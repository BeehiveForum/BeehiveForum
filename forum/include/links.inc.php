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

// Required includes
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

function links_get_in_folder($fid, $invisible = false, $sort_by = "TITLE", $sort_dir = "ASC", $page = 1)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'TITLE',
        'DESCRIPTION',
        'CREATED',
        'RATING'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($fid)) return false;

    if (!is_bool($invisible)) $invisible = false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'TITLE';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!($table_prefix = get_table_prefix())) return false;

    $offset = calculate_page_offset($page, 20);

    $links_array = array();

    if ($invisible === false) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql .= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_prefix}LINKS` LINKS ";
        $sql .= "LEFT JOIN `{$table_prefix}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql .= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.FID = '$fid' ";
        $sql .= "AND LINKS.VISIBLE = 'Y' AND LINKS.APPROVED IS NOT NULL ";
        $sql .= "GROUP BY LINKS.LID ORDER BY $sort_by $sort_dir ";
        $sql .= "LIMIT $offset, 20";

    } else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql .= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_prefix}LINKS` LINKS ";
        $sql .= "LEFT JOIN `{$table_prefix}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql .= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.FID = '$fid' ";
        $sql .= "AND LINKS.APPROVED IS NOT NULL GROUP BY LINKS.LID ";
        $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($links_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($links_count > 0) && ($page > 1)) {
        return links_get_in_folder($fid, $invisible, $sort_by, $sort_dir, $page - 1);
    }

    while (($links_data = $result->fetch_assoc()) !== null) {

        if (isset($links_data['LOGON']) && isset($links_data['PEER_NICKNAME'])) {
            if (!is_null($links_data['PEER_NICKNAME']) && strlen($links_data['PEER_NICKNAME']) > 0) {
                $links_data['NICKNAME'] = $links_data['PEER_NICKNAME'];
            }
        }

        if (!isset($links_data['LOGON'])) $links_data['LOGON'] = gettext("Unknown user");
        if (!isset($links_data['NICKNAME'])) $links_data['NICKNAME'] = "";

        $links_array[$links_data['LID']] = $links_data;
    }

    return array(
        'links_count' => $links_count,
        'links_array' => $links_array
    );
}

/**
 * @param bool $visible
 * @return bool|array
 */
function links_folders_get($visible = true)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $visible = ($visible) ? "AND VISIBLE = 'Y'" : '';

    $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM `{$table_prefix}LINKS_FOLDERS` ";
    $sql .= "WHERE PARENT_FID IS NULL $visible ORDER BY FID LIMIT 1";

    $result = $db->query($sql);

    if ($result->num_rows == 0) return false;

    $links_data = $result->fetch_assoc();

    $top_level = $links_data['FID'];

    $folders[$links_data['FID']] = $links_data;

    $sql = "SELECT FID, PARENT_FID, NAME, VISIBLE FROM `{$table_prefix}LINKS_FOLDERS` ";
    $sql .= "WHERE FID NOT IN ($top_level) $visible ORDER BY NAME";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {

        while (($links_data = $result->fetch_assoc()) !== null) {
            $folders[$links_data['FID']] = $links_data;
        }
    }

    return $folders;
}

function links_add($uri, $title, $description, $fid, $uid, $visible = true)
{
    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    $uri = $db->escape($uri);

    $title = $db->escape($title);

    $description = $db->escape($description);

    $visible = $visible ? "Y" : "N";

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!($table_prefix = get_table_prefix())) return false;

    if (forum_get_setting('require_link_approval', 'Y') && !perm_is_links_moderator($uid)) {

        $sql = "INSERT INTO `{$table_prefix}LINKS` (URI, TITLE, DESCRIPTION, FID, ";
        $sql .= "UID, VISIBLE, CREATED, APPROVED) VALUES ('$uri', '$title', '$description', ";
        $sql .= "'$fid', '$uid', '$visible', CAST('$current_datetime' AS DATETIME), NULL)";

    } else {

        $sql = "INSERT INTO `{$table_prefix}LINKS` (URI, TITLE, DESCRIPTION, FID, ";
        $sql .= "UID, VISIBLE, CREATED, APPROVED, APPROVED_BY) VALUES ('$uri', '$title', ";
        $sql .= "'$description', '$fid', '$uid', '$visible', CAST('$current_datetime' AS DATETIME), ";
        $sql .= "CAST('$current_datetime' AS DATETIME), '$uid')";
    }

    if (!$db->query($sql)) return false;

    if (forum_get_setting('require_link_approval', 'Y') && !perm_is_links_moderator($uid)) {
        admin_send_post_approval_notification($fid);
    }

    return true;
}

