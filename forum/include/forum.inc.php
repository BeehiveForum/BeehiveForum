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

// Required includes
require_once BH_INCLUDE_PATH . 'adsense.inc.php';
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'install.inc.php';
require_once BH_INCLUDE_PATH . 'ip.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'sitemap.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function get_forum_data()
{
    static $forum_data = false;

    if (!$db = db::get()) return false;

    if (!is_array($forum_data) || !isset($forum_data['WEBTAG']) || !isset($forum_data['PREFIX'])) {

        if (($webtag = get_webtag()) !== false) {

            // Check #1: See if the webtag specified in GET/POST
            // actually exists.
            $webtag = $db->escape($webtag);

            $sql = "SELECT FID, WEBTAG, ACCESS_LEVEL, DEFAULT_FORUM, DATABASE_NAME, ";
            $sql .= "CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX ";
            $sql .= "FROM FORUMS WHERE WEBTAG = '$webtag'";

            if (($result = $db->query($sql)) !== false) {

                if ($result->num_rows == 0) return false;

                $forum_data = $result->fetch_assoc();

                if (!isset($forum_data['ACCESS_LEVEL'])) $forum_data['ACCESS_LEVEL'] = 0;
            }

        } else {

            // Check #2: Try and select a default webtag from
            // the databse
            $sql = "SELECT FID, WEBTAG, ACCESS_LEVEL, DEFAULT_FORUM, DATABASE_NAME, ";
            $sql .= "CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX ";
            $sql .= "FROM FORUMS WHERE DEFAULT_FORUM = 1";

            if (($result = $db->query($sql)) !== false) {

                if ($result->num_rows == 0) return false;

                $forum_data = $result->fetch_assoc();

                if (!isset($forum_data['ACCESS_LEVEL'])) $forum_data['ACCESS_LEVEL'] = 0;
            }
        }
    }

    return $forum_data;
}

function get_webtag()
{
    if (isset($_GET['webtag']) && preg_match("/^[A-Z]{1}[A-Z0-9_]+$/D", trim($_GET['webtag']))) {
        return trim($_GET['webtag']);
    } else if (isset($_POST['webtag']) && preg_match("/^[A-Z]{1}[A-Z0-9_]+$/D", trim($_POST['webtag']))) {
        return trim($_POST['webtag']);
    }

    return false;
}

function get_table_prefix()
{
    if (!($forum_data = get_forum_data())) return false;

    if (!isset($forum_data['PREFIX'])) return false;

    return $forum_data['PREFIX'];
}

function get_forum_fid()
{
    if (!($forum_data = get_forum_data())) return false;

    if (!isset($forum_data['FID'])) return false;

    return $forum_data['FID'];
}

function get_all_table_prefixes()
{
    $db = db::get();

    $sql = "SELECT FID, WEBTAG, ACCESS_LEVEL, DEFAULT_FORUM, DATABASE_NAME, ";
    $sql .= "CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX FROM FORUMS";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $forum_data_array = array();

    while (($forum_data = $result->fetch_assoc()) !== null) {

        if (!isset($forum_data['ACCESS_LEVEL'])) $forum_data['ACCESS_LEVEL'] = 0;

        $forum_data_array[] = $forum_data;
    }

    return $forum_data_array;
}

function forum_check_webtag_available(&$webtag, $check_ignore = true)
{
    $result = ($check_ignore) ? forum_check_webtag_available_ignore() : false;

    if (!($forum_data = get_forum_data())) return $result;

    if (!isset($forum_data['WEBTAG'])) return $result;

    if (isset($forum_data['DEFAULT_FORUM']) && ($webtag === false)) {
        $webtag = ($forum_data['DEFAULT_FORUM'] == FORUM_DEFAULT) ? $forum_data['WEBTAG'] : $webtag;
    }

    if ($forum_data['ACCESS_LEVEL'] != FORUM_DISABLED) {
        return true;
    }

    return $result;
}

function forum_check_webtag_available_ignore()
{
    $forum_check_webtag_ignore_files_preg = implode("|^", array_map('preg_quote_callback', get_forum_check_webtag_ignore_files()));

    if (preg_match("/^$forum_check_webtag_ignore_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) {
        return true;
    }

    return false;
}

function forum_check_guest_access_allowed()
{
    $result = forum_check_guest_access_allowed_ignore();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return $result;

    if (!user_guest_enabled() && $_SESSION['UID'] == 0) {
        return $result;
    }

    return true;
}

function forum_check_guest_access_allowed_ignore()
{
    $guest_access_ignore_files_preg = implode("|^", array_map('preg_quote_callback', get_guest_access_ignore_files()));

    if (preg_match("/^$guest_access_ignore_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) {
        return true;
    }

    return false;
}

function forum_check_access_level()
{
    $forum_access_ignore_files_preg = implode("|^", array_map('preg_quote_callback', get_forum_access_ignore_files()));

    if (preg_match("/^$forum_access_ignore_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) {
        return true;
    }

    if (!($db = db::get())) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT FORUMS.FID, FORUMS.ACCESS_LEVEL, USER_FORUM.ALLOWED FROM FORUMS ";
    $sql .= "LEFT JOIN USER_FORUM ON (USER_FORUM.FID = FORUMS.FID ";
    $sql .= "AND USER_FORUM.UID = '{$_SESSION['UID']}') WHERE FORUMS.FID = '$forum_fid' ";
    $sql .= "AND FORUMS.ACCESS_LEVEL < 3";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    if (!($forum_data = $result->fetch_assoc())) return false;

    if (!isset($forum_data['ACCESS_LEVEL'])) return true;

    if ($forum_data['ACCESS_LEVEL'] == FORUM_CLOSED) {

        forum_closed_message();

    } else if (($forum_data['ACCESS_LEVEL'] == FORUM_RESTRICTED) && ($forum_data['ALLOWED'] != FORUM_USER_ALLOWED)) {

        forum_restricted_message();

    } else if ($forum_data['ACCESS_LEVEL'] == FORUM_PASSWD_PROTECTED) {

        forum_check_password($forum_data['FID']);
    }

    return true;
}

function forum_closed_message()
{
    cache_disable();

    html_draw_top(
        array(
            'title' => gettext("Closed")
        )
    );


    $forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

    echo "<h1>", gettext("Closed"), "</h1>\n";

    if (($closed_message = forum_get_setting('closed_message')) !== false) {

        html_display_error_msg(fix_html($closed_message), '600', 'center');

    } else {

        html_display_error_msg(sprintf(gettext("%s is currently closed"), htmlentities_array($forum_name)), '600', 'center');
    }

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0) || session::check_perm(USER_PERM_FORUM_TOOLS, 0)) {

        html_display_warning_msg(gettext("If you want to change some settings on your forum click the Admin link in the navigation bar above."), '600', 'center');
    }

    html_draw_bottom();
    exit;
}

function forum_restricted_message()
{
    cache_disable();

    $final_uri = basename(get_request_uri());

    $available_popup_files_preg = implode("|^", array_map('preg_quote_callback', get_available_popup_files()));

    if (preg_match("/^$available_popup_files_preg/", $final_uri) > 0) {
        $forum_owner_link_target = "_blank";
    } else {
        $forum_owner_link_target = html_get_top_frame_name();
    }

    if (($restricted_message = forum_get_setting('restricted_message', null, false)) !== false) {

        html_draw_error(fix_html($restricted_message), '600', 'center');

    } else {

        $forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

        if (!($forum_owner_uid = forum_get_setting('owner_uid'))) {
            html_draw_error(sprintf(gettext("You do not have access to %s"), htmlentities_array($forum_name)));
        }

        $webtag = get_webtag();

        forum_check_webtag_available($webtag);

        $forum_owner_pm_link = sprintf('pm_write.php?webtag=%s&uid=%s', $webtag, $forum_owner_uid);

        $forum_owner_link = sprintf(
            '<a href="index.php?webtag=%s&amp;final_uri=%s" target="%s">%s</a>',
            $webtag,
            rawurlencode($forum_owner_pm_link),
            $forum_owner_link_target,
            gettext('Forum Owner')
        );

        $apply_for_access_text = sprintf(gettext("To apply for access please contact the %s."), $forum_owner_link);

        html_draw_error(sprintf(gettext("You do not have access to %s. To apply for access please contact the %s"), htmlentities_array($forum_name), $apply_for_access_text));
    }
}

function forum_get_password($forum_fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($forum_fid)) return false;

    $sql = "SELECT FORUM_PASSWD FROM FORUMS WHERE FID = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($forum_passwd) = $result->fetch_row();

    return is_md5($forum_passwd) ? $forum_passwd : false;
}

