<?php

/*======================================================================
Copyright Project Beehive Forum 2002

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
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: attachments.inc.php,v 1.158 2008-09-06 20:13:56 decoyduck Exp $ */

/**
* attachments.inc.php - attachment upload handling
*
* Contains functions to handle the upload, deletion and modification of file attachments
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "gd_lib.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

/**
* Fetch upload temporary directory
*
* Fetches the upload temporary directory as defined in php.ini
* or as defined by the system environment variable 'TEMP' / 'TMP'
*
* @return mixed
* @param void
*/

function attachments_get_upload_tmp_dir()
{
    if (($upload_tmp_dir = @ini_get('upload_tmp_dir')) !== false) {
        if (is_writable($upload_tmp_dir)) return $upload_tmp_dir;
    }

    if (($upload_tmp_dir = @system_get_temp_dir()) !== false) {
        if (is_writable($upload_tmp_dir)) return $upload_tmp_dir;
    }

    return false;
}

/**
* Checks attachments directory
*
* Checks that the specified attachments directory exists and is writable.
* Attempts to create the directory if it doesn't exist. Returns string
* containing attachment path if successful, otherwise false.
*
* @return mixed
* @param void
*/

function attachments_check_dir()
{
    if (($attachment_dir = forum_get_setting('attachment_dir'))) {

        // Check that the temporary upload directory is writable

        if (!@is_writable(attachments_get_upload_tmp_dir())) return false;

        // Check to make sure the $attachment_dir exists and is writable.

        mkdir_recursive($attachment_dir, 0755);

        // Check that the directory is writable.

        if (@is_writable($attachment_dir)) return $attachment_dir;
    }

    return false;
}

/**
* Fetches user attachments
*
* Fetches the available attachments based on the provided parameters that match $aid
*
* @return bool
* @param integer $uid - User ID
* @param string $aid - Current post attachment ID (MD5 Hash)
* @param array $user_attachments - By reference array containing normal attachments
* @param array $user_attachments - By reference array containing image attachments
*/

function get_attachments($uid, $aid, &$user_attachments, &$user_image_attachments, $hash_array = array())
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db_get_attachments = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;
    if (!is_array($hash_array)) return false;

    if (!is_array($hash_array)) $hash_array = false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $hash_array = preg_grep("/^[A-Fa-f0-9]{32}$/Du", $hash_array);

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        $hash_list = implode("', '", $hash_array);

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' ";
        $sql.= "AND PAF.HASH IN ('$hash_list') ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    }else {

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' AND PAF.AID = '$aid' ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";
    }

    if (!$result = db_query($sql, $db_get_attachments)) return false;

    while (($attachment = db_fetch_array($result))) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[$attachment['HASH']] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                                     "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                                     "filesize"     => $filesize,
                                                                     "aid"          => $attachment['AID'],
                                                                     "hash"         => $attachment['HASH'],
                                                                     "mimetype"     => $attachment['MIMETYPE'],
                                                                     "downloads"    => $attachment['DOWNLOADS']);

            }else {

                $user_attachments[$attachment['HASH']] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                               "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                               "filesize"     => filesize("$attachment_dir/{$attachment['HASH']}"),
                                                               "aid"          => $attachment['AID'],
                                                               "hash"         => $attachment['HASH'],
                                                               "mimetype"     => $attachment['MIMETYPE'],
                                                               "downloads"    => $attachment['DOWNLOADS']);
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

/**
* Fetches user attachments
*
* Fetches the available attachments based on the provided parameters that do not match $aid
*
* @return bool
* @param integer $uid - User ID
* @param string $aid - Current post attachment ID (MD5 Hash)
* @param array $user_attachments - By reference array containing normal attachments
* @param array $user_attachments - By reference array containing image attachments
*/

