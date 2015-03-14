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
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

function threads_get_folders()
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$db = db::get()) return false;

    $access_allowed = USER_PERM_POST_READ;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, USER_FOLDER.INTEREST ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
    $sql .= "ORDER BY USER_FOLDER.INTEREST DESC, FOLDER.POSITION";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $folder_info = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {

        if (!session::logged_in()) {

            if (session::check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                $folder_data['STATUS'] = session::get_perm($folder_data['FID']);

                if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = "";
                if (!isset($folder_data['INTEREST'])) $folder_data['INTEREST'] = 0;

                if (!isset($folder_data['ALLOWED_TYPES']) || is_null($folder_data['ALLOWED_TYPES'])) {
                    $folder_data['ALLOWED_TYPES'] = FOLDER_ALLOW_ALL_THREAD;
                }

                $folder_info[$folder_data['FID']] = $folder_data;
            }

        } else {

            if (session::check_perm($access_allowed, $folder_data['FID'])) {

                $folder_data['STATUS'] = session::get_perm($folder_data['FID']);

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

function threads_get_all($uid, $folder, $page = 1) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Constants for user relationships.
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    if (!session::logged_in()) {

        // Formulate query.
        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, NULL AS LAST_READ, ";
        $sql .= "NULL AS INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql .= "USER.LOGON, USER.NICKNAME, NULL AS PEER_NICKNAME, NULL AS RELATIONSHIP, ";
        $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
        $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
        $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "WHERE THREAD.FID IN ($folder) ";
        $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
        $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
        $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 50";

    } else {

        // Formulate query.
        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
        $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, ";
        $sql .= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
        $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
        $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
        $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
        $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
        $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
        $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
        $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "WHERE THREAD.FID IN ($folder) ";
        $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
        $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
        $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
        $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
        $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
        $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
        $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
        $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
        $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 50";
    }

    return threads_process_list($sql);
}

function threads_get_started_by_me($uid, $folder, $page = 1) // get threads started by user
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view unread messages.
    if (!session::logged_in()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.BY_UID = '$uid' AND THREAD.FID IN ($folder) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_unread($uid, $folder, $page = 1) // get unread messages for $uid
{
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view unread messages.
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql .= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_unread_to_me($uid, $folder, $page = 1) // get unread messages to $uid (ignores folder interest level)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view unread messages.
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}POST_RECIPIENT` POST_RECIPIENT ";
    $sql .= "ON (POST_RECIPIENT.TID = POST.TID AND POST_RECIPIENT.PID = POST.PID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND POST_RECIPIENT.TO_UID = '$uid' AND POST_RECIPIENT.VIEWED IS NULL ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_by_days($uid, $folder, $page = 1, $days = 1) // get threads from the last $days days
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($days)) return array(0, 0, 0);

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

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

    if (!session::logged_in()) {

        // Formulate query.
        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, NULL AS LAST_READ, ";
        $sql .= "NULL AS INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
        $sql .= "USER.NICKNAME, NULL AS PEER_NICKNAME, NULL AS RELATIONSHIP, ";
        $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
        $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
        $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "WHERE THREAD.FID IN ($folder) ";
        $sql .= "AND THREAD.MODIFIED >= CAST('$threads_modified_datetime' AS DATETIME) ";
        $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
        $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
        $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 50";

    } else {

        // Formulate query.
        $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
        $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
        $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
        $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
        $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
        $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
        $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
        $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
        $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
        $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "WHERE THREAD.FID IN ($folder) ";
        $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
        $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
        $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
        $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
        $sql .= "AND THREAD.MODIFIED >= CAST('$threads_modified_datetime' AS DATETIME) ";
        $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
        $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
        $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
        $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
        $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 50";
    }

    return threads_process_list($sql);
}

function threads_get_by_interest($uid, $folder, $page = 1, $interest = THREAD_INTERESTED) // get messages for $uid by interest (default High Interest)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($interest)) return array(0, 0, 0);

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql .= "AND USER_THREAD.INTEREST = '$interest' ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_unread_by_interest($uid, $folder, $page = 1, $interest = THREAD_INTERESTED) // get unread messages for $uid by interest (default High Interest)
{
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($interest)) return array(0, 0, 0);

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql .= "AND USER_THREAD.INTEREST = '$interest' ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_recently_viewed($uid, $folder, $page = 1) // get messages recently seen by $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid' ";
    $sql .= "AND USER_THREAD.LAST_READ_AT >= CAST('$threads_viewed_datetime' AS DATETIME) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_by_relationship($uid, $folder, $page = 1, $relationship = USER_FRIEND) // get threads started by people of a particular relationship (default friend)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($relationship)) return array(0, 0, 0);

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Formulate query
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_unread_by_relationship($uid, $folder, $page = 1, $relationship = USER_FRIEND) // get unread messages started by people of a particular relationship (default friend)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($relationship)) return array(0, 0, 0);

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$available_folders = folder_get_available_array()) return array(0, 0, 0);

    // Check the selected folder is in those available.
    if (is_numeric($folder) && !in_array($folder, $available_folders)) return array(0, 0, 0);

    // If the folder is not numeric use the available folders.
    if (!is_numeric($folder)) $folder = implode(',', $available_folders);

    // Check to see if unread messages are disabled.
    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return array(0, 0, 0);

    // Formulate query
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND (USER_PEER.RELATIONSHIP & $relationship = $relationship)";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_polls($uid, $folder, $page = 1)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND THREAD.POLL_FLAG = 'Y' ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_sticky($uid, $folder, $page = 1)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND THREAD.STICKY = 'Y' ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_longest_unread($uid, $folder, $page = 1) // get unread messages for $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD.LENGTH - IF (USER_THREAD.LAST_READ, USER_THREAD.LAST_READ, 0) AS T_LENGTH, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY T_LENGTH DESC, THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_folder($uid, $folder, $page = 1)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);
    if (!is_numeric($folder)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Get the folders the user can see.
    if (!$folders_array = folder_get_available_array()) return array(0, 0, 0);

    // Check to make sure the specified folder is available to the user.
    if (!in_array($folder, $folders_array)) return array(0, 0, 0);

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // Formulate query
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0  ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_deleted($uid, $folder, $page = 1)
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Only Admins can view deleted threads.
    if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'Y' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_unread_by_days($uid, $folder, $page = 1, $days = 0) // get unread messages for $uid
{
    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($uid)) return array(0, 0, 0);

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($days)) return array(0, 0, 0);

    $offset = calculate_page_offset($page, 50);

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return array(0, 0, 0);

    // Guests can't view this thread type.
    if (!session::logged_in()) return array(0, 0, 0);

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
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folder) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.MODIFIED >= CAST('$threads_modified_datetime' AS DATETIME) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '$uid') ";
    $sql .= "ORDER BY THREAD.STICKY DESC, THREAD.MODIFIED DESC ";
    $sql .= "LIMIT $offset, 50";

    return threads_process_list($sql);
}

function threads_get_most_recent($limit = 10, $fid = false, $creation_order = false)
{
    if (!($db = db::get())) return array(0, 0, 0);

    // If there are any problems with the function arguments we bail out.
    if (!is_numeric($limit)) return false;

    // If there are problems with fetching the webtag / table prefix we need to bail out as well.
    if (!($table_prefix = get_table_prefix())) return false;

    // Get the folders the user can see.
    if (!$available_folders_array = folder_get_available_array()) return false;

    // If we have aa folder specified we should only use the ones the user can see.
    if (is_numeric($fid) && in_array($fid, $available_folders_array)) {

        $available_folders_array = array(
            $fid
        );
    }

    // Convert the array into a comma-separated list.
    $folders = implode(',', $available_folders_array);

    // Do we want to sort by thread created or thread modified?
    if ($creation_order === true) {
        $order_by = "THREAD.CREATED DESC";
    } else {
        $order_by = "THREAD.MODIFIED DESC";
    }

    // Constants for user relationships
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    // User UID
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Unread cutoff
    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    // Forumlate query
    $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.DELETED, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "THREAD.STICKY, THREAD.UNREAD_PID, THREAD_STATS.VIEWCOUNT, USER_THREAD.LAST_READ, ";
    $sql .= "USER_THREAD.INTEREST, UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "THREAD_TRACK.TRACK_TYPE FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_TRACK` THREAD_TRACK ";
    $sql .= "ON (THREAD_TRACK.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD_STATS` THREAD_STATS ";
    $sql .= "ON (THREAD_STATS.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql .= "ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE THREAD.FID IN ($folders) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1) ";
    $sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";
    $sql .= "AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '{$_SESSION['UID']}') ";
    $sql .= "ORDER BY $order_by ";
    $sql .= "LIMIT 0, $limit";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $threads_get_array = array();

    while (($thread = $result->fetch_assoc()) !== null) {

        if (isset($thread['LOGON']) && isset($thread['PEER_NICKNAME'])) {
            if (!is_null($thread['PEER_NICKNAME']) && strlen($thread['PEER_NICKNAME']) > 0) {
                $thread['NICKNAME'] = $thread['PEER_NICKNAME'];
            }
        }

        if (!isset($thread['LOGON'])) $thread['LOGON'] = gettext("Unknown user");
        if (!isset($thread['NICKNAME'])) $thread['NICKNAME'] = "";

        if (!isset($thread['RELATIONSHIP']) || is_null($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;
        if (!isset($thread['INTEREST']) || is_null($thread['INTEREST'])) $thread['INTEREST'] = 0;
        if (!isset($thread['STICKY']) || is_null($thread['STICKY'])) $thread['STICKY'] = 0;
        if (!isset($thread['VIEWCOUNT']) || is_null($thread['VIEWCOUNT'])) $thread['VIEWCOUNT'] = 0;
        if (!isset($thread['TRACK_TYPE']) || is_null($thread['TRACK_TYPE'])) $thread['TRACK_TYPE'] = -1;
        if (!isset($thread['DELETED']) || is_null($thread['DELETED'])) $thread['DELETED'] = 'N';

        if (!session::logged_in()) {

            $thread['LAST_READ'] = 0;

        } else if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

            $thread['LAST_READ'] = 0;

            if (isset($thread['MODIFIED']) && $unread_cutoff_timestamp !== false && $thread['MODIFIED'] < $unread_cutoff_timestamp) {
                $thread['LAST_READ'] = $thread['LENGTH'];
            } else if (isset($thread['UNREAD_PID']) && is_numeric($thread['UNREAD_PID'])) {
                $thread['LAST_READ'] = $thread['UNREAD_PID'];
            }
        }

        $threads_get_array[$thread['TID']] = $thread;
    }

    threads_have_attachments($threads_get_array);

    return $threads_get_array;
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
    if (!($db = db::get())) return array(0, 0, 0);

    if (!($result = $db->query($sql))) return array(0, 0, 0);

    if (($thread_count = $result->num_rows) == 0) return array(0, 0, 0);

    $unread_cutoff_timestamp = threads_get_unread_cutoff();

    $threads_array = array();

    $folder_order = array();

    while (($thread = $result->fetch_assoc()) !== null) {

        if (isset($thread['LOGON']) && isset($thread['PEER_NICKNAME'])) {
            if (!is_null($thread['PEER_NICKNAME']) && strlen($thread['PEER_NICKNAME']) > 0) {
                $thread['NICKNAME'] = $thread['PEER_NICKNAME'];
            }
        }

        if (!isset($thread['LOGON'])) $thread['LOGON'] = gettext("Unknown user");
        if (!isset($thread['NICKNAME'])) $thread['NICKNAME'] = "";

        if (!isset($thread['RELATIONSHIP']) || is_null($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;
        if (!isset($thread['INTEREST']) || is_null($thread['INTEREST'])) $thread['INTEREST'] = 0;
        if (!isset($thread['STICKY']) || is_null($thread['STICKY'])) $thread['STICKY'] = 0;
        if (!isset($thread['VIEWCOUNT']) || is_null($thread['VIEWCOUNT'])) $thread['VIEWCOUNT'] = 0;
        if (!isset($thread['TRACK_TYPE']) || is_null($thread['TRACK_TYPE'])) $thread['TRACK_TYPE'] = -1;
        if (!isset($thread['DELETED']) || is_null($thread['DELETED'])) $thread['DELETED'] = 'N';

        if (!in_array($thread['FID'], $folder_order)) {
            $folder_order[] = $thread['FID'];
        }

        if (!session::logged_in()) {

            $thread['LAST_READ'] = 0;

        } else if (!isset($thread['LAST_READ']) || is_null($thread['LAST_READ'])) {

            $thread['LAST_READ'] = 0;

            if (isset($thread['MODIFIED']) && $unread_cutoff_timestamp !== false && $thread['MODIFIED'] < $unread_cutoff_timestamp) {
                $thread['LAST_READ'] = $thread['LENGTH'];
            } else if (isset($thread['UNREAD_PID']) && is_numeric($thread['UNREAD_PID'])) {
                $thread['LAST_READ'] = $thread['UNREAD_PID'];
            }
        }

        $threads_array[$thread['TID']] = $thread;
    }

    threads_have_attachments($threads_array);

    return array(
        $threads_array,
        $folder_order,
        $thread_count
    );
}

function threads_get_folder_msgs()
{
    $folder_msgs = array();

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$available_folders = folder_get_available_array()) return false;

    $folder = implode(',', $available_folders);

    $sql = "SELECT FID, COUNT(*) AS TOTAL FROM `{$table_prefix}THREAD` ";
    $sql .= "WHERE FID IN ($folder) AND DELETED = 'N' AND LENGTH > 0 ";
    $sql .= "AND (APPROVED IS NOT NULL OR BY_UID = '{$_SESSION['UID']}') ";
    $sql .= "GROUP BY FID";

    if (!($result = $db->query($sql))) return false;

    while (($folder = $result->fetch_assoc()) !== null) {
        $folder_msgs[$folder['FID']] = $folder['TOTAL'];
    }

    return $folder_msgs;
}

function threads_any_unread()
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $fidlist = folder_get_available();

    $user_ignored = USER_IGNORED;

    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $sql = "SELECT COUNT(THREAD.TID) AS UNREAD_THREAD_COUNT ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON ";
    $sql .= "(USER_PEER.UID = '{$_SESSION['UID']}' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE THREAD.FID in ($fidlist) AND THREAD.DELETED = 'N' ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
    $sql .= "AND (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "AND THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
    $sql .= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1)";

    if (!($result = $db->query($sql))) return false;

    list($unread_thread_count) = $result->fetch_row();

    return ($unread_thread_count > 0);
}

function threads_mark_all_read()
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql .= "SELECT {$_SESSION['UID']}, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE (THREAD.LENGTH > USER_THREAD.LAST_READ ";
    $sql .= "OR USER_THREAD.LAST_READ IS NULL) AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!$db->query($sql)) return false;

    return true;
}

