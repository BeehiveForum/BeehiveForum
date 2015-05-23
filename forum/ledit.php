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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
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

$tid = null;
$pid = null;
$fid = null;

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$fid = thread_get_folder_fid($tid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode('.', $_POST['msg']);

    if (!$fid = thread_get_folder_fid($tid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    light_html_draw_error(gettext("No message specified for editing"), 'lthread_list.php', 'get', array('back' => gettext("Back")));
}

if (isset($_POST['return_msg']) && validate_msg($_POST['return_msg'])) {
    $return_msg = $_POST['return_msg'];
} else if (isset($_GET['return_msg']) && validate_msg($_GET['return_msg'])) {
    $return_msg = $_GET['return_msg'];
} else {
    $return_msg = $msg;
}

if (!($edit_message = messages_get($tid, $pid, 1))) {

    light_html_draw_top(
        array(
            'title' => gettext("Error")
        )
    );

    light_navigation_bar();
    light_html_display_error_msg(gettext("That post does not exist in this thread!"));
    light_html_draw_bottom();
    exit;
}

if (thread_is_poll($tid) && $pid == 1) {

    light_html_draw_top(
        array(
            'title' => gettext("Error")
        )
    );

    light_navigation_bar();
    light_html_display_error_msg(gettext("Cannot edit polls in Mobile mode"));
    light_html_draw_bottom();
    exit;
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    light_html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $fid)) {
    light_html_draw_error(gettext("You cannot edit posts in this folder"));
}

if (!$thread_data = thread_get($tid)) {
    light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

$error_msg_array = array();

$show_sigs = session::show_sigs();

$page_prefs = session::get_post_page_prefs();

$valid = true;

$allow_html = true;

$allow_sig = true;

if (isset($edit_message['ATTACHMENTS'])) {
    $attachments = $edit_message['ATTACHMENTS'];
} else {
    $attachments = array();
}

if (isset($fid) && !session::check_perm(USER_PERM_HTML_POSTING, $fid)) {
    $allow_html = false;
}

if (isset($fid) && !session::check_perm(USER_PERM_SIGNATURE, $fid)) {
    $allow_sig = false;
}

if (isset($_POST['apply']) || isset($_POST['preview'])) {

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

    if (isset($_POST['sig'])) {

        $sig = fix_html(emoticons_strip($_POST['sig']));

        if (attachments_embed_check($sig)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
            $valid = false;
        }
    }

    if (isset($_POST['attachment']) && is_array($_POST['attachment'])) {
        $attachments = array_filter($_POST['attachment'], 'is_md5');
    } else {
        $attachments = array();
    }
}

if (!isset($content)) $content = "";

if (!isset($sig)) $sig = "";

if ($allow_html == false) {

    $content = htmlentities_array($content);
    $sig = htmlentities_array($sig);
}

if ($valid && isset($_POST['preview'])) {

    if (sizeof($attachments) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if (sizeof($attachments) > 0 && !attachments_check_post_space($_SESSION['UID'], $attachments)) {

        $max_post_attachment_space = forum_get_setting('attachments_max_post_space', 'is_numeric', 1048576);
        $error_msg_array[] = gettext(sprintf("You have too many files attached to this post. Maximum attachment space per post is %s", format_file_size($max_post_attachment_space)));
        $valid = false;
    }

    if ($valid) {

        $edit_message['CONTENT'] = $content;

        if ($allow_sig == true && isset($sig)) {
            $edit_message['CONTENT'] .= "<div class=\"sig\">$sig</div>";
        }

        $edit_message['ATTACHMENTS'] = $attachments;
    }

} else if ($valid && isset($_POST['apply'])) {

    $post_edit_time = forum_get_setting('post_edit_time', 'is_numeric', 0);

    if (sizeof($attachments) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if (sizeof($attachments) > 0 && !attachments_check_post_space($_SESSION['UID'], $attachments)) {

        $max_post_attachment_space = forum_get_setting('attachments_max_post_space', 'is_numeric', 1048576);
        $error_msg_array[] = gettext(sprintf("You have too many files attached to this post. Maximum attachment space per post is %s", format_file_size($max_post_attachment_space)));
        $valid = false;
    }

    if ((forum_get_setting('allow_post_editing', 'N') || (($_SESSION['UID'] != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {
        light_html_draw_error(gettext("You are not permitted to edit this message."), 'lmessages.php', 'get', array('back' => gettext("Back")), array('msg' => $return_msg));
    }

    if ($valid) {

        $content_new = $content;

        if ($allow_sig == true && isset($sig)) {
            $content_new .= "<div class=\"sig\">$sig</div>";
        }

        if (post_update($fid, $tid, $pid, $content_new)) {

            post_add_edit_text($tid, $pid);

            post_remove_attachments($tid, $pid);

            if (perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $edit_message['FROM_UID']) && !perm_is_moderator($edit_message['FROM_UID'], $fid)) {
                admin_send_post_approval_notification($fid);
            }

            if (sizeof($attachments) > 0 && ($attachments_array = attachments_get($edit_message['FROM_UID'], $attachments))) {

                foreach ($attachments_array as $attachment) {

                    post_add_attachment($tid, $pid, $attachment['aid']);
                }
            }

            if (session::check_perm(USER_PERM_FOLDER_MODERATE, $fid) && ($edit_message['FROM_UID'] != $_SESSION['UID'])) {
                admin_add_log_entry(EDIT_POST, array($fid, $tid, $pid));
            }

            header_redirect("lmessages.php?webtag=$webtag&msg=$return_msg&edit_success=$msg");
            exit;

        } else {

            $error_msg_array[] = gettext("Error updating post");
        }
    }

} else if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double)$page_prefs ^ POST_EMOTICONS_DISPLAY;

    } else if (isset($_POST['sig_toggle'])) {

        $page_prefs = (double)$page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($_SESSION['UID'], $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

} else {

    $post_edit_time = forum_get_setting('post_edit_time', 'is_numeric', 0);

    if (count($edit_message) > 0) {

        if (($edit_message['CONTENT'] = message_get_content($tid, $pid)) !== false) {

            if ((forum_get_setting('allow_post_editing', 'N') || (($_SESSION['UID'] != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {
                light_html_draw_error(gettext("You are not permitted to edit this message."), 'lmessages.php', 'get', array('back' => gettext("Back")), array('msg' => $return_msg));
            }

            $parsed_message = new MessageTextParse($edit_message['CONTENT']);

            $content = $parsed_message->getMessage();

            $sig = $parsed_message->getSig();

        } else {

            light_html_draw_error(sprintf(gettext("Message %s was not found"), $msg), 'lthread_list.php', 'get', array('back' => gettext("Back")));
        }

    } else {

        light_html_draw_error(sprintf(gettext("Message %s was not found"), $msg), 'lthread_list.php', 'get', array('back' => gettext("Back")));
    }
}

$page_title = sprintf(gettext("Edit message %s"), $msg);

light_html_draw_top(
    array(
        'title' => $page_title,
        'js' => array(
            'js/fineuploader.min.js',
            'js/attachments.js'
        )
    )
);

light_navigation_bar(
    array(
        'back' => "lmessages.php?webtag=$webtag&msg=$return_msg",
    )
);

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>";

    light_message_display($tid, $edit_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, false, false, false, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_edit\" action=\"ledit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo form_input_hidden("msg", htmlentities_array($msg));
echo form_input_hidden('return_msg', htmlentities_array($return_msg)), "\n";

echo "<div class=\"post\">\n";
echo "<h3>", $page_title, "</h3>\n";
echo "<div class=\"post_inner\">\n";
echo "<div class=\"post_to\">", gettext("To"), ":\n";
echo "<div class=\"recipients\">\n";

if (isset($edit_message['RECIPIENTS']) && sizeof($edit_message['RECIPIENTS']) > 0) {

    foreach ($edit_message['RECIPIENTS'] as $recipient) {
        echo word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "\n";
    }

} else {

    echo gettext('ALL');
}

echo "</div>\n";
echo "</div>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("content", htmlentities_array(strip_paragraphs($content)), 10, 50, null, 'textarea'), "</div>";

if ($allow_sig == true) {
    echo form_input_hidden("sig", htmlentities_array($sig));
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("apply", gettext("Apply"));
echo light_form_submit("preview", gettext("Preview"));
echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$return_msg\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>\n";

echo "</div>";

if (attachments_check_dir() && session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $fid)) {

    echo "<div class=\"attachments post_attachments\">", gettext('Attachments'), ":\n";
    echo "  ", attachments_form($edit_message['FROM_UID'], $attachments), "\n";
    echo "</div>\n";
}

echo "</div>";
echo "</div>";
echo "</form>\n";;

light_html_draw_bottom();