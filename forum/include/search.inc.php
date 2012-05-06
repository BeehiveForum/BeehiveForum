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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "sphinx.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function search_execute($search_arguments, &$error)
{
    if (($uid = session_get_value('UID')) === false) return false;

    // Database connection.
    if (!$db_search_execute = db_connect()) return false;

    // Ensure the date_from argument is set
    if (!isset($search_arguments['date_from']) || !is_numeric($search_arguments['date_from'])) {
        $search_arguments['date_from'] = SEARCH_FROM_ONE_MONTH_AGO;
    }

    // Ensure the date_to argument is set.
    if (!isset($search_arguments['date_to']) || !is_numeric($search_arguments['date_to'])) {
        $search_arguments['date_to'] = SEARCH_TO_TODAY;
    }

    // Ensure the sort_by argument is set.
    if (!isset($search_arguments['sort_by']) || !is_numeric($search_arguments['sort_by'])) {
        $search_arguments['sort_by'] = SEARCH_SORT_CREATED;
    }

    // Ensure the sort_dir argument is set.
    if (!isset($search_arguments['sort_dir']) || !is_numeric($search_arguments['sort_dir'])) {
        $search_arguments['sort_dir'] = SEARCH_SORT_DESC;
    }

    // Check the sort_dir is valid
    if (!in_array($search_arguments['sort_dir'], array(SEARCH_SORT_ASC, SEARCH_SORT_DESC))) {
        $search_arguments['sort_dir'] = SEARCH_SORT_DESC;
    }

    // Get available folders
    $folders_array = folder_get_available_array();

    // Check the selected folder is valid
    if (!isset($search_arguments['fid']) || !in_array($search_arguments['fid'], $folders_array)) {
        $search_arguments['fid'] = implode(',', $folders_array);
    }

    // Username based search.
    if (isset($search_arguments['username']) && strlen(trim($search_arguments['username'])) > 0) {

        // Make sure the uid_array key is an empty array.
        $search_arguments['user_uid_array'] = array();

        // Username argument is a semi-colon separated list.
        $search_arguments['username_array'] = array_map('trim', explode(';', $search_arguments['username']));

        // Iterate over the provided usernames
        foreach ($search_arguments['username_array'] as $username) {

            // Check the username is valid.
            if (!($user = user_get_by_logon(trim($username)))) {

                $error = SEARCH_USER_NOT_FOUND;
                return false;
            }

            // Add the user UID to the uid_array
            $search_arguments['user_uid_array'][] = $user['UID'];
        }
    }

    // Each user can only store one search result so we should
    // clean up their previous search if applicable.
    $sql = "DELETE QUICK FROM SEARCH_RESULTS WHERE UID = '$uid'";

    if (!db_query($sql, $db_search_execute)) return false;

    // Execute search via Swiftsearch
    if (forum_get_setting('sphinx_search_enabled', 'Y')) {
        return sphinx_search_execute($search_arguments, $error);
    }

    // Execute the search with MySQL Fulltext
    return search_mysql_execute($search_arguments, $error);
}

