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

/* $Id: admin_menu.php,v 1.33 2004-03-17 16:12:02 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

// Enable the error handler
include_once("./include/errorhandler.inc.php");

include_once("./include/constants.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

echo "<table border=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\">Tools</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_users.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['users']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_folders.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['folders']}</a></td>\n";
echo "  </tr>\n";

if (bh_session_get_value('STATUS') & USER_PERM_QUEEN) {

    echo "  <tr>\n";
    echo "    <td class=\"postbody\"><a href=\"admin_forum_settings.php?webtag={$webtag['WEBTAG']}\" target=\"right\">Forum Settings</a></td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_prof_sect.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['profiles']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_startpage.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['startpage']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_make_style.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['forumstyle']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_wordfilter.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['wordfilter']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"admin_viewlog.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['viewlog']}</a></td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>