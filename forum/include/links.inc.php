<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function links_get_in_folder($fid, $invisible = false, $sort_by = "TITLE", $sort_dir = "ASC", $offset = 0) // setting $invisible to true gets links that are marked as not visible too
{
    if (!$db_links_get_in_folder = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array = array('TITLE', 'DESCRIPTION', 'CREATED', 'RATING');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($fid)) return false;
    if (!is_numeric($offset)) return false;
    if (!is_bool($invisible)) $invisible = false;

    $offset = abs($offset);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'TITLE';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!$table_data = get_table_prefix()) return false;

    $links_array = array();

    if ($invisible === false) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql.= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql.= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_data['PREFIX']}LINKS` LINKS ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql.= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.FID = '$fid' ";
        $sql.= "AND LINKS.VISIBLE = 'Y' AND LINKS.APPROVED IS NOT NULL ";
        $sql.= "GROUP BY LINKS.LID ORDER BY $sort_by $sort_dir ";
        $sql.= "LIMIT $offset, 20";

    }else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql.= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql.= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_data['PREFIX']}LINKS` LINKS ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql.= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.FID = '$fid' ";
        $sql.= "AND LINKS.APPROVED IS NOT NULL GROUP BY LINKS.LID ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    if (!$result = db_query($sql, $db_links_get_in_folder)) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_links_get_in_folder)) return false;

    list($links_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($links_data = db_fetch_array($result))) {

            if (isset($links_data['LOGON']) && isset($links_data['PEER_NICKNAME'])) {
                if (!is_null($links_data['PEER_NICKNAME']) && strlen($links_data['PEER_NICKNAME']) > 0) {
                    $links_data['NICKNAME'] = $links_data['PEER_NICKNAME'];
                }
            }

            if (!isset($links_data['LOGON'])) $links_data['LOGON'] = $lang['unknownuser'];
            if (!isset($links_data['NICKNAME'])) $links_data['NICKNAME'] = "";

            $links_array[$links_data['LID']] = $links_data;
        }

    }else if ($links_count > 0) {

        $offset = floor(($links_count - 1) / 20) * 20;
        return links_get_in_folder($fid, $invisible, $sort_by, $sort_dir, $offset);
    }

    return array('links_count' => $links_count,
                 'links_array' => $links_array);
}

function links_folders_get($visible = true)
{
    if (!$db_links_folders_get = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;
    
    $visible = ($visible) ? "AND VISIBLE = 'Y'" : '';
    
    $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM `{$table_data['PREFIX']}LINKS_FOLDERS` ";
    $sql.= "WHERE PARENT_FID IS NULL $visible ORDER BY FID LIMIT 1";
        
    if (!$result = db_query($sql, $db_links_folders_get)) return false;

    if (db_num_rows($result) > 0) {

        $links_data = db_fetch_array($result);

        $top_level = $links_data['FID'];

        $folders[$links_data['FID']] =  $links_data;

        $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM `{$table_data['PREFIX']}LINKS_FOLDERS` ";
        $sql.= "WHERE FID NOT IN ($top_level) $visible ORDER BY NAME";

        if (!$result = db_query($sql, $db_links_folders_get)) return false;

        if (db_num_rows($result) > 0) {

            while (($links_data = db_fetch_array($result))) {

                $folders[$links_data['FID']] =  $links_data;
            }
        }

        return $folders;
    }

    return false;
}

function links_add($uri, $title, $description, $fid, $uid, $visible = true)
{
    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    $uri = db_escape_string($uri);

    $title = db_escape_string($title);
    $description = db_escape_string($description);

    if (!$db_links_add = db_connect()) return false;

    $visible = $visible ? "Y" : "N";

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!$table_data = get_table_prefix()) return false;
    
    if (forum_get_setting('require_link_approval', 'Y') && !perm_is_links_moderator($uid)) {

        $sql = "INSERT INTO `{$table_data['PREFIX']}LINKS` (URI, TITLE, DESCRIPTION, FID, ";
        $sql.= "UID, VISIBLE, CREATED, APPROVED) VALUES ('$uri', '$title', '$description', ";
        $sql.= "'$fid', '$uid', '$visible', CAST('$current_datetime' AS DATETIME), NULL)";
        
    } else {
        
        $sql = "INSERT INTO `{$table_data['PREFIX']}LINKS` (URI, TITLE, DESCRIPTION, FID, ";
        $sql.= "UID, VISIBLE, CREATED, APPROVED, APPROVED_BY) VALUES ('$uri', '$title', ";
        $sql.= "'$description', '$fid', '$uid', '$visible', CAST('$current_datetime' AS DATETIME), ";
        $sql.= "CAST('$current_datetime' AS DATETIME), '$uid')";
    }

    if (!db_query($sql, $db_links_add)) return false;
    
    if (forum_get_setting('require_link_approval', 'Y') && !perm_is_links_moderator($uid)) {
        admin_send_post_approval_notification($fid);
    }

    return true;
}

