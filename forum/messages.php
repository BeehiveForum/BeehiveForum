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

/* $Id: messages.php,v 1.113 2004-03-11 22:34:36 decoyduck Exp $ */

//Multiple forum support
include_once("./include/forum.inc.php");

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Require functions
include_once("./include/session.inc.php"); // Session functions
include_once("./include/html.inc.php"); // HTML functions
include_once("./include/thread.inc.php"); // Thread processing functions
include_once("./include/messages.inc.php"); // Message processing functions
include_once("./include/folder.inc.php"); // Folder processing functions
include_once("./include/beehive.inc.php"); // Beehive stuff
include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/config.inc.php");
include_once("./include/header.inc.php");
include_once("./include/user.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/lang.inc.php");

if (!isset($allow_post_editing)) $allow_post_editing = true;
if (!isset($post_edit_time)) $post_edit_time = 0;

if (!bh_session_check()) {

    if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
      $uri = "./index.php?webtag=$webtag&msg=". $HTTP_GET_VARS['msg'];
    }else {
      $uri = "./index.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    }

    header_redirect($uri);

}

// Check that required variables are set
// default to display most recent discussion for user
if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

@list($tid, $pid) = explode('.', $msg);

if (!isset($tid) || !is_numeric($tid)) $tid = 1;
if (!isset($pid) || !is_numeric($pid)) $pid = 1;

if(!thread_can_view($tid, bh_session_get_value('UID'))) {
        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
}

// Poll stuff

if (isset($HTTP_POST_VARS['pollsubmit'])) {

  if (isset($HTTP_POST_VARS['pollvote'])) {

    poll_vote($HTTP_POST_VARS['tid'], $HTTP_POST_VARS['pollvote']);
    header_redirect("./messages.php?webtag=$webtag&msg=". $HTTP_POST_VARS['tid']. ".1");

  }else {

    html_draw_top();
    echo "<h2>{$lang['mustselectpolloption']}</h2>";
    html_draw_bottom();
    exit;

  }

}elseif (isset($HTTP_POST_VARS['pollclose'])) {

  if (isset($HTTP_POST_VARS['confirm_pollclose'])) {

    poll_close($HTTP_POST_VARS['tid']);
    header_redirect("./messages.php?webtag=$webtag&msg=". $HTTP_POST_VARS['tid']. ".1");

  }else {

    html_draw_top("openprofile.js");
    poll_confirm_close($HTTP_POST_VARS['tid']);
    html_draw_bottom();
    exit;

  }

}elseif (isset($HTTP_POST_VARS['pollchangevote'])) {

  poll_delete_vote($HTTP_POST_VARS['tid']);
  header_redirect("./messages.php?webtag=$webtag&msg=". $HTTP_POST_VARS['tid']. ".1");

}

html_draw_top("openprofile.js", "basetarget=_blank");

if (bh_session_get_value('POSTS_PER_PAGE')) {
    $ppp = bh_session_get_value('POSTS_PER_PAGE');
} else {
    $ppp = 20;
}

$messages = messages_get($tid, $pid, $ppp);

if (!$messages) {
   echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
   html_draw_bottom();
   exit;
}

if (!$threaddata = thread_get($tid)) {
   echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
   html_draw_bottom();
   exit;
}

