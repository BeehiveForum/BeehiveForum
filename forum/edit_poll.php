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

/* $Id: edit_poll.php,v 1.81 2004-08-08 20:24:09 tribalonline Exp $ */

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

include_once("./include/edit.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (forum_get_setting('allow_polls', 'N', false)) {
    html_draw_top();
    echo "<h1>{$lang['pollshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($edit_msg) = explode(' ', rawurldecode($_GET['msg']));
    list($tid, $pid) = explode('.', $edit_msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_msg']) && validate_msg($_POST['t_msg'])) {

    list($edit_msg) = explode(' ', rawurldecode($_POST['t_msg']));
    list($tid, $pid) = explode('.', $_POST['t_msg']);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>";
    html_draw_bottom();
    exit;
}

$polldata    = poll_get($tid);
$pollresults = poll_get_votes($tid);

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if (isset($_POST['cancel'])) {

    $uri = "./discussion.php?webtag=$webtag&msg=$edit_msg";
    header_redirect($uri);
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else{
    $aid = md5(uniqid(rand()));
}

if (!perm_check_folder_permissions($t_fid, USER_PERM_POST_EDIT | USER_PERM_POST_READ)) {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannoteditpostsinthisfolder']}</h2>\n";

    html_draw_bottom();
    exit;
}

if (isset($_POST['preview']) || isset($_POST['submit'])) {

    if ($valid && strlen(trim($_POST['answers'][0])) == 0) {
        $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
        $valid = false;
    }

    if ($valid && strlen(trim($_POST['answers'][1])) == 0) {
        $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
        $valid = false;
    }

    if (get_num_attachments($aid) > 0 && !perm_check_folder_permissions($t_fid, USER_PERM_POST_ATTACHMENTS | USER_PERM_POST_READ)) {
        $error_html = "<h2>{$lang['cannotattachfilesinfolder']}</h2>";
        $valid = false;
    }

    if ($valid && $_POST['polltype'] == 2 && sizeof(array_unique($_POST['answer_groups']))  != 2) {
        $error_html = "<h2>{$lang['tablepollmusthave2groups']}</h2>";
        $valid = false;
    }

    if ($valid && $_POST['polltype'] == 2 && $_POST['changevote'] == 2) {
        $error_html = "<h2>{$lang['nomultivotetabulars']}</h2>";
        $valid = false;
    }
}

html_draw_top("basetarget=_blank", "openprofile.js", "post.js");

$allow_html = true;

if (isset($t_fid) && !perm_check_folder_permissions($t_fid, USER_PERM_HTML_POSTING)) {
	$allow_html = false;
}

if ($valid && isset($_POST['preview'])) {

    $polldata['TLOGON'] = "ALL";
    $polldata['TNICK'] = "ALL";

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
    $polldata['CONTENT'].= "          <td><h2>". (isset($_POST['question']) ? _htmlentities(_stripslashes($_POST['question'])) : thread_get_title($tid)). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

    $pollresults = array();

    $poll_answers_array = array();
    $poll_groups_array  = array();
    $poll_votes_array   = array();

    $max_value   = 0;
    $totalvotes  = 0;
    $optioncount = 0;

    $ans_h = 0;

    if ($allow_html == true && isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $ans_h = 2;
    }

    foreach($_POST['answers'] as $key => $answer_text) {

        if (strlen(trim($answer_text)) > 0) {

            $answer_tmp = new MessageText($ans_h, _stripslashes($answer_text));
            $poll_answers_array[$key] = $answer_tmp->getContent();

            srand((double)microtime()*1000000);
            $poll_vote = rand(1, 10);

            if ($poll_vote > $max_value) $max_value = $poll_vote;

            $poll_votes_array[] = $poll_vote;
            $totalvotes += $poll_vote;
            $optioncount++;

        }else {

            unset($_POST['answers'][$key]);
            unset($_POST['answer_groups'][$key]);
        }
    }

    $poll_groups_array = $_POST['answer_groups'];

    // Construct the pollresults array that will be used to display the graph
    // Modified to handle the new Group ID.

    $pollresults = array('OPTION_ID'   => array_keys($poll_answers_array),
                         'OPTION_NAME' => $poll_answers_array,
                         'GROUP_ID'    => $poll_groups_array,
                         'VOTES'       => $poll_votes_array);

    if ($_POST['polltype'] == 1) {

        $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);

    }elseif ($_POST['polltype'] == 0)  {

        $polldata['CONTENT'].= poll_preview_graph_horz($pollresults);

    }else {

        $polldata['CONTENT'].= poll_preview_graph_table($pollresults);
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

    if ($_POST['changevote'] == 1) {
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

    if ($_POST['closepoll'] == 0) {
        $poll_closes = gmmktime() + DAY_IN_SECONDS;
    }elseif ($_POST['closepoll'] == 1) {
        $poll_closes = gmmktime() + (DAY_IN_SECONDS * 3);
    }elseif ($_POST['closepoll'] == 2) {
        $poll_closes = gmmktime() + (DAY_IN_SECONDS * 7);
    }elseif ($_POST['closepoll'] == 3) {
        $poll_closes = gmmktime() + (DAY_IN_SECONDS * 30);
    }elseif ($_POST['closepoll'] == 4) {
        $poll_closes = -1;
    }else {
        $poll_closes = false;
    }

    // Check HTML tick box, innit.

    $answers = array();

    $ans_h = 0;

    if ($allow_html == true && isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
        $ans_h = 2;
    }

    foreach($_POST['answers'] as $key => $poll_answer) {
        $answers[$key] = new MessageText($ans_h, _stripslashes($poll_answer));
        $_POST['answers'][$key] = $answers[$key]->getContent();
    }

    if ($_POST['polltype'] == 2) {
        $_POST['pollvotetype'] = 1;
    }

    foreach ($_POST['answers'] as $key => $value) {
        if (!isset($pollresults['OPTION_NAME'][$key])) {
            $pollresults['OPTION_NAME'][$key] = "";
        }
    }

    foreach ($_POST['answer_groups'] as $key => $value) {
        if (!isset($pollresults['GROUP_ID'][$key])) {
            $pollresults['GROUP_ID'][$key] = $value;
        }
    }

    $hardedit = false;
    if ($_POST['answers'] != $pollresults['OPTION_NAME'] || $_POST['answer_groups'] != $pollresults['GROUP_ID']
       ||  ($polldata['POLLTYPE'] != 2 && $_POST['polltype'] == 2)
       || ($_POST['pollvotetype'] == 1 && $polldata['VOTETYPE'] == 0)) {
        $hardedit = true;
    }

    poll_edit($tid, $_POST['question'], $_POST['answers'], $_POST['answer_groups'], $poll_closes, $_POST['changevote'], $_POST['polltype'], $_POST['showresults'], $_POST['pollvotetype'], $_POST['optiontype'], $hardedit);
    post_add_edit_text($tid, 1);

    if (isset($aid) && forum_get_setting('attachments_enabled', 'Y', false)) {
        if (get_num_attachments($aid) > 0) post_save_attachment_id($tid, $pid, $aid);
    }

    header_redirect("./discussion.php?webtag=$webtag&msg=$tid.1");

}else {

    $polldata['TLOGON'] = "ALL";
    $polldata['TNICK'] = "ALL";

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
    $polldata['CONTENT'].= "          <td><h2>". thread_get_title($tid). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

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
    $polldata['CONTENT'].= "<p>&nbsp;</p>\n";

    if (bh_session_get_value('UID') != $polldata['FROM_UID'] && !perm_is_moderator($t_fid)) {
        edit_refuse($tid, $pid);
        exit;
    }
}

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_edit_poll\" action=\"edit_poll.php\" method=\"POST\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("t_msg", $edit_msg), "\n";
echo "  <p>{$lang['editpollwarning']}</p>\n";
echo "  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td><h2>{$lang['pollquestion']}</h2></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>", form_input_text('question', isset($_POST['question']) ? _htmlentities(_stripslashes($_POST['question'])) : thread_get_title($tid), 30, 64), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <h2>{$lang['hardedit']}</h2>\n";
echo "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table border=\"0\" class=\"posthead\" width=\"500\">\n";
echo "          <tr>\n";
echo "            <td><h2>{$lang['possibleanswers']}</h2></td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table border=\"0\" class=\"posthead\" cellpadding=\"0\" cellspacing=\"0\">\n";

$available_answers = array(5, 10, 15, 20);

if (isset($_POST['answercount'])) {

    $answercount = $available_answers[$_POST['answercount']];
    $answerselection = $_POST['answercount'];

}else {

    if (sizeof($pollresults['OPTION_ID']) <= 5) {

        $answercount = 5;
        $answerselection = 0;

    }elseif (sizeof($pollresults['OPTION_ID']) > 5 && sizeof($pollresults['OPTION_ID']) <= 10) {

        $answercount = 10;
        $answerselection = 1;

    }elseif (sizeof($pollresults['OPTION_ID']) > 10 && sizeof($pollresults['OPTION_ID']) <= 15) {

        $answercount = 15;
        $answerselection = 2;

    }elseif (sizeof($pollresults['OPTION_ID']) > 15) {

        $answercount = 20;
        $answerselection = 3;
    }
}

echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>{$lang['numberanswers']}: ", form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), $answerselection), "&nbsp;", form_submit('changecount', $lang['change']) , "</td>\n";
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

$t_post_html = false;

if (isset($_POST['t_post_html'])) {

    if ($_POST['t_post_html'] == "Y") {

        $t_post_html = true;

    }else {

        $t_post_html = false;
    }
}

for ($i = 0; $i < $answercount; $i++) {

    echo "                <tr>\n";
    echo "                  <td>", ($i + 1), ". </td>\n";
    echo "                  <td>";

    if (isset($_POST['answers'][$i])) {

        echo form_input_text("answers[$i]", _htmlentities(clean_emoticons(_stripslashes($_POST['answers'][$i]))), 40, 255);

    }else {

        if (isset($pollresults['OPTION_NAME'][$i])) {

            $pollresults['OPTION_NAME'][$i] = clean_emoticons($pollresults['OPTION_NAME'][$i]);

            if (strip_tags($pollresults['OPTION_NAME'][$i]) != $pollresults['OPTION_NAME'][$i]) {

                if (!isset($_POST['t_post_html'])) $t_post_html = true;

                echo form_input_text("answers[$i]", _htmlentities($pollresults['OPTION_NAME'][$i]), 40, 255);

            }else {

                echo form_input_text("answers[$i]", $pollresults['OPTION_NAME'][$i], 40, 255);
            }

        }else {

            echo form_input_text("answers[$i]", '', 40, 255);
        }
    }

    echo "  </td>\n";
    echo "  <td align=\"center\">";

    if (isset($_POST['answer_groups'][$i])) {

        echo form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), $_POST['answer_groups'][$i]), "</td>\n";

    }else {

        if (isset($pollresults['GROUP_ID'][$i])) {

            echo form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), $pollresults['GROUP_ID'][$i]), "</td>\n";

        }else {

            echo form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), 1), "</td>\n";
        }
    }

    echo "  <td>&nbsp;</td>\n";
    echo "</tr>\n";
}