function search_mysql_execute($search_arguments, &$error)
{
    if (($uid = session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Database connection.
    if (!$db_search_execute_mysql = db_connect()) return false;

    // If the user has specified a folder within their viewable scope limit them
    // to that folder, otherwise limit them to their available folders.
    $where_sql = "WHERE THREAD.FID IN ({$search_arguments['fid']}) ";

    // Can't search for deleted threads nor threads with no posts
    $where_sql.= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 ";

    // Where query needs to limit the search results to the user specified date range.
    $where_sql.= search_date_range($search_arguments['date_from'], $search_arguments['date_to'], SEARCH_DATE_RANGE_SQL);

    // Username based search.
    if (isset($search_arguments['user_uid_array']) && sizeof($search_arguments['user_uid_array']) > 0) {

        // Base query slightly different if you're not searching by keywords
        if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
            $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED, LENGTH, RELEVANCE) SELECT SQL_NO_CACHE ";
            $select_sql.= "SQL_BUFFER_RESULT $uid, $forum_fid, THREAD.FID, POST.TID, MIN(POST.PID), ";
            $select_sql.= "THREAD.BY_UID, POST.FROM_UID, POST.TO_UID, MIN(POST.CREATED) AS DATE_CREATED, ";
            $select_sql.= "THREAD.LENGTH, 1.0 AS RELEVANCE ";

        }else {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
            $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED, LENGTH, RELEVANCE) SELECT SQL_NO_CACHE ";
            $select_sql.= "SQL_BUFFER_RESULT $uid, $forum_fid, THREAD.FID, POST.TID, POST.PID, ";
            $select_sql.= "THREAD.BY_UID, POST.FROM_UID, POST.TO_UID, POST.CREATED AS DATE_CREATED, ";
            $select_sql.= "THREAD.LENGTH, 1.0 AS RELEVANCE ";
        }

        // Save the sort by and sort dir.
        search_save_arguments($search_arguments);

        // FROM query uses POST table if we're not using keyword searches.
        $from_sql = "FROM `{$table_data['PREFIX']}POST` POST ";

        // Join to the THREAD table for the TID
        $join_sql = "INNER JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = POST.TID) ";

        // Don't need a HAVING clause if we're not using MATCH(..) AGAINST(..)
        $having_sql = "";

        // Combine the user UIDs into a comma-seperated list.
        $user_uids = implode(',', array_filter($search_arguments['user_uid_array'], 'is_numeric'));

        // Check if we're searching for threads or posts started by these users.
        if (isset($search_arguments['user_include']) && is_numeric($search_arguments['user_include'])) {

            if ($search_arguments['user_include'] == SEARCH_FILTER_USER_THREADS) {

                $where_sql.= "AND THREAD.BY_UID IN ($user_uids) AND POST.PID = 1 ";

            } else if ($search_arguments['user_include'] == SEARCH_FILTER_USER_POSTS) {

                $where_sql.= "AND POST.FROM_UID IN ($user_uids) ";
            }
        }
    }

    /// Keyword based search.
    if (isset($search_arguments['search_string']) && strlen(trim(stripslashes_array($search_arguments['search_string']))) > 0) {

        $search_string = db_escape_string(stripslashes_array($search_arguments['search_string']));

        $from_sql = "FROM `{$table_data['PREFIX']}POST_CONTENT` POST_CONTENT ";

        $join_sql = "INNER JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = POST_CONTENT.TID) ";
        $join_sql.= "INNER JOIN `{$table_data['PREFIX']}POST` POST ON (POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID) ";

        $having_sql = "HAVING RELEVANCE > 0.2";

        search_save_arguments($search_arguments);

        if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
            $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED, LENGTH, RELEVANCE) ";
            $select_sql.= "SELECT SQL_NO_CACHE SQL_BUFFER_RESULT $uid, $forum_fid, ";
            $select_sql.= "THREAD.FID, POST_CONTENT.TID, MIN(POST_CONTENT.PID), THREAD.BY_UID, ";
            $select_sql.= "POST.FROM_UID, POST.TO_UID, MIN(POST.CREATED) AS DATE_CREATED, THREAD.LENGTH, ";
            $select_sql.= "MATCH(POST_CONTENT.CONTENT, THREAD.TITLE) AGAINST('$search_string' IN BOOLEAN MODE) ";
            $select_sql.= "AS RELEVANCE";

        }else {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, FID, TID, PID, ";
            $select_sql.= "BY_UID, FROM_UID, TO_UID, CREATED, LENGTH, RELEVANCE) ";
            $select_sql.= "SELECT SQL_NO_CACHE SQL_BUFFER_RESULT $uid, $forum_fid, ";
            $select_sql.= "THREAD.FID, POST_CONTENT.TID, POST_CONTENT.PID, THREAD.BY_UID, ";
            $select_sql.= "POST.FROM_UID, POST.TO_UID, POST.CREATED AS DATE_CREATED, THREAD.LENGTH, ";
            $select_sql.= "MATCH(POST_CONTENT.CONTENT, THREAD.TITLE) AGAINST('$search_string' IN BOOLEAN MODE) ";
            $select_sql.= "AS RELEVANCE";
        }

        $where_sql.= "AND MATCH(POST_CONTENT.CONTENT) AGAINST('$search_string' IN BOOLEAN MODE) ";

    }else {

        if (!isset($search_arguments['user_uid_array']) || sizeof($search_arguments['user_uid_array']) < 1) {

            $error = SEARCH_NO_MATCHES;
            return false;
        }
    }

    // If the user wants results grouped by thread (TID) then do so.
    if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {
        $group_sql = "GROUP BY THREAD.TID ";
    }else {
        $group_sql = "";
    }

    // Get the correct sort dir
    $sort_dir = ($search_arguments['sort_dir'] == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    // Construct the order by clause.
    switch($search_arguments['sort_by']) {

        case SEARCH_SORT_RELEVANCE:

            $order_sql = "ORDER BY RELEVANCE $sort_dir";
            break;

        case SEARCH_SORT_NUM_REPLIES:

            $order_sql = "ORDER BY THREAD.LENGTH $sort_dir";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $order_sql = "ORDER BY THREAD.FID $sort_dir";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $order_sql = "ORDER BY POST.FROM_UID $sort_dir";
            break;

        default:

            $order_sql = "ORDER BY POST.CREATED $sort_dir";
            break;
    }

    // Set a limit of 1000 results.
    $limit_sql = "LIMIT 0, 1000";

    // Build the final query.
    $sql = "$select_sql $from_sql $join_sql $where_sql ";
    $sql.= "$group_sql $having_sql $order_sql $limit_sql";

    // If the user has performed a search within the last x minutes bail out
    if (!check_search_frequency()) {

        $error = SEARCH_FREQUENCY_TOO_GREAT;
        return false;
    }

    // Execute the query
    if (!db_query($sql, $db_search_execute_mysql)) return false;

    // Check the number of results
    if (db_affected_rows($db_search_execute_mysql) > 0) return true;

    // No results from search.
    $error = SEARCH_NO_MATCHES;

    return false;
}

