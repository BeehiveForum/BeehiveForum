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

/* $Id: links.inc.php,v 1.23 2004-03-10 20:21:04 decoyduck Exp $ */

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

    $sort_array = array('TITLE', 'DESCRIPTION', 'CREATED', 'RATING');

    if (!in_array($sort_by, $sort_array)) $sort_by = 'TITLE';
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    
    $table_prefix = get_table_prefix();

    $sql  = "SELECT LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
    $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
    $sql .= "AVG(LINKS_VOTE.RATING) AS RATING ";
    $sql .= "FROM {$table_prefix}LINKS LINKS ";
    $sql .= "LEFT JOIN {$table_prefix}LINKS_VOTE LINKS_VOTE ";
    $sql .= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "LEFT JOIN USER USER ";
    $sql .= "ON (LINKS.UID = USER.UID) ";
    $sql .= "WHERE LINKS.FID = $fid ";
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
    
    $table_prefix = get_table_prefix();
    
    $sql  = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM {$table_prefix}LINKS_FOLDERS ";
    if (!$invisible) $sql .= "WHERE VISIBLE = 'Y' ";
    $sql .= "ORDER BY FID";

    $folders = false;

    $result_id = db_query($sql, $db_links_folders_get);

    while ($row = db_fetch_array($result_id)) {
        $folders[$row['FID']] =  $row;
    }

    return $folders;
}

function links_add($uri, $title, $description, $fid, $uid, $visible = true)
{
    if (!is_numeric($fid)) return false;
    if (!is_numeric($uid)) return false;

    $db_links_add = db_connect();

    $visible = $visible ? "Y" : "N";
    
    $table_prefix = get_table_prefix();

    $sql = "INSERT INTO {$table_prefix}LINKS (URI, TITLE, DESCRIPTION, FID, UID, VISIBLE, CREATED) ";
    $sql.= "VALUES ('$uri', '$title', '$description', '$fid', '$uid', '$visible', NOW())";

    return db_query($sql, $db_links_add);
}

function links_add_folder($fid, $name, $visible = false)
{
    if (!is_numeric($fid)) return false;

    $db_links_add_folder = db_connect();

    $visible = $visible ? "Y" : "N";
    
    $table_prefix = get_table_prefix();

    $sql = "INSERT INTO {$table_prefix}LINKS_FOLDERS (FID, PARENT_FID, NAME, VISIBLE) ";
    $sql.= "VALUES (NULL, $fid, '$name', '$visible')";

    return db_query($sql, $db_links_add_folder);
}

function links_display_folder_path($fid, $folders, $links = true, $link_last_too = false, $link_base = false)
{
    global $HTTP_SERVER_VARS, $webtag;

    $tree_fid = $fid;
    $tree     = '';

    list($key) = array_keys($folders);

    while ($tree_fid != $key) {
          $tree[] = $tree_fid;
          $tree_fid = $folders[$tree_fid]['PARENT_FID'];
    }

    $link_base = $link_base ? $link_base : "./links.php?webtag=$webtag";
    
    if (strstr($link_base, "?")) {
        $html = $links ? "<a href=\"$link_base&fid=$key\">" . _stripslashes($folders[$key]['NAME']) . "</a>" : $folders[$key]['NAME'];
    }else {
        $html = $links ? "<a href=\"$link_base?fid=$key\">" . _stripslashes($folders[$key]['NAME']) . "</a>" : $folders[$key]['NAME'];
    }

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
    
    $table_prefix = get_table_prefix();

    $sql = "UPDATE {$table_prefix}LINKS SET VISIBLE = '$visible' WHERE LID = '$lid'";
    return db_query($sql, $db_links_change_visibility);
}

function links_click($lid)
{
    if (!is_numeric($lid)) return false;

    $db_links_click = db_connect();
    
    $table_prefix = get_table_prefix();

    $sql = "UPDATE {$table_prefix}LINKS SET CLICKS = CLICKS + 1 WHERE LID = '$lid'";
    $result_id = db_query($sql, $db_links_click);

    $sql = "SELECT URI FROM {$table_prefix}LINKS WHERE LID = '$lid'";
    $result_id = db_query($sql, $db_links_click);

    $uri = db_fetch_array($result_id);
    header_redirect($uri['URI']);
}

