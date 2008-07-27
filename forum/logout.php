<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: logout.php,v 1.100 2008-07-27 10:53:32 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Intitalise a few variables

// Load the user session

$user_sess = bh_session_check(false);

// Fetch the forum webtag

$webtag = get_webtag();

// Load Language File

$lang = load_language_file();

// User was a guest that now wants to logon

if (user_is_guest()) {

    if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {
        $final_uri = "&final_uri=". rawurlencode(trim(_stripslashes($_GET['final_uri'])));
    }else {
        $final_uri = "";
    }

    bh_session_remove_cookies();
    bh_setcookie("bh_logon", "1");
    header_redirect("index.php?webtag=$webtag$final_uri");
    exit;
}

// The logout link on nav.php needs to be redirected to index.php

if (isset($_GET['check_cookie'])) {

    header_redirect("index.php?webtag=$webtag&final_uri=logout.php%3Fwebtag%3D$webtag");
    exit;
}

// Where are we going after we've logged off?

if (isset($_POST['logout'])) {

    bh_session_end();
    bh_setcookie("bh_logon", "1");

    header_redirect("index.php?webtag=$webtag", $lang['youhaveloggedout']);
}

html_draw_top();

$user = user_get(bh_session_get_value('UID'));

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"logout.php\" method=\"post\" target=\"", html_get_top_frame_name(), "\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"300\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"subhead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['logout']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\" nowrap=\"nowrap\">", sprintf($lang['currentlyloggedinas'], word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME'])))), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">", form_submit("logout", $lang['logout']), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form></div>\n";

html_draw_bottom();

?>