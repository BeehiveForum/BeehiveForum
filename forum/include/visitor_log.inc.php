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

/* $Id: visitor_log.inc.php,v 1.6 2007-09-01 16:17:23 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");

function visitor_log_get_recent()
{
    $db_visitor_log_get_recent = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $lang = load_language_file();

    $uid = bh_session_get_value('UID');

    if (forum_get_setting('guest_show_recent', 'Y')) {

        $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
        $sql.= "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL ";
        $sql.= "FROM VISITOR_LOG VISITOR_LOG ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS_FORUM ";
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

        $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
        $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
        $sql.= "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL ";
        $sql.= "FROM VISITOR_LOG VISITOR_LOG ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS_FORUM ";
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

        while ($visitor_array = db_fetch_array($result)) {

            if ($visitor_array['UID'] == 0) {

                $visitor_array['LOGON']    = $lang['guest'];
                $visitor_array['NICKNAME'] = $lang['guest'];

            }elseif (!isset($visitor_array['LOGON']) || is_null($visitor_array['LOGON'])) {

                $visitor_array['LOGON'] = $lang['unknownuser'];
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

    return false;
}

function visitor_log_get_profile_items(&$profile_header_array, &$profile_dropdown_array)
{
    $db_visitor_log_get_profile_items = db_connect();

    $lang = load_language_file();

    if (!$table_data = get_table_prefix()) return false;

    // Pre-defined profile options

    $profile_header_array = array('POST_COUNT'      => $lang['postcount'],
                                  'LAST_VISIT'      => $lang['lastvisit'],
                                  'REGISTERED'      => $lang['registered'],
                                  'USER_TIME_BEST'  => $lang['longesttimeinforum'],
                                  'USER_TIME_TOTAL' => $lang['totaltimeinforum'],
                                  'DOB'             => $lang['birthday'],
                                  'AGE'             => $lang['age'],
                                  'TIMEZONE'        => $lang['timezone']);

    // Add the pre-defined profile options to the top of the list

    $profile_dropdown_array[$lang['userdetails']] = $profile_header_array;

    // Query the database to get the

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME AS SECTION_NAME, ";
    $sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME, PROFILE_ITEM.TYPE ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "ON (PROFILE_SECTION.PSID = PROFILE_ITEM.PSID) ";
    $sql.= "WHERE PROFILE_SECTION.PSID IS NOT NULL";

    if (!$result = db_query($sql, $db_visitor_log_get_profile_items)) return false;

    if (db_num_rows($result) > 0) {

        while ($profile_item = db_fetch_array($result)) {

            if (($profile_item['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_item['TYPE'] == PROFILE_ITEM_DROPDOWN)) {
                @list($profile_item['ITEM_NAME']) = explode(':', $profile_item['ITEM_NAME']);
            }

            $profile_header_array[$profile_item['PIID']] = $profile_item['ITEM_NAME'];
            $profile_dropdown_array[$profile_item['SECTION_NAME']][$profile_item['PIID']] = $profile_item['ITEM_NAME'];
        }
    }

    return true;
}

function visitor_log_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty, $hide_guests)
{
    $db_visitor_log_browse_items = db_connect();

    // Check the function parameters are all correct.

    if (!is_numeric($offset)) return false;

    if (!is_array($profile_items_array)) return false;

    // Fetch the table prefix.

    if (!$table_data = get_table_prefix()) return false;

    // Forum FID which we'll need later.

    $forum_fid = $table_data['FID'];

    // Permitted columns to sort the results by

    $sort_by_array  = array_keys($profile_items_array);

    // Permitted sort directions.

    $sort_dir_array = array('ASC', 'DESC');

    // Check the specified sort by and sort directions. If they're
    // invalid default to LAST_VISIT DESC.

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'UID';
    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    // Load the language file.

    $lang = load_language_file();

    // Get the current session's UID.

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Constant for the relationship

    $user_friend = USER_FRIEND;

    // Named column NULL filtering

    $column_null_filter_having_array = array('POST_COUNT'      => '(POST_COUNT IS NOT NULL AND LENGTH(POST_COUNT) > 0)',
                                             'LAST_VISIT'      => '(LAST_VISIT IS NOT NULL AND LENGTH(LAST_VISIT) > 0)',
                                             'REGISTERED'      => '(REGISTERED IS NOT NULL AND LENGTH(REGISTERED) > 0)',
                                             'USER_TIME_BEST'  => '(USER_TIME_BEST IS NOT NULL AND LENGTH(USER_TIME_BEST) > 0)',
                                             'USER_TIME_TOTAL' => '(USER_TIME_TOTAL IS NOT NULL AND LENGTH(USER_TIME_TOTAL) > 0)',
                                             'DOB'             => '(DOB IS NOT NULL AND LENGTH(DOB) > 0)',
                                             'AGE'             => '(AGE IS NOT NULL AND LENGTH(AGE) > 0)',
                                             'TIMEZONE'        => '(TIMEZONE IS NOT NULL AND LENGTH(TIMEZONE) > 0)');

    $column_null_filter_where_array = array('POST_COUNT'      => '(USER_TRACK.POST_COUNT IS NOT NULL AND USER_TRACK.POST_COUNT > 0)',
                                            'LAST_VISIT'      => '(VISITOR_LOG_TIME.LAST_LOGON IS NOT NULL AND UNIX_TIMESTAMP(VISITOR_LOG_TIME.LAST_LOGON) > 0)',
                                            'REGISTERED'      => '(USER.REGISTERED IS NOT NULL AND UNIX_TIMESTAMP(USER.REGISTERED) > 0)',
                                            'USER_TIME_BEST'  => '(USER_TRACK.USER_TIME_BEST IS NOT NULL AND UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) > 0)',
                                            'USER_TIME_TOTAL' => '(USER_TRACK.USER_TIME_TOTAL IS NOT NULL AND UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) > 0)',
                                            'DOB'             => '(USER_PREFS_DOB.DOB_DISPLAY > 1 AND UNIX_TIMESTAMP(USER_PREFS_DOB.DOB) > 0)',
                                            'AGE'             => '((USER_PREFS_DOB.DOB_DISPLAY = 1 OR USER_PREFS_DOB.DOB_DISPLAY = 2) AND UNIX_TIMESTAMP(USER_PREFS_DOB.DOB) > 0)',
                                            'TIMEZONE'        => '(TIMEZONES.TZID IS NOT NULL AND LENGTH(TIMEZONES.TZID) > 0)');

    // Main query.

    $select_sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP, ";
    $select_sql.= "USER_PEER.PEER_NICKNAME, SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.NAME, SEARCH_ENGINE_BOTS.URL, ";
    $select_sql.= "USER_TRACK.POST_COUNT AS POST_COUNT, DATE_FORMAT(USER_PREFS_DOB.DOB, '0000-%m-%d') AS DOB, ";
    $select_sql.= "DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(USER_PREFS_AGE.DOB, '%Y') - ";
    $select_sql.= "(DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(USER_PREFS_AGE.DOB, '00-%m-%d')) AS AGE, ";
    $select_sql.= "TIMEZONES.TZID AS TIMEZONE, UNIX_TIMESTAMP(NOW()) AS LOCAL_TIME, ";
    $select_sql.= "UNIX_TIMESTAMP(VISITOR_LOG_TIME.LAST_LOGON) AS LAST_VISIT, ";
    $select_sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $select_sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $select_sql.= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, ";
    $select_sql.= "USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
    $select_sql.= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, ";
    $select_sql.= "USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";

    // Include the selected numeric (PIID) profile items

    $profile_query_array = array();

    foreach($profile_items_array as $column => $value) {

        if (is_numeric($column)) {

            $profile_sql = "USER_PROFILE_{$column}.ENTRY AS ENTRY_{$column} ";
            $profile_query_array[] = $profile_sql;
        }
    }

    // From portion which selects users and guests from the VISITOR_LOG table.

    $from_sql = "FROM VISITOR_LOG LEFT JOIN USER ON (USER.UID = VISITOR_LOG.UID) ";

    // Union from portion which flips the from and join so that we get the users
    // who haven't recently logged on to the forum.

    $union_sql = "FROM USER LEFT JOIN VISITOR_LOG ON (VISITOR_LOG.UID = USER.UID) ";

    // Join to get the user's DOB.

    $join_sql = "LEFT JOIN USER_PREFS USER_PREFS_DOB ON (USER_PREFS_DOB.UID = USER.UID ";
    $join_sql.= "AND USER_PREFS_DOB.DOB_DISPLAY > 1 AND USER_PREFS_DOB.DOB > 0) ";

    // Join to check the AGE display.

    $join_sql.= "LEFT JOIN USER_PREFS USER_PREFS_AGE ";
    $join_sql.= "ON (USER_PREFS_AGE.UID = USER.UID AND (USER_PREFS_DOB.DOB_DISPLAY = 1 ";
    $join_sql.= "OR USER_PREFS_DOB.DOB_DISPLAY = 2) AND USER_PREFS_DOB.DOB > 0) ";

    // Joins to check the ANON_LOGON setting.

    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS_FORUM ";
    $join_sql.= "ON (USER_PREFS_FORUM.UID = VISITOR_LOG.UID) ";

    $join_sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $join_sql.= "ON (USER_PREFS_GLOBAL.UID = VISITOR_LOG.UID) ";

    // Join to fetch the LAST_LOGON using the ANON_LOGON data

    $join_sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG_TIME ON (VISITOR_LOG_TIME.UID = VISITOR_LOG.UID ";
    $join_sql.= "AND VISITOR_LOG_TIME.VID = VISITOR_LOG.VID AND ((USER_PREFS_FORUM.ANON_LOGON IS NULL ";
    $join_sql.= "OR USER_PREFS_FORUM.ANON_LOGON = 0) AND (USER_PREFS_GLOBAL.ANON_LOGON IS NULL ";
    $join_sql.= "OR USER_PREFS_GLOBAL.ANON_LOGON = 0))) ";

    // Join for the POST_COUNT.

    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
    $join_sql.= "ON (USER_TRACK.UID = USER.UID) ";

    // Join for user relationship

    $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $join_sql.= "ON (USER_PEER.UID = USER.UID AND USER_PEER.PEER_UID = '$uid') ";

    // Join for the search bot data

    $join_sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = VISITOR_LOG.SID) ";

    // Join for the user timezone

    $join_sql.= "LEFT JOIN TIMEZONES ON (TIMEZONES.TZID = USER_PREFS_GLOBAL.TIMEZONE) ";

    // Joins on the selected numeric (PIID) profile items.

    foreach($profile_items_array as $column => $value) {

        if (is_numeric($column)) {

            $join_sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM_{$column} ";
            $join_sql.= "ON (PROFILE_ITEM_{$column}.PIID = '$column') ";
            $join_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE USER_PROFILE_{$column} ";
            $join_sql.= "ON (USER_PROFILE_{$column}.PIID = PROFILE_ITEM_{$column}.PIID ";
            $join_sql.= "AND USER_PROFILE_{$column}.UID = USER.UID ";
            $join_sql.= "AND (USER_PROFILE_{$column}.PRIVACY = 0 ";
            $join_sql.= "OR (USER_PROFILE_{$column}.PRIVACY = 1 ";
            $join_sql.= "AND (USER_PEER.RELATIONSHIP & $user_friend > 0)))) ";
        }
    }

    // Are we filtering the results by a LOGON / NICKNAME

    $where_query_array = array("VISITOR_LOG.FORUM = '$forum_fid'");

    // Null column filtering

    $where_union_array = array();

    $having_query_array = array();

    $where_count_array = array();

    if (($user_search !== false) && strlen(trim($user_search)) > 0) {

        $user_search = db_escape_string(str_replace('%', '', $user_search));

        $user_search_sql = "(USER.LOGON LIKE '$user_search%' OR ";
        $user_search_sql.= "USER.NICKNAME LIKE '$user_search%' OR ";
        $user_search_sql.= "SEARCH_ENGINE_BOTS.NAME LIKE '$user_search%') ";

        $where_query_array[] = $user_search_sql;
        $where_union_array[] = $user_search_sql;
        $where_count_array[] = $user_search_sql;
    }

    if ($hide_guests === true) {

        $where_query_array[] = "(USER.UID IS NOT NULL AND USER.UID > 0) ";
        $where_union_array[] = "(USER.UID IS NOT NULL AND USER.UID > 0) ";
        $where_count_array[] = "(USER.UID IS NOT NULL AND USER.UID > 0) ";
    }

    if ($hide_empty === true) {

        foreach($profile_items_array as $column => $value) {

            if (is_numeric($column)) {

                $having_query_array[] = "(ENTRY_{$column} IS NOT NULL AND LENGTH(ENTRY_{$column}) > 0) ";
                $where_count_array[]  = "(USER_PROFILE_{$column}.ENTRY IS NOT NULL AND LENGTH(USER_PROFILE_{$column}.ENTRY) > 0)";

            }else {

                $having_query_array[] = $column_null_filter_having_array[$column];
                $where_count_array[]  = $column_null_filter_where_array[$column];
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

    if (sizeof($where_union_array) > 0) {
        $where_union_sql = sprintf("WHERE %s", implode(" AND ", $where_union_array));
    }else {
        $where_union_sql = "";
    }

    // Count queries NULL column filtering

    if (sizeof($where_count_array) > 0) {
        $where_count_sql = sprintf("WHERE %s", implode(" AND ", $where_count_array));
    }else {
        $where_count_sql = "";
    }

    // Sort direction specified?

    $order_sql = is_numeric($sort_by) ? "ORDER BY ENTRY_{$sort_by} $sort_dir " : "ORDER BY $sort_by $sort_dir ";

    // Limit the display to 10 per page.

    $limit_sql = "LIMIT $offset, 10";

    // Default values for the user and visitor counts.

    $user_count = 0;
    $visitor_count = 0;

    // Array to store our results in.

    $user_array = array();

    // Get the number of users in our database matching the criteria

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT $union_sql $join_sql $where_count_sql";

    if (!$result = db_query($sql, $db_visitor_log_browse_items)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    if ($hide_guests !== true) {

        // Get the number of guests in our visitor log matching the criteria

        $sql = "SELECT COUNT(VISITOR_LOG.UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
        $sql.= "LEFT JOIN USER ON (USER.UID = VISITOR_LOG.UID) ";
        $sql.= "$join_sql $where_count_sql AND VISITOR_LOG.UID = 0";

        if (!$result = db_query($sql, $db_visitor_log_browse_items)) return false;

        list ($visitor_count) = db_fetch_array($result, DB_RESULT_NUM);
    }

    if (($user_count + $visitor_count) > 0) {

        // Officially Beehive's first ever UNION - 23rd April 2007

        $sql = implode(",", array_merge(array($select_sql), $profile_query_array));
        $sql.= "$from_sql $join_sql $where_sql $having_sql UNION ";
        $sql.= implode(",", array_merge(array($select_sql), $profile_query_array));
        $sql.= "$union_sql $join_sql $where_union_sql $having_sql $order_sql ";
        $sql.= "$limit_sql";

        if (!$result = db_query($sql, $db_visitor_log_browse_items)) return false;

        if (db_num_rows($result) > 0) {

            while ($user_data = db_fetch_array($result, DB_RESULT_ASSOC)) {

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

                if (isset($user_data['AVATAR_AID_FORUM']) && strlen($user_data['AVATAR_AID_FORUM']) > 0) {
                    $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_FORUM'];
                }elseif (isset($user_data['AVATAR_AID_GLOBAL']) && strlen($user_data['AVATAR_AID_GLOBAL']) > 0) {
                    $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_GLOBAL'];
                }

                if (isset($user_data['LAST_VISIT']) && !is_null($user_data['LAST_VISIT'])) {
                    $user_data['LAST_VISIT'] = format_time($user_data['LAST_VISIT']);
                }else {
                    $user_data['LAST_VISIT'] = $lang['unknown'];
                }

                if (isset($user_data['REGISTERED']) && !is_null($user_data['REGISTERED'])) {
                    $user_data['REGISTERED'] = format_date($user_data['REGISTERED']);
                }else {
                    $user_data['REGISTERED'] = $lang['unknown'];
                }

                if (isset($user_data['USER_TIME_BEST']) && !is_null($user_data['USER_TIME_BEST'])) {
                    $user_data['USER_TIME_BEST'] = format_time_display($user_data['USER_TIME_BEST']);
                }else {
                    $user_data['USER_TIME_BEST'] = $lang['unknown'];
                }

                if (isset($user_data['USER_TIME_TOTAL']) && !is_null($user_data['USER_TIME_TOTAL'])) {
                    $user_data['USER_TIME_TOTAL'] = format_time_display($user_data['USER_TIME_TOTAL']);
                }else {
                    $user_data['USER_TIME_TOTAL'] = $lang['unknown'];
                }

                if (!isset($user_data['AGE']) || is_null($user_data['AGE'])) {
                    $user_data['AGE'] = $lang['unknown'];
                }

                if (isset($user_data['DOB']) && !is_null($user_data['DOB'])) {
                    $user_data['DOB'] = format_birthday($user_data['DOB']);
                }else {
                    $user_data['DOB'] = $lang['unknown'];
                }

                if (isset($user_data['TIMEZONE']) && !is_null($user_data['TIMEZONE'])) {
                    $user_data['TIMEZONE'] = timezone_id_to_string($user_data['TIMEZONE']);
                }else {
                    $user_data['TIMEZONE'] = $lang['unknown'];
                }

                if (!isset($user_data['POST_COUNT']) || is_null($user_data['POST_COUNT'])) {
                    $user_data['POST_COUNT'] = 0;
                }

                $user_array[] = $user_data;
            }

        }else {

            $offset = floor((($user_count + $visitor_count) - 1) / 10) * 10;

            echo "visitor_log_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty, $hide_guests);<br />\n";

            return visitor_log_browse_items($user_search, $profile_items_array, $offset, $sort_by, $sort_dir, $hide_empty, $hide_guests);
        }
    }

    return array('user_count' => ($user_count + $visitor_count),
                 'user_array' => $user_array);
}

function visitor_log_clean_up()
{
    $db_visitor_log_clean_up = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $visitor_log_clean_up_prob = intval(forum_get_setting('forum_self_clean_prob', false, 10000));

    if ($visitor_log_clean_up_prob < 1) $visitor_log_clean_up_prob = 1;
    if ($visitor_log_clean_up_prob > 10000) $visitor_log_clean_up_prob = 10000;

    if (($mt_result = mt_rand(1, $visitor_log_clean_up_prob)) == 1) {

        // Keep visitor log for 7 days.

        $visitor_cutoff_stamp = DAY_IN_SECONDS * 7;

        $sql = "DELETE FROM VISITOR_LOG WHERE FORUM = '$forum_fid' ";
        $sql.= "AND LAST_LOGON < FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()) ";
        $sql.= "- $visitor_cutoff_stamp)";

        $result = db_query($sql, $db_visitor_log_clean_up);

        return true;
    }

    return false;
}

?>