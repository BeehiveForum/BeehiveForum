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

// Required includes
require_once BH_INCLUDE_PATH. 'adsense.inc.php';
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'myforums.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'user_rel.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';
// End Required includes

function light_html_draw_top()
{
    static $called = false;

    if ($called) return;

    $called = true;

    $arg_array = func_get_args();

    $title = null;

    $robots = null;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $link_array = array();

    $func_matches = array();

    $forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

    foreach ($arg_array as $key => $func_args) {

        if (preg_match('/^title=(.+)?$/Disu', $func_args, $func_matches) > 0) {

            $title = (!isset($title) && isset($func_matches[1]) ? $func_matches[1] : $title);
            unset($arg_array[$key]);
        }

        if (preg_match('/^robots=(.+)?$/Disu', $func_args, $func_matches) > 0) {

            $robots = (!isset($robots) && isset($func_matches[1]) ? $func_matches[1] : $robots);
            unset($arg_array[$key]);
        }

        if (preg_match('/^link=([^:]+):(.+)$/Disu', $func_args, $func_matches) > 0) {

            $link_array[] = array(
                'rel' => $func_matches[1],
                'href' => $func_matches[2]
            );

            unset($arg_array[$key]);
        }
    }

    // Default Meta keywords and description.
    $meta_keywords = html_get_forum_keywords();
    $meta_description = html_get_forum_description();

    echo "<!DOCTYPE html>\n";
    echo "<html lang=\"en\" dir=\"", gettext("ltr"), "\">\n";
    echo "<head>\n";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        message_get_meta_content($_GET['msg'], $meta_keywords, $meta_description);

        list($tid, $pid) = explode('.', $_GET['msg']);

        if (($thread_data = thread_get($tid)) !== false) {

            $prev_page = ($pid - 10 > 0) ? $pid - 10 : 1;
            $next_page = ($pid + 10 < $thread_data['LENGTH']) ? $pid + 10 : $thread_data['LENGTH'];

            echo "<link rel=\"first\" href=\"", html_get_forum_file_path("index.php?webtag=$webtag&amp;msg=$tid.1"), "\" />\n";
            echo "<link rel=\"previous\" href=\"", html_get_forum_file_path("index.php?webtag=$webtag&amp;msg=$tid.{$thread_data['LENGTH']}"), "\" />\n";
            echo "<link rel=\"next\" href=\"", html_get_forum_file_path("index.php?webtag=$webtag&amp;msg=$tid.$next_page"), "\" />\n";
            echo "<link rel=\"last\" href=\"", html_get_forum_file_path("index.php?webtag=$webtag&amp;msg=$tid.$prev_page"), "\" />\n";

            echo "<title>", word_filter_add_ob_tags($thread_data['TITLE'], true), " - ", word_filter_add_ob_tags($forum_name, true), "</title>\n";

        } else if (isset($title)) {

            echo "<title>", word_filter_add_ob_tags($title, true), " - ", word_filter_add_ob_tags($forum_name, true), "</title>\n";

        } else {

            echo "<title>", word_filter_add_ob_tags($forum_name, true), "</title>\n";
        }

    } else if (isset($title)) {

        echo "<title>", word_filter_add_ob_tags($title, true), " - ", htmlentities_array($forum_name), "</title>\n";

    } else {

        echo "<title>", htmlentities_array($forum_name), "</title>\n";
    }

    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
    echo "<meta name=\"generator\" content=\"Beehive Forum ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"keywords\" content=\"", word_filter_add_ob_tags($meta_keywords, true), "\" />\n";
    echo "<meta name=\"description\" content=\"", word_filter_add_ob_tags($meta_description, true), "\" />\n";
    echo "<meta name=\"MobileOptimized\" content=\"0\" />\n";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\n";

    if (forum_get_setting('allow_search_spidering', 'N')) {

        echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";

    } else if (isset($robots)) {

        echo "<meta name=\"robots\" content=\"$robots\" />\n";
    }

    if (($stylesheet = html_get_style_sheet('mobile.css')) !== false) {
        html_include_css($stylesheet);
    }

    if (($emoticon_stylesheet = html_get_emoticon_style_sheet(true)) !== false) {
        html_include_css($emoticon_stylesheet, 'print, screen');
    }

    $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag");

    printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array(gettext("RSS Feed")), $rss_feed_path);

    if (($folders_array = folder_get_available_details()) !== false) {

        foreach ($folders_array as $folder) {

            $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag&amp;fid={$folder['FID']}");

            printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array($folder['TITLE']), htmlentities_array(gettext("RSS Feed")), $rss_feed_path);
        }
    }

    if (($user_style_path = html_get_user_style_path()) !== false) {

        printf("<link rel=\"apple-touch-icon\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-57x57.png', $user_style_path)));
        printf("<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-72x72.png', $user_style_path)));
        printf("<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-114x114.png', $user_style_path)));
        printf("<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-144x144.png', $user_style_path)));

        printf("<link rel=\"shortcut icon\" type=\"image/ico\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/favicon.ico', $user_style_path)));
    }

    html_include_javascript(html_get_forum_file_path('js/jquery.min.js'));
    html_include_javascript(html_get_forum_file_path('js/jquery.placeholder.min.js'));
    html_include_javascript(html_get_forum_file_path('js/jquery.sprintf.js'));
    html_include_javascript(html_get_forum_file_path('js/general.js'));
    html_include_javascript(html_get_forum_file_path('js/light.js'));

    $message_display_pages = array(
        'admin_post_approve.php',
        'create_poll.php',
        'delete.php',
        'display.php',
        'edit.php',
        'edit_poll.php',
        'edit_signature.php',
        'ldisplay.php',
        'lmessages.php',
        'lpost.php',
        'messages.php',
        'post.php'
    );

    if (in_array(basename($_SERVER['PHP_SELF']), $message_display_pages)) {

        if (isset($_SESSION['USE_MOVER_SPOILER']) && ($_SESSION['USE_MOVER_SPOILER'] == 'Y')) {

            html_include_javascript(html_get_forum_file_path('js/spoiler.js'));
        }
    }

    foreach ($arg_array as $func_args) {

        if (!($extension = pathinfo($func_args, PATHINFO_EXTENSION))) {
            continue;
        }

        switch ($extension) {

            case 'js':

                html_include_javascript(html_get_forum_file_path($func_args));
                break;

            case 'css':

                html_include_css(html_get_forum_file_path($func_args));
                break;
        }
    }

    html_include_javascript(html_get_forum_file_path("json.php?webtag=$webtag"));

    echo "</head>\n";
    echo "<body id=\"mobile\">\n";

    if ((forum_get_setting('show_share_links', 'Y')) && isset($_SESSION['SHOW_SHARE_LINKS']) && ($_SESSION['SHOW_SHARE_LINKS'] == 'Y')) {
        echo '<div id="fb-root"></div>';
    }

    echo "<a name=\"top\"></a>\n";
    echo "<div id=\"header\">\n";
    echo "  <img src=\"", html_style_image('mobile_logo.png'), "\" alt=\"", gettext("Beehive Forum Logo"), "\" />\n";
    echo "  <div id=\"nav\">", gettext("Menu"), "</div>\n";
    echo "</div>\n";
    echo "<div id=\"menu\">\n";
    echo "  <ul>\n";

    if (forums_get_available_count() > 1 || !forum_get_default()) {
        echo "    <li class=\"menu_item\"><a href=\"lforums.php?webtag=$webtag\">", gettext("My Forums"), "</a></li>\n";
    }

    echo "    <li class=\"menu_item\"><a href=\"lthread_list.php?webtag=$webtag\">", gettext("Messages"), "</a></li>\n";
    echo "    <li class=\"menu_item\"><a href=\"lpm.php?webtag=$webtag\">", gettext("Inbox"), "</a></li>\n";
    echo "    <li class=\"menu_item\"><a href=\"lsearch.php?webtag=$webtag\">", gettext("Search"), "</a></li>\n";

    if (!session::logged_in()) {
        echo "    <li class=\"menu_item\"><a href=\"llogon.php?webtag=$webtag\">", gettext("Login"), "</a></li>\n";
    } else {
        echo "    <li class=\"menu_item\"><a href=\"llogout.php?webtag=$webtag\">", gettext("Logout"), "</a></li>\n";
    }

    echo "  </ul>\n";
    echo "</div>\n";
    echo "<div id=\"page_content\">\n";

    light_pm_check_messages();

    if (html_output_adsense_settings() && adsense_check_user() && adsense_check_page()) {
        adsense_output_html();
    }
}

function light_html_draw_bottom()
{
    static $called = false;

    if ($called) return;

    $called = true;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "</div>\n";
    echo "<div id=\"footer\">\n";

    if (!session::is_search_engine()) {

        echo "  <div id=\"footer_links\">\n";
        echo "    <a href=\"#top\">", gettext("Top"), "</a> &middot; <a href=\"index.php?webtag=$webtag&amp;view=full\">", gettext("Desktop Version"), "</a>\n";
        echo "  </div>\n";
    }

    echo "  <h6><a href=\"http://www.beehiveforum.co.uk/\" target=\"_blank\">Beehive Forum ", BEEHIVE_VERSION, "<br />&copy; ", strftime('%Y'), " Project Beehive Forum</a></h6>\n";
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
}

function light_draw_logon_form($error_msg_array = array())
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (isset($_GET['logout_success']) && $_GET['logout_success'] == 'true') {
        light_html_display_success_msg(gettext("You have successfully logged out."));
    } else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        light_html_display_error_array($error_msg_array);
    }

    $username_array = array();
    $password_array = array();
    $passhash_array = array();

    echo "<div class=\"logon\">\n";
    echo "<h3>", gettext("Logon"), "</h3>\n";
    echo "<div class=\"logon_inner\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"logonform\" action=\"llogon.php\" method=\"post\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  <div class=\"logon_username\"><span>", gettext("Username"), ":</span>", light_form_input_text("user_logon", (isset($username_array[0]) ? htmlentities_array($username_array[0]) : ""), 20, 15, ''). "</div>\n";

    if (isset($password_array[0]) && strlen($password_array[0]) > 0) {

        if (isset($passhash_array[0]) && is_md5($passhash_array[0])) {
            echo "  <div class=\"logon_password\"><span>", gettext("Password"), ":</span>", light_form_input_password("user_password", htmlentities_array($password_array[0]), 20, 32, ''), form_input_hidden("user_passhash", htmlentities_array($passhash_array[0])), "</div>\n";
        } else {
            echo "  <div class=\"logon_password\"><span>", gettext("Password"), ":</span>", light_form_input_password("user_password", "", 20, 32, ''), form_input_hidden("user_passhash", ""), "</div>\n";
        }

    } else {

        echo "  <div class=\"logon_password\"><span>", gettext("Password"), ":</span>", light_form_input_password("user_password", "", 20, 32, ''), form_input_hidden("user_passhash", ""), "</div>\n";
    }

    echo "  <div class=\"logon_remember\">", light_form_checkbox("user_remember", "Y", gettext("Remember me"), false, ''), "</div>\n";
    echo "  <div class=\"logon_buttons\">", light_form_submit('logon', gettext("Logon")), "</div>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "</div>\n";
}

function light_draw_messages($tid, $pid)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!$thread_data = thread_get($tid, session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        return;
    }

    if (!folder_get($thread_data['FID'])) {

        light_html_display_error_msg(gettext("The requested folder could not be found or access was denied."));
        return;
    }

    if (!$messages = messages_get($tid, $pid, 10)) {

        light_html_display_error_msg(gettext("That post does not exist in this thread!"));
        return;
    }

    $msg_count = count($messages);

    light_messages_top($tid, $pid, $thread_data['TITLE'], $thread_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'));

    if (($tracking_data_array = thread_get_tracking_data($tid)) !== false) {

        foreach ($tracking_data_array as $tracking_data) {

            if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_MERGE) { // Thread merged

                if ($tracking_data['TID'] == $tid) {

                    $thread_link = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], gettext("here"));

                    light_html_display_warning_msg(sprintf(gettext("<b>Threads Merged:</b> This thread has moved %s"), $thread_link));
                }

                if ($tracking_data['NEW_TID'] == $tid) {

                    $thread_link = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['TID'], gettext("here"));

                    light_html_display_warning_msg(sprintf(gettext("<b>Threads Merged:</b> This thread was merged from %s"), $thread_link));
                }

            } else if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_SPLIT) { // Thread Split

                if ($tracking_data['TID'] == $tid) {

                    $thread_link = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], gettext("here"));

                    light_html_display_warning_msg(sprintf(gettext("<b>Thread Split:</b> Some posts in this thread have been moved %s"), $thread_link));
                }

                if ($tracking_data['NEW_TID'] == $tid) {

                    $thread_link = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['TID'], gettext("here"));

                    light_html_display_warning_msg(sprintf(gettext("<b>Thread Split:</b> Some posts in this thread were moved from %s"), $thread_link));
                }
            }
        }
    }

    if ($msg_count > 0) {

        foreach ($messages as $message_number => $message) {

            if (isset($message['RELATIONSHIP'])) {

                if ($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                    $message['CONTENT'] = message_get_content($tid, $message['PID']);
                } else {
                    $message['CONTENT'] = gettext("Ignored"); // must be set to something or will show as deleted
                }

            } else {

              $message['CONTENT'] = message_get_content($tid, $message['PID']);

            }

            if ($thread_data['POLL_FLAG'] == 'Y') {

                if ($message['PID'] == 1) {

                    light_poll_display($tid, $thread_data['LENGTH'], $thread_data['FID'], true, $thread_data['CLOSED'], false, false);
                    $last_pid = $message['PID'];

                } else {

                    light_message_display($tid, $message, $thread_data['LENGTH'], $pid, $thread_data['FID'], true, $thread_data['CLOSED'], true, true, false);
                    $last_pid = $message['PID'];
                }

            } else {

                light_message_display($tid, $message, $thread_data['LENGTH'], $pid, $thread_data['FID'], true, $thread_data['CLOSED'], true, false, false);
                $last_pid = $message['PID'];
            }

            if (adsense_check_user() && adsense_check_page($message_number, 10, $thread_data['LENGTH'])) {

                adsense_output_html();
            }
        }
    }

    unset($messages, $message);

    echo "<div class=\"message_page_footer\">\n";
    echo "<ul>\n";

    if (($thread_data['CLOSED'] == 0 && session::check_perm(USER_PERM_POST_CREATE, $thread_data['FID'])) || session::check_perm(USER_PERM_FOLDER_MODERATE, $thread_data['FID'])) {
        echo "<li><a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.0\" class=\"reply_all\">", gettext("Reply to All"), "</a></li>\n";
    }

    if ($last_pid < $thread_data['LENGTH']) {

        $npid = $last_pid + 1;
        echo "<li class=\"right_col\">", light_form_quick_button("lmessages.php", gettext("Keep reading&hellip;"), array('msg' => "$tid.$npid")), "</li>\n";
    }

    echo "</ul>\n";
    echo "</div>\n";

    echo "<a href=\"lthread_list.php?webtag=$webtag\" class=\"thread_list_link\">", gettext("Back to thread list"), "</a>";

    light_messages_nav_strip($tid, $pid, $thread_data['LENGTH'], 10);

    if (($msg_count > 0 && session::logged_in())) {
        messages_update_read($tid, $last_pid, $thread_data['LAST_READ'], $thread_data['LENGTH'], $thread_data['MODIFIED']);
    }
}

