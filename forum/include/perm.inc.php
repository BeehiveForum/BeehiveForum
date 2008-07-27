<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: perm.inc.php,v 1.127 2008-07-27 18:26:15 decoyduck Exp $ */

/**
* Functions relating to permissions
*/

/**
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

function perm_is_moderator($uid, $folder_fid = 0)
{
    if (!$db_perm_is_moderator = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($folder_fid)) return false;

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);
    }

    if ($folder_fid > 0) {

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0, $folder_fid) ";
        $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "ORDER BY GROUP_PERMS.PERM DESC";

    }else {

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "ORDER BY GROUP_PERMS.PERM DESC";
    }

    if (!$result = db_query($sql, $db_perm_is_moderator)) return false;

    list($user_status) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_status & USER_PERM_FOLDER_MODERATE) > 0;
}

function perm_has_admin_access($uid)
{
    if (!$db_perm_has_admin_access = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0);
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!$result = db_query($sql, $db_perm_has_admin_access)) return false;

    list($user_status) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_global_admin_access($uid)
{
    if (!$db_perm_has_global_admin_access = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0);
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!$result = db_query($sql, $db_perm_has_global_admin_access)) return false;

    list($user_status) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_forumtools_access($uid)
{
    if (!$db_perm_has_forumtools_access = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0);
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!$result = db_query($sql, $db_perm_has_forumtools_access)) return false;

    list($user_status) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_status & USER_PERM_FORUM_TOOLS) > 0;
}

function perm_is_links_moderator($uid)
{
    if (!$db_perm_has_forumtools_access = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0);
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "ORDER BY GROUP_PERMS.GID DESC";

    if (!$result = db_query($sql, $db_perm_has_forumtools_access)) return false;

    list($user_status) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_status & USER_PERM_LINKS_MODERATE) > 0;
}

function perm_check_folder_permissions($fid, $access_level, $uid)
{
    if (!$db_perm_check_folder_permissions = db_connect()) return false;

    if (!is_numeric($fid)) return false;
    if (!is_numeric($access_level)) return false;
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm($access_level, $fid);
    }

    $sql = "SELECT FOLDER.FID, BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = '$uid') ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID ";

    if (!$result = db_query($sql, $db_perm_check_folder_permissions)) return false;

    $permissions_data = db_fetch_array($result);

    if ($permissions_data['USER_PERM_COUNT'] > 0) {

        $folder_fid = $fid;
        $user_status = $permissions_data['USER_STATUS'];

    }elseif ($permissions_data['FOLDER_PERM_COUNT'] > 0) {

        $folder_fid = $fid;
        $user_status = $permissions_data['FOLDER_PERMS'];
    }

    return ($user_status & $access_level) == $access_level;
}

function perm_check_global_permissions($access_level, $uid)
{
    if (!$db_perm_get_global_permissions = db_connect()) return false;

    if (!is_numeric($access_level)) return false;
    if (!is_numeric($uid)) return false;

    if ($uid == bh_session_get_value('UID')) {
        return bh_session_check_perm($access_level, 0);
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS USER_PERM FROM GROUPS ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND GROUP_USERS.UID = '$uid' ";

    if (!$result = db_query($sql, $db_perm_get_global_permissions)) return false;

    list($user_status) = db_fetch_array($result, DB_RESULT_NUM);

    return ($user_status & $access_level) == $access_level;
}

function perm_get_user_groups($offset, $sort_by = 'GROUP_NAME', $sort_dir = 'ASC')
{
    if (!$db_perm_get_user_groups = db_connect()) return false;

    $sort_by_array  = array('GROUPS.GROUP_NAME', 'GROUPS.GROUP_DESC', 'USER_COUNT');
    $sort_dir_array = array('ASC', 'DESC');

    if (!is_numeric($offset)) return false;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'GROUPS.GROUP_NAME';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $user_groups_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS GROUPS.GID, GROUPS.FORUM, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC, ";
    $sql.= "GROUPS.AUTO_GROUP, COUNT(GROUP_USERS.UID) AS USER_COUNT ";
    $sql.= "FROM GROUPS GROUPS LEFT JOIN GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 AND GROUPS.FORUM = '$forum_fid' ";
    $sql.= "GROUP BY GROUPS.GID ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_perm_get_user_groups)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_perm_get_user_groups)) return false;

    list($user_groups_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while ($permissions_data = db_fetch_array($result)) {

            $user_groups_array[] = $permissions_data;
        }

    }else if ($user_groups_count > 0) {

        $offset = floor(($user_groups_count - 1) / 10) * 10;
        return perm_get_user_groups($offset, $sort_by, $sort_dir);
    }

    return array('user_groups_array' => $user_groups_array,
                 'user_groups_count' => $user_groups_count);
}

function perm_user_get_groups($uid)
{
    if (!$db_perm_user_get_groups = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT GROUPS.GID, GROUPS.FORUM, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC, ";
    $sql.= "GROUPS.AUTO_GROUP, COUNT(GROUP_USER_COUNT.UID) AS USER_COUNT FROM GROUPS GROUPS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USER_COUNT ON (GROUP_USER_COUNT.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 AND GROUPS.FORUM = '$forum_fid' AND GROUP_USERS.UID = '$uid'";
    $sql.= "GROUP BY GROUPS.GID";

    if (!$result = db_query($sql, $db_perm_user_get_groups)) return false;

    if (db_num_rows($result) > 0) {

        $user_groups_array = array();

        while ($permissions_data = db_fetch_array($result)) {

            $user_groups_array[] = $permissions_data;
        }

        return $user_groups_array;
    }

    return false;
}

function perm_user_get_group_names($uid, &$user_groups_array)
{
    if (!$db_perm_user_get_group_names = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!is_array($user_groups_array)) $user_groups_array = array();

    $sql = "SELECT GROUPS.GID, GROUPS.GROUP_NAME FROM GROUPS GROUPS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USER_COUNT ON (GROUP_USER_COUNT.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 AND GROUPS.FORUM IN (0, $forum_fid) ";
    $sql.= "AND GROUP_USERS.UID = '$uid' GROUP BY GROUPS.GID";

    if (!$result = db_query($sql, $db_perm_user_get_group_names)) return false;

    if (db_num_rows($result) > 0) {

        while ($perm_data = db_fetch_array($result)) {

            $user_groups_array[$perm_data['GID']] = $perm_data['GROUP_NAME'];
        }
    }

    if (perm_has_admin_access($uid)) $user_groups_array[] = $lang['forumleader'];
    if (perm_is_moderator($uid)) $user_groups_array[] = $lang['userpermfoldermoderate'];

    return sizeof($user_groups_array) > 0;
}

function perm_add_group($group_name, $group_desc, $perm)
{
    if (!$db_perm_add_group = db_connect()) return false;

    if (!is_numeric($perm)) return false;

    $group_name = db_escape_string($group_name);
    $group_desc = db_escape_string($group_desc);

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "INSERT INTO GROUPS (FORUM, GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
    $sql.= "VALUES ('$forum_fid', '$group_name', '$group_desc', 0)";

    if ($result = db_query($sql, $db_perm_add_group)) {

        $new_gid = db_insert_id($db_perm_add_group);

        if ($perm > 0) {

            $sql = "INSERT INTO GROUP_PERMS (FORUM, GID, FID, PERM) ";
            $sql.= "VALUES ('$forum_fid', '$new_gid', '0', '$perm')";

            if (!$result = db_query($sql, $db_perm_add_group)) return false;
        }

        return $new_gid;
    }

    return false;
}

function perm_update_group($gid, $group_name, $group_desc, $perm)
{
    if (!$db_perm_update_group = db_connect()) return false;

    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    $group_name = db_escape_string($group_name);
    $group_desc = db_escape_string($group_desc);

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "UPDATE LOW_PRIORITY GROUPS SET GROUP_NAME = '$group_name', ";
        $sql.= "GROUP_DESC = '$group_desc' WHERE GID = '$gid'";

        if (!$result = db_query($sql, $db_perm_update_group)) return false;

        $sql = "SELECT PERM FROM GROUP_PERMS WHERE GID = '$gid' ";
        $sql.= "AND FORUM = '$forum_fid' AND FID = 0 LIMIT 0, 1";

        if (!$result = db_query($sql, $db_perm_update_group)) return false;

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$perm' WHERE ";
            $sql.= "GID = '$gid' AND FORUM = '$forum_fid' AND FID = 0";

            if (!$result = db_query($sql, $db_perm_update_group)) return false;

        }else {

            $sql = "INSERT INTO GROUP_PERMS (FORUM, FID, PERM, GID) ";
            $sql.= "VALUES ($forum_fid, 0, $perm, $gid)";

            if (!$result = db_query($sql, $db_perm_update_group)) return false;
        }
    }

    return true;
}

function perm_remove_group($gid)
{
    if (!$db_perm_remove_group = db_connect()) return false;

    if (!is_numeric($gid)) return false;

    $sql = "DELETE QUICK FROM GROUP_PERMS WHERE GID = '$gid'";

    if (!$result = db_query($sql, $db_perm_remove_group)) return false;

    $sql = "DELETE QUICK FROM GROUP_USERS WHERE GID = '$gid'";

    if (!$result = db_query($sql, $db_perm_remove_group)) return false;

    $sql = "DELETE QUICK FROM GROUPS WHERE GID = '$gid'";

    if (!$result = db_query($sql, $db_perm_remove_group)) return false;

    return (db_affected_rows($db_perm_remove_group) > 0);
}

function perm_get_group($gid)
{
    if (!$db_perm_get_group = db_connect()) return false;

    if (!is_numeric($gid)) return false;

    $sql = "SELECT GID, FORUM, GROUP_NAME, GROUP_DESC, AUTO_GROUP ";
    $sql.= "FROM GROUPS WHERE GID = '$gid' AND AUTO_GROUP = 0";

    if (!$result = db_query($sql, $db_perm_get_group)) return false;

    if (db_num_rows($result) > 0) {

        $permissions_data = db_fetch_array($result);
        return $permissions_data;
    }

    return false;
}

function perm_get_group_name($gid)
{
    if (!$db_perm_get_group_name = db_connect()) return false;

    if (!is_numeric($gid)) return false;

    $sql = "SELECT GROUP_NAME FROM GROUPS WHERE GID = '$gid' AND AUTO_GROUP = 0";

    if (!$result = db_query($sql, $db_perm_get_group_name)) return false;

    if (db_num_rows($result) > 0) {

        list($group_name) = db_fetch_array($result, DB_RESULT_NUM);
        return $group_name;
    }

    return false;
}

function perm_is_group($gid)
{
    if (!$db_perm_is_group = db_connect()) return false;

    if (!is_numeric($gid)) return false;

    $sql = "SELECT GID FROM GROUPS WHERE GID = '$gid' ";
    $sql.= "AND AUTO_GROUP = 0 LIMIT 0, 1";

    if (!$result = db_query($sql, $db_perm_is_group)) return false;

    return (db_num_rows($result) > 0);
}

function perm_user_in_group($uid, $gid)
{
    if (!$db_perm_user_in_group = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    $sql = "SELECT GID FROM GROUP_USERS WHERE UID = '$uid' ";
    $sql.= "AND GID = '$gid' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_perm_user_in_group)) return false;

    return (db_num_rows($result) > 0);
}

function perm_get_global_user_permissions($uid)
{
    if (!$db_perm_get_global_permissions = db_connect()) return false;

    if (!is_numeric($uid)) return 0;

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS USER_PERM FROM GROUPS ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND GROUP_USERS.UID = '$uid' ";

    if (!$result = db_query($sql, $db_perm_get_global_permissions)) return false;

    list($global_user_perm) = db_fetch_array($result, DB_RESULT_NUM);

    return $global_user_perm;
}

/**
* Counts the number of users with global access to admin and forum management tools
*
* @return integer
* @see perm_get_admin_tools_perm_count()
* @see perm_get_forum_tools_perm_count()
*/
function perm_get_global_permissions_count()
{
    if (!$db_perm_get_global_permissions = db_connect()) return false;

    $upft = USER_PERM_FORUM_TOOLS;
    $upat = USER_PERM_ADMIN_TOOLS;

    $sql = "SELECT COUNT(GROUPS.GID) AS PERM_COUNT FROM GROUPS ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND (GROUP_PERMS.PERM & $upft > 0 ";
    $sql.= "OR GROUP_PERMS.PERM & $upat > 0) AND USER.UID IS NOT NULL ";

    if (!$result = db_query($sql, $db_perm_get_global_permissions)) return false;

    list($global_perm_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $global_perm_count;
}

/**
* Counts the number of users with global access to admin tools
*
* @return integer
* @see perm_get_global_permissions_count()
* @see perm_get_forum_tools_perm_count()
*/
function perm_get_admin_tools_perm_count()
{
    if (!$db_perm_get_global_permissions = db_connect()) return false;

    $upat = USER_PERM_ADMIN_TOOLS;

    $sql = "SELECT COUNT(GROUPS.GID) AS PERM_COUNT FROM GROUPS ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND (GROUP_PERMS.PERM & $upat > 0) ";
    $sql.= "AND USER.UID IS NOT NULL";

    if (!$result = db_query($sql, $db_perm_get_global_permissions)) return false;

    list($global_perm_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $global_perm_count;
}

/**
* Counts the number of users with global access to forum management tools
*
* @return integer
* @see perm_get_global_permissions_count()
* @see perm_get_admin_tools_perm_count()
*/
function perm_get_forum_tools_perm_count()
{
    if (!$db_perm_get_global_permissions = db_connect()) return false;

    $upft = USER_PERM_FORUM_TOOLS;

    $sql = "SELECT COUNT(GROUPS.GID) AS PERM_COUNT FROM GROUPS ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND (GROUP_PERMS.PERM & $upft > 0) ";
    $sql.= "AND USER.UID IS NOT NULL";

    if (!$result = db_query($sql, $db_perm_get_global_permissions)) return false;

    list($global_perm_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $global_perm_count;
}

function perm_update_global_perms($uid, $perm)
{
    if (!$db_perm_add_global_perms = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if ($gid = perm_get_global_user_gid($uid)) {

        $sql = "SELECT GID FROM GROUP_PERMS WHERE GID = '$gid' ";
        $sql.= "AND FORUM = 0 AND FID = 0 LIMIT 0, 1";

        if (!$result = db_query($sql, $db_perm_add_global_perms)) return false;

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$perm' WHERE GID = '$gid' ";
            $sql.= "AND FORUM = '0' AND FID = '0'";

            if (!$result = db_query($sql, $db_perm_add_global_perms)) return false;

        }else {

            $sql = "INSERT INTO GROUP_PERMS (FID, PERM, GID, FORUM) ";
            $sql.= "VALUES ('0', '$perm', '$gid', '0')";

            if (!$result = db_query($sql, $db_perm_add_global_perms)) return false;
        }

        return true;

    }else {

        $sql = "INSERT INTO GROUPS (FORUM, AUTO_GROUP) VALUES (0, 1)";

        if ($result = db_query($sql, $db_perm_add_global_perms)) {

            $new_gid = db_insert_id($db_perm_add_global_perms);

            $sql = "INSERT INTO GROUP_PERMS (FID, PERM, GID, FORUM) ";
            $sql.= "VALUES ('0', '$perm', '$new_gid', '0')";

            if (!$result = db_query($sql, $db_perm_add_global_perms)) return false;

            $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
            $sql.= "VALUES ('$new_gid', '$uid')";

            if (!$result = db_query($sql, $db_perm_add_global_perms)) return false;

            return $new_gid;
        }
    }

    return false;
}

function perm_get_group_permissions($gid)
{
    if (!$db_perm_get_group_permissions = db_connect()) return false;

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "SELECT PERM FROM GROUP_PERMS WHERE GID = '$gid' AND FID = 0 ";
        $sql.= "AND FORUM = '$forum_fid'";

        if (!$result = db_query($sql, $db_perm_get_group_permissions)) return false;

        if (db_num_rows($result) > 0) {

            $permissions_data = db_fetch_array($result);
            return $permissions_data['PERM'];
        }

        return 0;
    }

    return false;
}

function perm_group_get_folders($gid)
{
    if (!$db_perm_get_group_folder_perms = db_connect()) return false;

    $folders_array = array();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "SELECT FOLDER.FID, FOLDER.TITLE, BIT_OR(GROUP_PERMS.PERM) AS GROUP_PERMS, ";
        $sql.= "COUNT(GROUP_PERMS.PERM) AS GROUP_PERM_COUNT, ";
        $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
        $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
        $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
        $sql.= "AND GROUP_PERMS.GID = '$gid' AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
        $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS  ON (FOLDER_PERMS.FID = FOLDER.FID ";
        $sql.= "AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
        $sql.= "GROUP BY FOLDER.FID ";
        $sql.= "ORDER BY FOLDER.FID";

        if (!$result = db_query($sql, $db_perm_get_group_folder_perms)) return false;

        if (db_num_rows($result) > 0) {

            while ($permissions_data = db_fetch_array($result)) {

                if ($permissions_data['GROUP_PERM_COUNT'] > 0) {

                    $folders_array[$permissions_data['FID']] = array('FID'          => $permissions_data['FID'],
                                                                     'TITLE'        => $permissions_data['TITLE'],
                                                                     'STATUS'       => $permissions_data['GROUP_PERMS'],
                                                                     'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']);

                }elseif ($permissions_data['FOLDER_PERM_COUNT'] > 0) {

                    $folders_array[$permissions_data['FID']] = array('FID'          => $permissions_data['FID'],
                                                                     'TITLE'        => $permissions_data['TITLE'],
                                                                     'STATUS'       => $permissions_data['FOLDER_PERMS'],
                                                                     'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']);
                }else {

                    $folders_array[$permissions_data['FID']] = array('FID'          => $permissions_data['FID'],
                                                                     'TITLE'        => $permissions_data['TITLE'],
                                                                     'STATUS'       => 0,
                                                                     'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']);
                }
            }

            return $folders_array;
        }

        return false;
    }
}

