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

/* $Id: folder.inc.php,v 1.31 2003-07-27 12:42:04 hodcroftcj Exp $ */

require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/form.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/format.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="", $allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $ustatus = bh_session_get_value('STATUS');
    $uid = bh_session_get_value('UID');

    if ($ustatus & PERM_CHECK_WORKER) {
        $sql = "select FID, TITLE from ".forum_table("FOLDER")." WHERE ";
        $sql.= "ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL";
    } else {
        $sql = "select DISTINCT F.FID, F.TITLE from ".forum_table("FOLDER")." F left join ";
        $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = '$uid') ";
        $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1)) ";
        $sql.= "AND (F.ALLOWED_TYPES & $allowed_types > 0 OR ALLOWED_TYPES IS NULL)";
    }

    return form_dropdown_sql($field_name.$suffix, $sql, $default_fid);
}

function folder_get_title($fid)
{
   $db_folder_get_title = db_connect();
   $sql = "select FOLDER.TITLE from " . forum_table("FOLDER") . " FOLDER where FID = $fid";
   $resource_id = db_query($sql, $db_folder_get_title);
   if(!db_num_rows($resource_id)){
     $foldertitle = "The Unknown Folder";
   } else {
     $data = db_fetch_array($resource_id);
     $foldertitle = $data['TITLE'];
   }
   return $foldertitle;
}

function folder_create($title,$access,$description = "",$allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $db_folder_create = db_connect();

    $sql = "insert into " . forum_table("FOLDER") . " (TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES) ";
    $sql.= "values (\"$title\",$access,\"$description\",$allowed_types)";

    $result = db_query($sql, $db_folder_create);

    if ($result) {
        $new_fid = db_insert_id($db_folder_create);
    }else {
        $new_fid = 0;
    }

    return $new_fid;
}

function folder_update($fid,$title,$access,$description = "",$allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $db_folder_update = db_connect();
    $sql = "update low_priority " . forum_table("FOLDER") . " ";
    $sql.= "set TITLE = \"$title\", ";
    $sql.= "ACCESS_LEVEL = $access, ";
    $sql.= "DESCRIPTION = \"$description\", ";
    $sql.= "ALLOWED_TYPES = $allowed_types ";
    $sql.= "where FID = $fid";
    $result = db_query($sql, $db_folder_update);
    return $result;
}

function folder_move_threads($from,$to)
{
    $db_folder_move_threads = db_connect();
    $sql = "update " . forum_table("THREAD") . " ";
    $sql.= "set FID = $to ";
    $sql.= "where FID = $from";
    $result = db_query($sql, $db_folder_move_threads);
    return $result;
}

function folder_get_available()
{
    $uid = bh_session_get_value('UID');
    $db_folder_get_available = db_connect();

    $sql = "select DISTINCT F.FID from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";

    $result = db_query($sql, $db_folder_get_available);
    $count = db_num_rows($result);

    if ($count==0) {
        $return = "0";
    } else {
        $row = db_fetch_array($result);
        $return = $row['FID'];

        while($row = db_fetch_array($result)){
            $return .= ",".$row['FID'];
        }
    }

    return $return;
}

function folder_get_all()
{

    $return = array();

    $db_folder_get_all = db_connect();

    $sql = "select FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, FOLDER.DESCRIPTION, FOLDER.ALLOWED_TYPES, count(*) as THREAD_COUNT ";
    $sql.= "from " . forum_table("FOLDER") . " FOLDER LEFT JOIN " . forum_table("THREAD") . " THREAD ";
    $sql.= " on (THREAD.FID = FOLDER.FID) ";
    $sql.= "group by FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL";

    $result = db_query($sql, $db_folder_get_all);

    while ($row = db_fetch_array($result)) {
      $return[] = $row;
    }

    return $return;

}

function folder_get($fid)
{
    $db_folder_get = db_connect();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, COUNT(*) AS THREAD_COUNT ";
    $sql.= "FROM ". forum_table("FOLDER"). " FOLDER ";
    $sql.= "LEFT JOIN " . forum_table("THREAD") . " THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "WHERE FOLDER.FID = $fid GROUP BY FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL";

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

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM ";
    $sql.= forum_table("USER"). " USER, ". forum_table("FOLDER"). " FOLDER ";
    $sql.= "LEFT JOIN ". forum_table("USER_FOLDER"). " UF ON (UF.UID = USER.UID AND UF.FID = FOLDER.FID) ";
    $sql.= "WHERE FOLDER.FID = $fid AND UF.ALLOWED = 1";

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



// Checks that a $fid is a valid folder and is accessible by the user.

function folder_is_valid($fid)
{
    $uid = bh_session_get_value('UID');
    $db_folder_get_available = db_connect();

    $sql = "select DISTINCT F.FID from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1)) ";
    $sql.= "and F.FID = $fid";

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

    $sql = "delete from ". forum_table("USER_FOLDER"). " where UID = '$uid' and FID = '$fid'";
    $result = db_query($sql, $db_user_set_folder_interest);

    if ($interest == -1) {
        $sql = "insert into ". forum_table("USER_FOLDER"). " (UID, FID, INTEREST) ";
        $sql.= "values ($uid, $fid, $interest)";
        $result = db_query($sql, $db_user_set_folder_interest);
    }

}

function folder_thread_type_allowed($fid, $type) // for types see constants.inc.php
{
    $db_folder_thread_type_allowed = db_connect();

    $sql = "SELECT ALLOWED_TYPES FROM ".forum_table("FOLDER")." WHERE FID = $fid";
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

    $sql = "select DISTINCT F.FID from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = '$uid') ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1)) ";
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