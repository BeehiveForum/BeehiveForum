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

require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/config.inc.php");

function get_attachments($uid, $aid) {

    global $HTTP_SERVER_VARS, $attachment_dir;

    $userattachments = '';

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = $uid and AID = '$aid'";
    $result = db_query($sql, $db);
    
    while($row = db_fetch_array($result)) {
    
      if (!is_array($userattachments)) $userattachments = array();
      
      if (file_exists($attachment_dir. '/'. md5($row['AID']. $row['FILENAME']))) {
      
        $userattachments[] = array("filename" => $row['FILENAME'],
                                   "filesize" => filesize($attachment_dir. '/'. md5($row['AID']. $row['FILENAME'])),
                                   "aid"      => $row['AID'],
                                   "hash"     => $row['HASH']);
      }
                                 
    }
    
    return $userattachments;
    
}

function get_all_attachments($uid, $aid) {

    global $HTTP_SERVER_VARS, $attachment_dir;

    $userattachments = '';
    
    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = $uid and AID <> '$aid'";
    $result = db_query($sql, $db);
    
    while($row = db_fetch_array($result)) {
    
      if (!is_array($userattachments)) $userattachments = array();
      
      if (file_exists($attachment_dir. '/'. md5($row['AID']. $row['FILENAME']))) {
    
        $userattachments[] = array("filename" => $row['FILENAME'],
                                   "filesize" => filesize($attachment_dir. '/'. md5($row['AID']. $row['FILENAME'])),
                                   "aid"      => $row['AID'],
                                   "hash"     => $row['HASH']);
      }
      
    }
    
    return $userattachments;
    
}
    
function add_attachment($uid, $aid, $filename, $mimetype) {

    $db = db_connect();
    
    $hash = md5($aid. $filename);
    
    $sql = "insert into ". forum_table("POST_ATTACHMENT_FILES"). " (ID, AID, UID, FILENAME, MIMETYPE, HASH) ";
    $sql.= "values ('', '$aid', '$uid', '$filename', '$mimetype', '$hash')";
    
    $result = db_query($sql, $db);
    
    return $result;
    
}

function delete_attachment($uid, $aid, $filename) {

    $db = db_connect();
    
    $sql = "delete from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = $uid ";
    $sql.= "and AID = '$aid' AND FILENAME = '$filename'";
    $result = db_query($sql, $db);
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where AID = '$aid'";
    $result = db_query($sql, $db);
    
    if (db_num_rows($result) == 0) {
    
      $sql = "delete from ". forum_table("POST_ATTACHMENT_IDS"). " where AID = '$aid'";
      $result = db_query($sql, $db);
      
    }

    return $result;
    
}

function get_free_attachment_space($uid) {

    global $HTTP_SERVER_VARS, $attachment_dir;

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = $uid";
    $result = db_query($sql, $db) or die(mysql_error());
    
    while($row = db_fetch_array($result)) {
    
      if (file_exists($attachment_dir. '/'. md5($row['AID']. $row['FILENAME']))) {
    
        $used_attachment_space += filesize($attachment_dir. '/'. md5($row['AID']. $row['FILENAME']));
        
      }
      
    }

    return MAX_ATTACHMENT_SIZE - $used_attachment_space;                      
}

function get_attachment_id($tid, $pid) {

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_IDS"). " where TID = $tid AND PID = $pid";
    $result = db_query($sql, $db);
    
    if (db_num_rows($result) > 0) {
    
      $attachment = db_fetch_array($result);
      return $attachment['AID'];
      
    }else{
    
      return -1;
      
    }
    
}

function get_message_tidpid($aid) {

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_IDS"). " where AID = '$aid'";
    $result = db_query($sql, $db);
    
    if (db_num_rows($result) > 0) {
    
      $tidpid = db_fetch_array($result);
      return $tidpid['TID']. ".". $tidpid['PID'];
      
    }else{
    
      return "";
      
    }
    
}

function get_num_attachments($aid) {

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where AID = '$aid'";
    $result = db_query($sql, $db);
    return db_num_rows($result);
    
}

?>