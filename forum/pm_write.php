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

/* $Id: pm_write.php,v 1.65 2004-04-23 22:11:31 decoyduck Exp $ */

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

// Get the Message ID (MID) if any.

if (isset($_GET['replyto']) && is_numeric($_GET['replyto'])) {
    $mid = $_GET['replyto'];
}elseif (isset($_POST['replyto']) && is_numeric($_POST['replyto'])) {
    $mid = $_POST['replyto'];
}

// User clicked cancel

if (isset($_POST['cancel'])) {
    $uri = (isset($mid)) ? "./pm.php?webtag=$webtag&mid=$mid" : "./pm.php?webtag=$webtag";
    header_redirect($uri);
}

// Check the MID to see if it is valid and accessible.

if (isset($mid)) {
    $t_recipient_list = pm_get_user($mid);
    if ($pm_data = pm_single_get($mid, PM_FOLDER_INBOX)) {
        if (!isset($_POST['t_subject']) || trim($_POST['t_subject']) == "") {
            $t_subject = $pm_data['SUBJECT'];
            if (strtoupper(substr($t_subject, 0, 3)) != "RE:") {
                $t_subject = "Re:". $t_subject;
            }
        }
    }else {
        html_draw_top();
        pm_error_refuse();
        html_draw_bottom();
        exit;
    }
}

// Assume everything is correct (form input, etc)

$valid = true;
$t_content = "";

// User clicked the submit button - check the data that was submitted

if (isset($_POST['submit']) || isset($_POST['preview'])) {

    $error_html = "";

    if (isset($_POST['t_subject']) && trim($_POST['t_subject']) != "") {
        $t_subject = _htmlentities(trim($_POST['t_subject']));
    }else {
        $error_html.= "<h2>{$lang['entersubjectformessage']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
        $t_content = $_POST['t_content'];
    }elseif ($valid) {
        $error_html.= "<h2>{$lang['entercontentformessage']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_recipient_list']) && trim($_POST['t_recipient_list']) != "") {

        if ($valid) {

            $t_recipient_array = preg_split("/[;|,]/", trim($_POST['t_recipient_list']));

            $t_new_recipient_array['TO_UID'] = array();
            $t_new_recipient_array['LOGON']  = array();
            $t_new_recipient_array['NICK']   = array();

            foreach ($t_recipient_array as $key => $t_recipient) {

                $to_logon = trim($t_recipient);

                if ($to_user = user_get_uid($to_logon)) {

                    if (!in_array($to_user['UID'], $t_new_recipient_array['TO_UID'])) {
                        $t_new_recipient_array['TO_UID'][] = $to_user['UID'];
                        $t_new_recipient_array['LOGON'][]  = $to_user['LOGON'];
                        $t_new_recipient_array['NICK'][]   = $to_user['NICKNAME'];
                    }

                    if (!user_allow_pm($to_user['UID'])) {

		        $error_html.= "<h2>{$lang['user']} $to_logon {$lang['hasoptoutpm']}.</h2>\n";
			$valid = false;
		    }

		    if (pm_get_free_space($to_user['UID']) < (strlen(trim($t_subject)) + strlen(trim($t_content)))) {

		        $error_html.= "<h2>{$lang['user']} $to_logon {$lang['notenoughfreespace']}.</h2>\n";
			$valid = false;
		    }

                }elseif ($valid) {

                    $error_html.= "<h2>{$lang['usernotfound1']} $to_logon {$lang['usernotfound2']}</h2>\n";
                    $valid = false;
                }
            }

            $t_recipient_list = implode('; ', $t_new_recipient_array['LOGON']);

        }else {

            $t_recipient_list = $_POST['t_recipient_list'];
        }

        if ($valid && sizeof($t_new_recipient_array['TO_UID']) > 10) {
            $error_html.= "<h2>{$lang['maximumtenrecipientspermessage']}</h2>\n";
            $valid = false;
        }

        if ($valid && sizeof($t_new_recipient_array['TO_UID']) < 1) {
            $error_html.= "<h2>{$lang['mustspecifyrecipient']}</h2>\n";
            $valid = false;
        }

    }elseif ($valid) {
        $error_html.= "<h2>{$lang['mustspecifyrecipient']}</h2>\n";
        $valid = false;
    }
}

$post_html = 0;
if (isset($_POST['t_post_html'])) {
    $t_post_html = $_POST['t_post_html'];
    if ($t_post_html == "enabled_auto") {
		$post_html = 1;
    } else if ($t_post_html == "enabled") {
		$post_html = 2;
    }
}

// Process the data based on what we know.
$post = new MessageText($post_html, $t_content);
$t_content = $post->getContent();