function search_extract_keywords($search_string, $strip_valid = false)
{
    // Split the search string into boolean parts
    $keywords_array = preg_split('/([\+|-]?["][^"]+["])|([\+|-]?[\pL\pN\pP]+)/u', $search_string, -1, PREG_SPLIT_DELIM_CAPTURE);

    // Removed empty parts.
    $keywords_array = array_filter(array_map('trim', $keywords_array), 'strlen');

    // Get the min and max word lengths that MySQL supports
    $min_length = 4;
    $max_length = 84;

    search_get_word_lengths($min_length, $max_length);

    // Reindex the keywords array.
    $keywords_array = array_values($keywords_array);

    // Take a count of the words before we remove the stop words.
    $unfiltered_count = sizeof($keywords_array);
    
    // Filter the boolean parts through the MySQL Full-Text stop word list
    // and by checking individual words lengths.
    if ($strip_valid === true) {

        $keywords_array_length = preg_grep(sprintf('/^[\+|-]?["]?[\pL\pN\pP\pZ]{%d,%d}["]?$/Diu', $min_length, $max_length), $keywords_array, PREG_GREP_INVERT);
        $keywords_array = array_merge($keywords_array_length, $keywords_array_swords);

    }else {
        
        $keywords_array = preg_grep(sprintf('/^[\+|-]?["]?[\pL\pN\pP\pZ]{%d,%d}["]?$/Diu', $min_length, $max_length), $keywords_array);
    }
    
    // Remove any duplicate words, reindex the array.
    $keywords_array = array_values(array_unique($keywords_array));

    // Count the array a second time to get the number of valid search parts.
    $filtered_count = sizeof($keywords_array);

    // Return the data as an array.
    return array('keywords_array'   => $keywords_array,
                 'unfiltered_count' => $unfiltered_count,
                 'filtered_count'   => $filtered_count);
}

