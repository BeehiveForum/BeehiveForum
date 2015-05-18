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
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'search.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check that PM system is enabled
pm_enabled();

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
        PM_FOLDER_DRAFTS => gettext("Drafts"),
        PM_SEARCH_RESULTS => gettext("Search Results")
    );
}

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "SUBJECT") {
        $sort_by = "PM.SUBJECT";
    } else if ($_GET['sort_by'] == "TYPE") {
        $sort_by = "TYPE";
    } else if ($_GET['sort_by'] == "FROM_UID") {
        $sort_by = "PM.FROM_UID";
    } else if ($_GET['sort_by'] == "TO_UID") {
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

if (isset($mid) && is_numeric($mid) && $mid > 0) {

    if (!($message_data = pm_message_get($mid))) {
        html_draw_error(gettext("Message not found. Check that it hasn't been deleted."));
    }

    if (!pm_get_folder_type($current_folder)) {
        html_draw_error(gettext("Message not found. Check that it hasn't been deleted."));
    }
}

if (isset($_POST['pm_delete_messages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'is_numeric');
    } else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (isset($_POST['pm_delete_confirm']) && $_POST['pm_delete_confirm'] == 'Y') {

            if (pm_delete_messages($process_messages)) {

                if (in_array($mid, $process_messages)) {

                    header_redirect("pm_messages.php?webtag=$webtag&folder=$current_folder&page=$page&deleted=true#message");
                    exit;

                } else {

                    header_redirect("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&page=$page&deleted=true#message");
                    exit;
                }

            } else {

                $error_msg_array[] = gettext("Failed to delete selected messages");
                $valid = false;
            }

        } else {

            html_draw_top(
                array(
                    'title' => gettext('Delete Message'),
                    'class' => 'window_title'
                )
            );

            html_display_msg(gettext("Delete"), gettext("Are you sure you want to delete all of the selected messages?"), "pm_messages.php", 'post', array(
                'pm_option_submit' => gettext("Yes"),
                'back' => gettext("No")
            ), array(
                'folder' => $current_folder,
                'page' => $page,
                'process' => $process_messages,
                'pm_delete_messages' => gettext("Delete"),
                'pm_delete_confirm' => 'Y'
            ), '_self', 'center');
            html_draw_bottom();
            exit;
        }

    } else {

        $error_msg_array[] = gettext("You must select some messages to delete");
        $valid = false;
    }

} else if (isset($_POST['pm_save_messages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'is_numeric');
    } else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (pm_archive_messages($process_messages, $current_folder)) {

            header_redirect("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&page=$page&archived=true#message");
            exit;

        } else {

            $error_msg_array[] = gettext("Failed to archive selected messages");
            $valid = false;
        }

    } else {

        $error_msg_array[] = gettext("You must select some messages to archive");
        $valid = false;
    }
}

if (isset($_POST['search'])) {

    if (isset($_POST['search_string']) && strlen(trim($_POST['search_string'])) > 0) {
        $search_string = trim($_POST['search_string']);
    } else {
        $search_string = '';
    }

    $error = SEARCH_NO_ERROR;

    if (!pm_search_execute($search_string, $error)) {

        switch ($error) {

            case SEARCH_NO_MATCHES:

                header_redirect("pm_messages.php?webtag=$webtag&folder=6&search_no_results=true");
                exit;

            case SEARCH_FREQUENCY_TOO_GREAT:

                header_redirect("pm_messages.php?webtag=$webtag&folder=6&search_frequency_error=true");
                exit;
        }
    }
}

pm_user_prune_folders($_SESSION['UID']);

html_draw_top(
    array(
        'title' => sprintf(
            gettext('Private Messages - %s'),
            htmlentities_array($folder_names_array[$current_folder])
        ),
        'base_target' => '_blank',
        'js' => array(
            'js/search.js',
            'js/pm.js'
        ),
        'pm_popup_disabled' => true,
        'class' => 'window_title'
    )
);

if ($current_folder == PM_FOLDER_INBOX) {

    $messages_array = pm_get_inbox($sort_by, $sort_dir, $page, 10);

} else if ($current_folder == PM_FOLDER_SENT) {

    $messages_array = pm_get_sent($sort_by, $sort_dir, $page, 10);

} else if ($current_folder == PM_FOLDER_OUTBOX) {

    $messages_array = pm_get_outbox($sort_by, $sort_dir, $page, 10);

} else if ($current_folder == PM_FOLDER_SAVED) {

    $messages_array = pm_get_saved_items($sort_by, $sort_dir, $page, 10);

} else if ($current_folder == PM_FOLDER_DRAFTS) {

    $messages_array = pm_get_drafts($sort_by, $sort_dir, $page, 10);

} else if ($current_folder == PM_SEARCH_RESULTS) {

    $messages_array = pm_fetch_search_results($sort_by, $sort_dir, $page, 10);
}

echo "<h1>", gettext("Private Messages"), html_style_image('separator'), htmlentities_array($folder_names_array[$current_folder]), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '96%', 'center');

} else if (isset($_GET['message_sent'])) {

    html_display_success_msg(gettext("Message sent successfully."), '96%', 'center');

} else if (isset($_GET['message_saved'])) {

    html_display_success_msg(gettext("Message was successfully saved to 'Drafts' folder"), '96%', 'center');

} else if (isset($_GET['deleted'])) {

    html_display_success_msg(gettext("Successfully deleted selected messages"), '96%', 'center', 'pm_delete_success');

} else if (isset($_GET['archived'])) {

    html_display_success_msg(gettext("Successfully archived selected messages"), '96%', 'center', 'pm_archive_success');

} else if (isset($_GET['search_no_results'])) {

    html_display_warning_msg(gettext("Search Returned No Results"), '96%', 'center');

} else if (isset($_GET['search_frequency_error'])) {

    $search_limit_count = forum_get_setting('search_limit_count', 'is_numeric', 1);
    $search_limit_time = forum_get_setting('search_limit_time', 'is_numeric', 30);
    html_display_error_msg(sprintf(gettext("You can only perform %d search(es) every %s seconds."), $search_limit_count, $search_limit_time), '96%', 'center');

} else if (isset($messages_array['message_array']) && sizeof($messages_array['message_array']) < 1) {

    html_display_warning_msg(sprintf(gettext("Your %s folder is empty"), htmlentities_array($folder_names_array[$current_folder])), '96%', 'center');
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

if (isset($messages_array['message_array']) && sizeof($messages_array['message_array']) > 0) {
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"1%\">", form_checkbox("toggle_all", "toggle_all"), "</td>\n";
} else {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
}

$col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '35%' : '50%';

echo "                  <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\" colspan=\"2\">\n";

if ($sort_by == 'PM.SUBJECT' && $sort_dir == 'ASC') {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'PM.SUBJECT' && $sort_dir == 'DESC') {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a>\n";
} else {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=SUBJECT&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Subject"), "</a>\n";
}

echo "                  </td>\n";

if ($current_folder == PM_FOLDER_INBOX || $current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) {

    $col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '15%' : '30%';
    echo "                  <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\">\n";

    if ($sort_by == 'PM.FROM_UID' && $sort_dir == 'ASC') {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a>\n";
        echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
    } else if ($sort_by == 'PM.FROM_UID' && $sort_dir == 'DESC') {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a>\n";
        echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
    } else if ($sort_dir == 'ASC') {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a>\n";
    } else {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=FROM_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("From"), "</a>\n";
    }

    echo "                  </td>\n";
}

if ($current_folder == PM_FOLDER_SENT || $current_folder == PM_FOLDER_OUTBOX || $current_folder == PM_FOLDER_DRAFTS || $current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) {

    $col_width = ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_SEARCH_RESULTS) ? '15%' : '30%';
    echo "                  <td class=\"subhead\" align=\"left\" width=\"$col_width\" style=\"white-space: nowrap\">\n";

    if ($sort_by == 'PM.TO_UID' && $sort_dir == 'ASC') {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a>\n";
        echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
    } else if ($sort_by == 'PM.TO_UID' && $sort_dir == 'DESC') {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a>\n";
        echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
    } else if ($sort_dir == 'ASC') {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a>\n";
    } else {
        echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=TO_UID&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("To"), "</a>\n";
    }

    echo "                  </td>\n";
}