function perm_add_user_to_group($uid, $gid)
{
    if (!$db_perm_add_user_to_group = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (perm_is_group($gid)) {

        $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$gid', '$uid')";

        if (!$result = db_query($sql, $db_perm_add_user_to_group)) return false;
    }

    return true;
}

function perm_remove_user_from_group($uid, $gid)
{
    if (!$db_perm_remove_user_from_group = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (perm_is_group($gid)) {

        $sql = "DELETE QUICK FROM GROUP_USERS ";
        $sql.= "WHERE GID = '$gid' AND UID = '$uid'";

        if (!$result = db_query($sql, $db_perm_remove_user_from_group)) return false;
    }

    return true;
}

/**
* Fetches a user's permissions
*
* Retrieves the permissions of the user with UID = '$uid', stored using bitwise logic in
* a 32-bit integer. See constants.inc.php for the user permissions constants
*
* @see config.inc.php
* @return integer
* @param integer $uid UID of user to retrieve permissions for.
*/
function perm_get_user_permissions($uid)
{
    if (!$db_perm_get_user_permissions = db_connect()) return false;

    if (!is_numeric($uid)) return 0;

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS ";
    $sql.= "FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid)";

    if (!$result = db_query($sql, $db_perm_get_user_permissions)) return false;

    if (db_num_rows($result) > 0) {

        $permissions_data = db_fetch_array($result);
        return $permissions_data['STATUS'];
    }

    return 0;
}

function perm_get_forum_user_permissions($uid)
{
    if (!$db_perm_get_forum_user_permissions = db_connect()) return false;

    if (!is_numeric($uid)) return 0;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "LEFT JOIN GROUPS GROUPS ON (GROUPS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_perm_get_forum_user_permissions)) return false;

    if (db_num_rows($result) > 0) {

        $permissions_data = db_fetch_array($result);
        return $permissions_data['STATUS'];
    }

    return 0;
}

function perm_get_user_gid($uid)
{
    if (!$db_perm_get_user_gid = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT GROUPS.GID FROM GROUPS GROUPS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUPS.FORUM = '$forum_fid' ";
    $sql.= "AND GROUP_USERS.UID = '$uid'";

    if (!$result = db_query($sql, $db_perm_get_user_gid)) return false;

    if (db_num_rows($result) > 0) {

        $permissions_data = db_fetch_array($result);
        return $permissions_data['GID'];
    }

    return false;
}

function perm_get_global_user_gid($uid)
{
    if (!$db_perm_get_user_gid = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT GROUPS.GID FROM GROUPS GROUPS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUPS.FORUM = 0 ";
    $sql.= "AND GROUP_USERS.UID = '$uid'";

    if (!$result = db_query($sql, $db_perm_get_user_gid)) return false;

    if (db_num_rows($result) > 0) {

        $permissions_data = db_fetch_array($result);
        return $permissions_data['GID'];
    }

    return false;
}

function perm_user_get_folders($uid)
{
    if (!$db_perm_user_get_user_folders = db_connect()) return false;

    $folders_array = array();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = '$uid') ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.FID";

    if (!$result = db_query($sql, $db_perm_user_get_user_folders)) return false;

    if (db_num_rows($result) > 0) {

        while ($permissions_data = db_fetch_array($result)) {

            if ($permissions_data['USER_PERM_COUNT'] > 0) {

                $folders_array[$permissions_data['FID']] = array('FID'          => $permissions_data['FID'],
                                                                 'TITLE'        => $permissions_data['TITLE'],
                                                                 'STATUS'       => $permissions_data['USER_STATUS'],
                                                                 'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']);

            }elseif ($permissions_data['FOLDER_PERM_COUNT'] > 0) {

                $folders_array[$permissions_data['FID']] = array('FID'          => $permissions_data['FID'],
                                                                 'TITLE'        => $permissions_data['TITLE'],
                                                                 'STATUS'       => $permissions_data['FOLDER_PERMS'],
                                                                 'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']);
            }else {

                $folders_array[$permissions_data['FID']] = array('FID'          => $permissions_data['FID'],
                                                                 'TITLE'        => $permissions_data['TITLE'],
                                                                 'STATUS'       => 0,
                                                                 'FOLDER_PERMS' => $permissions_data['FOLDER_PERMS']);
            }
        }

        return $folders_array;
    }

    return false;
}

function perm_update_user_folder_perms($uid, $fid, $perm)
{
    if (!$db_perm_update_user_folder_perms = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if ($gid = perm_get_user_gid($uid)) {

        $sql = "SELECT GID FROM GROUP_PERMS WHERE GID = '$gid' ";
        $sql.= "AND FORUM = '$forum_fid' AND FID = '$fid' LIMIT 0, 1";

        if (!$result = db_query($sql, $db_perm_update_user_folder_perms)) return false;

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$perm' WHERE ";
            $sql.= "GID = '$gid' AND FORUM = '$forum_fid' AND FID = '$fid'";

            if (!$result = db_query($sql, $db_perm_update_user_folder_perms)) return false;

        }else {

            $sql = "INSERT INTO GROUP_PERMS (PERM, GID, FORUM, FID) ";
            $sql.= "VALUES ('$perm', '$gid', '$forum_fid', '$fid')";

            if (!$result = db_query($sql, $db_perm_update_user_folder_perms)) return false;
        }
    }

    return true;
}

function perm_update_group_folder_perms($gid, $fid, $perm)
{
    if (!$db_perm_update_group_folder_perms = db_connect()) return false;

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "SELECT GID FROM GROUP_PERMS WHERE GID = '$gid' ";
        $sql.= "AND FORUM = '$forum_fid' AND FID = '$fid' LIMIT 0, 1";

        if (!$result = db_query($sql, $db_perm_update_group_folder_perms)) return false;

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$perm' ";
            $sql.= "WHERE GID = '$gid' AND FID = '$fid' ";
            $sql.= "AND FORUM = '$forum_fid'";

            if (!$result = db_query($sql, $db_perm_update_group_folder_perms)) return false;

        }else {

            $sql = "INSERT INTO GROUP_PERMS (GID, FID, FORUM, PERM) ";
            $sql.= "VALUES ('$gid', '$fid', '$forum_fid', '$perm')";

            if (!$result = db_query($sql, $db_perm_update_group_folder_perms)) return false;
        }
    }

    return true;
}

