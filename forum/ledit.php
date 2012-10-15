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
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode('.', $_POST['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    light_html_draw_error(gettext("No message specified for editing"), 'lthread_list.php', 'get', array('back' => gettext("Back")));
}

if (!($edit_message = messages_get($tid, $pid, 1))) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")));
    light_html_display_error_msg(gettext("That post does not exist in this thread!"));
    light_html_draw_bottom();
    exit;
}

if (thread_is_poll($tid) && $pid == 1) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")));
    light_html_display_error_msg(gettext("Cannot edit polls in Mobile mode"));
    light_html_draw_bottom();
    exit;
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    light_html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {
    light_html_draw_error(gettext("You cannot edit posts in this folder"));
}

if (!$thread_data = thread_get($tid)) {
    light_html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

$error_msg_array = array();

$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

$uid = session::get_value('UID');

$page_prefs = session::get_post_page_prefs();

$valid = true;

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else{
    $aid = md5(uniqid(mt_rand()));
}

post_save_attachment_id($tid, $pid, $aid);

$allow_html = true;

$allow_sig = true;

if (isset($t_fid) && !session::check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !session::check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

        $t_content = fix_html(emoticons_strip($_POST['t_content']));

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

if (!isset($t_content)) $t_content = "";

if (!isset($t_sig)) $t_sig = "";

if ($allow_html == false) {

    $t_content = htmlentities_array($t_content);
    $t_sig = htmlentities_array($t_sig);
}

if ($valid && isset($_POST['preview'])) {

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if ($valid) {

        $edit_message['CONTENT'] = $t_content;

        if ($allow_sig == true && isset($t_sig)) {
            $edit_message['CONTENT'].= "<div class=\"sig\">$t_sig</div>";
        }

        if ($edit_message['TO_UID'] == 0) {

            $edit_message['TLOGON'] = gettext("ALL");
            $edit_message['TNICK'] = gettext("ALL");
        }

        $edit_message['AID'] = $aid;
    }

} else if ($valid && isset($_POST['apply'])) {

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    if (attachments_get_count($aid) > 0 && !session::check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        light_html_draw_error(gettext("You are not permitted to edit this message."), 'lmessages.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        light_html_draw_error(gettext("You are not permitted to edit this message."), 'lmessages.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
    }

    if ($valid) {

        $t_content_new = $t_content;

        if ($allow_sig == true && isset($t_sig)) {
            $t_content_new.= "<div class=\"sig\">$t_sig</div>";
        }

        if (post_update($t_fid, $tid, $pid, $t_content_new)) {

            post_add_edit_text($tid, $pid);

            post_save_attachment_id($tid, $pid, $aid);

            if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && ($edit_message['FROM_UID'] != $uid)) {
                admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
            }

            header_redirect("lmessages.php?webtag=$webtag&msg=$msg");
            exit;

        } else {

            $error_msg_array[] = gettext("Error updating post");
        }
    }

} else if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    } else if (isset($_POST['sig_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array(
        'POST_PAGE' => $page_prefs
    );

    if (!user_update_prefs($uid, $user_prefs)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }

} else {

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    if (count($edit_message) > 0) {

        if (($edit_message['CONTENT'] = message_get_content($tid, $pid))) {

            if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
                light_html_draw_error(gettext("You are not permitted to edit this message."), 'lmessages.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
            }

            if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
                light_html_draw_error(gettext("You are not permitted to edit this message."), 'lmessages.php', 'get', array('back' => gettext("Back")), array('msg' => $msg));
            }

            $to_uid = $edit_message['TO_UID'];

            $from_uid = $edit_message['FROM_UID'];

            $parsed_message = new MessageTextParse($edit_message['CONTENT']);

            $t_content = $parsed_message->getMessage();

            $t_sig = $parsed_message->getSig();

        } else {

            light_html_draw_error(sprintf(gettext("Message %s was not found"), $msg), 'lthread_list.php', 'get', array('back' => gettext("Back")));
        }

    } else{

        light_html_draw_error(sprintf(gettext("Message %s was not found"), $msg), 'lthread_list.php', 'get', array('back' => gettext("Back")));
    }
}

$page_title = sprintf(gettext("Edit message %s"), $msg);

light_html_draw_top("title=$page_title");

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>";

    light_message_display($tid, $edit_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, false, false, false, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_edit\" action=\"ledit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo form_input_hidden("msg", htmlentities_array($msg));

echo "<div class=\"post\">\n";
echo sprintf("<h3>%s %s</h3>", gettext("Edit message"), $msg);
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("t_content", htmlentities_array($t_content), 10, 50, false, 'textarea editor mobile'), "</div>";

if ($allow_sig == true) {
    echo form_input_hidden("t_sig", htmlentities_array($t_sig));
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("apply", gettext("Apply"));
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
echo "</form>\n";;

light_html_draw_bottom();

?>