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

/* $Id: admin.inc.php,v 1.6 2003-08-01 20:53:00 decoyduck Exp $ */

function admin_addlog($uid, $fid, $tid, $pid, $psid, $piid, $action)
{
    $db_admin_addlog = db_connect();
    $admin_uid = bh_session_get_value('UID');

    $sql = "INSERT INTO ". forum_table("ADMIN_LOG"). " (LOG_TIME, ADMIN_UID, UID, FID, TID, PID, PSID, PIID, ACTION) ";
    $sql.= "VALUES (NOW(), '$admin_uid', '$uid', '$fid', '$tid', '$pid', '$psid', '$piid', '$action')";

    $result = db_query($sql, $db_admin_addlog);

    return $result;
}

function admin_clearlog()
{
    $db_admin_clearlog = db_connect();

    if ((bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {

        $sql = "DELETE FROM ". forum_table("ADMIN_LOG");
	$result = db_query($sql, $db_admin_clearlog);
    }
}

function admin_get_log_entries($offset, $sort_by, $sort_dir)
{
    $db_admin_get_log_entries = db_connect();

    $sql = "SELECT ADMIN_LOG.LOG_ID, UNIX_TIMESTAMP(ADMIN_LOG.LOG_TIME) AS LOG_TIME, ADMIN_LOG.ADMIN_UID, ";
    $sql.= "ADMIN_LOG.UID, AUSER.LOGON AS ALOGON, AUSER.NICKNAME AS ANICKNAME, USER.LOGON, USER.NICKNAME, ";
    $sql.= "ADMIN_LOG.FID, ADMIN_LOG.TID, ADMIN_LOG.PID, FOLDER.TITLE AS FOLDER_TITLE, THREAD.TITLE AS THREAD_TITLE, ";
    $sql.= "ADMIN_LOG.PSID, ADMIN_LOG.PIID, PS.NAME AS PS_NAME, PI.NAME AS PI_NAME, ADMIN_LOG.ACTION ";
    $sql.= "FROM ". forum_table("ADMIN_LOG"). " ADMIN_LOG ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " AUSER ON (AUSER.UID = ADMIN_LOG.ADMIN_UID) ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "LEFT JOIN ". forum_table("PROFILE_SECTION"). " PS ON (PS.PSID = ADMIN_LOG.PSID) ";
    $sql.= "LEFT JOIN ". forum_table("PROFILE_ITEM"). " PI ON (PI.PIID = ADMIN_LOG.PIID) ";
    $sql.= "LEFT JOIN ". forum_table("FOLDER"). " FOLDER ON (FOLDER.FID = ADMIN_LOG.FID) ";
    $sql.= "LEFT JOIN ". forum_table("THREAD"). " THREAD ON (THREAD.TID = ADMIN_LOG.TID) ";
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

?>