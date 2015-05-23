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
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'search.inc.php';
// End Required includes

function sphinx_search_connect()
{
    if (!($sphinx_search_host = forum_get_setting('sphinx_search_host'))) return false;

    if (!($sphinx_search_port = forum_get_setting('sphinx_search_port', 'is_numeric', false))) return false;

    try {

        return mysqli_connect($sphinx_search_host, null, null, null, $sphinx_search_port);

    } catch (Exception $e) {

        return false;
    }
}

function sphinx_search_execute($search_arguments, &$error)
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    /** @var mysqli $sphinx */
    if (!($sphinx = sphinx_search_connect())) {

        $error = SEARCH_SPHINX_UNAVAILABLE;
        return false;
    }

    // Sphinx Search index name is the forum's webtag.
    if (!($sphinx_search_index = get_webtag())) {

        $error = SEARCH_SPHINX_UNAVAILABLE;
        return false;
    }

    // Validate the webtag
    if (!forum_check_webtag_available($sphinx_search_index)) {

        $error = SEARCH_SPHINX_UNAVAILABLE;
        return false;
    }

    // Regular Database connection.
    if (!$db = db::get()) return false;

    // If the user has specified a folder within their viewable scope limit them
    // to that folder, otherwise limit them to their available folders.
    $where_sql = "WHERE forum = {$forum_fid} AND fid IN ({$search_arguments['fid']}) ";

    // Where query needs to limit the search results to the user specified date range.
    $where_sql .= sphinx_search_date_range($search_arguments['date_from'], $search_arguments['date_to']);

    // Username based search.
    if (isset($search_arguments['user_uid_array']) && sizeof($search_arguments['user_uid_array']) > 0) {

        // Save the sort by and sort dir.
        search_save_arguments($search_arguments);

        // Combine the user UIDs into a comma-seperated list.
        $user_uids = implode(',', array_filter($search_arguments['user_uid_array'], 'is_numeric'));

        // Check if we're searching for threads or posts started by these users.
        if (isset($search_arguments['user_include']) && is_numeric($search_arguments['user_include'])) {

            if ($search_arguments['user_include'] == SEARCH_FILTER_USER_THREADS) {

                $where_sql .= "AND by_uid IN ($user_uids) AND pid = 1 ";

            } else if ($search_arguments['user_include'] == SEARCH_FILTER_USER_POSTS) {

                $where_sql .= "AND from_uid IN ($user_uids) ";
            }
        }
    }

    /// Keyword based search.
    if (isset($search_arguments['search_string']) && strlen(trim($search_arguments['search_string'])) > 0) {

        // Sphinx doesn't like -- in MATCH. Don't know if it's because it
        // thinks it is a MySQL-style comment or a bug. We have no choice
        // but to strip it out.
        $search_string = $sphinx->real_escape_string(str_replace('--', '', $search_arguments['search_string']));

        search_save_arguments($search_arguments);

        $where_sql .= "AND MATCH('$search_string')";

    } else {

        if (!isset($search_arguments['user_uid_array']) || sizeof($search_arguments['user_uid_array']) < 1) {

            $error = SEARCH_NO_MATCHES;
            return false;
        }
    }

    // If the user wants results grouped by thread (TID) then do so.
    if (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS) {
        $group_sql = "GROUP BY tid";
    } else {
        $group_sql = "";
    }

    // Get the correct sort dir
    $sort_dir = ($search_arguments['sort_dir'] == SEARCH_SORT_DESC) ? 'DESC' : 'ASC';

    // Construct the order by clause.
    switch ($search_arguments['sort_by']) {

        case SEARCH_SORT_NUM_REPLIES:

            $order_sql = "ORDER BY length $sort_dir";
            break;

        case SEARCH_SORT_FOLDER_NAME:

            $order_sql = "ORDER BY fid $sort_dir";
            break;

        case SEARCH_SORT_AUTHOR_NAME:

            $order_sql = "ORDER BY from_uid $sort_dir";
            break;

        default:

            $order_sql = "ORDER BY created $sort_dir";
            break;
    }

    // Prepend _DELTA to the end of the index name.
    $sphinx_search_index_delta = sprintf('%s_DELTA', $sphinx_search_index);

    // Build query including main and delta indexes.
    $sql = "SELECT *, WEIGHT() FROM $sphinx_search_index, $sphinx_search_index_delta ";
    $sql .= "$where_sql $group_sql $order_sql LIMIT 1000";

    // Execute the query
    if (!($result = $sphinx->query($sql))) return false;

    // Check if we have any results
    if ($result->num_rows == 0) {

        // No results from search.
        $error = SEARCH_NO_MATCHES;

        return false;
    }

    while (($search_result = $result->fetch_assoc()) !== null) {

        if (isset($search_result['weight()'])) {
            $weight = $search_result['weight()'];
        } else if (isset($search_result['weight'])) {
            $weight = $search_result['weight'];
        } else {
            $weight = 0;
        }

        $sql = "INSERT INTO SEARCH_RESULTS (UID, FORUM, TID, PID, RELEVANCE) ";
        $sql .= "SELECT '{$_SESSION['UID']}' AS UID, '$forum_fid' AS FORUM, THREAD.TID, POST.PID, ";
        $sql .= "{$weight} AS RELEVANCE FROM `{$table_prefix}POST` ";
        $sql .= "POST INNER JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
        $sql .= "WHERE THREAD.TID = '{$search_result['tid']}' AND POST.PID = '{$search_result['pid']}' ";
        $sql .= "AND THREAD.LENGTH > 0 AND THREAD.DELETED = 'N' AND (THREAD.APPROVED IS NOT NULL ";
        $sql .= "OR THREAD.BY_UID = '{$_SESSION['UID']}') ";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function sphinx_search_date_range($from, $to)
{
    list($from_timestamp, $to_timestamp) = search_date_range($from, $to, SEARCH_DATE_RANGE_ARRAY);

    $range = '';

    if (isset($from_timestamp) && is_numeric($from_timestamp)) {
        $range = "AND created >= $from_timestamp ";
    }

    if (isset($to_timestamp) && is_numeric($to_timestamp)) {
        $range .= "AND created <= $to_timestamp ";
    }

    return $range;
}