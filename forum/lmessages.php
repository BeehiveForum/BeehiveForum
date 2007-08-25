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

/* $Id: lmessages.php,v 1.85 2007-08-25 20:38:49 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {

    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag");
}

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {

    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag");
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

    header_redirect("./lforums.php");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("./lforums.php");
}

// Check that required variables are set
// default to display most recent discussion for user

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $uid = bh_session_get_value('UID');
    $msg = $_GET['msg'];

}else {

    if ($uid = bh_session_get_value('UID')) {
        $msg = messages_get_most_recent($uid);
    } else {
        $msg = "1.1";
    }
}

list($tid, $pid) = explode('.', $msg);

if (!is_numeric($pid)) $pid = 1;
if (!is_numeric($tid)) $tid = 1;

// Poll stuff

if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['pollvote'])) {

        poll_vote($_POST['tid'], $_POST['pollvote']);
        header_redirect("lmessages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");

    }else {

        light_html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['mustselectpolloption']}</h2>";
        light_html_draw_bottom();
        exit;
    }
}


if ($posts_per_page = bh_session_get_value('POSTS_PER_PAGE')) {

    if ($posts_per_page < 10) $posts_per_page = 10;
    if ($posts_per_page > 30) $posts_per_page = 30;

}else {

    $posts_per_page = 20;
}

if (!$messages = messages_get($tid, $pid, $posts_per_page)) {

    light_html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
    light_html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid, bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    light_html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
    light_html_draw_bottom();
    exit;
}

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
$thread_title = thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']);

light_html_draw_top("$forum_name > $thread_title");

$foldertitle = folder_get_title($threaddata['FID']);

$msg_count = count($messages);

light_messages_top($msg, $threaddata['PREFIX'], $threaddata['TITLE'], $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK']);

if ($tracking_data_array = thread_get_tracking_data($tid)) {

    foreach ($tracking_data_array as $tracking_data) {

        if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_MERGE) { // Thread merged

            if ($tracking_data['TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], $lang['threadmovedhere']);

                echo "<p>", sprintf($lang['thisthreadhasmoved'], $thread_link), "</p>\n";
            }

            if ($tracking_data['NEW_TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['TID'], $lang['threadmovedhere']);

                echo "<p>", sprintf($lang['thisthreadwasmergedfrom'], $thread_link), "</p>\n";
            }

        }elseif ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_SPLIT) { // Thread Split

            if ($tracking_data['TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], $lang['threadmovedhere']);

                echo "<p>", sprintf($lang['somepostsinthisthreadhavebeenmoved'], $thread_link), "</p>\n";
            }

            if ($tracking_data['NEW_TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['TID'], $lang['threadmovedhere']);

                echo "<p>", sprintf($lang['somepostsinthisthreadweremovedfrom'], $thread_link), "</p>\n";
            }
        }
    }
}

if ($msg_count > 0) {

    $first_msg = $messages[0]['PID'];

    foreach($messages as $message) {

        if (isset($message['RELATIONSHIP'])) {

            if ($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                $message['CONTENT'] = message_get_content($tid, $message['PID']);
            }else {
                $message['CONTENT'] = $lang['ignored']; // must be set to something or will show as deleted
            }

        }else {

          $message['CONTENT'] = message_get_content($tid, $message['PID']);

        }

        if ($threaddata['POLL_FLAG'] == 'Y') {

            if ($message['PID'] == 1) {

                light_poll_display($tid, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], true);
                $last_pid = $message['PID'];

            }else {

                light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], true, true, false, false);
                $last_pid = $message['PID'];
            }

        }else {

            light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], true, false, false, false);
            $last_pid = $message['PID'];

        }
    }
}

unset($messages, $message);

if ($last_pid < $threaddata['LENGTH']) {

    $npid = $last_pid + 1;
    echo form_quick_button("./lmessages.php", $lang['keepreading'], array('msg' => "$tid.$npid"));
}

light_messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $posts_per_page);

if (($threaddata['CLOSED'] == 0 && bh_session_check_perm(USER_PERM_POST_CREATE, $threaddata['FID'])) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $threaddata['FID'])) {
    echo "<p><a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\">{$lang['replyall']}</a></p>\n";
}

if (user_is_guest()) {
    echo "<h4><a href=\"lthread_list.php?webtag=$webtag\">{$lang['backtothreadlist']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['login']}</a></h4>\n";
}else {
    echo "<h4><a href=\"lthread_list.php?webtag=$webtag\">{$lang['backtothreadlist']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

if ($msg_count > 0 && !user_is_guest()) {
    messages_update_read($tid, $pid, $threaddata['LAST_READ'], $threaddata['LENGTH'], $threaddata['MODIFIED']);
}

?>