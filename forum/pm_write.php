<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: pm_write.php,v 1.216 2008-09-06 16:05:55 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Fetch the webtag

$webtag = get_webtag();

// Load language file

$lang = load_language_file();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access this page.

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that PM system is enabled

pm_enabled();

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Prune old messages for the current user

pm_user_prune_folders();

// Get the Message ID (MID) if any.

if (isset($_GET['replyto']) && is_numeric($_GET['replyto'])) {

    $t_reply_mid = $_GET['replyto'];

}elseif (isset($_POST['replyto']) && is_numeric($_POST['replyto'])) {

    $t_reply_mid = $_POST['replyto'];

}elseif (isset($_GET['fwdmsg']) && is_numeric($_GET['fwdmsg'])) {

    $t_forward_mid = $_GET['fwdmsg'];

}elseif (isset($_POST['fwdmsg']) && is_numeric($_POST['fwdmsg'])) {

    $t_forward_mid = $_POST['fwdmsg'];

}elseif (isset($_GET['editmsg']) && is_numeric($_GET['editmsg'])) {

    $t_edit_mid = $_GET['editmsg'];

}elseif (isset($_POST['editmsg']) && is_numeric($_POST['editmsg'])) {

    $t_edit_mid = $_POST['editmsg'];
}

// Get the tid.pid if any.

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (is_numeric($tid) && is_numeric($pid)) {

        if (($threaddata = thread_get($tid))) {

            $thread_title = thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']);
            $thread_index = "[$tid.$pid]";

            if (strlen($thread_title) > (55 - strlen($thread_index))) {
                $thread_title = substr($thread_title, 0, (55 - strlen($thread_index))). '...';
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
    }else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }

}elseif (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }
}

// User clicked cancel

if (isset($_POST['cancel'])) {

    if (isset($t_reply_mid) && is_numeric($t_reply_mid)  && $t_reply_mid > 0) {

        $uri = "pm.php?webtag=$webtag&mid=$t_reply_mid";

    }elseif (isset($t_forward_mid) && is_numeric($t_forward_mid)  && $t_forward_mid > 0) {

        $uri = "pm.php?webtag=$webtag&mid=$t_forward_mid";

    }elseif (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

        $uri = "pm.php?webtag=$webtag&mid=$t_edit_mid";

    }else {

        $uri = "pm.php?webtag=$webtag";
    }

    header_redirect($uri);
}

// Assume everything is correct (form input, etc)

$valid = true;

// Array to hold error messages

$error_msg_array = array();

// Enable Fix HTML.

$fix_html = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false

$allow_html = true;

// User clicked the emoticon panel toggle button

if (isset($_POST['emots_toggle_x']) || isset($_POST['emots_toggle_y'])) {

    if (isset($_POST['t_subject']) && strlen(trim(_stripslashes($_POST['t_subject']))) > 0) {
        $t_subject = trim(_stripslashes($_POST['t_subject']));
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {
        $t_content = trim(_stripslashes($_POST['t_content']));
    }

    if (isset($_POST['to_radio']) && is_numeric($_POST['to_radio'])) {
        $to_radio = $_POST['to_radio'];
    }else {
        $to_radio = POST_RADIO_OTHERS;
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    }else {
        $t_to_uid = 0;
    }

    if (isset($_POST['t_recipient_list']) && strlen(trim(_stripslashes($_POST['t_recipient_list']))) > 0) {
        $t_recipient_list = trim(_stripslashes($_POST['t_recipient_list']));
    }

    $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }
}

// Some Options.

if (isset($_POST['t_post_emots'])) {

    if ($_POST['t_post_emots'] == "disabled") {
        $emots_enabled = false;
    }else {
        $emots_enabled = true;
    }

}else {

    $emots_enabled = true;
}

if (isset($_POST['t_post_links'])) {

   if ($_POST['t_post_links'] == "enabled") {
        $links_enabled = true;
   } else {
        $links_enabled = false;
   }

}else {

   $links_enabled = false;
}

if (isset($_POST['t_check_spelling'])) {

    if ($_POST['t_check_spelling'] == "enabled") {
        $spelling_enabled = true;
    } else {
        $spelling_enabled = false;
    }

}else {

    $spelling_enabled = ($page_prefs & POST_CHECK_SPELLING);
}

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = POST_HTML_AUTO;
    }else if ($t_post_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }

}else if (!isset($post_html)) {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_AUTO;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }

    $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);
    $links_enabled = ($page_prefs & POST_AUTO_LINKS);
}