function links_create_top_folder($name)
{
    if (!$db = db::get()) return false;

    $name = $db->escape($name);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "REPLACE INTO `{$table_prefix}LINKS_FOLDERS` (FID, PARENT_FID, ";
    $sql .= "NAME, VISIBLE) VALUES (1, NULL, '$name', 'Y')";

    if (!$db->query($sql)) return false;

    return true;
}

function links_add_folder($fid, $name, $uid, $visible = false)
{
    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    $name = $db->escape($name);

    $visible = $visible ? "Y" : "N";

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}LINKS_FOLDERS` (PARENT_FID, NAME, ";
    $sql .= "VISIBLE) VALUES ($fid, '$name', '$visible')";

    if (!$db->query($sql)) return false;

    return true;
}

function links_update_folder($fid, $uid, $name)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    $name = $db->escape($name);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS_FOLDERS` ";
    $sql .= "SET NAME = '$name' WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}

function links_get_folder_path_links($fid, $folders, $html = true, $link_last_too = false, $link_base = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

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

    $link_base = $link_base ? $link_base : "links.php?webtag=$webtag";

    if (strstr($link_base, "?")) {
        $result = $html ? "<a href=\"$link_base&amp;fid=$key\">" . word_filter_add_ob_tags($folders[$key]['NAME'], true) . "</a>" : word_filter_add_ob_tags($folders[$key]['NAME'], true);
    } else {
        $result = $html ? "<a href=\"$link_base&amp;fid=$key\">" . word_filter_add_ob_tags($folders[$key]['NAME'], true) . "</a>" : word_filter_add_ob_tags($folders[$key]['NAME'], true);
    }

    if (is_array($tree_array) && sizeof($tree_array) > 0) {

        while (($val = array_pop($tree_array)) !== null) {

            if (($val != $fid && $html) || $link_last_too) {
                $result .= $html ? html_style_image('separator') . "<a href=\"$link_base&amp;fid=$val\">" . word_filter_add_ob_tags($folders[$val]['NAME'], true) . "</a>" : " &gt; " . word_filter_add_ob_tags($folders[$val]['NAME'], true);
            } else {
                $result .= $html ? html_style_image('separator') . word_filter_add_ob_tags($folders[$val]['NAME'], true) : " &gt; " . word_filter_add_ob_tags($folders[$val]['NAME'], true);
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

        while (($val = array_pop($tree_array)) !== null) {

            $path .= " - " . $folders[$val]['NAME'];
        }
    }

    if ($link_title !== false) {
        $path .= ' - ' . $link_title;
    }

    return $path;
}

function links_get_subfolders($fid, $folders)
{
    $subfolders = array();

    if (is_array($folders)) {

        foreach ($folders as $key => $val) {

            if (isset($val['PARENT_FID']) && $val['PARENT_FID'] == $fid && $key != 1) $subfolders[] = $key;
        }
    }

    return $subfolders;
}

function links_change_visibility($lid, $visible = true)
{
    if (!is_numeric($lid)) return false;

    $visible = $visible ? "Y" : "N";

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS` ";
    $sql .= "SET VISIBLE = '$visible' WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    return true;
}

function links_click($lid)
{
    if (!is_numeric($lid)) return;

    if (!$db = db::get()) return;

    if (!($table_prefix = get_table_prefix())) return;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS` ";
    $sql .= "SET CLICKS = CLICKS + 1 WHERE LID = '$lid'";

    if (!$db->query($sql)) return;

    $sql = "SELECT URI FROM `{$table_prefix}LINKS` ";
    $sql .= "WHERE LID = '$lid'";

    if (!($result = $db->query($sql))) return;

    if ($result->num_rows == 0) return;

    list($link_uri) = $result->fetch_row();

    header_redirect($link_uri);
}

function links_get_single($lid, $approved = true)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    $approved = ($approved) ? "AND LINKS.APPROVED IS NOT NULL" : '';

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT LINKS.FID, LINKS.UID, LINKS.URI, LINKS.TITLE, ";
    $sql .= "LINKS.DESCRIPTION, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, ";
    $sql .= "LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.APPROVED) AS APPROVED, ";
    $sql .= "LINKS.APPROVED_BY, LINKS.CLICKS, USER.LOGON, USER.NICKNAME, ";
    $sql .= "AVG(LINKS_VOTE.RATING) AS RATING, COUNT(LINKS_VOTE.RATING) AS VOTES ";
    $sql .= "FROM `{$table_prefix}LINKS` LINKS LEFT JOIN USER USER ON (LINKS.UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
    $sql .= "WHERE LINKS.LID = '$lid' $approved GROUP BY LINKS_VOTE.LID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $link_array = $result->fetch_assoc();

    if (isset($link_array['LOGON']) && isset($link_array['PEER_NICKNAME'])) {
        if (!is_null($link_array['PEER_NICKNAME']) && strlen($link_array['PEER_NICKNAME']) > 0) {
            $link_array['NICKNAME'] = $link_array['PEER_NICKNAME'];
        }
    }

    if (!isset($link_array['LOGON'])) $link_array['LOGON'] = gettext("Unknown user");
    if (!isset($link_array['NICKNAME'])) $link_array['NICKNAME'] = "";

    return $link_array;
}

function links_get_all($invisible = false, $sort_by = "TITLE", $sort_dir = "ASC", $page = 1)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'TITLE',
        'DESCRIPTION',
        'CREATED',
        'RATING'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_bool($invisible)) $invisible = false;

    if (!is_numeric($page) || ($page < 1)) return $page = 1;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'TITLE';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!($table_prefix = get_table_prefix())) return false;

    $offset = calculate_page_offset($page, 20);

    $links_array = array();

    if ($invisible === false) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql .= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_prefix}LINKS` LINKS ";
        $sql .= "LEFT JOIN `{$table_prefix}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql .= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.VISIBLE = 'Y' ";
        $sql .= "AND LINKS.APPROVED IS NOT NULL GROUP BY LINKS.LID ";
        $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    } else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS.LID, LINKS.UID, USER.LOGON, USER.NICKNAME, LINKS.URI, LINKS.TITLE, ";
        $sql .= "LINKS.DESCRIPTION, LINKS.VISIBLE, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED, LINKS.CLICKS, ";
        $sql .= "AVG(LINKS_VOTE.RATING) AS RATING FROM `{$table_prefix}LINKS` LINKS ";
        $sql .= "LEFT JOIN `{$table_prefix}LINKS_VOTE` LINKS_VOTE ON (LINKS.LID = LINKS_VOTE.LID) ";
        $sql .= "LEFT JOIN USER USER ON (LINKS.UID = USER.UID) WHERE LINKS.APPROVED IS NOT NULL ";
        $sql .= "GROUP BY LINKS.LID ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($links_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($links_count > 0) && ($page > 1)) {
        return links_get_all($invisible, $sort_by, $sort_dir, $page - 1);
    }

    while (($links_data = $result->fetch_assoc()) !== null) {

        if (isset($links_data['LOGON']) && isset($links_data['PEER_NICKNAME'])) {
            if (!is_null($links_data['PEER_NICKNAME']) && strlen($links_data['PEER_NICKNAME']) > 0) {
                $links_data['NICKNAME'] = $links_data['PEER_NICKNAME'];
            }
        }

        if (!isset($links_data['LOGON'])) $links_data['LOGON'] = gettext("Unknown user");
        if (!isset($links_data['NICKNAME'])) $links_data['NICKNAME'] = "";

        $links_array[$links_data['LID']] = $links_data;
    }

    return array(
        'links_count' => $links_count,
        'links_array' => $links_array
    );
}

