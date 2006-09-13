<?php

/* ======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and / or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA    02111 - 1307
USA
======================================================================*/

/* $Id: poll.inc.php,v 1.171 2006-09-13 19:07:32 decoyduck Exp $ */

/**
* Poll related functions
*/

/**
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

function poll_create($tid, $poll_options, $answer_groups, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $question)
{
    $db_poll_create = db_connect();

    if (is_numeric($closes)) {
        $closes = "FROM_UNIXTIME($closes)";
    }else {
        $closes = 'NULL';
    }

    if (!is_numeric($tid)) return false;
    if (!is_array($poll_options)) return false;
    if (!is_array($answer_groups)) return false;
    if (!is_numeric($change_vote)) $change_vote = 1;
    if (!is_numeric($poll_type)) $poll_type = 0;
    if (!is_numeric($show_results)) $show_results = 1;
    if (!is_numeric($poll_vote_type)) $poll_vote_type = 0;
    if (!is_numeric($option_type)) $option_type = 0;

    $question  = addslashes(_htmlentities($question));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}POLL (TID, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS, VOTETYPE, OPTIONTYPE, QUESTION) ";
    $sql.= "VALUES ('$tid', $closes, '$change_vote', '$poll_type', '$show_results', '$poll_vote_type', '$option_type', '$question')";

    if (db_query($sql, $db_poll_create)) {

        for ($i = 0; $i <= sizeof($poll_options); $i++) {

            if (isset($poll_options[$i]) && trim($poll_options[$i]) != "") {

                $option_name  = addslashes($poll_options[$i]);
                $option_group = (isset($answer_groups[$i])) ? $answer_groups[$i] : 1;

                $sql = "INSERT INTO {$table_data['PREFIX']}POLL_VOTES (TID, OPTION_NAME, GROUP_ID) ";
                $sql.= "VALUES ('$tid', '$option_name', '$option_group')";

                $result = db_query($sql, $db_poll_create);
            }
        }

    }else {

        return false;
    }
}

function poll_edit($tid, $thread_title, $poll_question, $poll_options, $answer_groups, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $hardedit)
{
    $db_poll_edit = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_array($poll_options)) return false;
    if (!is_array($answer_groups)) return false;
    if (!is_numeric($change_vote)) $change_vote = 1;
    if (!is_numeric($poll_type)) $poll_type = 0;
    if (!is_numeric($show_results)) $show_results = 1;
    if (!is_numeric($poll_vote_type)) $poll_vote_type = 0;
    if (!is_numeric($option_type)) $option_type = 0;

    $edit_uid = bh_session_get_value('UID');

    $thread_title = addslashes($thread_title);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD SET TITLE = '$thread_title' WHERE TID = $tid";
    $result = db_query($sql, $db_poll_edit);

    if ($hardedit) {

        $sql = "DELETE FROM {$table_data['PREFIX']}USER_POLL_VOTES WHERE TID = '$tid'";
        $result = db_query($sql, $db_poll_edit);
    }

    $poll_question = addslashes($poll_question);

    $sql = "UPDATE {$table_data['PREFIX']}POLL SET CHANGEVOTE = '$change_vote', ";
    $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$show_results', ";
    $sql.= "VOTETYPE = '$poll_vote_type', OPTIONTYPE = '$option_type', ";
    $sql.= "QUESTION = '$poll_question' ";

    if ($closes) {

        if ($closes > 0) {
            $sql.= ", CLOSES = FROM_UNIXTIME($closes) ";
        }else {
            $sql.= ", CLOSES = NULL ";
        }
    }

    $sql.= "WHERE TID = '$tid'";
    $result = db_query($sql, $db_poll_edit);

    $sql = "DELETE FROM {$table_data['PREFIX']}POLL_VOTES WHERE TID = '$tid'";
    $result = db_query($sql, $db_poll_edit);

    for ($i = 0; $i <= sizeof($poll_options); $i++) {

        if (isset($poll_options[$i]) && trim($poll_options[$i]) != "") {

            $option_name    = addslashes($poll_options[$i]);
            $option_group = (isset($answer_groups[$i])) ? $answer_groups[$i] : 1;

            $sql = "INSERT INTO {$table_data['PREFIX']}POLL_VOTES (TID, OPTION_NAME, GROUP_ID) ";
            $sql.= "VALUES ('$tid', '$option_name', '$option_group')";

            $result = db_query($sql, $db_poll_edit);
        }
    }
}

function poll_get($tid)
{
    $lang = load_language_file();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;

    $db_poll_get = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST.VIEWED, ";
    $sql.= "POST.MOVED_TID, POST.MOVED_PID, FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, USER_PEER.RELATIONSHIP, ";
    $sql.= "USER_PEER.PEER_NICKNAME, POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, ";
    $sql.= "POLL.VOTETYPE, POLL.OPTIONTYPE, UNIX_TIMESTAMP(POLL.CLOSES) AS CLOSES, POLL.QUESTION, ";
    $sql.= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, ";
    $sql.= "POST.EDITED_BY, POST.APPROVED_BY, POST.IPADDRESS ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN USER FUSER ON (POST.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (POST.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL POLL ON (POST.TID = POLL.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.UID = $uid AND USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID = 1";

    $result = db_query($sql, $db_poll_get);
    $polldata = db_fetch_array($result);

    if (!isset($polldata['TNICK'])) {
        $polldata['TNICK']  = $lang['allcaps'];
        $polldata['TLOGON'] = $lang['allcaps'];
    }

    if (!isset($polldata['CLOSES'])) {
        $polldata['CLOSES'] = 0;
    }

    if (!isset($polldata['CHANGEVOTE'])) {
        $polldata['CHANGEVOTE'] = 1;
    }

    if (!isset($polldata['POLLTYPE'])) {
        $polldata['POLLTYPE'] = 0;
    }

    if (!isset($polldata['SHOWRESULTS'])) {
        $polldata['SHOWRESULTS'] = 1;
    }

    if (!isset($polldata['VOTETYPE'])) {
        $polldata['VOTETYPE'] = 0;
    }

    if (!isset($polldata['OPTIONTYPE'])) {
        $polldata['OPTIONTYPE'] = 0;
    }

    if (isset($polldata['PEER_NICKNAME'])) {
        if (!is_null($polldata['PEER_NICKNAME']) && strlen($polldata['PEER_NICKNAME']) > 0) {
            $polldata['FNICK'] = $polldata['PEER_NICKNAME'];
        }
    }

    return $polldata;
}

function poll_get_votes($tid)
{
    $db_poll_get_votes = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME, ";
    $sql.= "POLL_VOTES.GROUP_ID, COUNT(USER_POLL_VOTES.UID) AS VOTE_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}POLL_VOTES POLL_VOTES LEFT JOIN ";
    $sql.= "{$table_data['PREFIX']}USER_POLL_VOTES USER_POLL_VOTES ";
    $sql.= "ON (USER_POLL_VOTES.TID = POLL_VOTES.TID ";
    $sql.= "AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES.OPTION_ID) ";
    $sql.= "WHERE POLL_VOTES.TID = $tid GROUP BY POLL_VOTES.OPTION_ID";

    $result = db_query($sql, $db_poll_get_votes);

    $option_ids    = array();
    $option_names  = array();
    $option_groups = array();
    $option_votes  = array();

    $pollresults = array();

    while($row = db_fetch_array($result)) {
        
        $option_ids[]    = $row['OPTION_ID'];
        $option_names[]  = $row['OPTION_NAME'];
        $option_groups[] = $row['GROUP_ID'];
        $option_votes[]  = $row['VOTE_COUNT'];

        if (!isset($group_size[$row['GROUP_ID']])) {
            $group_size[$row['GROUP_ID']] = 0;
        }

        $group_size[$row['GROUP_ID']]++;
    }

    $pollresults = array('OPTION_ID'   => $option_ids,
                         'OPTION_NAME' => $option_names,
                         'GROUP_ID'    => $option_groups,
                         'VOTES'       => $option_votes,
                         'GROUP_SIZE'  => $group_size);

    return $pollresults;
}

function poll_get_total_votes($tid)
{
    $db_poll_get_total_votes = db_connect();

    if (!is_numeric($tid)) return 0;
    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(DISTINCT UID) FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = $tid";

    $result = db_query($sql, $db_poll_get_total_votes);
    list($vote_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $vote_count;
}

function poll_get_user_votes($tid, $viewstyle)
{
    $db_poll_get_user_vote_hashes = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($viewstyle)) $viewstyle = 0;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UP.UID, UP.OPTION_ID, UNIX_TIMESTAMP(UP.TSTAMP) AS TSTAMP ";
    $sql.= "FROM {$table_data['PREFIX']}USER_POLL_VOTES UP ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL POLL ON (UP.TID = POLL.TID) ";
    $sql.= "WHERE UP.TID = '$tid' AND POLL.VOTETYPE = 1";

    $result = db_query($sql, $db_poll_get_user_vote_hashes);

    $poll_get_user_votes = array();

    while($row = db_fetch_array($result)) {

        if ($viewstyle == 0) {
            $poll_get_user_votes[$row['OPTION_ID']][] = $row['UID'];
        }else {
            $poll_get_user_votes[$row['UID']][] = $row['OPTION_ID'];
        }
    }

    return $poll_get_user_votes;
}

function poll_get_user_vote($tid)
{
    if (!is_numeric($tid)) return false;

    $db_poll_get_user_vote = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT OPTION_ID, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP ";
    $sql.= "FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE UID = $uid AND TID = $tid";

    $result = db_query($sql, $db_poll_get_user_vote);

    if (db_num_rows($result) > 0) {

        $user_poll_data = array();

        while($row = db_fetch_array($result)) {

            $user_poll_data[] = $row;
        }

        return $user_poll_data;
    }

    return false;
}

function poll_sort_groups($a, $b) {

    if ($a['GROUP_ID'] == $b['GROUP_ID']) return 0;
    return ($a['GROUP_ID'] > $b['GROUP_ID']) ? 1 : - 1;
}

function poll_display($tid, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = true, $show_sigs = true, $is_preview = false, $highlight = array())
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $polldata     = poll_get($tid);
    $pollresults  = poll_get_votes($tid);
    $user_poll_data = poll_get_user_vote($tid);

    if (isset($polldata['QUESTION']) && trim(_stripslashes($polldata['QUESTION']) != "")) {
        $question = $polldata['QUESTION'];
    } else {
        $question = thread_get_title($tid);
    }

    $totalvotes  = 0;
    $optioncount = 0;

    $polldata['CONTENT'] = "<br />\n";
    $polldata['CONTENT'].= "<div align=\"center\">\n";
    $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td>\n";
    $polldata['CONTENT'].= "      <form method=\"post\" action=\"". $_SERVER['PHP_SELF']. "\" target=\"_self\">\n";
    $polldata['CONTENT'].= "        ". form_input_hidden("webtag", $webtag). "\n";
    $polldata['CONTENT'].= "        ". form_input_hidden('tid', $tid). "\n";
    $polldata['CONTENT'].= "        <table width=\"450\">\n";
    $polldata['CONTENT'].= "          <tr>\n";
    $polldata['CONTENT'].= "            <td><h2>". apply_wordfilter($question). "</h2></td>\n";
    $polldata['CONTENT'].= "          </tr>\n";

    $poll_group_count = 1;

    /*for ($i = 0; $i < sizeof($pollresults['GROUP_ID']); $i++) {

        if (!isset($pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]]))         {
            $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]] = 1;
        }else {
            $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]]++;
        }
    }*/

    if ($in_list) {

        if (((!is_array($user_poll_data) || $polldata['CHANGEVOTE'] == 2) && bh_session_get_value('UID') > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > mktime()) && !$is_preview) {

            $polldata['CONTENT'].= "          <tr>\n";
            $polldata['CONTENT'].= "            <td>\n";
            $polldata['CONTENT'].= "              <table width=\"100%\">\n";

            array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);
            
            for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

                if (!isset($poll_previous_group)) {
                    $poll_previous_group = $pollresults['GROUP_ID'][$i];
                }

                if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

                    if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {

                        if ($polldata['OPTIONTYPE'] == 1 && $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i - 1]] > 1) {

                            $polldata['CONTENT'].= "                <tr>\n";
                            $polldata['CONTENT'].= "                  <td class=\"postbody\">&nbsp;</td>\n";
                            $polldata['CONTENT'].= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$pollresults['GROUP_ID'][$i - 1]}]", $dropdown['value'], $dropdown['label'], false, false). "</td>\n";
                            $polldata['CONTENT'].= "                </tr>\n";

                        }else {

                            $polldata['CONTENT'].= "                <tr>\n";
                            $polldata['CONTENT'].= "                  <td colspan=\"2\"><hr /></td>\n";
                            $polldata['CONTENT'].= "                <tr>\n";
                        }

                        unset($dropdown);

                        $poll_group_count++;
                    }

                    if ($pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]] > 1) {

                        if ($polldata['OPTIONTYPE'] == 1) {

                            $dropdown['value'][] = $pollresults['OPTION_ID'][$i];
                            $dropdown['label'][] = apply_wordfilter($pollresults['OPTION_NAME'][$i]);

                        }else {

                            $polldata['CONTENT'].= "                <tr>\n";
                            $polldata['CONTENT'].= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_radio("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "</td>\n";
                            $polldata['CONTENT'].= "                  <td class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";
                            $polldata['CONTENT'].= "                </tr>\n";
                        }

                    }else {

                        $polldata['CONTENT'].= "                <tr>\n";
                        $polldata['CONTENT'].= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_checkbox("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "</td>\n";
                        $polldata['CONTENT'].= "                  <td class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";
                        $polldata['CONTENT'].= "                </tr>\n";
                    }

                    $poll_previous_group = $pollresults['GROUP_ID'][$i];
                }

                if ($i == sizeof($pollresults['OPTION_ID']) - 1) {

                    if ($polldata['OPTIONTYPE'] == 1 && $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]] > 1) {

                        $polldata['CONTENT'].= "                <tr>\n";
                        $polldata['CONTENT'].= "                  <td class=\"postbody\">&nbsp;</td>\n";
                        $polldata['CONTENT'].= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$pollresults['GROUP_ID'][$i]}]", $dropdown['value'], $dropdown['label'], false, false). "</td>\n";
                        $polldata['CONTENT'].= "                </tr>\n";

                    }
                }
            }

            $polldata['CONTENT'].= "                        </table>\n";
            $polldata['CONTENT'].= "                    </td>\n";
            $polldata['CONTENT'].= "                </tr>\n";

        }else {

            if ($polldata['SHOWRESULTS'] == 1 || ($polldata['CLOSES'] > 0 && $polldata['CLOSES'] < mktime())) {

                if ($polldata['POLLTYPE'] == 0) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_horizontal_graph($tid);
                    $polldata['CONTENT'].= "                    </td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";

                }else if ($polldata['POLLTYPE'] == 1) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_vertical_graph($tid);
                    $polldata['CONTENT'].= "                    </td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";

                }else if ($polldata['POLLTYPE'] == 2) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_table_graph($tid);
                    $polldata['CONTENT'].= "                    </td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";

                }else {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_public_ballot($tid);
                    $polldata['CONTENT'].= "                    </td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                }

            }else {

                for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

                    if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

                    if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

                        if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {

                            $polldata['CONTENT'].= "                <tr>\n";
                            $polldata['CONTENT'].= "                  <td colspan=\"2\"><hr /></td>\n";
                            $polldata['CONTENT'].= "                <tr>\n";

                            $poll_group_count++;
                        }

                        $polldata['CONTENT'].= "                <tr>\n";
                        $polldata['CONTENT'].= "                  <td colspan=\"2\" class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";
                        $polldata['CONTENT'].= "                </tr>\n";

                        $poll_previous_group = $pollresults['GROUP_ID'][$i];
                    }
                }
            }
        }

    }else {

        $polldata['CONTENT'].= "                <tr>\n";
        $polldata['CONTENT'].= "                    <td colspan=\"2\" class=\"postbody\">\n";
        $polldata['CONTENT'].= "                        <ul>\n";

        for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (strlen($pollresults['OPTION_NAME'][$i]) > 0) {

                $polldata['CONTENT'].= "                <li>". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</li>\n";
            }
        }

        $polldata['CONTENT'].= "                        </ul>\n";
        $polldata['CONTENT'].= "                    </td>\n";
        $polldata['CONTENT'].= "                </tr>\n";

    }

    if ($in_list && !$is_preview) {

        $polldata['CONTENT'].= "                <tr>\n";
        $polldata['CONTENT'].= "                    <td colspan=\"2\">&nbsp;</td>\n";
        $polldata['CONTENT'].= "                </tr>\n";
        $polldata['CONTENT'].= "                <tr>\n";
        $polldata['CONTENT'].= "                    <td colspan=\"2\" class=\"postbody\">";

        $group_array = array();

        for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!in_array($pollresults['GROUP_ID'][$i], $group_array)) {
                    $group_array[] = $pollresults['GROUP_ID'][$i];
            }
        }

        $totalvotes = poll_get_total_votes($tid);
        $poll_group_count = sizeof($group_array);

        if ($totalvotes == 0 && ($polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0)) {

            $polldata['CONTENT'].= "<b>{$lang['nobodyvoted']}</b>";

        }else if ($totalvotes == 0 && ($polldata['CLOSES'] > mktime() || $polldata['CLOSES'] == 0)) {

            $polldata['CONTENT'].= "<b>{$lang['nobodyhasvoted']}</b>";

        }else if ($totalvotes == 1 && ($polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0)) {

            $polldata['CONTENT'].= "<b>{$lang['1personvoted']}</b>";

        }else if ($totalvotes == 1 && ($polldata['CLOSES'] > mktime() || $polldata['CLOSES'] == 0)) {

            $polldata['CONTENT'].= "<b>{$lang['1personhasvoted']}</b>";

        }else {

            if ($polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0) {

                $polldata['CONTENT'].= "<b>$totalvotes {$lang['peoplevoted']}</b>";

            }else {

                $polldata['CONTENT'].= "<b>$totalvotes {$lang['peoplehavevoted']}</b>";

            }

        }

        $polldata['CONTENT'].= "</td>\n";
        $polldata['CONTENT'].= "                </tr>\n";
        $polldata['CONTENT'].= "                <tr>\n";
        $polldata['CONTENT'].= "                    <td colspan=\"2\">&nbsp;</td>\n";
        $polldata['CONTENT'].= "                </tr>\n";

        if (($polldata['CLOSES'] <= mktime()) && $polldata['CLOSES'] != 0) {

            $polldata['CONTENT'].= "                <tr>\n";
            $polldata['CONTENT'].= "                    <td colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
            $polldata['CONTENT'].= "                </tr>\n";

            if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2 && $polldata['POLLTYPE'] != 2) {

                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\">&nbsp;</td>";
                $polldata['CONTENT'].= "                </tr>\n";
                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">";
                $polldata['CONTENT'].= "                      ". form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");
                $polldata['CONTENT'].= "                    </td>\n";
                $polldata['CONTENT'].= "                </tr>\n";
                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\">&nbsp;</td>";
                $polldata['CONTENT'].= "                </tr>\n";
            }

            if (is_array($user_poll_data) && isset($user_poll_data[0]['TSTAMP'])) {

                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\" class=\"postbody\">";

                $user_poll_votes_array = array();

                for ($i = 0; $i < sizeof($user_poll_data); $i++) {

                    for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {

                        if ($user_poll_data[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {

                            if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {

                                $user_poll_votes_array[] = "'". apply_wordfilter($pollresults['OPTION_NAME'][$j]). "'";

                            }else {

                                $user_poll_votes_array[] = "Option {$user_poll_data[$i]['OPTION_ID']}";
                            }
                        }
                    }
                }

                $polldata['CONTENT'].= "{$lang['youvotedfor']}: ". implode(" & ", $user_poll_votes_array);
                $polldata['CONTENT'].=    " {$lang['on']} ". gmdate("jS M Y", $user_poll_data[0]['TSTAMP']). ". </td>\n";
                $polldata['CONTENT'].= "                </tr>\n";

            }

        }else {

            if (is_array($user_poll_data) && isset($user_poll_data[0]['TSTAMP'])) {

                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\" class=\"postbody\">";

                $user_poll_votes_array = array();

                for ($i = 0; $i < sizeof($user_poll_data); $i++) {

                    for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {

                        if ($user_poll_data[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {

                            if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {

                                $user_poll_votes_array[] = "'". apply_wordfilter($pollresults['OPTION_NAME'][$j]). "'";

                            }else {

                                $user_poll_votes_array[] = "Option {$user_poll_data[$i]['OPTION_ID']}";
                            }
                        }
                    }
                }

                $polldata['CONTENT'].= "{$lang['youvotedfor']}: ". implode(" & ", $user_poll_votes_array);
                $polldata['CONTENT'].=    " {$lang['on']} ". gmdate("jS M Y", $user_poll_data[0]['TSTAMP']). ". </td>\n";
                $polldata['CONTENT'].= "                </tr>\n";
                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\">&nbsp;</td>\n";
                $polldata['CONTENT'].= "                </tr>\n";

                if ($polldata['CHANGEVOTE'] == 2) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                }

                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">";

                if (($polldata['SHOWRESULTS'] == 1 && $totalvotes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2 && $polldata['POLLTYPE'] != 2) {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

                    }else {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

                    }
                }

                if (bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, false, $folder_fid)) {

                    $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']);
                }

                $polldata['CONTENT'].= "</td>\n";
                $polldata['CONTENT'].= "                </tr>\n";

                if ($polldata['CHANGEVOTE'] != 0) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                }

                if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2 && $polldata['POLLTYPE'] != 2) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                }

            }else if (bh_session_get_value('UID') > 0) {

                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                $polldata['CONTENT'].= "                </tr>\n";
                $polldata['CONTENT'].= "                <tr>\n";
                $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">";

                if (($polldata['SHOWRESULTS'] == 1 && $totalvotes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2 && $polldata['POLLTYPE'] != 2) {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

                    }else {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");
                    }
                }

                if (bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']);

                }

                $polldata['CONTENT'].= "</td>\n";
                $polldata['CONTENT'].= "                </tr>\n";

                if ($polldata['VOTETYPE'] == 1 && $polldata['CHANGEVOTE'] < 2 && $polldata['POLLTYPE'] != 2) {

                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                    $polldata['CONTENT'].= "                <tr>\n";
                    $polldata['CONTENT'].= "                    <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $polldata['CONTENT'].= "                </tr>\n";
                }
            }
        }
    }

    $polldata['CONTENT'].= "            </table>\n";
    $polldata['CONTENT'].= "            </form>\n";
    $polldata['CONTENT'].= "        </td>\n";
    $polldata['CONTENT'].= "    </tr>\n";
    $polldata['CONTENT'].= "</table>\n";
    $polldata['CONTENT'].= "</div>\n";
    $polldata['CONTENT'].= "<br />\n";

    $polldata['FROM_RELATIONSHIP'] = user_rel_get(bh_session_get_value('UID'), $polldata['FROM_UID']);

    message_display($tid, $polldata, $msg_count, $first_msg, $folder_fid, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);
}


