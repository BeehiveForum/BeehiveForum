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

// Compress the output
require_once("./include/gzipenc.inc.php");

// Functions for the links database

require_once('./include/db.inc.php');
require_once('./include/forum.inc.php');
require_once('./include/header.inc.php');
require_once('./include/html.inc.php');
require_once('./include/form.inc.php');
require_once('./include/format.inc.php');

function links_get_in_folder($fid, $invisible = false, $sort_by = "TITLE", $sort_dir = "ASC") // setting $invisible to true gets links that are marked as not visible too
{

    $links = array();

    $db_links_get_in_folder = db_connect();

    $sql  = "SELECT LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
    $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
    $sql .= "AVG(LINKS_VOTE.RATING) AS RATING ";
    $sql .= "FROM " . forum_table("LINKS") . " LINKS JOIN " . forum_table("USER") . " USER ";
    $sql .= "LEFT JOIN " . forum_table("LINKS_VOTE") . " LINKS_VOTE ";
    $sql .= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "WHERE LINKS.UID = USER.UID ";
    $sql .= "AND LINKS.FID = $fid ";
    if (!$invisible) $sql .= "AND LINKS.VISIBLE = 'Y' ";
    $sql .= "GROUP BY LINKS.LID ";
    $sql .= "ORDER BY $sort_by $sort_dir";

    $result_id = db_query($sql, $db_links_get_in_folder);

    while ($row = db_fetch_array($result_id)) {
        $links[$row['LID']] = $row;
    }

    return $links;

}

function links_folders_get($invisible = false)
{

    $db_links_folders_get = db_connect();
    $sql  = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM ". forum_table("LINKS_FOLDERS") . " ";
    if (!$invisible) $sql .= "WHERE VISIBLE = 'Y' ";
    $sql .= "ORDER BY FID";

    $result_id = db_query($sql, $db_links_folders_get);

    while ($row = db_fetch_array($result_id)) {
        $folders[$row['FID']] =  $row;
    }

    return $folders;

}

function links_add($uri, $title, $description, $fid, $uid, $visible = true)
{

    $db_links_add = db_connect();
    $visible = $visible ? "Y" : "N";
    $sql  = "INSERT INTO " . forum_table("LINKS") . " (LID, URI, TITLE, DESCRIPTION, FID, UID, VISIBLE, CREATED) ";
    $sql .= "VALUES (NULL, '$uri', '$title', '$description', $fid, $uid, '$visible', NOW())";

    $result_id = db_query($sql, $db_links_add);

    return $result_id;
}

function links_add_folder($fid, $name, $visible = false)
{

    $db_links_add_folder = db_connect();
    $visible = $visible ? "Y" : "N";
    $sql  = "INSERT INTO " . forum_table("LINKS_FOLDERS") . " (FID, PARENT_FID, NAME, VISIBLE) ";
    $sql .= "VALUES (NULL, $fid, '$name', '$visible')";

    $result_id = db_query($sql, $db_links_add_folder);

    return $result_id;
}

