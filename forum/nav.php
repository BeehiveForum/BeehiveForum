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

/* $Id: nav.php,v 1.67 2004-04-17 18:41:01 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/session.inc.php");

$user_sess = bh_session_check();

// Fetch the forum webtag and settings
$webtag = get_webtag();

header_no_cache();

html_draw_top("class=navpage");

if ($webtag) {

    echo "<a href=\"start.php?webtag=$webtag\" target=\"main\">{$lang['start']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"discussion.php?webtag=$webtag\" target=\"main\">{$lang['messages']}</a>&nbsp;|&nbsp;\n";
    
    if (forum_get_setting('show_links', 'Y', false)) {
        echo "<a href=\"links.php?webtag=$webtag\" target=\"main\">{$lang['links']}</a>&nbsp;|&nbsp;\n";
    }

    if (forum_get_setting('show_pms', 'Y', false)) {
        echo "<a href=\"pm.php?webtag=$webtag\" target=\"main\">{$lang['pminbox']}</a>&nbsp;|&nbsp;\n";
    }

    echo "<a href=\"user.php?webtag=$webtag\" target=\"main\">{$lang['mycontrols']}</a>&nbsp;|&nbsp;\n";
}

echo "<a href=\"forums.php?webtag=$webtag\" target=\"main\">{$lang['myforums']}</a>&nbsp;|&nbsp;\n";

if ((bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<a href=\"admin.php?webtag=$webtag\" target=\"main\">{$lang['admin']}</a>&nbsp;|&nbsp;\n";
}

if (bh_session_get_value('UID') == 0) {
    echo "<a href=\"logout.php?webtag=$webtag\" target=\"_top\">{$lang['login']}</a>\n";
}else {
    echo "<a href=\"logout.php?webtag=$webtag\" target=\"main\">{$lang['logout']}</a>\n";
}

html_draw_bottom();

?>