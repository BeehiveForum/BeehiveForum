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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'image.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

if (!session::logged_in()) {
    exit;
}

if (!($attachment_dir = attachments_check_dir())) {

    header_status(500, 'Internal Server Error');
    exit;
}

$valid = true;

$error = null;
$attachment_details = null;
$content = null;
$file_type = null;
$temp_file = null;
$file_size = null;
$file_name = null;

$content_type = 'text/html; charset=UTF-8';

$file_hash = md5(uniqid(mt_rand()));

$max_user_attachment_space = forum_get_setting('attachments_max_user_space', 'is_numeric', 1048576);

$free_upload_space = attachments_get_free_user_space($_SESSION['UID']);

$attachment_mime_types = attachments_get_mime_types();

$total_attachment_size = 0;

$attachment_dir = rtrim($attachment_dir, '/');

if (isset($_POST['summary'])) {

    if (isset($_POST['hashes']) && is_array($_POST['hashes'])) {
        $hash_array = array_filter($_POST['hashes'], 'is_md5');
    } else {
        $hash_array = array();
    }

    $used_post_space = format_file_size(attachments_get_post_used_space($_SESSION['UID'], $hash_array));

    $free_post_space = attachments_get_free_post_space($_SESSION['UID'], $hash_array);

    $content_type = 'application/json; charset=UTF-8';

    $content = json_encode(
        array(
            'used_post_space' => $used_post_space,
            'free_post_space' => ($free_post_space > -1) ? format_file_size($free_post_space) : gettext("Unlimited"),
            'free_upload_space' => ($free_upload_space > -1) ? format_file_size($free_upload_space) : gettext("Unlimited"),
        )
    );

} else if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['hashes']) && is_array($_POST['hashes'])) {

        foreach ($_POST['hashes'] as $hash) {

            if (!attachments_delete($hash)) {

                $valid = false;
            }
        }
    }

    $content_type = 'application/json; charset=UTF-8';

    $content = json_encode($valid);

} else {

    if (isset($_FILES['upload']) && is_array($_FILES['upload'])) {

        for ($i = 0; $i < sizeof($_FILES['upload']['name']); $i++) {

            if (isset($_FILES['upload']['name'][$i]) && strlen(trim($_FILES['upload']['name'][$i])) > 0) {

                $file_name = trim($_FILES['upload']['name'][$i]);

                if (isset($_FILES['upload']['error'][$i]) && $_FILES['upload']['error'][$i] != UPLOAD_ERR_OK) {

                    $valid = false;
                    $error = gettext('Upload had errors');

                } else {

                    $file_size = $_FILES['upload']['size'][$i];

                    $temp_file = $_FILES['upload']['tmp_name'][$i];

                    $file_type = $_FILES['upload']['type'][$i];

                    $file_path = "$attachment_dir/$file_hash";

                    if (!@move_uploaded_file($temp_file, $file_path)) {

                        @unlink($temp_file);

                        $valid = false;

                        $error = gettext('Failed to move uploaded file.');
                    }
                }
            }
        }

    } else if (isset($_GET['upload']) && is_array($_GET['upload'])) {

        $content_type = 'application/json; charset=UTF-8';

        $file_name = trim(array_shift($_GET['upload']));

        $file_type = 'application/octet-stream';

        $file_path = "$attachment_dir/$file_hash";

        file_put_contents($file_path, fopen('php://input', 'r'));

        $file_size = filesize($file_path);
    }

    if ($valid) {

        if (function_exists('mime_content_type') && ($magic_mime_type = mime_content_type($file_path))) {
            $file_type = $magic_mime_type;
        }

        if (sizeof($attachment_mime_types) > 0 && !in_array($file_type, $attachment_mime_types)) {

            @unlink($file_path);

            @unlink($temp_file);

            $valid = false;

            $error = gettext('Attachment mimetype is not allowed');

        } else if (($max_user_attachment_space > 0) && ($free_upload_space > -1) && ($free_upload_space < $file_size)) {

            @unlink($file_path);

            @unlink($temp_file);

            $valid = false;

            $error = gettext('You do not have enough free attachment space');

        } else {

            $image_width = null;

            $image_height = null;

            $thumbnail = false;

            if (($image_info = @getimagesize($file_path)) !== false) {

                $image_width = $image_info[0];

                $image_height = $image_info[1];

                image_rotate($file_path);

                $thumbnail = image_resize($file_path, $file_path . '.thumb');
            }

            if (($attachment_aid = attachments_add($_SESSION['UID'], $file_name, $file_hash, $file_type, $file_size, $image_width, $image_height, $thumbnail)) !== false) {

                $attachment_details = attachments_get_by_aid($attachment_aid, $_SESSION['UID']);

            } else {

                @unlink($file_path);

                @unlink($file_path . '.thumb');

                @unlink($temp_file);

                $valid = false;

                $error = gettext('Attachment failed to upload. Please try again.');
            }
        }
    }

    $content = json_encode(array(
        'error' => $error,
        'attachment' => $attachment_details,
        'preventRetry' => true,
        'success' => $valid,
    ));
}

header(sprintf('Content-type: %s', $content_type));

echo $content;