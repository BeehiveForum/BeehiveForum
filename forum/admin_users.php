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

/* $Id: admin_users.php,v 1.41 2003-12-22 22:41:22 decoyduck Exp $ */

// Frameset for thread list and messages

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/format.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/admin.inc.php");

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
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
    } else {
        $sort_by = "LAST_LOGON";
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

if (isset($HTTP_GET_VARS['page']) && is_numeric($HTTP_GET_VARS['page'])) {
    $start = $HTTP_GET_VARS['page'] * 20;
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

// Draw the form
echo "<h1>{$lang['manageusers']}</h1>\n";
echo "<p>{$lang['manageusersexp_1']} {$sort_by}. {$lang['manageusersexp_2']}</p>\n";
echo "<p>{$lang['manageusersexp_3']}</p>\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";

if ($sort_by == 'UID' && $sort_dir == 'ASC') {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;start=$start\">UID</a></td>\n";
}else {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;start=$start\">UID</a></td>\n";
}

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['logon']}</a></td>\n";
}else {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'STATUS' && $sort_dir == 'ASC') {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=STATUS&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['status']}</a></td>\n";
}else {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=STATUS&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['status']}</a></td>\n";
}

if ($sort_by == 'LAST_LOGON' && $sort_dir == 'ASC') {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['lastlogon']}</a></td>\n";
}else {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['lastlogon']}</a></td>\n";
}

if ($sort_by == 'LOGON_FROM' && $sort_dir == 'ASC') {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON_FROM&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['logonfrom']}</a></td>\n";
}else {
    echo "          <td class=\"subhead\" align=\"left\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?sort_by=LOGON_FROM&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;start=$start\">{$lang['logonfrom']}</a></td>\n";
}

echo "        </tr>\n";

if (isset($usersearch) && strlen($usersearch) > 0) {
    $user_array = admin_user_search($usersearch, $sort_by, $sort_dir, $start, false);
}else {
    $user_array = admin_user_get_all($sort_by, $sort_dir, $start, false);
}

if (sizeof($user_array) > 0) {

    foreach ($user_array as $user) {

        echo "        <tr>\n";
        echo "          <td class=\"posthead\" align=\"left\">", $user['UID'], "</td>\n";
        echo "          <td class=\"posthead\" align=\"left\"><a href=\"./admin_user.php?uid=", $user['UID'], "\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
        echo "          <td class=\"posthead\" align=\"left\">";

        if (isset($user['STATUS']) && $user['STATUS'] > 0) {

            if ($user['STATUS'] & USER_PERM_QUEEN)   echo "{$lang['queen']} ";
            if ($user['STATUS'] & USER_PERM_SOLDIER) echo "{$lang['soldier']} ";
            if ($user['STATUS'] & USER_PERM_WORKER)  echo "{$lang['worker']} ";
            if ($user['STATUS'] & USER_PERM_WORM)    echo "{$lang['worm']} ";
            if ($user['STATUS'] & USER_PERM_WASP)    echo "{$lang['wasp']} ";
            if ($user['STATUS'] & USER_PERM_SPLAT)   echo "{$lang['splat']}";

            echo " (", $user['STATUS'], ")</td>\n";

        }else {
          echo "&nbsp;</td>\n";
        }

        echo "          <td class=\"posthead\" align=\"left\">", format_time($user['LAST_LOGON'], 1), "</td>\n";
        echo "          <td class=\"posthead\" align=\"left\">", $user['LOGON_FROM'], "</td>\n";
        echo "        </tr>\n";

    }

}else {

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "        <tr>\n";
        echo "          <td class=\"posthead\" colspan=\"6\" align=\"left\">{$lang['nomatches']}</td>\n";
        echo "        </tr>\n";

    }else {

        // Shouldn't happen ever, after all how did you get here if there are no user accounts?

        echo "        <tr>\n";
        echo "          <td class=\"posthead\" colspan=\"6\" align=\"left\">{$lang['nouseraccounts']}</td>\n";
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

if (sizeof($user_array) == 20) {
    if ($start < 20) {
        echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
    }elseif ($start >= 20) {
        echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
        echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
        echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
    }
}else {
    if ($start >= 20) {
        echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
        echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
    }else {
        echo "<p>&nbsp;</p>\n";
    }
}

echo "<table width=\"96%\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td class=\"posthead\" align=\"left\">\n";
echo "            <form method=\"get\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\">\n";
echo "              {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
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