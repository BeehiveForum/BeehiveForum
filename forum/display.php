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

/* $Id: display.php,v 1.116 2009-10-18 17:51:07 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

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

// User UID for fetching recent message

$uid = bh_session_get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

}else if (isset($_GET['print_msg']) && validate_msg($_GET['print_msg'])) {

    $msg = $_GET['print_msg'];
    list($tid, $pid) = explode('.', $msg);

}else {

    html_draw_top("title={$lang['error']}", "robots=noindex,nofollow");
    html_error_msg($lang['invalidmsgidornomessageidspecified']);
    html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid, bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (!$folder_data = folder_get($thread_data['FID'])) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['foldercouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (!$message = messages_get($tid, $pid, 1)) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['postdoesnotexist']);
    html_draw_bottom();
    exit;
}

$thread_title = thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']);

html_draw_top("title=$thread_title", "openprofile.js", "post.js", "poll.js", "folder_options.js", "basetarget=_blank");

if (isset($thread_data['STICKY']) && isset($thread_data['STICKY_UNTIL'])) {

    if ($thread_data['STICKY'] == "Y" && $thread_data['STICKY_UNTIL'] != 0 && time() > $thread_data['STICKY_UNTIL']) {

        thread_set_sticky($tid, false);
        $thread_data['STICKY'] = "N";
    }
}

$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, $pid, $thread_data['FID'], $folder_data['TITLE'], $thread_title, $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK']), "</td>\n";

if ($thread_data['POLL_FLAG'] == 'Y' && $message['PID'] != 1) {

    if (($userpollvote = poll_get_user_vote($tid))) {

        if ($userpollvote ^ POLL_VOTE_MULTI) {

            for ($i = 0; $i < sizeof($userpollvote); $i++) {

                $userpollvotes_array[] = $userpollvote[$i]['OPTION_ID'];
            }

            if (sizeof($userpollvotes_array) > 1) {

                echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoptions']}: ", implode(", ", $userpollvotes_array), "</td>\n";

            }else {

                echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktochangevote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youvotedforoption']} #", implode(", ", $userpollvotes_array), "</td>\n";
            }
        }

    }else {

        echo "    <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\"><a href=\"messages.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_self\" title=\"{$lang['clicktovote']}\"><img src=\"", style_image('poll.png'), "\" border=\"0\" alt=\"{$lang['poll']}\" title=\"{$lang['poll']}\" /></a> {$lang['youhavenotvoted']}</td>\n";
    }
}

echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

if ($message) {

    $first_msg = $message['PID'];
    $message['CONTENT'] = message_get_content($tid, $message['PID']);

    if ($thread_data['POLL_FLAG'] == 'Y') {

        if ($message['PID'] == 1) {

            poll_display($tid, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, $show_sigs, true);

        }else {

            message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, false, $show_sigs, true);
        }

    }else {

        message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], true, $thread_data['CLOSED'], false, false, $show_sigs, true);
    }
}

echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <form accept-charset=\"utf-8\" name=\"display\" method=\"get\" action=\"messages.php\" target=\"_self\">\n";
echo "        ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "        ", form_input_hidden("msg", htmlentities_array("$tid.$pid")), "\n";

if (isset($_GET['print_msg']) && is_numeric($_GET['print_msg'])) {
    echo "        ", form_submit("back", $lang['back']), "&nbsp;", form_button("print", $lang['print'], "onclick=\"self.print()\""), "\n";
}else {
    echo "        ", form_submit("back", $lang['back']), "\n";
}

echo "      </form>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>