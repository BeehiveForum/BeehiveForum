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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $edit_msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $edit_msg = $_POST['msg'];

    list($tid, $pid) = explode('.', $_POST['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['nomessagespecifiedforedit'], 'discussion.php', 'get', array('back' => $lang['back']));
    html_draw_bottom();
    exit;
}

if (thread_is_poll($tid) && $pid == 1) {

    header_redirect("edit_poll.php?webtag=$webtag&msg=$edit_msg");
    exit;
}

if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannoteditpostsinthisfolder']);
    html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages
$error_msg_array = array();

// Check if the user is viewing signatures.
$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

// User UID
$uid = session_get_value('UID');

// Get the user's post page preferences.
$page_prefs = session_get_post_page_prefs();

// Form validation
$valid = true;

// Pre-set the content and signature vars
$t_content = "";
$t_sig = "";

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
    }else {
        $links_enabled = false;
    }

}else {

    $links_enabled = false;
}

if (isset($_POST['t_check_spelling'])) {

    if ($_POST['t_check_spelling'] == "enabled") {
        $spelling_enabled = true;
    }else {
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
    }

}else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_AUTO;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
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
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

} else {
    
    $sig_html = POST_HTML_DISABLED;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = attachments_get_id($tid, $pid)) {

    $aid = md5(uniqid(mt_rand()));
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

post_save_attachment_id($tid, $pid, $aid);

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, "", $emots_enabled, $links_enabled, false);

$allow_html = true;
$allow_sig = true;

if (isset($t_fid) && !session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !session_check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if ($allow_html == false) {

    if ($post->getHTML() > 0) {

        $post->setHTML(false);
        $t_content = $post->getContent();
    }

    $sig->setHTML(false, true);
    $t_sig = $sig->getContent();
}

if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

    $t_content = trim(stripslashes_array($_POST['t_content']));

    if ($post_html && attachments_embed_check($t_content)) {

        $error_msg_array[] = $lang['notallowedembedattachmentpost'];
        $valid = false;
    }

    $post->setContent($t_content);
    $t_content = $post->getContent();

    if (mb_strlen($t_content) >= 65535) {

        $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(mb_strlen($t_content)));
        $valid = false;
    }
}

if (isset($_POST['t_sig']) && strlen(trim(stripslashes_array($_POST['t_sig']))) > 0) {

    $t_sig = trim(stripslashes_array($_POST['t_sig']));

    if (attachments_embed_check($t_sig)) {

        $error_msg_array[] = $lang['notallowedembedattachmentpost'];
        $valid = false;
    }

    $sig->setContent($t_sig);
    $t_sig = $sig->getContent();

    if (mb_strlen($t_sig) >= 65535) {

        $error_msg_array[] = sprintf($lang['reducesiglength'], number_format(mb_strlen($t_sig)));
        $valid = false;
    }
}

