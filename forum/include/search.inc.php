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

/* $Id: search.inc.php,v 1.36 2003-09-30 21:05:12 decoyduck Exp $ */

require_once("./include/form.inc.php");
require_once("./include/format.inc.php");
require_once("./include/user.inc.php");
require_once("./include/config.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");

function search_execute($argarray, &$urlquery, &$error)
{
    global $search_min_word_length;

    $db_search_execute = db_connect();

    $searchsql = "SELECT THREAD.FID, THREAD.TID, THREAD.TITLE, POST.TID, POST.PID, POST.FROM_UID, POST.TO_UID, ";
    $searchsql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST_CONTENT.CONTENT ";
    $searchsql.= "FROM ". forum_table("THREAD"). " THREAD ";
    $searchsql.= "LEFT JOIN ". forum_table("POST"). " POST ON (THREAD.TID = POST.TID) ";
    $searchsql.= "LEFT JOIN ". forum_table("POST_CONTENT"). " POST_CONTENT ON (POST.PID = POST_CONTENT.PID AND POST.TID = POST_CONTENT.TID) ";
    $searchsql.= "WHERE ";

    if ($argarray['fid'] > 0) {
        $folders = "THREAD.FID = ". $argarray['fid'];
    }else{
        $folders = "THREAD.FID in (". threads_get_available_folders(). ")";
    }

    // Default to 3 for minimum word length

    if (!isset($search_min_word_length)) {
        $search_min_word_length = 3;
    }

    $daterange = search_date_range($argarray['date_from'], $argarray['date_to']);
    $fromtouser = "";

    if (!isset($argarray['me_only'])) {
        $argarray['me_only'] = "N";
    }

    if (empty($argarray['to_other']) && $argarray['to_uid'] > 0) {
        $fromtouser = "AND POST.TO_UID = ". $argarray['to_uid'];
    }elseif (!empty($argarray['to_other'])) {
        $touid = user_get_uid($argarray['to_other']);
        if ($touid['UID'] > -1) {
            $fromtouser = "AND POST.TO_UID = ". $touid['UID'];
        }else {
            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }
    }

    if (empty($argarray['from_other']) && $argarray['from_uid'] > 0) {
        $fromtouser.= " AND POST.FROM_UID = ". $argarray['from_uid'];
    }elseif (!empty($argarray['from_other'])) {
        $fromuid = user_get_uid($argarray['from_other']);
        if ($fromuid['UID'] > -1) {
            $fromtouser.= " AND POST.FROM_UID = ". $fromuid['UID'];
        }else {
            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }
    }

    if (strlen(trim($argarray['search_string'])) > 0) {

        if ($argarray['method'] == 1) { // AND

            $keywords = explode(' ', trim($argarray['search_string']));

            $threadtitle = "";
            foreach($keywords as $word) {
                if (strlen($word) >= $search_min_word_length) {
                    $threadtitle.= "THREAD.TITLE LIKE '%". addslashes($word). "%' AND ";
                }
            }

            $postcontent = "";
            foreach($keywords as $word) {
                if (strlen($word) >= $search_min_word_length) {
                    $postcontent.= "POST_CONTENT.CONTENT LIKE '%". addslashes($word). "%' AND ";
                }
            }

            $threadtitle = trim(substr($threadtitle, 0, -5));
            $postcontent = trim(substr($postcontent, 0, -5));

            if ((strlen($threadtitle) > 0) && (strlen($postcontent) > 0)) {

                if (isset($argarray['me_only']) && $argarray['me_only'] == 'Y') {

                    $searchsql.= $folders. " AND (";

                    if (strlen($threadtitle) > 0) $searchsql.= $threadtitle. " AND ";
                    $searchsql.= "(POST.TO_UID = ". bh_session_get_value('UID'). " OR POST.FROM_UID = ".  bh_session_get_value('UID'). ")". $daterange. ") OR (";

                    if (strlen($postcontent) > 0) $searchsql.= $postcontent. " AND ";
                    $searchsql.= "(POST.TO_UID = ". bh_session_get_value('UID'). " OR POST.FROM_UID = ". bh_session_get_value('UID'). ")". $daterange. ")";

                }else {

                    $searchsql.= "(". $folders;
                    if (strlen($threadtitle) > 0) $searchsql.= " AND ". $threadtitle;
                    $searchsql.= $daterange. $fromtouser. ") ";

                    $searchsql.= "OR (". $folders;
                    if (strlen($postcontent) > 0) $searchsql.= " AND ". $postcontent;
                    $searchsql.= $daterange. $fromtouser. ") ";

                }

            }else {

                $error = SEARCH_NO_KEYWORDS;
                return false;

            }

        }elseif ($argarray['method'] == 2) { // OR

            $keywords = explode(' ', trim($argarray['search_string']));

            $threadtitle = "";
            foreach($keywords as $word) {
                if (strlen($word) >= $search_min_word_length) {
                    $threadtitle.= "THREAD.TITLE LIKE '%". addslashes($word). "%' OR ";
                }
            }

            $postcontent = "";
            foreach($keywords as $word) {
                if (strlen($word) >= $search_min_word_length) {
                    $postcontent.= "POST_CONTENT.CONTENT LIKE '%". addslashes($word). "%' OR ";
                }
            }

            $threadtitle = substr($threadtitle, 0, -4);
            $postcontent = substr($postcontent, 0, -4);

            if ((strlen($threadtitle) > 0) && (strlen($postcontent) > 0)) {

                if ($argarray['me_only'] == 'Y') {

                    $searchsql.= $folders. " AND (";

                    if (strlen($threadtitle) > 0) $searchsql.= $threadtitle. " AND ";
                    $searchsql.= "(POST.TO_UID = ". bh_session_get_value('UID'). " OR POST.FROM_UID = ". bh_session_get_value('UID'). ")". $daterange. ") OR (";

                    if (strlen($postcontent) > 0) $searchsql.= $postcontent. " AND ";
                    $searchsql.= "(POST.TO_UID = ". bh_session_get_value('UID'). " OR POST.FROM_UID = ". bh_session_get_value('UID'). ")". $daterange. ")";

                }else {

                    $searchsql.= "(". $folders;
                    if (strlen($threadtitle) > 0) $searchsql.= " AND ". $threadtitle;
                    $searchsql.= $daterange. $fromtouser. ")";

                    $searchsql.= " OR (". $folders;
                    if (strlen($postcontent) > 0) $searchsql.= " AND ". $postcontent;
                    $searchsql.= $daterange. $fromtouser. ")";

                }

            }else {

                $error = SEARCH_NO_KEYWORDS;
                return false;

            }

        }elseif ($argarray['method'] == 3) { // EXACT

            $searchsql.= $folders. " AND INSTR(THREAD.TITLE, ' ". addslashes(trim($argarray['search_string'])). " ')";
            $searchsql.= " OR INSTR(POST_CONTENT.CONTENT, ' ". addslashes(trim($argarray['search_string'])). " ')";
            $searchsql.= $daterange;

            if ($argarray['me_only'] == 'Y') {

                $searchsql.= " AND (POST.TO_UID = ". bh_session_get_value('UID');
                $searchsql.= " OR POST.FROM_UID = ". bh_session_get_value('UID'). ")";

            }else {

                $searchsql.= $fromtouser;

            }

        }

    }else {

        $error = SEARCH_NO_KEYWORDS;
        return false;

    }

    if (isset($argarray['group_by_thread']) && $argarray['group_by_thread'] == 'Y') {
        $searchsql.= " GROUP BY THREAD.TID";
    }

    if ($argarray['order_by'] == 2) {
        $searchsql.= " ORDER BY POST.CREATED DESC";
    }elseif($argarray['order_by'] == 3) {
        $searchsql.= " ORDER BY POST.CREATED";
    }

    $searchsql.= " LIMIT ". $argarray['sstart']. ", 50";

    $result = db_query($searchsql, $db_search_execute);

    $urlquery = "&fid=". $argarray['fid']. "&date_from=". $argarray['date_from']. "&date_to=". $argarray['date_to'];
    $urlquery.= "&search_string=". rawurlencode(trim($argarray['search_string'])). "&method=". $argarray['method']. "&me_only=". $argarray['me_only'];
    $urlquery.= "&to_other=". $argarray['to_other']. "&to_uid=". $argarray['to_uid']. "&from_other=". $argarray['from_other'];
    $urlquery.= "&from_uid=". $argarray['from_uid']. "&order_by=". $argarray['order_by'];

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
    global $lang;

    $db_folder_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    $sql = "select DISTINCT F.FID, F.TITLE from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = '$uid') ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";

    $result = db_query($sql, $db_folder_search_dropdown);

    $fids[] = 0;
    $titles[] = $lang['all_caps'];

    while($row = db_fetch_array($result)) {

      $fids[]   = $row['FID'];
      $titles[] = $row['TITLE'];

    }

    return form_dropdown_array("fid", $fids, $titles, 0);

}

function search_draw_user_dropdown($name)
{
    global $lang;

    $db_search_draw_user_dropdown = db_connect();
    $uid = bh_session_get_value('UID');

    $sql = "SELECT U.UID, U.LOGON, U.NICKNAME, UNIX_TIMESTAMP(U.LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM ".forum_table("USER")." U WHERE (U.LOGON <> 'GUEST' AND U.PASSWD <> MD5('GUEST')) ";
    $sql.= "AND U.UID <> $uid ORDER BY U.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    $result = db_query($sql, $db_search_draw_user_dropdown);

    $uids[]  = 0;
    $names[] = $lang['all_caps'];

    if (bh_session_get_value('UID') > 0) {

      $uids[]  = bh_session_get_value('UID');
      $names[] = $lang['me_caps'];

    }

    while($row = db_fetch_array($result)) {

      $uids[]  = $row['UID'];
      $names[] = format_user_name($row['LOGON'], $row['NICKNAME']);

    }

    return form_dropdown_array($name, $uids, $names, 0);

}

?>