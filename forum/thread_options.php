<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: thread_options.php,v 1.75 2007-03-17 15:26:19 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Guests can't use this

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check that required variables are set

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    list($tid, $pid) = explode(".", $_GET['msg']);
}elseif (isset($_GET['tid']) && is_numeric($_GET['tid'])) {
    $tid = $_GET['tid'];
    $pid = 1;
}elseif (isset($_POST['tid']) && is_numeric($_POST['tid'])) {
    $tid = $_POST['tid'];
    $pid = 1;
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['error']}</h2>\n";
    html_draw_bottom();
    exit;
}

// Get the folder ID for the current message

if (!$fid = thread_get_folder($tid)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    html_draw_bottom();
    exit;
}

// UID of the current user.

$uid = bh_session_get_value('UID');

if (!$threaddata = thread_get($tid, true)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
    html_draw_bottom();
    exit;
}

$update = false;

if (isset($_POST['back'])) {

    $uri = "./messages.php?webtag=$webtag&msg=$tid.$pid";
    header_redirect($uri);
    exit;
}

// User Options

if (isset($_POST['markasread']) && is_numeric($_POST['markasread']) && $_POST['markasread'] != $threaddata['LAST_READ']) {

    $threaddata['LAST_READ'] = $_POST['markasread'];
    messages_set_read($tid, $threaddata['LAST_READ'], $uid, $threaddata['MODIFIED']);
    $update = true;

}else if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {

    $markasread = $_GET['markasread'];
    messages_set_read($tid, $markasread, $uid, $threaddata['MODIFIED']);

    $uri = "./messages.php?webtag=$webtag&msg=$tid.$pid&markasread=1";
    header_redirect($uri);
    exit;
}

if (isset($_POST['setinterest']) && is_numeric($_POST['setinterest']) && $_POST['setinterest'] != $threaddata['INTEREST']) {

    $threaddata['INTEREST'] = $_POST['setinterest'];
    thread_set_interest($tid, $threaddata['INTEREST']);
    $update = true;

    $uri = "./messages.php?webtag=$webtag&msg=$tid.$pid&setinterest=1";
    header_redirect($uri);
    exit;
}

if (isset($_POST['interest']) && is_numeric($_POST['interest']) && $_POST['interest'] != $threaddata['INTEREST']) {
    $threaddata['INTEREST'] = $_POST['interest'];
    thread_set_interest($tid, $threaddata['INTEREST']);
    $update = true;
}

// Admin Options

if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid) || ((($threaddata['FROM_UID'] == $uid) && $threaddata['ADMIN_LOCK'] == 0) && ((forum_get_setting('allow_post_editing', 'Y')) && intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)))) {

    if (isset($_POST['rename']) && strlen(trim(_stripslashes($_POST['rename']))) > 0) {

        $t_rename = trim(_stripslashes($_POST['rename']));

        if ($t_rename != $threaddata['TITLE']) {

            thread_change_title($fid, $tid, $t_rename);

            post_add_edit_text($tid, 1);

            if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

                admin_add_log_entry(RENAME_THREAD, array($tid, $threaddata['TITLE'], $t_rename));
            }

            $threaddata['TITLE'] = _htmlentities($t_rename);
            $update = true;
        }
    }

    if (isset($_POST['move']) && is_numeric($_POST['move'])) {

        $t_move = $_POST['move'];

        if (folder_is_valid($t_move) && $t_move != $threaddata['FID']) {

            if (bh_session_check_perm(USER_PERM_THREAD_CREATE, $t_move)) {

                thread_change_folder($tid, $t_move);

                $new_folder_title = folder_get_title($t_move);
                $old_folder_title = folder_get_title($threaddata['FID']);

                post_add_edit_text($tid, 1);

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

                    admin_add_log_entry(MOVED_THREAD, array($tid, $threaddata['TITLE'], $old_folder_title, $new_folder_title));
                }

                $threaddata['FID'] = $_POST['move'];
                $update = true;
            }
        }
    }
}

