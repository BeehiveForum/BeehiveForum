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

/* $Id: admin.inc.php,v 1.126 2007-08-04 22:32:13 decoyduck Exp $ */

/**
* admin.inc.php - admin functions
*
* Contains admin related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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
    $db_admin_add_log_entry = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($action)) return false;

    if (is_array($data)) $data = implode("\x00", preg_replace('/[\x00]+/', '', $data));

    $data = db_escape_string($data);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}ADMIN_LOG (CREATED, UID, ACTION, ENTRY) ";
    $sql.= "VALUES (NOW(), '$uid', '$action', '$data')";

    if (!$result = db_query($sql, $db_admin_add_log_entry)) return false;

    return true;
}

/**
* Clears admin log
*
* Clears the forum admin log
*
* @return bool
* @param void
*/

function admin_clearlog()
{
    $db_admin_clearlog = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}ADMIN_LOG";

    if (!$result = db_query($sql, $db_admin_clearlog)) return false;

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
    $db_admin_get_log_entries = db_connect();

    $lang = load_language_file();

    $sort_by_array  = array('CREATED', 'UID', 'ACTION');
    $sort_dir_array = array('ASC', 'DESC');

    $admin_log_array = array();

    if (!is_numeric($offset)) $offset = 0;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT COUNT(ID) AS LOG_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}ADMIN_LOG ";

    if (!$result = db_query($sql, $db_admin_get_log_entries)) return false;

    list($admin_log_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT ADMIN_LOG.ID, ADMIN_LOG.UID, ADMIN_LOG.ACTION, ADMIN_LOG.ENTRY, ";
    $sql.= "USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(ADMIN_LOG.CREATED) AS CREATED ";
    $sql.= "FROM {$table_data['PREFIX']}ADMIN_LOG ADMIN_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = ADMIN_LOG.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "ORDER BY ADMIN_LOG.$sort_by $sort_dir LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_log_entries)) return false;

    if (db_num_rows($result) > 0) {

        while ($admin_log_entry = db_fetch_array($result)) {

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
    $db_admin_get_word_filter = db_connect();

    if (!is_numeric($offset)) $offset = 0;

    $word_filter_array = array();
    $word_filter_count = 0;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(FID) FROM {$table_data['PREFIX']}WORD_FILTER ";
    $sql.= "WHERE UID = 0";

    if (!$result = db_query($sql, $db_admin_get_word_filter)) return false;
    
    list($word_filter_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, ";
    $sql.= "FILTER_ENABLED FROM {$table_data['PREFIX']}WORD_FILTER ";
    $sql.= "WHERE UID = 0 ORDER BY FID ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_word_filter)) return false;

    if (db_num_rows($result) > 0) {

        while ($word_filter_data = db_fetch_array($result)) {

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
    $db_admin_get_word_filter = db_connect();

    if (!is_numeric($filter_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, ";
    $sql.= "FILTER_ENABLED FROM {$table_data['PREFIX']}WORD_FILTER ";
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
    $db_user_delete_word_filter = db_connect();

    if (!is_numeric($filter_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}WORD_FILTER ";
    $sql.= "WHERE UID = 0 AND FID = '$filter_id'";

    if (!$result = db_query($sql, $db_user_delete_word_filter)) return false;

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
    $db_admin_clear_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}WORD_FILTER WHERE UID = 0";

    if (!$result = db_query($sql, $db_admin_clear_word_filter)) return false;

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
    $db_admin_add_word_filter = db_connect();

    $filter_name  = db_escape_string($filter_name);
    $match_text   = db_escape_string($match_text);
    $replace_text = db_escape_string($replace_text);

    if (!is_numeric($filter_option)) $filter_option = WORD_FILTER_TYPE_ALL;
    if (!is_numeric($filter_enabled)) $filter_enabled = WORD_FILTER_ENABLED;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}WORD_FILTER ";
    $sql.= "(UID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, FILTER_ENABLED) ";
    $sql.= "VALUES (0, '$filter_name', '$match_text', '$replace_text', '$filter_option', '$filter_enabled')";

    if (!$result = db_query($sql, $db_admin_add_word_filter)) return false;

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
    $db_admin_add_word_filter = db_connect();

    if (!is_numeric($filter_id)) return false;

    if (!is_numeric($filter_option)) $filter_option = WORD_FILTER_TYPE_ALL;
    if (!is_numeric($filter_enabled)) $filter_enabled = WORD_FILTER_ENABLED;

    $filter_name  = db_escape_string($filter_name);
    $match_text   = db_escape_string($match_text);
    $replace_text = db_escape_string($replace_text);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}WORD_FILTER SET FILTER_NAME = '$filter_name', ";
    $sql.= "MATCH_TEXT = '$match_text', REPLACE_TEXT = '$replace_text', ";
    $sql.= "FILTER_TYPE = '$filter_option', FILTER_ENABLED = '$filter_enabled' ";
    $sql.= "WHERE UID = 0 AND FID = '$filter_id'";

    if (!$result = db_query($sql, $db_admin_add_word_filter)) return false;

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

function admin_user_search($user_search, $sort_by = 'USER_FORUM.LAST_VISIT', $sort_dir = 'DESC', $filter = ADMIN_USER_FILTER_NONE, $offset = 0)
{
    $db_admin_user_search = db_connect();

    $sort_by_array  = array('USER.UID', 'USER.LOGON', 'USER_FORUM.LAST_VISIT', 'USER.REGISTERED', 'SESSIONS.REFERER');
    $sort_dir_array = array('ASC', 'DESC');

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'USER_FORUM.LAST_VISIT';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($filter)) $filter = ADMIN_USER_FILTER_NONE;

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $user_get_all_array = array();

    $up_banned = USER_PERM_BANNED;

    $user_search = db_escape_string(str_replace("%", "", $user_search));

    switch ($filter) {

        case ADMIN_USER_FILTER_ONLINE: // Online Users

            $user_count_sql = "SELECT COUNT(DISTINCT SESSIONS.UID) AS USER_COUNT ";
            $user_count_sql.= "FROM SESSIONS LEFT JOIN USER ON (USER.UID = SESSIONS.UID) ";
            $user_count_sql.= "WHERE SESSIONS.FID = '$forum_fid' AND SESSIONS.UID > 0 ";
            $user_count_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_count_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NOT NULL ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        case ADMIN_USER_FILTER_OFFLINE: // Offline Users

            $user_count_sql = "SELECT COUNT(DISTINCT USER.UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID ";
            $user_count_sql.= "AND SESSIONS.FID = '$forum_fid') WHERE SESSIONS.HASH IS NULL ";
            $user_count_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_count_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NULL ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        case ADMIN_USER_FILTER_APPROVAL: // Users awaiting approval

            $user_count_sql = "SELECT COUNT(DISTINCT USER.UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "WHERE USER.APPROVED IS NULL AND (USER.LOGON LIKE '$user_search%' ";
            $user_count_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            $user_fetch_sql = "WHERE USER.APPROVED IS NULL ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        case ADMIN_USER_FILTER_BANNED: // Banned users

            $user_count_sql = "SELECT COUNT(DISTINCT USER.UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
            $user_count_sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
            $user_count_sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) AND GROUP_PERMS.FID = '0') ";
            $user_count_sql.= "WHERE GROUP_PERMS.PERM & $up_banned > 0 ";
            $user_count_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_count_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            $user_fetch_sql = "WHERE GROUP_PERMS.PERM & $up_banned > 0 ";
            $user_fetch_sql.= "AND (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;

        default:

            $user_count_sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "WHERE (USER.LOGON LIKE '$user_search%' ";
            $user_count_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            $user_fetch_sql = "WHERE (USER.LOGON LIKE '$user_search%' ";
            $user_fetch_sql.= "OR USER.NICKNAME LIKE '$user_search%') ";

            break;
    }

    if (!$result = db_query($user_count_sql, $db_admin_user_search)) return false;
    
    list($user_get_all_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, SESSIONS.HASH, ";
    $sql.= "SESSIONS.REFERER, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) AND GROUP_PERMS.FID = '0') ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER.UID = USER_FORUM.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') $user_fetch_sql ";
    $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 10 ";

    if (!$result = db_query($sql, $db_admin_user_search)) return false;

    if (db_num_rows($result) > 0) {

        while ($user_data = db_fetch_array($result)) {
            
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

function admin_user_get_all($sort_by = 'USER_FORUM.LAST_VISIT', $sort_dir = 'ASC', $filter = ADMIN_USER_FILTER_NONE, $offset = 0)
{
    $db_user_get_all = db_connect();
    $user_get_all_array = array();

    $sort_by_array  = array('USER.UID', 'USER.LOGON', 'USER_FORUM.LAST_VISIT', 'USER.REGISTERED', 'SESSIONS.REFERER');
    $sort_dir_array = array('ASC', 'DESC');

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'USER_FORUM.LAST_VISIT';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;
    if (!is_numeric($filter)) $filter = ADMIN_USER_FILTER_NONE;

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $user_get_all_array = array();

    $up_banned = USER_PERM_BANNED;

    switch ($filter) {

        case ADMIN_USER_FILTER_ONLINE: // Online Users

            $user_count_sql = "SELECT COUNT(DISTINCT SESSIONS.UID) AS USER_COUNT FROM SESSIONS ";
            $user_count_sql.= "WHERE SESSIONS.FID = '$forum_fid' AND SESSIONS.UID > 0";

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NOT NULL";

            break;

        case ADMIN_USER_FILTER_OFFLINE: // Offline Users

            $user_count_sql = "SELECT COUNT(DISTINCT USER.UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID ";
            $user_count_sql.= "AND SESSIONS.FID = '$forum_fid') ";
            $user_count_sql.= "WHERE SESSIONS.HASH IS NULL";

            $user_fetch_sql = "WHERE SESSIONS.HASH IS NULL";

            break;

        case ADMIN_USER_FILTER_APPROVAL: // Users awaiting approval

            $user_count_sql = "SELECT COUNT(DISTINCT USER.UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "WHERE USER.APPROVED IS NULL";

            $user_fetch_sql = "WHERE USER.APPROVED IS NULL";

            break;

        case ADMIN_USER_FILTER_BANNED: // Banned users

            $user_count_sql = "SELECT COUNT(DISTINCT USER.UID) AS USER_COUNT FROM USER ";
            $user_count_sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
            $user_count_sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
            $user_count_sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) AND GROUP_PERMS.FID = '0') ";
            $user_count_sql.= "WHERE GROUP_PERMS.PERM & $up_banned > 0";

            $user_fetch_sql = "WHERE GROUP_PERMS.PERM & $up_banned > 0";

            break;

        default:

            $user_count_sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER";

            $user_fetch_sql = "";

            break;
    }

    if (!$result = db_query($user_count_sql, $db_user_get_all)) return false;
    
    list($user_get_all_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, SESSIONS.HASH, ";
    $sql.= "SESSIONS.REFERER, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT FROM USER ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.UID = USER.UID) ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) AND GROUP_PERMS.FID = '0') ";
    $sql.= "LEFT JOIN USER_FORUM  ON (USER.UID = USER_FORUM.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') $user_fetch_sql ";
    $sql.= "GROUP BY USER.UID ORDER BY $sort_by $sort_dir LIMIT $offset, 10 ";

    if (!$result = db_query($sql, $db_user_get_all)) return false;

    if (db_num_rows($result) > 0) {

        while ($user_data = db_fetch_array($result)) {
            
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
* End user session
*
* Ends the session of the specified user
*
* @return bool
* @param integer $uid - UID of the user account to end session for.
*/

function admin_session_end($uid)
{
    $db_admin_session_end = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "DELETE FROM SESSIONS WHERE UID = '$uid' ";
    $sql.= "AND FID = '$forum_fid'";

    if (!$result = db_query($sql, $db_admin_session_end)) return false;

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

    $db_get_users_attachments = db_connect();

    if (!is_numeric($uid)) return false;

    if (!is_array($hash_array)) $hash_array = false;

    $forum_settings = forum_get_settings();

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    if (is_array($hash_array)) {

        $hash_list = implode("', '", preg_grep("/^[A-Fa-f0-9]{32}$/", $hash_array));

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

    while($attachment = db_fetch_array($result)) {

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
    $db_admin_get_forum_list = db_connect();

    if (!is_numeric($offset)) return false;

    $forums_array = array();

    $sql = "SELECT COUNT(FID) FROM FORUMS";

    if (!$result = db_query($sql, $db_admin_get_forum_list)) return false;

    list($forums_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT FORUMS.FID, FORUMS.WEBTAG, FORUMS.DEFAULT_FORUM, ";
    $sql.= "FORUM_SETTINGS.SVALUE AS FORUM_NAME FROM FORUMS ";
    $sql.= "LEFT JOIN FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID ";
    $sql.= "AND FORUM_SETTINGS.SNAME = 'forum_name') ";
    $sql.= "LIMIT $offset, 10 ";

    if (!$result = db_query($sql, $db_admin_get_forum_list)) return false;

    if (db_num_rows($result) > 0) {

        while($forum_data = db_fetch_array($result)) {

            if ($post_count = admin_forum_get_post_count($forum_data['FID'])) {
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
    $db_admin_forum_get_post_count = db_connect();

    if (!is_numeric($fid)) return false;

    if ($table_data = forum_get_table_prefix($fid)) {

        $sql = "SELECT COUNT(PID) FROM {$table_data['PREFIX']}POST";

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
    $db_admin_get_bandata = db_connect();

    $sort_by_array = array('ID', 'BANTYPE', 'BANDATA', 'COMMENT');
    $sort_dir_array = array('ASC', 'DESC');

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'ID';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return false;

    $ban_data_array = array();

    $sql = "SELECT COUNT(ID) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED";

    if (!$result = db_query($sql, $db_admin_get_bandata)) return false;
    
    list($ban_data_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT ID, BANTYPE, BANDATA, COMMENT FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_bandata)) return false;

    if (db_num_rows($result) > 0) {
    
        while ($ban_data = db_fetch_array($result)) {

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
    $db_admin_get_bandata = db_connect();

    if (!is_numeric($ban_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ID, BANTYPE, BANDATA, COMMENT FROM ";
    $sql.= "{$table_data['PREFIX']}BANNED WHERE ID = '$ban_id'";

    if (!$result = db_query($sql, $db_admin_get_bandata)) return false;

    if (db_num_rows($result) > 0) {
    
        $ban_data_array = db_fetch_array($result);
        return $ban_data_array;
    }

    return false;
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
    $db_admin_get_post_approval_queue = db_connect();

    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return false;

    if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {
        $fidlist = implode(',', $folder_list);
    }

    $post_approval_array = array();

    $sql = "SELECT COUNT(POST.PID) FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.TID = POST.TID) WHERE POST.APPROVED = '0' ";
    $sql.= "AND THREAD.FID IN ($fidlist)";

    if (!$result = db_query($sql, $db_admin_get_post_approval_queue)) return false;
    
    list($post_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT THREAD.TITLE, POST.TID, POST.PID, FOLDER.PREFIX ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = POST.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE POST.APPROVED = '0' AND THREAD.FID IN ($fidlist) ";
    $sql.= "LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_post_approval_queue)) return false;

    if (db_num_rows($result) > 0) {
    
        while ($post_array = db_fetch_array($result)) {

            if (isset($post_array['TID']) && isset($post_array['PID'])) {

                if (validate_msg("{$post_array['TID']}.{$post_array['PID']}")) {
            
                    $post_approval_array[] = $post_array;
                }
            }
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
    $db_admin_get_visitor_log = db_connect();

    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return false;

    $users_get_recent_array = array();
    $users_get_recent_count = 0;

    $lang = load_language_file();

    $uid = bh_session_get_value('UID');

    $forum_fid = $table_data['FID'];

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE LAST_LOGON IS NOT NULL AND LAST_LOGON > 0 ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_admin_get_visitor_log)) return false;
    
    list($users_get_recent_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "VISITOR_LOG.IPADDRESS, VISITOR_LOG.REFERER, ";
    $sql.= "SEB.SID, SEB.NAME, SEB.URL FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS SEB ";
    $sql.= "ON (SEB.SID = VISITOR_LOG.SID) ";
    $sql.= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
    $sql.= "AND VISITOR_LOG.FORUM = '$forum_fid' ";
    $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC LIMIT $offset, 10";

    if (!$result = db_query($sql, $db_admin_get_visitor_log)) return false;

    if (db_num_rows($result) > 0) {

        while ($visitor_array = db_fetch_array($result)) {

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

                if (preg_match("/^$forum_uri_preg/i", trim($visitor_array['REFERER'])) > 0) {
                    $visitor_array['REFERER'] = "";
                }

            }else {

                $visitor_array['REFERER'] = "";
            }

            $users_get_recent_array[] = $visitor_array;
            $users_get_recent_count++;
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

function admin_clear_visitor_log()
{
    $db_admin_clear_visitor_log = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "DELETE FROM VISITOR_LOG WHERE FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_admin_clear_visitor_log)) return false;

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

function admin_get_user_aliases($uid)
{
    $db_user_get_aliases = db_connect();

    $lang = load_language_file();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Initialise arrays

    $user_ip_address_array = array();
    $user_aliases_array = array();

    // Session UID

    $sess_uid = bh_session_get_value('UID');

    // Fetch the user's last 10 IP addresses from the POST table

    $sql = "SELECT DISTINCT IPADDRESS FROM {$table_data['PREFIX']}POST ";
    $sql.= "WHERE FROM_UID = '$uid' AND IPADDRESS IS NOT NULL ";
    $sql.= "AND LENGTH(IPADDRESS) > 0 LIMIT 0, 10";

    if (!$result = db_query($sql, $db_user_get_aliases)) return false;

    if (db_num_rows($result) > 0) {

        while ($user_get_aliases_row = db_fetch_array($result)) {

            if (strlen(trim($user_get_aliases_row['IPADDRESS'])) > 0) {
            
                $user_ip_address_array[] = $user_get_aliases_row['IPADDRESS'];
            }
        }
    }

    if ($ipaddress = user_get_last_ip_address($uid)) {
        $user_ip_address_array[] = $ipaddress;
    }

    // Search the POST table for any matches - limit 10 matches

    $user_ip_address_list = implode("' OR POST.IPADDRESS = '", $user_ip_address_array);

    if (strlen($user_ip_address_list) > 0) {

        $sql = "SELECT DISTINCT POST.FROM_UID AS UID, USER.LOGON, ";
        $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, POST.IPADDRESS ";
        $sql.= "FROM {$table_data['PREFIX']}POST POST ";
        $sql.= "LEFT JOIN USER USER ON (POST.FROM_UID = USER.UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$sess_uid') ";
        $sql.= "WHERE (POST.IPADDRESS = '$user_ip_address_list') ";
        $sql.= "AND POST.FROM_UID <> $uid LIMIT 0, 10";

        if (!$result = db_query($sql, $db_user_get_aliases)) return false;

        if (db_num_rows($result) > 0) {

            while($user_aliases = db_fetch_array($result)) {

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

function admin_get_user_history($uid)
{
    $db_admin_get_user_history = db_connect();

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
            
            while ($user_history_row = db_fetch_array($result, DB_RESULT_NUM)) {

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

function admin_clear_user_history($uid)
{
    $db_admin_clear_user_history = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "DELETE FROM USER_HISTORY WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_admin_clear_user_history)) return false;

    return (db_affected_rows($db_admin_clear_user_history) > 0);
}

function admin_approve_user($uid)
{
    $db_admin_approve_user = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "UPDATE USER SET APPROVED = NOW() WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_admin_approve_user)) return false;

    return (db_affected_rows($db_admin_approve_user) > 0);
}

?>