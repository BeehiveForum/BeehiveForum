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

/* $Id: logout.php,v 1.34 2004-03-13 00:00:21 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag=$webtag");
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

// Disable caching when showing logon page
include_once("./include/header.inc.php");

if (!bh_session_get_value('UID')) {
    header_no_cache();
}

// User was a guest that now wants to logon

if (bh_session_get_value('UID') == 0) {
    if (isset($HTTP_GET_VARS['final_uri'])) {
        $uri = "./index.php?webtag=$webtag&final_uri=". $HTTP_GET_VARS['final_uri'];
    }else {
        $uri = "./index.php?webtag=$webtag";
    }
    bh_session_end();
    bh_setcookie("bh_logon", '1', time() + YEAR_IN_SECONDS);
    header_redirect($uri);
}

$logged_off = false;

// Where are we going after we've logged off?

if (isset($HTTP_POST_VARS['submit'])) {
    bh_session_end();
    header_redirect("./index.php?webtag=$webtag");
    $logged_off = true;
}


html_draw_top();

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_top\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>\n";
echo "<table class=\"subhead\" width=\"100%\"><tr><td align=\"left\">\n";
echo "{$lang['logout']}:\n";
echo "</td></tr></table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
if ($logged_off) {
    echo "<tr><td>{$lang['youhaveloggedout']}</td></tr>\n";
    echo "<tr><td>&nbsp;</td></tr>";
} else {
    echo "<tr><td>{$lang['currentlyloggedinas']} ". user_get_logon(bh_session_get_value('UID')). "</td></tr>\n";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td align=\"center\">".form_submit("submit", $lang['logout']);
}
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form></div>\n";

html_draw_bottom();

?>