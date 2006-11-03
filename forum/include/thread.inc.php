<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: thread.inc.php,v 1.90 2006-11-03 23:00:10 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");

function thread_get_title($tid)
{
    $db_thread_get_title = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT TITLE FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";
    $result = db_query($sql, $db_thread_get_title);

    if (db_num_rows($result) > 0) {

        list($thread_title) = db_fetch_array($result, DB_RESULT_NUM);
        return $thread_title;
    }

    return "The Unknown Thread";
}

function thread_get($tid, $inc_deleted = false)
{
    $db_thread_get = db_connect();

    $fidlist = folder_get_available();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.BY_UID, THREAD.TITLE, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD_STATS.VIEWCOUNT, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.STICKY_UNTIL) AS STICKY_UNTIL, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, THREAD.CLOSED, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.CREATED) AS CREATED, THREAD.ADMIN_LOCK, ";
    $sql.= "USER_THREAD.INTEREST, USER_THREAD.LAST_READ, USER.UID AS FROM_UID, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "USER_PEER.RELATIONSHIP, FOLDER.TITLE AS FOLDER_TITLE ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.TID = '$tid' ";
    $sql.= "AND THREAD.FID IN ($fidlist) ";
    
    if ($inc_deleted === false) $sql.= "AND THREAD.LENGTH > 0 ";

    $result = db_query($sql, $db_thread_get);

    if (db_num_rows($result) > 0) {

        $threaddata = db_fetch_array($result);

        if (!isset($threaddata['INTEREST'])) {
            $threaddata['INTEREST'] = 0;
        }

        if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

            $thread['LAST_READ'] = 0;

            if (isset($thread['MODIFIED']) && ($thread['MODIFIED'] > $unread_cutoff_stamp)) {
                $thread['LAST_READ'] = 0;
            }else if (isset($thread['LENGTH'])) {
                $thread['LAST_READ'] = $thread['LENGTH'];
            }
        }

        if (!isset($threaddata['STICKY_UNTIL'])) {
            $threaddata['STICKY_UNTIL'] = 0;
        }

        if (!isset($threaddata['ADMIN_LOCK'])) {
            $threaddata['ADMIN_LOCK'] = 0;
        }

        if (!isset($threaddata['CLOSED'])) {
            $threaddata['CLOSED'] = 0;
        }

        if (isset($threaddata['PEER_NICKNAME'])) {
            if (!is_null($threaddata['PEER_NICKNAME']) && strlen($threaddata['PEER_NICKNAME']) > 0) {
                $threaddata['NICKNAME'] = $threaddata['PEER_NICKNAME'];
            }
        }

        return $threaddata;
    }

    return false;
}

function thread_get_by_uid($tid)
{
    $db_thread_get_author = db_connect();

    if (!$table_data = get_table_prefix()) return "";

    if (!is_numeric($tid)) return false;

    $sql = "SELECT BY_UID FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE TID = $tid";

    $result = db_query($sql, $db_thread_get_author);

    list($by_uid) = db_fetch_array($result, DB_RESULT_NUM);

    return $by_uid;
}

function thread_get_folder($tid)
{
    $db_thread_get_folder = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "WHERE TID = '$tid'";

    $result = db_query($sql, $db_thread_get_folder);

    if (db_num_rows($result) > 0) {

        list($folder) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder;
    }

    return false;
}

function thread_get_length($tid)
{
    $db_thread_get_length = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT LENGTH FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";
    $result = db_query($sql, $db_thread_get_length);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return isset($row['LENGTH']) ? $row['LENGTH'] : 0;

    }else {

        return 0;
    }
}

function thread_get_tracking_data($tid)
{
    $db_thread_get_tracking_data = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT TID, NEW_TID, TRACK_TYPE ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD_TRACK ";
    $sql.= "WHERE TID = '$tid' OR NEW_TID = '$tid'";

    $result = db_query($sql, $db_thread_get_tracking_data);

    if (db_num_rows($result) > 0) {
    
        $tracking_data_array = array();
        
        while ($tracking_data = db_fetch_array($result)) {
            $tracking_data_array[] = $tracking_data;
        }

        return $tracking_data_array;
    }

    return false;
}    

