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
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'sitemap.inc.php';
require_once BH_INCLUDE_PATH . 'sphinx.inc.php';
require_once BH_INCLUDE_PATH . 'text_captcha.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_FORUM_TOOLS, 0, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Array to hold error messages
$error_msg_array = array();

// Text captcha class
$text_captcha = new captcha(6, 15, 25, 9, 30);

// Array of valid periods for the unread cutoff
$unread_cutoff_periods = array(
    UNREAD_MESSAGES_DISABLED => gettext("Disable unread messages"),
    THIRTY_DAYS_IN_SECONDS => gettext("30 Days"),
    SIXTY_DAYS_IN_SECONDS => gettext("60 Days"),
    NINETY_DAYS_IN_SECONDS => gettext("90 Days"),
    HUNDRED_EIGHTY_DAYS_IN_SECONDS => gettext("180 Days"),
    YEAR_IN_SECONDS => gettext("1 year")
);

// Array of valid periods for the sitemap frequency
$sitemap_freq_periods = array(
    DAY_IN_SECONDS => gettext("Once a day"),
    WEEK_IN_SECONDS => gettext("Once a Week")
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

$mail_functions_array = array(
    MAIL_FUNCTION_PHP => gettext("Use PHP mail function"),
    MAIL_FUNCTION_SMTP => gettext("Use SMTP Server"),
    MAIL_FUNCTION_SENDMAIL => gettext("Use Sendmail"),
    MAIL_FUNCTION_NONE => gettext("Do not send email"),
);

// Array of valid attachment thumbnail methods.
$attachment_thumbnail_methods = array(
    ATTACHMENT_THUMBNAIL_IMAGEMAGICK => gettext("Use Imagemagick"),
    ATTACHMENT_THUMBNAIL_PHPGD => gettext("Use PHP GD library")
);

// Get the global forum settings
$forum_global_settings = forum_get_global_settings();

// Submit code.
if (isset($_POST['save']) || isset($_POST['confirm_unread_cutoff']) || isset($_POST['cancel_unread_cutoff'])) {

    $valid = true;

    if (isset($_POST['cancel_unread_cutoff'])) unset($_POST['messages_unread_cutoff']);

    if (isset($_POST['forum_name']) && strlen(trim($_POST['forum_name'])) > 0) {
        $new_forum_settings['forum_name'] = trim($_POST['forum_name']);
    } else {
        $error_msg_array[] = gettext("You must supply a forum name");
        $valid = false;
    }

    if (isset($_POST['forum_desc']) && strlen(trim($_POST['forum_desc'])) > 0) {
        $new_forum_settings['forum_desc'] = trim($_POST['forum_desc']);
    } else {
        $new_forum_settings['forum_desc'] = "";
    }

    if (isset($_POST['forum_keywords']) && strlen(trim($_POST['forum_keywords'])) > 0) {
        $new_forum_settings['forum_keywords'] = trim($_POST['forum_keywords']);
    } else {
        $new_forum_settings['forum_keywords'] = "";
    }

    if (isset($_POST['mail_function']) && in_array($_POST['mail_function'], array_keys($mail_functions_array))) {
        $new_forum_settings['mail_function'] = $_POST['mail_function'];
    } else {
        $new_forum_settings['mail_function'] = forum_get_setting('mail_function', 'is_numeric', MAIL_FUNCTION_PHP);
    }

    if (isset($_POST['smtp_server']) && strlen(trim($_POST['smtp_server'])) > 0) {
        $new_forum_settings['smtp_server'] = trim($_POST['smtp_server']);
    } else {
        $new_forum_settings['smtp_server'] = '';
    }

    if (isset($_POST['smtp_port']) && is_numeric($_POST['smtp_port'])) {
        $new_forum_settings['smtp_port'] = $_POST['smtp_port'];
    } else {
        $new_forum_settings['smtp_port'] = '';
    }

    if (isset($_POST['smtp_ssl']) && $_POST['smtp_ssl'] == "Y") {
        $new_forum_settings['smtp_ssl'] = "Y";
    } else {
        $new_forum_settings['smtp_ssl'] = "N";
    }

    if (isset($_POST['smtp_username']) && strlen(trim($_POST['smtp_username'])) > 0) {
        $new_forum_settings['smtp_username'] = trim($_POST['smtp_username']);
    } else {
        $new_forum_settings['smtp_username'] = '';
    }

    if (isset($_POST['smtp_password']) && strlen(trim($_POST['smtp_password'])) > 0) {
        $new_forum_settings['smtp_password'] = trim($_POST['smtp_password']);
    } else {
        $new_forum_settings['smtp_password'] = '';
    }

    if (isset($_POST['sendmail_path']) && strlen(trim($_POST['sendmail_path'])) > 0) {
        $new_forum_settings['sendmail_path'] = trim($_POST['sendmail_path']);
    } else {
        $new_forum_settings['sendmail_path'] = '';
    }

    if (isset($_POST['forum_email']) && strlen(trim($_POST['forum_email'])) > 0) {
        $new_forum_settings['forum_email'] = trim($_POST['forum_email']);
    } else {
        $new_forum_settings['forum_email'] = "admin@beehiveforum.co.uk";
    }

    if (isset($_POST['forum_noreply_email']) && strlen(trim($_POST['forum_noreply_email'])) > 0) {
        $new_forum_settings['forum_noreply_email'] = trim($_POST['forum_noreply_email']);
    } else {
        $new_forum_settings['forum_noreply_email'] = "noreply@beehiveforum.co.uk";
    }

    if (isset($_POST['content_delivery_domains']) && strlen(trim($_POST['content_delivery_domains'])) > 0) {
        $new_forum_settings['content_delivery_domains'] = trim($_POST['content_delivery_domains']);
    } else {
        $new_forum_settings['content_delivery_domains'] = "";
    }

    if (isset($_POST['messages_unread_cutoff']) && in_array($_POST['messages_unread_cutoff'], array_keys($unread_cutoff_periods))) {
        $new_forum_settings['messages_unread_cutoff'] = $_POST['messages_unread_cutoff'];
    } else {
        $new_forum_settings['messages_unread_cutoff'] = forum_get_setting('messages_unread_cutoff', 'is_numeric', YEAR_IN_SECONDS);
    }

    if (isset($_POST['search_limit_count']) && is_numeric($_POST['search_limit_count'])) {
        $new_forum_settings['search_limit_count'] = $_POST['search_limit_count'];
    } else {
        $new_forum_settings['search_limit_count'] = 1;
    }

    if (isset($_POST['search_limit_time']) && is_numeric($_POST['search_limit_time'])) {
        $new_forum_settings['search_limit_time'] = $_POST['search_limit_time'];
    } else {
        $new_forum_settings['search_limit_time'] = 1;
    }

    if (isset($_POST['sphinx_search_enabled']) && $_POST['sphinx_search_enabled'] == "Y") {
        $new_forum_settings['sphinx_search_enabled'] = "Y";
    } else {
        $new_forum_settings['sphinx_search_enabled'] = "N";
    }

    if (isset($_POST['sphinx_search_host']) && strlen(trim($_POST['sphinx_search_host'])) > 0) {
        $new_forum_settings['sphinx_search_host'] = trim($_POST['sphinx_search_host']);
    } else {
        $new_forum_settings['sphinx_search_host'] = "";
    }

    if (isset($_POST['sphinx_search_port']) && is_numeric($_POST['sphinx_search_port'])) {
        $new_forum_settings['sphinx_search_port'] = $_POST['sphinx_search_port'];
    } else {
        $new_forum_settings['sphinx_search_port'] = '';
    }

    if (isset($_POST['allow_new_registrations']) && $_POST['allow_new_registrations'] == "Y") {
        $new_forum_settings['allow_new_registrations'] = "Y";
    } else {
        $new_forum_settings['allow_new_registrations'] = "N";
    }

    if (isset($_POST['require_unique_email']) && $_POST['require_unique_email'] == "Y") {
        $new_forum_settings['require_unique_email'] = "Y";
    } else {
        $new_forum_settings['require_unique_email'] = "N";
    }

    if (isset($_POST['require_email_confirmation']) && $_POST['require_email_confirmation'] == "Y") {
        $new_forum_settings['require_email_confirmation'] = "Y";
    } else {
        $new_forum_settings['require_email_confirmation'] = "N";
    }

    if (isset($_POST['forum_rules_enabled']) && $_POST['forum_rules_enabled'] == "Y") {
        $new_forum_settings['forum_rules_enabled'] = "Y";
    } else {
        $new_forum_settings['forum_rules_enabled'] = "N";
    }

    if (isset($_POST['forum_rules_message']) && strlen(trim($_POST['forum_rules_message'])) > 0) {
        $new_forum_settings['forum_rules_message'] = fix_html(emoticons_strip($_POST['forum_rules_message']), true);
    } else {
        $new_forum_settings['forum_rules_message'] = "";
    }

    if (isset($_POST['enable_google_analytics']) && $_POST['enable_google_analytics'] == "Y") {
        $new_forum_settings['enable_google_analytics'] = "Y";
    } else {
        $new_forum_settings['enable_google_analytics'] = "N";
    }

    if (isset($_POST['allow_forum_google_analytics']) && $_POST['allow_forum_google_analytics'] == "Y") {
        $new_forum_settings['allow_forum_google_analytics'] = "Y";
    } else {
        $new_forum_settings['allow_forum_google_analytics'] = "N";
    }

    if (isset($_POST['google_analytics_code']) && strlen(trim($_POST['google_analytics_code'])) > 0) {
        $new_forum_settings['google_analytics_code'] = trim($_POST['google_analytics_code']);
    } else {
        $new_forum_settings['google_analytics_code'] = "";
    }

    if (isset($_POST['adsense_publisher_id']) && strlen(trim($_POST['adsense_publisher_id'])) > 0) {
        $new_forum_settings['adsense_publisher_id'] = trim($_POST['adsense_publisher_id']);
    } else {
        $new_forum_settings['adsense_publisher_id'] = '';
    }

    if (isset($_POST['adsense_medium_ad_id']) && strlen(trim($_POST['adsense_medium_ad_id'])) > 0) {
        $new_forum_settings['adsense_medium_ad_id'] = trim($_POST['adsense_medium_ad_id']);
    } else {
        $new_forum_settings['adsense_medium_ad_id'] = '';
    }

    if (isset($_POST['adsense_small_ad_id']) && strlen(trim($_POST['adsense_small_ad_id'])) > 0) {
        $new_forum_settings['adsense_small_ad_id'] = trim($_POST['adsense_small_ad_id']);
    } else {
        $new_forum_settings['adsense_small_ad_id'] = '';
    }

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

    if (isset($_POST['adsense_message_number']) && is_numeric($_POST['adsense_message_number'])) {
        $new_forum_settings['adsense_message_number'] = $_POST['adsense_message_number'];
    } else {
        $new_forum_settings['adsense_message_number'] = 1;
    }

    if (isset($_POST['text_captcha_enabled']) && $_POST['text_captcha_enabled'] == "Y") {
        $new_forum_settings['text_captcha_enabled'] = "Y";
    } else {
        $new_forum_settings['text_captcha_enabled'] = "N";
    }

    if (isset($_POST['text_captcha_dir']) && strlen(trim($_POST['text_captcha_dir'])) > 0) {

        $new_forum_settings['text_captcha_dir'] = trim($_POST['text_captcha_dir']);

    } else if (mb_strtoupper($new_forum_settings['text_captcha_enabled']) == "Y") {

        $error_msg_array[] = gettext("You must supply a directory to save text-captcha images in");
        $valid = false;
    }

    if (isset($_POST['new_user_email_notify']) && $_POST['new_user_email_notify'] == "Y") {
        $new_forum_settings['new_user_email_notify'] = "Y";
    } else {
        $new_forum_settings['new_user_email_notify'] = "N";
    }

    if (isset($_POST['new_user_pm_notify_email']) && $_POST['new_user_pm_notify_email'] == "Y") {
        $new_forum_settings['new_user_pm_notify_email'] = "Y";
    } else {
        $new_forum_settings['new_user_pm_notify_email'] = "N";
    }

    if (isset($_POST['new_user_pm_notify']) && $_POST['new_user_pm_notify'] == "Y") {
        $new_forum_settings['new_user_pm_notify'] = "Y";
    } else {
        $new_forum_settings['new_user_pm_notify'] = "N";
    }

    if (isset($_POST['new_user_mark_as_of_int']) && $_POST['new_user_mark_as_of_int'] == "Y") {
        $new_forum_settings['new_user_mark_as_of_int'] = "Y";
    } else {
        $new_forum_settings['new_user_mark_as_of_int'] = "N";
    }

    if (isset($_POST['show_pms']) && $_POST['show_pms'] == "Y") {
        $new_forum_settings['show_pms'] = "Y";
    } else {
        $new_forum_settings['show_pms'] = "N";
    }

    if (isset($_POST['pm_max_user_messages']) && is_numeric($_POST['pm_max_user_messages'])) {
        $new_forum_settings['pm_max_user_messages'] = $_POST['pm_max_user_messages'];
    } else {
        $new_forum_settings['pm_max_user_messages'] = 100;
    }

    if (isset($_POST['pm_auto_prune_enabled']) && $_POST['pm_auto_prune_enabled'] == "Y") {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $new_forum_settings['pm_auto_prune'] = $_POST['pm_auto_prune'];

        } else {

            $new_forum_settings['pm_auto_prune'] = "-60";
        }

    } else {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $new_forum_settings['pm_auto_prune'] = $_POST['pm_auto_prune'] * -1;

        } else {

            $new_forum_settings['pm_auto_prune'] = "-60";
        }
    }

    if (isset($_POST['pm_allow_attachments']) && $_POST['pm_allow_attachments'] == "Y") {
        $new_forum_settings['pm_allow_attachments'] = "Y";
    } else {
        $new_forum_settings['pm_allow_attachments'] = "N";
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

    if (isset($_POST['sitemap_enabled']) && $_POST['sitemap_enabled'] == "Y") {
        $new_forum_settings['sitemap_enabled'] = "Y";
    } else {
        $new_forum_settings['sitemap_enabled'] = "N";
    }

    if (isset($_POST['sitemap_freq']) && in_array($_POST['sitemap_freq'], array_keys($sitemap_freq_periods))) {
        $new_forum_settings['sitemap_freq'] = $_POST['sitemap_freq'];
    } else {
        $new_forum_settings['sitemap_freq'] = DAY_IN_SECONDS;
    }

    if (isset($_POST['allow_username_changes']) && $_POST['allow_username_changes'] == "Y") {
        $new_forum_settings['allow_username_changes'] = "Y";
    } else {
        $new_forum_settings['allow_username_changes'] = "N";
    }

    if (isset($_POST['require_user_approval']) && $_POST['require_user_approval'] == "Y") {
        $new_forum_settings['require_user_approval'] = "Y";
    } else {
        $new_forum_settings['require_user_approval'] = "N";
    }

    if (isset($_POST['send_new_user_email']) && $_POST['send_new_user_email'] == "Y") {
        $new_forum_settings['send_new_user_email'] = "Y";
    } else {
        $new_forum_settings['send_new_user_email'] = "N";
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

    if (isset($_POST['attachments_enabled']) && $_POST['attachments_enabled'] == "Y") {
        $new_forum_settings['attachments_enabled'] = "Y";
    } else {
        $new_forum_settings['attachments_enabled'] = "N";
    }

    if (isset($_POST['attachment_thumbnails']) && $_POST['attachment_thumbnails'] == "Y") {
        $new_forum_settings['attachment_thumbnails'] = "Y";
    } else {
        $new_forum_settings['attachment_thumbnails'] = "N";
    }

    if (isset($_POST['attachment_dir']) && strlen(trim($_POST['attachment_dir'])) > 0) {

        $new_forum_settings['attachment_dir'] = trim($_POST['attachment_dir']);

    } else if (mb_strtoupper($new_forum_settings['attachments_enabled']) == "Y") {

        $error_msg_array[] = gettext("You must supply a directory to save attachments in");
        $valid = false;
    }

    if (isset($_POST['attachment_mime_types']) && strlen(trim($_POST['attachment_mime_types'])) > 0) {
        $new_forum_settings['attachment_mime_types'] = trim($_POST['attachment_mime_types']);
    } else {
        $new_forum_settings['attachment_mime_types'] = "";
    }

    if (isset($_POST['attachment_thumbnail_method']) && in_array($_POST['attachment_thumbnail_method'], array_keys($attachment_thumbnail_methods))) {
        $new_forum_settings['attachment_thumbnail_method'] = trim($_POST['attachment_thumbnail_method']);
    } else {
        $new_forum_settings['attachment_thumbnail_method'] = ATTACHMENT_THUMBNAIL_PHPGD;
    }

    if (isset($_POST['attachment_imagemagick_path']) && strlen(trim($_POST['attachment_imagemagick_path'])) > 0) {
        $new_forum_settings['attachment_imagemagick_path'] = trim($_POST['attachment_imagemagick_path']);
    } else {
        $new_forum_settings['attachment_imagemagick_path'] = "";
    }

    if (isset($_POST['attachments_max_user_space']) && is_numeric($_POST['attachments_max_user_space'])) {
        $new_forum_settings['attachments_max_user_space'] = ($_POST['attachments_max_user_space'] * 1024) * 1024;
    } else {
        $new_forum_settings['attachments_max_user_space'] = 1048576; // 1MB in bytes
    }

    if (isset($_POST['attachments_max_post_space']) && is_numeric($_POST['attachments_max_post_space'])) {
        $new_forum_settings['attachments_max_post_space'] = ($_POST['attachments_max_post_space'] * 1024) * 1024;
    } else {
        $new_forum_settings['attachments_max_post_space'] = 1048576; // 1MB in bytes
    }

    if (isset($_POST['attachment_size_limit']) && is_numeric($_POST['attachment_size_limit'])) {
        $new_forum_settings['attachment_size_limit'] = ($_POST['attachment_size_limit'] * 1024) * 1024;
    } else {
        $new_forum_settings['attachment_size_limit'] = "";
    }

    if (isset($_POST['attachments_allow_embed']) && $_POST['attachments_allow_embed'] == "Y") {
        $new_forum_settings['attachments_allow_embed'] = "Y";
    } else {
        $new_forum_settings['attachments_allow_embed'] = "N";
    }

    if (isset($_POST['attachment_allow_guests']) && $_POST['attachment_allow_guests'] == "Y") {
        $new_forum_settings['attachment_allow_guests'] = "Y";
    } else {
        $new_forum_settings['attachment_allow_guests'] = "N";
    }

    if ($valid) {

        $unread_cutoff_stamp = $new_forum_settings['messages_unread_cutoff'];

        $previous_unread_cutoff_stamp = forum_get_unread_cutoff();

        if (!isset($_POST['confirm_unread_cutoff'])) {

            if (($unread_cutoff_stamp > 0) && ($previous_unread_cutoff_stamp !== false) && ($unread_cutoff_stamp != $previous_unread_cutoff_stamp)) {

                html_draw_top(
                    array(
                        'title' => gettext("Admin - Global Forum Settings"),
                        'class' => 'window_title',
                        'main_css' => 'admin.css'
                    )
                );

                echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Global Forum Settings"), "</h1>\n";
                echo "<br />\n";
                echo "<div align=\"center\">\n";
                echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_default_forum_settings.php\" method=\"post\" target=\"_self\">\n";
                echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
                echo "  ", form_input_hidden_array($_POST), "\n";
                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
                echo "    <tr>\n";
                echo "      <td align=\"left\">\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("WARNING"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";

                if ($unread_cutoff_stamp > $previous_unread_cutoff_stamp) {

                    echo "                      <tr>\n";
                    echo "                        <td>", gettext("Increasing the unread cut-off will make threads marked as modified since and threads older than the previous cut-off appear as unread to all users"), "</td>\n";
                    echo "                      </tr>\n";
                    echo "                      <tr>\n";
                    echo "                        <td>&nbsp;</td>\n";
                    echo "                      </tr>\n";
                }

                echo "                      <tr>\n";
                echo "                        <td>", gettext("Depending on server performance and the number of threads your forums contain, changing the unread cut-off may take several minutes to complete. For this reason it is recommended that you avoid changing this setting while your forums are busy."), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td>&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td>", gettext("Are you sure you want to change the unread cut-off?"), "</td>\n";
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
                echo "      <td align=\"center\">", form_submit("confirm_unread_cutoff", gettext("Yes")), "&nbsp;", form_submit("cancel_unread_cutoff", gettext("No")), "</td>\n";
                echo "    </tr>\n";
                echo "  </table>\n";
                echo "</form>\n";
                echo "</div>\n";

                html_display_warning_msg(gettext("Clicking 'No' will only cancel the unread cut-off changes. Other changes you've made will still be saved."), '700', 'center');

                html_draw_bottom();
                exit;
            }
        }

        if (forum_save_global_settings($new_forum_settings)) {

            if (isset($_POST['confirm_unread_cutoff'])) forum_update_unread_data($unread_cutoff_stamp);

            header_redirect("admin_default_forum_settings.php?webtag=$webtag&updated=true", gettext("Forum settings successfully updated"));

        } else {

            $valid = false;
            $error_msg_array[] = gettext("Failed to update forum settings. Please try again later.");
        }
    }

    $forum_global_settings = array_merge($forum_global_settings, $new_forum_settings);
}

html_draw_top(
    array(
        'title' => gettext('Admin - Global Forum Settings'),
        'class' => 'window_title',
        'js' => array(
            'js/admin.js',
            'js/emoticons.js',
            'ckeditor/ckeditor.js'
        ),
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Global Forum Settings"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'center');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '700', 'center');

} else {

    html_display_warning_msg(gettext("<b>Note:</b> These settings affect all forums. Where the setting is duplicated on the individual Forum's settings page that will take precedence over the settings you change here."), '700', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"prefsform\" action=\"admin_default_forum_settings.php\" method=\"post\" target=\"_self\">\n";
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
echo "                        <td align=\"left\">", form_input_text("forum_name", (isset($forum_global_settings['forum_name']) ? htmlentities_array($forum_global_settings['forum_name']) : 'A Beehive Forum'), 52, 255), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Description"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_desc", (isset($forum_global_settings['forum_desc']) ? htmlentities_array($forum_global_settings['forum_desc']) : ''), 52, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Keywords"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_keywords", (isset($forum_global_settings['forum_keywords']) ? htmlentities_array($forum_global_settings['forum_keywords']) : ''), 52, 80), "&nbsp;</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Email and contact settings"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Mail function"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("mail_function", htmlentities_array($mail_functions_array), (isset($forum_global_settings['mail_function']) ? htmlentities_array($forum_global_settings['mail_function']) : 0)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\" id=\"smtp_settings\" style=\"display: ", (isset($forum_global_settings['mail_function']) && $forum_global_settings['mail_function'] == MAIL_FUNCTION_SMTP) ? 'block' : 'none', "\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("SMTP Server Address"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("smtp_server", (isset($forum_global_settings['smtp_server']) ? htmlentities_array($forum_global_settings['smtp_server']) : 'localhost'), 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("SMTP Server Port"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("smtp_port", (isset($forum_global_settings['smtp_port']) ? htmlentities_array($forum_global_settings['smtp_port']) : '25'), 7, 5), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("SMTP Server Username"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("smtp_username", (isset($forum_global_settings['smtp_username']) ? htmlentities_array($forum_global_settings['smtp_username']) : ''), 25, null, 'autocomplete="off"'), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("SMTP Server Password"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_password("smtp_password", (isset($forum_global_settings['smtp_password']) ? htmlentities_array($forum_global_settings['smtp_password']) : ''), 25, null, 'autocomplete="off"'), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("SMTP use SSL"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("smtp_ssl", "Y", gettext("Yes"), (isset($forum_global_settings['smtp_ssl']) && $forum_global_settings['smtp_ssl'] == 'Y')), "&nbsp;", form_radio("smtp_ssl", "N", gettext("No"), (isset($forum_global_settings['smtp_ssl']) && $forum_global_settings['smtp_ssl'] == 'N') || !isset($forum_global_settings['smtp_ssl'])), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\" id=\"sendmail_settings\" style=\"display: ", isset($forum_global_settings['mail_function']) && ($forum_global_settings['mail_function'] == MAIL_FUNCTION_SENDMAIL) ? 'block' : 'none', "\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Sendmail path"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("sendmail_path", (isset($forum_global_settings['sendmail_path']) ? htmlentities_array($forum_global_settings['sendmail_path']) : ''), 52), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Forum Email"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_email", (isset($forum_global_settings['forum_email']) ? htmlentities_array($forum_global_settings['forum_email']) : 'admin@beehiveforum.co.uk'), 52, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("No-Reply Email"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("forum_noreply_email", (isset($forum_global_settings['forum_noreply_email']) ? htmlentities_array($forum_global_settings['forum_noreply_email']) : 'noreply@beehiveforum.co.uk'), 52, 80), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"2\">\n";
echo "                          <p>", gettext("Select the <b>Mail function</b> suitable for your server. By default your Beehive Forum will use PHP's built-in mail function. If this doesn't work or you prefer to use another method to send emails from your server you can select it here."), "</p>\n";
echo "                          <p>", gettext("<b>Important:</b> If you are unsure what settings to use for sending email please consult your hosting provider's documentation."), "</p>\n";
echo "                          <p>", gettext("Use <b>No-Reply Email</b> to specify an email address that does not exist or will not be monitored for replies. This email address will be used in the headers for all emails sent from your forum including but not limited to Post and PM notifications, user emails and password reminders."), "</p>\n";
echo "                          <p>", gettext("It is recommended that you use an email address that does not exist to help cut down on spam that may be directed at your main forum email address"), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Content Delivery"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" width=\"270\">", gettext("Content Delivery Network Paths"), ":</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_textarea("content_delivery_domains", (isset($forum_global_settings['content_delivery_domains'])) ? htmlentities_array($forum_global_settings['content_delivery_domains']) : "", 6, 82, null, 'admin_tools_textarea'), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <p>", gettext("A <b>Content Delivery Network</b> or CDN can be used to help speed up page load of your forum by off-loading some of page content such as images, CSS and JavaScript to other servers."), "</p>\n";
echo "                          <p>", gettext("You should enter any CDN paths in the text box above, one per line. Your Beehive Forum will automatically prefix every static content request with each of the CDN paths in turn."), "</p>\n";
echo "                          <p>", gettext("Please Note: Your CDN paths should be to the root of the Beehive Forum content. For example, if you enter <i>cdn01.beehiveforum.co.uk</i>, requests for the user's CSS styles will be made to <i>cdn01.beehiveforum.co.uk/styles/[user_style]/style.css</i>"), "</p>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "                        <td align=\"left\" width=\"270\">", gettext("Unread messages cut-off"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("messages_unread_cutoff", $unread_cutoff_periods, (isset($forum_global_settings['messages_unread_cutoff']) && in_array($forum_global_settings['messages_unread_cutoff'], array_keys($unread_cutoff_periods))) ? $forum_global_settings['messages_unread_cutoff'] : YEAR_IN_SECONDS), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("<b>Unread messages cut-off</b> specifies how long messages remain unread. Threads modified no later than the period selected will automatically appear as read."), "</p>\n";
echo "                          <p>", gettext("Choosing <b>Disable unread messages</b> will completely remove unread messages support and remove the relevant options from the discussion type drop down on the thread list."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Search Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">", gettext("Limit Searches to"), ":</td>\n";
echo "                        <td align=\"left\">", sprintf(gettext("%s search(es) every %s seconds"), form_input_text("search_limit_count", (isset($forum_global_settings['search_limit_count'])) ? htmlentities_array($forum_global_settings['search_limit_count']) : 1, 4, 3), form_input_text("search_limit_time", (isset($forum_global_settings['search_limit_time'])) ? htmlentities_array($forum_global_settings['search_limit_time']) : 30, 4, 3)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("This setting defines how long a user must wait before performing another search. Searches can place a high demand on the database, so it is recommended that you set this to 1 search every 30 seconds to prevent \"search spamming\" having negative effect on your server."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Sphinx Search Integration"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";

if (isset($forum_global_settings['sphinx_search_enabled']) && $forum_global_settings['sphinx_search_enabled'] == "Y") {

    if (!sphinx_search_connect()) {

        html_display_error_msg(gettext("Cannot connect to a Sphinx Search server using the settings you have specified."), '95%', 'center');
    }
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">", gettext("Enable Sphinx Search integration"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("sphinx_search_enabled", "Y", gettext("Yes"), (isset($forum_global_settings['sphinx_search_enabled']) && $forum_global_settings['sphinx_search_enabled'] == 'Y')), "&nbsp;", form_radio("sphinx_search_enabled", "N", gettext("No"), (isset($forum_global_settings['sphinx_search_enabled']) && $forum_global_settings['sphinx_search_enabled'] == 'N') || !isset($forum_global_settings['sphinx_search_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Sphinx Search Hostname"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("sphinx_search_host", (isset($forum_global_settings['sphinx_search_host'])) ? htmlentities_array($forum_global_settings['sphinx_search_host']) : '', 35), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Sphinx Search Port"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("sphinx_search_port", (isset($forum_global_settings['sphinx_search_port'])) ? htmlentities_array($forum_global_settings['sphinx_search_port']) : '', 5), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("These settings allow you to integrate Sphinx Search into your Beehive Forum. Sphinx Search provides an alternative to MySQL's full-text searching and can help provide better search results and can help reduce server load. Spinx Search must be installed on your server and configured before it will work with your Beehive Forum. For instructions please see the Beehive Forum docs."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("New User Registrations"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">", gettext("Allow new user registrations"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_new_registrations", "Y", gettext("Yes"), (isset($forum_global_settings['allow_new_registrations']) && $forum_global_settings['allow_new_registrations'] == 'Y') || !isset($forum_global_settings['allow_new_registrations'])), "&nbsp;", form_radio("allow_new_registrations", "N", gettext("No"), (isset($forum_global_settings['allow_new_registrations']) && $forum_global_settings['allow_new_registrations'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">", gettext("Prevent duplicate email addresses"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("require_unique_email", "Y", gettext("Yes"), (isset($forum_global_settings['require_unique_email']) && $forum_global_settings['require_unique_email'] == 'Y')), "&nbsp;", form_radio("require_unique_email", "N", gettext("No"), (isset($forum_global_settings['require_unique_email']) && $forum_global_settings['require_unique_email'] == 'N') || !isset($forum_global_settings['require_unique_email'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">", gettext("Require email confirmation"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("require_email_confirmation", "Y", gettext("Yes"), (isset($forum_global_settings['require_email_confirmation']) && $forum_global_settings['require_email_confirmation'] == 'Y')), "&nbsp;", form_radio("require_email_confirmation", "N", gettext("No"), (isset($forum_global_settings['require_email_confirmation']) && $forum_global_settings['require_email_confirmation'] == 'N') || !isset($forum_global_settings['require_email_confirmation'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Require user to agree to forum rules"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("forum_rules_enabled", "Y", gettext("Yes"), ((isset($forum_global_settings['forum_rules_enabled']) && $forum_global_settings['forum_rules_enabled'] == 'Y') || !isset($forum_global_settings['forum_rules_enabled']))), "&nbsp;", form_radio("forum_rules_enabled", "N", gettext("No"), (isset($forum_global_settings['forum_rules_enabled']) && $forum_global_settings['forum_rules_enabled'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Require user approval by admin"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("require_user_approval", "Y", gettext("Yes"), (isset($forum_global_settings['require_user_approval']) && $forum_global_settings['require_user_approval'] == "Y")), "&nbsp;", form_radio("require_user_approval", "N", gettext("No"), (isset($forum_global_settings['require_user_approval']) && $forum_global_settings['require_user_approval'] == "N") || !isset($forum_global_settings['require_user_approval'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Send notification to global forum owner"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("send_new_user_email", "Y", gettext("Yes"), (isset($forum_global_settings['send_new_user_email']) && $forum_global_settings['send_new_user_email'] == 'Y')), "&nbsp;", form_radio("send_new_user_email", "N", gettext("No"), (isset($forum_global_settings['send_new_user_email']) && ($forum_global_settings['send_new_user_email'] == 'N') || !isset($forum_global_settings['send_new_user_email']))), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("<b>Allow new user registrations</b> allows or disallows the creation of new user accounts. Setting the option to no completely disables the registration form."), "</p>\n";
echo "                          <p>", gettext("<b>Prevent use of duplicate email addresses</b> forces Beehive to check the user accounts against the email address the user is registering with and prompts them to use another if it is already in use."), "</p>\n";
echo "                          <p>", gettext("<b>Require email confirmation</b> when enabled will send an email to each new user with a link that can be used to confirm their email address. Until they confirm their email address they will not be able to post unless their user permissions are changed manually by an admin."), "</p>\n";
echo "                          <p>", gettext("<b>Require user approval by admin</b> allows you to restrict access by new users until they have been approved by a moderator or admin. Without approval a user cannot access any area of the Beehive Forum installation including individual forums, PM inbox and My Forums sections."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Text-captcha"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\">", gettext("Use text-captcha"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("text_captcha_enabled", "Y", gettext("Yes"), (isset($forum_global_settings['text_captcha_enabled']) && $forum_global_settings['text_captcha_enabled'] == 'Y')), "&nbsp;", form_radio("text_captcha_enabled", "N", gettext("No"), (isset($forum_global_settings['text_captcha_enabled']) && $forum_global_settings['text_captcha_enabled'] == 'N') || !isset($forum_global_settings['text_captcha_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Text-captcha Dir"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("text_captcha_dir", (isset($forum_global_settings['text_captcha_dir'])) ? htmlentities_array($forum_global_settings['text_captcha_dir']) : "text_captcha", 35, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";

if (isset($forum_global_settings['text_captcha_enabled']) && $forum_global_settings['text_captcha_enabled'] == "Y") {

    if (!$text_captcha->generate_keys() || !$text_captcha->make_image()) {

        if (($errno = $text_captcha->get_error()) !== false) {

            switch ($errno) {

                case TEXT_CAPTCHA_NO_FONTS:

                    html_display_error_msg(gettext("Text-captcha has been disabled automatically because there are no true type fonts available for it to use. Please upload some true type fonts to <b>text_captcha/fonts</b> on your server."), '95%', 'center');
                    break;

                case TEXT_CAPTCHA_GD_ERROR:

                    html_display_error_msg(gettext("Text-captcha has been disabled because your server's PHP setup does not provide support for GD Image manipulation and / or TTF font support. Both are required for text-captcha support."), '95%', 'center');
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
echo "                          <p>", gettext("<b>Use text-captcha</b> presents the new user with a mangled image which they must copy a number from into a text field on the registration form. Use this option to prevent automated sign-up via scripts."), "</p>\n";
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
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Google Analytics"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Enable Google Analytics"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("enable_google_analytics", "Y", gettext("Yes"), (isset($forum_global_settings['enable_google_analytics']) && $forum_global_settings['enable_google_analytics'] == "Y")), "&nbsp;", form_radio("enable_google_analytics", "N", gettext("No"), (isset($forum_global_settings['enable_google_analytics']) && $forum_global_settings['enable_google_analytics'] == "N") || !isset($forum_global_settings['enable_google_analytics'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Allow Google Analytics on each forum"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_forum_google_analytics", "Y", gettext("Yes"), (isset($forum_global_settings['allow_forum_google_analytics']) && $forum_global_settings['allow_forum_google_analytics'] == "Y")), "&nbsp;", form_radio("allow_forum_google_analytics", "N", gettext("No"), (isset($forum_global_settings['allow_forum_google_analytics']) && $forum_global_settings['allow_forum_google_analytics'] == "N") || !isset($forum_global_settings['allow_forum_google_analytics'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Google Analytics Account ID"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("google_analytics_code", (isset($forum_global_settings['google_analytics_code']) ? htmlentities_array($forum_global_settings['google_analytics_code']) : ''), 31, 20), "&nbsp;</td>\n";
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
echo "                        <td align=\"left\" width=\"255\" style=\"white-space: nowrap\">", gettext("AdSense publisher id"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("adsense_publisher_id", (isset($forum_global_settings['adsense_publisher_id']) ? htmlentities_array($forum_global_settings['adsense_publisher_id']) : ''), 25, 40), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Medium sized (468x60) ad slot id"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("adsense_medium_ad_id", (isset($forum_global_settings['adsense_medium_ad_id']) ? htmlentities_array($forum_global_settings['adsense_medium_ad_id']) : ''), 25, 40), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Small sized (234x60) ad slot id"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("adsense_small_ad_id", (isset($forum_global_settings['adsense_small_ad_id']) ? htmlentities_array($forum_global_settings['adsense_small_ad_id']) : ''), 25, 40), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Display AdSense Ads for"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('adsense_display_users', $adsense_user_type_array, (isset($forum_global_settings['adsense_display_users']) && in_array($forum_global_settings['adsense_display_users'], array_keys($adsense_user_type_array)) ? $forum_global_settings['adsense_display_users'] : ADSENSE_DISPLAY_NONE)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Display AdSense Ads on"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('adsense_display_pages', $adsense_page_type_array, (isset($forum_global_settings['adsense_display_pages']) && in_array($forum_global_settings['adsense_display_pages'], array_keys($adsense_page_type_array)) ? $forum_global_settings['adsense_display_pages'] : ADSENSE_DISPLAY_TOP_OF_ALL_PAGES)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Display AdSense Ads after post"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text('adsense_message_number', (isset($forum_global_settings['adsense_message_number']) && is_numeric($forum_global_settings['adsense_message_number']) ? $forum_global_settings['adsense_message_number'] : 1), 15, 40), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("Your Beehive Forum supports 2 different sizes of <b>Google AdSense</b> adverts. Enter the slot ids of the relevant sized ads into the boxes above and Beehive will automatically choose the correct ad for each page."), "</p>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\" colspan=\"2\">\n";

html_display_warning_msg(gettext("If you do not have a Google AdSense Account you will need to sign up for one by clicking <a href=\"https://www.google.com/adsense/\" target=\"_blank\">here</a>."), '95%', 'center');
html_display_warning_msg(gettext("If you wish to enable or disable Google AdSense ads on a particular forum you can do so by visiting that forum's Forum Settings page."), '95%', 'center');

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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("New User Preferences"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Email notification on reply to user"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_email_notify", "Y", gettext("Yes"), (isset($forum_global_settings['new_user_email_notify']) && $forum_global_settings['new_user_email_notify'] == 'Y') || !isset($forum_global_settings['new_user_email_notify'])), "&nbsp;", form_radio("new_user_email_notify", "N", gettext("No"), (isset($forum_global_settings['new_user_email_notify']) && $forum_global_settings['new_user_email_notify'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Email notification on PM to user"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_pm_notify_email", "Y", gettext("Yes"), (isset($forum_global_settings['new_user_pm_notify_email']) && $forum_global_settings['new_user_pm_notify_email'] == 'Y') || !isset($forum_global_settings['new_user_pm_notify_email'])), "&nbsp;", form_radio("new_user_pm_notify_email", "N", gettext("No"), (isset($forum_global_settings['new_user_pm_notify_email']) && $forum_global_settings['new_user_pm_notify_email'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Show popup when receiving new PM"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_pm_notify", "Y", gettext("Yes"), (isset($forum_global_settings['new_user_pm_notify']) && $forum_global_settings['new_user_pm_notify'] == 'Y') || !isset($forum_global_settings['new_user_pm_notify'])), "&nbsp;", form_radio("new_user_pm_notify", "N", gettext("No"), (isset($forum_global_settings['new_user_pm_notify']) && $forum_global_settings['new_user_pm_notify'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Set automatic high interest on post"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("new_user_mark_as_of_int", "Y", gettext("Yes"), (isset($forum_global_settings['new_user_mark_as_of_int']) && $forum_global_settings['new_user_mark_as_of_int'] == 'Y') || !isset($forum_global_settings['new_user_mark_as_of_int'])), "&nbsp;", form_radio("new_user_mark_as_of_int", "N", gettext("No"), (isset($forum_global_settings['new_user_mark_as_of_int']) && $forum_global_settings['new_user_mark_as_of_int'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">\n";
echo "                          <p>", gettext("The above options change the default values for the user registration form. Where applicable other settings will use the forum's own default settings."), "</p>\n";
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

$forum_name = forum_get_setting('forum_name', 'strlen', 'A Beehive Forum');

$frame_top_target = html_get_top_frame_name();

$default_forum_rules = sprintf(gettext("<p><b>Forum Rules</b></p><p>Registration to %1\$s is free! We do insist that you abide by the rules and policies detailed below. If you agree to the terms, please check the 'I agree' checkbox and press the 'Register' button below. If you would like to cancel the registration, click <a href=\"index.php?webtag=%2\$s\" target=\"%3\$s\">here</a> to return to the forums index.</p><p>Although the administrators and moderators of %1\$s will attempt to keep all objectionable messages off this forum, it is impossible for us to review all messages. All messages express the views of the author, and neither the owners of %1\$s, nor Project Beehive Forum and its affiliates will be held responsible for the content of any message.</p><p>By agreeing to these rules, you warrant that you will not post any messages that are obscene, vulgar, sexually-orientated, hateful, threatening, or otherwise in violation of any laws.</p><p>The owners of %1\$s reserve the right to remove, edit, move or close any thread for any reason.</p>"), $forum_name, $webtag, $frame_top_target);

if (!isset($forum_global_settings['forum_rules_message'])) $forum_global_settings['forum_rules_message'] = $default_forum_rules;

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Forum Rules"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_textarea("forum_rules_message", htmlentities_array($forum_global_settings['forum_rules_message']), 10, 72, null, 'admin_tools_textarea editor'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("Use <b>Forum Rules</b> to enter an Acceptable Use Policy that each user must agree to before registering on your forum."), "</p>\n";
echo "                          <p>", gettext("You can use HTML in your forum rules. Hyperlinks and email addresses will also be automatically converted to links. To use the default Beehive Forum AUP clear the field."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Personal Messages"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Enable Personal Messages"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("show_pms", "Y", gettext("Yes"), ((isset($forum_global_settings['show_pms']) && $forum_global_settings['show_pms'] == 'Y'))), "&nbsp;", form_radio("show_pms", "N", gettext("No"), (isset($forum_global_settings['show_pms']) && $forum_global_settings['show_pms'] == 'N') || !isset($forum_global_settings['show_pms'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">", gettext("Auto prune user's PM folders every"), " ", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($forum_global_settings['pm_auto_prune']) ? ($forum_global_settings['pm_auto_prune'] > 0 ? $forum_global_settings['pm_auto_prune'] : $forum_global_settings['pm_auto_prune'] * -1) : 4)), " ", gettext("days"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("pm_auto_prune_enabled", "Y", gettext("Yes"), (isset($forum_global_settings['pm_auto_prune']) && $forum_global_settings['pm_auto_prune'] > 0)), "&nbsp;", form_radio("pm_auto_prune_enabled", "N", gettext("No"), ((isset($forum_global_settings['pm_auto_prune']) && $forum_global_settings['pm_auto_prune'] < 0)) || !isset($forum_global_settings['pm_auto_prune'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Allow Personal Messages to have attachments"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("pm_allow_attachments", "Y", gettext("Yes"), (isset($forum_global_settings['pm_allow_attachments']) && $forum_global_settings['pm_allow_attachments'] == 'Y')), "&nbsp;", form_radio("pm_allow_attachments", "N", gettext("No"), ((isset($forum_global_settings['pm_allow_attachments']) && $forum_global_settings['pm_allow_attachments'] == 'N')) || !isset($forum_global_settings['pm_allow_attachments'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("PM messages per user"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("pm_max_user_messages", (isset($forum_global_settings['pm_max_user_messages'])) ? htmlentities_array($forum_global_settings['pm_max_user_messages']) : "100", 10, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"3\">\n";
echo "                          <p>", gettext("Personal Messages are invaluable as a way of taking more private matters out of view of the other members. However if you don't want your users to be able to send each other personal messages you can disable this option."), "</p>\n";
echo "                          <p>", gettext("Personal Messages can also contain attachments which can be useful for exchanging files between users."), "</p>\n";
echo "                          <p>", gettext("<b>Note:</b> The space allocation for PM attachments is taken from each users' main attachment allocation and is not in addition to."), "</p>\n";
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
echo "                        <td align=\"left\" width=\"350\">", gettext("Allow Search Engine Spidering"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_search_spidering", "Y", gettext("Yes"), (isset($forum_global_settings['allow_search_spidering']) && $forum_global_settings['allow_search_spidering'] == 'Y')), "&nbsp;", form_radio("allow_search_spidering", "N", gettext("No"), (isset($forum_global_settings['allow_search_spidering']) && $forum_global_settings['allow_search_spidering'] == 'N') || !isset($forum_global_settings['allow_search_spidering'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">", gettext("Show Search Engine Bots in Visitor Log"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("searchbots_show_recent", "Y", gettext("Yes"), (isset($forum_global_settings['searchbots_show_recent']) && $forum_global_settings['searchbots_show_recent'] == 'Y')), "&nbsp;", form_radio("searchbots_show_recent", "N", gettext("No"), (isset($forum_global_settings['searchbots_show_recent']) && $forum_global_settings['searchbots_show_recent'] == 'N') || !isset($forum_global_settings['searchbots_show_recent'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">", gettext("Show Search Engine Bots in Active Users"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("searchbots_show_active", "Y", gettext("Yes"), (isset($forum_global_settings['searchbots_show_active']) && $forum_global_settings['searchbots_show_active'] == 'Y')), "&nbsp;", form_radio("searchbots_show_active", "N", gettext("No"), (isset($forum_global_settings['searchbots_show_active']) && $forum_global_settings['searchbots_show_active'] == 'N') || !isset($forum_global_settings['searchbots_show_active'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">", gettext("Enable Sitemap"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("sitemap_enabled", "Y", gettext("Yes"), (isset($forum_global_settings['sitemap_enabled']) && $forum_global_settings['sitemap_enabled'] == 'Y')), "&nbsp;", form_radio("sitemap_enabled", "N", gettext("No"), (isset($forum_global_settings['sitemap_enabled']) && $forum_global_settings['sitemap_enabled'] == 'N') || !isset($forum_global_settings['sitemap_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"350\">", gettext("Sitemap Update Frequency"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("sitemap_freq", $sitemap_freq_periods, (isset($forum_global_settings['sitemap_freq']) && in_array($forum_global_settings['sitemap_freq'], array_keys($sitemap_freq_periods))) ? $forum_global_settings['sitemap_freq'] : DAY_IN_SECONDS), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("These settings allows your forum to be spidered by search engines like Google, AltaVista and Yahoo. If you switch this option off your forum will not be included in these search engines results."), "</p>\n";
echo "                          <p>", gettext("In addition to simple spidering, Beehive can also generate a sitemap for the forum to make it easier for search engines to find and index the messages posted by your users."), "</p>\n";

if (isset($forum_global_settings['sitemap_enabled']) && $forum_global_settings['sitemap_enabled'] == "Y") {

    if (!sitemap_get_dir()) {

        html_display_error_msg(gettext("Sitemap directory must be writable by the web server / PHP process!"), '95%', 'center');

    }
}

echo "                          <p>", gettext("Sitemaps are automatically saved to the sitemaps sub-directory of your Beehive Forum installation. If this directory doesn't exist you must create it and ensure that it is writable by the server / PHP process. To allow search engines to find your sitemap you must add the URL to your robots.txt."), "</p>\n";
echo "                          <p>", gettext("Depending on server performance and the number of forums and threads your Beehive installation contains, generating a sitemap may take several minutes to complete. If performance of your server is adversely affected it is recommend you disable generation of the sitemap."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("User and Guest Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"220\">", gettext("Allow users to change username"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("allow_username_changes", "Y", gettext("Yes"), (isset($forum_global_settings['allow_username_changes']) && $forum_global_settings['allow_username_changes'] == "Y")), "&nbsp;", form_radio("allow_username_changes", "N", gettext("No"), (isset($forum_global_settings['allow_username_changes']) && $forum_global_settings['allow_username_changes'] == "N") || !isset($forum_global_settings['allow_username_changes'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Enable Guest Account"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_account_enabled", "Y", gettext("Yes"), (isset($forum_global_settings['guest_account_enabled']) && $forum_global_settings['guest_account_enabled'] == 'Y') || !isset($forum_global_settings['guest_account_enabled'])), "&nbsp;", form_radio("guest_account_enabled", "N", gettext("No"), (isset($forum_global_settings['guest_account_enabled']) && $forum_global_settings['guest_account_enabled'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("List Guests in Visitor Log"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("guest_show_recent", "Y", gettext("Yes"), (isset($forum_global_settings['guest_show_recent']) && $forum_global_settings['guest_show_recent'] == 'Y') || !isset($forum_global_settings['guest_show_recent'])), "&nbsp;", form_radio("guest_show_recent", "N", gettext("No"), (isset($forum_global_settings['guest_show_recent']) && $forum_global_settings['guest_show_recent'] == 'N')), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("<b>Allow users to change username</b> permits already registered users to change their username. When enabled you can track the changes a user makes to their username via the admin user tools."), "</p>\n";
echo "                          <p>", gettext("<b>Enable Guest Account</b> allows visitors to browse your forum and read posts without registering a user account. A user account is still required if they wish to post or change user preferences."), "</p>\n";
echo "                          <p>", gettext("<b>List Guests in Visitor Log</b> allows you to specify whether or not unregistered users are listed on the Visitor Log alongside registered users."), "</p>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Attachments"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Enable Attachments"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("attachments_enabled", "Y", gettext("Yes"), (isset($forum_global_settings['attachments_enabled']) && $forum_global_settings['attachments_enabled'] == 'Y')), "&nbsp;", form_radio("attachments_enabled", "N", gettext("No"), (isset($forum_global_settings['attachments_enabled']) && $forum_global_settings['attachments_enabled'] == 'N') || !isset($forum_global_settings['attachments_enabled'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Enable attachment image thumbnails"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("attachment_thumbnails", "Y", gettext("Yes"), (isset($forum_global_settings['attachment_thumbnails']) && $forum_global_settings['attachment_thumbnails'] == 'Y') || !isset($forum_global_settings['attachment_thumbnails'])), "&nbsp;", form_radio("attachment_thumbnails", "N", gettext("No"), isset($forum_global_settings['attachment_thumbnails']) && $forum_global_settings['attachment_thumbnails'] == 'N'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Allow embedding of attachments"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("attachments_allow_embed", "Y", gettext("Yes"), (isset($forum_global_settings['attachments_allow_embed']) && $forum_global_settings['attachments_allow_embed'] == 'Y')), "&nbsp;", form_radio("attachments_allow_embed", "N", gettext("No"), (isset($forum_global_settings['attachments_allow_embed']) && $forum_global_settings['attachments_allow_embed'] == 'N') || !isset($forum_global_settings['attachments_allow_embed'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Allow Guests to access attachments"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("attachment_allow_guests", "Y", gettext("Yes"), (isset($forum_global_settings['attachment_allow_guests']) && $forum_global_settings['attachment_allow_guests'] == 'Y')), "&nbsp;", form_radio("attachment_allow_guests", "N", gettext("No"), (isset($forum_global_settings['attachment_allow_guests']) && $forum_global_settings['attachment_allow_guests'] == 'N') || !isset($forum_global_settings['attachment_allow_guests'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Attachment Dir"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachment_dir", (isset($forum_global_settings['attachment_dir'])) ? htmlentities_array($forum_global_settings['attachment_dir']) : "attachments", 35, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Attachment thumbnail method"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('attachment_thumbnail_method', $attachment_thumbnail_methods, (isset($forum_global_settings['attachment_thumbnail_method']) ? $forum_global_settings['attachment_thumbnail_method'] : ATTACHMENT_THUMBNAIL_PHPGD)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Path to Imagemagick convert binary"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachment_imagemagick_path", (isset($forum_global_settings['attachment_imagemagick_path'])) ? htmlentities_array($forum_global_settings['attachment_imagemagick_path']) : '', 35, 255), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Maximum attachment space per user"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachments_max_user_space", (isset($forum_global_settings['attachments_max_user_space'])) ? htmlentities_array(($forum_global_settings['attachments_max_user_space'] / 1024) / 1024) : "1", 10, 32), "&nbsp;MB</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Maximum attachment space per post"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachments_max_post_space", (isset($forum_global_settings['attachments_max_post_space'])) ? htmlentities_array(($forum_global_settings['attachments_max_post_space'] / 1024) / 1024) : "1", 10, 32), "&nbsp;MB</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"270\">", gettext("Maximum attachment file size"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("attachment_size_limit", (isset($forum_global_settings['attachment_size_limit'])) ? htmlentities_array(($forum_global_settings['attachment_size_limit'] / 1024) / 1024) : '', 10, 32), "&nbsp;MB</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" width=\"270\" colspan=\"2\">", gettext("Allowed attachment mime-types"), ":</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">", form_textarea("attachment_mime_types", (isset($forum_global_settings['attachment_mime_types'])) ? htmlentities_array($forum_global_settings['attachment_mime_types']) : "", 6, 82, null, 'admin_tools_textarea'), "&nbsp;</td>\n";
echo "                      </tr>\n";

if (isset($forum_global_settings['attachments_enabled']) && $forum_global_settings['attachments_enabled'] == "Y") {

    if (!attachments_check_dir()) {

        echo "                      <tr>\n";
        echo "                        <td colspan=\"2\">\n";

        html_display_error_msg(gettext("Attachment directory and system temporary directory / php.ini 'upload_tmp_dir' must be writable by the web server / PHP process!"), '95%', 'center');

        echo "                        </td>\n";
        echo "                      </tr>\n";
    }
}

echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">\n";
echo "                          <p>", gettext("Beehive allows attachments to be uploaded to messages when posted. If you have limited web space you may which to disable attachments by clearing the box above."), "</p>\n";
echo "                          <p>", gettext("<b>Attachment Dir</b> is the location Beehive should store attachments in. This directory must exist on your web space and must be writable by the web server / PHP process otherwise uploads will fail."), "</p>\n";
echo "                          <p>", gettext("<b>Maximum attachment space per user / post</b> is the maximum amount of disk space a user has for attachments. Once this space is used up the user cannot upload any more attachments. Maximum user space is the amount of space the user has for all uploaded files, whether they are attached to a post, a private message or left unassigned. Max post space is the maximum size per individual post or PM. Set to zero (0) to allow unlimited space."), "</p>\n";
echo "                          <p>", gettext("<b>Maximum attachment file size</b> is the maximum size of a single uploaded file. This is the limit of your webserver and/or PHP. Only set this value if you are having problems with attachments not uploading. Leave it blank to have your Beehive Forum determine the amount from PHP's upload_max_filesize configuration setting."), "</p>\n";
echo "                          <p>", gettext("<b>Allow embedding of attachments in messages / signatures</b> allows users to embed attachments in posts. Enabling this option while useful can increase your bandwidth usage drastically under certain configurations of PHP. If you have limited bandwidth it is recommended that you disable this option."), "</p>\n";
echo "                          <p>", gettext("<b>Use Alternative attachment method</b> Forces Beehive to use an alternative retrieval method for attachments. If you receive 404 error messages when trying to download attachments from messages try enabling this option."), "</p>\n";
echo "                          <p>", gettext("<b>Allowed attachment mime-types</b> allows you to restrict the mime-types of files that can be uploaded. Enter each allowed mime-type on a new line. <b>Note:</b> Beehive doesn't perform strict analysis of the files uploaded and renamed files may be able to circumvent this restriction."), "</p>\n";
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