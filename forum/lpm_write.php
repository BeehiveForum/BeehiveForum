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
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

// Get the user's UID
$uid = session::get_value('UID');

// Check that PM system is enabled
pm_enabled();

// Get the user's post page preferences.
$page_prefs = session::get_post_page_prefs();

// Prune old messages for the current user
pm_user_prune_folders();

// Get the Message ID (MID) if any.
if (isset($_GET['replyto']) && is_numeric($_GET['replyto'])) {

    $t_reply_mid = $_GET['replyto'];

} else if (isset($_POST['replyto']) && is_numeric($_POST['replyto'])) {

    $t_reply_mid = $_POST['replyto'];

} else if (isset($_GET['fwdmsg']) && is_numeric($_GET['fwdmsg'])) {

    $t_forward_mid = $_GET['fwdmsg'];

} else if (isset($_POST['fwdmsg']) && is_numeric($_POST['fwdmsg'])) {

    $t_forward_mid = $_POST['fwdmsg'];

} else if (isset($_GET['editmsg']) && is_numeric($_GET['editmsg'])) {

    $t_edit_mid = $_GET['editmsg'];

} else if (isset($_POST['editmsg']) && is_numeric($_POST['editmsg'])) {

    $t_edit_mid = $_POST['editmsg'];
}

// Get the tid.pid if any.
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (is_numeric($tid) && is_numeric($pid)) {

        if (($thread_data = thread_get($tid))) {

            $thread_title = trim($thread_data['TITLE']);
            $thread_index = "[$tid.$pid]";

            if (mb_strlen($thread_title) > (55 - mb_strlen($thread_index))) {
                $thread_title = mb_substr($thread_title, 0, (55 - mb_strlen($thread_index))). '...';
            }

            $t_subject = "RE:$thread_title $thread_index";
        }
    }
}

// Default Folder
$folder = PM_FOLDER_INBOX;

if (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    } else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    } else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }

} else if (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    } else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    } else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }
}

// Assume everything is correct (form input, etc)
$valid = true;

// Array to hold error messages
$error_msg_array = array();

