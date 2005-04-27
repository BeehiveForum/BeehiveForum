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

/* $Id: admin_main.php,v 1.53 2005-04-27 19:47:06 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (!perm_has_admin_access() && !perm_has_forumtools_access()) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

echo "<h1>{$lang['forumadmin']}</h1>\n";

if (perm_has_admin_access()) {

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
    echo "<p>{$lang['adminexp_13']}</p>\n";
}

if (perm_has_forumtools_access()) {

    echo "<p>{$lang['adminexp_14']}</p>\n";
    echo "<p>{$lang['adminexp_15']}</p>\n";
}

html_draw_bottom();

?>