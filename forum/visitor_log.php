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

/* $Id: visitor_log.php,v 1.45 2004-04-28 14:28:55 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/db.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $start = floor($_GET['page'] - 1) * 20;
}else {
    $start = 0;
}

if (isset($_GET['usersearch']) && strlen(trim($_GET['usersearch'])) > 0) {
    $usersearch = $_GET['usersearch'];
}else {
    $usersearch = "";
}

if (isset($_GET['reset'])) {
    $usersearch = "";
}

html_draw_top("openprofile.js");

echo "<h1>{$lang['recentvisitors']}</h1><br />\n";

if (isset($usersearch) && strlen($usersearch) > 0) {
    $user_search_array = users_search_recent($usersearch, $start);
}else {
    $user_search_array = users_get_recent();
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"65%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";

if (sizeof($user_search_array['user_array']) > 0) {

    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\">{$lang['member']}</td>\n";
    echo "                   <td class=\"subhead\" align=\"right\" width=\"200\">{$lang['lastvisit']}&nbsp;</td>\n";
    echo "                 </tr>\n";

    foreach ($user_search_array['user_array'] as $user_search) {
        echo "                 <tr>\n";
        echo "                   <td class=\"postbody\" align=\"left\"><a href=\"#\" target=\"_self\" onclick=\"openProfile({$user_search['UID']}, '$webtag')\">", format_user_name($user_search['LOGON'], $user_search['NICKNAME']), "</a></td>\n";
        echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">", format_time($user_search['LAST_LOGON']), "&nbsp;</td>\n";
        echo "                 </tr>\n";
    }

    echo "                 <tr>\n";
    echo "                   <td class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";

}else {

    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\">{$lang['search']}</td>\n";
    echo "                 </tr>\n";
    echo "                 <tr>\n";
    echo "                   <td class=\"postbody\" align=\"left\">{$lang['yoursearchdidnotreturnanymatches']}</td>\n";
    echo "                 </tr>\n";
    echo "                 <tr>\n";
    echo "                   <td class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";
}

echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">Pages: ";

$page_count = ceil($user_search_array['user_count'] / 10);

if ($page_count > 1) {

    for ($page = 1; $page <= $page_count; $page++) {
        echo "<a href=\"visitor_log.php?webtag=$webtag&amp;usersearch=$usersearch&amp;page=$page\" target=\"_self\">$page</a> ";
    }

}else {

    echo "<a href=\"visitor_log.php?webtag=$webtag&amp;usersearch=$usersearch&amp;page=1\" target=\"_self\">1</a> ";
}

echo "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

echo "<form action=\"visitor_log.php\" method=\"get\">\n";
echo "  ", form_input_hidden("webtag", $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"65%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"6\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>