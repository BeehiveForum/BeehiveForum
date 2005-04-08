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

/* $Id: admin_forum_settings.php,v 1.69 2005-04-08 17:38:36 decoyduck Exp $ */

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
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!perm_has_admin_access()) {
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

// Get the forum settings just for this forum

$current_forum_settings = forum_get_settings(true);

if (isset($_POST['changepermissions'])) {

    header_redirect("admin_forum_access.php?webtag=$webtag&fid={$current_forum_settings['fid']}");
    exit;

}elseif (isset($_POST['changepassword'])) {

    header_redirect("admin_forum_set_passwd.php?webtag=$webtag&fid={$current_forum_settings['fid']}");
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

    if (isset($_POST['default_style']) && strlen(trim(_stripslashes($_POST['default_style']))) > 0) {

        $new_forum_settings['default_style'] = trim(_stripslashes($_POST['default_style']));

        if (!style_exists($new_forum_settings['default_style'])) {

            $error_html = "<h2>{$lang['unknownstylename']}</h2>\n";
            $valid = false;
        }

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

    if (isset($_POST['default_language']) && strlen(trim(_stripslashes($_POST['default_language']))) > 0) {

        $new_forum_settings['default_language'] = trim(_stripslashes($_POST['default_language']));

        if (!_in_array($new_forum_settings['default_language'], $available_langs)) {

            $error_html = "<h2>{$lang['unknownlanguage']}</h2>\n";
            $valid = false;
        }

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
        forum_update_access($current_forum_settings['fid'], $_POST['access_level']);
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

    if (isset($_POST['auto_logon']) && $_POST['auto_logon'] == "Y") {
        $new_forum_settings['auto_logon'] = "Y";
    }else {
        $new_forum_settings['auto_logon'] = "N";
    }

    if ($valid) {

        forum_save_settings($new_forum_settings);

        $uid = bh_session_get_value('UID');

        admin_add_log_entry(EDIT_FORUM_SETTINGS, $new_forum_settings['forum_name']);

        if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
            header_redirect("./admin_forum_settings.php?webtag=$webtag&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './admin_forum_settings.php?webtag=$webtag&amp;updated=true';\n";
            echo "//-->\n";
            echo "</script>";
            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['forumsettingsupdated']}</p>";
            echo form_quick_button("./admin_forum_settings.php", $lang['continue'], false, false, "_top");

            html_draw_bottom();
            exit;
        }
    }
}

// Start Output Here

html_draw_top("emoticons.js");

if ($webtag) {
    echo "<h1>{$lang['admin']} : {$lang['forumsettings']} : ", (isset($current_forum_settings['forum_name']) ? $current_forum_settings['forum_name'] : 'A Beehive Forum'), "</h1>\n";
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
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['mainsettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['forumname']}:</td>\n";
echo "                        <td>", form_input_text("forum_name", (isset($current_forum_settings['forum_name']) ? $current_forum_settings['forum_name'] : 'A Beehive Forum'), 42, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['forumemail']}:</td>\n";
echo "                        <td>", form_input_text("forum_email", (isset($current_forum_settings['forum_email']) ? $current_forum_settings['forum_email'] : 'admin@abeehiveforum.net'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['forumdesc']}:</td>\n";
echo "                        <td>", form_input_text("forum_desc", (isset($current_forum_settings['forum_desc']) ? $current_forum_settings['forum_desc'] : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['forumkeywords']}:</td>\n";
echo "                        <td>", form_input_text("forum_keywords", (isset($current_forum_settings['forum_keywords']) ? $current_forum_settings['forum_keywords'] : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['defaultstyle']}:</td>\n";
echo "                        <td>", form_dropdown_array("default_style", array_keys($available_styles), array_values($available_styles), (isset($current_forum_settings['default_style']) && in_array($current_forum_settings['default_style'], array_keys($available_styles)) ? $current_forum_settings['default_style'] : 'default')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['defaultemoticons']} [<a href=\"javascript:void(0);\" onclick=\"openEmoticons('','$webtag')\" target=\"_self\">{$lang['preview']}</a>]:</td>\n";
echo "                        <td>", form_dropdown_array("default_emoticons", array_keys($available_emoticons), array_values($available_emoticons), (isset($current_forum_settings['default_emoticons']) && in_array($current_forum_settings['default_emoticons'], array_keys($available_emoticons)) ? $current_forum_settings['default_emoticons'] : 'none')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['defaultlanguage']}:</td>\n";
echo "                        <td>", form_dropdown_array("default_language", $available_langs, $available_langs, (isset($current_forum_settings['default_language']) && in_array($current_forum_settings['default_language'], $available_langs) ? $current_forum_settings['default_language'] : 'en')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>{$lang['timezonefromGMT']}:</td>\n";
echo "                        <td>", form_dropdown_array("forum_timezone", $timezones_data, $timezones, (isset($current_forum_settings['forum_timezone']) && is_numeric($current_forum_settings['forum_timezone']) ? $current_forum_settings['forum_timezone'] : 0)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                        <td>", form_checkbox("forum_dl_saving", "Y", $lang['daylightsaving'], (isset($current_forum_settings['forum_dl_saving']) && $current_forum_settings['forum_dl_saving'] == 'Y') ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['forumaccesssettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['forumaccessstatus']}:</td>\n";
echo "                        <td>", form_radio("access_level", 0, $lang['open'], (isset($current_forum_settings['access_level']) && $current_forum_settings['access_level'] == 0 ? true : false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">&nbsp;</td>\n";
echo "                        <td>", form_radio("access_level", -1, $lang['closed'], (isset($current_forum_settings['access_level']) && $current_forum_settings['access_level'] == -1 ? true : false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">&nbsp;</td>\n";
echo "                        <td>", form_radio("access_level", 1, $lang['restricted'], (isset($current_forum_settings['access_level']) && $current_forum_settings['access_level'] == 1 ? true : false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">&nbsp;</td>\n";
echo "                        <td>", form_radio("access_level", 2, $lang['passwordprotected'], (isset($current_forum_settings['access_level']) && $current_forum_settings['access_level'] == 2 ? true : false)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                      </tr>\n";

if ($current_forum_settings['access_level'] == 1) {

    echo "                      <tr>\n";
    echo "                        <td width=\"220\">&nbsp;</td>\n";
    echo "                        <td>", form_submit("changepermissions", $lang['changepermissions']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>&nbsp;</td>\n";
    echo "                        <td>&nbsp;</td>\n";
    echo "                      </tr>\n";

}elseif ($current_forum_settings['access_level'] == 2) {

    echo "                      <tr>\n";
    echo "                        <td width=\"220\">&nbsp;</td>\n";
    echo "                        <td>", form_submit("changepassword", $lang['changepassword']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td>&nbsp;</td>\n";
    echo "                        <td>&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['postoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['requirepostapproval']}:</td>\n";
echo "                        <td>", form_radio("require_post_approval", "Y", $lang['yes'], (isset($current_forum_settings['require_post_approval']) && $current_forum_settings['require_post_approval'] == "Y")), "&nbsp;", form_radio("require_post_approval", "N", $lang['no'], (isset($current_forum_settings['require_post_approval']) && $current_forum_settings['require_post_approval'] == "N") || !isset($current_forum_settings['require_post_approval'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['allowpostoptions']}:</td>\n";
echo "                        <td>", form_radio("allow_post_editing", "Y", $lang['yes'], (isset($current_forum_settings['allow_post_editing']) && $current_forum_settings['allow_post_editing'] == "Y")), "&nbsp;", form_radio("allow_post_editing", "N", $lang['no'], (isset($current_forum_settings['allow_post_editing']) && $current_forum_settings['allow_post_editing'] == "N") || !isset($current_forum_settings['allow_post_editing'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['postedittimeout']}:</td>\n";
echo "                        <td>", form_input_text("post_edit_time", (isset($current_forum_settings['post_edit_time']) && is_numeric($current_forum_settings['post_edit_time']) ? $current_forum_settings['post_edit_time'] : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['maximumpostlength']}:</td>\n";
echo "                        <td>", form_input_text("maximum_post_length", (isset($current_forum_settings['maximum_post_length']) && is_numeric($current_forum_settings['maximum_post_length']) ? $current_forum_settings['maximum_post_length'] : '6226'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['minimumpostfrequency']}:</td>\n";
echo "                        <td>", form_input_text("minimum_post_frequency", (isset($current_forum_settings['minimum_post_frequency']) && is_numeric($current_forum_settings['minimum_post_frequency']) ? $current_forum_settings['minimum_post_frequency'] : '0'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_10']}</p>\n";
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
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['wikiintegration']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['enablewikiintegration']}:</td>\n";
echo "                        <td>", form_radio("enable_wiki_integration", "Y", $lang['yes'], (isset($current_forum_settings['enable_wiki_integration']) && $current_forum_settings['enable_wiki_integration'] == "Y")), "&nbsp;", form_radio("enable_wiki_integration", "N", $lang['no'], (isset($current_forum_settings['enable_wiki_integration']) && $current_forum_settings['enable_wiki_integration'] == "N") || !isset($current_forum_settings['enable_wiki_integration'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['enablewikiquicklinks']}:</td>\n";
echo "                        <td>", form_radio("enable_wiki_quick_links", "Y", $lang['yes'], (isset($current_forum_settings['enable_wiki_quick_links']) && $current_forum_settings['enable_wiki_quick_links'] == "Y")), "&nbsp;", form_radio("enable_wiki_quick_links", "N", $lang['no'], (isset($current_forum_settings['enable_wiki_quick_links']) && $current_forum_settings['enable_wiki_quick_links'] == "N") || !isset($current_forum_settings['enable_wiki_quick_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['wikiintegrationuri']}:</td>\n";
echo "                        <td>", form_input_text("wiki_integration_uri", (isset($current_forum_settings['wiki_integration_uri']) ? $current_forum_settings['wiki_integration_uri'] : 'http://en.wikipedia.org/wiki/[WikiWord]'), 42, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_30']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_31']}</p>\n";
echo "                          <p class=\"smalltext\">{$lang['forum_settings_help_32']}</p>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['links']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['enablelinkssection']}:</td>\n";
echo "                        <td>", form_radio("show_links", "Y", $lang['yes'], (isset($current_forum_settings['show_links']) && $current_forum_settings['show_links'] == "Y")), "&nbsp;", form_radio("show_links", "N", $lang['no'], (isset($current_forum_settings['show_links']) && $current_forum_settings['show_links'] == "N") || !isset($current_forum_settings['show_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
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
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['polls']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['allowcreationofpolls']}:</td>\n";
echo "                        <td>", form_radio("allow_polls", "Y", $lang['yes'], (isset($current_forum_settings['allow_polls']) && $current_forum_settings['allow_polls'] == "Y")), "&nbsp;", form_radio("allow_polls", "N", $lang['no'], (isset($current_forum_settings['allow_polls']) && $current_forum_settings['allow_polls'] == "N") || !isset($current_forum_settings['allow_polls'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
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
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['stats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['enablestatsdisplay']}:</td>\n";
echo "                        <td>", form_radio("show_stats", "Y", $lang['yes'], (isset($current_forum_settings['show_stats']) && $current_forum_settings['show_stats'] == "Y")), "&nbsp;", form_radio("show_stats", "N", $lang['no'], (isset($current_forum_settings['show_stats']) && $current_forum_settings['show_stats'] == "N") || !isset($current_forum_settings['show_stats'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
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
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['searchenginespidering']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['allowsearchenginespidering']}:</td>\n";
echo "                        <td>", form_radio("allow_search_spidering", "Y", $lang['yes'], (isset($current_forum_settings['allow_search_spidering']) && $current_forum_settings['allow_search_spidering'] == "Y")), "&nbsp;", form_radio("allow_search_spidering", "N", $lang['no'], (isset($current_forum_settings['allow_search_spidering']) && $current_forum_settings['allow_search_spidering'] == "N") || !isset($current_forum_settings['allow_search_spidering'])), "</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['guestaccess']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"220\">{$lang['allowguestaccess']}:</td>\n";
echo "                        <td>", form_radio("guest_account_enabled", "Y", $lang['yes'], (isset($current_forum_settings['guest_account_enabled']) && $current_forum_settings['guest_account_enabled'] == "Y")), "&nbsp;", form_radio("guest_account_enabled", "N", $lang['no'], (isset($current_forum_settings['guest_account_enabled']) && $current_forum_settings['guest_account_enabled'] == "N") || !isset($current_forum_settings['guest_account_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
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