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
require_once 'lboot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'search.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
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

if (!$folder_dropdown = light_folder_search_dropdown($search_folder_fid)) {
    html_draw_error(gettext("There are no folders available."));
}

$min_length = 4;
$max_length = 84;

search_get_word_lengths($min_length, $max_length);

if (isset($_POST) && sizeof($_POST) > 0) {

    $page = 1;

    $search_arguments = array(
        'user_include' => SEARCH_FILTER_USER_POSTS,
    );

    $search_no_matches = false;

    if (isset($_POST['search_string']) && strlen(trim($_POST['search_string'])) > 0) {
        $search_arguments['search_string'] = trim($_POST['search_string']);
    }

    if (isset($_POST['username']) && strlen(trim($_POST['username'])) > 0) {
        $search_arguments['username'] = trim($_POST['username']);
    }

    if (isset($_POST['user_include']) && is_numeric($_POST['user_include'])) {
        $search_arguments['user_include'] = intval($_POST['user_include']);
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

    $error = SEARCH_NO_ERROR;

    if (!($search_success = search_execute($search_arguments, $error))) {

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

    } else {

        header_redirect("lsearch.php?webtag=$webtag&page=1");
        exit;
    }

} else if (isset($_GET['page']) && is_numeric($_GET['page'])) {

    $page = intval($_GET['page']);

    if (($search_results_array = search_fetch_results($page)) !== false) {

        light_html_draw_top();

        light_navigation_bar();

        light_thread_list_draw_top(SEARCH_RESULTS);

        if ($page > 1) {
            echo "<div class=\"search_pagination\"><a href=\"lsearch.php?webtag=$webtag&amp;page=", ($page - 1), "\">", gettext("Previous 20 results"), "</a></div>\n";
        } else {
            echo "<div class=\"search_pagination\">", gettext("Found"), ": {$search_results_array['result_count']} ", gettext("matches"), "</div>\n";
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

                        echo "  <li><p><a href=\"lmessages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;hightlight=yes\"><b>{$message['TITLE']}</b></a><br />";
                        echo "<span><b>", gettext("From"), ":</b> ", word_filter_add_ob_tags(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME']), true), ", ", format_date_time($search_result['CREATED']), "</span></p></li>\n";

                    } else {

                        echo "  <li><p><a href=\"lmessages.php?webtag=$webtag&amp;msg={$search_result['TID']}.{$search_result['PID']}&amp;highlight=yes\"><b>{$message['TITLE']}</b></a><br />";
                        echo "{$message['CONTENT']}<br /><span><b>", gettext("From"), ":</b> ", word_filter_add_ob_tags(format_user_name($search_result['FROM_LOGON'], $search_result['FROM_NICKNAME']), true), ", ", format_date_time($search_result['CREATED']), "</span></p></li>\n";
                    }
                }
            }
        }

        echo "</ol>\n";

        if (ceil($search_results_array['result_count'] / 20) > $page) {
            echo "<div class=\"search_pagination\"><a href=\"lsearch.php?webtag=$webtag&amp;page=", ($page + 1), "\">", gettext("Next 20 results"), "</a></div>\n";
        }

    } else {

        light_html_draw_top();

        light_navigation_bar();

        light_thread_list_draw_top(SEARCH_RESULTS);

        echo "", html_style_image('search'), "&nbsp;", gettext("Found"), ": 0 ", gettext("matches"), "<br /><br />\n";
    }

    light_html_draw_bottom();
    exit;
}

light_html_draw_top();

light_navigation_bar();

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    light_html_display_error_array($error_msg_array);

} else if (isset($search_no_matches) && $search_no_matches == true) {

    light_html_display_error_msg(gettext("Search Returned No Results"));
}

echo "<form accept-charset=\"utf-8\" id=\"search_form\" method=\"post\" action=\"lsearch.php\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "<div class=\"search\">\n";
echo "<h3>", gettext("Search discussions"), "</h3>\n";
echo "<div class=\"search_inner\">\n";
echo "<div class=\"search_keywords\">", gettext("Keywords"), ":", light_form_input_text("search_string", (isset($search_arguments['search_string']) ? htmlentities_array($search_arguments['search_string']) : ''), 30), "</div>\n";
echo "<div class=\"search_user\">", gettext("Username (optional)"), ":", light_form_input_text("username", (isset($search_arguments['username']) ? htmlentities_array($search_arguments['username']) : ''), 30), "</div>\n";
echo "<div class=\"search_folder\">", gettext("Folder(s)"), ":", $folder_dropdown, "</div>\n";
echo "<div class=\"search_date\">", gettext("Posted From"), ":", light_form_dropdown_array("date_from", $search_date_from_array, (isset($search_arguments['date_from']) && in_array($search_arguments['date_from'], array_keys($search_date_from_array)) ? $search_arguments['date_from'] : SEARCH_FROM_ONE_MONTH_AGO)), "</div>\n";
echo "<div class=\"search_date\">", gettext("Posted to"), ":", light_form_dropdown_array("date_to", $search_date_to_array, (isset($search_arguments['date_to']) && in_array($search_arguments['date_to'], array_keys($search_date_from_array)) ? $search_arguments['date_to'] : SEARCH_TO_TODAY)), "</div>\n";
echo "<div class=\"search_buttons\">", light_form_submit("search_submit", gettext("Find")), "</div>";
echo "</div>";
echo "</div>";
echo "</form>";

light_html_draw_bottom();