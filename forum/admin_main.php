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

/* $Id: admin_main.php,v 1.49 2005-01-19 22:44:14 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (!perm_has_admin_access()) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

echo "<h1>{$lang['forumadmin']}</h1>\n";

if (forum_check_access_level()) {

    echo "<p>{$lang['adminexp_1']}</p>\n";
    echo "<p>{$lang['adminexp_2']}</p>\n";
    echo "<p>{$lang['adminexp_3']}</p>\n";
    echo "<p>{$lang['adminexp_4']}</p>\n";
    echo "<p>{$lang['adminexp_5']}</p>\n";
    echo "<p>{$lang['adminexp_6']}</p>\n";
    echo "<p>{$lang['adminexp_7']}</p>\n";
    echo "<p>{$lang['adminexp_8']}</p>\n";
    echo "<p>{$lang['adminexp_9']}</p>\n";
    echo "<p>{$lang['adminexp_10']}</p>\n";
    echo "<p>{$lang['adminexp_11']}</p>\n";
    echo "<p>{$lang['adminexp_12']}</p>\n";
}

if (perm_has_forumtools_access()) {

    echo "<p>{$lang['adminexp_13']}</p>\n";
    echo "<p>{$lang['adminexp_14']}</p>\n";
}

html_draw_bottom();

?>