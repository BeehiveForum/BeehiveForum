<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'image.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'server.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

function attachments_get_upload_tmp_dir()
{
    if (($upload_tmp_dir = @ini_get('upload_tmp_dir')) !== false) {
        if (is_writable($upload_tmp_dir)) return $upload_tmp_dir;
    }

    if (($upload_tmp_dir = @sys_get_temp_dir()) !== false) {
        if (is_writable($upload_tmp_dir)) return $upload_tmp_dir;
    }

    return false;
}

function attachments_check_dir()
{
    if (!($attachment_dir = forum_get_setting('attachment_dir'))) return false;

    if (!@is_writable(attachments_get_upload_tmp_dir())) return false;

    @mkdir($attachment_dir, 0755, true);

    if (!@is_writable($attachment_dir)) return false;
    
    return $attachment_dir;
}

function attachments_get($uid, $aid, &$user_attachments, &$user_image_attachments, $hash_array = array())
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;
    if (!is_array($hash_array)) return false;

    if (!is_array($hash_array)) $hash_array = false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $hash_array = array_filter($hash_array, 'is_md5');

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        $hash_list = implode("', '", $hash_array);

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' ";
        $sql.= "AND PAF.HASH IN ('$hash_list') ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    } else {

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' AND PAF.AID = '$aid' ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";
    }

    if (!$result = $db->query($sql)) return false;

    while (($attachment = $result->fetch_assoc())) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[$attachment['HASH']] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filedate" => filemtime("$attachment_dir/{$attachment['HASH']}"),
                    "filesize" => $filesize,
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS']
                );

            } else {

                $user_attachments[$attachment['HASH']] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filedate" => filemtime("$attachment_dir/{$attachment['HASH']}"),
                    "filesize" => filesize("$attachment_dir/{$attachment['HASH']}"),
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS']
                );
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

function attachments_get_all($uid, $aid, &$user_attachments, &$user_image_attachments)
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
    $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAF.UID = '$uid' AND PAF.AID <> '$aid'";
    $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    if (!$result = $db->query($sql)) return false;

    while (($attachment = $result->fetch_assoc())) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[$attachment['HASH']] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filedate" => filemtime("$attachment_dir/{$attachment['HASH']}"),
                    "filesize" => $filesize,
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS']
                );

            } else {

                $user_attachments[$attachment['HASH']] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filedate" => filemtime("$attachment_dir/{$attachment['HASH']}"),
                    "filesize" => filesize("$attachment_dir/{$attachment['HASH']}"),
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS']
                );
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

function attachments_get_users($uid, &$user_attachments, &$user_image_attachments, $hash_array = array())
{
    $user_attachments = array();
    $user_image_attachments = array();

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_array($hash_array)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $hash_array = array_filter($hash_array, 'is_md5');

    if (is_array($hash_array) && sizeof($hash_array) > 0) {

        $hash_list = implode("', '", $hash_array);

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' AND PAF.HASH IN ('$hash_list') ";
        $sql.= "ORDER BY FORUMS.FID DESC, PAF.FILENAME";

    } else {

        $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, PAF.DOWNLOADS, ";
        $sql.= "FORUMS.WEBTAG, FORUMS.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
        $sql.= "WHERE PAF.UID = '$uid' ORDER BY FORUMS.FID DESC, PAF.FILENAME";
    }

    if (!$result = $db->query($sql)) return false;

    while (($attachment = $result->fetch_assoc())) {

        if (@file_exists("$attachment_dir/{$attachment['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment['HASH']}.thumb");

                $user_image_attachments[$attachment['HASH']] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filedate" => filemtime("$attachment_dir/{$attachment['HASH']}"),
                    "filesize" => $filesize,
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS']
                );

            } else {

                $user_attachments[$attachment['HASH']] = array(
                    "filename" => rawurldecode($attachment['FILENAME']),
                    "filedate" => filemtime("$attachment_dir/{$attachment['HASH']}"),
                    "filesize" => filesize("$attachment_dir/{$attachment['HASH']}"),
                    "aid" => $attachment['AID'],
                    "hash" => $attachment['HASH'],
                    "mimetype" => $attachment['MIMETYPE'],
                    "downloads" => $attachment['DOWNLOADS']
                );
            }
        }
    }

    return (sizeof($user_attachments) > 0 || sizeof($user_image_attachments) > 0);
}

