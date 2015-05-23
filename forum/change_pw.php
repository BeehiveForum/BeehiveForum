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
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Array to hold error messages
$error_msg_array = array();

$pw = null;
$cpw = null;

// Submit code.
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['u']) && is_numeric($_POST['u'])) {

        $uid = $_POST['u'];

    } else {

        $error_msg_array[] = gettext("Invalid user account specified. Check email for correct link");
        $valid = false;
    }

    if (isset($_POST['h']) && strlen(trim($_POST['h'])) > 0) {

        $key = $_POST['h'];

    } else {

        $error_msg_array[] = gettext("Invalid user key provided. Check email for correct link");
        $valid = false;
    }

    if (isset($_POST['pw']) && strlen(trim($_POST['pw'])) > 0) {

        $pw = $_POST['pw'];

    } else {

        $error_msg_array[] = gettext("You must enter a new password");
        $valid = false;
    }

    if (isset($_POST['cpw']) && strlen(trim($_POST['cpw'])) > 0) {

        $cpw = $_POST['cpw'];

    } else {

        $error_msg_array[] = gettext("You must confirm your new password");
        $valid = false;
    }

    if ($valid) {

        if (htmlentities_array($pw) != $pw) {

            $error_msg_array[] = gettext("Password must not contain HTML tags");
            $valid = false;
        }

        if (mb_strlen(trim($_POST['pw'])) < 6) {

            $error_msg_array[] = gettext("Password must be a minimum of 6 characters long");
            $valid = false;
        }

        if ($pw != $cpw) {

            $error_msg_array[] = gettext("Passwords do not match");
            $valid = false;
        }
    }

    if ($valid) {

        if (user_reset_password($uid, $pw, $key)) {

            html_draw_top(
                array(
                    'title' => gettext('Password changed'),
                    'class' => 'window_title'
                )
            );

            html_display_msg(gettext("Password changed"), gettext("Your password has been changed."), 'index.php', 'get', array('continue' => gettext("Continue")), array(), '_top');
            html_draw_bottom();
            exit;

        } else {

            $error_msg_array[] = gettext("Update failed");
            $valid = false;
        }
    }
}

if (isset($_REQUEST['u']) && isset($_REQUEST['h'])) {

    $uid = $_GET['u'];
    $key = $_GET['h'];

} else {

    html_draw_error(gettext("Required information not found"));
}

if (!$user = user_get_by_passhash($uid, $key)) {
    html_draw_error(gettext("Required information not found"));
}

html_draw_top(
    array(
        'title' => gettext('Change Password'),
        'class' => 'window_title'
    )
);

echo "<h1>", gettext("Change Password"), "</h1>";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '450', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "  <form accept-charset=\"utf-8\" name=\"forgot_pw\" action=\"change_pw.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("u", htmlentities_array($uid)), "\n";
echo "  ", form_input_hidden("h", htmlentities_array($key)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"450\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Change Password"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", gettext("New Password"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_password("pw", null, 37), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"right\">", gettext("Confirm Password"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_password("cpw", null, 37), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
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
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();