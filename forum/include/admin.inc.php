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

/* $Id: admin.inc.php,v 1.23 2004-03-19 23:06:52 decoyduck Exp $ */

function admin_addlog($uid, $fid, $tid, $pid, $psid, $piid, $action)
{
    $db_admin_addlog = db_connect();
    $admin_uid = bh_session_get_value('UID');

    $uid    = addslashes($uid);
    $tid    = addslashes($tid);
    $pid    = addslashes($pid);
    $psid   = addslashes($psid);
    $piid   = addslashes($piid);
    $action = addslashes($action);
    
    $webtag = get_webtag();

    $sql = "INSERT INTO {$webtag['PREFIX']}ADMIN_LOG (LOG_TIME, ADMIN_UID, UID, FID, TID, PID, PSID, PIID, ACTION) ";
    $sql.= "VALUES (NOW(), '$admin_uid', '$uid', '$fid', '$tid', '$pid', '$psid', '$piid', '$action')";

    $result = db_query($sql, $db_admin_addlog);

    return $result;
}

function admin_clearlog()
{
    $db_admin_clearlog = db_connect();

    if ((bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {

        $webtag = get_webtag();
        
        $sql = "DELETE FROM {$webtag['PREFIX']}ADMIN_LOG";
	$result = db_query($sql, $db_admin_clearlog);
    }
}

function admin_get_log_entries($offset, $sort_by, $sort_dir)
{
    $db_admin_get_log_entries = db_connect();

    $sort_array = array('ADMIN_LOG.LOG_TIME', 'ADMIN_LOG.ADMIN_UID', 'ADMIN_LOG.ACTION');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'ADMIN_LOG.LOG_TIME';
    
    $webtag = get_webtag();

    $sql = "SELECT ADMIN_LOG.LOG_ID, UNIX_TIMESTAMP(ADMIN_LOG.LOG_TIME) AS LOG_TIME, ADMIN_LOG.ADMIN_UID, ";
    $sql.= "ADMIN_LOG.UID, AUSER.LOGON AS ALOGON, AUSER.NICKNAME AS ANICKNAME, USER.LOGON, USER.NICKNAME, ";
    $sql.= "ADMIN_LOG.FID, ADMIN_LOG.TID, ADMIN_LOG.PID, FOLDER.TITLE AS FOLDER_TITLE, THREAD.TITLE AS THREAD_TITLE, ";
    $sql.= "ADMIN_LOG.PSID, ADMIN_LOG.PIID, PS.NAME AS PS_NAME, PI.NAME AS PI_NAME, ADMIN_LOG.ACTION ";
    $sql.= "FROM {$webtag['PREFIX']}ADMIN_LOG ADMIN_LOG ";
    $sql.= "LEFT JOIN USER AUSER ON (AUSER.UID = ADMIN_LOG.ADMIN_UID) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}PROFILE_SECTION PS ON (PS.PSID = ADMIN_LOG.PSID) ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}PROFILE_ITEM PI ON (PI.PIID = ADMIN_LOG.PIID) ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = ADMIN_LOG.FID) ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}THREAD THREAD ON (THREAD.TID = ADMIN_LOG.TID) ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    $result = db_query($sql, $db_admin_get_log_entries);

    if (db_num_rows($result)) {
	$admin_log_array = array();
	while ($row = db_fetch_array($result)) {
	    $admin_log_array[] = $row;
	}
	return $admin_log_array;
    }else {
        return false;
    }
}

function admin_get_word_filter()
{
    $db_admin_get_word_filter = db_connect();
    
    $webtag = get_webtag();

    $sql = "SELECT * FROM {$webtag['PREFIX']}FILTER_LIST WHERE UID = 0";
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
    
    $webtag = get_webtag();
    
    $sql = "DELETE FROM {$webtag['PREFIX']}FILTER_LIST ";
    $sql.= "WHERE ID = '$id' AND UID = 0";
    
    $result = db_query($sql, $db_user_delete_word_filter);
}

function admin_clear_word_filter()
{
    $db_admin_clear_word_filter = db_connect();
    
    $webtag = get_webtag();

    $sql = "DELETE FROM {$webtag['PREFIX']}FILTER_LIST WHERE UID = 0";
    return db_query($sql, $db_admin_clear_word_filter);
}

function admin_add_word_filter($match, $replace, $filter_option)
{
    $match = addslashes($match);
    $replace = addslashes($replace);

    $db_admin_add_word_filter = db_connect();
    $uid = bh_session_get_value('UID');    
    
    $webtag = get_webtag();

    $sql = "INSERT INTO {$webtag['PREFIX']}FILTER_LIST (MATCH_TEXT, REPLACE_TEXT, FILTER_OPTION) ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER_STATUS.STATUS, SESSIONS.SESSID FROM USER USER ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$webtag['FID']}') ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
    $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_user_search);

    if (db_num_rows($result)) {
        $user_search_array = array();
        while ($row = db_fetch_array($result)) {
            $user_search_array[] = $row;
        }
        return $user_search_array;
    }else {
        return false;
    }
}

function admin_user_get_all($sort_by = "LAST_LOGON", $sort_dir = "ASC", $offset = 0)
{
    $db_user_get_all = db_connect();
    $user_get_all_array = array();

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER_STATUS.STATUS', 
                        'VISITOR_LOG.LAST_LOGON', 'SESSIONS.SESSID');

    if (!is_numeric($offset)) $offset = 0;
    if (!in_array($sort_by, $sort_array)) $sort_by = 'LAST_LOGON';
    
    $webtag = get_webtag();

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER_STATUS.STATUS, SESSIONS.SESSID FROM USER USER ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN USER_STATUS USER_STATUS ON (USER_STATUS.UID = USER.UID AND USER_STATUS.FID = '{$webtag['FID']}') ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
    $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    $result = db_query($sql, $db_user_get_all);

    while($row = db_fetch_array($result)) {
       $user_get_all_array[] = $row;
    }

    return $user_get_all_array;
}

function admin_session_end($uid)
{
    $db_admin_session_end = db_connect();
    
    if (!is_numeric($uid)) return false;
    
    $webtag = get_webtag();
    
    $sql = "DELETE FROM SESSIONS WHERE UID = '$uid' AND FID = '{$webtag['FID']}'";
    $result = db_query($sql, $db_admin_session_end);
    
    return (db_affected_rows($db_admin_session_end) > 0);
}

?>