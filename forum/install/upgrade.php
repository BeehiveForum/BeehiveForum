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

if (!install_table_exists($config['db_database'], 'USER_PERM')) {

    $sql = "CREATE TABLE GROUPS_NEW (";
    $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  GROUP_NAME VARCHAR(32) NOT NULL,";
    $sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
    $sql.= "  GID_OLD MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  PRIMARY KEY (GID),";
    $sql.= "  KEY FORUM (FORUM)";
    $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE GROUP_PERMS_NEW (";
    $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  PERM INT(32) UNSIGNED NOT NULL,";
    $sql.= "  PRIMARY KEY (GID,FID)";
    $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE GROUP_USERS_NEW (";
    $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  PRIMARY KEY (GID,UID)";
    $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE USER_PERM (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  PERM INT(32) UNSIGNED NOT NULL,";
    $sql.= "  PRIMARY KEY (UID,FORUM,FID)";
    $sql.= ") ENGINE=MYISAM CHARSET=UTF8";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO GROUPS_NEW (FORUM, GROUP_NAME, GROUP_DESC, GID_OLD) ";
    $sql.= "SELECT GROUP_PERMS.FORUM, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC, ";
    $sql.= "GROUPS.GID FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql.= "ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "GROUP BY GROUPS.GID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO GROUP_PERMS_NEW SELECT DISTINCT GROUPS_NEW.GID, ";
    $sql.= "GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUP_USERS ";
    $sql.= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "INNER JOIN GROUPS ON (GROUPS.GID = GROUP_USERS.GID) INNER JOIN GROUPS_NEW ";
    $sql.= "ON (GROUPS_NEW.GID_OLD = GROUPS.GID) GROUP BY GID, FID ";
    $sql.= "ORDER BY GID, FID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO GROUP_USERS_NEW SELECT GROUPS_NEW.GID, GROUP_USERS.UID ";
    $sql.= "FROM GROUP_USERS INNER JOIN GROUPS_NEW ON (GROUPS_NEW.GID_OLD = GROUP_USERS.GID)";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO USER_PERM SELECT DISTINCT GROUP_USERS.UID, GROUP_PERMS.FORUM, ";
    $sql.= "GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUP_USERS ";
    $sql.= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql.= "LEFT JOIN GROUPS ON (GROUPS.GID = GROUP_USERS.GID) WHERE GROUPS.GID IS NULL ";
    $sql.= "GROUP BY UID, FORUM, FID ORDER BY UID, FORUM, FID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE GROUPS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE GROUP_PERMS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE GROUP_USERS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "RENAME TABLE GROUPS_NEW TO GROUPS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "RENAME TABLE GROUP_PERMS_NEW TO GROUP_PERMS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "RENAME TABLE GROUP_USERS_NEW TO GROUP_USERS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE GROUPS DROP COLUMN GID_OLD";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (!install_table_exists($config['db_database'], 'PM_RECIPIENT')) {

    $sql = "CREATE TABLE PM_RECIPIENT ( ";
    $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  NOTIFIED CHAR(1) NOT NULL DEFAULT 'N',";
    $sql.= "  PRIMARY KEY (MID,TO_UID)";
    $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE PM_TYPE (";
    $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL,";
    $sql.= "  PRIMARY KEY (MID,UID,TYPE)";
    $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO PM_CONTENT SELECT MID, NULL FROM PM WHERE MID NOT IN (SELECT MID FROM PM_CONTENT)";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DELETE FROM PM_CONTENT WHERE MID NOT IN (SELECT MID FROM PM)";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO PM_RECIPIENT SELECT PM.MID, PM.TO_UID, IF(PM.NOTIFIED = 1, 'Y', 'N') ";
    $sql.= "FROM PM WHERE PM.TYPE & 1 = 1 OR PM.TYPE & 2 = 2 OR PM.TYPE & 4 = 4 ";
    $sql.= "OR PM.TYPE & 16 = 16 OR PM.TYPE & 32 = 32";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO PM_TYPE SELECT PM.MID, PM.TO_UID, PM.TYPE FROM PM ";
    $sql.= "WHERE PM.TYPE & 1 = 1 OR PM.TYPE & 2 = 2 OR PM.TYPE & 4 = 4 ";
    $sql.= "OR PM.TYPE & 16 = 16 OR PM.TYPE & 32 = 32";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO PM_RECIPIENT SELECT PM.MID, PM.TO_UID, IF(PM.NOTIFIED = 1, 'Y', 'N') ";
    $sql.= "FROM PM WHERE PM.TYPE & 8 = 8 AND PM.SMID = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO PM_TYPE SELECT PM.MID, PM.FROM_UID, PM.TYPE FROM PM ";
    $sql.= "WHERE PM.TYPE & 8 = 8 AND PM.SMID = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DELETE FROM PM_RECIPIENT WHERE TO_UID = 0 OR TO_UID IS NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM DROP COLUMN TYPE";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM DROP COLUMN TO_UID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM DROP COLUMN RECIPIENTS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM DROP COLUMN NOTIFIED";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM DROP COLUMN SMID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM ADD COLUMN REPLY_TO_MID MEDIUMINT(8) UNSIGNED NULL AFTER MID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM CHANGE FROM_UID FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM CHANGE SUBJECT SUBJECT VARCHAR(64) NOT NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM CHANGE CREATED CREATED DATETIME NOT NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'RELEVANCE')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS ADD COLUMN RELEVANCE FLOAT UNSIGNED NOT NULL AFTER MID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'TYPE')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS DROP COLUMN TYPE";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'FROM_UID')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS DROP COLUMN FROM_UID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

}

if (install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'TO_UID')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS DROP COLUMN TO_UID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'SUBJECT')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS DROP COLUMN SUBJECT";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'RECIPIENTS')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS DROP COLUMN RECIPIENTS";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'PM_SEARCH_RESULTS', 'CREATED')) {

    $sql = "ALTER TABLE PM_SEARCH_RESULTS DROP COLUMN CREATED";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

$sql = "ALTER TABLE PM_SEARCH_RESULTS CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE PM_SEARCH_RESULTS CHANGE MID MID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

if (!install_column_exists($config['db_database'], 'POST_ATTACHMENT_FILES', 'FILESIZE')) {

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
}

if (install_column_exists($config['db_database'], 'SEARCH_RESULTS', 'BY_UID')) {

    $sql = "ALTER TABLE SEARCH_RESULTS DROP COLUMN BY_UID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'SEARCH_RESULTS', 'FROM_UID')) {

    $sql = "ALTER TABLE SEARCH_RESULTS DROP COLUMN FROM_UID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

}

if (install_column_exists($config['db_database'], 'SEARCH_RESULTS', 'TO_UID')) {

    $sql = "ALTER TABLE SEARCH_RESULTS DROP COLUMN TO_UID";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'SEARCH_RESULTS', 'CREATED')) {

    $sql = "ALTER TABLE SEARCH_RESULTS DROP COLUMN CREATED";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

if (install_column_exists($config['db_database'], 'SEARCH_RESULTS', 'LENGTH')) {

    $sql = "ALTER TABLE SEARCH_RESULTS DROP COLUMN LENGTH";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }
}