if (!isset($t_content)) $t_content = "";

$post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);

$t_content = $post->getContent();

// Submit handling code

if (isset($_POST['send']) || isset($_POST['preview'])) {

    // User clicked the send or preview button - check the data that was submitted

    if (isset($_POST['t_subject']) && strlen(trim(_stripslashes($_POST['t_subject']))) > 0) {

        $t_subject = trim(_stripslashes($_POST['t_subject']));

    }else {

        $error_msg_array[] = $lang['entersubjectformessage'];
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = trim(_stripslashes($_POST['t_content']));

        $post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);

        $t_content = $post->getContent();

    }else {

        $error_msg_array[] = $lang['entercontentformessage'];
        $valid = false;
    }

    if (isset($_POST['to_radio']) && is_numeric($_POST['to_radio'])) {
        $to_radio = $_POST['to_radio'];
    }else {
        $to_radio = POST_RADIO_OTHERS;
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    }else {
        $t_to_uid = 0;
    }

    if ($to_radio == POST_RADIO_FRIENDS && $t_to_uid == 0) {

        $error_msg_array[] = $lang['mustspecifyrecipient'];
        $valid = false;
    }

    if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

        if (($pm_data = pm_message_get($t_reply_mid))) {

            $pm_data['CONTENT'] = pm_get_content($t_reply_mid);

        }else {

            html_draw_top();
            pm_error_refuse();
            html_draw_bottom();
            exit;
        }
    }

    if (isset($_POST['t_recipient_list']) && strlen(trim(_stripslashes($_POST['t_recipient_list']))) > 0) {

        $t_recipient_array = preg_split("/[;|,]/u", trim(_stripslashes($_POST['t_recipient_list'])));

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

                if ($to_radio == POST_RADIO_OTHERS) {

                    if ((($peer_relationship ^ USER_BLOCK_PM) && user_allow_pm($to_user['UID'])) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, 0)) {

                        pm_user_prune_folders();

                        if (pm_get_free_space($uid) < sizeof($t_new_recipient_array['TO_UID'])) {

                            $error_msg_array[] = $lang['youdonothaveenoughfreespace'];
                            $valid = false;
                        }

                    }else {

                        $error_msg_array[] = sprintf($lang['userhasoptedoutofpm'], $to_logon);
                        $valid = false;
                    }
                }

            }else {

                $error_msg_array[] = sprintf($lang['usernotfound'], $to_logon);
                $valid = false;
            }
        }

        $t_recipient_list = implode('; ', $t_new_recipient_array['LOGON']);

        if ($to_radio == POST_RADIO_OTHERS) {

            if ($valid && sizeof($t_new_recipient_array['TO_UID']) > 10) {

                $error_msg_array[] = $lang['maximumtenrecipientspermessage'];
                $valid = false;
            }

            if ($valid && sizeof($t_new_recipient_array['TO_UID']) < 1) {

                $error_msg_array[] = $lang['mustspecifyrecipient'];
                $valid = false;
            }
        }

    }elseif ($to_radio == POST_RADIO_OTHERS) {

        $error_msg_array[] = $lang['mustspecifyrecipient'];
        $valid = false;
    }

}else if (isset($_POST['save'])) {

    // User click the save button - Check the data that was submitted.

    if (isset($_POST['t_subject']) && strlen(trim(_stripslashes($_POST['t_subject']))) > 0) {

        $t_subject = trim(_stripslashes($_POST['t_subject']));

    }else {

        $t_subject = "";
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = trim(_stripslashes($_POST['t_content']));

        $post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);

        $t_content = $post->getContent();

    }else {

        $t_content = "";
    }

    if (isset($_POST['to_radio']) && is_numeric($_POST['to_radio'])) {
        $to_radio = $_POST['to_radio'];
    }else {
        $to_radio = POST_RADIO_OTHERS;
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    }else {
        $t_to_uid = 0;
    }

    if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
        $aid = $_POST['aid'];
    }else{
        $aid = md5(uniqid(mt_rand()));
    }

    if (isset($_POST['t_recipient_list']) && strlen(trim(_stripslashes($_POST['t_recipient_list']))) > 0) {

        $t_recipient_array = preg_split("/[;|,]/u", trim(_stripslashes($_POST['t_recipient_list'])));

        if (sizeof($t_recipient_array) > 10) {

            $error_msg_array[] = $lang['maximumtenrecipientspermessage'];
            $valid = false;
        }

        $t_recipient_list = implode(';', $t_recipient_array);

    }else {

        $t_recipient_list = "";
    }

}else if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    if (!$t_recipient_list = pm_get_user($t_reply_mid)) $t_recipient_list = "";

    if (($pm_data = pm_message_get($t_reply_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_reply_mid);

        $t_subject = preg_replace('/^(RE:)?/iu', 'RE:', $pm_data['SUBJECT']);

        $message_author = _htmlentities(format_user_name($pm_data['FLOGON'], $pm_data['FNICK']));

        if (bh_session_get_value('PM_INCLUDE_REPLY') == 'Y') {

            if ($page_prefs & POST_TINYMCE_DISPLAY) {

                $t_content = "<div class=\"quotetext\" id=\"quote\">";
                $t_content.= "<b>quote: </b>$message_author</div>";
                $t_content.= "<div class=\"quote\">";
                $t_content.= trim(strip_tags(strip_paragraphs($pm_data['CONTENT'])));
                $t_content.= "</div><p>&nbsp;</p>";

            }else {

                $t_content = "<quote source=\"$message_author\" url=\"\">";
                $t_content.= trim(strip_tags(strip_paragraphs($pm_data['CONTENT'])));
                $t_content.= "</quote>\n\n";
            }

            // Set the HTML mode to 'with automatic line breaks' so
            // the quote is handled correctly when the user previews
            // the message.

            $post = new MessageText(POST_HTML_AUTO, $t_content, $emots_enabled, $links_enabled);

            $t_content = $post->getContent();

            $post_html = POST_HTML_AUTO;
        }

    }else {

        html_draw_top();
        pm_error_refuse();
        html_draw_bottom();
        exit;
    }

}else if (isset($t_forward_mid) && is_numeric($t_forward_mid) && $t_forward_mid > 0) {

    if (($pm_data = pm_message_get($t_forward_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_forward_mid);

        $t_subject = preg_replace('/^(FWD:)?/iu', 'FWD:', $pm_data['SUBJECT']);

        $message_author = _htmlentities(format_user_name($pm_data['FLOGON'], $pm_data['FNICK']));

        if ($page_prefs & POST_TINYMCE_DISPLAY) {

            $t_content = "<div class=\"quotetext\" id=\"quote\">";
            $t_content.= "<b>quote: </b>$message_author</div>";
            $t_content.= "<div class=\"quote\">";
            $t_content.= trim(strip_tags(strip_paragraphs($pm_data['CONTENT'])));
            $t_content.= "</div><p>&nbsp;</p>";

        }else {

            $t_content = "<quote source=\"$message_author\" url=\"\">";
            $t_content.= trim(strip_tags(strip_paragraphs($pm_data['CONTENT'])));
            $t_content.= "</quote>\n\n";
        }

        // Set the HTML mode to 'with automatic line breaks' so
        // the quote is handled correctly when the user previews
        // the message.

        $post = new MessageText(POST_HTML_AUTO, $t_content, $emots_enabled, $links_enabled);

        $t_content = $post->getContent();

        $post_html = POST_HTML_AUTO;

    }else {

        html_draw_top();
        pm_error_refuse();
        html_draw_bottom();
        exit;
    }

}else if (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

    if (($pm_data = pm_message_get($t_edit_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_edit_mid);

        $t_subject = $pm_data['SUBJECT'];

        $parsed_message = new MessageTextParse($pm_data['CONTENT'], $emots_enabled, $links_enabled);

        $emots_enabled = $parsed_message->getEmoticons();
        $links_enabled = $parsed_message->getLinks();

        $t_content = $parsed_message->getMessage();
        $post_html = $parsed_message->getMessageHTML();

        $post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);

        $post->diff = false;

        $t_content = $post->getContent();

        $t_subject = $pm_data['SUBJECT'];

        $t_to_uid = $pm_data['TO_UID'];

        $t_recipient_list = $pm_data['RECIPIENTS'];

        if (strlen($t_recipient_list) > 0) {
            $to_radio = POST_RADIO_OTHERS;
        }elseif ($t_to_uid > 0) {
            $to_radio = POST_RADIO_FRIENDS;
        }

        $aid = $pm_data['AID'];

    }else {

        html_draw_top();
        pm_error_refuse();
        html_draw_bottom();
        exit;
    }
}

// Check the message length.

if (strlen($t_content) >= 65535) {

    $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(strlen($t_content)));
    $valid = false;
}

