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

/* $Id: admin_folders.php,v 1.102 2006-06-26 11:04:36 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['t_more'])) {

    list($fid) = array_keys($_POST['t_more']);
    header_redirect("./admin_folder_edit.php?webtag=$webtag&fid=$fid");
}

if (isset($_POST['addnew'])) {
    header_redirect("./admin_folder_add.php?webtag=$webtag");
}

// Do updates
if (isset($_POST['submit'])) {

    if (isset($_POST['t_fid'])) {

        foreach($_POST['t_fid'] as $fid => $value) {

            $folder_data = folder_get($fid);

            if (isset($_POST['t_position'][$fid]) && is_numeric($_POST['t_position'][$fid])) {
                $folder_data['POSITION'] = $_POST['t_position'][$fid];
            }

            if (isset($_POST['t_old_position'][$fid]) && is_numeric($_POST['t_old_position'][$fid])) {
                $folder_data['OLD_POSITION'] = $_POST['t_old_position'][$fid];
            }

            folder_update($fid, $folder_data);
            admin_add_log_entry(EDIT_THREAD_OPTIONS, $folder_data);
        }
    }
}

html_draw_top();

// Draw the form
echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['managefolders']}</h1>\n";

if (isset($_GET['add_success']) && strlen(trim(_stripslashes($_GET['add_success']))) > 0) {
    echo "<h2>{$lang['successfullyaddedfolder']}: ", trim(_stripslashes($_GET['add_success'])), "</h2>\n";
}

if (isset($_GET['del_success']) && strlen(trim(_stripslashes($_GET['del_success']))) > 0) {
    echo "<h2>{$lang['successfullydeletedfolder']}: ", trim(_stripslashes($_GET['del_success'])), "</h2>\n";
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"admin_folders.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['position']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['foldername']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['threadcount']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['permissions']}</td>\n";
echo "                </tr>\n";

if ($folder_array = folder_get_all()) {

    $folder_index = 0;

    foreach ($folder_array as $key => $folder) {

        $folder_index++;

        echo "                <tr>\n";

        if (sizeof($folder_array) > 1) {
            echo "                  <td align=\"left\">", form_dropdown_array("t_position[{$folder['FID']}]", range(1, sizeof($folder_array) + 1), range(1, sizeof($folder_array) + 1), $folder_index), form_input_hidden("t_old_position[{$folder['FID']}]", $folder_index), form_input_hidden("t_fid[{$folder['FID']}]", $folder['FID']), "</td>\n";
        }else {
            echo "                  <td align=\"left\">{$folder_index}</td>\n";
        }

        echo "                  <td align=\"left\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid={$folder['FID']}\" title=\"Click To Edit Folder Details\">{$folder['TITLE']}</a></td>\n";

        if ($thread_count = folder_get_thread_count($folder['FID'])) {
            echo "                  <td align=\"left\">{$thread_count}</td>\n";
        }else {
            echo "                  <td align=\"left\">{$lang['unknown']}</td>\n";
        }

        if ($folder['FOLDER_PERM_COUNT'] > 0) {
            echo "                  <td align=\"left\">", perm_display_list($folder['FOLDER_PERMS']), "</td>\n";
        }else {
            echo "                  <td align=\"left\">{$lang['none']}</td>\n";
        }

        echo "                </tr>\n";
    }
}

echo "                <tr>\n";
echo "                  <td colspan=\"8\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("addnew", $lang['addnewfolder']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"4\" class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;Permissions Key</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td><b>R</b></td>\n";
echo "                  <td>{$lang['postreadingallowed']}</td>\n";
echo "                  <td><b>W</b></td>\n";
echo "                  <td>{$lang['postcreationallowed']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td><b>T</b></td>\n";
echo "                  <td>{$lang['threadcreationallowed']}</td>\n";
echo "                  <td><b>E</b></td>\n";
echo "                  <td>{$lang['posteditingallowed']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td><b>D</b></td>\n";
echo "                  <td>{$lang['postdeletionallowed']}</td>\n";
echo "                  <td><b>A</b></td>\n";
echo "                  <td>{$lang['attachmentsallowed']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td><b>H</b></td>\n";
echo "                  <td>{$lang['htmlpostingallowed']}</td>\n";
echo "                  <td><b>S</b></td>\n";
echo "                  <td>{$lang['signatureallowed']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td><b>G</b></td>\n";
echo "                  <td>{$lang['guestaccessallowed']}</td>\n";
echo "                  <td><b>V</b></td>\n";
echo "                  <td>{$lang['postapprovalrequired']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"8\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>