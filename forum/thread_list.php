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

/* $Id: thread_list.php,v 1.274 2006-10-27 23:28:43 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

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

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check the RSS feeds

rss_check_feeds();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Are we viewing a specific folder only?

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
    $folder = $_GET['folder'];
    $mode = 0;
}

// Check that required variables are set

if (bh_session_get_value('UID') == 0) {

    $uid = 0; // default to UID 0 if no other UID specified

    if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {
        // non-logged in users can only display "All" threads or those in the past x days, since the other options would be impossible
        if ($_GET['mode'] == 0 || $_GET['mode'] == 3 || $_GET['mode'] == 4 || $_GET['mode'] == 5) {
            $mode = $_GET['mode'];
        }else {
            $mode = 0;
        }
    }else {
        if (isset($_COOKIE['bh_thread_mode']) && is_numeric($_COOKIE['bh_thread_mode'])) {
            $mode = $_COOKIE['bh_thread_mode'];
        }else{
            $mode = 0;
        }
    }

}else {

    $uid = bh_session_get_value('UID');

    if (isset($_GET['markread'])) {

        if ($_GET['markread'] == 2 && isset($_GET['tid_array']) && is_array($_GET['tid_array'])) {
            threads_mark_read($_GET['tid_array']);
        }elseif ($_GET['markread'] == 0) {
            threads_mark_all_read();
        }elseif ($_GET['markread'] == 1) {
            threads_mark_50_read();
        }elseif ($_GET['markread'] == 3 && isset($folder)) {
            threads_mark_folder_read($folder);
        }
    }

    if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {

        $mode = $_GET['mode'];

        if ($mode == 19) {
            header_redirect("./search.php?offset=0");
        }

    }else {
        if (isset($_COOKIE['bh_thread_mode']) && is_numeric($_COOKIE['bh_thread_mode'])) {
            $mode = $_COOKIE['bh_thread_mode'];
        }else{
            if (threads_any_unread()) { // default to "Unread" messages for a logged-in user, unless there aren't any
                $mode = 1;
            }else {
                $mode = 0;
            }
        }
    }
}

if (bh_session_get_value('UID') != 0) {
    bh_setcookie('bh_thread_mode', $mode);
}

if (isset($_GET['start_from']) && is_numeric($_GET['start_from'])) {
    $start_from = $_GET['start_from'];
}else {
    $start_from = 0;
}

// Output XHTML header
html_draw_top("modslist.js");

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function confirmFolderIgnore() {\n";
echo "    return window.confirm('{$lang['ignorefolderconfirm']}');\n";
echo "}\n\n";
echo "function confirmFolderUnignore() {\n";
echo "    return window.confirm('{$lang['unignorefolderconfirm']}');\n";
echo "}\n\n";
echo "//-->\n";
echo "</script>\n";

// Draw discussion dropdown
thread_list_draw_top($mode);

// The tricky bit - displaying the right threads for whatever mode is selected

if (isset($folder)) {
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
        case 20: // Deleted threads
            list($thread_info, $folder_order) = threads_get_deleted($uid);
            break;
        default: // Default to all threads
            list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
            break;
    }
}

// Now, the actual bit that displays the threads...

// Get folder FIDs and titles
$folder_info = threads_get_folders();

if (!$folder_info) {

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

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $threadvisible = false;

    list($tid, $pid) = explode('.', $_GET['msg']);

    if ($thread = thread_get($tid)) {

        if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

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
    echo "<p>{$lang['nomessagesinthiscategory']} <a href=\"thread_list.php?webtag=$webtag&amp;mode=0\">{$lang['clickhere']}</a> {$lang['forallthreads']}.</p>\n";
}else {
    echo "<br />\n";
}

echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";

if ($start_from != 0 && $mode == 0 && !isset($folder)) echo "<tr><td class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['prev50threads']}\" title=\"{$lang['prev50threads']}\" />&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from - 50)."\" title=\"{$lang['showprev50threads']}\">{$lang['prev50threads']}</a></td></tr><tr><td align=\"left\">&nbsp;</td></tr>\n";

// Iterate through the information we've just got and display it in the right order

foreach ($folder_order as $key1 => $folder_number) {

    if (isset($folder_info[$folder_number]) && is_array($folder_info[$folder_number])) {

        echo "  <tr>\n";
        echo "    <td align=\"left\" colspan=\"2\">\n";
        echo "      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "        <tr>\n";
        echo "          <td align=\"left\" class=\"foldername\">\n";

        if ($folder_info[$folder_number]['INTEREST'] == 0) {
            echo "            <img src=\"".style_image('folder.png')."\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" />\n";
        }else {
            echo "            <img src=\"".style_image('folder_ignored.png')."\" alt=\"{$lang['ignoredfolder']}\" title=\"{$lang['ignoredfolder']}\" />\n";
        }

        echo "            <a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder_number\" title=\"", add_wordfilter_tags(_htmlentities($folder_info[$folder_number]['DESCRIPTION'])), "\">", add_wordfilter_tags(_htmlentities($folder_info[$folder_number]['TITLE'])), "</a>\n";
        echo "          </td>\n";

        if (bh_session_get_value('UID') > 0) {

            echo "          <td align=\"left\" class=\"folderpostnew\" nowrap=\"nowrap\"><a href=\"javascript:void(0);\" onclick=\"openModsList({$folder_number}, '$webtag')\"><img src=\"". style_image('mods_list.png'). "\" border=\"0\" alt=\"View moderators\" title=\"View moderators\" /></a>";

            if ($folder_info[$folder_number]['INTEREST'] == 0) {
                echo "<a href=\"user_folder.php?webtag=$webtag&amp;fid=$folder_number&amp;interest=-1\" onclick=\"return confirmFolderIgnore();\"><img src=\"". style_image('folder_hide.png'). "\" border=\"0\" alt=\"{$lang['ignorethisfolder']}\" title=\"{$lang['ignorethisfolder']}\" /></a></td>\n";
            }else {
                echo "<a href=\"user_folder.php?webtag=$webtag&amp;fid=$folder_number&amp;interest=0\" onclick=\"return confirmFolderUnignore();\"><img src=\"". style_image('folder_show.png'). "\" border=\"0\" alt=\"{$lang['stopignoringthisfolder']}\" title=\"{$lang['stopignoringthisfolder']}\" /></a></td>\n";
            }
        }

        echo "        </tr>\n";
        echo "      </table>\n";
        echo "    </td>\n";
        echo "  </tr>\n";

        if ((bh_session_get_value('UID') == 0) || ($folder_info[$folder_number]['INTEREST'] != -1) || ($mode == 2) || (isset($selected_folder) && $selected_folder == $folder_number)) {

            if (is_array($thread_info)) {

                $visible_threads = in_array($folder_number, $folder_order);

                if ($visible_threads) {

                    echo "  <tr>\n";
                    echo "    <td align=\"left\" class=\"threads_top_left\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"{$lang['viewmessagesinthisfolderonly']}\">";

                    if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo "&nbsp;{$lang['threads']}</a></td>\n";
                    echo "    <td align=\"left\" class=\"threads_top_right\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        echo "<a href=\"", ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) ? "./post.php?webtag=$webtag" : "./create_poll.php?webtag=$webtag";
                        echo "&amp;fid={$folder_number}\" target=\"main\" class=\"folderpostnew\" title=\"{$lang['createnewdiscussioninthisfolder']}\">{$lang['postnew']}</a>";

                    }else {

                        echo "&nbsp;";
                    }

                    echo "</td>\n";
                    echo "  </tr>\n";

                    if ($start_from != 0 && isset($folder) && $folder_number == $folder) {

                        echo "  <tr>\n";
                        echo "    <td align=\"left\" class=\"threads_left_right\" colspan=\"2\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=", ($start_from - 50), "\" class=\"folderinfo\" title=\"{$lang['showprev50threads']}\">{$lang['prev50threads']}</a></td>\n";
                        echo "  </tr>\n";
                    }

                    echo "  <tr>\n";
                    echo "    <td align=\"left\" class=\"threads_left_right_bottom\" colspan=\"2\">\n";
                    echo "      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";

                    foreach($thread_info as $key2 => $thread) {

                        if (!isset($visible_threads_array) || !is_array($visible_threads_array)) $visible_threads_array = array();
                        if (!in_array($thread['TID'], array_keys($visible_threads_array))) $visible_threads_array[$thread['TID']] = $thread['LENGTH'];

                        if ($thread['FID'] == $folder_number) {

                            echo "        <tr>\n";
                            echo "          <td valign=\"top\" align=\"center\" nowrap=\"nowrap\" width=\"20\">";
                            echo "<a href=\"thread_options.php?webtag=$webtag&amp;tid={$thread['TID']}\" target=\"right\">";

                            if ($thread['LAST_READ'] == 0) {

                                if ($thread['LENGTH'] > 1) {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['manynew'], $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"right\" title=\"{$lang['gotolastpostinthread']}\">]</a>";

                                }else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['onenew'], $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"right\" title=\"{$lang['gotolastpostinthread']}\">]</a>";
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

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['manynewoflength'], $new_posts, $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"right\" title=\"{$lang['gotolastpostinthread']}\">]</a>";

                                }else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= sprintf($lang['onenewoflength'], $new_posts, $thread['LENGTH']);
                                    $number.= "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"right\" title=\"{$lang['gotolastpostinthread']}\">]</a>";
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

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= "{$thread['LENGTH']}<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$thread['LENGTH']}\" target=\"right\" title=\"{$lang['gotolastpostinthread']}\">]</a>";

                                }else {

                                    $number = "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotofirstpostinthread']}\">[</a>";
                                    $number.= "1<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.1\" target=\"right\" title=\"{$lang['gotolastpostinthread']}\">]</a>";
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
                            echo "          <td align=\"left\" valign=\"top\">";
                            echo "<a href=\"messages.php?webtag=$webtag&amp;msg={$thread['TID']}.{$latest_post}\" target=\"right\" class=\"threadname\" onclick=\"change_current_thread('{$thread['TID']}');\"";
                            echo "title=\"#{$thread['TID']} {$lang['startedby']} ", add_wordfilter_tags(format_user_name($thread['LOGON'], $thread['NICKNAME'])), ". ";
                            echo ($thread['VIEWCOUNT'] == 1) ? $lang['threadviewedonetime'] : sprintf($lang['threadviewedtimes'], $thread['VIEWCOUNT']), "\">";
                            echo add_wordfilter_tags($thread['TITLE']), "</a> ";

                            if ($thread['INTEREST'] == 1) echo "<img src=\"".style_image('high_interest.png')."\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" /> ";
                            if ($thread['INTEREST'] == 2) echo "<img src=\"".style_image('subscribe.png')."\" alt=\"{$lang['subscribed']}\" title=\"{$lang['subscribed']}\" /> ";
                            if ($thread['POLL_FLAG'] == 'Y') echo "<a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid={$thread['TID']}', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['thisisapoll']}\" title=\"{$lang['thisisapoll']}\" /></a> ";
                            if ($thread['STICKY'] == 'Y') echo "<img src=\"".style_image('sticky.png')."\" alt=\"{$lang['sticky']}\" title=\"{$lang['sticky']}\" /> ";
                            if ($thread['RELATIONSHIP'] & USER_FRIEND) echo "<img src=\"" . style_image('friend.png') . "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" /> ";

                            if (isset($thread['AID']) && is_md5($thread['AID'])) echo "<img src=\"" . style_image('attach.png') . "\" alt=\"{$lang['attachment']}\" title=\"{$lang['attachment']}\" /> ";

                            echo "<span class=\"threadxnewofy\">{$number}</span></td>\n";
                            echo "          <td valign=\"top\" nowrap=\"nowrap\" align=\"right\"><span class=\"threadtime\">{$thread_time}&nbsp;</span></td>\n";
                            echo "        </tr>\n";

                        }
                    }

                    if (isset($folder) && $folder_number == $folder) {

                         $more_threads = $folder_msgs[$folder] - $start_from - 50;

                        if ($more_threads > 0 && $more_threads <= 50) {
                            echo "        <tr>\n";
                            echo "          <td align=\"left\" colspan=\"3\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\" class=\"folderinfo\">{$lang['next']} $more_threads {$lang['threads']}</a></td>\n";
                            echo "        </tr>\n";
                        }

                        if ($more_threads > 50) {
                            echo "        <tr>\n";
                            echo "          <td align=\"left\" colspan=\"3\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\" class=\"folderinfo\" title=\"{$lang['shownext50threads']}\">{$lang['next50threads']}</a></td>\n";
                            echo "        </tr>\n";
                        }

                    }

                    echo "      </table>\n";
                    echo "    </td>\n";
                    echo "  </tr>\n";

                }else {

                    echo "  <tr>\n";
                    echo "    <td align=\"left\" class=\"threads_top_left_bottom\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"{$lang['viewmessagesinthisfolderonly']}\">";

                    if (isset($folder_msgs[$folder_number]) && $folder_msgs[$folder_number] > 0) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo "&nbsp;{$lang['threads']}</a></td>\n";
                    echo "    <td align=\"left\" class=\"threads_top_right_bottom\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        echo "<a href=\"", ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) ? "./post.php?webtag=$webtag" : "./create_poll.php?webtag=$webtag";
                        echo "&amp;fid={$folder_number}\" target=\"main\" class=\"folderpostnew\" title=\"{$lang['createnewdiscussioninthisfolder']}\">{$lang['postnew']}</a>";

                    }else {

                        echo "&nbsp;";
                    }

                    echo "</td>\n";
                    echo "  </tr>\n";
                }

            }elseif ($folder_info[$folder_number]['INTEREST'] != -1) {

                // Only display the additional folder info if the user _DOESN'T_ have the folder on ignore

                echo "  <tr>\n";
                echo "    <td class=\"threads_top_left_bottom\" align=\"left\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\"><a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;folder={$folder_number}\" class=\"folderinfo\" title=\"{$lang['viewmessagesinthisfolderonly']}\">";

                if (isset($folder_msgs[$folder_number])) {
                    echo $folder_msgs[$folder_number];
                }else {
                    echo "0";
                }

                echo "&nbsp;{$lang['threads']}</a></td>\n";
                echo "    <td align=\"left\" class=\"threads_top_right_bottom\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">";

                if (bh_session_check_perm(USER_PERM_THREAD_CREATE, $folder_number)) {

                    echo "<a href=\"";
                    echo $folder_info[$folder_number]['ALLOWED_TYPES']&FOLDER_ALLOW_NORMAL_THREAD ? "./post.php?webtag=$webtag" : "./create_poll.php?webtag=$webtag";
                    echo "&amp;fid=$folder_number\" target=\"main\" class=\"folderpostnew\" title=\"{$lang['createnewdiscussioninthisfolder']}\">{$lang['postnew']}</a>";

                }else {

                    echo "&nbsp;";
                }

                echo "</td>\n";
                echo "  </tr>\n";

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
      if ($more_threads > 0 && $more_threads <= 50) echo "<tr><td colspan=\"2\">&nbsp;</td></tr><tr><td align=\"left\" class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['next']} $more_threads {$lang['threads']}\" title=\"{$lang['next']} $more_threads {$lang['threads']}\" />&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\">{$lang['next']} $more_threads {$lang['threads']}</td></tr>\n";
      if ($more_threads > 50) echo "<tr><td colspan=\"2\">&nbsp;</td></tr><tr><td align=\"left\" class=\"smalltext\" colspan=\"2\"><img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['next50threads']}\" title=\"{$lang['next50threads']}\" />&nbsp;<a href=\"thread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\" title=\"{$lang['shownext50threads']}\">{$lang['next50threads']}</a></td></tr>\n";

    }
}

echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (bh_session_get_value('UID') != 0) {

    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['markasread']}:</td>\n";
    echo "  </tr>\n";

    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form name=\"f_mark\" method=\"get\" action=\"thread_list.php\">\n";
    echo "        ", form_input_hidden('webtag', $webtag), "\n";

    $labels = array($lang['alldiscussions'], $lang['next50discussions']);
    $selected_option = 0;

    if (isset($visible_threads_array) && is_array($visible_threads_array)) {

        $labels[] = $lang['visiblediscussions'];
        $selected_option = 2;

        foreach ($visible_threads_array as $tid => $length) {
            echo "        ", form_input_hidden("tid_array[$tid]", $length), "\n";
        }
    }

    if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        echo "        ", form_input_hidden('folder', $folder), "\n";

        $labels[] = $lang['selectedfolder'];
        $selected_option = 3;
    }

    echo "        ", form_dropdown_array("markread", range(0, sizeof($labels) - 1), $labels, $selected_option). "\n";
    echo "        ", form_submit("go",$lang['goexcmark']). "\n";
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
echo "      <form name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"right\">\n";
echo "        ", form_input_hidden('webtag', $webtag), "\n";

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
    echo "        ", form_input_hidden('folder', $folder), "\n";
}

echo "        ", form_input_text('msg', '1.1', 10), "\n";
echo "        ", form_submit("go",$lang['goexcmark']), "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['search']} (<a href=\"search.php?webtag=$webtag\" target=\"right\">{$lang['advanced']}</a>):</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "    <td align=\"left\" class=\"smalltext\">\n";
echo "      <form method=\"post\" action=\"search.php\" target=\"_self\">\n";
echo "        ", form_input_hidden('webtag', $webtag), "\n";

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
    echo "        ", form_input_hidden('folder', $folder), "\n";
}

echo "        ", form_input_text("search_string", "", 20). "\n";
echo "        ", form_submit("submit", $lang['find']). "\n";
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