// Attachment Unique ID

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else if (!isset($aid)) {
    $aid = md5(uniqid(mt_rand()));
}

// De-dupe key

if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
}else{
    $t_dedupe = mktime();
}

// Send the PM

if ($valid && isset($_POST['send'])) {

    if (check_ddkey($t_dedupe)) {

        if (isset($to_radio) && $to_radio == POST_RADIO_FRIENDS) {

            if (($new_mid = pm_send_message($t_to_uid, $uid, $t_subject, $t_content, $aid))) {

                email_send_pm_notification($t_to_uid, $new_mid, $uid);

            }else {

                $error_msg_array[] = $lang['errorcreatingpm'];
                $valid = false;
            }

            if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {
                pm_delete_message($t_edit_mid);
            }

        }else {

            foreach ($t_new_recipient_array['TO_UID'] as $t_to_uid) {

                if (($new_mid = pm_send_message($t_to_uid, $uid, $t_subject, $t_content, $aid))) {

                    email_send_pm_notification($t_to_uid, $new_mid, $uid);

                }else {

                    $error_msg_array[] = $lang['errorcreatingpm'];
                    $valid = false;
                }
            }

            if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {
                pm_delete_message($t_edit_mid);
            }
        }
    }

    if ($valid) {

        header_redirect("pm.php?webtag=$webtag&message_sent=true");
        exit;
    }

}else if ($valid && isset($_POST['save'])) {

    if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {

        if (pm_update_saved_message($t_edit_mid, $t_subject, $t_content, $t_to_uid, $t_recipient_list)) {

            header_redirect("pm.php?webtag=$webtag&mid=$t_edit_mid&message_saved=true");
            exit;

        }else {

            $error_msg_array[] = $lang['couldnotsavemessage'];
            $valid = false;
        }

    }else {

        if (($saved_mid = pm_save_message($t_subject, $t_content, $t_to_uid, $t_recipient_list))) {

            pm_save_attachment_id($saved_mid, $aid);

            header_redirect("pm.php?webtag=$webtag&mid=$saved_mid&message_saved=true");
            exit;

        }else {

            $error_msg_array[] = $lang['couldnotsavemessage'];
            $valid = false;
        }
    }
}

