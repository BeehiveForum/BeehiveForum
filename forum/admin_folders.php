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
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
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

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? intval($_POST['page']) : 1;
} else {
    $page = 1;
}

// Array to hold error messages
$error_msg_array = array();

// Delete folders.
if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach ($_POST['t_delete'] as $fid => $delete_folder) {

            if ($valid && $delete_folder == "Y" && $folder_data = folder_get($fid)) {

                if ($folder_data['THREAD_COUNT'] < 1) {

                    if (folder_delete($fid)) {

                        admin_add_log_entry(DELETE_FOLDER, array($folder_data['TITLE']));

                    } else {

                        $error_msg_array[] = gettext("Failed to delete folder.");
                        $valid = false;
                    }

                } else {

                    $error_msg_array[] = gettext("Cannot delete folders that still contain threads.");
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_folders.php?webtag=$webtag&page=$page&deleted=true");
            exit;
        }
    }

}

if (isset($_POST['addnew'])) {

    header_redirect("admin_folder_add.php?webtag=$webtag&page=$page");
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($fid) = array_keys($_POST['move_up']);

    if (folder_move_up($fid)) {

        header_redirect("admin_folders.php?webtag=$webtag&page=$page");
        exit;
    }
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($fid) = array_keys($_POST['move_down']);

    if (folder_move_down($fid)) {

        header_redirect("admin_folders.php?webtag=$webtag&page=$page");
        exit;
    }
}

if (isset($_POST['move_up_disabled']) || isset($_POST['move_down_disabled'])) {

    header_redirect("admin_folders.php?webtag=$webtag&page=$page");
    exit;
}

html_draw_top(
    array(
        'title' => gettext('Admin - Manage Folders'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

$folder_array = folder_get_all_by_page($page);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Folders"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

} else if (isset($_GET['added'])) {

    html_display_success_msg(gettext("Successfully added new folder"), '86%', 'center');

} else if (isset($_GET['edited'])) {

    html_display_success_msg(gettext("Successfully edited folder"), '86%', 'center');

} else if (isset($_GET['deleted'])) {

    html_display_success_msg(gettext("Successfully removed selected folders"), '86%', 'center');

} else if (sizeof($folder_array['folder_array']) < 1) {

    html_display_warning_msg(gettext("No existing folders found. To add a folder click the 'Add New' button below."), '86%', 'center');

} else {

    html_display_warning_msg(gettext("Folder order only applies when user has enabled 'Sort Thread List by folders' in Forum Options."), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_folders\" action=\"admin_folders.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Folder name"), "</td>\n";
echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\" align=\"center\" style=\"white-space: nowrap\">", gettext("Thread Count"), "</td>\n";
echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">", gettext("Permissions"), "</td>\n";
echo "                </tr>\n";

if (sizeof($folder_array['folder_array']) > 0) {

    foreach ($folder_array['folder_array'] as $key => $folder) {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$folder['FID']}]", "Y"), "</td>\n";
        echo "                  <td align=\"left\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;page=$page&amp;fid={$folder['FID']}\" title=\"", gettext("Click To Edit Folder"), "\">", word_filter_add_ob_tags($folder['TITLE'], true), "</a></td>\n";
        echo "                  <td align=\"right\" width=\"40\" style=\"white-space: nowrap\">", form_submit_image('move_up', "move_up[{$folder['FID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down', "move_down[{$folder['FID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";

        if (isset($folder['THREAD_COUNT']) && $folder['THREAD_COUNT'] > 0) {
            echo "                  <td align=\"center\" width=\"15%\">{$folder['THREAD_COUNT']}</td>\n";
        } else {
            echo "                  <td align=\"center\" width=\"15%\">0</td>\n";
        }

        if (isset($folder['FOLDER_PERMS']) && $folder['FOLDER_PERMS'] > 0) {
            echo "                  <td align=\"left\" width=\"25%\" style=\"white-space: nowrap\">", perm_display_list($folder['FOLDER_PERMS']), "</td>\n";
        } else {
            echo "                  <td align=\"left\" width=\"25%\" style=\"white-space: nowrap\">", gettext("none"), "</td>\n";
        }

        echo "                </tr>\n";
    }
}

echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"8\">&nbsp;</td>\n";
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
echo "      <td class=\"postbody\" align=\"center\">";

html_page_links("admin_folders.php?webtag=$webtag", $page, $folder_array['folder_count'], 10);

echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("addnew", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" class=\"posthead\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td colspan=\"4\" class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">Permissions Key</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table width=\"95%\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" valign=\"top\" width=\"50%\">\n";
echo "                        <table width=\"100%\">\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>PR</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Post Reading allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>TC</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Thread Creation allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>PD</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Post Deletion allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>HP</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("HTML Posting allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>GA</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Guest Access allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>TM</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Move threads to folder"), "</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                      <td align=\"left\" valign=\"top\" width=\"50%\">\n";
echo "                        <table width=\"100%\">\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>PC</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Post Creation allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>PE</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Post Editing allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>UA</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Uploading Attachments allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>US</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("User Signature allowed"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>PA</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Post Approval required"), "</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\" colspan=\"8\">&nbsp;</td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();