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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");
include_once(BH_INCLUDE_PATH. "zip_lib.inc.php");

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Initialise Locale
lang_init();

// Get the user's UID
$uid = session_get_value('UID');

// Guests can't access PMs
if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages
$error_msg_array = array();

// Check that PM system is enabled
pm_enabled();

// Variables to hold message counts
$pm_new_count = 0;
$pm_outbox_count = 0;
$pm_unread_count = 0;

// Check for new PMs
pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

// Get custom folder names array.
if (!$pm_folder_names_array = pm_get_folder_names()) {

    $pm_folder_names_array = array(PM_FOLDER_INBOX   => gettext("Inbox"),
                                   PM_FOLDER_SENT    => gettext("Sent Items"),
                                   PM_FOLDER_OUTBOX  => gettext("Outbox"),
                                   PM_FOLDER_SAVED   => gettext("Saved Items"),
                                   PM_FOLDER_DRAFTS  => gettext("Drafts"),
                                   PM_SEARCH_RESULTS => gettext("Search Results"));
}

$pm_folder_name_array = array(PM_OUTBOX      => $pm_folder_names_array[PM_FOLDER_OUTBOX],
                              PM_UNREAD      => $pm_folder_names_array[PM_FOLDER_INBOX],
                              PM_READ        => $pm_folder_names_array[PM_FOLDER_INBOX],
                              PM_SENT        => $pm_folder_names_array[PM_FOLDER_SENT],
                              PM_SAVED_IN    => $pm_folder_names_array[PM_FOLDER_SAVED],
                              PM_SAVED_OUT   => $pm_folder_names_array[PM_FOLDER_SAVED],
                              PM_SAVED_DRAFT => $pm_folder_names_array[PM_FOLDER_DRAFTS]);

// Column sorting stuff
if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "SUBJECT") {
        $sort_by = "PM.SUBJECT";
    } elseif ($_GET['sort_by'] == "TYPE") {
        $sort_by = "TYPE";
    } elseif ($_GET['sort_by'] == "FROM_UID") {
        $sort_by = "PM.FROM_UID";
    } elseif ($_GET['sort_by'] == "TO_UID") {
        $sort_by = "PM.TO_UID";
    } else {
        $sort_by = "CREATED";
    }
} else {
    $sort_by = "CREATED";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

// Check to see which page we should be on
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

// Check to see if we're viewing a message and get the folder it is in.
if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = ($_GET['mid'] > 0) ? $_GET['mid'] : 0;

    if (!$message_folder = pm_message_get_folder($mid)) {
        $message_folder = PM_FOLDER_INBOX;
    }

}elseif (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

    $mid = ($_POST['mid'] > 0) ? $_POST['mid'] : 0;

    if (!$message_folder = pm_message_get_folder($mid)) {
        $message_folder = PM_FOLDER_INBOX;
    }

}else {

    $mid = 0;
    $message_folder = PM_FOLDER_INBOX;
}

// Default folder
$current_folder = $message_folder;

// Check for folder specified in URL query.
if (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_INBOX) {
        $current_folder = PM_FOLDER_INBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SENT) {
        $current_folder = PM_FOLDER_SENT;
    }else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $current_folder = PM_FOLDER_OUTBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $current_folder = PM_FOLDER_SAVED;
    }else if ($_GET['folder'] == PM_FOLDER_DRAFTS) {
        $current_folder = PM_FOLDER_DRAFTS;
    }else if ($_GET['folder'] == PM_SEARCH_RESULTS) {
        $current_folder = PM_SEARCH_RESULTS;
    }

}elseif (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_INBOX) {
        $current_folder = PM_FOLDER_INBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SENT) {
        $current_folder = PM_FOLDER_SENT;
    }else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $current_folder = PM_FOLDER_OUTBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $current_folder = PM_FOLDER_SAVED;
    }else if ($_POST['folder'] == PM_FOLDER_DRAFTS) {
        $current_folder = PM_FOLDER_DRAFTS;
    }else if ($_POST['folder'] == PM_SEARCH_RESULTS) {
        $current_folder = PM_SEARCH_RESULTS;
    }
}

// Check to see if we're displaying a message.
if (isset($mid) && is_numeric($mid) && $mid > 0) {

    if (($current_folder != PM_SEARCH_RESULTS) && ($current_folder != $message_folder)) {

        html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
        html_error_msg(gettext("Message not found in selected folder. Check that it hasn't been moved or deleted."));
        html_draw_bottom();
        exit;
    }

    if (!$pm_message_array = pm_message_get($mid)) {

        html_draw_top("title=", gettext("Error"), "", 'pm_popup_disabled');
        html_error_msg(gettext("Message not found. Check that it hasn't been deleted."));
        html_draw_bottom();
        exit;
    }
}

