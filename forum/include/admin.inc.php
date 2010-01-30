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

/* $Id: admin.inc.php,v 1.195 2010/01/10 14:26:25 decoyduck Exp $ */

/**
* admin.inc.php - admin functions
*
* Contains admin related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

/**
* Add log entry
*
* Adds an entry to the ADMIN_LOG table.
*
* @return bool
* @param integer $action - Action ID (see constants.inc.php)
* @param mixed $data - Data to insert into the log. Can be an array or string.
*/

function admin_add_log_entry($action, $data = "")
{
    if (!$db_admin_add_log_entry = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($action)) return false;

    if (is_array($data)) $data = implode("\x00", preg_replace('/[\x00]+/u', '', $data));

    $data = db_escape_string($data);

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}ADMIN_LOG` (CREATED, UID, ACTION, ENTRY) ";
    $sql.= "VALUES (CAST('$current_datetime' AS DATETIME), '$uid', '$action', '$data')";

    if (!db_query($sql, $db_admin_add_log_entry)) return false;

    return true;
}

/**
* Clears admin log
*
* Clears the forum admin log
*
* @return bool
* @param integer $remove_type - Action ID (see constants.inc.php) type to remove. (0 = All)
* @param mixed $remove_days - Remove entries older than days.
*/

function admin_prune_log($remove_type, $remove_days)
{
    if (!$db_admin_clearlog = db_connect()) return false;

    if (!is_numeric($remove_type)) return false;
    if (!is_numeric($remove_days)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $remove_days_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($remove_days * DAY_IN_SECONDS));

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}ADMIN_LOG` ";
    $sql.= "WHERE CREATED < CAST('$remove_days_datetime' AS DATETIME) ";
    $sql.= "AND (ACTION = '$remove_type' OR '$remove_type' = 0)";

    if (!db_query($sql, $db_admin_clearlog)) return false;

    return true;
}

/**
* Fetches admin log entries
*
* Fetches the available admin log entries into an array
*
* @return array
* @param integer $offset - Offset of the rows returned by the query
* @param string $sort_by - Column to sort the results by
* @param string $sort_dir - Direction to sort the results by
*/

function admin_get_log_entries($offset, $sort_by = 'CREATED', $sort_dir = 'DESC')
{
    if (!$db_admin_get_log_entries = db_connect()) return false;

    $lang = load_language_file();

    $sort_by_array  = array('CREATED', 'UID', 'ACTION');
    $sort_dir_array = array('ASC', 'DESC');

    $admin_log_array = array();

    if (!is_numeric($offset)) $offset = 0;

    // Ensure offset is positive.

    $offset = abs($offset);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS ADMIN_LOG.ID, ADMIN_LOG.UID, ADMIN_LOG.ACTION, ADMIN_LOG.ENTRY, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(ADMIN_LOG.CREATED) AS CREATED ";
    $sql.= "FROM `{$table_data['PREFIX']}ADMIN_LOG` ADMIN_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = ADMIN_LOG.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "ORDER BY ADMIN_LOG.$sort_by $sort_dir LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_log_entries)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_get_log_entries)) return false;

    list($admin_log_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($admin_log_entry = db_fetch_array($result))) {

            if (isset($admin_log_entry['LOGON']) && isset($admin_log_entry['PEER_NICKNAME'])) {
                if (!is_null($admin_log_entry['PEER_NICKNAME']) && strlen($admin_log_entry['PEER_NICKNAME']) > 0) {
                    $admin_log_entry['NICKNAME'] = $admin_log_entry['PEER_NICKNAME'];
                }
            }

            if (!isset($admin_log_entry['LOGON'])) $admin_log_entry['LOGON'] = $lang['unknownuser'];
            if (!isset($admin_log_entry['NICKNAME'])) $admin_log_entry['NICKNAME'] = "";

            $admin_log_array[] = $admin_log_entry;
        }

    }else if ($admin_log_count > 0) {

        $offset = floor(($admin_log_count - 1) / 10) * 10;
        return admin_get_log_entries($offset, $sort_by, $sort_dir);
    }

    return array('admin_log_count' => $admin_log_count,
                 'admin_log_array' => $admin_log_array);
}

/**
* Fetches admin word filter list
*
* Fetches the available word filter entries into an array
*
* @return array
* @param integer $offset - Offset for results
*/

function admin_get_word_filter_list($offset)
{
    if (!$db_admin_get_word_filter = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;

    // Ensure offset is positive.

    $offset = abs($offset);

    $word_filter_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, ";
    $sql.= "FILTER_TYPE, FILTER_ENABLED FROM `{$table_data['PREFIX']}WORD_FILTER` ";
    $sql.= "WHERE UID = 0 ORDER BY FID ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_word_filter)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_get_word_filter)) return false;

    list($word_filter_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($word_filter_data = db_fetch_array($result))) {

            $word_filter_array[$word_filter_data['FID']] = $word_filter_data;
        }

    }else if ($word_filter_count > 0) {

        $offset = floor(($word_filter_count - 1) / 10) * 10;
        return admin_get_word_filter_list($offset);
    }

    return array('word_filter_count' => $word_filter_count,
                 'word_filter_array' => $word_filter_array);
}

/**
* Fetches specified admin word filter
*
* Fetches the specified admin word filter entry data.
*
* @return mixed - array on success, false on failure.
* @param integer $filter_id - Word Filter entry to retrieve from database.
*/

