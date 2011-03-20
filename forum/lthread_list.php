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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings
$forum_settings = forum_get_settings();

// Fetch Global Forum Settings
$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// See if we can try and logon automatically
logon_perform_auto();

// Get webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Light mode check to see if we should bounce to the logon screen.
if (html_get_cookie('logon')) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Check thread list cache
cache_check_thread_list();

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    header_redirect("lforums.php");
}

// Get the folders the user can see.
if (!($available_folders = folder_get_available_array())) {
    $available_folders = array();
}

// Are we viewing a specific folder only?
if (isset($_REQUEST['folder']) && in_array($_REQUEST['folder'], $available_folders)) {
    $folder = $_REQUEST['folder'];
} else {
    $folder = false;
}

// View offset.
if (isset($_REQUEST['start_from']) && is_numeric($_REQUEST['start_from'])) {
    $start_from = $_REQUEST['start_from'];
} else {
    $start_from = 0;
}

// View mode
if (isset($_REQUEST['thread_mode']) && is_numeric($_REQUEST['thread_mode'])) {
    $thread_mode = $_REQUEST['thread_mode'];
}

// Check that required variables are set
if (user_is_guest()) {

    // default to UID 0 if no other UID specified
    $uid = 0;

    // non-logged in users can only display "All" threads
    // or those in the past x days, since the other options
    // would be impossible
    if (!isset($thread_mode) || ($thread_mode != ALL_DISCUSSIONS && $thread_mode != TODAYS_DISCUSSIONS && $thread_mode != TWO_DAYS_BACK && $thread_mode != SEVEN_DAYS_BACK)) {
        $thread_mode = ALL_DISCUSSIONS;
    }

}else {

    $uid = session_get_value('UID');

    $threads_any_unread = threads_any_unread();

    if (isset($thread_mode) && is_numeric($thread_mode)) {

        html_set_cookie("thread_mode_{$webtag}", $thread_mode);

    }else {

        $thread_mode = html_get_cookie("thread_mode_{$webtag}", false, UNREAD_DISCUSSIONS);

        if ($thread_mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {
            $thread_mode = ALL_DISCUSSIONS;
        }
    }

    html_set_cookie("thread_mode_{$webtag}", $thread_mode);

    if (isset($_POST['mark_read_submit'])) {

        if (isset($_POST['mark_read_confirm']) && $_POST['mark_read_confirm'] == 'Y') {

            if ($_POST['mark_read_type'] == THREAD_MARK_READ_VISIBLE) {

                if (isset($_POST['mark_read_threads']) && strlen(trim(stripslashes_array($_POST['mark_read_threads']))) > 0) {

                    $thread_data = array();

                    $mark_read_threads = trim(stripslashes_array($_POST['mark_read_threads']));

                    $mark_read_threads_array = array_filter(explode(',', $mark_read_threads), 'is_numeric');

                    threads_get_unread_data($thread_data, $mark_read_threads_array);

                    if (threads_mark_read($thread_data)) {

                        header_redirect("lthread_list.php?webtag=$webtag&thread_mode=$thread_mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                        exit;

                    }else {

                        $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                        $valid = false;
                    }
                }

            }elseif ($_POST['mark_read_type'] == THREAD_MARK_READ_ALL) {

                if (threads_mark_all_read()) {

                    header_redirect("lthread_list.php?webtag=$webtag&thread_mode=$thread_mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }

            }elseif ($_POST['mark_read_type'] == THREAD_MARK_READ_FIFTY) {

                if (threads_mark_50_read()) {

                    header_redirect("lthread_list.php?webtag=$webtag&thread_mode=$thread_mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }

            }elseif ($_POST['mark_read_type'] == THREAD_MARK_READ_FOLDER && isset($folder) && is_numeric($folder)) {

                if (threads_mark_folder_read($folder)) {

                    header_redirect("lthread_list.php?webtag=$webtag&thread_mode=$thread_mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }
            }

        }else {

            unset($_POST['mark_read_submit'], $_POST['mark_read_confirm']);

            light_html_draw_top("robots=noindex,nofollow");
            light_html_display_msg($lang['confirm'], $lang['confirmmarkasread'], 'lthread_list.php', 'post', array('mark_read_submit' => $lang['confirm'], 'cancel' => $lang['cancel']), array_merge($_POST, array('mark_read_confirm' => 'Y')));
            light_html_draw_bottom();
            exit;
        }
    }
}

light_draw_thread_list($thread_mode, $folder, $start_from);

?>