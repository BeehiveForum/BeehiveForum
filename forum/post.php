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

/* $Id: post.php,v 1.182 2004-04-17 18:41:01 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/email.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/htmltools.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
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

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

$newthread = false;

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
    } else if ($to_radio == "in_thread") {
        $t_to_uid = $_POST['t_to_uid_in_thread'];
        $_POST['t_to_uid'] = $t_to_uid;
    } else {
        $t_to_uid = $_POST['t_to_uid_recent'];
        $_POST['t_to_uid'] = $t_to_uid;
    }
}

if (isset($_POST['t_newthread'])) {
    $newthread = true;

    if (isset($_POST['t_threadtitle']) && trim($_POST['t_threadtitle']) != "") {
        $t_threadtitle = trim($_POST['t_threadtitle']);
    }else{
        $error_html = "<h2>{$lang['mustenterthreadtitle']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_fid'])) {
        if (folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_NORMAL_THREAD)) {
            $t_fid = $_POST['t_fid'];
        } else {
            $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
            $valid = false;
        }
    } else if ($valid) {
        $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>";
        $valid = false;
    }

} else if (!isset($_POST['t_tid'])) {
	$valid = false;
}

$post_html = 0;
$sig_html = 0;

if (isset($_POST['t_post_html'])) {
    $t_post_html = $_POST['t_post_html'];
    if ($t_post_html == "enabled_auto") {
		$post_html = 1;
    } else if ($t_post_html == "enabled") {
		$post_html = 2;
    }
}
if (isset($_POST['t_sig_html'])) {
	$t_sig_html = $_POST['t_sig_html'];
	if ($t_sig_html != "N") {
		$sig_html = 1;
	}
}

$t_content = "";
$t_sig = "";
if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
	$t_content = $_POST['t_content'];

	if ($post_html && attachment_embed_check($t_content)) {
		$error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
		$valid = false;
	}
}else if (isset($_POST['submit']) || isset($_POST['preview'])){
	$error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
	$valid = false;
}
if (isset($_POST['t_sig'])) {
	$t_sig = $_POST['t_sig'];
	if ($sig_html && attachment_embed_check($t_sig)) {
		$error_html = "<h2>{$lang['notallowedembedattachmentsignature']}</h2>\n";
		$valid = false;
	}
}

$post = new MessageText($post_html, $t_content);
$sig = new MessageText($sig_html, $t_sig);

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
    $newthread = false;

}elseif (isset($_POST['t_tid'])) {

    $reply_to_tid = $_POST['t_tid'];
    $reply_to_pid = $_POST['t_rpid'];
    $newthread = false;

}else{

    $newthread = true;

    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

        $t_fid = $_GET['fid'];

    }elseif (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        $t_fid = $_POST['t_fid'];
    }

}

if (!$newthread) {

    $reply_message = messages_get($reply_to_tid, $reply_to_pid);
    $reply_message['CONTENT'] = message_get_content($reply_to_tid, $reply_to_pid);
    $threaddata = thread_get($reply_to_tid);

    if (((user_get_status($reply_message['FROM_UID']) & USER_PERM_WORM) && !perm_is_moderator()) || ((!isset($reply_message['CONTENT']) || $reply_message['CONTENT'] == "") && $threaddata['POLL_FLAG'] != 'Y')) {

        /*html_draw_top();

        echo "<h1 style=\"width: 99%\">".$lang['postmessage']."</h1>\n";
        echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";

        echo "<table class=\"posthead\" width=\"720\">\n";
        echo "<tr><td class=\"subhead\">".$lang['error']."</td></tr>\n";
        echo "<tr><td>\n"; */

        $error_html = "<h2>{$lang['messagehasbeendeleted']}</h2>\n";
	$valid = false;

        /*echo "</td></tr>\n";

        echo "<tr><td align=\"center\">\n";
        echo form_submit('cancel', $lang['cancel']);
        echo "</td></tr>\n";
        echo "</table></form>\n";

        html_draw_bottom();
        exit; */
    }
}

