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

require_once('./include/messages.inc.php');
require_once('./include/thread.inc.php');

function poll_create($tid, $answers, $closes, $change_vote, $poll_type, $show_results)
{

    $db_poll_create = db_connect();
    
    $sql = "insert into ". forum_table("POLL"). " (TID, O1, O2, O3, O4, O5, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS) ";
    $sql.= "values ($tid, '". addslashes($answers[0]). "', '". addslashes($answers[1]). "', '". addslashes($answers[2]). "', '". addslashes($answers[3]). "', '". addslashes($answers[4]). "', ";
    $sql.= "'$closes', '$change_vote', '$poll_type', '$show_results')";
    
    $result = db_query($sql,$db_poll_create);
    
    if ($result) {
      
      return true;
      
    }else {
    
      return false;
      
    }
    
}

function poll_get($tid)
{

    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db_poll_get = db_connect();

    $sql = "select POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";    
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, POST.VIEWED, ";
    $sql.= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, ";
    $sql.= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER.RELATIONSHIP ";
    $sql.= "from ". forum_table("POST"). " POST ";
    $sql.= "left join ". forum_table("USER"). " FUSER on (POST.from_uid = FUSER.uid) ";
    $sql.= "left join ". forum_table("USER"). " TUSER on (POST.to_uid = TUSER.uid) ";
    $sql.= "left join ". forum_table("USER_PEER") . " USER_PEER ";
    $sql.= "on (USER_PEER.UID = $uid and USER_PEER.PEER_UID = POST.FROM_UID) ";    
    $sql.= "where POST.TID = $tid and POST.PID = 1";
    
    $result = db_query($sql, $db_poll_get);
    $polldata = db_fetch_array($result);
    
    return $polldata;
    
}

function poll_get_votes($tid)
{

    $db_poll_get_votes = db_connect();
    
    $sql = "select O1, O2, O3, O4, O5, O1_VOTES, O2_VOTES, O3_VOTES, O4_VOTES, O5_VOTES, ";
    $sql.= "CHANGEVOTE, POLLTYPE, SHOWRESULTS, UNIX_TIMESTAMP(CLOSES) AS CLOSES ";
    $sql.= "FROM POLL WHERE TID = $tid";
    
    $result = db_query($sql, $db_poll_get_votes);
    $pollresults = db_fetch_array($result);
    
    return $pollresults;
    
}

function poll_get_user_vote($tid)
{

    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    
    $db_poll_get_user_vote = db_connect();

    $sql = "select VOTE, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP from POLL_VOTES where UID = $uid and TID = $tid";
    $result = db_query($sql, $db_poll_get_user_vote);
    $userpolldata = db_fetch_array($result);
    
    return $userpolldata;
    
}

function poll_sort($a, $b) {

    if ($a['votes'] == $b['votes']) return 0;
    return ($a['votes'] > $b['votes']) ? -1 : 1;
    
}

