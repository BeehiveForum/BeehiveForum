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

//require_once("./include/search.inc.php");
require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/post.inc.php");

html_draw_top();

if (isset($HTTP_POST_VARS['submit'])) {

  echo "Yes, thats right, this doesn't do anything at the moment, but it certainly had you going didn't it?<br /><br />";
  echo "Method: ". $HTTP_POST_VARS['method']. "<br />\n";
  echo "Search String: ". $HTTP_POST_VARS['search_string']. "<br />\n";
  echo "Folder ID: ". $HTTP_POST_VARS['t_fid']. "<br />\n";

  if (isset($HTTP_POST_VARS['to_other'])) {
    echo "Messages To User: ". $HTTP_POST_VARS['to_other']. "<br />\n";
  }else{
    echo "Messages To User: ". $HTTP_POST_VARS['t_to_uid']. "<br />\n";
  }
  
  echo "Date From: ". $HTTP_POST_VARS['posted_from']. "<br />\n";
  echo "Date To: ". $HTTP_POST_VARS['posted_to']. "<br />\n";
  echo "Order By: ". $HTTP_POST_VARS['order_by']. "<br />\n";
  
  if (isset($HTTP_POST_VARS['me_only'])) echo "Me only<br />\n";

  html_draw_bottom();
  exit;
  
}

?>
<h1>Search Messages</h1>
<form method="post" action="search.php" target="left">
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
    <td><?php echo folder_draw_dropdown(0); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">To:</td>
    <td class="postbody"><?php echo post_draw_to_dropdown(0); ?> or <?php echo form_input_text("to_other", "", 20); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">From:</td>
    <td class="postbody"><?php echo post_draw_to_dropdown(0); ?> or <?php echo form_input_text("from_other", "", 20); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Posted From:</td>
    <td><?php echo form_dropdown_array("date_from", range(1, 12), array("Today", "Yesterday", "Day before yesterday", "1 week", "2 weeks", "3 weeks", "1 month", "2 months", "3 months", "6 months", "1 year", "Beginning of time"), 1); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Posted To:</td>
    <td><?php echo form_dropdown_array("date_to", range(1, 13), array("Now", "Today", "Yesterday", "Day before yesterday", "1 week", "2 weeks", "3 weeks", "1 month", "2 months", "3 months", "6 months", "1 year", "Beginning of time"), 2); ?></td>
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