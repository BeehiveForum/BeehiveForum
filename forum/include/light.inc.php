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

/* $Id: light.inc.php,v 1.107 2006-09-13 18:58:46 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "myforums.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function light_html_draw_top ($title = false)
{
    $lang = load_language_file();

    if (defined('BEEHIVE_LIGHT_INCLUDE')) return false;

    if (!isset($title) || !$title) {
        $title = forum_get_setting('forum_name', false, 'A Beehive Forum');
    }

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";

    $stylesheet = html_get_style_sheet();
    echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" />\n";

    echo "</head>\n";
    echo "<body>\n";
}

function light_html_draw_bottom ()
{
    if (defined('BEEHIVE_LIGHT_INCLUDE')) return false;

    echo "</body>\n";
    echo "</html>\n";
}

function light_draw_logon_form()
{
    $lang = load_language_file();

    $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

    echo "<form name=\"logonform\" action=\"llogon.php\" method=\"post\">\n";

    echo "<p>{$lang['username']}: ";
    echo light_form_input_text("user_logon", (isset($_COOKIE['bh_light_remember_username']) ? $_COOKIE['bh_light_remember_username'] : "")). "</p>\n";

    echo "<p>{$lang['passwd']}: ";
    echo light_form_input_password("user_password", (isset($_COOKIE['bh_light_remember_password']) ? $_COOKIE['bh_light_remember_password'] : "")). "</p>\n";

    echo "<p>", form_checkbox("remember_user", "Y", $lang['rememberpassword'], (isset($_COOKIE['bh_light_remember_username']) && isset($_COOKIE['bh_light_remember_password']) ? true : false)), "</p>\n";

    echo "<p>", form_submit('submit', $lang['logon']), "</p>\n";

    echo "</form>\n";
}

function light_draw_thread_list($mode = 0, $folder = false, $start_from = 0)
{
    $webtag = get_webtag($webtag_search);

    $lang = load_language_file();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    echo "<form name=\"f_mode\" method=\"get\" action=\"lthread_list.php\">\n";
    echo "  ", form_input_hidden("webtag", $webtag), "\n";
    echo "  ", light_threads_draw_discussions_dropdown($mode), "\n";
    echo "  ", light_form_submit("go", $lang['goexcmark']), "\n";
    echo "</form>\n";

    // The tricky bit - displaying the right threads for whatever mode is selected

    if (isset($folder) && $folder !== false) {
        list($thread_info, $folder_order) = threads_get_folder($uid, $folder, $start_from);
    } else {
        switch ($mode) {
            case 0: // All discussions
                list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
                break;
            case 1; // Unread discussions
                list($thread_info, $folder_order) = threads_get_unread($uid);
                break;
            case 2; // Unread discussions To: Me
                list($thread_info, $folder_order) = threads_get_unread_to_me($uid);
                break;
            case 3; // Today's discussions
                list($thread_info, $folder_order) = threads_get_by_days($uid, 1);
                break;
            case 4: // Unread today
                list($thread_info, $folder_order) = threads_get_unread_by_days($uid);
                break;
            case 5; // 2 days back
                list($thread_info, $folder_order) = threads_get_by_days($uid, 2);
                break;
            case 6; // 7 days back
                list($thread_info, $folder_order) = threads_get_by_days($uid, 7);
                break;
            case 7; // High interest
                list($thread_info, $folder_order) = threads_get_by_interest($uid, 1);
                break;
            case 8; // Unread high interest
                list($thread_info, $folder_order) = threads_get_unread_by_interest($uid, 1);
                break;
            case 9; // Recently seen
                list($thread_info, $folder_order) = threads_get_recently_viewed($uid);
                break;
            case 10; // Ignored
                list($thread_info, $folder_order) = threads_get_by_interest($uid, -1);
                break;
            case 11; // By Ignored Users
                list($thread_info, $folder_order) = threads_get_by_relationship($uid, USER_IGNORED_COMPLETELY);
                break;
            case 12; // Subscribed to
                list($thread_info, $folder_order) = threads_get_by_interest($uid, 2);
                break;
            case 13: // Started by friend
                list($thread_info, $folder_order) = threads_get_by_relationship($uid, USER_FRIEND);
                break;
            case 14: // Unread started by friend
                list($thread_info, $folder_order) = threads_get_unread_by_relationship($uid, USER_FRIEND);
                break;
            case 15: // Started by me
                list($thread_info, $folder_order) = threads_get_started_by_me($uid);
                break;
            case 16: // Polls
                list($thread_info, $folder_order) = threads_get_polls($uid);
                break;
            case 17: // Sticky threads
                list($thread_info, $folder_order) = threads_get_sticky($uid);
                break;
            case 18: // Most unread posts
                list($thread_info, $folder_order) = threads_get_longest_unread($uid);
                break;
            default: // Default to all threads
                list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
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

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        $threadvisible = false;

        list($tid, $pid) = explode('.', $_GET['msg']);

        if ($thread = thread_get($tid)) {

            if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

            if ($thread['TID'] == $tid) {

                if (in_array($thread['FID'], $folder_order)) {
                    array_splice($folder_order, array_search($thread['FID'], $folder_order), 1);
                }

                array_unshift($folder_order, $thread['FID']);

                if (!is_array($thread_info)) $thread_info = array();

                foreach ($thread_info as $key => $thread_data) {
                    if ($thread_data['TID'] == $tid) {
                        unset($thread_info[$key]);
                        break;
                    }
                }

                array_unshift($thread_info, $thread);
            }
        }
    }

    // Work out if any folders have no messages and add them.
    // Seperate them by INTEREST level

    if (bh_session_get_value('UID') > 0) {

        if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            list($tid, $pid) = explode('.', $_GET['msg']);

            if ($thread = thread_get($tid)) {

                $selected_folder = $thread['FID'];
            }

        }elseif (isset($_GET['folder'])) {

            $selected_folder = $_GET['folder'];

        }else {

            $selected_folder = 0;
        }

        $ignored_folders = array();

        while (list($fid, $folder_data) = each($folder_info)) {
            if ($folder_data['INTEREST'] == 0 || (isset($selected_folder) && $selected_folder == $fid)) {
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

        echo "<p>{$lang['nomessagesinthiscategory']} <a href=\"lthread_list.php?webtag=$webtag&amp;mode=0\">{$lang['clickhere']}</a> {$lang['forallthreads']}.</p>\n";
    }

    if ($start_from != 0 && $mode == 0 && !isset($folder)) echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></p>\n";

    // Iterate through the information we've just got and display it in the right order

    foreach ($folder_order as $key1 => $folder_number) {

        if (isset($folder_info[$folder_number]) && is_array($folder_info[$folder_number])) {

            echo "<h3><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder_number\">". apply_wordfilter($folder_info[$folder_number]['TITLE']) . "</a></h3>";

            if ((!$folder_info[$folder_number]['INTEREST']) || ($mode == 2) || (isset($selected_folder) && $selected_folder == $folder_number)) {

                if (is_array($thread_info)) {

                    echo "<p>";

                    if (isset($folder_msgs[$folder_number])) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo " {$lang['threads']}";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        if ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) echo " - <b><a href=\"lpost.php?webtag=$webtag&amp;fid=$folder_number\">{$lang['postnew']}</a></b>";
                    }

                    echo "</p>\n";

                    if ($start_from != 0 && isset($folder) && $folder_number == $folder) echo "<p><i><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></i></p>\n";

                    $folder_list_start = false;
                    $folder_list_end   = false;

                    foreach($thread_info as $key2 => $thread) {

                        if (!isset($visiblethreads) || !is_array($visiblethreads)) $visiblethreads = array();
                        if (!in_array($thread['TID'], $visiblethreads)) $visiblethreads[] = $thread['TID'];

                        if ($thread['FID'] == $folder_number) {

                            if ($folder_list_start === false) {

                                echo "<ul>\n";
                                $folder_list_start = true;
                            }
                           
                            echo "<li>\n";

                            if ($thread['LAST_READ'] == 0) {

                                $number = "[{$thread['LENGTH']}&nbsp;new]";
                                $latest_post = 1;

                            }elseif ($thread['LAST_READ'] < $thread['LENGTH']) {

                                $new_posts = $thread['LENGTH'] - $thread['LAST_READ'];
                                $number = "[{$new_posts}&nbsp;new&nbsp;of&nbsp;{$thread['LENGTH']}]";
                                $latest_post = $thread['LAST_READ'] + 1;

                            } else {

                                $number = "[{$thread['LENGTH']}]";
                                $latest_post = 1;

                            }

                            // work out how long ago the thread was posted and format the time to display
                            $thread_time = format_time($thread['MODIFIED']);

                            echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg={$thread['TID']}.$latest_post\" title=\"#{$thread['TID']} {$lang['startedby']} ". format_user_name($thread['LOGON'], $thread['NICKNAME']) . "\">".apply_wordfilter($thread['TITLE'])."</a> ";
                            if ($thread['INTEREST'] == 1) echo "<font color=\"#FF0000\">(HI)</font> ";
                            if ($thread['INTEREST'] == 2) echo "<font color=\"#FF0000\">(Sub)</font> ";
                            if ($thread['POLL_FLAG'] == 'Y') echo "(P) ";
                            if ($thread['STICKY'] == 'Y') echo "(St) ";
                            if ($thread['RELATIONSHIP']&USER_FRIEND) echo "(Fr) ";
                            echo $number." ";
                            echo $thread_time." ";
                            echo "</li>\n";
                        }
                    }

                    if ($folder_list_end === false && $folder_list_start === true) {

                        echo "</ul>\n";
                        $folder_list_end = true;
                    }

                    if (isset($folder) && $folder_number == $folder) {

                        $more_threads = $folder_msgs[$folder] - $start_from - 50;

                        if ($more_threads > 0 && $more_threads <= 50) echo "<p><i><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\">{$lang['next']} $more_threads {$lang['threads']}</a></i></p>\n";
                        if ($more_threads > 50) echo "<p><i><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></i></p>\n";

                    }

                }elseif ($folder_info[$folder_number]['INTEREST'] != -1) {

                    echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder_number\">";

                    if (isset($folder_msgs[$folder_number])) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo " {$lang['threads']}</a>";
                    if ($folder_info[$folder_number]['ALLOWED_TYPES']&FOLDER_ALLOW_NORMAL_THREAD) echo " - <b><a href=\"lpost.php?webtag=$webtag&amp;fid=$folder_number\">{$lang['postnew']}</a></b>";
                    echo "</p>\n";
                }

            }

            if (is_array($thread_info)) reset($thread_info);
        }
    }

    if ($mode == 0 && !isset($folder)) {

        $total_threads = 0;

        if (is_array($folder_msgs)) {

          while (list($fid, $num_threads) = each($folder_msgs)) {
            $total_threads += $num_threads;
          }

          $more_threads = $total_threads - $start_from - 50;
          if ($more_threads > 0 && $more_threads <= 50) echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\">{$lang['next']} $more_threads {$lang['threads']}</p>\n";
          if ($more_threads > 50) echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></p>\n";

        }
    }

    if ($uid != 0) {

        echo "  <h5>{$lang['markasread']}:</h5>\n";
        echo "    <form name=\"f_mark\" method=\"get\" action=\"lthread_list.php\">\n";
        echo "      ", form_input_hidden("webtag", $webtag), "\n";

        $labels = array($lang['alldiscussions'], $lang['next50discussions']);
        $selected_option = 0;

        if (isset($visible_threads_array) && is_array($visible_threads_array)) {

            $labels[] = $lang['visiblediscussions'];
            $selected_option = 2;

            foreach ($visible_threads_array as $tid => $length) {
                echo form_input_hidden("tid_array[$tid]", $length), "\n";
            }
        }

        if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "        ", form_input_hidden('folder', $folder), "\n";

            $labels[] = $lang['selectedfolder'];
            $selected_option = 3;
        }

        echo light_form_dropdown_array("markread", range(0, sizeof($labels) -1), $labels, $selected_option). "\n";
        echo light_form_submit("go", $lang['goexcmark']). "\n";
        echo "    </form>\n";

    }
}

function light_draw_my_forums()
{
    $lang = load_language_file();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if ($uid <> 0) {

        if ($forums_array = get_my_forums()) {

            echo "<h2>{$lang['myforums']}</h2>\n";

            if (sizeof($forums_array['FAV_FORUMS']) > 0) {

                echo "<h3>{$lang['favouriteforums']}</h3>\n";

                foreach ($forums_array['FAV_FORUMS'] as $forum) {

                    echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";

                    if ($forum['UNREAD_TO_ME'] > 0) {
                        echo "<p>{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</p>\n";
                    }else {
                        echo "<p>{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']}</p>\n";
                    }

                    if (isset($forum['LAST_LOGON']) && $forum['LAST_LOGON'] > 0) {
                        echo "<p>{$lang['lastvisited']}: ", format_time($forum['LAST_LOGON']), "</p>\n";
                    }else {
                        echo "<p>{$lang['lastvisited']}: {$lang['never']}</p>\n";
                    }
                }
            }

            if (sizeof($forums_array['RECENT_FORUMS']) > 0) {

                echo "<h3>{$lang['recentlyvisitedforums']}</h3>\n";

                foreach ($forums_array['RECENT_FORUMS'] as $forum) {

                    echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";

                    if ($forum['UNREAD_TO_ME'] > 0) {
                        echo "<p>{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</p>\n";
                    }else {
                        echo "<p>{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']}</p>\n";
                    }

                    if (isset($forum['LAST_LOGON']) && $forum['LAST_LOGON'] > 0) {
                        echo "<p>{$lang['lastvisited']}: ", format_time($forum['LAST_LOGON']), "</p>\n";
                    }else {
                        echo "<p>{$lang['lastvisited']}: {$lang['never']}</p>\n";
                    }
                }
            }

            if (sizeof($forums_array['OTHER_FORUMS']) > 0) {

                echo "<h3>{$lang['availableforums']}</h3>\n";

                foreach ($forums_array['OTHER_FORUMS'] as $forum) {

                    echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";

                    if ($forum['UNREAD_TO_ME'] > 0) {
                        echo "<p>{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']} ({$forum['UNREAD_TO_ME']} {$lang['unreadtome']})</p>\n";
                    }else {
                        echo "<p>{$forum['UNREAD_MESSAGES']} {$lang['unreadmessages']}</p>\n";
                    }

                    if (isset($forum['LAST_LOGON']) && $forum['LAST_LOGON'] > 0) {
                        echo "<p>{$lang['lastvisited']}: ", format_time($forum['LAST_LOGON']), "</p>\n";
                    }else {
                        echo "<p>{$lang['lastvisited']}: {$lang['never']}</p>\n";
                    }
                }
            }

        }else {

            echo "<h2>{$lang['myforums']}</h2>\n";
            echo "<p>{$lang['noforumsavailablelogin']}</p>\n";
        }

    }else {

        if ($forums_array = get_forum_list()) {

            echo "<h2>{$lang['availableforums']}</h2>\n";

            foreach ($forums_array as $forum) {

                echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";
                echo "<p>{$forum['MESSAGES']} {$lang['messages']}</p>\n";
            }

        }else {

            echo "<h2>{$lang['availableforums']}</h2>\n";
            echo "<p>{$lang['noforumsavailablelogin']}</p>\n";
        }
    }
}

// create a <select> dropdown with values from array(s)
function light_form_dropdown_array($name, $value, $label, $default = "")
{
    $html = "<select name=\"$name\">";

    for($i=0;$i<count($value);$i++){
        $sel = ($value[$i] == $default) ? " selected=\"selected\"" : "";
        if($label[$i]){
            $html.= "<option value=\"{$value[$i]}\"$sel>{$label[$i]}</option>";
        } else {
            $html.= "<option$sel>{$value[$i]}</option>";
        }
    }
    return $html."</select>";
}

// create a <input type="submit"> button
function light_form_submit($name = "submit", $value = "Submit")
{
    return "<input type=\"submit\" name=\"$name\" value=\"$value\" />";
}

function light_poll_confirm_close($tid)
{
    $lang = load_language_file();

    if (!is_numeric($tid)) return;

    if (!$t_fid = thread_get_folder($tid, 1)) {
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        return;
    }

    if(bh_session_get_value('UID') != $preview_message['FROM_UID'] && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        edit_refuse($tid, 1);
        return;
    }

    $preview_message = messages_get($tid, 1, 1);

    if($preview_message['TO_UID'] == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

    }else {

        $preview_tuser = user_get($preview_message['TO_UID']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];

    }

    $preview_fuser = user_get($preview_message['FROM_UID']);
    $preview_message['FLOGON'] = $preview_fuser['LOGON'];
    $preview_message['FNICK'] = $preview_fuser['NICKNAME'];

    echo "<h2>{$lang['pollconfirmclose']}</h2>\n";

    light_poll_display($tid, $preview_message, 0, $threaddata['FID'], 0, false);

    echo "<p><form name=\"f_delete\" action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" target=\"_self\">";
    echo form_input_hidden('webtag', $webtag), "\n";
    echo form_input_hidden("tid", $tid);
    echo form_input_hidden("confirm_pollclose", "Y");
    echo light_form_submit("pollclose", $lang['endpoll']);
    echo "&nbsp;".light_form_submit("cancel", $lang['cancel']);
    echo "</form>\n";

}

function light_messages_top($msg, $threadtitle, $interest_level = 0, $sticky = "N", $closed = false, $locked = false)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    echo "<h2>Full Version: <a href=\"index.php?webtag=$webtag&amp;msg=$msg\">$threadtitle</a>";

    if ($closed) echo "&nbsp;<font color=\"#FF0000\">({$lang['closed']})</font>\n";
    if ($interest_level == 1) echo "&nbsp;<font color=\"#FF0000\">({$lang['highinterest']})</font>";
    if ($interest_level == 2) echo "&nbsp;<font color=\"#FF0000\">({$lang['subscribed']})</font>";
    if ($sticky == "Y") echo "&nbsp;({$lang['sticky']})";
    if ($locked) echo "&nbsp;<font color=\"#FF0000\">({$lang['locked']})</font>";

    echo "</h2>";
}

function light_form_radio($name, $value, $text, $checked = false)
{
    $html = "<input type=\"radio\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked=\"checked\"";
    return $html . " />$text";
}

function light_poll_display($tid, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = true, $show_sigs = true, $is_preview = false, $highlight = array())
{
    $webtag = get_webtag($webtag_search);

    $lang = load_language_file();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $polldata     = poll_get($tid);
    $pollresults  = poll_get_votes($tid);
    $userpolldata = poll_get_user_vote($tid);

    $totalvotes       = 0;
    $poll_group_count = 1;

    $polldata['CONTENT'] = "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\" target=\"_self\">\n";
    $polldata['CONTENT'].= form_input_hidden('webtag', $webtag). "\n";
    $polldata['CONTENT'].= form_input_hidden('tid', $tid). "\n";
    $polldata['CONTENT'].= "<h2>". thread_get_title($tid). "</h2>\n";

    if ($in_list) {

      if ((!is_array($userpolldata) && bh_session_get_value('UID') > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > mktime())) {

        for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

          if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

          if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldata['CONTENT'].= "<hr />\n";
                $poll_group_count++;
            }

            $polldata['CONTENT'].= light_form_radio("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "&nbsp;{$pollresults['OPTION_NAME'][$i]}<br />\n";
            $poll_previous_group = $pollresults['GROUP_ID'][$i];

          }

        }

      }else {

        if ($polldata['SHOWRESULTS'] == 1) {

          for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

              if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                  $polldata['CONTENT'].= "<hr />\n";
                  $poll_group_count++;
              }

              $polldata['CONTENT'] .= $pollresults['OPTION_NAME'][$i] . ": " . $pollresults['VOTES'][$i] . " votes <br />\n";
              $poll_previous_group = $pollresults['GROUP_ID'][$i];
            }

          }

        }else {

          for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

              if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                  $polldata['CONTENT'].= "<hr />\n";
                  $poll_group_count++;
              }

              $polldata['CONTENT'].= $pollresults['OPTION_NAME'][$i]. "<br />\n";
              $poll_previous_group = $pollresults['GROUP_ID'][$i];
            }

          }

        }

      }

    }else {

      for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

        if (!empty($pollresults['OPTION_NAME'][$i])) {

          if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
              $polldata['CONTENT'].= "<hr />\n";
              $poll_group_count++;
          }

          $polldata['CONTENT'].= $pollresults['OPTION_NAME'][$i]. "<br />\n";
          $poll_previous_group = $pollresults['GROUP_ID'][$i];
        }

      }

    }

    if ($in_list) {

      $group_array = array();

      for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (!in_array($pollresults['GROUP_ID'][$i], $group_array)) {
            $group_array[] = $pollresults['GROUP_ID'][$i];
        }
      }

      $poll_group_count = sizeof($group_array);
      $totalvotes = poll_get_total_votes($tid);

      $polldata['CONTENT'] .= "<p>";

      if ($totalvotes == 0 && ($polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyvoted']}</b>";

      }elseif ($totalvotes == 0 && ($polldata['CLOSES'] > mktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyhasvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] > mktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personhasvoted']}</b>";

      }else {

        if ($polldata['CLOSES'] <= mktime() && $polldata['CLOSES'] != 0) {

          $polldata['CONTENT'].= "<b>$totalvotes {$lang['peoplevoted']}</b>";

        }else {

          $polldata['CONTENT'].= "<b>$totalvotes {$lang['peoplehavevoted']}</b>";

        }

      }

      $polldata['CONTENT'].= "</p>\n";

      if (($polldata['CLOSES'] <= mktime()) && $polldata['CLOSES'] != 0) {

        $polldata['CONTENT'].= "<p>{$lang['pollhasended']}</p>\n";

        if (is_array($userpolldata)) {

          $userpollvotes_array = array();

          for ($i = 0; $i < sizeof($userpolldata); $i++) {
            for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {
              if ($userpolldata[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {
                if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {
                  $userpollvotes_array[] = "'{$pollresults['OPTION_NAME'][$j]}'";
                }else {
                  $userpollvotes_array[] = "Option {$userpolldata[$i]['OPTION_ID']}";
                }
              }
            }
          }

          $polldata['CONTENT'].= "<p>{$lang['youvotedfor']}: ". implode(" & ", $userpollvotes_array);
          $polldata['CONTENT'].= " {$lang['on']} ". gmdate("jS M Y", $userpolldata[0]['TSTAMP']). "</p>\n";

        }

      }else {

        if (is_array($userpolldata)) {

          $userpollvotes_array = array();

          for ($i = 0; $i < sizeof($userpolldata); $i++) {
            for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {
              if ($userpolldata[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {
                if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {
                  $userpollvotes_array[] = "'{$pollresults['OPTION_NAME'][$j]}'";
                }else {
                  $userpollvotes_array[] = "Option {$userpolldata[$i]['OPTION_ID']}";
                }
              }
            }
          }

          $polldata['CONTENT'].= "<p>{$lang['youvotedfor']}: ". implode(" & ", $userpollvotes_array);
          $polldata['CONTENT'].= " {$lang['on']} ". gmdate("jS M Y", $userpolldata[0]['TSTAMP']). "</p>\n";

        }elseif (bh_session_get_value('UID') > 0) {

          $polldata['CONTENT'].= "<p>". light_form_submit('pollsubmit', $lang['vote']). "</p>\n";

        }

      }

    }

    $polldata['CONTENT'].= "</form>\n";

    // Work out what relationship the user has to the user who posted the poll
    $polldata['FROM_RELATIONSHIP'] = user_rel_get(bh_session_get_value('UID'), $polldata['FROM_UID']);

    light_message_display($tid, $polldata, $msg_count, $first_msg, $folder_fid, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);
}

function light_message_display($tid, $message, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true, $is_preview = false)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if(!isset($message['CONTENT']) || $message['CONTENT'] == "") {
        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    if (bh_session_get_value('UID') != $message['FROM_UID']) {
        if ((perm_get_user_permissions($message['FROM_UID']) & USER_PERM_WORMED) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid)) {
            light_message_display_deleted($tid, $message['PID']);
            return;
        }
    }

    if(!isset($message['FROM_RELATIONSHIP'])) {
        $message['FROM_RELATIONSHIP'] = 0;
    }

    if(!isset($message['TO_RELATIONSHIP'])) {
        $message['TO_RELATIONSHIP'] = 0;
    }

    if (($message['TO_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) || ($message['FROM_RELATIONSHIP'] & USER_IGNORED_COMPLETELY))
    {
        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    // Check for words that should be filtered ---------------------------------

    $message['CONTENT'] = apply_wordfilter($message['CONTENT']);

    if (bh_session_get_value('IMAGES_TO_LINKS') == 'Y') {

        $message['CONTENT'] = preg_replace("/<a([^>]*)href=\"([^\"]*)\"([^\>]*)><img[^>]*src=\"([^\"]*)\"[^>]*><\/a>/i", "[img: <a\\1href=\"\\2\"\\3>\\4</a>]", $message['CONTENT']);
        $message['CONTENT'] = preg_replace("/<img[^>]*src=\"([^\"]*)\"[^>]*>/i", "[img: <a href=\"\\1\">\\1</a>]", $message['CONTENT']);
        $message['CONTENT'] = preg_replace("/<embed[^>]*src=\"([^\"]*)\"[^>]*>/i", "[object: <a href=\"\\1\">\\1</a>]", $message['CONTENT']);
    }

    $message['CONTENT'] = message_mouseover_spoiler($message['CONTENT']);

    if ((strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length', false, 6226))) && $limit_text) {

        $cut_msg = substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length', false, 6226)));
        $cut_msg = preg_replace("/(<[^>]+)?$/", "", $cut_msg);

        $message['CONTENT'] = fix_html($cut_msg, false);
        $message['CONTENT'].= "&hellip;[{$lang['msgtruncated']}]\n<p align=\"center\"><a href=\"ldisplay.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['viewfullmsg']}.</a>";
    }

    if($in_list){
        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>";
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    if (isset($message['PID'])) {

        echo "<p><b>{$lang['from']}: ", format_user_name($message['FLOGON'], $message['FNICK']), "</b> [#{$message['PID']}]<br />";

    }else {

        echo "<p><b>{$lang['from']}: ", format_user_name($message['FLOGON'], $message['FNICK']), "</b><br />";;
    }

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "&nbsp;({$lang['friend']}) ";
    } else if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) || isset($temp_ignore)) {
        echo "&nbsp;({$lang['ignoreduser']}) ";
    }

    if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text) {

        echo "<b>{$lang['ignoredmsg']}</b>";

    } else {

        if($in_list) {

            if ((perm_get_user_permissions($message['FROM_UID']) & USER_PERM_WORMED)) echo "<b>{$lang['wormeduser']}</b> ";

            //This is commented out because as far as I know, all sigs are ignored in Light. Correct me if I'm wrong. - Rowan
            //if ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) echo "<b>{$lang['ignoredsig']}</b> ";

            echo "&nbsp;".format_time($message['CREATED'], 1)."<br />";
        }
    }

    if (($message['TLOGON'] != $lang['allcaps']) && $message['TO_UID'] != 0) {

        echo "<b>{$lang['to']}: " . format_user_name($message['TLOGON'], $message['TNICK'])."</b>";

        if (isset($message['REPLY_TO_PID']) && $message['REPLY_TO_PID'] > 0) echo " [#{$message['REPLY_TO_PID']}]";

        if($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "&nbsp;({$lang['friend']})";
        } else if($message['TO_RELATIONSHIP'] & USER_IGNORED) {
            echo "&nbsp;({$lang['ignoreduser']})";
        }

        if (!$is_preview) {

            if(isset($message['VIEWED']) && $message['VIEWED'] > 0) {
                echo "&nbsp;".format_time($message['VIEWED'], 1);
            } else {
                echo "&nbsp;{$lang['unread']}";
            }
        }

    }else {
        echo "<b>{$lang['to']}: {$lang['all_caps']}</b>";
    }

    echo "</p>\n";

    if (!$in_list && isset($message['PID'])) echo "<p><i>{$lang['message']} {$message['PID']} {$lang['of']} $msg_count</i></p>\n";

        if (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs) {

            if (preg_match("/<div class=\"sig\">/", $message['CONTENT']) > 0) {

                $msg_split = preg_split("/<div class=\"sig\">/", $message['CONTENT']);

                $tmp_sig = preg_split('/<\/div>/', $msg_split[count($msg_split) - 1]);

                $msg_split[count($msg_split)-1] = $tmp_sig[count($tmp_sig)-1];

                $message['CONTENT'] = "";

                for ($i = 0; $i < count($msg_split); $i++) {

                    if ($i > 0) $message['CONTENT'] .= "<div class=\"sig\">";
                    $message['CONTENT'].= $msg_split[$i];
                }

                $message['CONTENT'].= "</div>";
            }
        }

        echo "<p>{$message['CONTENT']}</p>\n";

        if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

            $aid = isset($message['AID']) ? $message['AID'] : get_attachment_id($tid, $message['PID']);

            if (get_attachments($message['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

                // Draw the attachment header at the bottom of the post

                if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                    echo "<p><b>{$lang['attachments']}:</b><br />\n";

                    foreach($attachments_array as $attachment) {

                        if ($attachment_link = light_attachment_make_link($attachment)) {

                            echo $attachment_link, "<br />\n";
                        }
                    }

                    echo "</p>\n";
                }

                if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                    echo "<p><b>{$lang['imageattachments']}:</b><br />\n";

                    foreach($image_attachments_array as $key => $attachment) {

                        if ($attachment_link = light_attachment_make_link($attachment)) {

                            echo $attachment_link, "&nbsp;\n";
                        }
                    }

                    echo "</p>\n";
                }
            }
        }

        echo "<p>\n";

        if ($in_list && $limit_text != false) {

            if (!$closed && bh_session_check_perm(USER_PERM_POST_CREATE, $folder_fid)) {

                echo "<a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\">{$lang['reply']}</a>";
            }
        }

        echo "</p>\n";
        echo "<hr />";
}

function light_message_display_deleted($tid,$pid)
{
    $lang = load_language_file();

    echo "<p>{$lang['message']} ${tid}.${pid} {$lang['wasdeleted']}</p>\n";
    echo "<hr />";
}

function light_messages_nav_strip($tid,$pid,$length,$ppp)
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    // Less than 20 messages, no nav needed
    if($pid == 1 && $length < $ppp){
        return;
    }

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if($spid > 1){
        if($pid > 1){
            $navbits[0] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">" . mess_nav_range(1,$spid-1) . "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
        $i = 1;
    } else {
        $i = 0;
    }

    // The middle section(s)
    while($spid + ($ppp - 1) <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">" . mess_nav_range($spid==0 ? 1 : $spid,$spid+($ppp - 1)) . "</a>";
        }
        $spid += $ppp;
        $i++;
    }

    // The final section, x-n
    if($spid <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }
    $max = $i;

    $html = "{$lang['showmessages']}:";

    if ($length <= $ppp) {
        $html .= " <a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">{$lang['all']}</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            if((abs($c - $i) < 4) || $i == 0 || $i == $max){
                $html .= "\n&nbsp;" . $navbits[$i];
            } else if(abs($c - $i) == 4){
                $html .= "\n&nbsp;&hellip;";
            }
        }
    }

    unset($navbits);

    echo "<p align=\"center\">$html</p>\n";
}

function light_html_guest_error ()
{
     global $frame_top_target;
     
     $lang = load_language_file();

     $webtag = get_webtag($webtag_search);

     light_html_draw_top();

     if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
         echo "<h1>{$lang['guesterror_1']} <a href=\"llogout.php?webtag=$webtag\" ";
         echo "target=\"$frame_top_target\">{$lang['guesterror_2']}</a></h1>";
     }else {
         echo "<h1>{$lang['guesterror_1']} <a href=\"llogout.php?webtag=$webtag\" ";
         echo "target=\"_top\">{$lang['guesterror_2']}</a></h1>";
     }

     light_html_draw_bottom();
}

function light_folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="")
{
    $db_folder_draw_dropdown = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return "";

    $forum_fid = $table_data['FID'];

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $allowed_types = FOLDER_ALLOW_NORMAL_THREAD;
    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "WHERE FOLDER.ALLOWED_TYPES & $allowed_types > 0 ";
    $sql.= "OR FOLDER.ALLOWED_TYPES IS NULL ";
    $sql.= "ORDER BY FOLDER.FID ";

    $result = db_query($sql, $db_folder_draw_dropdown);

    if (db_num_rows($result) > 0) {

        while($folder_data = db_fetch_array($result)) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                    $folders['FIDS'][]   = $folder_data['FID'];
                    $folders['TITLES'][] = $folder_data['TITLE'];
                }

            }else {
            
                if (bh_session_check_perm($access_allowed, $folder_data['FID'])) {

                    $folders['FIDS'][]   = $folder_data['FID'];
                    $folders['TITLES'][] = $folder_data['TITLE'];
                }
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            return light_form_dropdown_array($field_name.$suffix, $folders['FIDS'], $folders['TITLES'], $default_fid);
        }
    }

    return false;
}

function light_form_textarea($name, $value = "", $rows = 0, $cols = 0)
{
    $html = "<textarea name=\"$name\" ";

    if($rows) $html.= " rows=\"$rows\"";
    if($cols) $html.= " cols=\"$cols\"";

    $html .= ">$value</textarea>";

    return $html;
}

function light_form_checkbox($name, $value, $text, $checked = false)
{
    $html = "<input type=\"checkbox\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked=\"checked\"";
    return $html . " />$text";
}

function light_form_field($name, $value = "", $width = 0, $maxchars = 0, $type = "text")
{
    $html = "<input type=\"$type\" name=\"$name\"";
    $html.= " value=\"$value\"";

    if($width) $html.= " size=\"$width\"";
    if($maxchars) $html.= " maxchars=\"$maxchars\"";

    return $html." />";
}

function light_form_input_text($name, $value = "", $width = 0, $maxchars = 0)
{
    return light_form_field($name,$value,$width,$maxchars,"text");
}

function light_form_input_password($name, $value = "", $width = 0, $maxchars = 0)
{
    return light_form_field($name,$value,$width,$maxchars,"password");
}

function light_html_message_type_error()
{
    $lang = load_language_file();

    light_html_draw_top();
    echo "<h1>{$lang['cannotpostthisthreadtype']}</h1>";
    light_html_draw_bottom();
}

function light_attachment_make_link($attachment)
{
    if (!is_array($attachment)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    if (!isset($attachment['hash']) || !is_md5($attachment['hash'])) return false;
    if (!isset($attachment['filename'])) return false;

    $webtag = get_webtag($webtag_search);

    $href = "get_attachment.php?webtag=$webtag&amp;hash={$attachment['hash']}";
    $href.= "&amp;filename={$attachment['filename']}";

    $attachment_link = "<img src=\"";
    $attachment_link.= style_image('attach.png');
    $attachment_link.= "\" width=\"14\" height=\"14\" border=\"0\" />";
    $attachment_link.= "<a href=\"$href\" target=\"_blank\">{$attachment['filename']}</a>";

    return $attachment_link;
}

function light_threads_draw_discussions_dropdown($mode)
{
    $lang = load_language_file();

    if (bh_session_get_value('UID') == 0) {

        $labels = array($lang['alldiscussions'], $lang['todaysdiscussions'], $lang['2daysback'], $lang['7daysback']);
        return light_form_dropdown_array("mode", array(0, 3, 4, 5), $labels, $mode, "onchange=\"submit()\"");

    }else {

        $labels = array($lang['alldiscussions'],$lang['unreaddiscussions'],$lang['unreadtome'],$lang['todaysdiscussions'],
                        $lang['unreadtoday'],$lang['2daysback'],$lang['7daysback'],$lang['highinterest'],$lang['unreadhighinterest'],
                        $lang['iverecentlyseen'],$lang['iveignored'],$lang['byignoredusers'],$lang['ivesubscribedto'],$lang['startedbyfriend'],
                        $lang['unreadstartedbyfriend'],$lang['startedbyme'],$lang['polls'],$lang['stickythreads'],$lang['mostunreadposts']);

        return light_form_dropdown_array("mode", range(0, 18), $labels, $mode, "onchange=\"submit()\"");

    }
}

?>