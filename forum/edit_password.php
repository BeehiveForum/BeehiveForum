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

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages
$error_msg_array = array();

// Arrays to hold our cookie data
$username_array = array();
$password_array = array();
$passhash_array = array();

// Submit code
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['opw']) && strlen(trim($_POST['opw'])) > 0) {

        $t_old_pass = trim($_POST['opw']);

    } else {

        $error_msg_array[] = gettext("You must enter your current password");
        $valid = false;
    }

    if (isset($_POST['npw']) && strlen(trim($_POST['npw'])) > 0) {

        $t_new_pass = trim($_POST['npw']);

    } else {

        $error_msg_array[] = gettext("You must enter a new password");
        $valid = false;
    }

    if (isset($_POST['cpw']) && strlen(trim($_POST['cpw'])) > 0) {

        $t_confirm_pass = trim($_POST['cpw']);

    } else {

        $error_msg_array[] = gettext("You must confirm your new password");
        $valid = false;
    }

    if ($valid) {

        if ($t_new_pass != $t_confirm_pass) {

            $error_msg_array[] = gettext("Passwords do not match");
            $valid = false;
        }

        if (htmlentities_array($t_new_pass) != $t_new_pass) {

            $error_msg_array[] = gettext("Password must not contain HTML tags");
            $valid = false;
        }

        if (mb_strlen($t_new_pass) < 6) {

            $error_msg_array[] = gettext("Password must be a minimum of 6 characters long");
            $valid = false;
        }

        if ($t_old_pass == $t_new_pass) {

            $error_msg_array[] = gettext("New and old passwords are the same.");
            $valid = false;
        }

        if ($valid) {

            // User's UID for updating with.
            $uid = session::get_value('UID');

            // Fetch current logon.
            $logon = session::get_value('LOGON');

            // Update the password and cookie
            if (user_change_password($uid, $t_new_pass, $t_old_pass)) {

                // Force redirect to prevent refreshing the page
                // prompting to user to resubmit form data.
                header_redirect("edit_password.php?webtag=$webtag&updated=true", gettext("Password changed"));
                exit;

            } else {

                $error_msg_array[] = gettext("Update failed");
                $valid = false;
            }
        }
    }
}

// Start Output Here
html_draw_top(sprintf('title=%s', gettext("My Controls - Change Password")), 'class=window_title');

echo "<h1>", gettext("Change Password"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '600', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"edit_password.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Change Password"), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Current Password"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_password("opw", "", 37, 0), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("New Password"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_password("npw", "", 37, 0), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Confirm Password"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_password("cpw", "", 37, 0), "&nbsp;</td>\n";
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

?>