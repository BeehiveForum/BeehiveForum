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

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
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

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {
    html_guest_error();
    exit;
}

// Array to hold error messages
$error_msg_array = array();

// Check to see if the forum owner has allowed the creation of polls
if (forum_get_setting('allow_polls', 'N')) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['pollshavebeendisabled']);
    html_draw_bottom();
    exit;
}

// Check that there are some available folders for this thread type
if (!folder_get_by_type_allowed(FOLDER_ALLOW_POLL_THREAD)) {

    html_message_type_error();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

// Get the user's post page preferences.
$page_prefs = session_get_post_page_prefs();

// Get the user's UID. We need this a couple of times
$uid = session_get_value('UID');

// Assume everything is A-OK!
$valid = true;

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
    $spelling_enabled = false;
}

if (isset($_POST['t_post_interest'])) {
    if ($_POST['t_post_interest'] == "Y") {
        $high_interest = "Y";
    }else {
        $high_interest = "N";
    }
}else {
    $high_interest = "N";
}

if (isset($_POST['t_sticky'])) {

    if ($_POST['t_sticky'] == 'Y') {
        $t_sticky = 'Y';
    }else {
        $t_sticky = 'N';
    }
}

if (isset($_POST['t_closed'])) {

    if ($_POST['t_closed'] == 'Y') {
        $t_closed = 'Y';
    }else {
        $t_closed = 'N';
    }
}

