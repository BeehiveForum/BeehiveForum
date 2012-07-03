<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings
$forum_settings = forum_get_settings();

// Fetch Global Forum Settings
$forum_global_settings = forum_get_global_settings();

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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Initialise Locale
lang_init();

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

if (!(session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("You do not have permission to use this section."));
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {

    header_redirect("admin_folders.php?webtag=$webtag&page=$page");
    exit;
}

if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

    $fid = $_POST['fid'];

}elseif (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

}else {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("No Folder ID specified"), 'admin_folders.php', 'get', array('back' => gettext("Back")), array('page' => $page));
    html_draw_bottom();
    exit;
}

if (!folder_is_valid($fid)) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("Invalid Folder ID. Check that a folder with this ID exists!"), 'admin_folders.php', 'get', array('back' => gettext("Back")), array('page' => $page));
    html_draw_bottom();
    exit;
}

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['name']) && strlen(trim(stripslashes_array($_POST['name']))) > 0) {
        $folder_data['TITLE'] = trim(stripslashes_array($_POST['name']));
    }else {
        $error_msg_array[] = gettext("You must enter a folder name");
        $valid = false;
    }

    if (isset($_POST['old_name']) && strlen(trim(stripslashes_array($_POST['old_name']))) > 0) {
        $folder_data['OLD_TITLE'] = trim(stripslashes_array($_POST['old_name']));
    }else {
        $folder_data['OLD_TITLE'] = "";
    }

    if (isset($_POST['description']) && strlen(trim(stripslashes_array($_POST['description']))) > 0) {
        $folder_data['DESCRIPTION'] = trim(stripslashes_array($_POST['description']));
    }else {
        $folder_data['DESCRIPTION'] = "";
    }

    if (isset($_POST['old_description']) && strlen(trim(stripslashes_array($_POST['old_description']))) > 0) {
        $folder_data['OLD_DESCRIPTION'] = trim(stripslashes_array($_POST['old_description']));
    }else {
        $folder_data['OLD_DESCRIPTION'] = "";
    }

    if (isset($_POST['prefix']) && strlen(trim(stripslashes_array($_POST['prefix']))) > 0) {
        $folder_data['PREFIX'] = trim(stripslashes_array($_POST['prefix']));
    }else {
        $folder_data['PREFIX'] = "";
    }

    if (isset($_POST['old_prefix']) && strlen(trim(stripslashes_array($_POST['old_prefix']))) > 0) {
        $folder_data['OLD_PREFIX'] = trim(stripslashes_array($_POST['old_prefix']));
    }else {
        $folder_data['OLD_PREFIX'] = "";
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
    $t_thread_move   = (double) (isset($_POST['t_thread_move']))   ? $_POST['t_thread_move']   : 0;

    // We need a double / float here because we're storing a high bit value
    $t_permissions = (double) $t_post_read | $t_post_create | $t_thread_create;
    $t_permissions = (double) $t_permissions | $t_post_edit | $t_post_delete | $t_post_attach;
    $t_permissions = (double) $t_permissions | $t_post_html | $t_post_sig | $t_guest_access;
    $t_permissions = (double) $t_permissions | $t_post_approval | $t_thread_move;

    $folder_data['PERM'] = (double) $t_permissions;

    if ($valid) {

        if (folder_update($fid, $folder_data)) {

            admin_add_log_entry(EDIT_THREAD_OPTIONS, $folder_data);

            if (isset($_POST['move_confirm']) && $_POST['move_confirm'] == "Y") {

                if (isset($_POST['fid_move']) && is_numeric($_POST['fid_move'])) {

                    $fid_move = $_POST['fid_move'];

                    if (($fid != $fid_move) && ($new_folder_title = folder_get_title($fid_move))) {

                        if (folder_move_threads($fid, $fid_move)) {

                            admin_add_log_entry(MOVED_THREADS, array($folder_data['TITLE'], $new_folder_title));

                        }else {

                            $error_msg_array[] = gettext("Failed to move threads to specified folder");
                            $valid = false;
                        }
                    }
                }
            }

            if (isset($_POST['t_reset_user_perms']) && $_POST['t_reset_user_perms'] == "Y" && isset($_POST['t_reset_user_perms_con']) && $_POST['t_reset_user_perms_con'] == "Y") {

                if (!perm_folder_reset_user_permissions($fid)) {

                    $error_msg_array[] = gettext("Failed to reset user permissions");
                    $valid = false;
                }
            }

        }else {

            $error_msg_array[] = gettext("Failed to update folder");
            $valid = false;
        }

        if ($valid) {

            header_redirect("admin_folders.php?webtag=$webtag&edited=true&page=$page");
            exit;
        }
    }
}

if (!($folder_data = folder_get($fid))) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("Invalid Folder ID. Check that a folder with this ID exists!"), 'admin_folders.php', 'get', array('back' => gettext("Back")), array('page' => $page));
    html_draw_bottom();
    exit;
}

