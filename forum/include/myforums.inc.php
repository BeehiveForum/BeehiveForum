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
    $get_my_forums_array = array();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, FORUM_SETTINGS.SVALUE AS FORUM_NAME ";
    $sql.= "FROM FORUMS FORUMS LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON ";
    $sql.= "(FORUMS.FID = FORUM_SETTINGS.FID AND FORUM_SETTINGS.SNAME = 'forum_name')";

    $result = db_query($sql, $db_get_my_forums); 

    while ($forum_data = db_fetch_array($result)) {  

        if (isset($forum_data['WEBTAG']) && isset($forum_data['FID'])) {

	    if (!isset($forum_data['FORUM_NAME']) || strlen(trim($forum_data['FORUM_NAME'])) == 0) {
	        $forum_data['FORUM_NAME'] = "Unnamed Forum";
	    }

            // Get unread message count
        
            $sql = "SELECT THREAD.LENGTH, USER_THREAD.LAST_READ ";
            $sql.= "FROM {$forum_data['WEBTAG']}_THREAD THREAD ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ON ";
            $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
	    $sql.= "WHERE USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL";

            $result = db_query($sql, $db_get_my_forums);

	    $forum_data['UNREAD_MESSAGES'] = 0;
        
            if (db_num_rows($result)) {
	        while ($row = db_fetch_array($result)) {
                    if (isset($row['LAST_READ']) && ($row['LAST_READ'] < $row['LENGTH'])) {
		        $forum_data['UNREAD_MESSAGES']+= $row['LENGTH'] - $row['LAST_READ'];
		    }else {
		        $forum_data['UNREAD_MESSAGES']+= $row['LENGTH'];
		    }
	        }
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
        
            $sql = "SELECT LAST_LOGON FROM VISITOR_LOG WHERE FID = {$forum_data['FID']} AND UID = '$uid'";
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

	    $get_my_forums_array[] = $forum_data;
	}
    }

    return $get_my_forums_array;
}

?>