function light_draw_thread_list($mode = ALL_DISCUSSIONS, $folder = false, $page = 1)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $error_msg_array = array();

    $available_views = thread_list_available_views();

    $visible_threads_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    light_thread_list_draw_top($mode, $folder);

    switch ($mode) {

        case UNREAD_DISCUSSIONS:

            list($thread_info, $folder_order, $thread_count) = threads_get_unread($_SESSION['UID'], $folder, $page);
            break;

        case UNREAD_DISCUSSIONS_TO_ME:

            list($thread_info, $folder_order, $thread_count) = threads_get_unread_to_me($_SESSION['UID'], $folder, $page);
            break;

        case TODAYS_DISCUSSIONS:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_days($_SESSION['UID'], $folder, $page, 1);
            break;

        case UNREAD_TODAY:

            list($thread_info, $folder_order, $thread_count) = threads_get_unread_by_days($_SESSION['UID'], $folder, $page);
            break;

        case TWO_DAYS_BACK:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_days($_SESSION['UID'], $folder, $page, 2);
            break;

        case SEVEN_DAYS_BACK:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_days($_SESSION['UID'], $folder, $page, 7);
            break;

        case HIGH_INTEREST:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_interest($_SESSION['UID'], $folder, $page, THREAD_INTERESTED);
            break;

        case UNREAD_HIGH_INTEREST:

            list($thread_info, $folder_order, $thread_count) = threads_get_unread_by_interest($_SESSION['UID'], $folder, $page, THREAD_INTERESTED);
            break;

        case RECENTLY_SEEN:

            list($thread_info, $folder_order, $thread_count) = threads_get_recently_viewed($_SESSION['UID'], $folder, $page);
            break;

        case IGNORED_THREADS:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_interest($_SESSION['UID'], $folder, $page, THREAD_IGNORED);
            break;

        case BY_IGNORED_USERS:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_relationship($_SESSION['UID'], $folder, $page, USER_IGNORED_COMPLETELY);
            break;

        case SUBSCRIBED_TO:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_interest($_SESSION['UID'], $folder, $page, THREAD_SUBSCRIBED);
            break;

        case STARTED_BY_FRIEND:

            list($thread_info, $folder_order, $thread_count) = threads_get_by_relationship($_SESSION['UID'], $folder, $page, USER_FRIEND);
            break;

        case UNREAD_STARTED_BY_FRIEND:

            list($thread_info, $folder_order, $thread_count) = threads_get_unread_by_relationship($_SESSION['UID'], $folder, $page, USER_FRIEND);
            break;

        case STARTED_BY_ME:

            list($thread_info, $folder_order, $thread_count) = threads_get_started_by_me($_SESSION['UID'], $folder, $page);
            break;

        case POLL_THREADS:

            list($thread_info, $folder_order, $thread_count) = threads_get_polls($_SESSION['UID'], $folder, $page);
            break;

        case STICKY_THREADS:

            list($thread_info, $folder_order, $thread_count) = threads_get_sticky($_SESSION['UID'], $folder, $page);
            break;

        case MOST_UNREAD_POSTS:

            list($thread_info, $folder_order, $thread_count) = threads_get_longest_unread($_SESSION['UID'], $folder, $page);
            break;

        case DELETED_THREADS:

            list($thread_info, $folder_order, $thread_count) = threads_get_deleted($_SESSION['UID'], $folder, $page);
            break;

        default:

            list($thread_info, $folder_order, $thread_count) = threads_get_all($_SESSION['UID'], $folder, $page);
            break;
    }

    // Now, the actual bit that displays the threads...
    // Get folder FIDs and titles
    if (!$folder_info = threads_get_folders()) {

        light_html_display_error_msg(gettext("There are no folders available."));
        return;
    }

    // Get total number of messages for each folder
    $folder_msgs = threads_get_folder_msgs();

    // Check that the folder order is a valid array.
    if (!is_array($folder_order)) $folder_order = array();

    // Check the folder display order.
    if (isset($_SESSION['THREADS_BY_FOLDER']) && ($_SESSION['THREADS_BY_FOLDER'] == 'Y')) {
        $folder_order = array_keys($folder_info);
    }

    // Check for a message to display and re-order the thread list.
    if (isset($_REQUEST['msg']) && validate_msg($_REQUEST['msg'])) {

        list($selected_tid) = explode('.', $_REQUEST['msg']);

        if (($thread = thread_get($selected_tid)) !== false) {

            if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

            // Check the folder display order / user is a guest.
            if (!isset($_SESSION['THREADS_BY_FOLDER']) || $_SESSION['THREADS_BY_FOLDER'] != 'Y' || !session::logged_in()) {

                // Remove the folder from the list of folders.
                if (in_array($thread['FID'], $folder_order)) {
                    array_splice($folder_order, array_search($thread['FID'], $folder_order), 1);
                }

                // Re-add it at the top of the list.
                array_unshift($folder_order, $thread['FID']);
            }

            // Check $thread_info is an array.
            if (!is_array($thread_info)) $thread_info = array();

            // Check to see if the thread is already in the list.
            // If it is remove it, otherwise take the last thread
            // off the list so we always only have 50 threads on display.
            if (isset($thread_info[$selected_tid])) {
                unset($thread_info[$selected_tid]);
            } else {
                $thread_info = array_slice($thread_info, 0, 50, true);
            }

            // Add the requested thread to the top of the list of threads.
            array_unshift($thread_info, $thread);
        }
    }

    // Check for a specified folder and move it to the top of the thread list.
    if (isset($folder) && is_numeric($folder)) {

        if (in_array($folder, $folder_order)) {
            array_splice($folder_order, array_search($folder, $folder_order), 1);
        }

        array_unshift($folder_order, $folder);
    }

    if ($_SESSION['UID'] > 0) {

        // Array to hold our ignored folders in.
        $ignored_folders = array();

        // Loop through the list of folders and check their status.
        // If they're ignored and not already set to be on display
        // they need to be added to $ignored_folders so that they
        // appear at the bottom of the thread list.
        foreach ($folder_info as $fid => $folder_data) {

            if (!in_array($fid, $folder_order) && !in_array($fid, $ignored_folders)) {

                if ($folder_data['INTEREST'] != FOLDER_IGNORED || (isset($folder) && $folder == $fid)) {
                    array_push($folder_order, $fid);
                } else {
                    array_push($ignored_folders, $fid);
                }
            }
        }

        // Append ignored folders onto the end of the folder list.
        // This will make them appear at the bottom of the thread list.
        $folder_order = array_merge($folder_order, $ignored_folders);

    } else {

        foreach ($folder_info as $fid => $folder_data) {
            if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
        }
    }

    // If no threads are returned, say something to that effect
    if (isset($_REQUEST['mark_read_success'])) {

        light_html_display_success_msg(gettext("Successfully marked selected threads as read"), '100%', 'left');

    } else if (!is_array($thread_info)) {

        if (is_numeric($folder) && ($folder_title = folder_get_title($folder))) {

            $all_discussions_link = sprintf("<a href=\"lthread_list.php?webtag=$webtag&amp;folder=$folder&amp;mode=0\">%s</a>", gettext("click here"));
            light_html_display_warning_msg(sprintf(gettext("No &quot;%s&quot; in &quot;%s&quot; folder. Please select another folder, or %s for all threads."), $available_views[$mode], $folder_title, $all_discussions_link), '100%', 'left');

        } else {

            $all_discussions_link = sprintf("<a href=\"lthread_list.php?webtag=$webtag&amp;mode=0\">%s</a>", gettext("click here"));
            light_html_display_warning_msg(sprintf(gettext("No &quot;%s&quot; available. Please %s for all threads."), $available_views[$mode], $all_discussions_link), '100%', 'left');
        }

    } else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        light_html_display_error_array($error_msg_array, '100%', 'left');

    } else if (is_numeric($folder) && ($folder_title = folder_get_title($folder))) {

        $all_folders_link = sprintf("<a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode\">%s</a>", gettext("click here"));
        light_html_display_warning_msg(sprintf(gettext("Viewing &quot;%s&quot; in &quot;%s&quot; only. To view threads in all folders %s."), $available_views[$mode], $folder_title, $all_folders_link), '100%', 'left');
    }

    if (($page > 1) && !is_numeric($folder)) {
        echo "<div class=\"thread_pagination\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;page=", ($page - 1), "\">", gettext("Previous 50 threads"), "</a></div>\n";
    }

    // Iterate through the information we've just got and display it in the right order
    foreach ($folder_order as $folder_number) {

        if (isset($folder_info[$folder_number]) && is_array($folder_info[$folder_number])) {

            echo "<div class=\"folder\">\n";
            echo "  <h3><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder_number\">", word_filter_add_ob_tags($folder_info[$folder_number]['TITLE'], true), "</a></h3>";
            echo "  <div class=\"folder_inner\">\n";

            if ((!session::logged_in()) || ($folder_info[$folder_number]['INTEREST'] > FOLDER_IGNORED) || ($mode == UNREAD_DISCUSSIONS_TO_ME) || (isset($folder) && $folder == $folder_number)) {

                if (is_array($thread_info)) {

                    echo "  <div class=\"folder_info\">";

                    if (isset($folder_msgs[$folder_number])) {
                        echo $folder_msgs[$folder_number];
                    } else {
                        echo "0";
                    }

                    echo " ", gettext("threads"), "";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        if ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) {
                            echo "<span><a href=\"lpost.php?webtag=$webtag&amp;fid=$folder_number\">", gettext("Post New"), "</a></span>";
                        }
                    }

                    echo "  </div>\n";

                    if (($page > 1) && is_numeric($folder) && ($folder_number == $folder)) {
                        echo "<div class=\"folder_pagination\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder&amp;page=", ($page - 1), "\">", gettext("Previous 50 threads"), "</a></div>\n";
                    }

                    $folder_list_start = false;
                    $folder_list_end   = false;

                    foreach ($thread_info as $thread) {

                        if (!in_array($thread['TID'], $visible_threads_array)) $visible_threads_array[] = $thread['TID'];

                        if ($thread['FID'] == $folder_number) {

                            if ($folder_list_start === false) {

                                echo "<ul>\n";
                                $folder_list_start = true;
                            }

                            echo "<li>\n";

                            if ($thread['LAST_READ'] == 0) {

                                $number = "[{$thread['LENGTH']}&nbsp;new]";
                                $latest_post = 1;

                            } else if ($thread['LAST_READ'] < $thread['LENGTH']) {

                                $new_posts = $thread['LENGTH'] - $thread['LAST_READ'];
                                $number = "[{$new_posts}&nbsp;new&nbsp;of&nbsp;{$thread['LENGTH']}]";
                                $latest_post = $thread['LAST_READ'] + 1;

                            } else {

                                $number = "[{$thread['LENGTH']}]";
                                $latest_post = 1;

                            }

                            // work out how long ago the thread was posted and format the time to display
                            $thread_time = format_time($thread['MODIFIED']);

                            echo "<span class=\"thread_title\">";
                            echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg={$thread['TID']}.$latest_post\" ";
                            echo "title=\"", sprintf(gettext("Thread #%s Started by %s. Viewed %s"), $thread['TID'], word_filter_add_ob_tags(format_user_name($thread['LOGON'], $thread['NICKNAME']), true), ($thread['VIEWCOUNT'] == 1) ? gettext("1 time") : sprintf(gettext("%d times"), $thread['VIEWCOUNT'])), "\">";
                            echo word_filter_add_ob_tags($thread['TITLE'], true), "</a> ";

                            echo "<span class=\"thread_detail\">";

                            if (isset($thread['INTEREST']) && $thread['INTEREST'] == THREAD_INTERESTED) echo "<span class=\"thread_high_interest\" title=\"", gettext("High Interest"), "\">[H]</span>";
                            if (isset($thread['INTEREST']) && $thread['INTEREST'] == THREAD_SUBSCRIBED) echo "<span class=\"thread_subscribed\" title=\"", gettext("Subscribed"), "\">[S]</span>";
                            if (isset($thread['POLL_FLAG']) && $thread['POLL_FLAG'] == 'Y') echo "<span class=\"thread_poll\" title=\"", gettext("Poll"), "\">[P]</span>";
                            if (isset($thread['STICKY']) && $thread['STICKY'] == 'Y') echo "<span class=\"thread_sticky\" title=\"", gettext("Sticky"), "\">[ST]</span>";
                            if (isset($thread['RELATIONSHIP']) && $thread['RELATIONSHIP'] & USER_FRIEND) echo "<span class=\"thread_friend\" title=\"", gettext("Friend"), "\">[F]</span>";
                            if (isset($thread['TRACK_TYPE']) && $thread['TRACK_TYPE'] == THREAD_TYPE_SPLIT) echo "<span class=\"thread_split\" title=\"", gettext("Thread has been split"), "\">[TS]</span>";
                            if (isset($thread['TRACK_TYPE']) && $thread['TRACK_TYPE'] == THREAD_TYPE_MERGE) echo "<span class=\"thread_merge\" title=\"", gettext("Thread has been merged"), "\">[TM]</span>";
                            if (isset($thread['ATTACHMENT_COUNT']) && $thread['ATTACHMENT_COUNT'] > 0) echo "<span class=\"thread_attachment\" title=\"", gettext("Attachment"), "\">[A]</span>";

                            echo "<span class=\"thread_length\">$number</span>";
                            echo "</span>";
                            echo "</span>";

                            echo "<span class=\"thread_time\">$thread_time</span>";
                            echo "</li>\n";
                        }
                    }

                    if ($folder_list_end === false && $folder_list_start === true) {

                        echo "</ul>\n";
                        $folder_list_end = true;
                    }

                    if (is_numeric($folder) && ($folder_number == $folder) && ($thread_count >= 50)) {
                        echo "<div class=\"folder_pagination\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder&amp;page=", ($page + 1), "\">", gettext("Next 50 threads"), "</a></div>\n";
                    }

                } else if ($folder_info[$folder_number]['INTEREST'] != FOLDER_IGNORED) {

                    echo "<div class=\"folder_info\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder_number\">";

                    if (isset($folder_msgs[$folder_number])) {
                        echo $folder_msgs[$folder_number];
                    } else {
                        echo "0";
                    }

                    echo " ", gettext("threads"), "</a>";

                    if ($folder_info[$folder_number]['ALLOWED_TYPES']&FOLDER_ALLOW_NORMAL_THREAD) {
                        echo "<span><a href=\"lpost.php?webtag=$webtag&amp;fid=$folder_number\">", gettext("Post New"), "</a></span>";
                    }

                    echo "</div>\n";
                }
            }

            echo "  </div>\n";
            echo "</div>\n";

            if (is_array($thread_info)) reset($thread_info);
        }
    }

    if (!is_numeric($folder) && ($thread_count >= 50)) {
        echo "<div class=\"thread_pagination\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;page=", ($page + 1), "\">", gettext("Next 50 threads"), "</a></div>\n";
    }

    if (session::logged_in()) {

        echo "<div id=\"thread_mark_read\">\n";
        echo "<h3>", gettext("Mark as Read"), "</h3>\n";
        echo "<form accept-charset=\"utf-8\" name=\"f_mark\" method=\"post\" action=\"lthread_list.php\">\n";

        echo form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
        echo form_input_hidden("mode", htmlentities_array($mode)), "\n";
        echo form_input_hidden("page", htmlentities_array($page)), "\n";
        echo form_input_hidden("mark_read_confirm", 'N'), "\n";

        $labels = array(
            gettext("All Discussions"),
            gettext("Next 50 discussions")
        );

        $selected_option = THREAD_MARK_READ_ALL;

        if (sizeof($visible_threads_array) > 0) {

            $labels[] = gettext("Visible discussions");
            $selected_option = THREAD_MARK_READ_VISIBLE;

            $visible_threads = implode(',', array_filter($visible_threads_array, 'is_numeric'));
            echo form_input_hidden("mark_read_threads", htmlentities_array($visible_threads)), "\n";
        }

        if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo form_input_hidden('folder', htmlentities_array($folder)), "\n";

            $labels[] = gettext("Selected folder");
            $selected_option = THREAD_MARK_READ_FOLDER;
        }

        echo "<ul>\n";
        echo "<li>", light_form_dropdown_array("mark_read_type", $labels, $selected_option), "</li>\n";
        echo "<li class=\"right_col\">", light_form_submit("mark_read_submit", gettext("Go!")), "</li>\n";
        echo "</ul>\n";
        echo "</form>\n";
        echo "</div>\n";
    }
}

