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

/* $Id: threads.inc.php,v 1.127 2004-05-26 13:19:53 decoyduck Exp $ */

include_once("./include/folder.inc.php");
include_once("./include/forum.inc.php");

function threads_get_available_folders()
{
    return folder_get_available();
}

function threads_get_folders($access_allowed = USER_PERM_POST_READ)
{
    $uid = bh_session_get_value('UID');

    $db_threads_get_folders = db_connect();

    if (!$table_data = get_table_prefix()) return false;
    if (!is_numeric($access_allowed)) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_STATUS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.FID = FOLDER.FID AND GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_PERMS FOLDER_PERMS ";
    $sql.= "ON (FOLDER_PERMS.FID = FOLDER.FID AND FOLDER_PERMS.GID = 0) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.FID";

    $result = db_query($sql, $db_threads_get_folders);

    if (db_num_rows($result) > 0) {

        $folder_info = array();

        while($row = db_fetch_array($result, MYSQL_ASSOC)) {

            if ($row['USER_PERM_COUNT'] > 0) {

                $status = $row['USER_STATUS'];

            }elseif ($row['FOLDER_PERM_COUNT'] > 0) {

                $status = $row['FOLDER_PERM_COUNT'];

            }else {

                $status = (double)USER_PERM_POST_READ | USER_PERM_POST_CREATE;
                $status = (double)$status | USER_PERM_THREAD_CREATE | USER_PERM_POST_EDIT;
                $status = (double)$status | USER_PERM_POST_DELETE | USER_PERM_POST_ATTACHMENTS;
            }

            if (($status & $access_allowed) > 0) {

                if (isset($row['INTEREST'])) {

                    $folder_info[$row['FID']] = array('TITLE'         => $row['TITLE'],
                                                      'DESCRIPTION'   => (isset($row['DESCRIPTION'])) ? $row['DESCRIPTION'] : "",
                                                      'ALLOWED_TYPES' => (isset($row['ALLOWED_TYPES']) && !is_null($row['ALLOWED_TYPES'])) ? $row['ALLOWED_TYPES'] : FOLDER_ALLOW_ALL_THREAD,
                                                      'INTEREST'      => $row['INTEREST'],
                                                      'STATUS'        => $status);
                }else {

                    $folder_info[$row['FID']] = array('TITLE'         => $row['TITLE'],
                                                      'DESCRIPTION'   => (isset($row['DESCRIPTION'])) ? $row['DESCRIPTION'] : "",
                                                      'ALLOWED_TYPES' => (isset($row['ALLOWED_TYPES']) && !is_null($row['ALLOWED_TYPES'])) ? $row['ALLOWED_TYPES'] : FOLDER_ALLOW_ALL_THREAD,
                                                      'INTEREST'      => 0,
                                                      'STATUS'        => $status);
                }
            }
        }

        return $folder_info;
    }

    return false;
}

