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
require_once("./include/folder.inc.php");
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

    echo "<tr><td>".$row['FID'].form_input_hidden("t_fid_$i",$row['FID'])."</td>\n";
    echo "<td>".form_field("t_title_$i",$row['TITLE'],32,32);
    echo form_input_hidden("t_old_title_$i",$row['TITLE'])."</td>";

    // Draw the ACCESS_LEVEL dropdown
    echo "<td>".form_dropdown_array("t_access_$i",array(-1,0,1),array("Closed","Open","Restricted"),$row['ACCESS_LEVEL']);
    echo form_input_hidden("t_old_access_$i",$row['ACCESS_LEVEL'])."</td>\n";

    echo "<td>".$row['THREAD_COUNT']."</td>\n";
    echo "<td>" . folder_draw_dropdown($row['FID'],"t_move","_$i") . "</td></tr>\n";
}

// Draw a row for a new folder to be created
echo "<tr><td>NEW</td>\n";
echo "<td>".form_field("t_title_new","New Folder",32,32)."</td>";

// Draw the ACCESS_LEVEL dropdown
echo "<td>".form_dropdown_array("t_access_new",array(-1,0,1),array("Closed","Open","Restricted"));

echo "<td>-</td>\n";
echo "<td>&nbsp;</td></tr>\n";
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
