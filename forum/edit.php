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

/* $Id: edit.php,v 1.153 2004-11-02 19:24:21 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

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

// Check that we have access to this forum

if (!forum_check_access_level()) {
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

if (!perm_check_folder_permissions($t_fid, USER_PERM_POST_EDIT | USER_PERM_POST_READ)) {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannoteditpostsinthisfolder']}</h2>\n";

    html_draw_bottom();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;


// Get the user's post page preferences.
$page_prefs = bh_session_get_post_page_prefs();

$valid = true;

$fix_html = true;

html_draw_top("onUnload=clearFocus()", "basetarget=_blank", "edit.js", "openprofile.js", "htmltools.js", "emoticons.js");

$t_content = "";
$t_sig = "";

if (isset($_POST['t_post_emots'])) {
        if ($_POST['t_post_emots'] == "disabled") {
                $emots_enabled = false;
        } else {
                $emots_enabled = true;
        }
} else {
        $emots_enabled = true;
}
if (isset($_POST['t_post_links'])) {
        if ($_POST['t_post_links'] == "enabled") {
                $links_enabled = true;
        } else {
                $links_enabled = false;
        }
} else {
        $links_enabled = false;
}

$post_html = 0;
$sig_html = 2;

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
                $post_html = 1;
    } else if ($t_post_html == "enabled") {
                $post_html = 2;
    }

} else {
        if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
                $post_html = 1;
        } else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
                $post_html = 2;
        } else {
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
}else{
    $aid = md5(uniqid(rand()));
}

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, "", true, false);

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
        }
        if ($sig->getHTML() > 0) {
                $sig->setHTML(false);
        }
}

if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {

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
if (isset($_POST['t_sig']) && trim($_POST['t_sig']) != "") {

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

    if (get_num_attachments($aid) > 0 && !perm_check_folder_permissions($t_fid, USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ)) {
        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    if ($valid) {

        $preview_message['CONTENT'] = $t_content;

                if ($allow_sig == true) {
                $preview_message['CONTENT'].= "<div class=\"sig\">$t_sig</div>";
                }

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

    if (strlen(trim($t_content)) == 0) {
        $error_html = "<h2>{$lang['mustenterpostcontent']}</h2>";
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !perm_check_folder_permissions($t_fid, USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ)) {
        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    if (((forum_get_setting('allow_post_editing', 'N', false)) || (bh_session_get_value('UID') != $editmessage['FROM_UID']) || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS)) && intval(forum_get_setting('post_edit_time')) != 0)) && !perm_is_moderator($t_fid)) {

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

                if ($allow_sig == true) {
                    $t_content_tmp = $t_content."<div class=\"sig\">$t_sig</div>";
                } else {
                    $t_content_tmp = $t_content;
                }

        $updated = post_update($tid, $pid, $t_content_tmp);

        if ($updated) {

            post_add_edit_text($tid, $pid);

            if (isset($aid) && forum_get_setting('attachments_enabled', 'Y', false)) {
                if (get_num_attachments($aid) > 0) post_save_attachment_id($tid, $pid, $aid);
            }

                        if ($preview_message['FROM_UID'] != bh_session_get_value('UID')) {
                    admin_addlog(0, $t_fid, $tid, $pid, 0, 0, 23);
                        }

            echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
            echo "  <!--\n";
            echo "    function clearFocus() {\n";
            echo "      return;\n";
            echo "    }\n";
            echo "  //-->\n";
            echo "</script>\n";

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

} else if (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x'])) {

        if (isset($_POST['t_content'])) {
                $t_content = _htmlentities(trim(_stripslashes($_POST['t_content'])));
        $post->setContent($t_content);
        $t_content = $post->getContent();
        }

        if (isset($_POST['t_sig'])) {
                $t_sig = _htmlentities(trim(_stripslashes($_POST['t_sig'])));
        $sig->setContent($t_sig);
        $t_sig = $sig->getContent();
        }

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
                $page_prefs ^= POST_EMOTICONS_DISPLAY;
        } else {
                $page_prefs ^= POST_SIGNATURE_DISPLAY;
        }

        user_update_prefs(bh_session_get_value('UID'), array('POST_PAGE' => $page_prefs));

        $fix_html = false;

} else {

    $editmessage = messages_get($tid, $pid, 1);

    if (count($editmessage) > 0) {

        if ($editmessage['CONTENT'] = message_get_content($tid, $pid)) {

            if (((forum_get_setting('allow_post_editing', 'N', false)) || (bh_session_get_value('UID') != $editmessage['FROM_UID']) || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS)) && intval(forum_get_setting('post_edit_time')) != 0)) && !perm_is_moderator($t_fid)) {

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

               if (threads_any_unread() && $msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

                   form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");

               }else {

                   bh_setcookie('bh_thread_mode', 0);
                   $msg = messages_get_most_recent(bh_session_get_value('UID'));
                   form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");
               }

           }else {

               form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid", "_self");
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

               if (threads_any_unread() && $msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

                   form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");

               }else {

                   bh_setcookie('bh_thread_mode', 0);
                   $msg = messages_get_most_recent(bh_session_get_value('UID'));
                   form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");
               }

           }else {

               form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid", "_self");
           }

           echo "</table>\n";

           html_draw_bottom();
           exit;
    }

    unset($editmessage);
}

echo "<h1 style=\"width: 99%\">{$lang['editmessage']} $tid.$pid</h1>\n";
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

echo "<h2>".$lang['folder'].":</h2>\n";
echo _stripslashes($threaddata['FOLDER_TITLE'])."\n";
echo "<h2>".$lang['threadtitle'].":</h2>\n";
echo apply_wordfilter(_stripslashes($threaddata['TITLE'])), "\n";

echo form_input_hidden("t_msg", $edit_msg);
echo form_input_hidden("t_to_uid", $to_uid);
echo form_input_hidden("t_from_uid", $from_uid);

echo "<h2>".$lang['to'].":</h2>\n";
if ($preview_message['TLOGON'] != "ALL") {
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile($to_uid, '$webtag')\" target=\"_self\">";
        echo _stripslashes(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']));
        echo "</a><br /><br />\n";
} else {
        echo _stripslashes(format_user_name($preview_message['TLOGON'], $preview_message['TNICK']));
}

echo "<h2>". $lang['messageoptions'] .":</h2>\n";

echo form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br /><br />\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if ($emot_prev != "") {
        echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
        echo "  <tr>\n";
        echo "    <td class=\"subhead\">\n";
        echo "      <div style=\"float:left\">&nbsp;{$lang['emoticons']}:</div>\n";

        if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
                echo "      <div style=\"float:right\">". form_submit_image('emots_hide.png', 'emots_toggle', 'hide'). "</div>\n";
                echo "    </td>\n";
                echo "  </tr>\n";

                echo "  <tr>\n";
                echo "    <td colspan=\"2\">\n";
                echo $emot_prev;
        } else {
                echo "      <div style=\"float:right\">". form_submit_image('emots_show.png', 'emots_toggle', 'show'). "</div>\n";
        }

        echo "    </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
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

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

if ($allow_html == true && ($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
        echo $tools->toolbar(false, form_submit('submit', $lang['post'], 'onclick="closeAttachWin(); clearFocus()"'));
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "style=\"width: 480px\" tabindex=\"1\"")."\n";

if ($post->isDiff() && $fix_html) {

        echo $tools->compare_original("t_content", $post->getOriginalContent());

        echo "<br /><br />\n";
}

if ($allow_html == true) {
        echo "<h2>". $lang['htmlinmessage'] .":</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
        echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
                echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
        }

} else {
        echo form_input_hidden("t_post_html", "disabled");
}

echo "<br /><br />\n";
echo form_submit('submit',$lang['apply'], 'tabindex="2" onclick="closeAttachWin(); clearFocus()"');
echo "&nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onclick="clearFocus()"');
echo "&nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y', false) && perm_check_folder_permissions($t_fid, USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ)) {

    if ($aid = get_attachment_id($tid, $pid)) {
        echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
        echo form_input_hidden('aid', $aid);
    }else {
        $aid = md5(uniqid(rand()));
        echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
        echo form_input_hidden('aid', $aid);
    }
}

// ---- SIGNATURE ----
if ($allow_sig == true) {

        echo "<br /><br /><table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
        echo "  <tr>\n";
        echo "    <td class=\"subhead\">\n";
        echo "      <div style=\"float:left\">&nbsp;{$lang['signature']}:</div>\n";

        $t_sig = ($fix_html ? $sig->getTidyContent() : $sig->getOriginalContent());

        if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
                echo "      <div style=\"float:right\">". form_submit_image('sig_hide.png', 'sig_toggle', 'hide'). "</div>\n";
                echo "    </td>\n";
                echo "  </tr>\n";

                echo "  <tr>\n";
                echo "    <td colspan=\"2\">\n";

                echo $tools->textarea("t_sig", $t_sig, 5, 75, "virtual", "tabindex=\"7\" style=\"width: 480px\"")."\n";

                echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N")."\n";

                if ($sig->isDiff() && $fix_html && !$fetched_sig) {
                        echo $tools->compare_original("t_sig", $sig->getOriginalContent());
                }

        } else {
                echo "      <div style=\"float:right\">". form_submit_image('sig_show.png', 'sig_toggle', 'show'). "</div>\n";
                echo "      ".form_input_hidden("t_sig", $t_sig)."\n";
        }

        echo "    </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";

}


echo $tools->js();


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