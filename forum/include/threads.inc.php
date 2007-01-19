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

/* $Id: threads.inc.php,v 1.242 2007-01-19 17:40:33 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function threads_get_folders()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $db_threads_get_folders = db_connect();

    $access_allowed = USER_PERM_POST_READ;

    if (!$table_data = get_table_prefix()) return false;
    if (!is_numeric($access_allowed)) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, USER_FOLDER.INTEREST ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "ORDER BY FOLDER.FID, USER_FOLDER.INTEREST DESC";

    $result = db_query($sql, $db_threads_get_folders);

    if (db_num_rows($result) > 0) {

        $folder_info = array();

        while ($folder_data = db_fetch_array($result)) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                    $folder_data['STATUS'] = bh_session_get_perm($folder_data['FID']);

                    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = "";
                    if (!isset($folder_data['INTEREST'])) $folder_data['INTEREST'] = 0;

                    if (!isset($folder_data['ALLOWED_TYPES']) || is_null($folder_data['ALLOWED_TYPES'])) {
                        $folder_data['ALLOWED_TYPES'] = FOLDER_ALLOW_ALL_THREAD;
                    }

                    $folder_info[$folder_data['FID']] = $folder_data;
                }

            }else {
            
                if (bh_session_check_perm($access_allowed, $folder_data['FID'])) {

                    $folder_data['STATUS'] = bh_session_get_perm($folder_data['FID']);

                    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = "";
                    if (!isset($folder_data['INTEREST'])) $folder_data['INTEREST'] = 0;

                    if (!isset($folder_data['ALLOWED_TYPES']) || is_null($folder_data['ALLOWED_TYPES'])) {
                        $folder_data['ALLOWED_TYPES'] = FOLDER_ALLOW_ALL_THREAD;
                    }

                    $folder_info[$folder_data['FID']] = $folder_data;
                }
            }
        }

        return $folder_info;
    }

    return false;
}

function threads_get_all($uid, $start = 0) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    $db_threads_get_all = db_connect();

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships.

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query. We only join on the USER_FOLDER, USER_PEER and USER_THREAD tables
    // if the user is NOT a guest.

    if (user_is_guest()) {

        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, ";
        $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
        $sql.= "THREAD_STATS.VIEWCOUNT, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql.= "USER.LOGON, USER.NICKNAME FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
        $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql.= "WHERE THREAD.FID IN ($folders) AND THREAD.LENGTH > 0 ";
        $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql.= "LIMIT $start, 50";

    }else {
        
        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
        $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
        $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
        $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
        $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
        $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
        $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
        $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
        $sql.= "WHERE THREAD.FID IN ($folders) ";
        $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
        $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
        $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
        $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
        $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
        $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
        $sql.= "AND THREAD.LENGTH > 0 ";
        $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql.= "LIMIT $start, 50";
    }

    $result = db_query($sql, $db_threads_get_all);
    return threads_process_list($result);
}

function threads_get_started_by_me($uid, $start = 0) // get threads started by user
{
    $db_threads_get_started_by_me = db_connect();

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view unread messages.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.BY_UID = $uid AND THREAD.FID IN ($folders) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    $result = db_query($sql, $db_threads_get_started_by_me);
    return threads_process_list($result);
}

function threads_get_unread($uid) // get unread messages for $uid
{
    $db_threads_get_unread = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view unread messages.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationship

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_unread);
    return threads_process_list($result);
}

function threads_get_unread_to_me($uid) // get unread messages to $uid (ignores folder interest level)
{
    $db_threads_get_unread_to_me = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view unread messages.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (POST.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_unread_to_me);
    return threads_process_list($result);
}

function threads_get_by_days($uid, $days = 1) // get threads from the last $days days
{
    $db_threads_get_by_days = db_connect();

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($days)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships.

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query. We only join on the USER_FOLDER, USER_PEER and USER_THREAD tables
    // if the user is NOT a guest.

    if (user_is_guest()) {

        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, ";
        $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
        $sql.= "THREAD_STATS.VIEWCOUNT, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql.= "USER.LOGON, USER.NICKNAME FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
        $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql.= "WHERE THREAD.FID IN ($folders) AND THREAD.LENGTH > 0 ";
        $sql.= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) < $days ";
        $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql.= "LIMIT 0, 50";

    }else {

        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
        $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ,  USER_THREAD.INTEREST, ";
        $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
        $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
        $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
        $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
        $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
        $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
        $sql.= "WHERE THREAD.FID IN ($folders) ";
        $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
        $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
        $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
        $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
        $sql.= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) < $days ";
        $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
        $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
        $sql.= "AND THREAD.LENGTH > 0 ";
        $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql.= "LIMIT 0, 50";
    }

    $result = db_query($sql, $db_threads_get_by_days);
    return threads_process_list($result);
}

function threads_get_by_interest($uid, $interest = 1) // get messages for $uid by interest (default High Interest)
{
    $db_threads_get_by_interest = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($interest)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ,  USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql.= "AND USER_THREAD.INTEREST = $interest ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_by_interest);
    return threads_process_list($result);
}

function threads_get_unread_by_interest($uid, $interest = 1) // get unread messages for $uid by interest (default High Interest)
{
    $db_threads_get_unread_by_interest = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($interest)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ,  USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql.= "AND USER_THREAD.INTEREST = $interest ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_unread_by_interest);
    return threads_process_list($result);
}

function threads_get_recently_viewed($uid) // get messages recently seem by $uid
{
    $db_threads_get_recently_viewed = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ,  USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql.= "AND TO_DAYS(NOW()) - TO_DAYS(USER_THREAD.LAST_READ_AT) <= 1 ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_recently_viewed);
    return threads_process_list($result);
}

function threads_get_by_relationship($uid, $relationship = USER_FRIEND, $start = 0) // get threads started by people of a particular relationship (default friend)
{
    $db_threads_get_by_relationship = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($relationship)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    $result = db_query($sql, $db_threads_get_by_relationship);
    return threads_process_list($result);
}

function threads_get_unread_by_relationship($uid, $relationship = USER_FRIEND) // get unread messages started by people of a particular relationship (default friend)
{
    $db_threads_get_unread = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($relationship)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages are disabled.

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_unread);
    return threads_process_list($result);
}

function threads_get_polls($uid, $start = 0)
{
    $db_threads_get_polls = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.POLL_FLAG = 'Y' ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    $result = db_query($sql, $db_threads_get_polls);
    return threads_process_list($result);
}

function threads_get_sticky($uid, $start = 0)
{
    $db_threads_get_all = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.STICKY = 'Y' ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    $result = db_query($sql, $db_threads_get_all);
    return threads_process_list($result);
}

function threads_get_longest_unread($uid) // get unread messages for $uid
{
    $db_threads_get_unread = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "THREAD.LENGTH - IF (USER_THREAD.LAST_READ, USER_THREAD.LAST_READ, 0) AS T_LENGTH, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY T_LENGTH DESC, THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_unread);
    return threads_process_list($result);
}

function threads_get_folder($uid, $fid, $start = 0)
{
    $db_threads_get_folder = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($fid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available_array()) return array(0, 0);

    // Check to make sure the specified folder is available to the user.

    if (!in_array($fid, $folders)) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($fid) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    $result = db_query($sql, $db_threads_get_folder);
    return threads_process_list($result);
}

function threads_get_deleted($uid, $start = 0)
{
    $db_threads_get_all = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Only Admins can view deleted threads.

    if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.LENGTH = 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    $result = db_query($sql, $db_threads_get_all);
    return threads_process_list($result);
}

function threads_get_unread_by_days($uid, $days = 0) // get unread messages for $uid
{
    $db_threads_get_unread = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($days)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "USER_FOLDER.INTEREST AS FOLDER_INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) <= $days ";
    $sql.= "AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    $result = db_query($sql, $db_threads_get_unread);
    return threads_process_list($result);
}

function threads_get_most_recent($limit = 10, $fid_list = false, $creation_order = false)
{
    $db_threads_get_recent = db_connect();

    // If there are any problems with the function arguments we bail out.
    
    if (!is_numeric($limit)) return false;

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return false;

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return false;

    // If we have an array of folders we should only
    // use the ones the user can see.

    if (is_array($fid_list) && sizeof($fid_list) > 0) {

        foreach($fid_list as $key => $fid) {
            if (!in_array($fid, explode(", ", $folders))) {
                unset($fid_list[$key]);
            }
        }

        if (sizeof($fid_list) > 0) {
            $folders = implode(",", $fid_list);
        }
    }

    // Do we want to sort by thread created or thread modified?

    if ($creation_order === true) {
        $order_by = "THREAD.CREATED DESC";
    }else {
        $order_by = "THREAD.MODIFIED DESC";
    }

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Thread cut off period for unread type messages

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    if (user_is_guest()) {

        $sql = "SELECT THREAD.TID, THREAD.TITLE, THREAD.STICKY, ";
        $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD_STATS.VIEWCOUNT, ";
        $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql.= "USER.NICKNAME, USER.LOGON ";
        $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
        $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql.= "WHERE THREAD.FID IN ($folders) AND THREAD.LENGTH > 0 ";
        $sql.= "ORDER BY $order_by ";
        $sql.= "LIMIT 0, $limit";

    }else {

        $sql = "SELECT THREAD.TID, THREAD.TITLE, THREAD.STICKY, ";
        $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, USER_THREAD.LAST_READ, ";
        $sql.= "THREAD_STATS.VIEWCOUNT, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql.= "USER_PEER.RELATIONSHIP, USER_THREAD.INTEREST, ";
        $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER.LOGON, ";
        $sql.= "THREAD_STATS.UNREAD_PID FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
        $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
        $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = $uid) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
        $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = $uid) ";
        $sql.= "WHERE THREAD.FID IN ($folders) ";
        $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
        $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
        $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
        $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
        $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
        $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
        $sql.= "AND THREAD.LENGTH > 0 ";
        $sql.= "ORDER BY $order_by ";
        $sql.= "LIMIT 0, $limit";
    }

    $result = db_query($sql, $db_threads_get_recent);

    if (db_num_rows($result) > 0) {

        $threads_get_array = array();
        $tid_array = array();

        while ($thread = db_fetch_array($result)) {

            if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;
            if (!isset($thread['INTEREST'])) $thread['INTEREST'] = 0;

            if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

                $thread['LAST_READ'] = 0;
                
                if (isset($thread['MODIFIED']) && $thread['MODIFIED'] < $unread_cutoff_stamp) {
                    $thread['LAST_READ'] = $thread['LENGTH'];
                }elseif (isset($thread['UNREAD_PID']) && !is_null($thread['UNREAD_PID']) && $thread['UNREAD_PID'] > 0) {
                    $thread['LAST_READ'] = $thread['UNREAD_PID'];
                }
            }

            $threads_get_array[$thread['TID']] = $thread;
            $tid_array[] = $thread['TID'];

            if (isset($polldata['PEER_NICKNAME'])) {
                if (!is_null($polldata['PEER_NICKNAME']) && strlen($polldata['PEER_NICKNAME']) > 0) {
                    $polldata['NICKNAME'] = $polldata['PEER_NICKNAME'];
                }
            }
        }

        threads_have_attachments($threads_get_array, $tid_array);
        return $threads_get_array;
    }
        
    return false;
}

// Arrange the results of a query into the right order for display

function threads_process_list($result)
{
    // Default to returning no threads.

    $threads_array = 0;
    $folder = 0;
    $folder_order = 0;

    // Thread cut off period for unread type messages

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    // Check that the set of threads returned is not empty

    if (db_num_rows($result) > 0) {

        // Record the TIDs as we go for later attachment checking.
        
        $tid_array = array();

        // If the user has clicked on a folder header, we want
        // that folder to be first in the list

        if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
            $folder = $_GET['folder'];
            $folder_order = array($_GET['folder']);
        }

        // Loop through the results and construct an array to return

        while ($thread = db_fetch_array($result, DB_RESULT_ASSOC)) {

            if (!isset($thread['FOLDER_INTEREST'])) $thread['FOLDER_INTEREST'] = 0;
            if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;
            if (!isset($thread['INTEREST'])) $thread['INTEREST'] = 0;
            if (!isset($thread['STICKY'])) $thread['STICKY'] = 0;
            if (!isset($thread['VIEWCOUNT'])) $thread['VIEWCOUNT'] = 0;

            // If this folder ID has not been encountered before,
            // make it the next folder in the order to be displayed

            if (!is_array($folder_order)) {
                $folder_order = array($thread['FID']);
            }else {
                if (!in_array($thread['FID'], $folder_order)) {
                    $folder_order[] = $thread['FID'];
                }
            }

            if (!is_array($threads_array)) $threads_array = array();

            // LAST_READ may not be set or may be null. If the user
            // is viewing posts in an unread state and LAST_READ is
            // not set we check to see how old the thread is before
            // we mark it as unread.

            if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

                $thread['LAST_READ'] = 0;
                
                if (isset($thread['MODIFIED']) && $thread['MODIFIED'] < $unread_cutoff_stamp) {
                    $thread['LAST_READ'] = $thread['LENGTH'];
                }elseif (isset($thread['UNREAD_PID']) && !is_null($thread['UNREAD_PID']) && $thread['UNREAD_PID'] > 0) {
                    $thread['LAST_READ'] = $thread['UNREAD_PID'];
                }
            }

            if (isset($thread['PEER_NICKNAME'])) {
                if (!is_null($thread['PEER_NICKNAME']) && strlen($thread['PEER_NICKNAME']) > 0) {
                    $thread['NICKNAME'] = $thread['PEER_NICKNAME'];
                }
            }

            $threads_array[$thread['TID']] = $thread;
            $tid_array[] = $thread['TID'];
        }

        threads_have_attachments($threads_array, $tid_array);
    }

    // $threads_array is the array with thread information,
    // $folder_order is a list of FIDs in the order
    // in which the folders should be displayed

    return array($threads_array, $folder_order);
}

function threads_get_folder_msgs()
{
    $folder_msgs = array();
    $db_threads_get_folder_msgs = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT FID, COUNT(*) AS TOTAL FROM {$table_data['PREFIX']}THREAD GROUP BY FID";
    $result = db_query($sql, $db_threads_get_folder_msgs);

    while($folder = db_fetch_array($result)){
        $folder_msgs[$folder['FID']] = $folder['TOTAL'];
    }

    return $folder_msgs;
}

function threads_any_unread()
{
    $db_threads_any_unread = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $fidlist = folder_get_available();

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    $sql = "SELECT THREAD.TID FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql.= "WHERE (USER_THREAD.LAST_READ < THREAD.LENGTH) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) AND THREAD.FID IN ($fidlist) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_threads_any_unread);

    return (db_num_rows($result) > 0);
}

function threads_mark_all_read()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $db_threads_mark_all_read = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    // Mark as read cut off

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return array(0, 0);

    if (db_fetch_mysql_version() >= 40116) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "SELECT $uid, {$table_data['PREFIX']}THREAD.TID, {$table_data['PREFIX']}THREAD.LENGTH, NOW(), ";
        $sql.= "{$table_data['PREFIX']}USER_THREAD.INTEREST FROM {$table_data['PREFIX']}THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD ON ";
        $sql.= "({$table_data['PREFIX']}USER_THREAD.TID = {$table_data['PREFIX']}THREAD.TID ";
        $sql.= "AND {$table_data['PREFIX']}USER_THREAD.UID = $uid) ";
        $sql.= "WHERE {$table_data['PREFIX']}THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

        $result_threads = db_query($sql, $db_threads_mark_all_read);

        return $result_threads;

    }else {

        $sql = "SELECT THREAD.TID, THREAD.LENGTH, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED ";
        $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
        $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
        $sql.= "WHERE (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
        $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "ORDER BY THREAD.MODIFIED";

        $result_threads = db_query($sql, $db_threads_mark_all_read);

        $threads_array = array();

        while($thread_data = db_fetch_array($result_threads)) {
            $threads_array[$thread_data['TID']] = $thread_data;
        }

        return threads_mark_read($threads_array);
    }
}

function threads_mark_50_read()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $db_threads_mark_50_read = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    // Mark as read cut off

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;

    if (db_fetch_mysql_version() >= 40116) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "SELECT $uid, {$table_data['PREFIX']}THREAD.TID, {$table_data['PREFIX']}THREAD.LENGTH, NOW(), ";
        $sql.= "{$table_data['PREFIX']}USER_THREAD.INTEREST FROM {$table_data['PREFIX']}THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD ON ";
        $sql.= "({$table_data['PREFIX']}USER_THREAD.TID = {$table_data['PREFIX']}THREAD.TID ";
        $sql.= "AND {$table_data['PREFIX']}USER_THREAD.UID = $uid) ";
        $sql.= "WHERE {$table_data['PREFIX']}THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "LIMIT 0, 50 ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ) ";

        $result_threads = db_query($sql, $db_threads_mark_50_read);

        return $result_threads;

    }else {

        $sql = "SELECT THREAD.TID, THREAD.LENGTH, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED ";
        $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
        $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
        $sql.= "WHERE (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
        $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 50";

        $result_threads = db_query($sql, $db_threads_mark_50_read);

        $threads_array = array();

        while($thread_data = db_fetch_array($result_threads)) {
            $threads_array[$thread_data['TID']] = $thread_data;
        }

        return threads_mark_read($threads_array);
    }
}

function threads_mark_folder_read($fid)
{
    $db_threads_mark_folder_read = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Mark as read cut off

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (db_fetch_mysql_version() >= 40116) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "SELECT $uid, {$table_data['PREFIX']}THREAD.TID, {$table_data['PREFIX']}THREAD.LENGTH, NOW(), ";
        $sql.= "{$table_data['PREFIX']}USER_THREAD.INTEREST FROM {$table_data['PREFIX']}THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD ON ";
        $sql.= "({$table_data['PREFIX']}USER_THREAD.TID = {$table_data['PREFIX']}THREAD.TID ";
        $sql.= "AND {$table_data['PREFIX']}USER_THREAD.UID = $uid) ";
        $sql.= "WHERE {$table_data['PREFIX']}THREAD.FID = '$fid' ";
        $sql.= "AND {$table_data['PREFIX']}THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";
 
        $result_threads = db_query($sql, $db_threads_mark_folder_read);

        return $result_threads;

    }else {

        $sql = "SELECT THREAD.TID, THREAD.LENGTH, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED ";
        $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
        $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
        $sql.= "WHERE (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
        $sql.= "AND THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "AND THREAD.FID = $fid";

        $result_threads = db_query($sql, $db_threads_mark_folder_read);

        $threads_array = array();

        while($thread_data = db_fetch_array($result_threads)) {
            $threads_array[$thread_data['TID']] = $thread_data;
        }

        return threads_mark_read($threads_array);
    }
}

function threads_mark_read($tid_array)
{
    $db_threads_mark_read = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_array($tid_array)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Mark as read cut off
    
    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;

    if (db_fetch_mysql_version() >= 40116) {

        $tid_list = implode(",", array_keys($tid_array));

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_THREAD (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "SELECT $uid, {$table_data['PREFIX']}THREAD.TID, {$table_data['PREFIX']}THREAD.LENGTH, NOW(), ";
        $sql.= "{$table_data['PREFIX']}USER_THREAD.INTEREST FROM {$table_data['PREFIX']}THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD ON ";
        $sql.= "({$table_data['PREFIX']}USER_THREAD.TID = {$table_data['PREFIX']}THREAD.TID ";
        $sql.= "AND {$table_data['PREFIX']}USER_THREAD.UID = $uid) ";
        $sql.= "WHERE {$table_data['PREFIX']}THREAD.TID IN ($tid_list) ";
        $sql.= "AND {$table_data['PREFIX']}THREAD.MODIFIED > FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

        $result_threads = db_query($sql, $db_threads_mark_read);

        return $result_threads;

    }else {
        
        foreach($tid_array as $thread_data) {

            $valid = true;

            if (isset($thread_data['TID']) && is_numeric($thread_data['TID'])) {
                $tid = $thread_data['TID'];
            }else {
                $valid = false;
            }

            if (isset($thread_data['LENGTH']) && is_numeric($thread_data['LENGTH'])) {
                $length = $thread_data['LENGTH'];
            }else {
                $valid = false;
            }

            if (isset($thread_data['MODIFIED']) && is_numeric($thread_data['MODIFIED'])) {
                $modified = $thread_data['MODIFIED'];
            }else {
                $valid = false;
            }

            if ($valid) {

                if (!$result = messages_update_read($tid, $length, $uid, $modified)) {

                    return false;
                }
            }
        }

        return true;
    }
}

function threads_get_unread_data(&$threads_array, $tid_array)
{
    if (!is_array($tid_array)) return false;
    if (sizeof($tid_array) < 1) return false;

    if (!$table_data = get_table_prefix()) return false;

    $tid_list = implode(",", preg_grep("/^[0-9]+$/", $tid_array));

    $db_threads_get_modified = db_connect();

    $sql = "SELECT TID, LENGTH, UNIX_TIMESTAMP(MODIFIED) AS MODIFIED ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD WHERE TID IN ($tid_list)";

    $result = db_query($sql, $db_threads_get_modified);

    if (db_num_rows($result) > 0) {

        while ($thread_data = db_fetch_array($result)) {

            $threads_array[$thread_data['TID']] = $thread_data;
        }

        return true;
    }

    return false;
}

function thread_update_unread_cutoff($tid, $unread_pid, $unread_created)
{
    $db_thread_update_unread_cutoff = db_connect();

    if (!$table_data = get_table_prefix()) return false;
    
    if (!is_numeric($tid)) return false;
    if (!is_numeric($unread_pid)) return false;
    if (!is_numeric($unread_created)) return false;

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD_STATS SET UNREAD_PID = '$unread_pid', ";
    $sql.= "UNREAD_CREATED = FROM_UNIXTIME('$unread_created') WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_update_unread_cutoff)) return false;

    if (db_affected_rows($result) < 1) {

        $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}THREAD_STATS ";
        $sql.= "(TID, UNREAD_PID, UNREAD_CREATED) VALUES ('$tid', ";
        $sql.= "'$unread_pid', FROM_UNIXTIME('$unread_created'))";

        if (!$result = db_query($sql, $db_thread_update_unread_cutoff)) return false;
    }

    return true;
}

function thread_list_draw_top($mode)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "function change_current_thread (thread_id) {\n";
    echo "    if (current_thread > 0) {\n";
    echo "        document[\"t\" + current_thread].src = \"", style_image('bullet.png'), "\";\n";
    echo "    }\n";
    echo "    document[\"t\" + thread_id].src = \"", style_image('current_thread.png'), "\";\n";
    echo "    current_thread = thread_id;\n";
    echo "    return true;\n";
    echo "}\n\n";
    echo "// -->\n";
    echo "</script>\n\n";
    echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('post.png'), "\" alt=\"{$lang['newdiscussion']}\" title=\"{$lang['newdiscussion']}\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"main\">{$lang['newdiscussion']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('poll.png'), "\" alt=\"{$lang['createpoll']}\" title=\"{$lang['createpoll']}\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"main\">{$lang['createpoll']}</a></td>\n";
    echo "  </tr>\n";

    if ($pm_new_count = pm_get_unread_count()) {

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('pmunread.png'), "\" alt=\"{$lang['pminbox']}\" title=\"{$lang['pminbox']}\" />&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"main\">{$lang['pminbox']}</a> <span class=\"pmnewcount\">[$pm_new_count {$lang['unread']}]</span></td>\n";
        echo "  </tr>\n";

    }else {

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('pmread.png'), "\" alt=\"{$lang['pminbox']}\" title=\"{$lang['pminbox']}\" />&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"main\">{$lang['pminbox']}</a></td>\n";
        echo "  </tr>\n";
    }

    echo "</table>\n";
    echo "<br />\n";
    echo "<form name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n";
    echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\">";

    echo "        ", form_input_hidden("webtag", $webtag), "\n";

    if (bh_session_get_value('UID') == 0) {

        $labels = array($lang['alldiscussions'], $lang['todaysdiscussions'], $lang['2daysback'], $lang['7daysback']);
        echo form_dropdown_array("mode", array(0, 3, 4, 5), $labels, $mode, "onchange=\"submit()\"");

    }else {

        if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

            if ($unread_cutoff_stamp !== false) {
            
                $labels = array($lang['alldiscussions'], $lang['unreaddiscussions'], $lang['unreadtome'],
                                $lang['todaysdiscussions'], $lang['unreadtoday'], $lang['2daysback'],
                                $lang['7daysback'], $lang['highinterest'], $lang['unreadhighinterest'],
                                $lang['iverecentlyseen'], $lang['iveignored'], $lang['byignoredusers'],
                                $lang['ivesubscribedto'], $lang['startedbyfriend'], $lang['unreadstartedbyfriend'],
                                $lang['startedbyme'], $lang['polls'], $lang['stickythreads'],
                                $lang['mostunreadposts'], $lang['searchresults'], $lang['deletedthreads']);

                                $keys = range(0, 20);

            }else {

                $labels = array($lang['alldiscussions'], $lang['unreadtome'], $lang['todaysdiscussions'],
                                $lang['2daysback'], $lang['7daysback'], $lang['highinterest'], 
                                $lang['iverecentlyseen'],  $lang['iveignored'], $lang['byignoredusers'],
                                $lang['ivesubscribedto'],  $lang['startedbyfriend'], $lang['startedbyme'], 
                                $lang['polls'],  $lang['stickythreads'], $lang['searchresults'], 
                                $lang['deletedthreads']);

                                $keys = array(0, 2, 3, 5, 6, 7, 9, 10, 11, 12, 13, 15, 16, 17, 19, 20);
            }

        }else {

            if ($unread_cutoff_stamp !== false) {
        
                $labels = array($lang['alldiscussions'], $lang['unreaddiscussions'], $lang['unreadtome'],
                                $lang['todaysdiscussions'], $lang['unreadtoday'], $lang['2daysback'],
                                $lang['7daysback'], $lang['highinterest'], $lang['unreadhighinterest'],
                                $lang['iverecentlyseen'], $lang['iveignored'], $lang['byignoredusers'],
                                $lang['ivesubscribedto'], $lang['startedbyfriend'], $lang['unreadstartedbyfriend'],
                                $lang['startedbyme'], $lang['polls'], $lang['stickythreads'],
                                $lang['mostunreadposts'], $lang['searchresults']);

                                $keys = range(0, 19);
            }else {

                $labels = array($lang['alldiscussions'], $lang['unreadtome'], $lang['todaysdiscussions'], 
                                $lang['2daysback'], $lang['7daysback'], $lang['highinterest'], 
                                $lang['iverecentlyseen'], $lang['iveignored'], $lang['byignoredusers'],
                                $lang['ivesubscribedto'], $lang['startedbyfriend'], $lang['startedbyme'], 
                                $lang['polls'], $lang['stickythreads'], $lang['searchresults']);

                                $keys = array(0, 2, 3, 5, 6, 7, 9, 10, 11, 12, 13, 15, 16, 17, 19);
            }

        }

        echo form_dropdown_array("mode", $keys, $labels, $mode, "onchange=\"submit()\"");
    }

    echo "        ", form_submit("go",$lang['goexcmark']), "\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}

function threads_have_attachments(&$threads_array, $tid_array)
{
    if (!is_array($tid_array)) return false;
    if (sizeof($tid_array) < 1) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $tid_list = implode(",", preg_grep("/^[0-9]+$/", $tid_array));

    $db_thread_has_attachments = db_connect();

    $sql = "SELECT PAI.TID, PAF.AID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "WHERE PAI.FID = $forum_fid AND PAI.TID IN ($tid_list) ";

    $result = db_query($sql, $db_thread_has_attachments);

    while ($row = db_fetch_array($result)) {

        $threads_array[$row['TID']]['AID'] = $row['AID'];
    }
}

function thread_has_attachments($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $db_thread_has_attachments = db_connect();

    $sql = "SELECT PAF.AID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "WHERE PAI.FID = $forum_fid AND PAI.TID = $tid ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_thread_has_attachments);

    return (db_num_rows($result) > 0);
}

function thread_auto_prune_unread_data($force_start = false, $debug_output = false)
{
    $db_thread_prune_unread_data = db_connect();

    if (!is_bool($force_start)) return false;
    if (!is_bool($debug_output)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;

    $unread_rem_prob = intval(forum_get_setting('forum_self_clean_prob', false, 50));

    if ($unread_rem_prob < 1) $unread_rem_prob = 1;
    if ($unread_rem_prob > 100) $unread_rem_prob = 100;

    if ((($mt_result = mt_rand(1, $unread_rem_prob)) == 1) || $force_start === true) {

        $tid_array = array();

        $sql = "SELECT THREAD.TID, THREAD.LENGTH, ";
        $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED ";
        $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
        $sql.= "ON (USER_THREAD.TID = THREAD.TID) ";
        $sql.= "WHERE USER_THREAD.LAST_READ IS NOT NULL ";
        $sql.= "AND THREAD.MODIFIED < FROM_UNIXTIME('$unread_cutoff_stamp') ";
        $sql.= "GROUP BY THREAD.TID ";
        
        if ($force_start !== true) $sql.= "LIMIT 0, 5";

        if (!$result = db_query($sql, $db_thread_prune_unread_data)) return false;

        if (db_num_rows($result) > 0) {

            while ($row = db_fetch_array($result)) {
                
                if ($debug_output === true) {

                    echo "Updating thread unread cutoff for thread: {$row['TID']}<br />\n";
                    install_flush_buffer();
                }
                
                thread_update_unread_cutoff($row['TID'], $row['LENGTH'], $row['MODIFIED']);
                $tid_array[] = $row['TID'];
            }

            if (sizeof($tid_array) > 0) {

                $tid_list = implode(", ", $tid_array);

                if ($debug_output === true) {

                    echo "Pruning thread unread data for threads: $tid_list<br />\n";
                    install_flush_buffer();
                }

                $sql = "DELETE LOW_PRIORITY FROM {$table_data['PREFIX']}USER_THREAD ";
                $sql.= "WHERE TID IN ($tid_list) AND INTEREST = 0";

                if (!$result = db_query($sql, $db_thread_prune_unread_data)) return false;

                return true;
            }
        }
    }

    return false;
}

function threads_get_user_subscriptions($include_threads = array(), $interest_type = 0, $offset = 0)
{
    $db_threads_get_user_subscriptions = db_connect();

    $thread_array = array();
    $thread_count = 0;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($interest_type)) $interest_type = 0;
    if (!is_array($include_threads)) $include_threads = array();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT COUNT(THREAD.TID) FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";

    if ($interest_type <> 0) {
        $sql.= "WHERE USER_THREAD.INTEREST = '$interest_type' ";
    }else {
        $sql.= "WHERE USER_THREAD.INTEREST <> 0 ";
    }

    if (isset($include_threads) && sizeof($include_threads) > 0) {

        $threads_list = implode("', '", preg_grep("/^[0-9]+$/", $include_threads));
        $sql.= "OR THREAD.TID IN ('$threads_list') ";
    }

    $result = db_query($sql, $db_threads_get_user_subscriptions);
    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT THREAD.TID, THREAD.TITLE, USER_THREAD.INTEREST ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";

    if ($interest_type <> 0) {
        $sql.= "WHERE USER_THREAD.INTEREST = '$interest_type' ";
    }else {
        $sql.= "WHERE USER_THREAD.INTEREST <> 0 ";
    }

    if (isset($include_threads) && sizeof($include_threads) > 0) {

        $threads_list = implode("', '", preg_grep("/^[0-9]+$/", $include_threads));
        $sql.= "OR THREAD.TID IN ('$threads_list') ";
    }

    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_threads_get_user_subscriptions);

    if (db_num_rows($result) > 0) {

        while ($thread_data = db_fetch_array($result)) {

            $thread_array[] = $thread_data;
        }
    }
    
    return array('thread_count' => $thread_count,
                 'thread_array' => $thread_array);
}

function threads_search_user_subscriptions($threadsearch, $include_threads = array(), $interest_type = 0, $offset = 0)
{
    $db_threads_search_user_subscriptions = db_connect();

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($interest_type)) $interest_type = 0;
    if (!is_array($include_threads)) $include_threads = array();

    if (!$table_data = get_table_prefix()) return false;

    $threadsearch = addslashes($threadsearch);

    $thread_array = array();
    $thread_count = 0;

    $uid = bh_session_get_value('UID');

    $bool_mode = (db_fetch_mysql_version() > 40010) ? " IN BOOLEAN MODE" : "";

    $sql = "SELECT COUNT(THREAD.TID) FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";

    if ($interest_type <> 0) {
        $sql.= "WHERE USER_THREAD.INTEREST = '$interest_type' ";
    }else {
        $sql.= "WHERE USER_THREAD.INTEREST <> 0 ";
    }

    $sql.= "AND MATCH (THREAD.TITLE) AGAINST('$threadsearch'$bool_mode) ";

    if (isset($include_threads) && sizeof($include_threads) > 0) {

        $threads_list = implode("', '", preg_grep("/^[0-9]+$/", $include_threads));
        $sql.= "OR THREAD.TID IN ('$threads_list') ";
    }
    
    $result = db_query($sql, $db_threads_search_user_subscriptions);
    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT THREAD.TID, THREAD.TITLE, USER_THREAD.INTEREST ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";

    if ($interest_type <> 0) {
        $sql.= "WHERE USER_THREAD.INTEREST = '$interest_type' ";
    }else {
        $sql.= "WHERE USER_THREAD.INTEREST <> 0 ";
    }

    $sql.= "AND MATCH (THREAD.TITLE) AGAINST('$threadsearch'$bool_mode) ";

    if (isset($include_threads) && sizeof($include_threads) > 0) {

        $threads_list = implode("', '", preg_grep("/^[0-9]+$/", $include_threads));
        $sql.= "OR THREAD.TID IN ('$threads_list') ";
    }

    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_threads_search_user_subscriptions);

    if (db_num_rows($result) > 0) {

        while ($thread_data = db_fetch_array($result)) {

            $thread_array[] = $thread_data;
        }
    }
    
    return array('thread_count' => $thread_count,
                 'thread_array' => $thread_array);
}

?>