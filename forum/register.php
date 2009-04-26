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

/* $Id: register.php,v 1.204 2009-04-26 13:01:11 decoyduck Exp $ */

/**
* Displays and processes registration forms
*/

/**
*/

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Set the default timezone
date_default_timezone_set('UTC');

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "text_captcha.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Where are we going after we've logged on?

if (isset($_GET['final_uri']) && strlen(trim(stripslashes_array($_GET['final_uri']))) > 0) {

    $final_uri = basename(trim(stripslashes_array($_GET['final_uri'])));

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename($final_uri)) < 1) unset($final_uri);
}

// Load the user session

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Load language file

$lang = lang::get_instance()->load(__FILE__);

// Make sure we have a webtag

$webtag = get_webtag();

// check to see if user registration is available

if (forum_get_setting('allow_new_registrations', 'N')) {

    html_draw_top();
    html_error_msg($lang['newuserregistrationsarenotpermitted']);
    html_draw_bottom();
    exit;
}

// Get an array of available emoticon sets

$available_emoticons = emoticons_get_available();

// Get an array of available languages

$available_langs = lang_get_available();

// Get an array of available timezones.

$available_timezones = get_available_timezones();

// Initialise the text captcha

$text_captcha = new captcha(6, 15, 25, 9, 30);

// Array to hold error messages

$error_msg_array = array();

// Top frame target

$frame_top_target = html_get_top_frame_name();

// Check to see if Forum Rules are enabled.

if (isset($_GET['reload_captcha'])) {

    if (($text_captcha->generate_keys() && $text_captcha->make_image())) {

        // Outputting XML

        cache_disable();

        header('Content-type: text/xml; charset=UTF-8', true);

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<captcha>\n";
        echo "  <image>", $text_captcha->get_image_filename(), "</image>\n";
        echo "  <chars>", $text_captcha->get_num_chars(), "</chars>\n";
        echo "  <key>", $text_captcha->get_public_key(), "</key>\n";
        echo "</captcha>\n";
        exit;
    }
}

if (isset($_GET['private_key']) && strlen(trim(stripslashes_array($_GET['private_key']))) > 0) {
    $text_captcha_private_key = trim(stripslashes_array($_GET['private_key']));
}else {
    $text_captcha_private_key = "";
}

if (forum_get_setting('forum_rules_enabled', 'Y', true)) {

    $user_agree_rules = 'N';

    if (isset($_POST['forum_rules'])) {

        if (isset($_POST['user_agree_rules']) && $_POST['user_agree_rules'] == 'Y') {

            $user_agree_rules = 'Y';

        }else {

            $error_msg_array[] = $lang['youmustagreetotheforumrules'];
            $valid = false;
        }
    }

}else {

    $user_agree_rules = 'Y';
}

if (isset($_POST['cancel'])) {

    bh_setcookie("bh_logon", "1");
    header_redirect("logon.php?webtag=$webtag");
    exit;
}

$valid = true;

