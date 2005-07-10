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

/* $Id: myforums.inc.php,v 1.48 2005-07-10 21:28:34 decoyduck Exp $ */

include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

function get_forum_list()
{
    $lang = load_language_file();

    $db_get_forum_list = db_connect();
    $get_forum_list_array = array();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT FORUMS.*, USER_FORUM.INTEREST FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID ";
    $sql.= "AND USER_FORUM.UID = $uid) WHERE FORUMS.ACCESS_LEVEL > -1 ";
    $sql.= "ORDER BY FORUMS.FID";

    $result_forums = db_query($sql, $db_get_forum_list);

    if (db_num_rows($result_forums) > 0) {

        while ($forum_data = db_fetch_array($result_forums)) {

            $forum_fid = $forum_data['FID'];

            $forum_settings = forum_get_settings_by_fid($forum_fid);

            foreach($forum_settings as $key => $value) {
                if (!isset($forum_data[strtoupper($key)])) {
                    $forum_data[strtoupper($key)] = $value;
                }
            }

            if (!isset($forum_data['FORUM_DESC'])) {
                $forum_data['FORUM_DESC'] = "";
            }

            // Get number of messages on forum

            $sql = "SELECT COUNT(*) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
            $result_post_count = db_query($sql, $db_get_forum_list);

            if (db_num_rows($result_post_count) > 0) {

                $row = db_fetch_array($result_post_count);
                $forum_data['MESSAGES'] = $row['POST_COUNT'];

            }else {

                $forum_data['MESSAGES'] = 0;
            }

            $result_description = db_query($sql, $db_get_forum_list);

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
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID ";
    $sql.= "AND USER_FORUM.UID = $uid) WHERE FORUMS.ACCESS_LEVEL > -1 ";
    $sql.= "ORDER BY FORUMS.FID";

    $result_forums = db_query($sql, $db_get_my_forums);

    if (db_num_rows($result_forums) > 0) {

        while ($forum_data = db_fetch_array($result_forums)) {

            $forum_fid = $forum_data['FID'];

            $forum_settings = forum_get_settings_by_fid($forum_fid);

            foreach($forum_settings as $key => $value) {
                if (!isset($forum_data[strtoupper($key)])) {
                    $forum_data[strtoupper($key)] = $value;
                }
            }

            if (!isset($forum_data['FORUM_NAME'])) {
                $forum_data['FORUM_NAME'] = "A Beehive Forum";
            }

            if (!isset($forum_data['FORUM_DESC'])) {
                $forum_data['FORUM_DESC'] = "";
            }

            // Get any unread messages

            $folders = folder_get_available($forum_fid);

            $user_ignored = USER_IGNORED;
            $user_ignored_completely = USER_IGNORED_COMPLETELY;

            $sql = "SELECT SUM(THREAD.LENGTH) - SUM(USER_THREAD.LAST_READ) ";
            $sql.= "AS UNREAD_MESSAGES, SUM(THREAD.LENGTH) AS NUM_MESSAGES ";
            $sql.= "FROM {$forum_data['WEBTAG']}_THREAD THREAD ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_THREAD USER_THREAD ";
            $sql.= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_FOLDER USER_FOLDER ON ";
            $sql.= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_PEER USER_PEER ON ";
            $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
            $sql.= "WHERE THREAD.FID IN ($folders) ";
            $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
            $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
            $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
            $sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";
            $sql.= "AND (USER_THREAD.INTEREST IS NULL OR USER_THREAD.INTEREST > -1) ";
            $sql.= "AND (USER_FOLDER.INTEREST IS NULL OR USER_FOLDER.INTEREST > -1)";

            $result_post_count = db_query($sql, $db_get_my_forums);

            $row = db_fetch_array($result_post_count);

            if (!isset($row['UNREAD_MESSAGES']) || is_null($row['UNREAD_MESSAGES'])) {
                $forum_data['UNREAD_MESSAGES'] = $row['NUM_MESSAGES'];
            }else {
                $forum_data['UNREAD_MESSAGES'] = $row['UNREAD_MESSAGES'];
            }

            // Get unread to me message count

            $sql = "SELECT COUNT(POST.PID) AS UNREAD_TO_ME FROM ";
            $sql.= "{$forum_data['WEBTAG']}_POST POST ";
            $sql.= "LEFT JOIN {$forum_data['WEBTAG']}_USER_PEER USER_PEER ON ";
            $sql.= "(USER_PEER.UID = $uid AND USER_PEER.PEER_UID = POST.FROM_UID) ";
            $sql.= "WHERE POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
            $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 ";
            $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
            $sql.= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 ";
            $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";

            $result_unread_to_me = db_query($sql, $db_get_my_forums);

            $row = db_fetch_array($result_unread_to_me);
            $forum_data['UNREAD_TO_ME'] = $row['UNREAD_TO_ME'];

            // Get Last Visited

            $sql = "SELECT UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG ";
            $sql.= "WHERE UID = '$uid' AND FORUM = $forum_fid ";
            $sql.= "AND LAST_LOGON IS NOT NULL AND LAST_LOGON > 0";

            $result_last_visit = db_query($sql, $db_get_my_forums);

            if (db_num_rows($result_last_visit) > 0) {

                $row = db_fetch_array($result_last_visit);
                $forum_data['LAST_LOGON'] = $row['LAST_LOGON'];

            }else{

                $forum_data['LAST_LOGON'] = 0;
            }

            if (isset($forum_data['INTEREST']) && $forum_data['INTEREST'] == 1) {

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