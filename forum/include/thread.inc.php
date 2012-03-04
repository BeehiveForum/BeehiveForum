<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "sphinx.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

function thread_get_title($tid)
{
    if (!$db_thread_get_title = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT TITLE FROM `{$table_data['PREFIX']}THREAD` WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_get_title)) return false;

    if (db_num_rows($result) > 0) {

        list($thread_title) = db_fetch_array($result, DB_RESULT_NUM);
        return $thread_title;
    }

    return "The Unknown Thread";
}

function thread_get($tid, $inc_deleted = false, $inc_empty = false)
{
    if (!$db_thread_get = db_connect()) return false;

    $lang = load_language_file();

    $fidlist = folder_get_available();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, ";
    $sql.= "TRIM(CONCAT(FOLDER.PREFIX, ' ', THREAD.TITLE)) AS TITLE, ";
    $sql.= "THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "THREAD.BY_UID, UNIX_TIMESTAMP(THREAD.CLOSED) AS CLOSED, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.ADMIN_LOCK) AS ADMIN_LOCK, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.CREATED) AS CREATED, THREAD.ADMIN_LOCK, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.STICKY_UNTIL) AS STICKY_UNTIL, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.UID, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "FOLDER.TITLE AS FOLDER_TITLE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.TID = '$tid' AND THREAD.FID IN ($fidlist) ";

    if ($inc_deleted === false) $sql.= "AND THREAD.DELETED = 'N' ";

    if ($inc_empty === false)  $sql.= "AND THREAD.LENGTH > 0 ";

    if (!$result = db_query($sql, $db_thread_get)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);

        if (!isset($thread_data['INTEREST'])) $thread_data['INTEREST'] = 0;

        if (user_is_guest()) {

            $thread_data['LAST_READ'] = 0;

        }else if (!isset($thread_data['LAST_READ']) || !is_numeric($thread_data['LAST_READ'])) {

            $thread_data['LAST_READ'] = 0;

            if (isset($thread_data['MODIFIED']) && $unread_cutoff_timestamp !== false && $thread_data['MODIFIED'] < $unread_cutoff_timestamp) {
                $thread_data['LAST_READ'] = $thread_data['LENGTH'];
            }else if (isset($thread_data['UNREAD_PID']) && is_numeric($thread_data['UNREAD_PID'])) {
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

        if (!isset($thread_data['LOGON'])) $thread_data['LOGON'] = $lang['unknownuser'];
        if (!isset($thread_data['NICKNAME'])) $thread_data['NICKNAME'] = "";

        thread_has_attachments($thread_data);

        return $thread_data;
    }

    return false;
}

function thread_get_by_uid($tid)
{
    if (!$db_thread_get_author = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return "";

    if (!is_numeric($tid)) return false;

    $sql = "SELECT BY_UID FROM `{$table_data['PREFIX']}THREAD` ";
    $sql.= "WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_get_author)) return false;

    list($by_uid) = db_fetch_array($result, DB_RESULT_NUM);

    return $by_uid;
}

function thread_get_folder($tid)
{
    if (!$db_thread_get_folder = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT FID FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_get_folder)) return false;

    if (db_num_rows($result) > 0) {

        list($folder) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder;
    }

    return false;
}

function thread_get_length($tid)
{
    if (!$db_thread_get_length = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT LENGTH FROM `{$table_data['PREFIX']}THREAD` WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_get_length)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);
        return isset($thread_data['LENGTH']) ? $thread_data['LENGTH'] : 0;
    }

    return 0;
}

