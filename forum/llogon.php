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

/* $Id: llogon.php,v 1.66 2008-07-27 10:53:32 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Intitalise a few variables

// Initialise the user session

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag();

// Error messages string

$error_msg_array = array();

if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

    if (logon_perform(true)) {

        header_redirect("lthread_list.php?webtag=$webtag", $lang['loggedinsuccessfully']);

    }else {

        $error_msg_array[] = $lang['usernameorpasswdnotvalid'];
    }
}

light_html_draw_top("robots=noindex,nofollow");

echo "<h1>{$lang['logon']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<br />\n";

light_draw_logon_form();

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";

light_html_draw_bottom();

?>