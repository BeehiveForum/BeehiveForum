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
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';
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

    } else {

        html_draw_error(gettext("No message specified for editing"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

} else if (isset($_GET['msg'])) {

    if (validate_msg($_GET['msg'])) {

        $msg = $_GET['msg'];

    } else {

        html_draw_error(gettext("No message specified for editing"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }
}

if (isset($msg) && validate_msg($msg)) {

    $valid = true;

    list($tid, $pid) = explode('.', $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {
        html_draw_error(gettext("You cannot edit posts in this folder"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
        html_draw_error(gettext("You cannot edit posts in this folder"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!$thread_data = thread_get($tid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (($preview_message = messages_get($tid, $pid, 1)) !== false) {

        if (isset($preview_message['APPROVED']) && ($preview_message['APPROVED'] > 0)) {
            html_draw_error(gettext("Post does not require approval"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
        }

        $preview_message['CONTENT'] = message_get_content($tid, $pid);

        if (isset($_POST['approve']) && is_numeric($tid) && is_numeric($pid)) {

            if (post_approve($tid, $pid)) {

                admin_add_log_entry(APPROVED_POST, array($t_fid, $tid, $pid));

                if (preg_match("/^messages.php/u", basename($ret)) > 0) {

                    header_redirect("messages.php?webtag=$webtag&msg=$msg&post_approve_success=$msg");
                    exit;

                } else {

                    html_draw_top(sprintf('title=%s', gettext("Approve Post")), 'class=window_title');
                    html_display_msg(gettext("Approve Post"), sprintf(gettext("Successfully approved post %s"), $msg), "admin_post_approve.php", 'get', array('back' => gettext("Back")), array('ret' => $ret), '_self', 'center');
                    html_draw_bottom();
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

                    html_draw_top(sprintf('title=%s', gettext("Delete posts")), 'class=window_title');
                    html_display_msg(gettext("Delete posts"), sprintf(gettext("Successfully deleted post %s"), $msg), "admin_post_approve.php", 'get', array('back' => gettext("Back")), array('ret' => $ret), '_self', 'center');
                    html_draw_bottom();
                    exit;
                }

            } else {

                $error_msg_array[] = gettext("Error deleting post");
            }
        }

        html_draw_top(sprintf('title=%s', gettext("Admin - Approve Post")), 'class=window_title', "js/post.js", "resize_width=720");

        echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Approve Post"), "</h1>\n";

        $show_sigs = session::show_sigs();

        if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
            html_display_error_array($error_msg_array, '86%', 'left');
        }

        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"admin_post_approve.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
        echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";
        echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">", gettext("Approve Post"), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\"><br />\n";

        if (thread_is_poll($tid) && $pid == 1) {

            poll_display($tid, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], false, $show_sigs, true);

        } else {

            message_display($tid, $preview_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], false, false, $show_sigs, true);
        }

        echo "                  </td>\n";
        echo "                </tr>\n";
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
        echo "      <td align=\"center\">", form_submit("approve", gettext("Approve")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();

    } else {

        html_draw_error(gettext("That post does not exist in this thread!"), 'admin_post_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

} else {

    html_draw_top(sprintf('title=%s', gettext("Admin - Post Approval Queue")), 'class=window_title');

    $post_approval_array = admin_get_post_approval_queue($page);

    echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Post Approval Queue"), "</h1>\n";

    if (sizeof($post_approval_array['post_array']) < 1) {
        html_display_warning_msg(gettext("No posts are awaiting approval"), '86%', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"20\">&nbsp;</td>\n";
    echo "                   <td class=\"subhead\" align=\"left\">", gettext("Thread title"), "</td>\n";
    echo "                   <td class=\"subhead\" align=\"left\">", gettext("Folder"), "</td>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">", gettext("User"), "</td>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">", gettext("Date/Time"), "</td>\n";
    echo "                 </tr>\n";

    if (sizeof($post_approval_array['post_array']) > 0) {

        foreach ($post_approval_array['post_array'] as $post_approval_entry) {

            echo "                 <tr>\n";
            echo "                   <td align=\"left\" width=\"20\">&nbsp;</td>\n";
            echo "                   <td align=\"left\"><a href=\"admin_post_approve.php?webtag=$webtag&msg={$post_approval_entry['MSG']}\" target=\"_self\">", word_filter_add_ob_tags($post_approval_entry['TITLE'], true), "</a></td>\n";
            echo "                   <td align=\"left\">{$post_approval_entry['FOLDER_TITLE']}</td>\n";
            echo "                   <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$post_approval_entry['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($post_approval_entry['LOGON'], $post_approval_entry['NICKNAME']), true) . "</a></td>\n";
            echo "                   <td align=\"left\">", format_time($post_approval_entry['CREATED']), "</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", html_page_links("admin_post_approve.php?webtag=$webtag&ret=$ret", $page, $post_approval_array['post_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>