function poll_preview_form($pollresults, $polldata)
{
    $lang = load_language_file();

    $poll_group_count = 1;

    for ($i = 0; $i < sizeof($pollresults['GROUP_ID']); $i++) {

        if (!isset($pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]]))         {
            $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]] = 1;
        }else {
            $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]]++;
        }
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "                        <div align=\"center\">\n";
    $polldisplay.= "                        <table width=\"100%\">\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) {
            $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }

        if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {

                if ($polldata['OPTIONTYPE'] == 1 && $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i - 1]] > 1) {

                    $polldisplay.= "                <tr>\n";
                    $polldisplay.= "                  <td class=\"postbody\">&nbsp;</td>\n";
                    $polldisplay.= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$pollresults['GROUP_ID'][$i - 1]}]", $dropdown['value'], $dropdown['label'], false, false). "</td>\n";
                    $polldisplay.= "                </tr>\n";

                }else {

                    $polldisplay.= "                <tr>\n";
                    $polldisplay.= "                  <td colspan=\"2\"><hr /></td>\n";
                    $polldisplay.= "                <tr>\n";
                }

                unset($dropdown);

                $poll_group_count++;
            }

            if ($pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]] > 1) {

                if ($polldata['OPTIONTYPE'] == 1) {

                    $dropdown['value'][] = $pollresults['OPTION_ID'][$i];
                    $dropdown['label'][] = apply_wordfilter($pollresults['OPTION_NAME'][$i]);

                }else {

                    $polldisplay.= "                <tr>\n";
                    $polldisplay.= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_radio("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "</td>\n";
                    $polldisplay.= "                  <td class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";
                    $polldisplay.= "                </tr>\n";
                }

            }else {

                $polldisplay.= "                <tr>\n";
                $polldisplay.= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_checkbox("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "</td>\n";
                $polldisplay.= "                  <td class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";
                $polldisplay.= "                </tr>\n";
            }

            $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }

        if ($i == sizeof($pollresults['OPTION_ID']) - 1) {

            if ($polldata['OPTIONTYPE'] == 1 && $pollresults['GROUP_SIZE'][$pollresults['GROUP_ID'][$i]] > 1) {

                $polldisplay.= "                <tr>\n";
                $polldisplay.= "                  <td class=\"postbody\">&nbsp;</td>\n";
                $polldisplay.= "                  <td class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$pollresults['GROUP_ID'][$i]}]", $dropdown['value'], $dropdown['label'], false, false). "</td>\n";
                $polldisplay.= "                </tr>\n";

            }
        }
    }

    $polldisplay.= "                        </table>\n";
    $polldisplay.= "                        </div>\n";

    return $polldisplay;
}

