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

/* $Id: admin_viewlog.php,v 1.128 2007-12-26 13:19:33 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Types of admin log entries

$admin_log_type_array = array(ALL_LOG_ENTIES => 'All Log Entries',
                              CHANGE_USER_STATUS => 'User Status Changes',
                              CHANGE_FORUM_ACCESS => 'Forum Access Changes',
                              DELETE_ALL_USER_POSTS => 'User Mass Post Deletion',
                              BANNED_IPADDRESS => 'IP Address Ban Additions',
                              UNBANNED_IPADDRESS => 'IP Address Ban Deletions',
                              EDIT_THREAD_OPTIONS => 'Thread Title Edits',
                              MOVED_THREADS => 'Mass Thread Moves',
                              CREATE_FOLDER => 'Folder Creations',
                              DELETE_FOLDER => 'Folder Deletions',
                              CHANGE_PROFILE_SECT => 'Profile Section Changes',
                              ADDED_PROFILE_SECT => 'Profile Section Additions',
                              DELETE_PROFILE_SECT => 'Profile Section Deletions',
                              CHANGE_PROFILE_ITEM => 'Profile Item Changes',
                              ADDED_PROFILE_ITEM => 'Profile Item Additions',
                              DELETE_PROFILE_ITEM => 'Profile Item Deletions',
                              EDITED_START_PAGE => 'Start Page Changes',
                              CREATED_NEW_STYLE => 'Forum Style Creations',
                              MOVED_THREAD => 'Thread Moves',
                              CLOSED_THREAD => 'Thread Closures',
                              OPENED_THREAD => 'Thread Openings',
                              RENAME_THREAD => 'Thread Renames',
                              DELETE_POST => 'Post Deletions',
                              EDIT_POST => 'Post Edits',
                              EDIT_WORD_FILTER => 'Word Filter Edits',
                              CREATE_THREAD_STICKY => 'Thread Sticky Creations',
                              REMOVE_THREAD_STICKY => 'Thread Sticky Deletions',
                              END_USER_SESSION => 'User Session Deletions',
                              EDIT_FORUM_SETTINGS => 'Forum Settings Edits',
                              LOCKED_THREAD => 'Thread Locks',
                              UNLOCKED_THREAD => 'Thread Unlocks',
                              DELETE_USER_THREAD_POSTS => 'User Mass Post Deletions in a Thread',
                              DELETE_THREAD => 'Thread Deletions',
                              DELETE_ATTACHMENT => 'Attachment Deletions',
                              EDIT_FORUM_LINKS => 'Forum Link Edits',
                              APPROVED_POST => 'Post Approvals',
                              CREATE_USER_GROUP => 'User Group Creations',
                              DELETE_USER_GROUP => 'User Group Deletions',
                              ADD_USER_TO_GROUP => 'User Group User Addition',
                              REMOVE_USER_FROM_GROUP => 'User Group User Removal',
                              CHANGE_USER_PASSWD => 'User Password Change',
                              UPDATE_USER_GROUP => 'User Group Changes',
                              ADD_BANNED_IP => 'IP Address Ban Additions',
                              REMOVE_BANNED_IP => 'IP Address Ban Deletions',
                              ADD_BANNED_LOGON => 'Logon Ban Additions',
                              REMOVE_BANNED_LOGON => 'Logon Ban Deletions',
                              ADD_BANNED_NICKNAME => 'Nickname Ban Additions',
                              REMOVE_BANNED_NICKNAME => 'Nickname Ban Additions',
                              ADD_BANNED_EMAIL => 'E-Mail Ban Additions',
                              REMOVE_BANNED_EMAIL => 'E-Mail Ban Deletions',
                              ADDED_RSS_FEED => 'RSS Feed Additions',
                              EDITED_RSS_FEED => 'RSS Feed Changes',
                              UNDELETE_THREAD => 'Thread Undeletions',
                              ADD_BANNED_REFERER => 'HTTP Referer Ban Additions',
                              REMOVE_BANNED_REFERER => 'HTTP Referer Ban Deletions',
                              DELETED_RSS_FEED => 'RSS Feed Deletions',
                              UPDATED_BAN => 'Ban Changes',
                              THREAD_SPLIT => 'Thread Splits',
                              THREAD_MERGE => 'Thread Merges',
                              APPROVED_USER => 'User Approvals',
                              ADD_FORUM_LINKS => 'Forum Link Additions',
                              DELETE_FORUM_LINKS => 'Forum Link Deletions',
                              EDIT_TOP_LINK_CAPTION => 'Forum Link Top Caption Changes',
                              EDIT_FOLDER => 'Folder Edits',
                              DELETE_USER => 'User Deletions',
                              DELETE_USER_DATA => 'User Data Deletions',
                              FORUM_AUTO_UPDATE_STATS => 'Forum Stats Auto Updates',
                              FORUM_AUTO_PRUNE_PM => 'Forum Auto PM Pruning',
                              FORUM_AUTO_PRUNE_SESSIONS => 'Forum Auto Session Pruning',
                              FORUM_AUTO_CLEAN_THREAD_UNREAD => 'Forum Auto Thread Unread Data Updates',
                              FORUM_AUTO_CLEAN_CAPTCHA => 'Forum Auto Text Captcha Clean-Ups',
                              UPDATE_USER_GROUP => 'User Group Changes');

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "CREATED") {
        $sort_by = "CREATED";
    } elseif ($_GET['sort_by'] == "UID") {
        $sort_by = "UID";
    } elseif ($_GET['sort_by'] == "ACTION") {
        $sort_by = "ACTION";
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
}else {
    $page = 1;
}

$start = floor($page - 1) * 20;
if ($start < 0) $start = 0;

// Array to hold our error messages

$error_msg_array = array();

// Clear the admin log.

if (isset($_POST['prune_log'])) {

    $valid = true;

    if (isset($_POST['remove_type']) && is_numeric($_POST['remove_type'])) {

        $remove_type = $_POST['remove_type'];

    }else {

        $error_msg_array[] = $lang['youmustspecifyanactiontypetoremove'];
        $valid = false;
    }

    if (isset($_POST['remove_days']) && is_numeric($_POST['remove_days'])) {
        $remove_days = $_POST['remove_days'];
    }else {
        $remove_days = 0;
    }

    if ($valid) {

        if (admin_prune_log($remove_type, $remove_days)) {

            header_redirect("admin_viewlog.php?webtag=$webtag&pruned=true");
            exit;

        }else {

            $error_msg_array[] = $lang['failedtopruneadminlog'];
            $valid = false;
        }
    }
}

html_draw_top();

$admin_log_array = admin_get_log_entries($start, $sort_by, $sort_dir);

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['adminaccesslog']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '75%', 'center');

}else if (isset($_GET['pruned'])) {

    html_display_success_msg($lang['successfullyprunedadminlog'], '75%', 'center');

}else if (sizeof($admin_log_array['admin_log_array']) < 1) {

    html_display_warning_msg($lang['adminlogempty'], '75%', 'center');

}else {

    html_display_warning_msg($lang['adminlogexp'], '75%', 'center');
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"75%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if ($sort_by == 'CREATED' && $sort_dir == 'ASC') {
    echo "                    <td class=\"subhead_sort_asc\" width=\"100\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page\">{$lang['datetime']}</a></td>\n";
}elseif ($sort_by == 'CREATED' && $sort_dir == 'DESC') {
    echo "                    <td class=\"subhead_sort_desc\" width=\"100\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page\">{$lang['datetime']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                    <td class=\"subhead\" width=\"100\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=ASC&amp;page=$page\">{$lang['datetime']}</a></td>\n";
}else {
    echo "                    <td class=\"subhead\" width=\"100\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=CREATED&amp;sort_dir=DESC&amp;page=$page\">{$lang['datetime']}</a></td>\n";
}

if ($sort_by == 'UID' && $sort_dir == 'ASC') {
    echo "                    <td class=\"subhead_sort_asc\" width=\"200\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;page=$page\">{$lang['logon']}</a></td>\n";
}elseif ($sort_by == 'UID' && $sort_dir == 'DESC') {
    echo "                    <td class=\"subhead_sort_desc\" width=\"200\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;page=$page\">{$lang['logon']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                    <td class=\"subhead\" width=\"200\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;page=$page\">{$lang['logon']}</a></td>\n";
}else {
    echo "                    <td class=\"subhead\" width=\"200\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;page=$page\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'ACTION' && $sort_dir == 'ASC') {
    echo "                    <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=DESC&amp;page=$page\">{$lang['action']}</a></td>\n";
}elseif ($sort_by == 'ACTION' && $sort_dir == 'DESC') {
    echo "                    <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=ASC&amp;page=$page\">{$lang['action']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                    <td class=\"subhead\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=ASC&amp;page=$page\">{$lang['action']}</a></td>\n";
}else {
    echo "                    <td class=\"subhead\" align=\"left\"><a href=\"admin_viewlog.php?webtag=$webtag&amp;sort_by=ACTION&amp;sort_dir=DESC&amp;page=$page\">{$lang['action']}</a></td>\n";
}

echo "                  </tr>\n";

if (sizeof($admin_log_array['admin_log_array']) > 0) {

    foreach ($admin_log_array['admin_log_array'] as $admin_log_entry) {

        $auto_update = false;

        echo "                  <tr>\n";
        echo "                    <td align=\"left\" valign=\"top\">", format_time($admin_log_entry['CREATED']), "</td>\n";

        $entry_array = _htmlentities(explode("\x00", $admin_log_entry['ENTRY']));

        foreach($entry_array as $key => $value) {
            if (strlen($value) < 1) $entry_array[$key] = "Unknown";
        }

        switch ($admin_log_entry['ACTION']) {

            case CHANGE_USER_STATUS:

                $action_text = sprintf($lang['changedstatusforuser'], $entry_array[0]);
                break;

            case CHANGE_FORUM_ACCESS:

                $action_text = sprintf($lang['changedforumaccess'], $entry_array[1]);
                break;

            case DELETE_ALL_USER_POSTS:

                $action_text = sprintf($lang['deletedallusersposts'], $entry_array[0]);
                break;

            case CHANGE_USER_PASSWD:

                $action_text = sprintf($lang['changedpasswordforuser'], $entry_array[0]);
                break;

            case ADD_BANNED_IP:

                $action_text = sprintf($lang['addedipaddresstobanlist'], $entry_array[0]);
                break;

            case REMOVE_BANNED_IP:

                $action_text = sprintf($lang['removedipaddressfrombanlist'], $entry_array[0]);
                break;

            case ADD_BANNED_LOGON:

                $action_text = sprintf($lang['addedlogontobanlist'], $entry_array[0]);
                break;

            case REMOVE_BANNED_LOGON:

                $action_text = sprintf($lang['removedlogonfrombanlist'], $entry_array[0]);
                break;

            case ADD_BANNED_NICKNAME:

                $action_text = sprintf($lang['addednicknametobanlist'], $entry_array[0]);
                break;

            case REMOVE_BANNED_NICKNAME:

                $action_text = sprintf($lang['removednicknamefrombanlist'], $entry_array[0]);
                break;

            case ADD_BANNED_EMAIL:

                $action_text = sprintf($lang['addedemailtobanlist'], $entry_array[0]);
                break;

            case REMOVE_BANNED_EMAIL:

                $action_text = sprintf($lang['removedemailfrombanlist'], $entry_array[0]);
                break;

            case ADD_BANNED_REFERER:

                $action_text = sprintf($lang['addedreferertobanlist'], $entry_array[0]);
                break;

            case REMOVE_BANNED_REFERER:

                $action_text = sprintf($lang['removedrefererfrombanlist'], $entry_array[0]);
                break;

            case EDIT_THREAD_OPTIONS:

                $action_text = sprintf($lang['editedfolder'], $entry_array[0]);
                break;

            case MOVED_THREADS:

                $action_text = sprintf($lang['movedallthreadsfromto'], $entry_array[0], $entry_array[1]);
                break;

            case CREATE_FOLDER:

                $action_text = sprintf($lang['creatednewfolder'], $entry_array[0]);
                break;

            case DELETE_FOLDER:

                $action_text = sprintf($lang['deletedfolder'], $entry_array[0]);
                break;

            case CHANGE_PROFILE_SECT:

                $action_text = sprintf($lang['changedprofilesectiontitle'], $entry_array[0], $entry_array[2]);
                break;

            case ADDED_PROFILE_SECT:

                $action_text = sprintf($lang['addednewprofilesection'], $entry_array[0]);
                break;

            case DELETE_PROFILE_SECT:

                $action_text = sprintf($lang['deletedprofilesection'], $entry_array[0]);
                break;

            case CHANGE_PROFILE_ITEM:

                $action_text = sprintf($lang['changedprofileitem'], $entry_array[0]);
                break;

            case ADDED_PROFILE_ITEM:

                $action_text = sprintf($lang['addednewprofileitem'], $entry_array[1], $entry_array[0]);
                break;

            case DELETE_PROFILE_ITEM:

                $action_text = sprintf($lang['deletedprofileitem'], $entry_array[0]);
                break;

            case EDITED_START_PAGE:

                $action_text = sprintf($lang['editedstartpage']);
                break;

            case CREATED_NEW_STYLE:

                $action_text = sprintf($lang['savednewstyle'], $entry_array[0]);
                break;

            case MOVED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['movedthread'], $thread_link, $entry_array[2], $entry_array[3]);
                break;

            case CLOSED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['closedthread'], $thread_link);
                break;

            case OPENED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['openedthread'], $thread_link);
                break;

            case RENAME_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[2]);
                $action_text = sprintf($lang['renamedthread'], $entry_array[1], $thread_link);
                break;

            case DELETE_POST:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[1], $entry_array[2], $entry_array[1], $entry_array[2]);
                $action_text = sprintf($lang['deletedpost'], $thread_link);
                break;

            case EDIT_POST:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[1], $entry_array[2], $entry_array[1], $entry_array[2]);
                $action_text = sprintf($lang['editedpost'], $thread_link);
                break;

            case EDIT_WORD_FILTER:

                $action_text = sprintf($lang['editedwordfilter']);
                break;

            case CREATE_THREAD_STICKY:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['madethreadsticky'], $thread_link);
                break;

            case REMOVE_THREAD_STICKY:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['madethreadnonsticky'], $thread_link);
                break;

            case END_USER_SESSION:

                $action_text = sprintf($lang['endedsessionforuser'], $entry_array[0]);
                break;

            case EDIT_FORUM_SETTINGS:

                $action_text = sprintf($lang['editedforumsettings']);
                break;

            case LOCKED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['lockedthreadtitlefolder'], $thread_link);
                break;

            case UNLOCKED_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['unlockedthreadtitlefolder'], $thread_link);
                break;

            case DELETE_USER_THREAD_POSTS:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['deletedpostsfrominthread'], $entry_array[2], $thread_link);
                break;

            case DELETE_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['deletedthread'], $thread_link);
                break;

            case UNDELETE_THREAD:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['undeletedthread'], $thread_link);
                break;

            case DELETE_ATTACHMENT:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[0], $entry_array[1], $entry_array[0], $entry_array[1]);
                $action_text = sprintf($lang['deletedattachmentfrompost'], $entry_array[2], $thread_link);
                break;

            case EDIT_FORUM_LINKS:

                if (sizeof($entry_array) > 0) {

                    $forum_link = sprintf("admin_forum_links.php?webtag=$webtag&amp;lid=%s", $entry_array[0]);
                    $admin_link = sprintf("<a href=\"index.php?webtag=$webtag&final_uri=%s\" target=\"_blank\">%s</a>", rawurlencode($forum_link), $entry_array[1]);
                    $action_text = sprintf($lang['editedforumlink'], $admin_link);

                }else {

                    $action_text = sprintf($lang['editedforumlinks']);
                }

                break;

            case ADD_FORUM_LINKS:

                $forum_link = sprintf("admin_forum_links.php?webtag=$webtag&amp;lid=%s", $entry_array[0]);
                $admin_link = sprintf("<a href=\"index.php?webtag=$webtag&final_uri=%s\" target=\"_blank\">%s</a>", rawurlencode($forum_link), $entry_array[1]);
                $action_text = sprintf($lang['addedforumlink'], $admin_link);
                break;

            case DELETE_FORUM_LINKS:

                $action_text = sprintf($lang['deletedforumlink'], $entry_array[0]);
                break;

            case EDIT_TOP_LINK_CAPTION:

                $action_text = sprintf($lang['changedtoplinkcaption'], $entry_array[1], $entry_array[0]);
                break;

            case APPROVED_POST:

                $thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.%s\" target=\"_blank\">%s.%s</a>", $entry_array[1], $entry_array[2], $entry_array[1], $entry_array[2]);
                $action_text = sprintf($lang['approvedpost'], $thread_link);
                break;

            case CREATE_USER_GROUP:

                $action_text = sprintf($lang['createdusergroup'], $entry_array[0]);
                break;

            case DELETE_USER_GROUP:

                $action_text = sprintf($lang['deletedusergroup'], $entry_array[0]);
                break;

            case ADD_USER_TO_GROUP:

                $action_text = sprintf($lang['addedusertogroup'], $entry_array[0], $entry_array[1]);
                break;

            case REMOVE_USER_FROM_GROUP:

                $action_text = sprintf($lang['removeduserfromgroup'], $entry_array[0], $entry_array[1]);
                break;

            case UPDATE_USER_GROUP:

                $action_text = sprintf($lang['updatedusergroup'], $entry_array[0]);
                break;

            case ADDED_RSS_FEED:

                $action_text = sprintf($lang['addedrssfeed'], $entry_array[0]);
                break;

            case EDITED_RSS_FEED:

                $action_text = sprintf($lang['editedrssfeed'], $entry_array[0]);
                break;

            case DELETED_RSS_FEED:

                $action_text = sprintf($lang['deletedrssfeed'], $entry_array[0]);
                break;

            case UPDATED_BAN:

                $admin_log_ban_types = array(BAN_TYPE_IP    => $lang['ipban'],
                                             BAN_TYPE_LOGON => $lang['logonban'],
                                             BAN_TYPE_NICK  => $lang['nicknameban'],
                                             BAN_TYPE_EMAIL => $lang['emailban'],
                                             BAN_TYPE_REF   => $lang['refererban']);

                $ban_link = sprintf("admin_banned.php?webtag=$webtag&amp;ban_id=%s", $entry_array[0]);
                $admin_link = sprintf("<a href=\"index.php?webtag=$webtag&final_uri=%s\" target=\"_blank\">%s</a>", rawurlencode($ban_link), $entry_array[4]);
                $action_text = sprintf($lang['updatedban'], $admin_link, $admin_log_ban_types[$entry_array[3]], $admin_log_ban_types[$entry_array[1]], $entry_array[4], $entry_array[2]);
                break;

            case THREAD_SPLIT:

                $threada_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[3]);
                $threadb_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[2], $entry_array[3]);

                $action_text = sprintf($lang['splitthreadatpostintonewthread'], $threada_link, $entry_array[1], $threadb_link);
                break;

            case THREAD_MERGE:

                $threada_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[0], $entry_array[1]);
                $threadb_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[2], $entry_array[3]);
                $threadc_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\" target=\"_blank\">%s</a>", $entry_array[4], $entry_array[5]);

                $action_text = sprintf($lang['mergedthreadintonewthread'], $threada_link, $threadb_link, $threadc_link);
                break;

            case APPROVED_USER:

                $action_text = sprintf($lang['approveduser'], $entry_array[0]);
                break;

            case FORUM_AUTO_UPDATE_STATS:

                $auto_update = true;
                $action_text = $lang['forumautoupdatestats'];
                break;

            case FORUM_AUTO_PRUNE_PM:

                $auto_update = true;
                $action_text = $lang['forumautoprunepm'];
                break;

            case FORUM_AUTO_PRUNE_SESSIONS:

                $auto_update = true;
                $action_text = $lang['forumautoprunesessions'];
                break;

            case FORUM_AUTO_CLEAN_THREAD_UNREAD:

                $auto_update = true;
                $action_text = $lang['forumautocleanthreadunread'];
                break;

            case FORUM_AUTO_CLEAN_CAPTCHA:

                $auto_update = true;
                $action_text = $lang['forumautocleancaptcha'];
                break;

            default:

                $action_text = "{$lang['unknown']} &raquo; {$admin_log_entry['ACTION']}";
                $action_text.= implode(", ", $entry_array);
                break;
        }

        if ($auto_update === true) {
            echo "                    <td align=\"left\" valign=\"top\">{$lang['none']}</td>\n";
        }else {
            echo "                    <td align=\"left\" valign=\"top\"><a href=\"admin_user.php?webtag=$webtag&amp;uid=", $admin_log_entry['UID'], "\">", word_filter_add_ob_tags(_htmlentities(format_user_name($admin_log_entry['LOGON'], $admin_log_entry['NICKNAME']))), "</a></td>\n";
        }

        echo "                    <td align=\"left\">", $action_text, "</td>\n";
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
echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_viewlog.php?webtag=$webtag&sort_by=$sort_by&sort_dir=$sort_dir", $start, $admin_log_array['admin_log_count'], 20), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <form action=\"admin_viewlog.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"75%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\" nowrap=\"nowrap\">{$lang['removeentriesrelatingtoaction']}:</td>\n";
echo "                        <td align=\"left\">", form_dropdown_array('remove_type', $admin_log_type_array, false), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"250\" nowrap=\"nowrap\">{$lang['removeentriesolderthandays']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text('remove_days', '7', 15, 4), "</td>\n";
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
echo "    <tr>\n";
echo "      <td colspan=\"2\" align=\"center\">", form_submit("prune_log", $lang['prune_log']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>
