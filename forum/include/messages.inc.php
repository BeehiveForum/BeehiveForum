<?php

/*======================================================================
Copyright Ben Sekulowicz <me@beseku.com>, Chris Hodcroft
<chris@hodcroft.net>, Mark Rendle <mark@bigpinkpig.com> 2002

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
along with Beehive Forum; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Included functions for displaying threads in the left frameset.

require_once("./include/db.inc.php"); // Database functions
require_once("./include/threads.inc.php"); // Thread processing functions

function messages_get($tid, $pid = 1, $limit = 1) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
	$db = db_connect();

	// Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
	// for threads with unread messages, so the UID needs to be passed to the function
	$sql  = "SELECT POST.pid, POST.reply_to_pid, POST.from_uid, POST.to_uid, POST.created, POST.content, FUSER.nickname AS fnick, TUSER.nickname AS tnick ";
	$sql .= "FROM POST LEFT JOIN USER FUSER ON POST.from_uid = FUSER.uid LEFT JOIN USER TUSER ON POST.to_uid = TUSER.uid ";
	$sql .= "WHERE POST.tid = $tid ";
	$sql .= "AND POST.pid >= $pid ";
	$sql .= "ORDER BY POST.pid ";
	$sql .= "LIMIT 0, " . $limit;

	$resource_id = db_query($sql, $db);

	// Loop through the results and construct an array to return
	for ($i = 0; $i < db_num_rows($resource_id); $i++) {

		$message = db_fetch_array($resource_id);

		$messages[$i]['pid'] = $message['pid'];
		$messages[$i]['reply_to_pid'] = $message['reply_to_pid'];
		$messages[$i]['from_uid'] = $message['from_uid'];
		$messages[$i]['to_uid'] = $message['to_uid'];
		$messages[$i]['created'] = $message['created'];
		$messages[$i]['content'] = $message['content'];
		$messages[$i]['fnick'] = $message['fnick'];
		if($message['tnick']){
           	$messages[$i]['tnick'] = $message['tnick'];
        } else {
            $messages[$i]['tnick'] = "ALL";
        }
	}

	db_disconnect($db);
	return $messages;
}

function messages_top($threadtitle)
{
    echo "<p>Discussion: $threadtitle</p>";
    // To be expanded later
}

function messages_bottom()
{
    echo "<p>Bottom of messages, innit?</p>";
}

function message_display($tid, $message)
{
    echo "<br /><div align=\"center\">";
    echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td>";
    echo "<table width=\"100%\" border=\"0\"><tr>";
    echo "<td class=\"posthead\" width=\"1%\" align=\"right\">";
    echo "<p class=\"posttofrom\">From:<br>To:</p></td>";
    echo "<td class=\"posthead\" width=\"99%\">";
    echo "<p class=\"posttofrom\">" . $message['fnick'] . "<br>" . $message['tnick'] . "</p></td>";
    echo "<td class=\"posthead\" width=\"1%\" align=\"right\">";
    echo "<p class=\"postinfo\">Info</p></td></table>";
    echo "<table width=\"100%\" border=\"0\">";
    echo "<tr><td align=\"right\">$tid.$pid</td></tr>";
    echo "<tr><td class=\"postbody\">";
    echo $message['content'];
    echo "</td></tr>";
    echo "<tr><td><p class=\"postresponse\">Reply</p></td></tr></table>";
    echo "</td></tr></table></div>";
}
?>