function thread_get_tracking_data($tid)
{
    if (!$db_thread_get_tracking_data = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $tracking_data_array = array();

    $sql = "SELECT * FROM (SELECT TID, NEW_TID, TRACK_TYPE ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD_TRACK` ";
    $sql.= "WHERE TID = '$tid') AS TRACK_FROM, (SELECT TID, ";
    $sql.= "NEW_TID, TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD_TRACK` ";
    $sql.= "WHERE NEW_TID = '$tid') AS TRACK_TO";

    if (!$result = db_query($sql, $db_thread_get_tracking_data)) return false;

    if (db_num_rows($result) > 0) {

        while (($tracking_data = db_fetch_array($result))) {
            $tracking_data_array[] = $tracking_data;
        }
    }

    return sizeof($tracking_data_array) > 0 ? $tracking_data_array : false;
}

function thread_set_length($tid, $length)
{
    if (!$db_thread_get_length = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($length)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` SET LENGTH = '$length', ";
    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_get_length)) return false;

    return true;
}

function thread_set_moved($old_tid, $new_tid)
{
    if (!$db_thread_set_moved = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}THREAD_TRACK` (TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql.= "VALUES ('$old_tid', '$new_tid', CAST('$current_datetime' AS DATETIME), 0)";

    if (!db_query($sql, $db_thread_set_moved)) return false;

    return true;
}

function thread_set_split($old_tid, $new_tid)
{
    if (!$db_thread_set_split = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}THREAD_TRACK` (TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql.= "VALUES ('$old_tid', '$new_tid', CAST('$current_datetime' AS DATETIME), 1)";

    if (!db_query($sql, $db_thread_set_split)) return false;

    return true;
}

function thread_get_interest($tid)
{
    if (($uid = session_get_value('UID')) === false) return false;

    if (!$db_thread_get_interest = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT INTEREST FROM `{$table_data['PREFIX']}USER_THREAD` ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_get_interest)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);
        return isset($thread_data['INTEREST']) ? $thread_data['INTEREST'] : 0;
    }

    return 0;
}

function thread_set_interest($tid, $interest)
{
    if (!$db_thread_set_interest = db_connect()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($interest)) return false;

    $thread_interest_array = array(THREAD_IGNORED, THREAD_NOINTEREST, THREAD_INTERESTED, THREAD_SUBSCRIBED);

    if (!in_array($interest, $thread_interest_array)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, INTEREST) ";
    $sql.= "VALUES ('$uid', '$tid', '$interest') ON DUPLICATE KEY ";
    $sql.= "UPDATE INTEREST = VALUES(INTEREST)";

    if (!db_query($sql, $db_thread_set_interest)) return false;

    return true;
}

// Same as thread_set_interest but this one won't
// change the interest of a thread unless it is 'normal'
function thread_set_high_interest($tid)
{
    if (!$db_thread_set_high_interest = db_connect()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $thread_interested = THREAD_INTERESTED;

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, INTEREST) ";
    $sql.= "VALUES ('$uid', '$tid', '$thread_interested') ON DUPLICATE KEY ";
    $sql.= "UPDATE INTEREST = VALUES(INTEREST)";

    if (!$result = db_query($sql, $db_thread_set_high_interest)) return false;

    return $result;
}

function thread_set_sticky($tid, $sticky = true, $sticky_until = false)
{
    if (!$db_thread_set_sticky = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sticky_sql = ($sticky === true) ? 'Y' : 'N';

    $current_datetime = date(MYSQL_DATETIME, time());

    if (is_numeric($sticky_until) && $sticky_until !== false) {

        $sticky_until_datetime = date(MYSQL_DATETIME_MIDNIGHT, $sticky_until);

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET STICKY = '$sticky_sql', MODIFIED = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "STICKY_UNTIL = CAST('$sticky_until_datetime' AS DATETIME) WHERE TID = '$tid'";

    }else {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET STICKY = '$sticky_sql', MODIFIED = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "STICKY_UNTIL = NULL WHERE TID = '$tid'";
    }

    if (!db_query($sql, $db_thread_set_sticky)) return false;

    return true;
}

function thread_set_closed($tid, $closed = true)
{
    if (!$db_thread_set_closed = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if ($closed === true) {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET CLOSED = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) ";
        $sql.= "WHERE TID = '$tid'";

    }else {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET CLOSED = NULL, MODIFIED = CAST('$current_datetime' AS DATETIME) ";
        $sql.= "WHERE TID = '$tid'";
    }

    if (!db_query($sql, $db_thread_set_closed)) return false;

    return true;
}

function thread_admin_lock($tid, $locked = true)
{
    if (!$db_thread_admin_lock = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if ($locked === true) {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET ADMIN_LOCK = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) ";
        $sql.= "WHERE TID = '$tid'";

    }else {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET ADMIN_LOCK = NULL, MODIFIED = CAST('$current_datetime' AS DATETIME) ";
        $sql.= "WHERE TID = '$tid'";
    }

    if (!db_query($sql, $db_thread_admin_lock)) return false;

    return true;
}

function thread_change_folder($tid, $new_fid)
{
    if (!$db_thread_set_closed = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($new_fid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
    $sql.= "SET FID = '$new_fid', MODIFIED = CAST('$current_datetime' AS DATETIME) ";
    $sql.= "WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_set_closed)) return false;

    sphinx_search_update_index($tid);

    return true;
}

function thread_change_title($tid, $new_title)
{
    if (!$db_thread_change_title = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $new_title = db_escape_string($new_title);

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
    $sql.= "SET TITLE = '$new_title', MODIFIED = CAST('$current_datetime' AS DATETIME) ";
    $sql.= "WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_change_title)) return false;

    sphinx_search_update_index($tid);

    return true;
}

function thread_delete_by_user($tid, $uid)
{
    if (!$db_thread_delete_by_user = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql.= "SELECT TID, PID, NULL FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "WHERE POST.FROM_UID = '$uid' AND POST.TID = '$tid'";
    $sql.= "ON DUPLICATE KEY UPDATE CONTENT = VALUES(CONTENT)";

    if (!db_query($sql, $db_thread_delete_by_user)) return false;

    return true;
}

function thread_delete($tid, $delete_type)
{
    if (!$db_thread_delete = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($delete_type)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if ($delete_type == THREAD_DELETE_PERMENANT) {

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}POST_CONTENT` WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}POST` WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}THREAD` WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}USER_THREAD` WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

    }else {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` ";
        $sql.= "SET DELETED = 'Y', MODIFIED = CAST('$current_datetime' AS DATETIME) ";
        $sql.= "WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;
    }

    return true;
}

