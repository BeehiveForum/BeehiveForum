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

/* $Id: lthread_list.php,v 1.27 2004-03-06 13:45:50 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// "LIGHT" THREAD LIST DISPLAY

// Require functions
require_once("./include/html.inc.php");
require_once("./include/threads.inc.php");
require_once("./include/format.inc.php");
require_once("./include/session.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/light.inc.php");
require_once("./include/lang.inc.php");

if(!bh_session_check() || bh_session_get_value('UID') == 0){

    $uri = "./llogon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

// Check that required variables are set

$user = bh_session_get_value('UID');

if (isset($HTTP_GET_VARS['markread'])) {

    if ($HTTP_GET_VARS['markread'] == 2 && isset($HTTP_GET_VARS['tids']) && is_array($HTTP_GET_VARS['tids'])) {
        threads_mark_read(explode(',', $HTTP_GET_VARS['tids']));
    }elseif ($HTTP_GET_VARS['markread'] == 0) {
        threads_mark_all_read();
    }elseif ($HTTP_GET_VARS['markread'] == 1) {
        threads_mark_50_read();
    }
}

if (!isset($HTTP_GET_VARS['mode'])) {
    if (!isset($HTTP_COOKIE_VARS['bh_thread_mode'])) {
        if (threads_any_unread()) { // default to "Unread" messages for a logged-in user, unless there aren't any
            $mode = 1;
        }else {
            $mode = 0;
        }
    }else {
        $mode = (is_numeric($HTTP_COOKIE_VARS['bh_thread_mode'])) ? $HTTP_COOKIE_VARS['bh_thread_mode'] : 0;
    }
}else {
    $mode = (is_numeric($HTTP_GET_VARS['mode'])) ? $HTTP_GET_VARS['mode'] : 0;
}

if (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {
    $folder = $HTTP_GET_VARS['folder'];
    $mode = 0;
}

bh_setcookie('bh_thread_mode', $mode);

if (isset($HTTP_GET_VARS['start_from']) && is_numeric($HTTP_GET_VARS['start_form'])) {
    $start_from = $HTTP_GET_VARS['start_from'];
}else {
    $start_from = 0;
}

// Output XHTML header
light_html_draw_top();

echo "<form name=\"f_mode\" method=\"get\" action=\"lthread_list.php\">\n        ";

if (bh_session_get_value('UID') == 0) {

  $labels = array($lang['alldiscussions'], $lang['todaysdiscussions'], $lang['2daysback'], $lang['7daysback']);
  echo light_form_dropdown_array("mode", array(0, 3, 4, 5), $labels, $mode). "\n        ";

}else {

  $labels = array($lang['alldiscussions'],$lang['unreaddiscussions'],$lang['unreadtome'],$lang['todaysdiscussions'],
                  $lang['2daysback'],$lang['7daysback'],$lang['highinterest'],$lang['unreadhighinterest'],
                  $lang['iverecentlyseen'],$lang['iveignored'],$lang['ivesubscribedto'],$lang['startedbyfriend'],
                  $lang['unreadstartedbyfriend'],$lang['polls'],$lang['stickythreads'],$lang['mostunreadposts']);

  echo light_form_dropdown_array("mode",range(0,15),$labels,$mode). "\n        ";

}

echo light_form_submit("go",$lang['goexcmark']). "\n";

echo "</form>\n";

// The tricky bit - displaying the right threads for whatever mode is selected

if(isset($folder)){
    list($thread_info, $folder_order) = threads_get_folder($user, $folder, $start_from);
} else {
    switch ($mode) {
        case 0: // All discussions
            list($thread_info, $folder_order) = threads_get_all($user, $start_from);
            break;
        case 1; // Unread discussions
            list($thread_info, $folder_order) = threads_get_unread($user);
            break;
        case 2; // Unread discussions To: Me
            list($thread_info, $folder_order) = threads_get_unread_to_me($user);
            break;
        case 3; // Today's discussions
            list($thread_info, $folder_order) = threads_get_by_days($user, 1);
            break;
        case 4; // 2 days back
            list($thread_info, $folder_order) = threads_get_by_days($user, 2);
            break;
        case 5; // 7 days back
            list($thread_info, $folder_order) = threads_get_by_days($user, 7);
            break;
        case 6; // High interest
            list($thread_info, $folder_order) = threads_get_by_interest($user, 1);
            break;
        case 7; // Unread high interest
            list($thread_info, $folder_order) = threads_get_unread_by_interest($user, 1);
            break;
        case 8; // Recently seen
            list($thread_info, $folder_order) = threads_get_recently_viewed($user);
            break;
        case 9; // Ignored
            list($thread_info, $folder_order) = threads_get_by_interest($user, -1);
            break;
        case 10; // Subscribed to
            list($thread_info, $folder_order) = threads_get_by_interest($user, 2);
            break;
        case 11: // Started by friend
            list($thread_info, $folder_order) = threads_get_by_relationship($user, USER_FRIEND);
            break;
        case 12: // Unread started by friend
            list($thread_info, $folder_order) = threads_get_unread_by_relationship($user, USER_FRIEND);
            break;
        case 13: // Polls
            list($thread_info, $folder_order) = threads_get_polls($user);
            break;
        case 14: // Sticky threads
            list($thread_info, $folder_order) = threads_get_sticky($user);
            break;
        case 15: // Most unread posts
            list($thread_info, $folder_order) = threads_get_longest_unread($user);
            break;
    }
}

// Now, the actual bit that displays the threads...

// Get folder FIDs and titles
$folder_info = threads_get_folders();
if (!$folder_info) die ("<p>{$lang['couldnotretrievefolderinformation']}</p>");

// Get total number of messages for each folder
$folder_msgs = threads_get_folder_msgs();

// Check to see if $folder_order is an array, and define it as one if not
if (!is_array($folder_order)) $folder_order = array();

// Sort the folders and threads correctly as per the URL query for the TID

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

    $threadvisible = false;

    list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);

    if(thread_can_view($tid, bh_session_get_value('UID'))) {

        list($thread['tid'], $thread['fid'], $thread['title'], $thread['length'], $thread['poll_flag'],
             $thread['modified'], $thread['closed'], $thread['interest'], $thread['last_read'])  = thread_get($tid);

        $thread['title'] = _stripslashes($thread['title']);

        if ($thread['tid'] == $tid) {

            if (in_array($thread['fid'], $folder_order)) {
              array_splice($folder_order, array_search($thread['fid'], $folder_order), 1);
            }

            array_unshift($folder_order, $thread['fid']);

            for ($i = 0; $i < sizeof($thread_info); $i++) {

                if ($thread_info[$i]['tid'] == $tid) {
                    $thread_info = array_merge(array_splice($thread_info, $i, 1), $thread_info);
                    $threadvisible = true;
                }

            }

            if (!$threadvisible && is_array($thread_info)) array_unshift($thread_info, $thread);

        }
    }

}

// Work out if any folders have no messages and add them.
// Seperate them by INTEREST level

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);
    list(,$selectedfolder) = thread_get($tid);
}elseif (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {
    $selectedfolder = $HTTP_GET_VARS['folder'];
}else {
    $selectedfolder = 0;
}

while (list($fid, $folder_data) = each($folder_info)) {
  if (!$folder_data['INTEREST'] || ($selectedfolder == $fid)) {
    if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
  }else {
    $ignored_folders[] = $fid;
  }
}

// Append ignored folders onto the end of the folder list.
// This will make them appear at the bottom of the thread list.

if (isset($ignored_folders)) $folder_order = array_merge($folder_order, $ignored_folders);

// If no threads are returned, say something to that effect

if (!$thread_info) {
    echo "<p>{$lang['nomessagesinthiscategory']} <a href=\"lthread_list.php?mode=0\">{$lang['clickhere']}</a> {$lang['forallthreads']}.</p>\n";
}

if ($start_from != 0 && $mode == 0 && !isset($folder)) echo "<p><a href=\"lthread_list.php?mode=0&start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></p>\n";

// Iterate through the information we've just got and display it in the right order

while (list($key1, $folder_number) = each($folder_order)) {

    echo "<h3><a href=\"lthread_list.php?mode=0&folder=".$folder_number. "\">". $folder_info[$folder_number]['TITLE'] . "</a></h3>";

    if ((!$folder_info[$folder_number]['INTEREST']) || ($mode == 2) || (isset($selectedfolder) && $selectedfolder == $folder_number)) {

        if (is_array($thread_info)) {

            echo "<p>";

            if (isset($folder_msgs[$folder_number])) {
                echo $folder_msgs[$folder_number];
            }else {
                echo "0";
            }

            echo " {$lang['threads']}";
            if ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) echo " - <b><a href=\"lpost.php?fid=".$folder_number."\">{$lang['postnew']}</a></b>";
            echo "</p>\n";

            if ($start_from != 0 && isset($folder) && $folder_number == $folder) echo "<p><i><a href=\"lthread_list.php?mode=0&folder=$folder&start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></i></p>\n";

            echo "<ul>\n";

            while (list($key2, $thread) = each($thread_info)) {

                if (!isset($visiblethreads) || !is_array($visiblethreads)) $visiblethreads = array();
                if (!in_array($thread['tid'], $visiblethreads)) $visiblethreads[] = $thread['tid'];

                if ($thread['fid'] == $folder_number) {

                    echo "<li>\n";

                    if ($thread['last_read'] == 0) {

                        $number = "[".$thread['length']."&nbsp;new]";
                        $latest_post = 1;

                    }elseif ($thread['last_read'] < $thread['length']) {

                        $new_posts = $thread['length'] - $thread['last_read'];
                        $number = "[".$new_posts."&nbsp;new&nbsp;of&nbsp;".$thread['length']."]";
                        $latest_post = $thread['last_read'] + 1;

                    } else {

                        $number = "[".$thread['length']."]";
                        $latest_post = 1;

                    }

                    // work out how long ago the thread was posted and format the time to display
                    $thread_time = format_time($thread['modified']);

                    echo "<a href=\"lmessages.php?msg=".$thread['tid'].".".$latest_post."\" title=\"#".$thread['tid']. " {$lang['startedby']} ". format_user_name($thread['logon'], $thread['nickname']) . "\">".$thread['title']."</a> ";
                    if ($thread['interest'] == 1) echo "<font color=\"#FF0000\">(HI)</font> ";
                    if ($thread['interest'] == 2) echo "<font color=\"#FF0000\">(Sub)</font> ";
                    if ($thread['poll_flag'] == 'Y') echo "(P) ";
                    if ($thread['sticky'] == 'Y') echo "(St) ";
                    if ($thread['relationship'] & USER_FRIEND) echo "(Fr) ";
                    echo $number." ";
                    echo $thread_time." ";
                    echo "</li>\n";
                }
            }

            echo "</ul>\n";

            if (isset($folder) && $folder_number == $folder) {

                $more_threads = $folder_msgs[$folder] - $start_from - 50;

                if ($more_threads > 0 && $more_threads <= 50) echo "<p><i><a href=\"lthread_list.php?mode=0&folder=$folder&start_from=".($start_from + 50)."\">{$lang['next']} $more_threads {$lang['threads']}</a></i></p>\n";
                if ($more_threads > 50) echo "<p><i><a href=\"lthread_list.php?mode=0&folder=$folder&start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></i></p>\n";

            }

        }elseif ($folder_info[$folder_number]['INTEREST'] != -1) {

            echo "<p><a href=\"lthread_list.php?mode=0&folder=".$folder_number."\">";

            if (isset($folder_msgs[$folder_number])) {
                echo $folder_msgs[$folder_number];
            }else {
                echo "0";
            }

            echo " {$lang['threads']}</a>";
            if ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) echo " - <b><a href=\"lpost.php?fid=".$folder_number."\">{$lang['postnew']}</a></b>";
            echo "</p>\n";
        }

    }

    if (is_array($thread_info)) reset($thread_info);
}

if ($mode == 0 && !isset($folder)) {

    $total_threads = 0;

    if (is_array($folder_msgs)) {

      while (list($fid, $num_threads) = each($folder_msgs)) {
        $total_threads += $num_threads;
      }

      $more_threads = $total_threads - $start_from - 50;
      if ($more_threads > 0 && $more_threads <= 50) echo "<p><a href=\"lthread_list.php?mode=0&start_from=".($start_from + 50)."\">{$lang['next']} $more_threads {$lang['threads']}</p>\n";
      if ($more_threads > 50) echo "<p><a href=\"lthread_list.php?mode=0&start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></p>\n";

    }
}

if (bh_session_get_value('UID') != 0) {

    echo "  <h5>{$lang['markasread']}:</h5>\n";
    echo "    <form name=\"f_mark\" method=\"get\" action=\"lthread_list.php\">\n";

    $labels = array($lang['alldiscussions'], $lang['next50discussions']);

    if (isset($visiblethreads) && is_array($visiblethreads)) {

        $labels[] = $lang['visiblediscussions'];
        echo form_input_hidden("tids", implode(',', $visiblethreads));
    }

    echo light_form_dropdown_array("markread", range(0, sizeof($labels) -1), $labels, 0). "\n        ";
    echo light_form_submit("go",$lang['goexcmark']). "\n";
    echo "    </form>\n";

}

echo "<p><a href=\"llogout.php\">{$lang['logout']}</a></p>\n";
light_html_draw_bottom();

?>