function light_thread_list_draw_top($mode, $folder = null)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "<div id=\"thread_view\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"lthread_list.php\">\n";

    echo form_input_hidden("webtag", htmlentities_array($webtag));

    if (is_numeric($folder) && in_array($folder, folder_get_available_array())) {
        echo form_input_hidden('folder', htmlentities_array($folder)), "\n";
    }

    echo "<ul>\n";
    echo "<li>", light_threads_draw_discussions_dropdown($mode), "</li>\n";

    echo "<li class=\"right_col\">", light_form_submit("go", gettext("Go!")), "</li>\n";
    echo "</ul>\n";
    echo "</form>\n";
    echo "</div>\n";
}

function light_draw_pm_inbox()
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $new_count = 0;
    $outbox_count = 0;
    $unread_count = 0;

    $current_folder = PM_FOLDER_INBOX;

    pm_get_message_count($new_count, $outbox_count, $unread_count);

    $error_msg_array = array();

    if (!($folder_names_array = pm_get_folder_names())) {

        $folder_names_array = array(
            PM_FOLDER_INBOX => gettext("Inbox"),
            PM_FOLDER_SENT => gettext("Sent Items"),
            PM_FOLDER_OUTBOX => gettext("Outbox"),
            PM_FOLDER_SAVED => gettext("Saved Items"),
            PM_FOLDER_DRAFTS => gettext("Drafts")
        );
    }

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
    } else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
        $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
    } else {
        $page = 1;
    }

    if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

        $mid = ($_GET['mid'] > 0) ? $_GET['mid'] : 0;

    } else if (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

        $mid = ($_POST['mid'] > 0) ? $_POST['mid'] : 0;

    } else {

        $mid = 0;
    }

    if (isset($_GET['folder'])) {

        if ($_GET['folder'] == PM_FOLDER_INBOX) {
            $current_folder = PM_FOLDER_INBOX;
        } else if ($_GET['folder'] == PM_FOLDER_SENT) {
            $current_folder = PM_FOLDER_SENT;
        } else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
            $current_folder = PM_FOLDER_OUTBOX;
        } else if ($_GET['folder'] == PM_FOLDER_SAVED) {
            $current_folder = PM_FOLDER_SAVED;
        } else if ($_GET['folder'] == PM_FOLDER_DRAFTS) {
            $current_folder = PM_FOLDER_DRAFTS;
        } else if ($_GET['folder'] == PM_SEARCH_RESULTS) {
            $current_folder = PM_SEARCH_RESULTS;
        }

    } else if (isset($_POST['folder'])) {

        if ($_POST['folder'] == PM_FOLDER_INBOX) {
            $current_folder = PM_FOLDER_INBOX;
        } else if ($_POST['folder'] == PM_FOLDER_SENT) {
            $current_folder = PM_FOLDER_SENT;
        } else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
            $current_folder = PM_FOLDER_OUTBOX;
        } else if ($_POST['folder'] == PM_FOLDER_SAVED) {
            $current_folder = PM_FOLDER_SAVED;
        } else if ($_POST['folder'] == PM_FOLDER_DRAFTS) {
            $current_folder = PM_FOLDER_DRAFTS;
        } else if ($_POST['folder'] == PM_SEARCH_RESULTS) {
            $current_folder = PM_SEARCH_RESULTS;
        }
    }

    if (isset($_GET['delete_msg']) && is_numeric($_GET['delete_msg']) && ($message_data = pm_message_get($_GET['delete_msg']))) {

        $delete_mid = $_GET['delete_msg'];

        $type = pm_get_folder_type($current_folder);

        $message_data['CONTENT'] = pm_get_content($delete_mid);

        if (isset($_POST['pm_delete_confirm'])) {

            if (pm_delete_message($delete_mid, $type)) {

                header_redirect("lpm.php?webtag=$webtag&folder=$current_folder&deleted=true");
                exit;
            }

        } else if (isset($_POST['cancel'])) {

            header_redirect("lpm.php?webtag=$webtag&folder=$current_folder&mid=$delete_mid");
            exit;
        }

        echo "<form method=\"post\" action=\"lpm.php?delete_msg=$delete_mid&folder=$current_folder\">";

        light_pm_display($message_data, true);

        echo "<div class=\"post_buttons\">";
        echo light_form_submit("pm_delete_confirm", gettext("Delete"));
        echo light_form_submit("cancel", gettext("Cancel"));
        echo "</div>\n";

        return;
    }

    if (isset($mid) && is_numeric($mid) && $mid > 0) {

        if (!($message_data = pm_message_get($mid))) {

            light_html_display_error_msg(gettext("Message not found. Check that it hasn't been deleted."));

        } else {

            if (isset($_GET['message_sent'])) {
                light_html_display_success_msg(gettext("Message sent successfully."));
            } else if (isset($_GET['deleted'])) {
                light_html_display_success_msg(gettext("Successfully deleted selected messages"));
            } else if (isset($_GET['message_saved'])) {
                light_html_display_success_msg(gettext("Message was successfully saved to 'Drafts' folder"));
            }

            $message_data['CONTENT'] = pm_get_content($mid);

            light_pm_display($message_data);

            if (($current_folder == PM_FOLDER_INBOX) && ($message_data['TYPE'] == PM_UNREAD)) {
                pm_mark_as_read($mid);
            }
        }

        echo "<a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder\" class=\"folder_list_link\">", gettext("Back to folder list"), "</a>";

    } else {

        if (isset($_GET['message_sent'])) {
            light_html_display_success_msg(gettext("Message sent successfully."));
        } else if (isset($_GET['deleted'])) {
            light_html_display_success_msg(gettext("Successfully deleted selected messages"));
        } else if (isset($_GET['message_saved'])) {
            light_html_display_success_msg(gettext("Message was successfully saved to 'Drafts' folder"));
        }

        $message_count_array = pm_get_folder_message_counts();

        echo "<div id=\"folder_view\">\n";
        echo "<form accept-charset=\"utf-8\" method=\"get\" action=\"lpm.php\">\n";
        echo "<ul>\n";
        echo "<li>", light_form_dropdown_array("folder", $folder_names_array, $current_folder), "</li>\n";
        echo "<li class=\"right_col\">", light_form_submit("go", gettext("Go!")), "</li>\n";
        echo "</ul>\n";
        echo "</form>\n";
        echo "</div>\n";

        if (isset($message_count_array[$current_folder]) && is_numeric($message_count_array[$current_folder])) {

            echo "<div class=\"folder\">";
            echo "  <h3>{$folder_names_array[$current_folder]}</h3>\n";
            echo "  <div class=\"folder_inner\">\n";
            echo "    <div class=\"folder_info\">{$message_count_array[$current_folder]} ", gettext("Messages"), "</div>\n";

            if ($current_folder == PM_FOLDER_INBOX) {

                $messages_array = pm_get_inbox(false, false, $page, 20);

            } else if ($current_folder == PM_FOLDER_SENT) {

                $messages_array = pm_get_sent(false, false, $page, 20);

            } else if ($current_folder == PM_FOLDER_OUTBOX) {

                $messages_array = pm_get_outbox(false, false, $page, 20);

            } else if ($current_folder == PM_FOLDER_SAVED) {

                $messages_array = pm_get_saved_items(false, false, $page, 20);

            } else if ($current_folder == PM_FOLDER_DRAFTS) {

                $messages_array = pm_get_drafts(false, false, $page, 20);
            }

            if (isset($messages_array['message_array']) && sizeof($messages_array['message_array']) > 0) {

                if ($page> 1) {
                    echo "<div class=\"folder_pagination\"><a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;page=", ($page - 1), "\">", gettext("Previous"), "</a></div>\n";
                }

                echo "<ul>\n";

                foreach ($messages_array['message_array'] as $message) {

                    if ($message['TYPE'] == PM_UNREAD) {
                        echo "<li class=\"pm_unread\">";
                    } else {
                        echo "<li class=\"pm_read\">";
                    }

                    echo "<span class=\"pm_title\">";
                    echo "<a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}\">{$message['SUBJECT']}</a>";
                    echo "</span>";
                    echo "<span class=\"pm_time\">", format_time($message['CREATED']), "</span>";
                    echo "</li>\n";
                }

                echo "</ul>\n";

                $more_messages = $message_count_array[$current_folder] - $page - 1;

                if ($more_messages > 0) {
                    echo "<div class=\"folder_pagination\"><a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;page=", ($page + 1), "\">", gettext("Next"), "</a></div>\n";
                }
            }

            echo "  </div>\n";
            echo "</div>\n";
        }

        echo "<a href=\"lpm_write.php?webtag=$webtag\" class=\"pm_send_new\">", gettext("Send New PM"), "</a>\n";

        $free_space = pm_get_free_space($_SESSION['UID']);

        $max_user_messages = forum_get_setting('pm_max_user_messages', null, 100);

        $used_percent = (100 / $max_user_messages) * ($max_user_messages - $free_space);

        echo "<div class=\"pm_bar\">\n";
        echo "<div class=\"pm_bar_inner\" style=\"width: {$used_percent}%\"></div>\n";
        echo "</div>\n";

        echo "<div class=\"pm_folder_usage\">", sprintf(gettext("Your PM folders are %s full"), "$used_percent%"), "</div>\n";

        if (pm_auto_prune_enabled()) {
            light_html_display_warning_msg(gettext("PM Folder pruning is enabled!"));
        }
    }
}

