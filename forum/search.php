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

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);

    header_redirect($uri);
}

require_once("./include/search.inc.php");
require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/user.inc.php");
require_once("./include/threads.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");

// Base Query - The same for all searches
  
$basesql = "SELECT THREAD.FID, THREAD.TID, POST.TID, POST.PID, POST.FROM_UID, POST.TO_UID, ";
$basesql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST_CONTENT.CONTENT ";
$basesql.= "FROM ". forum_table("THREAD"). " THREAD ";
$basesql.= "LEFT JOIN ". forum_table("POST"). " ON (THREAD.TID = POST.TID) ";
$basesql.= "LEFT JOIN ". forum_table("POST_CONTENT"). " ON (POST.PID = POST_CONTENT.PID AND POST.TID = POST_CONTENT.TID) ";
$basesql.= "WHERE ";

// Construct the unique part of the query

if (isset($HTTP_POST_VARS['submit'])) {

  // Folder ID
  
  if ($HTTP_POST_VARS['fid'] > 0) {
    $searchsql.= "THREAD.FID = ". $HTTP_POST_VARS['fid']. " ";
  }else{
    $folders = threads_get_available_folders();
    $searchsql.= "THREAD.FID in ($folders) ";
  }
  
  // Date Range
  
  $searchsql.= search_date_range($HTTP_POST_VARS['date_from'], $HTTP_POST_VARS['date_to']). " ";
  
  // Keywords
  
  if (!empty($HTTP_POST_VARS['search_string'])) {
  
    if ($HTTP_POST_VARS['method'] == 1) {
  
      $keywords = explode(' ', $HTTP_POST_VARS['search_string']);
      foreach($keywords as $word) $searchsql.= "AND POST_CONTENT.CONTENT LIKE '%$word%' ";
    
    }elseif ($HTTP_POST_VARS['method'] == 2) {
  
      $searchsql.= "AND ";
      $keywords = explode(' ', $HTTP_POST_VARS['search_string']);
      foreach($keywords as $word) $searchsql.= "POST_CONTENT.CONTENT LIKE '%$word%' OR ";
      $searchsql = substr($searchsql, 0, -3);
    
    }elseif ($HTTP_POST_VARS['method'] == 3) {
  
      $searchsql.= "AND POST_CONTENT.CONTENT LIKE '%". $HTTP_POST_VARS['search_string']. "%' ";

    }
    
  }
  
  // User selection
  
  if ($HTTP_POST_VARS['me_only'] != 'Y') {
  
    // To User
  
    if (empty($HTTP_POST_VARS['to_other']) && $HTTP_POST_VARS['to_uid'] > 0) {
      $searchsql.= "AND POST.TO_UID = ". $HTTP_POST_VARS['to_uid']. " ";
    }elseif (!empty($HTTP_POST_VARS['to_other'])) {
      $touid = user_get_uid($HTTP_POST_VARS['to_other']);
      if ($touid > -1) $searchsql.= "AND POST.TO_UID = ". $touid. " ";    
    }
  
    // From User
  
    if (empty($HTTP_POST_VARS['from_other']) && $HTTP_POST_VARS['from_uid'] > 0) {
      $searchsql.= "AND POST.FROM_UID = ". $HTTP_POST_VARS['from_uid']. " ";
    }elseif (!empty($HTTP_POST_VARS['from_other'])) {
      $fromuid = user_get_uid($HTTP_POST_VARS['from_other']);
      if ($fromuid > -1) $searchsql.= "AND POST.FROM_UID = ". $fromuid. " ";      
    }
    
  }else {
  
    $searchsql.= "AND POST.TO_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid']. " OR ";
    $searchsql.= $searchsql. " AND POST.FROM_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid']. " ";

  }
  
  // Order by
  
  if ($HTTP_POST_VARS['order_by'] == 2) {
    $searchsql.= "ORDER BY POST.CREATED DESC";
  }elseif($HTTP_POST_VARS['order_by'] == 3) {
    $searchsql.= "ORDER BY POST.CREATED";
  }
  
}

if (isset($HTTP_COOKIE_VARS['bh_search_sql']) && isset($HTTP_GET_VARS['sstart'])) $searchsql = stripslashes($HTTP_COOKIE_VARS['bh_search_sql']);

