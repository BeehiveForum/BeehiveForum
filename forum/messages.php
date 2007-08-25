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

/* $Id: messages.php,v 1.233 2007-08-25 20:38:49 decoyduck Exp $ */

/**
* Displays a thread and processes poll votes
*/

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "rss_feed.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
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

@list($tid, $pid) = explode('.', $msg);

if (!isset($tid) || !is_numeric($tid)) $tid = 1;
if (!isset($pid) || !is_numeric($pid)) $pid = 1;

// Poll stuff

if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['pollvote'])) {

        if (poll_check_tabular_votes($_POST['tid'], $_POST['pollvote'])) {

            poll_vote($_POST['tid'], $_POST['pollvote']);
            $user_poll_votes = implode(",", $_POST['pollvote']);
            header_redirect("./messages.php?webtag=$webtag&user_poll_votes=$user_poll_votes&msg=". $_POST['tid']. ".1");

        }else {

            html_draw_top();
            html_error_msg($lang['mustvoteforallgroups'], 'messages.php', 'get', array('back' => $lang['back']), array('msg' => $msg));
            html_draw_bottom();
            exit;
        }

    }else {

        html_draw_top();
        html_error_msg($lang['mustselectpolloption'], 'messages.php', 'get', array('back' => $lang['back']), array('msg' => $msg));
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['pollclose'])) {

    if (isset($_POST['confirm_pollclose'])) {

        poll_close($_POST['tid']);
        header_redirect("./messages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");

    }else {

        html_draw_top("openprofile.js", "poll.js");
        poll_confirm_close($_POST['tid']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['pollchangevote'])) {

    poll_delete_vote($_POST['tid']);
    header_redirect("./messages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");
}

if ($posts_per_page = bh_session_get_value('POSTS_PER_PAGE')) {

    if ($posts_per_page < 10) $posts_per_page = 10;
    if ($posts_per_page > 30) $posts_per_page = 30;

}else {

    $posts_per_page = 20;
}

if (!$messages = messages_get($tid, $pid, $posts_per_page)) {

    html_draw_top();
    html_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid, bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

$forum_name   = forum_get_setting('forum_name', false, 'A Beehive Forum');
$thread_title = thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']);

html_draw_top("title=$forum_name > $thread_title", "openprofile.js", "post.js", "poll.js", "basetarget=_blank", "robots=index,follow", "onload=initialisePostQuoting()");

echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function initialisePostQuoting()\n";
echo "{\n";
echo "    var form_obj = getObjByName('quote_list');\n";
echo "    form_obj.value = '';\n";
echo "}\n\n";
echo "function togglePostQuoting(post_id)\n";
echo "{\n";
echo "    var form_obj = getObjByName('quote_list');\n";
echo "    var post_img = getObjByName('p' + post_id);\n";
echo "    if (form_obj.value.length > 0) {\n";
echo "        var quote_list = form_obj.value.split(',');\n";
echo "        for (var check_post_id in quote_list) {\n";
echo "            if (quote_list[check_post_id] == post_id) {\n";
echo "                quote_list.splice(check_post_id, 1);\n";
echo "                form_obj.value = quote_list.join(',');\n";
echo "                post_img.src = '", style_image('quote_disabled.png'), "';\n";
echo "                return false;\n";
echo "            }\n";
echo "        }\n";
echo "        quote_list.push(post_id);\n";
echo "        post_img.src = '", style_image('quote_enabled.png'), "';\n";
echo "        form_obj.value = quote_list.join(',');\n";
echo "    }else {\n";
echo "        post_img.src = '", style_image('quote_enabled.png'), "';\n";
echo "        form_obj.value = post_id;\n";
echo "    }\n";
echo "    return false;\n";
echo "}\n\n";
echo "function checkPostQuoting(replyto_id)\n";
echo "{\n";
echo "    var form_obj = getObjByName('quote_list');\n";
echo "    if (form_obj.value.length > 0) {\n";
echo "        var f_quote = getObjByName('f_quote');\n";
echo "        var replyto = getObjByName('replyto');\n";
echo "        replyto.value = replyto_id;\n";
echo "        f_quote.submit();\n";
echo "        return false;\n";
echo "    }\n";
echo "}\n";
echo "//-->\n";
echo "</script>\n";

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

if (isset($_GET['highlight'])) {
    $highlight_array = search_get_keywords();
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
echo "    <td align=\"left\">", messages_top($foldertitle, $threaddata['PREFIX'], $threaddata['TITLE'], $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK'], ($threaddata['LENGTH'] < 1)), "</td>\n";

if ($threaddata['POLL_FLAG'] == 'Y' && $messages[0]['PID'] != 1) {

    if ($userpollvote = poll_get_user_vote($tid)) {

        for ($i = 0; $i < sizeof($userpollvote); $i++) {
            $userpollvotes_array[] = $userpollvote[$i]['OPTION_ID'];
        }

        if (sizeof($userpollvotes_array) > 1) {
            echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoptions']}: ", implode(", ", $userpollvotes_array), "</td>\n";
        }else {
            echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoption']} #", implode(", ", $userpollvotes_array), "</td>\n";
        }

    }else {

        echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktovote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youhavenotvoted']}</td>\n";
    }
}

echo "  </tr>\n";
echo "</table>\n";

if (isset($_GET['markasread'])) {
    html_display_success_msg($lang['threareadstatusupdated'], '96%', 'center');
}

if (isset($_GET['setinterest'])) {
    html_display_success_msg($lang['interestupdated'], '96%', 'center');
}

if (isset($_GET['relupdated'])) {
    html_display_success_msg($lang['relationshipsupdated'], '96%', 'center');
}

if ($tracking_data_array = thread_get_tracking_data($tid)) {

    echo "<table class=\"thread_track_notice\" width=\"96%\">\n";

    foreach ($tracking_data_array as $tracking_data) {

        if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_MERGE) { // Thread merged

            if ($tracking_data['TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], $lang['threadmovedhere']);

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf($lang['thisthreadhasmoved'], $thread_link), "</td>\n";
                echo "  </tr>\n";
            }

            if ($tracking_data['NEW_TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['TID'], $lang['threadmovedhere']);

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf($lang['thisthreadwasmergedfrom'], $thread_link), "</td>\n";
                echo "  </tr>\n";
            }

        }elseif ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_SPLIT) { // Thread Split

            if ($tracking_data['TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], $lang['threadmovedhere']);

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf($lang['somepostsinthisthreadhavebeenmoved'], $thread_link), "</td>\n";
                echo "  </tr>\n";
            }

            if ($tracking_data['NEW_TID'] == $tid) {

                $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                $thread_link = sprintf($thread_link, $tracking_data['TID'], $lang['threadmovedhere']);

                echo "  <tr>\n";
                echo "    <td align=\"left\">", sprintf($lang['somepostsinthisthreadweremovedfrom'], $thread_link), "</td>\n";
                echo "  </tr>\n";
            }
        }
    }

    echo "</table>\n";
}

echo "</div>\n";
echo "<form name=\"f_quote\" action=\"post.php\" method=\"get\" target=\"_parent\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('quote_list', ''), "\n";
echo "  ", form_input_hidden('replyto', ''), "\n";
echo "</form>\n";

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

            poll_display($tid, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, true, true, false, $highlight_array);
            $last_pid = $message['PID'];

          }else {

            message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], true, true, $show_sigs, false, $highlight_array);
            $last_pid = $message['PID'];

          }

        }else {

          message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], true, false, $show_sigs, false, $highlight_array);
          $last_pid = $message['PID'];

        }
    }
}

