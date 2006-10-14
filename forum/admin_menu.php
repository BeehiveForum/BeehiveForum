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

/* $Id: admin_menu.php,v 1.76 2006-10-14 19:11:35 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "<table border=\"0\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['admintools']}</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"right\">{$lang['users']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_user_groups.php?webtag=$webtag\" target=\"right\">{$lang['usergroups']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_banned.php?webtag=$webtag\" target=\"right\">{$lang['bancontrols']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_folders.php?webtag=$webtag\" target=\"right\">{$lang['folders']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_rss_feeds.php?webtag=$webtag\" target=\"right\">{$lang['rssfeeds']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_prof_sect.php?webtag=$webtag\" target=\"right\">{$lang['profiles']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_forum_settings.php?webtag=$webtag\" target=\"right\">{$lang['forumsettings']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_startpage.php?webtag=$webtag\" target=\"right\">{$lang['startpage']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_make_style.php?webtag=$webtag\" target=\"right\">{$lang['forumstyle']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_wordfilter.php?webtag=$webtag\" target=\"right\">{$lang['wordfilter']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_post_stats.php?webtag=$webtag\" target=\"right\">{$lang['postingstats']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_forum_links.php?webtag=$webtag\" target=\"right\">{$lang['forumlinks']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_viewlog.php?webtag=$webtag\" target=\"right\">{$lang['viewlog']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}


if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

    echo "<table border=\"0\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['forummanagement']}</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_forums.php?webtag=$webtag\" target=\"right\">{$lang['manageforums']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"admin_default_forum_settings.php?webtag=$webtag\" target=\"right\">{$lang['globalforumsettings']}</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

html_draw_bottom();

?>