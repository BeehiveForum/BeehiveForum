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

function get_forum_list()
{
    $db_get_forum_list = db_connect();
    $get_forum_list_array = array();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, FORUM_SETTINGS.SVALUE AS FORUM_NAME ";
    $sql.= "FROM FORUMS FORUMS LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON ";
    $sql.= "(FORUMS.FID = FORUM_SETTINGS.FID AND FORUM_SETTINGS.SNAME = 'forum_name')";

    $result = db_query($sql, $db_get_forum_list); 

    while ($row = db_fetch_array($result)) {  
        
        $forum_data = $row;

	if (isset($forum_data['FORUM_NAME'])) {
	    $forum_data['FORUM_NAME'] = "Unknown Forum";
	}

	if ($uid <> 0) {

            // Get unread message count
        
            $sql = "SELECT COUNT(*) AS POST_COUNT FROM {$forum_data['WEBTAG']}_THREAD THREAD ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ";
            $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = '$uid') ";
            $sql.= "WHERE THREAD.LENGTH > USER_THREAD.LAST_READ ";

            $result = db_query($sql, $db_get_forum_list);
        
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $unread_message_count = $row['POST_COUNT'];
		$message_count = 0;
        
            }else {
        
                $unread_message_count = 0;
		$message_count = 0;
            }

            // Get unread to me message count
        
            $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
	    $sql.= "WHERE TO_UID = '$uid' AND VIEWED IS NULL";

            $result = db_query($sql, $db_get_forum_list);
        
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $unread_to_me_message_count = $row['POST_COUNT'];
        
            }else {
        
                $unread_to_me_message_count = 0;
            }
        
            $sql = "SELECT LAST_LOGON FROM VISITOR_LOG WHERE FID = {$forum_data['FID']} AND UID = '$uid'";
            $result = db_query($sql, $db_get_forum_list);
        
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $last_visit = $row['LAST_LOGON'];
        
            }else{
          
                $last_visit = "Never";
            }

	}else {

            $unread_message_count = 0;
	    $unread_to_me_message_count = 0;
	    $last_visit = "Never";
        
            $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
            $result = db_query($sql, $db_get_forum_list);
        
            if (db_num_rows($result)) {
        
                $row = db_fetch_array($result);
                $message_count = $row['POST_COUNT'];
        
            }else {
        
                $message_count = 0;
            }
        }
        
        $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
        $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
        $sql.= "FORUM_SETTINGS.SNAME = 'description'";

        $result = db_query($sql, $db_get_forum_list);

        if (db_num_rows($result)) {
            
            $row = db_fetch_array($lv_result);
            $forum_description = $row['SVALUE'];
            
        }else{
            
            $forum_description = "";
        }

	$get_forum_list_array[] = array('FID'         => $forum_data['FID'],
	                                'WEBTAG'      => $forum_data['WEBTAG'],
					'FORUM_NAME'  => $forum_data['FORUM_NAME'],
					'DESCRIPTION' => $forum_description,
					'MESSAGES'    => $message_count,
					'UMESSAGES'   => $unread_message_count,
                                        'UNREADTOME'  => $unread_to_me_message_count,
                                        'LAST_VISIT'  => $last_visit);
    }

    return $get_forum_list_array;
}

?>