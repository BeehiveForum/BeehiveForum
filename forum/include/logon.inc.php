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

/* $Id: logon.inc.php,v 1.7 2004-04-24 18:42:30 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");

function perform_logon($logon_main)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    // Retrieve existing cookie data if any

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

    if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

        if (preg_match("/^ +$/", _stripslashes($_POST['user_password']))) {

            if (isset($_POST['user_passhash']) && is_md5(_stripslashes($_POST['user_passhash']))) {

                $logon = _stripslashes($_POST['user_logon']);
                $passw = _stripslashes($_POST['user_password']);
                $passh = _stripslashes($_POST['user_passhash']);

                $luid = user_logon(strtoupper($_POST['user_logon']), $_POST['user_passhash'], true);
            }

        }else {

            $logon = _stripslashes($_POST['user_logon']);
            $passw = str_repeat(chr(32), strlen(_stripslashes($_POST['user_password'])));
            $passh = md5(_stripslashes($_POST['user_password']));

            $luid = user_logon(strtoupper($_POST['user_logon']), $_POST['user_password'], false);
        }

        if (isset($luid) && $luid > -1) {

            bh_setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS);

            if ((strtoupper($_POST['user_logon']) == "GUEST") && (strtoupper($_POST['user_password']) == "GUEST")) {

                if (user_guest_enabled()) {

                    bh_session_init(0); // Use UID 0 for guest account.
                }

            }else {

                bh_session_init($luid);

                if (($key = _array_search($logon, $username_array)) !== false) {

                    unset($username_array[$key]);
                    unset($password_array[$key]);
                    unset($passhash_array[$key]);
                }

                array_unshift($username_array, $logon);

                if (isset($_POST['remember_user']) && ($_POST['remember_user'] == 'Y')) {

                    array_unshift($password_array, $passw);
                    array_unshift($passhash_array, $passh);

                }else {

                    array_unshift($password_array, "");
                    array_unshift($passhash_array, "");
                }

                // set / update the username and password cookies

                for ($i = 0; $i < sizeof($username_array); $i++) {

                    bh_setcookie("bh_remember_username[$i]", $username_array[$i], time() + YEAR_IN_SECONDS);

                    if (isset($password_array[$i]) && isset($passhash_array[$i])) {

                        bh_setcookie("bh_remember_password[$i]", $password_array[$i], time() + YEAR_IN_SECONDS);
                        bh_setcookie("bh_remember_passhash[$i]", $passhash_array[$i], time() + YEAR_IN_SECONDS);

                    }else {

                        bh_setcookie("bh_remember_password[$i]", "", time() + YEAR_IN_SECONDS);
                        bh_setcookie("bh_remember_passhash[$i]", "", time() + YEAR_IN_SECONDS);
                    }
                }

                // set / update the cookie that remembers if the user
                // has any logon form data.

                bh_setcookie("bh_logon", "1", time() + YEAR_IN_SECONDS);
            }

            return true;

        }else if (isset($luid) && $luid == -2) { // User is banned - everybody hide

            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
		exit;
            }else {
                echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
		exit;
            }

        }else {

            bh_setcookie("bh_logon", '1', time() + YEAR_IN_SECONDS);

            html_draw_top();

            echo "<div align=\"center\">\n";
            echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
            echo "<h2>{$lang['pleasereenterpasswd']}</h2>\n";

	    if ($logon_main) {

                if (isset($final_uri)) {
                    form_quick_button("./index.php", $lang['back'], "final_uri", rawurlencode($final_uri), "_top");
                }else {
                    form_quick_button("./index.php", $lang['back'], false, false, "_top");
                }

                echo "<hr width=\"350\" />\n";
                echo "<h2>{$lang['problemsloggingon']}</h2>\n";

                if (isset($final_uri)) {
                    $final_uri = rawurlencode($final_uri);
                    echo "<p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&deletecookie=yes&final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
                    echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
                }else {
                    echo "<p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
                    echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
                }

	    }else {

	        echo "</div>\n";
	        draw_logon_form();
	    }

            html_draw_bottom();
            exit;
        }
    }
}

function draw_logon_form($logon_main)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    // Retrieve existing cookie data if any

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

    // Has the 'Other' button been clicked?

    if (isset($_GET['other'])) {
        $otherlogon = true;
    }else {
        $otherlogon = false;
    }

    echo "<p>&nbsp;</p>\n";
    echo "<div align=\"center\">\n";

    if ($logon_main) {

        echo "  <form name=\"logonform\" action=\"". get_request_uri(). "\" method=\"post\" target=\"_top\" onsubmit=\"return has_clicked;\">\n";

    }else {

        echo "  <form name=\"logonform\" action=\"". get_request_uri(). "\" method=\"post\" target=\"_self\" onsubmit=\"return has_clicked;\">\n";

        foreach($_POST as $key => $value) {
	    form_input_hidden($key, _htmlentities(_stripslashes($value)));
        }
    }

    echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "      <tr>\n";
    echo "        <td>\n";
    echo "          <table class=\"subhead\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"subhead\" align=\"left\">Logon</td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "          <table class=\"posthead\" width=\"100%\">\n";

    if ((sizeof($username_array) > 1) && $otherlogon == false) {

        echo "          <tr>\n";
        echo "            <td align=\"right\">{$lang['username']}:</td>\n";
        echo "            <td>";

        foreach ($username_array as $key => $value) {
            $usernames[$key] = _stripslashes($value);
        }

        echo form_dropdown_array("logonarray", $usernames, $usernames, "", "onchange=\"changepassword()\" style=\"width: 135px\"");
        echo form_input_hidden("user_logon", _stripslashes($username_array[0]));

        for ($i = 0; $i < sizeof($username_array); $i++) {

            if (isset($password_array[$i]) && strlen($password_array[$i]) > 0) {

                if (isset($passhash_array[$i]) && is_md5($passhash_array[$i])) {

                    echo form_input_hidden("user_password$i", $password_array[$i]);
                    echo form_input_hidden("user_passhash$i", $passhash_array[$i]);

                }else {

                    echo form_input_hidden("user_password$i", "");
                    echo form_input_hidden("user_passhash$i", "");
                }

            }else {

                echo form_input_hidden("user_password$i", "");
                echo form_input_hidden("user_passhash$i", "");
            }
        }

        $request_uri = get_request_uri();

        if (strstr($request_uri, '?')) {
            $request_uri.= "&other=true";
        }else {
            $request_uri.= "?other=true";
        }

        echo "&nbsp;", form_button("other", "Other", "onclick=\"self.location.href='$request_uri';\""), "</td>\n";

        echo "          </tr>\n";
        echo "          <tr>\n";
        echo "            <td align=\"right\">{$lang['passwd']}:</td>\n";

        if (isset($password_array[0]) && strlen($password_array[0]) > 0) {
            if (isset($passhash_array[0]) && is_md5($passhash_array[0])) {
                echo "            <td>", form_input_password("user_password", $password_array[0]), form_input_hidden("user_passhash", $passhash_array[0]), "</td>\n";
            }else {
                echo "            <td>", form_input_password("user_password", ""), form_input_hidden("user_passhash", ""), "</td>\n";
            }
        }else {
            echo "            <td>", form_input_password("user_password", ""), form_input_hidden("user_passhash", ""), "</td>\n";
        }

        echo "          </tr>\n";

    }else {

        if ($otherlogon) {

            echo "          <tr>\n";
            echo "            <td align=\"right\">{$lang['username']}:</td>\n";
            echo "            <td>", form_input_text("user_logon", ""), "</td>\n";
            echo "          </tr>\n";
            echo "          <tr>\n";
            echo "            <td align=\"right\">{$lang['passwd']}:</td>\n";
            echo "            <td>", form_input_password("user_password", ""), "</td>\n";
            echo "          </tr>\n";
            echo "          </tr>\n";

        }else {

            echo "          <tr>\n";
            echo "            <td align=\"right\">{$lang['username']}:</td>\n";
            echo "            <td>", form_input_text("user_logon", (isset($username_array[0]) ? $username_array[0] : "")), "</td>\n";
            echo "          </tr>\n";
            echo "          <tr>\n";
            echo "            <td align=\"right\">{$lang['passwd']}:</td>\n";
            echo "            <td>", form_input_password("user_password", (isset($password_array[0]) ? $password_array[0] : "")), form_input_hidden("user_passhash", (isset($passhash_array[0]) ? $passhash_array[0] : "")), "</td>\n";
            echo "          </tr>\n";
            echo "          </tr>\n";
        }
    }

    echo "            <tr>\n";
    echo "              <td>&nbsp;</td>\n";
    echo "              <td>";

    echo form_checkbox("remember_user", "Y", $lang['rememberpasswds'], (isset($password_array[0]) && isset($passhash_array[0]) && $otherlogon == false));

    echo "</td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "          <table class=\"posthead\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td align=\"center\">", form_submit(md5(uniqid(rand())), $lang['logon'], 'onclick="has_clicked = true"'), "</td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "  </form>\n";

    if (user_guest_enabled()) {

        echo "  <form name=\"guest\" action=\"", get_request_uri(), "\" method=\"POST\" target=\"_top\">\n";
        echo "    <p class=\"smalltext\">{$lang['enterasa']} ". form_input_hidden("user_logon", "guest"). form_input_hidden("user_password", "guest"). form_submit(md5(uniqid(rand())), $lang['guest']). "</p>\n";
        echo "  </form>\n";
    }

    if (isset($final_uri)) {

        $final_uri = rawurlencode($final_uri);

        echo "  <p class=\"smalltext\">{$lang['donthaveanaccount']} <a href=\"register.php?webtag=$webtag&final_uri=$final_uri\" target=\"_self\">Register now.</a></p>\n";
        echo "  <hr width=\"350\" />\n";
        echo "  <h2>{$lang['problemsloggingon']}</h2>\n";
        echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&deletecookie=yes&final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
        echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";

    }else {

        echo "  <p class=\"smalltext\">{$lang['donthaveanaccount']} <a href=\"register.php?webtag=$webtag\" target=\"_self\">Register now.</a></p>\n";
        echo "  <hr width=\"350\" />\n";
        echo "  <h2>{$lang['problemsloggingon']}</h2>\n";
        echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
        echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
    }

    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['usingaPDA']}</h2>\n";
    echo "  <p class=\"smalltext\"><a href=\"llogon.php?webtag=$webtag\" target=\"_top\">{$lang['lightHTMLversion']}</a></p>\n";
    echo "</div>\n";
}

?>