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
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'myforums.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

function admin_add_log_entry($action, array $data = array())
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!is_numeric($action)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $data = $db->escape(base64_encode(serialize($data)));

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT UNIX_TIMESTAMP(MAX(CREATED)) FROM `{$table_prefix}ADMIN_LOG` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND ACTION = '$action' AND ENTRY = '$data'";

    if (!($result = $db->query($sql))) return false;

    list($created) = $result->fetch_array(MYSQLI_NUM);

    if ($created < (time() - HOUR_IN_SECONDS)) {

        $sql = "INSERT INTO `{$table_prefix}ADMIN_LOG` (CREATED, UID, ACTION, ENTRY) ";
        $sql .= "VALUES (CAST('$current_datetime' AS DATETIME), '{$_SESSION['UID']}', '$action', '$data')";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function admin_prune_log($remove_type, $remove_days)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($remove_type)) return false;
    if (!is_numeric($remove_days)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $remove_days_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($remove_days * DAY_IN_SECONDS));

    $sql = "DELETE QUICK FROM `{$table_prefix}ADMIN_LOG` ";
    $sql .= "WHERE CREATED < CAST('$remove_days_datetime' AS DATETIME) ";
    $sql .= "AND (ACTION = '$remove_type' OR '$remove_type' = 0)";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_get_log_entries($page = 1, $group_by = ADMIN_LOG_GROUP_NONE, $sort_by = 'CREATED', $sort_dir = 'DESC')
{
    if (!$db = db::get()) return false;

    $group_by_array = array(
        ADMIN_LOG_GROUP_NONE => 'ADMIN_LOG.ID',
        ADMIN_LOG_GROUP_YEAR => "DATE_FORMAT(ADMIN_LOG.CREATED, '%Y')",
        ADMIN_LOG_GROUP_MONTH => "DATE_FORMAT(ADMIN_LOG.CREATED, '%Y%m')",
        ADMIN_LOG_GROUP_DAY => "DATE_FORMAT(ADMIN_LOG.CREATED, '%Y%m%d')",
        ADMIN_LOG_GROUP_HOUR => "DATE_FORMAT(ADMIN_LOG.CREATED, '%Y%m%d%H')",
        ADMIN_LOG_GROUP_MINUTE => "DATE_FORMAT(ADMIN_LOG.CREATED, '%Y%m%d%H%i')",
        ADMIN_LOG_GROUP_SECOND => "DATE_FORMAT(ADMIN_LOG.CREATED, '%Y%m%d%H%i%s')",
    );

    $sort_by_array = array(
        'CREATED',
        'UID',
        'ACTION',
        'COUNT'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    $admin_log_array = array();

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!isset($group_by_array[$group_by])) $group_by = ADMIN_LOG_GROUP_NONE;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS ADMIN_LOG.ID, ADMIN_LOG.UID, ADMIN_LOG.ACTION, ";
    $sql .= "ADMIN_LOG.ENTRY, UNIX_TIMESTAMP(MAX(ADMIN_LOG.CREATED)) AS CREATED, ";
    $sql .= "{$group_by_array[$group_by]} AS GROUP_BY, COUNT(*) AS COUNT, ";
    $sql .= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
    $sql .= "FROM `{$table_prefix}ADMIN_LOG` ADMIN_LOG ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = ADMIN_LOG.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "GROUP BY GROUP_BY, ADMIN_LOG.UID, ADMIN_LOG.ACTION, ADMIN_LOG.ENTRY ";
    $sql .= "ORDER BY $sort_by $sort_dir ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($admin_log_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($admin_log_count > 0) && ($page > 1)) {
        return admin_get_log_entries($page - 1, $sort_by, $sort_dir);
    }

    while (($admin_log_data = $result->fetch_assoc()) !== null) {

        if (isset($admin_log_data['LOGON']) && isset($admin_log_data['PEER_NICKNAME'])) {
            if (!is_null($admin_log_data['PEER_NICKNAME']) && strlen($admin_log_data['PEER_NICKNAME']) > 0) {
                $admin_log_data['NICKNAME'] = $admin_log_data['PEER_NICKNAME'];
            }
        }

        if (!isset($admin_log_data['LOGON'])) $admin_log_data['LOGON'] = gettext("Unknown user");
        if (!isset($admin_log_data['NICKNAME'])) $admin_log_data['NICKNAME'] = "";

        $admin_log_data['ENTRY'] = unserialize(base64_decode($admin_log_data['ENTRY']));

        $admin_log_array[] = $admin_log_data;
    }

    return array(
        'admin_log_count' => $admin_log_count,
        'admin_log_array' => $admin_log_array
    );
}

function admin_get_word_filter_list($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    $word_filter_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, ";
    $sql .= "FILTER_TYPE, FILTER_ENABLED FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID = 0 ORDER BY FID ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($word_filter_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($word_filter_count > 0) && ($page > 1)) {
        return admin_get_word_filter_list($page - 1);
    }

    while (($word_filter_data = $result->fetch_assoc()) !== null) {
        $word_filter_array[$word_filter_data['FID']] = $word_filter_data;
    }

    return array(
        'word_filter_count' => $word_filter_count,
        'word_filter_array' => $word_filter_array
    );
}

function admin_get_word_filter($filter_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, ";
    $sql .= "FILTER_ENABLED FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID = 0 AND FID = '$filter_id' ORDER BY FID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $word_filter_array = $result->fetch_assoc();

    return $word_filter_array;
}

