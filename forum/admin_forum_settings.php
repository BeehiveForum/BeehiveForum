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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
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
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
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

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Get the user's post page preferences.
$page_prefs = bh_session_get_post_page_prefs();

// Check to see if the user can access this page.
if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Content Ratings
$content_ratings_array = array(FORUM_RATING_GENERAL    => 'General',
                               FORUM_RATING_FOURTEEN   => '14 Years',
                               FORUM_RATING_MATURE     => 'Mature',
                               FORUM_RATING_RESTRICTED => 'Restricted');

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

// Array to hold error messages.
$error_msg_array = array();

// Get an array of available emoticon sets
$available_emoticons = emoticons_get_available();

// Get an array of available languages
$available_langs = lang_get_available(false);

// Get an array of available timezones.
$available_timezones = get_available_timezones();

// Submit code starts here
if (isset($_POST['changepermissions'])) {

    $redirect_uri = "admin_forum_access.php?webtag=$webtag&fid={$forum_settings['fid']}";
    $redirect_uri.= "&ret=". rawurlencode(get_request_uri(true, false));

    header_redirect($redirect_uri);
    exit;

}elseif (isset($_POST['changepassword'])) {

    $redirect_uri = "admin_forum_set_passwd.php?webtag=$webtag&fid={$forum_settings['fid']}";
    $redirect_uri.= "&ret=". rawurlencode(get_request_uri(true, false));

    header_redirect($redirect_uri);
    exit;

}elseif (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['forum_name']) && strlen(trim(stripslashes_array($_POST['forum_name']))) > 0) {
        $new_forum_settings['forum_name'] = trim(stripslashes_array($_POST['forum_name']));
    }else {
        $error_msg_array[] = $lang['mustsupplyforumname'];
        $valid = false;
    }

    if (isset($_POST['forum_email']) && strlen(trim(stripslashes_array($_POST['forum_email']))) > 0) {
        $new_forum_settings['forum_email'] = trim(stripslashes_array($_POST['forum_email']));
    }else {
        $error_msg_array[] = $lang['mustsupplyforumemail'];
        $valid = false;
    }

    if (isset($_POST['forum_desc']) && strlen(trim(stripslashes_array($_POST['forum_desc']))) > 0) {
        $new_forum_settings['forum_desc'] = trim(stripslashes_array($_POST['forum_desc']));
    }else {
        $new_forum_settings['forum_desc'] = "";
    }

    if (isset($_POST['forum_content_rating']) && is_numeric($_POST['forum_content_rating'])) {
        $new_forum_settings['forum_content_rating'] = $_POST['forum_content_rating'];
    }else {
        $new_forum_settings['forum_content_rating'] = FORUM_RATING_GENERAL;
    }

    if (isset($_POST['forum_keywords']) && strlen(trim(stripslashes_array($_POST['forum_keywords']))) > 0) {
        $new_forum_settings['forum_keywords'] = trim(stripslashes_array($_POST['forum_keywords']));
    }else {
        $new_forum_settings['forum_keywords'] = "";
    }

    if (isset($_POST['default_style']) && style_exists(trim(stripslashes_array($_POST['default_style'])))) {

        $new_forum_settings['default_style'] = trim(stripslashes_array($_POST['default_style']));

    }else {

        $error_msg_array[] = $lang['mustchoosedefaultstyle'];
        $valid = false;
    }

    if (isset($_POST['default_emoticons']) && strlen(trim(stripslashes_array($_POST['default_emoticons']))) > 0) {

        $new_forum_settings['default_emoticons'] = trim(stripslashes_array($_POST['default_emoticons']));

        if (!emoticons_set_exists($new_forum_settings['default_emoticons'])) {
            $error_msg_array[] = $lang['unknownemoticonsname'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustchoosedefaultemoticons'];
        $valid = false;
    }

    if (isset($_POST['default_language']) && in_array($_POST['default_language'], $available_langs)) {

        $new_forum_settings['default_language'] = $_POST['default_language'];

    }else {

        $error_msg_array[] = $lang['mustchoosedefaultlang'];
        $valid = false;
    }

    if (forum_get_global_setting('allow_forum_google_analytics', 'Y')) {

        if (isset($_POST['enable_google_analytics']) && $_POST['enable_google_analytics'] == "Y") {
            $new_forum_settings['enable_google_analytics'] = "Y";
        }else {
            $new_forum_settings['enable_google_analytics'] = "N";
        }

        if (isset($_POST['google_analytics_code']) && strlen(trim(stripslashes_array($_POST['google_analytics_code']))) > 0) {
            $new_forum_settings['google_analytics_code'] = trim(stripslashes_array($_POST['google_analytics_code']));
        }else {
            $new_forum_settings['google_analytics_code'] = "";
        }
    }

    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

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

    }else {

        $new_forum_settings['adsense_display_users'] = forum_get_global_setting('adsense_display_users', false, ADSENSE_DISPLAY_NONE);
        $new_forum_settings['adsense_display_pages'] = forum_get_global_setting('adsense_display_pages', false, ADSENSE_DISPLAY_TOP_OF_ALL_PAGES);
    }

    if (isset($_POST['forum_timezone']) && is_numeric($_POST['forum_timezone'])) {
        $new_forum_settings['forum_timezone'] = $_POST['forum_timezone'];
    }else {
        $new_forum_settings['forum_timezone'] = 27;
    }

    if (isset($_POST['forum_dl_saving']) && $_POST['forum_dl_saving'] == "Y") {
        $new_forum_settings['forum_dl_saving'] = "Y";
    }else {
        $new_forum_settings['forum_dl_saving'] = "N";
    }

    if (isset($_POST['access_level']) && is_numeric($_POST['access_level'])) {
        forum_update_access($forum_settings['fid'], $_POST['access_level']);
    }

    if (isset($_POST['closed_message']) && strlen(trim(stripslashes_array($_POST['closed_message']))) > 0) {
        $new_forum_settings['closed_message'] = trim(stripslashes_array($_POST['closed_message']));
    }else {
        $new_forum_settings['closed_message'] = "";
    }

    if (isset($_POST['restricted_message']) && strlen(trim(stripslashes_array($_POST['restricted_message']))) > 0) {
        $new_forum_settings['restricted_message'] = trim(stripslashes_array($_POST['restricted_message']));
    }else {
        $new_forum_settings['restricted_message'] = "";
    }

    if (isset($_POST['password_protected_message']) && strlen(trim(stripslashes_array($_POST['password_protected_message']))) > 0) {
        $new_forum_settings['password_protected_message'] = trim(stripslashes_array($_POST['password_protected_message']));
    }else {
        $new_forum_settings['password_protected_message'] = "";
    }

    if (isset($_POST['require_post_approval']) && $_POST['require_post_approval'] == "Y") {
        $new_forum_settings['require_post_approval'] = "Y";
    }else {
        $new_forum_settings['require_post_approval'] = "N";
    }

    if (isset($_POST['allow_post_editing']) && $_POST['allow_post_editing'] == "Y") {
        $new_forum_settings['allow_post_editing'] = "Y";
    }else {
        $new_forum_settings['allow_post_editing'] = "N";
    }

    if (isset($_POST['post_edit_time']) && is_numeric($_POST['post_edit_time'])) {
        $new_forum_settings['post_edit_time'] = $_POST['post_edit_time'];
    }else {
        $new_forum_settings['post_edit_time'] = 0;
    }

    if (isset($_POST['post_edit_grace_period']) && is_numeric($_POST['post_edit_grace_period'])) {
        $new_forum_settings['post_edit_grace_period'] = $_POST['post_edit_grace_period'];
    }else {
        $new_forum_settings['post_edit_grace_period'] = 0;
    }

    if (isset($_POST['maximum_post_length']) && is_numeric($_POST['maximum_post_length'])) {
        $new_forum_settings['maximum_post_length'] = $_POST['maximum_post_length'];
    }else {
        $new_forum_settings['maximum_post_length'] = 6226;
    }

    if (isset($_POST['minimum_post_frequency']) && is_numeric($_POST['minimum_post_frequency'])) {
        $new_forum_settings['minimum_post_frequency'] = $_POST['minimum_post_frequency'];
    }else {
        $new_forum_settings['minimum_post_frequency'] = 0;
    }

    if (isset($_POST['enable_wiki_integration']) && $_POST['enable_wiki_integration'] == "Y") {
        $new_forum_settings['enable_wiki_integration'] = "Y";
    }else {
        $new_forum_settings['enable_wiki_integration'] = "N";
    }

    if (isset($_POST['enable_wiki_quick_links']) && $_POST['enable_wiki_quick_links'] == "Y") {
        $new_forum_settings['enable_wiki_quick_links'] = "Y";
    }else {
        $new_forum_settings['enable_wiki_quick_links'] = "N";
    }

    if (isset($_POST['wiki_integration_uri']) && strlen(trim(stripslashes_array($_POST['wiki_integration_uri']))) > 0) {
        $new_forum_settings['wiki_integration_uri'] = trim(stripslashes_array($_POST['wiki_integration_uri']));
    }else {
        $new_forum_settings['wiki_integration_uri'] = "";
    }

    if (isset($_POST['show_links']) && $_POST['show_links'] == "Y") {
        $new_forum_settings['show_links'] = "Y";
    }else {
        $new_forum_settings['show_links'] = "N";
    }

    if (isset($_POST['allow_polls']) && $_POST['allow_polls'] == "Y") {
        $new_forum_settings['allow_polls'] = "Y";
    }else {
        $new_forum_settings['allow_polls'] = "N";
    }

    if (isset($_POST['poll_allow_guests']) && $_POST['poll_allow_guests'] == "Y") {
        $new_forum_settings['poll_allow_guests'] = "Y";
    }else {
        $new_forum_settings['poll_allow_guests'] = "N";
    }

    if (isset($_POST['show_stats']) && $_POST['show_stats'] == "Y") {
        $new_forum_settings['show_stats'] = "Y";
    }else {
        $new_forum_settings['show_stats'] = "N";
    }

    if (isset($_POST['allow_search_spidering']) && $_POST['allow_search_spidering'] == "Y") {
        $new_forum_settings['allow_search_spidering'] = "Y";
    }else {
        $new_forum_settings['allow_search_spidering'] = "N";
    }

    if (isset($_POST['searchbots_show_recent']) && $_POST['searchbots_show_recent'] == "Y") {
        $new_forum_settings['searchbots_show_recent'] = "Y";
    }else {
        $new_forum_settings['searchbots_show_recent'] = "N";
    }

    if (isset($_POST['searchbots_show_active']) && $_POST['searchbots_show_active'] == "Y") {
        $new_forum_settings['searchbots_show_active'] = "Y";
    }else {
        $new_forum_settings['searchbots_show_active'] = "N";
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

    if ($valid) {

        if (forum_save_settings($new_forum_settings)) {

            admin_add_log_entry(EDIT_FORUM_SETTINGS, $new_forum_settings['forum_name']);
            header_redirect("admin_forum_settings.php?webtag=$webtag&updated=true", $lang['forumsettingsupdated']);

        }else {

            $valid = false;
            $error_msg_array[] = $lang['failedtoupdateforumsettings'];
        }
    }
}

// Start Output Here
html_draw_top("title={$lang['admin']} - {$lang['forumsettings']}", 'class=window_title', "onunload=clearFocus()", "emoticons.js", "htmltools.js");

echo "<h1>{$lang['admin']}<img src=\"", style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$lang['forumsettings']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_forum_settings.php\" method=\"post\" target=\"_self\">\n";
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
echo "                        <td align=\"left\">", form_input_text("forum_name", (isset($forum_settings['forum_name']) ? htmlentities_array($forum_settings['forum_name']) : 'A Beehive Forum'), 42, 255), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumemail']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_email", (isset($forum_settings['forum_email']) ? htmlentities_array($forum_settings['forum_email']) : 'admin@abeehiveforum.net'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumdesc']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_desc", (isset($forum_settings['forum_desc']) ? htmlentities_array($forum_settings['forum_desc']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumkeywords']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_keywords", (isset($forum_settings['forum_keywords']) ? htmlentities_array($forum_settings['forum_keywords']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumcontentrating']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("forum_content_rating", htmlentities_array($content_ratings_array), (isset($forum_settings['forum_content_rating']) ? htmlentities_array($forum_settings['forum_content_rating']) : 0)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";

if (($available_styles = styles_get_available())) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">{$lang['defaultstyle']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("default_style", htmlentities_array($available_styles), (isset($forum_settings['default_style']) && style_exists($forum_settings['default_style']) ? htmlentities_array($forum_settings['default_style']) : 'default')), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultemoticons']} [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" class=\"popup 500x400\">{$lang['preview']}</a>]:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_emoticons", htmlentities_array($available_emoticons), (isset($forum_settings['default_emoticons']) && in_array($forum_settings['default_emoticons'], array_keys($available_emoticons)) ? $forum_settings['default_emoticons'] : 'none')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultlanguage']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_language", htmlentities_array($available_langs), (isset($forum_settings['default_language']) && in_array($forum_settings['default_language'], $available_langs) ? $forum_settings['default_language'] : 'en')), "</td>\n";
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
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['timezone']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['timezonefromGMT']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("forum_timezone", htmlentities_array($available_timezones), (isset($forum_settings['forum_timezone']) && is_numeric($forum_settings['forum_timezone']) ? $forum_settings['forum_timezone'] : 27), false, 'timezone_dropdown'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox("forum_dl_saving", "Y", $lang['daylightsaving'], (isset($forum_settings['forum_dl_saving']) && $forum_settings['forum_dl_saving'] == 'Y') ? true : false), "</td>\n";
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

if (!isset($forum_settings['access_level']) || $forum_settings['access_level'] > FORUM_DISABLED) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['forumaccesssettings']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">{$lang['forumaccessstatus']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_UNRESTRICTED, $lang['open'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_UNRESTRICTED ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_CLOSED, $lang['closed'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_CLOSED ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_RESTRICTED, $lang['restricted'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_RESTRICTED ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_PASSWD_PROTECTED, $lang['passwordprotected'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_PASSWD_PROTECTED ? true : false)), "</td>\n";
    echo "                      </tr>\n";

    if ($forum_settings['access_level'] == FORUM_RESTRICTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"center\" colspan=\"2\">", form_submit("changepermissions", $lang['changepermissions']), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";

    }elseif ($forum_settings['access_level'] == FORUM_PASSWD_PROTECTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";

        if (!forum_get_password($forum_settings['fid'])) {

            echo "                      <tr>\n";
            echo "                        <td align=\"center\" colspan=\"2\">\n";

            html_display_warning_msg($lang['passwordprotectwarning'], '95%', 'center');

            echo "                        </td>\n";
            echo "                      </tr>\n";
        }

        echo "                      <tr>\n";
        echo "                        <td align=\"center\" colspan=\"2\">", form_submit("changepassword", $lang['changepassword']), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">\n";
    echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_33']}</p>\n";
    echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_34']}</p>\n";
    echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_35']}</p>\n";
    echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_36']}</p>\n";
    echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_37']}</p>\n";

    html_display_warning_msg($lang['forum_settings_help_38'], '95%', 'center');

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
}

$closed_message = new TextAreaHTML("prefsform");

$restricted_message = new TextAreaHTML("prefsform");

$password_protected_message = new TextAreaHTML("prefsform");

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if (!isset($forum_settings['closed_message'])) $forum_settings['closed_message'] = '';
if (!isset($forum_settings['restricted_message'])) $forum_settings['restricted_message'] = '';
if (!isset($forum_settings['password_protected_message'])) $forum_settings['password_protected_message'] = '';

$forum_settings_closed_message = new MessageText(POST_HTML_AUTO, $forum_settings['closed_message'], true, true);
$forum_settings_restricted_message = new MessageText(POST_HTML_AUTO, $forum_settings['restricted_message'], true, true);
$forum_settings_password_protected_message = new MessageText(POST_HTML_AUTO, $forum_settings['password_protected_message'], true, true);

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['forumstatusmessages']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['forumclosedmessage']}:</td>\n";
echo "                      </tr>\n";

if ($tool_type <> POST_TOOLBAR_DISABLED) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", $closed_message->toolbar(true), "</td>\n";
    echo "                      </tr>\n";

}else {

    $closed_message->set_tinymce(false);
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", $closed_message->textarea("closed_message", $forum_settings_closed_message->getTidyContent(), 7, 80, false, false, 'admin_tools_textarea'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumrestrictedmessage']}:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $restricted_message->textarea("restricted_message", $forum_settings_restricted_message->getTidyContent(), 7, 80, false, false, 'admin_tools_textarea'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumpasswordprotectedmessage']}:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $password_protected_message->textarea("password_protected_message", $forum_settings_password_protected_message->getTidyContent(), 7, 80, false, false, 'admin_tools_textarea'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_51']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_52']}</p>\n";
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
echo "                        <td align=\"left\" width=\"220\">{$lang['requirepostapproval']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("require_post_approval", "Y", $lang['yes'], (isset($forum_settings['require_post_approval']) && $forum_settings['require_post_approval'] == "Y")), "&nbsp;", form_radio("require_post_approval", "N", $lang['no'], (isset($forum_settings['require_post_approval']) && $forum_settings['require_post_approval'] == "N") || !isset($forum_settings['require_post_approval'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['allowpostoptions']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_post_editing", "Y", $lang['yes'], (isset($forum_settings['allow_post_editing']) && $forum_settings['allow_post_editing'] == "Y")), "&nbsp;", form_radio("allow_post_editing", "N", $lang['no'], (isset($forum_settings['allow_post_editing']) && $forum_settings['allow_post_editing'] == "N") || !isset($forum_settings['allow_post_editing'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['postedittimeout']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("post_edit_time", (isset($forum_settings['post_edit_time']) && is_numeric($forum_settings['post_edit_time']) ? htmlentities_array($forum_settings['post_edit_time']) : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['posteditgraceperiod']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("post_edit_grace_period", (isset($forum_settings['post_edit_grace_period']) && is_numeric($forum_settings['post_edit_grace_period']) ? htmlentities_array($forum_settings['post_edit_grace_period']) : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['maximumpostlength']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("maximum_post_length", (isset($forum_settings['maximum_post_length']) && is_numeric($forum_settings['maximum_post_length']) ? htmlentities_array($forum_settings['maximum_post_length']) : '6226'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['postfrequency']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("minimum_post_frequency", (isset($forum_settings['minimum_post_frequency']) && is_numeric($forum_settings['minimum_post_frequency']) ? htmlentities_array($forum_settings['minimum_post_frequency']) : '0'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_10']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_47']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_11']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_40']}</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['wikiintegration']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['enablewikiintegration']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_wiki_integration", "Y", $lang['yes'], (isset($forum_settings['enable_wiki_integration']) && $forum_settings['enable_wiki_integration'] == "Y")), "&nbsp;", form_radio("enable_wiki_integration", "N", $lang['no'], (isset($forum_settings['enable_wiki_integration']) && $forum_settings['enable_wiki_integration'] == "N") || !isset($forum_settings['enable_wiki_integration'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['enablewikiquicklinks']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_wiki_quick_links", "Y", $lang['yes'], (isset($forum_settings['enable_wiki_quick_links']) && $forum_settings['enable_wiki_quick_links'] == "Y")), "&nbsp;", form_radio("enable_wiki_quick_links", "N", $lang['no'], (isset($forum_settings['enable_wiki_quick_links']) && $forum_settings['enable_wiki_quick_links'] == "N") || !isset($forum_settings['enable_wiki_quick_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['wikiintegrationuri']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("wiki_integration_uri", (isset($forum_settings['wiki_integration_uri']) ? htmlentities_array($forum_settings['wiki_integration_uri']) : 'http://en.wikipedia.org/wiki/[WikiWord]'), 42, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_30']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_31']}</p>\n";
echo "                          <p class=\"smalltext\">", sprintf($lang['forum_settings_help_32'], '[WikiWord]', "<a href=\"http://en.wikipedia.org/wiki/\" target=\"_blank\">Wikipedia.org</a>"), "</p>\n";
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

if (forum_get_global_setting('allow_forum_google_analytics', 'Y')) {

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
    echo "                        <td align=\"left\" width=\"220\">{$lang['enablegoogleanalytics']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("enable_google_analytics", "Y", $lang['yes'], (isset($forum_settings['enable_google_analytics']) && $forum_settings['enable_google_analytics'] == "Y")), "&nbsp;", form_radio("enable_google_analytics", "N", $lang['no'], (isset($forum_settings['enable_google_analytics']) && $forum_settings['enable_google_analytics'] == "N") || !isset($forum_settings['enable_google_analytics'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['googleanalyticsaccountid']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("google_analytics_code", (isset($forum_settings['google_analytics_code']) ? htmlentities_array($forum_settings['google_analytics_code']) : ''), 31, 20), "&nbsp;</td>\n";
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
}

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

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
    echo "                        <td align=\"center\" colspan=\"2\">\n";

    html_display_warning_msg($lang['forum_settings_help_65'], '95%', 'center');

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
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['links']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['enablelinkssection']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("show_links", "Y", $lang['yes'], (isset($forum_settings['show_links']) && $forum_settings['show_links'] == "Y")), "&nbsp;", form_radio("show_links", "N", $lang['no'], (isset($forum_settings['show_links']) && $forum_settings['show_links'] == "N") || !isset($forum_settings['show_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_13']}</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['polls']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['allowcreationofpolls']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_polls", "Y", $lang['yes'], (isset($forum_settings['allow_polls']) && $forum_settings['allow_polls'] == "Y")), "&nbsp;", form_radio("allow_polls", "N", $lang['no'], (isset($forum_settings['allow_polls']) && $forum_settings['allow_polls'] == "N") || !isset($forum_settings['allow_polls'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['allowguestvotesinpolls']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("poll_allow_guests", "Y", $lang['yes'], (isset($forum_settings['poll_allow_guests']) && $forum_settings['poll_allow_guests'] == "Y")), "&nbsp;", form_radio("poll_allow_guests", "N", $lang['no'], (isset($forum_settings['poll_allow_guests']) && $forum_settings['poll_allow_guests'] == "N") || !isset($forum_settings['poll_allow_guests'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_12']}</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['stats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['enablestatsdisplay']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("show_stats", "Y", $lang['yes'], (isset($forum_settings['show_stats']) && $forum_settings['show_stats'] == "Y")), "&nbsp;", form_radio("show_stats", "N", $lang['no'], (isset($forum_settings['show_stats']) && $forum_settings['show_stats'] == "N") || !isset($forum_settings['show_stats'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_17']}</p>\n";
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
echo "                        <td align=\"left\" width=\"300\">{$lang['allowsearchenginespidering']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_search_spidering", "Y", $lang['yes'], (isset($forum_settings['allow_search_spidering']) && $forum_settings['allow_search_spidering'] == "Y")), "&nbsp;", form_radio("allow_search_spidering", "N", $lang['no'], (isset($forum_settings['allow_search_spidering']) && $forum_settings['allow_search_spidering'] == "N") || !isset($forum_settings['allow_search_spidering'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"300\">{$lang['showsearchenginebotsinvisitors']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("searchbots_show_recent", "Y", $lang['yes'], (isset($forum_settings['searchbots_show_recent']) && $forum_settings['searchbots_show_recent'] == 'Y')), "&nbsp;", form_radio("searchbots_show_recent", "N", $lang['no'], (isset($forum_settings['searchbots_show_recent']) && $forum_settings['searchbots_show_recent'] == 'N') || !isset($forum_settings['searchbots_show_recent'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">{$lang['showsearchenginebotsinactiveusers']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("searchbots_show_active", "Y", $lang['yes'], (isset($forum_settings['searchbots_show_active']) && $forum_settings['searchbots_show_active'] == 'Y')), "&nbsp;", form_radio("searchbots_show_active", "N", $lang['no'], (isset($forum_settings['searchbots_show_active']) && $forum_settings['searchbots_show_active'] == 'N') || !isset($forum_settings['searchbots_show_active'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_28']}</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userandguestaccesssettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['allowguestaccess']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_account_enabled", "Y", $lang['yes'], (isset($forum_settings['guest_account_enabled']) && $forum_settings['guest_account_enabled'] == "Y")), "&nbsp;", form_radio("guest_account_enabled", "N", $lang['no'], (isset($forum_settings['guest_account_enabled']) && $forum_settings['guest_account_enabled'] == "N") || !isset($forum_settings['guest_account_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['listguestsinvisitorlog']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_show_recent", "Y", $lang['yes'], (isset($forum_settings['guest_show_recent']) && $forum_settings['guest_show_recent'] == 'Y') || !isset($forum_settings['guest_show_recent'])), "&nbsp;", form_radio("guest_show_recent", "N", $lang['no'], (isset($forum_settings['guest_show_recent']) && $forum_settings['guest_show_recent'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_21']}</p>\n";
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
