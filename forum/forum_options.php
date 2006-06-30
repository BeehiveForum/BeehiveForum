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

/* $Id: forum_options.php,v 1.89 2006-06-30 18:07:33 decoyduck Exp $ */

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

// Timezones

$timezones = array("UTC -12h", "UTC -11h", "UTC -10h", "UTC -9h30m", "UTC -9h", "UTC -8h30m", "UTC -8h",
                   "UTC -7h", "UTC -6h", "UTC -5h", "UTC -4h", "UTC -3h30m", "UTC -3h", "UTC -2h", "UTC -1h",
                   "UTC", "UTC +1h", "UTC +2h", "UTC +3h",  "UTC +3h30m", "UTC +4h", "UTC +4h30m", "UTC +5h",
                   "UTC +5h30m", "UTC +6h", "UTC +6h30m", "UTC +7h", "UTC +8h", "UTC +9h", "UTC +9h30m",
                   "UTC +10h", "UTC +10h30m", "UTC +11h", "UTC +11h30m", "UTC +12h", "UTC +13h", "UTC +14h");

$timezones_data = array(-12, -11, -10, -9.5, -9, -8.5, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, 0, 1, 2, 3, 3.5, 4, 4.5, 5, 5.5,
                        6, 6.5, 7, 8, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13, 14);

// Languages

$available_langs = lang_get_available(); // get list of available languages

$available_langs_labels = array_merge(array($lang['browsernegotiation']), $available_langs);

array_unshift($available_langs, "");

