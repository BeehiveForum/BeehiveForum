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

/* $Id: lmessages.php,v 1.113 2008-11-22 22:19:57 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {
    header_redirect("llogon.php?webtag=$webtag");
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
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("lforums.php");
}

// User UID for fetching recent message

$uid = bh_session_get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

}else if (($msg = messages_get_most_recent($uid))) {

    list($tid, $pid) = explode('.', $msg);

}else {

    light_html_draw_top("robots=noindex,nofollow");
    light_html_display_error_msg($lang['nomessages']);
    light_html_draw_bottom();
    exit;
}

// Poll stuff

if (isset($_POST['pollsubmit'])) {

    if (isset($_POST['pollvote'])) {

        poll_vote($_POST['tid'], $_POST['pollvote']);
        header_redirect("lmessages.php?webtag=$webtag&msg=". $_POST['tid']. ".1");

    }else {

        light_html_draw_top("robots=noindex,nofollow");
        light_html_display_error_msg($lang['mustselectpolloption']);
        light_html_draw_bottom();
        exit;
    }
}

light_draw_messages($msg);

if (user_is_guest()) {
    echo "<h4><a href=\"lthread_list.php?webtag=$webtag\">{$lang['backtothreadlist']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['login']}</a></h4>\n";
}else {
    echo "<h4><a href=\"lthread_list.php?webtag=$webtag\">{$lang['backtothreadlist']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";

light_html_draw_bottom();

?>