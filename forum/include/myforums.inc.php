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

require_once("./include/html.inc.php");
require_once("./include/threads.inc.php");

function get_forum_list()
{
    $db_get_forum_list = db_connect();
    $get_forum_list_array = array();

    $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, FORUM_SETTINGS.SVALUE AS FORUM_NAME ";
    $sql.= "FROM FORUMS FORUMS LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON ";
    $sql.= "(FORUMS.FID = FORUM_SETTINGS.FID AND FORUM_SETTINGS.SNAME = 'forum_name')";

    $result = db_query($sql, $db_get_forum_list); 

    while ($forum_data = db_fetch_array($result)) {  
        
        if (isset($forum_data['WEBTAG']) && isset($forum_data['FID'])) {

	    if (!isset($forum_data['FORUM_NAME']) || strlen(trim($forum_data['FORUM_NAME'])) == 0) {
	        $forum_data['FORUM_NAME'] = "Unnamed Forum";
	    }

    	    // Get number of messages on forum

            $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
            $result = db_query($sql, $db_get_forum_list);
        
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $forum_data['MESSAGES'] = $row['POST_COUNT'];
        
            }else {
        
                $forum_data['MESSAGES'] = 0;
            }
        
            $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
            $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
            $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

            $result = db_query($sql, $db_get_forum_list);

            if (db_num_rows($result)) {
            
                $row = db_fetch_array($result);
                $forum_data['DESCRIPTION'] = $row['SVALUE'];
            
            }else{
            
                $forum_data['DESCRIPTION'] = "";
            }

	    $get_forum_list_array[] = $forum_data;
	}
    }

    return $get_forum_list_array;
}

function get_my_forums()
{
    $db_get_my_forums = db_connect();

    $get_my_forums_array = array('FAVOURITES' => array(),
                                 'FORUMS'     => array());

    $uid = bh_session_get_value('UID');

    $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, USER_FORUM.INTEREST, ";
    $sql.= "FORUM_SETTINGS.SVALUE AS FORUM_NAME FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID)";
    $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON ";
    $sql.= "(FORUMS.FID = FORUM_SETTINGS.FID AND FORUM_SETTINGS.SNAME = 'forum_name') ";

    $result = db_query($sql, $db_get_my_forums); 

    while ($forum_data = db_fetch_array($result)) {  

        if (isset($forum_data['WEBTAG']) && isset($forum_data['FID'])) {

	    // Make sure the Forum Name is set

	    if (!isset($forum_data['FORUM_NAME']) || strlen(trim($forum_data['FORUM_NAME'])) == 0) {
	        $forum_data['FORUM_NAME'] = "Unnamed Forum";
	    }

	    // Make sure the Forum Interest Level is set.

	    if (!isset($forum_data['INTEREST'])) {
	        $forum_data['INTEREST'] = 0;
	    }

            // Get any new messages since last visit

	    $folders = threads_get_available_folders();

            $sql = "SELECT COUNT(POST.PID) AS NEW_MESSAGES ";
            $sql.= "FROM {$forum_data['WEBTAG']}_POST POST ";
	    $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_THREAD THREAD ON (POST.TID = THREAD.TID) ";
	    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (VISITOR_LOG.UID = $uid) ";
	    $sql.= "WHERE THREAD.FID IN ($folders) AND POST.CREATED >= VISITOR_LOG.LAST_LOGON";

            $result = db_query($sql, $db_get_my_forums);

	    $forum_data['NEW_MESSAGES'] = 0;
        
            if (db_num_rows($result)) {
	        $row = db_fetch_array($result);
		$forum_data['NEW_MESSAGES'] = $row['NEW_MESSAGES'];
	    }

            // Get unread to me message count
        
            $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
            $sql.= "WHERE TO_UID = '$uid' AND VIEWED IS NULL";

            $result = db_query($sql, $db_get_my_forums);
        
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $forum_data['UNREAD_TO_ME'] = $row['POST_COUNT'];
        
            }else {
        
                $forum_data['UNREAD_TO_ME'] = 0;
            }

            // Get Last Visited
        
            $sql = "SELECT UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON ";
            $sql.= "FROM VISITOR_LOG WHERE FID = {$forum_data['FID']} ";
            $sql.= "AND UID = '$uid'";

            $result = db_query($sql, $db_get_my_forums);
         
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $forum_data['LAST_LOGON'] = $row['LAST_LOGON'];
        
            }else{
        
                $forum_data['LAST_LOGON'] = "Never";
            }

            // Get Forum Description
        
            $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
            $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
            $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

            $result = db_query($sql, $db_get_my_forums);

            if (db_num_rows($result)) {
            
                $row = db_fetch_array($result);
                $forum_data['DESCRIPTION'] = $row['SVALUE'];
            
            }else{
            
                $forum_data['DESCRIPTION'] = "";
            }

	    if ($forum_data['INTEREST'] == 1) {
  	        $get_my_forums_array['FAVOURITES'][] = $forum_data;
	    }else {
  	        $get_my_forums_array['FORUMS'][] = $forum_data;
	    }
	}
    }

    return $get_my_forums_array;
}

function user_set_forum_interest($fid, $interest)
{
    $db_user_set_forum_interest = db_connect();

    $uid = bh_session_get_value('UID');

    if (!is_numeric($fid)) return false;
    if (!is_numeric($interest)) return false;

    $sql = "UPDATE USER_FORUM SET INTEREST = '$interest' ";
    $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    $result = db_query($sql, $db_user_set_forum_interest);

    if (!db_affected_rows($db_user_set_forum_interest)) {

        $sql = "INSERT INTO USER_FORUM (UID, FID, INTEREST) ";
	$sql.= "VALUES ('$uid', '$fid', 1)";

	$result = db_query($sql, $db_user_set_forum_interest);
    }

    return $result;
}

?>