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

/* $Id: pm_edit.php,v 1.62 2005-02-06 00:38:46 decoyduck Exp $ */

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

include_once("./include/attachments.inc.php");
include_once("./include/email.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/htmltools.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access PMs

if ($uid == 0) {

    html_guest_error();
    exit;
}

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Prune old messages for the current user

pm_user_prune_folders();

// Get the Message ID (MID)

if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {
    $mid = $_GET['mid'];
}elseif (isset($_POST['mid']) && is_numeric($_POST['mid'])) {
    $mid = $_POST['mid'];
}else {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = get_attachment_id($tid, $pid)) {

    $aid = md5(uniqid(rand()));
}

// User clicked cancel

if (isset($_POST['cancel'])) {
    header_redirect("./pm.php?webtag=$webtag&folder=3");
}

$valid = true;

$fix_html = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false
$allow_html = true;

$t_content = "";

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

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = 1;
    }else if ($t_post_html == "enabled") {
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
        $links_enabled = ($page_prefs & POST_AUTO_LINKS);
}

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);

if (isset($_POST['submit']) || isset($_POST['preview'])) {

    if (isset($_POST['t_subject']) && trim($_POST['t_subject']) != "") {
        $t_subject = trim(_stripslashes($_POST['t_subject']));
    }else {
        $error_html = "<h2>{$lang['entersubjectformessage']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {

        $t_content = trim(_stripslashes($_POST['t_content']));

        $post->setContent($t_content);
        $t_content = $post->getContent();

        if (strlen($t_content) >= 65535) {
            $error_html = "<h2>{$lang['reducemessagelength']} ".number_format(strlen($t_content)).")</h2>";
            $valid = false;
        }

    }else {

        $error_html = "<h2>{$lang['entercontentformessage']}</h2>";
        $valid = false;
    }
}

// Update the PM

if ($valid && isset($_POST['preview'])) {

    $edit_html = ($_POST['t_post_html'] == "Y");

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX)) {

        $pm_elements_array['CONTENT'] = $t_content;

        $pm_elements_array['SUBJECT'] = _htmlentities($t_subject);
        $pm_elements_array['FOLDER'] = PM_FOLDER_OUTBOX;

    }else {
        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }

}else if ($valid && isset($_POST['submit'])) {

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX)) {

        $t_subject = _htmlentities($t_subject);

        if (forum_get_setting('attachments_enabled', 'Y', false)) {

            if (get_num_attachments($aid) > 0) pm_save_attachment_id($mid, $aid);
        }

        if (pm_edit_message($mid, $t_subject, $t_content)) {
            header_redirect("pm.php?webtag=$webtag&folder=3");
        }else {
            $error_html = "<h2>{$lang['errorcreatingpm']}</h2>";
            $valid = false;
        }

    }else {
        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }

} else if (isset($_POST['emots_toggle_x']) || isset($_POST['emots_toggle_y'])) {

    if (isset($_POST['t_subject']) && trim($_POST['t_subject']) != "") {
        $t_subject = _htmlentities(trim(_stripslashes($_POST['t_subject'])));
    }

    if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
        $t_content = trim(_stripslashes($_POST['t_content']));
        $post->setContent($t_content);
        $t_content = $post->getContent();
    }

    if (isset($_POST['to_radio']) && is_numeric($_POST['to_radio'])) {
        $to_radio = $_POST['to_radio'];
    }else {
        $to_radio = 1;
    }

    if (isset($_POST['t_to_uid']) && is_numeric($_POST['t_to_uid'])) {
        $t_to_uid = $_POST['t_to_uid'];
    }else {
        $t_to_uid = 0;
    }

    if (isset($_POST['t_recipient_list']) && trim($_POST['t_recipient_list']) != "") {

        $t_recipient_list = $_POST['t_recipient_list'];
    }

    $page_prefs ^= POST_EMOTICONS_DISPLAY;

    user_update_prefs($uid, array('POST_PAGE' => $page_prefs));

    $pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX);

    $fix_html = false;

} else {

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX)) {

        if ($pm_elements_array['TYPE'] != PM_UNREAD) {
            html_draw_top();
            pm_edit_refuse();
            html_draw_bottom();
            exit;
        }

        $parsed_message = new MessageTextParse(pm_get_content($mid), $emots_enabled, $links_enabled);

                $emots_enabled = $parsed_message->getEmoticons();
                $links_enabled = $parsed_message->getLinks();
                $t_content = $parsed_message->getMessage();
                $post_html = $parsed_message->getMessageHTML();

        $post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);

                $post->diff = false;

        $t_content = $post->getContent();
        $t_subject = $pm_elements_array['SUBJECT'];

    }else {

        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }
}

