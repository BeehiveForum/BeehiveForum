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
require_once("./include/lang.inc.php");

if (!bh_session_check()) {

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

if (isset($HTTP_GET_VARS['offset'])) {
    $start = $HTTP_GET_VARS['offset'];
}else {
    $start = 0;
}

if (isset($HTTP_GET_VARS['usersearch']) && isset($HTTP_GET_VARS['submit']) && $HTTP_GET_VARS['submit'] == 'Search') {
    $usersearch = $HTTP_GET_VARS['usersearch'];
}else {
    $usersearch = '';
}

html_draw_top_script();

echo "<h1>{$lang['recentvisitors']}</h1><br />\n";

$db = db_connect();

if (isset($usersearch) && strlen($usersearch) > 0) {

  $sql = "SELECT UID, LOGON, NICKNAME, UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON ";
  $sql.= "FROM ". forum_table("USER"). " WHERE LOGON LIKE '%$usersearch%' OR ";
  $sql.= "NICKNAME LIKE '%$usersearch%' ORDER BY LAST_LOGON DESC LIMIT $start, 20";

}else {

  $sql = "SELECT UID, LOGON, NICKNAME, UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON ";
  $sql.= "FROM ". forum_table("USER"). " ORDER BY LAST_LOGON DESC LIMIT $start, 20";

}

$result = db_query($sql, $db);

echo "<div align=\"center\">\n";
echo "<table width=\"65%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\" align=\"left\">{$lang['member']}</td>\n";
echo "          <td class=\"subhead\" align=\"right\" width=\"200\">{$lang['lastvisit']}</td>\n";
echo "        </tr>\n";

while ($row = db_fetch_array($result)) {

  echo "        <tr>\n";
  echo "          <td class=\"postbody\" align=\"left\"><a href=\"#\" target=\"_self\" onclick=\"openProfile(", $row['UID'], ")\">", format_user_name($row['LOGON'], $row['NICKNAME']), "</a></td>\n";
  echo "          <td class=\"postbody\" align=\"right\" width=\"200\">", format_time($row['LAST_LOGON']), "</td>\n";
  echo "        </tr>\n";

}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (db_num_rows($result) == 20) {
  if ($start < 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"visitor_log.php?offset=", $start + 20, "\" target=\"_self\">{$lang['more']}</a></p>\n";
  }elseif ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"visitor_log.php\" target=\"_self\">{$lang['recentvisitors']}</a><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"visitor_log.php?offset=", $start + 20, "\" target=\"_self\">{$lang['more']}</a></p>\n";
  }
}else {
  if ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"visitor_log.php\" target=\"_self\">{$lang['recentvisitors']}</a><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>";
  }
}

echo "<p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>\n";
echo "<table width=\"65%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td class=\"posthead\" align=\"left\">\n";
echo "            <form method=\"get\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" target=\"_self\">\n";
echo "              {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('submit', $lang['clear']), "\n";
echo "            </form>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo "</div>\n";

html_draw_bottom();

?>
