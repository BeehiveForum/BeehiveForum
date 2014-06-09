<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'lang.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'styles.inc.php';
require_once BH_INCLUDE_PATH . 'timezone.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages.
$error_msg_array = array();

// Get an array of available emoticon sets
$available_emoticons = emoticons_get_available();

// Get an array of available languages
$available_langs = lang_get_available();

// Get an array of available timezones.
$available_timezones = get_available_timezones();

// Get User Prefs
$user_prefs = user_get_prefs($_SESSION['UID']);

// Submit code starts here.
if (isset($_POST['save'])) {

    $user_prefs_global = array();

    if (isset($_POST['timezone']) && in_array($_POST['timezone'], array_keys($available_timezones))) {
        $user_prefs['TIMEZONE'] = $_POST['timezone'];
    } else {
        $user_prefs['TIMEZONE'] = forum_get_setting('forum_timezone', 'is_numeric', 27);
    }

    if (isset($_POST['dl_saving']) && $_POST['dl_saving'] == "Y") {
        $user_prefs['DL_SAVING'] = "Y";
    } else {
        $user_prefs['DL_SAVING'] = "N";
    }

    if (isset($_POST['language'])) {
        $user_prefs['LANGUAGE'] = trim($_POST['language']);
    } else {
        $user_prefs['LANGUAGE'] = "";
    }

    if (isset($_POST['view_sigs']) && $_POST['view_sigs'] == "N") {
        $user_prefs['VIEW_SIGS'] = "N";
    } else {
        $user_prefs['VIEW_SIGS'] = "Y";
    }

    if (isset($_POST['view_sigs_global'])) {
        $user_prefs_global['VIEW_SIGS'] = ($_POST['view_sigs_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['VIEW_SIGS'] = false;
    }

    if (isset($_POST['threads_by_folder']) && $_POST['threads_by_folder'] == "Y") {
        $user_prefs['THREADS_BY_FOLDER'] = "Y";
    } else {
        $user_prefs['THREADS_BY_FOLDER'] = "N";
    }

    if (isset($_POST['threads_by_folder_global'])) {
        $user_prefs_global['THREADS_BY_FOLDER'] = ($_POST['threads_by_folder_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['THREADS_BY_FOLDER'] = false;
    }

    if (isset($_POST['mark_as_of_int']) && $_POST['mark_as_of_int'] == "Y") {
        $user_prefs['MARK_AS_OF_INT'] = "Y";
    } else {
        $user_prefs['MARK_AS_OF_INT'] = "N";
    }

    if (isset($_POST['mark_as_of_int_global'])) {
        $user_prefs_global['MARK_AS_OF_INT'] = ($_POST['mark_as_of_int_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['MARK_AS_OF_INT'] = false;
    }

    if (isset($_POST['images_to_links']) && $_POST['images_to_links'] == "Y") {
        $user_prefs['IMAGES_TO_LINKS'] = "Y";
    } else {
        $user_prefs['IMAGES_TO_LINKS'] = "N";
    }

    if (isset($_POST['images_to_links_global'])) {
        $user_prefs_global['IMAGES_TO_LINKS'] = ($_POST['images_to_links_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['IMAGES_TO_LINKS'] = false;
    }

    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
    } else {
        $user_prefs['USE_WORD_FILTER'] = "N";
    }

    if (isset($_POST['use_word_filter_global'])) {
        $user_prefs_global['USE_WORD_FILTER'] = ($_POST['use_word_filter_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }

    if (isset($_POST['show_thumbs_enabled']) && $_POST['show_thumbs_enabled'] == "Y") {

        if (isset($_POST['show_thumbs']) && is_numeric($_POST['show_thumbs'])) {
            $user_prefs['SHOW_THUMBS'] = $_POST['show_thumbs'];
        } else {
            $user_prefs['SHOW_THUMBS'] = 2;
        }

    } else {

        if (isset($_POST['show_thumbs']) && is_numeric($_POST['show_thumbs'])) {
            $user_prefs['SHOW_THUMBS'] = $_POST['show_thumbs'] * -1;
        } else {
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
    } else {
        $user_prefs['USE_MOVER_SPOILER'] = "N";
    }

    if (isset($_POST['use_mover_spoiler_global'])) {
        $user_prefs_global['USE_MOVER_SPOILER'] = ($_POST['use_mover_spoiler_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['USE_MOVER_SPOILER'] = false;
    }

    if (isset($_POST['use_light_mode_spoiler']) && $_POST['use_light_mode_spoiler'] == "Y") {
        $user_prefs['USE_LIGHT_MODE_SPOILER'] = "Y";
    } else {
        $user_prefs['USE_LIGHT_MODE_SPOILER'] = "N";
    }

    if (isset($_POST['use_light_mode_spoiler_global'])) {
        $user_prefs_global['USE_LIGHT_MODE_SPOILER'] = ($_POST['use_light_mode_spoiler_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['USE_LIGHT_MODE_SPOILER'] = false;
    }

    if (isset($_POST['use_overflow_resize']) && $_POST['use_overflow_resize'] == "Y") {
        $user_prefs['USE_OVERFLOW_RESIZE'] = "Y";
    } else {
        $user_prefs['USE_OVERFLOW_RESIZE'] = "N";
    }

    if (isset($_POST['use_overflow_resize_global'])) {
        $user_prefs_global['USE_OVERFLOW_RESIZE'] = ($_POST['use_overflow_resize_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['USE_OVERFLOW_RESIZE'] = false;
    }

    if (isset($_POST['reply_quick']) && ($_POST['reply_quick'] == "Y")) {
        $user_prefs['REPLY_QUICK'] = 'Y';
    } else {
        $user_prefs['REPLY_QUICK'] = 'N';
    }

    if (isset($_POST['reply_quick_global'])) {
        $user_prefs_global['REPLY_QUICK'] = ($_POST['reply_quick_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['REPLY_QUICK'] = false;
    }

    if (isset($_POST['thread_last_page']) && ($_POST['thread_last_page'] == "Y")) {
        $user_prefs['THREAD_LAST_PAGE'] = 'Y';
    } else {
        $user_prefs['THREAD_LAST_PAGE'] = 'N';
    }

    if (isset($_POST['thread_last_page_global'])) {
        $user_prefs_global['THREAD_LAST_PAGE'] = ($_POST['thread_last_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['THREAD_LAST_PAGE'] = false;
    }

    if (isset($_POST['show_avatars']) && ($_POST['show_avatars'] == "Y")) {
        $user_prefs['SHOW_AVATARS'] = 'Y';
    } else {
        $user_prefs['SHOW_AVATARS'] = 'N';
    }

    if (isset($_POST['show_avatars_global'])) {
        $user_prefs_global['SHOW_AVATARS'] = ($_POST['show_avatars_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['SHOW_AVATARS'] = false;
    }

    if (isset($_POST['show_share_links']) && ($_POST['show_share_links'] == "Y")) {
        $user_prefs['SHOW_SHARE_LINKS'] = 'Y';
    } else {
        $user_prefs['SHOW_SHARE_LINKS'] = 'N';
    }

    if (isset($_POST['show_share_links_global'])) {
        $user_prefs_global['SHOW_SHARE_LINKS'] = ($_POST['show_share_links_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['SHOW_SHARE_LINKS'] = false;
    }

    if (isset($_POST['enable_wiki_words']) && $_POST['enable_wiki_words'] == "Y") {
        $user_prefs['ENABLE_WIKI_WORDS'] = "Y";
    } else {
        $user_prefs['ENABLE_WIKI_WORDS'] = "N";
    }

    if (isset($_POST['enable_wiki_words_global'])) {
        $user_prefs_global['ENABLE_WIKI_WORDS'] = ($_POST['enable_wiki_words_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['ENABLE_WIKI_WORDS'] = false;
    }

    if (isset($_POST['enable_wiki_quick_links']) && $_POST['enable_wiki_quick_links'] == "Y") {
        $user_prefs['ENABLE_WIKI_QUICK_LINKS'] = "Y";
    } else {
        $user_prefs['ENABLE_WIKI_QUICK_LINKS'] = "N";
    }

    if (isset($_POST['enable_wiki_quick_links_global'])) {
        $user_prefs_global['ENABLE_WIKI_QUICK_LINKS'] = ($_POST['enable_wiki_quick_links_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['ENABLE_WIKI_QUICK_LINKS'] = false;
    }

    if (isset($_POST['enable_tags']) && $_POST['enable_tags'] == "Y") {
        $user_prefs['ENABLE_TAGS'] = "Y";
    } else {
        $user_prefs['ENABLE_TAGS'] = "N";
    }

    if (isset($_POST['enable_tags_global'])) {
        $user_prefs_global['ENABLE_TAGS'] = ($_POST['enable_tags_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['ENABLE_TAGS'] = false;
    }

    if (isset($_POST['show_stats']) && $_POST['show_stats'] == "Y") {
        $user_prefs['SHOW_STATS'] = "Y";
    } else {
        $user_prefs['SHOW_STATS'] = "N";
    }

    if (isset($_POST['show_stats_global'])) {
        $user_prefs_global['SHOW_STATS'] = ($_POST['show_stats_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['SHOW_STATS'] = false;
    }

    if (isset($_POST['posts_per_page'])) {
        $user_prefs['POSTS_PER_PAGE'] = trim($_POST['posts_per_page']);
    } else {
        $user_prefs['POSTS_PER_PAGE'] = 20;
    }

    if (isset($_POST['posts_per_page_global'])) {
        $user_prefs_global['POSTS_PER_PAGE'] = ($_POST['posts_per_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['POSTS_PER_PAGE'] = false;
    }

    if (isset($_POST['font_size'])) {
        $user_prefs['FONT_SIZE'] = trim($_POST['font_size']);
    } else {
        $user_prefs['FONT_SIZE'] = 10;
    }

    if (isset($_POST['font_size_global'])) {
        $user_prefs_global['FONT_SIZE'] = ($_POST['font_size_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['FONT_SIZE'] = false;
    }

    if (isset($_POST['style']) && style_exists(trim($_POST['style']))) {
        $user_prefs['STYLE'] = trim($_POST['style']);
    } else {
        $user_prefs['STYLE'] = forum_get_setting('default_style', 'strlen', 'default');
    }

    if (isset($_POST['style_global'])) {
        $user_prefs_global['STYLE'] = ($_POST['style_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['STYLE'] = false;
    }

    if (isset($_POST['emoticons'])) {
        $user_prefs['EMOTICONS'] = trim($_POST['emoticons']);
    } else {
        $user_prefs['EMOTICONS'] = forum_get_setting('default_emoticons', 'strlen', 'default');
    }

    if (isset($_POST['emoticons_global'])) {
        $user_prefs_global['EMOTICONS'] = ($_POST['emoticons_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['EMOTICONS'] = false;
    }

    if (isset($_POST['start_page'])) {
        $user_prefs['START_PAGE'] = trim($_POST['start_page']);
    } else {
        $user_prefs['START_PAGE'] = 0;
    }

    if (isset($_POST['start_page_global'])) {
        $user_prefs_global['START_PAGE'] = ($_POST['start_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['START_PAGE'] = false;
    }

    // Update USER_PREFS
    if (user_update_prefs($_SESSION['UID'], $user_prefs, $user_prefs_global)) {

        header_redirect("forum_options.php?webtag=$webtag&updated=true", gettext("Preferences were successfully updated."));
        exit;

    } else {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

// Check to see if we should show the set for all forums checkboxes
$show_set_all = (forums_get_available_count() > 1) ? true : false;

// Start output here
html_draw_top(
    array(
        'title' => gettext('My Controls - Forum Options'),
        'js' => array(
            'js/emoticons.js',
            'js/forum_options.js'
        ),
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Forum Options"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '700', 'left', 'preferences_updated');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"forum_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">", gettext("Time Zone"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"3\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Time zone"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("timezone", htmlentities_array($available_timezones), (isset($user_prefs['TIMEZONE']) && in_array($user_prefs['TIMEZONE'], array_keys($available_timezones))) ? $user_prefs['TIMEZONE'] : forum_get_setting('forum_timezone', 'is_numeric', 27), null, 'timezone_dropdown'), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_checkbox("dl_saving", "Y", gettext("Adjust for daylight saving"), (isset($user_prefs['DL_SAVING'])) ? ($user_prefs['DL_SAVING'] == 'Y') : forum_get_setting('forum_dl_saving', 'Y')), "</td>\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Language"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">", gettext("Language"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Preferred language"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("language", htmlentities_array($available_langs), (isset($user_prefs['LANGUAGE']) ? $user_prefs['LANGUAGE'] : 0)), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("language_global", "Y", null, (isset($user_prefs['LANGUAGE_GLOBAL']) ? $user_prefs['LANGUAGE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("language_global", 'Y'), "&nbsp;</td>\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Display"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Display"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"18\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("threads_by_folder", "Y", gettext("Sort Thread List by folders"), (isset($user_prefs['THREADS_BY_FOLDER']) && $user_prefs['THREADS_BY_FOLDER'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("threads_by_folder_global", "Y", null, (isset($user_prefs['THREADS_BY_FOLDER_GLOBAL']) ? $user_prefs['THREADS_BY_FOLDER_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("threads_by_folder_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("view_sigs", "N", gettext("Globally ignore user signatures"), (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "N") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("view_sigs_global", "Y", null, (isset($user_prefs['VIEW_SIGS_GLOBAL']) ? $user_prefs['VIEW_SIGS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("view_sigs_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("mark_as_of_int", "Y", gettext("Automatically mark threads I post in as High Interest"), (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("mark_as_of_int_global", "Y", null, (isset($user_prefs['MARK_AS_OF_INT_GLOBAL']) ? $user_prefs['MARK_AS_OF_INT_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("mark_as_of_int_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("images_to_links", "Y", gettext("Automatically convert embedded images in posts into links"), (isset($user_prefs['IMAGES_TO_LINKS']) && $user_prefs['IMAGES_TO_LINKS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\"  style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("images_to_links_global", "Y", null, (isset($user_prefs['IMAGES_TO_LINKS_GLOBAL']) ? $user_prefs['IMAGES_TO_LINKS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("images_to_links_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("show_thumbs_enabled", "Y", array(gettext("Show"), " ", form_dropdown_array("show_thumbs", array(ATTACHMENT_THUMB_SMALL => gettext("Small Sized"), ATTACHMENT_THUMB_MEDIUM => gettext("Medium Sized"), ATTACHMENT_THUMB_LARGE => gettext("Large Sized")), (isset($user_prefs['SHOW_THUMBS']) ? ($user_prefs['SHOW_THUMBS'] > 0 ? $user_prefs['SHOW_THUMBS'] : $user_prefs['SHOW_THUMBS'] * -1) : 2)), " ", gettext("thumbnails for image attachments")), (isset($user_prefs['SHOW_THUMBS']) && $user_prefs['SHOW_THUMBS'] > 0) ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("show_thumbs_global", "Y", null, (isset($user_prefs['SHOW_THUMBS_GLOBAL']) ? $user_prefs['SHOW_THUMBS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("show_thumbs_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("enable_wiki_words", "Y", gettext("Enable WikiWiki Integration"), (isset($user_prefs['ENABLE_WIKI_WORDS']) && $user_prefs['ENABLE_WIKI_WORDS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("enable_wiki_words_global", "Y", null, (isset($user_prefs['ENABLE_WIKI_WORDS_GLOBAL']) ? $user_prefs['ENABLE_WIKI_WORDS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("enable_wiki_words_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("enable_wiki_quick_links", "Y", gettext("Enable WikiWiki Quick links"), (isset($user_prefs['ENABLE_WIKI_QUICK_LINKS']) && $user_prefs['ENABLE_WIKI_QUICK_LINKS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("enable_wiki_quick_links_global", "Y", null, (isset($user_prefs['ENABLE_WIKI_QUICK_LINKS_GLOBAL']) ? $user_prefs['ENABLE_WIKI_QUICK_LINKS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("enable_wiki_quick_links_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("enable_tags", "Y", gettext("Enable post tagging with #hashtags"), (isset($user_prefs['ENABLE_TAGS']) && $user_prefs['ENABLE_TAGS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("enable_tags_global", "Y", null, (isset($user_prefs['ENABLE_TAGS_GLOBAL']) ? $user_prefs['ENABLE_TAGS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("enable_tags_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("use_mover_spoiler", "Y", gettext("Reveal spoilers on mouse over"), (isset($user_prefs['USE_MOVER_SPOILER']) && $user_prefs['USE_MOVER_SPOILER'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("use_mover_spoiler_global", "Y", null, (isset($user_prefs['USE_MOVER_SPOILER_GLOBAL']) ? $user_prefs['USE_MOVER_SPOILER_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("use_mover_spoiler_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("use_light_mode_spoiler", "Y", gettext("Always show spoilers in Mobile version (uses lighter font colour)"), (isset($user_prefs['USE_LIGHT_MODE_SPOILER']) && $user_prefs['USE_LIGHT_MODE_SPOILER'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("use_light_mode_spoiler_global", "Y", null, (isset($user_prefs['USE_LIGHT_MODE_SPOILER_GLOBAL']) ? $user_prefs['USE_LIGHT_MODE_SPOILER_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("use_light_mode_spoiler_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("show_stats", "Y", gettext("Show forum stats at bottom of message pane"), (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("show_stats_global", "Y", null, (isset($user_prefs['SHOW_STATS_GLOBAL']) ? $user_prefs['SHOW_STATS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("show_stats_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("use_word_filter", "Y", gettext("Enable word filter."), (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "&nbsp;<span>[<a href=\"edit_wordfilter.php?webtag=$webtag\">", gettext("Edit Word Filter"), "</a>]</span></td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("use_word_filter_global", "Y", null, (isset($user_prefs['USE_WORD_FILTER_GLOBAL']) ? $user_prefs['USE_WORD_FILTER_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("use_word_filter_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("use_overflow_resize", "Y", gettext("Resize images and reflow page to prevent horizontal scrolling."), (isset($user_prefs['USE_OVERFLOW_RESIZE']) && $user_prefs['USE_OVERFLOW_RESIZE'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("use_overflow_resize_global", "Y", null, (isset($user_prefs['USE_OVERFLOW_RESIZE_GLOBAL']) ? $user_prefs['USE_OVERFLOW_RESIZE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("use_overflow_resize_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("reply_quick", "Y", gettext("Use Quick Reply by default. (Full reply in menu)"), (isset($user_prefs['REPLY_QUICK']) && $user_prefs['REPLY_QUICK'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("reply_quick_global", "Y", null, (isset($user_prefs['REPLY_QUICK_GLOBAL']) ? $user_prefs['REPLY_QUICK_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("reply_quick_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("thread_last_page", "Y", gettext("Thread list last post link goes to last page of posts."), (isset($user_prefs['THREAD_LAST_PAGE']) && $user_prefs['THREAD_LAST_PAGE'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("thread_last_page_global", "Y", null, (isset($user_prefs['THREAD_LAST_PAGE_GLOBAL']) ? $user_prefs['THREAD_LAST_PAGE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("thread_last_page_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("show_avatars", "Y", gettext("Show user avatars in message headers, visitor log and active user list"), (isset($user_prefs['SHOW_AVATARS']) && $user_prefs['SHOW_AVATARS'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("show_avatars_global", "Y", null, (isset($user_prefs['SHOW_AVATARS_GLOBAL']) ? $user_prefs['SHOW_AVATARS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("show_avatars_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("show_share_links", "Y", gettext("Show social network share links at top of each thread"), (isset($user_prefs['SHOW_SHARE_LINKS']) && $user_prefs['SHOW_SHARE_LINKS'] == "Y")), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("show_share_links_global", "Y", null, (isset($user_prefs['SHOW_SHARE_LINKS_GLOBAL']) ? $user_prefs['SHOW_SHARE_LINKS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("show_avatars_global", 'Y'), "&nbsp;</td>\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Style"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">", gettext("Style"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"7\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Posts per page"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("posts_per_page", array(10 => 10, 20 => 20, 30 => 30), (isset($user_prefs['POSTS_PER_PAGE']) && is_numeric($user_prefs['POSTS_PER_PAGE'])) ? $user_prefs['POSTS_PER_PAGE'] : 10), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("posts_per_page_global", "Y", null, (isset($user_prefs['POSTS_PER_PAGE_GLOBAL']) ? $user_prefs['POSTS_PER_PAGE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("posts_per_page_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Font size"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("font_size", array(5 => '5pt', 6 => '6pt', 7 => '7pt', 8 => '8pt', 9 => '9pt', 10 => '10pt', 11 => '11pt', 12 => '12pt', 13 => '13pt', 14 => '14pt', 15 => '15pt'), (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) ? $user_prefs['FONT_SIZE'] : 10), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("font_size_global", "Y", null, (isset($user_prefs['FONT_SIZE_GLOBAL']) ? $user_prefs['FONT_SIZE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("font_size_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";

if (($available_styles = styles_get_available()) !== false) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Forum style"), ":</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("style", htmlentities_array($available_styles), (isset($user_prefs['STYLE']) && style_exists($user_prefs['STYLE'])) ? htmlentities_array($user_prefs['STYLE']) : htmlentities_array(forum_get_setting('default_style', 'strlen', 'default'))), "</td>\n";
    echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("style_global", "Y", null, (isset($user_prefs['STYLE_GLOBAL']) ? $user_prefs['STYLE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("style_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
}

if (sizeof($available_emoticons) > 1) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Forum emoticons"), " [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" class=\"emoticon_preview_popup\">", gettext("Preview"), "</a>]:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("emoticons", htmlentities_array($available_emoticons), (isset($user_prefs['EMOTICONS']) && in_array($user_prefs['EMOTICONS'], array_keys($available_emoticons))) ? htmlentities_array($user_prefs['EMOTICONS']) : htmlentities_array(forum_get_setting('default_emoticons', 'strlen', 'default'))), "</td>\n";
    echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("emoticons_global", "Y", null, (isset($user_prefs['EMOTICONS_GLOBAL']) ? $user_prefs['EMOTICONS_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("emoticons_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Start page"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("start_page", array(START_PAGE_NORMAL => gettext("Start"), START_PAGE_MESSAGES => gettext("Messages"), START_PAGE_INBOX => gettext("Inbox")), (isset($user_prefs['START_PAGE'])) ? $user_prefs['START_PAGE'] : 0), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("start_page_global", "Y", null, (isset($user_prefs['START_PAGE_GLOBAL']) ? $user_prefs['START_PAGE_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("start_page_global", 'Y'), "&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();