// Delete Messages
if (isset($_POST['pm_delete_messages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'is_numeric');
    }else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (isset($_POST['pm_delete_confirm']) && $_POST['pm_delete_confirm'] == 'Y') {

            if (pm_delete_messages($process_messages)) {

                if (in_array($mid, $process_messages)) {

                    header_redirect("pm_messages.php?webtag=$webtag&folder=$current_folder&page=$page&deleted=true#message");
                    exit;

                }else {

                    header_redirect("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&page=$page&deleted=true#message");
                    exit;
                }

            }else {

                $error_msg_array[] = gettext("Failed to delete selected messages");
                $valid = false;
            }

        }else {

            html_draw_top(sprintf("title=%s", gettext("Delete Message")), 'class=window_title');
            html_display_msg(gettext("Delete"), gettext("Are you sure you want to delete all of the selected messages?"), "pm_messages.php", 'post', array('pm_option_submit' => gettext("Yes"), 'back' => gettext("No")), array('folder' => $current_folder, 'page' => $page, 'process' => $process_messages, 'pm_delete_messages' => gettext("Delete"), 'pm_delete_confirm' => 'Y'), '_self', 'center');
            html_draw_bottom();
            exit;
        }

    }else {

        $error_msg_array[] = gettext("You must select some messages to process");
        $valid = false;
    }

}else if (isset($_POST['pm_export_messages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'is_numeric');
    }else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (!pm_export_messages($process_messages)) {

            $error_msg_array[] = gettext("Failed to export messages");
            $valid = false;
        }

    }else {

        $error_msg_array[] = gettext("You must select some messages to process");
        $valid = false;
    }

}else if (isset($_POST['pm_save_messages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'is_numeric');
    }else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (pm_archive_messages($process_messages)) {

            header_redirect("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&page=$page&archived=true#message");
            exit;

        }else {

            $error_msg_array[] = gettext("Failed to archive selected messages");
            $valid = false;
        }

    }else {

        $error_msg_array[] = gettext("You must select some messages to process");
        $valid = false;
    }
}

// Search string.
if (isset($_POST['search'])) {

    if (isset($_POST['search_string']) && strlen(trim(stripslashes_array($_POST['search_string']))) > 0) {
        $search_string = trim(stripslashes_array($_POST['search_string']));
    }else {
        $search_string = '';
    }

    $error = SEARCH_NO_ERROR;

    if (!pm_search_execute($search_string, $error)) {

        switch($error) {

            case SEARCH_NO_MATCHES:

                header_redirect("pm_messages.php?webtag=$webtag&folder=6&search_no_results=true");
                exit;

            case SEARCH_FREQUENCY_TOO_GREAT:

                header_redirect("pm_messages.php?webtag=$webtag&folder=6&search_frequency_error=true");
                exit;
        }
    }
}

// Prune old messages for the current user
pm_user_prune_folders();

html_draw_top("title=", gettext("Private Messages"), " - {$pm_folder_names_array[$current_folder]}", "basetarget=_blank", "search.js", "pm.js", 'pm_popup_disabled', 'class=window_title');

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if ($current_folder == PM_FOLDER_INBOX) {

    $pm_messages_array = pm_get_inbox($sort_by, $sort_dir, $start, 10);

}elseif ($current_folder == PM_FOLDER_SENT) {

    $pm_messages_array = pm_get_sent($sort_by, $sort_dir, $start, 10);

}elseif ($current_folder == PM_FOLDER_OUTBOX) {

    $pm_messages_array = pm_get_outbox($sort_by, $sort_dir, $start, 10);

}elseif ($current_folder == PM_FOLDER_SAVED) {

    $pm_messages_array = pm_get_saved_items($sort_by, $sort_dir, $start, 10);

}elseif ($current_folder == PM_FOLDER_DRAFTS) {

    $pm_messages_array = pm_get_drafts($sort_by, $sort_dir, $start, 10);

}elseif ($current_folder == PM_SEARCH_RESULTS) {

    $pm_messages_array = pm_fetch_search_results($sort_by, $sort_dir, $start, 10);
}