function poll_preview_graph_horz($pollresults)
{
    $lang = load_language_file();

    $totalvotes    = array();
    $max_values    = array();

    $bar_color = 1;

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "                        <div align=\"center\">\n";
    $polldisplay.= "                        <table width=\"100%\">\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

            $polldisplay.= "                            <tr>\n";
            $polldisplay.= "                                <td width=\"150\" class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";

            if ($pollresults['VOTES'][$i] > 0) {

                $polldisplay.= "                                <td width=\"300\">\n";
                $polldisplay.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$pollresults['GROUP_ID'][$i]], 2) * $pollresults['VOTES'][$i]). "px\">\n";
                $polldisplay.= "                                        <tr>\n";
                $polldisplay.= "                                            <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $polldisplay.= "                                        </tr>\n";
                $polldisplay.= "                                    </table>\n";
                $polldisplay.= "                                </td>\n";

            }else {

                $polldisplay.= "                                <td class=\"postbody\" height=\"25\">&nbsp;</td>\n";
            }

            if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
                $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
            }else {
                $vote_percent = 0;
            }

            $polldisplay.= "                            </tr>\n";
            $polldisplay.= "                            <tr>\n";
            $polldisplay.= "                                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
            $polldisplay.= "                                <td class=\"postbody\" height=\"20\">". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
            $polldisplay.= "                            </tr>\n";

            $poll_previous_group = $pollresults['GROUP_ID'][$i];

        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $polldisplay.= "                        </table>\n";
    $polldisplay.= "                        </div>\n";

    return $polldisplay;
}

