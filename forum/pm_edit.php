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

/* $Id: pm_edit.php,v 1.119 2008-04-23 21:03:14 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

// Fetch the webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access this page.

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that PM system is enabled

pm_enabled();

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

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['nomessagespecifiedforedit']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = get_pm_attachment_id($mid)) {

    $aid = md5(uniqid(mt_rand()));
}

pm_save_attachment_id($mid, $aid);

// User clicked cancel

if (isset($_POST['cancel'])) {
    header_redirect("pm.php?webtag=$webtag&mid=$mid");
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

$post_html = POST_HTML_DISABLED;

if (isset($_POST['t_post_html'])) {

    $t_post_html = $_POST['t_post_html'];

    if ($t_post_html == "enabled_auto") {
        $post_html = POST_HTML_AUTO;
    }else if ($t_post_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
    }

} else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_AUTO;
    } else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    } else {
        $post_html = POST_HTML_DISABLED;
    }

    $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);
    $links_enabled = ($page_prefs & POST_AUTO_LINKS);
}

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_subject']) && strlen(trim(_stripslashes($_POST['t_subject']))) > 0) {

        $t_subject = trim(_stripslashes($_POST['t_subject']));

    }else {

        $error_msg_array[] = $lang['entersubjectformessage'];
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

        $t_content = trim(_stripslashes($_POST['t_content']));

        $post->setContent($t_content);
        $t_content = $post->getContent();

        if (strlen($t_content) >= 65535) {

            $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(strlen($t_content)));
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['entercontentformessage'];
        $valid = false;
    }
}

// Update the PM

if ($valid && isset($_POST['preview'])) {

    $edit_html = ($_POST['t_post_html'] == "Y");

    if ($pm_message_array = pm_message_get($mid)) {

        $pm_message_array['CONTENT'] = $t_content;

        $pm_message_array['SUBJECT'] = $t_subject;
        $pm_message_array['FOLDER'] = PM_FOLDER_OUTBOX;

    }else {

        html_draw_top('pm_popup_disabled');
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }

}else if ($valid && isset($_POST['apply'])) {

    if ($pm_message_array = pm_message_get($mid)) {

        pm_save_attachment_id($mid, $aid);

        if (pm_edit_message($mid, $t_subject, $t_content)) {

            header_redirect("pm.php?webtag=$webtag&mid=$mid");
            exit;

        }else {

            $error_msg_array[] = $lang['errorcreatingpm'];
            $valid = false;
        }

    }else {

        html_draw_top('pm_popup_disabled');
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }

} else if (isset($_POST['emots_toggle_x']) || isset($_POST['emots_toggle_y'])) {

    if (isset($_POST['t_subject']) && strlen(trim(_stripslashes($_POST['t_subject']))) > 0) {
        $t_subject = trim(_stripslashes($_POST['t_subject']));
    }

    if (isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

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

    $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }

}else {

    if ($pm_message_array = pm_message_get($mid)) {

        if ($pm_message_array['TYPE'] != PM_OUTBOX) {

            html_draw_top('pm_popup_disabled');
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

        $t_subject = $pm_message_array['SUBJECT'];

    }else {

        html_draw_top('pm_popup_disabled');
        pm_edit_refuse();
        html_draw_bottom();
        exit;
    }
}

html_draw_top("onUnload=clearFocus()", "resize_width=720", "openprofile.js", "edit.js", "pm.js", "dictionary.js", "htmltools.js", "basetarget=_blank", 'pm_popup_disabled');

echo "<h1>{$lang['privatemessages']} &raquo; {$lang['editpm']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

echo "<br />\n";
echo "<form name=\"f_post\" action=\"pm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('mid', _htmlentities($mid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && isset($_POST['preview'])) {

    echo "              <table class=\"posthead\" width=\"720\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['messagepreview']}</td>\n";
    echo "                </tr>";
    echo "                <tr>\n";
    echo "                  <td align=\"left\"><br />", pm_display($pm_message_array, PM_FOLDER_OUTBOX, true), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table width=\"720\" class=\"posthead\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['editpm']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['subject']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("t_subject", isset($t_subject) ? _htmlentities($t_subject) : "", 42, false, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['to']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$pm_message_array['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$pm_message_array['TO_UID']}, '$webtag')\">", word_filter_add_ob_tags(_htmlentities(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']))), "</a></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['messageoptions']}</h2>\n";
echo "                          ".form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo "                          ".form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo "                          ".form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."\n";
echo "                        </td>\n";
echo "                      </tr>\n";

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if (strlen($emot_prev) > 0) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "                          <tr>\n";
    echo "                            <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {

        echo "                            <td class=\"subhead\" align=\"right\">", form_submit_image('emots_hide.png', 'emots_toggle', 'hide'), "&nbsp;</td>\n";
        echo "                          </tr>\n";
        echo "                          <tr>\n";
        echo "                            <td align=\"left\" colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "                            <td class=\"subhead\" align=\"right\">", form_submit_image('emots_show.png', 'emots_toggle', 'show'), "&nbsp;</td>\n";
    }

    echo "                          </tr>\n";
    echo "                        </table></td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td align=\"left\" width=\"500\" valign=\"top\">\n";
echo "                    <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">";
echo "                         <h2>{$lang['message']}</h2>\n";

$tools = new TextAreaHTML("f_post");
echo $tools->preload();

$t_content = ($fix_html ? $post->getTidyContent() : $post->getOriginalContent());

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {
    echo $tools->toolbar(false, form_submit('apply', $lang['apply'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""));

} else {
    $tools->setTinyMCE(false);
}

echo $tools->textarea("t_content", $t_content, 20, 75, "virtual", "tabindex=\"1\"", "signature_content"), "\n";

echo "                        </td>\n";
echo "                      </tr>\n";

if ($post->isDiff() && $fix_html) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          ", $tools->compare_original("t_content", $post->getOriginalContent()), "\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

if ($allow_html == true) {

    if ($tools->getTinyMCE()) {

        echo form_input_hidden("t_post_html", "enabled");

    } else {

        echo "              <h2>{$lang['htmlinmessage']}</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_post_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_post_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_post_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {

            echo $tools->assign_checkbox("t_post_html[1]", "t_post_html[0]");
        }

        echo "              <br />";
    }

}else {

    echo form_input_hidden("t_post_html", "disabled");
}

echo "              <br />\n";

echo form_submit('apply', $lang['apply'], "tabindex=\"2\" onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\"");
echo "              &nbsp;".form_submit('preview', $lang['preview'], 'tabindex="3" onclick="clearFocus()"');
echo "              &nbsp;".form_submit('cancel', $lang['cancel'], 'tabindex="4" onclick="closeAttachWin(); clearFocus()"');

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "              &nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$uid', '$aid', '$webtag');\"");
    echo form_input_hidden('aid', _htmlentities($aid));
}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

echo $tools->js();

echo "</form>\n";

html_draw_bottom();

?>