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

/* $Id: admin_viewlog.php,v 1.150 2008-10-26 16:46:24 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
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

$admin_log_type_array = array(ALL_LOG_ENTIES => $lang['alllogentries'],
                              CHANGE_USER_STATUS => $lang['userstatuschanges'],
                              CHANGE_FORUM_ACCESS => $lang['forumaccesschanges'],
                              DELETE_ALL_USER_POSTS => $lang['usermasspostdeletion'],
                              BANNED_IPADDRESS => $lang['ipaddressbanadditions'],
                              UNBANNED_IPADDRESS => $lang['ipaddressbandeletions'],
                              EDIT_THREAD_OPTIONS => $lang['threadtitleedits'],
                              MOVED_THREADS => $lang['massthreadmoves'],
                              CREATE_FOLDER => $lang['foldercreations'],
                              DELETE_FOLDER => $lang['folderdeletions'],
                              CHANGE_PROFILE_SECT => $lang['profilesectionchanges'],
                              ADDED_PROFILE_SECT => $lang['profilesectionadditions'],
                              DELETE_PROFILE_SECT => $lang['profilesectiondeletions'],
                              CHANGE_PROFILE_ITEM => $lang['profileitemchanges'],
                              ADDED_PROFILE_ITEM => $lang['profileitemadditions'],
                              DELETE_PROFILE_ITEM => $lang['profileitemdeletions'],
                              EDITED_START_PAGE => $lang['startpagechanges'],
                              CREATED_NEW_STYLE => $lang['forumstylecreations'],
                              MOVED_THREAD => $lang['threadmoves'],
                              CLOSED_THREAD => $lang['threadclosures'],
                              OPENED_THREAD => $lang['threadopenings'],
                              RENAME_THREAD => $lang['threadrenames'],
                              DELETE_POST => $lang['postdeletions'],
                              EDIT_POST => $lang['postedits'],
                              EDIT_WORD_FILTER => $lang['wordfilteredits'],
                              CREATE_THREAD_STICKY => $lang['threadstickycreations'],
                              REMOVE_THREAD_STICKY => $lang['threadstickydeletions'],
                              END_USER_SESSION => $lang['usersessiondeletions'],
                              EDIT_FORUM_SETTINGS => $lang['forumsettingsedits'],
                              LOCKED_THREAD => $lang['threadlocks'],
                              UNLOCKED_THREAD => $lang['threadunlocks'],
                              DELETE_USER_THREAD_POSTS => $lang['usermasspostdeletionsinathread'],
                              DELETE_THREAD => $lang['threaddeletions'],
                              DELETE_ATTACHMENT => $lang['attachmentdeletions'],
                              EDIT_FORUM_LINKS => $lang['forumlinkedits'],
                              APPROVED_POST => $lang['postapprovals'],
                              CREATE_USER_GROUP => $lang['usergroupcreations'],
                              DELETE_USER_GROUP => $lang['usergroupdeletions'],
                              ADD_USER_TO_GROUP => $lang['usergroupuseraddition'],
                              REMOVE_USER_FROM_GROUP => $lang['usergroupuserremoval'],
                              CHANGE_USER_PASSWD => $lang['userpasswordchange'],
                              UPDATE_USER_GROUP => $lang['usergroupchanges'],
                              ADD_BANNED_IP => $lang['ipaddressbanadditions'],
                              REMOVE_BANNED_IP => $lang['ipaddressbandeletions'],
                              ADD_BANNED_LOGON => $lang['logonbanadditions'],
                              REMOVE_BANNED_LOGON => $lang['logonbandeletions'],
                              ADD_BANNED_NICKNAME => $lang['nicknamebanadditions'],
                              REMOVE_BANNED_NICKNAME => $lang['nicknamebanadditions'],
                              ADD_BANNED_EMAIL => $lang['e-mailbanadditions'],
                              REMOVE_BANNED_EMAIL => $lang['e-mailbandeletions'],
                              ADDED_RSS_FEED => $lang['rssfeedadditions'],
                              EDITED_RSS_FEED => $lang['rssfeedchanges'],
                              UNDELETE_THREAD => $lang['threadundeletions'],
                              ADD_BANNED_REFERER => $lang['httprefererbanadditions'],
                              REMOVE_BANNED_REFERER => $lang['httprefererbandeletions'],
                              DELETED_RSS_FEED => $lang['rssfeeddeletions'],
                              UPDATED_BAN => $lang['banchanges'],
                              THREAD_SPLIT => $lang['threadsplits'],
                              THREAD_MERGE => $lang['threadmerges'],
                              ADD_FORUM_LINKS => $lang['forumlinkadditions'],
                              DELETE_FORUM_LINKS => $lang['forumlinkdeletions'],
                              EDIT_TOP_LINK_CAPTION => $lang['forumlinktopcaptionchanges'],
                              EDIT_FOLDER => $lang['folderedits'],
                              DELETE_USER => $lang['userdeletions'],
                              DELETE_USER_DATA => $lang['userdatadeletions'],
                              UPDATE_USER_GROUP => $lang['usergroupchanges'],
                              BAN_HIT_TYPE_IP => $lang['ipaddressbancheckresults'],
                              BAN_HIT_TYPE_LOGON => $lang['logonbancheckresults'],
                              BAN_HIT_TYPE_NICK => $lang['nicknamebancheckresults'],
                              BAN_HIT_TYPE_EMAIL => $lang['emailbancheckresults'],
                              BAN_HIT_TYPE_REF => $lang['httprefererbancheckresults']);

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
        echo "                    <td align=\"left\" valign=\"top\"><span title=\"", format_time($admin_log_entry['CREATED'], true), "\">", format_time($admin_log_entry['CREATED']), "</td>\n";

        $entry_array = htmlentities_array(explode("\x00", $admin_log_entry['ENTRY']));

        foreach ($entry_array as $key => $value) {
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

            case BAN_HIT_TYPE_IP:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                }else {

                    $admin_user_link = $lang['guest'];
                }

                $action_text = sprintf($lang['ipaddressbanhit'], $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_LOGON:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                }else {

                    $admin_user_link = $lang['guest'];
                }

                $action_text = sprintf($lang['logonbanhit'], $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_NICK:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                }else {

                    $admin_user_link = $lang['guest'];
                }

                $action_text = sprintf($lang['nicknamebanhit'], $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_EMAIL:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                }else {

                    $admin_user_link = $lang['guest'];
                }

                $action_text = sprintf($lang['emailbanhit'], $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case BAN_HIT_TYPE_REF:

                $auto_update = true;

                $index_link = "<a href=\"index.php?webtag=$webtag&amp;final_uri=%s\" target=\"_blank\">%s</a>";

                $admin_banned_link = sprintf("admin_banned.php?webtag=$webtag&amp;ban_id=%s", $entry_array[0]);
                $admin_banned_link = sprintf($index_link, rawurlencode($admin_banned_link), $entry_array[2]);

                if (isset($entry_array[3]) && isset($entry_array[4])) {

                    $admin_user_link = sprintf("admin_user.php?webtag=$webtag&amp;uid=%s", $entry_array[3]);
                    $admin_user_link = sprintf($index_link, rawurlencode($admin_user_link), $entry_array[4]);

                }else {

                    $admin_user_link = $lang['guest'];
                }

                $action_text = sprintf($lang['refererbanhit'], $admin_user_link, $entry_array[1], $admin_banned_link);
                break;

            case USER_PERMS_CHANGED:

                $action_text = sprintf($lang['modifiedpermsforuser'], $entry_array[0]);
                break;

            case USER_FOLDER_PERMS_CHANGED:

                $action_text = sprintf($lang['modifiedfolderpermsforuser'], $entry_array[0]);
                break;

            default:

                $action_text = "{$lang['unknown']} &raquo; {$admin_log_entry['ACTION']} &raquo; ";
                $action_text.= implode(", ", $entry_array);
                break;
        }

        if ($auto_update === true) {
            echo "                    <td align=\"left\" valign=\"top\">{$lang['none']}</td>\n";
        }else {
            echo "                    <td align=\"left\" valign=\"top\"><a href=\"admin_user.php?webtag=$webtag&amp;uid=", $admin_log_entry['UID'], "\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($admin_log_entry['LOGON'], $admin_log_entry['NICKNAME']))), "</a></td>\n";
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
echo "  <form accept-charset=\"utf-8\" action=\"admin_viewlog.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
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
echo "                        <td align=\"left\">", form_input_text('remove_days', '30', 15, 4), "</td>\n";
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
echo "      <td colspan=\"2\" align=\"center\">", form_submit("prune_log", $lang['prunelog']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>