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

/* $Id: poll.inc.php,v 1.221 2008-03-04 00:13:18 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function poll_create($tid, $poll_options, $poll_answer_groups, $poll_closes, $poll_change_vote, $poll_type, $poll_show_results, $poll_vote_type, $poll_option_type, $poll_question, $poll_allow_guests)
{
    if (!$db_poll_create = db_connect()) return false;

    if (is_numeric($poll_closes)) {
        $poll_closes = "FROM_UNIXTIME($poll_closes)";
    }else {
        $poll_closes = 'NULL';
    }

    if (!is_numeric($tid)) return false;

    if (!is_array($poll_options))  return false;
    if (!is_array($poll_answer_groups)) return false;

    if (!is_numeric($poll_change_vote))  $poll_change_vote  = POLL_VOTE_CAN_CHANGE;
    if (!is_numeric($poll_type))         $poll_type         = POLL_HORIZONTAL_GRAPH;
    if (!is_numeric($poll_show_results)) $poll_show_results = POLL_SHOW_RESULTS;
    if (!is_numeric($poll_vote_type))    $poll_vote_type    = POLL_VOTE_ANON;
    if (!is_numeric($poll_option_type))  $poll_option_type  = POLL_OPTIONS_RADIOS;
    if (!is_numeric($poll_allow_guests)) $poll_allow_guests = POLL_GUEST_DENIED;

    if (!forum_get_setting('poll_allow_guests', false)) $poll_allow_guests = POLL_GUEST_DENIED;

    $poll_question = db_escape_string($poll_question);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}POLL (TID, CLOSES, CHANGEVOTE, ";
    $sql.= "POLLTYPE, SHOWRESULTS, VOTETYPE, OPTIONTYPE, QUESTION, ALLOWGUESTS) ";
    $sql.= "VALUES ('$tid', $poll_closes, '$poll_change_vote', '$poll_type', '$poll_show_results', ";
    $sql.= "'$poll_vote_type', '$poll_option_type', '$poll_question', '$poll_allow_guests')";

    if (!$result = db_query($sql, $db_poll_create)) return false;

    foreach ($poll_options as $key => $poll_option) {

        if (strlen(trim($poll_option)) > 0) {

            $poll_option_name  = db_escape_string($poll_option);
            $poll_option_group = (isset($poll_answer_groups[$key]) && is_numeric($poll_answer_groups[$key])) ? $poll_answer_groups[$key] : 1;

            $sql = "INSERT INTO {$table_data['PREFIX']}POLL_VOTES (TID, OPTION_NAME, GROUP_ID) ";
            $sql.= "VALUES ('$tid', '$poll_option_name', '$poll_option_group')";

            if (!$result = db_query($sql, $db_poll_create)) return false;
        }
    }

    return true;
}

function poll_edit($fid, $tid, $thread_title, $poll_question, $poll_options, $poll_answer_groups, $poll_closes, $poll_change_vote, $poll_type, $poll_show_results, $poll_vote_type, $poll_option_type, $poll_allow_guests, $poll_delete_votes)
{
    if (!$db_poll_edit = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!is_array($poll_options))  return false;
    if (!is_array($poll_answer_groups)) return false;

    if (!is_numeric($poll_change_vote))  $poll_change_vote  = POLL_VOTE_CAN_CHANGE;
    if (!is_numeric($poll_type))         $poll_type         = POLL_HORIZONTAL_GRAPH;
    if (!is_numeric($poll_show_results)) $poll_show_results = POLL_SHOW_RESULTS;
    if (!is_numeric($poll_vote_type))    $poll_vote_type    = POLL_VOTE_ANON;
    if (!is_numeric($poll_option_type))  $poll_option_type  = POLL_OPTIONS_RADIOS;
    if (!is_numeric($poll_allow_guests)) $poll_allow_guests = POLL_GUEST_DENIED;

    $thread_title = db_escape_string($thread_title);

    $poll_question = db_escape_string($poll_question);

    if (!forum_get_setting('poll_allow_guests', false)) $poll_allow_guests = POLL_GUEST_DENIED;

    $edit_uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}THREAD SET TITLE = '$thread_title' WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_edit)) return false;

    if ($poll_delete_votes) {

        $sql = "DELETE QUICK FROM {$table_data['PREFIX']}USER_POLL_VOTES WHERE TID = '$tid'";
        if (!$result = db_query($sql, $db_poll_edit)) return false;
    }

    if (is_numeric($poll_closes)) {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POLL SET CHANGEVOTE = '$poll_change_vote', ";
        $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$poll_show_results', ";
        $sql.= "VOTETYPE = '$poll_vote_type', OPTIONTYPE = '$poll_option_type', ";
        $sql.= "QUESTION = '$poll_question', ALLOWGUESTS = '$poll_allow_guests', ";
        $sql.= "CLOSES = FROM_UNIXTIME($poll_closes) WHERE TID = '$tid'";

        if (!$result = db_query($sql, $db_poll_edit)) return false;

    }else {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POLL SET CHANGEVOTE = '$poll_change_vote', ";
        $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$poll_show_results', ";
        $sql.= "VOTETYPE = '$poll_vote_type', OPTIONTYPE = '$poll_option_type', ";
        $sql.= "QUESTION = '$poll_question', ALLOWGUESTS = '$poll_allow_guests' ";
        $sql.= "WHERE TID = '$tid'";

        if (!$result = db_query($sql, $db_poll_edit)) return false;
    }

    $sql = "DELETE QUICK FROM {$table_data['PREFIX']}POLL_VOTES WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_edit)) return false;

    foreach ($poll_options as $key => $poll_option) {

        if (strlen(trim($poll_option)) > 0) {

            $option_name  = db_escape_string($poll_option);
            $option_group = (isset($poll_answer_groups[$key]) && is_numeric($poll_answer_groups[$key])) ? $poll_answer_groups[$key] : 1;

            $sql = "INSERT INTO {$table_data['PREFIX']}POLL_VOTES (TID, OPTION_NAME, GROUP_ID) ";
            $sql.= "VALUES ('$tid', '$option_name', '$option_group')";

            if (!$result = db_query($sql, $db_poll_edit)) return false;
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

    $sql = "SELECT POLL_VOTES.OPTION_ID, POLL_VOTES.OPTION_NAME, ";
    $sql.= "POLL_VOTES.GROUP_ID, COUNT(USER_POLL_VOTES.UID) AS VOTE_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}POLL_VOTES POLL_VOTES LEFT JOIN ";
    $sql.= "{$table_data['PREFIX']}USER_POLL_VOTES USER_POLL_VOTES ";
    $sql.= "ON (USER_POLL_VOTES.TID = POLL_VOTES.TID ";
    $sql.= "AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES.OPTION_ID) ";
    $sql.= "WHERE POLL_VOTES.TID = '$tid' GROUP BY POLL_VOTES.OPTION_ID";

    if (!$result = db_query($sql, $db_poll_get_votes)) return false;

    $poll_option_id_array    = array();
    $poll_option_name_array  = array();
    $poll_option_group_array = array();
    $poll_option_vote_array  = array();
    $poll_group_size_array   = array();

    $poll_results = array();

    while($poll_data = db_fetch_array($result)) {

        $poll_option_id_array[]    = $poll_data['OPTION_ID'];
        $poll_option_name_array[]  = $poll_data['OPTION_NAME'];
        $poll_option_group_array[] = $poll_data['GROUP_ID'];
        $poll_option_vote_array[]  = $poll_data['VOTE_COUNT'];

        if (!isset($poll_group_size_array[$poll_data['GROUP_ID']])) {
            $poll_group_size_array[$poll_data['GROUP_ID']] = 0;
        }

        $poll_group_size_array[$poll_data['GROUP_ID']]++;
    }

    $poll_results = array('OPTION_ID'   => $poll_option_id_array,
                          'OPTION_NAME' => $poll_option_name_array,
                          'GROUP_ID'    => $poll_option_group_array,
                          'VOTES'       => $poll_option_vote_array,
                          'GROUP_SIZE'  => $poll_group_size_array);

    return $poll_results;
}

function poll_get_total_votes($tid, &$total_votes, &$guest_votes)
{
    if (!$db_poll_get_total_votes = db_connect()) return false;

    if (!is_numeric($tid)) return 0;
    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(DISTINCT UID) FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID > 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($total_votes) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID = 0";

    if (!$result = db_query($sql, $db_poll_get_total_votes)) return false;

    list($guest_votes) = db_fetch_array($result, DB_RESULT_NUM);

    return true;
}

function poll_get_user_votes($tid, $view_style)
{
    if (!$db_poll_get_user_vote_hashes = db_connect()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($view_style)) $view_style = POLL_VIEW_TYPE_OPTION;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UP.UID, UP.OPTION_ID, UNIX_TIMESTAMP(UP.TSTAMP) AS TSTAMP ";
    $sql.= "FROM {$table_data['PREFIX']}USER_POLL_VOTES UP ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL POLL ON (UP.TID = POLL.TID) ";
    $sql.= "WHERE UP.TID = '$tid' AND POLL.VOTETYPE = 1 ";
    $sql.= "AND UP.UID > 0";

    if (!$result = db_query($sql, $db_poll_get_user_vote_hashes)) return false;

    $poll_get_user_votes = array();

    while($poll_data = db_fetch_array($result)) {

        if ($view_style == POLL_VIEW_TYPE_OPTION) {
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

    if (!$db_poll_get_user_vote = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (user_is_guest()) return false;

    $sql = "SELECT OPTION_ID, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP ";
    $sql.= "FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE UID = '$uid' AND TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_get_user_vote)) return false;

    if (db_num_rows($result) > 0) {

        $user_poll_votes_array = array();

        while($poll_data = db_fetch_array($result)) {

            $user_poll_votes_array[] = $poll_data;
        }

        return $user_poll_votes_array;
    }

    return false;
}

function poll_display($tid, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = true, $show_sigs = true, $is_preview = false, $highlight = array())
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $poll_data = poll_get($tid);

    $poll_results = poll_get_votes($tid);

    $user_poll_votes_array = poll_get_user_vote($tid);

    if (isset($poll_data['QUESTION']) && strlen(trim(_stripslashes($poll_data['QUESTION']))) > 0) {
        $poll_question = $poll_data['QUESTION'];
    } else {
        $poll_question = thread_get_title($tid);
    }

    $total_votes  = 0;
    $option_count = 0;

    $request_uri = get_request_uri();

    $poll_data['CONTENT'] = "<br />\n";
    $poll_data['CONTENT'].= "                <div align=\"center\">\n";
    $poll_data['CONTENT'].= "                <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    $poll_data['CONTENT'].= "                  <tr>\n";
    $poll_data['CONTENT'].= "                    <td align=\"left\">\n";
    $poll_data['CONTENT'].= "                      <form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
    $poll_data['CONTENT'].= "                        ". form_input_hidden("webtag", _htmlentities($webtag)). "\n";
    $poll_data['CONTENT'].= "                        ". form_input_hidden('tid', _htmlentities($tid)). "\n";
    $poll_data['CONTENT'].= "                        <table width=\"460\">\n";
    $poll_data['CONTENT'].= "                          <tr>\n";
    $poll_data['CONTENT'].= "                            <td align=\"left\"><h2>". word_filter_add_ob_tags(_htmlentities($poll_question)). "</h2></td>\n";
    $poll_data['CONTENT'].= "                          </tr>\n";

    $poll_group_count = 1;

    if ($in_list) {

        if (((!is_array($user_poll_votes_array) || $poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) && (bh_session_get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) && ($poll_data['CLOSES'] == 0 || $poll_data['CLOSES'] > mktime()) && !$is_preview) {

            $poll_data['CONTENT'].= "                          <tr>\n";
            $poll_data['CONTENT'].= "                            <td align=\"left\">\n";
            $poll_data['CONTENT'].= "                              <table width=\"100%\">\n";

            array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

            foreach ($poll_results['OPTION_ID'] as $key => $poll_results_option_id) {

                if (!isset($poll_previous_group)) {
                    $poll_previous_group = $poll_results['GROUP_ID'][$key];
                }

                if (strlen(trim($poll_results['OPTION_NAME'][$key])) > 0) {

                    if ($poll_results['GROUP_ID'][$key] <> $poll_previous_group) {

                        if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$key - 1]] > 1) {

                            $poll_data['CONTENT'].= "                                <tr>\n";
                            $poll_data['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$key - 1]}]", _htmlentities($drop_down_data), false, false). "</td>\n";
                            $poll_data['CONTENT'].= "                                </tr>\n";

                        }else {

                            $poll_data['CONTENT'].= "                                <tr>\n";
                            $poll_data['CONTENT'].= "                                  <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                            $poll_data['CONTENT'].= "                                </tr>\n";
                        }

                        unset($drop_down_data);

                        $poll_group_count++;
                    }

                    if ($poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$key]] > 1) {

                        if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                            $drop_down_data[$poll_results['OPTION_ID'][$key]] = word_filter_add_ob_tags($poll_results['OPTION_NAME'][$key]);

                        }else {

                            $poll_data['CONTENT'].= "                                <tr>\n";
                            $poll_data['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[{$poll_results['GROUP_ID'][$key]}]", _htmlentities($poll_results['OPTION_ID'][$key]), '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$key]). "</td>\n";
                            $poll_data['CONTENT'].= "                                </tr>\n";
                        }

                    }else {

                        $poll_data['CONTENT'].= "                                <tr>\n";
                        $poll_data['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[{$poll_results['GROUP_ID'][$key]}]", _htmlentities($poll_results['OPTION_ID'][$key]), '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$key]). "</td>\n";
                        $poll_data['CONTENT'].= "                                </tr>\n";
                    }

                    $poll_previous_group = $poll_results['GROUP_ID'][$key];
                }

                if ($key == sizeof($poll_results['OPTION_ID']) - 1) {

                    if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$key]] > 1) {

                        $poll_data['CONTENT'].= "                                <tr>\n";
                        $poll_data['CONTENT'].= "                                  <td align=\"left\" class=\"postbody\" valign=\"top\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$key]}]", _htmlentities($drop_down_data), false, false). "</td>\n";
                        $poll_data['CONTENT'].= "                                </tr>\n";

                    }
                }
            }

            $poll_data['CONTENT'].= "                              </table>\n";
            $poll_data['CONTENT'].= "                            </td>\n";
            $poll_data['CONTENT'].= "                          </tr>\n";

        }else {

            if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS || ($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] < mktime())) {

                if ($poll_data['POLLTYPE'] == POLL_HORIZONTAL_GRAPH) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $poll_data['CONTENT'].= poll_horizontal_graph($tid);
                    $poll_data['CONTENT'].= "                            </td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";

                }else if ($poll_data['POLLTYPE'] == POLL_VERTICAL_GRAPH) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $poll_data['CONTENT'].= poll_vertical_graph($tid);
                    $poll_data['CONTENT'].= "                            </td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";

                }else if ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $poll_data['CONTENT'].= poll_table_graph($tid);
                    $poll_data['CONTENT'].= "                            </td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";

                }else {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">\n";
                    $poll_data['CONTENT'].= poll_public_ballot($tid);
                    $poll_data['CONTENT'].= "                            </td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                }

            }else {

                foreach ($poll_results['OPTION_ID'] as $key => $poll_results_option_id) {

                    if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$key];

                    if (isset($poll_results['OPTION_NAME'][$key]) && strlen($poll_results['OPTION_NAME'][$key]) > 0) {

                        if ($poll_results['GROUP_ID'][$key] <> $poll_previous_group) {

                            $poll_data['CONTENT'].= "                          <tr>\n";
                            $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                            $poll_data['CONTENT'].= "                          </tr>\n";

                            $poll_group_count++;
                        }

                        $poll_data['CONTENT'].= "                          <tr>\n";
                        $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$key]). "</td>\n";
                        $poll_data['CONTENT'].= "                          </tr>\n";

                        $poll_previous_group = $poll_results['GROUP_ID'][$key];
                    }
                }
            }
        }

    }else {

        $poll_data['CONTENT'].= "                          <tr>\n";
        $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">\n";
        $poll_data['CONTENT'].= "                              <ul>\n";

        foreach ($poll_results['OPTION_ID'] as $key => $poll_results_option_id) {

            if (strlen($poll_results['OPTION_NAME'][$key]) > 0) {

                $poll_data['CONTENT'].= "                                <li>". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$key]). "</li>\n";
            }
        }

        $poll_data['CONTENT'].= "                              </ul>\n";
        $poll_data['CONTENT'].= "                            </td>\n";
        $poll_data['CONTENT'].= "                          </tr>\n";

    }

    if ($in_list && !$is_preview) {

        $group_array = array();

        foreach ($poll_results['OPTION_ID'] as $key => $poll_results_option_id) {

            if (!in_array($poll_results['GROUP_ID'][$key], $group_array)) {

                $group_array[] = $poll_results['GROUP_ID'][$key];
            }
        }

        poll_get_total_votes($tid, $total_votes, $guest_votes);

        $poll_group_count = sizeof($group_array);

        $poll_data['CONTENT'].= "                          <tr>\n";
        $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $poll_data['CONTENT'].= "                          </tr>\n";
        $poll_data['CONTENT'].= "                          <tr>\n";
        $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". poll_format_vote_counts($poll_data, $total_votes, $guest_votes). "</td>\n";
        $poll_data['CONTENT'].= "                          </tr>\n";
        $poll_data['CONTENT'].= "                          <tr>\n";
        $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
        $poll_data['CONTENT'].= "                          </tr>\n";

        if (($poll_data['CLOSES'] <= mktime()) && $poll_data['CLOSES'] != 0) {

            $poll_data['CONTENT'].= "                          <tr>\n";
            $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
            $poll_data['CONTENT'].= "                          </tr>\n";

            if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_data['CONTENT'].= "                          </tr>\n";
                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_button("pollresults", $lang['resultdetails'], "onclick=\"openPollResults('$tid', '$webtag');\""). "</td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";
                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>";
                $poll_data['CONTENT'].= "                          </tr>\n";
            }

            if (is_array($user_poll_votes_array) && isset($user_poll_votes_array[0]['TSTAMP'])) {

                $user_poll_votes_display_array = array();

                foreach ($user_poll_votes_display_array as $vote_key => $user_poll_vote) {

                    foreach ($poll_results['OPTION_ID'] as $group_key => $poll_results_group_id) {

                        if ($user_poll_votes_display_array[$vote_key]['OPTION_ID'] == $poll_results['OPTION_ID'][$group_key]) {

                            if ($poll_results['OPTION_NAME'][$group_key] == strip_tags($poll_results['OPTION_NAME'][$group_key])) {

                                $user_poll_votes_display_array[] = sprintf("'%s'", word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group_key]));

                            }else {

                                $user_poll_votes_display_array[] = sprintf("Option %s", $user_poll_votes_display_array[$vote_key]['OPTION_ID']);
                            }
                        }
                    }
                }

                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptionsondate'], implode(' &amp; ', $user_poll_votes_display_array), format_time($user_poll_votes_array[0]['TSTAMP'], true)). "</td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";
            }

        }else {

            if (is_array($user_poll_votes_array) && isset($user_poll_votes_array[0]['TSTAMP'])) {

                $user_poll_votes_display_array = array();

                foreach ($user_poll_votes_display_array as $vote_key => $user_poll_vote) {

                    foreach ($poll_results['OPTION_ID'] as $group_key => $poll_results_group_id) {

                        if ($user_poll_votes_display_array[$vote_key]['OPTION_ID'] == $poll_results['OPTION_ID'][$group_key]) {

                            if ($poll_results['OPTION_NAME'][$group_key] == strip_tags($poll_results['OPTION_NAME'][$group_key])) {

                                $user_poll_votes_display_array[] = sprintf("'%s'", word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group_key]));

                            }else {

                                $user_poll_votes_display_array[] = sprintf("Option %s", $user_poll_votes_display_array[$vote_key]['OPTION_ID']);
                            }
                        }
                    }
                }

                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\" class=\"postbody\">". sprintf($lang['youvotedforpolloptionsondate'], implode(' &amp; ', $user_poll_votes_display_array), format_time($user_poll_votes_array[0]['TSTAMP'], true)). "</td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";
                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";

                if ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                }

                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">";

                if (($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || bh_session_get_value('UID') == $poll_data['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                        $poll_data['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"openPollResults('$tid', '$webtag')\"");

                    }else {

                        $poll_data['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"openPollResults('$tid', '$webtag')\"");

                    }
                }

                if (bh_session_get_value('UID') == $poll_data['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    $poll_data['CONTENT'].= "                &nbsp;". form_submit('pollclose', $lang['endpoll']);
                }

                $poll_data['CONTENT'].= "                            </td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";

                if ($poll_data['CHANGEVOTE'] != 0) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                }

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                }

            }else if (bh_session_get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false))) {

                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";
                $poll_data['CONTENT'].= "                          <tr>\n";
                $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">";

                if (($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS && $total_votes > 0) || bh_session_get_value('UID') == $poll_data['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                        $poll_data['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"openPollResults('$tid', '$webtag')\"");

                    }else {

                        $poll_data['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"openPollResults('$tid', '$webtag')\"");
                    }
                }

                if (bh_session_get_value('UID') == $poll_data['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {

                    $poll_data['CONTENT'].= "                &nbsp;". form_submit('pollclose', $lang['endpoll']);

                }

                $poll_data['CONTENT'].= "                            </td>\n";
                $poll_data['CONTENT'].= "                          </tr>\n";

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                    $poll_data['CONTENT'].= "                          <tr>\n";
                    $poll_data['CONTENT'].= "                            <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
                    $poll_data['CONTENT'].= "                          </tr>\n";
                }
            }
        }
    }

    $poll_data['CONTENT'].= "                        </table>\n";
    $poll_data['CONTENT'].= "                      </form>\n";
    $poll_data['CONTENT'].= "                    </td>\n";
    $poll_data['CONTENT'].= "                  </tr>\n";
    $poll_data['CONTENT'].= "                </table>\n";
    $poll_data['CONTENT'].= "                </div>\n";
    $poll_data['CONTENT'].= "                <br />\n";

    $poll_data['FROM_RELATIONSHIP'] = user_get_relationship(bh_session_get_value('UID'), $poll_data['FROM_UID']);

    message_display($tid, $poll_data, $msg_count, $first_msg, $folder_fid, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);
}

function poll_format_vote_counts($poll_data, $user_votes, $guest_votes)
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

    if ($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] <= mktime()) {
        if ($user_votes > 0 || $guest_votes > 0) {
            $html.= sprintf("<b>{$lang['votedisplayclosedpoll']}</b>", $user_votes_display, $guest_votes_display);
        }else {
            $html.= $lang['nobodyvotedclosedpoll'];
        }
    }elseif ($poll_data['CLOSES'] == 0 || ($poll_data['CLOSES'] > mktime())) {
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
    if (!isset($poll_results['OPTION_ID'])) {
        $poll_results['OPTION_ID'] = array();
    }

    if (!isset($poll_results['GROUP_ID'])) {
        $poll_results['GROUP_ID'] = array();
    }

    if (!isset($poll_results['OPTION_NAME'])) {
        $poll_results['OPTION_NAME'] = array();
    }

    if (!isset($poll_results['VOTES'])) {
        $poll_results['VOTES'] = array();
    }

    foreach ($poll_results['OPTION_ID'] as $key => $option_id) {

        if (!isset($poll_results['GROUP_ID'][$key])) {
            $poll_results['GROUP_ID'][$key] = 1;
        }

        if (!isset($poll_results['GROUP_ID'][$key])) {
            $poll_results['OPTION_NAME'][$key] = '';
        }

        if (!isset($poll_results['VOTES'][$key])) {
            $poll_results['VOTES'][$key] = 0;
        }
    }
}

function poll_preview_form($poll_results, $poll_data)
{
    $lang = load_language_file();

    $poll_group_count = 1;

    poll_results_check_data($poll_results);

    foreach($poll_results['GROUP_ID'] as $group_key => $poll_results_group_id) {

        if (!isset($poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$group_key]]))         {
            $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$group_key]] = 1;
        }else {
            $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$group_key]]++;
        }
    }

    array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

    $poll_display = "                              <div align=\"center\">\n";
    $poll_display.= "                              <table width=\"100%\">\n";

    foreach ($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

        if (!isset($poll_previous_group)) {
            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }

        if (strlen(trim($poll_results['OPTION_NAME'][$option_key])) > 0) {

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {

                if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$option_key - 1]] > 1) {

                    $poll_display.= "                      <tr>\n";
                    $poll_display.= "                        <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
                    $poll_display.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$option_key - 1]}]", _htmlentities($drop_down_data), false, false). "</td>\n";
                    $poll_display.= "                      </tr>\n";

                }else {

                    $poll_display.= "                      <tr>\n";
                    $poll_display.= "                        <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                    $poll_display.= "                      </tr>\n";
                }

                unset($drop_down_data);

                $poll_group_count++;
            }

            if ($poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$option_key]] > 1) {

                if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                    $drop_down_data[$poll_results['OPTION_ID'][$option_key]] = word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]);

                }else {

                    $poll_display.= "                      <tr>\n";
                    $poll_display.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_radio("pollvote[{$poll_results['GROUP_ID'][$option_key]}]", _htmlentities($poll_results['OPTION_ID'][$option_key]), '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). "</td>\n";
                    $poll_display.= "                      </tr>\n";
                }

            }else {

                $poll_display.= "                      <tr>\n";
                $poll_display.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"1%\">". form_checkbox("pollvote[{$poll_results['GROUP_ID'][$option_key]}]", _htmlentities($poll_results['OPTION_ID'][$option_key]), '', false). " ". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). "</td>\n";
                $poll_display.= "                      </tr>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }

        if ($option_key == sizeof($poll_results['OPTION_ID']) - 1) {

            if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN && $poll_results['GROUP_SIZE'][$poll_results['GROUP_ID'][$option_key]] > 1) {

                $poll_display.= "                      <tr>\n";
                $poll_display.= "                        <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
                $poll_display.= "                        <td align=\"left\" class=\"postbody\" valign=\"top\" width=\"20\">". form_dropdown_array("pollvote[{$poll_results['GROUP_ID'][$option_key]}]", _htmlentities($drop_down_data), false, false). "</td>\n";
                $poll_display.= "                      </tr>\n";

            }
        }
    }

    $poll_display.= "                              </table>\n";
    $poll_display.= "                              </div>\n";

    return $poll_display;
}

function poll_preview_graph_horz($poll_results)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $bar_color = 1;

    poll_results_check_data($poll_results);

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            $poll_display.= "                                <tr>\n";
            $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). "</td>\n";

            if ($poll_results['VOTES'][$option_key] > 0) {

                $poll_display.= "                                  <td align=\"left\" width=\"300\">\n";
                $poll_display.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]). "px\">\n";
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
            $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"postbody\">&nbsp;</td>\n";
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

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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
    $poll_display.= "                              <table width=\"460\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $poll_display.= "                                <tr>\n";

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['VOTES'][$option_key] > 0) {

                if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {
                    $poll_display.= "                            <td align=\"left\" style=\"width: 2px; border-left: 1px solid #000000\">&nbsp;</td>\n";
                }

                $poll_display.= "                                  <td align=\"center\" valign=\"bottom\">\n";
                $poll_display.= "                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]). "px; width: ". round(400 / $option_count, 2). "px\">\n";
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

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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

function poll_horizontal_graph($tid)
{
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $bar_color = 1;

    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);

    poll_results_check_data($poll_results);

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {

                $poll_display.= "                              <tr>\n";
                $poll_display.= "                                <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                $poll_display.= "                              </tr>\n";

                $poll_group_count++;
            }

            $poll_display.= "                              <tr>\n";
            $poll_display.= "                                <td align=\"left\" width=\"150\" class=\"postbody\">". word_filter_add_ob_tags($poll_results['OPTION_NAME'][$option_key]). "</td>\n";

            if ($poll_results['VOTES'][$option_key] > 0) {

                $poll_display.= "                                <td align=\"left\" width=\"300\">\n";
                $poll_display.= "                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]). "px\">\n";
                $poll_display.= "                                    <tr>\n";
                $poll_display.= "                                      <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $poll_display.= "                                    </tr>\n";
                $poll_display.= "                                  </table>\n";
                $poll_display.= "                                </td>\n";

            }else {

                $poll_display.= "                                <td align=\"left\" class=\"postbody\" height=\"25\">&nbsp;</td>\n";
            }

            if (isset($total_votes[$poll_results['GROUP_ID'][$option_key]]) && $total_votes[$poll_results['GROUP_ID'][$option_key]] > 0) {
                $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$option_key]]) * $poll_results['VOTES'][$option_key], 2);
            }else {
                $vote_percent = 0;
            }

            $poll_display.= "                              </tr>\n";
            $poll_display.= "                              <tr>\n";
            $poll_display.= "                                <td align=\"left\" width=\"150\" class=\"postbody\">&nbsp;</td>\n";
            $poll_display.= "                                <td align=\"left\" class=\"postbody\" height=\"20\">". $poll_results['VOTES'][$option_key]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
            $poll_display.= "                              </tr>\n";

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
    $lang = load_language_file();

    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $bar_color = 1;

    poll_results_check_data($poll_results);

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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
        $blank1[] = 0;
    }

    $group2 = array();

    for ($i = 0; $i < sizeof($group2_keys); $i++) {

        $group2[] = $poll_results['OPTION_ID'][$group2_keys[$i]];
        $blank2[] = 0;
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
    $poll_display.= "                              <table width=\"460\" align=\"center\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

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

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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
    $poll_display.= "                              <table width=\"460\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $poll_display.= "                                <tr>\n";

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

        if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

            if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {

                $poll_display.= "                                <td align=\"left\" style=\"width: 2px; border-left: 1px solid #000000\">&nbsp;</td>\n";
                $poll_group_count++;
            }

            if ($poll_results['VOTES'][$option_key] > 0) {

                $poll_display.= "                                <td align=\"center\" valign=\"bottom\">\n";
                $poll_display.= "                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$poll_results['GROUP_ID'][$option_key]], 2) * $poll_results['VOTES'][$option_key]). "px; width: ". round(400 / $option_count, 2). "px\">\n";
                $poll_display.= "                                    <tr>\n";
                $poll_display.= "                                      <td align=\"left\" class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
                $poll_display.= "                                    </tr>\n";
                $poll_display.= "                            </table>\n";
                $poll_display.= "                                </td>\n";

            }else {

                $poll_display.= "                                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $option_count, 2). "px\">&nbsp;</td>\n";
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

        }

        $bar_color++;

        if ($bar_color > 5) $bar_color = 1;
    }

    $poll_display.= "                                </tr>\n";
    $poll_display.= "                                <tr>\n";

    unset($poll_previous_group);

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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
    $max_values  = array();

    $option_count = 0;

    $bar_color = 1;

    $poll_group_count = 1;

    $poll_results = poll_get_votes($tid);

    $poll_table_results = poll_get_table_votes($tid);

    poll_results_check_data($poll_results);

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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

    for ($i = 0; $i < sizeof($poll_table_results['UID']); $i++) {

        if (!isset($poll_previous_uid)) $poll_previous_uid =    - 1;

        if ($poll_previous_uid != $poll_table_results['UID'][$i]) {

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
    $poll_display.= "                              <table width=\"460\" cellpadding=\"6\" cellspacing=\"1\" border=\"0\">\n";

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

function poll_public_ballot($tid, $view_style)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    $total_votes = array();
    $max_values  = array();

    $option_count = 0;

    $poll_results = poll_get_votes($tid);

    poll_results_check_data($poll_results);

    foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

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

    $row_class   = (sizeof($max_values) > 1) ? "highlight" : "postbody";
    $table_class = (sizeof($max_values) > 1) ? "box" : "";

    $user_poll_votes = poll_get_user_votes($tid, $view_style);

    if ($view_style == POLL_VIEW_TYPE_OPTION) {

        array_multisort($poll_results['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $poll_results['OPTION_ID'], $poll_results['OPTION_NAME'], $poll_results['VOTES']);

        $poll_display = "                              <div align=\"center\">\n";
        $poll_display.= "                              <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";

        foreach($poll_results['OPTION_ID'] as $option_key => $poll_results_option_id) {

            if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$option_key];

            if (isset($poll_results['OPTION_NAME'][$option_key]) && strlen($poll_results['OPTION_NAME'][$option_key]) > 0) {

                if ($poll_results['GROUP_ID'][$option_key] <> $poll_previous_group) {

                    $poll_display.= "                              </table><br />\n";
                    $poll_display.= "                              <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
                }

                $poll_display.= "                                <tr>\n";
                $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\" style=\"border-bottom: 1px solid\"><h2>{$poll_results['OPTION_NAME'][$option_key]}</h2></td>\n";

                if ($poll_results['VOTES'][$option_key] > 0) {

                    if (isset($total_votes[$poll_results['GROUP_ID'][$option_key]]) && $total_votes[$poll_results['GROUP_ID'][$option_key]] > 0) {
                        $vote_percent = round((100 / $total_votes[$poll_results['GROUP_ID'][$option_key]]) * $poll_results['VOTES'][$option_key], 2);
                    }else {
                        $vote_percent = 0;
                    }

                    $poll_display.= "                                  <td align=\"left\"    class=\"$row_class\" style=\"border-bottom: 1px solid\">{$poll_results['VOTES'][$option_key]} {$lang['votes']} ({$vote_percent}%)</td>\n";
                    $poll_display.= "                                </tr>\n";

                    if (isset($user_poll_votes[$poll_results['OPTION_ID'][$option_key]]) && is_array($user_poll_votes[$poll_results['OPTION_ID'][$option_key]])) {

                        for ($j = 0; $j < sizeof($user_poll_votes[$poll_results['OPTION_ID'][$option_key]]); $j++) {

                            if ($user = user_get($user_poll_votes[$poll_results['OPTION_ID'][$option_key]][$j])) {

                                $poll_display.= "                                <tr>\n";
                                $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                                $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user['UID']}, '$webtag')\">". word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))). "</a></td>\n";
                                $poll_display.= "                                </tr>\n";
                            }
                        }
                    }

                    $poll_display.= "                                <tr>\n";
                    $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $poll_display.= "                                </tr>\n";

                }else {

                    $poll_display.= "                                  <td align=\"left\"    class=\"$row_class\" style=\"border-bottom: 1px solid\">0 {$lang['votes']} (0%)</td>\n";
                    $poll_display.= "                                </tr>\n";
                    $poll_display.= "                                <tr>\n";
                    $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $poll_display.= "                                </tr>\n";
                }
            }

            $poll_previous_group = $poll_results['GROUP_ID'][$option_key];
        }

        $poll_display.= "                              </table><br />\n";
        $poll_display.= "                              </div>\n";

    }else {

        $poll_display = "";

        foreach ($user_poll_votes as $uid => $option_id_array) {

            if ($user = user_get($uid)) {

                $poll_display.= "                              <div align=\"center\">\n";
                $poll_display.= "                              <table width=\"460\" cellpadding=\"5\" cellspacing=\"0\" class=\"$table_class\">\n";
                $poll_display.= "                                <tr>\n";
                $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\" style=\"border-bottom: 1px solid\" colspan=\"2\"><h2><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user['UID']}, '$webtag')\">". word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))). "</a></h2></td>\n";
                $poll_display.= "                                </tr>\n";

                foreach ($option_id_array as $option_key => $option_id) {

                    $poll_display.= "                                <tr>\n";
                    $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">&nbsp;</td>\n";
                    $poll_display.= "                                  <td align=\"left\" width=\"150\" class=\"$row_class\">". ($poll_results['OPTION_NAME'][$option_id_array[$option_key] - 1]). "</td>\n";
                    $poll_display.= "                                </tr>\n";

                }

                $poll_display.= "                              </table><br />\n";
                $poll_display.= "                              </div>\n";
            }
        }
    }

    return $poll_display;
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

    html_display_warning_msg($lang['pollconfirmclose'], '96%', 'center');

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
    if (!$db_poll_close = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FROM_UID FROM {$table_data['PREFIX']}POST WHERE TID = '$tid' AND PID = 1";

    if (!$result = db_query($sql, $db_poll_close)) return false;

    if (($t_fid = thread_get_folder($tid, 1)) && (db_num_rows($result) > 0)) {

        $poll_data = db_fetch_array($result);

        if (bh_session_get_value('UID') == $poll_data['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            $timestamp = mktime();

            $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POLL SET ";
            $sql.= "CLOSES = FROM_UNIXTIME($timestamp) WHERE TID = '$tid'";

            if (!$result = db_query($sql, $db_poll_close)) return false;
        }
    }
}

function poll_is_closed($tid)
{
    if (!$db_poll_is_closed = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM {$table_data['PREFIX']}POLL WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_poll_is_closed)) return false;

    if (db_num_rows($result) > 0) {

        $poll_data = db_fetch_array($result);
        if (isset($poll_data['CLOSES']) && $poll_data['CLOSES'] <= mktime() && $poll_data['CLOSES'] != 0) return true;
    }

    return false;
}

function poll_vote($tid, $vote_array)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($tid)) return false;
    if (!is_array($vote_array)) return false;

    if (!$db_poll_vote = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $poll_data = poll_get($tid);

    if ((!poll_get_user_vote($tid)) || ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) || (user_is_guest() && ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', false)))) {

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
    if (!$db_poll_delete_vote = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM {$table_data['PREFIX']}USER_POLL_VOTES ";
    $sql.= "WHERE TID = '$tid' AND UID = '$uid'";

    if (!$result = db_query($sql, $db_poll_delete_vote)) return false;
}

function thread_is_poll($tid)
{
    if (!$db_thread_is_poll = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT CLOSES FROM {$table_data['PREFIX']}POLL WHERE TID = '$tid'";

    if (!$result = db_query($sql, $db_thread_is_poll)) return false;

    if (db_num_rows($result) > 0) {

        return true;
    }

    return false;
}

function poll_check_tabular_votes($tid, $votes_array)
{
    if (!$db_poll_check_tabular_votes = db_connect()) return false;

    if (!is_numeric($tid)) return false;

    if (!is_array($votes_array)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POLL.POLLTYPE, MAX(POLL_VOTES.GROUP_ID) AS GROUP_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}POLL POLL ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POLL_VOTES POLL_VOTES ";
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

?>