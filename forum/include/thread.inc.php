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

function thread_get_title($tid)
{
   $db_thread_get_title = db_connect();
   $sql = "SELECT THREAD.title FROM " . forum_table("THREAD") . " WHERE tid = $tid";
   $resource_id = db_query($sql, $db_thread_get_title);
   if(!db_num_rows($resource_id)){
     $threadtitle = "The Unknown Thread";
   } else {
     $data = db_fetch_array($resource_id);
     $threadtitle = stripslashes($data['title']);
   }
   return $threadtitle;
}

function thread_get($tid)
{
   global $HTTP_COOKIE_VARS;
   $db_thread_get = db_connect();
   $sql = "SELECT THREAD.TID, THREAD.FID, THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, ";
   $sql.= "UNIX_TIMESTAMP(THREAD.MODIFIED) AS MODIFIED, THREAD.CLOSED, USER_THREAD.INTEREST AS INTEREST, USER_THREAD.LAST_READ FROM ";
   $sql.= forum_table("THREAD") . " THREAD LEFT JOIN ". forum_table("USER_THREAD"). " USER_THREAD ";
   $sql.= "ON (THREAD.TID = USER_THREAD.TID AND USER_THREAD.UID = ";
   $sql.= $HTTP_COOKIE_VARS['bh_sess_uid'] . ") WHERE THREAD.TID = $tid";
   $resource_id = db_query($sql, $db_thread_get);
   if(!db_num_rows($resource_id)){
     $threaddata = false;
   } else {
     $threaddata = db_fetch_array($resource_id);
   }
   
   if(!isset($threaddata['INTEREST'])){
       $threaddata['INTEREST'] = 0;
   }
   if(!isset($threaddata['LAST_READ'])){
       $threaddata['LAST_READ'] = 0;
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
	global $HTTP_COOKIE_VARS;
	$uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
	$db_thread_get_interest = db_connect();
	$sql = "select INTEREST from USER_THREAD where UID = $uid and TID = $tid";
	$resource_id = db_query($sql, $db_thread_get_interest);
	$fa = db_fetch_array($resource_id);
	$return = isset($fa['INTEREST']) ? $fa['INTEREST'] : 0;
	return $return;
}

function thread_set_interest($tid, $interest, $new = false)
{
    global $HTTP_COOKIE_VARS;
    
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];
    
    if($new){
    
    	$sql = "insert into ". forum_table("USER_THREAD"). " (UID, TID, INTEREST) values ($uid, $tid, $interest)";
    	
    } else {
    
        $sql = "update low_priority ". forum_table("USER_THREAD"). " set INTEREST = $interest where UID = $uid and TID = $tid";
        
    }
    
    $db_thread_set_interest = db_connect();
    db_query($sql, $db_thread_set_interest);

}

?>