if (isset($_POST['t_message_html'])) {

    $t_message_html = $_POST['t_message_html'];

    if ($t_message_html == "enabled_auto") {
        $post_html = POST_HTML_AUTO;
    }else if ($t_message_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }

}else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_AUTO;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
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

    if (($page_prefs & POST_CHECK_SPELLING) > 0) {
        $spelling_enabled = true;
    }else {
        $spelling_enabled = false;
    }

    if (($high_interest = session_get_value('MARK_AS_OF_INT')) === false) {
        $high_interest = "N";
    }
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $fetched_sig = false;

    if (isset($_POST['t_sig']) && strlen(trim(stripslashes_array($_POST['t_sig']))) > 0) {
        $t_sig = trim(stripslashes_array($_POST['t_sig']));
    }else {
        $t_sig = "";
    }

}else {

    // Fetch the current user's sig
    if (!user_get_sig($uid, $t_sig, $t_sig_html)) {

        $t_sig = '';
        $t_sig_html = 'Y';
    }

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

$allow_html = true;
$allow_sig = true;

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(mt_rand()));
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "discussion.php?webtag=$webtag";
    header_redirect($uri);

}elseif (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['post'])) {

    $valid = true;

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (isset($_POST['t_threadtitle']) && strlen(trim(stripslashes_array($_POST['t_threadtitle']))) > 0) {

        $t_threadtitle = trim(stripslashes_array($_POST['t_threadtitle']));

    }else {

        $error_msg_array[] = $lang['mustenterthreadtitle'];
        $valid = false;
    }

    if (isset($_POST['t_question']) && strlen(trim(stripslashes_array($_POST['t_question']))) > 0) {
        $t_question = trim(stripslashes_array($_POST['t_question']));
    }else {
        $t_question = '';
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        $t_fid = $_POST['t_fid'];

        if (!folder_is_valid($t_fid)) {

            $error_msg_array[] = $lang['unknownfolder'];
            $valid = false;
        }

        if (!session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

            $error_msg_array[] = $lang['cannotcreatethreadinfolder'];
            $valid = false;
        }

        if (attachments_get_count($aid) > 0 && !session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

            $error_msg_array[] = $lang['cannotattachfilesinfolder'];
            $valid = false;
        }

    }else {

        $error_msg_array[] = $lang['pleaseselectfolder'];
        $valid = false;
    }

    if (isset($_POST['answers']) && is_array($_POST['answers'])) {

        $t_answers_array = array_filter(stripslashes_array($_POST['answers']), "strlen");

        if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {

            foreach ($t_answers_array as $key => $t_poll_answer) {

                $t_poll_check_html = new MessageText(POST_HTML_ENABLED, $t_poll_answer);
                $t_answers_array[$key] = $t_poll_check_html->getContent();

                if ($valid == true && strlen(trim($t_answers_array[$key])) < 1) {

                    $t_answers_array[$key] = $t_poll_check_html->getOriginalContent();
                    $error_msg_array[] = $lang['pollquestioncontainsinvalidhtml'];
                    $valid = false;
                }
            }
        }

        if (!isset($t_answers_array[0]) || strlen(trim(stripslashes_array($t_answers_array[0]))) < 1) {

            $error_msg_array[] = $lang['mustspecifyvalues1and2'];
            $valid = false;
        }

        if (!isset($t_answers_array[1]) || strlen(trim(stripslashes_array($t_answers_array[1]))) < 1) {

            $error_msg_array[] = $lang['mustspecifyvalues1and2'];
            $valid = false;
        }

        foreach ($t_answers_array as $t_poll_answer) {

            if (attachments_embed_check($t_poll_answer) && $t_post_html == 'Y') {

                $error_msg_array[] = $lang['notallowedembedattachmentpost'];
                $valid = false;
            }
        }
    }

    if (isset($_POST['answer_groups']) && is_array($_POST['answer_groups'])) {

        foreach ($_POST['answer_groups'] as $key => $t_answer_group) {

            if (isset($t_answers_array[$key]) && is_numeric($t_answer_group)) {

                $t_answer_groups[$key] = $t_answer_group;
            }
        }

    }else {

        $error_msg_array[] = $lang['mustprovideanswergroups'];
        $valid = false;
    }

    if (isset($_POST['poll_type']) && is_numeric($_POST['poll_type'])) {
        $t_poll_type = $_POST['poll_type'];
    }else {
        $error_msg_array[] = $lang['mustprovidepolltype'];
        $valid = false;
    }

    if (isset($_POST['show_results']) && is_numeric($_POST['show_results'])) {
        $t_show_results = $_POST['show_results'];
    }else {
        $error_msg_array[] = $lang['mustprovidepollresultsdisplaytype'];
        $valid = false;
    }

    if (isset($_POST['poll_vote_type']) && is_numeric($_POST['poll_vote_type'])) {
        $t_poll_vote_type = $_POST['poll_vote_type'];
    }else {
        $error_msg_array[] = $lang['mustprovidepollvotetype'];
        $valid = false;
    }

    if (isset($_POST['option_type']) && is_numeric($_POST['option_type'])) {
        $t_option_type = $_POST['option_type'];
    }else {
        $error_msg_array[] = $lang['mustprovidepolloptiontype'];
        $valid = false;
    }

    if (isset($_POST['change_vote']) && is_numeric($_POST['change_vote'])) {
        $t_change_vote = $_POST['change_vote'];
    }else {
        $error_msg_array[] = $lang['mustprovidepollvotetype'];
        $valid = false;
    }

    if (isset($_POST['allow_guests']) && is_numeric($_POST['allow_guests'])) {
        $t_allow_guests = $_POST['allow_guests'];
    }elseif (!forum_get_setting('poll_allow_guests', false)) {
        $t_allow_guests = POLL_GUEST_DENIED;
    }else {
        $error_msg_array[] = $lang['mustprovidepollguestvotetype'];
        $valid = false;
    }

    if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
        $t_close_poll = $_POST['close_poll'];
    }else {
        $t_close_poll = false;
    }

    if ($valid && $t_poll_type == POLL_TABLE_GRAPH && sizeof(array_unique($t_answer_groups)) <> 2) {

        $error_msg_array[] = $lang['tablepollmusthave2groups'];
        $valid = false;
    }

    if ($valid && $t_poll_type == POLL_TABLE_GRAPH && $t_change_vote == POLL_VOTE_MULTI) {

        $error_msg_array[] = $lang['nomultivotetabulars'];
        $valid = false;
    }

    if ($valid && $t_poll_vote_type == POLL_VOTE_PUBLIC && $t_change_vote == POLL_VOTE_MULTI) {

        $error_msg_array[] = $lang['nomultivotepublic'];
        $valid = false;
    }

    if (isset($_POST['t_message_text']) && strlen(trim(stripslashes_array($_POST['t_message_text']))) > 0) {

        $t_message_text = trim(stripslashes_array($_POST['t_message_text']));

        if (attachments_embed_check($t_message_text) && $t_message_html == "Y") {

            $error_msg_array[] = $lang['notallowedembedattachmentpost'];
            $valid = false;
        }
    }

    if (isset($t_sig)) {

        if (attachments_embed_check($t_sig) && $t_sig_html == "Y") {

            $error_msg_array[] = $lang['notallowedembedattachmentsignature'];
            $valid = false;
        }
    }

    if ($valid && !folder_thread_type_allowed($t_fid, FOLDER_ALLOW_POLL_THREAD)) {

        $error_msg_array[] = $lang['cannotpostthisthreadtypeinfolder'];
        $valid = false;
    }

}elseif (isset($_POST['emots_toggle']) || isset($_POST['sig_toggle'])) {

    if (isset($_POST['t_message_text']) && strlen(trim(stripslashes_array($_POST['t_message_text']))) > 0) {
        $t_message_text = trim(stripslashes_array($_POST['t_message_text']));
    }

    if (isset($_POST['t_sig'])) {
        $t_sig = trim(stripslashes_array($_POST['t_sig']));
    }

    if (isset($_POST['emots_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs = array('POST_PAGE' => $page_prefs);
    $user_prefs_global = array();

    if (!user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }

}elseif (isset($_POST['change_count'])) {

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (isset($_POST['t_threadtitle']) && strlen(trim(stripslashes_array($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(stripslashes_array($_POST['t_threadtitle']));
    }else {
        $t_threadtitle = '';
    }

    if (isset($_POST['t_question']) && strlen(trim(stripslashes_array($_POST['t_question']))) > 0) {
        $t_question = trim(stripslashes_array($_POST['t_question']));
    }else {
        $t_question = '';
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
        $t_fid = $_POST['t_fid'];
    }

    if (isset($_POST['answers']) && is_array($_POST['answers'])) {

        $t_answers_array = array();

        foreach ($_POST['answers'] as $t_answer) {

            if (strlen(trim(stripslashes_array($t_answer))) > 0) {

                $t_answers_array[] = trim(stripslashes_array($t_answer));
            }
        }
    }

    if (isset($_POST['answer_groups']) && is_array($_POST['answer_groups'])) {

        foreach ($_POST['answer_groups'] as $key => $t_answer_group) {

            if (isset($t_answers_array[$key]) && is_numeric($t_answer_group)) {

                $t_answer_groups[$key] = $t_answer_group;
            }
        }
    }

    if (isset($_POST['poll_type']) && is_numeric($_POST['poll_type'])) {
        $t_poll_type = $_POST['poll_type'];
    }

    if (isset($_POST['show_results']) && is_numeric($_POST['show_results'])) {
        $t_show_results = $_POST['show_results'];
    }

    if (isset($_POST['poll_vote_type']) && is_numeric($_POST['poll_vote_type'])) {
        $t_poll_vote_type = $_POST['poll_vote_type'];
    }

    if (isset($_POST['option_type']) && is_numeric($_POST['option_type'])) {
        $t_option_type = $_POST['option_type'];
    }

    if (isset($_POST['change_vote']) && is_numeric($_POST['change_vote'])) {
        $t_change_vote = $_POST['change_vote'];
    }

    if (isset($_POST['allow_guests']) && is_numeric($_POST['allow_guests'])) {
        $t_allow_guests = $_POST['allow_guests'];
    }elseif (!forum_get_setting('poll_allow_guests', false)) {
        $t_allow_guests = POLL_GUEST_DENIED;
    }

    if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
        $t_close_poll = $_POST['close_poll'];
    }else {
        $t_close_poll = false;
    }
}

if (isset($_POST['answer_count']) && is_numeric($_POST['answer_count'])) {
    $t_answer_count = $_POST['answer_count'];
}else {
    $t_answer_count = 0;
}

if (isset($t_fid) && !session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !session_check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if (!isset($t_message_text)) $t_message_text = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($post_html, $t_message_text, $emots_enabled, $links_enabled);
$sig = new MessageText($sig_html, $t_sig, true, false);

$t_message_text = $post->getContent();
$t_sig = $sig->getContent();

if (mb_strlen($t_message_text) >= 65535) {

    $error_msg_array[] = sprintf($lang['reducemessagelength'], number_format(mb_strlen($t_message_text)));
    $valid = false;
}

if (mb_strlen($t_sig) >= 65535) {

    $error_msg_array[] = sprintf($lang['reducesiglength'], number_format(mb_strlen($t_sig)));
    $valid = false;
}

// De-dupe key
if (isset($_POST['t_dedupe']) && is_numeric($_POST['t_dedupe'])) {
    $t_dedupe = $_POST['t_dedupe'];
}else{
    $t_dedupe = time();
}

if ($valid && isset($_POST['post'])) {

    if (post_check_frequency()) {

        if (post_check_ddkey($t_dedupe)) {

            // Work out when the poll will close.
            if ($t_close_poll == POLL_CLOSE_ONE_DAY) {

                $t_poll_closes = time() + DAY_IN_SECONDS;

            }elseif ($t_close_poll == POLL_CLOSE_THREE_DAYS) {

                $t_poll_closes = time() + (DAY_IN_SECONDS * 3);

            }elseif ($t_close_poll == POLL_CLOSE_SEVEN_DAYS) {

                $t_poll_closes = time() + (DAY_IN_SECONDS * 7);

            }elseif ($t_close_poll == POLL_CLOSE_THIRTY_DAYS) {

                $t_poll_closes = time() + (DAY_IN_SECONDS * 30);

            }elseif ($t_close_poll == POLL_CLOSE_NEVER) {

                $t_poll_closes = false;
            }

            if ($allow_html == false || !isset($t_post_html) || $t_post_html == 'N') {
                $t_answers_array = htmlentities_array($t_answers_array);
            }

            // Create the poll thread with the poll_flag set to Y and sticky flag set to N
            $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle, 'Y', 'N');

            $t_pid = post_create($t_fid, $t_tid, 0, $uid, 0, '');

            // Ensure that Tablular polls have
            if ($t_poll_type == POLL_TABLE_GRAPH) $t_poll_vote_type = POLL_VOTE_PUBLIC;

            poll_create($t_tid, $t_answers_array, $t_answer_groups, $t_poll_closes, $t_change_vote, $t_poll_type, $t_show_results, $t_poll_vote_type, $t_option_type, $t_question, $t_allow_guests);

            post_save_attachment_id($t_tid, $t_pid, $aid);

            if (strlen($t_message_text) > 0) {

                if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
                    $t_message_text.= "<div class=\"sig\">$t_sig</div>";
                }

                post_create($t_fid, $t_tid, 1, $uid, $uid, $t_message_text);
            }

            if ($high_interest == "Y") thread_set_high_interest($t_tid);
        }

        if (isset($t_tid) && $t_tid > 0) {
            $uri = "discussion.php?webtag=$webtag&msg=$t_tid.1";
        }else {
            $uri = "discussion.php?webtag=$webtag";
        }

        header_redirect($uri);

    }else {

        $error_msg_array[] = sprintf($lang['postfrequencytoogreat'], forum_get_setting('minimum_post_frequency', false, 0));
    }
}

if (!isset($t_fid)) {
    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $t_fid = $_GET['fid'];
    }else {
        $t_fid = 1;
    }
}

if (!$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "" ,FOLDER_ALLOW_POLL_THREAD, USER_PERM_THREAD_CREATE, "", "post_folder_dropdown")) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannotcreatenewthreads']);
    html_draw_bottom();
    exit;
}

html_draw_top("title={$lang['createpoll']}", "basetarget=_blank", "onUnload=clearFocus()", "resize_width=785", "post.js", "attachments.js", "dictionary.js", "htmltools.js", "emoticons.js", 'class=window_title');

echo "<h1>{$lang['createpoll']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '785', 'left');
}

