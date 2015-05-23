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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'adsense.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'lang.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'styles.inc.php';
require_once BH_INCLUDE_PATH . 'timezone.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Content Ratings
$content_ratings_array = array(
    FORUM_RATING_GENERAL => 'General',
    FORUM_RATING_FOURTEEN => '14 Years',
    FORUM_RATING_MATURE => 'Mature',
    FORUM_RATING_RESTRICTED => 'Restricted'
);

// Array of valid Google Adsense ad user account types
$adsense_user_type_array = array(
    ADSENSE_DISPLAY_NONE => gettext("No-one (disabled)"),
    ADSENSE_DISPLAY_ALL_USERS => gettext("All Users"),
    ADSENSE_DISPLAY_GUESTS => gettext("Guests only")
);

// Array of valid Google Adsense ad page types
$adsense_page_type_array = array(
    ADSENSE_DISPLAY_TOP_OF_ALL_PAGES => gettext("Top of every page"),
    ADSENSE_DISPLAY_TOP_OF_MESSAGES => gettext("Top of messages"),
    ADSENSE_DISPLAY_BOTTOM_OF_ALL_PAGES => gettext("Bottom of every page"),
    ADSENSE_DISPLAY_BOTTOM_OF_MESSAGES => gettext("Bottom of messages"),
    ADSENSE_DISPLAY_ONCE_AFTER_NTH_MSG => gettext("Once only after the nth post"),
    ADSENSE_DISPLAY_AFTER_EVERY_NTH_MSG => gettext("After every nth post"),
    ADSENSE_DISPLAY_AFTER_RANDOM_MSG => gettext("Once after a random post")
);

// Array to hold error messages.
$error_msg_array = array();

// Get an array of available emoticon sets
$available_emoticons = emoticons_get_available();

// Get an array of available languages
$available_langs = lang_get_available(false);

// Get an array of available timezones.
$available_timezones = get_available_timezones();

// Get the forum settings
$forum_settings = forum_get_settings();

// Get the global forum settings
$forum_global_settings = forum_get_global_settings();

