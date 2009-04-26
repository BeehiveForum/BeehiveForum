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

/* $Id: threads.inc.php,v 1.352 2009-04-26 13:01:11 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
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

    if (!$db_threads_get_folders = db_connect()) return false;

    $access_allowed = USER_PERM_POST_READ;

    if (!$table_data = get_table_prefix()) return false;
    if (!is_numeric($access_allowed)) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, USER_FOLDER.INTEREST ";
    $sql.= "FROM `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "ORDER BY USER_FOLDER.INTEREST DESC, FOLDER.POSITION";

    if (!$result = db_query($sql, $db_threads_get_folders)) return false;

    if (db_num_rows($result) > 0) {

        $folder_info = array();

        while (($folder_data = db_fetch_array($result))) {

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

function threads_get_all($uid, $start_from = 0) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    if (!$db_threads_get_all = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start_from)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships.

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query.

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    if (!$result = db_query($sql, $db_threads_get_all)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_started_by_me($uid) // get threads started by user
{
    if (!$db_threads_get_started_by_me = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    
    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view unread messages.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.BY_UID = '$uid' AND THREAD.FID IN ($folders) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_started_by_me)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_unread($uid) // get unread messages for $uid
{
    if (!$db_threads_get_unread = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view unread messages.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationship

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_unread)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_unread_to_me($uid) // get unread messages to $uid (ignores folder interest level)
{
    if (!$db_threads_get_unread_to_me = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view unread messages.

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND POST.TO_UID = '$uid' AND POST.VIEWED IS NULL ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_unread_to_me)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_by_days($uid, $days = 1) // get threads from the last $days days
{
    if (!$db_threads_get_by_days = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($days)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships.

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;
    
    // Generate datetime for '$days' days ago.
    
    $threads_modified_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($days * DAY_IN_SECONDS));

    // Formulate query.

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.MODIFIED >= CAST('$threads_modified_datetime' AS DATETIME) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_by_days)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_by_interest($uid, $interest = THREAD_INTERESTED) // get messages for $uid by interest (default High Interest)
{
    if (!$db_threads_get_by_interest = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($interest)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql.= "AND USER_THREAD.INTEREST = '$interest' ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_by_interest)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_unread_by_interest($uid, $interest = THREAD_INTERESTED) // get unread messages for $uid by interest (default High Interest)
{
    if (!$db_threads_get_unread_by_interest = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($interest)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql.= "AND USER_THREAD.INTEREST = '$interest' ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_unread_by_interest)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_recently_viewed($uid) // get messages recently seem by $uid
{
    if (!$db_threads_get_recently_viewed = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;
    
    // Generate datetime for yesterday
    
    $threads_viewed_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - DAY_IN_SECONDS);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql.= "AND USER_THREAD.LAST_READ_AT >= CAST('$threads_viewed_datetime' AS DATETIME) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_recently_viewed)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_by_relationship($uid, $relationship = USER_FRIEND) // get threads started by people of a particular relationship (default friend)
{
    if (!$db_threads_get_by_relationship = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($relationship)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_by_relationship)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_unread_by_relationship($uid, $relationship = USER_FRIEND) // get unread messages started by people of a particular relationship (default friend)
{
    if (!$db_threads_get_unread = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($relationship)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Check to see if unread messages are disabled.

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_unread)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_polls($uid)
{
    if (!$db_threads_get_polls = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.POLL_FLAG = 'Y' ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_polls)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_sticky($uid)
{
    if (!$db_threads_get_all = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed because even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.STICKY = 'Y' ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_all)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_longest_unread($uid) // get unread messages for $uid
{
    if (!$db_threads_get_unread = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Guests can't view this thread type

    if (user_is_guest()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders = folder_get_available()) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0);

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD.LENGTH - IF (USER_THREAD.LAST_READ, USER_THREAD.LAST_READ, 0) AS T_LENGTH, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql.= "ORDER BY T_LENGTH DESC, THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_unread)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_folder($uid, $fid, $start = 0)
{
    if (!$db_threads_get_folder = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($fid)) return array(0, 0);
    if (!is_numeric($start)) return array(0, 0);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return array(0, 0);

    // Get the folders the user can see.

    if (!$folders_array = folder_get_available_array()) return array(0, 0);

    // Check to make sure the specified folder is available to the user.

    if (!in_array($fid, $folders_array)) return array(0, 0);

    // Constants for user relationships

    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($fid) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start, 50";

    if (!$result = db_query($sql, $db_threads_get_folder)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_deleted($uid)
{
    if (!$db_threads_get_all = db_connect()) return array(0, 0);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($uid)) return array(0, 0);

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

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'Y' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_all)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_unread_by_days($uid, $days = 0) // get unread messages for $uid
{
    if (!$db_threads_get_unread = db_connect()) return array(0, 0);

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

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0);
    
    // Generate datetime for '$days' days ago.
    
    $threads_modified_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($days * DAY_IN_SECONDS));

    // Formulate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.MODIFIED >= CAST('$threads_modified_datetime' AS DATETIME) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT 0, 50";

    if (!$result = db_query($sql, $db_threads_get_unread)) return array(0, 0);

    return threads_process_list($result);
}

function threads_get_most_recent($limit = 10, $folder_list_array = array(), $creation_order = false)
{
    if (!$db_threads_get_recent = db_connect()) return false;

    // Language file

    $lang = lang::get_instance()->load(__FILE__);

    // If there are any problems with the function arguments we bail out.

    if (!is_numeric($limit)) return false;

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.

    if (!$table_data = get_table_prefix()) return false;

    // Get the folders the user can see.

    if (!$available_folders_array = folder_get_available_array()) return false;

    // If we have an array of folders we should only
    // use the ones the user can see.

    if (is_array($folder_list_array) && sizeof($folder_list_array) > 0) {

        $available_folders_preg = implode("$|^", array_map('preg_quote_callback', $available_folders_array));
        $folder_list_array = preg_grep("/^$available_folders_preg$/Du", $folder_list_array);
    }

    // Convert the array into a comma-separated list.

    if (is_array($folder_list_array) && sizeof($folder_list_array) > 0) {
        $folders = implode(',', $folder_list_array);
    }else {
        $folders = implode(',', $available_folders_array);
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

    // User UID

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Unread cutoff

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    // Forumlate query

    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
    $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, THREAD.UNREAD_PID, ";
    $sql.= "THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, USER_THREAD.INTEREST, ";
    $sql.= "FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "THREAD_TRACK.TRACK_TYPE FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_TRACK` THREAD_TRACK ";
    $sql.= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS ";
    $sql.= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.FID IN ($folders) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY $order_by ";
    $sql.= "LIMIT 0, $limit";

    if (!$result = db_query($sql, $db_threads_get_recent)) return false;

    if (db_num_rows($result) > 0) {

        $threads_get_array = array();

        while (($thread = db_fetch_array($result))) {

            if (isset($thread['LOGON']) && isset($thread['PEER_NICKNAME'])) {
                if (!is_null($thread['PEER_NICKNAME']) && strlen($thread['PEER_NICKNAME']) > 0) {
                    $thread['NICKNAME'] = $thread['PEER_NICKNAME'];
                }
            }

            if (!isset($thread['LOGON'])) $thread['LOGON'] = $lang['unknownuser'];
            if (!isset($thread['NICKNAME'])) $thread['NICKNAME'] = "";

            if (!isset($thread['RELATIONSHIP']) || is_null($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;
            if (!isset($thread['INTEREST']) || is_null($thread['INTEREST'])) $thread['INTEREST'] = 0;
            if (!isset($thread['STICKY']) || is_null($thread['STICKY'])) $thread['STICKY'] = 0;
            if (!isset($thread['VIEWCOUNT']) || is_null($thread['VIEWCOUNT'])) $thread['VIEWCOUNT'] = 0;
            if (!isset($thread['PREFIX']) || is_null($thread['PREFIX'])) $thread['PREFIX'] = "";
            if (!isset($thread['TRACK_TYPE']) || is_null($thread['TRACK_TYPE'])) $thread['TRACK_TYPE'] = -1;
            if (!isset($thread['DELETED']) || is_null($thread['DELETED'])) $thread['DELETED'] = 'N';

            if (user_is_guest()) {

                $thread['LAST_READ'] = 0;

            }else if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

                $thread['LAST_READ'] = 0;

                if (isset($thread['MODIFIED']) && $unread_cutoff_timestamp !== false && $thread['MODIFIED'] < $unread_cutoff_timestamp) {
                    $thread['LAST_READ'] = $thread['LENGTH'];
                }else if (isset($thread['UNREAD_PID']) && is_numeric($thread['UNREAD_PID'])) {
                    $thread['LAST_READ'] = $thread['UNREAD_PID'];
                }
            }

            $threads_get_array[$thread['TID']] = $thread;
        }

        threads_have_attachments($threads_get_array);
        return $threads_get_array;
    }

    return false;
}

function threads_get_unread_cutoff()
{
    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;
    
    list($year, $month, $day) = explode('-', date(MYSQL_DATE, time()));
    
    return (mktime(0, 0, 0, $month, $day, $year) - $unread_cutoff_stamp);
}

// Arrange the results of a query into the right order for display

function threads_process_list($result)
{
    // Language file

    $lang = lang::get_instance()->load(__FILE__);

    // Unread cutoff

    $unread_cutoff_timestamp = threads_get_unread_cutoff();
    
    // Check for a specified folder
    
    if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
        $folder_order = array($_GET['folder']);
    }    

    if (db_num_rows($result) > 0) {
    
        $threads_array = array();
        
        while (($thread = db_fetch_array($result, DB_RESULT_ASSOC))) {
                    
            if (isset($thread['LOGON']) && isset($thread['PEER_NICKNAME'])) {
                if (!is_null($thread['PEER_NICKNAME']) && strlen($thread['PEER_NICKNAME']) > 0) {
                    $thread['NICKNAME'] = $thread['PEER_NICKNAME'];
                }
            }

            if (!isset($thread['LOGON'])) $thread['LOGON'] = $lang['unknownuser'];
            if (!isset($thread['NICKNAME'])) $thread['NICKNAME'] = "";        

            if (!isset($thread['RELATIONSHIP']) || is_null($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;
            if (!isset($thread['INTEREST']) || is_null($thread['INTEREST'])) $thread['INTEREST'] = 0;
            if (!isset($thread['STICKY']) || is_null($thread['STICKY'])) $thread['STICKY'] = 0;
            if (!isset($thread['VIEWCOUNT']) || is_null($thread['VIEWCOUNT'])) $thread['VIEWCOUNT'] = 0;
            if (!isset($thread['PREFIX']) || is_null($thread['PREFIX'])) $thread['PREFIX'] = "";
            if (!isset($thread['TRACK_TYPE']) || is_null($thread['TRACK_TYPE'])) $thread['TRACK_TYPE'] = -1;
            if (!isset($thread['DELETED']) || is_null($thread['DELETED'])) $thread['DELETED'] = 'N';

            if (!isset($folder_order) || !is_array($folder_order)) {
                $folder_order = array($thread['FID']);
            }else {
                if (!in_array($thread['FID'], $folder_order)) {
                    $folder_order[] = $thread['FID'];
                }
            }

            if (user_is_guest()) {

                $thread['LAST_READ'] = 0;

            }else if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

                $thread['LAST_READ'] = 0;

                if (isset($thread['MODIFIED']) && $unread_cutoff_timestamp !== false && $thread['MODIFIED'] < $unread_cutoff_timestamp) {
                    $thread['LAST_READ'] = $thread['LENGTH'];
                }else if (isset($thread['UNREAD_PID']) && is_numeric($thread['UNREAD_PID'])) {
                    $thread['LAST_READ'] = $thread['UNREAD_PID'];
                }
            }

            $threads_array[$thread['TID']] = $thread;
        }

        threads_have_attachments($threads_array);
        return array($threads_array, $folder_order);
    }
    
    return array(0, 0);
}

function threads_get_folder_msgs()
{
    $folder_msgs = array();

    if (!$db_threads_get_folder_msgs = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT FID, COUNT(TID) AS TOTAL FROM `{$table_data['PREFIX']}THREAD` GROUP BY FID";

    if (!$result = db_query($sql, $db_threads_get_folder_msgs)) return false;

    while (($folder = db_fetch_array($result))) {
        $folder_msgs[$folder['FID']] = $folder['TOTAL'];
    }

    return $folder_msgs;
}

function threads_any_unread()
{
    if (!$db_threads_any_unread = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $fidlist = folder_get_available();

    $user_ignored = USER_IGNORED;

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $sql = "SELECT COUNT(THREAD.TID) AS UNREAD_THREAD_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ON ";
    $sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_FOLDER` USER_FOLDER ON ";
    $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1)";

    if (!$result = db_query($sql, $db_threads_any_unread)) return false;

    list($unread_thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($unread_thread_count > 0);
}

function threads_mark_all_read()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$db_threads_mark_all_read = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;
    
    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql.= "SELECT $uid, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') WHERE (THREAD.LENGTH > USER_THREAD.LAST_READ ";
    $sql.= "OR USER_THREAD.LAST_READ IS NULL) AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!db_query($sql, $db_threads_mark_all_read)) return false;

    return true;
}

function threads_mark_50_read()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$db_threads_mark_50_read = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;
    
    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql.= "SELECT $uid, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') WHERE (THREAD.LENGTH > USER_THREAD.LAST_READ ";
    $sql.= "OR USER_THREAD.LAST_READ IS NULL) AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 50 ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!db_query($sql, $db_threads_mark_50_read)) return false;

    return true;
}

function threads_mark_folder_read($fid)
{
    if (!$db_threads_mark_folder_read = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;
    
    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql.= "SELECT $uid, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') WHERE THREAD.FID = '$fid' ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (THREAD.LENGTH > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!db_query($sql, $db_threads_mark_folder_read)) return false;

    return true;
}

function threads_mark_read($tid_array)
{
    if (!$db_threads_mark_read = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_array($tid_array)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $tid_list = implode(",", array_keys($tid_array));
    
    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql.= "SELECT $uid, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime') AS DATETIME, USER_THREAD.INTEREST ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') WHERE THREAD.TID IN ($tid_list) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (THREAD.LENGTH > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!db_query($sql, $db_threads_mark_read)) return false;

    return true;
}

function threads_get_unread_data(&$threads_array, $tid_array)
{
    if (!is_array($tid_array)) return false;
    if (sizeof($tid_array) < 1) return false;

    if (!$table_data = get_table_prefix()) return false;

    $tid_list = implode(",", preg_grep("/^[0-9]+$/Du", $tid_array));

    if (!$db_threads_get_modified = db_connect()) return false;

    $sql = "SELECT TID, LENGTH, LENGTH AS LAST_READ, UNIX_TIMESTAMP(MODIFIED) AS MODIFIED ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` WHERE TID IN ($tid_list)";

    if (!$result = db_query($sql, $db_threads_get_modified)) return false;

    if (db_num_rows($result) > 0) {

        while (($thread_data = db_fetch_array($result))) {

            $threads_array[$thread_data['TID']] = $thread_data;
        }

        return true;
    }

    return false;
}

function thread_list_draw_top($mode)
{
    $lang = lang::get_instance()->load(__FILE__);

    $webtag = get_webtag();

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "function change_current_thread (thread_id)\n";
    echo "{\n";
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
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('post.png'), "\" alt=\"{$lang['newdiscussion']}\" title=\"{$lang['newdiscussion']}\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['newdiscussion']}</a></td>\n";
    echo "  </tr>\n";

    if (forum_get_setting('allow_polls', 'Y')) {

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('poll.png'), "\" alt=\"{$lang['createpoll']}\" title=\"{$lang['createpoll']}\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['createpoll']}</a></td>\n";
        echo "  </tr>\n";
    }

    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('search.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" />&nbsp;<a href=\"search.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['search']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('pmunread.png'), "\" alt=\"{$lang['pminbox']}\" title=\"{$lang['pminbox']}\" />&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['pminbox']}</a> <span class=\"pmnewcount\" id=\"pm_message_count\"></span></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";

    if (user_is_guest()) {

        $available_views = array(ALL_DISCUSSIONS    => $lang['alldiscussions'],
                                 TODAYS_DISCUSSIONS => $lang['todaysdiscussions'],
                                 TWO_DAYS_BACK      => $lang['2daysback'],
                                 SEVEN_DAYS_BACK    => $lang['7daysback']);

    }else {

        $available_views = array(ALL_DISCUSSIONS          => $lang['alldiscussions'],
                                 UNREAD_DISCUSSIONS       => $lang['unreaddiscussions'],
                                 UNREAD_DISCUSSIONS_TO_ME => $lang['unreadtome'],
                                 TODAYS_DISCUSSIONS       => $lang['todaysdiscussions'],
                                 UNREAD_TODAY             => $lang['unreadtoday'],
                                 TWO_DAYS_BACK            => $lang['2daysback'],
                                 SEVEN_DAYS_BACK          => $lang['7daysback'],
                                 HIGH_INTEREST            => $lang['highinterest'],
                                 UNREAD_HIGH_INTEREST     => $lang['unreadhighinterest'],
                                 RECENTLY_SEEN            => $lang['iverecentlyseen'],
                                 IGNORED_THREADS          => $lang['iveignored'],
                                 BY_IGNORED_USERS         => $lang['byignoredusers'],
                                 SUBSCRIBED_TO            => $lang['ivesubscribedto'],
                                 STARTED_BY_FRIEND        => $lang['startedbyfriend'],
                                 UNREAD_STARTED_BY_FRIEND => $lang['unreadstartedbyfriend'],
                                 STARTED_BY_ME            => $lang['startedbyme'],
                                 POLL_THREADS             => $lang['polls'],
                                 STICKY_THREADS           => $lang['stickythreads'],
                                 MOST_UNREAD_POSTS        => $lang['mostunreadposts'],
                                 SEARCH_RESULTS           => $lang['searchresults'],
                                 DELETED_THREADS          => $lang['deletedthreads']);

        if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

            if ($unread_cutoff_stamp === false) {

                // Remove unread thread options (Unread Discussions, Unread Today,
                // Unread High Interest, Unread Started By Friend, Most Unread Posts).

                unset($available_views[UNREAD_DISCUSSIONS], $available_views[UNREAD_TODAY], $available_views[UNREAD_HIGH_INTEREST]);
                unset($available_views[UNREAD_STARTED_BY_FRIEND], $available_views[MOST_UNREAD_POSTS]);
            }

        }else {

            // Remove Admin Deleted Threads option.

            unset($available_views[DELETED_THREADS]);

            if ($unread_cutoff_stamp === false) {

                // Remove unread thread options (Unread Discussions, Unread Today,
                // Unread High Interest, Unread Started By Friend, Most Unread Posts).

                unset($available_views[UNREAD_DISCUSSIONS], $available_views[UNREAD_TODAY], $available_views[UNREAD_HIGH_INTEREST]);
                unset($available_views[UNREAD_STARTED_BY_FRIEND], $available_views[MOST_UNREAD_POSTS]);
            }

        }
    }

    echo "<form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"postbody\">", form_dropdown_array("mode", $available_views, htmlentities_array($mode), "onchange=\"submit()\""), "&nbsp;", form_submit("go",$lang['goexcmark']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

function threads_have_attachments(&$threads_array)
{
    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $tid_list = implode(",", preg_grep("/^[0-9]+$/Du", array_keys($threads_array)));

    if (!$db_thread_has_attachments = db_connect()) return false;

    $sql = "SELECT PAI.TID, PAF.AID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAI.TID IN ($tid_list) ";

    if (!$result = db_query($sql, $db_thread_has_attachments)) return false;

    while (($attachment_data = db_fetch_array($result))) {
        $threads_array[$attachment_data['TID']]['AID'] = $attachment_data['AID'];
    }

    return true;
}

function thread_has_attachments($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_thread_has_attachments = db_connect()) return false;

    $sql = "SELECT COUNT(PAF.AID) FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "INNER JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAI.TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_has_attachments)) return false;

    list($attachment_count) = db_fetch_array($result, DB_RESULT_NUM);
    
    return ($attachment_count > 0);
}

function thread_auto_prune_unread_data()
{
    if (!$db_thread_prune_unread_data = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) !== false) {

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "USING `{$table_data['PREFIX']}USER_THREAD` USER_THREAD LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "ON (USER_THREAD.TID = THREAD.TID) WHERE THREAD.MODIFIED IS NOT NULL ";
        $sql.= "AND THREAD.MODIFIED < CAST('$unread_cutoff_datetime' AS DATETIME) ";
        $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST = 0)";

        if (!db_query($sql, $db_thread_prune_unread_data)) return false;
    }

    return true;
}

function threads_get_user_subscriptions($interest_type = THREAD_NOINTEREST, $offset = 0)
{
    if (!$db_threads_get_user_subscriptions = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($interest_type)) $interest_type = THREAD_NOINTEREST;

    if (!$table_data = get_table_prefix()) return false;

    $thread_subscriptions_array = array();

    $uid = bh_session_get_value('UID');

    if ($interest_type <> THREAD_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE, FOLDER.PREFIX, ";
        $sql.= "USER_THREAD.INTEREST FROM `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
        $sql.= "ON (FOLDER.FID = THREAD.FID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql.= "WHERE USER_THREAD.INTEREST = '$interest_type' ";
        $sql.= "ORDER BY THREAD.MODIFIED DESC ";
        $sql.= "LIMIT $offset, 20";

    }else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE, FOLDER.PREFIX, ";
        $sql.= "USER_THREAD.INTEREST FROM `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
        $sql.= "ON (FOLDER.FID = THREAD.FID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql.= "ORDER BY THREAD.MODIFIED DESC ";
        $sql.= "LIMIT $offset, 20";
    }

    if (!$result = db_query($sql, $db_threads_get_user_subscriptions)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_threads_get_user_subscriptions)) return false;

    list($thread_subscriptions_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($thread_data_array = db_fetch_array($result))) {

            $thread_subscriptions_array[] = $thread_data_array;
        }

    }else if ($thread_subscriptions_count > 0) {

        $offset = floor(($thread_subscriptions_count - 1) / 20) * 20;
        return threads_get_user_subscriptions($interest_type, $offset);
    }

    return array('thread_count' => $thread_subscriptions_count,
                 'thread_array' => $thread_subscriptions_array);
}

function threads_search_user_subscriptions($thread_search, $interest_type = THREAD_NOINTEREST, $offset = 0)
{
    if (!$db_threads_search_user_subscriptions = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($interest_type)) $interest_type = THREAD_NOINTEREST;

    if (!$table_data = get_table_prefix()) return false;

    $thread_search = db_escape_string($thread_search);

    $thread_subscriptions_array = array();

    $uid = bh_session_get_value('UID');

    if ($interest_type <> THREAD_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE, FOLDER.PREFIX, ";
        $sql.= "USER_THREAD.INTEREST FROM `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
        $sql.= "ON (FOLDER.FID = THREAD.FID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql.= "WHERE USER_THREAD.INTEREST = '$interest_type' ";
        $sql.= "AND THREAD.TITLE LIKE '$thread_search%' ";
        $sql.= "ORDER BY THREAD.MODIFIED DESC ";
        $sql.= "LIMIT $offset, 20";

    }else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE, FOLDER.PREFIX, ";
        $sql.= "USER_THREAD.INTEREST FROM `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
        $sql.= "ON (FOLDER.FID = THREAD.FID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
        $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql.= "WHERE USER_THREAD.INTEREST <> 0 ";
        $sql.= "AND THREAD.TITLE LIKE '$thread_search%' ";
        $sql.= "ORDER BY THREAD.MODIFIED DESC ";
        $sql.= "LIMIT $offset, 20";
    }

    if (!$result = db_query($sql, $db_threads_search_user_subscriptions)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_threads_search_user_subscriptions)) return false;

    list($thread_subscriptions_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($thread_data_array = db_fetch_array($result))) {

            $thread_subscriptions_array[] = $thread_data_array;
        }

    }else if ($thread_subscriptions_count > 0) {

        $offset = floor(($thread_subscriptions_count - 1) / 20) * 20;
        return threads_search_user_subscriptions($thread_search, $interest_type, $offset);
    }

    return array('thread_count' => $thread_subscriptions_count,
                 'thread_array' => $thread_subscriptions_array);
}

?>