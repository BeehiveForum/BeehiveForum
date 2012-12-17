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

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

$uid = session::get_value('UID');

$content = '';

if (!session::logged_in()) {
    exit;
}

if (forum_get_setting('attachments_enabled', 'N')) {

    header_status(500, 'Internal Server Error');
    exit;
}

if (!$attachment_dir = attachments_check_dir()) {

    header_status(500, 'Internal Server Error');
    exit;
}

$error = null;

$attachment_details = null;

$valid = true;

$file_hash = md5(uniqid(mt_rand()));

$max_user_attachment_space = forum_get_setting('attachments_max_user_space', null, 1048576);

$free_upload_space = attachments_get_free_user_space($uid);

$attachment_mime_types = attachments_get_mime_types();

$total_attachment_size = 0;

$attachment_dir = rtrim($attachment_dir, '/');

header('Content-Type: application/json');

if (isset($_POST['summary'])) {

    if (isset($_POST['hashes']) && is_array($_POST['hashes'])) {
        $hash_array = array_filter($_POST['hashes'], 'is_md5');
    } else {
        $hash_array = array();
    }

    $used_post_space = format_file_size(attachments_get_post_used_space($uid, $hash_array));

    $free_post_space = attachments_get_free_post_space($uid, $hash_array);

    echo json_encode(
        array(
            'used_post_space' => $used_post_space,
            'free_post_space' => ($free_post_space > -1) ? format_file_size($free_post_space) : gettext("Unlimited"),
            'free_upload_space' => ($free_upload_space > -1) ? format_file_size($free_upload_space) : gettext("Unlimited"),
        )
    );

    exit;
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['hashes']) && is_array($_POST['hashes'])) {

        foreach ($_POST['hashes'] as $hash) {

            if (!attachments_delete($hash)) {

                $valid = false;
            }
        }
    }

    echo json_encode($valid);

} else {

    if (isset($_FILES['upload']) && is_array($_FILES['upload'])) {

        for ($i = 0; $i < sizeof($_FILES['upload']['name']); $i++) {

            if (isset($_FILES['upload']['name'][$i]) && strlen(trim($_FILES['upload']['name'][$i])) > 0) {

                $file_name = trim($_FILES['upload']['name'][$i]);

                if (isset($_FILES['upload']['error'][$i]) && $_FILES['upload']['error'][$i] != UPLOAD_ERR_OK) {

                    $valid = false;
                    $error = gettext('Upload failed1');

                } else {

                    $file_size = $_FILES['upload']['size'][$i];

                    $temp_file = $_FILES['upload']['tmp_name'][$i];

                    $file_type = $_FILES['upload']['type'][$i];

                    $file_path = "$attachment_dir/$file_hash";

                    if (!@move_uploaded_file($temp_file, $file_path)) {

                        @unlink($temp_file);

                        $valid = false;

                        $error = gettext('Upload failed2');
                    }
                }
            }
        }

    } else if (isset($_GET['upload']) && is_array($_GET['upload'])) {

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

            $thumbnail = image_resize($file_path, $file_path. '.thumb');

            $attachment_aid = attachments_add($uid, $file_name, $file_hash, $file_type, $file_size, $thumbnail);

            $attachment_details = attachments_get_by_aid($attachment_aid, $uid);
        }
    }

    echo json_encode(array(
        'error' => $error,
        'attachment' => $attachment_details,
        'preventRetry' => true,
        'success' => $valid,
    ));
}

?>