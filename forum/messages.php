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

// Compress the output
require_once("./include/gzipenc.inc.php");

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

if (!bh_session_check()) {

    if (isset($HTTP_GET_VARS['msg'])) {
      $uri = "./index.php?msg=". $HTTP_GET_VARS['msg'];
    }else {
      $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    }

    header_redirect($uri);

}

// Check that required variables are set
// default to display most recent discussion for user
if (isset($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    if (isset($HTTP_COOKIE_VARS['bh_sess_uid'])) {
        $msg = messages_get_most_recent($HTTP_COOKIE_VARS['bh_sess_uid']);
    }else {
        $msg = "1.1";
    }
}

if (isset($HTTP_GET_VARS['fontsize'])) {

    $userprefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);

    user_update_prefs($HTTP_COOKIE_VARS['bh_sess_uid'], $userprefs['FIRSTNAME'], $userprefs['LASTNAME'],
                      $userprefs['HOMEPAGE_URL'], $userprefs['PIC_URL'], $userprefs['EMAIL_NOTIFY'],
                      $userprefs['TIMEZONE'], $userprefs['DL_SAVING'], $userprefs['MARK_AS_OF_INT'],
                      $userprefs['POST_PER_PAGE'], $HTTP_GET_VARS['fontsize'], $userprefs['STYLE'],
                      $userprefs['VIEW_SIGS'], $userprefs['START_PAGE']);

    unset($userprefs);

    bh_session_init($HTTP_COOKIE_VARS['bh_sess_uid']);
    header_redirect($HTTP_SERVER_VARS['PHP_SELF']. "?msg=$msg");

}

@list($tid, $pid) = explode('.', $msg);
if ($tid == '') $tid = 1;
if ($pid == '') $pid = 1;

if(!thread_can_view($tid, $HTTP_COOKIE_VARS['bh_sess_uid'])){
	html_draw_top();
	echo "<h2>The requested thread could not be found. It has either been deleted or access was denied.</h2>";
	html_draw_bottom();
	exit;
}

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

  if (isset($HTTP_POST_VARS['confirm_pollclose'])) {

    poll_close($HTTP_POST_VARS['tid']);
    header_redirect("messages.php?msg=". $HTTP_POST_VARS['tid']. ".1");

  }else {

    html_draw_top_script();
    poll_confirm_close($HTTP_POST_VARS['tid']);
    html_draw_bottom();
    exit;

  }

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
if (!$messages) {
   echo "<h2>That post does not exist in this thread!</h2>\n";
   html_draw_bottom();
   exit;
}
$threaddata = thread_get($tid);
$closed = isset($threaddata['CLOSED']);
$foldertitle = folder_get_title($threaddata['FID']);
if($closed) $foldertitle .= " (closed)";

$show_sigs = !($HTTP_COOKIE_VARS['bh_sess_sig'] == 1);

$msg_count = count($messages);

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td>";

messages_top($foldertitle,_stripslashes($threaddata['TITLE']),$threaddata['INTEREST']);

echo "    </td>\n";

if ($threaddata['POLL_FLAG'] == 'Y' && $messages[0]['PID'] != 1) {

  if ($userpollvote = poll_user_has_voted($tid)) {
    echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?msg=$tid.1\" target=\"_self\" title=\"Click to change vote\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" /></a> You voted for option #", $userpollvote, "</td>\n";
  }else {
    echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?msg=$tid.1\" target=\"_self\" title=\"Click to vote\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" /></a> You have not voted</td>\n";
  }

}

echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

$highlight = array();

if (isset($HTTP_GET_VARS['search_string']) && strlen($HTTP_GET_VARS['search_string']) > 0) {
    $highlight = explode(' ', $HTTP_GET_VARS['search_string']);
}

if($msg_count > 0) {

    $first_msg = $messages[0]['PID'];
    foreach($messages as $message) {

        if (isset($message['RELATIONSHIP'])) {

          if($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
            $message['CONTENT'] = message_get_content($tid, $message['PID']);
          }else {
            $message['CONTENT'] = 'Ignored'; // must be set to something or will show as deleted
          }

	}else {

	  $message['CONTENT'] = message_get_content($tid, $message['PID']);

	}

        if($threaddata['POLL_FLAG'] == 'Y') {

          if ($message['PID'] == 1) {

            poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $closed, false, true, true, false, $highlight);
            $last_pid = $message['PID'];

          }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, true, true, $show_sigs, false, $highlight);
            $last_pid = $message['PID'];

          }

        }else {

          message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $closed, true, false, $show_sigs, false, $highlight);
          $last_pid = $message['PID'];

        }
    }
}

unset($messages, $message);

if($last_pid < $threaddata['LENGTH']){
    $npid = $last_pid + 1;
    echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td align=\"right\">\n";
    echo form_quick_button($HTTP_SERVER_VARS['PHP_SELF'], "Keep reading >>", "msg", "$tid.$npid");
    echo "</td></tr></table>\n";
}else {
    echo "<p>&nbsp;</p>\n";
}

messages_start_panel();
messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $ppp);

if($threaddata['POLL_FLAG'] == 'Y') {
    echo "<a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('pollresults.php?tid=", $tid, "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\">View Results</a>\n";
}

if ($HTTP_COOKIE_VARS['bh_sess_uid'] != 0) {

	messages_interest_form($tid, $pid);
	messages_fontsize_form($tid, $pid);

	if(perm_is_moderator()){
		messages_admin_form($tid,$pid,$threaddata['TITLE'],$closed);
	}
}

draw_beehive_bar();
messages_end_panel();
html_draw_bottom();

if($msg_count > 0 && isset($HTTP_COOKIE_VARS['bh_sess_uid']) && $HTTP_COOKIE_VARS['bh_sess_uid'] != 0){
    messages_update_read($tid,$last_pid,$HTTP_COOKIE_VARS['bh_sess_uid']);
}

?>
