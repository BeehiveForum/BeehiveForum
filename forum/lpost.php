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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'email.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    light_html_message_type_error();
}

$show_sigs = session::show_sigs();

$page_prefs = session::get_post_page_prefs();

$high_interest = (isset($_SESSION['MARK_AS_OF_INT']) && $_SESSION['MARK_AS_OF_INT'] == 'Y') ? 'Y' : 'N';

$valid = true;

$new_thread = false;

$to_logon_array = array();

$reply_to_pid = null;

$reply_message = null;

$fid = null;

$threadtitle = null;

if (($sig = user_get_sig($_SESSION['UID'])) !== false) {
    $sig = fix_html($sig);
}

if (isset($_POST['newthread']) && (isset($_POST['post']) || isset($_POST['preview']))) {

    $new_thread = true;

    if (isset($_POST['threadtitle']) && strlen(trim($_POST['threadtitle'])) > 0) {

        $threadtitle = trim($_POST['threadtitle']);
    } else {

        $error_msg_array[] = gettext("You must enter a title for the thread!");
        $valid = false;
    }

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

        if (folder_thread_type_allowed($_POST['fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $fid = $_POST['fid'];
        } else {

            $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
            $valid = false;
        }
    } else {
        if ($valid) {

            $error_msg_array[] = gettext("Please select a folder");
            $valid = false;
        }
    }
} else {
    if (!isset($_POST['reply_to'])) {

        $valid = false;
    }
}

if (isset($_POST['attachment']) && is_array($_POST['attachment'])) {
    $attachments = array_filter($_POST['attachment'], 'is_md5');
} else {
    $attachments = array();
}
if (isset($_POST['dedupe']) && is_numeric($_POST['dedupe'])) {
    $dedupe = $_POST['dedupe'];
} else {
    $dedupe = time();
}

if (isset($_POST['post']) || isset($_POST['preview'])) {

    if (isset($_POST['content']) && strlen(trim($_POST['content'])) > 0) {

        $content = nl2br(fix_html(emoticons_strip($_POST['content'])));

        if (attachments_embed_check($content)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
            $valid = false;
        }
    } else {

        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }
}

if (isset($_POST['more'])) {

    if (isset($_POST['content']) && strlen(trim($_POST['content'])) > 0) {
        $content = nl2br(fix_html(emoticons_strip($_POST['content'])));
    }
}

if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['newthread'])) {

        if (isset($_POST['threadtitle']) && strlen(trim($_POST['threadtitle'])) > 0) {
            $threadtitle = trim($_POST['threadtitle']);
        }

        if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

            if (folder_thread_type_allowed($_POST['fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

                $fid = $_POST['fid'];
            } else {

                $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
                $valid = false;
            }
        }
    }

    if (isset($_POST['content']) && strlen(trim($_POST['content'])) > 0) {
        $content = nl2br(fix_html(emoticons_strip($_POST['content'])));
    }

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;
    } else {
        if (isset($_POST['sig_toggle'])) {

            $page_prefs = (double)$page_prefs ^ POST_SIGNATURE_DISPLAY;
        }
    }

    $user_prefs = array('POST_PAGE' => $page_prefs);

    if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

if (!isset($content)) {
    $content = "";
}