html_draw_top("onUnload=clearFocus()", "resize_width=720", "tinymce_auto_focus=t_content", "openprofile.js", "pm.js", "attachments.js", "dictionary.js", "htmltools.js", "basetarget=_blank");

echo "<h1>{$lang['privatemessages']} &raquo; {$lang['sendnewpm']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"pm_write.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('folder', _htmlentities($folder)), "\n";
echo "  ", form_input_hidden("t_dedupe", _htmlentities($t_dedupe));
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

// preview message

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['messagepreview']}</td>\n";
    echo "                </tr>\n";

    if (isset($to_radio) && $to_radio == POST_RADIO_FRIENDS) {

        $preview_tuser = user_get($t_to_uid);

        $pm_preview_array['TLOGON'] = $preview_tuser['LOGON'];
        $pm_preview_array['TNICK']  = $preview_tuser['NICKNAME'];
        $pm_preview_array['TO_UID'] = $preview_tuser['UID'];

    }else {

        $pm_preview_array['TLOGON'] = $t_new_recipient_array['LOGON'];
        $pm_preview_array['TNICK']  = $t_new_recipient_array['NICK'];
        $pm_preview_array['TO_UID'] = $t_new_recipient_array['TO_UID'];
    }

    $preview_fuser = user_get($uid);

    $pm_preview_array['FLOGON'] = $preview_fuser['LOGON'];
    $pm_preview_array['FNICK']  = $preview_fuser['NICKNAME'];
    $pm_preview_array['FROM_UID'] = $preview_fuser['UID'];

    $pm_preview_array['SUBJECT'] = $t_subject;
    $pm_preview_array['CREATED'] = mktime();
    $pm_preview_array['AID'] = $aid;

    $pm_preview_array['CONTENT'] = $t_content;

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" width=\"690\"><br />", pm_display($pm_preview_array, PM_FOLDER_OUTBOX, true), "</td>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table width=\"720\" class=\"posthead\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['writepm']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['subject']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("t_subject", isset($t_subject) ? _htmlentities($t_subject) : "", 42, false, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['to']}</h2></td>\n";
echo "                      </tr>\n";