function forum_check_password($forum_fid)
{
    if (!is_numeric($forum_fid)) return;

    $webtag = get_webtag();

    if (!forum_check_webtag_available($webtag)) return;

    if (!($forum_passhash = forum_get_password($forum_fid))) return;

    if (isset($_SESSION["{$webtag}_PASSWORD"]) && is_md5($_SESSION["{$webtag}_PASSWORD"])) {
        $forum_passhash_check = $_SESSION["{$webtag}_PASSWORD"];
    } else {
        $forum_passhash_check = null;
    }

    if (isset($_POST['forum_password']) && strlen($_POST['forum_password']) > 0) {
        $forum_passhash_check = md5($_POST['forum_password']);
    }

    if ($forum_passhash == $forum_passhash_check) {

        $_SESSION["{$webtag}_PASSWORD"] = $forum_passhash_check;
        return;
    }

    cache_disable();

    html_draw_top(
        array(
            'title' => gettext("Password Protected Forum")
        )
    );


    echo "<h1>", gettext("Password Protected Forum"), "</h1>\n";

    if (isset($_SESSION["{$webtag}_PASSWORD"]) && is_md5($_SESSION["{$webtag}_PASSWORD"])) {
        html_display_error_msg(gettext("The username or password you supplied is not valid."), '550', 'center');
    }

    if (($password_protected_message = forum_get_setting('password_protected_message')) !== false) {

        echo fix_html($password_protected_message);

    } else {

        html_display_warning_msg(gettext("This forum is password protected. To gain access enter the password below."), '400', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" method=\"post\" action=\"", get_request_uri(), "\" target=\"_self\" autocomplete=\"off\">\n";
    echo "    ", form_csrf_token_field(), "\n";

    if (isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) {
        echo form_input_hidden_array($_POST);
    }

    echo "    ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">\n";
    echo "          <table class=\"box\" width=\"400\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\" align=\"center\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Enter Password"), "</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "                <table class=\"posthead\" width=\"90%\">\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\">", gettext("Password"), ":</td>\n";
    echo "                    <td align=\"left\">", form_input_password('forum_password', null, 40), "</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">&nbsp;</td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"center\">", form_submit("logon", gettext("Logon")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "      </tr>\n";
    echo "    </table>\n";

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0) || session::check_perm(USER_PERM_FORUM_TOOLS, 0)) {
        html_display_warning_msg(gettext("If you want to change some settings on your forum click the Admin link in the navigation bar above."), '400', 'center');
    }

    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;
}

function forum_get_settings()
{
    static $forum_settings = array();

    if (!$forum_settings) {

        if (!($forum_fid = get_forum_fid())) return $forum_settings;

        $forum_settings = forum_get_settings_by_fid($forum_fid, 'forum_check_setting_name');
    }

    return $forum_settings;
}

function forum_get_global_settings()
{
    static $forum_global_settings = array();

    if (!$forum_global_settings) {
        $forum_global_settings = forum_get_settings_by_fid(0, 'forum_check_global_setting_name');
    }

    return $forum_global_settings;
}

function forum_get_settings_by_fid($forum_fid, $callback = null)
{
    if (!$db = db::get()) return false;

    $forum_fid = $db->escape($forum_fid);

    $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $forum_settings = array(
        'fid' => $forum_fid,
        'forum_gmt_offset' => 0,
        'forum_dst_offset' => 1
    );

    while (($forum_data = $result->fetch_assoc()) !== null) {

        if (!is_callable($callback) || $callback($forum_data['SNAME'])) {
            $forum_settings[$forum_data['SNAME']] = $forum_data['SVALUE'];
        }
    }

    if (isset($forum_settings['forum_timezone'])) {

        $timezone = $db->escape($forum_settings['forum_timezone']);

        $sql = "SELECT GMT_OFFSET, DST_OFFSET FROM TIMEZONES ";
        $sql .= "WHERE TZID = '$timezone'";

        if (!($result = $db->query($sql))) return false;

        if ($result->num_rows > 0) {

            list($gmt_offset, $dst_offset) = $result->fetch_row();

            $forum_settings['forum_gmt_offset'] = $gmt_offset;
            $forum_settings['forum_dst_offset'] = $dst_offset;
        }
    }

    $sql = "SELECT WEBTAG, ACCESS_LEVEL, OWNER_UID FROM FORUMS WHERE FID = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        list($webtag, $access_level, $owner_uid) = $result->fetch_row();

        $forum_settings['webtag'] = $webtag;
        $forum_settings['access_level'] = $access_level;
        $forum_settings['owner_uid'] = $owner_uid;
    }

    return $forum_settings;
}

function forum_save_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    foreach ($forum_settings_array as $setting_name => $setting_value) {

        if (forum_check_setting_name($setting_name)) {

            $setting_name = $db->escape($setting_name);
            $setting_value = $db->escape($setting_value);

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql .= "VALUES ($forum_fid, '$setting_name', '$setting_value')";
            $sql .= "ON DUPLICATE KEY UPDATE SVALUE = VALUES(SVALUE)";

            if (!$db->query($sql)) return false;
        }
    }

    return true;
}

function forum_save_global_settings($forum_settings_array)
{
    if (!is_array($forum_settings_array)) return false;

    if (!$db = db::get()) return false;

    foreach ($forum_settings_array as $setting_name => $setting_value) {

        if (forum_check_global_setting_name($setting_name)) {

            $setting_name = $db->escape($setting_name);
            $setting_value = $db->escape($setting_value);

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql .= "VALUES ('0', '$setting_name', '$setting_value') ";
            $sql .= "ON DUPLICATE KEY UPDATE SVALUE = VALUES(SVALUE)";

            if (!$db->query($sql)) return false;
        }
    }

    return true;
}

function forum_check_setting_name($setting_name)
{
    $valid_forum_settings = array(
        'adsense_display_users',
        'adsense_display_pages',
        'allow_polls',
        'allow_post_editing',
        'allow_search_spidering',
        'closed_message',
        'csrf_token_name',
        'default_emoticons',
        'default_language',
        'default_style',
        'default_user_group',
        'enable_wiki_integration',
        'enable_wiki_quick_links',
        'enable_tags',
        'enable_google_analytics',
        'force_word_filter',
        'forum_desc',
        'forum_content_rating',
        'forum_dl_saving',
        'forum_email',
        'forum_keywords',
        'forum_name',
        'forum_links_top_link',
        'forum_timezone',
        'google_analytics_code',
        'guest_account_enabled',
        'guest_show_recent',
        'maximum_post_length',
        'minimum_post_frequency',
        'password_protected_message',
        'poll_allow_guests',
        'post_edit_grace_period',
        'post_edit_time',
        'restricted_message',
        'searchbots_show_active',
        'searchbots_show_recent',
        'send_new_user_email',
        'show_links',
        'require_link_approval',
        'show_share_links',
        'show_stats',
        'start_page',
        'start_page_css',
        'wiki_integration_uri',
    );

    return in_array($setting_name, $valid_forum_settings);
}