function poll_preview_graph_vert($pollresults)
{
    $lang = load_language_file();

    $totalvotes    = array();
    $max_value     = array();

    $optioncount = 0;
    $bar_color     = 1;

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "                        <div align=\"center\">\n";
    $polldisplay.= "                        <table width=\"460\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "                            <tr>\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

            if ($pollresults['VOTES'][$i] > 0) {

                if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                    $polldisplay.= "                                <td style=\"width: 2px; border - left: 1px solid #000000\"></td>\n";
                }

                $polldisplay.= "                                <td align=\"center\" valign=\"bottom\">\n";
                $polldisplay.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$pollresults['GROUP_ID'][$i]], 2) * $pollresults['VOTES'][$i]). "px; width: ". round(400 / $optioncount, 2). "px\">\n";
                $polldisplay.= "                                        <tr>\n";
                $polldisplay.= "                                            <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $polldisplay.= "                                        </tr>\n";
                $polldisplay.= "                                    </table>\n";
                $polldisplay.= "                                </td>\n";

            }else {

                $polldisplay.= "                                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $optioncount, 2). "px\">&nbsp;</td>\n";
            }

            $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $polldisplay.= "                            </tr>\n";
    $polldisplay.= "                            <tr>\n";

    unset($poll_previous_group);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

            if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
                $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
            }else {
                $vote_percent = 0;
            }

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldisplay.= "                                <td style=\"width: 2px; border - left: 1px solid #000000\"></td>\n";
            }

            $polldisplay.= "                                <td class=\"postbody\" align=\"center\" valign=\"top\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "<br />". $pollresults['VOTES'][$i]. " {$lang['votes']}<br />(". $vote_percent. "%)</td>\n";
            $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }
    }

    $polldisplay.= "                            </tr>\n";
    $polldisplay.= "                        </table>\n";
    $polldisplay.= "                        </div>\n";

    return $polldisplay;
}