function admin_delete_word_filter($filter_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID = 0 AND FID = '$filter_id'";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_clear_word_filter()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}WORD_FILTER` WHERE UID = 0";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_add_word_filter($filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)
{
    if (!$db = db::get()) return false;

    $filter_name = $db->escape($filter_name);
    $match_text = $db->escape($match_text);
    $replace_text = $db->escape($replace_text);

    if (!is_numeric($filter_option)) $filter_option = WORD_FILTER_TYPE_ALL;
    if (!is_numeric($filter_enabled)) $filter_enabled = WORD_FILTER_ENABLED;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "INSERT INTO `{$table_prefix}WORD_FILTER` ";
    $sql .= "(UID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, FILTER_ENABLED) ";
    $sql .= "VALUES (0, '$filter_name', '$match_text', '$replace_text', '$filter_option', '$filter_enabled')";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_update_word_filter($filter_id, $filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!is_numeric($filter_option)) $filter_option = WORD_FILTER_TYPE_ALL;
    if (!is_numeric($filter_enabled)) $filter_enabled = WORD_FILTER_ENABLED;

    $filter_name = $db->escape($filter_name);
    $match_text = $db->escape($match_text);
    $replace_text = $db->escape($replace_text);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}WORD_FILTER` SET FILTER_NAME = '$filter_name', ";
    $sql .= "MATCH_TEXT = '$match_text', REPLACE_TEXT = '$replace_text', ";
    $sql .= "FILTER_TYPE = '$filter_option', FILTER_ENABLED = '$filter_enabled' ";
    $sql .= "WHERE UID = 0 AND FID = '$filter_id'";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_user_search($user_search, $sort_by = 'LAST_VISIT', $sort_dir = 'DESC', $filter = ADMIN_USER_FILTER_NONE, $page = 1)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'LOGON' => 'USER.LOGON',
        'LAST_VISIT' => 'USER_FORUM.LAST_VISIT',
        'REGISTERED' => 'USER.REGISTERED',
    );

    if (!in_array($sort_dir, array('ASC', 'DESC'))) $sort_dir = 'ASC';

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($filter)) $filter = ADMIN_USER_FILTER_NONE;

    $offset = calculate_page_offset($page, 10);

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    if (in_array($sort_by, array_keys($sort_by_array))) {
        $sort_by_array[$sort_by];
    } else {
        $sort_by = 'USER_FORUM.LAST_VISIT';
    }

    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    $user_get_all_array = array();

    $up_banned = USER_PERM_BANNED;

    $user_search = $db->escape(str_replace("%", "", $user_search));

    switch ($filter) {

        case ADMIN_USER_FILTER_ONLINE:

            $user_fetch_sql = "WHERE ACTIVE_SESSIONS.ID IS NOT NULL ";
            $user_fetch_sql .= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql .= "OR USER.NICKNAME LIKE '$user_search%') ";
            break;

        case ADMIN_USER_FILTER_OFFLINE:

            $user_fetch_sql = "WHERE ACTIVE_SESSIONS.ID IS NULL ";
            $user_fetch_sql .= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql .= "OR USER.NICKNAME LIKE '$user_search%') ";
            break;

        case ADMIN_USER_FILTER_APPROVAL:

            $user_fetch_sql = "WHERE USER.APPROVED IS NULL ";
            $user_fetch_sql .= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql .= "OR USER.NICKNAME LIKE '$user_search%') ";
            break;

        case ADMIN_USER_FILTER_BANNED:

            $user_fetch_sql = "WHERE PERMS.PERM & $up_banned > 0 ";
            $user_fetch_sql .= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql .= "OR USER.NICKNAME LIKE '$user_search%') ";
            break;

        default:

            $user_fetch_sql = "WHERE (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql .= "OR USER.NICKNAME LIKE '$user_search%') ";
            break;
    }

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "ACTIVE_SESSIONS.ID, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql .= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql .= "LEFT JOIN (SELECT ID, UID FROM SESSIONS WHERE UID > 0 AND TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "GROUP BY UID) AS ACTIVE_SESSIONS ON (ACTIVE_SESSIONS.UID = USER.UID) ";
    $sql .= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID AND USER_FORUM.FID = $forum_fid) ";
    $sql .= "LEFT JOIN (SELECT UID, BIT_OR(PERM) AS PERM FROM ((SELECT GROUP_USERS.UID, ";
    $sql .= "GROUPS.FORUM, GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM, ";
    $sql .= "COUNT(GROUP_PERMS.GID) AS PERM_COUNT FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) INNER JOIN GROUP_USERS ";
    $sql .= "ON (GROUP_USERS.GID = GROUPS.GID) WHERE GROUPS.FORUM = $forum_fid ";
    $sql .= "AND GROUP_PERMS.FID = 0 GROUP BY GROUP_USERS.UID, GROUPS.FORUM, GROUP_PERMS.FID ";
    $sql .= "HAVING PERM_COUNT > 0) UNION ALL (SELECT USER.UID, USER_PERM.FORUM, ";
    $sql .= "USER_PERM.FID, BIT_OR(USER_PERM.PERM) AS PERM, COUNT(USER_PERM.UID) AS PERM_COUNT ";
    $sql .= "FROM USER INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
    $sql .= "AND USER_PERM.FID = 0 GROUP BY USER.UID, USER_PERM.FORUM, USER_PERM.FID ";
    $sql .= "HAVING PERM_COUNT > 0)) AS USER_GROUP_PERMS GROUP BY UID) AS PERMS ";
    $sql .= "ON (PERMS.UID = USER_FORUM.UID) $user_fetch_sql GROUP BY USER.UID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_get_all_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($user_get_all_count > 0) && ($page > 1)) {
        return admin_user_get_all($sort_by, $sort_dir, $filter, $page - 1);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {
        $user_get_all_array[$user_data['UID']] = $user_data;
    }

    return array(
        'user_count' => $user_get_all_count,
        'user_array' => $user_get_all_array
    );
}

function admin_user_get_all($sort_by = 'LAST_VISIT', $sort_dir = 'ASC', $filter = ADMIN_USER_FILTER_NONE, $page = 1)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'LOGON' => 'USER.LOGON',
        'LAST_VISIT' => 'USER_FORUM.LAST_VISIT',
        'REGISTERED' => 'USER.REGISTERED',
        'ACTIVE' => 'ACTIVE_SESSIONS.ID'
    );

    if (!in_array($sort_dir, array('ASC', 'DESC'))) $sort_dir = 'ASC';

    if (!is_numeric($page) || ($page < 1)) $page = 1;
    if (!is_numeric($filter)) $filter = ADMIN_USER_FILTER_NONE;

    $offset = calculate_page_offset($page, 10);

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    if (in_array($sort_by, array_keys($sort_by_array))) {
        $sort_by = $sort_by_array[$sort_by];
    } else {
        $sort_by = 'USER_FORUM.LAST_VISIT';
    }

    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    $user_get_all_array = array();

    $up_banned = USER_PERM_BANNED;

    switch ($filter) {

        case ADMIN_USER_FILTER_ONLINE:
            $user_fetch_sql = "WHERE ACTIVE_SESSIONS.ID IS NOT NULL";

            break;

        case ADMIN_USER_FILTER_OFFLINE:
            $user_fetch_sql = "WHERE ACTIVE_SESSIONS.ID IS NULL";

            break;

        case ADMIN_USER_FILTER_APPROVAL:
            $user_fetch_sql = "WHERE USER.APPROVED IS NULL";

            break;

        case ADMIN_USER_FILTER_BANNED:
            $user_fetch_sql = "WHERE PERMS.PERM & $up_banned > 0";

            break;

        default:

            $user_fetch_sql = "";
            break;
    }

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "ACTIVE_SESSIONS.ID, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql .= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql .= "LEFT JOIN (SELECT ID, UID FROM SESSIONS WHERE UID > 0 AND TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "GROUP BY UID) AS ACTIVE_SESSIONS ON (ACTIVE_SESSIONS.UID = USER.UID) ";
    $sql .= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID AND USER_FORUM.FID = $forum_fid) ";
    $sql .= "LEFT JOIN (SELECT UID, BIT_OR(PERM) AS PERM FROM ((SELECT GROUP_USERS.UID, ";
    $sql .= "GROUPS.FORUM, GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM, ";
    $sql .= "COUNT(GROUP_PERMS.GID) AS PERM_COUNT FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) INNER JOIN GROUP_USERS ";
    $sql .= "ON (GROUP_USERS.GID = GROUPS.GID) WHERE GROUPS.FORUM = $forum_fid ";
    $sql .= "AND GROUP_PERMS.FID = 0 GROUP BY GROUP_USERS.UID, GROUPS.FORUM, GROUP_PERMS.FID ";
    $sql .= "HAVING PERM_COUNT > 0) UNION ALL (SELECT USER.UID, USER_PERM.FORUM, ";
    $sql .= "USER_PERM.FID, BIT_OR(USER_PERM.PERM) AS PERM, COUNT(USER_PERM.UID) AS PERM_COUNT ";
    $sql .= "FROM USER INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) WHERE USER_PERM.FORUM IN (0, $forum_fid) ";
    $sql .= "AND USER_PERM.FID = 0 GROUP BY USER.UID, USER_PERM.FORUM, USER_PERM.FID ";
    $sql .= "HAVING PERM_COUNT > 0)) AS USER_GROUP_PERMS GROUP BY UID) AS PERMS ";
    $sql .= "ON (PERMS.UID = USER_FORUM.UID) $user_fetch_sql GROUP BY USER.UID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_get_all_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($user_get_all_count > 0) && ($page > 1)) {
        return admin_user_get_all($sort_by, $sort_dir, $filter, $page - 1);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {
        $user_get_all_array[$user_data['UID']] = $user_data;
    }

    return array(
        'user_count' => $user_get_all_count,
        'user_array' => $user_get_all_array
    );
}

function admin_user_get($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($forum_fid = get_forum_fid())) {
        $forum_fid = 0;
    }

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL, ";
    $sql .= "USER.IPADDRESS, SESSIONS.ID, SESSIONS.REFERER AS SESSION_REFERER, ";
    $sql .= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql .= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql .= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID) ";
    $sql .= "LEFT JOIN USER_FORUM  ON (USER.UID = USER_FORUM.UID ";
    $sql .= "AND USER_FORUM.FID = '$forum_fid') WHERE USER.UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $admin_user_get = $result->fetch_assoc();

    return $admin_user_get;
}

function admin_session_end($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "DELETE QUICK FROM SESSIONS WHERE UID = '$uid' ";
    $sql .= "AND FID = '$forum_fid'";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_get_users_attachments($uid, &$user_attachments, &$user_image_attachments, $hash_array = false)
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($hash_array)) $hash_array = false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    if (is_array($hash_array)) {

        $hash_list = implode("', '", array_filter($hash_array, 'is_md5'));

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql .= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql .= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql .= "WHERE PAF.UID = '$uid' AND PAF.HASH IN ('$hash_list') ";
        $sql .= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    } else {

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql .= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql .= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql .= "WHERE PAF.UID = '$uid' ORDER BY FORUMS.FID DESC, PAF.FILENAME";
    }

    if (!($result = $db->query($sql))) return false;

    while (($attachment = $result->fetch_assoc()) !== null) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize += filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filesize" => $filesize,
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS'],
                    "forum_fid" => is_numeric($attachment['FID']) ? $attachment['FID'] : 0,
                    "forum_webtag" => $attachment['WEBTAG']
                );

            } else {

                $user_attachments[] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filesize" => filesize("$attachment_dir/{$attachment['HASH']}"),
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS'],
                    "forum_fid" => is_numeric($attachment['FID']) ? $attachment['FID'] : 0,
                    "forum_webtag" => $attachment['WEBTAG']
                );
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

function admin_get_forum_list($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    $sql = "SELECT SQL_CALC_FOUND_ROWS FORUMS.FID, FORUMS.WEBTAG, FORUMS.DEFAULT_FORUM, ";
    $sql .= "FORUMS.ACCESS_LEVEL, FORUM_SETTINGS.SVALUE AS FORUM_NAME FROM FORUMS ";
    $sql .= "LEFT JOIN FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID ";
    $sql .= "AND FORUM_SETTINGS.SNAME = 'forum_name') ";
    $sql .= "LIMIT $offset, 10 ";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($forums_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($forums_count > 0) && ($page > 1)) {
        return admin_get_forum_list($page - 1);
    }

    $forums_array = array();

    while (($forum_data = $result->fetch_assoc()) !== null) {

        if (!isset($forum_data['ACCESS_LEVEL'])) $forum_data['ACCESS_LEVEL'] = 0;

        if (($post_count = admin_forum_get_post_count($forum_data['FID'])) !== false) {
            $forum_data['MESSAGES'] = $post_count;
        }

        $forums_array[] = $forum_data;
    }

    return array(
        'forums_array' => $forums_array,
        'forums_count' => $forums_count
    );
}

function admin_forum_get_post_count($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = forum_get_table_prefix($fid))) return false;

    $sql = "SELECT COUNT(PID) FROM `{$table_prefix}POST`";

    if (!($result = $db->query($sql))) return false;

    list($post_count) = $result->fetch_row();

    return $post_count;
}

function admin_get_ban_data($sort_by = "ID", $sort_dir = "ASC", $page = 1)
{
    if (!$db = db::get()) return false;

    $sort_by_array = array(
        'ID',
        'BANTYPE',
        'BANDATA',
        'COMMENT',
        'EXPIRES'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'ID';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $ban_data_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS ID, BANTYPE, BANDATA, COMMENT, ";
    $sql .= "UNIX_TIMESTAMP(EXPIRES) AS EXPIRES FROM `{$table_prefix}BANNED` ";
    $sql .= "ORDER BY $sort_by $sort_dir ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($ban_data_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($ban_data_count > 0) && ($page > 1)) {
        return admin_get_ban_data($sort_by, $sort_dir, $page - 1);
    }

    while (($ban_data = $result->fetch_assoc()) !== null) {
        $ban_data_array[$ban_data['ID']] = $ban_data;
    }

    return array(
        'ban_count' => $ban_data_count,
        'ban_array' => $ban_data_array
    );
}

function admin_get_ban($ban_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ban_id)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT ID, BANTYPE, BANDATA, COMMENT, UNIX_TIMESTAMP(EXPIRES) AS EXPIRES, ";
    $sql .= "DAY(EXPIRES) AS EXPIRESDAY, MONTH(EXPIRES) AS EXPIRESMONTH, ";
    $sql .= "YEAR(EXPIRES) AS EXPIRESYEAR FROM `{$table_prefix}BANNED` ";
    $sql .= "WHERE ID = '$ban_id'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $ban_data_array = $result->fetch_assoc();

    return $ban_data_array;
}

function admin_user_approved($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT COUNT(UID) FROM USER WHERE APPROVED IS NOT NULL AND UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    list($user_approved_count) = $result->fetch_row();

    return $user_approved_count > 0;
}

function admin_get_post_approval_queue($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $fidlist = array();

    if (($folder_list = session::get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) !== false) {
        $fidlist = implode(',', $folder_list);
    }

    $post_approval_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.TITLE AS FOLDER_TITLE, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE, ";
    $sql .= "USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, ";
    $sql .= "CONCAT(POST.TID, '.', POST.PID) AS MSG FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE POST.APPROVED IS NULL AND THREAD.FID IN ($fidlist) ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($post_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($post_count > 0) && ($page > 1)) {
        return admin_get_post_approval_queue($page - 1);
    }

    while (($post_array = $result->fetch_assoc()) !== null) {
        $post_approval_array[] = $post_array;
    }

    return array(
        'post_count' => $post_count,
        'post_array' => $post_approval_array
    );
}

function admin_get_link_approval_queue($page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 0;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!session::check_perm(USER_PERM_LINKS_MODERATE, 0)) return false;

    $link_approval_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS LINKS_FOLDERS.NAME AS FOLDER_TITLE, ";
    $sql .= "LINKS.LID, LINKS.URI, LINKS.TITLE, LINKS.DESCRIPTION, USER.UID, ";
    $sql .= "USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(LINKS.CREATED) AS CREATED ";
    $sql .= "FROM `{$table_prefix}LINKS` LINKS LEFT JOIN USER USER ON (USER.UID = LINKS.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}LINKS_FOLDERS` LINKS_FOLDERS ON (LINKS_FOLDERS.FID = LINKS.FID) ";
    $sql .= "WHERE LINKS.APPROVED IS NULL ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($link_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($link_count > 0) && ($page > 1)) {
        return admin_get_link_approval_queue($page - 1);
    }

    while (($link_array = $result->fetch_assoc()) !== null) {
        $link_approval_array[] = $link_array;
    }

    return array(
        'link_count' => $link_count,
        'link_array' => $link_approval_array
    );
}

