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

/* $Id: search.php,v 1.45 2003-09-15 18:34:48 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/search.inc.php");
require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/format.inc.php");
require_once("./include/user.inc.php");
require_once("./include/threads.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/config.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");

if (isset($HTTP_COOKIE_VARS['bh_thread_mode'])) {
    $mode = $HTTP_COOKIE_VARS['bh_thread_mode'];
}else{
    $mode = 0;
}

html_draw_top();

if (isset($HTTP_POST_VARS['submit'])) {
    $search_arguments = $HTTP_POST_VARS;
}elseif (isset($HTTP_GET_VARS['sstart'])) {
    $search_arguments = $HTTP_GET_VARS;
}else {

    echo "<h1>", $lang['searchmessages'], "</h1>\n";
    echo "<form method=\"post\" action=\"search.php\" target=\"left\">\n";
    echo form_input_hidden('sstart', '0'), "\n";
    echo "<table border=\"0\" width=\"550\" align=\"center\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\" colspan=\"2\">", $lang['searchdiscussions'], "...</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "    <td>", form_dropdown_array("method", range(1,3), array($lang['containingallwords'], $lang['containinganywords'], $lang['containingexactphrase']), 1). "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_input_text("search_string", "", 20), "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_submit("submit", $lang['find']), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "    <td class=\"postbody\">{$lang['wordsshorterthan_1']} ", (isset($search_min_word_length) ? $search_min_word_length : "3"), " {$lang['wordsshorterthan_2']}", ".</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td class=\"postbody\" colspan=\"2\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
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
    echo "    <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "    <td>", form_checkbox("me_only", "Y", $lang['onlyshowmessagestoorfromme'], false), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "    <td>", form_checkbox("group_by_thread", "Y", $lang['groupsresultsbythread'], false), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "    <td>", form_submit("submit", $lang['find']), "</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</form>\n";

    // html_draw_bottom();
    exit;
}

$urlquery = "";
$error = false;

echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\" colspan=\"2\">\n";
echo "      <img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"post.php\" target=\"main\">{$lang['newdiscussion']}</a><br />\n";
echo "      <img src=\"", style_image('poll.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"create_poll.php\" target=\"main\">{$lang['createpoll']}</a><br />\n";
echo "      <img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"search.php\" target=\"right\">{$lang['search']}</a><br />\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan=\"2\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan=\"2\">\n";
echo "      <form name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n";

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

    echo "<img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>{$lang['found']}: ", sizeof($search_results_array), " {$lang['matches']}<br />\n";

    if ($sstart >= 50) {
        echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"search.php?sstart=", $sstart - 50, $urlquery, "\">{$lang['prevpage']}</a>\n";
    }

    echo "<ol start=\"", $sstart + 1, "\">\n";

    foreach ($search_results_array as $search_result) {

        $message = messages_get($search_result['TID'], $search_result['PID']);
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

        echo "  <li><p><a href=\"messages.php?msg=", $search_result['TID'], ".", $search_result['PID'], "&amp;search_string=", rawurlencode(trim($search_string)), "\" target=\"right\"><b>", $message['TITLE'], "</b><br />";
        if (strlen($message['CONTENT']) > 0) echo wordwrap($message['CONTENT'], 25, '<br />', 1), "</a><br />";
        echo "<span class=\"smalltext\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>-<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>from ". format_user_name($message['FLOGON'], $message['FNICK']). ", ". format_time($message['CREATED'], 1). "</span></a></p></li>\n";
    }

    echo "</ol>\n";

    if (sizeof($search_results_array) == 50) {
        echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><a href=\"search.php?sstart=", $sstart + 50, $urlquery, "\">{$lang['findmore']}</a>\n";
    }

}else if ($error) {

    switch($error) {

        case SEARCH_USER_NOT_FOUND:
	    echo "<h2>{$lang['usernamenotfound']}</h2>\n";
	    break;
	case SEARCH_NO_KEYWORDS:
	    echo "<h2>{$lang['notexttosearchfor_1']} ", isset($search_min_word_length) ? $search_min_word_length : "3", " {$lang['notexttosearchfor_2']}.</h2>\n";
	    break;
	case SEARCH_NO_MATCHES:
	    echo "<img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"\" /><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>{$lang['found']}: 0 {$lang['matches']}<br />\n";
	    break;
    }
}

// html_draw_bottom();

?>