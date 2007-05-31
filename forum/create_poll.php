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

/* $Id: create_poll.php,v 1.202 2007-05-31 21:59:14 decoyduck Exp $ */

/**
* Displays and processes the Create Poll page
*/

/**
*/

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (user_is_guest()) {
    html_guest_error();
    exit;
}

// Check to see if the forum owner has allowed the creation of polls

if (forum_get_setting('allow_polls', 'N')) {

    html_draw_top();
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
$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Get the user's UID. We need this a couple of times

$uid = bh_session_get_value('UID');

$valid = true;

$fix_html = true;

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

if (isset($_POST['t_message_html'])) {

    $t_message_html = $_POST['t_message_html'];

    if ($t_message_html == "enabled_auto") {
        $post_html = POST_HTML_DISABLED;
    }else if ($t_message_html == "enabled") {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }

}else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = POST_HTML_DISABLED;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = POST_HTML_ENABLED;
    }else {
        $post_html = POST_HTML_DISABLED;
    }

    $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);
    $links_enabled = ($page_prefs & POST_AUTO_LINKS);
    $spelling_enabled = ($page_prefs & POST_CHECK_SPELLING);

    if (!$high_interest = bh_session_get_value('MARK_AS_OF_INT')) {
        $high_interest = "N";
    }
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = POST_HTML_ENABLED;
    }

    $fetched_sig = false;

    if (isset($_POST['t_sig']) && strlen(trim(_stripslashes($_POST['t_sig']))) > 0) {
        $t_sig = trim(_stripslashes($_POST['t_sig']));
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

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(rand()));
}

if (!isset($sig_html)) $sig_html = POST_HTML_DISABLED;