if (isset($_POST['delete'])) {

    if ($folder_data['THREAD_COUNT'] == 0) {

        if (folder_delete($fid)) {

            admin_add_log_entry(DELETE_FOLDER, array($folder_data['TITLE']));
            header_redirect("admin_folders.php?webtag=$webtag&deleted=true&page=$page");
            exit;

        }else {

            $error_msg_array[] = gettext("Failed to delete folder.");
            $valid = false;
        }

    }else {

        $error_msg_array[] = gettext("Cannot delete folders that still contain threads.");
        $valid = false;
    }
}

// Make the arrays for the allow post types dropdown
$allowed_post_types = array(FOLDER_ALLOW_NORMAL_THREAD => gettext("Normal threads only"),
                            FOLDER_ALLOW_POLL_THREAD   => gettext("Poll threads only"),
                            FOLDER_ALLOW_ALL_THREAD    => gettext("Both thread types"));

html_draw_top("", gettext("Admin"), " - ", gettext("Manage Folders"), " - ", gettext("Edit Folder"), " - {$folder_data['TITLE']}", 'class=window_title');

echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Manage Folders"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Edit Folder"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", word_filter_add_ob_tags($folder_data['TITLE'], true), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_folder_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('fid', htmlentities_array($fid)), "\n";
echo "  ", form_input_hidden('position', htmlentities_array($folder_data['POSITION'])), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Name and Description"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Name"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("name", htmlentities_array($folder_data['TITLE']), 30, 32), form_input_hidden("old_name", htmlentities_array($folder_data['TITLE'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Description"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("description", htmlentities_array($folder_data['DESCRIPTION']), 30, 255), form_input_hidden("old_description", htmlentities_array($folder_data['DESCRIPTION'])), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Thread Title Prefix"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("prefix", htmlentities_array($folder_data['PREFIX']), 30, 16), form_input_hidden("old_prefix", htmlentities_array($folder_data['PREFIX'])), "</td>\n";
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
echo "        <br />\n";

if (($folder_dropdown = folder_draw_dropdown_all($folder_data['FID'], 'fid_move', "", "", "post_folder_dropdown"))) {

    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Move Threads"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Move threads to folder"), ":</td>\n";
    echo "                        <td align=\"left\">", $folder_dropdown, "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_checkbox("move_confirm", "Y", gettext("Confirm")), "</td>\n";
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
    echo "        <br />\n";
}

echo "        ", form_input_hidden("old_perms", htmlentities_array($folder_data['PERM'])), "\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Permissions"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_read", USER_PERM_POST_READ, gettext("Read Posts"), $folder_data['PERM'] & USER_PERM_POST_READ), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_create", USER_PERM_POST_CREATE, gettext("Reply to threads"), $folder_data['PERM'] & USER_PERM_POST_CREATE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_thread_create", USER_PERM_THREAD_CREATE, gettext("Create new threads"), $folder_data['PERM'] & USER_PERM_THREAD_CREATE), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_edit", USER_PERM_POST_EDIT, gettext("Edit posts"), $folder_data['PERM'] & USER_PERM_POST_EDIT), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_delete", USER_PERM_POST_DELETE, gettext("Delete posts"), $folder_data['PERM'] & USER_PERM_POST_DELETE), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_attach", USER_PERM_POST_ATTACHMENTS, gettext("Upload attachments"), $folder_data['PERM'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_html", USER_PERM_HTML_POSTING, gettext("Post in HTML"), $folder_data['PERM'] & USER_PERM_HTML_POSTING), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_sig", USER_PERM_SIGNATURE, gettext("Post a signature"), $folder_data['PERM'] & USER_PERM_SIGNATURE), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_guest_access", USER_PERM_GUEST_ACCESS, gettext("Allow Guest Access"), $folder_data['PERM'] & USER_PERM_GUEST_ACCESS), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_approval", USER_PERM_POST_APPROVAL, gettext("Require Post Approval"), $folder_data['PERM'] & USER_PERM_POST_APPROVAL), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_thread_move", USER_PERM_THREAD_MOVE, gettext("Move threads to folder"), $folder_data['PERM'] & USER_PERM_THREAD_MOVE), "</td>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Reset user permissions"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"50%\">Reset User Perms:</td>\n";
echo "                        <td align=\"left\">", form_radio("t_reset_user_perms", "Y", gettext("Yes"), false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("t_reset_user_perms", "N", gettext("No"), true), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_reset_user_perms_con", "Y", gettext("Confirm"), false), "</td>\n";
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
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Allow"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Allow folder to contain"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("allowed_types", $allowed_post_types, isset($folder_data['ALLOWED_TYPES']) ? $folder_data['ALLOWED_TYPES'] : FOLDER_ALLOW_NORMAL_THREAD | FOLDER_ALLOW_POLL_THREAD), form_input_hidden("old_allowed_types", isset($folder_data['ALLOWED_TYPES']) ? htmlentities_array($folder_data['ALLOWED_TYPES']) : 0), "</td>\n";
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
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>
