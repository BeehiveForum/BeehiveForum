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
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= "/".dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);

    header_redirect($uri);
}

$uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/threads.inc.php");

html_draw_top_script();

echo "<table class=\"posthead\" border=\"0\" width=\"100%\">";

echo "<tr><td class=\"subhead\">Recent threads</td></tr>";

$db = db_connect();

// Get most recent threads
$sql = "select T.TID, T.TITLE, T.LENGTH, UT.LAST_READ ";
$sql.= "from ".forum_table("THREAD")." T left join ".forum_table("USER_THREAD")." UT ";
$sql.= "on (T.TID = UT.TID and UT.UID = $uid) ";
$sql.= "order by T.MODIFIED desc ";
$sql.= "limit 0, 10";

$result = db_query($sql,$db);

while($row = db_fetch_array($result)){
    $tid = $row['TID'];
    if($row['LAST_READ'] && $row['LENGTH'] > $row['LAST_READ']){
        $pid = $row['LAST_READ'] + 1;
    } else {
        $pid = 1;
    }
    echo "<tr><td><a href=\"discussion.php?msg=$tid.$pid\" target=\"main\">";
    echo stripslashes($row['TITLE'])."</a></td></tr>\n";
}

echo "<tr><td>&nbsp;</td></tr>\n";

// Display "Start Reading" button
echo "<tr><td align=\"center\">\n";
echo "<form name=\"f_startreading\" method=\"get\" action=\"discussion.php\" target=\"main\">\n";
echo "<input type=\"submit\" class=\"button\" value=\"Start reading\">\n";
echo "</form></td></tr>\n";

echo "<tr><td>&nbsp;</td></tr>\n";

echo "<tr><td class=\"subhead\">Recent visitors</td></tr>";

// Get recent visitors
$sql = "select U.UID, U.LOGON, U.NICKNAME, U.LAST_LOGON ";
$sql.= "from ".forum_table("USER")." U ";
$sql.= "order by U.LAST_LOGON desc ";
$sql.= "limit 0, 10";

$result = db_query($sql,$db);

while($row = db_fetch_array($result)){
    echo "<tr><td>";
    echo "<a href=\"#\" onclick=\"openProfile(".$row['UID'].")\">";
    echo format_user_name($row['LOGON'], $row['NICKNAME']) . "</a>";
    echo "</td></tr>\n";
}

echo "</table>\n";

html_draw_bottom();

?>
