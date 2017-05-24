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

// Required includes
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'post.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

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
    if (forum_get_setting('attachments_enabled', 'N')) return false;

    if (!($attachment_dir = forum_get_setting('attachment_dir', null, 'attachments'))) return false;

    $attachment_dir = rtrim(trim($attachment_dir), '/');

    if (!attachments_get_upload_tmp_dir()) return false;

    @mkdir($attachment_dir, 0755, true);

    if (!@is_writable($attachment_dir)) return false;

    return $attachment_dir;
}

function attachments_get($uid, array $hash_array)
{
    if (!($forum_fid = get_forum_fid())) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($hash_array)) $hash_array = array();

    $hash_array = array_filter($hash_array, 'is_md5');

    if (sizeof($hash_array) == 0) {
        return false;
    }

    $hash_list = implode("', '", $hash_array);

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, ";
    $sql .= "PAF.FILESIZE, PAF.WIDTH, PAF.HEIGHT, PAF.THUMBNAIL, ";
    $sql .= "PAF.DOWNLOADS FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID ";
    $sql .= "AND PAI.FID = '$forum_fid') LEFT JOIN PM_ATTACHMENT_IDS PMAI ";
    $sql .= "ON (PMAI.AID = PAF.AID) WHERE PAF.UID = '$uid' ";
    $sql .= "AND PAF.HASH IN ('$hash_list') ";
    $sql .= "ORDER BY PAF.FILENAME";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $attachments = array();

    while (($attachment_data = $result->fetch_assoc()) !== null) {

        $attachments[$attachment_data['HASH']] = array(
            "aid" => $attachment_data['AID'],
            "downloads" => $attachment_data['DOWNLOADS'],
            "filename" => rawurldecode($attachment_data['FILENAME']),
            "filesize" => $attachment_data['FILESIZE'],
            "hash" => $attachment_data['HASH'],
            "height" => $attachment_data['HEIGHT'],
            "mimetype" => $attachment_data['MIMETYPE'],
            "thumbnail" => $attachment_data['THUMBNAIL'],
            "width" => $attachment_data['WIDTH'],
        );
    }

    return $attachments;
}

function attachments_get_all($uid)
{
    if (!($forum_fid = get_forum_fid())) return false;

    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT PAF.AID, PAF.HASH, PAF.FILENAME, PAF.MIMETYPE, ";
    $sql .= "PAF.FILESIZE, PAF.WIDTH, PAF.HEIGHT, PAF.THUMBNAIL, ";
    $sql .= "PAF.DOWNLOADS FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID ";
    $sql .= "AND PAI.FID = '$forum_fid') LEFT JOIN PM_ATTACHMENT_IDS PMAI ";
    $sql .= "ON (PMAI.AID = PAF.AID) WHERE PAF.UID = '$uid' ";
    $sql .= "ORDER BY PAF.FILENAME";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $attachments = array();

    while (($attachment_data = $result->fetch_assoc()) !== null) {

        $attachments[$attachment_data['HASH']] = array(
            "aid" => $attachment_data['AID'],
            "downloads" => $attachment_data['DOWNLOADS'],
            "filename" => rawurldecode($attachment_data['FILENAME']),
            "filesize" => $attachment_data['FILESIZE'],
            "hash" => $attachment_data['HASH'],
            "height" => $attachment_data['HEIGHT'],
            "mimetype" => $attachment_data['MIMETYPE'],
            "thumbnail" => $attachment_data['THUMBNAIL'],
            "width" => $attachment_data['WIDTH'],
        );
    }

    return $attachments;
}

