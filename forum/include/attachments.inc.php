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

/* $Id: attachments.inc.php,v 1.79 2004-12-27 16:19:57 decoyduck Exp $ */

include_once("./include/admin.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/perm.inc.php");

function get_attachments($uid, $aid)
{
    $user_attachments = false;

    $db_get_attachments = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
    $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAF.UID = '$uid' AND PAF.AID = '$aid' ";
    $sql.= "ORDER BY FORUMS.FID DESC";

    $result = db_query($sql, $db_get_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($user_attachments)) $user_attachments = array();

        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            $user_attachments[] = array("filename"     => rawurldecode($row['FILENAME']),
                                        "filesize"     => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                        "filedate"     => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                        "aid"          => $row['AID'],
                                        "hash"         => $row['HASH'],
                                        "mimetype"     => $row['MIMETYPE'],
                                        "downloads"    => $row['DOWNLOADS'],
                                        "forum_fid"    => is_numeric($row['FID']) ? $row['FID'] : 0,
                                        "forum_webtag" => $row['WEBTAG']);
        }
    }

    return $user_attachments;
}

function get_all_attachments($uid, $aid)
{
    $user_attachments = false;

    $db_get_all_attachments = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
    $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAF.UID = '$uid' AND PAF.AID <> '$aid'";
    $sql.= "ORDER BY FORUMS.FID DESC";

    $result = db_query($sql, $db_get_all_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($user_attachments)) $user_attachments = array();

        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            $user_attachments[] = array("filename"     => rawurldecode($row['FILENAME']),
                                        "filesize"     => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                        "filedate"     => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                        "aid"          => $row['AID'],
                                        "hash"         => $row['HASH'],
                                        "mimetype"     => $row['MIMETYPE'],
                                        "downloads"    => $row['DOWNLOADS'],
                                        "forum_fid"    => is_numeric($row['FID']) ? $row['FID'] : 0,
                                        "forum_webtag" => $row['WEBTAG']);
        }
    }

    return $user_attachments;
}

