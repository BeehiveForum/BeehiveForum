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

// Frameset for thread list and messages

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

echo "<table border=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\">Tools</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"./admin_users.php\" target=\"right\">Users</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"./admin_folders.php\" target=\"right\">Folders</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"./admin_prof_sect.php\" target=\"right\">Profiles</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"./admin_startpage.php\" target=\"right\">Start Page</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"./admin_make_style.php\" target=\"right\">Forum Style</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"./admin_viewlog.php\" target=\"right\">View Log</a></td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>