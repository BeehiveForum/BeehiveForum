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

/* $Id: links.inc.php,v 1.67 2007-05-19 18:24:31 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");

function links_get_in_folder($fid, $invisible = false, $sort_by = "TITLE", $sort_dir = "ASC", $offset = 0) // setting $invisible to true gets links that are marked as not visible too
{
    $links_array = array();

    $db_links_get_in_folder = db_connect();

    $sort_array = array('TITLE', 'DESCRIPTION', 'CREATED', 'RATING');

    if (!in_array($sort_by, $sort_array)) $sort_by = 'TITLE';
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';

    if (!$table_data = get_table_prefix()) return array('links_count' => 0,
                                                        'links_array' => array());

    $sql = "SELECT COUNT(LID) AS LINK_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}LINKS ";
    $sql.= "WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_links_get_in_folder)) return false;
    
    list($links_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
    $sql.= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
    $sql.= "AVG(LINKS_VOTE.RATING) AS RATING ";
    $sql.= "FROM {$table_data['PREFIX']}LINKS LINKS ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}LINKS_VOTE LINKS_VOTE ";
    $sql.= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql.= "LEFT JOIN USER USER ";
    $sql.= "ON (LINKS.UID = USER.UID) ";
    $sql.= "WHERE LINKS.FID = '$fid' ";

    if (!$invisible) $sql.= "AND LINKS.VISIBLE = 'Y' ";

    $sql.= "GROUP BY LINKS.LID ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 20";

    if (!$result = db_query($sql, $db_links_get_in_folder)) return false;

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            $links_array[$row['LID']] = $row;
        }

    }else if ($links_count > 0) {

        $offset = floor(($links_count - 1) / 20) * 20;
        return links_get_in_folder($fid, $invisible, $sort_by, $sort_dir, $offset);
    }

    return array('links_count' => $links_count,
                 'links_array' => $links_array);
}

function links_folders_get($invisible = false)
{
    $db_links_folders_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM {$table_data['PREFIX']}LINKS_FOLDERS ";
    $sql.= "WHERE PARENT_FID IS NULL";

    if (!$result = db_query($sql, $db_links_folders_get)) return false;

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        $top_level = $row['FID'];
        $folders[$row['FID']] =  $row;

        if ($invisible) {

            $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM {$table_data['PREFIX']}LINKS_FOLDERS ";
            $sql.= "WHERE FID NOT IN ($top_level) ORDER BY NAME";

        }else {

            $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM {$table_data['PREFIX']}LINKS_FOLDERS ";
            $sql.= "WHERE VISIBLE = 'Y' AND FID NOT IN ($top_level) ORDER BY FID";
        }

        if (!$result = db_query($sql, $db_links_folders_get)) return false;

        if (db_num_rows($result) > 0) {

            while ($row = db_fetch_array($result)) {

                $folders[$row['FID']] =  $row;
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

    $uri = db_escape_string(_htmlentities($uri));

    $title = db_escape_string(_htmlentities($title));
    $description = db_escape_string(_htmlentities($description));

    $db_links_add = db_connect();

    $visible = $visible ? "Y" : "N";

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}LINKS (URI, TITLE, DESCRIPTION, FID, UID, VISIBLE, CREATED) ";
    $sql.= "VALUES ('$uri', '$title', '$description', '$fid', '$uid', '$visible', NOW())";

    if (!$result = db_query($sql, $db_links_add)) return false;

    return true;
}

function links_create_top_folder($name)
{
    $db_links_add_folder = db_connect();

    $name = db_escape_string(_htmlentities($name));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}LINKS_FOLDERS (FID, PARENT_FID, NAME, VISIBLE) ";
    $sql.= "VALUES (1, NULL, '$name', 'Y')";

    if (!$result = db_query($sql, $db_links_add_folder)) return false;

    return true;
}

function links_add_folder($fid, $name, $visible = false)
{
    if (!is_numeric($fid)) return false;

    $name = db_escape_string(_htmlentities($name));

    $db_links_add_folder = db_connect();

    $visible = $visible ? "Y" : "N";

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}LINKS_FOLDERS (FID, PARENT_FID, NAME, VISIBLE) ";
    $sql.= "VALUES (NULL, $fid, '$name', '$visible')";

    if (!$result = db_query($sql, $db_links_add_folder)) return false;

    return true;
}

function links_display_folder_path($fid, $folders, $links = true, $link_last_too = false, $link_base = false)
{
    $webtag = get_webtag($webtag_search);

    $tree_fid = $fid;
    $tree     = '';

    list($key) = array_keys($folders);

    while ($tree_fid != $key) {

          $tree[] = $tree_fid;
          $tree_fid = $folders[$tree_fid]['PARENT_FID'];
    }

    $link_base = $link_base ? $link_base : "./links.php?webtag=$webtag";

    if (strstr($link_base, "?")) {
        $html = $links ? "<a href=\"$link_base&amp;fid=$key\">". $folders[$key]['NAME']. "</a>" : $folders[$key]['NAME'];
    }else {
        $html = $links ? "<a href=\"$link_base&amp;fid=$key\">". $folders[$key]['NAME']. "</a>" : $folders[$key]['NAME'];
    }

    if (is_array($tree)) {

        while ($val = array_pop($tree)) {

            if (($val != $fid && $links) || $link_last_too) {
                $html .= "&nbsp;&raquo;&nbsp;<a href=\"$link_base&amp;fid=$val\">". $folders[$val]['NAME']. "</a>";
            } else {
                $html .= "&nbsp;&raquo;&nbsp;". $folders[$val]['NAME'];
            }
        }
    }

    return $html;
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

    $db_links_change_visibility = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}LINKS SET VISIBLE = '$visible' WHERE LID = '$lid'";
    
    if (!$result = db_query($sql, $db_links_change_visibility)) return false;

    return true;
}

function links_click($lid)
{
    if (!is_numeric($lid)) return false;

    $db_links_click = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}LINKS SET CLICKS = CLICKS + 1 WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_click)) return false;

    $sql = "SELECT URI FROM {$table_data['PREFIX']}LINKS WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_click)) return false;

    $uri = db_fetch_array($result);
    header_redirect($uri['URI']);
}

function links_get_single($lid)
{
    if (!is_numeric($lid)) return false;

    $db_links_get_single = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql  = "SELECT LINKS.FID, LINKS.UID, LINKS.URI, LINKS.TITLE, LINKS.DESCRIPTION, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, ";
    $sql .= "LINKS.VISIBLE, LINKS.CLICKS, USER.LOGON, USER.NICKNAME, AVG(LINKS_VOTE.RATING) AS RATING, COUNT(LINKS_VOTE.RATING) AS VOTES ";
    $sql .= "FROM {$table_data['PREFIX']}LINKS LINKS ";
    $sql .= "LEFT JOIN USER USER ";
    $sql .= "ON (LINKS.UID = USER.UID) ";
    $sql .= "LEFT JOIN {$table_data['PREFIX']}LINKS_VOTE LINKS_VOTE ";
    $sql .= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "WHERE LINKS.LID = '$lid' ";
    $sql .= "GROUP BY LINKS_VOTE.LID";

    if (!$result = db_query($sql, $db_links_get_single)) return false;

    if ($result) {
        $link = db_fetch_array($result);
        return $link;
    } else {
        return false;
    }
}

function links_get_all($invisible = false, $sort_by = "TITLE", $sort_dir = "ASC", $offset = 0)
{
    $links_array = array();

    $sort_array = array('TITLE', 'DESCRIPTION', 'CREATED', 'RATING');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'ASC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'TITLE';

    $db_links_get_in_folder = db_connect();

    if (!$table_data = get_table_prefix()) return array('links_count' => 0,
                                                        'links_array' => array());

    $sql = "SELECT COUNT(LID) AS LINK_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}LINKS ";

    if (!$result = db_query($sql, $db_links_get_in_folder)) return false;
    
    list($links_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
    $sql.= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
    $sql.= "AVG(LINKS_VOTE.RATING) AS RATING ";
    $sql.= "FROM {$table_data['PREFIX']}LINKS LINKS ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}LINKS_VOTE LINKS_VOTE ";
    $sql.= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql.= "LEFT JOIN USER USER ";
    $sql.= "ON (LINKS.UID = USER.UID) ";

    if (!$invisible) $sql.= "WHERE LINKS.VISIBLE = 'Y' ";

    $sql.= "GROUP BY LINKS.LID ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 20";

    if (!$result = db_query($sql, $db_links_get_in_folder)) return false;

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            $links_array[$row['LID']] = $row;
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
    $db_links_folder_change_visibility = db_connect();

    if (!is_numeric($fid)) return false;

    $visible = $visible ? "Y" : "N";

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}LINKS_FOLDERS SET VISIBLE = '$visible' WHERE FID = '$fid'";
    
    if (!$result = db_query($sql, $db_links_folder_change_visibility)) return false;

    return true;
}

function links_folder_delete($fid)
{
    if (!is_numeric($fid)) return false;

    $folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));

    $db_links_folder_delete = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MIN(FID) AS FID FROM {$table_data['PREFIX']}LINKS";

    if (!$result = db_query($sql, $db_links_folder_delete)) return false;

    $link_array = db_fetch_array($result);
    if (isset($link_array['FID']) && $link_array['FID'] == $fid) return false;

    $sql = "UPDATE {$table_data['PREFIX']}LINKS SET FID = '{$folders[$fid]['PARENT_FID']}' WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_links_folder_delete)) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}LINKS_FOLDERS WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_links_folder_delete)) return false;

    return $result;
}

function links_get_vote($lid, $uid)
{
    $db_links_get_vote = db_connect();

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT RATING FROM {$table_data['PREFIX']}LINKS_VOTE WHERE LID = '$lid' AND UID = '$uid'";

    if (!$result = db_query($sql, $db_links_get_vote)) return false;

    if ($result) {
        $vote = db_fetch_array($result);
        return $vote['RATING'];
    } else {
        return false;
    }
}

function links_vote($lid, $vote, $uid)
{
    $db_links_vote = db_connect();

    if (!is_numeric($lid))  return false;
    if (!is_numeric($vote)) return false;
    if (!is_numeric($uid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}LINKS_VOTE ";
    $sql.= "WHERE UID = '$uid' AND LID = '$lid'";

    if (!$result = db_query($sql, $db_links_vote)) return false;

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE {$table_data['PREFIX']}LINKS_VOTE SET RATING = '$vote', TSTAMP = NOW() ";
        $sql.= "WHERE UID = '$uid' AND LID = '$lid'";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}LINKS_VOTE (LID, UID, RATING, TSTAMP) ";
        $sql.= "VALUES ($lid, $uid, $vote, NOW())";
    }

    if (!$result = db_query($sql, $db_links_vote)) return false;

    return true;
}

function links_add_comment($lid, $uid, $comment)
{
    $db_links_add_comment = db_connect();

    if (!is_numeric($lid))  return false;
    if (!is_numeric($uid))  return false;

    $comment = db_escape_string(_htmlentities($comment));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}LINKS_COMMENT (LID, UID, COMMENT, CREATED) ";
    $sql.= "VALUES ('$lid', '$uid', '$comment', NOW())";

    if (!$result = db_query($sql, $db_links_add_comment)) return false;

    return true;
}

function links_get_comments($lid)
{
    $db_links_get_comments = db_connect();

    if (!is_numeric($lid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql  = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(LINKS_COMMENT.CREATED) AS CREATED, ";
    $sql .= "LINKS_COMMENT.CID, LINKS_COMMENT.COMMENT ";
    $sql .= "FROM {$table_data['PREFIX']}LINKS_COMMENT LINKS_COMMENT ";
    $sql .= "LEFT JOIN USER USER ";
    $sql .= "ON (LINKS_COMMENT.UID = USER.UID) ";
    $sql .= "WHERE LINKS_COMMENT.LID = '$lid' ORDER BY CREATED ASC";

    if (!$result = db_query($sql, $db_links_get_comments)) return false;

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {
            $comments[] = $row;
        }

        return $comments;

    } else {
        return false;
    }
}

function links_folder_dropdown($default_fid, $folders)
{
    while (list($key, $val) = each($folders)) {

        $labels[$key] = links_display_folder_path($key, $folders, false);
        if ($key == $default_fid) $default_value = $key;
    }

    return form_dropdown_array("fid", $labels, $default_value, false, "links_dropdown");
}

function links_delete_comment($cid)
{
    $db_links_delete_comment = db_connect();

    if (!is_numeric($cid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}LINKS_COMMENT WHERE CID = '$cid'";

    if (!$result = db_query($sql, $db_links_delete_comment)) return false;

    return $result;
}

function links_delete($lid)
{
    $db_links_delete = db_connect();

    if (!is_numeric($lid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}LINKS WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_delete)) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}LINKS_COMMENT WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_delete)) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}LINKS_VOTE WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_delete)) return false;
}

function links_update($lid, $fid, $title, $uri, $description)
{
    $db_links_update = db_connect();

    if (!is_numeric($lid)) return false;
    if (!is_numeric($fid)) return false;

    $uri = db_escape_string(_htmlentities($uri));

    $title = db_escape_string(_htmlentities($title));
    $description = db_escape_string(_htmlentities($description));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}LINKS SET LID = '$lid', FID = '$fid', ";
    $sql.= "TITLE = '$title', URI = '$uri', DESCRIPTION = '$description' WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_update)) return false;

    return true;
}

function links_get_creator_uid($lid)
{
    $db_links_get_creator_uid = db_connect();

    if (!is_numeric($lid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}LINKS WHERE LID = '$lid'";

    if (!$result = db_query($sql, $db_links_get_creator_uid)) return false;

    if (db_num_rows($result) > 0) {
    
        list($creator_uid) = db_fetch_array($result);
        return $creator_uid;
    }

    return false;
}

function links_get_comment_uid($cid)
{
    $db_links_get_comment_uid = db_connect();

    if (!is_numeric($cid))  return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}LINKS_COMMENT WHERE CID = '$cid'";

    if (!$result = db_query($sql, $db_links_get_comment_uid)) return false;

    if (db_num_rows($result) > 0) {
    
        list($comment_uid) = db_fetch_array($result);
        return $comment_uid;
    }

    return false;
}

?>