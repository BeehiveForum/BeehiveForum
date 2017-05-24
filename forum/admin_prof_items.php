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

$t_type_new = null;
$t_new_name = null;
$t_options_new = null;
$t_section_new = null;
$t_name_new = null;

$psid = null;

if (isset($_GET['sect_page']) && is_numeric($_GET['sect_page'])) {
    $sect_page = ($_GET['sect_page'] > 0) ? intval($_GET['sect_page']) : 1;
} else if (isset($_POST['sect_page']) && is_numeric($_POST['sect_page'])) {
    $sect_page = ($_POST['sect_page'] > 0) ? intval($_POST['sect_page']) : 1;
} else {
    $sect_page = 1;
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? intval($_POST['page']) : 1;
} else {
    $page = 1;
}

if (isset($_GET['psid']) && is_numeric($_GET['psid'])) {

    $psid = intval($_GET['psid']);

} else if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {

    $psid = intval($_POST['psid']);

} else {

    html_draw_error(gettext("No Profile section specified."), 'admin_prof_sect.php', 'get', array('back' => gettext("Back")));
}

// Array to hold error messages
$error_msg_array = array();

// Array of valid profile item types
$profile_item_valid_types = array(
    PROFILE_ITEM_LARGE_TEXT,
    PROFILE_ITEM_MEDIUM_TEXT,
    PROFILE_ITEM_SMALL_TEXT,
    PROFILE_ITEM_MULTI_TEXT,
    PROFILE_ITEM_RADIO,
    PROFILE_ITEM_DROPDOWN,
    PROFILE_ITEM_HYPERLINK
);

// Array of profile item type descriptions.
$item_types_array = array(
    PROFILE_ITEM_LARGE_TEXT => gettext("Text Field"),
    PROFILE_ITEM_MULTI_TEXT => gettext("Multi-line Text Field"),
    PROFILE_ITEM_RADIO => gettext("Radio Buttons"),
    PROFILE_ITEM_DROPDOWN => gettext("Drop Down List"),
    PROFILE_ITEM_HYPERLINK => gettext("Clickable Hyperlink")
);

// View type
if (isset($_GET['viewitems'])) {
    $viewitems = "yes";
} else if (isset($_POST['viewitems'])) {
    $viewitems = "yes";
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_item']) && is_array($_POST['delete_item'])) {

        foreach ($_POST['delete_item'] as $piid => $delete_item) {

            if ($valid && $delete_item == "Y" && $profile_item_name = profile_item_get_name($piid)) {

                if (($section_name = profile_section_get_name($_POST['psid'])) !== false) {

                    if (profile_item_delete($piid)) {

                        admin_add_log_entry(DELETE_PROFILE_ITEM, array($section_name, $profile_item_name));

                    } else {

                        $error_msg_array[] = gettext("Failed to remove profile items");
                        $valid = false;
                    }
                }
            }
        }

        if ($valid) {

            header_redirect("admin_prof_items.php?webtag=$webtag&psid=$psid&deleted=true");
            exit;
        }
    }
}

if (isset($_POST['cancel'])) {

    header_redirect("admin_prof_items.php?webtag=$webtag&psid=$psid");
    exit;
}

if (isset($_POST['back'])) {

    if (isset($viewitems)) {

        $redirect = "admin_prof_sect.php?webtag=$webtag&page=$sect_page";
        header_redirect($redirect);

    } else {

        $redirect = "admin_prof_sect.php?webtag=$webtag&psid=$psid&page=$sect_page";
        header_redirect($redirect);
    }
}

