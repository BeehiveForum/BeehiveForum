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
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

// Don't cache this page - fixes problems with Opera.
cache_disable();

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages
$error_msg_array = array();

// Available PM Folders
$available_folders = array(
    PM_FOLDER_INBOX,
    PM_FOLDER_SENT,
    PM_FOLDER_OUTBOX,
    PM_FOLDER_SAVED,
    PM_FOLDER_DRAFTS,
    PM_SEARCH_RESULTS
);

// Default to Inbox
$current_folder = PM_FOLDER_INBOX;

// Get the user's saved left frame width.
if (isset($_SESSION['LEFT_FRAME_WIDTH']) && is_numeric($_SESSION['LEFT_FRAME_WIDTH'])) {
    $left_frame_width = max(100, intval($_SESSION['LEFT_FRAME_WIDTH']));
} else {
    $left_frame_width = 280;
}

// Output starts here
html_draw_top(
    array(
        'frame_set_html' => true,
        'pm_popup_disabled' => true
    )
);

$frameset = new html_frameset_cols('pm', "$left_frame_width,*");

// If we're viewing a message we need to know the folder it is in.
if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = intval($_GET['mid']);

    if (($message_data = pm_message_get($mid))) {

        if (($message_folder = pm_get_type_folder($message_data['TYPE']))) {

            $current_folder = $message_folder;
        }
    }

    if (isset($_GET['message_sent'])) {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&mid=$mid&folder=$current_folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&message_sent=true#message", html_get_frame_name('pm_messages'), 0);

    } else if (isset($_GET['message_saved'])) {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&mid=$mid&folder=$current_folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&message_saved=true#message", html_get_frame_name('pm_messages'), 0);

    } else {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&mid=$mid&folder=$current_folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder#message", html_get_frame_name('pm_messages'), 0);
    }

} else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $current_folder = (in_array($_GET['folder'], $available_folders)) ? intval($_GET['folder']) : PM_FOLDER_INBOX;

    if (isset($_GET['message_sent'])) {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&folder=$current_folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&folder=$current_folder&message_sent=true", html_get_frame_name('pm_messages'), 0);

    } else {

        $frameset->html_frame("pm_folders.php?webtag=$webtag&folder=$current_folder", html_get_frame_name('pm_folders'), 0);
        $frameset->html_frame("pm_messages.php?webtag=$webtag&folder=$current_folder", html_get_frame_name('pm_messages'), 0);
    }
}

if (isset($_GET['message_sent'])) {

    $frameset->html_frame("pm_folders.php?webtag=$webtag", html_get_frame_name('pm_folders'), 0);
    $frameset->html_frame("pm_messages.php?webtag=$webtag&message_sent=true", html_get_frame_name('pm_messages'), 0);

} else {

    $frameset->html_frame("pm_folders.php?webtag=$webtag", html_get_frame_name('pm_folders'), 0);
    $frameset->html_frame("pm_messages.php?webtag=$webtag", html_get_frame_name('pm_messages'), 0);
}

$frameset->output_html();

html_draw_bottom(true);