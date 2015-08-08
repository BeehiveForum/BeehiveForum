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
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages.
$error_msg_array = array();

// Get User Prefs
$user_prefs = user_get_prefs($_SESSION['UID']);

// Submit code starts here.
if (isset($_POST['save'])) {

    if (isset($_POST['pm_notify']) && $_POST['pm_notify'] == "Y") {
        $user_prefs['PM_NOTIFY'] = "Y";
    } else {
        $user_prefs['PM_NOTIFY'] = "N";
    }

    if (isset($_POST['pm_save_sent_items']) && $_POST['pm_save_sent_items'] == "Y") {
        $user_prefs['PM_SAVE_SENT_ITEM'] = "Y";
    } else {
        $user_prefs['PM_SAVE_SENT_ITEM'] = "N";
    }

    if (isset($_POST['pm_include_reply']) && $_POST['pm_include_reply'] == "Y") {
        $user_prefs['PM_INCLUDE_REPLY'] = "Y";
    } else {
        $user_prefs['PM_INCLUDE_REPLY'] = "N";
    }

    if (isset($_POST['pm_auto_prune_enabled']) && $_POST['pm_auto_prune_enabled'] == "Y") {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $user_prefs['PM_AUTO_PRUNE'] = $_POST['pm_auto_prune'];

        } else {

            $user_prefs['PM_AUTO_PRUNE'] = "-60";
        }

    } else {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $user_prefs['PM_AUTO_PRUNE'] = $_POST['pm_auto_prune'] * -1;

        } else {

            $user_prefs['PM_AUTO_PRUNE'] = "-60";
        }
    }

    if (isset($_POST['pm_export_file']) && is_numeric($_POST['pm_export_file'])) {
        $user_prefs['PM_EXPORT_FILE'] = $_POST['pm_export_file'];
    } else {
        $user_prefs['PM_EXPORT_FILE'] = 0;
    }

    if (isset($_POST['pm_export_type']) && is_numeric($_POST['pm_export_type'])) {
        $user_prefs['PM_EXPORT_TYPE'] = $_POST['pm_export_type'];
    } else {
        $user_prefs['PM_EXPORT_TYPE'] = 0;
    }

    if (isset($_POST['pm_export_attachments']) && $_POST['pm_export_attachments'] == "Y") {
        $user_prefs['PM_EXPORT_ATTACHMENTS'] = "Y";
    } else {
        $user_prefs['PM_EXPORT_ATTACHMENTS'] = "N";
    }

    if (isset($_POST['pm_export_wordfilter']) && $_POST['pm_export_wordfilter'] == "Y") {
        $user_prefs['PM_EXPORT_WORDFILTER'] = "Y";
    } else {
        $user_prefs['PM_EXPORT_WORDFILTER'] = "N";
    }

    // Update USER_PREFS
    if (user_update_prefs($_SESSION['UID'], $user_prefs)) {

        // Redirect back to the page so we correctly reload the user's preferences.
        header_redirect("pm_options.php?webtag=$webtag&updated=true");
        exit;

    } else {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

// Start output here
html_draw_top(
    array(
        'title' => gettext('Private Message Options'),
        'js' => array(
            'js/emoticons.js',
            'js/prefs.js',
        ),
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Private Message Options"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '700', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"pm_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Private Message Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("pm_notify", "Y", gettext("Notify by popup of new PM messages to me"), (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("pm_save_sent_items", "Y", gettext("Save a copy of each PM I send in my Sent Items folder"), (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("pm_include_reply", "Y", gettext("Include message body when replying to PM"), (isset($user_prefs['PM_INCLUDE_REPLY']) && $user_prefs['PM_INCLUDE_REPLY'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("pm_auto_prune_enabled", "Y", gettext("Auto prune my PM folders every:"), (isset($user_prefs['PM_AUTO_PRUNE']) && $user_prefs['PM_AUTO_PRUNE'] > 0) ? true : false), "&nbsp;", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($user_prefs['PM_AUTO_PRUNE']) ? ($user_prefs['PM_AUTO_PRUNE'] > 0 ? $user_prefs['PM_AUTO_PRUNE'] : $user_prefs['PM_AUTO_PRUNE'] * -1) : 60)), " ", gettext("days"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">", gettext("Private Message Export Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"7\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"250\" style=\"white-space: nowrap\">", gettext("Export as type"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_type", array(gettext("HTML"), gettext("XML"), gettext("CSV")), (isset($user_prefs['PM_EXPORT_TYPE']) && is_numeric($user_prefs['PM_EXPORT_TYPE'])) ? $user_prefs['PM_EXPORT_TYPE'] : 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"250\" style=\"white-space: nowrap\">", gettext("Export messages as"), ":</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_file", array(gettext("One file for all messages"), gettext("One file per message")), (isset($user_prefs['PM_EXPORT_FILE']) && is_numeric($user_prefs['PM_EXPORT_FILE'])) ? $user_prefs['PM_EXPORT_FILE'] : 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" style=\"white-space: nowrap\">", form_checkbox("pm_export_attachments", "Y", gettext("Export attachments"), (isset($user_prefs['PM_EXPORT_ATTACHMENTS']) && $user_prefs['PM_EXPORT_ATTACHMENTS'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" style=\"white-space: nowrap\">", form_checkbox("pm_export_wordfilter", "Y", gettext("Apply word filter to messages"), (isset($user_prefs['PM_EXPORT_WORDFILTER']) && $user_prefs['PM_EXPORT_WORDFILTER'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();