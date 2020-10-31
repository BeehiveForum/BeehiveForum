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
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'timezone.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function visitor_log_get_recent()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (forum_get_setting('guest_show_recent', 'Y') && user_guest_enabled()) {

        $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, ";
        $sql .= "USER_PEER.PEER_NICKNAME, SEARCH_ENGINE_BOTS.NAME, ";
        $sql .= "SEARCH_ENGINE_BOTS.URL, SEARCH_ENGINE_BOTS.SID, ";
        $sql .= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON,  ";
        $sql .= "COALESCE(USER_PREFS_FORUM.AVATAR_URL, USER_PREFS_GLOBAL.AVATAR_URL) AS AVATAR_URL, ";
        $sql .= "COALESCE(USER_PREFS_FORUM.AVATAR_AID, USER_PREFS_GLOBAL.AVATAR_AID) AS AVATAR_AID ";
        $sql .= "FROM VISITOR_LOG VISITOR_LOG ";
        $sql .= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ";
        $sql .= "ON (USER_PREFS_FORUM.UID = USER.UID) ";
        $sql .= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
        $sql .= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
        $sql .= "AND VISITOR_LOG.FORUM = '$forum_fid' ";
        $sql .= "AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL OR USER_PREFS_GLOBAL.ANON_LOGON = 0) ";
        $sql .= "ORDER BY VISITOR_LOG.LAST_LOGON DESC LIMIT 10";

    } else {

        $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, ";
        $sql .= "USER_PEER.PEER_NICKNAME, SEARCH_ENGINE_BOTS.NAME, ";
        $sql .= "SEARCH_ENGINE_BOTS.URL, SEARCH_ENGINE_BOTS.SID, ";
        $sql .= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON,  ";
        $sql .= "COALESCE(USER_PREFS_FORUM.AVATAR_URL, USER_PREFS_GLOBAL.AVATAR_URL) AS AVATAR_URL, ";
        $sql .= "COALESCE(USER_PREFS_FORUM.AVATAR_AID, USER_PREFS_GLOBAL.AVATAR_AID) AS AVATAR_AID ";
        $sql .= "FROM VISITOR_LOG VISITOR_LOG ";
        $sql .= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ";
        $sql .= "ON (USER_PREFS_FORUM.UID = USER.UID) ";
        $sql .= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
        $sql .= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
        $sql .= "AND VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID > 0 ";
        $sql .= "AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL OR USER_PREFS_GLOBAL.ANON_LOGON = 0) ";
        $sql .= "ORDER BY VISITOR_LOG.LAST_LOGON DESC LIMIT 10";
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $users_get_recent_array = array();

    while (($visitor_array = $result->fetch_assoc()) !== null) {

        if ($visitor_array['UID'] == 0) {

            $visitor_array['LOGON'] = gettext('Guest');
            $visitor_array['NICKNAME'] = gettext('Guest');

        } else if (!isset($visitor_array['LOGON']) || is_null($visitor_array['LOGON'])) {

            $visitor_array['LOGON'] = gettext('Unknown User');
            $visitor_array['NICKNAME'] = "";
        }

        if (isset($visitor_array['PEER_NICKNAME'])) {

            if (!is_null($visitor_array['PEER_NICKNAME']) && strlen($visitor_array['PEER_NICKNAME']) > 0) {

                $visitor_array['NICKNAME'] = $visitor_array['PEER_NICKNAME'];
            }
        }

        $users_get_recent_array[] = $visitor_array;
    }

    return $users_get_recent_array;
}