if (isset($_GET['reply_to']) && validate_msg($_GET['reply_to'])) {

    list($tid, $reply_to_pid) = explode(".", $_GET['reply_to']);

    if (isset($_GET['return_msg']) && validate_msg($_GET['return_msg'])) {
        $return_msg = $_GET['return_msg'];
    } else {
        $return_msg = $_GET['reply_to'];
    }

    if (!($fid = thread_get_folder_fid($tid))) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

    if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        light_html_email_confirmation_error();
        exit;
    }

    if (!session::check_perm(USER_PERM_POST_CREATE, $fid)) {
        light_html_draw_error(gettext("You cannot reply to posts in this folder"));
    }

    $new_thread = false;
} else {
    if (isset($_POST['reply_to']) && validate_msg($_POST['reply_to'])) {

        list($tid, $reply_to_pid) = explode(".", $_POST['reply_to']);

        if (isset($_POST['return_msg']) && validate_msg($_POST['return_msg'])) {
            $return_msg = $_POST['return_msg'];
        } else {
            $return_msg = $_POST['reply_to'];
        }

        if (!($fid = thread_get_folder_fid($tid))) {
            light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
        }

        if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

            light_html_email_confirmation_error();
            exit;
        }

        if (!session::check_perm(USER_PERM_POST_CREATE, $fid)) {
            light_html_draw_error(gettext("You cannot reply to posts in this folder"));
        }

        if (sizeof($attachments) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

            $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
            $valid = false;
        }

        if (sizeof($attachments) > 0 && !attachments_check_post_space($_SESSION['UID'], $attachments)) {

            $max_post_attachment_space = forum_get_setting('attachments_max_post_space', 'is_numeric', 1048576);
            $error_msg_array[] = gettext(sprintf("You have too many files attached to this post. Maximum attachment space per post is %s", format_file_size($max_post_attachment_space)));
            $valid = false;
        }

        $new_thread = false;
    } else {

        $new_thread = true;

        if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
            $fid = $_GET['fid'];
        } else {
            if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
                $fid = $_POST['fid'];
            }
        }

        if (isset($fid) && !folder_is_valid($fid)) {

            $error_msg_array[] = gettext("Invalid Folder ID. Check that a folder with this ID exists!");
            $valid = false;
        }

        if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

            light_html_email_confirmation_error();
            exit;
        }

        if (isset($fid) && !session::check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $fid)) {

            $error_msg_array[] = gettext("You cannot create new threads in this folder");
            $valid = false;
        }

        if (isset($fid) && sizeof($attachments) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

            $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
            $valid = false;
        }

        if (sizeof($attachments) > 0 && !attachments_check_post_space($_SESSION['UID'], $attachments)) {

            $error_msg_array[] = gettext(sprintf("You have too many files attached to this post. Maximum attachment space per post is %s", format_file_size($max_post_attachment_space)));
            $valid = false;
        }
    }
}

if (!$new_thread) {

    if (!($reply_message = messages_get($tid, $reply_to_pid))) {
        light_html_draw_error(gettext("That post does not exist in this thread!"));
    }

    if (!($thread_data = thread_get($tid))) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

    $reply_message['CONTENT'] = message_get_content($tid, $reply_to_pid);

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {
        light_html_draw_error(gettext("Message not found. Check that it hasn't been deleted."));
    }
}

if (isset($_POST['to_logon'])) {

    if (strlen(trim($_POST['to_logon'])) > 0) {

        $to_logon_array = preg_split('/,\s*/u', trim($_POST['to_logon'], ', '));

        $to_logon_array = array_filter(array_map('trim', $to_logon_array), 'strlen');

        foreach ($to_logon_array as $key => $recipient) {

            $to_logon = trim($recipient);

            unset($to_logon_array[$key]);

            if (($to_user = user_get_by_logon($to_logon)) !== false) {

                $to_logon_array[$to_user['UID']] = array('UID' => $to_user['UID'], 'LOGON' => $to_user['LOGON'], 'NICKNAME' => $to_user['NICKNAME']);
            } else {

                $error_msg_array[] = sprintf(gettext("User %s not found"), htmlentities_array($to_logon));
                $valid = false;
            }
        }

        $to_logon = implode(', ', array_map('user_get_logon_callback', $to_logon_array));

        if ($valid && sizeof($to_logon_array) > 10) {

            $error_msg_array[] = gettext("There is a limit of 10 recipients per message. Please amend your recipient list.");
            $valid = false;
        }
    }
} else {
    if (isset($tid) && isset($reply_to_pid) && ($reply_to_pid > 0)) {

        $to_logon = $reply_message['FROM_LOGON'];
    }
}

$allow_html = true;

$allow_sig = true;

if (isset($fid) && !session::check_perm(USER_PERM_HTML_POSTING, $fid)) {
    $allow_html = false;
}

if (isset($fid) && !session::check_perm(USER_PERM_SIGNATURE, $fid)) {
    $allow_sig = false;
}

if ($allow_html == false) {

    $content = htmlentities_array($content);
    $sig = htmlentities_array($sig);
}

