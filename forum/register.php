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

/* $Id: register.php,v 1.132 2006-10-22 16:24:32 decoyduck Exp $ */

/**
* Displays and processes registration forms
*/

/**
*/

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "text_captcha.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Where are we going after we've logged on?

if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {
    $final_uri = basename(trim(_stripslashes(rawurldecode($_GET['final_uri']))));
}

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Load language file

$lang = load_language_file();

// Make sure we have a webtag

$webtag = get_webtag($webtag_search);

// check to see if user registration is available

if (forum_get_setting('allow_new_registrations', 'N')) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['newuserregistrationsarenotpermitted']}</h2>\n";
    html_draw_bottom();
    exit;
}

$available_styles = styles_get_available();
$available_emoticons = emoticons_get_available();
$available_langs = lang_get_available();

$available_langs_labels = array_merge(array($lang['browsernegotiation']), $available_langs);
array_unshift($available_langs, "");

// Timezones

$timezones = array("(GMT -12:00) Enitwetok, Kwajalein",
                   "(GMT -11:00) Midway Island, Samoa",
                   "(GMT -10:00) Hawaii",
                   "(GMT -09:30) Isle Marquises",
                   "(GMT -09:00) Alaska",
                   "(GMT -08:00) Pacific Time (US &amp; Canada)",
                   "(GMT -07:00) Mountain Time (US &amp; Canada)",
                   "(GMT -06:00) Central Time (US &amp; Canada)",
                   "(GMT -05:00) Eastern Time (US &amp; Canada)",
                   "(GMT -04:00) Atlantic Time (Canada)",
                   "(GMT -03:30) Newfoundland",
                   "(GMT -03:00) Brazil, Buenos Aires",
                   "(GMT -02:00) Mid-Atlantic",
                   "(GMT -01:00) Azores, Cape Verde Islands",
                   "(GMT) Casablanca, Dublin, London, Lisbon, Monrovia",
                   "(GMT +01:00) CET (Central Europe Time)",
                   "(GMT +02:00) EET (Eastern Europe Time)",
                   "(GMT +03:00) Baghdad, Kuwait, Riyadh",
                   "(GMT +03:30) Tehran",
                   "(GMT +04:00) Abu Dhabi, Muscat",
                   "(GMT +04:30) Kabul",
                   "(GMT +05:00) Ekaterinburg, Islamabad",
                   "(GMT +05:30) Bombay, Calcutta",
                   "(GMT +06:00) Almaty, Dhaka, Colombo",
                   "(GMT +07:00) Bangkok, Hanoi",
                   "(GMT +08:00) Beijing, Perth",
                   "(GMT +09:00) Tokyo, Seoul, Osaka",
                   "(GMT +09:30) Adelaide, Darwin",
                   "(GMT +10:00) East Australian Standard Time",
                   "(GMT +11:00) Magadan, Solomon Islands",
                   "(GMT +12:00) Auckland, Wellington");

$timezones_data = array(-12, -11, -10, -9.5, -9, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, 0,
                        1, 2, 3, 3.5, 4, 4.5, 5, 5.5, 6, 7, 8, 9, 9.5, 10, 11, 12);

$text_captcha = new captcha(6, 15, 25, 9, 30);

