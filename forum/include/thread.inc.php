<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
// End Required includes

function thread_get_title($tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT TITLE FROM `{$table_prefix}THREAD` WHERE TID = '$tid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($thread_title) = $result->fetch_row();

    return $thread_title;
}

function thread_get($tid, $inc_deleted = false, $inc_empty = false, $inc_unapproved = false)
{
    if (!$db = db::get()) return false;

    $fidlist = folder_get_available();

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($tid)) return false;

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql .= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql .= "THREAD.BY_UID, UNIX_TIMESTAMP(THREAD.CLOSED) AS CLOSED, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.ADMIN_LOCK) AS ADMIN_LOCK, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.CREATED) AS CREATED, THREAD.ADMIN_LOCK, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.STICKY_UNTIL) AS STICKY_UNTIL, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.APPROVED) AS APPROVED, THREAD.APPROVED_BY, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.UID, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "FOLDER.TITLE AS FOLDER_TITLE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.TID = '$tid' AND THREAD.FID IN ($fidlist) ";

    if ($inc_unapproved === false) $sql .= "AND THREAD.APPROVED IS NOT NULL ";

    if ($inc_deleted === false) $sql .= "AND THREAD.DELETED = 'N' ";

    if ($inc_empty === false) $sql .= "AND THREAD.LENGTH > 0 ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $thread_data = $result->fetch_assoc();

    if (!isset($thread_data['INTEREST'])) $thread_data['INTEREST'] = 0;

    if (!session::logged_in()) {

        $thread_data['LAST_READ'] = 0;

    } else if (!isset($thread_data['LAST_READ']) || !is_numeric($thread_data['LAST_READ'])) {

        $thread_data['LAST_READ'] = 0;

        if (isset($thread_data['MODIFIED']) && $unread_cutoff_timestamp !== false && $thread_data['MODIFIED'] < $unread_cutoff_timestamp) {
            $thread_data['LAST_READ'] = $thread_data['LENGTH'];
        } else if (isset($thread_data['UNREAD_PID']) && is_numeric($thread_data['UNREAD_PID'])) {
            $thread_data['LAST_READ'] = $thread_data['UNREAD_PID'];
        }
    }

    if (!isset($thread_data['STICKY_UNTIL'])) {
        $thread_data['STICKY_UNTIL'] = 0;
    }

    if (!isset($thread_data['ADMIN_LOCK'])) {
        $thread_data['ADMIN_LOCK'] = 0;
    }

    if (!isset($thread_data['CLOSED'])) {
        $thread_data['CLOSED'] = 0;
    }

    if (!isset($thread_data['DELETED'])) {
        $thread_data['DELETED'] = 'N';
    }

    if (isset($thread_data['LOGON']) && isset($thread_data['PEER_NICKNAME'])) {
        if (!is_null($thread_data['PEER_NICKNAME']) && strlen($thread_data['PEER_NICKNAME']) > 0) {
            $thread_data['NICKNAME'] = $thread_data['PEER_NICKNAME'];
        }
    }

    if (!isset($thread_data['LOGON'])) $thread_data['LOGON'] = gettext("Unknown user");
    if (!isset($thread_data['NICKNAME'])) $thread_data['NICKNAME'] = "";

    $thread_data['ATTACHMENT_COUNT'] = thread_get_attachment_count($tid);

    return $thread_data;
}

function thread_get_by_uid($tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return "";

    if (!is_numeric($tid)) return false;

    $sql = "SELECT BY_UID FROM `{$table_prefix}THREAD` ";
    $sql .= "WHERE TID = '$tid'";

    if (!($result = $db->query($sql))) return false;

    list($by_uid) = $result->fetch_row();

    return $by_uid;
}

function thread_get_folder($tid, $thread_count = true)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.POSITION, FOLDER.PREFIX, ";
    $sql .= "FOLDER.ALLOWED_TYPES, FOLDER.PERM, USER_FOLDER.INTEREST FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON (USER_FOLDER.FID = FOLDER.FID ";
    $sql .= "AND USER_FOLDER.UID = '{$_SESSION['UID']}') WHERE THREAD.TID = '$tid' ";
    $sql .= "GROUP BY FOLDER.FID, FOLDER.TITLE";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $folder_data = $result->fetch_assoc();

    if ($thread_count) {
        $folder_data['THREAD_COUNT'] = folder_get_thread_count($folder_data['FID']);
    }

    return $folder_data;
}

