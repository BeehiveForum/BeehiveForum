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

/* $Id: user.php,v 1.62 2007-10-11 13:01:17 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Don't cache this page - fixes problems with Opera.

header_no_cache();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

if (isset($_GET['page']) && strlen(trim(_stripslashes($_GET['page']))) > 0) {

    $requested_page = trim(_stripslashes($_GET['page']));

    $available_pages = get_available_user_control_files();
    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));

    if (preg_match("/^$available_pages_preg/", basename($requested_page)) > 0) {

        html_draw_top('body_tag=false', 'frames=true');

        echo "<frameset cols=\"250,*\" framespacing=\"0\" border=\"4\">\n";
        echo "  <frame src=\"./user_menu.php?webtag=$webtag\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
        echo "  <frame src=\"$requested_page\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
        echo "</frameset>\n";

        html_draw_bottom(false);
        exit;
    }
}

html_draw_top('body_tag=false', 'frames=true');

echo "<frameset cols=\"250,*\" framespacing=\"0\" border=\"4\">\n";
echo "  <frame src=\"./user_menu.php?webtag=$webtag\" name=\"", html_get_frame_name('left'), "\" frameborder=\"0\" />\n";
echo "  <frame src=\"./user_main.php?webtag=$webtag\" name=\"", html_get_frame_name('right'), "\" frameborder=\"0\" />\n";
echo "</frameset>\n";

html_draw_bottom(false);

?>