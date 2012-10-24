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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'email.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'light.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'user_rel.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    light_html_message_type_error();
}

$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

$uid = session::get_value('UID');

$page_prefs = session::get_post_page_prefs();

if (($high_interest = session::get_value('MARK_AS_OF_INT')) === false) {
    $high_interest = "N";
}

$valid = true;

$new_thread = false;

$t_to_uid = 0;

if (($t_sig = user_get_sig($uid))) {
    $t_sig = fix_html($t_sig);
}

if (isset($_POST['t_newthread']) && (isset($_POST['post']) || isset($_POST['preview']))) {

    $new_thread = true;

    if (isset($_POST['t_threadtitle']) && strlen(trim($_POST['t_threadtitle'])) > 0) {

        $t_threadtitle = trim($_POST['t_threadtitle']);

    } else{

        $error_msg_array[] = gettext("You must enter a title for the thread!");
        $valid = false;
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $t_fid = $_POST['t_fid'];

        } else {

            $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
            $valid = false;
        }

    } else if ($valid) {

        $error_msg_array[] = gettext("Please select a folder");
        $valid = false;
    }

} else if (!isset($_POST['t_tid'])) {

    $valid = false;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else{
    $aid = md5(uniqid(mt_rand()));
}

if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
} else{
    $t_dedupe = time();
}

if (isset($_POST['post']) || isset($_POST['preview'])) {

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));

        if (attachments_embed_check($t_content)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = fix_html(emoticons_strip($_POST['t_sig']));

        if (attachments_embed_check($t_sig)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
            $valid = false;
        }
    }
}

if (isset($_POST['more'])) {

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));
    }
}

if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['t_newthread'])) {

        if (isset($_POST['t_threadtitle']) && strlen(trim($_POST['t_threadtitle'])) > 0) {
            $t_threadtitle = trim($_POST['t_threadtitle']);
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

            if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

                $t_fid = $_POST['t_fid'];

            } else {

                $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
                $valid = false;
            }
        }
    }

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {
        $t_content = nl2br(fix_html(emoticons_strip($_POST['t_content'])));
    }

    if (isset($_POST['t_sig'])) {
        $t_sig = fix_html(emoticons_strip($_POST['t_sig']));
    }

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;

    } else if (isset($_POST['sig_toggle'])) {

        $page_prefs = (double)$page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($uid, $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

if (!isset($t_content)) $t_content = "";

if (!isset($t_sig)) $t_sig = "";

if (mb_strlen($t_content) >= 65535) {

    $error_msg_array[] = sprintf(gettext("Message length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_content)));
    $valid = false;
}

if (mb_strlen($t_sig) >= 65535) {

    $error_msg_array[] = sprintf(gettext("Signature length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_sig)));
    $valid = false;
}

if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

    list($reply_to_tid, $reply_to_pid) = explode(".", $_GET['replyto']);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

    if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        light_html_email_confirmation_error();
        exit;
    }

    if (!session::check_perm(USER_PERM_POST_CREATE, $t_fid)) {
        light_html_draw_error(gettext("You cannot reply to posts in this folder"));
    }

    $new_thread = false;

} else if (isset($_POST['t_tid']) && isset($_POST['t_rpid'])) {

    $reply_to_tid = (is_numeric($_POST['t_tid']) ? $_POST['t_tid'] : 0);
    $reply_to_pid = (is_numeric($_POST['t_rpid']) ? $_POST['t_rpid'] : 0);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

    if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        light_html_email_confirmation_error();
        exit;
    }

    if (!session::check_perm(USER_PERM_POST_CREATE, $t_fid)) {
        light_html_draw_error(gettext("You cannot reply to posts in this folder"));
    }

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    $new_thread = false;

} else{

    $new_thread = true;

    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $t_fid = $_GET['fid'];
    } else if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
        $t_fid = $_POST['t_fid'];
    }

    if (isset($t_fid) && !folder_is_valid($t_fid)) {

        $error_msg_array[] = gettext("Invalid Folder ID. Check that a folder with this ID exists!");
        $valid = false;
    }

    if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        light_html_email_confirmation_error();
        exit;
    }

    if (isset($t_fid) && !session::check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot create new threads in this folder");
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }
}

