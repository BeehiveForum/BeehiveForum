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

/* $Id: threads_rss.php,v 1.31 2006-10-24 19:47:29 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

$webtag = get_webtag($webtag_search);

// Get the forum location accounting for forward slashes, multiple slashes, etc.

$forum_location = html_get_forum_uri();

// Get the Forum Name and the current date.

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

$build_data = gmdate("D, d M Y H:i:s");

// Check to see if we can login a user

if (isset($_COOKIE['bh_remember_username'][0]) && isset($_COOKIE['bh_remember_passhash'][0])) {

    $username = strtoupper($_COOKIE['bh_remember_username'][0]);
    $passhash = $_COOKIE['bh_remember_passhash'][0];

    $uid = user_logon($username, $passhash);

    if (isset($uid) && $uid > -1) {

        $user_hash = bh_session_init($uid, false, true);
        $user_sess = bh_session_check(false, $user_hash);
    }

}else {

    $user_hash = bh_session_init(0, false, true);
    $user_sess = bh_session_check(false, $user_hash, true);
}

// Default values (limit 20, all folders, sort by modified)

$limit = 20;
$fid_list = false;
$sort_created = false;

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check to see if the user wants a custom number of threads.
// Maximum to display is 20. Minimum is 1.

if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
    
    $limit = $_GET['limit'];

    if ($limit > 20) $limit = 20;
    if ($limit < 1)  $limit = 1;
}

// Check to see if the user wants a specified list of folders
// or the default to show all folders.

if (isset($_GET['fid']) && strlen(trim(stripslashes($_GET['fid']))) > 0) {

    $fid = trim(stripslashes($_GET['fid']));

    if (preg_match("/(([0-9]+),)+,?/", $fid)) {
        
        $fid_list = preg_grep("/^[0-9]+$/", explode(",", $fid));

    }else if (is_numeric($_GET['fid'])) {

        $fid_list = array($_GET['fid']);
    }
}

// Check to see if the user wants threads ordered by created
// or modified date. Modified date bumps a thread to the top
// when it receives a reply. Created threads show the threads
// in the order they were created and is more useful as a
// RSS news feed within your forum.

if (isset($_GET['sort_created'])) {
    $sort_created = true;
}

// echo out the rss feed

header('Content-type: text/xml');

echo "<?xml version=\"1.0\"?>\n";
echo "<rss version=\"2.0\">\n";
echo "<channel>\n";
echo "<title>{$forum_name}</title>\n";
echo "<link>{$forum_location}/</link>\n";
echo "<description>{$forum_name} - {$forum_location}/</description>\n";
echo "<lastBuildDate>{$build_data} UT</lastBuildDate>\n";
echo "<generator>$forum_name / www.beehiveforum.net</generator>\n";

// Get the 20 most recent threads

if ($threads_array = threads_get_most_recent($limit, $fid_list, $sort_created)) {

    foreach ($threads_array as $thread) {

        $t_title = $thread['TITLE'];
        
        // Make the date human readable and fetch the content of the last
        // post in the thread. Can easily change this if it isn't right
        // by making it fetch post 1.

        $modified_date = gmdate("D, d M Y H:i:s", $thread['MODIFIED']);

        // Get the post content and remove the HTML tags.

        if ($sort_created === true) {

            $t_content = message_get_content($thread['TID'], 1);
            $t_content = strip_tags(trim($t_content));

        }else {

            $t_content = message_get_content($thread['TID'], $thread['LENGTH']);
            $t_content = strip_tags(trim($t_content));
        }

        // Convert HTML special chars (& -> &amp;, etc);

        $t_content = htmlspecialchars($t_content);
        $t_title   = htmlspecialchars($t_title);

        // Check for double-encoded HTML chars (&amp;amp;, etc.)

        $t_content = preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&\\1;", $t_content);
        $t_title   = preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&\\1;", $t_title);

        // Convert HTML entities to XML literals.
        
        $t_content = preg_replace("/(&[^;]+;)/me", "xml_literal_to_numeric('\\1')", $t_content);
        $t_title   = preg_replace("/(&[^;]+;)/me", "xml_literal_to_numeric('\\1')", $t_title);

        echo "<item>\n";
        echo "<guid isPermaLink=\"true\">{$forum_location}/?webtag=$webtag&amp;msg={$thread['TID']}.1</guid>\n";
        echo "<pubDate>{$modified_date} UT</pubDate>\n";
        echo "<title>{$t_title}</title>\n";
        echo "<link>{$forum_location}/?webtag=$webtag&amp;msg={$thread['TID']}.1</link>\n";
        echo "<description>{$t_content}</description>\n";
        echo "<comments>{$forum_location}/?webtag=$webtag&amp;msg={$thread['TID']}.1</comments>\n";
        echo "</item>\n";
    }
}

echo "</channel>\n";
echo "</rss>\n";

?>