function links_get_single($lid)
{
    if (!is_numeric($lid)) return false;

    $db_links_get_single = db_connect();
    
    $table_prefix = get_table_prefix();

    $sql  = "SELECT LINKS.FID, LINKS.UID, LINKS.URI, LINKS.TITLE, LINKS.DESCRIPTION, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, ";
    $sql .= "LINKS.VISIBLE, LINKS.CLICKS, USER.LOGON, USER.NICKNAME, AVG(LINKS_VOTE.RATING) AS RATING, COUNT(LINKS_VOTE.RATING) AS VOTES ";
    $sql .= "FROM {$table_prefix}LINKS LINKS ";
    $sql .= "LEFT JOIN USER USER ";
    $sql .= "ON (LINKS.UID = USER.UID) ";
    $sql .= "LEFT JOIN {$table_prefix}LINKS_VOTE LINKS_VOTE ";
    $sql .= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "WHERE LINKS.LID = '$lid' ";
    $sql .= "GROUP BY LINKS_VOTE.LID";

    $result_id = db_query($sql, $db_links_get_single);

    if ($result_id) {
        $link = db_fetch_array($result_id);
        return $link;
    } else {
        return false;
    }
}

function links_get_all($invisible = false, $sort_by = "DATE", $sort_dir = "DESC", $offset = 0)
{
    $links = array();

    $sort_array = array('TITLE', 'DESCRIPTION', 'CREATED', 'RATING');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'TITLE';

    $db_links_get_in_folder = db_connect();
    
    $table_prefix = get_table_prefix();

    $sql  = "SELECT LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
    $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
    $sql .= "AVG(LINKS_VOTE.RATING) AS RATING ";
    $sql .= "FROM {$table_prefix}LINKS LINKS ";
    $sql .= "LEFT JOIN {$table_prefix}LINKS_VOTE LINKS_VOTE ";
    $sql .= "ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "LEFT JOIN USER USER ";
    $sql .= "ON (LINKS.UID = USER.UID) ";
    if (!$invisible) $sql .= "WHERE LINKS.VISIBLE = 'Y' ";
    $sql .= "GROUP BY LINKS.LID ";
    $sql .= "ORDER BY $sort_by $sort_dir ";
    $sql .= "LIMIT $offset, 20";

    $result_id = db_query($sql, $db_links_get_in_folder);

    while ($row = db_fetch_array($result_id)) {
        $links[$row['LID']] = $row;
    }

    return $links;
}

function links_folder_change_visibility($fid, $visible = true)
{
    $db_links_folder_change_visibility = db_connect();

    if (!is_numeric($fid)) return false;

    $visible = $visible ? "Y" : "N";
    
    $table_prefix = get_table_prefix();

    $sql = "UPDATE {$table_prefix}LINKS_FOLDERS SET VISIBLE = '$visible' WHERE FID = $fid";
    return db_query($sql, $db_links_folder_change_visibility);
}

function links_folder_delete($fid)
{
    if (!is_numeric($fid)) return false;

    $folders = links_folders_get(perm_is_moderator());

    $db_links_folder_delete = db_connect();
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT MIN(FID) AS FID FROM {$table_prefix}LINKS";
    $result_id = db_query($sql, $db_links_folder_delete);

    $link_array = db_fetch_array($result_id);
    if ($link_array['FID'] == $fid) return false;

    $sql = "UPDATE {$table_prefix}LINKS SET FID = '{$folders[$fid]['PARENT_FID']}' WHERE FID = '$fid'";
    $result_id = db_query($sql, $db_links_folder_delete);

    $sql = "DELETE FROM {$table_prefix}LINKS_FOLDERS WHERE FID = $fid";
    $result_id = db_query($sql, $db_links_folder_delete);

    return $result_id;
}