function attachments_add($uid, $aid, $fileid, $filename, $mimetype)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_md5($aid)) return false;

    $hash = md5("$aid$fileid$filename");
    $filename = rawurlencode($filename);

    $filename = $db->escape($filename);
    $mimetype = $db->escape($mimetype);

    $sql = "INSERT INTO POST_ATTACHMENT_FILES (AID, UID, FILENAME, MIMETYPE, HASH) ";
    $sql.= "VALUES ('$aid', '$uid', '$filename', '$mimetype', '$hash')";

    if (!$db->query($sql)) return false;

    return true;
}

function attachments_delete_by_aid($aid)
{
    if (!is_md5($aid)) return false;

    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.
    $sql = "SELECT PAF.HASH FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "WHERE PAF.AID = '$aid' AND PAF.UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    while (($attachment_data = $result->fetch_assoc())) {

        if (!attachments_delete($attachment_data['HASH'])) return false;
    }

    return true;
}

function attachments_delete($hash)
{
    if (!is_md5($hash)) return false;

    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.
    if (($table_prefix = get_table_prefix())) {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID, THREAD.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = PAI.TID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";

    } else {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";
    }

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    if (!isset($attachment_data['FID'])) $attachment_data['FID'] = 0;

    if (!(($attachment_data['UID'] == $uid) || session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']))) return false;

    if (isset($attachment_data['TID']) && isset($attachment_data['PID'])) {

        post_add_edit_text($attachment_data['TID'], $attachment_data['PID']);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']) && ($attachment_data['UID'] != $uid)) {

            $log_data = array(
                $attachment_data['TID'], 
                $attachment_data['PID'], 
                $attachment_data['FILENAME']
            );

            admin_add_log_entry(ATTACHMENTS_DELETE, $log_data);
        }
    }

    $sql = "DELETE QUICK FROM POST_ATTACHMENT_FILES ";
    $sql.= "WHERE HASH = '$hash'";

    if (!$db->query($sql)) return false;

    $sql = "SELECT AID FROM POST_ATTACHMENT_FILES ";
    $sql.= "WHERE AID = '{$attachment_data['AID']}'";

    if (!$db->query($sql)) return false;

    @unlink("$attachment_dir/$hash");

    @unlink("$attachment_dir/$hash.thumb");

    return true;
}

function attachments_delete_thumbnail($hash)
{
    if (!is_md5($hash)) return false;

    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    // Fetch the attachment to make sure the user
    // is able to delete it, i.e. it belongs to them.
    if (($table_prefix = get_table_prefix())) {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID, THREAD.FID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = PAI.TID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";

    } else {

        $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
        $sql.= "PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
        $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
        $sql.= "WHERE PAF.HASH = '$hash'";
    }

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    if (!isset($attachment_data['FID'])) $attachment_data['FID'] = 0;

    if (!(($attachment_data['UID'] == $uid) || session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']))) return false;

    if (isset($attachment_data['TID']) && isset($attachment_data['PID'])) {

        post_add_edit_text($attachment_data['TID'], $attachment_data['PID']);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']) && ($attachment_data['UID'] != $uid)) {

            $log_data = array(
                $attachment_data['TID'], 
                $attachment_data['PID'], 
                $attachment_data['FILENAME']
            );
            
            admin_add_log_entry(ATTACHMENTS_DELETE, $log_data);
        }
    }

    @unlink("$attachment_dir/$hash.thumb");

    return true;
}

function attachments_get_free_space($uid, $aid)
{
    // Get max settings for attachment space (default: 1MB)
    $max_user_attachment_space = forum_get_setting('attachments_max_user_space', null, 1048576);
    $max_post_attachment_space = forum_get_setting('attachments_max_post_space', null, 1048576);

    // Get the user's used attachment space (global and per-post)
    $user_attachment_space = attachments_get_user_space($uid);
    $post_attachment_space = attachments_get_post_space($aid);

    // If Max user attachment space > 0 use that to check the free space.
    // Checking that Max post attachment space > 0 and lower than max user space.
    if ($max_user_attachment_space > 0) {

        if (($max_post_attachment_space > 0) && ($max_post_attachment_space < $max_user_attachment_space)) {

            return (($max_post_attachment_space - $post_attachment_space) < 0) ? 0 : ($max_post_attachment_space - $post_attachment_space);

        } else {

            return (($max_user_attachment_space - $user_attachment_space) < 0) ? 0 : ($max_user_attachment_space - $user_attachment_space);
        }
    }

    // If Max post attachment space > 0 use that to check against the used post attachment space.
    if ($max_post_attachment_space > 0) {
        return (($max_post_attachment_space - $post_attachment_space) < 0) ? 0 : ($max_post_attachment_space - $post_attachment_space);
    }

    // All out of space?
    return 0;
}

function attachments_get_free_user_space($uid)
{
    $max_user_attachment_space = forum_get_setting('attachments_max_user_space', null, 1048576);

    $user_attachment_space = attachments_get_user_space($uid);

    return (($max_user_attachment_space - $user_attachment_space) < 0) ? 0 : ($max_user_attachment_space - $user_attachment_space);
}

function attachments_get_free_post_space($aid)
{
    $max_post_attachment_space = forum_get_setting('attachments_max_post_space', null, 1048576);

    $post_attachment_space = attachments_get_post_space($aid);

    return (($max_post_attachment_space - $post_attachment_space) < 0) ? 0 : ($max_post_attachment_space - $post_attachment_space);
}

function attachments_get_max_space()
{
    // Get max settings for attachment space (default: 1MB)
    $max_user_attachment_space = forum_get_setting('attachments_max_user_space', null, 1048576);
    $max_post_attachment_space = forum_get_setting('attachments_max_post_space', null, 1048576);

    if ($max_user_attachment_space > 0) {
        return $max_user_attachment_space;
    } else if ($max_post_attachment_space > 0) {
        return $max_post_attachment_space;
    }

    return 0;
}

function attachments_get_user_space($uid)
{
    $used_attachment_space = 0;

    if (!$db = db::get()) return 0;

    if (!is_numeric($uid)) return 0;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return 0;

    $sql = "SELECT HASH FROM POST_ATTACHMENT_FILES WHERE UID = '$uid'";

    if (!$result = $db->query($sql)) return 0;

    while (($attachment_data = $result->fetch_assoc())) {

        if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

            $used_attachment_space += filesize("$attachment_dir/{$attachment_data['HASH']}");
        }
    }

    return $used_attachment_space;
}

function attachments_get_post_space($aid)
{
    $used_attachment_space = 0;

    if (!$db = db::get()) return 0;

    if (!is_md5($aid)) return 0;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return 0;

    $sql = "SELECT HASH FROM POST_ATTACHMENT_FILES WHERE AID = '$aid'";

    if (!$result = $db->query($sql)) return 0;

    while (($attachment_data = $result->fetch_assoc())) {

        if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

            $used_attachment_space += filesize("$attachment_dir/{$attachment_data['HASH']}");
        }
    }

    return $used_attachment_space;
}