function admin_get_visitor_log($page = 1, $group_by = ADMIN_VISITOR_LOG_GROUP_NONE, $sort_by = 'LAST_LOGON', $sort_dir = 'DESC')
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 0;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $group_by_array = array(
        ADMIN_VISITOR_LOG_GROUP_NONE => 'VISITOR_LOG.VID',
        ADMIN_VISITOR_LOG_GROUP_IP => 'VISITOR_LOG.IPADDRESS',
        ADMIN_VISITOR_LOG_GROUP_REFERER => 'VISITOR_LOG.REFERER',
        ADMIN_VISITOR_LOG_GROUP_USER_AGENT => 'VISITOR_LOG.USER_AGENT'
    );

    $sort_by_array = array(
        'LOGON',
        'LAST_LOGON',
        'IPADDRESS',
        'REFERER',
        'USER_AGENT',
        'COUNT'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    $users_get_recent_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!isset($group_by_array[$group_by])) $group_by = ADMIN_LOG_GROUP_NONE;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    $sql = "SELECT SQL_CALC_FOUND_ROWS VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql .= "VISITOR_LOG.IPADDRESS, VISITOR_LOG.REFERER, VISITOR_LOG.USER_AGENT, ";
    $sql .= "{$group_by_array[$group_by]} AS GROUP_BY, COUNT(*) AS COUNT, ";
    $sql .= "SEB.SID, SEB.NAME, SEB.URL FROM VISITOR_LOG VISITOR_LOG ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN SEARCH_ENGINE_BOTS SEB ON (SEB.SID = VISITOR_LOG.SID) ";
    $sql .= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
    $sql .= "AND VISITOR_LOG.FORUM = '$forum_fid' GROUP BY GROUP_BY ";
    $sql .= "ORDER BY $sort_by $sort_dir ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($users_get_recent_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($users_get_recent_count > 0) && ($page > 1)) {
        return admin_get_visitor_log($page - 1);
    }

    while (($visitor_array = $result->fetch_assoc()) !== null) {

        if (isset($visitor_array['LOGON']) && isset($visitor_array['PEER_NICKNAME'])) {
            if (!is_null($visitor_array['PEER_NICKNAME']) && strlen($visitor_array['PEER_NICKNAME']) > 0) {
                $visitor_array['NICKNAME'] = $visitor_array['PEER_NICKNAME'];
            }
        }

        if ($visitor_array['UID'] == 0) {

            $visitor_array['LOGON'] = gettext("Guest");
            $visitor_array['NICKNAME'] = gettext("Guest");

        } else if (!isset($visitor_array['LOGON']) || is_null($visitor_array['LOGON'])) {

            $visitor_array['LOGON'] = gettext("Unknown user");
            $visitor_array['NICKNAME'] = "";
        }

        if (isset($visitor_array['REFERER']) && strlen(trim($visitor_array['REFERER'])) > 0) {

            $forum_uri_preg = preg_quote(html_get_forum_uri(), '/');

            if (preg_match("/^$forum_uri_preg/iu", trim($visitor_array['REFERER'])) > 0) {
                $visitor_array['REFERER'] = "";
            }

        } else {

            $visitor_array['REFERER'] = "";
        }

        $users_get_recent_array[] = $visitor_array;
    }

    return array(
        'user_count' => $users_get_recent_count,
        'user_array' => $users_get_recent_array
    );
}

