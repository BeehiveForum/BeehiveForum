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

/* $Id: pm_edit.php,v 1.51 2004-08-10 21:43:11 decoyduck Exp $ */

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

// User clicked cancel

if (isset($_POST['cancel'])) {
    header_redirect("./pm.php?webtag=$webtag&folder=3");
}

$valid = true;

$t_content = "";
$post_html = 0;

if (isset($_POST['t_post_html'])) {
    $t_post_html = $_POST['t_post_html'];
    if ($t_post_html == "enabled_auto") {
                $post_html = 1;
    } else if ($t_post_html == "enabled") {
                $post_html = 2;
    }
}

$post = new MessageText($post_html);

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

        if (isset($_POST['aid']) && forum_get_setting('attachments_enabled', 'Y', false)) {
            if (get_num_attachments($_POST['aid']) > 0) pm_save_attachment_id($mid, $_POST['aid']);
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

}else {

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX)) {

        if ($pm_elements_array['TYPE'] != PM_UNREAD) {
            html_draw_top();
            pm_edit_refuse();
            html_draw_bottom();
            exit;
        }

        $t_content = pm_get_content($mid);
        $t_content = clean_emoticons($t_content);
        $t_subject = $pm_elements_array['SUBJECT'];

        $t_content = _htmlentities_decode($t_content);
        $post_html = 0;
        $t_content_tmp = preg_replace("/<a href=\"([^\"]*)\">\\1<\/a>/", "\\1", $t_content);

        if (strip_tags($t_content, '<p><br>') != $t_content_tmp) {
            $post_html = 2;
        } else {
            $t_content = strip_tags($t_content);
        }

        $post = new MessageText($post_html, $t_content);
        $t_content = $post->getContent();

    }else {

        html_draw_top();
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }
}

html_draw_top("openprofile.js", "edit.js", "htmltools.js", "basetarget=_blank");
draw_header_pm();

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\" height=\"20\">\n";
echo "  <tr>\n";
echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['editpm']}</b></td>\n";
echo "    <td class=\"pmheadr\" align=\"right\"><a href=\"pm_write.php?webtag=$webtag\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php?webtag=$webtag\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=1\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=2\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=3\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
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
echo "          <td>", form_input_text("t_subject", isset($t_subject) ? _htmlentities($t_subject) : "", 42, false, "style=\"width: 190px\""), "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><h2>{$lang['to']}:</h2></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><a href=\"javascript:void(0);\" onclick=\"openProfile({$pm_elements_array['TO_UID']}, '$webtag')\" target=\"_self\">", _stripslashes(format_user_name($pm_elements_array['TLOGON'], $pm_elements_array['TNICK'])), "</a></td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "    <td width=\"500\">\n";
echo "      <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td>";
echo "           <h2>{$lang['message']}:</h2>\n";

$tools = new TextAreaHTML("f_post");

echo $tools->toolbar(false, form_submit('submit', $lang['post'], 'onclick="closeAttachWin(); clearFocus()"'));

echo $tools->textarea("t_content", $post->getTidyContent(), 20, 0, "virtual", "style=\"width: 480px\" tabindex=\"1\"")."\n";

echo "          <td>\n";
echo "        </tr>\n";

if ($post->isDiff()) {

    echo "        <tr>\n";
    echo "          <td>\n";
    echo "            ".$tools->compare_original("t_content", $post->getOriginalContent());
    echo "          </td>\n";
    echo "        </tr>\n";
}

echo "        <tr>\n";
echo "          <td>\n";
echo "<h2>". $lang['htmlinmessage'] .":</h2>\n";

$tph_radio = $post->getHTML();

echo "            ", form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\""), " \n";
echo "            ", form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1), " \n";
echo "            ", form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2), " \n";

echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");

echo "<br /><br /><h2>". $lang['messageoptions'] .":</h2>\n";

echo form_submit('submit', $lang['apply'], 'tabindex="2" onclick="closeAttachWin(); clearFocus()"');
echo "&nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onClick="clearFocus()"');
echo "&nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y', false)) {

    if ($aid = get_pm_attachment_id($mid)) {
        echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
        echo form_input_hidden('aid', $aid);
    }else {
        $aid = md5(uniqid(rand()));
        echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
        echo form_input_hidden('aid', $aid);
    }
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