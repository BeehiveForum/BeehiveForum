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

/* $Id: create_poll.php,v 1.148 2005-03-20 12:37:33 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
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

// Check to see if the forum owner has allowed the creation of polls

if (forum_get_setting('allow_polls', 'N', false)) {
    html_draw_top();
    echo "<h1>{$lang['pollshavebeendisabled']}</h1>\n";
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
    if ($_POST['t_post_interest'] == "high") {
        $high_interest = true;
    }else {
        $high_interest = false;
    }
}else {
    $high_interest = false;
}

if (isset($_POST['t_message_html'])) {

    $t_message_html = $_POST['t_message_html'];

    if ($t_message_html == "enabled_auto") {
        $post_html = 1;
    }else if ($t_message_html == "enabled") {
        $post_html = 2;
    }else {
        $post_html = 0;
    }

}else {

    if (($page_prefs & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = 1;
    }else if (($page_prefs & POST_HTML_DEFAULT) > 0) {
        $post_html = 2;
    }else {
        $post_html = 0;
    }

    $emots_enabled = !($page_prefs & POST_EMOTICONS_DISABLED);
    $links_enabled = ($page_prefs & POST_AUTO_LINKS);
    $high_interest = bh_session_get_value('MARK_AS_OF_INT');
}

if (isset($_POST['t_sig_html'])) {

    $t_sig_html = $_POST['t_sig_html'];

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }

    $fetched_sig = false;

    if (isset($_POST['t_sig']) && strlen(trim(_stripslashes($_POST['t_sig']))) > 0) {
        $t_sig = trim(_stripslashes($_POST['t_sig']));
    }else {
        $t_sig = "";
    }

}else {

    // Fetch the current user's sig

    user_get_sig($uid, $t_sig, $t_sig_html);

    if ($t_sig_html != "N") {
        $sig_html = 2;
    }

    $t_sig = tidy_html($t_sig, false);

    $fetched_sig = true;
}

if (!isset($_POST['aid'])) {
    $aid = md5(uniqid(rand()));
}else{
    $aid = $_POST['aid'];
}

if (!isset($sig_html)) $sig_html = 0;

if (isset($_POST['cancel'])) {

    $uri = "./discussion.php?webtag=$webtag";
    header_redirect($uri);

}elseif (isset($_POST['preview']) || isset($_POST['submit']) || isset($_POST['change_count'])) {

    $valid = true;

    if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $t_post_html = 'Y';
    }else {
        $t_post_html = 'N';
    }

    if (isset($_POST['question']) && strlen(trim(_stripslashes($_POST['question']))) > 0) {
        $t_question = trim(_stripslashes($_POST['question']));
    }else {
        $error_html = "<h2>{$lang['mustenterpollquestion']}</h2>";
        $valid = false;
    }

    if (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {

        $t_fid = $_POST['t_fid'];

        if (!folder_is_valid($t_fid)) {

            $error_html = "<h2>{$lang['unknownfolder']}</h2>\n";
            $valid = false;
        }

        if (!perm_check_folder_permissions($t_fid, USER_PERM_THREAD_CREATE | USER_PERM_POST_READ)) {

            $error_html = "<h2>{$lang['cannotcreatethreadinfolder']}</h2>\n";
            $valid = false;
        }

        if (get_num_attachments($aid) > 0 && !perm_check_folder_permissions($t_fid, USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ)) {

            $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
            $valid = false;
        }

    }else {

        $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>\n";
        $valid = false;
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

    if (isset($_POST['close_poll']) && is_numeric($_POST['close_poll'])) {
        $t_close_poll = $_POST['close_poll'];
    }else {
        $t_close_poll = false;
    }

    if ($valid && $t_poll_type == 2 && sizeof(array_unique($t_answer_groups)) != 2) {
        $error_html = "<h2>{$lang['tablepollmusthave2groups']}</h2>";
        $valid = false;
    }

    if ($valid && (sizeof(array_unique($t_answer_groups)) >= sizeof($t_answers))) {
        $error_html = "<h2>{$lang['groupcountmustbelessthananswercount']}</h2>";
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

    if (isset($_POST['t_message_text']) && strlen(trim(_stripslashes($_POST['t_message_text']))) > 0) {

        $t_message_text = trim(_stripslashes($_POST['t_message_text']));

        if (attachment_embed_check($t_message_text) && $t_message_html == "Y") {
            $error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
            $valid = false;
        }
    }

    if (isset($t_sig)) {

        if (attachment_embed_check($t_sig) && $t_sig_html == "Y") {
            $error_html = "<h2>{$lang['notallowedembedattachmentpostsignature']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid && !folder_thread_type_allowed($t_fid, FOLDER_ALLOW_POLL_THREAD)) {
        $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
        $valid = false;
    }

}else if (isset($_POST['sig_toggle_x'])) {

    if (isset($_POST['t_message_text']) && strlen(trim(_stripslashes($_POST['t_message_text']))) > 0) {
        $t_message_text = trim(_stripslashes($_POST['t_message_text']));
    }

    if (isset($t_sig)) {
        $t_sig = _htmlentities($t_sig);
    }

    $page_prefs ^= POST_SIGNATURE_DISPLAY;

    user_update_prefs($uid, array('POST_PAGE' => $page_prefs));

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

if (isset($t_fid) && !perm_check_folder_permissions($t_fid, USER_PERM_HTML_POSTING)) {
    $allow_html = false;
}

if (isset($t_fid) && !perm_check_folder_permissions($t_fid, USER_PERM_SIGNATURE)) {
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

            if ($t_close_poll == 0) {

                $t_poll_closes = gmmktime() + DAY_IN_SECONDS;

            }elseif ($t_close_poll == 1) {

                $t_poll_closes = gmmktime() + (DAY_IN_SECONDS * 3);

            }elseif ($t_close_poll == 2) {

                $t_poll_closes = gmmktime() + (DAY_IN_SECONDS * 7);

            }elseif ($t_close_poll == 3) {

                $t_poll_closes = gmmktime() + (DAY_IN_SECONDS * 30);

            }elseif ($t_close_poll == 4) {

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

            // Create the poll thread with the poll_flag set to Y and sticky flag set to N

            $t_tid = post_create_thread($t_fid, $uid, $t_question, 'Y', 'N');
            $t_pid = post_create($t_fid, $t_tid, 0, $uid, $uid, 0, '');

            if ($t_poll_type == 2) {

                $t_poll_vote_type = 1;
            }

            poll_create($t_tid, $t_answers, $t_answer_groups, $t_poll_closes, $t_change_vote, $t_poll_type, $t_show_results, $t_poll_vote_type, $t_option_type);

            if (isset($aid) && forum_get_setting('attachments_enabled', 'Y', false)) {

                if (get_num_attachments($aid) > 0) post_save_attachment_id($t_tid, $t_pid, $aid);
            }

            if (strlen($t_message_text) > 0) {

                if ($allow_sig == true && trim($t_sig) != "") {
                    $t_message_text.= "\n<div class=\"sig\">$t_sig</div>";
                }

                post_create($t_fid, $t_tid, 1, $uid, $uid, 0, $t_message_text);
            }

            if ($high_interest) thread_set_high_interest($t_tid, 1, true);
        }

        if (isset($t_tid) && $t_tid > 0) {
            $uri = "./discussion.php?webtag=$webtag&msg=$t_tid.1";
        }else {
            $uri = "./discussion.php?webtag=$webtag";
        }

        header_redirect($uri);

    }else {

        $error_html = "<h2>{$lang['postfrequencytoogreat_1']} ";
        $error_html.= forum_get_setting('minimum_post_frequency', false, 0);
        $error_html.= " {$lang['postfrequencytoogreat_2']}</h2>\n";
    }
}

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $t_fid = $_GET['fid'];
}else {
    $t_fid = 1;
}

if (!$folder_dropdown = folder_draw_dropdown($t_fid, "t_fid", "" ,FOLDER_ALLOW_POLL_THREAD)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannotcreatenewthreads']}</h2>";
    html_draw_bottom();
    exit;
}

html_draw_top("basetarget=_blank", "onUnload=clearFocus()", "openprofile.js", "post.js", "dictionary.js", "htmltools.js");

echo "<h1>{$lang['createpoll']}</h1>\n";

if ($valid && isset($_POST['preview'])) {

    echo "<h2>{$lang['preview']}:</h2>";

    $polldata['TLOGON'] = "ALL";
    $polldata['TNICK'] = "ALL";

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
    $polldata['CONTENT'].= "          <td><h2>{$t_question}</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

    $pollresults = array();

    $max_value   = 0;
    $totalvotes  = 0;
    $optioncount = 0;

    $ans_h = 0;

    if ($allow_html == true && isset($t_post_html) && $t_post_html == 'Y') {
        $ans_h = 2;
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

    if ($t_poll_type == 1) {
        $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);
    }elseif ($t_poll_type == 2) {
        $polldata['CONTENT'] .= poll_preview_graph_table($pollresults);
    } else {
        $polldata['CONTENT'].= poll_preview_graph_horz($pollresults);
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
        $polldata['CONTENT'].= $lang['abletochangevote'];
    }elseif ($t_change_vote == 2) {
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

    message_display(0, $polldata, 0, 0, false, false, false, true, $show_sigs, true);

    if (strlen($t_message_text) > 0) {

        $polldata['CONTENT'] = $t_message_text;

        if ($allow_sig == true && trim($t_sig) != "") {

            $polldata['CONTENT'].= "<div class=\"sig\">". $t_sig. "</div>";
        }

        message_display(0, $polldata, 0, 0, false, false, false, true, $show_sigs, true);
    }
}

if (isset($error_html)) echo $error_html. "\n";

echo "<form name=\"f_poll\" action=\"create_poll.php\" method=\"post\" target=\"_self\">\n";
echo form_input_hidden('webtag', $webtag), "\n";

if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $_POST['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", gmmktime());
}

echo "  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td><h2>{$lang['selectfolder']}</h2></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>", $folder_dropdown, "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td><h2>{$lang['pollquestion']}</h2></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>", form_input_text('question', isset($t_question) ? _htmlentities($t_question) : '', 30, 64), "&nbsp;", form_submit('submit', $lang['post']), "&nbsp;", form_submit('preview', $lang['preview']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table border=\"0\" class=\"posthead\" width=\"500\">\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['possibleanswers']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['enterpollquestionexp']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" class=\"posthead\" cellpadding=\"0\" cellspacing=\"5\">\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>{$lang['numberanswers']}: ", form_dropdown_array('answer_count', range(0, 3), array('5', '10', '15', '20'), $t_answer_count), "&nbsp;", form_submit('change_count', $lang['change']), "</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>Answer Text</td>\n";
echo "                  <td align=\"center\">Answer Group</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";

$available_answers = array(5, 10, 15, 20);

if (isset($t_answer_count)) {
    $answer_count = $available_answers[$t_answer_count];
}else {
    $answer_count = 5;
}

for ($i = 0; $i < $answer_count; $i++) {

    echo "<tr>\n";
    echo "  <td>", $i + 1, ". </td>\n";
    echo "  <td>", form_input_text("answers[]", isset($t_answers[$i]) ? _htmlentities($t_answers[$i]) : '', 40, 255), "</td>\n";
    echo "  <td align=\"center\">", form_dropdown_array("answer_groups[]", range(1, $answer_count), range(1, $answer_count), (isset($t_answer_groups[$i])) ? $t_answer_groups[$i] : 1), "</td>\n";
    echo "  <td>&nbsp;</td>\n";
    echo "</tr>\n";
}

echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";

if ($allow_html == true) {
        echo "                  <td>", form_checkbox('t_post_html', 'Y', $lang['answerscontainHTML'], (isset($t_post_html) && $t_post_html == 'Y')), "</td>\n";
} else {
        echo "                  <td>", form_input_hidden('t_post_html', 'N'), "</td>\n";
}

echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['optionsdisplay']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['optionsdisplayexp']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td width=\"30%\">", form_radio('option_type', '0', $lang['radios'], isset($t_option_type) ? $t_option_type == 0 : true), "</td>\n";
echo "                  <td width=\"30%\">", form_radio('option_type', '1', $lang['dropdown'], isset($t_option_type) ? $t_option_type == 1 : false), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['votechanging']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['votechangingexp']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" width=\"500\">\n";
echo "                <tr>\n";
echo "                  <td width=\"25%\">", form_radio('change_vote', '1', $lang['yes'], isset($t_change_vote) ? $t_change_vote == 1 : true), "</td>\n";
echo "                  <td width=\"25%\">", form_radio('change_vote', '0', $lang['no'], isset($t_change_vote) ? $t_change_vote == 0 : false), "</td>\n";
echo "                  <td>", form_radio('change_vote', '2', $lang['allowmultiplevotes'], isset($t_change_vote) ? $t_change_vote == 2 : false), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['pollresults']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['pollresultsexp']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" width=\"500\">\n";
echo "                <tr>\n";
echo "                  <td width=\"25%\">", form_radio('poll_type', '0', $lang['horizgraph'], isset($t_poll_type) ? $t_poll_type == 0 : true), "</td>\n";
echo "                  <td width=\"25%\">", form_radio('poll_type', '1', $lang['vertgraph'], isset($t_poll_type) ? $t_poll_type == 1 : false), "</td>\n";
echo "                  <td>", form_radio('poll_type', '2', $lang['tablegraph'], isset($t_poll_type) ? $t_poll_type == 2 : false), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['pollvotetype']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['pollvotesexp']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td width=\"50%\">", form_radio('poll_vote_type', '0', $lang['pollvoteanon'], isset($t_poll_vote_type) ? $t_poll_vote_type == 0 : true), "</td>\n";
echo "                  <td width=\"50%\">", form_radio('poll_vote_type', '1', $lang['pollvotepub'], isset($t_poll_vote_type) ? $t_poll_vote_type == 1 : false), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['expiration']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['showresultswhileopen']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td width=\"50%\">", form_radio('show_results', '1', $lang['yes'], isset($t_show_results) ? $t_show_results == 1 : true), "</td>\n";
echo "                  <td width=\"50%\">", form_radio('show_results', '0', $lang['no'], isset($t_show_results) ? $t_show_results == 0 : false), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['whenlikepollclose']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>", form_dropdown_array('close_poll', range(0, 4), array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never']), isset($t_close_poll) ? $t_close_poll : 4), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><hr /></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['polladditionalmessage']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['polladditionalmessageexp']}</td>\n";
echo "          </tr>\n";

$tools = new TextAreaHTML("f_poll");

$t_message_text = $post->getTidyContent();

if ($allow_html == true && ($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
        echo "          <tr>\n";
        echo "            <td>", $tools->toolbar(), "</td>\n";
        echo "          </tr>\n";
}

echo "          <tr>\n";
echo "            <td>", $tools->textarea('t_message_text', $t_message_text, 15, 75), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";

if ($post->isDiff() && $fix_html) {
    echo $tools->compare_original("t_message_text", $post->getOriginalContent());
}

if ($allow_html == true) {
        echo "<h2>". $lang['htmlinmessage'] .":</h2>\n";

        $tph_radio = $post->getHTML();

        echo form_radio("t_message_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
        echo form_radio("t_message_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
        echo form_radio("t_message_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

        if (($page_prefs & POST_TOOLBAR_DISPLAY) > 0) {
                echo $tools->assign_checkbox("t_message_html[1]", "t_message_html[0]");
        }
        echo "<br /><br />\n";
} else {
        echo form_input_hidden("t_message_html", "disabled");
}

echo "<h2>". $lang['messageoptions'] .":</h2>\n";

echo form_checkbox("t_post_links", "enabled", $lang['automaticallyparseurls'], $links_enabled)."<br />\n";
echo form_checkbox("t_check_spelling", "enabled", $lang['automaticallycheckspelling'], $spelling_enabled)."<br />\n";
echo form_checkbox("t_post_emots", "disabled", $lang['disableemoticonsinmessage'], !$emots_enabled)."<br />\n";
echo form_checkbox("t_post_interest", "high", $lang['setthreadtohighinterest'], $high_interest)."<br />\n";

echo "<br />\n";
echo form_submit("submit", $lang['post'], "onclick=\"return autoCheckSpell('$webtag'); closeAttachWin(); clearFocus()\""), "&nbsp;", form_submit("preview", $lang['preview']), "&nbsp;", form_submit("cancel", $lang['cancel']);

if (forum_get_setting('attachments_enabled', 'Y', false)) {

    echo "&nbsp;".form_button("attachments", $lang['attachments'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
    echo form_input_hidden("aid", $aid);
}

if ($allow_sig == true) {

        echo "<br /><br />\n";
        echo "<table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" class=\"messagefoot\">\n";
        echo "  <tr>\n";
        echo "    <td class=\"subhead\">&nbsp;{$lang['signature']}:</td>\n";

        $t_sig = ($fix_html ? $sig->getTidyContent() : $sig->getOriginalContent());

        if (($page_prefs & POST_SIGNATURE_DISPLAY) > 0) {

            echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('sig_hide.png', 'sig_toggle', 'hide'), "&nbsp;</td>\n";
            echo "  </tr>\n";
            echo "  <tr>\n";
            echo "    <td colspan=\"2\">\n";

            echo $tools->textarea("t_sig", $t_sig, 5, 75, "virtual", "tabindex=\"7\"", "signature_content")."\n";

            if ($sig->isDiff() && $fix_html && !$fetched_sig) {

                echo $tools->compare_original("t_sig", $sig->getOriginalContent());
            }

        }else {

            echo "    <td class=\"subhead\" align=\"right\">", form_submit_image('sig_show.png', 'sig_toggle', 'show'), "&nbsp;</td>\n";
            echo "    ", form_input_hidden("t_sig", $t_sig), "\n";

        }

        echo "  </tr>\n";
        echo "</table>\n";
        echo form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"), "\n";

}

echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";


echo $tools->js(false);


echo "</form>\n";

html_draw_bottom();

?>