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

/* $Id: pollresults.php,v 1.60 2004-04-29 14:02:53 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag();

            html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    html_draw_top();
    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top("openprofile.js");

if (isset($_POST['submit']) && $_POST['submit'] == $lang['close']) {

  echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
  echo "  window.close();\n";
  echo "</script>\n";

  html_draw_bottom();
  exit;

}

if (isset($_GET['tid']) && is_numeric($_GET['tid'])) {

  $tid = $_GET['tid'];

}else {

  echo "<div align=\"center\">";
  echo "<p>{$lang['mustspecifypolltoview']}</p>";
  echo "<form method=\"post\" action=\"pollresults.php\">\n";
  echo "  ", form_input_hidden('webtag', $webtag), "\n";
  echo "  ". form_submit('submit', $lang['close']). "\n";
  echo "</form>\n";
  echo "</div>";

  html_draw_bottom();
  exit;

}

$polldata = poll_get($tid);

if (isset($_GET['viewstyle']) && is_numeric($_GET['viewstyle'])) {
    $viewstyle = $_GET['viewstyle'];
    if ($viewstyle < 0 || $viewstyle > 1) $viewstyle = 0;
}else {
    $viewstyle = 0;
}

echo "<br />\n";

if ($polldata['VOTETYPE'] == 1) {

    echo "<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\" class=\"postbody\">\n";
    echo "      <form name=\"f_mode\" method=\"get\" action=\"pollresults.php\">\n";
    echo "        ", form_input_hidden("webtag", $webtag), "\n";
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

  $pollresults = poll_get_votes($tid);

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
echo "  <form method=\"post\" action=\"pollresults.php\" target=\"_self\">\n";
echo "    ", form_input_hidden('webtag', $webtag), "\n";
echo "    ". form_submit('submit', $lang['close']). "\n";
echo "  </form>\n";
echo "</div>\n";


html_draw_bottom();

?>