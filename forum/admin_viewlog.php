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
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Array to hold our error messages
$error_msg_array = array();

$remove_type = null;

// Types of admin log entries
$admin_log_type_array = array(
    ALL_LOG_ENTIES => gettext("All Log Entries"),
    CHANGE_USER_STATUS => gettext("User Status Changes"),
    CHANGE_FORUM_ACCESS => gettext("Forum Access Changes"),
    DELETE_ALL_USER_POSTS => gettext("User Mass Post Deletion"),
    EDIT_THREAD_OPTIONS => gettext("Thread Title Edits"),
    MOVED_THREADS => gettext("Mass Thread Moves"),
    CREATE_FOLDER => gettext("Folder Creations"),
    DELETE_FOLDER => gettext("Folder Deletions"),
    CHANGE_PROFILE_SECT => gettext("Profile Section Changes"),
    ADDED_PROFILE_SECT => gettext("Profile Section Additions"),
    DELETE_PROFILE_SECT => gettext("Profile Section Deletions"),
    CHANGE_PROFILE_ITEM => gettext("Profile Item Changes"),
    ADDED_PROFILE_ITEM => gettext("Profile Item Additions"),
    DELETE_PROFILE_ITEM => gettext("Profile Item Deletions"),
    EDITED_START_PAGE => gettext("Start Page Changes"),
    CREATED_NEW_STYLE => gettext("Forum Style Creations"),
    MOVED_THREAD => gettext("Thread Moves"),
    CLOSED_THREAD => gettext("Thread Closures"),
    OPENED_THREAD => gettext("Thread Openings"),
    RENAME_THREAD => gettext("Thread Renames"),
    DELETE_POST => gettext("Post Deletions"),
    EDIT_POST => gettext("Post Edits"),
    EDIT_WORD_FILTER => gettext("Word Filter Edits"),
    CREATE_THREAD_STICKY => gettext("Thread Sticky Creations"),
    REMOVE_THREAD_STICKY => gettext("Thread Sticky Deletions"),
    END_USER_SESSION => gettext("User Session Deletions"),
    EDIT_FORUM_SETTINGS => gettext("Forum Settings Edits"),
    LOCKED_THREAD => gettext("Thread Locks"),
    UNLOCKED_THREAD => gettext("Thread Unlocks"),
    DELETE_USER_THREAD_POSTS => gettext("User Mass Post Deletions in a Thread"),
    DELETE_THREAD => gettext("Thread Deletions"),
    ATTACHMENTS_DELETE => gettext("Attachment Deletions"),
    EDIT_FORUM_LINKS => gettext("Forum Link Edits"),
    APPROVED_POST => gettext("Post Approvals"),
    CREATE_USER_GROUP => gettext("User Group Creations"),
    DELETE_USER_GROUP => gettext("User Group Deletions"),
    ADD_USER_TO_GROUP => gettext("User Group User Addition"),
    REMOVE_USER_FROM_GROUP => gettext("User Group User Removal"),
    CHANGE_USER_PASSWD => gettext("User Password Change"),
    ADD_BANNED_IP => gettext("IP Address Ban Additions"),
    REMOVE_BANNED_IP => gettext("IP Address Ban Deletions"),
    ADD_BANNED_LOGON => gettext("Logon Ban Additions"),
    REMOVE_BANNED_LOGON => gettext("Logon Ban Deletions"),
    ADD_BANNED_NICKNAME => gettext("Nickname Ban Additions"),
    REMOVE_BANNED_NICKNAME => gettext("Nickname Ban Additions"),
    ADD_BANNED_EMAIL => gettext("E-Mail Ban Additions"),
    REMOVE_BANNED_EMAIL => gettext("E-Mail Ban Deletions"),
    ADDED_RSS_FEED => gettext("RSS Feed Additions"),
    EDITED_RSS_FEED => gettext("RSS Feed Changes"),
    UNDELETE_THREAD => gettext("Thread Undeletions"),
    ADD_BANNED_REFERER => gettext("HTTP Referer Ban Additions"),
    REMOVE_BANNED_REFERER => gettext("HTTP Referer Ban Deletions"),
    DELETED_RSS_FEED => gettext("RSS Feed Deletions"),
    UPDATED_BAN => gettext("Ban Changes"),
    THREAD_SPLIT => gettext("Thread Splits"),
    THREAD_MERGE => gettext("Thread Merges"),
    ADD_FORUM_LINKS => gettext("Forum Link Additions"),
    DELETE_FORUM_LINKS => gettext("Forum Link Deletions"),
    EDIT_TOP_LINK_CAPTION => gettext("Forum Link Top Caption Changes"),
    DELETE_USER => gettext("User Deletions"),
    DELETE_USER_DATA => gettext("User Data Deletions"),
    UPDATE_USER_GROUP => gettext("User Group Changes"),
    BAN_HIT_TYPE_IP => gettext("IP Address Ban Check Results"),
    BAN_HIT_TYPE_LOGON => gettext("Logon Ban Check Results"),
    BAN_HIT_TYPE_NICK => gettext("Nickname Ban Check Results"),
    BAN_HIT_TYPE_EMAIL => gettext("Email Ban Check Results"),
    BAN_HIT_TYPE_REF => gettext("HTTP Referer Ban Check Results"),
    BAN_HIT_TYPE_SFS => gettext("StopForumSpam Ban Check Results")
);