if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

    if (isset($_POST['closed'])) {

        if (($_POST['closed'] == "Y") != $threaddata['CLOSED']) {

            $threaddata['CLOSED'] = ($_POST['closed'] == "Y");
            thread_set_closed($tid, $threaddata['CLOSED']);
            admin_add_log_entry(($threaddata['CLOSED']) ? CLOSED_THREAD : OPENED_THREAD, array($tid, $threaddata['TITLE']));
            $update = true;
        }
    }

    if (isset($_POST['lock'])) {

        if (($_POST['lock'] == "Y") != $threaddata['ADMIN_LOCK']) {

            $threaddata['ADMIN_LOCK'] = ($_POST['lock'] == "Y");
            thread_admin_lock($tid, $threaddata['ADMIN_LOCK']);
            admin_add_log_entry(($threaddata['ADMIN_LOCK']) ? LOCKED_THREAD : UNLOCKED_THREAD, array($tid, $threaddata['TITLE']));
            $update = true;
        }
    }

    if (isset($_POST['sticky'])) {

        if ($_POST['sticky'] == "Y") {

            $day = isset($_POST['sticky_day']) && is_numeric($_POST['sticky_day']) ? $_POST['sticky_day'] : 0;
            $month = isset($_POST['sticky_month']) && is_numeric($_POST['sticky_month']) ? $_POST['sticky_month'] : 0;
            $year = isset($_POST['sticky_year']) && is_numeric($_POST['sticky_year']) ? $_POST['sticky_year'] : 0;
            $tmp_sticky_until = $day || $month || $year ? mktime(0, 0, 0, $month, $day, $year) : false;

            if (($_POST['sticky'] == $threaddata['STICKY'] && $tmp_sticky_until != $threaddata['STICKY_UNTIL']) || $_POST['sticky'] != $threaddata['STICKY']) {

                $threaddata['STICKY'] = $_POST['sticky'];
                $threaddata['STICKY_UNTIL'] = $tmp_sticky_until;
                thread_set_sticky($tid, true, $threaddata['STICKY_UNTIL']);
                admin_add_log_entry(CREATE_THREAD_STICKY, array($tid, $threaddata['TITLE']));
                $update = true;
            }

        }elseif ($_POST['sticky'] != $threaddata['STICKY']) {

            $threaddata['STICKY'] = $_POST['sticky'];
            thread_set_sticky($tid, false);

            admin_add_log_entry(REMOVE_THREAD_STICKY, array($tid, $threaddata['TITLE']));

            $update = true;
        }
    }

    if (isset($_POST['thread_merge_split']) && is_numeric($_POST['thread_merge_split'])) {

        if ($_POST['thread_merge_split'] == 0) {

            if (isset($_POST['merge_thread']) && is_numeric($_POST['merge_thread'])
                && isset($_POST['merge_type']) && is_numeric($_POST['merge_type'])
                && isset($_POST['merge_thread_con']) && $_POST['merge_thread_con'] == "Y") {

                $merge_thread = $_POST['merge_thread'];
                $merge_type = $_POST['merge_type'];

                if (validate_msg($merge_thread)) {
                    list($merge_thread,) = explode('.', $merge_thread);
                }

                $error_str = "";

                if ($merge_result = thread_merge($merge_thread, $tid, $merge_type, $error_str)) {

                    admin_add_log_entry(THREAD_MERGE, $merge_result);
                    $update = true;

                }else {

                    html_draw_top();
                    echo "<h1>{$lang['error']}</h1>\n";
                    echo "<h2>{$lang['threadmergefailed']}</h2>\n";

                    if (isset($error_str) && strlen(trim($error_str)) > 0) {
                        echo $error_str;
                    }

                    html_draw_bottom();
                    exit;
                }
            }

        }elseif ($_POST['thread_merge_split'] == 1) {
            
            if (isset($_POST['split_thread']) && is_numeric($_POST['split_thread'])
                && $_POST['split_thread'] > 1 && isset($_POST['split_type']) 
                && is_numeric($_POST['split_type']) && isset($_POST['split_thread_con']) 
                && $_POST['split_thread_con'] == "Y") {

                $split_start = $_POST['split_thread'];
                $split_type = $_POST['split_type'];

                $error_str = "";

                if ($split_result = thread_split($tid, $split_start, $split_type, $error_str)) {

                    admin_add_log_entry(THREAD_SPLIT, $split_result);
                    $update = true;

                }else {

                    html_draw_top();
                    echo "<h1>{$lang['error']}</h1>\n";
                    echo "<h2>{$lang['threadsplitfailed']}</h2>\n";
                    
                    if (isset($error_str) && strlen(trim($error_str)) > 0) {
                        echo $error_str;
                    }

                    html_draw_bottom();
                    exit;
                }
            }
        }
    }

    if (isset($_POST['t_to_uid_in_thread']) && is_numeric($_POST['t_to_uid_in_thread']) && isset($_POST['deluser_con']) && $_POST['deluser_con'] == "Y") {

        if ($del_uid = $_POST['t_to_uid_in_thread']) {

            $user_logon = user_get_logon($del_uid['UID']);

            thread_delete_by_user($tid, $del_uid['UID']);

            admin_add_log_entry(DELETE_USER_THREAD_POSTS, array($tid, $threaddata['TITLE'], $user_logon));

            $update = true;
        }
    }

    if (isset($_POST['delthread']) && is_numeric($_POST['delthread'])) {

        if (isset($_POST['delthread_con']) && $_POST['delthread_con'] == "Y") {

            $delthread = $_POST['delthread'];
            
            thread_delete($tid, $delthread);

            admin_add_log_entry(DELETE_THREAD, array($tid, $threaddata['TITLE']));

            $update = true;
        }
    }

    if (isset($_POST['undelthread']) && $_POST['undelthread'] == "Y") {

        if (isset($_POST['undelthread_con']) && $_POST['undelthread_con'] == "Y") {

            thread_undelete($tid);

            admin_add_log_entry(UNDELETE_THREAD, array($tid, $threaddata['TITLE']));

            $update = true;
        }
    }

    if (!$threaddata = thread_get($tid, true)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
        html_draw_bottom();
        exit;
    }
}

