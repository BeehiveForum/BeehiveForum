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

// Array to hold error messages
$error_msg_array = array();

$t_name = null;

// Cancel button clicked.
if (isset($_POST['cancel'])) {

    header_redirect("admin_user_groups.php?webtag=$webtag");
    exit;
}

// Do updates
if (isset($_POST['add_group']) || isset($_POST['add_users'])) {

    $valid = true;

    if (isset($_POST['t_name']) && strlen(trim($_POST['t_name'])) > 0) {

        $t_name = trim($_POST['t_name']);

    } else {

        $error_msg_array[] = gettext("You must enter a group name");
        $valid = false;
    }

    if (isset($_POST['t_description']) && strlen(trim($_POST['t_description'])) > 0) {
        $t_description = trim($_POST['t_description']);
    } else {
        $t_description = "";
    }

    $t_admintools = (double)(isset($_POST['t_admintools'])) ? $_POST['t_admintools'] : 0;
    $t_banned = (double)(isset($_POST['t_banned'])) ? $_POST['t_banned'] : 0;
    $t_wormed = (double)(isset($_POST['t_wormed'])) ? $_POST['t_wormed'] : 0;
    $t_globalmod = (double)(isset($_POST['t_globalmod'])) ? $_POST['t_globalmod'] : 0;
    $t_linksmod = (double)(isset($_POST['t_linksmod'])) ? $_POST['t_linksmod'] : 0;

    $new_group_perms = (double)$t_banned | $t_wormed | $t_globalmod | $t_linksmod;

    if (session::check_perm(USER_PERM_FORUM_TOOLS, 0)) {

        $new_group_perms = (double)$new_group_perms | $t_admintools;
    }

    if ($valid) {

        if (($new_gid = perm_add_group($t_name, $t_description, $new_group_perms)) !== false) {

            if (isset($_POST['t_new_perms_array']) && is_array($_POST['t_new_perms_array'])) {

                $t_new_perms_array = $_POST['t_new_perms_array'];

                foreach ($t_new_perms_array as $fid) {

                    $t_post_read = (double)(isset($_POST['t_post_read'][$fid])) ? $_POST['t_post_read'][$fid] : 0;
                    $t_post_create = (double)(isset($_POST['t_post_create'][$fid])) ? $_POST['t_post_create'][$fid] : 0;
                    $t_thread_create = (double)(isset($_POST['t_thread_create'][$fid])) ? $_POST['t_thread_create'][$fid] : 0;
                    $t_post_edit = (double)(isset($_POST['t_post_edit'][$fid])) ? $_POST['t_post_edit'][$fid] : 0;
                    $t_post_delete = (double)(isset($_POST['t_post_delete'][$fid])) ? $_POST['t_post_delete'][$fid] : 0;
                    $t_post_attach = (double)(isset($_POST['t_post_attach'][$fid])) ? $_POST['t_post_attach'][$fid] : 0;
                    $t_moderator = (double)(isset($_POST['t_moderator'][$fid])) ? $_POST['t_moderator'][$fid] : 0;
                    $t_post_html = (double)(isset($_POST['t_post_html'][$fid])) ? $_POST['t_post_html'][$fid] : 0;
                    $t_post_sig = (double)(isset($_POST['t_post_sig'][$fid])) ? $_POST['t_post_sig'][$fid] : 0;
                    $t_post_approval = (double)(isset($_POST['t_post_approval'][$fid])) ? $_POST['t_post_approval'][$fid] : 0;

                    $new_group_perms = (double)$t_post_read | $t_post_create | $t_thread_create;
                    $new_group_perms = (double)$new_group_perms | $t_post_edit | $t_post_delete;
                    $new_group_perms = (double)$new_group_perms | $t_moderator | $t_post_attach;
                    $new_group_perms = (double)$new_group_perms | $t_post_html | $t_post_sig | $t_post_approval;

                    perm_update_group_folder_perms($new_gid, $fid, $new_group_perms);
                }
            }

            admin_add_log_entry(CREATE_USER_GROUP, array($t_name));

            if (isset($_POST['add_users'])) {

                header_redirect("admin_user_groups_edit_users.php?webtag=$webtag&gid=$new_gid&added=true");
                exit;

            } else {

                header_redirect("admin_user_groups.php?webtag=$webtag&added=true");
                exit;
            }
        }
    }
}

