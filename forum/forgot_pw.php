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

/* $Id: forgot_pw.php,v 1.29 2004-04-23 22:11:04 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/email.inc.php");
include_once("./include/form.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/user.inc.php");

if (isset($_POST['submit'])) {

    if (isset($_POST['logon'])) {

        $logon = strtoupper($_POST['logon']);

	if (email_send_pw_reminder($logon)) {

            html_draw_top();

            echo "<h1>{$lang['passwdresetemailsent']}</h1>";
            echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
            echo "<p class=\"smalltext\">{$lang['passwdresetexp_1']}<br />\n";
            echo "{$lang['passwdresetexp_2']}</p>\n";

            form_quick_button('./logon.php', 'Back');

            html_draw_bottom();
            exit;

        }else {

	    $error_html = "<h2>{$lang['couldnotsendpasswordreminder']}</h2>\n";
	}

    }else {

        $error_html = "<h2>{$lang['validusernamerequired']}</h2>\n";
    }
}

// Load language file

$lang = load_language_file();

// Make sure we have a webtag

$webtag = get_webtag();

html_draw_top();

echo "<h1>{$lang['forgotpasswd']}</h1>";

if (isset($error_html)) {
    echo $error_html;
}else {
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "  <form name=\"forgot_pw\" action=\"forgot_pw.php?webtag=$webtag\" method=\"POST\">\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"subhead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td>{$lang['forgotpasswd']}</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"right\">{$lang['username']}:</td>\n";
echo "              <td>", form_input_text("logon", (isset($logon) ? $logon : '')), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"center\">", form_submit('submit', $lang['request']), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "  <p>{$lang['forgotpasswdexp_1']}<br />{$lang['forgotpasswdexp_2']}</p>\n";
echo "</div>\n";

html_draw_bottom();

?>