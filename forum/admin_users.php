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

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

// Draw the form
echo "<h1>Manage Users</h1>\n";
echo "<p>Click on a user's name to alter their permissions</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort=UID\">UID</a></td>\n";
echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort=LOGON\">Logon</a></td>\n";
echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort=NICKNAME\">Nickname</a></td>\n";
echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort=STATUS\">Status</a></td>\n";
echo "        </tr>\n";

$db = db_connect();

$sql = "select UID, LOGON, NICKNAME, STATUS from " . forum_table("USER") . " where UID > 0 order by ";

if (isset($HTTP_GET_VARS['sort'])) {
  if ($HTTP_GET_VARS['sort'] == 'STATUS') {
    $sql.= "STATUS desc";
  }else {
    $sql.= $HTTP_GET_VARS['sort'];
  }
}else {
  $sql.= "UID";
}

$result = db_query($sql,$db);

$result_count = db_num_rows($result);

for($i=0; $i < $result_count; $i++){

    $row = db_fetch_array($result);

    echo "        <tr>\n";
    echo "          <td class=\"posthead\">", $row['UID'], "</td>\n";
    echo "          <td class=\"posthead\"><a href=\"./admin_user.php?uid=", $row['UID'], "\">", $row['LOGON'], "</a></td>\n";
    echo "          <td class=\"posthead\">", $row['NICKNAME'], "</td>\n";
    echo "          <td class=\"posthead\">";

    if (isset($row['STATUS']) && $row['STATUS'] > 0) {

      if ($row['STATUS'] & USER_PERM_QUEEN)   echo "Queen ";
      if ($row['STATUS'] & USER_PERM_SOLDIER) echo "Soldier ";
      if ($row['STATUS'] & USER_PERM_WORKER)  echo "Worker ";
      if ($row['STATUS'] & USER_PERM_WORM)    echo "Worm ";
      if ($row['STATUS'] & USER_PERM_WASP)    echo "Wasp ";
      if ($row['STATUS'] & USER_PERM_SPLAT)   echo "Splat";

      echo " (", $row['STATUS'], ")</td>\n";

    }else {
      echo "&nbsp;</td>\n";
    }

    echo "        </tr>\n";

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>