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

// Included functions for displaying threads in the left frameset.

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/format.inc.php"); // Formatting functions

function threads_get_available_folders()
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    $db = db_connect();

    $sql = "select DISTINCT F.FID from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";

    $result = db_query($sql,$db);
    $count = db_num_rows($result);

    if($count==0){
        $return = "0";
    } else {
        $row = db_fetch_array($result);
        $return = $row['FID'];

        while($row = db_fetch_array($result)){
            $return .= ",".$row['FID'];
        }
    }

    db_disconnect($db);

    return $return;
}

function threads_get_folders()
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

	$db = db_connect();
	//$query = "select distinct FID, TITLE from " . forum_table("FOLDER") . " order by FID";
    $sql = "select DISTINCT F.FID, F.TITLE from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED = 1)) order by F.FID";
	$result = db_query($sql, $db);

	if (!db_num_rows($result)) {
		 $folder_titles = FALSE;
	} else {
		while($query_data = db_fetch_array($result)) {
			$folder_titles[$query_data['FID']] = $query_data['TITLE'];
		}
	}

	return $folder_titles;
	db_disconnect($db);
}

function threads_get_all($uid) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
	// for threads with unread messages, so the UID needs to be passed to the function

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_unread($uid) // get unread messages for $uid
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL)";
	$sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_unread_to_me($uid) // get unread messages to $uid
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid), ";
	$sql .= forum_table("POST") . " POST ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
	$sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
	$sql .= "AND POST.TID = THREAD.TID AND POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_by_days($uid,$days = 1) // get threads from the last $days days
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
	// for threads with unread messages, so the UID needs to be passed to the function

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) <= $days ";
	$sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_by_interest($uid,$interest = 1) // get messages for $uid by interest (default High Interest)
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
	$sql .= "AND USER_THREAD.INTEREST = $interest ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_unread_by_interest($uid,$interest = 1) // get unread messages for $uid by interest (default High Interest)
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
	$sql .= "AND USER_THREAD.last_read < THREAD.length ";
	$sql .= "AND USER_THREAD.INTEREST = $interest ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_recently_viewed($uid) // get messages recently seem by $uid
{
    $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid in ($folders) ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
	$sql .= "AND TO_DAYS(NOW()) - TO_DAYS(USER_THREAD.LAST_READ_AT) <= 1 ";
	$sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_folder($uid,$fid) // get messages recently seem by $uid
{
//  $folders = threads_get_available_folders();
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid = $fid ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
//	$sql .= "AND TO_DAYS(NOW()) - TO_DAYS(USER_THREAD.LAST_READ_AT) <= 1 ";
	$sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_process_list($resource_id) // Arrange the results of a query into the right order for display
{
    if (db_num_rows($resource_id)) { // check that the set of threads returned is not empty
        // If the user has clicked on a folder header, we want that folder to be first in the list
	    global $HTTP_GET_VARS;
	    if (isset($HTTP_GET_VARS['folder'])) $folder_order[] = $HTTP_GET_VARS['folder'];

	    // Loop through the results and construct an array to return
    	for ($i = 0; $i < db_num_rows($resource_id); $i++) {
		$thread = db_fetch_array($resource_id);

		// If this folder ID has not been encountered before, make it the next folder in the order to be displayed
		if (!isset($folder_order)) {
			$folder_order[] = $thread['fid'];
        } else {
			if (!in_array($thread['fid'], $folder_order)) $folder_order[] = $thread['fid'];
		}

		$lst[$i]['tid'] = $thread['tid'];
		$lst[$i]['fid'] = $thread['fid'];
		$lst[$i]['title'] = stripslashes($thread['title']);
		$lst[$i]['length'] = $thread['length'];

		if (isset($thread['last_read'])) { // special case - last_read may be NULL, in which case PHP will complain that the array index doesn't exist if we don't do this
			$lst[$i]['last_read'] = $thread['last_read'];
		} else {
			$lst[$i]['last_read'] = 0;
		}

		$lst[$i]['modified'] = $thread['modified'];

	    }
    } else { // special case - no threads returned, but we have to return something
        $lst = 0;
        $folder_order = 0;
    }
	return array($lst, $folder_order); // $lst is the array with thread information, $folder_order is a list of FIDs in the order in which the folders should be displayed
}

function thread_get_title($tid)
{
   $db = db_connect();
   $sql = "SELECT THREAD.title FROM " . forum_table("THREAD") . " WHERE tid = $tid";
   $resource_id = db_query($sql,$db);
   if(!db_num_rows($resource_id)){
     $threadtitle = "The Unknown Thread";
   } else {
     $data = db_fetch_array($resource_id);
     $threadtitle = stripslashes($data['title']);
   }
   db_disconnect($db);
   return $threadtitle;
}

function thread_get($tid)
{
   $db = db_connect();
   $sql = "SELECT * FROM " . forum_table("THREAD") . " WHERE tid = $tid";
   $resource_id = db_query($sql,$db);
   if(!db_num_rows($resource_id)){
     $threaddata = false;
   } else {
     $threaddata = db_fetch_array($resource_id);
   }
   db_disconnect($db);
   return $threaddata;
}

function threads_get_folder_msgs()
{
	$db = db_connect();
	//$sql = "SELECT fid, COUNT(fid) AS total FROM " . forum_table("THREAD") . " GROUP BY fid";
    $sql = "SELECT ".forum_table("FOLDER").".fid, COUNT(".forum_table("THREAD").".fid) AS total FROM ".forum_table("FOLDER")." LEFT JOIN ".forum_table("THREAD")." ON ".forum_table("FOLDER").".fid = ".forum_table("THREAD").".fid GROUP BY ".forum_table("FOLDER").".fid";
	$resource_id = db_query($sql, $db);
	for ($i = 0; $i < db_num_rows($resource_id); $i++) {
		$folder = db_fetch_array($resource_id);
		$folder_msgs[$folder['fid']] = $folder['total'];
	}
	db_disconnect($db);
	return $folder_msgs;
}

function thread_get_author($tid)
{
	$db = db_connect();
	$sql = "SELECT U.LOGON, U.NICKNAME FROM ".forum_table("USER")." U, ".forum_table("POST")." P ";
	$sql.= "WHERE U.UID = P.FROM_UID AND P.TID = $tid and P.PID = 1";
	$resource_id = db_query($sql, $db);
	$author = db_fetch_array($resource_id);
	db_disconnect($db);
	return format_user_name($author['LOGON'], $author['NICKNAME']);
}

function thread_get_interest($tid)
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
	$db = db_connect();
	$sql = "select INTEREST from USER_THREAD where UID = $uid and TID = $tid";
	$resource_id = db_query($sql, $db);
	$fa = db_fetch_array($resource_id);
	db_disconnect($db);
	$return = isset($fa['INTEREST']) ? $fa['INTEREST'] : 0;
	return $return;
}

function thread_set_interest($tid,$interest,$new = false)
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    if($new){
    	$sql = "insert into USER_THREAD (UID,TID,INTEREST) values ($uid,$tid,$interest)";
    } else {
        $sql = "update USER_THREAD set INTEREST = $interest where UID = $uid and TID = $tid";
    }
	$db = db_connect();
	db_query($sql, $db);
	db_disconnect($db);

}

