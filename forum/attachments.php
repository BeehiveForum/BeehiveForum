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

if (isset($_GET['aid']) && is_md5($_GET['aid'])) {
    $aid = $_GET['aid'];
} else if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else {
    header_status(500, 'Internal Server Error');
    exit;
}

$max_attachment_space = attachments_get_max_space();

$users_free_space = attachments_get_free_space($uid, $aid);

$attachment_mime_types = attachments_get_mime_types();

$total_attachment_size = 0;

$attachment_dir = rtrim($attachment_dir, '/');

if (isset($_FILES['file']) && is_array($_FILES['file'])) {

    for ($i = 0; $i < sizeof($_FILES['file']['name']); $i++) {

        if (isset($_FILES['file']['name'][$i]) && strlen(trim($_FILES['file']['name'][$i])) > 0) {

            $filename = trim($_FILES['file']['name'][$i]);

            if (isset($_FILES['file']['error'][$i]) && $_FILES['file']['error'][$i] != UPLOAD_ERR_OK) {

                $content = json_encode(array(
                    'success' => false,
                    'error' => gettext('Upload Failed'),
                    'preventRetry' => true,
                ));

            } else {

                $file_size = $_FILES['file']['size'][$i];
                $temp_file = $_FILES['file']['tmp_name'][$i];
                $file_type = $_FILES['file']['type'][$i];

                if (function_exists('mime_content_type') && ($magic_mime_type = mime_content_type($temp_file))) {
                    $file_type = $magic_mime_type;
                }

                if (sizeof($attachment_mime_types) > 0 && !in_array($file_type, $attachment_mime_types)) {

                    if (@file_exists($temp_file)) {
                        unlink($temp_file);
                    }

                    $content = json_encode(array(
                        'success' => false,
                        'error' => gettext('File type is not allowed'),
                        'preventRetry' => true
                    ));

                } else if (($max_attachment_space > 0) && ($users_free_space < $file_size)) {

                    if (@file_exists($temp_file)) {
                        unlink($temp_file);
                    }

                    $content = json_encode(array(
                        'success' => false,
                        'error' => gettext('Check free attachment space'),
                        'preventRetry' => true
                    ));

                } else {

                    $unique_file_id = md5(uniqid(mt_rand()));

                    $file_hash = md5("{$aid}{$unique_file_id}{$filename}");

                    $file_path = "$attachment_dir/$file_hash";

                    if (@move_uploaded_file($temp_file, $file_path)) {

                        attachments_add($uid, $aid, $unique_file_id, $filename, $file_type);

                        image_resize($file_path, $file_path. '.thumb');

                        if (($users_free_space > 0)) {
                            $users_free_space -= $file_size;
                        }

                        $content = json_encode(array(
                            'success' => true,
                            'hash' => $file_hash
                        ));

                    } else {

                        if (@file_exists($temp_file)) {
                            unlink($temp_file);
                        }

                        $content = json_encode(array(
                            'success' => false,
                            'error' => gettext('Upload failed'),
                            'preventRetry' => true
                        ));
                    }
                }
            }
        }
    }

} else if (isset($_GET['file']) && is_array($_GET['file'])) {

    $filename = trim(array_shift($_GET['file']));

    $temp_file = tempnam(attachments_get_upload_tmp_dir(), 'file');

    $file_type = 'application/octet-stream';

    file_put_contents($temp_file, fopen('php://input', 'r'));

    $file_size = filesize($temp_file);

    if (function_exists('mime_content_type') && ($magic_mime_type = mime_content_type($temp_file))) {
        $file_type = $magic_mime_type;
    }

    if (sizeof($attachment_mime_types) > 0 && !in_array($file_type, $attachment_mime_types)) {

        if (@file_exists($temp_file)) {
            unlink($temp_file);
        }

        $content = json_encode(array(
            'success' => false,
            'error' => gettext('File type is not allowed'),
            'preventRetry' => true
        ));

    } else if (($max_attachment_space > 0) && ($users_free_space < $file_size)) {

        if (@file_exists($temp_file)) {
            unlink($temp_file);
        }

        $content = json_encode(array(
            'success' => false,
            'error' => gettext('Check free attachment space'),
            'preventRetry' => true
        ));

    } else {

        $unique_file_id = md5(uniqid(mt_rand()));

        $file_hash = md5("{$aid}{$unique_file_id}{$filename}");

        $file_path = "$attachment_dir/$file_hash";

        if (@rename($temp_file, $file_path)) {

            attachments_add($uid, $aid, $unique_file_id, $filename, $file_type);

            image_resize($file_path, $file_path. '.thumb');

            if (($users_free_space > 0)) {
                $users_free_space -= $file_size;
            }

            $content = json_encode(array(
                'success' => true,
                'hash' => $file_hash
            ));

        } else {

            if (@file_exists($temp_file)) {
                unlink($temp_file);
            }

            $content = json_encode(array(
                'success' => false,
                'error' => gettext('Upload failed'),
                'preventRetry' => true
            ));
        }
    }

} else if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['attachments_delete']) && is_array($_POST['attachments_delete'])) {

        foreach ($_POST['attachments_delete'] as $hash => $del_attachment) {

            if (($del_attachment == 'Y') && attachments_get_by_hash($hash)) {

                if (!attachments_delete($hash)) {
                    $valid = false;
                }
            }
        }

        $content = json_encode($valid);
    }
}

header('Content-Type: application/json');

echo $content;

?>