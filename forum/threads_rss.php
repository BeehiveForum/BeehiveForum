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

/* $Id: threads_rss.php,v 1.2 2004-04-21 21:02:54 decoyduck Exp $ */

header('Content-type: text/xml');

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

require_once("./include/db.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/threads.inc.php");

// Get the forum location accounting for forward slashes, multiple slashes, etc.

$forum_location = preg_replace("/\\\/", "/", dirname($_SERVER['PHP_SELF']));
$forum_location = preg_replace("/[\/]+$/", "", $forum_location);
$forum_location = preg_replace("/^[\/]+/", "", $forum_location);
$forum_location = preg_replace("/[\/]+/", "/", "/$forum_location/");
$forum_location = "{$_SERVER['HTTP_HOST']}{$forum_location}";

// Get the Forum Name and the current date.

$forum_name = forum_get_setting('forum_name');
$build_data = date("D, d M Y H:i:s  T");

// echo out the rss feed

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<?xml-stylesheet type=\"text/xsl\" href=\"styles/threads_rss.xsl\"?>\n";
echo "<rss version=\"2.0\">\n";
echo "\t<channel>\n";
echo "\t\t<title>{$forum_name}</title>\n";
echo "\t\t<link>http://{$forum_location}</link>\n";
echo "\t\t<description>{$forum_name} - {$forum_location}</description>\n";
echo "\t\t<lastBuildDate>{$build_data}</lastBuildDate>\n";
echo "\t\t<generator>$forum_name / www.beehiveforum.net</generator>\n";

// Get the recent threads (10 of them)

if ($threads_array = threads_get_most_recent()) {

    foreach ($threads_array as $thread) {

        // Make the date human readable and fetch the content of the last
        // post in the thread. Can easily change this if it isn't right
        // by making it fetch post 1.

        $modified_date   = date("D, d M Y H:i:s  T", $thread['MODIFIED']);
        $message_content = message_get_content($thread['TID'], $thread['LENGTH']);

        echo "\t\t\t<item>\n";
        echo "\t\t\t\t<guid isPermaLink=\"true\">\n";
        echo "\t\t\t\t\thttp://{$forum_location}?msg={$thread['TID']}.1\n";
        echo "\t\t\t\t</guid>\n";
        echo "\t\t\t\t<pubDate>{$modified_date}</pubDate>\n";
        echo "\t\t\t\t<title>{$thread['TITLE']}</title>\n";
        echo "\t\t\t\t<link>\n";
        echo "\t\t\t\t\thttp://{$forum_location}?msg={$thread['TID']}.1\n";
        echo "\t\t\t\t</link>\n";
        echo "\t\t\t\t<description><![CDATA[{$message_content}]]></description>\n";
        echo "\t\t\t\t<comments>\n";
        echo "\t\t\t\t\thttp://{$forum_location}?msg={$thread['TID']}.1\n";
        echo "\t\t\t\t</comments>\n";
        echo "\t\t\t</item>\n";
    }
}

echo "\t</channel>\n";
echo "</rss>\n";

?>