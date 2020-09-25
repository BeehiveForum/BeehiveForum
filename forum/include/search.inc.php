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
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'sphinx.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function search_execute($search_arguments, &$error)
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // If the user has performed a search within the last x minutes bail out
    if (!check_search_frequency()) {

        $error = SEARCH_FREQUENCY_TOO_GREAT;
        return false;
    }

    // Database connection.
    if (!$db = db::get()) return false;

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

        // Username argument is a comma separated list.
        $search_arguments['username_array'] = preg_split('/,\s*/u', trim($search_arguments['username'], ', '));

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
    $sql = "DELETE QUICK FROM SEARCH_RESULTS WHERE UID = '{$_SESSION['UID']}'";

    if (!$db->query($sql)) return false;

    // Execute search via Swiftsearch, unless we're searching for a tag.
    if (!isset($search_arguments['search_tag']) && forum_get_setting('sphinx_search_enabled', 'Y')) {
        return sphinx_search_execute($search_arguments, $error);
    }

    // Execute the search with MySQL Fulltext
    return search_mysql_execute($search_arguments, $error);
}

function search_mysql_execute($search_arguments, &$error)
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    // Database connection.
    if (!$db = db::get()) return false;

    // If the user has specified a folder within their viewable scope limit them
    // to that folder, otherwise limit them to their available folders.
    $where_sql = "WHERE THREAD.FID IN ({$search_arguments['fid']}) ";

    // Can't search for deleted threads nor threads with no posts
    $where_sql .= "AND THREAD.DELETED = 'N' AND THREAD.LENGTH > 0 AND (THREAD.APPROVED IS NOT NULL OR THREAD.BY_UID = '{$_SESSION['UID']}') ";

    // Where query needs to limit the search results to the user specified date range.
    $where_sql .= search_date_range($search_arguments['date_from'], $search_arguments['date_to'], SEARCH_DATE_RANGE_SQL);

    // No select, joins, from or having clauses by default.
    $select_sql = null;
    $join_sql = null;
    $from_sql = null;
    $having_sql = null;

    // Username based search.
    if (isset($search_arguments['user_uid_array']) && sizeof($search_arguments['user_uid_array']) > 0) {

        // Base query slightly different if you're not searching by keywords
        if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) SELECT DISTINCT SQL_NO_CACHE ";
            $select_sql .= "SQL_BUFFER_RESULT {$_SESSION['UID']}, $forum_fid, POST.TID, MIN(POST.PID), ";
            $select_sql .= "1.0 AS RELEVANCE ";

        } else {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) SELECT DISTINCT SQL_NO_CACHE ";
            $select_sql .= "SQL_BUFFER_RESULT {$_SESSION['UID']}, $forum_fid, POST.TID, POST.PID, ";
            $select_sql .= "1.0 AS RELEVANCE ";
        }

        // Save the sort by and sort dir.
        search_save_arguments($search_arguments);

        // FROM query uses POST table if we're not using keyword searches.
        $from_sql = "FROM `{$table_prefix}POST` POST ";

        // Join to the THREAD table for the TID
        $join_sql = "INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST.TID) ";

        // Combine the user UIDs into a comma-separated list.
        $user_uids = implode(',', array_filter($search_arguments['user_uid_array'], 'is_numeric'));

        // Check if we're searching for threads or posts started by these users.
        if (isset($search_arguments['user_include']) && is_numeric($search_arguments['user_include'])) {

            if ($search_arguments['user_include'] == SEARCH_FILTER_USER_THREADS) {

                $where_sql .= "AND THREAD.BY_UID IN ($user_uids) AND POST.PID = 1 ";

            } else if ($search_arguments['user_include'] == SEARCH_FILTER_USER_POSTS) {

                $where_sql .= "AND POST.FROM_UID IN ($user_uids) ";
            }
        }
    }

    /// Keyword based search.
    if (isset($search_arguments['search_string']) && strlen(trim($search_arguments['search_string'])) > 0) {

        $search_string = $db->escape($search_arguments['search_string']);

        $from_sql = "FROM `{$table_prefix}POST_CONTENT` POST_CONTENT ";

        $join_sql = "INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST_CONTENT.TID) ";
        $join_sql .= "INNER JOIN `{$table_prefix}POST` POST ON (POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID) ";

        $having_sql = "HAVING RELEVANCE > 0.2 ";

        search_save_arguments($search_arguments);

        if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) ";
            $select_sql .= "SELECT DISTINCT SQL_NO_CACHE SQL_BUFFER_RESULT {$_SESSION['UID']}, $forum_fid, ";
            $select_sql .= "POST.TID, MIN(POST.PID), MATCH(POST_CONTENT.CONTENT, THREAD.TITLE) ";
            $select_sql .= "AGAINST('$search_string' IN BOOLEAN MODE) AS RELEVANCE ";

        } else {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) ";
            $select_sql .= "SELECT DISTINCT SQL_NO_CACHE SQL_BUFFER_RESULT {$_SESSION['UID']}, $forum_fid, ";
            $select_sql .= "POST.TID, POST.PID, MATCH(POST_CONTENT.CONTENT, THREAD.TITLE) ";
            $select_sql .= "AGAINST('$search_string' IN BOOLEAN MODE) AS RELEVANCE ";
        }

        $where_sql .= "AND MATCH(POST_CONTENT.CONTENT) AGAINST('$search_string' IN BOOLEAN MODE) ";

    } else if (isset($search_arguments['search_tag']) && strlen(trim($search_arguments['search_tag'])) > 0) {

        $search_tag = $db->escape($search_arguments['search_tag']);

        $from_sql = "FROM `{$table_prefix}POST` POST ";

        $join_sql = "INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
        $join_sql .= "INNER JOIN `{$table_prefix}POST_TAG` POST_TAG ON (POST_TAG.TID = POST.TID AND POST_TAG.PID = POST.PID) ";
        $join_sql .= "INNER JOIN `{$table_prefix}TAG` TAG ON (TAG.TID = POST_TAG.TAG) ";

        search_save_arguments($search_arguments);

        if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) ";
            $select_sql .= "SELECT DISTINCT SQL_NO_CACHE SQL_BUFFER_RESULT {$_SESSION['UID']}, $forum_fid, ";
            $select_sql .= "POST.TID, MIN(POST.PID), 1.0 AS RELEVANCE ";

        } else {

            $select_sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) ";
            $select_sql .= "SELECT DISTINCT SQL_NO_CACHE SQL_BUFFER_RESULT {$_SESSION['UID']}, $forum_fid, ";
            $select_sql .= "POST.TID, POST.PID, 1.0 AS RELEVANCE ";
        }

        $where_sql .= "AND TAG.TAG = '$search_tag' ";

    } else {

        if (!isset($search_arguments['user_uid_array']) || sizeof($search_arguments['user_uid_array']) < 1) {

            $error = SEARCH_NO_MATCHES;
            return false;
        }
    }

    // If the user wants results grouped by thread (TID) then do so.
    if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {
        $group_sql = "GROUP BY THREAD.TID ";
    } else {
        $group_sql = "";
    }

    // Get the correct sort dir
    $sort_dir = ($search_arguments['sort_dir'] == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    // Construct the order by clause.
    switch ($search_arguments['sort_by']) {

        case SEARCH_SORT_RELEVANCE:

            $order_sql = "ORDER BY RELEVANCE $sort_dir ";
            break;

        case SEARCH_SORT_NUM_REPLIES:

            $order_sql = "ORDER BY THREAD.LENGTH $sort_dir ";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $order_sql = "ORDER BY THREAD.FID $sort_dir ";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $order_sql = "ORDER BY POST.FROM_UID $sort_dir ";
            break;

        default:

            $order_sql = "ORDER BY POST.CREATED $sort_dir ";
            break;
    }

    // Set a limit of 1000 results.
    $limit_sql = "LIMIT 0, 1000 ";

    // Build the final query.
    $sql = "$select_sql $from_sql $join_sql $where_sql ";
    $sql .= "$group_sql $having_sql $order_sql $limit_sql";

    // Execute the query
    if (!$db->query($sql)) return false;

    // Check the number of results
    if ($db->affected_rows > 0) return true;

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

        $keywords_array = preg_grep(sprintf('/^[\+|-]?["]?[\pL\pN\pP\pZ]{%d,%d}["]?$/Diu', $min_length, $max_length), $keywords_array, PREG_GREP_INVERT);

    } else {

        $keywords_array = preg_grep(sprintf('/^[\+|-]?["]?[\pL\pN\pP\pZ]{%d,%d}["]?$/Diu', $min_length, $max_length), $keywords_array);
    }

    // Remove any duplicate words, reindex the array.
    $keywords_array = array_values(array_unique($keywords_array));

    // Count the array a second time to get the number of valid search parts.
    $filtered_count = sizeof($keywords_array);

    // Return the data as an array.
    return array('keywords_array' => $keywords_array,
        'unfiltered_count' => $unfiltered_count,
        'filtered_count' => $filtered_count);
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

    } else {

        $keywords_array = preg_replace('/["|\+|\-|\x00]+/u', '', $keywords_array);
    }

    // return array
    return $keywords_array;
}

