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

/* $Id: logout.php,v 1.42 2004-03-21 20:00:01 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}";
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

// User was a guest that now wants to logon

if (bh_session_get_value('UID') == 0) {

    if (isset($HTTP_GET_VARS['final_uri'])) {
        $uri = "./index.php?webtag={$webtag['WEBTAG']}&final_uri=". $HTTP_GET_VARS['final_uri'];
    }else {
        $uri = "./index.php?webtag={$webtag['WEBTAG']}";
    }
    
    bh_session_end();
    bh_setcookie("bh_logon", '1', time() + YEAR_IN_SECONDS);
    header_redirect($uri);
}

// Where are we going after we've logged off?

if (isset($HTTP_POST_VARS['submit'])) {

    bh_session_end();
    
    if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
    
        header_redirect("./index.php?webtag={$webtag['WEBTAG']}");

    }else {
    
        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        echo "document.location.href = './index.php?webtag={$webtag['WEBTAG']}';\n";
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\">\n";
        echo "<p>{$lang['youhaveloggedout']}</p>\n";

        form_quick_button("./index.php", $lang['continue'], "webtag", $webtag['WEBTAG'], "_top");

        echo "</div>\n";
        html_draw_bottom();
        exit;
    }
}

html_draw_top();

echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"./logout.php\" method=\"post\" target=\"_top\">\n";
echo "  ", form_input_hidden("webtag", $webtag['WEBTAG']), "\n";
echo "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"subhead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">{$lang['logout']}:</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td>{$lang['currentlyloggedinas']} ", user_get_logon(bh_session_get_value('UID')), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"center\">", form_submit("submit", $lang['logout']), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form></div>\n";

html_draw_bottom();

?>