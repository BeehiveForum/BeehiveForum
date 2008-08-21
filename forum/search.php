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

/* $Id: search.php,v 1.226 2008-08-21 20:46:15 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

// Open Search support (FireFox 2.0, etc.)

if (isset($_GET['opensearch'])) {
    search_output_opensearch_xml();
    exit;
}

if (user_is_guest()) {
    html_guest_error();
    exit;
}

if (isset($_GET['sort_by']) && is_numeric($_GET['sort_by'])) {
    $sort_by = $_GET['sort_by'];
}elseif (isset($_POST['sort_by']) && is_numeric($_POST['sort_by'])) {
    $sort_by = $_POST['sort_by'];
}else {
    $sort_by = 1;
}

if (isset($_GET['sort_dir']) && is_numeric($_GET['sort_dir'])) {
    $sort_dir = $_GET['sort_dir'];
}elseif (isset($_POST['sort_dir']) && is_numeric($_POST['sort_dir'])) {
    $sort_dir = $_POST['sort_dir'];
}else {
    $sort_dir = SORT_DIR_DESC;
}

if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
    $search_folder_fid = $_POST['fid'];
}else {
    $search_folder_fid = 0;
}

// Drop down date from options

$search_date_from_array = array(SEARCH_FROM_TODAY             => $lang['today'],
                                SEARCH_FROM_YESTERDAY         => $lang['yesterday'],
                                SEARCH_FROM_DAYBEFORE         => $lang['daybeforeyesterday'],
                                SEARCH_FROM_ONE_WEEK_AGO      => sprintf($lang['weekago'], 1),
                                SEARCH_FROM_TWO_WEEKS_AGO     => sprintf($lang['weeksago'], 2),
                                SEARCH_FROM_THREE_WEEKS_AGO   => sprintf($lang['weeksago'], 3),
                                SEARCH_FROM_ONE_MONTH_AGO     => sprintf($lang['monthago'], 1),
                                SEARCH_FROM_TWO_MONTHS_AGO    => sprintf($lang['monthsago'], 2),
                                SEARCH_FROM_THREE_MONTHS_AGO  => sprintf($lang['monthsago'], 3),
                                SEARCH_FROM_SIX_MONTHS_AGO    => sprintf($lang['monthsago'], 6),
                                SEARCH_FROM_ONE_YEAR_AGO      => sprintf($lang['yearago'], 1),
                                SEARCH_FROM_BEGINNING_OF_TIME => $lang['beginningoftime']);

// Drop down date to options

$search_date_to_array = array(SEARCH_TO_NOW              => $lang['now'],
                              SEARCH_TO_TODAY            => $lang['today'],
                              SEARCH_TO_YESTERDAY        => $lang['yesterday'],
                              SEARCH_TO_DAYBEFORE        => $lang['daybeforeyesterday'],
                              SEARCH_TO_ONE_WEEK_AGO     => sprintf($lang['weekago'], 1),
                              SEARCH_TO_TWO_WEEKS_AGO    => sprintf($lang['weeksago'], 2),
                              SEARCH_TO_THREE_WEEKS_AGO  => sprintf($lang['weeksago'], 3),
                              SEARCH_TO_ONE_MONTH_AGO    => sprintf($lang['monthago'], 1),
                              SEARCH_TO_TWO_MONTHS_AGO   => sprintf($lang['monthsago'], 2),
                              SEARCH_TO_THREE_MONTHS_AGO => sprintf($lang['monthsago'], 3),
                              SEARCH_TO_SIX_MONTHS_AGO   => sprintf($lang['monthsago'], 6),
                              SEARCH_TO_ONE_YEAR_AGO     => sprintf($lang['yearago'], 1));

// Drop down sort by options

$search_sort_by_array = array(SEARCH_SORT_CREATED     => $lang['lastpostdate'],
                              SEARCH_SORT_NUM_REPLIES => $lang['numberofreplies'],
                              SEARCH_SORT_FOLDER_NAME => $lang['foldername'],
                              SEARCH_SORT_AUTHOR_NAME => $lang['authorname']);

// Drop down sort dir options

$search_sort_dir_array = array(SORT_DIR_DESC => $lang['decendingorder'],
                               SORT_DIR_ASC  => $lang['ascendingorder']);

// Get a list of available folders.

if (!$folder_dropdown = folder_search_dropdown($search_folder_fid)) {

    html_draw_top();
    html_error_msg($lang['couldnotretrievefolderinformation']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['show_stop_words'])) {

    $highlight_keywords_array = array();

    html_draw_top('pm_popup_disabled');

    if (isset($_GET['close'])) {

        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "  window.close();\n";
        echo "</script>\n";

        html_draw_bottom();
        exit;
    }

    if (isset($_GET['keywords']) && strlen(trim(_stripslashes($_GET['keywords']))) > 0) {

        $highlight_keywords_array = explode(" ", trim(_stripslashes($_GET['keywords'])));
        array_walk($highlight_keywords_array, 'mysql_fulltext_callback', '/');
        $highlight_keywords_preg = implode('$|^', $highlight_keywords_array);
    }

    $mysql_fulltext_stopwords = array();

    include(BH_INCLUDE_PATH. "search_stopwords.inc.php");

    echo "<h1>{$lang['mysqlstopwordlist']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" id=\"search_stop_words\" method=\"get\" action=\"search.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("show_stop_words", "yes"), "\n";
    echo "  <table cellpadding=\"5\" cellspacing=\"0\" width=\"540\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" valign=\"top\" width=\"100%\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table width=\"100%\" border=\"0\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['mysqlstopwordlist']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"95%\" border=\"0\">\n";
    echo "                      <tr>\n";

    $mysql_fulltext_stopwords = array_values($mysql_fulltext_stopwords);

    for ($i = 0; $i < sizeof($mysql_fulltext_stopwords); $i++) {

        if ($i > 0 && (!($i % 4))) {

            echo "                      </tr>\n";
            echo "                      <tr>\n";
        }

        if (isset($highlight_keywords_preg) && preg_match("/^$highlight_keywords_preg$/iu", $mysql_fulltext_stopwords[$i]) > 0) {

            echo "                        <td align=\"left\" class=\"postbody\"><span class=\"search_keyword_highlight\">{$mysql_fulltext_stopwords[$i]}</span></td>\n";

        }else {

            echo "                        <td align=\"left\" class=\"postbody\">{$mysql_fulltext_stopwords[$i]}</td>\n";
        }
    }

    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit('close', $lang['close']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;
}

$min_length = 4;
$max_length = 84;

search_get_word_lengths($min_length, $max_length);

if (((isset($_POST) && sizeof($_POST) > 0 && !isset($_POST['search_reset'])) || isset($_GET['search_string']) || isset($_GET['logon'])) && !isset($_GET['search_error'])) {

    $offset = 0;

    $search_arguments = array();

    $search_no_matches = false;

    if (isset($_GET['search_string']) && strlen(trim(_stripslashes($_GET['search_string']))) > 0) {
        $search_arguments['search_string'] = trim(_stripslashes($_GET['search_string']));
    }else if (isset($_POST['search_string']) && strlen(trim(_stripslashes($_POST['search_string']))) > 0) {
        $search_arguments['search_string'] = trim(_stripslashes($_POST['search_string']));
    }

    if (isset($_POST['method']) && is_numeric($_POST['method'])) {
        $search_arguments['method'] = $_POST['method'];
    }

    if (isset($_POST['username']) && strlen(trim(_stripslashes($_POST['username']))) > 0) {

        $search_arguments['username'] = trim(_stripslashes($_POST['username']));

    }elseif (isset($_GET['logon']) && strlen(trim(_stripslashes($_GET['logon']))) > 0) {

        $search_arguments['username'] = trim(_stripslashes($_GET['logon']));
        $search_arguments['user_include'] = SEARCH_FILTER_USER_POSTS;
        $search_arguments['date_from'] = 12;
        $search_arguments['date_to'] = 1;
    }

    if (isset($_POST['user_include']) && is_numeric($_POST['user_include'])) {

        $search_arguments['user_include'] = $_POST['user_include'];

    }elseif (isset($_GET['user_include']) && is_numeric($_GET['user_include'])) {

        $search_arguments['user_include'] = $_GET['user_include'];
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

    if (isset($_POST['sort_by']) && is_numeric($_POST['sort_by'])) {
        $search_arguments['sort_by'] = $_POST['sort_by'];
    }

    if (isset($_POST['sort_dir']) && is_numeric($_POST['sort_dir'])) {
        $search_arguments['sort_dir'] = $_POST['sort_dir'];
    }

    if (isset($_POST['group_by_thread']) && is_numeric($_POST['group_by_thread'])) {
        $search_arguments['group_by_thread'] = $_POST['group_by_thread'];
    }

    $error = SEARCH_NO_ERROR;

    if (($search_success = search_execute($search_arguments, $error))) {

        if (isset($_GET['search_string']) || isset($_GET['logon'])) {

            $redirect_uri = "index.php?webtag=$webtag&final_uri=.%2Fdiscussion.php";
            $redirect_uri.= "%3Fwebtag%3D$webtag%26amp%3Bleft%3Dsearch_results";

            header_redirect($redirect_uri);
            exit;

        }else {

            header_redirect("search.php?webtag=$webtag&search_success=true");
            exit;
        }

    }else if (isset($_GET['search_string']) || isset($_GET['logon'])) {

        $redirect_uri = "index.php?webtag=$webtag&final_uri=.%2Fdiscussion.php";
        $redirect_uri.= "%3Fwebtag%3D$webtag%26amp%3Bright%3Dsearch";
        $redirect_uri.= "%26amp%3Bsearch_error%3D$error";

        header_redirect($redirect_uri);
        exit;

    }else {

        switch ($error) {

            case SEARCH_NO_MATCHES:

                $search_no_matches = true;
                $valid = false;

                break;

            case SEARCH_USER_NOT_FOUND:

                $error_msg_array[] = $lang['usernamenotfound'];
                $valid = false;

                break;

            case SEARCH_NO_KEYWORDS:

                if (isset($search_arguments['search_string']) && strlen(trim(_stripslashes($search_arguments['search_string']))) > 0) {

                    $search_string = trim(_stripslashes($search_arguments['search_string']));

                    $keywords_error_array = search_strip_keywords($search_string, true);
                    $keywords_error_array['keywords'] = search_strip_special_chars($keywords_error_array['keywords'], false);

                    $stopped_keywords = urlencode(implode(' ', $keywords_error_array['keywords']));

                    $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true&amp;keywords=$stopped_keywords\" target=\"_blank\" onclick=\"return displayMysqlStopwords('$webtag', '$stopped_keywords')\">{$lang['mysqlstopwordlist']}</a>";
                    $error_msg_array[] = sprintf($lang['notexttosearchfor'], $min_length, $max_length, $mysql_stop_word_link);

                    $keywords_error_str = implode(", ", $keywords_error_array['keywords']);
                    $error_msg_array[] = sprintf($lang['keywordscontainingerrors'], $keywords_error_str);

                    break;

                }else {

                    $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true\" target=\"_blank\" onclick=\"return displayMysqlStopwords('$webtag', '')\">{$lang['mysqlstopwordlist']}</a>";
                    $error_msg_array[] = sprintf($lang['notexttosearchfor'], $min_length, $max_length, $mysql_stop_word_link);

                    break;
                }

            case SEARCH_FREQUENCY_TOO_GREAT:

                $search_frequency = forum_get_setting('search_min_frequency', false, 0);
                $error_msg_array[] = sprintf($lang['searchfrequencyerror'], $search_frequency);
                break;
        }
    }

}elseif (isset($_GET['offset']) && is_numeric($_GET['offset'])) {

    $offset = $_GET['offset'];

    if (($search_results_array = search_fetch_results($offset, $sort_by, $sort_dir))) {

        html_draw_top("search.js");

        thread_list_draw_top(SEARCH_RESULTS);

        echo "<br />\n";
        echo "<h1>{$lang['searchresults']}</h1>\n";
        echo "<img src=\"", style_image('search.png'), "\" alt=\"{$lang['found']}\" title=\"{$lang['found']}\" />&nbsp;{$lang['found']}: {$search_results_array['result_count']} {$lang['matches']}<br />\n";

        if ($offset >= 20) {
            echo "<img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['prevpage']}\" title=\"{$lang['prevpage']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;offset=", $offset - 20, "&amp;sort_by=$sort_by\">{$lang['prevpage']}</a>\n";
        }

        echo "<ol start=\"", $offset + 1, "\">\n";

        foreach ($search_results_array['result_array'] as $search_result) {

            if (($message = messages_get($search_result['TID'], $search_result['PID'], 1))) {

                $message['CONTENT'] = message_get_content($search_result['TID'], $search_result['PID']);

                if (($threaddata = thread_get($search_result['TID']))) {

                    $message['TITLE']   = trim(thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']));
                    $message['CONTENT'] = trim(strip_tags(message_get_content($search_result['TID'], $search_result['PID'])));

                    // Limit thread title to 20 characters.

                    if (strlen($message['TITLE']) > 20) {
                        $message['TITLE'] = word_filter_add_ob_tags(substr(_htmlentities($message['TITLE']), 0, 20)). "&hellip;";
                    }else {
                        $message['TITLE'] = word_filter_add_ob_tags(_htmlentities($message['TITLE']));
                    }

                    // Limit displayed post content to 35 characters

                    if (strlen($message['CONTENT']) > 35) {
                        $message['CONTENT'] = word_filter_add_ob_tags(substr($message['CONTENT'], 0, 35)). "&hellip;";
                    }else {
                        $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT']);
                    }

                    if ((thread_is_poll($search_result['TID']) && $search_result['PID'] == 1) || strlen($message['CONTENT']) < 1) {

                        echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;hightlight=yes\" target=\"", html_get_frame_name('right'), "\"><b>{$message['TITLE']}</b></a><br />";
                        echo "<span class=\"smalltext\"><b>{$lang['from']}:</b> ", word_filter_add_ob_tags(_htmlentities(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME']))), ", ", format_time($search_result['CREATED'], 1), "</span></p></li>\n";

                    }else {

                        echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;highlight=yes\" target=\"", html_get_frame_name('right'), "\"><b>{$message['TITLE']}</b></a><br />";
                        echo "{$message['CONTENT']}<br /><span class=\"smalltext\"><b>{$lang['from']}:</b> ", word_filter_add_ob_tags(_htmlentities(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME']))), ", ", format_time($search_result['CREATED'], 1), "</span></p></li>\n";
                    }
                }
            }
        }

        echo "</ol>\n";

        if ($search_results_array['result_count'] >  (sizeof($search_results_array['result_array']) + $offset)) {
            echo "<img src=\"", style_image('current_thread.png'), "\" alt=\"{$lang['findmore']}\" title=\"{$lang['findmore']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;offset=", $offset + 20, "&amp;sort_by=$sort_by\">{$lang['findmore']}</a><br />\n";
        }

        echo "<form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"search.php\" target=\"_self\">\n";
        echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden("offset", isset($offset) ? _htmlentities($offset) : 0), "\n";
        echo "  <table cellpadding=\"2\" cellspacing=\"0\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['sortresults']}:</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "      <td align=\"left\" colspan=\"2\">", form_dropdown_array("sort_by", $search_sort_by_array, $sort_by), "</td>\n";
        echo "    </tr>\n";
        echo"     <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "      <td align=\"left\">", form_dropdown_array("sort_dir", $search_sort_dir_array, $sort_dir), "</td>\n";
        echo "      <td align=\"left\">", form_submit("go",$lang['goexcmark']). "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "<br />\n";

    }else {

        html_draw_top("search.js");

        thread_list_draw_top(SEARCH_RESULTS);

        echo "<br />\n";
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<img src=\"", style_image('search.png'), "\" alt=\"{$lang['matches']}\" title=\"{$lang['matches']}\" />&nbsp;{$lang['found']}: 0 {$lang['matches']}<br /><br />\n";
    }

    echo "<table cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['navigate']}:</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"", html_get_frame_name('right'), "\">\n";
    echo "        ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "        ", form_input_text('msg', '1.1', 10). "\n";
    echo "        ", form_submit("go",$lang['goexcmark']). "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";
    echo "<table cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['searchagain']} (<a href=\"search.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['advanced']}</a>):</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form accept-charset=\"utf-8\" method=\"post\" action=\"search.php\" target=\"", html_get_frame_name('right'), "\">\n";
    echo "        ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "        ", form_input_text("search_string", "", 20). "\n";
    echo "        ", form_submit("search", $lang['find']). "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

    html_draw_bottom();
    exit;
}

html_draw_top("search.js");

echo "<h1>{$lang['searchmessages']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'center');

}elseif (isset($_GET['search_success'])) {

    $frame_target = html_get_frame_name('left');
    $results_link = sprintf("<a href=\"search.php?webtag=$webtag&amp;offset=0\" target=\"$frame_target\">%s</a>", $lang['clickheretoviewresults']);

    echo "<div id=\"search_success\">\n";
    html_display_success_msg(sprintf($lang['searchsuccessfullycompleted'], $results_link), '600', 'center');
    echo "</div>\n";

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "if (top.document.body.rows) {\n";
    echo "    top.frames['", html_get_frame_name('main'), "'].frames['", html_get_frame_name('left'), "'].location.replace('search.php?webtag=$webtag&offset=0');\n";
    echo "}else if (top.document.body.cols) {\n";
    echo "    top.frames['", html_get_frame_name('left'), "'].location.replace('search.php?webtag=$webtag&offset=0');\n";
    echo "}\n\n";
    echo "var search_success_container = getObjById('search_success');\n\n";
    echo "if (typeof search_success_container == 'object') {\n";
    echo "    search_success_container.innerHTML = '", html_display_success_msg_js(sprintf($lang['searchsuccessfullycompleted'], ''), '600', 'center'), "';\n";
    echo "}\n\n";
    echo "-->\n";
    echo "</script>\n\n";

}elseif (isset($_GET['search_error']) && is_numeric($_GET['search_error'])) {

    $search_error = $_GET['search_error'];

    switch ($search_error) {

        case SEARCH_NO_MATCHES:

            html_display_warning_msg($lang['searchreturnednoresults'], '600', 'center');
            break;

        case SEARCH_USER_NOT_FOUND:

            html_display_error_msg($lang['usernamenotfound'], '600', 'center');
            break;

        case SEARCH_NO_KEYWORDS:

            $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true\" target=\"_blank\" onclick=\"return displayMysqlStopwords('$webtag', '')\">{$lang['mysqlstopwordlist']}</a>";
            html_display_error_msg(sprintf($lang['notexttosearchfor'], $min_length, $max_length, $mysql_stop_word_link));
            break;

        case SEARCH_FREQUENCY_TOO_GREAT:

            $search_frequency = forum_get_setting('search_min_frequency', false, 0);
            html_display_error_msg(sprintf($lang['searchfrequencyerror'], $search_frequency));
            break;
    }

}elseif (isset($search_no_matches) && $search_no_matches == true) {

    html_display_warning_msg($lang['searchreturnednoresults'], '600', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" id=\"search_form\" method=\"post\" action=\"search.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['searchdiscussions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"40%\">{$lang['keywords']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("search_string", (isset($search_arguments['search_string']) ? _htmlentities($search_arguments['search_string']) : ''), 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['searchbyuser']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"40%\">{$lang['username']}:</td>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text("username", (isset($search_arguments['username']) ? _htmlentities($search_arguments['username']) : ''), 28, 0, "", "search_logon"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;obj_name=username\" onclick=\"return openLogonSearch('$webtag', 'username');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("user_include", SEARCH_FILTER_USER_POSTS, $lang['postsfromuser'], ((isset($search_arguments['user_include']) && $search_arguments['user_include'] == SEARCH_FILTER_USER_POSTS) || (!isset($search_arguments['user_include'])))), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("user_include", SEARCH_FILTER_USER_THREADS, $lang['threadsstartedbyuser'], (isset($search_arguments['user_include']) && $search_arguments['user_include'] == SEARCH_FILTER_USER_THREADS)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['additionalcriteria']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"40%\">{$lang['folderbrackets_s']}:</td>\n";
echo "                        <td align=\"left\">", $folder_dropdown, "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['postedfrom']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("date_from", $search_date_from_array, (isset($search_arguments['date_from']) && in_array($search_arguments['date_from'], array_keys($search_date_from_array)) ? $search_arguments['date_from'] : SEARCH_FROM_ONE_MONTH_AGO), false, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['postedto']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("date_to", $search_date_to_array, (isset($search_arguments['date_to']) && in_array($search_arguments['date_to'], array_keys($search_date_to_array)) ? $search_arguments['date_to'] : SEARCH_TO_TODAY), false, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['sortby']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("sort_by", $search_sort_by_array, (isset($search_arguments['sort_by']) && in_array($search_arguments['sort_by'], array_keys($search_sort_by_array)) ? $search_arguments['sort_by'] : SEARCH_SORT_CREATED), false, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['sortdir']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("sort_dir", $search_sort_dir_array, (isset($search_arguments['sort_dir']) && in_array($search_arguments['sort_dir'], array_keys($search_sort_dir_array)) ? $search_arguments['sort_dir'] : SORT_DIR_DESC), false, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['groupbythread']}:</td>\n";
echo "                        <td align=\"left\">", form_radio("group_by_thread", SEARCH_GROUP_THREADS, $lang['yes'], (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS)), "&nbsp;", form_radio("group_by_thread", SEARCH_GROUP_NONE, $lang['no'], ((isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_NONE) || (!isset($search_arguments['group_by_thread'])))), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit('search_submit', $lang['find'], "onclick=\"searchFormSubmit()\""), "&nbsp;", form_submit('search_reset', $lang['reset']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>