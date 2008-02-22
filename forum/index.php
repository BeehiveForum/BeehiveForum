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

/* $Id: index.php,v 1.157 2008-02-22 21:26:52 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// This page doesn't validate as XHTML Frameset, but I don't care.

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

//Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Don't cache this page - fixes problems with Opera.

header_no_cache();

// Load the user session

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Check to see if we have an active session

$session_active = bh_session_active();
$logon_failed = isset($_COOKIE['bh_logon_failed']);

// Check to see if the user is trying to change their password.

$skip_logon_page = false;

// Embedded light mode in this script.

define('BEEHIVE_LIGHT_INCLUDE', 1);

// Check to see if noframes URL query specified

light_mode_check_noframes();

// Load language file

$lang = load_language_file();

// Top frame filename

$top_html = html_get_top_page();

// Clear the logon cookie

bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);

// Are we being redirected somewhere?

if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

    $final_uri_check = basename(trim(_stripslashes($_GET['final_uri'])));

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    $my_controls_files = get_available_user_control_files();
    $my_controls_preg = implode("|^", array_map('preg_quote_callback', $my_controls_files));

    $popup_files_preg = get_available_popup_files_preg();

    if (preg_match("/^$available_files_preg/", $final_uri_check) > 0) {

        $final_uri = basename(trim(_stripslashes($_GET['final_uri'])));

        if (preg_match("/^change_pw.php|^register.php/", $final_uri) > 0) {

            $skip_logon_page = true;

        }else if (preg_match("/^$popup_files_preg/", $final_uri) > 0) {

            header_redirect($final_uri);
            exit;

        }else if (preg_match("/^admin_[^\.]+\.php/", $final_uri) > 0) {

            $final_uri = rawurlencode($final_uri);
            $final_uri = "admin.php?webtag=$webtag&page=$final_uri";

        }else if (preg_match("/^$my_controls_preg/", $final_uri) > 0) {

            $final_uri = rawurlencode($final_uri);
            $final_uri = "user.php?webtag=$webtag&page=$final_uri";
        }
    }
}

// Calculate how tall the nav frameset should be based on the user's fontsize.

$navsize = bh_session_get_value('FONT_SIZE');
$navsize = max((is_numeric($navsize) ? $navsize * 2 : 22), 22);

// If user has requested password change show the form instead of the logon page.

if ($skip_logon_page === true) {

    html_draw_top('body_tag=false', 'frames=true', 'robots=index,follow');

    echo "<frameset rows=\"60,$navsize,*\" framespacing=\"0\" border=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"", html_get_frame_name('ftop'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
    echo "<frame src=\"$final_uri\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

}else if ($session_active && !$logon_failed) {

    html_draw_top('body_tag=false', 'frames=true', 'robots=index,follow');

    echo "<frameset rows=\"60,$navsize,*\" framespacing=\"0\" border=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"", html_get_frame_name('ftop'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if ($webtag) {

        if (isset($final_uri) && strlen($final_uri) > 0) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"$final_uri\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"discussion.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"discussion.php?webtag=$webtag&amp;folder={$_GET['folder']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"pm.php?webtag=$webtag&amp;mid={$_GET['pmid']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else {

            if ($start_page = bh_session_get_value('START_PAGE')) {

                if ($start_page == START_PAGE_MESSAGES) {
                    $final_uri = "discussion.php?webtag=$webtag";
                }elseif ($start_page == START_PAGE_INBOX) {
                    $final_uri = "pm.php?webtag=$webtag";
                }elseif ($start_page == START_PAGE_THREAD_LIST) {
                    $final_uri = "start.php?webtag=$webtag&left=threadlist";
                }else {
                    $final_uri = "start.php?webtag=$webtag";
                }

            }else {

                $final_uri = "start.php?webtag=$webtag";
            }

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"$final_uri\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";
        }

    }else {

        if (isset($final_uri) && strlen($final_uri) > 0) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode($final_uri), "\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"forums.php?webtag_search=$webtag_search&amp;final_uri=discussion.php%3Fmsg%3D{$_GET['msg']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"forums.php?webtag_search=$webtag_search&amp;final_uri=discussion.php%3Ffolder%3D{$_GET['folder']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"forums.php?webtag_search=$webtag_search&amp;final_uri=pm.php%3Fmid%3D{$_GET['pmid']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

        }else {

            echo "<frame src=\"nav.php?webtag=$webtag\" name=\"", html_get_frame_name('fnav'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"10\" noresize=\"noresize\" />\n";
            echo "<frame src=\"forums.php?webtag_search=$webtag_search\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" framespacing=\"0\" />\n";
        }
    }

}else {

    html_draw_top('body_tag=false', 'frames=true', 'robots=index,follow');

    echo "<frameset rows=\"60,*\" framespacing=\"0\" border=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"", html_get_frame_name('ftop'), "\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if (isset($_GET['other_logon'])) {
        $other_logon = "&amp;other_logon=true";
    }else {
        $other_logon = "";
    }

    if (isset($final_uri) && strlen($final_uri) > 0) {

        echo "<frame src=\"logon.php?webtag=$webtag$other_logon&amp;final_uri=", rawurlencode($final_uri), "\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" framespacing=\"0\" />\n";

    }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        echo "<frame src=\"logon.php?webtag=$webtag$other_logon&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg%3D{$_GET['msg']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

    }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        echo "<frame src=\"logon.php?webtag=$webtag$other_logon&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder%3D{$_GET['folder']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

    }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

        echo "<frame src=\"logon.php?webtag=$webtag$other_logon&amp;final_uri=pm.php%3Fwebtag%3D$webtag%26mid={$_GET['pmid']}\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";

    }else {

        echo "<frame src=\"logon.php?webtag=$webtag$other_logon\" name=\"", html_get_frame_name('main'), "\" frameborder=\"0\" />\n";
    }
}

echo "<noframes>\n";
echo "<body>\n";

if ($session_active && !$logon_failed) {

    if ($webtag !== false) {

        light_draw_thread_list();

        if (user_is_guest()) {
            echo "<h4><a href=\"lforums.php?webtag=$webtag\">{$lang['myforums']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['login']}</a></h4>\n";
        }else {
            echo "<h4><a href=\"lforums.php?webtag=$webtag\">{$lang['myforums']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
        }

    }else {

        light_draw_my_forums();

        echo "<h4><a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
    }

}else {

    light_draw_logon_form();
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";
echo "</body>\n";
echo "</noframes>\n";
echo "</frameset>\n";

html_draw_bottom(false);

?>