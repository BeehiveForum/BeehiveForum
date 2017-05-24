<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'search.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Open search support
if (isset($_GET['opensearch'])) {

    search_output_opensearch_xml();
    exit;
}

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == SEARCH_SORT_NUM_REPLIES) {
        $sort_by = SEARCH_SORT_NUM_REPLIES;
    } else if ($_GET['sort_by'] == SEARCH_SORT_FOLDER_NAME) {
        $sort_by = SEARCH_SORT_FOLDER_NAME;
    } else if ($_GET['sort_by'] == SEARCH_SORT_AUTHOR_NAME) {
        $sort_by = SEARCH_SORT_AUTHOR_NAME;
    } else if ($_GET['sort_by'] == SEARCH_SORT_RELEVANCE) {
        $sort_by = SEARCH_SORT_RELEVANCE;
    } else {
        $sort_by = SEARCH_SORT_CREATED;
    }

} else {

    $sort_by = SEARCH_SORT_CREATED;
}

if (isset($_GET['sort_dir'])) {

    if ($_GET['sort_dir'] == SEARCH_SORT_DESC) {
        $sort_dir = SEARCH_SORT_DESC;
    } else {
        $sort_dir = SEARCH_SORT_ASC;
    }

} else {

    $sort_dir = SEARCH_SORT_DESC;
}

if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
    $search_folder_fid = intval($_POST['fid']);
} else {
    $search_folder_fid = 0;
}

$search_date_from_array = array(
    SEARCH_FROM_TODAY => gettext("Today"),
    SEARCH_FROM_YESTERDAY => gettext("Yesterday"),
    SEARCH_FROM_DAYBEFORE => gettext("Day before yesterday"),
    SEARCH_FROM_ONE_WEEK_AGO => sprintf(gettext("%s week ago"), 1),
    SEARCH_FROM_TWO_WEEKS_AGO => sprintf(gettext("%s weeks ago"), 2),
    SEARCH_FROM_THREE_WEEKS_AGO => sprintf(gettext("%s weeks ago"), 3),
    SEARCH_FROM_ONE_MONTH_AGO => sprintf(gettext("%s month ago"), 1),
    SEARCH_FROM_TWO_MONTHS_AGO => sprintf(gettext("%s months ago"), 2),
    SEARCH_FROM_THREE_MONTHS_AGO => sprintf(gettext("%s months ago"), 3),
    SEARCH_FROM_SIX_MONTHS_AGO => sprintf(gettext("%s months ago"), 6),
    SEARCH_FROM_ONE_YEAR_AGO => sprintf(gettext("%s year ago"), 1),
    SEARCH_FROM_BEGINNING_OF_TIME => gettext("Beginning of time")
);

$search_date_to_array = array(
    SEARCH_TO_NOW => gettext("Now"),
    SEARCH_TO_TODAY => gettext("Today"),
    SEARCH_TO_YESTERDAY => gettext("Yesterday"),
    SEARCH_TO_DAYBEFORE => gettext("Day before yesterday"),
    SEARCH_TO_ONE_WEEK_AGO => sprintf(gettext("%s week ago"), 1),
    SEARCH_TO_TWO_WEEKS_AGO => sprintf(gettext("%s weeks ago"), 2),
    SEARCH_TO_THREE_WEEKS_AGO => sprintf(gettext("%s weeks ago"), 3),
    SEARCH_TO_ONE_MONTH_AGO => sprintf(gettext("%s month ago"), 1),
    SEARCH_TO_TWO_MONTHS_AGO => sprintf(gettext("%s months ago"), 2),
    SEARCH_TO_THREE_MONTHS_AGO => sprintf(gettext("%s months ago"), 3),
    SEARCH_TO_SIX_MONTHS_AGO => sprintf(gettext("%s months ago"), 6),
    SEARCH_TO_ONE_YEAR_AGO => sprintf(gettext("%s year ago"), 1)
);

