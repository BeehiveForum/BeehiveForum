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

/* $Id: edit_poll.php,v 1.159 2008-03-04 00:13:17 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
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

    $uri = "edit.php?webtag=$webtag";

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

$poll_data    = poll_get($tid);
$poll_results = poll_get_votes($tid);

// Check if the user is viewing signatures.

$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

// Form validation tracking

$valid = true;

// Array to hold error messages

$error_msg_array = array();

// Check for attachment AID

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

}else if (!$aid = get_attachment_id($tid, $pid)) {

    $aid = md5(uniqid(mt_rand()));
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

$allow_html = true;

if (isset($_POST['cancel'])) {

    $uri = "discussion.php?webtag=$webtag&msg=$edit_msg";
    header_redirect($uri);

}elseif (isset($_POST['preview_poll']) || isset($_POST['preview_form']) || isset($_POST['submit'])) {

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {

        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));

    }else {

        $error_msg_array[] = $lang['mustenterthreadtitle'];
        $valid = false;
    }

    if (isset($_POST['question']) && strlen(trim(_stripslashes($_POST['question']))) > 0) {
        $t_question = trim(_stripslashes($_POST['question']));
    }else {
        $t_question = $t_threadtitle;
    }

    if (isset($_POST['answer_count']) && is_numeric($_POST['answer_count'])) {
        $t_answer_count = $_POST['answer_count'];
    }

    if (isset($_POST['answers']) && is_array($_POST['answers'])) {

        $t_answers_array = array_filter(_stripslashes($_POST['answers']), "strlen");

        $poll_answers_valid = true;

        if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {

            foreach($t_answers_array as $key => $t_poll_answer) {

                $t_poll_check_html = new MessageText(POST_HTML_ENABLED, $t_poll_answer);
                $t_answers_array[$key] = $t_poll_check_html->getContent();

                if ($poll_answers_valid == true && strlen(trim($t_answers_array[$key])) < 1) {

                    $t_answers_array[$key] = $t_poll_check_html->getOriginalContent();

                    $error_msg_array[] = $lang['pollquestioncontainsinvalidhtml'];
                    $poll_answers_valid = false;
                    $valid = false;
                }
            }
        }

        if (!isset($t_answers_array[0]) || strlen(trim(_stripslashes($t_answers_array[0]))) == 0) {

            $error_msg_array[] = $lang['mustspecifyvalues1and2'];
            $valid = false;
        }

        if (!isset($t_answers_array[1]) || strlen(trim(_stripslashes($t_answers_array[1]))) == 0) {

            $error_msg_array[] = $lang['mustspecifyvalues1and2'];
            $valid = false;
        }

        foreach($t_answers_array as $t_poll_answer) {

            if (attachment_embed_check($t_poll_answer) && $t_post_html == 'Y') {

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
        $error_msg_array[] = $lang['mustprovidepollchangevotetype'];
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

    if (get_num_attachments($aid) > 0 && !bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

        $error_msg_array[] = $lang['cannotattachfilesinfolder'];
        $valid = false;
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

}else if (isset($_POST['change_count'])) {

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (isset($_POST['t_threadtitle']) && strlen(trim(_stripslashes($_POST['t_threadtitle']))) > 0) {
        $t_threadtitle = trim(_stripslashes($_POST['t_threadtitle']));
    }

    if (isset($_POST['question']) && strlen(trim(_stripslashes($_POST['question']))) > 0) {
        $t_question = trim(_stripslashes($_POST['question']));
    }

    if (isset($_POST['answer_count']) && is_numeric($_POST['answer_count'])) {
        $t_answer_count = $_POST['answer_count'];
    }

    if (isset($_POST['answers']) && is_array($_POST['answers'])) {
        $t_answers_array = array_filter(_stripslashes($_POST['answers']), "strlen");
    }

    if (isset($_POST['answer_groups']) && is_array($_POST['answer_groups'])) {
        $t_answer_groups = array_filter(_stripslashes($_POST['answer_groups']), "is_numeric");
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

html_draw_top("basetarget=_blank", "resize_width=785", "openprofile.js", "post.js", "poll.js");

if (isset($t_fid) && !bh_session_check_perm(USER_PERM_HTML_POSTING, $t_fid)) {
    $allow_html = false;
}

if ($valid && (isset($_POST['preview_poll']) || isset($_POST['preview_form']))) {

    $poll_data['TLOGON'] = $lang['allcaps'];
    $poll_data['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get(bh_session_get_value('UID'));

    $poll_data['FLOGON']   = $preview_tuser['LOGON'];
    $poll_data['FNICK']    = $preview_tuser['NICKNAME'];
    $poll_data['FROM_UID'] = $preview_tuser['UID'];

    $poll_data['CONTENT'] = "<br />\n";
    $poll_data['CONTENT'].= "<div align=\"center\">\n";
    $poll_data['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    $poll_data['CONTENT'].= "  <tr>\n";
    $poll_data['CONTENT'].= "    <td align=\"center\">\n";
    $poll_data['CONTENT'].= "      <table width=\"95%\">\n";
    $poll_data['CONTENT'].= "        <tr>\n";
    $poll_data['CONTENT'].= "          <td align=\"left\"><h2>". (isset($t_question) ? word_filter_add_ob_tags(_htmlentities($t_question)) : word_filter_add_ob_tags(_htmlentities(thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE'])))). "</h2></td>\n";
    $poll_data['CONTENT'].= "        </tr>\n";
    $poll_data['CONTENT'].= "        <tr>\n";
    $poll_data['CONTENT'].= "          <td align=\"left\" class=\"postbody\">\n";

    $poll_results = array();

    $poll_answers_array = array();
    $poll_groups_array  = array();
    $poll_votes_array   = array();

    $max_value   = 0;
    $totalvotes  = 0;
    $optioncount = 0;

    // Poll answers and groups. If HTML is disabled we need to pass
    // the answers through _htmlentities.

    if ($allow_html == false || !isset($t_post_html) || $t_post_html == 'N') {
        $poll_preview_answers_array = _htmlentities($t_answers_array);
    }else {
        $poll_preview_answers_array = $t_answers_array;
    }

    // Get the poll groups.

    $poll_preview_groups_array = $t_answer_groups;

    // Generate some random votes

    $poll_preview_votes_array = rand_array(0, sizeof($t_answers_array), 1, 10);

    // Construct the pollresults array that will be used to display the graph
    // Modified to handle the new Group ID.

    $poll_results = array('OPTION_ID'   => array_keys($poll_preview_answers_array),
                         'OPTION_NAME' => array_values($poll_preview_answers_array),
                         'GROUP_ID'    => array_values($poll_preview_groups_array),
                         'VOTES'       => array_values($poll_preview_votes_array));

    if (isset($_POST['option_type']) && is_numeric($_POST['option_type'])) {
        $pollpreviewdata['OPTIONTYPE'] = $t_option_type;
    }else {
        $pollpreviewdata['OPTIONTYPE'] = 0;
    }

    if (isset($_POST['preview_form'])) {

        $poll_data['CONTENT'].= poll_preview_form($poll_results, $pollpreviewdata);

    }else {

        if ($t_poll_type == POLL_VERTICAL_GRAPH) {
            $poll_data['CONTENT'].= poll_preview_graph_vert($poll_results);
        }elseif ($t_poll_type == POLL_TABLE_GRAPH) {
            $poll_data['CONTENT'].= poll_preview_graph_table($poll_results);
        } else {
            $poll_data['CONTENT'].= poll_preview_graph_horz($poll_results);
        }
    }

    $poll_data['CONTENT'].= "          </td>\n";
    $poll_data['CONTENT'].= "        </tr>\n";
    $poll_data['CONTENT'].= "      </table>\n";
    $poll_data['CONTENT'].= "    </td>\n";
    $poll_data['CONTENT'].= "  </tr>\n";
    $poll_data['CONTENT'].= "  <tr>\n";
    $poll_data['CONTENT'].= "    <td align=\"center\">";
    $poll_data['CONTENT'].= "      <table width=\"95%\">\n";
    $poll_data['CONTENT'].= "        <tr>\n";
    $poll_data['CONTENT'].= "          <td class=\"postbody\" align=\"center\">";

    if ($t_change_vote == POLL_VOTE_CAN_CHANGE) {
        $poll_data['CONTENT'].= "{$lang['abletochangevote']}";
    }else {
        $poll_data['CONTENT'].= "{$lang['notabletochangevote']}";
    }

    $poll_data['CONTENT'].= "          </td>";
    $poll_data['CONTENT'].= "        </tr>\n";
    $poll_data['CONTENT'].= "      </table>\n";
    $poll_data['CONTENT'].= "    </td>";
    $poll_data['CONTENT'].= "  </tr>\n";
    $poll_data['CONTENT'].= "</table>\n";
    $poll_data['CONTENT'].= "</div>\n";
    $poll_data['CONTENT'].= "<p class=\"postbody\" align=\"center\">{$lang['pollvotesrandom']}</p>\n";

    // Attachments preview

    $poll_data['AID'] = $aid;

}elseif ($valid && isset($_POST['submit'])) {

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

        $t_poll_closes = -1;

    }else {

        $t_poll_closes = false;
    }

    // Check HTML tick box, innit.

    $answers = array();

    $t_answers_array_html = POST_HTML_DISABLED;

    if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {
        $t_answers_array_html = POST_HTML_ENABLED;
    }

    foreach($t_answers_array as $key => $poll_answer) {

        $answers[$key] = new MessageText($t_answers_array_html, $poll_answer);
        $t_answers_array[$key] = $answers[$key]->getContent();
    }

    if ($t_poll_type == POLL_TABLE_GRAPH) {

        $t_poll_vote_type = POLL_VOTE_PUBLIC;
    }

    foreach ($t_answers_array as $key => $value) {

        if (!isset($poll_results['OPTION_NAME'][$key])) {

            $poll_results['OPTION_NAME'][$key] = "";
        }
    }

    foreach ($t_answer_groups as $key => $answer_group) {

        if (!isset($poll_results['GROUP_ID'][$key]) && is_numeric($answer_group)) {

            $poll_results['GROUP_ID'][$key] = $answer_group;
        }
    }

    $hard_edit = false;

    if ($t_answers_array != $poll_results['OPTION_NAME'] || $t_answer_groups != $poll_results['GROUP_ID'] || ($poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH && $t_poll_type == POLL_TABLE_GRAPH) || ($t_poll_vote_type == POLL_VOTE_PUBLIC && $poll_data['VOTETYPE'] == POLL_VOTE_ANON)) {

        $hard_edit = true;
    }

    poll_edit($fid, $tid, $t_threadtitle, $t_question, $t_answers_array, $t_answer_groups, $t_poll_closes, $t_change_vote, $t_poll_type, $t_show_results, $t_poll_vote_type, $t_option_type, $t_allow_guests, $hard_edit);

    post_add_edit_text($tid, 1);

    post_save_attachment_id($tid, $pid, $aid);

    header_redirect("discussion.php?webtag=$webtag&msg=$tid.1");

}else {

    $poll_data['TLOGON'] = $lang['allcaps'];
    $poll_data['TNICK'] = $lang['allcaps'];

    $preview_tuser = user_get($poll_data['FROM_UID']);

    $poll_data['FLOGON']   = $preview_tuser['LOGON'];
    $poll_data['FNICK']    = $preview_tuser['NICKNAME'];
    $poll_data['FROM_UID'] = $preview_tuser['UID'];

    $poll_data['CONTENT'] = "<br />\n";
    $poll_data['CONTENT'].= "<div align=\"center\">\n";
    $poll_data['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    $poll_data['CONTENT'].= "  <tr>\n";
    $poll_data['CONTENT'].= "    <td align=\"center\">\n";
    $poll_data['CONTENT'].= "      <table width=\"95%\">\n";
    $poll_data['CONTENT'].= "        <tr>\n";
    $poll_data['CONTENT'].= "          <td align=\"left\"><h2>". word_filter_add_ob_tags(_htmlentities($poll_data['QUESTION'])). "</h2></td>\n";
    $poll_data['CONTENT'].= "        </tr>\n";
    $poll_data['CONTENT'].= "        <tr>\n";
    $poll_data['CONTENT'].= "          <td align=\"left\" class=\"postbody\">\n";

    if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS) {

        if ($poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

            $poll_data['CONTENT'].= poll_preview_graph_vert($poll_results);

        }elseif ($poll_data['POLLTYPE'] == POLL_HORIZONTAL_GRAPH)  {

            $poll_data['CONTENT'].= poll_preview_graph_horz($poll_results);

        }else {

            $poll_data['CONTENT'].= poll_preview_graph_table($poll_results);
        }

    }else {

        $poll_data['CONTENT'].= "            <ul>\n";

        foreach($poll_results['OPTION_NAME'] as $pollquestion) {
            $poll_data['CONTENT'].= "          <li>{$pollquestion}</li>\n";
        }

        $poll_data['CONTENT'].= "            </ul>\n";
    }

    $poll_data['CONTENT'].= "          </td>\n";
    $poll_data['CONTENT'].= "        </tr>\n";
    $poll_data['CONTENT'].= "      </table>\n";
    $poll_data['CONTENT'].= "    </td>\n";
    $poll_data['CONTENT'].= "  </tr>\n";
    $poll_data['CONTENT'].= "  <tr>\n";
    $poll_data['CONTENT'].= "    <td align=\"center\">";
    $poll_data['CONTENT'].= "      <table width=\"95%\">\n";
    $poll_data['CONTENT'].= "        <tr>\n";
    $poll_data['CONTENT'].= "          <td class=\"postbody\" align=\"center\">";

    if ($poll_data['CHANGEVOTE'] == POLL_VOTE_CAN_CHANGE) {
        $poll_data['CONTENT'].= $lang['abletochangevote'];
    }else {
        $poll_data['CONTENT'].= $lang['notabletochangevote'];
    }

    $poll_data['CONTENT'].= "          </td>";
    $poll_data['CONTENT'].= "        </tr>\n";
    $poll_data['CONTENT'].= "      </table>\n";
    $poll_data['CONTENT'].= "    </td>";
    $poll_data['CONTENT'].= "  </tr>\n";
    $poll_data['CONTENT'].= "</table>\n";
    $poll_data['CONTENT'].= "</div>\n";
    $poll_data['CONTENT'].= "<br />\n";

    if (bh_session_get_value('UID') != $poll_data['FROM_UID'] && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        edit_refuse($tid, $pid);
        exit;
    }
}

echo sprintf("<h1>{$lang['editmessage']}</h1>\n", $edit_msg);

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '785', 'left');
}

echo "<br />\n";
echo "<form name=\"f_edit_poll\" action=\"edit_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("t_msg", _htmlentities($edit_msg)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"785\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"785\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['editpoll']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"210\">\n";
echo "                    <table class=\"posthead\" width=\"210\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>{$lang['threadtitle']}</h2>\n";
echo "                          ", form_input_text('t_threadtitle', isset($t_threadtitle) ? _htmlentities($t_threadtitle) : _htmlentities($threaddata['TITLE']), 30, 64, false, "thread_title"), "\n";
echo "                          <h2>{$lang['pollquestion']}</h2>\n";
echo "                          ", form_input_text('question', isset($t_question) ? _htmlentities($t_question) : _htmlentities($poll_data['QUESTION']), 30, 64, false, "thread_title"), "\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                    <br />\n";
echo "                    <table class=\"posthead\" width=\"210\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['editpollwarning']}</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td align=\"left\" valign=\"top\" width=\"530\">\n";
echo "                    <table class=\"posthead\" width=\"530\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>{$lang['poll']}</h2>\n";
echo "                          <div class=\"create_poll_display\">\n";
echo "                          <table width=\"100%\" cellpadding=\"2\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" class=\"subhead\">{$lang['hardedit']}</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                          <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table border=\"0\" class=\"posthead\" width=\"450\">\n";
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
echo "                                      <table border=\"0\" class=\"posthead\" cellpadding=\"0\" cellspacing=\"5\">\n";

$available_answers = array(5, 10, 15, 20);

if (isset($t_answer_count) && is_numeric($t_answer_count)) {

    $answer_count = $available_answers[$t_answer_count];
    $answer_selection = $t_answer_count;

}else {

    if (sizeof($poll_results['OPTION_ID']) <= 5) {

        $answer_count = 5;
        $answer_selection = 0;

    }elseif (sizeof($poll_results['OPTION_ID']) > 5 && sizeof($poll_results['OPTION_ID']) <= 10) {

        $answer_count = 10;
        $answer_selection = 1;

    }elseif (sizeof($poll_results['OPTION_ID']) > 10 && sizeof($poll_results['OPTION_ID']) <= 15) {

        $answer_count = 15;
        $answer_selection = 2;

    }elseif (sizeof($poll_results['OPTION_ID']) > 15) {

        $answer_count = 20;
        $answer_selection = 3;
    }
}

echo "                                        <tr>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                          <td align=\"left\">{$lang['numberanswers']}: ", form_dropdown_array('answer_count', array('5', '10', '15', '20'), _htmlentities($answer_selection)), "&nbsp;", form_submit('change_count', $lang['change']) , "</td>\n";
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
echo "                                          <td align=\"left\">Answer Text</td>\n";
echo "                                          <td align=\"center\">Answer Group</td>\n";
echo "                                          <td align=\"left\">&nbsp;</td>\n";
echo "                                        </tr>\n";

if (isset($t_post_html) && $t_post_html == 'Y') {
    $t_post_html = true;
}else {
    $t_post_html = false;
}

$answer_groups = range(0, $answer_count);
unset($answer_groups[0]);

for ($i = 0; $i < $answer_count; $i++) {

    echo "                                        <tr>\n";
    echo "                                          <td align=\"left\">", ($i + 1), ". </td>\n";

    if (isset($t_answers_array[$i])) {

        echo "                                          <td align=\"left\">", form_input_text("answers[$i]", _htmlentities($t_answers_array[$i]), 40, 255), "</td>\n";

    }else {

        if (isset($poll_results['OPTION_NAME'][$i])) {

            $parsed_poll_option_name = new MessageTextParse($poll_results['OPTION_NAME'][$i], false);

            $t_answer_text = $parsed_poll_option_name->getMessage(); $t_post_html = $parsed_poll_option_name->getMessageHTML();

            echo "                                          <td align=\"left\">", form_input_text("answers[$i]", $t_answer_text, 40, 255), "</td>\n";

        }else {

            echo "                                          <td align=\"left\">", form_input_text("answers[$i]", '', 40, 255), "</td>\n";
        }
    }

    if (isset($t_answer_groups[$i]) && is_numeric($t_answer_groups[$i])) {

        echo "                                          <td align=\"center\">", form_dropdown_array("answer_groups[]", $answer_groups, $t_answer_groups[$i]), "</td>\n";

    }elseif (isset($poll_results['GROUP_ID'][$i]) && is_numeric($poll_results['GROUP_ID'][$i])) {

        echo "                                          <td align=\"center\">", form_dropdown_array("answer_groups[]", $answer_groups, $poll_results['GROUP_ID'][$i]), "</td>\n";

    }else {

        echo "                                          <td align=\"center\">", form_dropdown_array("answer_groups[]", $answer_groups, 1), "</td>\n";
    }

    echo "                                          <td align=\"left\">&nbsp;</td>\n";
    echo "                                        </tr>\n";
}

if ($allow_html == true) {

    echo "                                        <tr>\n";
    echo "                                          <td align=\"left\">&nbsp;</td>\n";
    echo "                                          <td align=\"left\">", form_checkbox('t_post_html', 'Y', $lang['answerscontainHTML'], $t_post_html), "</td>\n";
    echo "                                        </tr>\n";
}

echo "                                      </table>\n";
echo "                                    </td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\"><h2>{$lang['pollresults']}</h2></td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['pollresultsexp']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">\n";
echo "                                      <table border=\"0\" width=\"400\">\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\" width=\"30%\">", form_radio('poll_type', POLL_HORIZONTAL_GRAPH, $lang['horizgraph'], isset($t_poll_type) ? $t_poll_type == POLL_HORIZONTAL_GRAPH : $poll_data['POLLTYPE'] == POLL_HORIZONTAL_GRAPH), "</td>\n";
echo "                                          <td align=\"left\" width=\"30%\">", form_radio('poll_type', POLL_VERTICAL_GRAPH, $lang['vertgraph'], isset($t_poll_type) ? $t_poll_type == POLL_VERTICAL_GRAPH : $poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH), "</td>\n";
echo "                                          <td align=\"left\" width=\"30%\">", form_radio('poll_type', POLL_TABLE_GRAPH, $lang['tablegraph'], isset($t_poll_type) ? $t_poll_type == POLL_TABLE_GRAPH : $poll_data['POLLTYPE'] == POLL_TABLE_GRAPH), "</td>\n";
echo "                                        </tr>\n";
echo "                                      </table>\n";
echo "                                    </td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\"><h2>{$lang['pollvotetype']}</h2></td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['pollvotesexp']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">\n";
echo "                                      <table border=\"0\" width=\"400\">\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_ANON, $lang['pollvoteanon'], isset($t_poll_vote_type) ? $t_poll_vote_type == POLL_VOTE_ANON : $poll_data['VOTETYPE'] == POLL_VOTE_ANON), "</td>\n";
echo "                                          <td align=\"left\" width=\"50%\">", form_radio('poll_vote_type', POLL_VOTE_PUBLIC, $lang['pollvotepub'], isset($t_poll_vote_type) ? $t_poll_vote_type == POLL_VOTE_PUBLIC : $poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC), "</td>\n";
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
echo "                          </table>\n";
echo "                          <br />\n";
echo "                          <table width=\"100%\" cellpadding=\"2\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" class=\"subhead\">{$lang['softedit']}</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                          <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\">\n";
echo "                                <table class=\"posthead\" width=\"450\">\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\"><h2>{$lang['optionsdisplay']}</h2></td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['optionsdisplayexp']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">\n";
echo "                                      <table border=\"0\" width=\"400\">\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_RADIOS, $lang['radios'], isset($t_option_type) ? $t_option_type == POLL_OPTIONS_RADIOS : $poll_data['OPTIONTYPE'] == POLL_OPTIONS_RADIOS), "</td>\n";
echo "                                          <td align=\"left\" width=\"30%\">", form_radio('option_type', POLL_OPTIONS_DROPDOWN, $lang['dropdown'], isset($t_option_type) ? $t_option_type == POLL_OPTIONS_DROPDOWN : $poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN), "</td>\n";
echo "                                        </tr>\n";
echo "                                      </table>\n";
echo "                                    </td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\"><h2>{$lang['votechanging']}</h2></td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['votechangingexp']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">\n";
echo "                                      <table border=\"0\" width=\"400\">\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CAN_CHANGE, $lang['yes'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_CAN_CHANGE : $poll_data['CHANGEVOTE'] == POLL_VOTE_CAN_CHANGE), "</td>\n";
echo "                                          <td align=\"left\" width=\"25%\">", form_radio('change_vote', POLL_VOTE_CANNOT_CHANGE, $lang['no'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_CANNOT_CHANGE : $poll_data['CHANGEVOTE'] == POLL_VOTE_CANNOT_CHANGE), "</td>\n";
echo "                                          <td align=\"left\">", form_radio('change_vote', POLL_VOTE_MULTI, $lang['allowmultiplevotes'], isset($t_change_vote) ? $t_change_vote == POLL_VOTE_MULTI : $poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI), "</td>\n";
echo "                                        </tr>\n";
echo "                                      </table>\n";
echo "                                    </td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";

if (forum_get_setting('poll_allow_guests', false)) {

    echo "                                  <tr>\n";
    echo "                                    <td align=\"left\"><h2>{$lang['guestvoting']}</h2></td>\n";
    echo "                                  </tr>\n";
    echo "                                  <tr>\n";
    echo "                                    <td align=\"left\">{$lang['guestvotingexp']}</td>\n";
    echo "                                  </tr>\n";
    echo "                                  <tr>\n";
    echo "                                    <td align=\"left\">\n";
    echo "                                      <table border=\"0\" width=\"400\">\n";
    echo "                                        <tr>\n";
    echo "                                          <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_ALLOWED, $lang['yes'], isset($t_allow_guests) ? $t_allow_guests == POLL_GUEST_ALLOWED : $poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED), "</td>\n";
    echo "                                          <td align=\"left\" width=\"25%\">", form_radio('allow_guests', POLL_GUEST_DENIED, $lang['no'], isset($t_allow_guests) ? $t_allow_guests == POLL_GUEST_DENIED : $poll_data['ALLOWGUESTS'] == POLL_GUEST_DENIED), "</td>\n";
    echo "                                        </tr>\n";
    echo "                                      </table>\n";
    echo "                                    </td>\n";
    echo "                                  </tr>\n";
    echo "                                  <tr>\n";
    echo "                                    <td align=\"left\">&nbsp;</td>\n";
    echo "                                  </tr>\n";
}

echo "                                  <tr>\n";
echo "                                    <td align=\"left\"><h2>{$lang['expiration']}</h2></td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['showresultswhileopen']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">\n";
echo "                                      <table border=\"0\" width=\"300\">\n";
echo "                                        <tr>\n";
echo "                                          <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_SHOW_RESULTS, $lang['yes'], isset($t_show_results) ? $t_show_results == POLL_SHOW_RESULTS : $poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS), "</td>\n";
echo "                                          <td align=\"left\" width=\"50%\">", form_radio('show_results', POLL_HIDE_RESULTS, $lang['no'], isset($t_show_results) ? $t_show_results == POLL_HIDE_RESULTS : $poll_data['SHOWRESULTS'] == POLL_HIDE_RESULTS), "</td>\n";
echo "                                        </tr>\n";
echo "                                      </table>\n";
echo "                                    </td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">{$lang['changewhenpollcloses']}</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">", form_dropdown_array('close_poll', array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never'], $lang['nochange']), isset($t_close_poll) ? $t_close_poll : 5), "</td>\n";
echo "                                  </tr>\n";
echo "                                  <tr>\n";
echo "                                    <td align=\"left\">&nbsp;</td>\n";
echo "                                  </tr>\n";
echo "                                </table>\n";
echo "                              </td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                          </div>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";

echo form_submit("submit", $lang['apply']), "&nbsp;", form_submit("preview_poll", $lang['preview']), "&nbsp;", form_submit("preview_form", $lang['previewvotingform']), "&nbsp;", form_submit("cancel", $lang['cancel']);

if (forum_get_setting('attachments_enabled', 'Y') && bh_session_check_perm(USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ, $t_fid)) {

    echo "            &nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('{$poll_data['FROM_UID']}', '$aid', '$webtag');\"");
    echo form_input_hidden('aid', _htmlentities($aid));
}

echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";

if ($valid) {

    echo "              <table class=\"posthead\" width=\"785\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['preview']}</td>\n";
    echo "                </tr>";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">\n";

    message_display($tid, $poll_data, $threaddata['LENGTH'], $pid, $threaddata['FID'], true, false, false, false, $show_sigs, true);

    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
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