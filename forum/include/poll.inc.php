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

    $poll_option_count = 0;

    foreach ($poll_question_array as $poll_question) {

        if (!isset($poll_question['QUESTION'])) return false;

        if (!isset($poll_question['OPTIONS_ARRAY']) || !is_array($poll_question['OPTIONS_ARRAY'])) return false;

        foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {
            if (strlen(trim($option['OPTION_NAME'])) < 1) return false;
        }

        if (sizeof($poll_question['OPTIONS_ARRAY']) < 1) return false;

        $poll_option_count+= sizeof($poll_question['OPTIONS_ARRAY']);
    }

    if (sizeof($poll_option_count) > 20) return false;

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

        $poll_options_array = $poll_question['OPTIONS_ARRAY'];

        $allow_multi = (isset($poll_question['ALLOW_MULTI']) && ($poll_question['ALLOW_MULTI'] == 'Y')) ? 'Y' : 'N';

        $poll_question = db_escape_string($poll_question['QUESTION']);

        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_QUESTIONS` (TID, QUESTION, ALLOW_MULTI) ";
        $sql.= "VALUES ('$tid', '$poll_question', '$allow_multi')";

        if (!db_query($sql, $db_poll_create)) return false;

        if (!$poll_question_id = db_insert_id($db_poll_create)) return false;

        foreach ($poll_options_array as $poll_option) {

            $poll_option = db_escape_string(trim($poll_option['OPTION_NAME']));

            $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_VOTES` (TID, QUESTION_ID, OPTION_NAME) ";
            $sql.= "VALUES ('$tid', '$poll_question_id', '$poll_option')";

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

    $poll_option_count = 0;

    foreach ($poll_question_array as $poll_question) {

        if (!isset($poll_question['QUESTION'])) return false;

        if (!isset($poll_question['OPTIONS_ARRAY']) || !is_array($poll_question['OPTIONS_ARRAY'])) return false;

        foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {
            if (strlen(trim($option['OPTION_NAME'])) < 1) return false;
        }

        if (sizeof($poll_question['OPTIONS_ARRAY']) < 1) return false;

        $poll_option_count+= sizeof($poll_question['OPTIONS_ARRAY']);
    }

    if (sizeof($poll_option_count) > 20) return false;

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

    if ($poll_delete_votes) {

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}USER_POLL_VOTES` WHERE TID = '$tid'";

        if (!db_query($sql, $db_poll_edit)) return false;

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}POLL_QUESTIONS` WHERE TID = '$tid'";

        if (!db_query($sql, $db_poll_edit)) return false;

        $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}POLL_VOTES` WHERE TID = '$tid'";

        if (!db_query($sql, $db_poll_edit)) return false;

        foreach ($poll_question_array as $poll_question) {

            $poll_options_array = $poll_question['OPTIONS_ARRAY'];

            $allow_multi = (isset($poll_question['ALLOW_MULTI']) && ($poll_question['ALLOW_MULTI'] == 'Y')) ? 'Y' : 'N';

            $poll_question = db_escape_string($poll_question['QUESTION']);

            $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_QUESTIONS` (TID, QUESTION, ALLOW_MULTI) ";
            $sql.= "VALUES ('$tid', '$poll_question', '$allow_multi')";

            if (!db_query($sql, $db_poll_edit)) return false;

            if (!$poll_question_id = db_insert_id($db_poll_edit)) return false;

            foreach ($poll_options_array as $poll_option) {

                $poll_option = db_escape_string(trim($poll_option['OPTION_NAME']));

                $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_VOTES` (TID, QUESTION_ID, OPTION_NAME) ";
                $sql.= "VALUES ('$tid', '$poll_question_id', '$poll_option')";

                if (!db_query($sql, $db_poll_edit)) return false;
            }
        }
    }

    return true;
}

function poll_edit_check_questions($tid, $poll_questions_array)
{
    $poll_questions_array = serialize($poll_questions_array);

    $poll_original_questions_array = serialize(poll_get_votes($tid, false));

    return ($poll_original_questions_array != $poll_questions_array);
}

function poll_get_random_users($limit)
{
    if (!$db_poll_get_random_votes = db_connect()) return false;

    if (!is_numeric($limit)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $sql = "SELECT UID, LOGON, NICKNAME, PEER_NICKNAME FROM (SELECT USER.UID, USER.LOGON, ";
    $sql.= "USER.NICKNAME, USER_PEER.PEER_NICKNAME, VISITOR_LOG.LAST_LOGON, (SELECT COUNT(*) ";
    $sql.= "FROM VISITOR_LOG WHERE FORUM = 1) AS VISITOR_COUNT FROM USER LEFT JOIN VISITOR_LOG ";
    $sql.= "VISITOR_LOG ON (VISITOR_LOG.UID = USER.UID AND VISITOR_LOG.FORUM = '{$table_data['FID']}') ";
    $sql.= "LEFT JOIN DEFAULT_USER_PEER USER_PEER ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "HAVING VISITOR_COUNT = 0 OR VISITOR_LOG.LAST_LOGON > DATE_SUB(NOW(), INTERVAL 14 DAY) ";
    $sql.= "ORDER BY RAND() LIMIT $limit) AS RANDOM_USERS";

    if (!$result = db_query($sql, $db_poll_get_random_votes)) return false;

    $poll_get_random_votes = array();

    while (($poll_random_vote_data = db_fetch_array($result, DB_RESULT_ASSOC))) {

        if (isset($poll_random_vote_data['PEER_NICKNAME'])) {
            if (!is_null($poll_random_vote_data['PEER_NICKNAME']) && strlen(trim($poll_random_vote_data['PEER_NICKNAME'])) > 0) {
                $poll_random_vote_data['NICKNAME'] = $poll_random_vote_data['PEER_NICKNAME'];
            }
        }

        unset($poll_random_vote_data['PEER_NICKNAME']);

        $poll_get_random_votes[] = $poll_random_vote_data;
    }

    return $poll_get_random_votes;
}

function poll_get($tid)
{
    if (!$db_poll_get = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    $sql = "SELECT POST.TID, POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, ";
    $sql.= "POST.TO_UID, UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST.VIEWED, ";
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

function poll_get_votes($tid, $include_votes = true)
{
    if (!$db_poll_get_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL_QUESTIONS.QUESTION_ID, POLL_QUESTIONS.QUESTION, ";
    $sql.= "POLL_QUESTIONS.ALLOW_MULTI, POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME, ";
    $sql.= "USER_POLL_VOTES.UID FROM `{$table_data['PREFIX']}POLL` POLL ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ON (POLL_QUESTIONS.TID = POLL.TID) ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ON (POLL_VOTES.TID = POLL.TID AND ";
    $sql.= "POLL_VOTES.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID) LEFT JOIN `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "USER_POLL_VOTES ON (USER_POLL_VOTES.TID = POLL.TID AND USER_POLL_VOTES.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID AND ";
    $sql.= "USER_POLL_VOTES.OPTION_ID = POLL_VOTES.OPTION_ID) WHERE POLL.TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_get_votes)) return false;

    $poll_votes_array = array();

    while (($poll_votes_data = db_fetch_array($result))) {

        if (!isset($poll_votes_array[$poll_votes_data['QUESTION_ID']])) {

            $poll_votes_array[$poll_votes_data['QUESTION_ID']] = array(
                'QUESTION_ID'   => $poll_votes_data['QUESTION_ID'],
                'QUESTION'      => $poll_votes_data['QUESTION'],
                'ALLOW_MULTI'   => $poll_votes_data['ALLOW_MULTI'],
                'OPTIONS_ARRAY' => array()
            );
        }

        if (!isset($poll_votes_array[$poll_votes_data['QUESTION_ID']]['OPTIONS_ARRAY'][$poll_votes_data['OPTION_ID']])) {

            $poll_votes_array[$poll_votes_data['QUESTION_ID']]['OPTIONS_ARRAY'][$poll_votes_data['OPTION_ID']] = array(
                'OPTION_ID'   => $poll_votes_data['OPTION_ID'],
                'OPTION_NAME' => $poll_votes_data['OPTION_NAME'],
            );
        }

        if ($include_votes === true) {

            if (!isset($poll_votes_array[$poll_votes_data['QUESTION_ID']]['OPTIONS_ARRAY'][$poll_votes_data['OPTION_ID']]['VOTES_ARRAY'])) {
                $poll_votes_array[$poll_votes_data['QUESTION_ID']]['OPTIONS_ARRAY'][$poll_votes_data['OPTION_ID']]['VOTES_ARRAY'] = array();
            }

            if (isset($poll_votes_data['UID']) && is_numeric($poll_votes_data['UID'])) {
                $poll_votes_array[$poll_votes_data['QUESTION_ID']]['OPTIONS_ARRAY'][$poll_votes_data['OPTION_ID']]['VOTES_ARRAY'][] = $poll_votes_data['UID'];
            }
        }
    }

    return $poll_votes_array;
}