function thread_set_length($tid, $length)
{
    $db_thread_get_length = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($length)) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD ";
    $sql.= "SET LENGTH = '$length' WHERE TID = '$tid'";

    return db_query($sql, $db_thread_get_length);
}

function thread_set_moved($old_tid, $new_tid)
{
    $db_thread_set_moved = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}THREAD_TRACK ";
    $sql.= "(TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql.= "VALUES ('$old_tid', '$new_tid', NOW(), 0)";

    return db_query($sql, $db_thread_set_moved);
}

function thread_set_split($old_tid, $new_tid)
{
    $db_thread_set_split = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($old_tid)) return false;
    if (!is_numeric($new_tid)) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}THREAD_TRACK ";
    $sql.= "(TID, NEW_TID, CREATED, TRACK_TYPE) ";
    $sql.= "VALUES ('$old_tid', '$new_tid', NOW(), 1)";

    return db_query($sql, $db_thread_set_split);
}

function thread_get_interest($tid)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $db_thread_get_interest = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT INTEREST FROM {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    $result = db_query($sql, $db_thread_get_interest);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return isset($row['INTEREST']) ? $row['INTEREST'] : 0;

    }else {

        return 0;
    }
}

function thread_set_interest($tid, $interest)
{
    $db_thread_set_interest = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($interest)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "SET INTEREST = '$interest' WHERE UID = '$uid' AND TID = '$tid'";

    $result = db_query($sql, $db_thread_set_interest);

    if (db_affected_rows($db_thread_set_interest) < 1) {

        $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$tid', '$interest')";

        $result = db_query($sql, $db_thread_set_interest);
    }
    
    return $result;
}

// Same as thread_set_interest but this one won't
// change the interest of a thread unless it is 'normal'

function thread_set_high_interest($tid)
{
    $db_thread_set_high_interest = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_THREAD ";
    $sql.= "SET INTEREST = 1 WHERE UID = '$uid' AND TID = '$tid' ";
    $sql.= "AND (INTEREST = 0 OR INTEREST IS NULL)";

    $result = db_query($sql, $db_thread_set_high_interest);

    if (db_affected_rows($db_thread_set_high_interest) < 1) {

        $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$tid', 1)";

        $result = db_query($sql, $db_thread_set_high_interest);
    }
    
    return $result;
}

function thread_set_sticky($tid, $sticky = true, $sticky_until = false)
{
    $db_thread_set_sticky = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    if ($sticky) {

        $sql  = "UPDATE {$table_data['PREFIX']}THREAD SET STICKY = 'Y' ";

        if ($sticky_until) {
            $sql .= ", STICKY_UNTIL = FROM_UNIXTIME($sticky_until) ";
        }else {
            $sql .= ", STICKY_UNTIL = NULL ";
        }

        $sql .= "WHERE TID = $tid";

    }else {

        $sql = "UPDATE {$table_data['PREFIX']}THREAD SET STICKY = 'N' WHERE TID = $tid";
    }

    return db_query($sql,$db_thread_set_sticky);
}

function thread_set_closed($tid, $closed = true)
{
    $db_thread_set_closed = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    if ($closed) {
        $sql = "UPDATE {$table_data['PREFIX']}THREAD SET CLOSED = NOW() WHERE TID = $tid";
    }else {
        $sql = "UPDATE {$table_data['PREFIX']}THREAD SET CLOSED = NULL WHERE TID = $tid";
    }

    return db_query($sql,$db_thread_set_closed);
}

function thread_admin_lock($tid, $locked = true)
{
    $db_thread_admin_lock = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    if ($locked) {
        $sql = "UPDATE {$table_data['PREFIX']}THREAD SET ADMIN_LOCK = NOW() WHERE TID = $tid";
    }else {
        $sql = "UPDATE {$table_data['PREFIX']}THREAD SET ADMIN_LOCK = NULL WHERE TID = $tid";
    }

    return db_query($sql, $db_thread_admin_lock);
}