function search_strip_special_chars($keywords_array, $remove_non_matches = true)
{
    if (!is_array($keywords_array)) return false;
    if (!is_bool($remove_non_matches)) $remove_non_matches = true;

    // Get the min and max word lengths that MySQL supports
    $min_length = 4;
    $max_length = 84;

    search_get_word_lengths($min_length, $max_length);

    // Expression to match words prefixed with a hyphen (for do not match)
    if ($remove_non_matches === true) {

        $boolean_non_match = sprintf('/^-["]?([\pL\pN\pP\pZ]){%d,%d}["]?$/Du', $min_length, $max_length);

        $keywords_array = preg_grep($boolean_non_match, $keywords_array, PREG_GREP_INVERT);
        $keywords_array = preg_replace('/["|\+|\x00]+/u', '', $keywords_array);

    }else {

        $keywords_array = preg_replace('/["|\+|\-|\x00]+/u', '', $keywords_array);
    }

    // return array
    return $keywords_array;
}

function search_get_word_lengths(&$min_length, &$max_length)
{
    if (!$db_search_get_word_lengths = db_connect()) return false;

    $sql = "SHOW VARIABLES LIKE 'ft_%'";

    if (!$result = db_query($sql, $db_search_get_word_lengths)) return false;

    $min_length = 4;
    $max_length = 84;

    while (($mysql_variable_data = db_fetch_array($result))) {

        if (isset($mysql_variable_data['Variable_name']) && isset($mysql_variable_data['Value'])) {

            if ($mysql_variable_data['Variable_name'] == 'ft_max_word_len') {
                $max_length = $mysql_variable_data['Value'];
            }

            if ($mysql_variable_data['Variable_name'] == 'ft_min_word_len') {
                $min_length = $mysql_variable_data['Value'];
            }
        }
    }

    return false;
}

function search_save_arguments($search_arguments)
{
    if (!$db_search_save_arguments = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (isset($search_arguments['search_string'])) {
        $keywords = db_escape_string($search_arguments['search_string']);
    } else {
        $keywords = '';
    }

    if (isset($search_arguments['sort_by'])) {
        $sort_by = db_escape_string($search_arguments['sort_by']);
    } else {
        $sort_by = '';
    }

    if (isset($search_arguments['sort_dir'])) {
        $sort_dir = db_escape_string($search_arguments['sort_dir']);
    }else {
        $sort_dir = '';
    }

    $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}USER_TRACK` ";
    $sql.= "SET LAST_SEARCH_KEYWORDS = '$keywords', LAST_SEARCH_SORT_BY = '$sort_by', ";
    $sql.= "LAST_SEARCH_SORT_DIR = '$sort_dir' WHERE UID = '$uid'";

    if (!db_query($sql, $db_search_save_arguments)) return false;

    return true;
}

function search_get_keywords($remove_non_matches = true)
{
    if (!$db_search_get_keywords = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $sql = "SELECT LAST_SEARCH_KEYWORDS FROM `{$table_data['PREFIX']}USER_TRACK` ";
    $sql.= "WHERE UID = '$uid'";
    
    if (!$result = db_query($sql, $db_search_get_keywords)) return false;

    if (db_num_rows($result) > 0) {

        list($search_keywords) = db_fetch_array($result, DB_RESULT_NUM);

        $keywords_array = search_extract_keywords($search_keywords);

        return search_strip_special_chars($keywords_array['keywords_array'], $remove_non_matches);
    }

    return false;
}

function search_get_sort(&$sort_by, &$sort_dir)
{
    if (!$db_search_get_sort = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $sql = "SELECT LAST_SEARCH_SORT_BY, LAST_SEARCH_SORT_DIR ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_TRACK` ";
    $sql.= "WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_search_get_sort)) return false;

    if (db_num_rows($result) > 0) {

        list($sort_by, $sort_dir) = db_fetch_array($result, DB_RESULT_NUM);

        return true;
    }

    return false;
}