if (isset($_POST['register'])) {

    if (isset($_POST['user_agree_rules']) && $_POST['user_agree_rules'] == 'Y') {

        $user_agree_rules = 'Y';

    }else {

        $error_msg_array[] = $lang['youmustagreetotheforumrules'];
        $valid = false;
    }

    if (isset($_POST['logon']) && strlen(trim(stripslashes_array($_POST['logon']))) > 0) {

        $logon = mb_strtoupper(trim(stripslashes_array($_POST['logon'])));

        if (mb_strlen($logon) < 2) {

            $error_msg_array[] = $lang['usernametooshort'];
            $valid = false;
        }

        if (mb_strlen($logon) > 15) {

            $error_msg_array[] = $lang['usernametoolong'];
            $valid = false;
        }

        if (logon_is_banned($logon)) {

            $error_msg_array[] = $lang['logonnotpermitted'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['usernamerequired'];
        $valid = false;
    }

    if (isset($_POST['pw']) && strlen(trim(stripslashes_array($_POST['pw']))) > 0) {

        $password = trim(stripslashes_array($_POST['pw']));

        if (mb_strlen($password) < 6) {

            $error_msg_array[] = $lang['passwdtooshort'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['passwdrequired'];
        $valid.= false;
    }

    if (isset($_POST['cpw']) && strlen(trim(stripslashes_array($_POST['cpw']))) > 0) {

        $check_password = trim(stripslashes_array($_POST['cpw']));

        if (htmlentities_array($check_password) != $check_password) {

            $error_msg_array[] = $lang['passwdmustnotcontainHTML'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['confirmationpasswdrequired'];
        $valid = false;
    }

    if (isset($_POST['nickname']) && strlen(trim(stripslashes_array($_POST['nickname']))) > 0) {

        $nickname = strip_tags(trim(stripslashes_array($_POST['nickname'])));

        if (nickname_is_banned($nickname)) {

            $error_msg_array[] = $lang['nicknamenotpermitted'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['nicknamerequired'];
        $valid = false;
    }

    if (isset($_POST['email']) && strlen(trim(stripslashes_array($_POST['email']))) > 0) {

        $email = trim(stripslashes_array($_POST['email']));

        if (!email_address_valid($email)) {

            $error_msg_array[] = $lang['invalidemailaddressformat'];
            $valid = false;

        }else {

            if (email_is_banned($email)) {

                $error_msg_array[] = $lang['emailaddressnotpermitted'];
                $valid = false;
            }

            if (forum_get_setting('require_unique_email', 'Y') && !email_is_unique($email)) {

                $error_msg_array[] = $lang['emailaddressalreadyinuse'];
                $valid = false;
            }
        }

    }else {

        $error_msg_array[] = $lang['emailrequired'];
        $valid = false;
    }

    if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && @checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

        $new_user_prefs['DOB_DAY']   = trim(stripslashes_array($_POST['dob_day']));
        $new_user_prefs['DOB_MONTH'] = trim(stripslashes_array($_POST['dob_month']));
        $new_user_prefs['DOB_YEAR']  = trim(stripslashes_array($_POST['dob_year']));

        $new_user_prefs['DOB'] = "{$new_user_prefs['DOB_YEAR']}-{$new_user_prefs['DOB_MONTH']}-{$new_user_prefs['DOB_DAY']}";
        $new_user_prefs['DOB_BLANK_FIELDS'] = ($new_user_prefs['DOB_YEAR'] == 0 || $new_user_prefs['DOB_MONTH'] == 0 || $new_user_prefs['DOB_DAY'] == 0) ? true : false;

    }else {

        $error_msg_array[] = $lang['birthdayrequired'];
        $valid = false;
    }

    if (isset($_POST['firstname']) && strlen(trim(stripslashes_array($_POST['firstname']))) > 0) {
        $new_user_prefs['FIRSTNAME'] = trim(stripslashes_array($_POST['firstname']));
    }else {
        $new_user_prefs['FIRSTNAME'] = "";
    }

    if (isset($_POST['lastname']) && strlen(trim(stripslashes_array($_POST['lastname']))) > 0) {
        $new_user_prefs['LASTNAME'] = trim(stripslashes_array($_POST['lastname']));
    }else {
        $new_user_prefs['LASTNAME'] = "";
    }

    if (isset($_POST['sig_content']) && strlen(trim(stripslashes_array($_POST['sig_content']))) > 0) {
        $sig_content = trim(stripslashes_array($_POST['sig_content']));
    }else {
        $sig_content = "";
    }

    if (isset($_POST['sig_html']) && $_POST['sig_html'] == "Y") {
        $sig_content = fix_html($sig_content);
        $sig_html = "Y";
    }else {
        $sig_content = stripslashes_array($sig_content);
        $sig_html = "N";
    }

    if (isset($_POST['email_notify']) && $_POST['email_notify'] == "Y") {
        $new_user_prefs['EMAIL_NOTIFY'] = "Y";
    }else {
        $new_user_prefs['EMAIL_NOTIFY'] = "N";
    }

    if (isset($_POST['pm_notify_email']) && $_POST['pm_notify_email'] == "Y") {
        $new_user_prefs['PM_NOTIFY_EMAIL'] = "Y";
    }else {
        $new_user_prefs['PM_NOTIFY_EMAIL'] = "N";
    }

    if (isset($_POST['pm_notify']) && $_POST['pm_notify'] == "Y") {
        $new_user_prefs['PM_NOTIFY'] = "Y";
    }else {
        $new_user_prefs['PM_NOTIFY'] = "N";
    }

    if (isset($_POST['mark_as_of_int']) && $_POST['mark_as_of_int'] == "Y") {
        $new_user_prefs['MARK_AS_OF_INT'] = "Y";
    }else {
        $new_user_prefs['MARK_AS_OF_INT'] = "N";
    }

    if (isset($_POST['dl_saving']) && $_POST['dl_saving'] == "Y") {
        $new_user_prefs['DL_SAVING'] = "Y";
    }else {
        $new_user_prefs['DL_SAVING'] = "N";
    }

    if (isset($_POST['timezone']) && in_array($_POST['timezone'], array_keys($available_timezones))) {
        $new_user_prefs['TIMEZONE'] = $_POST['timezone'];
    }else {
        $new_user_prefs['TIMEZONE'] = forum_get_setting('forum_timezone', false, 27);
    }

    if (isset($_POST['language']) && in_array($_POST['language'], $available_langs)) {
        $new_user_prefs['LANGUAGE'] = $_POST['language'];
    }else {
        $new_user_prefs['LANGUAGE'] = forum_get_setting('default_language', false, 'en');
    }

    if (isset($_POST['style']) && style_exists(trim(stripslashes_array($_POST['style'])))) {
        $new_user_prefs['STYLE'] = trim(stripslashes_array($_POST['style']));
    }else {
        $new_user_prefs['STYLE'] = forum_get_setting('default_style', false, 'default');
    }

    if (isset($_POST['emoticons']) && in_array($_POST['emoticons'], $available_emoticons)) {
        $new_user_prefs['EMOTICONS'] = $_POST['emoticons'];
    }else {
        $new_user_prefs['EMOTICONS'] = forum_get_setting('default_emoticons', false, 'default');
    }

    if (forum_get_setting('text_captcha_enabled', 'Y')) {

        if (isset($_POST['public_key']) && strlen(trim(stripslashes_array($_POST['public_key']))) > 0) {

            $public_key = trim(stripslashes_array($_POST['public_key']));

            if (isset($_POST['private_key']) && strlen(trim(stripslashes_array($_POST['private_key']))) > 0) {

                $private_key = trim(stripslashes_array($_POST['private_key']));

            }else {

                $error_msg_array[] = $lang['textcaptchamissingkey'];
                $valid = false;
            }

            if ($valid) {

                $text_captcha->set_public_key($public_key);
                $text_captcha->destroy_image();

                if (!$text_captcha->verify_keys($private_key)) {

                    $error_msg_array[] = $lang['textcaptchaverificationfailed'];
                    $valid = false;
                }
            }
        }
    }

    foreach ($new_user_prefs as $key => $value) {
        $new_user_prefs_global[$key] = true;
    }

    if ($valid) {

        if ($password != $check_password) {

            $error_msg_array[] = $lang['passwdsdonotmatch'];
            $valid = false;
        }

        if (mb_strtolower($logon) == mb_strtolower($password)) {

            $error_msg_array[] = $lang['usernamesameaspasswd'];
            $valid = false;
        }
    }

    if ($valid) {

        if (user_exists($logon)) {

            $error_msg_array[] = $lang['usernameexists'];
            $valid = false;
        }
    }

    if ($valid) {

        if (($new_uid = user_create($logon, $password, $nickname, $email))) {

            // Save the new user preferences and signature

            user_update_prefs($new_uid, $new_user_prefs, $new_user_prefs_global);
            user_update_sig($new_uid, $sig_content, $sig_html);

            // Initialise the new user session.

            bh_session_init($new_uid);

            // Check if the user wants to save their password.

            $save_password = isset($_POST['remember_user']) && ($_POST['remember_user'] == 'Y');

            // Generate the MD5 checksum of the user's password for saving in their cookie.

            $passhash = md5($password);
            $password = str_repeat(chr(32), mb_strlen($password));

            // Update the cookies.

            logon_update_cookies($logon, $password, $passhash, $save_password, false);

            // Check to see if the user is going somewhere after they have registered.

            $final_uri = (isset($final_uri)) ? rawurlencode($final_uri) : '';

            // If User Confirmation is enabled send the forum owners an email.

            if (forum_get_setting('require_user_approval', 'Y')) {
                admin_send_user_approval_notification();
            }

            // If New User Notification is enabled send the forum owners an email.

            if (forum_get_setting('send_new_user_email', 'Y')) {
                admin_send_new_user_notification($new_uid);
            }

            // Display final success / confirmation page.

            if (forum_get_setting('require_email_confirmation', 'Y')) {

                if (email_send_user_confirmation($new_uid)) {

                    perm_user_apply_email_confirmation($new_uid);

                    html_draw_top();
                    html_display_msg($lang['successfullycreateduseraccount'], $lang['useraccountcreatedconfirmsuccess'], 'index.php', 'get', array('continue' => $lang['continue']), array('final_uri' => $final_uri), '_top', 'center');
                    html_draw_bottom();
                    exit;

                }else {

                    html_draw_top();
                    html_display_msg($lang['successfullycreateduseraccount'], $lang['useraccountcreatedconfirmfailed'], 'index.php', 'get', array('continue' => $lang['continue']), array('final_uri' => $final_uri), '_top', 'center');
                    html_draw_bottom();
                    exit;
                }

            }else {

                html_draw_top();
                html_display_msg($lang['successfullycreateduseraccount'], $lang['useraccountcreated'], 'index.php', 'get', array('continue' => $lang['continue']), array('final_uri' => $final_uri), '_top', 'center');
                html_draw_bottom();
                exit;
            }

        }else {

            $error_msg_array[] = $lang['errorcreatinguserrecord'];
            $valid = false;
        }
    }
}

html_draw_top('emoticons.js', 'register.js', "basetarget=$frame_top_target");

echo "<h1>{$lang['userregistration']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '600', 'center');
}

if (isset($user_agree_rules) && $user_agree_rules == 'Y') {

    html_display_warning_msg($lang['moreoptionsavailable'], '600', 'center');

    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"form_register\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('user_agree_rules', htmlentities_array($user_agree_rules)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("logon", (isset($logon) ? htmlentities_array($logon) : ""), 45, 15), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['passwd']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_password("pw", "", 45, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['confirmpassword']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_password("cpw", "", 45, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['nickname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("nickname", (isset($nickname) ? htmlentities_array($nickname) : ""), 45, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['email']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("email", (isset($email) ? htmlentities_array($email) : ""), 45, 80), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['dateofbirth']}:</td>\n";
    echo "                        <td align=\"left\">", form_dob_dropdowns((isset($new_user_prefs['DOB_YEAR']) ? htmlentities_array($new_user_prefs['DOB_YEAR']) : 0), (isset($new_user_prefs['DOB_MONTH']) ? htmlentities_array($new_user_prefs['DOB_MONTH']) : 0), (isset($new_user_prefs['DOB_DAY']) ? htmlentities_array($new_user_prefs['DOB_DAY']) : 0), true), "</td>\n";
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
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("firstname", (isset($new_user_prefs['FIRSTNAME']) ? htmlentities_array($new_user_prefs['FIRSTNAME']) : ""), 45, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['lastname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("lastname", (isset($new_user_prefs['LASTNAME']) ? htmlentities_array($new_user_prefs['LASTNAME']) : ""), 45, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\" valign=\"top\">{$lang['signature']}:</td>\n";
    echo "                        <td align=\"left\">", form_textarea("sig_content", (isset($sig_content) ? htmlentities_array($sig_content) : ""), 6, 42), "</td>\n";
    echo "                      </tr>\n";
    echo "                     <tr>\n";
    echo "                       <td align=\"left\">&nbsp;</td>\n";
    echo "                       <td align=\"left\">", form_checkbox("sig_html", "Y", $lang['signaturecontainshtmlcode'], (isset($sig_html) && $sig_html == "Y")), "</td>\n";
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
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                        <td align=\"left\">", form_radio("email_notify", "Y", $lang['yes'], (isset($new_user_prefs['EMAIL_NOTIFY'])) ? ($new_user_prefs['EMAIL_NOTIFY'] == "Y") : forum_get_setting('new_user_email_notify', 'Y', true)), "&nbsp;", form_radio("email_notify", "N", $lang['no'], (isset($new_user_prefs['EMAIL_NOTIFY'])) ? ($new_user_prefs['EMAIL_NOTIFY'] == "N") : forum_get_setting('new_user_email_notify', 'N', false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['notifyonnewprivatemessage']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("pm_notify_email", "Y", $lang['yes'], (isset($new_user_prefs['PM_NOTIFY_EMAIL'])) ? ($new_user_prefs['PM_NOTIFY_EMAIL'] == "Y") : forum_get_setting('new_user_pm_notify_email', 'Y', true)), "&nbsp;", form_radio("pm_notify_email", "N", $lang['no'], (isset($new_user_prefs['PM_NOTIFY_EMAIL'])) ? ($new_user_prefs['PM_NOTIFY_EMAIL'] == "N") : forum_get_setting('new_user_pm_notify_email', 'N', false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['popuponnewprivatemessage']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("pm_notify", "Y", $lang['yes'], (isset($new_user_prefs['PM_NOTIFY'])) ? ($new_user_prefs['PM_NOTIFY'] == "Y") : forum_get_setting('new_user_pm_notify', 'Y', true)), "&nbsp;", form_radio("pm_notify", "N", $lang['no'], (isset($new_user_prefs['PM_NOTIFY'])) ? ($new_user_prefs['PM_NOTIFY'] == "N") : forum_get_setting('new_user_pm_notify', 'N', false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['automatichighinterestonpost']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("mark_as_of_int", "Y", $lang['yes'], (isset($new_user_prefs['MARK_AS_OF_INT'])) ? ($new_user_prefs['MARK_AS_OF_INT'] == "Y") : forum_get_setting('new_user_mark_as_of_int', 'Y', true)), "&nbsp;", form_radio("mark_as_of_int", "N", $lang['no'], (isset($new_user_prefs['MARK_AS_OF_INT'])) ? ($new_user_prefs['MARK_AS_OF_INT'] == "N") : forum_get_setting('new_user_mark_as_of_int', 'N', false)), "</td>\n";
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
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                        <td align=\"left\">", form_dropdown_array("timezone", htmlentities_array($available_timezones), (isset($new_user_prefs['TIMEZONE']) && in_array($new_user_prefs['TIMEZONE'], array_keys($available_timezones))) ? $new_user_prefs['TIMEZONE'] : forum_get_setting('forum_timezone', false, 27), false, 'timezone_dropdown'), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($new_user_prefs['DL_SAVING'])) ? ($new_user_prefs['DL_SAVING'] == 'Y') : forum_get_setting('forum_dl_saving', 'Y')), "</td>\n";
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
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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

    if (($available_styles = styles_get_available())) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"posthead\">{$lang['style']}:</td>\n";
        echo "                        <td align=\"left\">", form_dropdown_array("style", htmlentities_array($available_styles), (isset($new_user_prefs['STYLE']) && style_exists($new_user_prefs['STYLE'])) ? htmlentities_array($new_user_prefs['STYLE']) : htmlentities_array(forum_get_setting('default_style', false, 'default')), "", "register_dropdown"), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">{$lang['forumemoticons']} [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" onclick=\"return openEmoticons('','$webtag')\">{$lang['preview']}</a>]:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("emoticons", htmlentities_array($available_emoticons), (isset($new_user_prefs['EMOTICONS']) && in_array($new_user_prefs['EMOTICONS'], array_keys($available_emoticons))) ? htmlentities_array($new_user_prefs['EMOTICONS']) : htmlentities_array(forum_get_setting('default_emoticons', false, 'default')), "", "register_dropdown"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\" width=\"255\">{$lang['preferredlang']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("language", htmlentities_array($available_langs), (isset($new_user_prefs['LANGUAGE']) ? htmlentities_array($new_user_prefs['LANGUAGE']) : htmlentities_array(forum_get_setting('default_language', false, 'en'))), "", "register_dropdown"), "</td>\n";
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
    echo "    </tr>\n";
    echo "  </table>\n";

    if (forum_get_setting('text_captcha_enabled', 'Y') && ($text_captcha->generate_keys())) {

        if (strlen(trim($text_captcha_private_key)) > 0) {

            echo form_input_hidden("private_key", htmlentities_array($text_captcha_private_key));
            echo form_input_hidden("public_key", htmlentities_array($text_captcha->get_public_key()));

        }else if ($text_captcha->make_image()) {

            $forum_owner_email = forum_get_setting('forum_email', false, 'admin@abeehiveforum.net');
            $forum_owner_link  = sprintf("<a href=\"mailto:%s\">{$lang['forumowner']}</a>", $forum_owner_email);

            echo "  <br />\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['textcaptchaconfirmation']}</td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" valign=\"top\" rowspan=\"2\">", sprintf($lang['textcaptchaexplain'], $forum_owner_link), "</td>\n";
            echo "                        <td align=\"left\" valign=\"top\" rowspan=\"2\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" valign=\"top\"><img src=\"", $text_captcha->get_image_filename(), "\" alt=\"{$lang['textcaptchaimgtip']}\" title=\"{$lang['textcaptchaimgtip']}\" id=\"captcha_img\" /></td>\n";
            echo "                        <td align=\"left\" valign=\"top\"><a href=\"Javascript:void(0)\" onclick=\"return captcha_reload()\"><img src=\"", style_image('reload.png'), "\" border=\"0\" alt=\"\" /></a></td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" colspan=\"2\">", form_input_text("private_key", "", 20, htmlentities_array($text_captcha->get_num_chars()), "", "text_captcha_input"), form_input_hidden("public_key", htmlentities_array($text_captcha->get_public_key())), "</td>\n";
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
            echo "    </tr>\n";
            echo "  </table>\n";
        }
    }

    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('register', $lang['register']), "&nbsp;", form_submit('cancel', $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "</form>\n";
    echo "</div>\n";

}else {

    $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

    if (!$forum_rules = forum_get_setting('forum_rules_message')) {

        $cancel_link = "<a href=\"index.php?webtag=$webtag\">{$lang['cancellinktext']}</a>";
        $forum_rules = sprintf($lang['forumrulesmessage'], $forum_name, $cancel_link);
    }

    $forum_rules_message = new MessageText(POST_HTML_AUTO, $forum_rules, true, true);

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"form_register\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumrules']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td>{$lang['forumrulesnotification']}:</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>\n";
    echo "                          <div class=\"forum_rules_box\"><p>", $forum_rules_message->getContent(), "</p></div>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox('user_agree_rules', 'Y', $lang['forumrulescheckbox']), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit('forum_rules', $lang['register']), "&nbsp;", form_submit('cancel', $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
}

html_draw_bottom();

?>