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

/* $Id: edit_password.php,v 1.34 2005-01-19 21:49:28 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_POST['submit'])) {

    $valid = true;
    $error_html = "";

    // Required fields

    if (isset($_POST['opw']) && strlen(trim(_stripslashes($_POST['opw']))) > 0) {

        if (isset($_POST['npw']) && strlen(trim(_stripslashes($_POST['npw']))) > 0) {

            if (isset($_POST['cpw']) && strlen(trim(_stripslashes($_POST['cpw']))) > 0) {

                if (trim(_stripslashes($_POST['npw'])) == trim(_stripslashes($_POST['cpw']))) {

                    if (_htmlentities(trim(_stripslashes($_POST['npw']))) != trim(trim(_stripslashes($_POST['npw'])))) {
                        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
                        $valid = false;
                    }

                    if (!preg_match("/^[a-z0-9_-]+$/i", trim(_stripslashes($_POST['npw'])))) {
                        $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
                        $valid = false;
                    }

                    if (strlen(trim(_stripslashes($_POST['npw']))) < 6) {
                        $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
                        $valid = false;
                    }

                    if ($valid) {
                        $t_password = trim(_stripslashes($_POST['npw']));
                        $t_passhash = md5(trim(_stripslashes($_POST['opw'])));
                    }

                }else {
                    $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
                    $valid = false;
                }

            }else {
                $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
                $valid = false;
            }

        }else {
            $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update the password (and cookie)

        user_change_pass($uid, $t_password, $t_passhash);

        // Username array

        if (isset($_COOKIE['bh_remember_username']) && is_array($_COOKIE['bh_remember_username'])) {
            $username_array = $_COOKIE['bh_remember_username'];
        }else {
            $username_array = array();
        }

        // Password array

        if (isset($_COOKIE['bh_remember_password']) && is_array($_COOKIE['bh_remember_password'])) {
            $password_array = $_COOKIE['bh_remember_password'];
        }else {
            $password_array = array();
        }

        // Passhash array

        if (isset($_COOKIE['bh_remember_passhash']) && is_array($_COOKIE['bh_remember_passhash'])) {
            $passhash_array = $_COOKIE['bh_remember_passhash'];
        }else {
            $passhash_array = array();
        }

        // Update the password that matches the current logged on user

        foreach ($username_array as $key => $logon) {
            if (stristr($logon, bh_session_get_value('LOGON'))) {
                $t_passhash = md5($t_password);
                $t_password = str_repeat(chr(32), strlen($t_password));
                if (isset($password_array[$key]) && isset($passhash_array[$key])) {
                    bh_setcookie("bh_remember_password[$key]", $t_password, time() + YEAR_IN_SECONDS);
                    bh_setcookie("bh_remember_passhash[$key]", $t_passhash, time() + YEAR_IN_SECONDS);
                }
            }
        }

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./edit_password.php?webtag=$webtag&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './edit_password.php?webtag=$webtag&amp;updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['passwdchanged']}</p>";

            form_quick_button("./edit_password.php", $lang['continue'], false, false, "_top");

            html_draw_bottom();
            exit;
        }
    }
}

// Start Output Here

html_draw_top();

echo "<h1>{$lang['changepassword']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['passwdchanged']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_password.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['changepassword']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['currentpasswd']}:</td>\n";
echo "                  <td>", form_field("opw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['newpasswd']}:</td>\n";
echo "                  <td>", form_field("npw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['confirmpasswd']}:</td>\n";
echo "                  <td>", form_field("cpw", "", 37, 0, "password"), "&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>