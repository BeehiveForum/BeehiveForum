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

/* $Id: search.inc.php,v 1.146 2005-10-20 22:08:15 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function search_execute($argarray, &$error)
{
    $uid = bh_session_get_value('UID');

    // MySQL has a list of stop words for fulltext searches.
    // We'll save ourselves some server time by checking
    // them first.

    include(BH_INCLUDE_PATH. "search_stopwords.inc.php");

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Ensure the bare minimum of variables are set

    if (!isset($argarray['method']) || !is_numeric($argarray['method'])) $argarray['method'] = 1;
    if (!isset($argarray['date_from']) || !is_numeric($argarray['date_from'])) $argarray['date_from'] = 7;
    if (!isset($argarray['date_to']) || !is_numeric($argarray['date_to'])) $argarray['date_to'] = 2;
    if (!isset($argarray['group_by_thread']) || !is_numeric($argarray['group_by_thread'])) $argarray['group_by_thread'] = 0;
    if (!isset($argarray['sstart']) || !is_numeric($argarray['sstart'])) $argarray['sstart'] = 0;
    if (!isset($argarray['fid']) || !is_numeric($argarray['fid'])) $argarray['fid'] = 0;
    if (!isset($argarray['include']) || !is_numeric($argarray['include'])) $argarray['include'] = 2;
    if (!isset($argarray['username']) || strlen(trim($argarray['username'])) < 1) $argarray['username'] = "";
    if (!isset($argarray['user_include']) || !is_numeric($argarray['user_include'])) $argarray['user_include'] = 1;

    $db_search_execute = db_connect();

    // Each user can only store one search result so we should
    // clean up their previous search if applicable.

    $sql = "DELETE FROM SEARCH_RESULTS WHERE UID = $uid";
    $result = db_query($sql, $db_search_execute);

    // Base query parts - the same for all seraches

    $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
    $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED) SELECT $uid, ";
    $select_sql.= "$forum_fid, THREAD.FID, POST_CONTENT.TID, POST_CONTENT.PID, ";
    $select_sql.= "THREAD.BY_UID, POST.FROM_UID, POST.TO_UID, POST.CREATED ";

    $from_sql = "FROM {$table_data['PREFIX']}POST_CONTENT POST_CONTENT ";

    $join_sql = "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = POST_CONTENT.TID) ";
    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID) ";

    // Peer portion of the query for removing rows from ignored users - the same for all searches

    $peer_join_sql = "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $peer_join_sql.= "ON (USER_PEER.PEER_UID = THREAD.BY_UID AND USER_PEER.UID = $uid) ";

    $peer_where_sql = "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. ") = 0 ";
    $peer_where_sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $peer_where_sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED. ") = 0 ";
    $peer_where_sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";

    // Get available folders

    $folders = folder_get_available();

    // If the user has specified a folder within their viewable scope limit them
    // to that folder, otherwise limit them to their available folders.

    if (isset($argarray['fid']) && in_array($argarray['fid'], explode(",", $folders))) {
        $where_sql = "WHERE THREAD.FID = {$argarray['fid']} ";
    }else{
        $where_sql = "WHERE THREAD.FID IN ($folders) ";
    }

    // Where query needs to limit the search results to the user specified date range.

    $where_sql.= search_date_range($argarray['date_from'], $argarray['date_to']);

    // Username based search.

    if (isset($argarray['username']) && strlen(trim($argarray['username'])) > 0) {

        if ($user_uid = user_get_uid($argarray['username'])) {

            if ($argarray['user_include'] == 1) {

                $where_sql.= "AND POST.FROM_UID = '{$user_uid['UID']}' ";

            }elseif ($argarray['user_include'] == 2) {

                $where_sql.= "AND POST.TO_UID = '{$user_uid['UID']}' ";

            }else {

                $where_sql.= "AND (POST.FROM_UID = '{$user_uid['UID']}' ";
                $where_sql.= "OR POST.TO_UID = '{$user_uid['UID']}') ";
            }

        }else {

            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }
    }

    /// Keyword based search.

    if (isset($argarray['search_string']) && strlen(trim($argarray['search_string'])) > 0) {

        // Filter the input so the user can't do anything dangerous with it

        $argarray['search_string'] = str_replace("%", "", $argarray['search_string']);
        $argarray['search_string'] = _htmlentities($argarray['search_string']);

        // Remove any keywords which are under the minimum length.

        $keywords_array = explode(' ', trim($argarray['search_string']));

        array_walk($mysql_fulltext_stopwords, 'mysql_fulltext_callback', '/');
        $mysql_fulltext_stopwords = implode('$|^', $mysql_fulltext_stopwords);

        $keywords_array = array_unique($keywords_array);

        search_get_word_lengths($min_length, $max_length);

        $keywords_array = preg_grep("/^[\w']{{$min_length},{$max_length}}$/", $keywords_array);
        $keywords_array = preg_grep("/^[\d]+$|^$mysql_fulltext_stopwords$/", $keywords_array, PREG_GREP_INVERT);

        $keyword_count = sizeof($keywords_array);

        if ($keyword_count > 0) {

            // Include the keyword matching portion of the where clause.

            $bool_mode = (db_fetch_mysql_version() > 40010) ? " IN BOOLEAN MODE" : "";

            if ($argarray['method'] == 1) { // AND

                $where_sql.= "AND MATCH(POST_CONTENT.CONTENT) AGAINST('+";
                $where_sql.= implode('+', $keywords_array);
                $where_sql.= "'$bool_mode) ";

            }elseif ($argarray['method'] == 2) { // OR

                $where_sql.= "AND MATCH(POST_CONTENT.CONTENT) AGAINST('";
                $where_sql.= implode(' ', $keywords_array);
                $where_sql.= "'$bool_mode) ";
            }

        }else {

            $error = SEARCH_NO_KEYWORDS;
            return false;
        }

    }else {

        if (!isset($argarray['username']) || strlen(trim($argarray['username'])) < 1) {

            $error = SEARCH_NO_KEYWORDS;
            return false;
        }
    }

    // If the user wants results grouped by thread (TID) then do so. We still group
    // by TID, PID otherwise AND based searches won't work.

    if (isset($argarray['group_by_thread']) && $argarray['group_by_thread'] == 1) {
        $group_sql = "GROUP BY THREAD.TID ";
    }else {
        $group_sql = "";
    }

    // Build the final query.

    $sql = "$select_sql $from_sql $join_sql $peer_join_sql $where_sql ";
    $sql.= "$peer_where_sql $group_sql";

    // If the user has performed a search within the last x minutes bail out

    if (!check_search_frequency() && !defined('BEEHIVE_INSTALL_NOWARN')) {

        $error = SEARCH_FREQUENCY_TOO_GREAT;
        return false;
    }

    // Execute the query

    if ($result = db_query($sql, $db_search_execute)) {

        return true;
    }

    $error = SEARCH_NO_MATCHES;
    return false;
}

function search_get_word_lengths(&$min_length, &$max_length)
{
    $db_search_get_word_lengths = db_connect();

    $sql = "SHOW VARIABLES LIKE 'ft_%'";
    $result = db_query($sql, $db_search_get_word_lengths);

    $min_length = 4;
    $max_length = 84;

    while ($row = db_fetch_array($result)) {

        if (isset($row['Variable_name']) && isset($row['Value'])) {

            if ($row['Variable_name'] == 'ft_max_word_len') {
                $max_length = $row['Value'];
            }

            if ($row['Variable_name'] == 'ft_min_word_len') {
                $min_length = $row['Value'];
            }
        }
    }
}

function search_fetch_results($offset, $order_by)
{
    $db_search_fetch_results = db_connect();

    $uid = bh_session_get_value('UID');

    $sql = "SELECT COUNT(*) AS RESULT_COUNT FROM SEARCH_RESULTS WHERE UID = $uid";
    $result = db_query($sql, $db_search_fetch_results);

    list($result_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($result_count > 0) {

        if ($order_by == 1) {

            $sql = "SELECT FID, TID, PID, BY_UID, FROM_UID, TO_UID, ";
            $sql.= "UNIX_TIMESTAMP(CREATED) AS CREATED FROM SEARCH_RESULTS ";
            $sql.= "WHERE UID = $uid ORDER BY CREATED DESC LIMIT $offset, 20";

        }else {

            $sql = "SELECT FID, TID, PID, BY_UID, FROM_UID, TO_UID, ";
            $sql.= "UNIX_TIMESTAMP(CREATED) AS CREATED FROM SEARCH_RESULTS ";
            $sql.= "WHERE UID = $uid ORDER BY CREATED ASC LIMIT $offset, 20";
        }

        $result = db_query($sql, $db_search_fetch_results);

        $search_results_array = array();

        while ($search_result = db_fetch_array($result)) {
            $search_results_array[] = $search_result;
        }

        return array('result_count' => $result_count,
                     'result_array' => $search_results_array);
    }

    return false;
}

function search_date_range($from, $to)
{
    $year  = date('Y', mktime());
    $month = date('n', mktime());
    $day   = date('j', mktime());

    $range = "";

    switch($from) {

      case 1:  // Today

        $from_timestamp = mktime(0, 0, 0, $month, $day, $year);
        break;

      case 2:  // Yesterday

        $from_timestamp = mktime(0, 0, 0, $month, $day - 1, $year);
        break;

      case 3:  // Day before yesterday

        $from_timestamp = mktime(0, 0, 0, $month, $day - 2, $year);
        break;

      case 4:  // 1 week ago

        $from_timestamp = mktime(0, 0, 0, $month, $day - 7, $year);
        break;

      case 5:  // 2 weeks ago

        $from_timestamp = mktime(0, 0, 0, $month, $day - 14, $year);
        break;

      case 6:  // 3 weeks ago

        $from_timestamp = mktime(0, 0, 0, $month, $day - 21, $year);
        break;

      case 7:  // 1 month ago

        $from_timestamp = mktime(0, 0, 0, $month - 1, $day, $year);
        break;

      case 8:  // 2 months ago

        $from_timestamp = mktime(0, 0, 0, $month - 2, $day, $year);
        break;

      case 9:  // 3 months ago

        $from_timestamp = mktime(0, 0, 0, $month - 3, $day, $year);
        break;

      case 10: // 6 months ago

        $from_timestamp = mktime(0, 0, 0, $month - 6, $day, $year);
        break;

      case 11: // 1 year ago

        $from_timestamp = mktime(0, 0, 0, $month, $day, $year - 1);
        break;

    }

    switch($to) {

      case 1:  // Now

        $to_timestamp = mktime();
        break;

      case 2:  // Today

        $to_timestamp = mktime(23, 59, 59, $month, $day, $year);
        break;

      case 3:  // Yesterday

        $to_timestamp = mktime(23, 59, 59, $month, $day - 1, $year);
        break;

      case 4:  // Day before yesterday

        $to_timestamp = mktime(23, 59, 59, $month, $day - 2, $year);
        break;

      case 5:  // 1 week ago

        $to_timestamp = mktime(23, 59, 59, $month, $day - 7, $year);
        break;

      case 6:  // 2 weeks ago

        $to_timestamp = mktime(23, 59, 59, $month, $day - 14, $year);
        break;

      case 7:  // 3 weeks ago

        $to_timestamp = mktime(23, 59, 59, $month, $day - 21, $year);
        break;

      case 8:  // 1 month ago

        $to_timestamp = mktime(23, 59, 59, $month - 1, $day, $year);
        break;

      case 9:  // 2 months ago

        $to_timestamp = mktime(23, 59, 59, $month - 2, $day, $year);
        break;

      case 10: // 3 months ago

        $to_timestamp = mktime(23, 59, 59, $month - 3, $day, $year);
        break;

      case 11: // 6 months ago

        $to_timestamp = mktime(23, 59, 59, $month - 6, $day, $year);
        break;

      case 12: // 1 year ago

        $to_timestamp = mktime(23, 59, 59, $month, $day, $year - 1);
        break;

    }

    if (isset($from_timestamp)) $range = "AND POST.CREATED >= FROM_UNIXTIME($from_timestamp) ";
    if (isset($to_timestamp)) $range.= "AND POST.CREATED <= FROM_UNIXTIME($to_timestamp) ";

    return $range;
}

function forum_search_dropdown()
{
    $lang = load_language_file();

    $db_forum_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FORUMS.FID, FORUM_SETTINGS.SVALUE FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID ";
    $sql.= "AND FORUM_SETTINGS.SNAME = 'forum_name') ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID) ";
    $sql.= "WHERE FORUMS.ACCESS_LEVEL = 0 OR FORUMS.ACCESS_LEVEL = 2 ";
    $sql.= "OR (FORUMS.ACCESS_LEVEL = 1 AND USER_FORUM.ALLOWED = 1) ";

    $result = db_query($sql, $db_forum_search_dropdown);

    if (db_num_rows($result) > 0) {

        $forums_array[0] = $lang['all_caps'];

        while($row = db_fetch_array($result)) {

            $forums_array[$row['FID']] = $row['SVALUE'];
        }

        return form_dropdown_array("forums", array_keys($forums_array), array_values($forums_array), $forum_fid, false, "search_dropdown");
    }

    return false;
}

function folder_search_dropdown()
{
    $lang = load_language_file();

    $db_folder_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
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

    $result = db_query($sql, $db_folder_search_dropdown);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            if (($row['FOLDER_PERMS'] & USER_PERM_GUEST_ACCESS) > 0 || !user_is_guest()) {

                if ($row['USER_PERM_COUNT'] > 0 && ($row['USER_STATUS'] & $access_allowed) > 0) {

                    $folders['FIDS'][] = $row['FID'];
                    $folders['TITLES'][] = $row['TITLE'];

                }elseif ($row['FOLDER_PERM_COUNT'] > 0 && ($row['FOLDER_PERMS'] & $access_allowed) > 0) {

                    $folders['FIDS'][] = $row['FID'];
                    $folders['TITLES'][] = $row['TITLE'];

                }elseif ($row['FOLDER_PERM_COUNT'] == 0 && $row['USER_PERM_COUNT'] == 0) {

                    $folders['FIDS'][] = $row['FID'];
                    $folders['TITLES'][] = $row['TITLE'];
                }
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            array_unshift($folders['FIDS'], 0);
            array_unshift($folders['TITLES'], $lang['all_caps']);

            return form_dropdown_array("fid", $folders['FIDS'], $folders['TITLES'], 0, false, "search_dropdown");
        }
    }

    return false;
}

function search_draw_user_dropdown($name)
{
    $lang = load_language_file();

    $db_search_draw_user_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return "";

    $forum_fid = $table_data['FID'];

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON ";
    $sql.= "(USER.UID = VISITOR_LOG.UID AND VISITOR_LOG.FORUM = $forum_fid) ";
    $sql.= "WHERE USER.UID <> '$uid' ";
    $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    $result = db_query($sql, $db_search_draw_user_dropdown);

    $uids[]  = 0;
    $names[] = $lang['all_caps'];

    if ($uid > 0) {

        $uids[]  = $uid;
        $names[] = $lang['me_caps'];
    }

    while($row = db_fetch_array($result)) {

      $uids[]  = $row['UID'];
      $names[] = format_user_name($row['LOGON'], $row['NICKNAME']);

    }

    return form_dropdown_array($name, $uids, $names, 0, false, "search_dropdown");
}

function check_search_frequency()
{
    $db_check_search_frequency = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $search_min_frequency = intval(forum_get_setting('search_min_frequency', false, 30));

    if ($search_min_frequency == 0) return true;

    $search_stamp = time() - $search_min_frequency;

    $sql = "SELECT UNIX_TIMESTAMP(LAST_SEARCH) FROM USER_TRACK WHERE UID = '$uid'";
    $result = db_query($sql, $db_check_search_frequency);

    if (db_num_rows($result) > 0) {

        list($last_search_check) = db_fetch_array($result);

        if ($last_search_check < $search_stamp) {

            $sql = "UPDATE USER_TRACK SET LAST_SEARCH = NOW() WHERE UID = '$uid'";
            $result = db_query($sql, $db_check_search_frequency);

            return true;
        }

    }else{

        $sql = "INSERT INTO USER_TRACK (UID, LAST_SEARCH) ";
        $sql.= "VALUES ('$uid', NOW())";

        $result = db_query($sql, $db_check_search_frequency);

        return true;
    }

    return false;
}

function mysql_fulltext_callback(&$item, $key, $delimiter)
{
    $item = preg_quote($item, $delimiter);
}

?>