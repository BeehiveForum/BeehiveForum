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

/* $Id: admin_folders.php,v 1.82 2004-05-26 13:19:53 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top();

if (!perm_has_admin_access()) {
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

            folder_update($fid, $folder_data);
            admin_addlog(0, $fid, 0, 0, 0, 0, 7);
        }
    }
}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['managefolders']}</h1>\n";

if (isset($_GET['add_success'])) {
    echo "<h2>{$lang['successfullyaddedfolder']}: ", _stripslashes($_GET['add_success']), "</h2>\n";
}

if (isset($_GET['del_success'])) {
    echo "<h2>{$lang['successfullydeletedfolder']}: ", _stripslashes($_GET['del_success']), "</h2>\n";
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_folders\" action=\"admin_folders.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
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
        echo "                  <td align=\"left\">{$folder['THREAD_COUNT']}</td>\n";
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
echo "  </table>\n";
echo "</form>\n";;
echo "</div>\n";

html_draw_bottom();

?>