if (isset($_POST['preview'])) {

    if (!$preview_message = messages_get($tid, $pid, 1)) {

        html_draw_top("title={$lang['error']}");
        html_display_error_msg($lang['postdoesnotexist']);
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_to_uid'])) {

        $to_uid = $_POST['t_to_uid'];

    }else {

        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {

        $from_uid = $_POST['t_from_uid'];

    }else {

        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (strlen(trim($t_content)) < 1) {

        $error_msg_array[] = $lang['mustenterpostcontent'];
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
        $valid = false;
    }

    if ($valid) {

        $preview_message['CONTENT'] = $t_content;

        if ($allow_sig == true && isset($t_sig)) {
            $preview_message['CONTENT'].= "<div class=\"sig\">$t_sig</div>";
        }

        if ($to_uid == 0) {

            $preview_message['TLOGON'] = $lang['allcaps'];
            $preview_message['TNICK'] = $lang['allcaps'];

        }else{

            $preview_tuser = user_get($_POST['t_to_uid']);
            $preview_message['TLOGON'] = $preview_tuser['LOGON'];
            $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
            $preview_message['TO_UID'] = $preview_tuser['UID'];
        }

        $preview_tuser = user_get($from_uid);
        $preview_message['FLOGON'] = $preview_tuser['LOGON'];
        $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['FROM_UID'] = $from_uid;
        $preview_message['AID'] = $aid;
    }

}else if (isset($_POST['apply'])) {

    if (!$edit_message = messages_get($tid, $pid, 1)) {

        html_draw_top("title={$lang['error']}");
        html_display_error_msg($lang['postdoesnotexist']);
        html_draw_bottom();
        exit;
    }

    $post_edit_time = forum_get_setting('post_edit_time', false, 0);

    if (isset($_POST['t_to_uid'])) {

        $to_uid = $_POST['t_to_uid'];

    }else {

        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {

        $from_uid = $_POST['t_from_uid'];

    }else {

        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (strlen(trim($t_content)) < 1) {

        $error_msg_array[] = $lang['mustenterpostcontent'];
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
        $valid = false;
    }

    if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session_check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_msg));
        html_draw_bottom();
        exit;
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_msg));
        html_draw_bottom();
        exit;
    }

    $preview_message = $edit_message;

    if ($valid) {

        if ($allow_sig == true && isset($t_sig)) {

            $t_content_new = $t_content."<div class=\"sig\">$t_sig</div>";

        }else {

            $t_content_new = $t_content;
        }

        if (post_update($t_fid, $tid, $pid, $t_content_new)) {

            post_add_edit_text($tid, $pid);

            post_save_attachment_id($tid, $pid, $aid);

            if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != $uid) {
                admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
            }

            header_redirect("discussion.php?webtag=$webtag&msg=$edit_msg&edit_success=$edit_msg");
            exit;

        }else{

            $error_msg_array[] = $lang['errorupdatingpost'];
        }
    }

}else if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (!$preview_message = messages_get($tid, $pid, 1)) {

        html_draw_top("title={$lang['error']}");
        html_display_error_msg($lang['postdoesnotexist']);
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_to_uid'])) {
        $to_uid = $_POST['t_to_uid'];
    }else {
        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {
        $from_uid = $_POST['t_from_uid'];
    }else {
        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }

}else {

    if (!$edit_message = messages_get($tid, $pid, 1)) {

        html_draw_top("title={$lang['error']}");
        html_display_error_msg($lang['postdoesnotexist']);
        html_draw_bottom();
        exit;
    }

    $post_edit_time = forum_get_setting('post_edit_time', false, 0);

    if (count($edit_message) > 0) {

        if (($edit_message['CONTENT'] = message_get_content($tid, $pid))) {

            if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session_check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                html_draw_top("title={$lang['error']}");
                html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_msg));
                html_draw_bottom();
                exit;
            }

            if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                html_draw_top("title={$lang['error']}");
                html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_msg));
                html_draw_bottom();
                exit;
            }

            $preview_message = $edit_message;

            $to_uid = $edit_message['TO_UID'];

            $from_uid = $edit_message['FROM_UID'];
            
            $parsed_message = new MessageTextParse($edit_message['CONTENT'], $emots_enabled, $links_enabled);
            
            $emots_enabled = $parsed_message->getEmoticons();

            $links_enabled = $parsed_message->getLinks();

            $t_content = $parsed_message->getMessage();
            
            $post_html = $parsed_message->getMessageHTML();

            $t_sig = $parsed_message->getSig();
            
            $sig_html = $parsed_message->getSigHTML();
            
            $post->setHTML($allow_html ? $post_html : POST_HTML_DISABLED);
            $sig->setHTML($allow_html ? $sig_html : POST_HTML_DISABLED, true);

            $post->setContent($t_content);
            $post->setEmoticons($emots_enabled);
            $post->setLinks($links_enabled);
            
            $sig->setContent($t_sig);
            $sig->setEmoticons($emots_enabled);
            $sig->setLinks($links_enabled);

            $post->diff = false;
            $sig->diff = false;

            $t_content = $post->getContent();
            $t_sig = $sig->getContent();

        }else {

            html_draw_top("title={$lang['error']}");
            html_error_msg(sprintf($lang['messagewasnotfound'], $edit_msg), 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_msg));
            html_draw_bottom();
            exit;
        }

    }else{

       html_draw_top("title={$lang['error']}");
       html_error_msg(sprintf($lang['messagewasnotfound'], $edit_msg), 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_msg));
       html_draw_bottom();
       exit;
    }
}

$page_title = sprintf($lang['editmessage'], $edit_msg);

html_draw_top("title=$page_title", "onUnload=clearFocus()", "resize_width=720", "basetarget=_blank", "attachments.js", "dictionary.js", "htmltools.js", "emoticons.js", "post.js", 'class=window_title');

echo "<h1>$page_title</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_edit\" action=\"edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("msg", htmlentities_array($edit_msg));
echo "  ", form_input_hidden("t_to_uid", htmlentities_array($to_uid));
echo "  ", form_input_hidden("t_from_uid", htmlentities_array($from_uid));
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\" class=\"max_width\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

$tools = new TextAreaHTML("f_edit");

