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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get webtag
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

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Guests can't use this
if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that required variables are set
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode(".", $_GET['msg']);

}elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];
    list($tid, $pid) = explode(".", $_POST['msg']);

}else {

    html_draw_top("title={$lang['threadcouldnotbefound']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Get the folder ID for the current message
if (!$fid = thread_get_folder($tid)) {

    html_draw_top("title={$lang['threadcouldnotbefound']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// UID of the current user.
$uid = session_get_value('UID');

// Get the existing thread data.
if (!$thread_data = thread_get($tid, true)) {

    html_draw_top("title={$lang['threadcouldnotbefound']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages
$error_msg_array = array();

// Array of valid thread deletion types
$thread_delete_valid_types = array(THREAD_DELETE_PERMENANT, THREAD_DELETE_NON_PERMENANT);

// Back button clicked.
if (isset($_POST['back'])) {

    header_redirect("messages.php?webtag=$webtag&msg=$msg");
    exit;
}

// Code for handling functionality from messages.php
if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {

    if (in_range($_GET['markasread'], 0, $thread_data['LENGTH'])) {

        $mark_as_read = $_GET['markasread'];

        if (messages_set_read($tid, $mark_as_read, $thread_data['MODIFIED'])) {

            header_redirect("messages.php?webtag=$webtag&msg=$msg&markasread=1");
            exit;
        }
    }

    header_redirect("messages.php?webtag=$webtag&msg=$msg&markasread=0");
    exit;

}elseif (isset($_POST['setinterest']) && is_numeric($_POST['setinterest'])) {

    $thread_interest = $_POST['setinterest'];

    if (thread_set_interest($tid, $thread_interest)) {

        header_redirect("messages.php?webtag=$webtag&msg=$msg&setinterest=1");
        exit;
    }

    header_redirect("messages.php?webtag=$webtag&msg=$msg&setinterest=0");
    exit;
}

// Submit Code
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['markasread']) && is_numeric($_POST['markasread'])) {

        if (in_range($_POST['markasread'], 0, $thread_data['LENGTH'])) {

            $thread_data['LAST_READ'] = $_POST['markasread'];

            if (!messages_set_read($tid, $thread_data['LAST_READ'], $thread_data['MODIFIED'])) {

                $error_msg_array[] = $lang['failedtoupdatethreadreadstatus'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['failedtoupdatethreadreadstatus'];
            $valid = false;
        }
    }

    if (isset($_POST['interest']) && is_numeric($_POST['interest'])) {

        $thread_data['INTEREST'] = $_POST['interest'];

        if (!thread_set_interest($tid, $thread_data['INTEREST'])) {

            $error_msg_array[] = $lang['failedtoupdatethreadinterest'];
            $valid = false;
        }
    }

    // Admin Options
    if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid) || (($thread_data['BY_UID'] == $uid) && ($thread_data['ADMIN_LOCK'] != THREAD_ADMIN_LOCK_ENABLED) && forum_get_setting('allow_post_editing', 'Y') && ((intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $thread_data['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0) * MINUTE_IN_SECONDS)))))) {

        if (isset($_POST['rename']) && strlen(trim(stripslashes_array($_POST['rename']))) > 0) {

            $t_rename = trim(stripslashes_array($_POST['rename']));

            if ($t_rename !== trim($thread_data['TITLE'])) {

                if (thread_change_title($tid, $t_rename)) {

                    post_add_edit_text($tid, 1);

                    if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

                        admin_add_log_entry(RENAME_THREAD, array($tid, $thread_data['TITLE'], $t_rename));
                    }

                }else {

                    $error_msg_array[] = $lang['failedtorenamethread'];
                    $valid = false;
                }
            }
        }

        if (isset($_POST['move']) && is_numeric($_POST['move'])) {

            $t_move = $_POST['move'];

            if (folder_is_valid($t_move) && ($t_move !== $thread_data['FID'])) {

                if ((session_check_perm(USER_PERM_FOLDER_MODERATE, $t_move) || (session_check_perm(USER_PERM_THREAD_MOVE, $t_move) && ($thread_data['BY_UID'] == $uid) && ($thread_data['ADMIN_LOCK'] != THREAD_ADMIN_LOCK_ENABLED) && forum_get_setting('allow_post_editing', 'Y') && ((intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $thread_data['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0) * MINUTE_IN_SECONDS)))))) && thread_change_folder($tid, $t_move)) {

                    $new_folder_title = folder_get_title($t_move);
                    $old_folder_title = folder_get_title($thread_data['FID']);

                    post_add_edit_text($tid, 1);

                    if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

                        admin_add_log_entry(MOVED_THREAD, array($tid, $thread_data['TITLE'], $old_folder_title, $new_folder_title));
                    }

                }else {

                    $error_msg_array[] = $lang['failedtomovethread'];
                    $valid = false;
                }
            }
        }
    }

    if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

        if (isset($_POST['closed']) && is_numeric($_POST['closed'])) {

            $t_closed = in_array($_POST['closed'], range(0, 1)) ? $_POST['closed'] : $thread_data['CLOSED'];

            if ($t_closed != $thread_data['CLOSED']) {

                if (thread_set_closed($tid, $t_closed > 0)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(($t_closed > 0) ? CLOSED_THREAD : OPENED_THREAD, array($tid, $thread_data['TITLE']));

                }else {

                    $error_msg_array[] = $lang['failedtoupdatethreadclosedstatus'];
                    $valid = false;
                }
            }
        }

        if (isset($_POST['admin_lock']) && is_numeric($_POST['admin_lock'])) {

            $t_admin_lock = in_array($_POST['admin_lock'], range(0, 1)) ? $_POST['admin_lock'] : $thread_data['ADMIN_LOCK'];

            if ($t_admin_lock != $thread_data['ADMIN_LOCK']) {

                if (thread_admin_lock($tid, $t_admin_lock > 0)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(($t_admin_lock > 0) ? LOCKED_THREAD : UNLOCKED_THREAD, array($tid, $thread_data['TITLE']));

                }else {

                    $error_msg_array[] = $lang['failedtoupdatethreadlockstatus'];
                    $valid = false;
                }
            }
        }

        if (isset($_POST['sticky']) && $_POST['sticky'] == "Y") {

            $t_sticky = $_POST['sticky'];

            if (isset($_POST['sticky_year']) && isset($_POST['sticky_month']) && isset($_POST['sticky_day'])) {

                $sticky_day   = trim(stripslashes_array($_POST['sticky_day']));
                $sticky_month = trim(stripslashes_array($_POST['sticky_month']));
                $sticky_year  = trim(stripslashes_array($_POST['sticky_year']));

                if (is_numeric($sticky_month) && $sticky_month > 0 && is_numeric($sticky_day) && $sticky_day > 0 && is_numeric($sticky_year) && $sticky_year > 0) {

                    if (@checkdate($sticky_month, $sticky_day, $sticky_year)) {

                        $t_sticky_until = mktime(0, 0, 0, $sticky_month, $sticky_day, $sticky_year);

                        if (($t_sticky != $thread_data['STICKY']) || ($t_sticky_until != $thread_data['STICKY_UNTIL'])) {

                            $thread_data['STICKY'] = $_POST['sticky'];
                            $thread_data['STICKY_UNTIL'] = $t_sticky_until;

                            if (thread_set_sticky($tid, true, $t_sticky_until)) {

                                post_add_edit_text($tid, 1);

                                admin_add_log_entry(CREATE_THREAD_STICKY, array($tid, $thread_data['TITLE']));

                            }else {

                                $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                                $valid = false;
                            }
                        }

                    }else {

                        $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                        $valid = false;
                    }

                }else {

                    if (thread_set_sticky($tid, true)) {

                        post_add_edit_text($tid, 1);

                        admin_add_log_entry(CREATE_THREAD_STICKY, array($tid, $thread_data['TITLE']));

                    }else {

                        $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                        $valid = false;
                    }
                }
            }

        }else if (isset($_POST['sticky']) && $_POST['sticky'] == "N") {

            $t_sticky = $_POST['sticky'];

            if ($t_sticky != $thread_data['STICKY']) {

                if (thread_set_sticky($tid, false)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(REMOVE_THREAD_STICKY, array($tid, $thread_data['TITLE']));

                }else {

                    $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                    $valid = false;
                }
            }
        }

        if (isset($_POST['thread_merge_split']) && is_numeric($_POST['thread_merge_split'])) {

            if ($_POST['thread_merge_split'] == THREAD_TYPE_MERGE) {

                if (isset($_POST['merge_thread']) && is_numeric($_POST['merge_thread'])) {

                    if (isset($_POST['merge_type']) && is_numeric($_POST['merge_type']) && isset($_POST['merge_thread_con']) && $_POST['merge_thread_con'] == "Y") {

                        $error_str = '';

                        $merge_thread = $_POST['merge_thread'];
                        $merge_type   = $_POST['merge_type'];

                        if (validate_msg($merge_thread)) {
                            list($merge_thread) = explode('.', $merge_thread);
                        }

                        if (($merge_result = thread_merge($tid, $merge_thread, $merge_type, $error_str))) {

                            post_add_edit_text($tid, 1);

                            admin_add_log_entry(THREAD_MERGE, $merge_result);

                        }else {

                            $error_msg_array[] = $error_str;
                            $valid = false;
                        }
                    }
                }

            }elseif ($_POST['thread_merge_split'] == THREAD_TYPE_SPLIT) {

                if (isset($_POST['split_thread']) && is_numeric($_POST['split_thread']) && $_POST['split_thread'] > 1) {

                    if (isset($_POST['split_type']) && is_numeric($_POST['split_type']) && isset($_POST['split_thread_con']) && $_POST['split_thread_con'] == "Y") {

                        $error_str = '';

                        $split_start = $_POST['split_thread'];
                        $split_type  = $_POST['split_type'];

                        if (($split_result = thread_split($tid, $split_start, $split_type, $error_str))) {

                            post_add_edit_text($tid, 1);

                            admin_add_log_entry(THREAD_SPLIT, $split_result);

                        }else {

                            $error_msg_array[] = $error_str;
                            $valid = false;
                        }
                    }
                }
            }
        }

        if (isset($_POST['t_to_uid_in_thread']) && is_numeric($_POST['t_to_uid_in_thread']) && isset($_POST['deluser_con']) && $_POST['deluser_con'] == "Y") {

            $del_user_uid = $_POST['t_to_uid_in_thread'];

            if (($user_logon = user_get_logon($del_user_uid))) {

                if (thread_delete_by_user($tid, $del_user_uid)) {

                    post_add_edit_text($tid, 1);
                    admin_add_log_entry(DELETE_USER_THREAD_POSTS, array($tid, $thread_data['TITLE'], $user_logon));

                }else {

                    $error_msg_array[] = sprintf($lang['failedtodeletepostsbyuser'], $user_logon);
                    $valid = false;
                }
            }
        }

        if (isset($_POST['delete_thread']) && in_array($_POST['delete_thread'], $thread_delete_valid_types)) {

            if (isset($_POST['delete_thread_confirm']) && $_POST['delete_thread_confirm'] == "Y") {

                $delete_thread = $_POST['delete_thread'];

                if (thread_delete($tid, $delete_thread)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(DELETE_THREAD, array($tid, $thread_data['TITLE']));

                    html_draw_top("title={$lang['deletethread']}", 'class=window_title');
                    html_display_msg($lang['deletethread'], $lang['threadwassuccessfullydeleted'], 'discussion.php', 'get', array('continue' => $lang['continue']), false, html_get_frame_name('main'), 'center');
                    html_draw_bottom();
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtodeletethread'];
                    $valid = false;
                }
            }
        }

        if (isset($_POST['undelete_thread']) && $_POST['undelete_thread'] == "Y") {

            if (isset($_POST['undelete_thread_confirm']) && $_POST['undelete_thread_confirm'] == "Y") {

                if (thread_undelete($tid)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(UNDELETE_THREAD, array($tid, $thread_data['TITLE']));

                    html_draw_top("title={$lang['undeletethread']}", 'class=window_title');
                    html_display_msg($lang['undeletethread'], $lang['threadwassuccessfullyundeleted'], 'thread_options.php', 'get', array('back' => $lang['back']), array('msg' => $msg), '_self', 'center');
                    html_draw_bottom();
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtoundeletethread'];
                    $valid = false;
                }
            }
        }
    }

    if ($valid) {

        header_redirect("thread_options.php?webtag=$webtag&msg=$msg&updated=true");
        exit;
    }
}

if ($thread_data['DELETED'] == 'N') {

    html_draw_top("title={$lang['threadoptions']} - {$thread_data['TITLE']}", "basetarget=_blank", 'search_popup.js', 'class=window_title');

    echo "<h1>{$lang['threadoptions']}<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" /><a href=\"messages.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\">", word_filter_add_ob_tags($thread_data['TITLE'], true), "</a></h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'center');

    }else if (isset($_GET['updated'])) {

        html_display_success_msg($lang['updatessavedsuccessfully'], '600', 'center');

    }else if (thread_is_poll($tid)) {

        html_display_warning_msg($lang['torenamethisthreadyoumusteditthepoll'], '600', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"thread_options.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("msg", htmlentities_array($msg)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                        <td align=\"left\" width=\"260\" class=\"posthead\">{$lang['markedasread']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array('markasread', range(0, $thread_data['LENGTH']), ($thread_data['LAST_READ'] > $thread_data['LENGTH'] ? $thread_data['LENGTH'] : $thread_data['LAST_READ'])), " {$lang['postsoutof']} {$thread_data['LENGTH']}</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" class=\"posthead\">{$lang['interest']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_IGNORED, $lang['ignore'], $thread_data['INTEREST'] == THREAD_IGNORED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_NOINTEREST, $lang['normal'], $thread_data['INTEREST'] == THREAD_NOINTEREST), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_INTERESTED, $lang['interested'], $thread_data['INTEREST'] == THREAD_INTERESTED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_SUBSCRIBED, $lang['subscribe'], $thread_data['INTEREST'] == THREAD_SUBSCRIBED), "</td>\n";
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

    if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid) || (($thread_data['BY_UID'] == $uid) && ($thread_data['ADMIN_LOCK'] != THREAD_ADMIN_LOCK_ENABLED) && forum_get_setting('allow_post_editing', 'Y') && ((intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $thread_data['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0) * MINUTE_IN_SECONDS)))))) {

        if (!thread_is_poll($tid)) {

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
            echo "                        <td align=\"left\" width=\"260\" class=\"posthead\">{$lang['renamethread']}:</td>\n";
            echo "                        <td align=\"left\">", form_input_text("rename", htmlentities_array($thread_data['TITLE']), 37, 64), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['movethread']}:</td>\n";
            echo "                        <td align=\"left\">", folder_draw_dropdown($thread_data['FID'], "move", "", FOLDER_ALLOW_NORMAL_THREAD, USER_PERM_THREAD_MOVE, "", "post_folder_dropdown"), "</td>\n";
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

        }else {

            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['move']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"260\" class=\"posthead\">{$lang['movethread']}:</td>\n";
            echo "                        <td align=\"left\">", folder_draw_dropdown($thread_data['FID'], "move", "", FOLDER_ALLOW_POLL_THREAD, USER_PERM_THREAD_MOVE, "", "post_folder_dropdown"), "</td>\n";
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

        if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

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
                echo "                        <td align=\"left\" width=\"260\">", form_input_hidden("thread_merge_split", 1), $lang['splitthreadatpost'], "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids), "</td>\n";
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
                echo "                        <td align=\"left\" width=\"260\">", form_input_hidden("thread_merge_split", 0), $lang['mergewiththreadid'], "</td>\n";
                echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search("merge_thread", "", 28, 15, SEARCH_THREAD, false, "", "merge_thread_id"), "</td>\n";
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

                $thread_available_pids = array('&nbsp;') + $thread_available_pids;

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
                echo "                        <td align=\"left\" width=\"260\">", form_radio("thread_merge_split", 0, $lang['mergewiththreadid'], false, false, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search('merge_thread', '', 37, false, SEARCH_THREAD, false, "", "merge_thread_id"), "</td>\n";
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
                echo "                        <td align=\"left\" width=\"260\">", form_radio("thread_merge_split", 1, $lang['splitthreadatpost'], false, false, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids), "</td>\n";
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
            echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['sticky']}:</td>\n";

            $sticky_year_min = date("Y");

            if ($thread_data['STICKY_UNTIL'] && $thread_data['STICKY'] == "Y") {

                $sticky_year  = date("Y", $thread_data['STICKY_UNTIL']);
                $sticky_month = date("n", $thread_data['STICKY_UNTIL']);
                $sticky_day   = date("j", $thread_data['STICKY_UNTIL']);

                if ( $sticky_year < $sticky_year_min ) {
                    $sticky_year_min = $sticky_year;
                }

            }else {

                $sticky_year  = 0;
                $sticky_month = 0;
                $sticky_day   = 0;
            }

            echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_radio("sticky", "Y", $lang['until'], $thread_data['STICKY'] == "Y"), "&nbsp;", form_date_dropdowns($sticky_year, $sticky_month, $sticky_day, "sticky_", $sticky_year_min), "&nbsp;<span class=\"small_optional_text\">{$lang['optionalbrackets']}</span></td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">", form_radio("sticky", "N", $lang['no'], $thread_data['STICKY'] == "N"), "</td>\n";
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
            echo "                          ", form_radio("closed", 1, $lang['yes'], $thread_data['CLOSED'] > 0), " \n";
            echo "                          ", form_radio("closed", 0, $lang['no'], $thread_data['CLOSED'] < 1), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['locktitleandfolder']}:</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("admin_lock", 1, $lang['yes'], $thread_data['ADMIN_LOCK'] > 0), " \n";
            echo "                          ", form_radio("admin_lock", 0, $lang['no'], $thread_data['ADMIN_LOCK'] < 1), "\n";
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
            echo "                        <td align=\"left\" class=\"posthead\" width=\"260\">{$lang['deletepostsinthreadbyuser']}:</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", post_draw_to_dropdown_in_thread($tid, 0, false, true, 'bhselect', 'style="width: 275px"'), "</td>\n";
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
            echo "                        <td align=\"left\" class=\"posthead\" width=\"260\">{$lang['deletethread']}:</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delete_thread", -1, $lang['no'], true), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delete_thread", 0, $lang['permenantlydelete'], false), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delete_thread", 1, $lang['movetodeleteditems'], false), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("delete_thread_confirm", "Y", $lang['confirm'], false), "</td>\n";
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
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else if (session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

    html_draw_top("title={$lang['threadoptions']} - {$thread_data['TITLE']}", "basetarget=_blank", 'class=window_title');

    echo "<h1>{$lang['threadoptions']}: <a href=\"messages.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\">#{$tid} ", word_filter_add_ob_tags($thread_data['TITLE'], true), "</a></h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'center');

    }else if (isset($_GET['updated'])) {

        html_display_success_msg($lang['updatessavedsuccessfully'], '600', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"thread_options.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("msg", htmlentities_array($msg)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
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
    echo "                        <td align=\"left\">", form_radio("undelete_thread", "Y", $lang['yes']), "&nbsp;", form_radio("undelete_thread", "N", $lang['no'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("undelete_thread_confirm", "Y", $lang['confirm'], false), " \n";
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
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannoteditpostsinthisfolder']);
    html_draw_bottom();
    exit;
}

?>