echo "<h1>", gettext("Private Messages"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$pm_folder_names_array[$current_folder]}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '96%', 'center');

}else if (isset($_GET['message_sent'])) {

    html_display_success_msg(gettext("Message sent successfully."), '96%', 'center');

}else if (isset($_GET['message_saved'])) {

    html_display_success_msg(gettext("Message was successfully saved to 'Drafts' folder"), '96%', 'center');

}else if (isset($_GET['deleted'])) {

    html_display_success_msg(gettext("Successfully deleted selected messages"), '96%', 'center', 'pm_delete_success');

}else if (isset($_GET['archived'])) {

    html_display_success_msg(gettext("Successfully archived selected messages"), '96%', 'center', 'pm_archive_success');

}else if (isset($_GET['search_no_results'])) {

    html_display_warning_msg(gettext("Search Returned No Results"), '96%', 'center');

}else if (isset($_GET['search_frequency_error'])) {

    $search_frequency = forum_get_setting('search_min_frequency', false, 0);
    html_display_warning_msg(sprintf(gettext("You can only search once every %s seconds. Please try again later."), $search_frequency), '96%', 'center');

}else if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) < 1) {

    html_display_warning_msg(sprintf(gettext("Your %s folder is empty"), htmlentities_array($pm_folder_names_array[$current_folder])), '96%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"pm\" action=\"pm_messages.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('mid', htmlentities_array($mid)), "\n";
echo "  ", form_input_hidden('folder', htmlentities_array($current_folder)), "\n";
echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
echo "  ", form_input_hidden('pm_delete_confirm', 'N'), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" colspan=\"3\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\" border=\"0\">\n";
echo "                <tr>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_all", "toggle_all"), "</td>\n";
}else {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
}

$col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '35%' : '50%';

if ($sort_by == 'PM.SUBJECT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\" colspan=\"2\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a></td>\n";
}elseif ($sort_by == 'PM.SUBJECT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\" colspan=\"2\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\" colspan=\"2\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\" colspan=\"2\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a></td>\n";
}

if ($current_folder == PM_SEARCH_RESULTS) {

    if ($sort_by == 'TYPE' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"15%\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Folder"), "</a></td>\n";
    }elseif ($sort_by == 'TYPE' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"15%\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Folder"), "</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"15%\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Folder"), "</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"15%\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Folder"), "</a></td>\n";
    }
}

if ($current_folder == PM_FOLDER_INBOX || $current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) {

    $col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '15%' : '30%';

    if ($sort_by == 'PM.FROM_UID' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a></td>\n";
    }elseif ($sort_by == 'PM.FROM_UID' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a></td>\n";
    }
}

if ($current_folder == PM_FOLDER_SENT || $current_folder == PM_FOLDER_OUTBOX || $current_folder == PM_FOLDER_DRAFTS || $current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) {

    $col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '15%' : '30%';

    if ($sort_by == 'PM.TO_UID' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a></td>\n";
    }elseif ($sort_by == 'PM.TO_UID' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a></td>\n";
    }
}

if ($sort_by == 'CREATED' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" style=\"white-space: nowrap\" width=\"20%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a></td>\n";
}elseif ($sort_by == 'CREATED' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" style=\"white-space: nowrap\" width=\"20%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\" width=\"20%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\" width=\"20%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a></td>\n";
}