function forum_check_global_setting_name($setting_name)
{
    $valid_global_forum_settings = array(
        'adsense_publisher_id',
        'adsense_medium_ad_id',
        'adsense_small_ad_id',
        'adsense_display_users',
        'adsense_display_pages',
        'adsense_message_number',
        'allow_new_registrations',
        'allow_search_spidering',
        'allow_username_changes',
        'attachments_allow_embed',
        'attachments_enabled',
        'attachment_thumbnails',
        'attachment_thumbnail_method',
        'attachments_max_user_space',
        'attachments_max_post_space',
        'attachment_allow_guests',
        'attachment_dir',
        'attachment_mime_types',
        'attachment_imagemagick_path',
        'cache_dir',
        'content_delivery_domains',
        'forum_desc',
        'forum_email',
        'forum_keywords',
        'forum_name',
        'forum_noreply_email',
        'forum_rules_enabled',
        'forum_rules_message',
        'forum_maintenance_function',
        'forum_maintenance_schedule',
        'forum_timezone',
        'pm_system_prune_folders_last_run',
        'thread_auto_prune_unread_data_last_run',
        'sitemap_create_file_last_run',
        'enable_google_analytics',
        'allow_forum_google_analytics',
        'google_analytics_code',
        'guest_account_enabled',
        'guest_show_recent',
        'message_cache_enabled',
        'messages_unread_cutoff',
        'messages_unread_cutoff_custom',
        'new_user_email_notify',
        'new_user_mark_as_of_int',
        'new_user_pm_notify_email',
        'new_user_pm_notify',
        'pm_allow_attachments',
        'pm_auto_prune',
        'pm_max_user_messages',
        'require_email_confirmation',
        'require_unique_email',
        'require_user_approval',
        'search_limit_count',
        'search_limit_time',
        'searchbots_show_active',
        'searchbots_show_recent',
        'send_new_user_email',
        'sitemap_enabled',
        'sitemap_freq',
        'showpopuponnewpm',
        'show_pms',
        'text_captcha_enabled',
        'text_captcha_key',
        'text_captcha_dir',
        'mail_function',
        'sendmail_path',
        'smtp_server',
        'smtp_port',
        'smtp_ssl',
        'smtp_username',
        'smtp_password',
        'sphinx_search_enabled',
        'sphinx_search_host',
        'sphinx_search_port',
        'use_minified_scripts',
        'sfs_enabled',
        'sfs_api_url',
        'sfs_min_confidence',
        'ajax_chat_enabled',
    );

    return in_array($setting_name, $valid_global_forum_settings);
}

function forum_get_name($fid)
{
    if (!$db = db::get()) return gettext("A Beehive Forum");

    if (!is_numeric($fid)) return gettext("A Beehive Forum");

    $sql = "SELECT SVALUE AS FORUM_NAME FROM FORUM_SETTINGS ";
    $sql .= "WHERE SNAME = 'forum_name' AND FID = '$fid'";

    if (!($result = $db->query($sql))) return gettext("A Beehive Forum");

    if ($result->num_rows == 0) return gettext("A Beehive Forum");

    list($forum_name) = $result->fetch_row();

    return $forum_name;
}

function forum_get_webtag($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT WEBTAG FROM FORUMS WHERE FID = '$fid' AND ACCESS_LEVEL < 3";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($forum_webtag) = $result->fetch_row();

    return $forum_webtag;
}

function forum_get_table_prefix($fid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX, ";
    $sql .= "FID, WEBTAG FROM FORUMS WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($forum_prefix) = $result->fetch_row();

    return $forum_prefix;
}

function forum_get_setting($setting_name, $callback = null, $default = null)
{
    $forum_settings = forum_get_settings();

    if (!is_array($forum_settings) || !isset($forum_settings[$setting_name])) {
        return forum_get_global_setting($setting_name, $callback, $default);
    }

    if (function_exists($callback) && is_callable($callback)) {
        return ($callback($forum_settings[$setting_name])) ? $forum_settings[$setting_name] : $default;
    } else if (is_scalar($callback)) {
        return mb_strtoupper($forum_settings[$setting_name]) == mb_strtoupper($callback);
    }

    return $forum_settings[$setting_name];
}

function forum_get_global_setting($setting_name, $callback = null, $default = null)
{
    $forum_global_settings = forum_get_global_settings();

    if (!is_array($forum_global_settings) || !isset($forum_global_settings[$setting_name])) {
        return $default;
    }

    if (function_exists($callback) && is_callable($callback)) {
        return ($callback($forum_global_settings[$setting_name])) ? $forum_global_settings[$setting_name] : $default;
    } else if (is_scalar($callback)) {
        return mb_strtoupper($forum_global_settings[$setting_name]) == mb_strtoupper($callback);
    }

    return $forum_global_settings[$setting_name];
}

function forum_get_unread_cutoff()
{
    $unread_cutoff_periods = array(
        THIRTY_DAYS_IN_SECONDS,
        SIXTY_DAYS_IN_SECONDS,
        NINETY_DAYS_IN_SECONDS,
        HUNDRED_EIGHTY_DAYS_IN_SECONDS,
        YEAR_IN_SECONDS
    );

    $messages_unread_cutoff = forum_get_setting('messages_unread_cutoff');

    if ($messages_unread_cutoff == UNREAD_MESSAGES_DISABLED) return false;

    return in_array($messages_unread_cutoff, $unread_cutoff_periods) ? $messages_unread_cutoff : YEAR_IN_SECONDS;
}

function forum_get_unread_cutoff_datetime()
{
    if (($unread_cutoff_stamp = forum_get_unread_cutoff()) === false) return false;
    return date(MYSQL_DATETIME_MIDNIGHT, time() - $unread_cutoff_stamp);
}

function forum_process_unread_cutoff($forum_settings)
{
    if (!is_array($forum_settings)) return YEAR_IN_SECONDS;

    $unread_cutoff_periods = array(
        THIRTY_DAYS_IN_SECONDS,
        SIXTY_DAYS_IN_SECONDS,
        NINETY_DAYS_IN_SECONDS,
        HUNDRED_EIGHTY_DAYS_IN_SECONDS,
        YEAR_IN_SECONDS
    );

    if (isset($forum_settings['messages_unread_cutoff'])) {
        $messages_unread_cutoff = $forum_settings['messages_unread_cutoff'];
    } else {
        $messages_unread_cutoff = YEAR_IN_SECONDS;
    }

    if ($messages_unread_cutoff == UNREAD_MESSAGES_DISABLED) return false;

    return in_array($messages_unread_cutoff, $unread_cutoff_periods) ? $messages_unread_cutoff : YEAR_IN_SECONDS;
}

