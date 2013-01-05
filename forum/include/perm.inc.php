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
// End Required includes

function perm_is_moderator($uid, $folder_fid = 0)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($folder_fid)) return false;

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    if ($folder_fid > 0) {

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0, $folder_fid) ";
        $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "ORDER BY GROUP_PERMS.PERM DESC";

    } else {

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "ORDER BY GROUP_PERMS.PERM DESC";
    }

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_FOLDER_MODERATE) > 0;
}

function perm_has_admin_access($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_global_admin_access($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_forumtools_access($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_FORUM_TOOLS) > 0;
}

function perm_is_links_moderator($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_LINKS_MODERATE) > 0;
}

function perm_check_folder_permissions($fid, $access_level, $uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_numeric($access_level)) return false;
    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, USER_DATA.PERM AS USER_PERMS, ";
    $sql.= "COALESCE(USER_DATA.PERM_COUNT, 0) AS USER_PERM_COUNT, FOLDER.PERM AS FOLDER_PERMS, ";
    $sql.= "IF (FOLDER.PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql.= "LEFT JOIN (SELECT GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM, ";
    $sql.= "COUNT(GROUP_PERMS.PERM) AS PERM_COUNT FROM GROUP_USERS  INNER JOIN GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.GID = GROUP_USERS.GID) WHERE GROUP_PERMS.FORUM = '$forum_fid' ";
    $sql.= "AND GROUP_USERS.UID = '$uid' GROUP BY GROUP_PERMS.FID) AS USER_DATA ";
    $sql.= "ON (USER_DATA.FID = FOLDER.FID) WHERE FOLDER.FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    $permissions_data = $result->fetch_assoc();

    if ($permissions_data['USER_PERM_COUNT'] > 0) {

        $user_status = $permissions_data['USER_PERMS'];

    } else if ($permissions_data['FOLDER_PERM_COUNT'] > 0) {

        $user_status = $permissions_data['FOLDER_PERMS'];
    }

    return ($user_status & $access_level) == $access_level;
}

function perm_check_global_permissions($access_level, $uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($access_level)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS USER_PERM FROM GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS USING (GID) WHERE GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND GROUP_USERS.UID = '$uid' ";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & $access_level) == $access_level;
}

function perm_get_user_groups($page = 1, $sort_by = 'GROUP_NAME', $sort_dir = 'ASC')
{
    if (!$db = db::get()) return false;

    $sort_by_array  = array(
        'GROUPS.GROUP_NAME',
        'GROUPS.GROUP_DESC',
        'GROUP_PERMS',
        'USER_COUNT'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'GROUPS.GROUP_NAME';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_groups_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS GROUPS.GID, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC, ";
    $sql.= "COUNT(DISTINCT GROUP_USERS.UID) AS USER_COUNT, BIT_OR(GROUP_PERMS.PERM) AS GROUP_PERMS ";
    $sql.= "FROM GROUPS INNER JOIN GROUP_PERMS USING (GID) LEFT JOIN GROUP_USERS USING (GID) ";
    $sql.= "WHERE GROUP_PERMS.FORUM = '$forum_fid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "GROUP BY GROUP_PERMS.GID LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_groups_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($user_groups_count > 0) && ($page > 1)) {
        return perm_get_user_groups($page - 1, $sort_by, $sort_dir);
    }

    while (($permissions_data = $result->fetch_assoc()) !== null) {
        $user_groups_array[] = $permissions_data;
    }

    return array(
        'user_groups_array' => $user_groups_array,
        'user_groups_count' => $user_groups_count
    );
}

function perm_user_get_groups($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME, COUNT(DISTINCT GROUP_USER_COUNT.UID) AS USER_COUNT ";
    $sql.= "FROM GROUP_PERMS INNER JOIN GROUPS USING (GID) INNER JOIN GROUP_USERS GROUP_USER_COUNT USING (GID) ";
    $sql.= "INNER JOIN GROUP_USERS USING (GID) WHERE GROUP_PERMS.FORUM = '$forum_fid' AND GROUP_USERS.UID = '$uid' ";
    $sql.= "GROUP BY GROUP_PERMS.GID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_groups_array = array();

    while (($permissions_data = $result->fetch_assoc()) !== null) {
        $user_groups_array[] = $permissions_data;
    }

    return $user_groups_array;
}

