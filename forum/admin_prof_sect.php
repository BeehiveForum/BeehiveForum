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

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

$db = db_connect();

// Do updates
if(isset($HTTP_POST_VARS['submit'])){

  if ($HTTP_POST_VARS['submit'] == "Submit") {

    for($i=0;$i<$HTTP_POST_VARS['t_count'];$i++){

        if($HTTP_POST_VARS['t_name_'.$i] != $HTTP_POST_VARS['t_old_name_'.$i]){

            $new_name = (trim($HTTP_POST_VARS['t_name_'.$i]) != "") ? $HTTP_POST_VARS['t_name_'.$i] : $HTTP_POST_VARS['t_old_name_'.$i];
            profile_section_update($HTTP_POST_VARS['t_psid_'.$i], $new_name);
            admin_addlog(0, 0, 0, 0, $HTTP_POST_VARS['t_psid_'.$i], 0, 10);

        }
    }

    if(trim($HTTP_POST_VARS['t_name_new']) != "" && $HTTP_POST_VARS['t_name_new'] != "New Section"){

        $new_psid = profile_section_create($HTTP_POST_VARS['t_name_new']);
        admin_addlog(0, 0, 0, 0, $new_psid, 0, 11);

    }

  }elseif ($HTTP_POST_VARS['submit'] == "Delete") {

    $sql = "delete from ". forum_table("PROFILE_SECTION"). " where PSID = ". $HTTP_POST_VARS['psid'];
    $result = db_query($sql, $db);
    admin_addlog(0, 0, 0, 0, $HTTP_POST_VARS['psid'], 0, 12);

  }

}


// Draw the form
echo "<h1>Manage Profile Sections</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <form name=\"f_sections\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\">\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" align=\"left\">ID</td>\n";
echo "            <td class=\"subhead\" align=\"left\">Section Name</td>\n";
echo "            <td class=\"subhead\" align=\"left\">&nbsp;</td>\n";
echo "            <td class=\"subhead\" align=\"left\">&nbsp;</td>\n";
echo "          </tr>\n";

$sql = "select PROFILE_SECTION.PSID, PROFILE_SECTION.NAME ";
$sql.= "from " . forum_table("PROFILE_SECTION") . " PROFILE_SECTION ";
$sql.= "order by PROFILE_SECTION.PSID";

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i = 0; $i < $result_count; $i++){

    $row = db_fetch_array($result);

    echo "          <tr>\n";
    echo "            <td valign=\"top\" align=\"left\">", $row['PSID'], form_input_hidden("t_psid_$i",$row['PSID']), "</td>\n";
    echo "            <td valign=\"top\" align=\"left\">", form_field("t_name_$i",$row['NAME'],64,64), form_input_hidden("t_old_name_$i",$row['NAME']), "</td>\n";
    echo "            <td valign=\"top\" align=\"left\"><a href=\"./admin_prof_items.php?psid=".$row['PSID']."\">Items...</a></td>\n";
    echo "            <td>";

    $psid_sql = "select * from ". forum_table("PROFILE_ITEM"). " where PSID = ". $row['PSID'];
    $psid_result = db_query($psid_sql, $db);

    if (db_num_rows($psid_result) == 0) {

      echo form_input_hidden("psid", $row['PSID']). form_submit("submit", "Delete");

    }else{

      echo "&nbsp;";

    }

    echo "</td>\n";
    echo "          </tr>\n";
}

// Draw a row for a new section to be created
echo "          <tr>\n";
echo "            <td align=\"left\">NEW</td>\n";
echo "            <td align=\"left\">", form_field("t_name_new","New Section",64,64), "</td>\n";
echo "            <td align=\"center\" colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"4\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"4\" align=\"right\">", form_input_hidden("t_count",$result_count), form_submit(), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>
