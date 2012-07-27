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
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag
$webtag = get_webtag();

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
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Initialise Locale
lang_init();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {
    html_guest_error();
    exit;
}

// Check that there are some available folders for this thread type
if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    html_message_type_error();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

// Get the user's post page preferences.
$page_prefs = session_get_post_page_prefs();

// Get the user's UID
$uid = session_get_value('UID');

// Assume everything is A-OK!
$valid = true;

$new_thread = false;

$t_to_uid = 0;

if (isset($_POST['t_newthread']) && (isset($_POST['post']) || isset($_POST['preview']))) {

    $new_thread = true;

    if (isset($_POST['t_threadtitle']) && strlen(trim(stripslashes_array($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(stripslashes_array($_POST['t_threadtitle']));
    }else{
        $error_msg_array[] = gettext("You must enter a title for the thread!");
        $valid = false;
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $t_fid = $_POST['t_fid'];

        }else {

            $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
            $valid = false;
        }

    }else if ($valid) {

        $error_msg_array[] = gettext("Please select a folder");
        $valid = false;
    }

}else if (!isset($_POST['t_tid'])) {

    $valid = false;
}

if (isset($_POST['t_post_emots'])) {

    if ($_POST['t_post_emots'] == "disabled") {
        $emots_enabled = false;
    }else {
        $emots_enabled = true;
    }

}else {

    $emots_enabled = true;
}

if (isset($_POST['t_check_spelling'])) {

    if ($_POST['t_check_spelling'] == "enabled") {
        $spelling_enabled = true;
    }else {
        $spelling_enabled = false;
    }

}else {

    $spelling_enabled = false;
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

if (isset($_POST['t_post_interest'])) {

    if ($_POST['t_post_interest'] == "Y") {
        $high_interest = "Y";
    }else {
        $high_interest = "N";
    }

}else {

    $high_interest = "N";
}

if (isset($_POST['t_sticky'])) {

    if ($_POST['t_sticky'] == 'Y') {
        $t_sticky = 'Y';
    }else {
        $t_sticky = 'N';
    }
}

if (isset($_POST['t_closed'])) {

    if ($_POST['t_closed'] == 'Y') {
        $t_closed = 'Y';
    }else {
        $t_closed = 'N';
    }
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

    if (($page_prefs & POST_CHECK_SPELLING) > 0) {
        $spelling_enabled = true;
    }else {
        $spelling_enabled = false;
    }

    if (($high_interest = session_get_value('MARK_AS_OF_INT')) === false) {
        $high_interest = "N";
    }
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $fetched_sig = false;

}else {

    $t_sig = '';
    $t_sig_html = 'N';

    if (!user_get_sig($uid, $t_sig, $t_sig_html)) {

        $t_sig = '';
        $t_sig_html = 'N';
    }

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(mt_rand()));
}

if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
}else{
    $t_dedupe = time();
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

if (isset($_POST['post']) || isset($_POST['preview'])) {

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = trim(stripslashes_array($_POST['t_content']));

        if (($post_html > POST_HTML_DISABLED) && attachments_embed_check($t_content)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your posts.");
            $valid = false;
        }

    }else {

        $error_msg_array[] = gettext("You must enter some content for the post!");
        $valid = false;
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = trim(stripslashes_array($_POST['t_sig']));

        if ($sig_html && attachments_embed_check($t_sig)) {

            $error_msg_array[] = gettext("You are not allowed to embed attachments in your signature.");
            $valid = false;
        }
    }
}

if (isset($_POST['more'])) {

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {
        $t_content = trim(stripslashes_array($_POST['t_content']));
    }
}

if (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['t_newthread'])) {

        if (isset($_POST['t_threadtitle']) && strlen(trim(stripslashes_array($_POST['t_threadtitle']))) > 0) {

            $t_threadtitle = trim(stripslashes_array($_POST['t_threadtitle']));
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

            if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

                $t_fid = $_POST['t_fid'];

            }else {

                $error_msg_array[] = gettext("You cannot post this thread type in that folder!");
                $valid = false;
            }
        }
    }

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = trim(stripslashes_array($_POST['t_content']));
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = trim(stripslashes_array($_POST['t_sig']));
    }

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
        $valid = false;
    }
}

if (!isset($t_content)) $t_content = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, $t_sig, $emots_enabled, $links_enabled, false);

