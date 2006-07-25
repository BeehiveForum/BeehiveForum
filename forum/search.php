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

/* $Id: search.php,v 1.139 2006-07-25 21:43:52 decoyduck Exp $ */

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

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_COOKIE['bh_thread_mode'])) {
    $mode = $_COOKIE['bh_thread_mode'];
}else{
    $mode = 0;
}

if (isset($_GET['order_by']) && is_numeric($_GET['order_by'])) {
    $order_by = $_GET['order_by'];
}else {
    $order_by = 1;
}

if (!$folder_dropdown = folder_search_dropdown()) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['couldnotretrievefolderinformation']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (isset($_GET['show_stop_words'])) {

    html_draw_top();

    if (isset($_GET['close'])) {

        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "  window.close();\n";
        echo "</script>\n";

        html_draw_bottom();
        exit;
    }

    include(BH_INCLUDE_PATH. "search_stopwords.inc.php");

    echo "<h1>{$lang['mysqlstopwordlist']}</h1>\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"540\">\n";
    echo "  <tr>\n";

    $mysql_fulltext_stopwords = array_values($mysql_fulltext_stopwords);

    for ($i = 0; $i < sizeof($mysql_fulltext_stopwords); $i++) {

        if ($i > 0 && (!($i % 4))) {

            echo "  </tr>\n";
            echo "  <tr>\n";
        }

        echo "    <td class=\"postbody\">{$mysql_fulltext_stopwords[$i]}</td>\n";
    }

    echo "  </tr>\n";
    echo "</table>\n";
    echo "<div align=\"center\">\n";
    echo form_quick_button("./search.php", $lang['close'], array("close", "show_stop_words"), array("close", "yes"), "_self");
    echo "</div>\n";

    html_draw_bottom();
    exit;
}

search_get_word_lengths($min_length, $max_length);

if (isset($_POST) && sizeof($_POST) > 0) {

    $offset = 0;

    $search_arguments = array();

    if (isset($_POST['search_string'])) {
        $search_arguments['search_string'] = $_POST['search_string'];
    }

    if (isset($_POST['method']) && is_numeric($_POST['method'])) {
        $search_arguments['method'] = $_POST['method'];
    }

    if (isset($_POST['username']) && strlen(trim($_POST['username'])) > 0) {
        $search_arguments['username'] = $_POST['username'];
    }

    if (isset($_POST['user_include']) && is_numeric($_POST['user_include'])) {
        $search_arguments['user_include'] = $_POST['user_include'];
    }

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $search_arguments['fid'] = $_POST['fid'];
    }

    if (isset($_POST['date_from']) && is_numeric($_POST['date_from'])) {
        $search_arguments['date_from'] = $_POST['date_from'];
    }

    if (isset($_POST['date_to']) && is_numeric($_POST['date_to'])) {
        $search_arguments['date_to'] = $_POST['date_to'];
    }

    if (isset($_POST['order_by']) && is_numeric($_POST['order_by'])) {
        $search_arguments['order_by'] = $_POST['order_by'];
    }

    if (isset($_POST['group_by_thread']) && is_numeric($_POST['group_by_thread'])) {
        $search_arguments['group_by_thread'] = $_POST['group_by_thread'];
    }

    if (!$search_success = search_execute($search_arguments, $error)) {

        html_draw_top("search.js", "robots=noindex,nofollow", "onload=enable_search_button()");

        echo "<h1>{$lang['error']}</h1>\n";

        search_get_word_lengths($min_length, $max_length);

        $search_frequency = forum_get_setting('search_min_frequency', false, 0);

        switch($error) {

            case SEARCH_USER_NOT_FOUND:
                echo "<p>{$lang['usernamenotfound']}</p>\n";
                break;
            case SEARCH_NO_KEYWORDS:

                $mysql_stop_word_link = "<a href=\"javascript:void(0);\" onclick=\"display_mysql_stopwords('$webtag')\">{$lang['mysqlstopwordlist']}</a>";

                echo sprintf("<p>{$lang['notexttosearchfor']}</p>\n", $min_length, $max_length, $mysql_stop_word_link);

                if (isset($search_arguments['search_string']) && strlen(trim(_stripslashes($search_arguments['search_string']))) > 0) {

                    $search_string = trim(_stripslashes($search_arguments['search_string']));
                    $keywords_error_array = search_strip_keywords($search_string, true);

                    echo "<h2>Keywords containing errors:</h2>\n";
                    echo "<ul>\n";

                    foreach($keywords_error_array['keywords'] as $keyword_error) {
                        echo "  <li>$keyword_error</li>\n";
                    }

                    echo "</ul>\n";
                }

                break;

            case SEARCH_FREQUENCY_TOO_GREAT:
                echo "<p>{$lang['searchfrequencyerror_1']} $search_frequency {$lang['searchfrequencyerror_2']}</p>\n";
                break;
        }

        echo "</table>\n";
    }

}elseif (isset($_GET['offset']) && is_numeric($_GET['offset'])) {

    $search_success = true;
    $offset = $_GET['offset'];
}

