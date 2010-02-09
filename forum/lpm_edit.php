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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
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
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
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

// Load language file

$lang = load_language_file();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access this page.

if (user_is_guest()) {

    light_html_guest_error();
    exit;
}

// Check that PM system is enabled

light_pm_enabled();

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

    light_html_draw_top("title={$lang['error']}", 'pm_popup_disabled');
    light_html_display_error_msg($lang['nomessagespecifiedforedit']);
    light_html_draw_bottom();
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
    header_redirect("lpm.php?webtag=$webtag&mid=$mid");
}

$valid = true;

// For future's sake, if we ever add an admin option for allowing/disallowing HTML PMs.
// Then just do something like $allow_html = forum_allow_html_pms() ? true : false

$allow_html = true;

$t_content = "";

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
}

if (($page_prefs & POST_EMOTICONS_DISABLED) > 0) {
    $emots_enabled = false;
}else {
    $emots_enabled = true;
}

if (($page_prefs & POST_AUTO_LINKS) > 0) {
    $links_enabled = true;
}else {
    $links_enabled = false;
}

$post = new MessageText($post_html, "", $emots_enabled, $links_enabled);

if (isset($_POST['apply']) || isset($_POST['preview'])) {

    if (isset($_POST['t_subject']) && strlen(trim(stripslashes_array($_POST['t_subject']))) > 0) {

        $t_subject = trim(stripslashes_array($_POST['t_subject']));

    }else {

        $error_msg_array[] = $lang['entersubjectformessage'];
        $valid = false;
    }

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = trim(stripslashes_array($_POST['t_content']));

        $post->setContent($t_content);
        $t_content = $post->getContent();

        if (mb_strlen($t_content) >= 65535) {

            $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(mb_strlen($t_content)));
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

    if (($pm_message_array = pm_message_get($mid))) {

        $pm_message_array['CONTENT'] = $t_content;

        $pm_message_array['SUBJECT'] = $t_subject;
        $pm_message_array['FOLDER'] = PM_FOLDER_OUTBOX;

    }else {

        light_html_draw_top("title={$lang['error']}");
        light_pm_edit_refuse();
        light_html_draw_bottom();
        exit;
    }

}else if ($valid && isset($_POST['apply'])) {

    if (($pm_message_array = pm_message_get($mid))) {

        pm_save_attachment_id($mid, $aid);

        if (pm_edit_message($mid, $t_subject, $t_content)) {

            header_redirect("lpm.php?webtag=$webtag&mid=$mid");
            exit;

        }else {

            $error_msg_array[] = $lang['errorcreatingpm'];
            $valid = false;
        }

    }else {

        light_html_draw_top("title={$lang['error']}");
        light_pm_edit_refuse();
        light_html_draw_bottom();
        exit;
    }

} else if (isset($_POST['emots_toggle'])) {

    if (isset($_POST['t_subject']) && strlen(trim(stripslashes_array($_POST['t_subject']))) > 0) {
        $t_subject = trim(stripslashes_array($_POST['t_subject']));
    }

    if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {

        $t_content = trim(stripslashes_array($_POST['t_content']));

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

    if (($pm_message_array = pm_message_get($mid))) {

        if ($pm_message_array['TYPE'] != PM_OUTBOX) {

            light_html_draw_top("title={$lang['error']}", 'pm_popup_disabled');
            light_pm_edit_refuse();
            light_html_draw_bottom();
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

        light_html_draw_top("title={$lang['error']}");
        light_pm_edit_refuse();
        light_html_draw_bottom();
        exit;
    }
}

light_html_draw_top("title={$lang['editpm']}");

if ($valid && isset($_POST['preview'])) {

    echo "<h1>{$lang['messagepreview']}</h1>\n";

    light_pm_display($pm_message_array, PM_FOLDER_OUTBOX, true);

    echo "<br />\n";
}

echo "<form accept-charset=\"utf-8\" name=\"f_post\" action=\"lpm_edit.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";

echo "<h1>{$lang['privatemessages']} &raquo; {$lang['editpm']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array, '720', 'left');
}

echo "<p>{$lang['subject']}: ";
echo light_form_input_text("t_subject", isset($t_subject) ? htmlentities_array($t_subject) : "", 30, 64), "</p>\n";
echo "<p>{$lang['to']}: ", word_filter_add_ob_tags(htmlentities_array(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']))), "</p>\n";
echo "<p>", light_form_textarea("t_content", $post->getTidyContent(), 10, 50), "</p>\n";

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

light_html_draw_bottom();

?>