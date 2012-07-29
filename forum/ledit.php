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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get Webtag
$webtag = get_webtag();

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

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Initialise Locale
lang_init();

// Check that we have access to this forum
if (!forum_check_access_level()) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {

    light_html_draw_top();
    light_html_guest_error();
    light_html_draw_bottom();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $edit_msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        light_html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {

    $edit_msg = $_POST['t_msg'];

    list($tid, $pid) = explode('.', $_POST['t_msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        light_html_draw_bottom();
        exit;
    }

}else {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("No message specified for editing"));
    light_html_draw_bottom();
    exit;
}

if (thread_is_poll($tid) && $pid == 1) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("Cannot edit polls in Mobile version"));
    light_html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {

    header_redirect("lmessages.php?webtag=$webtag&msg=$edit_msg");
    exit;
}

if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("You cannot edit posts in this folder"));
    light_html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid)) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
    light_html_draw_bottom();
    exit;
}

$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

$uid = session_get_value('UID');

$page_prefs = session_get_post_page_prefs();

$valid = true;

light_html_draw_top(sprintf("title=%s %s", gettext("Edit message"), $edit_msg), "robots=noindex,nofollow");

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
    } else {
        $post_html = POST_HTML_DISABLED;
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
$sig = new MessageText($sig_html, "", true, false, false);

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

        $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
        $valid = false;
    }

    $post->setContent($t_content);
    $t_content = $post->getContent();

    if (mb_strlen($t_content) >= 65535) {

        $error_msg_array[] = sprintf(gettext("Message length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_content)));
        $valid = false;
    }
}

if (isset($_POST['t_sig']) && strlen(trim(stripslashes_array($_POST['t_sig']))) > 0) {

    $t_sig = trim(stripslashes_array($_POST['t_sig']));

    if (attachments_embed_check($t_sig)) {

        $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
        $valid = false;
    }

    $sig->setContent($t_sig);
    $t_sig = $sig->getContent();

    if (mb_strlen($t_sig) >= 65535) {

        $error_msg_array[] = sprintf(gettext("Signature length must be under 65,535 characters (currently: %s)"), number_format(mb_strlen($t_sig)));
        $valid = false;
    }
}

if (isset($_POST['preview'])) {

    if (!$preview_message = messages_get($tid, $pid, 1)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_to_uid'])) {

        $to_uid = $_POST['t_to_uid'];

    }else {

        $error_msg_array[] = gettext("Invalid username!");
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {

        $from_uid = $_POST['t_from_uid'];

    }else {

        $error_msg_array[] = gettext("Invalid username!");
        $valid = false;
    }

    if (strlen(trim($t_content)) < 1) {

        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if ($valid) {

        $preview_message['CONTENT'] = $t_content;

        if ($allow_sig == true) {

            $preview_message['CONTENT'].= "<div class=\"sig\">$t_sig</div>";
        }

        if ($to_uid == 0) {

            $preview_message['TLOGON'] = gettext("ALL");
            $preview_message['TNICK'] = gettext("ALL");

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

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_to_uid'])) {
        $to_uid = $_POST['t_to_uid'];
    }else {
        $error_msg_array[] = gettext("Invalid username!");
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {
        $from_uid = $_POST['t_from_uid'];
    }else {
        $error_msg_array[] = gettext("Invalid username!");
        $valid = false;
    }

    if (strlen(trim($t_content)) < 1) {
        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    if (((forum_get_setting('allow_post_editing', 'N')) || ((session_get_value('UID') != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session_check_perm(USER_PERM_PILLORIED, 0)) || (((time() - $edit_message['CREATED']) >= (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)) && intval(forum_get_setting('post_edit_time', false, 0)) != 0)) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("You are not permitted to edit this message."));
        light_html_draw_bottom();
        exit;
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("You are not permitted to edit this message."));
        light_html_draw_bottom();
        exit;
    }

    $preview_message = $edit_message;

    if ($valid) {

        if ($allow_sig == true) {

            $t_content_tmp = $t_content."<div class=\"sig\">$t_sig</div>";

        }else {

            $t_content_tmp = $t_content;
        }

        if (post_update($t_fid, $tid, $pid, $t_content_tmp)) {

            post_add_edit_text($tid, $pid);

            post_save_attachment_id($tid, $pid, $aid);

            if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != session_get_value('UID')) {
                admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
            }

            header_redirect("lmessages.php?webtag=$webtag&msg=$edit_msg");
            exit;

        }else{

            $error_msg_array[] = gettext("Error updating post");
        }
    }

}else {

    if (!$edit_message = messages_get($tid, $pid, 1)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        light_html_draw_bottom();
        exit;
    }

    if (count($edit_message) > 0) {

        if (($edit_message['CONTENT'] = message_get_content($tid, $pid))) {

            if (((forum_get_setting('allow_post_editing', 'N')) || ((session_get_value('UID') != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session_check_perm(USER_PERM_PILLORIED, 0)) || (((time() - $edit_message['CREATED']) >= (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)) && intval(forum_get_setting('post_edit_time', false, 0)) != 0)) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
                light_html_display_error_msg(gettext("You are not permitted to edit this message."));
                light_html_draw_bottom();
                exit;
            }

            if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
                light_html_display_error_msg(gettext("You are not permitted to edit this message."));
                light_html_draw_bottom();
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

            echo sprintf("<h3>%s %s</h3>", gettext("Edit message"), $edit_msg);
            echo "<p>", gettext("Message was not found"), "</p>\n";
            exit;
        }

    }else{

        echo sprintf("<h3>%s %s</h3>", gettext("Edit message"), $edit_msg);
        echo "<p>", gettext("Message was not found"), "</p>\n";
        exit;
    }
}

if ($valid && isset($_POST['preview'])) {

    echo "<h3>", gettext("Message Preview"), "</h3>";

    light_message_display($tid, $preview_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, false, false, false, true);
}

echo "<form accept-charset=\"utf-8\" name=\"f_edit\" action=\"ledit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo form_input_hidden("t_msg", htmlentities_array($edit_msg));
echo form_input_hidden("t_to_uid", htmlentities_array($to_uid));
echo form_input_hidden("t_from_uid", htmlentities_array($from_uid));

echo "<div class=\"post\">\n";
echo sprintf("<h3>%s %s</h3>", gettext("Edit message"), $edit_msg);
echo "<div class=\"post_inner\">\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<div class=\"post_content\">", gettext("Content"), ":", light_form_textarea("t_content", $post->getTidyContent(), 10, 50), "</div>";

if ($allow_sig == true) {

    echo form_input_hidden("t_sig", $sig->getTidyContent());
    echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";
}

if ($allow_html == true) {

    $tph_radio = $post->getHTML();

    echo "<div class=\"post_html\"><span>", gettext("HTML in message"), ":</span>\n";
    echo light_form_radio("t_post_html", "disabled", gettext("Disabled"), $tph_radio == POST_HTML_DISABLED);
    echo light_form_radio("t_post_html", "enabled_auto", gettext("Enabled with auto-line-breaks"), $tph_radio == POST_HTML_AUTO);
    echo light_form_radio("t_post_html", "enabled", gettext("Enabled"), $tph_radio == POST_HTML_ENABLED);
    echo "</div>";

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("apply", gettext("Apply"));
echo light_form_submit("preview", gettext("Preview"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>";

echo "</div>";
echo "</div>";
echo "</form>\n";;

light_html_draw_bottom();

?>