function get_users_attachments($uid)
{
    $user_attachments = false;

    $db_get_users_attachments = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return $user_attachments;

    $forum_settings = get_forum_settings();

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
    $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAF.UID = '$uid'";
    $sql.= "ORDER BY FORUMS.FID DESC";

    $result = db_query($sql, $db_get_users_attachments);

    while($row = db_fetch_array($result)) {

        if (!is_array($user_attachments)) $user_attachments = array();

        if (@file_exists(forum_get_setting('attachment_dir'). '/'. $row['HASH'])) {

            $user_attachments[] = array("filename"     => rawurldecode($row['FILENAME']),
                                        "filesize"     => filesize(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                        "filedate"     => filemtime(forum_get_setting('attachment_dir'). '/'. $row['HASH']),
                                        "aid"          => $row['AID'],
                                        "hash"         => $row['HASH'],
                                        "mimetype"     => $row['MIMETYPE'],
                                        "downloads"    => $row['DOWNLOADS'],
                                        "forum_fid"    => is_numeric($row['FID']) ? $row['FID'] : 0,
                                        "forum_webtag" => $row['WEBTAG']);
        }
    }

    return $user_attachments;
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

    $sql = "INSERT INTO POST_ATTACHMENT_FILES (AID, UID, FILENAME, MIMETYPE, HASH) ";
    $sql.= "VALUES ('$aid', '$uid', '$filename', '$mimetype', '$hash')";

    $result = db_query($sql, $db_add_attachment);

    return $result;
}

function delete_attachment_by_aid($aid)
{
    if (!is_md5($aid)) return false;

    $db_delete_attachment_by_aid = db_connect();

    if (!$uid = bh_session_get_value('UID')) return false;
    if(!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.

    $sql = "SELECT PAF.HASH FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "WHERE PAF.AID = '$aid' AND PAF.UID = '$uid'";

    $result = db_query($sql, $db_delete_attachment_by_aid);

    while ($row = db_fetch_array($result)) {

        delete_attachment($row['HASH']);
    }
}

function delete_attachment($hash)
{
    if (!is_md5($hash)) return false;

    $db_delete_attachment = db_connect();

    if (!$uid = bh_session_get_value('UID')) return false;
    if (!$table_data = get_table_prefix()) return false;

    $forum_settings = get_forum_settings();

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.

    $sql = "SELECT PAF.AID, PAF.UID, PAI.TID, PAI.PID, THREAD.FID ";
    $sql.= "FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = PAI.TID) ";
    $sql.= "WHERE PAF.HASH = '$hash'";

    $result = db_query($sql, $db_delete_attachment);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (($row['UID'] == $uid) || perm_is_moderator($row['FID'])) {

            // Mark the related post as edited

            if (isset($row['TID']) && isset($row['PID'])) {

                post_add_edit_text($row['TID'], $row['PID']);

                if (perm_is_moderator($row['FID'])) {

                    admin_addlog(0, 0, $row['TID'], $row['TID'], 0, 0, 34);
                }
            }

            // Delete the attachment record from the database

            $sql = "DELETE FROM POST_ATTACHMENT_FILES ";
            $sql.= "WHERE HASH = '$hash'";

            $result = db_query($sql, $db_delete_attachment);

            // Check to see if there are anymore attachments with the same AID

            $sql = "SELECT AID FROM POST_ATTACHMENT_FILES ";
            $sql.= "WHERE AID = '{$row['AID']}'";

            $result = db_query($sql, $db_delete_attachment);

            // No more attachments connected to the AID, so we can remove it from
            // the PAI database.

            if (db_num_rows($result) < 1) {

                $sql = "DELETE FROM POST_ATTACHMENT_IDS ";
                $sql.= "WHERE FID = '{$table_data['FID']}' ";
                $sql.= "AND AID = '{$row['AID']}'";

                $result = db_query($sql, $db_delete_attachment);
            }

            // Finally delete the file

            @unlink("$attachment_dir/$hash");
        }
    }
}

function get_free_attachment_space($uid)
{
    $used_attachment_space = 0;

    $db_get_free_attachment_space = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_settings = get_forum_settings();

    $max_attachment_space = forum_get_setting('attachments_max_user_space', false, 1048576);

    $sql = "SELECT * FROM POST_ATTACHMENT_FILES WHERE UID = '$uid'";
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

    $sql = "SELECT AID FROM POST_ATTACHMENT_IDS ";
    $sql.= "WHERE FID = '{$table_data['FID']}' ";
    $sql.= "AND TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_get_attachment_id);

    if (db_num_rows($result) > 0) {

        $attachment = db_fetch_array($result);
        return $attachment['AID'];

    }else{

        return false;
    }
}

function get_folder_fid($aid)
{
    $db_get_folder_fid = db_connect();

    if (!is_md5($aid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FOLDER.FID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = PAI.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE PAI.FID = '{$table_data['FID']}' AND PAI.AID = '$aid'";

    $result = db_query($sql, $db_get_folder_fid);

    if (db_num_rows($result) > 0) {

        $folder_array = db_fetch_array($result);
        return $folder_array['FID'];
    }

    return false;
}

function get_pm_attachment_id($mid)
{
    $db_get_pm_attachment_id = db_connect();

    if (!is_numeric($mid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";
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

    $webtag = get_webtag($webtag_search);

    $sql = "SELECT FORUMS.WEBTAG, PAI.TID, PAI.PID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAI.AID = '$aid'";

    $result = db_query($sql, $db_get_message_link);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return "./messages.php?webtag={$row['WEBTAG']}&amp;msg={$row['TID']}.{$row['PID']}";

    }else{

        $sql = "SELECT MID FROM PM_ATTACHMENT_IDS WHERE AID = '$aid'";
        $result = db_query($sql, $db_get_message_link);

        if (db_num_rows($result) > 0) {

            $mid = db_fetch_array($result);
            return "./pm.php?webtag=$webtag&amp;mid=". $mid['MID'];
        }
    }

    return false;
}

function get_num_attachments($aid)
{
    $db_get_num_attachments = db_connect();

    if (!is_md5($aid)) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT * FROM POST_ATTACHMENT_FILES WHERE AID = '$aid'";
    $result = db_query($sql, $db_get_num_attachments);

    return db_num_rows($result);
}

function get_attachment_by_hash($hash)
{
    $db_get_attachment_by_hash = db_connect();

    if (!is_md5($hash)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM POST_ATTACHMENT_FILES WHERE HASH = '$hash' LIMIT 0, 1";
    $result = db_query($sql, $db_get_attachment_by_hash);

    if (db_num_rows($result) > 0) {
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

    $sql = "UPDATE LOW_PRIORITY POST_ATTACHMENT_FILES ";
    $sql.= "SET DOWNLOADS = DOWNLOADS + 1 WHERE HASH = '$hash'";

    return db_query($sql, $db_attachment_inc_dload_count);
}

// Checks to see if an attachment has been embedded in the content
// True: attachment is embedded. False: no attachments embedded

function attachment_embed_check($content)
{
    if (forum_get_setting('attachments_allow_embed', 'Y', false)) return false;

    $content_check = preg_replace('/\&amp;\#([0-9]+)\;/me', "chr('\\1')", rawurldecode($content));

    return preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+get_attachment.php.+>/ ", $content_check);
}

?>