function poll_horizontal_graph($tid)
{
    $lang = load_language_file();

    $totalvotes    = array();
    $max_values    = array();

    $bar_color = 1;
    $poll_group_count = 1;

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "                        <div align=\"center\">\n";
    $polldisplay.= "                        <table width=\"100%\">\n";

    if (sizeof($pollresults['OPTION_ID']) > 0) {

        for ($i = 0; $i <= sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

                if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {

                    $polldisplay.= "                            <tr>\n";
                    $polldisplay.= "                              <td colspan=\"2\"><hr /></td>\n";
                    $polldisplay.= "                            </tr>\n";

                    $poll_group_count++;
                }

                $polldisplay.= "                            <tr>\n";
                $polldisplay.= "                                <td width=\"150\" class=\"postbody\">". apply_wordfilter($pollresults['OPTION_NAME'][$i]). "</td>\n";

                if ($pollresults['VOTES'][$i] > 0) {

                    $polldisplay.= "                                <td width=\"300\">\n";
                    $polldisplay.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$pollresults['GROUP_ID'][$i]], 2) * $pollresults['VOTES'][$i]). "px\">\n";
                    $polldisplay.= "                                        <tr>\n";
                    $polldisplay.= "                                            <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                    $polldisplay.= "                                        </tr>\n";
                    $polldisplay.= "                                    </table>\n";
                    $polldisplay.= "                                </td>\n";

                }else {

                    $polldisplay.= "                                <td class=\"postbody\" height=\"25\">&nbsp;</td>\n";
                }

                if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
                    $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
                }else {
                    $vote_percent = 0;
                }

                $polldisplay.= "                            </tr>\n";
                $polldisplay.= "                            <tr>\n";
                $polldisplay.= "                                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
                $polldisplay.= "                                <td class=\"postbody\" height=\"20\">". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
                $polldisplay.= "                            </tr>\n";

                $poll_previous_group = $pollresults['GROUP_ID'][$i];
            }

            $bar_color++;
            if ($bar_color > 5) $bar_color = 1;
        }
    }

    $polldisplay.= "                        </table>\n";
    $polldisplay.= "                        </div>\n";

    return $polldisplay;

}

