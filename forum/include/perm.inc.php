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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function perm_is_moderator($uid, $folder_fid = null)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($folder_fid)) return false;

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    if (is_numeric($folder_fid)) {

        $sql = "SELECT BIT_OR(PERM) AS PERM FROM ((SELECT GROUP_USERS.UID, ";
        $sql .= "BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUPS INNER JOIN GROUP_PERMS ";
        $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) INNER JOIN GROUP_USERS ";
        $sql .= "ON (GROUP_USERS.GID = GROUPS.GID) INNER JOIN USER ";
        $sql .= "ON (USER.UID = GROUP_USERS.UID) WHERE GROUPS.FORUM = $forum_fid ";
        $sql .= "AND GROUP_PERMS.FID IN (0, $folder_fid) AND GROUP_USERS.UID = $uid ";
        $sql .= "GROUP BY GROUP_USERS.UID) UNION ALL (SELECT USER_PERM.UID, ";
        $sql .= "BIT_OR(USER_PERM.PERM) AS PERM FROM USER INNER JOIN USER_PERM ";
        $sql .= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
        $sql .= "AND USER_PERM.FID IN (0, $folder_fid) AND USER_PERM.UID = $uid ";
        $sql .= "GROUP BY USER.UID)) AS USER_PERM GROUP BY UID";

    } else {

        $sql = "SELECT BIT_OR(PERM) AS PERM FROM ((SELECT GROUP_USERS.UID, ";
        $sql .= "BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUPS INNER JOIN GROUP_PERMS ";
        $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) INNER JOIN GROUP_USERS ";
        $sql .= "ON (GROUP_USERS.GID = GROUPS.GID) INNER JOIN USER ";
        $sql .= "ON (USER.UID = GROUP_USERS.UID) WHERE GROUPS.FORUM = $forum_fid ";
        $sql .= "AND GROUP_USERS.UID = $uid GROUP BY GROUP_USERS.UID) UNION ALL ";
        $sql .= "(SELECT USER_PERM.UID, BIT_OR(USER_PERM.PERM) AS PERM FROM USER ";
        $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
        $sql .= "WHERE USER_PERM.FORUM IN (0, $forum_fid) AND USER_PERM.UID = $uid ";
        $sql .= "GROUP BY USER.UID)) AS USER_PERM GROUP BY UID";
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

    $sql = "SELECT BIT_OR(PERM) AS PERM FROM ((SELECT GROUP_USERS.UID, ";
    $sql .= "BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) INNER JOIN GROUP_USERS ";
    $sql .= "ON (GROUP_USERS.GID = GROUPS.GID) INNER JOIN USER ";
    $sql .= "ON (USER.UID = GROUP_USERS.UID) WHERE GROUPS.FORUM = $forum_fid ";
    $sql .= "AND GROUP_PERMS.FID = 0 AND GROUP_USERS.UID = $uid ";
    $sql .= "GROUP BY GROUP_USERS.UID) UNION ALL (SELECT USER_PERM.UID, ";
    $sql .= "BIT_OR(USER_PERM.PERM) AS PERM FROM USER INNER JOIN USER_PERM ";
    $sql .= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
    $sql .= "AND USER_PERM.FID = 0 AND USER_PERM.UID = $uid ";
    $sql .= "GROUP BY USER.UID)) AS USER_PERM GROUP BY UID";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_global_admin_access($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT BIT_OR(USER_PERM.PERM) AS PERM FROM USER ";
    $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM = 0 AND USER_PERM.FID = 0 ";
    $sql .= "AND USER_PERM.UID = $uid GROUP BY USER.UID";

    if (!($result = $db->query($sql))) return false;

    list($user_status) = $result->fetch_row();

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_forumtools_access($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT BIT_OR(USER_PERM.PERM) AS PERM FROM USER ";
    $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM = 0 AND USER_PERM.FID = 0 ";
    $sql .= "AND USER_PERM.UID = $uid GROUP BY USER.UID";

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

    $sql = "SELECT BIT_OR(PERM) AS PERM FROM ((SELECT GROUP_USERS.UID, ";
    $sql .= "BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) INNER JOIN GROUP_USERS ";
    $sql .= "ON (GROUP_USERS.GID = GROUPS.GID) INNER JOIN USER ";
    $sql .= "ON (USER.UID = GROUP_USERS.UID) WHERE GROUPS.FORUM = $forum_fid ";
    $sql .= "AND GROUP_PERMS.FID = 0 AND GROUP_USERS.UID = $uid ";
    $sql .= "GROUP BY GROUP_USERS.UID) UNION ALL (SELECT USER_PERM.UID, ";
    $sql .= "BIT_OR(USER_PERM.PERM) AS PERM FROM USER INNER JOIN USER_PERM ";
    $sql .= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
    $sql .= "AND USER_PERM.FID = 0 AND USER_PERM.UID = $uid ";
    $sql .= "GROUP BY USER.UID)) AS USER_PERM GROUP BY UID";

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

    $sql = "SELECT BIT_OR(PERM) AS PERM FROM ((SELECT BIT_OR(GROUP_PERMS.PERM) AS PERM ";
    $sql .= "FROM GROUPS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN USER ON (USER.UID = GROUP_USERS.UID) WHERE GROUPS.FORUM = $forum_fid ";
    $sql .= "AND GROUP_PERMS.FID = $fid AND GROUP_USERS.UID = $uid) UNION ALL  ";
    $sql .= "(SELECT BIT_OR(USER_PERM.PERM) AS PERM FROM USER INNER JOIN USER_PERM ";
    $sql .= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
    $sql .= "AND USER_PERM.FID  = $fid AND USER_PERM.UID = $uid) UNION ALL ";
    $sql .= "(SELECT FOLDER.PERM FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "WHERE FOLDER.FID = $fid)) AS USER_PERM HAVING PERM & $access_level > 0";

    if (!($result = $db->query($sql))) return false;

    return $result->num_rows > 0;
}