function admin_get_word_filter($filter_id)
{
    if (!$db_admin_get_word_filter = db_connect()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, ";
    $sql.= "FILTER_ENABLED FROM `{$table_data['PREFIX']}WORD_FILTER` ";
    $sql.= "WHERE UID = 0 AND FID = '$filter_id' ORDER BY FID";

    if (!$result = db_query($sql, $db_admin_get_word_filter)) return false;

    if (db_num_rows($result) > 0) {

        $word_filter_array = db_fetch_array($result);
        return $word_filter_array;
    }

    return false;
}

/**
* Delete an entry in the word filter
*
* Fetches the available attachments based on the provided parameters that match $aid
*
* @return bool
* @param integer $id - Filter entry ID
*/

function admin_delete_word_filter($filter_id)
{
    if (!$db_user_delete_word_filter = db_connect()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}WORD_FILTER` ";
    $sql.= "WHERE UID = 0 AND FID = '$filter_id'";

    if (!db_query($sql, $db_user_delete_word_filter)) return false;

    return true;
}

/**
* Clear admin word filter
*
* Removes all word filter entries from the admin defined word filter
*
* @return bool
* @param void
*/

function admin_clear_word_filter()
{
    if (!$db_admin_clear_word_filter = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}WORD_FILTER` WHERE UID = 0";

    if (!db_query($sql, $db_admin_clear_word_filter)) return false;

    return true;
}

/**
* Add entry to admin word filter
*
* Adds an entry to the admin defined word filter
*
* @return bool
* @param string $match - String to match. May be all, word or PCRE
* @param string $replace - String to replace with. May be all, word or PCRE
* @param integer $filter_option - Type of filtering to perform (0: all, 1: word, 2: PCRE)
*/

function admin_add_word_filter($filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)
{
    if (!$db_admin_add_word_filter = db_connect()) return false;

    $filter_name  = db_escape_string($filter_name);
    $match_text   = db_escape_string($match_text);
    $replace_text = db_escape_string($replace_text);

    if (!is_numeric($filter_option)) $filter_option = WORD_FILTER_TYPE_ALL;
    if (!is_numeric($filter_enabled)) $filter_enabled = WORD_FILTER_ENABLED;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}WORD_FILTER` ";
    $sql.= "(UID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, FILTER_ENABLED) ";
    $sql.= "VALUES (0, '$filter_name', '$match_text', '$replace_text', '$filter_option', '$filter_enabled')";

    if (!db_query($sql, $db_admin_add_word_filter)) return false;

    return true;
}

/**
* Update entry in admin word filter
*
* Updates an entry in the admin defined word filter
*
* @return bool
* @param string $match - String to match. May be all, word or PCRE
* @param string $replace - String to replace with. May be all, word or PCRE
* @param integer $filter_option - Type of filtering to perform (0: all, 1: word, 2: PCRE)
*/

function admin_update_word_filter($filter_id, $filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)
{
    if (!$db_admin_add_word_filter = db_connect()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!is_numeric($filter_option)) $filter_option = WORD_FILTER_TYPE_ALL;
    if (!is_numeric($filter_enabled)) $filter_enabled = WORD_FILTER_ENABLED;

    $filter_name  = db_escape_string($filter_name);
    $match_text   = db_escape_string($match_text);
    $replace_text = db_escape_string($replace_text);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}WORD_FILTER` SET FILTER_NAME = '$filter_name', ";
    $sql.= "MATCH_TEXT = '$match_text', REPLACE_TEXT = '$replace_text', ";
    $sql.= "FILTER_TYPE = '$filter_option', FILTER_ENABLED = '$filter_enabled' ";
    $sql.= "WHERE UID = 0 AND FID = '$filter_id'";

    if (!db_query($sql, $db_admin_add_word_filter)) return false;

    return true;
}

/**
* Search for a user
*
* Searches for a user account and returns logon, nickname and last visit timestamp
*
* @return array
* @param string $usersearch - Logon or Nickname to search for
* @param string $sort_by - Column to sort the results by
* @param string $sort_dir - Direction to sort results by
* @param integer $offset - Offset of the rows returned by the query
*/

function admin_user_search($user_search, $sort_by = 'LAST_VISIT', $sort_dir = 'DESC', $filter = ADMIN_USER_FILTER_NONE, $offset = 0)
{
    if (!$db_admin_user_search = db_connect()) return false;

    $sort_by_array  = array('LOGON'      => 'USER.LOGON',
                            'LAST_VISIT' => 'USER_FORUM.LAST_VISIT',
                            'REGISTERED' => 'USER.REGISTERED',
                            'REFERER'    => 'SESSIONS.REFERER');

    if (!in_array($sort_dir, array('ASC', 'DESC'))) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($filter)) $filter = ADMIN_USER_FILTER_NONE;

    // Ensure offset is positive.

    $offset = abs($offset);

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    if (in_array($sort_by, array_keys($sort_by_array))) {
        $sort_by_array[$sort_by];
    }else {
        $sort_by = 'USER_FORUM.LAST_VISIT';
    }

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $active_sess_cutoff);

    $user_get_all_array = array();

    $up_banned = USER_PERM_BANNED;

    $user_search = db_escape_string(str_replace("%", "", $user_search));

    switch ($filter) {

        case ADMIN_USER_FILTER_ONLINE: // Online Users

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NOT NULL ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        case ADMIN_USER_FILTER_OFFLINE: // Offline Users

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NULL ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        case ADMIN_USER_FILTER_APPROVAL: // Users awaiting approval

            $user_fetch_sql = "WHERE USER.APPROVED IS NULL ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        case ADMIN_USER_FILTER_BANNED: // Banned users

            $user_fetch_sql = "WHERE GROUP_PERMS.PERM & $up_banned > 0 ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        default:

            $user_fetch_sql = "WHERE (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;
    }

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, SESSIONS.HASH, ";
    $sql.= "SESSIONS.REFERER, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID ";
    $sql.= "AND SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME)) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) AND GROUP_PERMS.FID = '0') ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER.UID = USER_FORUM.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') $user_fetch_sql ";
    $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 10 ";

    if (!$result = db_query($sql, $db_admin_user_search)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_user_search)) return false;

    list($user_get_all_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($user_data = db_fetch_array($result))) {

            $user_get_all_array[$user_data['UID']] = $user_data;
        }

    }else if ($user_get_all_count > 0) {

        $offset = floor(($user_get_all_count - 1) / 10) * 10;
        return admin_user_get_all($sort_by, $sort_dir, $filter, $offset);
    }

    return array('user_count' => $user_get_all_count,
                 'user_array' => $user_get_all_array);
}

