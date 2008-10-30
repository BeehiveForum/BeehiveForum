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

/* $Id: threads_rss.php,v 1.73 2008-10-30 20:42:53 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get webtag

$webtag = get_webtag();

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

// Check to see if the user wants a specified list of folders
// or the default to show all folders.

if (isset($_GET['fid']) && mb_strlen(trim(stripslashes($_GET['fid']))) > 0) {

    $fid = trim(stripslashes($_GET['fid']));

    if (preg_match("/(([0-9]+),)+,?/u", $fid)) {

        $folder_list_array = preg_grep("/^[0-9]+$/Du", explode(",", $fid));

    }elseif (is_numeric($_GET['fid'])) {

        $folder_list_array = array($_GET['fid']);

    }else {

        $folder_list_array = array();
    }

}else {

    $folder_list_array = array();
}

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

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    header_server_error();
}

// Check we're logged in correctly

if (!$user_sess = bh_session_check(false)) {

    // Retrieve existing cookie data if any and try
    // and log in the last used user account.

    if (logon_get_cookies($username_array, $password_array, $passhash_array)) {

        if (isset($username_array[0]) && mb_strlen(trim($username_array[0])) > 0) {

            if (isset($passhash_array[0]) && is_md5($passhash_array[0])) {

                $username = mb_strtoupper($username_array[0]);
                $passhash = $passhash_array[0];

                if (($uid = user_logon($username, $passhash))) {

                    bh_session_init($uid);
                    header_redirect("threads_rss.php?webtag=$webtag&fid=$fid&limit=$limit&sort_created=$sort_created");
                    exit;

                }else {

                    header_server_error();
                }
            }
        }
    }
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

// Enable caching on RSS Feed

header_check_cache();

// echo out the rss feed

header('Content-type: text/xml; charset=UTF-8');

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<rss xmlns:dc=\"http://purl.org/dc/elements/1.1/\" version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
echo "<channel>\n";
echo "<title>{$forum_name}</title>\n";
echo "<link>{$forum_location}/</link>\n";
echo "<description>{$forum_name} - {$forum_location}/</description>\n";
echo "<lastBuildDate>{$build_date}</lastBuildDate>\n";
echo "<generator>Project Beehive Forum - www.beehiveforum.net</generator>\n";

// Get the 20 most recent threads

if (($threads_array = threads_get_most_recent($limit, $folder_list_array, ($sort_created == 'Y')))) {

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
        echo "  <guid isPermaLink=\"true\">{$forum_location}/?webtag=$webtag&amp;msg={$thread['TID']}.1</guid>\n";
        echo "  <pubDate>{$modified_date} UT</pubDate>\n";
        echo "  <title>{$t_title}</title>\n";
        echo "  <link>{$forum_location}/?webtag=$webtag&amp;msg={$thread['TID']}.1</link>\n";

        // Get the author of the message.

        if (isset($t_user_array['LOGON'])) {

            $t_user = htmlentities_array(format_user_name($t_user_array['LOGON'], $t_user_array['NICKNAME']));
            echo "  <dc:creator>{$t_user}</dc:creator>\n";
        }

        echo "  <description><![CDATA[{$t_content}]]></description>\n";
        echo "  <comments>{$forum_location}/?webtag=$webtag&amp;msg={$thread['TID']}.1</comments>\n";
        echo "</item>\n";
    }
}

echo "<atom:link href=\"{$forum_location}/threads_rss.php?webtag=$webtag\" rel=\"self\" type=\"application/rss+xml\" />\n";
echo "</channel>\n";
echo "</rss>\n";

?>