function admin_prune_visitor_log($remove_days)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($remove_days)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $remove_days_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($remove_days * DAY_IN_SECONDS));

    $sql = "DELETE QUICK FROM VISITOR_LOG WHERE FORUM = '$forum_fid' ";
    $sql .= "AND LAST_LOGON < CAST('$remove_days_datetime' AS DATETIME)";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_get_user_ip_matches($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $user_ip_address_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT DISTINCT IPADDRESS FROM `{$table_prefix}POST` ";
    $sql .= "WHERE FROM_UID = '$uid' AND IPADDRESS IS NOT NULL LIMIT 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_get_aliases_row = $result->fetch_assoc()) !== null) {

        if (strlen(trim($user_get_aliases_row['IPADDRESS'])) > 0) {
            $user_ip_address_array[] = $user_get_aliases_row['IPADDRESS'];
        }
    }

    if (($ipaddress = user_get_last_ip_address($uid)) !== false) {
        $user_ip_address_array[] = $ipaddress;
    }

    if (sizeof($user_ip_address_array) == 0) return false;

    $user_ip_address_list = implode("', '", $user_ip_address_array);

    $sql = "SELECT DISTINCT POST.FROM_UID AS UID, USER.LOGON, ";
    $sql .= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, POST.IPADDRESS ";
    $sql .= "FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN USER USER ON (POST.FROM_UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}RSS_FEEDS` RSS_FEEDS ";
    $sql .= "ON (RSS_FEEDS.UID = USER.UID) WHERE POST.FROM_UID <> $uid ";
    $sql .= "AND ((POST.IPADDRESS IN ('$user_ip_address_list')) ";
    $sql .= "OR (USER.IPADDRESS IN ('$user_ip_address_list'))) ";
    $sql .= "AND RSS_FEEDS.UID IS NOT NULL ";
    $sql .= "LIMIT 0, 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_aliases_array = array();

    while (($user_aliases = $result->fetch_assoc()) !== null) {

        if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
            if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
            }
        }

        if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = gettext("Unknown user");
        if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

        $user_aliases_array[$user_aliases['UID']] = $user_aliases;
    }

    return $user_aliases_array;
}

