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

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");


if($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {
        html_guest_error();
        exit;
}


require_once("./include/forum.inc.php");
require_once("./include/form.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user_profile.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/format.inc.php");


html_draw_top();


echo "<h1>Edit Profile</h1>\n";
echo "<br />\n";


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
echo "<table width=\"600\" class=\"box\">\n  <tr>\n    <td class=\"posthead\">\n";


echo "      <form name=\"f_profile\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\">\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";


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
    $row['ENTRY'] = isset($row['ENTRY']) ? _stripslashes($row['ENTRY']) : "";


    if($row['PSID'] != $last_psid){
        if($last_psid > -1){
            echo "          <tr>\n            <td colspan=\"2\">&nbsp;</td>\n          </tr>\n";
        }
        echo "          <tr>\n            <td class=\"subhead\" colspan=\"2\">". $row['SECTION_NAME']. "</td>\n          </tr>\n";
        $last_psid = $row['PSID'];
    }


    echo "          <tr>\n            <td>".$row['ITEM_NAME'].form_input_hidden("t_piid_$i",$row['PIID'])."</td>\n";
    echo "            <td nowrap=\"nowrap\" align=\"right\">:&nbsp;". form_field("t_entry_$i",$row['ENTRY'], 60, 255);
    echo form_input_hidden("t_old_entry_$i", $row['ENTRY']);
    echo form_input_hidden("t_new_$i", $new)."&nbsp;&nbsp;</td>\n          </tr>\n";
}


echo "          <tr>\n            <td colspan=\"2\">&nbsp;</td>\n          </tr>\n";
echo "          <tr>\n            <td colspan=\"2\" align=\"right\">";
echo form_input_hidden("t_count", $result_count);
echo form_submit("submit", "Submit");
echo "</td>\n          </tr>\n        </table>\n";
echo "      </form>\n";
echo "    </td>\n  </tr>\n</table>\n";


html_draw_bottom();


?>