function perm_update_user_permissions($uid, $perm)
{
    if (!$db_perm_update_user_permissions = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if ($gid = perm_get_user_gid($uid)) {

        $sql = "SELECT GID FROM GROUP_PERMS WHERE GID = '$gid' ";
        $sql.= "AND FORUM = '$forum_fid' AND FID = 0 LIMIT 0, 1";

        if (!$result = db_query($sql, $db_perm_update_user_permissions)) return false;

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$perm' WHERE ";
            $sql.= "GID = '$gid' AND FORUM = '$forum_fid' AND FID = 0";

            if (!$result = db_query($sql, $db_perm_update_user_permissions)) return false;

        }else {

            $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, PERM, FID) ";
            $sql.= "VALUES ('$gid', '$forum_fid', '$perm', '0')";

            if (!$result = db_query($sql, $db_perm_update_user_permissions)) return false;
        }

        return $gid;

    }else {

        $sql = "INSERT INTO GROUPS (FORUM, AUTO_GROUP) VALUES ($forum_fid, 1)";

        if ($result = db_query($sql, $db_perm_update_user_permissions)) {

            $new_gid = db_insert_id($db_perm_update_user_permissions);

            $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, PERM, FID) ";
            $sql.= "VALUES ('$new_gid', '$forum_fid', '$perm', '0')";

            if (!$result = db_query($sql, $db_perm_update_user_permissions)) return false;

            $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
            $sql.= "VALUES ('$new_gid', '$uid')";

            if (!$result = db_query($sql, $db_perm_update_user_permissions)) return false;

            return $new_gid;
        }
    }

    return false;
}

