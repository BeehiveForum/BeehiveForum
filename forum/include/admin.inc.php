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

/* $Id: admin.inc.php,v 1.81 2006-10-29 23:07:23 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "perm.inc.php");

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

    $data = addslashes($data);

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

    $sort_by_array  = array('CREATED', 'UID', 'ACTION');
    $sort_dir_array = array('ASC', 'DESC');

    $admin_log_array = array();

    if (!is_numeric($offset)) $offset = 0;

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'CREATED';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(ID) AS LOG_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}ADMIN_LOG ";

    if (!$result = db_query($sql, $db_admin_get_log_entries)) return false;

    list($admin_log_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT ADMIN_LOG.ID, UNIX_TIMESTAMP(ADMIN_LOG.CREATED) AS CREATED, ";
    $sql.= "ADMIN_LOG.UID, ADMIN_LOG.ACTION, ADMIN_LOG.ENTRY, USER.LOGON, USER.NICKNAME ";
    $sql.= "FROM {$table_data['PREFIX']}ADMIN_LOG ADMIN_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = ADMIN_LOG.UID) ";
    $sql.= "ORDER BY ADMIN_LOG.$sort_by $sort_dir LIMIT $offset, 20";

    if (!$result = db_query($sql, $db_admin_get_log_entries)) return false;

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            $admin_log_array[] = $row;
        }
    }

    return array('admin_log_count' => $admin_log_count,
                 'admin_log_array' => $admin_log_array);
}

/**
* Fetches admin word filter
*
* Fetches the available word filter entries into an array
*
* @return bool
* @param void
*/

function admin_get_word_filter()
{
    $db_admin_get_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $sql = "SELECT * FROM {$table_data['PREFIX']}FILTER_LIST ";
    $sql.= "WHERE UID = 0 ORDER BY ID";

    if (!$result = db_query($sql, $db_admin_get_word_filter)) return false;

    $filter_array = array();

    while($row = db_fetch_array($result)) {
        $filter_array[$row['ID']] = $row;
    }

    return $filter_array;
}

/**
* Delete an entry in the word filter
*
* Fetches the available attachments based on the provided parameters that match $aid
*
* @return bool
* @param integer $id - Filter entry ID
*/

function admin_delete_word_filter($id)
{
    if (!is_numeric($id)) return false;

    $db_user_delete_word_filter = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}FILTER_LIST ";
    $sql.= "WHERE ID = '$id' AND UID = 0";

    $result = db_query($sql, $db_user_delete_word_filter);
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

    $sql = "DELETE FROM {$table_data['PREFIX']}FILTER_LIST WHERE UID = 0";
    return db_query($sql, $db_admin_clear_word_filter);
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

function admin_add_word_filter($match, $replace, $filter_option)
{
    $match = addslashes($match);
    $replace = addslashes($replace);

    if (!is_numeric($filter_option)) $filter_option = 0;

    $db_admin_add_word_filter = db_connect();
    
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}FILTER_LIST (MATCH_TEXT, REPLACE_TEXT, FILTER_OPTION) ";
    $sql.= "VALUES ('$match', '$replace', '$filter_option')";

    $result = db_query($sql, $db_admin_add_word_filter);
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

function admin_update_word_filter($filter_id, $match, $replace, $filter_option)
{
    if (!is_numeric($filter_id)) return false;
    if (!is_numeric($filter_option)) $filter_option = 0;

    $match = addslashes($match);
    $replace = addslashes($replace);

    $db_admin_add_word_filter = db_connect();
    
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}FILTER_LIST SET MATCH_TEXT = '$match', ";
    $sql.= "REPLACE_TEXT = '$replace', FILTER_OPTION = '$filter_option' ";
    $sql.= "WHERE ID = '$filter_id'";

    $result = db_query($sql, $db_admin_add_word_filter);
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

function admin_user_search($usersearch, $sort_by = 'VISITOR_LOG.LAST_LOGON', $sort_dir = 'DESC', $offset = 0)
{
    $db_user_search = db_connect();

    $sort_by_array = array('USER.UID', 'USER.LOGON', 'VISITOR_LOG.LAST_LOGON', 'SESSIONS.REFERER');
    $sort_dir_array = array('ASC', 'DESC');

    $usersearch = addslashes($usersearch);

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'VISITOR_LOG.LAST_LOGON';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (!is_numeric($offset)) $offset = 0;

    $user_search_array = array();

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER ";
    $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";

    $result = db_query($sql, $db_user_search);
    list($user_search_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($table_data = get_table_prefix()) {

        $forum_fid = $table_data['FID'];

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, SESSIONS.HASH, SESSIONS.REFERER, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
        $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID AND VISITOR_LOG.FORUM = $forum_fid) ";
        $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    }else {

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
        $sql.= "SESSIONS.HASH, SESSIONS.REFERER FROM USER USER ";
        $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
        $sql.= "WHERE (USER.LOGON LIKE '$usersearch%' OR USER.NICKNAME LIKE '$usersearch%') ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    $result = db_query($sql, $db_user_search);

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            if (!isset($user_search_array[$row['UID']])) {

                $user_search_array[$row['UID']] = $row;
            }
        }
    }

    return array('user_count' => $user_search_count,
                 'user_array' => $user_search_array);
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