if ($threaddata['LENGTH'] > 0) {

    html_draw_top("basetarget=_blank", "robots=noindex,nofollow", 'thread_options.js');

    echo "<h1>{$lang['threadoptions']} &raquo; <a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.1\" target=\"_self\">#{$tid} ", thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']), "</a></h1>\n";
    echo "<br />\n";

    if ($update) {
        echo "<h2>{$lang['updatesmade']}</h2>\n";
        echo "<br />\n";
    }

    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_self\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['useroptions']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"250\" class=\"posthead\">{$lang['markedasread']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("markasread", _htmlentities($threaddata['LAST_READ']), 5), " {$lang['postsoutof']} {$threaddata['LENGTH']}</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" class=\"posthead\">{$lang['interest']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", -1, $lang['ignore'], $threaddata['INTEREST'] == -1), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", 0, $lang['normal'], $threaddata['INTEREST'] == 0), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", 1, $lang['interested'], $threaddata['INTEREST'] == 1), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", 2, $lang['subscribe'], $threaddata['INTEREST'] == 2), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";

    if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid) || ((($threaddata['FROM_UID'] == $uid) && $threaddata['ADMIN_LOCK'] == 0) && ((forum_get_setting('allow_post_editing', 'Y')) && intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)))) {

        echo "        <br />\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['rename']} / {$lang['move']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"250\" class=\"posthead\">{$lang['renamethread']}:</td>\n";

        if (thread_is_poll($tid)) {
            echo "                        <td align=\"left\"><a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_parent\">{$lang['editthepoll']}</a> {$lang['torenamethisthread']}.</td>\n";
        }else {
            echo "                        <td align=\"left\">", form_input_text("rename", $threaddata['TITLE'], 30, 64), "</td>\n";
        }

        $thread_type = (thread_is_poll($tid) ? FOLDER_ALLOW_POLL_THREAD : FOLDER_ALLOW_NORMAL_THREAD);

        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"posthead\">{$lang['movethread']}:</td>\n";
        echo "                        <td align=\"left\">", folder_draw_dropdown($threaddata['FID'], "move", "", $thread_type, "", "post_folder_dropdown"), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";

        if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

            $thread_available_pids = thread_get_unmoved_posts($tid);   

            if (thread_is_poll($tid) && $thread_available_pids) {

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mergesplitthread']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_input_hidden("thread_merge_split", 1), $lang['splitthreadatpost'], "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids, $thread_available_pids), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 0, $lang['selectedpostsandrepliesonly'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 1, $lang['selectedandallfollowingposts'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("split_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";

            }else if (!thread_is_poll($tid) && !$thread_available_pids) {

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mergesplitthread']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_input_hidden("thread_merge_split", 0), $lang['mergewiththreadid'], "</td>\n";
                echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text('merge_thread', '', 26, 0, "", "merge_thread_id"), form_submit_image("search_button.png", "search", $lang['search'], "onclick=\"return openThreadSearch('$webtag', 'merge_thread');\" title=\"{$lang['search']}\"", "search_button"), "</div></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 0, $lang['postsinthisthreadatstart'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 1, $lang['postsinthisthreadatend'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 2, $lang['reorderpostsintodateorder'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("merge_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";

            }else if (!thread_is_poll($tid) && $thread_available_pids) {

                array_unshift($thread_available_pids, '');

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mergesplitthread']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_radio("thread_merge_split", 0, $lang['mergewiththreadid'], false, false, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text('merge_thread', '', 26, 0, "", "merge_thread_id"), form_submit_image("search_button.png", "search", $lang['search'], "onclick=\"return openThreadSearch('$webtag', 'merge_thread');\" title=\"{$lang['search']}\"", "search_button"), "</div></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 0, $lang['postsinthisthreadatstart'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 1, $lang['postsinthisthreadatend'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 2, $lang['reorderpostsintodateorder'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("merge_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_radio("thread_merge_split", 1, $lang['splitthreadatpost'], false, false, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids, $thread_available_pids), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 0, $lang['selectedpostsandrepliesonly'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 1, $lang['selectedandallfollowingposts'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("split_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['makethreadsticky']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"50%\" class=\"posthead\">{$lang['sticky']}:</td>\n";

            if ($threaddata['STICKY_UNTIL'] && $threaddata['STICKY'] == "Y") {

                $year = date("Y", $threaddata['STICKY_UNTIL']);
                $month = date("n", $threaddata['STICKY_UNTIL']);
                $day = date("j", $threaddata['STICKY_UNTIL']);

            }else {

                $year = 0;
                $month = 0;
                $day = 0;
            }

            echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_radio("sticky", "Y", $lang['until'], $threaddata['STICKY'] == "Y"), "&nbsp;", form_date_dropdowns($year, $month, $day, "sticky_"), "&nbsp;&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">", form_radio("sticky", "N", $lang['no'], $threaddata['STICKY'] == "N"), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['locked']} / {$lang['closed']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['closedforposting']}:</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("closed", "Y", $lang['yes'], $threaddata['CLOSED']), " \n";
            echo "                          ", form_radio("closed", "N", $lang['no'], !$threaddata['CLOSED']), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['locktitleandfolder']}:</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("lock", "Y", $lang['yes'], $threaddata['ADMIN_LOCK']), " \n";
            echo "                          ", form_radio("lock", "N", $lang['no'], !$threaddata['ADMIN_LOCK']), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['deleteposts']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['deletepostsinthreadbyuser']}:</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", post_draw_to_dropdown_in_thread($tid, 0, false, true), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("deluser_con", "Y", $lang['confirm']), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['deletethread']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['deletethread']}:</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delthread", -1, $lang['no'], true), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delthread", 0, "Permenant Delete", false), " \n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delthread", 1, "Move to Deleted Threads", false), " \n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("delthread_con", "Y", $lang['confirm'], false), " \n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
        }

        echo "      </td>\n";
        echo "    </tr>\n";
    }

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), " &nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif ($thread_length = thread_can_be_undeleted($tid)) {
    
    html_draw_top("basetarget=_blank", "robots=noindex,nofollow", 'thread_options.js');

    echo "<h1>{$lang['threadoptions']}: <a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.1\" target=\"_self\">#{$tid} ", thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']), "</a></h1>\n";
    echo "<br />\n";

    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("thread_length", _htmlentities($thread_length)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\"> \n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['undeletethread']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['undeletethread']}</td>\n";
    echo "                        <td align=\"left\">", form_radio("undelthread", "Y", $lang['yes']), "&nbsp;", form_radio("undelthread", "N", $lang['no'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("undelthread_con", "Y", $lang['confirm'], false), " \n";
    echo "                        </td>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threaddeletedpermenantly']}</h2>\n";
    html_draw_bottom();
}

?>