$t_message_text = $post->getTidyContent();

$t_sig = $sig->getTidyContent();

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_poll\" action=\"create_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('t_dedupe', htmlentities_array($t_dedupe)), "\n";
echo "  <table width=\"785\" class=\"max_width\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if ($valid && (isset($_POST['preview_poll']) || isset($_POST['preview_form']))) {

    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['preview']}</td>\n";
    echo "                </tr>";

    $polldata['TLOGON'] = $lang['allcaps'];
    $polldata['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get($uid);

    $polldata['FLOGON']   = $preview_tuser['LOGON'];
    $polldata['FNICK']    = $preview_tuser['NICKNAME'];
    $polldata['FROM_UID'] = $preview_tuser['UID'];

    $polldata['CONTENT'] = "<br />\n";
    $polldata['CONTENT'].= "<div align=\"center\">\n";
    $polldata['CONTENT'].= "<table class=\"box\" width=\"475\">\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td align=\"center\">\n";
    $polldata['CONTENT'].= "      <table width=\"95%\">\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td align=\"left\"><h2>". htmlentities_array($t_question). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td align=\"left\" class=\"postbody\">\n";

    $pollresults = array();

    $max_value   = 0;
    $totalvotes  = 0;
    $optioncount = 0;

    // Poll answers and groups. If HTML is disabled we need to pass
    // the answers through htmlentities_array.
    if ($allow_html == false || !isset($t_post_html) || $t_post_html == 'N') {
        $poll_preview_answers_array = htmlentities_array($t_answers_array);
    }else {
        $poll_preview_answers_array = $t_answers_array;
    }

    // Get the poll groups.
    $poll_preview_groups_array = $t_answer_groups;

    // Generate some random votes
    $poll_preview_votes_array = rand_array(0, sizeof($t_answers_array), 1, 10);

    // Construct the pollresults array that will be used to display the graph
    // Modified to handle the new Group ID.
    $pollresults = array('OPTION_ID'   => array_keys($poll_preview_answers_array),
                         'OPTION_NAME' => array_values($poll_preview_answers_array),
                         'GROUP_ID'    => array_values($poll_preview_groups_array),
                         'VOTES'       => array_values($poll_preview_votes_array));

    if (isset($_POST['option_type']) && is_numeric($_POST['option_type'])) {
        $pollpreviewdata['OPTIONTYPE'] = $t_option_type;
    }else {
        $pollpreviewdata['OPTIONTYPE'] = 0;
    }

    if (isset($_POST['preview_form'])) {

        $polldata['CONTENT'].= poll_preview_form($pollresults, $pollpreviewdata);

    }else {

        if ($t_poll_type == POLL_VERTICAL_GRAPH) {
            $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);
        }elseif ($t_poll_type == POLL_TABLE_GRAPH) {
            $polldata['CONTENT'] .= poll_preview_graph_table($pollresults);
        } else {
            $polldata['CONTENT'].= poll_preview_graph_horz($pollresults);
        }
    }

    $polldata['CONTENT'].= "          </td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "      </table>\n";
    $polldata['CONTENT'].= "    </td>\n";
    $polldata['CONTENT'].= "  </tr>\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td align=\"center\">";
    $polldata['CONTENT'].= "      <table width=\"95%\">\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td class=\"postbody\" align=\"center\">";

    if ($t_change_vote == POLL_VOTE_CAN_CHANGE) {
        $polldata['CONTENT'].= $lang['abletochangevote'];
    }elseif ($t_change_vote == POLL_VOTE_MULTI) {
        $polldata['CONTENT'].= $lang['abletovotemultiple'];
    }else {
        $polldata['CONTENT'].= $lang['notabletochangevote'];
    }

    $polldata['CONTENT'].= "          </td>";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "      </table>\n";
    $polldata['CONTENT'].= "    </td>";
    $polldata['CONTENT'].= "  </tr>\n";
    $polldata['CONTENT'].= "</table>\n";
    $polldata['CONTENT'].= "</div>\n";
    $polldata['CONTENT'].= "<p class=\"postbody\" align=\"center\">{$lang['pollvotesrandom']}</p>\n";

    // Attachments preview
    $polldata['AID'] = $aid;

    echo "                <tr>\n";
    echo "                  <td align=\"left\"><br />\n";

    message_display(0, $polldata, 0, 0, 0, false, false, false, true, $show_sigs, true);

    echo "                  </td>\n";
    echo "                </tr>\n";

    if (strlen($t_message_text) > 0) {

        $polldata['CONTENT'] = $t_message_text;

        if ($allow_sig == true && strlen(trim($t_sig)) > 0) {

            $polldata['CONTENT'].= "<div class=\"sig\">". $t_sig. "</div>";
        }

        echo "                <tr>\n";
        echo "                  <td align=\"left\"><br />", message_display(0, $polldata, 0, 0, 0, false, false, false, false, $show_sigs, true), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

$tools = new TextAreaHTML("f_poll");

echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['createpoll']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"220\">\n";
echo "                    <table class=\"posthead\" width=\"220\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['folder']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">$folder_dropdown</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['threadtitle']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("t_threadtitle", isset($t_threadtitle) ? htmlentities_array($t_threadtitle) : '', 30, 64, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['pollquestion']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_input_text("t_question", isset($t_question) ? htmlentities_array($t_question) : '', 30, 64, false, "thread_title"), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['messageoptions']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_checkbox("t_post_interest", "Y", $lang['setthreadtohighinterest'], $high_interest == "Y"), "</td>\n";
echo "                      </tr>\n";

if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['admin']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_closed", "Y", $lang['closeforposting'], (isset($t_closed) ? $t_closed == 'Y' : false)), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("t_sticky", "Y", $lang['makesticky'], (isset($t_sticky) ? $t_sticky == 'Y' : false)), "</td>\n";
    echo "                      </tr>\n";
}

echo "                    </table>\n";

if (($user_emoticon_pack = session_get_value('EMOTICONS')) === false) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
}

