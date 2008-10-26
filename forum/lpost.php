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

/* $Id: lpost.php,v 1.143 2008-10-26 21:03:49 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {
    header_redirect("llogon.php?webtag=$webtag");
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

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("lforums.php");
}

if (user_is_guest()) {

    light_html_guest_error();
    exit;
}

// Check that there are some available folders for this thread type

if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    light_html_message_type_error();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "lmessages.php?webtag=$webtag";

    if (isset($_POST['t_tid']) && isset($_POST['t_rpid'])) {
        $uri.= "&msg={$_POST['t_tid']}.{$_POST['t_rpid']}";
    }elseif (isset($_GET['replyto'])) {
        $uri.= "&msg={$_GET['replyto']}";
    }

    header_redirect($uri);
}

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Assume everything is A-OK!

$valid = true;

$new_thread = false;

if (isset($_POST['t_newthread'])) {

    $new_thread = true;

    if (isset($_POST['t_threadtitle']) && mb_strlen(trim(stripslashes_array($_POST['t_threadtitle']))) > 0) {

        $t_threadtitle = trim(stripslashes_array($_POST['t_threadtitle']));

    }else {

        $error_msg_array[] = $lang['mustenterthreadtitle'];
        $valid = false;
    }

    if (isset($_POST['t_fid'])) {

        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {

            $t_fid = $_POST['t_fid'];

        }else {

            $error_msg_array[] = $lang['cannotpostthisthreadtypeinfolder'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['pleaseselectfolder'];
        $valid = false;
    }

    if (isset($_POST['t_content']) && mb_strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = stripslashes_array($_POST['t_content']);

    }else {

        $error_msg_array[] = $lang['mustenterpostcontent'];
        $valid = false;
    }

}else {

    if (isset($_POST['t_tid'])) {

        if (isset($_POST['t_content']) && mb_strlen($_POST['t_content']) > 0) {

            $t_content = stripslashes_array($_POST['t_content']);

        }else {

            $error_msg_array[] = $lang['mustenterpostcontent'];
            $valid = false;
        }

    }else {

        $valid = false;
    }
}

if (($high_interest = bh_session_get_value('MARK_AS_OF_INT')) === false) {
    $high_interest = "N";
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
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $fetched_sig = false;

    if (isset($_POST['t_sig']) && mb_strlen(trim(stripslashes_array($_POST['t_sig']))) > 0) {
        $t_sig = stripslashes_array($_POST['t_sig']);
    }else {
        $t_sig = "";
    }

}else {

    if (!user_get_sig($uid, $t_sig, $t_sig_html)) {

        $t_sig = '';
        $t_sig_html = 'Y';
    }

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

if (($page_prefs & POST_EMOTICONS_DISABLED) > 0) {
    $emots_enabled = false;
}else {
    $emots_enabled = true;
}

if (!isset($t_content)) $t_content = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_content, $emots_enabled);
$sig = new MessageText($sig_html, $t_sig);

$t_content = $post->getContent();
$t_sig = $sig->getContent();

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

    $new_thread = false;

}elseif (isset($_POST['t_tid']) && isset($_POST['t_rpid'])) {

    $reply_to_tid = (is_numeric($_POST['t_tid']) ? $_POST['t_tid'] : 0);
    $reply_to_pid = (is_numeric($_POST['t_rpid']) ? $_POST['t_rpid'] : 0);

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['threadcouldnotbefound']);
        light_html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE | USER_PERM_POST_READ, $t_fid)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['cannotcreatepostinfolder']);
        light_html_draw_bottom();
        exit;
    }

    $new_thread = false;

}else {

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

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['cannotcreatethreadinfolder']);
        light_html_draw_bottom();
        exit;
    }
}

if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {

    $t_to_uid = $_POST['t_to_uid'];

}else {

    $t_to_uid = 0;

    if (isset($reply_to_tid) && isset($reply_to_pid)) {

        if (!$t_to_uid = message_get_user($reply_to_tid, $reply_to_pid)) {

            $t_to_uid = 0;
        }
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

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['postdoesnotexist']);
        light_html_draw_bottom();
        exit;
    }

    if (!$thread_data = thread_get($reply_to_tid)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['threadcouldnotbefound']);
        light_html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if (((perm_get_user_permissions($reply_message['FROM_UID']) & USER_PERM_WORMED) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0)) {

        $error_msg_array[] = $lang['messagehasbeendeleted'];
        $valid = false;
    }
}

// De-dupe key

if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
}else{
    $t_dedupe = mktime();
}

if ($valid && isset($_POST['post'])) {

    if (check_post_frequency()) {

        if (check_ddkey($t_dedupe)) {

            if ($new_thread) {

                $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle);
                $t_rpid = 0;

            }else {

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

            }

            if ($t_tid > 0) {

                if ($allow_sig == true && mb_strlen(trim($t_sig)) > 0) {
                    $t_content.= "<div class=\"sig\">$t_sig</div>";
                }

                $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $t_to_uid, $t_content);

                if ($new_pid > -1) {

                    $user_rel = user_get_relationship($t_to_uid, $uid);

                    if ($high_interest == "Y") thread_set_high_interest($t_tid);

                    if (!bh_session_check_perm(USER_PERM_WORMED, 0) && !($user_rel & USER_IGNORED_COMPLETELY)) {

                        $exclude_user_array = array($t_to_uid, $uid);

                        $thread_modified = (isset($thread_data['MODIFIED']) && is_numeric($thread_data['MODIFIED'])) ? $thread_data['MODIFIED'] : 0;

                        email_sendnotification($t_to_uid, $uid, $t_tid, $new_pid);

                        email_send_folder_subscription($t_to_uid, $uid, $t_fid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);

                        email_send_thread_subscription($t_to_uid, $uid, $t_tid, $new_pid, $thread_modified, $exclude_user_array);
                    }
                }
            }

        }else {

            $new_pid = 0;

            if ($new_thread) {

                $t_tid = 0;
                $t_rpid = 0;

            }else {

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

            }
        }

        if ($new_pid > -1) {

            if ($t_tid > 0 && $t_rpid > 0) {
                $uri = "lmessages.php?webtag=$webtag&msg=$t_tid.$t_rpid";
            }else {
                $uri = "lmessages.php?webtag=$webtag";
            }

            header_redirect($uri);
            exit;

        }else {

            $error_msg_array[] = $lang['errorcreatingpost'];
        }

    }else {

        $error_msg_array[] = sprintf($lang['postfrequencytoogreat'], forum_get_setting('minimum_post_frequency', false, 0));
    }
}

light_html_draw_top("robots=noindex,nofollow");

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(mt_rand()));
}

if ($valid && isset($_POST['preview'])) {

    echo "<h1>{$lang['messagepreview']}</h1>";

    if ($t_to_uid == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

    }else {

        $preview_tuser = user_get($t_to_uid);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['TO_UID'] = $preview_tuser['UID'];
    }

    $preview_tuser = user_get(bh_session_get_value('UID'));
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    $preview_message['CONTENT'] = $t_content;

    if ($allow_sig == true && mb_strlen(trim($t_sig)) > 0) {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    light_message_display(0, $preview_message, 0, 0, false, false, false, false, true);

    echo "<br />\n";
}

if (!$new_thread) {

    if (isset($thread_data['CLOSED']) && $thread_data['CLOSED'] > 0) {

        if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            echo "<h2>{$lang['moderatorthreadclosed']}</h2>\n";

        }else {

            echo "<h2>{$lang['threadisclosedforposting']}</h2>\n";
            light_html_draw_bottom();
            exit;
        }
    }
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\">\n";
echo form_input_hidden('t_dedupe', htmlentities_array($t_dedupe));

if (!isset($t_threadtitle)) {
    $t_threadtitle = "";
}

if (!isset($t_fid)) {
    $t_fid = 1;
}

if ($new_thread) {

    echo "<h1>{$lang['createnewthread']}</h1>\n";
    echo "<p>{$lang['selectfolder']}: ";
    echo light_folder_draw_dropdown($t_fid, "t_fid"), "</p>\n";
    echo "<p>{$lang['threadtitle']}: ";
    echo light_form_input_text("t_threadtitle", htmlentities_array($t_threadtitle), 30, 64);
    echo "</p>\n";
    echo form_input_hidden("t_newthread", "Y");

}else {

    if (!$reply_message = messages_get($reply_to_tid, $reply_to_pid)) {

        light_html_display_error_msg($lang['postdoesnotexist']);
        light_html_draw_bottom();
        exit;
    }

    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $thread_data['POLL_FLAG'] != 'Y' && $reply_to_pid != 0) {

        light_html_display_error_msg($lang['messagehasbeendeleted']);
        light_html_draw_bottom();
        exit;

    }else {

        echo "<h1>{$lang['postreply']}: ", thread_get_title($reply_to_tid), "</h1>\n";
        echo form_input_hidden("t_tid", htmlentities_array($reply_to_tid));
        echo form_input_hidden("t_rpid", htmlentities_array($reply_to_pid))."\n";
    }
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<p>{$lang['to']}: ", post_draw_to_dropdown($t_to_uid), "</p>\n";
echo "<p>", light_form_textarea("t_content", htmlentities_array($post->getTidyContent()), 15, 60), "</p>\n";

if ($allow_sig == true) {
    echo "<p>{$lang['signature']}:<br />", light_form_textarea("t_sig", htmlentities_array($sig->getTidyContent()), 5, 60), form_input_hidden("t_sig_html", htmlentities_array($t_sig_html))."</p>\n";
}

if ($allow_html == true) {

    $tph_radio = $post->getHTML();

    echo "<p>{$lang['htmlinmessage']}:<br />\n";
    echo light_form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED), "<br />\n";
    echo light_form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO), "<br />\n";
    echo light_form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED), "<br />\n";
    echo "</p>";

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "<p>", light_form_submit("post", $lang['post']), "&nbsp;", light_form_submit("preview", $lang['preview']), "&nbsp;", light_form_submit("cancel", $lang['cancel']);
echo "</p>";

echo "</form>\n";

if (!$new_thread && $reply_to_pid > 0) {

    echo "<p>{$lang['inreplyto']}:</p>\n";

    if (($thread_data['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        light_poll_display($reply_to_tid, $thread_data['LENGTH'], $thread_data['FID'], false, false, false, false);

    }else {

        light_message_display($reply_to_tid, $reply_message, $thread_data['LENGTH'], $thread_data['FID'], false, false, false, false, false);
    }
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";

light_html_draw_bottom();

?>