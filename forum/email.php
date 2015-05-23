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
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Forum name
$forum_name = forum_get_setting('forum_name', 'strlen', 'A Beehive Forum');

// Array to hold error messages
$error_msg_array = array();

$to_uid = null;

// User UID to send email to.
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $to_uid = $_GET['uid'];

} else if (isset($_POST['to_uid']) && is_numeric($_POST['to_uid'])) {

    $to_uid = $_POST['to_uid'];

} else {

    html_draw_error(gettext("No user specified for emailing."));
}

$to_user = user_get($to_uid);

$from_user = user_get($_SESSION['UID']);

$subject = null;
$message = null;

if (isset($_POST['send'])) {

    $valid = true;

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {

        $subject = trim($_POST['t_subject']);

    } else {

        $error_msg_array[] = gettext("Enter a subject for the message");
        $valid = false;
    }

    if (isset($_POST['t_message']) && strlen(trim($_POST['t_message'])) > 0) {

        $message = trim($_POST['t_message']);

    } else {

        $error_msg_array[] = gettext("Enter some content for the message");
        $valid = false;
    }

    if (isset($_POST['t_use_email_addr']) && $_POST['t_use_email_addr'] == 'Y') {
        $use_email_addr = true;
    } else {
        $use_email_addr = false;
    }

    if (!user_allow_email($to_user['UID'])) {

        $error_msg_array[] = sprintf(gettext("%s has opted out of email contact"), word_filter_add_ob_tags(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), true));
        $valid = false;
    }

    if (!email_address_valid($to_user['EMAIL'])) {

        $error_msg_array[] = sprintf(gettext("%s has an invalid email address"), word_filter_add_ob_tags(format_user_name($to_user['LOGON'], $to_user['NICKNAME']), true));
        $valid = false;
    }

    if ($valid) {

        if (email_send_message_to_user($to_uid, $_SESSION['UID'], $subject, $message, $use_email_addr)) {

            html_draw_top(
                array(
                    'title' => gettext('Email result'),
                    'pm_popup_disabled' => true,
                    'class' => 'window_title'
                )
            );
            html_display_msg(gettext("Message sent"), gettext("Message sent successfully."), 'email.php', 'post', array('close' => gettext("Close")), array('to_uid' => $to_uid), '_self', 'center');
            html_draw_bottom();
            exit;

        } else {

            html_draw_error(gettext("Mail system failure. Message not sent."));
            exit;
        }
    }
}

html_draw_top(
    array(
        'title' => sprintf(
            gettext('Send Email to %s'),
            htmlentities_array(format_user_name($to_user['LOGON'], $to_user['NICKNAME']))
        ),
        'pm_popup_disabled' => true,
        'class' => 'window_title'
    )
);

echo "<h1>", sprintf(gettext("Send Email to %s"), htmlentities_array(format_user_name($to_user['LOGON'], $to_user['NICKNAME']))), "</h1>\n";
echo "<br />";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_email\" action=\"email.php\" method=\"post\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("to_uid", htmlentities_array($to_uid)), "\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '480', 'center');
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"480\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"480\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", sprintf(gettext("Send Email to %s"), htmlentities_array(format_user_name($to_user['LOGON'], $to_user['NICKNAME']))), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"25%\">", gettext("From"), ":</td>\n";
echo "                        <td align=\"left\">", word_filter_add_ob_tags($from_user['NICKNAME'], true), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Subject"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("t_subject", (isset($subject) ? htmlentities_array($subject) : ''), 54, 128), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\">", gettext("Message"), ":</td>\n";
echo "                        <td align=\"left\">", form_textarea("t_message", (isset($message) ? htmlentities_array($message) : ''), 12, 51), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_checkbox('t_use_email_addr', 'Y', gettext("Use my real email address to send this message"), (isset($use_email_addr) ? $use_email_addr : (isset($_SESSION['USE_EMAIL_ADDR']) && $_SESSION['USE_EMAIL_ADDR'] == 'Y'))), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("send", gettext("Send")), "&nbsp;", form_button("close_popup", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();