function search_fetch_results($offset, $sort_by, $sort_dir)
{
    if (!is_numeric($offset)) return false;

    $offset = abs($offset);

    if (!$db_search_fetch_results = db_connect()) return false;

    $lang = load_language_file();

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $search_keywords = search_get_keywords();

    if (!in_array($sort_dir, array(SEARCH_SORT_ASC, SEARCH_SORT_DESC))) {
        $sort_dir = SEARCH_SORT_ASC;
    }

    $sort_dir = ($sort_dir == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    $sql = "SELECT SQL_CALC_FOUND_ROWS SEARCH_RESULTS.FID, SEARCH_RESULTS.TID, SEARCH_RESULTS.PID, ";
    $sql.= "SEARCH_RESULTS.BY_UID, SEARCH_RESULTS.FROM_UID, SEARCH_RESULTS.TO_UID, ";
    $sql.= "USER_TRACK.LAST_SEARCH_KEYWORDS AS KEYWORDS, UNIX_TIMESTAMP(CREATED) AS CREATED, ";
    $sql.= "USER.LOGON AS FROM_LOGON, USER.NICKNAME AS FROM_NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME FROM SEARCH_RESULTS ";
    $sql.= "INNER JOIN USER ON (USER.UID = SEARCH_RESULTS.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = SEARCH_RESULTS.FROM_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ";
    $sql.= "ON (USER_TRACK.UID = SEARCH_RESULTS.UID) ";
    $sql.= "WHERE SEARCH_RESULTS.UID = '$uid' ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. ") = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED. ") = 0 ";
    $sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";

    switch($sort_by) {

        case SEARCH_SORT_RELEVANCE:

            $sql.= "ORDER BY SEARCH_RESULTS.RELEVANCE $sort_dir LIMIT $offset, 20";
            break;

        case SEARCH_SORT_NUM_REPLIES:

            $sql.= "ORDER BY SEARCH_RESULTS.LENGTH $sort_dir LIMIT $offset, 20";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $sql.= "ORDER BY SEARCH_RESULTS.FID $sort_dir LIMIT $offset, 20";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $sql.= "ORDER BY SEARCH_RESULTS.FROM_UID $sort_dir LIMIT $offset, 20";
            break;

        default:

            $sql.= "ORDER BY SEARCH_RESULTS.CREATED $sort_dir LIMIT $offset, 20";
            break;
    }

    if (!$result = db_query($sql, $db_search_fetch_results)) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_search_fetch_results)) return false;

    list($result_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        $search_results_array = array();

        while (($search_result = db_fetch_array($result))) {

            $search_result['KEYWORDS'] = $search_keywords;

            if (isset($search_result['FROM_LOGON']) && isset($search_result['PEER_NICKNAME'])) {
                if (!is_null($search_result['PEER_NICKNAME']) && strlen($search_result['PEER_NICKNAME']) > 0) {
                    $search_result['FROM_NICKNAME'] = $search_result['PEER_NICKNAME'];
                }
            }

            if (!isset($search_result['FROM_LOGON'])) $search_result['FROM_LOGON'] = $lang['unknownuser'];
            if (!isset($search_result['FROM_NICKNAME'])) $search_result['FROM_NICKNAME'] = $lang['unknownuser'];

            $search_results_array[] = $search_result;
        }

        return array('result_count' => $result_count,
                     'result_array' => $search_results_array);

    }else if ($result_count > 0) {

        $offset = floor(($result_count - 1) / 20) * 20;
        return search_fetch_results($offset, $sort_by, $sort_dir);
    }

    return false;
}