if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "./discussion.php?webtag=$webtag";
    header_redirect($uri);

}elseif (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['submit']) || isset($_POST['change_count'])) {

    $valid = true;

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
    }else {
        $error_html = "<h2>{$lang['mustenterthreadtitle']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_question']) && strlen(trim(_stripslashes($_POST['t_question']))) > 0) {
        $t_question = trim(_stripslashes($_POST['t_question']));
    }elseif (isset($t_threadtitle)) {
        $t_question = $t_threadtitle;
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        $t_fid = $_POST['t_fid'];

        if (!folder_is_valid($t_fid)) {

            $error_html = "<h2>{$lang['unknownfolder']}</h2>\n";
            $valid = false;
        }

        if (!bh_session_check_perm(USER_PERM_THREAD_CREATE | USER_PERM_POST_READ, $t_fid)) {

            $error_html = "<h2>{$lang['cannotcreatethreadinfolder']}</h2>\n";
            $valid = false;
        }

        if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

            $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
            $valid = false;
        }

    }else {

        $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['answers']) && is_array($_POST['answers'])) {

        $t_answers = array();

        foreach($_POST['answers'] as $t_answer) {

            if (strlen(trim(_stripslashes($t_answer))) > 0) {

                $t_answers[] = trim(_stripslashes($t_answer));
            }
        }

        if (!isset($t_answers[0]) || strlen(trim(_stripslashes($t_answers[0]))) == 0) {
            $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
            $valid = false;
        }

        if (!isset($t_answers[1]) || strlen(trim(_stripslashes($t_answers[1]))) == 0) {
            $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
            $valid = false;
        }

        foreach($t_answers as $t_answer) {

            if (attachment_embed_check($t_answer) && $t_post_html == 'Y') {

                $error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
                $valid = false;
            }
        }
    }

    if (isset($_POST['answer_groups']) && is_array($_POST['answer_groups'])) {

        foreach ($_POST['answer_groups'] as $key => $t_answer_group) {

            if (isset($t_answers[$key])) {

                $t_answer_groups[$key] = $t_answer_group;
            }
        }

    }else {

        $error_html = "<h2>{$lang['mustprovideanswergroups']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['poll_type']) && is_numeric($_POST['poll_type'])) {
        $t_poll_type = $_POST['poll_type'];
    }else {
        $error_html = "<h2>{$lang['mustprovidepolltype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['show_results']) && is_numeric($_POST['show_results'])) {
        $t_show_results = $_POST['show_results'];
    }else {
        $error_html = "<h2>{$lang['mustprovidepollresultsdisplaytype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['poll_vote_type']) && is_numeric($_POST['poll_vote_type'])) {
        $t_poll_vote_type = $_POST['poll_vote_type'];
    }else {
        $error_html = "<h2>{$lang['mustprovidepollvotetype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['option_type']) && is_numeric($_POST['option_type'])) {
        $t_option_type = $_POST['option_type'];
    }else {
        $error_html = "<h2>{$lang['mustprovidepolloptiontype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['change_vote']) && is_numeric($_POST['change_vote'])) {
        $t_change_vote = $_POST['change_vote'];
    }else {
        $error_html = "<h2>{$lang['mustprovidepollvotetype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['allow_guests']) && is_numeric($_POST['allow_guests'])) {
        $t_allow_guests = $_POST['allow_guests'];
    }elseif (!forum_get_setting('poll_allow_guests', false)) {
        $t_allow_guests = POLL_GUEST_DENIED;
    }else {        
        $error_html = "<h2>{$lang['mustprovidepollguestvotetype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
        $t_close_poll = $_POST['close_poll'];
    }else {
        $t_close_poll = false;
    }

    if ($valid && $t_poll_type == POLL_TABLE_GRAPH && sizeof(array_unique($t_answer_groups)) != 2) {
        $error_html = "<h2>{$lang['tablepollmusthave2groups']}</h2>";
        $valid = false;
    }

    if ($valid && $t_poll_type == POLL_TABLE_GRAPH && $t_change_vote == POLL_MULTIVOTE) {
        $error_html = "<h2>{$lang['nomultivotetabulars']}</h2>";
        $valid = false;
    }

    if ($valid && $t_poll_vote_type == POLL_VOTE_PUBLIC && $t_change_vote == POLL_VOTE_MULTI) {
        $error_html = "<h2>{$lang['nomultivotepublic']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_message_text']) && strlen(trim(_stripslashes($_POST['t_message_text']))) > 0) {

        $t_message_text = trim(_stripslashes($_POST['t_message_text']));

        if (attachment_embed_check($t_message_text) && $t_message_html == "Y") {

            $error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
            $valid = false;
        }
    }

    if (isset($t_sig)) {

        if (attachment_embed_check($t_sig) && $t_sig_html == "Y") {
            $error_html = "<h2>{$lang['notallowedembedattachmentsignature']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid && !folder_thread_type_allowed($t_fid, FOLDER_ALLOW_POLL_THREAD)) {
        $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
        $valid = false;
    }

}elseif (isset($_POST['emots_toggle_x']) || isset($_POST['sig_toggle_x'])) {

    if (isset($_POST['t_message_text']) && strlen(trim(_stripslashes($_POST['t_message_text']))) > 0) {
        $t_message_text = trim(_stripslashes($_POST['t_message_text']));
    }

    if (isset($t_sig)) {
        $t_sig = _htmlentities($t_sig);
    }

    if (isset($_POST['emots_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_EMOTICONS_DISPLAY;

    }elseif (isset($_POST['sig_toggle_x'])) {

        $page_prefs = (double) $page_prefs ^ POST_SIGNATURE_DISPLAY;
    }

    $user_prefs['POST_PAGE'] = $page_prefs;
    $user_prefs_global['POST_PAGE'] = true;

    user_update_prefs($uid, $user_prefs, $user_prefs_global);

    $fix_html = false;
}

if (isset($_POST['change_count'])) {

    $valid = true;
    unset($error_html);
}

if (isset($_POST['answer_count']) && is_numeric($_POST['answer_count'])) {
    $t_answer_count = $_POST['answer_count'];
}else {
    $t_answer_count = 0;
}

$allow_html = true;
$allow_sig = true;

if (isset($t_fid) && !bh_session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if (isset($t_fid) && !bh_session_check_perm(USER_PERM_SIGNATURE, $t_fid)) {
    $allow_sig = false;
}

if (!isset($t_message_text)) $t_message_text = "";
if (!isset($t_sig)) $t_sig = "";

$post = new MessageText($allow_html ? $post_html : false, $t_message_text, $emots_enabled, $links_enabled);
$sig = new MessageText($allow_html ? $sig_html : false, $t_sig, true, false);

$t_message_text = $post->getContent();
$t_sig = $sig->getContent();

if (strlen($t_message_text) >= 65535) {
    $error_html = "<h2>{$lang['reducemessagelength']} ".number_format(strlen($t_message_text)).")</h2>";
    $valid = false;
}

if (strlen($t_sig) >= 65535) {
    $error_html = "<h2>{$lang['reducesiglength']} ".number_format(strlen($t_sig)).")</h2>";
    $valid = false;
}

if ($valid && isset($_POST['submit'])) {

    if (check_post_frequency()) {

        if (check_ddkey($_POST['t_dedupe'])) {

            // Work out when the poll will close.

            if ($t_close_poll == POLL_CLOSE_ONE_DAY) {

                $t_poll_closes = mktime() + DAY_IN_SECONDS;

            }elseif ($t_close_poll == POLL_CLOSE_THREE_DAYS) {

                $t_poll_closes = mktime() + (DAY_IN_SECONDS * 3);

            }elseif ($t_close_poll == POLL_CLOSE_SEVEN_DAYS) {

                $t_poll_closes = mktime() + (DAY_IN_SECONDS * 7);

            }elseif ($t_close_poll == POLL_CLOSE_THIRTY_DAYS) {

                $t_poll_closes = mktime() + (DAY_IN_SECONDS * 30);

            }elseif ($t_close_poll == POLL_CLOSE_NEVER) {

                $t_poll_closes = false;
            }

            // Check HTML tick box, innit.

            $answers = array();
            $ans_h = POST_HTML_DISABLED;

            if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {
                $ans_h = POST_HTML_ENABLED;
            }

            foreach($t_answers as $key => $poll_answer) {

                $answers[$key] = new MessageText($ans_h, $poll_answer);
                $t_answers[$key] = $answers[$key]->getContent();
            }

            // Create the poll thread with the poll_flag set to Y and sticky flag set to N

            $t_tid = post_create_thread($t_fid, $uid, $t_threadtitle, 'Y', 'N');
            $t_pid = post_create($t_fid, $t_tid, 0, $uid, $uid, 0, '');

            // Ensure that Tablular polls have 
            
            if ($t_poll_type == POLL_TABLE_GRAPH) $t_poll_vote_type = POLL_VOTE_PUBLIC;

            poll_create($t_tid, $t_answers, $t_answer_groups, $t_poll_closes, $t_change_vote, $t_poll_type, $t_show_results, $t_poll_vote_type, $t_option_type, $t_question, $t_allow_guests);

            post_save_attachment_id($t_tid, $t_pid, $aid);

            if (strlen($t_message_text) > 0) {

                if ($allow_sig == true && strlen(trim($t_sig)) > 0) {
                    $t_message_text.= "\n<div class=\"sig\">$t_sig</div>";
                }

                post_create($t_fid, $t_tid, 1, $uid, $uid, 0, $t_message_text);
            }

            if ($high_interest == "Y") thread_set_high_interest($t_tid);
        }

        if (isset($t_tid) && $t_tid > 0) {
            $uri = "./discussion.php?webtag=$webtag&msg=$t_tid.1";
        }else {
            $uri = "./discussion.php?webtag=$webtag";
        }

        header_redirect($uri);

    }else {

        $error_html = sprintf("<h2>{$lang['postfrequencytoogreat']}</h2>", forum_get_setting('minimum_post_frequency', false, 0));
    }
}

if (!isset($t_fid)) {
    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $t_fid = $_GET['fid'];
    }else {
        $t_fid = 1;
    }
}

if (!$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "" ,FOLDER_ALLOW_POLL_THREAD, "", "post_folder_dropdown")) {

    html_draw_top();
    html_error_msg($lang['cannotcreatenewthreads']);
    html_draw_bottom();
    exit;
}

html_draw_top("basetarget=_blank", "onUnload=clearFocus()", "resize_width=785", "post.js", "attachments.js", "openprofile.js", "dictionary.js", "htmltools.js", "emoticons.js", "poll.js");

echo "<h1>{$lang['postmessage']}</h1>\n";
echo "<br />\n";
echo "<form name=\"f_poll\" action=\"create_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";

if (isset($error_html)) {

    echo "  <table class=\"posthead\" width=\"785\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"subhead\">{$lang['error']}</td>\n";
    echo "    </tr>";
    echo "    <tr>\n";
    echo "      <td align=\"left\">$error_html</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

if ($valid && (isset($_POST['preview_poll']) || isset($_POST['preview_form']))) {

    echo "<table class=\"posthead\" width=\"785\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"subhead\">{$lang['preview']}</td>\n";
    echo "  </tr>";


    $polldata['TLOGON'] = $lang['allcaps'];
    $polldata['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get($uid);

    $polldata['FLOGON']   = $preview_tuser['LOGON'];
    $polldata['FNICK']    = $preview_tuser['NICKNAME'];
    $polldata['FROM_UID'] = $preview_tuser['UID'];

    $polldata['CONTENT'] = "<br />\n";
    $polldata['CONTENT'].= "<div align=\"center\">\n";
    $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td align=\"center\">\n";
    $polldata['CONTENT'].= "      <table width=\"95%\">\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td align=\"left\"><h2>{$t_question}</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td align=\"left\" class=\"postbody\">\n";

    $pollresults = array();

    $max_value   = 0;
    $totalvotes  = 0;
    $optioncount = 0;

    $ans_h = POST_HTML_DISABLED;

    if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {
        $ans_h = POST_HTML_ENABLED;
    }

    foreach($t_answers as $key => $answer_text) {

        $answer_tmp = new MessageText($ans_h, _stripslashes($answer_text));
        $poll_answers_array[$key] = $answer_tmp->getContent();

        srand((double)microtime()*1000000);
        $poll_vote = rand(1, 10);

        if ($poll_vote > $max_value) $max_value = $poll_vote;

        $poll_votes_array[] = $poll_vote;
        $totalvotes += $poll_vote;
        $optioncount++;
    }

    $poll_groups_array = $t_answer_groups;

    // Construct the pollresults array that will be used to display the graph
    // Modified to handle the new Group ID.

    $pollresults = array('OPTION_ID'   => array_keys($poll_answers_array),
                         'OPTION_NAME' => $poll_answers_array,
                         'GROUP_ID'    => $poll_groups_array,
                         'VOTES'       => $poll_votes_array);

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

    echo "<tr><td align=\"left\">\n";
    message_display(0, $polldata, 0, 0, 0, false, false, false, true, $show_sigs, true);
    echo "</td></tr>\n";

    if (strlen($t_message_text) > 0) {

        $polldata['CONTENT'] = $t_message_text;

        if ($allow_sig == true && strlen(trim($t_sig)) > 0) {

            $polldata['CONTENT'].= "<div class=\"sig\">". $t_sig. "</div>";
        }

        echo "<tr><td align=\"left\">\n";
        message_display(0, $polldata, 0, 0, 0, false, false, false, true, $show_sigs, true);
        echo "</td></tr>\n";
    }

    echo "<tr><td align=\"left\">&nbsp;</td></tr>\n";
    echo "</table>\n";
}

echo "  <table class=\"posthead\" width=\"785\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['createpoll']}</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "        <table class=\"posthead\" width=\"210\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">\n";
echo "              <h2>{$lang['folder']}</h2>\n";
echo "              ", $folder_dropdown, "\n";
echo "              <h2>{$lang['threadtitle']}</h2>\n";
echo "              ", form_input_text("t_threadtitle", isset($t_threadtitle) ? _htmlentities($t_threadtitle) : '', 0, 0, false, "thread_title"), "\n";
echo "              <h2>{$lang['pollquestion']}</h2>\n";
echo "              ", form_input_text('t_question', isset($t_question) ? _htmlentities($t_question) : '', 0, 0, false, "thread_title"), "\n";
echo "              <h2>{$lang['messageoptions']}</h2>\n";
echo "              ", form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo "              ", form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo "              ", form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br />\n";
echo "              ", form_checkbox("t_post_interest", "Y", $lang['setthreadtohighinterest'], $high_interest == "Y")."<br />\n";

if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    echo "              <br />\n";
    echo "              <h2>{$lang['admin']}</h2>\n";
    echo "              ", form_checkbox("t_closed", "Y", $lang['closeforposting'], isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 ? true : false), "<br />";
    echo "              ", form_checkbox("t_sticky", "Y", $lang['makesticky'], isset($threaddata['STICKY']) && $threaddata['STICKY'] == "Y" ? true : false)."<br />\n";
    echo "              ", form_input_hidden("old_t_closed", isset($threaddata['CLOSED']) && $threaddata['CLOSED'] > 0 ? "Y" : "N"), "\n";
    echo "              ", form_input_hidden("old_t_sticky", isset($threaddata['STICKY']) && $threaddata['STICKY'] == "Y" ? "Y" : "N"), "\n";
}

$emot_user = bh_session_get_value('EMOTICONS');
$emot_prev = emoticons_preview($emot_user);

if (strlen($emot_prev) > 0) {

    echo "<br />\n";
    echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";

    if (($page_prefs & POST_EMOTICONS_DISPLAY) > 0) {

        echo "    <td class=\"subhead\" align=\"right\">". form_submit_image('emots_hide.png', 'emots_toggle', 'hide'). "&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" colspan=\"2\">{$emot_prev}</td>\n";

    }else {

        echo "    <td class=\"subhead\" align=\"right\">". form_submit_image('emots_show.png', 'emots_toggle', 'show'). "&nbsp;</td>\n";
    }

    echo "  </tr>\n";
    echo "</table>\n";
}

echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"530\">\n";
echo "        <table class=\"posthead\" width=\"530\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">\n";
echo "              <h2>{$lang['poll']}</h2>\n";
echo "              <div class=\"create_poll_display\">\n";
echo "              <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table border=\"0\" class=\"posthead\" width=\"450\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['possibleanswers']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['enterpollquestionexp']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" class=\"posthead\" cellpadding=\"0\" cellspacing=\"5\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">{$lang['numberanswers']}: ", form_dropdown_array('answer_count', array('5', '10', '15', '20'), $t_answer_count), "&nbsp;", form_submit('change_count', $lang['change']), "</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">{$lang['answertext']}</td>\n";
echo "                              <td align=\"center\">{$lang['answergroup']}</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";

$available_answers = array(5, 10, 15, 20);

if (isset($t_answer_count)) {
    $answer_count = $available_answers[$t_answer_count];
}else {
    $answer_count = 5;
}

$answer_groups = range(0, $answer_count);
unset($answer_groups[0]);

for ($i = 0; $i < $answer_count; $i++) {

    echo "            <tr>\n";
    echo "              <td align=\"left\">", $i + 1, ". </td>\n";
    echo "              <td align=\"left\">", form_input_text("answers[]", isset($t_answers[$i]) ? _htmlentities($t_answers[$i]) : '', 40, 255), "</td>\n";
    echo "              <td align=\"center\">", form_dropdown_array("answer_groups[]", $answer_groups, (isset($t_answer_groups[$i])) ? $t_answer_groups[$i] : 0), "</td>\n";
    echo "              <td align=\"left\">&nbsp;</td>\n";
    echo "            </tr>\n";
}

echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";

if ($allow_html == true) {
        echo "                              <td align=\"left\">", form_checkbox('t_post_html', 'Y', $lang['answerscontainHTML'], (isset($t_post_html) && $t_post_html == 'Y')), "</td>\n";
} else {
        echo "                              <td align=\"left\">", form_input_hidden('t_post_html', 'N'), "</td>\n";
}

echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['optionsdisplay']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['optionsdisplayexp']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" width=\"400\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_RADIOS, $lang['radios'], isset($t_option_type) ? $t_option_type == POLL_OPTIONS_RADIOS : true), "</td>\n";
echo "                              <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, $lang['dropdown'], isset($t_option_type) ? $t_option_type == POLL_OPTIONS_DROPDOWN : false), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['votechanging']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['votechangingexp']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" width=\"400\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, $lang['yes'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_CAN_CHANGE : true), "</td>\n";
echo "                              <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, $lang['no'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_CANNOT_CHANGE : false), "</td>\n";
echo "                              <td align=\"left\">", form_radio('change_vote', POLL_VOTE_MULTI, $lang['allowmultiplevotes'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_MULTI : false), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";

if (forum_get_setting('poll_allow_guests', false)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\"><h2>{$lang['guestvoting']}</h2></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['guestvotingexp']}</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table border=\"0\" width=\"400\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, $lang['yes'], isset($t_allow_guests) ? $t_allow_guests == POLL_GUEST_ALLOWED : false), "</td>\n";
    echo "                              <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_DENIED, $lang['no'], isset($t_allow_guests) ? $t_allow_guests == POLL_GUEST_DENIED : true), "</td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['pollresults']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['pollresultsexp']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" width=\"400\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" width=\"25%\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, $lang['horizgraph'], isset($t_poll_type) ? $t_poll_type == POLL_HORIZONTAL_GRAPH : true), "</td>\n";
echo "                              <td align=\"left\" width=\"25%\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, $lang['vertgraph'], isset($t_poll_type) ? $t_poll_type == POLL_VERTICAL_GRAPH : false), "</td>\n";
echo "                              <td align=\"left\" nowrap=\"nowrap\">", form_radio('poll_type', POLL_TABLE_GRAPH, $lang['tablegraph'], isset($t_poll_type) ? $t_poll_type == POLL_TABLE_GRAPH : false), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['pollvotetype']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['pollvotesexp']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" width=\"400\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_ANON, $lang['pollvoteanon'], isset($t_poll_vote_type) ? $t_poll_vote_type == POLL_VOTE_ANON : true), "</td>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_PUBLIC, $lang['pollvotepub'], isset($t_poll_vote_type) ? $t_poll_vote_type == POLL_VOTE_PUBLIC : false), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['expiration']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['showresultswhileopen']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" width=\"400\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_SHOW_RESULTS, $lang['yes'], isset($t_show_results) ? $t_show_results == POLL_SHOW_RESULTS : true), "</td>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_HIDE_RESULTS, $lang['no'], isset($t_show_results) ? $t_show_results == POLL_HIDE_RESULTS : false), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['whenlikepollclose']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_dropdown_array('close_poll', array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never']), isset($t_close_poll) ? $t_close_poll : 4), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['polladditionalmessage']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['polladditionalmessageexp']}</td>\n";
echo "                      </tr>\n";

$tools = new TextAreaHTML("f_poll");

$t_message_text = $post->getTidyContent();

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
} else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

if ($allow_html == true && $tool_type != 0) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", $tools->toolbar(), "</td>\n";
    echo "                      </tr>\n";

}else {

    $tools->setTinyMCE(false);
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", $tools->textarea('t_message_text', $t_message_text, 20, 75), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";

if ($post->isDiff() && $fix_html) {
    echo $tools->compare_original("t_message_text", $post->getOriginalContent());
}

if ($allow_html == true) {

    if ($tools->getTinyMCE()) {

        echo form_input_hidden("t_post_html", "enabled");

    } else {

        echo "            <h2>{$lang['htmlinmessage']}</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_message_html", "disabled", $lang['disabled'], $tph_radio == POST_HTML_DISABLED, "tabindex=\"6\"")." \n";
        echo form_radio("t_message_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == POST_HTML_AUTO)." \n";
        echo form_radio("t_message_html", "enabled", $lang['enabled'], $tph_radio == POST_HTML_ENABLED)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
                echo $tools->assign_checkbox("t_message_html[1]", "t_message_html[0]");
        }
        echo "            <br />";
    }
} else {
        echo form_input_hidden("t_message_html", "disabled");
}

if ($allow_sig == true) {

        echo "            <br />\n";
        echo "            <table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
        echo "              <tr>\n";
        echo "                <td align=\"left\" class=\"subhead\">{$lang['signature']}</td>\n";

        $t_sig = ($fix_html ? $sig->getTidyContent() : $sig->getOriginalContent(true));

        if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {

            echo "                <td class=\"subhead\" align=\"right\">", form_submit_image('sig_hide.png', 'sig_toggle', 'hide'), "&nbsp;</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td align=\"left\" colspan=\"2\">", $tools->textarea("t_sig", $t_sig, 5, 75, "virtual", "tabindex=\"7\"", "signature_content"), "</td>\n";

            if ($sig->isDiff() && $fix_html && !$fetched_sig) {

                echo $tools->compare_original("t_sig", $sig->getOriginalContent());
            }

        }else {

            echo "                <td class=\"subhead\" align=\"right\">", form_submit_image('sig_show.png', 'sig_toggle', 'show'), "&nbsp;</td>\n";
            echo "                ", form_input_hidden("t_sig", $t_sig), "\n";

        }

        echo "              </tr>\n";
        echo "            </table>\n";
        echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";

}

echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </div>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"left\">";

echo form_submit("submit", $lang['post'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""), "&nbsp;", form_submit("preview_poll", $lang['preview']), "&nbsp;", form_submit("preview_form", $lang['previewvotingform']), "&nbsp;", form_submit("cancel", $lang['cancel']);

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "            &nbsp;".form_button("attachments", $lang['attachments'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", _htmlentities($aid));
}


echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  ", $tools->js(false);

if (isset($_POST['t_dedupe'])) {
    echo "  ", form_input_hidden("t_dedupe", _htmlentities($_POST['t_dedupe'])), "\n";
}else{
    echo "  ", form_input_hidden("t_dedupe", _htmlentities(mktime())), "\n";
}

echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>