function links_create_top_folder($name)
{
    if (!$db_links_create_top_folder = db_connect()) return false;

    $name = db_escape_string($name);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "REPLACE INTO `{$table_data['PREFIX']}LINKS_FOLDERS` (FID, PARENT_FID, ";
    $sql.= "NAME, VISIBLE) VALUES (1, NULL, '$name', 'Y')";

    if (!db_query($sql, $db_links_create_top_folder)) return false;

    return true;
}

function links_add_folder($fid, $name, $uid, $visible = false)
{
    if (!is_numeric($fid)) return false;
    
    if (!is_numeric($uid)) return false;

    $name = db_escape_string($name);

    if (!$db_links_add_folder = db_connect()) return false;

    $visible = $visible ? "Y" : "N";

    if (!$table_data = get_table_prefix()) return false;
    
    $current_datetime = date(MYSQL_DATETIME, time());
    
    $sql = "INSERT INTO `{$table_data['PREFIX']}LINKS_FOLDERS` (PARENT_FID, NAME, ";
    $sql.= "VISIBLE) VALUES ($fid, '$name', '$visible')";

    if (!db_query($sql, $db_links_add_folder)) return false;

    return true;
}

function links_update_folder($fid, $uid, $name)
{
    if (!$db_links_update_folder = db_connect()) return false;

    if (!is_numeric($fid)) return false;
    
    if (!is_numeric($uid)) return false;

    $name = db_escape_string($name);

    if (!$table_data = get_table_prefix()) return false;
    
    $current_datetime = date(MYSQL_DATETIME, time());
    
    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS_FOLDERS` ";
    $sql.= "SET NAME = '$name' WHERE FID = '$fid'";  

    if (!db_query($sql, $db_links_update_folder)) return false;

    return (db_affected_rows($db_links_update_folder) > 0);
}

function links_get_folder_path_links($fid, $folders, $html = true, $link_last_too = false, $link_base = false)
{
    $webtag = get_webtag();

    if (!is_numeric($fid)) return false;

    if (!is_array($folders)) return false;
    
    if (!isset($folders[$fid])) return false;

    $tree_fid = $fid; $tree_array = array();

    list($key) = array_keys($folders);

    while ($tree_fid != $key) {
        $tree_array[] = $tree_fid;
        $tree_fid = $folders[$tree_fid]['PARENT_FID'];
    }

    $link_base = $link_base ? $link_base : "links.php?webtag=$webtag";

    if (strstr($link_base, "?")) {
        $result = $html ? "<a href=\"$link_base&amp;fid=$key\">". word_filter_add_ob_tags($folders[$key]['NAME'], true). "</a>" : word_filter_add_ob_tags($folders[$key]['NAME'], true);
    }else {
        $result = $html ? "<a href=\"$link_base&amp;fid=$key\">". word_filter_add_ob_tags($folders[$key]['NAME'], true). "</a>" : word_filter_add_ob_tags($folders[$key]['NAME'], true);
    }

    if (is_array($tree_array) && sizeof($tree_array) > 0) {

        while (($val = array_pop($tree_array))) {

            if (($val != $fid && $html) || $link_last_too) {
                $result.= $html ? "<img src=". html_style_image('separator.png'). " alt=\"\" border=\"0\" /><a href=\"$link_base&amp;fid=$val\">". word_filter_add_ob_tags($folders[$val]['NAME'], true). "</a>" : " &gt; ". word_filter_add_ob_tags($folders[$val]['NAME'], true);
            } else {
                $result.= $html ? "<img src=". html_style_image('separator.png'). " alt=\"\" border=\"0\" />". word_filter_add_ob_tags($folders[$val]['NAME'], true) : " &gt; ". word_filter_add_ob_tags($folders[$val]['NAME'], true);
            }
        }
    }

    return $result;
}

function links_get_folder_page_title($fid, $folders, $link_title = false)
{
    if (!is_numeric($fid)) return false;
    
    if (!is_array($folders)) return false;
    
    if (!isset($folders[$fid])) return false;

    $tree_fid = $fid;

    $tree_array = array();

    list($key) = array_keys($folders);
    
    while ($tree_fid != $key) {
        
        $tree_array[] = $tree_fid;
        $tree_fid = $folders[$tree_fid]['PARENT_FID'];
    }

    $path = $folders[$key]['NAME'];

    if (is_array($tree_array) && sizeof($tree_array) > 0) {

        while (($val = array_pop($tree_array))) {

            $path.= " - ". $folders[$val]['NAME'];
        }
    }

    if ($link_title !== false) {
        $path.= ' - '. $link_title;
    }

    return $path;
}

function links_get_subfolders($fid, $folders)
{
    $subfolders = array();

    if (is_array($folders)) {

        while (list($key, $val) = each($folders)) {

            if (isset($val['PARENT_FID']) && $val['PARENT_FID'] == $fid && $key != 1) $subfolders[] = $key;
        }
    }

    return $subfolders;
}

function links_change_visibility($lid, $visible = true)
{
    if (!is_numeric($lid)) return false;

    $visible = $visible ? "Y" : "N";

    if (!$db_links_change_visibility = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS` ";
    $sql.= "SET VISIBLE = '$visible' WHERE LID = '$lid'";

    if (!db_query($sql, $db_links_change_visibility)) return false;

    return true;
}