function perm_check_global_permissions($access_level, $uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($access_level)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "SELECT BIT_OR(USER_PERM.PERM) AS PERM FROM USER ";
    $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID)";
    $sql .= "WHERE USER_PERM.FORUM = 0 AND USER_PERM.FID = 0";
    $sql .= "AND USER_PERM.UID = $uid HAVING PERM & $access_level > 0";

    if (!($result = $db->query($sql))) return false;

    return $result->num_rows > 0;
}

function perm_get_user_groups($page = 1, $sort_by = 'GROUP_NAME', $sort_dir = 'ASC')
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'GROUP_NAME',
        'GROUP_DESC',
        'PERMS',
        'USER_COUNT',
        'DEFAULT_GROUP',
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'GROUP_NAME';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_groups_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS GROUPS.GID, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC, ";
    $sql .= "COUNT(DISTINCT GROUP_USERS.UID) AS USER_COUNT, BIT_OR(GROUP_PERMS.PERM) AS PERMS, ";
    $sql .= "IF(FORUM_SETTINGS.SVALUE = GROUPS.GID, 1, 0) AS DEFAULT_GROUP FROM GROUPS ";
    $sql .= "INNER JOIN GROUP_PERMS USING (GID) LEFT JOIN GROUP_USERS USING (GID) ";
    $sql .= "LEFT JOIN FORUM_SETTINGS ON (FORUM_SETTINGS.FID = '$forum_fid' ";
    $sql .= "AND FORUM_SETTINGS.SNAME = 'default_user_group') WHERE GROUPS.FORUM = '$forum_fid' ";
    $sql .= "AND GROUP_PERMS.FID = 0 GROUP BY GROUP_PERMS.GID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_groups_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($user_groups_count > 0) && ($page > 1)) {
        return perm_get_user_groups($page - 1, $sort_by, $sort_dir);
    }

    while (($permissions_data = $result->fetch_assoc()) !== null) {

        $user_groups_array[$permissions_data['GID']] = array(
            'GID' => $permissions_data['GID'],
            'GROUP_NAME' => $permissions_data['GROUP_NAME'],
            'GROUP_DESC' => $permissions_data['GROUP_DESC'],
            'USER_COUNT' => $permissions_data['USER_COUNT'],
            'PERMS' => (double)$permissions_data['PERMS']
        );
    }

    return array(
        'user_groups_array' => $user_groups_array,
        'user_groups_count' => $user_groups_count
    );
}

