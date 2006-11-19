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

/* $Id: visitor_log.php,v 1.73 2006-11-19 00:13:22 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
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

if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
    $start = floor($_GET['page'] - 1) * 20;
}else {
    $start = 0;
}

if (isset($_GET['usersearch']) && strlen(trim(_stripslashes($_GET['usersearch']))) > 0) {
    $usersearch = $_GET['usersearch'];
}else {
    $usersearch = "";
}

if (isset($_GET['reset'])) {
    $usersearch = "";
}

html_draw_top("robots=noindex,nofollow", "openprofile.js");

echo "<h1>{$lang['recentvisitors']}</h1><br />\n";

if (isset($usersearch) && strlen($usersearch) > 0) {
    $user_search_array = users_search_recent($usersearch, $start);
}else {
    $user_search_array = users_get_recent($start, 20);
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"65%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";

if (sizeof($user_search_array['user_array']) > 0) {

    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\">{$lang['member']}</td>\n";
    echo "                   <td class=\"subhead\" align=\"right\" width=\"200\">{$lang['lastvisit']}&nbsp;</td>\n";
    echo "                 </tr>\n";

    foreach ($user_search_array['user_array'] as $user_search) {

        echo "                 <tr>\n";

        if (isset($user_search['SID']) && !is_null($user_search['SID'])) {

            echo "                   <td class=\"postbody\" align=\"left\"><a href=\"{$user_search['URL']}\" target=\"_blank\">{$user_search['NAME']}</a></td>\n";

        }elseif ($user_search['UID'] > 0) {

            echo "                   <td class=\"postbody\" align=\"left\"><a href=\"javascript:void(0)\" target=\"_self\" onclick=\"openProfile({$user_search['UID']}, '$webtag')\">", add_wordfilter_tags(add_wordfilter_tags(format_user_name($user_search['LOGON'], $user_search['NICKNAME']))), "</a></td>\n";

        }else {

            echo "                   <td class=\"postbody\" align=\"left\">", add_wordfilter_tags(add_wordfilter_tags(format_user_name($user_search['LOGON'], $user_search['NICKNAME']))), "</td>\n";
        }

        if (isset($user_search['LAST_LOGON']) && $user_search['LAST_LOGON'] > 0) {
            echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">", format_time($user_search['LAST_LOGON']), "&nbsp;</td>\n";
        }else {
            echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">{$lang['unknown']}&nbsp;</td>\n";
        }

        echo "                 </tr>\n";
    }

    echo "                 <tr>\n";
    echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";

}else {

    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\">{$lang['search']}</td>\n";
    echo "                 </tr>\n";

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "                 <tr>\n";
        echo "                   <td class=\"postbody\" align=\"left\">{$lang['yoursearchdidnotreturnanymatches']}</td>\n";
        echo "                 </tr>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td class=\"postbody\" align=\"left\">{$lang['nouseraccounts']}</td>\n";
        echo "                 </tr>\n";
    }

    echo "                 <tr>\n";
    echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";
}

echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", page_links(get_request_uri(false), $start, $user_search_array['user_count'], 20), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <form action=\"visitor_log.php\" method=\"get\">\n";
echo "    ", form_input_hidden("webtag", $webtag), "\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"65%\">\n";
echo "      <tr>\n";
echo "        <td align=\"left\">\n";
echo "          <table class=\"box\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"left\" class=\"posthead\">\n";
echo "                <table width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td class=\"posthead\" align=\"left\">\n";
echo "                      {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
echo "                    </td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>