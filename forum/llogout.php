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

/* $Id: llogout.php,v 1.2 2004-03-07 18:05:45 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check() || bh_session_get_value('UID') == 0) {

    $uri = "./llogon.php";
    header_redirect($uri);
}

// Disable caching when showing logon page
require_once("./include/header.inc.php");
require_once("./include/config.inc.php");
require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/session.inc.php");
require_once("./include/form.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/light.inc.php");

// Where are we going after we've logged off?

if (isset($HTTP_POST_VARS['submit'])) {
    
    bh_session_end();

    if (!strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS

        header_redirect("./llogon.php");

    }else { // IIS bug prevents redirect at same time as setting cookies.

        light_html_draw_top();

        echo "<p>{$lang['youhaveloggedout']}</p>";
        echo form_quick_button("./llogon.php", $lang['ok']);

        light_html_draw_bottom();
        exit;
    }
}

light_html_draw_top();

echo "<form name=\"logon\" action=\"llogout.php\" method=\"post\" target=\"_top\">\n";
echo "<p>{$lang['currentlyloggedinas']} ", user_get_logon(bh_session_get_value('UID')), "</p>\n";
echo "<p>", form_submit("submit", $lang['logout']), "</p>\n";

light_html_draw_bottom();

?>