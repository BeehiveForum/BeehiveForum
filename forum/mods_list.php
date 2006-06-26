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

/* $Id: mods_list.php,v 1.9 2006-06-26 11:04:45 decoyduck Exp $ */

/**
* Displays list of moderators for a folder
*/

/**
*/
// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable UTF-8 encoding via mb_string functions if supported
include_once(BH_INCLUDE_PATH. "utf8.inc.php");

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

include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "mods_list.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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

}else {

    html_draw_top();

    echo "<h2>{$lang['cantdisplaymods']}</h2>\n";
    echo "{$lang['mustprovidefolderid']}\n";

    html_draw_bottom();
    exit;
}

$folder_title = folder_get_title($fid);

html_draw_top("title={$lang['moderatorlist']} {$folder_title}", "openprofile.js");

echo "<div align=\"center\">\n";

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"1\">{$lang['modsforfolder']} '{$folder_title}'</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table width=\"90%\" class=\"posthead\">\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <h2>{$lang['forumleaders']}</h2>\n";
echo "                          <ul>\n";

if ($forum_mods_array = mods_list_get_mods(0)) {

    foreach ($forum_mods_array as $forum_mod) {

        echo "                            <li><a href=\"javascript:void(0);\" onclick=\"openProfile({$forum_mod['UID']}, '$webtag')\" target=\"_self\">";
        echo format_user_name($forum_mod['LOGON'], $forum_mod['NICKNAME']), "</a></li>\n";
    }

}else {

    echo "                            <li>{$lang['nomodsfound']}</li>\n";
}

echo "                          </ul>\n";
echo "                          <h2>{$lang['foldermods']}</h2>";
echo "                          <ul>\n";

if ($folder_mods_array = mods_list_get_mods($fid)) {

    foreach ($folder_mods_array as $folder_mod) {

        echo "                            <li><a href=\"javascript:void(0);\" onclick=\"openProfile({$folder_mod['UID']}, '$webtag')\" target=\"_self\">";
        echo format_user_name($folder_mod['LOGON'], $folder_mod['NICKNAME']), "</a></li>\n";
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
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>