if (isset($_POST['to_radio']) && strlen(trim($_POST['to_radio'])) > 0) {
    $to_radio = trim($_POST['to_radio']);
} else {
    $to_radio = '';
}

if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {

    $t_to_uid = $_POST['t_to_uid'];

} else if (isset($reply_to_tid) && isset($reply_to_pid)) {

    if (($message_user = message_get_user($reply_to_tid, $reply_to_pid))) {
        $t_to_uid = $message_user['UID'];
    }
}

$allow_html = true;

$allow_sig = true;

if (isset($t_fid) && !session::check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !session::check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if ($allow_html == false) {

    $t_content = htmlentities_array($t_content);
    $t_sig = htmlentities_array($t_sig);
}

if (!$new_thread) {

    if (!$reply_message = messages_get($reply_to_tid, $reply_to_pid)) {
        light_html_draw_error(gettext("That post does not exist in this thread!"));
    }

    if (!$thread_data = thread_get($reply_to_tid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {
        light_html_draw_error(gettext("Message not found. Check that it hasn't been deleted."));
    }
}

if ($valid && isset($_POST['post'])) {

    if (post_check_frequency()) {

        if (post_check_ddkey($t_dedupe)) {

            if ($new_thread) {

                $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle, 'N', 'N', false);
                $t_rpid = 0;

            } else{

                $t_tid  = (isset($_POST['t_tid']) && is_numeric($_POST['t_tid'])) ? $_POST['t_tid'] : 0;
                $t_rpid = (isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid'])) ? $_POST['t_rpid'] : 0;

                if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && (!session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid))) {
                    light_html_draw_error(gettext("This thread is closed, you cannot post in it!"));
                }
            }

            if ($t_tid > 0) {

                if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
                    $t_content.= "<div class=\"sig\">$t_sig</div>";
                }

                $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $t_to_uid, $t_content);

                if ($new_pid > -1) {

                    $user_rel = user_get_relationship($t_to_uid, $uid);

                    if ($high_interest == "Y") thread_set_high_interest($t_tid);

                    if (!session::check_perm(USER_PERM_WORMED, 0) && !($user_rel & USER_IGNORED_COMPLETELY)) {

                        $exclude_user_array = array(
                            $t_to_uid,
                            $uid
                        );

                        $thread_modified = (isset($thread_data['MODIFIED']) && is_numeric($thread_data['MODIFIED'])) ? $thread_data['MODIFIED'] : 0;

                        email_sendnotification($t_to_uid, $uid, $t_tid, $new_pid);

                        email_send_folder_subscription($uid, $t_fid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);

                        email_send_thread_subscription($uid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);
                    }

                    post_save_attachment_id($t_tid, $new_pid, $aid);
                }
            }

        } else {

            $new_pid = 0;

            $t_tid  = (isset($_POST['t_tid']) && is_numeric($_POST['t_tid'])) ? $_POST['t_tid'] : 0;
            $t_rpid = (isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid'])) ? $_POST['t_rpid'] : 0;
        }

        if ($new_pid > -1) {

            if ($new_thread && $t_tid > 0) {

                $uri = "lmessages.php?webtag=$webtag&msg=$t_tid.1";

            } else {

                if ($t_tid > 0 && $t_rpid > 0) {
                    $uri = "lmessages.php?webtag=$webtag&msg=$t_tid.$t_rpid";
                } else{
                    $uri = "lmessages.php?webtag=$webtag";
                }
            }

            header_redirect($uri);
            exit;

        } else{

            $error_msg_array[] = gettext("Error creating post! Please try again in a few minutes.");
        }

    } else {

        $error_msg_array[] = sprintf(gettext("You can only post once every %s seconds. Please try again later."), forum_get_setting('minimum_post_frequency', null, 0));
    }
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if (($new_thread && !$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "", FOLDER_ALLOW_NORMAL_THREAD, USER_PERM_THREAD_CREATE, "", "post_folder_dropdown"))) {
    light_html_draw_error(gettext("You cannot create new threads."));
}

