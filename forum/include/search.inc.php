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

require_once("./include/form.inc.php");
require_once("./include/format.inc.php");
require_once("./include/user.inc.php");

function search_construct_query($argarray, &$searchsql, &$urlquery)
{

  global $HTTP_COOKIE_VARS;

  if ($argarray['fid'] > 0) {
      $folders = "THREAD.FID = ". $argarray['fid'];
  }else{
      $folders = "THREAD.FID in (". threads_get_available_folders(). ")";
  }
  
  $daterange = search_date_range($argarray['date_from'], $argarray['date_to']);
  $fromtouser = "";
  
    if(!isset($argarray['me_only'])){
        $argarray['me_only'] = "N";
    }

  if (empty($argarray['to_other']) && $argarray['to_uid'] > 0) {
      $fromtouser = "AND POST.TO_UID = ". $argarray['to_uid'];
  }elseif (!empty($argarray['to_other'])) {
      $touid = user_get_uid($argarray['to_other']);
      if ($touid > -1) $fromtouser = "AND POST.TO_UID = ". $touid;
  }

  if (empty($argarray['from_other']) && $argarray['from_uid'] > 0) {
    $fromtouser.= " AND POST.FROM_UID = ". $argarray['from_uid'];
  }elseif (!empty($argarray['from_other'])) {
    $fromuid = user_get_uid($argarray['from_other']);
    if ($fromuid > -1) $fromtouser.= " AND POST.FROM_UID = ". $fromuid;
  }

  if (!empty($argarray['search_string'])) {

    if ($argarray['method'] == 1) { // AND

      $keywords = explode(' ', $argarray['search_string']);

      $threadtitle = "";
      foreach($keywords as $word) {
          $threadtitle.= "THREAD.TITLE LIKE '%$word%' AND ";
      }

      $postcontent = "";
      foreach($keywords as $word) {
        $postcontent.= "POST_CONTENT.CONTENT LIKE '%$word%' AND ";
      }

      $threadtitle = substr($threadtitle, 0, -5);
      $postcontent = substr($postcontent, 0, -5);

      if (@$argarray['me_only'] == 'Y') {

        $searchsql.= " (". $folders. " AND ". $threadtitle. " AND (POST.TO_UID = ".
        $HTTP_COOKIE_VARS['bh_sess_uid']. " OR POST.FROM_UID = ".
        $HTTP_COOKIE_VARS['bh_sess_uid']. ") ". $daterange. ") OR (". $postcontent.
        " AND (POST.TO_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'].
        " OR POST.FROM_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid']. ") ". $daterange. ") ";
        
      }else {
      
        $searchsql.= " (". $folders. " AND ". $threadtitle. " ". $daterange. " ". $fromtouser. ")";
        $searchsql.= " OR (". $folders. " AND ". $postcontent. " ". $daterange. " ". $fromtouser. ") ";
        
      }
      
    }elseif ($argarray['method'] == 2) { // OR
  
      $keywords = explode(' ', $argarray['search_string']);
      
      foreach($keywords as $word) {
        $threadtitle.= "THREAD.TITLE LIKE '%$word%' OR ";
      }
      
      foreach($keywords as $word) {
        $postcontent.= "POST_CONTENT.CONTENT LIKE '%$word%' OR ";
      }
      
      $threadtitle = substr($threadtitle, 0, -4);
      $postcontent = substr($postcontent, 0, -4);
      
      if ($argarray['me_only'] == 'Y') {
      
        $searchsql = " (". $folders. " AND ". $threadtitle. " AND (POST.TO_UID = ".
        $HTTP_COOKIE_VARS['bh_sess_uid']. " OR POST.FROM_UID = ".
        $HTTP_COOKIE_VARS['bh_sess_uid']. ") ". $daterange. ") OR (". $postcontent.
        " AND (POST.TO_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'].
        " OR POST.FROM_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid']. ") ". $daterange. ") ";
        
      }else {
      
        $searchsql.= " (". $folders. " AND ". $threadtitle. " ". $daterange. " ". $fromtouser. ")";
        $searchsql.= " OR (". $folders. " AND ". $postcontent. " ". $daterange. " ". $fromtouser. ") ";
        
      }
    
    }elseif ($argarray['method'] == 3) { // EXACT
  
      $searchsql.= $folders. " AND (THREAD.TITLE LIKE '%". $argarray['search_string']. "%' ";
      $searchsql.= "OR POST_CONTENT.CONTENT LIKE '%". $argarray['search_string']. "%') ";
      $searchsql.= $daterange;
      
      if ($argarray['me_only'] == 'Y') {
      
        $searchsql.= " AND (POST.TO_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
        $searchsql.= " OR POST.FROM_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid']. ")";
        
      }else {
      
        $searchsql.= $fromtouser;
        
      }      

    }
    
  }else {
  
    if ($argarray['me_only'] == 'Y') {
     
      $searchsql.= $folders. " AND (POST.TO_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
      $searchsql.= " OR POST.FROM_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid']. ")";
      $searchsql.= " ". $daterange;
      
    }else {
    
      $searchsql.= $folders. " ". $fromtouser. " ". $daterange;
      
    }
    
  }
  
  if ($argarray['order_by'] == 2) {
    $searchsql.= " ORDER BY POST.CREATED DESC";
  }elseif($argarray['order_by'] == 3) {
    $searchsql.= " ORDER BY POST.CREATED";
  }
  
  $urlquery = "&fid=". $argarray['fid']. "&date_from=". $argarray['date_from']. "&date_to=". $argarray['date_to'];
  $urlquery.= "&search_string=". rawurlencode($argarray['search_string']). "&method=". $argarray['method']. "&me_only=". $argarray['me_only'];
  $urlquery.= "&to_other=". $argarray['to_other']. "&to_uid=". $argarray['to_uid']. "&from_other=". $argarray['from_other'];
  $urlquery.= "&from_uid=". $argarray['from_uid']. "&order_by=". $argarray['order_by'];
 
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
    
    if (isset($from_timestamp)) $range = "AND POST.CREATED >= FROM_UNIXTIME($from_timestamp)";
    if (isset($to_timestamp)) $range.= " AND POST.CREATED <= FROM_UNIXTIME($to_timestamp)";
    
    return $range;
    
}