function thread_change_folder($tid, $new_fid)
{
    $db_thread_set_closed = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($new_fid)) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD SET FID = $new_fid WHERE TID = $tid";
    return db_query($sql, $db_thread_set_closed);
}

function thread_change_title($tid, $new_title)
{
    $db_thread_change_title = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $new_title = addslashes(_htmlentities($new_title));

    if (!is_numeric($tid)) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD SET TITLE = '$new_title' WHERE TID = $tid";
    return db_query($sql, $db_thread_change_title);
}

function thread_delete_by_user($tid, $uid)
{
    $db_thread_delete_by_user = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "SELECT TID, PID FROM {$table_data['PREFIX']}POST ";
    $sql.= "WHERE FROM_UID = '$uid' AND TID = '$tid'";

    $result = db_query($sql, $db_thread_delete_by_user);

    while ($row = db_fetch_array($result)) {

        $sql = "UPDATE {$table_data['PREFIX']}POST_CONTENT ";
        $sql.= "SET CONTENT = NULL WHERE TID = '{$row['TID']}' ";
        $sql.= "AND PID = '{$row['PID']}'";

        $result = db_query($sql, $db_thread_delete_by_user);
    }

    return $result;
}

function thread_delete($tid, $delete_type)
{
    $db_thread_delete = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($delete_type)) return false;

    if ($delete_type == 0) {

        $sql = "DELETE FROM {$table_data['PREFIX']}POST_CONTENT WHERE TID = '$tid'";
        $result = db_query($sql, $db_thread_delete);

        $sql = "DELETE FROM {$table_data['PREFIX']}POST WHERE TID = '$tid'";
        $result = db_query($sql, $db_thread_delete);

        $sql = "DELETE FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";
        $result = db_query($sql, $db_thread_delete);

        $sql = "DELETE FROM {$table_data['PREFIX']}USER_THREAD WHERE TID = '$tid'";
        $result = db_query($sql, $db_thread_delete);

    }else {

        $sql = "UPDATE {$table_data['PREFIX']}THREAD ";
        $sql.= "SET LENGTH = 0 WHERE TID = '$tid'";

        $result = db_query($sql, $db_thread_delete);
    }

    return true;
}

function thread_undelete($tid)
{
    $db_thread_undelete = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    if (!$thread_length = thread_can_be_undeleted($tid)) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD ";
    $sql.= "SET LENGTH = '$thread_length' WHERE TID = '$tid'";

    return db_query($sql, $db_thread_undelete);
}

function thread_merge($tida, $tidb, $merge_type)
{
    $db_thread_merge = db_connect();

    if (!is_numeric($tida)) return false;
    if (!is_numeric($tidb)) return false;
    if (!is_numeric($merge_type)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (thread_is_poll($tida) || thread_is_poll($tidb)) return false;

    if ($threada = thread_get($tida) && $threadb = thread_get($tidb)) {

        thread_set_closed($tida, true);
        thread_set_closed($tidb, true);

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

        if (is_array($post_data_array) && isset($post_data_array[0]['TID'])) {

            if ($new_thread = thread_get($post_data_array[0]['TID'])) {

                $new_tid = post_create_thread($new_thread['FID'], $new_thread['BY_UID'], _htmlentities_decode($new_thread['TITLE']), 'N', 'N', true);

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

                        if ($result_insert = db_query($sql, $db_thread_merge)) {

                            $new_pid = db_insert_id($db_thread_merge);

                            $sql = "INSERT INTO {$table_data['PREFIX']}POST_CONTENT (TID, PID, CONTENT) ";
                            $sql.= "SELECT $new_tid, $new_pid, CONTENT FROM {$table_data['PREFIX']}POST_CONTENT ";
                            $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                            $result_content = db_query($sql, $db_thread_merge);

                            $sql = "UPDATE {$table_data['PREFIX']}POST SET MOVED_TID = '$new_tid', MOVED_PID = '$new_pid' ";
                            $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                            $result_update = db_query($sql, $db_thread_merge);
                        }
                    }

                    thread_set_moved($tida, $new_tid);
                    thread_set_moved($tidb, $new_tid);

                    thread_set_length($new_tid, sizeof($post_data_array));
                    thread_set_closed($new_tid, false);

                    return array($tida, $threada['TITLE'], $tidb, $threadb['TITLE'], $new_tid, $thread_new['TITLE']);
                }
            }
        }
    }

    thread_set_closed($tida, false);
    thread_set_closed($tidb, false);

    return false;
}

