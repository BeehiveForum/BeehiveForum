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
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    
    header_redirect($uri);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/profile.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

if(!$HTTP_COOKIE_VARS[bh_sess_ustatus] & USER_PERM_SOLDIER){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

if(isset($HTTP_GET_VARS['psid'])){
    $psid = $HTTP_GET_VARS['psid'];
} else if(isset($HTTP_POST_VARS['t_psid'])){
    $psid = $HTTP_POST_VARS['t_psid'];
} else {
    echo "<h1>Invalid Operation</h1>\n";
    echo "<p>No Profile Section specified.</p>\n";
    html_draw_bottom();
    exit;
}

// Do updates
if(isset($HTTP_POST_VARS['submit'])){
    for($i=0;$i<$HTTP_POST_VARS['t_count'];$i++){
        if($HTTP_POST_VARS['t_name_'.$i] != $HTTP_POST_VARS['t_old_name_'.$i]
        || $HTTP_POST_VARS['t_move_'.$i] != $psid){
            $new_name = (trim($HTTP_POST_VARS['t_name_'.$i]) != "") ? $HTTP_POST_VARS['t_name_'.$i] : $HTTP_POST_VARS['t_old_name_'.$i];
            profile_item_update($HTTP_POST_VARS['t_piid_'.$i],$HTTP_POST_VARS['t_move_'.$i],$new_name);
        }
    }
    if(trim($HTTP_POST_VARS['t_name_new']) != "" && $HTTP_POST_VARS['t_name_new'] != "New Item"){
        profile_item_create($psid,$HTTP_POST_VARS['t_name_new']);
    }
}

// Draw the form
echo "<h1>Manage Profile Items<br>Section: ".profile_section_get_name($psid)."</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\"><tr><td class=\"box\">";

echo "<form name=\"f_items\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
echo "<td class=\"subhead\">ID</td>\n";
echo "<td class=\"subhead\">Item Name</td>\n";
echo "<td class=\"subhead\">Move to</td>\n";
echo "</tr>\n";

$db = db_connect();

$sql = "select PROFILE_ITEM.PIID, PROFILE_ITEM.NAME ";
$sql.= "from " . forum_table("PROFILE_ITEM") . " PROFILE_ITEM ";
$sql.= "where PROFILE_ITEM.PSID = $psid ";
$sql.= "order by PROFILE_ITEM.PIID";

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i=0;$i<$result_count;$i++){

    $row = db_fetch_array($result);

    echo "<tr><td>".$row['PIID']."<input type=\"hidden\" name=\"t_piid_$i\" value=\"".$row['PIID']."\"></td>\n";
    echo "<td><input type=\"text\" name=\"t_name_$i\" width=\"64\" maxchars=\"64\" value=\"".$row['NAME']."\">";
    echo "<input type=\"hidden\" name=\"t_old_name_$i\" value=\"".$row['NAME']."\"></td>";
    echo "<td>".profile_section_dropdown($psid,"t_move","_$i")."</td></tr>";
}

// Draw a row for a new section to be created
echo "<tr><td>NEW</td>\n";
echo "<td><input type=\"text\" name=\"t_name_new\" width=\"64\" maxchars=\"64\" value=\"New Item\"></td>";
echo "<td align=\"center\">-</td></tr>\n";
echo "<tr><td colspan=\"5\">&nbsp;</td></tr>\n";
echo "<tr><td colspan=\"5\" align=\"right\">\n";
echo "<input type=\"hidden\" name=\"t_psid\" value=\"$psid\">\n";
echo "<input type=\"hidden\" name=\"t_count\" value=\"$result_count\">\n";
echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"button\">\n";
echo "</td></tr></table>\n";
echo "</form>\n";
echo "</td></tr></table>\n";
echo "</div>\n";

html_draw_bottom();

?>