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

/* $Id: pm_edit.php,v 1.40 2004-04-26 11:21:10 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

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

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
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
        $t_subject = trim($_POST['t_subject']);
    }else {
        $error_html = "<h2>{$lang['entersubjectformessage']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
        $t_content = $_POST['t_content'];
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

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX, bh_session_get_value('UID'))) {
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

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX, bh_session_get_value('UID'))) {

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

    if ($pm_elements_array = pm_single_get($mid, PM_FOLDER_OUTBOX, bh_session_get_value('UID'))) {

        if ($pm_elements_array['TYPE'] <> PM_NEW) {
            html_draw_top();
            pm_edit_refuse();
            html_draw_bottom();
            exit;
        }

        $t_content = clean_emoticons($pm_elements_array['CONTENT']);
        $t_subject = _stripslashes($pm_elements_array['SUBJECT']);

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
echo "<p>&nbsp;</p>\n";

if ($valid == false) {
    echo $error_html;
}

$tools = new TextAreaHTML("f_post");

echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('mid', $mid), "\n";
echo "<table width=\"480\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"right\" width=\"30\">{$lang['subject']}:</td>\n";
echo "          <td>", form_field("t_subject", isset($t_subject) ? _htmlentities($t_subject) : "", 32), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "      <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td>".$tools->toolbar();
echo $tools->textarea("t_content", $post->getTidyContent(), 15, 72). "</td>\n";
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

echo "            ".form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
echo "            ".form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
echo "            ".form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo form_submit('submit', $lang['apply']), "&nbsp;", form_submit('preview', $lang['preview']), "&nbsp;";
echo form_submit('cancel', $lang['cancel']);

if ($aid = get_pm_attachment_id($mid)) {
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}else {
    $aid = md5(uniqid(rand()));
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}

echo $tools->js();

echo "</form>\n";

if ($valid) {
    echo "<h2>{$lang['messagepreview']}:</h2><br />\n";
    $pm_elements_array['FOLDER'] = PM_FOLDER_OUTBOX;
    draw_pm_message($pm_elements_array);
}

html_draw_bottom();

?>