function poll_preview_graph_table($pollresults)
{
    $lang = load_language_file();

    $totalvotes = array();
    $max_value  = array();

    $optioncount = 0;
    $bar_color   = 1;

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $groups = array_unique($pollresults['GROUP_ID']);

    $group_keys = array_keys($groups);

    $group1_keys = array_keys($pollresults['GROUP_ID'], $groups[$group_keys[0]]);
    $group2_keys = array_keys($pollresults['GROUP_ID'], $groups[$group_keys[1]]);

    $group1 = array();

    for ($i = 0; $i < sizeof($group1_keys); $i++) {
        $group1[] = $pollresults['OPTION_ID'][$group1_keys[$i]];
        $blank1[] = 0;
    }

    $group2 = array();

    for ($i = 0; $i < sizeof($group2_keys); $i++) {
        $group2[] = $pollresults['OPTION_ID'][$group2_keys[$i]];
        $blank2[] = 0;
    }

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $table[$rows][$cols] = rand(0, 10);
        }
    }

    $rowcount = array();
    $numvotes = 0;

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        $rowcount[] = 0;

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $rowcount[$rows]    += $table[$rows][$cols];
            $numvotes    += $table[$rows][$cols];
        }
    }

    $colcount = array();

    for ($cols = 0; $cols < sizeof($group2); $cols++) {

        $colcount[] = 0;

        for ($rows = 0; $rows < sizeof($group1); $rows++) {

            $colcount[$cols]    += $table[$rows][$cols];
        }
    }

    $polldisplay = "                        <table width=\"460\" align=\"center\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

    for ($rows = 0; $rows < sizeof($group1) + 2; $rows++) {

        $polldisplay.= "                            <tr>\n";

        for ($cols = 0; $cols < sizeof($group2) + 2; $cols++) {

            if ($cols == 0) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                <td>&nbsp;</td>\n";

                }else {

                    $polldisplay.= "                                <th class=\"posthead\" align=\"right\">". apply_wordfilter($pollresults['OPTION_NAME'][$group1_keys[$rows - 1]]). "</th>\n";
                }

            }else if ($cols == sizeof($group2) + 1) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                <td>&nbsp;</td>\n";

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (". round($rowcount[$rows - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (0%)</th>\n";
                    }
                }

            }else {

                if ($rows == 0) {

                    $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". apply_wordfilter($pollresults['OPTION_NAME'][$group2_keys[$cols - 1]]). "</th>\n";

                }else if ($rows == sizeof($group1) + 1) {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (". round($colcount[$cols - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (0%)</th>\n";
                    }

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (". round($table[$rows - 1][$cols - 1] * 100 / $numvotes, 2). "%)</td>\n";

                    }else {

                        $polldisplay.= "                                <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (0%)</td>\n";
                    }
                }

            }
        }

        $polldisplay.= "                            </tr>\n";
    }

    $polldisplay.= "                        </table>\n";

    return $polldisplay;
}

function poll_vertical_graph($tid)
{
    $lang = load_language_file();

    $totalvotes    = array();
    $max_values    = array();

    $optioncount = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "                        <div align=\"center\">\n";
    $polldisplay.= "                        <table width=\"460\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "                            <tr>\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldisplay.= "                                <td style=\"width: 2px; border - left: 1px solid #000000\">&nbsp;</td>\n";
                $poll_group_count++;
            }

            if ($pollresults['VOTES'][$i] > 0) {

                $polldisplay.= "                                <td align=\"center\" valign=\"bottom\">\n";
                $polldisplay.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$pollresults['GROUP_ID'][$i]], 2) * $pollresults['VOTES'][$i]). "px; width: ". round(400 / $optioncount, 2). "px\">\n";
                $polldisplay.= "                                        <tr>\n";
                $polldisplay.= "                                            <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $polldisplay.= "                                        </tr>\n";
                $polldisplay.= "                                    </table>\n";
                $polldisplay.= "                                </td>\n";

            }else {

                $polldisplay.= "                                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $optioncount, 2). "px\">&nbsp;</td>\n";
            }

            $poll_previous_group = $pollresults['GROUP_ID'][$i];

        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $polldisplay.= "                            </tr>\n";
    $polldisplay.= "                            <tr>\n";

    unset($poll_previous_group);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldisplay.= "                                <td style=\"width: 2px; border - left: 1px solid #000000\">&nbsp;</td>\n";
            }

            if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {

                $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);

            }else {

                $vote_percent = 0;
            }

            $polldisplay.= "                                <td class=\"postbody\" align=\"center\" valign=\"top\">". ($pollresults['OPTION_NAME'][$i]). "<br />". $pollresults['VOTES'][$i]. " {$lang['votes']}<br />(". $vote_percent. "%)</td>\n";
            $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }
    }

    $polldisplay.= "                            </tr>\n";
    $polldisplay.= "                        </table>\n";
    $polldisplay.= "                        </div>\n";

    return $polldisplay;
}

function poll_get_table_votes($tid)
{
    $db_poll_get_votes = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID, OPTION_ID FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid'";

    $result_votes = db_query($sql, $db_poll_get_votes);

    $vote_uid    = array();
    $vote_option = array();

    while($row_votes = db_fetch_array($result_votes)) {

        $vote_uid[]    = $row_votes['UID'];
        $vote_option[] = $row_votes['OPTION_ID'];
    }

    $uid_votes = array('UID'       => $vote_uid,
                       'OPTION_ID' => $vote_option);

    return $uid_votes;
}