function light_draw_my_forums()
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    if (isset($_GET['webtag_error']) && strlen(trim($_GET['webtag_error'])) > 0) {
        light_html_display_error_msg(gettext("Invalid forum or forum is not available"));
    }

    if (session::logged_in()) {

        $forums_array = get_my_forums(FORUMS_SHOW_ALL, $page);

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) > 0) {

            foreach ($forums_array['forums_array'] as $forum) {

                echo "<div class=\"forum\">\n";
                echo "<h3><a href=\"lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";
                echo "<div class=\"forum_inner\">\n";
                echo "<div class=\"forum_info\">", $forum['FORUM_DESC'], "</div>";
                echo "<ul>\n";
                echo "<li>\n";
                echo "<span class=\"forum_messages\">";

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                        echo sprintf(gettext("%s Unread Messages"), number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), " (", sprintf(gettext("%s Unread &quot;To: Me&quot;"), number_format($forum['UNREAD_TO_ME'], 0, ",", ",")), ")\n";

                    } else {

                        echo sprintf(gettext("%s Unread &quot;To: Me&quot;"), number_format($forum['UNREAD_TO_ME'], 0, ".", ","));
                    }

                } else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                    echo sprintf(gettext("%s Unread Messages"), number_format($forum['UNREAD_MESSAGES'], 0, ".", ","));

                } else {

                    echo gettext("No Unread Messages");
                }

                echo "</span>\n";
                echo "</li>\n";
                echo "<li>";

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {
                    echo "<span class=\"forum_last_visit\">", gettext("Last Visited"), ": ", format_time($forum['LAST_VISIT']), "</span>\n";
                } else {
                    echo "<span class=\"forum_last_visit\">", gettext("Last Visited"), ": ", gettext("Never"), "</span>\n";
                }

                echo "</li>\n";
                echo "</ul>\n";
                echo "</div>\n";
                echo "</div>\n";
            }

            echo html_page_links("lforums.php?webtag=$webtag", $page, $forums_array['forums_count'], 10);

        } else {

            echo "<h3>", gettext("There are no forums available. Please login to view your forums."), "</h3>\n";
        }

    } else {

        $forums_array = get_forum_list($page);

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) > 0) {

            foreach ($forums_array['forums_array'] as $forum) {

                echo "<div class=\"forum\">\n";
                echo "  <h3><a href=\"lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";
                echo "  <div class=\"forum_info\">", number_format($forum['MESSAGES']), " ", gettext("Messages"), "</div>\n";
                echo "</div>\n";
            }

            echo html_page_links("lforums.php?webtag=$webtag", $page, $forums_array['forums_count'], 10);

        } else {

            echo "<h3>", gettext("There are no forums available. Please login to view your forums."), "</h3>\n";
        }
    }
}