function links_get_vote($lid, $uid)
{
    $db_links_get_vote = db_connect();

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT RATING FROM {$table_prefix}LINKS_VOTE WHERE LID = $lid AND UID = $uid";
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

    if (!is_numeric($lid))  return false;
    if (!is_numeric($vote)) return false;
    if (!is_numeric($uid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql = "DELETE FROM {$table_prefix}LINKS_VOTE WHERE UID = '$uid' AND LID = '$lid'";
    $result = db_query($sql, $db_links_vote);

    $sql = "INSERT INTO {$table_prefix}LINKS_VOTE (LID, UID, RATING, TSTAMP) ";
    $sql.= "VALUES ($lid, $uid, $vote, NOW())";

    return db_query($sql, $db_links_vote);
}

function links_add_comment($lid, $uid, $comment)
{
    $db_links_add_comment = db_connect();

    if (!is_numeric($lid))  return false;
    if (!is_numeric($uid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql = "INSERT INTO {$table_prefix}LINKS_COMMENT (LID, UID, COMMENT, CREATED) ";
    $sql.= "VALUES ('$lid', '$uid', '$comment', NOW())";

    return db_query($sql, $db_links_add_comment);
}

function links_get_comments($lid)
{
    $db_links_get_comments = db_connect();

    if (!is_numeric($lid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql  = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(LINKS_COMMENT.CREATED) AS CREATED, ";
    $sql .= "LINKS_COMMENT.CID, LINKS_COMMENT.COMMENT ";
    $sql .= "FROM {$table_prefix}LINKS_COMMENT LINKS_COMMENT ";
    $sql .= "LEFT JOIN USER USER ";
    $sql .= "ON (LINKS_COMMENT.UID = USER.UID) ";
    $sql .= "WHERE LINKS_COMMENT.LID = '$lid' ORDER BY CREATED ASC";

    $result_id = db_query($sql, $db_links_get_comments);

    if (db_num_rows($result_id)) {

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
    
    $table_prefix = get_table_prefix();
    
    $sql = "DELETE FROM {$table_prefix}LINKS_COMMENT WHERE CID = $cid";
    $result_id = db_query($sql, $db_links_delete_comment);
    return $result_id;
}

function links_delete($lid)
{
    $db_links_delete = db_connect();

    if (!is_numeric($lid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql = "DELETE FROM {$table_prefix}LINKS WHERE LID = '$lid'";
    $result_id = db_query($sql, $db_links_delete);

    $sql = "DELETE FROM {$table_prefix}LINKS_COMMENT WHERE LID = '$lid'";
    $result_id = db_query($sql, $db_links_delete);

    $sql = "DELETE FROM {$table_prefix}LINKS_VOTE WHERE LID = '$lid'";
    $result_id = db_query($sql, $db_links_delete);
}

function links_update($lid, $fid, $title, $uri, $description)
{
    $db_links_update = db_connect();

    if (!is_numeric($lid))  return false;
    if (!is_numeric($fid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql = "UPDATE {$table_prefix}LINKS SET LID = '$lid', FID = '$fid', ";
    $sql.= "TITLE = '$title', URI = '$uri', DESCRIPTION = '$description' WHERE LID = '$lid'";

    return db_query($sql, $db_links_update);
}

function links_get_creator_uid($lid)
{
    $db_links_get_creator_uid = db_connect();

    if (!is_numeric($lid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT UID FROM {$table_prefix}LINKS WHERE LID = '$lid'";
    $result_id = db_query($sql, $db_links_get_creator_uid);

    return db_fetch_array($result_id);
}

function links_get_comment_uid($cid)
{
    $db_links_get_comment_uid = db_connect();

    if (!is_numeric($cid))  return false;
    
    $table_prefix = get_table_prefix();

    $sql = "SELECT UID FROM {$table_prefix}LINKS_COMMENT WHERE CID = '$cid'";
    $result_id = db_query($sql, $db_links_get_comment_uid);

    return db_fetch_array($result_id);
}

?>