function threads_any_unread()
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    
    $sql = "select * from ".forum_table("THREAD")." T left join ".forum_table("USER_THREAD")." UT ";
    $sql.= "on (T.TID = UT.TID and UT.UID = $uid) ";
    $sql.= "where T.LENGTH > UT.LAST_READ ";
    $sql.= "limit 0,1";
    
    $db = db_connect();
    $result = db_query($sql,$db);
    $return = (db_num_rows($result) > 0);
    db_disconnect($db);
    
    return $return;
}

function threads_mark_all_read()
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    
    $sql = "select T.TID, T.LENGTH, UT.LAST_READ ";
    $sql.= "from ".forum_table("THREAD")." T left join ".forum_table("USER_THREAD")." UT ";
    $sql.= "on (UT.TID = T.TID and UT.UID = $uid) ";
    $sql.= "where T.LENGTH > UT.LAST_READ";

    $db = db_connect();
    $result = db_query($sql,$db);

    for($i=0;$row[$i] = db_fetch_array($result);$i++);

    for($j=0;$j<$i;$j++){
        if($row[$j]['LAST_READ']){
            $sql = "insert into ".forum_table("USER_THREAD")." (UID,TID,LAST_READ,LAST_READ_AT,INTEREST) ";
            $sql.= "values ($uid, ".$row[$j]['TID'].", ".$row[$j]['LENGTH'].",NOW(),0)";
        } else {
            $sql = "update  ".forum_table("USER_THREAD");
            $sql.= " set LAST_READ = ".$row[$j]['LENGTH'].", ";
            $sql.= "LAST_READ_AT = NOW() ";
            $sql.= "where TID = ".$row[$j]['TID']." and UID = $uid";
        }
        db_query($sql,$db);
    }
    
    db_disconnect($db);
}

?>