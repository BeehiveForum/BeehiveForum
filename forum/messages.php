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

// Require functions
require_once("./include/session.inc.php"); // Session functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/thread.inc.php"); // Thread processing functions
require_once("./include/messages.inc.php"); // Message processing functions
require_once("./include/folder.inc.php"); // Folder processing functions
require_once("./include/beehive.inc.php"); // Beehive stuff
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/config.inc.php");
require_once("./include/header.inc.php");
require_once("./include/user.inc.php");
require_once("./include/perm.inc.php");
require_once("./include/poll.inc.php");

// Check that required variables are set
// default to display most recent discussion for user
if (!isset($HTTP_GET_VARS['msg'])) {
    if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
        $msg = messages_get_most_recent($HTTP_COOKIE_VARS['bh_sess_uid']);
    } else {
        $msg = "1.1";
    }
} else {
    $msg = $HTTP_GET_VARS['msg'];
}

if (isset($HTTP_GET_VARS['fontsize'])) {
    
    $userprefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
    user_update_prefs($HTTP_COOKIE_VARS['bh_sess_uid'], $userprefs['FIRSTNAME'], $userprefs['LASTNAME'],
                      $userprefs['HOMEPAGE_URL'], $userprefs['PIC_URL'], $userprefs['EMAIL_NOTIFY'],
                      $userprefs['TIMEZONE'], $userprefs['DL_SAVING'], $userprefs['MARK_AS_OF_INT'],
                      $userprefs['POST_PER_PAGE'], $HTTP_GET_VARS['fontsize'], $userprefs['STYLE']);
    unset($userprefs);

    bh_session_init($HTTP_COOKIE_VARS['bh_sess_uid']);
    header_redirect($HTTP_SERVER_VARS['PHP_SELF']. "?msg=$msg");
    
}

list($tid, $pid) = explode('.', $msg);
if ($pid == '') $pid = 1;

// Poll stuff

if (isset($HTTP_POST_VARS['pollsubmit'])) {

  if (isset($HTTP_POST_VARS['pollvote'])) {

    poll_vote($HTTP_POST_VARS['tid'], $HTTP_POST_VARS['pollvote']);
    header_redirect("messages.php?msg=". $HTTP_POST_VARS['tid']. ".1");
    
  }else {
  
    html_draw_top();
    echo "<h2>You must select an option to vote for.</h2>";
    html_draw_bottom();
    exit;
    
  }
  
}elseif (isset($HTTP_POST_VARS['pollclose'])) {

  poll_close($HTTP_POST_VARS['tid']);
  header_redirect("messages.php?msg=". $HTTP_POST_VARS['tid']. ".1");  
  
}elseif (isset($HTTP_POST_VARS['pollchangevote'])) {

  poll_delete_vote($HTTP_POST_VARS['tid']);
  header_redirect("messages.php?msg=". $HTTP_POST_VARS['tid']. ".1");  
  
}

// Output XHTML header
html_draw_top_script();

if(isset($HTTP_COOKIE_VARS['bh_sess_ppp'])){
    $ppp = $HTTP_COOKIE_VARS['bh_sess_ppp'];
} else {
    $ppp = 20;
}

$messages = messages_get($tid,$pid,$ppp);
$threaddata = thread_get($tid);
$closed = isset($threaddata['CLOSED']);
$foldertitle = folder_get_title($threaddata['FID']);
if($closed) $foldertitle .= " (closed)";

$msg_count = count($messages);

echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td>\n";
messages_top($foldertitle,_stripslashes($threaddata['TITLE']),$threaddata['INTEREST']);
echo "</td></tr></table></div>\n";

if($msg_count > 0){
    $first_msg = $messages[0]['PID'];
    foreach($messages as $message) {
    
        if($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
            $message['CONTENT'] = message_get_content($tid, $message['PID']);
        } else {
            $message['CONTENT'] = 'Ignored'; // must be set to something or will show as deleted
        }
        
        if($threaddata['POLL_FLAG'] == 'Y') {
        
          if ($message['PID'] == 1) {
        
            poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $closed, true);
            $last_pid = $message['PID'];
            
          }else {
          
            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, true, true);
            $last_pid = $message['PID'];
            
          }
          
        }else {
        
          message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, true);
          $last_pid = $message['PID'];
          
        }
    }
}

unset($messages, $message);

if($last_pid < $threaddata['LENGTH']){
    $npid = $last_pid + 1;
    echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td align=\"right\">\n";
    echo form_quick_button($HTTP_SERVER_VARS['PHP_SELF'], "Keep reading", "msg", "$tid.$npid");
    echo "</td></tr></table>\n";
}

messages_start_panel();

messages_nav_strip($tid,$pid,$threaddata['LENGTH'],$ppp);
if ($HTTP_COOKIE_VARS['bh_sess_uid'] != 0) {
	messages_interest_form($tid, $pid);
	messages_fontsize_form($tid, $pid);

	if(perm_is_moderator()){
		messages_admin_form($tid,$pid,$threaddata['TITLE'],$closed);
	}
}
messages_end_panel();

draw_beehive_bar();
html_draw_bottom();

if($msg_count > 0 && isset($HTTP_COOKIE_VARS['bh_sess_uid']) && $HTTP_COOKIE_VARS['bh_sess_uid'] != 0){
    messages_update_read($tid,$last_pid,$HTTP_COOKIE_VARS['bh_sess_uid']);
}

?>
