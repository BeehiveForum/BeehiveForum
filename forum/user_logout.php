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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/session.inc.php");
require_once("./include/form.inc.php");
require_once("./include/lang.inc.php");

$logged_off = false;

// Where are we going after we've logged on?
if(isset($HTTP_POST_VARS['submit'])){
    bh_session_end();
    $logged_off = true;
}


html_draw_top();

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"" . get_request_uri() . "\" method=\"POST\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>\n";
echo "<table class=\"subhead\" width=\"100%\"><tr><td>\n";
echo "{$lang['logout']}:\n";
echo "</td></tr></table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
if($logged_off){
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
