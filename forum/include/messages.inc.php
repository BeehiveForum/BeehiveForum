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

// Included functions for displaying messages in the main frameset.

require_once("./include/db.inc.php"); // Database functions
require_once("./include/threads.inc.php"); // Thread processing functions
require_once("./include/format.inc.php"); // Formatting functions
require_once("./include/perm.inc.php"); // Permissions functions
require_once("./include/forum.inc.php"); // Forum functions
require_once("./include/user.inc.php"); // User functions
require_once("./include/folder.inc.php");

function messages_get($tid, $pid = 1, $limit = 1) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    if(!$uid) $uid = 0;

	$db = db_connect();

    $tbl_post = forum_table("POST");

	// Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
	// for threads with unread messages, so the UID needs to be passed to the function
	$sql  = "select POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
	$sql .= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, POST.VIEWED, POST_CONTENT.CONTENT, ";
	$sql .= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, ";
	$sql .= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER.RELATIONSHIP ";
	$sql .= "from " . forum_table("POST") . " POST, " . forum_table("POST_CONTENT") . " POST_CONTENT ";
	$sql .= "left join " . forum_table("USER") . " FUSER on (POST.from_uid = FUSER.uid) ";
	$sql .= "left join " . forum_table("USER") . " TUSER on (POST.to_uid = TUSER.uid) ";
	$sql .= "left join " . forum_table("USER_PEER") . " USER_PEER ";
	$sql .= "on (USER_PEER.uid = $uid and USER_PEER.PEER_UID = POST.FROM_UID) ";
	$sql .= "where POST.TID = $tid ";
	$sql .= "and POST.PID >= $pid ";
	$sql .= "and POST_CONTENT.TID = POST.TID and POST_CONTENT.PID = POST.PID ";
	$sql .= "order by POST.PID ";
	$sql .= "limit 0, " . $limit;

	$resource_id = db_query($sql, $db);

	// Loop through the results and construct an array to return
	for ($i = 0; $i < db_num_rows($resource_id); $i++) {

		$message = db_fetch_array($resource_id);

		$messages[$i]['PID'] = $message['PID'];
		$messages[$i]['REPLY_TO_PID'] = $message['REPLY_TO_PID'];
		//echo "<p>" . $message['REPLY_TO_PID'] . "</p>";
		$messages[$i]['FROM_UID'] = $message['FROM_UID'];
		$messages[$i]['TO_UID'] = $message['TO_UID'];
		$messages[$i]['CREATED'] = $message['CREATED'];
		$messages[$i]['VIEWED'] = $message['VIEWED'];
		$messages[$i]['CONTENT'] = stripslashes($message['CONTENT']);
		$messages[$i]['RELATIONSHIP'] = $message['RELATIONSHIP'];
		$messages[$i]['FNICK'] = $message['FNICK'];
		$messages[$i]['FLOGON'] = $message['FLOGON'];
		if(isset($message['TNICK'])){
           	$messages[$i]['TNICK'] = $message['TNICK'];
           	$messages[$i]['TLOGON'] = $message['TLOGON'];
        } else {
            $messages[$i]['TNICK'] = "ALL";
           	$messages[$i]['TLOGON'] = "ALL";
        }
	}

	db_disconnect($db);
	return $messages;
}

function messages_top($foldertitle, $threadtitle)
{
    echo "<p><img src=\"./images/folder.png\" alt=\"folder\" />$foldertitle: $threadtitle</p>";
    // To be expanded later
}

function messages_bottom()
{
    echo "<p align=\"right\">BeehiveForum 2002</p>";
}