function search_get_first_result_msg()
{
    if (!$db_search_fetch_results = db_connect()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    search_get_sort($sort_by, $sort_dir);

    $sql = "SELECT TID, PID FROM SEARCH_RESULTS WHERE UID = '$uid' ";

    if (!in_array($sort_dir, array(SEARCH_SORT_ASC, SEARCH_SORT_DESC))) {
        $sort_dir = SEARCH_SORT_DESC;
    }

    $sort_dir = ($sort_dir == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    switch($sort_by) {

        case SEARCH_SORT_RELEVANCE:

            $sql.= "ORDER BY RELEVANCE $sort_dir LIMIT 1";
            break;

        case SEARCH_SORT_NUM_REPLIES:

            $sql.= "ORDER BY LENGTH $sort_dir LIMIT 1";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $sql.= "ORDER BY FID $sort_dir LIMIT 1";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $sql.= "ORDER BY FROM_UID $sort_dir LIMIT 1";
            break;

        default:

            $sql.= "ORDER BY CREATED $sort_dir LIMIT 1";
            break;
    }

    if (!$result = db_query($sql, $db_search_fetch_results)) return false;

    if (db_num_rows($result) > 0) {

        list($tid, $pid) = db_fetch_array($result, DB_RESULT_NUM);
        return "$tid.$pid";
    }

    return false;
}

function search_date_range($from, $to, $return = SEARCH_DATE_RANGE_SQL)
{
    $year  = date('Y', time());
    $month = date('n', time());
    $day   = date('j', time());

    $from_timestamp = null;
    $to_timestamp = null;

    switch ($from) {

        case SEARCH_FROM_TODAY:  // Today

            $from_timestamp = gmmktime(0, 0, 0, $month, $day, $year);
            break;

        case SEARCH_FROM_YESTERDAY:  // Yesterday

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 1, $year);
            break;

        case SEARCH_FROM_DAYBEFORE:  // Day before yesterday

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 2, $year);
            break;

        case SEARCH_FROM_ONE_WEEK_AGO:  // 1 week ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 7, $year);
            break;

        case SEARCH_FROM_TWO_WEEKS_AGO:  // 2 weeks ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 14, $year);
            break;

        case SEARCH_FROM_THREE_WEEKS_AGO:  // 3 weeks ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 21, $year);
            break;

        case SEARCH_FROM_ONE_MONTH_AGO:  // 1 month ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 1, $day, $year);
            break;

        case SEARCH_FROM_TWO_MONTHS_AGO:  // 2 months ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 2, $day, $year);
            break;

        case SEARCH_FROM_THREE_MONTHS_AGO:  // 3 months ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 3, $day, $year);
            break;

        case SEARCH_FROM_SIX_MONTHS_AGO: // 6 months ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 6, $day, $year);
            break;

        case SEARCH_FROM_ONE_YEAR_AGO: // 1 year ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day, $year - 1);
            break;
    }

    switch($to) {

        case SEARCH_TO_NOW:  // Now

            $to_timestamp = time();
            break;

        case SEARCH_TO_TODAY:  // Today

            $to_timestamp = gmmktime(23, 59, 59, $month, $day, $year);
            break;

        case SEARCH_TO_YESTERDAY:  // Yesterday

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 1, $year);
            break;

        case SEARCH_TO_DAYBEFORE:  // Day before yesterday

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 2, $year);
            break;

        case SEARCH_TO_ONE_WEEK_AGO:  // 1 week ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 7, $year);
            break;

        case SEARCH_TO_TWO_WEEKS_AGO:  // 2 weeks ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 14, $year);
            break;

        case SEARCH_TO_THREE_WEEKS_AGO:  // 3 weeks ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 21, $year);
            break;

        case SEARCH_TO_ONE_MONTH_AGO:  // 1 month ago

            $to_timestamp = gmmktime(23, 59, 59, $month - 1, $day, $year);
            break;

        case SEARCH_TO_TWO_MONTHS_AGO:  // 2 months ago

            $to_timestamp = gmmktime(23, 59, 59, $month - 2, $day, $year);
            break;

        case SEARCH_TO_THREE_MONTHS_AGO: // 3 months ago

            $to_timestamp = gmmktime(23, 59, 59, $month - 3, $day, $year);
            break;

        case SEARCH_TO_SIX_MONTHS_AGO: // 6 months ago

            $to_timestamp = gmmktime(23, 59, 59, $month - 6, $day, $year);
            break;

        case SEARCH_TO_ONE_YEAR_AGO: // 1 year ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day, $year - 1);
            break;
    }

    switch ($return) {

        case SEARCH_DATE_RANGE_ARRAY:

            return array($from_timestamp, $to_timestamp);
            break;

        default:

            $range = '';

            if (isset($from_timestamp)) {

                $from_datetime = date(MYSQL_DATETIME, $from_timestamp);
                $range = "AND POST.CREATED >= CAST('$from_datetime' AS DATETIME) ";
            }

            if (isset($to_timestamp)) {

                $to_datetime = date(MYSQL_DATETIME, $to_timestamp);
                $range.= "AND POST.CREATED <= CAST('$to_datetime' AS DATETIME) ";
            }

            return $range;
            break;
    }
}