if ((mb_strlen($content) + mb_strlen($sig)) >= 65535) {

    $error_msg_array[] = sprintf(gettext("Combined Message and signature length must be less than 65,535 characters (currently: %s)"), format_number(mb_strlen($content) + mb_strlen($sig)));

    $valid = false;
}

if ($valid && isset($_POST['post'])) {

    if (post_check_frequency()) {

        if (post_check_ddkey($dedupe)) {

            if ($new_thread) {

                $tid = post_create_thread($fid, $_SESSION['UID'], $threadtitle, 'N', 'N', false);
                $reply_to_pid = 0;
            } else {

                if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && (!session::check_perm(USER_PERM_FOLDER_MODERATE, $fid))) {
                    light_html_draw_error(gettext("This thread is closed, you cannot post in it!"));
                }
            }

            if (isset($tid) && is_numeric($tid)) {

                if ($allow_sig == true && strlen(trim($sig)) > 0) {
                    $content .= "<div class=\"sig\">$sig</div>";
                }

                if (($new_pid = post_create($fid, $tid, $reply_to_pid, $_SESSION['UID'], $to_logon_array, $content)) !== false) {

                    if ($high_interest == "Y") {
                        thread_set_high_interest($tid);
                    }

                    email_send_notification($tid, $new_pid);

                    email_send_thread_subscription($tid, $new_pid);

                    email_send_folder_subscription($fid, $tid, $new_pid);

                    if (perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $_SESSION['UID']) && !perm_is_moderator($_SESSION['UID'], $fid)) {
                        admin_send_post_approval_notification($fid);
                    }

                    if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($_SESSION['UID'], $attachments)) !== false) {

                        foreach ($attachments_array as $attachment) {

                            post_add_attachment($tid, $new_pid, $attachment['aid']);
                        }
                    }
                }
            }
        }

        if ($new_thread && isset($tid) && is_numeric($tid)) {

            $uri = "lmessages.php?webtag=$webtag&msg=$tid.1";
        } else {

            if (isset($return_msg)) {

                $uri = "lmessages.php?webtag=$webtag&msg=$return_msg";
            } else {
                if (isset($tid) && is_numeric($tid) && isset($reply_to_pid) && is_numeric($reply_to_pid)) {

                    $uri = "lmessages.php?webtag=$webtag&msg=$tid.$reply_to_pid";
                } else {

                    $uri = "lmessages.php?webtag=$webtag";
                }
            }

            if (isset($tid) && is_numeric($tid) && isset($new_pid) && is_numeric($new_pid)) {
                $uri .= "&post_success=$tid.$new_pid";
            }
        }

        header_redirect($uri);
        exit;
    } else {

        $error_msg_array[] = sprintf(gettext("You can only post once every %s seconds. Please try again later."), forum_get_setting('minimum_post_frequency', 'is_numeric', 0));
    }
}

if (!isset($fid)) {
    $fid = 1;
}

if (($new_thread && !($folder_dropdown = folder_draw_dropdown($fid, "fid", "", FOLDER_ALLOW_NORMAL_THREAD, USER_PERM_THREAD_CREATE, "", "post_folder_dropdown")))) {
    light_html_draw_error(gettext("You cannot create new threads."));
}

if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {
    light_html_draw_error(gettext("This thread is closed, you cannot post in it!"));
}

if (isset($return_msg)) {
    $back = "lmessages.php?webtag=$webtag&msg=$return_msg";
} else {
    if (isset($tid) && is_numeric($tid) && isset($reply_to_pid) && is_numeric($reply_to_pid)) {
        $back = "lmessages.php?webtag=$webtag&msg=$tid.$reply_to_pid";
    } else {
        $back = "lthread_list.php?webtag=$webtag";
    }
}

light_html_draw_top(
    array(
        'title' => gettext('Post message'),
        'js' => array(
            'js/fineuploader.min.js',
            'js/attachments.js'
        )
    )
);

light_navigation_bar(
    array(
        'back' => $back,
    )
);

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