if (($friends_array = pm_user_get_friends())) {

    if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

        $to_user = user_get($_GET['uid']);

        if (in_array($to_user['UID'], array_keys($friends_array))) {

            $t_to_uid = $to_user['UID'];
            $to_radio = 0;

        }else {

            $t_recipient_list = $to_user['LOGON'];
        }
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_radio("to_radio", POST_RADIO_FRIENDS, $lang['friends'], (isset($to_radio) && $to_radio == POST_RADIO_FRIENDS)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_to_uid", $friends_array, (isset($t_to_uid) ? $t_to_uid : 0), "onclick=\"checkToRadio(0)\"", "to_uid_dropdown"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_radio("to_radio", POST_RADIO_OTHERS, $lang['others'], (isset($to_radio) && $to_radio == POST_RADIO_OTHERS) ? true : (!isset($to_radio))), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text("t_recipient_list", isset($t_recipient_list) ? _htmlentities($t_recipient_list) : "", 0, 0, "title=\"{$lang['recipienttiptext']}\" onclick=\"checkToRadio(1)\"", "recipient_list"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;allow_multi=Y&amp;obj_name=t_recipient_list\" onclick=\"return openRecipientSearch('$webtag', 't_recipient_list');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div></td>\n";
    echo "                      </tr>\n";

}else {

    if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

        $to_user = user_get($_GET['uid']);
        $t_recipient_list = $to_user['LOGON'];
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text("t_recipient_list", isset($t_recipient_list) ? _htmlentities($t_recipient_list) : "", 0, 0, "title=\"{$lang['recipienttiptext']}\"", "recipient_list"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;allow_multi=Y&amp;obj_name=t_recipient_list\" onclick=\"return openRecipientSearch('$webtag', 't_recipient_list');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div></td>\n";
    echo "                      </tr>\n";
}

if (!is_array($friends_array) && forum_check_webtag_available($webtag)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['hint']}</h2><span class=\"smalltext\">{$lang['adduserstofriendslist']}</span></td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['messageoptions']}</h2>\n";

echo "                          ".form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo "                          ".form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo "                          ".form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br />\n";

echo "                        </td>\n";
echo "                      </tr>\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if (strlen($emot_prev) > 0) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {

        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('emots_hide.png', 'emots_toggle', 'hide'), "&nbsp;</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('emots_show.png', 'emots_toggle', 'show'), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td align=\"left\" width=\"500\" valign=\"top\">\n";
echo "                    <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">";
echo "                         <h2>{$lang['message']}</h2>\n";

$tools = new TextAreaHTML("f_post");
echo $tools->preload();

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar(false, form_submit('send', $lang['send'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));
} else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("t_content", _htmlentities($t_content), 20, 75, "tabindex=\"1\"", "post_content"), "\n";

echo "                        </td>\n";
echo "                      </tr>\n";

if ($post->isDiff() && $fix_html) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          ", $tools->compare_original("t_content", $post->getOriginalContent()), "\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

if ($allow_html == true) {

    if (($tools->getTinyMCE())) {

        echo form_input_hidden("t_post_html", "enabled");

    } else {

        echo "              <h2>{$lang['htmlinmessage']}</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
                echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
        }

        echo "              <br />";
    }

} else {

        echo form_input_hidden("t_post_html", "disabled");
}

echo "              <br />\n";

echo "&nbsp;", form_submit('send', $lang['send'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "&nbsp;", form_submit('save', $lang['save'], 'tabindex="3" onclick="clearFocus()"');
echo "&nbsp;", form_submit('preview', $lang['preview'], 'tabindex="4" onclick="clearFocus()"');
echo "&nbsp;", form_submit('cancel', $lang['cancel'], 'tabindex="5" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y') && forum_get_setting('pm_allow_attachments', 'Y')) {

    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", _htmlentities($aid));
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";

echo $tools->js();

if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    echo form_input_hidden("replyto", _htmlentities($t_reply_mid)), "\n";

}elseif (isset($t_forward_mid) && is_numeric($t_forward_mid) && $t_forward_mid > 0) {

    echo form_input_hidden("fwdmsg", _htmlentities($t_forward_mid)), "\n";

}elseif (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

    echo form_input_hidden("editmsg", _htmlentities($t_edit_mid)), "\n";
}

if (isset($pm_data) && is_array($pm_data) && isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['inreplyto']}</td>\n";
    echo "                </tr>";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" width=\"690\"><br />", pm_display($pm_data, PM_FOLDER_INBOX, true), "</td>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>