function perm_folder_get_permissions($fid)
{
    if (!$db_perm_folder_get_permissions = db_connect()) return false;

    if (!is_numeric($fid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT PERM AS STATUS FROM GROUP_PERMS ";
    $sql.= "WHERE FID = '$fid' AND GID = 0 AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_perm_folder_get_permissions)) return false;

    if (db_num_rows($result) > 0) {

        $permissions_data = db_fetch_array($result);
        if (!is_null($permissions_data['STATUS'])) return $permissions_data['STATUS'];
    }

    return false;
}

function perm_folder_reset_user_permissions($fid)
{
    if (!$db_perm_folder_reset_user_permissions = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Fetch the folder's permissions

    $folder_perms = perm_folder_get_permissions($fid);

    $upfm = USER_PERM_FOLDER_MODERATE;

    // Remove the permissions don't apply at the user to folder level

    $remove_perms = (double) USER_PERM_BANNED | USER_PERM_WORMED;
    $remove_perms = (double) $remove_perms | USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS;
    $remove_perms = (double) $remove_perms | USER_PERM_GUEST_ACCESS | USER_PERM_LINKS_MODERATE;
    $remove_perms = (double) $remove_perms | USER_PERM_EMAIL_CONFIRM | USER_PERM_CAN_IGNORE_ADMIN;
    $remove_perms = (double) $remove_perms | USER_PERM_PILLORIED;

    $folder_perms = $folder_perms ^ $remove_perms;

    // Process the permissions without affecting the user's
    // moderation level on the forum or the groups they're in.

    $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$folder_perms' | (PERM & $upfm) ";
    $sql.= "WHERE FID = '$fid' AND GID <> '0' AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_perm_folder_reset_user_permissions)) return false;

    return true;
}

function perm_group_get_users($gid, $offset = 0)
{
    if (!$db_perm_group_get_users = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($gid)) return 0;
    if (!is_numeric($offset)) $offset = 0;

    if (perm_is_group($gid)) {

        $group_user_array = array();

        $sql = "SELECT SQL_CALC_FOUND_ROWS GROUP_USERS.UID, ";
        $sql.= "USER.LOGON, USER.NICKNAME FROM GROUP_USERS ";
        $sql.= "LEFT JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
        $sql.= "WHERE GROUP_USERS.GID = '$gid' ";
        $sql.= "LIMIT $offset, 20";

        if (!$result = db_query($sql, $db_perm_group_get_users)) return false;

        // Fetch the number of total results

        $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

        if (!$result_count = db_query($sql, $db_perm_group_get_users)) return false;

        list($group_user_count) = db_fetch_array($result_count, DB_RESULT_NUM);

        if (db_num_rows($result) > 0) {

            while ($user_data = db_fetch_array($result)) {

                if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                    if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                        $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                    }
                }

                if (!isset($user_data['LOGON'])) $user_data['LOGON'] = $lang['unknownuser'];
                if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

                $group_user_array[] = $user_data;
            }

        }else if ($group_user_count > 0) {

            $offset = floor(($group_user_count - 1) / 10) * 10;
            return perm_group_get_users($gid, $offset);
        }

        return array('user_count' => $group_user_count,
                     'user_array' => $group_user_array);
    }

    return false;
}

function perm_user_apply_email_confirmation($uid)
{
    if (!$db_perm_user_apply_email_confirmation = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $perm = USER_PERM_EMAIL_CONFIRM;

    if ($gid = perm_get_global_user_gid($uid)) {

        $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = PERM | $perm ";
        $sql.= "WHERE GID = '$gid'";

        if (!$result = db_query($sql, $db_perm_user_apply_email_confirmation)) return false;

    }else {

        $sql = "INSERT INTO GROUPS (FORUM, AUTO_GROUP) VALUES (0, 1)";

        if ($result = db_query($sql, $db_perm_user_apply_email_confirmation)) {

            $new_gid = db_insert_id($db_perm_user_apply_email_confirmation);

            $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, PERM, FID) ";
            $sql.= "VALUES ('$new_gid', 0, '$perm', '0')";

            if (!$result = db_query($sql, $db_perm_user_apply_email_confirmation)) return false;

            $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
            $sql.= "VALUES ('$new_gid', '$uid')";

            if (!$result = db_query($sql, $db_perm_user_apply_email_confirmation)) return false;

            return true;
        }
    }

    return false;
}

function perm_user_cancel_email_confirmation($uid)
{
    if (!$db_perm_user_cancel_email_confirmation = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if ($gid = perm_get_global_user_gid($uid)) {

        $sql = "SELECT PERM FROM GROUP_PERMS WHERE GID = '$gid'";

        if (!$result = db_query($sql, $db_perm_user_cancel_email_confirmation)) return false;

        list($perm) = db_fetch_array($result, DB_RESULT_NUM);

        if ($perm & USER_PERM_EMAIL_CONFIRM) {
            $perm = $perm ^ USER_PERM_EMAIL_CONFIRM;
        }

        $sql = "UPDATE LOW_PRIORITY GROUP_PERMS SET PERM = '$perm' WHERE GID = '$gid'";

        if (!$result = db_query($sql, $db_perm_user_cancel_email_confirmation)) return false;
    }

    return true;
}

function perm_display_list($perms)
{
    $perms_array = array();

    $lang = load_language_file();

    if ($perms & USER_PERM_BANNED)           $perms_array[] = "B";
    if ($perms & USER_PERM_WORMED)           $perms_array[] = "W";
    if ($perms & USER_PERM_POST_READ)        $perms_array[] = "R";
    if ($perms & USER_PERM_POST_CREATE)      $perms_array[] = "W";
    if ($perms & USER_PERM_THREAD_CREATE)    $perms_array[] = "T";
    if ($perms & USER_PERM_POST_EDIT)        $perms_array[] = "E";
    if ($perms & USER_PERM_POST_DELETE)      $perms_array[] = "D";
    if ($perms & USER_PERM_POST_ATTACHMENTS) $perms_array[] = "A";
    if ($perms & USER_PERM_FOLDER_MODERATE)  $perms_array[] = "M";
    if ($perms & USER_PERM_ADMIN_TOOLS)      $perms_array[] = "A";
    if ($perms & USER_PERM_FORUM_TOOLS)      $perms_array[] = "F";
    if ($perms & USER_PERM_HTML_POSTING)     $perms_array[] = "H";
    if ($perms & USER_PERM_SIGNATURE)        $perms_array[] = "S";
    if ($perms & USER_PERM_GUEST_ACCESS)     $perms_array[] = "G";
    if ($perms & USER_PERM_POST_APPROVAL)    $perms_array[] = "V";

    if (sizeof($perms_array) > 0) {

        echo implode("", $perms_array);

    }else {

        echo $lang['none'];
    }
}

?>