if ($valid && isset($_POST['submit'])) {

    if (check_ddkey($_POST['t_dedupe'])) {

        if ($newthread) {
        
            $folderdata = folder_get($t_fid);
            
            if ($folderdata['ACCESS_LEVEL'] == 2 && !folder_is_accessible($t_fid) && !perm_is_moderator()) {
        
                html_draw_top();
                
                echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
                echo "<table class=\"posthead\" width=\"720\">\n";
                echo "<tr><td class=\"subhead\">".$lang['threadclosed']."</td></tr>\n";
                echo "<tr><td>\n";
                echo "<h2>".$lang['threadisclosedforposting']."</h2>\n";
                echo "</td></tr>\n";
 
                echo "<tr><td align=\"center\">\n";
                echo form_submit('cancel', $lang['cancel']);
                echo "</td></tr>\n";
                echo "</table></form>\n";
 
                html_draw_bottom();
                exit;
            }        

            if (isset($_POST['t_closed'])) $t_closed = $_POST['t_closed'];
            if (isset($_POST['old_t_closed'])) $old_t_closed = $_POST['old_t_closed'];
            if (isset($_POST['t_sticky'])) $t_sticky = $_POST['t_sticky'];
            if (isset($_POST['old_t_sticky'])) $old_t_sticky = $_POST['old_t_sticky'];

            if (bh_session_get_value("STATUS") & PERM_CHECK_WORKER) {
                $t_closed = isset($t_closed) && $t_closed == "Y" ? true : false;
                $t_sticky = isset($t_sticky) && $t_sticky == "Y" ? "Y" : "N";
            } else {
                $t_closed = false;
                $t_sticky = "N";
            }

            $t_tid = post_create_thread($t_fid, ($t_threadtitle), "N", $t_sticky, $t_closed);
            $t_rpid = 0;

        }else{

            $t_tid = $_POST['t_tid'];
            $t_rpid = $_POST['t_rpid'];
            
            if (isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 && (!(bh_session_get_value('STATUS') & PERM_CHECK_WORKER))) {

                html_draw_top();
                
                echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
                echo "<table class=\"posthead\" width=\"720\">\n";
                echo "<tr><td class=\"subhead\">".$lang['threadclosed']."</td></tr>\n";
                echo "<tr><td>\n";
                echo "<h2>".$lang['threadisclosedforposting']."</h2>\n";
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

            if (bh_session_get_value("STATUS") & PERM_CHECK_WORKER) {

                if (isset($_POST['t_closed'])) $t_closed = $_POST['t_closed'];
                if (isset($_POST['old_t_closed'])) $old_t_closed = $_POST['old_t_closed'];
                if (isset($_POST['t_sticky'])) $t_sticky = $_POST['t_sticky'];
                if (isset($_POST['old_t_sticky'])) $old_t_sticky = $_POST['old_t_sticky'];

                if (isset($t_closed) && isset($old_t_closed) && $t_closed != $old_t_closed && $t_closed == "Y") {
                    thread_set_closed($t_tid, true);
                } elseif ((!isset($t_closed) || (isset($t_closed) && $t_closed != "Y")) && $old_t_closed == "Y") {
                    thread_set_closed($t_tid, false);
                }
                if (isset($t_sticky) && isset($old_t_sticky) && $t_sticky != $old_t_sticky && $t_sticky == "Y") {
                    thread_set_sticky($t_tid, true);
                } elseif ((!isset($t_sticky) || (isset($t_sticky) && $t_sticky != "Y")) && $old_t_sticky == "Y") {
                    thread_set_sticky($t_tid, false);
                }
            }
        }

        if ($t_tid > 0) {

            if (trim($t_sig) != "") {
                $t_content.= "\n<div class=\"sig\">".$t_sig."</div>";

            }

            $new_pid = post_create($t_tid, $t_rpid, bh_session_get_value('UID'), $_POST['t_to_uid'], $t_content);

            if (bh_session_get_value('MARK_AS_OF_INT')) thread_set_interest($t_tid, 1, $newthread);

            if (!(user_get_status(bh_session_get_value('UID')) & USER_PERM_WORM)) {
                email_sendnotification($_POST['t_to_uid'], "$t_tid.$new_pid", bh_session_get_value('UID'));
                email_sendsubscription($_POST['t_to_uid'], "$t_tid.$new_pid", bh_session_get_value('UID'));
            }
            
            if (isset($_POST['aid']) && forum_get_setting('attachments_enabled', 'Y', false)) {
                if (get_num_attachments($_POST['aid']) > 0) post_save_attachment_id($t_tid, $new_pid, $_POST['aid']);
            }             
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

        if ($t_tid > 0 && $t_rpid > 0) {

          $uri = "./discussion.php?webtag=$webtag&msg=$t_tid.$t_rpid";

        }else{

          $uri = "./discussion.php?webtag=$webtag";

        }

        header_redirect($uri);
        exit;

    }else{

        $error_html = "<h2>{$lang['errorcreatingpost']}</h2>";

    }

}

html_draw_top("onUnload=clearFocus()", "basetarget=_blank", "post.js", "openprofile.js", "htmltools.js", "emoticons.js");

if (!isset($_POST['aid'])) {
    $aid = md5(uniqid(rand()));
}else{
    $aid = $_POST['aid'];
}

echo "<h1 style=\"width: 99%\">".$lang['postmessage']."</h1>\n";
echo "<br /><form name=\"f_post\" action=\"post.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";

if (!$newthread) {

    if (isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0) {

        echo "<table class=\"posthead\" width=\"720\">\n";
        echo "<tr><td class=\"subhead\">".$lang['threadclosed']."</td></tr>\n";
        echo "<tr><td>\n";

        if (bh_session_get_value('STATUS') & PERM_CHECK_WORKER) {
            echo "<h2>".$lang['moderatorthreadclosed']."</h2>\n";
            echo "</td></tr>\n";

        } else {
            echo "<h2>".$lang['threadisclosedforposting']."</h2>\n";
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

if ($valid && isset($_POST['preview'])) {

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['messagepreview']}</td></tr>";

    if ($_POST['t_to_uid'] == 0) {

        $preview_message['TLOGON'] = "ALL";
        $preview_message['TNICK'] = "ALL";

    }else{

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

    if (trim($t_sig) != "") {
        $preview_message['CONTENT'] = $preview_message['CONTENT']. "<div class=\"sig\">". $t_sig. "</div>";
    }

    $preview_message['CREATED'] = mktime();
    $preview_message['AID'] = $aid;

    echo "<tr><td>\n";
    message_display(0, $preview_message, 0, 0, true, false, false, false, $show_sigs, true);
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

if (!isset($t_sig)) {
    $has_sig = user_get_sig(bh_session_get_value('UID'), $t_sig, $t_sig_html);
}else{
    $has_sig = true;
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

if (!isset($t_fid)) {
    $t_fid = 0;
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


// ======================================
// =========== OPTIONS COLUMN ===========
echo "<td valign=\"top\" width=\"210\">\n";
echo "<table class=\"posthead\" width=\"210\">\n";
echo "<tr><td>\n";

if ($newthread) {

    echo "<h2>".$lang['folder'].":</h2>\n";
    echo folder_draw_dropdown($t_fid, "t_fid", "", FOLDER_ALLOW_NORMAL_THREAD, "style=\"width: 190px\"")."\n";
    echo "<h2>".$lang['threadtitle'].":</h2>\n";
    echo form_input_text("t_threadtitle", _htmlentities(_stripslashes($t_threadtitle)), 0, 0, "style=\"width: 190px\"")."\n";

    echo form_input_hidden("t_newthread", "Y")."\n";
    echo "<br />\n";

}else {

    echo "<h2>".$lang['folder'].":</h2>\n";
    echo _stripslashes($threaddata['FOLDER_TITLE'])."\n";
    echo "<h2>".$lang['threadtitle'].":</h2>\n";
    echo _stripslashes($threaddata['TITLE'])."\n";

    echo form_input_hidden("t_tid", $reply_to_tid);
    echo form_input_hidden("t_rpid", $reply_to_pid)."\n";
    echo "<br /><br />\n";
}

echo "<h2>".$lang['to'].":</h2>\n";

if (!$newthread) {
    echo form_radio("to_radio", "in_thread", $lang['usersinthread'], true)."<br />\n";
    echo post_draw_to_dropdown_in_thread($reply_to_tid, $t_to_uid, true, false, 'onClick="checkToRadio(0)"')."<br />\n";
}

echo form_radio("to_radio", "recent", $lang['recentvisitors'], $newthread ? true : false)."<br />\n";
echo post_draw_to_dropdown_recent($newthread && isset($t_to_uid) ? $t_to_uid : ($newthread ? -1 : 0))."<br />\n";

echo form_radio("to_radio", "others", $lang['others'])."<br />\n";
echo form_input_text("t_to_uid_others", "", 0, 0, "style=\"width: 190px\" onClick=\"checkToRadio(".($newthread ? 1 : 2).")\"")."<br /><br />\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);
if ($emot_prev != "") {
	echo "<h2>".$lang['emoticons'].":</h2>\n";
	echo $emot_prev."<br />\n";
}

if (bh_session_get_value("STATUS") & PERM_CHECK_WORKER) {

    echo "<h2>".$lang['admin'].":</h2>\n";

    echo form_checkbox("t_closed", "Y", $lang['closeforposting'], isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 ? true : false);
    echo "<br />".form_checkbox("t_sticky", "Y", $lang['makesticky'], isset($threaddata['STICKY']) && $threaddata['STICKY'] == "Y" ? true : false)."</p>\n";
    echo form_input_hidden("old_t_closed", isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 ? "Y" : "N");
    echo form_input_hidden("old_t_sticky", isset($threaddata['STICKY']) && $threaddata['STICKY'] == "Y" ? "Y" : "N");
}

echo "</td></tr>\n";
echo "</table>\n";
echo "</td>\n";
// ======================================


//echo "<td valign=\"top\" width=\"1\">&nbsp;</td>\n";


// ======================================
// =========== MESSAGE COLUMN ===========
echo "<td valign=\"top\" width=\"500\">\n";
echo "<table class=\"posthead\" width=\"500\">\n";
echo "<tr><td>\n";

if (!isset($t_to_uid)) $t_to_uid = -1;

echo "<h2>". $lang['message'] .":</h2>\n";

$tools = new TextAreaHTML("f_post");

echo $tools->toolbar(false, form_submit('submit', $lang['post'], 'onclick="closeAttachWin(); clearFocus()"'));

$t_content = $post->getTidyContent();
echo $tools->textarea("t_content", $t_content, 20, 0, "virtual", "style=\"width: 480px\" tabindex=\"1\"")."\n";



if ($post->isDiff()) {

	echo $tools->compare_original("t_content", $post->getOriginalContent());

    echo "<br /><br />\n";
}

echo "<h2>". $lang['htmlinmessage'] .":</h2>\n";

$tph_radio = $post->getHTML();

echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");

echo "<br /><br /><h2>". $lang['messageoptions'] .":</h2>\n";

echo form_submit('submit', $lang['post'], 'tabindex="2" onclick="closeAttachWin(); clearFocus()"');
echo "&nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onClick="clearFocus()"');
echo "&nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y', false)) {

    echo "&nbsp;".form_button("attachments", $lang['attachments'], "tabindex=\"5\" onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", $aid);
}


// ---- SIGNATURE ----
echo "<br /><br /><h2>". $lang['signature'] .":</h2>\n";

$t_sig = $sig->getTidyContent();

echo $tools->textarea("t_sig", $t_sig, 5, 0, "virtual", "tabindex=\"7\" style=\"width: 480px\"")."\n";

echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N")."\n";

if ($sig->isDiff()) {

	echo $tools->compare_original("t_sig", $sig->getOriginalContent());

}

echo "</td></tr>\n";
echo "</table>";
echo "</td>\n";
// ======================================


echo "</tr>\n";
echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
echo "</table>\n";


echo $tools->js();


if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $_POST['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

if (!$newthread) {

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">". $lang['inreplyto'] .":</td></tr>\n";
    echo "<tr><td>\n";

    if (($threaddata['POLL_FLAG'] == 'Y') && ($reply_message['PID'] == 1)) {

      poll_display($reply_to_tid, $threaddata['LENGTH'], $reply_to_pid, false, false, false, true, $show_sigs, true);

    }else {

      message_display($reply_to_tid, $reply_message, $threaddata['LENGTH'], $reply_to_pid, true, false, false, false, $show_sigs, true);

    }

    echo "<br /></td></tr>\n";
    echo "</table>\n";
}

echo "</form>\n";

html_draw_bottom();

?>