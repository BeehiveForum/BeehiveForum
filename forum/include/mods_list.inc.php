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

/* $Id: mods_list.inc.php,v 1.3 2005-04-09 21:27:15 decoyduck Exp $ */

/**
* Fucntions related to generating the folder moderators lists
*/

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
    $db_mods_list_get_mods = db_connect();

    $mod_list_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $mod_status = USER_PERM_FOLDER_MODERATE | USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS;

    $sql = "SELECT GROUP_USERS.UID, USER.LOGON, USER.NICKNAME FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql.= "WHERE GROUP_PERMS.FID = $fid AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "AND GROUP_PERMS.PERM & $mod_status > 0 ";
    $sql.= "GROUP BY GROUP_USERS.UID";

    $result = db_query($sql, $db_mods_list_get_mods);

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {
            $mod_list_array[] = $row;
        }

        return $mod_list_array;
    }

    return false;
}

?>