function admin_get_user_email_matches($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    // Initialise array
    $user_email_aliases_array = array();

    // Session UID
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Get the user's email address
    $user_email_address = user_get_email($uid);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, USER.EMAIL FROM USER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE (USER.EMAIL = '$user_email_address') ";
    $sql .= "AND USER.UID <> $uid LIMIT 0, 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_aliases = $result->fetch_assoc()) !== null) {

        if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
            if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
            }
        }

        if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = gettext("Unknown user");
        if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

        $user_email_aliases_array[$user_aliases['UID']] = $user_aliases;
    }

    return $user_email_aliases_array;
}

function admin_get_user_referer_matches($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $user_referer_aliases_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $user_http_referer = user_get_referer($uid);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, USER.REFERER FROM USER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE USER.REFERER = '$user_http_referer' ";
    $sql .= "AND USER.UID <> $uid LIMIT 0, 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_aliases = $result->fetch_assoc()) !== null) {

        if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
            if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
            }
        }

        if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = gettext("Unknown user");
        if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

        $user_referer_aliases_array[$user_aliases['UID']] = $user_aliases;
    }

    return $user_referer_aliases_array;
}

function admin_get_user_passwd_matches($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    // Initialise array
    $user_passwd_aliases_array = array();

    // Session UID
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Get the user's email address
    $user_passwd = user_get_passwd($uid);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, USER.PASSWD FROM USER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE (USER.PASSWD = '$user_passwd') ";
    $sql .= "AND USER.UID <> $uid LIMIT 0, 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_aliases = $result->fetch_assoc()) !== null) {

        if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
            if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
            }
        }

        if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = gettext("Unknown user");
        if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

        $user_passwd_aliases_array[$user_aliases['UID']] = $user_aliases;
    }

    return $user_passwd_aliases_array;
}

