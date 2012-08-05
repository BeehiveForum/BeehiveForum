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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';

function mods_list_get_mods($fid)
{
    if (!$db_mods_list_get_mods = db_connect()) return false;

    $mod_list_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM USER USER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "WHERE GROUP_PERMS.FID IN (0, $fid) AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";

    if ($fid > 0) {

        $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;
        $sql.= "AND (GROUP_PERMS.PERM & $user_perm_folder_moderate) > 0 ";

    } else {

        $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;
        $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;

        $sql.= "AND ((GROUP_PERMS.PERM & $user_perm_admin_tools) > 0 ";
        $sql.= "OR (GROUP_PERMS.PERM & $user_perm_folder_moderate) > 0) ";
    }

    if (!$result = db_query($sql, $db_mods_list_get_mods)) return false;

    if (db_num_rows($result) == 0) return false;

    while (($mod_list_data = db_fetch_array($result))) {
        $mod_list_array[$mod_list_data['UID']] = $mod_list_data;
    }

    return $mod_list_array;
}

?>