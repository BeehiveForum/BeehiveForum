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
require_once("./include/profile.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/admin.inc.php");

html_draw_top();

if(!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

$db = db_connect();

// Do updates

if(isset($HTTP_GET_VARS['psid'])){

  $psid = $HTTP_GET_VARS['psid'];

}else if(isset($HTTP_POST_VARS['t_psid'])){

  $psid = $HTTP_POST_VARS['t_psid'];

}else {

  echo "<h1>Invalid Operation</h1>\n";
  echo "<p>No Profile Section specified.</p>\n";
  html_draw_bottom();
  exit;

}

if(isset($HTTP_POST_VARS['submit'])) {

  if ($HTTP_POST_VARS['submit'] == "Submit") {

    for($i = 0; $i < $HTTP_POST_VARS['t_count']; $i++) {

        if($HTTP_POST_VARS['t_name_'.$i] != $HTTP_POST_VARS['t_old_name_'.$i] || $HTTP_POST_VARS['t_move_'.$i] != $psid){
            $new_name = (trim($HTTP_POST_VARS['t_name_'.$i]) != "") ? $HTTP_POST_VARS['t_name_'.$i] : $HTTP_POST_VARS['t_old_name_'.$i];
            profile_item_update($HTTP_POST_VARS['t_piid_'.$i],$HTTP_POST_VARS['t_move_'.$i],$new_name);
            admin_addlog(0, 0, 0, 0, $psid, $HTTP_POST_VARS['t_piid_'.$i], 13);
        }

    }

    if(trim($HTTP_POST_VARS['t_name_new']) != "" && $HTTP_POST_VARS['t_name_new'] != "New Item"){
        $new_piid = profile_item_create($psid,$HTTP_POST_VARS['t_name_new']);
        admin_addlog(0, 0, 0, 0, $psid, $new_piid, 14);
    }

  }elseif ($HTTP_POST_VARS['submit'] == "Delete") {

    $sql = "delete from ". forum_table("PROFILE_ITEM"). " where PIID = ". $HTTP_POST_VARS['piid'];
    $result = db_query($sql, $db);
    admin_addlog(0, 0, 0, 0, 0, $HTTP_POST_VARS['piid'], 15);

  }

}

// Draw the form
echo "<h1>Manage Profile Items<br />Section: ".profile_section_get_name($psid)."</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <form name=\"f_items\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\">\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" align=\"left\">ID</td>\n";
echo "            <td class=\"subhead\" align=\"left\">Item Name</td>\n";
echo "            <td class=\"subhead\" align=\"left\">Move to</td>\n";
echo "            <td class=\"subhead\" align=\"left\">Delete Item</td>\n";
echo "          </tr>\n";

$sql = "select PROFILE_ITEM.PIID, PROFILE_ITEM.NAME ";
$sql.= "from " . forum_table("PROFILE_ITEM") . " PROFILE_ITEM ";
$sql.= "where PROFILE_ITEM.PSID = $psid ";
$sql.= "order by PROFILE_ITEM.PIID";

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i=0;$i<$result_count;$i++){

    $row = db_fetch_array($result);

    echo "          <tr>\n";
    echo "            <td valign=\"top\" align=\"left\">", $row['PIID'], form_input_hidden("t_piid_$i",$row['PIID']), "</td>\n";
    echo "            <td valign=\"top\" align=\"left\">", form_field("t_name_$i",$row['NAME'],64,64), form_input_hidden("t_old_name_$i", $row['NAME']), "</td>\n";
    echo "            <td valign=\"top\" align=\"left\">", profile_section_dropdown($psid,"t_move","_$i"), "</td>\n";
    echo "            <td valign=\"top\" align=\"left\" width=\"100\">", form_input_hidden("t_psid", $psid), form_input_hidden("piid", $row['PIID']). form_submit("submit", "Delete"), "</td>\n";
    echo "          </tr>\n";

}

// Draw a row for a new section to be created
echo "          <tr>\n";
echo "            <td align=\"left\">NEW</td>\n";
echo "            <td align=\"left\">", form_field("t_name_new","New Item",64,64), "</td>";
echo "            <td align=\"center\">&nbsp;</td>\n";
echo "            <td align=\"center\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"4\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"4\" align=\"right\">", form_input_hidden("t_psid",$psid), form_input_hidden("t_count",$result_count), form_submit(), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>