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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
// End Required includes

function folder_draw_dropdown($default_fid, $field_name = "t_fid", $suffix = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $access_allowed = USER_PERM_THREAD_CREATE, $custom_html = "", $class = "bhselect")
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return "";

    if (!is_numeric($allowed_types)) return "";

    $available_folders = array();

    $sql = "SELECT FID, TITLE, DESCRIPTION FROM `{$table_prefix}FOLDER` ";
    $sql .= "WHERE ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL ";
    $sql .= "ORDER BY POSITION ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($folder_order = $result->fetch_assoc()) !== null) {

        if (!session::logged_in()) {

            if (session::check_perm(USER_PERM_GUEST_ACCESS, $folder_order['FID'])) {

                $available_folders[$folder_order['FID']] = htmlentities_array($folder_order['TITLE']);
            }

        } else {

            if (session::check_perm($access_allowed, $folder_order['FID']) || ($default_fid == $folder_order['FID'])) {

                $available_folders[$folder_order['FID']] = htmlentities_array($folder_order['TITLE']);
            }
        }
    }

    if (sizeof($available_folders) == 0) return false;

    return form_dropdown_array($field_name . $suffix, $available_folders, $default_fid, $custom_html, $class);
}

function folder_draw_dropdown_all($default_fid, $field_name = "t_fid", $suffix = "", $custom_html = "", $class = "bhselect")
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return "";

    $available_folders = array();

    $sql = "SELECT FID, TITLE, DESCRIPTION FROM `{$table_prefix}FOLDER` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($folder_data = $result->fetch_assoc()) !== null) {
        $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
    }

    if (sizeof($available_folders) == 0) return false;

    return form_dropdown_array($field_name . $suffix, $available_folders, $default_fid, $custom_html, $class);
}

function folder_get_title($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return "The Unknown Folder";

    if (!($table_prefix = get_table_prefix())) return "The Unknown Folder";

    $sql = "SELECT TITLE FROM `{$table_prefix}FOLDER` WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($folder_title) = $result->fetch_row();

    return $folder_title;
}

function folder_get_prefix($fid)
{
    if (!$db = db::get()) return '';

    if (!is_numeric($fid)) return '';

    if (!($table_prefix = get_table_prefix())) return '';

    $sql = "SELECT PREFIX FROM `{$table_prefix}FOLDER` WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return '';

    if ($result->num_rows == 0) return '';

    list($folder_prefix) = $result->fetch_row();

    return $folder_prefix;
}

function folder_create($title, $description = "", $prefix = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $permissions = 0)
{
    if (!$db = db::get()) return false;

    $title = $db->escape($title);
    $description = $db->escape($description);
    $prefix = $db->escape($prefix);

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;
    if (!is_numeric($permissions)) $permissions = 0;

    if (!($table_prefix = get_table_prefix())) return 0;

    $sql = "SELECT MAX(POSITION) + 1 AS NEW_POS FROM `{$table_prefix}FOLDER`";

    if (!($result = $db->query($sql))) return false;

    list($new_pos) = $result->fetch_row();

    $sql = "INSERT INTO `{$table_prefix}FOLDER` (TITLE, DESCRIPTION, CREATED, PREFIX, ALLOWED_TYPES, POSITION, PERM) ";
    $sql .= "VALUES ('$title', '$description', NOW(), '$prefix', '$allowed_types', '$new_pos', '$permissions')";

    if (!($result = $db->query($sql))) return false;

    return $db->insert_id;
}

function folder_delete($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}FOLDER` WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    return $result;
}

function folder_update($fid, $folder_data)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_array($folder_data)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $folder_data = array_merge(folder_get($fid), $folder_data);

    foreach ($folder_data as $key => $value) {
        if (!is_numeric($value)) {
            $folder_data[$key] = $db->escape($value);
        }
    }

    if (!isset($folder_data['TITLE'])) return false;
    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = '';
    if (!isset($folder_data['PREFIX'])) $folder_data['PREFIX'] = '';

    if (!isset($folder_data['POSITION']) || !is_numeric($folder_data['POSITION'])) $folder_data['POSITION'] = 0;
    if (!isset($folder_data['ALLOWED_TYPES']) || !is_numeric($folder_data['ALLOWED_TYPES'])) $folder_data['ALLOWED_TYPES'] = 3;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FOLDER` SET TITLE = '{$folder_data['TITLE']}', ";
    $sql .= "DESCRIPTION = '{$folder_data['DESCRIPTION']}', MODIFIED = NOW(), ALLOWED_TYPES = '{$folder_data['ALLOWED_TYPES']}', ";
    $sql .= "POSITION = '{$folder_data['POSITION']}', PREFIX = '{$folder_data['PREFIX']}', ";
    $sql .= "PERM = '{$folder_data['PERM']}' WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    return true;
}

