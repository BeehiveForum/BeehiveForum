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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once('./include/db.inc.php');

if (!bh_session_check()) {

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

if (isset($HTTP_GET_VARS['offset'])) {
    $start = $HTTP_GET_VARS['offset'];
}else {
    $start = 0;
}

html_draw_top_script();

echo "<h1>Recent Visitors</h1><br />\n";

$db = db_connect();

$sql = "SELECT UID, LOGON, NICKNAME, UNIX_TIMESTAMP(LAST_LOGON) as LAST_LOGON ";
$sql.= "FROM ". forum_table("USER"). " ORDER BY LAST_LOGON LIMIT $start, 20";

$result = db_query($sql, $db);

echo "<div align=\"center\">\n";
echo "<table width=\"65%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\">Member</td>\n";
echo "          <td class=\"subhead\" align=\"right\" width=\"200\">Last Visit</td>\n";
echo "        </tr>\n";

while ($row = db_fetch_array($result)) {

  echo "        <tr>\n";
  echo "          <td class=\"postbody\"><a href=\"#\" target=\"_self\" onclick=\"openProfile(", $row['UID'], ")\">", format_user_name($row['LOGON'], $row['NICKNAME']), "</a></td>\n";
  echo "          <td class=\"postbody\" align=\"right\" width=\"200\">", format_time($row['LAST_LOGON']), "</td>\n";
  echo "        </tr>\n";

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (db_num_rows($result) == 20) {
  echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?offset=", $start, "\">More</a></p>\n";
}

echo "</div>\n";

html_draw_bottom();

?>