if ($allow_html == true) {
	echo "                <tr>\n";
	echo "                  <td>&nbsp;</td>\n";
	echo "                  <td>", form_checkbox('t_post_html', 'Y', $lang['answerscontainHTML'], $t_post_html), "</td>\n";
	echo "                </tr>\n";
}

echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";

if ($polldata['POLLTYPE'] == 0 || $polldata['POLLTYPE'] == 1) {
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
        echo "              <table border=\"0\" width=\"400\">\n";
        echo "                <tr>\n";
        echo "                  <td>", form_radio('polltype', '2', $lang['tablegraph'], isset($_POST['polltype']) ? $_POST['polltype'] == 2 : $polldata['POLLTYPE'] == 2), "</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
}


if ($polldata['VOTETYPE'] == 0) {
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
        echo "                  <td width=\"50%\">", form_radio('pollvotetype', '1', $lang['pollvotepub'], isset($_POST['pollvotetype']) ? $_POST['pollvotetype'] == 1 : $polldata['VOTETYPE'] == 1), "</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
}

echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";



echo "  <h2>{$lang['softedit']}</h2>\n";
echo "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table border=\"0\" class=\"posthead\" width=\"500\">\n";

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
echo "                  <td width=\"30%\">", form_radio('optiontype', '0', $lang['radios'], isset($_POST['optiontype']) ? $_POST['optiontype'] == 0 : $polldata['OPTIONTYPE'] == 0), "</td>\n";
echo "                  <td width=\"30%\">", form_radio('optiontype', '1', $lang['dropdown'], isset($_POST['optiontype']) ? $_POST['optiontype'] == 1 : $polldata['OPTIONTYPE'] == 1), "</td>\n";
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
echo "              <table border=\"0\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td width=\"25%\">", form_radio('changevote', '1', $lang['yes'], isset($_POST['changevote']) ? $_POST['changevote'] == 1 : $polldata['CHANGEVOTE'] == 1), "</td>\n";
echo "                  <td width=\"25%\">", form_radio('changevote', '0', $lang['no'], isset($_POST['changevote']) ? $_POST['changevote'] == 0 : $polldata['CHANGEVOTE'] == 0), "</td>\n";
echo "                  <td>", form_radio('changevote', '2', $lang['allowmultiplevotes'], isset($_POST['changevote']) ? $_POST['changevote'] == 2 : $polldata['CHANGEVOTE'] == 2), "</td>\n";
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
echo "              <table border=\"0\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td width=\"30%\">", form_radio('polltype', '0', $lang['horizgraph'], isset($_POST['polltype']) ? $_POST['polltype'] == 0 : $polldata['POLLTYPE'] == 0), "</td>\n";
echo "                  <td width=\"30%\">", form_radio('polltype', '1', $lang['vertgraph'], isset($_POST['polltype']) ? $_POST['polltype'] == 1 : $polldata['POLLTYPE'] == 1), "</td>\n";
if ($polldata['POLLTYPE'] == 2) {
        echo "                  <td>", form_radio('polltype', '2', $lang['tablegraph'], isset($_POST['polltype']) ? $_POST['polltype'] == 2 : $polldata['POLLTYPE'] == 2), "</td>\n";
}
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
if ($polldata['VOTETYPE'] == 0) {
        echo "                  <td width=\"50%\">", form_radio('pollvotetype', '0', $lang['pollvoteanon'], isset($_POST['pollvotetype']) ? $_POST['pollvotetype'] == 0 : $polldata['VOTETYPE'] == 0), "</td>\n";
} else {
        echo "                  <td width=\"50%\">", form_radio('pollvotetype', '0', $lang['pollvoteanon'], isset($_POST['pollvotetype']) ? $_POST['pollvotetype'] == 0 : $polldata['VOTETYPE'] == 0), "</td>\n";
        echo "                  <td width=\"50%\">", form_radio('pollvotetype', '1', $lang['pollvotepub'], isset($_POST['pollvotetype']) ? $_POST['pollvotetype'] == 1 : $polldata['VOTETYPE'] == 1), "</td>\n";
}
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
echo "              <table border=\"0\" width=\"300\">\n";
echo "                <tr>\n";
echo "                  <td width=\"50%\">", form_radio('showresults', '1', $lang['yes'], isset($_POST['showresults']) ? $_POST['showresults'] == 1 : $polldata['SHOWRESULTS'] == 1), "</td>\n";
echo "                  <td width=\"50%\">", form_radio('showresults', '0', $lang['no'], isset($_POST['showresults']) ? $_POST['showresults'] == 0 : $polldata['SHOWRESULTS'] == 0), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>{$lang['changewhenpollcloses']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>", form_dropdown_array('closepoll', range(0, 5), array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never'], $lang['nochange']), isset($_POST['closepoll']) ? $_POST['closepoll'] : 5), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

echo form_submit("submit", $lang['apply']). "&nbsp;". form_submit("preview", $lang['preview']). "&nbsp;". form_submit("cancel", $lang['cancel']);

if ($aid = get_attachment_id($tid, $pid)) {
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}else {
    $aid = md5(uniqid(rand()));
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid', '$webtag');\"");
    echo form_input_hidden('aid', $aid);
}

echo "</form>\n";

$threaddata = thread_get($tid);

if ($valid) {

    echo "<h2>{$lang['messagepreview']}:</h2>";
    message_display($tid, $polldata, $threaddata['LENGTH'], $pid, true, false, false, false, $show_sigs, true);
}

html_draw_bottom();

?>