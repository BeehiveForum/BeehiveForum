<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';

function get_forum_list($page = 1)
{
    if (!$db_get_forum_list = db_connect()) return false;

    if (!is_numeric($page)) return false;

    $offset = calculate_page_offset($page, 10);

    $forums_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS CONCAT(FORUMS.DATABASE_NAME, '`.`', FORUMS.WEBTAG, '_') AS PREFIX, ";
    $sql.= "FORUM_SETTINGS_NAME.SVALUE AS FORUM_NAME, FORUM_SETTINGS_DESC.SVALUE AS FORUM_DESC, ";
    $sql.= "FORUMS.FID, FORUMS.WEBTAG, FORUMS.ACCESS_LEVEL FROM FORUMS ";
    $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_NAME ON (FORUM_SETTINGS_NAME.FID = FORUMS.FID AND FORUM_SETTINGS_NAME.SNAME = 'forum_name') ";
    $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_DESC ON (FORUM_SETTINGS_DESC.FID = FORUMS.FID AND FORUM_SETTINGS_DESC.SNAME = 'forum_desc') ";
    $sql.= "WHERE FORUMS.ACCESS_LEVEL > -1 AND FORUMS.ACCESS_LEVEL < 3 ORDER BY FORUMS.FID LIMIT $offset, 10";

    if (!$result_forums = db_query($sql, $db_get_forum_list)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_get_forum_list)) return false;

    list($forums_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if ((db_num_rows($result) == 0) && ($forums_count > 0) && ($page > 1)) {
        return get_forum_list($page - 1);
    }        

    while (($forum_data = db_fetch_array($result_forums))) {

        if (!isset($forum_data['FORUM_NAME']) || strlen(trim($forum_data['FORUM_NAME'])) < 1) {
            $forum_data['FORUM_NAME'] = "A Beehive Forum";
        }

        if (!isset($forum_data['FORUM_DESC']) || strlen(trim($forum_data['FORUM_DESC'])) < 1) {
            $forum_data['FORUM_DESC'] = "";
        }

        $sql = "SELECT COUNT(PID) AS POST_COUNT FROM `{$forum_data['PREFIX']}POST` POST ";

        if (!$result_post_count = db_query($sql, $db_get_forum_list)) return false;

        $forum_post_data = db_fetch_array($result_post_count);

        if (!isset($forum_post_data['POST_COUNT']) || is_null($forum_post_data['POST_COUNT'])) {
            $forum_data['MESSAGES'] = 0;
        } else {
            $forum_data['MESSAGES'] = $forum_post_data['POST_COUNT'];
        }

        $forums_array[] = $forum_data;
    }

    return array(
        'forums_array' => $forums_array,
        'forums_count' => $forums_count
    );
}

