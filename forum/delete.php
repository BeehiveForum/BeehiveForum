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

/* $Id: delete.php,v 1.36 2003-09-15 18:34:45 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
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
require_once("./include/lang.inc.php");

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if (isset($HTTP_POST_VARS['msg'])) {

    $msg = $HTTP_POST_VARS['msg'];
    list($tid, $pid) = explode(".", $msg);

}elseif (isset($HTTP_GET_VARS['msg'])) {

    $msg = $HTTP_GET_VARS['msg'];
    list($tid, $pid) = explode(".", $msg);

}else {

    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2{$lang['nomessagespecifiedfordel']}</h2>";
    // html_draw_bottom();
    exit;
}

if (isset($HTTP_POST_VARS['cancel'])) {
    $uri = "./discussion.php?msg=". $msg;
    header_redirect($uri);
}

if (isset($tid) && isset($pid) && is_numeric($tid) && is_numeric($pid)) {

    $preview_message = messages_get($tid, $pid, 1);

    if (count($preview_message) > 0) {

        $preview_message['CONTENT'] = message_get_content($tid, $pid);

        if (bh_session_get_value('UID') != $preview_message['FROM_UID'] && !perm_is_moderator()) {
            edit_refuse();
            exit;
        }

        $to_uid = $preview_message['TO_UID'];
        $from_uid = $preview_message['FROM_UID'];

    }else {

        $valid = false;
        $error_html = "<h2>{$lang['message']} " . $HTTP_GET_VARS['msg'] . " {$lang['wasnotfound']}</h2>";
    }
}

html_draw_top("openprofile.js", "basetarget=_blank");

if ($valid) {

    if (isset($HTTP_POST_VARS['submit']) && is_numeric($tid) && is_numeric($pid)) {

        if (post_delete($tid, $pid)) {

            if (perm_is_moderator()) admin_addlog(0, 0, $tid, $pid, 0, 0, 22);

            echo "<div align=\"center\">";
            echo "<p>{$lang['postdelsuccessfully']}</p>";
            echo form_quick_button("discussion.php", $lang['back'], "msg", $HTTP_POST_VARS['msg']);
            echo "</div>";
            // html_draw_bottom();
            exit;

        }else {

            $error_html = "<h2>{$lang['errordelpost']}</h2>";

        }

    }

    echo "<h1>{$lang['delthismessage']}</h1>";
    echo "<h2>" . thread_get_title($tid) . "</h2>";

    if ($to_uid == 0) {

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

echo "<div align=\"center\">\n";
echo "  <form name=\"f_delete\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\" target=\"_self\">\n";
echo "    ", form_input_hidden("msg", $msg), "\n";
echo "    <p>", form_submit("submit", $lang['delete']), "&nbsp;".form_submit("cancel", $lang['cancel']), "</p>\n";
echo "  </form>\n";
echo "</div>\n";

// html_draw_bottom();

?>