if (isset($_POST['submit'])) {

    $valid = true;
    $error_html = "";

    if (isset($_POST['LOGON']) && strlen(trim(_stripslashes($_POST['LOGON']))) > 0) {

        $new_user['LOGON'] = strtoupper(trim(_stripslashes($_POST['LOGON'])));

        if (!preg_match("/^[a-z0-9_-]+$/i", $new_user['LOGON'])) {
            $error_html.= "<h2>{$lang['usernameinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen($new_user['LOGON']) < 2) {
            $error_html.= "<h2>{$lang['usernametooshort']}</h2>\n";
            $valid = false;
        }

        if (strlen($new_user['LOGON']) > 15) {
            $error_html.= "<h2>{$lang['usernametoolong']}</h2>\n";
            $valid = false;
        }

        if (logon_is_banned($new_user['LOGON'])) {

            $error_html.= "<h2>{$lang['logonnotpermitted']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['usernamerequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['PW']) && strlen(trim(_stripslashes($_POST['PW']))) > 0) {

        $new_user['PW'] = trim(_stripslashes($_POST['PW']));

        if (!preg_match("/^[a-z0-9_-]+$/i", $new_user['PW'])) {
            $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen($new_user['PW']) < 6) {
            $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
        $valid.= false;
    }

    if (isset($_POST['CPW']) && strlen(trim(_stripslashes($_POST['CPW']))) > 0) {

        $new_user['CPW'] = trim(_stripslashes($_POST['CPW']));

        if (_htmlentities($new_user['CPW']) != $new_user['CPW']) {
            $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['confirmationpasswdrequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['NICKNAME']) && strlen(trim(_stripslashes($_POST['NICKNAME']))) > 0) {

        $new_user['NICKNAME'] = trim(_stripslashes($_POST['NICKNAME']));

        if (nickname_is_banned($new_user['NICKNAME'])) {

            $error_html.= "<h2>{$lang['nicknamenotpermitted']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['EMAIL']) && strlen(trim(_stripslashes($_POST['EMAIL']))) > 0) {

        $new_user['EMAIL'] = trim(_stripslashes($_POST['EMAIL']));

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $new_user['EMAIL'])) {

            $error_html.= "<h2>{$lang['invalidemailaddressformat']}</h2>\n";
            $valid = false;

        }else {

            if (email_is_banned($new_user['EMAIL'])) {

                $error_html.= "<h2>{$lang['emailaddressnotpermitted']}</h2>\n";
                $valid = false;
            }

            if (forum_get_setting('require_unique_email', 'Y') && !email_is_unique($new_user['EMAIL'])) {

                $error_html.= "<h2>{$lang['emailaddressalreadyinuse']}</h2>\n";
                $valid = false;
            }
        }

    }else {

        $error_html.= "<h2>{$lang['emailrequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && @checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

        $new_user['DOB_DAY']   = trim(_stripslashes($_POST['dob_day']));
        $new_user['DOB_MONTH'] = trim(_stripslashes($_POST['dob_month']));
        $new_user['DOB_YEAR']  = trim(_stripslashes($_POST['dob_year']));

        $new_user['DOB'] = "{$new_user['DOB_YEAR']}-{$new_user['DOB_MONTH']}-{$new_user['DOB_DAY']}";
        $new_user['DOB_BLANK_FIELDS'] = ($new_user['DOB_YEAR'] == 0 || $new_user['DOB_MONTH'] == 0 || $new_user['DOB_DAY'] == 0) ? true : false;

    }else {

        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['FIRSTNAME']) && strlen(trim(_stripslashes($_POST['FIRSTNAME']))) > 0) {
        $new_user['FIRSTNAME'] = trim(_stripslashes($_POST['FIRSTNAME']));
    }else {
        $new_user['FIRSTNAME'] = "";
    }

    if (isset($_POST['LASTNAME']) && strlen(trim(_stripslashes($_POST['LASTNAME']))) > 0) {
        $new_user['LASTNAME'] = trim(_stripslashes($_POST['LASTNAME']));
    }else {
        $new_user['LASTNAME'] = "";
    }

    if (isset($_POST['SIG_CONTENT']) && strlen(trim(_stripslashes($_POST['SIG_CONTENT']))) > 0) {
        $new_user['SIG_CONTENT'] = trim(_stripslashes($_POST['SIG_CONTENT']));
    }else {
        $new_user['SIG_CONTENT'] = "";
    }

    if (isset($_POST['SIG_HTML']) && $_POST['SIG_HTML'] == "Y") {
        $new_user['SIG_CONTENT'] = fix_html($new_user['SIG_CONTENT']);
        $new_user['SIG_HTML'] = "Y";
    }else {
        $new_user['SIG_CONTENT'] = _stripslashes($new_user['SIG_CONTENT']);
        $new_user['SIG_HTML'] = "N";
    }

    if (isset($_POST['EMAIL_NOTIFY']) && $_POST['EMAIL_NOTIFY'] == "Y") {
        $new_user['EMAIL_NOTIFY'] = "Y";
    }else {
        $new_user['EMAIL_NOTIFY'] = "N";
    }

    if (isset($_POST['PM_NOTIFY_EMAIL']) && $_POST['PM_NOTIFY_EMAIL'] == "Y") {
        $new_user['PM_NOTIFY_EMAIL'] = "Y";
    }else {
        $new_user['PM_NOTIFY_EMAIL'] = "N";
    }

    if (isset($_POST['PM_NOTIFY']) && $_POST['PM_NOTIFY'] == "Y") {
        $new_user['PM_NOTIFY'] = "Y";
    }else {
        $new_user['PM_NOTIFY'] = "N";
    }

    if (isset($_POST['MARK_AS_OF_INT']) && $_POST['MARK_AS_OF_INT'] == "Y") {
        $new_user['MARK_AS_OF_INT'] = "Y";
    }else {
        $new_user['MARK_AS_OF_INT'] = "N";
    }

    if (isset($_POST['DL_SAVING']) && $_POST['DL_SAVING'] == "Y") {
        $new_user['DL_SAVING'] = "Y";
    }else {
        $new_user['DL_SAVING'] = "N";
    }

    if (isset($_POST['TIMEZONE']) && in_array($_POST['TIMEZONE'], $timezones_data)) {
        $new_user['TIMEZONE'] = $_POST['TIMEZONE'];
    }else {
        $new_user['TIMEZONE'] = 0;
    }

    if (isset($_POST['LANGUAGE']) && in_array($_POST['LANGUAGE'], $available_langs_labels)) {
        $new_user['LANGUAGE'] = $_POST['LANGUAGE'];
    }else {
        $new_user['LANGUAGE'] = forum_get_setting('default_language', false, 'en');
    }

    if (isset($_POST['STYLE']) && in_array($_POST['STYLE'], array_keys($available_styles))) {
        $new_user['STYLE'] = $_POST['STYLE'];
    }else {
        $new_user['STYLE'] = forum_get_setting('default_style', false, 'default');
    }

    if (isset($_POST['EMOTICONS']) && in_array($_POST['EMOTICONS'], $available_emoticons)) {
        $new_user['EMOTICONS'] = $_POST['EMOTICONS'];
    }else {
        $new_user['EMOTICONS'] = forum_get_setting('default_emoticons', false, 'default');
    }

    if (forum_get_setting('text_captcha_enabled', 'Y')) {

        if (isset($_POST['public_key']) && strlen(trim(_stripslashes($_POST['public_key']))) > 0) {

            $public_key = trim(_stripslashes($_POST['public_key']));

            $text_captcha->destroy_image();

            if (isset($_POST['private_key']) && strlen(trim(_stripslashes($_POST['private_key']))) > 0) {
                $private_key = trim(_stripslashes($_POST['private_key']));
            }else {
                $error_html.= "<h2>{$lang['textcaptchamissingkey']}</h2>\n";
                $valid = false;
            }

            if ($valid) {

                $text_captcha->set_public_key($public_key);

                if (!$text_captcha->verify_keys($private_key)) {
                    $error_html.= "<h2>{$lang['textcaptchaverificationfailed']}</h2>\n";
                    $valid = false;
                }
            }
        }
    }

    // Defaults that we don't otherwise set.

    $new_user['HOMEPAGE_URL'] = "";
    $new_user['PIC_URL'] = "";
    $new_user['POSTS_PER_PAGE'] = 20;
    $new_user['FONT_SIZE'] = 10;
    $new_user['VIEW_SIGS'] = "Y";
    $new_user['START_PAGE'] = 0;
    $new_user['DOB_DISPLAY'] = 0;
    $new_user['ANON_LOGON'] = "N";
    $new_user['SHOW_STATS'] = "Y";
    $new_user['IMAGES_TO_LINKS'] = "N";
    $new_user['USE_WORD_FILTER'] = "N";
    $new_user['USE_ADMIN_FILTER'] = "N";
    $new_user['ALLOW_EMAIL'] = "Y";
    $new_user['ALLOW_PM'] = "Y";

    foreach ($new_user as $key => $value) {
        $new_user_global[$key] = true;
    }

    if ($valid) {

        if ($new_user['PW'] != $new_user['CPW']) {
            $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
            $valid = false;
        }

        if (strtolower($new_user['LOGON']) == strtolower($new_user['PW'])) {
            $error_html.= "<h2>{$lang['usernamesameaspasswd']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        if (user_exists($new_user['LOGON'])) {
            $error_html.= "<h2>{$lang['usernameexists']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        $new_uid = user_create($new_user['LOGON'], $new_user['PW'], $new_user['NICKNAME'], $new_user['EMAIL']);

        if ($new_uid > -1) {

            $email_confirm_result = true;

            user_update_prefs($new_uid, $new_user, $new_user_global);
            user_update_sig($new_uid, $new_user['SIG_CONTENT'], $new_user['SIG_HTML']);

            if (forum_get_setting('require_email_confirmation', 'Y')) {

                $email_confirm_result = email_send_user_confirmation($new_uid);
                perm_user_apply_email_confirmation($new_uid);
            }

            bh_session_init($new_uid);

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

            // Prepare Form Data

            $passw = str_repeat(chr(32), strlen($new_user['PW']));
            $passh = md5(_stripslashes($new_user['PW']));

            if (($key = _array_search($new_user['LOGON'], $username_array)) !== false) {

                unset($username_array[$key]);
                unset($password_array[$key]);
                unset($passhash_array[$key]);
            }

            array_unshift($username_array, $new_user['LOGON']);

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

            html_draw_top();

            echo "<div align=\"center\">\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\" width=\"550\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\">{$lang['successfullycreateduseraccount']}</td>\n";
            echo "                </tr>\n";

            if (forum_get_setting('require_email_confirmation', 'Y')) {

                if ($email_confirm_result) {

                    echo "                <tr>\n";
                    echo "                  <td align=\"left\">{$lang['useraccountcreatedconfirmsuccess']}</td>\n";
                    echo "                </tr>\n";

                }else {

                    echo "                <tr>\n";
                    echo "                  <td align=\"left\">{$lang['useraccountcreatedconfirmfailed']}</td>\n";
                    echo "                </tr>\n";
                }

            }else {

                echo "                <tr>\n";
                echo "                  <td align=\"left\">{$lang['useraccountcreated']}</td>\n";
                echo "                </tr>\n";
            }

            echo "                <tr>\n";
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

            if (isset($final_uri)) {

                echo "    <tr>\n";
                echo "      <td align=\"center\">", form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top"), "</td>\n";
                echo "    </tr>\n";

            }else {

                echo "    <tr>\n";
                echo "      <td align=\"center\">", form_quick_button("./index.php", $lang['continue'], false, false, "_top"), "</td>\n";
                echo "    </tr>\n";
            }

            echo "  </table>\n";
            echo "</div>\n";

            html_draw_bottom();

            exit;

        }else {

            $error_html.= "<h2>{$lang['errorcreatinguserrecord']}</h2>\n";
            $valid = false;
        }
    }
}

html_draw_top();

echo "<h1>{$lang['userregistration']}</h1>\n";

if (isset($error_html) && strlen($error_html) > 0) {
    echo $error_html;
}else {
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "<form name=\"register\" action=\"register.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['registrationinformationrequired']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\" width=\"295\">{$lang['username']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("LOGON", (isset($new_user['LOGON']) ? _htmlentities($new_user['LOGON']) : ""), 45, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['passwd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("PW", "", 45, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['confirmpassword']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("CPW", "", 45, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['nickname']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("NICKNAME", (isset($new_user['NICKNAME']) ? _htmlentities($new_user['NICKNAME']) : ""), 45, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['email']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("EMAIL", (isset($new_user['EMAIL']) ? _htmlentities($new_user['EMAIL']) : ""), 45, 80), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['dateofbirth']}:</td>\n";
echo "                        <td align=\"left\">", form_dob_dropdowns((isset($new_user['DOB_YEAR']) ? _htmlentities($new_user['DOB_YEAR']) : 0), (isset($new_user['DOB_MONTH']) ? _htmlentities($new_user['DOB_MONTH']) : 0), (isset($new_user['DOB_DAY']) ? _htmlentities($new_user['DOB_DAY']) : 0), true), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox("remember_user", "Y", $lang['rememberpasswd'], (isset($_POST['remember_user']) && $_POST['remember_user'] == "Y")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </td>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['profileinformationoptional']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\" width=\"295\">{$lang['firstname']}:</td>\n";
echo "                        <td align=\"left\">", form_field("FIRSTNAME", (isset($new_user['FIRSTNAME']) ? _htmlentities($new_user['FIRSTNAME']) : ""), 45, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['lastname']}:</td>\n";
echo "                        <td align=\"left\">", form_field("LASTNAME", (isset($new_user['LASTNAME']) ? _htmlentities($new_user['LASTNAME']) : ""), 45, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\" valign=\"top\">{$lang['signature']}:</td>\n";
echo "                        <td align=\"left\">", form_textarea("SIG_CONTENT", (isset($new_user['SIG_CONTENT']) ? _htmlentities($new_user['SIG_CONTENT']) : ""), 6, 42), "</td>\n";
echo "                      </tr>\n";
echo "                     <tr>\n";
echo "                       <td align=\"left\">&nbsp;</td>\n";
echo "                       <td align=\"left\">", form_checkbox("SIG_HTML", "Y", $lang['containsHTML'], (isset($new_user['SIG_HTML']) && $new_user['SIG_HTML'] == "Y")), "</td>\n";
echo "                     </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </td>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['preferencesoptional']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\" width=\"245\">{$lang['alwaysnotifymeofrepliestome']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("EMAIL_NOTIFY", "Y", $lang['yes'], (isset($new_user['EMAIL_NOTIFY'])) ? ($new_user['EMAIL_NOTIFY'] == "Y") : forum_get_setting('new_user_email_notify', 'Y', true)), "&nbsp;", form_radio("EMAIL_NOTIFY", "N", $lang['no'], (isset($new_user['EMAIL_NOTIFY'])) ? ($new_user['EMAIL_NOTIFY'] == "N") : forum_get_setting('new_user_email_notify', 'N', false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['notifyonnewprivatemessage']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("PM_NOTIFY_EMAIL", "Y", $lang['yes'], (isset($new_user['PM_NOTIFY_EMAIL'])) ? ($new_user['PM_NOTIFY_EMAIL'] == "Y") : forum_get_setting('new_user_pm_notify_email', 'Y', true)), "&nbsp;", form_radio("PM_NOTIFY_EMAIL", "N", $lang['no'], (isset($new_user['PM_NOTIFY_EMAIL'])) ? ($new_user['PM_NOTIFY_EMAIL'] == "N") : forum_get_setting('new_user_pm_notify_email', 'N', false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['popuponnewprivatemessage']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("PM_NOTIFY", "Y", $lang['yes'], (isset($new_user['PM_NOTIFY'])) ? ($new_user['PM_NOTIFY'] == "Y") : forum_get_setting('new_user_pm_notify', 'Y', true)), "&nbsp;", form_radio("PM_NOTIFY", "N", $lang['no'], (isset($new_user['PM_NOTIFY'])) ? ($new_user['PM_NOTIFY'] == "N") : forum_get_setting('new_user_pm_notify', 'N', false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['automatichighinterestonpost']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("MARK_AS_OF_INT", "Y", $lang['yes'], (isset($new_user['MARK_AS_OF_INT'])) ? ($new_user['MARK_AS_OF_INT'] == "Y") : forum_get_setting('new_user_mark_as_of_int', 'Y', true)), "&nbsp;", form_radio("MARK_AS_OF_INT", "N", $lang['no'], (isset($new_user['MARK_AS_OF_INT'])) ? ($new_user['MARK_AS_OF_INT'] == "N") : forum_get_setting('new_user_mark_as_of_int', 'N', false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </td>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['timezone']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['timezonefromGMT']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("TIMEZONE", $timezones_data, $timezones, (isset($new_user['TIMEZONE']) ? $new_user['TIMEZONE'] : forum_get_setting('forum_timezone', false, 0))), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox("DL_SAVING", "Y", $lang['daylightsaving'], (isset($new_user['DL_SAVING']) && $new_user['DL_SAVING'] == 'Y') ? true : forum_get_setting('forum_dl_saving', false, true)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </td>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumoptions']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['style']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("STYLE", array_keys($available_styles), array_values($available_styles), (isset($new_user['STYLE']) && in_array($new_user['STYLE'], array_keys($available_styles))) ? $new_user['STYLE'] : forum_get_setting('default_style', false, 'default'), "", "register_dropdown"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['forumemoticons']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("EMOTICONS", array_keys($available_emoticons), array_values($available_emoticons), (isset($new_user['EMOTICONS']) && in_array($new_user['EMOTICONS'], array_keys($available_emoticons))) ? $new_user['EMOTICONS'] : forum_get_setting('default_emoticons', false, 'default'), "", "register_dropdown"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\" width=\"255\">{$lang['preferredlang']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("LANGUAGE", $available_langs, $available_langs_labels, (isset($new_user['LANGUAGE']) ? $new_user['LANGUAGE'] : forum_get_setting('default_language', false, 'en')), "", "register_dropdown"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";

if (forum_get_setting('text_captcha_enabled', 'Y')) {

    if ($text_captcha->generate_keys() && $text_captcha->make_image()) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['textcaptchaconfirmation']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" valign=\"top\">{$lang['textcaptchaexplain']}</td>\n";
        echo "                        <td align=\"left\"><img src=\"", $text_captcha->get_image_filename(), "\" alt=\"{$lang['textcaptchaimgtip']}\" title=\"{$lang['textcaptchaimgtip']}\" /></td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">", form_input_text("private_key", "", $text_captcha->get_num_chars(), $text_captcha->get_num_chars(), "", "text_captcha_input"), form_input_hidden("public_key", $text_captcha->get_public_key()), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        echo "                      </tr>\n";
    }
}

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
echo "      <td align=\"center\">{$lang['moreoptionsavailable']}</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['register']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>