function perm_user_get_group_names($uid, &$user_groups_array)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!is_array($user_groups_array)) $user_groups_array = array();

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME FROM GROUPS ";
    $sql.= "INNER JOIN GROUP_PERMS USING (GID) INNER JOIN GROUP_USERS USING (GID) ";
    $sql.= "INNER JOIN USER USING (UID) WHERE GROUP_PERMS.FORUM = $forum_fid ";
    $sql.= "AND GROUP_USERS.UID = '$uid' GROUP BY GROUPS.GID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        while (($perm_data = $result->fetch_assoc()) !== null) {
            $user_groups_array[$perm_data['GID']] = $perm_data['GROUP_NAME'];
        }
    }

    if (perm_has_admin_access($uid)) $user_groups_array[] = gettext("Forum Leader");
    if (perm_is_moderator($uid)) $user_groups_array[] = gettext("Folder Moderator");

    return sizeof($user_groups_array) > 0;
}

function perm_add_group($group_name, $group_desc, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($perm)) return false;

    $group_name = $db->escape($group_name);
    $group_desc = $db->escape($group_desc);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM) ";
    $sql.= "VALUES ('$forum_fid', '0', '$perm')";

    if ($db->query($sql)) {

        $new_gid = $db->insert_id;

        $sql = "INSERT INTO GROUPS (GID, GROUP_NAME, GROUP_DESC) ";
        $sql.= "VALUES ('$new_gid', '$group_name', '$group_desc')";

        if (!$db->query($sql)) return false;

        return $new_gid;
    }

    return false;
}