if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
    light_html_draw_error(gettext("This thread is closed, you cannot post in it!"));
}

light_html_draw_top(sprintf("title=%s", gettext("Post message")));

echo "<h1>", gettext("Post message"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

if (!$new_thread && isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
    light_html_display_warning_msg(gettext("Warning: this thread is closed for posting to normal users."));
}

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>";

    if ($t_to_uid == 0) {

        $preview_message['TLOGON'] = gettext("ALL");
        $preview_message['TNICK'] = gettext("ALL");

    } else if ($t_to_uid > 0) {

        $preview_tuser = user_get($t_to_uid);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['TO_UID'] = $preview_tuser['UID'];

    }

    $preview_tuser = user_get($uid);
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    $preview_message['CONTENT'] = $t_content;

    if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    $preview_message['CREATED'] = time();

    light_message_display(0, $preview_message, 0, 0, 0, false, false, false, false, true);
}


if (!$new_thread) {

    if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0) {

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            echo "<h3>", gettext("Warning: this thread is closed for posting to normal users."), "</h3>\n";

        } else {

            echo "<h3>", gettext("This thread is closed, you cannot post in it!"), "</h3>\n";
            light_html_draw_bottom();
            exit;
        }
    }
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpost.php\" method=\"post\">\n";
echo form_input_hidden('webtag', htmlentities_array($webtag));
echo form_input_hidden('t_dedupe', htmlentities_array($t_dedupe));

echo "<div class=\"post\">\n";

if (!isset($t_threadtitle)) {
    $t_threadtitle = "";
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if ($new_thread) {

    echo form_input_hidden("t_newthread", "Y");

    echo "<h3>", gettext("Create new thread"), "</h3>\n";
    echo "<div class=\"post_inner\">\n";
    echo "<div class=\"post_folder\">", gettext("Select folder"), ":", light_folder_draw_dropdown($t_fid, "t_fid"), "</div>";
    echo "<div class=\"post_thread_title\">", gettext("Thread title"), ":", light_form_input_text("t_threadtitle", htmlentities_array($t_threadtitle), 30, 64), "</div>";

} else {

    if (!$reply_message = messages_get($reply_to_tid, $reply_to_pid)) {

        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0) {

        light_html_display_error_msg(gettext("Message not found. Check that it hasn't been deleted."));
        light_html_draw_bottom();
        exit;

    } else {

        echo "<h3>", gettext("Post Reply"), ": ", word_filter_add_ob_tags(thread_get_title($reply_to_tid), true), "</h3>\n";
        echo "<div class=\"post_inner\">\n";
        echo form_input_hidden("t_tid", htmlentities_array($reply_to_tid));
        echo form_input_hidden("t_rpid", htmlentities_array($reply_to_pid))."\n";
    }
}

echo "<div class=\"post_to\">", gettext("To"), ":", post_draw_to_dropdown($t_to_uid), "</div>";
echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("t_content", htmlentities_array(strip_paragraphs($t_content)), 10, 50, false, 'textarea'), "</div>";

if ($allow_sig == true) {
    echo form_input_hidden("t_sig", htmlentities_array($t_sig));
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("post", gettext("Post"));
echo light_form_submit("preview", gettext("Preview"));

if (isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid']) ) {

    echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg={$_POST['t_tid']}.{$_POST['t_rpid']}\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";

} else if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

    echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg={$_GET['replyto']}\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";

} else {

    echo "<a href=\"lmessages.php?webtag=$webtag\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
}

echo "</div>";

echo "</div>";
echo "</div>";
echo "</form>\n";

if (!$new_thread && $reply_to_pid > 0) {

    echo "<h3>", gettext("In reply to"), ":</h3>\n";

    if (($thread_data['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        light_poll_display($reply_to_tid, $thread_data['LENGTH'], $thread_data['FID'], $thread_data['CLOSED'], false, true);

    } else {

        light_message_display($reply_to_tid, $reply_message, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], false, false, false, false, true);
    }
}

light_html_draw_bottom();

?>