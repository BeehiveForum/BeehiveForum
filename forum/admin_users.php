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

//Check logged in status
require_once("./include/session.inc.php");
if(!bh_session_check()){
    $go = "Location: http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $go .= "/".dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $go .= "/logon.php?final_uri=";
    $go .= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    header($go);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

if(!$HTTP_COOKIE_VARS[bh_sess_ustatus] & USER_PERM_SOLDIER){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

// Draw the form
echo "<h1>Manage Users</h1>\n";
echo "<p>Click on a user's name to alter their permissions</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\"><tr><td class=\"box\">";

$db = db_connect();

$sql = "select UID, LOGON, NICKNAME from " . forum_table("USER");

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i=0;$i<$result_count;$i++){

    $row = db_fetch_array($result);

    echo "<p class=\"posthead\"><a href=\"./admin_user.php?uid=".$row['UID']."\">";
    echo format_user_name($row['LOGON'],$row['NICKNAME']);
    echo "</a></p>\n";
}

db_disconnect($db);

echo "</td></tr></table>\n";
echo "</div>\n";

html_draw_bottom();

?>