function poll_get_total_votes($tid, &$total_votes, &$user_votes, &$guest_votes)
{
    if (!$db_poll_get_total_votes = db_connect()) return false;

    if (!is_numeric($tid)) return 0;
    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_VOTES ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid' AND UID > 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($user_votes) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS GUEST_VOTES ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid' AND UID = 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($guest_votes) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(DISTINCT UID, VOTED) AS TOTAL_VOTES ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_POLL_VOTES` ";
    $sql.= "WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($total_votes) = db_fetch_array($result, DB_RESULT_NUM);

    return true;
}

function poll_get_user_votes($tid)
{
    if (!is_numeric($tid)) return false;

    if (!$db_poll_get_user_votes = db_connect()) return false;

    if (($uid = session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (user_is_guest()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(USER_POLL_VOTES.VOTED) AS VOTED, POLL_QUESTIONS.QUESTION_ID, ";
    $sql.= "POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME FROM `{$table_data['PREFIX']}POLL` POLL  ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ON (POLL_QUESTIONS.TID = POLL.TID)  ";
    $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ON (POLL_VOTES.TID = POLL.TID  ";
    $sql.= "AND POLL_VOTES.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID) INNER JOIN `{$table_data['PREFIX']}USER_POLL_VOTES`  ";
    $sql.= "USER_POLL_VOTES ON (USER_POLL_VOTES.TID = POLL_VOTES.TID AND USER_POLL_VOTES.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID  ";
    $sql.= "AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES.OPTION_ID) WHERE POLL.TID = '$tid' AND USER_POLL_VOTES.UID = '$uid'  ";
    $sql.= "ORDER BY USER_POLL_VOTES.VOTED";

    if (!$result = db_query($sql, $db_poll_get_user_votes)) return false;

    if (db_num_rows($result) > 0) {

        $user_poll_votes_array = array();

        while (($poll_data = db_fetch_array($result))) {

            if (!isset($user_poll_votes_array['VOTED'])) {
                $user_poll_votes_array['VOTED'] = $poll_data['VOTED'];
            }

            if (!isset($user_poll_votes_array['VOTES'])) {
                $user_poll_votes_array['VOTES'] = array();
            }

            $user_poll_votes_array['VOTES'][$poll_data['QUESTION_ID']. $poll_data['OPTION_ID']] = $poll_data['OPTION_NAME'];
        }

        return $user_poll_votes_array;
    }

    return false;
}

function poll_display($tid, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $show_sigs = true, $is_preview = false, $highlight_array = array())
{
    $lang = load_language_file();

    $webtag = get_webtag();

    $total_votes = 0;

    $user_votes = 0;

    $guest_votes = 0;

    $poll_data = poll_get($tid);

    $poll_results = poll_get_votes($tid);

    $user_poll_votes_array = poll_get_user_votes($tid);

    poll_get_total_votes($tid, $total_votes, $user_votes, $guest_votes);

    $request_uri = get_request_uri();

    $poll_display = "<br />\n";
    $poll_display.= "<div align=\"center\">\n";
    $poll_display.= "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"580\">\n";
    $poll_display.= "    <tr>\n";
    $poll_display.= "      <td align=\"center\">\n";
    $poll_display.= "        <form accept-charset=\"utf-8\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
    $poll_display.= "          ". form_input_hidden("webtag", htmlentities_array($webtag)). "\n";
    $poll_display.= "          ". form_input_hidden('tid', htmlentities_array($tid)). "\n";
    $poll_display.= "          <table width=\"560\">\n";

    if (((!is_array($user_poll_votes_array) || $poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) && (session_get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) && ($poll_data['CLOSES'] == 0 || $poll_data['CLOSES'] > time()) && !$is_preview) {

        foreach ($poll_results as $question_id => $poll_question) {

            $poll_display.= "          <tr>\n";
            $poll_display.= "            <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['QUESTION'])). "</h2></td>\n";
            $poll_display.= "          </tr>\n";
            $poll_display.= "          <tr>\n";
            $poll_display.= "            <td align=\"left\">\n";
            $poll_display.= "              <table width=\"100%\">\n";

            if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                $dropdown_options_array = array_map('poll_dropdown_options_callback', $poll_question['OPTIONS_ARRAY']);

                $poll_display.= "                <tr>\n";
                $poll_display.= "                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[$question_id]", $dropdown_options_array). "</td>\n";
                $poll_display.= "                </tr>\n";

            } else {

                foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {

                    if ((sizeof($poll_question['OPTIONS_ARRAY']) == 1) || ($poll_question['ALLOW_MULTI'] == 'Y')) {

                        $poll_display.= "                <tr>\n";
                        $poll_display.= "                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[$question_id][$option_id]", 'Y', word_filter_add_ob_tags($option['OPTION_NAME']), false). "</td>\n";
                        $poll_display.= "                </tr>\n";

                    } else {

                        $poll_display.= "                <tr>\n";
                        $poll_display.= "                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option['OPTION_NAME']), false). "</td>\n";
                        $poll_display.= "                </tr>\n";
                    }
                }
            }

            $poll_display.= "              </table>\n";
            $poll_display.= "            </td>\n";
            $poll_display.= "          </tr>\n";
        }

    } else {

        if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS || ($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] < time())) {

            if (($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) && ($poll_data['VOTETYPE'] != POLL_VOTE_PUBLIC)) {

                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td align=\"left\" colspan=\"2\">". poll_table_graph($poll_results, $poll_data, $total_votes). "</td>\n";
                $poll_display.= "             </tr>\n";

            } else {

                foreach ($poll_results as $question_id => $poll_question) {

                    $poll_display.= "           <tr>\n";
                    $poll_display.= "               <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['QUESTION'])). "</h2></td>\n";
                    $poll_display.= "            </tr>\n";
                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td align=\"left\">\n";
                    $poll_display.= "                <table width=\"100%\">\n";

                    if (($poll_data['POLLTYPE'] == POLL_HORIZONTAL_GRAPH) || ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC)) {

                        $poll_display.= "                  <tr>\n";
                        $poll_display.= "                    <td align=\"left\" colspan=\"2\">". poll_horizontal_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_votes). "</td>\n";
                        $poll_display.= "                   </tr>\n";

                    } else {

                        $poll_display.= "                  <tr>\n";
                        $poll_display.= "                    <td align=\"left\" colspan=\"2\">". poll_vertical_graph($poll_question['OPTIONS_ARRAY'], $poll_data, $total_votes). "</td>\n";
                        $poll_display.= "                  </tr>\n";
                    }

                    $poll_display.= "                </table>\n";
                    $poll_display.= "              </td>\n";
                    $poll_display.= "            </tr>\n";
                }
            }

        }else {

            foreach ($poll_results as $question_id => $poll_question) {

                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['QUESTION'])). "</h2></td>\n";
                $poll_display.= "            </tr>\n";
                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td align=\"left\">\n";
                $poll_display.= "                <table width=\"100%\">\n";

                foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {

                    $poll_display.= "                  <tr>\n";
                    $poll_display.= "                    <td align=\"left\" class=\"postbody\">". word_filter_add_ob_tags($option['OPTION_NAME']). "</td>\n";
                    $poll_display.= "                  </tr>\n";
                }

                $poll_display.= "                </table>\n";
                $poll_display.= "              </td>\n";
                $poll_display.= "            </tr>\n";
            }
        }
    }

    if (!$is_preview) {

        $poll_display.= "            <tr>\n";
        $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $poll_display.= "            </tr>\n";
        $poll_display.= "            <tr>\n";
        $poll_display.= "              <td align=\"left\" colspan=\"2\" class=\"postbody\">". poll_format_vote_counts($poll_data, $user_votes, $guest_votes). "</td>\n";
        $poll_display.= "            </tr>\n";
        $poll_display.= "            <tr>\n";
        $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $poll_display.= "            </tr>\n";

        if (($poll_data['CLOSES'] <= time()) && $poll_data['CLOSES'] != 0) {

            $poll_display.= "            <tr>\n";
            $poll_display.= "              <td align=\"left\" colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
            $poll_display.= "            </tr>\n";

            if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_display.= "            </tr>\n";
                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td colspan=\"2\" align=\"center\"><a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" class=\"button popup 800x600\"><span>{$lang['results']}</span></a></td>\n";
                $poll_display.= "            </tr>\n";
                $poll_display.= "            <tr>\n";
                $poll_display.= "             <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_display.= "             </tr>\n";
            }

            if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {
                $poll_display.= poll_display_user_votes($user_poll_votes_array);
            }

        }else {

            if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {

                $poll_display.= poll_display_user_votes($user_poll_votes_array);

                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
                $poll_display.= "            </tr>\n";

                if ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) {

                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                    $poll_display.= "            </tr>\n";
                }

                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td colspan=\"2\" align=\"center\">";

                if (($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_display.= "<a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" class=\"button popup 800x600\"><span>{$lang['results']}</span></a>";
                }

                if (session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_display.= "&nbsp;<a href=\"close_poll.php?webtag=$webtag&msg=$tid.1\" class=\"button\" target=\"_parent\">{$lang['endpoll']}</a>";
                }

                $poll_display.= "              </td>\n";
                $poll_display.= "            </tr>\n";

                if ($poll_data['CHANGEVOTE'] != POLL_VOTE_CANNOT_CHANGE) {

                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
                    $poll_display.= "            </tr>\n";
                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_display.= "            </tr>\n";
                }

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $poll_display.= "            </tr>\n";
                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_display.= "            </tr>\n";
                }

            } else if (session_get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false))) {

                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                $poll_display.= "            </tr>\n";
                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td colspan=\"2\" align=\"center\">";

                if (($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_display.= "<a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" class=\"button popup 800x600\"><span>{$lang['results']}</span></a>";
                }

                if (session_get_value('UID') == $poll_data['FROM_UID'] || session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
                    $poll_display.= "&nbsp;<a href=\"close_poll.php?webtag=$webtag&msg=$tid.1\" class=\"button\" target=\"_parent\">{$lang['endpoll']}</a>";
                }

                $poll_display.= "              </td>\n";
                $poll_display.= "            </tr>\n";
                $poll_display.= "            <tr>\n";
                $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_display.= "            </tr>\n";

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $poll_display.= "            </tr>\n";
                    $poll_display.= "            <tr>\n";
                    $poll_display.= "              <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_display.= "            </tr>\n";
                }
            }
        }

    } else {

        if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {

            $poll_display.= "            <tr>\n";
            $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
            $poll_display.= "            </tr>\n";
            $poll_display.= "            <tr>\n";
            $poll_display.= "              <td align=\"left\" colspan=\"2\" class=\"postbody\">". poll_format_vote_counts($poll_data, $user_votes, $guest_votes). "</td>\n";
            $poll_display.= "            </tr>\n";
            $poll_display.= "            <tr>\n";
            $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
            $poll_display.= "            </tr>\n";

            $poll_display.= poll_display_user_votes($user_poll_votes_array);

            $poll_display.= "            <tr>\n";
            $poll_display.= "              <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
            $poll_display.= "            </tr>\n";
        }
    }

    $poll_display.= "          </table>\n";
    $poll_display.= "        </form>\n";
    $poll_display.= "      </td>\n";
    $poll_display.= "    </tr>\n";
    $poll_display.= "  </table>\n";
    $poll_display.= "</div>\n";
    $poll_display.= "<br />\n";

    $poll_data['CONTENT'] = $poll_display;

    $poll_data['FROM_RELATIONSHIP'] = user_get_relationship(session_get_value('UID'), $poll_data['FROM_UID']);

    message_display($tid, $poll_data, $msg_count, $first_msg, $folder_fid, $in_list, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight_array);
}

function poll_display_user_votes($user_poll_votes_array)
{
    $lang = load_language_file();

    array_walk($user_poll_votes_array['VOTES'], 'poll_user_poll_votes_callback');

    $poll_votes_display = "<tr>\n";
    $poll_votes_display.= "  <td align=\"left\" colspan=\"2\" class=\"postbody\">";
    $poll_votes_display.= "      ". sprintf($lang['youvotedforpolloptionsondate'], implode("' &amp; '", $user_poll_votes_array['VOTES']), format_date($user_poll_votes_array['VOTED']));
    $poll_votes_display.= "  </td>\n";
    $poll_votes_display.= "</tr>\n";

    return $poll_votes_display;
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

function poll_voting_form($poll_results, $poll_data)
{
    $poll_display = "<div align=\"center\">\n";
    $poll_display.= "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"580\">\n";
    $poll_display.= "    <tr>\n";
    $poll_display.= "      <td align=\"center\">\n";
    $poll_display.= "        <table width=\"560\">\n";

    foreach ($poll_results as $question_id => $poll_question) {

        $poll_display.= "          <tr>\n";
        $poll_display.= "            <td align=\"left\"><h2>". word_filter_add_ob_tags(htmlentities_array($poll_question['QUESTION'])). "</h2></td>\n";
        $poll_display.= "          </tr>\n";
        $poll_display.= "          <tr>\n";
        $poll_display.= "            <td align=\"left\">\n";
        $poll_display.= "              <table width=\"100%\">\n";

        if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

            $dropdown_options_array = array_map('poll_dropdown_options_callback', $poll_question['OPTIONS_ARRAY']);

            $poll_display.= "                <tr>\n";
            $poll_display.= "                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[$question_id]", $dropdown_options_array). "</td>\n";
            $poll_display.= "                </tr>\n";

        } else {

            foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {

                if ((sizeof($poll_question['OPTIONS_ARRAY']) == 1) || ($poll_question['ALLOW_MULTI'] == 'Y')) {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[$question_id][$option_id]", 'Y', word_filter_add_ob_tags($option['OPTION_NAME']), false). "</td>\n";
                    $poll_display.= "                </tr>\n";

                } else {

                    $poll_display.= "                <tr>\n";
                    $poll_display.= "                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option['OPTION_NAME']), false). "</td>\n";
                    $poll_display.= "                </tr>\n";
                }
            }
        }

        $poll_display.= "              </table>\n";
        $poll_display.= "            </td>\n";
        $poll_display.= "          </tr>\n";
    }

    $poll_display.= "        </table>\n";
    $poll_display.= "      </td>\n";
    $poll_display.= "    </tr>\n";
    $poll_display.= "  </table>\n";
    $poll_display.= "</div>\n";

    return $poll_display;
}

function poll_horizontal_graph($options_array, $poll_data, $total_votes)
{
    $lang = load_language_file();

    static $bar_color = 1;

    $poll_display = "<div align=\"center\">\n";
    $poll_display.= "  <table width=\"100%\">\n";

    foreach ($options_array as $option_id => $option) {

        $poll_bar_width = ($total_votes > 0) ? (100 / $total_votes) * sizeof($option['VOTES_ARRAY']) : 0;

        $vote_percent = ((sizeof($option['VOTES_ARRAY']) > 0) && ($total_votes > 0)) ? (sizeof($option['VOTES_ARRAY']) / $total_votes) * 100 : 0;

        $poll_display.= "    <tr>\n";
        $poll_display.= "      <td align=\"left\">\n";
        $poll_display.= "        <div class=\"poll_bar poll_bar_horizontal poll_bar_$bar_color\">\n";
        $poll_display.= "          <div class=\"poll_bar_inner poll_bar_inner_$bar_color\" style=\"width: {$poll_bar_width}%; left: -{$poll_bar_width}%\"></div>\n";
        $poll_display.= "        </div>\n";
        $poll_display.= "      </td>\n";
        $poll_display.= "    </tr>\n";
        $poll_display.= "    <tr>\n";
        $poll_display.= "      <td class=\"postbody\">". word_filter_add_ob_tags($option['OPTION_NAME']). ": ". sizeof($option['VOTES_ARRAY']). " {$lang['votes']} (". number_format($vote_percent, 2). "%)</td>\n";
        $poll_display.= "    </tr>\n";

        if (($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC)) {

            $poll_display.= "    <tr>\n";
            $poll_display.= "      <td class=\"postbody\">". implode(', ', array_map('poll_public_ballot_user_callback', $option['VOTES_ARRAY'])). "</td>\n";
            $poll_display.= "    </tr>\n";
        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "  </table>\n";
    $poll_display.= "</div>\n";

    return $poll_display;
}

function poll_vertical_graph($options_array, $poll_data, $total_votes)
{
    $lang = load_language_file();

    static $bar_color = 1;

    $poll_display = "<div align=\"center\">\n";
    $poll_display.= "  <table width=\"560\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $poll_display.= "    <tr>\n";

    foreach ($options_array as $option_id => $option) {

        $poll_bar_width = floor(400 / sizeof($options_array));

        $poll_cell_width = floor(100 / sizeof($options_array));

        $poll_bar_height = ($total_votes > 0) ? (100 / $total_votes) * sizeof($option['VOTES_ARRAY']) : 0;

        $poll_display.= "      <td align=\"center\" width=\"$poll_cell_width%\">\n";
        $poll_display.= "        <div class=\"poll_bar poll_bar_vertical poll_bar_$bar_color\" style=\"width: {$poll_bar_width}px\">\n";
        $poll_display.= "          <div class=\"poll_bar_inner poll_bar_inner_$bar_color\" style=\"width: {$poll_bar_width}px; height: {$poll_bar_height}%; bottom: -{$poll_bar_height}%\"></div>\n";
        $poll_display.= "        </div>\n";
        $poll_display.= "      </td>\n";

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "    </tr>\n";
    $poll_display.= "    <tr>\n";

    foreach ($options_array as $option_id => $option) {

        $vote_percent = ((sizeof($option['VOTES_ARRAY']) > 0) && ($total_votes > 0)) ? (sizeof($option['VOTES_ARRAY']) / $total_votes) * 100 : 0;

        $poll_display.= "      <td class=\"postbody\" align=\"center\">". word_filter_add_ob_tags($option['OPTION_NAME']). "<br />". sizeof($option['VOTES_ARRAY']). " {$lang['votes']} (". number_format($vote_percent, 2). "%)</td>\n";
    }

    $poll_display.= "    </tr>\n";
    $poll_display.= "  </table>\n";
    $poll_display.= "</div>\n";

    return $poll_display;
}

function poll_table_graph($poll_results, $poll_data, $total_votes)
{
    list($row_question, $col_question) = array_values($poll_results);

    $col_width = (560 / (sizeof($col_question['OPTIONS_ARRAY']) + 2));

    $row_vote_count_array = array();

    $col_vote_count_array = array();

    $row_col_vote_count_array = array();

    foreach ($row_question['OPTIONS_ARRAY'] as $row_option) {

        foreach ($col_question['OPTIONS_ARRAY'] as $col_option) {

            $row_votes_serialized = array_map('serialize', $row_option['VOTES_ARRAY']);

            $col_votes_serialized = array_map('serialize', $col_option['VOTES_ARRAY']);

            $row_col_votes_array = array_map('unserialize', array_intersect($row_votes_serialized, $col_votes_serialized));

            $row_col_votes_count = sizeof($row_col_votes_array);

            if (!isset($row_vote_count_array[$row_option['OPTION_ID']])) {
                $row_vote_count_array[$row_option['OPTION_ID']] = 0;
            }

            if (!isset($col_vote_count_array[$col_option['OPTION_ID']])) {
                $col_vote_count_array[$col_option['OPTION_ID']] = 0;
            }

            if (!isset($row_col_vote_count_array[$row_option['OPTION_ID']][$col_option['OPTION_ID']])) {
                $row_col_vote_count_array[$row_option['OPTION_ID']][$col_option['OPTION_ID']] = 0;
            }

            $row_vote_count_array[$row_option['OPTION_ID']]+= $row_col_votes_count;

            $col_vote_count_array[$col_option['OPTION_ID']]+= $row_col_votes_count;

            $row_col_vote_count_array[$row_option['OPTION_ID']][$col_option['OPTION_ID']] = $row_col_votes_count;
        }
    }

    $poll_display = "<div align=\"center\">\n";
    $poll_display.= "  <table width=\"560\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";
    $poll_display.= "    <tr>\n";
    $poll_display.= "      <td width=\"$col_width\">&nbsp;</td>\n";

    foreach ($col_question['OPTIONS_ARRAY'] as $col_option) {
        $poll_display.= "      <th class=\"posthead\" align=\"center\" width=\"$col_width\">". $col_option['OPTION_NAME']. "</th>\n";
    }

    $poll_display.= "      <td width=\"$col_width\">&nbsp;</td>\n";
    $poll_display.= "    </tr>\n";

    foreach ($row_question['OPTIONS_ARRAY'] as $row_option) {

        $poll_display.= "    <tr>\n";
        $poll_display.= "      <th class=\"posthead\">". $row_option['OPTION_NAME']. "</th>\n";

        foreach ($col_question['OPTIONS_ARRAY'] as $col_option) {

            if (!isset($row_col_vote_count_array[$row_option['OPTION_ID']][$col_option['OPTION_ID']])) {

                $poll_display.= "      <td align=\"center\" width=\"$col_width\">0 (0%)</td>\n";

            } else {

                $row_col_vote_count = $row_col_vote_count_array[$row_option['OPTION_ID']][$col_option['OPTION_ID']];

                $vote_percent = ($total_votes > 0) ? ($row_col_vote_count / $total_votes) * 100 : 0;

                $poll_display.= "      <td align=\"center\" width=\"$col_width\">". $row_col_vote_count. " (". number_format($vote_percent, 2). "%)</td>\n";
            }
        }

        if (isset($row_vote_count_array[$row_option['OPTION_ID']])) {

            $vote_percent = ($total_votes > 0) ? ($row_vote_count_array[$row_option['OPTION_ID']] / $total_votes) * 100 : 0;

            $poll_display.= "      <th class=\"posthead\" align=\"center\" width=\"$col_width\">". $row_vote_count_array[$row_option['OPTION_ID']]. " (". number_format($vote_percent, 2). "%)</td>\n";

        } else {

            $poll_display.= "      <th class=\"posthead\" align=\"center\" width=\"$col_width\">0 (0%)</th>\n";
        }

        $poll_display.= "    </tr>\n";
    }

    $poll_display.= "    <tr>\n";
    $poll_display.= "      <td width=\"$col_width\">&nbsp;</td>\n";

    foreach ($col_question['OPTIONS_ARRAY'] as $col_option) {

        if (isset($col_vote_count_array[$col_option['OPTION_ID']])) {

            $vote_percent = ($total_votes > 0) ? ($col_vote_count_array[$col_option['OPTION_ID']] / $total_votes) * 100 : 0;

            $poll_display.= "      <th class=\"posthead\" align=\"center\" width=\"$col_width\">". $col_vote_count_array[$col_option['OPTION_ID']]. " (". number_format($vote_percent, 2). "%)</td>\n";

        } else {

            $poll_display.= "      <th class=\"posthead\" align=\"center\" width=\"$col_width\">0 (0%)</th>\n";
        }
    }

    $poll_display.= "      <td width=\"$col_width\">&nbsp;</td>\n";
    $poll_display.= "    </tr>\n";
    $poll_display.= "  </table>\n";
    $poll_display.= "</div>\n";

    return $poll_display;
}

function poll_public_ballot_user_callback($user_data)
{
    $webtag = get_webtag();

    if (isset($user_data['UID']) && ($user_data['UID'] > 0)) {

        $user_profile_link_html = "<a href=\"user_profile.php?webtag=$webtag&amp;uid=%1\$s\" target=\"_blank\" class=\"popup 650x500\" style=\"white-space: nowrap\">%2\$s</a>";
        return sprintf($user_profile_link_html, $user_data['UID'], word_filter_add_ob_tags(htmlentities_array(format_user_name($user_data['LOGON'], $user_data['NICKNAME']))), $webtag);

    }else if (isset($user_data['LOGON'])) {

        return $user_data['LOGON'];

    } else if (is_string($user_data)) {

        return $user_data;
    }
}

function poll_user_poll_votes_callback(&$option_name, $key)
{
    if (strlen(trim(strip_tags($option_name))) < 1) {
        $option_name = $key;
    }

    $option_name = strip_tags($option_name);
}

function poll_dropdown_options_callback($option)
{
    return $option['OPTION_NAME'];
}

function poll_check_tabular_votes($tid, $votes_array)
{
    if (!$db_poll_check_tabular_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!is_array($votes_array)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL.POLLTYPE, MAX(POLL_VOTES.QUESTION_ID) AS QUESTION_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}POLL` POLL ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ";
    $sql.= "ON (POLL_VOTES.TID = POLL.TID) WHERE POLL.TID = '$tid' GROUP BY POLL.TID";

    if (!$result = db_query($sql, $db_poll_check_tabular_votes)) return false;

    if (db_num_rows($result) > 0) {

        $poll_data = db_fetch_array($result);

        if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            return (sizeof($votes_array) == $poll_data['QUESTION_COUNT']);

        }else {

            return true;
        }
    }

    return true;
}