function thread_merge_get_by_created($dest_tid, $source_tid)
{
    if (!is_numeric($dest_tid)) return false;
    if (!is_numeric($source_tid)) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $db_thread_merge_get_by_created = db_connect();

    $post_data_array = array();

    $sql = "SELECT TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, ";
    $sql.= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS ";
    $sql.= "FROM {$table_data['PREFIX']}POST WHERE TID IN ($dest_tid, $source_tid) ";
    $sql.= "AND MOVED_TID IS NULL AND MOVED_PID IS NULL ";
    $sql.= "ORDER BY CREATED";

    $result = db_query($sql, $db_thread_merge_get_by_created);

    if (db_num_rows($result) > 0) {

        $dest_pid_array   = array();
        $source_pid_array = array();

        $new_post_pid = 0;

        while ($post_data = db_fetch_array($result, DB_RESULT_ASSOC)) {

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
    
    $db_thread_merge_get_by_created = db_connect();

    $post_data_array = array();

    if ($threaddata = thread_get($tida)) {

        $sql = "SELECT TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, ";
        $sql.= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS ";
        $sql.= "FROM {$table_data['PREFIX']}POST WHERE TID IN ($tida, $tidb) ";
        $sql.= "AND MOVED_TID IS NULL AND MOVED_PID IS NULL ";
        $sql.= "ORDER BY CREATED";

        $result = db_query($sql, $db_thread_merge_get_by_created);

        if (db_num_rows($result) > 0) {

            $tida_post_array = array();
            $tidb_post_array   = array();

            $new_post_pid = 0;

            while ($post_data = db_fetch_array($result, DB_RESULT_ASSOC)) {

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

                $post_data_array = array_merge($tida_post_array, $tidb_post_array);
            }
        }
    }

    return (sizeof($post_data_array) > 0) ? $post_data_array : false;
}

function thread_split($tid, $spid, $split_type)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($spid)) return false;
    if (!is_numeric($split_type)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $db_thread_split = db_connect();

    if ($threaddata = thread_get($tid)) {

        thread_set_closed($tid, true);

        switch ($split_type) {

            case THREAD_SPLIT_REPLIES:
        
                $post_data_array = thread_split_get_replies($tid, $spid);
                $new_tid = post_create_thread($threaddata['FID'], $threaddata['BY_UID'], _htmlentities_decode($threaddata['TITLE']), 'N', 'N', true);
                break;

            case THREAD_SPLIT_FOLLOWING:

                $post_data_array = thread_split_get_following($tid, $spid);
                $new_tid = post_create_thread($threaddata['FID'], $threaddata['BY_UID'], _htmlentities_decode($threaddata['TITLE']), 'N', 'N', true);
                break;
        }

        if ($thread_new = thread_get($new_tid, true)) {

            if (is_array($post_data_array) && sizeof($post_data_array) > 0 && $new_tid > 0) {

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

                    if ($result_insert = db_query($sql, $db_thread_split)) {

                        $new_pid = db_insert_id($db_thread_split);

                        $sql = "INSERT INTO {$table_data['PREFIX']}POST_CONTENT (TID, PID, CONTENT) ";
                        $sql.= "SELECT $new_tid, $new_pid, CONTENT FROM {$table_data['PREFIX']}POST_CONTENT ";
                        $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                        $result_content = db_query($sql, $db_thread_split);

                        $sql = "UPDATE {$table_data['PREFIX']}POST SET MOVED_TID = '$new_tid', MOVED_PID = '$new_pid' ";
                        $sql.= "WHERE TID = '{$post_data['TID']}' AND PID = '{$post_data['PID']}'";

                        $result_update = db_query($sql, $db_thread_split);
                    }
                }

                thread_set_split($tid, $new_tid);

                thread_set_length($new_tid, sizeof($post_data_array));

                thread_set_closed($tid, false);
                thread_set_closed($new_tid, false);
                
                return array($tid, $spid, $new_tid, $thread_new['TITLE']);
            }
        }
    }

    return false;
}

