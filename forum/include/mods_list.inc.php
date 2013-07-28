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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
// End Required includes

function mods_list_folder_mods($fid)
{
    if (!$db = db::get()) return false;

    $mod_list_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;

    $sql = "SELECT USERS.UID, USERS.LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USERS.NICKNAME) AS NICKNAME ";
    $sql.= "FROM ((SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME FROM USER INNER JOIN GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.UID = USER.UID) INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "INNER JOIN GROUPS ON (GROUPS.GID = GROUP_PERMS.GID) WHERE GROUPS.FORUM IN (0, $forum_fid) ";
    $sql.= "AND GROUP_PERMS.FID IN (0, $fid) AND GROUP_PERMS.PERM & $user_perm_folder_moderate) UNION ALL ";
    $sql.= "(SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME FROM USER INNER JOIN USER_PERM ";
    $sql.= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) AND USER_PERM.FID IN (0, $fid) ";
    $sql.= "AND USER_PERM.PERM & $user_perm_folder_moderate > 0)) AS USERS LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USERS.UID AND USER_PEER.UID = {$_SESSION['UID']})";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($mod_list_data = $result->fetch_assoc()) !== null) {
        $mod_list_array[$mod_list_data['UID']] = $mod_list_data;
    }

    return $mod_list_array;
}

function mods_list_forum_leaders()
{
    if (!$db = db::get()) return false;

    $mod_list_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;

    $sql = "SELECT USERS.UID, USERS.LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USERS.NICKNAME) AS NICKNAME ";
    $sql.= "FROM ((SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME FROM USER INNER JOIN GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.UID = USER.UID) INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "INNER JOIN GROUPS ON (GROUPS.GID = GROUP_PERMS.GID) WHERE GROUPS.FORUM IN (0, $forum_fid) ";
    $sql.= "AND GROUP_PERMS.FID IN (0) AND GROUP_PERMS.PERM & $user_perm_admin_tools) UNION ALL ";
    $sql.= "(SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME FROM USER INNER JOIN USER_PERM ";
    $sql.= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) AND USER_PERM.FID IN (0) ";
    $sql.= "AND USER_PERM.PERM & $user_perm_admin_tools > 0)) AS USERS LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USERS.UID AND USER_PEER.UID = {$_SESSION['UID']})";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($mod_list_data = $result->fetch_assoc()) !== null) {
        $mod_list_array[$mod_list_data['UID']] = $mod_list_data;
    }

    return $mod_list_array;
}