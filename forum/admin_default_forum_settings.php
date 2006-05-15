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

/* $Id: admin_default_forum_settings.php,v 1.45 2006-05-15 22:46:41 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "text_captcha.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$error_html = "";
$text_captcha_dir_created = false;

// Default Forum Settings

$default_forum_settings = forum_get_default_settings();

// Text captcha class

$text_captcha = new captcha(6, 15, 25, 9, 30);

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['search_min_frequency']) && is_numeric($_POST['search_min_frequency'])) {
        $new_forum_settings['search_min_frequency'] = $_POST['search_min_frequency'];
    }else {
        $new_forum_settings['search_min_frequency'] = 30;
    }

    if (isset($_POST['session_cutoff']) && is_numeric($_POST['session_cutoff'])) {
        $new_forum_settings['session_cutoff'] = $_POST['session_cutoff'];
    }else {
        $new_forum_settings['session_cutoff'] = 86400;
    }

    if (isset($_POST['active_sess_cutoff']) && is_numeric($_POST['active_sess_cutoff'])) {

        if ($_POST['active_sess_cutoff'] < $_POST['session_cutoff']) {

            $new_forum_settings['active_sess_cutoff'] = $_POST['active_sess_cutoff'];

        }else {

            $error_html = "<h2>{$lang['activesessiongreaterthansession']}</h2>\n";
            $valid = false;
        }

    }else {

        $new_forum_settings['active_sess_cutoff'] = 900;
    }

    if (isset($_POST['allow_new_registrations']) && $_POST['allow_new_registrations'] == "Y") {
        $new_forum_settings['allow_new_registrations'] = "Y";
    }else {
        $new_forum_settings['allow_new_registrations'] = "N";
    }

    if (isset($_POST['require_unique_email']) && $_POST['require_unique_email'] == "Y") {
        $new_forum_settings['require_unique_email'] = "Y";
    }else {
        $new_forum_settings['require_unique_email'] = "N";
    }

    if (isset($_POST['require_email_confirmation']) && $_POST['require_email_confirmation'] == "Y") {
        $new_forum_settings['require_email_confirmation'] = "Y";
    }else {
        $new_forum_settings['require_email_confirmation'] = "N";
    }

    if (isset($_POST['text_captcha_enabled']) && $_POST['text_captcha_enabled'] == "Y") {
        $new_forum_settings['text_captcha_enabled'] = "Y";
    }else {
        $new_forum_settings['text_captcha_enabled'] = "N";
    }

    if (isset($_POST['text_captcha_dir']) && strlen(trim(_stripslashes($_POST['text_captcha_dir']))) > 0) {

        $new_forum_settings['text_captcha_dir'] = trim(_stripslashes($_POST['text_captcha_dir']));

    }else if (strtoupper($new_forum_settings['text_captcha_enabled']) == "Y") {

        $error_html = "<h2>{$lang['textcaptchadirblank']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['text_captcha_key']) && strlen(trim(_stripslashes($_POST['text_captcha_key']))) > 0) {
        $new_forum_settings['text_captcha_key'] = trim(_stripslashes($_POST['text_captcha_key']));
    }else {
        $new_forum_settings['text_captcha_key'] = "";
    }

    if (isset($_POST['new_user_email_notify']) && $_POST['new_user_email_notify'] == "Y") {
        $new_forum_settings['new_user_email_notify'] = "Y";
    }else {
        $new_forum_settings['new_user_email_notify'] = "N";
    }

    if (isset($_POST['new_user_pm_notify_email']) && $_POST['new_user_pm_notify_email'] == "Y") {
        $new_forum_settings['new_user_pm_notify_email'] = "Y";
    }else {
        $new_forum_settings['new_user_pm_notify_email'] = "N";
    }

    if (isset($_POST['showpopuponnewpm']) && $_POST['showpopuponnewpm'] == "Y") {
        $new_forum_settings['showpopuponnewpm'] = "Y";
    }else {
        $new_forum_settings['showpopuponnewpm'] = "N";
    }

    if (isset($_POST['new_user_mark_as_of_int']) && $_POST['new_user_mark_as_of_int'] == "Y") {
        $new_forum_settings['new_user_mark_as_of_int'] = "Y";
    }else {
        $new_forum_settings['new_user_mark_as_of_int'] = "N";
    }

    if (isset($_POST['show_pms']) && $_POST['show_pms'] == "Y") {
        $new_forum_settings['show_pms'] = "Y";
    }else {
        $new_forum_settings['show_pms'] = "N";
    }

    if (isset($_POST['pm_max_user_messages']) && is_numeric($_POST['pm_max_user_messages'])) {
        $new_forum_settings['pm_max_user_messages'] = $_POST['pm_max_user_messages'];
    }else {
        $new_forum_settings['pm_max_user_messages'] = 100;
    }

    if (isset($_POST['pm_auto_prune_enabled']) && $_POST['pm_auto_prune_enabled'] == "Y") {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $new_forum_settings['pm_auto_prune'] = $_POST['pm_auto_prune'];

        }else {

            $new_forum_settings['pm_auto_prune'] = "-60";
        }

    }else {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $new_forum_settings['pm_auto_prune'] = $_POST['pm_auto_prune'] * -1;

        }else {

            $new_forum_settings['pm_auto_prune'] = "-60";
        }
    }

    if (isset($_POST['pm_allow_attachments']) && $_POST['pm_allow_attachments'] == "Y") {
        $new_forum_settings['pm_allow_attachments'] = "Y";
    }else {
        $new_forum_settings['pm_allow_attachments'] = "N";
    }

    if (isset($_POST['allow_search_spidering']) && $_POST['allow_search_spidering'] == "Y") {
        $new_forum_settings['allow_search_spidering'] = "Y";
    }else {
        $new_forum_settings['allow_search_spidering'] = "N";
    }

    if (isset($_POST['guest_account_enabled']) && $_POST['guest_account_enabled'] == "Y") {
        $new_forum_settings['guest_account_enabled'] = "Y";
    }else {
        $new_forum_settings['guest_account_enabled'] = "N";
    }

    if (isset($_POST['guest_auto_logon']) && $_POST['guest_auto_logon'] == "Y") {
        $new_forum_settings['guest_auto_logon'] = "Y";
    }else {
        $new_forum_settings['guest_auto_logon'] = "N";
    }

    if (isset($_POST['attachments_enabled']) && $_POST['attachments_enabled'] == "Y") {
        $new_forum_settings['attachments_enabled'] = "Y";
    }else {
        $new_forum_settings['attachments_enabled'] = "N";
    }

    if (isset($_POST['attachment_dir']) && strlen(trim(_stripslashes($_POST['attachment_dir']))) > 0) {

        $new_forum_settings['attachment_dir'] = trim(_stripslashes($_POST['attachment_dir']));

    }elseif (strtoupper($new_forum_settings['attachments_enabled']) == "Y") {

        $error_html = "<h2>{$lang['attachmentdirblank']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['attachments_max_user_space']) && is_numeric($_POST['attachments_max_user_space'])) {
        $new_forum_settings['attachments_max_user_space'] = ($_POST['attachments_max_user_space'] * 1024) * 1024;
    }else {
        $new_forum_settings['attachments_max_user_space'] = 1048576; // 1MB in bytes
    }

    if (isset($_POST['attachments_allow_embed']) && $_POST['attachments_allow_embed'] == "Y") {
        $new_forum_settings['attachments_allow_embed'] = "Y";
    }else {
        $new_forum_settings['attachments_allow_embed'] = "N";
    }

    if (isset($_POST['attachment_use_old_method']) && $_POST['attachment_use_old_method'] == "Y") {
        $new_forum_settings['attachment_use_old_method'] = "Y";
    }else {
        $new_forum_settings['attachment_use_old_method'] = "N";
    }

    if ($valid) {

        forum_save_default_settings($new_forum_settings);
        header_redirect("./admin_default_forum_settings.php?webtag=$webtag&updated=true", $lang['forumsettingsupdated']);
    }

    $default_forum_settings = array_merge($default_forum_settings, $new_forum_settings);
}

// Start Output Here

html_draw_top("emoticons.js");

echo "<h1>{$lang['admin']} : {$lang['globalforumsettings']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['forumsettingsupdated']}</h2>\n";
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"prefs\" action=\"admin_default_forum_settings.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>{$lang['settingsaffectallforumswarning']}</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['searchoptions']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['searchfrequency']}:</td>\n";
echo "                        <td>", form_input_text("search_min_frequency", (isset($default_forum_settings['search_min_frequency'])) ? $default_forum_settings['search_min_frequency'] : "30", 10, 3), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_39']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['sessions']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['sessioncutoffseconds']}:</td>\n";
echo "                        <td>", form_input_text("session_cutoff", (isset($default_forum_settings['session_cutoff'])) ? $default_forum_settings['session_cutoff'] : "86400", 20, 6), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['activesessioncutoffseconds']}:</td>\n";
echo "                        <td>", form_input_text("active_sess_cutoff", (isset($default_forum_settings['active_sess_cutoff'])) ? $default_forum_settings['active_sess_cutoff'] : "900", 20, 6), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_15']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_16']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['newuserregistrations']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"250\">{$lang['allownewuserregistrations']}:</td>\n";
echo "                        <td>", form_radio("allow_new_registrations", "Y", $lang['yes'], (isset($default_forum_settings['allow_new_registrations']) && $default_forum_settings['allow_new_registrations'] == 'Y') || !isset($default_forum_settings['allow_new_registrations'])), "&nbsp;", form_radio("allow_new_registrations", "N", $lang['no'], (isset($default_forum_settings['allow_new_registrations']) && $default_forum_settings['allow_new_registrations'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"250\">{$lang['preventduplicateemailaddresses']}:</td>\n";
echo "                        <td>", form_radio("require_unique_email", "Y", $lang['yes'], (isset($default_forum_settings['require_unique_email']) && $default_forum_settings['require_unique_email'] == 'Y')), "&nbsp;", form_radio("require_unique_email", "N", $lang['no'], (isset($default_forum_settings['require_unique_email']) && $default_forum_settings['require_unique_email'] == 'N') || !isset($default_forum_settings['require_unique_email'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"250\">{$lang['requireemailconfirmation']}:</td>\n";
echo "                        <td>", form_radio("require_email_confirmation", "Y", $lang['yes'], (isset($default_forum_settings['require_email_confirmation']) && $default_forum_settings['require_email_confirmation'] == 'Y')), "&nbsp;", form_radio("require_email_confirmation", "N", $lang['no'], (isset($default_forum_settings['require_email_confirmation']) && $default_forum_settings['require_email_confirmation'] == 'N') || !isset($default_forum_settings['require_email_confirmation'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"250\">{$lang['usetextcaptcha']}:</td>\n";
echo "                        <td>", form_radio("text_captcha_enabled", "Y", $lang['yes'], (isset($default_forum_settings['text_captcha_enabled']) && $default_forum_settings['text_captcha_enabled'] == 'Y')), "&nbsp;", form_radio("text_captcha_enabled", "N", $lang['no'], (isset($default_forum_settings['text_captcha_enabled']) && $default_forum_settings['text_captcha_enabled'] == 'N') || !isset($default_forum_settings['text_captcha_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['textcaptchadir']}:</td>\n";
echo "                        <td>", form_input_text("text_captcha_dir", (isset($default_forum_settings['text_captcha_dir'])) ? $default_forum_settings['text_captcha_dir'] : "text_captcha", 35, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['textcaptchakey']}:</td>\n";
echo "                        <td>", form_input_text("text_captcha_key", (isset($default_forum_settings['text_captcha_key'])) ? $default_forum_settings['text_captcha_key'] : md5(uniqid(rand())), 35, 255), "</td>\n";
echo "                      </tr>\n";

if (isset($default_forum_settings['text_captcha_enabled']) && $default_forum_settings['text_captcha_enabled'] == "Y") {

    if (!$text_captcha->generate_keys() || !$text_captcha->make_image()) {

        if ($errno = $text_captcha->get_error()) {

            echo "                      <tr>\n";
            echo "                        <td colspan=\"2\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td colspan=\"2\" align=\"center\">\n";
            echo "                          <table class=\"text_captcha_error\" width=\"95%\">\n";

            switch ($errno) {

                case TEXT_CAPTCHA_NO_FONTS:

                    $text_captcha_dir = dirname($_SERVER['PHP_SELF']). "/";
                    $text_captcha_dir.= forum_get_setting('text_captcha_dir', false, 'text_captcha');
                    $text_captcha_dir.= "/fonts/";
                    
                    echo "                            <tr>\n";
                    echo "                              <td width=\"30\"><img src=\"", style_image('warning.png'), "\" /></td>\n";
                    echo "                              <td>", sprintf($lang['textcaptchafonterror'], $text_captcha_dir), "</td>\n";
                    echo "                            </tr>\n";
                    break;

                case TEXT_CAPTCHA_DIR_ERROR:

                    echo "                            <tr>\n";
                    echo "                              <td width=\"30\"><img src=\"", style_image('warning.png'), "\" /></td>\n";
                    echo "                              <td>{$lang['textcaptchadirerror']}</td>\n";
                    break;

                case TEXT_CAPTCHA_GD_ERROR:

                    echo "                            <tr>\n";
                    echo "                              <td width=\"30\"><img src=\"", style_image('warning.png'), "\" /></td>\n";
                    echo "                              <td>{$lang['textcaptchagderror']}</td>\n";
                    break;
            }

            echo "                          </table>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
        }
    }
}

echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_29']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_42']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_43']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_44']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_45']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_46']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['newuserpreferences']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['sendemailnotificationonreply']}:</td>\n";
echo "                        <td>", form_radio("new_user_email_notify", "Y", $lang['yes'], (isset($default_forum_settings['new_user_email_notify']) && $default_forum_settings['new_user_email_notify'] == 'Y') || !isset($default_forum_settings['new_user_email_notify'])), "&nbsp;", form_radio("new_user_email_notify", "N", $lang['no'], (isset($default_forum_settings['new_user_email_notify']) && $default_forum_settings['new_user_email_notify'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['sendemailnotificationonpm']}:</td>\n";
echo "                        <td>", form_radio("new_user_pm_notify_email", "Y", $lang['yes'], (isset($default_forum_settings['new_user_pm_notify_email']) && $default_forum_settings['new_user_pm_notify_email'] == 'Y') || !isset($default_forum_settings['new_user_pm_notify_email'])), "&nbsp;", form_radio("new_user_pm_notify_email", "N", $lang['no'], (isset($default_forum_settings['new_user_pm_notify_email']) && $default_forum_settings['new_user_pm_notify_email'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['showpopuponnewpm']}:</td>\n";
echo "                        <td>", form_radio("new_user_pm_notify", "Y", $lang['yes'], (isset($default_forum_settings['new_user_pm_notify']) && $default_forum_settings['new_user_pm_notify'] == 'Y') || !isset($default_forum_settings['new_user_pm_notify'])), "&nbsp;", form_radio("new_user_pm_notify", "N", $lang['no'], (isset($default_forum_settings['new_user_pm_notify']) && $default_forum_settings['new_user_pm_notify'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['setautomatichighinterestonpost']}:</td>\n";
echo "                        <td>", form_radio("new_user_mark_as_of_int", "Y", $lang['yes'], (isset($default_forum_settings['new_user_mark_as_of_int']) && $default_forum_settings['new_user_mark_as_of_int'] == 'Y') || !isset($default_forum_settings['new_user_mark_as_of_int'])), "&nbsp;", form_radio("new_user_mark_as_of_int", "N", $lang['no'], (isset($default_forum_settings['new_user_mark_as_of_int']) && $default_forum_settings['new_user_mark_as_of_int'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"3\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_41']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['personalmessages']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['enablepersonalmessages']}:</td>\n";
echo "                        <td>", form_radio("show_pms", "Y", $lang['yes'] , ((isset($default_forum_settings['show_pms']) && $default_forum_settings['show_pms'] == 'Y'))), "&nbsp;", form_radio("show_pms", "N", $lang['no'] , (isset($default_forum_settings['show_pms']) && $default_forum_settings['show_pms'] == 'N') || !isset($default_forum_settings['show_pms'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"350\">{$lang['autopruneuserspmfoldersevery']} ", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($default_forum_settings['pm_auto_prune']) ? ($default_forum_settings['pm_auto_prune'] > 0 ? $default_forum_settings['pm_auto_prune'] : $default_forum_settings['pm_auto_prune'] * -1) : 4)), " {$lang['days']}:</td>\n";
echo "                        <td>", form_radio("pm_auto_prune_enabled", "Y", $lang['yes'], (isset($default_forum_settings['pm_auto_prune']) && $default_forum_settings['pm_auto_prune'] > 0)), "&nbsp;", form_radio("pm_auto_prune_enabled", "N", $lang['no'] , ((isset($default_forum_settings['pm_auto_prune']) && $default_forum_settings['pm_auto_prune'] < 0)) || !isset($default_forum_settings['pm_auto_prune'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['allowpmstohaveattachments']}:</td>\n";
echo "                        <td>", form_radio("pm_allow_attachments", "Y", $lang['yes'] , (isset($default_forum_settings['pm_allow_attachments']) && $default_forum_settings['pm_allow_attachments'] == 'Y')), "&nbsp;", form_radio("pm_allow_attachments", "N", $lang['no'] , ((isset($default_forum_settings['pm_allow_attachments']) && $default_forum_settings['pm_allow_attachments'] == 'N')) || !isset($default_forum_settings['pm_allow_attachments'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['pmusermessages']}:</td>\n";
echo "                        <td>", form_input_text("pm_max_user_messages", (isset($default_forum_settings['pm_max_user_messages'])) ? $default_forum_settings['pm_max_user_messages'] : "100", 10, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"3\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_18']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_19']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_20']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['searchenginespidering']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['allowsearchenginespidering']}:</td>\n";
echo "                        <td>", form_radio("allow_search_spidering", "Y", $lang['yes'], (isset($default_forum_settings['allow_search_spidering']) && $default_forum_settings['allow_search_spidering'] == 'Y')), "&nbsp;", form_radio("allow_search_spidering", "N", $lang['no'], (isset($default_forum_settings['allow_search_spidering']) && $default_forum_settings['allow_search_spidering'] == 'N') || !isset($default_forum_settings['allow_search_spidering'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_28']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['guestaccount']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['enableguestaccount']}:</td>\n";
echo "                        <td>", form_radio("guest_account_enabled", "Y", $lang['yes'], (isset($default_forum_settings['guest_account_enabled']) && $default_forum_settings['guest_account_enabled'] == 'Y') || !isset($default_forum_settings['guest_account_enabled'])), "&nbsp;", form_radio("guest_account_enabled", "N", $lang['no'], (isset($default_forum_settings['guest_account_enabled']) && $default_forum_settings['guest_account_enabled'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['autologinguests']}:</td>\n";
echo "                        <td>", form_radio("guest_auto_logon", "Y", $lang['yes'], (isset($default_forum_settings['guest_auto_logon']) && $default_forum_settings['guest_auto_logon'] == 'Y') || !isset($default_forum_settings['guest_auto_logon'])), "&nbsp;", form_radio("guest_auto_logon", "N", $lang['no'], (isset($default_forum_settings['guest_auto_logon']) && $default_forum_settings['guest_auto_logon'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_21']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_22']}</p>\n";
echo "                        </td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['attachments']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['enableattachments']}:</td>\n";
echo "                        <td>", form_radio("attachments_enabled", "Y", $lang['yes'], (isset($default_forum_settings['attachments_enabled']) && $default_forum_settings['attachments_enabled'] == 'Y')), "&nbsp;", form_radio("attachments_enabled", "N", $lang['no'], (isset($default_forum_settings['attachments_enabled']) && $default_forum_settings['attachments_enabled'] == 'N') || !isset($default_forum_settings['attachments_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['allowembeddingofattachments']}:</td>\n";
echo "                        <td>", form_radio("attachments_allow_embed", "Y", $lang['yes'], (isset($default_forum_settings['attachments_allow_embed']) && $default_forum_settings['attachments_allow_embed'] == 'Y')), "&nbsp;", form_radio("attachments_allow_embed", "N", $lang['no'], (isset($default_forum_settings['attachments_allow_embed']) && $default_forum_settings['attachments_allow_embed'] == 'N') || !isset($default_forum_settings['attachments_allow_embed'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['usealtattachmentmethod']}:</td>\n";
echo "                        <td>", form_radio("attachment_use_old_method", "Y", $lang['yes'], (isset($default_forum_settings['attachment_use_old_method']) && $default_forum_settings['attachment_use_old_method'] == 'Y')), "&nbsp;", form_radio("attachment_use_old_method", "N", $lang['no'], (isset($default_forum_settings['attachment_use_old_method']) && $default_forum_settings['attachment_use_old_method'] == 'N') || !isset($default_forum_settings['attachment_use_old_method'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['attachmentdir']}:</td>\n";
echo "                        <td>", form_input_text("attachment_dir", (isset($default_forum_settings['attachment_dir'])) ? $default_forum_settings['attachment_dir'] : "attachments", 35, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"270\">{$lang['userattachmentspace']}:</td>\n";
echo "                        <td>", form_input_text("attachments_max_user_space", (isset($default_forum_settings['attachments_max_user_space'])) ? ($default_forum_settings['attachments_max_user_space'] / 1024) / 1024 : "1", 10, 32), "&nbsp;(MB)</td>\n";
echo "                      </tr>\n";

if (isset($default_forum_settings['attachments_enabled']) && $default_forum_settings['attachments_enabled'] == "Y") {

    if (!attachments_check_dir()) {

        echo "                      <tr>\n";
        echo "                        <td colspan=\"2\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td colspan=\"2\" align=\"center\">\n";
        echo "                          <table class=\"text_captcha_error\" width=\"95%\">\n";
        echo "                            <tr>\n";
        echo "                              <td width=\"30\"><img src=\"", style_image('warning.png'), "\" /></td>\n";
        echo "                              <td>{$lang['attachmentdirnotwritable']}</td>\n";
        echo "                            </tr>\n";
        echo "                          </table>\n";
        echo "                        </td>\n";
        echo "                      </tr>\n";
    }
}

echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_23']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_24']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_25']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_26']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_27']}</p>\n";
echo "                        </td>\n";
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
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>