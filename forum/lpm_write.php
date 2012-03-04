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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Load language file
$lang = load_language_file();

// Get the user's UID
$uid = session_get_value('UID');

// Guests can't access this page.
if (user_is_guest()) {

    light_html_draw_top();
    light_html_guest_error();
    light_html_draw_bottom();
    exit;
}

// Check that PM system is enabled
light_pm_enabled();

// Get the user's post page preferences.
$page_prefs = session_get_post_page_prefs();

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

        $uri = "lpm.php?webtag=$webtag&mid=$t_reply_mid";

    }elseif (isset($t_forward_mid) && is_numeric($t_forward_mid)  && $t_forward_mid > 0) {

        $uri = "lpm.php?webtag=$webtag&mid=$t_forward_mid";

    }elseif (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

        $uri = "lpm.php?webtag=$webtag&mid=$t_edit_mid";

    }else {

        $uri = "lpm.php?webtag=$webtag";
    }

    header_redirect($uri);
}

// Assume everything is correct (form input, etc)
$valid = true;

// Array to hold error messages
$error_msg_array = array();

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false
$allow_html = true;

// Some Options.
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
}

if (($page_prefs & POST_EMOTICONS_DISABLED) > 0) {
    $emots_enabled = false;
}else {
    $emots_enabled = true;
}

if (($page_prefs & POST_AUTO_LINKS) > 0) {
    $links_enabled = true;
}else {
    $links_enabled = false;
}

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);

$t_content = $post->getContent();

// Submit handling code
if (isset($_POST['send']) || isset($_POST['preview'])) {

    // User clicked the send or preview button - check the data that was submitted
    if (isset($_POST['t_subject']) && strlen(trim(stripslashes_array($_POST['t_subject']))) > 0) {

        $t_subject = trim(stripslashes_array($_POST['t_subject']));

    }else {

        $error_msg_array[] = $lang['entersubjectformessage'];
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = trim(stripslashes_array($_POST['t_content']));

        $post->setContent($t_content);

        $t_content = $post->getContent();

    }else {

        $error_msg_array[] = $lang['entercontentformessage'];
        $valid = false;
    }

    if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

        if (($pm_data = pm_message_get($t_reply_mid))) {

            $pm_data['CONTENT'] = pm_get_content($t_reply_mid);

        }else {

            light_html_draw_top("title={$lang['error']}");
            light_pm_error_refuse();
            light_html_draw_bottom();
            exit;
        }
    }

    if (isset($_POST['t_to_uid_others']) && strlen(trim(stripslashes_array($_POST['t_to_uid_others']))) > 0) {

        $t_recipient_array = preg_split("/[;|,]/u", trim(stripslashes_array($_POST['t_to_uid_others'])));

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

                if ((($peer_relationship ^ USER_BLOCK_PM) && user_allow_pm($to_user['UID'])) || session_check_perm(USER_PERM_FOLDER_MODERATE, 0)) {

                    pm_user_prune_folders();

                    if (pm_get_free_space($uid) < sizeof($t_new_recipient_array['TO_UID'])) {

                        $error_msg_array[] = $lang['youdonothaveenoughfreespace'];
                        $valid = false;
                    }

                }else {

                    $error_msg_array[] = sprintf($lang['userhasoptedoutofpm'], $to_logon);
                    $valid = false;
                }

            }else {

                $error_msg_array[] = sprintf($lang['usernotfound'], $to_logon);
                $valid = false;
            }
        }

        $t_to_uid_others = implode('; ', $t_new_recipient_array['LOGON']);

        if ($valid && sizeof($t_new_recipient_array['TO_UID']) > 10) {

            $error_msg_array[] = $lang['maximumtenrecipientspermessage'];
            $valid = false;
        }

        if ($valid && sizeof($t_new_recipient_array['TO_UID']) < 1) {

            $error_msg_array[] = $lang['mustspecifyrecipient'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustspecifyrecipient'];
        $valid = false;
    }

}else if (isset($_POST['save'])) {

    // User click the save button - Check the data that was submitted.
    if (isset($_POST['t_subject']) && strlen(trim(stripslashes_array($_POST['t_subject']))) > 0) {

        $t_subject = trim(stripslashes_array($_POST['t_subject']));

    }else {

        $t_subject = "";
    }

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = trim(stripslashes_array($_POST['t_content']));

        $post->setContent($t_content);

        $t_content = $post->getContent();

    }else {

        $t_content = "";
    }

    if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
        $aid = $_POST['aid'];
    }else{
        $aid = md5(uniqid(mt_rand()));
    }

    if (isset($_POST['t_to_uid_others']) && strlen(trim(stripslashes_array($_POST['t_to_uid_others']))) > 0) {

        $t_recipient_array = preg_split("/[;|,]/u", trim(stripslashes_array($_POST['t_to_uid_others'])));

        if (sizeof($t_recipient_array) > 10) {

            $error_msg_array[] = $lang['maximumtenrecipientspermessage'];
            $valid = false;
        }

        $t_to_uid_others = implode(';', $t_recipient_array);

    }else {

        $t_to_uid_others = "";
    }

}else if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    if (!$t_to_uid_others = pm_get_user($t_reply_mid)) $t_to_uid_others = "";

    if (($pm_data = pm_message_get($t_reply_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_reply_mid);

        $t_subject = preg_replace('/^(RE:)?/iu', 'RE:', $pm_data['SUBJECT']);

        $message_author = htmlentities_array(format_user_name($pm_data['FLOGON'], $pm_data['FNICK']));

        if (session_get_value('PM_INCLUDE_REPLY') == 'Y') {

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
            $post->setHTML(POST_HTML_AUTO);

            $t_content = $post->getContent();

            $post_html = POST_HTML_AUTO;
        }

    }else {

        light_html_draw_top("title={$lang['error']}");
        light_pm_error_refuse();
        light_html_draw_bottom();
        exit;
    }

}else if (isset($t_forward_mid) && is_numeric($t_forward_mid) && $t_forward_mid > 0) {

    if (($pm_data = pm_message_get($t_forward_mid))) {

        $pm_data['CONTENT'] = pm_get_content($t_forward_mid);

        $t_subject = preg_replace('/^(FWD:)?/iu', 'FWD:', $pm_data['SUBJECT']);

        $message_author = htmlentities_array(format_user_name($pm_data['FLOGON'], $pm_data['FNICK']));

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
        $post->setHTML(POST_HTML_AUTO);

        $t_content = $post->getContent();

        $post_html = POST_HTML_AUTO;

    }else {

        light_html_draw_top("title={$lang['error']}");
        light_pm_error_refuse();
        light_html_draw_bottom();
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
        
        $post->setHTML($allow_html ? $post_html : POST_HTML_DISABLED);

        $post->setContent($t_content);
        $post->setEmoticons($emots_enabled);
        $post->setLinks($links_enabled);        

        $post->diff = false;

        $t_content = $post->getContent();

        $t_subject = $pm_data['SUBJECT'];

        $t_to_uid_others = $pm_data['RECIPIENTS'];

        $aid = $pm_data['AID'];

    }else {

        light_html_draw_top("title={$lang['error']}");
        light_pm_error_refuse();
        light_html_draw_bottom();
        exit;
    }
}

