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

/* $Id: visitor_log.php,v 1.35 2004-04-08 16:47:17 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

// We got this far we should now read the forum settings

$forum_settings = get_forum_settings();

include_once("./include/db.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

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

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

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
        echo "          <td class=\"postbody\" align=\"left\"><a href=\"#\" target=\"_self\" onclick=\"openProfile({$user_search['UID']}, '$webtag')\">", format_user_name($user_search['LOGON'], $user_search['NICKNAME']), "</a></td>\n";
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
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag&page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
  }elseif ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag&page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag&page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
  }
}else {
  if ($start >= 20) {
    echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
    echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"visitor_log.php?webtag=$webtag&page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
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
echo "            <form method=\"get\" action=\"visitor_log.php\" target=\"_self\">\n";
echo "              ", form_input_hidden("webtag", $webtag), "\n";
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