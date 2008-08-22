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

/* $Id: admin_forum_settings.php,v 1.145 2008-08-22 19:07:19 decoyduck Exp $ */

/**
* Displays and handles the Forum Settings page
*
* Generates the forms relating to the local forum settings, and handles their sumbission.
* For global options see admin_default_forum_settings.php
*
* @see admin_default_forum_settings.php
*/

/**
*/
// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

// Check to see if the user can access this page.

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Content Ratings

$content_ratings_array = array(FORUM_RATING_GENERAL    => 'General',
                               FORUM_RATING_FOURTEEN   => '14 Years',
                               FORUM_RATING_MATURE     => 'Mature',
                               FORUM_RATING_RESTRICTED => 'Restricted');

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

    if (isset($_POST['forum_name']) && strlen(trim(_stripslashes($_POST['forum_name']))) > 0) {
        $new_forum_settings['forum_name'] = trim(_stripslashes($_POST['forum_name']));
    }else {
        $error_msg_array[] = $lang['mustsupplyforumname'];
        $valid = false;
    }

    if (isset($_POST['forum_email']) && strlen(trim(_stripslashes($_POST['forum_email']))) > 0) {
        $new_forum_settings['forum_email'] = trim(_stripslashes($_POST['forum_email']));
    }else {
        $error_msg_array[] = $lang['mustsupplyforumemail'];
        $valid = false;
    }

    if (isset($_POST['forum_desc']) && strlen(trim(_stripslashes($_POST['forum_desc']))) > 0) {
        $new_forum_settings['forum_desc'] = trim(_stripslashes($_POST['forum_desc']));
    }else {
        $new_forum_settings['forum_desc'] = "";
    }

    if (isset($_POST['forum_content_rating']) && is_numeric($_POST['forum_content_rating'])) {
        $new_forum_settings['forum_content_rating'] = $_POST['forum_content_rating'];
    }else {
        $new_forum_settings['forum_content_rating'] = FORUM_RATING_GENERAL;
    }

    if (isset($_POST['forum_keywords']) && strlen(trim(_stripslashes($_POST['forum_keywords']))) > 0) {
        $new_forum_settings['forum_keywords'] = trim(_stripslashes($_POST['forum_keywords']));
    }else {
        $new_forum_settings['forum_keywords'] = "";
    }

    if (isset($_POST['default_style']) && style_exists(trim(_stripslashes($_POST['default_style'])))) {

        $new_forum_settings['default_style'] = trim(_stripslashes($_POST['default_style']));

    }else {

        $error_msg_array[] = $lang['mustchoosedefaultstyle'];
        $valid = false;
    }

    if (isset($_POST['default_emoticons']) && strlen(trim(_stripslashes($_POST['default_emoticons']))) > 0) {

        $new_forum_settings['default_emoticons'] = trim(_stripslashes($_POST['default_emoticons']));

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

    if (isset($_POST['closed_message']) && strlen(trim(_stripslashes($_POST['closed_message']))) > 0) {
        $new_forum_settings['closed_message'] = trim(_stripslashes($_POST['closed_message']));
    }else {
        $new_forum_settings['closed_message'] = "";
    }

    if (isset($_POST['restricted_message']) && strlen(trim(_stripslashes($_POST['restricted_message']))) > 0) {
        $new_forum_settings['restricted_message'] = trim(_stripslashes($_POST['restricted_message']));
    }else {
        $new_forum_settings['restricted_message'] = "";
    }

    if (isset($_POST['password_protected_message']) && strlen(trim(_stripslashes($_POST['password_protected_message']))) > 0) {
        $new_forum_settings['password_protected_message'] = trim(_stripslashes($_POST['password_protected_message']));
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

    if (isset($_POST['wiki_integration_uri']) && strlen(trim(_stripslashes($_POST['wiki_integration_uri']))) > 0) {
        $new_forum_settings['wiki_integration_uri'] = trim(_stripslashes($_POST['wiki_integration_uri']));
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

html_draw_top("onunload=clearFocus()", "emoticons.js", "htmltools.js");

echo "<h1>{$lang['admin']} &raquo; {$lang['forumsettings']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_forum_settings.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
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
echo "                        <td align=\"left\">", form_input_text("forum_name", (isset($forum_settings['forum_name']) ? _htmlentities($forum_settings['forum_name']) : 'A Beehive Forum'), 42, 255), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumemail']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_email", (isset($forum_settings['forum_email']) ? _htmlentities($forum_settings['forum_email']) : 'admin@abeehiveforum.net'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumdesc']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_desc", (isset($forum_settings['forum_desc']) ? _htmlentities($forum_settings['forum_desc']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumkeywords']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_keywords", (isset($forum_settings['forum_keywords']) ? _htmlentities($forum_settings['forum_keywords']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumcontentrating']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("forum_content_rating", _htmlentities($content_ratings_array), (isset($forum_settings['forum_content_rating']) ? _htmlentities($forum_settings['forum_content_rating']) : 0)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";

if (($available_styles = styles_get_available())) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">{$lang['defaultstyle']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("default_style", _htmlentities($available_styles), (isset($forum_settings['default_style']) && style_exists($forum_settings['default_style']) ? _htmlentities($forum_settings['default_style']) : 'default')), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultemoticons']} [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" onclick=\"return openEmoticons('','$webtag')\">{$lang['preview']}</a>]:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_emoticons", _htmlentities($available_emoticons), (isset($forum_settings['default_emoticons']) && in_array($forum_settings['default_emoticons'], array_keys($available_emoticons)) ? $forum_settings['default_emoticons'] : 'none')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultlanguage']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_language", _htmlentities($available_langs), (isset($forum_settings['default_language']) && in_array($forum_settings['default_language'], $available_langs) ? $forum_settings['default_language'] : 'en')), "</td>\n";
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
echo "                        <td align=\"left\">", form_dropdown_array("forum_timezone", _htmlentities($available_timezones), (isset($forum_settings['forum_timezone']) && is_numeric($forum_settings['forum_timezone']) ? $forum_settings['forum_timezone'] : 27), false, 'timezone_dropdown'), "</td>\n";
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

if (!isset($forum_settings['access_level']) || $forum_settings['access_level'] > -2) {

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
echo $closed_message->preload();

$restricted_message = new TextAreaHTML("prefsform");
echo $restricted_message->preload();

$password_protected_message = new TextAreaHTML("prefsform");
echo $password_protected_message->preload();

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
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $closed_message->toolbar(true), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $closed_message->textarea("closed_message", (isset($forum_settings['closed_message']) ? _htmlentities($forum_settings['closed_message']) : ''), 7, 80, "", "admin_startpage_textarea"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumrestrictedmessage']}:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $restricted_message->textarea("restricted_message", (isset($forum_settings['restricted_message']) ? _htmlentities($forum_settings['restricted_message']) : ''), 7, 80, "", "admin_startpage_textarea"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumpasswordprotectedmessage']}:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $password_protected_message->textarea("password_protected_message", (isset($forum_settings['password_protected_message']) ? _htmlentities($forum_settings['password_protected_message']) : ''), 7, 80, "", "admin_startpage_textarea"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", $closed_message->js(false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_51']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_52']}</p>\n";
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
echo "                        <td align=\"left\">", form_input_text("post_edit_time", (isset($forum_settings['post_edit_time']) && is_numeric($forum_settings['post_edit_time']) ? _htmlentities($forum_settings['post_edit_time']) : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['posteditgraceperiod']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("post_edit_grace_period", (isset($forum_settings['post_edit_grace_period']) && is_numeric($forum_settings['post_edit_grace_period']) ? _htmlentities($forum_settings['post_edit_grace_period']) : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['maximumpostlength']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("maximum_post_length", (isset($forum_settings['maximum_post_length']) && is_numeric($forum_settings['maximum_post_length']) ? _htmlentities($forum_settings['maximum_post_length']) : '6226'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['postfrequency']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("minimum_post_frequency", (isset($forum_settings['minimum_post_frequency']) && is_numeric($forum_settings['minimum_post_frequency']) ? _htmlentities($forum_settings['minimum_post_frequency']) : '0'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_10']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_47']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_11']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_40']}</p>\n";
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
echo "                        <td align=\"left\">", form_input_text("wiki_integration_uri", (isset($forum_settings['wiki_integration_uri']) ? _htmlentities($forum_settings['wiki_integration_uri']) : 'http://en.wikipedia.org/wiki/[WikiWord]'), 42, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_30']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_31']}</p>\n";
echo "                          <p class=\"smalltext\">", sprintf($lang['forum_settings_help_32'], '[WikiWord]', "<a href=\"http://en.wikipedia.org/wiki/\" target=\"_blank\">Wikipedia.org</a>"), "</p>\n";
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
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_13']}</p>\n";
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
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_12']}</p>\n";
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
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_17']}</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['searchenginespidering']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['allowsearchenginespidering']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_search_spidering", "Y", $lang['yes'], (isset($forum_settings['allow_search_spidering']) && $forum_settings['allow_search_spidering'] == "Y")), "&nbsp;", form_radio("allow_search_spidering", "N", $lang['no'], (isset($forum_settings['allow_search_spidering']) && $forum_settings['allow_search_spidering'] == "N") || !isset($forum_settings['allow_search_spidering'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
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
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_21']}</p>\n";
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