function forum_update_unread_data($unread_cutoff_stamp)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($unread_cutoff_stamp)) return false;

    $unread_cutoff_datetime = date(MYSQL_DATETIME_MIDNIGHT, time() - $unread_cutoff_stamp);

    if (!($forum_prefix_array = forum_get_all_prefixes())) return false;

    foreach ($forum_prefix_array as $forum_prefix) {

        $sql = "DELETE QUICK FROM `{$forum_prefix}USER_THREAD` ";
        $sql .= "USING `{$forum_prefix}USER_THREAD` LEFT JOIN `{$forum_prefix}THREAD` ";
        $sql .= "ON (`{$forum_prefix}USER_THREAD`.`TID` = `{$forum_prefix}USER_THREAD`.`TID`) ";
        $sql .= "WHERE `{$forum_prefix}THREAD`.`MODIFIED` IS NOT NULL ";
        $sql .= "AND `{$forum_prefix}THREAD`.`MODIFIED` < CAST('$unread_cutoff_datetime' AS DATETIME) ";
        $sql .= "AND (`{$forum_prefix}USER_THREAD`.`INTEREST` IS NULL ";
        $sql .= "OR `{$forum_prefix}USER_THREAD`.`INTEREST` = 0)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function forum_create($webtag, $forum_name, $owner_uid, $database_name, $access, $delete_tables_on_error, &$error_str)
{
    if (!is_numeric($owner_uid)) return false;

    if (!is_numeric($access)) return false;

    if (!preg_match("/^[A-Z]{1}[A-Z0-9_]+$/Du", $webtag)) return false;

    $ipaddress = get_ip_address();

    $current_datetime = date(MYSQL_DATETIME, time());

    $forum_table_prefix = install_format_table_prefix($database_name, $webtag);

    if (!$db = db::get()) return false;

    $sql = "SELECT FID FROM FORUMS WHERE WEBTAG = '$webtag'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        $error_str = gettext("The selected webtag is already in use. Please choose another.");
        return false;
    }

    if (($conflicting_tables_array = install_check_table_conflicts($database_name, $webtag, true, false, false)) !== false) {

        $error_str = gettext("The selected database contains conflicting tables. Conflicting table names are:");
        $error_str .= sprintf("<p>%s</p>\n", implode(", ", $conflicting_tables_array));

        return false;
    }

    try {

        $sql = "CREATE TABLE `{$forum_table_prefix}ADMIN_LOG` (";
        $sql .= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL,";
        $sql .= "  ACTION MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  ENTRY LONGBLOB,";
        $sql .= "  PRIMARY KEY  (ID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}BANNED` (";
        $sql .= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
        $sql .= "  BANTYPE TINYINT(4) NOT NULL, ";
        $sql .= "  BANDATA VARCHAR(255) NOT NULL, ";
        $sql .= "  COMMENT VARCHAR(255) NOT NULL, ";
        $sql .= "  EXPIRES DATETIME DEFAULT NULL, ";
        $sql .= "  PRIMARY KEY (ID), ";
        $sql .= "  KEY BANTYPE (BANTYPE, BANDATA)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}FOLDER` (";
        $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
        $sql .= "  TITLE VARCHAR(32) NOT NULL, ";
        $sql .= "  DESCRIPTION VARCHAR(255) DEFAULT NULL, ";
        $sql .= "  CREATED DATETIME NOT NULL, ";
        $sql .= "  MODIFIED DATETIME DEFAULT NULL, ";
        $sql .= "  PREFIX VARCHAR(16) DEFAULT NULL, ";
        $sql .= "  ALLOWED_TYPES TINYINT(3) NOT NULL, ";
        $sql .= "  POSITION MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  PERM INT(32) UNSIGNED DEFAULT NULL, ";
        $sql .= "  PRIMARY KEY (FID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}FORUM_LINKS` (";
        $sql .= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  URI VARCHAR(255) NOT NULL,";
        $sql .= "  TITLE VARCHAR(64) NOT NULL,";
        $sql .= "  POSITION MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (LID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}LINKS` (";
        $sql .= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  FID SMALLINT(5) UNSIGNED NOT NULL,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  URI VARCHAR(255) NOT NULL,";
        $sql .= "  TITLE VARCHAR(64) NOT NULL,";
        $sql .= "  DESCRIPTION TEXT NOT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL,";
        $sql .= "  APPROVED DATETIME DEFAULT NULL,";
        $sql .= "  APPROVED_BY MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  VISIBLE CHAR(1) NOT NULL DEFAULT 'N',";
        $sql .= "  CLICKS MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (LID),";
        $sql .= "  KEY FID (FID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}LINKS_COMMENT` (";
        $sql .= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  LID SMALLINT(5) UNSIGNED NOT NULL,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL,";
        $sql .= "  COMMENT TEXT NOT NULL,";
        $sql .= "  PRIMARY KEY  (CID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}LINKS_FOLDERS` (";
        $sql .= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT NULL,";
        $sql .= "  NAME VARCHAR(32) NOT NULL,";
        $sql .= "  VISIBLE CHAR(1) NOT NULL,";
        $sql .= "  PRIMARY KEY  (FID),";
        $sql .= "  KEY PARENT_FID (PARENT_FID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}LINKS_VOTE` (";
        $sql .= "  LID SMALLINT(5) UNSIGNED NOT NULL,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  RATING SMALLINT(5) UNSIGNED NOT NULL,";
        $sql .= "  VOTED DATETIME NOT NULL,";
        $sql .= "  PRIMARY KEY  (LID,UID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POLL` (";
        $sql .= "  `TID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `CLOSES` DATETIME DEFAULT NULL,";
        $sql .= "  `CHANGEVOTE` TINYINT(1) NOT NULL,";
        $sql .= "  `POLLTYPE` TINYINT(1) NOT NULL,";
        $sql .= "  `SHOWRESULTS` TINYINT(1) NOT NULL,";
        $sql .= "  `VOTETYPE` TINYINT(1) UNSIGNED NOT NULL,";
        $sql .= "  `OPTIONTYPE` TINYINT(1) UNSIGNED NOT NULL,";
        $sql .= "  `ALLOWGUESTS` TINYINT(1) NOT NULL,";
        $sql .= "  PRIMARY KEY (`TID`)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POLL_QUESTIONS` (";
        $sql .= "  `TID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `QUESTION_ID` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  `QUESTION` VARCHAR(255) NOT NULL,";
        $sql .= "  `ALLOW_MULTI` CHAR(1) NOT NULL,";
        $sql .= "  PRIMARY KEY (`TID`,`QUESTION_ID`)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POLL_VOTES` (";
        $sql .= "  `TID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `QUESTION_ID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `OPTION_ID` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  `OPTION_NAME` VARCHAR(255) NOT NULL,";
        $sql .= "  PRIMARY KEY (`TID`,`QUESTION_ID`,`OPTION_ID`)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POST` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL,";
        $sql .= "  APPROVED DATETIME DEFAULT NULL,";
        $sql .= "  APPROVED_BY MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  EDITED DATETIME DEFAULT NULL,";
        $sql .= "  EDITED_BY MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  IPADDRESS VARCHAR(255) NOT NULL,";
        $sql .= "  MOVED_TID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  MOVED_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  INDEXED DATETIME DEFAULT NULL,";
        $sql .= "  PRIMARY KEY (TID,PID),";
        $sql .= "  KEY FROM_UID (FROM_UID),";
        $sql .= "  KEY IPADDRESS (IPADDRESS,FROM_UID),";
        $sql .= "  KEY APPROVED (APPROVED),";
        $sql .= "  KEY CREATED (CREATED),";
        $sql .= "  KEY EDITED (EDITED),";
        $sql .= "  KEY INDEXED (INDEXED)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_CONTENT` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  CONTENT TEXT,";
        $sql .= "  PRIMARY KEY  (TID,PID),";
        $sql .= "  FULLTEXT KEY CONTENT (CONTENT)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_RATING` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  RATING TINYINT(4) NOT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL,";
        $sql .= "  PRIMARY KEY (TID,PID,UID),";
        $sql .= "  KEY CREATED (CREATED),";
        $sql .= "  KEY RATING (RATING)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_RECIPIENT` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  VIEWED DATETIME DEFAULT NULL,";
        $sql .= "  PRIMARY KEY (TID,PID,TO_UID),";
        $sql .= "  KEY VIEWED (VIEWED)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_SEARCH_ID` (";
        $sql .= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (SID,TID,PID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_TAG` (";
        $sql .= "  TID MEDIUMINT(11) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(11) UNSIGNED NOT NULL,";
        $sql .= "  TAG MEDIUMINT(11) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY (TID, PID, TAG)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}TAG` (";
        $sql .= "  TID MEDIUMINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  TAG VARCHAR(255) DEFAULT NULL,";
        $sql .= "  PRIMARY KEY (TID),";
        $sql .= "  UNIQUE KEY TAG (TAG)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}PROFILE_ITEM` (";
        $sql .= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  NAME VARCHAR(64) NOT NULL,";
        $sql .= "  TYPE TINYINT(3) UNSIGNED NOT NULL,";
        $sql .= "  OPTIONS TEXT NOT NULL, ";
        $sql .= "  POSITION MEDIUMINT(3) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (PIID),";
        $sql .= "  KEY PSID (PSID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` ";
        $sql .= "(PSID, NAME, TYPE, OPTIONS, POSITION) ";
        $sql .= "VALUES (1, 'Location', 0, '', 1)";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` ";
        $sql .= "(PSID, NAME, TYPE, OPTIONS, POSITION) ";
        $sql .= "VALUES (1, 'Age', 0, '', 2)";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` ";
        $sql .= "(PSID, NAME, TYPE, OPTIONS, POSITION) VALUES ";
        $sql .= "(1, 'Gender', 5, 'Male\nFemale\nUnspecified', 3)";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` ";
        $sql .= "(PSID, NAME, TYPE, OPTIONS, POSITION) ";
        $sql .= "VALUES (1, 'Quote', 0, '', 4)";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` ";
        $sql .= "(PSID, NAME, TYPE, OPTIONS, POSITION) ";
        $sql .= "VALUES (1, 'Occupation', 0, '', 5)";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}PROFILE_SECTION` (";
        $sql .= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  NAME VARCHAR(64) NOT NULL,";
        $sql .= "  POSITION MEDIUMINT(3) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (PSID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}PROFILE_SECTION` ";
        $sql .= "(NAME, POSITION) VALUES ('Personal', 1)";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}RSS_FEEDS` (";
        $sql .= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  NAME VARCHAR(255) NOT NULL,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  URL VARCHAR(255) NOT NULL, ";
        $sql .= "  PREFIX VARCHAR(16) DEFAULT NULL, ";
        $sql .= "  FREQUENCY MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  LAST_RUN DATETIME DEFAULT NULL, ";
        $sql .= "  MAX_ITEM_COUNT MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  PRIMARY KEY  (RSSID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}RSS_HISTORY` (";
        $sql .= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  LINK VARCHAR(255) NOT NULL, ";
        $sql .= "  KEY RSSID (RSSID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}STATS` (";
        $sql .= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  MOST_USERS_DATE DATETIME NOT NULL,";
        $sql .= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  MOST_POSTS_DATE DATETIME NOT NULL,";
        $sql .= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (ID),";
        $sql .= "  KEY MOST_POSTS_COUNT (MOST_POSTS_COUNT), ";
        $sql .= "  KEY MOST_USERS_COUNT (MOST_USERS_COUNT) ";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}THREAD` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
        $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  BY_UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  TITLE VARCHAR(64) NOT NULL, ";
        $sql .= "  LENGTH MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  UNREAD_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
        $sql .= "  POLL_FLAG CHAR(1) DEFAULT 'N', ";
        $sql .= "  APPROVED DATETIME DEFAULT NULL,";
        $sql .= "  APPROVED_BY MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL, ";
        $sql .= "  MODIFIED DATETIME DEFAULT NULL, ";
        $sql .= "  CLOSED DATETIME DEFAULT NULL, ";
        $sql .= "  STICKY CHAR(1) NOT NULL DEFAULT 'N', ";
        $sql .= "  STICKY_UNTIL DATETIME DEFAULT NULL, ";
        $sql .= "  ADMIN_LOCK DATETIME DEFAULT NULL, ";
        $sql .= "  DELETED CHAR(1) NOT NULL DEFAULT 'N', ";
        $sql .= "  PRIMARY KEY (TID), ";
        $sql .= "  KEY STICKY (STICKY, MODIFIED, FID, LENGTH, DELETED), ";
        $sql .= "  KEY MODIFIED (MODIFIED, FID, LENGTH, DELETED), ";
        $sql .= "  FULLTEXT KEY TITLE (TITLE) ";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}THREAD_STATS` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (TID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}THREAD_TRACK` (";
        $sql .= "  TID MEDIUMINT(8) NOT NULL, ";
        $sql .= "  NEW_TID MEDIUMINT(8) NOT NULL, ";
        $sql .= "  CREATED DATETIME NOT NULL, ";
        $sql .= "  TRACK_TYPE TINYINT(4) NOT NULL, ";
        $sql .= "  PRIMARY KEY (TID, NEW_TID), ";
        $sql .= "  KEY NEW_TID (NEW_TID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_FOLDER` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  INTEREST TINYINT(4) NOT NULL, ";
        $sql .= "  PRIMARY KEY (UID, FID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_PEER` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  RELATIONSHIP TINYINT(4) NOT NULL, ";
        $sql .= "  PEER_NICKNAME VARCHAR(32) DEFAULT NULL, ";
        $sql .= "  PRIMARY KEY (UID, PEER_UID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_POLL_VOTES` (";
        $sql .= "  `VOTE_ID` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  `TID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `QUESTION_ID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `OPTION_ID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `UID` MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  `VOTED` DATETIME NOT NULL,";
        $sql .= "  PRIMARY KEY (`VOTE_ID`),";
        $sql .= "  KEY `TID` (`TID`),";
        $sql .= "  KEY `QUESTION_ID` (`QUESTION_ID`),";
        $sql .= "  KEY `OPTION_ID` (`OPTION_ID`),";
        $sql .= "  KEY `UID` (`UID`)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_PREFS` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  HOMEPAGE_URL VARCHAR(255) DEFAULT NULL,";
        $sql .= "  PIC_URL VARCHAR(255) DEFAULT NULL,";
        $sql .= "  EMAIL_NOTIFY CHAR(1) DEFAULT NULL,";
        $sql .= "  MARK_AS_OF_INT CHAR(1) DEFAULT NULL,";
        $sql .= "  POSTS_PER_PAGE CHAR(3) DEFAULT NULL,";
        $sql .= "  FONT_SIZE CHAR(2) DEFAULT NULL,";
        $sql .= "  STYLE VARCHAR(255) DEFAULT NULL,";
        $sql .= "  EMOTICONS VARCHAR(255) DEFAULT NULL,";
        $sql .= "  VIEW_SIGS CHAR(1) DEFAULT NULL,";
        $sql .= "  START_PAGE CHAR(3) DEFAULT NULL,";
        $sql .= "  LANGUAGE VARCHAR(32) DEFAULT NULL,";
        $sql .= "  SHOW_STATS CHAR(1) DEFAULT NULL,";
        $sql .= "  IMAGES_TO_LINKS CHAR(1) DEFAULT NULL,";
        $sql .= "  USE_WORD_FILTER CHAR(1) DEFAULT NULL,";
        $sql .= "  USE_ADMIN_FILTER CHAR(1) DEFAULT NULL,";
        $sql .= "  SHOW_THUMBS CHAR(2) DEFAULT NULL,";
        $sql .= "  ENABLE_WIKI_WORDS CHAR(1) DEFAULT NULL,";
        $sql .= "  ENABLE_WIKI_QUICK_LINKS CHAR(1) DEFAULT NULL,";
        $sql .= "  USE_MOVER_SPOILER CHAR(1) DEFAULT NULL,";
        $sql .= "  USE_LIGHT_MODE_SPOILER CHAR(1) DEFAULT NULL,";
        $sql .= "  USE_OVERFLOW_RESIZE CHAR(1) DEFAULT NULL,";
        $sql .= "  PIC_AID MEDIUMINT(11) DEFAULT NULL,";
        $sql .= "  AVATAR_URL VARCHAR(255) DEFAULT NULL,";
        $sql .= "  AVATAR_AID MEDIUMINT(11) DEFAULT NULL,";
        $sql .= "  REPLY_QUICK CHAR(1) DEFAULT NULL,";
        $sql .= "  THREADS_BY_FOLDER CHAR(1) DEFAULT NULL,";
        $sql .= "  THREAD_LAST_PAGE CHAR(1) DEFAULT NULL,";
        $sql .= "  LEFT_FRAME_WIDTH SMALLINT(4) UNSIGNED DEFAULT NULL,";
        $sql .= "  SHOW_AVATARS CHAR(1) DEFAULT NULL,";
        $sql .= "  SHOW_SHARE_LINKS CHAR(1) DEFAULT NULL,";
        $sql .= "  ENABLE_TAGS CHAR(1) DEFAULT NULL,";
        $sql .= "  AUTO_SCROLL_MESSAGES CHAR(1) DEFAULT NULL,";
        $sql .= "  PRIMARY KEY (UID)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=utf8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_PROFILE` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  ENTRY VARCHAR(255) DEFAULT NULL,";
        $sql .= "  PRIVACY TINYINT(3) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY  (UID,PIID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_SIG` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  CONTENT TEXT,";
        $sql .= "  PRIMARY KEY  (UID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_THREAD` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  LAST_READ MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  LAST_READ_AT DATETIME NOT NULL,";
        $sql .= "  INTEREST TINYINT(4) NOT NULL DEFAULT '0',";
        $sql .= "  PRIMARY KEY  (UID,TID),";
        $sql .= "  KEY TID (TID),";
        $sql .= "  KEY LAST_READ (LAST_READ),";
        $sql .= "  KEY INTEREST (INTEREST)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}USER_TRACK` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  USER_KEY VARCHAR(255) NOT NULL,";
        $sql .= "  USER_VALUE TEXT DEFAULT NULL,";
        $sql .= "  PRIMARY KEY  (UID, USER_KEY)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "CREATE TABLE `{$forum_table_prefix}WORD_FILTER` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
        $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
        $sql .= "  FILTER_NAME VARCHAR(255) NOT NULL, ";
        $sql .= "  MATCH_TEXT TEXT NOT NULL, ";
        $sql .= "  REPLACE_TEXT TEXT NOT NULL, ";
        $sql .= "  FILTER_TYPE TINYINT(3) UNSIGNED NOT NULL, ";
        $sql .= "  FILTER_ENABLED TINYINT(3) UNSIGNED NOT NULL, ";
        $sql .= "  PRIMARY KEY (UID, FID)";
        $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        $db->query($sql);

        // Save Webtag, Database name and Access Level.
        $sql = "INSERT INTO FORUMS (WEBTAG, OWNER_UID, DATABASE_NAME, ACCESS_LEVEL) ";
        $sql .= "VALUES ('$webtag', '$owner_uid', '$database_name', $access)";

        $db->query($sql);

        // Get the new FID so we can save the settings
        if (!$forum_fid = $db->insert_id) {
            throw new Exception('Failed to get new forum fid');
        }

        // Create General Folder
        $sql = "INSERT INTO `{$forum_table_prefix}FOLDER` (TITLE, CREATED, MODIFIED, ALLOWED_TYPES, POSITION, PERM) ";
        $sql .= "VALUES ('General', NOW(), NOW(), 3, 1, 14588)";

        $db->query($sql);

        // Add some default forum links
        $sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POSITION, TITLE, URI) ";
        $sql .= "VALUES (2, 'Project Beehive Forum Home', 'http://www.beehiveforum.co.uk/')";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POSITION, TITLE, URI) ";
        $sql .= "VALUES (3, 'Project Beehive Forum on Facebook', 'http://www.facebook.com/beehiveforum')";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POSITION, TITLE, URI) ";
        $sql .= "VALUES (3, 'Project Beehive Forum on Twitter', 'https://twitter.com/beehiveforum')";

        $db->query($sql);

        $sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POSITION, TITLE, URI) ";
        $sql .= "VALUES (2, 'Teh Forum', 'http://www.tehforum.co.uk/forum/')";

        $db->query($sql);

        // Create user permissions for forum leader
        if (!perm_update_user_forum_permissions($owner_uid, $forum_fid, USER_PERM_ADMIN_TOOLS | USER_PERM_FOLDER_MODERATE)) {
            throw new Exception('Failed to set owner forum permissions');
        }

        // Create 'Welcome' Thread
        $sql = "INSERT INTO `{$forum_table_prefix}THREAD` (FID, BY_UID, TITLE, LENGTH, POLL_FLAG, ";
        $sql .= "APPROVED, APPROVED_BY, CREATED, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
        $sql .= "VALUES (1, '$owner_uid', 'Welcome', 1, 'N', CAST('$current_datetime' AS DATETIME), ";
        $sql .= "'$owner_uid', CAST('$current_datetime' AS DATETIME), CAST('$current_datetime' AS DATETIME), ";
        $sql .= "NULL, 'N', NULL, NULL)";

        $db->query($sql);

        // Get the Thread ID. It should be 1, but just in case.
        if (!$new_tid = $db->insert_id) {
            throw new Exception('Failed to get first thread tid');
        }

        // Create the first post in the thread. Make it appear to be from
        // the Owner UID.
        $sql = "INSERT INTO `{$forum_table_prefix}POST` (TID, REPLY_TO_PID, FROM_UID, ";
        $sql .= "CREATED, APPROVED, APPROVED_BY, EDITED, EDITED_BY, IPADDRESS) ";
        $sql .= "VALUES ('$new_tid', 0, $owner_uid, CAST('$current_datetime' AS DATETIME), ";
        $sql .= "CAST('$current_datetime' AS DATETIME), '$owner_uid', NULL, NULL, '$ipaddress')";

        $db->query($sql);

        // Get the Post ID. Again should be 1, but trying to be tidy here.
        if (!$new_pid = $db->insert_id) {
            throw new Exception('Fauled to fetch new post pid');
        }

        // First Post content.
        $sql = "INSERT INTO `{$forum_table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
        $sql .= "VALUES ('$new_tid', '$new_pid', 'Welcome to your new Beehive Forum')";

        $db->query($sql);

        // First Post search ID
        $sql = "INSERT INTO `{$forum_table_prefix}POST_SEARCH_ID` (TID, PID) ";
        $sql .= "VALUES ('$new_tid', '$new_pid')";

        $db->query($sql);

        // Create Top Level Links Folder
        $sql = "INSERT INTO `{$forum_table_prefix}LINKS_FOLDERS` ";
        $sql .= "(PARENT_FID, NAME, VISIBLE) VALUES (NULL, 'Top Level', 'Y')";

        $db->query($sql);

        $forum_settings = array(
            'wiki_integration_uri' => 'http://en.wikipedia.org/wiki/[WikiWord]',
            'enable_wiki_quick_links' => 'Y',
            'enable_wiki_integration' => 'N',
            'minimum_post_frequency' => '0',
            'maximum_post_length' => '6226',
            'post_edit_time' => '0',
            'allow_post_editing' => 'Y',
            'forum_dl_saving' => 'Y',
            'forum_timezone' => '27',
            'default_language' => 'en_GB',
            'default_emoticons' => 'default',
            'default_style' => 'default',
            'forum_keywords' => 'A Beehive Forum, Beehive Forum, Project Beehive Forum',
            'forum_desc' => 'A Beehive Forum',
            'forum_email' => 'admin@beehiveforum.co.uk',
            'forum_name' => $forum_name,
            'show_links' => 'Y',
            'allow_polls' => 'Y',
            'show_stats' => 'Y',
            'allow_search_spidering' => 'Y',
            'guest_account_enabled' => 'Y',
            'forum_links_top_link' => 'Forum Links:'
        );

        foreach ($forum_settings as $setting_name => $setting_value) {

            $setting_name = $db->escape($setting_name);
            $setting_value = $db->escape($setting_value);

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql .= "VALUES ($forum_fid, '$setting_name', '$setting_value')";

            $db->query($sql);
        }

        // Make sure at least the current user can
        // access the forum even if its not protected.
        $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) VALUES('$owner_uid', $forum_fid, 1)";

        $db->query($sql);

    } catch (Exception $e) {

        $error_str = $e->getMessage();

        if ($delete_tables_on_error) {
            forum_delete_tables($webtag, $database_name);
        }

        return false;
    }

    return $forum_fid;
}

