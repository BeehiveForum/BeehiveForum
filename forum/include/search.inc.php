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

/* $Id: search.inc.php,v 1.89 2005-03-07 21:32:40 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/user.inc.php");

function search_execute($argarray, &$urlquery, &$error)
{
    // MySQL has a list of stop words for fulltext searches.
    // We'll save ourselves some server time by checking
    // them first.

    include("./include/search_stopwords.inc.php");

    // Ensure the bare minimum of variables are set

    if (!isset($argarray['method'])) $argarray['method'] = 1;
    if (!isset($argarray['date_from'])) $argarray['date_from'] = 7;
    if (!isset($argarray['date_to'])) $argarray['date_to'] = 2;
    if (!isset($argarray['order_by'])) $argarray['order_by'] = 1;
    if (!isset($argarray['group_by_thread'])) $argarray['group_by_thread'] = "N";
    if (!isset($argarray['sstart'])) $argarray['sstart'] = 0;
    if (!isset($argarray['fid'])) $argarray['fid'] = 0;
    if (!isset($argarray['me_only'])) $argarray['me_only'] = "N";
    if (!isset($argarray['include'])) $argarray['include'] = 2;
    if (!isset($argarray['username'])) $argarray['username'] = "";
    if (!isset($argarray['user_include'])) $argarray['user_include'] = 1;

    $search_min_word_length = intval(forum_get_setting('search_min_word_length', false, 3));

    $db_search_execute = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    $search_sql = "SELECT THREAD.FID, THREAD.TITLE, POST.TID, POST.PID, ";
    $search_sql.= "POST.FROM_UID, POST.TO_UID, UNIX_TIMESTAMP(POST.CREATED) AS CREATED ";
    $search_sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ON ";
    $search_sql.= "(USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = THREAD.BY_UID) ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (THREAD.TID = POST.TID) ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}SEARCH_KEYWORDS SEARCH_KEYWORDS ";
    $search_sql.= "ON (SEARCH_KEYWORDS.TID = POST.TID AND SEARCH_KEYWORDS.PID = POST.PID) ";
    $search_sql.= "WHERE ((USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. ") = 0 ";
    $search_sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $search_sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED. ") = 0 ";
    $search_sql.= "OR USER_PEER.RELATIONSHIP IS NULL OR THREAD.LENGTH > 1) ";

    if (isset($argarray['fid']) && $argarray['fid'] > 0) {
        $search_sql.= "AND THREAD.FID = {$argarray['fid']} ";
    }else{
        $folders = folder_get_available();
        $search_sql.= "AND THREAD.FID in ($folders) ";
    }

    $search_sql.= search_date_range($argarray['date_from'], $argarray['date_to']);

    if (isset($argarray['username']) && strlen(trim($argarray['username'])) > 0) {

        if ($user_uid = user_get_uid($argarray['username'])) {

            if ($argarray['user_include'] == 1) {

                $search_sql.= "AND POST.FROM_UID = '{$user_uid['UID']}'";

            }elseif ($argarray['user_include'] == 2) {

                $search_sql.= "AND POST.TO_UID = '{$user_uid['UID']}'";

            }else {

                $search_sql.= "AND (POST.FROM_UID = '{$user_uid['UID']}' ";
                $search_sql.= "OR POST.TO_UID = '{$user_uid['UID']}')";
            }

        }else {

            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }

    }elseif ($argarray['me_only'] == 'Y') {

        $keyword_search_sql.= "AND (POST.TO_UID = '$uid' OR POST.FROM_UID = '$uid') ";
    }

    if (strlen(trim($argarray['search_string'])) > 0) {

        // Filter the input so the user can't do anything dangerous with it

        $argarray['search_string'] = str_replace("%", "", $argarray['search_string']);
        $argarray['search_string'] = _htmlentities($argarray['search_string']);

        // Remove any keywords which are under the minimum length.

        $keywords_array = explode(' ', trim($argarray['search_string']));

        foreach ($keywords_array as $key => $value) {

            if (strlen($value) < $search_min_word_length || strlen($value) > 64 || _in_array($value, $mysql_fulltext_stopwords)) {
                unset($keywords_array[$key]);
            }
        }

        if (sizeof($keywords_array) > 0) {

            if ($argarray['method'] == 1) { // AND

                $search_sql.= "AND (SEARCH_KEYWORDS.KEYWORD LIKE '%";
                $search_sql.= implode("%' AND SEARCH_KEYWORDS.KEYWORD LIKE '%", $keywords_array);
                $search_sql.= "%') ";

            }elseif ($argarray['method'] == 2) { // OR

                $search_sql.= "AND (SEARCH_KEYWORDS.KEYWORD LIKE '%";
                $search_sql.= implode("%' OR SEARCH_KEYWORDS.KEYWORD LIKE '%", $keywords_array);
                $search_sql.= "%') ";
            }
        }

    }else {

        if (!isset($argarray['username']) || strlen(trim($argarray['username'])) < 1) {

            $error = SEARCH_NO_KEYWORDS;
            return false;
        }
    }

    if (isset($argarray['group_by_thread']) && $argarray['group_by_thread'] == 'Y') {
        $search_sql.= " GROUP BY THREAD.TID, POST.PID";
    }else {
        $search_sql.= " GROUP BY POST.PID";
    }

    if ($argarray['order_by'] == 2) {
        $search_sql.= " ORDER BY POST.CREATED DESC";
    }elseif($argarray['order_by'] == 3) {
        $search_sql.= " ORDER BY POST.CREATED";
    }

    $search_sql.= " LIMIT ". $argarray['sstart']. ", 50";
    $search_sql = preg_replace("/ +/", " ", $search_sql);

    $result = db_query($search_sql, $db_search_execute);

    $urlquery = "&amp;fid={$argarray['fid']}&amp;date_from={$argarray['date_from']}";
    $urlquery.= "&amp;date_to={$argarray['date_to']}&amp;search_string=". rawurlencode(trim($argarray['search_string']));
    $urlquery.= "&amp;method={$argarray['method']}&amp;me_only={$argarray['me_only']}";
    $urlquery.= "&amp;username={$argarray['username']}&amp;user_include={$argarray['user_include']}";
    $urlquery.= "&amp;order_by={$argarray['order_by']}&amp;group_by_thread={$argarray['group_by_thread']}";

    if (db_num_rows($result) > 0) {

        $search_results_array = array();

        while ($row = db_fetch_array($result)) {

            $search_results_array[] = $row;
        }

        return $search_results_array;

    }else {

        $error = SEARCH_NO_MATCHES;
        return false;
    }
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

function folder_search_dropdown()
{
    $lang = load_language_file();

    $db_folder_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return "";

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

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}VISITOR_LOG VISITOR_LOG ON ";
    $sql.= "(USER.UID = VISITOR_LOG.UID) WHERE USER.UID <> '$uid' ";
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

function search_index_post()
{
    $db_search_index_post = db_connect();

    include("./include/search_stopwords.inc.php");

    if (!$table_data = get_table_prefix()) return false;

    $search_min_word_length = intval(forum_get_setting('search_min_word_length', false, 3));

    $sql = "SELECT TID, PID, CONTENT FROM {$table_data['PREFIX']}POST_CONTENT ";
    $sql.= "WHERE INDEXED = 0 ORDER BY TID, PID LIMIT 0, 1";

    $result = db_query($sql, $db_search_index_post);

    if (db_num_rows($result) > 0) {

        list($tid, $pid, $content) = db_fetch_array($result, DB_RESULT_NUM);

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST_CONTENT SET INDEXED = 1 ";
        $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

        $result = db_query($sql, $db_search_index_post);

        $content_array = explode(" ", $content);

        foreach ($content_array as $key => $value) {

            if (strlen($value) < $search_min_word_length || strlen($value) > 64 || _in_array($value, $mysql_fulltext_stopwords)) {

                unset($content_array[$key]);

            }else {

                $value = strtolower($value);
                $content_array[$key] = "('$tid', '$pid', '$value')";
            }
        }

        $sql_values = implode(",\n", $content_array);

        $sql = "INSERT INTO {$table_data['PREFIX']}SEARCH_KEYWORDS ";
        $sql.= "(TID, PID, KEYWORD) VALUES $sql_values ";

        $result = db_query($sql, $db_search_index_post);
    }
}

?>