function poll_table_graph($tid)
{
    $lang = load_language_file();

    $totalvotes = array();
    $max_values = array();

    $optioncount = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    $pollresults = poll_get_votes($tid);
    $polltableresults = poll_get_table_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $groups = array_unique($pollresults['GROUP_ID']);

    $group_keys = array_keys($groups);

    $group1_keys = array_keys($pollresults['GROUP_ID'], $groups[$group_keys[0]]);
    $group2_keys = array_keys($pollresults['GROUP_ID'], $groups[$group_keys[1]]);

    $group1 = array();

    for ($i = 0; $i < sizeof($group1_keys); $i++) {
        $group1[] = $pollresults['OPTION_ID'][$group1_keys[$i]];
    }

    $group2 = array();

    for ($i = 0; $i < sizeof($group2_keys); $i++) {
        $group2[] = $pollresults['OPTION_ID'][$group2_keys[$i]];
    }

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $table[$rows][$cols] = 0;
        }
    }

    for ($i = 0; $i < sizeof($polltableresults['UID']); $i++) {

        if (!isset($poll_previous_uid)) $poll_previous_uid =    - 1;

        if ($poll_previous_uid != $polltableresults['UID'][$i]) {

            $uid_keys = array_keys($polltableresults['UID'], $polltableresults['UID'][$i]);

            if (count($uid_keys) == 2) {

                if (in_array($polltableresults['OPTION_ID'][$uid_keys[0]], $group1)) {

                    $vote_group1 = array_search($polltableresults['OPTION_ID'][$uid_keys[0]], $group1);
                    $vote_group2 = array_search($polltableresults['OPTION_ID'][$uid_keys[1]], $group2);

                }else {

                    $vote_group1 = array_search($polltableresults['OPTION_ID'][$uid_keys[1]], $group1);
                    $vote_group2 = array_search($polltableresults['OPTION_ID'][$uid_keys[0]], $group2);
                }

                $table[$vote_group1][$vote_group2]++;
            }
        }

        $poll_previous_uid = $polltableresults['UID'][$i];
    }

    unset($poll_previous_uid);

    $rowcount = array();
    $numvotes = 0;

    for ($rows = 0; $rows < sizeof($group1); $rows++) {

        $rowcount[] = 0;

        for ($cols = 0; $cols < sizeof($group2); $cols++) {

            $rowcount[$rows]    += $table[$rows][$cols];
            $numvotes    += $table[$rows][$cols];
        }
    }

    $colcount = array();

    for ($cols = 0; $cols < sizeof($group2); $cols++) {

        $colcount[] = 0;

        for ($rows = 0; $rows < sizeof($group1); $rows++) {

            $colcount[$cols]    += $table[$rows][$cols];
        }
    }

    $polldisplay = "                        <table width=\"430\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

    for ($rows = 0; $rows < sizeof($group1) + 2; $rows++) {

        $polldisplay.= "                            <tr>\n";

        for ($cols = 0; $cols < sizeof($group2) + 2; $cols++) {

            if ($cols == 0) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                <td>&nbsp;</td>\n";

                }else {

                    $polldisplay.= "                                <th class=\"posthead\" align=\"right\">". ($pollresults['OPTION_NAME'][$group1_keys[$rows - 1]]). "</th>\n";
                }

            }else if ($cols == sizeof($group2) + 1) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                <td>&nbsp;</td>\n";

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (". round($rowcount[$rows - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (0%)</th>\n";
                    }
                }

            }else {

                if ($rows == 0) {

                    $polldisplay.= "                                <th class=\"posthead\"    align=\"center\">". apply_wordfilter($pollresults['OPTION_NAME'][$group2_keys[$cols - 1]]). "</th>\n";

                }else if ($rows == sizeof($group1) + 1) {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (". round($colcount[$cols - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (0%)</th>\n";
                    }

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (". round($table[$rows - 1][$cols - 1] * 100 / $numvotes, 2). "%)</td>\n";

                    }else {

                        $polldisplay.= "                                <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (0%)</td>\n";
                    }
                }
            }
        }

        $polldisplay.= "                            </tr>\n";
    }

    $polldisplay.= "                        </table>\n";

    return $polldisplay;
}