$t_content = $post->getContent();
$t_sig = $sig->getContent();

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

        html_draw_top(sprintf("title=%s", gettext("The requested thread could not be found or access was denied.")));
        html_error_msg(gettext("The requested thread could not be found or access was denied."));
        html_draw_bottom();
        exit;
    }

    if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top(sprintf("title=%s", gettext("You cannot reply to posts in this folder")));
        html_error_msg(gettext("You cannot reply to posts in this folder"));
        html_draw_bottom();
        exit;
    }

    if (isset($_GET['quote_list']) && strlen(trim($_GET['quote_list'])) > 0) {

        $quote_list = array_filter(explode(',', $_GET['quote_list']), 'is_numeric');

        sort($quote_list);

        $t_content_array = array();

        foreach ($quote_list as $quote_pid) {

            if (($message_array = messages_get($reply_to_tid, $quote_pid))) {

                $message_author = htmlentities_array(format_user_name($message_array['FLOGON'], $message_array['FNICK']));

                $message_content = message_get_content($reply_to_tid, $quote_pid);
                $message_content = message_apply_formatting($message_content, false, true);
                
                $message_content = trim(strip_tags(strip_paragraphs($message_content)));                
                $message_content = preg_replace("/(\r\n|\r|\n){2,}/", "\r\n\r\n", $message_content);

                if ($page_prefs & POST_TINYMCE_DISPLAY) {

                    $t_quoted_post = "<div class=\"quotetext\" id=\"quote\">";
                    $t_quoted_post.= "<b>quote: </b>$message_author</div>";
                    $t_quoted_post.= "<div class=\"quote\">". trim($message_content). "</div><br />";

                }else {

                    $t_quoted_post = "<quote source=\"$message_author\" ";
                    $t_quoted_post.= "url=\"messages.php?webtag=$webtag&amp;msg=$reply_to_tid.$quote_pid\">";
                    $t_quoted_post.= trim($message_content). "</quote>\n\n";
                }

                $t_content_array[] = $t_quoted_post;
            }
        }

        if (sizeof($t_content_array) > 0) {

            $post->setContent(implode('', $t_content_array));
            $post->setHTML(POST_HTML_AUTO);
        }
    }

    $new_thread = false;

}elseif (isset($_POST['t_tid']) && isset($_POST['t_rpid'])) {

    $reply_to_tid = (is_numeric($_POST['t_tid']) ? $_POST['t_tid'] : 0);
    $reply_to_pid = (is_numeric($_POST['t_rpid']) ? $_POST['t_rpid'] : 0);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top(sprintf("title=%s", gettext("The requested thread could not be found or access was denied.")));
        html_error_msg(gettext("The requested thread could not be found or access was denied."));
        html_draw_bottom();
        exit;
    }

    if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top(sprintf("title=%s", gettext("You cannot reply to posts in this folder")));
        html_error_msg(gettext("You cannot reply to posts in this folder"));
        html_draw_bottom();
        exit;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }

    $new_thread = false;

}else{

    $new_thread = true;

    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $t_fid = $_GET['fid'];
    }elseif (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
        $t_fid = $_POST['t_fid'];
    }

    if (isset($t_fid) && !folder_is_valid($t_fid)) {

        $error_msg_array[] = gettext("Invalid Folder ID. Check that a folder with this ID exists!");
        $valid = false;
    }

    if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (isset($t_fid) && !session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot create new threads in this folder");
        $valid = false;
    }

    if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = gettext("You cannot post attachments in this folder. Remove attachments to continue.");
        $valid = false;
    }
}

if (isset($_POST['to_radio']) && strlen(trim(stripslashes_array($_POST['to_radio']))) > 0) {
    $to_radio = trim(stripslashes_array($_POST['to_radio']));
}else {
    $to_radio = '';
}

if (isset($_POST['t_to_uid_in_thread']) && is_numeric($_POST['t_to_uid_in_thread'])) {
    $t_to_uid_in_thread = $_POST['t_to_uid_in_thread'];
}else {
    $t_to_uid_in_thread = '';
}

if (isset($_POST['t_to_uid_recent']) && is_numeric($_POST['t_to_uid_recent'])) {
    $t_to_uid_recent = $_POST['t_to_uid_recent'];
}else {
    $t_to_uid_recent = '';
}

if (isset($_POST['t_to_uid_others']) && strlen(trim(stripslashes_array($_POST['t_to_uid_others']))) > 0) {
    $t_to_uid_others = trim(stripslashes_array($_POST['t_to_uid_others']));
}else {
    $t_to_uid_others = '';
}

