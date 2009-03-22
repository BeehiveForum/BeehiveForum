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

/* $Id: visitor_log.inc.php,v 1.45 2009-03-22 18:48:14 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");

function visitor_log_get_recent()
{
    if (!$db_visitor_log_get_recent = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $lang = lang::get_instance()->load(__FILE__);

    $uid = bh_session_get_value('UID');

    if (forum_get_setting('guest_show_recent', 'Y')) {

        $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, ";
        $sql.= "USER_PEER.PEER_NICKNAME, SEARCH_ENGINE_BOTS.NAME, ";
        $sql.= "SEARCH_ENGINE_BOTS.URL, SEARCH_ENGINE_BOTS.SID, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON,  ";
        $sql.= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, ";
        $sql.= "USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
        $sql.= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, ";
        $sql.= "USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";
        $sql.= "FROM VISITOR_LOG VISITOR_LOG ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PREFS` USER_PREFS_FORUM ";
        $sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) ";
        $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
        $sql.= "ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
        $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
        $sql.= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
        $sql.= "AND VISITOR_LOG.FORUM = '$forum_fid' ";
        $sql.= "AND (USER_PREFS_FORUM.ANON_LOGON IS NULL OR USER_PREFS_FORUM.ANON_LOGON = 0) ";
        $sql.= "AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL OR USER_PREFS_GLOBAL.ANON_LOGON = 0) ";
        $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC LIMIT 10";

    }else {

        $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, ";
        $sql.= "USER_PEER.PEER_NICKNAME, SEARCH_ENGINE_BOTS.NAME, ";
        $sql.= "SEARCH_ENGINE_BOTS.URL, SEARCH_ENGINE_BOTS.SID, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON,  ";
        $sql.= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, ";
        $sql.= "USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
        $sql.= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, ";
        $sql.= "USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";
        $sql.= "FROM VISITOR_LOG VISITOR_LOG ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PREFS` USER_PREFS_FORUM ";
        $sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) ";
        $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
        $sql.= "ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
        $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
        $sql.= "WHERE VISITOR_LOG.LAST_LOGON IS NOT NULL AND VISITOR_LOG.LAST_LOGON > 0 ";
        $sql.= "AND VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID > 0 ";
        $sql.= "AND (USER_PREFS_FORUM.ANON_LOGON IS NULL OR USER_PREFS_FORUM.ANON_LOGON = 0) ";
        $sql.= "AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL OR USER_PREFS_GLOBAL.ANON_LOGON = 0) ";
        $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC LIMIT 10";
    }

    if (!$result = db_query($sql, $db_visitor_log_get_recent)) return false;

    if (db_num_rows($result) > 0) {

        $users_get_recent_array = array();

        while (($visitor_array = db_fetch_array($result))) {

            if ($visitor_array['UID'] == 0) {

                $visitor_array['LOGON']    = $lang['guest'];
                $visitor_array['NICKNAME'] = $lang['guest'];

            }elseif (!isset($visitor_array['LOGON']) || is_null($visitor_array['LOGON'])) {

                $visitor_array['LOGON'] = $lang['unknownuser'];
                $visitor_array['NICKNAME'] = "";
            }

            if (isset($visitor_array['AVATAR_URL_FORUM']) && strlen($visitor_array['AVATAR_URL_FORUM']) > 0) {
                $visitor_array['AVATAR_URL'] = $visitor_array['AVATAR_URL_FORUM'];
            }elseif (isset($visitor_array['AVATAR_URL_GLOBAL']) && strlen($visitor_array['AVATAR_URL_GLOBAL']) > 0) {
                $visitor_array['AVATAR_URL'] = $visitor_array['AVATAR_URL_GLOBAL'];
            }

            if (isset($visitor_array['AVATAR_AID_FORUM']) && is_md5($visitor_array['AVATAR_AID_FORUM'])) {
                $visitor_array['AVATAR_AID'] = $visitor_array['AVATAR_AID_FORUM'];
            }elseif (isset($visitor_array['AVATAR_AID_GLOBAL']) && is_md5($visitor_array['AVATAR_AID_GLOBAL'])) {
                $visitor_array['AVATAR_AID'] = $visitor_array['AVATAR_AID_GLOBAL'];
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

    return false;
}

function visitor_log_get_profile_items(&$profile_header_array, &$profile_dropdown_array)
{
    if (!$db_visitor_log_get_profile_items = db_connect()) return false;

    $lang = lang::get_instance()->load(__FILE__);

    if (!$table_data = get_table_prefix()) return false;

    // Pre-defined profile options

    $profile_header_array = array('POST_COUNT'      => $lang['postcount'],
                                  'LAST_VISIT'      => $lang['lastvisit'],
                                  'REGISTERED'      => $lang['registered'],
                                  'USER_TIME_BEST'  => $lang['longesttimeinforum'],
                                  'USER_TIME_TOTAL' => $lang['totaltimeinforum'],
                                  'DOB'             => $lang['birthday'],
                                  'AGE'             => $lang['age'],
                                  'TIMEZONE'        => $lang['timezone'],
                                  'LOCAL_TIME'      => 'Local Time');

    // Add the pre-defined profile options to the top of the list

    $profile_dropdown_array[$lang['userdetails']]['subitems'] = $profile_header_array;

    // Query the database to get the profile items

    $sql = "SELECT PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME ";
    $sql.= "FROM `{$table_data['PREFIX']}PROFILE_ITEM` PROFILE_ITEM ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}PROFILE_SECTION` PROFILE_SECTION ";
    $sql.= "ON (PROFILE_SECTION.PSID = PROFILE_ITEM.PSID) ";
    $sql.= "WHERE PROFILE_SECTION.PSID IS NOT NULL ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_ITEM.POSITION";

    if (!$result = db_query($sql, $db_visitor_log_get_profile_items)) return false;

    if (db_num_rows($result) > 0) {

        while (($profile_item = db_fetch_array($result))) {

            $profile_header_array[$profile_item['PIID']] = htmlentities_array($profile_item['ITEM_NAME']);
            $profile_dropdown_array[$profile_item['SECTION_NAME']]['subitems'][$profile_item['PIID']] = htmlentities_array($profile_item['ITEM_NAME']);
        }
    }

    return true;
}

function visitor_log_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty, $hide_guests)
{
    if (!$db_visitor_log_browse_items = db_connect()) return false;

    // Check the function parameters are all correct.

    if (!is_numeric($offset)) return false;

    if (!is_array($profile_items_array)) return false;

    // Fetch the table prefix.

    if (!$table_data = get_table_prefix()) return false;

    // Forum FID which we'll need later.

    $forum_fid = $table_data['FID'];

    // Forum timezone ID for Guests

    $timezone_id = forum_get_setting('forum_timezone', false, 27);

    // Permitted columns to sort the results by

    $sort_by_array  = array_keys($profile_items_array);

    // Permitted sort directions.

    $sort_dir_array = array('ASC', 'DESC');

    // Check the specified sort by and sort directions. If they're
    // invalid default to LAST_VISIT DESC.

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'UID';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    // Load the language file.

    $lang = lang::get_instance()->load(__FILE__);

    // Get the current session's UID.

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Constant for the relationship

    $user_friend = USER_FRIEND;

    // Named column NULL filtering

    $column_null_filter_having_array = array('POST_COUNT'      => '(POST_COUNT IS NOT NULL)',
                                             'LAST_VISIT'      => '(LAST_VISIT IS NOT NULL)',
                                             'REGISTERED'      => '(REGISTERED IS NOT NULL)',
                                             'USER_TIME_BEST'  => '(USER_TIME_BEST IS NOT NULL)',
                                             'USER_TIME_TOTAL' => '(USER_TIME_TOTAL IS NOT NULL)',
                                             'DOB'             => '(DOB IS NOT NULL)',
                                             'AGE'             => '(AGE IS NOT NULL AND AGE > 0)',
                                             'TIMEZONE'        => '(TIMEZONE IS NOT NULL)',
                                             'LOCAL_TIME'      => '(LOCAL_TIME IS NOT NULL)');

    // Year, Month and Day for Age calculation
    
    list($year, $month, $day) = explode('-', date(MYSQL_DATE, time()));
    
    // Current Date for User's local time
    
    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());
    
    // Main Query

    $select_sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, ";
    $select_sql.= "USER_PEER.RELATIONSHIP, USER_PEER.PEER_NICKNAME, USER_TRACK.POST_COUNT AS POST_COUNT, ";
    $select_sql.= "DATE_FORMAT(USER_PREFS_DOB.DOB, '0000-%m-%d') AS DOB, ";
    $select_sql.= "$year - DATE_FORMAT(USER_PREFS_AGE.DOB, '%Y') - ";
    $select_sql.= "('00-$month-$day' < DATE_FORMAT(USER_PREFS_AGE.DOB, '00-%m-%d')) AS AGE, ";
    $select_sql.= "TIMEZONES.TZID AS TIMEZONE, UNIX_TIMESTAMP('$current_datetime') AS LOCAL_TIME, ";
    $select_sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $select_sql.= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, ";
    $select_sql.= "USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
    $select_sql.= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, ";
    $select_sql.= "USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";

    // User's Last Visit

    $last_visit_sql = "UNIX_TIMESTAMP(VISITOR_LOG_TIME.LAST_LOGON) AS LAST_VISIT ";

    // Search Engine Bot Details

    $search_bot_sql = "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL ";

    // Include the selected numeric (PIID) profile items

    $profile_entry_array = array();

    // Include the profile item types and options.

    $profile_item_type_array = array();
    $profile_item_options_array = array();

    // Iterate through them.

    $profile_items_array_keys = array_keys($profile_items_array);

    foreach ($profile_items_array_keys as $column) {

        if (is_numeric($column)) {

            $profile_entry_sql = "USER_PROFILE_{$column}.ENTRY AS ENTRY_{$column} ";
            $profile_entry_array[$column] = $profile_entry_sql;

            $profile_item_type_sql = "PROFILE_ITEM_{$column}.TYPE AS PROFILE_ITEM_TYPE_{$column} ";
            $profile_item_type_array[] = $profile_item_type_sql;

            $profile_item_options_sql = "PROFILE_ITEM_{$column}.OPTIONS AS PROFILE_ITEM_OPTIONS_{$column} ";
            $profile_item_options_array[] = $profile_item_options_sql;
        }
    }

    // From portion which selects users and guests from the VISITOR_LOG table.

    $from_sql = "FROM USER LEFT JOIN VISITOR_LOG ON (VISITOR_LOG.UID = USER.UID AND VISITOR_LOG.FORUM = '$forum_fid') ";

    // Join to get the user's DOB.

    $join_sql = "LEFT JOIN USER_PREFS USER_PREFS_DOB ON (USER_PREFS_DOB.UID = USER.UID ";
    $join_sql.= "AND USER_PREFS_DOB.DOB_DISPLAY > 1 AND USER_PREFS_DOB.DOB > 0) ";

    // Join to check the AGE display.

    $join_sql.= "LEFT JOIN USER_PREFS USER_PREFS_AGE ";
    $join_sql.= "ON (USER_PREFS_AGE.UID = USER.UID AND (USER_PREFS_DOB.DOB_DISPLAY = 1 ";
    $join_sql.= "OR USER_PREFS_DOB.DOB_DISPLAY = 3) AND USER_PREFS_DOB.DOB > 0) ";

    // Joins to check the ANON_LOGON setting.

    $join_sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PREFS` USER_PREFS_FORUM ";
    $join_sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) ";

    $join_sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $join_sql.= "ON (USER_PREFS_GLOBAL.UID = USER.UID) ";

    // Join to fetch the LAST_LOGON using the ANON_LOGON data

    $join_sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG_TIME ON (VISITOR_LOG_TIME.UID = USER.UID ";
    $join_sql.= "AND VISITOR_LOG_TIME.VID = VISITOR_LOG.VID AND ((USER_PREFS_FORUM.ANON_LOGON IS NULL ";
    $join_sql.= "OR USER_PREFS_FORUM.ANON_LOGON = 0) AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL ";
    $join_sql.= "OR USER_PREFS_GLOBAL.ANON_LOGON = 0))) ";

    // Join for the POST_COUNT.

    $join_sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ";
    $join_sql.= "ON (USER_TRACK.UID = USER.UID) ";

    // Join for user relationship

    $join_sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $join_sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";

    // Join for the search bot data

    $join_sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";

    // Join for the user timezone

    $join_sql.= "LEFT JOIN TIMEZONES ON (TIMEZONES.TZID = USER_PREFS_GLOBAL.TIMEZONE) ";

    // Joins on the selected numeric (PIID) profile items.

    $profile_items_array_keys = array_keys($profile_items_array);

    foreach ($profile_items_array_keys as $column) {

        if (is_numeric($column)) {

            $join_sql.= "LEFT JOIN `{$table_data['PREFIX']}PROFILE_ITEM` PROFILE_ITEM_{$column} ";
            $join_sql.= "ON (PROFILE_ITEM_{$column}.PIID = '$column') ";
            $join_sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PROFILE` USER_PROFILE_{$column} ";
            $join_sql.= "ON (USER_PROFILE_{$column}.PIID = PROFILE_ITEM_{$column}.PIID ";
            $join_sql.= "AND USER_PROFILE_{$column}.UID = USER.UID ";
            $join_sql.= "AND (USER_PROFILE_{$column}.PRIVACY = 0 ";
            $join_sql.= "OR (USER_PROFILE_{$column}.PRIVACY = 1 ";
            $join_sql.= "AND (USER_PEER.RELATIONSHIP & $user_friend > 0)))) ";
        }
    }

    // The Where clause

    $where_query_array = array();
    $having_query_array = array();

    // Where clause for UNION with VISITOR_LOG.

    $where_visitor_array = array("VISITOR_LOG.UID = '0'");

    // Null column filtering for Guests

    $having_visitor_array = array();

    // Filter by user name / search engine bot name

    if (($user_search !== false) && strlen(trim($user_search)) > 0) {

        $user_search = db_escape_string(str_replace('%', '', $user_search));

        $user_search_sql = "(USER.LOGON LIKE '$user_search%' OR ";
        $user_search_sql.= "USER.NICKNAME LIKE '$user_search%')";

        $where_query_array[] = $user_search_sql;

        if ($hide_guests === false) {

            $where_visitor_sql = "SEARCH_ENGINE_BOTS.NAME LIKE '$user_search%'";
            $where_visitor_array[] = $where_visitor_sql;
        }
    }

    // Hide Guests

    if ($hide_guests === true) {

        $where_query_array[] = "(USER.UID IS NOT NULL AND USER.UID > 0) ";
    }

    // Hide empty or NULL values

    if ($hide_empty === true) {

        $profile_items_array_keys = array_keys($profile_items_array);

        foreach ($profile_items_array_keys as $column) {

            if (is_numeric($column)) {

                $having_query_array[] = "(ENTRY_{$column} IS NOT NULL) ";
                $having_visitor_array[] = "(ENTRY_{$column} IS NOT NULL) ";

            }else {

                $having_query_array[] = $column_null_filter_having_array[$column];
                $having_visitor_array[] = $column_null_filter_having_array[$column];
            }
        }
    }

    // Main query NULL column filtering

    if (sizeof($having_query_array) > 0) {
        $having_sql = sprintf("HAVING %s", implode(" OR ", $having_query_array));
    }else {
        $having_sql = "";
    }

    if (sizeof($where_query_array) > 0) {
        $where_sql = sprintf("WHERE %s", implode(" AND ", $where_query_array));
    }else {
        $where_sql = "";
    }

    // Guest NULL column filtering

    if (sizeof($where_visitor_array) > 0) {
        $where_visitor_sql = sprintf("WHERE %s", implode(" AND ", $where_visitor_array));
    }else {
        $where_visitor_sql = "";
    }

    if (sizeof($having_visitor_array) > 0) {
        $having_visitor_sql = sprintf("HAVING %s", implode(" AND ", $having_visitor_array));
    }else {
        $having_visitor_sql = "";
    }

    // Sort direction specified?

    $order_sql = is_numeric($sort_by) ? "ORDER BY ENTRY_{$sort_by} $sort_dir " : "ORDER BY $sort_by $sort_dir ";

    // Limit the display to 10 per page.

    $limit_sql = "LIMIT $offset, 10";

    // Array to store our results in.

    $user_array = array();

    // Perform a different query if we're hiding guests.

    if ($hide_guests === true) {

        $query_array_merge = array_merge(array($select_sql), $profile_entry_array, $profile_item_type_array);
        $query_array_merge = array_merge($query_array_merge, $profile_item_options_array, array($search_bot_sql, $last_visit_sql));

        $sql = implode(",", $query_array_merge). "$from_sql $join_sql $where_sql $having_sql $order_sql $limit_sql";

    }else {

        $query_array_merge = array_merge(array($select_sql), $profile_entry_array, $profile_item_type_array);
        $query_array_merge = array_merge($query_array_merge, $profile_item_options_array, array($search_bot_sql, $last_visit_sql));

        $profile_entry_array = preg_grep("/[0-9]+/u", $profile_entry_array);

        if (sizeof($profile_entry_array) > 0) {

            $profile_item_columns = implode(', ', array_map('visitor_log_prof_item_column', array_keys($profile_entry_array)));

            $sql = implode(",", $query_array_merge). "$from_sql $join_sql $where_sql $having_sql ";
            $sql.= "UNION SELECT VISITOR_LOG.UID, '' AS LOGON, '' AS NICKNAME, ";
            $sql.= "NULL AS RELATIONSHIP, '' AS PEER_NICKNAME, 0 AS POST_COUNT, ";
            $sql.= "NULL AS DOB, NULL AS AGE, $timezone_id AS TIMEZONE, ";
            $sql.= "UNIX_TIMESTAMP('$current_datetime') AS LOCAL_TIME, NULL AS REGISTERED, ";
            $sql.= "NULL AS USER_TIME_BEST, NULL AS USER_TIME_TOTAL, ";
            $sql.= "'' AS AVATAR_URL_FORUM, '' AS AVATAR_AID_FORUM, ";
            $sql.= "'' AS AVATAR_URL_GLOBAL, '' AS AVATAR_AID_GLOBAL, $profile_item_columns, ";
            $sql.= "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL, ";
            $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_VISIT FROM VISITOR_LOG ";
            $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
            $sql.= "$where_visitor_sql $having_visitor_sql $order_sql $limit_sql";

        }else {

            $sql = implode(",", $query_array_merge). "$from_sql $join_sql $where_sql $having_sql ";
            $sql.= "UNION SELECT VISITOR_LOG.UID, '' AS LOGON, '' AS NICKNAME, ";
            $sql.= "NULL AS RELATIONSHIP, '' AS PEER_NICKNAME, 0 AS POST_COUNT, ";
            $sql.= "NULL AS DOB, NULL AS AGE, $timezone_id AS TIMEZONE, ";
            $sql.= "UNIX_TIMESTAMP('$current_datetime') AS LOCAL_TIME, NULL AS REGISTERED, ";
            $sql.= "NULL AS USER_TIME_BEST, NULL AS USER_TIME_TOTAL, ";
            $sql.= "'' AS AVATAR_URL_FORUM, '' AS AVATAR_AID_FORUM, ";
            $sql.= "'' AS AVATAR_URL_GLOBAL, '' AS AVATAR_AID_GLOBAL, ";
            $sql.= "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL, ";
            $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_VISIT FROM VISITOR_LOG ";
            $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";
            $sql.= "$where_visitor_sql $having_visitor_sql $order_sql $limit_sql";
        }
    }

    if (!$result = db_query($sql, $db_visitor_log_browse_items)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_visitor_log_browse_items)) return false;

    list($user_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    // Check if we have any results.

    if (db_num_rows($result) > 0) {

        while (($user_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            if ($user_data['UID'] == 0) {

                $user_data['LOGON']    = $lang['guest'];
                $user_data['NICKNAME'] = $lang['guest'];

            }elseif (!isset($user_data['LOGON']) || is_null($user_data['LOGON'])) {

                $user_data['LOGON'] = $lang['unknownuser'];
                $user_data['NICKNAME'] = "";
            }

            if (isset($user_data['AVATAR_URL_FORUM']) && strlen($user_data['AVATAR_URL_FORUM']) > 0) {
                $user_data['AVATAR_URL'] = $user_data['AVATAR_URL_FORUM'];
            }elseif (isset($user_data['AVATAR_URL_GLOBAL']) && strlen($user_data['AVATAR_URL_GLOBAL']) > 0) {
                $user_data['AVATAR_URL'] = $user_data['AVATAR_URL_GLOBAL'];
            }

            if (isset($user_data['AVATAR_AID_FORUM']) && is_md5($user_data['AVATAR_AID_FORUM'])) {
                $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_FORUM'];
            }elseif (isset($user_data['AVATAR_AID_GLOBAL']) && is_md5($user_data['AVATAR_AID_GLOBAL'])) {
                $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_GLOBAL'];
            }

            if (isset($user_data['LAST_VISIT']) && is_numeric($user_data['LAST_VISIT'])) {
                $user_data['LAST_VISIT'] = format_time($user_data['LAST_VISIT']);
            }else {
                $user_data['LAST_VISIT'] = $lang['unknown'];
            }

            if (isset($user_data['REGISTERED']) && is_numeric($user_data['REGISTERED'])) {
                $user_data['REGISTERED'] = format_date($user_data['REGISTERED']);
            }else {
                $user_data['REGISTERED'] = $lang['unknown'];
            }

            if (isset($user_data['USER_TIME_BEST']) && is_numeric($user_data['USER_TIME_BEST'])) {
                $user_data['USER_TIME_BEST'] = format_time_display($user_data['USER_TIME_BEST']);
            }else {
                $user_data['USER_TIME_BEST'] = $lang['unknown'];
            }

            if (isset($user_data['USER_TIME_TOTAL']) && is_numeric($user_data['USER_TIME_TOTAL'])) {
                $user_data['USER_TIME_TOTAL'] = format_time_display($user_data['USER_TIME_TOTAL']);
            }else {
                $user_data['USER_TIME_TOTAL'] = $lang['unknown'];
            }

            if (!isset($user_data['AGE']) || !is_numeric($user_data['AGE'])) {
                $user_data['AGE'] = $lang['unknown'];
            }

            if (!$user_data['DOB'] = format_birthday($user_data['DOB'])) {
                $user_data['DOB'] = $lang['unknown'];
            }

            $user_data['TIMEZONE'] = timezone_id_to_string($user_data['TIMEZONE']);
            
            if (isset($user_data['LOCAL_TIME']) && is_numeric($user_data['LOCAL_TIME'])) {
                $user_data['LOCAL_TIME'] = format_time($user_data['LOCAL_TIME']);
            }else {
                $user_data['LOCAL_TIME'] = $lang['unknown'];
            }            

            if (!isset($user_data['POST_COUNT']) || !is_numeric($user_data['POST_COUNT'])) {
                $user_data['POST_COUNT'] = 0;
            }

            $user_array[] = $user_data;
        }

    }elseif ($user_count > 0) {

        $offset = floor(($user_count - 1) / 10) * 10;
        return visitor_log_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty, $hide_guests);
    }

    return array('user_count' => $user_count,
                 'user_array' => $user_array);
}

function visitor_log_prof_item_column($column)
{
    $profile_column_sql = "'' AS ENTRY_{$column}, ";
    $profile_column_sql.= "0 AS PROFILE_ITEM_TYPE_{$column}, ";
    $profile_column_sql.= "'' AS PROFILE_ITEM_OPTIONS_{$column} ";

    return $profile_column_sql;
}

function visitor_log_clean_up()
{
    if (!$db_visitor_log_clean_up = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Keep visitor log for 7 days.
    
    $visitor_cutoff_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - (DAY_IN_SECONDS * 7));

    $sql = "DELETE QUICK FROM VISITOR_LOG WHERE FORUM = '$forum_fid' ";
    $sql.= "AND LAST_LOGON < '$visitor_cutoff_datetime' ";

    if (!db_query($sql, $db_visitor_log_clean_up)) return false;

    return true;
}

?>