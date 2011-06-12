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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// See if we can try and logon automatically
logon_perform_auto();

// Get webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Light mode check to see if we should bounce to the logon screen.
if (html_get_cookie('logon')) {
    header_redirect("llogon.php?webtag=$webtag");
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
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Message pane caching
cache_check_messages();

// Load language file
$lang = load_language_file();

// Check that we have access to this forum
if (!forum_check_access_level()) {
    header_redirect("lforums.php");
}

// User UID for fetching recent message
$uid = session_get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    list($tid, $pid) = explode('.', $_GET['msg']);

}else if (($msg = messages_get_most_recent($uid))) {

    list($tid, $pid) = explode('.', $msg);

}else {

    light_html_draw_top("title={$lang['error']}", "robots=noindex,nofollow");
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

        light_html_draw_top("title={$lang['error']}", "robots=noindex,nofollow");
        light_html_display_error_msg($lang['mustselectpolloption']);
        light_html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['pollchangevote'])) {

    if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {

        $tid = $_POST['tid'];

        $pid = 1;

        poll_delete_vote($tid);
    }
}

light_html_draw_top();

light_draw_messages($tid, $pid);

light_html_draw_bottom();

?>