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

/* $Id: llogout.php,v 1.24 2004-05-09 00:57:48 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/light.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./llogon.php?webtag=$webtag";
    header_redirect($uri);
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Where are we going after we've logged off?

if (isset($_POST['submit'])) {

    bh_session_end();

    if (!strstr(@$_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS

        header_redirect("./llogon.php");

    }else { // IIS bug prevents redirect at same time as setting cookies.

        light_html_draw_top();

        echo "<p>{$lang['youhaveloggedout']}</p>";
        form_quick_button("./llogon.php", $lang['ok']);

        light_html_draw_bottom();
        exit;
    }
}

light_html_draw_top();

echo "<form name=\"logon\" action=\"llogout.php\" method=\"post\" target=\"_top\">\n";
echo form_input_hidden('webtag', $webtag), "\n";
echo "<p>{$lang['currentlyloggedinas']} ", user_get_logon(bh_session_get_value('UID')), "</p>\n";
echo "<p>", form_submit("submit", $lang['logout']), "</p>\n";

light_html_draw_bottom();

?>