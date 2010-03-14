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

/* $Id$ */

// Set the default timezone

date_default_timezone_set('UTC');

// Constant to define where the include files are

define("BH_INCLUDE_PATH", "include/");

// Server checking functions

include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions

include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals

unregister_globals();

// Disable caching if on AOL

cache_disable_aol();

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Load language file

$lang = load_language_file();

// Make sure we have a webtag

$webtag = get_webtag();

// Array for holding error messages

$error_msg_array = array();

if (isset($_POST['request'])) {

    if (isset($_POST['logon'])) {

        $logon = mb_strtoupper($_POST['logon']);

        if (email_send_pw_reminder($logon)) {

            html_draw_top("title={$lang['passwdresetemailsent']}");
            html_display_msg($lang['passwdresetemailsent'], $lang['passwdresetexp'], 'logon.php', 'get', array('back' => $lang['back']), false, '_self', 'center');
            html_draw_bottom();
            exit;

        }else {

           $error_msg_array[] = $lang['couldnotsendpasswordreminder'];
        }

    }else {

        $error_msg_array[] = $lang['validusernamerequired'];
    }
}

html_draw_top("title={$lang['forgotpasswd']}");

echo "<h1>{$lang['forgotpasswd']}</h1>";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '450', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"forgot_pw\" action=\"forgot_pw.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "      <tr>\n";
echo "        <td align=\"center\">\n";
echo "          <table class=\"box\" width=\"450\">\n";
echo "            <tr>\n";
echo "              <td align=\"left\" class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['forgotpasswd']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td align=\"center\">\n";
echo "                      <table class=\"posthead\" width=\"95%\">\n";
echo "                        <tr>\n";
echo "                          <td align=\"left\">{$lang['username']}:</td>\n";
echo "                          <td align=\"left\">", form_input_text("logon", (isset($logon) ? htmlentities_array($logon) : ''), 37, 15), "</td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td align=\"left\">&nbsp;</td>\n";
echo "                    <td align=\"left\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"left\">&nbsp;</td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\">", form_submit('request', $lang['request']), "</td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>