function links_folder_change_visibility($fid, $visible = true)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    $visible = $visible ? "Y" : "N";

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS_FOLDERS` ";
    $sql .= "SET VISIBLE = '$visible' WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    return true;
}

function links_folder_delete($fid)
{
    if (!is_numeric($fid)) return false;

    $folders = links_folders_get(!session::check_perm(USER_PERM_LINKS_MODERATE, 0));

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT MIN(FID) AS FID FROM `{$table_prefix}LINKS`";

    if (!($result = $db->query($sql))) return false;

    $link_array = $result->fetch_assoc();

    if (isset($link_array['FID']) && $link_array['FID'] == $fid) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS` ";
    $sql .= "SET FID = '{$folders[$fid]['PARENT_FID']}' WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}LINKS_FOLDERS` ";
    $sql .= "WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    return $result;
}

function links_get_vote($lid, $uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT RATING FROM `{$table_prefix}LINKS_VOTE` ";
    $sql .= "WHERE LID = '$lid' AND UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($vote) = $result->fetch_row();

    return $vote;
}

function links_vote($lid, $vote, $uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($vote)) return false;
    if (!is_numeric($uid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}LINKS_VOTE` (LID, UID, RATING, VOTED) ";
    $sql .= "VALUES ($lid, $uid, $vote, CAST('$current_datetime' AS DATETIME)) ";
    $sql .= "ON DUPLICATE KEY UPDATE RATING = VALUES(RATING), ";
    $sql .= "VOTED = CAST('$current_datetime' AS DATETIME) ";

    if (!$db->query($sql)) return false;

    return true;
}

function links_clear_vote($lid, $uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}LINKS_VOTE` ";
    $sql .= "WHERE UID = '$uid' AND LID = '$lid'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}

function links_add_comment($lid, $uid, $comment)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;
    if (!is_numeric($uid)) return false;

    $comment = $db->escape($comment);

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}LINKS_COMMENT` (LID, UID, COMMENT, CREATED) ";
    $sql .= "VALUES ('$lid', '$uid', '$comment', CAST('$current_datetime' AS DATETIME))";

    if (!$db->query($sql)) return false;

    return true;
}

function links_get_comments($lid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $links_comment_array = array();

    $sql = "SELECT LINKS_COMMENT.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(LINKS_COMMENT.CREATED) AS CREATED, ";
    $sql .= "LINKS_COMMENT.CID, LINKS_COMMENT.COMMENT FROM `{$table_prefix}LINKS_COMMENT` LINKS_COMMENT ";
    $sql .= "LEFT JOIN USER USER ON (LINKS_COMMENT.UID = USER.UID) ";
    $sql .= "WHERE LINKS_COMMENT.LID = '$lid' ORDER BY CREATED ASC";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($link_comment_data = $result->fetch_assoc()) !== null) {

        if (isset($link_comment_data['LOGON']) && isset($link_comment_data['PEER_NICKNAME'])) {
            if (!is_null($link_comment_data['PEER_NICKNAME']) && strlen($link_comment_data['PEER_NICKNAME']) > 0) {
                $link_comment_data['NICKNAME'] = $link_comment_data['PEER_NICKNAME'];
            }
        }

        if (!isset($link_comment_data['LOGON'])) $link_comment_data['LOGON'] = gettext("Unknown user");
        if (!isset($link_comment_data['NICKNAME'])) $link_comment_data['NICKNAME'] = "";

        $links_comment_array[] = $link_comment_data;
    }

    return $links_comment_array;
}

function links_folder_dropdown($default_fid, $folders)
{
    $default_value = 0;

    $labels = array();

    foreach (array_keys($folders) as $key) {

        $labels[$key] = links_get_folder_path_links($key, $folders, false);
        if ($key == $default_fid) $default_value = $key;
    }

    return form_dropdown_array("fid", $labels, $default_value, null, "links_dropdown");
}

function links_delete_comment($cid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($cid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}LINKS_COMMENT` WHERE CID = '$cid'";

    if (!($result = $db->query($sql))) return false;

    return $result;
}

