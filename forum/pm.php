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

// Server checking functions

include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions

include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals

unregister_globals();

// Disable caching if on AOL

cache_disable_aol();

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Don't cache this page - fixes problems with Opera.

cache_disable();

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

// Guests don't have access to PM system.

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check to see if we're looking for new messages.

if (isset($_GET['check_messages'])) {

    pm_check_messages();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Available PM Folders

$available_folders = array(PM_FOLDER_INBOX, PM_FOLDER_SENT, PM_FOLDER_OUTBOX,
                           PM_FOLDER_SAVED, PM_FOLDER_DRAFTS, PM_SEARCH_RESULTS);

// Output starts here

html_draw_top('frame_set_html', 'pm_popup_disabled');

$frameset = new html_frameset_cols('pm', '280,*');

// If we're viewing a message we need to know the folder it is in.

if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];

    if (!$folder = pm_message_get_folder($mid)) $folder = PM_FOLDER_INBOX;

    if (isset($_GET['message_sent'])) {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder&amp;message_sent=true#message", html_get_frame_name('pm_messages'), 0);

    }elseif (isset($_GET['message_saved'])) {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder&amp;message_saved=true#message", html_get_frame_name('pm_messages'), 0);

    }else {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder#message", html_get_frame_name('pm_messages'), 0);
    }

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $folder = (in_array($_GET['folder'], $available_folders)) ? $_GET['folder'] : PM_FOLDER_INBOX;

    if (isset($_GET['message_sent'])) {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&amp;folder=$folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&amp;folder=$folder&message_sent=true", html_get_frame_name('pm_messages'), 0);

    }else {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&amp;folder=$folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&amp;folder=$folder", html_get_frame_name('pm_messages'), 0);
    }
}

if (isset($_GET['message_sent'])) {

    $frameset->html_frame("pm_folders.php?webtag=$webtag", html_get_frame_name('pm_folders'), 0);
    $frameset->html_frame("pm_messages.php?webtag=$webtag&message_sent=true", html_get_frame_name('pm_messages'), 0);

}else {

    $frameset->html_frame("pm_folders.php?webtag=$webtag", html_get_frame_name('pm_folders'), 0);
    $frameset->html_frame("pm_messages.php?webtag=$webtag", html_get_frame_name('pm_messages'), 0);
}

$frameset->output_html();

html_draw_bottom(true);
exit;

?>