function thread_undelete($tid)
{
    if (!$db_thread_undelete = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    if (!thread_can_be_undeleted($tid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}THREAD` SET DELETED = 'N', ";
    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_undelete)) return false;

    return true;
}

function thread_merge($tida, $tidb, $merge_type, &$error_str)
{
    if (!$db_thread_merge = db_connect()) return false;

    if (!is_numeric($tida)) return false;
    if (!is_numeric($tidb)) return false;
    
    if (!in_array($merge_type, array(THREAD_MERGE_BY_CREATED, THREAD_MERGE_START, THREAD_MERGE_END))) return false;
    
    // Get Forum Data
    if (!$table_data = get_table_prefix()) {
        return thread_merge_error(THREAD_MERGE_FORUM_ERROR, $error_str);
    }

    // Forum FID
    $forum_fid = $table_data['FID'];

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
    if (!session_check_perm(USER_PERM_FOLDER_MODERATE, $threada['FID'])) {
        return thread_merge_error(THREAD_MERGE_PERMS_ERROR, $error_str);
    }                            

    // Check thread B permissions
    if (!session_check_perm(USER_PERM_FOLDER_MODERATE, $threada['FID'])) {
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

    $sql = "SELECT COUNT(*), MAX(PID) + 1 FROM `{$table_data['PREFIX']}POST` ";
    $sql.= "WHERE TID IN ('$tida', '$tidb') ";

    if (!$result = db_query($sql, $db_thread_merge)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    list($post_count, $max_pid) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO SPHINX_SEARCH_ID (SEARCH_ID) VALUES ";
    $sql.= implode(', ', array_fill(1, $post_count, '(NULL)'));

    if (!$result = db_query($sql, $db_thread_merge)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    $search_id = db_insert_id($db_thread_merge);

    // Construct query to correctly sort the posts in the new thread.
    switch ($merge_type) {

        case THREAD_MERGE_BY_CREATED:

            $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, REPLY_TO_PID, ";
            $sql.= "FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, APPROVED_BY, ";
            $sql.= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID, SEARCH_ID) ";
            $sql.= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, TO_UID, NULL, NOW(), ";
            $sql.= "STATUS, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
            $sql.= "PID, $search_id + (PID - ($max_pid - $post_count)) AS SEARCH_ID ";
            $sql.= "FROM `{$table_data['PREFIX']}POST` WHERE TID IN ('$tida', '$tidb') ";
            $sql.= "ORDER BY CREATED";
            break;

        case THREAD_MERGE_START:

            $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, REPLY_TO_PID, ";
            $sql.= "FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, APPROVED_BY, ";
            $sql.= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID, SEARCH_ID) ";
            $sql.= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, TO_UID, NULL, NOW(), ";
            $sql.= "STATUS, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
            $sql.= "PID, $search_id + (PID - ($max_pid - $post_count)) AS SEARCH_ID ";
            $sql.= "FROM `{$table_data['PREFIX']}POST` WHERE TID IN ('$tida', '$tidb') ";
            $sql.= "ORDER BY TID = '$tidb', CREATED";
            break;

        case THREAD_MERGE_END:

            $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, REPLY_TO_PID, ";
            $sql.= "FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, APPROVED_BY, ";
            $sql.= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID, SEARCH_ID) ";
            $sql.= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, TO_UID, NULL, NOW(), ";
            $sql.= "STATUS, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
            $sql.= "PID, $search_id + (PID - ($max_pid - $post_count)) AS SEARCH_ID ";
            $sql.= "FROM `{$table_data['PREFIX']}POST` WHERE TID IN ('$tida', '$tidb') ";
            $sql.= "ORDER BY TID = '$tida', CREATED";
            break;
    }

    // Execute the query to copy the posts.
    if (!db_query($sql, $db_thread_merge)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Copy the post contents to the new thread
    $sql = "INSERT INTO `{$table_data['PREFIX']}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql.= "SELECT POST.TID, POST.PID, POST_CONTENT.CONTENT FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST_CONTENT` POST_CONTENT ";
    $sql.= "ON (POST_CONTENT.TID = POST.MOVED_TID AND POST_CONTENT.PID = MOVED_PID) ";
    $sql.= "WHERE POST.TID = '$new_tid'";

    if (!db_query($sql, $db_thread_merge)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Update the REPLY_TO_PIDs in the new thread
    $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, PID, REPLY_TO_PID) ";
    $sql.= "SELECT TARGET_POST.TID, TARGET_POST.PID, SOURCE_POST.PID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` TARGET_POST ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POST` SOURCE_POST ";
    $sql.= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql.= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql.= "WHERE TARGET_POST.TID = '$new_tid' ";
    $sql.= "ON DUPLICATE KEY UPDATE REPLY_TO_PID = VALUES(REPLY_TO_PID) ";

    if (!db_query($sql, $db_thread_merge)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Link the attachments to the new thread.
    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql.= "SELECT $forum_fid, TARGET_POST.TID, TARGET_POST.PID, ";
    $sql.= "SOURCE_POST_ATTACHMENT_IDS.AID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` TARGET_POST ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POST` SOURCE_POST ";
    $sql.= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql.= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql.= "INNER JOIN POST_ATTACHMENT_IDS SOURCE_POST_ATTACHMENT_IDS ";
    $sql.= "ON (SOURCE_POST_ATTACHMENT_IDS.TID = SOURCE_POST.TID ";
    $sql.= "AND SOURCE_POST_ATTACHMENT_IDS.PID = SOURCE_POST.PID) ";
    $sql.= "WHERE TARGET_POST.TID = '$new_tid'";

    if (!db_query($sql, $db_thread_merge)) {

        // Unlock the threads if they weren't originally locked.
        thread_set_closed($tida, ($threada['CLOSED'] > 0));
        thread_set_closed($tidb, ($threadb['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_MERGE_QUERY_ERROR, $error_str);
    }

    // Now we unset the MOVED_TID and MOVED_PIDs for the new thread
    // so the posts appear in the new thread.
    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET MOVED_TID = NULL, ";
    $sql.= "MOVED_PID = NULL WHERE TID = '$new_tid'";

    if (!db_query($sql, $db_thread_merge)) {

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

    // Index our new thread with Sphinx
    sphinx_search_update_index($new_tid);

    // Return the admin log data.
    return array($tida, $threada['TITLE'], $tidb, $threadb['TITLE'], $new_tid, $threada['TITLE']);
}

function thread_merge_error($error_code, &$error_str)
{
    $lang = load_language_file();

    switch ($error_code) {

        case THREAD_MERGE_FORUM_ERROR:

            $error_str = $lang['couldnotretrieveforumdata'];
            break;

        case THREAD_MERGE_FOLDER_ERROR:

            $error_str = $lang['invalidfolderid'];
            break;

        case THREAD_MERGE_THREAD_ERROR:

            $error_str = $lang['couldnotretrievethreaddatamerge'];
            break;

        case THREAD_MERGE_POLL_ERROR:

            $error_str = $lang['cannotmergepolls'];
            break;

        case THREAD_MERGE_PERMS_ERROR:

            $error_str = $lang['nopermissiontomergethreads'];
            break;

        case THREAD_MERGE_CREATE_ERROR:

            $error_str = $lang['failedtocreatenewthreadformerge'];
            break;

        case THREAD_MERGE_QUERY_ERROR:

            $error_str = $lang['failedtoexecutethreadmergequery'];
            break;

        default:

            $error_str = "";
            break;
    }

    return false;
}

function thread_split($tid, $spid, $split_type, &$error_str)
{
    if (!$db_thread_split = db_connect()) return false;
    
    if (!is_numeric($tid)) return false;
    if (!is_numeric($spid)) return false;
    
    if (!in_array($split_type, array(THREAD_SPLIT_REPLIES, THREAD_SPLIT_FOLLOWING))) return false;

    if (!$table_data = get_table_prefix()) {
        return thread_split_error(THREAD_SPLIT_FORUM_ERROR, $error_str);
    }

    if (!($thread_data = thread_get($tid))) {
        return thread_split_error(THREAD_SPLIT_THREAD_ERROR, $error_str);
    }

    $forum_fid = $table_data['FID'];

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

            $pid_array = thread_split_get_replies($tid, $spid, $pid_array);
            break;

        case THREAD_SPLIT_FOLLOWING:

            $pid_array = thread_split_get_following($tid, $spid, $pid_array);
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

    if (!($thread_new = thread_get($new_tid, true, true))) {

        thread_split_error(THREAD_SPLIT_CREATE_ERROR, $error_str);
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));
        return false;
    }

    $pid_list = implode(',', $pid_array);

    $sql = "SELECT COUNT(*), MAX(PID) + 1 FROM `{$table_data['PREFIX']}POST` ";
    $sql.= "WHERE TID = $tid AND PID IN ($pid_list)";

    if (!$result = db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    list($post_count, $max_pid) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO SPHINX_SEARCH_ID (SEARCH_ID) VALUES ";
    $sql.= implode(', ', array_fill(0, $post_count, '(NULL)'));
    
    if (!$result = db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    $search_id = db_insert_id($db_thread_split);
    
    $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, REPLY_TO_PID, ";
    $sql.= "FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, APPROVED_BY, ";
    $sql.= "EDITED, EDITED_BY, IPADDRESS, MOVED_TID, MOVED_PID, SEARCH_ID) ";
    $sql.= "SELECT '$new_tid', REPLY_TO_PID, FROM_UID, TO_UID, NULL, NOW(), ";
    $sql.= "STATUS, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS, TID, ";
    $sql.= "PID, $search_id + (PID - ($max_pid - $post_count)) AS SEARCH_ID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` WHERE TID = $tid ";
    $sql.= "AND PID IN ($pid_list) ORDER BY CREATED";

    if (!$result = db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Copy the post contents to the new thread
    $sql = "INSERT INTO `{$table_data['PREFIX']}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql.= "SELECT POST.TID, POST.PID, POST_CONTENT.CONTENT FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST_CONTENT` POST_CONTENT ";
    $sql.= "ON (POST_CONTENT.TID = POST.MOVED_TID AND POST_CONTENT.PID = MOVED_PID) ";
    $sql.= "WHERE POST.TID = '$new_tid'";

    if (!db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_split_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Update the REPLY_TO_PIDs in the new thread
    $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, PID, REPLY_TO_PID) ";
    $sql.= "SELECT TARGET_POST.TID, TARGET_POST.PID, SOURCE_POST.PID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` TARGET_POST ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POST` SOURCE_POST ";
    $sql.= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql.= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql.= "WHERE TARGET_POST.TID = '$new_tid' AND TARGET_POST.PID > 1 ";
    $sql.= "ON DUPLICATE KEY UPDATE REPLY_TO_PID = VALUES(REPLY_TO_PID) ";

    if (!db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Remove the first post in the thread's REPLY_TO_PID
    $sql = "UPDATE `{$table_data['PREFIX']}POST` POST SET REPLY_TO_PID = NULL ";
    $sql.= "WHERE POST.TID = '$new_tid' AND POST.PID = 1";

    if (!db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Update the old thread's post MOVED_TID and MOVED_PID
    $sql = "INSERT INTO `{$table_data['PREFIX']}POST` (TID, PID, MOVED_TID, MOVED_PID) ";
    $sql.= "SELECT $tid, MOVED_PID, $new_tid, PID FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "WHERE POST.TID = $new_tid ON DUPLICATE KEY UPDATE MOVED_TID = VALUES(MOVED_TID), ";
    $sql.= "MOVED_PID = VALUES(MOVED_PID)";

    if (!db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Link the attachments to the new thread.
    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql.= "SELECT $forum_fid, TARGET_POST.TID, TARGET_POST.PID, ";
    $sql.= "SOURCE_POST_ATTACHMENT_IDS.AID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` TARGET_POST ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POST` SOURCE_POST ";
    $sql.= "ON (SOURCE_POST.MOVED_TID = TARGET_POST.MOVED_TID ";
    $sql.= "AND TARGET_POST.REPLY_TO_PID = SOURCE_POST.MOVED_PID) ";
    $sql.= "INNER JOIN POST_ATTACHMENT_IDS SOURCE_POST_ATTACHMENT_IDS ";
    $sql.= "ON (SOURCE_POST_ATTACHMENT_IDS.TID = SOURCE_POST.TID ";
    $sql.= "AND SOURCE_POST_ATTACHMENT_IDS.PID = SOURCE_POST.PID) ";
    $sql.= "WHERE TARGET_POST.TID = '$new_tid'";

    if (!db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    // Now we unset the MOVED_TID and MOVED_PIDs for the new thread
    // so the posts appear in the new thread.
    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET MOVED_TID = NULL, ";
    $sql.= "MOVED_PID = NULL WHERE TID = '$new_tid'";

    if (!db_query($sql, $db_thread_split)) {

        // Unlock the original thread if it wasn't originally locked.
        thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

        // Return error message.
        return thread_merge_error(THREAD_SPLIT_QUERY_ERROR, $error_str);
    }

    thread_set_split($tid, $new_tid);

    thread_set_length($new_tid, sizeof($pid_array));

    thread_set_closed($tid, ($thread_data['CLOSED'] > 0));

    thread_set_closed($new_tid, ($thread_data['CLOSED'] > 0));

    sphinx_search_update_index($new_tid);

    return array($tid, $spid, $new_tid, $thread_new['TITLE']);
}

function thread_split_error($error_code, &$error_str)
{
    $lang = load_language_file();

    switch ($error_code) {

        case THREAD_SPLIT_INVALID_ARGS:

            $error_str = $lang['invalidfunctionarguments'];
            break;

        case THREAD_SPLIT_FORUM_ERROR:

            $error_str = $lang['couldnotretrieveforumdata'];
            break;

        case THREAD_SPLIT_THREAD_ERROR:

            $error_str = $lang['couldnotretrievethreaddatasplit'];
            break;

        case THREAD_SPLIT_POST_ERROR :

            $error_str = $lang['couldnotretrievepostdatasplit'];
            break;

        case THREAD_SPLIT_CREATE_ERROR:

            $error_str = $lang['failedtocreatenewthreadforsplit'];
            break;

        case THREAD_SPLIT_QUERY_ERROR:

            $error_str = $lang['failedtoexecutethreadmergequery'];
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

    if (!$table_data = get_table_prefix()) return false;

    if (!$db_thread_split_recursive = db_connect()) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID >= '$pid' ";
    $sql.= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";
    $sql.= "ORDER BY POST.CREATED";

    $pid_array = array($pid);

    if (!$result = db_query($sql, $db_thread_split_recursive)) return false;

    if (db_num_rows($result) > 0) {

        while (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (in_array($post_data['REPLY_TO_PID'], $pid_array)) {

                $pid_array[] = $post_data['PID'];
            }
        }

        return $pid_array;
    }

    return false;
}

function thread_split_get_following($tid, $pid)
{
    if (!is_numeric($tid)) return false;

    if (!is_numeric($pid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$db_thread_split_recursive = db_connect()) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID >= '$pid' ";
    $sql.= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";
    $sql.= "ORDER BY POST.CREATED";

    $pid_array = array();

    if (!$result = db_query($sql, $db_thread_split_recursive)) return false;

    if (db_num_rows($result) > 0) {

        while (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {
            $pid_array[] = $post_data['PID'];
        }

        return $pid_array;
    }

    return false;
}

function thread_get_unmoved_posts($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$db_thread_get_unmoved_posts = db_connect()) return false;

    $sql = "SELECT PID FROM `{$table_data['PREFIX']}POST` ";
    $sql.= "WHERE TID = '$tid' AND MOVED_TID IS NULL ";
    $sql.= "AND MOVED_PID IS NULL AND PID > 1";

    if (!$result = db_query($sql, $db_thread_get_unmoved_posts)) return false;

    if (db_num_rows($result) > 0) {

        $thread_unmoved_posts_array = array();

        while (($thread_data = db_fetch_array($result))) {

            $thread_unmoved_posts_array[$thread_data['PID']] = $thread_data['PID'];
        }

        return $thread_unmoved_posts_array;
    }

    return false;
}

function thread_can_be_undeleted($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$db_thread_can_be_undeleted = db_connect()) return false;

    $sql = "SELECT MAX(PID) AS LENGTH FROM ";
    $sql.= "`{$table_data['PREFIX']}POST` WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_can_be_undeleted)) return false;

    list($length) = db_fetch_array($result, DB_RESULT_NUM);

    return ($length > 0);
}

function thread_search($thread_search, $selected_array = array())
{
    if (!$db_thread_search = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $results_array = array();

    $fidlist = folder_get_available();

    $thread_search = db_escape_string(str_replace("%", "", $thread_search));

    $selected_array = array_filter($selected_array, 'is_numeric');

    $sql = "SELECT DISTINCT THREAD.TID, TRIM(CONCAT(FOLDER.PREFIX, ' ', THREAD.TITLE)) AS TITLE ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) WHERE THREAD.TITLE LIKE '$thread_search%' ";
    $sql.= "AND THREAD.FID IN ($fidlist) ";

    if (sizeof($selected_array) > 0) {

        $selected = implode(', ', $selected_array);
        $sql.= "AND THREAD.TID NOT IN ($selected) ";
    }

    $sql.= "LIMIT 10";

    if (!$result = db_query($sql, $db_thread_search)) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_thread_search)) return false;

    list($results_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($thread_data = db_fetch_array($result))) {

            $results_array[$thread_data['TID']] = $thread_data;
        }
    }

    return array('results_count' => $results_count,
                 'results_array' => $results_array);
}

function thread_get_last_page_pid($length, $posts_per_page)
{
    if (session_get_value('THREAD_LAST_PAGE') == 'Y') {

        $last_page_pid = $length - ($length % $posts_per_page);
        return ($last_page_pid > 1) ? $last_page_pid : 1;
    }

    return $length;
}

function thread_has_attachments(&$thread_data)
{
    if (!isset($thread_data['TID'])) return false;

    if (!is_numeric($thread_data['TID'])) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_thread_has_attachments = db_connect()) return false;

    $sql = "SELECT PAI.TID, PAF.AID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAI.TID = '{$thread_data['TID']}'";

    if (!$result = db_query($sql, $db_thread_has_attachments)) return false;

    while (($attachment_data = db_fetch_array($result))) {
        $thread_data['AID'] = $attachment_data['AID'];
    }

    return true;
}

?>