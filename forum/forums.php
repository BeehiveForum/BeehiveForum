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

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/myforums.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top("basetarget=_top");

echo "<h1>Available Forums</h1>\n";
echo "<br>\n";

//echo "<form action=\"\" method=\"post\" name=\"form1\" id=\"form1\">\n";

echo "<div align=\"center\">\n";
echo "<table width=\"90%\" border=\"1\" class=\"box\">\n";
echo "  <tr>\n";
echo "    <td class=\"posthead\">\n";
echo "      <table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"posthead\">\n";

if ($user_sess = bh_session_check()) {

    $forums_array = get_forum_list();

    echo "        <tr class=\"subhead\">\n";
    echo "          <td colspan=\"3\">Available Forums:</td>\n";
    echo "          <td>Last Visited</td>\n";
    echo "        </tr>\n";

    foreach ($forums_array as $forum) {

        echo "        <tr>\n";
        echo "          <td width=\"25%\">\n";
        echo "            <a href=\"#\">[?]</a>&nbsp;";

        if (isset($HTTP_GET_VARS['final_uri'])) {
            echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=", rawurlencode($HTTP_GET_VARS['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
        }else {
            echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
        }

        echo "          </td>\n";
        echo "          <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";
        echo "          <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=.%2Fdiscussion.php\">{$forum['MESSAGES']} Messages</a></td>\n";
        echo "          <td width=\"20%\">{$forum['LAST_VISIT']}</td>\n";
        echo "        </tr>\n";
    }

}else {

    $forums_array = get_forum_list();

    echo "        <tr class=\"subhead\">\n";
    echo "          <td colspan=\"3\">Available Forums:</td>\n";
    echo "          <td>&nbsp;</td>\n";
    echo "        </tr>\n";

    foreach ($forums_array as $forum) {
    
        echo "        <tr>\n";
        echo "          <td width=\"25%\">\n";
        echo "            <a href=\"#\">[?]</a>&nbsp;";

        if (isset($HTTP_GET_VARS['final_uri'])) {
            echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}&final_uri=", rawurlencode($HTTP_GET_VARS['final_uri']), "\">{$forum['FORUM_NAME']}</a>\n";
        }else {
            echo "            <a href=\"index.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a>\n";
        }

        echo "          </td>\n";
        echo "          <td width=\"30%\">{$forum['DESCRIPTION']}</td>\n";
        echo "          <td width=\"20%\"><a href=\"index.php?webtag={$forum['WEBTAG']}&amp;final_uri=.%2Fdiscussion.php\">{$forum['MESSAGES']} Messages</a></td>\n";
        echo "          <td width=\"20%\">{$forum['LAST_VISIT']}</td>\n";
        echo "        </tr>\n";
    }
}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>