function links_delete($lid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}LINKS` WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}LINKS_COMMENT` WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}LINKS_VOTE` WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    return true;
}

function links_update($lid, $fid, $uid, $title, $uri, $description)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    $uri = $db->escape($uri);

    $title = $db->escape($title);

    $description = $db->escape($description);

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (forum_get_setting('require_link_approval', 'Y') && !perm_is_links_moderator($uid)) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS` SET FID = '$fid', ";
        $sql .= "TITLE = '$title', URI = '$uri', DESCRIPTION = '$description', ";
        $sql .= "APPROVED = NULL, APPROVED_BY = NULL WHERE LID = '$lid'";

    } else {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS` SET FID = '$fid', ";
        $sql .= "TITLE = '$title', URI = '$uri', DESCRIPTION = '$description', ";
        $sql .= "APPROVED = CAST('$current_datetime' AS DATETIME), APPROVED_BY = $uid ";
        $sql .= "WHERE LID = '$lid'";
    }

    if (!$db->query($sql)) return false;

    return true;
}

function links_approve($lid)
{
    if (!is_numeric($lid)) return false;

    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}LINKS` ";
    $sql .= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql .= "APPROVED_BY = '{$_SESSION['UID']}' WHERE LID = '$lid'";

    if (!$db->query($sql)) return false;

    return true;
}

function links_get_creator_uid($lid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($lid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT UID FROM `{$table_prefix}LINKS` WHERE LID = '$lid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($creator_uid) = $result->fetch_row();

    return $creator_uid;
}

function links_get_comment_uid($cid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($cid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT UID FROM `{$table_prefix}LINKS_COMMENT` WHERE CID = '$cid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($comment_uid) = $result->fetch_row();

    return $comment_uid;
}