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

/* $Id: admin_folders.php,v 1.42 2004-01-14 20:42:26 decoyduck Exp $ */

// Frameset for thread list and messages

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

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
require_once("./include/lang.inc.php");
require_once("./include/format.inc.php");

html_draw_top();

if(!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)){
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Do updates
if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['t_fid'])) {

        foreach($HTTP_POST_VARS['t_fid'] as $fid => $value) {
                
            $new_title  = trim(_stripslashes($HTTP_POST_VARS['t_title'][$fid]));
            $new_desc   = trim(_stripslashes($HTTP_POST_VARS['t_desc'][$fid]));

	    $new_access = (is_numeric($HTTP_POST_VARS['t_access'][$fid]))   ? $HTTP_POST_VARS['t_access'][$fid]   : 0;
            $new_allow  = (is_numeric($HTTP_POST_VARS['t_allow'][$fid]))    ? $HTTP_POST_VARS['t_allow'][$fid]    : 0;
	    $new_pos    = (is_numeric($HTTP_POST_VARS['t_position'][$fid])) ? $HTTP_POST_VARS['t_position'][$fid] : 0;

            folder_update($HTTP_POST_VARS['t_fid'][$fid], $new_title, $new_access, $new_desc, $new_allow, $new_pos);
            admin_addlog(0, $HTTP_POST_VARS['t_fid'][$fid], 0, 0, 0, 0, 7);

            if ($HTTP_POST_VARS['t_fid'][$fid] != $HTTP_POST_VARS['t_move'][$fid]) {
                folder_move_threads($HTTP_POST_VARS['t_fid'][$fid], $HTTP_POST_VARS['t_move'][$fid]);
                admin_addlog(0, $HTTP_POST_VARS['t_fid'][$fid], 0, 0, 0, 0, 8);
            }
        }
    }

    if (strlen(trim(_stripslashes($HTTP_POST_VARS['t_title_new']))) > 0 && trim(_stripslashes($HTTP_POST_VARS['t_title_new'])) != $lang['newfolder']) {

        $new_title  = trim(_stripslashes($HTTP_POST_VARS['t_title_new']));
	$new_desc   = trim(_stripslashes($HTTP_POST_VARS['t_desc_new']));
        $new_access = (is_numeric($HTTP_POST_VARS['t_access_new'])) ? $HTTP_POST_VARS['t_access_new'] : 0;
	$new_allow  = (is_numeric($HTTP_POST_VARS['t_allow_new'])) ? $HTTP_POST_VARS['t_allow_new'] : 0;
	$new_pos    = (isset($HTTP_POST_VARS['t_fid'])) ? sizeof($HTTP_POST_VARS['t_fid']) : 1;
        
        $new_fid = folder_create($new_title, $new_access, $new_desc, $new_allow, $new_pos );
        admin_addlog(0, $new_fid, 0, 0, 0, 0, 9);

    }
}

// Draw the form
echo "<h1>{$lang['managefolders']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"./admin_folders.php\" method=\"post\">\n";
echo "  <table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td class=\"posthead\">\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['position']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['foldername']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['description']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['accesslevel']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['threadcount']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['move']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['allow']}</td>\n";
echo "            <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['permissions']}</td>\n";
echo "          </tr>\n";

$folder_array = folder_get_all();

// Make the arrays for the allow post types dropdown

$allow_labels = array($lang['normalthreadsonly'], $lang['pollthreadsonly'], $lang['both']);
$allow_values = array(FOLDER_ALLOW_NORMAL_THREAD, FOLDER_ALLOW_POLL_THREAD, FOLDER_ALLOW_ALL_THREAD);

