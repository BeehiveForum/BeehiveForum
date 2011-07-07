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

/* $Id$ */

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
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
    if (($uid = session_get_value('UID')) === false) return false;

    if (!$db_threads_get_folders = db_connect()) return false;

    $access_allowed = USER_PERM_POST_READ;

    if (!$table_data = get_table_prefix()) return false;

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

                if (session_check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                    $folder_data['STATUS'] = session_get_perm($folder_data['FID']);

                    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = "";
                    if (!isset($folder_data['INTEREST'])) $folder_data['INTEREST'] = 0;

                    if (!isset($folder_data['ALLOWED_TYPES']) || is_null($folder_data['ALLOWED_TYPES'])) {
                        $folder_data['ALLOWED_TYPES'] = FOLDER_ALLOW_ALL_THREAD;
                    }

                    $folder_info[$folder_data['FID']] = $folder_data;
                }

            }else {

                if (session_check_perm($access_allowed, $folder_data['FID'])) {

                    $folder_data['STATUS'] = session_get_perm($folder_data['FID']);

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

function threads_get_all($uid, $folder, $start_from = 0) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships.
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query.
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, ";
    $sql.= "THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
    $sql.= "THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql.= "USER_THREAD.INTEREST, FOLDER.PREFIX, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_started_by_me($uid, $folder, $start_from = 0) // get threads started by user
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view unread messages.
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.BY_UID = '$uid' AND THREAD.FID IN ($folder) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_unread($uid, $folder, $start_from = 0) // get unread messages for $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view unread messages.
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationship
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0, 0);

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
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
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_unread_to_me($uid, $folder, $start_from = 0) // get unread messages to $uid (ignores folder interest level)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view unread messages.
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND POST.TO_UID = '$uid' AND POST.VIEWED IS NULL ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_by_days($uid, $folder, $start_from = 0, $days = 1) // get threads from the last $days days
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);
    if (!is_numeric($days)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships.
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Generate datetime for '$days' days ago.
    $threads_modified_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($days * DAY_IN_SECONDS));

    // Formulate query.
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.MODIFIED >= CAST('$threads_modified_datetime' AS DATETIME) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_by_interest($uid, $folder, $start_from = 0, $interest = THREAD_INTERESTED) // get messages for $uid by interest (default High Interest)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);
    if (!is_numeric($interest)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql.= "AND USER_THREAD.INTEREST = '$interest' ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_unread_by_interest($uid, $folder, $start_from = 0, $interest = THREAD_INTERESTED) // get unread messages for $uid by interest (default High Interest)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);
    if (!is_numeric($interest)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0, 0);

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
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
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_recently_viewed($uid, $folder, $start_from = 0) // get messages recently seem by $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Generate datetime for yesterday
    $threads_viewed_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - DAY_IN_SECONDS);

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
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
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_by_relationship($uid, $folder, $start_from = 0, $relationship = USER_FRIEND) // get threads started by people of a particular relationship (default friend)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);
    if (!is_numeric($relationship)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_unread_by_relationship($uid, $folder, $start_from = 0, $relationship = USER_FRIEND) // get unread messages started by people of a particular relationship (default friend)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);
    if (!is_numeric($relationship)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Check to see if unread messages are disabled.
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0, 0);

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql.= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_polls($uid, $folder, $start_from = 0)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.POLL_FLAG = 'Y' ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_sticky($uid, $folder, $start_from = 0)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed because even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND THREAD.STICKY = 'Y' ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_longest_unread($uid, $folder, $start_from = 0) // get unread messages for $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0, 0);

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
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
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_folder($uid, $folder, $start_from = 0)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($folder)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$folders_array = folder_get_available_array()) return array(0, 0, 0);

    // Check to make sure the specified folder is available to the user.
    if (!in_array($folder, $folders_array)) return array(0, 0, 0);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_deleted($uid, $folder, $start_from = 0)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Only Admins can view deleted threads.
    if (!session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql.= "AND THREAD.DELETED = 'Y' AND THREAD.LENGTH > 0 ";
    $sql.= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_unread_by_days($uid, $folder, $start_from = 0, $days = 0) // get unread messages for $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($start_from)) return array(0, 0, 0);
    if (!is_numeric($days)) return array(0, 0, 0);

    // Ensure offset is positive.
    $start_from = abs($start_from);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return array(0, 0, 0);

    // Guests can't view this thread type.
    if (user_is_guest()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Check to see if unread messages have been disabled.
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0, 0);

    // Generate datetime for '$days' days ago.
    $threads_modified_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($days * DAY_IN_SECONDS));

    // Formulate query
    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.DELETED, ";
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
    $sql.= "WHERE THREAD.FID IN ($folder) ";
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
    $sql.= "LIMIT $start_from, 50";

    return threads_process_list($sql);
}