function perm_get_user_group_names()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME FROM GROUPS ";
    $sql .= "WHERE GROUPS.FORUM = $forum_fid GROUP BY GROUPS.GID";

    if (!($result = $db->query($sql))) return false;

    $user_groups_array = array();

    if ($result->num_rows > 0) {

        while (($perm_data = $result->fetch_assoc()) !== null) {
            $user_groups_array[$perm_data['GID']] = $perm_data['GROUP_NAME'];
        }
    }

    return $user_groups_array;
}

function perm_user_get_groups($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME, COUNT(DISTINCT GROUP_USER_COUNT.UID) AS USER_COUNT ";
    $sql .= "FROM GROUP_PERMS INNER JOIN GROUPS USING (GID) INNER JOIN GROUP_USERS GROUP_USER_COUNT USING (GID) ";
    $sql .= "INNER JOIN GROUP_USERS USING (GID) WHERE GROUPS.FORUM = '$forum_fid' AND GROUP_USERS.UID = '$uid' ";
    $sql .= "GROUP BY GROUP_PERMS.GID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_groups_array = array();

    while (($permissions_data = $result->fetch_assoc()) !== null) {
        $user_groups_array[$permissions_data['GID']] = $permissions_data;
    }

    return $user_groups_array;
}

function perm_user_get_group_names($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_groups_array = array();

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME FROM GROUPS ";
    $sql .= "INNER JOIN GROUP_PERMS USING (GID) INNER JOIN GROUP_USERS USING (GID) ";
    $sql .= "INNER JOIN USER USING (UID) WHERE GROUPS.FORUM = '$forum_fid' ";
    $sql .= "AND GROUP_USERS.UID = '$uid' GROUP BY GROUPS.GID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        while (($perm_data = $result->fetch_assoc()) !== null) {
            $user_groups_array[$perm_data['GID']] = $perm_data['GROUP_NAME'];
        }
    }

    if (perm_has_admin_access($uid)) $user_groups_array[] = gettext("Forum Leader");
    if (perm_is_moderator($uid)) $user_groups_array[] = gettext("Folder Moderator");

    return sizeof($user_groups_array) > 0 ? $user_groups_array : false;
}

