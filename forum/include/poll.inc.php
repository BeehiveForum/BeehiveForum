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

/* $Id: poll.inc.php,v 1.57 2003-08-10 17:30:51 decoyduck Exp $ */

// Author: Matt Beale

require_once('./include/messages.inc.php');
require_once('./include/thread.inc.php');
require_once('./include/user_rel.inc.php');
require_once("./include/lang.inc.php");

function poll_create($tid, $poll_options, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type)
{

    $db_poll_create = db_connect();

    if ($closes) {
      $closes = "from_unixtime($closes)";
    }else {
      $closes = 'NULL';
    }

    $sql = "insert into ". forum_table("POLL"). " (TID, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS, VOTETYPE) ";
    $sql.= "values ('$tid', $closes, '$change_vote', '$poll_type', '$show_results', '$poll_vote_type')";

    if (db_query($sql, $db_poll_create)) {

      foreach($poll_options as $option_name) {

        if (strlen(trim($option_name)) > 0) {

          $sql = "insert into ". forum_table("POLL_VOTES"). " (TID, OPTION_NAME) ";
          $sql.= "values ('$tid', '". addslashes($option_name). "')";

          $result = db_query($sql, $db_poll_create);

        }

      }

    }else {

      return false;

    }

}

function poll_edit($tid, $poll_question, $poll_options, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type)
{

    $db_poll_edit = db_connect();

    // Rename the thread

    $sql = "UPDATE ".forum_table("THREAD")." SET TITLE = '$poll_question' WHERE TID = $tid";
    $result = db_query($sql, $db_poll_edit);

    // Delete the recorded user votes for this poll

    $sql = "DELETE FROM ". forum_table("USER_POLL_VOTES"). " WHERE TID = '$tid'";
    $result = db_query($sql, $db_poll_edit);

    // Update the Poll settings

    if ($closes) {
      $closes = "FROM_UNIXTIME($closes)";
    }else {
      $closes = 'NULL';
    }

    $sql = "UPDATE ". forum_table("POLL"). " SET CHANGEVOTE = '$change_vote', ";
    $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$show_results', VOTETYPE = '$poll_vote_type' ";

    if ($closes && $closes > 0) $sql.= ", CLOSES = $closes ";

    $sql.= "WHERE TID = '$tid'";

    $result = db_query($sql, $db_poll_edit);

    // Delete the available options for the poll

    $sql = "DELETE FROM ". forum_table("POLL_VOTES"). " WHERE TID = '$tid'";
    $result = db_query($sql, $db_poll_edit);

    // Insert the new poll options

    foreach($poll_options as $option_name) {

      if (strlen(trim($option_name)) > 0) {

        $sql = "INSERT INTO ". forum_table("POLL_VOTES"). " (TID, OPTION_NAME) ";
        $sql.= "VALUES ('$tid', '". addslashes($option_name). "')";

        $result = db_query($sql, $db_poll_edit);

      }

    }

}

function poll_get($tid)
{
    $uid = bh_session_get_value('UID');

    $db_poll_get = db_connect();

    $sql = "select POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, POST.VIEWED, ";
    $sql.= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, ";
    $sql.= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER.RELATIONSHIP, ";
    $sql.= "POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, POLL.VOTETYPE, ";
    $sql.= "UNIX_TIMESTAMP(POLL.CLOSES) as CLOSES ";
    $sql.= "from ". forum_table("POST"). " POST ";
    $sql.= "left join ". forum_table("USER"). " FUSER on (POST.FROM_UID = FUSER.UID) ";
    $sql.= "left join ". forum_table("USER"). " TUSER on (POST.TO_UID = TUSER.UID) ";
    $sql.= "left join ". forum_table("POLL"). " POLL on (POST.TID = POLL.TID) ";
    $sql.= "left join ". forum_table("USER_PEER") . " USER_PEER ";
    $sql.= "on (USER_PEER.UID = $uid and USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "where POST.TID = $tid and POST.PID = 1";

    $result = db_query($sql, $db_poll_get);
    $polldata = db_fetch_array($result);

    if (!isset($polldata['TNICK'])) {
        $polldata['TNICK']  = "ALL";
        $polldata['TLOGON'] = "ALL";
    }

    if (!isset($polldata['CLOSES'])) {
        $polldata['CLOSES'] = 0;
    }

    return $polldata;

}