function threads_get_all($uid, $start = 0) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    $folders = threads_get_available_folders();
    $db_threads_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_all);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread($uid) // get unread messages for $uid
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, USER_FOLDER.interest AS folder_interest, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread_to_me($uid) // get unread messages to $uid (ignores folder interest level)
{
    $folders = threads_get_available_folders();
    $db_threads_get_unread_to_me = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid), ";
    $sql .= "{$table_data['PREFIX']}POST POST ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST2 ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND USER.uid = POST2.from_uid ";
    $sql .= "AND POST2.tid = THREAD.tid ";
    $sql .= "AND POST2.pid = 1 ";
    $sql .= "AND POST.tid = THREAD.tid AND POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread_to_me);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_by_days($uid,$days = 1) // get threads from the last $days days
{

    $folders = threads_get_available_folders();
    $db_threads_get_by_days = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');
    if (!is_numeric($days)) $days = 1;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) <= $days ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_by_days);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_by_interest($uid, $interest = 1) // get messages for $uid by interest (default High Interest)
{

    $folders = threads_get_available_folders();
    $db_threads_get_by_interest = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');
    if (!is_numeric($interest)) $interest = 1;

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD, ";
    $sql .= "{$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql .= "AND (USER_THREAD.INTEREST = $interest OR NOT USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_by_interest);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread_by_interest($uid,$interest = 1) // get unread messages for $uid by interest (default High Interest)
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread_by_interest = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');
    if (!is_numeric($interest)) $interest = 1;

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD, ";
    $sql .= "{$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql .= "AND USER_THREAD.last_read < THREAD.length ";
    $sql .= "AND (USER_THREAD.INTEREST = $interest OR NOT USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread_by_interest);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_recently_viewed($uid) // get messages recently seem by $uid
{

    $folders = threads_get_available_folders();
    $db_threads_get_recently_viewed = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD, ";
    $sql .= "{$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql .= "AND TO_DAYS(NOW()) - TO_DAYS(USER_THREAD.LAST_READ_AT) <= 1 ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_recently_viewed);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_by_relationship($uid,$relationship = USER_FRIEND,$start = 0) // get threads started by people of a particular relationship (default friend)
{

    $folders = threads_get_available_folders();
    $db_threads_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (UP.relationship & $relationship = $relationship)";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_all);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread_by_relationship($uid,$relationship = USER_FRIEND) // get unread messages started by people of a particular relationship (default friend)
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, USER_FOLDER.interest AS folder_interest, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (UP.relationship & $relationship = $relationship)";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_polls($uid, $start = 0)
{

    $folders = threads_get_available_folders();
    $db_threads_get_polls = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND THREAD.poll_flag = 'Y' ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_polls);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_sticky($uid, $start = 0)
{

    $folders = threads_get_available_folders();
    $db_threads_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');
    if (!is_numeric($start)) $start = 0;

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND THREAD.sticky = 'Y' ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_all);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_longest_unread($uid) // get unread messages for $uid
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, USER_FOLDER.interest AS folder_interest, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "THREAD.length - IF (USER_THREAD.last_read, USER_THREAD.last_read, 0) AS T_LENGTH, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT ((USER_THREAD.INTEREST <=> -1) OR (USER_FOLDER.INTEREST <=> -1)) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY T_LENGTH DESC, THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_folder($uid, $fid, $start = 0)
{
    $db_threads_get_folder = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) $uid = bh_session_get_value('UID');
    if (!is_numeric($start)) $start = 0;

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, THREAD.sticky, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN USER USER ";
    $sql .= "JOIN {$table_data['PREFIX']}POST POST ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($fid) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST <> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.sticky DESC, THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_folder);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_most_recent()
{
    $db_threads_get_recent = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $fidlist = folder_get_available();

    if (!$uid = bh_session_get_value('UID')) $uid = 0;

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT T.TID, T.TITLE, T.STICKY, T.LENGTH, T.POLL_FLAG, UT.LAST_READ, ";
    $sql.= "UNIX_TIMESTAMP(T.MODIFIED) AS MODIFIED, UP.RELATIONSHIP, ";
    $sql.= "AT.AID AS ATTACHMENTS, UT.INTEREST, U.NICKNAME, U.LOGON ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD T ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD UT ";
    $sql.= "ON (T.TID = UT.TID and UT.UID = '$uid') ";
    $sql.= "JOIN USER U ";
    $sql.= "JOIN {$table_data['PREFIX']}POST P ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER UF ON ";
    $sql.= "(UF.FID = T.FID AND UF.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER UP ON ";
    $sql.= "(UP.UID = '$uid' AND UP.PEER_UID = P.FROM_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON ";
    $sql.= "(GROUP_USERS.GID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ON ";
    $sql.= "(GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FID IN (T.FID)) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS AT ON ";
    $sql.= "(AT.TID = T.TID) ";
    $sql.= "WHERE T.FID IN ($fidlist) ";
    $sql.= "AND U.UID = P.FROM_UID ";
    $sql.= "AND P.TID = T.TID ";
    $sql.= "AND P.PID = 1 ";
    $sql.= "AND NOT ((UT.INTEREST <=> -1) OR (UF.INTEREST <=> -1)) ";
    $sql.= "GROUP BY T.TID ";
    $sql.= "ORDER BY T.MODIFIED desc ";
    $sql.= "LIMIT 0, 10";

    $result = db_query($sql, $db_threads_get_recent);

    if (db_num_rows($result)) {

        $threads_get_array = array();

	while ($thread = db_fetch_array($result)) {
	    if (!($thread['RELATIONSHIP'] & USER_IGNORED) || $thread['LENGTH'] > 1) {
	        $threads_get_array[] = $thread;
	    }
	}

	return $threads_get_array;

    }else {
        return false;
    }
}

// Arrange the results of a query into the right order for display

function threads_process_list($resource_id)
{
    $max = db_num_rows($resource_id);

    // Default to returning no threads.

    $lst = 0;
    $folder = 0;
    $folder_order = 0;

    // Check that the set of threads returned is not empty

    if ($max) {

        // If the user has clicked on a folder header, we want
        // that folder to be first in the list

        if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
            $folder = $_GET['folder'];
            $folder_order = array($_GET['folder']);
        }

        // Loop through the results and construct an array to return

        for($i = 0; $i < $max; $i++){

            $thread = db_fetch_array($resource_id);

            if (!isset($thread['relationship'])) $thread['relationship'] = 0;

            // If the thread has been started by someone in our ignore list
            // and there are currently no replies (length of 1) then we don't
            // want to display it.

            if (!($thread['relationship'] & USER_IGNORED) || $thread['length'] > 1 || $thread['fid'] == $folder) {

                // If this folder ID has not been encountered before,
                // make it the next folder in the order to be displayed

                if (!is_array($folder_order)) {
                    $folder_order = array($thread['fid']);
                }else{
                    if (!in_array($thread['fid'], $folder_order)) {
                        $folder_order[] = $thread['fid'];
                    }
                }

                if (!is_array($lst)) $lst = array();

                $lst[$i]['tid'] = $thread['tid'];
                $lst[$i]['fid'] = $thread['fid'];
                $lst[$i]['title'] = _stripslashes($thread['title']);
                $lst[$i]['length'] = $thread['length'];
                $lst[$i]['poll_flag'] = $thread['poll_flag'];

                // Special case - last_read may be NULL, in which case
                // PHP will complain that the array index doesn't exist
                // if we don't do this

                if (isset($thread['last_read'])) {
                    $lst[$i]['last_read'] = $thread['last_read'];
                }else{
                    $lst[$i]['last_read'] = 0;
                }

                $lst[$i]['interest'] = isset($thread['interest']) ? $thread['interest'] : 0;
                $lst[$i]['modified'] = $thread['modified'];
                $lst[$i]['logon'] = $thread['logon'];
                $lst[$i]['nickname'] = $thread['nickname'];
                $lst[$i]['relationship'] = isset($thread['relationship']) ? $thread['relationship'] : 0;
                $lst[$i]['attachments'] = isset($thread['aid']) ? true : false;
                $lst[$i]['sticky'] = isset($thread['sticky']) ? $thread['sticky'] : 0;
            }
        }
    }

    // $lst is the array with thread information,
    // $folder_order is a list of FIDs in the order
    // in which the folders should be displayed

    return array($lst, $folder_order);
}

function threads_get_folder_msgs()
{

    $folder_msgs = array();
    $db_threads_get_folder_msgs = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT FID, COUNT(*) AS TOTAL FROM {$table_data['PREFIX']}THREAD GROUP BY FID";
    $resource_id = db_query($sql, $db_threads_get_folder_msgs);

    while($folder = db_fetch_array($resource_id)){
        $folder_msgs[$folder['FID']] = $folder['TOTAL'];
    }

    return $folder_msgs;
}

function threads_any_unread()
{
    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}THREAD T LEFT JOIN {$table_data['PREFIX']}USER_THREAD UT ";
    $sql.= "ON (T.TID = UT.TID AND UT.UID = '$uid') ";
    $sql.= "WHERE T.LENGTH > UT.LAST_READ ";
    $sql.= "LIMIT 0,1";

    $db_threads_any_unread = db_connect();
    $result = db_query($sql, $db_threads_any_unread);

    return (db_num_rows($result) > 0);
}