function perm_add_group($group_name, $group_desc, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($perm)) return false;

    $group_name = $db->escape($group_name);
    $group_desc = $db->escape($group_desc);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "INSERT INTO GROUPS (FORUM, GROUP_NAME, GROUP_DESC) ";
    $sql .= "VALUES ('$forum_fid', '$group_name', '$group_desc')";

    if (!$db->query($sql)) return false;

    $new_gid = $db->insert_id;

    $sql = "INSERT INTO GROUP_PERMS (GID, FID, PERM) ";
    $sql .= "VALUES ('$new_gid', '0', '$perm')";

    if (!$db->query($sql)) return false;

    return $new_gid;
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

    $sql = "UPDATE LOW_PRIORITY GROUPS SET GROUP_NAME = '$group_name', ";
    $sql .= "GROUP_DESC = '$group_desc' WHERE GID = '$gid'";

    if (!$db->query($sql)) return false;

    $sql = "INSERT INTO GROUP_PERMS (GID, FID, PERM) ";
    $sql .= "VALUES ('$gid', 0, '$perm') ON DUPLICATE KEY ";
    $sql .= "UPDATE PERM = $perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_remove_group($gid)
{
    if (!is_numeric($gid)) return false;

    if (!$db = db::get()) return false;

    $sql = "DELETE QUICK FROM GROUP_PERMS WHERE GID = '$gid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM GROUP_USERS WHERE GID = '$gid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM GROUPS WHERE GID = '$gid'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}

function perm_get_group($gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC ";
    $sql .= "FROM GROUPS WHERE GROUPS.GID = '$gid' ";
    $sql .= "AND GROUPS.FORUM = '$forum_fid'";

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

function perm_get_default_group()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT GROUPS.GID FROM GROUPS INNER JOIN FORUM_SETTINGS ";
    $sql .= "ON (FORUM_SETTINGS.FID = GROUPS.FORUM AND FORUM_SETTINGS.SNAME = 'default_user_group' ";
    $sql .= "AND FORUM_SETTINGS.SVALUE = GROUPS.GID) GROUP BY GROUPS.GID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($gid) = $result->fetch_row();

    return $gid;
}

function perm_user_in_group($uid, $gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    $sql = "SELECT COUNT(GROUP_USERS.UID) FROM GROUPS INNER JOIN GROUP_USERS ";
    $sql .= "USING (GID) WHERE GROUP_USERS.UID = '$uid' AND GROUPS.GID = '$gid'";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return ($user_count > 0);
}

function perm_get_global_user_permissions($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return 0;

    $sql = "SELECT BIT_OR(USER_PERM.PERM) AS PERM FROM USER ";
    $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM = 0 AND USER_PERM.FID = 0 ";
    $sql .= "AND USER_PERM.UID = $uid";

    if (!($result = $db->query($sql))) return false;

    list($global_user_perm) = $result->fetch_row();

    return $global_user_perm;
}

function perm_get_admin_tools_perm_count()
{
    if (!$db = db::get()) return false;

    $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;

    $sql = "SELECT COUNT(DISTINCT USER.UID) AS COUNT FROM USER INNER JOIN USER_PERM ";
    $sql .= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM = 0 AND USER_PERM.FID = 0 ";
    $sql .= "AND USER_PERM.PERM & $user_perm_admin_tools > 0";

    if (!($result = $db->query($sql))) return false;

    list($global_perm_count) = $result->fetch_row();

    return $global_perm_count;
}

function perm_get_forum_tools_perm_count()
{
    if (!$db = db::get()) return false;

    $user_perm_forum_tools = USER_PERM_FORUM_TOOLS;

    $sql = "SELECT COUNT(DISTINCT USER.UID) AS COUNT FROM USER INNER JOIN USER_PERM ";
    $sql .= "ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM = 0 AND USER_PERM.FID = 0 ";
    $sql .= "AND USER_PERM.PERM & $user_perm_forum_tools > 0";

    if (!($result = $db->query($sql))) return false;

    list($global_perm_count) = $result->fetch_row();

    return $global_perm_count;
}

function perm_update_user_global_perms($uid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    $sql = "INSERT INTO USER_PERM (UID, FORUM, FID, PERM) ";
    $sql .= "VALUES ('$uid', '0', '0', '$perm') ON DUPLICATE KEY ";
    $sql .= "UPDATE PERM = $perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_get_group_permissions($gid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql .= "USING (GID) WHERE GROUPS.GID = '$gid' AND GROUP_PERMS.FID = 0 ";
    $sql .= "AND GROUPS.FORUM = '$forum_fid'";

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

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COALESCE(GROUP_PERM, FOLDER.PERM, 0) AS STATUS ";
    $sql.= "FROM `{$table_prefix}FOLDER` FOLDER LEFT JOIN (SELECT GROUP_PERMS.FID, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS GROUP_PERM FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.GID = GROUPS.GID) WHERE GROUPS.FORUM = $forum_fid ";
    $sql.= "AND GROUPS.GID = $gid GROUP BY GROUP_PERMS.FID) AS GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.FID = FOLDER.FID)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($permissions_data = $result->fetch_assoc()) !== null) {

        $folders_array[$permissions_data['FID']] = array(
            'FID' => $permissions_data['FID'],
            'TITLE' => $permissions_data['TITLE'],
            'STATUS' => (double)$permissions_data['STATUS']
        );
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

    $sql = "DELETE QUICK FROM GROUP_USERS WHERE GID = '$gid' AND UID = '$uid'";

    if (!$db->query($sql)) return false;

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

    $sql = "SELECT BIT_OR(USER_PERM.PERM) AS STATUS FROM USER ";
    $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
    $sql .= "AND USER_PERM.FID = 0 AND USER_PERM.UID = $uid";

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

    $sql = "SELECT BIT_OR(USER_PERM.PERM) AS STATUS FROM USER ";
    $sql .= "INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM = $forum_fid AND USER_PERM.FID = 0 ";
    $sql .= "AND USER_PERM.UID = $uid";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $permissions_data = $result->fetch_assoc();

    return (double)$permissions_data['STATUS'];
}

function perm_user_get_folders($uid)
{
    if (!$db = db::get()) return false;

    $folders_array = array();

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COALESCE(USER_PERM, FOLDER.PERM, 0) AS STATUS ";
    $sql.= "FROM `{$table_prefix}FOLDER` FOLDER LEFT JOIN (SELECT USER_PERM.FID, ";
    $sql.= "BIT_OR(USER_PERM.PERM) AS USER_PERM FROM USER INNER JOIN USER_PERM ON ";
    $sql.= "(USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM = $forum_fid AND USER_PERM.UID = $uid ";
    $sql.= "GROUP BY USER_PERM.FID) AS USER_PERMS ON (USER_PERMS.FID = FOLDER.FID)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($permissions_data = $result->fetch_assoc()) !== null) {

        $folders_array[$permissions_data['FID']] = array(
            'FID' => $permissions_data['FID'],
            'TITLE' => $permissions_data['TITLE'],
            'STATUS' => (double)$permissions_data['STATUS']
        );
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

    $sql = "INSERT INTO USER_PERM (UID, FORUM, FID, PERM) ";
    $sql .= "VALUES ('$uid', '$forum_fid', '$fid', '$perm') ";
    $sql .= "ON DUPLICATE KEY UPDATE PERM = $perm ";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_update_group_folder_perms($gid, $fid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO GROUP_PERMS (GID, FID, PERM) ";
    $sql .= "VALUES ('$gid', '$fid', '$perm') ";
    $sql .= "ON DUPLICATE KEY UPDATE PERM = $perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_update_user_permissions($uid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "INSERT INTO USER_PERM (UID, FORUM, FID, PERM) ";
    $sql .= "VALUES ('$uid', '$forum_fid', '0', '$perm') ";
    $sql .= "ON DUPLICATE KEY UPDATE PERM = $perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_update_user_forum_permissions($uid, $forum_fid, $perm)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($forum_fid)) return false;
    if (!is_numeric($uid)) return false;

    $sql = "INSERT INTO USER_PERM (UID, FORUM, FID, PERM) ";
    $sql .= "VALUES ('$uid', '$forum_fid', '0', '$perm') ";
    $sql .= "ON DUPLICATE KEY UPDATE PERM = PERM | $perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_folder_get_permissions($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return 0;

    if (!($table_prefix = get_table_prefix())) return 0;

    $sql = "SELECT PERM FROM `{$table_prefix}FOLDER` WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($permissions_data) = $result->fetch_assoc();

    return $permissions_data;
}

function perm_folder_reset_user_permissions($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $folder_perms = perm_folder_get_permissions($fid);

    $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;

    $remove_perms = (double)USER_PERM_BANNED | USER_PERM_WORMED;
    $remove_perms = (double)$remove_perms | USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS;
    $remove_perms = (double)$remove_perms | USER_PERM_LINKS_MODERATE | USER_PERM_EMAIL_CONFIRM;
    $remove_perms = (double)$remove_perms | USER_PERM_CAN_IGNORE_ADMIN | USER_PERM_PILLORIED;

    $folder_perms = $folder_perms & ~$remove_perms;

    $sql = "UPDATE LOW_PRIORITY GROUPS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql .= "SET GROUP_PERMS.PERM = '$folder_perms' | (PERM & $user_perm_folder_moderate) ";
    $sql .= "WHERE GROUP_PERMS.FID = '$fid' AND GROUPS.FORUM = $forum_fid";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_group_get_users($gid, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($gid)) return 0;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 20);

    $group_user_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS GROUP_USERS.UID, USER.LOGON, USER.NICKNAME ";
    $sql .= "FROM GROUPS INNER JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN USER ON (USER.UID = GROUP_USERS.UID) WHERE GROUPS.GID = '$gid' ";
    $sql .= "ORDER BY USER.LOGON LIMIT $offset, 20";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($group_user_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($group_user_count > 0) && ($page > 1)) {
        return perm_group_get_users($gid, $page - 1);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {
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

    $sql = "INSERT INTO USER_PERM (UID, FORUM, FID, PERM) ";
    $sql .= "VALUES ('$uid', '0', '0', '$perm') ON DUPLICATE KEY ";
    $sql .= "UPDATE PERM = PERM | $perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_user_cancel_email_confirmation($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $perm = USER_PERM_EMAIL_CONFIRM;

    $sql = "INSERT INTO USER_PERM (UID, FORUM, FID, PERM) ";
    $sql .= "VALUES ('$uid', '0', '0', '$perm') ON DUPLICATE KEY ";
    $sql .= "UPDATE PERM = PERM & ~$perm";

    if (!$db->query($sql)) return false;

    return true;
}

function perm_display_list($perms)
{
    $perms_array = array();

    if ($perms & USER_PERM_BANNED) $perms_array[] = 'UB';
    if ($perms & USER_PERM_WORMED) $perms_array[] = 'UW';
    if ($perms & USER_PERM_POST_READ) $perms_array[] = 'PR';
    if ($perms & USER_PERM_POST_CREATE) $perms_array[] = 'PC';
    if ($perms & USER_PERM_THREAD_CREATE) $perms_array[] = 'TC';
    if ($perms & USER_PERM_POST_EDIT) $perms_array[] = 'PE';
    if ($perms & USER_PERM_POST_DELETE) $perms_array[] = 'PD';
    if ($perms & USER_PERM_POST_ATTACHMENTS) $perms_array[] = 'UA';
    if ($perms & USER_PERM_FOLDER_MODERATE) $perms_array[] = 'FM';
    if ($perms & USER_PERM_ADMIN_TOOLS) $perms_array[] = 'AT';
    if ($perms & USER_PERM_HTML_POSTING) $perms_array[] = 'HP';
    if ($perms & USER_PERM_SIGNATURE) $perms_array[] = 'US';
    if ($perms & USER_PERM_GUEST_ACCESS) $perms_array[] = 'GA';
    if ($perms & USER_PERM_POST_APPROVAL) $perms_array[] = 'PA';
    if ($perms & USER_PERM_LINKS_MODERATE) $perms_array[] = 'LM';
    if ($perms & USER_PERM_EMAIL_CONFIRM) $perms_array[] = 'EC';
    if ($perms & USER_PERM_CAN_IGNORE_ADMIN) $perms_array[] = 'IA';
    if ($perms & USER_PERM_PILLORIED) $perms_array[] = 'UP';
    if ($perms & USER_PERM_THREAD_MOVE) $perms_array[] = 'TM';

    if (sizeof($perms_array) > 0) {

        return implode(",", $perms_array);

    } else {

        return gettext("none");
    }
}