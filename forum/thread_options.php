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
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check that required variables are set
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode(".", $_GET['msg']);

} else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];
    list($tid, $pid) = explode(".", $_POST['msg']);

} else {

    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (isset($_POST['return_msg']) && validate_msg($_POST['return_msg'])) {
    $return_msg = $_POST['return_msg'];
} else if (isset($_GET['return_msg']) && validate_msg($_GET['return_msg'])) {
    $return_msg = $_GET['return_msg'];
} else {
    $return_msg = $msg;
}

if (!$folder_data = thread_get_folder($tid)) {
    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

$perm_folder_moderate = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID']);

if (!$thread_data = thread_get($tid, $perm_folder_moderate, false, $perm_folder_moderate)) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

// Array to hold error messages
$error_msg_array = array();

// Array of valid thread deletion types
$thread_delete_valid_types = array(
    THREAD_DELETE_PERMENANT,
    THREAD_DELETE_NON_PERMENANT
);

// Back button clicked.
if (isset($_POST['back'])) {

    header_redirect("messages.php?webtag=$webtag&msg=$return_msg");
    exit;
}

// Code for handling functionality from messages.php
if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {

    if (in_range($_GET['markasread'], 0, $thread_data['LENGTH'])) {

        $mark_as_read = $_GET['markasread'];

        if (messages_set_read($tid, $mark_as_read, $thread_data['MODIFIED'])) {

            header_redirect("messages.php?webtag=$webtag&msg=$return_msg&markasread=1");
            exit;
        }
    }

    header_redirect("messages.php?webtag=$webtag&msg=$return_msg&markasread=0");
    exit;

} else if (isset($_POST['setinterest']) && is_numeric($_POST['setinterest'])) {

    $thread_interest = $_POST['setinterest'];

    if (thread_set_interest($tid, $thread_interest)) {

        header_redirect("messages.php?webtag=$webtag&msg=$return_msg&setinterest=1");
        exit;
    }

    header_redirect("messages.php?webtag=$webtag&msg=$return_msg&setinterest=0");
    exit;
}

// Submit Code
if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['markasread']) && is_numeric($_POST['markasread'])) {

        if (in_range($_POST['markasread'], 0, $thread_data['LENGTH'])) {

            $thread_data['LAST_READ'] = $_POST['markasread'];

            if (!messages_set_read($tid, $thread_data['LAST_READ'], $thread_data['MODIFIED'])) {

                $error_msg_array[] = gettext("Failed to update thread read status");
                $valid = false;
            }

        } else {

            $error_msg_array[] = gettext("Failed to update thread read status");
            $valid = false;
        }
    }

    if (isset($_POST['interest']) && is_numeric($_POST['interest'])) {

        $thread_data['INTEREST'] = $_POST['interest'];

        if (!thread_set_interest($tid, $thread_data['INTEREST'])) {

            $error_msg_array[] = gettext("Failed to update thread interest");
            $valid = false;
        }
    }

    // Admin Options
    if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID']) || (($thread_data['BY_UID'] == $_SESSION['UID']) && ($thread_data['ADMIN_LOCK'] != THREAD_ADMIN_LOCK_ENABLED) && forum_get_setting('allow_post_editing', 'Y') && ((intval(forum_get_setting('post_edit_time', 'is_numeric', 0)) == 0) || ((time() - $thread_data['CREATED']) < (intval(forum_get_setting('post_edit_time', 'is_numeric', 0) * MINUTE_IN_SECONDS)))))) {

        if (isset($_POST['rename']) && strlen(trim($_POST['rename'])) > 0) {

            $t_rename = trim($_POST['rename']);

            if ($t_rename !== trim($thread_data['TITLE'])) {

                if (thread_change_title($tid, $t_rename)) {

                    post_add_edit_text($tid, 1);

                    if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID'])) {

                        admin_add_log_entry(RENAME_THREAD, array($tid, $thread_data['TITLE'], $t_rename));
                    }

                } else {

                    $error_msg_array[] = gettext("Failed to rename thread");
                    $valid = false;
                }
            }
        }

        if (isset($_POST['move']) && is_numeric($_POST['move'])) {

            $t_move = $_POST['move'];

            if (folder_is_valid($t_move) && ($t_move !== $thread_data['FID'])) {

                if ((session::check_perm(USER_PERM_FOLDER_MODERATE, $t_move) || (session::check_perm(USER_PERM_THREAD_MOVE, $t_move) && ($thread_data['BY_UID'] == $_SESSION['UID']) && ($thread_data['ADMIN_LOCK'] != THREAD_ADMIN_LOCK_ENABLED) && forum_get_setting('allow_post_editing', 'Y') && ((intval(forum_get_setting('post_edit_time', 'is_numeric', 0)) == 0) || ((time() - $thread_data['CREATED']) < (intval(forum_get_setting('post_edit_time', 'is_numeric', 0) * MINUTE_IN_SECONDS)))))) && thread_change_folder($tid, $t_move)) {

                    $new_folder_title = folder_get_title($t_move);
                    $old_folder_title = folder_get_title($thread_data['FID']);

                    post_add_edit_text($tid, 1);

                    if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID'])) {

                        admin_add_log_entry(MOVED_THREAD, array($tid, $thread_data['TITLE'], $old_folder_title, $new_folder_title));
                    }

                } else {

                    $error_msg_array[] = gettext("Failed to move thread to specified folder");
                    $valid = false;
                }
            }
        }
    }

    if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID'])) {

        if (isset($_POST['closed']) && is_numeric($_POST['closed'])) {

            $t_closed = in_array($_POST['closed'], range(0, 1)) ? $_POST['closed'] : $thread_data['CLOSED'];

            if ($t_closed != $thread_data['CLOSED']) {

                if (thread_set_closed($tid, $t_closed > 0)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(($t_closed > 0) ? CLOSED_THREAD : OPENED_THREAD, array($tid, $thread_data['TITLE']));

                } else {

                    $error_msg_array[] = gettext("Failed to update thread closed status");
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

                } else {

                    $error_msg_array[] = gettext("Failed to update thread lock status");
                    $valid = false;
                }
            }
        }

        if (isset($_POST['sticky']) && $_POST['sticky'] == "Y") {

            $t_sticky = $_POST['sticky'];

            if (isset($_POST['sticky_year']) && isset($_POST['sticky_month']) && isset($_POST['sticky_day'])) {

                $sticky_day = trim($_POST['sticky_day']);
                $sticky_month = trim($_POST['sticky_month']);
                $sticky_year = trim($_POST['sticky_year']);

                if (is_numeric($sticky_month) && $sticky_month > 0 && is_numeric($sticky_day) && $sticky_day > 0 && is_numeric($sticky_year) && $sticky_year > 0) {

                    if (@checkdate($sticky_month, $sticky_day, $sticky_year)) {

                        $t_sticky_until = mktime(0, 0, 0, $sticky_month, $sticky_day, $sticky_year);

                        if (($t_sticky != $thread_data['STICKY']) || ($t_sticky_until != $thread_data['STICKY_UNTIL'])) {

                            $thread_data['STICKY'] = $_POST['sticky'];
                            $thread_data['STICKY_UNTIL'] = $t_sticky_until;

                            if (thread_set_sticky($tid, true, $t_sticky_until)) {

                                post_add_edit_text($tid, 1);

                                admin_add_log_entry(CREATE_THREAD_STICKY, array($tid, $thread_data['TITLE']));

                            } else {

                                $error_msg_array[] = gettext("Failed to update thread sticky status");
                                $valid = false;
                            }
                        }

                    } else {

                        $error_msg_array[] = gettext("Failed to update thread sticky status");
                        $valid = false;
                    }

                } else {

                    if (thread_set_sticky($tid, true)) {

                        post_add_edit_text($tid, 1);

                        admin_add_log_entry(CREATE_THREAD_STICKY, array($tid, $thread_data['TITLE']));

                    } else {

                        $error_msg_array[] = gettext("Failed to update thread sticky status");
                        $valid = false;
                    }
                }
            }

        } else if (isset($_POST['sticky']) && $_POST['sticky'] == "N") {

            $t_sticky = $_POST['sticky'];

            if ($t_sticky != $thread_data['STICKY']) {

                if (thread_set_sticky($tid, false)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(REMOVE_THREAD_STICKY, array($tid, $thread_data['TITLE']));

                } else {

                    $error_msg_array[] = gettext("Failed to update thread sticky status");
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
                        $merge_type = $_POST['merge_type'];

                        if (validate_msg($merge_thread)) {
                            list($merge_thread) = explode('.', $merge_thread);
                        }

                        if (($merge_result = thread_merge($tid, $merge_thread, $merge_type, $error_str)) !== false) {

                            post_add_edit_text($tid, 1);

                            admin_add_log_entry(THREAD_MERGE, $merge_result);

                        } else {

                            $error_msg_array[] = $error_str;
                            $valid = false;
                        }
                    }
                }

            } else if ($_POST['thread_merge_split'] == THREAD_TYPE_SPLIT) {

                if (isset($_POST['split_thread']) && is_numeric($_POST['split_thread']) && $_POST['split_thread'] > 1) {

                    if (isset($_POST['split_type']) && is_numeric($_POST['split_type']) && isset($_POST['split_thread_con']) && $_POST['split_thread_con'] == "Y") {

                        $error_str = '';

                        $split_start = $_POST['split_thread'];
                        $split_type = $_POST['split_type'];

                        if (($split_result = thread_split($tid, $split_start, $split_type, $error_str)) !== false) {

                            post_add_edit_text($tid, 1);

                            admin_add_log_entry(THREAD_SPLIT, $split_result);

                        } else {

                            $error_msg_array[] = $error_str;
                            $valid = false;
                        }
                    }
                }
            }
        }

        if (isset($_POST['t_to_uid_in_thread']) && is_numeric($_POST['t_to_uid_in_thread']) && isset($_POST['deluser_con']) && $_POST['deluser_con'] == "Y") {

            $del_user_uid = $_POST['t_to_uid_in_thread'];

            if (($user_logon = user_get_logon($del_user_uid)) !== false) {

                if (thread_delete_by_user($tid, $del_user_uid)) {

                    post_add_edit_text($tid, 1);
                    admin_add_log_entry(DELETE_USER_THREAD_POSTS, array($tid, $thread_data['TITLE'], $user_logon));

                } else {

                    $error_msg_array[] = sprintf(gettext("Failed to delete posts by selected user"), $user_logon);
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

                    html_draw_top(
                        array(
                            'title' => gettext("Delete Thread"),
                            'class' => 'window_title'
                        )
                    );
                    html_display_msg(gettext("Delete Thread"), gettext("Thread was successfully deleted"), 'discussion.php', 'get', array('continue' => gettext("Continue")), array(), html_get_frame_name('main'), 'center');
                    html_draw_bottom();
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to delete thread.");
                    $valid = false;
                }
            }
        }

        if (isset($_POST['undelete_thread']) && $_POST['undelete_thread'] == "Y") {

            if (isset($_POST['undelete_thread_confirm']) && $_POST['undelete_thread_confirm'] == "Y") {

                if (thread_undelete($tid)) {

                    post_add_edit_text($tid, 1);

                    admin_add_log_entry(UNDELETE_THREAD, array($tid, $thread_data['TITLE']));

                    html_draw_top(
                        array(
                            'title' => gettext("Undelete Thread"),
                            'class' => 'window_title'
                        )
                    );
                    html_display_msg(gettext("Undelete Thread"), gettext("Thread was successfully undeleted"), 'thread_options.php', 'get', array('back' => gettext("Back")), array('msg' => $msg), '_self', 'center');
                    html_draw_bottom();
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to un-delete thread");
                    $valid = false;
                }
            }
        }
    }

    if ($valid) {

        header_redirect("thread_options.php?webtag=$webtag&msg=$msg&return_msg=$return_msg&updated=true");
        exit;
    }
}

