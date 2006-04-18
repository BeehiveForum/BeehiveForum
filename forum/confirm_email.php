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

/* $Id: confirm_email.php,v 1.5 2006-04-18 17:28:21 decoyduck Exp $ */

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

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $uid = $_GET['uid'];
}else if (isset($_GET['u']) && is_numeric($_GET['u'])) {
    $uid = $_GET['u'];
}

if (isset($_GET['h']) && is_md5($_GET['h'])) {
    $key = $_GET['h'];
}

if (isset($_GET['resend']) && isset($uid)) {

    html_draw_top();

    if (email_send_user_confirmation($uid)) {

        echo "<h1>{$lang['emailconfirmation']}</h1>\n";
        echo "<h2>{$lang['emailconfirmationsent']}</h2>\n";

    }else {

        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['emailconfirmationfailedtosend']}</h2>\n";
    }

    html_draw_top();
    exit;
}

if (!isset($uid) || !isset($key)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2>\n";
    html_draw_bottom();
    exit;
}

if ($user = user_get_password($uid, $key)) {

    html_draw_top();

    if (perm_user_cancel_email_confirmation($uid)) {

        echo "<h1>{$lang['emailconfirmation']}</h1>";
        echo "<br />\n";
        echo "<div align=\"center\">\n";

        if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
            echo "  <form name=\"confirm_email\" action=\"index.php\" method=\"post\" target=\"$frame_top_target\">\n";
        }else {
            echo "  <form name=\"confirm_email\" action=\"index.php\" method=\"post\" target=\"_top\">\n";
        }

        echo "  ", form_input_hidden('webtag', $webtag), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"500\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\">{$lang['emailconfirmation']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>{$lang['emailconfirmationcomplete']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td>&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("submit", $lang['continue']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  </form>\n";
        echo "</div>\n";

    }else {

        echo "<h1>{$lang['emailconfirmation']}</h1>";
        echo "<br />\n";
        echo "<div align=\"center\">\n";

        if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
            echo "  <form name=\"confirm_email\" action=\"index.php\" method=\"post\" target=\"$frame_top_target\">\n";
        }else {
            echo "  <form name=\"confirm_email\" action=\"index.php\" method=\"post\" target=\"_top\">\n";
        }

        echo "  ", form_input_hidden('webtag', $webtag), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
        echo "    <tr>\n";
        echo "      <td>\n";
        echo "        <table class=\"box\">\n";
        echo "          <tr>\n";
        echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"500\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\">{$lang['emailconfirmation']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>{$lang['emailconfirmationfailed']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td>&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("submit", $lang['continue']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "  </form>\n";
        echo "</div>\n";
    }

    html_draw_bottom();

}else {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2></div>\n";
    html_draw_bottom();
    exit;
}

?>