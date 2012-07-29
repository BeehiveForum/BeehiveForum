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

include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Don't cache this page - fixes problems with Opera.
cache_disable();

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

// Initialise Locale
lang_init();

if ((!session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {

    html_draw_top();
    html_error_msg(gettext("You do not have permission to use this section."));
    html_draw_bottom();
    exit;
}

// Get the user's saved left frame width.
if (($left_frame_width = session_get_value('LEFT_FRAME_WIDTH')) === false) {
    $left_frame_width = 280;
}

// Output starts here
html_draw_top('class=window_title', 'frame_set_html', 'pm_popup_disabled');

$frameset = new html_frameset_cols('admin', "$left_frame_width,*");

if (isset($_GET['page']) && strlen(trim(stripslashes_array($_GET['page']))) > 0) {

    $requested_page = trim(stripslashes_array($_GET['page']));

    $available_pages = get_available_admin_files();
    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));

    if (preg_match("/^$available_pages_preg/u", basename($requested_page)) > 0) {

        $requested_page = href_cleanup_query_keys($requested_page);

        $frameset->html_frame("admin_menu.php?webtag=$webtag", html_get_frame_name('left'));
        $frameset->html_frame($requested_page, html_get_frame_name('right'));

        $frameset->output_html();

        html_draw_bottom(true);
        exit;
    }
}

$frameset->html_frame("admin_menu.php?webtag=$webtag", html_get_frame_name('left'));

if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
    $frameset->html_frame("admin_users.php?webtag=$webtag", html_get_frame_name('right'));
}else {
    $frameset->html_frame("admin_forums.php?webtag=$webtag", html_get_frame_name('right'));
}

$frameset->output_html();

html_draw_bottom(true);

?>