// Check the message length.
if (mb_strlen($t_content) >= 65535) {

    $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(mb_strlen($t_content)));
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
    $t_dedupe = time();
}

// Send the PM
if ($valid && isset($_POST['send'])) {

    if (post_check_ddkey($t_dedupe)) {

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

    if ($valid) {

        header_redirect("lpm.php?webtag=$webtag&message_sent=true");
        exit;
    }

}else if ($valid && isset($_POST['save'])) {

    if (isset($t_edit_mid) && is_numeric($t_edit_mid)) {

        if (pm_update_saved_message($t_edit_mid, $t_subject, $t_content, 0, $t_to_uid_others)) {

            header_redirect("lpm.php?webtag=$webtag&mid=$t_edit_mid&message_saved=true");
            exit;

        }else {

            $error_msg_array[] = $lang['couldnotsavemessage'];
            $valid = false;
        }

    }else {

        if (($saved_mid = pm_save_message($t_subject, $t_content, 0, $t_to_uid_others))) {

            pm_save_attachment_id($saved_mid, $aid);

            header_redirect("lpm.php?webtag=$webtag&mid=$saved_mid&message_saved=true");
            exit;

        }else {

            $error_msg_array[] = $lang['couldnotsavemessage'];
            $valid = false;
        }
    }
}

light_html_draw_top("title={$lang['sendnewpm']}", "robots=noindex,nofollow");

// preview message
if ($valid && isset($_POST['preview'])) {

    echo "<h3>{$lang['messagepreview']}</h3>\n";

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
echo "<h3>{$lang['sendnewpm']}</h3>\n";
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<div class=\"post_thread_title\">{$lang['subject']}:", light_form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 30, 64), "</div>\n";
echo "<div class=\"post_to\">{$lang['to']}:", light_form_input_text("t_to_uid_others", isset($t_to_uid_others) ? htmlentities_array($t_to_uid_others) : "", 0, 0), "</div>\n";
echo "<div class=\"post_content\">{$lang['content']}:", light_form_textarea("t_content", $post->getTidyContent(), 10, 50), "</div>\n";

if ($allow_html == true) {

    $tph_radio = $post->getHTML();

    echo "<div class=\"post_html\"><span>{$lang['htmlinmessage']}:</span>\n";
    echo light_form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED);
    echo light_form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO);
    echo light_form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED);
    echo "</div>";

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("send", $lang['send']);
echo light_form_submit("save", $lang['save']);
echo light_form_submit("preview", $lang['preview']);
echo light_form_submit("cancel", $lang['cancel']);
echo "</div>";

if (isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    echo form_input_hidden("replyto", htmlentities_array($t_reply_mid)), "\n";

}elseif (isset($t_forward_mid) && is_numeric($t_forward_mid) && $t_forward_mid > 0) {

    echo form_input_hidden("fwdmsg", htmlentities_array($t_forward_mid)), "\n";

}elseif (isset($t_edit_mid) && is_numeric($t_edit_mid) && $t_edit_mid > 0) {

    echo form_input_hidden("editmsg", htmlentities_array($t_edit_mid)), "\n";
}

echo "</div>";
echo "</div>";
echo "</form>\n";

if (isset($pm_data) && is_array($pm_data) && isset($t_reply_mid) && is_numeric($t_reply_mid) && $t_reply_mid > 0) {

    echo "<h3>{$lang['inreplyto']}:</h3>\n";
    light_pm_display($pm_data, PM_FOLDER_INBOX, true);
}

light_html_draw_bottom();

?>