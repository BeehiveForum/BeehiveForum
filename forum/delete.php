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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

if(isset($HTTP_POST_VARS['cancel'])) {

    $uri = "./discussion.php?msg=". $HTTP_POST_VARS['t_back'];
    header_redirect($uri);

}

require_once("./include/html.inc.php");

if(bh_session_get_value('UID') == 0) {
        html_guest_error();
        exit;
}

require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/format.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/edit.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/admin.inc.php");

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if(isset($HTTP_POST_VARS['submit'])) {

    $delete_msg = $HTTP_POST_VARS['t_msg'];
    list($tid, $pid) = explode(".", $delete_msg);

}else {

    if(isset($HTTP_GET_VARS['msg'])) {

        $delete_msg = $HTTP_GET_VARS['msg'];
        list($tid, $pid) = explode(".",$delete_msg);
        $back = $HTTP_GET_VARS['back'];

    }else {

        html_draw_top();
        echo "<h1>Invalid Operation</h1>\n";
        echo "<h2>No message specified for deleting</h2>";
        html_draw_bottom();
        exit;

    }

    if(isset($tid) && isset($pid)) {

        $preview_message = messages_get($tid, $pid, 1);

        if(count($preview_message) > 0) {

            $preview_message['CONTENT'] = message_get_content($tid, $pid);

            if(bh_session_get_value('UID') != $preview_message['FROM_UID'] && !perm_is_moderator()) {
                edit_refuse();
                exit;
            }

            $to_uid = $preview_message['TO_UID'];
            $from_uid = $preview_message['FROM_UID'];

        }else {

            $valid = false;
            $error_html = "<h2>Message " . $HTTP_GET_VARS['msg'] . " was not found</h2>";

        }
    }
}

html_draw_top_script();

if ($valid) {

    if(isset($HTTP_POST_VARS['submit'])) {

        if (post_delete($tid, $pid)) {

            if (perm_is_moderator()) admin_addlog(0, 0, $tid, $pid, 0, 0, 22);

            echo "<div align=\"center\">";
            echo "<p>Post deleted successfully</p>";
            echo form_quick_button("discussion.php", "Back", "msg", $HTTP_POST_VARS['t_back']);
            echo "</div>";
            html_draw_bottom();
            exit;

        }else {

            $error_html = "<h2>Error deleting post</h2>";

        }
    }

    echo "<h1>Delete this message</h1>";
    echo "<h2>" . thread_get_title($tid) . "</h2>";

    if($to_uid == 0) {

        $preview_message['TLOGON'] = "ALL";
        $preview_message['TNICK'] = "ALL";

    }else {

        $preview_tuser = user_get($to_uid);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];

    }

    $preview_tuser = user_get($from_uid);
    $preview_message['FLOGON'] = $preview_tuser['LOGON'];
    $preview_message['FNICK'] = $preview_tuser['NICKNAME'];

    $threaddata = thread_get($tid);

    if (thread_is_poll($tid) && $pid == 1) {

      poll_display($tid, $threaddata['LENGTH'], $pid, false, false, false, true, true, true);

    }else {

      message_display($tid, $preview_message, $threaddata['LENGTH'], $pid, true, false, false, false, $show_sigs, true);

    }
}

if(isset($error_html)) echo $error_html;

echo "<form name=\"f_delete\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\" target=\"_self\">";
echo form_input_hidden("t_msg",$delete_msg);
echo form_input_hidden("t_back",$back);
echo form_submit("submit","Delete");
echo "&nbsp;".form_submit("cancel","Cancel");
echo "</form>\n";
echo "<p>&nbsp;</p>\n";

html_draw_bottom();

?>
