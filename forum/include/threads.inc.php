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
require_once("./include/thread.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/constants.inc.php");

function threads_get_available_folders()
{
    return folder_get_available();

    /*global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    $db_threads_get_available_folders = db_connect();

    $sql = "select DISTINCT F.FID from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";

    $result = db_query($sql, $db_threads_get_available_folders);
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

    return $return;*/
}

function threads_get_folders()
{

    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db_threads_get_folders = db_connect();

    $sql = "select DISTINCT F.FID, F.TITLE, UF.INTEREST from ".forum_table("FOLDER")." F left join ";
    $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = $uid) ";
    $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED = 1)) order by F.FID";

    $result = db_query($sql, $db_threads_get_folders);

    if (!db_num_rows($result)) {
         $folder_info = FALSE;
    } else {
        while($query_data = db_fetch_array($result)) {
	    //$folder_info[$query_data['FID']] = $query_data['TITLE'];
            $folder_info[$query_data['FID']] = array('TITLE' => $query_data['TITLE'], 'INTEREST' => $query_data['INTEREST']);
        }
    }

    return $folder_info;
}

function threads_get_all($uid, $start = 0) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{

    $folders = threads_get_available_folders();
    $db_threads_get_all = db_connect();

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN " . forum_table("USER_FOLDER") . " USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND NOT (USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_all);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread($uid) // get unread messages for $uid
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread = db_connect();

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, USER_FOLDER.interest AS folder_interest, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN " . forum_table("USER_FOLDER") . " USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND NOT (USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread_to_me($uid) // get unread messages to $uid
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread_to_me = db_connect();

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid), ";
    $sql .= forum_table("POST") . " POST ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST2 ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND USER.uid = POST2.from_uid ";
    $sql .= "AND POST2.tid = THREAD.tid ";
    $sql .= "AND POST2.pid = 1 ";
    $sql .= "AND POST.tid = THREAD.tid AND POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread_to_me);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_by_days($uid,$days = 1) // get threads from the last $days days
{

    $folders = threads_get_available_folders();
    $db_threads_get_by_days = db_connect();

    // Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
    // for threads with unread messages, so the UID needs to be passed to the function

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN " . forum_table("USER_FOLDER") . " USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) <= $days ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND NOT (USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_by_days);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_by_interest($uid,$interest = 1) // get messages for $uid by interest (default High Interest)
{

    $folders = threads_get_available_folders();
    $db_threads_get_by_interest = db_connect();

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
    $sql .= forum_table("USER_THREAD") . " USER_THREAD ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql .= "AND USER_THREAD.INTEREST = $interest ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_by_interest);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread_by_interest($uid,$interest = 1) // get unread messages for $uid by interest (default High Interest)
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread_by_interest = db_connect();

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
    $sql .= forum_table("USER_THREAD") . " USER_THREAD ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql .= "AND USER_THREAD.last_read < THREAD.length ";
    $sql .= "AND USER_THREAD.INTEREST = $interest ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread_by_interest);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_recently_viewed($uid) // get messages recently seem by $uid
{

    $folders = threads_get_available_folders();
    $db_threads_get_recently_viewed = db_connect();

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read,  USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD, ";
    $sql .= forum_table("USER_THREAD") . " USER_THREAD ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
    $sql .= "AND TO_DAYS(NOW()) - TO_DAYS(USER_THREAD.LAST_READ_AT) <= 1 ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_recently_viewed);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_by_relationship($uid,$relationship = USER_FRIEND,$start = 0) // get threads started by people of a particular relationship (default friend)
{

    $folders = threads_get_available_folders();
    $db_threads_get_all = db_connect();

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN " . forum_table("USER_FOLDER") . " USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (UP.relationship & $relationship = $relationship)";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND NOT (USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_all);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_unread_by_relationship($uid,$relationship = USER_FRIEND) // get unread messages started by people of a particular relationship (default friend)
{

    $folders = threads_get_available_folders();
    $db_threads_get_unread = db_connect();

    // Formulate query

    $sql  = "SELECT DISTINCT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, USER_FOLDER.interest AS folder_interest, ";
    $sql .= "UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, UP.relationship, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "LEFT JOIN " . forum_table("USER_FOLDER") . " USER_FOLDER ON ";
    $sql .= "(USER_FOLDER.FID = THREAD.FID AND USER_FOLDER.UID = $uid) ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
    $sql .= "(UP.uid = $uid AND UP.peer_uid = POST.from_uid) ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid in ($folders) ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND POST.pid = 1 ";
    $sql .= "AND (UP.relationship & $relationship = $relationship)";
    $sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "AND NOT (USER_FOLDER.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT 0, 50";

    $resource_id = db_query($sql, $db_threads_get_unread);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_get_folder($uid, $fid, $start = 0)
{

    $db_threads_get_folder = db_connect();

    // Formulate query

    $sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, THREAD.poll_flag, ";
    $sql .= "USER_THREAD.last_read, USER_THREAD.interest, UNIX_TIMESTAMP(THREAD.modified) AS modified, ";
    $sql .= "USER.logon, USER.nickname, AT.aid ";
    $sql .= "FROM " . forum_table("THREAD") . " THREAD ";
    $sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql .= "JOIN " . forum_table("USER") . " USER ";
    $sql .= "JOIN " . forum_table("POST") . " POST ";
    $sql .= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
    $sql .= "(AT.TID = THREAD.TID) ";
    $sql .= "WHERE THREAD.fid = $fid ";
    $sql .= "AND USER.uid = POST.from_uid ";
    $sql .= "AND POST.tid = THREAD.tid ";
    $sql .= "AND NOT (USER_THREAD.INTEREST <=> -1) ";
    $sql .= "GROUP BY THREAD.tid ";
    $sql .= "ORDER BY THREAD.modified DESC ";
    $sql .= "LIMIT $start, 50";

    $resource_id = db_query($sql, $db_threads_get_folder);
    list($threads, $folder_order) = threads_process_list($resource_id);
    return array($threads, $folder_order);

}

function threads_process_list($resource_id) // Arrange the results of a query into the right order for display
{

    $max = db_num_rows($resource_id);

    if($max){ // check that the set of threads returned is not empty

        // If the user has clicked on a folder header, we want that folder to be first in the list

        global $HTTP_GET_VARS;

        if(isset($HTTP_GET_VARS['folder'])){
            $folder_order[] = $HTTP_GET_VARS['folder'];
        }

        // Loop through the results and construct an array to return

        for($i = 0; $i < $max; $i++){

            $thread = db_fetch_array($resource_id);

            // If this folder ID has not been encountered before, make it the next folder in the order to be displayed
            if(!isset($folder_order)){
                $folder_order[] = $thread['fid'];
            }else{
                if(!in_array($thread['fid'], $folder_order)){
                    $folder_order[] = $thread['fid'];
                }
            }

            $lst[$i]['tid'] = $thread['tid'];
            $lst[$i]['fid'] = $thread['fid'];
            $lst[$i]['title'] = _stripslashes($thread['title']);
            $lst[$i]['length'] = $thread['length'];
            $lst[$i]['poll_flag'] = $thread['poll_flag'];

            if (isset($thread['last_read'])) { // special case - last_read may be NULL, in which case PHP will complain that the array index doesn't exist if we don't do this
                $lst[$i]['last_read'] = $thread['last_read'];
            }else{
                $lst[$i]['last_read'] = 0;
            }

            $lst[$i]['interest'] = isset($thread['interest']) ? $thread['interest'] : 0;
            $lst[$i]['modified'] = $thread['modified'];
            $lst[$i]['logon'] = $thread['logon'];
            $lst[$i]['nickname'] = $thread['nickname'];
            $lst[$i]['relationship'] = isset($thread['relationship']) ? $thread['relationship'] : 0;
	    $lst[$i]['attachments'] = isset($thread['aid']) ? true : false;

        }

    }else{ // special case - no threads returned, but we have to return something
        $lst = 0;
        $folder_order = 0;
    }

    return array($lst, $folder_order); // $lst is the array with thread information, $folder_order is a list of FIDs in the order in which the folders should be displayed

}

function threads_get_folder_msgs()
{
    $db_threads_get_folder_msgs = db_connect();
    $sql = 'SELECT FID, COUNT(*) AS TOTAL FROM '.forum_table('THREAD').' GROUP BY FID';
    $resource_id = db_query($sql, $db_threads_get_folder_msgs);
    while($folder = db_fetch_array($resource_id)){
        $folder_msgs[$folder['FID']] = $folder['TOTAL'];
    }
    return $folder_msgs;
}

function threads_any_unread()
{
    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $sql = "select * from ".forum_table("THREAD")." T left join ".forum_table("USER_THREAD")." UT ";
    $sql.= "on (T.TID = UT.TID and UT.UID = '$uid') ";
    $sql.= "where T.LENGTH > UT.LAST_READ ";
    $sql.= "limit 0,1";

    $db_threads_any_unread = db_connect();
    $result = db_query($sql, $db_threads_any_unread);
    $return = (db_num_rows($result) > 0);

    return $return;
}

function threads_mark_all_read()
{

    global $HTTP_COOKIE_VARS;

    $db_threads_mark_all_read = db_connect();

    $sql = "SELECT TID, LENGTH FROM ". forum_table("THREAD");
    $result_threads = db_query($sql, $db_threads_mark_all_read);

    while($row = db_fetch_array($result_threads)) {

      $sql = "SELECT TID, LAST_READ, INTEREST FROM ". forum_table("USER_THREAD");
      $sql.= " WHERE TID = ". $row['TID']. " AND UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];

      $result_lastread = db_query($sql, $db_threads_mark_all_read);

      if (!db_num_rows($result_lastread)) {

        $sql = "INSERT INTO ".forum_table("USER_THREAD")." (UID, TID, LAST_READ, LAST_READ_AT) ";
        $sql.= "VALUES (". $HTTP_COOKIE_VARS['bh_sess_uid']. ", ". $row['TID']. ", ". $row['LENGTH'] .", NOW())";
        db_query($sql, $db_threads_mark_all_read);

      }else {

        $sql = "UPDATE LOW_PRIORITY ".forum_table("USER_THREAD");
        $sql.= " SET LAST_READ = ". $row['LENGTH']. ", ";
        $sql.= "LAST_READ_AT = NOW() ";
        $sql.= "WHERE TID = ". $row['TID']." and UID = ". $HTTP_COOKIE_VARS['bh_sess_uid'];

        db_query($sql, $db_threads_mark_all_read);

      }

    }

}

function threads_mark_50_read()
{

    global $HTTP_COOKIE_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db_threads_mark_50_read = db_connect();

    $sql = "SELECT DISTINCT THREAD.TID, THREAD.LENGTH FROM " . forum_table("THREAD") . " THREAD ";
    $sql.= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
    $sql.= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
    $sql.= "WHERE (USER_THREAD.LAST_READ < THREAD.LENGTH OR USER_THREAD.LAST_READ IS NULL) ";
    $sql.= "ORDER BY THREAD.MODIFIED DESC LIMIT 0, 50";

    $result = db_query($sql, $db_threads_mark_50_read);

    while ($row = db_fetch_array($result)) {

      messages_update_read($row['TID'], $row['LENGTH'], $HTTP_COOKIE_VARS['bh_sess_uid']);

    }

}

function threads_mark_read($tidarray)
{

    global $HTTP_COOKIE_VARS;

    $db_threads_mark_read = db_connect();

    foreach($tidarray as $ctid) {

      $sql = "SELECT LENGTH FROM ". forum_table("THREAD"). " WHERE TID = $ctid";
      $result = db_query($sql, $db_threads_mark_read);

      list($ctlength) = db_fetch_array($result);

      messages_update_read($ctid, $ctlength, $HTTP_COOKIE_VARS['bh_sess_uid']);

    }

}

?>
