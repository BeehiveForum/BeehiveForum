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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Load language file
$lang = load_language_file();

if ((!session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

html_draw_top();

if (forum_check_webtag_available($webtag)) {

    if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

        echo "<table border=\"0\" width=\"100%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"subhead\">{$lang['admintools']}</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['users']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_user_groups.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['usergroups']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_banned.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['bancontrols']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_folders.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['folders']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_rss_feeds.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['rssfeeds']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_prof_sect.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['profiles']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forum_settings.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['forumsettings']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_startpage.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['startpage']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_make_style.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['forumstyle']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_wordfilter.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['wordfilter']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forum_stats.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['forumstats']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_post_stats.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['postingstats']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forum_links.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['forumlinks']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_viewlog.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['viewlog']}</a></td>\n";
        echo "  </tr>\n";

        if (session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

            echo "  <tr>\n";
            echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_post_approve.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['postapprovalqueue']}</a></td>\n";
            echo "  </tr>\n";
        }

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_visitor_log.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['visitorlog']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";

    }elseif (session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

        echo "<table border=\"0\" width=\"100%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"subhead\">{$lang['admintools']}</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_post_approve.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['postapprovalqueue']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
    }

    if (session_check_perm(USER_PERM_FORUM_TOOLS, 0)) {

        echo "<table border=\"0\" width=\"100%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"subhead\">{$lang['forummanagement']}</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forums.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['manageforums']}</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_default_forum_settings.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['globalforumsettings']}</a></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
    }

}else {

    echo "<table border=\"0\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"subhead\">{$lang['forummanagement']}</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['users']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forums.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['manageforums']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_default_forum_settings.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['globalforumsettings']}</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

html_draw_bottom();

?>