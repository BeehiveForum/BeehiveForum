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

/* $Id: search.inc.php,v 1.61 2004-04-30 21:10:50 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");

function search_execute($argarray, &$urlquery, &$error)
{
    // Ensure the bare minimum of variables are set

    if (!isset($argarray['method'])) $argarray['method'] = 1;
    if (!isset($argarray['date_from'])) $argarray['date_from'] = 7;
    if (!isset($argarray['date_to'])) $argarray['date_to'] = 2;
    if (!isset($argarray['order_by'])) $argarray['order_by'] = 1;
    if (!isset($argarray['sstart'])) $argarray['sstart'] = 0;
    if (!isset($argarray['fid'])) $argarray['fid'] = 0;
    if (!isset($argarray['to_other'])) $argarray['to_other'] = "";
    if (!isset($argarray['from_other'])) $argarray['from_other'] = "";
    if (!isset($argarray['to_uid'])) $argarray['to_uid'] = 0;
    if (!isset($argarray['from_uid'])) $argarray['from_uid'] = 0;
    if (!isset($argarray['me_only'])) $argarray['me_only'] = "N";
    if (!isset($argarray['include'])) $argarray['include'] = 2;

    $db_search_execute = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    $search_sql = "SELECT THREAD.FID, THREAD.TID, THREAD.TITLE, POST.TID, POST.PID, ";
    $search_sql.= "POST.FROM_UID, POST.TO_UID, UNIX_TIMESTAMP(POST.CREATED) AS CREATED ";
    $search_sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ";
    $search_sql.= "ON (THREAD.TID = POST.TID) ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}POST_CONTENT POST_CONTENT ";
    $search_sql.= "ON (POST.PID = POST_CONTENT.PID AND POST.TID = POST_CONTENT.TID) ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS POST_ATTACHMENT_IDS ";
    $search_sql.= "ON (POST_ATTACHMENT_IDS.TID = POST.TID AND POST_ATTACHMENT_IDS.PID = POST.PID) ";
    $search_sql.= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_FILES POST_ATTACHMENT_FILES ";
    $search_sql.= "ON (POST_ATTACHMENT_FILES.AID = POST_ATTACHMENT_IDS.AID) ";
    $search_sql.= "WHERE ";

    if (isset($argarray['fid']) && $argarray['fid'] > 0) {
        $folder_sql = "THREAD.FID = {$argarray['fid']}";
    }else{
        $folders = threads_get_available_folders();
        $folder_sql = "THREAD.FID in ($folders)";
    }

    $date_range_sql = search_date_range($argarray['date_from'], $argarray['date_to']);

    if (isset($argarray['to_other']) && strlen(trim($argarray['to_other'])) > 0) {
        if ($to_uid = user_get_uid($argarray['to_other'])) {
            $from_to_user_sql = "AND POST.TO_UID = '{$to_uid['UID']}'";
        }else {
            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }
    }elseif (isset($argarray['to_uid']) && is_numeric($argarray['to_uid']) && $argarray['to_uid'] > 0) {
        $from_to_user_sql = "AND POST.TO_UID = {$argarray['to_uid']}";
    }else {
        $from_to_user_sql = "";
    }

    if (isset($argarray['from_other']) && strlen(trim($argarray['from_other'])) > 0) {
        if ($from_uid = user_get_uid($argarray['from_other'])) {
            $from_to_user_sql.= " AND POST.FROM_UID = '{$from_uid['UID']}'";
        }else {
            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }
    }elseif (isset($argarray['from_uid']) && is_numeric($argarray['from_uid']) && $argarray['from_uid'] > 0) {
        $from_to_user_sql.= " AND POST.FROM_UID = {$argarray['from_uid']}";
    }

    if (strlen(trim($argarray['search_string'])) > 0) {

        $thread_title_sql = false;
        $post_content_sql = false;
        $attach_files_sql = false;

        if ($argarray['method'] == 1) { // AND

            $keywords_array = explode(' ', trim($argarray['search_string']));

            foreach ($keywords_array as $key => $value) {
                if (strlen($value) < intval(forum_get_setting('search_min_word_length', false, 3))) {
                    unset($keywords_array[$key]);
                }
            }

            if (sizeof($keywords_array) > 0) {

                $keyword_search_sql = "";

                if ($argarray['include'] > 0) {

                    $thread_title_sql = "THREAD.TITLE LIKE '%";
                    $thread_title_sql.= implode("%' AND THREAD.TITLE LIKE '%", $keywords_array);
                    $thread_title_sql.= "%'";
                }

                if ($argarray['include'] > 1) {

                    $post_content_sql = "POST_CONTENT.CONTENT LIKE '%";
                    $post_content_sql.= implode("%' AND POST_CONTENT.CONTENT LIKE '%", $keywords_array);
                    $post_content_sql.= "%'";
                }

                if ($argarray['include'] > 2) {

                    $attach_files_sql = "POST_ATTACHMENT_FILES.FILENAME LIKE '%";
                    $attach_files_sql.= implode("%' AND POST_ATTACHMENT_FILES.FILENAME LIKE '%", $keywords_array);
                    $attach_files_sql.= "%'";
                }
            }

        }elseif ($argarray['method'] == 2) { // OR

            $keywords_array = explode(' ', trim($argarray['search_string']));

            foreach ($keywords_array as $key => $value) {
                if (strlen($value) < intval(forum_get_setting('search_min_word_length', false, 3))) {
                    unset($keywords_array[$key]);
                }
            }

            if (sizeof($keywords_array) > 0) {

                $keyword_search_sql = "";

                if ($argarray['include'] > 0) {

                    $thread_title_sql = "THREAD.TITLE LIKE '%";
                    $thread_title_sql.= implode("%' OR THREAD.TITLE LIKE '%", $keywords_array);
                    $thread_title_sql.= "%'";
                }

                if ($argarray['include'] > 1) {

                    $post_content_sql = "POST_CONTENT.CONTENT LIKE '%";
                    $post_content_sql.= implode("%' OR POST_CONTENT.CONTENT LIKE '%", $keywords_array);
                    $post_content_sql.= "%'";
                }

                if ($argarray['include'] > 2) {

                    $attach_files_sql = "POST_ATTACHMENT_FILES.FILENAME LIKE '%";
                    $attach_files_sql.= implode("%' OR POST_ATTACHMENT_FILES.FILENAME LIKE '%", $keywords_array);
                    $attach_files_sql.= "%'";
                }
            }

        }elseif ($argarray['method'] == 3) { // EXACT

            $words = addslashes(trim($argarray['search_string']));

            if ($argarray['include'] > 0) {
                $thread_title_sql.= "(INSTR(THREAD.TITLE, ' {$words} ') ";
            }

            if ($argarray['include'] > 1) {
                $post_content_sql = "INSTR(POST_CONTENT.CONTENT, ' {$words} ') ";
            }

            if ($argarray['include'] > 2) {
                $attach_files_sql = "INSTR(POST_ATTACHMENT_FILES.FILENAME, ' {$words} ')";
            }
        }

        if ($argarray['me_only'] == 'Y') {

            $keyword_search_sql.= "{$folder_sql} AND (";

            if ($thread_title_sql) {
                $keyword_search_sql.= "(({$thread_title_sql}) AND (POST.TO_UID = '$uid' OR POST.FROM_UID = '$uid') {$date_range_sql}) ";
            }

            if ($post_content_sql) {
                if ($thread_title_sql) {
                    $keyword_search_sql.= "OR (({$post_content_sql}) AND (POST.TO_UID = '$uid' OR POST.FROM_UID = '$uid') {$date_range_sql}) ";
                }else {
                    $keyword_search_sql.= "(({$post_content_sql}) AND (POST.TO_UID = '$uid' OR POST.FROM_UID = '$uid') {$date_range_sql}) ";
                }
            }

            if ($attach_files_sql) {
                if ($thread_title_sql || $post_content_sql) {
                    $keyword_search_sql.= "OR (({$attach_files_sql}) AND (POST.TO_UID = '$uid' OR POST.FROM_UID = '$uid') {$date_range_sql}) ";
                }else {
                    $keyword_search_sql.= "(({$attach_files_sql}) AND (POST.TO_UID = '$uid' OR POST.FROM_UID = '$uid') {$date_range_sql}) ";
                }
            }

            $keyword_search_sql.= ") ";

        }else {

            $keyword_search_sql.= "{$folder_sql} AND (";

            if ($thread_title_sql) {
                $keyword_search_sql.= "(({$thread_title_sql}) {$date_range_sql} {$from_to_user_sql}) ";
            }

            if ($post_content_sql) {
                if ($thread_title_sql) {
                    $keyword_search_sql.= "OR (({$post_content_sql}) {$date_range_sql} {$from_to_user_sql}) ";
                }else {
                    $keyword_search_sql.= "(({$post_content_sql}) {$date_range_sql} {$from_to_user_sql}) ";
                }
            }

            if ($attach_files_sql) {
                if ($thread_title_sql || $post_content_sql) {
                    $keyword_search_sql.= "OR (({$attach_files_sql}) {$date_range_sql} {$from_to_user_sql}) ";
                }else {
                    $keyword_search_sql.= "(({$attach_files_sql}) {$date_range_sql} {$from_to_user_sql}) ";
                }
            }

            $keyword_search_sql.= ") ";
        }

    }elseif (strlen(trim($from_to_user_sql)) > 0) {

        $keyword_search_sql = "{$folder_sql} {$date_range_sql} {$from_to_user_sql}";
    }

    if (isset($keyword_search_sql) && strlen(trim($keyword_search_sql)) > 0) {

        $search_sql = "{$search_sql}{$keyword_search_sql}";

        if (isset($argarray['group_by_thread']) && $argarray['group_by_thread'] == 'Y') {
            $search_sql.= " GROUP BY THREAD.TID";
        }

        if ($argarray['order_by'] == 2) {
            $search_sql.= " ORDER BY POST.CREATED DESC";
        }elseif($argarray['order_by'] == 3) {
            $search_sql.= " ORDER BY POST.CREATED";
        }

        $search_sql.= " LIMIT ". $argarray['sstart']. ", 50";
        $search_sql = preg_replace("/ +/", " ", $search_sql);

        $result = db_query($search_sql, $db_search_execute);

        $urlquery = "&amp;fid=". $argarray['fid']. "&amp;date_from=". $argarray['date_from']. "&amp;date_to=". $argarray['date_to'];
        $urlquery.= "&amp;search_string=". rawurlencode(trim($argarray['search_string'])). "&amp;method=". $argarray['method']. "&amp;me_only=". $argarray['me_only'];
        $urlquery.= "&amp;to_other=". $argarray['to_other']. "&amp;to_uid=". $argarray['to_uid']. "&amp;from_other=". $argarray['from_other'];
        $urlquery.= "&amp;from_uid=". $argarray['from_uid']. "&amp;order_by=". $argarray['order_by'];

        if (db_num_rows($result)) {
            $search_results_array = array();
            while ($row = db_fetch_array($result)) {
                $search_results_array[] = $row;
            }
            return $search_results_array;
        }else {
            $error = SEARCH_NO_MATCHES;
            return false;
        }

    }else {

        $error = SEARCH_NO_KEYWORDS;
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

    if (isset($from_timestamp)) $range = " AND POST.CREATED >= FROM_UNIXTIME($from_timestamp)";
    if (isset($to_timestamp)) $range.= " AND POST.CREATED <= FROM_UNIXTIME($to_timestamp)";

    return $range;

}

function folder_search_dropdown()
{
    $lang = load_language_file();

    $db_folder_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT DISTINCT F.FID, F.TITLE FROM {$table_data['PREFIX']}FOLDER F LEFT JOIN ";
    $sql.= "{$table_data['PREFIX']}USER_FOLDER UF ON (UF.FID = F.FID AND UF.UID = '$uid') ";
    $sql.= "WHERE (F.ACCESS_LEVEL = 0 OR (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";

    $result = db_query($sql, $db_folder_search_dropdown);

    $fids[] = 0;
    $titles[] = $lang['all_caps'];

    while($row = db_fetch_array($result)) {

      $fids[]   = $row['FID'];
      $titles[] = $row['TITLE'];

    }

    return form_dropdown_array("fid", $fids, $titles, 0, "style=\"width: 175px\"");
}

function search_draw_user_dropdown($name)
{
    $lang = load_language_file();

    $db_search_draw_user_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
    $sql.= "LEFT JOIN VISITOR_LOG VISITOR_LOG ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "WHERE USER.UID <> '$uid' ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
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

    return form_dropdown_array($name, $uids, $names, 0, "style=\"width: 175px\"");
}

?>