if ($to_radio == 'others') {

    if (($to_user = user_get_by_logon($t_to_uid_others))) {

        $t_to_uid = $to_user['UID'];

    }else{

        $error_msg_array[] = gettext("Invalid username!");
        $valid = false;
    }

}else if ($to_radio == 'in_thread') {

    $t_to_uid = $t_to_uid_in_thread;

}else if ($to_radio == 'recent') {

    $t_to_uid = $t_to_uid_recent;

}else if (isset($reply_to_tid) && isset($reply_to_pid)) {

    if (!$t_to_uid = message_get_user($reply_to_tid, $reply_to_pid)) {
        $t_to_uid = 0;
    }
}

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

if (!$new_thread) {

    if (!$reply_message = messages_get($reply_to_tid, $reply_to_pid)) {

        html_draw_top(sprintf("title=%s", gettext("That post does not exist in this thread!")));
        html_error_msg(gettext("That post does not exist in this thread!"));
        html_draw_bottom();
        exit;
    }

    if (!$thread_data = thread_get($reply_to_tid)) {

        html_draw_top(sprintf("title=%s", gettext("The requested thread could not be found or access was denied.")));
        html_error_msg(gettext("The requested thread could not be found or access was denied."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => "$reply_to_tid.$reply_to_pid"));
        html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {

        html_draw_top(sprintf("title=%s", gettext("Message not found. Check that it hasn't been deleted.")));
        html_error_msg(gettext("Message not found. Check that it hasn't been deleted."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => "$reply_to_tid.$reply_to_pid"));
        html_draw_bottom();
        exit;
    }
}

if ($valid && isset($_POST['post'])) {

    if (post_check_frequency()) {

        if (post_check_ddkey($t_dedupe)) {

            if ($new_thread) {

                if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                    $t_closed = isset($_POST['t_closed']) && $_POST['t_closed'] == 'Y' ? true : false;
                    $t_sticky = isset($_POST['t_sticky']) && $_POST['t_sticky'] == 'Y' ? 'Y' : 'N';

                }else {

                    $t_closed = false;
                    $t_sticky = "N";
                }

                $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle, "N", $t_sticky, $t_closed);
                $t_rpid = 0;

            }else{

                $t_tid  = (isset($_POST['t_tid']) && is_numeric($_POST['t_tid'])) ? $_POST['t_tid'] : 0;
                $t_rpid = (isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid'])) ? $_POST['t_rpid'] : 0;

                if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && (!session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid))) {

                    html_draw_top(sprintf("title=%s", gettext("This thread is closed, you cannot post in it!")));
                    html_error_msg(gettext("This thread is closed, you cannot post in it!"), 'discussion.php', 'post', array('back' => gettext("Back")), array('msg' => "$t_tid.$t_rpid"));
                    html_draw_bottom();
                    exit;
                }

                if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                    $t_closed = isset($_POST['t_closed']) && $_POST['t_closed'] == 'Y' ? true : false;
                    $t_sticky = isset($_POST['t_sticky']) && $_POST['t_sticky'] == 'Y' ? 'Y' : 'N';

                    if (isset($t_closed) && $t_closed == "Y") {
                        thread_set_closed($t_tid, true);
                    }else {
                        thread_set_closed($t_tid, false);
                    }

                    if (isset($t_sticky) && $t_sticky == "Y") {
                        thread_set_sticky($t_tid, true);
                    }else {
                        thread_set_sticky($t_tid, false);
                    }
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

                    if (!session_check_perm(USER_PERM_WORMED, 0) && !($user_rel & USER_IGNORED_COMPLETELY)) {

                        $exclude_user_array = array($t_to_uid, $uid);

                        $thread_modified = (isset($thread_data['MODIFIED']) && is_numeric($thread_data['MODIFIED'])) ? $thread_data['MODIFIED'] : 0;

                        email_sendnotification($t_to_uid, $uid, $t_tid, $new_pid);

                        email_send_folder_subscription($uid, $t_fid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);

                        email_send_thread_subscription($uid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);
                    }

                    post_save_attachment_id($t_tid, $new_pid, $aid);
                }
            }

        }else {

            $new_pid = 0;

            $t_tid  = (isset($_POST['t_tid']) && is_numeric($_POST['t_tid'])) ? $_POST['t_tid'] : 0;
            $t_rpid = (isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid'])) ? $_POST['t_rpid'] : 0;
        }

        if ($new_pid > -1) {

            if ($new_thread && $t_tid > 0) {

                $uri = "discussion.php?webtag=$webtag&msg=$t_tid.1";

            }else {

                if ($t_tid > 0 && $t_rpid > 0) {
                    $uri = "discussion.php?webtag=$webtag&msg=$t_tid.$t_rpid";
                }else{
                    $uri = "discussion.php?webtag=$webtag";
                }
            }

            header_redirect($uri);
            exit;

        }else{

            $error_msg_array[] = gettext("Error creating post! Please try again in a few minutes.");
        }

    }else {

        $error_msg_array[] = sprintf(gettext("You can only post once every %s seconds. Please try again later."), forum_get_setting('minimum_post_frequency', false, 0));
    }
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if (($new_thread && !$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "", FOLDER_ALLOW_NORMAL_THREAD, USER_PERM_THREAD_CREATE, "", "post_folder_dropdown"))) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("You cannot create new threads."));
    html_draw_bottom();
    exit;
}

