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

/* $Id: nav.php,v 1.41 2004-01-15 00:17:21 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Navigation strip

require_once("./include/constants.inc.php");
require_once("./include/header.inc.php");
require_once("./include/html.inc.php");
require_once("./include/config.inc.php");
require_once("./include/session.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/pm.inc.php");

bh_session_check();

header_no_cache();

html_draw_top("class=navpage", "refresh=60");

echo "<a href=\"start.php\" target=\"main\">{$lang['start']}</a>&nbsp;|&nbsp;\n";
echo "<a href=\"discussion.php\" target=\"main\">{$lang['messages']}</a>&nbsp;|&nbsp;\n";

if ($show_links) {
    echo "<a href=\"links.php\" target=\"main\">{$lang['links']}</a>&nbsp;|&nbsp;\n";
}

bh_session_check();

//if (bh_session_get_value('UID') > 0) {

    if ($show_pms) {
        if (bh_session_get_value('UID') > 0 && pm_new_check(false)) {
            echo "<a href=\"pm.php\" target=\"main\">{$lang['pminbox']}</a> <img src=\"", style_image("pmnew.png"), "\" />&nbsp;|&nbsp;\n";
        }else {
            echo "<a href=\"pm.php\" target=\"main\">{$lang['pminbox']}</a>&nbsp;|&nbsp;\n";
        }
    }

    echo "<a href=\"prefs.php\" target=\"main\">{$lang['preferences']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"profile.php\" target=\"main\">{$lang['profile']}</a>&nbsp;|&nbsp;\n";
//}

if (bh_session_get_value('STATUS') & USER_PERM_SOLDIER) {
    echo "<a href=\"admin.php\" target=\"main\">{$lang['admin']}</a>&nbsp;|&nbsp;\n";
}

if (bh_session_get_value('UID') == 0) {
    echo "<a href=\"logout.php\" target=\"_top\">{$lang['login']}</a>\n";
}else {
    echo "<a href=\"logout.php\" target=\"main\">{$lang['logout']}</a>\n";
}

html_draw_bottom();

?>