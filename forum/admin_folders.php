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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

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
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/admin.inc.php");

html_draw_top();

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

// Do updates
if (isset($HTTP_POST_VARS['submit'])) {
    for($i = 0; $i < $HTTP_POST_VARS['t_count']; $i++) {
        if($HTTP_POST_VARS['t_title_'.$i] != $HTTP_POST_VARS['t_old_title_'.$i] || $HTTP_POST_VARS['t_access_'.$i] != $HTTP_POST_VARS['t_old_access_'.$i]) {
            $new_title = (trim($HTTP_POST_VARS['t_title_'.$i]) != "") ? $HTTP_POST_VARS['t_title_'.$i] : $HTTP_POST_VARS['t_old_title_'.$i];
            folder_update($HTTP_POST_VARS['t_fid_'.$i], $new_title, $HTTP_POST_VARS['t_access_'.$i]);
            admin_addlog(0, $HTTP_POST_VARS['t_fid_'.$i], 0, 0, 0, 0, 7);
        }
        if($HTTP_POST_VARS['t_fid_'.$i] != $HTTP_POST_VARS['t_move_'.$i]){
            folder_move_threads($HTTP_POST_VARS['t_fid_'.$i], $HTTP_POST_VARS['t_move_'.$i]);
            admin_addlog(0, $HTTP_POST_VARS['t_fid_'.$i], 0, 0, 0, 0, 8);
        }
    }
    if(trim($HTTP_POST_VARS['t_title_new']) != "" && $HTTP_POST_VARS['t_title_new'] != "New Folder"){
        $new_fid = folder_create($HTTP_POST_VARS['t_title_new'],$HTTP_POST_VARS['t_access_new']);
        admin_addlog(0, $new_fid, 0, 0, 0, 0, 9);
    }
}

// Draw the form
echo "<h1>Manage Folders</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\"><tr><td class=\"posthead\">";

echo "<form name=\"f_folders\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\">\n";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
echo "<td class=\"subhead\" align=\"left\">ID</td>\n";
echo "<td class=\"subhead\" align=\"left\">Folder Name</td>\n";
echo "<td class=\"subhead\" align=\"left\">Access Level</td>\n";
echo "<td class=\"subhead\" align=\"left\">Threads</td>\n";
echo "<td class=\"subhead\" align=\"left\">Move</td>\n";
echo "</tr>\n";

$folder_array = folder_get_all();

foreach ($folder_array as $key => $folder) {

    // If the thread count is 1, then it's probably 0.
    if($folder['THREAD_COUNT'] == 1) $folder['THREAD_COUNT'] = 0;

    echo "<tr>\n";
    echo "  <td align=\"left\">". $folder['FID']. form_input_hidden("t_fid_$key", $folder['FID']). "</td>\n";
    echo "  <td align=\"left\">". form_field("t_title_$key", $folder['TITLE'], 32, 32). form_input_hidden("t_old_title_$key", $folder['TITLE']). "</td>\n";

    // Draw the ACCESS_LEVEL dropdown
    echo "  <td align=\"left\">".form_dropdown_array("t_access_$key", array(-1, 0, 1), array("Closed", "Open", "Restricted"), $folder['ACCESS_LEVEL']);
    echo form_input_hidden("t_old_access_$key", $folder['ACCESS_LEVEL']). "</td>\n";

    echo "  <td align=\"left\">". $folder['THREAD_COUNT']. "</td>\n";
    echo "  <td align=\"left\">". folder_draw_dropdown($folder['FID'], "t_move", "_$key"). "</td>\n";
    echo "</tr>\n";
}

// Draw a row for a new folder to be created
echo "<tr>\n";
echo "  <td align=\"left\">NEW</td>\n";
echo "  <td align=\"left\">". form_field("t_title_new", "New Folder", 32, 32). "</td>\n";
echo "  <td align=\"left\">". form_dropdown_array("t_access_new", array(-1,0,1), array("Closed", "Open", "Restricted")). "</td>\n";
echo "  <td align=\"left\">-</td>\n";
echo "  <td align=\"left\">&nbsp;</td>\n";
echo "</tr>\n";

echo "<tr><td colspan=\"5\">&nbsp;</td></tr>\n";
echo "<tr><td colspan=\"5\" align=\"right\">\n";
echo form_input_hidden("t_count", sizeof($folder_array));
echo form_submit();
echo "</td></tr></table>\n";
echo "</form>";
echo "</td></tr></table>\n";
echo "</div>\n";

html_draw_bottom();

?>