function search_highlight_callback($match)
{
    return sprintf(
        '<span class="highlight">%s</span>',
        $match[0]
    );
}

function search_get_word_lengths(&$min_length, &$max_length)
{
    if (!$db = db::get()) return false;

    $sql = "SHOW VARIABLES LIKE 'ft_%'";

    if (!($result = $db->query($sql))) return false;

    $min_length = 4;
    $max_length = 84;

    while (($mysql_variable_data = $result->fetch_assoc()) !== null) {

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
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (isset($search_arguments['search_string'])) {
        $keywords = $db->escape($search_arguments['search_string']);
    } else {
        $keywords = '';
    }

    if (isset($search_arguments['sort_by'])) {
        $sort_by = $db->escape($search_arguments['sort_by']);
    } else {
        $sort_by = '';
    }

    if (isset($search_arguments['sort_dir'])) {
        $sort_dir = $db->escape($search_arguments['sort_dir']);
    } else {
        $sort_dir = '';
    }

    $sql = "REPLACE INTO `{$table_prefix}USER_TRACK` (UID, USER_KEY, USER_VALUE) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', 'LAST_SEARCH_KEYWORDS', '$keywords'), ";
    $sql .= "('{$_SESSION['UID']}', 'LAST_SEARCH_SORT_BY', '$sort_by'), ";
    $sql .= "('{$_SESSION['UID']}', 'LAST_SEARCH_SORT_DIR', '$sort_dir')";

    if (!$db->query($sql)) return false;

    return true;
}

function search_get_keywords($remove_non_matches = true)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT USER_VALUE FROM `{$table_prefix}USER_TRACK` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY = 'LAST_SEARCH_KEYWORDS'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($search_keywords) = $result->fetch_row();

    $keywords_array = search_extract_keywords($search_keywords);

    return search_strip_special_chars($keywords_array['keywords_array'], $remove_non_matches);
}

