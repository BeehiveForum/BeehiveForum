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

/* $Id: folder.inc.php,v 1.51 2004-03-13 20:04:36 decoyduck Exp $ */

include_once("./include/constants.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $custom_html = "")
{
    $ustatus = bh_session_get_value('STATUS');
    $uid = bh_session_get_value('UID');
    
    $webtag = get_webtag();
    
    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if ($ustatus & PERM_CHECK_WORKER) {
        $sql = "SELECT FID, TITLE FROM {$webtag['PREFIX']}FOLDER WHERE ";
        $sql.= "ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL";
    } else {
        $sql = "SELECT DISTINCT F.FID, F.TITLE FROM {$webtag['PREFIX']}FOLDER F LEFT JOIN ";
        $sql.= "{$webtag['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = '$uid') ";
        $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR ((F.ACCESS_LEVEL = 1 OR F.ACCESS_LEVEL = 2) ";
        $sql.= "AND UF.ALLOWED <=> 1)) AND (F.ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL)";
    }

    return form_dropdown_sql($field_name.$suffix, $sql, $default_fid, $custom_html);
}

function folder_get_title($fid)
{
   $db_folder_get_title = db_connect();

   if (!is_numeric($fid)) return "The Unknown Folder";
   
   $webtag = get_webtag();

   $sql = "SELECT FOLDER.TITLE FROM {$webtag['PREFIX']}FOLDER FOLDER WHERE FID = $fid";
   $result = db_query($sql, $db_folder_get_title);

   if (!db_num_rows($result)) {
     $foldertitle = "The Unknown Folder";
   }else {
     $data = db_fetch_array($result);
     $foldertitle = $data['TITLE'];
   }

   return $foldertitle;
}

function folder_create($title, $access, $description = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $position)
{
    $db_folder_create = db_connect();

    $title = addslashes($title);
    $description = addslashes($description);

    if (!is_numeric($access)) $access = 0;
    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;
    
    $webtag = get_webtag();

    $sql = "INSERT INTO {$webtag['PREFIX']}FOLDER (TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
    $sql.= "VALUES ('$title', $access, '$description', $allowed_types, $position)";

    $result = db_query($sql, $db_folder_create);

    if ($result) {
        $new_fid = db_insert_id($db_folder_create);
    }else {
        $new_fid = 0;
    }

    return $new_fid;
}

function folder_update($fid, $title, $access, $description = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $position)
{
    $db_folder_update = db_connect();

    $title = addslashes($title);
    $description = addslashes($description);
    
    $webtag = get_webtag();

    $sql = "UPDATE LOW_PRIORITY {$webtag['PREFIX']}FOLDER SET TITLE = '$title', ";
    $sql.= "ACCESS_LEVEL = $access, DESCRIPTION = '$description', ";
    $sql.= "ALLOWED_TYPES = $allowed_types, POSITION = $position WHERE FID = $fid";

    return db_query($sql, $db_folder_update);
}

function folder_move_threads($from, $to)
{
    $db_folder_move_threads = db_connect();

    if (!is_numeric($from)) return false;
    if (!is_numeric($to)) return false;
    
    $webtag = get_webtag();

    $sql = "UPDATE {$webtag['PREFIX']}THREAD SET FID = '$to' WHERE FID = '$from'";
    $result = db_query($sql, $db_folder_move_threads);

    return $result;
}

function folder_get_available()
{
    $uid = bh_session_get_value('UID');
    $db_folder_get_available = db_connect();
    
    $webtag = get_webtag();

    $sql = "SELECT DISTINCT F.FID FROM {$webtag['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$webtag['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = $uid) ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, COUNT(THREAD.FID) AS THREAD_COUNT ";
    $sql.= "FROM {$webtag['PREFIX']}FOLDER FOLDER LEFT JOIN {$webtag['PREFIX']}THREAD THREAD ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, COUNT(*) AS THREAD_COUNT ";
    $sql.= "FROM {$webtag['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}THREAD THREAD ON (THREAD.FID = FOLDER.FID) ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM ";
    $sql.= "USER USER, {$webtag['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}USER_FOLDER UF ON (UF.UID = USER.UID AND UF.FID = FOLDER.FID) ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT DISTINCT FID FROM {$webtag['PREFIX']}FOLDER WHERE FID = '$fid'";
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
    
    $webtag = get_webtag();

    $sql = "SELECT DISTINCT F.FID FROM {$webtag['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$webtag['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID and UF.UID = $uid) ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT FID FROM {$webtag['PREFIX']}USER_FOLDER WHERE UID = '$uid' AND FID = '$fid'";
    $result = db_query($sql, $db_user_set_folder_interest);

    if (db_num_rows($result)) {

        $sql = "UPDATE {$webtag['PREFIX']}USER_FOLDER SET INTEREST = '$interest' ";
        $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    }else {

        $sql = "INSERT INTO {$webtag['PREFIX']}USER_FOLDER (UID, FID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$fid', '$interest')";
    }

    return db_query($sql, $db_user_set_folder_interest);
}

function user_get_restricted_folders($uid)
{
    $db_user_get_restricted_folders = db_connect();

    if (!is_numeric($uid)) return false;
    
    $webtag = get_webtag();

    $sql = "SELECT F.FID, F.TITLE, UF.ALLOWED FROM {$webtag['PREFIX']}FOLDER F ";
    $sql.= "LEFT JOIN {$webtag['PREFIX']}USER_FOLDER UF ON (UF.UID = $uid AND UF.FID = F.FID) ";
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
    
    $webtag = get_webtag();

    $sql = "SELECT ALLOWED_TYPES FROM {$webtag['PREFIX']}FOLDER WHERE FID = '$fid'";
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
    
    $webtag = get_webtag();

    $sql = "SELECT DISTINCT F.FID FROM {$webtag['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$webtag['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = '$uid') ";
    $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1)) ";
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