function perm_update_group($gid, $group_name, $group_desc, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    $group_name = $db->escape($group_name);
    $group_desc = $db->escape($group_desc);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (perm_is_group($gid)) {

        $sql = "UPDATE LOW_PRIORITY GROUPS SET GROUP_NAME = '$group_name', ";
        $sql.= "GROUP_DESC = '$group_desc' WHERE GID = '$gid'";

        if (!$db->query($sql)) return false;

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', 0, '$perm') ON DUPLICATE KEY ";
        $sql.= "UPDATE PERM = VALUES(PERM)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function perm_remove_group($gid)
{
    if (!is_numeric($gid)) return false;

    if (!$db = db::get()) return false;

    if (perm_is_group($gid)) {

        $sql = "DELETE QUICK FROM GROUP_PERMS WHERE GID = '$gid'";

        if (!$db->query($sql)) return false;

        $sql = "DELETE QUICK FROM GROUP_USERS WHERE GID = '$gid'";

        if (!$db->query($sql)) return false;

        $sql = "DELETE QUICK FROM GROUPS WHERE GID = '$gid'";

        if (!$db->query($sql)) return false;

        return ($db->affected_rows > 0);
    }

    return false;
}

function perm_get_group($gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC ";
    $sql.= "FROM GROUPS INNER JOIN GROUP_PERMS USING (GID) ";
    $sql.= "WHERE GROUPS.GID = '$gid' AND GROUP_PERMS.FORUM = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $permissions_data = $result->fetch_assoc();

    return $permissions_data;
}

function perm_get_group_name($gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;

    $sql = "SELECT GROUP_NAME FROM GROUPS WHERE GID = '$gid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($group_name) = $result->fetch_row();

    return $group_name;
}

function perm_is_group($gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;

    $sql = "SELECT COUNT(GID) FROM GROUPS WHERE GID = '$gid'";

    if (!($result = $db->query($sql))) return false;

    list($group_count) = $result->fetch_row();

    return ($group_count > 0);
}

function perm_user_in_group($uid, $gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    $sql = "SELECT COUNT(GROUP_USERS.UID) FROM GROUP_PERMS INNER JOIN GROUP_USERS ";
    $sql.= "USING (GID) WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.GID = '$gid'";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return ($user_count > 0);
}

function perm_get_global_user_permissions($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return 0;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS USER_PERM FROM GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS USING (GID) INNER JOIN USER USING (UID) ";
    $sql.= "WHERE GROUP_PERMS.FID = 0 AND GROUP_PERMS.FORUM = 0 ";
    $sql.= "AND GROUP_USERS.UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    list($global_user_perm) = $result->fetch_row();

    return $global_user_perm;
}

function perm_get_admin_tools_perm_count()
{
    if (!$db = db::get()) return false;

    $upat = USER_PERM_ADMIN_TOOLS;

    $sql = "SELECT COUNT(GROUP_PERMS.GID) AS PERM_COUNT FROM GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS USING (GID) INNER JOIN USER USING (UID) ";
    $sql.= "WHERE GROUP_PERMS.FID = 0 AND GROUP_PERMS.FORUM = 0 ";
    $sql.= "AND (GROUP_PERMS.PERM & $upat > 0)";

    if (!($result = $db->query($sql))) return false;

    list($global_perm_count) = $result->fetch_row();

    return $global_perm_count;
}

function perm_get_forum_tools_perm_count()
{
    if (!$db = db::get()) return false;

    $upft = USER_PERM_FORUM_TOOLS;

    $sql = "SELECT COUNT(GROUP_PERMS.GID) AS PERM_COUNT FROM GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS USING (GID) INNER JOIN USER USING (UID) ";
    $sql.= "WHERE GROUP_PERMS.FID = 0 AND GROUP_PERMS.FORUM = 0 ";
    $sql.= "AND (GROUP_PERMS.PERM & $upft > 0)";

    if (!($result = $db->query($sql))) return false;

    list($global_perm_count) = $result->fetch_row();

    return $global_perm_count;
}

function perm_update_global_perms($uid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (($gid = perm_get_user_gid($uid)) !== false) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '0', '0', '$perm') ON DUPLICATE KEY ";
        $sql.= "UPDATE PERM = VALUES(PERM)";

        if (!$db->query($sql)) return false;

        return true;

    } else {

        $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM) ";
        $sql.= "VALUES ('0', '0', '$perm')";

        if ($db->query($sql)) {

            $new_gid = $db->insert_id;

            return perm_add_user_to_group($uid, $new_gid);
        }
    }

    return false;
}

function perm_get_group_permissions($gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT GROUP_PERMS.PERM FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql.= "USING (GID) WHERE GROUPS.GID = '$gid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($group_perms) = $result->fetch_row();

    return $group_perms;
}

function perm_group_get_folders($gid)
{
    if (!$db = db::get()) return false;

    $folders_array = array();

    if (!is_numeric($gid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!perm_is_group($gid)) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, GROUP_DATA.PERM AS GROUP_PERMS, ";
    $sql.= "GROUP_DATA.PERM_COUNT AS GROUP_PERM_COUNT, FOLDER.PERM AS FOLDER_PERMS, ";
    $sql.= "IF (FOLDER.PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM `{$table_prefix}FOLDER` FOLDER LEFT JOIN (SELECT GROUP_PERMS.FID, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM, COUNT(GROUP_PERMS.PERM) AS PERM_COUNT ";
    $sql.= "FROM GROUPS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.GID = '$gid' AND GROUP_PERMS.FORUM = '$forum_fid' ";
    $sql.= "GROUP BY GROUP_PERMS.FID) AS GROUP_DATA ON (GROUP_DATA.FID = FOLDER.FID) ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($permissions_data = $result->fetch_assoc()) !== null) {

        if ($permissions_data['GROUP_PERM_COUNT'] > 0) {

            $folders_array[$permissions_data['FID']] = array(
                'FID' => $permissions_data['FID'],
                'TITLE' => $permissions_data['TITLE'],
                'STATUS' => $permissions_data['GROUP_PERMS'],
                'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']
            );

        } else if ($permissions_data['FOLDER_PERM_COUNT'] > 0) {

            $folders_array[$permissions_data['FID']] = array(
                'FID' => $permissions_data['FID'],
                'TITLE' => $permissions_data['TITLE'],
                'STATUS' => $permissions_data['FOLDER_PERMS'],
                'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']
            );

        } else {

            $folders_array[$permissions_data['FID']] = array(
                'FID' => $permissions_data['FID'],
                'TITLE' => $permissions_data['TITLE'],
                'STATUS' => 0,
                'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']
            );
        }
    }

    return $folders_array;
}

