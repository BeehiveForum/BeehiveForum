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
		if(isset($message['tnick'])){
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
    echo "<br /><div align=\"center\">\n";
    echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td>\n";
    echo "<table width=\"100%\" border=\"0\"><tr>\n";
    echo "<td class=\"posthead\" width=\"1%\" align=\"right\">\n";
    echo "<p class=\"posttofromlabel\">From:<br>To:</p></td>\n";
    echo "<td class=\"posthead\" width=\"99%\">\n";
    echo "<p class=\"posttofrom\">" . $message['fnick'] . "<br>" . $message['tnick'] . "</p></td>\n";
    echo "<td class=\"posthead\" width=\"1%\" align=\"right\">\n";
    echo "<p class=\"postinfo\">Info</p></td></table>\n";
    echo "<table width=\"100%\" border=\"0\">\n";
    echo "<tr><td class=\"postnumber\">$tid.".$message['pid']."</td></tr>\n";
    echo "<tr><td class=\"postbody\">\n";
    echo $message['content']."\n";
    echo "</td></tr>\n";
    echo "<tr><td><p class=\"postresponse\"><a href=\"post.php?replyto=$tid.".$message['pid']."\">Reply</a></p></td></tr></table>\n";
    echo "</td></tr></table></div>\n";
}

function messages_nav_strip($tid,$pid,$length)
{
    // Less than 20 messages, no nav needed
    if($pid == 1 && $length < 20){
        return;
    }

    // Modulus to get base for links, e.g. pid = 28, base = 8
    $spid = $pid % 20;

    // The first section, 1-x
    if($spid > 1){
        if($pid > 1){
            $navbits[0] = "<a href=\"messages.php?msg=$tid.1\">" . mess_nav_range(1,$spid) . "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid); // Don't add <a> tag for current section
        }
    }

    // The middle section(s)
    $i = 0;
    while($spid + 19 <= $length){
        $i++;
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+19); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"messages.php?msg=$tid.$spid\">" . mess_nav_range($spid,$spid+19) . "</a>";
        }
        $spid += 20;
    }

    // The final section, x-n
    if($spid <= $length){
        $i++;
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"messages.php?msg=$tid.$spid\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }
    $max = $i;

    $html = "Show messages:";

    if($length <= 20){
        $html .= " <a href=\"messages.php?msg=$tid.1\">All</a>";
    }
    $i=0;
    foreach($navbits as $bit){
        // Only display first, last and those within 3 of the current section
        if((abs($c - $i) < 4) || $i == 0 || $i == $max){
            $html .= " " . $bit;
        } else if(abs($c - $i) == 4){
            $html .= "...";
        }
        $i++;
    }

    echo "<table width=\"96%\"><tr><td align=\"center\">" . $html . "</td></tr></table>";
}

function mess_nav_range($from,$to)
{
    if($from == $to){
        $range = sprintf("%d", $from);
    } else {
        $range = sprintf("%d-%d", $from, $to);
    }
    return $range;
}

function message_get_user($tid,$pid)
{
    $db = db_connect();
    
    $sql = "select from_uid from POST where tid = $tid and pid = $pid";

    $result = db_query($sql,$db);

    if($result){
        $fa = db_fetch_array($result);
        $uid = $fa['from_uid'];
    } else {
        $uid = "";
    }

    db_disconnect($db);

    return $uid;
}

function messages_update_read($tid,$pid,$uid)
{
    $db = db_connect();
    
    $sql = "select LAST_READ from USER_THREAD where UID = $uid and TID = $tid";

    $result = db_query($sql,$db);
    
    if(db_num_rows($result)){
        $fa = db_fetch_array($result);
        if($pid > $fa['LAST_READ']){
            $sql = "update USER_THREAD set LAST_READ = $pid  where UID = $uid and TID = $tid";
            echo "<p>$sql</p>";
            db_query($sql,$db);
        }
    } else {
        $sql = "insert into USER_THREAD (UID,TID,LAST_READ,INTEREST) ";
        $sql .= "values ($uid, $tid, $pid, 0)";
        db_query($sql,$db);
    }
    db_disconnect($db);
}
?>
