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

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/user.inc.php");
require_once("./include/format.inc.php");
require_once("./include/forum.inc.php");

$uid = $HTTP_GET_VARS['uid'];
$psid = @$HTTP_GET_VARS['psid'];

if(!$uid){
    html_draw_top();
    echo "<h1>Error:</h1>";
    echo "<p>No user specified</p>";
    html_draw_bottom();
    exit;
}

$user = user_get($uid);

html_draw_top(format_user_name($user['LOGON'],$user['NICKNAME']));

$db = db_connect();

$sql = "select distinct PS.PSID, PS.NAME from ";
$sql.= forum_table("PROFILE_SECTION") . " PS, ";
$sql.= forum_table("PROFILE_ITEM") . " PI ";
$sql.= " where PS.PSID = PI.PSID";
$sql.= " order by PS.PSID";

$result = db_query($sql,$db);

$row_count = db_num_rows($result);

if($row_count == 0){
    echo "<h1>Error:</h1>";
    echo "<p>Profiles not set up</p>";
    html_draw_bottom();
    exit;
}

echo "<table width=\"100%\" class=\"subhead\" border=\"0\"><tr>\n";

for ($i = 0; $i < $row_count; $i++) {
    $row = db_fetch_array($result);
    if ($i == 0) {
        if(!$psid) {
            $psid = $row['PSID'];
        }
    } else if(!($i % 4)){ // Start new row every 4 sections
        echo "</tr><tr>";
    }
    echo "<td width=\"25%\">";
    if($row['PSID'] != $psid){
        echo "<a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?uid=$uid&psid=" . $row['PSID'] . "\">";
        echo stripslashes($row['NAME']) . "</a></td>\n";
    } else {
        echo "<b>" . stripslashes($row['NAME']) . "</b></td>\n";
    }
}

for(;$i % 4; $i++){
    echo "<td width=\"25%\">&nbsp;</td>";
}

echo "</tr></table>";

echo "<table width=\"100%\" class=\"posthead\"><tr><td width=\"75%\" valign=\"top\">\n";

echo "<table width=\"100%\">";

$sql = "select PI.NAME, UP.ENTRY from " . forum_table("PROFILE_ITEM") . " PI ";
$sql.= "left join " . forum_table("USER_PROFILE") . " UP on (UP.PIID = PI.PIID and UP.UID = $uid) ";
$sql.= "where PI.PSID = $psid order by PI.PIID";

$result = db_query($sql,$db);

while($row = db_fetch_array($result)){
    echo "<tr><td class=\"subhead\" width=\"33%\">" . $row['NAME'] . "</td>";
    echo "<td width=\"67%\" class=\"posthead\">" . stripslashes($row['ENTRY']) . "</td></tr>\n";
}

echo "</table></td>\n";

echo "<td valign=\"top\"><table width=\"100%\" class=\"subhead\">";
echo "<tr><td><a href=\"email.php?uid=$uid\">Send email</a></td></tr>\n";

$sql = "select RELATIONSHIP from " . forum_table("USER_PEER") . " USER_PEER ";
$sql.= "where UID = '" . $HTTP_COOKIE_VARS['bh_sess_uid'] . "' ";
$sql.= "and PEER_UID = '$uid'";

$result = db_query($sql,$db);
$row = db_fetch_array($result);

if($row['RELATIONSHIP'] != 1){
    $setrel = 1;
    $text = "Add to friends";
} else {
    $setrel = 0;
    $text = "Remove from friends";
}

echo "<tr><td><a href=\"./set_relation.php?uid=$uid&rel=$setrel&ret=";
echo urlencode($HTTP_SERVER_VARS['PHP_SELF'])."?uid=$uid&psid=$psid";
echo "\">$text</a></td></tr>\n";

if($row['RELATIONSHIP'] != -1){
    $setrel = -1;
    $text = "Ignore user";
} else {
    $setrel = 0;
    $text = "Stop ignoring user";
}

echo "<tr><td><a href=\"./set_relation.php?uid=$uid&rel=$setrel&ret=";
echo urlencode($HTTP_SERVER_VARS['PHP_SELF'])."?uid=$uid&psid=$psid";
echo "\">$text</a></td></tr>\n";

html_draw_bottom();

?>