function perm_add_user_to_group($uid, $gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    $sql = "INSERT IGNORE INTO GROUP_USERS (GID, UID) VALUES ('$gid', '$uid')";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_remove_user_from_group($uid, $gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (perm_is_group($gid)) {

        $sql = "DELETE QUICK FROM GROUP_USERS WHERE GID = '$gid' AND UID = '$uid'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function perm_get_user_permissions($uid)
{
    static $user_perm_cache = array();

    if (!is_numeric($uid)) return 0;

    if (array_key_exists($uid, $user_perm_cache)) {
        return $user_perm_cache[$uid];
    }

    if (!$db = db::get()) return false;

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($user_perm_cache[$uid]) = $result->fetch_row();

    return $user_perm_cache[$uid];
}

function perm_get_forum_user_permissions($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return 0;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS ";
    $sql.= "INNER JOIN GROUP_USERS GROUP_USERS USING (GID) ";
    $sql.= "WHERE GROUP_PERMS.FORUM = '$forum_fid' ";
    $sql.= "AND GROUP_USERS.UID = '$uid' ";
    $sql.= "AND GROUP_PERMS.FID = 0";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $permissions_data = $result->fetch_assoc();

    return $permissions_data['STATUS'];
}

function perm_get_user_gid($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT GROUP_PERMS.GID FROM GROUP_PERMS INNER JOIN GROUP_USERS USING (GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.GID NOT IN (SELECT GID FROM GROUPS) ";
    $sql.= "GROUP BY GROUP_PERMS.GID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_gids_array = array();

    while ((list($user_gid) = $result->fetch_row()) !== null) {
        $user_gids_array[] = $user_gid;
    }

    $user_gid = array_shift($user_gids_array);

    if (sizeof($user_gids_array) > 0) {

        $user_gids_list = implode(', ', $user_gids_array);

        $sql = "INSERT IGNORE INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "SELECT $user_gid, FORUM, FID, PERM FROM GROUP_PERMS ";
        $sql.= "WHERE GID IN ($user_gids_list)";

        if (!($result = $db->query($sql))) return false;

        $sql = "DELETE QUICK FROM GROUP_PERMS, GROUP_USERS USING GROUP_PERMS ";
        $sql.= "INNER JOIN GROUP_USERS USING (GID) WHERE GROUP_PERMS.GID IN ($user_gids_list)";

        if (!($result = $db->query($sql))) return false;
    }

    return $user_gid;
}

function perm_user_get_folders($uid)
{
    if (!$db = db::get()) return false;

    $folders_array = array();

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, USER_DATA.PERM AS USER_PERMS, ";
    $sql.= "USER_DATA.PERM_COUNT AS USER_PERM_COUNT, FOLDER.PERM AS FOLDER_PERMS, ";
    $sql.= "IF (FOLDER.PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM `{$table_prefix}FOLDER` FOLDER LEFT JOIN (SELECT GROUP_PERMS.FID, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM, COUNT(GROUP_PERMS.PERM) AS PERM_COUNT ";
    $sql.= "FROM GROUP_USERS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "WHERE GROUP_PERMS.FORUM = '$forum_fid' AND GROUP_USERS.UID = '$uid' ";
    $sql.= "AND GROUP_PERMS.GID NOT IN (SELECT GID FROM GROUPS) ";
    $sql.= "GROUP BY GROUP_PERMS.FID) AS USER_DATA ON (USER_DATA.FID = FOLDER.FID) ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($permissions_data = $result->fetch_assoc()) !== null) {

        if ($permissions_data['USER_PERM_COUNT'] > 0) {

            $folders_array[$permissions_data['FID']] = array(
                'FID' => $permissions_data['FID'],
                'TITLE' => $permissions_data['TITLE'],
                'STATUS' => $permissions_data['USER_PERMS'],
                'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']
            );

        } else if ($permissions_data['FOLDER_PERM_COUNT'] > 0) {

            $folders_array[$permissions_data['FID']] = array(
                'FID' => $permissions_data['FID'],
                'TITLE' => $permissions_data['TITLE'],
                'STATUS' => $permissions_data['FOLDER_PERMS'],
                'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']
            );

        } else {

            $folders_array[$permissions_data['FID']] = array(
                'FID' => $permissions_data['FID'],
                'TITLE' => $permissions_data['TITLE'],
                'STATUS' => 0,
                'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']
            );
        }
    }

    return $folders_array;
}

