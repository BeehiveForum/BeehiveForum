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

/* $Id: attachments.inc.php,v 1.59 2004-04-14 19:21:26 decoyduck Exp $ */

include_once("./include/edit.inc.php");
include_once("./include/perm.inc.php");

function get_attachments($uid, $aid)
{
    global $HTTP_SERVER_VARS, $forum_settings;

    $userattachments = false;

    $db_get_attachments = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES ";
    $sql.= "WHERE UID = '$uid' AND AID = '$aid' AND DELETED = 0";

    $result = db_query($sql, $db_get_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($userattachments)) $userattachments = array();
        
        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "filedate"  => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS']);
        }
    }

    return $userattachments;
}

function get_all_attachments($uid, $aid)
{
    global $HTTP_SERVER_VARS, $forum_settings;

    $userattachments = false;

    $db_get_all_attachments = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES ";
    $sql.= "WHERE UID = '$uid' AND AID <> '$aid' AND DELETED = 0";

    $result = db_query($sql, $db_get_all_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($userattachments)) $userattachments = array();

        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "filedate"  => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS']);
        }
    }

    return $userattachments;
}

function get_users_attachments($uid)
{
    global $HTTP_SERVER_VARS, $forum_settings;

    $userattachments = false;

    $db_get_users_attachments = db_connect();

    if (!is_numeric($uid)) return false;
    
    if (!$table_data = get_table_prefix()) return $userattachments;

    $sql = "SELECT DISTINCT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES ";
    $sql.= "WHERE UID = '$uid' AND DELETED = 0";

    $result = db_query($sql, $db_get_users_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($userattachments)) $userattachments = array();
        
        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            $userattachments[] = array("filename"  => rawurldecode($row['FILENAME']),
                                       "filesize"  => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "filedate"  => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                       "aid"       => $row['AID'],
                                       "hash"      => $row['HASH'],
                                       "mimetype"  => $row['MIMETYPE'],
                                       "downloads" => $row['DOWNLOADS']);
        }
    }

    return $userattachments;
}

function add_attachment($uid, $aid, $fileid, $filename, $mimetype)
{
    $db_add_attachment = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    $hash = md5("$aid$fileid$filename");
    $filename = rawurlencode($filename);

    $filename = addslashes($filename);
    $mimetype = addslashes($mimetype);
    
    if (!$table_data = get_table_prefix()) return false;
    
    $sql = "INSERT INTO {$table_data['PREFIX']}POST_ATTACHMENT_FILES (AID, UID, FILENAME, MIMETYPE, HASH) ";
    $sql.= "VALUES ('$aid', '$uid', '$filename', '$mimetype', '$hash')";

    $result = db_query($sql, $db_add_attachment);
        
    return $result;
}

function delete_attachment($uid, $hash)
{
    global $forum_settings;
    
    if (!is_numeric($uid)) return false;
    if (!is_md5($hash)) return false;

    $db_delete_attachment = db_connect();

    if(!$table_data = get_table_prefix()) return false;
   
    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.

    $sql = "SELECT PAF.AID, PAI.TID, PAI.PID FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST_ATTACHMENT_IDS PAI ";
    $sql.= "ON (PAI.AID = PAF.AID) WHERE PAF.HASH = '$hash' AND PAF.UID = '$uid'";
    
    $result = db_query($sql, $db_delete_attachment);
    
    if (db_num_rows($result) > 0 || perm_is_moderator()) {

        $row = db_fetch_array($result);

	// Mark the related post as edited
	
	if (isset($row['TID']) && isset($row['PID'])) {
	    post_add_edit_text($row['TID'], $row['PID']);
	}

	// Delete the attachment record from the database

	$sql = "DELETE FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES ";
	$sql.= "WHERE HASH = '$hash'";

	$result = db_query($sql, $db_delete_attachment);

	// Check to see if there are anymore attachments with the same AID

        $sql = "SELECT AID FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES ";
	$sql.= "WHERE AID = '{$row['AID']}'";

	$result = db_query($sql, $db_delete_attachment);

	// No more attachments connected to the AID, so we can remove it from
	// the PAI database.

	if (db_num_rows($result) == 0) {

	    $sql = "DELETE FROM {$table_data['PREFIX']}POST_ATTACHMENT_IDS ";
	    $sql.= "WHERE AID = '{$row['AID']}'";

	    $result = db_query($sql, $db_delete_attachment);
	}

	// Finally delete the file

        @unlink("$attachment_dir/$hash");
    }    
}