html_draw_top("onUnload=clearFocus()", "openprofile.js", "edit.js", "dictionary.js", "htmltools.js", "basetarget=_blank");
draw_header_pm();

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['editpm']}</b></td>\n";
echo "    <td class=\"pmheadr\" align=\"right\"><a href=\"pm_write.php?webtag=$webtag\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php?webtag=$webtag\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=2\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=3\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=4\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";

echo "<form name=\"f_post\" action=\"pm_edit.php\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('webtag', $webtag), "\n";
echo form_input_hidden('mid', $mid), "\n";

if (!$valid && isset($error_html) && strlen(trim($error_html)) > 0) {
    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['error']}</td>\n";
    echo "  </tr>";
    echo "  <tr>\n";
    echo "    <td>$error_html</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

if ($valid && isset($_POST['preview'])) {

    $pm_elements_array['FOLDER'] = PM_FOLDER_OUTBOX;

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['messagepreview']}</td>\n";
    echo "  </tr>";
    echo "  <tr>\n";
    echo "    <td><br />", draw_pm_message($pm_elements_array), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td colspan=\"2\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "<table width=\"720\" class=\"posthead\">\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\" colspan=\"2\">{$lang['editpm']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td valign=\"top\" width=\"210\">\n";
echo "      <table class=\"posthead\" width=\"210\">\n";
echo "        <tr>\n";
echo "          <td><h2>{$lang['subject']}:</h2></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td>", form_input_text("t_subject", isset($t_subject) ? _htmlentities($t_subject) : "", 42, false, false, "thread_title"), "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><h2>{$lang['to']}:</h2></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['TO_UID']}, '$webtag')\" target=\"_self\">", _stripslashes(format_user_name($pm_elements_array['TLOGON'], $pm_elements_array['TNICK'])), "</a></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td>&nbsp;</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><h2>". $lang['messageoptions'] .":</h2>\n";
echo "            ".form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo "            ".form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo "            ".form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."\n";
echo "          </td>\n";
echo "        </tr>\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if ($emot_prev != "") {

    echo "        <tr>\n";
    echo "          <td>&nbsp;</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"subhead\">&nbsp;{$lang['emoticons']}:</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {

        echo "              <td class=\"subhead\" align=\"right\">", form_submit_image('emots_hide.png', 'emots_toggle', 'hide'), "&nbsp;</td>\n";
        echo "            </tr>\n";
        echo "            <tr>\n";
        echo "              <td colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "              <td class=\"subhead\" align=\"right\">", form_submit_image('emots_show.png', 'emots_toggle', 'show'), "&nbsp;</td>\n";
    }

    echo "            </tr>\n";
    echo "          </table></td>\n";
    echo "        </tr>\n";
}

echo "      </table>\n";
echo "    </td>\n";
echo "    <td width=\"500\" valign=\"top\">\n";
echo "      <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td>";
echo "           <h2>{$lang['message']}:</h2>\n";

$tools = new TextAreaHTML("f_post");

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

if ($allow_html && ($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {

    echo $tools->toolbar(false, form_submit('submit', $lang['apply'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "class=\"signature_content\" tabindex=\"1\"")."\n";

echo "          </td>\n";
echo "        </tr>\n";

if ($post->isDiff() && $fix_html) {

    echo "        <tr>\n";
    echo "          <td>\n";
    echo "            ".$tools->compare_original("t_content", $post->getOriginalContent());
    echo "          </td>\n";
    echo "        </tr>\n";
}

echo "        <tr>\n";
echo "          <td>\n";

if ($allow_html == true) {

    echo "<h2>". $lang['htmlinmessage'] .":</h2>\n";

    $tph_radio = $post->getHTML();

    echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
    echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
    echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

    if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {

        echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
    }

    echo "<br /><br />\n";

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo form_submit('submit', $lang['apply'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "&nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onclick="clearFocus()"');
echo "&nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y', false)) {

    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$uid', '$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}

echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan=\"2\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo $tools->js();

if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $_POST['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

echo "</form>\n";

html_draw_bottom();

?>