function links_click($lid)
{
    if (!is_numeric($lid)) return false;

    if (!$db_links_click = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS` ";
    $sql.= "SET CLICKS = CLICKS + 1 WHERE LID = '$lid'";

    if (!db_query($sql, $db_links_click)) return false;

    $sql = "SELECT URI FROM `{$table_data['PREFIX']}LINKS` ";
    $sql.= "WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_click)) return false;

    if (db_num_rows($result) > 0) {

        list($link_uri) = db_fetch_array($result, DB_RESULT_NUM);
        header_redirect($link_uri);
    }

    return false;
}

function links_get_single($lid, $approved = true)
{
    if (!$db_links_get_single = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($lid)) return false;
    
    $approved = ($approved) ? "AND LINKS.APPROVED IS NOT NULL" : '';

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT LINKS.FID, LINKS.UID, LINKS.URI, LINKS.TITLE, ";
    $sql.= "LINKS.DESCRIPTION, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, ";
    $sql.= "LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.APPROVED) AS APPROVED, ";
    $sql.= "LINKS.APPROVED_BY, LINKS.CLICKS, USER.LOGON, USER.NICKNAME, ";
    $sql.= "AVG(LINKS_VOTE.RATING) AS RATING, COUNT(LINKS_VOTE.RATING) AS VOTES ";
    $sql.= "FROM `{$table_data['PREFIX']}LINKS` LINKS LEFT JOIN USER USER ON (LINKS.UID = USER.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql.= "WHERE LINKS.LID = '$lid' $approved GROUP BY LINKS_VOTE.LID";

    if (!$result = db_query($sql, $db_links_get_single)) return false;

    if (db_num_rows($result) > 0) {

        $link_array = db_fetch_array($result);

        if (isset($link_array['LOGON']) && isset($link_array['PEER_NICKNAME'])) {
            if (!is_null($link_array['PEER_NICKNAME']) && strlen($link_array['PEER_NICKNAME']) > 0) {
                $link_array['NICKNAME'] = $link_array['PEER_NICKNAME'];
            }
        }

        if (!isset($link_array['LOGON'])) $link_array['LOGON'] = $lang['unknownuser'];
        if (!isset($link_array['NICKNAME'])) $link_array['NICKNAME'] = "";

        return $link_array;
    }

    return false;
}

function links_get_all($invisible = false, $sort_by = "TITLE", $sort_dir = "ASC", $offset = 0)
{
    if (!$db_links_get_in_folder = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array = array('TITLE', 'DESCRIPTION', 'CREATED', 'RATING');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) return false;
    if (!is_bool($invisible)) $invisible = false;

    $offset = abs($offset);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'TITLE';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!$table_data = get_table_prefix()) return false;

    $links_array = array();

    if ($invisible === false) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql.= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql.= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_data['PREFIX']}LINKS` LINKS ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql.= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.VISIBLE = 'Y' ";
        $sql.= "AND LINKS.APPROVED IS NOT NULL GROUP BY LINKS.LID ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    }else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql.= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql.= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_data['PREFIX']}LINKS` LINKS ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql.= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.APPROVED IS NOT NULL ";
        $sql.= "GROUP BY LINKS.LID ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    if (!$result = db_query($sql, $db_links_get_in_folder)) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_links_get_in_folder)) return false;

    list($links_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($links_data = db_fetch_array($result))) {

            if (isset($links_data['LOGON']) && isset($links_data['PEER_NICKNAME'])) {
                if (!is_null($links_data['PEER_NICKNAME']) && strlen($links_data['PEER_NICKNAME']) > 0) {
                    $links_data['NICKNAME'] = $links_data['PEER_NICKNAME'];
                }
            }

            if (!isset($links_data['LOGON'])) $links_data['LOGON'] = $lang['unknownuser'];
            if (!isset($links_data['NICKNAME'])) $links_data['NICKNAME'] = "";

            $links_array[$links_data['LID']] = $links_data;
        }

    }else if ($links_count > 0) {

        $offset = floor(($links_count - 1) / 20) * 20;
        return links_get_all($invisible, $sort_by, $sort_dir, $offset);
    }

    return array('links_count' => $links_count,
                 'links_array' => $links_array);
}