function attachments_get_id($tid, $pid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT AID FROM POST_ATTACHMENT_IDS WHERE ";
    $sql.= "FID = '$forum_fid' AND TID = '$tid' AND PID = '$pid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($attachment_id) = $result->fetch_row();

    return $attachment_id;
}

function attachments_get_folder_fid($aid)
{
    if (!$db = db::get()) return false;

    if (!is_md5($aid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT FOLDER.FID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN `{$table_prefix}POST` POST ON (POST.TID = PAI.TID AND POST.PID = PAI.PID) ";
    $sql.= "LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = POST.TID) ";
    $sql.= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAI.AID = '$aid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($folder_fid) = $result->fetch_row();

    return $folder_fid;
}

function attachments_get_pm_id($mid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($mid)) return false;

    $sql = "SELECT AID FROM PM_ATTACHMENT_IDS WHERE MID = '$mid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($attachment_id) = $result->fetch_row();

    return $attachment_id;
}

function attachments_get_message_link($aid)
{
    if (!$db = db::get()) return false;

    if (!is_md5($aid)) return false;

    $webtag = get_webtag();

    $sql = "SELECT FORUMS.WEBTAG, PAI.TID, PAI.PID FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN FORUMS FORUMS ON (PAI.FID = FORUMS.FID) ";
    $sql.= "WHERE PAI.AID = '$aid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($forum_webtag, $tid, $pid) = $result->fetch_row();

    return "messages.php?webtag=$forum_webtag&amp;msg=$tid.$pid";
}

function attachments_get_pm_link($aid)
{
    if (!$db = db::get()) return false;

    if (!is_md5($aid)) return false;

    $webtag = get_webtag();

    $sql = "SELECT MID FROM PM_ATTACHMENT_IDS WHERE AID = '$aid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    list($mid) = $result->fetch_row();

    return "pm.php?webtag=$webtag&amp;mid=$mid";
}

function attachments_get_count($aid)
{
    if (!$db = db::get()) return false;

    if (!is_md5($aid)) return false;

    $aid = $db->escape($aid);

    $sql = "SELECT COUNT(AID) FROM POST_ATTACHMENT_FILES ";
    $sql.= "WHERE AID = '$aid'";

    if (!$result = $db->query($sql)) return false;

    list($num_attachments) = $result->fetch_row();

    return $num_attachments;
}

function attachments_get_by_hash($hash)
{
    if (!$db = db::get()) return false;

    if (!is_md5($hash)) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $sql = "SELECT AID, UID, FILENAME, MIMETYPE, HASH, DOWNLOADS ";
    $sql.= "FROM POST_ATTACHMENT_FILES WHERE HASH = '$hash' LIMIT 0, 1";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    if (@!file_exists("$attachment_dir/{$attachment_data['HASH']}")) return false;

    return array(
        "filename" => rawurldecode($attachment_data['FILENAME']),
        "filedate" => filemtime("$attachment_dir/{$attachment_data['HASH']}"),
        "filesize" => filesize("$attachment_dir/{$attachment_data['HASH']}"),
        "aid" => $attachment_data['AID'],
        "hash" => $attachment_data['HASH'],
        "mimetype" => $attachment_data['MIMETYPE'],
        "downloads" => $attachment_data['DOWNLOADS']
    );
}

function attachments_inc_download_count($hash)
{
    if (!$db = db::get()) return false;

    if (!is_md5($hash)) return false;

    $sql = "UPDATE LOW_PRIORITY POST_ATTACHMENT_FILES ";
    $sql.= "SET DOWNLOADS = DOWNLOADS + 1 WHERE HASH = '$hash'";

    if (!$db->query($sql)) return false;

    return true;
}

function attachments_embed_check($content)
{
    if (forum_get_setting('attachments_allow_embed', 'Y')) return false;

    $content_check = preg_replace('/\&amp;\#([0-9]+)\;/ume', "chr('\\1')", rawurldecode($content));

    return preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+get_attachment.php.+>/iu", $content_check);
}

function attachments_make_link($attachment, $show_thumbs = true, $limit_filename = false, $local_path = false, $img_tag = true)
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

    if (forum_get_setting('attachment_thumbnails', 'Y') && ((($user_show_thumbs = session::get_value('SHOW_THUMBS')) > 0) || !session::logged_in())) {

        $thumbnail_size = array(
            1 => 50, 
            2 => 100, 
            3 => 150
        );
        
        $thumbnail_max_size = isset($thumbnail_size[$user_show_thumbs]) ? $thumbnail_size[$user_show_thumbs] : 100;

    } else {

        $thumbnail_max_size = 100;
        $show_thumbs = false;
    }

    if ($local_path) {

        $attachment_href = "attachments/{$attachment['filename']}";

    } else {

        $attachment_href = "get_attachment.php?webtag=$webtag&amp;hash={$attachment['hash']}";
        $attachment_href.= "&amp;filename={$attachment['filename']}";
    }

    if ($img_tag === true) {

        $title_array = array();

        if (mb_strlen($attachment['filename']) > 16 && $limit_filename) {

            $title_array[] = gettext("Filename"). ": {$attachment['filename']}";

            $attachment['filename'] = mb_substr($attachment['filename'], 0, 16);
            $attachment['filename'].= "&hellip;";
        }

        if (isset($attachment['filesize']) && is_numeric($attachment['filesize'])) {

            $title_array[] = gettext("Size"). ": ". format_file_size($attachment['filesize']);
        }

        if ($attachment['downloads'] == 1) {

            $title_array[] = gettext("Downloaded: 1 time");

        } else {

            $title_array[] = sprintf(gettext("Downloaded: %d times"), $attachment['downloads']);
        }

        if (@file_exists("$attachment_dir/{$attachment['hash']}.thumb") && $show_thumbs) {

            if ((@$image_info = getimagesize("$attachment_dir/{$attachment['hash']}"))) {

                $title_array[] = gettext("Dimensions"). ": {$image_info[0]}x{$image_info[1]}px";

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
        $attachment_link.= html_style_image('attach.png');
        $attachment_link.= "\" width=\"14\" height=\"14\" border=\"0\" ";
        $attachment_link.= "alt=\"". gettext("Attachment"). "\" ";
        $attachment_link.= "title=\"". gettext("Attachment"). "\" />";
        $attachment_link.= "<a href=\"$attachment_href\" title=\"$title\" ";
        $attachment_link.= "target=\"_blank\">{$attachment['filename']}</a>\n";

        return $attachment_link;
    }

    return $attachment_href;
}

function attachments_get_mime_types()
{
    if (($allowed_mimetypes = forum_get_setting('attachment_mime_types'))) {
        return explode(';', $allowed_mimetypes);
    }

    return array();
}

?>