function get_free_attachment_space($uid)
{
    global $HTTP_SERVER_VARS, $forum_settings;
    
    $used_attachment_space = 0;

    $db_get_free_attachment_space = db_connect();

    if (!is_numeric($uid)) return false;
    
    if (!$table_data = get_table_prefix()) return 0;

    $max_attachment_space = forum_get_setting('attachments_max_user_space', false, 1048576);

    $sql = "SELECT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES WHERE UID = '$uid'";
    $result = db_query($sql, $db_get_free_attachment_space);

    while($row = db_fetch_array($result)) {

        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {
            $used_attachment_space += filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']);
        }
    }
    
    if (($max_attachment_space - $used_attachment_space) < 0) return 0;
    return $max_attachment_space - $used_attachment_space;
}

function get_attachment_id($tid, $pid)
{
    $db_get_attachment_id = db_connect();

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT AID FROM {$table_data['PREFIX']}POST_ATTACHMENT_IDS WHERE TID = '$tid' AND PID = '$pid'";
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

    if (!is_numeric($mid)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT AID FROM {$table_data['PREFIX']}PM_ATTACHMENT_IDS WHERE MID = '$mid'";
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

    if (!is_md5($aid)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $webtag = get_webtag();

    $sql = "SELECT TID, PID FROM {$table_data['PREFIX']}POST_ATTACHMENT_IDS WHERE AID = '$aid'";
    $result = db_query($sql, $db_get_message_link);

    if (db_num_rows($result) > 0) {

        $tidpid = db_fetch_array($result);
        return "./messages.php?webtag=$webtag&msg=". $tidpid['TID']. ".". $tidpid['PID'];

    }else{

        $sql = "SELECT MID FROM {$table_data['PREFIX']}PM_ATTACHMENT_IDS WHERE AID = '$aid'";
        $result = db_query($sql, $db_get_message_link);

        if (db_num_rows($result) > 0) {

            $mid = db_fetch_array($result);
            return "./pm.php?webtag=$webtag&mid=". $mid['MID'];
        }
    }

    return false;
}

function get_num_attachments($aid)
{
    $db_get_num_attachments = db_connect();

    if (!is_md5($aid)) return false;
    
    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES WHERE AID = '$aid'";
    $result = db_query($sql, $db_get_num_attachments);

    return db_num_rows($result);
}

function get_attachment_by_hash($hash)
{
    $db_get_attachment_by_hash = db_connect();

    if (!is_md5($hash)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM {$table_data['PREFIX']}POST_ATTACHMENT_FILES WHERE HASH = '$hash' LIMIT 0, 1";
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

    if (!is_md5($hash)) return false;
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}POST_ATTACHMENT_FILES ";
    $sql.= "SET DOWNLOADS = DOWNLOADS + 1 WHERE HASH = '$hash'";

    return db_query($sql, $db_attachment_inc_dload_count);
}

// Checks to see if an attachment has been embedded in the content
// True: attachment is embedded. False: no attachments embedded

function attachment_embed_check($content)
{
    if (forum_get_setting('attachments_allow_embed', 'Y', false)) return false;
    $content_check = preg_replace('/\&\#([0-9]+)\;/me', "chr('\\1')", rawurldecode($content));
    
    if (preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+getattachment.php.+>/ ", $content_check)) {
        return true;
    }
    
    return false;
}

?>