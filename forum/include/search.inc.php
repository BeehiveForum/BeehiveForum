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

/* $Id: search.inc.php,v 1.174 2007-03-01 14:34:28 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function search_execute($argarray, &$error)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Ensure the bare minimum of variables are set

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

        // Base query slightly different if you're not searching by keywords

        $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
        $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED, LENGTH) SELECT $uid, ";
        $select_sql.= "$forum_fid, THREAD.FID, POST.TID, POST.PID, THREAD.BY_UID, ";
        $select_sql.= "POST.FROM_UID, POST.TO_UID, POST.CREATED, THREAD.LENGTH ";

        // FROM query uses POST table if we're not using keyword searches.

        $from_sql = "FROM {$table_data['PREFIX']}POST POST ";

        // Join to the THREAD table for the TID

        $join_sql = "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = POST.TID) ";

        // Don't need a HAVING clause if we're not using MATCH(..) AGAINST(..)

        $having_sql = "";

        // Username argument can be an semi-colon separated list.

        $argarray['username_array'] = explode(";", $argarray['username']);

        foreach($argarray['username_array'] as $username) {
        
            if ($user_uid = user_get_uid(trim($username))) {

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
    }

    /// Keyword based search.

    if (isset($argarray['search_string']) && strlen(trim(_stripslashes($argarray['search_string']))) > 0) {

        $search_string = trim(_stripslashes($argarray['search_string']));

        $search_keywords_array = search_strip_keywords($search_string);

        $filtered_keyword_count   = $search_keywords_array['filtered_word_count'];
        $unfiltered_keyword_count = $search_keywords_array['unfiltered_word_count'];

        if ($filtered_keyword_count > 0 && $filtered_keyword_count == $unfiltered_keyword_count) {

            $from_sql = "FROM {$table_data['PREFIX']}POST_CONTENT POST_CONTENT ";

            $join_sql = "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = POST_CONTENT.TID) ";
            $join_sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID) ";

            $having_sql = "HAVING RELEVANCE > 0.2";

            // Include the keyword matching portion of the where clause.

            $bool_mode = (db_fetch_mysql_version() > 40010) ? " IN BOOLEAN MODE" : "";

            $search_string = addslashes(implode(' ', $search_keywords_array['keywords']));

            search_save_keywords($search_keywords_array['keywords']);

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
            $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED, LENGTH, RELEVANCE) ";
            $select_sql.= "SELECT $uid, $forum_fid, THREAD.FID, POST_CONTENT.TID, ";
            $select_sql.= "POST_CONTENT.PID, THREAD.BY_UID, POST.FROM_UID, POST.TO_UID, ";
            $select_sql.= "POST.CREATED, THREAD.LENGTH, MATCH(POST_CONTENT.CONTENT) ";
            $select_sql.= "AGAINST('$search_string'$bool_mode) AS RELEVANCE";

            $where_sql.= "AND MATCH(POST_CONTENT.CONTENT) AGAINST('$search_string'$bool_mode) ";

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

    $sql = "$select_sql $from_sql $join_sql $peer_join_sql ";
    $sql.= "$where_sql $peer_where_sql $group_sql $having_sql ";
    $sql.= "LIMIT 1000";

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

function search_strip_keywords($search_string, $strip_valid = false)
{
    // MySQL has a list of stop words for fulltext searches.
    // We'll save ourselves some server time by checking
    // them first.

    include(BH_INCLUDE_PATH. "search_stopwords.inc.php");

    // Filter the input so the user can't do anything dangerous with it

    $search_string = str_replace("%", "", $search_string);

    // Split the search string into boolean parts and clean out
    // the empty array values.

    $keyword_match = "([\+|-]?[\w']+)|([\+|-]?[\"][^\"]+[\"])";

    $keywords_array = preg_split("/$keyword_match/", $search_string, -1, PREG_SPLIT_DELIM_CAPTURE);
    $keywords_array = preg_grep("/^ {0,}$/", $keywords_array, PREG_GREP_INVERT);

    // Get the min and max word lengths that MySQL supports

    search_get_word_lengths($min_length, $max_length);

    // The number of boolean parts the user is searching for before
    // we remove the bad ones.

    $keywords_array = array_values($keywords_array);
    $unfiltered_keyword_count = sizeof($keywords_array);

    // Prepare the MySQL Full-Text stop word list

    array_walk($mysql_fulltext_stopwords, 'mysql_fulltext_callback', '/');
    $mysql_fulltext_stopwords = implode('[\"]?$|^[\+|-]?[\"]?', $mysql_fulltext_stopwords);

    // Filter the boolean parts through the MySQl Full-Text stop word list
    // and by checking individual words lengths.

    if ($strip_valid === true) {
        
        $keywords_array_length = preg_grep("/^[\+|-]?[\"]?[\w\s']{{$min_length},{$max_length}}[\"]?$/", $keywords_array, PREG_GREP_INVERT);
        $keywords_array_swords = preg_grep("/^[\+|-]?[\"]?{$mysql_fulltext_stopwords}[\"]?$/", $keywords_array);

        $keywords_array = array_merge($keywords_array_length, $keywords_array_swords);

    }else {
        
        $keywords_array = preg_grep("/^[\+|-]?[\"]?[\w\s']{{$min_length},{$max_length}}[\"]?$/", $keywords_array);
        $keywords_array = preg_grep("/^[\+|-]?[\"]?{$mysql_fulltext_stopwords}[\"]?$/", $keywords_array, PREG_GREP_INVERT);
    }

    // Remove any duplicate words, reindex the array and finally
    // count the number of boolean parts we're left with.
    // If they're less than the number the user gave us we have
    // an error somewhere.

    $keywords_array = array_unique($keywords_array);
    $keywords_array = array_values($keywords_array);

    $filtered_keyword_count = sizeof($keywords_array);

    return array('keywords' => $keywords_array,
                 'unfiltered_word_count' => $unfiltered_keyword_count,
                 'filtered_word_count'   => $filtered_keyword_count);
}

function search_strip_special_chars($keywords_array, $remove_non_matches = true)
{
    if (!is_array($keywords_array)) return false;
    if (!is_bool($remove_non_matches)) $remove_non_matches = true;
    
    // Get the min and max word lengths that MySQL supports

    search_get_word_lengths($min_length, $max_length);

    // Expression to match words prefixed with a hyphen (for do not match)

    if ($remove_non_matches === true) {

        $boolean_non_match = "/^-[\"]?([\w\s']){{$min_length},{$max_length}}[\"]?$/";
        
        $keywords_array = preg_grep($boolean_non_match, $keywords_array, PREG_GREP_INVERT);
        $keywords_array = preg_replace('/["|\+|\x00]+/', '', $keywords_array);

    }else {

        $keywords_array = preg_replace('/["|\+|\-|\x00]+/', '', $keywords_array);
    }

    // return array

    return $keywords_array;
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

function search_save_keywords($keywords_array)
{
    $db_search_save_keywords = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_array($keywords_array)) return false;

    $keywords_array = search_strip_special_chars($keywords_array);

    $keywords = addslashes(implode("\x00", $keywords_array));

    $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
    $sql.= "SET LAST_SEARCH_KEYWORDS = '$keywords' ";
    $sql.= "WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_search_save_keywords)) return false;

    return true;
}

function search_get_keywords()
{
    $db_search_get_keywords = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT LAST_SEARCH_KEYWORDS FROM ";
    $sql.= "{$table_data['PREFIX']}USER_TRACK ";
    $sql.= "WHERE UID = '$uid'";

    $result = db_query($sql, $db_search_get_keywords);

    if (db_num_rows($result) > 0) {

        list($keywords_string) = db_fetch_array($result, DB_RESULT_NUM);
        $keywords_array = explode("\x00", $keywords_string);

        if (is_array($keywords_array) && sizeof($keywords_array) > 0) {

            return $keywords_array;
        }
    }

    return false;
}

function search_fetch_results($offset, $sortby, $sortdir)
{
    $db_search_fetch_results = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!in_array($sortdir, array('DESC', 'ASC'))) {
        $sortdir = 'DESC';
    }

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT COUNT(*) AS RESULT_COUNT FROM SEARCH_RESULTS WHERE UID = $uid";
    $result = db_query($sql, $db_search_fetch_results);

    list($result_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($result_count > 0) {

        $sql = "SELECT SEARCH_RESULTS.FID, SEARCH_RESULTS.TID, SEARCH_RESULTS.PID, ";
        $sql.= "SEARCH_RESULTS.BY_UID, SEARCH_RESULTS.FROM_UID, SEARCH_RESULTS.TO_UID, ";
        $sql.= "USER_TRACK.LAST_SEARCH_KEYWORDS AS KEYWORDS, UNIX_TIMESTAMP(CREATED) AS CREATED, ";
        $sql.= "USER.LOGON AS FROM_LOGON, USER.NICKNAME AS FROM_NICKNAME FROM SEARCH_RESULTS ";
        $sql.= "LEFT JOIN USER ON (USER.UID = SEARCH_RESULTS.FROM_UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
        $sql.= "ON (USER_TRACK.UID = SEARCH_RESULTS.UID) ";
        $sql.= "WHERE SEARCH_RESULTS.UID = '$uid' ";

        switch($sortby) {
        
            case SEARCH_SORT_NUM_REPLIES:

                $sql.= "ORDER BY SEARCH_RESULTS.LENGTH $sortdir LIMIT $offset, 20";
                break;

            case SEARCH_SORT_FOLDER_NAME:

                $sql.= "ORDER BY SEARCH_RESULTS.FID $sortdir LIMIT $offset, 20";
                break;

            case SEARCH_SORT_AUTHOR_NAME:

                $sql.= "ORDER BY FROM_USER $sortdir LIMIT $offset, 20";
                break;

            default:

                $sql.= "ORDER BY SEARCH_RESULTS.CREATED $sortdir LIMIT $offset, 20";
                break;
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

function search_get_first_result_msg()
{
    $db_search_fetch_results = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT SEARCH_RESULTS.TID, SEARCH_RESULTS.PID FROM SEARCH_RESULTS ";
    $sql.= "WHERE SEARCH_RESULTS.UID = '$uid' ";
    $sql.= "ORDER BY SEARCH_RESULTS.CREATED DESC ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_search_fetch_results);

    if (db_num_rows($result) > 0) {

        list($tid, $pid) = db_fetch_array($result, DB_RESULT_NUM);
        return "$tid.$pid";
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

    if (($uid = bh_session_get_value('UID')) === false) return false;

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

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT FID, TITLE FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY FID ";

    $result = db_query($sql, $db_folder_search_dropdown);

    if (db_num_rows($result) > 0) {

        while($folder_data = db_fetch_array($result)) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                    $folders['FIDS'][]   = $folder_data['FID'];
                    $folders['TITLES'][] = $folder_data['TITLE'];
                }

            }else {
            
                if (bh_session_check_perm($access_allowed, $folder_data['FID'])) {

                    $folders['FIDS'][]   = $folder_data['FID'];
                    $folders['TITLES'][] = $folder_data['TITLE'];
                }
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            array_unshift($folders['FIDS'], 0);
            array_unshift($folders['TITLES'], $lang['all_caps']);

            return form_dropdown_array("fid", $folders['FIDS'], $folders['TITLES'], 0, false, "search_dropdown");
        }
    }
}

function check_search_frequency()
{
    $db_check_search_frequency = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $search_min_frequency = intval(forum_get_setting('search_min_frequency', false, 30));

    if ($search_min_frequency == 0) return true;

    $sql = "SELECT UNIX_TIMESTAMP(LAST_SEARCH) + $search_min_frequency, ";
    $sql.= "UNIX_TIMESTAMP(NOW()) FROM {$table_data['PREFIX']}USER_TRACK ";
    $sql.= "WHERE UID = '$uid'";

    $result = db_query($sql, $db_check_search_frequency);

    if (db_num_rows($result) > 0) {

        list($last_search_stamp, $current_timestamp) = db_fetch_array($result);

        if (!is_numeric($last_search_stamp) || $last_search_stamp < $current_timestamp) {

            $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
            $sql.= "SET LAST_SEARCH = NOW() WHERE UID = '$uid'";

            $result = db_query($sql, $db_check_search_frequency);

            return true;
        }

    }else{

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_TRACK ";
        $sql.= "(UID, LAST_SEARCH) VALUES ('$uid', NOW())";

        $result = db_query($sql, $db_check_search_frequency);

        return true;
    }

    return false;
}

function search_output_opensearch_xml()
{
    $webtag = get_webtag($webtag_search);

    $forum_path = html_get_forum_uri();

    $title = forum_get_setting('forum_name', false, 'A Beehive Forum');

    echo "<?xml version=\"1.0\"?>\n";
    echo "<OpenSearchDescription xmlns=\"http://a9.com/-/spec/opensearch/1.1/\">\n";
    echo "<ShortName>$title</ShortName>\n";
    echo "<Description>$title</Description>\n";
    echo "<Image height=\"16\" width=\"16\" type=\"image/x-icon\">$forum_path/forums/$webtag/favicon.ico</Image>\n";
    echo "<Url type=\"text/html\" method=\"get\" template=\"$forum_path/search.php?search_string={searchTerms}\"/>\n";
    echo "</OpenSearchDescription>\n";
}

function mysql_fulltext_callback(&$item, $key, $delimiter)
{
    $item = preg_quote($item, $delimiter);
}

?>