echo "                  <td class=\"subhead\" align=\"left\" style=\"white-space: nowrap\" width=\"20%\">\n";

if ($sort_by == 'CREATED' && $sort_dir == 'ASC') {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'CREATED' && $sort_dir == 'DESC') {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a>\n";
} else {
    echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page&amp;folder=$current_folder\" target=\"_self\">", gettext("Time Sent"), "</a>\n";
}

echo "                  </td>\n";
echo "                </tr>\n";

if (isset($messages_array['message_array']) && sizeof($messages_array['message_array']) > 0) {

    foreach ($messages_array['message_array'] as $message) {

        echo "                <tr>\n";
        echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\">", form_checkbox("process[]", $message['MID']), "</td>\n";

        if ($mid == $message['MID']) {

            echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\">", html_style_image('current_thread', gettext("Current Message")), "</td>";

        } else if (($current_folder == PM_FOLDER_INBOX) && ($message['TYPE'] == PM_UNREAD)) {

            echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\">", html_style_image('pm_unread', gettext("Unread Message")), "</td>";

        } else {

            echo "                  <td class=\"postbody\" align=\"center\" valign=\"top\" width=\"1%\">", html_style_image('pm_read', gettext("Read Message")), "</td>";
        }

        echo "                  <td align=\"left\" class=\"postbody\" width=\"50%\" valign=\"top\">";

        if (strlen(trim($message['SUBJECT'])) > 0) {

            echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}&amp;page=$page#message\" target=\"_self\">", word_filter_add_ob_tags($message['SUBJECT'], true), "</a>";

        } else {

            echo "                    <a href=\"pm_messages.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}&amp;page=$page#message\" target=\"_self\"><i>", gettext("No Subject"), "</i></a>";
        }

        if (isset($message['ATTACHMENT_COUNT']) && $message['ATTACHMENT_COUNT'] > 0) {
            echo "                    &nbsp;&nbsp;", html_style_image('attach', gettext("Attachment")), "";
        }

        echo "                  </td>\n";

        if ($current_folder == PM_FOLDER_SAVED || $current_folder == PM_FOLDER_INBOX || $current_folder == PM_SEARCH_RESULTS) {

            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">\n";
            echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$message['FROM_UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($message['FROM_LOGON'], $message['FROM_NICKNAME']), true), "</a>\n";
            echo "                  </td>\n";
        }

        if (in_array($current_folder, array(PM_FOLDER_SENT, PM_FOLDER_OUTBOX, PM_FOLDER_SAVED, PM_FOLDER_DRAFTS, PM_SEARCH_RESULTS))) {

            if (isset($message['RECIPIENTS']) && sizeof($message['RECIPIENTS']) > 0) {

                $recipients_display = array_slice($message['RECIPIENTS'], 0, 2);

                echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">";

                foreach ($recipients_display as $recipient) {
                    echo "                    <a href=\"user_profile.php?webtag=$webtag&amp;uid={$recipient['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($recipient['LOGON'], $recipient['NICKNAME']), true), "</a>\n";
                }

                if (sizeof($message['RECIPIENTS']) - 2 > 0) {
                    echo "&nbsp;", sprintf(gettext("and %d others"), sizeof($message['RECIPIENTS']) - 2);
                }

                echo "                  </td>\n";

            } else {

                echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", gettext('Unknown User'), "</td>\n";
            }
        }

        echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", format_date_time($message['CREATED']), "</td>\n";
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
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" width=\"33%\">&nbsp;</td>\n";
echo "      <td class=\"postbody\" align=\"center\" width=\"33%\">";

html_page_links("pm_messages.php?webtag=$webtag&mid=$mid&folder=$current_folder&sort_by=$sort_by&sort_dir=$sort_dir", $page, $messages_array['message_count'], 10);

echo "      </td>\n";

if (isset($messages_array['message_array']) && sizeof($messages_array['message_array']) > 0) {

    echo "      <td align=\"right\" width=\"33%\" valign=\"top\" style=\"white-space: nowrap\">";

    if (($current_folder == PM_FOLDER_INBOX) || ($current_folder == PM_FOLDER_SENT)) {
        echo form_submit('pm_save_messages', gettext("Save"), sprintf('title="%s"', gettext("Save Selected Messages"))), "&nbsp;";
    }

    echo form_submit('pm_delete_messages', gettext("Delete")), "&nbsp;";

    echo "</span></td>\n";

} else {

    echo "      <td align=\"left\">&nbsp;</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

if (isset($message_data) && is_array($message_data)) {

    $message_data['CONTENT'] = pm_get_content($mid);

    if (($current_folder == PM_FOLDER_INBOX) && ($message_data['TYPE'] == PM_UNREAD)) {
        pm_mark_as_read($mid);
    }

    echo "  <a name=\"message\"></a>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">";

    pm_display($message_data);

    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();