if ($folder_array = folder_get_all()) {

    for ($i = 0; $i < sizeof($folder_array); $i++) {

        if (!isset($folder_array[$i]['DESCRIPTION']) || is_null($folder_array[$i]['DESCRIPTION'])) $folder_array[$i]['DESCRIPTION'] = "";
        if (!isset($folder_array[$i]['ALLOWED_TYPES']) || is_null($folder_array[$i]['ALLOWED_TYPES'])) $folder_array[$i]['ALLOWED_TYPES'] = FOLDER_ALLOW_ALL_THREAD;

        echo "          <tr>\n";
        echo "            <td align=\"left\">", form_dropdown_array("t_position[{$folder_array[$i]['FID']}]", range(1, sizeof($folder_array) + 1), range(1, sizeof($folder_array) + 1), $i + 1), form_input_hidden("t_old_position[{$folder_array[$i]['FID']}]", $i), form_input_hidden("t_fid[{$folder_array[$i]['FID']}]", $folder_array[$i]['FID']), "</td>\n";
        echo "            <td align=\"left\">". form_field("t_title[{$folder_array[$i]['FID']}]", $folder_array[$i]['TITLE'], 25, 32). form_input_hidden("t_old_title[{$folder_array[$i]['FID']}]", $folder_array[$i]['TITLE']). "</td>\n";
        echo "            <td align=\"left\">". form_field("t_desc[{$folder_array[$i]['FID']}]", $folder_array[$i]['DESCRIPTION'], 32, 255). form_input_hidden("t_old_desc[{$folder_array[$i]['FID']}]", $folder_array[$i]['DESCRIPTION']). "</td>\n";

        // Draw the ACCESS_LEVEL dropdown
        echo "            <td align=\"left\">".form_dropdown_array("t_access[{$folder_array[$i]['FID']}]", array(-1, 0, 1), array($lang['closed'], $lang['open'], $lang['restricted']), $folder_array[$i]['ACCESS_LEVEL']);
        echo form_input_hidden("t_old_access[{$folder_array[$i]['FID']}]", $folder_array[$i]['ACCESS_LEVEL']). "</td>\n";

        echo "            <td align=\"left\">". $folder_array[$i]['THREAD_COUNT']. "</td>\n";
        echo "            <td align=\"left\">". folder_draw_dropdown($folder_array[$i]['FID'], "t_move", "[{$folder_array[$i]['FID']}]"). "</td>\n";
        echo "            <td align=\"left\">". form_dropdown_array("t_allow[{$folder_array[$i]['FID']}]", $allow_values, $allow_labels, $folder_array[$i]['ALLOWED_TYPES'] ? $folder_array[$i]['ALLOWED_TYPES'] : FOLDER_ALLOW_NORMAL_THREAD | FOLDER_ALLOW_POLL_THREAD).form_input_hidden("t_old_allow[{$folder_array[$i]['FID']}]", $folder_array[$i]['ALLOWED_TYPES'])."</td>\n";

        if ($folder_array[$i]['ACCESS_LEVEL'] > 0) {
            echo "            <td align=\"left\">", form_button("permissions", $lang['change'], "onclick=\"document.location.href='admin_folder_access.php?fid={$folder_array[$i]['FID']}'\""), "</td>\n";
        }else {
            echo "            <td align=\"left\">&nbsp;</td>";
        }

        echo "</tr>\n";
    }
}

// Draw a row for a new folder to be created
echo "          <tr>\n";
echo "            <td align=\"left\">NEW</td>\n";
echo "            <td align=\"left\">". form_field("t_title_new", $lang['newfolder'], 25, 32). "</td>\n";
echo "            <td align=\"left\">". form_field("t_desc_new", "", 32, 255). "</td>\n";
echo "            <td align=\"left\">". form_dropdown_array("t_access_new", array(-1,0,1), array($lang['closed'], $lang['open'], $lang['restricted'])). "</td>\n";
echo "            <td align=\"left\">&nbsp;</td>\n";
echo "            <td align=\"left\">&nbsp;</td>\n";
echo "            <td align=\"left\">".form_dropdown_array("t_allow_new", $allow_values, $allow_labels, FOLDER_ALLOW_ALL_THREAD)."</td>\n";
echo "            <td align=\"left\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"8\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <p>", form_input_hidden("t_count", sizeof($folder_array)), form_submit('submit', 'Save'), "</p>\n";
echo "</form>";
echo "</div>\n";

html_draw_bottom();

?>