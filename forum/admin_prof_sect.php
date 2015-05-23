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
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'profile.inc.php';
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

// Array for holding error messages
$error_msg_array = array();

$t_name_new = null;
$t_new_name = null;

$psid = null;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
} else {
    $page = 1;
}

// Cancel button clicked.
if (isset($_POST['cancel'])) {

    header_redirect("admin_prof_sect.php?webtag=$webtag");
    exit;
}

if (isset($_POST['delete_sections'])) {

    $valid = true;

    if (isset($_POST['delete_section']) && is_array($_POST['delete_section'])) {

        foreach ($_POST['delete_section'] as $psid => $delete_section) {

            if ($valid && $delete_section == "Y" && $profile_name = profile_section_get_name($psid)) {

                if (profile_section_delete($psid)) {

                    admin_add_log_entry(DELETE_PROFILE_SECT, array($profile_name));

                } else {

                    $error_msg_array[] = gettext("Failed to remove profile sections");
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_prof_sect.php?webtag=$webtag&deleted=true");
            exit;
        }
    }

} else if (isset($_POST['addsectionsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim($_POST['t_name_new'])) > 0) {
        $t_name_new = trim($_POST['t_name_new']);
    } else {
        $error_msg_array[] = gettext("Must specify a profile section name");
        $valid = false;
    }

    if ($valid) {

        if (($new_psid = profile_section_create($t_name_new)) !== false) {

            header_redirect("admin_prof_sect.php?webtag=$webtag&added=true");
            exit;
        }
    }

} else if (isset($_POST['editfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {
        $psid = $_POST['psid'];
    } else {
        $error_msg_array[] = gettext("Must specify a profile section ID");
        $valid = false;
    }

    if (isset($_POST['t_name_new']) && strlen(trim($_POST['t_name_new'])) > 0) {
        $t_new_name = trim($_POST['t_name_new']);
    } else {
        $error_msg_array[] = gettext("Must specify a profile section name");
        $valid = false;
    }

    if ($valid) {

        if (profile_section_update($psid, $t_new_name)) {

            $t_section_name = profile_section_get_name($psid);

            if ($t_new_name != $t_section_name) {
                admin_add_log_entry(CHANGE_PROFILE_SECT, array($t_section_name, $t_new_name));
            }

            header_redirect("admin_prof_sect.php?webtag=$webtag&edited=true");
            exit;
        }
    }

} else if (isset($_POST['addsection'])) {

    $redirect = "admin_prof_sect.php?webtag=$webtag&page=$page&addsection=true";
    header_redirect($redirect);
    exit;

} else if (isset($_POST['viewitems']) && is_array($_POST['viewitems'])) {

    list($psid) = array_keys($_POST['viewitems']);
    $redirect = "admin_prof_items.php?webtag=$webtag&psid=$psid&sect_page=$page";
    header_redirect($redirect);
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($psid) = array_keys($_POST['move_up']);
    profile_section_move_up($psid);
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($psid) = array_keys($_POST['move_down']);
    profile_section_move_down($psid);
}

if (isset($_GET['addsection']) || isset($_POST['addsection'])) {

    html_draw_top(
        array(
            'title' => gettext('Admin - Manage Profile Sections - Add new profile section'),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Profile Sections"), html_style_image('separator'), gettext("Add new profile section"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_prof_sect.php\" method=\"post\" target=\"_self\">\n";
    echo "    ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addsection', 'true'), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Section Name"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Section Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array($_POST['t_name_new']) : ""), 52, 64), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addsectionsubmit", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else if (isset($_POST['psid']) || isset($_GET['psid'])) {

    if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {

        $psid = $_POST['psid'];

    } else if (isset($_GET['psid']) && is_numeric($_GET['psid'])) {

        $psid = $_GET['psid'];

    } else {

        html_draw_error(gettext("Invalid profile section ID or section not found"), 'admin_prof_sect.php', 'get', array('back' => gettext("Back")));
    }

    if (!$profile_section = profile_get_section($psid)) {
        html_draw_error(gettext("Invalid profile section ID or section not found"), 'admin_prof_sect.php', 'get', array('back' => gettext("Back")));
    }

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - Manage Profile Sections - %s'),
                $profile_section['NAME']
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Profile Sections"), html_style_image('separator'), word_filter_add_ob_tags($profile_section['NAME'], true), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_prof_sect.php\" method=\"post\" target=\"_self\">\n";
    echo "    ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('psid', htmlentities_array($psid)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Section Name"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Section Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array($_POST['t_name_new']) : htmlentities_array($profile_section['NAME'])), 52, 64), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("editfeedsubmit", gettext("Save")), "&nbsp;", form_submit("viewitems[$psid]", gettext("View items")), "&nbsp;", form_submit("cancel", gettext("Back")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_top(
        array(
            'title' => gettext('Admin - Manage Profile Sections'),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    $profile_sections = profile_sections_get_by_page($page);

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Profile Sections"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '86%', 'center');

    } else if (isset($_GET['added'])) {

        html_display_success_msg(gettext("Successfully added profile section"), '86%', 'center');

    } else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully edited profile section"), '86%', 'center');

    } else if (isset($_GET['deleted'])) {

        html_display_success_msg(gettext("Successfully removed selected profile sections"), '86%', 'center');

    } else if (sizeof($profile_sections['profile_sections_array']) < 1) {

        html_display_warning_msg(gettext("No existing profile sections found. To add a profile section click the 'Add New' button below."), '86%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_sections\" action=\"admin_prof_sect.php\" method=\"post\">\n";
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
    echo "                  <td class=\"subhead\" align=\"left\" width=\"25\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\">", gettext("Section Name"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"50\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"center\">", gettext("Items"), "</td>\n";
    echo "                </tr>\n";

    if (sizeof($profile_sections['profile_sections_array']) > 0) {

        foreach ($profile_sections['profile_sections_array'] as $profile_section) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"25\">", form_checkbox("delete_section[{$profile_section['PSID']}]", "Y"), "</td>\n";
            echo "                  <td valign=\"top\" align=\"left\"><a href=\"admin_prof_sect.php?webtag=$webtag&amp;page=$page&amp;psid={$profile_section['PSID']}\">", word_filter_add_ob_tags($profile_section['NAME'], true), "</a></td>\n";
            echo "                  <td align=\"center\" width=\"50\" style=\"white-space: nowrap\">", form_submit_image('move_up', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"100\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid={$profile_section['PSID']}&amp;sect_page=$page&amp;viewitems=yes\">", htmlentities_array($profile_section['ITEM_COUNT']), "</a></td>\n";
            echo "                </tr>\n";
        }
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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

    html_page_links("admin_prof_sect.php?webtag=$webtag", $page, $profile_sections['profile_sections_count'], 10);

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addsection", gettext("Add New")), "&nbsp;", form_submit("delete_sections", gettext("Delete Selected")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}