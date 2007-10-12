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

/* $Id: pm_messages.php,v 1.29 2007-10-12 23:45:59 decoyduck Exp $ */

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

// Fetch the webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access PMs

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Check that PM system is enabled

pm_enabled();

// Check for new PMs

pm_new_check($pm_new_count, $pm_outbox_count);

// Various Headers for the PM folders

$pm_header_array = array(PM_FOLDER_INBOX   => $lang['pminbox'],
                         PM_FOLDER_SENT    => $lang['pmsentitems'],
                         PM_FOLDER_OUTBOX  => $lang['pmoutbox'],
                         PM_FOLDER_SAVED   => $lang['pmsaveditems'],
                         PM_FOLDER_DRAFTS  => $lang['pmdrafts'],
                         PM_SEARCH_RESULTS => $lang['searchresults']);

$pm_folder_name_array = array(PM_OUTBOX      => $lang['pmoutbox'],
                              PM_UNREAD      => $lang['pminbox'],
                              PM_READ        => $lang['pminbox'],
                              PM_SENT        => $lang['pmsentitems'],
                              PM_SAVED_IN    => $lang['pmsaveditems'],
                              PM_SAVED_OUT   => $lang['pmsaveditems'],
                              PM_SAVED_DRAFT => $lang['pmdrafts']);

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
}else {
    $page = 1;
}

// Default folder

$current_folder = PM_FOLDER_INBOX;

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

if (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_SENT) {
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

    if ($_POST['folder'] == PM_FOLDER_SENT) {
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

        html_draw_top('pm_popup_disabled');
        html_error_msg($lang['messagenotfoundinselectedfolder']);
        html_draw_bottom();
        exit;
    }

    if (!$pm_message_array = pm_message_get($mid)) {

        html_draw_top('pm_popup_disabled');
        html_error_msg($lang['messagehasbeendeleted']);
        html_draw_bottom();
        exit;
    }
}

// Delete Messages

if (isset($_POST['deletemessages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {

        foreach($_POST['process'] as $delete_mid) {

            if (!pm_delete_message($delete_mid)) {

                $error_msg_array[] = $lang['failedtodeleteselectedmessages'];
                $valid = false;
            }
        }

        if ($valid) {

            header_redirect("pm_messages.php?webtag=$webtag&folder=$current_folder&deleted=true");
            exit;
        }
    }
}

// Archive Messages

if (isset($_POST['savemessages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {

        foreach($_POST['process'] as $archive_mid) {

            if (!pm_archive_message($archive_mid)) {

                $error_msg_array[] = $lang['failedtoarchiveselectedmessages'];
                $valid = false;
            }
        }

        if ($valid) {

            header_redirect("pm_messages.php?webtag=$webtag&folder=$current_folder&archived=true");
            exit;
        }
    }
}

// Export Messages

if (isset($_POST['exportfolder'])) {

    pm_export($current_folder);
    exit;
}

// Search string.

if (isset($_POST['search'])) {

    if (isset($_POST['search_string']) && strlen(trim(_stripslashes($_POST['search_string']))) > 0) {
        $search_string = trim(_stripslashes($_POST['search_string']));
    }else {
        $search_string = '';
    }

    if (!pm_search_execute($search_string, $error)) {

        search_get_word_lengths($min_length, $max_length);

        $search_frequency = forum_get_setting('search_min_frequency', false, 0);

        switch($error) {

            case SEARCH_NO_MATCHES:

                $error_msg_array[] = $lang['searchreturnednoresults'];
                $valid = false;

                break;

            case SEARCH_NO_KEYWORDS:

                if (isset($search_string) && strlen(trim($search_string)) > 0) {

                    $keywords_error_array = search_strip_keywords($search_string, true);
                    $keywords_error_array['keywords'] = search_strip_special_chars($keywords_error_array['keywords'], false);

                    $stopped_keywords = urlencode(implode(' ', $keywords_error_array['keywords']));

                    $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true&amp;keywords=$stopped_keywords\" target=\"_blank\" onclick=\"return display_mysql_stopwords('$webtag', '$stopped_keywords')\">{$lang['mysqlstopwordlist']}</a>";

                    $error_msg = sprintf("<p>{$lang['notexttosearchfor']}</p>", $min_length, $max_length, $mysql_stop_word_link);
                    $error_msg.= "<h2>{$lang['keywordscontainingerrors']}</h2>\n";
                    $error_msg.= "<p><ul><li>". implode("</li>\n        <li>", $keywords_error_array['keywords']). "</li></ul></p>\n";

                    html_draw_top('pm_popup_disabled');
                    html_error_msg($error_msg);
                    html_draw_bottom();
                    exit;

                }else {

                    $mysql_stop_word_link = "<a href=\"search.php?webtag=$webtag&amp;show_stop_words=true\" target=\"_blank\" onclick=\"return display_mysql_stopwords('$webtag', '')\">{$lang['mysqlstopwordlist']}</a>";

                    html_draw_top('pm_popup_disabled');
                    html_error_msg(sprintf("<p>{$lang['notexttosearchfor']}</p>", $min_length, $max_length, $mysql_stop_word_link));
                    html_draw_bottom();
                    exit;
                }

            case SEARCH_FREQUENCY_TOO_GREAT:

                html_draw_top('pm_popup_disabled');
                html_error_msg(sprintf($lang['searchfrequencyerror'], $search_frequency));
                html_draw_bottom();
                exit;
        }
    }
}

// Prune old messages for the current user

pm_user_prune_folders();

html_draw_top("basetarget=_blank", "openprofile.js", "search.js", "pm.js", 'pm_popup_disabled');

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if ($current_folder == PM_FOLDER_INBOX) {

    $pm_messages_array = pm_get_inbox($sort_by, $sort_dir, $start);

}elseif ($current_folder == PM_FOLDER_SENT) {

    $pm_messages_array = pm_get_sent($sort_by, $sort_dir, $start);

}elseif ($current_folder == PM_FOLDER_OUTBOX) {

    $pm_messages_array = pm_get_outbox($sort_by, $sort_dir, $start);

}elseif ($current_folder == PM_FOLDER_SAVED) {

    $pm_messages_array = pm_get_saved_items($sort_by, $sort_dir, $start);

}elseif ($current_folder == PM_FOLDER_DRAFTS) {

    $pm_messages_array = pm_get_drafts($sort_by, $sort_dir, $start);

}elseif ($current_folder == PM_SEARCH_RESULTS) {

    $pm_messages_array = pm_fetch_search_results($sort_by, $sort_dir, $start);
}

echo "<h1>{$pm_header_array[$current_folder]}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '96%', 'center');

}else if (isset($_GET['deleted'])) {

    html_display_success_msg($lang['successfullydeletedselectedmessages'], '96%', 'center');

}else if (isset($_GET['archived'])) {

    html_display_success_msg($lang['successfullyarchivedselectedmessages'], '96%', 'center');

}else if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) < 1) {

    if ($current_folder == PM_SEARCH_RESULTS) {

        html_display_warning_msg($lang['yoursearchreturnednomatches'], '96%', 'center');

    }else {

        html_display_warning_msg(sprintf($lang['yourfoldernamefolderisempty'], _htmlentities($pm_header_array[$current_folder])), '96%', 'center');
    }
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"pm\" action=\"pm_messages.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('folder', _htmlentities($current_folder)), "\n";
echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" valign=\"top\" width=\"100%\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\" border=\"0\">\n";
echo "                <tr>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_all", "toggle_all", "", false, "onclick=\"pm_toggle_all();\""), "</td>\n";
}else {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
}