if (isset($_POST['additemsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim($_POST['t_name_new'])) > 0) {

        $t_new_name = trim($_POST['t_name_new']);

    } else {

        $error_msg_array[] = gettext("You must enter a profile item name");
        $valid = false;
    }

    if (isset($_POST['t_type_new']) && in_array($_POST['t_type_new'], $profile_item_valid_types)) {

        $t_type_new = $_POST['t_type_new'];

    } else {

        $error_msg_array[] = gettext("Invalid profile item type selected");
        $valid = false;
    }

    if (isset($_POST['t_options_new']) && strlen(trim($_POST['t_options_new'])) > 0) {

        $t_options_new = trim($_POST['t_options_new']);

        if ($valid && ($t_type_new == PROFILE_ITEM_RADIO || $t_type_new == PROFILE_ITEM_DROPDOWN)) {

            if (sizeof(explode("\n", $t_options_new)) < 1) {

                $error_msg_array[] = gettext("You must enter more than one option for selected profile item type");
                $valid = false;
            }

        } else if ($valid && $t_type_new == PROFILE_ITEM_HYPERLINK) {

            $check_url = parse_url($t_options_new);

            if (!isset($check_url['scheme']) || $check_url['scheme'] != "http") {

                $valid = false;
                $error_msg_array[] = gettext("Profile item hyperlinks support HTTP URLs only");
            }

            if ($valid && (!isset($check_url['host']) || strlen(trim($check_url['host'])) < 1)) {

                $valid = false;
                $error_msg_array[] = gettext("Profile item hyperlink format invalid");
            }

            if (preg_match('/\[ProfileEntry\]/iu', $t_options_new) < 1) {

                $error_msg_array[] = sprintf(gettext("You must include <i>%s</i> in the URL of clickable hyperlinks"), '[ProfileEntry]');
                $valid = false;
            }
        }

    } else if ($valid && ($t_type_new == PROFILE_ITEM_RADIO || $t_type_new == PROFILE_ITEM_DROPDOWN || $t_type_new == PROFILE_ITEM_HYPERLINK)) {

        $error_msg_array[] = gettext("You must enter some options for selected profile item type");
        $valid = false;

    } else {

        $t_options_new = "";
    }

    if ($valid) {

        if (($new_piid = profile_item_create($psid, $t_new_name, $t_type_new, $t_options_new)) !== false) {

            $t_section_name = profile_section_get_name($psid);

            admin_add_log_entry(ADDED_PROFILE_ITEM, array($t_section_name, $t_new_name));
            header_redirect("admin_prof_items.php?webtag=$webtag&psid=$psid&added=true");
            exit;

        } else {

            $error_msg_error[] = gettext("Failed to create new profile item");
            $valid = false;
        }
    }

} else if (isset($_POST['edititemsubmit'])) {

    $valid = true;

    if (isset($_POST['piid']) && is_numeric($_POST['piid'])) {

        $piid = intval($_POST['piid']);

    } else {

        $error_msg_array[] = gettext("Invalid profile item ID or item not found");
        $valid = false;
    }

    if (isset($_POST['t_name_new']) && strlen(trim($_POST['t_name_new'])) > 0) {

        $t_name_new = trim($_POST['t_name_new']);

    } else {

        $error_msg_array[] = gettext("You must enter a profile item name");
        $valid = false;
    }

    if (isset($_POST['t_type_new']) && in_array($_POST['t_type_new'], $profile_item_valid_types)) {

        $t_type_new = $_POST['t_type_new'];

    } else {

        $error_msg_array[] = gettext("Invalid profile item type selected");
        $valid = false;
    }

    if (isset($_POST['t_options_new']) && strlen(trim($_POST['t_options_new'])) > 0) {

        $t_options_new = trim($_POST['t_options_new']);

        if ($valid && ($t_type_new == PROFILE_ITEM_RADIO || $t_type_new == PROFILE_ITEM_DROPDOWN)) {

            if (sizeof(explode("\n", $t_options_new)) < 1) {

                $error_msg_array[] = gettext("You must enter more than one option for selected profile item type");
                $valid = false;
            }

        } else if ($valid && $t_type_new == PROFILE_ITEM_HYPERLINK) {

            $check_url = parse_url($t_options_new);

            if (!isset($check_url['scheme']) || $check_url['scheme'] != "http") {

                $valid = false;
                $error_msg_array[] = gettext("Profile item hyperlinks support HTTP URLs only");
            }

            if ($valid && (!isset($check_url['host']) || strlen(trim($check_url['host'])) < 1)) {

                $valid = false;
                $error_msg_array[] = gettext("Profile item hyperlink format invalid");
            }

            if (preg_match('/\[ProfileEntry\]/iu', $t_options_new) < 1) {

                $error_msg_array[] = sprintf(gettext("You must include <i>%s</i> in the URL of clickable hyperlinks"), '[ProfileEntry]');
                $valid = false;
            }
        }

    } else if ($valid && ($t_type_new == PROFILE_ITEM_RADIO || $t_type_new == PROFILE_ITEM_DROPDOWN || $t_type_new == PROFILE_ITEM_HYPERLINK)) {

        $error_msg_array[] = gettext("You must enter some options for selected profile item type");
        $valid = false;

    } else {

        $t_options_new = "";
    }

    if (isset($_POST['t_section_new']) && is_numeric($_POST['t_section_new'])) {

        $t_section_new = intval($_POST['t_section_new']);

    } else {

        $error_msg_array[] = gettext("Invalid profile section ID or section not found");
        $valid = false;
    }

    if ($valid) {

        if (profile_item_update($piid, $t_section_new, $t_type_new, $t_name_new, $t_options_new)) {

            $profile_item = profile_get_item($piid);

            if (($t_name_new != $profile_item['NAME']) || ($t_type_new != $profile_item['TYPE']) || ($t_section_new != $psid) || ($t_options_new != $profile_item['OPTIONS'])) {

                $log_data = array(
                    $t_name_new,
                    $profile_item['NAME'],
                    $t_type_new,
                    $profile_item['TYPE'],
                    $t_section_new, $psid
                );

                admin_add_log_entry(CHANGE_PROFILE_ITEM, $log_data);
            }

            header_redirect("admin_prof_items.php?webtag=$webtag&psid=$psid&edited=true");
            exit;

        } else {

            $error_msg_array[] = gettext("Failed to update profile item");
            $valid = false;
        }
    }

} else if (isset($_POST['additem'])) {

    $redirect = "admin_prof_items.php?webtag=$webtag&psid=$psid&additem=true&sect_page=$sect_page";
    header_redirect($redirect);
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($piid) = array_keys($_POST['move_up']);
    profile_item_move_up($psid, $piid);
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($piid) = array_keys($_POST['move_down']);
    profile_item_move_down($psid, $piid);
}

if (isset($_GET['additem']) || isset($_POST['additem'])) {

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - Manage Profile Sections - %s - Add New Item'),
                profile_section_get_name($psid)
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Profile Sections"), html_style_image('separator'), profile_section_get_name($psid), html_style_image('separator'), gettext("Add new item"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("psid", htmlentities_array($psid)), "\n";
    echo "  ", form_input_hidden("sect_page", htmlentities_array($sect_page)), "\n";

    if (isset($viewitems)) echo "  ", form_input_hidden("viewitems", "yes"), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" colspan=\"2\">", gettext("Add new item"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">", gettext("Type"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_type_new", $item_types_array), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">", gettext("Item Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array($_POST['t_name_new']) : ""), 52, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" valign=\"top\">", gettext("Options"), ":</td>\n";
    echo "                        <td align=\"left\">", form_textarea("t_options_new", (isset($_POST['t_options_new']) ? htmlentities_array($_POST['t_options_new']) : ""), 6, 50), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("additemsubmit", gettext("Add")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(gettext("To create Radio Buttons or a Drop Down List you need to enter each individual value on a separate line in the Options field."), '700', 'center');

    html_display_warning_msg(gettext("To create clickable links enter the URL in the Options field and use <i>[ProfileEntry]</i> where the entry from the user's profile should appear. Examples: <p>MySpace: <i>http://www.myspace.com/[ProfileEntry]</i><br />Xbox LIVE: <i>http://profile.mygamercard.net/[ProfileEntry]</i></p>"), '700', 'center');

    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else if (isset($_GET['piid']) || isset($_POST['piid'])) {

    if (isset($_POST['piid']) && is_numeric($_POST['piid'])) {

        $piid = intval($_POST['piid']);

    } else if (isset($_GET['piid']) && is_numeric($_GET['piid'])) {

        $piid = intval($_GET['piid']);

    } else {

        html_draw_error(gettext("Invalid profile item ID or item not found"), 'admin_prof_sect.php', 'get', array('back' => gettext("Back")));
    }

    if (!$profile_item = profile_get_item($piid)) {
        html_draw_error(gettext("Invalid profile item ID or item not found"), 'admin_prof_sect.php', 'get', array('back' => gettext("Back")));
    }

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - Manage Profile Sections - %s - Edit Item - %s'),
                profile_section_get_name($psid),
                $profile_item['NAME']
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Profile Sections"), html_style_image('separator'), profile_section_get_name($psid), html_style_image('separator'), gettext("Edit item"), html_style_image('separator'), word_filter_add_ob_tags($profile_item['NAME'], true), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '700', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("psid", htmlentities_array($psid)), "\n";
    echo "  ", form_input_hidden("piid", htmlentities_array($piid)), "\n";
    echo "  ", form_input_hidden("sect_page", htmlentities_array($sect_page)), "\n";
    echo "  ", form_input_hidden("delete_item[$piid]", "Y"), "\n";

    if (isset($viewitems)) echo "  ", form_input_hidden("viewitems", "yes"), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" colspan=\"2\">", gettext("Edit item"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">", gettext("Type"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_type_new", $item_types_array, (isset($_POST['t_type_new']) && is_numeric($_POST['t_type_new']) ? $_POST['t_type_new'] : $profile_item['TYPE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">", gettext("Section Name"), ":</td>\n";
    echo "                        <td align=\"left\">", profile_section_dropdown($psid, "t_section_new"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">", gettext("Item Name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array($_POST['t_name_new']) : htmlentities_array($profile_item['NAME'])), 52, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" valign=\"top\">", gettext("Options"), ":</td>\n";
    echo "                        <td align=\"left\">", form_textarea("t_options_new", (isset($_POST['t_options_new']) ? htmlentities_array($_POST['t_options_new']) : htmlentities_array($profile_item['OPTIONS'])), 6, 50), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("edititemsubmit", gettext("Save")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

    html_display_warning_msg(gettext("To create Radio Buttons or a Drop Down List you need to enter each individual value on a separate line in the Options field."), '700', 'center');

    html_display_warning_msg(gettext("To create clickable links enter the URL in the Options field and use <i>[ProfileEntry]</i> where the entry from the user's profile should appear. Examples: <p>MySpace: <i>http://www.myspace.com/[ProfileEntry]</i><br />Xbox LIVE: <i>http://profile.mygamercard.net/[ProfileEntry]</i></p>"), '700', 'center');

    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Admin - Manage Profile Sections - %s - View Items'),
                profile_section_get_name($psid)
            ),
            'class' => 'window_title',
            'main_css' => 'admin.css'
        )
    );

    $profile_items = profile_items_get_by_page($psid, $page);

    echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage Profile Sections"), html_style_image('separator'), profile_section_get_name($psid), html_style_image('separator'), gettext("View items"), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '86%', 'center');

    } else if (isset($_GET['added'])) {

        html_display_success_msg(gettext("Successfully added new profile item"), '86%', 'center');

    } else if (isset($_GET['edited'])) {

        html_display_success_msg(gettext("Successfully edited profile item"), '86%', 'center');

    } else if (isset($_GET['deleted'])) {

        html_display_success_msg(gettext("Successfully removed selected profile items"), '86%', 'center');

    } else if (sizeof($profile_items['profile_items_array']) < 1) {

        html_display_warning_msg(gettext("There are no existing profile items in this section. To add an item click the 'Add New' button below."), '86%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("psid", htmlentities_array($psid)), "\n";
    echo "  ", form_input_hidden("sect_page", htmlentities_array($sect_page)), "\n";

    if (isset($viewitems)) echo "  ", form_input_hidden("viewitems", "yes"), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"25\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\">", gettext("Item Name"), "</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"50\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"150\">", gettext("Type"), "</td>\n";
    echo "                </tr>\n";

    if (sizeof($profile_items['profile_items_array']) > 0) {

        foreach ($profile_items['profile_items_array'] as $profile_item) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"25\">", form_checkbox("delete_item[{$profile_item['PIID']}]", "Y"), "</td>\n";
            echo "                  <td valign=\"top\" align=\"left\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid=$psid&amp;piid={$profile_item['PIID']}&amp;sect_page=$sect_page\">", word_filter_add_ob_tags($profile_item['NAME'], true), "</a></td>\n";
            echo "                  <td align=\"center\" width=\"50\" style=\"white-space: nowrap\">", form_submit_image('move_up', "move_up[{$profile_item['PIID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down', "move_down[{$profile_item['PIID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";

            if (isset($item_types_array[$profile_item['TYPE']])) {
                echo "                  <td valign=\"top\" align=\"left\" width=\"100\">{$item_types_array[$profile_item['TYPE']]}</td>\n";
            } else {
                echo "                  <td valign=\"top\" align=\"left\" width=\"100\">", gettext("Text Field"), "</td>\n";
            }

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

    html_page_links("admin_prof_items.php?webtag=$webtag&psid=$psid&sect_page=$sect_page", $page, $profile_items['profile_items_count'], 10);

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("additem", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "&nbsp;", form_submit("back", gettext("Back")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}