function links_folder_change_visibility($fid, $visible = true)
{
    if (!$db_links_folder_change_visibility = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    $visible = $visible ? "Y" : "N";

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS_FOLDERS` ";
    $sql.= "SET VISIBLE = '$visible' WHERE FID = '$fid'";

    if (!db_query($sql, $db_links_folder_change_visibility)) return false;

    return true;
}

function links_folder_delete($fid)
{
    if (!is_numeric($fid)) return false;

    $folders = links_folders_get(!session_check_perm(USER_PERM_LINKS_MODERATE, 0));

    if (!$db_links_folder_delete = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MIN(FID) AS FID FROM `{$table_data['PREFIX']}LINKS`";

    if (!$result = db_query($sql, $db_links_folder_delete)) return false;

    $link_array = db_fetch_array($result);

    if (isset($link_array['FID']) && $link_array['FID'] == $fid) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS` ";
    $sql.= "SET FID = '{$folders[$fid]['PARENT_FID']}' WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_links_folder_delete)) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}LINKS_FOLDERS` ";
    $sql.= "WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_links_folder_delete)) return false;

    return $result;
}

function links_get_vote($lid, $uid)
{
    if (!$db_links_get_vote = db_connect()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT RATING FROM `{$table_data['PREFIX']}LINKS_VOTE` ";
    $sql.= "WHERE LID = '$lid' AND UID = '$uid'";

    if (!$result = db_query($sql, $db_links_get_vote)) return false;

    if (db_num_rows($result) > 0) {

        list($vote) = db_fetch_array($result, DB_RESULT_NUM);
        return $vote;
    }

    return false;
}

function links_vote($lid, $vote, $uid)
{
    if (!$db_links_vote = db_connect()) return false;

    if (!is_numeric($lid))  return false;
    if (!is_numeric($vote)) return false;
    if (!is_numeric($uid))  return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}LINKS_VOTE` (LID, UID, RATING, TSTAMP) ";
    $sql.= "VALUES ($lid, $uid, $vote, CAST('$current_datetime' AS DATETIME)) ";
    $sql.= "ON DUPLICATE KEY UPDATE RATING = VALUES(RATING), ";
    $sql.= "VOTED = CAST('$current_datetime' AS DATETIME) ";

    if (!db_query($sql, $db_links_vote)) return false;

    return true;
}

function links_clear_vote($lid, $uid)
{
    if (!$db_links_clear_vote = db_connect()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}LINKS_VOTE` ";
    $sql.= "WHERE UID = '$uid' AND LID = '$lid'";

    if (!db_query($sql, $db_links_clear_vote)) return false;

    return (db_affected_rows($db_links_clear_vote) > 0);
}

function links_add_comment($lid, $uid, $comment)
{
    if (!$db_links_add_comment = db_connect()) return false;

    if (!is_numeric($lid))  return false;
    if (!is_numeric($uid))  return false;

    $comment = db_escape_string($comment);

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}LINKS_COMMENT` (LID, UID, COMMENT, CREATED) ";
    $sql.= "VALUES ('$lid', '$uid', '$comment', CAST('$current_datetime' AS DATETIME))";

    if (!db_query($sql, $db_links_add_comment)) return false;

    return true;
}

function links_get_comments($lid)
{
    if (!$db_links_get_comments = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($lid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $links_comment_array = array();

    $sql  = "SELECT LINKS_COMMENT.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(LINKS_COMMENT.CREATED) AS CREATED, ";
    $sql .= "LINKS_COMMENT.CID, LINKS_COMMENT.COMMENT FROM `{$table_data['PREFIX']}LINKS_COMMENT` LINKS_COMMENT ";
    $sql .= "LEFT JOIN USER USER ON (LINKS_COMMENT.UID = USER.UID) ";
    $sql .= "WHERE LINKS_COMMENT.LID = '$lid' ORDER BY CREATED ASC";

    if (!$result = db_query($sql, $db_links_get_comments)) return false;

    if (db_num_rows($result) > 0) {

        while (($link_comment_data = db_fetch_array($result))) {

            if (isset($link_comment_data['LOGON']) && isset($link_comment_data['PEER_NICKNAME'])) {
                if (!is_null($link_comment_data['PEER_NICKNAME']) && strlen($link_comment_data['PEER_NICKNAME']) > 0) {
                    $link_comment_data['NICKNAME'] = $link_comment_data['PEER_NICKNAME'];
                }
            }

            if (!isset($link_comment_data['LOGON'])) $link_comment_data['LOGON'] = $lang['unknownuser'];
            if (!isset($link_comment_data['NICKNAME'])) $link_comment_data['NICKNAME'] = "";

            $links_comment_array[] = $link_comment_data;
        }

        return $links_comment_array;
    }

    return false;
}

function links_folder_dropdown($default_fid, $folders)
{
    $default_value = 0;
    
    while (list($key) = each($folders)) {

        $labels[$key] = links_get_folder_path_links($key, $folders, false);
        if ($key == $default_fid) $default_value = $key;
    }

    return form_dropdown_array("fid", $labels, $default_value, false, "links_dropdown");
}

function links_delete_comment($cid)
{
    if (!$db_links_delete_comment = db_connect()) return false;

    if (!is_numeric($cid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}LINKS_COMMENT` WHERE CID = '$cid'";

    if (!$result = db_query($sql, $db_links_delete_comment)) return false;

    return $result;
}