function get_my_forums($view_type, $page = 1, $sort_by = 'LAST_VISIT', $sort_dir = 'DESC')
{
    if (!$db_get_my_forums = db_connect()) return false;

    if (!is_numeric($view_type)) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    $sort_by_array  = array(
        'FORUM_NAME', 
        'FORUM_DESC', 
        'LAST_VISIT'
    );

    $sort_dir_array = array(
        'ASC', 
        'DESC'
    );

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'LAST_VISIT';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (($uid = session::get_value('UID')) === false) return false;

    $forums_array = array();

    if ($view_type == FORUMS_SHOW_ALL) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS CONCAT(FORUMS.DATABASE_NAME, '`.`', FORUMS.WEBTAG, '_') AS PREFIX, ";
        $sql.= "FORUM_SETTINGS_NAME.SVALUE AS FORUM_NAME, FORUM_SETTINGS_DESC.SVALUE AS FORUM_DESC, ";
        $sql.= "FORUMS.FID, FORUMS.WEBTAG, FORUMS.ACCESS_LEVEL, USER_FORUM.INTEREST, UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM FORUMS ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_NAME ON (FORUM_SETTINGS_NAME.FID = FORUMS.FID AND FORUM_SETTINGS_NAME.SNAME = 'forum_name') ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_DESC ON (FORUM_SETTINGS_DESC.FID = FORUMS.FID AND FORUM_SETTINGS_DESC.SNAME = 'forum_desc') ";
        $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
        $sql.= "WHERE FORUMS.ACCESS_LEVEL > -1  AND FORUMS.ACCESS_LEVEL < 3 AND (USER_FORUM.INTEREST > -1 ";
        $sql.= "OR USER_FORUM.INTEREST IS NULL) ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    } else if ($view_type == FORUMS_SHOW_FAVS) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS CONCAT(FORUMS.DATABASE_NAME, '`.`', FORUMS.WEBTAG, '_') AS PREFIX, ";
        $sql.= "FORUM_SETTINGS_NAME.SVALUE AS FORUM_NAME, FORUM_SETTINGS_DESC.SVALUE AS FORUM_DESC, ";
        $sql.= "FORUMS.FID, FORUMS.WEBTAG, FORUMS.ACCESS_LEVEL, USER_FORUM.INTEREST, UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM FORUMS ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_NAME ON (FORUM_SETTINGS_NAME.FID = FORUMS.FID AND FORUM_SETTINGS_NAME.SNAME = 'forum_name') ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_DESC ON (FORUM_SETTINGS_DESC.FID = FORUMS.FID AND FORUM_SETTINGS_DESC.SNAME = 'forum_desc') ";
        $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
        $sql.= "WHERE FORUMS.ACCESS_LEVEL > -1 AND FORUMS.ACCESS_LEVEL < 3 AND USER_FORUM.INTEREST = 1 ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    } else if ($view_type == FORUMS_SHOW_IGNORED) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS CONCAT(FORUMS.DATABASE_NAME, '`.`', FORUMS.WEBTAG, '_') AS PREFIX, ";
        $sql.= "FORUM_SETTINGS_NAME.SVALUE AS FORUM_NAME, FORUM_SETTINGS_DESC.SVALUE AS FORUM_DESC, ";
        $sql.= "FORUMS.FID, FORUMS.WEBTAG, FORUMS.ACCESS_LEVEL, USER_FORUM.INTEREST, UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM FORUMS ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_NAME ON (FORUM_SETTINGS_NAME.FID = FORUMS.FID AND FORUM_SETTINGS_NAME.SNAME = 'forum_name') ";
        $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_DESC ON (FORUM_SETTINGS_DESC.FID = FORUMS.FID AND FORUM_SETTINGS_DESC.SNAME = 'forum_desc') ";
        $sql.= "LEFT JOIN USER_FORUM ON (USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '$uid') ";
        $sql.= "WHERE FORUMS.ACCESS_LEVEL > -1 AND FORUMS.ACCESS_LEVEL < 3 AND USER_FORUM.INTEREST = -1 ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";
    }

    if (!$result_forums = db_query($sql, $db_get_my_forums)) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_get_my_forums)) return false;

    list($forums_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if ((db_num_rows($result) == 0) && ($forums_count > 0) && ($page > 1)) {
        return get_my_forums($view_type, $page - 1, $sort_by, $sort_dir);
    }        

    while (($forum_data = db_fetch_array($result_forums, DB_RESULT_ASSOC))) {

        $forum_fid = $forum_data['FID'];

        if (!isset($forum_data['FORUM_NAME']) || strlen(trim($forum_data['FORUM_NAME'])) < 1) {
            $forum_data['FORUM_NAME'] = gettext("A Beehive Forum");
        }

        if (!isset($forum_data['FORUM_DESC']) || strlen(trim($forum_data['FORUM_DESC'])) < 1) {
            $forum_data['FORUM_DESC'] = "";
        }

        if (!isset($forum_data['LAST_VISIT']) || is_null($forum_data['LAST_VISIT'])) {
            $forum_data['LAST_VISIT'] = 0;
        }

        $unread_cutoff_datetime = forum_get_unread_cutoff_datetime();

        $folders = folder_get_available_by_forum($forum_fid);

        if ($unread_cutoff_datetime !== false) {

            $sql = "SELECT SUM(THREAD.LENGTH) - SUM(COALESCE(USER_THREAD.LAST_READ, 0)) FROM `{$forum_data['PREFIX']}THREAD` THREAD ";
            $sql.= "LEFT JOIN `{$forum_data['PREFIX']}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
            $sql.= "LEFT JOIN `{$forum_data['PREFIX']}USER_FOLDER` USER_FOLDER ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
            $sql.= "WHERE THREAD.FID IN ($folders) AND (USER_FOLDER.INTEREST > -1 OR USER_FOLDER.INTEREST IS NULL) ";
            $sql.= "AND (USER_THREAD.INTEREST > -1 OR USER_THREAD.INTEREST IS NULL) ";
            $sql.= "AND (THREAD.MODIFIED > CAST('$unread_cutoff_datetime' AS DATETIME)) ";

            if (!$result_unread_count = db_query($sql, $db_get_my_forums)) return false;

            list($unread_messages) = db_fetch_array($result_unread_count, DB_RESULT_NUM);

            $forum_data['UNREAD_MESSAGES'] = $unread_messages;

        } else {

            $forum_data['UNREAD_MESSAGES'] = 0;
        }

        $sql = "SELECT COALESCE(SUM(THREAD.LENGTH), 0) FROM `{$forum_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$forum_data['PREFIX']}USER_THREAD` USER_THREAD ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '$uid') ";
        $sql.= "LEFT JOIN `{$forum_data['PREFIX']}USER_FOLDER` USER_FOLDER ON (USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = '$uid') ";
        $sql.= "WHERE THREAD.FID IN ($folders) AND (USER_FOLDER.INTEREST > -1 OR USER_FOLDER.INTEREST IS NULL) ";
        $sql.= "AND (USER_THREAD.INTEREST > -1 OR USER_THREAD.INTEREST IS NULL) ";

        if (!$result_messages_count = db_query($sql, $db_get_my_forums)) return false;

        list($num_messages) = db_fetch_array($result_messages_count, DB_RESULT_NUM);

        $forum_data['NUM_MESSAGES'] = $num_messages;

        $sql = "SELECT COUNT(POST.PID) AS UNREAD_TO_ME ";
        $sql.= "FROM `{$forum_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$forum_data['PREFIX']}POST` POST ";
        $sql.= "ON (POST.TID = THREAD.TID) WHERE THREAD.FID IN ($folders) ";
        $sql.= "AND POST.TO_UID = '$uid' AND POST.VIEWED IS NULL ";

        if (!$result_unread_to_me = db_query($sql, $db_get_my_forums)) return false;

        list($unread_to_me) = db_fetch_array($result_unread_to_me, DB_RESULT_NUM);

        $forum_data['UNREAD_TO_ME'] = $unread_to_me;

        if ($forum_data['NUM_MESSAGES'] < 0) $forum_data['NUM_MESSAGES'] = 0;

        if ($forum_data['UNREAD_MESSAGES'] < 0) $forum_data['UNREAD_MESSAGES'] = 0;

        if ($forum_data['UNREAD_TO_ME'] < 0) $forum_data['UNREAD_TO_ME'] = 0;

        $forums_array[] = $forum_data;
    }

    return array(
        'forums_array' => $forums_array,
        'forums_count' => $forums_count
    );
}

function user_set_forum_interest($fid, $interest)
{
    if (!$db_user_set_forum_interest = db_connect()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!is_numeric($fid)) return false;

    if (!is_numeric($interest)) return false;

    if (!session::logged_in()) return false;

    $sql = "INSERT INTO USER_FORUM (UID, FID, INTEREST) ";
    $sql.= "VALUES ('$uid', '$fid', '$interest') ";
    $sql.= "ON DUPLICATE KEY UPDATE INTEREST = VALUES(INTEREST)";

    if (!db_query($sql, $db_user_set_forum_interest)) return false;

    return true;
}

function forums_any_favourites()
{
    if (!$db_forums_any_favourites = db_connect()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    $sql = "SELECT COUNT(FID) AS FAV_COUNT FROM USER_FORUM ";
    $sql.= "WHERE INTEREST = 1 AND UID = '$uid'";

    if (!$result = db_query($sql, $db_forums_any_favourites)) return false;

    list($fav_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $fav_count > 0;
}

?>