function thread_get_folder_fid($tid)
{
    if (!($folder_data = thread_get_folder($tid, false))) {
        return false;
    }

    return $folder_data['FID'];
}

function thread_get_length($tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT LENGTH FROM `{$table_prefix}THREAD` WHERE TID = '$tid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $thread_data = $result->fetch_assoc();

    return isset($thread_data['LENGTH']) ? $thread_data['LENGTH'] : 0;
}

function thread_get_tracking_data($tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT * FROM (SELECT TID, NEW_TID, TRACK_TYPE ";
    $sql .= "FROM `{$table_prefix}THREAD_TRACK` ";
    $sql .= "WHERE TID = '$tid') AS TRACK_FROM, (SELECT TID, ";
    $sql .= "NEW_TID, TRACK_TYPE FROM `{$table_prefix}THREAD_TRACK` ";
    $sql .= "WHERE NEW_TID = '$tid') AS TRACK_TO";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $tracking_data_array = array();

    while (($tracking_data = $result->fetch_assoc()) !== null) {
        $tracking_data_array[] = $tracking_data;
    }

    return $tracking_data_array;
}

function thread_set_length($tid, $length)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($length)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET LENGTH = '$length', ";
    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
    $sql .= "WHERE TID = '$tid'";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_set_moved($old_tid, $new_tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_prefix}THREAD_TRACK` (TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql .= "VALUES ('$old_tid', '$new_tid', CAST('$current_datetime' AS DATETIME), 0)";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_set_split($old_tid, $new_tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_prefix}THREAD_TRACK` (TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql .= "VALUES ('$old_tid', '$new_tid', CAST('$current_datetime' AS DATETIME), 1)";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_get_interest($tid)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT INTEREST FROM `{$table_prefix}USER_THREAD` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND TID = '$tid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($thread_interest) = $result->fetch_row();

    return $thread_interest;
}

function thread_set_interest($tid, $interest)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($tid)) return false;

    if (!is_numeric($interest)) return false;

    $thread_interest_array = array(
        THREAD_IGNORED,
        THREAD_NOINTEREST,
        THREAD_INTERESTED,
        THREAD_SUBSCRIBED
    );

    if (!in_array($interest, $thread_interest_array)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, INTEREST) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', '$tid', '$interest') ON DUPLICATE KEY ";
    $sql .= "UPDATE INTEREST = VALUES(INTEREST)";

    if (!$db->query($sql)) return false;

    return true;
}

// Same as thread_set_interest but this one won't
// change the interest of a thread unless it is 'normal'
function thread_set_high_interest($tid)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($tid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $thread_interested = THREAD_INTERESTED;

    $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, INTEREST) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', '$tid', '$thread_interested') ON DUPLICATE KEY ";
    $sql .= "UPDATE INTEREST = VALUES(INTEREST)";

    if (!($result = $db->query($sql))) return false;

    return $result;
}

function thread_set_sticky($tid, $sticky = true, $sticky_until = false)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $sticky_sql = ($sticky === true) ? 'Y' : 'N';

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    if (is_numeric($sticky_until) && $sticky_until !== false) {

        $sticky_until_datetime = date(MYSQL_DATETIME_MIDNIGHT, $sticky_until);

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET STICKY = '$sticky_sql', ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)), ";
        $sql .= "STICKY_UNTIL = CAST('$sticky_until_datetime' AS DATETIME) ";
        $sql .= "WHERE TID = '$tid'";

    } else {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET STICKY = '$sticky_sql', ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)), ";
        $sql .= "STICKY_UNTIL = NULL WHERE TID = '$tid'";
    }

    if (!$db->query($sql)) return false;

    return true;
}

function thread_set_closed($tid, $closed = true)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    if ($closed === true) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET CLOSED = CAST('$current_datetime' AS DATETIME), ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
        $sql .= "WHERE TID = '$tid'";

    } else {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET CLOSED = NULL, ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
        $sql .= "WHERE TID = '$tid'";
    }

    if (!$db->query($sql)) return false;

    return true;
}

