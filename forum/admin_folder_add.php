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

/* $Id: admin_folder_add.php,v 1.2 2004-05-05 20:04:30 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

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

if (!(bh_session_get_value('STATUS')&USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {
    header_redirect("./admin_folders.php?webtag=$webtag");
}

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['t_name']) && strlen(trim($_POST['t_name'])) > 0) {
        $t_name = trim(_stripslashes($_POST['t_name']));
    }else {
        $error_html = "<h2>{$lang['mustenterfoldername']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_description']) && strlen(trim($_POST['t_description'])) > 0) {
        $t_description = trim(_stripslashes($_POST['t_description']));
    }else {
        $t_description = "";
    }

    if (isset($_POST['t_access_level']) && is_numeric($_POST['t_access_level'])) {
        $t_access_level = $_POST['t_access_level'];
    }else {
        $t_access_level = 0;
    }

    if (isset($_POST['t_allowed_types']) && is_numeric($_POST['t_allowed_types'])) {
        $t_allowed_types = $_POST['t_allowed_types'];
    }else {
        $t_allowed_types = FOLDER_ALLOW_ALL_THREAD;
    }

    if ($valid) {

        $new_fid = folder_create($t_name, $t_access_level, $t_description, $t_allowed_types);
        admin_addlog(0, $new_fid, 0, 0, 0, 0, 9);

        $add_success = rawurlencode($t_name);
        header_redirect("./admin_folders.php?webtag=$webtag&add+success=$add_success");
    }
}

// Make the arrays for the allow post types dropdown

$allow_labels = array($lang['normalthreadsonly'], $lang['pollthreadsonly'], $lang['both']);
$allow_values = array(FOLDER_ALLOW_NORMAL_THREAD, FOLDER_ALLOW_POLL_THREAD, FOLDER_ALLOW_ALL_THREAD);

echo "<h1>{$lang['admin']} : {$lang['managefolders']} : {$lang['addnewfolder']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form name=\"thread_options\" action=\"admin_folder_add.php\" method=\"post\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['name']} / {$lang['description']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['name']}:</td>\n";
echo "                  <td>".form_input_text("t_name", (isset($t_name) ? $t_name : ""), 30, 64)."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['description']}:</td>\n";
echo "                  <td>".form_input_text("t_description", (isset($t_description) ? $t_description : ""), 30, 64)."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['accesslevel']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['accesslevel']}:</td>\n";
echo "                  <td>", form_dropdown_array("t_access_level", array(-1, 0, 1, 2), array($lang['closed'], $lang['open'], $lang['restricted'], $lang['locked']), (isset($t_access_level) ? $t_access_level : 0)), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['allow']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['allowfoldertocontain']}:</td>\n";
echo "                  <td>", form_dropdown_array("t_allowed_types", $allow_values, $allow_labels, (isset($t_allowed_types) ? $t_allowed_types : FOLDER_ALLOW_ALL_THREAD)), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['add']), " &nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>