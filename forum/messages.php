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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

include_once(BH_INCLUDE_PATH. "adsense.inc.php");
include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
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

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Message pane caching
cache_check_messages();

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// User UID for fetching recent message
$uid = session_get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

}else if (($msg = messages_get_most_recent($uid))) {

    list($tid, $pid) = explode('.', $msg);

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['invalidmsgidornomessageidspecified']);
    html_draw_bottom();
    exit;
}

// Poll stuff
if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        if (isset($_POST['pollvote']) && is_array($_POST['pollvote'])) {

            $poll_votes = $_POST['pollvote'];

            if (poll_check_tabular_votes($tid, $poll_votes)) {

                poll_vote($tid, $poll_votes);

            }else {

                html_draw_top("title={$lang['error']}");
                html_error_msg($lang['mustvoteforallgroups'], 'messages.php', 'get', array('back' => $lang['back']), array('msg' => $msg));
                html_draw_bottom();
                exit;
            }

        }else {

            html_draw_top("title={$lang['error']}");
            html_error_msg($lang['mustselectpolloption'], 'messages.php', 'get', array('back' => $lang['back']), array('msg' => $msg));
            html_draw_bottom();
            exit;
        }
    }

}elseif (isset($_POST['pollclose'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        if (isset($_POST['confirm_pollclose'])) {

            poll_close($tid);

        }else {

            html_draw_top("title={$lang['error']}");
            poll_confirm_close($tid);
            html_draw_bottom();
            exit;
        }
    }

}elseif (isset($_POST['pollchangevote'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        $pid = 1;

        poll_delete_vote($tid);
    }
}

if (($posts_per_page = session_get_value('POSTS_PER_PAGE'))) {

    if ($posts_per_page < 10) $posts_per_page = 10;
    if ($posts_per_page > 30) $posts_per_page = 30;

}else {

    $posts_per_page = 20;
}

// Check the thread exists.
if (!$thread_data = thread_get($tid, session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Check it's in a folder we can view.
if (!$folder_data = folder_get($thread_data['FID'])) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Get the messages.
if (!$messages = messages_get($tid, $pid, $posts_per_page)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

$thread_title = thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']);

html_draw_top("title=$thread_title", "class=window_title", "post.js", "htmltools.js", "basetarget=_blank");

if (isset($thread_data['STICKY']) && isset($thread_data['STICKY_UNTIL'])) {

    if ($thread_data['STICKY'] == "Y" && $thread_data['STICKY_UNTIL'] != 0 && time() > $thread_data['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $thread_data['STICKY'] = "N";
    }
}

$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

$page_prefs = session_get_post_page_prefs();

$msg_count = count($messages);

$highlight_array = array();

if (isset($_GET['highlight'])) {
    $highlight_array = search_get_keywords();
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, $pid, $thread_data['FID'], $folder_data['TITLE'], $thread_title, $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'), true, $highlight_array), "</td>\n";
echo "    <td align=\"right\">\n";

if ((forum_get_setting('show_share_links', 'Y')) && (session_get_value('SHOW_SHARE_LINKS') == 'Y')) {

    echo "      <div style=\"display: inline-block; vertical-align: middle; margin-top: 1px\">\n";
    echo "        <g:plusone size=\"small\" count=\"false\" href=\"",  htmlentities(html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.1")), "\"></g:plusone>\n";
    echo "      </div>\n";
    echo "      <div style=\"display: inline-block; width: 47px; vertical-align: middle; margin-top: 2px; overflow: hidden\">\n";
    echo "        <iframe src=\"http://www.facebook.com/plugins/like.php?href=", urlencode(html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.1")), "&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:21px;\" allowTransparency=\"true\"></iframe>\n";
    echo "      </div>\n";
    echo "      <div style=\"display: inline-block; width: 55px; vertical-align: middle; overflow: hidden\">\n";
    echo "        <a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"", htmlentities(html_get_forum_uri("/index.php?webtag=$webtag&msg=$tid.1")), "\" data-count=\"none\">Tweet</a>\n";
    echo "      </div>\n";

} else {

    echo "&nbsp;";
}

echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {
    if ($_GET['markasread'] > 0) {
        html_display_success_msg($lang['threadreadstatusupdated'], '96%', 'center');
    }else {
        html_display_error_msg($lang['failedtoupdatethreadreadstatus'], '96%', 'center');
    }
}

if (isset($_GET['setinterest'])) {
    if ($_GET['setinterest'] > 0) {
        html_display_success_msg($lang['interestupdated'], '96%', 'center');
    }else {
        html_display_error_msg($lang['failedtoupdatethreadinterest'], '96%', 'center');
    }
}

if (isset($_GET['relupdated'])) {

    html_display_success_msg($lang['relationshipsupdated'], '96%', 'center');

}else if (isset($_GET['setstats'])) {

    html_display_success_msg($lang['statsdisplaychanged'], '96%', 'center');

}else if (isset($_GET['edit_success']) && validate_msg($_GET['edit_success'])) {

    html_display_success_msg(sprintf($lang['successfullyeditedpost'], $_GET['edit_success']), '96%', 'center');

}else if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {

    html_display_success_msg(sprintf($lang['successfullydeletedpost'], $_GET['delete_success']), '96%', 'center');

}elseif (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {

    html_display_success_msg(sprintf($lang['successfullydeletedpost'], $_GET['delete_success']), '96%', 'center');

}else if (isset($_GET['post_approve_success']) && validate_msg($_GET['post_approve_success'])) {

    html_display_success_msg(sprintf($lang['successfullyapprovedpost'], $_GET['post_approve_success']), '96%', 'center');
}

if (isset($_GET['font_resize'])) {

    echo "<div id=\"font_resize_success\">\n";
    html_display_success_msg(sprintf($lang['fontsizechanged'], $lang['framesmustbereloaded']), '96%', 'center');
    echo "</div>\n";
}

if (($tracking_data_array = thread_get_tracking_data($tid))) {

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
echo "<form accept-charset=\"utf-8\" name=\"f_quote\" action=\"post.php\" method=\"get\" target=\"_parent\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('quote_list', ''), "\n";
echo "  ", form_input_hidden('replyto', ''), "\n";
echo "</form>\n";

echo "<div id=\"quick_reply_container\" class=\"quick_reply_container_closed\">\n";
echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"quick_reply_form\" action=\"post.php\" method=\"post\" target=\"_parent\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('t_tid', htmlentities_array($tid)), "\n";
echo "  ", form_input_hidden('t_rpid', '0'), "\n";

$quick_reply_tools = new TextAreaHTML('quick_reply_form');

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        ", html_display_warning_msg($lang['pressctrlentertoquicklysubmityourpost'], '100%', 'center');
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table cellspacing=\"0\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"subhead\">{$lang['quickreply']}</td>\n";
echo "                        <td align=\"right\" class=\"subhead\"><span id=\"quick_reply_header\"></span>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if (($page_prefs & POST_TOOLBAR_DISPLAY) && ($page_prefs & POST_AUTOHTML_DEFAULT)) {

    echo "                      <tr>\n";
    echo "                        <td align=\"center\">", $quick_reply_tools->toolbar_reduced($page_prefs & POST_EMOTICONS_DISPLAY), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"center\">", $quick_reply_tools->textarea("t_content", "", 7, 75), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("post", $lang['post']), "&nbsp;", form_submit("more", $lang['more']), "&nbsp;", form_button("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

if ($msg_count > 0) {

    $first_msg = $messages[0]['PID'];

    foreach ($messages as $message_number => $message) {

        if (isset($message['RELATIONSHIP'])) {

            if ($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                $message['CONTENT'] = message_get_content($tid, $message['PID']);
            }else {
                $message['CONTENT'] = $lang['ignored']; // must be set to something or will show as deleted
            }

        }else {

          $message['CONTENT'] = message_get_content($tid, $message['PID']);

        }

        if ($thread_data['POLL_FLAG'] == 'Y') {

          if ($message['PID'] == 1) {

            poll_display($tid, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], $thread_data['CLOSED'], false, $show_sigs, false, $highlight_array);
            $last_pid = $message['PID'];

          }else {

            message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], true, true, $show_sigs, false, $highlight_array);
            $last_pid = $message['PID'];

          }

        }else {

          message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], true, false, $show_sigs, false, $highlight_array);
          $last_pid = $message['PID'];

        }

        if (adsense_check_user() && adsense_check_page($message_number, $posts_per_page, $thread_data['LENGTH'])) {

            echo "<br />\n";
            adsense_output_html();
        }
    }
}

if ($msg_count > 0 && !user_is_guest() && !isset($_GET['markasread'])) {
    messages_update_read($tid, $last_pid, $thread_data['LAST_READ'], $thread_data['LENGTH'], $thread_data['MODIFIED']);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";

if (($thread_data['CLOSED'] == 0 && session_check_perm(USER_PERM_POST_CREATE, $thread_data['FID'])) || session_check_perm(USER_PERM_FOLDER_MODERATE, $thread_data['FID'])) {

    echo "    <td width=\"33%\" align=\"left\" nowrap=\"nowrap\" class=\"postbody\">";
    echo "      <img src=\"". html_style_image('reply_all.png') ."\" alt=\"{$lang['replyall']}\" title=\"{$lang['replyall']}\" border=\"0\" /> ";
    echo "      <a href=\"post.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\" id=\"reply_0\"><b>{$lang['replyall']}</b></a>\n";
    echo "    </td>\n";

}else {

    echo "    <td width=\"33%\" align=\"left\" class=\"postbody\">&nbsp;</td>\n";
}

if (!user_is_guest()) {

    if ($thread_data['LENGTH'] > 0) {

        echo "    <td width=\"33%\" align=\"center\" nowrap=\"nowrap\" class=\"postbody\"><img src=\"". html_style_image('thread_options.png') ."\" alt=\"{$lang['editthreadoptions']}\" title=\"{$lang['editthreadoptions']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['editthreadoptions']}</b></a></td>\n";

    }else {

        echo "    <td width=\"33%\" align=\"center\" nowrap=\"nowrap\" class=\"postbody\"><img src=\"". html_style_image('thread_options.png') ."\" alt=\"{$lang['undeletethread']}\" title=\"{$lang['undeletethread']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['undeletethread']}</b></a></td>\n";
    }

}else {

    echo "    <td width=\"33%\" align=\"center\" class=\"postbody\">&nbsp;</td>\n";
}

if ($last_pid < $thread_data['LENGTH']) {

    $next_pid = $last_pid + 1;

    echo "    <td width=\"33%\" align=\"right\" nowrap=\"nowrap\" class=\"postbody\">", form_quick_button("messages.php", $lang['keepreadingdotdotdot'], array('msg' => "$tid.$next_pid")), "</td>\n";

}else {

    echo "    <td width=\"33%\" align=\"center\" class=\"postbody\">&nbsp;</td>\n";
}

echo "  </tr>\n";

if (!user_is_guest()) {

    echo "  <tr>\n";
    echo "    <td colspan=\"3\" align=\"center\" class=\"postbody\"><img src=\"". html_style_image('quickreplyall.png') ."\" alt=\"{$lang['quickreplyall']}\" title=\"{$lang['quickreplyall']}\" border=\"0\" /> <a href=\"javascript:void(0)\" target=\"_self\" rel=\"$tid.0\" class=\"quick_reply_link\"><b>{$lang['quickreplyall']}</b></a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td colspan=\"3\">\n";
    echo "      <div align=\"center\">\n";
    echo "        <div id=\"quick_reply_0\"></div>\n";
    echo "      </div>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

messages_start_panel();

messages_nav_strip($tid, $pid, $thread_data['LENGTH'], $posts_per_page);

if ($thread_data['POLL_FLAG'] == 'Y') {

    echo "            <table class=\"posthead\" width=\"100%\">\n";
    echo "              <tr>\n";
    echo "                <td align=\"center\">\n";
    echo "                  <a href=\"poll_results.php?webtag=$webtag&amp;tid=$tid\" target=\"_blank\" class=\"popup 800x600\">{$lang['viewresults']}</a>\n";
    echo "                </td>\n";
    echo "              </tr>\n";
    echo "            </table>\n";
    echo "            <br />\n";
}

messages_interest_form($tid, $pid, $thread_data['INTEREST']);

messages_fontsize_form($tid, $pid);

draw_beehive_bar();

messages_end_panel();

messages_forum_stats($tid, $pid);

html_draw_bottom();

?>