function attachments_get_by_aid($aid, $uid = null)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($aid)) return false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    $sql = "SELECT AID, UID, FILENAME, MIMETYPE, FILESIZE, WIDTH, ";
    $sql .= "HEIGHT, THUMBNAIL, HASH, DOWNLOADS FROM POST_ATTACHMENT_FILES ";
    $sql .= "WHERE AID = '$aid' ";

    if (isset($uid) && is_numeric($uid)) {
        $sql .= "AND UID = '$uid'";
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    return array(
        "aid" => $attachment_data['AID'],
        "downloads" => $attachment_data['DOWNLOADS'],
        "filename" => rawurldecode($attachment_data['FILENAME']),
        "filesize" => $attachment_data['FILESIZE'],
        "hash" => $attachment_data['HASH'],
        "height" => $attachment_data['HEIGHT'],
        "mimetype" => $attachment_data['MIMETYPE'],
        "thumbnail" => $attachment_data['THUMBNAIL'],
        "width" => $attachment_data['WIDTH'],
    );
}

function attachments_get_by_hash($hash, $uid = null)
{
    if (!$db = db::get()) return false;

    if (!is_md5($hash)) return false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    $sql = "SELECT AID, UID, FILENAME, MIMETYPE, FILESIZE, WIDTH, ";
    $sql .= "HEIGHT, THUMBNAIL, HASH, DOWNLOADS FROM POST_ATTACHMENT_FILES ";
    $sql .= "WHERE HASH = '$hash' ";

    if (isset($uid) && is_numeric($uid)) {
        $sql .= "AND UID = '$uid'";
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    return array(
        "aid" => $attachment_data['AID'],
        "downloads" => $attachment_data['DOWNLOADS'],
        "filename" => rawurldecode($attachment_data['FILENAME']),
        "filesize" => $attachment_data['FILESIZE'],
        "hash" => $attachment_data['HASH'],
        "height" => $attachment_data['HEIGHT'],
        "mimetype" => $attachment_data['MIMETYPE'],
        "thumbnail" => $attachment_data['THUMBNAIL'],
        "width" => $attachment_data['WIDTH'],
    );
}

function attachments_add($uid, $filename, $hash, $mimetype, $filesize, $image_width, $image_height, $thumbnail)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_numeric($image_width) && !is_null($image_width)) return false;

    if (!is_numeric($image_height) && !is_null($image_height)) return false;

    $filename = $db->escape(rawurlencode($filename));

    $mimetype = $db->escape($mimetype);

    $filesize = $db->escape($filesize);

    $image_width = is_null($image_width) ? 'NULL' : $db->escape($image_width);

    $image_height = is_null($image_height) ? 'NULL' : $db->escape($image_height);

    $thumbnail = ($thumbnail) ? 'Y' : 'N';

    $hash = $db->escape($hash);

    $sql = "INSERT INTO POST_ATTACHMENT_FILES (UID, FILENAME, MIMETYPE, FILESIZE, ";
    $sql .= "WIDTH, HEIGHT, THUMBNAIL, HASH) VALUES ('$uid', '$filename', '$mimetype', ";
    $sql .= "'$filesize', $image_width, $image_height, '$thumbnail', '$hash')";

    if (!$db->query($sql)) return false;

    return $db->insert_id;
}

