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

/* $Id: forum_options.php,v 1.101 2007-02-19 16:05:07 decoyduck Exp $ */

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

$timezones = array(1  => "(GMT-12:00) International Date Line West",
                   2  => "(GMT-11:00) Midway Island Samoa",
                   3  => "(GMT-10:00) Hawaii",
                   4  => "(GMT-09:00) Alaska",
                   5  => "(GMT-08:00) Pacific Time (US & Canada); Tijuana",
                   6  => "(GMT-07:00) Arizona",
                   7  => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
                   8  => "(GMT-07:00) Mountain Time (US & Canada)",
                   9  => "(GMT-06:00) Central America",
                   10 => "(GMT-06:00) Central Time (US & Canada)",
                   11 => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
                   12 => "(GMT-06:00) Saskatchewan",
                   13 => "(GMT-05:00) Bogota, Lime, Quito",
                   14 => "(GMT-05:00) Eastern Time (US & Canada)",
                   15 => "(GMT-05:00) Indiana (East)",
                   16 => "(GMT-04:00) Atlantic Time (Canada)",
                   17 => "(GMT-04:00) Caracas, La Paz",
                   18 => "(GMT-04:00) Santiago",
                   19 => "(GMT-03:30) Newfoundland",
                   20 => "(GMT-03:00) Brasilia",
                   21 => "(GMT-03:00) Buenos Aires, Georgetown",
                   22 => "(GMT-03:00) Greenland",
                   23 => "(GMT-02:00) Mid-Atlantic",
                   24 => "(GMT-01:00) Azores",
                   25 => "(GMT-01:00) Cape Verde Is.",
                   26 => "(GMT) Casablanca, Monrovia",
                   27 => "(GMT) Dublin, Edinburgh, Lisbon, London",
                   28 => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
                   29 => "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
                   30 => "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
                   31 => "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
                   32 => "(GMT+01:00) West Central Africa",
                   33 => "(GMT+02:00) Athens, Istanbul, Minsk",
                   34 => "(GMT+02:00) Bucharest",
                   35 => "(GMT+02:00) Cairo",
                   36 => "(GMT+02:00) Harare, Pretoria",
                   37 => "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
                   38 => "(GMT+02:00) Jerusalem",
                   39 => "(GMT+03:00) Baghdad",
                   40 => "(GMT+03:00) Kuwait, Riyadh",
                   41 => "(GMT+03:00) Moscow, St. Petersburg, Volgograd",
                   42 => "(GMT+03:00) Nairobi",
                   43 => "(GMT+03:30) Tehran",
                   44 => "(GMT+04:00) Abu Dhabi, Muscat",
                   45 => "(GMT+04:00) Baku, Tbilisi, Yerevan",
                   46 => "(GMT+04:30) Kabul",
                   47 => "(GMT+05:00) Ekaterinburg",
                   48 => "(GMT+05:00) Islamabad, Karachi, Tashkent",
                   49 => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
                   50 => "(GMT+05.75) Kathmandu",
                   51 => "(GMT+06:00) Almaty, Novosibirsk",
                   52 => "(GMT+06:00) Astana, Dhaka",
                   53 => "(GMT+06:00) Sri Jayawardenepura",
                   54 => "(GMT+06:30) Rangoon",
                   55 => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
                   56 => "(GMT+07:00) Krasnoyarsk",
                   57 => "(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi",
                   58 => "(GMT+08:00) Irkutsk, Ulaan Bataar",
                   59 => "(GMT+08:00) Kuala Lumpur, Singapore",
                   60 => "(GMT+08:00) Perth",
                   61 => "(GMT+08:00) Taipei",
                   62 => "(GMT+09:00) Osaka, Sapporo, Tokyo",
                   63 => "(GMT+09:00) Seoul",
                   64 => "(GMT+09:00) Yakutsk",
                   65 => "(GMT+09:30) Adelaide",
                   66 => "(GMT+09:30) Darwin",
                   67 => "(GMT+10:00) Brisbane",
                   68 => "(GMT+10:00) Canberra, Melbourne, Sydney",
                   69 => "(GMT+10:00) Guam, Port Moresby",
                   70 => "(GMT+10:00) Hobart",
                   71 => "(GMT+10:00) Vladivostok",
                   72 => "(GMT+11:00) Magadan, Solomon Is., New Caledonia",
                   73 => "(GMT+12:00) Auckland, Wellington",
                   74 => "(GMT+12:00) Figi, Kamchatka, Marshall Is.",
                   75 => "(GMT+13:00) Nuku'alofa");

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
        $user_prefs['TIMEZONE'] = 27;
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

