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

/* $Id: forum_options.php,v 1.134 2008-07-09 19:32:51 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Guests can't access this page.

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages.

$error_msg_array = array();

// Get an array of available emoticon sets

$available_emoticons = emoticons_get_available();

// Get an array of available languages

$available_langs = lang_get_available();

// Get an array of available timezones.

$available_timezones = get_available_timezones();

// Submit code starts here.

if (isset($_POST['save'])) {

    $user_prefs = array();
    $user_prefs_global = array();

    if (isset($_POST['timezone']) && in_array($_POST['timezone'], array_keys($available_timezones))) {
        $user_prefs['TIMEZONE'] = $_POST['timezone'];
    }else {
        $user_prefs['TIMEZONE'] = forum_get_setting('forum_timezone', false, 27);
    }

    if (isset($_POST['dl_saving']) && $_POST['dl_saving'] == "Y") {
        $user_prefs['DL_SAVING'] = "Y";
    }else {
        $user_prefs['DL_SAVING'] = "N";
    }

    if (isset($_POST['language'])) {
        $user_prefs['LANGUAGE'] = trim(_stripslashes($_POST['language']));
    }else {
        $user_prefs['LANGUAGE'] = "";
    }

    if (isset($_POST['language_global'])) {
        $user_prefs_global['LANGUAGE'] = ($_POST['language_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['LANGUAGE'] = false;
    }

    if (isset($_POST['view_sigs']) && $_POST['view_sigs'] == "N") {
        $user_prefs['VIEW_SIGS'] = "N";
    }else {
        $user_prefs['VIEW_SIGS'] = "Y";
    }

    if (isset($_POST['view_sigs_global'])) {
        $user_prefs_global['VIEW_SIGS'] = ($_POST['view_sigs_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['VIEW_SIGS'] = false;
    }

    if (isset($_POST['mark_as_of_int']) && $_POST['mark_as_of_int'] == "Y") {
        $user_prefs['MARK_AS_OF_INT'] = "Y";
    }else {
        $user_prefs['MARK_AS_OF_INT'] = "N";
    }

    if (isset($_POST['mark_as_of_int_global'])) {
        $user_prefs_global['MARK_AS_OF_INT'] = ($_POST['mark_as_of_int_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['MARK_AS_OF_INT'] = false;
    }

    if (isset($_POST['images_to_links']) && $_POST['images_to_links'] == "Y") {
        $user_prefs['IMAGES_TO_LINKS'] = "Y";
    }else {
        $user_prefs['IMAGES_TO_LINKS'] = "N";
    }

    if (isset($_POST['images_to_links_global'])) {
        $user_prefs_global['IMAGES_TO_LINKS'] = ($_POST['images_to_links_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['IMAGES_TO_LINKS'] = false;
    }


    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
    }

    if (isset($_POST['use_word_filter_global'])) {
        $user_prefs_global['USE_WORD_FILTER'] = ($_POST['use_word_filter_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }

    // This is a bit hacky. Rather than have 2 columns to
    // remember the state of the tickbox and the drop down
    // independently the SHOW_THUMBS column stores the
    // value of the dropdown as a negative number for
    // disabled and positive number for enabled.

    if (isset($_POST['show_thumbs_enabled']) && $_POST['show_thumbs_enabled'] == "Y") {

        if (isset($_POST['show_thumbs']) && is_numeric($_POST['show_thumbs'])) {

            $user_prefs['SHOW_THUMBS'] = $_POST['show_thumbs'];

        }else {

            $user_prefs['SHOW_THUMBS'] = 2;
        }

    }else {

        if (isset($_POST['show_thumbs']) && is_numeric($_POST['show_thumbs'])) {

            $user_prefs['SHOW_THUMBS'] = $_POST['show_thumbs'] * -1;

        }else {

            $user_prefs['SHOW_THUMBS'] = -2;
        }
    }

    if (isset($_POST['show_thumbs_global'])) {
        $user_prefs_global['SHOW_THUMBS'] = ($_POST['show_thumbs_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['SHOW_THUMBS'] = false;
    }

    if (isset($_POST['use_mover_spoiler']) && $_POST['use_mover_spoiler'] == "Y") {
        $user_prefs['USE_MOVER_SPOILER'] = "Y";
    }else {
        $user_prefs['USE_MOVER_SPOILER'] = "N";
    }

    if (isset($_POST['use_mover_spoiler_global'])) {
        $user_prefs_global['USE_MOVER_SPOILER'] = ($_POST['use_mover_spoiler_global'] == "Y") ? true : false;
    }else {
        $user_prefs_global['USE_MOVER_SPOILER'] = false;
    }

    if (isset($_POST['use_light_mode_spoiler']) && $_POST['use_light_mode_spoiler'] == "Y") {
        $user_prefs['USE_LIGHT_MODE_SPOILER'] = "Y";
    }else {
        $user_prefs['USE_LIGHT_MODE_SPOILER'] = "N";
    }

    if (isset($_POST['use_light_mode_spoiler_global'])) {
        $user_prefs_global['USE_LIGHT_MODE_SPOILER'] = ($_POST['use_light_mode_spoiler_global'] == "Y") ? true : false;
    }else {
        $user_prefs_global['USE_LIGHT_MODE_SPOILER'] = false;
    }

    if (isset($_POST['use_overflow_resize']) && $_POST['use_overflow_resize'] == "Y") {
        $user_prefs['USE_OVERFLOW_RESIZE'] = "Y";
    }else {
        $user_prefs['USE_OVERFLOW_RESIZE'] = "N";
    }

    if (isset($_POST['use_overflow_resize_global'])) {
        $user_prefs_global['USE_OVERFLOW_RESIZE'] = ($_POST['use_overflow_resize_global'] == "Y") ? true : false;
    }else {
        $user_prefs_global['USE_OVERFLOW_RESIZE'] = false;
    }

    if (isset($_POST['reply_quick']) && ($_POST['reply_quick'] == "Y")) {
        $user_prefs['REPLY_QUICK'] = 'Y';
    }else {
        $user_prefs['REPLY_QUICK'] = 'N';
    }

    if (isset($_POST['enable_wiki_words']) && $_POST['enable_wiki_words'] == "Y") {
        $user_prefs['ENABLE_WIKI_WORDS'] = "Y";
    }else {
        $user_prefs['ENABLE_WIKI_WORDS'] = "N";
    }

    if (isset($_POST['enable_wiki_words_global'])) {
        $user_prefs_global['ENABLE_WIKI_WORDS'] = ($_POST['enable_wiki_words_global'] == "Y") ? true : false;
    }else {
        $user_prefs_global['ENABLE_WIKI_WORDS'] = false;
    }

    if (isset($_POST['show_stats']) && $_POST['show_stats'] == "Y") {
        $user_prefs['SHOW_STATS'] = "Y";
    }else {
        $user_prefs['SHOW_STATS'] = "N";
    }

    if (isset($_POST['show_stats_global'])) {
        $user_prefs_global['SHOW_STATS'] = ($_POST['show_stats_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['SHOW_STATS'] = false;
    }

    if (isset($_POST['posts_per_page'])) {
        $user_prefs['POSTS_PER_PAGE'] = trim(_stripslashes($_POST['posts_per_page']));
    }else {
        $user_prefs['POSTS_PER_PAGE'] = 20;
    }

    if (isset($_POST['posts_per_page_global'])) {
        $user_prefs_global['POSTS_PER_PAGE'] = ($_POST['posts_per_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['POSTS_PER_PAGE'] = false;
    }

    if (isset($_POST['font_size'])) {
        $user_prefs['FONT_SIZE'] = trim(_stripslashes($_POST['font_size']));
    }else {
        $user_prefs['FONT_SIZE'] = 10;
    }

    if (isset($_POST['font_size_global'])) {
        $user_prefs_global['FONT_SIZE'] = ($_POST['font_size_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['FONT_SIZE'] = false;
    }

    if (isset($_POST['style']) && style_exists(trim(_stripslashes($_POST['style'])))) {

        $user_prefs['STYLE'] = trim(_stripslashes($_POST['style']));
        $user_prefs_global['STYLE'] = false;

    }else {

        $user_prefs['STYLE'] = forum_get_setting('default_style', false, 'default');
        $user_prefs_global['STYLE'] = false;
    }

    if (isset($_POST['emoticons'])) {
        $user_prefs['EMOTICONS'] = trim(_stripslashes($_POST['emoticons']));
        $user_prefs_global['EMOTICONS'] = false;
    }else {
        $user_prefs['EMOTICONS'] = forum_get_setting('default_emoticons', false, 'default');
        $user_prefs_global['EMOTICONS'] = false;
    }

    if (isset($_POST['start_page'])) {
        $user_prefs['START_PAGE'] = trim(_stripslashes($_POST['start_page']));
    }else {
        $user_prefs['START_PAGE'] = 0;
    }

    if (isset($_POST['start_page_global'])) {
        $user_prefs_global['START_PAGE'] = ($_POST['start_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['START_PAGE'] = false;
    }

    $user_prefs['POST_PAGE'] = 0;

    // toolbar_toggle emots_toggle emots_disable  post_html

    if (isset($_POST['toolbar_toggle'])) {

        if ($_POST['toolbar_toggle'] == POST_TOOLBAR_SIMPLE) {

            $user_prefs['POST_PAGE'] |= POST_TOOLBAR_DISPLAY;

        }else if ($_POST['toolbar_toggle'] == POST_TOOLBAR_TINYMCE) {

            $user_prefs['POST_PAGE'] |= POST_TINYMCE_DISPLAY;
        }
    }

    if (isset($_POST['emots_toggle']) && $_POST['emots_toggle'] == "Y") {
        $user_prefs['POST_PAGE'] |= POST_EMOTICONS_DISPLAY;
    }

    if (isset($_POST['sig_toggle']) && $_POST['sig_toggle'] == "Y") {
        $user_prefs['POST_PAGE'] |= POST_SIGNATURE_DISPLAY;
    }

    if (isset($_POST['emots_disable']) && $_POST['emots_disable'] == "Y") {
        $user_prefs['POST_PAGE'] |= POST_EMOTICONS_DISABLED;
    }

    if (isset($_POST['check_spelling']) && $_POST['check_spelling'] == "Y") {
        $user_prefs['POST_PAGE'] |= POST_CHECK_SPELLING;
    }

    if (isset($_POST['post_links']) && $_POST['post_links'] == "Y") {
        $user_prefs['POST_PAGE'] |= POST_AUTO_LINKS;
    }

    if (isset($_POST['post_html'])) {

        if ($_POST['post_html'] == POST_HTML_DISABLED) {

            $user_prefs['POST_PAGE'] |= POST_TEXT_DEFAULT;

        }else if ($_POST['post_html'] == POST_HTML_AUTO) {

            $user_prefs['POST_PAGE'] |= POST_AUTOHTML_DEFAULT;

        }else {

            $user_prefs['POST_PAGE'] |= POST_HTML_DEFAULT;
        }
    }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

    // Update USER_PREFS

    if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        header_redirect("forum_options.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }
}

if (!isset($uid)) $uid = bh_session_get_value('UID');

// Get User Prefs

$user_prefs = user_get_prefs($uid);

// Set the default POST_PAGE options if none set

if (!isset($user_prefs['POST_PAGE']) || $user_prefs['POST_PAGE'] == 0) {

    $user_prefs['POST_PAGE']  = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY;
    $user_prefs['POST_PAGE'] |= POST_TEXT_DEFAULT | POST_AUTO_LINKS;
    $user_prefs['POST_PAGE'] |= POST_SIGNATURE_DISPLAY;
}

// Check to see if we should show the set for all forums checkboxes

$show_set_all = (forums_get_available_count() > 1) ? true : false;

// Start output here

html_draw_top("emoticons.js");

echo "<h1>{$lang['forumoptions']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'left');

    $top_html = html_get_top_page();

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "if (top.document.body.rows) {\n\n";

    if (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) {
        echo "    top.document.body.rows='60, ' + ". max($user_prefs['FONT_SIZE']* 2, 22) ."+ ', *';\n";
    }else {
        echo "    top.document.body.rows='60, 22, *';\n";
    }

    echo "    top.frames['", html_get_frame_name('ftop'), "'].location.replace('$top_html');\n";
    echo "    top.frames['", html_get_frame_name('fnav'), "'].location.reload();\n";
    echo "    top.frames['", html_get_frame_name('main'), "'].frames['", html_get_frame_name('left'), "'].location.reload();\n\n";
    echo "} else if (top.document.body.cols) {\n\n";
    echo "    top.frames['", html_get_frame_name('left'), "'].location.reload();\n\n";
    echo "}\n\n";
    echo "-->\n";
    echo "</script>";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"forum_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">{$lang['timezone']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"3\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['timezonefromGMT']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("timezone", _htmlentities($available_timezones), (isset($user_prefs['TIMEZONE']) && in_array($user_prefs['TIMEZONE'], array_keys($available_timezones))) ? $user_prefs['TIMEZONE'] : forum_get_setting('forum_timezone', false, 27), false, 'timezone_dropdown'), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($user_prefs['DL_SAVING'])) ? ($user_prefs['DL_SAVING'] == 'Y') : forum_get_setting('forum_dl_saving', 'Y')), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['language']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['language']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['preferredlang']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("language", _htmlentities($available_langs), (isset($user_prefs['LANGUAGE']) ? $user_prefs['LANGUAGE'] : 0)), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("language_global", "Y", '', (isset($user_prefs['LANGUAGE_GLOBAL']) ? $user_prefs['LANGUAGE_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("language_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['display']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['display']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"12\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("view_sigs", "N", $lang['globallyignoresigs'], (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "N") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("view_sigs_global", "Y", '', (isset($user_prefs['VIEW_SIGS_GLOBAL']) ? $user_prefs['VIEW_SIGS_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("view_sigs_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("mark_as_of_int_global", "Y", '', (isset($user_prefs['MARK_AS_OF_INT_GLOBAL']) ? $user_prefs['MARK_AS_OF_INT_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("mark_as_of_int_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("images_to_links", "Y", $lang['convertimagestolinks'], (isset($user_prefs['IMAGES_TO_LINKS']) && $user_prefs['IMAGES_TO_LINKS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\"  nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("images_to_links_global", "Y", '', (isset($user_prefs['IMAGES_TO_LINKS_GLOBAL']) ? $user_prefs['IMAGES_TO_LINKS_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("images_to_links_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("show_thumbs_enabled", "Y", array("{$lang['show']} ", form_dropdown_array("show_thumbs", array(ATTACHMENT_THUMB_SMALL => $lang['smallsized'], ATTACHMENT_THUMB_MEDIUM => $lang['mediumsized'], ATTACHMENT_THUMB_LARGE => $lang['largesized']), (isset($user_prefs['SHOW_THUMBS']) ? ($user_prefs['SHOW_THUMBS'] > 0 ? $user_prefs['SHOW_THUMBS'] : $user_prefs['SHOW_THUMBS'] * -1) : 2)), " {$lang['thumbnailsforimageattachments']}"), (isset($user_prefs['SHOW_THUMBS']) && $user_prefs['SHOW_THUMBS'] > 0) ? true : false, false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("show_thumbs_global", "Y", '', (isset($user_prefs['SHOW_THUMBS_GLOBAL']) ? $user_prefs['SHOW_THUMBS_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("show_thumbs_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("enable_wiki_words", "Y", $lang['enablewikiintegration'], (isset($user_prefs['ENABLE_WIKI_WORDS']) && $user_prefs['ENABLE_WIKI_WORDS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("enable_wiki_words_global", "Y", '', (isset($user_prefs['ENABLE_WIKI_WORDS_GLOBAL']) ? $user_prefs['ENABLE_WIKI_WORDS_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("enable_wiki_words_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_mover_spoiler", "Y", $lang['revealspoileronmouseover'], (isset($user_prefs['USE_MOVER_SPOILER']) && $user_prefs['USE_MOVER_SPOILER'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_mover_spoiler_global", "Y", '', (isset($user_prefs['USE_MOVER_SPOILER_GLOBAL']) ? $user_prefs['USE_MOVER_SPOILER_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("use_mover_spoiler_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_light_mode_spoiler", "Y", $lang['showspoilersinlightmode'], (isset($user_prefs['USE_LIGHT_MODE_SPOILER']) && $user_prefs['USE_LIGHT_MODE_SPOILER'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_light_mode_spoiler_global", "Y", '', (isset($user_prefs['USE_LIGHT_MODE_SPOILER_GLOBAL']) ? $user_prefs['USE_LIGHT_MODE_SPOILER_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("use_light_mode_spoiler_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("show_stats_global", "Y", '', (isset($user_prefs['SHOW_STATS_GLOBAL']) ? $user_prefs['SHOW_STATS_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("show_stats_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "&nbsp;<span class=\"smalltext\">[<a href=\"edit_wordfilter.php?webtag=$webtag\">{$lang['editwordfilter']}</a>]</span></td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_word_filter_global", "Y", '', (isset($user_prefs['USE_WORD_FILTER_GLOBAL']) ? $user_prefs['USE_WORD_FILTER_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("use_word_filter_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_overflow_resize", "Y", $lang['resizeimagesandreflowpage'], (isset($user_prefs['USE_OVERFLOW_RESIZE']) && $user_prefs['USE_OVERFLOW_RESIZE'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_overflow_resize_global", "Y", '', (isset($user_prefs['USE_OVERFLOW_RESIZE_GLOBAL']) ? $user_prefs['USE_OVERFLOW_RESIZE_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("use_overflow_resize_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("reply_quick", "Y", $lang['postdefaultquick'], (isset($user_prefs['REPLY_QUICK']) && $user_prefs['REPLY_QUICK'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("reply_quick_global", "Y", '', (isset($user_prefs['REPLY_QUICK_GLOBAL']) ? $user_prefs['REPLY_QUICK_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("reply_quick_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['style']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['style']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['postsperpage']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("posts_per_page", array(10 => 10, 20 => 20, 30 => 30), (isset($user_prefs['POSTS_PER_PAGE']) && is_numeric($user_prefs['POSTS_PER_PAGE'])) ? $user_prefs['POSTS_PER_PAGE'] : 10), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("posts_per_page_global", "Y", '', (isset($user_prefs['POSTS_PER_PAGE_GLOBAL']) ? $user_prefs['POSTS_PER_PAGE_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("posts_per_page_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['fontsize']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("font_size", array(5 => '5pt', 6 => '6pt', 7 => '7pt', 8 => '8pt', 9 => '9pt', 10 => '10pt', 11 => '11pt', 12 => '12pt', 13 => '13pt', 14 => '14pt', 15 => '15pt'), (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) ? $user_prefs['FONT_SIZE'] : 10), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("font_size_global", "Y", '', (isset($user_prefs['FONT_SIZE_GLOBAL']) ? $user_prefs['FONT_SIZE_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("font_size_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";

if ($available_styles = styles_get_available()) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['forumstyle']}:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("style", _htmlentities($available_styles), (isset($user_prefs['STYLE']) && style_exists($user_prefs['STYLE'])) ? _htmlentities($user_prefs['STYLE']) : _htmlentities(forum_get_setting('default_style', false, 'default'))), "</td>\n";
    echo "                </tr>\n";
}

if (sizeof($available_emoticons) > 1) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['forumemoticons']} [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" onclick=\"return openEmoticons('', '$webtag')\">{$lang['preview']}</a>]:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("emoticons", _htmlentities($available_emoticons), (isset($user_prefs['EMOTICONS']) && in_array($user_prefs['EMOTICONS'], array_keys($available_emoticons))) ? _htmlentities($user_prefs['EMOTICONS']) : _htmlentities(forum_get_setting('default_emoticons', false, 'default'))), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['startpage']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("start_page", array(START_PAGE_NORMAL => $lang['start'], START_PAGE_MESSAGES => $lang['messages'], START_PAGE_INBOX => $lang['pminbox'], START_PAGE_THREAD_LIST => $lang['startwiththreadlist']), (isset($user_prefs['START_PAGE'])) ? $user_prefs['START_PAGE'] : 0), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("start_page_global", "Y", '', (isset($user_prefs['START_PAGE_GLOBAL']) ? $user_prefs['START_PAGE_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("start_page_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['postpage']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"15\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_radio("toolbar_toggle", "0", $lang['nohtmltoolbar'], $user_prefs['POST_PAGE'] ^ POST_TOOLBAR_DISPLAY && $user_prefs['POST_PAGE'] ^ POST_TINYMCE_DISPLAY), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_radio("toolbar_toggle", "1", $lang['displaysimpletoolbar'], $user_prefs['POST_PAGE'] & POST_TOOLBAR_DISPLAY), "</td>\n";
echo "                </tr>\n";

if (@file_exists("tiny_mce/tiny_mce.js")) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_radio("toolbar_toggle", "2", $lang['displaytinymcetoolbar'], $user_prefs['POST_PAGE'] & POST_TINYMCE_DISPLAY), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("emots_toggle", "Y", $lang['displayemoticonspanel'], $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISPLAY), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("sig_toggle", "Y", $lang['displaysignature'], $user_prefs['POST_PAGE'] & POST_SIGNATURE_DISPLAY), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("emots_disable", "Y", $lang['disableemoticonsinpostsbydefault'], $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISABLED), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("check_spelling", "Y", $lang['automaticallycheckspelling'], $user_prefs['POST_PAGE'] & POST_CHECK_SPELLING), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("post_links", "Y", $lang['automaticallyparseurlsbydefault'], $user_prefs['POST_PAGE'] & POST_AUTO_LINKS), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_radio("post_html", "0", $lang['postinplaintextbydefault'], ($user_prefs['POST_PAGE'] & POST_TEXT_DEFAULT) > 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_radio("post_html", "1", $lang['postinhtmlwithautolinebreaksbydefault'], ($user_prefs['POST_PAGE'] & POST_AUTOHTML_DEFAULT) > 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_radio("post_html", "2", $lang['postinhtmlbydefault'], ($user_prefs['POST_PAGE'] & POST_HTML_DEFAULT) > 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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

html_draw_bottom();

?>