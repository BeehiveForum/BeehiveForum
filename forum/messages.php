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

/* $Id: messages.php,v 1.171 2005-01-19 21:49:29 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/beehive.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that required variables are set
// default to display most recent discussion for user

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

}else {

    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

@list($tid, $pid) = explode('.', $msg);

if (!isset($tid) || !is_numeric($tid)) $tid = 1;
if (!isset($pid) || !is_numeric($pid)) $pid = 1;

if (!thread_can_view($tid, bh_session_get_value('UID'))) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
    html_draw_bottom();
    exit;
}

// Poll stuff

if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['pollvote'])) {

        if (poll_check_tabular_votes($_POST['tid'], $_POST['pollvote'])) {

            poll_vote($_POST['tid'], $_POST['pollvote']);
            header_redirect("./messages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");

        }else {

            html_draw_top();
            echo "<h2>{$lang['mustvoteforallgroups']}</h2>";
            html_draw_bottom();
            exit;
        }

    }else {

        html_draw_top();
        echo "<h2>{$lang['mustselectpolloption']}</h2>";
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['pollclose'])) {

    if (isset($_POST['confirm_pollclose'])) {

        poll_close($_POST['tid']);
        header_redirect("./messages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");

    }else {

        html_draw_top("openprofile.js");
        poll_confirm_close($_POST['tid']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['pollchangevote'])) {

    poll_delete_vote($_POST['tid']);
    header_redirect("./messages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");

}

if (bh_session_get_value('POSTS_PER_PAGE')) {

    $ppp = bh_session_get_value('POSTS_PER_PAGE');

    if ($ppp < 10) $ppp = 10;
    if ($ppp > 30) $ppp = 30;

}else {

    $ppp = 20;
}

if (!$messages = messages_get($tid, $pid, $ppp)) {

    html_draw_top();
    echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid)) {

    html_draw_top();
    echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
    html_draw_bottom();
    exit;
}

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

html_draw_top("title={$forum_name} > {$threaddata['TITLE']}", "openprofile.js", "basetarget=_blank", "robots=index,follow");

if (isset($threaddata['STICKY']) && isset($threaddata['STICKY_UNTIL'])) {

    if ($threaddata['STICKY'] == "Y" && $threaddata['STICKY_UNTIL'] != 0 && time() > $threaddata['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $threaddata['STICKY'] == "N";
    }
}

$foldertitle = folder_get_title($threaddata['FID']);

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

$msg_count = count($messages);

$highlight_array = array();

if (isset($_GET['search_string']) && strlen(trim(_stripslashes($_GET['search_string']))) > 0) {
    $highlight_array = explode(' ', rawurldecode($_GET['search_string']));
}

// Check for search words to highlight -------------------------------------

if (sizeof($highlight_array) > 0) {

    $highlight_pattern = array();
    $highlight_replace = array();

    foreach ($highlight_array as $key => $word) {

        $highlight_word = preg_quote($word, "/");

        $highlight_pattern[$key] = "/($highlight_word)/i";
        $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
    }

    $thread_parts = preg_split('/([<|>])/', $threaddata['TITLE'], -1, PREG_SPLIT_DELIM_CAPTURE);

    for ($i = 0; $i < sizeof($thread_parts); $i++) {

        if (!($i % 4)) {

            $thread_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $thread_parts[$i], 1);
        }
    }

    $threaddata['TITLE'] = implode('', $thread_parts);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($foldertitle, $threaddata['TITLE'], $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK']), "</td>\n";

if ($threaddata['POLL_FLAG'] == 'Y' && $messages[0]['PID'] != 1) {

    if ($userpollvote = poll_get_user_vote($tid)) {

        if ($userpollvote ^ POLL_MULTIVOTE) {

            for ($i = 0; $i < sizeof($userpollvote); $i++) {

                $userpollvotes_array[] = $userpollvote[$i]['OPTION_ID'];
            }

            if (sizeof($userpollvotes_array) > 1) {

                echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoptions']}: ", implode(", ", $userpollvotes_array), "</td>\n";

            }else {

                echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoption']} #", implode(", ", $userpollvotes_array), "</td>\n";
            }
        }

    }else {

        echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktovote']}\"><img src=\"", style_image('poll.png'), "\" align=\"middle\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youhavenotvoted']}</td>\n";
    }
}

echo "  </tr>\n";

if (isset($_GET['markasread'])) {

    echo "  <tr>\n";
    echo "    <td><h2>{$lang['threareadstatusupdated']}</h2></td>\n";
    echo "  </tr>\n";
}

if (isset($_GET['setinterest'])) {

    echo "  <tr>\n";
    echo "    <td><h2>{$lang['interestupdated']}</h2></td>\n";
    echo "  </tr>\n";
}

echo "</table>\n";
echo "</div>\n";

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

            poll_display($tid, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], false, true, true, false, $highlight_array);
            $last_pid = $message['PID'];

          }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true, true, $show_sigs, false, $highlight_array);
            $last_pid = $message['PID'];

          }

        }else {

          message_display($tid, $message, $threaddata['LENGTH'], $first_msg, true, $threaddata['CLOSED'], true, false, $show_sigs, false, $highlight_array);
          $last_pid = $message['PID'];

        }
    }
}

unset($messages, $message);

if ($msg_count > 0 && bh_session_get_value('UID') != 0 && !isset($_GET['markasread'])) {
    messages_update_read($tid, $last_pid, bh_session_get_value('UID'));
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr valign=\"top\">\n";
echo "    <td width=\"33%\"><p><img src=\"". style_image('reply_all.png') ."\" alt=\"{$lang['replyall']}\" title=\"{$lang['replyall']}\" border=\"0\" /> <a href=\"post.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\"><b>{$lang['replyall']}</b></a></p></td>\n";

echo "    <td width=\"33%\" align=\"center\"><p>";
if (bh_session_get_value('UID') != 0) {
        echo "<img src=\"". style_image('thread_options.png') ."\" alt=\"{$lang['editthreadoptions']}\" title=\"{$lang['editthreadoptions']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['editthreadoptions']}</b></a>";
} else {
        echo "&nbsp;";
}
echo "</p></td>\n";

echo "    <td width=\"33%\" align=\"right\">";
if ($last_pid < $threaddata['LENGTH']) {
    $npid = $last_pid + 1;
    form_quick_button("./messages.php", "{$lang['keepreading']} &gt;&gt;", "msg", "$tid.$npid");
} else {
        echo "&nbsp;";
}
echo "    </td>\n";

echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

messages_start_panel();
messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $ppp);

if ($threaddata['POLL_FLAG'] == 'Y') {
    echo "<p><a href=\"javascript:void(0);\" target=\"_self\" onclick=\"window.open('poll_results.php?webtag=$webtag&amp;tid=", $tid, "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\">{$lang['viewresults']}</a></p>\n";
}

if (bh_session_get_value('UID') != 0) {

    messages_interest_form($tid,$pid);
    messages_fontsize_form($tid, $pid);
}

draw_beehive_bar();
messages_end_panel();
messages_forum_stats($tid, $pid);
html_draw_bottom();

?>