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

/* $Id: folder.inc.php,v 1.150 2008-07-30 16:04:35 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $custom_html = "", $class="bhselect")
{
    if (!$db_folder_draw_dropdown = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return "";

    if (!is_numeric($allowed_types)) return "";

    $available_folders = array();

    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FID, TITLE, DESCRIPTION FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "WHERE ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL ";
    $sql.= "ORDER BY POSITION ";

    if (!$result = db_query($sql, $db_folder_draw_dropdown)) return false;

    if (db_num_rows($result) > 0) {

        while (($folder_order = db_fetch_array($result))) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_order['FID'])) {

                    $available_folders[$folder_order['FID']] = _htmlentities($folder_order['TITLE']);
                }

            }else {

                if (bh_session_check_perm($access_allowed, $folder_order['FID'])) {

                    $available_folders[$folder_order['FID']] = _htmlentities($folder_order['TITLE']);
                }
            }
        }

        if (sizeof($available_folders) > 0) {

            return form_dropdown_array($field_name.$suffix, $available_folders, $default_fid, $custom_html, $class);
        }
    }

    return false;
}

function folder_draw_dropdown_all($default_fid, $field_name="t_fid", $suffix="", $custom_html = "", $class="bhselect")
{
    if (!$db_folder_draw_dropdown = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return "";

    $available_folders = array();

    $sql = "SELECT FID, TITLE, DESCRIPTION FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_folder_draw_dropdown)) return false;

    if (db_num_rows($result) > 0) {

        while (($folder_data = db_fetch_array($result))) {

            $available_folders[$folder_data['FID']] = _htmlentities($folder_data['TITLE']);
        }

        if (sizeof($available_folders) > 0) {

            return form_dropdown_array($field_name.$suffix, $available_folders, $default_fid, $custom_html, $class);
        }
    }

    return false;
}

function folder_get_title($fid)
{
    if (!$db_folder_get_title = db_connect()) return false;

    if (!is_numeric($fid)) return "The Unknown Folder";

    if (!$table_data = get_table_prefix()) return "The Unknown Folder";

    $sql = "SELECT TITLE FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_folder_get_title)) return false;

    if (db_num_rows($result) > 0) {

        list($folder_title) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder_title;
    }

    return "The Unknown Folder";
}

function folder_get_prefix($fid)
{
    if (!$db_folder_get_title = db_connect()) return false;

    if (!is_numeric($fid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT PREFIX FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_folder_get_title)) return false;

    if (db_num_rows($result) > 0) {

        list($folder_prefix) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder_prefix;
    }

    return "";
}

function folder_create($title, $description = "", $prefix = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $permissions = 0)
{
    if (!$db_folder_create = db_connect()) return false;

    $title = db_escape_string($title);
    $description = db_escape_string($description);
    $prefix = db_escape_string($prefix);

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;
    if (!is_numeric($permissions)) $permissions = 0;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT MAX(POSITION) + 1 AS NEW_POS FROM {$table_data['PREFIX']}FOLDER";

    if (!$result = db_query($sql, $db_folder_create)) return false;

    list($new_pos) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}FOLDER (TITLE, DESCRIPTION, PREFIX, ALLOWED_TYPES, POSITION) ";
    $sql.= "VALUES ('$title', '$description', '$prefix', '$allowed_types', '$new_pos')";

    if (!$result = db_query($sql, $db_folder_create)) return false;

    $new_fid = db_insert_id($db_folder_create);

    $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
    $sql.= "VALUES ('0', '$forum_fid', '$new_fid', '$permissions')";

    if (!$result = db_query($sql, $db_folder_create)) return false;

    return $new_fid;
}

function folder_delete($fid)
{
    if (!$db_folder_delete = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_folder_delete)) return false;

    return $result;
}

function folder_update($fid, $folder_data)
{
    if (!$db_folder_update = db_connect()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_array($folder_data)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $folder_data = array_merge(folder_get($fid), $folder_data);

    foreach ($folder_data as $key => $value) {
        if (!is_numeric($value)) {
            $folder_data[$key] = db_escape_string($value);
        }
    }

    if (!isset($folder_data['TITLE'])) return false;
    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = '';
    if (!isset($folder_data['PREFIX'])) $folder_data['PREFIX'] = '';

    if (!isset($folder_data['POSITION']) || !is_numeric($folder_data['POSITION'])) $folder_data['POSITION'] = 0;
    if (!isset($folder_data['ALLOWED_TYPES']) || !is_numeric($folder_data['ALLOWED_TYPES'])) $folder_data['ALLOWED_TYPES'] = 3;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET TITLE = '{$folder_data['TITLE']}', ";
    $sql.= "DESCRIPTION = '{$folder_data['DESCRIPTION']}', ALLOWED_TYPES = '{$folder_data['ALLOWED_TYPES']}', ";
    $sql.= "POSITION = '{$folder_data['POSITION']}', PREFIX = '{$folder_data['PREFIX']}' WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_folder_update)) return false;

    $sql = "SELECT FID FROM GROUP_PERMS WHERE FID = '$fid' ";
    $sql.= "AND FORUM = '$forum_fid' AND GID = '0'";

    if (!$result = db_query($sql, $db_folder_update)) return false;

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '{$folder_data['PERM']}' ";
        $sql.= "WHERE FID = '$fid' AND FORUM = '$forum_fid' AND GID = '0'";

        if (!$result = db_query($sql, $db_folder_update)) return false;

    }else {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('0', '$forum_fid', '$fid', '{$folder_data['PERM']}')";

        if (!$result = db_query($sql, $db_folder_update)) return false;
    }

    return true;
}

function folder_move_threads($from, $to)
{
    if (!$db_folder_move_threads = db_connect()) return false;

    if (!is_numeric($from)) return false;
    if (!is_numeric($to)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD SET FID = '$to' WHERE FID = '$from'";

    if (!$result = db_query($sql, $db_folder_move_threads)) return false;

    return $result;
}

function folder_get_available()
{
    if (user_is_guest()) {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS))) {
            return implode(',', preg_grep('/[0-9]+/', $folder_list));
        }

    }else {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ))) {
            return implode(',', preg_grep('/[0-9]+/', $folder_list));
        }
    }

    return '0';
}

function folder_get_available_by_forum($forum_fid)
{
    if (user_is_guest()) {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid))) {
            return implode(',', preg_grep('/[0-9]+/', $folder_list));
        }

    }else {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ, $forum_fid))) {
            return implode(',', preg_grep('/[0-9]+/', $folder_list));
        }
    }

    return '0';
}

function folder_get_available_array()
{
    if (user_is_guest()) {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS))) {
            return preg_grep('/[0-9]+/', $folder_list);
        }

    }else {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ))) {
            return preg_grep('/[0-9]+/', $folder_list);
        }
    }

    return '0';
}

function folder_get_available_array_by_forum($forum_fid)
{
    if (user_is_guest()) {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid))) {
            return preg_grep('/[0-9]+/', $folder_list);
        }

    }else {

        if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ, $forum_fid))) {
            return preg_grep('/[0-9]+/', $folder_list);
        }
    }

    return '0';
}

function folder_get_all()
{
    if (!$db_folder_get_all = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return array();

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, FOLDER.PREFIX, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.POSITION";

    if (!$result = db_query($sql, $db_folder_get_all)) return false;

    if (db_num_rows($result) > 0) {

        $folder_list = array();

        while (($folder_data = db_fetch_array($result))) {
            $folder_list[$folder_data['FID']] = $folder_data;
        }

        return $folder_list;
    }

    return false;
}

function folder_get_all_by_page($offset)
{
    if (!$db_folder_get_all_by_page = db_connect()) return false;

    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return array();

    $forum_fid = $table_data['FID'];

    $folder_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, FOLDER.PREFIX, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.POSITION ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_folder_get_all_by_page)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_folder_get_all_by_page)) return false;

    list($folder_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($folder_data = db_fetch_array($result))) {

            $folder_array[$folder_data['FID']] = $folder_data;
            $fid_array[] = $folder_data['FID'];
        }

        folders_get_thread_counts($folder_array, $fid_array);

    }else if ($folder_count > 0) {

        $offset = floor(($folder_count - 1) / 10) * 10;
        return folder_get_all_by_page($offset);
    }

    return array('folder_array' => $folder_array,
                 'folder_count' => $folder_count);
}

function folders_get_thread_counts(&$folder_array, $fid_array)
{
    if (!is_array($fid_array)) return false;
    if (sizeof($fid_array) < 1) return false;

    if (!$table_data = get_table_prefix()) return false;

    $fid_list = implode(",", preg_grep("/^[0-9]+$/", $fid_array));

    if (!$db_folder_get_thread_count = db_connect()) return false;

    $sql = "SELECT FID, COUNT(TID) AS THREAD_COUNT FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE FID IN ($fid_list) GROUP BY FID";

    if (!$result = db_query($sql, $db_folder_get_thread_count)) return false;

    while (($folder_data = db_fetch_array($result))) {
        $folder_array[$folder_data['FID']]['THREAD_COUNT'] = $folder_data['THREAD_COUNT'];
    }
    
    return true;
}

function folder_get_thread_count($fid)
{
    if (!$db_folder_get_thread_count = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS THREAD_COUNT FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_folder_get_thread_count)) return false;

    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $thread_count;
}

function folder_get($fid)
{
    if (!$db_folder_get = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.POSITION, ";
    $sql.= "FOLDER.PREFIX, FOLDER.ALLOWED_TYPES, GROUP_PERMS.PERM, USER_FOLDER.INTEREST ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = 0 AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
    $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '$uid') ";
    $sql.= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID, FOLDER.TITLE";

    if (!$result = db_query($sql, $db_folder_get)) return false;

    if (db_num_rows($result) > 0) {

        $folder_array = db_fetch_array($result);
        $folder_array['THREAD_COUNT'] = folder_get_thread_count($fid);

        return $folder_array;
    }

    return false;
}

// Checks that a $fid is a valid folder (i.e. it actually exists)

function folder_is_valid($fid)
{
    if (!$db_folder_get_available = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_folder_get_available)) return false;

    return (db_num_rows($result) > 0);
}

function folder_is_accessible($fid)
{
    if (!is_numeric($fid)) return false;

    return bh_session_check_perm(USER_PERM_POST_READ, $fid);
}

function user_set_folder_interest($fid, $interest)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$db_user_set_folder_interest = db_connect()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_numeric($interest)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_FOLDER ";
    $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    if (!$result = db_query($sql, $db_user_set_folder_interest)) return false;

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}USER_FOLDER SET INTEREST = '$interest' ";
        $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_FOLDER (UID, FID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$fid', '$interest')";
    }

    if (!$result = db_query($sql, $db_user_set_folder_interest)) return false;

    return true;
}

function folder_thread_type_allowed($fid, $type) // for types see constants.inc.php
{
    if (!$db_folder_thread_type_allowed = db_connect()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_numeric($type)) $type = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ALLOWED_TYPES FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";

    if (!$result = db_query($sql, $db_folder_thread_type_allowed)) return false;

    if (db_num_rows($result) > 0) {

        $folder_data = db_fetch_array($result);

        if (!isset($folder_data['ALLOWED_TYPES']) || is_null($folder_data['ALLOWED_TYPES'])) return true;

        return $folder_data['ALLOWED_TYPES'] ? ($folder_data['ALLOWED_TYPES'] & $type) : true;
    }

    return false;
}

// Similar to folder_draw_dropdown() but simply returns
// a list of folders or false on none, rather than draw
// the drop down.

function folder_get_by_type_allowed($allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    if (!$db_folder_get_by_type_allowed = db_connect()) return false;

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT FOLDER.FID FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "WHERE (FOLDER.ALLOWED_TYPES & $allowed_types > 0 OR FOLDER.ALLOWED_TYPES IS NULL)";

    if (!$result = db_query($sql, $db_folder_get_by_type_allowed)) return false;

    if (db_num_rows($result) > 0) {

        $allowed_folders = array();

        while (($folder_data = db_fetch_array($result))) {
            $allowed_folders[] = $folder_data['FID'];
        }

        return $allowed_folders;

    }else {

        return false;
    }
}

function folder_move_up($fid)
{
    if (!$db_folder_move_up = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    folder_positions_update();

    $sql = "SELECT FID, POSITION FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_folder_move_up)) return false;

    while (($folder_data = db_fetch_array($result))) {

        $folder_order[] = $folder_data['FID'];
        $folder_position[$folder_data['FID']] = $folder_data['POSITION'];
    }

    // Search for our folder in the list of know folders.

    if (($folder_order_key = array_search($fid, $folder_order)) !== false) {

        // Move the folder above to the same location as our selected folder.

        $folder_order_key--;
        if ($folder_order_key < 0) $folder_order_key = 0;

        $new_position = $folder_position[$fid];

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '{$folder_order[$folder_order_key]}'";

        if (!$result = db_query($sql, $db_folder_move_up)) return false;

        // Move the selected folder to the old location of the other folder.

        $new_position = $folder_position[$folder_order[$folder_order_key]];

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '$fid'";

        if (!$result = db_query($sql, $db_folder_move_up)) return false;

        return true;
    }

    return false;
}

function folder_move_down($fid)
{
    if (!$db_folder_move_down = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    folder_positions_update();

    $sql = "SELECT FID, POSITION FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_folder_move_down)) return false;

    while (($folder_data = db_fetch_array($result))) {

        $folder_order[] = $folder_data['FID'];
        $folder_position[$folder_data['FID']] = $folder_data['POSITION'];
    }

    if (($folder_order_key = array_search($fid, $folder_order)) !== false) {

        $folder_order_key++;

        if ($folder_order_key > sizeof($folder_order)) {
            $folder_order_key = sizeof($folder_order);
        }

        $new_position = $folder_position[$fid];

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '{$folder_order[$folder_order_key]}'";

        if (!$result = db_query($sql, $db_folder_move_down)) return false;

        $new_position = $folder_position[$folder_order[$folder_order_key]];

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '$fid'";

        if (!$result = db_query($sql, $db_folder_move_down)) return false;

        return true;
    }

    return false;
}

function folder_positions_update()
{
    $new_position = 0;

    if (!$db_folder_positions_update = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    if (!$result = db_query($sql, $db_folder_positions_update)) return false;

    while (list($fid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($fid) && is_numeric($fid)) {

            $new_position++;

            $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER ";
            $sql.= "SET POSITION = '$new_position' WHERE FID = '$fid'";

            if (!db_query($sql, $db_folder_positions_update)) return false;
        }
    }
    
    return true;
}

function folders_get_user_subscriptions($interest_type = FOLDER_NOINTEREST, $offset = 0)
{
    if (!$db_folders_get_user_subscriptions = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($interest_type)) $interest_type = FOLDER_NOINTEREST;

    if (!$table_data = get_table_prefix()) return false;

    $folder_subscriptions_array = array();

    // Get the folders the user can see.

    $folders = folder_get_available();

    // User UID

    $uid = bh_session_get_value('UID');

    if ($interest_type <> FOLDER_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql.= "USER_FOLDER.INTEREST FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
        $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '$uid') ";
        $sql.= "WHERE USER_FOLDER.INTEREST = '$interest_type' ";
        $sql.= "AND FOLDER.FID IN ($folders) ";
        $sql.= "ORDER BY FOLDER.POSITION DESC ";
        $sql.= "LIMIT $offset, 20";

    }else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql.= "USER_FOLDER.INTEREST FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
        $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '$uid') ";
        $sql.= "WHERE FOLDER.FID IN ($folders) ";
        $sql.= "ORDER BY FOLDER.POSITION DESC ";
        $sql.= "LIMIT $offset, 20";
    }

    if (!$result = db_query($sql, $db_folders_get_user_subscriptions)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_folders_get_user_subscriptions)) return false;

    list($folder_subscriptions_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($folder_data_array = db_fetch_array($result))) {

            $folder_subscriptions_array[] = $folder_data_array;
        }

    }else if ($folder_subscriptions_count > 0) {

        $offset = floor(($folder_subscriptions_count - 1) / 20) * 20;
        return folders_get_user_subscriptions($interest_type, $offset);
    }

    return array('folder_count' => $folder_subscriptions_count,
                 'folder_array' => $folder_subscriptions_array);
}

function folders_search_user_subscriptions($folder_search, $interest_type = FOLDER_NOINTEREST, $offset = 0)
{
    if (!$db_folders_search_user_subscriptions = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($interest_type)) $interest_type = FOLDER_NOINTEREST;

    if (!$table_data = get_table_prefix()) return false;

    $folder_search = db_escape_string($folder_search);

    $folder_subscriptions_array = array();

    // Get the folders the user can see.

    $folders = folder_get_available();

    // User UID

    $uid = bh_session_get_value('UID');

    if ($interest_type <> FOLDER_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql.= "USER_FOLDER.INTEREST FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
        $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '$uid') ";
        $sql.= "WHERE USER_FOLDER.INTEREST = '$interest_type' ";
        $sql.= "AND FOLDER.TITLE LIKE '$folder_search%' ";
        $sql.= "AND FOLDER.FID IN ($folders) ";
        $sql.= "ORDER BY FOLDER.POSITION DESC ";
        $sql.= "LIMIT $offset, 20";

    }else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql.= "USER_FOLDER.INTEREST FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER USER_FOLDER ";
        $sql.= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '$uid') ";
        $sql.= "WHERE FOLDER.FID IN ($folders) ";
        $sql.= "AND FOLDER.TITLE LIKE '$folder_search%' ";
        $sql.= "ORDER BY FOLDER.POSITION DESC ";
        $sql.= "LIMIT $offset, 20";
    }

    if (!$result = db_query($sql, $db_folders_search_user_subscriptions)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_folders_search_user_subscriptions)) return false;

    list($folder_subscriptions_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($folder_data_array = db_fetch_array($result))) {

            $folder_subscriptions_array[] = $folder_data_array;
        }

    }else if ($folder_subscriptions_count > 0) {

        $offset = floor(($folder_subscriptions_count - 1) / 20) * 20;
        return folders_search_user_subscriptions($folder_search, $interest_type, $offset);
    }

    return array('folder_count' => $folder_subscriptions_count,
                 'folder_array' => $folder_subscriptions_array);
}

?>