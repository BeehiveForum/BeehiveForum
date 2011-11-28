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

/* $Id: delete.php 4783 2011-08-15 19:28:12Z decoyduck $ */

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
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

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

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

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages
$error_msg_array = array();

// Check if the user is viewing signatures.
$show_sigs = (session_get_value('VIEW_SIGS') == 'N') ? false : true;

// Form validation
$valid = true;

// Submit code.
if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['nomessagespecifiedfordel']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {

    header_redirect("discussion.php?webtag=$webtag&msg=$msg");
    exit;
}

if (session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannotdeletepostsinthisfolder']);
    html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (!thread_is_poll($tid) || ($pid != 1)) {

    $uri = "discussion.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg=". $_GET['msg'];
    }elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
        $uri.= "&msg=". $_POST['msg'];
    }

    header_redirect($uri);
}

if (!$edit_message = messages_get($tid, 1, 1)) {

    html_draw_top("title={$lang['error']}");
    html_display_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

$post_edit_time = forum_get_setting('post_edit_time', false, 0);

$uid = session_get_value('UID');

if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session_check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_message));
    html_draw_bottom();
    exit;
}

if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['nopermissiontoedit'], 'discussion.php', 'get', array('back' => $lang['back']), array('msg' => $edit_message));
    html_draw_bottom();
    exit;
}

if (($preview_message = messages_get($tid, $pid, 1))) {

    $preview_message['CONTENT'] = message_get_content($tid, $pid);

    if ((strlen(trim($preview_message['CONTENT'])) < 1) && !thread_is_poll($tid)) {

        html_draw_top("title={$lang['error']}");
        post_edit_refuse($tid, $pid);
        html_draw_bottom();
        exit;
    }

    if ((session_get_value('UID') != $preview_message['FROM_UID'] || session_check_perm(USER_PERM_PILLORIED, 0)) && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top("title={$lang['error']}");
        post_edit_refuse($tid, $pid);
        html_draw_bottom();
        exit;
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($preview_message['APPROVED']) && $preview_message['APPROVED'] == 0 && !session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top("title={$lang['error']}");
        post_edit_refuse($tid, $pid);
        html_draw_bottom();
        exit;
    }
}

if (isset($_POST['endpoll'])) {

    if (poll_close($tid)) {

        post_add_edit_text($tid, 1);

        if (session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != session_get_value('UID')) {
            admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
        }
    }

    if ($thread_data['LENGTH'] > 1) {

        header_redirect("discussion.php?webtag=$webtag&msg=$msg&edit_success=$msg");
        exit;

    }else {

        header_redirect("discussion.php?webtag=$webtag&edit_success=$msg");
        exit;
    }
}

html_draw_top("title={$lang['deletemessage']}", "post.js", "resize_width=720", "basetarget=_blank", 'class=window_title');

echo "<h1>{$lang['deletemessage']} {$tid}.{$pid}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

if ($preview_message['TO_UID'] == 0) {

    $preview_message['TLOGON'] = $lang['allcaps'];
    $preview_message['TNICK'] = $lang['allcaps'];

}else {

    $preview_tuser = user_get($preview_message['TO_UID']);
    $preview_message['TLOGON'] = $preview_tuser['LOGON'];
    $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
}

$preview_tuser = user_get($preview_message['FROM_UID']);

$preview_message['FLOGON'] = $preview_tuser['LOGON'];
$preview_message['FNICK'] = $preview_tuser['NICKNAME'];

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"close_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['endpoll']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\"><br />";

poll_display($tid, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], false, $show_sigs, true);

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
echo "      <td align=\"center\">", form_submit("endpoll", $lang['endpoll']), "&nbsp;".form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>