function thread_admin_lock($tid, $locked = true)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    if ($locked === true) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` ";
        $sql .= "SET ADMIN_LOCK = CAST('$current_datetime' AS DATETIME), ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) WHERE TID = '$tid'";

    } else {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET ADMIN_LOCK = NULL, ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
        $sql .= "WHERE TID = '$tid'";
    }

    if (!$db->query($sql)) return false;

    return true;
}

function thread_change_folder($tid, $new_fid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($new_fid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET FID = '$new_fid', ";
    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
    $sql .= "WHERE TID = '$tid'";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_change_title($tid, $new_title)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    $new_title = $db->escape($new_title);

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET TITLE = '$new_title', ";
    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
    $sql .= "WHERE TID = '$tid'";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_delete_by_user($tid, $uid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "INSERT INTO `{$table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql .= "SELECT TID, PID, NULL FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.FROM_UID = '$uid' AND POST.TID = '$tid'";
    $sql .= "ON DUPLICATE KEY UPDATE CONTENT = VALUES(CONTENT)";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_delete($tid, $delete_type)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($delete_type)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    if ($delete_type == THREAD_DELETE_PERMENANT) {

        $sql = "DELETE QUICK FROM `{$table_prefix}POST_CONTENT` WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;

        $sql = "DELETE QUICK FROM `{$table_prefix}POST` WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;

        $sql = "DELETE QUICK FROM `{$table_prefix}THREAD` WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;

        $sql = "DELETE QUICK FROM `{$table_prefix}USER_THREAD` WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;

    } else {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET DELETED = 'Y', ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
        $sql .= "WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function thread_undelete($tid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;

    if (!thread_can_be_undeleted($tid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET DELETED = 'N', ";
    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) ";
    $sql .= "WHERE TID = '$tid'";

    if (!$db->query($sql)) return false;

    return true;
}

function thread_merge($tida, $tidb, $merge_type, &$error_str)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tida)) return false;
    if (!is_numeric($tidb)) return false;

    if (!in_array($merge_type, array(THREAD_MERGE_BY_CREATED, THREAD_MERGE_START, THREAD_MERGE_END))) return false;

    if (!($table_prefix = get_table_prefix())) {
        return thread_merge_error(THREAD_MERGE_FORUM_ERROR, $error_str);
    }

    if (!($forum_fid = get_forum_fid())) {
        return thread_merge_error(THREAD_MERGE_FORUM_ERROR, $error_str);
    }

    // Get Thread A data
    if (!$threada = thread_get($tida)) {
        return thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);
    }

    // Get Thread B data
    if (!$threadb = thread_get($tidb)) {
        return thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);
    }

    // Check the threads aren't polls.
    if (($threada['POLL_FLAG'] == 'Y') || ($threadb['POLL_FLAG'] == 'Y')) {
        return thread_merge_error(THREAD_MERGE_POLL_ERROR, $error_str);
    }

    // Check thread A permissions
    if (!session::check_perm(USER_PERM_FOLDER_MODERATE, $threada['FID'])) {
        return thread_merge_error(THREAD_MERGE_PERMS_ERROR, $error_str);
    }

    // Check thread B permissions
    if (!session::check_perm(USER_PERM_FOLDER_MODERATE, $threada['FID'])) {
        return thread_merge_error(THREAD_MERGE_PERMS_ERROR, $error_str);
    }

    // Close thread A
    thread_set_closed($tida, true);

    // Close thread B
    thread_set_closed($tidb, true);

    // Create new thread. Mark it as deleted so user's cannot see it.
    if (!($new_tid = post_create_thread($threada['FID'], $threada['BY_UID'], $threada['TITLE'], 'N', 'N', true, true))) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_CREATE_ERROR, $error_str);
    }

    // Construct query to correctly sort the posts in the new thread.
    switch ($merge_type) {

        case THREAD_MERGE_BY_CREATED:

            $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, ";
            $sql .= "FROM_UID, CREATED, APPROVED, APPROVED_BY, ";
            $sql .= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID) ";
            $sql .= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, NULL, NOW(), ";
            $sql .= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
            $sql .= "PID FROM `{$table_prefix}POST` WHERE TID IN ('$tida', '$tidb') ";
            $sql .= "ORDER BY CREATED";
            break;

        case THREAD_MERGE_START:

            $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, ";
            $sql .= "FROM_UID, CREATED, APPROVED, APPROVED_BY, ";
            $sql .= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID) ";
            $sql .= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, NULL, NOW(), ";
            $sql .= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
            $sql .= "PID FROM `{$table_prefix}POST` WHERE TID IN ('$tida', '$tidb') ";
            $sql .= "ORDER BY TID = '$tidb', CREATED";
            break;

        case THREAD_MERGE_END:

            $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, ";
            $sql .= "FROM_UID, CREATED, APPROVED, APPROVED_BY, ";
            $sql .= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID) ";
            $sql .= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, NULL, NOW(), ";
            $sql .= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
            $sql .= "PID FROM `{$table_prefix}POST` WHERE TID IN ('$tida', '$tidb') ";
            $sql .= "ORDER BY TID = '$tida', CREATED";
            break;
    }

    // Execute the query to copy the posts.
    if (!isset($sql) || !$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Copy the recipients to the new posts.
    $sql = "INSERT INTO `{$table_prefix}POST_RECIPIENT` (TID, PID, TO_UID, VIEWED) ";
    $sql .= "SELECT POST.TID, POST.PID, POST_RECIPIENT.TO_UID, POST_RECIPIENT.VIEWED ";
    $sql .= "FROM `{$table_prefix}POST` POST LEFT JOIN `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT ";
    $sql .= "ON (POST_RECIPIENT.TID = POST.MOVED_TID AND POST_RECIPIENT.PID = POST.MOVED_PID) ";
    $sql .= "WHERE POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Copy the post contents to the new thread
    $sql = "INSERT INTO `{$table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql .= "SELECT POST.TID, POST.PID, POST_CONTENT.CONTENT FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN `{$table_prefix}POST_CONTENT` POST_CONTENT ";
    $sql .= "ON (POST_CONTENT.TID = POST.MOVED_TID AND POST_CONTENT.PID = POST.MOVED_PID) ";
    $sql .= "WHERE POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Insert the new Sphinx Search IDs.
    $sql = "INSERT INTO `{$table_prefix}POST_SEARCH_ID` (TID, PID) ";
    $sql .= "SELECT $new_tid, POST.PID FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Update the REPLY_TO_PIDs in the new thread
    $sql = "INSERT INTO `{$table_prefix}POST` (TID, PID, REPLY_TO_PID) ";
    $sql .= "SELECT TARGET_POST.TID, TARGET_POST.PID, SOURCE_POST.PID ";
    $sql .= "FROM `{$table_prefix}POST` TARGET_POST ";
    $sql .= "INNER JOIN `{$table_prefix}POST` SOURCE_POST ";
    $sql .= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql .= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql .= "WHERE TARGET_POST.TID = '$new_tid' ";
    $sql .= "ON DUPLICATE KEY UPDATE REPLY_TO_PID = VALUES(REPLY_TO_PID) ";

    if (!$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Link the attachments to the new thread.
    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql .= "SELECT $forum_fid, TARGET_POST.TID, TARGET_POST.PID, ";
    $sql .= "SOURCE_POST_ATTACHMENT_IDS.AID ";
    $sql .= "FROM `{$table_prefix}POST` TARGET_POST ";
    $sql .= "INNER JOIN `{$table_prefix}POST` SOURCE_POST ";
    $sql .= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql .= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql .= "INNER JOIN POST_ATTACHMENT_IDS SOURCE_POST_ATTACHMENT_IDS ";
    $sql .= "ON (SOURCE_POST_ATTACHMENT_IDS.TID = SOURCE_POST.TID ";
    $sql .= "AND SOURCE_POST_ATTACHMENT_IDS.PID = SOURCE_POST.PID) ";
    $sql .= "WHERE TARGET_POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Now we unset the MOVED_TID and MOVED_PIDs for the new thread
    // so the posts appear in the new thread.
    $sql = "UPDATE `{$table_prefix}POST` SET MOVED_TID = NULL, ";
    $sql .= "MOVED_PID = NULL WHERE TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Update the new thread length
    thread_set_length($new_tid, $threada['LENGTH'] + $threadb['LENGTH']);

    // Set the original threads as moved
    thread_set_moved($tida, $new_tid);

    thread_set_moved($tidb, $new_tid);

    // Update the new thread so it's closed if either
    // of it's source threads were originally closed.
    thread_set_closed($new_tid, ($threada['CLOSED'] > 0) | ($threadb['CLOSED'] > 0));

    // Undelete the thread.
    thread_undelete($new_tid);

    // Return the admin log data.
    return array(
        $tida,
        $threada['TITLE'],
        $tidb,
        $threadb['TITLE'],
        $new_tid,
        $threada['TITLE']
    );
}

function thread_merge_error($error_code, &$error_str)
{
    switch ($error_code) {

        case THREAD_MERGE_FORUM_ERROR:

            $error_str = gettext("Could not retrieve forum data");
            break;

        case THREAD_MERGE_FOLDER_ERROR:

            $error_str = gettext("Invalid Folder ID. Check that a folder with this ID exists!");
            break;

        case THREAD_MERGE_THREAD_ERROR:

            $error_str = gettext("Could not retrieve thread data from one or more threads");
            break;

        case THREAD_MERGE_POLL_ERROR:

            $error_str = gettext("One or more threads is a poll. You cannot merge polls");
            break;

        case THREAD_MERGE_PERMS_ERROR:

            $error_str = gettext("You are not permitted to merge the selected threads");
            break;

        case THREAD_MERGE_CREATE_ERROR:

            $error_str = gettext("Failed to create new thread for merge");
            break;

        case THREAD_MERGE_QUERY_ERROR:

            $error_str = gettext("Failed to execute thread merge query");
            break;

        default:

            $error_str = "";
            break;
    }

    return false;
}

function thread_split($tid, $spid, $split_type, &$error_str)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($spid)) return false;

    if (!in_array($split_type, array(THREAD_SPLIT_REPLIES, THREAD_SPLIT_FOLLOWING))) return false;

    if (!($table_prefix = get_table_prefix())) {
        return thread_split_error(THREAD_SPLIT_FORUM_ERROR, $error_str);
    }

    if (!($thread_data = thread_get($tid))) {
        return thread_split_error(THREAD_SPLIT_THREAD_ERROR, $error_str);
    }

    if (!($forum_fid = get_forum_fid())) {
        return thread_split_error(THREAD_SPLIT_THREAD_ERROR, $error_str);
    }

    if (!is_numeric($spid) || ($spid < 2) || ($spid > $thread_data['LENGTH'])) {
        return thread_split_error(THREAD_SPLIT_INVALID_ARGS, $error_str);
    }

    if (!is_numeric($split_type)) {
        return thread_split_error(THREAD_SPLIT_INVALID_ARGS, $error_str);
    }

    thread_set_closed($tid, true);

    $pid_array = array();

    switch ($split_type) {

        case THREAD_SPLIT_REPLIES:

            $pid_array = thread_split_get_replies($tid, $spid);
            break;

        case THREAD_SPLIT_FOLLOWING:

            $pid_array = thread_split_get_following($tid, $spid);
            break;
    }

    if (!is_array($pid_array) || sizeof($pid_array) < 1) {

        thread_split_error(THREAD_SPLIT_POST_ERROR, $error_str);
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));
        return false;
    }

    if (!($new_tid = post_create_thread($thread_data['FID'], $thread_data['BY_UID'], $thread_data['TITLE'], 'N', 'N', true))) {

        thread_split_error(THREAD_SPLIT_CREATE_ERROR, $error_str);
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));
        return false;
    }

    if (!($thread_new = thread_get($new_tid, false, true))) {

        thread_split_error(THREAD_SPLIT_CREATE_ERROR, $error_str);
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));
        return false;
    }

    $pid_list = implode(',', $pid_array);

    $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, ";
    $sql .= "FROM_UID, CREATED, APPROVED, APPROVED_BY, EDITED, EDITED_BY, ";
    $sql .= "IPADDRESS, MOVED_TID, MOVED_PID) SELECT '$new_tid', REPLY_TO_PID, ";
    $sql .= "FROM_UID, NOW(), APPROVED, APPROVED_BY, EDITED, EDITED_BY, ";
    $sql .= "IPADDRESS, TID, PID FROM `{$table_prefix}POST` WHERE TID = $tid ";
    $sql .= "AND PID IN ($pid_list) ORDER BY CREATED";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Copy the recipients to the new thread
    $sql = "INSERT INTO `{$table_prefix}POST_RECIPIENT` (TID, PID, TO_UID, VIEWED) ";
    $sql .= "SELECT POST.TID, POST.PID, POST_RECIPIENT.TO_UID, NULL FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT ";
    $sql .= "ON (POST_RECIPIENT.TID = POST.MOVED_TID AND POST_RECIPIENT.PID = MOVED_PID) ";
    $sql .= "WHERE POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Copy the post contents to the new thread
    $sql = "INSERT INTO `{$table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql .= "SELECT POST.TID, POST.PID, POST_CONTENT.CONTENT FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN `{$table_prefix}POST_CONTENT` POST_CONTENT ";
    $sql .= "ON (POST_CONTENT.TID = POST.MOVED_TID AND POST_CONTENT.PID = MOVED_PID) ";
    $sql .= "WHERE POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Insert the new Sphinx Search IDs.
    $sql = "INSERT INTO `{$table_prefix}POST_SEARCH_ID` (TID, PID) ";
    $sql .= "SELECT $new_tid, POST.PID FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Update the REPLY_TO_PIDs in the new thread
    $sql = "INSERT INTO `{$table_prefix}POST` (TID, PID, REPLY_TO_PID) ";
    $sql .= "SELECT TARGET_POST.TID, TARGET_POST.PID, SOURCE_POST.PID ";
    $sql .= "FROM `{$table_prefix}POST` TARGET_POST ";
    $sql .= "INNER JOIN `{$table_prefix}POST` SOURCE_POST ";
    $sql .= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql .= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql .= "WHERE TARGET_POST.TID = '$new_tid' AND TARGET_POST.PID > 1 ";
    $sql .= "ON DUPLICATE KEY UPDATE REPLY_TO_PID = VALUES(REPLY_TO_PID) ";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Remove the first post in the thread's REPLY_TO_PID
    $sql = "UPDATE `{$table_prefix}POST` POST SET REPLY_TO_PID = NULL ";
    $sql .= "WHERE POST.TID = '$new_tid' AND POST.PID = 1";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Update the old thread's post MOVED_TID and MOVED_PID
    $sql = "INSERT INTO `{$table_prefix}POST` (TID, PID, MOVED_TID, MOVED_PID) ";
    $sql .= "SELECT $tid, MOVED_PID, $new_tid, PID FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.TID = $new_tid ON DUPLICATE KEY UPDATE MOVED_TID = VALUES(MOVED_TID), ";
    $sql .= "MOVED_PID = VALUES(MOVED_PID)";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Link the attachments to the new thread.
    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql .= "SELECT $forum_fid, TARGET_POST.TID, TARGET_POST.PID, ";
    $sql .= "SOURCE_POST_ATTACHMENT_IDS.AID ";
    $sql .= "FROM `{$table_prefix}POST` TARGET_POST ";
    $sql .= "INNER JOIN `{$table_prefix}POST` SOURCE_POST ";
    $sql .= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql .= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql .= "INNER JOIN POST_ATTACHMENT_IDS SOURCE_POST_ATTACHMENT_IDS ";
    $sql .= "ON (SOURCE_POST_ATTACHMENT_IDS.TID = SOURCE_POST.TID ";
    $sql .= "AND SOURCE_POST_ATTACHMENT_IDS.PID = SOURCE_POST.PID) ";
    $sql .= "WHERE TARGET_POST.TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Now we unset the MOVED_TID and MOVED_PIDs for the new thread
    // so the posts appear in the new thread.
    $sql = "UPDATE `{$table_prefix}POST` SET MOVED_TID = NULL, ";
    $sql .= "MOVED_PID = NULL WHERE TID = '$new_tid'";

    if (!$db->query($sql)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    thread_set_split($tid, $new_tid);

    thread_set_length($new_tid, sizeof($pid_array));

    thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

    thread_set_closed($new_tid, ($thread_data['CLOSED'] > 0));

    return array(
        $tid,
        $spid,
        $new_tid,
        $thread_new['TITLE']
    );
}

