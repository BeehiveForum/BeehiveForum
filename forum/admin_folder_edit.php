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

/* $Id: admin_folder_edit.php,v 1.37 2005-12-21 17:32:49 decoyduck Exp $ */

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

html_draw_top();

if (!perm_has_admin_access()) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['back'])) {
    header_redirect("./admin_folders.php?webtag=$webtag");
}

if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
    $fid = $_POST['fid'];
}elseif (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $fid = $_GET['fid'];
}else {
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nofolderidspecified']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (!folder_is_valid($fid)) {
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['invalidfolderid']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['name']) && strlen(trim(_stripslashes($_POST['name']))) > 0) {
        $folder_data['TITLE'] = trim(_stripslashes($_POST['name']));
    }else {
        $status_html = "<h2>{$lang['mustenterfoldername']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['old_name']) && strlen(trim(_stripslashes($_POST['old_name']))) > 0) {
        $folder_data['OLD_TITLE'] = trim(_stripslashes($_POST['old_name']));
    }else {
        $folder_data['OLD_TITLE'] = "";
    }

    if (isset($_POST['description']) && strlen(trim(_stripslashes($_POST['description']))) > 0) {
        $folder_data['DESCRIPTION'] = trim(_stripslashes($_POST['description']));
    }else {
        $folder_data['DESCRIPTION'] = "";
    }

    if (isset($_POST['old_description']) && strlen(trim(_stripslashes($_POST['old_description']))) > 0) {
        $folder_data['OLD_DESCRIPTION'] = trim(_stripslashes($_POST['old_description']));
    }else {
        $folder_data['OLD_DESCRIPTION'] = "";
    }

    if (isset($_POST['allowed_types']) && is_numeric($_POST['allowed_types'])) {
        $folder_data['ALLOWED_TYPES'] = $_POST['allowed_types'];
    }

    if (isset($_POST['old_allowed_types']) && is_numeric($_POST['old_allowed_types'])) {
        $folder_data['OLD_ALLOWED_TYPES'] = $_POST['allowed_types'];
    }

    if (isset($_POST['position']) && is_numeric($_POST['position'])) {
        $folder_data['POSITION'] = $_POST['position'];
    }

    if (isset($_POST['old_perms']) && is_numeric($_POST['old_perms'])) {
        $folder_data['OLD_PERMS'] = (double) $_POST['old_perms'];
    }

    $t_post_read     = (double) (isset($_POST['t_post_read']))     ? $_POST['t_post_read']     : 0;
    $t_post_create   = (double) (isset($_POST['t_post_create']))   ? $_POST['t_post_create']   : 0;
    $t_thread_create = (double) (isset($_POST['t_thread_create'])) ? $_POST['t_thread_create'] : 0;
    $t_post_edit     = (double) (isset($_POST['t_post_edit']))     ? $_POST['t_post_edit']     : 0;
    $t_post_delete   = (double) (isset($_POST['t_post_delete']))   ? $_POST['t_post_delete']   : 0;
    $t_post_attach   = (double) (isset($_POST['t_post_attach']))   ? $_POST['t_post_attach']   : 0;
    $t_post_html     = (double) (isset($_POST['t_post_html']))     ? $_POST['t_post_html']     : 0;
    $t_post_sig      = (double) (isset($_POST['t_post_sig']))      ? $_POST['t_post_sig']      : 0;
    $t_guest_access  = (double) (isset($_POST['t_guest_access']))  ? $_POST['t_guest_access']  : 0;
    $t_post_approval = (double) (isset($_POST['t_post_approval'])) ? $_POST['t_post_approval'] : 0;

    // We need a double / float here because we're storing a high bit value

    $t_permissions = (double) $t_post_read | $t_post_create | $t_thread_create;
    $t_permissions = (double) $t_permissions | $t_post_edit | $t_post_delete | $t_post_attach;
    $t_permissions = (double) $t_permissions | $t_post_html | $t_post_sig | $t_guest_access | $t_post_approval;

    $folder_data['PERM'] = (double) $t_permissions;

    if ($valid) {

        if (folder_update($fid, $folder_data)) {

            $status_html = "<h2>{$lang['folderupdatedsuccessfully']}</h2>\n";
        }

        admin_add_log_entry(EDIT_THREAD_OPTIONS, $folder_data);

        if (isset($_POST['move']) && is_numeric($_POST['move'])
            && isset($_POST['move_confirm']) && $_POST['move_confirm'] == "Y") {

            if ($fid != $_POST['move']) {

                if (folder_move_threads($fid, $_POST['move'])) {

                    $status_html = "<h2>{$lang['threadsmovedsuccessfully']}</h2>\n";
                }

                $new_folder_title = folder_get_title($_POST['move']);

                admin_add_log_entry(MOVED_THREADS, array($folder_data['TITLE'], $new_folder_title));
            }
        }
    }
}