function thread_split_get_replies($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $db_thread_split_get = db_connect();

    $post_data_array = array();
    $dest_pid_array  = array();

    $sql = "SELECT TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, ";
    $sql.= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS ";
    $sql.= "FROM {$table_data['PREFIX']}POST WHERE TID = '$tid' AND PID = '$pid' ";
    $sql.= "AND MOVED_TID IS NULL AND MOVED_PID IS NULL ";

    $result = db_query($sql, $db_thread_split_get);

    if ($post_data = db_fetch_array($result, DB_RESULT_ASSOC)) {
        
        $new_post_pid = 1;

        $dest_pid_array[$post_data['PID']] = $new_post_pid;

        $post_data_array[$new_post_pid] = $post_data;
        $post_data_array[$new_post_pid]['REPLY_TO_PID'] = 0;

        thread_split_recursive($tid, $pid, &$post_data_array, &$dest_pid_array, &$new_post_pid);
    }

    return (sizeof($post_data_array) > 0) ? $post_data_array : false;
}

function thread_split_get_following($tid, $spid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($spid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $db_thread_split_get_following = db_connect();

    $sql = "SELECT TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, ";
    $sql.= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS ";
    $sql.= "FROM {$table_data['PREFIX']}POST WHERE TID = $tid AND PID >= '$spid' ";
    $sql.= "AND MOVED_TID IS NULL AND MOVED_PID IS NULL ";
    $sql.= "ORDER BY PID";

    $result = db_query($sql, $db_thread_split_get_following);

    if (db_num_rows($result) > 0) {

        $dest_pid_array  = array();
        $post_data_array = array();

        $new_post_pid = 0;
        
        while ($post_data = db_fetch_array($result, DB_RESULT_ASSOC)) {

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

    $db_thread_split_recursive = db_connect();

    $sql = "SELECT TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, CREATED, ";
    $sql.= "APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS ";
    $sql.= "FROM {$table_data['PREFIX']}POST WHERE TID = $tid AND REPLY_TO_PID = $spid ";
    $sql.= "AND MOVED_TID IS NULL AND MOVED_PID IS NULL ";

    $result = db_query($sql, $db_thread_split_recursive);

    if (db_num_rows($result) > 0) {

        while ($post_data = db_fetch_array($result, DB_RESULT_ASSOC)) {

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

    $db_thread_get_unmoved_posts = db_connect();

    $sql = "SELECT PID FROM {$table_data['PREFIX']}POST ";
    $sql.= "WHERE TID = '$tid' AND MOVED_TID IS NULL ";
    $sql.= "AND MOVED_PID IS NULL AND PID > 1";

    $result = db_query($sql, $db_thread_get_unmoved_posts);

    if (db_num_rows($result) > 0) {

        $thread_data = array();
        
        while ($row = db_fetch_array($result)) {
            $thread_data[] = $row['PID'];
        }

        return $thread_data;
    }

    return false;
}

function thread_can_be_undeleted($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $db_thread_can_be_undeleted = db_connect();

    $sql = "SELECT MAX(PID) AS LENGTH FROM ";
    $sql.= "{$table_data['PREFIX']}POST WHERE TID = '$tid'";

    $result = db_query($sql, $db_thread_can_be_undeleted);

    list($length) = db_fetch_array($result, DB_RESULT_NUM);

    return $length;
}

?>