function thread_split_error($error_code, &$error_str)
{
    switch ($error_code) {

        case THREAD_SPLIT_INVALID_ARGS:

            $error_str = gettext("Invalid function arguments");
            break;

        case THREAD_SPLIT_FORUM_ERROR:

            $error_str = gettext("Could not retrieve forum data");
            break;

        case THREAD_SPLIT_THREAD_ERROR:

            $error_str = gettext("Could not retrieve thread data from source thread");
            break;

        case THREAD_SPLIT_POST_ERROR :

            $error_str = gettext("Could not retrieve post data from source thread");
            break;

        case THREAD_SPLIT_CREATE_ERROR:

            $error_str = gettext("Failed to create new thread for split");
            break;

        case THREAD_SPLIT_QUERY_ERROR:

            $error_str = gettext("Failed to execute thread merge query");
            break;

        default:

            $error_str = "";
            break;
    }

    return false;
}

function thread_split_get_replies($tid, $pid)
{
    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID ";
    $sql .= "FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.TID = '$tid' AND POST.PID >= '$pid' ";
    $sql .= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";
    $sql .= "ORDER BY POST.CREATED";

    $pid_array = array(
        $pid
    );

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($post_data = $result->fetch_assoc()) !== null) {

        if (in_array($post_data['REPLY_TO_PID'], $pid_array)) {
            $pid_array[] = $post_data['PID'];
        }
    }

    return $pid_array;
}