function poll_get_default_questions_array()
{
    return array(poll_get_question_array(1));
}

function poll_get_question_array($question_id)
{
    return array(
        'QUESTION_ID'   => $question_id,
        'QUESTION'      => '',
        'ALLOW_MULTI'   => 'N',
        'OPTIONS_ARRAY' => array(
            1 => poll_get_option_array(1),
            2 => poll_get_option_array(2),
        )
    );
}

function poll_get_option_array($option_id)
{
    return array(
        'OPTION_ID'   => $option_id,
        'OPTION_NAME' => '',
    );
}

function poll_get_question_html($question_number)
{
    if (!is_numeric($question_number)) return false;

    $lang = load_language_file();

    $html = "<fieldset class=\"poll_question\">\n";
    $html.= "  <div>\n";
    $html.= "    <h2>{$lang['pollquestion']}</h2>\n";
    $html.= "    <div class=\"poll_question_input\">\n";
    $html.= "      ". form_input_text("poll_questions[{$question_number}][question]", '', 40, 255). "&nbsp;". form_button_html("delete_question[{$question_number}]", 'submit', 'button_image delete_question', sprintf("<img src=\"%s\" alt=\"\" />", html_style_image('delete.png')), "title=\"{$lang['deletequestion']}\""). "<br />\n";
    $html.= "    </div>\n";
    $html.= "    <div class=\"poll_question_checkbox\">\n";
    $html.= "      ". form_checkbox("poll_questions[{$question_number}][allow_multi]", "Y", $lang['allowmultipleoptions'], false). "\n";
    $html.= "    </div>\n";
    $html.= "    <div class=\"poll_options_list\">\n";
    $html.= "      <ol>\n";
    $html.= "        ". poll_get_option_html($question_number, 1). "\n";
    $html.= "      </ol>\n";
    $html.= "    </div>\n";
    $html.= "  </div>\n";
    $html.= "  ". form_button_html("add_option[{$question_number}]", 'submit', 'button_image add_option', sprintf("<img src=\"%s\" alt=\"\" />&nbsp;%s", html_style_image('add.png'), $lang['addnewoption'])). "\n";
    $html.= "</fieldset>\n";

    return $html;
}