// Submit code starts here
if (isset($_POST['changepermissions'])) {

    $redirect_uri = "admin_forum_access.php?webtag=$webtag&fid={$forum_settings['fid']}";
    $redirect_uri .= "&ret=" . rawurlencode(get_request_uri(true, false));

    header_redirect($redirect_uri);
    exit;

} else if (isset($_POST['changepassword'])) {

    $redirect_uri = "admin_forum_set_passwd.php?webtag=$webtag&fid={$forum_settings['fid']}";
    $redirect_uri .= "&ret=" . rawurlencode(get_request_uri(true, false));

    header_redirect($redirect_uri);
    exit;

} else if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['forum_name']) && strlen(trim($_POST['forum_name'])) > 0) {
        $new_forum_settings['forum_name'] = trim($_POST['forum_name']);
    } else {
        $error_msg_array[] = gettext("You must supply a forum name");
        $valid = false;
    }

    if (isset($_POST['forum_email']) && strlen(trim($_POST['forum_email'])) > 0) {
        $new_forum_settings['forum_email'] = trim($_POST['forum_email']);
    } else {
        $error_msg_array[] = gettext("You must supply a forum email address");
        $valid = false;
    }

    if (isset($_POST['forum_desc']) && strlen(trim($_POST['forum_desc'])) > 0) {
        $new_forum_settings['forum_desc'] = trim($_POST['forum_desc']);
    } else {
        $new_forum_settings['forum_desc'] = "";
    }

    if (isset($_POST['forum_content_rating']) && is_numeric($_POST['forum_content_rating'])) {
        $new_forum_settings['forum_content_rating'] = $_POST['forum_content_rating'];
    } else {
        $new_forum_settings['forum_content_rating'] = FORUM_RATING_GENERAL;
    }

    if (isset($_POST['forum_keywords']) && strlen(trim($_POST['forum_keywords'])) > 0) {
        $new_forum_settings['forum_keywords'] = trim($_POST['forum_keywords']);
    } else {
        $new_forum_settings['forum_keywords'] = "";
    }

    if (isset($_POST['default_style']) && style_exists(trim($_POST['default_style']))) {

        $new_forum_settings['default_style'] = trim($_POST['default_style']);

    } else {

        $error_msg_array[] = gettext("You must choose a default forum style");
        $valid = false;
    }

    if (isset($_POST['default_emoticons']) && strlen(trim($_POST['default_emoticons'])) > 0) {

        $new_forum_settings['default_emoticons'] = trim($_POST['default_emoticons']);

        if (!emoticons_set_exists($new_forum_settings['default_emoticons'])) {
            $error_msg_array[] = gettext("Unknown emoticons name");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must choose default forum emoticons");
        $valid = false;
    }

    if (isset($_POST['default_language']) && in_array($_POST['default_language'], $available_langs)) {

        $new_forum_settings['default_language'] = $_POST['default_language'];

    } else {

        $error_msg_array[] = gettext("You must choose a default forum language");
        $valid = false;
    }

    if (forum_get_global_setting('allow_forum_google_analytics', 'Y')) {

        if (isset($_POST['enable_google_analytics']) && $_POST['enable_google_analytics'] == "Y") {
            $new_forum_settings['enable_google_analytics'] = "Y";
        } else {
            $new_forum_settings['enable_google_analytics'] = "N";
        }

        if (isset($_POST['google_analytics_code']) && strlen(trim($_POST['google_analytics_code'])) > 0) {
            $new_forum_settings['google_analytics_code'] = trim($_POST['google_analytics_code']);
        } else {
            $new_forum_settings['google_analytics_code'] = "";
        }
    }

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

        if (isset($_POST['adsense_display_users']) && in_array($_POST['adsense_display_users'], array_keys($adsense_user_type_array))) {
            $new_forum_settings['adsense_display_users'] = $_POST['adsense_display_users'];
        } else {
            $new_forum_settings['adsense_display_users'] = ADSENSE_DISPLAY_NONE;
        }

        if (isset($_POST['adsense_display_pages']) && in_array($_POST['adsense_display_pages'], array_keys($adsense_page_type_array))) {
            $new_forum_settings['adsense_display_pages'] = $_POST['adsense_display_pages'];
        } else {
            $new_forum_settings['adsense_display_pages'] = ADSENSE_DISPLAY_TOP_OF_ALL_PAGES;
        }

    } else {

        $new_forum_settings['adsense_display_users'] = forum_get_global_setting('adsense_display_users', 'is_numeric', ADSENSE_DISPLAY_NONE);
        $new_forum_settings['adsense_display_pages'] = forum_get_global_setting('adsense_display_pages', 'is_numeric', ADSENSE_DISPLAY_TOP_OF_ALL_PAGES);
    }

    if (isset($_POST['forum_timezone']) && is_numeric($_POST['forum_timezone'])) {
        $new_forum_settings['forum_timezone'] = $_POST['forum_timezone'];
    } else {
        $new_forum_settings['forum_timezone'] = 27;
    }

    if (isset($_POST['forum_dl_saving']) && $_POST['forum_dl_saving'] == "Y") {
        $new_forum_settings['forum_dl_saving'] = "Y";
    } else {
        $new_forum_settings['forum_dl_saving'] = "N";
    }

    if (isset($_POST['access_level']) && is_numeric($_POST['access_level'])) {
        forum_update_access($forum_settings['fid'], $_POST['access_level']);
    }

    if (isset($_POST['closed_message']) && strlen(trim($_POST['closed_message'])) > 0) {
        $new_forum_settings['closed_message'] = fix_html(emoticons_strip($_POST['closed_message']), true);
    } else {
        $new_forum_settings['closed_message'] = "";
    }

    if (isset($_POST['restricted_message']) && strlen(trim($_POST['restricted_message'])) > 0) {
        $new_forum_settings['restricted_message'] = fix_html(emoticons_strip($_POST['restricted_message']), true);
    } else {
        $new_forum_settings['restricted_message'] = "";
    }

    if (isset($_POST['password_protected_message']) && strlen(trim($_POST['password_protected_message'])) > 0) {
        $new_forum_settings['password_protected_message'] = fix_html(emoticons_strip($_POST['password_protected_message']), true);
    } else {
        $new_forum_settings['password_protected_message'] = "";
    }

    if (isset($_POST['allow_post_editing']) && $_POST['allow_post_editing'] == "Y") {
        $new_forum_settings['allow_post_editing'] = "Y";
    } else {
        $new_forum_settings['allow_post_editing'] = "N";
    }

    if (isset($_POST['post_edit_time']) && is_numeric($_POST['post_edit_time'])) {
        $new_forum_settings['post_edit_time'] = $_POST['post_edit_time'];
    } else {
        $new_forum_settings['post_edit_time'] = 0;
    }

    if (isset($_POST['post_edit_grace_period']) && is_numeric($_POST['post_edit_grace_period'])) {
        $new_forum_settings['post_edit_grace_period'] = $_POST['post_edit_grace_period'];
    } else {
        $new_forum_settings['post_edit_grace_period'] = 0;
    }

    if (isset($_POST['maximum_post_length']) && is_numeric($_POST['maximum_post_length'])) {
        $new_forum_settings['maximum_post_length'] = $_POST['maximum_post_length'];
    } else {
        $new_forum_settings['maximum_post_length'] = 6226;
    }

    if (isset($_POST['minimum_post_frequency']) && is_numeric($_POST['minimum_post_frequency'])) {
        $new_forum_settings['minimum_post_frequency'] = $_POST['minimum_post_frequency'];
    } else {
        $new_forum_settings['minimum_post_frequency'] = 0;
    }

    if (isset($_POST['enable_tags']) && $_POST['enable_tags'] == "Y") {
        $new_forum_settings['enable_tags'] = "Y";
    } else {
        $new_forum_settings['enable_tags'] = "N";
    }

    if (isset($_POST['enable_wiki_integration']) && $_POST['enable_wiki_integration'] == "Y") {
        $new_forum_settings['enable_wiki_integration'] = "Y";
    } else {
        $new_forum_settings['enable_wiki_integration'] = "N";
    }

    if (isset($_POST['enable_wiki_quick_links']) && $_POST['enable_wiki_quick_links'] == "Y") {
        $new_forum_settings['enable_wiki_quick_links'] = "Y";
    } else {
        $new_forum_settings['enable_wiki_quick_links'] = "N";
    }

    if (isset($_POST['wiki_integration_uri']) && strlen(trim($_POST['wiki_integration_uri'])) > 0) {
        $new_forum_settings['wiki_integration_uri'] = trim($_POST['wiki_integration_uri']);
    } else {
        $new_forum_settings['wiki_integration_uri'] = "";
    }

    if (isset($_POST['show_links']) && $_POST['show_links'] == "Y") {
        $new_forum_settings['show_links'] = "Y";
    } else {
        $new_forum_settings['show_links'] = "N";
    }

    if (isset($_POST['require_link_approval']) && $_POST['require_link_approval'] == "Y") {
        $new_forum_settings['require_link_approval'] = "Y";
    } else {
        $new_forum_settings['require_link_approval'] = "N";
    }

    if (isset($_POST['show_share_links']) && $_POST['show_share_links'] == "Y") {
        $new_forum_settings['show_share_links'] = "Y";
    } else {
        $new_forum_settings['show_share_links'] = "N";
    }

    if (isset($_POST['allow_polls']) && $_POST['allow_polls'] == "Y") {
        $new_forum_settings['allow_polls'] = "Y";
    } else {
        $new_forum_settings['allow_polls'] = "N";
    }

    if (isset($_POST['poll_allow_guests']) && $_POST['poll_allow_guests'] == "Y") {
        $new_forum_settings['poll_allow_guests'] = "Y";
    } else {
        $new_forum_settings['poll_allow_guests'] = "N";
    }

    if (isset($_POST['show_stats']) && $_POST['show_stats'] == "Y") {
        $new_forum_settings['show_stats'] = "Y";
    } else {
        $new_forum_settings['show_stats'] = "N";
    }

    if (isset($_POST['allow_search_spidering']) && $_POST['allow_search_spidering'] == "Y") {
        $new_forum_settings['allow_search_spidering'] = "Y";
    } else {
        $new_forum_settings['allow_search_spidering'] = "N";
    }

    if (isset($_POST['searchbots_show_recent']) && $_POST['searchbots_show_recent'] == "Y") {
        $new_forum_settings['searchbots_show_recent'] = "Y";
    } else {
        $new_forum_settings['searchbots_show_recent'] = "N";
    }

    if (isset($_POST['searchbots_show_active']) && $_POST['searchbots_show_active'] == "Y") {
        $new_forum_settings['searchbots_show_active'] = "Y";
    } else {
        $new_forum_settings['searchbots_show_active'] = "N";
    }

    if (isset($_POST['guest_account_enabled']) && $_POST['guest_account_enabled'] == "Y") {
        $new_forum_settings['guest_account_enabled'] = "Y";
    } else {
        $new_forum_settings['guest_account_enabled'] = "N";
    }

    if (isset($_POST['guest_show_recent']) && $_POST['guest_show_recent'] == "Y") {
        $new_forum_settings['guest_show_recent'] = "Y";
    } else {
        $new_forum_settings['guest_show_recent'] = "N";
    }

    if ($valid) {

        if (forum_save_settings($new_forum_settings)) {

            admin_add_log_entry(EDIT_FORUM_SETTINGS, array($new_forum_settings['forum_name']));
            header_redirect("admin_forum_settings.php?webtag=$webtag&updated=true", gettext("Forum settings successfully updated"));

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Failed to update forum settings. Please try again later.");
        }
    }
}