function poll_display($tid, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true)
{

    global $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    
    $poll = poll_get_votes($tid);
    $polldata = poll_get($tid);
    $userpolldata = poll_get_user_vote($tid);

    $totalvotes = $poll['O1_VOTES'] + $poll['O2_VOTES'] + 
                  $poll['O3_VOTES'] + $poll['O4_VOTES'] + 
                  $poll['O5_VOTES'];
    
    $pollresults = array(0 => array('option' => $poll['O1'], 'votes' => $poll['O1_VOTES']),
                         1 => array('option' => $poll['O2'], 'votes' => $poll['O2_VOTES']),
                         2 => array('option' => $poll['O3'], 'votes' => $poll['O3_VOTES']),
                         3 => array('option' => $poll['O4'], 'votes' => $poll['O4_VOTES']),
                         4 => array('option' => $poll['O5'], 'votes' => $poll['O5_VOTES']));
    
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

    $max_value = 0;
    
    for ($i = 0; $i < 5; $i++) {
    
      if (!empty($pollresults[$i]['option'])) {
    
        if ($pollresults[$i]['votes'] > $max_value) $max_value = $pollresults[$i]['votes'];
        $optioncount++;
        
      }
      
    }
    
    if ($max_value > 0) {
    
      $horizontal_bar_width = floor((300 / $max_value));
      
      $vertical_bar_height = floor((200 / $max_value));
      $vertical_bar_width = floor((400 / $optioncount));
      
    }
        
    if ($in_list) {
          
      if ((!isset($userpolldata['VOTE']) && $HTTP_COOKIE_VARS['bh_sess_uid'] > 0) && ($poll['CLOSES'] == 0 || $poll['CLOSES'] > gmmktime())) {
      
        for ($i = 0; $i < 5; $i++) {
        
          if (!empty($pollresults[$i]['option'])) {
            
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td class=\"postbody\">". form_radio("pollvote", $i, '', false). "&nbsp;". $pollresults[$i]['option']. "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
            
          }
          
        }
        
      }else {
      
        if ($poll['SHOWRESULTS'] == 1) {
            
          if ($poll['POLLTYPE'] == 0) {
        
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td>\n";
            $polldata['CONTENT'].= poll_horizontal_graph($pollresults, $horizontal_bar_width, $totalvotes);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
               
          }else {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td>\n";
            $polldata['CONTENT'].= poll_vertical_graph($pollresults, $vertical_bar_height, $vertical_bar_width, $totalvotes);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
                
          }
          
        }else {
        
          for ($i = 0; $i < 5; $i++) {
        
            if (!empty($pollresults[$i]['option'])) {

              $polldata['CONTENT'].= "        <tr>\n";
              $polldata['CONTENT'].= "          <td class=\"postbody\">". $pollresults[$i]['option']. "</td>\n";
              $polldata['CONTENT'].= "        </tr>\n";
          
            }
        
          }
          
        }
              
      }
          
    }else {
    
      for ($i = 0; $i < 5; $i++) {
        
        if (!empty($pollresults[$i]['option'])) {
        
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td class=\"postbody\">". $pollresults[$i]['option']. "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          
        }
        
      }
          
    }  
    
    if ($in_list) {
    
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td>&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";    
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td class=\"postbody\">";
      
      if ($totalvotes == 0 && ($poll['CLOSES'] <= gmmktime() && $poll['CLOSES'] != 0)) {
      
        $polldata['CONTENT'].= "<b>Nobody voted.</b>";
        
      }elseif ($totalvotes == 0 && ($poll['CLOSES'] > gmmktime() || $poll['CLOSES'] == 0)) {
      
        $polldata['CONTENT'].= "<b>Nobody has voted.</b>";
      
      }elseif ($totalvotes == 1 && ($poll['CLOSES'] <= gmmktime() && $poll['CLOSES'] != 0)) {
      
        $polldata['CONTENT'].= "<b>1 person voted.</b>";
        
      }elseif ($totalvotes == 1 && ($poll['CLOSES'] > gmmktime() || $poll['CLOSES'] == 0)) {
      
        $polldata['CONTENT'].= "<b>1 person has voted.</b>";
        
      }else {
      
        if ($poll['CLOSES'] <= gmmktime() && $poll['CLOSES'] != 0) {
      
          $polldata['CONTENT'].= "<b>". $totalvotes. " people voted.</b>";
          
        }else {
        
          $polldata['CONTENT'].= "<b>". $totalvotes. " people have voted.</b>";
          
        }
        
      }
      
      $polldata['CONTENT'].= "</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td>&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      
      if (($poll['CLOSES'] <= gmmktime()) && $poll['CLOSES'] != 0) {
      
        $polldata['CONTENT'].= "        <tr>\n";
        $polldata['CONTENT'].= "          <td class=\"postbody\">Poll has ended.</td>\n";
        $polldata['CONTENT'].= "        </tr>\n";
    
        if (isset($userpolldata['VOTE'])) {
    
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td class=\"postbody\">Your vote was '". $pollresults[$userpolldata['VOTE']]['option']. "' on ". gmdate("jS M Y", $userpolldata['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";        
              
        }
        
      }else {
      
        if (isset($userpolldata['VOTE'])) {
    
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td class=\"postbody\">Your vote was '". $pollresults[$userpolldata['VOTE']]['option']. "' on ". gmdate("jS M Y", $userpolldata['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          
          if($HTTP_COOKIE_VARS['bh_sess_uid'] == $polldata['FROM_UID'] || perm_is_moderator()){

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td>&nbsp;</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";      
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td align=\"center\">". form_submit('pollclose', 'End Poll'). "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
           
          }
          
          if ($poll['CHANGEVOTE'] == 1) {
      
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td align=\"center\">". form_submit('pollchangevote', 'Change Vote'). "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
        
          }          
              
        }elseif ($HTTP_COOKIE_VARS['bh_sess_uid'] > 0) {
    
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td align=\"center\">". form_submit('pollsubmit', 'Vote'). "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td align=\"center\">";
          
          if ($poll['SHOWRESULTS'] == 1 && $totalvotes > 0) {
          
            $polldata['CONTENT'].= form_button("pollresults", "Results", "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
            
          }

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

    message_display($tid, $polldata, $msg_count, $first_msg, $in_list, $closed, $limit_text, true);
    
}

function poll_horizontal_graph($pollresults, $bar_width, $totalvotes)
{

    //usort($pollresults, "poll_sort");

    $polldisplay = "            <table width=\"100%\" align=\"center\">\n";
    
    for ($i = 0; $i < 5; $i++) {
    
      if (!empty($pollresults[$i]['option'])) {
    
        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">". $pollresults[$i]['option']. "</td>\n";
        
        if ($pollresults[$i]['votes'] > 0) {
        
          $polldisplay.= "                <td width=\"300\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". $bar_width * $pollresults[$i]['votes']. "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". ($i + 1). "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";
          
        }else {
        
          $polldisplay.= "                <td class=\"postbody\" height=\"25\">&nbsp;</td>\n";
          
        }
        
        $polldisplay.= "              </tr>\n";
        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
        $polldisplay.= "                <td class=\"postbody\" height=\"20\">". $pollresults[$i]['votes']. " votes (". round((100 / $totalvotes) * $pollresults[$i]['votes'], 2). "%)</td>\n";
        $polldisplay.= "              </tr>\n";
        
      }
      
    }
    
    $polldisplay.= "            </table>\n";
    
    return $polldisplay;
    
}

function poll_vertical_graph($pollresults, $bar_height, $bar_width, $totalvotes)
{

    //usort($pollresults, "poll_sort");

    $polldisplay = "            <table width=\"460\" align=\"center\">\n";
    $polldisplay.= "              <tr>\n";
    
    for ($i = 0; $i < 5; $i++) {
    
      if (!empty($pollresults[$i]['option'])) {
        
        if ($pollresults[$i]['votes'] > 0) {
        
          $polldisplay.= "                <td align=\"center\" valign=\"bottom\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". $bar_height * $pollresults[$i]['votes']. "px; width: ". $bar_width. "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". ($i + 1). "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";
          
        }else {
        
          $polldisplay.= "                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". $bar_width. "px\">&nbsp;</td>\n";
          
        }
        
      }
      
    }
    
    $polldisplay.= "              </tr>\n";
    $polldisplay.= "              <tr>\n";
    
    for ($i = 0; $i < 5; $i++) {
    
      if (!empty($pollresults[$i]['option'])) {
     
        $polldisplay.= "                <td class=\"postbody\" align=\"center\">". $pollresults[$i]['option']. "<br />". $pollresults[$i]['votes']. " votes (". round((100 / $totalvotes) * $pollresults[$i]['votes'], 2). "%)</td>\n";
        
      }
      
    }    

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "            </table>\n";
    
    return $polldisplay;
    
}

function poll_close($tid)
{

    global $HTTP_COOKIE_VARS;

    $db_poll_close = db_connect();

    $sql = "select FROM_UID from ". forum_table("POST"). " where TID = $tid and PID = 1";
    $result = db_query($sql, $db_poll_close);
    
    if (db_num_rows($result) > 0) {
    
      $polldata = db_fetch_array($result);
    
      if($HTTP_COOKIE_VARS['bh_sess_uid'] == $polldata['FROM_UID'] || perm_is_moderator()) {
    
        $sql = "update ". forum_table("POLL"). " set CLOSES = FROM_UNIXTIME(". gmmktime(). ") where TID = $tid";
        $result = db_query($sql, $db_poll_close);
        
      }
      
    }
    
}

function poll_vote($tid, $vote)
{

    global $HTTP_COOKIE_VARS;

    $db_poll_vote = db_connect();
    
    $sql = "insert into ". forum_table("POLL_VOTES"). " (TID, UID, VOTE, TSTAMP) ";
    $sql.= "values ($tid, ". $HTTP_COOKIE_VARS['bh_sess_uid']. ", '". $vote. "', FROM_UNIXTIME(". mktime(). "))";
    $result = db_query($sql, $db_poll_vote);
    
    $vote++;
    
    $sql = "update ". forum_table("POLL"). " set O". $vote. "_VOTES = O". $vote. "_VOTES + 1 where TID = $tid";
    $result = db_query($sql, $db_poll_vote);
    
}

function poll_delete_vote($tid)
{

    global $HTTP_COOKIE_VARS;

    $db_poll_delete_vote = db_connect();
    
    $sql = "select VOTE from ". forum_table("POLL_VOTES"). " where TID = $tid and UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
    $result = db_query($sql, $db_poll_delete_vote);
    
    if (db_num_rows($result) > 0) {
    
      $userpollvote = db_fetch_array($result);
      $userpollvote['VOTE']++;
    
      $sql = "update ". forum_table("POLL"). " set O". $userpollvote['VOTE']. "_VOTES = O". $userpollvote['VOTE']. "_VOTES - 1 where TID = $tid";
      $result = db_query($sql, $db_poll_delete_vote);
    
      $sql = "delete from ". forum_table("POLL_VOTES"). " where TID = $tid and UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];
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