$admin_log_group_type_array = array(
    ADMIN_LOG_GROUP_NONE => gettext("Do Not Group"),
    ADMIN_LOG_GROUP_YEAR => gettext("Group by Year"),
    ADMIN_LOG_GROUP_MONTH => gettext("Group by Month"),
    ADMIN_LOG_GROUP_DAY => gettext("Group by Day"),
    ADMIN_LOG_GROUP_HOUR => gettext("Group by Hour"),
    ADMIN_LOG_GROUP_MINUTE => gettext("Group by Minute"),
    ADMIN_LOG_GROUP_SECOND => gettext("Group by Second")
);

$group_by = ADMIN_LOG_GROUP_NONE;

$sort_by = "CREATED";

$sort_dir = "DESC";

if (isset($_GET['group_by']) && is_numeric($_GET['group_by'])) {

    if (isset($admin_log_group_type_array[$_GET['group_by']])) {
        $group_by = $_GET['group_by'];
    }
}

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "CREATED") {
        $sort_by = "CREATED";
    } else if ($_GET['sort_by'] == "UID") {
        $sort_by = "UID";
    } else if ($_GET['sort_by'] == "ACTION") {
        $sort_by = "ACTION";
    } else if ($_GET['sort_by'] == "COUNT") {
        $sort_by = "COUNT";
    }
}

