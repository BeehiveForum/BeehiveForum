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

/* $Id: attachments.inc.php,v 1.36 2004-02-22 15:24:34 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/config.inc.php");

function get_attachments($uid, $aid)
{
    global $HTTP_SERVER_VARS, $attachment_dir;
    
    if (!isset($attachment_dir)) $attachment_dir = "attachments";

    $userattachments = false;

    $db_get_attachments = db_connect();

    $uid = addslashes($uid);
    $aid = addslashes($aid);

    $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE UID = '$uid' AND AID = '$aid'";
    $result = db_query($sql, $db_get_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($userattachments)) $userattachments = array();
        
        if (@file_exists($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME'])))) {

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME']))),
                                       "filedate"  => filemtime($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME']))),                                       
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS'],
                                       "deleted"   => false);
        }else {
        
            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => 0,
                                       "filedate"  => 0,                                       
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS'],
                                       "deleted"   => true);
        }
    }

    return $userattachments;
}

function get_all_attachments($uid, $aid)
{
    global $HTTP_SERVER_VARS, $attachment_dir;
    
    if (!isset($attachment_dir)) $attachment_dir = "attachments";

    $userattachments = false;

    $db_get_all_attachments = db_connect();

    $uid = addslashes($uid);
    $aid = addslashes($aid);

    $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE UID = '$uid' AND AID <> '$aid'";
    $result = db_query($sql, $db_get_all_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($userattachments)) $userattachments = array();

        if (@file_exists($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME'])))) {

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME']))),
                                       "filedate"  => filemtime($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME']))),                                       
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS'],
                                       "deleted"   => false);
        }else {
        
            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => 0,
                                       "filedate"  => 0,                                       
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS'],
                                       "deleted"   => true);
        }
    }

    return $userattachments;
}

function get_users_attachments($uid)
{
    global $HTTP_SERVER_VARS, $attachment_dir;
    
    if (!isset($attachment_dir)) $attachment_dir = "attachments";

    $userattachments = false;

    $db_get_users_attachments = db_connect();

    $uid = addslashes($uid);

    $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE UID = '$uid'";
    $result = db_query($sql, $db_get_users_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($userattachments)) $userattachments = array();

        if (@file_exists($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME'])))) {

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME']))),
                                       "filedate"  => filemtime($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME']))),                                       
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS'],
                                       "deleted"   => false);
        }else {
        
            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => 0,
                                       "filedate"  => 0,                                       
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS'],
                                       "deleted"   => true);
        }
    }

    return $userattachments;
}


function add_attachment($uid, $aid, $filename, $mimetype)
{
    $db_add_attachment = db_connect();

    $hash = md5($aid. $filename);

    $uid      = addslashes($uid);
    $aid      = addslashes($aid);
    $filename = addslashes($filename);
    $mimetype = addslashes($mimetype);

    $sql = "INSERT INTO ". forum_table("POST_ATTACHMENT_FILES"). " (AID, UID, FILENAME, MIMETYPE, HASH) ";
    $sql.= "VALUES ('$aid', '$uid', '$filename', '$mimetype', '$hash')";

    $result = db_query($sql, $db_add_attachment);

    return $result;
}

function delete_attachment($uid, $aid, $filename)
{
    global $attachment_dir;
    
    if (!isset($attachment_dir)) $attachment_dir = "attachments";

    $db_delete_attachment = db_connect();

    $uid      = addslashes($uid);
    $aid      = addslashes($aid);
    $filename = addslashes($filename);
    
    if (@file_exists($attachment_dir. '/'. md5($aid. rawurldecode($filename)))) {
        return unlink($attachment_dir. '/'. md5($aid. rawurldecode($filename)));
    }    

    /*$sql = "DELETE FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE UID = $uid ";
    $sql.= "AND AID = '$aid' AND FILENAME = '$filename'";

    $result = db_query($sql, $db_delete_attachment);

    if (db_affected_rows($db_delete_attachment) > 0) {

        $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE AID = '$aid'";
        $result = db_query($sql, $db_delete_attachment);

        if (db_num_rows($result) == 0) {

            $sql = "DELETE FROM ". forum_table("POST_ATTACHMENT_IDS"). " WHERE AID = '$aid'";
            $result = db_query($sql, $db_delete_attachment);

            $sql = "DELETE FROM ". forum_table("PM_ATTACHMENT_IDS"). " WHERE AID = '$aid'";
            $result = db_query($sql, $db_delete_attachment);

            if (file_exists($attachment_dir. '/'. md5($aid. rawurldecode($filename)))) {
                unlink($attachment_dir. '/'. md5($aid. rawurldecode($filename)));
            }
	}
    }
    
    return $result; */
}