html_draw_top(
    array(
        'title' => gettext('Admin - Forum Settings'),
        'class' => 'window_title',
        'js' => array(
            'js/emoticons.js',
            'ckeditor/ckeditor.js'
        ),
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Forum Settings"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'center');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '700', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_forum_settings.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Main Settings"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Name"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_name", (isset($forum_settings['forum_name']) ? htmlentities_array($forum_settings['forum_name']) : 'A Beehive Forum'), 42, 255), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Email"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_email", (isset($forum_settings['forum_email']) ? htmlentities_array($forum_settings['forum_email']) : 'admin@beehiveforum.co.uk'), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Description"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_desc", (isset($forum_settings['forum_desc']) ? htmlentities_array($forum_settings['forum_desc']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Keywords"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_keywords", (isset($forum_settings['forum_keywords']) ? htmlentities_array($forum_settings['forum_keywords']) : ''), 42, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Content Rating"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("forum_content_rating", htmlentities_array($content_ratings_array), (isset($forum_settings['forum_content_rating']) ? htmlentities_array($forum_settings['forum_content_rating']) : 0)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";

if (($available_styles = styles_get_available()) !== false) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">", gettext("Default Style"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("default_style", htmlentities_array($available_styles), (isset($forum_settings['default_style']) && style_exists($forum_settings['default_style']) ? htmlentities_array($forum_settings['default_style']) : 'default')), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Default Emoticons"), " [<a href=\"display_emoticons.php?webtag=$webtag\" target=\"_blank\" class=\"popup 500x400\">", gettext("Preview"), "</a>]:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("default_emoticons", htmlentities_array($available_emoticons), (isset($forum_settings['default_emoticons']) && in_array($forum_settings['default_emoticons'], array_keys($available_emoticons)) ? $forum_settings['default_emoticons'] : 'none')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Default Language"), ":</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Time Zone"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Time zone"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("forum_timezone", htmlentities_array($available_timezones), (isset($forum_settings['forum_timezone']) && is_numeric($forum_settings['forum_timezone']) ? $forum_settings['forum_timezone'] : 27), null, 'timezone_dropdown'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox("forum_dl_saving", "Y", gettext("Adjust for daylight saving"), (isset($forum_settings['forum_dl_saving']) && $forum_settings['forum_dl_saving'] == 'Y') ? true : false), "</td>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Forum Access Settings"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Access Status"), ":</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_UNRESTRICTED, gettext("Open"), (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_UNRESTRICTED ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_CLOSED, gettext("Closed"), (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_CLOSED ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_RESTRICTED, gettext("Restricted"), (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_RESTRICTED ? true : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("access_level", FORUM_PASSWD_PROTECTED, gettext("Password Protected"), (isset($forum_settings['access_level']) && $forum_settings['access_level'] == FORUM_PASSWD_PROTECTED ? true : false)), "</td>\n";
    echo "                      </tr>\n";

    if ($forum_settings['access_level'] == FORUM_RESTRICTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"center\" colspan=\"2\">", form_submit("changepermissions", gettext("Change Permissions")), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";

    } else if ($forum_settings['access_level'] == FORUM_PASSWD_PROTECTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";

        if (!forum_get_password($forum_settings['fid'])) {

            echo "                      <tr>\n";
            echo "                        <td align=\"center\" colspan=\"2\">\n";

            html_display_warning_msg(gettext("You have not set a forum password. If you do not set a password the password protection functionality will be automatically disabled!"), '95%', 'center');

            echo "                        </td>\n";
            echo "                      </tr>\n";
        }

        echo "                      <tr>\n";
        echo "                        <td align=\"center\" colspan=\"2\">", form_submit("changepassword", gettext("Change Password")), "</td>\n";
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
    echo "                          <p>", gettext("<b>Forum Access Status</b> controls how users may access your forum."), "</p>\n";
    echo "                          <p>", gettext("<b>Open</b> will allow all users and guests access to your forum without restriction."), "</p>\n";
    echo "                          <p>", gettext("<b>Closed</b> prevents access for all users, with the exception of the admin who may still access the admin panel."), "</p>\n";
    echo "                          <p>", gettext("<b>Restricted</b> allows to set a list of users who are allowed access to your forum."), "</p>\n";
    echo "                          <p>", gettext("<b>Password Protected</b> allows you to set a password to give out to users so they can access your forum."), "</p>\n";

    html_display_warning_msg(gettext("When setting Restricted or Password Protected mode you will need to save your changes before you can change the user access privileges or password."), '95%', 'center');

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

if (!isset($forum_settings['closed_message'])) $forum_settings['closed_message'] = '';
if (!isset($forum_settings['restricted_message'])) $forum_settings['restricted_message'] = '';
if (!isset($forum_settings['password_protected_message'])) $forum_settings['password_protected_message'] = '';

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Forum Status Messages"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Forum Closed Message"), ":</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_textarea("closed_message", htmlentities_array($forum_settings['closed_message']), 7, 80, null, 'admin_tools_textarea editor'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Restricted Message"), ":</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_textarea("restricted_message", htmlentities_array($forum_settings['restricted_message']), 7, 80, null, 'admin_tools_textarea editor'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Password Protected Message"), ":</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_textarea("password_protected_message", $forum_settings['password_protected_message'], 7, 80, null, 'admin_tools_textarea editor'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("Use <b>Closed Message</b>, <b>Restricted Message</b> and <b>Password Protected Message</b> to customise the message displayed when users access your forum in the various states."), "</p>\n";
echo "                          <p>", gettext("You can use HTML in your messages. Hyperlinks and email addresses will also be automatically converted to links. To use the default Beehive Forum messages clear the fields."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Post Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Enable Post Tagging"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_tags", "Y", gettext("Yes"), (isset($forum_settings['enable_tags']) && $forum_settings['enable_tags'] == "Y")), "&nbsp;", form_radio("enable_tags", "N", gettext("No"), (isset($forum_settings['enable_tags']) && $forum_settings['enable_tags'] == "N") || !isset($forum_settings['enable_tags'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Allow Post Editing"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_post_editing", "Y", gettext("Yes"), (isset($forum_settings['allow_post_editing']) && $forum_settings['allow_post_editing'] == "Y")), "&nbsp;", form_radio("allow_post_editing", "N", gettext("No"), (isset($forum_settings['allow_post_editing']) && $forum_settings['allow_post_editing'] == "N") || !isset($forum_settings['allow_post_editing'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Post Edit Timeout"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("post_edit_time", (isset($forum_settings['post_edit_time']) && is_numeric($forum_settings['post_edit_time']) ? htmlentities_array($forum_settings['post_edit_time']) : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Post Edit Grace Period"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("post_edit_grace_period", (isset($forum_settings['post_edit_grace_period']) && is_numeric($forum_settings['post_edit_grace_period']) ? htmlentities_array($forum_settings['post_edit_grace_period']) : '0'), 20, 32), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Maximum Post Length"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("maximum_post_length", (isset($forum_settings['maximum_post_length']) && is_numeric($forum_settings['maximum_post_length']) ? htmlentities_array($forum_settings['maximum_post_length']) : '6226'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Post Frequency"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("minimum_post_frequency", (isset($forum_settings['minimum_post_frequency']) && is_numeric($forum_settings['minimum_post_frequency']) ? htmlentities_array($forum_settings['minimum_post_frequency']) : '0'), 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("<b>Enable Post Tagging</b> allows users to tag posts by add alpha-numeric tags to posts prefixed with a hash(#) character. These tags can be clicked to find all similarly tagged posts quickly and easily."), "</p>\n";
echo "                          <p>", gettext("<b>Post Edit Timeout</b> is the time in minutes after posting that a user can edit their post. If set to 0 there is no limit."), "</p>\n";
echo "                          <p>", gettext("<b>Post Edit Grace Period</b> allows you to define a period in minutes where users may edit posts without the 'EDITED BY' text appearing on their posts. If set to 0 the 'EDITED BY' text will always appear."), "</p>\n";
echo "                          <p>", gettext("<b>Maximum Post Length</b> is the maximum number of characters that will be displayed in a post. If a post is longer than the number of characters defined here it will be cut short and a link added to the bottom to allow users to read the whole post on a separate page."), "</p>\n";
echo "                          <p>", gettext("<b>Post Frequency</b> is the minimum time a user must wait before they can post again. This setting also affects the creation of polls. Set to 0 to disable the restriction."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("WikiWiki Integration"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Enable WikiWiki Integration"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_wiki_integration", "Y", gettext("Yes"), (isset($forum_settings['enable_wiki_integration']) && $forum_settings['enable_wiki_integration'] == "Y")), "&nbsp;", form_radio("enable_wiki_integration", "N", gettext("No"), (isset($forum_settings['enable_wiki_integration']) && $forum_settings['enable_wiki_integration'] == "N") || !isset($forum_settings['enable_wiki_integration'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Enable WikiWiki Quick Links"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_wiki_quick_links", "Y", gettext("Yes"), (isset($forum_settings['enable_wiki_quick_links']) && $forum_settings['enable_wiki_quick_links'] == "Y")), "&nbsp;", form_radio("enable_wiki_quick_links", "N", gettext("No"), (isset($forum_settings['enable_wiki_quick_links']) && $forum_settings['enable_wiki_quick_links'] == "N") || !isset($forum_settings['enable_wiki_quick_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("WikiWiki Location"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("wiki_integration_uri", (isset($forum_settings['wiki_integration_uri']) ? htmlentities_array($forum_settings['wiki_integration_uri']) : 'http://en.wikipedia.org/wiki/[WikiWord]'), 42, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("<b>Enable WikiWiki Integration</b> provides WikiWord support in your Forum posts. A WikiWord is made up of two or more concatenated words with uppercase letters (often referred to as CamelCase). If you write a word this way it will automatically be changed into a hyperlink pointing to your chosen WikiWiki."), "</p>\n";
echo "                          <p>", gettext("<b>Enable WikiWiki Quick Links</b> enables the use of msg:1.1 and User:Logon style extended WikiLinks which create hyperlinks to the specified message / user profile of the specified user."), "</p>\n";
echo "                          <p>", gettext("<b>WikiWiki Location</b> is used to specify the URI of your WikiWiki. When entering the URI use <i>[WikiWord]</i> to indicate where in the URI the WikiWord should appear, i.e.: <i>http://en.wikipedia.org/wiki/[WikiWord]</i> would link your WikiWords to <a href=\"http://en.wikipedia.org/wiki/\" target=\"_blank\">Wikipedia.org</a>"), "</p>\n";
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

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Google Analytics"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">", gettext("Enable Google Analytics"), ":</td>\n";
    echo "                        <td align=\"left\">", form_radio("enable_google_analytics", "Y", gettext("Yes"), (isset($forum_settings['enable_google_analytics']) && $forum_settings['enable_google_analytics'] == "Y")), "&nbsp;", form_radio("enable_google_analytics", "N", gettext("No"), (isset($forum_settings['enable_google_analytics']) && $forum_settings['enable_google_analytics'] == "N") || !isset($forum_settings['enable_google_analytics'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Google Analytics Account ID"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("google_analytics_code", (isset($forum_settings['google_analytics_code']) ? htmlentities_array($forum_settings['google_analytics_code']) : ''), 31, 20), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">\n";
    echo "                          <p>", gettext("Enter your <b>Google Analytics Account ID</b> here to enable Google Analytic tracking of your forum. Google Analytics will track visitors to your site and record how long they stay and which pages they visit. By visiting the Google Analytics site you can see an overview of how your forum is used."), "</p>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\" colspan=\"2\">\n";

    html_display_warning_msg(gettext("If you do not have a Google Analytics Account you will need to sign up for one by clicking <a href=\"https://www.google.com/analytics/\" target=\"_blank\">here</a>."), '95%', 'center');

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

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Google AdSense"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"220\">", gettext("Display AdSense Ads for"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array('adsense_display_users', $adsense_user_type_array, (isset($forum_global_settings['adsense_display_users']) && in_array($forum_global_settings['adsense_display_users'], array_keys($adsense_user_type_array)) ? $forum_global_settings['adsense_display_users'] : ADSENSE_DISPLAY_NONE)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Display AdSense Ads on"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array('adsense_display_pages', $adsense_page_type_array, (isset($forum_global_settings['adsense_display_pages']) && in_array($forum_global_settings['adsense_display_pages'], array_keys($adsense_page_type_array)) ? $forum_global_settings['adsense_display_pages'] : ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\" colspan=\"2\">\n";

    html_display_warning_msg(gettext("To change Google AdSense account details and other settings please see Global Forum Settings"), '95%', 'center');

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

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Links"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Enable Links section"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("show_links", "Y", gettext("Yes"), (isset($forum_settings['show_links']) && $forum_settings['show_links'] == "Y")), "&nbsp;", form_radio("show_links", "N", gettext("No"), (isset($forum_settings['show_links']) && $forum_settings['show_links'] == "N") || !isset($forum_settings['show_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Require Links approval"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("require_link_approval", "Y", gettext("Yes"), (isset($forum_settings['require_link_approval']) && $forum_settings['require_link_approval'] == "Y")), "&nbsp;", form_radio("require_link_approval", "N", gettext("No"), (isset($forum_settings['require_link_approval']) && $forum_settings['require_link_approval'] == "N") || !isset($forum_settings['require_link_approval'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("The Links section of Beehive provides a place for your users to maintain a list of sites they frequently visit that other users may find useful. Links can be divided into categories by folder and allow for comments and ratings to be given. In order to moderate the links section a user must be granted Global Moderator status."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Share Links"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Show Share Links"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("show_share_links", "Y", gettext("Yes"), (isset($forum_settings['show_share_links']) && $forum_settings['show_share_links'] == "Y")), "&nbsp;", form_radio("show_share_links", "N", gettext("No"), (isset($forum_settings['show_share_links']) && $forum_settings['show_share_links'] == "N") || !isset($forum_settings['show_share_links'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("Enabling <b>Show Share Links</b> adds social network share links for Google+, Facebook and Twitter, at the top of each thread. Users can opt-out of displaying these buttons from their My Controls area. By disabling it here, they will be hidden for all users."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Polls"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Allow creation of polls"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_polls", "Y", gettext("Yes"), (isset($forum_settings['allow_polls']) && $forum_settings['allow_polls'] == "Y")), "&nbsp;", form_radio("allow_polls", "N", gettext("No"), (isset($forum_settings['allow_polls']) && $forum_settings['allow_polls'] == "N") || !isset($forum_settings['allow_polls'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Allow Guests to vote in polls"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("poll_allow_guests", "Y", gettext("Yes"), (isset($forum_settings['poll_allow_guests']) && $forum_settings['poll_allow_guests'] == "Y")), "&nbsp;", form_radio("poll_allow_guests", "N", gettext("No"), (isset($forum_settings['poll_allow_guests']) && $forum_settings['poll_allow_guests'] == "N") || !isset($forum_settings['poll_allow_guests'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("If you don't want your users to be able to create polls you can disable the above option."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Stats"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Enable Stats Display"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("show_stats", "Y", gettext("Yes"), (isset($forum_settings['show_stats']) && $forum_settings['show_stats'] == "Y")), "&nbsp;", form_radio("show_stats", "N", gettext("No"), (isset($forum_settings['show_stats']) && $forum_settings['show_stats'] == "N") || !isset($forum_settings['show_stats'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("Enabling this option allows Beehive to include a stats display at the bottom of the messages pane similar to the one used by many forum software titles. Once enabled the display of the stats page can be toggled individually by each user. If they don't want to see it they can hide it from view."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Search Engine Spidering"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"300\">", gettext("Allow Search Engine Spidering"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_search_spidering", "Y", gettext("Yes"), (isset($forum_settings['allow_search_spidering']) && $forum_settings['allow_search_spidering'] == "Y")), "&nbsp;", form_radio("allow_search_spidering", "N", gettext("No"), (isset($forum_settings['allow_search_spidering']) && $forum_settings['allow_search_spidering'] == "N") || !isset($forum_settings['allow_search_spidering'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"300\">", gettext("Show Search Engine Bots in Visitor Log"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("searchbots_show_recent", "Y", gettext("Yes"), (isset($forum_settings['searchbots_show_recent']) && $forum_settings['searchbots_show_recent'] == 'Y')), "&nbsp;", form_radio("searchbots_show_recent", "N", gettext("No"), (isset($forum_settings['searchbots_show_recent']) && $forum_settings['searchbots_show_recent'] == 'N') || !isset($forum_settings['searchbots_show_recent'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">", gettext("Show Search Engine Bots in Active Users"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("searchbots_show_active", "Y", gettext("Yes"), (isset($forum_settings['searchbots_show_active']) && $forum_settings['searchbots_show_active'] == 'Y')), "&nbsp;", form_radio("searchbots_show_active", "N", gettext("No"), (isset($forum_settings['searchbots_show_active']) && $forum_settings['searchbots_show_active'] == 'N') || !isset($forum_settings['searchbots_show_active'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("These settings allows your forum to be spidered by search engines like Google, AltaVista and Yahoo. If you switch this option off your forum will not be included in these search engines results."), "</p>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("User and guest access settings"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Allow Guest Access"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_account_enabled", "Y", gettext("Yes"), (isset($forum_settings['guest_account_enabled']) && $forum_settings['guest_account_enabled'] == "Y")), "&nbsp;", form_radio("guest_account_enabled", "N", gettext("No"), (isset($forum_settings['guest_account_enabled']) && $forum_settings['guest_account_enabled'] == "N") || !isset($forum_settings['guest_account_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("List Guests in Visitor Log"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_show_recent", "Y", gettext("Yes"), (isset($forum_settings['guest_show_recent']) && $forum_settings['guest_show_recent'] == 'Y') || !isset($forum_settings['guest_show_recent'])), "&nbsp;", form_radio("guest_show_recent", "N", gettext("No"), (isset($forum_settings['guest_show_recent']) && $forum_settings['guest_show_recent'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("<b>Enable Guest Account</b> allows visitors to browse your forum and read posts without registering a user account. A user account is still required if they wish to post or change user preferences."), "</p>\n";
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
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();