function light_form_dropdown_array($name, $options_array, $default = null, $custom_html = null)
{
    $id = form_unique_id($name);

    $html = "<select name=\"$name\" id=\"$id\" class=\"select\"";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= ">";

    if (is_array($options_array) && sizeof($options_array) > 0) {

        foreach ($options_array as $option_key => $option_text) {

            $selected = (mb_strtolower($option_key) == mb_strtolower($default)) ? " selected=\"selected\"" : "";
            $html.= "<option value=\"{$option_key}\"$selected>$option_text</option>";
        }
    }

    $html.= "</select>";
    return $html;
}

function light_form_submit($name = "submit", $value = "Submit", $custom_html = null)
{
    $id = form_unique_id($name);

    $html = "<input type=\"submit\" name=\"$name\" id=\"$id\" value=\"$value\" class=\"button\" ";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf("%s ", trim($custom_html));
    }

    $html.= "/>";
    return $html;
}

function light_messages_top($tid, $pid, $thread_title, $thread_interest_level = THREAD_NOINTEREST, $sticky = "N", $closed = false, $locked = false, $deleted = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "<h3 class=\"thread_title\">";
    echo "<a href=\"", html_get_forum_file_path("index.php?webtag=$webtag&amp;msg=$tid.$pid"), "\">", word_filter_add_ob_tags($thread_title, true), "</a> ";

    if ($closed) echo "<span class=\"thread_closed\" title=\"", gettext("Closed"), "\">[C]</span>\n";
    if ($thread_interest_level == THREAD_INTERESTED) echo "<span class=\"thread_high_interest\" title=\"", gettext("High Interest"), "\">[H]</span>";
    if ($thread_interest_level == THREAD_SUBSCRIBED) echo "<span class=\"thread_subscribed\" title=\"", gettext("Subscribed"), "\">[S]</span>";
    if ($sticky == "Y") echo "<span class=\"thread_sticky\" title=\"", gettext("Sticky"), "\">[ST]</span>";
    if ($locked) echo "<span class=\"thread_locked\" title=\"", gettext("Locked"), "\">[L]</span>\n";
    if ($deleted) echo "<span class=\"thread_deleted\" title=\"", gettext("Deleted"), "\">[D]</span>\n";

    echo "</h3>\n";
}

function light_form_radio($name, $value, $text, $checked = false, $custom_html = null)
{
    $id = form_unique_id($name);

    $html = "<label><input type=\"radio\" name=\"$name\" id=\"$id\" value=\"$value\" class=\"radio\"";

    if ($checked) {
        $html.= " checked=\"checked\"";
    }

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= " />$text</label>";

    return $html;
}

function light_form_quick_button($href, $label, $var_array = null, $target = "_self")
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $html = "<form accept-charset=\"utf-8\" method=\"get\" action=\"$href\" target=\"$target\">";
    $html.= form_input_hidden("webtag", htmlentities_array($webtag));

    if (is_array($var_array)) {

        foreach ($var_array as $var_name => $var_value) {

            if (!is_array($var_value)) {

                $html.= form_input_hidden($var_name, htmlentities_array($var_value));
            }
        }
    }

    $html.= light_form_submit(form_unique_id('submit'), $label);
    $html.= "</form>";

    return $html;
}

function light_poll_display($tid, $msg_count, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_preview = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $total_votes = 0;

    $user_votes = 0;

    $guest_votes = 0;

    $poll_data = poll_get($tid);

    $poll_results = poll_get_votes($tid);

    $user_poll_votes_array = poll_get_user_votes($tid);

    poll_get_total_votes($tid, $total_votes, $user_votes, $guest_votes);

    $request_uri = get_request_uri();

    $poll_display = "<div class=\"poll\">\n";
    $poll_display.= "<form accept-charset=\"utf-8\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
    $poll_display.= form_input_hidden('webtag', htmlentities_array($webtag));
    $poll_display.= form_input_hidden('tid', htmlentities_array($tid));

    if (((!is_array($user_poll_votes_array) || $poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) && ($_SESSION['UID'] > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', 'Y')))) && ($poll_data['CLOSES'] == 0 || $poll_data['CLOSES'] > time()) && !$is_preview) {

        foreach ($poll_results as $question_id => $poll_question) {

            $poll_display.= "<h3>". word_filter_add_ob_tags($poll_question['QUESTION'], true). "</h3>\n";

            if ($poll_data['OPTIONTYPE'] == POLL_OPTIONS_DROPDOWN) {

                $dropdown_options_array = array_map('poll_dropdown_options_callback', $poll_question['OPTIONS_ARRAY']);

                $poll_display.= light_form_dropdown_array("pollvote[$question_id]", $dropdown_options_array);

            } else {

                foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {

                    if ((sizeof($poll_question['OPTIONS_ARRAY']) == 1) || ($poll_question['ALLOW_MULTI'] == 'Y')) {

                        $poll_display.= light_form_checkbox("pollvote[$question_id][$option_id]", 'Y', word_filter_add_ob_tags($option['OPTION_NAME']), false);

                    } else {

                        $poll_display.= light_form_radio("pollvote[$question_id]", $option_id, word_filter_add_ob_tags($option['OPTION_NAME']), false);
                    }
                }
            }
        }

    } else {

        if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS || ($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] < time())) {

            $poll_display.= "<div class=\"poll_results\">\n";

            foreach ($poll_results as $question_id => $poll_question) {

                $poll_display.= "<h3>". word_filter_add_ob_tags($poll_question['QUESTION'], true). "</h3>\n";
                $poll_display.= light_poll_graph_display($poll_question['OPTIONS_ARRAY']);
            }

            $poll_display.= "</div>\n";

        } else {

            $poll_display.= "<div class=\"poll_results\">\n";

            foreach ($poll_results as $question_id => $poll_question) {

                $poll_display.= "<h3>". word_filter_add_ob_tags($poll_question['QUESTION'], true). "</h3>\n";

                foreach ($poll_question['OPTIONS_ARRAY'] as $option_id => $option) {

                    $poll_display.= word_filter_add_ob_tags($option['OPTION_NAME']);
                }
            }

            $poll_display.="</div>\n";
        }
    }

    if (!$is_preview) {

        $poll_display.= "<div class=\"poll_vote_counts\">". poll_format_vote_counts($poll_data, $user_votes, $guest_votes). "</div>\n";

        if (($poll_data['CLOSES'] <= time()) && $poll_data['CLOSES'] != 0) {

            $poll_display.= "<div class=\"poll_vote_closed\">". gettext("Poll has ended"). "</div>\n";

            if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {
                $poll_display.= poll_display_user_votes($user_poll_votes_array);
            }

        } else {

            if (is_array($user_poll_votes_array) && sizeof($user_poll_votes_array) > 0) {

                $poll_display.= poll_display_user_votes($user_poll_votes_array);

                if ($poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) {
                    $poll_display.= "<div class=\"poll_buttons\">". light_form_submit('pollsubmit', gettext("Vote")). "</div>";
                }

                if ($poll_data['CHANGEVOTE'] != POLL_VOTE_CANNOT_CHANGE) {
                    $poll_display.= "<div class=\"poll_buttons\">". light_form_submit('pollchangevote', gettext("Change vote")). "</div>\n";
                }

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {
                    $poll_display.= "<div class=\"poll_type_warning\">". gettext("<b>Warning</b>: This is a public ballot. Your name will be visible next to the option you vote for."). "</div>\n";
                }

            } else if ($_SESSION['UID'] > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', 'Y'))) {

                $poll_display.= "<div class=\"poll_buttons\">". light_form_submit('pollsubmit', gettext("Vote")). "</div>";

                if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {
                    $poll_display.= "<div class=\"poll_type_warning\">". gettext("<b>Warning</b>: This is a public ballot. Your name will be visible next to the option you vote for."). "</div>\n";
                }
            }
        }
    }

    $poll_display.= "</form>\n";
    $poll_display.= "</div>\n";

    $poll_data['CONTENT'] = $poll_display;

    light_message_display($tid, $poll_data, $msg_count, 1, $folder_fid, $in_list, $closed, $limit_text, true, $is_preview);
}

