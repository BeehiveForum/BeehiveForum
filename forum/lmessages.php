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

/* $Id: lmessages.php,v 1.23 2004-03-13 20:04:34 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/beehive.inc.php");
include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/light.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

// Check that required variables are set
// default to display most recent discussion for user

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    if (bh_session_get_value('UID')) {
        $msg = messages_get_most_recent(bh_session_get_value('UID'));
    } else {
        $msg = "1.1";
    }
}

list($tid, $pid) = explode('.', $msg);
if ($tid == '') $tid = 1;
if ($pid == '') $pid = 1;

if (!thread_can_view($tid, bh_session_get_value('UID'))) {
        light_html_draw_top();
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        light_html_draw_bottom();
        exit;
}

// Poll stuff

if (isset($HTTP_POST_VARS['pollsubmit'])) {

  if (isset($HTTP_POST_VARS['pollvote'])) {

    poll_vote($HTTP_POST_VARS['tid'], $HTTP_POST_VARS['pollvote']);
    header_redirect("lmessages.php?webtag={$webtag['WEBTAG']}&msg=". $HTTP_POST_VARS['tid']. ".1");

  }else {

    light_html_draw_top();
    echo "<h2>{$lang['mustselectpolloption']}</h2>";
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
$foldertitle = folder_get_title($threaddata['FID']);

$show_sigs = false; // explicitly set sigs not to show in light mode

$msg_count = count($messages);

light_messages_top($foldertitle, _stripslashes($threaddata['TITLE']), $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK']);

if ($msg_count > 0) {
    $first_msg = $messages[0]['PID'];
    foreach($messages as $message) {

        if (isset($message['RELATIONSHIP'])) {

            if ($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                $message['CONTENT'] = message_get_content($tid, $message['PID']);
            } else {
                $message['CONTENT'] = $lang['ignored']; // must be set to something or will show as deleted
            }

            } else {

                $message['CONTENT'] = message_get_content($tid, $message['PID']);

            }

        if ($threaddata['POLL_FLAG'] == 'Y') {

          if ($message['PID'] == 1) {

            light_poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true);
            $last_pid = $message['PID'];

          }else {

            light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true, true, $show_sigs);
            $last_pid = $message['PID'];

          }

        }else {

          light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true, false, $show_sigs);
          $last_pid = $message['PID'];

        }
    }
}

unset($messages, $message);

if ($last_pid < $threaddata['LENGTH']) {
    $npid = $last_pid + 1;
    echo form_quick_button("./lmessages.php?webtag={$webtag['WEBTAG']}", $lang['keepreading'], "msg", "$tid.$npid");
}

light_messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $ppp);

echo "<h4><a href=\"lthread_list.php?webtag={$webtag['WEBTAG']}\">{$lang['backtothreadlist']}</a></h4>";

light_html_draw_bottom();

if ($msg_count > 0 && bh_session_get_value('UID') && bh_session_get_value('UID') != 0) {
    messages_update_read($tid,$last_pid,bh_session_get_value('UID'));
}

?>