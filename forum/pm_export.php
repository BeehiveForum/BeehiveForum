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
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to store error messages.
$error_msg_array = array();

// Check that PM system is enabled
pm_enabled();

// Variables to hold message counts
$pm_new_count = 0;
$pm_outbox_count = 0;
$pm_unread_count = 0;

// Check for new PMs
pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

// Get custom folder names array.
if (!$pm_folder_names_array = pm_get_folder_names(false)) {

    $pm_folder_names_array = array(
        PM_FOLDER_INBOX => gettext("Inbox"),
        PM_FOLDER_SENT => gettext("Sent Items"),
        PM_FOLDER_OUTBOX => gettext("Outbox"),
        PM_FOLDER_SAVED => gettext("Saved Items"),
        PM_FOLDER_DRAFTS => gettext("Drafts")
    );
}

// Submit code starts here.
if (isset($_POST['export'])) {

    $options_array = array();

    $pm_folders_array = array();

    if (isset($_POST['pm_folders_array']) && is_array($_POST['pm_folders_array'])) {

        foreach ($_POST['pm_folders_array'] as $folder => $export) {

            if (isset($pm_folder_names_array[$folder]) && ($export == 'Y')) {

                $pm_folders_array[] = $folder;
            }
        }
    }

    if (isset($_POST['pm_export_file']) && in_array($_POST['pm_export_file'], range(0, 2))) {
        $options_array['PM_EXPORT_FILE'] = $_POST['pm_export_file'];
    } else {
        $options_array['PM_EXPORT_FILE'] = 0;
    }

    if (isset($_POST['pm_export_type']) && in_array($_POST['pm_export_type'], range(0, 1))) {
        $options_array['PM_EXPORT_TYPE'] = $_POST['pm_export_type'];
    } else {
        $options_array['PM_EXPORT_TYPE'] = 0;
    }

    if (isset($_POST['pm_export_attachments']) && $_POST['pm_export_attachments'] == "Y") {
        $options_array['PM_EXPORT_ATTACHMENTS'] = "Y";
    } else {
        $options_array['PM_EXPORT_ATTACHMENTS'] = "N";
    }

    if (isset($_POST['pm_export_wordfilter']) && $_POST['pm_export_wordfilter'] == "Y") {
        $options_array['PM_EXPORT_WORDFILTER'] = "Y";
    } else {
        $options_array['PM_EXPORT_WORDFILTER'] = "N";
    }

    if (sizeof($pm_folders_array) > 0) {

        pm_export_folders($pm_folders_array, $options_array);

    } else {

        $error_msg_array[] = gettext("You must select some folders to export");
    }
}

// Get User Prefs
$user_prefs = user_get_prefs($_SESSION['UID']);

// Start output here
html_draw_top(
    array(
        'title' => gettext('Export Private Messages'),
        'js' => array(
            'js/emoticons.js'
        ),
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Export Private Messages"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '600', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"pm_export.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Select folders to export"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";

$pm_message_count_array = pm_get_folder_message_counts(false);

foreach ($pm_folder_names_array as $folder_type => $folder_name) {

    if (isset($pm_message_count_array[$folder_type]) && is_numeric($pm_message_count_array[$folder_type])) {

        echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"foldername\">", form_checkbox("pm_folders_array[$folder_type]", "Y", $folder_name), "&nbsp;<span class=\"pm_message_count\">({$pm_message_count_array[$folder_type]})</span></td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    }
}

echo "                  </td>\n";
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
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_type", array(gettext("HTML"), gettext("XML")), (isset($user_prefs['PM_EXPORT_TYPE']) && is_numeric($user_prefs['PM_EXPORT_TYPE'])) ? $user_prefs['PM_EXPORT_TYPE'] : 0), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("export", gettext("Export")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();