function forum_update($fid, $forum_name, $owner_uid, $access_level)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!is_numeric($owner_uid) || $owner_uid < 1) return false;

    if (!is_numeric($access_level)) return false;

    $forum_name = $db->escape($forum_name);

    if (!session::check_perm(USER_PERM_FORUM_TOOLS, 0)) return false;

    $sql = "UPDATE LOW_PRIORITY FORUMS SET ACCESS_LEVEL = '$access_level', ";
    $sql .= "OWNER_UID = '$owner_uid' WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "INSERT IGNORE INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
    $sql .= "VALUES ('$fid', 'forum_name', '$forum_name') ";
    $sql .= "ON DUPLICATE KEY UPDATE SVALUE = VALUES(SVALUE)";

    if (!$db->query($sql)) return false;

    return true;
}

function forum_delete($fid)
{
    if (!session::check_perm(USER_PERM_FORUM_TOOLS, 0)) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT WEBTAG, DATABASE_NAME FROM FORUMS WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($webtag, $database_name) = $result->fetch_row();

    $sql = "DELETE QUICK FROM FORUMS WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM FORUM_SETTINGS WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM SEARCH_RESULTS WHERE FORUM = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM VISITOR_LOG WHERE FORUM = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM POST_ATTACHMENT_FILES ";
    $sql .= "WHERE AID IN (SELECT AID FROM POST_ATTACHMENT_IDS ";
    $sql .= "WHERE FID = '$fid')";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM POST_ATTACHMENT_IDS WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM USER_PERM WHERE FORUM = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM GROUPS WHERE FORUM = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM GROUP_USERS WHERE GID NOT IN (SELECT GID FROM GROUPS)";

    if (!$db->query($sql)) return false;

    $sql = "DELETE QUICK FROM GROUP_PERMS WHERE GID NOT IN (SELECT GID FROM GROUPS)";

    if (!$db->query($sql)) return false;

    if (!forum_delete_tables($webtag, $database_name)) return false;

    return true;
}

