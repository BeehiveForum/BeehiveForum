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

/* $Id: index.php,v 1.127 2006-07-25 21:43:51 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// This page doesn't validate as XHTML Frameset, but I don't care.

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

//Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Load language file

$lang = load_language_file();

// Top frame filename

$top_html = html_get_top_page();

// Check to see if we have an active session

$session_active = bh_session_active();

// Clear the logon cookie

bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);

if ($session_active) {

    // Fetch the forum settings

    $webtag = get_webtag($webtag_search);

    // Calculate how tall the nav frameset should be based on the user's fontsize.

    $navsize = bh_session_get_value('FONT_SIZE');
    $navsize = max(($navsize ? $navsize * 2 : 22), 22);

    html_draw_top('body_tag=false', 'robots=index,follow');

    echo "<frameset rows=\"60,$navsize,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"ftop\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"./nav.php?webtag=$webtag\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if ($webtag) {

        if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

            $final_uri = basename(trim(_stripslashes($_GET['final_uri'])));

            if (stristr($final_uri, "?")) {
                echo "<frame src=\"", rawurldecode($final_uri), "&amp;webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
            }else {
                echo "<frame src=\"", rawurldecode($final_uri), "?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
            }

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./discussion.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./discussion.php?webtag=$webtag&amp;folder={$_GET['folder']}\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./pm.php?webtag=$webtag&amp;mid={$_GET['pmid']}\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            if ($start_page = bh_session_get_value('START_PAGE')) {

                if ($start_page == 1) {
                    $final_uri = "./discussion.php?webtag=$webtag";
                }elseif ($start_page == 2) {
                    $final_uri = "./pm.php?webtag=$webtag";
                }elseif ($start_page == 3) {
                    $final_uri = "./start.php?webtag=$webtag&left=threadlist";
                }else {
                    $final_uri = "./start.php?webtag=$webtag";
                }

            }else {

                $final_uri = "./start.php?webtag=$webtag";
            }

            echo "<frame src=\"$final_uri\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
        }

    }else {

        if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

            $final_uri = basename(trim(_stripslashes($_GET['final_uri'])));

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode($final_uri), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode("./discussion.php?msg={$_GET['msg']}"), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode("./discussion.php?folder={$_GET['folder']}"), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode("./pm.php?mid={$_GET['pmid']}"), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
        }
    }

}else {

    // Fetch the forum settings

    $webtag = get_webtag($webtag_search);

    html_draw_top('body_tag=false', 'robots=index,follow');

    echo "<frameset rows=\"60,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

        $final_uri = basename(trim(_stripslashes($_GET['final_uri'])));

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=", rawurlencode($final_uri), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=". rawurlencode("./discussion.php?webtag=$webtag&amp;msg={$_GET['msg']}"). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=". rawurlencode("./discussion.php?webtag=$webtag&amp;folder={$_GET['folder']}"). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=". rawurlencode("./pm.php?webtag=$webtag&amp;mid={$_GET['pmid']}"). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else {

        echo "<frame src=\"./logon.php?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
    }
}

echo "<noframes>\n";
echo "<body>\n";

define('BEEHIVE_LIGHT_INCLUDE', 1);

if ($session_active) {

    if ($webtag = get_webtag($webtag_search)) {

        light_draw_thread_list();

        if (bh_session_get_value('UID') == 0) {
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

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";
echo "</body>\n";
echo "</noframes>\n";
echo "</frameset>\n";

html_draw_bottom(false);

?>
