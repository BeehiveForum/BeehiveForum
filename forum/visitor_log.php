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

/* $Id: visitor_log.php,v 1.18 2003-12-22 22:41:22 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once('./include/db.inc.php');
require_once("./include/lang.inc.php");
require_once("./include/html.inc.php");
require_once("./include/user.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (isset($HTTP_GET_VARS['page']) && is_numeric($HTTP_GET_VARS['page'])) {
    $start = ($HTTP_GET_VARS['page'] * 20);
}else {
    $start = 0;
}

if (isset($HTTP_GET_VARS['usersearch']) && strlen(trim($HTTP_GET_VARS['usersearch'])) > 0) {
    $usersearch = $HTTP_GET_VARS['usersearch'];
}else {
    $usersearch = "";
}

if (isset($HTTP_GET_VARS['reset'])) {
    $usersearch = "";
}

html_draw_top("openprofile.js");

echo "<h1>{$lang['recentvisitors']}</h1><br />\n";

if (isset($usersearch) && strlen($usersearch) > 0) {
    $user_search_array = user_search($usersearch, "LAST_LOGON", "DESC", $start);
}else {
    $user_search_array = user_get_all("LAST_LOGON", "DESC", $start);
}

echo "<div align=\"center\">\n";
echo "<table width=\"65%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";

if ($user_search_array) {

    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['member']}</td>\n";
    echo "          <td class=\"subhead\" align=\"right\" width=\"200\">{$lang['lastvisit']}</td>\n";
    echo "        </tr>\n";

    foreach ($user_search_array as $user_search) {
        echo "        <tr>\n";
        echo "          <td class=\"postbody\" align=\"left\"><a href=\"#\" target=\"_self\" onclick=\"openProfile(", $user_search['UID'], ")\">", format_user_name($user_search['LOGON'], $user_search['NICKNAME']), "</a></td>\n";
        echo "          <td class=\"postbody\" align=\"right\" width=\"200\">", format_time($user_search['LAST_LOGON']), "</td>\n";
        echo "        </tr>\n";
    }

}else {

    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['search']}</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"postbody\" align=\"left\">{$lang['yoursearchdidnotreturnanymatches']}</td>\n";
    echo "        </tr>\n";
}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

if ((sizeof($user_search_array) == 20)) {
  if ($start < 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
  }elseif ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
  }
}else {
  if ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
  }
}

echo "<p>&nbsp;</p>\n";
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
echo "              {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
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