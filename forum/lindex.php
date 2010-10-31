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

/* $Id: lmessages.php 4567 2010-10-12 17:46:56Z DecoyDuck $ */

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

// Don't cache this page - fixes problems with Opera.
cache_disable();

// See if we can try and logon automatically
logon_perform_auto();

// Get webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = bh_session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Light mode check to see if we should bounce to the logon screen.
if (bh_getcookie('logon')) {
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

// User UID for fetching recent message
$uid = bh_session_get_value('UID');

// Does the user want to login or have they got saved username and password
if (bh_getcookie('logon') && user_is_guest()) {

    // Display the logon form.
    light_draw_logon_form();

} else {

    // Check the webtag is valid.
    if (forum_check_webtag_available($webtag)) {

        // Check for message to display.
        if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            // Display the request message.
            light_draw_messages($_GET['msg']);

        // Check for PM to display.
        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            // Guests can't access PMs
            if (user_is_guest()) {

                light_html_guest_error();
                exit;
            }

            // Check that PM system is enabled
            light_pm_enabled();

            // Prune the PM folders
            pm_user_prune_folders();

            // Display the Inbox.
            light_draw_pm_inbox();

        }else {

            // Display thread list.
            light_draw_thread_list();
        }

    }else {

        // Draw forums page.
        light_draw_my_forums();
    }
}

// Clear the logon cookie
bh_setcookie("logon", "", time() - YEAR_IN_SECONDS);
  
?>