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

/* $Id: user_stats.php,v 1.59 2008-07-25 14:52:56 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Intitalise a few variables

$webtag_search = false;

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
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

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// User's UID

$uid = bh_session_get_value('UID');

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri() );
    header_redirect("forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check if we're fetching the stats.

if (isset($_GET['get_stats'])) {

    stats_output_xml();
    exit;

}else {

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $msg = $_GET['msg'];
    }else {
        $msg = messages_get_most_recent($uid);
    }

    if (isset($_GET['show_stats']) && $_GET['show_stats'] == "Y") {

        $user_prefs['SHOW_STATS'] = "Y";
        $user_prefs_global['SHOW_STATS'] = false;

    }else {

        $user_prefs['SHOW_STATS'] = "N";
        $user_prefs_global['SHOW_STATS'] = false;
    }

    if (!user_is_guest()) {

        if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

            header_redirect("messages.php?webtag=$webtag&msg=$msg&setstats=1", $lang['statsdisplaychanged']);
            exit;

        }else {

            html_draw_top();
            html_error_msg($lang['failedtoupdateuserdetails'], 'messages.php', 'get', array('back' => $lang['back']), array('msg' => $msg, 'setstats' => 1));
            html_draw_bottom();
        }

    }else {

        header_redirect("messages.php?webtag=$webtag&msg=$msg");
        exit;
    }
}

?>