function light_poll_graph_display($options_array)
{
    static $bar_color = 1;

    $max_vote_count = 0;

    $total_vote_count = 0;

    foreach ($options_array as $option) {

        $total_vote_count+= sizeof($option['VOTES_ARRAY']);

        if (sizeof($option['VOTES_ARRAY']) > $max_vote_count) {
            $max_vote_count = sizeof($option['VOTES_ARRAY']);
        }
    }

    $poll_display = '';

    foreach ($options_array as $option) {

        $poll_bar_width = ($total_vote_count > 0) ? (100 / $total_vote_count) * sizeof($option['VOTES_ARRAY']) : 0;

        $vote_percent = ((sizeof($option['VOTES_ARRAY']) > 0) && ($total_vote_count > 0)) ? (sizeof($option['VOTES_ARRAY']) / $total_vote_count) * 100 : 0;

        $poll_display.= "<div class=\"poll_bar poll_bar_horizontal poll_bar_$bar_color\">\n";
        $poll_display.= "  <div class=\"poll_bar_inner poll_bar_inner_$bar_color\" style=\"width: {$poll_bar_width}%; left: -{$poll_bar_width}%\"></div>\n";
        $poll_display.= "</div>\n";
        $poll_display.= "<div class=\"poll_vote_result\">". word_filter_add_ob_tags($option['OPTION_NAME']). ": ". sizeof($option['VOTES_ARRAY']). " ". gettext("Votes"). " (". number_format($vote_percent, 2). "%)</div>\n";

        $bar_color++;

        if ($bar_color > 5) $bar_color = 1;
    }

    return $poll_display;
}

function light_message_display($tid, $message, $msg_count, $first_msg, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $is_preview = false)
{
    $perm_is_moderator = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);

    $post_edit_time = forum_get_setting('post_edit_time', null, 0);

    $post_edit_grace_period = forum_get_setting('post_edit_grace_period', null, 0);

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if ((!isset($message['CONTENT']) || $message['CONTENT'] == "") && !$is_preview) {

        light_message_display_deleted($tid, isset($message['PID']) ? $message['PID'] : 0);
        return;
    }

    $from_user_permissions = perm_get_user_permissions($message['FROM_UID']);

    if ($_SESSION['UID'] != $message['FROM_UID']) {

        if (($from_user_permissions & USER_PERM_WORMED) && !$perm_is_moderator) {

            light_message_display_deleted($tid, $message['PID']);
            return;
        }
    }

    if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) == 1) {

        $recipient = array_slice(array_values($message['RECIPIENTS']), 0, 1);

        if (isset($recipient['RELATIONSHIP']) && ($recipient['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

            light_message_display_deleted($tid, $message['PID']);
            return;
        }
    }

    if (forum_get_setting('require_post_approval', 'Y') && $message['FROM_UID'] != $_SESSION['UID']) {

        if (isset($message['APPROVED']) && $message['APPROVED'] == 0 && !$perm_is_moderator) {

            light_message_display_approval_req($tid, $message['PID']);
            return;
        }
    }

    // OUTPUT MESSAGE ----------------------------------------------------------
    if (!$is_preview && ($message['MOVED_TID'] > 0) && ($message['MOVED_PID'] > 0)) {

        $post_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_self\">%s</a>";
        $post_link = sprintf($post_link, $message['MOVED_TID'], $message['MOVED_PID'], gettext("here"));

        light_html_display_warning_msg(sprintf(gettext("<b>Thread Split:</b> This post has been moved %s"), $post_link));
        return;
    }

    if ($in_list) {
        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>";
    }

    echo "<div class=\"message\">\n";

    if (isset($_SESSION['IMAGES_TO_LINKS']) && ($_SESSION['IMAGES_TO_LINKS'] == 'Y')) {

        $message['CONTENT'] = preg_replace('/<a([^>]*)href="([^"]*)"([^\>]*)><img[^>]*src="([^"]*)"[^>]*><\/a>/iu', '[img: <a\1href="\2"\3>\4</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<img[^>]*src="([^"]*)"[^>]*>/iu', '[img: <a href="\1">\1</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<embed[^>]*src="([^"]*)"[^>]*>/iu', '[object: <a href="\1">\1</a>]', $message['CONTENT']);
    }

    if ((mb_strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length', null, 6226))) && $limit_text) {

        $cut_msg = mb_substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length', null, 6226)));
        $cut_msg = preg_replace("/(<[^>]+)?$/Du", "", $cut_msg);

        $message['CONTENT'] = fix_html($cut_msg);
        $message['CONTENT'].= "&hellip;[". gettext("Message Truncated"). "]\n";
        $message['CONTENT'].= "<a href=\"ldisplay.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" class=\"message_full_view\">". gettext("View full message"). ".</a>";
    }

    echo "<div class=\"message_header\">\n";
    echo "<div class=\"message_from\">\n";
    echo "", gettext("From"), ": ", word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true);

    if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_FRIEND)) {

        echo "<span class=\"user_friend\" title=\"", gettext("Friend"), "\">", gettext("Friend"), "</span>";

    } else if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED)) {

        echo "<span class=\"user_enemy\" title=\"", gettext("Ignored user"), "\">", gettext("Enemy"), "</span>";
    }

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && $message['PID'] == 1 && isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED)) {
        $message['RELATIONSHIP']-= USER_IGNORED;
    }

    if (isset($message['RELATIONSHIP']) && ($message['RELATIONSHIP'] & USER_IGNORED) && $limit_text) {

        echo gettext("Ignored message");

    } else {

        if ($in_list) {

            if (($from_user_permissions & USER_PERM_WORMED)) echo gettext("Wormed user");
            echo "<span class=\"message_time\">", format_time($message['CREATED']), "</span>\n";
        }
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>";
    echo "<div class=\"message_to\">", gettext("To"), ": ";

    if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) > 0) {

        foreach ($message['RECIPIENTS'] as $recipient) {

            if (isset($recipient['RELATIONSHIP']) && ($recipient['RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {
                continue;
            }

            echo word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "\n";

            if (isset($recipient['VIEWED']) && $recipient['VIEWED'] > 0) {

                echo "<span class=\"smalltext\"><img src=\"", html_style_image('post_read.png'), "\" alt=\"\" title=\"", sprintf(gettext("Read: %s"), format_time($recipient['VIEWED'])), "\" /></span>\n";

            } else {

                if ($is_preview == false) {

                    echo "<span class=\"smalltext\"><img src=\"", html_style_image('post_unread.png'), "\" alt=\"\" title=\"", gettext("Unread Message"), "\" /></span>\n";
                }
            }
        }

    } else {

        echo gettext('ALL');
    }

    if ($in_list && $msg_count > 0) {
        echo "<span class=\"message_count\">", sprintf(gettext("%s of %s"), $message['PID'], $msg_count), "</span>";
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "<div class=\"message_links\">\n";

    if ($in_list && $msg_count > 0) {

        echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\">$tid.{$message['PID']}</a>";

        if ($message['REPLY_TO_PID'] > 0) {

            echo " ", gettext("In reply to"), " ";

            if (intval($message['REPLY_TO_PID']) >= intval($first_msg)) {

                echo "<a href=\"#a{$tid}_{$message['REPLY_TO_PID']}\" target=\"_self\">$tid.{$message['REPLY_TO_PID']}</a>";

            } else {

                echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg={$tid}.{$message['REPLY_TO_PID']}\">$tid.{$message['REPLY_TO_PID']}</a>";
            }
        }
    }

    echo "</div>\n";

    if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {
        $message['CONTENT'] = message_apply_formatting($message['CONTENT'], true);
    }

    $message['CONTENT'] = light_spoiler_enable($message['CONTENT']);

    if ($is_poll !== true) $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT']);

    echo "<div class=\"message_body\">\n";

    echo $message['CONTENT'];

    if (isset($message['EDITED']) && $message['EDITED'] > 0) {

        if (($post_edit_grace_period == 0) || ($message['EDITED'] - $message['CREATED']) > ($post_edit_grace_period * MINUTE_IN_SECONDS)) {

            if (($edit_user = user_get_logon($message['EDITED_BY'])) !== false) {

                echo "<div class=\"edit_text\">", sprintf(gettext("EDITED: %s by %s"), format_time($message['EDITED']), $edit_user), "</div>\n";
            }
        }
    }

    echo "</div>\n";

    if (isset($message['ATTACHMENTS']) && sizeof($message['ATTACHMENTS']) > 0) {

        if (($attachments_array = attachments_get($message['FROM_UID'], ATTACHMENT_FILTER_ASSIGNED, $message['ATTACHMENTS'])) !== false) {

            echo "<div class=\"message_attachments\">\n";
            echo "  <span>", gettext("Attachments"), ":</span>\n";
            echo "  <ul>\n";

            foreach ($attachments_array as $attachment) {

                if (($attachment_link = light_attachments_make_link($attachment)) !== false) {
                    echo "<li>", $attachment_link, "</li>\n";
                }
            }

            echo "  </ul>\n";
            echo "</div>\n";
        }
    }

    if (!$is_preview && $msg_count > 0) {

        $links_array = array();

        if (!$closed && session::check_perm(USER_PERM_POST_CREATE, $folder_fid)) {

            $links_array[] = "<a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" class=\"reply\">". gettext("Reply"). "</a>";
        }

        if (($_SESSION['UID'] == $message['FROM_UID'] && session::check_perm(USER_PERM_POST_DELETE, $folder_fid) && !session::check_perm(USER_PERM_PILLORIED, 0)) || $perm_is_moderator) {

            $links_array[] = "<a href=\"ldelete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" class=\"delete\">". gettext("Delete"). "</a>";
        }

        if ((!(session::check_perm(USER_PERM_PILLORIED, 0)) && ((($_SESSION['UID'] != $message['FROM_UID']) && ($from_user_permissions & USER_PERM_PILLORIED)) || ($_SESSION['UID'] == $message['FROM_UID'])) && session::check_perm(USER_PERM_POST_EDIT, $folder_fid) && ($post_edit_time == 0 || (time() - $message['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS)) && forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

            if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {

                $links_array[] = "<a href=\"ledit.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" class=\"edit\">". gettext("Edit"). "</a>";
            }
        }

        if (sizeof($links_array) > 0) {
            echo "<div class=\"message_footer_links\">", implode('&nbsp;&nbsp;', $links_array), "</div>\n";
        }

    } else {

        echo "<div class=\"message_footer_links\"></div>\n";
    }

    echo "</div>";
}

function light_spoiler_enable($message)
{
    if (isset($_SESSION['USE_LIGHT_MODE_SPOILER']) && ($_SESSION['USE_LIGHT_MODE_SPOILER'] == 'Y')) {
        return preg_replace('/<(div|span) class="spoiler">/iu', '<\1 class="spoiler_light">', $message);
    }

    return $message;
}

function light_message_display_deleted($tid,$pid)
{
    echo "<div class=\"message\">\n";
    echo sprintf(gettext("Message %s.%s was deleted"), $tid, $pid);
    echo "</div>\n";
}

function light_message_display_approval_req($tid, $pid)
{
    echo "<div class=\"message\">\n";
    echo sprintf(gettext("Message %s.%s is awaiting approval by a moderator"), $tid, $pid);
    echo "</div>\n";
}

function light_messages_nav_strip($tid, $pid, $length, $ppp)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if ($pid < 2 && $length < $ppp) {
        return;
    } else if ($pid < 1) {
        $pid = 1;
    }

    $c = 0;

    $spid = $pid % $ppp;

    if ($spid > 1) {

        if ($pid > 1) {

            $navbits[0] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">". mess_nav_range(1, $spid - 1). "</a>";

        } else {

            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1);
        }

        $i = 1;

    } else {

        $i = 0;
    }

    while ($spid + ($ppp - 1) < $length) {

        if ($spid == $pid) {

            $c = $i;
            $navbits[$i] = mess_nav_range($spid, $spid + ($ppp - 1));

        } else {

            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.". ($spid == 0 ? 1 : $spid). "\">". mess_nav_range($spid == 0 ? 1 : $spid, $spid + ($ppp - 1)). "</a>";
        }

        $spid += $ppp;

        $i++;
    }

    if ($spid <= $length) {

        if ($spid == $pid) {

            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length);

        } else {

            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">". mess_nav_range($spid,$length). "</a>";
        }
    }

    $max = $i;

    $html = "<span>". gettext("Show messages"). ":</span>";

    if ($length <= $ppp) {
        $html.= " <a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">". gettext("All"). "</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            if ((abs($c - $i) < 4) || $i == 0 || $i == $max) {

                $html.= "\n&nbsp;". $navbits[$i];

            } else if (abs($c - $i) == 4) {

                $html.= "\n&nbsp;&hellip;";
            }
        }
    }

    unset($navbits);

    echo "<div class=\"message_pagination\">$html</div>\n";
}

function light_html_guest_error()
{
    light_html_draw_error(gettext("Sorry, you need to be logged in to use this feature."), 'llogout.php', 'get', array('login' => gettext("Login now")));
}

function light_folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="")
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return "";

    $available_folders = array();

    $allowed_types = FOLDER_ALLOW_NORMAL_THREAD;
    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql.= "WHERE FOLDER.ALLOWED_TYPES & $allowed_types > 0 ";
    $sql.= "OR FOLDER.ALLOWED_TYPES IS NULL ";
    $sql.= "ORDER BY FOLDER.FID ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($folder_order = $result->fetch_assoc()) !== null) {

        if (!session::logged_in()) {

            if (session::check_perm(USER_PERM_GUEST_ACCESS, $folder_order['FID'])) {

                $available_folders[$folder_order['FID']] = htmlentities_array($folder_order['TITLE']);
            }

        } else {

            if (session::check_perm($access_allowed, $folder_order['FID']) || ($default_fid == $folder_order['FID'])) {

                $available_folders[$folder_order['FID']] = htmlentities_array($folder_order['TITLE']);
            }
        }
    }

    if (sizeof($available_folders) == 0) return false;

    return light_form_dropdown_array($field_name. $suffix, $available_folders, $default_fid);
}

