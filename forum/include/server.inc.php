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

/* $Id: server.inc.php,v 1.9 2007-04-11 20:11:13 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

/**
* Detects server OS
*
* Checks to see if the server is running MS Windows.
*
* @return boolean
* @param void
*/

function server_os_mswin()
{
    if (defined('PHP_OS')) {

        if (stristr(PHP_OS, 'WIN') && !stristr(PHP_OS, 'DARWIN')) {

            return true;
        }
    }

    return false;
}

/**
* Fetch the current CPU load
*
* Fetches the current server CPU load. Returns a percentage on Win32 and the
* result of /proc/loadavg on *nix.
*
* @return mixed
* @param void
*/

function server_get_cpu_load()
{
    $cpu_load  = 0;
    $cpu_count = 0;

    if (server_os_mswin()) {

        if (class_exists('COM')) {

            $wmi = new COM('WinMgmts:\\\\.');
            $cpu_array = $wmi->InstancesOf('Win32_Processor');

            while ($cpu = $cpu_array->Next()) {

                $cpu_load += $cpu->LoadPercentage;
                $cpu_count++;
            }

            $cpu_load = round($cpu_load / $cpu_count, 2);

            return "$cpuload%";
        }

    }else {

        if (@file_exists('/proc/loadavg')) {

            $loadavg_data = implode('', file('/proc/loadavg'));
            list($cpu_load) = explode(' ', $loadavg_data);

            return $cpu_load;
        }
    }

    return false;
}

/**
* Fetch the system temp dir
*
* Fetches the current server CPU load. Returns a percentage on Win32 and the
* result of /proc/loadavg on *nix.
*
* @return mixed
* @param void
*/

function system_get_tmp_dir()
{
    if (isset($_ENV['TEMP']) && strlen(trim($_ENV['TEMP'])) > 0) {
        
        $system_tmp_dir = trim($_ENV['TEMP']);
        return $system_tmp_dir;

    }elseif (isset($_ENV['TMP']) && strlen(trim($_ENV['TMP'])) > 0) {
        
        $system_tmp_dir = trim($_ENV['TMP']);
        return $system_tmp_dir;
    }        

    return false;
}

/**
* Fetch the current timestamp
*
* Fetches the current timestamp as a float.
*
* @return float
* @param void
*/

function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

/**
* Fetch a list of available forum files
*
* Returns an array of Beehive Forum PHP files (forum path only)
*
* @return float
* @param void
*/

function get_available_files()
{
    return array('admin.php', 'admin_banned.php',
                 'admin_default_forum_settings.php', 'admin_folders.php',
                 'admin_folder_add.php', 'admin_folder_edit.php',
                 'admin_forums.php', 'admin_forum_access.php',
                 'admin_forum_links.php', 'admin_forum_settings.php',
                 'admin_forum_set_passwd.php', 'admin_main.php',
                 'admin_make_style.php', 'admin_menu.php',
                 'admin_post_approve.php', 'admin_post_stats.php',
                 'admin_prof_items.php', 'admin_prof_sect.php',
                 'admin_rss_feeds.php', 'admin_startpage.php',
                 'admin_user.php', 'admin_users.php',
                 'admin_user_groups.php', 'admin_user_groups_add.php',
                 'admin_user_groups_edit.php', 'admin_user_groups_edit_users.php',
                 'admin_viewlog.php', 'admin_visitor_log.php',
                 'admin_wordfilter.php', 'attachments.php',
                 'change_pw.php', 'confirm_email.php',
                 'create_poll.php', 'delete.php',
                 'dictionary.php', 'discussion.php',
                 'display.php', 'display_emoticons.php',
                 'edit.php', 'edit_attachments.php',
                 'edit_email.php', 'edit_password.php',
                 'edit_poll.php', 'edit_prefs.php',
                 'edit_profile.php', 'edit_relations.php',
                 'edit_signature.php', 'edit_subscriptions.php',
                 'edit_wordfilter.php', 'email.php',
                 'font_size.php', 'forgot_pw.php',
                 'forums.php', 'forum_options.php',
                 'forum_password.php', 'get_attachment.php',
                 'index.php', 'ldelete.php',
                 'ldisplay.php', 'ledit.php',
                 'lforums.php', 'links.php',
                 'links_add.php', 'links_detail.php',
                 'llogon.php', 'llogout.php',
                 'lmessages.php', 'logon.php',
                 'logout.php', 'lpost.php',
                 'lthread_list.php', 'messages.php',
                 'mods_list.php', 'nav.php',
                 'pm.php', 'pm_edit.php',
                 'pm_write.php', 'poll_results.php',
                 'post.php', 'register.php',
                 'search.php', 'search_index.php',
                 'search_popup.php', 'set_relation.php',
                 'start.php', 'start_left.php',
                 'start_main.php', 'start_main_sf.php',
                 'threads_rss.php', 'thread_list.php',
                 'thread_options.php', 'user.php',
                 'user_folder.php', 'user_font.php',
                 'user_main.php', 'user_menu.php',
                 'user_profile.php', 'user_rel.php',
                 'user_stats.php', 'visitor_log.php');
}

// Executed by every script that includes server.inc.php.
// This crudely disables PHP's register_globals functionality.

if (!(bool)@ini_get('register_globals')) {

    foreach ($_GET as $get_key => $get_value) {

        if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $get_key)) {
            eval("unset(\${$get_key});");
        }
    }

    foreach ($_POST as $post_key => $post_value) {

        if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $post_key)) {
            eval("unset(\${$post_key});");
        }
    }

    foreach ($_REQUEST as $request_key => $request_value) {

        if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $request_key)) {
            eval("unset(\${$request_key});");
        }
    }
}

?>