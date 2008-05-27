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

/* $Id: discussion.php,v 1.113 2008-05-27 18:28:54 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

header_no_cache();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
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

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

$uid = bh_session_get_value('UID');

if (!$folder_info = threads_get_folders()) {

    html_draw_top();
    html_error_msg($lang['couldnotretrievefolderinformation']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['folder']) && is_numeric($_GET['folder']) && folder_is_accessible($_GET['folder'])) {

    $fid = $_GET['folder'];
    $msg = messages_get_most_recent($uid, $fid);

    html_draw_top('body_tag=false', 'frames=true');

    echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
    echo "  <frame src=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$fid\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
    echo "  <frame src=\"messages.php?webtag=$webtag&amp;msg=$msg\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
    echo "</frameset>\n";

    html_draw_bottom(false);

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    html_draw_top('body_tag=false', 'frames=true');

    if (isset($_GET['edit_success']) && validate_msg($_GET['edit_success'])) {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"thread_list.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"messages.php?webtag=$webtag&amp;msg={$_GET['msg']}&amp;edit_success={$_GET['edit_success']}\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";

    }else if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"thread_list.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"messages.php?webtag=$webtag&amp;msg={$_GET['msg']}&amp;delete_success={$_GET['delete_success']}\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";

    }else {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"thread_list.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"messages.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";
    }

    html_draw_bottom(false);

}else if (isset($_GET['right']) && $_GET['right'] == 'search') {

    // Guests can't use this

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    html_draw_top('body_tag=false', 'frames=true');

    if (isset($_GET['search_error']) && is_numeric($_GET['search_error'])) {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"thread_list.php?webtag=$webtag\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"search.php?webtag=$webtag&amp;search_error={$_GET['search_error']}\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";

    }else {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"thread_list.php?webtag=$webtag\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"search.php?webtag=$webtag\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";
    }

    html_draw_bottom(false);

}else if (isset($_GET['left']) && $_GET['left'] == 'search_results') {

    // Guests can't use this

    if (user_is_guest()) {

        html_guest_error();
        exit;
    }

    html_draw_top('body_tag=false', 'frames=true');

    if ($search_msg = search_get_first_result_msg()) {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"search.php?webtag=$webtag&amp;offset=0\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"messages.php?webtag=$webtag&amp;msg=$search_msg&amp;highlight=yes\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";

    }else {

        echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
        echo "  <frame src=\"search.php?webtag=$webtag&amp;offset=0\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"search.php?webtag=$webtag\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";
    }

    html_draw_bottom(false);

}else {

    $msg = messages_get_most_recent($uid);

    html_draw_top('body_tag=false', 'frames=true');

    echo "<frameset cols=\"280,*\" framespacing=\"4\" border=\"4\">\n";
    echo "  <frame src=\"thread_list.php?webtag=$webtag&amp;msg=$msg\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
    echo "  <frame src=\"messages.php?webtag=$webtag&amp;msg=$msg\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
    echo "</frameset>\n";

    html_draw_bottom(false);
}

?>