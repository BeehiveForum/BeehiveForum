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

/* $Id: perm.inc.php,v 1.19 2004-05-19 00:27:28 decoyduck Exp $ */

function perm_is_moderator($fid = 0)
{
    $db_perm_is_moderator = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM DEFAULT_GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN DEFAULT_GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID OR GROUP_PERMS.GID = 0) ";
    $sql.= "WHERE GROUP_USERS.UID = $uid AND GROUP_PERMS.FID IN (0, $fid) ";
    $sql.= "ORDER BY GROUP_PERMS.PERM DESC";

    $result = db_query($sql, $db_perm_is_moderator);

    $row = db_fetch_array($result);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return ($row['STATUS'] & USER_PERM_MODERATOR);
    }

    return false;
}

function perm_has_admin_access()
{
    $db_perm_has_admin_access = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID OR GROUP_PERMS.GID = 0) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    $result = db_query($sql, $db_perm_has_admin_access);

    $row = db_fetch_array($result);

    return ($row['STATUS'] & USER_PERM_ADMIN_TOOLS);
}

function perm_has_forumtools_access()
{
    $db_perm_has_forumtools_access = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID OR GROUP_PERMS.GID = 0) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    $result = db_query($sql, $db_perm_has_forumtools_access);

    $row = db_fetch_array($result);

    return ($row['STATUS'] & USER_PERM_FORUM_TOOLS);
}

function perm_check_folder_permissions($fid, $access_level)
{
    $db_perm_get_status = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($access_level)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID OR GROUP_PERMS.GID = 0) ";
    $sql.= "WHERE GROUP_USERS.UID = $uid AND GROUP_PERMS.FID IN (0, $fid) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    $result = db_query($sql, $db_perm_get_status);

    $row = db_fetch_array($result);

    return ($row['STATUS'] & $access_level);
}

function perm_get_user_groups()
{
    $db_perm_get_user_groups = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT GROUPS.GROUP_NAME, COUNT(GROUP_USERS.UID) AS USER_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}GROUPS GROUPS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
    $sql.= "ON GROUP_USERS.GID = GROUPS.GID ";
    $sql.= "GROUP BY GROUPS.GID";

    $result = db_query($sql, $db_perm_get_user_groups);

    if (db_num_rows($result)) {

        $user_groups_array = array();

        while ($row = db_fetch_array($result)) {

            $user_groups_array[] = $row;
        }

        return $user_groups_array;
    }

    return false;
}

function perm_add_group($group_name, $fid, $perm)
{
    $db_perm_add_group = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_PERMS (FID, PERM) ";
    $sql.= "VALUES ('$fid', '$perm')";

    if ($result = db_query($sql, $db_perm_add_group)) {

        $new_gid = db_insert_id($db_perm_add_group);

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUPS (GID, GROUP_NAME) ";
        $sql.= "VALUES ('$new_gid', '$group_name')";

        if ($result = db_query($sql, $db_perm_add_group)) {

            return $new_gid;
        }
    }

    return false;
}

function perm_remove_group($gid)
{
    $db_perm_remove_group = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUP_USERS WHERE GID = $gid";
    $result = db_query($sql, $db_perm_remove_group);

    if (db_num_rows($result) == 0) {

        $sql = "DELETE FROM {$table_data['PREFIX']}GROUPS WHERE GID = $gid";
        return db_query($sql, $db_perm_remove_group);
    }

    return false;
}

function perm_add_user_to_group($uid, $gid)
{
    $db_perm_add_user_to_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUPS WHERE GID = '$gid'";
    $result = db_query($sql, $db_perm_add_user_to_group);

    if (db_num_rows($result) > 0) {

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$gid', '$uid')";

        return db_query($sql, $db_perm_add_user_to_group);
    }

    return false;
}

function perm_remove_user_from_group($uid, $gid)
{
    $db_perm_remove_user_from_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUPS WHERE GID = '$gid'";
    $result = db_query($sql, $db_perm_remove_user_from_group);

    if (db_num_rows($result) > 0) {

        $sql = "DELETE FROM {$table_data['PREFIX']}GROUP_USERS GID = '$gid'";
        return db_query($sql, $db_perm_remove_user_from_group);
    }

    return false;
}

function perm_user_add_perms($uid, $fid, $perm)
{
    $db_perm_add_perms = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_PERMS (FID, PERM) ";
    $sql.= "VALUES ('$fid', '$perm')";

    if ($result = db_query($sql, $db_perm_add_perms)) {

        $new_gid = db_insert_id($db_perm_add_perms);

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$new_gid', '$uid')";

        if ($result = db_query($sql, $db_perm_add_perms)) {

            return $new_gid;
        }
    }

    return false;
}

function perm_user_remove_perms($uid, $gid)
{
    $db_perm_user_remove_perms = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUPS WHERE GID = '$gid'";
    $result = db_query($sql, $db_perm_user_remove_perms);

    if (db_num_rows($result) == 0) {

        $sql = "DELETE FROM {$table_data['PREFIX']}GROUP_USERS WHERE UID = '$uid' AND GID = '$gid'";
        $result = db_query($sql, $db_perm_user_remove_perms);

        $sql = "DELETE FROM {$table_data['PREFIX']}GROUP_PERMS WHERE GID = '$gid'";
        $result = db_query($sql, $db_perm_user_remove_perms);
    }

    return $result;
}

function perm_update_perms($gid, $perm)
{
    $db_perm_update_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}GROUP_PERMS ";
    $sql.= "SET PERM = $perm WHERE GID = $gid";

    return db_query($sql, $db_perm_update_perms);
}

?>