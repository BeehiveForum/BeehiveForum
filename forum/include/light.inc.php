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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

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
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'myforums.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'user_rel.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

function light_html_draw_top()
{
    static $called = false;

    if ($called) return;

    $called = true;

    $arg_array = func_get_args();

    $title = null;

    $robots = null;

    $webtag = get_webtag();

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

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"", gettext("ltr"), "\">\n";
    echo "<head>\n";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        message_get_meta_content($_GET['msg'], $meta_keywords, $meta_description);

        list($tid, $pid) = explode('.', $_GET['msg']);

        if (($thread_data = thread_get($tid))) {

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

    if (($stylesheet = html_get_style_sheet('mobile.css'))) {
        echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" media=\"screen\" />\n";
    }

    if (($emoticon_stylesheet = html_get_emoticon_style_sheet(true))) {
        echo "<link rel=\"stylesheet\" href=\"$emoticon_stylesheet\" type=\"text/css\" media=\"screen\" />\n";
    }

    $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag");

    printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array(gettext("RSS Feed")), $rss_feed_path);

    if (($folders_array = folder_get_available_details())) {

        foreach ($folders_array as $folder) {

            $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag&amp;fid={$folder['FID']}");

            printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array($folder['TITLE']), htmlentities_array(gettext("RSS Feed")), $rss_feed_path);
        }
    }

    if (($user_style_path = html_get_user_style_path())) {

        printf("<link rel=\"apple-touch-icon\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-57x57.png', $user_style_path)));
        printf("<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-72x72.png', $user_style_path)));
        printf("<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-114x114.png', $user_style_path)));

        printf("<link rel=\"shortcut icon\" type=\"image/ico\"href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/favicon.ico', $user_style_path)));
    }

    echo "<script type=\"text/javascript\" src=\"js/jquery-1.7.1.min.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"js/jquery.sprintf.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"js/general.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"js/light.js\"></script>\n";

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

        if (session::get_value('USE_MOVER_SPOILER') == "Y") {

            echo "<script type=\"text/javascript\" src=\"js/spoiler.js\"></script>\n";
        }
    }

    echo "<script type=\"text/javascript\" src=\"ckeditor/ckeditor.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"ckeditor/adapters/jquery.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"json.php?webtag=$webtag\"></script>\n";

    echo "</head>\n";
    echo "<body id=\"mobile\">\n";
    echo "<a name=\"top\"></a>\n";
    echo "<div id=\"header\">\n";
    echo "  <img src=\"", html_style_image('mobile_logo.png'), "\" alt=\"", gettext("Beehive Forum Logo"), "\" />\n";
    echo "  <div id=\"nav\">", gettext("Menu"), "</div>\n";
    echo "</div>\n";
    echo "<div id=\"menu\">\n";
    echo "  <ul>\n";

    if (forums_get_available_count() > 1 || !forum_check_webtag_available($webtag)) {
        echo "    <li class=\"menu_item\"><a href=\"lforums.php?webtag=$webtag\">", gettext("My Forums"), "</a></li>\n";
    }

    echo "    <li class=\"menu_item\"><a href=\"lthread_list.php?webtag=$webtag\">", gettext("Messages"), "</a></li>\n";
    echo "    <li class=\"menu_item\"><a href=\"lpm.php?webtag=$webtag\">", gettext("Inbox"), "</a></li>\n";

    if (!session::logged_in()) {
        echo "    <li class=\"menu_item\"><a href=\"llogon.php?webtag=$webtag\">", gettext("Login"), "</a></li>\n";
    } else {
        echo "    <li class=\"menu_item\"><a href=\"llogout.php?webtag=$webtag\">", gettext("Logout"), "</a></li>\n";
    }

    echo "  </ul>\n";
    echo "</div>\n";
    echo "<div id=\"content\">\n";

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

    if (($tracking_data_array = thread_get_tracking_data($tid))) {

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

    $error_msg_array = array();

    $available_views = thread_list_available_views();

    $visible_threads_array = array();

    if (($uid = session::get_value('UID')) === false) return;

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

    // Get the right threads for whichever mode is selected
    switch ($mode) {

        case UNREAD_DISCUSSIONS:

            list($thread_info, $folder_order) = threads_get_unread($uid, $folder, $page);
            break;

        case UNREAD_DISCUSSIONS_TO_ME:

            list($thread_info, $folder_order) = threads_get_unread_to_me($uid, $folder, $page);
            break;

        case TODAYS_DISCUSSIONS:

            list($thread_info, $folder_order) = threads_get_by_days($uid, $folder, $page, 1);
            break;

        case UNREAD_TODAY:

            list($thread_info, $folder_order) = threads_get_unread_by_days($uid, $folder, $page);
            break;

        case TWO_DAYS_BACK:

            list($thread_info, $folder_order) = threads_get_by_days($uid, $folder, $page, 2);
            break;

        case SEVEN_DAYS_BACK:

            list($thread_info, $folder_order) = threads_get_by_days($uid, $folder, $page, 7);
            break;

        case HIGH_INTEREST:

            list($thread_info, $folder_order) = threads_get_by_interest($uid, $folder, $page, 1);
            break;

        case UNREAD_HIGH_INTEREST:

            list($thread_info, $folder_order) = threads_get_unread_by_interest($uid, $folder, $page, 1);
            break;

        case RECENTLY_SEEN:

            list($thread_info, $folder_order) = threads_get_recently_viewed($uid, $folder, $page);
            break;

        case IGNORED_THREADS:

            list($thread_info, $folder_order) = threads_get_by_interest($uid, $folder, $page, -1);
            break;

        case BY_IGNORED_USERS:

            list($thread_info, $folder_order) = threads_get_by_relationship($uid, $folder, $page, USER_IGNORED_COMPLETELY);
            break;

        case SUBSCRIBED_TO:

            list($thread_info, $folder_order) = threads_get_by_interest($uid, $folder, $page, 2);
            break;

        case STARTED_BY_FRIEND:

            list($thread_info, $folder_order) = threads_get_by_relationship($uid, $folder, $page, USER_FRIEND);
            break;

        case UNREAD_STARTED_BY_FRIEND:

            list($thread_info, $folder_order) = threads_get_unread_by_relationship($uid, $folder, $page, USER_FRIEND);
            break;

        case STARTED_BY_ME:

            list($thread_info, $folder_order) = threads_get_started_by_me($uid, $folder, $page);
            break;

        case POLL_THREADS:

            list($thread_info, $folder_order) = threads_get_polls($uid, $folder, $page);
            break;

        case STICKY_THREADS:

            list($thread_info, $folder_order) = threads_get_sticky($uid, $folder, $page);
            break;

        case MOST_UNREAD_POSTS:

            list($thread_info, $folder_order) = threads_get_longest_unread($uid, $folder, $page);
            break;

        case DELETED_THREADS:

            list($thread_info, $folder_order) = threads_get_deleted($uid, $folder, $page);
            break;

        default:

            list($thread_info, $folder_order) = threads_get_all($uid, $folder, $page);
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
    // While we're here we can also check to see how the user
    // has decided to display the thread list.
    if (!is_array($folder_order) || (session::get_value('THREADS_BY_FOLDER') == 'Y')) {
        $folder_order = array_keys($folder_info);
    }

    // Sort the folders and threads correctly as per the URL query for the TID
    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid) = explode('.', $_GET['msg']);

        if (($thread = thread_get($tid))) {

            if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

            if ((session::get_value('THREADS_BY_FOLDER') == 'N') || !session::logged_in()) {

                if (in_array($thread['FID'], $folder_order)) {
                    array_splice($folder_order, array_search($thread['FID'], $folder_order), 1);
                }

                array_unshift($folder_order, $thread['FID']);
            }

            if (!is_array($thread_info)) $thread_info = array();

            if (isset($thread_info[$tid])) {
                unset($thread_info[$tid]);
            } else {
                array_pop($thread_info);
            }

            array_unshift($thread_info, $thread);
        }
    }

    // Work out if any folders have no messages and add them.
    // Seperate them by INTEREST level
    if (session::get_value('UID') > 0) {

        if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            list($tid) = explode('.', $_GET['msg']);

            if (($thread = thread_get($tid))) {
                $selected_folder = $thread['FID'];
            }

        } else if (isset($_GET['folder'])) {

            $selected_folder = $_GET['folder'];

        } else {

            $selected_folder = 0;
        }

        $ignored_folders = array();

        while (list($fid, $folder_data) = each($folder_info)) {
            if ($folder_data['INTEREST'] == FOLDER_NOINTEREST || (isset($selected_folder) && $selected_folder == $fid)) {
                if ((!in_array($fid, $folder_order)) && (!in_array($fid, $ignored_folders))) $folder_order[] = $fid;
            } else {
                if ((!in_array($fid, $folder_order)) && (!in_array($fid, $ignored_folders))) $ignored_folders[] = $fid;
            }
        }

        // Append ignored folders onto the end of the folder list.
        // This will make them appear at the bottom of the thread list.
        $folder_order = array_merge($folder_order, $ignored_folders);

    } else {

        while (list($fid, $folder_data) = each($folder_info)) {
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

            if ((!session::logged_in()) || ($folder_info[$folder_number]['INTEREST'] > FOLDER_IGNORED) || ($mode == UNREAD_DISCUSSIONS_TO_ME) || (isset($selected_folder) && $selected_folder == $folder_number)) {

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
                        echo "<div class=\"folder_navigation\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder&amp;page=", ($page - 1), "\">", gettext("Previous 50 threads"), "</a></div>\n";
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
                            if (isset($thread['AID']) && is_md5($thread['AID'])) echo "<span class=\"thread_attachment\" title=\"", gettext("Attachment"), "\">[A]</span>";

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

                    if (is_numeric($folder) && ($folder_number == $folder)) {
                        echo "<div class=\"folder_pagination\"><a href=\"lthread_list.php?webtag=$webtag&amp;mode=$mode&amp;folder=$folder&amp;page=", ($page + 1), "\">", gettext("Next 50 threads"), "</a></div>\n";
                    }

                } else if ($folder_info[$folder_number]['INTEREST'] != -1) {

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

    if ($mode == ALL_DISCUSSIONS && !isset($folder)) {
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

function light_draw_pm_inbox()
{
    $webtag = get_webtag();

    // Default values
    $pm_new_count = 0;
    $pm_outbox_count = 0;
    $pm_unread_count = 0;

    // Check for new PMs
    pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

    if (!($pm_folder_names_array = pm_get_folder_names())) {

        $pm_folder_names_array = array(
            PM_FOLDER_INBOX => gettext("Inbox"),
            PM_FOLDER_SENT => gettext("Sent Items"),
            PM_FOLDER_OUTBOX => gettext("Outbox"),
            PM_FOLDER_SAVED => gettext("Saved Items"),
            PM_FOLDER_DRAFTS => gettext("Drafts")
        );
    }

    // Check to see which page we should be on
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {
        $mid = ($_GET['mid'] > 0) ? $_GET['mid'] : 0;
    } else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {
        $mid = ($_GET['pmid'] > 0) ? $_GET['pmid'] : 0;
    } else if (isset($_POST['mid']) && is_numeric($_POST['mid'])) {
        $mid = ($_POST['mid'] > 0) ? $_POST['mid'] : 0;
    }

    $folder = PM_FOLDER_INBOX;

    if (isset($_GET['folder'])) {

        if ($_GET['folder'] == PM_FOLDER_INBOX) {
            $folder = PM_FOLDER_INBOX;
        } else if ($_GET['folder'] == PM_FOLDER_SENT) {
            $folder = PM_FOLDER_SENT;
        } else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
            $folder = PM_FOLDER_OUTBOX;
        } else if ($_GET['folder'] == PM_FOLDER_SAVED) {
            $folder = PM_FOLDER_SAVED;
        } else if ($_GET['folder'] == PM_FOLDER_DRAFTS) {
            $folder = PM_FOLDER_DRAFTS;
        }

    } else if (isset($_POST['folder'])) {

        if ($_POST['folder'] == PM_FOLDER_INBOX) {
            $folder = PM_FOLDER_INBOX;
        } else if ($_POST['folder'] == PM_FOLDER_SENT) {
            $folder = PM_FOLDER_SENT;
        } else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
            $folder = PM_FOLDER_OUTBOX;
        } else if ($_POST['folder'] == PM_FOLDER_SAVED) {
            $folder = PM_FOLDER_SAVED;
        } else if ($_POST['folder'] == PM_FOLDER_DRAFTS) {
            $folder = PM_FOLDER_DRAFTS;
        }
    }

    if (isset($_GET['deletemsg']) && is_numeric($_GET['deletemsg']) && ($pm_message_array = pm_message_get($_GET['deletemsg']))) {

        $delete_mid = $_GET['deletemsg'];

        $pm_message_array['CONTENT'] = pm_get_content($delete_mid);

        if (isset($_POST['pm_delete_confirm'])) {

            if (pm_delete_message($delete_mid)) {

                header_redirect("lpm.php?webtag=$webtag&folder=$folder&deleted=true");
                exit;
            }

        } else if (isset($_POST['cancel'])) {

            header_redirect("lpm.php?webtag=$webtag&folder=$folder&mid=$delete_mid");
            exit;
        }

        echo "<form method=\"post\" action=\"lpm.php?deletemsg=$delete_mid&folder=$folder\">";

        light_pm_display($pm_message_array, $folder, true);

        echo "<div class=\"post_buttons\">";
        echo light_form_submit("pm_delete_confirm", gettext("Delete"));
        echo light_form_submit("cancel", gettext("Cancel"));
        echo "</div>\n";

        return;
    }

    if (isset($mid) && is_numeric($mid)) {

        if (!($folder = pm_message_get_folder($mid))) {

            light_html_display_error_msg(gettext("Message not found in selected folder. Check that it hasn't been moved or deleted."));
            return;
        }

        if (!$pm_message_array = pm_message_get($mid)) {

            light_html_display_error_msg(gettext("Message not found. Check that it hasn't been deleted."));
            return;
        }

        if (isset($_GET['message_sent'])) {
            light_html_display_success_msg(gettext("Message sent successfully."));
        } else if (isset($_GET['deleted'])) {
            light_html_display_success_msg(gettext("Successfully deleted selected messages"));
        } else if (isset($_GET['message_saved'])) {
            light_html_display_success_msg(gettext("Message was successfully saved to 'Drafts' folder"));
        }

        $pm_message_array['CONTENT'] = pm_get_content($mid);

        light_pm_display($pm_message_array, $folder);

        echo "<a href=\"lpm.php?webtag=$webtag&amp;folder=$folder\" class=\"folder_list_link\">", gettext("Back to folder list"), "</a>";

    } else {

        if (isset($_GET['message_sent'])) {
            light_html_display_success_msg(gettext("Message sent successfully."));
        } else if (isset($_GET['deleted'])) {
            light_html_display_success_msg(gettext("Successfully deleted selected messages"));
        } else if (isset($_GET['message_saved'])) {
            light_html_display_success_msg(gettext("Message was successfully saved to 'Drafts' folder"));
        }

        $pm_message_count_array = pm_get_folder_message_counts();

        echo "<div id=\"folder_view\">\n";
        echo "<form accept-charset=\"utf-8\" method=\"get\" action=\"lpm.php\">\n";
        echo "<ul>\n";
        echo "<li>", light_form_dropdown_array("folder", $pm_folder_names_array, $folder), "</li>\n";
        echo "<li class=\"right_col\">", light_form_submit("go", gettext("Go!")), "</li>\n";
        echo "</ul>\n";
        echo "</form>\n";
        echo "</div>\n";

        if (isset($pm_message_count_array[$folder]) && is_numeric($pm_message_count_array[$folder])) {

            echo "<div class=\"folder\">";
            echo "  <h3>{$pm_folder_names_array[$folder]}</h3>\n";
            echo "  <div class=\"folder_inner\">\n";
            echo "    <div class=\"folder_info\">{$pm_message_count_array[$folder]} ", gettext("Messages"), "</div>\n";

            if ($folder == PM_FOLDER_INBOX) {

                $pm_messages_array = pm_get_inbox(false, false, $page, 20);

            } else if ($folder == PM_FOLDER_SENT) {

                $pm_messages_array = pm_get_sent(false, false, $page, 20);

            } else if ($folder == PM_FOLDER_OUTBOX) {

                $pm_messages_array = pm_get_outbox(false, false, $page, 20);

            } else if ($folder == PM_FOLDER_SAVED) {

                $pm_messages_array = pm_get_saved_items(false, false, $page, 20);

            } else if ($folder == PM_FOLDER_DRAFTS) {

                $pm_messages_array = pm_get_drafts(false, false, $page, 20);
            }

            if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {

                if ($page> 1) {
                    echo "<div class=\"folder_pagination\"><a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;page=", ($page - 1), "\">", gettext("Previous"), "</a></div>\n";
                }

                echo "<ul>\n";

                foreach ($pm_messages_array['message_array'] as $message) {

                    if ($message['TYPE'] == PM_UNREAD) {
                        echo "<li class=\"pm_unread\">";
                    } else {
                        echo "<li class=\"pm_read\">";
                    }

                    echo "<span class=\"pm_title\">";
                    echo "<a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;mid={$message['MID']}\">{$message['SUBJECT']}</a>";
                    echo "</span>";
                    echo "<span class=\"pm_time\">", format_time($message['CREATED']), "</span>";
                    echo "</li>\n";
                }

                echo "</ul>\n";

                $more_messages = $pm_message_count_array[$folder] - $page - 1;

                if ($more_messages > 0) {
                    echo "<div class=\"folder_pagination\"><a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;page=", ($page + 1), "\">", gettext("Next"), "</a></div>\n";
                }
            }

            echo "  </div>\n";
            echo "</div>\n";
        }

        echo "<a href=\"lpm_write.php?webtag=$webtag\" class=\"pm_send_new\">", gettext("Send New PM"), "</a>\n";

        // Fetch the free PM space and calculate it as a percentage.
        $pm_free_space = pm_get_free_space();
        $pm_max_user_messages = forum_get_setting('pm_max_user_messages', null, 100);

        $pm_used_percent = (100 / $pm_max_user_messages) * ($pm_max_user_messages - $pm_free_space);

        echo "<div class=\"pm_bar\">\n";
        echo "<div class=\"pm_bar_inner\" style=\"width: {$pm_used_percent}%\"></div>\n";
        echo "</div>\n";

        echo "<div class=\"pm_folder_usage\">", sprintf(gettext("Your PM folders are %s full"), "$pm_used_percent%"), "</div>\n";

        if (pm_auto_prune_enabled()) {
            light_html_display_warning_msg(gettext("PM Folder pruning is enabled!"));
        }
    }
}

function light_draw_my_forums()
{
    $webtag = get_webtag();

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    if (isset($_GET['webtag_error'])) {
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

function light_form_dropdown_array($name, $options_array, $default = "", $custom_html = false)
{
    $html = "<select name=\"$name\" class=\"select\"";

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

function light_form_submit($name = "submit", $value = "Submit", $custom_html = "")
{
    $html = "<input type=\"submit\" name=\"$name\" value=\"$value\" class=\"button\" ";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf("%s ", trim($custom_html));
    }

    $html.= "/>";
    return $html;
}

function light_messages_top($tid, $pid, $thread_title, $thread_interest_level = THREAD_NOINTEREST, $sticky = "N", $closed = false, $locked = false, $deleted = false)
{
    $webtag = get_webtag();

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

function light_form_radio($name, $value, $text, $checked = false, $custom_html = false)
{
    $html = "<label><input type=\"radio\" name=\"$name\" value=\"$value\" class=\"radio\"";

    if ($checked) {
        $html.= " checked=\"checked\"";
    }

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= " />$text</label>";

    return $html;
}

function light_form_quick_button($href, $label, $var_array = false, $target = "_self")
{
    $webtag = get_webtag();

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

    if (((!is_array($user_poll_votes_array) || $poll_data['CHANGEVOTE'] == POLL_VOTE_MULTI) && (session::get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', 'Y')))) && ($poll_data['CLOSES'] == 0 || $poll_data['CLOSES'] > time()) && !$is_preview) {

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

            } else if (session::get_value('UID') > 0 || ($poll_data['ALLOWGUESTS'] == POLL_GUEST_ALLOWED && forum_get_setting('poll_allow_guests', 'Y'))) {

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

    $poll_data['FROM_RELATIONSHIP'] = user_get_relationship(session::get_value('UID'), $poll_data['FROM_UID']);

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

    $attachments_array = array();
    $image_attachments_array = array();

    if (($uid = session::get_value('UID')) === false) return;

    if ((!isset($message['CONTENT']) || $message['CONTENT'] == "") && !$is_preview) {

        light_message_display_deleted($tid, isset($message['PID']) ? $message['PID'] : 0);
        return;
    }

    $from_user_permissions = perm_get_user_permissions($message['FROM_UID']);

    if ($uid != $message['FROM_UID']) {

        if (($from_user_permissions & USER_PERM_WORMED) && !$perm_is_moderator) {

            light_message_display_deleted($tid, $message['PID']);
            return;
        }
    }

    if (!isset($message['FROM_RELATIONSHIP'])) {

        $message['FROM_RELATIONSHIP'] = 0;
    }

    if (!isset($message['TO_RELATIONSHIP'])) {

        $message['TO_RELATIONSHIP'] = 0;
    }

    if (($message['TO_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) || ($message['FROM_RELATIONSHIP'] & USER_IGNORED_COMPLETELY)) {

        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    if (forum_get_setting('require_post_approval', 'Y') && $message['FROM_UID'] != $uid) {

        if (isset($message['APPROVED']) && $message['APPROVED'] == 0 && !$perm_is_moderator) {

            light_message_display_approval_req($tid, $message['PID']);
            return;
        }
    }

    // OUTPUT MESSAGE ----------------------------------------------------------
    if (!$is_preview && ($message['MOVED_TID'] > 0) && ($message['MOVED_PID'] > 0)) {

        $post_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_self\">%s</a>";
        $post_link = sprintf($post_link, $message['MOVED_TID'], $message['MOVED_PID'], gettext("here"));

        light_html_display_warning_msg(gettext("<b>Thread Split:</b> This post has been moved %s"), $post_link);
        return;
    }

    if ($in_list) {
        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>";
    }

    echo "<div class=\"message\">\n";

    if (session::get_value('IMAGES_TO_LINKS') == 'Y') {

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
    echo "", gettext("From"), ": ", word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK']), true);

    if ($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "<span class=\"user_friend\" title=\"", gettext("Friend"), "\">[F]</span>";
    } else if (($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        echo "<span class=\"user_enemy\" title=\"", gettext("Ignored user"), "\">[E]</span>";
    }

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        $message['FROM_RELATIONSHIP']-= USER_IGNORED;
    }

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text) {

        echo gettext("Ignored message");

    } else {

        if ($in_list) {

            if (($from_user_permissions & USER_PERM_WORMED)) echo gettext("Wormed user");
            echo "<span class=\"message_time\">", format_time($message['CREATED']), "</span>\n";
        }
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>";
    echo "<div class=\"message_to\">\n";

    if (($message['TLOGON'] != gettext("ALL")) && $message['TO_UID'] != 0) {

        echo "", gettext("To"), ": ", word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK']), true);

        if ($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "<span class=\"user_friend\" title=\"", gettext("Friend"), "\">[F]</span>";
        } else if (($message['TO_RELATIONSHIP'] & USER_IGNORED)) {
            echo "<span class=\"user_enemy\" title=\"", gettext("Ignored user"), "\">[E]</span>";
        }

        if (!$is_preview) {

            if (isset($message['VIEWED']) && $message['VIEWED'] > 0) {
                echo "<span class=\"message_read\">", format_time($message['VIEWED']), "</span>";
            } else {
                echo "<span class=\"message_unread\" title=\"", gettext("Unread"), "\"></span>";
            }
        }

    } else {

        echo "", gettext("To"), ": ", gettext("ALL"), "";
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

            if (($edit_user = user_get_logon($message['EDITED_BY']))) {

                echo "<div class=\"edit_text\">", sprintf(gettext("EDITED: %s by %s"), format_time($message['EDITED']), $edit_user), "</div>\n";
            }
        }
    }

    echo "</div>\n";

    if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

        $aid = isset($message['AID']) ? $message['AID'] : attachments_get_id($tid, $message['PID']);

        if (attachments_get($message['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

            if (sizeof($attachments_array) > 0) {

                echo "<div class=\"message_attachments\">\n";
                echo "  <span>", gettext("Attachments"), ":</span>\n";
                echo "  <ul>\n";

                foreach ($attachments_array as $attachment) {

                    if (($attachment_link = light_attachments_make_link($attachment))) {

                        echo "<li>", $attachment_link, "</li>\n";
                    }
                }

                echo "  </ul>\n";
                echo "</div>\n";
            }

            if (sizeof($image_attachments_array) > 0) {

                echo "<div class=\"message_attachments\">\n";
                echo "  <span>", gettext("Image Attachments"), ":</span>\n";
                echo "  <ul>\n";

                foreach ($image_attachments_array as $attachment) {

                    if (($attachment_link = light_attachments_make_link($attachment))) {

                        echo "<li>", $attachment_link, "</li>\n";
                    }
                }

                echo "  </ul>\n";
                echo "</div>\n";
            }
        }
    }

    if (!$is_preview && $msg_count > 0) {

        $links_array = array();

        if (!$closed && session::check_perm(USER_PERM_POST_CREATE, $folder_fid)) {

            $links_array[] = "<a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\" class=\"reply\">". gettext("Reply"). "</a>";
        }

        if (($uid == $message['FROM_UID'] && session::check_perm(USER_PERM_POST_DELETE, $folder_fid) && !session::check_perm(USER_PERM_PILLORIED, 0)) || $perm_is_moderator) {

            $links_array[] = "<a href=\"ldelete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" class=\"delete\">". gettext("Delete"). "</a>";
        }

        if ((!(session::check_perm(USER_PERM_PILLORIED, 0)) && ((($uid != $message['FROM_UID']) && ($from_user_permissions & USER_PERM_PILLORIED)) || ($uid == $message['FROM_UID'])) && session::check_perm(USER_PERM_POST_EDIT, $folder_fid) && ($post_edit_time == 0 || (time() - $message['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS)) && forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

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
    if (session::get_value('USE_LIGHT_MODE_SPOILER') == "Y") {
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

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    while (($folder_order = $result->fetch_assoc())) {

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

function light_form_textarea($name, $value = "", $rows = 0, $cols = 0, $custom_html = '', $class = 'textarea')
{
    if (!is_numeric($rows)) $rows = 5;
    if (!is_numeric($cols)) $cols = 50;

    if (strlen(trim($custom_html)) > 0) {
        $custom_html = sprintf(' %s', trim($custom_html));
    }

    return sprintf('<textarea name="%s" class="%s" rows="%s" cols="%s"%s>%s</textarea>', $name, $class, $rows, $cols, $custom_html, $value);
}

function light_form_checkbox($name, $value, $text, $checked = false, $custom_html = false)
{
    $html = "<label><input type=\"checkbox\" name=\"$name\" value=\"$value\" class=\"checkbox\"";

    if ($checked) {
        $html.= " checked=\"checked\"";
    }

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= " />$text</label>";

    return $html;
}

function light_form_field($name, $value = "", $width = false, $maxchars = false, $type = "text", $custom_html = false)
{
    $html = "<input type=\"$type\" name=\"$name\" value=\"$value\" class=\"$type\"";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($width) && $width > 0) {
        $html.= " size=\"$width\"";
    }

    if (is_numeric($maxchars) && $maxchars > 0) {
        $html.= " maxlength=\"$maxchars\"";
    }

    $html.= " />";
    return $html;
}

function light_form_input_text($name, $value = "", $width = 0, $maxlength = 0, $custom_html = false)
{
    return light_form_field($name, $value, $width, $maxlength, "text", $custom_html);
}

function light_form_input_password($name, $value = "", $width = 0, $maxlength = 0, $custom_html = false)
{
    return light_form_field($name, $value, $width, $maxlength, "password", $custom_html);
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
    if (($uid = session::get_value('UID')) === false) return;

    $user_array = user_get($uid);

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

function light_pm_display($pm_message_array, $folder, $preview = false)
{
    $webtag = get_webtag();

    echo "<div class=\"message\">\n";
    echo "<div class=\"message_header\">\n";
    echo "<div class=\"message_from\">\n";

    if ($folder == PM_FOLDER_INBOX) {

        echo "<span>", gettext("From"), ": ", word_filter_add_ob_tags(format_user_name($pm_message_array['FLOGON'], $pm_message_array['FNICK']), true), "</span>\n";

    } else {

        if (isset($pm_message_array['RECIPIENTS']) && strlen(trim($pm_message_array['RECIPIENTS'])) > 0) {

            $recipient_array = preg_split("/[;|,]/u", trim($pm_message_array['RECIPIENTS']));

            if ($pm_message_array['TO_UID'] > 0) {
                $recipient_array = array_unique(array_merge($recipient_array, array($pm_message_array['TLOGON'])));
            }

            echo "<span>", gettext("To"), ": ", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</span>\n";

        } else if (is_array($pm_message_array['TLOGON'])) {

            $recipient_array = array_unique($pm_message_array['TLOGON']);

            echo "<span>", gettext("To"), ": ", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</span>\n";

        } else if (isset($pm_message_array['TO_UID']) && is_numeric($pm_message_array['TO_UID'])) {

            echo "<span>", gettext("To"), ": ", word_filter_add_ob_tags(format_user_name($pm_message_array['TLOGON'], $pm_message_array['TNICK']), true), "</span>\n";

        } else {

            echo "<span>", gettext("To"), ": <span class=\"norecipients\">", gettext("No Recipients"), "</span></span>\n";
        }
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>\n";
    echo "<div class=\"message_subject\">\n";

    echo "", gettext("Subject"), ": ";

    if (strlen(trim($pm_message_array['SUBJECT'])) > 0) {

        echo word_filter_add_ob_tags($pm_message_array['SUBJECT'], true), "\n";

    } else {

        echo "<span class=\"no_subject\">", gettext("No Subject"), "</span>\n";
    }

    echo "<div class=\"clearer\"></div>\n";
    echo "</div>\n";
    echo "</div>\n";

    $pm_message_array['CONTENT'] = message_apply_formatting($pm_message_array['CONTENT']);
    $pm_message_array['CONTENT'] = word_filter_add_ob_tags($pm_message_array['CONTENT']);

    echo "<div class=\"message_body\">", $pm_message_array['CONTENT'], "</div>\n";

    if (isset($pm_message_array['AID'])) {

        $aid = $pm_message_array['AID'];

        $attachments_array = array();
        $image_attachments_array = array();

        if (attachments_get($pm_message_array['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

            if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

                echo "<div class=\"message_attachments\">\n";
                echo "  <span>", gettext("Attachments"), ":</span>\n";
                echo "  <ul>\n";

                foreach ($attachments_array as $attachment) {

                    if (($attachment_link = light_attachments_make_link($attachment))) {

                        echo "<li>", $attachment_link, "</li>\n";
                    }
                }

                echo "  </ul>\n";
                echo "</div>\n";
            }

            if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

                echo "<div class=\"message_attachments\">\n";
                echo "  <span>", gettext("Image Attachments"), ":</span>\n";
                echo "  <ul>\n";

                foreach ($image_attachments_array as $attachment) {

                    if (($attachment_link = light_attachments_make_link($attachment))) {

                        echo "<li>", $attachment_link, "</li>\n";
                    }
                }

                echo "  </ul>\n";
                echo "</div>\n";
            }
        }
    }

    if ($preview === false) {

        $links_array = array();

        if ($folder == PM_FOLDER_INBOX) {

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;replyto={$pm_message_array['MID']}\" class=\"reply\">". gettext("Reply"). "</a>";
            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" class=\"forward\">". gettext("Forward"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;deletemsg={$pm_message_array['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";

        } else if ($folder == PM_FOLDER_OUTBOX) {

            $links_array[] = "<a href=\"lpm_edit.php?webtag=$webtag&amp;mid={$pm_message_array['MID']}\" class=\"edit\">". gettext("Edit"). "</a>";
            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" class=\"forward\">". gettext("Forward"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;deletemsg={$pm_message_array['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";

        } else if ($folder == PM_FOLDER_DRAFTS) {

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;editmsg={$pm_message_array['MID']}\" class=\"edit\">". gettext("Edit"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;deletemsg={$pm_message_array['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";

        } else {

            $links_array[] = "<a href=\"lpm_write.php?webtag=$webtag&amp;fwdmsg={$pm_message_array['MID']}\" class=\"forward\">". gettext("Forward"). "</a>";
            $links_array[] = "<a href=\"lpm.php?webtag=$webtag&amp;folder=$folder&amp;deletemsg={$pm_message_array['MID']}\" class=\"delete\">". gettext("Delete"). "</a>";
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

    // Default the variables to return 0 even on error.
    $pm_new_count = 0;
    $pm_outbox_count = 0;
    $pm_unread_count = 0;

    // Get the number of messages.
    pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

    // Format the message sent to the client.
    if ($pm_new_count == 1 && $pm_outbox_count == 0) {

        $pm_notification = gettext("You have 1 new message. Would you like to go to your Inbox now?");

    } else if ($pm_new_count == 1 && $pm_outbox_count == 1) {

        $pm_notification = gettext("You have 1 new message.

You also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.

Would you like to go to your Inbox now?");

    } else if ($pm_new_count == 0 && $pm_outbox_count == 1) {

        $pm_notification = gettext("You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.

Would you like to go to your Inbox now?");

    } else if ($pm_new_count > 1 && $pm_outbox_count == 0) {

        $pm_notification = sprintf(gettext("You have %d new messages. Would you like to go to your Inbox now?"), $pm_new_count);

    } else if ($pm_new_count > 1 && $pm_outbox_count == 1) {

        $pm_notification = sprintf(gettext("You have %d new messages.

You also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.

Would you like to go to your Inbox now?"), $pm_new_count);

    } else if ($pm_new_count > 1 && $pm_outbox_count > 1) {

        $pm_notification = sprintf(gettext("You have %d new messages.

You also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.

Would you like to go to your Inbox now?"), $pm_new_count, $pm_outbox_count);

    } else if ($pm_new_count == 1 && $pm_outbox_count > 1) {

        $pm_notification = sprintf(gettext("You have 1 new message.

You also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.

Would you like to go to your Inbox now?"), $pm_outbox_count);

    } else if ($pm_new_count == 0 && $pm_outbox_count > 1) {

        $pm_notification = sprintf(gettext("You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.

Would you like to go to your Inbox now?"), $pm_outbox_count);
    }

    if (isset($pm_notification) && strlen(trim($pm_notification)) > 0) {

        // Wrap the notification in a hyperlink.
        $pm_notification = sprintf("<a href=\"lpm.php?webtag=$webtag\">%s</a>\n", $pm_notification);

        // Display the notification
        light_html_display_success_msg($pm_notification);
    }

    // Prevent checking again.
    $light_pm_check_messages_done = true;
}

?>