/**
* Fetch list of users
*
* Fetch a list of registered user accounts inc. logons, nicknames and last visit timestamp
*
* @return array
* @param string $sort_by - Column to sort the results by
* @param string $sort_dir - Direction to sort results by
* @param integer $offset - Offset of the rows returned by the query
*/

function admin_user_get_all($sort_by = 'LAST_VISIT', $sort_dir = 'ASC', $filter = ADMIN_USER_FILTER_NONE, $offset = 0)
{
    if (!$db_user_get_all = db_connect()) return false;

    $sort_by_array  = array('LOGON'      => 'USER.LOGON',
                            'LAST_VISIT' => 'USER_FORUM.LAST_VISIT',
                            'REGISTERED' => 'USER.REGISTERED',
                            'ACTIVE'     => 'SESSIONS.HASH');

    if (!in_array($sort_dir, array('ASC', 'DESC'))) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($filter)) $filter = ADMIN_USER_FILTER_NONE;

    // Ensure offset is positive.

    $offset = abs($offset);

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    if (in_array($sort_by, array_keys($sort_by_array))) {
        $sort_by = $sort_by_array[$sort_by];
    }else {
        $sort_by = 'USER_FORUM.LAST_VISIT';
    }

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $active_sess_cutoff);

    $user_get_all_array = array();

    $up_banned = USER_PERM_BANNED;

    switch ($filter) {

        case ADMIN_USER_FILTER_ONLINE: // Online Users

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NOT NULL";

            break;

        case ADMIN_USER_FILTER_OFFLINE: // Offline Users

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NULL";

            break;

        case ADMIN_USER_FILTER_APPROVAL: // Users awaiting approval

            $user_fetch_sql = "WHERE USER.APPROVED IS NULL";

            break;

        case ADMIN_USER_FILTER_BANNED: // Banned users

            $user_fetch_sql = "WHERE GROUP_PERMS.PERM & $up_banned > 0";

            break;

        default:

            $user_fetch_sql = "";
            break;
    }

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "SESSIONS.HASH, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID ";
    $sql.= "AND SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME)) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) AND GROUP_PERMS.FID = '0') ";
    $sql.= "LEFT JOIN USER_FORUM  ON (USER.UID = USER_FORUM.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') $user_fetch_sql ";
    $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 10 ";

    if (!$result = db_query($sql, $db_user_get_all)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_user_get_all)) return false;

    list($user_get_all_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($user_data = db_fetch_array($result))) {

            $user_get_all_array[$user_data['UID']] = $user_data;
        }

    }else if ($user_get_all_count > 0) {

        $offset = floor(($user_get_all_count - 1) / 10) * 10;
        return admin_user_get_all($sort_by, $sort_dir, $filter, $offset);
    }

    return array('user_count' => $user_get_all_count,
                 'user_array' => $user_get_all_array);
}

/**
* Fetch user
*
* Fetch the details for the specified user.
*
* @return mixed - Array on success boolean false on failure.
* @param integer $uid - UID of the user account to fetch.
*/

function admin_user_get($uid)
{
    if (!$db_admin_user_get = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER.EMAIL, ";
    $sql.= "USER.IPADDRESS, SESSIONS.HASH, SESSIONS.REFERER AS SESSION_REFERER, ";
    $sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID) ";
    $sql.= "LEFT JOIN USER_FORUM  ON (USER.UID = USER_FORUM.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') WHERE USER.UID = '$uid'";

    if (!$result = db_query($sql, $db_admin_user_get)) return false;

    if (db_num_rows($result) > 0) {

        $admin_user_get = db_fetch_array($result);
        return $admin_user_get;
    }

    return false;
}

/**
* End user session
*
* Ends the session of the specified user
*
* @return bool
* @param integer $uid - UID of the user account to end session for.
*/

function admin_session_end($uid)
{
    if (!$db_admin_session_end = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "DELETE QUICK FROM SESSIONS WHERE UID = '$uid' ";
    $sql.= "AND FID = '$forum_fid'";

    if (!db_query($sql, $db_admin_session_end)) return false;

    return true;
}

/**
* Get user attachments
*
* Fetches the attachments for the available user
*
* @return mixed
* @param integer $uid - UID of the user account to fetch attachments for.
*/

function admin_get_users_attachments($uid, &$user_attachments, &$user_image_attachments, $hash_array = false)
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db_get_users_attachments = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($hash_array)) $hash_array = false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    if (is_array($hash_array)) {

        $hash_list = implode("', '", array_filter($hash_array, 'is_md5'));

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' AND PAF.HASH IN ('$hash_list') ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    }else {

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' ORDER BY FORUMS.FID DESC, PAF.FILENAME";
    }

    if (!$result = db_query($sql, $db_get_users_attachments)) return false;

    while (($attachment = db_fetch_array($result))) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                  "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                  "filesize"     => $filesize,
                                                  "aid"          => $attachment['AID'],
                                                  "hash"         => $attachment['HASH'],
                                                  "mimetype"     => $attachment['MIMETYPE'],
                                                  "downloads"    => $attachment['DOWNLOADS'],
                                                  "forum_fid"    => is_numeric($attachment['FID']) ? $attachment['FID'] : 0,
                                                  "forum_webtag" => $attachment['WEBTAG']);

            }else {

                $user_attachments[] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                            "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                            "filesize"     => filesize("$attachment_dir/{$attachment['HASH']}"),
                                            "aid"          => $attachment['AID'],
                                            "hash"         => $attachment['HASH'],
                                            "mimetype"     => $attachment['MIMETYPE'],
                                            "downloads"    => $attachment['DOWNLOADS'],
                                            "forum_fid"    => is_numeric($attachment['FID']) ? $attachment['FID'] : 0,
                                            "forum_webtag" => $attachment['WEBTAG']);
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

/**
* Fetch list of forums
*
* Fetches a list of forums.
*
* @return mixed
* @param integer $start - Offset for results.
*/

