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

/* $Id: admin.inc.php,v 1.36 2004-04-23 15:53:47 decoyduck Exp $ */

include_once("./include/perm.inc.php");

function admin_addlog($uid, $fid, $tid, $pid, $psid, $piid, $action)
{
    $db_admin_addlog = db_connect();
    $admin_uid = bh_session_get_value('UID');

    if (perm_is_moderator()) {

        $uid    = addslashes($uid);
        $tid    = addslashes($tid);
        $pid    = addslashes($pid);
        $psid   = addslashes($psid);
        $piid   = addslashes($piid);
        $action = addslashes($action);

        if (!$table_data = get_table_prefix()) return false;

        $sql = "INSERT INTO {$table_data['PREFIX']}ADMIN_LOG (LOG_TIME, ADMIN_UID, UID, FID, TID, PID, PSID, PIID, ACTION) ";
        $sql.= "VALUES (NOW(), '$admin_uid', '$uid', '$fid', '$tid', '$pid', '$psid', '$piid', '$action')";

        $result = db_query($sql, $db_admin_addlog);

        return $result;
    }
}

function admin_clearlog()
{
    $db_admin_clearlog = db_connect();

    if ((bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {

        if (!$table_data = get_table_prefix()) return false;

        $sql = "DELETE FROM {$table_data['PREFIX']}ADMIN_LOG";
	$result = db_query($sql, $db_admin_clearlog);
    }
}

function admin_get_log_entries($offset, $sort_by, $sort_dir)
{
    $db_admin_get_log_entries = db_connect();

    $sort_array = array('ADMIN_LOG.LOG_TIME', 'ADMIN_LOG.ADMIN_UID', 'ADMIN_LOG.ACTION');

    $admin_log_array = array();

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'ADMIN_LOG.LOG_TIME';

    if (!$table_data = get_table_prefix()) return array('admin_log_count' => 0,
                                                        'admin_log_array' => array());

    $sql = "SELECT LOG_ID FROM {$table_data['PREFIX']}ADMIN_LOG ";

    $result = db_query($sql, $db_admin_get_log_entries);
    $admin_log_count = db_num_rows($result);

    $sql = "SELECT ADMIN_LOG.LOG_ID, UNIX_TIMESTAMP(ADMIN_LOG.LOG_TIME) AS LOG_TIME, ADMIN_LOG.ADMIN_UID, ";
    $sql.= "ADMIN_LOG.UID, AUSER.LOGON AS ALOGON, AUSER.NICKNAME AS ANICKNAME, USER.LOGON, USER.NICKNAME, ";
    $sql.= "ADMIN_LOG.FID, ADMIN_LOG.TID, ADMIN_LOG.PID, FOLDER.TITLE AS FOLDER_TITLE, THREAD.TITLE AS THREAD_TITLE, ";
    $sql.= "ADMIN_LOG.PSID, ADMIN_LOG.PIID, PS.NAME AS PS_NAME, PI.NAME AS PI_NAME, ADMIN_LOG.ACTION ";
    $sql.= "FROM {$table_data['PREFIX']}ADMIN_LOG ADMIN_LOG ";
    $sql.= "LEFT JOIN USER AUSER ON (AUSER.UID = ADMIN_LOG.ADMIN_UID) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_SECTION PS ON (PS.PSID = ADMIN_LOG.PSID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PI ON (PI.PIID = ADMIN_LOG.PIID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = ADMIN_LOG.FID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = ADMIN_LOG.TID) ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    $result = db_query($sql, $db_admin_get_log_entries);

    if (db_num_rows($result)) {
	while ($row = db_fetch_array($result)) {
	    $admin_log_array[] = $row;
	}
    }

    return array('admin_log_count' => $admin_log_count,
                 'admin_log_array' => $admin_log_array);
}

function admin_get_word_filter()
{
    $db_admin_get_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $sql = "SELECT * FROM {$table_data['PREFIX']}FILTER_LIST WHERE UID = 0";
    $result = db_query($sql, $db_admin_get_word_filter);

    $filter_array = array();

    while($row = db_fetch_array($result)) {
        $filter_array[$row['ID']] = $row;
    }

    return $filter_array;
}

function admin_delete_word_filter($id)
{
    if (!is_numeric($id)) return false;

    $db_user_delete_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}FILTER_LIST ";
    $sql.= "WHERE ID = '$id' AND UID = 0";

    $result = db_query($sql, $db_user_delete_word_filter);
}

function admin_clear_word_filter()
{
    $db_admin_clear_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}FILTER_LIST WHERE UID = 0";
    return db_query($sql, $db_admin_clear_word_filter);
}

function admin_add_word_filter($match, $replace, $filter_option)
{
    $match = addslashes($match);
    $replace = addslashes($replace);

    $db_admin_add_word_filter = db_connect();
    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}FILTER_LIST (MATCH_TEXT, REPLACE_TEXT, FILTER_OPTION) ";
    $sql.= "VALUES ('$match', '$replace', '$filter_option')";

    $result = db_query($sql, $db_admin_add_word_filter);
}