function search_get_sort(&$sort_by, &$sort_dir)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT USER_KEY, USER_VALUE FROM `{$table_prefix}USER_TRACK` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY IN ('LAST_SEARCH_SORT_BY', ";
    $sql .= "'LAST_SEARCH_SORT_DIR')";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_track_data = $result->fetch_assoc())) {

        switch ($user_track_data['USER_KEY']) {

            case 'LAST_SEARCH_SORT_BY':

                $sort_by = $user_track_data['USER_VALUE'];
                break;

            case 'LAST_SEARCH_SORT_DIR':

                $sort_dir = $user_track_data['USER_VALUE'];
                break;
        }
    }

    return true;
}

function search_fetch_results($page, $sort_by = null, $sort_dir = null)
{
    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 20);

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $search_keywords = search_get_keywords();

    if (!in_array($sort_dir, array(SEARCH_SORT_ASC, SEARCH_SORT_DESC))) {
        $sort_dir = SEARCH_SORT_ASC;
    }

    $sort_dir = ($sort_dir == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.FID, THREAD.TID, POST.PID, THREAD.BY_UID, POST.FROM_UID, ";
    $sql .= "USER_TRACK.USER_VALUE AS KEYWORDS, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, ";
    $sql .= "USER.LOGON AS FROM_LOGON, COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS FROM_NICKNAME  ";
    $sql .= "FROM SEARCH_RESULTS INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = SEARCH_RESULTS.TID) ";
    $sql .= "INNER JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "INNER JOIN `{$table_prefix}POST` POST ON (POST.TID = SEARCH_RESULTS.TID AND POST.PID = SEARCH_RESULTS.PID) ";
    $sql .= "INNER JOIN USER ON (USER.UID = POST.FROM_UID) LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = POST.FROM_UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = SEARCH_RESULTS.UID ";
    $sql .= "AND USER_TRACK.USER_KEY = 'LAST_SEARCH_KEYWORDS') ";
    $sql .= "WHERE SEARCH_RESULTS.UID = '{$_SESSION['UID']}' ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & " . USER_IGNORED_COMPLETELY . ") = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & " . USER_IGNORED . ") = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";

    switch ($sort_by) {

        case SEARCH_SORT_RELEVANCE:

            $sql .= "ORDER BY SEARCH_RESULTS.RELEVANCE $sort_dir LIMIT $offset, 20";
            break;

        case SEARCH_SORT_NUM_REPLIES:

            $sql .= "ORDER BY THREAD.LENGTH $sort_dir LIMIT $offset, 20";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $sql .= "ORDER BY FOLDER.TITLE $sort_dir LIMIT $offset, 20";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $sql .= "ORDER BY FROM_NICKNAME $sort_dir LIMIT $offset, 20";
            break;

        default:

            $sql .= "ORDER BY POST.CREATED $sort_dir LIMIT $offset, 20";
            break;
    }

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($result_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($result_count > 0) && ($page > 1)) {
        return search_fetch_results($page - 1, $sort_by, $sort_dir);
    }

    $search_results_array = array();

    while (($search_result = $result->fetch_assoc()) !== null) {

        $search_result['KEYWORDS'] = $search_keywords;

        if (isset($search_result['FROM_LOGON']) && isset($search_result['PEER_NICKNAME'])) {
            if (!is_null($search_result['PEER_NICKNAME']) && strlen($search_result['PEER_NICKNAME']) > 0) {
                $search_result['FROM_NICKNAME'] = $search_result['PEER_NICKNAME'];
            }
        }

        if (!isset($search_result['FROM_LOGON'])) $search_result['FROM_LOGON'] = gettext("Unknown user");
        if (!isset($search_result['FROM_NICKNAME'])) $search_result['FROM_NICKNAME'] = gettext("Unknown user");

        $search_results_array[] = $search_result;
    }

    return array(
        'result_count' => $result_count,
        'result_array' => $search_results_array
    );
}

