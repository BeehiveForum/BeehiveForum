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

// Compress the output
require_once("./include/gzipenc.inc.php");

// Frameset for thread list and messages

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    header_redirect("./logon.php");
    
}

// Disable caching when showing logon page
require_once("./include/header.inc.php");

if(!isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
    header_no_cache();
}

if ($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {

        $uri = "./index.php";
	bh_session_end();
	header_redirect($uri);
  
}

require_once("./include/config.inc.php");

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/session.inc.php");
require_once("./include/form.inc.php");

$logged_off = false;

// Where are we going after we've logged off?

if (isset($HTTP_POST_VARS['submit'])) {
    bh_session_end();
    header_redirect("./index.php");
    $logged_off = true;
}


html_draw_top();

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"" . get_request_uri() . "\" method=\"POST\" target=\"_top\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>\n";
echo "<table class=\"subhead\" width=\"100%\"><tr><td>\n";
echo "Log out:\n";
echo "</td></tr></table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
if($logged_off){
    echo "<tr><td>You have logged out.</td></tr>\n";
    echo "<tr><td>&nbsp;</td></tr>";
} else {
    echo "<tr><td>You are currently logged in as ". user_get_logon($HTTP_COOKIE_VARS['bh_sess_uid']). "</td></tr>\n";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td align=\"center\">".form_submit("submit", "Log out");
}
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form></div>\n";

html_draw_bottom();

?>
