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

/* $Id: myforums.inc.php,v 1.28 2004-04-24 18:42:45 decoyduck Exp $ */

include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/threads.inc.php");

function get_forum_list()
{
    $lang = load_language_file();

    $db_get_forum_list = db_connect();
    $get_forum_list_array = array();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT FORUMS.*, USER_FORUM.INTEREST FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON ";
    $sql.= "(USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
    $sql.= "WHERE FORUMS.ACCESS_LEVEL = 0 OR (FORUMS.ACCESS_LEVEL = 1 ";
    $sql.= "AND USER_FORUM.ALLOWED = 1) ";
    $sql.= "ORDER BY FORUMS.FID";

    $result_forums = db_query($sql, $db_get_forum_list);

    if (db_num_rows($result_forums)) {

        while ($forum_data = db_fetch_array($result_forums)) {

            $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
            $sql.= "WHERE SNAME = 'forum_name' AND FID = '{$forum_data['FID']}'";

	    $result_forum_name = db_query($sql, $db_get_forum_list);

	    if (db_num_rows($result_forum_name)) {

	        $row = db_fetch_array($result_forum_name);
	        $forum_data['FORUM_NAME'] = $row['FORUM_NAME'];

	    }else {

	        $forum_data['FORUM_NAME'] = $lang['unnamedforum'];
	    }

            // Get number of messages on forum

            $sql = "SELECT COUNT(*) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
            $result_post_count = db_query($sql, $db_get_forum_list);

            if (db_num_rows($result_post_count)) {

                $row = db_fetch_array($result_post_count);
                $forum_data['MESSAGES'] = $row['POST_COUNT'];

            }else {

                $forum_data['MESSAGES'] = 0;
            }

            $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
            $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
            $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

            $result_description = db_query($sql, $db_get_forum_list);

            if (db_num_rows($result_description)) {

                $row = db_fetch_array($result_description);
                $forum_data['DESCRIPTION'] = $row['SVALUE'];

            }else{

                $forum_data['DESCRIPTION'] = "";
            }

	    $get_forum_list_array[] = $forum_data;
        }

        return $get_forum_list_array;
    }

    return false;
}

function get_my_forums()
{
    $lang = load_language_file();

    $db_get_my_forums = db_connect();

    $get_my_forums_array = array('FAV_FORUMS'    => array(),
                                 'RECENT_FORUMS' => array(),
                                 'OTHER_FORUMS'  => array());

    $uid = bh_session_get_value('UID');

    $sql = "SELECT FORUMS.*, USER_FORUM.INTEREST FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON ";
    $sql.= "(USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
    $sql.= "WHERE FORUMS.ACCESS_LEVEL = 0 OR (FORUMS.ACCESS_LEVEL = 1 ";
    $sql.= "AND USER_FORUM.ALLOWED = 1) ";
    $sql.= "ORDER BY FORUMS.FID";

    $result_forums = db_query($sql, $db_get_my_forums);

    if (db_num_rows($result_forums)) {

        while ($forum_data = db_fetch_array($result_forums)) {

            $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
            $sql.= "WHERE SNAME = 'forum_name' AND FID = '{$forum_data['FID']}'";

	    $result_forum_name = db_query($sql, $db_get_my_forums);

	    if (db_num_rows($result_forum_name)) {

	        $row = db_fetch_array($result_forum_name);
	        $forum_data['FORUM_NAME'] = $row['FORUM_NAME'];

	    }else {

	        $forum_data['FORUM_NAME'] = $lang['unnamedforum'];
	    }

	    // Make sure the Forum Interest Level is set.

	    if (!isset($forum_data['INTEREST'])) {
	        $forum_data['INTEREST'] = 0;
	    }

            // Get any unread messages

            $folders = threads_get_available_folders();

            $sql = "SELECT COUNT(POST.PID) AS UNREAD_MESSAGES FROM {$forum_data['WEBTAG']}_POST POST ";
	    $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_THREAD THREAD ON ";
            $sql.= "(THREAD.TID = POST.TID) ";
	    $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ON ";
            $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
            $sql.= "WHERE THREAD.FID IN ($folders) ";
            $sql.= "AND ((USER_THREAD.LAST_READ < THREAD.LENGTH AND USER_THREAD.LAST_READ < POST.PID) ";
            $sql.= "OR USER_THREAD.LAST_READ IS NULL) ";

            $result_post_count = db_query($sql, $db_get_my_forums);

	    $row = db_fetch_array($result_post_count);
	    $forum_data['UNREAD_MESSAGES'] = $row['UNREAD_MESSAGES'];

            // Get unread to me message count

            $sql = "SELECT COUNT(POST.PID) AS UNREAD_TO_ME FROM {$forum_data['WEBTAG']}_THREAD THREAD ";
	    $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ON ";
            $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_POST POST ON ";
            $sql.= "(POST.TID = THREAD.TID) ";
            $sql.= "WHERE THREAD.FID IN ($folders) ";
            $sql.= "AND (POST.PID > USER_THREAD.LAST_READ OR USER_THREAD.LAST_READ IS NULL) ";
            $sql.= "AND POST.TO_UID = '$uid' AND POST.VIEWED IS NULL";

            $result_unread_to_me = db_query($sql, $db_get_my_forums);

            $row = db_fetch_array($result_unread_to_me);
	    $forum_data['UNREAD_TO_ME'] = $row['UNREAD_TO_ME'];

            // Get Last Visited

            $sql = "SELECT UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON ";
            $sql.= "FROM VISITOR_LOG WHERE FID = {$forum_data['FID']} ";
            $sql.= "AND UID = '$uid'";

            $result_last_visit = db_query($sql, $db_get_my_forums);

            if (db_num_rows($result_last_visit)) {

                $row = db_fetch_array($result_last_visit);
                $forum_data['LAST_LOGON'] = $row['LAST_LOGON'];

            }else{

                $forum_data['LAST_LOGON'] = 0;
            }

            // Get Forum Description

            $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
            $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
            $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

            $result_description = db_query($sql, $db_get_my_forums);

            if (db_num_rows($result_description)) {

                $row = db_fetch_array($result_description);
                $forum_data['DESCRIPTION'] = $row['SVALUE'];

            }else{

                $forum_data['DESCRIPTION'] = "";
            }

	    if ($forum_data['INTEREST'] == 1) {
  	        $get_my_forums_array['FAV_FORUMS'][] = $forum_data;
	    }else {
	        if ($forum_data['LAST_LOGON'] > 0) {
  	            $get_my_forums_array['RECENT_FORUMS'][] = $forum_data;
		}else {
		    $get_my_forums_array['OTHER_FORUMS'][] = $forum_data;
		}
	    }
        }

        return $get_my_forums_array;
    }

    return false;
}

function user_set_forum_interest($fid, $interest)
{
    $db_user_set_forum_interest = db_connect();

    $uid = bh_session_get_value('UID');

    if (!is_numeric($fid)) return false;
    if (!is_numeric($interest)) return false;

    $sql = "SELECT UID FROM USER_FORUM ";
    $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    $result = db_query($sql, $db_user_set_forum_interest);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE USER_FORUM SET INTEREST = '$interest' ";
        $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    }else {

        $sql = "INSERT INTO USER_FORUM (UID, FID, INTEREST) ";
	$sql.= "VALUES ('$uid', '$fid', 1)";
    }

    return db_query($sql, $db_user_set_forum_interest);
}

?>