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

/* $Id: search.php,v 1.75 2004-04-23 22:11:38 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/search.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/threads.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

if (isset($_COOKIE['bh_thread_mode'])) {
    $mode = $_COOKIE['bh_thread_mode'];
}else{
    $mode = 0;
}

html_draw_top();

if (isset($_POST['search_string'])) {
    $search_arguments = $_POST;
    $search_string = $_POST['search_string'];
}elseif (isset($_GET['sstart'])) {
    $search_arguments = $_GET;
    $search_string = $_GET['search_string'];
}else {
    echo "<h1>", $lang['searchmessages'], "</h1>\n";
    echo "<form method=\"post\" action=\"search.php?webtag=$webtag\" target=\"left\">\n";
    echo form_input_hidden('sstart', '0'), "\n";
    echo "<table border=\"0\" width=\"550\" align=\"center\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\" colspan=\"2\">", $lang['searchdiscussions'], "...</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td>", form_dropdown_array("method", range(1,3), array($lang['containingallwords'], $lang['containinganywords'], $lang['containingexactphrase']), 1). "&nbsp;", form_input_text("search_string", "", 20), "&nbsp;", form_submit("submit", $lang['find']), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td class=\"postbody\">{$lang['wordsshorterthan_1']} ", forum_get_setting('search_min_word_length', false, 3), " {$lang['wordsshorterthan_2']}", ".</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\" colspan=\"2\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\" colspan=\"2\">", $lang['additionalcriteria'], "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"right\" class=\"postbody\">", $lang['folderbrackets_s'], ":</td>\n";
    echo "    <td>", folder_search_dropdown(), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"right\" class=\"postbody\">", $lang['to'], ":</td>\n";
    echo "    <td class=\"postbody\">", search_draw_user_dropdown("to_uid"), " or ", form_input_text("to_other", "", 20), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"right\" class=\"postbody\">", $lang['from'], ":</td>\n";
    echo "    <td class=\"postbody\">", search_draw_user_dropdown("from_uid"), " or ", form_input_text("from_other", "", 20), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"right\" class=\"postbody\">", $lang['postedfrom'], ":</td>\n";
    echo "    <td>", form_dropdown_array("date_from", range(1, 12), array($lang['today'], $lang['yesterday'], $lang['daybeforeyesterday'], "1 {$lang['weekago']}", "2 {$lang['weeksago']}", "3 {$lang['weeksago']}", "1 {$lang['monthago']}", "2 {$lang['monthsago']}", "3 {$lang['monthsago']}", "6 {$lang['monthsago']}", "1 {$lang['yearago']}", $lang['beginningoftime']), 7), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"right\" class=\"postbody\">", $lang['postedto'], ":</td>\n";
    echo "    <td>", form_dropdown_array("date_to", range(1, 12), array($lang['now'], $lang['today'], $lang['yesterday'], $lang['daybeforeyesterday'], "1 {$lang['weekago']}", "2 {$lang['weeksago']}", "3 {$lang['weeksago']}", "1 {$lang['monthago']}", "2 {$lang['monthsago']}", "3 {$lang['monthsago']}", "6 {$lang['monthsago']}", "1 {$lang['yearago']}"), 2), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"right\" class=\"postbody\">Order by:</td>\n";
    echo "    <td>", form_dropdown_array("order_by", range(1, 3), array($lang['relevance'], $lang['newestfirst'], $lang['oldestfirst']), 1), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td>", form_checkbox("me_only", "Y", $lang['onlyshowmessagestoorfromme'], false), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td>", form_checkbox("group_by_thread", "Y", $lang['groupsresultsbythread'], false), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td>", form_submit("submit", $lang['find']), "</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</form>\n";

    html_draw_bottom();
    exit;
}

$urlquery = "";
$error = false;

echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\" colspan=\"2\">\n";
echo "      <img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"post.php?webtag=$webtag\" target=\"main\">{$lang['newdiscussion']}</a><br />\n";
echo "      <img src=\"", style_image('poll.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"create_poll.php?webtag=$webtag\" target=\"main\">{$lang['createpoll']}</a><br />\n";

if ($pm_new_count = pm_new_check(false)) {
    echo "      <img src=\"", style_image('pmunread.png'), "\" height=\"16\" alt=\"\" />&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"main\">{$lang['pminbox']}</a> <span class=\"adminipdisplay\">[$pm_new_count {$lang['new']}]</span><br />\n";
}else {
    echo "      <img src=\"", style_image('pmread.png'), "\" height=\"16\" alt=\"\" />&nbsp;<a href=\"pm.php?webtag=$webtag\" target=\"main\">{$lang['pminbox']}</a><br />\n";
}

echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan=\"2\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan=\"2\">\n";
echo "      <form name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n";
echo "        ", form_input_hidden("webtag", $webtag), "\n";

if (bh_session_get_value('UID') == 0) {

    $labels = array($lang['alldiscussions'], $lang['todaysdiscussions'], $lang['2daysback'], $lang['7daysback']);
    echo form_dropdown_array("mode", array(0, 3, 4, 5), $labels, $mode, "onchange=\"submit()\""). "\n";

}else {

    $labels = array($lang['alldiscussions'],$lang['unreaddiscussions'],$lang['unreadtome'],$lang['todaysdiscussions'],
                    $lang['2daysback'],$lang['7daysback'],$lang['highinterest'],$lang['unreadhighinterest'],
                    $lang['iverecentlyseen'],$lang['iveignored'],$lang['ivesubscribedto'],$lang['startedbyfriend'],
                    $lang['unreadstartedbyfriend']);

    echo form_dropdown_array("mode", range(0, 12), $labels, $mode, "onchange=\"submit()\""), "\n";
}

echo form_submit("go", $lang['goexcmark']), "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo "<h1>{$lang['searchresults']}</h1>\n";

if ($search_results_array = search_execute($search_arguments, $urlquery, $error)) {

    if (isset($search_arguments['sstart'])) {
        $sstart = $search_arguments['sstart'];
    }else {
        $sstart = 0;
    }

    echo "<img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"\" />&nbsp;{$lang['found']}: ", sizeof($search_results_array), " {$lang['matches']}<br />\n";

    if ($sstart >= 50) {
        echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"search.php?webtag=$webtag&sstart=", $sstart - 50, $urlquery, "\">{$lang['prevpage']}</a>\n";
    }

    echo "<ol start=\"", $sstart + 1, "\">\n";

    foreach ($search_results_array as $search_result) {

        $message = messages_get($search_result['TID'], $search_result['PID']);
        $message['CONTENT'] = message_get_content($search_result['TID'], $search_result['PID']);

        $threaddata = thread_get($search_result['TID']);

        if (thread_is_poll($search_result['TID'])) {

            $message['TITLE']   = trim(strip_tags(_stripslashes($threaddata['TITLE'])));
            $message['CONTENT'] = '';

        }else {

            $message['TITLE']   = trim(strip_tags(_stripslashes($threaddata['TITLE'])));
            $message['CONTENT'] = trim(strip_tags(message_get_content($search_result['TID'], $search_result['PID'])));

        }

        // trunicate the search result at the last space in the first 50 chars.

        if (strlen($message['TITLE']) > 20) {

            $message['TITLE'] = substr($message['TITLE'], 0, 20);

            if ($schar = strrpos($message['TITLE'], ' ')) {
                $message['TITLE'] = substr($message['TITLE'], 0, $schar);
            }else {
                $message['TITLE'] = substr($message['TITLE'], 0, 17). "...";
            }

        }

        if (strlen($message['CONTENT']) > 35) {

            $message['CONTENT'] = substr($message['CONTENT'], 0, 35);

            if ($schar = strrpos($message['CONTENT'], ' ')) {
                $message['CONTENT'] = substr($message['CONTENT'], 0, $schar);
            }else {
                $message['CONTENT'] = substr($message['CONTENT'], 0, 32). "...";
            }

        }

        echo "  <li><p><a href=\"messages.php?webtag=$webtag&msg=", $search_result['TID'], ".", $search_result['PID'], "&amp;search_string=", rawurlencode(trim($search_string)), "\" target=\"right\"><b>", $message['TITLE'], "</b><br />";
        if (strlen($message['CONTENT']) > 0) echo wordwrap($message['CONTENT'], 25, '<br />', 1), "</a><br />";
        echo "<span class=\"smalltext\">&nbsp;-&nbsp;from ". format_user_name($message['FLOGON'], $message['FNICK']). ", ". format_time($message['CREATED'], 1). "</span></a></p></li>\n";
    }

    echo "</ol>\n";

    if (sizeof($search_results_array) == 50) {
        echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\">&nbsp;<a href=\"search.php?webtag=$webtag&sstart=", $sstart + 50, $urlquery, "\">{$lang['findmore']}</a>\n";
    }

}else if ($error) {

    switch($error) {

        case SEARCH_USER_NOT_FOUND:
	    echo "<h2>{$lang['usernamenotfound']}</h2>\n";
	    break;
	case SEARCH_NO_KEYWORDS:
	    echo "<h2>{$lang['notexttosearchfor_1']} ", forum_get_setting('search_min_word_length', false, 3), " {$lang['notexttosearchfor_2']}.</h2>\n";
	    break;
	case SEARCH_NO_MATCHES:
	    echo "<img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"\" />&nbsp;{$lang['found']}: 0 {$lang['matches']}<br />\n";
	    break;
    }
}

echo "<p>&nbsp;</p>\n";
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "  <tr>\n";
echo "    <td class=\"smalltext\" colspan=\"2\">{$lang['navigate']}:</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "    <td class=\"smalltext\">\n";
echo "      <form name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"right\">\n";
echo "        ", form_input_hidden("webtag", $webtag), "\n";
echo "        ", form_input_text('msg', '1.1', 10). "\n";
echo "        ", form_submit("go",$lang['goexcmark']). "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "  <tr>\n";
echo "    <td class=\"smalltext\" colspan=\"2\">{$lang['searchagain']} (<a href=\"search.php?webtag=$webtag\" target=\"right\">{$lang['advanced']}</a>):</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "    <td class=\"smalltext\">\n";
echo "      <form method=\"post\" action=\"search.php?webtag=$webtag\" target=\"_self\">\n";
echo "        ", form_input_text("search_string", "", 20). "\n";
echo "        ", form_submit("submit", $lang['find']). "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>