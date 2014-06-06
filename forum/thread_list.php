<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'rss_feed.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Thread List Cache Control
cache_check_thread_list();

// Check the RSS feeds
rss_feed_check_feeds();

// Array to hold error messages
$error_msg_array = array();

// Array of available thread list views.
$available_views = thread_list_available_views();

// Get the folders the user can see.
if (!($available_folders = folder_get_available_array())) {
    $available_folders = array();
}

// Are we viewing a specific folder only?
if (isset($_REQUEST['folder']) && in_array($_REQUEST['folder'], $available_folders)) {
    $folder = $_REQUEST['folder'];
} else {
    $folder = false;
}

// View offset.
if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

// View mode
if (isset($_REQUEST['mode']) && is_numeric($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

// Number of posts per page
if (isset($_SESSION['POSTS_PER_PAGE']) && is_numeric($_SESSION['POSTS_PER_PAGE'])) {
    $posts_per_page = max(min($_SESSION['POSTS_PER_PAGE'], 30), 10);
} else {
    $posts_per_page = 20;
}

// Check that required variables are set
if (!session::logged_in()) {

    // non-logged in users can only display "All" threads
    // or those in the past x days, since the other options
    // would be impossible
    if (!isset($mode) || ($mode != ALL_DISCUSSIONS && $mode != TODAYS_DISCUSSIONS && $mode != TWO_DAYS_BACK && $mode != SEVEN_DAYS_BACK)) {
        $mode = ALL_DISCUSSIONS;
    }

} else {

    $threads_any_unread = threads_any_unread();

    if (isset($mode) && is_numeric($mode)) {

        $_SESSION['THREAD_MODE'] = $mode;

        if ($mode == SEARCH_RESULTS) {

            header_redirect("search.php?webtag=$webtag&page=1");
            exit;
        }

    } else {

        if (isset($_SESSION['THREAD_MODE']) && is_numeric($_SESSION['THREAD_MODE']) && ($_SESSION['THREAD_MODE'] != SEARCH_RESULTS)) {
            $mode = $_SESSION['THREAD_MODE'];
        } else {
            $mode = UNREAD_DISCUSSIONS;
        }

        if ($mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {
            $mode = ALL_DISCUSSIONS;
        }
    }

    if (isset($_REQUEST['mark_read_submit'])) {

        if (isset($_REQUEST['mark_read_confirm']) && ($_REQUEST['mark_read_confirm'] == 'Y')) {

            if ($_REQUEST['mark_read_type'] == THREAD_MARK_READ_VISIBLE) {

                if (isset($_REQUEST['mark_read_threads']) && strlen(trim($_REQUEST['mark_read_threads'])) > 0) {

                    $thread_data = array();

                    $mark_read_threads = trim($_REQUEST['mark_read_threads']);

                    $mark_read_threads_array = array_filter(explode(',', $mark_read_threads), 'is_numeric');

                    threads_get_unread_data($thread_data, $mark_read_threads_array);

                    if (threads_mark_read($thread_data)) {

                        header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                        exit;

                    } else {

                        $error_msg_array[] = gettext("Failed to mark selected threads as read");
                        $valid = false;
                    }
                }

            } else if ($_REQUEST['mark_read_type'] == THREAD_MARK_READ_ALL) {

                if (threads_mark_all_read()) {

                    header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to mark selected threads as read");
                    $valid = false;
                }

            } else if ($_REQUEST['mark_read_type'] == THREAD_MARK_READ_FIFTY) {

                if (threads_mark_50_read()) {

                    header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to mark selected threads as read");
                    $valid = false;
                }

            } else if (($_REQUEST['mark_read_type'] == THREAD_MARK_READ_FOLDER) && (isset($folder) && is_numeric($folder))) {

                if (threads_mark_folder_read($folder)) {

                    header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to mark selected threads as read");
                    $valid = false;
                }
            }

        } else {

            unset($_REQUEST['mark_read_submit'], $_REQUEST['mark_read_confirm']);

            html_draw_top();
            html_display_msg(gettext("Confirm"), gettext("Are you sure you want to mark the selected threads as read?"), 'thread_list.php', 'post', array(
                'mark_read_submit' => gettext("Confirm"),
                'cancel' => gettext("Cancel")
            ), array_merge($_REQUEST, array('mark_read_confirm' => 'Y')));
            html_draw_bottom();
            exit;
        }
    }
}

// Output XHTML header
html_draw_top(
    array(
        'js' => array(
            'js/thread_list.js'
        )
    )
);

// Fetch the right threads for whichever mode is selected
switch ($mode) {

    case UNREAD_DISCUSSIONS:

        list($thread_info, $folder_order, $thread_count) = threads_get_unread($_SESSION['UID'], $folder, $page);
        break;

    case UNREAD_DISCUSSIONS_TO_ME:

        list($thread_info, $folder_order, $thread_count) = threads_get_unread_to_me($_SESSION['UID'], $folder, $page);
        break;

    case TODAYS_DISCUSSIONS:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_days($_SESSION['UID'], $folder, $page, 1);
        break;

    case UNREAD_TODAY:

        list($thread_info, $folder_order, $thread_count) = threads_get_unread_by_days($_SESSION['UID'], $folder, $page);
        break;

    case TWO_DAYS_BACK:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_days($_SESSION['UID'], $folder, $page, 2);
        break;

    case SEVEN_DAYS_BACK:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_days($_SESSION['UID'], $folder, $page, 7);
        break;

    case HIGH_INTEREST:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_interest($_SESSION['UID'], $folder, $page, THREAD_INTERESTED);
        break;

    case UNREAD_HIGH_INTEREST:

        list($thread_info, $folder_order, $thread_count) = threads_get_unread_by_interest($_SESSION['UID'], $folder, $page, THREAD_INTERESTED);
        break;

    case RECENTLY_SEEN:

        list($thread_info, $folder_order, $thread_count) = threads_get_recently_viewed($_SESSION['UID'], $folder, $page);
        break;

    case IGNORED_THREADS:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_interest($_SESSION['UID'], $folder, $page, THREAD_IGNORED);
        break;

    case BY_IGNORED_USERS:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_relationship($_SESSION['UID'], $folder, $page, USER_IGNORED_COMPLETELY);
        break;

    case SUBSCRIBED_TO:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_interest($_SESSION['UID'], $folder, $page, THREAD_SUBSCRIBED);
        break;

    case STARTED_BY_FRIEND:

        list($thread_info, $folder_order, $thread_count) = threads_get_by_relationship($_SESSION['UID'], $folder, $page, USER_FRIEND);
        break;

    case UNREAD_STARTED_BY_FRIEND:

        list($thread_info, $folder_order, $thread_count) = threads_get_unread_by_relationship($_SESSION['UID'], $folder, $page, USER_FRIEND);
        break;

    case STARTED_BY_ME:

        list($thread_info, $folder_order, $thread_count) = threads_get_started_by_me($_SESSION['UID'], $folder, $page);
        break;

    case POLL_THREADS:

        list($thread_info, $folder_order, $thread_count) = threads_get_polls($_SESSION['UID'], $folder, $page);
        break;

    case STICKY_THREADS:

        list($thread_info, $folder_order, $thread_count) = threads_get_sticky($_SESSION['UID'], $folder, $page);
        break;

    case MOST_UNREAD_POSTS:

        list($thread_info, $folder_order, $thread_count) = threads_get_longest_unread($_SESSION['UID'], $folder, $page);
        break;

    case DELETED_THREADS:

        list($thread_info, $folder_order, $thread_count) = threads_get_deleted($_SESSION['UID'], $folder, $page);
        break;

    default:

        list($thread_info, $folder_order, $thread_count) = threads_get_all($_SESSION['UID'], $folder, $page);
        break;
}

// Now, the actual bit that displays the threads...
// Get folder FIDs and titles
if (!$folder_info = threads_get_folders()) {
    html_draw_error(gettext("There are no folders available."));
}

// Get total number of messages for each folder
$folder_msgs = threads_get_folder_msgs();

// Check that the folder order is a valid array.
if (!is_array($folder_order)) $folder_order = array();

// Check the folder display order.
if (isset($_SESSION['THREADS_BY_FOLDER']) && ($_SESSION['THREADS_BY_FOLDER'] == 'Y')) {
    $folder_order = array_keys($folder_info);
}

// Check for a message to display and re-order the thread list.
if (isset($_REQUEST['msg']) && validate_msg($_REQUEST['msg'])) {

    list($selected_tid) = explode('.', $_REQUEST['msg']);

    if (($thread = thread_get($selected_tid)) !== false) {

        if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

        // Check the folder display order / user is a guest.
        if (!isset($_SESSION['THREADS_BY_FOLDER']) || $_SESSION['THREADS_BY_FOLDER'] != 'Y' || !session::logged_in()) {

            // Remove the folder from the list of folders.
            if (in_array($thread['FID'], $folder_order)) {
                array_splice($folder_order, array_search($thread['FID'], $folder_order), 1);
            }

            // Re-add it at the top of the list.
            array_unshift($folder_order, $thread['FID']);
        }

        // Check $thread_info is an array.
        if (!is_array($thread_info)) $thread_info = array();

        // Check to see if the thread is already in the list.
        // If it is remove it, otherwise take the last thread
        // off the list so we always only have 50 threads on display.
        if (isset($thread_info[$selected_tid])) {
            unset($thread_info[$selected_tid]);
        } else {
            $thread_info = array_slice($thread_info, 0, 50, true);
        }

        // Add the requested thread to the top of the list of threads.
        array_unshift($thread_info, $thread);
    }
}

// Check for a specified folder and move it to the top of the thread list.
if (isset($folder) && is_numeric($folder)) {

    if (in_array($folder, $folder_order)) {
        array_splice($folder_order, array_search($folder, $folder_order), 1);
    }

    array_unshift($folder_order, $folder);
}

if ($_SESSION['UID'] > 0) {

    // Array to hold our ignored folders in.
    $ignored_folders = array();

    // Loop through the list of folders and check their status.
    // If they're ignored and not already set to be on display
    // they need to be added to $ignored_folders so that they
    // appear at the bottom of the thread list.
    foreach ($folder_info as $fid => $folder_data) {

        if (!in_array($fid, $folder_order) && !in_array($fid, $ignored_folders)) {

            if ($folder_data['INTEREST'] != FOLDER_IGNORED || (isset($folder) && $folder == $fid)) {
                array_push($folder_order, $fid);
            } else {
                array_push($ignored_folders, $fid);
            }
        }
    }

    // Append ignored folders onto the end of the folder list.
    // This will make them appear at the bottom of the thread list.
    $folder_order = array_merge($folder_order, $ignored_folders);

} else {

    foreach ($folder_info as $fid => $folder_data) {
        if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
    }
}

// Draw discussion dropdown
thread_list_draw_top($mode, $folder);

// If no threads are returned, say something to that effect
if (isset($_REQUEST['mark_read_success'])) {

    html_display_success_msg(gettext("Successfully marked selected threads as read"), '100%', 'left');

} else if (!is_array($thread_info)) {

    if (is_numeric($folder) && ($folder_title = folder_get_title($folder))) {

        $all_discussions_link = sprintf("<a href=\"thread_list.php?webtag=$webtag&amp;folder=$folder&amp;mode=0\">%s</a>", gettext("click here"));
        html_display_warning_msg(sprintf(gettext("No &quot;%s&quot; in &quot;%s&quot; folder. Please select another folder, or %s for all threads."), $available_views[$mode], $folder_title, $all_discussions_link), '100%', 'left');

    } else {

        $all_discussions_link = sprintf("<a href=\"thread_list.php?webtag=$webtag&amp;mode=0\">%s</a>", gettext("click here"));
        html_display_warning_msg(sprintf(gettext("No &quot;%s&quot; available. Please %s for all threads."), $available_views[$mode], $all_discussions_link), '100%', 'left');
    }

} else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '100%', 'left');

} else if (is_numeric($folder) && ($folder_title = folder_get_title($folder))) {

    $all_folders_link = sprintf("<a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode\">%s</a>", gettext("click here"));
    html_display_warning_msg(sprintf(gettext("Viewing &quot;%s&quot; in &quot;%s&quot; only. To view threads in all folders %s."), $available_views[$mode], $folder_title, $all_folders_link), '100%', 'left');

} else {

    echo "<br />";
}

if (($page > 1) && !is_numeric($folder)) {

    echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" valign=\"top\" class=\"smalltext\" colspan=\"2\">", html_style_image('current_thread'), "&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;page=", ($page - 1), "\" title=\"", gettext("Show previous 50 threads"), "\">", gettext("Previous 50 threads"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

// Array to track visible threads for mark as read
$visible_threads_array = array();

// Variable to track first thread
$first_thread = false;

// Unread cut-off
$thread_unread_cutoff = threads_get_unread_cutoff();

// Iterate through the information we've just got and display it in the right order
foreach ($folder_order as $folder_number) {

    if (isset($folder_info[$folder_number]) && is_array($folder_info[$folder_number])) {

        echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" colspan=\"2\">\n";
        echo "      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "        <tr>\n";
        echo "          <td align=\"left\" valign=\"top\" class=\"foldername\">\n";

        if (session::logged_in() && ($folder_info[$folder_number]['INTEREST'] == FOLDER_SUBSCRIBED)) {
            echo "            <a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" class=\"popup 550x400\">", html_style_image('folder_subscribed', gettext("Subscribed Folder")), "</a>\n";
        } else if (session::logged_in() && ($folder_info[$folder_number]['INTEREST'] == FOLDER_IGNORED)) {
            echo "            <a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" class=\"popup 550x400\">", html_style_image('folder_ignored', gettext("Ignored Folder")), "</a>\n";
        } else {
            echo "            <a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" class=\"popup 550x400\">", html_style_image('folder', gettext("Folder")), "</a>\n";
        }

        echo "            <a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder_number\" title=\"", word_filter_add_ob_tags($folder_info[$folder_number]['DESCRIPTION'], true), "\">", word_filter_add_ob_tags($folder_info[$folder_number]['TITLE'], true), "</a>\n";
        echo "          </td>\n";

        echo "          <td align=\"left\" class=\"folderpostnew\" style=\"white-space: nowrap\"><a href=\"threads_rss.php?webtag=DEFAULT&amp;fid=$folder_number\" target=\"_blank\" class=\"popup 580x450\" id=\"mods_list_$folder_number\">", html_style_image('rss', gettext("RSS")), "</a></td>";

        if ($_SESSION['UID'] > 0) {
            echo "          <td align=\"left\" class=\"folderpostnew\" style=\"white-space: nowrap\"><a href=\"mods_list.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" class=\"popup 580x450\" id=\"mods_list_$folder_number\">", html_style_image('mods_list', gettext("View moderators")), "</a></td>";
        }

        echo "        </tr>\n";
        echo "      </table>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";

        if ((!session::logged_in()) || ($folder_info[$folder_number]['INTEREST'] > FOLDER_IGNORED) || ($mode == UNREAD_DISCUSSIONS_TO_ME) || (isset($folder) && $folder == $folder_number)) {

            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
            echo "  <tr>\n";
            echo "    <td align=\"left\">\n";
            echo "      <table class=\"box\" width=\"100%\">\n";
            echo "        <tr>\n";
            echo "          <td align=\"left\" class=\"posthead\">\n";

            if (is_array($thread_info)) {

                $visible_threads = in_array($folder_number, $folder_order);

                if ($visible_threads) {

                    echo "            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                    echo "              <tr>\n";
                    echo "                <td align=\"left\" class=\"threads_top_left\" valign=\"top\" width=\"50%\" style=\"white-space: nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"", gettext("View messages in this folder only"), "\">";

                    if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                        echo $folder_msgs[$folder_number];
                    } else {
                        echo "0";
                    }

                    echo "&nbsp;", gettext("threads"), "</a></td>\n";
                    echo "                <td align=\"left\" class=\"threads_top_right\" valign=\"top\" width=\"50%\" style=\"white-space: nowrap\">";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        echo "<a href=\"", ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) ? "post.php?webtag=$webtag" : (forum_get_setting('allow_polls', 'Y') ? "create_poll.php?webtag=$webtag" : "");
                        echo "&amp;fid={$folder_number}\" target=\"", html_get_frame_name('main'), "\" class=\"folderpostnew\" title=\"", gettext("Create new discussion in this folder"), "\">", gettext("Post New"), "</a>";

                    } else {

                        echo "&nbsp;";
                    }

                    echo "</td>\n";
                    echo "              </tr>\n";

                    if (($page > 1) && is_numeric($folder) && ($folder_number == $folder)) {

                        echo "              <tr>\n";
                        echo "                <td align=\"left\" class=\"threads_left_right\" colspan=\"2\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder&amp;page=", ($page - 1), "\" class=\"folderinfo\" title=\"", gettext("Show previous 50 threads"), "\">", gettext("Previous 50 threads"), "</a></td>\n";
                        echo "              </tr>\n";
                    }

                    echo "              <tr>\n";
                    echo "                <td align=\"left\" class=\"threads_left_right_bottom\" colspan=\"2\">\n";

                    foreach ($thread_info as $key => $thread) {

                        if (!in_array($thread['TID'], $visible_threads_array)) $visible_threads_array[] = $thread['TID'];

                        if ($thread['FID'] == $folder_number) {

                            echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
                            echo "                    <tr>\n";
                            echo "                      <td align=\"center\" valign=\"top\" style=\"white-space: nowrap\" width=\"25\">";
                            echo "<a href=\"thread_options.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"", html_get_frame_name('right'), "\">";

                            if (($thread['LAST_READ'] == 0 || $thread['LAST_READ'] < $thread['LENGTH']) && $thread['MODIFIED'] > $thread_unread_cutoff) {

                                $new_posts = $thread['LENGTH'] - $thread['LAST_READ'];

                                if ($new_posts == $thread['LENGTH']) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to first post in thread") . "\">[</a>";
                                    $number .= sprintf(gettext("%d new"), $thread['LENGTH']);
                                    $number .= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}." . thread_get_last_page_pid($thread['LENGTH'], $posts_per_page) . "\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to last post in thread") . "\">]</a>";

                                } else if ($new_posts > 1) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to first post in thread") . "\">[</a>";
                                    $number .= sprintf(gettext("%d new of %d"), $new_posts, $thread['LENGTH']);
                                    $number .= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}." . thread_get_last_page_pid($thread['LENGTH'], $posts_per_page) . "\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to last post in thread") . "\">]</a>";

                                } else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to first post in thread") . "\">[</a>";
                                    $number .= sprintf(gettext("%d new of %d"), $new_posts, $thread['LENGTH']);
                                    $number .= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}." . thread_get_last_page_pid($thread['LENGTH'], $posts_per_page) . "\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to last post in thread") . "\">]</a>";
                                }

                                $latest_post = $thread['LAST_READ'] + 1;

                                if (!is_numeric($first_thread) && isset($selected_tid) && ($selected_tid == $thread['TID'])) {

                                    $first_thread = $thread['TID'];
                                    echo html_style_image('bullet current_thread', gettext("Thread Options"), "t{$thread['TID']}");

                                } else {

                                    echo html_style_image('bullet unread_thread', gettext("Thread Options"), "t{$thread['TID']}");
                                }

                            } else {

                                if ($thread['LENGTH'] > 1) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to first post in thread") . "\">[</a>";
                                    $number .= "{$thread['LENGTH']}<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}." . thread_get_last_page_pid($thread['LENGTH'], $posts_per_page) . "\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to last post in thread") . "\">]</a>";

                                } else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to first post in thread") . "\">[</a>";
                                    $number .= "1<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"" . html_get_frame_name('right') . "\" title=\"" . gettext("Go to last post in thread") . "\">]</a>";
                                }

                                $latest_post = 1;

                                if (!is_numeric($first_thread) && isset($selected_tid) && ($selected_tid == $thread['TID'])) {

                                    $first_thread = $thread['TID'];
                                    echo html_style_image('bullet current_thread', gettext("Thread Options"), "t{$thread['TID']}");

                                } else {

                                    echo html_style_image('bullet bullet', gettext("Thread Options"), "t{$thread['TID']}");
                                }
                            }

                            echo "</a>";

                            $thread_time = format_date_time($thread['MODIFIED'], true);

                            echo "</td>\n";
                            echo "                      <td align=\"left\" valign=\"top\">";
                            echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$latest_post}\" target=\"", html_get_frame_name('right'), "\" class=\"threadname\" data-tid=\"t{$thread['TID']}\"";
                            echo "title=\"", sprintf(gettext("Thread #%s Started by %s. Viewed %s"), $thread['TID'], word_filter_add_ob_tags(format_user_name($thread['LOGON'], $thread['NICKNAME']), true), ($thread['VIEWCOUNT'] == 1) ? gettext("1 time") : sprintf(gettext("%d times"), $thread['VIEWCOUNT'])), "\">";
                            echo word_filter_add_ob_tags($thread['TITLE'], true), "</a> ";

                            if (session::logged_in()) {

                                if (isset($thread['INTEREST']) && ($thread['INTEREST'] == THREAD_INTERESTED)) {
                                    echo "", html_style_image('high_interest', gettext("High Interest")), " ";
                                }

                                if (isset($thread['INTEREST']) && ($thread['INTEREST'] == THREAD_SUBSCRIBED)) {
                                    echo "", html_style_image('subscribe', gettext("Subscribed")), " ";
                                }

                                if (isset($thread['RELATIONSHIP']) && $thread['RELATIONSHIP'] & USER_FRIEND) {
                                    echo "", html_style_image('friend', gettext("Friend")), " ";
                                }
                            }

                            if (isset($thread['POLL_FLAG']) && $thread['POLL_FLAG'] == 'Y') {
                                echo "<a href=\"poll_results.php?webtag=$webtag&amp;tid={$thread['TID']}\" target=\"_blank\" class=\"popup 800x600\">", html_style_image('poll', gettext("This is a poll. Click to view results.")), "</a> ";
                            }

                            if (isset($thread['STICKY']) && $thread['STICKY'] == "Y") {
                                echo "", html_style_image('sticky', gettext("Sticky")), " ";
                            }

                            if (isset($thread['TRACK_TYPE']) && $thread['TRACK_TYPE'] == THREAD_TYPE_SPLIT) {

                                echo "", html_style_image('split_thread', gettext("Thread has been split")), " ";

                            } else if (isset($thread['TRACK_TYPE']) && $thread['TRACK_TYPE'] == THREAD_TYPE_MERGE) {

                                echo "", html_style_image('merge_thread', gettext("Thread has been merged")), " ";
                            }

                            if (isset($thread['ATTACHMENT_COUNT']) && $thread['ATTACHMENT_COUNT'] > 0) {
                                echo "", html_style_image('attach', gettext("Attachment")), " ";
                            }

                            echo "<span class=\"threadxnewofy\">{$number}</span></td>\n";
                            echo "                      <td valign=\"top\" style=\"white-space: nowrap\" align=\"right\"><span class=\"threadtime\">{$thread_time}&nbsp;</span></td>\n";
                            echo "                    </tr>\n";
                            echo "                  </table>\n";

                            unset($thread_info[$key]);
                        }
                    }

                    if (is_numeric($folder) && ($folder_number == $folder) && ($thread_count >= 50)) {

                        echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
                        echo "                    <tr>\n";
                        echo "                      <td align=\"left\" colspan=\"3\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder&amp;page=", ($page + 1), "\" class=\"folderinfo\" title=\"", gettext("Show next 50 threads"), "\">", gettext("Next 50 threads"), "</a></td>\n";
                        echo "                    </tr>\n";
                        echo "                  </table>\n";
                    }

                    echo "                </td>\n";
                    echo "              </tr>\n";
                    echo "            </table>\n";

                } else {

                    echo "            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                    echo "              <tr>\n";
                    echo "                <td align=\"left\" class=\"threads_top_left_bottom\" valign=\"top\" width=\"50%\" style=\"white-space: nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"", gettext("View messages in this folder only"), "\">";

                    if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                        echo $folder_msgs[$folder_number];
                    } else {
                        echo "0";
                    }

                    echo "&nbsp;", gettext("threads"), "</a></td>\n";
                    echo "                <td align=\"left\" class=\"threads_top_right_bottom\" valign=\"top\" width=\"50%\" style=\"white-space: nowrap\">";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        echo "<a href=\"", ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) ? "post.php?webtag=$webtag" : (forum_get_setting('allow_polls', 'Y') ? "create_poll.php?webtag=$webtag" : "");
                        echo "&amp;fid={$folder_number}\" target=\"", html_get_frame_name('main'), "\" class=\"folderpostnew\" title=\"", gettext("Create new discussion in this folder"), "\">", gettext("Post New"), "</a>";

                    } else {

                        echo "&nbsp;";
                    }

                    echo "</td>\n";
                    echo "              </tr>\n";
                    echo "            </table>\n";
                }

            } else if ($folder_info[$folder_number]['INTEREST'] != FOLDER_IGNORED) {

                // Only display the additional folder info if the user DOESN'T have the folder on ignore
                echo "            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                echo "              <tr>\n";
                echo "                <td class=\"threads_top_left_bottom\" align=\"left\" valign=\"top\" width=\"50%\" style=\"white-space: nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"", gettext("View messages in this folder only"), "\">";

                if (isset($folder_msgs[$folder_number])) {
                    echo $folder_msgs[$folder_number];
                } else {
                    echo "0";
                }

                echo "&nbsp;", gettext("threads"), "</a></td>\n";
                echo "                <td align=\"left\" class=\"threads_top_right_bottom\" valign=\"top\" width=\"50%\" style=\"white-space: nowrap\">";

                if (session::check_perm(USER_PERM_THREAD_CREATE, $folder_number)) {

                    echo "<a href=\"";
                    echo $folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD ? "post.php?webtag=$webtag" : (forum_get_setting('allow_polls', 'Y') ? "create_poll.php?webtag=$webtag" : "");
                    echo "&amp;fid=$folder_number\" target=\"", html_get_frame_name('main'), "\" class=\"folderpostnew\" title=\"", gettext("Create new discussion in this folder"), "\">", gettext("Post New"), "</a>";

                } else {

                    echo "&nbsp;";
                }

                echo "</td>\n";
                echo "              </tr>\n";
                echo "            </table>\n";

            }

            echo "          </td>\n";
            echo "        </tr>\n";
            echo "      </table>\n";
            echo "    </td>\n";
            echo "  </tr>\n";
            echo "</table>\n";
        }

        if (is_array($thread_info)) reset($thread_info);
    }
}

echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";

if (!is_numeric($folder) && ($thread_count >= 50)) {

    echo "<tr>\n";
    echo "  <td colspan=\"2\">&nbsp;</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "  <td align=\"left\" valign=\"top\" class=\"smalltext\" colspan=\"2\">", html_style_image('current_thread'), "&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=$mode&amp;page=", ($page + 1), "\" title=\"", gettext("Show next 50 threads"), "\">", gettext("Next 50 threads"), "</a></td>\n";
    echo "</tr>\n";
}

echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (session::logged_in()) {

    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">", gettext("Mark as Read"), ":</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" width=\"15\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"f_mark\" method=\"post\" action=\"thread_list.php\">\n";
    echo "        ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "        ", form_input_hidden("mode", htmlentities_array($mode)), "\n";
    echo "        ", form_input_hidden("page", htmlentities_array($page)), "\n";
    echo "        ", form_input_hidden('mark_read_confirm', 'N'), "\n";

    $labels = array(
        gettext("All Discussions"),
        gettext("Next 50 discussions")
    );

    $selected_option = THREAD_MARK_READ_ALL;

    if (sizeof($visible_threads_array) > 0) {

        $labels[] = gettext("Visible discussions");
        $selected_option = THREAD_MARK_READ_VISIBLE;

        $visible_threads = implode(',', array_filter($visible_threads_array, 'is_numeric'));
        echo "        ", form_input_hidden("mark_read_threads", htmlentities_array($visible_threads)), "\n";
    }

    if (isset($folder) && is_numeric($folder)) {

        echo "        ", form_input_hidden('folder', htmlentities_array($folder)), "\n";

        $labels[] = gettext("Selected folder");
        $selected_option = THREAD_MARK_READ_FOLDER;
    }

    echo "        ", form_dropdown_array("mark_read_type", $labels, $selected_option) . "\n";
    echo "        ", form_submit("mark_read_submit", gettext("Go!")) . "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">", gettext("Navigate"), ":</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" width=\"15\">&nbsp;</td>\n";
echo "    <td align=\"left\" class=\"smalltext\">\n";
echo "      <form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"", html_get_frame_name('right'), "\">\n";
echo "        ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

if (isset($folder) && is_numeric($folder)) {
    echo "        ", form_input_hidden('folder', htmlentities_array($folder)), "\n";
}

echo "        ", form_input_text('msg', '1.1', 10), "\n";
echo "        ", form_submit("go", gettext("Go!")), "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();