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

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user_profile.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

echo "<h1>Edit Profile</h1>\n";
echo "<p>&nbsp;</p>\n";

$uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

// Do updates
if(isset($HTTP_POST_VARS['submit'])){
    for($i=0;$i<$HTTP_POST_VARS['t_count'];$i++){
        if($HTTP_POST_VARS['t_entry_'.$i] != $HTTP_POST_VARS['t_old_entry_'.$i]){
            $entry = trim($HTTP_POST_VARS['t_entry_'.$i]);
            if($HTTP_POST_VARS['t_new_'.$i] == "Y"){
                user_profile_create($uid,$HTTP_POST_VARS['t_piid_'.$i],$entry);
            } else {
                user_profile_update($uid,$HTTP_POST_VARS['t_piid_'.$i],$entry);
            }
        }
    }
    echo "<p>Profile updated.</p>";
}

// Draw the form
echo "<div align=\"center\">\n";
echo "<table width=\"96%\"><tr><td class=\"box\">";

echo "<form name=\"f_profile\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
echo "<table class=\"posthead\" width=\"100%\">\n";

$db = db_connect();

$sql = "select PROFILE_SECTION.PSID, PROFILE_SECTION.NAME as SECTION_NAME, ";
$sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME as ITEM_NAME, ";
$sql.= "USER_PROFILE.PIID as CHECK_PIID, USER_PROFILE.ENTRY ";
$sql.= "from " . forum_table("PROFILE_SECTION") . " PROFILE_SECTION, ";
$sql.= forum_table("PROFILE_ITEM") . " PROFILE_ITEM ";
$sql.= "left join " . forum_table("USER_PROFILE") . " USER_PROFILE ";
$sql.= "on (USER_PROFILE.PIID = PROFILE_ITEM.PIID and USER_PROFILE.UID = $uid) ";
$sql.= "where PROFILE_ITEM.PSID = PROFILE_SECTION.PSID ";
$sql.= "order by PROFILE_SECTION.PSID, PROFILE_ITEM.PIID";

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

if($result_count == 0){
    echo "<p>The forum owner has not set up Profiles.</p>";
    html_draw_bottom();
    exit;
}

$last_psid = -1;

for($i=0;$i<$result_count;$i++){

    $row = db_fetch_array($result);

    $new = isset($row['CHECK_PIID']) ? "N" : "Y";
    $row['ENTRY'] = stripslashes($row['ENTRY']);

    if($row['PSID'] != $last_psid){
        if($last_psid > -1){
            echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
        }
        echo "<tr><td class=\"subhead\" colspan=\"2\">".$row['SECTION_NAME']."</td></tr>\n";
        $last_psid = $row['PSID'];
    }

    echo "<tr><td>".$row['ITEM_NAME']."<input type=\"hidden\" name=\"t_piid_$i\" value=\"".$row['PIID']."\"></td>\n";
    echo "<td><input type=\"text\" name=\"t_entry_$i\" width=\"80\" maxchars=\"255\" value=\"".$row['ENTRY']."\">";
    echo "<input type=\"hidden\" name=\"t_old_entry_$i\" value=\"".$row['ENTRY']."\">";
    echo "<input type=\"hidden\" name=\"t_new_$i\" value=\"$new\"></td></tr>";
}

echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
echo "<tr><td colspan=\"2\" align=\"right\">\n";
echo "<input type=\"hidden\" name=\"t_count\" value=\"$result_count\">\n";
echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"button\">\n";
echo "</td></tr></table>\n";
echo "</form>\n";
echo "</td></tr></table>\n";
echo "</div>\n";

html_draw_bottom();

?>