function threads_mark_50_read()
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql .= "SELECT {$_SESSION['UID']}, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE (THREAD.LENGTH > USER_THREAD.LAST_READ ";
    $sql .= "OR USER_THREAD.LAST_READ IS NULL) AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 50 ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!$db->query($sql)) return false;

    return true;
}

function threads_mark_folder_read($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql .= "SELECT {$_SESSION['UID']}, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE THREAD.FID = '$fid' ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND (THREAD.LENGTH > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!$db->query($sql)) return false;

    return true;
}

function threads_mark_read($tid_array)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_array($tid_array)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) === false) return false;

    $tid_list = implode(",", array_keys($tid_array));

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "INSERT INTO `{$table_prefix}USER_THREAD` (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql .= "SELECT {$_SESSION['UID']}, THREAD.TID, THREAD.LENGTH, CAST('$current_datetime' AS DATETIME), USER_THREAD.INTEREST ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE THREAD.TID IN ($tid_list) ";
    $sql .= "AND (THREAD.MODIFIED >= CAST('$unread_cutoff_datetime' AS DATETIME)) ";
    $sql .= "AND (THREAD.LENGTH > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";
    $sql .= "ON DUPLICATE KEY UPDATE LAST_READ = VALUES(LAST_READ)";

    if (!$db->query($sql)) return false;

    return true;
}