function poll_get_votes($tid)
{

    $db_poll_get_votes = db_connect();

    $sql = "select OPTION_ID, OPTION_NAME, VOTES from ". forum_table('POLL_VOTES'). " where TID = $tid";
    $result = db_query($sql, $db_poll_get_votes);

    $pollresults = array();

    while($row = db_fetch_array($result)) {
      $pollresults[$row['OPTION_ID']] = array('OPTION_ID'   => $row['OPTION_ID'],
                                              'OPTION_NAME' => $row['OPTION_NAME'],
                                              'VOTES'       => $row['VOTES']);
    }

    return $pollresults;

}

function poll_get_user_votes($tid)
{
    $db_poll_get_user_vote_hashes = db_connect();

    $sql = "select PTUID, OPTION_ID from ". forum_table("USER_POLL_VOTES"). " where TID = $tid";
    $result = db_query($sql, $db_poll_get_user_vote_hashes);

    $poll_get_user_votes = array();

    while($row = db_fetch_array($result)) {
      $poll_get_user_votes[$row['PTUID']] = $row['OPTION_ID'];
    }

    return $poll_get_user_votes;
}

function poll_get_user_vote($tid)
{

    $uid = bh_session_get_value('UID');

    $polldata = poll_get($tid);
    if ($polldata['CHANGEVOTE'] == 2) return POLL_MULTIVOTE;

    $db_poll_get_user_vote = db_connect();

    $sql = "select OPTION_ID, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP from ". forum_table('USER_POLL_VOTES'). " where PTUID = MD5($tid.$uid)";
    $result = db_query($sql, $db_poll_get_user_vote);

    if (db_num_rows($result)) {
      $userpolldata = db_fetch_array($result);
    }else {
      $userpolldata = false;
    }

    return $userpolldata;

}

function poll_sort($a, $b) {

    if ($a['VOTES'] == $b['VOTES']) return 0;
    return ($a['VOTES'] > $b['VOTES']) ? -1 : 1;

}

