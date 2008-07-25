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

/* $Id: ledit.php,v 1.32 2008-07-25 18:12:55 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Intitalise a few variables

$webtag_search = false;

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

    $request_uri = rawurlencode(get_request_uri());
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

    light_html_guest_error();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $edit_msg = $_GET['msg'];

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['threadcouldnotbefound']);
        light_html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {

    $edit_msg = $_POST['t_msg'];

    list($tid, $pid) = explode('.', $_POST['t_msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['threadcouldnotbefound']);
        light_html_draw_bottom();
        exit;
    }

}else {

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['nomessagespecifiedforedit']);
    light_html_draw_bottom();
    exit;
}

if (thread_is_poll($tid) && $pid == 1) {

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['cannoteditpollsinlightmode']);
    light_html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {

    header_redirect("lmessages.php?webtag=$webtag&msg=$edit_msg");
    exit;
}

if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!bh_session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['cannoteditpostsinthisfolder']);
    light_html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid)) {

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['threadcouldnotbefound']);
    light_html_draw_bottom();
    exit;
}

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

$uid = bh_session_get_value('UID');

$page_prefs = bh_session_get_post_page_prefs();

$valid = true;

light_html_draw_top("robots=noindex,nofollow");

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

$post_html = POST_HTML_DISABLED;
$sig_html = POST_HTML_ENABLED;

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = POST_HTML_AUTO;
    }else if ($t_post_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
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
    $links_enabled = $page_prefs & POST_AUTO_LINKS;
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = get_attachment_id($tid, $pid)) {

    $aid = md5(uniqid(mt_rand()));
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

    $sig->setHTML(false, true);
}

if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

    $t_content = trim(_stripslashes($_POST['t_content']));

    if ($post_html && attachment_embed_check($t_content)) {

        $error_msg_array[] = $lang['notallowedembedattachmentpost'];
        $valid = false;
    }

    $post->setContent($t_content);
    $t_content = $post->getContent();

    if (strlen($t_content) >= 65535) {

        $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(strlen($t_content)));
        $valid = false;
    }
}

if (isset($_POST['t_sig']) && strlen(trim(_stripslashes($_POST['t_sig']))) > 0) {

    $t_sig = trim(_stripslashes($_POST['t_sig']));

    if (attachment_embed_check($t_sig)) {

        $error_msg_array[] = $lang['notallowedembedattachmentpost'];
        $valid = false;
    }

    $sig->setContent($t_sig);
    $t_sig = $sig->getContent();

    if (strlen($t_sig) >= 65535) {

        $error_msg_array[] = sprintf($lang['reducesiglength'], number_format(strlen($t_sig)));
        $valid = false;
    }
}

if (isset($_POST['preview'])) {

    if (!$preview_message = messages_get($tid, $pid, 1)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['postdoesnotexist']);
        light_html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_to_uid'])) {

        $to_uid = $_POST['t_to_uid'];

    }else {

        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {

        $from_uid = $_POST['t_from_uid'];

    }else {

        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (strlen(trim($t_content)) == 0) {

        $error_msg_array[] = $lang['mustenterpostcontent'];
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
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

}else if (isset($_POST['apply'])) {

    if (!$editmessage = messages_get($tid, $pid, 1)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['postdoesnotexist']);
        light_html_draw_bottom();
        exit;
    }

    if (isset($_POST['t_to_uid'])) {
        $to_uid = $_POST['t_to_uid'];
    }else {
        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (isset($_POST['t_from_uid'])) {
        $from_uid = $_POST['t_from_uid'];
    }else {
        $error_msg_array[] = $lang['invalidusername'];
        $valid = false;
    }

    if (strlen(trim($t_content)) == 0) {
        $error_msg_array[] = $lang['mustenterpostcontent'];
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
        $valid = false;
    }

    if (((forum_get_setting('allow_post_editing', 'N')) || ((bh_session_get_value('UID') != $editmessage['FROM_UID']) && !(perm_get_user_permissions($editmessage['FROM_UID']) & USER_PERM_PILLORIED)) || (bh_session_check_perm(USER_PERM_PILLORIED, 0)) || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)) && intval(forum_get_setting('post_edit_time', false, 0)) != 0)) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg(sprintf("<h1>{$lang['nopermissiontoedit']}</h1>\n", $edit_msg));
        light_html_draw_bottom();
        exit;
    }

    $preview_message = $editmessage;

    if ($valid) {

        if ($allow_sig == true) {

            $t_content_tmp = $t_content."<div class=\"sig\">$t_sig</div>";

        }else {

            $t_content_tmp = $t_content;
        }

        if (post_update($t_fid, $tid, $pid, $t_content_tmp)) {

            post_add_edit_text($tid, $pid);

            post_save_attachment_id($tid, $pid, $aid);

            if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != bh_session_get_value('UID')) {
                admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
            }

            header_redirect("lmessages.php?webtag=$webtag&msg=$edit_msg");
            exit;

        }else{

            $error_msg_array[] = $lang['errorupdatingpost'];
        }
    }

}else {

    if (!$editmessage = messages_get($tid, $pid, 1)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['postdoesnotexist']);
        light_html_draw_bottom();
        exit;
    }

    if (count($editmessage) > 0) {

        if (($editmessage['CONTENT'] = message_get_content($tid, $pid))) {

            if (((forum_get_setting('allow_post_editing', 'N')) || ((bh_session_get_value('UID') != $editmessage['FROM_UID']) && !(perm_get_user_permissions($editmessage['FROM_UID']) & USER_PERM_PILLORIED)) || (bh_session_check_perm(USER_PERM_PILLORIED, 0)) || (((time() - $editmessage['CREATED']) >= (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)) && intval(forum_get_setting('post_edit_time', false, 0)) != 0)) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

                light_html_draw_top("robots=noindex,nofollow");
                light_html_display_error_msg(sprintf("<h1>{$lang['nopermissiontoedit']}</h1>\n", $edit_msg));
                light_html_draw_bottom();
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

            echo sprintf("<h1>{$lang['editmessage']}</h1>\n", $edit_msg);
            echo sprintf("<h2>{$lang['messagewasnotfound']}</h2>\n", $edit_msg);
            exit;
        }

    }else{

        echo sprintf("<h1>{$lang['editmessage']}</h1>\n", $edit_msg);
        echo sprintf("<h2>{$lang['messagewasnotfound']}</h2>\n", $edit_msg);
        exit;
    }
}

echo sprintf("<h1>{$lang['editmessage']}</h1>\n", $edit_msg);

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<form name=\"f_edit\" action=\"ledit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo form_input_hidden("t_msg", _htmlentities($edit_msg));
echo form_input_hidden("t_to_uid", _htmlentities($to_uid));
echo form_input_hidden("t_from_uid", _htmlentities($from_uid));

if ($valid && isset($_POST['preview'])) {
    light_message_display($tid, $preview_message, $threaddata['LENGTH'], $pid, $threaddata['FID'], true, false, false, false, $show_sigs, true);
}

echo "<p>", light_form_textarea("t_content", $post->getTidyContent(), 15, 60), "</p>\n";

if ($allow_sig == true) {
    echo "<p>{$lang['signature']}:<br />", light_form_textarea("t_sig", $sig->getTidyContent(), 5, 60), form_input_hidden("t_sig_html", _htmlentities($sig->getHTML()))."</p>\n";
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

echo "<p>", light_form_submit("apply", $lang['apply']), "&nbsp;", light_form_submit("preview", $lang['preview']), "&nbsp;", light_form_submit("cancel", $lang['cancel']);
echo "</p>";

echo "</form>\n";

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";

light_html_draw_bottom();

?>