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

// Author: Matt Beale

require_once('messages.inc.php');
require_once('thread.inc.php');

function poll_create($tid, $answers, $closes, $change_vote, $poll_type, $show_results)
{

    $db_poll_create = db_connect();
    
    $sql = "insert into ". forum_table("POLL"). " (TID, O1, O2, O3, O4, O5, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS) ";
    $sql.= "values ($tid, '". $answers[0]. "', '". $answers[1]. "', '". $answers[2]. "', '". $answers[3]. "', '". $answers[4]. "', ";
    $sql.= "'$closes', '$change_vote', '$poll_type', '$show_results')";
    
    $result = db_query($sql,$db_poll_create);
    
    if ($result) {
      
      return true;
      
    }else {
    
      return false;
      
    }
    
}

function poll_display($tid, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true)
{

    global $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    if(!$uid) $uid = 0;

    $db_poll_display = db_connect();
    
    $sql = "select POLL.TID, POLL.O1, POLL.O2, POLL.O3, POLL.O4, POLL.O5, ";
    $sql.= "POLL.O1_VOTES, POLL.O2_VOTES, POLL.O3_VOTES, POLL.O4_VOTES, POLL.O5_VOTES, ";
    $sql.= "POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, UNIX_TIMESTAMP(POLL.CLOSES) AS CLOSES, ";
    $sql.= "POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";    
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, POST.VIEWED, ";
    $sql.= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, ";
    $sql.= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER.RELATIONSHIP ";
    $sql.= "from ". forum_table("POLL"). " POLL, ". forum_table("POST"). " POST ";
    $sql.= "left join ". forum_table("USER"). " FUSER on (POST.from_uid = FUSER.uid) ";
    $sql.= "left join ". forum_table("USER"). " TUSER on (POST.to_uid = TUSER.uid) ";
    $sql.= "left join ". forum_table("USER_PEER") . " USER_PEER ";
    $sql.= "on (USER_PEER.UID = $uid and USER_PEER.PEER_UID = POST.FROM_UID) ";    
    $sql.= "where POLL.TID = $tid and POST.TID = POLL.TID ";
    $sql.= "and POST.PID = 1";
    
    $result = db_query($sql, $db_poll_display);
    $polldata = db_fetch_array($result);
    
    $sql = "select VOTE, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP from POLL_VOTES where UID = $uid and TID = $tid";
    $result = db_query($sql, $db_poll_display);
    $userpolldata = db_fetch_array($result);
    
    $totalvotes = $polldata['O1_VOTES'] + $polldata['O2_VOTES'];
    $totalvotes+= $polldata['O3_VOTES'] + $polldata['O4_VOTES'];
    $totalvotes+= $polldata['O5_VOTES'];
    
    $polldata['CONTENT'] = "<br>\n";
    $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td>\n";
    
    $polldata['CONTENT'].= "      <form method=\"post\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\" target=\"_self\">\n      ";
    $polldata['CONTENT'].= form_input_hidden('tid', $tid). "\n";    
    $polldata['CONTENT'].= "      <table width=\"95%\" align=\"center\">\n";  
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td><h2>". thread_get_title($tid). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td>\n";
    $polldata['CONTENT'].= "            <table width=\"100%\" align=\"center\">\n";
    
    $max_value = 0;
    
    for ($i = 1; $i < 6; $i++) {
    
      if ($polldata['O'. $i. '_VOTES'] > $max_value) $max_value = $polldata['O'. $i. '_VOTES'];
      
    }
    
    if ($max_value > 0) $bar_width = (300 / $max_value);
    
    for ($i = 1; $i < 6; $i++) {

      if (!empty($polldata['O'. $i])) {
     
        $polldata['CONTENT'].= "          <tr>\n";
        $polldata['CONTENT'].= "            <td width=\"100\" class=\"postbody\">";
        
        if ($in_list) {
        
          if ((!isset($userpolldata['VOTE']) && $HTTP_COOKIE_VARS['bh_sess_uid'] > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > gmmktime())) {
        
            $polldata['CONTENT'].= form_radio("pollvote", $i, '', false);
            $polldata['CONTENT'].= "&nbsp;". $polldata['O'. $i]. "</td>\n";
          
          }else {
        
            $polldata['CONTENT'].= $polldata['O'. $i]. "</td>\n";
            $polldata['CONTENT'].= "            <td class=\"postbody\">";
            $polldata['CONTENT'].= "<img src=\"./images/pollbar". $i. ".png\" height=\"20\" width=\"". $bar_width * $polldata['O'. $i. '_VOTES']. "\" alt=\"\">";
            $polldata['CONTENT'].= "</td>\n";
          
          }
          
        }else {
        
          $polldata['CONTENT'].= $polldata['O'. $i]. "</td>\n";
          
        }
        
        $polldata['CONTENT'].= "          </tr>\n";
        
      }
      
    }
    
    $polldata['CONTENT'].= "            </table>\n";
    $polldata['CONTENT'].= "          </td>\n";    
    
    if ($in_list) {
    
      // Number of votes
    
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td>&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";    
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td class=\"postbody\">". $totalvotes. " people ";
      
      if ($polldata['CLOSES'] < gmmktime() && $polldata['CLOSES'] != 0) {
      
        $polldata['CONTENT'].= "voted.</td>\n";
        
      }else {
      
        $polldata['CONTENT'].= "have voted so far.</td>\n";
        
      }
      
      $polldata['CONTENT'].= "        </tr>\n";
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td>&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      

      // User voting options
      
      if ($polldata['CLOSES'] < gmmktime() && $polldata['CLOSES'] != 0) {
      
        $polldata['CONTENT'].= "        <tr>\n";
        $polldata['CONTENT'].= "          <td class=\"postbody\">Poll has ended.</td>\n";
        $polldata['CONTENT'].= "        </tr>\n";
    
        if (isset($userpolldata['VOTE'])) {
    
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td class=\"postbody\">Your vote was '". $polldata[$userpolldata['VOTE']]. "' on ". gmdate("j M H:i", $userpolldata['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";        
              
        }
        
      }else {
      
        if (isset($userpolldata['VOTE'])) {
    
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td class=\"postbody\">Your vote was '". $polldata[$userpolldata['VOTE']]. "' on ". gmdate("j M H:i", $userpolldata['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          
          if($HTTP_COOKIE_VARS['bh_sess_uid'] == $polldata['FROM_UID'] || perm_is_moderator()){

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td>&nbsp;</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";      
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td align=\"center\">". form_submit('pollclose', 'End Poll'). "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
           
          }
          
          if ($polldata['CHANGEVOTE'] == 1) {
      
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td align=\"center\">". form_submit('pollchangevote', 'Change Vote'). "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
        
          }          
              
        }elseif ($HTTP_COOKIE_VARS['bh_sess_uid'] > 0) {
    
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td align=\"center\">". form_submit('pollsubmit', 'Vote'). "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td align=\"center\">". form_button("pollresults", "Results", "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");

          if($HTTP_COOKIE_VARS['bh_sess_uid'] == $polldata['FROM_UID'] || perm_is_moderator()){
      
            $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', 'End Poll');
        
          }
    
          $polldata['CONTENT'].= "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          
        }
        
      }
      
    }
    
    $polldata['CONTENT'].= "      </table>\n";    
    $polldata['CONTENT'].= "      </form>\n";
    $polldata['CONTENT'].= "    </td>\n"; 
    $polldata['CONTENT'].= "  </tr>\n";
    $polldata['CONTENT'].= "</table>\n";
    $polldata['CONTENT'].= "<br><br>\n";

    message_display($tid, $polldata, $msg_count, $first_msg, $in_list, $closed, $limit_text);
    
}

function poll_close($tid)
{

    global $HTTP_COOKIE_VARS;

    $db_poll_close = db_connect();

    $sql = "select FROM_UID from ". forum_table("POST"). " where TID = $tid ";
    $sql.= "and PID = 1 and FROM_UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
    
    $result = db_query($sql, $db_poll_close);
    
    if (db_num_rows($result) > 0) {
    
      $sql = "update low_priority ". forum_table("POLL"). " set CLOSES = NOW() where TID = $tid";
      $result = db_query($sql, $db_poll_close);
      
    }
    
}

function poll_vote($tid, $vote)
{

    global $HTTP_COOKIE_VARS;

    $db_poll_vote = db_connect();
    
    $sql = "update ". forum_table("POLL"). " set O". $vote. "_VOTES = O". $vote. "_VOTES + 1 where TID = $tid";
    $result = db_query($sql, $db_poll_vote);

    $sql = "insert into ". forum_table("POLL_VOTES"). " (TID, UID, VOTE, TSTAMP) ";
    $sql.= "values ($tid, ". $HTTP_COOKIE_VARS['bh_sess_uid']. ", '$vote', NOW())";
    
    $result = db_query($sql, $db_poll_vote);
    
}

function poll_delete_vote($tid)
{

    global $HTTP_COOKIE_VARS;

    $db_poll_delete_vote = db_connect();
    
    $sql = "select VOTE from ". forum_table("POLL_VOTES"). " where UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
    $result = db_query($sql, $db_poll_delete_vote);
    
    if (db_num_rows($result) > 0) {
    
      $userpollvote = db_fetch_array($result);
    
      $sql = "update ". forum_table("POLL"). " set O". $userpollvote['VOTE']. "_VOTES = O". $userpollvote['VOTE']. "_VOTES - 1 where TID = $tid";
      $result = db_query($sql, $db_poll_delete_vote);
    
      $sql = "delete from ". forum_table("POLL_VOTES"). " where TID = $tid and UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
      $result = db_query($sql, $db_poll_delete_vote);
      
    }
    
}