function search_get_first_result_msg()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    search_get_sort($sort_by, $sort_dir);

    $sql = "SELECT THREAD.TID, POST.PID FROM SEARCH_RESULTS ";
    $sql .= "INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = SEARCH_RESULTS.TID) ";
    $sql .= "INNER JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "INNER JOIN `{$table_prefix}POST` POST ON (POST.TID = SEARCH_RESULTS.TID AND POST.PID = SEARCH_RESULTS.PID) ";
    $sql .= "INNER JOIN USER ON (USER.UID = POST.FROM_UID) LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = POST.FROM_UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE SEARCH_RESULTS.UID = '{$_SESSION['UID']}' ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & " . USER_IGNORED_COMPLETELY . ") = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & " . USER_IGNORED . ") = 0 ";
    $sql .= "OR USER_PEER.RELATIONSHIP IS NULL) ";

    if (!in_array($sort_dir, array(SEARCH_SORT_ASC, SEARCH_SORT_DESC))) {
        $sort_dir = SEARCH_SORT_DESC;
    }

    $sort_dir = ($sort_dir == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    switch ($sort_by) {

        case SEARCH_SORT_RELEVANCE:

            $sql .= "ORDER BY SEARCH_RESULTS.RELEVANCE $sort_dir LIMIT 1";
            break;

        case SEARCH_SORT_NUM_REPLIES:

            $sql .= "ORDER BY THREAD.LENGTH $sort_dir LIMIT 1";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $sql .= "ORDER BY FOLDER.TITLE $sort_dir LIMIT 1";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $sql .= "ORDER BY FROM_NICKNAME $sort_dir LIMIT 1";
            break;

        default:

            $sql .= "ORDER BY POST.CREATED $sort_dir LIMIT 1";
            break;
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($tid, $pid) = $result->fetch_row();

    return "$tid.$pid";
}

function search_date_range($from, $to, $return = SEARCH_DATE_RANGE_SQL)
{
    $year = date('Y', time());
    $month = date('n', time());
    $day = date('j', time());

    $from_timestamp = null;
    $to_timestamp = null;

    switch ($from) {

        case SEARCH_FROM_TODAY: // Today

            $from_timestamp = gmmktime(0, 0, 0, $month, $day, $year);
            break;

        case SEARCH_FROM_YESTERDAY: // Yesterday

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 1, $year);
            break;

        case SEARCH_FROM_DAYBEFORE: // Day before yesterday

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 2, $year);
            break;

        case SEARCH_FROM_ONE_WEEK_AGO: // 1 week ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 7, $year);
            break;

        case SEARCH_FROM_TWO_WEEKS_AGO: // 2 weeks ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 14, $year);
            break;

        case SEARCH_FROM_THREE_WEEKS_AGO: // 3 weeks ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day - 21, $year);
            break;

        case SEARCH_FROM_ONE_MONTH_AGO: // 1 month ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 1, $day, $year);
            break;

        case SEARCH_FROM_TWO_MONTHS_AGO: // 2 months ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 2, $day, $year);
            break;

        case SEARCH_FROM_THREE_MONTHS_AGO: // 3 months ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 3, $day, $year);
            break;

        case SEARCH_FROM_SIX_MONTHS_AGO: // 6 months ago

            $from_timestamp = gmmktime(0, 0, 0, $month - 6, $day, $year);
            break;

        case SEARCH_FROM_ONE_YEAR_AGO: // 1 year ago

            $from_timestamp = gmmktime(0, 0, 0, $month, $day, $year - 1);
            break;
    }

    switch ($to) {

        case SEARCH_TO_NOW: // Now

            $to_timestamp = time();
            break;

        case SEARCH_TO_TODAY: // Today

            $to_timestamp = gmmktime(23, 59, 59, $month, $day, $year);
            break;

        case SEARCH_TO_YESTERDAY: // Yesterday

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 1, $year);
            break;

        case SEARCH_TO_DAYBEFORE: // Day before yesterday

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 2, $year);
            break;

        case SEARCH_TO_ONE_WEEK_AGO: // 1 week ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 7, $year);
            break;

        case SEARCH_TO_TWO_WEEKS_AGO: // 2 weeks ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 14, $year);
            break;

        case SEARCH_TO_THREE_WEEKS_AGO: // 3 weeks ago

            $to_timestamp = gmmktime(23, 59, 59, $month, $day - 21, $year);
            break;

        case SEARCH_TO_ONE_MONTH_AGO: // 1 month ago

            $to_timestamp = gmmktime(23, 59, 59, $month - 1, $day, $year);
            break;

        case SEARCH_TO_TWO_MONTHS_AGO: // 2 months ago

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
                $range .= "AND POST.CREATED <= CAST('$to_datetime' AS DATETIME) ";
            }

            return $range;
            break;
    }
}