html_draw_top(
    array(
        'title' => gettext('Admin - Manage User Groups - Add User Group'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User Groups"), html_style_image('separator'), gettext("Add User Group"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '800', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"admin_user_form\" action=\"admin_user_groups_add.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
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
echo "                        <td align=\"left\">" . form_input_text("t_name", (isset($t_name) ? htmlentities_array($t_name) : ""), 30, 64) . "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Description"), ":</td>\n";
echo "                        <td align=\"left\">" . form_input_text("t_description", (isset($t_description) ? htmlentities_array($t_description) : ""), 30, 64) . "</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("Group Status"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (session::check_perm(USER_PERM_FORUM_TOOLS, 0)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_admintools", USER_PERM_ADMIN_TOOLS, gettext("Group can access admin tools")), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_globalmod", USER_PERM_FOLDER_MODERATE, gettext("Group can moderate all folders")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_linksmod", USER_PERM_LINKS_MODERATE, gettext("Group can moderate Links sections")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_banned", USER_PERM_BANNED, gettext("Group is banned")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_wormed", USER_PERM_WORMED, gettext("Group is wormed")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
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

if (($folder_array = folder_get_all()) !== false) {

    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">", gettext("Folder Access"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"box\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"posthead\">\n";
    echo "                          <table class=\"posthead\" width=\"100%\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\" width=\"100\">", gettext("Folders"), "</td>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Permissions"), "</td>\n";
    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" colspan=\"2\">\n";
    echo "                                <div class=\"admin_folder_perms\">\n";

    foreach ($folder_array as $folder) {

        if ($folder['FOLDER_PERM_COUNT'] > 0) {

            echo "                                  ", form_input_hidden("t_new_perms_array[]", htmlentities_array($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags($folder['TITLE'], true), "</a></td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, gettext("Read Posts"), $folder['FOLDER_PERMS'] & USER_PERM_POST_READ), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, gettext("Reply to threads"), $folder['FOLDER_PERMS'] & USER_PERM_POST_CREATE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, gettext("Create new threads"), $folder['FOLDER_PERMS'] & USER_PERM_THREAD_CREATE), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, gettext("Edit posts"), $folder['FOLDER_PERMS'] & USER_PERM_POST_EDIT), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, gettext("Delete posts"), $folder['FOLDER_PERMS'] & USER_PERM_POST_DELETE), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, gettext("Upload attachments"), $folder['FOLDER_PERMS'] & USER_PERM_POST_ATTACHMENTS), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, gettext("Post in HTML"), $folder['FOLDER_PERMS'] & USER_PERM_HTML_POSTING), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, gettext("Post a signature"), $folder['FOLDER_PERMS'] & USER_PERM_SIGNATURE), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, gettext("Moderate folder")), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, gettext("Require Post Approval")), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
            echo "                                    </tr>\n";
            echo "                                  </table>\n";

        } else {

            echo "                                  ", form_input_hidden("t_new_perms_array[]", htmlentities_array($folder['FID'])), "\n";
            echo "                                  <table class=\"posthead\" width=\"100%\">\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" rowspan=\"5\" width=\"100\" valign=\"top\"><a href=\"admin_folder_edit.php?webtag=$webtag&amp;fid={$folder['FID']}\" target=\"_self\">", word_filter_add_ob_tags($folder['TITLE'], true), "</a></td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_read[{$folder['FID']}]", USER_PERM_POST_READ, gettext("Read Posts"), true), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_create[{$folder['FID']}]", USER_PERM_POST_CREATE, gettext("Reply to threads"), true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_thread_create[{$folder['FID']}]", USER_PERM_THREAD_CREATE, gettext("Create new threads"), true), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_edit[{$folder['FID']}]", USER_PERM_POST_EDIT, gettext("Edit posts"), true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_delete[{$folder['FID']}]", USER_PERM_POST_DELETE, gettext("Delete posts"), true), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_attach[{$folder['FID']}]", USER_PERM_POST_ATTACHMENTS, gettext("Upload attachments"), true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_html[{$folder['FID']}]", USER_PERM_HTML_POSTING, gettext("Post in HTML"), true), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_sig[{$folder['FID']}]", USER_PERM_SIGNATURE, gettext("Post a signature"), true), "</td>\n";
            echo "                                    </tr>\n";
            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_moderator[{$folder['FID']}]", USER_PERM_FOLDER_MODERATE, gettext("Moderate folder")), "</td>\n";
            echo "                                      <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("t_post_approval[{$folder['FID']}]", USER_PERM_POST_APPROVAL, gettext("Require Post Approval")), "</td>\n";
            echo "                                    </tr>\n";


            echo "                                    <tr>\n";
            echo "                                      <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
            echo "                                    </tr>\n";
            echo "                                  </table>\n";
        }
    }

    echo "                                </div>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
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
}

echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("add_group", gettext("Add Empty Group")), "&nbsp;", form_submit("add_users", gettext("Add Users To Group")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();