if (($emoticon_preview_html = emoticons_preview($user_emoticon_pack))) {

    echo "                    <br />\n";
    echo "                    <table width=\"196\" class=\"messagefoot\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'emots_toggle', 'hide', '', 'button_image toggle_button', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                        <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'emots_toggle', 'show', '', 'button_image toggle_button', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"2\">\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {
        echo "                          <div class=\"emots_toggle\">{$emoticon_preview_html}</div>\n";
    } else {
        echo "                          <div class=\"emots_toggle\" style=\"display: none\">{$emoticon_preview_html}</div>\n";
    }

    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
}

echo "                  </td>\n";
echo "                  <td align=\"left\" valign=\"top\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>{$lang['poll']}</h2>\n";
echo "                          <table width=\"520\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table border=\"0\" class=\"posthead\" width=\"500\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\"><h2>{$lang['possibleanswers']}</h2></td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['enterpollquestionexp']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">\n";
echo "                                      <table border=\"0\" class=\"posthead\" width=\"100%\">\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">{$lang['numberanswers']}: ", form_dropdown_array('answer_count', array('5', '10', '15', '20'), $t_answer_count), "&nbsp;", form_submit('change_count', $lang['change']), "</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                        </tr>\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                        </tr>\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">{$lang['answertext']}</td>\n";
echo "                                          <td align=\"center\">{$lang['answergroup']}</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                        </tr>\n";