function forum_delete_tables($webtag, $database_name)
{
    if (!preg_match("/^[A-Z0-9_]+$/Du", $webtag)) return false;

    if (!preg_match("/^[A-Z0-9_]+$/Diu", $database_name)) return false;

    if (!$db = db::get()) return false;

    $forum_table_prefix = install_format_table_prefix($database_name, $webtag);

    $table_array = array(
        'ADMIN_LOG',
        'BANNED',
        'FOLDER',
        'FORUM_LINKS',
        'LINKS',
        'LINKS_COMMENT',
        'LINKS_FOLDERS',
        'LINKS_VOTE',
        'POLL',
        'POLL_QUESTIONS',
        'POLL_VOTES',
        'POST',
        'POST_CONTENT',
        'POST_RATING',
        'POST_RECIPIENT',
        'POST_SEARCH_ID',
        'PROFILE_ITEM',
        'PROFILE_SECTION',
        'RSS_FEEDS',
        'RSS_HISTORY',
        'STATS',
        'THREAD',
        'THREAD_STATS',
        'THREAD_TRACK',
        'USER_FOLDER',
        'USER_PEER',
        'USER_POLL_VOTES',
        'USER_PREFS',
        'USER_PROFILE',
        'USER_SIG',
        'USER_THREAD',
        'USER_TRACK',
        'WORD_FILTER'
    );

    foreach ($table_array as $table_name) {

        $sql = "DROP TABLE IF EXISTS `{$forum_table_prefix}{$table_name}`";
        if (!$db->query($sql)) return false;
    }

    return true;
}