function perm_update_user_folder_perms($uid, $fid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (($gid = perm_get_user_gid($uid)) !== false) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '$fid', '$perm') ";
        $sql.= "ON DUPLICATE KEY UPDATE PERM = VALUES(PERM) ";

        if (!$db->query($sql)) return false;

    } else {

        $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM) ";
        $sql.= "VALUES ('$forum_fid', '$fid', '$perm')";

        if ($db->query($sql)) {

            $new_gid = $db->insert_id;

            return perm_add_user_to_group($uid, $new_gid);
        }
    }

    return true;
}

function perm_update_group_folder_perms($gid, $fid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (perm_is_group($gid)) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '$fid', '$perm') ";
        $sql.= "ON DUPLICATE KEY UPDATE PERM = VALUES(PERM)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function perm_update_user_permissions($uid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (($gid = perm_get_user_gid($uid)) !== false) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '0', '$perm') ";
        $sql.= "ON DUPLICATE KEY UPDATE PERM = VALUES(PERM)";

        if (!$db->query($sql)) return false;

        return $gid;

    } else {

        $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM) ";
        $sql.= "VALUES ('$forum_fid', '0', '$perm')";

        if ($db->query($sql)) {

            $new_gid = $db->insert_id;

            return perm_add_user_to_group($uid, $new_gid);
        }
    }

    return false;
}

function perm_update_user_forum_permissions($forum_fid, $uid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($forum_fid)) return false;
    if (!is_numeric($uid)) return false;

    if (($gid = perm_get_user_gid($uid)) !== false) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '0', '$perm') ";
        $sql.= "ON DUPLICATE KEY UPDATE PERM = PERM | VALUES(PERM)";

        if (!$db->query($sql)) return false;

        return true;

    } else {

        $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM) ";
        $sql.= "VALUES ('$forum_fid', '0', '$perm')";

        if ($db->query($sql)) {

            $new_gid = $db->insert_id;
            return perm_add_user_to_group($uid, $new_gid);
        }
    }

    return false;
}

function perm_folder_get_permissions($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return 0;

    if (!($table_prefix = get_table_prefix())) return 0;

    $sql = "SELECT PERM FROM `{$table_prefix}FOLDER` FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $permissions_data = $result->fetch_assoc();

    if (!is_null($permissions_data['PERM'])) return $permissions_data['PERM'];
}

