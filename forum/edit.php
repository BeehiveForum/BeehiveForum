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

/* $Id: edit.php,v 1.185 2006-03-19 18:38:14 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
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

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $edit_msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {

    $edit_msg = $_POST['t_msg'];
    list($tid, $pid) = explode('.', $_POST['t_msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();

    echo "<h1>{$lang['editmessage']}</h1>\n";
    echo "<br />\n";

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['error']}</td></tr>\n";
    echo "<tr><td>\n";

    echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>\n";
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

    echo "<h1>{$lang['editmessage']} $tid.$pid</h1>\n";
    echo "<br />\n";

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "<tr><td class=\"subhead\">{$lang['error']}</td></tr>\n";
    echo "<tr><td>\n";

    echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>\n";
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

if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['emailconfirmationrequiredbeforepost']}</h2>\n";
    echo "<h2><a href=\"\">{$lang['resendconfirmation']}</a></h2>\n";

    html_draw_bottom();
    exit;
}

if (!bh_session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannoteditpostsinthisfolder']}</h2>\n";

    html_draw_bottom();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

// User UID
$uid = bh_session_get_value('UID');

// Get the user's post page preferences.
$page_prefs = bh_session_get_post_page_prefs();

$valid = true;

$fix_html = true;

html_draw_top("onUnload=clearFocus()", "basetarget=_blank", "edit.js", "openprofile.js", "dictionary.js", "htmltools.js", "emoticons.js");

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

$post_html = 0;
$sig_html = 2;

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = 1;
    }else if ($t_post_html == "enabled") {
        $post_html = 2;
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
    $links_enabled = $page_prefs & POST_AUTO_LINKS;
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = get_attachment_id($tid, $pid)) {

    $aid = md5(uniqid(rand()));
}

post_save_attachment_id($tid, $pid, $aid);

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, "", true, false);

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
    }

    if ($sig->getHTML() > 0) {
        $sig->setHTML(false);
    }
}

if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

    $t_content = trim(_stripslashes($_POST['t_content']));

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

if (isset($_POST['t_sig']) && strlen(trim(_stripslashes($_POST['t_sig']))) > 0) {

    $t_sig = trim(_stripslashes($_POST['t_sig']));

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

    if (strlen(trim($t_content)) == 0) {
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    if ($valid) {

        $preview_message['CONTENT'] = $t_content;

        if ($allow_sig == true) {

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

}else if (isset($_POST['submit'])) {

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

    if (strlen(trim($t_content)) == 0) {
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    if (((forum_get_setting('allow_post_editing', 'N'))
        || ((bh_session_get_value('UID') != $editmessage['FROM_UID']) && !(perm_get_user_permissions($editmessage['FROM_UID']) & USER_PERM_PILLORIED))
        || (perm_get_user_permissions(bh_session_get_value('UID')) & USER_PERM_PILLORIED)
        || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time', false, 0)) * HOUR_IN_SECONDS)) && intval(forum_get_setting('post_edit_time', false, 0)) != 0)) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        echo "<h1>{$lang['editmessage']} $tid.$pid</h1>\n";
        echo "<br />\n";

        echo "<table class=\"posthead\" width=\"720\">\n";
        echo "<tr><td class=\"subhead\">{$lang['error']}</td></tr>\n";
        echo "<tr><td>\n";

        echo "<h2>{$lang['nopermissiontoedit']}</h2>\n";
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

        if ($allow_sig == true) {

            $t_content_tmp = $t_content."<div class=\"sig\">$t_sig</div>";

        }else {

            $t_content_tmp = $t_content;
        }

        $updated = post_update($t_fid, $tid, $pid, $t_content_tmp);

        if ($updated) {

            post_add_edit_text($tid, $pid);

            post_save_attachment_id($tid, $pid, $aid);

            if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != bh_session_get_value('UID')) {
                admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
            }

            echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
            echo "  <!--\n";
            echo "    function clearFocus() {\n";
            echo "      return;\n";
            echo "    }\n";
            echo "  //-->\n";
            echo "</script>\n";

            echo "<h1>{$lang['editmessage']} $tid.$pid</h1>\n";
            echo "<br />\n";

            echo "<table class=\"posthead\" width=\"720\">\n";
            echo "<tr><td class=\"subhead\">{$lang['editmessage']}</td></tr>\n";
            echo "<tr><td>\n";

            echo "<h2>{$lang['editappliedtomessage']}</h2>\n";
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

}else if (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x'])) {

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

    if (isset($_POST['emots_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs['POST_PAGE'] = $page_prefs;
    $user_prefs_global['POST_PAGE'] = true;

    user_update_prefs($uid, $user_prefs, $user_prefs_global);

}else {

    $editmessage = messages_get($tid, $pid, 1);

    if (count($editmessage) > 0) {

        if ($editmessage['CONTENT'] = message_get_content($tid, $pid)) {

            if (((forum_get_setting('allow_post_editing', 'N'))
                || ((bh_session_get_value('UID') != $editmessage['FROM_UID']) && !(perm_get_user_permissions($editmessage['FROM_UID']) & USER_PERM_PILLORIED))
                || (perm_get_user_permissions(bh_session_get_value('UID')) & USER_PERM_PILLORIED)
                || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time', false, 0)) * HOUR_IN_SECONDS)) && intval(forum_get_setting('post_edit_time', false, 0)) != 0)) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                echo "<h1>{$lang['editmessage']} $tid.$pid</h1>\n";
                echo "<br />\n";

                echo "<table class=\"posthead\" width=\"720\">\n";
                echo "<tr><td class=\"subhead\">{$lang['error']}</td></tr>\n";
                echo "<tr><td>\n";

                echo "<h2>{$lang['nopermissiontoedit']}</h2>\n";
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

            $parsed_message = new MessageTextParse($editmessage['CONTENT'], $emots_enabled);

            $emots_enabled = $parsed_message->getEmoticons();
            $links_enabled = $parsed_message->getLinks();
            $t_content = $parsed_message->getMessage();
            $post_html = $parsed_message->getMessageHTML();
            $t_sig = $parsed_message->getSig();

            $post = new MessageText($allow_html ? $post_html : false, $t_content, $emots_enabled, $links_enabled);
            $sig = new MessageText($allow_html ? $sig_html : false, $t_sig, true, false);

            $post->diff = false;
            $sig->diff = false;

            $t_content = $post->getContent();
            $t_sig = $sig->getContent();

        }else {

           echo "<table class=\"posthead\" width=\"720\">\n";
           echo "  <tr>\n";
           echo "    <td class=\"subhead\">{$lang['error']}</td>\n";
           echo "  </tr>";
           echo "  <tr>\n";
           echo "    <td><h2>{$lang['message']} {$_GET['msg']} {$lang['wasnotfound']}</h2></td>\n";
           echo "  </tr>\n";
           echo "  <tr>\n";
           echo "    <td align=\"center\">\n";

           $thread_length = thread_get_length($tid);

           if ($thread_length < 1) {

               if ($msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

                   echo form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");

               }else {

                   bh_setcookie('bh_thread_mode', 0);
                   $msg = messages_get_most_recent(bh_session_get_value('UID'));
                   echo form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");
               }

           }else {

               echo form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid", "_self");
           }

           echo "</table>\n";

           html_draw_bottom();
           exit;
        }

    }else{

           echo "<table class=\"posthead\" width=\"720\">\n";
           echo "  <tr>\n";
           echo "    <td class=\"subhead\">{$lang['error']}</td>\n";
           echo "  </tr>";
           echo "  <tr>\n";
           echo "    <td><h2>{$lang['message']} {$_GET['msg']} {$lang['wasnotfound']}</h2></td>\n";
           echo "  </tr>\n";
           echo "  <tr>\n";
           echo "    <td align=\"center\">\n";

           $thread_length = thread_get_length($tid);

           if ($thread_length < 1) {

               if ($msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

                   echo form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");

               }else {

                   bh_setcookie('bh_thread_mode', 0);
                   $msg = messages_get_most_recent(bh_session_get_value('UID'));
                   echo form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");
               }

           }else {

               echo form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid", "_self");
           }

           echo "</table>\n";

           html_draw_bottom();
           exit;
    }
}

echo "<h1>{$lang['editmessage']} $tid.$pid</h1>\n";
echo "<br /><form name=\"f_edit\" action=\"edit.php\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('webtag', $webtag), "\n";

$tools = new TextAreaHTML("f_edit");
echo $tools->preload();

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

echo "<h2>{$lang['folder']}:</h2>\n";
echo _stripslashes($threaddata['FOLDER_TITLE'])."\n";
echo "<h2>{$lang['threadtitle']}:</h2>\n";
echo apply_wordfilter(_stripslashes($threaddata['TITLE'])), "\n";

echo form_input_hidden("t_msg", $edit_msg);
echo form_input_hidden("t_to_uid", $to_uid);
echo form_input_hidden("t_from_uid", $from_uid);

echo "<h2>{$lang['to']}:</h2>\n";

if ($preview_message['TLOGON'] != $lang['allcaps']) {

    echo "<a href=\"javascript:void(0);\" onclick=\"openProfile($to_uid, '$webtag')\" target=\"_self\">";
    echo _stripslashes(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']));
    echo "</a><br /><br />\n";

}else {

    echo _stripslashes(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']));
}

echo "<h2>{$lang['messageoptions']}:</h2>\n";

echo form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br /><br />\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if ($emot_prev != "") {

    echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">&nbsp;{$lang['emoticons']}:</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {

        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('emots_hide.png', 'emots_toggle', 'hide'), "</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('emots_show.png', 'emots_toggle', 'show'), "</td>\n";
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

echo "<h2>{$lang['message']}:</h2>\n";

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

$tool_type = 0;
if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = 1;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = 2;
}

if ($allow_html == true && $tool_type != 0) {
    echo $tools->toolbar(false, form_submit("submit", $lang['apply'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));
} else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "tabindex=\"1\"", "post_content"), "\n";

if ($post->isDiff() && $fix_html) {

    echo $tools->compare_original("t_content", $post->getOriginalContent());

    if ($tools->getTinyMCE()) {
        echo "<br />\n";
    } else {
        echo "<br /><br />\n";
    }
}

if ($allow_html == true) {

    if ($tools->getTinyMCE()) {

        echo form_input_hidden("t_post_html", "enabled");

    } else {

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

if ($tools->getTinyMCE()) {
    echo "<br />\n";
} else {
    echo "<br /><br />\n";
}
echo form_submit('submit',$lang['apply'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "&nbsp;".form_submit("preview", $lang['preview'], "tabindex=\"3\" onclick=\"clearFocus()\"");
echo "&nbsp;".form_submit("cancel", $lang['cancel'], "tabindex=\"4\" onclick=\"closeAttachWin(); clearFocus()\"");

if (forum_get_setting('attachments_enabled', 'Y') && bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$from_uid', '$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}

if ($allow_sig == true) {

    echo "<br /><br /><table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">&nbsp;{$lang['signature']}:</td>\n";

    $t_sig = ($fix_html ? $sig->getTidyContent() : $sig->getOriginalContent());

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {

        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('sig_hide.png', 'sig_toggle', 'hide'), "</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td colspan=\"2\">", $tools->textarea("t_sig", $t_sig, 5, 75, "virtual", "tabindex=\"7\"", "signature_content"), "</td>\n";

        echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N")."\n";

        if ($sig->isDiff() && $fix_html) {

            echo $tools->compare_original("t_sig", $sig->getOriginalContent());
        }

    }else {

        echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('sig_show.png', 'sig_toggle', 'hide'), "</td>\n";
        echo "    ", form_input_hidden("t_sig", $t_sig), "\n";
    }

    echo "  </tr>\n";
    echo "</table>\n";
}

echo $tools->js();

echo "</td></tr>\n";
echo "</table>";
echo "</td>\n";
echo "</tr>\n";
echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
echo "</table>\n";
echo "</form>";

html_draw_bottom();

?>