function admin_get_user_history($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $user_history_array = array();

    $sql = "SELECT LOGON, NICKNAME, EMAIL FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($logon, $nickname, $email) = $result->fetch_row();

    $sql = "SELECT LOGON, NICKNAME, EMAIL, UNIX_TIMESTAMP(MODIFIED) ";
    $sql .= "FROM USER_HISTORY WHERE UID = '$uid' ";
    $sql .= "ORDER BY MODIFIED DESC LIMIT 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_history_data_old = '';

    $user_history_data = '';

    while (($user_history_row = $result->fetch_row()) !== null) {

        $user_history_data_array = array();

        list($logon_old, $nickname_old, $email_old, $modified_date) = $user_history_row;

        if ($logon != $logon_old) {
            $user_history_data_array[] = sprintf(gettext("Changed Logon from %s to %s"), $logon_old, $logon);
        }

        if ($nickname != $nickname_old) {
            $user_history_data_array[] = sprintf(gettext("Changed Nickname from %s to %s"), $nickname_old, $nickname);
        }

        if ($email != $email_old) {
            $user_history_data_array[] = sprintf(gettext("Changed Email from %s to %s"), $email_old, $email);
        }

        if (sizeof($user_history_data_array) > 0) {

            $user_history_data = implode(". ", $user_history_data_array);

            if ($user_history_data != $user_history_data_old) {

                $user_history_array[] = array(
                    'MODIFIED' => $modified_date,
                    'DATA' => $user_history_data
                );
            }
        }

        list($logon, $nickname, $email) = $user_history_row;

        $user_history_data_old = $user_history_data;
    }

    return $user_history_array;
}

