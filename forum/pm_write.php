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

/* $Id: pm_write.php,v 1.100 2005-01-26 21:33:16 decoyduck Exp $ */

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
include_once("./include/messages.inc.php");
include_once("./include/thread.inc.php");

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

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Prune old messages for the current user

pm_user_prune_folders();


// Get the Message ID (MID) if any.

if (isset($_GET['replyto']) && is_numeric($_GET['replyto'])) {
    $t_rmid = $_GET['replyto'];
}elseif (isset($_POST['replyto']) && is_numeric($_POST['replyto'])) {
    $t_rmid = $_POST['replyto'];
}else {
    $t_rmid = 0;
}

// Get the tid.pid if any.
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    @list($tid, $pid) = explode('.', $_GET['msg']);

    if (is_numeric($tid) && is_numeric($pid)) {
        if ($threaddata = thread_get($tid)) {
           $t_subject = "Re:".$threaddata['TITLE']." [$tid.$pid]";
          }
    }
}

// User clicked cancel

if (isset($_POST['cancel'])) {

    if (isset($t_rmid) && $t_rmid > 0) {
        $uri = "./pm.php?webtag=$webtag&mid=$t_rmid";
    }else {
        $uri = "./pm.php?webtag=$webtag";
    }

    header_redirect($uri);
}

// Check the MID to see if it is valid and accessible.

