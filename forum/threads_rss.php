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

include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get webtag
$webtag = get_webtag();

// Check the webtag is valid
forum_check_webtag_available($webtag);

// Arrays for our cookie data
$username_array = array();
$password_array = array();
$passhash_array = array();

// Get the forum location accounting for forward slashes, multiple slashes, etc.
$forum_location = html_get_forum_uri();

// Get the Forum Name
$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

// Current date
$build_date = gmdate("D, d M Y H:i:s O");

// Check to see if the user wants a custom number of threads.
// Maximum to display is 20. Minimum is 1. Default is 20.
if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {

    if ($_GET['limit'] > 20) {

        $limit = 20;

    }else if ($_GET['limit'] < 1) {

        $limit = 1;

    }else {

        $limit = $_GET['limit'];
    }

}else {

    $limit = 20;
}

// Feed title is just the forum name by default
$feed_title = $forum_name;

// Default to showing all available folders
$fid = false;

// Check to see if the user wants threads ordered by created
// or modified date. Modified date bumps a thread to the top
// when it receives a reply. Created threads show the threads
// in the order they were created and is more useful as a
// RSS news feed within your forum.
if (isset($_GET['sort_created']) && $_GET['sort_created'] == 'Y') {
    $sort_created = 'Y';
}else {
    $sort_created = 'N';
}

// See if we can try and logon automatically
logon_perform_auto();

// Load the user session
$user_sess = session_check(false);

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

// Check that Guests are allowed
if (user_is_guest() && !user_guest_enabled()) {
    html_guest_error();
}


// Check to see if the user wants a specified list of folders
// or the default to show all folders.
if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    if (($available_folders_array = folder_get_available_array())) {

        if (in_array($_GET['fid'], $available_folders_array) && ($folder_title = folder_get_title($fid))) {

            $fid = trim(stripslashes_array($_GET['fid']));
            $feed_title.= sprintf(' - %s', htmlentities_array($folder_title));

        } else {

            $fid = false;
        }
    }
}

// Enable caching on RSS Feed
cache_check_last_modified(time() + 300);

// Language file
$lang = load_language_file();

// echo out the rss feed
header('Content-type: text/xml; charset=UTF-8');

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<rss xmlns:dc=\"http://purl.org/dc/elements/1.1/\" version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
echo "<channel>\n";
echo "<title>{$feed_title} - {$lang['rssfeed']}</title>\n";
echo "<link>{$forum_location}/</link>\n";
echo "<description>{$forum_name} - {$forum_location}/</description>\n";
echo "<lastBuildDate>{$build_date}</lastBuildDate>\n";
echo "<generator>Project Beehive Forum - www.beehiveforum.co.uk</generator>\n";
echo "<image>\n";
echo "<title>{$forum_name}</title>\n";
echo "<url>", html_style_image('rss_icon.png', true, true), "</url>\n";
echo "<link>{$forum_location}/</link>\n";
echo "</image>\n";

// Get the 20 most recent threads
if (($threads_array = threads_get_most_recent($limit, $fid, ($sort_created == 'Y')))) {

    foreach ($threads_array as $thread) {

        $t_title = $thread['TITLE'];

        // Make the date human readable and fetch the content of the last
        // post in the thread. Can easily change this if it isn't right
        // by making it fetch post 1.
        $modified_date = gmdate("D, d M Y H:i:s", $thread['MODIFIED']);

        // Get the post content and author
        if ($sort_created == 'Y') {

            $t_content = message_get_content($thread['TID'], 1);
            $t_user_array = message_get_user_array($thread['TID'], 1);

        }else {

            $t_content = message_get_content($thread['TID'], $thread['LENGTH']);
            $t_user_array = message_get_user_array($thread['TID'], $thread['LENGTH']);
        }

        // Strip signatures from the RSS feed
        $t_content = message_apply_formatting($t_content, false, true);

        // Strip HTML and trim the content back.
        $t_content = strip_tags(trim(xml_strip_invalid_chars($t_content)));

        // Convert HTML special chars (& -> &amp;, etc);
        $t_content = htmlspecialchars($t_content);
        $t_title   = htmlspecialchars($t_title);

        // Check for double-encoded HTML chars (&amp;amp;, etc.)
        $t_content = preg_replace("/&amp;(#[0-9]+|[a-z]+);/iu", "&\\1;", $t_content);
        $t_title   = preg_replace("/&amp;(#[0-9]+|[a-z]+);/iu", "&\\1;", $t_title);

        // Convert HTML entities to XML literals.
        $t_content = html_entity_to_decimal($t_content);
        $t_title   = html_entity_to_decimal($t_title);

        // Output the item.
        echo "<item>\n";
        echo "  <guid isPermaLink=\"true\">{$forum_location}/index.php?webtag=$webtag&amp;msg={$thread['TID']}.1</guid>\n";
        echo "  <pubDate>{$modified_date} UT</pubDate>\n";
        echo "  <title>{$t_title}</title>\n";
        echo "  <link>{$forum_location}/index.php?webtag=$webtag&amp;msg={$thread['TID']}.1</link>\n";

        // Get the author of the message.
        if (isset($t_user_array['LOGON'])) {

            $t_user = htmlentities_array(format_user_name($t_user_array['LOGON'], $t_user_array['NICKNAME']));
            echo "  <dc:creator>{$t_user}</dc:creator>\n";
        }

        echo "  <description><![CDATA[{$t_content}]]></description>\n";
        echo "  <comments>{$forum_location}/index.php?webtag=$webtag&amp;msg={$thread['TID']}.1</comments>\n";
        echo "</item>\n";
    }
}

echo "<atom:link href=\"{$forum_location}/threads_rss.php?webtag=$webtag\" rel=\"self\" type=\"application/rss+xml\" />\n";
echo "</channel>\n";
echo "</rss>\n";

?>