$sql = "ALTER TABLE SEARCH_RESULTS CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_RESULTS CHANGE FORUM FORUM MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_RESULTS CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_RESULTS CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_RESULTS CHANGE PID PID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_RESULTS CHANGE RELEVANCE RELEVANCE FLOAT UNSIGNED NOT NULL";

if (!($result = $db->query($sql))) {

    $valid = false;
    return;
}

foreach ($forum_prefix_array as $forum_fid => $table_data) {

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_POST", 'INDEXED')) {

        $sql = "ALTER TABLE `{$forum_table_prefix}POST` ADD COLUMN INDEXED DATETIME NULL";

        if (!@$db->query($sql)) {
            throw new Exception('Failed to create table POST_SEARCH_ID');
        }

        $sql = "DROP TABLE IF EXISTS `{$forum_table_prefix}POST_SEARCH_ID`";

        if (!@$db->query($sql)) {
            throw new Exception('Failed to create table POST_SEARCH_ID');
        }

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_SEARCH_ID` (";
        $sql.= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  PRIMARY KEY  (SID,TID,PID)";
        $sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

        if (!@$db->query($sql)) {
            throw new Exception('Failed to create table POST_SEARCH_ID');
        }
    }

    if (!install_table_exists($config['db_database'], "{$table_data['WEBTAG']}_POST_RATING")) {

        $sql = "CREATE TABLE `{$forum_table_prefix}POST_RATING` (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  RATING TINYINT(4) NOT NULL,";
        $sql.= "  PRIMARY KEY (TID,PID,UID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_USER_TRACK", 'USER_KEY')) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}USER_TRACK_NEW` (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  USER_KEY VARCHAR(255) NOT NULL,";
        $sql.= "  USER_VALUE TEXT,";
        $sql.= "  PRIMARY KEY (UID,USER_KEY)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }

        $user_track_keys = array(
            'DDKEY',
            'LAST_POST',
            'LAST_SEARCH',
            'LAST_SEARCH_KEYWORDS',
            'LAST_SEARCH_SORT_BY',
            'LAST_SEARCH_SORT_DIR',
            'POST_COUNT'
        );

        foreach ($user_track_keys as $user_key) {

            $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK_NEW` (UID, USER_KEY, USER_VALUE) ";
            $sql.= "SELECT UID, '$user_key', `$user_key` FROM `{$table_data['PREFIX']}USER_TRACK`";

            if (!($result = $db->query($sql))) {

                $valid = false;
                return;
            }
        }

        $sql = "DROP TABLE `{$table_data['PREFIX']}USER_TRACK`";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }

        $sql = "RENAME TABLE `{$table_data['PREFIX']}USER_TRACK_NEW` TO `{$table_data['PREFIX']}USER_TRACK`";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }
    }

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

    if (!install_table_exists($config['db_database'], "{$table_data['WEBTAG']}_POST_RECIPIENT")) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}POST_RECIPIENT` (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  VIEWED DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY (TID,PID,TO_UID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO `{$table_data['PREFIX']}POST_RECIPIENT` (TID, PID, TO_UID, VIEWED) ";
        $sql.= "SELECT TID, PID, TO_UID, VIEWED FROM `{$table_data['PREFIX']}POST`";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN TO_UID;";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN VIEWED";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN STATUS";

        if (!($result = $db->query($sql))) {

            $valid = false;
            return;
        }
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE APPROVED APPROVED DATETIME NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET APPROVED = NULL WHERE APPROVED = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE APPROVED_BY APPROVED_BY MEDIUMINT(8) UNSIGNED NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET APPROVED_BY = NULL WHERE APPROVED_BY = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE EDITED_BY EDITED_BY MEDIUMINT(8) UNSIGNED NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET EDITED_BY = NULL WHERE EDITED_BY = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE IPADDRESS IPADDRESS VARCHAR(255) NULL";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }


    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET IPADDRESS = NULL WHERE LENGTH(IPADDRESS) = 0";

    if (!($result = $db->query($sql))) {

        $valid = false;
        return;
    }

    $sql = "DELETE FROM `{$table_data['PREFIX']}POST_RECIPIENT` WHERE TO_UID = 0";

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