function get_all_attachments($uid, $aid, &$user_attachments, &$user_image_attachments)
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db_get_all_attachments = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
    $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAF.UID = '$uid' AND PAF.AID <> '$aid'";
    $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    if (!$result = db_query($sql, $db_get_all_attachments)) return false;

    while (($attachment = db_fetch_array($result))) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[$attachment['HASH']] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                                     "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                                     "filesize"     => $filesize,
                                                                     "aid"          => $attachment['AID'],
                                                                     "hash"         => $attachment['HASH'],
                                                                     "mimetype"     => $attachment['MIMETYPE'],
                                                                     "downloads"    => $attachment['DOWNLOADS']);

            }else {

                $user_attachments[$attachment['HASH']] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                               "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                               "filesize"     => filesize("$attachment_dir/{$attachment['HASH']}"),
                                                               "aid"          => $attachment['AID'],
                                                               "hash"         => $attachment['HASH'],
                                                               "mimetype"     => $attachment['MIMETYPE'],
                                                               "downloads"    => $attachment['DOWNLOADS']);
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

/**
* Fetches user attachments
*
* Fetches the available attachments for the provided User ID
*
* @return bool
* @param integer $uid - User ID
* @param array $user_attachments - By reference array containing normal attachments
* @param array $user_attachments - By reference array containing image attachments
*/

