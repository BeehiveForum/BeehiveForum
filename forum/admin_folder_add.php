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

/* $Id: admin_folder_add.php,v 1.29 2006-06-30 18:07:32 decoyduck Exp $ */

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

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {
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

    if (isset($_POST['t_name']) && strlen(trim(_stripslashes($_POST['t_name']))) > 0) {
        $t_name = trim(_stripslashes($_POST['t_name']));
    }else {
        $error_html = "<h2>{$lang['mustenterfoldername']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_description']) && strlen(trim(_stripslashes($_POST['t_description']))) > 0) {
        $t_description = trim(_stripslashes($_POST['t_description']));
    }else {
        $t_description = "";
    }

    if (isset($_POST['t_allowed_types']) && is_numeric($_POST['t_allowed_types'])) {
        $t_allowed_types = $_POST['t_allowed_types'];
    }else {
        $t_allowed_types = FOLDER_ALLOW_ALL_THREAD;
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

    if ($valid) {

        $new_fid = folder_create($t_name, $t_description, $t_allowed_types, $t_permissions);
        admin_add_log_entry(CREATE_FOLDER, $t_name);

        $add_success = rawurlencode($t_name);
        header_redirect("./admin_folders.php?webtag=$webtag&add+success=$add_success");
    }
}

// Make the arrays for the allow post types dropdown

$allow_labels = array($lang['normalthreadsonly'], $lang['pollthreadsonly'], $lang['both']);
$allow_values = array(FOLDER_ALLOW_NORMAL_THREAD, FOLDER_ALLOW_POLL_THREAD, FOLDER_ALLOW_ALL_THREAD);

echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['managefolders']} : {$lang['addnewfolder']}</h1>\n";

if (isset($error_html) && strlen($error_html) > 0) {
    echo $error_html;
}else {
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "  <form name=\"thread_options\" action=\"admin_folder_add.php\" method=\"post\" target=\"_self\">\n";
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
echo "                  <td>".form_input_text("t_name", (isset($t_name) ? $t_name : ""), 30, 32)."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\" class=\"posthead\">{$lang['description']}:</td>\n";
echo "                  <td>".form_input_text("t_description", (isset($t_description) ? $t_description : ""), 30, 255)."</td>\n";
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
echo "                  <td class=\"subhead\">{$lang['permissions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>\n";
echo "                    <table class=\"posthead\" width=\"80%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_post_read", USER_PERM_POST_READ, $lang['readposts'], false), "</td>\n";
echo "                        <td>", form_checkbox("t_post_create", USER_PERM_POST_CREATE, $lang['replytothreads'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_thread_create", USER_PERM_THREAD_CREATE, $lang['createnewthreads'], false), "</td>\n";
echo "                        <td>", form_checkbox("t_post_edit", USER_PERM_POST_EDIT, $lang['editposts'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_post_delete", USER_PERM_POST_DELETE, $lang['deleteposts'], false), "</td>\n";
echo "                        <td>", form_checkbox("t_post_attach", USER_PERM_POST_ATTACHMENTS, $lang['uploadattachments'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_post_html", USER_PERM_HTML_POSTING, $lang['postinhtml'], false), "</td>\n";
echo "                        <td>", form_checkbox("t_post_sig", USER_PERM_SIGNATURE, $lang['postasignature'], false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("t_guest_access", USER_PERM_GUEST_ACCESS, $lang['allowguestaccess'], false), "</td>\n";
echo "                        <td>", form_checkbox("t_post_approval", USER_PERM_POST_APPROVAL, $lang['requirepostapproval'], false), "</td>\n";
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