function light_form_textarea($name, $value = null, $rows = null, $cols = null, $custom_html = null, $class = 'textarea', $placeholder = null)
{
    $id = form_unique_id($name);

    $html = "<textarea name=\"$name\" id=\"$id\" class=\"$class\"";

    if (isset($custom_html) && is_string($custom_html)) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($rows)) {
        $html.= " rows=\"$rows\"";
    }

    if (is_numeric($cols)) {
        $html.= " cols=\"$cols\"";
    }

    if (isset($placeholder) && is_string($placeholder)) {
        $html.= " placeholder=\"$placeholder\"";
    }

    return $html. ">$value</textarea>";
}

function light_form_checkbox($name, $value, $text, $checked = false, $custom_html = null)
{
    $id = form_unique_id($name);

    $html = "<label><input type=\"checkbox\" name=\"$name\" id=\"$id\" value=\"$value\" class=\"checkbox\"";

    if ($checked) {
        $html.= " checked=\"checked\"";
    }

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= " />$text</label>";

    return $html;
}

function light_form_field($name, $value = null, $width = null, $maxchars = null, $type = "text", $custom_html = null, $placeholder = null)
{
    $id = form_unique_id($name);

    $html = "<input type=\"$type\" name=\"$name\" id=\"$id\" class=\"$type\" value=\"$value\"";

    if (isset($custom_html) && is_string($custom_html)) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($width)) {
        $html.= " size=\"$width\"";
    }

    if (is_numeric($maxchars)) {
        $html.= " maxlength=\"$maxchars\"";
    }

    if (isset($placeholder) && is_string($placeholder)) {
        $html.= " placeholder=\"$placeholder\"";
    }

    return $html. " />";
}

function light_form_input_text($name, $value = null, $width = null, $maxlength = null, $custom_html = null, $placeholder = null)
{
    return light_form_field($name, $value, $width, $maxlength, "text", $custom_html, $placeholder);
}

function light_form_input_password($name, $value = null, $width = null, $maxlength = null, $custom_html = null, $placeholder = null)
{
    return light_form_field($name, $value, $width, $maxlength, "password", $custom_html, $placeholder);
}

function light_html_message_type_error()
{
    light_html_draw_error(gettext("You cannot post this thread type as there are no available folders that allow it."));
}

function light_attachments_make_link($attachment)
{
    if (!is_array($attachment)) return false;

    if (!isset($attachment['hash']) || !is_md5($attachment['hash'])) return false;
    if (!isset($attachment['filename'])) return false;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $href = "get_attachment.php?webtag=$webtag&amp;hash={$attachment['hash']}";
    $href.= "&amp;filename={$attachment['filename']}";

    return "<a href=\"$href\" target=\"_blank\">{$attachment['filename']}</a>";
}

function light_threads_draw_discussions_dropdown($mode)
{
    $unread_cutoff_stamp = forum_get_unread_cutoff();

    if (!session::logged_in()) {

        $available_views = array(
            ALL_DISCUSSIONS => gettext("All Discussions"),
            TODAYS_DISCUSSIONS => gettext("Today's Discussions"),
            TWO_DAYS_BACK => gettext("2 Days Back"),
            SEVEN_DAYS_BACK => gettext("7 Days Back")
        );

    } else {

        $available_views = array(
            ALL_DISCUSSIONS => gettext("All Discussions"),
            UNREAD_DISCUSSIONS => gettext("Unread Discussions"),
            UNREAD_DISCUSSIONS_TO_ME => gettext("Unread &quot;To: Me&quot;"),
            TODAYS_DISCUSSIONS => gettext("Today's Discussions"),
            UNREAD_TODAY => gettext("Unread today"),
            TWO_DAYS_BACK => gettext("2 Days Back"),
            SEVEN_DAYS_BACK => gettext("7 Days Back"),
            HIGH_INTEREST => gettext("High Interest"),
            UNREAD_HIGH_INTEREST => gettext("Unread High Interest"),
            RECENTLY_SEEN => gettext("I've recently seen"),
            IGNORED_THREADS => gettext("I've ignored"),
            BY_IGNORED_USERS => gettext("By ignored users"),
            SUBSCRIBED_TO => gettext("I've subscribed to"),
            STARTED_BY_FRIEND => gettext("Started by friend"),
            UNREAD_STARTED_BY_FRIEND => gettext("Unread started by friend"),
            STARTED_BY_ME => gettext("Started by me"),
            POLL_THREADS => gettext("Polls"),
            STICKY_THREADS => gettext("Sticky Threads"),
            MOST_UNREAD_POSTS => gettext("Most unread posts"),
            SEARCH_RESULTS => gettext("Search Results"),
            DELETED_THREADS => gettext("Deleted Threads")
        );

        if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

            if ($unread_cutoff_stamp === false) {

                // Remove unread thread options (Unread Discussions, Unread Today,
                // Unread High Interest, Unread Started By Friend, Most Unread Posts).
                unset($available_views[UNREAD_DISCUSSIONS], $available_views[UNREAD_TODAY], $available_views[UNREAD_HIGH_INTEREST]);
                unset($available_views[UNREAD_STARTED_BY_FRIEND], $available_views[MOST_UNREAD_POSTS]);
            }

        } else {

            // Remove Admin Deleted Threads option.
            unset($available_views[DELETED_THREADS]);

            if ($unread_cutoff_stamp === false) {

                // Remove unread thread options (Unread Discussions, Unread Today,
                // Unread High Interest, Unread Started By Friend, Most Unread Posts).
                unset($available_views[UNREAD_DISCUSSIONS], $available_views[UNREAD_TODAY], $available_views[UNREAD_HIGH_INTEREST]);
                unset($available_views[UNREAD_STARTED_BY_FRIEND], $available_views[MOST_UNREAD_POSTS]);
            }

        }
    }

    return light_form_dropdown_array("mode", $available_views, $mode);
}

