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

/* $Id: llogout.php,v 1.60 2008-09-23 23:54:06 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get webtag

$webtag = get_webtag();

// Load the user session

$user_sess = bh_session_check();

// Load language file

$lang = load_language_file();

// User was a guest that now wants to logon

if (user_is_guest()) {

    bh_session_remove_cookies();
    bh_setcookie("bh_logon", "1");
    header_redirect("llogon.php?webtag=$webtag");
}

// Where are we going after we've logged off?

if (isset($_POST['logout'])) {

    bh_session_end();
    header_redirect("llogon.php?webtag=$webtag", $lang['youhaveloggedout']);
}

light_html_draw_top("robots=noindex,nofollow");

$user = user_get(bh_session_get_value('UID'));

echo "<form accept-charset=\"utf-8\" name=\"logon\" action=\"llogout.php\" method=\"post\" target=\"", html_get_top_frame_name(), "\">\n";
echo form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "<p>", sprintf($lang['currentlyloggedinas'], word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME'])))), "</p>\n";
echo "<p>", light_form_submit("logout", $lang['logout']), "</p>\n";
echo "</form>\n";

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";

light_html_draw_bottom();

?>