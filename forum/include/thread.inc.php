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

/* $Id: thread.inc.php,v 1.28 2003-08-02 00:02:53 decoyduck Exp $ */

// Included functions for displaying threads in the left frameset.

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/format.inc.php"); // Formatting functions
require_once("./include/folder.inc.php");

function thread_get_title($tid)
{
   $db_thread_get_title = db_connect();
   $sql = "SELECT thread.title FROM " . forum_table("THREAD") . " thread WHERE tid = $tid";
   $resource_id = db_query($sql, $db_thread_get_title);
   if(!db_num_rows($resource_id)){
     $threadtitle = "The Unknown Thread";
   } else {
     $data = db_fetch_array($resource_id);
     $threadtitle = _stripslashes($data['title']);
   }
   return $threadtitle;
}

function thread_get($tid)
{

   $db_thread_get = db_connect();

   $uid = bh_session_get_value('UID');

   $sql = "SELECT DISTINCT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.STICKY, ";
   $sql.= "UNIX_TIMESTAMP(THREAD.modified) AS MODIFIED, THREAD.CLOSED, USER_THREAD.INTEREST, ";
   $sql.= "USER_THREAD.LAST_READ, USER.LOGON, USER.NICKNAME, UP.RELATIONSHIP, AT.AID ";
   $sql.= "FROM ". forum_table("THREAD"). " THREAD ";
   $sql.= "LEFT JOIN ". forum_table("USER_THREAD"). " USER_THREAD ";
   $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = $uid)";
   $sql.= "JOIN " . forum_table("USER") . " USER ";
   $sql.= "JOIN " . forum_table("POST") . " POST ";
   $sql.= "LEFT JOIN " . forum_table("USER_PEER") . " UP ON ";
   $sql.= "(UP.UID = $uid AND UP.PEER_UID = POST.FROM_UID) ";
   $sql.= "LEFT JOIN " . forum_table("POST_ATTACHMENT_IDS") . " AT ON ";
   $sql.= "(AT.TID = THREAD.TID) ";
   $sql.= "WHERE USER.UID = POST.FROM_UID ";
   $sql.= "AND POST.TID = THREAD.TID ";
   $sql.= "AND POST.PID = 1 ";
   $sql.= "AND THREAD.TID = $tid ";
   $sql.= "GROUP BY THREAD.tid ";

   $resource_id = db_query($sql, $db_thread_get);

   if (!db_num_rows($resource_id)) {
     $threaddata = false;
   }else {

     $threaddata = db_fetch_array($resource_id);

     if (!isset($threaddata['INTEREST'])) {
       $threaddata['INTEREST'] = 0;
     }

     if (!isset($threaddata['LAST_READ'])) {
       $threaddata['LAST_READ'] = 0;
     }

   }

   return $threaddata;
}

function thread_get_author($tid)
{
        $db_thread_get_author = db_connect();

        $sql = "SELECT U.LOGON, U.NICKNAME FROM ".forum_table("USER")." U, ".forum_table("POST")." P ";
        $sql.= "WHERE U.UID = P.FROM_UID AND P.TID = $tid and P.PID = 1";

        $result = db_query($sql, $db_thread_get_author);
        $author = db_fetch_array($result);

        return format_user_name($author['LOGON'], $author['NICKNAME']);

}

function thread_get_interest($tid)
{
        $uid = bh_session_get_value('UID');
        $db_thread_get_interest = db_connect();
        $sql = "select INTEREST from USER_THREAD where UID = $uid and TID = $tid";
        $resource_id = db_query($sql, $db_thread_get_interest);
        $fa = db_fetch_array($resource_id);
        $return = isset($fa['INTEREST']) ? $fa['INTEREST'] : 0;
        return $return;
}

function thread_set_interest($tid, $interest, $new = false)
{
    $uid = bh_session_get_value('UID');

    if ($new) {
        $sql = "insert into ". forum_table("USER_THREAD"). " (UID, TID, INTEREST) ";
        $sql.= "values ($uid, $tid, $interest)";
    }else {
        $sql = "update low_priority ". forum_table("USER_THREAD"). " ";
        $sql.= "set INTEREST = $interest where UID = $uid and TID = $tid";
    }

    $db_thread_set_interest = db_connect();
    db_query($sql, $db_thread_set_interest);

}

function thread_can_view($tid = 0, $uid = 0)
{
    $fidlist = folder_get_available();
    $db_thread_can_view = db_connect();

    $sql = "select * from ".forum_table("THREAD")." where TID = '$tid' and FID in ($fidlist)";

    $result = db_query($sql,$db_thread_can_view);
    $count = db_num_rows($result);

    return ($count > 0);
}

function thread_set_sticky($tid, $sticky = true)
{
    $db_thread_set_sticky = db_connect();

    if ($sticky) {
        $sql = "UPDATE ".forum_table("THREAD")." SET STICKY = \"Y\" WHERE TID = $tid";
    } else {
        $sql = "UPDATE ".forum_table("THREAD")." SET STICKY = \"N\" WHERE TID = $tid";
    }

    $result = db_query($sql,$db_thread_set_sticky);

    return $result;
}

function thread_set_closed($tid, $closed = true)
{
    $db_thread_set_closed = db_connect();

    if ($closed) {
        $sql = "UPDATE ".forum_table("THREAD")." SET CLOSED = NOW() WHERE TID = $tid";
    } else {
        $sql = "UPDATE ".forum_table("THREAD")." SET CLOSED = NULL WHERE TID = $tid";
    }

    $result = db_query($sql,$db_thread_set_closed);

    return $result;
}

function thread_change_folder($tid, $new_fid)
{
    $db_thread_set_closed = db_connect();

    $sql = "UPDATE ". forum_table("THREAD"). " SET FID = $new_fid WHERE TID = $tid";
    $result = db_query($sql, $db_thread_set_closed);

    return $result;
}

function thread_change_title($tid, $new_title)
{
    $db_thread_change_title = db_connect();
    $new_title = _addslashes(_htmlentities($new_title));

    $sql = "UPDATE ". forum_table("THREAD"). " SET TITLE = '$new_title' WHERE TID = $tid";
    $result = db_query($sql, $db_thread_change_title);

    return $result;
}

?>