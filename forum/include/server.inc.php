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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
// End Required includes

function server_os_mswin()
{
    if (!defined('PHP_OS')) return false;

    if (stristr(PHP_OS, 'WIN') === false) return false;

    if (stristr(PHP_OS, 'DARWIN')) return false;

    return true;
}

function get_available_files()
{
    return array(
        'admin.php',
        'admin_banned.php',
        'admin_default_forum_settings.php',
        'admin_folder_add.php',
        'admin_folder_edit.php',
        'admin_folders.php',
        'admin_forum_access.php',
        'admin_forum_links.php',
        'admin_forum_set_passwd.php',
        'admin_forum_settings.php',
        'admin_forum_stats.php',
        'admin_forums.php',
        'admin_link_approve.php',
        'admin_menu.php',
        'admin_post_approve.php',
        'admin_post_stats.php',
        'admin_prof_items.php',
        'admin_prof_sect.php',
        'admin_rss_feeds.php',
        'admin_startpage.php',
        'admin_user.php',
        'admin_user_groups.php',
        'admin_user_groups_add.php',
        'admin_user_groups_edit.php',
        'admin_user_groups_edit_users.php',
        'admin_users.php',
        'admin_viewlog.php',
        'admin_visitor_log.php',
        'admin_wordfilter.php',
        'ajax.php',
        'attachments.php',
        'boot.php',
        'change_pw.php',
        'close_poll.php',
        'confirm_email.php',
        'create_poll.php',
        'delete.php',
        'discussion.php',
        'display.php',
        'display_emoticons.php',
        'edit.php',
        'edit_attachments.php',
        'edit_email.php',
        'edit_password.php',
        'edit_poll.php',
        'edit_prefs.php',
        'edit_profile.php',
        'edit_relations.php',
        'edit_signature.php',
        'edit_subscriptions.php',
        'edit_wordfilter.php',
        'email.php',
        'folder_options.php',
        'folder_subscriptions.php',
        'font_size.php',
        'forgot_pw.php',
        'forum_options.php',
        'forums.php',
        'get_attachment.php',
        'index.php',
        'json.php',
        'lboot.php',
        'ldelete.php',
        'ldisplay.php',
        'ledit.php',
        'lforums.php',
        'links.php',
        'links_add.php',
        'links_detail.php',
        'links_folder_edit.php',
        'llogon.php',
        'llogout.php',
        'lmessages.php',
        'logon.php',
        'logout.php',
        'lpm.php',
        'lpm_edit.php',
        'lpm_write.php',
        'lpost.php',
        'lsearch.php',
        'lthread_list.php',
        'messages.php',
        'mods_list.php',
        'nav.php',
        'pm.php',
        'pm_edit.php',
        'pm_export.php',
        'pm_folders.php',
        'pm_messages.php',
        'pm_options.php',
        'pm_write.php',
        'poll_results.php',
        'post.php',
        'register.php',
        'search.php',
        'search_popup.php',
        'start.php',
        'start_main.php',
        'thread_list.php',
        'thread_options.php',
        'threads_rss.php',
        'user.php',
        'user_font.php',
        'user_menu.php',
        'user_profile.php',
        'user_rel.php',
        'user_stats.php',
        'visitor_log.php',
        'chat/index.php',
    );
}

function get_available_admin_files()
{
    return array(
        'admin_banned.php',
        'admin_default_forum_settings.php',
        'admin_folder_add.php',
        'admin_folder_edit.php',
        'admin_folders.php',
        'admin_forum_access.php',
        'admin_forum_links.php',
        'admin_forum_set_passwd.php',
        'admin_forum_settings.php',
        'admin_forum_stats.php',
        'admin_forums.php',
        'admin_link_approve.php',
        'admin_menu.php',
        'admin_post_approve.php',
        'admin_post_stats.php',
        'admin_prof_items.php',
        'admin_prof_sect.php',
        'admin_rss_feeds.php',
        'admin_startpage.php',
        'admin_user.php',
        'admin_user_groups.php',
        'admin_user_groups_add.php',
        'admin_user_groups_edit.php',
        'admin_user_groups_edit_users.php',
        'admin_users.php',
        'admin_viewlog.php',
        'admin_visitor_log.php',
        'admin_wordfilter.php',
    );
}

function get_available_user_files()
{
    return array(
        'edit_attachments.php',
        'edit_email.php',
        'edit_password.php',
        'edit_prefs.php',
        'edit_profile.php',
        'edit_relations.php',
        'edit_signature.php',
        'edit_subscriptions.php',
        'edit_wordfilter.php',
        'folder_subscriptions.php',
        'forum_options.php',
        'pm_options.php',
    );
}

function get_available_popup_files()
{
    return array(
        'display_emoticons.php',
        'edit_attachments.php',
        'email.php',
        'folder_options.php',
        'mods_list.php',
        'poll_results.php',
        'search_popup.php',
        'user_profile.php',
    );
}

function get_available_support_files()
{
    return array(
        'ajax.php',
        'font_size.php',
        'json.php',
        'user_font.php',
        'user_stats.php'
    );
}

