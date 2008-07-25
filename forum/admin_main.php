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

/* $Id: admin_main.php,v 1.70 2008-07-25 14:52:54 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Intitalise a few variables

$webtag_search = false;

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

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

if ((!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) || (bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE) && $webtag === false)) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

html_draw_top();

echo "<h1>{$lang['forumadmin']}</h1>\n";

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "<p>{$lang['adminexp_1']}</p>\n";
    echo "<p>{$lang['adminexp_2']}</p>\n";

    if ($webtag !== false) {

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
        echo "<p>{$lang['adminexp_14']}</p>\n";

        if (bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

            echo "<p>{$lang['adminexp_17']}</p>\n";
        }

        echo "<p>{$lang['adminexp_18']}</p>\n";
    }

}elseif (bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

    echo "<p>{$lang['adminexp_17']}</p>\n";
}

if (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

    echo "<p>{$lang['adminexp_15']}</p>\n";
    echo "<p>{$lang['adminexp_16']}</p>\n";
}

html_draw_bottom();

?>