if ($sort_by == 'PM.SUBJECT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"30%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['subject']}</a></td>\n";
}elseif ($sort_by == 'PM.SUBJECT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"30%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['subject']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"30%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['subject']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"30%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['subject']}</a></td>\n";
}

if ($current_folder == PM_SEARCH_RESULTS) {

    if ($sort_by == 'TYPE' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"15%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['folder']}</a></td>\n";
    }elseif ($sort_by == 'TYPE' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"15%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['folder']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"15%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['folder']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"15%\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TYPE&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['folder']}</a></td>\n";
    }
}

if ($current_folder == PM_FOLDER_INBOX || $current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) {

    $col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '15%' : '30%';

    if ($sort_by == 'PM.FROM_UID' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['from']}</a></td>\n";
    }elseif ($sort_by == 'PM.FROM_UID' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['from']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['from']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['from']}</a></td>\n";
    }
}

if ($current_folder == PM_FOLDER_SENT || $current_folder == PM_FOLDER_OUTBOX || $current_folder == PM_FOLDER_DRAFTS || $current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) {

    $col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '15%' : '30%';

    if ($sort_by == 'PM.TO_UID' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['to']}</a></td>\n";
    }elseif ($sort_by == 'PM.TO_UID' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['to']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['to']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\" width=\"$col_width\" nowrap=\"nowrap\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['to']}</a></td>\n";
    }
}

if ($sort_by == 'CREATED' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" nowrap=\"nowrap\" width=\"15%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['timesent']}</a></td>\n";
}elseif ($sort_by == 'CREATED' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" nowrap=\"nowrap\" width=\"15%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['timesent']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\" width=\"15%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['timesent']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\" width=\"15%\"><a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">{$lang['timesent']}</a></td>\n";
}