echo "                </tr>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {

    foreach ($pm_messages_array['message_array'] as $message) {

        echo "                <tr>\n";
        echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\">", form_checkbox('process[]', $message['MID'], ''), "</td>\n";

        if ($mid == $message['MID']) {

            echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\"><img src=\"".html_style_image('current_thread.png')."\" title=\"", gettext("Current Message"), "\" alt=\"", gettext("Current Message"), "\" /></td>";

        }else {

            if (($message['TYPE'] == PM_UNREAD)) {

                echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\"><img src=\"".html_style_image('pmunread.png')."\" title=\"", gettext("Unread Message"), "\" alt=\"", gettext("Unread Message"), "\" /></td>";

            }else {

                echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\"><img src=\"".html_style_image('pmread.png')."\" title=\"", gettext("Read Message"), "\" alt=\"", gettext("Read Message"), "\" /></td>";
            }
        }

        echo "                  <td align=\"left\" class=\"postbody\" width=\"50%\" valign=\"top\">";

        if (strlen(trim($message['SUBJECT'])) > 0) {

            echo "            <a href=\"pm_messages.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}&amp;page=$page#message\" target=\"_self\">", word_filter_add_ob_tags($message['SUBJECT'], true), "</a>";

        }else {

            echo "            <a href=\"pm_messages.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}&amp;page=$page#message\" target=\"_self\"><i>", gettext("No Subject"), "</i></a>";
        }

        if (isset($message['AID']) && pm_has_attachments($message['MID'])) {
            echo "            &nbsp;&nbsp;<img src=\"".html_style_image('attach.png')."\" border=\"0\" alt=\"", gettext("Attachment"), " - {$message['AID']}\" title=\"", gettext("Attachment"), "\" />";
        }

        echo "            </td>\n";

        if ($current_folder == PM_FOLDER_SENT || $current_folder == PM_FOLDER_OUTBOX) {

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
            echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK']), true), "</a>\n";
            echo "                  </td>\n";
            echo "                  <td align=\"left\" class=\"postbody\">", format_time($message['CREATED']), "</td>\n";
            echo "                </tr>\n";

        }elseif ($current_folder == PM_FOLDER_SAVED) {

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
            echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK']), true), "</a>\n";
            echo "                  </td>\n";

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
            echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK']), true), "</a>\n";
            echo "                  </td>\n";
            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", format_time($message['CREATED']), "</td>\n";
            echo "                </tr>\n";

        }elseif ($current_folder == PM_FOLDER_DRAFTS) {

            if (isset($message['RECIPIENTS']) && strlen(trim($message['RECIPIENTS'])) > 0) {

                $recipient_array = preg_split("/[;|,]/u", trim($message['RECIPIENTS']));

                if ($message['TO_UID'] > 0) {
                    $recipient_array = array_unique(array_merge($recipient_array, array($message['TLOGON'])));
                }

                $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

                echo "                  <td align=\"left\" class=\"postbody\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</td>\n";

            }else if (isset($message['TO_UID']) && $message['TO_UID'] > 0) {

                echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
                echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK']), true), "</a>\n";
                echo "                  </td>\n";

            }else {

                echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\"><i>", gettext("No Recipients"), "</i></td>\n";
            }

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\"><i>", gettext("Not Sent"), "</i></td>\n";
            echo "                </tr>\n";

        }elseif ($current_folder == PM_SEARCH_RESULTS) {

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">{$pm_folder_name_array[$message['TYPE']]}</td>\n";

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
            echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK']), true), "</a>\n";
            echo "                  </td>\n";

            if ($message['TYPE'] & PM_SAVED_DRAFT) {

                if (isset($message['RECIPIENTS']) && strlen(trim($message['RECIPIENTS'])) > 0) {

                    $recipient_array = preg_split("/[;|,]/u", trim($message['RECIPIENTS']));

                    if ($message['TO_UID'] > 0) {
                        $recipient_array = array_unique(array_merge($recipient_array, array($message['TLOGON'])));
                    }

                    $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

                    echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</td>\n";
                    echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", format_time($message['CREATED']), "</td>\n";
                    echo "                </tr>\n";

                }else if (isset($message['TO_UID']) && $message['TO_UID'] > 0) {

                    echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
                    echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK']), true), "</a>\n";
                    echo "                  </td>\n";

                }else {

                    echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\"><i>", gettext("No Recipients"), "</i></td>\n";
                    echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\"><i>", gettext("Not Sent"), "</i></td>\n";
                    echo "                </tr>\n";
                }

            }else {

                echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
                echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK']), true), "</a>\n";
                echo "                  </td>\n";
                echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", format_time($message['CREATED']), "</td>\n";
                echo "                </tr>\n";
            }

        }else {

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
            echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK']), true), "</a>\n";
            echo "                  </td>\n";
            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", format_time($message['CREATED']), "</td>\n";
            echo "                </tr>\n";
        }
    }
}

echo "                <tr>\n";
echo "                  <td class=\"postbody\">&nbsp;</td>\n";
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
echo "      <td align=\"left\" width=\"33%\">&nbsp;</td>\n";
echo "      <td class=\"postbody\" align=\"center\" width=\"33%\">", page_links("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&sort_by=$sort_by&sort_dir=$sort_dir", $start, $pm_messages_array['message_count'], 10), "</td>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {

    echo "      <td align=\"right\" width=\"33%\" valign=\"top\" style=\"white-space: nowrap\">";

    if (($current_folder <> PM_FOLDER_SAVED) && ($current_folder <> PM_FOLDER_OUTBOX)) {
        echo form_submit('pm_save_messages', gettext("Save"), sprintf('title="%s"', gettext("Save Selected Messages"))), "&nbsp;";
    }

    echo form_submit('pm_delete_messages', gettext("Delete")), "&nbsp;";

    if ($current_folder != PM_SEARCH_RESULTS) {
        echo form_submit('pm_export_messages', gettext("Export"), sprintf('title="%s"', gettext("Export Selected Messages"))), "&nbsp;";
    }

    echo "</span></td>\n";

}else {

    echo "      <td align=\"left\">&nbsp;</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

// View a message
if (isset($pm_message_array) && is_array($pm_message_array)) {

    $pm_message_array['CONTENT'] = pm_get_content($mid);

    echo "  <a name=\"message\"></a>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">", pm_display($pm_message_array, $message_folder), "</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>
