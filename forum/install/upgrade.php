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

if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) == 'upgrade.php') {

    header("Request-URI: index.php");
    header("Content-Location: index.php");
    header("Location: index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'install.inc.php';

@set_time_limit(0);

$current_datetime = date(MYSQL_DATETIME, time());

if (!($forum_prefix_array = install_get_table_data())) {

    $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE AID AID_OLD VARCHAR(32) NOT NULL, CHANGE ID ID MEDIUMINT(8) UNSIGNED NOT NULL, DROP PRIMARY KEY";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN AID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY(AID)";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN FILESIZE BIGINT(8) UNSIGNED NOT NULL AFTER MIMETYPE";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN WIDTH SMALLINT(5) UNSIGNED DEFAULT NULL AFTER FILESIZE";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}
$sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN HEIGHT SMALLINT(5) UNSIGNED DEFAULT NULL AFTER WIDTH";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN THUMBNAIL CHAR(1) NOT NULL AFTER HEIGHT";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE FILENAME FILENAME VARCHAR(255) NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE MIMETYPE MIMETYPE VARCHAR(255) NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE HASH HASH VARCHAR(32) NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE AID AID_OLD CHAR(32) NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS ADD COLUMN AID MEDIUMINT(8) UNSIGNED NOT NULL AFTER PID";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE PID PID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS DROP PRIMARY KEY";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS ADD PRIMARY KEY(FID, TID, PID, AID)";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_ATTACHMENT_IDS CHANGE AID AID_OLD CHAR(32) NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_ATTACHMENT_IDS ADD COLUMN AID MEDIUMINT(8) UNSIGNED NOT NULL AFTER MID";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_ATTACHMENT_IDS CHANGE MID MID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_ATTACHMENT_IDS DROP PRIMARY KEY";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_ATTACHMENT_IDS ADD PRIMARY KEY(MID, AID)";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "REPLACE INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
$sql.= "SELECT POST_ATTACHMENT_IDS.FID, POST_ATTACHMENT_IDS.TID, ";
$sql.= "POST_ATTACHMENT_IDS.PID, POST_ATTACHMENT_FILES.AID ";
$sql.= "FROM POST_ATTACHMENT_FILES INNER JOIN POST_ATTACHMENT_IDS ";
$sql.= "ON (POST_ATTACHMENT_IDS.AID_OLD = POST_ATTACHMENT_FILES.AID_OLD)";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_IDS DROP COLUMN AID_OLD";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "DELETE FROM POST_ATTACHMENT_IDS WHERE AID = 0";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "REPLACE INTO PM_ATTACHMENT_IDS (MID, AID) ";
$sql.= "SELECT PM_ATTACHMENT_IDS.MID, POST_ATTACHMENT_FILES.AID ";
$sql.= "FROM POST_ATTACHMENT_FILES INNER JOIN PM_ATTACHMENT_IDS ";
$sql.= "ON (PM_ATTACHMENT_IDS.AID_OLD = POST_ATTACHMENT_FILES.AID_OLD)";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_ATTACHMENT_IDS DROP COLUMN AID_OLD";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "DELETE FROM PM_ATTACHMENT_IDS WHERE AID = 0";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES DROP COLUMN AID_OLD";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE POST_ATTACHMENT_FILES DROP COLUMN ID";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

foreach ($forum_prefix_array as $forum_fid => $table_data) {

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` INNER JOIN POST_ATTACHMENT_FILES ";
    $sql.= "ON (POST_ATTACHMENT_FILES.HASH = `{$table_data['PREFIX']}USER_PREFS`.AVATAR_AID) ";
    $sql.= "SET `{$table_data['PREFIX']}USER_PREFS`.AVATAR_AID = POST_ATTACHMENT_FILES.AID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` INNER JOIN POST_ATTACHMENT_FILES ";
    $sql.= "ON (POST_ATTACHMENT_FILES.HASH = `{$table_data['PREFIX']}USER_PREFS`.PIC_AID) ";
    $sql.= "SET `{$table_data['PREFIX']}USER_PREFS`.PIC_AID = POST_ATTACHMENT_FILES.AID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE PIC_AID PIC_AID MEDIUMINT(11) NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE AVATAR_AID AVATAR_AID MEDIUMINT(11) NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` SET AVATAR_AID = NULL WHERE AVATAR_AID = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` SET PIC_AID = NULL WHERE PIC_AID = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

$sql = "UPDATE USER_PREFS INNER JOIN POST_ATTACHMENT_FILES ";
$sql.= "ON (POST_ATTACHMENT_FILES.HASH = USER_PREFS.AVATAR_AID) ";
$sql.= "SET USER_PREFS.AVATAR_AID = POST_ATTACHMENT_FILES.AID";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "UPDATE USER_PREFS INNER JOIN POST_ATTACHMENT_FILES ";
$sql.= "ON (POST_ATTACHMENT_FILES.HASH = USER_PREFS.PIC_AID) ";
$sql.= "SET USER_PREFS.PIC_AID = POST_ATTACHMENT_FILES.AID";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE PIC_AID PIC_AID MEDIUMINT(11) NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE AVATAR_AID AVATAR_AID MEDIUMINT(11) NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "UPDATE USER_PREFS SET AVATAR_AID = NULL WHERE AVATAR_AID = 0";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "UPDATE USER_PREFS SET PIC_AID = NULL WHERE PIC_AID = 0";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "UPDATE USER_PREFS SET POST_PAGE = 63";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

if (($attachment_dir = forum_get_global_setting('attachment_dir', null, false)) !== false) {

    $attachment_dir = rtrim($attachment_dir, '/');

    if (!($attachment_realpath = realpath($attachment_dir))) {

        if (!($attachment_realpath = realpath(sprintf('../%s', $attachment_dir)))) {

            $error_html.= "<h2>Could not locate attachment directory!</h2>\n";
            $valid = false;
            return;
        }
    }

    $attachments = glob(sprintf('%s/*', $attachment_realpath));

    $pattern_match = sprintf('/^%s\/([A-Fa-f0-9]{32})$/Du', preg_quote($attachment_realpath, '/'));

    foreach ($attachments as $attachment) {

        if (is_dir($attachment) || !preg_match($pattern_match, $attachment, $matches_array)) {
            continue;
        }

        $image_width = 'NULL';

        $image_height = 'NULL';

        $thumbnail = 'N';

        $hash = $db->escape($matches_array[1]);

        $filesize = $db->escape(filesize($attachment));

        if (($image_info = @getimagesize($attachment)) !== false) {

            $image_width = $db->escape($image_info[0]);

            $image_height = $db->escape($image_info[1]);

            $thumbnail = @file_exists($attachment. '.thumb') ? 'Y' : 'N';
        }

        $sql = "UPDATE POST_ATTACHMENT_FILES SET FILESIZE = '$filesize', ";
        $sql.= "WIDTH = $image_width, HEIGHT = $image_height, ";
        $sql.= "THUMBNAIL = '$thumbnail' WHERE HASH = '$hash'";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }
    }

    $sql = "DELETE FROM POST_ATTACHMENT_IDS WHERE AID NOT IN (SELECT AID FROM POST_ATTACHMENT_FILES)";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DELETE FROM PM_ATTACHMENT_IDS WHERE AID NOT IN (SELECT AID FROM POST_ATTACHMENT_FILES)";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

?>