function admin_clear_user_history($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "DELETE QUICK FROM USER_HISTORY WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}

function admin_approve_user($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY USER SET APPROVED = CAST('$current_datetime' AS DATETIME) ";
    $sql .= "WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    return ($db->affected_rows > 0);
}

function admin_delete_user($uid, $delete_content = false)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_bool($delete_content)) $delete_content = false;

    $current_datetime = date(MYSQL_DATETIME, time());

    // Mark as read cut off
    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    // UID of current user
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Before we delete we verify the user account exists and that
    // the user is not the current user account.
    if (($user_logon = user_get_logon($uid)) && ($_SESSION['UID'] != $uid)) {

        // Check to see if we're also deleting the user's content.
        if ($delete_content === true) {

            // Get a list of available forums
            if (($forum_table_prefix_array = forum_get_all_prefixes()) !== false) {

                // Loop through all forums and delete all the user data from every forum.
                foreach ($forum_table_prefix_array as $forum_table_prefix) {

                    // Delete log entries created by the user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}ADMIN_LOG` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Links created by the user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}LINKS` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Link Votes made by the user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}LINKS_VOTE` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Link Comments made by the user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}LINKS_COMMENT` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Poll Votes made by the user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_POLL_VOTES` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Relationship data for the user and relationships
                    // with this user made by other users.
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_PEER` WHERE UID = '$uid' OR PEER_UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete folder preferences set by the user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_FOLDER` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete User's Preferences
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_PREFS` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete User's Profile.
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_PROFILE` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete User's Signature
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_SIG` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete User's Thread Read Data
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_THREAD` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete User's Tracking data (Post Count, etc.)
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_TRACK` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Word Filter Entries made by user
                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}WORD_FILTER` WHERE UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete Polls created by user
                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}THREAD` SET POLL_FLAG = 'N', ";
                    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
                    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) WHERE BY_UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Delete threads started by the user where
                    // the thread only contains a single post.
                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}THREAD` SET DELETED = 'Y', ";
                    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
                    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) WHERE BY_UID = '$uid' ";
                    $sql .= "AND LENGTH = 1";

                    if (!$db->query($sql)) return false;

                    // Delete content of posts made by this user
                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}POST_CONTENT` POST_CONTENT ";
                    $sql .= "LEFT JOIN `{$forum_table_prefix}POST` POST ON (POST.TID = POST_CONTENT.TID ";
                    $sql .= "AND POST.PID = POST_CONTENT.PID) SET POST_CONTENT.CONTENT = NULL ";
                    $sql .= "WHERE POST.FROM_UID = '$uid'";

                    if (!$db->query($sql)) return false;

                    // Mark posts made by this user as approved so they don't appear in the
                    // approval queue.
                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}POST` ";
                    $sql .= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
                    $sql .= "APPROVED_BY = '{$_SESSION['UID']}' WHERE FROM_UID = '$uid'";

                    if (!$db->query($sql)) return false;
                }
            }

            // Delete User Group Entries related to this user.
            $sql = "DELETE QUICK FROM GROUP_USERS WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Remove all PM_TYPE records
            $sql = "DELETE QUICK FROM PM_TYPE WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Remove all PM_RECIPIENT records
            $sql = "DELETE QUICK FROM PM_RECIPIENT WHERE TO_UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete any PMs from this user.
            $sql = "DELETE QUICK FROM PM WHERE FROM_UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Remove any PMs that have no recipients.
            $sql = "DELETE QUICK FROM PM, PM_CONTENT USING PM ";
            $sql .= "LEFT JOIN PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
            $sql .= "LEFT JOIN PM_RECIPIENT ON (PM_RECIPIENT.MID = PM.MID) ";
            $sql .= "LEFT JOIN PM_TYPE ON (PM_TYPE.MID = PM.MID) ";
            $sql .= "WHERE PM_TYPE.MID IS NULL OR PM_RECIPIENT.MID IS NULL";

            if (!$db->query($sql)) return false;

            // Delete all the attachments uploaded by the user.
            $sql = "SELECT HASH FROM POST_ATTACHMENT_FILES WHERE UID = '$uid'";

            if (!($result = $db->query($sql))) return false;

            while (($attachment_data = $result->fetch_assoc()) !== null) {
                attachments_delete($attachment_data['HASH']);
            }

            // Delete User's PM Search Results
            $sql = "DELETE QUICK FROM PM_SEARCH_RESULTS WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Attachments (doesn't remove the physical files).
            $sql = "DELETE QUICK FROM POST_ATTACHMENT_FILES WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Search Results.
            $sql = "DELETE QUICK FROM SEARCH_RESULTS WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Sessions
            $sql = "DELETE QUICK FROM SESSIONS WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Forum Preferences and Permissions
            $sql = "DELETE QUICK FROM USER_FORUM WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's History Data (Logon, Nickname, Email address changes)
            $sql = "DELETE QUICK FROM USER_HISTORY WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Global Preferences
            $sql = "DELETE QUICK FROM USER_PERM WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Global Preferences
            $sql = "DELETE QUICK FROM USER_PREFS WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Delete User's Visitor Log Data
            $sql = "DELETE QUICK FROM VISITOR_LOG WHERE UID = '$uid'";

            if (!$db->query($sql)) return false;

            // Add a log entry to show what we've done.
            admin_add_log_entry(DELETE_USER_DATA, array($uid, $user_logon));
        }

        // Delete the User account.
        $sql = "DELETE QUICK FROM USER WHERE UID = '$uid'";

        if (!$db->query($sql)) return false;

        // Add a log entry to show what we've done.
        admin_add_log_entry(DELETE_USER, array($user_logon));

        return true;
    }

    return false;
}

function admin_delete_users_posts($uid)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($uid)) return false;

    $sql = "INSERT INTO `{$table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql .= "SELECT TID, PID, NULL FROM `{$table_prefix}POST` WHERE FROM_UID = '$uid' ";
    $sql .= "ON DUPLICATE KEY UPDATE CONTENT = VALUES(CONTENT)";

    if (!$db->query($sql)) return false;

    return true;
}

function admin_prepare_affected_sessions($affected_session)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if ($affected_session['UID'] > 0) {

        $affected_session_text = sprintf(
            '<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500">%s</a>',
            urlencode($webtag),
            urlencode($affected_session['UID']),
            word_filter_add_ob_tags(format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), true)
        );

    } else {

        $affected_session_text = sprintf(
            ngettext('%s Guest', '%s Guests', $affected_session['SESSION_COUNT']),
            $affected_session['SESSION_COUNT']
        );
    }

    return $affected_session_text;
}

function admin_send_user_approval_notification($new_user_uid)
{
    if (!$db = db::get()) return false;

    $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;

    $notification_success = false;

    $sql = "SELECT DISTINCT USER_PERM.UID, BIT_OR(USER_PERM.PERM) AS PERM ";
    $sql .= "FROM USER INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM = 0 GROUP BY USER.UID ";
    $sql .= "HAVING PERM & $user_perm_admin_tools > 0";

    if (!($result = $db->query($sql))) return false;

    while (($admin_data = $result->fetch_assoc()) !== null) {

        if (email_send_user_approval_notification($admin_data['UID'], $new_user_uid)) {
            $notification_success = true;
        }
    }

    return $notification_success;
}

function admin_send_new_user_notification($new_user_uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($new_user_uid)) return false;

    $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;

    $notification_success = false;

    $sql = "SELECT DISTINCT USER_PERM.UID, BIT_OR(USER_PERM.PERM) AS PERM ";
    $sql .= "FROM USER INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM = 0 GROUP BY USER.UID ";
    $sql .= "HAVING PERM & $user_perm_admin_tools > 0";

    if (!($result = $db->query($sql))) return false;

    while (($admin_data = $result->fetch_assoc()) !== null) {

        if (email_send_new_user_notification($admin_data['UID'], $new_user_uid)) {
            $notification_success = true;
        }
    }

    return $notification_success;
}

