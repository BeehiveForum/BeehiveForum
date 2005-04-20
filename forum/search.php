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

/* $Id: search.php,v 1.114 2005-04-20 18:42:26 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

if (isset($_COOKIE['bh_thread_mode'])) {
    $mode = $_COOKIE['bh_thread_mode'];
}else{
    $mode = 0;
}

if (!$folder_dropdown = folder_search_dropdown()) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['couldnotretrievefolderinformation']}</h2>\n";
    html_draw_bottom();
    exit;
}

html_draw_top("robots=noindex,nofollow");

$search_arguments = array();

if (isset($_POST['search_string'])) {
    $search_arguments['search_string'] = $_POST['search_string'];
}else if (isset($_GET['search_string'])) {
    $search_arguments['search_string'] = $_GET['search_string'];
}

if (isset($_POST['method']) && is_numeric($_POST['method'])) {
    $search_arguments['method'] = $_POST['method'];
}else if (isset($_GET['method']) && is_numeric($_GET['method'])) {
    $search_arguments['method'] = $_GET['method'];
}

if (isset($_POST['username']) && strlen(trim($_POST['username'])) > 0) {
    $search_arguments['username'] = $_POST['username'];
}else if (isset($_GET['username']) && strlen(trim($_GET['username'])) > 0) {
    $search_arguments['username'] = $_GET['username'];
}

if (isset($_POST['user_include']) && is_numeric($_POST['user_include'])) {
    $search_arguments['user_include'] = $_POST['user_include'];
}else if (isset($_GET['user_include']) && is_numeric($_GET['user_include'])) {
    $search_arguments['user_include'] = $_GET['user_include'];
}

if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
    $search_arguments['fid'] = $_POST['fid'];
}else if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $search_arguments['fid'] = $_GET['fid'];
}

if (isset($_POST['date_from']) && is_numeric($_POST['date_from'])) {
    $search_arguments['date_from'] = $_POST['date_from'];
}else if (isset($_GET['date_from']) && is_numeric($_GET['date_from'])) {
    $search_arguments['date_from'] = $_GET['date_from'];
}

if (isset($_POST['date_to']) && is_numeric($_POST['date_to'])) {
    $search_arguments['date_to'] = $_POST['date_to'];
}else if (isset($_GET['date_to']) && is_numeric($_GET['date_to'])) {
    $search_arguments['date_to'] = $_GET['date_to'];
}

if (isset($_POST['order_by']) && is_numeric($_POST['order_by'])) {
    $search_arguments['order_by'] = $_POST['order_by'];
}else if (isset($_GET['order_by']) && is_numeric($_GET['order_by'])) {
    $search_arguments['order_by'] = $_GET['order_by'];
}

if (isset($_POST['group_by_thread']) && strlen(trim($_POST['group_by_thread'])) > 0) {
    $search_arguments['group_by_thread'] = $_POST['group_by_thread'];
}else if (isset($_GET['group_by_thread']) && strlen(trim($_GET['group_by_thread'])) > 0) {
    $search_arguments['group_by_thread'] = $_GET['group_by_thread'];
}

if (isset($_POST['sstart']) && is_numeric($_POST['sstart'])) {
    $search_arguments['sstart'] = $_POST['sstart'];
}else if (isset($_GET['sstart']) && is_numeric($_GET['sstart'])) {
    $search_arguments['sstart'] = $_GET['sstart'];
}

if (isset($_POST['sstart']) && is_numeric($_POST['sstart'])) {
    $search_arguments['sstart'] = $_POST['sstart'];
}else if (isset($_GET['sstart']) && is_numeric($_GET['sstart'])) {
    $search_arguments['sstart'] = $_GET['sstart'];
}

if (!isset($search_arguments) || sizeof($search_arguments) < 1) {

    echo "<h1>{$lang['searchmessages']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form id=\"search_form\" method=\"post\" action=\"search.php\" target=\"left\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('sstart', '0'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\" class=\"subhead\">&nbsp;{$lang['searchdiscussions']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"40%\">&nbsp;{$lang['keywords']}:</td>\n";
    echo "                  <td>", form_input_text("search_string", "", 32), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"40%\">&nbsp;</td>\n";
    echo "                  <td>", form_dropdown_array("method", range(1, 2), array($lang['containingallwords'], $lang['containinganywords']), 1), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\" class=\"subhead\">&nbsp;{$lang['searchbyuser']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"40%\">&nbsp;{$lang['username']}:</td>\n";
    echo "                  <td>", form_input_text("username", "", 32), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>", form_radio("user_include", 1, $lang['postsfromuser'], true), "&nbsp;", "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>", form_radio("user_include", 2, $lang['poststouser'], false), "&nbsp;", "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>", form_radio("user_include", 3, $lang['poststoandfromuser'], false), "&nbsp;", "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\" class=\"subhead\">&nbsp;{$lang['additionalcriteria']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"40%\">&nbsp;{$lang['folderbrackets_s']}:</td>\n";
    echo "                  <td>", $folder_dropdown, "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['postedfrom']}:</td>\n";
    echo "                  <td>", form_dropdown_array("date_from", range(1, 12), array($lang['today'], $lang['yesterday'], $lang['daybeforeyesterday'], "1 {$lang['weekago']}", "2 {$lang['weeksago']}", "3 {$lang['weeksago']}", "1 {$lang['monthago']}", "2 {$lang['monthsago']}", "3 {$lang['monthsago']}", "6 {$lang['monthsago']}", "1 {$lang['yearago']}", $lang['beginningoftime']), 7, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['postedto']}:</td>\n";
    echo "                  <td>", form_dropdown_array("date_to", range(1, 12), array($lang['now'], $lang['today'], $lang['yesterday'], $lang['daybeforeyesterday'], "1 {$lang['weekago']}", "2 {$lang['weeksago']}", "3 {$lang['weeksago']}", "1 {$lang['monthago']}", "2 {$lang['monthsago']}", "3 {$lang['monthsago']}", "6 {$lang['monthsago']}", "1 {$lang['yearago']}"), 2, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['orderby']}:</td>\n";
    echo "                  <td>", form_dropdown_array("order_by", range(1, 2), array($lang['newestfirst'], $lang['oldestfirst']), 1, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['groupbythread']}:</td>\n";
    echo "                  <td>", form_radio("group_by_thread", "Y", $lang['yes'], true), "&nbsp;", form_radio("group_by_thread", "Y", $lang['no'], false), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>{$lang['searchcriteria_1']} ", forum_get_setting('search_min_word_length', false, 3), " {$lang['searchcriteria_2']}</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_button("go", $lang['find'], "onclick=\"disable_button(this); submit_form('search_form')\""), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;
}

$urlquery = "";
$error = false;

// Draw discussion dropdown
thread_list_draw_top(0);

echo "</table>\n";

if ($search_results_array = search_execute($search_arguments, $urlquery, $error)) {

    if (isset($search_arguments['sstart']) && is_numeric($search_arguments['sstart'])) {
        $sstart = $search_arguments['sstart'];
    }else {
        $sstart = 0;
    }

    if (!isset($search_arguments['search_string'])) {
        $search_arguments['search_string'] = "";
    }

    echo "<h1>{$lang['searchresults']}</h1>\n";
    echo "<img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"{$lang['found']}\" title=\"{$lang['found']}\" />&nbsp;{$lang['found']}: {$search_results_array['match_count']} {$lang['matches']}<br />\n";

    if ($sstart >= 20) {
        echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"{$lang['prevpage']}\" title=\"{$lang['prevpage']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;sstart=", $sstart - 20, $urlquery, "\">{$lang['prevpage']}</a>\n";
    }

    echo "<ol start=\"", $sstart + 1, "\">\n";

    foreach ($search_results_array['match_array'] as $search_result) {

        $message = messages_get($search_result['TID'], $search_result['PID'], 1);
        $message['CONTENT'] = message_get_content($search_result['TID'], $search_result['PID']);

        $threaddata = thread_get($search_result['TID']);

        if (thread_is_poll($search_result['TID'])) {

            $message['TITLE']   = trim(strip_tags(_stripslashes($threaddata['TITLE'])));
            $message['CONTENT'] = '';

        }else {

            $message['TITLE']   = trim(strip_tags(_stripslashes($threaddata['TITLE'])));
            $message['CONTENT'] = trim(strip_tags(message_get_content($search_result['TID'], $search_result['PID'])));

        }

        $message['TITLE'] = apply_wordfilter($message['TITLE']);

        // trunicate the search result at the last space in the first 50 chars.

        if (strlen($message['TITLE']) > 20) {

            $message['TITLE'] = substr($message['TITLE'], 0, 20);

            if (($pos = strrpos($message['TITLE'], ' ')) !== false) {

                $message['TITLE'] = substr($message['TITLE'], 0, $pos);

            }else {

                $message['TITLE'] = substr($message['TITLE'], 0, 17). "&hellip;";
            }
        }

        if (strlen($message['CONTENT']) > 35) {

            $message['CONTENT'] = substr($message['CONTENT'], 0, 35);

            if (($pos = strrpos($message['TITLE'], ' ')) !== false) {

                $message['CONTENT'] = substr($message['CONTENT'], 0, $pos);

            }else {

                $message['CONTENT'] = substr($message['CONTENT'], 0, 32). "&hellip;";
            }
        }

        if (strlen($message['CONTENT']) > 0) {

            echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;search_string=", rawurlencode(trim($search_arguments['search_string'])), "\" target=\"right\"><b>{$message['TITLE']}</b><br />";
            echo wordwrap($message['CONTENT'], 25, '<br />', 1), "</a><br />";
            echo "<span class=\"smalltext\">&nbsp;-&nbsp;from ". format_user_name($message['FLOGON'], $message['FNICK']). ", ". format_time($search_result['CREATED'], 1). "</span></p></li>\n";

        }else {

            echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;search_string=", rawurlencode(trim($search_arguments['search_string'])), "\" target=\"right\"><b>{$message['TITLE']}</b></a><br />";
            echo "<span class=\"smalltext\">&nbsp;-&nbsp;from ". format_user_name($message['FLOGON'], $message['FNICK']). ", ". format_time($search_result['CREATED'], 1). "</span></p></li>\n";
        }
    }

    echo "</ol>\n";

    if ($search_results_array['match_count'] >  (sizeof($search_results_array['match_array']) + $sstart)) {
        echo "<img src=\"", style_image('current_thread.png'), "\" height=\"15\" alt=\"{$lang['findmore']}\" title=\"{$lang['findmore']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;sstart=", $sstart + 20, $urlquery, "\">{$lang['findmore']}</a>\n";
    }

}else if ($error) {

    echo "<h1>{$lang['error']}</h1>\n";

    switch($error) {

        case SEARCH_USER_NOT_FOUND:
            echo "<p>{$lang['usernamenotfound']}</p>\n";
            break;
        case SEARCH_NO_KEYWORDS:
            echo "<p>{$lang['notexttosearchfor']}</p>\n";
            break;
        case SEARCH_NO_MATCHES:
            echo "<img src=\"", style_image('search.png'), "\" height=\"15\" alt=\"{$lang['matches']}\" title=\"{$lang['matches']}\" />&nbsp;{$lang['found']}: 0 {$lang['matches']}<br />\n";
            break;
        case SEARCH_FREQUENCY_TOO_GREAT:
            echo "<p>{$lang['searchfrequencyerror_1']} ", forum_get_setting('search_min_frequency', false, 30), " {$lang['searchfrequencyerror_2']}</p>\n";
            break;
    }
}

echo "<br />\n";
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
echo "      <form method=\"post\" action=\"search.php\" target=\"_self\">\n";
echo "        ", form_input_hidden('webtag', $webtag), "\n";
echo "        ", form_input_text("search_string", "", 20). "\n";
echo "        ", form_submit("submit", $lang['find']). "\n";
echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>