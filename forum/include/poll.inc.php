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

/* $Id: poll.inc.php,v 1.205 2007-09-05 19:42:09 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function poll_create($tid, $poll_options, $answer_groups, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $question, $allow_guests)
{
    $db_poll_create = db_connect();

    if (is_numeric($closes)) {
        $closes = "FROM_UNIXTIME($closes)";
    }else {
        $closes = 'NULL';
    }

    if (!is_numeric($tid)) return false;

    if (!is_array($poll_options))  return false;
    if (!is_array($answer_groups)) return false;

    if (!is_numeric($change_vote))    $change_vote    = POLL_VOTE_CAN_CHANGE;
    if (!is_numeric($poll_type))      $poll_type      = POLL_HORIZONTAL_GRAPH;
    if (!is_numeric($show_results))   $show_results   = POLL_SHOW_RESULTS;
    if (!is_numeric($poll_vote_type)) $poll_vote_type = POLL_VOTE_ANON;
    if (!is_numeric($option_type))    $option_type    = POLL_OPTIONS_RADIOS;
    if (!is_numeric($allow_guests))   $allow_guests   = POLL_GUEST_DENIED;

    if (!forum_get_setting('poll_allow_guests', false)) $allow_guests = POLL_GUEST_DENIED;

    $question = db_escape_string(_htmlentities($question));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}POLL (TID, CLOSES, CHANGEVOTE, ";
    $sql.= "POLLTYPE, SHOWRESULTS, VOTETYPE, OPTIONTYPE, QUESTION, ALLOWGUESTS) ";
    $sql.= "VALUES ('$tid', $closes, '$change_vote', '$poll_type', '$show_results', ";
    $sql.= "'$poll_vote_type', '$option_type', '$question', '$allow_guests')";

    if (!$result = db_query($sql, $db_poll_create)) return false;

    foreach ($poll_options as $key => $poll_option) {

        if (strlen(trim($poll_option)) > 0) {

            $option_name  = db_escape_string($poll_option);
            $option_group = (isset($answer_groups[$i]) && is_numeric($answer_groups[$i])) ? $answer_groups[$i] : 1;

            $sql = "INSERT INTO {$table_data['PREFIX']}POLL_VOTES (TID, OPTION_NAME, GROUP_ID) ";
            $sql.= "VALUES ('$tid', '$option_name', '$option_group')";

            if (!$result = db_query($sql, $db_poll_create)) return false;
        }
    }

    return true;
}

function poll_edit($fid, $tid, $thread_title, $poll_question, $poll_options, $answer_groups, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type, $option_type, $allow_guests, $delete_votes)
{
    $db_poll_edit = db_connect();

    if (!is_numeric($tid)) return false;

    if (!is_array($poll_options))  return false;
    if (!is_array($answer_groups)) return false;

    if (!is_numeric($change_vote))    $change_vote    = POLL_VOTE_CAN_CHANGE;
    if (!is_numeric($poll_type))      $poll_type      = POLL_HORIZONTAL_GRAPH;
    if (!is_numeric($show_results))   $show_results   = POLL_SHOW_RESULTS;
    if (!is_numeric($poll_vote_type)) $poll_vote_type = POLL_VOTE_ANON;
    if (!is_numeric($option_type))    $option_type    = POLL_OPTIONS_RADIOS;
    if (!is_numeric($allow_guests))   $allow_guests   = POLL_GUEST_DENIED;

    $thread_title = db_escape_string(_htmlentities($thread_title));
    $poll_question = db_escape_string(_htmlentities($poll_question));

    if (!forum_get_setting('poll_allow_guests', false)) $allow_guests = POLL_GUEST_DENIED;

    $edit_uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD SET TITLE = '$thread_title' WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_edit)) return false;

    if ($delete_votes) {

        $sql = "DELETE QUICK IGNORE FROM {$table_data['PREFIX']}USER_POLL_VOTES WHERE TID = '$tid'";
        if (!$result = db_query($sql, $db_poll_edit)) return false;
    }

    if (is_numeric($closes)) {

        $sql = "UPDATE {$table_data['PREFIX']}POLL SET CHANGEVOTE = '$change_vote', ";
        $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$show_results', ";
        $sql.= "VOTETYPE = '$poll_vote_type', OPTIONTYPE = '$option_type', ";
        $sql.= "QUESTION = '$poll_question', ALLOWGUESTS = '$allow_guests', ";
        $sql.= "CLOSES = FROM_UNIXTIME($closes) WHERE TID = '$tid'";

        if (!$result = db_query($sql, $db_poll_edit)) return false;

    }else {

        $sql = "UPDATE {$table_data['PREFIX']}POLL SET CHANGEVOTE = '$change_vote', ";
        $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$show_results', ";
        $sql.= "VOTETYPE = '$poll_vote_type', OPTIONTYPE = '$option_type', ";
        $sql.= "QUESTION = '$poll_question', ALLOWGUESTS = '$allow_guests' ";
        $sql.= "WHERE TID = '$tid'";

        if (!$result = db_query($sql, $db_poll_edit)) return false;
    }

    $sql = "DELETE QUICK IGNORE FROM {$table_data['PREFIX']}POLL_VOTES WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_edit)) return false;

    foreach ($poll_options as $key => $poll_option) {

        if (strlen(trim($poll_option)) > 0) {

            $option_name  = db_escape_string($poll_option);
            $option_group = (isset($answer_groups[$key]) && is_numeric($answer_groups[$key])) ? $answer_groups[$key] : 1;

            $sql = "INSERT INTO {$table_data['PREFIX']}POLL_VOTES (TID, OPTION_NAME, GROUP_ID) ";
            $sql.= "VALUES ('$tid', '$option_name', '$option_group')";

            if (!$result = db_query($sql, $db_poll_edit)) return false;
        }
    }

    return true;
}

function poll_get($tid)
{
    $db_poll_get = db_connect();

    $lang = load_language_file();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST.VIEWED, ";
    $sql.= "POST.MOVED_TID, POST.MOVED_PID, FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, USER_PEER.RELATIONSHIP, ";
    $sql.= "USER_PEER.PEER_NICKNAME, POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, ";
    $sql.= "POLL.VOTETYPE, POLL.OPTIONTYPE, UNIX_TIMESTAMP(POLL.CLOSES) AS CLOSES, POLL.QUESTION, ";
    $sql.= "UNIX_TIMESTAMP(POST.EDITED) AS EDITED, UNIX_TIMESTAMP(POST.APPROVED) AS APPROVED, ";
    $sql.= "POLL.ALLOWGUESTS, POST.EDITED_BY, POST.APPROVED_BY, POST.IPADDRESS ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN USER FUSER ON (POST.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN USER TUSER ON (POST.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL POLL ON (POST.TID = POLL.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.PID = 1";

    if (!$result = db_query($sql, $db_poll_get)) return false;

    if (db_num_rows($result) > 0) {

        $polldata = db_fetch_array($result);

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

        if (isset($polldata['TLOGON']) && isset($polldata['PTNICK'])) {
            if (!is_null($polldata['PTNICK']) && strlen($polldata['PTNICK']) > 0) {
                $polldata['TNICK'] = $polldata['PTNICK'];
            }
        }

        if (isset($polldata['FLOGON']) && isset($polldata['PFNICK'])) {
            if (!is_null($polldata['PFNICK']) && strlen($polldata['PFNICK']) > 0) {
                $polldata['FNICK'] = $polldata['PFNICK'];
            }
        }

        if (!isset($polldata['FNICK'])) $polldata['FNICK'] = $lang['unknownuser'];
        if (!isset($polldata['FLOGON'])) $polldata['FLOGON'] = $lang['unknownuser'];
        if (!isset($polldata['FROM_UID'])) $polldata['FROM_UID'] = -1;

        if (!isset($polldata['TNICK'])) $polldata['TNICK'] = $lang['allcaps'];
        if (!isset($polldata['TLOGON'])) $polldata['TLOGON'] = $lang['allcaps'];

        return $polldata;
    }

    return false;
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
    $sql.= "WHERE POLL_VOTES.TID = '$tid' GROUP BY POLL_VOTES.OPTION_ID";

    if (!$result = db_query($sql, $db_poll_get_votes)) return false;

    $option_ids    = array();
    $option_names  = array();
    $option_groups = array();
    $option_votes  = array();
    $group_size    = array();

    $poll_results = array();

    while($poll_data = db_fetch_array($result)) {

        $option_ids[]    = $poll_data['OPTION_ID'];
        $option_names[]  = $poll_data['OPTION_NAME'];
        $option_groups[] = $poll_data['GROUP_ID'];
        $option_votes[]  = $poll_data['VOTE_COUNT'];

        if (!isset($group_size[$poll_data['GROUP_ID']])) {
            $group_size[$poll_data['GROUP_ID']] = 0;
        }

        $group_size[$poll_data['GROUP_ID']]++;
    }

    $poll_results = array('OPTION_ID'   => $option_ids,
                         'OPTION_NAME' => $option_names,
                         'GROUP_ID'    => $option_groups,
                         'VOTES'       => $option_votes,
                         'GROUP_SIZE'  => $group_size);

    return $poll_results;
}

function poll_get_total_votes($tid, &$total_votes, &$guestvotes)
{
    $db_poll_get_total_votes = db_connect();

    if (!is_numeric($tid)) return 0;
    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(DISTINCT UID) FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID > 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($total_votes) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID = 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($guestvotes) = db_fetch_array($result, DB_RESULT_NUM);

    return true;
}

function poll_get_user_votes($tid, $viewstyle)
{
    $db_poll_get_user_vote_hashes = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($viewstyle)) $viewstyle = POLL_VIEW_TYPE_OPTION;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UP.UID, UP.OPTION_ID, UNIX_TIMESTAMP(UP.TSTAMP) AS TSTAMP ";
    $sql.= "FROM {$table_data['PREFIX']}USER_POLL_VOTES UP ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL POLL ON (UP.TID = POLL.TID) ";
    $sql.= "WHERE UP.TID = '$tid' AND POLL.VOTETYPE = 1 ";
    $sql.= "AND UP.UID > 0";

    if (!$result = db_query($sql, $db_poll_get_user_vote_hashes)) return false;

    $poll_get_user_votes = array();

    while($poll_data = db_fetch_array($result)) {

        if ($viewstyle == POLL_VIEW_TYPE_OPTION) {
            $poll_get_user_votes[$poll_data['OPTION_ID']][] = $poll_data['UID'];
        }else {
            $poll_get_user_votes[$poll_data['UID']][] = $poll_data['OPTION_ID'];
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

    if (user_is_guest()) return false;

    $sql = "SELECT OPTION_ID, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP ";
    $sql.= "FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_get_user_vote)) return false;

    if (db_num_rows($result) > 0) {

        $user_poll_data = array();

        while($poll_data = db_fetch_array($result)) {

            $user_poll_data[] = $poll_data;
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
    $poll_results  = poll_get_votes($tid);
    $user_poll_data = poll_get_user_vote($tid);

    if (isset($polldata['QUESTION']) && strlen(trim(_stripslashes($polldata['QUESTION']))) > 0) {
        $question = $polldata['QUESTION'];
    } else {
        $question = thread_get_title($tid);
    }

    $total_votes  = 0;
    $option_count = 0;

    $polldata['CONTENT'] = "<br />\n";
    $polldata['CONTENT'].= "                <div align=\"center\">\n";
    $polldata['CONTENT'].= "                <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    $polldata['CONTENT'].= "                  <tr>\n";
    $polldata['CONTENT'].= "                    <td align=\"left\">\n";
    $polldata['CONTENT'].= "                      <form method=\"post\" action=\"". $_SERVER['PHP_SELF']. "\" target=\"_self\">\n";
    $polldata['CONTENT'].= "                        ". form_input_hidden("webtag", _htmlentities($webtag)). "\n";
    $polldata['CONTENT'].= "                        ". form_input_hidden('tid', _htmlentities($tid)). "\n";
    $polldata['CONTENT'].= "                        <table width=\"450\">\n";
    $polldata['CONTENT'].= "                          <tr>\n";
    $polldata['CONTENT'].= "                            <td align=\"left\"><h2>". word_filter_add_ob_tags($question). "</h2></td>\n";
    $polldata['CONTENT'].= "                          </tr>\n";

    $poll_group_count = 1;

    if ($in_list) {

        if (((!is_array($user_poll_data) || $polldata['CHANGEVOTE'] == POLL_VOTE_MULTI) && (bh_session_get_value('UID') > 0 || ($polldata['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > mktime()) && !$is_preview) {

            $polldata['CONTENT'].= "                          <tr>\n";
            $polldata['CONTENT'].= "                            <td align=\"left\">\n";
            $polldata['CONTENT'].= "                              <table width=\"100%\">\n";

            array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

            for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

                if (!isset($poll_previous_group)) {
                    $poll_previous_group = $poll_results['GROUP_ID'][$i];
                }

                if (strlen(trim($poll_results['OPTION_NAME'][$i])) > 0) {

                    if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                        if ($polldata['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i - 1]] > 1) {

                            $polldata['CONTENT'].= "                                <tr>\n";
                            $polldata['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$i - 1]}]", $dropdown, false, false). "</td>\n";
                            $polldata['CONTENT'].= "                                </tr>\n";

                        }else {

                            $polldata['CONTENT'].= "                                <tr>\n";
                            $polldata['CONTENT'].= "                                  <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                            $polldata['CONTENT'].= "                                <tr>\n";
                        }

                        unset($drop_down_data);

                        $poll_group_count++;
                    }

                    if ($poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]] > 1) {

                        if ($polldata['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                            $drop_down_data[$poll_results['OPTION_ID'][$i]] = word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]);

                        }else {

                            $polldata['CONTENT'].= "                                <tr>\n";
                            $polldata['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[{$poll_results['GROUP_ID'][$i]}]", $poll_results['OPTION_ID'][$i], '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";
                            $polldata['CONTENT'].= "                                </tr>\n";
                        }

                    }else {

                        $polldata['CONTENT'].= "                                <tr>\n";
                        $polldata['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[{$poll_results['GROUP_ID'][$i]}]", $poll_results['OPTION_ID'][$i], '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";
                        $polldata['CONTENT'].= "                                </tr>\n";
                    }

                    $poll_previous_group = $poll_results['GROUP_ID'][$i];
                }

                if ($i == sizeof($poll_results['OPTION_ID']) - 1) {

                    if ($polldata['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]] > 1) {

                        $polldata['CONTENT'].= "                                <tr>\n";
                        $polldata['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$i]}]", $drop_down_data, false, false). "</td>\n";
                        $polldata['CONTENT'].= "                                </tr>\n";

                    }
                }
            }

            $polldata['CONTENT'].= "                              </table>\n";
            $polldata['CONTENT'].= "                            </td>\n";
            $polldata['CONTENT'].= "                          </tr>\n";

        }else {

            if ($polldata['SHOWRESULTS'] == POLL_SHOW_RESULTS || ($polldata['CLOSES'] > 0 && $polldata['CLOSES'] < mktime())) {

                if ($polldata['POLLTYPE'] == POLL_HORIZONTAL_GRAPH) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_horizontal_graph($tid);
                    $polldata['CONTENT'].= "                            </td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";

                }else if ($polldata['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_vertical_graph($tid);
                    $polldata['CONTENT'].= "                            </td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";

                }else if ($polldata['POLLTYPE'] == POLL_TABLE_GRAPH) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_table_graph($tid);
                    $polldata['CONTENT'].= "                            </td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";

                }else {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $polldata['CONTENT'].= poll_public_ballot($tid);
                    $polldata['CONTENT'].= "                            </td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                }

            }else {

                for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

                    if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

                    if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

                        if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                            $polldata['CONTENT'].= "                          <tr>\n";
                            $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                            $polldata['CONTENT'].= "                          <tr>\n";

                            $poll_group_count++;
                        }

                        $polldata['CONTENT'].= "                          <tr>\n";
                        $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";
                        $polldata['CONTENT'].= "                          </tr>\n";

                        $poll_previous_group = $poll_results['GROUP_ID'][$i];
                    }
                }
            }
        }

    }else {

        $polldata['CONTENT'].= "                          <tr>\n";
        $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">\n";
        $polldata['CONTENT'].= "                              <ul>\n";

        for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

            if (strlen($poll_results['OPTION_NAME'][$i]) > 0) {

                $polldata['CONTENT'].= "                                <li>". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</li>\n";
            }
        }

        $polldata['CONTENT'].= "                              </ul>\n";
        $polldata['CONTENT'].= "                            </td>\n";
        $polldata['CONTENT'].= "                          </tr>\n";

    }

    if ($in_list && !$is_preview) {

        $group_array = array();

        for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

            if (!in_array($poll_results['GROUP_ID'][$i], $group_array)) {
                    $group_array[] = $poll_results['GROUP_ID'][$i];
            }
        }

        poll_get_total_votes($tid, $total_votes, $guestvotes);
        $poll_group_count = sizeof($group_array);

        $polldata['CONTENT'].= "                          <tr>\n";
        $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $polldata['CONTENT'].= "                          </tr>\n";
        $polldata['CONTENT'].= "                          <tr>\n";
        $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". poll_format_vote_counts($polldata, $total_votes, $guestvotes). "</td>\n";
        $polldata['CONTENT'].= "                          </tr>\n";
        $polldata['CONTENT'].= "                          <tr>\n";
        $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $polldata['CONTENT'].= "                          </tr>\n";

        if (($polldata['CLOSES'] <= mktime()) && $polldata['CLOSES'] != 0) {

            $polldata['CONTENT'].= "                          <tr>\n";
            $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
            $polldata['CONTENT'].= "                          </tr>\n";

            if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['CHANGEVOTE'] < POLL_VOTE_MULTI && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $polldata['CONTENT'].= "                          </tr>\n";
                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_button("pollresults", $lang['resultdetails'], "onclick=\"openPollResults('$tid', '$webtag');\""). "</td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";
                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $polldata['CONTENT'].= "                          </tr>\n";
            }

            if (is_array($user_poll_data) && isset($user_poll_data[0]['TSTAMP'])) {

                $user_poll_votes_array = array();

                for ($i = 0; $i < sizeof($user_poll_data); $i++) {

                    for ($j = 0; $j < sizeof($poll_results['OPTION_ID']); $j++) {

                        if ($user_poll_data[$i]['OPTION_ID'] == $poll_results['OPTION_ID'][$j]) {

                            if ($poll_results['OPTION_NAME'][$j] == strip_tags($poll_results['OPTION_NAME'][$j])) {

                                $user_poll_votes_array[] = "'". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$j]). "'";

                            }else {

                                $user_poll_votes_array[] = "Option {$user_poll_data[$i]['OPTION_ID']}";
                            }
                        }
                    }
                }

                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptionsondate'], implode(' &amp; ', $user_poll_votes_array), format_time($user_poll_data[0]['TSTAMP'], true)). "</td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";
            }

        }else {

            if (is_array($user_poll_data) && isset($user_poll_data[0]['TSTAMP'])) {

                $user_poll_votes_array = array();

                for ($i = 0; $i < sizeof($user_poll_data); $i++) {

                    for ($j = 0; $j < sizeof($poll_results['OPTION_ID']); $j++) {

                        if ($user_poll_data[$i]['OPTION_ID'] == $poll_results['OPTION_ID'][$j]) {

                            if ($poll_results['OPTION_NAME'][$j] == strip_tags($poll_results['OPTION_NAME'][$j])) {

                                $user_poll_votes_array[] = "'". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$j]). "'";

                            }else {

                                $user_poll_votes_array[] = "Option {$user_poll_data[$i]['OPTION_ID']}";
                            }
                        }
                    }
                }

                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptionsondate'], implode(' &amp; ', $user_poll_votes_array), format_time($user_poll_data[0]['TSTAMP'], true)). "</td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";
                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";

                if ($polldata['CHANGEVOTE'] == POLL_VOTE_MULTI) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                }

                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">";

                if (($polldata['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['CHANGEVOTE'] < POLL_VOTE_MULTI && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"openPollResults('$tid', '$webtag')\"");

                    }else {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"openPollResults('$tid', '$webtag')\"");

                    }
                }

                if (bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    $polldata['CONTENT'].= "                &nbsp;". form_submit('pollclose', $lang['endpoll']);
                }

                $polldata['CONTENT'].= "                            </td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";

                if ($polldata['CHANGEVOTE'] != 0) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                }

                if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['CHANGEVOTE'] < POLL_VOTE_MULTI && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                }

            }else if (bh_session_get_value('UID') > 0 || ($polldata['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false))) {

                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";
                $polldata['CONTENT'].= "                          <tr>\n";
                $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">";

                if (($polldata['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['CHANGEVOTE'] < POLL_VOTE_MULTI && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"openPollResults('$tid', '$webtag')\"");

                    }else {

                        $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"openPollResults('$tid', '$webtag')\"");
                    }
                }

                if (bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    $polldata['CONTENT'].= "                &nbsp;". form_submit('pollclose', $lang['endpoll']);

                }

                $polldata['CONTENT'].= "                            </td>\n";
                $polldata['CONTENT'].= "                          </tr>\n";

                if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['CHANGEVOTE'] < POLL_VOTE_MULTI && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                    $polldata['CONTENT'].= "                          <tr>\n";
                    $polldata['CONTENT'].= "                            <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $polldata['CONTENT'].= "                          </tr>\n";
                }
            }
        }
    }

    $polldata['CONTENT'].= "                        </table>\n";
    $polldata['CONTENT'].= "                      </form>\n";
    $polldata['CONTENT'].= "                    </td>\n";
    $polldata['CONTENT'].= "                  </tr>\n";
    $polldata['CONTENT'].= "                </table>\n";
    $polldata['CONTENT'].= "                </div>\n";
    $polldata['CONTENT'].= "                <br />\n";

    $polldata['FROM_RELATIONSHIP'] = user_get_relationship(bh_session_get_value('UID'), $polldata['FROM_UID']);

    message_display($tid, $polldata, $msg_count, $first_msg, $folder_fid, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);
}

function poll_format_vote_counts($polldata, $user_votes, $guest_votes)
{
    $html = "";

    $lang = load_language_file();

    if ($user_votes == 0) {
        $user_votes_display = $lang['nousersvoted'];
    }elseif ($user_votes == 1) {
        $user_votes_display = $lang['oneuservoted'];
    }else {
        $user_votes_display = sprintf($lang['xusersvoted'], $user_votes);
    }

    if ($guest_votes == 0) {
        $guest_votes_display = $lang['noguestsvoted'];
    }elseif ($guest_votes == 1) {
        $guest_votes_display = $lang['oneguestvoted'];
    }else {
        $guest_votes_display = sprintf($lang['xguestsvoted'], $guest_votes);
    }

    if ($polldata['CLOSES'] > 0 && $polldata['CLOSES'] <= mktime()) {
        if ($user_votes > 0 || $guest_votes > 0) {
            $html.= sprintf("<b>{$lang['votedisplayclosedpoll']}</b>", $user_votes_display, $guest_votes_display);
        }else {
            $html.= $lang['nobodyvotedclosedpoll'];
        }
    }elseif ($polldata['CLOSES'] == 0 || ($polldata['CLOSES'] > mktime())) {
        if ($user_votes > 0 || $guest_votes > 0) {
            $html.= sprintf("<b>{$lang['votedisplayopenpoll']}</b>", $user_votes_display, $guest_votes_display);
        }else {
            $html.= $lang['nobodyvotedclosedpoll'];
        }
    }

    return $html;
}

function poll_preview_form($poll_results, $polldata)
{
    $lang = load_language_file();

    $poll_group_count = 1;

    for ($i = 0; $i < sizeof($poll_results['GROUP_ID']); $i++) {

        if (!isset($poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]]))         {
            $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]] = 1;
        }else {
            $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]]++;
        }
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $polldisplay = "                              <div align=\"center\">\n";
    $polldisplay.= "                              <table width=\"100%\">\n";

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) {
            $poll_previous_group = $poll_results['GROUP_ID'][$i];
        }

        if (strlen(trim($poll_results['OPTION_NAME'][$i])) > 0) {

            if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                if ($polldata['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i - 1]] > 1) {

                    $polldisplay.= "                      <tr>\n";
                    $polldisplay.= "                        <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
                    $polldisplay.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$i - 1]}]", $drop_down_data, false, false). "</td>\n";
                    $polldisplay.= "                      </tr>\n";

                }else {

                    $polldisplay.= "                      <tr>\n";
                    $polldisplay.= "                        <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                    $polldisplay.= "                      <tr>\n";
                }

                unset($drop_down_data);

                $poll_group_count++;
            }

            if ($poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]] > 1) {

                if ($polldata['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                    $drop_down_data[$poll_results['OPTION_ID'][$i]] = word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]);

                }else {

                    $polldisplay.= "                      <tr>\n";
                    $polldisplay.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[{$poll_results['GROUP_ID'][$i]}]", $poll_results['OPTION_ID'][$i], '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";
                    $polldisplay.= "                      </tr>\n";
                }

            }else {

                $polldisplay.= "                      <tr>\n";
                $polldisplay.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[{$poll_results['GROUP_ID'][$i]}]", $poll_results['OPTION_ID'][$i], '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";
                $polldisplay.= "                      </tr>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$i];
        }

        if ($i == sizeof($poll_results['OPTION_ID']) - 1) {

            if ($polldata['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$i]] > 1) {

                $polldisplay.= "                      <tr>\n";
                $polldisplay.= "                        <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
                $polldisplay.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$i]}]", $drop_down_data, false, false). "</td>\n";
                $polldisplay.= "                      </tr>\n";

            }
        }
    }

    $polldisplay.= "                              </table>\n";
    $polldisplay.= "                              </div>\n";

    return $polldisplay;
}

function poll_preview_graph_horz($poll_results)
{
    $lang = load_language_file();

    $total_votes    = array();
    $max_values    = array();

    $bar_color = 1;

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $polldisplay = "                              <div align=\"center\">\n";
    $polldisplay.= "                              <table width=\"100%\">\n";

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

        if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

            $polldisplay.= "                                <tr>\n";
            $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";

            if ($poll_results['VOTES'][$i] > 0) {

                $polldisplay.= "                                  <td align=\"left\" width=\"300\">\n";
                $polldisplay.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$poll_results['GROUP_ID'][$i]], 2) * $poll_results['VOTES'][$i]). "px\">\n";
                $polldisplay.= "                                      <tr>\n";
                $polldisplay.= "                                        <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $polldisplay.= "                                      </tr>\n";
                $polldisplay.= "                                    </table>\n";
                $polldisplay.= "                                  </td>\n";

            }else {

                $polldisplay.= "                                  <td align=\"left\" class=\"postbody\" height=\"25\">&nbsp;</td>\n";
            }

            if (isset($total_votes[$poll_results['GROUP_ID'][$i]]) && $total_votes[$poll_results['GROUP_ID'][$i]] > 0) {
                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$i]]) * $poll_results['VOTES'][$i], 2);
            }else {
                $vote_percent = 0;
            }

            $polldisplay.= "                                </tr>\n";
            $polldisplay.= "                                <tr>\n";
            $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"postbody\">&nbsp;</td>\n";
            $polldisplay.= "                                  <td align=\"left\" class=\"postbody\" height=\"20\">". $poll_results['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
            $polldisplay.= "                                </tr>\n";

            $poll_previous_group = $poll_results['GROUP_ID'][$i];

        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $polldisplay.= "                              </table>\n";
    $polldisplay.= "                              </div>\n";

    return $polldisplay;
}

function poll_preview_graph_vert($poll_results)
{
    $lang = load_language_file();

    $total_votes    = array();
    $max_value     = array();

    $option_count = 0;
    $bar_color     = 1;

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $polldisplay = "                              <div align=\"center\">\n";
    $polldisplay.= "                              <table width=\"460\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "                                <tr>\n";

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

        if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

            if ($poll_results['VOTES'][$i] > 0) {

                if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {
                    $polldisplay.= "                            <td align=\"left\" style=\"width: 2px; border - left: 1px solid #000000\">&nbsp;</td>\n";
                }

                $polldisplay.= "                                  <td align=\"center\" valign=\"bottom\">\n";
                $polldisplay.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$poll_results['GROUP_ID'][$i]], 2) * $poll_results['VOTES'][$i]). "px; width: ". round(400 / $option_count, 2). "px\">\n";
                $polldisplay.= "                                      <tr>\n";
                $polldisplay.= "                                        <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $polldisplay.= "                                      </tr>\n";
                $polldisplay.= "                                    </table>\n";
                $polldisplay.= "                                  </td>\n";

            }else {

                $polldisplay.= "                                  <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $option_count, 2). "px\">&nbsp;</td>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$i];
        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $polldisplay.= "                                </tr>\n";
    $polldisplay.= "                                <tr>\n";

    unset($poll_previous_group);

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

        if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

            if (isset($total_votes[$poll_results['GROUP_ID'][$i]]) && $total_votes[$poll_results['GROUP_ID'][$i]] > 0) {
                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$i]]) * $poll_results['VOTES'][$i], 2);
            }else {
                $vote_percent = 0;
            }

            if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldisplay.= "                                  <td align=\"left\" style=\"width: 2px; border - left: 1px solid #000000\">&nbsp;</td>\n";
            }

            $polldisplay.= "                                  <td class=\"postbody\" align=\"center\" valign=\"top\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "<br />". $poll_results['VOTES'][$i]. " {$lang['votes']}<br />(". $vote_percent. "%)</td>\n";
            $poll_previous_group = $poll_results['GROUP_ID'][$i];
        }
    }

    $polldisplay.= "                                </tr>\n";
    $polldisplay.= "                              </table>\n";
    $polldisplay.= "                              </div>\n";

    return $polldisplay;
}

function poll_horizontal_graph($tid)
{
    $lang = load_language_file();

    $total_votes    = array();
    $max_values    = array();

    $bar_color = 1;
    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $polldisplay = "                              <div align=\"center\">\n";
    $polldisplay.= "                              <table width=\"100%\">\n";

    if (sizeof($poll_results['OPTION_ID']) > 0) {

        for ($i = 0; $i <= sizeof($poll_results['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

            if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

                if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                    $polldisplay.= "                              <tr>\n";
                    $polldisplay.= "                                <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                    $polldisplay.= "                              </tr>\n";

                    $poll_group_count++;
                }

                $polldisplay.= "                              <tr>\n";
                $polldisplay.= "                                <td align=\"left\" width=\"150\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$i]). "</td>\n";

                if ($poll_results['VOTES'][$i] > 0) {

                    $polldisplay.= "                                <td align=\"left\" width=\"300\">\n";
                    $polldisplay.= "                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$poll_results['GROUP_ID'][$i]], 2) * $poll_results['VOTES'][$i]). "px\">\n";
                    $polldisplay.= "                                    <tr>\n";
                    $polldisplay.= "                                      <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                    $polldisplay.= "                                    </tr>\n";
                    $polldisplay.= "                                  </table>\n";
                    $polldisplay.= "                                </td>\n";

                }else {

                    $polldisplay.= "                                <td align=\"left\" class=\"postbody\" height=\"25\">&nbsp;</td>\n";
                }

                if (isset($total_votes[$poll_results['GROUP_ID'][$i]]) && $total_votes[$poll_results['GROUP_ID'][$i]] > 0) {
                    $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$i]]) * $poll_results['VOTES'][$i], 2);
                }else {
                    $vote_percent = 0;
                }

                $polldisplay.= "                              </tr>\n";
                $polldisplay.= "                              <tr>\n";
                $polldisplay.= "                                <td align=\"left\" width=\"150\" class=\"postbody\">&nbsp;</td>\n";
                $polldisplay.= "                                <td align=\"left\" class=\"postbody\" height=\"20\">". $poll_results['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
                $polldisplay.= "                              </tr>\n";

                $poll_previous_group = $poll_results['GROUP_ID'][$i];
            }

            $bar_color++;
            if ($bar_color > 5) $bar_color = 1;
        }
    }

    $polldisplay.= "                              </table>\n";
    $polldisplay.= "                              </div>\n";

    return $polldisplay;

}

function poll_preview_graph_table($poll_results)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_value  = array();

    $option_count = 0;
    $bar_color   = 1;

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
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
        $blank1[] = 0;
    }

    $group2 = array();

    for ($i = 0; $i < sizeof($group2_keys); $i++) {
        $group2[] = $poll_results['OPTION_ID'][$group2_keys[$i]];
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

    $polldisplay = "                              <table width=\"460\" align=\"center\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

    for ($rows = 0; $rows < sizeof($group1) + 2; $rows++) {

        $polldisplay.= "                                <tr>\n";

        for ($cols = 0; $cols < sizeof($group2) + 2; $cols++) {

            if ($cols == 0) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    $polldisplay.= "                                  <th class=\"posthead\" align=\"right\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group1_keys[$rows - 1]]). "</th>\n";
                }

            }else if ($cols == sizeof($group2) + 1) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (". round($rowcount[$rows - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (0%)</th>\n";
                    }
                }

            }else {

                if ($rows == 0) {

                    $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group2_keys[$cols - 1]]). "</th>\n";

                }else if ($rows == sizeof($group1) + 1) {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (". round($colcount[$cols - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (0%)</th>\n";
                    }

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                  <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (". round($table[$rows - 1][$cols - 1] * 100 / $numvotes, 2). "%)</td>\n";

                    }else {

                        $polldisplay.= "                                  <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (0%)</td>\n";
                    }
                }

            }
        }

        $polldisplay.= "                                </tr>\n";
    }

    $polldisplay.= "                              </table>\n";

    return $polldisplay;
}

function poll_vertical_graph($tid)
{
    $lang = load_language_file();

    $total_votes    = array();
    $max_values    = array();

    $option_count = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        $option_count++;
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $polldisplay = "                              <div align=\"center\">\n";
    $polldisplay.= "                              <table width=\"460\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "                                <tr>\n";

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

        if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

            if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldisplay.= "                                <td align=\"left\" style=\"width: 2px; border - left: 1px solid #000000\">&nbsp;</td>\n";
                $poll_group_count++;
            }

            if ($poll_results['VOTES'][$i] > 0) {

                $polldisplay.= "                                <td align=\"center\" valign=\"bottom\">\n";
                $polldisplay.= "                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$poll_results['GROUP_ID'][$i]], 2) * $poll_results['VOTES'][$i]). "px; width: ". round(400 / $option_count, 2). "px\">\n";
                $polldisplay.= "                                    <tr>\n";
                $polldisplay.= "                                      <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $polldisplay.= "                                    </tr>\n";
                $polldisplay.= "                            </table>\n";
                $polldisplay.= "                                </td>\n";

            }else {

                $polldisplay.= "                                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $option_count, 2). "px\">&nbsp;</td>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$i];

        }

        $bar_color++;
        if ($bar_color > 5) $bar_color = 1;
    }

    $polldisplay.= "                                </tr>\n";
    $polldisplay.= "                                <tr>\n";

    unset($poll_previous_group);

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

        if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

            if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldisplay.= "                                  <td align=\"left\" style=\"width: 2px; border - left: 1px solid #000000\">&nbsp;</td>\n";
            }

            if (isset($total_votes[$poll_results['GROUP_ID'][$i]]) && $total_votes[$poll_results['GROUP_ID'][$i]] > 0) {

                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$i]]) * $poll_results['VOTES'][$i], 2);

            }else {

                $vote_percent = 0;
            }

            $polldisplay.= "                                  <td class=\"postbody\" align=\"center\" valign=\"top\">". ($poll_results['OPTION_NAME'][$i]). "<br />". $poll_results['VOTES'][$i]. " {$lang['votes']}<br />(". $vote_percent. "%)</td>\n";
            $poll_previous_group = $poll_results['GROUP_ID'][$i];
        }
    }

    $polldisplay.= "                                </tr>\n";
    $polldisplay.= "                              </table>\n";
    $polldisplay.= "                              </div>\n";

    return $polldisplay;
}

function poll_get_table_votes($tid)
{
    $db_poll_get_votes = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID, OPTION_ID FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid'";

    if (!$result_votes = db_query($sql, $db_poll_get_votes)) return false;

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

    $total_votes = array();
    $max_values = array();

    $option_count = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);
    $polltableresults = poll_get_table_votes($tid);

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]] += $poll_results['VOTES'][$i];
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

    $polldisplay = "                              <table width=\"430\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

    for ($rows = 0; $rows < sizeof($group1) + 2; $rows++) {

        $polldisplay.= "                                <tr>\n";

        for ($cols = 0; $cols < sizeof($group2) + 2; $cols++) {

            if ($cols == 0) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    $polldisplay.= "                                  <th class=\"posthead\" align=\"right\">". ($poll_results['OPTION_NAME'][$group1_keys[$rows - 1]]). "</th>\n";
                }

            }else if ($cols == sizeof($group2) + 1) {

                if (($rows == 0) || ($rows == sizeof($group1) + 1)) {

                    $polldisplay.= "                                  <td align=\"left\">&nbsp;</td>\n";

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (". round($rowcount[$rows - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $rowcount[$rows - 1]. " (0%)</th>\n";
                    }
                }

            }else {

                if ($rows == 0) {

                    $polldisplay.= "                                  <th class=\"posthead\"    align=\"center\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group2_keys[$cols - 1]]). "</th>\n";

                }else if ($rows == sizeof($group1) + 1) {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (". round($colcount[$cols - 1] * 100 / $numvotes, 2). "%)</th>\n";

                    }else {

                        $polldisplay.= "                                  <th class=\"posthead\" align=\"center\">". $colcount[$cols - 1]. " (0%)</th>\n";
                    }

                }else {

                    if ($numvotes > 0) {

                        $polldisplay.= "                                  <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (". round($table[$rows - 1][$cols - 1] * 100 / $numvotes, 2). "%)</td>\n";

                    }else {

                        $polldisplay.= "                                  <td align=\"center\">". $table[$rows - 1][$cols - 1]. " (0%)</td>\n";
                    }
                }
            }
        }

        $polldisplay.= "                                </tr>\n";
    }

    $polldisplay.= "                              </table>\n";

    return $polldisplay;
}

function poll_public_ballot($tid, $viewstyle)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $total_votes = array();
    $max_value   = array();

    $poll_results = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

        if (!isset($max_values[$poll_results['GROUP_ID'][$i]])) {
            $max_values[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $max_values[$poll_results['GROUP_ID'][$i]]+= $poll_results['VOTES'][$i];
        }

        if (!isset($total_votes[$poll_results['GROUP_ID'][$i]])) {
            $total_votes[$poll_results['GROUP_ID'][$i]] = $poll_results['VOTES'][$i];
        }else {
            $total_votes[$poll_results['GROUP_ID'][$i]]+= $poll_results['VOTES'][$i];
        }
    }

    $row_class   = (sizeof($max_values) > 1) ? "highlight" : "postbody";
    $table_class = (sizeof($max_values) > 1) ? "box" : "";

    $user_poll_votes = poll_get_user_votes($tid, $viewstyle);

    if ($viewstyle == POLL_VIEW_TYPE_OPTION) {

        array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

        $polldisplay = "                              <div align=\"center\">\n";
        $polldisplay.= "                              <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
        $polldisplay.= "                                <tr>\n";

        for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

            if (isset($poll_results['OPTION_NAME'][$i]) && strlen($poll_results['OPTION_NAME'][$i]) > 0) {

                if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                    $polldisplay.= "                              </table><br />\n";
                    $polldisplay.= "                              <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
                }

                $polldisplay.= "                                <tr>\n";
                $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\" style=\"border-bottom: 1px solid\"><h2>{$poll_results['OPTION_NAME'][$i]}</h2></td>\n";

                if ($poll_results['VOTES'][$i] > 0) {

                    if (isset($total_votes[$poll_results['GROUP_ID'][$i]]) && $total_votes[$poll_results['GROUP_ID'][$i]] > 0) {
                        $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$i]]) * $poll_results['VOTES'][$i], 2);
                    }else {
                        $vote_percent = 0;
                    }

                    $polldisplay.= "                                  <td align=\"left\"    class=\"$row_class\" style=\"border-bottom: 1px solid\">{$poll_results['VOTES'][$i]} {$lang['votes']} ({$vote_percent}%)</td>\n";
                    $polldisplay.= "                                </tr>\n";

                    if (isset($user_poll_votes[$poll_results['OPTION_ID'][$i]]) && is_array($user_poll_votes[$poll_results['OPTION_ID'][$i]])) {

                        for ($j = 0; $j < sizeof($user_poll_votes[$poll_results['OPTION_ID'][$i]]); $j++) {

                            if ($user = user_get($user_poll_votes[$poll_results['OPTION_ID'][$i]][$j])) {

                                $polldisplay.= "                                <tr>\n";
                                $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                                $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user['UID']}, '$webtag')\">". word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME'])). "</a></td>\n";
                                $polldisplay.= "                                </tr>\n";
                            }
                        }
                    }

                    $polldisplay.= "                                <tr>\n";
                    $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                </tr>\n";

                }else {

                    $polldisplay.= "                                  <td align=\"left\"    class=\"$row_class\" style=\"border - bottom: 1px solid\">0 {$lang['votes']} (0%)</td>\n";
                    $polldisplay.= "                                </tr>\n";
                    $polldisplay.= "                                <tr>\n";
                    $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                </tr>\n";
                }
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$i];
        }

        $polldisplay.= "                              </table><br />\n";
        $polldisplay.= "                              </div>\n";

    }else {

        $polldisplay = "";

        foreach ($user_poll_votes as $uid => $option_id_array) {

            if ($user = user_get($uid)) {

                $polldisplay.= "                              <div align=\"center\">\n";
                $polldisplay.= "                              <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
                $polldisplay.= "                                <tr>\n";
                $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\" style=\"border-bottom: 1px solid\" colspan=\"2\"><h2><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user['UID']}, '$webtag')\">". word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME'])). "</a></h2></td>\n";
                $polldisplay.= "                                </tr>\n";

                for ($i = 0; $i < sizeof($option_id_array); $i++) {

                    $polldisplay.= "                                <tr>\n";
                    $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $polldisplay.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">". ($poll_results['OPTION_NAME'][$option_id_array[$i] - 1]). "</td>\n";
                    $polldisplay.= "                                </tr>\n";

                }

                $polldisplay.= "                              </table><br />\n";
                $polldisplay.= "                              </div>\n";
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
    echo form_input_hidden("webtag", _htmlentities($webtag));
    echo form_input_hidden("tid", _htmlentities($tid));
    echo form_input_hidden("confirm_pollclose", "Y");
    echo "<p align=\"center\">", form_submit("pollclose", $lang['endpoll']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p>\n";
    echo "</form>\n";
}

function poll_close($tid)
{
    $db_poll_close = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FROM_UID FROM {$table_data['PREFIX']}POST WHERE TID = '$tid' AND PID = 1";

    if (!$result = db_query($sql, $db_poll_close)) return false;

    if ($t_fid = thread_get_folder($tid, 1) && (db_num_rows($result) > 0)) {

        $polldata = db_fetch_array($result);

        if (bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            $timestamp = mktime();

            $sql = "UPDATE {$table_data['PREFIX']}POLL SET ";
            $sql.= "CLOSES = FROM_UNIXTIME($timestamp) WHERE TID = '$tid'";

            if (!$result = db_query($sql, $db_poll_close)) return false;
        }
    }
}

function poll_is_closed($tid)
{
    $db_poll_is_closed = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM {$table_data['PREFIX']}POLL WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_is_closed)) return false;

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

    if ((!poll_get_user_vote($tid)) || ($polldata['CHANGEVOTE'] == POLL_VOTE_MULTI) || (user_is_guest() && ($polldata['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) {

        foreach ($vote_array as $user_vote) {

            if (is_numeric($user_vote)) {

                $sql = "INSERT INTO {$table_data['PREFIX']}USER_POLL_VOTES (TID, UID, OPTION_ID, TSTAMP) ";
                $sql.= "VALUES ('$tid', '$uid', '$user_vote', NOW())";

                if (!$result = db_query($sql, $db_poll_vote)) return false;
            }
        }
    }
}

function poll_delete_vote($tid)
{
    $db_poll_delete_vote = db_connect();

    if (!is_numeric($tid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK IGNORE FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID = '$uid'";

    if (!$result = db_query($sql, $db_poll_delete_vote)) return false;
}

function thread_is_poll($tid)
{
    $db_thread_is_poll = db_connect();

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM {$table_data['PREFIX']}POLL WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_is_poll)) return false;

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

    if (!$result = db_query($sql, $db_poll_check_tabular_votes)) return false;

    if (db_num_rows($result) > 0) {

        $poll_data = db_fetch_array($result);

        if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            return (sizeof($votes) == $poll_data['GROUP_COUNT']);

        }else {
            return true;
        }
    }

    return true;
}

?>