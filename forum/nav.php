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

/* $Id: nav.php,v 1.120 2009-03-22 18:48:12 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Set the default timezone
date_default_timezone_set('Europe/London');

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
include_once(BH_INCLUDE_PATH. "forum_links.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Get webtag

$webtag = get_webtag();

// Don't want to redirect the nav.php - frame is too small!

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Load language file

$lang = lang::get_instance()->load(__FILE__);

// Number of forums available

header_no_cache();

html_draw_top("class=navpage", "forumlinks.js");

echo "<div class=\"navleft\">\n";

if (forum_check_webtag_available($webtag)) {

    echo "<a href=\"start.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['start']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"discussion.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['messages']}</a>&nbsp;|&nbsp;\n";

    if (forum_get_setting('show_links', 'Y')) {
        echo "<a href=\"links.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['links']}</a>&nbsp;|&nbsp;\n";
    }
}

if (forum_get_setting('show_pms', 'Y')) {
    echo "<a href=\"pm.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['pminbox']}</a>&nbsp;|&nbsp;\n";
}

if (forum_check_webtag_available($webtag)) {
    echo "<a href=\"user.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['mycontrols']}</a>&nbsp;|&nbsp;\n";
}

if (forums_get_available_count() > 1 || !forum_check_webtag_available($webtag)) {
    echo "<a href=\"forums.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['myforums']}</a>&nbsp;|&nbsp;\n";
}

if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0) || bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {
    echo "<a href=\"admin.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['admin']}</a>&nbsp;|&nbsp;\n";
}

if (user_is_guest()) {

    echo "<a href=\"logout.php?webtag=$webtag\" target=\"", html_get_top_frame_name(), "\">{$lang['login']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"register.php?webtag=$webtag\" target=\"", html_get_frame_name('main'), "\">{$lang['register']}</a>\n";

}else {

    $logon = bh_session_get_value('LOGON');
    echo "<a href=\"logout.php?webtag=$webtag\" target=\"", html_get_top_frame_name(), "\">{$lang['logout']} : $logon</a>\n";
}

echo "</div>\n";
echo "<div class=\"navright\">\n";

echo forum_links_draw_dropdown('openForumLink');

echo "</div>\n";

html_draw_bottom();

?>