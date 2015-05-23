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
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

$error_msg_array = array();

$show_sigs = session::show_sigs();

$valid = true;

$tid = null;
$pid = null;
$t_fid = null;
$preview_message = null;

if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder_fid($tid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder_fid($tid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    html_draw_error(gettext("No message specified for deletion"));
}

if (isset($_POST['return_msg']) && validate_msg($_POST['return_msg'])) {
    $return_msg = $_POST['return_msg'];
} else if (isset($_GET['return_msg']) && validate_msg($_GET['return_msg'])) {
    $return_msg = $_GET['return_msg'];
} else {
    $return_msg = $msg;
}

if (isset($_POST['cancel'])) {

    header_redirect("discussion.php?webtag=$webtag&msg=$return_msg");
    exit;
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {
    html_draw_error(gettext("You cannot delete posts in this folder"));
}

if (!$thread_data = thread_get($tid)) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (isset($tid) && isset($pid) && is_numeric($tid) && is_numeric($pid)) {

    if (($preview_message = messages_get($tid, $pid, 1)) !== false) {

        $preview_message['CONTENT'] = message_get_content($tid, $pid);

        if ((strlen(trim($preview_message['CONTENT'])) < 1) && !thread_is_poll($tid)) {
            post_edit_refuse($tid, $pid);
        }

        if (($_SESSION['UID'] != $preview_message['FROM_UID'] || session::check_perm(USER_PERM_PILLORIED, 0)) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
            post_edit_refuse($tid, $pid);
        }

    } else {

        html_draw_error(gettext("That post does not exist in this thread!"));
    }
}

if (isset($_POST['delete']) && is_numeric($tid) && is_numeric($pid)) {

    if (post_delete($tid, $pid)) {

        post_add_edit_text($tid, $pid);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != $_SESSION['UID']) {
            admin_add_log_entry(DELETE_POST, array($t_fid, $tid, $pid));
        }

        header_redirect("discussion.php?webtag=$webtag&msg=$return_msg&delete_success=$msg");
        exit;

    } else {

        $error_msg_array[] = gettext("Error deleting post");
    }
}

html_draw_top(
    array(
        'title' => gettext('Delete Message'),
        'js' => array(
            'js/post.js'
        ),
        'base_target' => '_blank',
        'class' => 'window_title max_width'
    )
);

echo "<h1>", sprintf(gettext("Delete Message - %s"), $msg), "</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"delete.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";
echo "  ", form_input_hidden('return_msg', htmlentities_array($return_msg)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("Delete Message"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\"><br />";

if (thread_is_poll($tid) && $pid == 1) {

    poll_display($tid, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], $show_sigs, true);

} else {

    message_display($tid, $preview_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, false, false, $show_sigs, true);
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
echo "      <td align=\"center\">", form_submit("delete", gettext("Delete")), "&nbsp;" . form_submit("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();