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

/* $Id: perm.inc.php,v 1.30 2004-05-24 18:01:37 decoyduck Exp $ */

function perm_is_moderator($fid = 0)
{
    $db_perm_is_moderator = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM DEFAULT_GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN DEFAULT_GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = $uid AND GROUP_PERMS.FID = '$fid' ";
    $sql.= "ORDER BY GROUP_PERMS.PERM DESC";

    $result = db_query($sql, $db_perm_is_moderator);

    $row = db_fetch_array($result);

    return ($row['STATUS'] & USER_PERM_MODERATOR);
}

function perm_has_admin_access()
{
    $db_perm_has_admin_access = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
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
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    $result = db_query($sql, $db_perm_has_forumtools_access);

    $row = db_fetch_array($result);

    return ($row['STATUS'] & USER_PERM_FORUM_TOOLS);
}

function perm_check_folder_permissions($fid, $access_level)
{
    $db_perm_check_folder_permissions = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($access_level)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT GROUP_PERMS.PERM AS STATUS FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN ($fid) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    $result = db_query($sql, $db_perm_check_folder_permissions);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        if (!is_null($row['STATUS'])) return ($row['STATUS'] & $access_level) > 0;
    }

    $sql = "SELECT PERM AS STATUS FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_perm_check_folder_permissions);

    $row = db_fetch_array($result);
    if (!is_null($row['STATUS'])) return ($row['STATUS'] & $access_level) > 0;

    return true;
}

function perm_get_user_groups()
{
    $db_perm_get_user_groups = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT GROUPS.*, COUNT(GROUP_USERS.UID) AS USER_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}GROUPS GROUPS ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 ";
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

function perm_user_get_groups($uid)
{
    $db_perm_user_get_groups = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT GROUPS.*, COUNT(GROUP_USER_COUNT.UID) AS USER_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}GROUPS GROUPS ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USER_COUNT ";
    $sql.= "ON (GROUP_USER_COUNT.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 AND GROUP_USERS.UID = '$uid'";
    $sql.= "GROUP BY GROUPS.GID";

    $result = db_query($sql, $db_perm_user_get_groups);

    if (db_num_rows($result)) {

        $user_groups_array = array();

        while ($row = db_fetch_array($result)) {

            $user_groups_array[] = $row;
        }

        return $user_groups_array;
    }

    return false;
}

function perm_add_group($group_name, $group_desc, $perm)
{
    $db_perm_add_group = db_connect();

    if (!is_numeric($perm)) return false;

    $group_name = addslashes(_htmlentities($group_name));
    $group_desc = addslashes(_htmlentities($group_desc));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}GROUPS (GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
    $sql.= "VALUES ('$group_name', '$group_desc', 0)";

    if ($result = db_query($sql, $db_perm_add_group)) {

        $new_gid = db_insert_id($db_perm_add_group);

        if ($perm > 0) {

            $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_PERMS (GID, FID, PERM) ";
            $sql.= "VALUES ('$new_gid', '0', '$perm')";

            $result = db_query($sql, $db_perm_add_group);
        }

        return $new_gid;
    }

    return false;
}

function perm_update_group($gid, $group_name, $group_desc, $perm)
{
    $db_perm_update_group = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    $group_name = addslashes(_htmlentities($group_name));
    $group_desc = addslashes(_htmlentities($group_desc));

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "UPDATE {$table_data['PREFIX']}GROUPS SET GROUP_NAME = '$group_name', ";
        $sql.= "GROUP_DESC = '$group_desc' WHERE GID = '$gid'";

        $result = db_query($sql, $db_perm_update_group);

        $sql = "UPDATE {$table_data['PREFIX']}GROUP_PERMS SET PERM = '$perm' ";
        $sql.= "WHERE GID = '$gid' AND FID = '0'";

        return db_query($sql, $db_perm_update_group);
    }

    return false;
}