function admin_get_forum_list($offset)
{
    if (!$db_admin_get_forum_list = db_connect()) return false;

    if (!is_numeric($offset)) return false;

    $forums_array = array();

    // Ensure offset is positive.

    $offset = abs($offset);

    $sql = "SELECT SQL_CALC_FOUND_ROWS FORUMS.FID, FORUMS.WEBTAG, FORUMS.DEFAULT_FORUM, ";
    $sql.= "FORUMS.ACCESS_LEVEL, FORUM_SETTINGS.SVALUE AS FORUM_NAME FROM FORUMS ";
    $sql.= "LEFT JOIN FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID ";
    $sql.= "AND FORUM_SETTINGS.SNAME = 'forum_name') ";
    $sql.= "LIMIT $offset, 10 ";

    if (!$result = db_query($sql, $db_admin_get_forum_list)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_get_forum_list)) return false;

    list($forums_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($forum_data = db_fetch_array($result))) {

            if (!isset($forum_data['ACCESS_LEVEL'])) $forum_data['ACCESS_LEVEL'] = 0;

            if (($post_count = admin_forum_get_post_count($forum_data['FID']))) {
                $forum_data['MESSAGES'] = $post_count;
            }

            $forums_array[] = $forum_data;
        }

    }else if ($forums_count > 0) {

        $offset = floor(($forums_count - 1) / 10) * 10;
        return admin_get_forum_list($offset);
    }

    return array('forums_array' => $forums_array,
                 'forums_count' => $forums_count);
}

/**
* Fetch post count
*
* Fetches post count of specified forum.
*
* @return array
* @param integer $fid - Forum FID.
*/

function admin_forum_get_post_count($fid)
{
    if (!$db_admin_forum_get_post_count = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (($table_data = forum_get_table_prefix($fid))) {

        $sql = "SELECT COUNT(PID) FROM `{$table_data['PREFIX']}POST`";

        if (!$result = db_query($sql, $db_admin_forum_get_post_count)) return false;

        list($post_count) = db_fetch_array($result, DB_RESULT_NUM);

        return $post_count;
    }

    return false;
}

/**
* Fetch ban data
*
* Fetches available ban data from database.
*
* @return array
* @param string $sort_by - Optional column to sort results by (default: ID)
* @param string $sort_dir - Optional sort direction for results (default: ASC);
* @param integer $offset - Offset for results
*/

function admin_get_ban_data($sort_by = "ID", $sort_dir = "ASC", $offset = 0)
{
    if (!$db_admin_get_bandata = db_connect()) return false;

    $sort_by_array = array('ID', 'BANTYPE', 'BANDATA', 'COMMENT', 'EXPIRES');
    $sort_dir_array = array('ASC', 'DESC');

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'ID';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;

    // Ensure offset is positive.

    $offset = abs($offset);

    if (!$table_data = get_table_prefix()) return false;

    $ban_data_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS ID, BANTYPE, BANDATA, COMMENT, ";
    $sql.= "UNIX_TIMESTAMP(EXPIRES) AS EXPIRES FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "ORDER BY $sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_bandata)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_get_bandata)) return false;

    list($ban_data_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($ban_data = db_fetch_array($result))) {

            $ban_data_array[$ban_data['ID']] = $ban_data;
        }

    }else if ($ban_data_count > 0) {

        $offset = floor(($ban_data_count - 1) / 10) * 10;
        return admin_get_ban_data($sort_by, $sort_dir, $offset);
    }

    return array('ban_count' => $ban_data_count,
                 'ban_array' => $ban_data_array);
}

/**
* Fetch ban data by ban ID
*
* Fetches available ban data from database for the specified ban ID.
*
* @return array
* @param string $ban_id - ID of ban to return.
*/