$available_answers = array(5, 10, 15, 20);

if (isset($t_answer_count) && is_numeric($t_answer_count)) {
    $answer_count = $available_answers[$t_answer_count];
}else {
    $answer_count = 5;
}

$answer_groups = range(0, $answer_count);
unset($answer_groups[0]);

for ($i = 0; $i < $answer_count; $i++) {

    echo "                                        <tr>\n";
    echo "                                          <td align=\"left\">", $i + 1, ". </td>\n";
    echo "                                          <td align=\"left\">", form_input_text("answers[]", isset($t_answers_array[$i]) ? htmlentities_array($t_answers_array[$i]) : '', 45, 255), "</td>\n";
    echo "                                          <td align=\"center\">", form_dropdown_array("answer_groups[]", $answer_groups, (isset($t_answer_groups[$i])) ? $t_answer_groups[$i] : 0), "</td>\n";
    echo "                                          <td align=\"left\">&nbsp;</td>\n";
    echo "                                        </tr>\n";
}

echo "                                        <tr>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";

if ($allow_html == true) {
    echo "                                          <td align=\"left\" colspan=\"3\">", form_checkbox('t_post_html', 'Y', $lang['answerscontainHTML'], (isset($t_post_html) && $t_post_html == 'Y')), "</td>\n";
} else {
    echo "                                          <td align=\"left\" colspan=\"3\">", form_input_hidden('t_post_html', 'N'), "</td>\n";
}

