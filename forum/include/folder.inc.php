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

/* $Id: folder.inc.php,v 1.61 2004-05-05 22:07:08 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/constants.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $custom_html = "")
{
    $ustatus = bh_session_get_value('STATUS');
    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return "";

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if ($ustatus & PERM_CHECK_WORKER) {
        $sql = "SELECT FID, TITLE FROM {$table_data['PREFIX']}FOLDER WHERE ";
        $sql.= "ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL";
    } else {
        $sql = "SELECT DISTINCT F.FID, F.TITLE FROM {$table_data['PREFIX']}FOLDER F LEFT JOIN ";
        $sql.= "{$table_data['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = '$uid') ";
        $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR ((F.ACCESS_LEVEL = 1 OR F.ACCESS_LEVEL = 2) ";
        $sql.= "AND UF.ALLOWED <=> 1)) AND (F.ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL)";
    }

    return form_dropdown_sql($field_name.$suffix, $sql, $default_fid, $custom_html);
}

function folder_get_title($fid)
{
   $db_folder_get_title = db_connect();

   if (!is_numeric($fid)) return "The Unknown Folder";

   if (!$table_data = get_table_prefix()) return "The Unknown Folder";

   $sql = "SELECT FOLDER.TITLE FROM {$table_data['PREFIX']}FOLDER FOLDER WHERE FID = $fid";
   $result = db_query($sql, $db_folder_get_title);

   if (!db_num_rows($result)) {
     $foldertitle = "The Unknown Folder";
   }else {
     $data = db_fetch_array($result);
     $foldertitle = $data['TITLE'];
   }

   return $foldertitle;
}

function folder_create($title, $access, $description = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $db_folder_create = db_connect();

    $title = addslashes($title);
    $description = addslashes($description);

    if (!is_numeric($access)) $access = 0;
    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT MAX(POSITION) + 1 AS NEW_POS FROM {$table_data['PREFIX']}FOLDER";
    $result = db_query($sql, $db_folder_create);

    list($new_pos) = db_fetch_array($result, MYSQL_NUM);

    $sql = "INSERT INTO {$table_data['PREFIX']}FOLDER (TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
    $sql.= "VALUES ('$title', $access, '$description', $allowed_types, $new_pos)";

    $result = db_query($sql, $db_folder_create);

    if ($result) {
        $new_fid = db_insert_id($db_folder_create);
    }else {
        $new_fid = 0;
    }

    return $new_fid;
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

    $folder_data = array_merge(folder_get($fid), $folder_data);

    foreach($folder_data as $key => $value) {
        if (!is_numeric($value)) {
            $folder_data[$key] = addslashes($value);
        }
    }

    if (!isset($folder_data['TITLE'])) return false;
    if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = '';

    if (!isset($folder_data['ACCESS_LEVEL']) || !is_numeric($folder_data['ACCESS_LEVEL'])) $folder_data['ACCESS_LEVEL'] = 0;
    if (!isset($folder_data['ALLOWED_TYPES']) || !is_numeric($folder_data['ALLOWED_TYPES'])) $folder_data['ALLOWED_TYPES'] = FOLDER_ALLOW_ALL_THREAD;
    if (!isset($folder_data['POSITION']) || !is_numeric($folder_data['POSITION'])) $folder_data['POSITION'] = 0;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET TITLE = '{$folder_data['TITLE']}', ";
    $sql.= "ACCESS_LEVEL = {$folder_data['ACCESS_LEVEL']}, DESCRIPTION = '{$folder_data['DESCRIPTION']}', ";
    $sql.= "ALLOWED_TYPES = {$folder_data['ALLOWED_TYPES']}, POSITION = {$folder_data['POSITION']} WHERE FID = $fid";

    return db_query($sql, $db_folder_update);
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
    $db_folder_get_available = db_connect();

    if (!$table_data = get_table_prefix()) return '0';
    if (!$uid = bh_session_get_value('UID')) $uid = 0;

    $sql = "SELECT DISTINCT F.FID FROM {$table_data['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$table_data['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = $uid) ";
    $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR F.ACCESS_LEVEL = 2 OR ";
    $sql.= "(F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1)) ";
    $sql.= "ORDER BY F.POSITION";

    $result = db_query($sql, $db_folder_get_available);

    if (db_num_rows($result)) {
        $folder_list = array();
        while($row = db_fetch_array($result)){
            $folder_list[] = $row['FID'];
        }
        return implode(',', $folder_list);
    }

    return '0';
}

function folder_get_all()
{
    $db_folder_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, COUNT(THREAD.FID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "GROUP BY FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL ";
    $sql.= "ORDER BY FOLDER.POSITION";

    $result = db_query($sql, $db_folder_get_all);

    if (db_num_rows($result)) {
        $folder_list = array();
        while ($row = db_fetch_array($result)) {
            $folder_list[] = $row;
        }
        return $folder_list;
    }else {
        return array();
    }
}

function folder_get($fid)
{
    $db_folder_get = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, COUNT(THREAD.FID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL";

    $result = db_query($sql, $db_folder_get);

    if (db_num_rows($result)) {
      return db_fetch_array($result);
    }else {
      return false;
    }
}

function folder_get_permissions($fid)
{
    $db_folder_get_permissions = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM ";
    $sql.= "USER USER, {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER UF ON (UF.UID = USER.UID AND UF.FID = FOLDER.FID) ";
    $sql.= "WHERE FOLDER.FID = '$fid' AND UF.ALLOWED = 1";

    $result = db_query($sql, $db_folder_get_permissions);

    if (db_num_rows($result)) {
        $users = array();
        while($row = db_fetch_array($result)) {
            $users[] = $row;
        }
        return $users;
    }else {
        return false;
    }
}

// Checks that a $fid is a valid folder (i.e. it actually exists).

function folder_is_valid($fid)
{
    $db_folder_get_available = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT FID FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_get_available);

    if (db_num_rows($result)) {
        return true;
    }

    return false;
}

// Same as above, but also checks that the folder is accessible by the current user

function folder_is_accessible($fid)
{
    $uid = bh_session_get_value('UID');
    $db_folder_get_available = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT F.FID FROM {$table_data['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$table_data['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or ((F.ACCESS_LEVEL = 1 OR F.ACCESS_LEVEL = 2) ";
    $sql.= "AND UF.ALLOWED <=> 1)) and F.FID = '$fid'";

    $result = db_query($sql, $db_folder_get_available);

    if (db_num_rows($result)) {
        return true;
    }

    return false;
}

function user_set_folder_interest($fid, $interest)
{
    $uid = bh_session_get_value('UID');

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

function user_get_restricted_folders($uid)
{
    $db_user_get_restricted_folders = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT F.FID, F.TITLE, UF.ALLOWED FROM {$table_data['PREFIX']}FOLDER F ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_FOLDER UF ON (UF.UID = $uid AND UF.FID = F.FID) ";
    $sql.= "WHERE F.ACCESS_LEVEL = 1";

    $result = db_query($sql, $db_user_get_restricted_folders);

    if (db_num_rows($result)) {
        $user_restricted_folders_array = array();
	while ($row = db_fetch_array($result)) {
	    $user_restricted_folders_array[] = $row;
	}
	return $user_restricted_folders_array;
    }else {
        return false;
    }
}

function folder_thread_type_allowed($fid, $type) // for types see constants.inc.php
{
    $db_folder_thread_type_allowed = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($type)) $type = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ALLOWED_TYPES FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_thread_type_allowed);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row['ALLOWED_TYPES'] ? ($row['ALLOWED_TYPES'] & $type) : true;
    } else {
        return false;
    }
}

// Similar to folder_draw_dropdown() but simply returns
// a list of folders or false on none, rather than draw
// the drop down.

function folder_get_by_type_allowed($allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $db_folder_get_by_type_allowed = db_connect();

    $ustatus = bh_session_get_value('STATUS');
    $uid = bh_session_get_value('UID');

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT F.FID FROM {$table_data['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$table_data['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = '$uid') ";
    $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR (F.ACCESS_LEVEL > 0 AND UF.ALLOWED <=> 1)) ";
    $sql.= "AND (F.ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL)";

    $result = db_query($sql, $db_folder_get_by_type_allowed);

    if (db_num_rows($result)) {
        $allowed_folders = array();
        while($row = db_fetch_array($result)) {
            $allowed_folders[] = $row['FID'];
        }
        return $allowed_folders;
    } else {
        return false;
    }
}

?>