function attachments_delete($hash)
{
    if (!is_md5($hash)) return false;

    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
    $sql .= "PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql .= "WHERE PAF.HASH = '$hash'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    if (!isset($attachment_data['FID'])) $attachment_data['FID'] = 0;

    if (!(($attachment_data['UID'] == $_SESSION['UID']) || session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']))) return false;

    if (isset($attachment_data['TID']) && isset($attachment_data['PID'])) {

        post_add_edit_text($attachment_data['TID'], $attachment_data['PID']);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']) && ($attachment_data['UID'] != $_SESSION['UID'])) {

            $log_data = array(
                $attachment_data['TID'],
                $attachment_data['PID'],
                $attachment_data['FILENAME']
            );

            admin_add_log_entry(ATTACHMENTS_DELETE, $log_data);
        }
    }

    $sql = "DELETE QUICK FROM POST_ATTACHMENT_FILES ";
    $sql .= "WHERE HASH = '$hash'";

    if (!$db->query($sql)) return false;

    @unlink("$attachment_dir/$hash");

    @unlink("$attachment_dir/$hash.thumb");

    return true;
}

function attachments_delete_thumbnail($hash)
{
    if (!is_md5($hash)) return false;

    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    $sql = "SELECT PAF.AID, PAF.UID, PAF.FILENAME, PAI.TID, ";
    $sql .= "PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql .= "WHERE PAF.HASH = '$hash'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $attachment_data = $result->fetch_assoc();

    if (!isset($attachment_data['FID'])) $attachment_data['FID'] = 0;

    if (!(($attachment_data['UID'] == $_SESSION['UID']) || session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']))) return false;

    if (isset($attachment_data['TID']) && isset($attachment_data['PID'])) {

        post_add_edit_text($attachment_data['TID'], $attachment_data['PID']);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $attachment_data['FID']) && ($attachment_data['UID'] != $_SESSION['UID'])) {

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

function attachments_get_free_user_space($uid)
{
    $max_user_attachment_space = forum_get_setting('attachments_max_user_space', null, 1048576);

    $user_attachment_space = attachments_get_user_used_space($uid);

    if ($max_user_attachment_space > 0) {
        return (($max_user_attachment_space - $user_attachment_space) < 0) ? 0 : ($max_user_attachment_space - $user_attachment_space);
    }

    return -1;
}

function attachments_get_free_post_space($uid, $hash_array)
{
    $max_post_attachment_space = forum_get_setting('attachments_max_post_space', null, 1048576);

    $post_attachment_space = attachments_get_post_used_space($uid, $hash_array);

    if ($max_post_attachment_space > 0) {
        return (($max_post_attachment_space - $post_attachment_space) < 0) ? 0 : ($max_post_attachment_space - $post_attachment_space);
    }

    return -1;
}

function attachments_check_post_space($uid, $hash_array)
{
    $max_post_attachment_space = forum_get_setting('attachments_max_post_space', null, 1048576);

    if ($max_post_attachment_space == 0) return true;

    $post_attachment_space = attachments_get_post_used_space($uid, $hash_array);

    return $post_attachment_space < $max_post_attachment_space;
}

function attachments_get_post_used_space($uid, $hash_array)
{
    if (!$db = db::get()) return 0;

    if (!is_numeric($uid)) return 0;

    if (!is_array($hash_array)) return 0;

    $hash_array = array_filter($hash_array, 'is_md5');

    if (sizeof($hash_array) == 0) return 0;

    $hash_list = implode("', '", $hash_array);

    $sql = "SELECT SUM(PAF.FILESIZE) AS FILESIZE FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "WHERE PAF.UID = '$uid' AND PAF.HASH IN ('$hash_list')";

    if (!($result = $db->query($sql))) return 0;

    list($post_attachment_space) = $result->fetch_row();

    return $post_attachment_space;
}

function attachments_get_user_used_space($uid)
{
    if (!$db = db::get()) return 0;

    if (!is_numeric($uid)) return 0;

    $sql = "SELECT SUM(PAF.FILESIZE) AS FILESIZE FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "WHERE PAF.UID = '$uid'";

    if (!($result = $db->query($sql))) return 0;

    list($user_attachment_space) = $result->fetch_row();

    return $user_attachment_space;
}

function attachments_form($uid, $hash_array)
{
    if (!is_numeric($uid)) return '';

    if (!is_array($hash_array)) $hash_array = array();

    $selected_total_size = attachments_get_post_used_space($uid, $hash_array);

    $attachment_free_post_space = attachments_get_free_post_space($uid, $hash_array);

    $attachment_free_user_space = attachments_get_free_user_space($uid);

    $attachments_array = attachments_get($uid, $hash_array);

    return sprintf(
        '<ul>%s</ul>
         <div class="buttons"></div>
         <div class="summary">
           <div>
             <span>%s:</span>
             <span class="used_post_space">%s</span>
           </div>
           <div>
             <span>%s:</span>
             <span class="free_post_space">%s</span>
           </div>
           <div>
             <span>%s:</span>
             <span class="free_upload_space">%s</span>
           </div>
         </div>
         <div class="clearer"></div>',
        attachments_form_list($attachments_array, $hash_array),
        gettext("Total Size"),
        format_file_size($selected_total_size),
        gettext("Free Post Space"),
        $attachment_free_post_space >= 0
            ? format_file_size($attachment_free_post_space)
            : gettext("Unlimited"),
        gettext("Free Upload Space"),
        $attachment_free_user_space >= 0
            ? format_file_size($attachment_free_user_space)
            : gettext("Unlimited")
    );
}

function attachments_form_list($attachments_array, $hash_array)
{
    if (!is_array($attachments_array)) $attachments_array = array();

    if (!is_array($hash_array)) $hash_array = array();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $html = '';

    foreach ($attachments_array as $attachment) {

        $html .= sprintf(
            '<li class="attachment complete" data-hash="%1$s">
               <label>
                 <input %2$s class="bhinputcheckbox" name="attachment[]" type="checkbox" value="%1$s" />
                 <span class="image"></span>
                 <span class="filename">
                   <a href="get_attachment.php?webtag=%3$s&amp;hash=%1$s&amp;filename=%4$s">%5$s</a>
                 </span>
                 <span class="progress"></span>
                 <span class="retry" title="%6$s">%7$s</span>
                 <span class="cancel" title="%8$s">%9$s</span>
                 <span class="filesize">%10$s</span>
               </label>
             </li>',
            $attachment['hash'],
            in_array($attachment['hash'], $hash_array) ? 'checked="checked"' : '',
            $webtag,
            urlencode($attachment['filename']),
            format_file_name($attachment['filename']),
            htmlentities_array(gettext('Retry')),
            gettext('Retry'),
            htmlentities_array(gettext('Cancel')),
            gettext('Cancel'),
            format_file_size($attachment['filesize'])
        );
    }

    return $html;
}

function attachments_get_message_link($hash)
{
    if (!$db = db::get()) return false;

    $hash = $db->escape($hash);

    $sql = "SELECT FORUMS.WEBTAG, PAI.TID, PAI.PID FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "INNER JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql .= "INNER JOIN FORUMS ON (FORUMS.FID = PAI.FID) ";
    $sql .= "WHERE PAF.HASH = '$hash'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($forum_webtag, $tid, $pid) = $result->fetch_row();

    return "messages.php?webtag=$forum_webtag&amp;msg=$tid.$pid";
}

function attachments_get_pm_link($hash)
{
    if (!$db = db::get()) return false;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $hash = $db->escape($hash);

    $sql = "SELECT PAI.MID FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "INNER JOIN PM_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql .= "WHERE PAF.HASH = '$hash'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($mid) = $result->fetch_row();

    return "pm.php?webtag=$webtag&amp;mid=$mid";
}

function attachments_inc_download_count($hash)
{
    if (!$db = db::get()) return false;

    if (!is_md5($hash)) return false;

    $sql = "UPDATE LOW_PRIORITY POST_ATTACHMENT_FILES ";
    $sql .= "SET DOWNLOADS = DOWNLOADS + 1 WHERE HASH = '$hash'";

    if (!$db->query($sql)) return false;

    return true;
}

function attachments_embed_check($content)
{
    if (forum_get_setting('attachments_allow_embed', 'Y')) return false;

    $content_check = preg_replace_callback('/\&amp;\#([0-9]+)\;/um', 'attachments_embed_check_callback', rawurldecode($content));

    return preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+get_attachment.php.+>/iu", $content_check);
}

function attachments_embed_check_callback($match)
{
    return chr($match[1]);
}

function attachments_make_link($attachment, $show_thumbs = true, $limit_filename = false, $local_path = false, $img_tag = true)
{
    if (!is_array($attachment)) return false;

    if (!is_bool($show_thumbs)) $show_thumbs = true;
    if (!is_bool($limit_filename)) $limit_filename = false;
    if (!is_bool($local_path)) $local_path = false;
    if (!is_bool($img_tag)) $img_tag = true;

    if (!($attachment_dir = attachments_check_dir())) return false;

    if (!isset($attachment['hash'])) return false;
    if (!isset($attachment['filename'])) return false;
    if (!isset($attachment['downloads'])) return false;
    if (!is_md5($attachment['hash'])) return false;

    $thumbnail_max_size = 100;

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (isset($_SESSION['SHOW_THUMBS']) && is_numeric($_SESSION['SHOW_THUMBS'])) {
        $user_show_thumbs = intval($_SESSION['SHOW_THUMBS']);
    } else {
        $user_show_thumbs = 100;
    }

    if ($show_thumbs && forum_get_setting('attachment_thumbnails', 'Y') && ($user_show_thumbs > 0 || !session::logged_in())) {

        $thumbnail_size = array(
            1 => 50,
            2 => 100,
            3 => 150
        );

        $thumbnail_max_size = isset($thumbnail_size[$user_show_thumbs]) ? $thumbnail_size[$user_show_thumbs] : 100;

    } else {

        $show_thumbs = false;
    }

    if ($local_path) {

        $attachment_href = "attachments/{$attachment['filename']}";

    } else {

        $attachment_href = "get_attachment.php?webtag=$webtag&amp;hash={$attachment['hash']}";
        $attachment_href .= "&amp;filename={$attachment['filename']}";
    }

    if ($img_tag) {

        $title_array = array();

        if (mb_strlen($attachment['filename']) > 16 && $limit_filename) {

            $title_array[] = sprintf(gettext("Filename: %s"), $attachment['filename']);
            $attachment['filename'] = format_file_name($attachment['filename']);
        }

        if (isset($attachment['filesize']) && is_numeric($attachment['filesize']) && $attachment['filesize'] > 0) {
            $title_array[] = sprintf(gettext("Size: %s"), format_file_size($attachment['filesize']));
        }

        if ($attachment['downloads'] == 1) {
            $title_array[] = gettext("Downloaded: 1 time");
        } else {
            $title_array[] = sprintf(gettext("Downloaded: %d times"), $attachment['downloads']);
        }

        if (isset($attachment['width'], $attachment['height'])) {
            $title_array[] = sprintf(gettext("Dimensions %dx%dpx"), $attachment['width'], $attachment['height']);
        }

        $title = implode(", ", $title_array);

        if ($show_thumbs && isset($attachment['thumbnail']) && ($attachment['thumbnail'] == 'Y')) {

            $thumbnail_width = 150;
            $thumbnail_height = 150;

            while ($thumbnail_width > $thumbnail_max_size) {

                $thumbnail_width--;
                $thumbnail_height--;
            }

            $attachment_link = "<a href=\"$attachment_href\" target=\"_blank\"><span class=\"attachment_thumb\" ";
            $attachment_link .= "style=\"background-image: url('$attachment_href&amp;thumb=1'); ";
            $attachment_link .= "width: {$thumbnail_width}px; height: {$thumbnail_height}px\" ";
            $attachment_link .= "title=\"$title\"></span></a>";

        } else {

            $attachment_link = html_style_image('attach', gettext("Attachment"));
            $attachment_link .= "<a href=\"$attachment_href\" title=\"$title\" ";
            $attachment_link .= "target=\"_blank\">{$attachment['filename']}</a>";
        }

        return $attachment_link;
    }

    return $attachment_href;
}

function attachments_get_mime_types()
{
    if (($allowed_mimetypes = forum_get_setting('attachment_mime_types', 'strlen', false)) !== false) {
        return array_map('trim', explode("\n", $allowed_mimetypes));
    }

    return array();
}