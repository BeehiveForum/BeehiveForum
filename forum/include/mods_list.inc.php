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

/* $Id: mods_list.inc.php,v 1.2 2005-04-07 11:03:57 rowan_hill Exp $ */

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
    $db_get_mods = db_connect();    
    
    if (!$table_data = get_table_prefix()) return false;
    
    $forum_fid = $table_data['FID'];
    
    $sql = "SELECT GROUP_USERS.UID, BIT_OR(GROUP_PERMS.PERM) AS STATUS, GROUP_PERMS.FID ";
    $sql.= "FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_PERMS.FID = $fid ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "GROUP BY GROUP_USERS.UID, GROUP_PERMS.FID "; 
    $sql.= "ORDER BY GROUP_PERMS.PERM DESC ";   

    $result = db_query($sql, $db_get_mods);
    
    if (db_num_rows($result) > 0) {
    
        while($row = db_fetch_array($result)) {
        
            $user_status = $row['STATUS'];

	    $modstatus = USER_PERM_FOLDER_MODERATE | USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS;
            if (($user_status & ($modstatus)) > 0) {
                $mod_uid[] = $row['UID'];
            }
        }
    }
    
    if (isset($mod_uid)) {    
        return $mod_uid;
    } else {
        return false;
    }
}

?>