function admin_user_get_all($sort_by = 'VISITOR_LOG.LAST_LOGON', $sort_dir = 'ASC', $offset = 0)
{
    $db_user_get_all = db_connect();
    $user_get_all_array = array();

    $sort_by_array  = array('USER.UID', 'USER.LOGON', 'VISITOR_LOG.LAST_LOGON', 'SESSIONS.REFERER');
    $sort_dir_array = array('ASC', 'DESC');

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'VISITOR_LOG.LAST_LOGON';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'ASC';

    if (!is_numeric($offset)) $offset = 0;

    $user_get_all_array = array();

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER";

    $result = db_query($sql, $db_user_get_all);
    list($user_get_all_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($table_data = get_table_prefix()) {

        $forum_fid = $table_data['FID'];

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, SESSIONS.HASH, SESSIONS.REFERER, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
        $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
        $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID AND VISITOR_LOG.FORUM = $forum_fid) ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";

    }else {

        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
        $sql.= "SESSIONS.HASH, SESSIONS.REFERER FROM USER USER ";
        $sql.= "LEFT JOIN SESSIONS SESSIONS ON (SESSIONS.UID = USER.UID) ";
        $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 20";
    }

    $result = db_query($sql, $db_user_get_all);

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            if (!isset($user_get_all_array[$row['UID']])) {

                $user_get_all_array[$row['UID']] = $row;
            }
        }
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
    $sql.= "AND FID = $forum_fid";

    return db_query($sql, $db_admin_session_end);
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

    if (!$table_data = get_table_prefix()) return $userattachments;

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

    $result = db_query($sql, $db_get_users_attachments);

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
* Fetches a list of forums and their settings
*
* @return array
* @param void
*/

function admin_get_forum_list()
{
    $db_get_forum_list = db_connect();
    $get_forum_list_array = array();

    $sql = "SELECT * FROM FORUMS ORDER BY FID";
    $result_forums = db_query($sql, $db_get_forum_list);

    while ($forum_data = db_fetch_array($result_forums)) {

        // Get the Forum Name

        $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
        $sql.= "WHERE SNAME = 'forum_name' AND FID = '{$forum_data['FID']}'";

        $result_forum_name = db_query($sql, $db_get_forum_list);

        if (db_num_rows($result_forum_name) > 0) {

            $row = db_fetch_array($result_forum_name);
            $forum_data['FORUM_NAME'] = $row['FORUM_NAME'];

        }else {

            $forum_data['FORUM_NAME'] = "Unnamed Forum";
        }

        // Get the Description

        $sql = "SELECT SVALUE AS DESCRIPTION FROM FORUM_SETTINGS WHERE ";
        $sql.= "FORUM_SETTINGS.FID = {$forum_data['FID']} AND ";
        $sql.= "FORUM_SETTINGS.SNAME = 'forum_desc'";

        $result_description = db_query($sql, $db_get_forum_list);

        if (db_num_rows($result_description) > 0) {

            $row = db_fetch_array($result_description);
            $forum_data['DESCRIPTION'] = $row['DESCRIPTION'];

        }else{

            $forum_data['DESCRIPTION'] = "";
        }

        // Get number of messages on forum

        $forum_data['MESSAGES'] = 0;

        $sql = "SHOW TABLES LIKE '{$forum_data['WEBTAG']}_POST'";
        $result = db_query($sql, $db_get_forum_list);

        if (db_num_rows($result) > 0) {

            $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$forum_data['WEBTAG']}_POST POST ";
            $result_post_count = db_query($sql, $db_get_forum_list);

            if (db_num_rows($result_post_count) > 0) {

                $row = db_fetch_array($result_post_count);
                $forum_data['MESSAGES'] = $row['POST_COUNT'];
            }
        }

        $get_forum_list_array[] = $forum_data;
    }

    return $get_forum_list_array;
}

/**
* Fetch ban data
*
* Fetches available ban data
*
* @return array
* @void
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

    $result = db_query($sql, $db_admin_get_bandata);
    list($ban_data_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT ID, BANTYPE, BANDATA, COMMENT FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    $result = db_query($sql, $db_admin_get_bandata);

    while ($row = db_fetch_array($result)) {

        $ban_data_array[$row['ID']] = $row;
    }

    return array('ban_count' => $ban_data_count,
                 'ban_array' => $ban_data_array);
}

function admin_get_ban($ban_id)
{
    $db_admin_get_bandata = db_connect();

    if (!is_numeric($ban_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ID, BANTYPE, BANDATA, COMMENT FROM ";
    $sql.= "{$table_data['PREFIX']}BANNED WHERE ID = '$ban_id'";

    $result = db_query($sql, $db_admin_get_bandata);

    if (db_num_rows($result) > 0) {
    
        $ban_data_array = db_fetch_array($result);
        return $ban_data_array;
    }

    return false;
}

?>