function threads_get_unread_data(&$threads_array, $tid_array)
{
    if (!is_array($tid_array)) return false;
    if (sizeof($tid_array) < 1) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $tid_list = implode(",", array_filter($tid_array, 'is_numeric'));

    if (!$db = db::get()) return false;

    $sql = "SELECT TID, LENGTH, LENGTH AS LAST_READ, UNIX_TIMESTAMP(MODIFIED) AS MODIFIED ";
    $sql .= "FROM `{$table_prefix}THREAD` WHERE TID IN ($tid_list)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($thread_data = $result->fetch_assoc()) !== null) {
        $threads_array[$thread_data['TID']] = $thread_data;
    }

    return true;
}

function thread_list_draw_top($mode, $folder = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\">", html_style_image('post', gettext("New Discussion")), "&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">", gettext("New Discussion"), "</a></td>\n";
    echo "  </tr>\n";

    if (forum_get_setting('allow_polls', 'Y')) {

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\">", html_style_image('poll', gettext("Create Poll")), "&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">", gettext("Create Poll"), "</a></td>\n";
        echo "  </tr>\n";
    }

    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\">", html_style_image('search', gettext("Search")), "&nbsp;<a href=\"search.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Search"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\">", html_style_image('pm_unread', gettext("Inbox")), "&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">", gettext("Inbox"), "</a> <span class=\"pmnewcount\" id=\"pm_message_count\"></span></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";

    $available_views = thread_list_available_views();

    echo "<form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"postbody\">\n";
    echo "        ", form_dropdown_array("mode", $available_views, htmlentities_array($mode)), "&nbsp;", form_submit("go", gettext("Go!")), "\n";

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
    $unread_cutoff_stamp = forum_get_unread_cutoff();

    if (!session::logged_in()) {

        $available_views = array(
            ALL_DISCUSSIONS => gettext("All Discussions"),
            TODAYS_DISCUSSIONS => gettext("Today's Discussions"),
            TWO_DAYS_BACK => gettext("2 Days Back"),
            SEVEN_DAYS_BACK => gettext("7 Days Back")
        );

    } else {

        $available_views = array(
            ALL_DISCUSSIONS => gettext("All Discussions"),
            UNREAD_DISCUSSIONS => gettext("Unread Discussions"),
            UNREAD_DISCUSSIONS_TO_ME => gettext("Unread &quot;To: Me&quot;"),
            TODAYS_DISCUSSIONS => gettext("Today's Discussions"),
            UNREAD_TODAY => gettext("Unread today"),
            TWO_DAYS_BACK => gettext("2 Days Back"),
            SEVEN_DAYS_BACK => gettext("7 Days Back"),
            HIGH_INTEREST => gettext("High Interest"),
            UNREAD_HIGH_INTEREST => gettext("Unread High Interest"),
            RECENTLY_SEEN => gettext("I've recently seen"),
            IGNORED_THREADS => gettext("I've ignored"),
            BY_IGNORED_USERS => gettext("By ignored users"),
            SUBSCRIBED_TO => gettext("I've subscribed to"),
            STARTED_BY_FRIEND => gettext("Started by friend"),
            UNREAD_STARTED_BY_FRIEND => gettext("Unread started by friend"),
            STARTED_BY_ME => gettext("Started by me"),
            POLL_THREADS => gettext("Polls"),
            STICKY_THREADS => gettext("Sticky Threads"),
            MOST_UNREAD_POSTS => gettext("Most unread posts"),
            SEARCH_RESULTS => gettext("Search Results"),
            DELETED_THREADS => gettext("Deleted Threads")
        );

        if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

            if ($unread_cutoff_stamp === false) {

                // Remove unread thread options (Unread Discussions, Unread Today,
                // Unread High Interest, Unread Started By Friend, Most Unread Posts).
                unset($available_views[UNREAD_DISCUSSIONS], $available_views[UNREAD_TODAY], $available_views[UNREAD_HIGH_INTEREST]);
                unset($available_views[UNREAD_STARTED_BY_FRIEND], $available_views[MOST_UNREAD_POSTS]);
            }

        } else {

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
    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $tid_list = implode(',', array_filter(array_keys($threads_array), 'is_numeric'));

    if (!$db = db::get()) return false;

    $sql = "SELECT PAI.TID, COUNT(PAF.HASH) AS ATTACHMENT_COUNT ";
    $sql .= "FROM POST_ATTACHMENT_IDS PAI INNER JOIN POST_ATTACHMENT_FILES PAF ";
    $sql .= "ON (PAF.AID = PAI.AID) WHERE PAI.FID = '$forum_fid' ";
    $sql .= "AND PAI.TID IN ($tid_list) GROUP BY PAI.TID";

    if (!($result = $db->query($sql))) return false;

    while (($attachment_data = $result->fetch_assoc()) !== null) {
        $threads_array[$attachment_data['TID']]['ATTACHMENT_COUNT'] = $attachment_data['ATTACHMENT_COUNT'];
    }

    return true;
}

function thread_auto_prune_unread_data()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) !== false) {

        $sql = "DELETE QUICK FROM `{$table_prefix}USER_THREAD` ";
        $sql .= "USING `{$table_prefix}USER_THREAD` LEFT JOIN `{$table_prefix}THREAD` ";
        $sql .= "ON (`{$table_prefix}USER_THREAD`.`TID` = `{$table_prefix}THREAD`.`TID`) ";
        $sql .= "WHERE `{$table_prefix}THREAD`.`MODIFIED` IS NOT NULL ";
        $sql .= "AND `{$table_prefix}THREAD`.`MODIFIED` < CAST('$unread_cutoff_datetime' AS DATETIME) ";
        $sql .= "AND (`{$table_prefix}USER_THREAD`.`INTEREST` IS NULL ";
        $sql .= "OR `{$table_prefix}USER_THREAD`.`INTEREST` = 0)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function threads_get_user_subscriptions($interest_type = THREAD_NOINTEREST, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($interest_type)) $interest_type = THREAD_NOINTEREST;

    if (!is_numeric($page)) $page = 1;

    if (!($table_prefix = get_table_prefix())) return false;

    $offset = calculate_page_offset($page, 20);

    $thread_subscriptions_array = array();

    if ($interest_type <> THREAD_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "USER_THREAD.INTEREST FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID ";
        $sql .= "AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE USER_THREAD.INTEREST = '$interest_type' ";
        $sql .= "ORDER BY THREAD.MODIFIED DESC LIMIT $offset, 20";

    } else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "USER_THREAD.INTEREST FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID ";
        $sql .= "AND USER_THREAD.UID = '{$_SESSION['UID']}') ORDER BY THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 20";
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($thread_subscriptions_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($thread_subscriptions_count > 0) && ($page > 1)) {
        return threads_get_user_subscriptions($interest_type, $page - 1);
    }

    while (($thread_data_array = $result->fetch_assoc()) !== null) {
        $thread_subscriptions_array[] = $thread_data_array;
    }

    return array(
        'thread_count' => $thread_subscriptions_count,
        'thread_array' => $thread_subscriptions_array
    );
}