function folder_move_threads($from, $to)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($from)) return false;
    if (!is_numeric($to)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = date(MYSQL_DATETIME, threads_get_unread_cutoff());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET FID = '$to', ";
    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) WHERE FID = '$from'";

    if (!($result = $db->query($sql))) return false;

    return $result;
}

function folder_get_available()
{
    if (!session::logged_in()) {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_GUEST_ACCESS)) !== false) {
            return implode(',', array_filter($folder_list, 'is_numeric'));
        }

    } else {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_POST_READ)) !== false) {
            return implode(',', array_filter($folder_list, 'is_numeric'));
        }
    }

    return '0';
}

function folder_get_available_by_forum($forum_fid)
{
    if (!is_numeric($forum_fid)) return '0';

    if (!session::logged_in()) {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid)) !== false) {
            return implode(',', array_filter($folder_list, 'is_numeric'));
        }

    } else {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_POST_READ, $forum_fid)) !== false) {
            return implode(',', array_filter($folder_list, 'is_numeric'));
        }
    }

    return '0';
}

function folder_get_available_array()
{
    if (!session::logged_in()) {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_GUEST_ACCESS)) !== false) {
            return array_filter($folder_list, 'is_numeric');
        }

    } else {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_POST_READ)) !== false) {
            return array_filter($folder_list, 'is_numeric');
        }
    }

    return '0';
}

function folder_get_available_array_by_forum($forum_fid)
{
    if (!session::logged_in()) {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid)) !== false) {
            return array_filter($folder_list, 'is_numeric');
        }

    } else {

        if (($folder_list = session::get_folders_by_perm(USER_PERM_POST_READ, $forum_fid)) !== false) {
            return array_filter($folder_list, 'is_numeric');
        }
    }

    return '0';
}

function folder_get_all()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return array();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.ALLOWED_TYPES, ";
    $sql .= "FOLDER.POSITION, FOLDER.PREFIX, FOLDER.PERM AS FOLDER_PERMS, ";
    $sql .= "IF (FOLDER.PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ORDER BY FOLDER.POSITION";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $folder_list = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {
        $folder_list[$folder_data['FID']] = $folder_data;
    }

    return $folder_list;
}

function folder_get_all_by_page($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return array();

    $folder_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
    $sql .= "FOLDER.DESCRIPTION, FOLDER.ALLOWED_TYPES, ";
    $sql .= "FOLDER.POSITION, FOLDER.PREFIX, FOLDER.PERM AS FOLDER_PERMS, ";
    $sql .= "IF (FOLDER.PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ORDER BY FOLDER.POSITION ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($folder_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($folder_count > 0) && ($page > 1)) {
        return folder_get_all_by_page($page - 1);
    }

    $fid_array = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {

        $folder_array[$folder_data['FID']] = $folder_data;
        $fid_array[] = $folder_data['FID'];
    }

    folders_get_thread_counts($folder_array, $fid_array);

    return array(
        'folder_array' => $folder_array,
        'folder_count' => $folder_count
    );
}

function folders_get_thread_counts(&$folder_array, $fid_array)
{
    if (!is_array($fid_array)) return false;
    if (sizeof($fid_array) < 1) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $fid_list = implode(",", array_filter($fid_array, 'is_numeric'));

    if (!$db = db::get()) return false;

    $sql = "SELECT FID, COUNT(*) AS THREAD_COUNT FROM `{$table_prefix}THREAD` ";
    $sql .= "WHERE FID IN ($fid_list) GROUP BY FID";

    if (!($result = $db->query($sql))) return false;

    while (($folder_data = $result->fetch_assoc()) !== null) {
        $folder_array[$folder_data['FID']]['THREAD_COUNT'] = $folder_data['THREAD_COUNT'];
    }

    return true;
}

