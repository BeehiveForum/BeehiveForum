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

/* $Id: admin.inc.php,v 1.16 2004-03-09 23:00:07 decoyduck Exp $ */

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
    
    $table_prefix = get_table_prefix();

    $sql = "INSERT INTO {$table_prefix}ADMIN_LOG (LOG_TIME, ADMIN_UID, UID, FID, TID, PID, PSID, PIID, ACTION) ";
    $sql.= "VALUES (NOW(), '$admin_uid', '$uid', '$fid', '$tid', '$pid', '$psid', '$piid', '$action')";

    $result = db_query($sql, $db_admin_addlog);

    return $result;
}

function admin_clearlog()
{
    $db_admin_clearlog = db_connect();

    if ((bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {

        $table_prefix = get_table_prefix();
        
        $sql = "DELETE FROM {$table_prefix}ADMIN_LOG";
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
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT ADMIN_LOG.LOG_ID, UNIX_TIMESTAMP(ADMIN_LOG.LOG_TIME) AS LOG_TIME, ADMIN_LOG.ADMIN_UID, ";
    $sql.= "ADMIN_LOG.UID, AUSER.LOGON AS ALOGON, AUSER.NICKNAME AS ANICKNAME, USER.LOGON, USER.NICKNAME, ";
    $sql.= "ADMIN_LOG.FID, ADMIN_LOG.TID, ADMIN_LOG.PID, FOLDER.TITLE AS FOLDER_TITLE, THREAD.TITLE AS THREAD_TITLE, ";
    $sql.= "ADMIN_LOG.PSID, ADMIN_LOG.PIID, PS.NAME AS PS_NAME, PI.NAME AS PI_NAME, ADMIN_LOG.ACTION ";
    $sql.= "FROM {$table_prefix}ADMIN_LOG ADMIN_LOG ";
    $sql.= "LEFT JOIN {$table_prefix}USER AUSER ON (AUSER.UID = ADMIN_LOG.ADMIN_UID) ";
    $sql.= "LEFT JOIN {$table_prefix}USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "LEFT JOIN {$table_prefix}PROFILE_SECTION PS ON (PS.PSID = ADMIN_LOG.PSID) ";
    $sql.= "LEFT JOIN {$table_prefix}PROFILE_ITEM PI ON (PI.PIID = ADMIN_LOG.PIID) ";
    $sql.= "LEFT JOIN {$table_prefix}FOLDER FOLDER ON (FOLDER.FID = ADMIN_LOG.FID) ";
    $sql.= "LEFT JOIN {$table_prefix}THREAD THREAD ON (THREAD.TID = ADMIN_LOG.TID) ";
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
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT * FROM {$table_prefix}FILTER_LIST WHERE UID = 0";
    $result = db_query($sql, $db_admin_get_word_filter);

    $filter_array = array();

    while($row = db_fetch_array($result)) {
        $filter_array[] = $row;
    }

    return $filter_array;
}

function admin_clear_word_filter()
{
    $db_admin_clear_word_filter = db_connect();
    
    $table_prefix = get_table_prefix();

    $sql = "DELETE FROM {$table_prefix}FILTER_LIST WHERE UID = 0";
    return db_query($sql, $db_admin_clear_word_filter);
}

function admin_add_word_filter($match, $replace, $preg_expr)
{
    $match = addslashes($match);
    $replace = addslashes($replace);

    $db_admin_add_word_filter = db_connect();
    $uid = bh_session_get_value('UID');    
    
    $table_prefix = get_table_prefix();

    $sql = "INSERT INTO {$table_prefix}FILTER_LIST (MATCH_TEXT, REPLACE_TEXT, PREG_EXPR) ";
    $sql.= "VALUES ('$match', '$replace', '$preg_expr')";

    $result = db_query($sql, $db_admin_add_word_filter);
}

function admin_user_search($usersearch, $sort_by = "USER.LAST_LOGON", $sort_dir = "DESC", $offset = 0)
{
    $db_user_search = db_connect();

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER.STATUS', 
                        'USER.LAST_LOGON', 'USER.LOGON_FROM', 'SESSIONS.SESSID');
    
    $usersearch = addslashes($usersearch);
    if (!is_numeric($offset)) $offset = 0;
    if (!in_array($sort_by, $sort_array)) $sort_by = 'USER.LAST_LOGON';
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(USER.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER.LOGON_FROM, USER.STATUS FROM {$table_prefix}USER USER ";
    $sql.= "LEFT JOIN {$table_prefix}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "WHERE (LOGON LIKE '$usersearch%' OR NICKNAME LIKE '$usersearch%') ";
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

    $sort_array = array('USER.UID', 'USER.LOGON', 'USER.STATUS', 
                        'USER.LAST_LOGON', 'USER.LOGON_FROM', 'SESSIONS.SESSID');

    if (!is_numeric($offset)) $offset = 0;
    if (!in_array($sort_by, $sort_array)) $sort_by = 'LAST_LOGON';
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(USER.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER.LOGON_FROM, USER.STATUS, SESSIONS.SESSID FROM {$table_prefix}USER USER ";
    $sql.= "LEFT JOIN {$table_prefix}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "LEFT JOIN {$table_prefix}SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";    
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
    
    $table_prefix = get_table_prefix();
    
    $sql = "DELETE FROM SESSIONS WHERE UID = '$uid'";
    $result = db_query($sql, $db_admin_session_end);
    
    return (db_affected_rows($db_admin_session_end) > 0);
}

?>