if (isset($_POST['submit'])) {

    $user_prefs = array();
    $user_prefs_global = array();

    if (isset($_POST['timezone']) && is_numeric($_POST['timezone'])) {
        $user_prefs['TIMEZONE'] = $_POST['timezone'];
    }else {
        $user_prefs['TIMEZONE'] = 0;
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


    if (isset($_POST['pm_notify']) && $_POST['pm_notify'] == "Y") {
        $user_prefs['PM_NOTIFY'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY'] = "N";
    }

    if (isset($_POST['pm_save_sent_items']) && $_POST['pm_save_sent_items'] == "Y") {
        $user_prefs['PM_SAVE_SENT_ITEM'] = "Y";
    }else {
        $user_prefs['PM_SAVE_SENT_ITEM'] = "N";
    }

    if (isset($_POST['pm_include_reply']) && $_POST['pm_include_reply'] == "Y") {
        $user_prefs['PM_INCLUDE_REPLY'] = "Y";
    } else {
        $user_prefs['PM_INCLUDE_REPLY'] = "N";
    }

    if (isset($_POST['pm_auto_prune_enabled']) && $_POST['pm_auto_prune_enabled'] == "Y") {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $user_prefs['PM_AUTO_PRUNE'] = $_POST['pm_auto_prune'];

        }else {

            $user_prefs['PM_AUTO_PRUNE'] = "-60";
        }

    }else {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $user_prefs['PM_AUTO_PRUNE'] = $_POST['pm_auto_prune'] * -1;

        }else {

            $user_prefs['PM_AUTO_PRUNE'] = "-60";
        }
    }

    if (isset($_POST['pm_export_file']) && is_numeric($_POST['pm_export_file'])) {
        $user_prefs['PM_EXPORT_FILE'] = $_POST['pm_export_file'];
    }else {
        $user_prefs['PM_EXPORT_FILE'] = 0;
    }

    if (isset($_POST['pm_export_type']) && is_numeric($_POST['pm_export_type'])) {
        $user_prefs['PM_EXPORT_TYPE'] = $_POST['pm_export_type'];
    }else {
        $user_prefs['PM_EXPORT_TYPE'] = 0;
    }

    if (isset($_POST['pm_export_attachments']) && $_POST['pm_export_attachments'] == "Y") {
        $user_prefs['PM_EXPORT_ATTACHMENTS'] = "Y";
    }else {
        $user_prefs['PM_EXPORT_ATTACHMENTS'] = "N";
    }

    if (isset($_POST['pm_export_style']) && $_POST['pm_export_style'] == "Y") {
        $user_prefs['PM_EXPORT_STYLE'] = "Y";
    }else {
        $user_prefs['PM_EXPORT_STYLE'] = "N";
    }

    if (isset($_POST['pm_export_wordfilter']) && $_POST['pm_export_wordfilter'] == "Y") {
        $user_prefs['PM_EXPORT_WORDFILTER'] = "Y";
    }else {
        $user_prefs['PM_EXPORT_WORDFILTER'] = "N";
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

    if (isset($_POST['style'])) {
        $user_prefs['STYLE'] = trim(_stripslashes($_POST['style']));
    }else {
        $user_prefs['STYLE'] = forum_get_setting('default_style', false, 'default');
    }

    if (isset($_POST['style_global'])) {
        $user_prefs_global['STYLE'] = ($_POST['style_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['STYLE'] = false;
    }

    if (isset($_POST['emoticons'])) {
        $user_prefs['EMOTICONS'] = trim(_stripslashes($_POST['emoticons']));
    }else {
        $user_prefs['EMOTICONS'] = forum_get_setting('default_emoticons', false, 'default');
    }

    if (isset($_POST['emoticons_global'])) {
        $user_prefs_global['EMOTICONS'] = ($_POST['emoticons_global'] == "Y") ? true : false;
    } else {
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

        if ($_POST['toolbar_toggle'] == 1) {

            $user_prefs['POST_PAGE'] |= POST_TOOLBAR_DISPLAY;

        }else if ($_POST['toolbar_toggle'] == 2) {

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

        if ($_POST['post_html'] == 0) {

            $user_prefs['POST_PAGE'] |= POST_TEXT_DEFAULT;

        }else if ($_POST['post_html'] == 1) {

            $user_prefs['POST_PAGE'] |= POST_AUTOHTML_DEFAULT;

        }else {

            $user_prefs['POST_PAGE'] |= POST_HTML_DEFAULT;
        }
    }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

    // Update USER_PREFS

    user_update_prefs($uid, $user_prefs, $user_prefs_global);

    // Reinitialize the User's Session to save them having to logout and back in

    bh_session_init($uid, false);

    header_redirect("./forum_options.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
}

if (!isset($uid)) $uid = bh_session_get_value('UID');

// Get User Prefs

$user_prefs = user_get_prefs($uid);

// Get the available forum styles and emoticons

$available_styles = styles_get_available();
$available_emoticons = emoticons_get_available();

// Set the default POST_PAGE options if none set

if (!isset($user_prefs['POST_PAGE']) || $user_prefs['POST_PAGE'] == 0) {

    $user_prefs['POST_PAGE']  = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY;
    $user_prefs['POST_PAGE'] |= POST_TEXT_DEFAULT | POST_AUTO_LINKS;
    $user_prefs['POST_PAGE'] |= POST_SIGNATURE_DISPLAY;
}

// Start output here

html_draw_top("emoticons.js");

echo "<h1>{$lang['forumoptions']}</h1>\n";

if (!empty($error_html)) {

    echo $error_html;

}else if (isset($_GET['updated'])) {

    echo "<h2>{$lang['preferencesupdated']}</h2>\n";

    $top_html = html_get_top_page();

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "if (top.document.body.rows) {\n\n";

    if (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) {
        echo "    top.document.body.rows='60, ' + ". max($user_prefs['FONT_SIZE']* 2, 22) ."+ ', *';\n";
    }else {
        echo "    top.document.body.rows='60, 22, *';\n";
    }

    echo "    top.frames['ftop'].location.replace('$top_html');\n";
    echo "    top.frames['fnav'].location.reload();\n";
    echo "    top.frames['main'].frames['left'].location.reload();\n\n";
    echo "} else if (top.document.body.cols) {\n\n";
    echo "    top.frames['left'].location.reload();\n\n";
    echo "}\n\n";
    echo "-->\n";
    echo "</script>";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"forum_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['timezone']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['timezonefromGMT']}:</td>\n";
echo "                        <td>", form_dropdown_array("timezone", $timezones_data, $timezones, (isset($user_prefs['TIMEZONE']) && is_numeric($user_prefs['TIMEZONE'])) ? $user_prefs['TIMEZONE'] : forum_get_setting('forum_timezone', false, 0)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                        <td>", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($user_prefs['DL_SAVING']) && $user_prefs['DL_SAVING'] == 'Y') ? true : forum_get_setting('forum_dl_saving', 'Y')), "</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['language']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['preferredlang']}:</td>\n";
echo "                        <td>", form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($user_prefs['LANGUAGE']) ? $user_prefs['LANGUAGE'] : 0)), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("language_global", "Y", $lang['setforallforums'], (isset($user_prefs['LANGUAGE_GLOBAL']) ? $user_prefs['LANGUAGE_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"3\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['display']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("view_sigs", "N", $lang['globallyignoresigs'], (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "N") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("view_sigs_global", "Y", $lang['setforallforums'], (isset($user_prefs['VIEW_SIGS_GLOBAL']) ? $user_prefs['VIEW_SIGS_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("mark_as_of_int_global", "Y", $lang['setforallforums'], (isset($user_prefs['MARK_AS_OF_INT_GLOBAL']) ? $user_prefs['MARK_AS_OF_INT_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("images_to_links", "Y", $lang['convertimagestolinks'], (isset($user_prefs['IMAGES_TO_LINKS']) && $user_prefs['IMAGES_TO_LINKS'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\"  nowrap=\"nowrap\"", form_checkbox("images_to_links_global", "Y", $lang['setforallforums'], (isset($user_prefs['IMAGES_TO_LINKS_GLOBAL']) ? $user_prefs['IMAGES_TO_LINKS_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("show_thumbs_enabled", "Y", array("{$lang['show']} ", form_dropdown_array("show_thumbs", array(1 => 1, 2 => 2, 3 => 3), array(1 => $lang['smallsized'], 2 => $lang['mediumsized'], 3 => $lang['largesized']), (isset($user_prefs['SHOW_THUMBS']) ? ($user_prefs['SHOW_THUMBS'] > 0 ? $user_prefs['SHOW_THUMBS'] : $user_prefs['SHOW_THUMBS'] * -1) : 2)), " {$lang['thumbnailsforimageattachments']}"), (isset($user_prefs['SHOW_THUMBS']) && $user_prefs['SHOW_THUMBS'] > 0) ? true : false, false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("show_thumbs_global", "Y", $lang['setforallforums'], (isset($user_prefs['SHOW_THUMBS_GLOBAL']) ? $user_prefs['SHOW_THUMBS_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("enable_wiki_words", "Y", $lang['enablewikiintegration'], (isset($user_prefs['ENABLE_WIKI_WORDS']) && $user_prefs['ENABLE_WIKI_WORDS'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("enable_wiki_words_global", "Y", $lang['setforallforums'], (isset($user_prefs['ENABLE_WIKI_WORDS_GLOBAL']) ? $user_prefs['ENABLE_WIKI_WORDS_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("show_stats_global", "Y", $lang['setforallforums'], (isset($user_prefs['SHOW_STATS_GLOBAL']) ? $user_prefs['SHOW_STATS_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "&nbsp;<span class=\"smalltext\">[<a href=\"edit_wordfilter.php?webtag=$webtag\">{$lang['editwordfilter']}</a>]</span></td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("use_word_filter_global", "Y", $lang['setforallforums'], (isset($user_prefs['USE_WORD_FILTER_GLOBAL']) ? $user_prefs['USE_WORD_FILTER_GLOBAL'] : false)), "&nbsp;</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['style']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['postsperpage']}:</td>\n";
echo "                        <td>", form_dropdown_array("posts_per_page", array(10, 20, 30), array(10, 20, 30), (isset($user_prefs['POSTS_PER_PAGE']) && is_numeric($user_prefs['POSTS_PER_PAGE'])) ? $user_prefs['POSTS_PER_PAGE'] : 10), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("posts_per_page_global", "Y", $lang['setforallforums'], (isset($user_prefs['POSTS_PER_PAGE_GLOBAL']) ? $user_prefs['POSTS_PER_PAGE_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['fontsize']}:</td>\n";
echo "                        <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) ? $user_prefs['FONT_SIZE'] : 10), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("font_size_global", "Y", $lang['setforallforums'], (isset($user_prefs['FONT_SIZE_GLOBAL']) ? $user_prefs['FONT_SIZE_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['forumstyle']}:</td>\n";
echo "                        <td>", form_dropdown_array("style", array_keys($available_styles), array_values($available_styles), (isset($user_prefs['STYLE']) && in_array($user_prefs['STYLE'], array_keys($available_styles))) ? $user_prefs['STYLE'] : forum_get_setting('default_style', false, 'default')), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("style_global", "Y", $lang['setforallforums'], (isset($user_prefs['STYLE_GLOBAL']) ? $user_prefs['STYLE_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['forumemoticons']} [<a href=\"javascript:void(0);\" onclick=\"openEmoticons('', '$webtag')\" target=\"_self\">{$lang['preview']}</a>]:</td>\n";
echo "                        <td>", form_dropdown_array("emoticons", array_keys($available_emoticons), array_values($available_emoticons), (isset($user_prefs['EMOTICONS']) && in_array($user_prefs['EMOTICONS'], array_keys($available_emoticons))) ? $user_prefs['EMOTICONS'] : forum_get_setting('default_emoticons', false, 'default')), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("emoticons_global", "Y", $lang['setforallforums'], (isset($user_prefs['EMOTICONS_GLOBAL']) ? $user_prefs['EMOTICONS_GLOBAL'] : false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td nowrap=\"nowrap\">{$lang['startpage']}:</td>\n";
echo "                        <td>", form_dropdown_array("start_page", range(0, 3), array($lang['start'], $lang['messages'], $lang['pminbox'], $lang['startwiththreadlist']), (isset($user_prefs['START_PAGE'])) ? $user_prefs['START_PAGE'] : 0), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("start_page_global", "Y", $lang['setforallforums'], (isset($user_prefs['START_PAGE_GLOBAL']) ? $user_prefs['START_PAGE_GLOBAL'] : false)), "&nbsp;</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['postpage']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_radio("toolbar_toggle", "0", $lang['nohtmltoolbar'], $user_prefs['POST_PAGE'] ^ POST_TOOLBAR_DISPLAY && $user_prefs['POST_PAGE'] ^ POST_TINYMCE_DISPLAY), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_radio("toolbar_toggle", "1", $lang['displaysimpletoolbar'], $user_prefs['POST_PAGE'] & POST_TOOLBAR_DISPLAY), "</td>\n";
echo "                      </tr>\n";

if (@file_exists("./tiny_mce/tiny_mce.js")) {
    echo "                      <tr>\n";
    echo "                        <td>", form_radio("toolbar_toggle", "2", $lang['displaytinymcetoolbar'], $user_prefs['POST_PAGE'] & POST_TINYMCE_DISPLAY), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("emots_toggle", "Y", $lang['displayemoticonspanel'], $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISPLAY), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("sig_toggle", "Y", $lang['displaysignature'], $user_prefs['POST_PAGE'] & POST_SIGNATURE_DISPLAY), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("emots_disable", "Y", $lang['disableemoticonsinpostsbydefault'], $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISABLED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("check_spelling", "Y", $lang['automaticallycheckspelling'], $user_prefs['POST_PAGE'] & POST_CHECK_SPELLING), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("post_links", "Y", $lang['automaticallyparseurlsbydefault'], $user_prefs['POST_PAGE'] & POST_AUTO_LINKS), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_radio("post_html", "0", $lang['postinplaintextbydefault'], ($user_prefs['POST_PAGE'] & POST_TEXT_DEFAULT) > 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_radio("post_html", "1", $lang['postinhtmlwithautolinebreaksbydefault'], ($user_prefs['POST_PAGE'] & POST_AUTOHTML_DEFAULT) > 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_radio("post_html", "2", $lang['postinhtmlbydefault'], ($user_prefs['POST_PAGE'] & POST_HTML_DEFAULT) > 0), "</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['privatemessageoptions']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("pm_save_sent_items", "Y", $lang['savepminsentitems'], (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("pm_include_reply", "Y", $lang['includepminreply'], (isset($user_prefs['PM_INCLUDE_REPLY']) && $user_prefs['PM_INCLUDE_REPLY'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("pm_auto_prune_enabled", "Y", $lang['autoprunemypmfoldersevery'], (isset($user_prefs['PM_AUTO_PRUNE']) && $user_prefs['PM_AUTO_PRUNE'] > 0) ? true : false), "&nbsp;", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($user_prefs['PM_AUTO_PRUNE']) ? ($user_prefs['PM_AUTO_PRUNE'] > 0 ? $user_prefs['PM_AUTO_PRUNE'] : $user_prefs['PM_AUTO_PRUNE'] * -1) : 60)), " {$lang['days']}</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['privatemessageexportoptions']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"250\">{$lang['pmexportastype']}:</td>\n";
echo "                        <td>", form_dropdown_array("pm_export_type", range(0, 2), array($lang['pmexporthtml'], $lang['pmexportxml'], $lang['pmexportplaintext']), (isset($user_prefs['PM_EXPORT_TYPE']) && is_numeric($user_prefs['PM_EXPORT_TYPE'])) ? $user_prefs['PM_EXPORT_TYPE'] : 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"250\">{$lang['pmexportmessagesas']}:</td>\n";
echo "                        <td>", form_dropdown_array("pm_export_file", range(0, 1), array($lang['pmexportonefileforallmessages'], $lang['pmexportonefilepermessage']), (isset($user_prefs['PM_EXPORT_FILE']) && is_numeric($user_prefs['PM_EXPORT_FILE'])) ? $user_prefs['PM_EXPORT_FILE'] : 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">", form_checkbox("pm_export_attachments", "Y", $lang['pmexportattachments'], (isset($user_prefs['PM_EXPORT_ATTACHMENTS']) && $user_prefs['PM_EXPORT_ATTACHMENTS'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">", form_checkbox("pm_export_style", "Y", $lang['pmexportincludestyle'], (isset($user_prefs['PM_EXPORT_STYLE']) && $user_prefs['PM_EXPORT_STYLE'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">", form_checkbox("pm_export_wordfilter", "Y", $lang['pmexportwordfilter'], (isset($user_prefs['PM_EXPORT_WORDFILTER']) && $user_prefs['PM_EXPORT_WORDFILTER'] == "Y") ? true : false), "</td>\n";
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
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>