if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    html_draw_top(sprintf("title=%s", gettext("This thread is closed, you cannot post in it!")));
    html_error_msg(gettext("This thread is closed, you cannot post in it!"));
    html_draw_bottom();
    exit;
}

html_draw_top(sprintf("title=%s", gettext("Post message")), "onUnload=clearFocus()", "resize_width=720", "basetarget=_blank", "post.js", "attachments.js", "htmltools.js", "emoticons.js", "dictionary.js", 'search.js', 'search_popup.js', 'class=window_title');

echo "<h1>", gettext("Post message"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

if (!$new_thread && isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
    html_display_warning_msg(gettext("Warning: this thread is closed for posting to normal users."), '720', 'left');
}

echo "<br /><form accept-charset=\"utf-8\" name=\"f_post\" action=\"post.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('t_dedupe', htmlentities_array($t_dedupe)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\" class=\"max_width\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

$tools = new TextAreaHTML("f_post");

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Message Preview"), "</td>\n";
    echo "                </tr>\n";

    if ($t_to_uid == 0) {

        $preview_message['TLOGON'] = gettext("ALL");
        $preview_message['TNICK'] = gettext("ALL");

    }else if ($t_to_uid > 0) {

        $preview_tuser = user_get($t_to_uid);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['TO_UID'] = $preview_tuser['UID'];

    }

    $preview_tuser = user_get($uid);
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    $preview_message['CONTENT'] = $post->getContent();

    if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    $preview_message['CREATED'] = time();
    $preview_message['AID'] = $aid;

    echo "                <tr>\n";
    echo "                  <td align=\"left\"><br />", message_display(0, $preview_message, 0, 0, 0, false, false, false, false, $show_sigs, true), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

if (!isset($t_threadtitle)) $t_threadtitle = "";

echo "              <table class=\"posthead\" width=\"720\">\n";

if ($new_thread) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Create new thread"), "</td>\n";
    echo "                </tr>\n";

}else{

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Post Reply"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\" cellpadding=\"0\">\n";

if ($new_thread) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>", gettext("Folder"), "</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">$folder_dropdown</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>", gettext("Thread title"), "</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_input_text("t_threadtitle", htmlentities_array($t_threadtitle), 0, 0, false, "thread_title"), form_input_hidden("t_newthread", "Y"), "</td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>", gettext("Folder"), "</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", word_filter_add_ob_tags($thread_data['FOLDER_TITLE'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>", gettext("Thread title"), "</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", word_filter_add_ob_tags($thread_data['TITLE'], true), form_input_hidden("t_tid", htmlentities_array($reply_to_tid)), form_input_hidden("t_rpid", htmlentities_array($reply_to_pid)), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("To"), "</h2></td>\n";
echo "                      </tr>\n";

if (!$new_thread) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_radio("to_radio", "in_thread", gettext("Users in thread"), true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", post_draw_to_dropdown_in_thread($reply_to_tid, $t_to_uid, true, false), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("to_radio", "recent", gettext("Recent Visitors"), $new_thread ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", post_draw_to_dropdown_recent($t_to_uid, $new_thread), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("to_radio", "others", gettext("Others")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search("t_to_uid_others", "", false, false, SEARCH_LOGON, false, "", "post_to_others"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>", gettext("Message options"), "</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_links", "enabled", gettext("Automatically parse URLs"), $links_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_check_spelling", "enabled", gettext("Automatically check spelling"), $spelling_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_emots", "disabled", gettext("Disable emoticons"), !$emots_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_interest", "Y", gettext("Set thread to high interest"), $high_interest == "Y"), "</td>\n";
echo "                      </tr>\n";

if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>", gettext("Admin"), "</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_closed", "Y", gettext("Close for posting"), isset($t_closed) ? $t_closed == 'Y' : isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 ? true : false), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_sticky", "Y", gettext("Make sticky"), isset($t_sticky) ? $t_sticky == 'Y' : isset($thread_data['STICKY']) && $thread_data['STICKY'] == "Y" ? true : false), "</td>\n";
    echo "                      </tr>\n";
}

if (($user_emoticon_pack = session_get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack))) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Emoticons"), "</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'emots_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'emots_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" colspan=\"2\">\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                                <div class=\"emots_toggle\">{$emoticon_preview_html}</div>\n";
    } else {
        echo "                                <div class=\"emots_toggle\" style=\"display: none\">{$emoticon_preview_html}</div>\n";
    }

    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"500\">\n";
