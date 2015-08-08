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

// Required includes
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

// Check that PM system is enabled
pm_enabled();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Prune old messages for the current user
pm_user_prune_folders($_SESSION['UID']);

$t_subject = null;
$t_content = null;

// Get the Message ID (MID)
if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];

} else {
    if (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

        $mid = $_POST['mid'];

    } else {

        light_html_draw_error(gettext("No message specified for editing"));
    }
}

// Get the message.
if (!($message_data = pm_message_get($mid))) {
    pm_edit_refuse();
}

if (isset($message_data['ATTACHMENTS'])) {
    $attachments = $message_data['ATTACHMENTS'];
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

            $error_msg_array[] = sprintf(
                gettext("Message length must be under 65,535 characters (currently: %s)"),
                format_number(mb_strlen($t_content))
            );

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

if ($valid && isset($_POST['preview'])) {

    $message_data['CONTENT'] = $t_content;

    $message_data['SUBJECT'] = $t_subject;

    $message_data['FOLDER'] = PM_FOLDER_OUTBOX;

    $message_data['ATTACHMENTS'] = $attachments;

} else {
    if ($valid && isset($_POST['apply'])) {

        if (sizeof($attachments) > 0 && ($attachments_array = attachments_get(
                $_SESSION['UID'],
                $attachments
            )) !== false
        ) {

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

    } else {
        if (isset($_POST['emots_toggle'])) {

            if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {
                $t_subject = trim($_POST['t_subject']);
            }

            if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
                $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));
            }

            if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
                $t_to_uid = $_POST['t_to_uid'];
            } else {
                $t_to_uid = 0;
            }

            $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;

            $user_prefs = array(
                'POST_PAGE' => $page_prefs
            );

            if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

                $error_msg_array[] = gettext(
                    "Some or all of your user account details could not be updated. Please try again later."
                );
                $valid = false;
            }

        } else {

            if (!isset($message_data['EDITABLE']) || ($message_data['EDITABLE'] == 0)) {
                pm_edit_refuse();
            }

            $parsed_message = new MessageTextParse(pm_get_content($mid));

            $t_content = $parsed_message->getMessage();

            $t_subject = $message_data['SUBJECT'];
        }
    }
}

light_html_draw_top(
    array(
        'title' => gettext('Edit Message'),
        'js' => array(
            'js/fineuploader.min.js'
        )
    )
);

light_navigation_bar(
    array(
        'back' => "lpm.php?webtag=$webtag&mid=$mid",
    )
);

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>\n";
    light_pm_display($message_data, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";

echo "<div class=\"post\">\n";
echo "<h3>", gettext("Edit Message"), "</h3>\n";
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<div class=\"post_thread_title\">", gettext("Subject"), ":", light_form_input_text(
    "t_subject",
    isset($t_subject) ? htmlentities_array($t_subject) : "",
    30,
    64
), "</div>\n";
echo "<div class=\"post_to\">", gettext("To"), ":\n";
echo "<div class=\"recipients\">\n";

if (isset($message_data['RECIPIENTS']) && sizeof($message_data['RECIPIENTS']) > 0) {

    foreach ($message_data['RECIPIENTS'] as $recipient) {
        echo word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "\n";
    }

} else {

    echo gettext('Unknown User');
}

echo "</div>\n";
echo "</div>\n";

echo "<div class=\"post_content\">", light_form_textarea(
    "t_content",
    htmlentities_array(strip_paragraphs($t_content)),
    10,
    50,
    null,
    'textarea'
), "</div>\n";

echo "<div class=\"post_buttons\">";
echo light_form_submit("apply", gettext("Apply"));
echo light_form_submit("preview", gettext("Preview"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>";

if (attachments_check_dir()) {

    echo "<div class=\"attachments post_attachments\">", gettext('Attachments'), ":\n";
    echo "  ", attachments_form($_SESSION['UID'], $attachments), "\n";
    echo "</div>\n";
}

echo "</div>";
echo "</div>";
echo "</form>\n";

light_html_draw_bottom();