function forum_update_access($fid, $access)
{
    if (!is_numeric($fid)) return false;

    if (!is_numeric($access)) return false;

    if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0) ||
        session::check_perm(USER_PERM_FORUM_TOOLS, 0))
    ) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!$db = db::get()) return false;

    $sql = "UPDATE LOW_PRIORITY FORUMS SET ACCESS_LEVEL = '$access' ";
    $sql .= "WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', '$fid', 1) ON DUPLICATE KEY ";
    $sql .= "UPDATE ALLOWED = VALUES(ALLOWED)";

    if (!$db->query($sql)) return false;

    return true;
}

function forum_update_password($fid, $password)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0) ||
        session::check_perm(USER_PERM_FORUM_TOOLS, 0))
    ) return false;

    $password = $db->escape(md5($password));

    $sql = "UPDATE LOW_PRIORITY FORUMS SET FORUM_PASSWD = '$password' ";
    $sql .= "WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    return true;
}

function forum_get($fid)
{
    if (!is_numeric($fid)) return false;

    if (!session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT FID, WEBTAG, OWNER_UID, DATABASE_NAME, DEFAULT_FORUM, ";
    $sql .= "ACCESS_LEVEL, FORUM_PASSWD FROM FORUMS WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $forum_get_array = $result->fetch_assoc();

    $forum_get_array['FORUM_SETTINGS'] = array();

    if (isset($forum_get_array['OWNER_UID']) && $forum_get_array['OWNER_UID'] > 0) {

        if (($forum_leader = user_get_logon($forum_get_array['OWNER_UID'])) !== false) {
            $forum_get_array['FORUM_SETTINGS']['forum_leader'] = $forum_leader;
        }
    }

    $sql = "SELECT SNAME, SVALUE FROM FORUM_SETTINGS WHERE FID = '$fid'";

    if (!($result = $db->query($sql))) return false;

    while (($forum_data = $result->fetch_assoc()) !== null) {
        $forum_get_array['FORUM_SETTINGS'][$forum_data['SNAME']] = $forum_data['SVALUE'];
    }

    return $forum_get_array;
}

function forum_get_permissions($fid, $page = 1)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($fid)) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 20);

    $perms_user_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME FROM USER USER ";
    $sql .= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID) ";
    $sql .= "WHERE USER_FORUM.FID = '$fid' AND USER_FORUM.ALLOWED = 1 ";
    $sql .= "LIMIT $offset, 20";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($perms_user_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($perms_user_count > 0) && ($page > 1)) {
        return forum_get_permissions($fid, $page - 1);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        $perms_user_array[] = $user_data;
    }

    return array(
        'user_count' => $perms_user_count,
        'user_array' => $perms_user_array
    );
}

function forum_get_default()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT WEBTAG FROM FORUMS WHERE DEFAULT_FORUM = 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($webtag) = $result->fetch_row();

    return $webtag;
}

function forum_update_default($fid)
{
    if (!is_numeric($fid)) return false;

    if (!$db = db::get()) return false;

    $sql = "UPDATE LOW_PRIORITY FORUMS SET DEFAULT_FORUM = 0";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY FORUMS SET DEFAULT_FORUM = 1 WHERE FID = '$fid'";

    if (!$db->query($sql)) return false;

    return true;
}

function forum_search_array_clean($forum_search)
{
    return db::get()->escape(trim(str_replace("%", "", $forum_search)));
}

function forum_search($forum_search, $page, $sort_by, $sort_dir)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page)) return false;

    $offset = calculate_page_offset($page, 10);

    $sort_by_array = array(
        'FORUM_NAME',
        'FORUM_DESC',
        'LAST_VISIT'
    );

    $sort_dir_array = array(
        'ASC',
        'DESC'
    );

    if (!in_array($sort_by, $sort_by_array)) $sort_by = 'LAST_VISIT';

    if (!in_array($sort_dir, $sort_dir_array)) $sort_dir = 'DESC';

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (strlen(trim($forum_search)) == 0) return false;

    $forums_array = array();

    $forum_search_array = preg_split('/,\s*/u', trim($forum_search, ', '));
    $forum_search_array = array_map('forum_search_array_clean', $forum_search_array);

    $forum_search_webtag = implode("%' OR FORUMS.WEBTAG LIKE '%", $forum_search_array);
    $forum_search_svalue = implode("%' OR FORUM_SETTINGS.SVALUE LIKE '%", $forum_search_array);

    $sql = "SELECT SQL_CALC_FOUND_ROWS CONCAT(FORUMS.DATABASE_NAME, '`.`', FORUMS.WEBTAG, '_') AS PREFIX, ";
    $sql .= "FORUM_SETTINGS_NAME.SVALUE AS FORUM_NAME, FORUM_SETTINGS_DESC.SVALUE AS FORUM_DESC, ";
    $sql .= "FORUMS.FID, FORUMS.WEBTAG, FORUMS.ACCESS_LEVEL, USER_FORUM.INTEREST FROM FORUMS ";
    $sql .= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID) ";
    $sql .= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_NAME ON (FORUM_SETTINGS_NAME.FID = FORUMS.FID AND FORUM_SETTINGS_NAME.SNAME = 'forum_name') ";
    $sql .= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS_DESC ON (FORUM_SETTINGS_DESC.FID = FORUMS.FID AND FORUM_SETTINGS_DESC.SNAME = 'forum_desc') ";
    $sql .= "LEFT JOIN USER_FORUM ON (USER_FORUM.FID = FORUMS.FID AND USER_FORUM.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE FORUMS.ACCESS_LEVEL > -1 AND (FORUMS.WEBTAG LIKE ";
    $sql .= "'%$forum_search_webtag%' OR FORUM_SETTINGS.SVALUE LIKE ";
    $sql .= "'%$forum_search_svalue%') GROUP BY FORUMS.FID ";
    $sql .= "ORDER BY $sort_by $sort_dir LIMIT $offset, 10";

    if (!($result_forums = $db->query($sql))) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($forums_count) = $result_count->fetch_row();

    if (($result_forums->num_rows == 0) && ($forums_count > 0) && ($page > 1)) {
        return forum_search($forum_search, $page - 1, $sort_by, $sort_dir);
    }

    while (($forum_data = $result_forums->fetch_assoc()) !== null) {

        $forum_fid = $forum_data['FID'];

        // Check the forum name is set. If it isn't set it to 'A Beehive Forum'
        if (!isset($forum_data['FORUM_NAME']) || strlen(trim($forum_data['FORUM_NAME'])) < 1) {
            $forum_data['FORUM_NAME'] = "A Beehive Forum";
        }

        // Check the forum description is set.
        if (!isset($forum_data['FORUM_DESC']) || strlen(trim($forum_data['FORUM_DESC'])) < 1) {
            $forum_data['FORUM_DESC'] = "";
        }

        // Check the LAST_VISIT column to make sure its OK.
        if (!isset($forum_data['LAST_VISIT']) || is_null($forum_data['LAST_VISIT'])) {
            $forum_data['LAST_VISIT'] = 0;
        }

        // Unread cut-off stamp.
        $unread_cutoff_datetime = forum_get_unread_cutoff_datetime();

        // Get available folders for queries below
        $folders = folder_get_available_by_forum($forum_fid);

        // Get any unread messages
        if ($unread_cutoff_datetime !== false) {

            $sql = "SELECT SUM(THREAD.LENGTH) - SUM(COALESCE(USER_THREAD.LAST_READ, 0)) AS UNREAD_MESSAGES ";
            $sql .= "FROM `{$forum_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$forum_data['PREFIX']}USER_THREAD` USER_THREAD ";
            $sql .= "ON (USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = '{$_SESSION['UID']}') WHERE THREAD.FID IN ($folders) ";
            $sql .= "AND (THREAD.MODIFIED > CAST('$unread_cutoff_datetime' AS DATETIME)) ";

            if (!($result_unread_count = $db->query($sql))) return false;

            list($unread_messages) = $result_unread_count->fetch_row();

            $forum_data['UNREAD_MESSAGES'] = $unread_messages;

        } else {

            $forum_data['UNREAD_MESSAGES'] = 0;
        }

        // Total number of messages
        $sql = "SELECT SUM(THREAD.LENGTH) AS NUM_MESSAGES FROM `{$forum_data['PREFIX']}THREAD` THREAD ";
        $sql .= "WHERE THREAD.FID IN ($folders) ";

        if (!($result_messages_count = $db->query($sql))) return false;

        $num_messages_data = $result_messages_count->fetch_assoc();

        if (!isset($num_messages_data['NUM_MESSAGES']) || is_null($num_messages_data['NUM_MESSAGES'])) {
            $forum_data['NUM_MESSAGES'] = 0;
        } else {
            $forum_data['NUM_MESSAGES'] = $num_messages_data['NUM_MESSAGES'];
        }

        // Get unread to me message count
        $sql = "SELECT COUNT(POST.PID) AS UNREAD_TO_ME FROM `{$forum_data['PREFIX']}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$forum_data['PREFIX']}POST` POST ON (POST.TID = THREAD.TID) ";
        $sql .= "LEFT JOIN `{$forum_data['PREFIX']}POST_RECIPIENT` POST_RECIPIENT ";
        $sql .= "ON (POST_RECIPIENT.TID = POST.TID AND POST_RECIPIENT.PID = POST.PID) ";
        $sql .= "WHERE THREAD.FID IN ($folders) AND POST_RECIPIENT.TO_UID = '{$_SESSION['UID']}' ";
        $sql .= "AND POST_RECIPIENT.VIEWED IS NULL ";

        if (!($result_unread_to_me = $db->query($sql))) return false;

        $forum_unread_post_data = $result_unread_to_me->fetch_assoc();

        if (!isset($forum_unread_post_data['UNREAD_TO_ME']) || is_null($forum_unread_post_data['UNREAD_TO_ME'])) {
            $forum_data['UNREAD_TO_ME'] = 0;
        } else {
            $forum_data['UNREAD_TO_ME'] = $forum_unread_post_data['UNREAD_TO_ME'];
        }

        // Sometimes the USER_THREAD table might have a higher count that the thread
        // length due to table corruption. I've only seen this on the SF provided
        // webspace but none the less we do this check here anyway.
        if ($forum_data['NUM_MESSAGES'] < 0) $forum_data['NUM_MESSAGES'] = 0;
        if ($forum_data['UNREAD_MESSAGES'] < 0) $forum_data['UNREAD_MESSAGES'] = 0;
        if ($forum_data['UNREAD_TO_ME'] < 0) $forum_data['UNREAD_TO_ME'] = 0;

        $forums_array[] = $forum_data;
    }

    return array(
        'forums_array' => $forums_array,
        'forums_count' => $forums_count
    );
}