function admin_send_post_approval_notification($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;

    $notification_success = false;

    $sql = "(SELECT DISTINCT GROUP_USERS.UID, BIT_OR(GROUP_PERMS.PERM) AS PERM ";
    $sql .= "FROM GROUPS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql .= "WHERE GROUPS.FORUM = $forum_fid AND GROUP_PERMS.FID = $fid ";
    $sql .= "GROUP BY GROUP_USERS.UID HAVING PERM & $user_perm_folder_moderate > 0) ";
    $sql .= "UNION (SELECT DISTINCT USER_PERM.UID, BIT_OR(USER_PERM.PERM) AS PERM ";
    $sql .= "FROM USER INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM IN (0, $forum_fid) AND USER_PERM.FID = $fid ";
    $sql .= "GROUP BY USER.UID HAVING PERM & $user_perm_folder_moderate > 0)";

    if (!($result = $db->query($sql))) return false;

    while (($admin_data = $result->fetch_assoc()) !== null) {

        if (email_send_post_approval_notification($admin_data['UID'])) {
            $notification_success = true;
        }
    }

    return $notification_success;
}

function admin_send_link_approval_notification()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_perm_links_moderate = USER_PERM_LINKS_MODERATE;

    $notification_success = false;

    $sql = "(SELECT DISTINCT GROUP_USERS.UID, BIT_OR(GROUP_PERMS.PERM) AS PERM ";
    $sql .= "FROM GROUPS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql .= "INNER JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql .= "WHERE GROUPS.FORUM = $forum_fid GROUP BY GROUP_USERS.UID ";
    $sql .= "HAVING PERM & $user_perm_links_moderate > 0) ";
    $sql .= "UNION (SELECT DISTINCT USER_PERM.UID, BIT_OR(USER_PERM.PERM) AS PERM ";
    $sql .= "FROM USER INNER JOIN USER_PERM ON (USER_PERM.UID = USER.UID) ";
    $sql .= "WHERE USER_PERM.FORUM IN (0, $forum_fid) GROUP BY USER.UID ";
    $sql .= "HAVING PERM & $user_perm_links_moderate > 0)";

    if (!($result = $db->query($sql))) return false;

    while (($admin_data = $result->fetch_assoc()) !== null) {

        if (email_send_link_approval_notification($admin_data['UID'])) {
            $notification_success = true;
        }
    }

    return $notification_success;
}

function admin_reset_user_password($uid, $password)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $salt = user_password_salt();

    $passhash = user_password_encrypt($password, $salt);

    $salt = $db->escape($salt);

    $passhash = $db->escape($passhash);

    $sql = "UPDATE USER SET PASSWD = '$passhash', SALT = '$salt' ";
    $sql .= "WHERE UID = '$uid'";

    if (!($db->query($sql))) return false;

    return true;
}

function admin_check_credentials()
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (isset($_SESSION['ADMIN_TIMEOUT']) && is_numeric($_SESSION['ADMIN_TIMEOUT']) && ($_SESSION['ADMIN_TIMEOUT'] > time())) {

        $_SESSION['ADMIN_TIMEOUT'] = time() + HOUR_IN_SECONDS;
        return true;
    }

    if (isset($_POST['admin_logon']) && isset($_POST['admin_password'])) {

        $admin_logon = $_POST['admin_logon'];

        $admin_password = $_POST['admin_password'];

        if (($admin_uid = user_logon($admin_logon, $admin_password)) && ($admin_uid == $_SESSION['UID'])) {

            $_SESSION['ADMIN_TIMEOUT'] = time() + HOUR_IN_SECONDS;
            return true;

        } else {

            html_display_error_msg(gettext("The username or password you supplied are not valid."), '500', 'center');
        }
    }

    html_draw_top(
        array(
            'main_css' => 'admin.css'
        )
    );

    if (isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) {
        html_display_warning_msg(gettext('To save any changes you must re-authenticate yourself'), '500', 'center');
    } else {
        html_display_warning_msg(gettext('To access the Admin area you must re-authenticate yourself'), '500', 'center');
    }

    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"logonform\" method=\"post\" action=\"", get_request_uri(), "\" target=\"", html_get_frame_name('main'), "\" autocomplete=\"off\">\n";

    if (isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) {
        echo form_input_hidden_array($_POST);
    }

    echo "    ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "    <br />\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"325\">\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">\n";
    echo "          <table class=\"box\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td align=\"left\" class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\" class=\"subhead\">", gettext("Please enter your password"), "</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"center\">\n";
    echo "                      <table class=\"posthead\" width=\"95%\">\n";
    echo "                        <tr>\n";
    echo "                          <td align=\"right\" width=\"90\">", gettext("Username"), ":</td>\n";
    echo "                          <td align=\"left\">", form_input_text('admin_logon', null, 24, 32, null, 'bhinputlogon'), "</td>\n";
    echo "                        </tr>\n";
    echo "                        <tr>\n";
    echo "                          <td align=\"right\" width=\"90\">", gettext("Password"), ":</td>\n";
    echo "                          <td align=\"left\">", form_input_password('admin_password', null, 24, 32, null, 'bhinputlogon'), "</td>\n";
    echo "                        </tr>\n";
    echo "                        <tr>\n";
    echo "                          <td align=\"left\">&nbsp;</td>\n";
    echo "                        </tr>\n";
    echo "                      </table>\n";
    echo "                    </td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">&nbsp;</td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"center\" colspan=\"2\">", form_submit('logon', gettext("Logon")), "</td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;
}