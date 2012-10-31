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

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'search.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';

// Message pane caching
cache_check_messages();

// User's UID
$uid = session::get_value('UID');

// Get the user's saved left frame width.
if (($left_frame_width = session::get_value('LEFT_FRAME_WIDTH')) === false) {
    $left_frame_width = 280;
}

// Prevent the frame width from being less than 100px
$left_frame_width = max(100, $left_frame_width);

if (!$folder_info = threads_get_folders()) {
    html_draw_error(gettext("There are no folders available."));
}

if (isset($_GET['edit_success']) && validate_msg($_GET['edit_success'])) {
    $edit_success = "&amp;edit_success={$_GET['edit_success']}";
} else {
    $edit_success = "";
}

if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {
    $delete_success = "&amp;delete_success={$_GET['delete_success']}";
} else {
    $delete_success = "";
}

if (isset($_GET['folder']) && is_numeric($_GET['folder']) && folder_is_accessible($_GET['folder'])) {

    $fid = $_GET['folder'];

    if (($msg = messages_get_most_recent($uid, $fid))) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$fid", html_get_frame_name('left'));
        $frameset->html_frame("messages.php?webtag=$webtag&amp;msg=$msg$edit_success$delete_success", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    } else {

        html_draw_error(gettext("No Messages"));
    }

} else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    html_draw_top('frame_set_html', 'pm_popup_disabled');

    $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

    $frameset->html_frame("thread_list.php?webtag=$webtag&amp;msg={$_GET['msg']}", html_get_frame_name('left'));
    $frameset->html_frame("messages.php?webtag=$webtag&amp;msg={$_GET['msg']}$edit_success$delete_success", html_get_frame_name('right'));

    $frameset->output_html();

    html_draw_bottom(true);

} else if (isset($_GET['right']) && $_GET['right'] == 'search') {

    // Guests can't use this
    if (!session::logged_in()) {

        html_guest_error();
        exit;
    }

    if (isset($_GET['search_error']) && is_numeric($_GET['search_error'])) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag", html_get_frame_name('left'));
        $frameset->html_frame("search.php?webtag=$webtag&amp;search_error={$_GET['search_error']}", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    } else {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag", html_get_frame_name('left'));
        $frameset->html_frame("search.php?webtag=$webtag", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);
    }

} else if (isset($_GET['left']) && $_GET['left'] == 'search_results') {

    // Guests can't use this
    if (!session::logged_in()) {

        html_guest_error();
        exit;
    }

    if (($search_msg = search_get_first_result_msg())) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

        $frameset->html_frame("search.php?webtag=$webtag&amp;page=1", html_get_frame_name('left'));
        $frameset->html_frame("messages.php?webtag=$webtag&amp;msg=$search_msg&amp;highlight=yes$edit_success$delete_success", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    } else {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

        $frameset->html_frame("search.php?webtag=$webtag&amp;page=1", html_get_frame_name('left'));
        $frameset->html_frame("search.php?webtag=$webtag", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);
    }

} else {

    if (($msg = messages_get_most_recent($uid))) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols('discussion', "$left_frame_width,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag&amp;msg=$msg", html_get_frame_name('left'));
        $frameset->html_frame("messages.php?webtag=$webtag&amp;msg=$msg$edit_success$delete_success", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    } else {

        html_draw_error(gettext("No Messages"));
    }
}

?>