function folder_search_dropdown()
{

    $db_folder_search_dropdown = db_connect();
    
    $sql = "select FID, TITLE from " . forum_table("FOLDER");
    $result = db_query($sql, $db_folder_search_dropdown);
    
    $fids[] = 0;
    $titles[] = "ALL";
    
    while($row = db_fetch_array($result)) {
    
      $fids[]   = $row['FID'];
      $titles[] = $row['TITLE'];
      
    }
    
    return form_dropdown_array("fid", $fids, $titles, 0);
    
}

function search_draw_user_dropdown($name)
{

    global $HTTP_COOKIE_VARS;

    $db_search_draw_user_dropdown = db_connect();
    
    $sql = "select U.UID, U.LOGON, U.NICKNAME, UNIX_TIMESTAMP(U.LAST_LOGON) as LAST_LOGON ";
    $sql.= "from ".forum_table("USER")." U WHERE U.UID <> ". $HTTP_COOKIE_VARS['bh_sess_uid']. " ";
    $sql.= "order by U.LAST_LOGON desc ";
    $sql.= "limit 0, 20";
    
    $result = db_query($sql, $db_search_draw_user_dropdown);
    
    $uids[]  = 0;
    $names[] = "ALL";
    
    if ($HTTP_COOKIE_VARS['bh_sess_uid'] > 0) {
    
      $uids[]  = $HTTP_COOKIE_VARS['bh_sess_uid'];
      $names[] = "ME";
      
    }
    
    while($row = db_fetch_array($result)) {
    
      $uids[]  = $row['UID'];
      $names[] = format_user_name($row['LOGON'], $row['NICKNAME']);
      
    }
    
    return form_dropdown_array($name, $uids, $names, 0);
    
}

?>