$search_sort_by_array = array(
    SEARCH_SORT_CREATED => gettext("Last post date"),
    SEARCH_SORT_NUM_REPLIES => gettext("Number of replies"),
    SEARCH_SORT_FOLDER_NAME => gettext("Folder name"),
    SEARCH_SORT_AUTHOR_NAME => gettext("Author name"),
    SEARCH_SORT_RELEVANCE => gettext("Relevancy")
);

$search_sort_dir_array = array(
    SEARCH_SORT_ASC => gettext("Oldest first"),
    SEARCH_SORT_DESC => gettext("Newest first")
);

if (!$folder_dropdown = folder_search_dropdown($search_folder_fid)) {
    html_draw_error(gettext("There are no folders available."));
}

$min_length = 4;
$max_length = 84;

search_get_word_lengths($min_length, $max_length);

if (((isset($_POST) && sizeof($_POST) > 0 && !isset($_POST['search_reset'])) || isset($_GET['search_string']) || isset($_GET['logon']) || isset($_GET['tag'])) && !isset($_GET['search_error'])) {

    $page = 1;

    $search_arguments = array();

    $search_no_matches = false;

    if (isset($_GET['search_string']) && strlen(trim($_GET['search_string'])) > 0) {
        $search_arguments['search_string'] = trim($_GET['search_string']);
    } else if (isset($_GET['tag']) && strlen(trim($_GET['tag'])) > 0) {
        $search_arguments['search_tag'] = trim($_GET['tag']);
    } else if (isset($_POST['search_string']) && strlen(trim($_POST['search_string'])) > 0) {
        $search_arguments['search_string'] = trim($_POST['search_string']);
    }

    if (isset($_POST['method']) && is_numeric($_POST['method'])) {
        $search_arguments['method'] = intval($_POST['method']);
    }

    if (isset($_POST['username']) && strlen(trim($_POST['username'])) > 0) {

        $search_arguments['username'] = trim($_POST['username']);

    } else if (isset($_GET['logon']) && strlen(trim($_GET['logon'])) > 0) {

        $search_arguments['username'] = trim($_GET['logon']);
        $search_arguments['user_include'] = SEARCH_FILTER_USER_POSTS;

        $search_arguments['date_from'] = SEARCH_FROM_BEGINNING_OF_TIME;
        $search_arguments['date_to'] = SEARCH_TO_TODAY;

        $search_arguments['sort_by'] = SEARCH_SORT_CREATED;
        $search_arguments['sort_dir'] = SEARCH_SORT_DESC;
    }

    if (isset($_POST['user_include']) && is_numeric($_POST['user_include'])) {
        $search_arguments['user_include'] = intval($_POST['user_include']);
    } else if (isset($_GET['user_include']) && is_numeric($_GET['user_include'])) {
        $search_arguments['user_include'] = intval($_GET['user_include']);
    }

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $search_arguments['fid'] = intval($_POST['fid']);
    }

    if (isset($_POST['date_from']) && is_numeric($_POST['date_from'])) {
        $search_arguments['date_from'] = intval($_POST['date_from']);
    }

    if (isset($_POST['date_to']) && is_numeric($_POST['date_to'])) {
        $search_arguments['date_to'] = intval($_POST['date_to']);
    }

    if (isset($_POST['sort_by']) && is_numeric($_POST['sort_by'])) {
        $search_arguments['sort_by'] = intval($_POST['sort_by']);
    }

    if (isset($_POST['sort_dir']) && is_numeric($_POST['sort_dir'])) {
        $search_arguments['sort_dir'] = intval($_POST['sort_dir']);
    }

    if (isset($_POST['group_by_thread']) && is_numeric($_POST['group_by_thread'])) {
        $search_arguments['group_by_thread'] = intval($_POST['group_by_thread']);
    }

    $error = SEARCH_NO_ERROR;

    if (($search_success = search_execute($search_arguments, $error)) !== false) {

        if (isset($_GET['search_string']) || isset($_GET['logon'])) {

            $redirect_uri = "index.php?webtag=$webtag&final_uri=discussion.php";
            $redirect_uri .= "%3Fwebtag%3D$webtag%26left%3Dsearch_results";

            header_redirect($redirect_uri);
            exit;
        }

    } else if (isset($_GET['search_string']) || isset($_GET['logon'])) {

        $redirect_uri = "index.php?webtag=$webtag&final_uri=discussion.php";
        $redirect_uri .= "%3Fwebtag%3D$webtag%26right%3Dsearch";
        $redirect_uri .= "%26search_error%3D$error";

        header_redirect($redirect_uri);
        exit;

    } else {

        switch ($error) {

            case SEARCH_NO_MATCHES:

                $search_no_matches = true;
                $valid = false;

                break;

            case SEARCH_USER_NOT_FOUND:

                $error_msg_array[] = gettext("The username you specified in the to or from field was not found.");
                $valid = false;

                break;

            case SEARCH_FREQUENCY_TOO_GREAT:

                $search_limit_count = forum_get_setting('search_limit_count', 'is_numeric', 1);
                $search_limit_time = forum_get_setting('search_limit_time', 'is_numeric', 30);
                $error_msg_array[] = sprintf(gettext("You can only perform %d search(es) every %s seconds."), $search_limit_count, $search_limit_time);
                break;

            case SEARCH_SPHINX_UNAVAILABLE:

                $error_msg_array[] = gettext("Search is currently unavailable. Please try again later.");
                break;
        }
    }

} else if (isset($_GET['page']) && is_numeric($_GET['page'])) {

    $page = intval($_GET['page']);

    if (($search_results_array = search_fetch_results($page, $sort_by, $sort_dir)) !== false) {

        html_draw_top(
            array(
                'js' => array(
                    'js/search.js',
                    'js/search_popup.js',
                    'js/thread_list.js'
                )
            )
        );

        thread_list_draw_top(SEARCH_RESULTS);

        echo "<br />\n";
        echo "<h1>", gettext("Search Results"), "</h1>\n";
        echo "", html_style_image('search', gettext("Found")), "&nbsp;", gettext("Found"), ": {$search_results_array['result_count']} ", gettext("matches"), "<br />\n";

        if ($page > 1) {
            echo "", html_style_image('current_thread', gettext("Previous page")), "&nbsp;<a href=\"search.php?webtag=$webtag&amp;page=", $page - 1, "&amp;sort_by=$sort_by&amp;sort_dir=$sort_dir\">", gettext("Previous page"), "</a>\n";
        }

        echo "<ol start=\"", (($page * 20) - 20) + 1, "\">\n";

        foreach ($search_results_array['result_array'] as $search_result) {

            if (($message = messages_get($search_result['TID'], $search_result['PID'], 1)) !== false) {

                if (($thread_data = thread_get($search_result['TID'])) !== false) {

                    $message['TITLE'] = trim($thread_data['TITLE']);

                    // Fetch the messaage content, strip the signature and remove HTML.
                    $message['CONTENT'] = message_get_content($search_result['TID'], $search_result['PID']);
                    $message['CONTENT'] = message_apply_formatting($message['CONTENT'], true);
                    $message['CONTENT'] = trim(strip_tags($message['CONTENT']));

                    // Limit thread title to 20 characters.
                    if (mb_strlen($message['TITLE']) > 20) {
                        $message['TITLE'] = word_filter_add_ob_tags(mb_substr($message['TITLE'], 0, 20), true) . "&hellip;";
                    } else {
                        $message['TITLE'] = word_filter_add_ob_tags($message['TITLE'], true);
                    }

                    // Limit displayed post content to 35 characters
                    if (mb_strlen($message['CONTENT']) > 70) {
                        $message['CONTENT'] = word_filter_add_ob_tags(fix_html(mb_substr($message['CONTENT'], 0, 70)), true) . "&hellip;";
                    } else {
                        $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT'], true);
                    }

                    if ((thread_is_poll($search_result['TID']) && $search_result['PID'] == 1) || strlen($message['CONTENT']) < 1) {

                        echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;hightlight=yes\" target=\"", html_get_frame_name('right'), "\"><b>{$message['TITLE']}</b></a><br />";
                        echo "<span><b>", gettext("From"), ":</b> ", word_filter_add_ob_tags(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME']), true), ", ", format_date_time($search_result['CREATED']), "</span></p></li>\n";

                    } else {

                        echo "  <li><p><a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;highlight=yes\" target=\"", html_get_frame_name('right'), "\"><b>{$message['TITLE']}</b></a><br />";
                        echo "{$message['CONTENT']}<br /><span><b>", gettext("From"), ":</b> ", word_filter_add_ob_tags(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME']), true), ", ", format_date_time($search_result['CREATED']), "</span></p></li>\n";
                    }
                }
            }
        }

        echo "</ol>\n";

        if (ceil($search_results_array['result_count'] / 20) > $page) {
            echo "", html_style_image('current_thread'), "&nbsp;<a href=\"search.php?webtag=$webtag&amp;page=", $page + 1, "&amp;sort_by=$sort_by&amp;sort_dir=$sort_dir\">", gettext("Find more"), "</a><br />\n";
        }

        echo "<br />\n";
        echo "<form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"search.php\" target=\"_self\">\n";
        echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden("page", isset($page) ? htmlentities_array($page) : 1), "\n";
        echo "  <table cellpadding=\"2\" cellspacing=\"0\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\" colspan=\"2\">", gettext("Sort Results"), ":</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "      <td align=\"left\" colspan=\"2\">", form_dropdown_array("sort_by", $search_sort_by_array, $sort_by), "</td>\n";
        echo "    </tr>\n";
        echo "     <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "      <td align=\"left\">", form_dropdown_array("sort_dir", $search_sort_dir_array, $sort_dir), "</td>\n";
        echo "      <td align=\"left\">", form_submit("go", gettext("Go!")) . "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "<br />\n";

    } else {

        html_draw_top(
            array(
                'js' => array(
                    'js/search.js',
                    'js/search_popup.js',
                    'js/thread_list.js'
                )
            )
        );

        thread_list_draw_top(SEARCH_RESULTS);

        echo "<br />\n";
        echo "<h1>", gettext("Error"), "</h1>\n";
        echo "", html_style_image('search'), "&nbsp;", gettext("Found"), ": 0 ", gettext("matches"), "<br /><br />\n";
    }

    echo "<table cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" colspan=\"2\">", gettext("Navigate"), ":</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"messages.php\" target=\"", html_get_frame_name('right'), "\">\n";
    echo "        ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "        ", form_input_text('msg', '1.1', 10) . "\n";
    echo "        ", form_submit("go", gettext("Go!")) . "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br />\n";
    echo "<table cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" colspan=\"2\">", gettext("Search Again"), " (<a href=\"search.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Advanced"), "</a>):</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">&nbsp;</td>\n";
    echo "    <td align=\"left\">\n";
    echo "      <form accept-charset=\"utf-8\" method=\"post\" action=\"search.php\" target=\"", html_get_frame_name('right'), "\">\n";
    echo "        ", form_csrf_token_field(), "\n";
    echo "        ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "        ", form_input_text("search_string", null, 20) . "\n";
    echo "        ", form_submit("search", gettext("Find")) . "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

    html_draw_bottom();
    exit;
}

html_draw_top(
    array(
        'js' => array(
            'js/search.js',
            'js/search_popup.js',
            'js/thread_list.js'
        )
    )
);

echo "<h1>", gettext("Search Messages"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '500', 'center');

} else if (isset($search_success) && $search_success) {

    $frame_target = html_get_frame_name('left');
    $results_link = sprintf("<a href=\"search.php?webtag=$webtag&amp;page=1&amp;sort_by=$sort_by&amp;sort_dir=$sort_dir\" target=\"$frame_target\">%s</a>", gettext("Click here to view results."));

    echo "<div id=\"search_success\">\n";
    html_display_success_msg(sprintf(gettext("Search successfully completed. %s"), $results_link), '500', 'center');
    echo "</div>\n";

} else if (isset($_GET['search_error']) && is_numeric($_GET['search_error'])) {

    $search_error = intval($_GET['search_error']);

    switch ($search_error) {

        case SEARCH_NO_MATCHES:

            html_display_warning_msg(gettext("Search Returned No Results"), '500', 'center');
            break;

        case SEARCH_USER_NOT_FOUND:

            html_display_error_msg(gettext("The username you specified in the to or from field was not found."), '500', 'center');
            break;

        case SEARCH_FREQUENCY_TOO_GREAT:

            $search_limit_count = forum_get_setting('search_limit_count', 'is_numeric', 1);
            $search_limit_time = forum_get_setting('search_limit_time', 'is_numeric', 30);
            html_display_error_msg(sprintf(gettext("You can only perform %d search(es) every %s seconds."), $search_limit_count, $search_limit_time));
            break;
    }

} else if (isset($search_no_matches) && $search_no_matches == true) {

    html_display_warning_msg(gettext("Search Returned No Results"), '500', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" id=\"search_form\" method=\"post\" action=\"search.php\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Search discussions"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"40%\">", gettext("Keywords"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text("search_string", (isset($search_arguments['search_string']) ? htmlentities_array($search_arguments['search_string']) : ''), 32, null, null, 'bhinputtext focus'), "&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Search by user (optional)"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"40%\">", gettext("Username"), ":</td>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search("username", (isset($search_arguments['username']) ? htmlentities_array($search_arguments['username']) : ''), 28, null, SEARCH_LOGON), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("user_include", SEARCH_FILTER_USER_POSTS, gettext("Posts from user"), ((isset($search_arguments['user_include']) && $search_arguments['user_include'] == SEARCH_FILTER_USER_POSTS) || (!isset($search_arguments['user_include'])))), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                        <td align=\"left\">", form_radio("user_include", SEARCH_FILTER_USER_THREADS, gettext("Threads started by user"), (isset($search_arguments['user_include']) && $search_arguments['user_include'] == SEARCH_FILTER_USER_THREADS)), "&nbsp;</td>\n";
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
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">", gettext("Additional Criteria"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"40%\">", gettext("Folder(s)"), ":</td>\n";
echo "                        <td align=\"left\">", $folder_dropdown, "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Posted from"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("date_from", $search_date_from_array, (isset($search_arguments['date_from']) && in_array($search_arguments['date_from'], array_keys($search_date_from_array)) ? $search_arguments['date_from'] : SEARCH_FROM_ONE_MONTH_AGO), null, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Posted to"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("date_to", $search_date_to_array, (isset($search_arguments['date_to']) && in_array($search_arguments['date_to'], array_keys($search_date_to_array)) ? $search_arguments['date_to'] : SEARCH_TO_TODAY), null, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Sort by"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("sort_by", $search_sort_by_array, (isset($search_arguments['sort_by']) && in_array($search_arguments['sort_by'], array_keys($search_sort_by_array)) ? $search_arguments['sort_by'] : SEARCH_SORT_CREATED), null, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">", gettext("Sort dir"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array("sort_dir", $search_sort_dir_array, (isset($search_arguments['sort_dir']) && in_array($search_arguments['sort_dir'], array_keys($search_sort_dir_array)) ? $search_arguments['sort_dir'] : SEARCH_SORT_DESC), null, "search_dropdown"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" style=\"white-space: nowrap\">", gettext("Group by thread"), ":</td>\n";
echo "                        <td align=\"left\">", form_radio("group_by_thread", SEARCH_GROUP_THREADS, gettext("Yes"), (isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_THREADS)), "&nbsp;", form_radio("group_by_thread", SEARCH_GROUP_NONE, gettext("No"), ((isset($search_arguments['group_by_thread']) && $search_arguments['group_by_thread'] == SEARCH_GROUP_NONE) || (!isset($search_arguments['group_by_thread'])))), "&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit('search_submit', gettext("Find")), "&nbsp;", form_submit('search_reset', gettext("Reset")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();