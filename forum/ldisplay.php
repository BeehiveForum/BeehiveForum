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

/* $Id: ldisplay.php,v 1.14 2006-09-01 12:05:12 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

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

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {

    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {

    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./lforums.php?final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("./lforums.php");
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $msg = $_GET['msg'];
}else {
    if (bh_session_get_value('UID')) {
        $msg = messages_get_most_recent(bh_session_get_value('UID'));
    } else {
        $msg = "1.1";
    }
}

list($tid, $pid) = explode('.', $msg);

if (!is_numeric($pid)) $pid = 1;
if (!is_numeric($tid)) $tid = 1;

if (!$message = messages_get($tid, $pid, 1)) {

   light_html_draw_top();
   echo "<h1>{$lang['error']}</h1>\n";
   echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
   light_html_draw_bottom();
   exit;
}

if (!$threaddata = thread_get($tid)) {

    light_html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
    light_html_draw_bottom();
    exit;
}

$foldertitle = folder_get_title($threaddata['FID']);

light_html_draw_top();

light_messages_top($msg, apply_wordfilter(_stripslashes($threaddata['TITLE'])), $threaddata['INTEREST'], $threaddata['STICKY'], $threaddata['CLOSED'], $threaddata['ADMIN_LOCK']);

$first_msg = $message['PID'];
$message['CONTENT'] = message_get_content($tid, $message['PID']);

if ($threaddata['POLL_FLAG'] == 'Y') {

    if ($message['PID'] == 1) {

        light_poll_display($tid, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, true, false, false);
        $last_pid = $message['PID'];

    }else {

        light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, true, false, false);
        $last_pid = $message['PID'];
    }

}else {

    light_message_display($tid, $message, $threaddata['LENGTH'], $first_msg, $threaddata['FID'], true, $threaddata['CLOSED'], false, false, false, false);
    $last_pid = $message['PID'];
}

echo "<a href=\"lmessages.php?msg=$msg\">{$lang['back']}</a>\n";

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>