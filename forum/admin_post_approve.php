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
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have Admin / Moderator access
if ((!session::check_perm(USER_PERM_ADMIN_TOOLS, 0) && !session::check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !session::get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Array to hold error messages
$error_msg_array = array();

$show_sigs = session::show_sigs();

// Page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else {
    $page = 1;
}

// Are we returning somewhere?
if (isset($_GET['ret']) && strlen(trim($_GET['ret'])) > 0) {
    $ret = href_cleanup_query_keys($_GET['ret']);
} else if (isset($_POST['ret']) && strlen(trim($_POST['ret'])) > 0) {
    $ret = href_cleanup_query_keys($_POST['ret']);
} else {
    $ret = "admin_post_approve.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = array(
        'admin_post_approve.php',
        'messages.php'
    );

    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (!preg_match("/^$available_files_preg/u", $ret)) {
        $ret = "admin_post_approve.php?webtag=$webtag";
    }
}

if (isset($_POST['cancel'])) {
    header_redirect($ret);
}

// Check POST and GET for message ID and check it is valid.
if (isset($_POST['msg'])) {

    if (validate_msg($_POST['msg'])) {

        $msg = $_POST['msg'];

        list($tid, $pid) = explode('.', $msg);

    } else {

        html_draw_error(gettext("No message specified for editing"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

} else if (isset($_GET['msg'])) {

    if (validate_msg($_GET['msg'])) {

        $msg = $_GET['msg'];

        list($tid, $pid) = explode('.', $msg);

    } else {

        html_draw_error(gettext("No message specified for editing"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }
}

if (isset($tid) && is_numeric($tid) && isset($pid) && is_numeric($pid)) {

    if (!$t_fid = thread_get_folder_fid($tid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {
        html_draw_error(gettext("You cannot edit posts in this folder"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        html_draw_error(gettext("You cannot edit posts in this folder"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!$thread_data = thread_get($tid, false, false, true)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!($preview_message = messages_get($tid, $pid, 1))) {
        html_draw_error(gettext("That post does not exist in this thread!"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (isset($preview_message['APPROVED'])) {
        html_draw_error(gettext("Post does not require approval"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (isset($_POST['approve']) && is_numeric($tid) && is_numeric($pid)) {

        if (post_approve($tid, $pid)) {

            admin_add_log_entry(APPROVED_POST, array($t_fid, $tid, $pid));

            if (preg_match("/^messages.php/u", basename($ret)) > 0) {

                header_redirect("messages.php?webtag=$webtag&msg=$msg&post_approve_success=$msg");
                exit;

            } else {

                header_redirect("admin_post_approve.php?webtag=$webtag&post_approve_success=$msg");
                exit;
            }

        } else {

            $error_msg_array[] = gettext("Post approval failed.");
        }

    } else if (isset($_POST['delete'])) {

        if (post_delete($tid, $pid)) {

            post_add_edit_text($tid, $pid);

            if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != $_SESSION['UID']) {
                admin_add_log_entry(DELETE_POST, array($t_fid, $tid, $pid));
            }

            if (preg_match("/^messages.php/", basename($ret)) > 0) {

                header_redirect("messages.php?webtag=$webtag&msg=$msg&delete_success=$msg");
                exit;

            } else {

                header_redirect("admin_post_approve.php?webtag=$webtag&delete_success=$msg");
                exit;
            }

        } else {

            $error_msg_array[] = gettext("Error deleting post");
        }
    }
}

if (isset($_POST['approve_messages'])) {

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'validate_msg');
    } else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (isset($_POST['approve_confirm']) && $_POST['approve_confirm'] == 'Y') {

            $valid = true;

            foreach ($process_messages as $process_message) {

                $approve_fid = null;

                $process_valid = true;

                list($approve_tid, $approve_pid) = explode(".", $process_message);

                if ($process_valid && !$approve_fid = thread_get_folder_fid($approve_tid)) {
                    $process_valid = false;
                }

                if ($process_valid && !session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $approve_fid)) {
                    $process_valid = false;
                }

                if ($process_valid && !session::check_perm(USER_PERM_FOLDER_MODERATE, $approve_fid)) {
                    $process_valid = false;
                }

                if ($process_valid && !$thread_data = thread_get($approve_tid, false, false, true)) {
                    $process_valid = false;
                }

                if ($process_valid && !($preview_message = messages_get($approve_tid, $approve_pid, 1))) {
                    $process_valid = false;
                }

                if ($process_valid && isset($preview_message['APPROVED'])) {
                    $process_valid = false;
                }

                if ($process_valid && post_approve($approve_tid, $approve_pid)) {
                    admin_add_log_entry(APPROVED_POST, array($approve_fid, $approve_tid, $approve_pid));
                } else {
                    $valid = false;
                }
            }

            if ($valid) {

                header_redirect("admin_post_approve.php?webtag=$webtag&page=$page&approve_success=true");
                exit;

            } else {

                $error_msg_array[] = gettext("Failed to approve some messages");
            }

        } else {

            html_draw_top(
                array(
                    'title' => gettext('Approve Message'),
                    'class' => 'window_title'
                )
            );

            html_display_msg(gettext("Approve"), gettext("Are you sure you want to approve all of the selected messages?"), "admin_post_approve.php", 'post', array(
                'approve_messages' => gettext("Yes"),
                'back' => gettext("No")
            ), array(
                'page' => $page,
                'process' => $process_messages,
                'approve_confirm' => 'Y'
            ), '_self', 'center');

            html_draw_bottom();
            exit;
        }

    } else {

        $error_msg_array[] = gettext("You must select some messages to approve");
    }

} else if (isset($_POST['delete_messages'])) {

    $valid = true;

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_messages = array_filter($_POST['process'], 'validate_msg');
    } else {
        $process_messages = array();
    }

    if (sizeof($process_messages) > 0) {

        if (isset($_POST['delete_confirm']) && $_POST['delete_confirm'] == 'Y') {

            foreach ($process_messages as $process_message) {

                $delete_fid = null;

                $process_valid = true;

                list($delete_tid, $delete_pid) = explode(".", $process_message);

                if ($process_valid && !$delete_fid = thread_get_folder_fid($delete_tid)) {
                    $process_valid = false;
                }

                if ($process_valid && !session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $delete_fid)) {
                    $process_valid = false;
                }

                if ($process_valid && !session::check_perm(USER_PERM_FOLDER_MODERATE, $delete_fid)) {
                    $process_valid = false;
                }

                if ($process_valid && !$thread_data = thread_get($delete_tid, false, false, true)) {
                    $process_valid = false;
                }

                if ($process_valid && !($preview_message = messages_get($delete_tid, $delete_pid, 1))) {
                    $process_valid = false;
                }

                if ($process_valid && isset($preview_message['APPROVED'])) {
                    $process_valid = false;
                }

                if ($process_valid && post_delete($delete_tid, $delete_pid)) {

                    post_add_edit_text($delete_tid, $delete_pid);

                    if (session::check_perm(USER_PERM_FOLDER_MODERATE, $delete_fid) && (!isset($preview_message['FROM_UID']) || $preview_message['FROM_UID'] != $_SESSION['UID'])) {
                        admin_add_log_entry(DELETE_POST, array($delete_fid, $delete_tid, $delete_pid));
                    }

                } else {

                    $valid = false;
                }
            }

            if ($valid) {

                header_redirect("admin_post_approve.php?webtag=$webtag&page=$page&delete_success=true");
                exit;

            } else {

                $error_msg_array[] = gettext("Failed to delete some messages");
            }

        } else {

            html_draw_top(
                array(
                    'title' => gettext('Delete Message'),
                    'class' => 'window_title'
                )
            );

            html_display_msg(gettext("Delete"), gettext("Are you sure you want to delete all of the selected messages?"), "admin_post_approve.php", 'post', array(
                'delete_messages' => gettext("Yes"),
                'back' => gettext("No")
            ), array(
                'page' => $page,
                'process' => $process_messages,
                'delete_confirm' => 'Y'
            ), '_self', 'center');

            html_draw_bottom();
            exit;
        }

    } else {

        $error_msg_array[] = gettext("You must select some messages to delete");
        $valid = false;
    }
}

html_draw_top(
    array(
        'title' => gettext('Admin - Post Approval Queue'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

$post_approval_array = admin_get_post_approval_queue($page);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Post Approval Queue"), "</h1>\n";

if (isset($_GET['post_approve_success']) && validate_msg($_GET['post_approve_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully approved post %s"), $_GET['post_approve_success']), '86%', 'center');

} else if (isset($_GET['delete_success']) && validate_msg($_GET['delete_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully deleted post %s"), $_GET['delete_success']), '86%', 'center');

} else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

} else if (sizeof($post_approval_array['post_array']) < 1) {

    html_display_warning_msg(gettext("No posts are awaiting approval"), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"admin_post_approve.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" colspan=\"3\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";

if (isset($post_approval_array['post_array']) && sizeof($post_approval_array['post_array']) > 0) {
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"20\">", form_checkbox("toggle_all", "toggle_all"), "</td>\n";
} else {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
}

echo "                   <td class=\"subhead\" align=\"left\">", gettext("Thread title"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\">", gettext("Folder"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">", gettext("User"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">", gettext("Date/Time"), "</td>\n";
echo "                 </tr>\n";

if (sizeof($post_approval_array['post_array']) > 0) {

    foreach ($post_approval_array['post_array'] as $post_approval_entry) {

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" width=\"20\">", form_checkbox("process[]", $post_approval_entry['MSG']), "</td>\n";
        echo "                   <td align=\"left\"><a href=\"admin_post_approve.php?webtag=$webtag&msg={$post_approval_entry['MSG']}\" target=\"_self\">", word_filter_add_ob_tags($post_approval_entry['TITLE'], true), "</a></td>\n";
        echo "                   <td align=\"left\">{$post_approval_entry['FOLDER_TITLE']}</td>\n";
        echo "                   <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$post_approval_entry['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($post_approval_entry['LOGON'], $post_approval_entry['NICKNAME']), true) . "</a></td>\n";
        echo "                   <td align=\"left\">", format_date_time($post_approval_entry['CREATED']), "</td>\n";
        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "       </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" width=\"33%\">&nbsp;</td>\n";
echo "      <td class=\"postbody\" align=\"center\" width=\"33%\">";

html_page_links("admin_post_approve.php?webtag=$webtag&ret=$ret", $page, $post_approval_array['post_count'], 10);

echo "      </td>\n";

if (isset($post_approval_array['post_array']) && sizeof($post_approval_array['post_array']) > 0) {

    echo "<td align=\"right\" width=\"33%\" valign=\"top\" style=\"white-space: nowrap\">";
    echo form_submit('approve_messages', gettext("Approve"), sprintf('title="%s"', gettext("Approve Selected Messages"))), "&nbsp;";
    echo form_submit('delete_messages', gettext("Delete"), sprintf('title="%s"', gettext("Delete Selected Messages"))), "&nbsp;";
    echo "</span></td>\n";

} else {

    echo "      <td align=\"left\">&nbsp;</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

if (isset($tid, $pid, $preview_message, $thread_data)) {

    $preview_message['CONTENT'] = message_get_content($tid, $pid);

    echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"admin_post_approve.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";
    echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";

    if (thread_is_poll($tid) && $pid == 1) {

        poll_display($tid, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], $show_sigs, true);

    } else {

        message_display($tid, $preview_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], false, $show_sigs, true);
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("approve", gettext("Approve")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

echo "</div>\n";

html_draw_bottom();