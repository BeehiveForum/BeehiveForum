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

// Disable caching if proxy server detected.
cache_disable_proxy();

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
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Load language file
$lang = load_language_file();

// Check we have a webtag
$webtag = get_webtag();

// Array to hold error messages
$error_msg_array = array();

// Submit code.
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {

        $uid = $_POST['uid'];

    }else {

        $error_msg_array[] = $lang['invaliduseraccount'];
        $valid = false;
    }

    if (isset($_POST['key']) && is_md5(trim(stripslashes_array($_POST['key'])))) {

        $key = $_POST['key'];

    }else {

        $error_msg_array[] = $lang['invaliduserkeyprovided'];
        $valid = false;
    }

    if (isset($_POST['pw']) && strlen(trim(stripslashes_array($_POST['pw']))) > 0) {

        $pw = $_POST['pw'];

    }else {

        $error_msg_array[] = $lang['youmustenteranewpasswd'];
        $valid = false;
    }

    if (isset($_POST['cpw']) && strlen(trim(stripslashes_array($_POST['cpw']))) > 0) {

        $cpw = $_POST['cpw'];

    }else {

        $error_msg_array[] = $lang['youmustconfirmyournewpasswd'];
        $valid = false;
    }

    if ($valid) {

        if (htmlentities_array($pw) != $pw) {

            $error_msg_array[] = $lang['passwdmustnotcontainHTML'];
            $valid = false;
        }

        if (mb_strlen(trim(stripslashes_array($_POST['pw']))) < 6) {

            $error_msg_array[] = $lang['passwdtooshort'];
            $valid = false;
        }

        if ($pw != $cpw) {

            $error_msg_array[] = $lang['passwdsdonotmatch'];
            $valid = false;
        }
    }

    if ($valid) {

        if (user_change_password($uid, $pw, $key)) {

            html_draw_top("title={$lang['passwdchanged']}", 'class=window_title');
            html_display_msg($lang['passwdchanged'], $lang['passedchangedexp'], 'index.php', 'get', array('continue' => $lang['continue']), false, '_top');
            html_draw_bottom();
            exit;

        }else {

            $error_msg_array[] = $lang['updatefailed'];
            $valid = false;
        }
    }
}

if (isset($_GET['u']) && is_numeric($_GET['u']) && isset($_GET['h']) && is_md5($_GET['h'])) {

    $uid = $_GET['u'];
    $key = $_GET['h'];

}elseif (isset($_POST['uid']) && is_numeric($_POST['uid']) && isset($_POST['key']) && is_md5($_POST['key'])) {

    $uid = $_POST['uid'];
    $key = $_POST['key'];

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['requiredinformationnotfound']);
    html_draw_bottom();
    exit;
}

if (!$user = user_get_by_password($uid, $key)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['requiredinformationnotfound']);
    html_draw_bottom();
    exit;
}

html_draw_top("title={$lang['changepassword']}", 'class=window_title');

echo "<h1>{$lang['changepassword']}</h1>";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '450', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"forgot_pw\" action=\"change_pw.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("uid", htmlentities_array($uid)), "\n";
echo "  ", form_input_hidden("key", htmlentities_array($key)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"450\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['changepassword']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">{$lang['newpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("pw", "", 37, 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">{$lang['confirmpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("cpw", "", 37, 0), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>