function light_post_edit_refuse()
{
    light_html_draw_error(gettext("You are not permitted to edit this message."));
}

function light_html_display_msg($header_text, $string_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self")
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $available_methods = array(
        'get',
        'post'
    );

    if (!in_array($method, $available_methods)) $method = 'get';

    if (is_string($href) && strlen(trim($href)) > 0) {

        echo "<form accept-charset=\"utf-8\" action=\"$href\" method=\"$method\" target=\"$target\">\n";
        echo form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

        if (is_array($var_array)) {

            echo form_input_hidden_array($var_array), "\n";
        }
    }

    echo "<div class=\"message_box message_question\">\n";
    echo "  <h3>", $header_text, "</h3>\n";
    echo "  <p>", $string_msg, "</p>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        $button_html_array = array();

        if (is_array($button_array) && sizeof($button_array) > 0) {

            foreach ($button_array as $button_name => $button_label) {
                $button_html_array[] = form_submit(htmlentities_array($button_name), htmlentities_array($button_label));
            }
        }

        if (sizeof($button_html_array) > 0) {
            echo "<p>", implode("&nbsp;", $button_html_array), "</p>\n";
        }
    }

    echo "</div>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {
        echo "</form>\n";
    }
}

function light_html_display_error_array($error_list_array)
{
    echo "<div class=\"message_box message_error\">\n";
    echo "  <h3>", gettext("The following errors were encountered:"), "</h3>\n";
    echo "  <ul>\n";
    echo "    <li>", implode("</li>\n<li>", $error_list_array), "</li>\n";
    echo "  </ul>\n";
    echo "</div>\n";
}

function light_html_display_success_msg($string_msg)
{
    echo "<div class=\"message_box message_success\">\n";
    echo "  <h3>", $string_msg, "</h3>\n";
    echo "</div>\n";
}

function light_html_display_warning_msg($string_msg)
{
    echo "<div class=\"message_box message_warning\">\n";
    echo "  <h3>", $string_msg, "</h3>\n";
    echo "</div>\n";
}

function light_html_display_error_msg($string_msg)
{
    echo "<div class=\"message_box message_error\">\n";
    echo "  <h3>", $string_msg, "</h3>\n";
    echo "</div>\n";
}

function light_html_draw_error($error_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self")
{
    light_html_draw_top();
    light_html_display_msg(gettext('Error'), $error_msg, $href, $method, $button_array, $var_array, $target);
    light_html_draw_bottom();
    exit;
}

function light_html_user_banned()
{
    header_status(500, 'Internal Server Error');
    exit;
}

function light_html_user_require_approval()
{
    light_html_draw_error(gettext("Your user account needs to be approved by a forum admin before you can access the requested forum."));
}

function light_html_email_confirmation_error()
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $user_array = user_get($_SESSION['UID']);

    light_html_draw_error(gettext("Email confirmation is required before you can post. If you have not received a confirmation email please click the button below and a new one will be sent to you. If your email address needs changing please do so before requesting a new confirmation email. You may change your email address by click My Controls above and then User Details"), 'confirm_email.php', 'get', array('resend' => gettext("Resend Confirmation")), array('uid' => $user_array['UID'], 'resend' => 'Y'));
}

function light_pm_error_refuse()
{
    light_html_draw_error(gettext("Cannot view PM. Message does not exist or it is inaccessible by you"));
}

function light_pm_edit_refuse()
{
    light_html_draw_error(gettext("Cannot edit this PM. It has already been viewed by the recipient or the message does not exist or it is inaccessible by you"));
}

function light_pm_enabled()
{
    if (!forum_get_setting('show_pms', 'Y')) {
        light_html_draw_error(gettext("Personal Messages have been disabled by the forum owner."));
    }

    return true;
}

function light_pm_display($message_data, $preview = false)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    echo "<div class=\"message\">\n";
    echo "<div class=\"message_header\">\n";

    echo "<div class=\"message_from\">\n";
    echo "<span>", gettext("From"), ": ", word_filter_add_ob_tags(format_user_name($message_data['FROM_LOGON'], $message_data['FROM_NICKNAME']), true), "</span>\n";
    echo "</div>\n";

    echo "<div class=\"message_subject\">", gettext("Subject"), ": ";

    if (strlen(trim($message_data['SUBJECT'])) > 0) {

        echo word_filter_add_ob_tags($message_data['SUBJECT'], true), "\n";

    } else {

        echo "<span class=\"no_subject\">", gettext("No Subject"), "</span>\n";
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>\n";

    echo "<div class=\"message_to\">", gettext("To"), ": ";

    if (isset($message_data['RECIPIENTS']) && sizeof($message_data['RECIPIENTS']) > 0) {

        foreach ($message_data['RECIPIENTS'] as $recipient) {
            echo "<span>", word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "</span>\n";
        }

    } else {

        echo gettext('Unknown User');
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>\n";

    echo "</div>\n";

    $message_data['CONTENT'] = message_apply_formatting($message_data['CONTENT']);
    $message_data['CONTENT'] = word_filter_add_ob_tags($message_data['CONTENT']);

    echo "<div class=\"message_body\">", $message_data['CONTENT'], "</div>\n";

    if (isset($message_data['ATTACHMENTS']) && sizeof($message_data['ATTACHMENTS']) > 0) {

        if (($attachments_array = attachments_get($message_data['FROM_UID'], ATTACHMENT_FILTER_ASSIGNED, $message_data['ATTACHMENTS'])) !== false) {

            echo "<div class=\"message_attachments\">\n";
            echo "  <span>", gettext("Attachments"), ":</span>\n";
            echo "  <ul>\n";

            foreach ($attachments_array as $attachment) {

                if (($attachment_link = light_attachments_make_link($attachment)) !== false) {
                    echo "<li>", $attachment_link, "</li>\n";
                }
            }

            echo "  </ul>\n";
            echo "</div>\n";
        }
    }

    if ($preview === false) {

        $links_array = array();

        if (($message_data['TYPE'] & PM_INBOX_ITEMS) > 0) {

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;replyto={$message_data['MID']}\" class=\"reply\">". gettext("Reply"). "</a>";

            if (isset($message_data['RECIPIENTS']) && sizeof($message_data['RECIPIENTS']) > 1) {
                $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;replyall={$message_data['MID']}\" class=\"replyall\">". gettext("Reply All"). "</a>";
            }

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;fwdmsg={$message_data['MID']}\" class=\"forward\">". gettext("Forward"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;delete_msg={$message_data['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";

        } else if (($message_data['TYPE'] & PM_OUTBOX_ITEMS) > 0) {

            $links_array[] = "<a href=\"lpm_edit.php?webtag=$webtag&amp;mid={$message_data['MID']}\" class=\"edit\">". gettext("Edit"). "</a>";
            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;fwdmsg={$message_data['MID']}\" class=\"forward\">". gettext("Forward"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;delete_msg={$message_data['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";

        } else if (($message_data['TYPE'] & PM_DRAFT_ITEMS) > 0) {

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;editmsg={$message_data['MID']}\" class=\"edit\">". gettext("Edit"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;delete_msg={$message_data['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";

        } else {

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;fwdmsg={$message_data['MID']}\" class=\"forward\">". gettext("Forward"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;delete_msg={$message_data['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";
        }

        if (sizeof($links_array) > 0) {
            echo "<div class=\"message_footer_links\">", implode('&nbsp;&nbsp;', $links_array), "</div>\n";
        }
    }

    echo "</div>";
}

function light_pm_check_messages()
{
    // Check if this function has be called multiple times in one request.
    static $light_pm_check_messages_done = false;

    // Check if we've already displayed the notification once.
    if ($light_pm_check_messages_done === true) return;

    // Get the webtag
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Default the variables to return 0 even on error.
    $new_count = 0;
    $outbox_count = 0;
    $unread_count = 0;

    // Get the number of messages.
    pm_get_message_count($new_count, $outbox_count, $unread_count);

    // Format the message sent to the client.
    if ($new_count == 1 && $outbox_count == 0) {

        $notification = gettext("You have 1 new message. Would you like to go to your Inbox now?");

    } else if ($new_count == 1 && $outbox_count == 1) {

        $notification = gettext("You have 1 new message.\n\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?");

    } else if ($new_count == 0 && $outbox_count == 1) {

        $notification = gettext("You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?");

    } else if ($new_count > 1 && $outbox_count == 0) {

        $notification = sprintf(gettext("You have %d new messages. Would you like to go to your Inbox now?"), $new_count);

    } else if ($new_count > 1 && $outbox_count == 1) {

        $notification = sprintf(gettext("You have %d new messages.\n\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $new_count);

    } else if ($new_count > 1 && $outbox_count > 1) {

        $notification = sprintf(gettext("You have %d new messages.\n\nYou also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $new_count, $outbox_count);

    } else if ($new_count == 1 && $outbox_count > 1) {

        $notification = sprintf(gettext("You have 1 new message.\n\nYou also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $outbox_count);

    } else if ($new_count == 0 && $outbox_count > 1) {

        $notification = sprintf(gettext("You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?"), $outbox_count);
    }

    if (isset($notification) && strlen(trim($notification)) > 0) {

        // Wrap the notification in a hyperlink.
        $notification = sprintf("<a href=\"lpm.php?webtag=$webtag\">%s</a>\n", $notification);

        // Display the notification
        light_html_display_success_msg($notification);
    }

    // Prevent checking again.
    $light_pm_check_messages_done = true;
}

function light_folder_search_dropdown($selected_folder)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($selected_folder)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $available_folders = array();

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT FID, TITLE FROM `{$table_prefix}FOLDER` ";
    $sql.= "ORDER BY FID ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($folder_data = $result->fetch_assoc()) !== null) {

        if (!session::logged_in()) {

            if (session::check_perm(USER_PERM_GUEST_ACCESS, $folder_data['FID'])) {

                $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
            }

        } else {

            if (session::check_perm($access_allowed, $folder_data['FID'])) {

                $available_folders[$folder_data['FID']] = htmlentities_array($folder_data['TITLE']);
            }
        }
    }

    if (sizeof($available_folders) == 0) return false;

    $available_folders = array(
        gettext("ALL")
    ) + $available_folders;

    return light_form_dropdown_array("fid", $available_folders, $selected_folder);
}

?>