function threads_mark_all_read()
{

    $uid = bh_session_get_value('UID');

    $db_threads_mark_all_read = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT TID, LENGTH FROM {$table_data['PREFIX']}THREAD";
    $result_threads = db_query($sql, $db_threads_mark_all_read);

    while($row = db_fetch_array($result_threads)) {
        messages_update_read($row['TID'], $row['LENGTH'], bh_session_get_value('UID'));
    }

}

function threads_mark_50_read()
{
    $uid = bh_session_get_value('UID');

    $db_threads_mark_50_read = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT THREAD.TID, THREAD.LENGTH FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_THREAD USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "WHERE (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 50";

    $result = db_query($sql, $db_threads_mark_50_read);

    while ($row = db_fetch_array($result)) {
        messages_update_read($row['TID'], $row['LENGTH'], bh_session_get_value('UID'));
    }
}

function threads_mark_read($tidarray)
{
    $db_threads_mark_read = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_array($tidarray)) return false;

    foreach($tidarray as $ctid) {

        $sql = "SELECT LENGTH FROM {$table_data['PREFIX']}THREAD WHERE TID = $ctid";

        $result = db_query($sql, $db_threads_mark_read);

        list($ctlength) = db_fetch_array($result);
        messages_update_read($ctid, $ctlength, bh_session_get_value('UID'));
    }
}

?>