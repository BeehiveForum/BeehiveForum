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

/* $Id: thread_list.php,v 1.142 2003-08-29 00:09:27 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// THREAD LIST DISPLAY

// Compress the output
require_once("./include/gzipenc.inc.php");

// Require functions
require_once("./include/html.inc.php"); // HTML functions
require_once("./include/threads.inc.php"); // Thread processing functions
require_once("./include/format.inc.php"); // Formatting functions
require_once("./include/form.inc.php"); // Form drawing functions
require_once("./include/header.inc.php");
require_once("./include/session.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/pm.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

header_no_cache();

// Check that required variables are set
if (bh_session_get_value('UID') == 0) {
    $user = 0; // default to UID 0 if no other UID specified
    if (!isset($HTTP_GET_VARS['mode'])) {
        if (!isset($HTTP_COOKIE_VARS['bh_thread_mode'])) {
            $mode = 0;
        }else{
            $mode = $HTTP_COOKIE_VARS['bh_thread_mode'];
        }
    } else {
        // non-logged in users can only display "All" threads or those in the past x days, since the other options would be impossible
        if ($HTTP_GET_VARS['mode'] == 0 || $HTTP_GET_VARS['mode'] == 3 || $HTTP_GET_VARS['mode'] == 4 || $HTTP_GET_VARS['mode'] == 5) {
            $mode = $HTTP_GET_VARS['mode'];
        } else {
            $mode = 0;
        }
    }
} else {
    $user = bh_session_get_value('UID');

    if (isset($HTTP_GET_VARS['markread'])) {

      if ($HTTP_GET_VARS['markread'] == 2) {
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
            } else {
                $mode = 0;
            }
        }else {
            $mode = $HTTP_COOKIE_VARS['bh_thread_mode'];
        }
    } else {
        $mode = $HTTP_GET_VARS['mode'];
    }
}

if (isset($HTTP_GET_VARS['folder'])) {
    $folder = $HTTP_GET_VARS['folder'];
    $mode = 0;
}

bh_setcookie('bh_thread_mode', $mode, 0);

if(!isset($HTTP_GET_VARS['start_from'])) { $start_from = 0; } else { $start_from = $HTTP_GET_VARS['start_from']; }

// Output XHTML header
html_draw_top();

// Drop out of PHP to start the HTML table
?>

<script language="JavaScript" type="text/javascript">
// Func to change the little icon next to each discussion title
function change_current_thread (thread_id) {
    if (current_thread > 0){
        document["t" + current_thread].src = "<?php echo style_image('bullet.png'); ?>";
    }
    document["t" + thread_id].src = "<?php echo style_image('current_thread.png'); ?>";
    current_thread = thread_id;
}
// -->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="postbody" colspan="2">
      <img src="<?php echo style_image('post.png'); ?>" height="15" alt="" />&nbsp;<a href="post.php" target="main"><?php echo $lang['newdiscussion']; ?></a><br />
      <img src="<?php echo style_image('poll.png'); ?>" height="15" alt="" />&nbsp;<a href="create_poll.php" target="main"><?php echo $lang['createpoll']; ?></a><br />
      <img src="<?php echo style_image('search.png'); ?>" height="15" alt="" />&nbsp;<a href="search.php" target="right"><?php echo $lang['search']; ?></a><br />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
<?

echo "      <form name=\"f_mode\" method=\"get\" action=\"".$HTTP_SERVER_VARS['PHP_SELF']."\">\n        ";

if (bh_session_get_value('UID') == 0) {

  $labels = array($lang['alldiscussions'], $lang['todaysdiscussions'], $lang['2daysback'], $lang['7daysback']);
  echo form_dropdown_array("mode", array(0, 3, 4, 5), $labels, $mode, "onchange=\"submit()\""). "\n        ";

}else {

  $labels = array($lang['alldiscussions'],$lang['unreaddiscussions'],$lang['unreadtome'],$lang['todaysdiscussions'],
                    $lang['2daysback'],$lang['7daysback'],$lang['highinterest'],$lang['unreadhighinterest'],
                    $lang['iverecentlyseen'],$lang['iveignored'],$lang['ivesubscribedto'],$lang['startedbyfriend'],
                    $lang['unreadstartedbyfriend'],$lang['polls'],$lang['stickythreads'],$lang['mostunreadposts']);

  echo form_dropdown_array("mode",range(0,15),$labels,$mode,"onchange=\"submit()\""). "\n        ";

}

echo form_submit("go",$lang['goexcmark']). "\n";

?>
      </form>
    </td>
  </tr>
<?php

// The tricky bit - displaying the right threads for whatever mode is selected

if (isset($folder)) {
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

if (!$folder_info) {

    echo "</table>\n";
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['couldnotretrievefolderinformation']}</h2>\n";

    html_draw_bottom();
    exit;
}

// Get total number of messages for each folder
$folder_msgs = threads_get_folder_msgs();

// Check to see if $folder_order is an array, and define it as one if not
if (!is_array($folder_order)) $folder_order = array();

// Sort the folders and threads correctly as per the URL query for the TID

if (isset($HTTP_GET_VARS['msg']) && strlen($HTTP_GET_VARS['msg']) > 0) {

    $threadvisible = false;

    list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);

    if(thread_can_view($tid, bh_session_get_value('UID'))) {

        if ($thread = thread_get($tid)) {

            foreach ($thread as $key => $value) {
                $thread[strtolower($key)] = $value;
                unset($thread[$key]);
            }

            $thread['title'] = _stripslashes($thread['title']);

            if (isset($thread['aid'])) $thread['attachments'] = 1;
            if (!isset($thread['relationship'])) $thread['relationship'] = 0;

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

}

// Work out if any folders have no messages and add them.
// Seperate them by INTEREST level

if (bh_session_get_value('UID') > 0) {

  if (isset($HTTP_GET_VARS['msg'])) {
    list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);
    if (thread_can_view($tid, bh_session_get_value('UID'))) {
      list(,$selectedfolder) = thread_get($tid);
    }
  }elseif (isset($HTTP_GET_VARS['folder'])) {
    $selectedfolder = $HTTP_GET_VARS['folder'];
  }else {
    $selectedfolder = 0;
  }

  $ignored_folders = array();

  while (list($fid, $folder_data) = each($folder_info)) {
    if (!$folder_data['INTEREST'] || (isset($selectedfolder) && $selectedfolder == $fid)) {
      if ((!in_array($fid, $folder_order)) && (!in_array($fid, $ignored_folders))) $folder_order[] = $fid;
    }else {
      if ((!in_array($fid, $folder_order)) && (!in_array($fid, $ignored_folders))) $ignored_folders[] = $fid;
    }
  }

  // Append ignored folders onto the end of the folder list.
  // This will make them appear at the bottom of the thread list.

  $folder_order = array_merge($folder_order, $ignored_folders);

}else {

  while (list($fid, $folder_data) = each($folder_info)) {
    if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
  }

}

// If no threads are returned, say something to that effect

if (!$thread_info) {
    echo "  <tr>\n";
    echo "    <td class=\"smalltext\" colspan=\"2\">{$lang['nomessagesinthiscategory']} <a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0\">{$lang['clickhere']}</a> {$lang['forallthreads']}.</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "  </tr>\n";
}

if ($start_from != 0 && $mode == 0 && !isset($folder)) echo "<tr><td class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></td></tr><tr><td>&nbsp;</td></tr>\n";

// Iterate through the information we've just got and display it in the right order

while (list($key1, $folder_number) = each($folder_order)) {

    echo "  <tr>\n";
    echo "    <td colspan=\"2\">\n";
    echo "      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"foldername\">\n";
    echo "            <img src=\"".style_image('folder.png')."\" height=\"15\" alt=\"{$lang['folder']}\" />\n";
    echo "            <a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&amp;folder=".$folder_number. "\" title=\""._htmlentities(_stripslashes($folder_info[$folder_number]['DESCRIPTION']))."\">". _htmlentities($folder_info[$folder_number]['TITLE']). "</a>\n";
    echo "          </td>\n";

    if (bh_session_get_value('UID') > 0) {

      echo "          <td class=\"folderpostnew\" width=\"15\">\n";

      if (!$folder_info[$folder_number]['INTEREST']) {
          echo "            <a href=\"user_folder.php?fid=". $folder_number. "&amp;interest=-1\"><img src=\"". style_image('folder_hide.png'). "\" border=\"0\" height=\"15\" alt=\"{$lang['ignorethisfolder']}\" /></a>\n";
      }else {
          echo "            <a href=\"user_folder.php?fid=". $folder_number. "&amp;interest=0\"><img src=\"". style_image('folder_show.png'). "\" border=\"0\" height=\"15\" alt=\"{$lang['stopignoringthisfolder']}\" /></a>\n";
      }

      echo "          </td>\n";

    }

    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";

    if ((bh_session_get_value('UID') == 0) || ($folder_info[$folder_number]['INTEREST'] != -1) || ($mode == 2) || (isset($selectedfolder) && $selectedfolder == $folder_number)) {

        if (is_array($thread_info)) {

            $visible_threads = false;

            foreach (array_keys($thread_info) as $thread_info_key) {
                if ($thread_info[$thread_info_key]['fid'] == $folder_number) $visible_threads = true;
            }

            echo "  <tr>\n";
            echo "    <td class=\"threads\" style=\"", ($visible_threads ? "border-bottom: 0px; " : ""), ($lang['_textdir'] == "ltr") ? "border-right: 0px" : "border-left: 0px", "\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&amp;folder=".$folder_number."\" class=\"folderinfo\" style=\"", ($lang['_textdir'] == "ltr") ? "text-align: left; float: left" : "text-align: right; float: right", "\">";

            if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                echo $folder_msgs[$folder_number];
            }else {
                echo "0";
            }

            echo "&nbsp;{$lang['threads']}</a></td>\n";
            echo "    <td class=\"threads\" style=\"", ($visible_threads ? "border-bottom: 0px; " : ""), ($lang['_textdir'] == "ltr") ? "border-left: 0px" : "border-right: 0px", "\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"";
            echo $folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD ? "post.php" : "create_poll.php";
            echo "?fid=".$folder_number."\" target=\"main\" class=\"folderpostnew\" style=\"", ($lang['_textdir'] == "ltr") ? "text-align: right; float: right" : "text-align: left; float: left", "\">{$lang['postnew']}</a></td>\n";
            echo "  </tr>\n";

            if ($start_from != 0 && isset($folder) && $folder_number == $folder) {
                echo "  <tr>\n";
                echo "    <td class=\"threads\" style=\"border-top: 0px; border-bottom: 0px;\" colspan=\"2\"><a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&amp;folder=$folder&start_from=".($start_from - 50)."\" class=\"folderinfo\">{$lang['prev50threads']}</a></td>\n";
                echo "  </tr>\n";
            }

            if ($visible_threads) {

                echo "  <tr>\n";
                echo "    <td class=\"threads\" style=\"border-top: 0px;\" colspan=\"2\">\n";
                echo "      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";

                while (list($key2, $thread) = each($thread_info)) {

                    if (!isset($visiblethreads) || !is_array($visiblethreads)) $visiblethreads = array();
                    if (!in_array($thread['tid'], $visiblethreads)) $visiblethreads[] = $thread['tid'];

                    if ($thread['fid'] == $folder_number) {

                        echo "        <tr>\n";
                        echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\" width=\"16\">";

                        if ($thread['last_read'] == 0) {

                            $number = "[".$thread['length']."&nbsp;{$lang['new']}]";
                            $latest_post = 1;

                            if(!isset($first_thread) && isset($HTTP_GET_VARS['msg'])) {
                                $first_thread = $thread['tid'];
                                echo "<img src=\"".style_image('current_thread.png')."\" name=\"t".$thread['tid']."\" align=\"middle\" height=\"15\" alt=\"\" />";
                            }else {
                                echo "<img src=\"".style_image('unread_thread.png')."\" name=\"t".$thread['tid']."\" align=\"middle\" height=\"15\" alt=\"\"/>";
                            }

                        }elseif ($thread['last_read'] < $thread['length']) {

                            $new_posts = $thread['length'] - $thread['last_read'];
                            $number = "[".$new_posts."&nbsp;{$lang['new']}&nbsp;{$lang['of']}&nbsp;".$thread['length']."]";
                            $latest_post = $thread['last_read'] + 1;

                            if(!isset($first_thread) && isset($HTTP_GET_VARS['msg'])) {
                                $first_thread = $thread['tid'];
                                echo "<img src=\"".style_image('current_thread.png')."\" name=\"t".$thread['tid']."\" align=\"middle\" height=\"15\" alt=\"\" />";
                            }else {
                                echo "<img src=\"".style_image('unread_thread.png')."\" name=\"t".$thread['tid']."\" align=\"middle\" height=\"15\" alt=\"\" />";
                            }

                        } else {

                            $number = "[".$thread['length']."]";
                            $latest_post = 1;

                            if(!isset($first_thread) && isset($HTTP_GET_VARS['msg'])) {
                                $first_thread = $thread['tid'];
                                echo "<img src=\"".style_image('current_thread.png')."\" name=\"t".$thread['tid']."\" align=\"middle\" height=\"15\" alt=\"\" />";
                            } else {
                                echo "<img src=\"".style_image('bullet.png')."\" name=\"t".$thread['tid']."\" align=\"middle\" height=\"15\" alt=\"\" />";
                            }

                        }

                        // work out how long ago the thread was posted and format the time to display
                        $thread_time = format_time($thread['modified']);
                        // $thread_author = thread_get_author($thread['tid']);

                        echo "&nbsp;</td>\n";
                        echo "          <td valign=\"top\">";
                        // With mouseover status message: echo "<a href=\"messages.php?msg=".$thread['tid'].".".$latest_post."\" target=\"right\" class=\"threadname\" onclick=\"change_current_thread('".$thread['tid']."');\" onmouseOver=\"status='#".$thread['tid']." Started by ". $thread_author ."';return true\" onmouseOut=\"window.status='';return true\" title=\"#".$thread['tid']. " Started by ". $thread_author. "\">".$thread['title']."</a>&nbsp;";
                        echo "<a href=\"messages.php?msg=".$thread['tid'].".".$latest_post."\" target=\"right\" class=\"threadname\" onclick=\"change_current_thread('".$thread['tid']."');\" title=\"#".$thread['tid']. " {$lang['startedby']} ". format_user_name($thread['logon'], $thread['nickname']) . "\">".$thread['title']."</a> ";
                        if ($thread['interest'] == 1) echo "<img src=\"".style_image('high_interest.png')."\" height=\"15\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" align=\"middle\" /> ";
                        if ($thread['interest'] == 2) echo "<img src=\"".style_image('subscribe.png')."\" height=\"15\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" align=\"middle\" /> ";
                        if ($thread['poll_flag'] == 'Y') echo "<img src=\"".style_image('poll.png')."\" height=\"15\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" align=\"middle\" /> ";
                        if ($thread['sticky'] == 'Y') echo "<img src=\"".style_image('sticky.png')."\" height=\"15\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" align=\"middle\" /> ";
                        if ($thread['relationship'] & USER_FRIEND) echo "<img src=\"" . style_image('friend.png') . "\" height=\"15\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" align=\"middle\" /> ";
                        if (isset($thread['attachments']) && $thread['attachments'] > 0) echo "<img src=\"" . style_image('attach.png') . "\" height=\"15\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" align=\"middle\" /> ";
                        echo "<span class=\"threadxnewofy\">".$number."</span></td>\n";
                        echo "          <td valign=\"top\" nowrap=\"nowrap\" align=\"right\"><span class=\"threadtime\">".$thread_time."&nbsp;</span></td>\n";
                        echo "        </tr>\n";

                    }
                }

                if (isset($folder) && $folder_number == $folder) {

                    $more_threads = $folder_msgs[$folder] - $start_from - 50;

                    if ($more_threads > 0 && $more_threads <= 50) {
                        echo "        <tr>\n";
                        echo "          <td colspan=\"3\"><a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\" class=\"folderinfo\">{$lang['next']} $more_threads {$lang['threads']}</a></td>\n";
                        echo "        </tr>\n";
                    }

                    if ($more_threads > 50) {
                        echo "        <tr>\n";
                        echo "          <td colspan=\"3\"><a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\" class=\"folderinfo\">{$lang['next50threads']}</a></td>\n";
                        echo "        </tr>\n";
                    }

                }

                echo "      </table>\n";
                echo "    </td>\n";
                echo "  </tr>\n";

            }

        }elseif ($folder_info[$folder_number]['INTEREST'] != -1) {

            // Only display the additional folder info if the user _DOESN'T_ have the folder on ignore

            echo "  <tr>\n";
            echo "    <td class=\"threads\" style=\"", ($lang['_textdir'] == 'ltr') ? "border-right: 1px" : "border-left: 1px", "\" align=\"left\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&amp;folder=".$folder_number."\" class=\"folderinfo\">";

            if (isset($folder_msgs[$folder_number])) {
                echo $folder_msgs[$folder_number];
            }else {
                echo "0";
            }

            echo " {$lang['threads']}</a></td>\n";
            echo "    <td class=\"threads\" style=\"", ($lang['_textdir'] == 'ltr') ? "border-left: 1px" : "border-right: 1px", "\" align=\"right\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"";
            echo $folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD ? "post.php" : "create_poll.php";
            echo "?fid=".$folder_number."\" target=\"main\" class=\"folderpostnew\">{$lang['postnew']}</a></td>\n";
            echo "  </tr>\n";

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
      if ($more_threads > 0 && $more_threads <= 50) echo "<tr><td colspan=\"2\">&nbsp;</td></tr><tr><td class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&start_from=".($start_from + 50)."\">{$lang['next']} $more_threads {$lang['threads']}</td></tr>\n";
      if ($more_threads > 50) echo "<tr><td colspan=\"2\">&nbsp;</td></tr><tr><td class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"".$HTTP_SERVER_VARS['PHP_SELF']."?mode=0&start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></td></tr>\n";

    }
}

echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (bh_session_get_value('UID') != 0) {

    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"smalltext\" colspan=\"2\">{$lang['markasread']}:</td>\n";
    echo "  </tr>\n";

    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td class=\"smalltext\">\n";
    echo "      <form name=\"f_mark\" method=\"get\" action=\"".$HTTP_SERVER_VARS['PHP_SELF']."\">\n";

    $labels = array($lang['alldiscussions'], $lang['next50discussions']);

    if (isset($visiblethreads) && is_array($visiblethreads)) {

        $labels[] = $lang['visiblediscussions'];
        echo "        ", form_input_hidden("tids", implode(',', $visiblethreads)), "\n";
    }

    echo "        ", form_dropdown_array("markread", range(0, sizeof($labels) -1), $labels, 0). "\n";
    echo "        ", form_submit("go",$lang['goexcmark']). "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"smalltext\" colspan=\"2\">{$lang['navigate']}:</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "    <td class=\"smalltext\">\n";
echo "      <form name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"right\">\n";
echo "        ", form_input_text('msg', '1.1', 10). "\n";
echo "        ", form_submit("go",$lang['goexcmark']). "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
echo "<!--\n";

if (isset($first_thread)) {
    echo "current_thread = ".$first_thread.";\n";
}else {
    echo "current_thread = 0;\n";
}

echo "// -->";
echo "</script>\n";

html_draw_bottom();

?>