function get_users_attachments($uid, &$user_attachments, &$user_image_attachments, $hash_array = array())
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db_get_users_attachments = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_array($hash_array)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $hash_array = preg_grep("/^[A-Fa-f0-9]{32}$/Du", $hash_array);

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        $hash_list = implode("', '", $hash_array);

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' ";
        $sql.= "AND PAF.HASH IN ('$hash_list') ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    }else {

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' ORDER BY FORUMS.FID DESC, PAF.FILENAME";
    }

    if (!$result = db_query($sql, $db_get_users_attachments)) return false;

    while (($attachment = db_fetch_array($result))) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[$attachment['HASH']] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                                     "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                                     "filesize"     => $filesize,
                                                                     "aid"          => $attachment['AID'],
                                                                     "hash"         => $attachment['HASH'],
                                                                     "mimetype"     => $attachment['MIMETYPE'],
                                                                     "downloads"    => $attachment['DOWNLOADS']);

            }else {

                $user_attachments[$attachment['HASH']] = array("filename"     => rawurldecode($attachment['FILENAME']),
                                                               "filedate"     => filemtime("$attachment_dir/{$attachment['HASH']}"),
                                                               "filesize"     => filesize("$attachment_dir/{$attachment['HASH']}"),
                                                               "aid"          => $attachment['AID'],
                                                               "hash"         => $attachment['HASH'],
                                                               "mimetype"     => $attachment['MIMETYPE'],
                                                               "downloads"    => $attachment['DOWNLOADS']);
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

/**
* Add user attachment
*
* Adds a record to the database for a new file attachment
*
* @return bool
* @param integer $uid - User ID
* @param string $aid - Post attachment ID (MD5 Hash)
* @param integer $fileid - Unique ID of the file for duplicate filenames
* @param string $filename - Filename of the file attachment
* @param string $mimetype - MIME type of the file attachment
*/

function add_attachment($uid, $aid, $fileid, $filename, $mimetype)
{
    if (!$db_add_attachment = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    $hash = md5("$aid$fileid$filename");
    $filename = rawurlencode($filename);

    $filename = db_escape_string($filename);
    $mimetype = db_escape_string($mimetype);

    $sql = "INSERT INTO POST_ATTACHMENT_FILES (AID, UID, FILENAME, MIMETYPE, HASH) ";
    $sql.= "VALUES ('$aid', '$uid', '$filename', '$mimetype', '$hash')";

    if (!db_query($sql, $db_add_attachment)) return false;

    return true;
}

/**
* Delete an attachment
*
* Deletes an attachment by it's Post attachment ID
*
* @return void
* @param string $aid - Post attachment ID (MD5 Hash)
*/

function delete_attachment_by_aid($aid)
{
    if (!is_md5($aid)) return false;

    if (!$db_delete_attachment_by_aid = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.

    $sql = "SELECT PAF.HASH FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "WHERE PAF.AID = '$aid' AND PAF.UID = '$uid'";

    if (!$result = db_query($sql, $db_delete_attachment_by_aid)) return false;

    while (($attachment_data = db_fetch_array($result))) {

        if (!delete_attachment($attachment_data['HASH'])) return false;
    }

    return true;
}

/**
* Delete an attachment
*
* Deletes an attachment by it's file hash
*
* @return void
* @param string $hash - File attachment ID (MD5 Hash)
*/

function delete_attachment($hash)
{
    if (!is_md5($hash)) return false;

    if (!$db_delete_attachment = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.

    if (($table_data = get_table_prefix())) {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID, THREAD.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = PAI.TID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";

    }else {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";
    }

    if (!$result = db_query($sql, $db_delete_attachment)) return false;

    if (db_num_rows($result) > 0) {

        $attachment_data = db_fetch_array($result);

        if (!isset($attachment_data['FID'])) $attachment_data['FID'] = 0;

        if (($attachment_data['UID'] == $uid) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID'])) {

            // Mark the related post as edited

            if (isset($attachment_data['TID']) && isset($attachment_data['PID'])) {

                post_add_edit_text($attachment_data['TID'], $attachment_data['PID']);

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']) && ($attachment_data['UID'] != $uid)) {

                    $log_data = array($attachment_data['TID'], $attachment_data['PID'], $attachment_data['FILENAME']);
                    admin_add_log_entry(DELETE_ATTACHMENT, $log_data);
                }
            }

            // Delete the attachment record from the database

            $sql = "DELETE QUICK FROM POST_ATTACHMENT_FILES ";
            $sql.= "WHERE HASH = '$hash'";

            if (!db_query($sql, $db_delete_attachment)) return false;

            // Check to see if there are anymore attachments with the same AID

            $sql = "SELECT AID FROM POST_ATTACHMENT_FILES ";
            $sql.= "WHERE AID = '{$attachment_data['AID']}'";

            if (!db_query($sql, $db_delete_attachment)) return false;

            // Finally delete the file (and it's thumbnail)

            @unlink("$attachment_dir/$hash");
            @unlink("$attachment_dir/$hash.thumb");

            return true;
        }
    }

    return false;
}

/**
* Delete an attachment thumbnail
*
* Deletes an attachments thunbnail by it's file hash.
*
* @return void
* @param string $hash - File attachment ID (MD5 Hash)
*/

function delete_attachment_thumbnail($hash)
{
    if (!is_md5($hash)) return false;

    if (!$db_delete_attachment_thumbnail = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.

    if (($table_data = get_table_prefix())) {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID, THREAD.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = PAI.TID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";

    }else {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";
    }

    if (!$result = db_query($sql, $db_delete_attachment_thumbnail)) return false;

    if (db_num_rows($result) > 0) {

        $attachment_data = db_fetch_array($result);

        if (!isset($attachment_data['FID'])) $attachment_data['FID'] = 0;

        if (($attachment_data['UID'] == $uid) || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID'])) {

            // Mark the related post as edited

            if (isset($attachment_data['TID']) && isset($attachment_data['PID'])) {

                post_add_edit_text($attachment_data['TID'], $attachment_data['PID']);

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']) && ($attachment_data['UID'] != $uid)) {

                    $log_data = array($attachment_data['TID'], $attachment_data['PID'], $attachment_data['FILENAME']);
                    admin_add_log_entry(DELETE_ATTACHMENT, $log_data);
                }
            }

            // Delete the thumbnail.

            @unlink("$attachment_dir/$hash.thumb");

            return true;
        }
    }

    return false;
}

/**
* Get free attachment space
*
* Gets the free attachment space for the specified User ID
*
* @return integer
* @param integer $uid - User ID
*/

function get_free_attachment_space($uid)
{
    $used_attachment_space = 0;

    if (!$db_get_free_attachment_space = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return 0;

    $max_attachment_space = forum_get_setting('attachments_max_user_space', false, 1048576);

    if ($max_attachment_space > 0) {

        $sql = "SELECT HASH FROM POST_ATTACHMENT_FILES WHERE UID = '$uid'";

        if (!$result = db_query($sql, $db_get_free_attachment_space)) return false;

        while (($attachment_data = db_fetch_array($result))) {

            if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

                $used_attachment_space += filesize("$attachment_dir/{$attachment_data['HASH']}");
            }
        }

        return (($max_attachment_space - $used_attachment_space) < 0) ? 0 : ($max_attachment_space - $used_attachment_space);
    }

    return 0;
}

/**
* Gets Post attachment ID
*
* Gets the post attachment ID from the provided Thread ID and Post ID
*
* @return mixed
* @param integer $tid - Thread ID
* @param integer $pid - Post ID
*/

function get_attachment_id($tid, $pid)
{
    if (!$db_get_attachment_id = db_connect()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT AID FROM POST_ATTACHMENT_IDS WHERE ";
    $sql.= "FID = '$forum_fid' AND TID = '$tid' AND PID = '$pid'";

    if (!$result = db_query($sql, $db_get_attachment_id)) return false;

    if (db_num_rows($result) > 0) {

        list($attachment_id) = db_fetch_array($result, DB_RESULT_NUM);
        return $attachment_id;

    }else{

        return false;
    }
}

/**
* Get folder ID
*
* Get the folder ID from the provided post attachment ID
*
* @return mixed
* @param string $aid Post attachment ID (MD5 Hash)
*/

function get_folder_fid($aid)
{
    if (!$db_get_folder_fid = db_connect()) return false;

    if (!is_md5($aid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = PAI.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAI.AID = '$aid'";

    if (!$result = db_query($sql, $db_get_folder_fid)) return false;

    if (db_num_rows($result) > 0) {

        list($folder_fid) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder_fid;
    }

    return false;
}

/**
* Get PM attachment ID
*
* Gets the PM attachment ID from the provided personal message ID
*
* @return mixed
* @param integer $mid Personal Message ID
*/

function get_pm_attachment_id($mid)
{
    if (!$db_get_pm_attachment_id = db_connect()) return false;

    if (!is_numeric($mid)) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";

    if (!$result = db_query($sql, $db_get_pm_attachment_id)) return false;

    if (db_num_rows($result) > 0) {

        list($attachment_id) = db_fetch_array($result, DB_RESULT_NUM);
        return $attachment_id;
    }

    return false;
}

/**
* Get message link
*
* Constucts the URI for use in a HTML anchor href attribute for the message that contains the specified attachment.
*
* @return mixed
* @param string $aid - Attachment ID (MD5 Hash)
* @param bool $get_pm_link - Optional paramter for getting PM link if post link fails
*/

function get_message_link($aid, $get_pm_link = true)
{
    if (!$db_get_message_link = db_connect()) return false;

    if (!is_md5($aid)) return false;

    $webtag = get_webtag();

    $sql = "SELECT FORUMS.WEBTAG, PAI.TID, PAI.PID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAI.AID = '$aid'";

    if (!$result = db_query($sql, $db_get_message_link)) return false;

    if (db_num_rows($result) > 0) {

        list($forum_webtag, $tid, $pid) = db_fetch_array($result, DB_RESULT_NUM);
        return "messages.php?webtag=$forum_webtag&amp;msg=$tid.$pid";

    }else if ($get_pm_link) {

        $sql = "SELECT MID FROM PM_ATTACHMENT_IDS WHERE AID = '$aid'";

        if (!$result = db_query($sql, $db_get_message_link)) return false;

        if (db_num_rows($result) > 0) {

            list($mid) = db_fetch_array($result, DB_RESULT_NUM);
            return "pm.php?webtag=$webtag&amp;mid=$mid";
        }
    }

    return false;
}

/**
* Gets attachment count for specified post attachment ID
*
* Returns the number of individual attachments a post or PM contains
*
* @return integer
* @param string $aid - Post attachment ID (MD5 Hash)
*/

function get_num_attachments($aid)
{
    if (!$db_get_num_attachments = db_connect()) return false;

    if (!is_md5($aid)) return false;

    $aid = db_escape_string($aid);

    $sql = "SELECT COUNT(AID) FROM POST_ATTACHMENT_FILES ";
    $sql.= "WHERE AID = '$aid' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_get_num_attachments)) return false;

    list($num_attachments) = db_fetch_array($result, DB_RESULT_NUM);

    return $num_attachments;
}

/**
* Fetches an attachment
*
* Fetches the attachment that matches the specified file hash
*
* @return mixed
* @param string $hash - File attachment hash (MD5 Hash)
*/

function get_attachment_by_hash($hash)
{
    if (!$db_get_attachment_by_hash = db_connect()) return false;

    if (!is_md5($hash)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $sql = "SELECT AID, UID, FILENAME, MIMETYPE, HASH, DOWNLOADS ";
    $sql.= "FROM POST_ATTACHMENT_FILES WHERE HASH = '$hash' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_get_attachment_by_hash)) return false;

    if (db_num_rows($result) > 0) {

        $attachment_data = db_fetch_array($result);

        if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

            return array("filename"  => rawurldecode($attachment_data['FILENAME']),
                         "filedate"  => filemtime("$attachment_dir/{$attachment_data['HASH']}"),
                         "filesize"  => filesize("$attachment_dir/{$attachment_data['HASH']}"),
                         "aid"       => $attachment_data['AID'],
                         "hash"      => $attachment_data['HASH'],
                         "mimetype"  => $attachment_data['MIMETYPE'],
                         "downloads" => $attachment_data['DOWNLOADS']);
        }
    }

    return false;
}

/**
* Increment download count
*
* Increments the download count for the specified file hash
*
* @return mixed
* @param string $hash - Post attachment ID (MD5 hash)
*/

function attachment_inc_dload_count($hash)
{
    if (!$db_attachment_inc_dload_count = db_connect()) return false;

    if (!is_md5($hash)) return false;

    $sql = "UPDATE LOW_PRIORITY POST_ATTACHMENT_FILES ";
    $sql.= "SET DOWNLOADS = DOWNLOADS + 1 WHERE HASH = '$hash'";

    if (!db_query($sql, $db_attachment_inc_dload_count)) return false;

    return true;
}

/**
* Check for embedded attachments
*
* Checks provided content for attachments embedded in HTML image / object tags
*
* @return bool
* @param string $content - string to check
*/

function attachment_embed_check($content)
{
    if (forum_get_setting('attachments_allow_embed', 'Y')) return false;

    $content_check = preg_replace('/\&amp;\#([0-9]+)\;/ume', "chr('\\1')", rawurldecode($content));

    return preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+get_attachment.php.+>/iu", $content_check);
}

/**
* Make attachment link
*
* Constucts the correct type of link for the specified attachment / image attachment
*
* @return string
* @param array $attachment - attachment array retrieved from get_attachments / get_all_attachments function
* @param bool $show_thumbs - Optionally enable or disable the display of thumbnails for supported image attachments (default: true)
* @param bool $limit_filename - Optionally truncate the filename to 16 characters if it is too long (default: false)
* @param bool $local_path - Optionally include the path to the attachment (default: false).
* @param bool $img_tag - Optionally include the HTML to construct the thumbnail / attachment icon (default: true).
*/

function attachment_make_link($attachment, $show_thumbs = true, $limit_filename = false, $local_path = false, $img_tag = true)
{
    if (!is_array($attachment)) return false;

    if (!is_bool($show_thumbs)) $show_thumbs = true;
    if (!is_bool($limit_filename)) $limit_filename = false;
    if (!is_bool($local_path)) $local_path = false;
    if (!is_bool($img_tag)) $img_tag = true;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    if (!isset($attachment['aid'])) return false;
    if (!isset($attachment['hash'])) return false;
    if (!isset($attachment['filename'])) return false;
    if (!isset($attachment['downloads'])) return false;

    if (!is_md5($attachment['aid'])) return false;
    if (!is_md5($attachment['hash'])) return false;

    $webtag = get_webtag();

    $lang = load_language_file();

    if (($user_show_thumbs = bh_session_get_value('SHOW_THUMBS')) > 0) {

        $thumbnail_size = array(1 => 50, 2 => 100, 3 => 150);
        $thumbnail_max_size = isset($thumbnail_size[$user_show_thumbs])
                              ? $thumbnail_size[$user_show_thumbs] : 100;

    }else {

        $thumbnail_max_size = 100;
        $show_thumbs = false;
    }

    if ($local_path) {

        $attachment_href = "attachments/{$attachment['filename']}";

    }else if (forum_get_setting('attachment_use_old_method', 'Y')) {

        $attachment_href = "get_attachment.php?webtag=$webtag&amp;hash={$attachment['hash']}";
        $attachment_href.= "&amp;filename={$attachment['filename']}";

    }else {

        $attachment_href = "get_attachment.php/{$attachment['hash']}/";
        $attachment_href.= rawurlencode($attachment['filename']);
        $attachment_href.= "?webtag=$webtag";
    }

    if ($img_tag === true) {

        $title_array = array();

        if (strlen($attachment['filename']) > 16 && $limit_filename) {

            $title_array[] = "{$lang['filename']}: {$attachment['filename']}";

            $attachment['filename'] = substr($attachment['filename'], 0, 16);
            $attachment['filename'].= "&hellip;";
        }

        if (isset($attachment['filesize']) && is_numeric($attachment['filesize'])) {

            $title_array[] = "{$lang['size']}: ". format_file_size($attachment['filesize']);
        }

        if ($attachment['downloads'] == 1) {

            $title_array[] = $lang['downloadedonetime'];

        }else {

            $title_array[] = sprintf($lang['downloadedxtimes'], $attachment['downloads']);
        }

        if (@file_exists("$attachment_dir/{$attachment['hash']}.thumb") && $show_thumbs) {

            if ((@$image_info = getimagesize("$attachment_dir/{$attachment['hash']}"))) {

                $title_array[] = "{$lang['dimensions']}: {$image_info[0]}x{$image_info[1]}px";

                $thumbnail_width  = $image_info[0];
                $thumbnail_height = $image_info[1];

                while ($thumbnail_width > $thumbnail_max_size || $thumbnail_height > $thumbnail_max_size) {

                    $thumbnail_width--;
                    $thumbnail_height = floor($thumbnail_width * ($image_info[1] / $image_info[0]));
                }

                $title = implode(", ", $title_array);

                $attachment_link = "<span class=\"attachment_thumb\"><a href=\"$attachment_href\" title=\"$title\" ";
                $attachment_link.= "target=\"_blank\"><img src=\"$attachment_href&amp;thumb=1\"";
                $attachment_link.= "border=\"0\" width=\"$thumbnail_width\" height=\"$thumbnail_height\"";
                $attachment_link.= "alt=\"$title\" title=\"$title\" /></a></span>";

                return $attachment_link;
            }
        }

        $title = implode(", ", $title_array);

        $attachment_link = "<img src=\"";
        $attachment_link.= style_image('attach.png');
        $attachment_link.= "\" width=\"14\" height=\"14\" border=\"0\" ";
        $attachment_link.= "alt=\"{$lang['attachment']}\" ";
        $attachment_link.= "title=\"{$lang['attachment']}\" />";
        $attachment_link.= "<a href=\"$attachment_href\" title=\"$title\" ";
        $attachment_link.= "target=\"_blank\">{$attachment['filename']}</a>\n";

        return $attachment_link;
    }

    return $attachment_href;
}

/**
* Set thumb transparency
*
* Assigns alpha transparency to an image to correctly create thumbnails from
* pngs with alpha transparency.
*
* @return GD image resource
* @param GD image resource $im - GD image source from GD image create function.
*/

function attachment_thumb_transparency($im)
{
    if (!function_exists('imageantialias')) return $im;
    if (!function_exists('imagealphablending')) return $im;
    if (!function_exists('imagesavealpha')) return $im;

    imageantialias($im, true);
    imagealphablending($im, false);
    imagesavealpha($im, true);

    $im_width  = imagesx($im);
    $im_height = imagesy($im);

    $transparent = imagecolorallocatealpha($im, 255, 255, 255, 0);

    for ($x = 0; $x < $im_width; $x++) {
        for ($y = 0;$y < $im_height; $y++) {
            imagesetpixel($im, $x, $y, $transparent);
        }
    }

    return $im;
}

/**
* Create a thumbnail
*
* Creates a thumbnail for the attachment if it is of a supported image type
*
* @return bool
* @param string $filepath - path to the file attachment on the server
*/

function attachment_create_thumb($filepath, $max_width = 150, $max_height = 150)
{
    if (!is_numeric($max_width)) $max_width = 150;
    if (!is_numeric($max_height)) $max_height = 150;

    // Required PHP image create from functions

    $required_read_functions  = array(1 => 'imagecreatefromgif',
                                      2 => 'imagecreatefromjpeg',
                                      3 => 'imagecreatefrompng');

    // Required PHP image output functions

    $required_write_functions = array(1 => 'imagegif',
                                      2 => 'imagejpeg',
                                      3 => 'imagepng');

    // Required GD read support

    $required_read_support = array(1 => 'GIF Read Support',
                                   2 => 'JPG Support',
                                   3 => 'PNG Support');

    // Required GD write support

    $required_write_support = array(1 => 'GIF Create Support',
                                    2 => 'JPG Support',
                                    3 => 'PNG Support');

    if (@file_exists($filepath) && @$image_info = getimagesize($filepath)) {

        if (($attachment_gd_info = get_gd_info())) {

            // Check 1: Does GD support reading and writing our image type?

            if (!isset($required_read_support[$image_info[2]])) return false;
            if (!isset($required_write_support[$image_info[2]])) return false;

            if (!isset($attachment_gd_info[$required_read_support[$image_info[2]]])) return false;
            if (!isset($attachment_gd_info[$required_write_support[$image_info[2]]])) return false;

            if ($attachment_gd_info[$required_read_support[$image_info[2]]] != 1) return false;
            if ($attachment_gd_info[$required_write_support[$image_info[2]]] != 1) return false;

            // Check 2: Even if GD says it supports the image format check the php functions actually exist!

            if (!function_exists($required_read_functions[$image_info[2]])) return false;
            if (!function_exists($required_write_functions[$image_info[2]])) return false;

            // Got this far, lets try reading the image.

            if ((@$src = $required_read_functions[$image_info[2]]($filepath))) {

                $target_width  = $image_info[0];
                $target_height = $image_info[1];

                while ($target_width > $max_width || $target_height > $max_height) {

                    $target_width--;
                    $target_height = $target_width * ($image_info[1] / $image_info[0]);
                }

                if (strcmp($attachment_gd_info['GD Version'], '2.0') > -1) {

                    $dst = imagecreatetruecolor($target_width, $target_height);
                    $dst = attachment_thumb_transparency($dst);

                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $target_width,
                                       $target_height, $image_info[0], $image_info[1]);

                }else {

                    $dst = imagecreate($target_width, $target_height);
                    $dst = attachment_thumb_transparency($dst);

                    imagecopyresized($dst, $src, 0, 0, 0, 0, $target_width,
                                     $target_height, $image_info[0], $image_info[1]);
                }

                return $required_write_functions[$image_info[2]]($dst, "$filepath.thumb");
            }
        }
    }

    return false;
}

?>