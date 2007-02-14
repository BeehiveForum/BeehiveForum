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

/* $Id: edit_prefs.php,v 1.62 2007-02-14 22:54:40 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// User's UID
$uid = bh_session_get_value('UID');

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Get user information
$user_info = user_get($uid);

// Clear the error string
$error_html = "";

// Initialise the global prefs array

$user_prefs_global = array();

if (isset($_POST['submit'])) {

    $valid = true;

    // Required Fields

    if (isset($_POST['nickname']) && strlen(trim(_stripslashes($_POST['nickname']))) > 0) {

        $user_info['LOGON'] = trim(_stripslashes($_POST['logon']));

        if (!preg_match("/^[a-z0-9_-]+$/i", $user_info['LOGON'])) {
            $error_html.= "<h2>{$lang['usernameinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen($user_info['LOGON']) < 2) {
            $error_html.= "<h2>{$lang['usernametooshort']}</h2>\n";
            $valid = false;
        }

        if (strlen($user_info['LOGON']) > 15) {
            $error_html.= "<h2>{$lang['usernametoolong']}</h2>\n";
            $valid = false;
        }

        if (logon_is_banned($user_info['LOGON'])) {

            $error_html.= "<h2>{$lang['logonnotpermitted']}</h2>\n";
            $valid = false;
        }

        if (user_exists($user_info['LOGON'], $uid)) {

            $error_html.= "<h2>{$lang['usernameexists']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['usernamerequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['nickname']) && strlen(trim(_stripslashes($_POST['nickname']))) > 0) {

        $user_info['NICKNAME'] = trim(_stripslashes($_POST['nickname']));

        if (nickname_is_banned($user_info['NICKNAME'])) {

            $error_html.= "<h2>{$lang['nicknamenotpermitted']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['email']) && strlen(trim(_stripslashes($_POST['email']))) > 0) {

        $user_info['EMAIL'] = trim(_stripslashes($_POST['email']));

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $user_info['EMAIL'])) {

            $error_html.= "<h2>{$lang['invalidemailaddressformat']}</h2>\n";
            $valid = false;

        }else {

            if (email_is_banned($user_info['EMAIL'])) {

                $error_html.= "<h2>{$lang['emailaddressnotpermitted']}</h2>\n";
                $valid = false;
            }

            if (forum_get_setting('require_unique_email', 'Y') && !email_is_unique($user_info['EMAIL'])) {

                $error_html.= "<h2>{$lang['emailaddressalreadyinuse']}</h2>\n";
                $valid = false;
            }
        }

    }else {

        $error_html.= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && @checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

        $dob['DAY']   = trim(_stripslashes($_POST['dob_day']));
        $dob['MONTH'] = trim(_stripslashes($_POST['dob_month']));
        $dob['YEAR']  = trim(_stripslashes($_POST['dob_year']));

        $user_prefs['DOB'] = sprintf("%04d-%02d-%02d", $dob['YEAR'], $dob['MONTH'], $dob['DAY']);

    }else {

        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($_POST['firstname'])) {

        $user_prefs['FIRSTNAME'] = trim(_stripslashes($_POST['firstname']));

        if (!user_check_pref('FIRSTNAME', $user_prefs['FIRSTNAME'])) {

            $error_html.= "<h2>{$lang['firstname']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['lastname'])) {

        $user_prefs['LASTNAME'] = trim(_stripslashes($_POST['lastname']));

        if (!user_check_pref('LASTNAME', $user_prefs['LASTNAME'])) {

            $error_html.= "<h2>{$lang['lastname']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['homepage_url'])) {

        $user_prefs['HOMEPAGE_URL'] = trim(_stripslashes($_POST['homepage_url']));
        $user_prefs_global['HOMEPAGE_URL'] = (isset($_POST['homepage_url_global']) && $_POST['homepage_url_global'] == "Y") ? true : false;

        if (!user_check_pref('HOMEPAGE_URL', $user_prefs['HOMEPAGE_URL'])) {

            $error_html.= "<h2>{$lang['homepageURL']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['pic_url'])) {

        $user_prefs['PIC_URL'] = trim(_stripslashes($_POST['pic_url']));
        $user_prefs_global['PIC_URL'] = (isset($_POST['pic_url_global']) && $_POST['pic_url_global'] == "Y") ? true : false;

        if (!user_check_pref('PIC_URL', $user_prefs['PIC_URL'])) {

            $error_html.= "<h2>{$lang['pictureURL']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if ($valid) {

        // Update basic settings in USER table

        user_update($uid, $user_info['LOGON'], $user_info['NICKNAME'], $user_info['EMAIL']);

        // Update USER_PREFS

        user_update_prefs($uid, $user_prefs, $user_prefs_global);

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid, false);

        // Username array

        if (isset($_COOKIE['bh_remember_username']) && is_array($_COOKIE['bh_remember_username'])) {
            $username_array = $_COOKIE['bh_remember_username'];
        }elseif (isset($_COOKIE['bh_remember_username']) && strlen($_COOKIE['bh_remember_username']) > 0) {
            $username_array = explode(",", $_COOKIE['bh_remember_username']);
        }else {
            $username_array = array();
        }

        // Password array

        if (isset($_COOKIE['bh_remember_password']) && is_array($_COOKIE['bh_remember_password'])) {
            $password_array = $_COOKIE['bh_remember_password'];
        }elseif (isset($_COOKIE['bh_remember_password']) && strlen($_COOKIE['bh_remember_password']) > 0) {
            $password_array = explode(",", $_COOKIE['bh_remember_password']);
        }else {
            $password_array = array();
        }

        // Passhash array

        if (isset($_COOKIE['bh_remember_passhash']) && is_array($_COOKIE['bh_remember_passhash'])) {
            $passhash_array = $_COOKIE['bh_remember_passhash'];
        }elseif (isset($_COOKIE['bh_remember_passhash']) && strlen($_COOKIE['bh_remember_passhash']) > 0) {
            $passhash_array = explode(",", $_COOKIE['bh_remember_passhash']);
        }else {
            $passhash_array = array();
        }

        // Update the logon that matches the current user

        $logon = bh_session_get_value('LOGON');

        if (($key = _array_search($logon, $username_array)) !== false) {

            $username_array[$key] = $user_info['LOGON'];

            // Remove old 0.7.1 and older cookies

            for ($i = 0; $i < sizeof($username_array); $i++) {

                bh_setcookie("bh_remember_username[$i]", '', time() - YEAR_IN_SECONDS);
                bh_setcookie("bh_remember_password[$i]", '', time() - YEAR_IN_SECONDS);
                bh_setcookie("bh_remember_passhash[$i]", '', time() - YEAR_IN_SECONDS);
            }

            // New format cookies for 0.7.2 for better compatibility with more browsers.

            $username_cookie = implode(",", $username_array);
            $password_cookie = implode(",", $password_array);
            $passhash_cookie = implode(",", $passhash_array);

            // Set the cookies.

            bh_setcookie("bh_remember_username", $username_cookie, time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_password", $password_cookie, time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_passhash", $passhash_cookie, time() + YEAR_IN_SECONDS);
        }

        header_redirect("./edit_prefs.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
    }
}

// Split the DOB into usable variables.

if (isset($user_prefs['DOB']) && preg_match("/\d{4,}-\d{2,}-\d{2,}/", $user_prefs['DOB'])) {

    if (!isset($dob['YEAR']) || !isset($dob['MONTH']) || !isset($dob['DAY'])) {

        list($dob['YEAR'], $dob['MONTH'], $dob['DAY']) = explode('-', $user_prefs['DOB']);
    }

    $dob['BLANK_FIELDS'] = ($dob['YEAR'] == 0 || $dob['MONTH'] == 0 || $dob['DAY'] == 0) ? true : false;

}else {

    $dob['YEAR']  = 0;
    $dob['MONTH'] = 0;
    $dob['DAY']   = 0;
    $dob['BLANK_FIELDS'] = true;
}

// Check to see if we should show the set for all forums checkboxes

$show_set_all = (forums_get_available_count() > 1) ? true : false;

// Start Output Here

html_draw_top();

echo "<h1>{$lang['userdetails']}</h1>\n";

// Any error messages to display?

echo $error_html;
if (isset($_GET['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_prefs.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userinformation']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['memberno']}:&nbsp;</td>\n";
echo "                        <td align=\"left\" colspan=\"2\">#{$user_info['UID']}&nbsp;</td>\n";
echo "                      </tr>\n";

if (forum_get_setting('allow_username_changes', 'Y')) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['username']}:&nbsp;</td>\n";
    echo "                        <td align=\"left\" colspan=\"2\">", form_field("logon", (isset($user_info['LOGON']) ? $user_info['LOGON'] : ""), 45, 15), "&nbsp;</td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['username']}:&nbsp;</td>\n";
    echo "                        <td align=\"left\" colspan=\"2\">{$user_info['LOGON']}&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_field("nickname", (isset($user_info['NICKNAME']) ? $user_info['NICKNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['emailaddress']}:&nbsp;</td>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_field("email", (isset($user_info['EMAIL']) ? $user_info['EMAIL'] : ""), 45, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['firstname']}:&nbsp;</td>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_field("firstname", (isset($user_prefs['FIRSTNAME']) ? $user_prefs['FIRSTNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['lastname']}:&nbsp;</td>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_field("lastname", (isset($user_prefs['LASTNAME']) ? $user_prefs['LASTNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['dateofbirth']}:&nbsp;</td>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\" colspan=\"2\">", form_dob_dropdowns($dob['YEAR'], $dob['MONTH'], $dob['DAY'], $dob['BLANK_FIELDS']), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">{$lang['homepageURL']}:&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_field("homepage_url", (isset($user_prefs['HOMEPAGE_URL']) ? $user_prefs['HOMEPAGE_URL'] : ""), 45, 255), "&nbsp;</td>\n";
echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("homepage_url_global", "Y", $lang['setforallforums'], (isset($user_prefs['HOMEPAGE_URL_GLOBAL']) ? $user_prefs['HOMEPAGE_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">{$lang['pictureURL']}:&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_field("pic_url", (isset($user_prefs['PIC_URL']) ? $user_prefs['PIC_URL'] : ""), 45, 255), "&nbsp;</td>\n";
echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", $lang['setforallforums'], (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>