if (isset($_POST['emots_toggle'])) {

    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {
        $t_subject = trim($_POST['t_subject']);
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));
    }

    if (isset($_POST['to_radio']) && strlen(trim($_POST['to_radio'])) > 0) {
        $to_radio = trim($_POST['to_radio']);
    } else {
        $to_radio = '';
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    } else {
        $t_to_uid = 0;
    }

    if (isset($_POST['t_to_uid_others']) && strlen(trim($_POST['t_to_uid_others'])) > 0) {
        $t_to_uid_others = trim($_POST['t_to_uid_others']);
    }

    $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($uid, $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

// Submit handling code
if (isset($_POST['send']) || isset($_POST['preview'])) {

    // User clicked the send or preview button - check the data that was submitted
    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {

        $t_subject = trim($_POST['t_subject']);

    } else {

        $error_msg_array[] = gettext("Enter a subject for the message");
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));

    } else {

        $error_msg_array[] = gettext("Enter some content for the message");
        $valid = false;
    }

    if (isset($_POST['to_radio']) && strlen(trim($_POST['to_radio'])) > 0) {
        $to_radio = trim($_POST['to_radio']);
    } else {
        $to_radio = '';
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    } else {
        $t_to_uid = 0;
    }

    if ($to_radio == 'friends' && $t_to_uid == 0) {

        $error_msg_array[] = gettext("You must specify at least one recipient.");
        $valid = false;
    }

    if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

        if (($pm_data = pm_message_get($t_reply_mid))) {

            $pm_data['CONTENT'] = pm_get_content($t_reply_mid);

        } else {

            light_pm_error_refuse();
        }
    }

    if (isset($_POST['t_to_uid_others']) && strlen(trim($_POST['t_to_uid_others'])) > 0) {

        $t_recipient_array = preg_split("/[;|,]/u", trim($_POST['t_to_uid_others']));

        $t_new_recipient_array['TO_UID'] = array();
        $t_new_recipient_array['LOGON']  = array();
        $t_new_recipient_array['NICK']   = array();

        foreach ($t_recipient_array as $key => $t_recipient) {

            $to_logon = trim($t_recipient);

            if (($to_user = user_get_by_logon($to_logon))) {

                $peer_relationship = user_get_peer_relationship($to_user['UID'], $uid);

                if (!in_array($to_user['UID'], $t_new_recipient_array['TO_UID'])) {

                    $t_new_recipient_array['TO_UID'][] = $to_user['UID'];
                    $t_new_recipient_array['LOGON'][]  = $to_user['LOGON'];
                    $t_new_recipient_array['NICK'][]   = $to_user['NICKNAME'];
                }

                if ($to_radio == 'others') {

                    if ((($peer_relationship ^ USER_BLOCK_PM) && user_allow_pm($to_user['UID'])) || session::check_perm(USER_PERM_FOLDER_MODERATE, 0)) {

                        pm_user_prune_folders();

                        if (pm_get_free_space($uid) < sizeof($t_new_recipient_array['TO_UID'])) {

                            $error_msg_array[] = gettext("You do not have enough free space to send this message.");
                            $valid = false;
                        }

                    } else {

                        $error_msg_array[] = sprintf(gettext("%s has opted out of receiving personal messages"), $to_logon);
                        $valid = false;
                    }
                }

            } else {

                $error_msg_array[] = sprintf(gettext("User %s not found"), $to_logon);
                $valid = false;
            }
        }

        $t_to_uid_others = implode('; ', $t_new_recipient_array['LOGON']);

        if ($to_radio == 'others') {

            if ($valid && sizeof($t_new_recipient_array['TO_UID']) > 10) {

                $error_msg_array[] = gettext("There is a limit of 10 recipients per message. Please amend your recipient list.");
                $valid = false;
            }

            if ($valid && sizeof($t_new_recipient_array['TO_UID']) < 1) {

                $error_msg_array[] = gettext("You must specify at least one recipient.");
                $valid = false;
            }
        }

    } else if ($to_radio == 'others') {

        $error_msg_array[] = gettext("You must specify at least one recipient.");
        $valid = false;
    }

} else if (isset($_POST['save'])) {

    // User click the save button - Check the data that was submitted.
    if (isset($_POST['t_subject']) && strlen(trim($_POST['t_subject'])) > 0) {

        $t_subject = trim($_POST['t_subject']);

    } else {

        $t_subject = "";
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));

    } else {

        $t_content = "";
    }

    if (isset($_POST['to_radio']) && strlen(trim($_POST['to_radio'])) > 0) {
        $to_radio = trim($_POST['to_radio']);
    } else {
        $to_radio = '';
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    } else {
        $t_to_uid = 0;
    }

    if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
        $aid = $_POST['aid'];
    } else{
        $aid = md5(uniqid(mt_rand()));
    }

    if (isset($_POST['t_to_uid_others']) && strlen(trim($_POST['t_to_uid_others'])) > 0) {

        $t_recipient_array = preg_split("/[;|,]/u", trim($_POST['t_to_uid_others']));

        if (sizeof($t_recipient_array) > 10) {

            $error_msg_array[] = gettext("There is a limit of 10 recipients per message. Please amend your recipient list.");
            $valid = false;
        }

        $t_to_uid_others = implode(';', $t_recipient_array);

    } else {

        $t_to_uid_others = "";
    }

} else if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    if (!$t_to_uid_others = pm_get_user($t_reply_mid)) $t_to_uid_others = "";

    if (($pm_data = pm_message_get($t_reply_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_reply_mid);

        $t_subject = preg_replace('/^(RE:)?/iu', 'RE:', $pm_data['SUBJECT']);

    } else {

        light_pm_error_refuse();
    }

} else if (isset($t_forward_mid) && is_numeric($t_forward_mid) && $t_forward_mid > 0) {

    if (($pm_data = pm_message_get($t_forward_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_forward_mid);

        $t_subject = preg_replace('/^(FWD:)?/iu', 'FWD:', $pm_data['SUBJECT']);

    } else {

        light_pm_error_refuse();
    }

} else if (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

    if (($pm_data = pm_message_get($t_edit_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_edit_mid);

        $t_subject = $pm_data['SUBJECT'];

        $parsed_message = new MessageTextParse($pm_data['CONTENT']);

        $t_content = $parsed_message->getMessage();

        $t_subject = $pm_data['SUBJECT'];

        $t_to_uid = $pm_data['TO_UID'];

        $t_to_uid_others = $pm_data['RECIPIENTS'];

        if (strlen($t_to_uid_others) > 0) {
            $to_radio = 'others';
        } else if ($t_to_uid > 0) {
            $to_radio = 'friends';
        }

        $aid = $pm_data['AID'];

    } else {

        light_pm_error_refuse();
    }
}

if (!isset($t_content)) $t_content = "";

// Check the message length.
if (mb_strlen($t_content) >= 65535) {

    $error_msg_array[] = sprintf(gettext("Message length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_content)));
    $valid = false;
}

// Attachment Unique ID
if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else if (!isset($aid)) {
    $aid = md5(uniqid(mt_rand()));
}

// De-dupe key
if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
} else{
    $t_dedupe = time();
}

// Send the PM
if ($valid && isset($_POST['send'])) {

    if (post_check_ddkey($t_dedupe)) {

        if (isset($to_radio) && $to_radio == 'friends') {

            if (($new_mid = pm_send_message($t_to_uid, $uid, $t_subject, $t_content, $aid))) {

                email_send_pm_notification($t_to_uid, $new_mid, $uid);

            } else {

                $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
                $valid = false;
            }

            if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {
                pm_delete_message($t_edit_mid);
            }

        } else {

            foreach ($t_new_recipient_array['TO_UID'] as $t_to_uid) {

                if (($new_mid = pm_send_message($t_to_uid, $uid, $t_subject, $t_content, $aid))) {

                    email_send_pm_notification($t_to_uid, $new_mid, $uid);

                } else {

                    $error_msg_array[] = gettext("Error creating PM! Please try again in a few minutes");
                    $valid = false;
                }
            }

            if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {
                pm_delete_message($t_edit_mid);
            }
        }
    }

    if ($valid) {

        header_redirect("lpm.php?webtag=$webtag&message_sent=true");
        exit;
    }

} else if ($valid && isset($_POST['save'])) {

    if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {

        if (pm_update_saved_message($t_edit_mid, $t_subject, $t_content, $t_to_uid, $t_to_uid_others)) {

            header_redirect("lpm.php?webtag=$webtag&mid=$t_edit_mid&message_saved=true");
            exit;

        } else {

            $error_msg_array[] = gettext("Could not save message. Make sure you have enough available free space.");
            $valid = false;
        }

    } else {

        if (($saved_mid = pm_save_message($t_subject, $t_content, $t_to_uid, $t_to_uid_others))) {

            pm_save_attachment_id($saved_mid, $aid);

            header_redirect("lpm.php?webtag=$webtag&mid=$saved_mid&message_saved=true");
            exit;

        } else {

            $error_msg_array[] = gettext("Could not save message. Make sure you have enough available free space.");
            $valid = false;
        }
    }
}

light_html_draw_top(sprintf("title=%s", gettext("Send New PM")), "robots=noindex,nofollow");

// preview message
if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>\n";

    $pm_preview_array['TLOGON'] = $t_new_recipient_array['LOGON'];
    $pm_preview_array['TNICK']  = $t_new_recipient_array['NICK'];
    $pm_preview_array['TO_UID'] = $t_new_recipient_array['TO_UID'];

    $preview_fuser = user_get($uid);

    $pm_preview_array['FLOGON'] = $preview_fuser['LOGON'];
    $pm_preview_array['FNICK']  = $preview_fuser['NICKNAME'];
    $pm_preview_array['FROM_UID'] = $preview_fuser['UID'];

    $pm_preview_array['SUBJECT'] = $t_subject;
    $pm_preview_array['CREATED'] = time();
    $pm_preview_array['AID'] = $aid;

    $pm_preview_array['CONTENT'] = $t_content;

    light_pm_display($pm_preview_array, PM_FOLDER_OUTBOX, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpm_write.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('folder', htmlentities_array($folder)), "\n";
echo "  ", form_input_hidden("t_dedupe", htmlentities_array($t_dedupe));

echo "<div class=\"post\">\n";
echo "<h3>", gettext("Send New PM"), "</h3>\n";
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<div class=\"post_thread_title\">", gettext("Subject"), ":", light_form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 30, 64), "</div>\n";
echo "<div class=\"post_to\">", gettext("To"), ":", light_form_input_text("t_to_uid_others", isset($t_to_uid_others) ? htmlentities_array($t_to_uid_others) : "", 0, 0), "</div>\n";
echo "<div class=\"post_content\">", light_form_textarea("t_content", htmlentities_array(strip_paragraphs($t_content)), 10, 50, false, 'textarea'), "</div>\n";

echo "<div class=\"post_buttons\">";
echo light_form_submit("send", gettext("Send"));
echo light_form_submit("save", gettext("Save"));
echo light_form_submit("preview", gettext("Preview"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>";

if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    echo form_input_hidden("replyto", htmlentities_array($t_reply_mid)), "\n";

} else if (isset($t_forward_mid) && is_numeric($t_forward_mid) && $t_forward_mid > 0) {

    echo form_input_hidden("fwdmsg", htmlentities_array($t_forward_mid)), "\n";

} else if (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

    echo form_input_hidden("editmsg", htmlentities_array($t_edit_mid)), "\n";
}

echo "</div>";
echo "</div>";
echo "</form>\n";

if (isset($pm_data) && is_array($pm_data) && isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    echo "<h3>", gettext("In reply to"), ":</h3>\n";
    light_pm_display($pm_data, PM_FOLDER_INBOX, true);
}

light_html_draw_bottom();

?>