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
require_once 'lboot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'email.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

// Check that PM system is enabled
pm_enabled();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Prune old messages for the current user
pm_user_prune_folders();

// Get the Message ID (MID)
if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];

} else if (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

    $mid = $_POST['mid'];

} else {

    light_html_draw_error(gettext("No message specified for editing"));
}

// Get the message.
if (!($pm_message_array = pm_message_get($mid))) {
    pm_edit_refuse();
}

if (isset($pm_message_array['ATTACHMENTS'])) {
    $attachments = $pm_message_array['ATTACHMENTS'];
} else {
    $attachments = array();
}
$valid = true;

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {

        $t_subject = trim($_POST['t_subject']);

    } else {

        $error_msg_array[] = gettext("Enter a subject for the message");
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));

        if (mb_strlen($t_content) >= 65535) {

            $error_msg_array[] = sprintf(gettext("Message length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_content)));
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("Enter some content for the message");
        $valid = false;
    }

    if (isset($_POST['attachment']) && is_array($_POST['attachment'])) {
        $attachments = array_filter($_POST['attachment'], 'is_md5');
    } else {
        $attachments = array();
    }
}

if (!isset($t_content)) $t_content = "";

if ($valid && isset($_POST['preview'])) {

    $pm_message_array['CONTENT'] = $t_content;

    $pm_message_array['SUBJECT'] = $t_subject;

    $pm_message_array['FOLDER'] = PM_FOLDER_OUTBOX;

	$pm_message_array['ATTACHMENTS'] = $attachments;

} else if ($valid && isset($_POST['apply'])) {

    if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($_SESSION['UID'], ATTACHMENT_FILTER_BOTH, $attachments)) !== false) {

        foreach ($attachments_array as $attachment) {

            pm_add_attachment($mid, $attachment['aid']);
        }
    }

    if (pm_edit_message($mid, $t_subject, $t_content)) {

        header_redirect("lpm.php?webtag=$webtag&mid=$mid");
        exit;

    } else {

        $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
        $valid = false;
    }

} else if (isset($_POST['emots_toggle'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {
        $t_subject = trim($_POST['t_subject']);
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));
    }

    if (isset($_POST['to_radio']) && is_numeric($_POST['to_radio'])) {
        $to_radio = $_POST['to_radio'];
    } else {
        $to_radio = 1;
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    } else {
        $t_to_uid = 0;
    }

    $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

} else {

    if ($pm_message_array['TYPE'] != PM_OUTBOX) {
        pm_edit_refuse();
    }

    $parsed_message = new MessageTextParse(pm_get_content($mid));

    $t_content = $parsed_message->getMessage();

    $t_subject = $pm_message_array['SUBJECT'];
}

light_html_draw_top(sprintf("title=%s", gettext("Edit Message")));

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>\n";
    light_pm_display($pm_message_array, PM_FOLDER_OUTBOX, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";

echo "<div class=\"post\">\n";
echo "<h3>", gettext("Edit Message"), "</h3>\n";
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array, '720', 'left');
}

echo "<div class=\"post_thread_title\">", gettext("Subject"), ":", light_form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 30, 64), "</div>\n";
echo "<div class=\"post_to\">", gettext("To"), ":", word_filter_add_ob_tags(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']), true), "</div>\n";
echo "<div class=\"post_content\">", light_form_textarea("t_content", htmlentities_array(strip_paragraphs($t_content)), 10, 50, false, 'textarea'), "</div>\n";

echo "<div class=\"post_buttons\">";
echo light_form_submit("apply", gettext("Apply"));
echo light_form_submit("preview", gettext("Preview"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>";

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "<div class=\"attachments post_attachments\">", gettext('Attachments'), ":\n";
    echo "  ", attachments_form($_SESSION['UID'], $attachments, ATTACHMENT_FILTER_BOTH), "\n";
    echo "</div>\n";
}

echo "</div>";
echo "</div>";
echo "</form>\n";

light_html_draw_bottom();

?>