echo "                </tr>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {

    foreach($pm_messages_array['message_array'] as $message) {

        echo "                <tr>\n";
        echo "                  <td class=\"postbody\" align=\"center\" width=\"1%\">", form_checkbox('process[]', $message['MID'], ''), "</td>\n";
        echo "                  <td align=\"left\" class=\"postbody\">";

        if ($mid == $message['MID']) {

            echo "            <img src=\"".style_image('current_thread.png')."\" title=\"{$lang['currentmessage']}\" alt=\"{$lang['currentmessage']}\" />";

        }else {

            if (($message['TYPE'] == PM_UNREAD)) {

                echo "            <img src=\"".style_image('pmunread.png')."\" title=\"{$lang['unreadmessage']}\" alt=\"{$lang['unreadmessage']}\" />";

            }else {

                echo "            <img src=\"".style_image('pmread.png')."\" title=\"{$lang['readmessage']}\" alt=\"{$lang['readmessage']}\" />";
            }
        }

        echo "            <a href=\"pm_messages.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}&amp;page=$page\" target=\"_self\">", word_filter_add_ob_tags(_htmlentities($message['SUBJECT'])), "</a>";

        if (isset($message['AID']) && pm_has_attachments($message['MID'])) {
            echo "            &nbsp;&nbsp;<img src=\"".style_image('attach.png')."\" border=\"0\" alt=\"{$lang['attachment']} - {$message['AID']}\" title=\"{$lang['attachment']}\" />";
        }

        echo "            </td>\n";

        if ($current_folder == PM_FOLDER_SENT || $current_folder == PM_FOLDER_OUTBOX) {

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
            echo word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
            echo "            </td>\n";

        }elseif ($current_folder == PM_FOLDER_SAVED) {

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['FROM_UID']}, '$webtag')\">";
            echo word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK'])) . "</a>";
            echo "            </td>\n";

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
            echo word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
            echo "            </td>\n";

        }elseif ($current_folder == PM_FOLDER_DRAFTS) {

            if (isset($message['RECIPIENTS']) && strlen(trim($message['RECIPIENTS'])) > 0) {

                $recipient_array = preg_split("/[;|,]/", trim($message['RECIPIENTS']));

                if ($message['TO_UID'] > 0) {
                    $recipient_array = array_unique(array_merge($recipient_array, array($message['TLOGON'])));
                }

                $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

                echo "                  <td align=\"left\" class=\"postbody\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</td>\n";

            }else {

                echo "                  <td align=\"left\" class=\"postbody\">";
                echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
                echo word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
                echo "            </td>\n";
            }

        }elseif ($current_folder == PM_SEARCH_RESULTS) {

            echo "                  <td align=\"left\" class=\"postbody\">{$pm_folder_name_array[$message['TYPE']]}</td>\n";

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['FROM_UID']}, '$webtag')\">";
            echo word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK'])) . "</a>";
            echo "            </td>\n";

            if ($message['TYPE'] & PM_SAVED_DRAFT) {

                if (isset($message['RECIPIENTS']) && strlen(trim($message['RECIPIENTS'])) > 0) {

                    $recipient_array = preg_split("/[;|,]/", trim($message['RECIPIENTS']));

                    if ($message['TO_UID'] > 0) {
                        $recipient_array = array_unique(array_merge($recipient_array, array($message['TLOGON'])));
                    }

                    $recipient_array = array_map('user_profile_popup_callback', $recipient_array);

                    echo "                  <td align=\"left\" class=\"postbody\">", word_filter_add_ob_tags(implode('; ', $recipient_array)), "</td>\n";

                }else {

                    echo "                  <td align=\"left\" class=\"postbody\">";
                    echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
                    echo word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
                    echo "            </td>\n";
                }

            }else {

                echo "                  <td align=\"left\" class=\"postbody\">";
                echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['TO_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['TO_UID']}, '$webtag')\">";
                echo word_filter_add_ob_tags(format_user_name($message['TLOGON'], $message['TNICK'])) . "</a>";
                echo "            </td>\n";
            }

        }else {

            echo "                  <td align=\"left\" class=\"postbody\">";
            echo "            <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" onclick=\"return openProfile({$message['FROM_UID']}, '$webtag')\">";
            echo word_filter_add_ob_tags(format_user_name($message['FLOGON'], $message['FNICK'])) . "</a>";
            echo "            </td>\n";

        }

        echo "                  <td align=\"left\" class=\"postbody\">", format_time($message['CREATED']), "</td>\n";
        echo "                </tr>\n";
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
echo "      <td align=\"left\" valign=\"top\" width=\"100%\">\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td width=\"25%\">&nbsp;</td>\n";
echo "            <td class=\"postbody\" align=\"center\">", page_links("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder", $start, $pm_messages_array['message_count'], 10), "</td>\n";

if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {
    echo "            <td align=\"right\" width=\"25%\" nowrap=\"nowrap\">", ($current_folder <> PM_SEARCH_RESULTS) ? form_submit("exportfolder", "Export Folder") : "", "&nbsp;", (($current_folder <> PM_FOLDER_SAVED) && ($current_folder <> PM_FOLDER_OUTBOX)) ? form_submit("savemessages", $lang['savemessage']) : "", "&nbsp;", form_submit("deletemessages", $lang['delete']), "</td>\n";
}else {
    echo "            <td width=\"25%\">&nbsp;</td>\n";
}

echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

// View a message

if (isset($pm_message_array) && is_array($pm_message_array)) {

    $pm_message_array['CONTENT'] = pm_get_content($mid);

    echo "  <br />\n";
    echo "  <table cellpadding=\"5\" cellspacing=\"0\" width=\"96%\">\n";
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
