<?php

/*======================================================================

Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA

======================================================================*/

/* $Id: post.php,v 1.274 2006-06-30 18:07:33 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
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

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check that there are some available folders for this thread type
if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    html_message_type_error();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "./discussion.php?webtag=$webtag";

    if (isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid']) ) {
        $uri.= "&msg={$_POST['t_tid']}.{$_POST['t_rpid']}";
    }elseif (isset($_GET['replyto']) && validate_msg($_POST['replyto'])) {
        $uri.= "&msg={$_GET['replyto']}";
    }

    header_redirect($uri);
}

// for "REPLY ALL" form button on messages.php
if (isset($_POST['replyto'])) {
    $_GET['replyto'] = $_POST['replyto'];
}

// Check if the user is viewing signatures.

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Assume everything is A-OK!

$valid = true;

$newthread = false;

$fix_html = true;

$t_to_uid_others = "";

if (isset($_POST['to_radio'])) {

    $to_radio = $_POST['to_radio'];

    if ($to_radio == "others") {

        $t_to_uid_others = $_POST['t_to_uid_others'];

        if ($to_user = user_get_uid($t_to_uid_others)) {

            $_POST['t_to_uid'] = $to_user['UID'];
            $t_to_uid = $to_user['UID'];

        }else{

            $error_html = "<h2>{$lang['invalidusername']}</h2>";
            $valid = false;
        }
    }else if ($to_radio == "in_thread") {

        $t_to_uid = $_POST['t_to_uid_in_thread'];
        $_POST['t_to_uid'] = $t_to_uid;

    }else {

        $t_to_uid = $_POST['t_to_uid_recent'];
        $_POST['t_to_uid'] = $t_to_uid;
    }
}

if (isset($_POST['t_newthread']) && (isset($_POST['submit']) || isset($_POST['preview']))) {

    $newthread = true;

    if (isset($_POST['t_threadtitle']) && trim(_stripslashes($_POST['t_threadtitle']) != "")) {
        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
    }else{
        $error_html = "<h2>{$lang['mustenterthreadtitle']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $t_fid = $_POST['t_fid'];

        }else {

            $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
            $valid = false;
        }

    }else if ($valid) {

        $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>";
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

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = 1;
    }else if ($t_post_html == "enabled") {
        $post_html = 2;
    }else {
        $post_html = 0;
    }

}else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = 1;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = 2;
    }else {
        $post_html = 0;
    }

    $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);
    $links_enabled = ($page_prefs & POST_AUTO_LINKS);
    $spelling_enabled = ($page_prefs & POST_CHECK_SPELLING);

    if (!$high_interest = bh_session_get_value('MARK_AS_OF_INT')) {
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
    user_get_sig($uid, $t_sig, $t_sig_html);

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(rand()));
}

if (!isset($sig_html)) $sig_html = 0;

if (isset($_POST['submit']) || isset($_POST['preview'])) {

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = trim(_stripslashes($_POST['t_content']));

        if ($post_html && attachment_embed_check($t_content)) {

            $error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = trim(_stripslashes($_POST['t_sig']));

        if ($sig_html && attachment_embed_check($t_sig)) {
            $error_html = "<h2>{$lang['notallowedembedattachmentsignature']}</h2>\n";
            $valid = false;
        }
    }
}

if (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x'])) {

    if (isset($_POST['t_newthread'])) {

        if (isset($_POST['t_threadtitle']) && trim(_stripslashes($_POST['t_threadtitle']) != "")) {

            $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
        }

        if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

            if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

                $t_fid = $_POST['t_fid'];

            }else {

                $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
                $valid = false;
            }
        }
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = _htmlentities(trim(_stripslashes($_POST['t_content'])));
    }

    if (isset($_POST['t_sig'])) {

        $t_sig = _htmlentities(trim(_stripslashes($_POST['t_sig'])));
    }

    if (isset($_POST['emots_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs['POST_PAGE'] = $page_prefs;
    $user_prefs_global['POST_PAGE'] = true;

    user_update_prefs($uid, $user_prefs, $user_prefs_global);

    $fix_html = false;
}

if (!isset($t_content)) $t_content = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, $t_sig, true, false);

$t_content = $post->getContent();
$t_sig = $sig->getContent();

if (strlen($t_content) >= 65535) {

    $error_html = "<h2>{$lang['reducemessagelength']} ".number_format(strlen($t_content)).")</h2>";
    $valid = false;
}

if (strlen($t_sig) >= 65535) {

    $error_html = "<h2>{$lang['reducesiglength']} ".number_format(strlen($t_sig)).")</h2>";
    $valid = false;
}

if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

    $replyto = $_GET['replyto'];
    list($reply_to_tid, $reply_to_pid) = explode(".", $replyto);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['cannotcreatepostinfolder']}</h2>";
        html_draw_bottom();
        exit;
    }

    $newthread = false;

}elseif (isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && isset($_POST['t_rpid']) && is_numeric($_POST['t_rpid'])) {

    $reply_to_tid = $_POST['t_tid'];
    $reply_to_pid = $_POST['t_rpid'];

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE, $t_fid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['cannotcreatepostinfolder']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    $newthread = false;

}else{

    $newthread = true;

    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $t_fid = $_GET['fid'];
    }elseif (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
        $t_fid = $_POST['t_fid'];
    }

    if (isset($t_fid) && !folder_is_valid($t_fid)) {

        $error_html = "<h2>{$lang['invalidfolderid']}</h2>\n";
        $valid = false;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (isset($t_fid) && !bh_session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

        $error_html = "<h2>{$lang['cannotcreatethreadinfolder']}</h2>";
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
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

    if ($sig->getHTML() > 0) {

        $sig->setHTML(false);
        $t_sig = $sig->getContent();
    }
}

if (!$newthread) {

    $reply_message = messages_get($reply_to_tid, $reply_to_pid);
    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);
    
    if (!$threaddata = thread_get($reply_to_tid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $threaddata['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {

        $error_html = "<h2>{$lang['messagehasbeendeleted']}</h2>\n";
        $valid = false;
    }
}

if ($valid && isset($_POST['submit'])) {

    if (check_post_frequency()) {

        if (check_ddkey($_POST['t_dedupe'])) {

            if ($newthread) {

                $t_closed     = (isset($_POST['t_closed']))     ? $_POST['t_closed']     : false;
                $old_t_closed = (isset($_POST['old_t_closed'])) ? $_POST['old_t_closed'] : false;
                $t_sticky     = (isset($_POST['t_sticky']))     ? $_POST['t_sticky']     : false;
                $old_t_sticky = (isset($_POST['old_t_sticky'])) ? $_POST['old_t_sticky'] : false;

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                    $t_closed = isset($t_closed) && $t_closed == "Y" ? true : false;
                    $t_sticky = isset($t_sticky) && $t_sticky == "Y" ? "Y" : "N";

                }else {

                    $t_closed = false;
                    $t_sticky = "N";
                }

                $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle, "N", $t_sticky, $t_closed);
                $t_rpid = 0;

            }else{

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

                if (isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 && (!bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid))) {

                    html_draw_top();

                    echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
                    echo "<table class=\"posthead\" width=\"720\">\n";
                    echo "<tr><td class=\"subhead\">{$lang['threadclosed']}</td></tr>\n";
                    echo "<tr><td>\n";
                    echo "<h2>{$lang['threadisclosedforposting']}</h2>\n";
                    echo "</td></tr>\n";

                    echo "<tr><td align=\"center\">\n";
                    echo form_input_hidden('t_tid', $t_tid);
                    echo form_input_hidden('t_rpid', $t_rpid);
                    echo form_submit('cancel', $lang['cancel']);
                    echo "</td></tr>\n";
                    echo "</table></form>\n";

                    html_draw_bottom();
                    exit;
                }

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                    $t_closed     = (isset($_POST['t_closed']))     ? $_POST['t_closed']     : false;
                    $old_t_closed = (isset($_POST['old_t_closed'])) ? $_POST['old_t_closed'] : false;
                    $t_sticky     = (isset($_POST['t_sticky']))     ? $_POST['t_sticky']     : false;
                    $old_t_sticky = (isset($_POST['old_t_sticky'])) ? $_POST['old_t_sticky'] : false;

                    if (isset($t_closed) && isset($old_t_closed) && $t_closed != $old_t_closed && $t_closed == "Y") {
                        thread_set_closed($t_tid, true);
                    }elseif ((!isset($t_closed) || (isset($t_closed) && $t_closed != "Y")) && $old_t_closed == "Y") {
                        thread_set_closed($t_tid, false);
                    }

                    if (isset($t_sticky) && isset($old_t_sticky) && $t_sticky != $old_t_sticky && $t_sticky == "Y") {
                        thread_set_sticky($t_tid, true);
                    }elseif ((!isset($t_sticky) || (isset($t_sticky) && $t_sticky != "Y")) && $old_t_sticky == "Y") {
                        thread_set_sticky($t_tid, false);
                    }
                }
            }

            if ($t_tid > 0) {

                if ($allow_sig == true && trim($t_sig) != "") {
                    $t_content.= "\n<div class=\"sig\">$t_sig</div>";
                }

                if ($newthread) {
                    $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $uid, $_POST['t_to_uid'], $t_content);
                }else {
                    $new_pid = post_create($t_fid, $t_tid, $t_rpid, $threaddata['BY_UID'], $uid, $_POST['t_to_uid'], $t_content);
                }

                if ($high_interest == "Y") thread_set_high_interest($t_tid, 1, $newthread);

                if (!(perm_get_user_permissions($uid) & USER_PERM_WORMED)) {

                    email_sendnotification($_POST['t_to_uid'], $uid, $t_tid, $new_pid);
                    email_sendsubscription($_POST['t_to_uid'], $uid, $t_tid, $new_pid);
                }

                post_save_attachment_id($t_tid, $new_pid, $aid);
            }

        }else {

            $new_pid = 0;

            if ($newthread) {

                $t_tid  = 0;
                $t_rpid = 0;

            }else {

                $t_tid  = (isset($_POST['t_tid'])) ? $_POST['t_tid'] : 0;
                $t_rpid = (isset($_POST['t_rpid'])) ? $_POST['t_rpid'] : 0;
            }
        }

        if ($new_pid > -1) {

            if ($newthread && $t_tid > 0) {

                $uri = "./discussion.php?webtag=$webtag&msg=$t_tid.1";

            }else {

                if ($t_tid > 0 && $t_rpid > 0) {
                    $uri = "./discussion.php?webtag=$webtag&msg=$t_tid.$t_rpid";
                }else{
                    $uri = "./discussion.php?webtag=$webtag";
                }
            }

            header_redirect($uri);
            exit;

        }else{

            $error_html = "<h2>{$lang['errorcreatingpost']}</h2>";
        }

    }else {

        $error_html = "<h2>{$lang['postfrequencytoogreat_1']} ";
        $error_html.= forum_get_setting('minimum_post_frequency', false, 0);
        $error_html.= " {$lang['postfrequencytoogreat_2']}</h2>\n";
    }
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if ($newthread && !$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "", FOLDER_ALLOW_NORMAL_THREAD, "", "post_folder_dropdown")) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannotcreatenewthreads']}</h2>";
    html_draw_bottom();
    exit;
}

html_draw_top("onUnload=clearFocus()", "basetarget=_blank", "post.js", "openprofile.js", "htmltools.js", "emoticons.js", "dictionary.js");

echo "<h1>{$lang['postmessage']}</h1>\n";
echo "<br /><form name=\"f_post\" action=\"post.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";

if (!$newthread) {

    if (isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0) {

        echo "<table class=\"posthead\" width=\"720\">\n";
        echo "<tr><td class=\"subhead\">{$lang['threadclosed']}</td></tr>\n";
        echo "<tr><td>\n";

        if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            echo "<h2>{$lang['moderatorthreadclosed']}</h2>\n";
            echo "</td></tr>\n";

        }else {

            echo "<h2>{$lang['threadisclosedforposting']}</h2>\n";
            echo "</td></tr>\n";

            echo "<tr><td align=\"center\">\n";
            echo form_submit('cancel', $lang['cancel']);
            echo "</td></tr>\n";
            echo "</table></form>\n";

            html_draw_bottom();
            exit;
        }
    }
}

$tools = new TextAreaHTML("f_post");
echo $tools->preload();

if ($valid && isset($_POST['preview'])) {

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['messagepreview']}</td></tr>";

    if ($_POST['t_to_uid'] == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

    }else{

        $preview_tuser = user_get($_POST['t_to_uid']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['TO_UID'] = $preview_tuser['UID'];

    }

    $preview_tuser = user_get($uid);
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    $preview_message['CONTENT'] = $post->getContent();

    if ($allow_sig == true && trim($t_sig) != "") {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    $preview_message['CREATED'] = mktime();
    $preview_message['AID'] = $aid;

    echo "<tr><td>\n";
    message_display(0, $preview_message, 0, 0, 0, true, false, false, false, $show_sigs, true);
    echo "</td></tr>\n";

    echo "<tr><td>&nbsp;</td></tr>\n";
    echo "</table>\n";
}

if (!$newthread) {

    if (!isset($_POST['t_to_uid'])) {
        $t_to_uid = message_get_user($reply_to_tid, $reply_to_pid);
    }else {
        $t_to_uid = $_POST['t_to_uid'];
    }
}

if (isset($error_html)) {
    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['error']}</td></tr>";
    echo "<tr><td>\n";
    echo $error_html . "\n";
    echo "</td></tr>\n";
    echo "</table>\n";
}

if (!isset($t_threadtitle)) {
    $t_threadtitle = "";
}

echo "<table class=\"posthead\" width=\"720\">\n";
echo "<tr><td class=\"subhead\" colspan=\"2\">";

if ($newthread) {
    echo $lang['createnewthread'];
}else{
    echo $lang['postreply'];
}

echo "</td></tr>\n";
echo "<tr>\n";
echo "<td valign=\"top\" width=\"210\">\n";
echo "<table class=\"posthead\" width=\"210\">\n";
echo "<tr><td>\n";

if ($newthread) {

    echo "<h2>{$lang['folder']}:</h2>\n";
    echo "$folder_dropdown\n";
    echo "<h2>{$lang['threadtitle']}:</h2>\n";
    echo form_input_text("t_threadtitle", _htmlentities($t_threadtitle), 0, 0, false, "thread_title"), "\n";

    echo form_input_hidden("t_newthread", "Y")."\n";
    echo "<br />\n";

}else {

    echo "<h2>{$lang['folder']}:</h2>\n";
    echo $threaddata['FOLDER_TITLE'], "\n";
    echo "<h2>{$lang['threadtitle']}:</h2>\n";
    echo apply_wordfilter($threaddata['TITLE']), "\n";

    echo form_input_hidden("t_tid", $reply_to_tid);
    echo form_input_hidden("t_rpid", $reply_to_pid)."\n";
    echo "<br /><br />\n";
}

echo "<h2>{$lang['to']}:</h2>\n";

if (!$newthread) {
    echo form_radio("to_radio", "in_thread", $lang['usersinthread'], true), "<br />\n";
    echo post_draw_to_dropdown_in_thread($reply_to_tid, $t_to_uid, true, false, 'onclick="checkToRadio(0)"'), "<br />\n";
}

echo form_radio("to_radio", "recent", $lang['recentvisitors'], $newthread ? true : false)."<br />\n";
echo post_draw_to_dropdown_recent($newthread && isset($t_to_uid) ? $t_to_uid : ($newthread ? -1 : 0))."<br />\n";

echo form_radio("to_radio", "others", $lang['others'])."<br />\n";
echo form_input_text("t_to_uid_others", "", 0, 0, "onclick=\"checkToRadio(".($newthread ? 1 : 2).")\"", "post_to_others")."<br /><br />\n";

echo "<h2>{$lang['messageoptions']}:</h2>\n";

echo form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br />\n";
echo form_checkbox("t_post_interest", "Y", $lang['setthreadtohighinterest'], $high_interest == "Y")."<br />\n";

if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    echo "<br />\n";
    echo "<h2>{$lang['admin']}:</h2>\n";
    echo form_checkbox("t_closed", "Y", $lang['closeforposting'], isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 ? true : false), "<br />";
    echo form_checkbox("t_sticky", "Y", $lang['makesticky'], isset($threaddata['STICKY']) && $threaddata['STICKY'] == "Y" ? true : false)."<br />\n";
    echo form_input_hidden("old_t_closed", isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 ? "Y" : "N");
    echo form_input_hidden("old_t_sticky", isset($threaddata['STICKY']) && $threaddata['STICKY'] == "Y" ? "Y" : "N");
}

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if ($emot_prev != "") {

    echo "<br />\n";
    echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">&nbsp;{$lang['emoticons']}:</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {

        echo "    <td class=\"subhead\" align=\"right\">". form_submit_image('emots_hide.png', 'emots_toggle', 'hide'). "&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "    <td class=\"subhead\" align=\"right\">". form_submit_image('emots_show.png', 'emots_toggle', 'show'). "&nbsp;</td>\n";
    }

    echo "  </tr>\n";
    echo "</table>\n";
}

echo "</td></tr>\n";
echo "</table>\n";
echo "</td>\n";
echo "<td valign=\"top\" width=\"500\">\n";
echo "<table class=\"posthead\" width=\"500\">\n";
echo "<tr><td>\n";

if (!isset($t_to_uid)) $t_to_uid = -1;

echo "<h2>{$lang['message']}:</h2>\n";

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

$tool_type = 0;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = 1;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = 2;
}

if ($allow_html == true && $tool_type != 0) {
    echo $tools->toolbar(false, form_submit("submit", $lang['post'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));
}else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "tabindex=\"1\"", "post_content"), "\n";

if ($post->isDiff() && $fix_html) {

    echo $tools->compare_original("t_content", $post->getOriginalContent());

    if ($tools->getTinyMCE()) {
        echo "<br />\n";
    }else {
        echo "<br /><br />\n";
    }
}

if ($allow_html == true) {

    if ($tools->getTinyMCE()) {

        echo form_input_hidden("t_post_html", "enabled");

    }else {

        echo "<h2>{$lang['htmlinmessage']}:</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
        echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
            echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
        }
    }

}else {

        echo form_input_hidden("t_post_html", "disabled");
}

// SUBMIT BUTTONS

if ($tools->getTinyMCE()) {
    echo "<br />\n";
}else {
    echo "<br /><br />\n";
}
echo form_submit("submit", $lang['post'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "&nbsp;".form_submit("preview", $lang['preview'], "tabindex=\"3\" onclick=\"clearFocus()\"");
echo "&nbsp;".form_submit("cancel", $lang['cancel'], "tabindex=\"4\" onclick=\"closeAttachWin(); clearFocus()\"");

if (forum_get_setting('attachments_enabled', 'Y') && (bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid) || $newthread)) {

    echo "&nbsp;".form_button("attachments", $lang['attachments'], "tabindex=\"5\" onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", $aid);
}

if ($allow_sig == true) {

    echo "<br /><br /><table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">&nbsp;{$lang['signature']}:</td>\n";

    $t_sig = ($fix_html ? $sig->getTidyContent() : $sig->getOriginalContent());

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {

        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('sig_hide.png', 'sig_toggle', 'hide'). "&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td colspan=\"2\">", $tools->textarea("t_sig", $t_sig, 5, 75, "virtual", "tabindex=\"7\"", "signature_content"), "</td>\n";
        echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";

        if ($sig->isDiff() && $fix_html && !$fetched_sig) {
            echo $tools->compare_original("t_sig", $sig->getOriginalContent());
        }

    }else {

        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('sig_show.png', 'sig_toggle', 'show'), "&nbsp;</td>\n";
        echo "    ", form_input_hidden("t_sig", $t_sig), "\n";
    }

    echo "  </tr>\n";
    echo "</table>\n";
}

echo "</td></tr>\n";
echo "</table>";
echo "</td>\n";
echo "</tr>\n";
echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
echo "</table>\n";


echo $tools->js();


if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $_POST['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", mktime());
}

if (!$newthread && $reply_to_pid > 0) {

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['inreplyto']}:</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>\n";

    if (($threaddata['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        poll_display($reply_to_tid, $threaddata['LENGTH'], $reply_to_pid, $threaddata['FID'], false, false, false, true, $show_sigs, true);

    }else {

        message_display($reply_to_tid, $reply_message, $threaddata['LENGTH'], $reply_to_pid, $threaddata['FID'], true, false, false, false, $show_sigs, true);
    }

    echo "      <br />\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "</form>\n";

html_draw_bottom();

?>