function message_display($tid, $message, $msg_count, $first_msg, $in_list = true, $closed = false)
{
    if(!isset($message['CONTENT']) || $message['CONTENT'] == ""){
        message_display_deleted($tid,$message['PID']);
        return;
    }

    global $HTTP_SERVER_VARS, $HTTP_COOKIE_VARS;

    if($in_list){
        echo "<a name=\"a" . $tid . "_" . $message['PID'] . "\"></a>";
    }
    echo "<br /><div align=\"center\">\n";
    echo "<table width=\"96%\"><tr><td class=\"box\">\n";
    echo "<table class=\"posthead\" width=\"100%\"><tr>\n";
    echo "<td width=\"4%\" align=\"right\">\n";
    echo "<p class=\"posttofromlabel\">From:<br />To:</p></td>\n";
    echo "<td width=\"92%\">\n";
    echo "<p class=\"posttofrom\">";
    echo "<a href=\"#\" onclick=\"openProfile(".$message['FROM_UID'].")\">";
    echo format_user_name($message['FLOGON'], $message['FNICK']) . "</a><br />";
    if($message['TLOGON'] != "ALL"){
        echo "<a href=\"#\" onclick=\"openProfile(".$message['TO_UID'].")\">";
        echo format_user_name($message['TLOGON'], $message['TNICK']) . "</a>";
    } else {
        echo "ALL";
    }
    if(!$message['VIEWED'] && $message['TLOGON'] != "ALL"){
        echo " <span class=\"smalltext\">(unread)</span>";
    }
    echo "</p></td>\n";
    echo "<td width=\"4%\" align=\"right\" nowrap>\n";
    if($in_list){
        $user_prefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
        echo "<p class=\"postinfo\">";
        echo format_time($message['CREATED']);
        echo "<br />" . $message['PID'] . " of $msg_count</p>";
    }
    echo "</td></table>\n";

    if($message['RELATIONSHIP'] < 0){
        echo "<table width=\"100%\" border=\"0\"><tr><td>\n";
        echo "Ignored.</td></tr></table>";
    } else {
        echo "<table width=\"100%\" border=\"0\">\n";
        if($in_list){
            echo "<tr><td align=\"right\"><p class=\"postnumber\" style=\"text-align:right\">";
            echo "$tid." . $message['PID'];
            if($message['PID'] > 1){
                echo " in reply to ";
                if(intval($message['REPLY_TO_PID']) >= intval($first_msg)){
                    echo "<a href=\"#a" . $tid . "_" . $message['REPLY_TO_PID'] . "\">";
                    echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
                } else {
                    echo "<a href=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "?msg=$tid." . $message['REPLY_TO_PID'] . "\">";
                    echo $tid . "." . $message['REPLY_TO_PID'] . "</a>";
                }
            }
            echo "</p></td></tr>\n";
        }
        echo "<tr><td class=\"postbody\">\n";
        echo $message['CONTENT'] . "\n";
        echo "</td></tr>\n";
        if($in_list){
            echo "<tr><td align=\"center\"><p class=\"postresponse\" style=\"text-align:center\">";
            if(!($closed || ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_WASP))){
                echo "<a href=\"post.php?replyto=$tid.".$message['PID']."\" target=\"main\">Reply</a>";
            }
            if($HTTP_COOKIE_VARS['bh_sess_uid'] == $message['FROM_UID'] || perm_is_moderator()){
                echo "&nbsp;&nbsp;<a href=\"delete.php?msg=$tid.".$message['PID']."&back=$tid.$first_msg\" target=\"main\">Delete</a>";
                echo "&nbsp;&nbsp;<a href=\"edit.php?msg=$tid.".$message['PID']."\" target=\"main\">Edit</a>";
            }
            echo "</p></td></tr>";
        }
        echo "</table>\n";
    }
    echo "</td></tr></table></div>\n";
}

function message_display_deleted($tid,$pid)
{
    echo "<br /><div align=\"center\">";
    echo "<table width=\"96%\" border=\"1\" bordercolor=\"black\"><tr><td>\n";
    echo "<table class=\"posthead\" width=\"100%\" border=\"0\"><tr><td>\n";
    echo "Message ${tid}.${pid} was deleted\n";
    echo "</td></tr></table>\n";
    echo "</td></tr></table></div>\n";
}

function messages_start_panel()
{
    echo "<p>&nbsp;</p>\n";
    echo "<div align=\"center\"><table width=\"96%\" class=\"messagefoot\"><tr><td>";
}

function messages_end_panel()
{
    echo "</td></tr></table></div>";
}

