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
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages
$error_msg_array = array();

// Get User Prefs
$user_prefs = user_get_prefs($_SESSION['UID']);

// Submit code
if (isset($_POST['save'])) {

    $user_prefs_global = array();

    if (isset($_POST['allow_email']) && $_POST['allow_email'] == "Y") {
        $user_prefs['ALLOW_EMAIL'] = "Y";
    } else {
        $user_prefs['ALLOW_EMAIL'] = "N";
    }

    if (isset($_POST['use_email_addr']) && $_POST['use_email_addr'] == "Y") {
        $user_prefs['USE_EMAIL_ADDR'] = "Y";
    } else {
        $user_prefs['USE_EMAIL_ADDR'] = "N";
    }

    if (isset($_POST['allow_pm']) && $_POST['allow_pm'] == "Y") {
        $user_prefs['ALLOW_PM'] = "Y";
    } else {
        $user_prefs['ALLOW_PM'] = "N";
    }

    if (isset($_POST['email_notify']) && $_POST['email_notify'] == "Y") {
        $user_prefs['EMAIL_NOTIFY'] = "Y";
    } else {
        $user_prefs['EMAIL_NOTIFY'] = "N";
    }

    if (isset($_POST['email_notify_global'])) {
        $user_prefs_global['EMAIL_NOTIFY'] = ($_POST['email_notify_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['EMAIL_NOTIFY'] = false;
    }

    if (isset($_POST['pm_notify_email']) && $_POST['pm_notify_email'] == "Y") {
        $user_prefs['PM_NOTIFY_EMAIL'] = "Y";
    } else {
        $user_prefs['PM_NOTIFY_EMAIL'] = "N";
    }

    if (isset($_POST['anon_logon']) && is_numeric($_POST['anon_logon'])) {
        $user_prefs['ANON_LOGON'] = intval($_POST['anon_logon']);
    } else {
        $user_prefs['ANON_LOGON'] = 0;
    }

    if (isset($_POST['dob_display'])) {
        $user_prefs['DOB_DISPLAY'] = trim($_POST['dob_display']);
    } else {
        $user_prefs['DOB_DISPLAY'] = 0;
    }

    // Update USER_PREFS
    if (user_update_prefs($_SESSION['UID'], $user_prefs, $user_prefs_global)) {

        header_redirect("edit_email.php?webtag=$webtag&updated=true");
        exit;

    } else {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

// Check to see if we should show the set for all forums checkboxes
$show_set_all = (forums_get_available_count() > 1) ? true : false;

html_draw_top(
    array(
        'title' => gettext('My Controls - Email & Privacy'),
        'class' => 'window_title',
        'js' => array(
            'js/prefs.js',
        )
    )
);

echo "<h1>", htmlentities_array(gettext("Email & Privacy")), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '700', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"edit_email.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Email and contact settings"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Email and contact settings"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("allow_email", "Y", gettext("Allow other users to send me emails via my profile"), (isset($user_prefs['ALLOW_EMAIL']) && $user_prefs['ALLOW_EMAIL'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("use_email_addr", "Y", gettext("Use my email address when sending other users emails via their profiles"), (isset($user_prefs['USE_EMAIL_ADDR']) && $user_prefs['USE_EMAIL_ADDR'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("allow_pm", "Y", gettext("Allow other users to send me personal messages"), (isset($user_prefs['ALLOW_PM']) && $user_prefs['ALLOW_PM'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("email_notify", "Y", gettext("Notify by email of posts to me"), (isset($user_prefs['EMAIL_NOTIFY']) && $user_prefs['EMAIL_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("email_notify_global", "Y", null, (isset($user_prefs['EMAIL_NOTIFY_GLOBAL']) ? $user_prefs['EMAIL_NOTIFY_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("email_notify_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_checkbox("pm_notify_email", "Y", gettext("Notify by email of new PM messages to me"), (isset($user_prefs['PM_NOTIFY_EMAIL']) && $user_prefs['PM_NOTIFY_EMAIL'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Birthday and date of birth display"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("dob_display", USER_DOB_DISPLAY_NONE, gettext("Do not show my age or date of birth to others"), ((isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_NONE) || !isset($user_prefs['DOB_DISPLAY']))), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("dob_display", USER_DOB_DISPLAY_AGE, gettext("Show only my age to others"), (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_AGE)), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("dob_display", USER_DOB_DISPLAY_DATE, gettext("Show only my day and month of birth to others"), (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_DATE)), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("dob_display", USER_DOB_DISPLAY_BOTH, gettext("Show both my age and date of birth to others"), (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_BOTH)), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Forum anonymity settings"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"5\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("anon_logon", USER_ANON_DISABLED, gettext("List me on the active users display"), ((isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == USER_ANON_DISABLED) || !isset($user_prefs['ANON_LOGON'])) ? true : false), "</td>\n";
echo "                  <td align=\"right\" style=\"white-space: nowrap\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("anon_logon", USER_ANON_ENABLED, gettext("Browse forum anonymously"), (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == USER_ANON_ENABLED) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_radio("anon_logon", USER_ANON_FRIENDS_ONLY, gettext("Browse anonymously, but allow friends to see me as online"), (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == USER_ANON_FRIENDS_ONLY) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();