echo "                    <table class=\"posthead\" width=\"500\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>", gettext("Message"), "</h2>\n";

$t_content = $post->getTidyContent();

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar(false, form_submit("post", gettext("Post")));
}else {
    $tools->set_tinymce(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, true, 'tabindex="1"', 'post_content'), "\n";

if ($post->isDiff()) {

    echo $tools->compare_original("t_content", $post);

    if (($tools->get_tinymce())) {
        echo "  <br />\n";
    }else {
        echo "  <br /><br />\n";
    }
}

if ($allow_html == true) {

    if (($tools->get_tinymce())) {

        echo form_input_hidden("t_post_html", "enabled");

    }else {

        echo "                          <h2>", gettext("HTML in message"), "</h2>\n";

        echo form_radio("t_post_html", "disabled", gettext("Disabled"), $post->getHTML() == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", gettext("Enabled with auto-line-breaks"), $post->getHTML() == POST_HTML_AUTO)." \n";
        echo form_radio("t_post_html", "enabled", gettext("Enabled"), $post->getHTML() == POST_HTML_ENABLED)." \n";
    }

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

// SUBMIT BUTTONS
if (($tools->get_tinymce())) {
    echo "  <br />\n";
}else {
    echo "  <br /><br />\n";
}

echo form_submit("post", gettext("Post"), "tabindex=\"2\"");

echo "&nbsp;", form_submit("preview", gettext("Preview"), "tabindex=\"3\"");

if (isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid']) ) {
    echo "&nbsp;<a href=\"discussion.php?webtag=$webtag&amp;msg={$_POST['t_tid']}.{$_POST['t_rpid']}\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>";
} else if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {
    echo "&nbsp;<a href=\"discussion.php?webtag=$webtag&amp;msg={$_GET['replyto']}\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>";
} else {
    echo "&nbsp;<a href=\"discussion.php?webtag=$webtag\" class=\"button\" target=\"_self\"><span>", gettext("Cancel"), "</span></a>";
}

if (forum_get_setting('attachments_enabled', 'Y') && (session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid) || $new_thread)) {

    echo "&nbsp;<a href=\"attachments.php?aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
    echo form_input_hidden("aid", htmlentities_array($aid));
}

if ($allow_sig == true) {

    echo "                          <br /><br />\n";
    echo "                          <table class=\"messagefoot\" width=\"486\" cellspacing=\"0\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">", gettext("Signature"), "</td>\n";

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'sig_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'sig_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" colspan=\"2\">\n";
    echo "                                <div class=\"sig_toggle\" style=\"display: ", (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) ? "block" : "none", "\">\n";

    $t_sig = $sig->getTidyContent();

    echo $tools->textarea("t_sig", $t_sig, 5, 75, false, 'tabindex="7"', 'signature_content');

    if ($sig->isDiff() && !$fetched_sig) {
        echo $tools->compare_original("t_sig", $sig);
    }

    echo "                                </div>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                          ", form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";
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

if (!$new_thread && $reply_to_pid > 0) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("In reply to"), "</td>\n";
    echo "                </tr>\n";


    if (($thread_data['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\"><br />", poll_display($reply_to_tid, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], false, false, false, $show_sigs, true), "</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\"><br />", message_display($reply_to_tid, $reply_message, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], false, false, false, false, $show_sigs, true), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

if (!$new_thread) {

    echo "  <br />\n";
    echo "  <table  width=\"720\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\"><img src=\"", html_style_image('current_thread.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"index.php?webtag=$webtag&amp;msg={$thread_data['TID']}.1\" target=\"_blank\" title=\"", gettext("Review entire thread in new window"), "\">", gettext("Review Thread"), "</a></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "</form>\n";

html_draw_bottom();

?>