if (isset($t_rmid) && $t_rmid > 0) {

    $t_recipient_list = pm_get_user($t_rmid);

    if ($pm_data = pm_single_get($t_rmid, PM_FOLDER_INBOX)) {

        $pm_data['CONTENT'] = pm_get_content($t_rmid);

        if (!isset($_POST['t_subject']) || trim($_POST['t_subject']) == "") {

            $t_subject = $pm_data['SUBJECT'];

            if (strtoupper(substr($t_subject, 0, 4)) == "FWD:") {
                $t_subject = substr($t_subject, 4);
            }

            if (strtoupper(substr($t_subject, 0, 3)) != "RE:") {
                $t_subject = "Re:$t_subject";
            }
        }

        $user_prefs = user_get_prefs(bh_session_get_value('UID'));

        if ($user_prefs['PM_INCLUDE_REPLY'] == 'Y') {

            // Quote the original PM using our psuedo HTML tag

            $t_content = "<quote source=\"";
            $t_content.= format_user_name($pm_data['TLOGON'], $pm_data['TNICK']);
            $t_content.= "\" url=\"\">";
            $t_content.= trim($pm_data['CONTENT']);
            $t_content.= "</quote>\n\n";

            // Set the HTML mode to 'with automatic line breaks' so
            // the quote is handled correctly when the user previews
            // the message.

            $post_html = 1;
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

$fix_html = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false
$allow_html = true;

// User clicked the emoticon panel toggle button

if (isset($_POST['emots_toggle_x']) || isset($_POST['emots_toggle_y'])) {

    if (isset($_POST['t_subject']) && trim($_POST['t_subject']) != "") {
        $t_subject = _htmlentities(trim(_stripslashes($_POST['t_subject'])));
    }

    if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
        $t_content = trim(_stripslashes($_POST['t_content']));
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

    user_update_prefs(bh_session_get_value('UID'), array('POST_PAGE' => $page_prefs));

        $fix_html = false;
}

// User clicked the submit button - check the data that was submitted

if (isset($_POST['submit']) || isset($_POST['preview'])) {

    $error_html = "";

    if (isset($_POST['t_subject']) && trim($_POST['t_subject']) != "") {
        $t_subject = _htmlentities(trim(_stripslashes($_POST['t_subject'])));
    }else {
        $error_html.= "<h2>{$lang['entersubjectformessage']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_content']) && trim($_POST['t_content']) != "") {
        $t_content = trim(_stripslashes($_POST['t_content']));
    }elseif ($valid) {
        $error_html.= "<h2>{$lang['entercontentformessage']}</h2>\n";
        $valid = false;
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

    if ($to_radio == 0 && $t_to_uid == 0) {

        $error_html.= "<h2>{$lang['mustspecifyrecipient']}</h2>\n";
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

                    if ($to_radio == 1) {

                        if (user_allow_pm($to_user['UID']) || perm_is_moderator()) {

                            $uid = bh_session_get_value('UID');

                            $user_prefs = user_get_prefs($uid);

                            pm_user_prune_folders();

                            if ((pm_get_free_space($uid) < 1) && $user_prefs['PM_SAVE_SENT_ITEM'] == 'Y') {

                                $error_html.= "<h2>{$lang['youdonothaveenoughfreespace']}</h2>\n";
                                $valid = false;
                            }

                            if (pm_get_free_space($to_user['UID']) < 1) {

                                pm_user_prune_folders($to_user['UID']);

                                if (pm_get_free_space($to_user['UID']) < 1) {

                                    $error_html.= "<h2>{$lang['user']} $to_logon {$lang['notenoughfreespace']}.</h2>\n";
                                    $valid = false;
                                }
                            }

                        }else {

                            $error_html.= "<h2>{$lang['user']} $to_logon {$lang['hasoptoutpm']}.</h2>\n";
                            $valid = false;
                        }
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

        if ($to_radio == 1) {

            if ($valid && sizeof($t_new_recipient_array['TO_UID']) > 10) {
                $error_html.= "<h2>{$lang['maximumtenrecipientspermessage']}</h2>\n";
                $valid = false;
            }

            if ($valid && sizeof($t_new_recipient_array['TO_UID']) < 1) {
                $error_html.= "<h2>{$lang['mustspecifyrecipient']}</h2>\n";
                $valid = false;
            }
        }

    }elseif ($valid && $to_radio == 1) {
        $error_html.= "<h2>{$lang['mustspecifyrecipient']}</h2>\n";
        $valid = false;
    }
}

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

}else {

   $links_enabled = false;
}

if (isset($_POST['t_check_spelling'])) {
        if ($_POST['t_check_spelling'] == "enabled") {
                $spelling_enabled = true;
        } else {
                $spelling_enabled = false;
        }
} else {
        $spelling_enabled = ($page_prefs & POST_CHECK_SPELLING);
}

if (!isset($post_html)) $post_html = 0;

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

if (!isset($t_content)) $t_content = "";

// Process the data based on what we know.
$post = new MessageText($post_html, $t_content, $emots_enabled, $links_enabled);

$t_content = $post->getContent();

if (strlen($t_content) >= 65535) {
    $error_html = "<h2>{$lang['reducemessagelength']} ". number_format(strlen($t_content)). ")</h2>";
    $valid = false;
}

// Attachment Unique ID

if (!isset($_POST['aid'])) {
    $aid = md5(uniqid(rand()));
}else{
    $aid = $_POST['aid'];
}

// Send the PM

if ($valid && isset($_POST['submit'])) {

    if (check_ddkey($_POST['t_dedupe'])) {

        if (isset($to_radio) && $to_radio == 0) {

            if ($new_mid = pm_send_message($t_to_uid, $t_subject, $t_content)) {
                if (get_num_attachments($aid) > 0) pm_save_attachment_id($new_mid, $_POST['aid']);
                email_send_pm_notification($t_to_uid, $new_mid, bh_session_get_value('UID'));
            }else {
                $error_html.= "<h2>{$lang['errorcreatingpm']}</h2>\n";
                $valid = false;
            }

        }else {

            foreach ($t_new_recipient_array['TO_UID'] as $t_to_uid) {

                if ($new_mid = pm_send_message($t_to_uid, $t_subject, $t_content)) {
                    if (get_num_attachments($aid) > 0) pm_save_attachment_id($new_mid, $_POST['aid']);
                    email_send_pm_notification($t_to_uid, $new_mid, bh_session_get_value('UID'));
                }else {
                    $error_html.= "<h2>{$lang['errorcreatingpm']}</h2>\n";
                    $valid = false;
                }
            }
        }
    }

    if ($valid) {

        if (isset($mid)) {
            $uri = "./pm.php?webtag=$webtag&mid=$mid";
        }else {
            $uri = "./pm.php?webtag=$webtag";
        }

        header_redirect($uri);
    }
}

html_draw_top("onUnload=clearFocus()", "openprofile.js", "post.js", "dictionary.js", "htmltools.js", "basetarget=_blank");
draw_header_pm();

// PM link from profile

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $to_user = user_get($_GET['uid']);
    $t_recipient_list = $to_user['LOGON'];
}

echo "<table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td class=\"pmheadl\">&nbsp;<b>{$lang['privatemessages']}: {$lang['writepm']}</b></td>\n";
echo "    <td class=\"pmheadr\" align=\"right\"><a href=\"pm_write.php?webtag=$webtag\" target=\"_self\">{$lang['sendnewpm']}</a> | <a href=\"pm.php?webtag=$webtag\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=2\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=3\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?webtag=$webtag&amp;folder=4\" target=\"_self\">{$lang['pmsaveditems']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";

echo "<form name=\"f_post\" action=\"pm_write.php\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('webtag', $webtag), "\n";

// preview message

if ($valid && isset($_POST['preview'])) {

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['messagepreview']}</td>\n";
    echo "  </tr>\n";

    if (isset($to_radio) && $to_radio == 0) {

        $preview_tuser = user_get($t_to_uid);

        $pm_preview_array['TLOGON'] = $preview_tuser['LOGON'];
        $pm_preview_array['TNICK']  = $preview_tuser['NICKNAME'];
        $pm_preview_array['TO_UID'] = $preview_tuser['UID'];

    }else {

        $pm_preview_array['TLOGON'] = $t_new_recipient_array['LOGON'];
        $pm_preview_array['TNICK']  = $t_new_recipient_array['NICK'];
        $pm_preview_array['TO_UID'] = $t_new_recipient_array['TO_UID'];
    }

    $preview_fuser = user_get(bh_session_get_value('UID'));

    $pm_preview_array['FLOGON'] = $preview_fuser['LOGON'];
    $pm_preview_array['FNICK']  = $preview_fuser['NICKNAME'];
    $pm_preview_array['FROM_UID'] = $preview_fuser['UID'];

    $pm_preview_array['SUBJECT'] = $t_subject;
    $pm_preview_array['CREATED'] = mktime();
    $pm_preview_array['AID'] = $aid;

    $pm_preview_array['FOLDER'] = PM_FOLDER_OUTBOX;

    $pm_preview_array['CONTENT'] = $t_content;

    echo "  <tr>\n";
    echo "    <td><br />", draw_pm_message($pm_preview_array, true), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

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

echo "<table width=\"720\" class=\"posthead\">\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\" colspan=\"2\">{$lang['writepm']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td valign=\"top\" width=\"210\">\n";
echo "      <table class=\"posthead\" width=\"210\">\n";
echo "        <tr>\n";
echo "          <td><h2>{$lang['subject']}:</h2></td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td>", form_input_text("t_subject", isset($t_subject) ? $t_subject : "", 42, false, "style=\"width: 190px\""), "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><h2>{$lang['to']}:</h2></td>\n";
echo "        </tr>\n";

if ($friends_array = pm_user_get_friends()) {

    echo "        <tr>\n";
    echo "          <td>\n";
    echo "            ", form_radio("to_radio", 0, $lang['friends'], (isset($to_radio) && $to_radio == 0)), "<br />\n";
    echo "            ", form_dropdown_array("t_to_uid", $friends_array['uid_array'], $friends_array['logon_array'], (isset($t_to_uid) ? $t_to_uid : 0), "style=\"width: 190px\" onclick=\"checkToRadio(0)\""), "<br />\n";
    echo "            ", form_radio("to_radio", 1, $lang['others'], (isset($to_radio) && $to_radio == 1) ? true : (!isset($to_radio))), "<br />\n";
    echo "            ", form_input_text("t_recipient_list", isset($t_recipient_list) ? _htmlentities(_stripslashes($t_recipient_list)) : "", 0, 0, "title=\"{$lang['recipienttiptext']}\" style=\"width: 190px\" onclick=\"checkToRadio(1)\""), "\n";
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"right\">", form_button("add", $lang['addrecipient'], "onclick=\"checkToRadio(1); addRecipient()\""), "&nbsp;&nbsp;</td>\n";
    echo "        </tr>\n";

}else {

    echo "        <tr>\n";
    echo "          <td>", form_input_text("t_recipient_list", isset($t_recipient_list) ? _htmlentities(_stripslashes($t_recipient_list)) : "", 0, 0, "title=\"{$lang['recipienttiptext']}\" style=\"width: 190px\""), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"right\">", form_button("add", $lang['addrecipient'], "onclick=\"addRecipient()\""), "&nbsp;&nbsp;</td>\n";
    echo "        </tr>\n";
}

if (!is_array($friends_array)) {

    echo "        <tr>\n";
    echo "          <td>&nbsp;</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><h2>Hint:</h2></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"smalltext\">Add users to your friends list to have them appear in a drop down on the PM Write Message Page.</td>\n";
    echo "        </tr>\n";
}

echo "        <tr>\n";
echo "          <td>&nbsp;</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><h2>". $lang['messageoptions'] .":</h2>\n";

echo "            ".form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo "            ".form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo "            ".form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br />\n";

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
        echo "              <td class=\"subhead\">\n";
        echo "                <div style=\"float:left\">&nbsp;{$lang['emoticons']}:</div>\n";

        if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
                echo "                <div style=\"float:right\">". form_submit_image('emots_hide.png', 'emots_toggle', 'hide'). "</div>\n";
                echo "              </td>\n";
                echo "            </tr>\n";

                echo "            <tr>\n";
                echo "              <td colspan=\"2\">\n";
                echo $emot_prev;
        } else {
                echo "                <div style=\"float:right\">". form_submit_image('emots_show.png', 'emots_toggle', 'show'). "</div>\n";
        }

        echo "              </td>\n";
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
        echo $tools->toolbar(false, form_submit('submit', $lang['post'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "style=\"width: 480px\" tabindex=\"1\"")."\n";

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

} else {

        echo form_input_hidden("t_post_html", "disabled");
}

echo form_submit('submit', $lang['post'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "&nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onclick="clearFocus()"');
echo "&nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y', false) && forum_get_setting('pm_allow_attachments', 'Y', false)) {

    echo "&nbsp;".form_button("attachments", $lang['attachments'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", $aid);
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

if (isset($t_rmid)) echo form_input_hidden("replyto", $t_rmid), "\n";

if (isset($pm_data) && is_array($pm_data)) {

    echo "<table class=\"posthead\" width=\"720\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"subhead\">{$lang['inreplyto']}</td>\n";
    echo "  </tr>";
    echo "  <tr>\n";
    echo "    <td><br />", draw_pm_message($pm_data), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td colspan=\"2\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "</form>\n";

html_draw_bottom();

?>