function thread_split_get_following($tid, $pid)
{
    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID ";
    $sql .= "FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.TID = '$tid' AND POST.PID >= '$pid' ";
    $sql .= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";
    $sql .= "ORDER BY POST.CREATED";

    $pid_array = array();

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($post_data = $result->fetch_assoc()) !== null) {
        $pid_array[] = $post_data['PID'];
    }

    return $pid_array;
}

function thread_get_unmoved_posts($tid)
{
    if (!is_numeric($tid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT PID FROM `{$table_prefix}POST` ";
    $sql .= "WHERE TID = '$tid' AND MOVED_TID IS NULL ";
    $sql .= "AND MOVED_PID IS NULL AND PID > 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $thread_unmoved_posts_array = array();

    while (($thread_data = $result->fetch_assoc()) !== null) {
        $thread_unmoved_posts_array[$thread_data['PID']] = $thread_data['PID'];
    }

    return $thread_unmoved_posts_array;
}

function thread_can_be_undeleted($tid)
{
    if (!is_numeric($tid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT MAX(PID) AS LENGTH FROM ";
    $sql .= "`{$table_prefix}POST` WHERE TID = '$tid'";

    if (!($result = $db->query($sql))) return false;

    list($length) = $result->fetch_row();

    return ($length > 0);
}

function thread_search($thread_search, $selected_array = array())
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $results_array = array();

    $fidlist = folder_get_available();

    $thread_search = $db->escape(str_replace("%", "", $thread_search));

    $selected_array = array_filter($selected_array, 'is_numeric');

    $sql = "SELECT DISTINCT THREAD.TID, TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) WHERE THREAD.TITLE LIKE '$thread_search%' ";
    $sql .= "AND THREAD.FID IN ($fidlist) ";

    if (sizeof($selected_array) > 0) {

        $selected = implode(', ', $selected_array);
        $sql .= "AND THREAD.TID NOT IN ($selected) ";
    }

    $sql .= "LIMIT 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($results_count) = $result_count->fetch_row();

    if ($result->num_rows == 0) return false;

    while (($thread_data = $result->fetch_assoc()) !== null) {
        $results_array[$thread_data['TID']] = $thread_data;
    }

    return array(
        'results_count' => $results_count,
        'results_array' => $results_array
    );
}

function thread_get_last_page_pid($length, $posts_per_page)
{
    if (!isset($_SESSION['THREAD_LAST_PAGE']) || ($_SESSION['THREAD_LAST_PAGE'] == 'N')) {
        return $length;
    }

    $last_page_pid = $length - ($length % $posts_per_page);
    return ($last_page_pid > 1) ? $last_page_pid : 1;
}

function thread_get_attachment_count($tid)
{
    if (!($forum_fid = get_forum_fid())) return false;

    if (!isset($tid)) return false;

    if (!is_numeric($tid)) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT PAI.TID, COUNT(PAF.HASH) AS ATTACHMENT_COUNT ";
    $sql .= "FROM POST_ATTACHMENT_IDS PAI INNER JOIN POST_ATTACHMENT_FILES PAF ";
    $sql .= "ON (PAF.AID = PAI.AID) WHERE PAI.FID = '$forum_fid' ";
    $sql .= "AND PAI.TID = '{$tid}' GROUP BY PAI.TID";

    if (!($result = $db->query($sql))) return false;

    $attachment_data = $result->fetch_assoc();

    if (isset($attachment_data['ATTACHMENT_COUNT'])) {
        return $attachment_data['ATTACHMENT_COUNT'];
    }

    return 0;
}