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

/* $Id: thread.inc.php,v 1.57 2004-11-03 23:31:55 decoyduck Exp $ */

include_once("./include/folder.inc.php");
include_once("./include/forum.inc.php");

function thread_get_title($tid)
{
    $db_thread_get_title = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return "The Unknown Thread";

    $sql = "SELECT TITLE FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid'";
    $resource_id = db_query($sql, $db_thread_get_title);

    if (!db_num_rows($resource_id)) {
        $threadtitle = "The Unknown Thread";
    }else {
        $data = db_fetch_array($resource_id);
        $threadtitle = _stripslashes($data['TITLE']);
    }

    return $threadtitle;
}

function thread_get($tid)
{
    $db_thread_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    if (!is_numeric($tid)) return false;

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, ";
    $sql.= "THREAD.POLL_FLAG, THREAD.STICKY, UNIX_TIMESTAMP(THREAD.STICKY_UNTIL) AS STICKY_UNTIL, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.modified) AS MODIFIED, THREAD.CLOSED, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, ";
    $sql.= "THREAD.ADMIN_LOCK, USER_THREAD.INTEREST, USER_THREAD.LAST_READ, USER.UID AS FROM_UID, ";
    $sql.= "USER.LOGON, USER.NICKNAME, UP.RELATIONSHIP, FOLDER.TITLE AS FOLDER_TITLE ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "JOIN USER USER ";
    $sql.= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql.= "(UP.UID = $uid AND UP.PEER_UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON ";
    $sql.= "(FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE USER.UID = POST.FROM_UID ";
    $sql.= "AND POST.TID = THREAD.TID ";
    $sql.= "AND POST.PID = 1 ";
    $sql.= "AND THREAD.TID = $tid ";
    $sql.= "GROUP BY THREAD.tid";

    $resource_id = db_query($sql, $db_thread_get);

    if (!db_num_rows($resource_id)) {
        $threaddata = false;
    }else {

        $threaddata = db_fetch_array($resource_id);

        if (!isset($threaddata['INTEREST'])) {
            $threaddata['INTEREST'] = 0;
        }

        if (!isset($threaddata['LAST_READ'])) {
            $threaddata['LAST_READ'] = 0;
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
    }

    return $threaddata;
}

function thread_get_author($tid)
{
    $db_thread_get_author = db_connect();

    if (!$table_data = get_table_prefix()) return "";

    if (!is_numeric($tid)) return false;

    $sql = "SELECT U.LOGON, U.NICKNAME FROM USER U, {$table_data['PREFIX']}POST P ";
    $sql.= "WHERE U.UID = P.FROM_UID AND P.TID = $tid and P.PID = 1";

    $result = db_query($sql, $db_thread_get_author);
    $author = db_fetch_array($result);

    return format_user_name($author['LOGON'], $author['NICKNAME']);
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

        $folder = db_fetch_array($result);
        return $folder['FID'];
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

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return isset($row['LENGTH']) ? $row['LENGTH'] : 0;
    }else {
        return 0;
    }
}

function thread_get_interest($tid)
{
    $uid = bh_session_get_value('UID');
    $db_thread_get_interest = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    if (!is_numeric($tid)) return false;

    $sql = "SELECT INTEREST FROM {$table_data['PREFIX']}USER_THREAD WHERE UID = '$uid' AND TID = '$tid'";
    $result = db_query($sql, $db_thread_get_interest);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return isset($row['INTEREST']) ? $row['INTEREST'] : 0;
    }else {
        return 0;
    }
}

function thread_set_interest($tid, $interest, $new = false)
{
    $uid = bh_session_get_value('UID');

    if (!is_numeric($tid)) return false;
    if (!is_numeric($interest)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if ($new) {
        $sql = "insert into {$table_data['PREFIX']}USER_THREAD (UID, TID, INTEREST) ";
        $sql.= "values ($uid, $tid, $interest)";
    }else {
        $sql = "update low_priority {$table_data['PREFIX']}USER_THREAD ";
        $sql.= "set INTEREST = $interest where UID = $uid and TID = $tid";
    }

    $db_thread_set_interest = db_connect();
    db_query($sql, $db_thread_set_interest);
}

function thread_can_view($tid = 0, $uid = 0)
{
    $fidlist = folder_get_available();
    $db_thread_can_view = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}THREAD WHERE TID = '$tid' AND FID IN ($fidlist)";
    $result = db_query($sql,$db_thread_can_view);

    return (db_num_rows($result) > 0);
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
        } else {
            $sql .= ", STICKY_UNTIL = NULL ";
        }
        $sql .= "WHERE TID = $tid";
    } else {
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
    } else {
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
    } else {
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

function thread_delete($tid)
{
    $db_thread_delete = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($tid)) return false;

    $sql = "UPDATE {$table_data['PREFIX']}POST_CONTENT ";
    $sql.= "SET CONTENT = NULL WHERE TID = '$tid'";

    return db_query($sql, $db_thread_delete);
}

?>