if (isset($_GET['sort_dir'])) {

    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else {
    $page = 1;
}

// Clear the admin log.
if (isset($_POST['prune_log'])) {

    $valid = true;

    if (isset($_POST['remove_type']) && is_numeric($_POST['remove_type'])) {

        $remove_type = intval($_POST['remove_type']);

    } else {

        $error_msg_array[] = gettext("You must specify an action type to remove");
        $valid = false;
    }

    if (isset($_POST['remove_days']) && is_numeric($_POST['remove_days'])) {
        $remove_days = intval($_POST['remove_days']);
    } else {
        $remove_days = 0;
    }

    if ($valid) {

        if (admin_prune_log($remove_type, $remove_days)) {

            header_redirect("admin_viewlog.php?webtag=$webtag&sort_dir=$sort_dir&sort_by=$sort_by&group_by=$group_by&pruned=true");
            exit;

        } else {

            $error_msg_array[] = gettext("Failed To Prune Admin Log");
            $valid = false;
        }
    }
}

html_draw_top(
    array(
        'title' => gettext('Admin - Admin Access Log'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

$admin_log_array = admin_get_log_entries($page, $group_by, $sort_by, $sort_dir);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Admin Access Log"), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

} else if (isset($_GET['pruned'])) {

    html_display_success_msg(gettext("Successfully Pruned Admin Log"), '86%', 'center');

} else if (sizeof($admin_log_array['admin_log_array']) < 1) {

    html_display_warning_msg(gettext("Admin Log is empty"), '86%', 'center');

} else {

    html_display_warning_msg(gettext("This list shows the last actions sanctioned by users with Admin privileges."), '86%', 'center');
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" width=\"10%\" align=\"left\">\n";

if ($sort_by == 'CREATED' && $sort_dir == 'ASC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Date/Time"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'CREATED' && $sort_dir == 'DESC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Date/Time"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Date/Time"), "</a>\n";
} else {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Date/Time"), "</a>\n";
}

echo "                  </td>\n";
echo "                  <td class=\"subhead\" width=\"10%\" align=\"left\">\n";

if ($sort_by == 'UID' && $sort_dir == 'ASC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Logon"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'UID' && $sort_dir == 'DESC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Logon"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Logon"), "</a>\n";
} else {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Logon"), "</a>\n";
}

echo "                  </td>\n";
echo "                  <td class=\"subhead\" align=\"left\">\n";

if ($sort_by == 'ACTION' && $sort_dir == 'ASC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Action"), "</a>\n";
    echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
} else if ($sort_by == 'ACTION' && $sort_dir == 'DESC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Action"), "</a>\n";
    echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
} else if ($sort_dir == 'ASC') {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Action"), "</a>\n";
} else {
    echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Action"), "</a>\n";
}

echo "                  </td>\n";

if (isset($group_by) && $group_by != ADMIN_LOG_GROUP_NONE) {

    echo "                  <td class=\"subhead\" width=\"10%\" align=\"center\">\n";

    if ($sort_by == 'COUNT' && $sort_dir == 'ASC') {
        echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=COUNT&amp;group_by=$group_by&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Count"), "</a>\n";
        echo "                     ", html_style_image('sort_asc', gettext("Sort Ascending")), "\n";
    } else if ($sort_by == 'COUNT' && $sort_dir == 'DESC') {
        echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=COUNT&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Count"), "</a>\n";
        echo "                     ", html_style_image('sort_desc', gettext("Sort Descending")), "\n";
    } else if ($sort_dir == 'ASC') {
        echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=COUNT&amp;sort_dir=ASC&amp;group_by=$group_by&amp;page=$page\">", gettext("Count"), "</a>\n";
    } else {
        echo "                    <a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=COUNT&amp;sort_dir=DESC&amp;group_by=$group_by&amp;page=$page\">", gettext("Count"), "</a>\n";
    }

    echo "                  </td>\n";
}

echo "                </tr>\n";

if (sizeof($admin_log_array['admin_log_array']) > 0) {

    foreach ($admin_log_array['admin_log_array'] as $admin_log_entry) {

        $auto_update = false;

        echo "                <tr>\n";
        echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\"><span title=\"", format_date_time($admin_log_entry['CREATED']), "\">", format_date_time($admin_log_entry['CREATED']), "</td>\n";

        $entry_array = htmlentities_array($admin_log_entry['ENTRY']);

        switch ($admin_log_entry['ACTION']) {

            case CHANGE_USER_STATUS:

                $action_text = sprintf(gettext("Changed user status for '%s'"), $entry_array[0]);
                break;

            case CHANGE_FORUM_ACCESS:

                $action_text = sprintf(gettext("Changed forum access permissions for '%s'"), $entry_array[1]);
                break;

            case DELETE_ALL_USER_POSTS:

                $action_text = sprintf(gettext("Deleted all posts for '%s'"), $entry_array[0]);
                break;

            case CHANGE_USER_PASSWD:

                $action_text = sprintf(gettext("Changed password for '%s'"), $entry_array[0]);
                break;

            case ADD_BANNED_IP:

                $action_text = sprintf(gettext("Added IP '%s' to ban list"), $entry_array[0]);
                break;

            case REMOVE_BANNED_IP:

                $action_text = sprintf(gettext("Removed IP '%s' from ban list"), $entry_array[0]);
                break;

            case ADD_BANNED_LOGON:

                $action_text = sprintf(gettext("Added logon '%s' to ban list"), $entry_array[0]);
                break;

            case REMOVE_BANNED_LOGON:

                $action_text = sprintf(gettext("Removed logon '%s' from ban list"), $entry_array[0]);
                break;

            case ADD_BANNED_NICKNAME:

                $action_text = sprintf(gettext("Added nickname '%s' to ban list"), $entry_array[0]);
                break;

            case REMOVE_BANNED_NICKNAME:

                $action_text = sprintf(gettext("Removed nickname '%s' from ban list"), $entry_array[0]);
                break;

            case ADD_BANNED_EMAIL:

                $action_text = sprintf(gettext("Added email address '%s' to ban list"), $entry_array[0]);
                break;

            case REMOVE_BANNED_EMAIL:

                $action_text = sprintf(gettext("Removed email address '%s' from ban list"), $entry_array[0]);
                break;

            case ADD_BANNED_REFERER:

                $action_text = sprintf(gettext("Added referer '%s' to ban list"), $entry_array[0]);
                break;

            case REMOVE_BANNED_REFERER:

                $action_text = sprintf(gettext("Removed referer '%s' from ban list"), $entry_array[0]);
                break;

            case EDIT_THREAD_OPTIONS:

                $action_text = sprintf(gettext("Edited Folder '%s'"), $entry_array[0]);
                break;

            case MOVED_THREADS:

                $action_text = sprintf(gettext("Moved all threads from '%s' to '%s'"), $entry_array[0], $entry_array[1]);
                break;

            case CREATE_FOLDER:

                $action_text = sprintf(gettext("Created new folder '%s'"), $entry_array[0]);
                break;

            case DELETE_FOLDER:

                $action_text = sprintf(gettext("Deleted folder '%s'"), $entry_array[0]);
                break;

            case CHANGE_PROFILE_SECT:

                $action_text = sprintf(gettext("Changed Profile section title from '%s' to '%s'"), $entry_array[0], $entry_array[2]);
                break;

            case ADDED_PROFILE_SECT:

                $action_text = sprintf(gettext("Added New Profile section '%s'"), $entry_array[0]);
                break;

            case DELETE_PROFILE_SECT:

                $action_text = sprintf(gettext("Deleted Profile Section '%s'"), $entry_array[0]);
                break;

            case CHANGE_PROFILE_ITEM:

                $action_text = sprintf(gettext("Changed Profile Item '%s'"), $entry_array[0]);
                break;

            case ADDED_PROFILE_ITEM:

                $action_text = sprintf(gettext("Added New Profile Item '%s' to section '%s'"), $entry_array[1], $entry_array[0]);
                break;

            case DELETE_PROFILE_ITEM:

                $action_text = sprintf(gettext("Deleted Profile Item '%s'"), $entry_array[0]);
                break;

            case EDITED_START_PAGE:

                $action_text = sprintf(gettext("Edited Start Page"));
                break;

            case CREATED_NEW_STYLE:

                $action_text = sprintf(gettext("Saved New Style '%s'"), $entry_array[0]);
                break;

            case MOVED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Moved Thread '%s' from '%s' to '%s'"), $thread_link, $entry_array[2], $entry_array[3]);
                break;

            case CLOSED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Closed Thread '%s'"), $thread_link);
                break;

            case OPENED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Opened Thread '%s'"), $thread_link);
                break;

            case RENAME_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[2]);
                $action_text = sprintf(gettext("Renamed Thread '%s' to '%s'"), $entry_array[1], $thread_link);
                break;

            case DELETE_POST:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[1], $entry_array[2], $entry_array[1], $entry_array[2]);
                $action_text = sprintf(gettext("Deleted Post '%s'"), $thread_link);
                break;

            case EDIT_POST:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[1], $entry_array[2], $entry_array[1], $entry_array[2]);
                $action_text = sprintf(gettext("Edited Post '%s'"), $thread_link);
                break;

            case EDIT_WORD_FILTER:

                $action_text = sprintf(gettext("Edited Word Filter"));
                break;

            case CREATE_THREAD_STICKY:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Made thread '%s' sticky"), $thread_link);
                break;

            case REMOVE_THREAD_STICKY:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Made thread '%s' non-sticky"), $thread_link);
                break;

            case END_USER_SESSION:

                $action_text = sprintf(gettext("Ended session for user '%s'"), $entry_array[0]);
                break;

            case EDIT_FORUM_SETTINGS:

                $action_text = sprintf(gettext("Edited Forum Settings"));
                break;

            case LOCKED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Locked thread options on '%s'"), $thread_link);
                break;

            case UNLOCKED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Unlocked thread options on '%s'"), $thread_link);
                break;

            case DELETE_USER_THREAD_POSTS:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Deleted posts from '%s' in thread '%s'"), $entry_array[2], $thread_link);
                break;

            case DELETE_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Deleted Thread '%s'"), $thread_link);
                break;

            case UNDELETE_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Undeleted Thread '%s'"), $thread_link);
                break;

            case ATTACHMENTS_DELETE:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[0], $entry_array[1], $entry_array[0], $entry_array[1]);
                $action_text = sprintf(gettext("Deleted attachment '%s' from post '%s'"), $entry_array[2], $thread_link);
                break;

            case EDIT_FORUM_LINKS:

                if (sizeof($entry_array) > 0) {

                    $forum_link = sprintf("admin_forum_links.php?webtag=$webtag&amp;lid=%s", $entry_array[0]);
                    $admin_link = sprintf("<a href=\"index.php?webtag=$webtag&final_uri=%s\" target=\"_blank\">%s</a>", rawurlencode($forum_link), $entry_array[1]);
                    $action_text = sprintf(gettext("Edited Forum Link: '%s'"), $admin_link);

                } else {

                    $action_text = sprintf(gettext("Edited Forum Links"));
                }

                break;

            case ADD_FORUM_LINKS:

                $forum_link = sprintf("admin_forum_links.php?webtag=$webtag&amp;lid=%s", $entry_array[0]);
                $admin_link = sprintf("<a href=\"index.php?webtag=$webtag&final_uri=%s\" target=\"_blank\">%s</a>", rawurlencode($forum_link), $entry_array[1]);
                $action_text = sprintf(gettext("Added Forum Link: '%s'"), $admin_link);
                break;

            case DELETE_FORUM_LINKS:

                $action_text = sprintf(gettext("Deleted Forum Link: '%s'"), $entry_array[0]);
                break;

            case EDIT_TOP_LINK_CAPTION:

                $action_text = sprintf(gettext("Changed top link caption from '%s' to '%s'"), $entry_array[1], $entry_array[0]);
                break;

            case APPROVED_POST:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[1], $entry_array[2], $entry_array[1], $entry_array[2]);
                $action_text = sprintf(gettext("Approved post '%s'"), $thread_link);
                break;

            case CREATE_USER_GROUP:

                $action_text = sprintf(gettext("Created User Group '%s'"), $entry_array[0]);
                break;

            case DELETE_USER_GROUP:

                $action_text = sprintf(gettext("Deleted User Group '%s'"), $entry_array[0]);
                break;

            case ADD_USER_TO_GROUP:

                $action_text = sprintf(gettext("Added user '%s' to group '%s'"), $entry_array[0], $entry_array[1]);
                break;

            case REMOVE_USER_FROM_GROUP:

                $action_text = sprintf(gettext("Remove user '%s' from group '%s'"), $entry_array[0], $entry_array[1]);
                break;

            case UPDATE_USER_GROUP:

                $action_text = sprintf(gettext("Updated User Group '%s'"), $entry_array[0]);
                break;

            case ADDED_RSS_FEED:

                $action_text = sprintf(gettext("Added RSS Feed '%s'"), $entry_array[0]);
                break;

            case EDITED_RSS_FEED:

                $action_text = sprintf(gettext("Edited RSS Feed '%s'"), $entry_array[0]);
                break;

            case DELETED_RSS_FEED:

                $action_text = sprintf(gettext("Deleted RSS Feed '%s'"), $entry_array[0]);
                break;

            case UPDATED_BAN:

                $admin_log_ban_types = array(
                    BAN_TYPE_IP => gettext("IP ban"),
                    BAN_TYPE_LOGON => gettext("Logon ban"),
                    BAN_TYPE_NICK => gettext("Nickname ban"),
                    BAN_TYPE_EMAIL => gettext("Email ban"),
                    BAN_TYPE_REF => gettext("Referer ban")
                );

                $ban_link = sprintf("admin_banned.php?webtag=$webtag&amp;ban_id=%s", $entry_array[0]);
                $admin_link = sprintf("<a href=\"index.php?webtag=$webtag&final_uri=%s\" target=\"_blank\">%s</a>", rawurlencode($ban_link), $entry_array[4]);
                $action_text = sprintf(gettext("Updated ban '%s'. Changed type from '%s' to '%s', Changed data from '%s' to '%s'."), $admin_link, $admin_log_ban_types[$entry_array[3]], $admin_log_ban_types[$entry_array[1]], $entry_array[4], $entry_array[2]);
                break;

            case THREAD_SPLIT:

                $threada_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[3]);
                $threadb_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[2], $entry_array[3]);

                $action_text = sprintf(gettext("Split thread '%s' at post %s  into new thread '%s'"), $threada_link, $entry_array[1], $threadb_link);
                break;

            case THREAD_MERGE:

                $threada_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $threadb_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[2], $entry_array[3]);
                $threadc_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[4], $entry_array[5]);

                $action_text = sprintf(gettext("Merged threads '%s' and '%s' into new thread '%s'"), $threada_link, $threadb_link, $threadc_link);
                break;

            case BAN_HIT_TYPE_IP:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                } else {

                    $admin_user_link = gettext("Guest");
                }

                $action_text = sprintf(gettext("User '%s' is banned. IP Address '%s' matched ban data '%s'"), $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_LOGON:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                } else {

                    $admin_user_link = gettext("Guest");
                }

                $action_text = sprintf(gettext("User '%s' is banned. Logon '%s' matched ban data '%s'"), $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_NICK:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                } else {

                    $admin_user_link = gettext("Guest");
                }

                $action_text = sprintf(gettext("User '%s' is banned. Nickname '%s' matched ban data '%s'"), $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_EMAIL:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                } else {

                    $admin_user_link = gettext("Guest");
                }

                $action_text = sprintf(gettext("User '%s' is banned. Email Address '%s' matched ban data '%s'"), $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_REF:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&amp;ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&amp;uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                } else {

                    $admin_user_link = gettext("Guest");
                }

                $action_text = sprintf(gettext("User '%s' is banned. HTTP Referer '%s' matched ban data '%s'"), $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_SFS:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                if (isset($entry_array[3]) && $entry_array[3] > 0) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[1]);

                } else {

                    $admin_user_link = gettext("Guest");
                }

                $ban_data_match = implode("', '", array_filter(array_slice($entry_array, 0, 3)));

                $action_text = sprintf(gettext("User '%s' is banned by StopForumSpam. Matched ban data '%s'"), $admin_user_link, $ban_data_match);
                break;

            case USER_PERMS_CHANGED:

                $action_text = sprintf(gettext("Modified perms for user '%s'"), $entry_array[0]);
                break;

            case USER_FOLDER_PERMS_CHANGED:

                $action_text = sprintf(gettext("Modified folder perms for user '%s'"), $entry_array[0]);
                break;

            case DELETE_USER:

                $action_text = sprintf(gettext("Deleted user account '%s'"), $entry_array[0]);
                break;

            case DELETE_USER_DATA:

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[0]);
                $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[1]);

                $action_text = sprintf(gettext("Deleted all user data for account '%s'"), $admin_user_link);
                break;

            default:

                $action_text = gettext("Unknown") . " :: {$admin_log_entry['ACTION']} :: ";
                $action_text .= implode(", ", $entry_array);
                break;
        }

        if ($auto_update === true) {
            echo "                    <td align=\"left\" valign=\"top\">", gettext("none"), "</td>\n";
        } else {
            echo "                    <td align=\"left\" valign=\"top\"><a href=\"admin_user.php?webtag=$webtag&amp;uid=", $admin_log_entry['UID'], "\">", word_filter_add_ob_tags(format_user_name($admin_log_entry['LOGON'], $admin_log_entry['NICKNAME']), true), "</a></td>\n";
        }

        echo "                    <td align=\"left\">", $action_text, "</td>\n";

        if (isset($group_by) && $group_by != ADMIN_LOG_GROUP_NONE) {
            echo "                    <td align=\"center\">{$admin_log_entry['COUNT']}</td>\n";
        }

        echo "                  </tr>\n";
    }
}

