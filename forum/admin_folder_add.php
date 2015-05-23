<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

$t_name = null;
$t_description = null;
$t_prefix = null;
$t_allowed_types = null;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
} else {
    $page = 1;
}

if (isset($_POST['cancel'])) {

    header_redirect("admin_folders.php?webtag=$webtag&page=$page");
    exit;
}

if (isset($_POST['add'])) {

    $valid = true;

    if (isset($_POST['t_name']) && strlen(trim($_POST['t_name'])) > 0) {
        $t_name = trim($_POST['t_name']);
    } else {
        $error_msg_array[] = gettext("You must enter a folder name");
        $valid = false;
    }

    if (isset($_POST['t_description']) && strlen(trim($_POST['t_description'])) > 0) {
        $t_description = trim($_POST['t_description']);
    } else {
        $t_description = "";
    }

    if (isset($_POST['t_prefix']) && strlen(trim($_POST['t_prefix'])) > 0) {
        $t_prefix = trim($_POST['t_prefix']);
    } else {
        $t_prefix = "";
    }

    if (isset($_POST['t_allowed_types']) && is_numeric($_POST['t_allowed_types'])) {
        $t_allowed_types = $_POST['t_allowed_types'];
    } else {
        $t_allowed_types = FOLDER_ALLOW_ALL_THREAD;
    }

    $t_post_read = (double)(isset($_POST['t_post_read'])) ? $_POST['t_post_read'] : 0;
    $t_post_create = (double)(isset($_POST['t_post_create'])) ? $_POST['t_post_create'] : 0;
    $t_thread_create = (double)(isset($_POST['t_thread_create'])) ? $_POST['t_thread_create'] : 0;
    $t_post_edit = (double)(isset($_POST['t_post_edit'])) ? $_POST['t_post_edit'] : 0;
    $t_post_delete = (double)(isset($_POST['t_post_delete'])) ? $_POST['t_post_delete'] : 0;
    $t_post_attach = (double)(isset($_POST['t_post_attach'])) ? $_POST['t_post_attach'] : 0;
    $t_post_html = (double)(isset($_POST['t_post_html'])) ? $_POST['t_post_html'] : 0;
    $t_post_sig = (double)(isset($_POST['t_post_sig'])) ? $_POST['t_post_sig'] : 0;
    $t_guest_access = (double)(isset($_POST['t_guest_access'])) ? $_POST['t_guest_access'] : 0;
    $t_post_approval = (double)(isset($_POST['t_post_approval'])) ? $_POST['t_post_approval'] : 0;
    $t_thread_move = (double)(isset($_POST['t_thread_move'])) ? $_POST['t_thread_move'] : 0;

    // We need a double / float here because we're storing a high bit value
    $t_permissions = (double)$t_post_read | $t_post_create | $t_thread_create;
    $t_permissions = (double)$t_permissions | $t_post_edit | $t_post_delete | $t_post_attach;
    $t_permissions = (double)$t_permissions | $t_post_html | $t_post_sig | $t_guest_access;
    $t_permissions = (double)$t_permissions | $t_post_approval | $t_thread_move;

    if ($valid) {

        if (($new_fid = folder_create($t_name, $t_description, $t_prefix, $t_allowed_types, $t_permissions)) !== false) {

            admin_add_log_entry(CREATE_FOLDER, array($t_name));
            header_redirect("admin_folders.php?webtag=$webtag&added=true&page=$page");
            exit;

        } else {

            $error_msg_array = gettext("Failed to create new folder");
            $valid = false;
        }
    }
}

// Make the arrays for the allow post types dropdown
$allowed_post_types = array(
    FOLDER_ALLOW_NORMAL_THREAD => gettext("Normal threads only"),
    FOLDER_ALLOW_POLL_THREAD => gettext("Poll threads only"),
    FOLDER_ALLOW_ALL_THREAD => gettext("Both thread types")
);

html_draw_top(
    array(
        'title' => gettext('Admin - Manage Folders - Add a new folder'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Folders"), html_style_image('separator'), gettext("Add a new folder"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '800', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_folder_add.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
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
echo "                        <td align=\"left\">" . form_input_text("t_name", (isset($t_name) ? htmlentities_array($t_name) : ""), 30, 32) . "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Description"), ":</td>\n";
echo "                        <td align=\"left\">" . form_input_text("t_description", (isset($t_description) ? htmlentities_array($t_description) : ""), 30, 255) . "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Thread Title Prefix"), ":</td>\n";
echo "                        <td align=\"left\">" . form_input_text("t_prefix", (isset($t_prefix) ? htmlentities_array($t_prefix) : ""), 30, 16) . "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Permissions"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_read", USER_PERM_POST_READ, gettext("Read Posts")), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_create", USER_PERM_POST_CREATE, gettext("Reply to threads")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_thread_create", USER_PERM_THREAD_CREATE, gettext("Create new threads")), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_edit", USER_PERM_POST_EDIT, gettext("Edit posts")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_delete", USER_PERM_POST_DELETE, gettext("Delete posts")), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_attach", USER_PERM_POST_ATTACHMENTS, gettext("Upload attachments")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_html", USER_PERM_HTML_POSTING, gettext("Post in HTML")), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_sig", USER_PERM_SIGNATURE, gettext("Post a signature")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_guest_access", USER_PERM_GUEST_ACCESS, gettext("Allow Guest Access")), "</td>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_approval", USER_PERM_POST_APPROVAL, gettext("Require Post Approval")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_thread_move", USER_PERM_THREAD_MOVE, gettext("Move threads to folder")), "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Allow"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Allow folder to contain"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("t_allowed_types", $allowed_post_types, (isset($t_allowed_types) ? $t_allowed_types : FOLDER_ALLOW_ALL_THREAD)), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
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
echo "      <td align=\"center\">", form_submit("add", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();