if ($thread_data['DELETED'] == 'N') {

    html_draw_top(
        array(
            'title' => sprintf(
                gettext('Thread Options - %s'),
                $thread_data['TITLE']
            ),
            'base_target' => '_blank',
            'js' => array(
                'js/search_popup.js'
            ),
            'class' => 'window_title'
        )
    );

    echo "<h1>", gettext("Thread Options"), html_style_image('separator'), "<a href=\"messages.php?webtag=$webtag&amp;msg=$return_msg\" target=\"_self\">", word_filter_add_ob_tags($thread_data['TITLE'], true), "</a></h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'center');

    } else if (isset($_GET['updated'])) {

        html_display_success_msg(gettext("Updates saved successfully"), '600', 'center');

    } else if (thread_is_poll($tid)) {

        html_display_warning_msg(gettext("To rename this thread you must edit the poll."), '600', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"thread_options.php\" method=\"post\" target=\"_self\">\n";
    echo "    ", form_csrf_token_field(), "\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("User Options"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"260\" class=\"posthead\">", gettext("Marked as read"), ":</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array('markasread', range(0, $thread_data['LENGTH']), ($thread_data['LAST_READ'] > $thread_data['LENGTH'] ? $thread_data['LENGTH'] : $thread_data['LAST_READ'])), " ", gettext("posts out of"), " {$thread_data['LENGTH']}</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" class=\"posthead\">", gettext("Interest"), ":</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_IGNORED, gettext("Ignore"), $thread_data['INTEREST'] == THREAD_IGNORED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_NOINTEREST, gettext("Normal"), $thread_data['INTEREST'] == THREAD_NOINTEREST), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_INTERESTED, gettext("Interested"), $thread_data['INTEREST'] == THREAD_INTERESTED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_SUBSCRIBED, gettext("Subscribe"), $thread_data['INTEREST'] == THREAD_SUBSCRIBED), "</td>\n";
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

    if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID']) || (($thread_data['BY_UID'] == $_SESSION['UID']) && ($thread_data['ADMIN_LOCK'] != THREAD_ADMIN_LOCK_ENABLED) && forum_get_setting('allow_post_editing', 'Y') && ((intval(forum_get_setting('post_edit_time', 'is_numeric', 0)) == 0) || ((time() - $thread_data['CREATED']) < (intval(forum_get_setting('post_edit_time', 'is_numeric', 0) * MINUTE_IN_SECONDS)))))) {

        if (!thread_is_poll($tid)) {

            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Rename"), " / ", gettext("Move"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"260\" class=\"posthead\">", gettext("Rename thread"), ":</td>\n";
            echo "                        <td align=\"left\">", form_input_text("rename", htmlentities_array($thread_data['TITLE']), 37, 64), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", gettext("Move thread"), ":</td>\n";
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

        } else {

            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Move"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"260\" class=\"posthead\">", gettext("Move thread"), ":</td>\n";
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

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID'])) {

            $thread_available_pids = thread_get_unmoved_posts($tid);

            if (thread_is_poll($tid) && $thread_available_pids) {

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Merge / Split Thread"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"260\">", form_input_hidden("thread_merge_split", THREAD_TYPE_SPLIT), gettext("Split thread at post:"), "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", THREAD_SPLIT_REPLIES, gettext("Selected post and replies only")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", THREAD_SPLIT_FOLLOWING, gettext("Selected and all following posts")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("split_thread_con", "Y", gettext("Confirm")), "</td>\n";
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

            } else if (!thread_is_poll($tid) && !$thread_available_pids) {

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Merge / Split Thread"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"260\">", form_input_hidden("thread_merge_split", THREAD_TYPE_MERGE), gettext("Merge with thread ID:"), "</td>\n";
                echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search("merge_thread", null, 28, 15, SEARCH_THREAD, false, null, "merge_thread_id"), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", THREAD_MERGE_START, gettext("Posts in this thread at start")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", THREAD_MERGE_END, gettext("Posts in this thread at end")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", THREAD_MERGE_BY_CREATED, gettext("Re-order posts into date order")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("merge_thread_con", "Y", gettext("Confirm")), "</td>\n";
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

            } else if (!thread_is_poll($tid) && $thread_available_pids) {

                $thread_available_pids = array('&nbsp;') + $thread_available_pids;

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Merge / Split Thread"), "</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"260\">", form_radio("thread_merge_split", THREAD_TYPE_MERGE, gettext("Merge with thread ID:"), false, null, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_input_text_search('merge_thread', null, 37, false, SEARCH_THREAD, false, null, "merge_thread_id"), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", THREAD_MERGE_START, gettext("Posts in this thread at start")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", THREAD_MERGE_START, gettext("Posts in this thread at end")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", THREAD_MERGE_BY_CREATED, gettext("Re-order posts into date order")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("merge_thread_con", "Y", gettext("Confirm")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"260\">", form_radio("thread_merge_split", THREAD_TYPE_SPLIT, gettext("Split thread at post:"), false, null, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", THREAD_SPLIT_REPLIES, gettext("Selected post and replies only")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", THREAD_SPLIT_FOLLOWING, gettext("Selected and all following posts")), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("split_thread_con", "Y", gettext("Confirm")), "</td>\n";
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
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Make Thread Sticky"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">", gettext("Sticky"), ":</td>\n";

            $sticky_year_min = strftime('%Y');

            if ($thread_data['STICKY_UNTIL'] && $thread_data['STICKY'] == "Y") {

                $sticky_year = strftime('%Y', $thread_data['STICKY_UNTIL']);
                $sticky_month = strftime('%b', $thread_data['STICKY_UNTIL']);
                $sticky_day = strftime('%d', $thread_data['STICKY_UNTIL']);

                if ($sticky_year < $sticky_year_min) {
                    $sticky_year_min = $sticky_year;
                }

            } else {

                $sticky_year = 0;
                $sticky_month = 0;
                $sticky_day = 0;
            }

            echo "                        <td align=\"left\" style=\"white-space: nowrap\">", form_radio("sticky", "Y", gettext("Until 00:00 UTC"), $thread_data['STICKY'] == "Y"), "&nbsp;", form_date_dropdowns($sticky_year, $sticky_month, $sticky_day, "sticky_", $sticky_year_min), "&nbsp;<span class=\"small_optional_text\">", gettext("(Optional)"), "</span></td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">", form_radio("sticky", "N", gettext("No"), $thread_data['STICKY'] == "N"), "</td>\n";
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
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Locked"), " / ", gettext("Closed"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", gettext("Closed for posting"), ":</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("closed", THREAD_CLOSED, gettext("Yes"), $thread_data['CLOSED'] > 0), " \n";
            echo "                          ", form_radio("closed", THREAD_OPEN, gettext("No"), $thread_data['CLOSED'] < 1), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", gettext("Lock title and folder"), ":</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("admin_lock", THREAD_ADMIN_LOCK_ENABLED, gettext("Yes"), $thread_data['ADMIN_LOCK'] > 0), " \n";
            echo "                          ", form_radio("admin_lock", THREAD_ADMIN_LOCK_DISABLED, gettext("No"), $thread_data['ADMIN_LOCK'] < 1), "\n";
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
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Delete posts"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\" width=\"260\">", gettext("Delete posts in thread by user"), ":</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", post_draw_to_dropdown_in_thread($tid, 0, false, true, 'bhselect', 'style="width: 275px"'), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("deluser_con", "Y", gettext("Confirm")), "</td>\n";
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
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Delete Thread"), "</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\" width=\"260\">", gettext("Delete Thread"), ":</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delete_thread", -1, gettext("No"), true), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delete_thread", THREAD_DELETE_PERMENANT, gettext("Permanently Delete")), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delete_thread", THREAD_DELETE_NON_PERMENANT, gettext("Move to Deleted Threads")), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("delete_thread_confirm", "Y", gettext("Confirm")), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_submit("back", gettext("Back")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else if (session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID'])) {

    html_draw_top(
        array(
            'title' => sprintf(
                gettext("Thread Options - %s"),
                $thread_data['TITLE']
            ),
            'base_target' => '_blank',
            'class' => 'window_title'
        )
    );

    echo "<h1>", gettext("Thread Options"), ": <a href=\"messages.php?webtag=$webtag&amp;msg=$return_msg\" target=\"_self\">#{$tid} ", word_filter_add_ob_tags($thread_data['TITLE'], true), "</a></h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', 'center');

    } else if (isset($_GET['updated'])) {

        html_display_success_msg(gettext("Updates saved successfully"), '600', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"thread_options.php\" method=\"post\" target=\"_self\">\n";
    echo "    ", form_csrf_token_field(), "\n";
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Undelete Thread"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", gettext("Undelete Thread"), "</td>\n";
    echo "                        <td align=\"left\">", form_radio("undelete_thread", "Y", gettext("Yes")), "&nbsp;", form_radio("undelete_thread", "N", gettext("No"), true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("undelete_thread_confirm", "Y", gettext("Confirm")), " \n";
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
    echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

} else {

    html_draw_error(gettext("You cannot edit posts in this folder"));
}