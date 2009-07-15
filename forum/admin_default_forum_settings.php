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

/* $Id: admin_default_forum_settings.php,v 1.145 2009-07-15 11:37:24 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "text_captcha.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Load language file

$lang = load_language_file();

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Check we can access this page.

if (!(bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Location of the forum for various URLs

$forum_location = html_get_forum_uri();

// Array to hold error messages

$error_msg_array = array();

// Variable to track creation of text-captcha directories.

$text_captcha_dir_created = false;

// Text captcha class

$text_captcha = new captcha(6, 15, 25, 9, 30);


// Array of valid periods for the unread cutoff

$unread_cutoff_periods = array(UNREAD_MESSAGES_DISABLED       => $lang['disableunreadmessages'],
                               THIRTY_DAYS_IN_SECONDS         => $lang['thirtynumberdays'],
                               SIXTY_DAYS_IN_SECONDS          => $lang['sixtynumberdays'],
                               NINETY_DAYS_IN_SECONDS         => $lang['ninetynumberdays'],
                               HUNDRED_EIGHTY_DAYS_IN_SECONDS => $lang['hundredeightynumberdays'],
                               YEAR_IN_SECONDS                => $lang['onenumberyear']);

// Array of valid periods for the sitemap frequency

$sitemap_freq_periods = array(DAY_IN_SECONDS  => $lang['onceaday'],
                              WEEK_IN_SECONDS => $lang['onceaweek']);

// Array of valid Google Adsense ad user account types

$adsense_user_type_array = array(ADSENSE_DISPLAY_NONE      => $lang['adsensenoone'],
                                 ADSENSE_DISPLAY_ALL_USERS => $lang['adsenseallusers'],
                                 ADSENSE_DISPLAY_GUESTS    => $lang['adsenseguestsonly']);

// Array of valid Google Adsense ad page types

$adsense_page_type_array = array(ADSENSE_DISPLAY_TOP_OF_ALL_PAGES => $lang['adsenseallpages'],
                                 ADSENSE_DISPLAY_TOP_OF_MESSAGES  => $lang['adsensetopofmessages'],
                                 ADSENSE_DISPLAY_AFTER_FIRST_MSG  => $lang['adsenseafterfirstmessage'],
                                 ADSENSE_DISPLAY_AFTER_THIRD_MSG  => $lang['adsenseafterthirdmessage'],
                                 ADSENSE_DISPLAY_AFTER_FIFTH_MSG  => $lang['adsenseafterfifthmessage'],
                                 ADSENSE_DISPLAY_AFTER_TENTH_MSG  => $lang['adsenseaftertenthmessage'],
                                 ADSENSE_DISPLAY_AFTER_RANDOM_MSG => $lang['adsenseafterrandommessage']);

// Submit code.

if (isset($_POST['save']) || isset($_POST['confirm_unread_cutoff']) || isset($_POST['cancel_unread_cutoff'])) {

    $valid = true;

    if (isset($_POST['cancel_unread_cutoff'])) unset($_POST['messages_unread_cutoff']);

    if (isset($_POST['forum_name']) && strlen(trim(stripslashes_array($_POST['forum_name']))) > 0) {
        $new_forum_settings['forum_name'] = trim(stripslashes_array($_POST['forum_name']));
    }else {
        $error_msg_array[] = $lang['mustsupplyforumname'];
        $valid = false;
    }

    if (isset($_POST['forum_email']) && strlen(trim(stripslashes_array($_POST['forum_email']))) > 0) {
        $new_forum_settings['forum_email'] = trim(stripslashes_array($_POST['forum_email']));
    }else {
        $new_forum_settings['forum_email'] = "admin@abeehiveforum.net";
    }

    if (isset($_POST['forum_noreply_email']) && strlen(trim(stripslashes_array($_POST['forum_noreply_email']))) > 0) {
        $new_forum_settings['forum_noreply_email'] = trim(stripslashes_array($_POST['forum_noreply_email']));
    }else {
        $new_forum_settings['forum_noreply_email'] = "noreply@abeehiveforum.net";
    }

    if (isset($_POST['forum_desc']) && strlen(trim(stripslashes_array($_POST['forum_desc']))) > 0) {
        $new_forum_settings['forum_desc'] = trim(stripslashes_array($_POST['forum_desc']));
    }else {
        $new_forum_settings['forum_desc'] = "";
    }

    if (isset($_POST['forum_keywords']) && strlen(trim(stripslashes_array($_POST['forum_keywords']))) > 0) {
        $new_forum_settings['forum_keywords'] = trim(stripslashes_array($_POST['forum_keywords']));
    }else {
        $new_forum_settings['forum_keywords'] = "";
    }

    if (isset($_POST['messages_unread_cutoff']) && in_array($_POST['messages_unread_cutoff'], array_keys($unread_cutoff_periods))) {
        $new_forum_settings['messages_unread_cutoff'] = $_POST['messages_unread_cutoff'];
    }else {
        $new_forum_settings['messages_unread_cutoff'] = forum_get_setting('messages_unread_cutoff', false, YEAR_IN_SECONDS);
    }

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

            $error_msg_array[] = $lang['activesessiongreaterthansession'];
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

    if (isset($_POST['forum_rules_enabled']) && $_POST['forum_rules_enabled'] == "Y") {
        $new_forum_settings['forum_rules_enabled'] = "Y";
    }else {
        $new_forum_settings['forum_rules_enabled'] = "N";
    }

    if (isset($_POST['forum_rules_message']) && strlen(trim(stripslashes_array($_POST['forum_rules_message']))) > 0) {
        $new_forum_settings['forum_rules_message'] = trim(stripslashes_array($_POST['forum_rules_message']));
    }else {
        $new_forum_settings['forum_rules_message'] = "";
    }

    if (isset($_POST['enable_google_analytics']) && $_POST['enable_google_analytics'] == "Y") {
        $new_forum_settings['enable_google_analytics'] = "Y";
    }else {
        $new_forum_settings['enable_google_analytics'] = "N";
    }

    if (isset($_POST['allow_forum_google_analytics']) && $_POST['allow_forum_google_analytics'] == "Y") {
        $new_forum_settings['allow_forum_google_analytics'] = "Y";
    }else {
        $new_forum_settings['allow_forum_google_analytics'] = "N";
    }

    if (isset($_POST['google_analytics_code']) && strlen(trim(stripslashes_array($_POST['google_analytics_code']))) > 0) {
        $new_forum_settings['google_analytics_code'] = trim(stripslashes_array($_POST['google_analytics_code']));
    }else {
        $new_forum_settings['google_analytics_code'] = "";
    }

    if (isset($_POST['adsense_publisher_id']) && strlen(trim(stripslashes_array($_POST['adsense_publisher_id']))) > 0) {
        $new_forum_settings['adsense_publisher_id'] = trim(stripslashes_array($_POST['adsense_publisher_id']));
    }else {
        $new_forum_settings['adsense_publisher_id'] = '';
    }

    if (isset($_POST['adsense_medium_ad_id']) && strlen(trim(stripslashes_array($_POST['adsense_medium_ad_id']))) > 0) {
        $new_forum_settings['adsense_medium_ad_id'] = trim(stripslashes_array($_POST['adsense_medium_ad_id']));
    }else {
        $new_forum_settings['adsense_medium_ad_id'] = '';
    }

    if (isset($_POST['adsense_small_ad_id']) && strlen(trim(stripslashes_array($_POST['adsense_small_ad_id']))) > 0) {
        $new_forum_settings['adsense_small_ad_id'] = trim(stripslashes_array($_POST['adsense_small_ad_id']));
    }else {
        $new_forum_settings['adsense_small_ad_id'] = '';
    }

    if (isset($_POST['adsense_display_users']) && in_array($_POST['adsense_display_users'], array_keys($adsense_user_type_array))) {
        $new_forum_settings['adsense_display_users'] = $_POST['adsense_display_users'];
    }else {
        $new_forum_settings['adsense_display_users'] = ADSENSE_DISPLAY_NONE;
    }

    if (isset($_POST['adsense_display_pages']) && in_array($_POST['adsense_display_pages'], array_keys($adsense_page_type_array))) {
        $new_forum_settings['adsense_display_pages'] = $_POST['adsense_display_pages'];
    }else {
        $new_forum_settings['adsense_display_pages'] = ADSENSE_DISPLAY_TOP_OF_ALL_PAGES;
    }

    if (isset($_POST['text_captcha_enabled']) && $_POST['text_captcha_enabled'] == "Y") {
        $new_forum_settings['text_captcha_enabled'] = "Y";
    }else {
        $new_forum_settings['text_captcha_enabled'] = "N";
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

    if (isset($_POST['new_user_pm_notify']) && $_POST['new_user_pm_notify'] == "Y") {
        $new_forum_settings['new_user_pm_notify'] = "Y";
    }else {
        $new_forum_settings['new_user_pm_notify'] = "N";
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

    if (isset($_POST['sitemap_enabled']) && $_POST['sitemap_enabled'] == "Y") {
        $new_forum_settings['sitemap_enabled'] = "Y";
    }else {
        $new_forum_settings['sitemap_enabled'] = "N";
    }

    if (isset($_POST['sitemap_freq']) && in_array($_POST['sitemap_freq'], array_keys($sitemap_freq_periods))) {
        $new_forum_settings['sitemap_freq'] = $_POST['sitemap_freq'];
    }else {
        $new_forum_settings['sitemap_freq'] = DAY_IN_SECONDS;
    }

    if (isset($_POST['allow_username_changes']) && $_POST['allow_username_changes'] == "Y") {
        $new_forum_settings['allow_username_changes'] = "Y";
    }else {
        $new_forum_settings['allow_username_changes'] = "N";
    }

    if (isset($_POST['require_user_approval']) && $_POST['require_user_approval'] == "Y") {
        $new_forum_settings['require_user_approval'] = "Y";
    }else {
        $new_forum_settings['require_user_approval'] = "N";
    }

    if (isset($_POST['send_new_user_email']) && $_POST['send_new_user_email'] == "Y") {
        $new_forum_settings['send_new_user_email'] = "Y";
    }else {
        $new_forum_settings['send_new_user_email'] = "N";
    }

    if (isset($_POST['guest_account_enabled']) && $_POST['guest_account_enabled'] == "Y") {
        $new_forum_settings['guest_account_enabled'] = "Y";
    }else {
        $new_forum_settings['guest_account_enabled'] = "N";
    }

    if (isset($_POST['guest_show_recent']) && $_POST['guest_show_recent'] == "Y") {
        $new_forum_settings['guest_show_recent'] = "Y";
    }else {
        $new_forum_settings['guest_show_recent'] = "N";
    }

    if (isset($_POST['attachments_enabled']) && $_POST['attachments_enabled'] == "Y") {
        $new_forum_settings['attachments_enabled'] = "Y";
    }else {
        $new_forum_settings['attachments_enabled'] = "N";
    }

    if (isset($_POST['attachment_dir']) && strlen(trim(stripslashes_array($_POST['attachment_dir']))) > 0) {

        $new_forum_settings['attachment_dir'] = trim(stripslashes_array($_POST['attachment_dir']));

    }elseif (mb_strtoupper($new_forum_settings['attachments_enabled']) == "Y") {

        $error_msg_array[] = $lang['attachmentdirblank'];
        $valid = false;
    }

    if (isset($_POST['attachments_max_user_space']) && is_numeric($_POST['attachments_max_user_space'])) {
        $new_forum_settings['attachments_max_user_space'] = ($_POST['attachments_max_user_space'] * 1024) * 1024;
    }else {
        $new_forum_settings['attachments_max_user_space'] = 1048576; // 1MB in bytes
    }
    
    if (isset($_POST['attachments_max_post_space']) && is_numeric($_POST['attachments_max_post_space'])) {
        $new_forum_settings['attachments_max_post_space'] = ($_POST['attachments_max_post_space'] * 1024) * 1024;
    }else {
        $new_forum_settings['attachments_max_post_space'] = 1048576; // 1MB in bytes
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

    if (isset($_POST['attachment_allow_guests']) && $_POST['attachment_allow_guests'] == "Y") {
        $new_forum_settings['attachment_allow_guests'] = "Y";
    }else {
        $new_forum_settings['attachment_allow_guests'] = "N";
    }

    if ($valid) {

        $unread_cutoff_stamp = $new_forum_settings['messages_unread_cutoff'];

        $previous_unread_cutoff_stamp = forum_get_unread_cutoff();

        if (!isset($_POST['confirm_unread_cutoff'])) {

            if (($unread_cutoff_stamp > 0) && ($previous_unread_cutoff_stamp !== false) && ($unread_cutoff_stamp != $previous_unread_cutoff_stamp)) {

                html_draw_top();

                echo "<h1>{$lang['admin']} &raquo; {$lang['globalforumsettings']}</h1>\n";
                echo "<br />\n";
                echo "<div align=\"center\">\n";
                echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_default_forum_settings.php\" method=\"post\" target=\"_self\">\n";
                echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
                echo "  ", form_input_hidden_array(stripslashes_array($_POST)), "\n";
                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
                echo "    <tr>\n";
                echo "      <td align=\"left\">\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['warning_caps']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";

                if ($unread_cutoff_stamp > $previous_unread_cutoff_stamp) {

                    echo "                      <tr>\n";
                    echo "                        <td>{$lang['unreadcutoffincreasewarning']}</td>\n";
                    echo "                      </tr>\n";
                    echo "                      <tr>\n";
                    echo "                        <td>&nbsp;</td>\n";
                    echo "                      </tr>\n";
                }

                echo "                      <tr>\n";
                echo "                        <td>{$lang['unreadcutoffchangewarning']}</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td>&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td>{$lang['confirmunreadcutoff']}</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td>&nbsp;</td>\n";
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
                echo "      <td align=\"center\">", form_submit("confirm_unread_cutoff", $lang['yes']), "&nbsp;", form_submit("cancel_unread_cutoff", $lang['no']), "</td>\n";
                echo "    </tr>\n";
                echo "  </table>\n";
                echo "</form>\n";
                echo "</div>\n";

                html_display_warning_msg($lang['otherchangeswillstillbeapplied'], '600', 'center');

                html_draw_bottom();
                exit;
            }
        }

        if (forum_save_default_settings($new_forum_settings)) {

            if (isset($_POST['confirm_unread_cutoff'])) forum_update_unread_data($unread_cutoff_stamp);

            header_redirect("admin_default_forum_settings.php?webtag=$webtag&updated=true", $lang['forumsettingsupdated']);

        }else {

            $valid = false;
            $error_msg_array[] = $lang['failedtoupdateforumsettings'];
        }
    }

    $forum_global_settings = array_merge($forum_global_settings, $new_forum_settings);
}

// Start Output Here

html_draw_top("onunload=clearFocus()", "admin.js", "emoticons.js", "htmltools.js");

echo "<h1>{$lang['admin']} &raquo; {$lang['globalforumsettings']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'center');

}else {

    html_display_warning_msg($lang['settingsaffectallforumswarning'], '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_default_forum_settings.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mainsettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumname']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_name", (isset($forum_global_settings['forum_name']) ? htmlentities_array($forum_global_settings['forum_name']) : 'A Beehive Forum'), 42, 255), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumemail']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_email", (isset($forum_global_settings['forum_email']) ? htmlentities_array($forum_global_settings['forum_email']) : 'admin@abeehiveforum.net'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumnoreplyemail']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_noreply_email", (isset($forum_global_settings['forum_noreply_email']) ? htmlentities_array($forum_global_settings['forum_noreply_email']) : 'noreply@abeehiveforum.net'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumdesc']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_desc", (isset($forum_global_settings['forum_desc']) ? htmlentities_array($forum_global_settings['forum_desc']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumkeywords']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_keywords", (isset($forum_global_settings['forum_keywords']) ? htmlentities_array($forum_global_settings['forum_keywords']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_56']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_57']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['postoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['unreadmessagescutoff']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("messages_unread_cutoff", $unread_cutoff_periods, (isset($forum_global_settings['messages_unread_cutoff']) && in_array($forum_global_settings['messages_unread_cutoff'], array_keys($unread_cutoff_periods))) ? $forum_global_settings['messages_unread_cutoff'] : YEAR_IN_SECONDS), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_48']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_49']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['searchoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['searchfrequency']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("search_min_frequency", (isset($forum_global_settings['search_min_frequency'])) ? htmlentities_array($forum_global_settings['search_min_frequency']) : "30", 10, 3), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_39']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['sessions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['sessioncutoffseconds']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("session_cutoff", (isset($forum_global_settings['session_cutoff'])) ? htmlentities_array($forum_global_settings['session_cutoff']) : "86400", 20, 6), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['activesessioncutoffseconds']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("active_sess_cutoff", (isset($forum_global_settings['active_sess_cutoff'])) ? htmlentities_array($forum_global_settings['active_sess_cutoff']) : "900", 20, 6), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_15']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_16']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['newuserregistrations']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">{$lang['allownewuserregistrations']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_new_registrations", "Y", $lang['yes'], (isset($forum_global_settings['allow_new_registrations']) && $forum_global_settings['allow_new_registrations'] == 'Y') || !isset($forum_global_settings['allow_new_registrations'])), "&nbsp;", form_radio("allow_new_registrations", "N", $lang['no'], (isset($forum_global_settings['allow_new_registrations']) && $forum_global_settings['allow_new_registrations'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">{$lang['preventduplicateemailaddresses']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("require_unique_email", "Y", $lang['yes'], (isset($forum_global_settings['require_unique_email']) && $forum_global_settings['require_unique_email'] == 'Y')), "&nbsp;", form_radio("require_unique_email", "N", $lang['no'], (isset($forum_global_settings['require_unique_email']) && $forum_global_settings['require_unique_email'] == 'N') || !isset($forum_global_settings['require_unique_email'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">{$lang['requireemailconfirmation']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("require_email_confirmation", "Y", $lang['yes'], (isset($forum_global_settings['require_email_confirmation']) && $forum_global_settings['require_email_confirmation'] == 'Y')), "&nbsp;", form_radio("require_email_confirmation", "N", $lang['no'], (isset($forum_global_settings['require_email_confirmation']) && $forum_global_settings['require_email_confirmation'] == 'N') || !isset($forum_global_settings['require_email_confirmation'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['requireforumrulesagreement']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("forum_rules_enabled", "Y", $lang['yes'] , ((isset($forum_global_settings['forum_rules_enabled']) && $forum_global_settings['forum_rules_enabled'] == 'Y') || !isset($forum_global_settings['forum_rules_enabled']))), "&nbsp;", form_radio("forum_rules_enabled", "N", $lang['no'] , (isset($forum_global_settings['forum_rules_enabled']) && $forum_global_settings['forum_rules_enabled'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['requireuserapproval']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("require_user_approval", "Y", $lang['yes'], (isset($forum_global_settings['require_user_approval']) && $forum_global_settings['require_user_approval'] == "Y")), "&nbsp;", form_radio("require_user_approval", "N", $lang['no'], (isset($forum_global_settings['require_user_approval']) && $forum_global_settings['require_user_approval'] == "N") || !isset($forum_global_settings['require_user_approval'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['sendnewuseremailnotifications']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("send_new_user_email", "Y", $lang['yes'] , (isset($forum_global_settings['send_new_user_email']) && $forum_global_settings['send_new_user_email'] == 'Y')), "&nbsp;", form_radio("send_new_user_email", "N", $lang['no'] , (isset($forum_global_settings['send_new_user_email']) && ($forum_global_settings['send_new_user_email'] == 'N') || !isset($forum_global_settings['send_new_user_email']))), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">{$lang['usetextcaptcha']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("text_captcha_enabled", "Y", $lang['yes'], (isset($forum_global_settings['text_captcha_enabled']) && $forum_global_settings['text_captcha_enabled'] == 'Y')), "&nbsp;", form_radio("text_captcha_enabled", "N", $lang['no'], (isset($forum_global_settings['text_captcha_enabled']) && $forum_global_settings['text_captcha_enabled'] == 'N') || !isset($forum_global_settings['text_captcha_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";

if (isset($forum_global_settings['text_captcha_enabled']) && $forum_global_settings['text_captcha_enabled'] == "Y") {

    if (!$text_captcha->generate_keys() || !$text_captcha->make_image()) {

        if (($errno = $text_captcha->get_error())) {

            switch ($errno) {

                case TEXT_CAPTCHA_NO_FONTS:

                    html_display_error_msg($lang['textcaptchafonterror'], '95%', 'center');
                    break;

                case TEXT_CAPTCHA_DIR_ERROR:

                    html_display_error_msg($lang['textcaptchadirerror'], '95%', 'center');
                    break;

                case TEXT_CAPTCHA_GD_ERROR:

                    html_display_error_msg($lang['textcaptchagderror'], '95%', 'center');
                    break;
            }
        }
    }
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_29']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_42']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_43']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_50']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_44']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['googleanalytics']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['enablegoogleanalytics']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_google_analytics", "Y", $lang['yes'], (isset($forum_global_settings['enable_google_analytics']) && $forum_global_settings['enable_google_analytics'] == "Y")), "&nbsp;", form_radio("enable_google_analytics", "N", $lang['no'], (isset($forum_global_settings['enable_google_analytics']) && $forum_global_settings['enable_google_analytics'] == "N") || !isset($forum_global_settings['enable_google_analytics'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['allowforumgoogleanalytics']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_forum_google_analytics", "Y", $lang['yes'], (isset($forum_global_settings['allow_forum_google_analytics']) && $forum_global_settings['allow_forum_google_analytics'] == "Y")), "&nbsp;", form_radio("allow_forum_google_analytics", "N", $lang['no'], (isset($forum_global_settings['allow_forum_google_analytics']) && $forum_global_settings['allow_forum_google_analytics'] == "N") || !isset($forum_global_settings['allow_forum_google_analytics'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['googleanalyticsaccountid']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("google_analytics_code", (isset($forum_global_settings['google_analytics_code']) ? htmlentities_array($forum_global_settings['google_analytics_code']) : ''), 31, 20), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_61']}</p>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\" colspan=\"2\">\n";

html_display_warning_msg($lang['forum_settings_help_62'], '95%', 'center');

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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['googleadsense']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"255\" nowrap=\"nowrap\">{$lang['adsensepublisherid']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("adsense_publisher_id", (isset($forum_global_settings['adsense_publisher_id']) ? htmlentities_array($forum_global_settings['adsense_publisher_id']) : ''), 25, 40), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['adsensemediumadid']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("adsense_medium_ad_id", (isset($forum_global_settings['adsense_medium_ad_id']) ? htmlentities_array($forum_global_settings['adsense_medium_ad_id']) : ''), 25, 40), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['adsensesmalladid']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("adsense_small_ad_id", (isset($forum_global_settings['adsense_small_ad_id']) ? htmlentities_array($forum_global_settings['adsense_small_ad_id']) : ''), 25, 40), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['adsensedisplayadsforusers']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('adsense_display_users', $adsense_user_type_array, (isset($forum_global_settings['adsense_display_users']) && in_array($forum_global_settings['adsense_display_users'], array_keys($adsense_user_type_array)) ? $forum_global_settings['adsense_display_users'] : ADSENSE_DISPLAY_NONE)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['adsensedisplayadsonpages']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('adsense_display_pages', $adsense_page_type_array, (isset($forum_global_settings['adsense_display_pages']) && in_array($forum_global_settings['adsense_display_pages'], array_keys($adsense_page_type_array)) ? $forum_global_settings['adsense_display_pages'] : ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_66']}</p>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\" colspan=\"2\">\n";


html_display_warning_msg($lang['forum_settings_help_63'], '95%', 'center');
html_display_warning_msg($lang['forum_settings_help_64'], '95%', 'center');

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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['newuserpreferences']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['sendemailnotificationonreply']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_email_notify", "Y", $lang['yes'], (isset($forum_global_settings['new_user_email_notify']) && $forum_global_settings['new_user_email_notify'] == 'Y') || !isset($forum_global_settings['new_user_email_notify'])), "&nbsp;", form_radio("new_user_email_notify", "N", $lang['no'], (isset($forum_global_settings['new_user_email_notify']) && $forum_global_settings['new_user_email_notify'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['sendemailnotificationonpm']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_pm_notify_email", "Y", $lang['yes'], (isset($forum_global_settings['new_user_pm_notify_email']) && $forum_global_settings['new_user_pm_notify_email'] == 'Y') || !isset($forum_global_settings['new_user_pm_notify_email'])), "&nbsp;", form_radio("new_user_pm_notify_email", "N", $lang['no'], (isset($forum_global_settings['new_user_pm_notify_email']) && $forum_global_settings['new_user_pm_notify_email'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['showpopuponnewpm']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_pm_notify", "Y", $lang['yes'], (isset($forum_global_settings['new_user_pm_notify']) && $forum_global_settings['new_user_pm_notify'] == 'Y') || !isset($forum_global_settings['new_user_pm_notify'])), "&nbsp;", form_radio("new_user_pm_notify", "N", $lang['no'], (isset($forum_global_settings['new_user_pm_notify']) && $forum_global_settings['new_user_pm_notify'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['setautomatichighinterestonpost']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_mark_as_of_int", "Y", $lang['yes'], (isset($forum_global_settings['new_user_mark_as_of_int']) && $forum_global_settings['new_user_mark_as_of_int'] == 'Y') || !isset($forum_global_settings['new_user_mark_as_of_int'])), "&nbsp;", form_radio("new_user_mark_as_of_int", "N", $lang['no'], (isset($forum_global_settings['new_user_mark_as_of_int']) && $forum_global_settings['new_user_mark_as_of_int'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_41']}</p>\n";
echo "                        </td>\n";
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

$forum_rules = new TextAreaHTML("prefsform");

echo $forum_rules->preload();

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

$frame_top_target = html_get_top_frame_name();

$cancel_link = "<a href=\"index.php?webtag=$webtag\" target=\"$frame_top_target\">{$lang['cancellinktext']}</a>";

$default_forum_rules = sprintf($lang['forumrulesmessage'], $forum_name, $cancel_link);

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if (!isset($forum_global_settings['forum_rules_message'])) $forum_global_settings['forum_rules_message'] = $default_forum_rules;

$forum_rules_message = new MessageText(POST_HTML_AUTO, $forum_global_settings['forum_rules_message'], true, true);

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['forumrules']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if ($tool_type <> POST_TOOLBAR_DISABLED) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", $forum_rules->toolbar(true), "</td>\n";
    echo "                      </tr>\n";

}else {

    $forum_rules->setTinyMCE(false);
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", $forum_rules->textarea("forum_rules_message", $forum_rules_message->getTidyContent(), 10, 80, "", "admin_startpage_textarea"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $forum_rules->js(false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_54']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_55']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['personalmessages']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['enablepersonalmessages']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("show_pms", "Y", $lang['yes'] , ((isset($forum_global_settings['show_pms']) && $forum_global_settings['show_pms'] == 'Y'))), "&nbsp;", form_radio("show_pms", "N", $lang['no'] , (isset($forum_global_settings['show_pms']) && $forum_global_settings['show_pms'] == 'N') || !isset($forum_global_settings['show_pms'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">{$lang['autopruneuserspmfoldersevery']} ", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($forum_global_settings['pm_auto_prune']) ? ($forum_global_settings['pm_auto_prune'] > 0 ? $forum_global_settings['pm_auto_prune'] : $forum_global_settings['pm_auto_prune'] * -1) : 4)), " {$lang['days']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("pm_auto_prune_enabled", "Y", $lang['yes'], (isset($forum_global_settings['pm_auto_prune']) && $forum_global_settings['pm_auto_prune'] > 0)), "&nbsp;", form_radio("pm_auto_prune_enabled", "N", $lang['no'] , ((isset($forum_global_settings['pm_auto_prune']) && $forum_global_settings['pm_auto_prune'] < 0)) || !isset($forum_global_settings['pm_auto_prune'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['allowpmstohaveattachments']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("pm_allow_attachments", "Y", $lang['yes'] , (isset($forum_global_settings['pm_allow_attachments']) && $forum_global_settings['pm_allow_attachments'] == 'Y')), "&nbsp;", form_radio("pm_allow_attachments", "N", $lang['no'] , ((isset($forum_global_settings['pm_allow_attachments']) && $forum_global_settings['pm_allow_attachments'] == 'N')) || !isset($forum_global_settings['pm_allow_attachments'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['pmusermessages']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("pm_max_user_messages", (isset($forum_global_settings['pm_max_user_messages'])) ? htmlentities_array($forum_global_settings['pm_max_user_messages']) : "100", 10, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_18']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_19']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_20']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['searchenginespidering']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['allowsearchenginespidering']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_search_spidering", "Y", $lang['yes'], (isset($forum_global_settings['allow_search_spidering']) && $forum_global_settings['allow_search_spidering'] == 'Y')), "&nbsp;", form_radio("allow_search_spidering", "N", $lang['no'], (isset($forum_global_settings['allow_search_spidering']) && $forum_global_settings['allow_search_spidering'] == 'N') || !isset($forum_global_settings['allow_search_spidering'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['sitemapenabled']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("sitemap_enabled", "Y", $lang['yes'], (isset($forum_global_settings['sitemap_enabled']) && $forum_global_settings['sitemap_enabled'] == 'Y')), "&nbsp;", form_radio("sitemap_enabled", "N", $lang['no'], (isset($forum_global_settings['sitemap_enabled']) && $forum_global_settings['sitemap_enabled'] == 'N') || !isset($forum_global_settings['sitemap_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['sitemapupdatefrequency']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("sitemap_freq", $sitemap_freq_periods, (isset($forum_global_settings['sitemap_freq']) && in_array($forum_global_settings['sitemap_freq'], array_keys($sitemap_freq_periods))) ? $forum_global_settings['sitemap_freq'] : DAY_IN_SECONDS), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_28']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_58']}</p>\n";

if (isset($forum_global_settings['sitemap_enabled']) && $forum_global_settings['sitemap_enabled'] == "Y") {

    if (!sitemap_get_dir()) {

        html_display_error_msg($lang['sitemappathnotwritable'], '95%', 'center');

    }
}

echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_59']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_60']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userandguestoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['allowuserstochangeusername']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_username_changes", "Y", $lang['yes'], (isset($forum_global_settings['allow_username_changes']) && $forum_global_settings['allow_username_changes'] == "Y")), "&nbsp;", form_radio("allow_username_changes", "N", $lang['no'], (isset($forum_global_settings['allow_username_changes']) && $forum_global_settings['allow_username_changes'] == "N") || !isset($forum_global_settings['allow_username_changes'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['enableguestaccount']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_account_enabled", "Y", $lang['yes'], (isset($forum_global_settings['guest_account_enabled']) && $forum_global_settings['guest_account_enabled'] == 'Y') || !isset($forum_global_settings['guest_account_enabled'])), "&nbsp;", form_radio("guest_account_enabled", "N", $lang['no'], (isset($forum_global_settings['guest_account_enabled']) && $forum_global_settings['guest_account_enabled'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['listguestsinvisitorlog']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_show_recent", "Y", $lang['yes'], (isset($forum_global_settings['guest_show_recent']) && $forum_global_settings['guest_show_recent'] == 'Y') || !isset($forum_global_settings['guest_show_recent'])), "&nbsp;", form_radio("guest_show_recent", "N", $lang['no'], (isset($forum_global_settings['guest_show_recent']) && $forum_global_settings['guest_show_recent'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_53']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_21']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_22']}</p>\n";
echo "                        </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['attachments']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['enableattachments']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("attachments_enabled", "Y", $lang['yes'], (isset($forum_global_settings['attachments_enabled']) && $forum_global_settings['attachments_enabled'] == 'Y')), "&nbsp;", form_radio("attachments_enabled", "N", $lang['no'], (isset($forum_global_settings['attachments_enabled']) && $forum_global_settings['attachments_enabled'] == 'N') || !isset($forum_global_settings['attachments_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['allowembeddingofattachments']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("attachments_allow_embed", "Y", $lang['yes'], (isset($forum_global_settings['attachments_allow_embed']) && $forum_global_settings['attachments_allow_embed'] == 'Y')), "&nbsp;", form_radio("attachments_allow_embed", "N", $lang['no'], (isset($forum_global_settings['attachments_allow_embed']) && $forum_global_settings['attachments_allow_embed'] == 'N') || !isset($forum_global_settings['attachments_allow_embed'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['usealtattachmentmethod']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("attachment_use_old_method", "Y", $lang['yes'], (isset($forum_global_settings['attachment_use_old_method']) && $forum_global_settings['attachment_use_old_method'] == 'Y')), "&nbsp;", form_radio("attachment_use_old_method", "N", $lang['no'], (isset($forum_global_settings['attachment_use_old_method']) && $forum_global_settings['attachment_use_old_method'] == 'N') || !isset($forum_global_settings['attachment_use_old_method'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['allowgueststoaccessattachments']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("attachment_allow_guests", "Y", $lang['yes'], (isset($forum_global_settings['attachment_allow_guests']) && $forum_global_settings['attachment_allow_guests'] == 'Y')), "&nbsp;", form_radio("attachment_allow_guests", "N", $lang['no'], (isset($forum_global_settings['attachment_allow_guests']) && $forum_global_settings['attachment_allow_guests'] == 'N') || !isset($forum_global_settings['attachment_allow_guests'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['attachmentdir']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachment_dir", (isset($forum_global_settings['attachment_dir'])) ? htmlentities_array($forum_global_settings['attachment_dir']) : "attachments", 35, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['userattachmentspace']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachments_max_user_space", (isset($forum_global_settings['attachments_max_user_space'])) ? htmlentities_array(($forum_global_settings['attachments_max_user_space'] / 1024) / 1024) : "1", 10, 32), "&nbsp;(MB)</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">{$lang['userattachmentspaceperpost']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachments_max_post_space", (isset($forum_global_settings['attachments_max_post_space'])) ? htmlentities_array(($forum_global_settings['attachments_max_post_space'] / 1024) / 1024) : "1", 10, 32), "&nbsp;(MB)</td>\n";
echo "                      </tr>\n";

if (isset($forum_global_settings['attachments_enabled']) && $forum_global_settings['attachments_enabled'] == "Y") {

    if (!attachments_check_dir()) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td colspan=\"2\">\n";

        html_display_error_msg($lang['attachmentdirnotwritable'], '95%', 'center');

        echo "                        </td>\n";
        echo "                      </tr>\n";
    }
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_23']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_24']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_25']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_26']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_27']}</p>\n";
echo "                        </td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>