// Check to see if we should show the set for all forums checkboxes

$show_set_all = (forums_get_available_count() > 1) ? true : false;

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
echo "                        <td align=\"left\">", form_dropdown_array("timezone", array_keys($timezones), array_values($timezones), (isset($user_prefs['TIMEZONE']) && is_numeric($user_prefs['TIMEZONE'])) ? $user_prefs['TIMEZONE'] : forum_get_setting('forum_timezone', false, 27)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($user_prefs['DL_SAVING']) && $user_prefs['DL_SAVING'] == 'Y') ? true : forum_get_setting('forum_dl_saving', 'Y')), "</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['language']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['preferredlang']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($user_prefs['LANGUAGE']) ? $user_prefs['LANGUAGE'] : 0)), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("language_global", "Y", $lang['setforallforums'], (isset($user_prefs['LANGUAGE_GLOBAL']) ? $user_prefs['LANGUAGE_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
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
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['display']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("view_sigs", "N", $lang['globallyignoresigs'], (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "N") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("view_sigs_global", "Y", $lang['setforallforums'], (isset($user_prefs['VIEW_SIGS_GLOBAL']) ? $user_prefs['VIEW_SIGS_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("mark_as_of_int_global", "Y", $lang['setforallforums'], (isset($user_prefs['MARK_AS_OF_INT_GLOBAL']) ? $user_prefs['MARK_AS_OF_INT_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("images_to_links", "Y", $lang['convertimagestolinks'], (isset($user_prefs['IMAGES_TO_LINKS']) && $user_prefs['IMAGES_TO_LINKS'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\"  nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("images_to_links_global", "Y", $lang['setforallforums'], (isset($user_prefs['IMAGES_TO_LINKS_GLOBAL']) ? $user_prefs['IMAGES_TO_LINKS_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("show_thumbs_enabled", "Y", array("{$lang['show']} ", form_dropdown_array("show_thumbs", array(1 => 1, 2 => 2, 3 => 3), array(1 => $lang['smallsized'], 2 => $lang['mediumsized'], 3 => $lang['largesized']), (isset($user_prefs['SHOW_THUMBS']) ? ($user_prefs['SHOW_THUMBS'] > 0 ? $user_prefs['SHOW_THUMBS'] : $user_prefs['SHOW_THUMBS'] * -1) : 2)), " {$lang['thumbnailsforimageattachments']}"), (isset($user_prefs['SHOW_THUMBS']) && $user_prefs['SHOW_THUMBS'] > 0) ? true : false, false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("show_thumbs_global", "Y", $lang['setforallforums'], (isset($user_prefs['SHOW_THUMBS_GLOBAL']) ? $user_prefs['SHOW_THUMBS_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("enable_wiki_words", "Y", $lang['enablewikiintegration'], (isset($user_prefs['ENABLE_WIKI_WORDS']) && $user_prefs['ENABLE_WIKI_WORDS'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("enable_wiki_words_global", "Y", $lang['setforallforums'], (isset($user_prefs['ENABLE_WIKI_WORDS_GLOBAL']) ? $user_prefs['ENABLE_WIKI_WORDS_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_mover_spoiler", "Y", $lang['revealspoileronmouseover'], (isset($user_prefs['USE_MOVER_SPOILER']) && $user_prefs['USE_MOVER_SPOILER'] == "Y")), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_mover_spoiler_global", "Y", $lang['setforallforums'], (isset($user_prefs['USE_MOVER_SPOILER_GLOBAL']) ? $user_prefs['USE_MOVER_SPOILER_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == "Y") ? true : false), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("show_stats_global", "Y", $lang['setforallforums'], (isset($user_prefs['SHOW_STATS_GLOBAL']) ? $user_prefs['SHOW_STATS_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "&nbsp;<span class=\"smalltext\">[<a href=\"edit_wordfilter.php?webtag=$webtag\">{$lang['editwordfilter']}</a>]</span></td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_word_filter_global", "Y", $lang['setforallforums'], (isset($user_prefs['USE_WORD_FILTER_GLOBAL']) ? $user_prefs['USE_WORD_FILTER_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("use_overflow_resize", "Y", $lang['resizeimagesandreflowpage'], (isset($user_prefs['USE_OVERFLOW_RESIZE']) && $user_prefs['USE_OVERFLOW_RESIZE'] == "Y")), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("use_overflow_resize_global", "Y", $lang['setforallforums'], (isset($user_prefs['USE_OVERFLOW_RESIZE_GLOBAL']) ? $user_prefs['USE_OVERFLOW_RESIZE_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['style']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['postsperpage']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("posts_per_page", array(10, 20, 30), array(10, 20, 30), (isset($user_prefs['POSTS_PER_PAGE']) && is_numeric($user_prefs['POSTS_PER_PAGE'])) ? $user_prefs['POSTS_PER_PAGE'] : 10), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("posts_per_page_global", "Y", $lang['setforallforums'], (isset($user_prefs['POSTS_PER_PAGE_GLOBAL']) ? $user_prefs['POSTS_PER_PAGE_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['fontsize']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) ? $user_prefs['FONT_SIZE'] : 10), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("font_size_global", "Y", $lang['setforallforums'], (isset($user_prefs['FONT_SIZE_GLOBAL']) ? $user_prefs['FONT_SIZE_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
echo "                      </tr>\n";

if (sizeof($available_styles) > 1) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['forumstyle']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("style", array_keys($available_styles), array_values($available_styles), (isset($user_prefs['STYLE']) && in_array($user_prefs['STYLE'], array_keys($available_styles))) ? $user_prefs['STYLE'] : forum_get_setting('default_style', false, 'default')), "</td>\n";
    echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("style_global", "Y", $lang['setforallforums'], (isset($user_prefs['STYLE_GLOBAL']) ? $user_prefs['STYLE_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
    echo "                      </tr>\n";
}

if (sizeof($available_emoticons) > 1) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['forumemoticons']} [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" onclick=\"return openEmoticons('', '$webtag')\">{$lang['preview']}</a>]:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("emoticons", array_keys($available_emoticons), array_values($available_emoticons), (isset($user_prefs['EMOTICONS']) && in_array($user_prefs['EMOTICONS'], array_keys($available_emoticons))) ? $user_prefs['EMOTICONS'] : forum_get_setting('default_emoticons', false, 'default')), "</td>\n";
    echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("emoticons_global", "Y", $lang['setforallforums'], (isset($user_prefs['EMOTICONS_GLOBAL']) ? $user_prefs['EMOTICONS_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['startpage']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("start_page", range(0, 3), array($lang['start'], $lang['messages'], $lang['pminbox'], $lang['startwiththreadlist']), (isset($user_prefs['START_PAGE'])) ? $user_prefs['START_PAGE'] : 0), "</td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("start_page_global", "Y", $lang['setforallforums'], (isset($user_prefs['START_PAGE_GLOBAL']) ? $user_prefs['START_PAGE_GLOBAL'] : false)) : '', "&nbsp;</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['postpage']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("toolbar_toggle", "0", $lang['nohtmltoolbar'], $user_prefs['POST_PAGE'] ^ POST_TOOLBAR_DISPLAY && $user_prefs['POST_PAGE'] ^ POST_TINYMCE_DISPLAY), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("toolbar_toggle", "1", $lang['displaysimpletoolbar'], $user_prefs['POST_PAGE'] & POST_TOOLBAR_DISPLAY), "</td>\n";
echo "                      </tr>\n";

if (@file_exists("./tiny_mce/tiny_mce.js")) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_radio("toolbar_toggle", "2", $lang['displaytinymcetoolbar'], $user_prefs['POST_PAGE'] & POST_TINYMCE_DISPLAY), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("emots_toggle", "Y", $lang['displayemoticonspanel'], $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISPLAY), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("sig_toggle", "Y", $lang['displaysignature'], $user_prefs['POST_PAGE'] & POST_SIGNATURE_DISPLAY), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("emots_disable", "Y", $lang['disableemoticonsinpostsbydefault'], $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISABLED), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("check_spelling", "Y", $lang['automaticallycheckspelling'], $user_prefs['POST_PAGE'] & POST_CHECK_SPELLING), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("post_links", "Y", $lang['automaticallyparseurlsbydefault'], $user_prefs['POST_PAGE'] & POST_AUTO_LINKS), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("post_html", "0", $lang['postinplaintextbydefault'], ($user_prefs['POST_PAGE'] & POST_TEXT_DEFAULT) > 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("post_html", "1", $lang['postinhtmlwithautolinebreaksbydefault'], ($user_prefs['POST_PAGE'] & POST_AUTOHTML_DEFAULT) > 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("post_html", "2", $lang['postinhtmlbydefault'], ($user_prefs['POST_PAGE'] & POST_HTML_DEFAULT) > 0), "</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['privatemessageoptions']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("pm_save_sent_items", "Y", $lang['savepminsentitems'], (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("pm_include_reply", "Y", $lang['includepminreply'], (isset($user_prefs['PM_INCLUDE_REPLY']) && $user_prefs['PM_INCLUDE_REPLY'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("pm_auto_prune_enabled", "Y", $lang['autoprunemypmfoldersevery'], (isset($user_prefs['PM_AUTO_PRUNE']) && $user_prefs['PM_AUTO_PRUNE'] > 0) ? true : false), "&nbsp;", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($user_prefs['PM_AUTO_PRUNE']) ? ($user_prefs['PM_AUTO_PRUNE'] > 0 ? $user_prefs['PM_AUTO_PRUNE'] : $user_prefs['PM_AUTO_PRUNE'] * -1) : 60)), " {$lang['days']}</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['privatemessageexportoptions']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">{$lang['pmexportastype']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("pm_export_type", range(0, 2), array($lang['pmexporthtml'], $lang['pmexportxml'], $lang['pmexportplaintext']), (isset($user_prefs['PM_EXPORT_TYPE']) && is_numeric($user_prefs['PM_EXPORT_TYPE'])) ? $user_prefs['PM_EXPORT_TYPE'] : 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">{$lang['pmexportmessagesas']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("pm_export_file", range(0, 1), array($lang['pmexportonefileforallmessages'], $lang['pmexportonefilepermessage']), (isset($user_prefs['PM_EXPORT_FILE']) && is_numeric($user_prefs['PM_EXPORT_FILE'])) ? $user_prefs['PM_EXPORT_FILE'] : 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("pm_export_attachments", "Y", $lang['pmexportattachments'], (isset($user_prefs['PM_EXPORT_ATTACHMENTS']) && $user_prefs['PM_EXPORT_ATTACHMENTS'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("pm_export_style", "Y", $lang['pmexportincludestyle'], (isset($user_prefs['PM_EXPORT_STYLE']) && $user_prefs['PM_EXPORT_STYLE'] == "Y") ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("pm_export_wordfilter", "Y", $lang['pmexportwordfilter'], (isset($user_prefs['PM_EXPORT_WORDFILTER']) && $user_prefs['PM_EXPORT_WORDFILTER'] == "Y") ? true : false), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>