function admin_get_ban($ban_id)
{
    if (!$db_admin_get_bandata = db_connect()) return false;

    if (!is_numeric($ban_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ID, BANTYPE, BANDATA, COMMENT, UNIX_TIMESTAMP(EXPIRES) AS EXPIRES, ";
    $sql.= "DAY(EXPIRES) AS EXPIRESDAY, MONTH(EXPIRES) AS EXPIRESMONTH, ";
    $sql.= "YEAR(EXPIRES) AS EXPIRESYEAR FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE ID = '$ban_id'";

    if (!$result = db_query($sql, $db_admin_get_bandata)) return false;

    if (db_num_rows($result) > 0) {

        $ban_data_array = db_fetch_array($result);
        return $ban_data_array;
    }

    return false;
}

/**
* Check user is approved
*
* Check that specified user is approved.
*
* @return boolean
* @param integer $uid - User UID
*/

function admin_user_approved($uid)
{
    if (!$db_admin_user_approved = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT COUNT(UID) FROM USER WHERE APPROVED IS NOT NULL AND UID = '$uid'";

    if (!$result = db_query($sql, $db_admin_user_approved)) return false;

    list($user_approved_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_approved_count > 0;
}

/**
* Fetch post approval queue.
*
* Fetches list of posts awaiting approval from database.
*
* @return array
* @param string $offset - Optional offset for results
*/

function admin_get_post_approval_queue($offset = 0)
{
    if (!$db_admin_get_post_approval_queue = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;

    // Ensure offset is positive.

    $offset = abs($offset);

    if (!$table_data = get_table_prefix()) return false;

    if (($folder_list = bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {
        $fidlist = implode(',', $folder_list);
    }

    $post_approval_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TITLE, FOLDER.TITLE AS FOLDER_TITLE, FOLDER.PREFIX, ";
    $sql.= "USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, ";
    $sql.= "CONCAT(POST.TID, '.', POST.PID) AS MSG FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE POST.APPROVED IS NULL AND THREAD.FID IN ($fidlist) ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_post_approval_queue)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_get_post_approval_queue)) return false;

    list($post_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($post_array = db_fetch_array($result))) {

            $post_approval_array[] = $post_array;
        }

    }else if ($post_count > 0) {

        $offset = floor(($post_count - 1) / 10) * 10;
        return admin_get_post_approval_queue($offset);
    }

    return array('post_count' => $post_count,
                 'post_array' => $post_approval_array);
}

/**
* Fetch visitor log from database.
*
* Fetches an extended list of visitors from database including HTTP referer
* which isn't shown on the normal visitor log.
*
* @return array
* @param integer $offset - offset for results
* @param integer $limit  - limit for number of results
*/

function admin_get_visitor_log($offset)
{
    if (!$db_admin_get_visitor_log = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;

    // Ensure offset is positive.

    $offset = abs($offset);

    if (!$table_data = get_table_prefix()) return false;

    $users_get_recent_array = array();

    $lang = load_language_file();

    $uid = bh_session_get_value('UID');

    $forum_fid = $table_data['FID'];

    $sql = "SELECT SQL_CALC_FOUND_ROWS VISITOR_LOG.UID, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "VISITOR_LOG.IPADDRESS, VISITOR_LOG.REFERER, ";
    $sql.= "SEB.SID, SEB.NAME, SEB.URL FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS SEB ";
    $sql.= "ON (SEB.SID = VISITOR_LOG.SID) ";
    $sql.= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
    $sql.= "AND VISITOR_LOG.FORUM = '$forum_fid' ";
    $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_visitor_log)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_admin_get_visitor_log)) return false;

    list($users_get_recent_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while (($visitor_array = db_fetch_array($result))) {

            if (isset($visitor_array['LOGON']) && isset($visitor_array['PEER_NICKNAME'])) {
                if (!is_null($visitor_array['PEER_NICKNAME']) && strlen($visitor_array['PEER_NICKNAME']) > 0) {
                    $visitor_array['NICKNAME'] = $visitor_array['PEER_NICKNAME'];
                }
            }

            if ($visitor_array['UID'] == 0) {

                $visitor_array['LOGON']    = $lang['guest'];
                $visitor_array['NICKNAME'] = $lang['guest'];

            }elseif (!isset($visitor_array['LOGON']) || is_null($visitor_array['LOGON'])) {

                $visitor_array['LOGON'] = $lang['unknownuser'];
                $visitor_array['NICKNAME'] = "";
            }

            if (isset($visitor_array['REFERER']) && strlen(trim($visitor_array['REFERER'])) > 0) {

                $forum_uri_preg = preg_quote(html_get_forum_uri(), '/');

                if (preg_match("/^$forum_uri_preg/iu", trim($visitor_array['REFERER'])) > 0) {
                    $visitor_array['REFERER'] = "";
                }

            }else {

                $visitor_array['REFERER'] = "";
            }

            $users_get_recent_array[] = $visitor_array;
        }

    }else if ($users_get_recent_count > 0) {

        $offset = floor(($users_get_recent_count - 1) / 10) * 10;
        return admin_get_visitor_log($offset);
    }

    return array('user_count' => $users_get_recent_count,
                 'user_array' => $users_get_recent_array);
}

/**
* Clears visitor log
*
* Clears the forum visitor log
*
* @return bool
* @param void
*/

function admin_prune_visitor_log($remove_days)
{
    if (!$db_admin_prune_visitor_log = db_connect()) return false;

    if (!is_numeric($remove_days)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $remove_days_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($remove_days * DAY_IN_SECONDS));

    $sql = "DELETE QUICK FROM VISITOR_LOG WHERE FORUM = '$forum_fid' ";
    $sql.= "AND LAST_LOGON < CAST('$remove_days_datetime' AS DATETIME)";

    if (!db_query($sql, $db_admin_prune_visitor_log)) return false;

    return true;
}

/**
* Fetch list of user aliases
*
* Fetches a list of aliases (IP Address matches) from database
* for the specified user UID.
*
* @return array
* @param integer $uid - User UID for searching.
*/

function admin_get_user_ip_matches($uid)
{
    if (!$db_admin_get_user_ip_matches = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Initialise arrays

    $user_ip_address_array = array();
    $user_aliases_array = array();

    // Session UID

    $sess_uid = bh_session_get_value('UID');

    // Fetch the user's last 10 IP addresses from the POST table

    $sql = "SELECT DISTINCT IPADDRESS FROM `{$table_data['PREFIX']}POST` ";
    $sql.= "WHERE FROM_UID = '$uid' AND IPADDRESS IS NOT NULL LIMIT 0, 10";

    if (!$result = db_query($sql, $db_admin_get_user_ip_matches)) return false;

    if (db_num_rows($result) > 0) {

        while (($user_get_aliases_row = db_fetch_array($result))) {

            if (strlen(trim($user_get_aliases_row['IPADDRESS'])) > 0) {

                $user_ip_address_array[] = $user_get_aliases_row['IPADDRESS'];
            }
        }
    }

    if (($ipaddress = user_get_last_ip_address($uid))) {
        $user_ip_address_array[] = $ipaddress;
    }

    // Search the POST table for any matches - limit 10 matches

    $user_ip_address_list = implode("', '", $user_ip_address_array);

    if (strlen($user_ip_address_list) > 0) {

        $sql = "SELECT DISTINCT POST.FROM_UID AS UID, USER.LOGON, ";
        $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, POST.IPADDRESS ";
        $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
        $sql.= "LEFT JOIN USER USER ON (POST.FROM_UID = USER.UID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$sess_uid') ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}RSS_FEEDS` RSS_FEEDS ";
        $sql.= "ON (RSS_FEEDS.UID = USER.UID) WHERE POST.FROM_UID <> $uid ";
        $sql.= "AND ((POST.IPADDRESS IN ('$user_ip_address_list')) ";
        $sql.= "OR (USER.IPADDRESS IN ('$user_ip_address_list'))) ";
        $sql.= "AND RSS_FEEDS.UID IS NOT NULL ";
        $sql.= "LIMIT 0, 10";

        if (!$result = db_query($sql, $db_admin_get_user_ip_matches)) return false;

        if (db_num_rows($result) > 0) {

            while (($user_aliases = db_fetch_array($result))) {

                if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
                    if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                        $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
                    }
                }

                if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = $lang['unknownuser'];
                if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

                $user_aliases_array[$user_aliases['UID']] = $user_aliases;
            }
        }
    }

    return $user_aliases_array;
}

/**
* Fetch list of user aliases
*
* Fetches a list of aliases (Email Address matches) from database
* for the specified user UID.
*
* @return array
* @param integer $uid - User UID for searching.
*/

function admin_get_user_email_matches($uid)
{
    if (!$db_admin_get_user_email_matches = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Initialise array

    $user_email_aliases_array = array();

    // Session UID

    $sess_uid = bh_session_get_value('UID');

    // Get the user's email address

    $user_email_address = user_get_email($uid);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME, USER.EMAIL FROM USER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$sess_uid') ";
    $sql.= "WHERE (USER.EMAIL = '$user_email_address') ";
    $sql.= "AND USER.UID <> $uid LIMIT 0, 10";

    if (!$result = db_query($sql, $db_admin_get_user_email_matches)) return false;

    if (db_num_rows($result) > 0) {

        while (($user_aliases = db_fetch_array($result))) {

            if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
                if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                    $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
                }
            }

            if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = $lang['unknownuser'];
            if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

            $user_email_aliases_array[$user_aliases['UID']] = $user_aliases;
        }
    }

    return $user_email_aliases_array;
}

/**
* Fetch list of user aliases
*
* Fetches a list of aliases (HTTP Referer matches) from database
* for the specified user UID.
*
* @return array
* @param integer $uid - User UID for searching.
*/

function admin_get_user_referer_matches($uid)
{
    if (!$db_admin_get_user_referer_matches = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Initialise array

    $user_referer_aliases_array = array();

    // Session UID

    $sess_uid = bh_session_get_value('UID');

    // Get the user's referer

    $user_http_referer = user_get_referer($uid);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME, USER.REFERER FROM USER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$sess_uid') ";
    $sql.= "WHERE USER.REFERER = '$user_http_referer' ";
    $sql.= "AND USER.UID <> $uid LIMIT 0, 10";

    if (!$result = db_query($sql, $db_admin_get_user_referer_matches)) return false;

    if (db_num_rows($result) > 0) {

        while (($user_aliases = db_fetch_array($result))) {

            if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
                if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                    $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
                }
            }

            if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = $lang['unknownuser'];
            if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

            $user_referer_aliases_array[$user_aliases['UID']] = $user_aliases;
        }
    }

    return $user_referer_aliases_array;
}

/**
* Fetch list of user aliases
*
* Fetches a list of aliases (Password matches) from database
* for the specified user UID.
*
* @return array
* @param integer $uid - User UID for searching.
*/

function admin_get_user_passwd_matches($uid)
{
    if (!$db_admin_get_user_passwd_matches = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Initialise array

    $user_passwd_aliases_array = array();

    // Session UID

    $sess_uid = bh_session_get_value('UID');

    // Get the user's email address

    $user_passwd = user_get_passwd($uid);

    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME, USER.PASSWD FROM USER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$sess_uid') ";
    $sql.= "WHERE (USER.PASSWD = '$user_passwd') ";
    $sql.= "AND USER.UID <> $uid LIMIT 0, 10";

    if (!$result = db_query($sql, $db_admin_get_user_passwd_matches)) return false;

    if (db_num_rows($result) > 0) {

        while (($user_aliases = db_fetch_array($result))) {

            if (isset($user_aliases['LOGON']) && isset($user_aliases['PEER_NICKNAME'])) {
                if (!is_null($user_aliases['PEER_NICKNAME']) && strlen($user_aliases['PEER_NICKNAME']) > 0) {
                    $user_aliases['NICKNAME'] = $user_aliases['PEER_NICKNAME'];
                }
            }

            if (!isset($user_aliases['LOGON'])) $user_aliases['LOGON'] = $lang['unknownuser'];
            if (!isset($user_aliases['NICKNAME'])) $user_aliases['NICKNAME'] = "";

            $user_passwd_aliases_array[$user_aliases['UID']] = $user_aliases;
        }
    }

    return $user_passwd_aliases_array;
}

/**
* Fetch user history
*
* Fetches user account changes including logon, nickname, email address
* and password changes made to a user account.
*
* @return array
* @param integer $uid - User UID to get history for
*/

function admin_get_user_history($uid)
{
    if (!$db_admin_get_user_history = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    $user_history_array = array();

    $sql = "SELECT LOGON, NICKNAME, EMAIL FROM USER WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_admin_get_user_history)) return false;

    if (db_num_rows($result) > 0) {

        list($logon, $nickname, $email) = db_fetch_array($result, DB_RESULT_NUM);

        $sql = "SELECT LOGON, NICKNAME, EMAIL, UNIX_TIMESTAMP(MODIFIED) ";
        $sql.= "FROM USER_HISTORY WHERE UID = '$uid' ";
        $sql.= "ORDER BY MODIFIED DESC ";
        $sql.= "LIMIT 0, 10";

        if (!$result = db_query($sql, $db_admin_get_user_history)) return false;

        if (db_num_rows($result) > 0) {

            $user_history_data_old = "";
            $user_history_data = "";

            while (($user_history_row = db_fetch_array($result, DB_RESULT_NUM))) {

                $user_history_data_array = array();

                list($logon_old, $nickname_old, $email_old, $modified_date) = $user_history_row;

                if ($logon != $logon_old) {
                    $user_history_data_array[] = sprintf($lang['changedlogonfromto'], $logon_old, $logon);
                }

                if ($nickname != $nickname_old) {
                    $user_history_data_array[] = sprintf($lang['changednicknamefromto'], $nickname_old, $nickname);
                }

                if ($email != $email_old) {
                    $user_history_data_array[] = sprintf($lang['changedemailfromto'], $email_old, $email);
                }

                if (sizeof($user_history_data_array) > 0) {

                    $user_history_data = implode(". ", $user_history_data_array);

                    if ($user_history_data != $user_history_data_old) {

                        $user_history_array[] = array('MODIFIED' => $modified_date,
                                                      'DATA'     => $user_history_data);
                    }
                }

                list($logon, $nickname, $email) = $user_history_row;
                $user_history_data_old = $user_history_data;
            }
        }
    }

    return $user_history_array;
}

/**
* Clear user history
*
* Clear user history for the speicifed user account.
*
* @return array
* @param integer $uid - UID of user to clear history from.
*/

function admin_clear_user_history($uid)
{
    if (!$db_admin_clear_user_history = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "DELETE QUICK FROM USER_HISTORY WHERE UID = '$uid'";

    if (!db_query($sql, $db_admin_clear_user_history)) return false;

    return (db_affected_rows($db_admin_clear_user_history) > 0);
}

/**
* Approve user account
*
* Approve the specified user account.
*
* @return array
* @param integer $uid - UID of user account to approve.
*/

function admin_approve_user($uid)
{
    if (!$db_admin_approve_user = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY USER SET APPROVED = CAST('$current_datetime' AS DATETIME) ";
    $sql.= "WHERE UID = '$uid'";

    if (!db_query($sql, $db_admin_approve_user)) return false;

    return (db_affected_rows($db_admin_approve_user) > 0);
}

/**
* Delete user account
*
* Delete the specified user account.
*
* @return array
* @param integer $uid - UID of user account to delete.
* @param boolean $delete_content - Optional - Optionally delete all content made by user.
*/

function admin_delete_user($uid, $delete_content = false)
{
    if (!$db_admin_delete_user = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_bool($delete_content)) $delete_content = false;

    // Constants for deleting PM data

    $pm_inbox_items  = PM_INBOX_ITEMS;
    $pm_sent_items   = PM_SENT_ITEMS;
    $pm_outbox_items = PM_OUTBOX_ITEMS;
    $pm_saved_out    = PM_SAVED_OUT;
    $pm_saved_in     = PM_SAVED_IN;
    $pm_draft_items  = PM_DRAFT_ITEMS;

    $current_datetime = date(MYSQL_DATETIME, time());

    // UID of current user

    $admin_uid = bh_session_get_value('UID');

    // Before we delete we verify the user account exists and that
    // the user is not the current user account.

    if (($user_logon = user_get_logon($uid)) && ($admin_uid != $uid)) {

        // Check to see if we're also deleting the user's content.

        if ($delete_content === true) {

            // Get a list of available forums

            if (($forum_table_prefix_array = forum_get_all_prefixes())) {

                // Loop through all forums and delete all the user data from every forum.

                foreach ($forum_table_prefix_array as $forum_table_prefix) {

                    // Delete log entries created by the user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}ADMIN_LOG` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Links created by the user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}LINKS` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Link Votes made by the user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}LINKS_VOTE` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Link Comments made by the user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}LINKS_COMMENT` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Poll Votes made by the user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_POLL_VOTES` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Relationship data for the user and relationships
                    // with this user made by other users.

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_PEER` WHERE UID = '$uid' OR PEER_UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete folder preferences set by the user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_FOLDER` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete User's Preferences

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_PREFS` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete User's Profile.

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_PROFILE` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete User's Signature

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_SIG` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete User's Thread Read Data

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_THREAD` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete User's Tracking data (Post Count, etc.)

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}USER_TRACK` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Word Filter Entries made by user

                    $sql = "DELETE QUICK FROM `{$forum_table_prefix}WORD_FILTER` WHERE UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete Polls created by user

                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}THREAD` SET POLL_FLAG = 'N', ";
                    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE BY_UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete threads started by the user where
                    // the thread only contains a single post.

                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}THREAD` SET DELETED = 'Y', ";
                    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE BY_UID = '$uid' ";
                    $sql.= "AND LENGTH = 1";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Delete content of posts made by this user

                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}POST_CONTENT` POST_CONTENT ";
                    $sql.= "LEFT JOIN `{$forum_table_prefix}POST` POST ON (POST.TID = POST_CONTENT.TID ";
                    $sql.= "AND POST.PID = POST_CONTENT.PID) SET POST_CONTENT.CONTENT = NULL ";
                    $sql.= "WHERE POST.FROM_UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;

                    // Mark posts made by this user as approved so they don't appear in the
                    // approval queue.

                    $sql = "UPDATE LOW_PRIORITY `{$forum_table_prefix}POST` ";
                    $sql.= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
                    $sql.= "APPROVED_BY = '$admin_uid' WHERE FROM_UID = '$uid'";

                    if (!db_query($sql, $db_admin_delete_user)) return false;
                }
            }

            // Delete Dictionary entries added by user

            $sql = "DELETE QUICK FROM DICTIONARY WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User Group Entries related to this user.

            $sql = "DELETE QUICK FROM GROUP_USERS WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's PM Content

            $sql = "DELETE QUICK FROM PM_CONTENT USING PM_CONTENT ";
            $sql.= "LEFT JOIN PM ON (PM.MID = PM_CONTENT.MID) ";
            $sql.= "WHERE ((PM.TYPE & $pm_inbox_items > 0) AND PM.TO_UID = '$uid') ";
            $sql.= "OR ((PM.TYPE & $pm_sent_items > 0) AND PM.FROM_UID = '$uid' AND PM.SMID = 0) ";
            $sql.= "OR ((PM.TYPE & $pm_outbox_items > 0) AND PM.FROM_UID = '$uid') ";
            $sql.= "OR ((PM.TYPE & $pm_saved_out > 0) AND PM.FROM_UID = '$uid') ";
            $sql.= "OR ((PM.TYPE & $pm_saved_in > 0) AND PM.TO_UID = '$uid') ";
            $sql.= "OR ((PM.TYPE & $pm_draft_items > 0) AND PM.FROM_UID = '$uid') ";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's PMs.

            $sql = "DELETE QUICK FROM PM WHERE ((TYPE & $pm_inbox_items > 0) ";
            $sql.= "AND TO_UID = '$uid') OR ((TYPE & $pm_sent_items > 0) ";
            $sql.= "AND FROM_UID = '$uid' AND SMID = 0) OR ((TYPE & $pm_outbox_items > 0) ";
            $sql.= "AND FROM_UID = '$uid') OR ((TYPE & $pm_saved_out > 0) ";
            $sql.= "AND FROM_UID = '$uid') OR ((TYPE & $pm_saved_in > 0) ";
            $sql.= "AND TO_UID = '$uid') OR ((TYPE & $pm_draft_items > 0) ";
            $sql.= "AND FROM_UID = '$uid') ";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's PM Search Results

            $sql = "DELETE QUICK FROM PM_SEARCH_RESULTS WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's Attachments (doesn't remove the physical files).

            $sql = "DELETE QUICK FROM POST_ATTACHMENT_FILES WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's Search Results.

            $sql = "DELETE QUICK FROM SEARCH_RESULTS WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's Sessions

            $sql = "DELETE QUICK FROM SESSIONS WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's Forum Preferences and Permissions

            $sql = "DELETE QUICK FROM USER_FORUM WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's History Data (Logon, Nickname, Email address changes)

            $sql = "DELETE QUICK FROM USER_HISTORY WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's Global Preferences

            $sql = "DELETE QUICK FROM USER_PREFS WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Delete User's Visitor Log Data

            $sql = "DELETE QUICK FROM VISITOR_LOG WHERE UID = '$uid'";

            if (!db_query($sql, $db_admin_delete_user)) return false;

            // Add a log entry to show what we've done.

            admin_add_log_entry(DELETE_USER_DATA, array($uid, $user_logon));
        }

        // Delete the User account.

        $sql = "DELETE QUICK FROM USER WHERE UID = '$uid'";

        if (!db_query($sql, $db_admin_delete_user)) return false;

        // Add a log entry to show what we've done.

        admin_add_log_entry(DELETE_USER, $user_logon);

        return true;
    }

    return false;
}

/**
* Delete user's posts.
*
* Delete users posts from the current forum.
*
* @return array
* @param integer $uid - UID of user account to delete posts for.
*/

function admin_delete_users_posts($uid)
{
    if (!$db_admin_delete_users_posts = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql.= "SELECT TID, PID, NULL FROM `{$table_data['PREFIX']}POST` WHERE FROM_UID = '$uid' ";
    $sql.= "ON DUPLICATE KEY UPDATE CONTENT = VALUES(CONTENT)";

    if (!db_query($sql, $db_admin_delete_users_posts)) return false;

    return true;
}

/**
* Format affected session array
*
* Helper function for check_affected_sessions that formats an affected
* session array into a human readable output.
*
* @return string
* @param array $affected_session - Array of affected session data from check_affected_sessions() function.
*/

function admin_prepare_affected_sessions($affected_session)
{
    $webtag = get_webtag();

    if ($affected_session['UID'] > 0) {

        $affected_session_text = "<a href=\"user_profile.php?webtag=$webtag&amp;uid={$affected_session['UID']};\" ";
        $affected_session_text.= "target=\"_blank\" class=\"popup 650x500\">";
        $affected_session_text.= word_filter_add_ob_tags(htmlentities_array(format_user_name($affected_session['LOGON'], $affected_session['NICKNAME'])));
        $affected_session_text.= "</a></li>\n";

    }else {

        $affected_session_text = word_filter_add_ob_tags(htmlentities_array(format_user_name($affected_session['LOGON'], $affected_session['NICKNAME'])));
    }

    return $affected_session_text;
}

/**
* Send user approval notification
*
* Sends an email to all global forum admins to notify them that
* a user account requires approval.
*
* @return boolean
* @param void
*/

function admin_send_user_approval_notification()
{
    if (!$db_admin_send_new_user_notification = db_connect()) return false;

    $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;

    $notification_success = true;

    $sql = "SELECT DISTINCT USER.UID FROM USER LEFT JOIN GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.UID = USER.UID) LEFT JOIN GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM = 0) ";
    $sql.= "WHERE (GROUP_PERMS.PERM & $user_perm_admin_tools) > 0 ";

    if (!$result = db_query($sql, $db_admin_send_new_user_notification)) return false;

    while (list($admin_uid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (!email_send_user_approval_notification($admin_uid)) {

            $notification_success = false;
        }
    }

    return $notification_success;
}

/**
* Send user approval notification
*
* Sends an email to all global forum admins to notify them that
* a new user account has been created.
*
* @return boolean
* @param integer $new_user_uid - New User account UID
*/

function admin_send_new_user_notification($new_user_uid)
{
    if (!$db_admin_send_new_user_notification = db_connect()) return false;

    if (!is_numeric($new_user_uid)) return false;

    $user_perm_admin_tools = USER_PERM_ADMIN_TOOLS;

    $sql = "SELECT DISTINCT USER.UID FROM USER LEFT JOIN GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.UID = USER.UID) LEFT JOIN GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM = 0) ";
    $sql.= "WHERE (GROUP_PERMS.PERM & $user_perm_admin_tools) > 0 ";

    if (!$result = db_query($sql, $db_admin_send_new_user_notification)) return false;

    while (list($admin_uid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (!email_send_new_user_notification($admin_uid, $new_user_uid)) return false;
    }

    return true;
}

/**
* Send post approval notification
*
* Sends an email to all global forum admins and folder moderators
* to notify them that a new post or thread has been created that
* requires approval
*
* @return boolean
* @param integer $fid - Folder where the post or thread was created.
*/

function admin_send_post_approval_notification($fid)
{
    if (!$db_admin_send_post_approval_notification = db_connect()) return false;

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $user_perm_folder_moderate = USER_PERM_FOLDER_MODERATE;

    $notification_success = true;

    $sql = "SELECT DISTINCT USER.UID FROM USER ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "WHERE (GROUP_PERMS.PERM & $user_perm_folder_moderate) > 0 ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "AND GROUP_PERMS.FID IN (0, $fid)";

    if (!$result = db_query($sql, $db_admin_send_post_approval_notification)) return false;

    while (list($admin_uid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (!email_send_post_approval_notification($admin_uid)) {

            $notification_success = false;
        }
    }

    return $notification_success;
}

?>