if (!$new_thread && isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {
    light_html_display_warning_msg(gettext("Warning: this thread is closed for posting to normal users."));
}

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>";

    $preview_message['RECIPIENTS'] = $to_logon_array;

    $preview_fuser = user_get($_SESSION['UID']);

    $preview_message['FROM_LOGON'] = $preview_fuser['LOGON'];
    $preview_message['FROM_NICKNAME'] = $preview_fuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_fuser['UID'];

    $preview_message['CONTENT'] = $content;

    if ($allow_sig == true && strlen(trim($sig)) > 0) {
        $preview_message['CONTENT'] = $preview_message['CONTENT'] . "<div class=\"sig\">" . $sig . "</div>";
    }

    $preview_message['CREATED'] = time();
    $preview_message['ATTACHMENTS'] = $attachments;

    light_message_display(0, $preview_message, 0, 0, 0, false, false, false, false, true);
}

if (!$new_thread) {

    if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && (!session::check_perm(USER_PERM_FOLDER_MODERATE, $fid))) {
        light_html_display_warning_msg(gettext("This thread is closed, you cannot post in it!"));
    }
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpost.php\" method=\"post\">\n";
echo form_input_hidden('webtag', htmlentities_array($webtag));
echo form_input_hidden('dedupe', htmlentities_array($dedupe));

echo "<div class=\"post\">\n";

if (!isset($threadtitle)) {
    $threadtitle = "";
}

if (!isset($fid)) {
    $fid = 1;
}

if ($new_thread) {

    echo form_input_hidden("newthread", "Y");

    echo "<h3>", gettext("Create new thread"), "</h3>\n";
    echo "<div class=\"post_inner\">\n";
    echo "<div class=\"post_folder\">", gettext("Select folder"), ":", light_folder_draw_dropdown($fid, "fid"), "</div>";
    echo "<div class=\"post_thread_title\">", gettext("Thread title"), ":", light_form_input_text("threadtitle", htmlentities_array($threadtitle), 30, 64), "</div>";
} else {

    if (!($reply_message = messages_get($tid, $reply_to_pid))) {

        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($tid, $reply_to_pid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0) {

        light_html_display_error_msg(gettext("Message not found. Check that it hasn't been deleted."));
        light_html_draw_bottom();
        exit;
    } else {

        echo "<h3>", gettext("Post Reply"), ": ", word_filter_add_ob_tags(thread_get_title($tid), true), "</h3>\n";
        echo "<div class=\"post_inner\">\n";
        echo form_input_hidden("reply_to", htmlentities_array("$tid.$reply_to_pid"));
        echo form_input_hidden('return_msg', htmlentities_array($return_msg)), "\n";
    }
}

echo "<div class=\"post_to\">", gettext("To"), ":", light_form_input_text("to_logon", isset($to_logon) ? htmlentities_array($to_logon) : "", 30, null, null, gettext("Leave blank for all")), "</div>";
echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("content", htmlentities_array(strip_paragraphs($content)), 10, 50, null, 'textarea'), "</div>";
echo "<div class=\"post_buttons\">";
echo light_form_submit("post", gettext("Post"));
echo light_form_submit("preview", gettext("Preview"));

if (isset($return_msg)) {
    echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$return_msg\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
} else {
    if (isset($tid) && is_numeric($tid) && isset($reply_to_pid) && is_numeric($reply_to_pid)) {
        echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$reply_to_pid\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
    } else {
        echo "<a href=\"lthread_list.php?webtag=$webtag\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";
    }
}

echo "</div>";

if (attachments_check_dir() && (session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid) || $new_thread)) {

    echo "<div class=\"attachments post_attachments\">", gettext('Attachments'), ":\n";
    echo "  ", attachments_form($_SESSION['UID'], $attachments), "\n";
    echo "</div>\n";
}

echo "</div>";
echo "</div>";
echo "</form>\n";

if (!$new_thread && $reply_to_pid > 0) {

    echo "<h3>", gettext("In reply to"), ":</h3>\n";

    if (($thread_data['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        light_poll_display($tid, $thread_data['LENGTH'], $thread_data['FID'], $thread_data['CLOSED'], false, true);
    } else {

        light_message_display($tid, $reply_message, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], false, false, false, false, true);
    }
}

light_html_draw_bottom();