echo "                <tr>\n";
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
echo "      <td class=\"postbody\" align=\"center\">";

html_page_links("admin_viewlog.php?webtag=$webtag&sort_by=$sort_by&sort_dir=$sort_dir&group_by=$group_by", $page, $admin_log_array['admin_log_count'], 20);

echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <form accept-charset=\"utf-8\" action=\"admin_viewlog.php\" method=\"get\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
echo "  ", form_input_hidden("page", htmlentities_array($page)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">", gettext("Options"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\">", gettext("Group Similar Log Entries"), ":&nbsp;</td>\n";
echo "                        <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\" width=\"100%\">", form_dropdown_array("group_by", array(ADMIN_LOG_GROUP_NONE => gettext("Do Not Group"), ADMIN_LOG_GROUP_YEAR => gettext("Group by Year"), ADMIN_LOG_GROUP_MONTH => gettext("Group by Month"), ADMIN_LOG_GROUP_DAY => gettext("Group by Day"), ADMIN_LOG_GROUP_HOUR => gettext("Group by Hour"), ADMIN_LOG_GROUP_MINUTE => gettext("Group by Minute"), ADMIN_LOG_GROUP_SECOND => gettext("Group by Second")), $group_by, null, 'bhlogondropdown'), "&nbsp;", form_submit("select_action", gettext("Go")), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "  <br />\n";
echo "  <form accept-charset=\"utf-8\" action=\"admin_viewlog.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Prune Log"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\" style=\"white-space: nowrap\">", gettext("Remove Entries Relating to Action"), ":</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('remove_type', $admin_log_type_array), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\" style=\"white-space: nowrap\">", gettext("Remove Entries Older Than (Days)"), ":</td>\n";
echo "                        <td align=\"left\">", form_input_text('remove_days', '30', 15, 4), "&nbsp;", form_submit("prune_log", gettext("Prune Log")), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();