function forum_get_all_prefixes()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT CONCAT(DATABASE_NAME, '`.`', WEBTAG, '_') AS PREFIX, ";
    $sql .= "FID FROM FORUMS ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $prefix_array = array();

    while (($forum_data = $result->fetch_assoc()) !== null) {
        $prefix_array[$forum_data['FID']] = $forum_data['PREFIX'];
    }

    return $prefix_array;
}

function forum_get_all_webtags()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT FID, WEBTAG FROM FORUMS ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $webtag_array = array();

    while (($forum_data = $result->fetch_assoc()) !== null) {
        $webtag_array[$forum_data['FID']] = $forum_data['WEBTAG'];
    }

    return $webtag_array;
}

function forum_get_all_fids()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT FID FROM FORUMS";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $fids_array = array();

    while (($forum_data = $result->fetch_assoc()) !== null) {
        $fids_array[] = $forum_data['FID'];
    }

    return $fids_array;
}

function forum_get_last_visit($uid)
{
    if ($uid == 0) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT UNIX_TIMESTAMP(LAST_VISIT) FROM USER_FORUM ";
    $sql .= "WHERE USER_FORUM.FID = $forum_fid AND USER_FORUM.UID = $uid";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($last_visit) = $result->fetch_row();

    return $last_visit;
}

function forum_update_last_visit($uid)
{
    if ($uid == 0) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "INSERT INTO USER_FORUM (UID, FID, LAST_VISIT) ";
    $sql .= "VALUES ('$uid', '$forum_fid', CAST('$current_datetime' AS DATETIME)) ";
    $sql .= "ON DUPLICATE KEY UPDATE LAST_VISIT = VALUES(LAST_VISIT)";

    if (!$db->query($sql)) return false;

    return true;
}

function forums_get_available_dbs()
{
    if (!$db = db::get()) return false;

    $sql = "SHOW DATABASES";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $database_array = array();

    while (($database = $result->fetch_assoc()) !== null) {

        if (!stristr('information_schema', $database['Database'])) {
            $database_array[$database['Database']] = $database['Database'];
        }
    }

    return $database_array;
}

function forums_get_available_count()
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT COUNT(FORUMS.FID) FROM FORUMS FORUMS ";
    $sql .= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID ";
    $sql .= "AND USER_FORUM.UID = '{$_SESSION['UID']}') WHERE FORUMS.ACCESS_LEVEL = 0 ";
    $sql .= "OR FORUMS.ACCESS_LEVEL = 2 OR (FORUMS.ACCESS_LEVEL = 1 ";
    $sql .= "AND USER_FORUM.ALLOWED = 1) ";

    if (!($result = $db->query($sql))) return false;

    list($forum_available_count) = $result->fetch_row();

    return $forum_available_count;
}

function forum_get_content_delivery_path($file_path)
{
    static $content_delivery_domain_index = -1;
    static $content_delivery_domains_array = false;
    static $content_delivery_files_array = array();

    if (!is_array($content_delivery_domains_array)) {

        $content_delivery_domains_array = explode("\n", forum_get_setting('content_delivery_domains'));
        $content_delivery_domains_array = array_map('trim', $content_delivery_domains_array);
        $content_delivery_domains_array = array_values(array_filter($content_delivery_domains_array));
    }

    if (sizeof($content_delivery_domains_array) < 1) return false;

    if (isset($content_delivery_files_array[$file_path])) {
        return $content_delivery_files_array[$file_path];
    }

    $content_delivery_domain_index++;

    if (isset($content_delivery_domains_array[$content_delivery_domain_index])) {

        $content_delivery_files_array[$file_path] = $content_delivery_domains_array[$content_delivery_domain_index];
        return preg_replace('/^http(s)?:\/\//', '', $content_delivery_files_array[$file_path]);
    }

    $content_delivery_domain_index = -1;

    return forum_get_content_delivery_path($file_path);
}

function forum_self_clean_check_ajax()
{
    if (isset($_SERVER['PHP_SELF']) && strlen(trim($_SERVER['PHP_SELF'])) > 0) {

        $script_filename = basename(trim($_SERVER['PHP_SELF']));
        if (in_array($script_filename, array('ajax.php', 'json.php'))) return false;
    }

    return true;
}

function forum_check_maintenance()
{
    $forum_maintenance_functions_array = array(
        'pm_system_prune_folders',
        'thread_auto_prune_unread_data',
        'sitemap_create_file'
    );

    $new_forum_settings = array();

    if (!forum_self_clean_check_ajax()) return;

    $forum_maintenance_hour = forum_get_setting('forum_maintenance_hour', 'is_numeric', 3);

    $forum_maintenance_duration = forum_get_setting('forum_maintenance_duration', 'is_numeric', 1);

    $forum_maintenance_function = forum_get_setting('forum_maintenance_function', 'is_numeric', 0);

    $forum_maintenance_function++;

    if (!isset($forum_maintenance_functions_array[$forum_maintenance_function])) {
        $forum_maintenance_function = 0;
    }

    $forum_maintenance_date_var = sprintf("%s_last_run", $forum_maintenance_functions_array[$forum_maintenance_function]);

    $forum_maintenance_last_run = forum_get_setting($forum_maintenance_date_var, 'is_numeric', 0);

    if (((time() - $forum_maintenance_last_run) < DAY_IN_SECONDS)) return;

    if ((time() < mktime($forum_maintenance_hour))) return;

    if ((time() > mktime($forum_maintenance_hour + $forum_maintenance_duration))) return;

    if (!function_exists($forum_maintenance_functions_array[$forum_maintenance_function])) return;

    ignore_user_abort(true);

    $forum_maintenance_functions_array[$forum_maintenance_function]();

    $new_forum_settings[$forum_maintenance_date_var] = time();

    $new_forum_settings['forum_maintenance_function'] = $forum_maintenance_function;

    forum_save_global_settings($new_forum_settings);
}