$folder_data = folder_get($fid);

if (isset($_POST['delete']) && $folder_data['THREAD_COUNT'] == 0) {

    $folder_name = folder_get_title($fid);

    folder_delete($fid);

    admin_add_log_entry(DELETE_FOLDER, $folder_name);

    $del_success = rawurlencode($folder_data['TITLE']);
    header_redirect("./admin_folders.php?webtag=$webtag&del_success=$del_success");
}

// Make the arrays for the allow post types dropdown

$allow_labels = array($lang['normalthreadsonly'], $lang['pollthreadsonly'], $lang['both']);
$allow_values = array(FOLDER_ALLOW_NORMAL_THREAD, FOLDER_ALLOW_POLL_THREAD, FOLDER_ALLOW_ALL_THREAD);

echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['managefolders']} : {$folder_data['TITLE']}</h1>\n";

if (isset($status_html) && strlen($status_html) > 0) {
    echo $status_html;
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form name=\"thread_options\" action=\"admin_folder_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('fid', $fid), "\n";
echo "  ", form_input_hidden('position', $folder_data['POSITION']), "\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['nameanddesc']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['name']}:</td>\n";
echo "                  <td>", form_input_text("name", $folder_data['TITLE'], 30, 32), form_input_hidden("old_name", $folder_data['TITLE']), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['description']}:</td>\n";
echo "                  <td>", form_input_text("description", $folder_data['DESCRIPTION'], 30, 255), form_input_hidden("old_description", $folder_data['DESCRIPTION']), "</td>\n";
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

if ($folder_dropdown = folder_draw_dropdown_all($folder_data['FID'], "move", "", "", "post_folder_dropdown")) {

    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['movethreads']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\" class=\"posthead\">{$lang['movethreadstofolder']}:</td>\n";
    echo "                  <td>", $folder_dropdown, "&nbsp;", form_checkbox("move_confirm", "Y", $lang['confirm']), "</td>\n";
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
}

echo "        ", form_input_hidden("old_perms", $folder_data['PERM']), "\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['permissions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"90%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_post_read", USER_PERM_POST_READ, $lang['readposts'], $folder_data['PERM'] & USER_PERM_POST_READ), "</td>\n";
echo "                        <td>", form_checkbox("t_post_create", USER_PERM_POST_CREATE, $lang['replytothreads'], $folder_data['PERM'] & USER_PERM_POST_CREATE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_thread_create", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], $folder_data['PERM'] & USER_PERM_THREAD_CREATE), "</td>\n";
echo "                        <td>", form_checkbox("t_post_edit", USER_PERM_POST_EDIT, $lang['editposts'], $folder_data['PERM'] & USER_PERM_POST_EDIT), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_post_delete", USER_PERM_POST_DELETE, $lang['deleteposts'], $folder_data['PERM'] & USER_PERM_POST_DELETE), "</td>\n";
echo "                        <td>", form_checkbox("t_post_attach", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], $folder_data['PERM'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_post_html", USER_PERM_HTML_POSTING, $lang['postinhtml'], $folder_data['PERM'] & USER_PERM_HTML_POSTING), "</td>\n";
echo "                        <td>", form_checkbox("t_post_sig", USER_PERM_SIGNATURE, $lang['postasignature'], $folder_data['PERM'] & USER_PERM_SIGNATURE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_guest_access", USER_PERM_GUEST_ACCESS, $lang['allowguestaccess'], $folder_data['PERM'] & USER_PERM_GUEST_ACCESS), "</td>\n";
echo "                        <td>", form_checkbox("t_post_approval", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], $folder_data['PERM'] & USER_PERM_POST_APPROVAL), "</td>\n";
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
echo "                  <td>", form_dropdown_array("allowed_types", $allow_values, $allow_labels, isset($folder_data['ALLOWED_TYPES']) ? $folder_data['ALLOWED_TYPES'] : FOLDER_ALLOW_NORMAL_THREAD | FOLDER_ALLOW_POLL_THREAD), form_input_hidden("old_allowed_types", isset($folder_data['ALLOWED_TYPES']) ? $folder_data['ALLOWED_TYPES'] : 0), "</td>\n";
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

if ($folder_data['THREAD_COUNT'] > 0) {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), " &nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>