if (strlen($t_content) >= 65535) {
	$error_html = "<h2>{$lang['reducemessagelength']} ".number_format(strlen($t_content)).")</h2>";
	$valid = false;
}

// Send the PM

if ($valid && isset($_POST['submit'])) {

    if (check_ddkey($_POST['t_dedupe'])) {

        foreach ($t_new_recipient_array['TO_UID'] as $t_to_uid) {
            if ($new_mid = pm_send_message($t_to_uid, $t_subject, $t_content)) {
                if (isset($_POST['aid']) && get_num_attachments($_POST['aid']) > 0) {
                    pm_save_attachment_id($new_mid, $_POST['aid']);
                }
                email_send_pm_notification($t_to_uid, $new_mid, bh_session_get_value('UID'));
            }else {
                $error_html.= "<h2>{$lang['errorcreatingpm']}</h2>\n";
                $valid = false;
            }
        }
    }
    if (isset($mid)) {
        $uri = "./pm.php?webtag=$webtag&mid=$mid";
    }else {
        $uri = "./pm.php?webtag=$webtag";
    }
    header_redirect($uri);
}

html_draw_top("openprofile.js", "post.js", "htmltools.js", "basetarget=_blank");
draw_header_pm();

// Attachment Unique ID

if (!isset($_POST['aid'])) {
  $aid = md5(uniqid(rand()));
}else{
  $aid = $_POST['aid'];
}

// preview message

if ($valid && isset($_POST['preview'])) {

    echo "<h1>{$lang['privatemessages']}: {$lang['messagepreview']}</h1>\n";
    echo "<br />\n";

    $pm_preview_array['TLOGON'] = $t_new_recipient_array['LOGON'];
    $pm_preview_array['TNICK']  = $t_new_recipient_array['NICK'];
    $pm_preview_array['TO_UID'] = $t_new_recipient_array['TO_UID'];

    $preview_fuser = user_get(bh_session_get_value('UID'));

    $pm_preview_array['FLOGON'] = $preview_fuser['LOGON'];
    $pm_preview_array['FNICK']  = $preview_fuser['NICKNAME'];
    $pm_preview_array['FROM_UID'] = $preview_fuser['UID'];

    $pm_preview_array['SUBJECT'] = $t_subject;
    $pm_preview_array['CREATED'] = mktime();
    $pm_preview_array['AID'] = $aid;

    $pm_preview_array['FOLDER'] = PM_FOLDER_OUTBOX;

    $pm_preview_array['CONTENT'] = $t_content;

    draw_pm_message($pm_preview_array);
    echo "<br />\n";

}

// PM link from profile

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $to_user = user_get($_GET['uid']);
    $t_recipient_list = $to_user['LOGON'];
}

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\" height=\"20\">\n";
echo "  <tr>\n";
echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['writepm']}</b></td>\n";
echo "    <td class=\"pmheadr\" align=\"right\"><a href=\"pm_write.php?webtag=$webtag\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php?webtag=$webtag\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?webtag=$webtag&folder=1\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?webtag=$webtag&folder=2\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?webtag=$webtag&folder=3\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";

if (!$valid && isset($error_html) && strlen(trim($error_html)) > 0) {
    echo $error_html;
    echo "<br />\n";
}

$tools = new TextAreaHTML("f_post");

echo "<form name=\"f_post\" action=\"pm_write.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";
echo "<table width=\"480\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"right\">{$lang['to']}: </td>\n";
echo "          <td>", form_input_text("t_recipient_list", isset($t_recipient_list) ? _htmlentities(_stripslashes($t_recipient_list)) : "", 42, false, "title=\"{$lang['recipienttiptext']}\""), "&nbsp;", form_button("add", $lang['addrecipient'], "onclick=\"javascript:addRecipient()\""), "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td align=\"right\" width=\"30\">{$lang['subject']}:</td>\n";
echo "          <td>", form_input_text("t_subject", isset($t_subject) ? _stripslashes($t_subject) : "", 42), "&nbsp;", form_submit("submit", $lang['post']), "</td>\n";
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

echo form_submit('submit', $lang['post']), "&nbsp;", form_submit('preview', $lang['preview']), "&nbsp;";
echo form_submit('cancel', $lang['cancel']);

if (forum_get_setting('attachments_enabled', 'Y', false) && forum_get_setting('pm_allow_attachments', 'Y', false)) {
    echo "&nbsp;".form_button("attachments", $lang['attachments'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", $aid);
}

echo $tools->js();

if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $_POST['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

if (isset($mid)) echo form_input_hidden("replyto", $mid), "\n";
echo "</form>\n";

if (isset($mid)) {
    echo "<h1>{$lang['inreplyto']}</h1><br />";
    draw_pm_message($pm_data);
}

html_draw_bottom();

?>