if ($valid && isset($_POST['preview'])) {

    echo "            <table class=\"posthead\" width=\"720\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"left\" class=\"subhead\">{$lang['messagepreview']}</td>\n";
    echo "              </tr>\n";
    echo "              <tr>\n";
    echo "                <td align=\"left\"><br />", message_display($tid, $preview_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, false, false, false, $show_sigs, true), "</td>\n";
    echo "              </tr>\n";
    echo "              <tr>\n";
    echo "                <td align=\"left\">&nbsp;</td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
}

echo "            <table class=\"posthead\" width=\"720\">\n";
echo "              <tr>\n";
echo "                <td align=\"left\" class=\"subhead\" colspan=\"2\">", sprintf($lang['editmessage'], $edit_msg), "</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                  <table class=\"posthead\" width=\"210\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\">\n";
echo "                        <h2>{$lang['folder']}</h2>\n";
echo "                        ", word_filter_add_ob_tags(htmlentities_array($thread_data['FOLDER_TITLE'])), "\n";
echo "                        <h2>{$lang['threadtitle']}</h2>\n";
echo "                        ", word_filter_add_ob_tags(htmlentities_array($thread_data['TITLE'])), "\n";
echo "                        <h2>{$lang['to']}</h2>\n";

if ($preview_message['TLOGON'] != $lang['allcaps']) {

    echo "                        <a href=\"user_profile.php?webtag=$webtag&amp;uid=$to_uid\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']))), "</a><br /><br />\n";

}else {

    echo "                        ", word_filter_add_ob_tags(htmlentities_array(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']))), "<br /><br />\n";
}

echo "                        <h2>{$lang['messageoptions']}</h2>\n";
echo "                        ", form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled), "<br />\n";
echo "                        ", form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled), "<br />\n";
echo "                        ", form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled), "<br /><br />\n";

if (($user_emoticon_pack = session_get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack))) {

    echo "                    <br />\n";
    echo "                    <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'emots_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'emots_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                          <div class=\"emots_toggle\">{$emoticon_preview_html}</div>\n";
    } else {
        echo "                          <div class=\"emots_toggle\" style=\"display: none\">{$emoticon_preview_html}</div>\n";
    }

    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
}

echo "                      </td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "                <td align=\"left\" valign=\"top\" width=\"500\">\n";
echo "                  <table class=\"posthead\" width=\"500\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\">\n";
echo "                        <h2>{$lang['message']}</h2>\n";

$t_content = $post->getTidyContent();

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar(false, form_submit("apply", $lang['apply']));
} else {
    $tools->set_tinymce(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, true, 'tabindex="1"', 'post_content'), "\n";

if ($post->isDiff()) {

    echo $tools->compare_original("t_content", $post);

    if (($tools->get_tinymce())) {
        echo "<br />\n";
    } else {
        echo "<br /><br />\n";
    }
}

if ($allow_html == true) {

    if (($tools->get_tinymce())) {

        echo form_input_hidden("t_post_html", "enabled");

    } else {

        echo "<h2>{$lang['htmlinmessage']}</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED)." \n";
    }

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

if (($tools->get_tinymce())) {
    echo "<br />\n";
} else {
    echo "<br /><br />\n";
}

echo form_submit('apply',$lang['apply'], "tabindex=\"2\"");

echo "&nbsp;".form_submit("preview", $lang['preview'], "tabindex=\"3\"");

echo "&nbsp;<a href=\"discussion.php?webtag=$webtag&msg=$edit_msg\" class=\"button\" target=\"_self\"><span>{$lang['cancel']}</span></a>";

if (forum_get_setting('attachments_enabled', 'Y') && session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

    echo "&nbsp;<a href=\"attachments.php?aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>{$lang['attachments']}</span></a>\n";
    echo form_input_hidden('aid', htmlentities_array($aid));
}

if ($allow_sig == true) {

    echo "<br /><br /><table class=\"messagefoot\" width=\"486\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"subhead\">{$lang['signature']}</td>\n";

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'sig_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'sig_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" colspan=\"2\">\n";
    echo "      <div class=\"sig_toggle\" style=\"display: ", (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) ? "block" : "none", "\">\n";

    $t_sig = $sig->getTidyContent();

    echo $tools->textarea("t_sig", $t_sig, 5, 75, false, 'tabindex="7"', 'signature_content');

    if ($sig->isDiff()) {
        echo $tools->compare_original("t_sig", $sig);
    }

    echo "      </div>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    
    echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";
}

echo "</td></tr>\n";
echo "</table>";
echo "</td>\n";
echo "</tr>\n";
echo "<tr><td align=\"left\" colspan=\"2\">&nbsp;</td></tr>\n";
echo "</table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>";

html_draw_bottom();

?>
