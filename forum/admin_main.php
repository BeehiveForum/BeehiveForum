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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Get Webtag
$webtag = get_webtag();

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

// Initialise Locale
lang_init();

if ((!session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {

    html_draw_top();
    html_error_msg(gettext("You do not have permission to use this section."));
    html_draw_bottom();
    exit;
}

html_draw_top();

echo "<h1>", gettext("Forum Admin"), "</h1>\n";

if (!forum_check_webtag_available()) {
    html_display_warning_msg("To see additional Admin options click 'My Forums', select a forum and then click the Admin link to return here", '600px', 'left');
}

if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    echo "<p>", gettext("Use the menu on the left to manage things in your forum."), "</p>\n";
    echo "<p>", gettext("<b>Users</b> allows you to set individual user permissions, including appointing moderators and gagging people."), "</p>\n";

    if (forum_check_webtag_available()) {

        echo "<p>", gettext("<b>User Groups</b> allows you to create User Groups to assign permissions to as many or as few users quickly and easily."), "</p>\n";
        echo "<p>", gettext("<b>Ban Controls</b> allows the banning and un-banning of IP Addresses, HTTP Referers, Usernames, Email addresses and Nicknames."), "</p>\n";
        echo "<p>", gettext("<b>Folders</b> allows the creation, modification and deletion of folders."), "</p>\n";
        echo "<p>", gettext("<b>RSS Feeds</b> allows you to manage RSS feeds for propagation into your forum."), "</p>\n";
        echo "<p>", gettext("<b>Profiles</b> lets you customise the items that appear in the user profiles."), "</p>\n";
        echo "<p>", gettext("<b>Forum Settings</b> allows you to customise your forum's name, appearance and many other things."), "</p>\n";
        echo "<p>", gettext("<b>Start Page</b> lets you customise your forum's start page."), "</p>\n";
        echo "<p>", gettext("<b>Forum style</b> allows you to generate random styles for your forum members to use."), "</p>\n";
        echo "<p>", gettext("<b>Word filter</b> allows you to filter words you don't want to be used on your forum."), "</p>\n";
        echo "<p>", gettext("<b>Posting stats</b> generates a report listing the top 10 posters in a defined period."), "</p>\n";
        echo "<p>", gettext("<b>Forum links</b> lets you manage the links dropdown in the navigation bar."), "</p>\n";
        echo "<p>", gettext("<b>View log</b> lists recent actions by the forum moderators."), "</p>\n";

        if (session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {
            echo "<p>", gettext("<b>Post Approval Queue</b> allows you to view any posts awaiting approval by a moderator."), "</p>\n";
        }

        echo "<p>", gettext("<b>Visitor Log</b> allows you to view an extended list of visitors including their HTTP referers."), "</p>\n";
    }

}elseif (session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

    echo "<p>", gettext("<b>Post Approval Queue</b> allows you to view any posts awaiting approval by a moderator."), "</p>\n";
}

if (session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0)) {

    echo "<p>", gettext("<b>Manage Forums</b> lets you create and delete and close or reopen forums."), "</p>\n";
    echo "<p>", gettext("<b>Global Forum Settings</b> allows you to modify settings which affect all forums."), "</p>\n";
}

html_draw_bottom();

?>
