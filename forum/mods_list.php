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

/* $Id: mods_list.php,v 1.21 2007-03-24 17:32:24 decoyduck Exp $ */

/**
* Displays list of moderators for a folder
*/

/**
*/
// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "mods_list.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

$valid = true;
$error_html = "";

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

}elseif (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

    $fid = $_POST['fid'];

}else {

    html_draw_top();
    html_error_msg($lang['cantdisplaymods']);
    html_draw_bottom();
    exit;
}

$folder_title = folder_get_title($fid);

html_draw_top("title={$lang['moderatorlist']} {$folder_title}", "openprofile.js");

if (isset($_POST['close'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">{$lang['modsforfolder']} '{$folder_title}'</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table width=\"90%\" class=\"posthead\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>{$lang['forumleaders']}</h2>\n";
echo "                          <ul>\n";

if ($forum_mods_array = mods_list_get_mods(0)) {

    foreach ($forum_mods_array as $forum_mod) {

        echo "                            <li><a href=\"user_profile.php?webtag=$webtag&amp;uid={$forum_mod['UID']}\" target=\"_blank\" onclick=\"return openProfile({$forum_mod['UID']}, '$webtag')\">";
        echo add_wordfilter_tags(format_user_name($forum_mod['LOGON'], $forum_mod['NICKNAME'])), "</a></li>\n";
    }

}else {

    echo "                            <li>{$lang['nomodsfound']}</li>\n";
}

echo "                          </ul>\n";
echo "                          <h2>{$lang['foldermods']}</h2>";
echo "                          <ul>\n";

if ($folder_mods_array = mods_list_get_mods($fid)) {

    foreach ($folder_mods_array as $folder_mod) {

        echo "                            <li><a href=\"user_profile.php?webtag=$webtag&amp;uid={$folder_mod['UID']}\" target=\"_blank\" onclick=\"return openProfile({$folder_mod['UID']}, '$webtag')\">";
        echo add_wordfilter_tags(format_user_name($folder_mod['LOGON'], $folder_mod['NICKNAME'])), "</a></li>\n";
    }

}else {

    echo "                            <li>{$lang['nomodsfound']}</li>\n";
}

echo "                          </ul>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <form method=\"post\" action=\"mods_list.php\" target=\"_self\">\n";
echo "    ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "    ", form_input_hidden('fid', _htmlentities($fid)), "\n";
echo "    ". form_submit('close', $lang['close']). "\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>