function poll_get_option_html($question_number, $option_number)
{
    if (!is_numeric($question_number)) return false;

    if (!is_numeric($option_number)) return false;

    $lang = load_language_file();

    return sprintf("<li>%s&nbsp;%s</li>\n", form_input_text("poll_questions[{$question_number}][options][{$option_number}]", '', 45, 255), form_button_html("delete_option[{$question_number}][{$option_number}]", 'submit', 'button_image delete_option', sprintf("<img src=\"%s\" alt=\"\"/>", html_style_image('delete.png')), "title=\"{$lang['deleteoption']}\""));
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

    $poll_results = poll_get_votes($tid);

    $current_datetime = date(MYSQL_DATETIME, time());

    if ((!poll_get_user_votes($tid)) || ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) || (user_is_guest() && ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) {

        foreach ($vote_array as $question_id => $option_data) {

            if (!is_numeric($question_id) || !isset($poll_results[$question_id])) continue;

            if (is_array($option_data) && sizeof($option_data) > 0) {

                foreach ($option_data as $option_id => $option_value) {

                    if (!is_numeric($option_id) || ($option_value != 'Y')) continue;

                    if (!isset($poll_results[$question_id]['OPTIONS_ARRAY'][$option_id])) continue;

                    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_POLL_VOTES` (TID, UID, QUESTION_ID, OPTION_ID, VOTED) ";
                    $sql.= "VALUES ('$tid', '$uid', '$question_id', '$option_id', CAST('$current_datetime' AS DATETIME))";

                    if (!db_query($sql, $db_poll_vote)) return false;
                }

            } else if (is_numeric($option_data)) {

                if (!isset($poll_results[$question_id]['OPTIONS_ARRAY'][$option_data])) continue;

                $sql = "INSERT INTO `{$table_data['PREFIX']}USER_POLL_VOTES` (TID, UID, QUESTION_ID, OPTION_ID, VOTED) ";
                $sql.= "VALUES ('$tid', '$uid', '$question_id', '$option_data', CAST('$current_datetime' AS DATETIME))";

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

?>