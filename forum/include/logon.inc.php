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

/* $Id: logon.inc.php,v 1.102 2009-01-17 23:37:46 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function logon_get_cookies(&$username_array, &$password_array, &$passhash_array, &$auto_logon = false)
{
    // Username array

    if (!$username_array = bh_getcookie('bh_remember_username', 'is_array')) {
        $username_array = explode(",", stripslashes_array(bh_getcookie('bh_remember_username', 'strlen', '')));
    }

    // Password array

    if (!$password_array = bh_getcookie('bh_remember_password', 'is_array')) {
        $password_array = explode(",", stripslashes_array(bh_getcookie('bh_remember_password', 'strlen', '')));
    }

    // Passhash array

    if (!$passhash_array = bh_getcookie('bh_remember_passhash', 'is_array')) {
        $passhash_array = explode(",", stripslashes_array(bh_getcookie('bh_remember_passhash', 'strlen', '')));
    }
    
    // Auto Logon cookie
    
    $auto_logon = bh_getcookie('bh_auto_logon', 'Y');

    // Remove any invalid entries.

    $username_array = array_filter($username_array, 'strlen');
    $password_array = array_filter($password_array, 'strlen');
    $passhash_array = array_filter($passhash_array, 'strlen');
    
    // Check auto_logon cookie
    
    $auto_logon = (in_array($auto_logon, array('Y', 'N'))) ? $auto_logon : 'N';
}

function logon_update_logon_cookie($old_logon, $new_logon)
{
    logon_get_cookies($username_array, $password_array, $passhash_array);

    if (($key = array_isearch($old_logon, $username_array)) !== false) {

        $username_array[$key] = $new_logon;

        // Remove old format cookies

        while (list($key) = each($username_array)) {

            bh_setcookie("bh_remember_username[$key]", '', time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_password[$key]", '', time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_passhash[$key]", '', time() - YEAR_IN_SECONDS);
        }

        // New format cookies for 0.8 for better compatibility with more browsers.

        $username_cookie = implode(",", $username_array);
        $password_cookie = implode(",", $password_array);
        $passhash_cookie = implode(",", $passhash_array);

        // Set the cookies.

        bh_setcookie("bh_remember_username", $username_cookie, time() + YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_password", $password_cookie, time() + YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_passhash", $passhash_cookie, time() + YEAR_IN_SECONDS);
    }
}

function logon_update_password_cookie($logon, $password)
{
    logon_get_cookies($username_array, $password_array, $passhash_array);

    if (($key = array_isearch($logon, $username_array)) !== false) {

        $password_array[$key] = str_repeat(chr(32), mb_strlen($password));
        $passhash_array[$key] = md5($password);

        // Remove old format cookies

        while (list($key) = each($username_array)) {

            bh_setcookie("bh_remember_username[$key]", '', time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_password[$key]", '', time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_passhash[$key]", '', time() - YEAR_IN_SECONDS);
        }

        // New format cookies for 0.8 for better compatibility with more browsers.

        $username_cookie = implode(",", $username_array);
        $password_cookie = implode(",", $password_array);
        $passhash_cookie = implode(",", $passhash_array);

        // Set the cookies.

        bh_setcookie("bh_remember_username", $username_cookie, time() + YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_password", $password_cookie, time() + YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_passhash", $passhash_cookie, time() + YEAR_IN_SECONDS);
    }
}

function logon_update_cookies($logon, $password, $passhash, $save_password, $auto_logon)
{
    // Retrieve the existing cookies

    logon_get_cookies($username_array, $password_array, $passhash_array);

    // Light mode uses different cookies to the main site.
    // It also doesn't support multiple saved logons for
    // compatibility reasons so we simply overwrite the
    // existing saved details with the new ones.

    if (defined('BEEHIVEMODE_LIGHT')) {

        if ($save_password === true) {

            bh_setcookie("bh_light_remember_username", $logon, time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_light_remember_password", $password, time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_light_remember_passhash", $passhash, time() + YEAR_IN_SECONDS);
            
            if ($auto_logon === true) {
                bh_setcookie("bh_light_auto_logon", 'Y', time() + YEAR_IN_SECONDS);
            }

        }else {

            bh_setcookie("bh_light_remember_username", $logon, time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_light_remember_password", "", time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_light_remember_passhash", "", time() - YEAR_IN_SECONDS);
        }

    }else {

        // Search for the specified logon in the existing cookies
        // and remove it if it's found.

        if (($key = array_isearch($logon, $username_array)) !== false) {

            unset($username_array[$key]);
            unset($password_array[$key]);
            unset($passhash_array[$key]);
        }

        // Add the new logon to the top of the list.

        array_unshift($username_array, $logon);

        // Check to see if we're saving the password

        if ($save_password === true) {

            array_unshift($password_array, $password);
            array_unshift($passhash_array, $passhash);
            
            // Set the auto logon cookie if required.

            if ($auto_logon === true) {
                bh_setcookie("bh_auto_logon", 'Y', time() + YEAR_IN_SECONDS);
            }            

        }else {

            array_unshift($password_array, "");
            array_unshift($passhash_array, "");
        }

        // Remove old format cookies

        while (list($key) = each($username_array)) {

            bh_setcookie("bh_remember_username[$key]", '', time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_password[$key]", '', time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_passhash[$key]", '', time() - YEAR_IN_SECONDS);
        }

        // New format cookies for 0.8 for better compatibility with more browsers.

        $username_cookie = implode(",", $username_array);
        $password_cookie = implode(",", $password_array);
        $passhash_cookie = implode(",", $passhash_array);

        // Set the cookies.

        bh_setcookie("bh_remember_username", $username_cookie, time() + YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_password", $password_cookie, time() + YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_passhash", $passhash_cookie, time() + YEAR_IN_SECONDS);
    }
}

function logon_perform()
{
    $webtag = get_webtag();

    // Check to see if the user is logging in as a guest or a normal user.

    if (isset($_POST['guest_logon'])) {

        if (user_guest_enabled()) {

            if (forum_check_webtag_available($webtag)) {

                bh_setcookie("bh_{$webtag}_thread_mode", "1", time() - YEAR_IN_SECONDS);
                bh_setcookie("bh_{$webtag}_light_thread_mode", "1", time() - YEAR_IN_SECONDS);
            }

            bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);
            bh_session_init(0);
            return true;
        }

    }else if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

        // Prepare the form data.

        $logon    = stripslashes_array($_POST['user_logon']);
        $password = stripslashes_array($_POST['user_password']);

        // Check if the user wants to save their password.

        $save_password = isset($_POST['remember_user']) && ($_POST['remember_user'] == 'Y');
        
        // Check if the user wants to automatically logon.
        
        $auto_logon = isset($_POST['auto_logon']) && ($_POST['auto_logon'] == 'Y');

        // Check the password submitted by the user. If it's a string
        // which isn't all spaces (trim will make it's length 0) then
        // use that, otherwise check the user_passhash cookie.

        if (strlen(trim($password)) > 0) {

            $passhash = md5($password);
            $password = str_repeat(chr(32), mb_strlen($password));

        }else {

            if (isset($_POST['user_passhash']) && is_md5(stripslashes_array($_POST['user_passhash']))) {

                $passhash = stripslashes_array($_POST['user_passhash']);

            }else {

                return false;
            }
        }

        // Try and login the user. If we're successful we need to
        // update their cookies.

        if (($luid = user_logon($logon, $passhash))) {

            // Remove any previously set cookies

            if (forum_check_webtag_available($webtag)) {

                bh_setcookie("bh_{$webtag}_thread_mode", "1", time() - YEAR_IN_SECONDS);
                bh_setcookie("bh_{$webtag}_light_thread_mode", "1", time() - YEAR_IN_SECONDS);
            }

            bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);

            // Initialise a user session.

            bh_session_init($luid);

            // Update the cookies.

            logon_update_cookies($logon, $password, $passhash, $save_password, $auto_logon);

            return true;
        }
    }

    return false;
}

function logon_perform_auto()
{
    $webtag = get_webtag();
    
    forum_check_webtag_available($webtag);
    
    if (bh_getcookie("bh_auto_logon", "Y") && !bh_session_active()) {
    
        if (defined("BEEHIVEMODE_LIGHT")) {

            $user_logon = bh_getcookie('bh_light_remember_username', 'strlen', '');
            $user_passhash = bh_getcookie('bh_light_remember_passhash', 'strlen', '');        
            
            if (($uid = user_logon($user_logon, $user_passhash))) {

                bh_session_init($uid);
                echo "header_redirect(\"index.php?webtag=$webtag&noframes\");\n";
                exit;
            }            
            
        }else {
    
            logon_get_cookies($username_array, $password_array, $passhash_array);

            if (isset($username_array[0]) && strlen(trim($username_array[0])) > 0) {

                if (isset($passhash_array[0]) && is_md5($passhash_array[0])) {

                    $username = mb_strtoupper($username_array[0]);
                    $passhash = $passhash_array[0];

                    if (($uid = user_logon($username, $passhash))) {

                        bh_session_init($uid);

                        header_redirect(get_request_uri(true, false));
                        exit;
                    }
                }
            }
        }
    }
    
    return false;
}        
    
function logon_draw_form($logon_options)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    // Make sure logon form argument is valid.

    if (!is_numeric($logon_options)) $logon_options = LOGON_FORM_DEFAULT;

    // Clean the logon cookie so we don't bounce to the logon screen.

    bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);

    // Retrieve existing cookie data if any

    logon_get_cookies($username_array, $password_array, $passhash_array);

    // If the user clicked the 'Other' button we need to
    // hide the logon dropdown and replace it with a normal
    // text field to allow them to type their username.

    $other_logon = (isset($_GET['other_logon']) || isset($_POST['other_logon'])) ? true : false;

    // Check for previously failed logon.

    if (isset($_GET['logout_success']) && $_GET['logout_success'] == 'true') {
        html_display_success_msg($lang['youhavesuccessfullyloggedout'], '500', 'center');
    }else if (isset($_GET['logon_failed']) && !($logon_options & LOGON_FORM_SESSION_EXPIRED)) {
        html_display_error_msg($lang['usernameorpasswdnotvalid'], '500', 'center');
    }

    // Get the original requested page url.

    $request_uri = get_request_uri();

    // If the request is for logon.php then we are performing
    // a normal login, otherwise potentially a failed session.

    if (stristr($request_uri, 'logon.php')) {

        echo "  <form accept-charset=\"utf-8\" name=\"logonform\" method=\"post\" action=\"$request_uri\" target=\"", html_get_top_frame_name(), "\">\n";

    }else {

        echo "  <form accept-charset=\"utf-8\" name=\"logonform\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
    }

    // Check for any post data that we need to include in the form.

    logon_unset_post_data();

    if (isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) {
        echo form_input_hidden_array(stripslashes_array($_POST));
    }

    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"320\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['logon']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"90%\">\n";

    if ((sizeof($username_array) > 1) && $other_logon === false) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"90\">{$lang['username']}:</td>\n";
        echo "                        <td align=\"left\" nowrap=\"nowrap\">";

        $username_dropdown_array = array_flip(htmlentities_array($username_array));
        array_walk($username_dropdown_array, create_function('&$item, $key', '$item = $key;'));

        $username_dropdown_other = array(0 => array('name' => $lang['otherdotdotdot'], 'class' => 'bhlogonother'));
        $username_dropdown_array = array_merge($username_dropdown_array, $username_dropdown_other);

        reset($username_array);
        reset($password_array);
        reset($passhash_array);

        $current_logon = key($username_array);

        echo form_dropdown_array("logonarray", $username_dropdown_array, "", "onchange=\"changePassword('$webtag')\" autocomplete=\"off\"", "bhlogondropdown");
        echo form_input_hidden("user_logon", htmlentities_array($username_array[$current_logon]));

        $username_array_keys = array_keys($username_array);

        foreach ($username_array_keys as $username_key) {

            if (isset($password_array[$username_key]) && strlen($password_array[$username_key]) > 0) {

                if (isset($passhash_array[$username_key]) && is_md5($passhash_array[$username_key])) {

                    echo form_input_hidden("user_password$username_key", htmlentities_array($password_array[$username_key]));
                    echo form_input_hidden("user_passhash$username_key", htmlentities_array($passhash_array[$username_key]));

                }else {

                    echo form_input_hidden("user_password$username_key", "");
                    echo form_input_hidden("user_passhash$username_key", "");
                }

            }else {

                echo form_input_hidden("user_password$username_key", "");
                echo form_input_hidden("user_passhash$username_key", "");
            }
        }

        echo "                        </td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">{$lang['passwd']}:</td>\n";

        if (isset($password_array[$current_logon]) && strlen($password_array[$current_logon]) > 0) {

            if (isset($passhash_array[$current_logon]) && is_md5($passhash_array[$current_logon])) {

                echo "                        <td align=\"left\">", form_input_password("user_password", htmlentities_array($password_array[$current_logon]), 24, false, "autocomplete=\"off\"", "bhinputlogon"), form_input_hidden("user_passhash", htmlentities_array($passhash_array[$current_logon])), "</td>\n";

            }else {

                echo "                        <td align=\"left\">", form_input_password("user_password", "", 24, false, "autocomplete=\"off\"", "bhinputlogon"), form_input_hidden("user_passhash", ""), "</td>\n";
            }

        }else {

            echo "                        <td align=\"left\">", form_input_password("user_password", "", 24, false, "autocomplete=\"off\"", "bhinputlogon"), form_input_hidden("user_passhash", ""), "</td>\n";
        }

        echo "                      </tr>\n";

    }else {

        if ($other_logon === true) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"90\">{$lang['username']}:</td>\n";
            echo "                        <td align=\"left\">", form_input_text("user_logon", "", 24, 15, "onchange=\"clearPassword()\" autocomplete=\"off\"", "bhinputlogon"), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"90\">{$lang['passwd']}:</td>\n";
            echo "                        <td align=\"left\">", form_input_password("user_password", "", 24, 32, "autocomplete=\"off\"", "bhinputlogon"), "</td>\n";
            echo "                      </tr>\n";

        }else {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"90\">{$lang['username']}:</td>\n";
            echo "                        <td align=\"left\">", form_input_text("user_logon", (isset($username_array[0]) ? htmlentities_array($username_array[0]) : ""), 24, 32, "onchange=\"clearPassword()\" autocomplete=\"off\"", "bhinputlogon"), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"90\">{$lang['passwd']}:</td>\n";
            echo "                        <td align=\"left\">", form_input_password("user_password", (isset($password_array[0]) ? htmlentities_array($password_array[0]) : ""), 24, 32, "autocomplete=\"off\"", "bhinputlogon"), form_input_hidden("user_passhash", (isset($passhash_array[0]) ? htmlentities_array($passhash_array[0]) : "")), "</td>\n";
            echo "                      </tr>\n";
        }
    }

    if (!($logon_options & LOGON_FORM_HIDE_TICKBOX)) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">", form_checkbox("remember_user", "Y", $lang['rememberpasswds'], (isset($password_array[0]) && strlen($password_array[0]) > 0 && isset($passhash_array[0]) && strlen($passhash_array[0]) > 0 && $other_logon === false), "autocomplete=\"off\" onclick=\"toogleAutoLogon()\""), "</td>\n";
        echo "                      </tr>\n";
        
        if (!($logon_options & LOGON_FORM_SESSION_EXPIRED)) {
        
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">", form_checkbox("auto_logon", "Y", $lang['logmeinautomatically'], false, "autocomplete=\"off\" onclick=\"changeAutoLogon()\""), "</td>\n";
            echo "                      </tr>\n";
        }        
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";        
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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";        
    echo "    </tr>\n";    
    echo "    <tr>\n";
    echo "      <td align=\"center\" colspan=\"2\">", form_submit('logon', $lang['logonbutton']), "</td>\n";
    echo "    </tr>\n";    
    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";

    if (!($logon_options & LOGON_FORM_HIDE_LINKS)) {
    
        echo "<hr class=\"bhlogonseparator\" />\n";

        if (user_guest_enabled()) {

            echo "<form accept-charset=\"utf-8\" name=\"guest\" action=\"logon.php?webtag=$webtag\" method=\"post\" target=\"", html_get_top_frame_name(), "\">\n";
            echo "  <p class=\"smalltext\">", sprintf($lang['enterasa'], form_submit('guest_logon', $lang['guest'])), "</p>\n";
            echo "</form>\n";
        }

        if (isset($_GET['final_uri']) && strlen(trim(stripslashes_array($_GET['final_uri']))) > 0) {

            $final_uri = rawurlencode(trim(stripslashes_array($_GET['final_uri'])));

            $register_link = rawurlencode("register.php?webtag=$webtag&final_uri=$final_uri");
            $forgot_pw_link = rawurlencode("forgot_pw.php?webtag=$webtag&final_uri=$final_uri");

            echo "<p class=\"smalltext\">", sprintf($lang['donthaveanaccount'], "<a href=\"index.php?webtag=$webtag&amp;final_uri=$register_link\" target=\"". html_get_top_frame_name(). "\">{$lang['registernow']}</a>"), "</p>\n";
            echo "<hr class=\"bhlogonseparator\" />\n";
            echo "<h2>{$lang['problemsloggingon']}</h2>\n";
            echo "<p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"", html_get_top_frame_name(), "\">{$lang['deletecookies']}</a></p>\n";
            echo "<p class=\"smalltext\"><a href=\"index.php?webtag=$webtag&amp;final_uri=$forgot_pw_link\" target=\"", html_get_top_frame_name(), "\">{$lang['forgottenpasswd']}</a></p>\n";

        }else {

            echo "<p class=\"smalltext\">", sprintf($lang['donthaveanaccount'], "<a href=\"index.php?webtag=$webtag&amp;final_uri=register.php%3Fwebtag%3D$webtag\" target=\"". html_get_top_frame_name(). "\">{$lang['registernow']}</a>"), "</p>\n";
            echo "<hr class=\"bhlogonseparator\" />\n";
            echo "<h2>{$lang['problemsloggingon']}</h2>\n";
            echo "<p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"", html_get_top_frame_name(), "\">{$lang['deletecookies']}</a></p>\n";
            echo "<p class=\"smalltext\"><a href=\"index.php?webtag=$webtag&amp;final_uri=forgot_pw.php%3Fwebtag%3D$webtag\" target=\"", html_get_top_frame_name(), "\">{$lang['forgottenpasswd']}</a></p>\n";
        }

        echo "<hr class=\"bhlogonseparator\" />\n";
        echo "<h2>{$lang['usingaPDA']}</h2>\n";
        echo "<p class=\"smalltext\"><a href=\"index.php?webtag=$webtag&amp;noframes\" target=\"", html_get_top_frame_name(), "\">{$lang['lightHTMLversion']}</a></p>\n";
    }
}

function logon_unset_post_data()
{
    if (!$username_array = bh_getcookie('bh_remember_username', 'is_array')) {
        $username_array = explode(",", stripslashes_array(bh_getcookie('bh_remember_username', 'strlen', '')));
    }

    for ($i = 0; $i < sizeof($username_array); $i++) {
        unset($_POST["user_password$i"], $_POST["user_passhash$i"]);
    }

    unset($_POST['user_logon'], $_POST['user_password'], $_POST['user_passhash'], $_POST['other_logon']);
    unset($_POST['remember_user'], $_POST['logon'], $_POST['logonarray'], $_POST['webtag'], $_POST['register']);
}

?>