function perm_remove_group($gid)
{
    $db_perm_remove_group = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUP_USERS ";
    $sql.= "WHERE GID = '$gid'";

    $result = db_query($sql, $db_perm_remove_group);

    if (db_num_rows($result) == 0) {

        $sql = "DELETE FROM {$table_data['PREFIX']}GROUPS WHERE GID = $gid";
        return db_query($sql, $db_perm_remove_group);
    }

    return false;
}

function perm_get_group($gid)
{
    $db_perm_get_group = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUPS ";
    $sql.= "WHERE GID = '$gid' AND AUTO_GROUP = 0";

    $result = db_query($sql, $db_perm_get_group);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return $row;
    }

    return false;
}

function perm_is_group($gid)
{
    $db_perm_is_group = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUPS ";
    $sql.= "WHERE GID = '$gid' AND AUTO_GROUP = 0";

    $result = db_query($sql, $db_perm_is_group);

    return (db_num_rows($result) > 0);
}

function perm_user_in_group($uid, $gid)
{
    $db_perm_user_in_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}GROUP_USERS ";
    $sql.= "WHERE UID = '$uid' AND GID = '$gid'";

    $result = db_query($sql, $db_perm_user_in_group);

    return (db_num_rows($result) > 0);
}

function perm_get_group_permissions($gid)
{
    $db_perm_get_group_permissions = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "SELECT PERM FROM {$table_data['PREFIX']}GROUP_PERMS WHERE GID = $gid AND FID = 0";
        $result = db_query($sql, $db_perm_get_group_permissions);

        if (db_num_rows($result) > 0) {

            $row = db_fetch_array($result);
            return $row['PERM'];
        }

        return 0;
    }

    return false;
}

function perm_get_group_folder_perms($gid, $fid)
{
    $db_perm_get_group_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "SELECT GID, BIT_OR(PERM) FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
        $sql.= "WHERE GID = '$gid' AND FID = '$fid'";

        $result = db_query($sql, $db_perm_get_group_folder_perms);

        if (db_num_rows($result) > 0) {

            $row = db_fetch_array($result);
            if (!is_null($row['PERM'])) return array('GID' => $row['GID'], 'STATUS' => $row['PERM']);
        }

        $sql = "SELECT PERM FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
        $result = db_query($sql, $db_perm_get_group_folder_perms);

        if (db_num_rows($result) > 0) {

            $row = db_fetch_array($result);
            if (!is_null($row['PERM'])) return array('STATUS' => $row['PERM']);
        }
    }

    return array('STATUS' => 0);
}

function perm_add_user_to_group($uid, $gid)
{
    $db_perm_add_user_to_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

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

     if (perm_is_group($gid)) {

        $sql = "DELETE FROM {$table_data['PREFIX']}GROUP_USERS GID = '$gid' AND UID = '$uid'";
        return db_query($sql, $db_perm_remove_user_from_group);
    }

    return false;
}

function perm_get_user_permissions($uid)
{
    $db_perm_get_user_permissions = db_connect();

    if (!is_numeric($uid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT GROUP_PERMS.GID, BIT_OR(GROUP_PERMS.PERM) AS STATUS ";
    $sql.= "FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON ";
    $sql.= "(GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "GROUP BY GROUP_PERMS.GID";

    $result = db_query($sql, $db_perm_get_user_permissions);

    if (db_num_rows($result) > 0) {

        return db_fetch_array($result);
    }

    return array('GID' => false, 'STATUS' => 0);
}

function perm_get_user_folder_perms($uid, $fid)
{
    $db_perm_get_user_folder_perms = db_connect();

    if (!is_numeric($uid)) return 0;
    if (!is_numeric($fid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT GROUP_PERMS.GID, GROUP_PERMS.PERM ";
    $sql.= "FROM {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
    $sql.= "JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ON ";
    $sql.= "(GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_PERMS.FID = '$fid' AND GROUP_USERS.UID = '$uid'";

    $result = db_query($sql, $db_perm_get_user_folder_perms);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        if (!is_null($row['PERM'])) return array('GID' => $row['GID'], 'STATUS' => $row['PERM']);
    }

    $sql = "SELECT PERM FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_perm_get_user_folder_perms);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        if (!is_null($row['PERM'])) return array('STATUS' => $row['PERM']);
    }

    return array('STATUS' => 0);
}

function perm_add_user_folder_perms($uid, $gid, $fid, $perm)
{
    $db_perm_add_user_folder_perms = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!perm_is_group($gid) && perm_user_in_group($uid, $gid)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$fid', '$perm')";

        return db_query($sql, $db_perm_add_user_folder_perms);
    }

    return false;
}

function perm_update_user_folder_perms($uid, $gid, $fid, $perm)
{
    $db_perm_update_user_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!perm_is_group($gid) && perm_user_in_group($uid, $gid)) {

        $sql = "UPDATE {$table_data['PREFIX']}GROUP_PERMS ";
        $sql.= "SET PERM = '$perm' WHERE GID = '$gid' AND FID = '$fid'";

        return db_query($sql, $db_perm_update_user_folder_perms);
    }

    return false;
}

