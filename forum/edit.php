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

/* $Id: edit.php,v 1.126 2004-05-04 17:10:17 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/attachments.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/folder.inc.php");
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

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

  $edit_msg = $_GET['msg'];
  list($tid, $pid) = explode('.', $_GET['msg']);

}elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {

  $edit_msg = $_POST['t_msg'];
  list($tid, $pid) = explode('.', $_POST['t_msg']);

}else {

    html_draw_top();

    echo "<h1 style=\"width: 99%\">{$lang['editmessage']}</h1>\n";
    echo "<br />\n";

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">".$lang['error']."</td></tr>\n";
    echo "<tr><td>\n";

    echo "<h2>".$lang['nomessagespecifiedforedit']."</h2>\n";
    echo "</td></tr>\n";

    echo "<tr><td align=\"center\">\n";
    echo form_quick_button("./discussion.php", $lang['back']);
    echo "</td></tr>\n";
    echo "</table>\n";

    html_draw_bottom();
    exit;

}

if (!is_numeric($tid) || !is_numeric($pid)) {

    html_draw_top();

    echo "<h1 style=\"width: 99%\">{$lang['editmessage']} $tid.$pid</h1>\n";
    echo "<br />\n";

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">".$lang['error']."</td></tr>\n";
    echo "<tr><td>\n";

    echo "<h2>".$lang['nomessagespecifiedforedit']."</h2>\n";
    echo "</td></tr>\n";

    echo "<tr><td align=\"center\">\n";
    echo form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid");
    echo "</td></tr>\n";
    echo "</table>\n";

    html_draw_bottom();
    exit;

}

if (thread_is_poll($tid) && $pid == 1) {

    $uri = "./edit_poll.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg=". $_GET['msg'];
    }elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {
        $uri.= "&msg=". $_POST['t_msg'];
    }

    header_redirect($uri);
}

if (isset($_POST['cancel'])) {

    $uri = "./discussion.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg=". $_GET['msg'];
    }elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {
        $uri.= "&msg=". $_POST['t_msg'];
    }

    header_redirect($uri);
}

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

html_draw_top("onUnload=clearFocus()", "basetarget=_blank", "edit.js", "openprofile.js", "htmltools.js", "emoticons.js");

$t_content = "";
$t_sig = "";

$post_html = 0;
$sig_html = 2;

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

$post = new MessageText($post_html);
$sig = new MessageText($sig_html);

if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
	$t_content = $_POST['t_content'];

	if ($post_html && attachment_embed_check($t_content)) {
		$error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
		$valid = false;
	}

	$post->setContent($t_content);
	$t_content = $post->getContent();

	if (strlen($t_content) >= 65535) {
		$error_html = "<h2>{$lang['reducemessagelength']} ".number_format(strlen($t_content)).")</h2>";
		$valid = false;
	}
}
if (isset($_POST['t_sig']) && trim($_POST['t_sig']) != "") {
	$t_sig = $_POST['t_sig'];

	if (attachment_embed_check($t_sig)) {
		$error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
		$valid = false;
	}

	$sig->setContent($t_sig);
	$t_sig = $sig->getContent();

	if (strlen($t_sig) >= 65535) {
		$error_html = "<h2>{$lang['reducesiglength']} ".number_format(strlen($t_sig)).")</h2>";
		$valid = false;
	}
}

if (isset($_POST['preview'])) {
    $preview_message = messages_get($tid, $pid, 1);

    if (isset($_POST['t_to_uid'])) {
        $to_uid = $_POST['t_to_uid'];
    }else {
        $error_html = "<h2>{$lang['invalidusername']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {
        $from_uid = $_POST['t_from_uid'];
    }else {
        $error_html = "<h2>{$lang['invalidusername']}</h2>\n";
        $valid = false;
    }

	if (trim($t_content) == "") {
		$error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
		$valid = false;
	}

    if ($valid) {
        $preview_message['CONTENT'] = $t_content;
        $preview_message['CONTENT'].= "<div class=\"sig\">$t_sig</div>";

        if ($to_uid == 0) {

            $preview_message['TLOGON'] = "ALL";
            $preview_message['TNICK'] = "ALL";

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
    }

} else if (isset($_POST['submit'])) {
    $editmessage = messages_get($tid, $pid, 1);

    if (isset($_POST['t_to_uid'])) {
        $to_uid = $_POST['t_to_uid'];
    }else {
        $error_html = "<h2>{$lang['invalidusername']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {
        $from_uid = $_POST['t_from_uid'];
    }else {
        $error_html = "<h2>{$lang['invalidusername']}</h2>\n";
        $valid = false;
    }

	if (trim($t_content) == "") {
		$error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
		$valid = false;
	}

    if (((forum_get_setting('allow_post_editing', 'N', false)) || (bh_session_get_value('UID') != $editmessage['FROM_UID']) || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS)) && intval(forum_get_setting('post_edit_time')) != 0)) && !perm_is_moderator()) {

        echo "<h1 style=\"width: 99%\">{$lang['editmessage']} $tid.$pid</h1>\n";
        echo "<br />\n";

        echo "<table class=\"posthead\" width=\"720\">\n";
        echo "<tr><td class=\"subhead\">".$lang['error']."</td></tr>\n";
        echo "<tr><td>\n";

        echo "<h2>".$lang['nopermissiontoedit']."</h2>\n";
        echo "</td></tr>\n";

        echo "<tr><td align=\"center\">\n";
        echo form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid");
        echo "</td></tr>\n";
        echo "</table>\n";

        html_draw_bottom();
        exit;
    }

    $preview_message = $editmessage;

    if ($valid) {
        $t_content_tmp = $t_content."<div class=\"sig\">$t_sig</div>";

        $updated = post_update($tid, $pid, $t_content_tmp);

        if ($updated) {

            post_add_edit_text($tid, $pid);

            if (isset($_POST['aid']) && forum_get_setting('attachments_enabled', 'Y', false)) {
                if (get_num_attachments($_POST['aid']) > 0) post_save_attachment_id($tid, $pid, $_POST['aid']);
            }

            if (perm_is_moderator() && ($_POST['t_from_uid'] != bh_session_get_value('UID'))) {
                admin_addlog(0, 0, $tid, $pid, 0, 0, 23);
            }

            echo "<h1 style=\"width: 99%\">{$lang['editmessage']} $tid.$pid</h1>\n";
            echo "<br />\n";

            echo "<table class=\"posthead\" width=\"720\">\n";
            echo "<tr><td class=\"subhead\">".$lang['editmessage']."</td></tr>\n";
            echo "<tr><td>\n";

            echo "<h2>".$lang['editappliedtomessage']."</h2>\n";
            echo "</td></tr>\n";

            echo "<tr><td align=\"center\">\n";
            echo form_quick_button("discussion.php", $lang['continue'], "msg", "$tid.$pid");
            echo "</td></tr>\n";
            echo "</table>\n";

            html_draw_bottom();
            exit;

        }else{
            $error_html = "<h2>{$lang['errorupdatingpost']}</h2>";
        }
    }

}else{

    $editmessage = messages_get($tid, $pid, 1);

    if (count($editmessage) > 0) {

        $editmessage['CONTENT'] = message_get_content($tid, $pid);

        if (((forum_get_setting('allow_post_editing', 'N', false)) || (bh_session_get_value('UID') != $editmessage['FROM_UID']) || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS)) && intval(forum_get_setting('post_edit_time')) != 0)) && !perm_is_moderator()) {

            echo "<h1 style=\"width: 99%\">{$lang['editmessage']} $tid.$pid</h1>\n";
            echo "<br />\n";

            echo "<table class=\"posthead\" width=\"720\">\n";
            echo "<tr><td class=\"subhead\">".$lang['error']."</td></tr>\n";
            echo "<tr><td>\n";

            echo "<h2>".$lang['nopermissiontoedit']."</h2>\n";
            echo "</td></tr>\n";

            echo "<tr><td align=\"center\">\n";
            echo form_quick_button("discussion.php", $lang['back'], "msg", "$tid.$pid");
            echo "</td></tr>\n";
            echo "</table>\n";

            html_draw_bottom();
            exit;
        }

        $preview_message = $editmessage;

        $to_uid = $editmessage['TO_UID'];
        $from_uid = $editmessage['FROM_UID'];

        $t_content_temp = clean_emoticons($editmessage['CONTENT']);
        $t_content_temp = preg_split("/<div class=\"sig\">/", $t_content_temp);

        if (count($t_content_temp) > 1) {

            $t_sig_temp = array_pop($t_content_temp);
            $t_sig_temp = preg_split("/<\/div>/", $t_sig_temp);

            $t_sig = "";

            for ($i = 0; $i < count($t_sig_temp) - 1; $i++) {
                $t_sig.= $t_sig_temp[$i];
                if ($i < count($t_sig_temp) - 2 ) {
                    $t_sig.= "</div>";
                }
            }

        }else {
            $t_sig = "";
        }

        $t_content = "";

        for ($i = 0; $i < count($t_content_temp); $i++) {
            $t_content.= $t_content_temp[$i];
            if ($i < count($t_content_temp) - 1) {
                $t_content.= "<div class=\"sig\">";
            }
        }

		$t_content = _htmlentities_decode($t_content);
		$post_html = 0;
		$t_content_tmp = preg_replace("/<a href=\"([^\"]*)\">\\1<\/a>/", "\\1", $t_content);

		if (strip_tags($t_content, '<p><br>') != $t_content_tmp) {
			$post_html = 2;
		} else {
			$t_content = strip_tags($t_content);
		}

		$post = new MessageText($post_html, $t_content);
		$sig = new MessageText($sig_html, $t_sig);

		$t_content = $post->getContent();
		$t_sig = $sig->getContent();

    }else{
        $valid = false;
        $error_html = "<h2>{$lang['message']} ". $_GET['msg']. " {$lang['wasnotfound']}</h2>";
    }

    unset($editmessage);
}

echo "<h1 style=\"width: 99%\">{$lang['editmessage']} $tid.$pid</h1>\n";
echo "<br /><form name=\"f_edit\" action=\"edit.php\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('webtag', $webtag), "\n";

if (isset($error_html)) {
    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['error']}</td></tr>";
    echo "<tr><td>\n";
    echo $error_html . "\n";
    echo "</td></tr>\n";
    echo "</table>\n";
}

$threaddata = thread_get($tid);

if ($valid && isset($_POST['preview'])) {
    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['messagepreview']}</td></tr>";

    echo "<tr><td>\n";
    message_display($tid, $preview_message, $threaddata['LENGTH'], $pid, true, false, false, false, $show_sigs, true);
    echo "</td></tr>\n";

    echo "<tr><td>&nbsp;</td></tr>\n";
    echo "</table>\n";
}

echo "<table class=\"posthead\" width=\"720\">\n";
echo "<tr><td class=\"subhead\" colspan=\"2\">";
echo $lang['editmessage'];
echo "</td></tr>\n";
echo "<tr>\n";


// ======================================
// =========== OPTIONS COLUMN ===========
echo "<td valign=\"top\" width=\"210\">\n";
echo "<table class=\"posthead\" width=\"210\">\n";
echo "<tr><td>\n";

echo "<h2>".$lang['folder'].":</h2>\n";
echo _stripslashes($threaddata['FOLDER_TITLE'])."\n";
echo "<h2>".$lang['threadtitle'].":</h2>\n";
echo _stripslashes($threaddata['TITLE'])."\n";

echo form_input_hidden("t_msg", $edit_msg);
echo form_input_hidden("t_to_uid", $to_uid);
echo form_input_hidden("t_from_uid", $from_uid);

echo "<h2>".$lang['to'].":</h2>\n";
echo "<a href=\"javascript:void(0);\" onclick=\"openProfile($to_uid, '$webtag')\" target=\"_self\">";
echo _stripslashes(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']));
echo "</a><br /><br />\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);
if ($emot_prev != "") {
	echo "<h2>".$lang['emoticons'].":</h2>\n";
	echo $emot_prev."<br />\n";
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

echo "<h2>". $lang['message'] .":</h2>\n";

$tools = new TextAreaHTML("f_edit");

echo $tools->toolbar(false, form_submit('submit',$lang['apply'], 'onclick="closeAttachWin(); clearFocus()"'));

echo $tools->textarea("t_content", $post->getTidyContent(), 20, 0, "virtual", "style=\"width: 480px\" tabindex=\"1\"")."\n";

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

echo "<br /><br />\n";

echo "<h2>". $lang['messageoptions'] .":</h2>\n";

echo form_submit('submit',$lang['apply'], 'tabindex="2" onclick="closeAttachWin(); clearFocus()"');
echo "&nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onClick="clearFocus()"');
echo "&nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if ($aid = get_attachment_id($tid, $pid)) {
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}else {
    $aid = md5(uniqid(rand()));
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}

// ---- SIGNATURE ----
echo "<br /><br /><h2>". $lang['signature'] .":</h2>\n";

echo $tools->textarea("t_sig", $sig->getTidyContent(), 5, 0, "virtual", "tabindex=\"7\" style=\"width: 480px\"")."\n";

echo $tools->js();

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
echo "</form>";

html_draw_bottom();

?>