function admin_user_search($usersearch, $sort_by = "VISITOR_LOG.LAST_LOGON", $sort_dir = "DESC", $offset = 0)
{
    $db_user_search = db_connect();

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER_STATUS.STATUS',
                        'VISITOR_LOG.LAST_LOGON', 'SESSIONS.SESSID');

    $usersearch = addslashes($usersearch);

    if (!is_numeric($offset)) $offset = 0;
    if (!in_array($sort_by, $sort_array)) $sort_by = 'VISITOR_LOG.LAST_LOGON';

    $user_search_array = array();

    $sql = "SELECT UID FROM USER WHERE (USER.LOGON LIKE '$usersearch%' ";
    $sql.= "OR USER.NICKNAME LIKE '$usersearch%') ";

    $result = db_query($sql, $db_user_search);
    $user_search_count = db_num_rows($result);

    if ($table_data = get_table_prefix()) {

        $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
        $sql.= "USER_STATUS.STATUS FROM USER USER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
        $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$table_data['FID']}') ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
        $sql.= "ORDER BY $sort_by $sort_dir ";
        $sql.= "LIMIT $offset, 20";

    }else {

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
        $sql.= "ORDER BY $sort_by $sort_dir ";
        $sql.= "LIMIT $offset, 20";
    }

    $result = db_query($sql, $db_user_search);

    if (db_num_rows($result)) {
        while ($row = db_fetch_array($result)) {
            if (!isset($user_search_array[$row['UID']])) {
                $user_search_array[$row['UID']] = $row;
	    }
        }
    }

    return array('user_count' => $user_search_count,
                 'user_array' => $user_search_array);
}

function admin_user_get_all($sort_by = "LAST_LOGON", $sort_dir = "ASC", $offset = 0)
{
    $db_user_get_all = db_connect();
    $user_get_all_array = array();

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER_STATUS.STATUS',
                        'VISITOR_LOG.LAST_LOGON', 'SESSIONS.SESSID');

    if (!is_numeric($offset)) $offset = 0;
    if (!in_array($sort_by, $sort_array)) $sort_by = 'LAST_LOGON';

    $user_get_all_array = array();

    $sql = "SELECT UID FROM USER";

    $result = db_query($sql, $db_user_get_all);
    $user_get_all_count = db_num_rows($result);

    if ($table_data = get_table_prefix()) {

        $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
        $sql.= "USER_STATUS.STATUS, SESSIONS.SESSID FROM USER USER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
        $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$table_data['FID']}') ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
        $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    }else {

        $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
        $sql.= "USER_STATUS.STATUS, SESSIONS.SESSID FROM USER USER ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
        $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    $result = db_query($sql, $db_user_get_all);

    if (db_num_rows($result)) {
        while ($row = db_fetch_array($result)) {
            if (!isset($user_get_all_array[$row['UID']])) {
                $user_get_all_array[$row['UID']] = $row;
	    }
        }
    }

    return array('user_count' => $user_get_all_count,
                 'user_array' => $user_get_all_array);
}

function admin_session_end($uid)
{
    $db_admin_session_end = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM SESSIONS WHERE UID = '$uid' ";
    $sql.= "AND FID = '{$table_data['FID']}'";

    return db_query($sql, $db_admin_session_end);
}

function admin_get_users_attachments($uid)
{
    $userattachments = false;

    $db_get_users_attachments = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return $userattachments;

    $forum_settings = get_forum_settings();

    $sql = "SELECT DISTINCT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES WHERE UID = '$uid'";
    $result = db_query($sql, $db_get_users_attachments);

    while($row = db_fetch_array($result)) {

        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            if (!is_array($userattachments)) $userattachments = array();

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "filedate"  => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS']);
        }
    }

    return $userattachments;
}

function admin_get_forum_list()
{
    $db_get_forum_list = db_connect();
    $get_forum_list_array = array();

    $sql = "SELECT * FROM FORUMS ORDER BY FID";
    $result_forums = db_query($sql, $db_get_forum_list);

    while ($forum_data = db_fetch_array($result_forums)) {

        // Get the Forum Name

        $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
	$sql.= "WHERE SNAME = 'forum_name' AND FID = '{$forum_data['FID']}'";

	$result_forum_name = db_query($sql, $db_get_forum_list);

	if (db_num_rows($result_forum_name)) {

	    $row = db_fetch_array($result_forum_name);
	    $forum_data['FORUM_NAME'] = $row['FORUM_NAME'];

	}else {

	    $forum_data['FORUM_NAME'] = "Unnamed Forum";
	}

	// Get the Description

        $sql = "SELECT SVALUE AS DESCRIPTION FROM FORUM_SETTINGS WHERE ";
        $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
        $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

        $result_description = db_query($sql, $db_get_forum_list);

        if (db_num_rows($result_description)) {

            $row = db_fetch_array($result_description);
            $forum_data['DESCRIPTION'] = $row['DESCRIPTION'];

        }else{

            $forum_data['DESCRIPTION'] = "";
        }

    	// Get number of messages on forum

        $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
        $result_post_count = db_query($sql, $db_get_forum_list);

        if (db_num_rows($result_post_count)) {

            $row = db_fetch_array($result_post_count);
            $forum_data['MESSAGES'] = $row['POST_COUNT'];

        }else {

            $forum_data['MESSAGES'] = 0;
        }

        $get_forum_list_array[] = $forum_data;
    }

    return $get_forum_list_array;
}

?>