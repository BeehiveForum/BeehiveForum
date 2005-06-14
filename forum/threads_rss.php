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

/* $Id: threads_rss.php,v 1.16 2005-06-14 14:11:48 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

$webtag = get_webtag($webtag_search);

// Get the forum location accounting for forward slashes, multiple slashes, etc.

$forum_location = preg_replace("/\\\/", "/", dirname($_SERVER['PHP_SELF']));
$forum_location = preg_replace("/[\/]+$/", "", $forum_location);
$forum_location = preg_replace("/^[\/]+/", "", $forum_location);
$forum_location = preg_replace("/[\/]+/", "/", "/$forum_location/");
$forum_location = "{$_SERVER['HTTP_HOST']}{$forum_location}";

// Get the Forum Name and the current date.

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');
$build_data = gmdate("D, d M Y H:i:s");

// Check to see if we can login a user

if (isset($_COOKIE['bh_remember_username'][0]) && isset($_COOKIE['bh_remember_passhash'][0])) {

    $username = strtoupper($_COOKIE['bh_remember_username'][0]);
    $passhash = $_COOKIE['bh_remember_passhash'][0];

    $uid = user_logon($username, $passhash, true);

    if (isset($uid) && $uid > -1) {

        bh_session_init($uid);
        $user_sess = bh_session_check();
    }
}

// echo out the rss feed

header('Content-type: text/xml');

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<rss version=\"2.0\">\n";
echo "<channel>\n";
echo "<title>{$forum_name}</title>\n";
echo "<link>http://{$forum_location}</link>\n";
echo "<description>{$forum_name} - {$forum_location}</description>\n";
echo "<lastBuildDate>{$build_data} UT</lastBuildDate>\n";
echo "<generator>$forum_name / www.beehiveforum.net</generator>\n";

// Get the 20 most recent threads

if ($threads_array = threads_get_most_recent(20)) {

    foreach ($threads_array as $thread) {

        // Make the date human readable and fetch the content of the last
        // post in the thread. Can easily change this if it isn't right
        // by making it fetch post 1.

        $thread['TITLE'] = _htmlentities_decode(_stripslashes($thread['TITLE']));

        $modified_date   = gmdate("D, d M Y H:i:s", $thread['MODIFIED']);

        $message_content = message_get_content($thread['TID'], $thread['LENGTH']);
        $parsed_message = new MessageTextParse($message_content, false);

        $t_content = $parsed_message->getMessage();
        $t_content = strip_tags(_htmlentities_decode($t_content));
        $t_content = preg_replace('/[\r|\n|\r\n]/', ' ', $t_content);
        $t_content = trim(preg_replace('/[ ]+/', ' ', $t_content));

        echo "<item>\n";
        echo "<guid isPermaLink=\"true\">http://{$forum_location}?webtag=$webtag&amp;msg={$thread['TID']}.1</guid>\n";
        echo "<pubDate>{$modified_date} UT</pubDate>\n";
        echo "<title>{$thread['TITLE']}</title>\n";
        echo "<link>http://{$forum_location}?webtag=$webtag&amp;msg={$thread['TID']}.1</link>\n";
        echo "<description><![CDATA[{$t_content}]]></description>\n";
        echo "<comments>http://{$forum_location}?webtag=$webtag&amp;msg={$thread['TID']}.1</comments>\n";
        echo "</item>\n";
    }
}

echo "</channel>\n";
echo "</rss>\n";

?>