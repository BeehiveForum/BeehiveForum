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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'profile.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'user_profile.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

$admin_edit = false;

$profile_uid = $_SESSION['UID'];

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['profile_uid'])) {

        if (is_numeric($_GET['profile_uid'])) {

            $profile_uid = $_GET['profile_uid'];
            $admin_edit = true;

        } else {

            html_draw_error(gettext("No user specified."));
        }

    } else if (isset($_POST['profile_uid'])) {

        if (is_numeric($_POST['profile_uid'])) {

            $profile_uid = $_POST['profile_uid'];
            $admin_edit = true;

        } else {

            html_draw_error(gettext("No user specified."));
        }
    }

    if (isset($_POST['cancel'])) {

        header_redirect("admin_user.php?webtag=$webtag&uid=$profile_uid");
        exit;
    }
}

if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($profile_uid != $_SESSION['UID'])) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Fetch array of profile items.
$profile_items_array = profile_get_user_values($profile_uid);

// Array to hold error messages
$error_msg_array = array();

// Do updates
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['t_entry']) && is_array($_POST['t_entry'])) {

        $t_entry_array = $_POST['t_entry'];

        $t_entry_cleaned_array = array_map('strip_tags', $t_entry_array);

        if (sizeof(array_diff_assoc($t_entry_array, $t_entry_cleaned_array)) > 0) {

            $error_msg_array[] = gettext("Profile Entries must not include HTML");
            $valid = false;
        }

        if ($valid) {

            foreach ($t_entry_array as $piid => $profile_entry) {

                $profile_entry = trim($profile_entry);

                if ($admin_edit) {

                    $privacy = (isset($profile_items_array[$piid]['PRIVACY']) ? $profile_items_array[$piid]['PRIVACY'] : PROFILE_ITEM_PRIVATE);

                } else if (isset($_POST['t_entry_private'][$piid]) && in_array($_POST['t_entry_private'][$piid], array(PROFILE_ITEM_PUBLIC, PROFILE_ITEM_FRIENDS, PROFILE_ITEM_PRIVATE))) {

                    $privacy = $_POST['t_entry_private'][$piid];

                } else {

                    $privacy = PROFILE_ITEM_PRIVATE;
                }

                if (!user_profile_update($profile_uid, $piid, $profile_entry, $privacy)) {

                    $error_msg_array[] = gettext("Failed to update user profile");
                    $valid = false;
                }
            }

            if ($valid) {

                if ($admin_edit === true) {

                    header_redirect("admin_user.php?webtag=$webtag&uid=$profile_uid&profile_updated=true", gettext("Profile updated."));
                    exit;

                } else {

                    header_redirect("edit_profile.php?webtag=$webtag&uid=$profile_uid&profile_updated=true", gettext("Profile updated."));
                    exit;
                }
            }
        }
    }
}

if (is_array($profile_items_array) && sizeof($profile_items_array) > 0) {

    if ($admin_edit === true) {

        $user = user_get($profile_uid);

        html_draw_top(
            array(
                'title' => sprintf(
                    gettext('Admin - Edit Profile - %s'),
                    format_user_name($user['LOGON'], $user['NICKNAME'])
                ),
                'class' => 'window_title',
                'js' => array(
                    'js/prefs.js',
                )
            )
        );

        echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Manage User"), html_style_image('separator'), format_user_name($user['LOGON'], $user['NICKNAME']), "</h1>\n";

    } else {

        html_draw_top(
            array(
                'title' => gettext("My Controls - Edit Profile"),
                'class' => 'window_title'
            )
        );

        echo "<h1>", gettext("Edit Profile"), "</h1>\n";
    }

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '700', ($admin_edit) ? 'center' : 'left');

    } else if (isset($_GET['profile_updated'])) {

        html_display_success_msg(gettext("Profile updated."), '700', ($admin_edit) ? 'center' : 'left');
    }

    if ($admin_edit === true) echo "<div align=\"center\">\n";

    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_profile\" action=\"edit_profile.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

    if ($admin_edit === true) echo "  ", form_input_hidden('profile_uid', htmlentities_array($profile_uid)), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td>\n";
    echo "              <table class=\"box\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"posthead\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";

    $last_psid = false;

    foreach ($profile_items_array as $profile_item) {

        if (!isset($profile_item['ENTRY'])) $profile_item['ENTRY'] = '';

        if ($profile_item['PSID'] != $last_psid) {

            if ($last_psid !== false) {

                echo "                      <tr>\n";
                echo "                        <td>&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
                echo "        <br />\n";
                echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td>\n";
                echo "              <table class=\"box\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td class=\"posthead\">\n";
                echo "                    <table class=\"posthead\" width=\"100%\">\n";
                echo "                      <tr>\n";
                echo "                        <td class=\"subhead\" colspan=\"3\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                      </tr>\n";

            } else {

                echo "                      <tr>\n";
                echo "                        <td class=\"subhead\" colspan=\"3\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                      </tr>\n";
            }
        }

        $last_psid = $profile_item['PSID'];

        echo "                      <tr>\n";
        echo "                        <td></td>\n";
        echo "                        <td colspan=\"2\">{$profile_item['ITEM_NAME']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td></td>\n";
        echo "                        <td>\n";

        if (($profile_item['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_item['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

            $profile_item_options_array = htmlentities_array(explode("\n", $profile_item['OPTIONS']));

            profile_item_add_clear_entry($profile_item_options_array, $profile_item['TYPE']);

            if ($profile_item['TYPE'] == PROFILE_ITEM_RADIO) {
                echo form_radio_array("t_entry[{$profile_item['PIID']}]", $profile_item_options_array, (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY']))), "\n";
            } else {
                echo form_dropdown_array("t_entry[{$profile_item['PIID']}]", $profile_item_options_array, (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY'])), null, 'bhinputprofileitem'), "\n";
            }

        } else if ($profile_item['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo form_textarea("t_entry[{$profile_item['PIID']}]", (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY'])), null, null, null, 'bhinputprofileitem'), "\n";

        } else {

            echo form_input_text("t_entry[{$profile_item['PIID']}]", (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY'])), null, null, null, 'bhinputprofileitem'), "\n";
        }

        echo "</td>\n";

        if ($admin_edit === false) {
            echo "                        <td>", form_dropdown_array("t_entry_private[{$profile_item['PIID']}]", array(gettext("Public"), gettext("Friends"), gettext("Only Me")), $profile_item['PRIVACY'], null, 'bhinputprofileprivacy'), "</td>\n";
        } else {
            echo "                        <td>&nbsp;</td>\n";
        }

        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td>&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td>&nbsp;</td>\n";
    echo "          </tr>\n";

    if ($admin_edit === true) {

        echo "          <tr>\n";
        echo "            <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "          </tr>\n";

    } else {

        echo "          <tr>\n";
        echo "            <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
        echo "          </tr>\n";
    }

    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    if ($admin_edit === true) echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_error(gettext("The forum owner has not set up Profiles."));
}