function links_display_folder_path($fid, $folders, $links = true, $link_last_too = false, $link_base = false)
{

    global $HTTP_SERVER_VARS;

    $tree_fid = $fid;
    $tree     = '';

    while ($tree_fid != 1) {
          $tree[] = $tree_fid;
          $tree_fid = $folders[$tree_fid]['PARENT_FID'];
    }

    $link_base = $link_base ? $link_base : $HTTP_SERVER_VARS['PHP_SELF'];

    $html = $links ? "<a href=\"$link_base?fid=1\">" . _stripslashes($folders[1]['NAME']) . "</a>" : $folders[1]['NAME'];

    if (is_array($tree)) {
        while ($val = array_pop($tree)) {
            if (($val != $fid && $links) || $link_last_too) {
                $html .= "&nbsp;>&nbsp;<a href=\"$link_base?fid=$val\">" . _stripslashes($folders[$val]['NAME']) . "</a>";
            } else {
                $html .= "&nbsp;>&nbsp;". _stripslashes($folders[$val]['NAME']);
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
            if ($val['PARENT_FID'] == $fid && $key != 1) $subfolders[] = $key;
        }
    }

    return $subfolders;
}

function links_change_visibility($lid, $visible = true)
{

    $visible = $visible ? "Y" : "N";
    $db_links_change_visibility = db_connect();
    $sql = "UPDATE " . forum_table("LINKS") . " SET VISIBLE = '$visible' WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_change_visibility);
    return $result_id;
}

function links_click($lid)
{
    $db_links_click = db_connect();
    $sql = "UPDATE " . forum_table("LINKS") . " SET CLICKS = CLICKS + 1 WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_click);
    $sql = "SELECT URI FROM " . forum_table("LINKS") . " WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_click);
    $uri = db_fetch_array($result_id);
    header_redirect($uri['URI']);
    return true;
}

function links_get_single($lid)
{
    $db_links_get_single = db_connect();
    $sql  = "SELECT LINKS.FID, LINKS.UID, LINKS.URI, LINKS.TITLE, LINKS.DESCRIPTION, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, ";
    $sql .= "LINKS.VISIBLE, LINKS.CLICKS, USER.LOGON, USER.NICKNAME, AVG(LINKS_VOTE.RATING) AS RATING, COUNT(LINKS_VOTE.RATING) AS VOTES ";
    $sql .= "FROM " . forum_table("LINKS") . " LINKS JOIN " . forum_table("USER") . " USER ";
    $sql .= "LEFT JOIN " . forum_table("LINKS_VOTE") . " LINKS_VOTE ";
    $sql .= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "WHERE USER.UID = LINKS.UID AND LINKS.LID = $lid ";
    $sql .= "GROUP BY LINKS_VOTE.LID";
    $result_id = db_query($sql, $db_links_get_single);
    if ($result_id) {
        $link = db_fetch_array($result_id);
        return $link;
    } else {
        return false;
    }
}

function links_folder_change_visibility($fid, $visible = true)
{
    $db_links_folder_change_visibility = db_connect();
    $visible = $visible ? "Y" : "N";
    $sql = "UPDATE " . forum_table("LINKS_FOLDERS") . " SET VISIBLE = '$visible' WHERE FID = $fid";
    $result_id = db_query($sql, $db_links_folder_change_visibility);
    return $result_id;
}

function links_folder_delete($fid)
{
    if ($fid == 1) return false; // can't delete the top level folder
    $folders = links_folders_get(perm_is_moderator());
    $db_links_folder_delete = db_connect();
    $sql = "UPDATE " . forum_table("LINKS") . " SET FID = {$folders[$fid]['PARENT_FID']} WHERE FID = $fid";
    $result_id = db_query($sql, $db_links_folder_delete);
    $sql = "DELETE FROM " . forum_table("LINKS_FOLDERS") . " WHERE FID = $fid";
    $result_id = db_query($sql, $db_links_folder_delete);
    return $result_id;
}

function links_get_vote($lid, $uid)
{
    $db_links_get_vote = db_connect();
    $sql = "SELECT RATING FROM " . forum_table("LINKS_VOTE") . " WHERE LID = $lid AND UID = $uid";
    $result_id = db_query($sql, $db_links_get_vote);
    if ($result_id) {
        $vote = db_fetch_array($result_id);
        return $vote['RATING'];
    } else {
        return false;
    }
}

function links_vote($lid, $vote, $uid)
{
    $db_links_vote = db_connect();
    $sql = "DELETE FROM " . forum_table("LINKS_VOTE") . " WHERE UID = $uid AND LID = $lid";
    $result_id = db_query($sql, $db_links_vote);
    $sql  = "INSERT INTO " . forum_table("LINKS_VOTE") . " (LID, UID, RATING, TSTAMP) ";
    $sql .= "VALUES ($lid, $uid, $vote, NOW())";
    $result_id = db_query($sql, $db_links_vote);
    return $result_id;
}

function links_add_comment($lid, $uid, $comment)
{
    $db_links_add_comment = db_connect();
    $sql  = "INSERT INTO " . forum_table("LINKS_COMMENT") . " (LID, UID, COMMENT, CREATED) ";
    $sql .= "VALUES ($lid, $uid, '$comment', NOW())";
    $result_id = db_query($sql, $db_links_add_comment);
    return $result_id;
}

function links_get_comments($lid)
{
    $db_links_get_comments = db_connect();
    $sql  = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(LINKS_COMMENT.CREATED) AS CREATED, ";
    $sql .= "LINKS_COMMENT.CID, LINKS_COMMENT.COMMENT ";
    $sql .= "FROM " . forum_table("LINKS_COMMENT") . " LINKS_COMMENT JOIN " . forum_table("USER") . " USER ";
    $sql .= "WHERE USER.UID = LINKS_COMMENT.UID AND LINKS_COMMENT.LID = $lid ORDER BY CREATED ASC";
    $result_id = db_query($sql, $db_links_get_comments);
    if ($result_id) {
        while ($row = db_fetch_array($result_id)) {
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
        $values[] = $key;
        $labels[] = links_display_folder_path($key, $folders, false);
        if ($key == $default_fid) $default_value = $key;
    }
    return form_dropdown_array("fid", $values, $labels, $default_value);
}

function links_delete_comment($cid)
{
    $db_links_delete_comment = db_connect();
    $sql = "DELETE FROM " . forum_table("LINKS_COMMENT") . " WHERE CID = $cid";
    $result_id = db_query($sql, $db_links_delete_comment);
    return $result_id;
}

function links_delete($lid)
{
    $db_links_delete = db_connect();
    /* This query will work on MySQL > 4.0 since it supports multiple table deletes. For now, we have to do them one at a time.
    $sql  = "DELETE FROM " . forum_table("LINKS") . " LINKS, " . forum_table("LINKS_COMMENT") . " COMMENT, " . forum_table("LINKS_VOTE") . " VOTE ";
    $sql .= "WHERE LINKS.LID = $lid OR LINKS_COMMENT.LID = $lid OR LINKS_VOTE.LID = $lid";
    */
    $sql = "DELETE FROM " . forum_table("LINKS") . " WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_delete);
    $sql = "DELETE FROM " . forum_table("LINKS_COMMENT") . " WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_delete);
    $sql = "DELETE FROM " . forum_table("LINKS_VOTE") . " WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_delete);
}

function links_update($lid, $fid, $title, $uri, $description)
{
    $db_links_update = db_connect();
    $sql = "UPDATE " . forum_table("LINKS") . " SET LID = $lid, FID = $fid, TITLE = '$title', URI = '$uri', DESCRIPTION = '$description' WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_update);
    return $result_id;
}

function links_get_creator_uid($lid)
{
    $db_links_get_creator_uid = db_connect();
    $sql = "SELECT UID FROM " . forum_table("LINKS") . " WHERE LID = $lid";
    $result_id = db_query($sql, $db_links_get_creator_uid);
    $result = db_fetch_array($result_id);
    return $result;
}

function links_get_comment_uid($cid)
{
    $db_links_get_comment_uid = db_connect();
    $sql = "SELECT UID FROM " . forum_table("LINKS_COMMENT") . " WHERE CID = $cid";
    $result_id = db_query($sql, $db_links_get_comment_uid);
    $result = db_fetch_array($result_id);
    return $result;
}

?>