function perm_add_group_folder_perms($gid, $fid, $perm)
{
    $db_perm_add_group_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$fid', '$perm')";

        return db_query($sql, $db_perm_add_group_folder_perms);
    }

    return false;
}

function perm_update_group_folder_perms($gid, $fid, $perm)
{
    $db_perm_update_group_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "UPDATE {$table_data['PREFIX']}GROUP_PERMS ";
        $sql.= "SET PERM = '$perm' WHERE GID = '$gid' AND FID = '$fid'";

        return db_query($sql, $db_perm_update_group_folder_perms);
    }

    return false;
}

function perm_add_user_permissions($uid, $perm)
{
    $db_perm_add_user_permissions = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}GROUPS (AUTO_GROUP) VALUES (1)";

    if ($result = db_query($sql, $db_perm_add_user_permissions)) {

        $new_gid = db_insert_id($db_perm_add_user_permissions);

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "VALUES ('$new_gid', '0', '$perm')";

        $result = db_query($sql, $db_perm_add_user_permissions);

        $sql = "INSERT INTO {$table_data['PREFIX']}GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$new_gid', '$uid')";

        return db_query($sql, $db_perm_add_user_permissions);
    }

    return false;
}

function perm_update_user_permissions($uid, $gid, $perm)
{
    $db_perm_update_user_permissions = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!perm_is_group($gid) && perm_user_in_group($uid, $gid)) {

        $sql = "UPDATE {$table_data['PREFIX']}GROUP_PERMS ";
        $sql.= "SET PERM = '$perm' WHERE GID = '$gid' AND FID = '0'";

        return db_query($sql, $db_perm_update_user_permissions);
    }

    return false;
}

function perm_folder_get_permissions($fid)
{
    $db_perm_folder_get_permissions = db_connect();

    if (!is_numeric($fid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT PERM AS STATUS FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_perm_folder_get_permissions);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (!is_null($row['STATUS'])) return $row['STATUS'];
    }

    return false;
}

function perm_group_get_users($gid, $offset = 0)
{
    $db_perm_group_get_users = db_connect();

    if (!is_numeric($gid)) return 0;
    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return array('user_count' => 0,
                                                        'user_array' => array());;

    if (perm_is_group($gid)) {

        $group_user_array = array();
        $group_user_count = 0;

        $sql = "SELECT * FROM {$table_data['PREFIX']}GROUP_USERS ";
        $sql.= "WHERE GID = '$gid'";

        $result = db_query($sql, $db_perm_group_get_users);
        $group_user_count = db_num_rows($result);

        $sql = "SELECT GROUP_USERS.UID, USER.LOGON, USER.NICKNAME ";
        $sql.= "FROM {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = GROUP_USERS.UID) ";
        $sql.= "WHERE GROUP_USERS.GID = '$gid' ";
        $sql.= "LIMIT $offset, 20";

        $result = db_query($sql, $db_perm_group_get_users);

        if (db_num_rows($result) > 0) {
            while ($row = db_fetch_array($result)) {
                $group_user_array[] = $row;
	    }
        }

        return array('user_count' => $group_user_count,
                     'user_array' => $group_user_array);
    }

    return false;
}

?>