if (isset($search_success) && $search_success === true && isset($offset)) {

    if ($search_results_array = search_fetch_results($offset, $order_by)) {

        html_draw_top("search.js", "robots=noindex,nofollow", "onload=enable_search_button()");

        thread_list_draw_top(19);

        echo "<br />\n";
        echo "<h1>{$lang['searchresults']}</h1>\n";
        echo "<img src=\"", style_image('search.png'), "\" alt=\"{$lang['found']}\" title=\"{$lang['found']}\" />&nbsp;{$lang['found']}: {$search_results_array['result_count']} {$lang['matches']}<br />\n";

        if ($offset >= 20) {
            echo "<img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['prevpage']}\" title=\"{$lang['prevpage']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;offset=", $offset - 20, "&amp;order_by=$order_by\">{$lang['prevpage']}</a>\n";
        }

        echo "<ol start=\"", $offset + 1, "\">\n";

        foreach ($search_results_array['result_array'] as $search_result) {

            $message = messages_get($search_result['TID'], $search_result['PID'], 1);
            $message['CONTENT'] = message_get_content($search_result['TID'], $search_result['PID']);

            if ($threaddata = thread_get($search_result['TID'])) {

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

                    if (($pos = strrpos($message['CONTENT'], ' ')) !== false) {

                        $message['CONTENT'] = substr($message['CONTENT'], 0, $pos);

                    }else {

                        $message['CONTENT'] = substr($message['CONTENT'], 0, 32). "&hellip;";
                    }
                }

                if (strlen($message['CONTENT']) > 0) {

                    echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;search_string=", rawurlencode(trim($search_result['KEYWORDS'])), "\" target=\"right\"><b>{$message['TITLE']}</b><br />";
                    echo wordwrap($message['CONTENT'], 25, '<br />', 1), "</a><br />";
                    echo "<span class=\"smalltext\">&nbsp;-&nbsp;from ", format_user_name($message['FLOGON'], $message['FNICK']), ", ", format_time($search_result['CREATED'], 1), "</span></p></li>\n";

                }else {

                    echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;search_string=", rawurlencode(trim($search_result['KEYWORDS'])), "\" target=\"right\"><b>{$message['TITLE']}</b></a><br />";
                    echo "<span class=\"smalltext\">&nbsp;-&nbsp;from ", format_user_name($message['FLOGON'], $message['FNICK']), ", ", format_time($search_result['CREATED'], 1), "</span></p></li>\n";
                }
            }
        }

        echo "</ol>\n";

        if ($search_results_array['result_count'] >  (sizeof($search_results_array['result_array']) + $offset)) {
            echo "<img src=\"", style_image('current_thread.png'), "\" alt=\"{$lang['findmore']}\" title=\"{$lang['findmore']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;offset=", $offset + 20, "&amp;order_by=$order_by\">{$lang['findmore']}</a><br />\n";
        }

    }else {

        html_draw_top("search.js", "robots=noindex,nofollow", "onload=enable_search_button()");

        thread_list_draw_top(19);

        echo "<br />\n";        
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<img src=\"", style_image('search.png'), "\" alt=\"{$lang['matches']}\" title=\"{$lang['matches']}\" />&nbsp;{$lang['found']}: 0 {$lang['matches']}<br />\n";
    }

}elseif (!isset($search_success)) {

    html_draw_top("search.js", "robots=noindex,nofollow");

    echo "<h1>{$lang['searchmessages']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form id=\"search_form\" method=\"post\" action=\"search.php\" target=\"left\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                  <td>", form_dropdown_array("date_from", range(1, 12), array($lang['today'], $lang['yesterday'], $lang['daybeforeyesterday'], sprintf($lang['weekago'], 1), sprintf($lang['weeksago'], 2), sprintf($lang['weeksago'], 3), sprintf($lang['monthago'], 1), sprintf($lang['monthsago'], 2), sprintf($lang['monthsago'], 3), sprintf($lang['monthsago'], 6), sprintf($lang['yearago'], 1), $lang['beginningoftime']), 7, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['postedto']}:</td>\n";
    echo "                  <td>", form_dropdown_array("date_to", range(1, 12), array($lang['now'], $lang['today'], $lang['yesterday'], $lang['daybeforeyesterday'], sprintf($lang['weekago'], 1), sprintf($lang['weeksago'], 2), sprintf($lang['weeksago'], 3), sprintf($lang['monthago'], 1), sprintf($lang['monthsago'], 2), sprintf($lang['monthsago'], 3), sprintf($lang['monthsago'], 6), sprintf($lang['yearago'], 1)), 2, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['orderby']}:</td>\n";
    echo "                  <td>", form_dropdown_array("order_by", range(1, 2), array($lang['newestfirst'], $lang['oldestfirst']), 1, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td nowrap=\"nowrap\">&nbsp;{$lang['groupbythread']}:</td>\n";
    echo "                  <td>", form_radio("group_by_thread", 1, $lang['yes'], false), "&nbsp;", form_radio("group_by_thread", 0, $lang['no'], true), "&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_button("go_button", $lang['find'], "onclick=\"disable_button(this); submit_form('search_form')\""), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;
}

echo "<br />\n";

if (isset($search_success) && $search_success === true) {

    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"smalltext\" colspan=\"2\">{$lang['orderby']}:</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td>&nbsp;</td>\n";
    echo "    <td class=\"smalltext\">\n";
    echo "      <form name=\"f_nav\" method=\"get\" action=\"search.php\" target=\"_self\">\n";
    echo "        ", form_input_hidden("webtag", $webtag), "\n";
    echo "        ", form_input_hidden("offset", isset($offset) ? $offset : 0), "\n";
    echo "        ", form_dropdown_array("order_by", range(1, 2), array($lang['newestfirst'], $lang['oldestfirst']), $order_by, false), "\n";
    echo "        ", form_submit("go",$lang['goexcmark']). "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

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