function folder_search_dropdown($selected_folder)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($selected_folder)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $available_folders = array();

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT FID, TITLE FROM `{$table_prefix}FOLDER` ";
    $sql .= "ORDER BY FID ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($folder_data = $result->fetch_assoc()) !== null) {

        if (!session::logged_in()) {

            if (session::check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
            }

        } else {

            if (session::check_perm($access_allowed, $folder_data['FID'])) {

                $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
            }
        }
    }

    if (sizeof($available_folders) == 0) return false;

    $available_folders = array(
            gettext("ALL")
        ) + $available_folders;

    return form_dropdown_array("fid", $available_folders, $selected_folder, null, "search_dropdown");
}

function check_search_frequency()
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $search_limit_count = forum_get_setting('search_limit_count', null, 1);

    $search_limit_time = forum_get_setting('search_limit_time', null, 30);

    if ($search_limit_time == 0 || $search_limit_count == 0) return true;

    $sql = "SELECT USER_VALUE FROM `{$table_prefix}USER_TRACK` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY = 'LAST_SEARCH'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        $last_search_row = $result->fetch_row();

        $last_search_timestamp_array = @unserialize($last_search_row[0]);

        if (!is_array($last_search_timestamp_array)) {
            $last_search_timestamp_array = array();
        }

        sort($last_search_timestamp_array);

    } else {

        $last_search_timestamp_array = array();
    }

    foreach ($last_search_timestamp_array as $key => $last_search_timestamp) {

        if (($last_search_timestamp + $search_limit_time) < time()) {
            unset($last_search_timestamp_array[$key]);
        }
    }

    while (sizeof($last_search_timestamp_array) > $search_limit_count) {
        array_pop($last_search_timestamp_array);
    }

    $success = sizeof($last_search_timestamp_array) < $search_limit_count;

    $last_search_timestamp_array[] = time();

    $last_search_row = $db->escape(serialize($last_search_timestamp_array));

    $sql = "REPLACE INTO `{$table_prefix}USER_TRACK` (UID, USER_KEY, USER_VALUE) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', 'LAST_SEARCH', '$last_search_row')";

    if (!$db->query($sql)) return false;

    return $success;
}

function search_output_opensearch_xml()
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $forum_title = forum_get_setting('forum_name', null, 'A Beehive Forum');

    $forum_description = html_get_forum_description();

    header('Content-type: text/xml; charset=UTF-8', true);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
    echo "<OpenSearchDescription xmlns=\"http://a9.com/-/spec/opensearch/1.1/\" xmlns:moz=\"http://www.mozilla.org/2006/browser/search/\">\n";
    echo "    <ShortName>", htmlentities_array($forum_title), "</ShortName>\n";
    echo "    <Description>", htmlentities_array($forum_description), "</Description>\n";
    echo "    <InputEncoding>UTF-8</InputEncoding>\n";

    if (($user_style_path = html_get_user_style_path()) !== false) {
        printf("    <Image height=\"16\" width=\"16\" type=\"image/x-icon\">%s</Image>\n", htmlentities_array(html_get_forum_uri(sprintf('styles/%s/images/favicon.ico', $user_style_path))));
    }

    echo "    <Url type=\"text/html\" method=\"get\" template=\"", htmlentities_array(html_get_forum_uri("search.php?webtag=$webtag&search_string={searchTerms}")), "\"></Url>\n";
    echo "</OpenSearchDescription>\n";
    exit;
}