function folder_get_thread_count($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(TID) AS THREAD_COUNT FROM `{$table_prefix}THREAD` ";
    $sql .= "WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    list($thread_count) = $result->fetch_row();

    return $thread_count;
}

function folder_get($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.POSITION, ";
    $sql .= "FOLDER.PREFIX, FOLDER.ALLOWED_TYPES, FOLDER.PERM, USER_FOLDER.INTEREST ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID, FOLDER.TITLE";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $folder_array = $result->fetch_assoc();

    $folder_array['THREAD_COUNT'] = folder_get_thread_count($fid);

    return $folder_array;
}

function folder_get_available_details()
{
    if (!($fid_list = folder_get_available())) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.POSITION, ";
    $sql .= "FOLDER.PREFIX, FOLDER.ALLOWED_TYPES, FOLDER.PERM, USER_FOLDER.INTEREST ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
    $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE FOLDER.FID IN ($fid_list) GROUP BY FOLDER.FID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $folders_array = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {
        $folders_array[$folder_data['FID']] = $folder_data;
    }

    return $folders_array;
}

function folder_is_valid($fid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT COUNT(FID) FROM `{$table_prefix}FOLDER` WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    list($folder_count) = $result->fetch_row();

    return ($folder_count > 0);
}

function folder_is_accessible($fid)
{
    if (!is_numeric($fid)) return false;

    return session::check_perm(USER_PERM_POST_READ, $fid);
}

function user_set_folder_interest($fid, $interest)
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_numeric($interest)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}USER_FOLDER` (UID, FID, INTEREST) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', '$fid', '$interest') ON DUPLICATE KEY UPDATE ";
    $sql .= "INTEREST = VALUES(INTEREST)";

    if (!$db->query($sql)) return false;

    return true;
}

function folder_thread_type_allowed($fid, $type) // for types see constants.inc.php
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_numeric($type)) $type = FOLDER_ALLOW_ALL_THREAD;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT ALLOWED_TYPES FROM `{$table_prefix}FOLDER` WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $folder_data = $result->fetch_assoc();

    if (!isset($folder_data['ALLOWED_TYPES']) || is_null($folder_data['ALLOWED_TYPES'])) return true;

    return $folder_data['ALLOWED_TYPES'] ? ($folder_data['ALLOWED_TYPES'] & $type) : true;
}

// Similar to folder_draw_dropdown() but simply returns
// a list of folders or false on none, rather than draw
// the drop down.
function folder_get_by_type_allowed($allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT DISTINCT FOLDER.FID FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "WHERE (FOLDER.ALLOWED_TYPES & $allowed_types > 0 OR FOLDER.ALLOWED_TYPES IS NULL)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $allowed_folders = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {
        $allowed_folders[] = $folder_data['FID'];
    }

    return $allowed_folders;
}

function folder_move_up($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    folder_positions_update();

    $sql = "SELECT FID, POSITION FROM `{$table_prefix}FOLDER` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    $folder_order = array();
    $folder_position = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {

        $folder_order[] = $folder_data['FID'];
        $folder_position[$folder_data['FID']] = $folder_data['POSITION'];
    }

    // Search for our folder in the list of know folders.
    if (($folder_order_key = array_search($fid, $folder_order)) === false) return false;

    // Move the folder above to the same location as our selected folder.
    $folder_order_key--;

    if ($folder_order_key < 0) $folder_order_key = 0;

    $new_position = $folder_position[$fid];

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FOLDER` SET POSITION = '$new_position' ";
    $sql .= "WHERE FID = '{$folder_order[$folder_order_key]}'";

    if (!($result = $db->query($sql))) return false;

    $new_position = $folder_position[$folder_order[$folder_order_key]];

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FOLDER` SET POSITION = '$new_position' ";
    $sql .= "WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    return true;
}

function folder_move_down($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    folder_positions_update();

    $sql = "SELECT FID, POSITION FROM `{$table_prefix}FOLDER` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    $folder_order = array();
    $folder_position = array();

    while (($folder_data = $result->fetch_assoc()) !== null) {

        $folder_order[] = $folder_data['FID'];
        $folder_position[$folder_data['FID']] = $folder_data['POSITION'];
    }

    if (($folder_order_key = array_search($fid, $folder_order)) === false) return false;

    $folder_order_key++;

    if ($folder_order_key > sizeof($folder_order)) {
        $folder_order_key = sizeof($folder_order);
    }

    $new_position = $folder_position[$fid];

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FOLDER` SET POSITION = '$new_position' ";
    $sql .= "WHERE FID = '{$folder_order[$folder_order_key]}'";

    if (!($result = $db->query($sql))) return false;

    $new_position = $folder_position[$folder_order[$folder_order_key]];

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FOLDER` SET POSITION = '$new_position' ";
    $sql .= "WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    return true;
}

function folder_positions_update()
{
    $new_position = 0;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FID FROM `{$table_prefix}FOLDER` ";
    $sql .= "ORDER BY POSITION";

    if (!($result = $db->query($sql))) return false;

    while (($folder_data = $result->fetch_assoc()) !== null) {

        $new_position++;

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}FOLDER` ";
        $sql .= "SET POSITION = '$new_position' WHERE FID = '{$folder_data['FID']}'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function folders_get_user_subscriptions($interest_type = FOLDER_NOINTEREST, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($page)) $page = 1;

    if (!is_numeric($interest_type)) $interest_type = FOLDER_NOINTEREST;

    $offset = calculate_page_offset($page, 20);

    if (!($table_prefix = get_table_prefix())) return false;

    $folder_subscriptions_array = array();

    $folders = folder_get_available();

    if ($interest_type <> FOLDER_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql .= "USER_FOLDER.INTEREST FROM `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
        $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE USER_FOLDER.INTEREST = '$interest_type' ";
        $sql .= "AND FOLDER.FID IN ($folders) ";
        $sql .= "ORDER BY FOLDER.POSITION DESC ";
        $sql .= "LIMIT $offset, 20";

    } else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql .= "USER_FOLDER.INTEREST FROM `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
        $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE FOLDER.FID IN ($folders) ";
        $sql .= "ORDER BY FOLDER.POSITION DESC ";
        $sql .= "LIMIT $offset, 20";
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($folder_subscriptions_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($folder_subscriptions_count > 0) && ($page > 1)) {
        return folders_get_user_subscriptions($interest_type, $page - 1);
    }

    while (($folder_data_array = $result->fetch_assoc()) !== null) {
        $folder_subscriptions_array[] = $folder_data_array;
    }

    return array(
        'folder_count' => $folder_subscriptions_count,
        'folder_array' => $folder_subscriptions_array
    );
}