if ($msg_count > 0 && !user_is_guest() && !isset($_GET['markasread'])) {
    messages_update_read($tid, $pid, $threaddata['LAST_READ'], $threaddata['LENGTH'], $threaddata['MODIFIED']);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr valign=\"top\">\n";

if (($threaddata['CLOSED'] == 0 && bh_session_check_perm(USER_PERM_POST_CREATE, $threaddata['FID'])) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $threaddata['FID'])) {
    echo "    <td width=\"33%\" align=\"left\"><p><img src=\"". style_image('reply_all.png') ."\" alt=\"{$lang['replyall']}\" title=\"{$lang['replyall']}\" border=\"0\" /> <a href=\"post.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\" onclick=\"return checkPostQuoting('$tid.0')\"><b>{$lang['replyall']}</b></a></p></td>\n";
} else {
    echo "    <td width=\"33%\" align=\"left\">&nbsp;</td>\n";
}

echo "    <td width=\"33%\" align=\"center\"><p>";

if (!user_is_guest()) {

    if ($threaddata['LENGTH'] > 0) {
        echo "<img src=\"". style_image('thread_options.png') ."\" alt=\"{$lang['editthreadoptions']}\" title=\"{$lang['editthreadoptions']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['editthreadoptions']}</b></a>";
    }else {
        echo "<img src=\"". style_image('thread_options.png') ."\" alt=\"{$lang['undeletethread']}\" title=\"{$lang['undeletethread']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['undeletethread']}</b></a>";
    }

}else {

    echo "&nbsp;";
}

echo "</p></td>\n";

echo "    <td width=\"33%\" align=\"right\">";

if ($last_pid < $threaddata['LENGTH']) {

    $npid = $last_pid + 1;
    echo form_quick_button("./messages.php", "{$lang['keepreading']}  &raquo;", array('msg' => "$tid.$npid"));

}else {

    echo "&nbsp;";
}

echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

messages_start_panel();

messages_nav_strip($tid, $pid, $threaddata['LENGTH'], $posts_per_page);

if ($threaddata['POLL_FLAG'] == 'Y') {

    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"center\">\n";
    echo "                  <a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" target=\"_blank\" onclick=\"return openPollResults('$tid', '$webtag')\">{$lang['viewresults']}</a>\n";
    echo "                </td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "            <br />\n";
}

messages_interest_form($tid, $pid);

messages_fontsize_form($tid, $pid);

draw_beehive_bar();

messages_end_panel();

messages_forum_stats($tid, $pid);

html_draw_bottom();

?>