function folder_search_dropdown($selected_folder)
{
    $lang = load_language_file();

    if (!$db_folder_search_dropdown = db_connect()) return false;

    if (!is_numeric($selected_folder)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $available_folders = array();

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT FID, TITLE FROM `{$table_data['PREFIX']}FOLDER` ";
    $sql.= "ORDER BY FID ";

    if (!$result = db_query($sql, $db_folder_search_dropdown)) return false;

    if (db_num_rows($result) > 0) {

        while (($folder_data = db_fetch_array($result))) {

            if (user_is_guest()) {

                if (session_check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                    $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
                }

            }else {

                if (session_check_perm($access_allowed, $folder_data['FID'])) {

                    $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
                }
            }
        }

        if (sizeof($available_folders) > 0) {

            $available_folders = array($lang['all_caps']) + $available_folders;
            return form_dropdown_array("fid", $available_folders, $selected_folder, false, "search_dropdown");
        }
    }

    return false;
}

function check_search_frequency()
{
    if (!$db_check_search_frequency = db_connect()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $search_min_frequency = intval(forum_get_setting('search_min_frequency', false, 30));

    if ($search_min_frequency == 0) return true;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "SELECT UNIX_TIMESTAMP(LAST_SEARCH) + $search_min_frequency, ";
    $sql.= "UNIX_TIMESTAMP('$current_datetime') FROM `{$table_data['PREFIX']}USER_TRACK` ";
    $sql.= "WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_check_search_frequency)) return false;

    if (db_num_rows($result) > 0) {

        list($last_search_stamp, $current_timestamp) = db_fetch_array($result);

        if (!is_numeric($last_search_stamp) || $last_search_stamp < $current_timestamp) {

            $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}USER_TRACK` ";
            $sql.= "SET LAST_SEARCH = CAST('$current_datetime' AS DATETIME) ";
            $sql.= "WHERE UID = '$uid'";

            if (!$result = db_query($sql, $db_check_search_frequency)) return false;

            return true;
        }

    }else{

        $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK` (UID, LAST_SEARCH) ";
        $sql.= "VALUES ('$uid', CAST('$current_datetime' AS DATETIME))";

        if (!$result = db_query($sql, $db_check_search_frequency)) return false;

        return true;
    }

    return false;
}

function search_output_opensearch_xml()
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $title = forum_get_setting('forum_name', false, 'A Beehive Forum');

    $forum_opensearch_uri = html_get_forum_uri("search.php?webtag=$webtag&amp;search_string={searchTerms}");

    header('Content-type: text/xml; charset=UTF-8', true);

    echo "<?xml version=\"1.0\"?>\n";
    echo "<OpenSearchDescription xmlns=\"http://a9.com/-/spec/opensearch/1.1/\">\n";
    echo "<ShortName>$title</ShortName>\n";
    echo "<Description>$title</Description>\n";
    echo "<InputEncoding>UTF-8</InputEncoding>\n";

    if (($user_style_path = html_get_user_style_path())) {
        printf("<Image height=\"16\" width=\"16\" type=\"image/x-icon\">%s</Image>\n", html_get_forum_uri(sprintf('styles/%s/images/favicon.ico', $user_style_path)));
    }    
    
    echo "<Url type=\"text/html\" method=\"get\" template=\"$forum_opensearch_uri\"/>\n";
    echo "</OpenSearchDescription>\n";
    exit;
}

?>