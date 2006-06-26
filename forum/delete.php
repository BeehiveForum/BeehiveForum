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

/* $Id: delete.php,v 1.99 2006-06-26 11:04:39 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable UTF-8 encoding via mb_string functions if supported
include_once(BH_INCLUDE_PATH. "utf8.inc.php");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
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

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

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

if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_draw_top();

    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['emailconfirmationrequiredbeforepost']}</h2>\n";
    echo "<h2><a href=\"\">{$lang['resendconfirmation']}</a></h2>\n";

    html_draw_bottom();
    exit;
}

if (!bh_session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

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

        if ((bh_session_get_value('UID') != $preview_message['FROM_UID'] || bh_session_check_perm(USER_PERM_PILLORIED, 0)) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

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

            if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != bh_session_get_value('UID')) {

                admin_add_log_entry(DELETE_POST, array($t_fid, $tid, $pid));
            }

            echo "<h1>{$lang['deletemessage']} {$tid}.{$pid}</h1>\n";
            echo "<br />\n";
            echo "<table class=\"posthead\" width=\"720\">\n";
            echo "  <tr>\n";
            echo "    <td class=\"subhead\">{$lang['deletemessage']}</td>\n";
            echo "  </tr>\n";
            echo "  <tr>\n";
            echo "    <td><h2>{$lang['postdelsuccessfully']}</h2></td>\n";
            echo "  </tr>\n";
            echo "  <tr>\n";
            echo "    <td align=\"center\">\n";

            $thread_length = thread_get_length($tid);

            if ($thread_length < 1) {

                if ($msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

                    echo form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");

                }else {

                    bh_setcookie('bh_thread_mode', 0);
                    $msg = messages_get_most_recent(bh_session_get_value('UID'));
                    echo form_quick_button("./discussion.php", $lang['back'], "msg", $msg, "_self");
                }

            }else {

                echo form_quick_button("./discussion.php", $lang['back'], "msg", "$tid.$pid", "_self");
            }

            echo "    </td>\n";
            echo "  </tr>\n";
            echo "</table>\n";

            html_draw_bottom();
            exit;

        }else {

            $error_html = "<h2>{$lang['errordelpost']}</h2>";
        }
    }

    echo "<h1>{$lang['delthismessage']}</h1>";
    echo "<h2>", apply_wordfilter(thread_get_title($tid)), "</h2>";

    if ($to_uid == 0) {

        $preview_message['TLOGON'] = $lang['allcaps'];
        $preview_message['TNICK'] = $lang['allcaps'];

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