function messages_nav_strip($tid,$pid,$length,$ppp)
{
    // Less than 20 messages, no nav needed
    if($pid == 1 && $length < $ppp){
        return;
    }

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if($spid > 1){
        if($pid > 1){
            $navbits[0] = "<a href=\"messages.php?msg=$tid.1\">" . mess_nav_range(1,$spid-1) . "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
    }

    // The middle section(s)
    $i = 0;
    while($spid + ($ppp - 1) <= $length){
        $i++;
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"messages.php?msg=$tid.$spid\">" . mess_nav_range($spid,$spid+($ppp - 1)) . "</a>";
        }
        $spid += $ppp;
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

    if($length <= $ppp){
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

    echo "<p align=\"center\">" . $html . "</p>\n";
}

function messages_interest_form($tid,$pid)
{
    $interest = thread_get_interest($tid);
    $chk = array("","","","");
    $chk[$interest+1] = " checked";
    global $HTTP_SERVER_VARS;

    echo "<p align=\"center\">\n";
    echo "<form name=\"rate_interest\" action=\"./interest.php?ret=";
    echo urlencode($HTTP_SERVER_VARS['PHP_SELF'])."?msg=$tid.$pid";
    echo "\" method=\"POST\">\n";
    echo "Rate my interest: \n";
    echo "<input type=\"radio\" name=\"interest\" value=\"-1\"". $chk[0] . "> Ignore \n";
    echo "<input type=\"radio\" name=\"interest\" value=\"0\"". $chk[1] . "> Normal \n";
    echo "<input type=\"radio\" name=\"interest\" value=\"1\"". $chk[2] . "> Interested \n";
    echo "<input type=\"radio\" name=\"interest\" value=\"2\"". $chk[3] . "> Subscribe \n";
    echo "<input type=\"submit\" class=\"button\" value=\"Apply\" name=\"submit\">\n";
    echo "<input type=\"hidden\" name=\"tid\" value=\"$tid\">\n";
    echo "</form>\n";
    echo "</p>\n";
}

function messages_admin_form($tid,$pid)
{
    global $HTTP_SERVER_VARS;
    echo "<p align=\"center\">\n";
    echo "<form name=\"thread_admin\" action=\"./thread_admin.php?ret=";
    echo urlencode($HTTP_SERVER_VARS['PHP_SELF'])."?msg=$tid.$pid";
    echo "\" method=\"POST\">\n";
    echo "Move thread to: " . folder_draw_dropdown(0,"t_move");
    echo " <input class=\"button\" type=\"submit\" name=\"move\" value=\"Move\">\n";
    echo "&nbsp;&nbsp;<input class=\"button\" type=\"submit\" name=\"close\" value=\"Close for posting\">\n";
    echo "<input type=\"hidden\" name=\"t_tid\" value=\"$tid\">\n";
    echo "<input type=\"hidden\" name=\"t_pid\" value=\"$pid\">\n";
    echo "</p>\n";
    echo "</form>\n";
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

    $sql = "select from_uid from " . forum_table("POST") . " where tid = $tid and pid = $pid";

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

function messages_update_read($tid,$pid,$uid,$spid = 1)
{
    $db = db_connect();

    // Check for existing entry in USER_THREAD
    $sql = "select LAST_READ from " . forum_table("USER_THREAD") . " where UID = $uid and TID = $tid";

    $result = db_query($sql,$db);

    if(db_num_rows($result)){
        // Update if already existing
        $fa = db_fetch_array($result);
        if($pid > $fa['LAST_READ']){
            $sql = "update " . forum_table("USER_THREAD") . " set LAST_READ = $pid, LAST_READ_AT = NOW() ";
            $sql .= "where UID = $uid and TID = $tid";
            //echo "<p>$sql</p>";
            db_query($sql,$db);
        }
    } else {
        // Create new USER_THREAD entry
        $sql = "insert into " . forum_table("USER_THREAD") . " (UID,TID,LAST_READ,LAST_READ_AT,INTEREST) ";
        $sql .= "values ($uid, $tid, $pid, NOW(), 0)";
        db_query($sql,$db);
    }

    // Mark posts as Viewed...
    $sql = "update POST set VIEWED = NOW() where TID = $tid and PID between $spid and $pid and TO_UID = $uid and VIEWED is null";
    db_query($sql,$db);

    db_disconnect($db);
}

function messages_get_most_recent($uid)
{
    $return = "1.1";

    $db = db_connect();

    $sql = "select THREAD.TID, THREAD.MODIFIED, USER_THREAD.LAST_READ ";
    $sql .= "from " . forum_table("THREAD") . " THREAD ";
    $sql .= "left join " . forum_table("USER_THREAD") . " USER_THREAD on (USER_THREAD.TID = THREAD.TID and USER_THREAD.UID = $uid) ";
    $sql .= "order by THREAD.MODIFIED DESC LIMIT 0,1";

    $result = db_query($sql,$db);

    if(db_num_rows($result)){
        $fa = db_fetch_array($result);
        if($fa['LAST_READ']){
            $return = $fa['TID'] . "." . $fa['LAST_READ'];
        } else {
            $return = $fa['TID'] . ".1";
        }
    }
    return $return;
}
?>
