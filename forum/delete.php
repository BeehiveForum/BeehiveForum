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

/* $Id: delete.php,v 1.76 2004-06-03 19:31:50 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/threads.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];
    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<h2>{$lang['nomessagespecifiedfordel']}</h2>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {
    $uri = "./discussion.php?webtag=$webtag&msg=". $msg;
    header_redirect($uri);
}

if (!perm_check_folder_permissions($t_fid, USER_PERM_POST_EDIT | USER_PERM_POST_READ)) {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannotdeletepostsinthisfolder']}</h2>\n";

    html_draw_bottom();
    exit;
}

if (isset($tid) && isset($pid) && is_numeric($tid) && is_numeric($pid)) {

    $preview_message = messages_get($tid, $pid, 1);

    if (count($preview_message) > 0) {

        $preview_message['CONTENT'] = message_get_content($tid, $pid);

        if ((strlen(trim($preview_message['CONTENT'])) == 0) && !thread_is_poll($tid)) {
            html_draw_top();
            edit_refuse($tid, $pid);
	    html_draw_bottom();
            exit;
        }

        if (bh_session_get_value('UID') != $preview_message['FROM_UID'] && !perm_is_moderator()) {
            html_draw_top();
            edit_refuse($tid, $pid);
	    html_draw_bottom();
            exit;
        }

        $to_uid = $preview_message['TO_UID'];
        $from_uid = $preview_message['FROM_UID'];

    }else {

        $valid = false;
        $error_html = "<h2>{$lang['message']} $tid.$pid {$lang['wasnotfound']}</h2>";
    }
}

html_draw_top("openprofile.js", "basetarget=_blank");

if ($valid) {

    if (isset($_POST['submit']) && is_numeric($tid) && is_numeric($pid)) {

        if (post_delete($tid, $pid)) {

            if (perm_is_moderator()) admin_addlog(0, 0, $tid, $pid, 0, 0, 22);

            echo "<div align=\"center\">";
            echo "<p>{$lang['postdelsuccessfully']}</p>";

            $thread_length = thread_get_length($tid);

            if ($thread_length < 1) {

                if (threads_any_unread() && $msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

                    form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");

                }else {

                    bh_setcookie('bh_thread_mode', 0);
                    $msg = messages_get_most_recent(bh_session_get_value('UID'));
                    form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");
                }
            }

            echo "</div>";
            html_draw_bottom();
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

if (isset($error_html)) echo $error_html;

echo "<div align=\"center\">\n";
echo "  <form name=\"f_delete\" action=\"delete.php\" method=\"post\" target=\"_self\">\n";
echo "    ", form_input_hidden('webtag', $webtag), "\n";
echo "    ", form_input_hidden("msg", $msg), "\n";
echo "    <p>", form_submit("submit", $lang['delete']), "&nbsp;".form_submit("cancel", $lang['cancel']), "</p>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>