if (isset($threaddata['STICKY']) && isset($threaddata['STICKY_UNTIL'])) {

    if ($threaddata['STICKY'] == "Y" && $threaddata['STICKY_UNTIL'] != 0 && time() > $threaddata['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $threaddata['STICKY'] == "N";
    }
}

$foldertitle = folder_get_title($threaddata['FID']);

$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$msg_count = count($messages);

$highlight = array();

if (isset($HTTP_GET_VARS['search_string']) && strlen(trim($HTTP_GET_VARS['search_string'])) > 0) {
    $highlight = explode(' ', rawurldecode($HTTP_GET_VARS['search_string']));
}

if (sizeof($highlight) > 0) {
    $thread_parts = preg_split('/([<|>])/', $threaddata['TITLE'], -1, PREG_SPLIT_DELIM_CAPTURE);
    foreach ($highlight as $word) {
        $word = preg_quote($word, '/');
        for ($i = 0; $i < sizeof($thread_parts); $i++) {
            if (!($i % 4)) {
                $thread_parts[$i] = preg_replace("/($word)/i", "<span class=\"highlight\">\\1</span>", $thread_parts[$i]);
            }
        }
    }
    $threaddata['TITLE'] = implode('', $thread_parts);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">";

messages_top($foldertitle, _stripslashes($threaddata['TITLE']), $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK']);

echo "    </td>\n";

if ($threaddata['POLL_FLAG'] == 'Y' && $messages[0]['PID'] != 1) {

  if ($userpollvote = poll_get_user_vote($tid)) {
    if ($userpollvote ^ POLL_MULTIVOTE) {
      for ($i = 0; $i < sizeof($userpollvote); $i++) {
        $userpollvotes_array[] = $userpollvote[$i]['OPTION_ID'];
      }
      if (sizeof($userpollvotes_array) > 1) {
        echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" /></a> {$lang['youvotedforoptions']}: ", implode(", ", $userpollvotes_array), "</td>\n";
      }else {
        echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" /></a> {$lang['youvotedforoption']} #", implode(", ", $userpollvotes_array), "</td>\n";
      }
    }
  }else {
    echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktovote']}\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" /></a> {$lang['youhavenotvoted']}</td>\n";
  }

}

echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

if($msg_count > 0) {

    $first_msg = $messages[0]['PID'];
    foreach($messages as $message) {

        if (isset($message['RELATIONSHIP'])) {

          if($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
            $message['CONTENT'] = message_get_content($tid, $message['PID']);
          }else {
            $message['CONTENT'] = $lang['ignored']; // must be set to something or will show as deleted
          }

        }else {

          $message['CONTENT'] = message_get_content($tid, $message['PID']);

        }

        if($threaddata['POLL_FLAG'] == 'Y') {

          if ($message['PID'] == 1) {

            poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], false, true, true, false, $highlight);
            $last_pid = $message['PID'];

          }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true, true, $show_sigs, false, $highlight);
            $last_pid = $message['PID'];

          }

        }else {

          message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true, false, $show_sigs, false, $highlight);
          $last_pid = $message['PID'];

        }
    }
}

unset($messages, $message);

if($msg_count > 0 && bh_session_get_value('UID') && bh_session_get_value('UID') != 0){
    messages_update_read($tid, $last_pid, bh_session_get_value('UID'));
}

if ($last_pid < $threaddata['LENGTH']) {
    $npid = $last_pid + 1;
    echo "<div align=\"center\"><table width=\"96%\" border=\"0\"><tr><td align=\"right\">\n";
    echo form_quick_button("./messages.php?webtag=$webtag", "{$lang['keepreading']} >>", "msg", "$tid.$npid");
    echo "</td></tr></table>\n";
}else {
    echo "<p>&nbsp;</p>\n";
}

messages_start_panel();
messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $ppp);

if ($threaddata['POLL_FLAG'] == 'Y') {
    echo "<p><a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('pollresults.php?webtag=$webtag&tid=", $tid, "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\">{$lang['viewresults']}</a></p>\n";
}

if (bh_session_get_value('UID') != 0) {

        messages_interest_form($tid, $pid);
        messages_fontsize_form($tid, $pid);

        if (perm_is_moderator()) {
        
            messages_admin_form($threaddata['FID'], $tid, $pid, $threaddata['TITLE'], $threaddata['CLOSED'], ($threaddata['STICKY'] == "Y") ? true : false, $threaddata['STICKY_UNTIL'], $threaddata['ADMIN_LOCK']);
            
        }elseif (($threaddata['FROM_UID'] == bh_session_get_value('UID')) && $threaddata['ADMIN_LOCK'] == 0) {
                    
            if (($allow_post_editing && $post_edit_time == 0) || ((time() - $threaddata['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS))) {
        
                messages_edit_thread($threaddata['FID'], $tid, $pid, $threaddata['TITLE']);
            }
        }
}

draw_beehive_bar();
messages_end_panel();
messages_forum_stats($tid, $pid);
html_draw_bottom();

?>