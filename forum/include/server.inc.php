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

/* $Id$ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
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

            while (($cpu = $cpu_array->Next())) {

                $cpu_load += $cpu->LoadPercentage;
                $cpu_count++;
            }

            $cpu_load = round($cpu_load / $cpu_count, 2);

            return "$cpu_load%";
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
                 'admin_forum_set_passwd.php', 'admin_forum_stats.php',
                 'admin_main.php', 'admin_make_style.php',
                 'admin_menu.php', 'admin_post_approve.php',
                 'admin_post_stats.php', 'admin_prof_items.php',
                 'admin_prof_sect.php', 'admin_rss_feeds.php',
                 'admin_startpage.php', 'admin_user.php',
                 'admin_users.php', 'admin_user_groups.php',
                 'admin_user_groups_add.php', 'admin_user_groups_edit.php',
                 'admin_user_groups_edit_users.php', 'admin_viewlog.php',
                 'admin_visitor_log.php', 'admin_wordfilter.php',
                 'attachments.php', 'change_pw.php',
                 'confirm_email.php', 'create_poll.php',
                 'delete.php', 'dictionary.php',
                 'discussion.php', 'display.php',
                 'display_emoticons.php', 'edit.php',
                 'edit_attachments.php', 'edit_email.php',
                 'edit_password.php', 'edit_poll.php',
                 'edit_prefs.php', 'edit_profile.php',
                 'edit_relations.php', 'edit_signature.php',
                 'edit_subscriptions.php', 'edit_wordfilter.php',
                 'email.php', 'folder_options.php',
                 'folder_subscriptions.php', 'font_size.php',
                 'forgot_pw.php', 'forums.php',
                 'forum_options.php', 'forum_password.php',
                 'get_attachment.php', 'index.php',
                 'ldelete.php', 'ldisplay.php',
                 'ledit.php', 'lforums.php',
                 'links.php', 'links_add.php',
                 'links_detail.php', 'links_folder_edit.php',
                 'llogon.php', 'llogout.php',
                 'lmessages.php', 'logon.php',
                 'logout.php', 'lpost.php',
                 'lthread_list.php', 'messages.php',
                 'mods_list.php', 'nav.php',
                 'pm.php', 'pm_edit.php',
                 'pm_folders.php', 'pm_messages.php',
                 'pm_options.php', 'pm_write.php',
                 'poll_results.php', 'post.php',
                 'register.php', 'search.php',
                 'search_index.php', 'search_popup.php',
                 'start.php', 'start_left.php',
                 'start_main.php', 'threads_rss.php',
                 'thread_list.php', 'thread_options.php',
                 'user.php', 'user_font.php',
                 'user_main.php', 'user_menu.php',
                 'user_profile.php', 'user_rel.php',
                 'user_stats.php', 'visitor_log.php');
}

/**
* Fetch a list of files accessible from 'Admin' section.
*
* Returns an array of Beehive Forum PHP files (forum path only)
*
* @return array
* @param void
*/

function get_available_admin_files()
{
    return array('admin_banned.php', 'admin_default_forum_settings.php',
                 'admin_folders.php', 'admin_folder_add.php',
                 'admin_folder_edit.php', 'admin_forums.php',
                 'admin_forum_access.php', 'admin_forum_links.php',
                 'admin_forum_settings.php', 'admin_forum_set_passwd.php',
                 'admin_forum_stats.php', 'admin_main.php',
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
* @return array
* @param void
*/

function get_available_user_control_files()
{
    return array('edit_prefs.php', 'edit_profile.php', 'edit_password.php',
                 'edit_email.php', 'edit_attachments.php', 'edit_signature.php',
                 'edit_relations.php', 'edit_wordfilter.php', 'edit_subscriptions.php',
                 'folder_subscriptions.php', 'forum_options.php', 'pm_options.php');
}

/**
* Fetch a list of files accessed via a Javascript popup.
*
* Returns a regular expression to match Beehive's available popups URLs.
*
* @return string
* @param void
*/

function get_available_js_popup_files_preg()
{
    $popup_files_preg_array = array('^attachments\.php', '^dictionary\.php', '^display_emoticons\.php',
                                    '^edit_attachments\.php', '^email\.php', '^folder_options\.php',
                                    '^mods_list\.php', '^poll_results\.php', '^search_popup\.php',
                                    '^search\.php.+show_stop_words=true', '^user_profile\.php');

    return implode("|", $popup_files_preg_array);
}

/**
* Fetch a list of files that handle fonts and stats support.
*
* Returns an array of Beehive Forum PHP files that are used to
* change font size, toggle stats display, etc.
*
* @return array
* @param void
*/

function get_available_support_files()
{
    return array('font_size.php', 'user_font.php', 'user_stats.php');
}

/**
* get_proxy_cache_headers
* 
* Get an array of headers used by caching proxy
* servers.
* 
* @param void
* @return array
*/
function get_proxy_cache_headers()
{
    return array('HTTP_VIA', 'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
                 'HTTP_X_FORWARDED', 'HTTP_FORWARDED', 'HTTP_CLIENT_IP',
                 'HTTP_FORWARDED_FOR_IP', 'VIA', 'X_FORWARDED_FOR',
                 'FORWARDED_FOR', 'X_FORWARDED', 'FORWARDED', 
                 'CLIENT_IP', 'FORWARDED_FOR_IP', 'HTTP_PROXY_CONNECTION');
}

/**
* Create a directory structure from a path.
*
* Checks for the existance of a directory structure and creates the path
* if it doesn't exist.
*
* @return boolean
* @param string $path_name - Path to create
* @param integer $mode - Mode (chmod) of the directory.
*/

function mkdir_recursive($path_name, $mode)
{
    if (!@is_dir(dirname($path_name))) mkdir_recursive(dirname($path_name), $mode);
    if (!@is_dir($path_name)) @mkdir($path_name, $mode);
    return @is_dir($path_name);
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

    if ((@$dir = opendir($path))) {

        while (($file = readdir($dir)) !== false) {

            if (@is_file("$path/$file") && !@is_link("$path/$file")) {

                unlink("$path/$file");

            }elseif (@is_dir("$path/$file") && $file != '.' && $file != '..') {

                rmdir_recursive("$path/$file");
            }
        }

        closedir($dir);
    }

    @rmdir($path);
}

/**
* Unregister Global variables.
*
* Undoes PHP's register_globals support by iterating through the $GLOBALS array
* and removing all REQUEST (inc. GET and POST), SESSION, SERVER, ENV, FILES.
*
* @return boolean
* @param string $pathname - Path to create
*/

function unregister_globals()
{
    if (ini_get('register_globals')) {

        $super_globals_array = array('_REQUEST', '_SESSION', '_SERVER', '_ENV', '_FILES');

        foreach ($super_globals_array as $super_global) {

            if (isset($GLOBALS[$super_global]) && is_array($GLOBALS[$super_global])) {
            
                foreach ($GLOBALS[$super_global] as $global_key => $global_var) {

                    if ($global_var === $GLOBALS[$global_key]) {

                        unset($GLOBALS[$global_key]);
                    }
                }
            }
        }
    }
}

?>