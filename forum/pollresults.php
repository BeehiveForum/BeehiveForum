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

if ($HTTP_POST_VARS['submit'] == 'Close') {

  echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
  echo "  window.close();\n";
  echo "</script>\n";
  
  html_draw_bottom();
  exit;
  
}

$poll = poll_get_votes($HTTP_GET_VARS['tid']);

$totalvotes = $poll['O1_VOTES'] + $poll['O2_VOTES'] + 
              $poll['O3_VOTES'] + $poll['O4_VOTES'] + 
              $poll['O5_VOTES'];
    
$pollresults = array(0 => array('option' => $poll['O1'], 'votes' => $poll['O1_VOTES']),
                     1 => array('option' => $poll['O2'], 'votes' => $poll['O2_VOTES']),
                     2 => array('option' => $poll['O3'], 'votes' => $poll['O3_VOTES']),
                     3 => array('option' => $poll['O4'], 'votes' => $poll['O4_VOTES']),
                     4 => array('option' => $poll['O5'], 'votes' => $poll['O5_VOTES']));

for ($i = 0; $i < 5; $i++) {
   
  if (!empty($pollresults[$i]['option'])) {
    
    if ($pollresults[$i]['votes'] > $max_value) $max_value = $pollresults[$i]['votes'];
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
echo "          <td><h2>". thread_get_title($HTTP_GET_VARS['tid']). "</h2></td>\n";
echo "        </tr>\n";

if ($poll['SHOWRESULTS'] == 1) {

  if ($poll['POLLTYPE'] == 0) {

    echo "        <tr>\n";
    echo "          <td>\n";
    echo poll_horizontal_graph($pollresults, $horizontal_bar_width);
    echo "          </td>\n";
    echo "        </tr>\n";
    
  }else {
  
    echo "        <tr>\n";
    echo "          <td>\n";
    echo poll_vertical_graph($pollresults, $vertical_bar_height, $vertical_bar_width);
    echo "          </td>\n";
    echo "        </tr>\n";
    
  }
  
}else {
        
  for ($i = 0; $i < 5; $i++) {
        
    if (!empty($pollresults[$i]['option'])) {

      echo "        <tr>\n";
      echo "          <td class=\"postbody\">". $pollresults[$i]['option']. "</td>\n";
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