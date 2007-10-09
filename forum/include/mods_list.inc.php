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

/* $Id: mods_list.inc.php,v 1.10 2007-10-09 23:16:03 decoyduck Exp $ */

/**
* Fucntions related to generating the folder moderators lists
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");

/**
* Returns all the mods for a given folder
*
* Returns an array of the UIDs of the moderators for a given folder, or false if unsuccesful.
*
* @return mixed
* @param integer $fid Folder ID of folder to find moderators for
*/
function mods_list_get_mods($fid)
{
    if (!$db_mods_list_get_mods = db_connect()) return false;

    $mod_list_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM USER USER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "WHERE GROUP_PERMS.FID IN (0, $fid) AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";

    if ($fid > 0) {

        $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;
        $sql.= "AND (GROUP_PERMS.PERM & $user_perm_folder_moderate) > 0 ";

    }else {

        $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;
        $user_perm_forum_tools = USER_PERM_FORUM_TOOLS;
        $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;

        $sql.= "AND ((GROUP_PERMS.PERM & $user_perm_admin_tools) > 0 ";
        $sql.= "OR (GROUP_PERMS.PERM & $user_perm_forum_tools) > 0 ";
        $sql.= "OR (GROUP_PERMS.PERM & $user_perm_folder_moderate) > 0) ";
    }

    if (!$result = db_query($sql, $db_mods_list_get_mods)) return false;

    if (db_num_rows($result) > 0) {

        while ($mod_list_data = db_fetch_array($result)) {

            $mod_list_array[$mod_list_data['UID']] = $mod_list_data;
        }

        return $mod_list_array;
    }

    return false;
}

?>