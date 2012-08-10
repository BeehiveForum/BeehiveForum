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
require_once 'lboot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'light.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    light_html_guest_error();
}

// Check if the user is viewing signatures.
$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

// Array to hold error messages
$error_msg_array = array();

// Submit code.
if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        light_html_draw_bottom();
        exit;
    }

} else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
        light_html_draw_bottom();
        exit;
    }

} else {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("No message specified for deletion"));
    light_html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {

    $uri = "lmessages.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg={$_GET['msg']}";
    } else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
        $uri.= "&msg={$_POST['msg']}";
    }

    header_redirect($uri);
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("You cannot delete posts in this folder"));
    light_html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid)) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
    light_html_draw_bottom();
    exit;
}

if (($preview_message = messages_get($tid, $pid, 1))) {

    $preview_message['CONTENT'] = message_get_content($tid, $pid);

    if ((strlen(trim($preview_message['CONTENT'])) < 1) && !thread_is_poll($tid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_post_edit_refuse();
        light_html_draw_bottom();
        exit;
    }

    if ((session::get_value('UID') != $preview_message['FROM_UID'] || session::check_perm(USER_PERM_PILLORIED, 0)) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_post_edit_refuse();
        light_html_draw_bottom();
        exit;
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($preview_message['APPROVED']) && $preview_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
        light_post_edit_refuse();
        light_html_draw_bottom();
        exit;
    }

} else {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(sprintf(gettext("Message %s was not found"), $msg));
    light_html_draw_bottom();
    exit;
}

if (isset($_POST['delete'])) {

    if (post_delete($tid, $pid)) {

        post_add_edit_text($tid, $pid);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != session::get_value('UID')) {
            admin_add_log_entry(DELETE_POST, array($t_fid, $tid, $pid));
        }

        header_redirect("lmessages.php?webtag=$webtag&msg=$msg");
        exit;

    } else {

        $error_msg_array[] = gettext("Error deleting post");
    }
}

light_html_draw_top(sprintf('title=%s %s.%s', gettext("Delete Message"), $tid, $pid), "robots=noindex,nofollow");

echo "<h3>", gettext("Delete Message"), " {$tid}.{$pid}</h3>\n";

if ($preview_message['TO_UID'] == 0) {

    $preview_message['TLOGON'] = gettext("ALL");
    $preview_message['TNICK'] = gettext("ALL");

} else {

    $preview_tuser = user_get($preview_message['TO_UID']);
    $preview_message['TLOGON'] = $preview_tuser['LOGON'];
    $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
}

$preview_tuser = user_get($preview_message['FROM_UID']);

$preview_message['FLOGON'] = $preview_tuser['LOGON'];
$preview_message['FNICK'] = $preview_tuser['NICKNAME'];

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    light_html_display_error_array($error_msg_array);
}

echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"ldelete.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";

if (thread_is_poll($tid) && $pid == 1) {

    light_poll_display($tid, $thread_data['LENGTH'], $thread_data['FID'], false, $thread_data['CLOSED'], false, false);

} else {

    light_message_display($tid, $preview_message, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], false, false, true);
}

echo "<div class=\"post_buttons\">";
echo light_form_submit("delete", gettext("Delete"));
echo light_form_submit("cancel", gettext("Cancel"));
echo "</div>\n";
echo "</form>\n";

light_html_draw_bottom();

?>