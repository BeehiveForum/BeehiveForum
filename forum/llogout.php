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

/* $Id: llogout.php,v 1.5 2004-03-12 18:46:50 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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
include_once("./include/light.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!bh_session_check() || bh_session_get_value('UID') == 0) {

    $uri = "./llogon.php?webtag=$webtag";
    header_redirect($uri);
}

// Where are we going after we've logged off?

if (isset($HTTP_POST_VARS['submit'])) {
    
    bh_session_end();

    if (!strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS

        header_redirect("./llogon.php?webtag=$webtag");

    }else { // IIS bug prevents redirect at same time as setting cookies.

        light_html_draw_top();

        echo "<p>{$lang['youhaveloggedout']}</p>";
        echo form_quick_button("./llogon.php?webtag=$webtag", $lang['ok']);

        light_html_draw_bottom();
        exit;
    }
}

light_html_draw_top();

echo "<form name=\"logon\" action=\"llogout.php?webtag=$webtag\" method=\"post\" target=\"_top\">\n";
echo "<p>{$lang['currentlyloggedinas']} ", user_get_logon(bh_session_get_value('UID')), "</p>\n";
echo "<p>", form_submit("submit", $lang['logout']), "</p>\n";

light_html_draw_bottom();

?>