function poll_public_ballot($tid, $viewstyle)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $totalvotes = array();
    $max_value  = array();

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
            $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $max_values[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }

        if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
            $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
        }else {
            $totalvotes[$pollresults['GROUP_ID'][$i]] += $pollresults['VOTES'][$i];
        }
    }

    $row_class     = (sizeof($max_values) > 1) ? "highlight" : "postbody";
    $table_class = (sizeof($max_values) > 1) ? "box" : "";

    $user_poll_votes = poll_get_user_votes($tid, $viewstyle);

    if ($viewstyle == 0) {

        array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

        $polldisplay = "                        <div align=\"center\">\n";
        $polldisplay.= "                        <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
        $polldisplay.= "                            <tr>\n";

        for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

                if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                    $polldisplay.= "                        </table><br />\n";
                    $polldisplay.= "                        <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
                }

                $polldisplay.= "                            <tr>\n";
                $polldisplay.= "                                <td width=\"150\" class=\"$row_class\" style=\"border - bottom: 1px solid\"><h2>". ($pollresults['OPTION_NAME'][$i]). "</h2></td>\n";

                if ($pollresults['VOTES'][$i] > 0) {

                    if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
                        $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
                    }else {
                        $vote_percent = 0;
                    }

                    $polldisplay.= "                                <td    class=\"$row_class\" style=\"border - bottom: 1px solid\">". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
                    $polldisplay.= "                            </tr>\n";

                    if (isset($user_poll_votes[$pollresults['OPTION_ID'][$i]]) && is_array($user_poll_votes[$pollresults['OPTION_ID'][$i]])) {

                        for ($j = 0; $j < sizeof($user_poll_votes[$pollresults['OPTION_ID'][$i]]); $j++) {

                            if ($user = user_get($user_poll_votes[$pollresults['OPTION_ID'][$i]][$j])) {

                                $polldisplay.= "                            <tr>\n";
                                $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                                $polldisplay.= "                                <td width=\"150\" class=\"$row_class\"><a href=\"javascript:void(0)\" onclick=\"openProfile({$user['UID']}, '$webtag')\">". format_user_name($user['LOGON'], $user['NICKNAME']). "</a></td>\n";
                                $polldisplay.= "                            </tr>\n";
                            }
                        }
                    }

                    $polldisplay.= "                            <tr>\n";
                    $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                            </tr>\n";

                }else {

                    $polldisplay.= "                                <td    class=\"$row_class\" style=\"border - bottom: 1px solid\">0 {$lang['votes']} (0%)</td>\n";
                    $polldisplay.= "                            </tr>\n";
                    $polldisplay.= "                            <tr>\n";
                    $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                            </tr>\n";
                }
            }

            $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }

        $polldisplay.= "                        </table><br />\n";
        $polldisplay.= "                        </div>\n";

    }else {

        $polldisplay = "";

        foreach ($user_poll_votes as $uid => $optionid_array) {

            if ($user = user_get($uid)) {

                $polldisplay.= "                        <div align=\"center\">\n";
                $polldisplay.= "                        <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
                $polldisplay.= "                            <tr>\n";
                $polldisplay.= "                                <td width=\"150\" class=\"$row_class\" style=\"border - bottom: 1px solid\" colspan=\"2\"><h2><a href=\"javascript:void(0)\" onclick=\"openProfile({$user['UID']}, '$webtag')\">". format_user_name($user['LOGON'], $user['NICKNAME']). "</a><h2></td>\n";
                $polldisplay.= "                            </tr>\n";

                for ($i = 0; $i < sizeof($optionid_array); $i++) {

                    $polldisplay.= "                            <tr>\n";
                    $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                <td width=\"150\" class=\"$row_class\">". ($pollresults['OPTION_NAME'][$optionid_array[$i] - 1]). "</td>\n";
                    $polldisplay.= "                            </tr>\n";

                }

                $polldisplay.= "                        </table><br />\n";
                $polldisplay.= "                        </div>\n";
            }
        }
    }

    return $polldisplay;
}

function poll_confirm_close($tid)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if (!$preview_message = messages_get($tid, 1, 1)) {

        edit_refuse($tid, 1);
        return;
    }
    
    if (!$threaddata = thread_get($tid)) {

        edit_refuse($tid, 1);
        return;
    }

    if (bh_session_get_value('UID') != $preview_message['FROM_UID'] && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $threaddata['FID'])) {

        edit_refuse($tid, 1);
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

    $show_sigs = !(bh_session_get_value('VIEW_SIGS'));

    echo "<h1>{$lang['endpoll']}</h1>\n";
    echo "<h2>{$lang['pollconfirmclose']}</h2>\n";

    poll_display($tid, $threaddata['LENGTH'], 1, $threaddata['FID'], false, false, false, true, $show_sigs, true);

    echo "<form name=\"f_delete\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_self\">";
    echo form_input_hidden("webtag", $webtag);
    echo form_input_hidden("tid", $tid);
    echo form_input_hidden("confirm_pollclose", "Y");
    echo "<p align=\"center\">", form_submit("pollclose", $lang['endpoll']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p>\n";
    echo "</form>\n";
}

function poll_close($tid)
{
    $db_poll_close = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FROM_UID FROM {$table_data['PREFIX']}POST WHERE TID = $tid AND PID = 1";
    $result = db_query($sql, $db_poll_close);

    if ($t_fid = thread_get_folder($tid, 1) && (db_num_rows($result) > 0)) {

        $polldata = db_fetch_array($result);

        if (bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            $timestamp = mktime();

            $sql = "UPDATE {$table_data['PREFIX']}POLL SET ";
            $sql.= "CLOSES = FROM_UNIXTIME($timestamp) WHERE TID = $tid";

            $result = db_query($sql, $db_poll_close);
        }
    }
}

function poll_is_closed($tid)
{
    $db_poll_is_closed = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM {$table_data['PREFIX']}POLL WHERE TID = $tid";
    $result = db_query($sql, $db_poll_is_closed);

    if (db_num_rows($result) > 0) {

        $polldata = db_fetch_array($result);
        if (isset($polldata['CLOSES']) && $polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0) return true;
    }

    return false;
}

function poll_vote($tid, $vote_array)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;
    if (!is_array($vote_array)) return false;

    $db_poll_vote = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $polldata = poll_get($tid);
    $vote_count = sizeof($vote_array);

    $timestamp = mktime();

    if ((!poll_get_user_vote($tid)) || ($polldata['CHANGEVOTE'] == 2)) {

        foreach ($vote_array as $user_vote) {

            $sql = "INSERT INTO {$table_data['PREFIX']}USER_POLL_VOTES (TID, UID, OPTION_ID, TSTAMP) ";
            $sql.= "VALUES ($tid, $uid, $user_vote, FROM_UNIXTIME($timestamp))";

            $result = db_query($sql, $db_poll_vote);
        }
    }
}

function poll_delete_vote($tid)
{
    $db_poll_delete_vote = db_connect();

    if (!is_numeric($tid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID = '$uid'";

    $result = db_query($sql, $db_poll_delete_vote);
}

function thread_is_poll($tid)
{
    $db_thread_is_poll = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM {$table_data['PREFIX']}POLL WHERE TID = $tid";
    $result = db_query($sql, $db_thread_is_poll);

    if (db_num_rows($result) > 0) {

        return true;
    }

    return false;
}

function poll_check_tabular_votes($tid, $votes)
{
    $db_poll_check_tabular_votes = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL.POLLTYPE, MAX(POLL_VOTES.GROUP_ID) AS GROUP_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}POLL POLL ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL_VOTES POLL_VOTES ";
    $sql.= "ON (POLL_VOTES.TID = POLL.TID) WHERE POLL.TID = '$tid' GROUP BY POLL.TID";

    $result = db_query($sql, $db_poll_check_tabular_votes);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if ($row['POLLTYPE'] == 2) {

            return (sizeof($votes) == $row['GROUP_COUNT']);

        }else {
            return true;
        }
    }

    return true;
}

?>