if (isset($searchsql)) {

  setcookie('bh_search_sql', $searchsql);
  
  html_draw_top();

  echo "<h1>Search Results</h1>";

  $db  = db_connect();
  $sql = $basesql.$searchsql;

  if (isset($HTTP_GET_VARS['sstart'])) {
    $sstart = $HTTP_GET_VARS['sstart'];
  }else {
    $sstart = 0;
  }
  
  $result = db_query($sql, $db);
  $numRows = mysql_num_rows($result);  
  
  echo "<br />\n";
  echo "<img src=\"./images/star.png\" alt=\"\">&nbsp;Found: ", $numRows, " matches<br />\n";
  
  if (($sstart + 50) > $numRows) {  
    echo "<img src=\"./images/star.png\" alt=\"\">&nbsp;Showing results: ", $sstart + 1, " - ", $numRows, "<br /><br />\n";
  }else{
    echo "<img src=\"./images/star.png\" alt=\"\">&nbsp;Showing results: ", $sstart + 1, " - ", $sstart + 50, "<br /><br />\n";
  }
  
  for ($i = $sstart; $i < $sstart + 50; $i++) {
  
    if (db_data_seek($result, $i)) {
    
      $row = db_fetch_array($result);
  
      $message = messages_get($row['TID'], $row['PID']);
      $threaddata = thread_get($row['TID']);
      $closed = isset($threaddata['CLOSED']);
      $foldertitle = folder_get_title($threaddata['FID']);
      if($closed) $foldertitle .= " (closed)";
    
      echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td>\n";
      echo "<p><img src=\"./images/folder.png\" alt=\"folder\" />&nbsp;$foldertitle:&nbsp;<a href=\"messages.php?msg=". $row['TID']. ".". $row['PID']. "\" target=\"_self\">". stripslashes($threaddata['TITLE']). "</a></p>";
      echo "</td></tr></table></div>\n";
      
      $message[0]['CONTENT'] = fix_html($message[0]['CONTENT']);
    
      message_display($row['TID'], $message[0], $threaddata['LENGTH'], $row['PID'], true, false);
      echo "<br />\n";
      
    }
    
  }
  
  if (($numRows > 50) && (($sstart + 50) < $numRows)) {
    if ($numRows - ($sstart + 50) > 50) {
      echo "<img src=\"./images/star.png\" alt=\"\">&nbsp;<a href=\"search.php?sstart=", $sstart + 50, "\">Next 50</a>\n";
    }else{
      echo "<img src=\"./images/star.png\" alt=\"\">&nbsp;<a href=\"search.php?sstart=", $sstart + 50, "\">Next ", $numRows - ($sstart + 50), "</a>\n";
    }
  }
  
  html_draw_bottom();
  exit;
  
}

html_draw_top();

?>
<h1>Search Messages</h1>
<form method="post" action="search.php">
<table border="0" width="500" align="center">
  <tr>
    <td class="postbody" colspan="2">Search Discussions...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_dropdown_array("method", range(1,3), array("Containing all of the words", "Containing any of the words", "Containing the exact phrase"), 1). "&nbsp;". form_input_text("search_string", "", 20). "&nbsp;". form_submit("submit", "Find"); ?></td>
  </tr>
  <tr>
    <td class="postbody" colspan="2">&nbsp;</td>
  </tr>   
  <tr>
    <td class="postbody" colspan="2">Additional Criteria</td>
  </tr>
  <tr>
    <td align="right" class="postbody">Folder(s):</td>
    <td><?php echo folder_search_dropdown(); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">To:</td>
    <td class="postbody"><?php echo search_draw_user_dropdown("to_uid"); ?> or <?php echo form_input_text("to_other", "", 20); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">From:</td>
    <td class="postbody"><?php echo search_draw_user_dropdown("from_uid"); ?> or <?php echo form_input_text("from_other", "", 20); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Posted From:</td>
    <td><?php echo form_dropdown_array("date_from", range(1, 12), array("Today", "Yesterday", "Day before yesterday", "1 week", "2 weeks", "3 weeks", "1 month", "2 months", "3 months", "6 months", "1 year", "Beginning of time"), 1); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Posted To:</td>
    <td><?php echo form_dropdown_array("date_to", range(1, 12), array("Now", "Today", "Yesterday", "Day before yesterday", "1 week", "2 weeks", "3 weeks", "1 month", "2 months", "3 months", "6 months", "1 year"), 2); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Order by:</td>
    <td><?php echo form_dropdown_array("order_by", range(1, 3), array("Relevance", "Newest First", "Oldest First"), 1); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_checkbox("me_only", "Y", "Only show messages to or from me", false); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("submit", "Find"); ?></td>
  </tr>
</table>
</form>

<?php

html_draw_bottom();

?>   