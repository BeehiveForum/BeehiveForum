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

/* $Id: search.php,v 1.172 2007-04-18 23:20:27 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

// Open Search support (FireFox 2.0, etc.)

if (isset($_GET['opensearch'])) {
    search_output_opensearch_xml();
    exit;
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
    $sort_dir = 1;
}


// Drop down date from options

$search_date_from_array = array(1  => $lang['today'],
                                2  => $lang['yesterday'], 
                                3  => $lang['daybeforeyesterday'], 
                                4  => sprintf($lang['weekago'], 1), 
                                5  => sprintf($lang['weeksago'], 2), 
                                6  => sprintf($lang['weeksago'], 3), 
                                7  => sprintf($lang['monthago'], 1), 
                                8  => sprintf($lang['monthsago'], 2), 
                                9  => sprintf($lang['monthsago'], 3), 
                                10 => sprintf($lang['monthsago'], 6), 
                                11 => sprintf($lang['yearago'], 1), 
                                12 => $lang['beginningoftime']);

// Drop down date to options

$search_date_to_array = array(1  => $lang['now'], 
                              2  => $lang['today'], 
                              3  => $lang['yesterday'], 
                              4  => $lang['daybeforeyesterday'], 
                              5  => sprintf($lang['weekago'], 1), 
                              6  => sprintf($lang['weeksago'], 2), 
                              7  => sprintf($lang['weeksago'], 3), 
                              8  => sprintf($lang['monthago'], 1), 
                              9  => sprintf($lang['monthsago'], 2), 
                              10 => sprintf($lang['monthsago'], 3), 
                              11 => sprintf($lang['monthsago'], 6), 
                              12 => sprintf($lang['yearago'], 1));

// Drop down sort by options

$search_sort_by_array = array(1 => $lang['lastpostdate'],
                              2 => $lang['numberofreplies'], 
                              3 => $lang['foldername'], 
                              4 => $lang['authorname']);

// Drop down sort dir options

$search_sort_dir_array = array(1 => $lang['decendingorder'], 
                               2 => $lang['ascendingorder']);

// Get a list of available folders.

if (!$folder_dropdown = folder_search_dropdown()) {

    html_draw_top();
    html_error_msg($lang['couldnotretrievefolderinformation']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['show_stop_words'])) {

    $highlight_keywords_array = array();
    
    html_draw_top();

    if (isset($_GET['close'])) {

        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "  window.close();\n";
        echo "</script>\n";

        html_draw_bottom();
        exit;
    }

    if (isset($_GET['keywords']) && strlen(trim(_stripslashes($_GET['keywords']))) > 0) {
        $highlight_keywords_array = explode(" ", trim(_stripslashes($_GET['keywords'])));
    }

    include(BH_INCLUDE_PATH. "search_stopwords.inc.php");

    echo "<h1>{$lang['mysqlstopwordlist']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form id=\"search_stop_words\" method=\"get\" action=\"search.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('show_stop_words', 'yes'), "\n";
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

    $mysql_fulltext_stopwords = array_values($mysql_fulltext_stopwords);

    for ($i = 0; $i < sizeof($mysql_fulltext_stopwords); $i++) {

        if ($i > 0 && (!($i % 4))) {

            echo "                      </tr>\n";
            echo "                      <tr>\n";
        }

        if (in_array($mysql_fulltext_stopwords[$i], $highlight_keywords_array)) {
            echo "                        <td align=\"left\" class=\"postbody\"><span class=\"highlight\">{$mysql_fulltext_stopwords[$i]}</span></td>\n";
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

search_get_word_lengths($min_length, $max_length);

if ((isset($_POST) && sizeof($_POST) > 0) || isset($_GET['search_string']) || isset($_GET['logon'])) {

    $offset = 0;

    $search_arguments = array();

    if (isset($_GET['search_string']) && strlen(trim(_stripslashes($_GET['search_string']))) > 0) {
        $search_arguments['search_string'] = trim(_stripslashes($_GET['search_string']));
    }else if (isset($_POST['search_string'])) {
        $search_arguments['search_string'] = $_POST['search_string'];
    }

    if (isset($_POST['method']) && is_numeric($_POST['method'])) {
        $search_arguments['method'] = $_POST['method'];
    }

    if (isset($_POST['username']) && strlen(trim($_POST['username'])) > 0) {

        $search_arguments['username'] = $_POST['username'];

    }elseif (isset($_GET['logon']) && strlen(trim($_GET['logon'])) > 0) {

        $search_arguments['username'] = $_GET['logon'];
        $search_arguments['date_from'] = 12;
        $search_arguments['date_to'] = 1;
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

    if (isset($_POST['sort_by']) && is_numeric($_POST['sort_by'])) {
        $search_arguments['sort_by'] = $_POST['sort_by'];
    }

    if (isset($_POST['sort_dir']) && is_numeric($_POST['sort_dir'])) {
        $search_arguments['sort_dir'] = $_POST['sort_dir'];
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

                if (isset($search_arguments['search_string']) && strlen(trim(_stripslashes($search_arguments['search_string']))) > 0) {

                    $search_string = trim(_stripslashes($search_arguments['search_string']));
                    
                    $keywords_error_array = search_strip_keywords($search_string, true);
                    $keywords_error_array['keywords'] = search_strip_special_chars($keywords_error_array['keywords'], false);

                    $stopped_keywords = urlencode(implode(' ', $keywords_error_array['keywords']));
                    
                    $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true&amp;keywords=$stopped_keywords\" target=\"_blank\" onclick=\"return display_mysql_stopwords('$webtag', '$stopped_keywords')\">{$lang['mysqlstopwordlist']}</a>";
                    echo sprintf("<p>{$lang['notexttosearchfor']}</p>\n", $min_length, $max_length, $mysql_stop_word_link);

                    echo "<h2>Keywords containing errors</h2>\n";
                    echo "<ul>\n";

                    foreach($keywords_error_array['keywords'] as $keyword_error) {
                        echo "  <li>$keyword_error</li>\n";
                    }

                    echo "</ul>\n";

                }else {

                    $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true\" target=\"_blank\" onclick=\"return display_mysql_stopwords('$webtag', '')\">{$lang['mysqlstopwordlist']}</a>";
                    echo sprintf("<p>{$lang['notexttosearchfor']}</p>\n", $min_length, $max_length, $mysql_stop_word_link);
                }

                break;

            case SEARCH_FREQUENCY_TOO_GREAT:

                echo sprintf("<p>{$lang['searchfrequencyerror']}</p>\n", $search_frequency);
                break;
        }

        echo "</table>\n";
    }

}elseif (isset($_GET['offset']) && is_numeric($_GET['offset'])) {

    $search_success = true;
    $offset = $_GET['offset'];
}

if (isset($search_success) && $search_success === true && (isset($_GET['search_string']) || isset($_GET['logon']))) {

    $redirect_uri = "./index.php?webtag=$webtag&final_uri=.%2Fdiscussion.php";
    $redirect_uri.= "%3Fwebtag%3D$webtag%26amp%3Bleft%3Dsearch_results";
    header_redirect($redirect_uri);
    exit;
}

if (isset($search_success) && $search_success === true && isset($offset)) {

    if ($search_results_array = search_fetch_results($offset, $sort_by, $sort_dir)) {

        html_draw_top("search.js", "robots=noindex,nofollow", "onload=enable_search_button()");

        thread_list_draw_top(19);

        echo "<br />\n";
        echo "<h1>{$lang['searchresults']}</h1>\n";
        echo "<img src=\"", style_image('search.png'), "\" alt=\"{$lang['found']}\" title=\"{$lang['found']}\" />&nbsp;{$lang['found']}: {$search_results_array['result_count']} {$lang['matches']}<br />\n";

        if ($offset >= 20) {
            echo "<img src=\"".style_image('current_thread.png')."\" alt=\"{$lang['prevpage']}\" title=\"{$lang['prevpage']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;offset=", $offset - 20, "&amp;sort_by=$sort_by\">{$lang['prevpage']}</a>\n";
        }

        echo "<ol start=\"", $offset + 1, "\">\n";

        foreach ($search_results_array['result_array'] as $search_result) {

            $message = messages_get($search_result['TID'], $search_result['PID'], 1);
            $message['CONTENT'] = message_get_content($search_result['TID'], $search_result['PID']);

            if ($threaddata = thread_get($search_result['TID'])) {

                $message['TITLE']   = trim(strip_tags(thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE'])));
                $message['CONTENT'] = trim(strip_tags(message_get_content($search_result['TID'], $search_result['PID'])));

                // Limit thread title to 20 characters.

                if (strlen($message['TITLE']) > 20) {

                    $message['TITLE'] = substr($message['TITLE'], 0, 20);

                    if (($pos = strrpos($message['TITLE'], ' ')) !== false) {

                        $message['TITLE'] = trim(substr($message['TITLE'], 0, $pos));

                    }else {

                        $message['TITLE'] = trim(substr($message['TITLE'], 0, 17). "&hellip;");
                    }
                }

                // Apply word filter to truncated thread title                
                
                $message['TITLE'] = word_filter_add_ob_tags($message['TITLE']);

                // Limit displayed post content to 35 characters

                if (strlen($message['CONTENT']) > 35) {

                    $message['CONTENT'] = substr($message['CONTENT'], 0, 35);

                    if (($pos = strrpos($message['CONTENT'], ' ')) !== false) {

                        $message['CONTENT'] = trim(substr($message['CONTENT'], 0, $pos));

                    }else {

                        $message['CONTENT'] = trim(substr($message['CONTENT'], 0, 32). "&hellip;");
                    }
                }

                // Apply word filter to content.
                
                $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT']);

                if ((thread_is_poll($search_result['TID']) && $search_result['PID'] == 1) || strlen($message['CONTENT']) < 1) {

                    echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;hightlight=yes\" target=\"right\"><b>{$message['TITLE']}</b></a><br />";
                    echo "<span class=\"smalltext\"><b>{$lang['from']}:</b> ", word_filter_add_ob_tags(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME'])), ", ", format_time($search_result['CREATED'], 1), "</span></p></li>\n";
                    
                }else {

                    echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;highlight=yes\" target=\"right\"><b>{$message['TITLE']}</b></a><br />";
                    echo "{$message['CONTENT']}<br /><span class=\"smalltext\"><b>{$lang['from']}:</b> ", word_filter_add_ob_tags(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME'])), ", ", format_time($search_result['CREATED'], 1), "</span></p></li>\n";
                }
            }
        }

        echo "</ol>\n";

        if ($search_results_array['result_count'] >  (sizeof($search_results_array['result_array']) + $offset)) {
            echo "<img src=\"", style_image('current_thread.png'), "\" alt=\"{$lang['findmore']}\" title=\"{$lang['findmore']}\" />&nbsp;<a href=\"search.php?webtag=$webtag&amp;offset=", $offset + 20, "&amp;sort_by=$sort_by\">{$lang['findmore']}</a><br />\n";
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
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['searchdiscussions']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"40%\">{$lang['keywords']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("search_string", "", 32), "&nbsp;</td>\n";
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
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['searchbyuser']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"40%\">{$lang['username']}:</td>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text("username", "", 28, 15, "", "search_logon"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=1&amp;obj_name=username\" onclick=\"return openLogonSearch('$webtag', 'username');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div>&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("user_include", 1, $lang['postsfromuser'], true), "&nbsp;", "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("user_include", 2, $lang['poststouser'], false), "&nbsp;", "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("user_include", 3, $lang['poststoandfromuser'], false), "&nbsp;", "</td>\n";
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
    echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['additionalcriteria']}:</td>\n";
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
    echo "                        <td align=\"left\">", form_dropdown_array("date_from", $search_date_from_array, 7, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['postedto']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("date_to", $search_date_to_array, 2, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['sortby']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("sort_by", $search_sort_by_array, 1, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['sortdir']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("sort_dir", $search_sort_dir_array, 1, false, "search_dropdown"), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">{$lang['groupbythread']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("group_by_thread", 1, $lang['yes'], false), "&nbsp;", form_radio("group_by_thread", 0, $lang['no'], true), "&nbsp;</td>\n";
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

    echo "<form name=\"f_nav\" method=\"get\" action=\"search.php\" target=\"_self\">\n";
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
}

if (!isset($_GET['search_string'])) {

    echo "<table cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['navigate']}:</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"right\">\n";
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
    echo "    <td align=\"left\" class=\"smalltext\" colspan=\"2\">{$lang['searchagain']} (<a href=\"search.php?webtag=$webtag\" target=\"right\">{$lang['advanced']}</a>):</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\" class=\"smalltext\">\n";
    echo "      <form method=\"post\" action=\"search.php\" target=\"_self\">\n";
    echo "        ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "        ", form_input_text("search_string", "", 20). "\n";
    echo "        ", form_submit("submit", $lang['find']). "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

html_draw_bottom();

?>