function links_delete($lid)
{
    if (!$db_links_delete = db_connect()) return false;

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}LINKS` WHERE LID = '$lid'";

    if (!db_query($sql, $db_links_delete)) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}LINKS_COMMENT` WHERE LID = '$lid'";

    if (!db_query($sql, $db_links_delete)) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}LINKS_VOTE` WHERE LID = '$lid'";

    if (!db_query($sql, $db_links_delete)) return false;

    return true;
}

function links_update($lid, $fid, $uid, $title, $uri, $description)
{
    if (!$db_links_update = db_connect()) return false;

    if (!is_numeric($lid)) return false;
    
    if (!is_numeric($fid)) return false;
    
    if (!is_numeric($uid)) return false;
    
    $uri = db_escape_string($uri);

    $title = db_escape_string($title);

    $description = db_escape_string($description);
    
    if (!$table_data = get_table_prefix()) return false;
    
    $current_datetime = date(MYSQL_DATETIME, time());

    if (forum_get_setting('require_link_approval') && !perm_is_links_moderator($uid)) {
        
        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS` SET FID = '$fid', ";
        $sql.= "TITLE = '$title', URI = '$uri', DESCRIPTION = '$description', ";
        $sql.= "APPROVED = NULL, APPROVED_BY = NULL WHERE LID = '$lid'";    

    } else {
        
        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS` SET FID = '$fid', ";
        $sql.= "TITLE = '$title', URI = '$uri', DESCRIPTION = '$description', ";
        $sql.= "APPROVED = CAST('$current_datetime' AS DATETIME), APPROVED_BY = $uid ";
        $sql.= "WHERE LID = '$lid'";
    }

    if (!db_query($sql, $db_links_update)) return false;

    return true;
}

function links_approve($lid)
{
    if (!is_numeric($lid)) return false;

    if (!$db_links_approve = db_connect()) return false;

    $approve_uid = session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}LINKS` ";
    $sql.= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "APPROVED_BY = '$approve_uid' WHERE LID = '$lid'";

    if (!db_query($sql, $db_links_approve)) return false;

    return true;
}

function links_get_creator_uid($lid)
{
    if (!$db_links_get_creator_uid = db_connect()) return false;

    if (!is_numeric($lid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM `{$table_data['PREFIX']}LINKS` WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_get_creator_uid)) return false;

    if (db_num_rows($result) > 0) {

        list($creator_uid) = db_fetch_array($result);
        return $creator_uid;
    }

    return false;
}

function links_get_comment_uid($cid)
{
    if (!$db_links_get_comment_uid = db_connect()) return false;

    if (!is_numeric($cid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM `{$table_data['PREFIX']}LINKS_COMMENT` WHERE CID = '$cid'";

    if (!$result = db_query($sql, $db_links_get_comment_uid)) return false;

    if (db_num_rows($result) > 0) {

        list($comment_uid) = db_fetch_array($result);
        return $comment_uid;
    }

    return false;
}

?>
