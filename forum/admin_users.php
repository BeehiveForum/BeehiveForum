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
require_once("./include/format.inc.php");
require_once("./include/constants.inc.php");

html_draw_top();

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

// Column sorting stuff

if (isset($HTTP_GET_VARS['sort_by'])) {
    if ($HTTP_GET_VARS['sort_by'] == "UID") {
        $sort_by = "UID";
    } elseif ($HTTP_GET_VARS['sort_by'] == "LOGON") {
        $sort_by = "LOGON";
    } elseif ($HTTP_GET_VARS['sort_by'] == "NICKNAME") {
        $sort_by = "NICKNAME";
    } elseif ($HTTP_GET_VARS['sort_by'] == "STATUS") {
        $sort_by = "STATUS";
    } elseif ($HTTP_GET_VARS['sort_by'] == "LAST_LOGON") {
        $sort_by = "LAST_LOGON";
    } elseif ($HTTP_GET_VARS['sort_by'] == "LOGON_FROM") {
        $sort_by = "LOGON_FROM";
    }
} else {
    $sort_by = "LAST_LOGON";
}

if (isset($HTTP_GET_VARS['sort_dir'])) {
    if ($HTTP_GET_VARS['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

if (isset($HTTP_GET_VARS['usersearch']) && isset($HTTP_GET_VARS['submit']) && $HTTP_GET_VARS['submit'] == 'Search') {
    $usersearch = $HTTP_GET_VARS['usersearch'];
}else {
    $usersearch = '';
}

// Draw the form
echo "<h1>Manage Users</h1>\n";
echo "<p>This list shows a selection of users who have logged on to your forum, sorted by $sort_by. To alter a user's permissions click their name.</p>\n";
echo "<p>To see the last few users to logon, sort the list by LAST_LOGON.</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";

if ($sort_by == 'UID' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch\">UID</a></td>\n";
}else {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch\">UID</a></td>\n";
}

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch\">Logon</a></td>\n";
}else {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch\">Logon</a></td>\n";
}

if ($sort_by == 'STATUS' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=STATUS&amp;sort_dir=DESC&amp;usersearch=$usersearch\">Status</a></td>\n";
}else {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=STATUS&amp;sort_dir=ASC&amp;usersearch=$usersearch\">Status</a></td>\n";
}

if ($sort_by == 'LAST_LOGON' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch\">Last Logon</a></td>\n";
}else {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch\">Last Logon</a></td>\n";
}

if ($sort_by == 'LOGON_FROM' && $sort_dir == 'ASC') {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON_FROM&amp;sort_dir=DESC&amp;usersearch=$usersearch\">Logon From</a></td>\n";
}else {
  echo "          <td class=\"subhead\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON_FROM&amp;sort_dir=ASC&amp;usersearch=$usersearch\">Logon From</a></td>\n";
}

echo "        </tr>\n";

$db = db_connect();

if (isset($usersearch) && strlen($usersearch) > 0) {

  $sql = "SELECT UID, LOGON, STATUS, UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON, ";
  $sql.= "LOGON_FROM FROM " . forum_table("USER") . " WHERE LOGON LIKE '%$usersearch%' ";
  $sql.= "OR NICKNAME LIKE '%$usersearch%' ORDER BY $sort_by $sort_dir LIMIT 0, 20";

}else {

  $sql = "SELECT UID, LOGON, STATUS, UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON, ";
  $sql.= "LOGON_FROM FROM " . forum_table("USER") . " WHERE UID > 0 ORDER BY $sort_by $sort_dir LIMIT 0, 20";

}

$result = db_query($sql,$db);

if (db_num_rows($result)) {

    while ($row = db_fetch_array($result)) {

        echo "        <tr>\n";
        echo "          <td class=\"posthead\">", $row['UID'], "</td>\n";
        echo "          <td class=\"posthead\"><a href=\"./admin_user.php?uid=", $row['UID'], "\">", $row['LOGON'], "</a></td>\n";
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

        echo "          <td class=\"posthead\">", format_time($row['LAST_LOGON'], 1), "</td>\n";
        echo "          <td class=\"posthead\">", $row['LOGON_FROM'], "</td>\n";
        echo "        </tr>\n";

    }

}else {

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "        <tr>\n";
        echo "          <td class=\"posthead\" colspan=\"6\">No matches found.</td>\n";
        echo "        </tr>\n";

    }else {

        // Shouldn't happen ever, after all how did you get here if there are no user accounts?

        echo "        <tr>\n";
        echo "          <td class=\"posthead\" colspan=\"6\">No user accounts in database.</td>\n";
        echo "        </tr>\n";

    }

}

echo "        <tr>\n";
echo "          <td colspan=\"6\">&nbsp;</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<p>&nbsp;</p>\n";
echo "<table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\">Search for a user not in list:</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td class=\"posthead\">\n";
echo "            <form method=\"get\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\">\n";
echo "              Username: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', 'Search'), " ", form_submit('submit', 'Clear'), "\n";
echo "              ", form_input_hidden('sort_by', $sort_by), form_input_hidden('sort_dir', $sort_dir), "\n";
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