function get_forum_check_webtag_ignore_files()
{
    return array(
        'admin.php',
        'admin_default_forum_settings.php',
        'admin_forums.php',
        'admin_menu.php',
        'admin_users.php',
        'admin_user.php',
        'ajax.php',
        'edit_email.php',
        'edit_password',
        'edit_prefs',
        'forum_options.php',
        'forums.php',
        'index.php',
        'json.php',
        'lforums.php',
        'llogon.php',
        'llogout.php',
        'lpm.php',
        'lpm_edit.php',
        'lpm_write.php',
        'logon.php',
        'logout.php',
        'nav.php',
        'pm.php',
        'pm_edit.php',
        'pm_export.php',
        'pm_folders.php',
        'pm_messages.php',
        'pm_options.php',
        'pm_write.php',
        'register.php',
        'user.php',
        'user_menu.php',
    );
}

function get_guest_access_ignore_files()
{
    return array(
        'admin.php',
        'index.php',
        'forgot_pw.php',
        'forums.php',
        'lforums.php',
        'llogon.php',
        'llogout.php',
        'logon.php',
        'logout.php',
        'nav.php',
        'register.php',
    );
}

function get_forum_access_ignore_files()
{
    return array_merge(
        get_available_admin_files(),
        get_available_user_files(),
        get_forum_check_webtag_ignore_files(),
        get_available_support_files()
    );
}

function get_light_back_button_files()
{
    return array(
        'lthread_list.php',
        'lmessages.php',
        'lpm.php',
    );
}

function get_pm_popup_disabled_files()
{
    return array(
        'admin.php',
        'attachments.php',
        'change_pw.php',
        'confirm_email.php',
        'discussion.php',
        'display_emoticons.php',
        'edit_attachments.php',
        'email.php',
        'font_size.php',
        'forgot_pw.php',
        'get_attachment.php',
        'index.php',
        'mods_list.php',
        'nav.php',
        'pm.php',
        'pm_edit.php',
        'pm_folders.php',
        'pm_messages.php',
        'pm_options.php',
        'poll_results.php',
        'start.php',
        'search_popup.php',
        'threads_rss.php',
        'user.php',
        'user_font.php',
        'user_profile.php',
        'user_stats.php',
    );
}

function get_image_resize_files()
{
    return array(
        'admin_post_approve.php',
        'create_poll.php',
        'delete.php',
        'display.php',
        'edit.php',
        'edit_poll.php',
        'edit_signature.php',
        'messages.php',
        'post.php',
        'pm_write.php',
        'pm_edit.php',
        'pm_messages.php'
    );
}

function get_message_display_files()
{
    return array(
        'admin_post_approve.php',
        'create_poll.php',
        'delete.php',
        'display.php',
        'edit.php',
        'edit_poll.php',
        'edit_signature.php',
        'ldisplay.php',
        'lmessages.php',
        'lpost.php',
        'messages.php',
        'post.php',
    );
}

function get_proxy_cache_headers()
{
    return array(
        'HTTP_VIA',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'VIA',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION',
    );
}

function unregister_globals()
{
    if (!ini_get('register_globals')) return;

    $super_globals_array = array(
        '_REQUEST',
        '_SESSION',
        '_SERVER',
        '_ENV',
        '_FILES'
    );

    foreach ($super_globals_array as $super_global) {

        if (!isset($GLOBALS[$super_global]) || !is_array($GLOBALS[$super_global])) {
            continue;
        }

        foreach ($GLOBALS[$super_global] as $global_key => $global_var) {

            if ($global_var !== $GLOBALS[$global_key]) {
                continue;
            }

            unset($GLOBALS[$global_key]);
        }
    }
}

function disable_magic_quotes()
{
    if (!get_magic_quotes_gpc()) return;

    $process = array(
        &$_GET,
        &$_POST,
        &$_COOKIE,
        &$_REQUEST
    );

    foreach ($process as $index => $array) {

        foreach ($array as $key => $value) {

            unset($process[$index][$key]);

            if (is_array($value)) {

                $process[$index][stripslashes($key)] = $value;

                $process[] = & $process[$index][stripslashes($key)];

            } else {

                $process[$index][stripslashes($key)] = stripslashes($value);
            }
        }
    }
}

function set_server_protocol()
{
    if (!isset($_SERVER['SERVER_PROTOCOL']) || !in_array($_SERVER['SERVER_PROTOCOL'], array('HTTP/1.0', 'HTTP/1.1'))) {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
    }
}

function server_get_config()
{
    static $config = false;

    if (!$config) {

        if (@file_exists(BH_INCLUDE_PATH . 'config.inc.php')) {

            require_once BH_INCLUDE_PATH . 'config.inc.php';

            if (@file_exists(BH_INCLUDE_PATH . "config-dev.inc.php")) {
                require_once BH_INCLUDE_PATH . 'config-dev.inc.php';
            }

            $config = get_defined_vars();

            unset($config['config']);
        }
    }

    return $config;
}

function server_get_forum_path()
{
    if (defined('BH_FORUM_PATH')) {
        return rtrim(BH_FORUM_PATH, '/');
    }

    return rtrim(dirname($_SERVER['PHP_SELF']), '/');
}