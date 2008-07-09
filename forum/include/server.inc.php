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

/* $Id: server.inc.php,v 1.26 2008-07-09 19:35:27 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");

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
* Fetches the system temp dir
*
* @return string
* @param void
*/

function system_get_temp_dir()
{
    $env_array = array_merge($_ENV, $_SERVER);

    if (function_exists('sys_get_temp_dir')) {

        return sys_get_temp_dir();

    }elseif (isset($env_array['TEMP']) && is_dir($env_array['TEMP'])) {

        return $env_array['TEMP'];

    }elseif (isset($env_array['TMP']) && is_dir($env_array['TMP'])) {

        return $env_array['TMP'];

    }elseif (isset($env_array['TMPDIR']) && is_dir($env_array['TMPDIR'])) {

        return $env_array['TMPDIR'];

    }elseif (file_exists('/tmp/') && is_dir('/tmp/')) {

        return '/tmp/';

    }elseif ($temp_file = tempnam(md5(uniqid(mt_rand())), '')) {

        unlink($temp_file);
        return realpath(dirname($temp_file));
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
* @return string
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

/**
* Fetch a list of files accessible from 'Admin' section.
*
* Returns an array of Beehive Forum PHP files (forum path only)
*
* @return string
* @param void
*/

function get_available_admin_files()
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
                 'admin_wordfilter.php');
}

/**
* Fetch a list of files accessible from 'My Controls' section.
*
* Returns an array of Beehive Forum PHP files (forum path only)
*
* @return string
* @param void
*/

function get_available_user_control_files()
{
    return array('edit_prefs.php', 'edit_profile.php', 'edit_password.php',
                 'edit_email.php', 'forum_options.php', 'pm_options.php',
                 'edit_attachments.php', 'edit_signature.php', 'edit_relations.php',
                 'edit_wordfilter.php', 'edit_subscriptions.php');
}

/**
* Fetch a list of files accessible from 'My Controls' section.
*
* Returns a regular expression to match Beehive's available popups URLs.
*
* @return string
* @param void
*/

function get_available_popup_files_preg()
{
    return implode("|^", array('^attachments\.php', '^dictionary\.php',
                               '^display_emoticons\.php', '^edit_attachments\.php.+popup=1',
                               '^email\.php', '^mods_list\.php',
                               '^poll_results\.php', '^search_popup\.php',
                               '^search\.php.+show_stop_words=true', '^user_profile\.php'));
}

/**
* Create a directory structure from a path.
*
* Checks for the existance of a directory structure and creates the path
* if it doesn't exist.
*
* @return boolean
* @param string $pathname - Path to create
* @param integer $mode - Mode (chmod) of the directory.
*/

function mkdir_recursive($pathname, $mode)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
    return is_dir($pathname) || @mkdir($pathname, $mode);
}

/**
* Recursive directory removal.
*
* Removes a directory and all the files it contains.
*
* @return boolean
* @param string $pathname - Path to create
*/

function rmdir_recursive($path)
{
    $path = rtrim($path, '/');

    if (@$dir = opendir($path)) {

        while(($file = readdir($dir)) !== false) {

            if (is_file("$path/$file") && !is_link("$path/$file")) {

                unlink("$path/$file");

            }elseif (is_dir("$path/$file") && $file != '.' && $file != '..') {

                rmdir_recursive("$path/$file");
            }
        }

        closedir($dir);
    }

    @rmdir($path);
}

/**
* Prepares a path for use in a URL.
*
* Prepare a path for use in a URL. Converts backslashes to forward slashes
* and removes trailing slash. Doesn't valid the path.
*
* @return boolean
* @param string $pathname - Path to prepare.
*/

function prepare_path_for_url($pathname)
{
    $pathname = preg_replace('/\\\/', '/', $pathname);
    return rtrim($pathname, '/');
}

// Executed by every script that includes server.inc.php.
// This crudely disables PHP's register_globals functionality.

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

?>