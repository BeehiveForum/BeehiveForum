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
require_once("./include/folder.inc.php");
require_once("./include/constants.inc.php");

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
        if($HTTP_POST_VARS['t_title_'.$i] != $HTTP_POST_VARS['t_old_title_'.$i]
        || $HTTP_POST_VARS['t_access_'.$i] != $HTTP_POST_VARS['t_old_access_'.$i]){
            $new_title = (trim($HTTP_POST_VARS['t_title_'.$i]) != "") ? $HTTP_POST_VARS['t_title_'.$i] : $HTTP_POST_VARS['t_old_title_'.$i];
            folder_update($HTTP_POST_VARS['t_fid_'.$i],$new_title,$HTTP_POST_VARS['t_access_'.$i]);
        }
        if($HTTP_POST_VARS['t_fid_'.$i] != $HTTP_POST_VARS['t_move_'.$i]){
            folder_move_threads($HTTP_POST_VARS['t_fid_'.$i], $HTTP_POST_VARS['t_move_'.$i]);
        }
    }
    if(trim($HTTP_POST_VARS['t_title_new']) != "" && $HTTP_POST_VARS['t_title_new'] != "New Folder"){
        folder_create($HTTP_POST_VARS['t_title_new'],$HTTP_POST_VARS['t_access_new']);
    }
}


// Draw the form
echo "<h1>Manage Folders</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\"><tr><td class=\"box\">";

echo "<form name=\"f_folders\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">\n";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
echo "<td class=\"subhead\">ID</td>\n";
echo "<td class=\"subhead\">Folder Name</td>\n";
echo "<td class=\"subhead\">Access Level</td>\n";
echo "<td class=\"subhead\">Threads</td>\n";
echo "<td class=\"subhead\">Move</td>\n";
echo "</tr>\n";

$db = db_connect();

$sql = "select FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL, count(*) as THREAD_COUNT ";
$sql.= "from " . forum_table("FOLDER") . " FOLDER LEFT JOIN " . forum_table("THREAD") . " THREAD ";
$sql.= " on (THREAD.FID = FOLDER.FID) ";
$sql.= "group by FOLDER.FID, FOLDER.TITLE, FOLDER.ACCESS_LEVEL";

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i=0;$i<$result_count;$i++){

    $row = db_fetch_array($result);

    // If the thread count is 1, then it's probably 0.
    if($row['THREAD_COUNT'] == 1) $row['THREAD_COUNT'] = 0;

    // Use this array to select the relevant ACCESS_LEVEL in the dropdown
    $sel = array("","","");
    $sel[$row['ACCESS_LEVEL']+1] = " selected";

    echo "<tr><td>".$row['FID']."<input type=\"hidden\" name=\"t_fid_$i\" value=\"".$row['FID']."\"></td>\n";
    echo "<td><input type=\"text\" name=\"t_title_$i\" width=\"32\" maxchars=\"32\" value=\"".$row['TITLE']."\">";
    echo "<input type=\"hidden\" name=\"t_old_title_$i\" value=\"".$row['TITLE']."\"></td>";

    // Draw the ACCESS_LEVEL dropdown
    echo "<td><select name=\"t_access_$i\">\n";
    echo "<option value=\"-1\"".$sel[0].">Closed</option>\n";
    echo "<option value=\"0\"".$sel[1].">Open</option>\n";
    echo "<option value=\"1\"".$sel[2].">Restricted</option>\n";
    echo "</select>\n";
    echo "<input type=\"hidden\" name=\"t_old_access_$i\" value=\"".$row['ACCESS_LEVEL']."\"></td>\n";

    echo "<td>".$row['THREAD_COUNT']."</td>\n";
    echo "<td>" . folder_draw_dropdown($row['FID'],"t_move","_$i") . "</td></tr>\n";
}

// Draw a row for a new folder to be created
echo "<tr><td>NEW</td>\n";
echo "<td><input type=\"text\" name=\"t_title_new\" width=\"32\" maxchars=\"32\" value=\"New Folder\"></td>";

// Draw the ACCESS_LEVEL dropdown
echo "<td><select name=\"t_access_new\">\n";
echo "<option value=\"-1\">Closed</option>\n";
echo "<option value=\"0\" selected>Open</option>\n";
echo "<option value=\"1\">Restricted</option>\n";
echo "</select>\n";

echo "<td>-</td>\n";
echo "<td>&nbsp;</td></tr>\n";
echo "<tr><td colspan=\"5\">&nbsp;</td></tr>\n";
echo "<tr><td colspan=\"5\" align=\"right\">\n";
echo "<input type=\"hidden\" name=\"t_count\" value=\"$result_count\">\n";
echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"button\">\n";
echo "</td></tr></table>\n";
echo "</form>\n";
echo "</td></tr></table>\n";
echo "</div>\n";

html_draw_bottom();

?>