function get_free_attachment_space($uid)
{
    global $HTTP_SERVER_VARS, $attachment_dir;
    
    if (!isset($attachment_dir)) $attachment_dir = "attachments";
    
    $used_attachment_space = 0;

    $db_get_free_attachment_space = db_connect();

    $uid = addslashes($uid);

    $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE UID = '$uid'";
    $result = db_query($sql, $db_get_free_attachment_space);

    while($row = db_fetch_array($result)) {

        if (@file_exists($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME'])))) {
            $used_attachment_space += filesize($attachment_dir. '/'. md5($row['AID']. rawurldecode($row['FILENAME'])));
        }
    }
    
    if ((MAX_ATTACHMENT_SIZE - $used_attachment_space) < 0) return 0;
    return MAX_ATTACHMENT_SIZE - $used_attachment_space;
}

function get_attachment_id($tid, $pid)
{
    $db_get_attachment_id = db_connect();

    $tid = addslashes($tid);
    $pid = addslashes($pid);

    $sql = "SELECT AID FROM ". forum_table("POST_ATTACHMENT_IDS"). " WHERE TID = '$tid' AND PID = '$pid'";
    $result = db_query($sql, $db_get_attachment_id);

    if (db_num_rows($result) > 0) {

        $attachment = db_fetch_array($result);
        return $attachment['AID'];

    }else{

        return false;
    }
}

function get_pm_attachment_id($mid)
{
    $db_get_pm_attachment_id = db_connect();

    $mid = addslashes($mid);

    $sql = "SELECT AID FROM ". forum_table("PM_ATTACHMENT_IDS"). " WHERE MID = '$mid'";
    $result = db_query($sql, $db_get_pm_attachment_id);

    if (db_num_rows($result) > 0) {

        $attachment = db_fetch_array($result);
        return $attachment['AID'];

    }else{

        return false;
    }
}

function get_message_link($aid)
{
    $db_get_message_link = db_connect();

    $aid = addslashes($aid);

    $sql = "SELECT TID, PID FROM ". forum_table("POST_ATTACHMENT_IDS"). " WHERE AID = '$aid'";
    $result = db_query($sql, $db_get_message_link);

    if (db_num_rows($result) > 0) {

        $tidpid = db_fetch_array($result);
        return "./messages.php?msg=". $tidpid['TID']. ".". $tidpid['PID'];

    }else{

        $sql = "SELECT MID FROM ". forum_table("PM_ATTACHMENT_IDS"). " WHERE AID = '$aid'";
        $result = db_query($sql, $db_get_message_link);

        if (db_num_rows($result) > 0) {

            $mid = db_fetch_array($result);
            return "./pm.php?mid=". $mid['MID'];
        }
    }

    return "";
}

function get_num_attachments($aid)
{
    $db_get_num_attachments = db_connect();

    $aid = addslashes($aid);

    $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE AID = '$aid'";
    $result = db_query($sql, $db_get_num_attachments);

    return db_num_rows($result);
}

function get_attachment_by_hash($hash)
{
    $db_get_attachment_by_hash = db_connect();
    $hash = addslashes($hash);

    $sql = "SELECT * FROM ". forum_table("POST_ATTACHMENT_FILES"). " WHERE HASH = '$hash' LIMIT 0, 1";
    $result = db_query($sql, $db_get_attachment_by_hash);

    if (db_num_rows($result)) {
	return db_fetch_array($result);
    }else {
        return false;
    }
}

function attachment_inc_dload_count($hash)
{
    $db_attachment_inc_dload_count = db_connect();
    $hash = addslashes($hash);

    $sql = "UPDATE LOW_PRIORITY ". forum_table("POST_ATTACHMENT_FILES"). " ";
    $sql.= "SET DOWNLOADS = DOWNLOADS + 1 WHERE HASH = '$hash'";

    $result = db_query($sql, $db_attachment_inc_dload_count);

    return (db_affected_rows($db_attachment_inc_dload_count) > 0);
}

// Checks to see if an attachment has been embedded in the content
// True: attachment is embedded. False: no attachments embedded

function attachment_embed_check($content)
{
    global $attachment_allow_embed;
    
    if (!isset($attachment_allow_embed)) $attachment_allow_embed = false;

    if ($attachment_allow_embed) return false;
    $content_check = preg_replace('/\&\#([0-9]+)\;/me', "chr('\\1')", rawurldecode($content));
    
    if (preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+getattachment.php.+>/ ", $content_check)) {
        return true;
    }
    
    return false;
}

?>