function folders_search_user_subscriptions($folder_search, $interest_type = FOLDER_NOINTEREST, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($page)) $page = 1;

    if (!is_numeric($interest_type)) $interest_type = FOLDER_NOINTEREST;

    $offset = calculate_page_offset($page, 20);

    if (!($table_prefix = get_table_prefix())) return false;

    $folder_search = $db->escape($folder_search);

    $folder_subscriptions_array = array();

    $folders = folder_get_available();

    if ($interest_type <> FOLDER_NOINTEREST) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql .= "USER_FOLDER.INTEREST FROM `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
        $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE USER_FOLDER.INTEREST = '$interest_type' ";
        $sql .= "AND FOLDER.TITLE LIKE '$folder_search%' ";
        $sql .= "AND FOLDER.FID IN ($folders) ";
        $sql .= "ORDER BY FOLDER.POSITION DESC ";
        $sql .= "LIMIT $offset, 20";

    } else {

        $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
        $sql .= "USER_FOLDER.INTEREST FROM `{$table_prefix}FOLDER` FOLDER ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_FOLDER` USER_FOLDER ";
        $sql .= "ON (USER_FOLDER.FID = FOLDER.FID AND USER_FOLDER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE FOLDER.FID IN ($folders) ";
        $sql .= "AND FOLDER.TITLE LIKE '$folder_search%' ";
        $sql .= "ORDER BY FOLDER.POSITION DESC ";
        $sql .= "LIMIT $offset, 20";
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($folder_subscriptions_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($folder_subscriptions_count > 0) && ($page > 1)) {
        return folders_search_user_subscriptions($folder_search, $interest_type, $page - 1);
    }

    while (($folder_data_array = $result->fetch_assoc()) !== null) {
        $folder_subscriptions_array[] = $folder_data_array;
    }

    return array(
        'folder_count' => $folder_subscriptions_count,
        'folder_array' => $folder_subscriptions_array
    );
}