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

/* $Id: pollresults.php,v 1.38 2004-03-11 22:34:36 decoyduck Exp $ */

//Multiple forum support
include_once("./include/forum.inc.php");

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

include_once("./include/session.inc.php");
include_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

include_once('./include/poll.inc.php');
include_once('./include/html.inc.php');
include_once("./include/lang.inc.php");

html_draw_top("openprofile.js");

if (isset($HTTP_POST_VARS['submit']) && $HTTP_POST_VARS['submit'] == $lang['close']) {

  echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
  echo "  window.close();\n";
  echo "</script>\n";

  html_draw_bottom();
  exit;

}

if (isset($HTTP_GET_VARS['tid']) && is_numeric($HTTP_GET_VARS['tid'])) {

  $tid = $HTTP_GET_VARS['tid'];

}else {

  echo "<div align=\"center\">";
  echo "<p>{$lang['mustspecifypolltoview']}</p>";
  echo "<form method=\"post\" action=\"pollresults.php?webtag=$webtag\">\n";
  echo "  ". form_submit('submit', $lang['close']). "\n";
  echo "</form>\n";
  echo "</div>";

  html_draw_bottom();
  exit;

}

$polldata = poll_get($tid);

if (isset($HTTP_GET_VARS['viewstyle']) && is_numeric($HTTP_GET_VARS['viewstyle'])) {
    $viewstyle = $HTTP_GET_VARS['viewstyle'];
    if ($viewstyle < 0 || $viewstyle > 1) $viewstyle = 0;
}else {
    $viewstyle = 0;
}

echo "<br />\n";

if ($polldata['VOTETYPE'] == 1) {

    echo "<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\" class=\"postbody\">\n";
    echo "      <form name=\"f_mode\" method=\"get\" action=\"pollresults.php?webtag=$webtag\">\n";
    echo "        ", form_input_hidden("tid", $tid), "\n";
    echo "        View Style: ", form_dropdown_array("viewstyle", range(0, 1), array('By option', 'By user'), $viewstyle, "onchange=\"submit()\""), "&nbsp;", form_submit('go', $lang['goexcmark']), "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table width=\"95%\" align=\"center\">\n";
echo "        <tr>\n";
echo "          <td><h2>". thread_get_title($tid). "</h2></td>\n";
echo "        </tr>\n";

if ($polldata['SHOWRESULTS'] == 1 || bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

  if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2) {

    echo "        <tr>\n";
    echo "          <td colspan=\"2\">\n";
    echo poll_public_ballot($tid, $viewstyle);
    echo "          </td>\n";
    echo "        </tr>\n";

  }else {

    if ($polldata['POLLTYPE'] == 0) {

      echo "        <tr>\n";
      echo "          <td>\n";
      echo poll_horizontal_graph($tid);
      echo "          </td>\n";
      echo "        </tr>\n";

    }else {

      echo "        <tr>\n";
      echo "          <td>\n";
      echo poll_vertical_graph($tid);
      echo "          </td>\n";
      echo "        </tr>\n";

    }
  }

}else {

  for ($i = 0; $i <= sizeof($pollresults['OPTION_ID']); $i++) {

    if (!empty($pollresults['OPTION_NAME'][$i])) {

      echo "        <tr>\n";
      echo "          <td class=\"postbody\">{$pollresults['OPTION_NAME'][$i]}</td>\n";
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
echo "  <form method=\"post\" action=\"pollresults.php?webtag=$webtag\" target=\"_self\">\n";
echo "    ". form_submit('submit', $lang['close']). "\n";
echo "  </form>\n";
echo "</div>\n";


html_draw_bottom();

?>