function poll_display($tid, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = true, $show_sigs = true, $is_preview = false, $highlight = array())
{

    global $HTTP_SERVER_VARS, $lang;
    $uid = bh_session_get_value('UID');

    $polldata     = poll_get($tid);
    $pollresults  = poll_get_votes($tid);
    $userpolldata = poll_get_user_vote($tid);

    $totalvotes   = 0;
    $optioncount  = 0;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {
      $totalvotes = $totalvotes + $pollresults[$i]['VOTES'];
    }

    $polldata['CONTENT'] = "<br />\n";
    $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td>\n";

    $polldata['CONTENT'].= "      <form method=\"post\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\" target=\"_self\">\n      ";
    $polldata['CONTENT'].= form_input_hidden('tid', $tid). "\n";
    $polldata['CONTENT'].= "      <table width=\"450\" align=\"center\">\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td colspan=\"2\"><h2>". thread_get_title($tid). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";

    $max_value = 0;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {

      if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

        if ($pollresults[$i]['VOTES'] > $max_value) $max_value = $pollresults[$i]['VOTES'];
        $optioncount++;

      }

    }

    if ($max_value > 0) {

      $horizontal_bar_width = round(300 / $max_value, 2);
      $vertical_bar_height  = round(200 / $max_value, 2);
      $vertical_bar_width   = round(400 / $optioncount, 2);

    }else {

      $horizontal_bar_width = 0;
      $vertical_bar_height  = 0;
      $vertical_bar_width   = round(400 / $optioncount, 2);

    }

    if ($in_list) {

      if ((!isset($userpolldata['OPTION_ID']) && bh_session_get_value('UID') > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > gmmktime())) {

        for ($i = 1; $i <= sizeof($pollresults); $i++) {

          if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td class=\"postbody\" valign=\"top\" width=\"15\">". form_radio("pollvote", $pollresults[$i]['OPTION_ID'], '', false). "</td>\n";
            $polldata['CONTENT'].= "          <td class=\"postbody\" width=\"435\">". $pollresults[$i]['OPTION_NAME']. "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }

      }else {

        if ($polldata['SHOWRESULTS'] == 1) {

          if ($polldata['POLLTYPE'] == 0) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\">\n";
            $polldata['CONTENT'].= poll_horizontal_graph($pollresults, $horizontal_bar_width, $totalvotes);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }elseif ($polldata['POLLTYPE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\">\n";
            $polldata['CONTENT'].= poll_vertical_graph($pollresults, $vertical_bar_height, $vertical_bar_width, $totalvotes);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }else {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\">\n";
            $polldata['CONTENT'].= poll_public_ballot($tid, $pollresults, $horizontal_bar_width, $totalvotes);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }else {

          for ($i = 1; $i <= sizeof($pollresults); $i++) {

            if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

              $polldata['CONTENT'].= "        <tr>\n";
              $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">". $pollresults[$i]['OPTION_NAME']. "</td>\n";
              $polldata['CONTENT'].= "        </tr>\n";

            }

          }

        }

      }

    }else {

      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">\n";
      $polldata['CONTENT'].= "            <ul>\n";

      for ($i = 1; $i <= sizeof($pollresults); $i++) {

        if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

          $polldata['CONTENT'].= "        <li>". $pollresults[$i]['OPTION_NAME']. "</li>\n";

        }

      }

      $polldata['CONTENT'].= "            </ul>\n";
      $polldata['CONTENT'].= "          </td>\n";
      $polldata['CONTENT'].= "        </tr>\n";

    }

    if ($in_list) {

      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\">&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">";

      if ($totalvotes == 0 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyvoted']}</b>";

      }elseif ($totalvotes == 0 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyhasvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personhasvoted']}</b>";

      }else {

        if ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0) {

          $polldata['CONTENT'].= "<b>". $totalvotes. " {$lang['peoplevoted']}</b>";

        }else {

          $polldata['CONTENT'].= "<b>". $totalvotes. " {$lang['peoplehavevoted']}</b>";

        }

      }

      $polldata['CONTENT'].= "</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\">&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";

      if (($polldata['CLOSES'] <= gmmktime()) && $polldata['CLOSES'] != 0) {

        $polldata['CONTENT'].= "        <tr>\n";
        $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
        $polldata['CONTENT'].= "        </tr>\n";

        if (isset($userpolldata['OPTION_ID'])) {

          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">";

          if ($pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME'] == strip_tags($pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME'])) {
            $polldata['CONTENT'].= "{$lang['yourvotewas']} '". $pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME']. "'";
          }else {
            $polldata['CONTENT'].= $lang['youvotedforoption']. $userpolldata['OPTION_ID'];
          }

          $polldata['CONTENT'].=  " {$lang['on']} ". gmdate("jS M Y", $userpolldata['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";

        }

      }else {

        if (isset($userpolldata['OPTION_ID'])) {

          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">";

          if ($pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME'] == strip_tags($pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME'])) {
            $polldata['CONTENT'].= "{$lang['yourvotewas']} '". $pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME']. "'";
          }else {
            $polldata['CONTENT'].= $lang['youvotedforoption']. $userpolldata['OPTION_ID'];
          }

          $polldata['CONTENT'].=  " {$lang['on']} ". gmdate("jS M Y", $userpolldata['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\">&nbsp;</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">";

          if (($polldata['SHOWRESULTS'] == 1 && $totalvotes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

            if ($polldata['VOTETYPE'] == 1) {

              $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }else {

              $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }
          }

          if(bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()){

            $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']). "</td>\n";

          }

          $polldata['CONTENT'].= "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";

          if ($polldata['CHANGEVOTE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

          if ($polldata['VOTETYPE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">{$lang['polltypewarning']}</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }elseif (bh_session_get_value('UID') > 0) {

          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">";

          if (($polldata['SHOWRESULTS'] == 1 && $totalvotes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

            if ($polldata['VOTETYPE'] == 1) {

              $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }else {

              $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }

          }

          if (bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()){

            $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']);

          }

          $polldata['CONTENT'].= "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";

          if ($polldata['VOTETYPE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">{$lang['polltypewarning']}</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }

      }

    }

    $polldata['CONTENT'].= "      </table>\n";
    $polldata['CONTENT'].= "      </form>\n";
    $polldata['CONTENT'].= "    </td>\n";
    $polldata['CONTENT'].= "  </tr>\n";
    $polldata['CONTENT'].= "</table>\n";
    $polldata['CONTENT'].= "<p>&nbsp;</p>\n";

    // Work out what relationship the user has to the user who posted the poll
    $polldata['FROM_RELATIONSHIP'] = user_rel_get(bh_session_get_value('UID'), $polldata['FROM_UID']);

    message_display($tid, $polldata, $msg_count, $first_msg, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);

}

function poll_horizontal_graph($pollresults, $bar_width, $totalvotes)
{

    global $lang;

    //usort($pollresults, "poll_sort");

    $polldisplay = "            <table width=\"100%\" align=\"center\">\n";

    $bar_color = 1;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {

      if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">". $pollresults[$i]['OPTION_NAME']. "</td>\n";

        if ($pollresults[$i]['VOTES'] > 0) {

          $polldisplay.= "                <td width=\"300\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor($bar_width * $pollresults[$i]['VOTES']). "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";

        }else {

          $polldisplay.= "                <td class=\"postbody\" height=\"25\">&nbsp;</td>\n";

        }

        if ($totalvotes > 0) {
          $vote_percent = round((100 / $totalvotes) * $pollresults[$i]['VOTES'], 2);
        }else {
          $vote_percent = 0;
        }

        $polldisplay.= "              </tr>\n";
        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
        $polldisplay.= "                <td class=\"postbody\" height=\"20\">". $pollresults[$i]['VOTES']. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
        $polldisplay.= "              </tr>\n";

      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "            </table>\n";

    return $polldisplay;

}

function poll_vertical_graph($pollresults, $bar_height, $bar_width, $totalvotes)
{

    global $lang;

    //usort($pollresults, "poll_sort");

    $polldisplay = "            <table width=\"460\" align=\"center\">\n";
    $polldisplay.= "              <tr>\n";

    $bar_color = 1;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {

      if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

        if ($pollresults[$i]['VOTES'] > 0) {

          $polldisplay.= "                <td align=\"center\" valign=\"bottom\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". $bar_height * $pollresults[$i]['VOTES']. "px; width: ". $bar_width. "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";

        }else {

          $polldisplay.= "                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". $bar_width. "px\">&nbsp;</td>\n";

        }

      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "              <tr>\n";

    for ($i = 1; $i <= sizeof($pollresults); $i++) {

      if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

        if ($totalvotes > 0) {
          $vote_percent = round((100 / $totalvotes) * $pollresults[$i]['VOTES'], 2);
        }else {
          $vote_percent = 0;
        }

        $polldisplay.= "                <td class=\"postbody\" align=\"center\" valign=\"top\">". $pollresults[$i]['OPTION_NAME']. "<br />". $pollresults[$i]['VOTES']. " {$lang['votes']} (". $vote_percent. "%)</td>\n";

      }

    }

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "            </table>\n";

    return $polldisplay;

}

function poll_public_ballot($tid, $pollresults, $bar_width, $totalvotes)
{
    global $lang;

    $user_votes = poll_get_user_votes($tid);
    $user_count = user_count();

    $polldisplay = "            <table width=\"460\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "              <tr>\n";

    $bar_color = 1;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {

      if (isset($pollresults[$i]['OPTION_NAME']) && strlen($pollresults[$i]['OPTION_NAME']) > 0) {

        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\" style=\"border-bottom: 1px solid\"><h2>". $pollresults[$i]['OPTION_NAME']. "</h2></td>\n";

        if ($pollresults[$i]['VOTES'] > 0) {

          if ($totalvotes > 0) {
            $vote_percent = round((100 / $totalvotes) * $pollresults[$i]['VOTES'], 2);
          }else {
            $vote_percent = 0;
          }

          $polldisplay.= "                <td class=\"postbody\" style=\"border-bottom: 1px solid\">". $pollresults[$i]['VOTES']. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
          $polldisplay.= "              </tr>\n";

          reset($user_votes);

          foreach($user_votes as $ptuid => $option_id) {

            for ($j = 1; $j <= $user_count; $j++) {

              if ((md5("$tid.$j") == $ptuid) && ($option_id == $pollresults[$i]['OPTION_ID'])) {

                $user = user_get($j);

                $polldisplay.= "              <tr>\n";
                $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
                $polldisplay.= "                <td width=\"150\" class=\"postbody\"><a href=\"javascript:void(0);\" onclick=\"openProfile({$j})\" target=\"_self\">". format_user_name($user['LOGON'], $user['NICKNAME']). "</a></td>\n";
                $polldisplay.= "              </tr>\n";

              }
            }
          }

        }else {

          $polldisplay.= "                <td class=\"postbody\" style=\"border-bottom: 1px solid\">0 {$lang['votes']} (0%)</td>\n";
          $polldisplay.= "              </tr>\n";
          $polldisplay.= "              <tr>\n";
          $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
          $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
          $polldisplay.= "              </tr>\n";

        }
      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "            </table>\n";

    return $polldisplay;
}

function poll_confirm_close($tid)
{
    global $HTTP_SERVER_VARS, $lang;

    $preview_message = messages_get($tid, 1, 1);

    if(bh_session_get_value('UID') != $preview_message['FROM_UID'] && !perm_is_moderator()) {
        edit_refuse();
        return;
    }

    if($preview_message['TO_UID'] == 0) {

        $preview_message['TLOGON'] = "ALL";
        $preview_message['TNICK'] = "ALL";

    }else {

        $preview_tuser = user_get($preview_message['TO_UID']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];

    }

    $preview_fuser = user_get($preview_message['FROM_UID']);
    $preview_message['FLOGON'] = $preview_fuser['LOGON'];
    $preview_message['FNICK'] = $preview_fuser['NICKNAME'];

    echo "<h2>{$lang['pollconfirmclose']}</h2>\n";

    poll_display($tid, $preview_message, 0, 0, false);

    echo "<p><form name=\"f_delete\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">";
    echo form_input_hidden("tid", $tid);
    echo form_input_hidden("confirm_pollclose", "Y");
    echo form_submit("pollclose", $lang['endpoll']);
    echo "&nbsp;".form_submit("cancel", $lang['cancel']);
    echo "</form>\n";

}

function poll_close($tid)
{

    $db_poll_close = db_connect();

    $sql = "select FROM_UID from ". forum_table("POST"). " where TID = $tid and PID = 1";
    $result = db_query($sql, $db_poll_close);

    if (db_num_rows($result) > 0) {

      $polldata = db_fetch_array($result);

      if(bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

        $sql = "update ". forum_table("POLL"). " set CLOSES = FROM_UNIXTIME(". gmmktime(). ") where TID = $tid";
        $result = db_query($sql, $db_poll_close);

      }

    }

}

function poll_is_closed($tid)
{

    $db_poll_is_closed = db_connect();

    $sql = "select CLOSES from ". forum_table("POLL"). " where TID = $tid";
    $result = db_query($sql, $db_poll_is_closed);

    if (db_num_rows($result)) {
      $polldata = db_fetch_array($result);
      if (isset($polldata['CLOSES']) && $polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0) return true;
    }

    return false;

}

function poll_vote($tid, $vote)
{
    $uid = bh_session_get_value('UID');

    $db_poll_vote = db_connect();

    $polldata = poll_get($tid);

    if ($polldata['CHANGEVOTE'] == 2) {

      $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES + 1 where TID = $tid and OPTION_ID = $vote";
      $result = db_query($sql, $db_poll_vote);

    }elseif ($uid > 0 && !poll_get_user_vote($tid)) {

      $sql = "insert into ". forum_table("USER_POLL_VOTES"). " (TID, PTUID, OPTION_ID, TSTAMP) ";
      $sql.= "values ($tid, MD5($tid.$uid), $vote, FROM_UNIXTIME(". mktime(). "))";
      $result = db_query($sql, $db_poll_vote);

      $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES + 1 where TID = $tid and OPTION_ID = $vote";
      $result = db_query($sql, $db_poll_vote);

    }else if($uid == 0) {

      $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES + 1 where TID = $tid and OPTION_ID = $vote";
      $result = db_query($sql, $db_poll_vote);

    }
}

function poll_delete_vote($tid)
{

    $db_poll_delete_vote = db_connect();

    $uid = bh_session_get_value('UID');

    $sql = "select OPTION_ID from ". forum_table("USER_POLL_VOTES"). " where PTUID = MD5($tid.$uid)";
    $result = db_query($sql, $db_poll_delete_vote);

    if (db_num_rows($result) > 0) {

      $userpollvote = db_fetch_array($result);

      $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES - 1 where OPTION_ID = ". $userpollvote['OPTION_ID']. " and TID = $tid";
      $result = db_query($sql, $db_poll_delete_vote);

      $sql = "delete from ". forum_table("USER_POLL_VOTES"). " where PTUID = MD5($tid.$uid)";
      $result = db_query($sql, $db_poll_delete_vote);

    }

}

function thread_is_poll($tid)
{

    $db_thread_is_poll = db_connect();

    $sql = "select CLOSES from ". forum_table("POLL"). " where TID = $tid";
    $result = db_query($sql, $db_thread_is_poll);

    if (db_num_rows($result) > 0) {

      return true;

    }else {

      return false;

    }

}

?>