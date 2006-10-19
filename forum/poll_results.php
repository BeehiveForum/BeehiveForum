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

/* $Id: poll_results.php,v 1.12 2006-10-19 19:34:44 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
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

    if (!$t_fid = thread_get_folder($tid, 1)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    echo "<div align=\"center\">";
    echo "<p>{$lang['mustspecifypolltoview']}</p>";
    echo "<form method=\"post\" action=\"poll_results.php\">\n";
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

if ($polldata['VOTETYPE'] == 1 && $polldata['POLLTYPE'] != 2) {

    echo "<div align=\"center\">\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\" class=\"postbody\">\n";
    echo "      <form name=\"f_mode\" method=\"get\" action=\"poll_results.php\">\n";
    echo "        ", form_input_hidden("webtag", $webtag), "\n";
    echo "        ", form_input_hidden("tid", $tid), "\n";
    echo "        View Style: ", form_dropdown_array("viewstyle", range(0, 1), array('By option', 'By user'), $viewstyle, "onchange=\"submit()\""), "&nbsp;", form_submit('go', $lang['goexcmark']), "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

echo "<div align=\"center\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <table width=\"95%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\"><h2>". thread_get_title($tid). "</h2></td>\n";
echo "        </tr>\n";

if ($polldata['SHOWRESULTS'] == 1 || bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) || ($polldata['CLOSES'] > 0 && $polldata['CLOSES'] < mktime())) {

  if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2 && $polldata['POLLTYPE'] != 2) {

    echo "        <tr>\n";
    echo "          <td align=\"left\" colspan=\"2\">\n";
    echo poll_public_ballot($tid, $viewstyle);
    echo "          </td>\n";
    echo "        </tr>\n";

  }else {

    if ($polldata['POLLTYPE'] == 0) {

      echo "        <tr>\n";
      echo "          <td align=\"left\">\n";
      echo poll_horizontal_graph($tid);
      echo "          </td>\n";
      echo "        </tr>\n";

    }elseif ($polldata['POLLTYPE'] == 2) {

      echo "        <tr>\n";
      echo "          <td align=\"left\">\n";
      echo poll_table_graph($tid);
      echo "          </td>\n";
      echo "        </tr>\n";

    }else {

      echo "        <tr>\n";
      echo "          <td align=\"left\">\n";
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
      echo "          <td align=\"left\" class=\"postbody\">{$pollresults['OPTION_NAME'][$i]}</td>\n";
      echo "        </tr>\n";

    }

  }

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";
echo "<form method=\"post\" action=\"poll_results.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ". form_submit('submit', $lang['close']). "\n";
echo "</form>\n";
echo "</div>\n";


html_draw_bottom();

?>