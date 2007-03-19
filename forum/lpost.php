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

/* $Id: lpost.php,v 1.98 2007-03-19 15:19:32 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {

    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag");
}

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {

    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag");
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

    header_redirect("./lforums.php");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("./lforums.php");
}

if (bh_session_get_value('UID') == 0) {
    light_html_guest_error();
    exit;
}

// Check that there are some available folders for this thread type

if (!folder_get_by_type_allowed(FOLDER_ALLOW_NORMAL_THREAD)) {
    light_html_message_type_error();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "./lthread_list.php?webtag=$webtag";

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

$valid = true;

$newthread = false;

if (isset($_POST['t_newthread'])) {

    $newthread = true;

    if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
    }else {
        $error_html = "<h2>{$lang['mustenterthreadtitle']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_fid'])) {
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

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {
        $t_content = _stripslashes($_POST['t_content']);
    }else {
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

}else {

    if (isset($_POST['t_tid'])) {

        if (isset($_POST['t_content']) && strlen($_POST['t_content']) > 0) {
            $t_content = _stripslashes($_POST['t_content']);
        }else {
            $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
            $valid = false;
        }

    }else {

        $valid = false;
    }
}

if (!$high_interest = bh_session_get_value('MARK_AS_OF_INT')) {
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
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }

    $fetched_sig = false;

    if (isset($_POST['t_sig']) && strlen(trim(_stripslashes($_POST['t_sig']))) > 0) {
        $t_sig = _stripslashes($_POST['t_sig']);
    }else {
        $t_sig = "";
    }

}else {

    user_get_sig($uid, $t_sig, $t_sig_html);

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

if (!isset($sig_html)) $sig_html = 0;

if (!isset($emots_enabled)) $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);

if (!isset($t_content)) $t_content = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_content, $emots_enabled);
$sig = new MessageText($sig_html, $t_sig);

$t_content = $post->getContent();
$t_sig = $sig->getContent();

if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

    $replyto = $_GET['replyto'];
    list($reply_to_tid, $reply_to_pid) = explode(".", $replyto);
    $newthread = false;

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top();
        echo "<h2>{$lang['error']}</h2>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE | USER_PERM_POST_READ, $t_fid)) {

        html_draw_top();
        echo "<h2>{$lang['error']}</h2>\n";
        echo "<h2>{$lang['cannotcreatepostinfolder']}</h2>";
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_tid'])) {

    $reply_to_tid = $_POST['t_tid'];
    $reply_to_pid = $_POST['t_rpid'];
    $newthread = false;

    if (!$t_fid = thread_get_folder($reply_to_tid, $reply_to_pid)) {

        html_draw_top();
        echo "<h2>{$lang['error']}</h2>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

        html_email_confirmation_error();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_CREATE | USER_PERM_POST_READ, $t_fid)) {

        html_draw_top();
        echo "<h2>{$lang['error']}</h2>\n";
        echo "<h2>{$lang['cannotcreatepostinfolder']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    $newthread = true;

    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

        $t_fid = $_GET['fid'];

    }elseif (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        $t_fid = $_POST['t_fid'];

    }else {

        $t_fid = 1;
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

        html_draw_top();
        echo "<h2>{$lang['error']}</h2>\n";
        echo "<h2>{$lang['cannotcreatethreadinfolder']}</h2>";
        html_draw_bottom();
        exit;
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

        light_html_draw_top();
        echo "<h2>{$lang['error']}</h2>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
        light_html_draw_bottom();
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

                $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle);
                $t_rpid = 0;

            }else {

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

            }

            if ($t_tid > 0) {

                if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
                    $t_content.= "\n<div class=\"sig\">".$t_sig."</div>";

                }

                if ($newthread) {

                    $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $uid, $_POST['t_to_uid'], $t_content);

                }else {

                    $new_pid = post_create($t_fid, $t_tid, $t_rpid, $threaddata['BY_UID'], $uid, $_POST['t_to_uid'], $t_content);
                }

                if ($high_interest == "Y") thread_set_high_interest($t_tid);

                if (!(perm_get_user_permissions($uid) & USER_PERM_WORMED)) {

                    email_sendnotification($_POST['t_to_uid'], $uid, $t_tid, $new_pid);
                    email_sendsubscription($_POST['t_to_uid'], $uid, $t_tid, $new_pid);
                }
            }

        }else {

            $new_pid = 0;

            if ($newthread) {

                $t_tid = 0;
                $t_rpid = 0;

            }else {

                $t_tid = $_POST['t_tid'];
                $t_rpid = $_POST['t_rpid'];

            }
        }

        if ($new_pid > -1) {

            if ($t_tid > 0 && $t_rpid > 0) {

              $uri = "./lmessages.php?webtag=$webtag&msg=$t_tid.$t_rpid";

            }else {

              $uri = "./lmessages.php?webtag=$webtag";

            }

            header_redirect($uri);
            exit;

        }else {

            $error_html = "<h2>{$lang['errorcreatingpost']}</h2>";

        }

    }else {

        $error_html = "<h2>{$lang['postfrequencytoogreat_1']} ";
        $error_html.= forum_get_setting('minimum_post_frequency', false, 0);
        $error_html.= " {$lang['postfrequencytoogreat_2']}</h2>\n";
    }
}

light_html_draw_top();

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(rand()));
}

if ($valid && isset($_POST['preview'])) {

    echo "<h2>{$lang['messagepreview']}</h2>";

    if ($_POST['t_to_uid'] == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

    }else {

        $preview_tuser = user_get($_POST['t_to_uid']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        $preview_message['TO_UID'] = $preview_tuser['UID'];
    }

    $preview_tuser = user_get(bh_session_get_value('UID'));
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];
    $preview_message['FROM_UID'] = $preview_tuser['UID'];

    $preview_message['CONTENT'] = $t_content;

    if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    light_message_display(0, $preview_message, 0, 0, 0, false, false, false, false, false, true);
    echo "<br />\n";
}

if (!$newthread) {

    if (!isset($_POST['t_to_uid'])) {
        $t_to_uid = message_get_user($reply_to_tid,$reply_to_pid);
    }else {
        $t_to_uid = $_POST['t_to_uid'];
    }

    if (isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0) {

        if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            echo "<h2>{$lang['moderatorthreadclosed']}</h2>\n";

        }else {

            echo "<h2>{$lang['threadisclosedforposting']}</h2>\n";
            light_html_draw_bottom();
            exit;
        }
    }
}

if ($newthread) {
    echo "<h2>{$lang['createnewthread']}</h2>\n";
}else {
    echo "<h2>{$lang['postreply']}</h2>\n";
}

if (isset($error_html)) {
    echo $error_html . "\n";
}

echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\">\n";

if (!isset($t_threadtitle)) {
    $t_threadtitle = "";
}

if ($newthread) {

    echo "<p>{$lang['selectfolder']}: ";
    echo light_folder_draw_dropdown($t_fid, "t_fid"), "</p>\n";
    echo "<p>{$lang['threadtitle']}: ";
    echo light_form_input_text("t_threadtitle", _htmlentities(_stripslashes($t_threadtitle)), 30, 64);
    echo "</p>\n";
    echo form_input_hidden("t_newthread", "Y");

}else {

    $reply_message = messages_get($reply_to_tid, $reply_to_pid);
    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $threaddata['POLL_FLAG'] != 'Y' && $reply_to_pid != 0) {

        echo "<h2>{$lang['messagehasbeendeleted']}</h2>\n";
        html_draw_bottom();
        exit;

    }else {

        echo "<h2>" . thread_get_title($reply_to_tid) . "</h2>\n";
        echo form_input_hidden("t_tid", _htmlentities($reply_to_tid));
        echo form_input_hidden("t_rpid", _htmlentities($reply_to_pid))."\n";
    }
}

if (!isset($t_to_uid)) $t_to_uid = -1;

echo "<p>{$lang['to']}: ", post_draw_to_dropdown($t_to_uid), "</p>\n";
echo "<p>", light_form_textarea("t_content", $post->getTidyContent(), 15, 60), "</p>\n";

if ($allow_sig == true) {
    echo "<p>{$lang['signature']}:<br />", light_form_textarea("t_sig", $sig->getTidyContent(), 5, 60), form_input_hidden("t_sig_html", _htmlentities($t_sig_html))."</p>\n";
}

if ($allow_html == true) {

    $tph_radio = $post->getHTML();

    echo "<p>{$lang['htmlinmessage']}:<br />\n";
    echo light_form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0), "<br />\n";
    echo light_form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1), "<br />\n";
    echo light_form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2), "<br />\n";
    echo "</p>";

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "<p>", light_form_submit("submit",$lang['post']), "&nbsp;", light_form_submit("preview",$lang['preview']), "&nbsp;", light_form_submit("cancel", $lang['cancel']);
echo "</p>";

if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", _htmlentities($_POST['t_dedupe']));
}else {
    echo form_input_hidden("t_dedupe", _htmlentities(mktime()));
}

echo "</form>\n";

if (!$newthread && $reply_to_pid > 0) {

    echo "<p>{$lang['inreplyto']}:</p>\n";

    if (($threaddata['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        light_poll_display($reply_to_tid, $threaddata['LENGTH'], $reply_to_pid, $threaddata['FID'], false, false, false, true, false, true);

    }else {

        light_message_display($reply_to_tid, $reply_message, $threaddata['LENGTH'], $reply_to_pid, $threaddata['FID'], true, false, false, false, false, true);
    }
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>