echo "                                        </tr>\n";
echo "                                      </table>\n";
echo "                                    </td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";
echo "                                <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" class=\"subhead\">{$lang['advancedoptions']}</td>\n";

if (($page_prefs & POLL_ADVANCED_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'poll_advanced_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'poll_advanced_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
}

echo "                                  </tr>";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";

if (($page_prefs & POLL_ADVANCED_DISPLAY) > 0) {
    echo "                                <div class=\"poll_advanced_toggle\">\n";
} else {
    echo "                                <div class=\"poll_advanced_toggle\" style=\"display: none\">\n";
}

echo "                                  <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" colspan=\"2\">\n";
echo "                                        <table border=\"0\" class=\"posthead\" width=\"500\">\n";
echo "                                          <tr>\n";
echo "                                            <td rowspan=\"27\" width=\"1%\">&nbsp;</td>\n";
echo "                                            <td align=\"left\"><h2>{$lang['optionsdisplay']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['optionsdisplayexp']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_RADIOS, $lang['radios'], isset($t_option_type) ? $t_option_type == POLL_OPTIONS_RADIOS : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, $lang['dropdown'], isset($t_option_type) ? $t_option_type == POLL_OPTIONS_DROPDOWN : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>{$lang['votechanging']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['votechangingexp']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, $lang['yes'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_CAN_CHANGE : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, $lang['no'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_CANNOT_CHANGE : false), "</td>\n";
echo "                                                  <td align=\"left\">", form_radio('change_vote', POLL_VOTE_MULTI, $lang['allowmultiplevotes'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_MULTI : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";

if (forum_get_setting('poll_allow_guests', false)) {

    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\"><h2>{$lang['guestvoting']}</h2></td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">{$lang['guestvotingexp']}</td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">\n";
    echo "                                              <table border=\"0\" width=\"100%\">\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, $lang['yes'], isset($t_allow_guests) ? $t_allow_guests == POLL_GUEST_ALLOWED : false), "</td>\n";
    echo "                                                  <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_DENIED, $lang['no'], isset($t_allow_guests) ? $t_allow_guests == POLL_GUEST_DENIED : true), "</td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
    echo "                                            </td>\n";
    echo "                                          </tr>\n";
    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">&nbsp;</td>\n";
    echo "                                          </tr>\n";
}

echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>{$lang['pollresults']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['pollresultsexp']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"25%\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, $lang['horizgraph'], isset($t_poll_type) ? $t_poll_type == POLL_HORIZONTAL_GRAPH : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"25%\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, $lang['vertgraph'], isset($t_poll_type) ? $t_poll_type == POLL_VERTICAL_GRAPH : false), "</td>\n";
echo "                                                  <td align=\"left\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_TABLE_GRAPH, $lang['tablegraph'], isset($t_poll_type) ? $t_poll_type == POLL_TABLE_GRAPH : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>{$lang['pollvotetype']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['pollvotesexp']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_ANON, $lang['pollvoteanon'], isset($t_poll_vote_type) ? $t_poll_vote_type == POLL_VOTE_ANON : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_PUBLIC, $lang['pollvotepub'], isset($t_poll_vote_type) ? $t_poll_vote_type == POLL_VOTE_PUBLIC : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\"><h2>{$lang['expiration']}</h2></td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['showresultswhileopen']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";
echo "                                              <table border=\"0\" width=\"100%\">\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_SHOW_RESULTS, $lang['yes'], isset($t_show_results) ? $t_show_results == POLL_SHOW_RESULTS : true), "</td>\n";
echo "                                                  <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_HIDE_RESULTS, $lang['no'], isset($t_show_results) ? $t_show_results == POLL_HIDE_RESULTS : false), "</td>\n";
echo "                                                </tr>\n";
echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">{$lang['whenlikepollclose']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", form_dropdown_array('close_poll', array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never']), isset($t_close_poll) ? $t_close_poll : 4), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                        </table>\n";
echo "                                      </td>\n";
echo "                                    </tr>\n";
echo "                                  </table>\n";
echo "                                </div>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";
echo "                                <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\" class=\"subhead\">{$lang['polladditionalmessage']}</td>\n";

if (($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY) > 0) {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'poll_additional_message_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
} else {
    echo "                                    <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'poll_additional_message_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
}

echo "                                  </tr>";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>\n";

if (($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY) > 0) {
    echo "                                <div class=\"poll_additional_message_toggle\">\n";
} else {
    echo "                                <div class=\"poll_additional_message_toggle\" style=\"display: none\">\n";
}

echo "                                  <table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" colspan=\"2\">\n";
echo "                                        <table border=\"0\" class=\"posthead\" width=\"500\">\n";
echo "                                          <tr>\n";
echo "                                            <td rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                                            <td align=\"left\">{$lang['polladditionalmessageexp']}</td>\n";
echo "                                          </tr>\n";

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type <> POST_TOOLBAR_DISABLED) {

    echo "                                          <tr>\n";
    echo "                                            <td align=\"left\">", $tools->toolbar(), "</td>\n";
    echo "                                          </tr>\n";

}else {

    $tools->set_tinymce(false);
}

echo "                                          <tr>\n";
echo "                                            <td align=\"left\">", $tools->textarea('t_message_text', $t_message_text, 20, 75, false, 'tabindex="1"', 'post_content'), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";

if ($post->isDiff()) {
    echo $tools->compare_original("t_message_text", $post);
}

if ($allow_html == true) {

    if (($tools->get_tinymce())) {

        echo form_input_hidden("t_message_html", "enabled");

    }else {

        echo "                                              <h2>{$lang['htmlinmessage']}</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_message_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_message_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_message_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED)." \n";
    }

}else {

    echo form_input_hidden("t_message_html", "disabled");
}

echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">&nbsp;</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"left\">\n";

if ($allow_sig == true) {

    echo "                                              <table class=\"messagefoot\" width=\"486\" cellspacing=\"0\">\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" class=\"subhead\">{$lang['signature']}</td>\n";

    if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {
        echo "                                                  <td class=\"subhead\" align=\"right\">", form_submit_image('hide.png', 'sig_toggle', 'hide', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    } else {
        echo "                                                  <td class=\"subhead\" align=\"right\">", form_submit_image('show.png', 'sig_toggle', 'show', '', 'button_image toggle_button'), "&nbsp;</td>\n";
    }

    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\" colspan=\"2\">\n";
    echo "                                                    <div class=\"sig_toggle\" style=\"display: ", (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) ? "block" : "none", "\">\n";

    $t_sig = $sig->getTidyContent();

    echo $tools->textarea("t_sig", $t_sig, 5, 75, false, 'tabindex="7"', 'signature_content');

    if ($sig->isDiff() && !$fetched_sig) {
        echo $tools->compare_original("t_sig", $sig);
    }

    echo "                                                    </div>\n";
    echo "                                                  </td>\n";
    echo "                                                </tr>\n";
    echo "                                              </table>\n";
    echo "                                              ", form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";
}

echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                        </table>\n";
echo "                                      </td>\n";
echo "                                    </tr>\n";
echo "                                  </table>\n";
echo "                                </div>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                ", form_submit("post", $lang['post']), "&nbsp;", form_submit("preview_poll", $lang['preview']), "&nbsp;", form_submit("preview_form", $lang['previewvotingform']), "&nbsp;", form_submit("cancel", $lang['cancel']);

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "&nbsp;<a href=\"attachments.php?aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>{$lang['attachments']}</span></a>\n";
    echo "                                        ", form_input_hidden("aid", htmlentities_array($aid)), "\n";
}


echo "                              </td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>