function threads_get_most_recent($limit = 10, $fid = false, $creation_order = false)
{
    if (!($db_threads_get_recent = db_connect())) return array(0, 0);

    // Language file
    $lang = load_language_file();

    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($limit)) return false;

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!$table_data = get_table_prefix()) return false;

    // Get the folders the user can see.
    if (!$available_folders_array = folder_get_available_array()) return false;

    // If we have aa folder specified we should only use the ones the user can see.
    if (is_numeric($fid) && in_array($fid, $available_folders_array)) {
        $available_folders_array = array($fid);
    }

    // Convert the array into a comma-separated list.
    $folders = implode(',', $available_folders_array);

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
    if (($uid = session_get_value('UID')) === false) return false;

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
function threads_process_list($sql)
{
    if (!($db_threads_process_list = db_connect())) return array(0, 0, 0);

    if (!($result = db_query($sql, $db_threads_process_list))) return array(0, 0, 0);

    if (db_num_rows($result) == 0) return array(0, 0, 0);

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = db_query($sql, $db_threads_process_list))) return array(0, 0, 0);

    list($total_threads) = db_fetch_array($result_count, DB_RESULT_NUM);

    $lang = load_language_file();

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $threads_array = array();

    $folder_order = array();

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

        if (!in_array($thread['FID'], $folder_order)) {
            $folder_order[] = $thread['FID'];
        }

        if (user_is_guest()) {

            $thread['LAST_READ'] = 0;

        } else if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

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

    return array($threads_array, $folder_order, $total_threads);
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

    if (($uid = session_get_value('UID')) === false) return false;

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
    if (($uid = session_get_value('UID')) === false) return false;

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
    if (($uid = session_get_value('UID')) === false) return false;

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

    if (($uid = session_get_value('UID')) === false) return false;

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

    if (($uid = session_get_value('UID')) === false) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $tid_list = implode(",", array_keys($tid_array));

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql.= "SELECT $uid, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
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

    $tid_list = implode(",", array_filter($tid_array, 'is_numeric'));

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

function thread_list_draw_top($thread_mode, $folder = false)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('post.png'), "\" alt=\"{$lang['newdiscussion']}\" title=\"{$lang['newdiscussion']}\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['newdiscussion']}</a></td>\n";
    echo "  </tr>\n";

    if (forum_get_setting('allow_polls', 'Y')) {

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('poll.png'), "\" alt=\"{$lang['createpoll']}\" title=\"{$lang['createpoll']}\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['createpoll']}</a></td>\n";
        echo "  </tr>\n";
    }

    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('search.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" />&nbsp;<a href=\"search.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['search']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('pmunread.png'), "\" alt=\"{$lang['pminbox']}\" title=\"{$lang['pminbox']}\" />&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['pminbox']}</a> <span class=\"pmnewcount\" id=\"pm_message_count\"></span></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";

    $available_views = thread_list_available_views();

    echo "<form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"postbody\">\n";
    echo "        ", form_dropdown_array("thread_mode", $available_views, htmlentities_array($thread_mode)), "&nbsp;", form_submit("go", $lang['goexcmark']), "\n";

    if (is_numeric($folder) && in_array($folder, folder_get_available_array())) {
        echo "        ", form_input_hidden("folder", htmlentities_array($folder)), "\n";
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

function thread_list_available_views()
{
    $lang = load_language_file();

    $unread_cutoff_stamp = forum_get_unread_cutoff();

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

        if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

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

    return $available_views;
}

function threads_have_attachments(&$threads_array)
{
    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $tid_list = implode(",", array_filter(array_keys($threads_array), 'is_numeric'));

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

function thread_auto_prune_unread_data()
{
    if (!$db_thread_prune_unread_data = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) !== false) {

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}USER_THREAD` ";
        $sql.= "USING `{$table_data['PREFIX']}USER_THREAD` LEFT JOIN `{$table_data['PREFIX']}THREAD` ";
        $sql.= "ON (`{$table_data['PREFIX']}USER_THREAD`.`TID` = `{$table_data['PREFIX']}THREAD`.`TID`) ";
        $sql.= "WHERE `{$table_data['PREFIX']}THREAD`.`MODIFIED` IS NOT NULL ";
        $sql.= "AND `{$table_data['PREFIX']}THREAD`.`MODIFIED` < CAST('$unread_cutoff_datetime' AS DATETIME) ";
        $sql.= "AND (`{$table_data['PREFIX']}USER_THREAD`.`INTEREST` IS NULL ";
        $sql.= "OR `{$table_data['PREFIX']}USER_THREAD`.`INTEREST` = 0)";

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

    // Ensure offset is positive.
    $offset = abs($offset);

    $thread_subscriptions_array = array();

    $uid = session_get_value('UID');

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

    // Ensure offset is positive.
    $offset = abs($offset);

    $thread_search = db_escape_string($thread_search);

    $thread_subscriptions_array = array();

    $uid = session_get_value('UID');

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
