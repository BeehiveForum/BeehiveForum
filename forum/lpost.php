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

/* $Id: lpost.php,v 1.67 2005-03-14 13:27:20 decoyduck Exp $ */

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

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./lforums.php?final_uri=$request_uri");
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


// for "REPLY ALL" form button on messages.php    ########################################################Hng
if (isset($_POST['replyto'])) {
        $_GET['replyto'] = $_POST['replyto'];
}


$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

// Get the user's post page preferences.

$page_prefs = bh_session_get_value('POST_PAGE');

// Get the user's UID

$uid = bh_session_get_value('UID');

if ($page_prefs == 0) {
        $page_prefs = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT;
}

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

if (isset($_POST['t_post_html'])) {

        $t_post_html = $_POST['t_post_html'];

        if ($t_post_html == "enabled_auto") {
                $post_html = 1;
        } else if ($t_post_html == "enabled") {
                $post_html = 2;
        } else {
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

} else {
        // Fetch the current user's sig
        user_get_sig($uid, $t_sig, $t_sig_html);

        if ($t_sig_html != "N") {
                $sig_html = 2;
        }

        $t_sig = tidy_html($t_sig, false);

        $fetched_sig = true;
}

if (!isset($sig_html)) $sig_html = 0;

if (!isset($post_html)) {
        if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
                $post_html = 1;
        } else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
                $post_html = 2;
        } else {
                $post_html = 0;
        }
}

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
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (!perm_check_folder_permissions($t_fid, USER_PERM_POST_CREATE | USER_PERM_POST_READ)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
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
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

    if (!perm_check_folder_permissions($t_fid, USER_PERM_POST_CREATE | USER_PERM_POST_READ)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
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

        $error_html = "<h2>{$lang['invalidfolder']}</h2>\n";
        $valid = false;
    }

    if (isset($t_fid) && !perm_check_folder_permissions($t_fid, USER_PERM_THREAD_CREATE | USER_PERM_POST_READ)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['cannotcreatethreadinfolder']}</h2>";
        html_draw_bottom();
        exit;
    }
}


$allow_html = true;
$allow_sig = true;

if (isset($t_fid) && !perm_check_folder_permissions($t_fid, USER_PERM_HTML_POSTING)) {
        $allow_html = false;
}
if (isset($t_fid) && !perm_check_folder_permissions($t_fid, USER_PERM_SIGNATURE)) {
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


if ($valid && isset($_POST['submit'])) {

    if (check_ddkey($_POST['t_dedupe'])) {

        if ($newthread) {

            $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle);
            $t_rpid = 0;

        }else {

            $t_tid = $_POST['t_tid'];
            $t_rpid = $_POST['t_rpid'];

        }

        if ($t_tid > 0) {

            if ($allow_sig == true && trim($t_sig) != "") {
                $t_content.= "\n<div class=\"sig\">".$t_sig."</div>";

            }

            $new_pid = post_create($t_fid, $t_tid, $t_rpid, $uid, $_POST['t_to_uid'], $t_content);

            if (bh_session_get_value('MARK_AS_OF_INT')) thread_set_high_interest($t_tid, 1, $newthread);

            email_sendnotification($_POST['t_to_uid'], "$t_tid.$new_pid", $uid);
            email_sendsubscription($_POST['t_to_uid'], "$t_tid.$new_pid", $uid);
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

}

light_html_draw_top();

if (!isset($_POST['aid'])) {
  $aid = md5(uniqid(rand()));
}else {
  $aid = $_POST['aid'];
}

if ($valid && isset($_POST['preview'])) {

    echo "<h2>{$lang['messagepreview']}:</h2>";

    if ($_POST['t_to_uid'] == 0) {

      $preview_message['TLOGON'] = "ALL";
      $preview_message['TNICK'] = "ALL";

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

    if ($allow_sig == true && trim($t_sig) != "") {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    light_message_display(0, $preview_message, 0, 0, false, false, false, false, $show_sigs, true);
    echo "<br />\n";
}

if (!$newthread) {

    if (!isset($_POST['t_to_uid'])) {
        $t_to_uid = message_get_user($reply_to_tid,$reply_to_pid);
    }else {
        $t_to_uid = $_POST['t_to_uid'];
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
    $threaddata = thread_get($reply_to_tid);

    if ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $threaddata['POLL_FLAG'] != 'Y' && $reply_to_pid != 0) {

      echo "<h2>{$lang['messagehasbeendeleted']}</h2>\n";
      html_draw_bottom();
      exit;

    }else {

      echo "<h2>" . thread_get_title($reply_to_tid) . "</h2>\n";
      echo form_input_hidden("t_tid", $reply_to_tid);
      echo form_input_hidden("t_rpid", $reply_to_pid)."\n";
    }
}

if (!isset($t_to_uid)) $t_to_uid = -1;

echo "<p>{$lang['to']}: ", post_draw_to_dropdown($t_to_uid), "</p>\n";
echo "<p>", light_form_textarea("t_content", $post->getTidyContent(), 15, 60), "</p>\n";

if ($allow_sig == true) {
        echo "<p>{$lang['signature']}:<br />", light_form_textarea("t_sig", $sig->getTidyContent(), 5, 60), form_input_hidden("t_sig_html", $t_sig_html)."</p>\n";
}

if ($allow_html == true) {

        $tph_radio = $post->getHTML();

        echo "<p>{$lang['htmlinmessage']}:<br />\n";
        echo light_form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0), "<br />\n";
        echo light_form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1), "<br />\n";
        echo light_form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2), "<br />\n";
        echo "</p>";

} else {

        echo form_input_hidden("t_post_html", "disabled");
}

echo "<p>", light_form_submit("submit",$lang['post']), "&nbsp;", light_form_submit("preview",$lang['preview']), "&nbsp;", light_form_submit("cancel", $lang['cancel']);
echo "</p>";

if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe",$_POST['t_dedupe']);
}else {
    echo form_input_hidden("t_dedupe",date("YmdHis"));
}

echo "</form>\n";

if (!$newthread && $reply_to_pid > 0) {

    echo "<p>{$lang['inreplyto']}:</p>\n";

    if (($threaddata['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

        light_poll_display($reply_to_tid, $threaddata['LENGTH'], $reply_to_pid, false, false, false, true, $show_sigs, true);

    }else {

        light_message_display($reply_to_tid, $reply_message, $threaddata['LENGTH'], $reply_to_pid, true, false, false, false, $show_sigs, true);
    }
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>