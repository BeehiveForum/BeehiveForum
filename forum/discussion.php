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

/* $Id: discussion.php,v 1.130 2009-04-07 19:17:56 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Set the default timezone
date_default_timezone_set('UTC');

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

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

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Message pane caching

cache_check_messages();

// Load language file

$lang = lang::get_instance()->load(__FILE__);

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

$uid = bh_session_get_value('UID');

if (!$folder_info = threads_get_folders()) {

    html_draw_top();
    html_error_msg($lang['couldnotretrievefolderinformation']);
    html_draw_bottom();
    exit;
}
   
if (isset($_GET['edit_success']) && validate_msg($_GET['edit_success'])) {
    $edit_success = "&amp;edit_success={$_GET['edit_success']}";
}else {
    $edit_success = "";
}

if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {
    $delete_success = "&amp;delete_success={$_GET['delete_success']}";
}else {
    $delete_success = "";
}

if (isset($_GET['folder']) && is_numeric($_GET['folder']) && folder_is_accessible($_GET['folder'])) {

    $fid = $_GET['folder'];

    if (($msg = messages_get_most_recent($uid, $fid))) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols("280,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$fid", html_get_frame_name('left'));
        $frameset->html_frame("messages.php?webtag=$webtag&amp;msg=$msg$edit_success$delete_success", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    }else {

        html_draw_top();
        html_error_msg($lang['nomessages']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    html_draw_top('frame_set_html', 'pm_popup_disabled');

    $frameset = new html_frameset_cols("280,*");

    $frameset->html_frame("thread_list.php?webtag=$webtag&amp;msg={$_GET['msg']}", html_get_frame_name('left'));
    $frameset->html_frame("messages.php?webtag=$webtag&amp;msg={$_GET['msg']}$edit_success$delete_success", html_get_frame_name('right'));

    $frameset->output_html();

    html_draw_bottom(true);

}else if (isset($_GET['right']) && $_GET['right'] == 'search') {

    // Guests can't use this

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    if (isset($_GET['search_error']) && is_numeric($_GET['search_error'])) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols("280,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag", html_get_frame_name('left'));
        $frameset->html_frame("search.php?webtag=$webtag&amp;search_error={$_GET['search_error']}", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    }else {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols("280,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag", html_get_frame_name('left'));
        $frameset->html_frame("search.php?webtag=$webtag", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);
    }

}else if (isset($_GET['left']) && $_GET['left'] == 'search_results') {

    // Guests can't use this

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    if (($search_msg = search_get_first_result_msg())) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols("280,*");

        $frameset->html_frame("search.php?webtag=$webtag&amp;offset=0", html_get_frame_name('left'));
        $frameset->html_frame("messages.php?webtag=$webtag&amp;msg=$search_msg&amp;highlight=yes$edit_success$delete_success", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    }else {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols("280,*");

        $frameset->html_frame("search.php?webtag=$webtag&amp;offset=0", html_get_frame_name('left'));
        $frameset->html_frame("search.php?webtag=$webtag", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);
    }

}else {

    if (($msg = messages_get_most_recent($uid))) {

        html_draw_top('frame_set_html', 'pm_popup_disabled');

        $frameset = new html_frameset_cols("280,*");

        $frameset->html_frame("thread_list.php?webtag=$webtag&amp;msg=$msg", html_get_frame_name('left'));
        $frameset->html_frame("messages.php?webtag=$webtag&amp;msg=$msg$edit_success$delete_success", html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);

    }else {

        html_draw_top();
        html_error_msg($lang['nomessages']);
        html_draw_bottom();
        exit;
    }
}

?>