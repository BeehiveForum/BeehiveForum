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

/* $Id: light.inc.php,v 1.216 2009-01-17 23:37:46 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "adsense.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "myforums.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function light_html_draw_top()
{
    $lang = load_language_file();

    $arg_array = func_get_args();

    $title = "";

    $robots = "index,follow";

    $link_array = array();

    $func_matches = array();

    if (defined('BEEHIVE_LIGHT_INCLUDE')) return;

    foreach ($arg_array as $key => $func_args) {

        if (preg_match('/^title=([^$]+)$/Diu', $func_args, $func_matches) > 0) {
            if (strlen($title) < 1) $title = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^robots=([^$]+)$/Diu', $func_args, $func_matches) > 0) {
            if (strlen($robots) < 1) $robots = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^link=([^:]+):([^$]+)$/Diu', $func_args, $func_matches) > 0) {
            $link_array[] = array('rel' => $func_matches[1], 'href' => $func_matches[2]);
            unset($arg_array[$key]);
        }
    }

    if (strlen($title) < 1) $title = forum_get_setting('forum_name', false, 'A Beehive Forum');

    $forum_keywords = html_get_forum_keywords();
    $forum_description = html_get_forum_description();

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
    echo "<meta name=\"generator\" content=\"Beehive Forum ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"keywords\" content=\"$forum_keywords\" />\n";
    echo "<meta name=\"description\" content=\"$forum_description\" />\n";

    if (forum_get_setting('allow_search_spidering', 'N')) {

        echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";

    }elseif (strlen(trim($robots)) > 0) {

        echo "<meta name=\"robots\" content=\"$robots\" />\n";
    }

    if (($stylesheet = html_get_style_sheet())) {
        echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" media=\"screen, handheld\" />\n";
    }

    if (isset($link_array) && is_array($link_array)) {

        foreach ($link_array as $link) {

            if (isset($link['rel']) && isset($link['href'])) {

                echo "<link rel=\"{$link['rel']}\" href=\"{$link['href']}\" />\n";
            }
        }
    }

    echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"js/general.js\"></script>\n";

    $message_display_pages = array('admin_post_approve.php', 'create_poll.php',
                                   'delete.php', 'display.php', 'edit.php',
                                   'edit_poll.php', 'edit_signature.php',
                                   'ldisplay.php', 'lmessages.php',
                                   'lpost.php', 'messages.php', 'post.php');

    if (in_array(basename($_SERVER['PHP_SELF']), $message_display_pages)) {

        if (bh_session_get_value('USE_MOVER_SPOILER') == "Y") {

            echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"js/general.js\"></script>\n";
            echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"js/spoiler.js\"></script>\n";
            echo "</head>\n";
            echo "<body onload=\"spoilerInitialise()\">\n";

            return;
        }
    }

    echo "</head>\n";
    echo "<body>\n";
    
    if (html_output_adsense_settings() && adsense_check_user() && adsense_check_page()) {

        adsense_output_html();
        echo "<br />\n";
    }    
}

function light_html_draw_bottom()
{
    if (defined('BEEHIVE_LIGHT_INCLUDE')) return;

    echo "</body>\n";
    echo "</html>\n";
}

function light_draw_logon_form()
{
    $lang = load_language_file();

    $webtag = get_webtag();
    
    forum_check_webtag_available($webtag);

    bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);

    $user_logon = bh_getcookie('bh_light_remember_username', 'strlen', '');

    $user_password = bh_getcookie('bh_light_remember_password', 'strlen', '');

    $user_passhash = bh_getcookie('bh_light_remember_passhash', 'strlen', '');
    
    echo "<form accept-charset=\"utf-8\" name=\"logonform\" action=\"llogon.php\" method=\"post\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  <p>{$lang['username']}: ", light_form_input_text("user_logon", htmlentities_array(stripslashes_array($user_logon)), 20, 15, "autocomplete=\"off\""). "</p>\n";
    echo "  <p>{$lang['passwd']}: ", light_form_input_password("user_password", htmlentities_array(stripslashes_array($user_password)), 20, 32, "autocomplete=\"off\""), form_input_hidden("user_passhash", htmlentities_array(stripslashes_array($user_passhash))), "</p>\n";
    echo "  <p>", light_form_checkbox("remember_user", "Y", $lang['rememberpassword'], (strlen($user_password) > 0 && strlen($user_passhash) > 0) && bh_getcookie('bh_light_remember_password'), "autocomplete=\"off\""), "</p>\n";
    echo "  <p>", light_form_checkbox("auto_logon", "Y", $lang['logmeinautomatically'], false, "autocomplete=\"off\""), "</p>\n";
    echo "  <p>", light_form_submit('logon', $lang['logon']), "</p>\n";
    echo "</form>\n";
}

function light_draw_messages($msg)
{
    if (!validate_msg($msg)) return;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $lang = load_language_file();

    list($tid, $pid) = explode('.', $msg);

    if (($posts_per_page = bh_session_get_value('POSTS_PER_PAGE'))) {

        if ($posts_per_page < 10) $posts_per_page = 10;
        if ($posts_per_page > 30) $posts_per_page = 30;

    }else {

        $posts_per_page = 20;
    }

    if (!$thread_data = thread_get($tid, bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['threadcouldnotbefound']);
        light_html_draw_bottom();
        exit;
    }

    if (!$folder_data = folder_get($thread_data['FID'])) {

        html_draw_top();
        html_error_msg($lang['foldercouldnotbefound']);
        html_draw_bottom();
        exit;
    }

    if (!$messages = messages_get($tid, $pid, $posts_per_page)) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['postdoesnotexist']);
        light_html_draw_bottom();
        exit;
    }

    // Previous and Next page links

    $prev_page = ($pid - $posts_per_page > 0) ? $pid - $posts_per_page : 1;

    $next_page = ($pid + $posts_per_page < $thread_data['LENGTH']) ? $pid + $posts_per_page : $thread_data['LENGTH'];

    // SEF links.

    $contents_href = "lthread_list.php?webtag=$webtag";

    $first_page_href = "lmessages.php?webtag=$webtag&amp;msg=$tid.1";

    $last_page_href  = "lmessages.php?webtag=$webtag&amp;msg=$tid.{$thread_data['LENGTH']}";

    $parent_href = "lthread_list.php?webtag=DEFAULT&amp;folder={$folder_data['FID']}";

    $next_page_href = "lmessages.php?webtag=$webtag&amp;msg=$tid.$next_page";

    $prev_page_href = "lmessages.php?webtag=$webtag&amp;msg=$tid.$prev_page";

    // Forum name, folder title and thread title.

    $forum_name   = forum_get_setting('forum_name', false, 'A Beehive Forum');

    $thread_title = htmlentities_array(thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']));

    light_html_draw_top("title=$forum_name > $thread_title", "link=contents:$contents_href", "link=first:$first_page_href", "link=previous:$prev_page_href", "link=next:$next_page_href", "link=last:$last_page_href", "link=up:$parent_href");

    $msg_count = count($messages);

    light_messages_top($msg, $thread_title, $thread_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK']);

    if (($tracking_data_array = thread_get_tracking_data($tid))) {

        foreach ($tracking_data_array as $tracking_data) {

            if ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_MERGE) { // Thread merged

                if ($tracking_data['TID'] == $tid) {

                    $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], $lang['threadmovedhere']);

                    echo "<p>", sprintf($lang['thisthreadhasmoved'], $thread_link), "</p>\n";
                }

                if ($tracking_data['NEW_TID'] == $tid) {

                    $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['TID'], $lang['threadmovedhere']);

                    echo "<p>", sprintf($lang['thisthreadwasmergedfrom'], $thread_link), "</p>\n";
                }

            }elseif ($tracking_data['TRACK_TYPE'] == THREAD_TYPE_SPLIT) { // Thread Split

                if ($tracking_data['TID'] == $tid) {

                    $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['NEW_TID'], $lang['threadmovedhere']);

                    echo "<p>", sprintf($lang['somepostsinthisthreadhavebeenmoved'], $thread_link), "</p>\n";
                }

                if ($tracking_data['NEW_TID'] == $tid) {

                    $thread_link = "<a href=\"messages.php?webtag=$webtag&amp;msg=%s.1\" target=\"_self\">%s</a>";
                    $thread_link = sprintf($thread_link, $tracking_data['TID'], $lang['threadmovedhere']);

                    echo "<p>", sprintf($lang['somepostsinthisthreadweremovedfrom'], $thread_link), "</p>\n";
                }
            }
        }
    }

    if ($msg_count > 0) {

        foreach ($messages as $message_number => $message) {

            if (isset($message['RELATIONSHIP'])) {

                if ($message['RELATIONSHIP'] >= 0) { // if we're not ignoring this user
                    $message['CONTENT'] = message_get_content($tid, $message['PID']);
                }else {
                    $message['CONTENT'] = $lang['ignored']; // must be set to something or will show as deleted
                }

            }else {

              $message['CONTENT'] = message_get_content($tid, $message['PID']);

            }

            if ($thread_data['POLL_FLAG'] == 'Y') {

                if ($message['PID'] == 1) {

                    light_poll_display($tid, $thread_data['LENGTH'], $thread_data['FID'], true, $thread_data['CLOSED'], true, false);
                    $last_pid = $message['PID'];

                }else {

                    light_message_display($tid, $message, $thread_data['LENGTH'], $thread_data['FID'], true, $thread_data['CLOSED'], true, true, false);
                    $last_pid = $message['PID'];
                }

            }else {

                light_message_display($tid, $message, $thread_data['LENGTH'], $thread_data['FID'], true, $thread_data['CLOSED'], true, false, false);
                $last_pid = $message['PID'];
            }
            
            if (adsense_check_user() && adsense_check_page($message_number, $posts_per_page, $thread_data['LENGTH'])) {

                echo "<br />\n";
                adsense_output_html();
            }            
        }
    }

    unset($messages, $message);

    if ($last_pid < $thread_data['LENGTH']) {

        $npid = $last_pid + 1;
        echo form_quick_button("lmessages.php", $lang['keepreading'], array('msg' => "$tid.$npid"));
    }

    light_messages_nav_strip($tid, $pid, $thread_data['LENGTH'], $posts_per_page);

    if (($thread_data['CLOSED'] == 0 && bh_session_check_perm(USER_PERM_POST_CREATE, $thread_data['FID'])) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $thread_data['FID'])) {
        echo "<p><a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.0\" target=\"_parent\">{$lang['replyall']}</a></p>\n";
    }

    if (($msg_count > 0 && !user_is_guest())) {
        messages_update_read($tid, $last_pid, $thread_data['LAST_READ'], $thread_data['LENGTH'], $thread_data['MODIFIED']);
    }
}

function light_draw_thread_list($mode = ALL_DISCUSSIONS, $folder = false, $start_from = 0)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $lang = load_language_file();

    $error_msg_array = array();

    $visible_threads_array = array();

    if (($uid = bh_session_get_value('UID')) === false) return;

    echo "<form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"lthread_list.php\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  ", light_threads_draw_discussions_dropdown($mode), "\n";
    echo "  ", light_form_submit("go", $lang['goexcmark']), "\n";
    echo "</form>\n";

    // The tricky bit - displaying the right threads for whatever mode is selected

    if (isset($folder) && is_numeric($folder) && $folder > 0) {
        list($thread_info, $folder_order) = threads_get_folder($uid, $folder, $start_from);
    }else {
        switch ($mode) {
            case ALL_DISCUSSIONS:
                list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
                break;
            case UNREAD_DISCUSSIONS:
                list($thread_info, $folder_order) = threads_get_unread($uid);
                break;
            case UNREAD_DISCUSSIONS_TO_ME:
                list($thread_info, $folder_order) = threads_get_unread_to_me($uid);
                break;
            case TODAYS_DISCUSSIONS:
                list($thread_info, $folder_order) = threads_get_by_days($uid, 1);
                break;
            case UNREAD_TODAY:
                list($thread_info, $folder_order) = threads_get_unread_by_days($uid);
                break;
            case TWO_DAYS_BACK:
                list($thread_info, $folder_order) = threads_get_by_days($uid, 2);
                break;
            case SEVEN_DAYS_BACK:
                list($thread_info, $folder_order) = threads_get_by_days($uid, 7);
                break;
            case HIGH_INTEREST:
                list($thread_info, $folder_order) = threads_get_by_interest($uid, 1);
                break;
            case UNREAD_HIGH_INTEREST:
                list($thread_info, $folder_order) = threads_get_unread_by_interest($uid, 1);
                break;
            case RECENTLY_SEEN:
                list($thread_info, $folder_order) = threads_get_recently_viewed($uid);
                break;
            case IGNORED_THREADS:
                list($thread_info, $folder_order) = threads_get_by_interest($uid, -1);
                break;
            case BY_IGNORED_USERS:
                list($thread_info, $folder_order) = threads_get_by_relationship($uid, USER_IGNORED_COMPLETELY);
                break;
            case SUBSCRIBED_TO:
                list($thread_info, $folder_order) = threads_get_by_interest($uid, 2);
                break;
            case STARTED_BY_FRIEND:
                list($thread_info, $folder_order) = threads_get_by_relationship($uid, USER_FRIEND);
                break;
            case UNREAD_STARTED_BY_FRIEND:
                list($thread_info, $folder_order) = threads_get_unread_by_relationship($uid, USER_FRIEND);
                break;
            case STARTED_BY_ME:
                list($thread_info, $folder_order) = threads_get_started_by_me($uid);
                break;
            case POLL_THREADS:
                list($thread_info, $folder_order) = threads_get_polls($uid);
                break;
            case STICKY_THREADS:
                list($thread_info, $folder_order) = threads_get_sticky($uid);
                break;
            case MOST_UNREAD_POSTS:
                list($thread_info, $folder_order) = threads_get_longest_unread($uid);
                break;
            case DELETED_THREADS:
                list($thread_info, $folder_order) = threads_get_deleted($uid);
                break;
            default:
                list($thread_info, $folder_order) = threads_get_all($uid, $start_from);
                break;
        }
    }

    // Now, the actual bit that displays the threads...

    // Get folder FIDs and titles

    if (!$folder_info = threads_get_folders()) {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['couldnotretrievefolderinformation']);
        light_html_draw_bottom();
        exit;
    }

    // Get total number of messages for each folder

    $folder_msgs = threads_get_folder_msgs();

    // Check that the folder order is a valid array.
    // While we're here we can also check to see how the user
    // has decided to display the thread list.

    if (!is_array($folder_order) || (bh_session_get_value('THREADS_BY_FOLDER') == 'Y')) {
        $folder_order = array_keys($folder_info);
    }

    // Sort the folders and threads correctly as per the URL query for the TID

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid) = explode('.', $_GET['msg']);

        if (($thread = thread_get($tid))) {

            if (!isset($thread['RELATIONSHIP'])) $thread['RELATIONSHIP'] = 0;

            if ((bh_session_get_value('THREADS_BY_FOLDER') == 'N') || user_is_guest()) {

                if (in_array($thread['FID'], $folder_order)) {
                    array_splice($folder_order, array_search($thread['FID'], $folder_order), 1);
                }

                array_unshift($folder_order, $thread['FID']);
            }

            if (!is_array($thread_info)) $thread_info = array();

            if (isset($thread_info[$tid])) {
                unset($thread_info[$tid]);
            }else {
                array_pop($thread_info);
            }

            array_unshift($thread_info, $thread);
        }
    }

    // Work out if any folders have no messages and add them.
    // Seperate them by INTEREST level

    if (bh_session_get_value('UID') > 0) {

        if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            list($tid) = explode('.', $_GET['msg']);

            if (($thread = thread_get($tid))) {
                $selected_folder = $thread['FID'];
            }

        }elseif (isset($_GET['folder'])) {

            $selected_folder = $_GET['folder'];

        }else {

            $selected_folder = 0;
        }

        $ignored_folders = array();

        while (list($fid, $folder_data) = each($folder_info)) {
            if ($folder_data['INTEREST'] == FOLDER_NOINTEREST || (isset($selected_folder) && $selected_folder == $fid)) {
                if ((!in_array($fid, $folder_order)) && (!in_array($fid, $ignored_folders))) $folder_order[] = $fid;
            }else {
                if ((!in_array($fid, $folder_order)) && (!in_array($fid, $ignored_folders))) $ignored_folders[] = $fid;
            }
        }

        // Append ignored folders onto the end of the folder list.
        // This will make them appear at the bottom of the thread list.

        $folder_order = array_merge($folder_order, $ignored_folders);

    }else {

        while (list($fid, $folder_data) = each($folder_info)) {
            if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
        }
    }

    // If no threads are returned, say something to that effect

    if (isset($_GET['mark_read_success'])) {

        light_html_display_success_msg($lang['successfullymarkreadselectedthreads'], '100%', 'left');

    }else if (!$thread_info) {

        $all_discussions_link = sprintf("<a href=\"thread_list.php?webtag=$webtag&amp;mode=0\">%s</a>", $lang['clickhere']);
        light_html_display_warning_msg(sprintf($lang['nomessagesinthiscategory'], $all_discussions_link));

    }else if (sizeof($error_msg_array) > 0) {

        light_html_display_error_array($error_msg_array, '100%', 'left');
    }

    if ($start_from != 0 && $mode == ALL_DISCUSSIONS && !isset($folder)) echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></p>\n";

    // Iterate through the information we've just got and display it in the right order

    foreach ($folder_order as $folder_number) {

        if (isset($folder_info[$folder_number]) && is_array($folder_info[$folder_number])) {

            echo "<h3><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder_number\">", word_filter_add_ob_tags(htmlentities_array($folder_info[$folder_number]['TITLE'])), "</a></h3>";

            if ((user_is_guest()) || ($folder_info[$folder_number]['INTEREST'] > FOLDER_IGNORED) || ($mode == UNREAD_DISCUSSIONS_TO_ME) || (isset($selected_folder) && $selected_folder == $folder_number)) {

                if (is_array($thread_info)) {

                    echo "<p>";

                    if (isset($folder_msgs[$folder_number])) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo " {$lang['threads']}";

                    if (is_null($folder_info[$folder_number]['STATUS']) || $folder_info[$folder_number]['STATUS'] & USER_PERM_THREAD_CREATE) {

                        if ($folder_info[$folder_number]['ALLOWED_TYPES'] & FOLDER_ALLOW_NORMAL_THREAD) echo " - <b><a href=\"lpost.php?webtag=$webtag&amp;fid=$folder_number\">{$lang['postnew']}</a></b>";
                    }

                    echo "</p>\n";

                    if ($start_from != 0 && isset($folder) && $folder_number == $folder) echo "<p><i><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from - 50)."\">{$lang['prev50threads']}</a></i></p>\n";

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

                            }elseif ($thread['LAST_READ'] < $thread['LENGTH']) {

                                $new_posts = $thread['LENGTH'] - $thread['LAST_READ'];
                                $number = "[{$new_posts}&nbsp;new&nbsp;of&nbsp;{$thread['LENGTH']}]";
                                $latest_post = $thread['LAST_READ'] + 1;

                            } else {

                                $number = "[{$thread['LENGTH']}]";
                                $latest_post = 1;

                            }

                            // work out how long ago the thread was posted and format the time to display
                            $thread_time = format_time($thread['MODIFIED']);

                            echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg={$thread['TID']}.$latest_post\" ";
                            echo "title=\"", sprintf($lang['threadstartedbytooltip'], $thread['TID'], word_filter_add_ob_tags(htmlentities_array(format_user_name($thread['LOGON'], $thread['NICKNAME']))), ($thread['VIEWCOUNT'] == 1) ? $lang['threadviewedonetime'] : sprintf($lang['threadviewedtimes'], $thread['VIEWCOUNT'])), "\">";
                            echo word_filter_add_ob_tags(htmlentities_array(thread_format_prefix($thread['PREFIX'], $thread['TITLE']))), "</a> ";

                            if ($thread['INTEREST'] == THREAD_INTERESTED) echo "<font color=\"#FF0000\">(HI)</font> ";
                            if ($thread['INTEREST'] == THREAD_SUBSCRIBED) echo "<font color=\"#FF0000\">(Sub)</font> ";
                            if ($thread['POLL_FLAG'] == 'Y') echo "(P) ";
                            if ($thread['STICKY'] == 'Y') echo "(St) ";
                            if ($thread['RELATIONSHIP'] & USER_FRIEND) echo "(Fr) ";

                            echo $number." ";
                            echo $thread_time." ";
                            echo "</li>\n";
                        }
                    }

                    if ($folder_list_end === false && $folder_list_start === true) {

                        echo "</ul>\n";
                        $folder_list_end = true;
                    }

                    if (isset($folder) && $folder_number == $folder) {

                        $more_threads = $folder_msgs[$folder] - $start_from - 50;

                        if ($more_threads > 0 && $more_threads <= 50) echo "<p><i><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\">", sprintf($lang['nextxthreads'], $more_threads), "</a></i></p>\n";
                        if ($more_threads > 50) echo "<p><i><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder&amp;start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></i></p>\n";

                    }

                }elseif ($folder_info[$folder_number]['INTEREST'] != -1) {

                    echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$folder_number\">";

                    if (isset($folder_msgs[$folder_number])) {
                        echo $folder_msgs[$folder_number];
                    }else {
                        echo "0";
                    }

                    echo " {$lang['threads']}</a>";
                    if ($folder_info[$folder_number]['ALLOWED_TYPES']&FOLDER_ALLOW_NORMAL_THREAD) echo " - <b><a href=\"lpost.php?webtag=$webtag&amp;fid=$folder_number\">{$lang['postnew']}</a></b>";
                    echo "</p>\n";
                }

            }

            if (is_array($thread_info)) reset($thread_info);
        }
    }

    if ($mode == ALL_DISCUSSIONS && !isset($folder)) {

        $total_threads = 0;

        if (is_array($folder_msgs)) {

          while (list($fid, $num_threads) = each($folder_msgs)) {
            $total_threads += $num_threads;
          }

          $more_threads = $total_threads - $start_from - 50;
          if ($more_threads > 0 && $more_threads <= 50) echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\">", sprintf($lang['nextxthreads'], $more_threads), "</p>\n";
          if ($more_threads > 50) echo "<p><a href=\"lthread_list.php?webtag=$webtag&amp;mode=0&amp;start_from=".($start_from + 50)."\">{$lang['next50threads']}</a></p>\n";

        }
    }

    if (!user_is_guest()) {

        echo "  <h5>{$lang['markasread']}</h5>\n";
        echo "    <form accept-charset=\"utf-8\" name=\"f_mark\" method=\"post\" action=\"lthread_list.php\">\n";
        echo "      ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
        echo "      ", form_input_hidden("mode", htmlentities_array($mode)), "\n";
        echo "      ", form_input_hidden("start_from", htmlentities_array($start_from)), "\n";
        echo "      ", form_input_hidden("mark_read_confirm", 'N'), "\n";

        $labels = array($lang['alldiscussions'], $lang['next50discussions']);
        $selected_option = THREAD_MARK_READ_ALL;

        if (sizeof($visible_threads_array) > 0) {

            $labels[] = $lang['visiblediscussions'];
            $selected_option = THREAD_MARK_READ_VISIBLE;

            $visible_threads = implode(',', preg_grep("/^[0-9]+$/Du", $visible_threads_array));
            echo "        ", form_input_hidden("mark_read_threads", htmlentities_array($visible_threads)), "\n";
        }

        if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "        ", form_input_hidden('folder', htmlentities_array($folder)), "\n";

            $labels[] = $lang['selectedfolder'];
            $selected_option = THREAD_MARK_READ_FOLDER;
        }

        echo light_form_dropdown_array("mark_read_type", $labels, $selected_option). "\n";
        echo light_form_submit("mark_read_submit", $lang['goexcmark'], "onclick=\"return confirmMarkAsRead()\""). "\n";
        echo "    </form>\n";
    }
}

function light_draw_my_forums()
{
    $webtag = get_webtag();

    $lang = load_language_file();

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
        $start = floor($page - 1) * 20;
    }else {
        $page = 1;
        $start = 0;
    }

    if (!user_is_guest()) {

        $forums_array = get_my_forums(FORUMS_SHOW_ALL, $start);

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) > 0) {

            foreach ($forums_array['forums_array'] as $forum) {

                echo "<h2><a href=\"lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h2>\n";

                if (isset($forum['UNREAD_TO_ME']) && $forum['UNREAD_TO_ME'] > 0) {

                    if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                        echo "<p>", sprintf($lang['forumunreadmessages'], number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), " (", sprintf($lang['forumunreadtome'], number_format($forum['UNREAD_TO_ME'], 0, ",", ",")), ")</p>\n";

                    }else {

                        echo "<p>", sprintf($lang['forumunreadtome'], number_format($forum['UNREAD_TO_ME'], 0, ".", ",")), "</p>\n";
                    }

                }else if (isset($forum['UNREAD_MESSAGES']) && is_numeric($forum['UNREAD_MESSAGES']) && $forum['UNREAD_MESSAGES'] > 0) {

                    echo "<p>", sprintf($lang['forumunreadmessages'], number_format($forum['UNREAD_MESSAGES'], 0, ".", ",")), "</p>\n";

                }else {

                    echo "<p>{$lang['forumnounreadmessages']}</p>\n";
                }

                if (isset($forum['LAST_VISIT']) && $forum['LAST_VISIT'] > 0) {
                    echo "<p>{$lang['lastvisited']}: ", format_time($forum['LAST_VISIT']), "</p>\n";
                }else {
                    echo "<p>{$lang['lastvisited']}: {$lang['never']}</p>\n";
                }
            }

            echo page_links("lforums.php?webtag=$webtag", $start, $forums_array['forums_count'], 10);

        }else {

            echo "<h1>{$lang['myforums']}</h1>\n";
            echo "<h2>{$lang['noforumsavailablelogin']}</h2>\n";
        }

    }else {

        $forums_array = get_forum_list($start);

        if (isset($forums_array['forums_array']) && sizeof($forums_array['forums_array']) > 0) {

            echo "<h1>{$lang['myforums']}</h1>\n";
            echo "<br />\n";

            foreach ($forums_array['forums_array'] as $forum) {

                echo "<h2><a href=\"lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h2>\n";
                echo "<p>{$forum['MESSAGES']} {$lang['messages']}</p>\n";
            }

            echo page_links("lforums.php?webtag=$webtag", $start, $forums_array['forums_count'], 10);

        }else {

            echo "<h1>{$lang['myforums']}</h1>\n";
            echo "<h2>{$lang['noforumsavailablelogin']}</h2>\n";
        }
    }
}

function light_form_dropdown_array($name, $options_array, $default = "", $custom_html = false)
{
    $html = "<select name=\"$name\"";

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
    $html = "<input type=\"submit\" name=\"$name\" value=\"$value\" ";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf("%s ", trim($custom_html));
    }

    $html.= "/>";
    return $html;
}

function light_messages_top($msg, $thread_title, $interest_level = THREAD_NOINTEREST, $sticky = "N", $closed = false, $locked = false)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    echo "<h1>Full Version: <a href=\"index.php?webtag=$webtag&amp;msg=$msg\">", word_filter_add_ob_tags($thread_title), "</a>";

    if ($closed) echo "&nbsp;<font color=\"#FF0000\">({$lang['closed']})</font>\n";
    if ($interest_level == THREAD_INTERESTED) echo "&nbsp;<font color=\"#FF0000\">({$lang['highinterest']})</font>";
    if ($interest_level == THREAD_SUBSCRIBED) echo "&nbsp;<font color=\"#FF0000\">({$lang['subscribed']})</font>";
    if ($sticky == "Y") echo "&nbsp;({$lang['sticky']})";
    if ($locked) echo "&nbsp;<font color=\"#FF0000\">({$lang['locked']})</font>";

    echo "</h1>";
}

function light_form_radio($name, $value, $text, $checked = false, $custom_html = false)
{
    $html = "<input type=\"radio\" name=\"$name\" value=\"$value\"";

    if ($checked) {
        $html.= " checked=\"checked\"";
    }

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= " />$text";

    return $html;
}

function light_poll_display($tid, $msg_count, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_preview = false)
{
    $webtag = get_webtag();

    $lang = load_language_file();

    $poll_data = poll_get($tid);

    $poll_results = poll_get_votes($tid);

    $user_poll_votes_array = poll_get_user_vote($tid);

    $total_votes = 0;
    $guest_votes = 0;

    $poll_group_count = 1;

    $poll_data['CONTENT'] = "<h2>". thread_get_title($tid). "</h2>\n";

    if ($in_list) {

        $poll_data['CONTENT'].= "<form accept-charset=\"utf-8\" method=\"post\" action=\"{$_SERVER['PHP_SELF']}\" target=\"_self\">\n";
        $poll_data['CONTENT'].= form_input_hidden('webtag', htmlentities_array($webtag)). "\n";
        $poll_data['CONTENT'].= form_input_hidden('tid', htmlentities_array($tid)). "\n";

        if ((!is_array($user_poll_votes_array) && bh_session_get_value('UID') > 0) && ($poll_data['CLOSES'] == 0 || $poll_data['CLOSES'] > mktime())) {

            $poll_previous_group = false;

            for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

                if ($poll_previous_group === false) $poll_previous_group = $poll_results['GROUP_ID'][$i];

                if (strlen(trim($poll_results['OPTION_NAME'][$i])) > 0) {

                    if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                        $poll_data['CONTENT'].= "<br />\n";
                        $poll_group_count++;
                    }

                    $poll_data['CONTENT'].= light_form_radio("pollvote[{$poll_results['GROUP_ID'][$i]}]", htmlentities_array($poll_results['OPTION_ID'][$i]), '', false). "&nbsp;{$poll_results['OPTION_NAME'][$i]}<br />\n";
                    $poll_previous_group = $poll_results['GROUP_ID'][$i];
                }
            }

        }else {

            if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS) {

                for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

                    if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

                    if (strlen(trim($poll_results['OPTION_NAME'][$i])) > 0) {

                        if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                            $poll_data['CONTENT'].= "<br />\n";
                            $poll_group_count++;
                        }

                        $poll_data['CONTENT'] .= $poll_results['OPTION_NAME'][$i] . ": " . $poll_results['VOTES'][$i] . " votes <br />\n";
                        $poll_previous_group = $poll_results['GROUP_ID'][$i];
                    }
                }

            }else {

                for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

                    if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

                    if (strlen(trim($poll_results['OPTION_NAME'][$i])) > 0) {

                        if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                            $poll_data['CONTENT'].= "<br />\n";
                            $poll_group_count++;
                        }

                        $poll_data['CONTENT'].= $poll_results['OPTION_NAME'][$i]. "<br />\n";
                        $poll_previous_group = $poll_results['GROUP_ID'][$i];
                    }
                }
            }
        }

    }else {

        for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $poll_results['GROUP_ID'][$i];

            if (!empty($poll_results['OPTION_NAME'][$i])) {

                if ($poll_results['GROUP_ID'][$i] <> $poll_previous_group) {

                    $poll_data['CONTENT'].= "<br />\n";
                    $poll_group_count++;
                }

                $poll_data['CONTENT'].= $poll_results['OPTION_NAME'][$i]. "<br />\n";
                $poll_previous_group = $poll_results['GROUP_ID'][$i];
            }
        }
    }

    if ($in_list) {

        $group_array = array();

        for ($i = 0; $i < sizeof($poll_results['OPTION_ID']); $i++) {

            if (!in_array($poll_results['GROUP_ID'][$i], $group_array)) {

                $group_array[] = $poll_results['GROUP_ID'][$i];
            }
        }

        $poll_group_count = sizeof($group_array);

        poll_get_total_votes($tid, $total_votes, $guest_votes);

        $poll_data['CONTENT'].= "<p>". poll_format_vote_counts($poll_data, $total_votes, $guest_votes). "</p>\n";

        if (($poll_data['CLOSES'] <= mktime()) && $poll_data['CLOSES'] != 0) {

            $poll_data['CONTENT'].= "<p>{$lang['pollhasended']}</p>\n";

            if (is_array($user_poll_votes_array) && isset($user_poll_votes_array[0]['TSTAMP'])) {

                $user_poll_votes_array_keys = array_keys($user_poll_votes_array);

                $user_poll_votes_display_array = array();

                foreach ($user_poll_votes_array_keys as $vote_key) {

                    foreach ($poll_results['OPTION_ID'] as $group_key => $poll_results_group_id) {

                        if ($user_poll_votes_array[$vote_key]['OPTION_ID'] == $poll_results_group_id) {

                            if ($poll_results['OPTION_NAME'][$group_key] == strip_tags($poll_results['OPTION_NAME'][$group_key])) {

                                $user_poll_votes_display_array[] = sprintf("'%s'", word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group_key]));

                            }else {

                                $user_poll_votes_display_array[] = sprintf("%s: %s", $lang['options'], $user_poll_votes_display_array[$vote_key]['OPTION_ID']);
                            }
                        }
                    }
                }

                $poll_data['CONTENT'].= sprintf($lang['youvotedforpolloptionsondate'], implode(' &amp; ', $user_poll_votes_display_array), format_date($user_poll_votes_array[0]['TSTAMP'], true));
            }

        }else {

            if (is_array($user_poll_votes_array) && isset($user_poll_votes_array[0]['TSTAMP'])) {

                $user_poll_votes_array_keys = array_keys($user_poll_votes_array);

                $user_poll_votes_display_array = array();

                foreach ($user_poll_votes_array_keys as $vote_key) {

                    foreach ($poll_results['OPTION_ID'] as $group_key => $poll_results_group_id) {

                        if ($user_poll_votes_array[$vote_key]['OPTION_ID'] == $poll_results_group_id) {

                            if ($poll_results['OPTION_NAME'][$group_key] == strip_tags($poll_results['OPTION_NAME'][$group_key])) {

                                $user_poll_votes_display_array[] = sprintf("'%s'", word_filter_add_ob_tags($poll_results['OPTION_NAME'][$group_key]));

                            }else {

                                $user_poll_votes_display_array[] = sprintf("%s: %s", $lang['options'], $user_poll_votes_display_array[$vote_key]['OPTION_ID']);
                            }
                        }
                    }
                }

                $poll_data['CONTENT'].= sprintf($lang['youvotedforpolloptionsondate'], implode(' &amp; ', $user_poll_votes_display_array), format_date($user_poll_votes_array[0]['TSTAMP'], true));

            }elseif (bh_session_get_value('UID') > 0) {

                $poll_data['CONTENT'].= "<p>". light_form_submit('pollsubmit', $lang['vote']). "</p>\n";
            }
        }

        $poll_data['CONTENT'].= "</form>\n";
    }

    // Work out what relationship the user has to the user who posted the poll

    $poll_data['FROM_RELATIONSHIP'] = user_get_relationship(bh_session_get_value('UID'), $poll_data['FROM_UID']);

    light_message_display($tid, $poll_data, $msg_count, $folder_fid, true, $closed, $limit_text, true, $is_preview);
}

function light_message_display($tid, $message, $msg_count, $folder_fid, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $is_preview = false)
{
    $lang = load_language_file();

    $perm_is_moderator = bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $folder_fid);

    $post_edit_time = forum_get_setting('post_edit_time', false, 0);
    $post_edit_grace_period = forum_get_setting('post_edit_grace_period', false, 0);

    $webtag = get_webtag();

    $attachments_array = array();
    $image_attachments_array = array();

    if (($uid = bh_session_get_value('UID')) === false) return;

    if (!isset($message['CONTENT']) || $message['CONTENT'] == "") {

        light_message_display_deleted($tid, $message['PID']);
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
        $post_link = sprintf($post_link, $message['MOVED_TID'], $message['MOVED_PID'], $lang['threadmovedhere']);

        echo sprintf("<p>{$lang['thisposthasbeenmoved']}</p>\n", $post_link);
        return;
    }

    if (bh_session_get_value('IMAGES_TO_LINKS') == 'Y') {

        $message['CONTENT'] = preg_replace('/<a([^>]*)href="([^"]*)"([^\>]*)><img[^>]*src="([^"]*)"[^>]*><\/a>/iu', '[img: <a\1href="\2"\3>\4</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<img[^>]*src="([^"]*)"[^>]*>/iu', '[img: <a href="\1">\1</a>]', $message['CONTENT']);
        $message['CONTENT'] = preg_replace('/<embed[^>]*src="([^"]*)"[^>]*>/iu', '[object: <a href="\1">\1</a>]', $message['CONTENT']);
    }

    if ((mb_strlen(strip_tags($message['CONTENT'])) > intval(forum_get_setting('maximum_post_length', false, 6226))) && $limit_text) {

        $cut_msg = mb_substr($message['CONTENT'], 0, intval(forum_get_setting('maximum_post_length', false, 6226)));
        $cut_msg = preg_replace("/(<[^>]+)?$/Du", "", $cut_msg);

        $message['CONTENT'] = fix_html($cut_msg, false);
        $message['CONTENT'].= "&hellip;[{$lang['msgtruncated']}]\n<p align=\"center\"><a href=\"ldisplay.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\" target=\"_self\">{$lang['viewfullmsg']}.</a>";
    }

    if ($in_list) {

        echo "<a name=\"a{$tid}_{$message['PID']}\"></a>";
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    if (isset($message['PID'])) {

        echo "<p><b>{$lang['from']}: ", word_filter_add_ob_tags(htmlentities_array(format_user_name($message['FLOGON'], $message['FNICK']))), "</b> [<a href=\"lmessages.php?webtag=$webtag&amp;msg={$tid}.{$message['PID']}\">#{$message['PID']}</a>]<br />";

    }else {

        echo "<p><b>{$lang['from']}: ", word_filter_add_ob_tags(htmlentities_array(format_user_name($message['FLOGON'], $message['FNICK']))), "</b><br />";;
    }

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen

    if ($is_poll && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {

        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if ($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "&nbsp;({$lang['friend']}) ";
    }else if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) || isset($temp_ignore)) {
        echo "&nbsp;({$lang['ignoreduser']}) ";
    }

    if (($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text) {

        echo "<b>{$lang['ignoredmsg']}</b>";
        return;

    }else {

        if ($in_list) {

            if (($from_user_permissions & USER_PERM_WORMED)) echo "<b>{$lang['wormeduser']}</b> ";
            echo "&nbsp;".format_time($message['CREATED'], 1)."<br />";
        }
    }

    if (($message['TLOGON'] != $lang['allcaps']) && $message['TO_UID'] != 0) {

        echo "<b>{$lang['to']}: " . word_filter_add_ob_tags(htmlentities_array(format_user_name($message['TLOGON'], $message['TNICK'])))."</b>";

        if (isset($message['REPLY_TO_PID']) && $message['REPLY_TO_PID'] > 0) echo " [<a href=\"lmessages.php?webtag=$webtag&amp;msg={$tid}.{$message['REPLY_TO_PID']}\">#{$message['REPLY_TO_PID']}</a>]";

        if ($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "&nbsp;({$lang['friend']})";
        } else if ($message['TO_RELATIONSHIP'] & USER_IGNORED) {
            echo "&nbsp;({$lang['ignoreduser']})";
        }

        if (!$is_preview) {

            if (isset($message['VIEWED']) && $message['VIEWED'] > 0) {
                echo "&nbsp;".format_time($message['VIEWED'], 1);
            } else {
                echo "&nbsp;{$lang['unread']}";
            }
        }

    }else {

        echo "<b>{$lang['to']}: {$lang['all_caps']}</b>";
    }

    echo "</p>\n";

    if (!$in_list && isset($message['PID'])) {
        echo sprintf("<p><i>{$lang['messagecountdisplay']}</i></p>\n", $message['PID'], $msg_count);
    }

    // Light mode never displays user signatures.

    $message['CONTENT'] = message_apply_formatting($message['CONTENT'], false, true);

    // Fix spoiler on light mode

    $message['CONTENT'] = light_spoiler_enable($message['CONTENT']);

    // Check for words that should be filtered ---------------------------------

    if ($is_poll !== true) $message['CONTENT'] = word_filter_add_ob_tags($message['CONTENT']);

    echo $message['CONTENT'];

    if (isset($message['EDITED']) && $message['EDITED'] > 0) {

        if (($post_edit_grace_period == 0) || ($message['EDITED'] - $message['CREATED']) > ($post_edit_grace_period * MINUTE_IN_SECONDS)) {

            if (($edit_user = user_get_logon($message['EDITED_BY']))) {

                echo "<p class=\"edit_text\">", sprintf($lang['editedbyuser'], format_time($message['EDITED'], 1), $edit_user), "</p>\n";
            }
        }
    }

    if (($tid <> 0 && isset($message['PID'])) || isset($message['AID'])) {

        $aid = isset($message['AID']) ? $message['AID'] : get_attachment_id($tid, $message['PID']);

        if (get_attachments($message['FROM_UID'], $aid, $attachments_array, $image_attachments_array)) {

            // Draw the attachment header at the bottom of the post

            if (sizeof($attachments_array) > 0) {

                echo "<p><b>{$lang['attachments']}:</b><br />\n";

                foreach ($attachments_array as $attachment) {

                    if (($attachment_link = light_attachment_make_link($attachment))) {

                        echo $attachment_link, "<br />\n";
                    }
                }

                echo "</p>\n";
            }

            if (sizeof($image_attachments_array) > 0) {

                echo "<p><b>{$lang['imageattachments']}:</b><br />\n";

                foreach ($image_attachments_array as $attachment) {

                    if (($attachment_link = light_attachment_make_link($attachment))) {

                        echo $attachment_link, "&nbsp;\n";
                    }
                }

                echo "</p>\n";
            }
        }
    }

    if ($in_list && $limit_text != false) {

        $links_array = array();

        if (!$closed && bh_session_check_perm(USER_PERM_POST_CREATE, $folder_fid)) {

            $links_array[] = "<a href=\"lpost.php?webtag=$webtag&amp;replyto=$tid.{$message['PID']}\">{$lang['reply']}</a>";
        }

        if (($uid == $message['FROM_UID'] && bh_session_check_perm(USER_PERM_POST_DELETE, $folder_fid) && !bh_session_check_perm(USER_PERM_PILLORIED, 0)) || $perm_is_moderator) {

            $links_array[] = "<a href=\"ldelete.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\">{$lang['delete']}</a>";
        }

        if ((!(bh_session_check_perm(USER_PERM_PILLORIED, 0)) && ((($uid != $message['FROM_UID']) && ($from_user_permissions & USER_PERM_PILLORIED)) || ($uid == $message['FROM_UID'])) && bh_session_check_perm(USER_PERM_POST_EDIT, $folder_fid) && ($post_edit_time == 0 || (time() - $message['CREATED']) < ($post_edit_time * HOUR_IN_SECONDS)) && forum_get_setting('allow_post_editing', 'Y')) || $perm_is_moderator) {

            if (!$is_poll || ($is_poll && isset($message['PID']) && $message['PID'] > 1)) {

                $links_array[] = "<a href=\"ledit.php?webtag=$webtag&amp;msg=$tid.{$message['PID']}\">{$lang['edit']}</a>";
            }
        }

        if (sizeof($links_array) > 0) {

            echo "<p>", implode('&nbsp;&nbsp;', $links_array), "</p>\n";
        }
    }

    echo "<hr />";
}

function light_spoiler_enable($message)
{
    if (bh_session_get_value('USE_LIGHT_MODE_SPOILER') == "Y") {
        return str_replace("<div class=\"spoiler\">", "<div class=\"spoiler_light\">", $message);
    }

    return $message;
}

function light_message_display_deleted($tid,$pid)
{
    $lang = load_language_file();

    echo sprintf("<p>{$lang['messagewasdeleted']}</p>\n", $tid, $pid);
    echo "<hr />";
}

function light_message_display_approval_req($tid, $pid)
{
    $lang = load_language_file();

    echo sprintf("<p>{$lang['messageawaitingapprovalbymoderator']}</p>\n", $tid, $pid);
    echo "<hr />\n";
}

function light_messages_nav_strip($tid,$pid,$length,$ppp)
{
    $lang = load_language_file();

    $webtag = get_webtag();

    // Less than 20 messages, no nav needed
    if ($pid == 1 && $length < $ppp) return;

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if ($spid > 1) {
        if ($pid > 1) {
            $navbits[0] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">" . mess_nav_range(1,$spid-1) . "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
        $i = 1;
    } else {
        $i = 0;
    }

    // The middle section(s)
    while ($spid + ($ppp - 1) <= $length){
        if ($spid == $pid) {
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">" . mess_nav_range($spid==0 ? 1 : $spid,$spid+($ppp - 1)) . "</a>";
        }
        $spid += $ppp;
        $i++;
    }

    // The final section, x-n
    if ($spid <= $length) {
        if ($spid == $pid) {
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.$spid\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }
    $max = $i;

    $html = "{$lang['showmessages']}:";

    if ($length <= $ppp) {
        $html .= " <a href=\"lmessages.php?webtag=$webtag&amp;msg=$tid.1\">{$lang['all']}</a>\n";
    }

    for ($i = 0; $i <= $max; $i++) {

        if (isset($navbits[$i])) {

            if ((abs($c - $i) < 4) || $i == 0 || $i == $max){
                $html .= "\n&nbsp;" . $navbits[$i];
            } else if (abs($c - $i) == 4){
                $html .= "\n&nbsp;&hellip;";
            }
        }
    }

    unset($navbits);

    echo "<p align=\"center\">$html</p>\n";
}

function light_html_guest_error ()
{
    $frame_top_target = html_get_top_frame_name();

    $lang = load_language_file();

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['guesterror']);

    echo "<br />\n";
    echo form_quick_button("llogout.php", $lang['loginnow'], false, $frame_top_target);

    light_html_draw_bottom();
}

function light_folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="")
{
    if (!$db_folder_draw_dropdown = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return "";

    $available_folders = array();

    $allowed_types = FOLDER_ALLOW_NORMAL_THREAD;
    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "WHERE FOLDER.ALLOWED_TYPES & $allowed_types > 0 ";
    $sql.= "OR FOLDER.ALLOWED_TYPES IS NULL ";
    $sql.= "ORDER BY FOLDER.FID ";

    if (!$result = db_query($sql, $db_folder_draw_dropdown)) return false;

    if (db_num_rows($result) > 0) {

        while (($folder_order = db_fetch_array($result))) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_order['FID'])) {

                    $available_folders[$folder_order['FID']] = htmlentities_array($folder_order['TITLE']);
                }

            }else {

                if (bh_session_check_perm($access_allowed, $folder_order['FID'])) {

                    $available_folders[$folder_order['FID']] = htmlentities_array($folder_order['TITLE']);
                }
            }
        }

        if (sizeof($available_folders) > 0) {

            return light_form_dropdown_array($field_name.$suffix, $available_folders, $default_fid);
        }
    }

    return false;
}

function light_form_textarea($name, $value = "", $rows = 0, $cols = 0, $custom_html = false)
{
    $html = "<textarea name=\"$name\" class=\"bhlightinput\"";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($rows)) {
        $html.= " rows=\"$rows\"";
    }

    if (is_numeric($cols)) {
        $html.= " cols=\"$cols\"";
    }

    $html.= ">$value</textarea>";

    return $html;
}

function light_form_checkbox($name, $value, $text, $checked = false, $custom_html = false)
{
    $html = "<input type=\"checkbox\" name=\"$name\" value=\"$value\" class=\"bhlightinput\"";

    if ($checked) {
        $html.= " checked=\"checked\"";
    }

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    $html.= " />$text";

    return $html;
}

function light_form_field($name, $value = "", $width = false, $maxchars = false, $type = "text", $custom_html = false)
{
    $html = "<input type=\"$type\" name=\"$name\" value=\"$value\" class=\"bhlightinput\"";

    if (strlen(trim($custom_html)) > 0) {
        $html.= sprintf(" %s", trim($custom_html));
    }

    if (is_numeric($width)) {
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
    $lang = load_language_file();

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['cannotpostthisthreadtype']);
    light_html_draw_bottom();
}

function light_attachment_make_link($attachment)
{
    if (!is_array($attachment)) return false;

    if (!isset($attachment['hash']) || !is_md5($attachment['hash'])) return false;
    if (!isset($attachment['filename'])) return false;

    $webtag = get_webtag();

    $href = "get_attachment.php?webtag=$webtag&amp;hash={$attachment['hash']}";
    $href.= "&amp;filename={$attachment['filename']}";

    $attachment_link = "<img src=\"";
    $attachment_link.= style_image('attach.png');
    $attachment_link.= "\" width=\"14\" height=\"14\" border=\"0\" />";
    $attachment_link.= "<a href=\"$href\" target=\"_blank\">{$attachment['filename']}</a>";

    return $attachment_link;
}

function light_threads_draw_discussions_dropdown($mode)
{
    $lang = load_language_file();

    $unread_cutoff_stamp = forum_get_unread_cutoff();

    if (user_is_guest()) {

        $available_views = array(ALL_DISCUSSIONS    => $lang['alldiscussions'],
                                 TODAYS_DISCUSSIONS => $lang['todaysdiscussions'],
                                 TWO_DAYS_BACK      => $lang['2daysback'],
                                 SEVEN_DAYS_BACK    => $lang['7daysback']);

    }else {

        $available_views = array(ALL_DISCUSSIONS          => $lang['alldiscussions'],
                                 UNREAD_DISCUSSIONS       => $lang['unreaddiscussions'],
                                 UNREAD_DISCUSSIONS_TO_ME => $lang['unreadtome'],
                                 TODAYS_DISCUSSIONS       => $lang['todaysdiscussions'],
                                 UNREAD_TODAY             => $lang['unreadtoday'],
                                 TWO_DAYS_BACK            => $lang['2daysback'],
                                 SEVEN_DAYS_BACK          => $lang['7daysback'],
                                 HIGH_INTEREST            => $lang['highinterest'],
                                 UNREAD_HIGH_INTEREST     => $lang['unreadhighinterest'],
                                 RECENTLY_SEEN            => $lang['iverecentlyseen'],
                                 IGNORED_THREADS          => $lang['iveignored'],
                                 BY_IGNORED_USERS         => $lang['byignoredusers'],
                                 SUBSCRIBED_TO            => $lang['ivesubscribedto'],
                                 STARTED_BY_FRIEND        => $lang['startedbyfriend'],
                                 UNREAD_STARTED_BY_FRIEND => $lang['unreadstartedbyfriend'],
                                 STARTED_BY_ME            => $lang['startedbyme'],
                                 POLL_THREADS             => $lang['polls'],
                                 STICKY_THREADS           => $lang['stickythreads'],
                                 MOST_UNREAD_POSTS        => $lang['mostunreadposts'],
                                 DELETED_THREADS          => $lang['deletedthreads']);

        if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

            if ($unread_cutoff_stamp === false) {

                // Remove unread thread options (Unread Discussions, Unread Today,
                // Unread High Interest, Unread Started By Friend, Most Unread Posts).

                unset($available_views[UNREAD_DISCUSSIONS], $available_views[UNREAD_TODAY], $available_views[UNREAD_HIGH_INTEREST]);
                unset($available_views[UNREAD_STARTED_BY_FRIEND], $available_views[MOST_UNREAD_POSTS]);
            }

        }else {

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

function light_mode_check_noframes()
{
    $webtag = get_webtag();

    if (isset($_GET['noframes'])) {

        if (bh_session_active() && !isset($_GET['logon_failed'])) {

            if (forum_check_webtag_available($webtag)) {

                header_redirect("lthread_list.php?webtag=$webtag");
                exit;

            }else {

                header_redirect("lforums.php?webtag=$webtag");
                exit;
            }

        }else {

            header_redirect("llogon.php?webtag=$webtag");
            exit;
        }
    }
}

function light_edit_refuse()
{
    $lang = load_language_file();

    light_html_display_error_msg($lang['nopermissiontoedit']);
}

function light_html_display_msg($header_text, $string_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self")
{
    $webtag = get_webtag();

    if (!is_string($header_text)) return;
    if (!is_string($string_msg)) return;

    $available_methods = array('get', 'post');
    if (!in_array($method, $available_methods)) $method = 'get';

    echo "<h1>$header_text</h1>\n";
    echo "<br />\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        echo "<form accept-charset=\"utf-8\" action=\"$href\" method=\"$method\" target=\"$target\">\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

        if (is_array($var_array)) {

            echo "  ", form_input_hidden_array($var_array), "\n";
        }
    }

    echo "<h2>$string_msg</h2>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        $button_html_array = array();

        if (is_array($button_array) && sizeof($button_array) > 0) {

            foreach ($button_array as $button_name => $button_label) {
                $button_html_array[] = light_form_submit(htmlentities_array($button_name), htmlentities_array($button_label));
            }
        }

        if (sizeof($button_html_array) > 0) {
            echo implode("&nbsp;", $button_html_array);
        }
    }

    if (is_string($href) && strlen(trim($href)) > 0) {
        echo "</form>\n";
    }
}

function light_html_display_error_array($error_list_array)
{
    $lang = load_language_file();

    $error_list_array = array_filter($error_list_array, 'is_string');

    if (sizeof($error_list_array) < 1) return;

    echo "<h2><img src=\"", style_image('error.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" />&nbsp;{$lang['thefollowingerrorswereencountered']}</h2>\n";
    echo "<ul>\n";
    echo "  <li>", implode("</li>\n  <li>", $error_list_array), "</li>\n";
    echo "</ul>\n";
}

function light_html_display_success_msg($string_msg)
{
    $lang = load_language_file();

    if (!is_string($string_msg)) return;

    echo "<h2><img src=\"", style_image('success.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['success']}\" title=\"{$lang['success']}\" />&nbsp;$string_msg</h2>\n";
}

function light_html_display_warning_msg($string_msg)
{
    $lang = load_language_file();

    if (!is_string($string_msg)) return;

    echo "<h2><img src=\"", style_image('warning.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['warning']}\" title=\"{$lang['warning']}\" />&nbsp;$string_msg</h2>\n";
}

function light_html_display_error_msg($string_msg)
{
    $lang = load_language_file();

    if (!is_string($string_msg)) return;

    echo "<h2><img src=\"", style_image('error.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" />&nbsp;$string_msg</h2>\n";
}

?>