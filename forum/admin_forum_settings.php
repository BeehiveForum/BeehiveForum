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

/* $Id: admin_forum_settings.php,v 1.93 2006-11-22 21:38:22 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$error_html = "";

// get list of available languages

$available_langs = lang_get_available();

// Get the available forum styles and emoticons

$available_styles = styles_get_available();
$available_emoticons = emoticons_get_available();

// Timezones

$timezones = array("UTC -12h", "UTC -11h", "UTC -10h", "UTC -9h30m", "UTC -9h", "UTC -8h30m", "UTC -8h",
                   "UTC -7h", "UTC -6h", "UTC -5h", "UTC -4h", "UTC -3h30m", "UTC -3h", "UTC -2h", "UTC -1h",
                   "UTC", "UTC +1h", "UTC +2h", "UTC +3h",  "UTC +3h30m", "UTC +4h", "UTC +4h30m", "UTC +5h",
                   "UTC +5h30m", "UTC +6h", "UTC +6h30m", "UTC +7h", "UTC +8h", "UTC +9h", "UTC +9h30m",
                   "UTC +10h", "UTC +10h30m", "UTC +11h", "UTC +11h30m", "UTC +12h", "UTC +13h", "UTC +14h");

$timezones_data = array(-12, -11, -10, -9.5, -9, -8.5, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, 0, 1, 2, 3, 3.5, 4, 4.5, 5, 5.5,
                        6, 6.5, 7, 8, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13, 14);

if (isset($_POST['changepermissions'])) {

    header_redirect("admin_forum_access.php?webtag=$webtag&fid={$forum_settings['fid']}&ret=admin_forum_settings.php%3Fwebtag%3D$webtag");
    exit;

}elseif (isset($_POST['changepassword'])) {

    header_redirect("admin_forum_set_passwd.php?webtag=$webtag&fid={$forum_settings['fid']}&ret=admin_forum_settings.php%3Fwebtag%3D$webtag");
    exit;

}elseif (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['forum_name']) && strlen(trim(_stripslashes($_POST['forum_name']))) > 0) {
        $new_forum_settings['forum_name'] = trim(_stripslashes($_POST['forum_name']));
    }else {
        $error_html = "<h2>{$lang['mustsupplyforumname']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['forum_email']) && strlen(trim(_stripslashes($_POST['forum_email']))) > 0) {
        $new_forum_settings['forum_email'] = trim(_stripslashes($_POST['forum_email']));
    }else {
        $error_html = "<h2>{$lang['mustsupplyforumemail']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['forum_desc']) && strlen(trim(_stripslashes($_POST['forum_desc']))) > 0) {
        $new_forum_settings['forum_desc'] = trim(_stripslashes($_POST['forum_desc']));
    }else {
        $new_forum_settings['forum_desc'] = "";
    }

    if (isset($_POST['forum_keywords']) && strlen(trim(_stripslashes($_POST['forum_keywords']))) > 0) {
        $new_forum_settings['forum_keywords'] = trim(_stripslashes($_POST['forum_keywords']));
    }else {
        $new_forum_settings['forum_keywords'] = "";
    }

    if (isset($_POST['default_style']) && in_array($_POST['default_style'], array_keys($available_styles))) {

        $new_forum_settings['default_style'] = $_POST['default_style'];

    }else {

        $error_html = "<h2>{$lang['mustchoosedefaultstyle']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['default_emoticons']) && strlen(trim(_stripslashes($_POST['default_emoticons']))) > 0) {

        $new_forum_settings['default_emoticons'] = trim(_stripslashes($_POST['default_emoticons']));

        if (!emoticons_set_exists($new_forum_settings['default_emoticons'])) {
            $error_html = "<h2>{$lang['unknownemoticonsname']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html = "<h2>{$lang['mustchoosedefaultemoticons']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['default_language']) && in_array($_POST['default_language'], array_keys($available_langs))) {

        $new_forum_settings['default_language'] = $_POST['default_language'];

    }else {

        $error_html = "<h2>{$lang['mustchoosedefaultlang']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['forum_timezone']) && is_numeric($_POST['forum_timezone'])) {
        $new_forum_settings['forum_timezone'] = $_POST['forum_timezone'];
    }else {
        $new_forum_settings['forum_timezone'] = 0;
    }

    if (isset($_POST['forum_dl_saving']) && $_POST['forum_dl_saving'] == "Y") {
        $new_forum_settings['forum_dl_saving'] = "Y";
    }else {
        $new_forum_settings['forum_dl_saving'] = "N";
    }

    if (isset($_POST['access_level']) && is_numeric($_POST['access_level'])) {
        forum_update_access($forum_settings['fid'], $_POST['access_level']);
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

        forum_save_settings($new_forum_settings);

        $uid = bh_session_get_value('UID');

        admin_add_log_entry(EDIT_FORUM_SETTINGS, $new_forum_settings['forum_name']);

        header_redirect("./admin_forum_settings.php?webtag=$webtag&updated=true", $lang['forumsettingsupdated']);
    }
}

// Start Output Here

html_draw_top("emoticons.js");

if ($webtag) {
    echo "<h1>{$lang['admin']} &raquo; {$lang['forumsettings']} &raquo; ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), "</h1>\n";
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    html_draw_bottom();
    exit;
}

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['forumsettingsupdated']}</h2>\n";
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"prefsform\" action=\"admin_forum_settings.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "                        <td align=\"left\">", form_input_text("forum_name", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), 42, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumemail']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_email", (isset($forum_settings['forum_email']) ? $forum_settings['forum_email'] : 'admin@abeehiveforum.net'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumdesc']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_desc", (isset($forum_settings['forum_desc']) ? $forum_settings['forum_desc'] : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['forumkeywords']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_keywords", (isset($forum_settings['forum_keywords']) ? $forum_settings['forum_keywords'] : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultstyle']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_style", array_keys($available_styles), array_values($available_styles), (isset($forum_settings['default_style']) && in_array($forum_settings['default_style'], array_keys($available_styles)) ? $forum_settings['default_style'] : 'default')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultemoticons']} [<a href=\"javascript:void(0);\" onclick=\"openEmoticons('','$webtag')\" target=\"_self\">{$lang['preview']}</a>]:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_emoticons", array_keys($available_emoticons), array_values($available_emoticons), (isset($forum_settings['default_emoticons']) && in_array($forum_settings['default_emoticons'], array_keys($available_emoticons)) ? $forum_settings['default_emoticons'] : 'none')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['defaultlanguage']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_language", $available_langs, $available_langs, (isset($forum_settings['default_language']) && in_array($forum_settings['default_language'], $available_langs) ? $forum_settings['default_language'] : 'en')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['timezonefromGMT']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("forum_timezone", $timezones_data, $timezones, (isset($forum_settings['forum_timezone']) && is_numeric($forum_settings['forum_timezone']) ? $forum_settings['forum_timezone'] : 0)), "</td>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
    echo "                        <td align=\"left\">", form_radio("access_level", 0, $lang['open'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == 0 ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", -1, $lang['closed'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == -1 ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", 1, $lang['restricted'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == 1 ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", 2, $lang['passwordprotected'], (isset($forum_settings['access_level']) && $forum_settings['access_level'] == 2 ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";

    if ($forum_settings['access_level'] == 1) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">", form_submit("changepermissions", $lang['changepermissions']), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";

    }elseif ($forum_settings['access_level'] == 2) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">", form_submit("changepassword", $lang['changepassword']), "</td>\n";
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
    echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_38']}</p>\n";
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

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "                        <td align=\"left\">", form_input_text("post_edit_time", (isset($forum_settings['post_edit_time']) && is_numeric($forum_settings['post_edit_time']) ? $forum_settings['post_edit_time'] : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['posteditgraceperiod']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("post_edit_grace_period", (isset($forum_settings['post_edit_grace_period']) && is_numeric($forum_settings['post_edit_grace_period']) ? $forum_settings['post_edit_grace_period'] : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['maximumpostlength']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("maximum_post_length", (isset($forum_settings['maximum_post_length']) && is_numeric($forum_settings['maximum_post_length']) ? $forum_settings['maximum_post_length'] : '6226'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">{$lang['postfrequency']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("minimum_post_frequency", (isset($forum_settings['minimum_post_frequency']) && is_numeric($forum_settings['minimum_post_frequency']) ? $forum_settings['minimum_post_frequency'] : '0'), 20, 32), "&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "                        <td align=\"left\">", form_input_text("wiki_integration_uri", (isset($forum_settings['wiki_integration_uri']) ? $forum_settings['wiki_integration_uri'] : 'http://en.wikipedia.org/wiki/[WikiWord]'), 42, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_30']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_31']}</p>\n";
echo "                          <p class=\"smalltext\">", sprintf($lang['forum_settings_help_32'], "<a href=\"http://en.wikipedia.org/\" target=\"_blank\">Wikipedia.org</a>"), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
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
echo "                        <td align=\"left\" width=\"270\">{$lang['listguestsinvisitorlog']}:</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>