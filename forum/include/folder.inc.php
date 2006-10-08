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

/* $Id: folder.inc.php,v 1.112 2006-10-08 17:22:47 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $custom_html = "", $class="bhselect")
{
    $db_folder_draw_dropdown = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return "";

    $forum_fid = $table_data['FID'];

    if (!is_numeric($allowed_types)) return "";

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "WHERE FOLDER.ALLOWED_TYPES & $allowed_types > 0 ";
    $sql.= "OR FOLDER.ALLOWED_TYPES IS NULL ";
    $sql.= "ORDER BY FOLDER.FID ";

    $result = db_query($sql, $db_folder_draw_dropdown);

    if (db_num_rows($result) > 0) {

        while($folder_data = db_fetch_array($result)) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                    $folders['FIDS'][]   = $folder_data['FID'];
                    $folders['TITLES'][] = $folder_data['TITLE'];
                }

            }else {
            
                if (bh_session_check_perm($access_allowed, $folder_data['FID'])) {

                    $folders['FIDS'][]   = $folder_data['FID'];
                    $folders['TITLES'][] = $folder_data['TITLE'];
                }
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            return form_dropdown_array($field_name.$suffix, $folders['FIDS'], $folders['TITLES'], $default_fid, $custom_html, $class);
        }
    }

    return false;
}

function folder_draw_dropdown_all($default_fid, $field_name="t_fid", $suffix="", $custom_html = "", $class="bhselect")
{
    $db_folder_draw_dropdown = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return "";

    $forum_fid = $table_data['FID'];

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";

    $result = db_query($sql, $db_folder_draw_dropdown);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            if (!in_array($row['FID'], $folders['FIDS'])) {

                $folders['FIDS'][] = $row['FID'];
                $folders['TITLES'][] = $row['TITLE'];
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            return form_dropdown_array($field_name.$suffix, $folders['FIDS'], $folders['TITLES'], $default_fid, $custom_html, $class);
        }
    }

    return false;
}

function folder_get_title($fid)
{
    $db_folder_get_title = db_connect();

    if (!is_numeric($fid)) return "The Unknown Folder";

    if (!$table_data = get_table_prefix()) return "The Unknown Folder";

    $sql = "SELECT FOLDER.TITLE FROM {$table_data['PREFIX']}FOLDER FOLDER WHERE FID = $fid";
    $result = db_query($sql, $db_folder_get_title);

    if (db_num_rows($result) < 1) {
        $foldertitle = "The Unknown Folder";
    }else {
        $data = db_fetch_array($result);
        $foldertitle = $data['TITLE'];
    }

    return $foldertitle;
}

function folder_create($title, $description = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $permissions = 0)
{
    $db_folder_create = db_connect();

    $title = addslashes($title);
    $description = addslashes($description);

    $new_pos = 0;

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;
    if (!is_numeric($permissions)) $permissions = 0;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT MAX(POSITION) + 1 AS NEW_POS FROM {$table_data['PREFIX']}FOLDER";
    $result = db_query($sql, $db_folder_create);

    if ($row = db_fetch_array($result)) {
        $new_pos = $row['NEW_POS'];
    }

    $sql = "INSERT INTO {$table_data['PREFIX']}FOLDER (TITLE, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
    $sql.= "VALUES ('$title', '$description', '$allowed_types', '$new_pos')";

    $result = db_query($sql, $db_folder_create);

    $new_fid = db_insert_id($db_folder_create);

    $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
    $sql.= "VALUES ('0', '$forum_fid', '$new_fid', '$permissions')";

    return db_query($sql, $db_folder_create);
}

function folder_delete($fid)
{
    $db_folder_delete = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_delete);

    return $result;
}

function folder_update($fid, $folder_data)
{
    $db_folder_update = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_array($folder_data)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $folder_data = array_merge(folder_get($fid), $folder_data);

    foreach($folder_data as $key => $value) {
        if (!is_numeric($value)) {
            $folder_data[$key] = addslashes($value);
        }
    }

    if (!isset($folder_data['TITLE'])) return false;
    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = '';

    if (!isset($folder_data['POSITION']) || !is_numeric($folder_data['POSITION'])) $folder_data['POSITION'] = 0;
    if (!isset($folder_data['ALLOWED_TYPES']) || !is_numeric($folder_data['ALLOWED_TYPES'])) $folder_data['ALLOWED_TYPES'] = 3;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET TITLE = '{$folder_data['TITLE']}', ";
    $sql.= "DESCRIPTION = '{$folder_data['DESCRIPTION']}', ALLOWED_TYPES = '{$folder_data['ALLOWED_TYPES']}', ";
    $sql.= "POSITION = '{$folder_data['POSITION']}' WHERE FID = $fid";

    $result = db_query($sql, $db_folder_update);

    $sql = "DELETE FROM GROUP_PERMS WHERE FID = '$fid' ";
    $sql.= "AND FORUM = '$forum_fid' AND GID = '0'";

    $result = db_query($sql, $db_folder_update);

    $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
    $sql.= "VALUES ('0', '$forum_fid', '$fid', '{$folder_data['PERM']}')";

    $result = db_query($sql, $db_folder_update);

    return true;
}

function folder_move_threads($from, $to)
{
    $db_folder_move_threads = db_connect();

    if (!is_numeric($from)) return false;
    if (!is_numeric($to)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD SET FID = '$to' WHERE FID = '$from'";
    $result = db_query($sql, $db_folder_move_threads);

    return $result;
}

function folder_get_available()
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS)) {
            return implode(',', $folder_list);
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ)) {
            return implode(',', $folder_list);
        }
    }

    return '0';
}

function folder_get_available_by_forum($forum_fid)
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid)) {
            return implode(',', $folder_list);
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ, $forum_fid)) {
            return implode(',', $folder_list);
        }
    }

    return '0';
}

function folder_get_available_array()
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS)) {
            return $folder_list;
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ)) {
            return $folder_list;
        }
    }

    return '0';
}

function folder_get_available_array_by_forum($forum_fid)
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid)) {
            return $folder_list;
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ, $forum_fid)) {
            return $folder_list;
        }
    }

    return '0';
}

function folder_get_all()
{
    $db_folder_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.POSITION";

    $result = db_query($sql, $db_folder_get_all);

    if (db_num_rows($result) > 0) {

        $folder_list = array();

        while ($row = db_fetch_array($result)) {
            $folder_list[$row['FID']] = $row;
        }

        return $folder_list;
    }

    return false;
}

function folder_get_thread_count($fid)
{
    $db_folder_get_thread_count = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE FID = $fid";

    $result = db_query($sql, $db_folder_get_thread_count);
    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $thread_count;
}

function folder_get($fid)
{
    $db_folder_get = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.POSITION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, GROUP_PERMS.PERM, ";
    $sql.= "COUNT(THREAD.FID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = 0 AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID, FOLDER.TITLE";

    $result = db_query($sql, $db_folder_get);

    if (db_num_rows($result) > 0) {
        return db_fetch_array($result);
    }else {
        return false;
    }
}

// Checks that a $fid is a valid folder (i.e. it actually exists)

function folder_is_valid($fid)
{
    $db_folder_get_available = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid' LIMIT 0, 1";
    $result = db_query($sql, $db_folder_get_available);

    return (db_num_rows($result) > 0);
}

function folder_is_accessible($fid)
{
    if (!is_numeric($fid)) return false;

    $access_allowed = USER_PERM_POST_READ;
    return bh_session_check_perm($access_allowed, $fid);
}

function user_set_folder_interest($fid, $interest)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $db_user_set_folder_interest = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($interest)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_FOLDER ";
    $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    $result = db_query($sql, $db_user_set_folder_interest);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE {$table_data['PREFIX']}USER_FOLDER SET INTEREST = '$interest' ";
        $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_FOLDER (UID, FID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$fid', '$interest')";
    }

    return db_query($sql, $db_user_set_folder_interest);
}

function folder_thread_type_allowed($fid, $type) // for types see constants.inc.php
{
    $db_folder_thread_type_allowed = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($type)) $type = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ALLOWED_TYPES FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_thread_type_allowed);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (!isset($row['ALLOWED_TYPES']) || is_null($row['ALLOWED_TYPES'])) return true;

        return $row['ALLOWED_TYPES'] ? ($row['ALLOWED_TYPES'] & $type) : true;
    }

    return false;
}

// Similar to folder_draw_dropdown() but simply returns
// a list of folders or false on none, rather than draw
// the drop down.

function folder_get_by_type_allowed($allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $db_folder_get_by_type_allowed = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT FOLDER.FID FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "WHERE (FOLDER.ALLOWED_TYPES & $allowed_types > 0 OR FOLDER.ALLOWED_TYPES IS NULL)";

    $result = db_query($sql, $db_folder_get_by_type_allowed);

    if (db_num_rows($result) > 0) {

        $allowed_folders = array();

        while($row = db_fetch_array($result)) {
            $allowed_folders[] = $row['FID'];
        }

        return $allowed_folders;

    }else {

        return false;
    }
}

function folder_move_up($fid)
{
    $db_folder_move_up = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_folder_move_up);

    while ($row = db_fetch_array($result)) {
        $folder_data[] = $row['FID'];
    }

    if (($folder_position_key = array_search($fid, $folder_data)) !== false) {

        $folder_position_key--;

        if ($folder_position_key < 0) {
            $folder_position_key = 0;
        }

        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = POSITION + 1 ";
        $sql.= "WHERE FID = '{$folder_data[$folder_position_key]}'";

        if (!$result = db_query($sql, $db_folder_move_up)) return false;

        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = POSITION - 1 ";
        $sql.= "WHERE FID = '$fid'";

        if (!$result = db_query($sql, $db_folder_move_up)) return false;

        return true;
    }

    return false;
}

function folder_move_down($fid)
{
    $db_folder_move_down = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_folder_move_down);

    while ($row = db_fetch_array($result)) {
        $folder_data[] = $row['FID'];
    }

    if (($folder_position_key = array_search($fid, $folder_data)) !== false) {

        $folder_position_key++;

        if ($folder_position_key > sizeof($folder_data)) {
            $folder_position_key = sizeof($folder_data);
        }        
        
        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = POSITION - 1 ";
        $sql.= "WHERE FID = '{$folder_data[$folder_position_key]}'";

        if (!$result = db_query($sql, $db_folder_move_down)) return false;

        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = POSITION + 1 ";
        $sql.= "WHERE FID = '$fid'";

        if (!$result = db_query($sql, $db_folder_move_down)) return false;

        return true;
    }

    return false;
}

?>