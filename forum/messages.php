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

/* $Id: messages.php,v 1.279 2008-08-21 20:46:15 decoyduck Exp $ */

/**
* Displays a thread and processes poll votes
*/

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

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
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

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
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

if (!forum_check_webtag_available()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// User UID for fetching recent message

$uid = bh_session_get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

}else if (!$msg = messages_get_most_recent($uid)) {

    html_draw_top();
    html_error_msg($lang['nomessages']);
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
    }

}elseif (isset($_POST['pollclose'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        if (isset($_POST['confirm_pollclose'])) {

            poll_close($tid);

        }else {

            html_draw_top("openprofile.js", "poll.js");
            poll_confirm_close($tid);
            html_draw_bottom();
            exit;
        }
    }

}elseif (isset($_POST['pollchangevote'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        poll_delete_vote($tid);
    }
}

if (($posts_per_page = bh_session_get_value('POSTS_PER_PAGE'))) {

    if ($posts_per_page < 10) $posts_per_page = 10;
    if ($posts_per_page > 30) $posts_per_page = 30;

}else {

    $posts_per_page = 20;
}

// Check the thread exists.

if (!$thread_data = thread_get($tid, bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Check it's in a folder we can view.

if (!$folder_data = folder_get($thread_data['FID'])) {

    html_draw_top();
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Get the messages.

if (!$messages = messages_get($tid, $pid, $posts_per_page)) {

    html_draw_top();
    html_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

$forum_name   = forum_get_setting('forum_name', false, 'A Beehive Forum');

$folder_title = _htmlentities($thread_data['FOLDER_TITLE']);

$thread_title = _htmlentities(thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']));

html_draw_top("onunload=clearFocus()", "title=$forum_name > $thread_title", "openprofile.js", "post.js", "poll.js", "htmltools.js", "folder_options.js", "basetarget=_blank", "onload=initialisePostQuoting()", "onload=registerQuickReplyHotKey()");

echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function initialisePostQuoting()\n";
echo "{\n";
echo "    var form_obj = getObjsByName('quote_list')[0];\n\n";
echo "    if (typeof form_obj == 'object') {\n";
echo "        form_obj.value = '';\n";
echo "    }\n";
echo "}\n\n";
echo "function togglePostQuoting(post_id)\n";
echo "{\n";
echo "    var form_obj = getObjsByName('quote_list')[0];\n";
echo "    var post_img = getObjsByName('p' + post_id)[0];\n\n";
echo "    var post_quotelink = getObjsByName('q' + post_id)[0];\n\n";
echo "    if ((typeof form_obj == 'object') && (typeof post_img == 'object')) {\n\n";
echo "        if (form_obj.value.length > 0) {\n\n";
echo "            var quote_list = form_obj.value.split(',');\n\n";
echo "            for (var check_post_id in quote_list) {\n\n";
echo "                if (quote_list[check_post_id] == post_id) {\n\n";
echo "                    quote_list.splice(check_post_id, 1);\n";
echo "                    form_obj.value = quote_list.join(',');\n";
echo "                    post_img.src = '", style_image('quote_disabled.png'), "';\n";
echo "                    post_quotelink.innerHTML = '{$lang['quote']}';\n";
echo "                    return false;\n";
echo "                }\n";
echo "            }\n\n";
echo "            quote_list.push(post_id);\n";
echo "            post_img.src = '", style_image('quote_enabled.png'), "';\n";
echo "            post_quotelink.innerHTML = '{$lang['unquote']}';\n";
echo "            form_obj.value = quote_list.join(',');\n\n";
echo "        }else {\n\n";
echo "            post_img.src = '", style_image('quote_enabled.png'), "';\n";
echo "            post_quotelink.innerHTML = '{$lang['unquote']}';\n";
echo "            form_obj.value = post_id;\n";
echo "        }\n";
echo "    }\n";
echo "    return false;\n";
echo "}\n\n";
echo "function checkPostQuoting(replyto_id)\n";
echo "{\n";
echo "    var quote_list_obj = getObjsByName('quote_list')[0];\n\n";
echo "    if (typeof quote_list_obj == 'object') {\n\n";
echo "        var f_quote_obj = getObjsByName('f_quote')[0];\n";
echo "        var replyto_obj = getObjsByName('replyto')[0];\n\n";
echo "        if (typeof f_quote_obj == 'object' && typeof replyto_obj == 'object') {\n\n";
echo "            if (quote_list_obj.value.length > 0) {\n\n";
echo "                replyto_obj.value = replyto_id;\n";
echo "                f_quote_obj.submit();\n";
echo "                return false;\n";
echo "            }\n";
echo "        }\n";
echo "    }\n";
echo "}\n\n";
echo "//-->\n";
echo "</script>\n";

if (isset($thread_data['STICKY']) && isset($thread_data['STICKY_UNTIL'])) {

    if ($thread_data['STICKY'] == "Y" && $thread_data['STICKY_UNTIL'] != 0 && time() > $thread_data['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $thread_data['STICKY'] = "N";
    }
}

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

$page_prefs = bh_session_get_post_page_prefs();

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

        $highlight_pattern[$key] = "/($highlight_word)/iu";
        $highlight_replace[$key] = "<span class=\"highlight\">\\1</span>";
    }

    $thread_parts = preg_split('/([<|>])/u', $thread_title, -1, PREG_SPLIT_DELIM_CAPTURE);

    for ($i = 0; $i < sizeof($thread_parts); $i++) {

        if (!($i % 4)) {

            $thread_parts[$i] = preg_replace($highlight_pattern, $highlight_replace, $thread_parts[$i], 1);
        }
    }

    $thread_title = implode('', $thread_parts);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, $pid, $thread_data['FID'], $folder_title, $thread_title, $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y')), "</td>\n";

if ($thread_data['POLL_FLAG'] == 'Y' && $messages[0]['PID'] != 1) {

    if (($userpollvote = poll_get_user_vote($tid))) {

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

if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {
    if ($_GET['markasread'] > 0) {
        html_display_success_msg($lang['threareadstatusupdated'], '96%', 'center');
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

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "var font_resize_success_container = getObjById('font_resize_success');\n\n";
    echo "if (typeof font_resize_success_container == 'object') {\n\n";
    echo "    font_resize_success_container.innerHTML = '", html_display_success_msg_js(sprintf($lang['fontsizechanged'], ''), '96%', 'center'), "';\n\n";
    echo "}\n\n";
    echo "-->\n";
    echo "</script>\n\n";
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
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('quote_list', ''), "\n";
echo "  ", form_input_hidden('replyto', ''), "\n";
echo "</form>\n";

echo "<div id=\"quick_reply_container\" class=\"quick_reply_container_closed\">\n";
echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"quick_reply_form\" action=\"post.php\" method=\"post\" target=\"_parent\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('t_tid', _htmlentities($tid)), "\n";
echo "  ", form_input_hidden('t_rpid', '0'), "\n";

$quick_reply_tools = new TextAreaHTML('quick_reply_form');

echo $quick_reply_tools->preload();

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        ", html_display_warning_msg($lang['pressctrlentertoquicklysubmityourpost'], '100%', 'center');
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">\n";
echo "                    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['quickreply']}</td>\n";
echo "                        <td align=\"right\"><span id=\"quick_reply_header\"></span>&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("post", $lang['post'], "onclick=\"return validateQuickReply()\""), "&nbsp;", form_submit("more", $lang['more']), "&nbsp;", form_button("cancel", $lang['cancel'], "onclick=\"hideQuickReply()\""), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

echo $quick_reply_tools->js();

echo "</div>\n";

if ($msg_count > 0) {

    $first_msg = $messages[0]['PID'];

    foreach ($messages as $message) {

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

            poll_display($tid, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, true, false, $highlight_array);
            $last_pid = $message['PID'];

          }else {

            message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], true, true, $show_sigs, false, $highlight_array);
            $last_pid = $message['PID'];

          }

        }else {

          message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], true, false, $show_sigs, false, $highlight_array);
          $last_pid = $message['PID'];

        }
    }
}

if ($msg_count > 0 && !user_is_guest() && !isset($_GET['markasread'])) {
    messages_update_read($tid, $last_pid, $thread_data['LAST_READ'], $thread_data['LENGTH'], $thread_data['MODIFIED']);
}

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";

if (($thread_data['CLOSED'] == 0 && bh_session_check_perm(USER_PERM_POST_CREATE, $thread_data['FID'])) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $thread_data['FID'])) {

    echo "    <td width=\"33%\" align=\"left\" nowrap=\"nowrap\"><img src=\"". style_image('reply_all.png') ."\" alt=\"{$lang['replyall']}\" title=\"{$lang['replyall']}\" border=\"0\" /> <a href=\"post.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\" onclick=\"return checkPostQuoting('$tid.0')\"><b>{$lang['replyall']}</b></a></td>\n";

}else {

    echo "    <td width=\"33%\" align=\"left\">&nbsp;</td>\n";
}

if (!user_is_guest()) {

    if ($thread_data['LENGTH'] > 0) {

        echo "    <td width=\"33%\" align=\"center\" nowrap=\"nowrap\"><img src=\"". style_image('thread_options.png') ."\" alt=\"{$lang['editthreadoptions']}\" title=\"{$lang['editthreadoptions']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['editthreadoptions']}</b></a></td>\n";

    }else {

        echo "    <td width=\"33%\" align=\"center\" nowrap=\"nowrap\"><img src=\"". style_image('thread_options.png') ."\" alt=\"{$lang['undeletethread']}\" title=\"{$lang['undeletethread']}\" border=\"0\" /> <a href=\"thread_options.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\"><b>{$lang['undeletethread']}</b></a></td>\n";
    }

}else {

    echo "    <td width=\"33%\" align=\"center\">&nbsp;</td>\n";
}

if ($last_pid < $thread_data['LENGTH']) {

    $next_pid = $last_pid + 1;

    echo "    <td width=\"33%\" align=\"right\" nowrap=\"nowrap\">", form_quick_button("messages.php", "{$lang['keepreading']}  &raquo;", array('msg' => "$tid.$next_pid")), "</td>\n";

}else {

    echo "    <td width=\"33%\" align=\"center\">&nbsp;</td>\n";
}

echo "  </tr>\n";

if (!user_is_guest()) {

    echo "  <tr>\n";
    echo "    <td colspan=\"3\" align=\"center\"><img src=\"". style_image('star.png') ."\" alt=\"{$lang['quickreplyall']}\" title=\"{$lang['quickreplyall']}\" border=\"0\" /> <a href=\"javascript:void(0)\" target=\"_self\" onclick=\"toggleQuickReply($tid, 0)\"><b>{$lang['quickreplyall']}</b></a></td>\n";
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