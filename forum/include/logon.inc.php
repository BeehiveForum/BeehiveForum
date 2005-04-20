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

/* $Id: logon.inc.php,v 1.26 2005-04-20 18:42:35 decoyduck Exp $ */

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

function perform_logon($logon_main)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

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

    if (isset($_POST['guest_logon'])) {

        if (user_guest_enabled()) {

            bh_session_init(0);
            return true;
        }

    }else if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

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

            return true;

        }else if (isset($luid) && $luid == -2) {

            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
            }

            echo "<h2>HTTP/1.0 500 Internal Server Error</h2>\n";
            exit;
        }
    }

    if ($logon_main) return false;

    echo "<div align=\"center\">\n";
    echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
    echo "<h2>{$lang['pleasereenterpasswd']}</h2>\n";

    return false;
}

function draw_logon_form($logon_main)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

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

    echo "<div align=\"center\">\n";

    if ($logon_main) {

        echo "  <br />\n";
        echo "  <form name=\"logonform\" action=\"". get_request_uri(). "\" method=\"post\" target=\"_top\" onsubmit=\"return has_clicked;\">\n";

    }else {

        echo "  <h2>Your session has expired. You will need to login again to continue.</h2>\n";
        echo "  <br />\n";
        echo "  <form name=\"logonform\" action=\"". get_request_uri(). "\" method=\"post\" target=\"_self\" onsubmit=\"return has_clicked;\">\n";

        foreach($_POST as $key => $value) {
            echo "    ", form_input_hidden($key, _htmlentities(_stripslashes($value))), "\n";
        }
    }

    echo "    ", form_input_hidden('webtag', $webtag), "\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "      <tr>\n";
    echo "        <td>\n";
    echo "          <table class=\"box\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td class=\"subhead\" colspan=\"2\">Logon</td>\n";
    echo "                  </tr>\n";

    if ((sizeof($username_array) > 1) && $otherlogon == false) {

        echo "                <tr>\n";
        echo "                  <td align=\"right\">{$lang['username']}:</td>\n";
        echo "                  <td>";

        foreach ($username_array as $key => $value) {
            $usernames[$key] = _stripslashes($value);
        }

        echo form_dropdown_array("logonarray", $usernames, $usernames, "", "onchange=\"changepassword()\"", "logon_dropdown");
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
            $request_uri.= "&amp;other=true";
        }else {
            $request_uri.= "?other=true";
        }

        echo "      &nbsp;", form_button("other", "Other", "onclick=\"self.location.href='$request_uri';\""), "</td>\n";

        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"right\">{$lang['passwd']}:</td>\n";

        if (isset($password_array[0]) && strlen($password_array[0]) > 0) {
            if (isset($passhash_array[0]) && is_md5($passhash_array[0])) {
                echo "                  <td>", form_input_password("user_password", $password_array[0]), form_input_hidden("user_passhash", $passhash_array[0]), "</td>\n";
            }else {
                echo "                  <td>", form_input_password("user_password", ""), form_input_hidden("user_passhash", ""), "</td>\n";
            }
        }else {
            echo "                  <td>", form_input_password("user_password", ""), form_input_hidden("user_passhash", ""), "</td>\n";
        }

        echo "                </tr>\n";

    }else {

        if ($otherlogon) {

            echo "                <tr>\n";
            echo "                  <td align=\"right\">{$lang['username']}:</td>\n";
            echo "                  <td>", form_input_text("user_logon", ""), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"right\">{$lang['passwd']}:</td>\n";
            echo "                  <td>", form_input_password("user_password", ""), "</td>\n";
            echo "                </tr>\n";

        }else {

            echo "                <tr>\n";
            echo "                  <td align=\"right\">{$lang['username']}:</td>\n";
            echo "                  <td>", form_input_text("user_logon", (isset($username_array[0]) ? $username_array[0] : "")), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"right\">{$lang['passwd']}:</td>\n";
            echo "                  <td>", form_input_password("user_password", (isset($password_array[0]) ? $password_array[0] : "")), form_input_hidden("user_passhash", (isset($passhash_array[0]) ? $passhash_array[0] : "")), "</td>\n";
            echo "                </tr>\n";
        }
    }

    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    echo "                    <td>", form_checkbox("remember_user", "Y", $lang['rememberpasswds'], (isset($password_array[0]) && isset($passhash_array[0]) && $otherlogon == false)), "</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"center\" colspan=\"2\">", form_submit(uniqid('bh'), $lang['logon'], 'onclick="has_clicked = true"'), "</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";
    echo "  </form>\n";
}

?>