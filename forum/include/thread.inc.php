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

/* $Id: thread.inc.php,v 1.153 2008-10-26 21:03:52 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

function thread_get_title($tid)
{
    if (!$db_thread_get_title = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT TITLE FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_get_title)) return false;

    if (db_num_rows($result) > 0) {

        list($thread_title) = db_fetch_array($result, DB_RESULT_NUM);
        return $thread_title;
    }

    return "The Unknown Thread";
}

function thread_get($tid, $inc_deleted = false)
{
    if (!$db_thread_get = db_connect()) return false;

    $lang = load_language_file();

    $fidlist = folder_get_available();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "THREAD.BY_UID, THREAD.CLOSED, THREAD.ADMIN_LOCK, FOLDER.PREFIX, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.CREATED) AS CREATED, THREAD.ADMIN_LOCK, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.STICKY_UNTIL) AS STICKY_UNTIL, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.UID, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "FOLDER.TITLE AS FOLDER_TITLE FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.TID = '$tid' AND THREAD.LENGTH > 0 ";
    $sql.= "AND THREAD.FID IN ($fidlist) ";

    if ($inc_deleted === false) $sql.= "AND THREAD.DELETED = 'N' ";

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
            if (!is_null($thread_data['PEER_NICKNAME']) && mb_strlen($thread_data['PEER_NICKNAME']) > 0) {
                $thread_data['NICKNAME'] = $thread_data['PEER_NICKNAME'];
            }
        }

        if (!isset($thread_data['LOGON'])) $thread_data['LOGON'] = $lang['unknownuser'];
        if (!isset($thread_data['NICKNAME'])) $thread_data['NICKNAME'] = "";

        return $thread_data;
    }

    return false;
}

function thread_get_by_uid($tid)
{
    if (!$db_thread_get_author = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return "";

    if (!is_numeric($tid)) return false;

    $sql = "SELECT BY_UID FROM {$table_data['PREFIX']}THREAD ";
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

    $sql = "SELECT FID FROM {$table_data['PREFIX']}THREAD THREAD ";
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

    $sql = "SELECT LENGTH FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";

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

    $sql = "SELECT TID, NEW_TID, TRACK_TYPE ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD_TRACK ";
    $sql.= "WHERE TID = '$tid' OR NEW_TID = '$tid'";

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

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD ";
    $sql.= "SET LENGTH = '$length' WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_get_length)) return false;

    return true;
}

function thread_set_moved($old_tid, $new_tid)
{
    if (!$db_thread_set_moved = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}THREAD_TRACK ";
    $sql.= "(TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql.= "VALUES ('$old_tid', '$new_tid', NOW(), 0)";

    if (!db_query($sql, $db_thread_set_moved)) return false;

    return true;
}

function thread_set_split($old_tid, $new_tid)
{
    if (!$db_thread_set_split = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}THREAD_TRACK ";
    $sql.= "(TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql.= "VALUES ('$old_tid', '$new_tid', NOW(), 1)";

    if (!db_query($sql, $db_thread_set_split)) return false;

    return true;
}

function thread_get_interest($tid)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$db_thread_get_interest = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT INTEREST FROM {$table_data['PREFIX']}USER_THREAD ";
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

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($interest)) return false;

    $thread_interest_array = array(THREAD_IGNORED, THREAD_NOINTEREST,
                                   THREAD_INTERESTED, THREAD_SUBSCRIBED);

    if (!in_array($interest, $thread_interest_array)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) FROM {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_set_interest)) return false;

    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($thread_count > 0) {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_THREAD ";
        $sql.= "SET INTEREST = '$interest' WHERE UID = '$uid' AND TID = '$tid'";

        if (!$result = db_query($sql, $db_thread_set_interest)) return false;

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$tid', '$interest')";

        if (!$result = db_query($sql, $db_thread_set_interest)) return false;
    }

    return true;
}

// Same as thread_set_interest but this one won't
// change the interest of a thread unless it is 'normal'

function thread_set_high_interest($tid)
{
    if (!$db_thread_set_high_interest = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) FROM {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_set_high_interest)) return false;

    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($thread_count > 0) {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_THREAD ";
        $sql.= "SET INTEREST = 1 WHERE UID = '$uid' AND TID = '$tid' ";
        $sql.= "AND (INTEREST = 0 OR INTEREST IS NULL)";

        if (!$result = db_query($sql, $db_thread_set_high_interest)) return false;

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$tid', 1)";

        if (!$result = db_query($sql, $db_thread_set_high_interest)) return false;
    }

    return $result;
}

function thread_set_sticky($tid, $sticky = true, $sticky_until = false)
{
    if (!$db_thread_set_sticky = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sticky_sql = ($sticky === true) ? 'Y' : 'N';
    $sticky_until_sql = ($sticky_until !== false) ? "FROM_UNIXTIME($sticky_until)" : 'NULL';

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD SET STICKY = '$sticky_sql', ";
    $sql.= "STICKY_UNTIL = $sticky_until_sql ";
    $sql.= "WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_set_sticky)) return false;

    return true;
}

function thread_set_closed($tid, $closed = true)
{
    if (!$db_thread_set_closed = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $closed_sql = ($closed === true) ? 'NOW()' : 'NULL';

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD ";
    $sql.= "SET CLOSED = $closed_sql WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_set_closed)) return false;

    return true;
}

function thread_admin_lock($tid, $locked = true)
{
    if (!$db_thread_admin_lock = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $locked_sql = ($locked === true) ? 'NOW()' : 'NULL';

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD ";
    $sql.= "SET ADMIN_LOCK = $locked_sql WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_admin_lock)) return false;

    return true;
}

function thread_change_folder($tid, $new_fid)
{
    if (!$db_thread_set_closed = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($new_fid)) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD SET FID = '$new_fid' WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_set_closed)) return false;

    return true;
}

function thread_change_title($tid, $new_title)
{
    if (!$db_thread_change_title = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $new_title = db_escape_string($new_title);

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD SET TITLE = '$new_title' WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_change_title)) return false;

    return true;
}

function thread_delete_by_user($tid, $uid)
{
    if (!$db_thread_delete_by_user = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}POST_CONTENT (TID, PID, CONTENT) ";
    $sql.= "SELECT TID, PID, NULL FROM {$table_data['PREFIX']}POST POST ";
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

    if ($delete_type == THREAD_DELETE_PERMENANT) {

        $sql = "DELETE QUICK FROM {$table_data['PREFIX']}POST_CONTENT WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

        $sql = "DELETE QUICK FROM {$table_data['PREFIX']}POST WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

        $sql = "DELETE QUICK FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

        $sql = "DELETE QUICK FROM {$table_data['PREFIX']}USER_THREAD WHERE TID = '$tid'";

        if (!db_query($sql, $db_thread_delete)) return false;

    }else {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD SET DELETED = 'Y' WHERE TID = '$tid'";

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

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD ";
    $sql.= "SET DELETED = 'N' WHERE TID = '$tid'";

    if (!db_query($sql, $db_thread_undelete)) return false;

    return true;
}

function thread_merge($tida, $tidb, $merge_type, &$error_str)
{
    if (!$db_thread_merge = db_connect()) return false;

    $tida_closed = true;
    $tidb_closed = true;

    if (!is_numeric($tida)) {
        return thread_merge_error(THREAD_MERGE_INVALID_ARGS, $error_str);
    }

    if (!is_numeric($tidb)) {
        return thread_merge_error(THREAD_MERGE_INVALID_ARGS, $error_str);
    }

    if (!is_numeric($merge_type)) {
        return thread_merge_error(THREAD_MERGE_INVALID_ARGS, $error_str);
    }

    if (!$table_data = get_table_prefix()) {
        return thread_merge_error(THREAD_MERGE_FORUM_ERROR, $error_str);
    }

    if (thread_is_poll($tida) || thread_is_poll($tidb)) {
        return thread_merge_error(THREAD_MERGE_POLL_ERROR, $error_str);
    }

    if (!$threada = thread_get($tida)) {
        return thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);
    }

    if (!$threadb = thread_get($tidb)) {
        return thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);
    }

    $forum_fid = $table_data['FID'];

    if (isset($threada['TITLE']) && isset($threadb['TITLE'])) {

        $tida_closed = thread_set_closed($tida, true);
        $tidb_closed = thread_set_closed($tidb, true);

        $post_data_array = array();
        $new_tid = -1;

        switch ($merge_type) {

            case THREAD_MERGE_BY_CREATED:

                $post_data_array = thread_merge_get_by_created($tida, $tidb);
                break;

            case THREAD_MERGE_START:

                $post_data_array = thread_merge_get($tidb, $tida);
                break;

            case THREAD_MERGE_END:

                $post_data_array = thread_merge_get($tida, $tidb);
                break;
        }

        if (is_array($post_data_array) && sizeof($post_data_array) > 0) {

            $required_post_keys_array = array('TID', 'REPLY_TO_PID', 'FROM_UID', 'TO_UID', 'CREATED');

            foreach ($post_data_array as $post_data) {

                if (!is_array($post_data)) {

                    thread_merge_error(THREAD_MERGE_POST_ERROR, $error_str);

                    if ($tida_closed) thread_set_closed($tida, false);
                    if ($tidb_closed) thread_set_closed($tidb, false);

                    return false;
                }

                foreach ($required_post_keys_array as $required_post_key) {

                    if (!in_array($required_post_key, array_keys($post_data))) {

                        thread_merge_error(THREAD_MERGE_POST_ERROR, $error_str);

                        if ($tida_closed) thread_set_closed($tida, false);
                        if ($tidb_closed) thread_set_closed($tidb, false);

                        return false;
                    }
                }
            }

            if (($new_thread = thread_get($post_data_array[1]['TID']))) {

                $required_thread_keys_array = array('FID', 'BY_UID', 'TITLE');

                if (!is_array($new_thread)) {

                    thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);

                    if ($tidb_closed) thread_set_closed($tidb, false);
                    if ($tidb_closed) thread_set_closed($tidb, false);

                    return false;
                }

                foreach ($required_thread_keys_array as $required_thread_key) {

                    if (!in_array($required_thread_key, array_keys($new_thread))) {

                        thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);

                        if ($tida_closed) thread_set_closed($tida, false);
                        if ($tidb_closed) thread_set_closed($tidb, false);

                        return false;
                    }
                }

                $new_tid = post_create_thread($new_thread['FID'], $new_thread['BY_UID'], $new_thread['TITLE'], 'N', 'N', true);

                if (($new_tid > -1) && ($thread_new = thread_get($new_tid, true))) {

                    foreach ($post_data_array as $post_data) {

                        if (!isset($post_data['APPROVED']))    $post_data['APPROVED'] = '';
                        if (!isset($post_data['APPROVED_BY'])) $post_data['APPROVED_BY'] = '';
                        if (!isset($post_data['EDITED']))      $post_data['EDITED'] = '';
                        if (!isset($post_data['EDITED_BY']))   $post_data['EDITED_BY'] = '';
                        if (!isset($post_data['IPADDRESS']))   $post_data['IPADDRESS'] = '';

                        $sql = "INSERT INTO {$table_data['PREFIX']}POST (TID, REPLY_TO_PID, FROM_UID, ";
                        $sql.= "TO_UID, CREATED, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS) ";
                        $sql.= "VALUES ('$new_tid', '{$post_data['REPLY_TO_PID']}', ";
                        $sql.= "'{$post_data['FROM_UID']}', '{$post_data['TO_UID']}', ";
                        $sql.= "'{$post_data['CREATED']}', '{$post_data['APPROVED']}', ";
                        $sql.= "'{$post_data['APPROVED_BY']}', '{$post_data['EDITED']}', ";
                        $sql.= "'{$post_data['EDITED_BY']}', '{$post_data['IPADDRESS']}')";

                        if (db_query($sql, $db_thread_merge)) {

                            $new_pid = db_insert_id($db_thread_merge);

                            $sql = "INSERT INTO {$table_data['PREFIX']}POST_CONTENT (TID, PID, CONTENT) ";
                            $sql.= "SELECT $new_tid, $new_pid, CONTENT FROM {$table_data['PREFIX']}POST_CONTENT ";
                            $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                            if (!db_query($sql, $db_thread_merge)) return false;

                            $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST SET MOVED_TID = '$new_tid', MOVED_PID = '$new_pid' ";
                            $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                            if (!db_query($sql, $db_thread_merge)) return false;

                            $aid = md5(uniqid(mt_rand()));

                            $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
                            $sql.= "VALUES ('$forum_fid', '$new_tid', '$new_pid', '$aid')";

                            if (!db_query($sql, $db_thread_merge)) return false;

                            $sql = "UPDATE LOW_PRIORITY POST_ATTACHMENT_FILES SET AID = '$aid' WHERE AID = '{$post_data['AID']}'";

                            if (!db_query($sql, $db_thread_merge)) return false;
                        }
                    }

                    thread_set_moved($tida, $new_tid);
                    thread_set_moved($tidb, $new_tid);

                    thread_set_length($new_tid, sizeof($post_data_array));
                    thread_set_closed($new_tid, false);

                    return array($tida, $threada['TITLE'], $tidb, $threadb['TITLE'], $new_tid, $thread_new['TITLE']);

                }else {

                    thread_merge_error(THREAD_MERGE_CREATE_ERROR, $error_str);

                    if ($tida_closed) thread_set_closed($tida, false);
                    if ($tidb_closed) thread_set_closed($tidb, false);

                    return false;
                }

            }else {

                thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);

                if ($tida_closed) thread_set_closed($tida, false);
                if ($tidb_closed) thread_set_closed($tidb, false);

                return false;
            }

        }else {

            thread_merge_error(THREAD_MERGE_POST_ERROR, $error_str);

            if ($tida_closed) thread_set_closed($tida, false);
            if ($tidb_closed) thread_set_closed($tidb, false);

            return false;
        }
    }

    return thread_merge_error(THREAD_MERGE_THREAD_ERROR, $error_str);
}

function thread_merge_error($error_code, &$error_str)
{
    $lang = load_language_file();

    switch ($error_code) {

        case THREAD_MERGE_INVALID_ARGS:

            $error_str = $lang['invalidfunctionarguments'];
            break;

        case THREAD_MERGE_FORUM_ERROR:

            $error_str = $lang['couldnotretrieveforumdata'];
            break;

        case THREAD_MERGE_POLL_ERROR:

            $error_str = $lang['cannotmergepolls'];
            break;

        case THREAD_MERGE_THREAD_ERROR:

            $error_str = $lang['couldnotretrievethreaddatamerge'];
            break;

        case THREAD_MERGE_POST_ERROR:

            $error_str = $lang['couldnotretrievepostdatamerge'];
            break;

        case THREAD_MERGE_CREATE_ERROR:

            $error_str = $lang['failedtocreatenewthreadformerge'];
            break;

        default:

            $error_str = "";
            break;
    }

    return false;
}

function thread_merge_get_by_created($dest_tid, $source_tid)
{
    if (!is_numeric($dest_tid)) return false;
    if (!is_numeric($source_tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_thread_merge_get_by_created = db_connect()) return false;

    $post_data_array = array();

    $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, ";
    $sql.= "POST.TO_UID, POST.CREATED, POST.APPROVED, POST.APPROVED_BY, ";
    $sql.= "POST.EDITED, POST.EDITED_BY, POST.IPADDRESS, PAI.AID ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.TID = POST.TID ";
    $sql.= "AND PAI.PID = POST.PID AND PAI.FID = '$forum_fid') ";
    $sql.= "WHERE POST.TID IN ($dest_tid, $source_tid) ";
    $sql.= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";
    $sql.= "ORDER BY POST.CREATED";

    if (!$result = db_query($sql, $db_thread_merge_get_by_created)) return false;

    if (db_num_rows($result) > 0) {

        $dest_pid_array   = array();
        $source_pid_array = array();

        $new_post_pid = 0;

        while (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            $new_post_pid++;

            if ($post_data['TID'] == $source_tid) {

                $source_pid_array[$post_data['PID']] = $new_post_pid;

                $post_data_array[$new_post_pid] = $post_data;

                if ($post_data['REPLY_TO_PID'] > 0) {
                    $post_data_array[$new_post_pid]['REPLY_TO_PID'] = $source_pid_array[$post_data['REPLY_TO_PID']];
                }

            }else {

                $dest_pid_array[$post_data['PID']] = $new_post_pid;

                $post_data_array[$new_post_pid] = $post_data;

                if ($post_data['REPLY_TO_PID'] > 0) {
                    $post_data_array[$new_post_pid]['REPLY_TO_PID'] = $dest_pid_array[$post_data['REPLY_TO_PID']];
                }
            }
        }
    }

    return (sizeof($post_data_array) > 0) ? $post_data_array : false;
}

function thread_merge_get($tida, $tidb)
{
    if (!is_numeric($tida)) return false;
    if (!is_numeric($tidb)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_thread_merge_get_by_created = db_connect()) return false;

    $post_data_array = array();

    if (($threaddata = thread_get($tida))) {

        $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, ";
        $sql.= "POST.TO_UID, POST.CREATED, POST.APPROVED, POST.APPROVED_BY, ";
        $sql.= "POST.EDITED, POST.EDITED_BY, POST.IPADDRESS, PAI.AID ";
        $sql.= "FROM {$table_data['PREFIX']}POST POST ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.TID = POST.TID ";
        $sql.= "AND PAI.PID = POST.PID AND PAI.FID = '$forum_fid') ";
        $sql.= "WHERE POST.TID IN ($tida, $tidb) AND POST.MOVED_TID IS NULL ";
        $sql.= "AND POST.MOVED_PID IS NULL ORDER BY POST.CREATED";

        if (!$result = db_query($sql, $db_thread_merge_get_by_created)) return false;

        if (db_num_rows($result) > 0) {

            $tida_post_array = array();
            $tidb_post_array = array();

            $new_post_pid = 0;

            while (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

                $new_post_pid++;

                if ($post_data['TID'] == $tida) {

                    $tida_post_array[$new_post_pid] = $post_data;

                }else {

                    $tidb_post_array[$new_post_pid] = $post_data;

                    if ($tidb_post_array[$new_post_pid]['REPLY_TO_PID'] > 0) {
                        $tidb_post_array[$new_post_pid]['REPLY_TO_PID'] += ($threaddata['LENGTH'] - 1);
                    }
                }
            }

            if (sizeof($tida_post_array) > 0 && sizeof($tidb_post_array) > 0) {

                $post_data_array = $tida_post_array + $tidb_post_array;
            }
        }
    }

    return (sizeof($post_data_array) > 0) ? $post_data_array : false;
}

function thread_split($tid, $spid, $split_type, &$error_str)
{
    if (!$db_thread_split = db_connect()) return false;

    $tid_closed = true;

    if (!is_numeric($tid)) {
        return thread_split_error(THREAD_SPLIT_INVALID_ARGS, $error_str);
    }

    if (!is_numeric($spid) || $spid < 2) {
        return thread_split_error(THREAD_SPLIT_INVALID_ARGS, $error_str);
    }

    if (!is_numeric($split_type)) {
        return thread_split_error(THREAD_SPLIT_INVALID_ARGS, $error_str);
    }

    if (!$table_data = get_table_prefix()) {
        return thread_split_error(THREAD_SPLIT_FORUM_ERROR, $error_str);
    }

    $forum_fid = $table_data['FID'];

    if (($thread_data = thread_get($tid))) {

        $required_thread_keys_array = array('FID', 'BY_UID', 'TITLE');

        if (!is_array($thread_data)) {
            return thread_split_error(THREAD_SPLIT_THREAD_ERROR, $error_str);
        }

        foreach ($required_thread_keys_array as $required_thread_key) {
            if (!in_array($required_thread_key, array_keys($thread_data))) {
                return thread_split_error(THREAD_SPLIT_THREAD_ERROR, $error_str);
            }
        }

        $tid_closed = thread_set_closed($tid, true);

        $post_data_array = array();
        $new_tid = -1;

        switch ($split_type) {

            case THREAD_SPLIT_REPLIES:

                $post_data_array = thread_split_get_replies($tid, $spid);
                break;

            case THREAD_SPLIT_FOLLOWING:

                $post_data_array = thread_split_get_following($tid, $spid);
                break;
        }

        if (is_array($post_data_array) && sizeof($post_data_array) > 0) {

            $required_post_keys_array = array('TID', 'REPLY_TO_PID', 'FROM_UID', 'TO_UID', 'CREATED');

            foreach ($post_data_array as $post_data) {

                if (!is_array($post_data)) {

                    thread_split_error(THREAD_SPLIT_POST_ERROR, $error_str);
                    if ($tid_closed) thread_set_closed($tid, false);
                    return false;
                }

                foreach ($required_post_keys_array as $required_post_key) {

                    if (!in_array($required_post_key, array_keys($post_data))) {

                        thread_split_error(THREAD_SPLIT_POST_ERROR, $error_str);
                        if ($tid_closed) thread_set_closed($tid, false);
                        return false;
                    }
                }
            }

            $new_tid = post_create_thread($thread_data['FID'], $post_data_array[1]['FROM_UID'], $thread_data['TITLE'], 'N', 'N', true);

            if (($new_tid > -1) && ($thread_new = thread_get($new_tid, true))) {

                foreach ($post_data_array as $post_data) {

                    if (!isset($post_data['APPROVED']))    $post_data['APPROVED'] = '';
                    if (!isset($post_data['APPROVED_BY'])) $post_data['APPROVED_BY'] = '';
                    if (!isset($post_data['EDITED']))      $post_data['EDITED'] = '';
                    if (!isset($post_data['EDITED_BY']))   $post_data['EDITED_BY'] = '';
                    if (!isset($post_data['IPADDRESS']))   $post_data['IPADDRESS'] = '';

                    $sql = "INSERT INTO {$table_data['PREFIX']}POST (TID, REPLY_TO_PID, FROM_UID, ";
                    $sql.= "TO_UID, CREATED, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS) ";
                    $sql.= "VALUES ('$new_tid', '{$post_data['REPLY_TO_PID']}', ";
                    $sql.= "'{$post_data['FROM_UID']}', '{$post_data['TO_UID']}', ";
                    $sql.= "'{$post_data['CREATED']}', '{$post_data['APPROVED']}', ";
                    $sql.= "'{$post_data['APPROVED_BY']}', '{$post_data['EDITED']}', ";
                    $sql.= "'{$post_data['EDITED_BY']}', '{$post_data['IPADDRESS']}')";

                    if (db_query($sql, $db_thread_split)) {

                        $new_pid = db_insert_id($db_thread_split);

                        $sql = "INSERT INTO {$table_data['PREFIX']}POST_CONTENT (TID, PID, CONTENT) ";
                        $sql.= "SELECT $new_tid, $new_pid, CONTENT FROM {$table_data['PREFIX']}POST_CONTENT ";
                        $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                        if (!db_query($sql, $db_thread_split)) return false;

                        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST SET MOVED_TID = '$new_tid', MOVED_PID = '$new_pid' ";
                        $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                        if (!db_query($sql, $db_thread_split)) return false;

                        $aid = md5(uniqid(mt_rand()));

                        $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
                        $sql.= "VALUES ('$forum_fid', '$new_tid', '$new_pid', '$aid')";

                        if (!db_query($sql, $db_thread_split)) return false;

                        $sql = "UPDATE LOW_PRIORITY POST_ATTACHMENT_FILES SET AID = '$aid' WHERE AID = '{$post_data['AID']}'";

                        if (!db_query($sql, $db_thread_split)) return false;
                    }
                }

                thread_set_split($tid, $new_tid);

                thread_set_length($new_tid, sizeof($post_data_array));

                thread_set_closed($tid, false);
                thread_set_closed($new_tid, false);

                return array($tid, $spid, $new_tid, $thread_new['TITLE']);

            }else {

                thread_split_error(THREAD_SPLIT_CREATE_ERROR, $error_str);
                if ($tid_closed) thread_set_closed($tid, false);
                return false;
            }

        }else {

            thread_split_error(THREAD_SPLIT_POST_ERROR, $error_str);
            if ($tid_closed) thread_set_closed($tid, false);
            return false;
        }

    }

    return thread_split_error(THREAD_SPLIT_THREAD_ERROR, $error_str);
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

    $forum_fid = $table_data['FID'];

    if (!$db_thread_split_get = db_connect()) return false;

    $post_data_array = array();
    $dest_pid_array  = array();

    $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, ";
    $sql.= "POST.TO_UID, POST.CREATED, POST.APPROVED, POST.APPROVED_BY, ";
    $sql.= "POST.EDITED, POST.EDITED_BY, POST.IPADDRESS, PAI.AID ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.TID = POST.TID ";
    $sql.= "AND PAI.PID = POST.PID AND PAI.FID = '$forum_fid') ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID = '$pid' ";
    $sql.= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";

    if (!$result = db_query($sql, $db_thread_split_get)) return false;

    if (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

        $new_post_pid = 1;

        $dest_pid_array[$post_data['PID']] = $new_post_pid;

        $post_data_array[$new_post_pid] = $post_data;
        $post_data_array[$new_post_pid]['REPLY_TO_PID'] = 0;

        thread_split_recursive($tid, $pid, $post_data_array, $dest_pid_array, $new_post_pid);
    }

    return (sizeof($post_data_array) > 0) ? $post_data_array : false;
}

function thread_split_get_following($tid, $spid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($spid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_thread_split_get_following = db_connect()) return false;

    $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, ";
    $sql.= "POST.TO_UID, POST.CREATED, POST.APPROVED, POST.APPROVED_BY, ";
    $sql.= "POST.EDITED, POST.EDITED_BY, POST.IPADDRESS, PAI.AID ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.TID = POST.TID ";
    $sql.= "AND PAI.PID = POST.PID AND PAI.FID = '$forum_fid') ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID >= '$spid' ";
    $sql.= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";
    $sql.= "ORDER BY POST.PID";

    if (!$result = db_query($sql, $db_thread_split_get_following)) return false;

    if (db_num_rows($result) > 0) {

        $dest_pid_array  = array();
        $post_data_array = array();

        $new_post_pid = 0;

        while (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            $new_post_pid++;

            $dest_pid_array[$post_data['PID']] = $new_post_pid;

            $post_data_array[$new_post_pid] = $post_data;

            if ($post_data['REPLY_TO_PID'] > 0) {

                if ($post_data['REPLY_TO_PID'] < $spid) {
                    $post_data_array[$new_post_pid]['REPLY_TO_PID'] = 0;
                }else {
                    $post_data_array[$new_post_pid]['REPLY_TO_PID'] = $dest_pid_array[$post_data['REPLY_TO_PID']];
                }
            }
        }

        return $post_data_array;
    }

    return false;
}

function thread_split_recursive($tid, $spid, &$post_data_array, &$dest_pid_array, &$new_post_pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($spid)) return false;

    if (!is_array($post_data_array)) $post_data_array = array();
    if (!is_array($dest_pid_array)) $dest_pid_array = array();

    if (!is_numeric($new_post_pid)) $new_post_pid = 0;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_thread_split_recursive = db_connect()) return false;

    $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, ";
    $sql.= "POST.TO_UID, POST.CREATED, POST.APPROVED, POST.APPROVED_BY, ";
    $sql.= "POST.EDITED, POST.EDITED_BY, POST.IPADDRESS, PAI.AID ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.TID = POST.TID ";
    $sql.= "AND PAI.PID = POST.PID AND PAI.FID = '$forum_fid') ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.REPLY_TO_PID = '$spid' ";
    $sql.= "AND POST.MOVED_TID IS NULL AND POST.MOVED_PID IS NULL ";

    if (!$result = db_query($sql, $db_thread_split_recursive)) return false;

    if (db_num_rows($result) > 0) {

        while (($post_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            $new_post_pid++;

            $dest_pid_array[$post_data['PID']] = $new_post_pid;
            $post_data_array[$new_post_pid] = $post_data;

            if ($post_data['REPLY_TO_PID'] > 0) {

                if ($post_data['REPLY_TO_PID'] < $spid) {
                    $post_data_array[$new_post_pid]['REPLY_TO_PID'] = 0;
                }else {
                    $post_data_array[$new_post_pid]['REPLY_TO_PID'] = $dest_pid_array[$post_data['REPLY_TO_PID']];
                }
            }

            thread_split_recursive($tid, $post_data['PID'], $post_data_array, $dest_pid_array, $new_post_pid);
        }

        return true;
    }

    return false;
}

function thread_get_unmoved_posts($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$db_thread_get_unmoved_posts = db_connect()) return false;

    $sql = "SELECT PID FROM {$table_data['PREFIX']}POST ";
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
    $sql.= "{$table_data['PREFIX']}POST WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_can_be_undeleted)) return false;

    list($length) = db_fetch_array($result, DB_RESULT_NUM);

    return ($length > 0);
}

function thread_search($thread_search, $offset = 0)
{
    if (!$db_thread_search = db_connect()) return false;

    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $results_array = array();

    $fidlist = folder_get_available();

    $thread_search = db_escape_string(str_replace("%", "", $thread_search));

    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE, ";
    $sql.= "FOLDER.PREFIX FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.TITLE LIKE '$thread_search%' ";
    $sql.= "AND THREAD.FID IN ($fidlist) ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_thread_search)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_thread_search)) return false;

    list($results_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($thread_data = db_fetch_array($result))) {

            if (!isset($results_array[$thread_data['TID']])) {

                $results_array[$thread_data['TID']] = $thread_data;
            }
        }

    }else if ($results_count > 0) {

        $offset = floor(($results_count - 1) / 10) * 10;
        return thread_search($thread_search, $offset);
    }

    return array('results_count' => $results_count,
                 'results_array' => $results_array);
}

function thread_format_prefix($prefix, $thread_title)
{
    if (mb_strlen(trim($prefix)) > 0) {
        return "{$prefix} {$thread_title}";
    }

    return $thread_title;
}

?>