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
require_once("./include/form.inc.php");

html_draw_top();

if(!$HTTP_COOKIE_VARS[bh_sess_ustatus] & USER_PERM_SOLDIER){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

// Do updates
if(isset($HTTP_POST_VARS['submit'])){
    for($i=0;$i<$HTTP_POST_VARS['t_count'];$i++){
        if($HTTP_POST_VARS['t_name_'.$i] != $HTTP_POST_VARS['t_old_name_'.$i]){
            $new_name = (trim($HTTP_POST_VARS['t_name_'.$i]) != "") ? $HTTP_POST_VARS['t_name_'.$i] : $HTTP_POST_VARS['t_old_name_'.$i];
            profile_section_update($HTTP_POST_VARS['t_psid_'.$i],$new_name);
        }
    }
    if(trim($HTTP_POST_VARS['t_name_new']) != "" && $HTTP_POST_VARS['t_name_new'] != "New Section"){
        profile_section_create($HTTP_POST_VARS['t_name_new']);
    }
}


// Draw the form
echo "<h1>Manage Profile Sections</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\"><tr><td class=\"box\">";

echo "<form name=\"f_sections\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
echo "<td class=\"subhead\">ID</td>\n";
echo "<td class=\"subhead\">Section Name</td>\n";
echo "<td class=\"subhead\">&nbsp</td>\n";
echo "</tr>\n";

$db = db_connect();

$sql = "select PROFILE_SECTION.PSID, PROFILE_SECTION.NAME ";
$sql.= "from " . forum_table("PROFILE_SECTION") . " PROFILE_SECTION ";
$sql.= "order by PROFILE_SECTION.PSID";

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i=0;$i<$result_count;$i++){

    $row = db_fetch_array($result);

    echo "<tr><td>".$row['PSID'].form_input_hidden("t_psid_$i",$row['PSID'])."</td>\n";
    echo "<td>".form_field("t_name_$i",$row['NAME'],64,64);
    echo form_input_hidden("t_old_name_$i",$row['NAME'])."</td>";
    echo "<td><a href=\"./admin_prof_items.php?psid=".$row['PSID']."\">Items...</a></td></tr>";
}

// Draw a row for a new section to be created
echo "<tr><td>NEW</td>\n";
echo "<td>".form_field("t_name_new","New Section",64,64)."</td>";
echo "<td align=\"center\">-</td></tr>\n";
echo "<tr><td colspan=\"5\">&nbsp;</td></tr>\n";
echo "<tr><td colspan=\"5\" align=\"right\">\n";
echo form_input_hidden("t_count",$result_count);
echo form_submit();
echo "</td></tr></table>\n";
echo "</form>\n";
echo "</td></tr></table>\n";
echo "</div>\n";

html_draw_bottom();

?>
