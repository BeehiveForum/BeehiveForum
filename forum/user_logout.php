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

/* $Id: user_logout.php,v 1.19 2004-03-12 18:46:50 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

$logged_off = false;

// Where are we going after we've logged on?
if (isset($HTTP_POST_VARS['submit'])) {

    bh_session_end();
    $logged_off = true;

}else {

    bh_session_check();
}

html_draw_top();

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"" . get_request_uri() . "\" method=\"POST\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>\n";
echo "<table class=\"subhead\" width=\"100%\"><tr><td>\n";
echo "{$lang['logout']}:\n";
echo "</td></tr></table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
if ($logged_off) {
    echo "<tr><td>{$lang['youhaveloggedout']}.</td></tr>\n";
    echo "<tr><td>&nbsp;</td></tr>";
} else {
    echo "<tr><td>{$lang['currentlyloggedinas']} ". user_get_logon(bh_session_get_value('UID')). "</td></tr>\n";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td align=\"center\">".form_submit("submit",$lang['logout']);
}
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form></div>\n";

html_draw_bottom();

?>