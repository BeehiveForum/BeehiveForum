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

// Author: Matt Beale

require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once('./include/poll.inc.php');
require_once('./include/html.inc.php');

html_draw_top();

if (isset($HTTP_GET_VARS['tid'])) {

  $tid = $HTTP_GET_VARS['tid'];
   
}else {

  echo "<div align=\"center\">";
  echo "<p>You must specify a poll to view.</p>";
  echo "<form method=\"post\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\">\n";
  echo "  ". form_submit('submit', 'Close'). "\n";
  echo "</form>\n";
  echo "</div>";
            
  html_draw_bottom();
  exit;
  
}  

if ($HTTP_POST_VARS['submit'] == 'Close') {

  echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
  echo "  window.close();\n";
  echo "</script>\n";

  html_draw_bottom();
  exit;

}

$polldata     = poll_get($tid);
$pollresults  = poll_get_votes($tid);

$totalvotes   = 0;

for ($i = 1; $i <= sizeof($pollresults); $i++) {
  $totalvotes = $totalvotes + $pollresults[$i]['VOTES'];
}


for ($i = 1; $i <= sizeof($pollresults); $i++) {

  if (!empty($pollresults[$i]['OPTION_NAME'])) {

    if ($pollresults[$i]['VOTES'] > $max_value) $max_value = $pollresults[$i]['VOTES'];
    $optioncount++;

  }

}

if ($max_value > 0) {

  $horizontal_bar_width = floor((300 / $max_value));

  $vertical_bar_height = floor((200 / $max_value));
  $vertical_bar_width = floor((350 / $optioncount));

}

echo "<br />\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table width=\"95%\" align=\"center\">\n";
echo "        <tr>\n";
echo "          <td><h2>". thread_get_title($tid). "</h2></td>\n";
echo "        </tr>\n";

if ($polldata['SHOWRESULTS'] == 1) {

  if ($polldata['POLLTYPE'] == 0) {

    echo "        <tr>\n";
    echo "          <td>\n";
    echo poll_horizontal_graph($pollresults, $horizontal_bar_width, $totalvotes);
    echo "          </td>\n";
    echo "        </tr>\n";

  }else {

    echo "        <tr>\n";
    echo "          <td>\n";
    echo poll_vertical_graph($pollresults, $vertical_bar_height, $vertical_bar_width, $totalvotes);
    echo "          </td>\n";
    echo "        </tr>\n";

  }

}else {

  for ($i = 1; $i <= sizeof($pollresults); $i++) {

    if (!empty($pollresults[$i]['OPTION_NAME'])) {

      echo "        <tr>\n";
      echo "          <td class=\"postbody\">". $pollresults[$i]['OPTION_NAME']. "</td>\n";
      echo "        </tr>\n";

    }

  }

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form method=\"post\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\">\n";
echo "    ". form_submit('submit', 'Close'). "\n";
echo "  </form>\n";
echo "</div>\n";


html_draw_bottom();

?>
