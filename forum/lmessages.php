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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

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
require_once("./include/light.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

// Check that required variables are set
// default to display most recent discussion for user
if (!isset($HTTP_GET_VARS['msg'])) {
    if(bh_session_get_value('UID')){
        $msg = messages_get_most_recent(bh_session_get_value('UID'));
    } else {
        $msg = "1.1";
    }
} else {
    $msg = $HTTP_GET_VARS['msg'];
}

if (isset($HTTP_GET_VARS['fontsize'])) {

    $userprefs = user_get_prefs(bh_session_get_value('UID'));

    user_update_prefs(bh_session_get_value('UID'), $userprefs['FIRSTNAME'], $userprefs['LASTNAME'],
                      $userprefs['DOB'], $userprefs['HOMEPAGE_URL'], $userprefs['PIC_URL'],
                      $userprefs['EMAIL_NOTIFY'], $userprefs['TIMEZONE'], $userprefs['DL_SAVING'],
                      $userprefs['MARK_AS_OF_INT'], $userprefs['POST_PER_PAGE'],
                      $HTTP_GET_VARS['fontsize'], $userprefs['STYLE']);

    unset($userprefs);

    bh_session_init(bh_session_get_value('UID'));
    header_redirect(basename($HTTP_SERVER_VARS['PHP_SELF']). "?msg=$msg");

}

list($tid, $pid) = explode('.', $msg);
if ($tid == '') $tid = 1;
if ($pid == '') $pid = 1;

if(!thread_can_view($tid, bh_session_get_value('UID'))){
        light_html_draw_top();
        echo "<h2>The requested thread could not be found or access was denied.</h2>";
        light_html_draw_bottom();
        exit;
}

// Poll stuff

if (isset($HTTP_POST_VARS['pollsubmit'])) {

  if (isset($HTTP_POST_VARS['pollvote'])) {

    poll_vote($HTTP_POST_VARS['tid'], $HTTP_POST_VARS['pollvote']);
    header_redirect("lmessages.php?msg=". $HTTP_POST_VARS['tid']. ".1");

  }else {

    light_html_draw_top();
    echo "<h2>You must select an option to vote for.</h2>";
    light_html_draw_bottom();
    exit;

  }

}

// Output XHTML header
light_html_draw_top();

if (bh_session_get_value('POSTS_PER_PAGE')) {
    $ppp = bh_session_get_value('POSTS_PER_PAGE');
} else {
    $ppp = 20;
}

$messages = messages_get($tid,$pid,$ppp);
$threaddata = thread_get($tid);
$closed = isset($threaddata['CLOSED']);
$foldertitle = folder_get_title($threaddata['FID']);
if($closed) $foldertitle .= " (closed)";

$show_sigs = false; // explicitly set sigs not to show in light mode

$msg_count = count($messages);

light_messages_top($foldertitle,_stripslashes($threaddata['TITLE']),$threaddata['INTEREST']);

if($msg_count > 0){
    $first_msg = $messages[0]['PID'];
    foreach($messages as $message) {

        if (isset($message['RELATIONSHIP'])) {

            if($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                $message['CONTENT'] = message_get_content($tid, $message['PID']);
            } else {
                $message['CONTENT'] = 'Ignored'; // must be set to something or will show as deleted
            }

            } else {

                $message['CONTENT'] = message_get_content($tid, $message['PID']);

            }

        if($threaddata['POLL_FLAG'] == 'Y') {

          if ($message['PID'] == 1) {

            light_poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $closed, true);
            $last_pid = $message['PID'];

          }else {

            light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, true, true, $show_sigs);
            $last_pid = $message['PID'];

          }

        }else {

          light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, true, false, $show_sigs);
          $last_pid = $message['PID'];

        }
    }
}

unset($messages, $message);

if($last_pid < $threaddata['LENGTH']){
    $npid = $last_pid + 1;
    echo form_quick_button($HTTP_SERVER_VARS['PHP_SELF'], "Keep reading", "msg", "$tid.$npid");
}

light_messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $ppp);

echo "<h4><a href=\"./lthread_list.php\">Back to thread list</a></h4>";

light_html_draw_bottom();

if($msg_count > 0 && bh_session_get_value('UID') && bh_session_get_value('UID') != 0){
    messages_update_read($tid,$last_pid,bh_session_get_value('UID'));
}

?>
