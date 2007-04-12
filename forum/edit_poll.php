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

/* $Id: edit_poll.php,v 1.132 2007-04-12 23:53:36 decoyduck Exp $ */

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
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
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (forum_get_setting('allow_polls', 'N')) {

    html_draw_top();
    html_error_msg($lang['pollshavebeendisabled']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($edit_msg) = explode(' ', rawurldecode($_GET['msg']));
    list($tid, $pid) = explode('.', $edit_msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {

    list($edit_msg) = explode(' ', rawurldecode($_POST['t_msg']));
    list($tid, $pid) = explode('.', $_POST['t_msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    html_error_msg($lang['nomessagespecifiedforedit']);
    html_draw_bottom();
    exit;
}

if (!thread_is_poll($tid) && $pid == 1) {

    $uri = "./edit.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg=". $_GET['msg'];
    }elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {
        $uri.= "&msg=". $_POST['t_msg'];
    }

    header_redirect($uri);
}

if (!$fid = thread_get_folder($tid)) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

$polldata    = poll_get($tid);
$pollresults = poll_get_votes($tid);

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = get_attachment_id($tid, $pid)) {

    $aid = md5(uniqid(rand()));
}

post_save_attachment_id($tid, $pid, $aid);

if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!bh_session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    html_draw_top();
    html_error_msg($lang['cannoteditpostsinthisfolder']);
    html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid)) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "./discussion.php?webtag=$webtag&msg=$edit_msg";
    header_redirect($uri);

}elseif (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['submit']) || isset($_POST['change_count'])) {

    if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
    }else {
        $error_html = "<h2>{$lang['mustenterthreadtitle']}</h2>";
        $valid = false;
    }
    if (isset($_POST['question']) && strlen(trim(_stripslashes($_POST['question']))) > 0) {
        $t_question = trim(_stripslashes($_POST['question']));
    }else {
        $t_question = $t_threadtitle;
    }

    if (isset($_POST['answers']) && is_array($_POST['answers'])) {

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
        $error_html = "<h2>{$lang['mustprovidepollchangevotetype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['allow_guests']) && is_numeric($_POST['allow_guests'])) {
        $t_allow_guests = $_POST['allow_guests'];
    }elseif (!forum_get_setting('poll_allow_guests', false)) {
        $t_allow_guests = 0;
    }else {        
        $error_html = "<h2>{$lang['mustprovidepollguestvotetype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
        $t_close_poll = $_POST['close_poll'];
    }else {
        $t_close_poll = false;
    }

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {
        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    if ($valid && $t_poll_type == 2 && sizeof(array_unique($t_answer_groups))  != 2) {
        $error_html = "<h2>{$lang['tablepollmusthave2groups']}</h2>";
        $valid = false;
    }

    if ($valid && $t_poll_type == 2 && $t_change_vote == 2) {
        $error_html = "<h2>{$lang['nomultivotetabulars']}</h2>";
        $valid = false;
    }

    if ($valid && $t_poll_vote_type == 1 && $t_change_vote == 2) {
        $error_html = "<h2>{$lang['nomultivotepublic']}</h2>";
        $valid = false;
    }

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

html_draw_top("basetarget=_blank", "resize_width=785", "openprofile.js", "post.js", "poll.js");

$allow_html = true;

if (isset($t_fid) && !bh_session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if ($valid && (isset($_POST['preview_poll']) || isset($_POST['preview_form']))) {

    $polldata['TLOGON'] = $lang['allcaps'];
    $polldata['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get(bh_session_get_value('UID'));

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
    $polldata['CONTENT'].= "          <td align=\"left\"><h2>". (isset($t_question) ? _htmlentities($t_question) : add_wordfilter_tags(thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']))). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td align=\"left\" class=\"postbody\">\n";

    $pollresults = array();

    $poll_answers_array = array();
    $poll_groups_array  = array();
    $poll_votes_array   = array();

    $max_value   = 0;
    $totalvotes  = 0;
    $optioncount = 0;

    $ans_h = 0;

    if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {
        $ans_h = 2;
    }

    foreach($t_answers as $key => $answer_text) {

        $answer_tmp = new MessageText($ans_h, $answer_text);
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

        if ($t_poll_type == 1) {
            $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);
        }elseif ($t_poll_type == 2) {
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

    if ($t_change_vote == 1) {
        $polldata['CONTENT'].= "{$lang['abletochangevote']}";
    }else {
        $polldata['CONTENT'].= "{$lang['notabletochangevote']}";
    }

    $polldata['CONTENT'].= "          </td>";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "      </table>\n";
    $polldata['CONTENT'].= "    </td>";
    $polldata['CONTENT'].= "  </tr>\n";
    $polldata['CONTENT'].= "</table>\n";
    $polldata['CONTENT'].= "</div>\n";
    $polldata['CONTENT'].= "<p class=\"postbody\" align=\"center\">{$lang['pollvotesrandom']}</p>\n";

}elseif ($valid && isset($_POST['submit'])) {

    // Work out when the poll will close.

    if ($t_close_poll == 0) {

        $t_poll_closes = mktime() + DAY_IN_SECONDS;

    }elseif ($t_close_poll == 1) {

        $t_poll_closes = mktime() + (DAY_IN_SECONDS * 3);

    }elseif ($t_close_poll == 2) {

        $t_poll_closes = mktime() + (DAY_IN_SECONDS * 7);

    }elseif ($t_close_poll == 3) {

        $t_poll_closes = mktime() + (DAY_IN_SECONDS * 30);

    }elseif ($t_close_poll == 4) {

        $t_poll_closes = -1;

    }else {

        $t_poll_closes = false;
    }

    // Check HTML tick box, innit.

    $answers = array();

    $ans_h = 0;

    if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {
        $ans_h = 2;
    }

    foreach($t_answers as $key => $poll_answer) {

        $answers[$key] = new MessageText($ans_h, $poll_answer);
        $t_answers[$key] = $answers[$key]->getContent();
    }

    if ($t_poll_type == 2) {

        $t_poll_vote_type = 1;
    }

    foreach ($t_answers as $key => $value) {

        if (!isset($pollresults['OPTION_NAME'][$key])) {

            $pollresults['OPTION_NAME'][$key] = "";
        }
    }

    foreach ($t_answer_groups as $key => $value) {

        if (!isset($pollresults['GROUP_ID'][$key])) {

            $pollresults['GROUP_ID'][$key] = $value;
        }
    }

    $hardedit = false;

    if ($t_answers != $pollresults['OPTION_NAME'] || $t_answer_groups != $pollresults['GROUP_ID'] || ($polldata['POLLTYPE'] != 2 && $t_poll_type == 2) || ($t_poll_vote_type == 1 && $polldata['VOTETYPE'] == 0)) {
        $hardedit = true;
    }

    poll_edit($fid, $tid, $t_threadtitle, $t_question, $t_answers, $t_answer_groups, $t_poll_closes, $t_change_vote, $t_poll_type, $t_show_results, $t_poll_vote_type, $t_option_type, $t_allow_guests, $hardedit);
    post_add_edit_text($tid, 1);

    post_save_attachment_id($tid, $pid, $aid);

    header_redirect("./discussion.php?webtag=$webtag&msg=$tid.1");

}else {

    $polldata['TLOGON'] = $lang['allcaps'];
    $polldata['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get($polldata['FROM_UID']);

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
    $polldata['CONTENT'].= "          <td align=\"left\"><h2>". add_wordfilter_tags($polldata['QUESTION']). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td align=\"left\" class=\"postbody\">\n";

    if ($polldata['SHOWRESULTS'] == 1) {

        if ($polldata['POLLTYPE'] == 1) {

            $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);

        }elseif ($polldata['POLLTYPE'] == 0)  {

            $polldata['CONTENT'].= poll_preview_graph_horz($pollresults);

        }else {

            $polldata['CONTENT'].= poll_preview_graph_table($pollresults);
        }

    }else {

        $polldata['CONTENT'].= "            <ul>\n";

        foreach($pollresults['OPTION_NAME'] as $pollquestion) {
            $polldata['CONTENT'].= "          <li>{$pollquestion}</li>\n";
        }

        $polldata['CONTENT'].= "            </ul>\n";
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

    if ($polldata['CHANGEVOTE'] == 1) {
        $polldata['CONTENT'].= $lang['abletochangevote'];
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
    $polldata['CONTENT'].= "<br />\n";

    if (bh_session_get_value('UID') != $polldata['FROM_UID'] && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        edit_refuse($tid, $pid);
        exit;
    }
}

echo sprintf("<h1>{$lang['editmessage']}</h1>\n", $edit_msg);
echo "<br />\n";
echo "<form name=\"f_edit_poll\" action=\"edit_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("t_msg", _htmlentities($edit_msg)), "\n";
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

echo "  <table class=\"posthead\" width=\"785\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['editpoll']}</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "        <table class=\"posthead\" width=\"210\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">\n";
echo "              <h2>{$lang['threadtitle']}</h2>\n";
echo "              ", form_input_text('t_threadtitle', isset($t_threadtitle) ? _htmlentities($t_threadtitle) : _htmlentities($threaddata['TITLE']), 30, 64), "\n";
echo "              <h2>{$lang['pollquestion']}</h2>\n";
echo "              ", form_input_text('question', isset($t_question) ? _htmlentities($t_question) : _htmlentities($polldata['QUESTION']), 30, 64), "\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"posthead\" width=\"210\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">{$lang['editpollwarning']}</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"530\">\n";
echo "        <table class=\"posthead\" width=\"530\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">\n";
echo "              <h2>{$lang['poll']}</h2>\n";
echo "              <div class=\"create_poll_display\">\n";
echo "              <table width=\"100%\" cellpadding=\"2\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['hardedit']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
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

$available_answers = array(5, 10, 15, 20);

if (isset($t_answer_count)) {

    $answer_count = $available_answers[$t_answer_count];
    $answer_selection = $t_answer_count;

}else {

    if (sizeof($pollresults['OPTION_ID']) <= 5) {

        $answer_count = 5;
        $answer_selection = 0;

    }elseif (sizeof($pollresults['OPTION_ID']) > 5 && sizeof($pollresults['OPTION_ID']) <= 10) {

        $answer_count = 10;
        $answer_selection = 1;

    }elseif (sizeof($pollresults['OPTION_ID']) > 10 && sizeof($pollresults['OPTION_ID']) <= 15) {

        $answer_count = 15;
        $answer_selection = 2;

    }elseif (sizeof($pollresults['OPTION_ID']) > 15) {

        $answer_count = 20;
        $answer_selection = 3;
    }
}

echo "                            <tr>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                              <td align=\"left\">{$lang['numberanswers']}: ", form_dropdown_array('answer_count', array('5', '10', '15', '20'), $answer_selection), "&nbsp;", form_submit('change_count', $lang['change']) , "</td>\n";
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
echo "                              <td align=\"left\">Answer Text</td>\n";
echo "                              <td align=\"center\">Answer Group</td>\n";
echo "                              <td align=\"left\">&nbsp;</td>\n";
echo "                            </tr>\n";

if (isset($t_post_html) && $t_post_html == 'Y') {
    $t_post_html = true;
}else {
    $t_post_html = false;
}

for ($i = 0; $i < $answer_count; $i++) {

    echo "                            <tr>\n";
    echo "                              <td align=\"left\">", ($i + 1), ". </td>\n";

    if (isset($t_answers[$i])) {

        echo "                              <td align=\"left\">", form_input_text("answers[$i]", _htmlentities($t_answers[$i]), 40, 255), "</td>\n";

    }else {

        if (isset($pollresults['OPTION_NAME'][$i])) {

            //$pollresults['OPTION_NAME'][$i] = clean_emoticons($pollresults['OPTION_NAME'][$i]);
            $pollresults['OPTION_NAME'][$i] = $pollresults['OPTION_NAME'][$i];

            if (strip_tags($pollresults['OPTION_NAME'][$i]) != $pollresults['OPTION_NAME'][$i]) {

                $t_post_html = true;

                echo "                              <td align=\"left\">", form_input_text("answers[$i]", _htmlentities($pollresults['OPTION_NAME'][$i]), 40, 255), "</td>\n";

            }else {

                echo "                              <td align=\"left\">", form_input_text("answers[$i]", _htmlentities($pollresults['OPTION_NAME'][$i]), 40, 255), "</td>\n";
            }

        }else {

            echo "                              <td align=\"left\">", form_input_text("answers[$i]", '', 40, 255), "</td>\n";
        }
    }

    if (isset($t_answer_groups[$i])) {

        echo "                              <td align=\"center\">", form_dropdown_array("answer_groups[]", range(1, $answer_count), $t_answer_groups[$i]), "</td>\n";

    }else {

        if (isset($pollresults['GROUP_ID'][$i])) {

            echo "                              <td align=\"center\">", form_dropdown_array("answer_groups[]", range(1, $answer_count), $pollresults['GROUP_ID'][$i]), "</td>\n";

        }else {

            echo "                              <td align=\"center\">", form_dropdown_array("answer_groups[]", range(1, $answer_count), 1), "</td>\n";
        }
    }

    echo "                              <td align=\"left\">&nbsp;</td>\n";
    echo "                            </tr>\n";
}

if ($allow_html == true) {

    echo "                            <tr>\n";
    echo "                              <td align=\"left\">&nbsp;</td>\n";
    echo "                              <td align=\"left\">", form_checkbox('t_post_html', 'Y', $lang['answerscontainHTML'], $t_post_html), "</td>\n";
    echo "                            </tr>\n";
}

echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
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
echo "                              <td align=\"left\" width=\"30%\">", form_radio('poll_type', '0', $lang['horizgraph'], isset($t_poll_type) ? $t_poll_type == 0 : $polldata['POLLTYPE'] == 0), "</td>\n";
echo "                              <td align=\"left\" width=\"30%\">", form_radio('poll_type', '1', $lang['vertgraph'], isset($t_poll_type) ? $t_poll_type == 1 : $polldata['POLLTYPE'] == 1), "</td>\n";
echo "                              <td align=\"left\" width=\"30%\">", form_radio('poll_type', '2', $lang['tablegraph'], isset($t_poll_type) ? $t_poll_type == 2 : $polldata['POLLTYPE'] == 2), "</td>\n";
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
echo "                              <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', '0', $lang['pollvoteanon'], isset($t_poll_vote_type) ? $t_poll_vote_type == 0 : $polldata['VOTETYPE'] == 0), "</td>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', '1', $lang['pollvotepub'], isset($t_poll_vote_type) ? $t_poll_vote_type == 1 : $polldata['VOTETYPE'] == 1), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <br />\n";
echo "              <table width=\"100%\" cellpadding=\"2\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['softedit']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table class=\"posthead\" width=\"450\">\n";
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
echo "                              <td align=\"left\" width=\"30%\">", form_radio('option_type', '0', $lang['radios'], isset($t_option_type) ? $t_option_type == 0 : $polldata['OPTIONTYPE'] == 0), "</td>\n";
echo "                              <td align=\"left\" width=\"30%\">", form_radio('option_type', '1', $lang['dropdown'], isset($t_option_type) ? $t_option_type == 1 : $polldata['OPTIONTYPE'] == 1), "</td>\n";
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
echo "                              <td align=\"left\" width=\"25%\">", form_radio('change_vote', '1', $lang['yes'], isset($t_change_vote) ? $t_change_vote == 1 : $polldata['CHANGEVOTE'] == 1), "</td>\n";
echo "                              <td align=\"left\" width=\"25%\">", form_radio('change_vote', '0', $lang['no'], isset($t_change_vote) ? $t_change_vote == 0 : $polldata['CHANGEVOTE'] == 0), "</td>\n";
echo "                              <td align=\"left\">", form_radio('change_vote', '2', $lang['allowmultiplevotes'], isset($t_change_vote) ? $t_change_vote == 2 : $polldata['CHANGEVOTE'] == 2), "</td>\n";
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
    echo "                              <td align=\"left\" width=\"25%\">", form_radio('allow_guests', '1', $lang['yes'], isset($t_allow_guests) ? $t_allow_guests == 1 : $polldata['ALLOWGUESTS'] == 1), "</td>\n";
    echo "                              <td align=\"left\" width=\"25%\">", form_radio('allow_guests', '0', $lang['no'], isset($t_allow_guests) ? $t_allow_guests == 0 : $polldata['ALLOWGUESTS'] == 0), "</td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\"><h2>{$lang['expiration']}</h2></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['showresultswhileopen']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <table border=\"0\" width=\"300\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('show_results', '1', $lang['yes'], isset($t_show_results) ? $t_show_results == 1 : $polldata['SHOWRESULTS'] == 1), "</td>\n";
echo "                              <td align=\"left\" width=\"50%\">", form_radio('show_results', '0', $lang['no'], isset($t_show_results) ? $t_show_results == 0 : $polldata['SHOWRESULTS'] == 0), "</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['changewhenpollcloses']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", form_dropdown_array('close_poll', array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never'], $lang['nochange']), isset($t_close_poll) ? $t_close_poll : 5), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              </div>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"left\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";

echo form_submit("submit", $lang['apply']), "&nbsp;", form_submit("preview_poll", $lang['preview']), "&nbsp;", form_submit("preview_form", $lang['previewvotingform']), "&nbsp;", form_submit("cancel", $lang['cancel']);

if (forum_get_setting('attachments_enabled', 'Y') && bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('{$polldata['FROM_UID']}', '$aid', '$webtag');\"");
    echo form_input_hidden('aid', _htmlentities($aid));
}

echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

if ($valid) {

    echo "<table class=\"posthead\" width=\"785\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"subhead\">{$lang['preview']}</td>\n";
    echo "  </tr>";
    echo "  <tr>\n";
    echo "    <td align=\"left\">\n";

    message_display($tid, $polldata, $threaddata['LENGTH'], $pid, $threaddata['FID'], true, false, false, false, $show_sigs, true);

    echo "    </td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
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