function perm_folder_reset_user_permissions($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $folder_perms = perm_folder_get_permissions($fid);

    $upfm = USER_PERM_FOLDER_MODERATE;

    $remove_perms = (double) USER_PERM_BANNED | USER_PERM_WORMED;
    $remove_perms = (double) $remove_perms | USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS;
    $remove_perms = (double) $remove_perms | USER_PERM_LINKS_MODERATE | USER_PERM_EMAIL_CONFIRM;
    $remove_perms = (double) $remove_perms | USER_PERM_CAN_IGNORE_ADMIN | USER_PERM_PILLORIED;

    $folder_perms = $folder_perms ^ $remove_perms;

    $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$folder_perms' | (PERM & $upfm) ";
    $sql.= "WHERE FID = '$fid' AND GID <> '0' AND FORUM = '$forum_fid'";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_group_get_users($gid, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return 0;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 20);

    if (!perm_is_group($gid)) return false;

    $group_user_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS GROUP_USERS.UID, ";
    $sql.= "USER.LOGON, USER.NICKNAME FROM GROUP_USERS ";
    $sql.= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "INNER JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql.= "WHERE GROUP_USERS.GID = '$gid' GROUP BY GROUP_USERS.UID ";
    $sql.= "LIMIT $offset, 20";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($group_user_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($group_user_count > 0) && ($page > 1)) {
        return perm_group_get_users($gid, $page - 1);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        $group_user_array[] = $user_data;
    }

    return array(
        'user_count' => $group_user_count,
        'user_array' => $group_user_array
    );
}

function perm_user_apply_email_confirmation($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $perm = USER_PERM_EMAIL_CONFIRM;

    if (($gid = perm_get_user_gid($uid)) !== false) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '0', '0', '$perm') ON DUPLICATE KEY ";
        $sql.= "UPDATE PERM = PERM | VALUES(PERM)";

        if (!$db->query($sql)) return false;

    } else {

        $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM) ";
        $sql.= "VALUES ('0', '0', '$perm')";

        if ($db->query($sql)) {

            $new_gid = $db->insert_id;

            return perm_add_user_to_group($uid, $new_gid);
        }
    }

    return false;
}

function perm_user_cancel_email_confirmation($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $perm = USER_PERM_EMAIL_CONFIRM;

    if (!($gid = perm_get_user_gid($uid))) return false;

    $sql = "UPDATE GROUP_PERMS SET PERM = PERM ^ $perm ";
    $sql.= "WHERE GID = '$gid' AND FORUM = 0 AND FID = 0";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_display_list($perms)
{
    $perms_array = array();

    if ($perms & USER_PERM_BANNED)           $perms_array[] = 'UB';
    if ($perms & USER_PERM_WORMED)           $perms_array[] = 'UW';
    if ($perms & USER_PERM_POST_READ)        $perms_array[] = 'PR';
    if ($perms & USER_PERM_POST_CREATE)      $perms_array[] = 'PC';
    if ($perms & USER_PERM_THREAD_CREATE)    $perms_array[] = 'TC';
    if ($perms & USER_PERM_POST_EDIT)        $perms_array[] = 'PE';
    if ($perms & USER_PERM_POST_DELETE)      $perms_array[] = 'PD';
    if ($perms & USER_PERM_POST_ATTACHMENTS) $perms_array[] = 'UA';
    if ($perms & USER_PERM_FOLDER_MODERATE)  $perms_array[] = 'FM';
    if ($perms & USER_PERM_ADMIN_TOOLS)      $perms_array[] = 'AT';
    if ($perms & USER_PERM_HTML_POSTING)     $perms_array[] = 'HP';
    if ($perms & USER_PERM_SIGNATURE)        $perms_array[] = 'US';
    if ($perms & USER_PERM_GUEST_ACCESS)     $perms_array[] = 'GA';
    if ($perms & USER_PERM_POST_APPROVAL)    $perms_array[] = 'PA';
    if ($perms & USER_PERM_LINKS_MODERATE)   $perms_array[] = 'LM';
    if ($perms & USER_PERM_EMAIL_CONFIRM)    $perms_array[] = 'EC';
    if ($perms & USER_PERM_CAN_IGNORE_ADMIN) $perms_array[] = 'IA';
    if ($perms & USER_PERM_PILLORIED)        $perms_array[] = 'UP';
    if ($perms & USER_PERM_THREAD_MOVE)      $perms_array[] = 'TM';

    if (sizeof($perms_array) > 0) {

        return implode(",", $perms_array);

    } else {

        return gettext("none");
    }
}

?>