function visitor_log_get_profile_items(&$profile_header_array, &$profile_dropdown_array)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    // Pre-defined profile options
    $profile_header_array = array(
        'POST_COUNT' => gettext("Post Count"),
        'LAST_VISIT' => gettext("Last Visit"),
        'REGISTERED' => gettext("Registered"),
        'DOB' => gettext("Birthday"),
        'AGE' => gettext("Age"),
        'TIMEZONE' => gettext("Time Zone"),
        'LOCAL_TIME' => gettext("Local Time"),
        'USER_RATING' => gettext("User Rating"),
        'POST_SCORES' => gettext("Post Scores"),
    );

    // Add the pre-defined profile options to the top of the list
    $profile_dropdown_array[gettext("User Details")]['subitems'] = $profile_header_array;

    // Query the database to get the profile items
    $sql = "SELECT PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql .= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME ";
    $sql .= "FROM `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql .= "LEFT JOIN `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql .= "ON (PROFILE_SECTION.PSID = PROFILE_ITEM.PSID) ";
    $sql .= "WHERE PROFILE_SECTION.PSID IS NOT NULL ";
    $sql .= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_ITEM.POSITION";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($profile_item = $result->fetch_assoc()) !== null) {

        $profile_header_array[$profile_item['PIID']] = htmlentities_array($profile_item['ITEM_NAME']);
        $profile_dropdown_array[$profile_item['SECTION_NAME']]['subitems'][$profile_item['PIID']] = htmlentities_array($profile_item['ITEM_NAME']);
    }

    return true;
}

function visitor_log_browse_items($user_search, $profile_items_array, $page, $sort_by, $sort_dir, $hide_empty, $hide_guests)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) return false;

    $offset = calculate_page_offset($page, 10);

    if (!is_array($profile_items_array)) return false;

    // Fetch the table prefix.
    if (!($table_prefix = get_table_prefix())) return false;

    // Forum FID which we'll need later.
    if (!($forum_fid = get_forum_fid())) return false;

    // Permitted columns to sort the results by
    $sort_by_array = array_keys($profile_items_array);

    // Permitted sort directions.
    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    // Check the specified sort by and sort directions. If they're
    // invalid default to LAST_VISIT DESC.
    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'UID';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    // Get the current session's UID.
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Constant for the relationship
    $user_friend = USER_FRIEND;

    // Named column NULL filtering
    $column_null_filter_having_array = array(
        'POST_COUNT' => '(POST_COUNT IS NOT NULL)',
        'LAST_VISIT' => '(LAST_VISIT IS NOT NULL)',
        'REGISTERED' => '(REGISTERED IS NOT NULL)',
        'DOB' => '(DOB IS NOT NULL)',
        'AGE' => '(AGE IS NOT NULL AND AGE > 0)',
        'TIMEZONE' => '(TIMEZONE IS NOT NULL)',
        'LOCAL_TIME' => '(LOCAL_TIME IS NOT NULL)',
        'USER_RATING' => '(USER_RATING > 0)',
        'POST_SCORES' => '(POST_VOTE_TOTAL > 0)',
    );

    // Column alias to perform sorting against for textual results.
    $column_sort_alias = array(
        'POST_SCORES' => 'POST_VOTE_TOTAL',
    );

    // Year, Month and Day for Age calculation
    list($year, $month, $day) = explode('-', date(MYSQL_DATE, time()));

    // Current Date for User's local time
    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    // Main Query
    $select_sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP, ";
    $select_sql .= "USER_PEER.PEER_NICKNAME, CAST(USER_TRACK.USER_VALUE AS UNSIGNED) AS POST_COUNT, ";
    $select_sql .= "IF (USER_PREFS_GLOBAL.DOB_DISPLAY > 1, DATE_FORMAT(USER_PREFS_GLOBAL.DOB, '0000-%m-%d'), NULL) AS DOB, ";
    $select_sql .= "IF (USER_PREFS_GLOBAL.DOB_DISPLAY IN (1, 3), $year - DATE_FORMAT(USER_PREFS_GLOBAL.DOB, '%Y') - ";
    $select_sql .= "('00-$month-$day' < DATE_FORMAT(USER_PREFS_GLOBAL.DOB, '00-%m-%d')), ";
    $select_sql .= "NULL) AS AGE, TIMEZONES.TZID AS TIMEZONE, UNIX_TIMESTAMP('$current_datetime') AS LOCAL_TIME, ";
    $select_sql .= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, COALESCE(USER_PREFS_FORUM.AVATAR_URL, ";
    $select_sql .= "USER_PREFS_GLOBAL.AVATAR_URL) AS AVATAR_URL, COALESCE(USER_PREFS_FORUM.AVATAR_AID, ";
    $select_sql .= "USER_PREFS_GLOBAL.AVATAR_AID) AS AVATAR_AID, SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, ";
    $select_sql .= "SEARCH_ENGINE_BOTS.URL, IF (USER_PREFS_GLOBAL.ANON_LOGON = 1, NULL, ";
    $select_sql .= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON)) AS LAST_VISIT, ";
    $select_sql .= "COALESCE(USER_RATING.USER_RATING, 0) AS USER_RATING, ";
    $select_sql .= "COALESCE(POST_RATING.POST_VOTE_TOTAL, 0) AS POST_VOTE_TOTAL, ";
    $select_sql .= "COALESCE(POST_RATING.POST_VOTE_UP, 0) AS POST_VOTE_UP, ";
    $select_sql .= "COALESCE(POST_RATING.POST_VOTE_DOWN, 0) AS POST_VOTE_DOWN ";

    // Include the selected numeric (PIID) profile items
    $profile_entry_array = array();

    // Include the profile item types and options.
    $profile_item_type_array = array();
    $profile_item_options_array = array();

    // Iterate through them.
    foreach ($sort_by_array as $column) {

        if (is_numeric($column)) {

            $profile_entry_array[$column] = "USER_PROFILE_{$column}.ENTRY AS ENTRY_{$column} ";
            $profile_item_type_array[] = "PROFILE_ITEM_{$column}.TYPE AS PROFILE_ITEM_TYPE_{$column} ";
            $profile_item_options_array[] = "PROFILE_ITEM_{$column}.OPTIONS AS PROFILE_ITEM_OPTIONS_{$column} ";
        }
    }

    // From portion which selects users and guests from the VISITOR_LOG table.
    $from_sql = "FROM VISITOR_LOG LEFT JOIN USER ON (USER.UID = VISITOR_LOG.UID) ";

    // Various joins we need for User's Age, DOB, etc.
    $join_sql = "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $join_sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = USER.UID) ";
    $join_sql .= "LEFT JOIN `{$table_prefix}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER.UID AND USER_TRACK.USER_KEY = 'POST_COUNT') ";
    $join_sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $join_sql .= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
    $join_sql .= "LEFT JOIN TIMEZONES ON (TIMEZONES.TZID = USER_PREFS_GLOBAL.TIMEZONE) ";
    $join_sql .= "LEFT JOIN (SELECT POST_RATING.UID, COUNT(POST_RATING.RATING) AS POST_VOTE_TOTAL, ";
    $join_sql .= "SUM(IF(POST_RATING.RATING > 0, 1, 0)) AS POST_VOTE_UP, ";
    $join_sql .= "SUM(IF(POST_RATING.RATING < 0, 1, 0)) AS POST_VOTE_DOWN ";
    $join_sql .= "FROM `{$table_prefix}POST_RATING` POST_RATING GROUP BY POST_RATING.UID) AS POST_RATING ";
    $join_sql .= "ON (POST_RATING.UID = VISITOR_LOG.UID) LEFT JOIN (SELECT POST.FROM_UID AS UID, ";
    $join_sql .= "SUM(POST_RATING.RATING) AS USER_RATING FROM `{$table_prefix}POST` POST ";
    $join_sql .= "INNER JOIN `{$table_prefix}POST_RATING` POST_RATING ON (POST_RATING.TID = POST.TID ";
    $join_sql .= "AND POST_RATING.PID = POST.PID) GROUP BY POST.FROM_UID) AS USER_RATING ";
    $join_sql .= "ON (USER_RATING.UID = VISITOR_LOG.UID) ";

    // Joins on the selected numeric (PIID) profile items.
    foreach ($sort_by_array as $column) {

        if (is_numeric($column)) {

            $join_sql .= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM_{$column} ";
            $join_sql .= "ON (PROFILE_ITEM_{$column}.PIID = '$column') ";
            $join_sql .= "LEFT JOIN `{$table_prefix}USER_PROFILE` USER_PROFILE_{$column} ";
            $join_sql .= "ON (USER_PROFILE_{$column}.PIID = PROFILE_ITEM_{$column}.PIID ";
            $join_sql .= "AND USER_PROFILE_{$column}.UID = USER.UID ";
            $join_sql .= "AND (USER_PROFILE_{$column}.PRIVACY = 0 ";
            $join_sql .= "OR (USER_PROFILE_{$column}.PRIVACY = 1 ";
            $join_sql .= "AND (USER_PEER.RELATIONSHIP & $user_friend > 0)))) ";
        }
    }

    // The Where clause
    $where_query_array = array(
        "VISITOR_LOG.FORUM = '$forum_fid'"
    );

    // Having clause for filtering NULL columns.
    $having_query_array = array();

    // Filter by user name / search engine bot name
    if (($user_search !== false) && strlen(trim($user_search)) > 0) {

        $user_search = $db->escape(str_replace('%', '', $user_search));

        $user_search_sql = "(USER.LOGON LIKE '$user_search%' OR ";
        $user_search_sql .= "USER.NICKNAME LIKE '$user_search%')";

        $where_query_array[] = $user_search_sql;
    }

    // Hide Guests
    if ($hide_guests === true) {
        $where_query_array[] = "(USER.UID IS NOT NULL) ";
    }

    // Hide empty or NULL values
    if ($hide_empty === true) {

        foreach ($sort_by_array as $column) {

            if (is_numeric($column)) {

                $having_query_array[] = "(LENGTH(ENTRY_{$column}) > 0) ";

            } else {

                $having_query_array[] = $column_null_filter_having_array[$column];
            }
        }
    }

    // Main query NULL column filtering
    if (sizeof($having_query_array) > 0) {
        $having_sql = sprintf("HAVING %s", implode(" OR ", $having_query_array));
    } else {
        $having_sql = "";
    }

    if (sizeof($where_query_array) > 0) {
        $where_sql = sprintf("WHERE %s", implode(" AND ", $where_query_array));
    } else {
        $where_sql = "";
    }

    // Sort direction specified?
    if (is_numeric($sort_by)) {
        $order_sql = "ORDER BY ENTRY_{$sort_by} $sort_dir ";
    } else if (isset($column_sort_alias[$sort_by])) {
        $order_sql = "ORDER BY {$column_sort_alias[$sort_by]} $sort_dir ";
    } else {
        $order_sql = "ORDER BY $sort_by $sort_dir";
    }

    // Limit the display to 10 per page.
    $limit_sql = "LIMIT $offset, 10";

    // Array to store our results in.
    $user_array = array();

    // Combine the profile columns with the main select SQL.
    $query_array_merge = array_merge(array($select_sql), $profile_entry_array, $profile_item_type_array, $profile_item_options_array);

    // Construct final SQL query.
    $sql = implode(",", $query_array_merge) . "$from_sql $join_sql ";
    $sql .= "$where_sql $having_sql $order_sql $limit_sql";

    if (!($result = $db->query($sql))) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_count) = $result_count->fetch_row();

    // Check if we have any results.
    if (($result->num_rows == 0) && ($user_count > 0) && ($page > 1)) {
        return visitor_log_browse_items($user_search, $profile_items_array, $page - 1, $sort_by, $sort_dir, $hide_empty, $hide_guests);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if ($user_data['UID'] == 0) {

            $user_data['LOGON'] = gettext("Guest");
            $user_data['NICKNAME'] = gettext("Guest");

        } else if (!isset($user_data['LOGON']) || is_null($user_data['LOGON'])) {

            $user_data['LOGON'] = gettext("Unknown user");
            $user_data['NICKNAME'] = "";
        }

        if (isset($user_data['LAST_VISIT']) && is_numeric($user_data['LAST_VISIT'])) {
            $user_data['LAST_VISIT'] = format_date_time($user_data['LAST_VISIT']);
        } else {
            $user_data['LAST_VISIT'] = gettext("Unknown");
        }

        if (isset($user_data['REGISTERED']) && is_numeric($user_data['REGISTERED'])) {
            $user_data['REGISTERED'] = format_date_time($user_data['REGISTERED']);
        } else {
            $user_data['REGISTERED'] = gettext("Unknown");
        }

        if (!isset($user_data['AGE']) || !is_numeric($user_data['AGE'])) {
            $user_data['AGE'] = gettext("Unknown");
        }

        if (!$user_data['DOB'] = format_birthday($user_data['DOB'])) {
            $user_data['DOB'] = gettext("Unknown");
        }

        $user_data['TIMEZONE'] = timezone_id_to_string($user_data['TIMEZONE']);

        if (isset($user_data['LOCAL_TIME']) && is_numeric($user_data['LOCAL_TIME'])) {
            $user_data['LOCAL_TIME'] = format_date_time($user_data['LOCAL_TIME']);
        } else {
            $user_data['LOCAL_TIME'] = gettext("Unknown");
        }

        if (!isset($user_data['POST_COUNT']) || !is_numeric($user_data['POST_COUNT'])) {
            $user_data['POST_COUNT'] = 0;
        }

        if (!isset($user_data['POST_VOTE_TOTAL']) || !is_numeric($user_data['POST_VOTE_TOTAL'])) {
            $user_data['POST_VOTE_TOTAL'] = 0;
        }

        if (!isset($user_data['POST_VOTE_DOWN']) || !is_numeric($user_data['POST_VOTE_DOWN'])) {
            $user_data['POST_VOTE_DOWN'] = 0;
        }

        if (!isset($user_data['POST_VOTE_UP']) || !is_numeric($user_data['POST_VOTE_UP'])) {
            $user_data['POST_VOTE_UP'] = 0;
        }

        $user_data['POST_SCORES'] = sprintf(
            gettext("%d total, %d down - %d up"),
            $user_data['POST_VOTE_TOTAL'],
            $user_data['POST_VOTE_DOWN'],
            $user_data['POST_VOTE_UP']
        );

        $user_array[] = $user_data;
    }

    return array(
        'user_count' => $user_count,
        'user_array' => $user_array
    );
}

function visitor_log_prof_item_column($column)
{
    $profile_column_sql = "'' AS ENTRY_{$column}, ";
    $profile_column_sql .= "0 AS PROFILE_ITEM_TYPE_{$column}, ";
    $profile_column_sql .= "'' AS PROFILE_ITEM_OPTIONS_{$column} ";

    return $profile_column_sql;
}

function visitor_log_prune()
{
    if (!$db = db::get()) return false;

    $forum_fids = forum_get_all_fids();

    $visitor_log_prune_length = intval(forum_get_setting('visitor_log_auto_prune', null, 0));

    $remove_days_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - ($visitor_log_prune_length * DAY_IN_SECONDS));

    foreach ($forum_fids as $forum_fid) {
        $sql = "DELETE LOW_PRIORITY FROM VISITOR_LOG WHERE FORUM = '$forum_fid' ";
        $sql .= "AND LAST_LOGON < CAST('$remove_days_datetime' AS DATETIME)";

        if (!$db->query($sql)) return false;
    }

    return true;
}