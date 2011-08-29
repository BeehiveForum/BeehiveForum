<?php

/* ======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and / or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA    02111 - 1307
USA
======================================================================*/

/* $Id$ */

/**
* Poll related functions
*/

/**
*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function poll_create($tid, $poll_question_array, $poll_closes, $poll_change_vote, $poll_type, $poll_show_results, $poll_vote_type, $poll_option_type, $poll_allow_guests)
{
    if (!$db_poll_create = db_connect()) return false;

    if (!is_array($poll_question_array)) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($poll_change_vote)) return false;
    if (!is_numeric($poll_type)) return false;
    if (!is_numeric($poll_show_results)) return false;
    if (!is_numeric($poll_vote_type)) return false;
    if (!is_numeric($poll_option_type)) return false;
    if (!is_numeric($poll_allow_guests)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $poll_answer_count = 0;

    foreach ($poll_question_array as $poll_question) {

        if (!isset($poll_question['question'])) return false;

        if (!isset($poll_question['answers']) || !is_array($poll_question['answers'])) return false;

        $poll_answers_array = array_filter(array_map('trim', $poll_question['answers']), 'strlen');

        if (sizeof($poll_answers_array) == 0) return false;

        $poll_answer_count+= sizeof($poll_answers_array);
    }

    if (sizeof($poll_answer_count) > 20) return false;

    if (is_numeric($poll_closes) && ($poll_closes > 0)) {

        $poll_closes_datetime = date(MYSQL_DATETIME_MIDNIGHT, $poll_closes);

        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL` (TID, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS, ";
        $sql.= "VOTETYPE, OPTIONTYPE, ALLOWGUESTS) VALUES ('$tid', CAST('$poll_closes_datetime' AS DATETIME), ";
        $sql.= "'$poll_change_vote', '$poll_type', '$poll_show_results', '$poll_vote_type', '$poll_option_type', ";
        $sql.= "'$poll_allow_guests')";

    }else {

        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL` (TID, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS, ";
        $sql.= "VOTETYPE, OPTIONTYPE, ALLOWGUESTS) VALUES ('$tid', NULL, '$poll_change_vote', '$poll_type', ";
        $sql.= "'$poll_show_results', '$poll_vote_type', '$poll_option_type', '$poll_allow_guests')";
    }

    if (!db_query($sql, $db_poll_create)) return false;

    foreach ($poll_question_array as $poll_question) {

        $poll_answers_array = $poll_question['answers'];

        $poll_question = db_escape_string($poll_question['question']);

        $allow_multi = (isset($poll_question['multi']) && ($poll_question['multi'] == 'Y')) ? 'Y' : 'N';

        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_QUESTIONS` (TID, QUESTION, ALLOW_MULTI) ";
        $sql.= "VALUES ('$tid', '$poll_question', '$allow_multi')";

        if (!db_query($sql, $db_poll_create)) return false;

        if (!$poll_question_id = db_insert_id($db_poll_create)) return false;

        $poll_answers_array = array_filter(array_map('trim', $poll_question['answers']), 'strlen');

        foreach ($poll_answers_array as $poll_answer) {

            $poll_answer = db_escape_string($poll_answer);

            $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_VOTES` (TID, QID, OPTION_NAME) ";
            $sql.= "VALUES ('$tid', '$poll_question_id', '$poll_answer')";

            if (!db_query($sql, $db_poll_create)) return false;
        }
    }

    return true;
}

function poll_edit($tid, $poll_question_array, $poll_closes, $poll_change_vote, $poll_type, $poll_show_results, $poll_vote_type, $poll_option_type, $poll_allow_guests, $poll_delete_votes)
{
    if (!$db_poll_edit = db_connect()) return false;

    if (!is_array($poll_question_array)) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($poll_change_vote)) return false;
    if (!is_numeric($poll_type)) return false;
    if (!is_numeric($poll_show_results)) return false;
    if (!is_numeric($poll_vote_type)) return false;
    if (!is_numeric($poll_option_type)) return false;
    if (!is_numeric($poll_allow_guests)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if ($poll_delete_votes) {

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}USER_POLL_VOTES` WHERE TID = '$tid'";
        if (!db_query($sql, $db_poll_edit)) return false;
    }

    if (is_numeric($poll_closes) && ($poll_closes > 0)) {

        $poll_closes_datetime = date(MYSQL_DATETIME_MIDNIGHT, $poll_closes);

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POLL` ";
        $sql.= "SET CHANGEVOTE = '$poll_change_vote', POLLTYPE = '$poll_type', ";
        $sql.= "SHOWRESULTS = '$poll_show_results', VOTETYPE = '$poll_vote_type', ";
        $sql.= "OPTIONTYPE = '$poll_option_type', ALLOWGUESTS = '$poll_allow_guests', ";
        $sql.= "CLOSES = CAST('$poll_closes_datetime' AS DATETIME) WHERE TID = '$tid'";

        if (!db_query($sql, $db_poll_edit)) return false;

    }else {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POLL` ";
        $sql.= "SET CHANGEVOTE = '$poll_change_vote', POLLTYPE = '$poll_type', ";
        $sql.= "SHOWRESULTS = '$poll_show_results', VOTETYPE = '$poll_vote_type', ";
        $sql.= "OPTIONTYPE = '$poll_option_type', ALLOWGUESTS = '$poll_allow_guests' ";
        $sql.= "WHERE TID = '$tid'";

        if (!db_query($sql, $db_poll_edit)) return false;
    }

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}POLL_VOTES` WHERE TID = '$tid'";

    if (!db_query($sql, $db_poll_edit)) return false;

    foreach ($poll_question_array as $poll_question) {

        $poll_answers_array = $poll_question['answers'];

        $poll_question = db_escape_string($poll_question['question']);

        $allow_multi = (isset($poll_question['multi']) && ($poll_question['multi'] == 'Y')) ? 'Y' : 'N';

        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_QUESTIONS` (TID, QUESTION, ALLOW_MULTI) ";
        $sql.= "VALUES ('$tid', '$poll_question', '$allow_multi')";

        if (!db_query($sql, $db_poll_edit)) return false;

        if (!$poll_question_id = db_insert_id($db_poll_edit)) return false;

        $poll_answers_array = array_filter(array_map('trim', $poll_question['answers']), 'strlen');

        foreach ($poll_answers_array as $poll_answer) {

            $poll_answer = db_escape_string($poll_answer);

            $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_VOTES` (TID, QID, OPTION_NAME) ";
            $sql.= "VALUES ('$tid', '$poll_question_id', '$poll_answer')";

            if (!db_query($sql, $db_poll_edit)) return false;
        }
    }

    return true;
}

function poll_get($tid)
{
    if (!$db_poll_get = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST.VIEWED, ";
    $sql.= "POST.MOVED_TID, POST.MOVED_PID, FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, USER_PEER.RELATIONSHIP, ";
    $sql.= "USER_PEER.PEER_NICKNAME AS PFNICK, POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, ";
    $sql.= "POLL.VOTETYPE, POLL.OPTIONTYPE, UNIX_TIMESTAMP(POLL.CLOSES) AS CLOSES, ";
    $sql.= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, ";
    $sql.= "POLL.ALLOWGUESTS, POST.EDITED_BY, POST.APPROVED_BY, POST.IPADDRESS ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN USER FUSER ON (POST.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (POST.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POLL` POLL ON (POST.TID = POLL.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID = 1";

    if (!$result = db_query($sql, $db_poll_get)) return false;

    if (db_num_rows($result) > 0) {

        $poll_data = db_fetch_array($result);

        if (!isset($poll_data['CLOSES'])) {
            $poll_data['CLOSES'] = 0;
        }

        if (!isset($poll_data['CHANGEVOTE'])) {
            $poll_data['CHANGEVOTE'] = 1;
        }

        if (!isset($poll_data['POLLTYPE'])) {
            $poll_data['POLLTYPE'] = 0;
        }

        if (!isset($poll_data['SHOWRESULTS'])) {
            $poll_data['SHOWRESULTS'] = 1;
        }

        if (!isset($poll_data['VOTETYPE'])) {
            $poll_data['VOTETYPE'] = 0;
        }

        if (!isset($poll_data['OPTIONTYPE'])) {
            $poll_data['OPTIONTYPE'] = 0;
        }

        if (isset($poll_data['TLOGON']) && isset($poll_data['PTNICK'])) {
            if (!is_null($poll_data['PTNICK']) && strlen($poll_data['PTNICK']) > 0) {
                $poll_data['TNICK'] = $poll_data['PTNICK'];
            }
        }

        if (isset($poll_data['FLOGON']) && isset($poll_data['PFNICK'])) {
            if (!is_null($poll_data['PFNICK']) && strlen($poll_data['PFNICK']) > 0) {
                $poll_data['FNICK'] = $poll_data['PFNICK'];
            }
        }

        if (!isset($poll_data['FNICK'])) $poll_data['FNICK'] = $lang['unknownuser'];
        if (!isset($poll_data['FLOGON'])) $poll_data['FLOGON'] = $lang['unknownuser'];
        if (!isset($poll_data['FROM_UID'])) $poll_data['FROM_UID'] = -1;

        if (!isset($poll_data['TNICK'])) $poll_data['TNICK'] = $lang['allcaps'];
        if (!isset($poll_data['TLOGON'])) $poll_data['TLOGON'] = $lang['allcaps'];

        return $poll_data;
    }

    return false;
}

function poll_get_votes($tid)
{
    if (!$db_poll_get_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL_QUESTIONS.QUESTION_ID, POLL_QUESTIONS.QUESTION, POLL_QUESTIONS.ALLOW_MULTI, ";
    $sql.= "POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME, COUNT(USER_POLL_VOTES.UID) AS VOTE_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}POLL` POLL INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` ";
    $sql.= "POLL_QUESTIONS ON (POLL_QUESTIONS.TID = POLL.TID) INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` ";
    $sql.= "POLL_VOTES ON (POLL_VOTES.TID = POLL.TID AND POLL_VOTES.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_POLL_VOTES` USER_POLL_VOTES ON (USER_POLL_VOTES.TID = POLL.TID ";
    $sql.= "AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES.OPTION_ID) WHERE POLL.TID = '$tid' ";
    $sql.= "GROUP BY POLL.TID, POLL_QUESTIONS.QUESTION_ID, POLL_VOTES.OPTION_ID";

    if (!$result = db_query($sql, $db_poll_get_votes)) return false;

    $poll_votes_array = array();

    while (($poll_votes_data = db_fetch_array($result))) {

        if (!isset($poll_votes_array[$poll_votes_data['QUESTION_ID']])) {

            $poll_votes_array[$poll_votes_data['QUESTION_ID']] = array(
                'question' => $poll_votes_data['QUESTION'],
                'multi'    => $poll_votes_data['ALLOW_MULTI'],
                'answers'  => array()
            );
        }

        if (!isset($poll_votes_array[$poll_votes_data['QUESTION_ID']]['answers'][$poll_votes_data['OPTION_ID']])) {
            $poll_votes_array[$poll_votes_data['QUESTION_ID']]['answers'][$poll_votes_data['OPTION_ID']] = $poll_votes_data['OPTION_NAME'];
        }
    }

    return $poll_votes_array;
}

function poll_get_total_votes($tid, &$total_votes, &$guest_votes)
{
    if (!$db_poll_get_total_votes = db_connect()) return false;

    if (!is_numeric($tid)) return 0;
    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(DISTINCT UID) FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid' AND UID > 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($total_votes) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid' AND UID = 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($guest_votes) = db_fetch_array($result, DB_RESULT_NUM);

    return true;
}

function poll_get_user_votes($tid)
{
    if (!$poll_get_user_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $lang = load_language_file();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "USER_POLL_VOTES.UID, USER_POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_POLL_VOTES` USER_POLL_VOTES ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ";
    $sql.= "ON (POLL_VOTES.OPTION_ID = USER_POLL_VOTES.OPTION_ID ";
    $sql.= "AND POLL_VOTES.TID = USER_POLL_VOTES.TID) ";
    $sql.= "INNER JOIN USER USER ON (USER.UID = USER_POLL_VOTES.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE USER_POLL_VOTES.TID = '$tid' ";

    if (!$result = db_query($sql, $poll_get_user_votes)) return false;

    $poll_get_user_votes = array();

    while (($user_poll_votes_array = db_fetch_array($result))) {

        if ($user_poll_votes_array['UID'] == 0) {

            $user_poll_votes_array['LOGON']    = $lang['guest'];
            $user_poll_votes_array['NICKNAME'] = $lang['guest'];
        }

        if (!isset($user_poll_votes_array['LOGON'])) $user_poll_votes_array['LOGON'] = $lang['unknownuser'];
        if (!isset($user_poll_votes_array['NICKNAME'])) $user_poll_votes_array['NICKNAME'] = "";

        if (isset($user_poll_votes_array['LOGON']) && isset($user_poll_votes_array['PEER_NICKNAME'])) {
            if (!is_null($user_poll_votes_array['PEER_NICKNAME']) && strlen($user_poll_votes_array['PEER_NICKNAME']) > 0) {
                $user_poll_votes_array['NICKNAME'] = $user_poll_votes_array['PEER_NICKNAME'];
            }
        }

        $poll_user_nicknames[$user_poll_votes_array['OPTION_ID']][] = $user_poll_votes_array['NICKNAME'];
        $poll_get_user_votes[$user_poll_votes_array['OPTION_ID']][] = $user_poll_votes_array;
    }

    foreach (array_keys($poll_get_user_votes) as $option_id) {
        array_multisort($poll_user_nicknames[$option_id], SORT_STRING, SORT_ASC, $poll_get_user_votes[$option_id]);
    }

    return $poll_get_user_votes;
}

function poll_get_user_vote($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$db_poll_get_user_vote = db_connect()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (user_is_guest()) return false;

    $sql = "SELECT POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME ";
    $sql.= "FROM `{$table_data['PREFIX']}POLL` POLL ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ";
    $sql.= "ON (POLL_QUESTIONS.TID = POLL.TID) INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` ";
    $sql.= "POLL_VOTES ON (POLL_VOTES.TID = POLL.TID AND POLL_VOTES.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID) ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}USER_POLL_VOTES` USER_POLL_VOTES ";
    $sql.= "ON (USER_POLL_VOTES.TID = POLL_VOTES.TID AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES.OPTION_ID) ";
    $sql.= "WHERE POLL.TID = '$tid' AND USER_POLL_VOTES.UID = '$uid'";

    if (!$result = db_query($sql, $db_poll_get_user_vote)) return false;

    if (db_num_rows($result) > 0) {

        $user_poll_votes_array = array();

        while (($poll_data = db_fetch_array($result))) {
            $user_poll_votes_array[$poll_data['OPTION_ID']] = $poll_data['OPTION_NAME'];
        }

        return $user_poll_votes_array;
    }

    return false;
}

function poll_display($tid, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    $lang = load_language_file();

    $webtag = get_webtag();

    $poll_data = poll_get($tid);

    $poll_results = poll_get_votes($tid);

    $user_poll_votes_array = poll_get_user_vote($tid);

    if (isset($poll_data['QUESTION']) && strlen(trim($poll_data['QUESTION'])) > 0) {
        $poll_question = $poll_data['QUESTION'];
    } else {
        $poll_question = thread_get_title($tid);
    }

    $total_votes = 0;

    $guest_votes = 0;

    $request_uri = get_request_uri();

    $poll_data['CONTENT'] = "<br />\n";
    $poll_data['CONTENT'].= "<div align=\"center\">\n";
    $poll_data['CONTENT'].= "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"580\">\n";
    $poll_data['CONTENT'].= "  <tr>\n";
    $poll_data['CONTENT'].= "    <td align=\"center\">\n";
    $poll_data['CONTENT'].= "      <form accept-charset=\"utf-8\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
    $poll_data['CONTENT'].= "        ". form_input_hidden("webtag", htmlentities_array($webtag)). "\n";
    $poll_data['CONTENT'].= "        ". form_input_hidden('tid', htmlentities_array($tid)). "\n";
    $poll_data['CONTENT'].= "        <table width=\"560\">\n";

    if (((!is_array($user_poll_votes_array) || $poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) && (session_get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) && ($poll_data['CLOSES'] == 0 || $poll_data['CLOSES'] > time()) && !$is_preview) {

        foreach ($poll_results as $question_id => $poll_question) {

            $poll_data['CONTENT'].= "          <tr>\n";
            $poll_data['CONTENT'].= "            <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['question'])). "</h2></td>\n";
            $poll_data['CONTENT'].= "          </tr>\n";
            $poll_data['CONTENT'].= "          <tr>\n";
            $poll_data['CONTENT'].= "            <td align=\"left\">\n";
            $poll_data['CONTENT'].= "              <table width=\"100%\">\n";

            if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                $poll_data['CONTENT'].= "                <tr>\n";
                $poll_data['CONTENT'].= "                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[$question_id]", $poll_question['answers']). "</td>\n";
                $poll_data['CONTENT'].= "                </tr>\n";

            } else if (sizeof($poll_question['answers']) > 1) {

                foreach ($poll_question['answers'] as $option_id => $option_name) {

                    $poll_data['CONTENT'].= "                <tr>\n";
                    $poll_data['CONTENT'].= "                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option_name), false). "</td>\n";
                    $poll_data['CONTENT'].= "                </tr>\n";
                }

            }else {

                $poll_data['CONTENT'].= "                <tr>\n";
                $poll_data['CONTENT'].= "                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option_name), false). "</td>\n";
                $poll_data['CONTENT'].= "                </tr>\n";
            }

            $poll_data['CONTENT'].= "              </table>\n";
            $poll_data['CONTENT'].= "            </td>\n";
            $poll_data['CONTENT'].= "          </tr>\n";
        }

    } else {

        if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS || ($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] < time())) {

            foreach ($poll_results as $question_id => $poll_question) {

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['question'])). "</h2></td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\">\n";
                $poll_data['CONTENT'].= "              <table width=\"100%\">\n";

                if (($poll_data['POLLTYPE'] == POLL_HORIZONTAL_GRAPH) || ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC)) {

                    $public_ballot = ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC);

                    $poll_data['CONTENT'].= "                <tr>\n";
                    $poll_data['CONTENT'].= "                  <td align=\"left\" colspan=\"2\">horizontal</td>"; //. poll_horizontal_graph($tid, $public_ballot). "</td>\n";
                    $poll_data['CONTENT'].= "                 </tr>\n";

                }else if ($poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

                    $poll_data['CONTENT'].= "                <tr>\n";
                    $poll_data['CONTENT'].= "                  <td align=\"left\" colspan=\"2\">vertical</td>"; //. poll_vertical_graph($tid). "</td>\n";
                    $poll_data['CONTENT'].= "                </tr>\n";

                }else if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

                    $poll_data['CONTENT'].= "                <tr>\n";
                    $poll_data['CONTENT'].= "                  <td align=\"left\" colspan=\"2\">table</td>"; //. poll_table_graph($tid). "</td>\n";
                    $poll_data['CONTENT'].= "                </tr>\n";
                }

                $poll_data['CONTENT'].= "              </table>\n";
                $poll_data['CONTENT'].= "            </td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
            }

        }else {

            foreach ($poll_results as $question_id => $poll_question) {

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['question'])). "</h2></td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\">\n";
                $poll_data['CONTENT'].= "              <table width=\"100%\">\n";

                foreach ($poll_question['answers'] as $option_id => $option_name) {

                    $poll_data['CONTENT'].= "                <tr>\n";
                    $poll_data['CONTENT'].= "                  <td align=\"left\" class=\"postbody\">". word_filter_add_ob_tags($option_name). "</td>\n";
                    $poll_data['CONTENT'].= "                </tr>\n";
                }

                $poll_data['CONTENT'].= "              </table>\n";
                $poll_data['CONTENT'].= "            </td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
            }
        }
    }

    if (!$is_preview) {

        poll_get_total_votes($tid, $total_votes, $guest_votes);

        $poll_data['CONTENT'].= "          <tr>\n";
        $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $poll_data['CONTENT'].= "          </tr>\n";
        $poll_data['CONTENT'].= "          <tr>\n";
        $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". poll_format_vote_counts($poll_data, $total_votes, $guest_votes). "</td>\n";
        $poll_data['CONTENT'].= "          </tr>\n";
        $poll_data['CONTENT'].= "          <tr>\n";
        $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $poll_data['CONTENT'].= "          </tr>\n";

        if (($poll_data['CLOSES'] <= time()) && $poll_data['CLOSES'] != 0) {

            $poll_data['CONTENT'].= "          <tr>\n";
            $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
            $poll_data['CONTENT'].= "          </tr>\n";

            if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_data['CONTENT'].= "          </tr>\n";
                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\"><a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" class=\"button popup 800x600\"><span>{$lang['results']}</span></a></td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_data['CONTENT'].= "          </tr>\n";
            }

            if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {

                if (array_diff($user_poll_votes_array, array_map('strip_tags', $user_poll_votes_array))) {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptions'], sprintf("%s: %s", $lang['options'], implode(' &amp; ', array_keys($user_poll_votes_array)))). "</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";

                } else {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptions'], implode(' &amp; ', array_map('strip_tags', $user_poll_votes_array))). "</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                }
            }

        }else {

            if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {

                if (array_diff($user_poll_votes_array, array_map('strip_tags', $user_poll_votes_array))) {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptions'], sprintf("%s: %s", $lang['options'], implode(' &amp; ', array_keys($user_poll_votes_array)))). "</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";

                } else {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptions'], implode(' &amp; ', array_map('strip_tags', $user_poll_votes_array))). "</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                }

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";

                if ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                }

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">";

                if (session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_data['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']);
                }

                $poll_data['CONTENT'].= "            </td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";

                if ($poll_data['CHANGEVOTE'] != POLL_VOTE_CANNOT_CHANGE) {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                }

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                }

            }else if (session_get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false))) {

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">";

                if (($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_data['CONTENT'].= "<a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" class=\"button popup 800x600\"><span>{$lang['results']}</span></a>";
                }

                if (session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_data['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']);
                }

                $poll_data['CONTENT'].= "            </td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_data['CONTENT'].= "          </tr>\n";

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                    $poll_data['CONTENT'].= "          <tr>\n";
                    $poll_data['CONTENT'].= "            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_data['CONTENT'].= "          </tr>\n";
                }
            }
        }

    } else {

        if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {

            if (array_diff($user_poll_votes_array, array_map('strip_tags', $user_poll_votes_array))) {

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptions'], sprintf("%s: %s", $lang['options'], implode(' &amp; ', array_keys($user_poll_votes_array)))). "</td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";

            } else {

                $poll_data['CONTENT'].= "          <tr>\n";
                $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptions'], implode(' &amp; ', array_map('strip_tags', $user_poll_votes_array))). "</td>\n";
                $poll_data['CONTENT'].= "          </tr>\n";
            }

            $poll_data['CONTENT'].= "          <tr>\n";
            $poll_data['CONTENT'].= "            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
            $poll_data['CONTENT'].= "          </tr>\n";
        }
    }

    $poll_data['CONTENT'].= "        </table>\n";
    $poll_data['CONTENT'].= "      </form>\n";
    $poll_data['CONTENT'].= "    </td>\n";
    $poll_data['CONTENT'].= "  </tr>\n";
    $poll_data['CONTENT'].= "</table>\n";
    $poll_data['CONTENT'].= "</div>\n";
    $poll_data['CONTENT'].= "<br />\n";

    $poll_data['FROM_RELATIONSHIP'] = user_get_relationship(session_get_value('UID'), $poll_data['FROM_UID']);

    message_display($tid, $poll_data, $msg_count, $first_msg, $folder_fid, $in_list, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight_array);
}

function poll_format_vote_counts($poll_data, $user_votes, $guest_votes)
{
    $html = "";

    $lang = load_language_file();

    if ($user_votes == 0) {
        $user_votes_display = $lang['nousersvoted'];
    } else if ($user_votes == 1) {
        $user_votes_display = $lang['oneuservoted'];
    }else {
        $user_votes_display = sprintf($lang['xusersvoted'], $user_votes);
    }

    if ($guest_votes == 0) {
        $guest_votes_display = $lang['noguestsvoted'];
    } else if ($guest_votes == 1) {
        $guest_votes_display = $lang['oneguestvoted'];
    }else {
        $guest_votes_display = sprintf($lang['xguestsvoted'], $guest_votes);
    }

    if (($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] <= time())) {

        if ($user_votes > 0 || $guest_votes > 0) {
            $html.= sprintf("<b>{$lang['votedisplayclosedpoll']}</b>", $user_votes_display, $guest_votes_display);
        }else {
            $html.= $lang['nobodyvotedclosedpoll'];
        }

    } else if ($poll_data['CLOSES'] == 0 || ($poll_data['CLOSES'] > time())) {

        if ($user_votes > 0 || $guest_votes > 0) {
            $html.= sprintf("<b>{$lang['votedisplayopenpoll']}</b>", $user_votes_display, $guest_votes_display);
        }else {
            $html.= $lang['nobodyvotedclosedpoll'];
        }
    }

    return $html;
}

function poll_results_check_data(&$poll_results_array)
{
    if (!isset($poll_results_array['OPTION_ID'])) {
        $poll_results_array['OPTION_ID'] = array();
    }

    if (!isset($poll_results_array['GROUP_ID'])) {
        $poll_results_array['GROUP_ID'] = array();
    }

    if (!isset($poll_results_array['OPTION_NAME'])) {
        $poll_results_array['OPTION_NAME'] = array();
    }

    if (!isset($poll_results_array['VOTES'])) {
        $poll_results_array['VOTES'] = array();
    }

    $poll_results_option_id_keys = array_keys($poll_results_array['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($poll_results_array['GROUP_ID'][$option_key])) {
            $poll_results_array['GROUP_ID'][$option_key] = 1;
        }

        if (!isset($poll_results_array['GROUP_ID'][$option_key])) {
            $poll_results_array['OPTION_NAME'][$option_key] = '';
        }

        if (!isset($poll_results_array['VOTES'][$option_key])) {
            $poll_results_array['VOTES'][$option_key] = 0;
        }
    }
}

function poll_preview_form($poll_results, $poll_data)
{
    poll_results_check_data($poll_results);

    $poll_display = "<div align=\"center\">\n";
    $poll_display.= "  <table width=\"100%\">\n";

    foreach ($poll_results as $question_id => $poll_question) {

        $poll_display.= "    <tr>\n";
        $poll_display.= "      <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['question'])). "</h2></td>\n";
        $poll_display.= "    </tr>\n";
        $poll_display.= "    <tr>\n";
        $poll_display.= "      <td align=\"left\">\n";
        $poll_display.= "        <table width=\"100%\">\n";

        if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

            $poll_display.= "          <tr>\n";
            $poll_display.= "            <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[$question_id]", $poll_question['answers']). "</td>\n";
            $poll_display.= "          </tr>\n";

        } else if (sizeof($poll_question['answers']) > 1) {

            foreach ($poll_question['answers'] as $option_id => $option_name) {

                $poll_display.= "          <tr>\n";
                $poll_display.= "            <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option_name), false). "</td>\n";
                $poll_display.= "          </tr>\n";
            }

        }else {

            $poll_display.= "          <tr>\n";
            $poll_display.= "            <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option_name), false). "</td>\n";
            $poll_display.= "          </tr>\n";
        }

        $poll_display.= "        </table>\n";
        $poll_display.= "      </td>\n";
        $poll_display.= "    </tr>\n";
    }

    $poll_display.= "  </table>\n";
    $poll_display.= "</div>\n";

    return $poll_display;
}

function poll_preview_graph_horz($poll_results)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $bar_color = 1;

    poll_results_check_data($poll_results);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$option_key]])) {
            $max_values[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $max_values[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$option_key]])) {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"100%\">\n";

    $poll_previous_group = false;

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!is_numeric($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            $poll_display.= "                                <tr>\n";
            $poll_display.= "                                  <td align=\"left\" width=\"280\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). "</td>\n";

            if ($poll_results['VOTES'][$option_key] > 0) {

                $poll_display.= "                                  <td align=\"left\" width=\"280\">\n";
                $poll_display.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(280 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]). "px\">\n";
                $poll_display.= "                                      <tr>\n";
                $poll_display.= "                                        <td align=\"left\" class=\"pollbar$bar_color\">&nbsp;</td>\n";
                $poll_display.= "                                      </tr>\n";
                $poll_display.= "                                    </table>\n";
                $poll_display.= "                                  </td>\n";

            }else {

                $poll_display.= "                                  <td align=\"left\" class=\"postbody\" height=\"25\">&nbsp;</td>\n";
            }

            if (isset($total_votes[$poll_results['GROUP_ID'][$option_key]]) && $total_votes[$poll_results['GROUP_ID'][$option_key]] > 0) {
                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$option_key]]) * $poll_results['VOTES'][$option_key], 2);
            }else {
                $vote_percent = 0;
            }

            $poll_display.= "                                </tr>\n";
            $poll_display.= "                                <tr>\n";
            $poll_display.= "                                  <td align=\"left\" width=\"280\" class=\"postbody\">&nbsp;</td>\n";
            $poll_display.= "                                  <td align=\"left\" class=\"postbody\" height=\"20\">". $poll_results['VOTES'][$option_key]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
            $poll_display.= "                                </tr>\n";

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        }

        $bar_color++;

        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_preview_graph_vert($poll_results)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $bar_color = 1;

    poll_results_check_data($poll_results);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$option_key]])) {
            $max_values[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $max_values[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$option_key]])) {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"560\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $poll_display.= "                                <tr>\n";

    $poll_previous_group = false;

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!is_numeric($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['VOTES'][$option_key] > 0) {

                if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {
                    $poll_display.= "                            <td align=\"left\" style=\"width: 2px; border-left: 1px solid #000000\">&nbsp;</td>\n";
                }

                $poll_display.= "                                  <td align=\"center\" valign=\"bottom\">\n";
                $poll_display.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(280 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]). "px; width: ". round(400 / $option_count, 2). "px\">\n";
                $poll_display.= "                                      <tr>\n";
                $poll_display.= "                                        <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $poll_display.= "                                      </tr>\n";
                $poll_display.= "                                    </table>\n";
                $poll_display.= "                                  </td>\n";

            }else {

                $poll_display.= "                                  <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $option_count, 2). "px\">&nbsp;</td>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "                                </tr>\n";
    $poll_display.= "                                <tr>\n";

    unset($poll_previous_group);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if (isset($total_votes[$poll_results['GROUP_ID'][$option_key]]) && $total_votes[$poll_results['GROUP_ID'][$option_key]] > 0) {
                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$option_key]]) * $poll_results['VOTES'][$option_key], 2);
            }else {
                $vote_percent = 0;
            }

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {
                $poll_display.= "                                  <td align=\"left\" style=\"width: 2px; border-left: 1px solid #000000\">&nbsp;</td>\n";
            }

            $poll_display.= "                                  <td class=\"postbody\" align=\"center\" valign=\"top\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). "<br />". $poll_results['VOTES'][$option_key]. " {$lang['votes']}<br />(". $vote_percent. "%)</td>\n";
            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }
    }

    $poll_display.= "                                </tr>\n";
    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_horizontal_graph($tid, $public_ballot = false)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $bar_color = 1;

    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);

    poll_results_check_data($poll_results);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$option_key]])) {
            $max_values[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $max_values[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$option_key]])) {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"100%\">\n";

    $poll_previous_group = false;

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    $user_poll_votes = poll_get_user_votes($tid);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!is_numeric($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {

                $poll_display.= "                              <tr>\n";
                $poll_display.= "                                <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                $poll_display.= "                              </tr>\n";

                $poll_group_count++;
            }

            $poll_display.= "                              <tr>\n";

            $poll_bar_width = 0;

            if ($max_values[$poll_results['GROUP_ID'][$option_key]] > 0) {
                $poll_bar_width = round(100 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key];
            }

            $poll_display.= "                                <td align=\"left\" width=\"500\">\n";
            $poll_display.= "                                  <div class=\"poll_bar poll_bar_$bar_color\">\n";
            $poll_display.= "                                    <div class=\"poll_bar_inner poll_bar_inner_$bar_color\" style=\"width: {$poll_bar_width}%\"></div>\n";
            $poll_display.= "                                  </div>\n";
            $poll_display.= "                                </td>\n";

            if (isset($total_votes[$poll_results['GROUP_ID'][$option_key]]) && $total_votes[$poll_results['GROUP_ID'][$option_key]] > 0) {
                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$option_key]]) * $poll_results['VOTES'][$option_key], 2);
            }else {
                $vote_percent = 0;
            }

            $poll_display.= "                              </tr>\n";

            if ($public_ballot && isset($user_poll_votes[$poll_results['OPTION_ID'][$option_key]]) && is_array($user_poll_votes[$poll_results['OPTION_ID'][$option_key]])) {

                $user_poll_votes_list = implode(', ', array_map('poll_public_ballot_user_callback', $user_poll_votes[$poll_results['OPTION_ID'][$option_key]]));

                $poll_display.= "                              <tr>\n";
                $poll_display.= "                                <td width=\"280\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). ": ". $poll_results['VOTES'][$option_key]. " {$lang['votes']} (". $vote_percent. "%) - {$lang['votes']}:</td>\n";
                $poll_display.= "                              </tr>\n";
                $poll_display.= "                              <tr>\n";
                $poll_display.= "                                <td width=\"280\" class=\"postbody\">". $user_poll_votes_list. "</td>\n";
                $poll_display.= "                              </tr>\n";

            } else {

                $poll_display.= "                              <tr>\n";
                $poll_display.= "                                <td width=\"280\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). ": ". $poll_results['VOTES'][$option_key]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
                $poll_display.= "                              </tr>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_preview_graph_table($poll_results)
{
    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    poll_results_check_data($poll_results);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$option_key]])) {
            $max_values[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $max_values[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$option_key]])) {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $groups = array_unique($poll_results['GROUP_ID']);

    $group_keys = array_keys($groups);

    $group1_keys = array_keys($poll_results['GROUP_ID'], $groups[$group_keys[0]]);
    $group2_keys = array_keys($poll_results['GROUP_ID'], $groups[$group_keys[1]]);

    $group1 = array();

    for ($i = 0; $i < sizeof($group1_keys); $i++) {
        $group1[] = $poll_results['OPTION_ID'][$group1_keys[$i]];
    }

    $group2 = array();

    for ($i = 0; $i < sizeof($group2_keys); $i++) {
        $group2[] = $poll_results['OPTION_ID'][$group2_keys[$i]];
    }

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $table[$rows][$cols] = mt_rand(0, 10);
        }
    }

    $row_count = array();
    $num_votes = 0;

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        $row_count[] = 0;

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $row_count[$rows]+= $table[$rows][$cols];
            $num_votes+= $table[$rows][$cols];
        }
    }

    $col_count = array();

    for ($cols = 0; $cols < sizeof($group2); $cols++) {

        $col_count[] = 0;

        for ($rows = 0; $rows < sizeof($group1); $rows++) {

            $col_count[$cols]+= $table[$rows][$cols];
        }
    }

    $col_width = floor(100 / (sizeof($col_count) + 2));

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"560\" align=\"center\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

    for ($rows = 0; $rows < sizeof($group1) + 2; $rows++) {

        $poll_display.= "                                <tr>\n";

        for ($cols = 0; $cols < sizeof($group2) + 2; $cols++) {

            if ($cols == 0) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $poll_display.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group1_keys[$rows - 1]]). "</th>\n";
                }

            }else if ($cols == sizeof($group2) + 1) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $poll_display.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    if ($num_votes > 0) {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $row_count[$rows - 1]. " (". round($row_count[$rows - 1] * 100 / $num_votes, 2). "%)</th>\n";

                    }else {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $row_count[$rows - 1]. " (0%)</th>\n";
                    }
                }

            }else {

                if ($rows == 0) {

                    $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group2_keys[$cols - 1]]). "</th>\n";

                }else if ($rows == sizeof($group1) + 1) {

                    if ($num_votes > 0) {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $col_count[$cols - 1]. " (". round($col_count[$cols - 1] * 100 / $num_votes, 2). "%)</th>\n";

                    }else {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $col_count[$cols - 1]. " (0%)</th>\n";
                    }

                }else {

                    if ($num_votes > 0) {

                        $poll_display.= "                                  <td align=\"center\" width=\"$col_width%\">". $table[$rows - 1][$cols - 1]. " (". round($table[$rows - 1][$cols - 1] * 100 / $num_votes, 2). "%)</td>\n";

                    }else {

                        $poll_display.= "                                  <td align=\"center\" width=\"$col_width%\">". $table[$rows - 1][$cols - 1]. " (0%)</td>\n";
                    }
                }

            }
        }

        $poll_display.= "                                </tr>\n";
    }

    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_vertical_graph($tid)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $bar_color = 1;

    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);

    poll_results_check_data($poll_results);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$option_key]])) {
            $max_values[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $max_values[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$option_key]])) {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"560\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $poll_display.= "                                <tr>\n";

    $poll_previous_group = false;

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!is_numeric($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {

                $poll_display.= "                                <td align=\"left\" style=\"width: 2px; border-left: 1px solid #000000\">&nbsp;</td>\n";
                $poll_group_count++;
            }

            $poll_bar_height = 0;

            $poll_bar_width = round(400 / $option_count, 2);

            $poll_cell_width = floor(100 / $option_count);

            if ($max_values[$poll_results['GROUP_ID'][$option_key]] > 0) {
                $poll_bar_height = floor(round(200 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]);
            }

            $poll_bar_top = 200 - $poll_bar_height;

            $poll_display.= "                                <td align=\"center\" valign=\"bottom\" width=\"$poll_cell_width%\">\n";
            $poll_display.= "                                  <div class=\"poll_bar poll_bar_$bar_color\" style=\"width: {$poll_bar_width}px; height: 200px\">\n";
            $poll_display.= "                                    <div class=\"poll_bar_inner poll_bar_inner_$bar_color\" style=\"width: {$poll_bar_width}px; height: {$poll_bar_height}px; top: {$poll_bar_top}px; position: relative\"></div>\n";
            $poll_display.= "                                  </div>\n";
            $poll_display.= "                                </td>\n";

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }

        $bar_color++;

        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "                                </tr>\n";
    $poll_display.= "                                <tr>\n";

    unset($poll_previous_group);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {
                $poll_display.= "                                  <td align=\"left\" style=\"width: 2px; border-left: 1px solid #000000\">&nbsp;</td>\n";
            }

            if (isset($total_votes[$poll_results['GROUP_ID'][$option_key]]) && $total_votes[$poll_results['GROUP_ID'][$option_key]] > 0) {

                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$option_key]]) * $poll_results['VOTES'][$option_key], 2);

            }else {

                $vote_percent = 0;
            }

            $poll_display.= "                                  <td class=\"postbody\" align=\"center\" valign=\"top\">". ($poll_results['OPTION_NAME'][$option_key]). "<br />". $poll_results['VOTES'][$option_key]. " {$lang['votes']}<br />(". $vote_percent. "%)</td>\n";
            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }
    }

    $poll_display.= "                                </tr>\n";
    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_get_table_votes($tid)
{
    if (!$db_poll_get_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID, OPTION_ID FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid'";

    if (!$result_votes = db_query($sql, $db_poll_get_votes)) return false;

    $vote_uid    = array();
    $vote_option = array();

    while (($row_votes = db_fetch_array($result_votes))) {

        $vote_uid[]    = $row_votes['UID'];
        $vote_option[] = $row_votes['OPTION_ID'];
    }

    $uid_votes = array('UID'       => $vote_uid,
                       'OPTION_ID' => $vote_option);

    return $uid_votes;
}

function poll_table_graph($tid)
{
    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $poll_results = poll_get_votes($tid);

    $poll_table_results = poll_get_table_votes($tid);

    $poll_results_option_id_keys = array_keys($poll_results['OPTION_ID']);

    foreach ($poll_results_option_id_keys as $option_key) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$option_key]])) {
            $max_values[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $max_values[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$option_key]])) {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] = $poll_results['VOTES'][$option_key];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$option_key]] += $poll_results['VOTES'][$option_key];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $groups = array_unique($poll_results['GROUP_ID']);

    $group_keys = array_keys($groups);

    $group1_keys = array_keys($poll_results['GROUP_ID'], $groups[$group_keys[0]]);
    $group2_keys = array_keys($poll_results['GROUP_ID'], $groups[$group_keys[1]]);

    $group1 = array();

    for ($i = 0; $i < sizeof($group1_keys); $i++) {
        $group1[] = $poll_results['OPTION_ID'][$group1_keys[$i]];
    }

    $group2 = array();

    for ($i = 0; $i < sizeof($group2_keys); $i++) {
        $group2[] = $poll_results['OPTION_ID'][$group2_keys[$i]];
    }

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $table[$rows][$cols] = 0;
        }
    }

    $poll_previous_uid = false;

    for ($i = 0; $i < sizeof($poll_table_results['UID']); $i++) {

        if (!is_numeric($poll_previous_uid) || ($poll_previous_uid != $poll_table_results['UID'][$i])) {

            $uid_keys = array_keys($poll_table_results['UID'], $poll_table_results['UID'][$i]);

            if (count($uid_keys) == 2) {

                if (in_array($poll_table_results['OPTION_ID'][$uid_keys[0]], $group1)) {

                    $vote_group1 = array_search($poll_table_results['OPTION_ID'][$uid_keys[0]], $group1);
                    $vote_group2 = array_search($poll_table_results['OPTION_ID'][$uid_keys[1]], $group2);

                }else {

                    $vote_group1 = array_search($poll_table_results['OPTION_ID'][$uid_keys[1]], $group1);
                    $vote_group2 = array_search($poll_table_results['OPTION_ID'][$uid_keys[0]], $group2);
                }

                $table[$vote_group1][$vote_group2]++;
            }
        }

        $poll_previous_uid = $poll_table_results['UID'][$i];
    }

    unset($poll_previous_uid);

    $row_count = array();
    $num_votes = 0;

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        $row_count[] = 0;

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $row_count[$rows]    += $table[$rows][$cols];
            $num_votes    += $table[$rows][$cols];
        }
    }

    $col_count = array();

    for ($cols = 0; $cols < sizeof($group2); $cols++) {

        $col_count[] = 0;

        for ($rows = 0; $rows < sizeof($group1); $rows++) {

            $col_count[$cols]    += $table[$rows][$cols];
        }
    }

    $col_width = floor(100 / (sizeof($col_count) + 2));

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"560\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

    for ($rows = 0; $rows < sizeof($group1) + 2; $rows++) {

        $poll_display.= "                                <tr>\n";

        for ($cols = 0; $cols < sizeof($group2) + 2; $cols++) {

            if ($cols == 0) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $poll_display.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". ($poll_results['OPTION_NAME'][$group1_keys[$rows - 1]]). "</th>\n";
                }

            }else if ($cols == sizeof($group2) + 1) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $poll_display.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    if ($num_votes > 0) {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $row_count[$rows - 1]. " (". round($row_count[$rows - 1] * 100 / $num_votes, 2). "%)</th>\n";

                    }else {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $row_count[$rows - 1]. " (0%)</th>\n";
                    }
                }

            }else {

                if ($rows == 0) {

                    $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group2_keys[$cols - 1]]). "</th>\n";

                }else if ($rows == sizeof($group1) + 1) {

                    if ($num_votes > 0) {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $col_count[$cols - 1]. " (". round($col_count[$cols - 1] * 100 / $num_votes, 2). "%)</th>\n";

                    }else {

                        $poll_display.= "                                  <th class=\"posthead\" align=\"center\" width=\"$col_width%\">". $col_count[$cols - 1]. " (0%)</th>\n";
                    }

                }else {

                    if ($num_votes > 0) {

                        $poll_display.= "                                  <td align=\"center\" width=\"$col_width%\">". $table[$rows - 1][$cols - 1]. " (". round($table[$rows - 1][$cols - 1] * 100 / $num_votes, 2). "%)</td>\n";

                    }else {

                        $poll_display.= "                                  <td align=\"center\" width=\"$col_width%\">". $table[$rows - 1][$cols - 1]. " (0%)</td>\n";
                    }
                }
            }
        }

        $poll_display.= "                                </tr>\n";
    }

    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_public_ballot_user_callback($user_data)
{
    $webtag = get_webtag();

    if (isset($user_data['UID']) && $user_data['UID'] > 0) {

        $user_profile_link_html = "<a href=\"user_profile.php?webtag=$webtag&amp;uid=%1\$s\" target=\"_blank\" class=\"popup 650x500\" style=\"white-space: nowrap\">%2\$s</a>";
        return sprintf($user_profile_link_html, $user_data['UID'], word_filter_add_ob_tags(htmlentities_array(format_user_name($user_data['LOGON'], $user_data['NICKNAME']))), $webtag);

    }else {

        return $user_data['LOGON'];
    }
}

function poll_confirm_close($tid)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    if (!$preview_message = messages_get($tid, 1, 1)) {

        post_edit_refuse($tid, 1);
        return;
    }

    if (!$threaddata = thread_get($tid)) {

        post_edit_refuse($tid, 1);
        return;
    }

    if (session_get_value('UID') != $preview_message['FROM_UID'] && !session_check_perm(USER_PERM_FOLDER_MODERATE, $threaddata['FID'])) {

        post_edit_refuse($tid, 1);
        return;
    }

    if ($preview_message['TO_UID'] == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

    }else {

        $preview_tuser = user_get($preview_message['TO_UID']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
    }

    $preview_fuser = user_get($preview_message['FROM_UID']);
    $preview_message['FLOGON'] = $preview_fuser['LOGON'];
    $preview_message['FNICK'] = $preview_fuser['NICKNAME'];

    $show_sigs = !(session_get_value('VIEW_SIGS'));

    echo "<h1>{$lang['endpoll']}</h1>\n";

    html_display_warning_msg($lang['pollconfirmclose'], '96%', 'center');

    poll_display($tid, $threaddata['LENGTH'], 1, $threaddata['FID'], false, $threaddata['CLOSED'], false, $show_sigs, true);

    echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_self\">";
    echo form_input_hidden("webtag", htmlentities_array($webtag));
    echo form_input_hidden("tid", htmlentities_array($tid));
    echo form_input_hidden("confirm_pollclose", "Y");
    echo "<p align=\"center\">", form_submit("pollclose", $lang['endpoll']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p>\n";
    echo "</form>\n";
}

function poll_close($tid)
{
    if (!$db_poll_close = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FROM_UID FROM `{$table_data['PREFIX']}POST` WHERE TID = '$tid' AND PID = 1";

    if (!$result = db_query($sql, $db_poll_close)) return false;

    if (($t_fid = thread_get_folder($tid, 1)) && (db_num_rows($result) > 0)) {

        $poll_data = db_fetch_array($result);

        if (session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            $closes_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

            $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}POLL` SET ";
            $sql.= "CLOSES = CAST('$closes_datetime' AS DATETIME) ";
            $sql.= "WHERE TID = '$tid'";

            if (!db_query($sql, $db_poll_close)) return false;
        }
    }

    return true;
}

function poll_is_closed($tid)
{
    if (!$db_poll_is_closed = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM `{$table_data['PREFIX']}POLL` WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_is_closed)) return false;

    if (db_num_rows($result) > 0) {

        $poll_data = db_fetch_array($result);
        if (isset($poll_data['CLOSES']) && $poll_data['CLOSES'] <= time() && $poll_data['CLOSES'] != 0) return true;
    }

    return false;
}

function poll_vote($tid, $vote_array)
{
    if (($uid = session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;
    if (!is_array($vote_array)) return false;

    if (!$db_poll_vote = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $poll_data = poll_get($tid);

    $current_datetime = date(MYSQL_DATETIME, time());

    if ((!poll_get_user_vote($tid)) || ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) || (user_is_guest() && ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) {

        foreach ($vote_array as $user_vote) {

            if (is_numeric($user_vote)) {

                $sql = "INSERT INTO `{$table_data['PREFIX']}USER_POLL_VOTES` (TID, UID, OPTION_ID, TSTAMP) ";
                $sql.= "VALUES ('$tid', '$uid', '$user_vote', CAST('$current_datetime' AS DATETIME))";

                if (!db_query($sql, $db_poll_vote)) return false;
            }
        }
    }

    return true;
}

function poll_delete_vote($tid)
{
    if (!$db_poll_delete_vote = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid' AND UID = '$uid'";

    if (!db_query($sql, $db_poll_delete_vote)) return false;

    return true;
}

function thread_is_poll($tid)
{
    if (!$db_thread_is_poll = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT TID FROM `{$table_data['PREFIX']}POLL` WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_is_poll)) return false;

    return (db_num_rows($result) > 0);
}

function poll_check_tabular_votes($tid, $votes_array)
{
    throw new Exception('Not working yet');

    if (!$db_poll_check_tabular_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!is_array($votes_array)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL.POLLTYPE, MAX(POLL_VOTES.GROUP_ID) AS GROUP_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}POLL` POLL ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ";
    $sql.= "ON (POLL_VOTES.TID = POLL.TID) WHERE POLL.TID = '$tid' GROUP BY POLL.TID";

    if (!$result = db_query($sql, $db_poll_check_tabular_votes)) return false;

    if (db_num_rows($result) > 0) {

        $poll_data = db_fetch_array($result);

        if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            return (sizeof($votes_array) == $poll_data['GROUP_COUNT']);

        }else {
            return true;
        }
    }

    return true;
}

function poll_get_question_html($question_number)
{
    if (!is_numeric($question_number)) return false;

    $lang = load_language_file();

    $html = "<fieldset class=\"poll_question\">\n";
    $html.= "  <div>\n";
    $html.= "    <h2>{$lang['pollquestion']}</h2>\n";
    $html.= "    <div class=\"poll_question_input\">\n";
    $html.= "      ". form_input_text("poll_question[{$question_number}][question]", '', 40, 255). "&nbsp;". form_button_html("delete_question[{$question_number}]", 'submit', 'button_image delete_question', sprintf("<img src=\"%s\" alt=\"\" />", html_style_image('delete.png')), "title=\"{$lang['deletequestion']}\""). "<br />\n";
    $html.= "    </div>\n";
    $html.= "    <div class=\"poll_question_checkbox\">\n";
    $html.= "      ". form_checkbox("poll_question[{$question_number}][multi]", "Y", $lang['allowmultipleanswers'], false). "\n";
    $html.= "    </div>\n";
    $html.= "    <div class=\"poll_answer_list\">\n";
    $html.= "      <ol>\n";
    $html.= "        ". poll_get_answer_html($question_number, 0). "\n";
    $html.= "      </ol>\n";
    $html.= "    </div>\n";
    $html.= "  </div>\n";
    $html.= "  ". form_button_html("add_answer[{$question_number}]", 'submit', 'button_image add_answer', sprintf("<img src=\"%s\" alt=\"\" />&nbsp;%s", html_style_image('add.png'), $lang['addnewanswer'])). "\n";
    $html.= "</fieldset>\n";

    return $html;
}

function poll_get_answer_html($question_number, $answer_number)
{
    if (!is_numeric($question_number)) return false;

    if (!is_numeric($answer_number)) return false;

    $lang = load_language_file();

    return sprintf("<li>%s&nbsp;%s</li>\n", form_input_text("poll_question[{$question_number}][answers][{$answer_number}]", '', 45, 255), form_button_html("delete_answer[{$question_number}][{$answer_number}]", 'submit', 'button_image delete_answer', sprintf("<img src=\"%s\" alt=\"\"/>", html_style_image('delete.png')), "title=\"{$lang['deleteanswer']}\""));
}

?>