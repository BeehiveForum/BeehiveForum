<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: thread_list.php,v 1.336 2008-07-25 14:52:49 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "rss_feed.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

// Intitalise a few variables

$webtag_search = false;

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check the RSS feeds

rss_check_feeds();

// Array to hold error messages

$error_msg_array = array();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Are we viewing a specific folder only?

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $folder = $_GET['folder'];
    $mode = ALL_DISCUSSIONS;

}else {

    $folder = false;
}

// Check that required variables are set

if (user_is_guest()) {

    $uid = 0; // default to UID 0 if no other UID specified

    if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {

        // non-logged in users can only display "All" threads
        // or those in the past x days, since the other options
        // would be impossible

        if ($_GET['mode'] == ALL_DISCUSSIONS || $_GET['mode'] == TODAYS_DISCUSSIONS || $_GET['mode'] == TWO_DAYS_BACK || $_GET['mode'] == SEVEN_DAYS_BACK) {
            $mode = $_GET['mode'];
        }else {
            $mode = ALL_DISCUSSIONS;
        }

    }else {

        if (isset($_COOKIE["bh_{$webtag}_thread_mode"]) && is_numeric($_COOKIE["bh_{$webtag}_thread_mode"])) {
            $mode = $_COOKIE["bh_{$webtag}_thread_mode"];
        }else{
            $mode = ALL_DISCUSSIONS;
        }
    }

}else {

    $uid = bh_session_get_value('UID');

    $threads_any_unread = threads_any_unread();

    if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {

        $mode = $_GET['mode'];

        bh_setcookie("bh_{$webtag}_thread_mode", $mode);

        if ($mode == SEARCH_RESULTS) {

            header_redirect("search.php?webtag=$webtag&offset=0");
            exit;
        }

    }else {

        if (isset($_COOKIE["bh_{$webtag}_thread_mode"]) && is_numeric($_COOKIE["bh_{$webtag}_thread_mode"])) {

            $mode = $_COOKIE["bh_{$webtag}_thread_mode"];

            if ($mode == SEARCH_RESULTS) {

                header_redirect("search.php?webtag=$webtag&offset=0");
                exit;

            }elseif ($mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {

                $mode = ALL_DISCUSSIONS;
            }

        }else {

            if ($threads_any_unread) {

                $mode = UNREAD_DISCUSSIONS;

            }else {

                $mode = ALL_DISCUSSIONS;
            }
        }
    }

    if (isset($_GET['mark_read_submit'])) {

        if (isset($_GET['mark_read_confirm']) && $_GET['mark_read_confirm'] == 'Y') {

            if ($_GET['mark_read_type'] == THREAD_MARK_READ_VISIBLE) {

                if (isset($_GET['mark_read_threads_array']) && is_array($_GET['mark_read_threads_array'])) {

                    $mark_read_threads_array = preg_grep("/^[0-9]+$/", $_GET['mark_read_threads_array']);

                    $thread_data = array();

                    threads_get_unread_data($thread_data, $mark_read_threads_array);

                    if (threads_mark_read($thread_data)) {

                        header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                        exit;

                    }else {

                        $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                        $valid = false;
                    }
                }

            }elseif ($_GET['mark_read_type'] == THREAD_MARK_READ_ALL) {

                if (threads_mark_all_read()) {

                    header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }

            }elseif ($_GET['mark_read_type'] == THREAD_MARK_READ_FIFTY) {

                if (threads_mark_50_read()) {

                    header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }

            }elseif (($_GET['mark_read_type'] == THREAD_MARK_READ_FOLDER && isset($folder) && is_numeric($folder))) {

                if (threads_mark_folder_read($folder)) {

                    header_redirect("thread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }
            }

        }else {

            unset($_GET['mark_read_submit'], $_GET['mark_read_confirm']);

            html_draw_top();
            html_display_msg($lang['confirm'], $lang['confirmmarkasread'], 'thread_list.php', 'get', array('mark_read_submit' => $lang['confirm'], 'cancel' => $lang['cancel']), array_merge($_GET, array('mark_read_confirm' => 'Y')));
            html_draw_bottom();
            exit;
        }
    }
}

if (isset($_GET['start_from']) && is_numeric($_GET['start_from'])) {
    $start_from = $_GET['start_from'];
}else {
    $start_from = 0;
}

// Output XHTML header

html_draw_top("modslist.js", "poll.js", "thread_options.js", "folder_options.js");

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function confirmMarkAsRead()\n";
echo "{\n";
echo "    var mark_read_type = getObjsByName('mark_read_type')[0];\n";
echo "    var mark_read_confirm = getObjsByName('mark_read_confirm')[0];\n\n";
echo "    if ((typeof mark_read_type == 'object') && (typeof mark_read_confirm == 'object')) {\n\n";
echo "        if (window.confirm('", html_js_safe_str($lang['confirmmarkasread']), "')) {\n\n";
echo "            mark_read_confirm.value = 'Y';\n";
echo "            return true;\n";
echo "        }\n";
echo "    }\n\n";
echo "    return false;\n";
echo "}\n\n";
echo "//-->\n";
echo "</script>\n";

// The tricky bit - displaying the right threads for whatever mode is selected

if (isset($folder) && is_numeric($folder) && $folder > 0) {
    list($thread_info, $folder_order) = threads_get_folder($uid, $folder, $start_from);
}else {
    switch ($mode) {
        case ALL_DISCUSSIONS:
            list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
            break;
        case UNREAD_DISCUSSIONS:
            list($thread_info, $folder_order) = threads_get_unread($uid);
            break;
        case UNREAD_DISCUSSIONS_TO_ME:
            list($thread_info, $folder_order) = threads_get_unread_to_me($uid);
            break;
        case TODAYS_DISCUSSIONS:
            list($thread_info, $folder_order) = threads_get_by_days($uid, 1);
            break;
        case UNREAD_TODAY:
            list($thread_info, $folder_order) = threads_get_unread_by_days($uid);
            break;
        case TWO_DAYS_BACK:
            list($thread_info, $folder_order) = threads_get_by_days($uid, 2);
            break;
        case SEVEN_DAYS_BACK:
            list($thread_info, $folder_order) = threads_get_by_days($uid, 7);
            break;
        case HIGH_INTEREST:
            list($thread_info, $folder_order) = threads_get_by_interest($uid, 1);
            break;
        case UNREAD_HIGH_INTEREST:
            list($thread_info, $folder_order) = threads_get_unread_by_interest($uid, 1);
            break;
        case RECENTLY_SEEN:
            list($thread_info, $folder_order) = threads_get_recently_viewed($uid);
            break;
        case IGNORED:
            list($thread_info, $folder_order) = threads_get_by_interest($uid, -1);
            break;
        case BY_IGNORED_USERS:
            list($thread_info, $folder_order) = threads_get_by_relationship($uid, USER_IGNORED_COMPLETELY);
            break;
        case SUBSCRIBED_TO:
            list($thread_info, $folder_order) = threads_get_by_interest($uid, 2);
            break;
        case STARTED_BY_FRIEND:
            list($thread_info, $folder_order) = threads_get_by_relationship($uid, USER_FRIEND);
            break;
        case UNREAD_STARTED_BY_FRIEND:
            list($thread_info, $folder_order) = threads_get_unread_by_relationship($uid, USER_FRIEND);
            break;
        case STARTED_BY_ME:
            list($thread_info, $folder_order) = threads_get_started_by_me($uid);
            break;
        case POLLS:
            list($thread_info, $folder_order) = threads_get_polls($uid);
            break;
        case STICKY_THREADS:
            list($thread_info, $folder_order) = threads_get_sticky($uid);
            break;
        case MOST_UNREAD_POSTS:
            list($thread_info, $folder_order) = threads_get_longest_unread($uid);
            break;
        case DELETED_THREADS:
            list($thread_info, $folder_order) = threads_get_deleted($uid);
            break;
        default:
            list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
            break;
    }
}

// Now, the actual bit that displays the threads...

// Get folder FIDs and titles

if (!$folder_info = threads_get_folders()) {

    html_error_msg($lang['couldnotretrievefolderinformation']);
    html_draw_bottom();
    exit;
}

// Get total number of messages for each folder

$folder_msgs = threads_get_folder_msgs();

// Check to see if $folder_order is an array.
// If it's not an array we need to populate it
// with the keys from $folder_info to get a list
// of folders in the user's interest order.

if (!is_array($folder_order)) $folder_order = array_keys($folder_info);

// Sort the folders and threads correctly as per the URL query for the TID

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $threadvisible = false;

    list($tid, $pid) = explode('.', $_GET['msg']);

    if (($thread = thread_get($tid))) {

        if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

        if (in_array($thread['FID'], $folder_order)) {
            array_splice($folder_order, array_search($thread['FID'], $folder_order), 1);
        }

        array_unshift($folder_order, $thread['FID']);

        if (!is_array($thread_info)) $thread_info = array();

        if (isset($thread_info[$tid])) unset($thread_info[$tid]);

        array_unshift($thread_info, $thread);
    }
}

// Work out if any folders have no messages and add them.
// Seperate them by INTEREST level

if (bh_session_get_value('UID') > 0) {

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid, $pid) = explode('.', $_GET['msg']);

        if (($thread = thread_get($tid))) {
            $selected_folder = $thread['FID'];
        }

    }elseif (isset($_GET['folder'])) {

        $selected_folder = $_GET['folder'];

    }else {

        $selected_folder = 0;
    }

    $ignored_folders = array();

    while (list($fid, $folder_data) = each($folder_info)) {
        if (($folder_data['INTEREST'] == FOLDER_NOINTEREST || (isset($selected_folder) && $selected_folder == $fid))) {
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

// Draw discussion dropdown

thread_list_draw_top($mode);

// If no threads are returned, say something to that effect

if (!$thread_info) {

    $all_discussions_link = sprintf("<a href=\"thread_list.php?webtag=$webtag&amp;mode=0\">%s</a>", $lang['clickhere']);
    html_display_warning_msg(sprintf($lang['nomessagesinthiscategory'], $all_discussions_link), '100%', 'left');

}else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '100%', 'left');

}else if (isset($_GET['mark_read_success'])) {

    html_display_success_msg($lang['successfullymarkreadselectedthreads'], '100%', 'left');

}else {

    echo "<br />\n";
}

if (($start_from != 0 && $mode == ALL_DISCUSSIONS && !isset($folder))) {

    echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['prev50threads']}\" title=\"{$lang['prev50threads']}\" />&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from - 50)."\" title=\"{$lang['showprev50threads']}\">{$lang['prev50threads']}</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

// Iterate through the information we've just got and display it in the right order

foreach ($folder_order as $folder_number) {

    if (isset($folder_info[$folder_number]) && is_array($folder_info[$folder_number])) {

        echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" colspan=\"2\">\n";
        echo "      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "        <tr>\n";
        echo "          <td align=\"left\" class=\"foldername\">\n";

        if ($folder_info[$folder_number]['INTEREST'] == FOLDER_SUBSCRIBED) {
            echo "            <a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" onclick=\"return openFolderOptions($folder_number, '$webtag')\"><img src=\"".style_image('folder_subscribed.png')."\" alt=\"{$lang['subscribedfolder']}\" title=\"{$lang['subscribedfolder']}\" border=\"0\" /></a>\n";
        }else if ($folder_info[$folder_number]['INTEREST'] == FOLDER_IGNORED) {
            echo "            <a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" onclick=\"return openFolderOptions($folder_number, '$webtag')\"><img src=\"".style_image('folder_ignored.png')."\" alt=\"{$lang['ignoredfolder']}\" title=\"{$lang['ignoredfolder']}\" border=\"0\" /></a>\n";
        }else {
            echo "            <a href=\"folder_options.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" onclick=\"return openFolderOptions($folder_number, '$webtag')\"><img src=\"".style_image('folder.png')."\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" border=\"0\" /></a>\n";
        }

        echo "            <a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder_number\" title=\"", word_filter_add_ob_tags(_htmlentities($folder_info[$folder_number]['DESCRIPTION'])), "\">", word_filter_add_ob_tags(_htmlentities($folder_info[$folder_number]['TITLE'])), "</a>\n";
        echo "          </td>\n";

        if (bh_session_get_value('UID') > 0) {
            echo "          <td align=\"left\" class=\"folderpostnew\" nowrap=\"nowrap\"><a href=\"mods_list.php?webtag=$webtag&amp;fid=$folder_number\" target=\"_blank\" onclick=\"return openModsList({$folder_number}, '$webtag')\"><img src=\"". style_image('mods_list.png'). "\" border=\"0\" alt=\"View moderators\" title=\"View moderators\" /></a></td>";
        }

        echo "        </tr>\n";
        echo "      </table>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";

        if ((user_is_guest()) || ($folder_info[$folder_number]['INTEREST'] > FOLDER_IGNORED) || ($mode == UNREAD_DISCUSSIONS_TO_ME) || (isset($selected_folder) && $selected_folder == $folder_number)) {

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
                    echo "                <td align=\"left\" class=\"threads_top_left\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"{$lang['viewmessagesinthisfolderonly']}\">";

                    if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo "&nbsp;{$lang['threads']}</a></td>\n";
                    echo "                <td align=\"left\" class=\"threads_top_right\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        echo "<a href=\"", ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) ? "post.php?webtag=$webtag" : (forum_get_setting('allow_polls', 'Y') ? "create_poll.php?webtag=$webtag" : "");
                        echo "&amp;fid={$folder_number}\" target=\"", html_get_frame_name('main'), "\" class=\"folderpostnew\" title=\"{$lang['createnewdiscussioninthisfolder']}\">{$lang['postnew']}</a>";

                    }else {

                        echo "&nbsp;";
                    }

                    echo "</td>\n";
                    echo "              </tr>\n";

                    if (($start_from != 0 && isset($folder) && $folder_number == $folder)) {

                        echo "              <tr>\n";
                        echo "                <td align=\"left\" class=\"threads_left_right\" colspan=\"2\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=", ($start_from - 50), "\" class=\"folderinfo\" title=\"{$lang['showprev50threads']}\">{$lang['prev50threads']}</a></td>\n";
                        echo "              </tr>\n";
                    }

                    echo "              <tr>\n";
                    echo "                <td align=\"left\" class=\"threads_left_right_bottom\" colspan=\"2\">\n";


                    foreach($thread_info as $thread) {

                        if (!isset($visible_threads_array) || !is_array($visible_threads_array)) $visible_threads_array = array();
                        if (!in_array($thread['TID'], $visible_threads_array)) $visible_threads_array[] = $thread['TID'];

                        if ($thread['FID'] == $folder_number) {

                            echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
                            echo "                    <tr>\n";
                            echo "                      <td valign=\"top\" align=\"center\" nowrap=\"nowrap\" width=\"20\">";
                            echo "<a href=\"thread_options.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"", html_get_frame_name('right'), "\">";

                            if ($thread['LAST_READ'] == 0) {

                                if ($thread['LENGTH'] > 1) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['manynew'], $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotolastpostinthread']}\">]</a>";

                                }else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['onenew'], $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotolastpostinthread']}\">]</a>";
                                }

                                $latest_post = 1;

                                if (!isset($first_thread) && isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                                    $first_thread = $thread['TID'];
                                    echo "<img src=\"", style_image('current_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['threadoptions']}\" title=\"{$lang['threadoptions']}\" border=\"0\" />";

                                }else {

                                    echo "<img src=\"", style_image('unread_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['threadoptions']}\" title=\"{$lang['threadoptions']}\" border=\"0\" />";
                                }

                            }elseif ($thread['LAST_READ'] < $thread['LENGTH']) {

                                $new_posts = $thread['LENGTH'] - $thread['LAST_READ'];

                                if ($new_posts > 1) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['manynewoflength'], $new_posts, $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotolastpostinthread']}\">]</a>";

                                }else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['onenewoflength'], $new_posts, $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotolastpostinthread']}\">]</a>";
                                }

                                $latest_post = $thread['LAST_READ'] + 1;

                                if (!isset($first_thread) && isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                                    $first_thread = $thread['TID'];
                                    echo "<img src=\"", style_image('current_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['threadoptions']}\" title=\"{$lang['threadoptions']}\" border=\"0\" />";

                                }else {

                                    echo "<img src=\"", style_image('unread_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['threadoptions']}\" title=\"{$lang['threadoptions']}\" border=\"0\" />";
                                }

                            }else {

                                if ($thread['LENGTH'] > 1) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= "{$thread['LENGTH']}<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotolastpostinthread']}\">]</a>";

                                }else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= "1<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"". html_get_frame_name('right'). "\" title=\"{$lang['gotolastpostinthread']}\">]</a>";
                                }

                                $latest_post = 1;

                                if (!isset($first_thread) && isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                                    $first_thread = $thread['TID'];
                                    echo "<img src=\"", style_image('current_thread.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['threadoptions']}\" title=\"{$lang['threadoptions']}\" border=\"0\" />";

                                }else {

                                    echo "<img src=\"", style_image('bullet.png'), "\" name=\"t{$thread['TID']}\" alt=\"{$lang['threadoptions']}\" title=\"{$lang['threadoptions']}\" border=\"0\" />";
                                }
                            }

                            echo "</a>";

                            $thread_time = format_time($thread['MODIFIED']);

                            echo "&nbsp;</td>\n";
                            echo "                      <td align=\"left\" valign=\"top\">";
                            echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$latest_post}\" target=\"", html_get_frame_name('right'), "\" class=\"threadname\" onclick=\"change_current_thread('{$thread['TID']}');\"";
                            echo "title=\"", sprintf($lang['threadstartedbytooltip'], $thread['TID'], word_filter_add_ob_tags(_htmlentities(format_user_name($thread['LOGON'], $thread['NICKNAME']))), ($thread['VIEWCOUNT'] == 1) ? $lang['threadviewedonetime'] : sprintf($lang['threadviewedtimes'], $thread['VIEWCOUNT'])), "\">";
                            echo word_filter_add_ob_tags(_htmlentities(thread_format_prefix($thread['PREFIX'], $thread['TITLE']))), "</a> ";

                            if (isset($thread['INTEREST']) && $thread['INTEREST'] == THREAD_INTERESTED) echo "<img src=\"".style_image('high_interest.png')."\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" /> ";
                            if (isset($thread['INTEREST']) && $thread['INTEREST'] == THREAD_SUBSCRIBED) echo "<img src=\"".style_image('subscribe.png')."\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" /> ";
                            if (isset($thread['POLL_FLAG']) && $thread['POLL_FLAG'] == 'Y') echo "<a href=\"poll_results.php?webtag=$webtag&tid={$thread['TID']}\" target=\"_blank\" onclick=\"return openPollResults('{$thread['TID']}', '$webtag')\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['thisisapoll']}\" title=\"{$lang['thisisapoll']}\" /></a> ";
                            if (isset($thread['STICKY']) && $thread['STICKY'] == 'Y') echo "<img src=\"".style_image('sticky.png')."\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" /> ";
                            if (isset($thread['RELATIONSHIP']) && $thread['RELATIONSHIP'] & USER_FRIEND) echo "<img src=\"" . style_image('friend.png') . "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" /> ";
                            if (isset($thread['TRACK_TYPE']) && $thread['TRACK_TYPE'] == THREAD_TYPE_SPLIT) echo "<img src=\"" . style_image('split_thread.png') . "\" alt=\"{$lang['threadhasbeensplit']}\" title=\"{$lang['threadhasbeensplit']}\" /> ";
                            if (isset($thread['TRACK_TYPE']) && $thread['TRACK_TYPE'] == THREAD_TYPE_MERGE) echo "<img src=\"" . style_image('merge_thread.png') . "\" alt=\"{$lang['threadhasbeenmerged']}\" title=\"{$lang['threadhasbeenmerged']}\" /> ";
                            if (isset($thread['AID']) && is_md5($thread['AID'])) echo "<img src=\"" . style_image('attach.png') . "\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" /> ";

                            echo "<span class=\"threadxnewofy\">{$number}</span></td>\n";
                            echo "                      <td valign=\"top\" nowrap=\"nowrap\" align=\"right\"><span class=\"threadtime\">{$thread_time}&nbsp;</span></td>\n";
                            echo "                    </tr>\n";
                            echo "                  </table>\n";

                        }
                    }

                    if (isset($folder) && $folder_number == $folder) {

                         $more_threads = $folder_msgs[$folder] - $start_from - 50;

                        if ($more_threads > 0 && $more_threads <= 50) {

                            echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
                            echo "                    <tr>\n";
                            echo "                      <td align=\"left\" colspan=\"3\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\" class=\"folderinfo\">", sprintf($lang['nextxthreads'], $more_threads), "</a></td>\n";
                            echo "                    </tr>\n";
                            echo "                  </table>\n";

                        }

                        if ($more_threads > 50) {

                            echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
                            echo "                    <tr>\n";
                            echo "                      <td align=\"left\" colspan=\"3\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\" class=\"folderinfo\" title=\"{$lang['shownext50threads']}\">{$lang['next50threads']}</a></td>\n";
                            echo "                    </tr>\n";
                            echo "                  </table>\n";
                        }
                    }

                    echo "                </td>\n";
                    echo "              </tr>\n";
                    echo "            </table>\n";

                }else {

                    echo "            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                    echo "              <tr>\n";
                    echo "                <td align=\"left\" class=\"threads_top_left_bottom\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"{$lang['viewmessagesinthisfolderonly']}\">";

                    if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo "&nbsp;{$lang['threads']}</a></td>\n";
                    echo "                <td align=\"left\" class=\"threads_top_right_bottom\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        echo "<a href=\"", ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) ? "post.php?webtag=$webtag" : (forum_get_setting('allow_polls', 'Y') ? "create_poll.php?webtag=$webtag" : "");
                        echo "&amp;fid={$folder_number}\" target=\"", html_get_frame_name('main'), "\" class=\"folderpostnew\" title=\"{$lang['createnewdiscussioninthisfolder']}\">{$lang['postnew']}</a>";

                    }else {

                        echo "&nbsp;";
                    }

                    echo "</td>\n";
                    echo "              </tr>\n";
                    echo "            </table>\n";
                }

            }elseif ($folder_info[$folder_number]['INTEREST'] != -1) {

                // Only display the additional folder info if the user _DOESN'T_ have the folder on ignore

                echo "            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                echo "              <tr>\n";
                echo "                <td class=\"threads_top_left_bottom\" align=\"left\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"{$lang['viewmessagesinthisfolderonly']}\">";

                if (isset($folder_msgs[$folder_number])) {
                    echo $folder_msgs[$folder_number];
                }else {
                    echo "0";
                }

                echo "&nbsp;{$lang['threads']}</a></td>\n";
                echo "                <td align=\"left\" class=\"threads_top_right_bottom\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">";

                if (bh_session_check_perm(USER_PERM_THREAD_CREATE, $folder_number)) {

                    echo "<a href=\"";
                    echo $folder_info[$folder_number]['ALLOWED_TYPES']&FOLDER_ALLOW_NORMAL_THREAD ? "post.php?webtag=$webtag" : (forum_get_setting('allow_polls', 'Y') ? "create_poll.php?webtag=$webtag" : "");
                    echo "&amp;fid=$folder_number\" target=\"", html_get_frame_name('main'), "\" class=\"folderpostnew\" title=\"{$lang['createnewdiscussioninthisfolder']}\">{$lang['postnew']}</a>";

                }else {

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

if (($mode == ALL_DISCUSSIONS && !isset($folder))) {

    $total_threads = 0;

    if (is_array($folder_msgs)) {

        while (list($fid, $num_threads) = each($folder_msgs)) {
            $total_threads += $num_threads;
        }

        $more_threads = $total_threads - $start_from - 50;

        if ($more_threads > 0 && $more_threads <= 50) {

            echo "<tr>\n";
            echo "  <td colspan=\"2\">&nbsp;</td>\n";
            echo "</tr>\n";
            echo "<tr>\n";
            echo "  <td align=\"left\" class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['next']} $more_threads {$lang['threads']}\" title=\"{$lang['next']} $more_threads {$lang['threads']}\" />&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\">", sprintf($lang['nextxthreads'], $more_threads), "</td>\n";
            echo "</tr>\n";

        }elseif ($more_threads > 50)  {

            echo "<tr>\n";
            echo "  <td colspan=\"2\">&nbsp;</td>\n";
            echo "</tr>\n";
            echo "<tr>\n";
            echo "  <td align=\"left\" class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['next50threads']}\" title=\"{$lang['next50threads']}\" />&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\" title=\"{$lang['shownext50threads']}\">{$lang['next50threads']}</a></td>\n";
            echo "</tr>\n";
        }
    }
}

echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (!user_is_guest()) {

    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['markasread']}:</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form name=\"f_mark\" method=\"get\" action=\"thread_list.php\">\n";
    echo "        ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "        ", form_input_hidden('mark_read_confirm', 'N'), "\n";

    $labels = array($lang['alldiscussions'], $lang['next50discussions']);
    $selected_option = THREAD_MARK_READ_ALL;

    if (isset($visible_threads_array) && is_array($visible_threads_array)) {

        $labels[] = $lang['visiblediscussions'];
        $selected_option = THREAD_MARK_READ_VISIBLE;

        foreach ($visible_threads_array as $tid) {
            echo "        ", form_input_hidden("mark_read_threads_array[]", _htmlentities($tid)), "\n";
        }
    }

    if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        echo "        ", form_input_hidden('folder', _htmlentities($folder)), "\n";

        $labels[] = $lang['selectedfolder'];
        $selected_option = THREAD_MARK_READ_FOLDER;
    }

    echo "        ", form_dropdown_array("mark_read_type", $labels, $selected_option). "\n";
    echo "        ", form_submit("mark_read_submit", $lang['goexcmark'], "onclick=\"return confirmMarkAsRead()\""). "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['navigate']}:</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "    <td align=\"left\" class=\"smalltext\">\n";
echo "      <form name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"", html_get_frame_name('right'), "\">\n";
echo "        ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
    echo "        ", form_input_hidden('folder', _htmlentities($folder)), "\n";
}

echo "        ", form_input_text('msg', '1.1', 10), "\n";
echo "        ", form_submit("go", $lang['goexcmark']), "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['search']} (<a href=\"search.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['advanced']}</a>):</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "    <td align=\"left\" class=\"smalltext\">\n";
echo "      <form method=\"post\" action=\"search.php\" target=\"", html_get_frame_name('right'), "\">\n";
echo "        ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
    echo "        ", form_input_hidden('folder', _htmlentities($folder)), "\n";
}

echo "        ", form_input_text("search_string", "", 20). "\n";
echo "        ", form_submit("search", $lang['find']). "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
echo "<!--\n";

if (isset($first_thread)) {
    echo "current_thread = $first_thread;\n";
}else {
    echo "current_thread = 0;\n";
}

echo "// -->";
echo "</script>\n";

html_draw_bottom();

?>