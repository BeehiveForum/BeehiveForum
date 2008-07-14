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

/* $Id: post.php,v 1.344 2008-07-14 16:26:59 decoyduck Exp $ */

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

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
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

if (isset($_POST['cancel'])) {

    $uri = "discussion.php?webtag=$webtag";

    if (isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid']) ) {
        $uri.= "&msg={$_POST['t_tid']}.{$_POST['t_rpid']}";
    }elseif (isset($_GET['replyto']) && validate_msg($_POST['replyto'])) {
        $uri.= "&msg={$_GET['replyto']}";
    }

    header_redirect($uri);
}

// Check if the user is viewing signatures.

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Assume everything is A-OK!

$valid = true;

$new_thread = false;

$fix_html = true;

$t_to_uid = 0;

if (isset($_POST['t_newthread']) && (isset($_POST['post']) || isset($_POST['preview']))) {

    $new_thread = true;

    if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
    }else{
        $error_msg_array[] = $lang['mustenterthreadtitle'];
        $valid = false;
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $t_fid = $_POST['t_fid'];

        }else {

            $error_msg_array[] = $lang['cannotpostthisthreadtypeinfolder'];
            $valid = false;
        }

    }else if ($valid) {

        $error_msg_array[] = $lang['pleaseselectfolder'];
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

    $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);
    $links_enabled = ($page_prefs & POST_AUTO_LINKS);
    $spelling_enabled = ($page_prefs & POST_CHECK_SPELLING);

    if (($high_interest = bh_session_get_value('MARK_AS_OF_INT')) === false) {
        $high_interest = "N";
    }
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }

    $fetched_sig = false;

}else {

    // Fetch the current user's sig

    if (!user_get_sig($uid, $t_sig, $t_sig_html)) {

        $t_sig = '';
        $t_sig_html = 'Y';
    }

    if ($t_sig_html != "N") {
        $sig_html = 2;
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
    $t_dedupe = mktime();
}

if (!isset($sig_html)) $sig_html = 0;

if (isset($_POST['post']) || isset($_POST['preview'])) {

    $t_closed = isset($_POST['t_closed']) && $_POST['t_closed'] == 'Y' ? true : false;
    $t_sticky = isset($_POST['t_sticky']) && $_POST['t_sticky'] == 'Y' ? 'Y' : 'N';

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = trim(_stripslashes($_POST['t_content']));

        if (($post_html > POST_HTML_DISABLED) && attachment_embed_check($t_content)) {

            $error_msg_array[] = $lang['notallowedembedattachmentpost'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['mustenterpostcontent'];
        $valid = false;
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = trim(_stripslashes($_POST['t_sig']));

        if ($sig_html && attachment_embed_check($t_sig)) {

            $error_msg_array[] = $lang['notallowedembedattachmentsignature'];
            $valid = false;
        }
    }
}

if (isset($_POST['more'])) {

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {
        $t_content = trim(_stripslashes($_POST['t_content']));
    }
}

if (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x'])) {

    if (isset($_POST['t_newthread'])) {

        if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {

            $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

            if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

                $t_fid = $_POST['t_fid'];

            }else {

                $error_msg_array[] = $lang['cannotpostthisthreadtypeinfolder'];
                $valid = false;
            }
        }
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = trim(_stripslashes($_POST['t_content']));
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = trim(_stripslashes($_POST['t_sig']));
    }

    if (isset($_POST['emots_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }
}

if (!isset($t_content)) $t_content = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, $t_sig, true, false);

$t_content = $post->getContent();
$t_sig = $sig->getContent();

if (strlen($t_content) >= 65535) {

    $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(strlen($t_content)));
    $valid = false;
}

if (strlen($t_sig) >= 65535) {

    $error_msg_array[] = sprintf($lang['reducesiglength'], number_format(strlen($t_sig)));
    $valid = false;
}

if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

    list($reply_to_tid, $reply_to_pid) = explode(".", $_GET['replyto']);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top();
        html_error_msg($lang['cannotcreatepostinfolder']);
        html_draw_bottom();
        exit;
    }

    if (isset($_GET['quote_list']) && strlen(trim($_GET['quote_list'])) > 0) {

        $quote_list = preg_grep('/[0-9]+/', explode(',', $_GET['quote_list']));

        sort($quote_list);

        $t_content_array = array();

        foreach($quote_list as $quote_pid) {

            if ($message_array = messages_get($reply_to_tid, $quote_pid)) {

                $message_author = _htmlentities(format_user_name($message_array['FLOGON'], $message_array['FNICK']));

                $message_content = message_get_content($reply_to_tid, $quote_pid);
                $message_content = message_apply_formatting($message_content, false, true);

                if ($page_prefs & POST_TINYMCE_DISPLAY) {

                    $t_quoted_post = "<div class=\"quotetext\" id=\"quote\">";
                    $t_quoted_post.= "<b>quote: </b>$message_author</div>";
                    $t_quoted_post.= "<div class=\"quote\">";
                    $t_quoted_post.= trim(strip_tags(strip_paragraphs($message_content)));
                    $t_quoted_post.= "</div><p>&nbsp;</p>";

                }else {

                    $t_quoted_post = "<quote source=\"$message_author\" ";
                    $t_quoted_post.= "url=\"messages.php?webtag=$webtag&amp;msg=$reply_to_tid.$quote_pid\">";
                    $t_quoted_post.= trim(strip_tags(strip_paragraphs($message_content))). "</quote>\n\n";
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

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top();
        html_error_msg($lang['cannotcreatepostinfolder']);
        html_draw_bottom();
        exit;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
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

        $error_msg_array[] = $lang['invalidfolderid'];
        $valid = false;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (isset($t_fid) && !bh_session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = $lang['cannotcreatethreadinfolder'];
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
        $valid = false;
    }
}

if (isset($_POST['to_radio']) && strlen(trim(_stripslashes($_POST['to_radio']))) > 0) {
    $to_radio = trim(_stripslashes($_POST['to_radio']));
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

if (isset($_POST['t_to_uid_others']) && strlen(trim(_stripslashes($_POST['t_to_uid_others']))) > 0) {
    $t_to_uid_others = trim(_stripslashes($_POST['t_to_uid_others']));
}else {
    $t_to_uid_others = '';
}

if ($to_radio == 'others') {

    if ($to_user = user_get_uid($t_to_uid_others)) {

        $t_to_uid = $to_user['UID'];

    }else{

        $error_msg_array[] = $lang['invalidusername'];
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

if (isset($t_fid) && !bh_session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !bh_session_check_perm(USER_PERM_SIGNATURE, $t_fid)) {
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

        html_draw_top();
        html_error_msg($lang['postdoesnotexist']);
        html_draw_bottom();
        exit;
    }

    if (!$thread_data = thread_get($reply_to_tid)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => "$reply_to_tid.$reply_to_pid"));
        html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {

        html_draw_top();
        html_error_msg($lang['messagehasbeendeleted'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => "$reply_to_tid.$reply_to_pid"));
        html_draw_bottom();
        exit;
    }
}

if ($valid && isset($_POST['post'])) {

    if (check_post_frequency()) {

        if (check_ddkey($t_dedupe)) {

            if ($new_thread) {

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

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

                if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && (!bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid))) {

                    html_draw_top();
                    html_error_msg($lang['threadisclosedforposting'], 'discussion.php', 'post', array('back' => $lang['back']), array('msg' => "$t_tid.$t_rpid"));
                    html_draw_bottom();
                    exit;
                }

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

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
                    $t_content.= "\n<div class=\"sig\">$t_sig</div>";
                }

                if ($new_thread) {
                    $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $uid, $t_to_uid, $t_content);
                }else {
                    $new_pid = post_create($t_fid, $t_tid, $t_rpid, $thread_data['BY_UID'], $uid, $t_to_uid, $t_content);
                }

                if ($new_pid > -1) {

                    $user_rel = user_get_relationship($t_to_uid, $uid);

                    if ($high_interest == "Y") thread_set_high_interest($t_tid);

                    if (!bh_session_check_perm(USER_PERM_WORMED, 0) && !($user_rel & USER_IGNORED_COMPLETELY)) {

                        $exclude_user_array = array($t_to_uid, $uid);

                        email_sendnotification($t_to_uid, $uid, $t_tid, $new_pid);

                        email_send_folder_subscription($t_to_uid, $uid, $t_fid, $t_tid, $new_pid, $exclude_user_array);

                        if (isset($thread_data['MODIFIED']) && $thread_data['MODIFIED'] > 0) {

                            email_send_thread_subscription($t_to_uid, $uid, $t_tid, $new_pid, $thread_data['MODIFIED'], $exclude_user_array);
                        }
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

            $error_msg_array[] = $lang['errorcreatingpost'];
        }

    }else {

        $error_msg_array[] = sprintf($lang['postfrequencytoogreat'], forum_get_setting('minimum_post_frequency', false, 0));
    }
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if ($new_thread && !$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "", FOLDER_ALLOW_NORMAL_THREAD, "", "post_folder_dropdown")) {

    html_draw_top();
    html_error_msg($lang['cannotcreatenewthreads']);
    html_draw_bottom();
    exit;
}

if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    html_draw_top();
    html_error_msg($lang['threadisclosedforposting']);
    html_draw_bottom();
    exit;
}

html_draw_top("onUnload=clearFocus()", "resize_width=720", "basetarget=_blank", "post.js", "attachments.js", "poll.js", "openprofile.js", "htmltools.js", "emoticons.js", "dictionary.js");

echo "<h1>{$lang['postmessage']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

if (!$new_thread && isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 && bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
    html_display_warning_msg($lang['moderatorthreadclosed'], '720', 'left');
}

echo "<br /><form name=\"f_post\" action=\"post.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('t_dedupe', _htmlentities($t_dedupe)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

$tools = new TextAreaHTML("f_post");

echo $tools->preload();

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['messagepreview']}</td>\n";
    echo "                </tr>\n";

    if ($t_to_uid == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

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

    $preview_message['CREATED'] = mktime();
    $preview_message['AID'] = $aid;

    echo "                <tr>\n";
    echo "                  <td align=\"left\">\n";

    echo message_display(0, $preview_message, 0, 0, 0, true, false, false, false, $show_sigs, true);

    echo "                  </td>\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['createnewthread']}</td>\n";
    echo "                </tr>\n";

}else{

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['postreply']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\" cellpadding=\"0\">\n";

if ($new_thread) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['folder']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">$folder_dropdown</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['threadtitle']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_input_text("t_threadtitle", _htmlentities($t_threadtitle), 0, 0, false, "thread_title"), form_input_hidden("t_newthread", "Y"), "</td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['folder']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", word_filter_add_ob_tags(_htmlentities($thread_data['FOLDER_TITLE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['threadtitle']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", word_filter_add_ob_tags(_htmlentities(thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']))), form_input_hidden("t_tid", _htmlentities($reply_to_tid)), form_input_hidden("t_rpid", _htmlentities($reply_to_pid)), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['to']}</h2></td>\n";
echo "                      </tr>\n";

if (!$new_thread) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_radio("to_radio", "in_thread", $lang['usersinthread'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", post_draw_to_dropdown_in_thread($reply_to_tid, $t_to_uid, true, false, 'onclick="checkToRadio(0)"'), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("to_radio", "recent", $lang['recentvisitors'], $new_thread ? true : false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", post_draw_to_dropdown_recent($new_thread ? $t_to_uid : 0), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_radio("to_radio", "others", $lang['others']), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text("t_to_uid_others", "", 0, 0, "onclick=\"checkToRadio(". ($new_thread ? 1 : 2). ")\"", "post_to_others"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;obj_name=t_to_uid_others\" onclick=\"return openLogonSearch('$webtag', 't_to_uid_others');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['messageoptions']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_interest", "Y", $lang['setthreadtohighinterest'], $high_interest == "Y"), "</td>\n";
echo "                      </tr>\n";

if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['admin']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_closed", "Y", $lang['closeforposting'], isset($t_closed) ? $t_closed == 'Y' : isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0 ? true : false), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_sticky", "Y", $lang['makesticky'], isset($t_sticky) ? $t_sticky == 'Y' : isset($thread_data['STICKY']) && $thread_data['STICKY'] == "Y" ? true : false), "</td>\n";
    echo "                      </tr>\n";
}

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

        echo "                              <td class=\"subhead\" align=\"right\">". form_submit_image('emots_hide.png', 'emots_toggle', 'hide'). "&nbsp;</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "                              <td class=\"subhead\" align=\"right\">". form_submit_image('emots_show.png', 'emots_toggle', 'show'). "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                          </table>\n";
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"500\">\n";
echo "                    <table class=\"posthead\" width=\"500\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>{$lang['message']}</h2>\n";

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar(false, form_submit("post", $lang['post'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));
}else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "tabindex=\"1\"", "post_content"), "\n";

if ($post->isDiff() && $fix_html) {

    echo $tools->compare_original("t_content", $post->getOriginalContent());

    if ($tools->getTinyMCE()) {
        echo "  <br />\n";
    }else {
        echo "  <br /><br />\n";
    }
}

if ($allow_html == true) {

    if ($tools->getTinyMCE()) {

        echo form_input_hidden("t_post_html", "enabled");

    }else {

        echo "                          <h2>{$lang['htmlinmessage']}</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {

            echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
        }
    }

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

// SUBMIT BUTTONS

if ($tools->getTinyMCE()) {
    echo "  <br />\n";
}else {
    echo "  <br /><br />\n";
}

echo form_submit("post", $lang['post'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "  &nbsp;".form_submit("preview", $lang['preview'], "tabindex=\"3\" onclick=\"clearFocus()\"");
echo "  &nbsp;".form_submit("cancel", $lang['cancel'], "tabindex=\"4\" onclick=\"closeAttachWin(); clearFocus()\"");

if (forum_get_setting('attachments_enabled', 'Y') && (bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid) || $new_thread)) {

    echo "  &nbsp;".form_button("attachments", $lang['attachments'], "tabindex=\"5\" onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", _htmlentities($aid));
}

if ($allow_sig == true) {

    echo "                          <br /><br />\n";
    echo "                          <table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\">{$lang['signature']}</td>\n";

    $t_sig = ($fix_html ? $sig->getTidyContent() : $sig->getOriginalContent());

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {

        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('sig_hide.png', 'sig_toggle', 'hide'). "&nbsp;</td>\n";
        echo "                            </tr>\n";
        echo "                            <tr>\n";
        echo "                              <td align=\"left\" colspan=\"2\">", $tools->textarea("t_sig", $t_sig, 5, 75, "virtual", "tabindex=\"7\"", "signature_content"), form_input_hidden("t_sig_html", _htmlentities($sig->getHTML()) ? "Y" : "N"), "</td>\n";


        if ($sig->isDiff() && $fix_html && !$fetched_sig) {
            echo $tools->compare_original("t_sig", $sig->getOriginalContent());
        }

    }else {

        echo "                              <td class=\"subhead\" align=\"right\">", form_submit_image('sig_show.png', 'sig_toggle', 'show'), form_input_hidden("t_sig", $t_sig), "&nbsp;</td>\n";
    }

    echo "                            </tr>\n";
    echo "                          </table>\n";
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
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['inreplyto']}</td>\n";
    echo "                </tr>\n";


    if (($thread_data['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">\n";

        echo  poll_display($reply_to_tid, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], false, false, false, true, $show_sigs, true);

        echo "                  </td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">\n";

        echo message_display($reply_to_tid, $reply_message, $thread_data['LENGTH'], $reply_to_pid, $thread_data['FID'], true, false, false, false, $show_sigs, true);

        echo "                 </td>\n";
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
    echo "      <td align=\"center\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"index.php?webtag=$webtag&amp;msg={$thread_data['TID']}.1\" target=\"_blank\" title=\"{$lang['reviewthreadinnewwindow']}\">{$lang['reviewthread']}</a></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo $tools->js();

echo "</form>\n";

html_draw_bottom();

?>