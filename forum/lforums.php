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

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/light.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/myforums.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Load the user session. We don't need to check if
// the user should be logged in as we want all visitors
// to be able to see this page.

$user_sess = bh_session_check();

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

light_html_draw_top();

if ($user_sess && bh_session_get_value('UID') <> 0) {

    if ($forums_array = get_my_forums()) {

        echo "<h2>My Forums</h2>\n";

        if (sizeof($forums_array['FAVOURITES']) > 0) {

            foreach ($forums_array['FAVOURITES'] as $forum) {

                echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";

	        if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "<p>{$forum['NEW_MESSAGES']} New Messages ({$forum['UNREAD_TO_ME']} unread to me)</p>\n";
	        }else {
                    echo "<p>{$forum['NEW_MESSAGES']} New Messages</p>\n";
                }
  
                echo "<p>Last Visit: ", format_time($forum['LAST_LOGON']), "</p>\n";
	    }
        }

        if (sizeof($forums_array['FORUMS']) > 0) {

            foreach ($forums_array['FORUMS'] as $forum) {

                echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";

	        if ($forum['UNREAD_TO_ME'] > 0) {
                    echo "<p>{$forum['NEW_MESSAGES']} New Messages ({$forum['UNREAD_TO_ME']} unread to me)</p>\n";
	        }else {
                    echo "<p>{$forum['NEW_MESSAGES']} New Messages</p>\n";
                }
  
                echo "<p>Last Visit: ", format_time($forum['LAST_LOGON']), "</p>\n";
	    }
        }

    }else {

        echo "<h2>My Forums</h2>\n";
        echo "<h2>There are no forums available.</h2>\n";
    }

}else {

    $forums_array = get_forum_list();

    echo "<h2>Available Forums</h2>\n";

    foreach ($forums_array as $forum) {

        echo "<h3><a href=\"./lthread_list.php?webtag={$forum['WEBTAG']}\">{$forum['FORUM_NAME']}</a></h3>\n";
        echo "<p>{$forum['MESSAGES']} Messages</p>\n";
    }
}

html_draw_bottom();

?>