function threads_search_user_subscriptions($thread_search, $interest_type = THREAD_NOINTEREST, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($interest_type)) $interest_type = THREAD_NOINTEREST;

    if (!is_numeric($page)) $page = 1;

    if (!($table_prefix = get_table_prefix())) return false;

    $offset = calculate_page_offset($page, 20);

    $thread_search = $db->escape($thread_search);

    $thread_subscriptions_array = array();

    if ($interest_type <> THREAD_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "USER_THREAD.INTEREST FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID ";
        $sql .= "AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE USER_THREAD.INTEREST = '$interest_type' ";
        $sql .= "AND THREAD.TITLE LIKE '$thread_search%' ORDER BY THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 20";

    } else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, ";
        $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
        $sql .= "USER_THREAD.INTEREST FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID ";
        $sql .= "AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE USER_THREAD.INTEREST <> 0 ";
        $sql .= "AND THREAD.TITLE LIKE '$thread_search%' ORDER BY THREAD.MODIFIED DESC ";
        $sql .= "LIMIT $offset, 20";
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($thread_subscriptions_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($thread_subscriptions_count > 0) && ($page > 1)) {
        return threads_search_user_subscriptions($thread_search, $interest_type, $page - 1);
    }

    while (($thread_data_array = $result->fetch_assoc()) !== null) {
        $thread_subscriptions_array[] = $thread_data_array;
    }

    return array(
        'thread_count' => $thread_subscriptions_count,
        'thread_array' => $thread_subscriptions_array
    );
}