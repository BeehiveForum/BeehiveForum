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

require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'install.inc.php';

@set_time_limit(0);

$current_datetime = date(MYSQL_DATETIME, time());

if (!($forum_prefix_array = install_get_table_data())) {
    throw new Exception("Could not locate any previous Beehive Forum installations");
}

$attachment_real_path = null;

if (($attachment_dir = forum_get_global_setting('attachment_dir', null, false)) !== false) {

    $attachment_dir = rtrim(trim($attachment_dir), '/');

    if (!($attachment_real_path = realpath($attachment_dir))) {

        if (!($attachment_real_path = realpath(__DIR__ . '/../' . $attachment_dir))) {
            throw new Exception("Could not locate attachment directory");
        }
    }
}

/** @noinspection PhpUndefinedVariableInspection */
if (!install_table_exists($config['db_database'], 'USER_PERM')) {

    $sql = "CREATE TABLE GROUPS_NEW (";
    $sql .= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql .= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  GROUP_NAME VARCHAR(32) NOT NULL,";
    $sql .= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
    $sql .= "  GID_OLD MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  PRIMARY KEY (GID),";
    $sql .= "  KEY FORUM (FORUM)";
    $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    $db->query($sql);

    $sql = "CREATE TABLE GROUP_PERMS_NEW (";
    $sql .= "  GID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  PERM INT(32) UNSIGNED NOT NULL,";
    $sql .= "  PRIMARY KEY (GID,FID)";
    $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    $db->query($sql);

    $sql = "CREATE TABLE GROUP_USERS_NEW (";
    $sql .= "  GID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  PRIMARY KEY (GID,UID)";
    $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    $db->query($sql);

    $sql = "CREATE TABLE USER_PERM (";
    $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  PERM INT(32) UNSIGNED NOT NULL,";
    $sql .= "  PRIMARY KEY (UID,FORUM,FID)";
    $sql .= ") ENGINE=MYISAM CHARSET=UTF8";

    $db->query($sql);

    $sql = "INSERT INTO GROUPS_NEW (FORUM, GROUP_NAME, GROUP_DESC, GID_OLD) ";
    $sql .= "SELECT GROUP_PERMS.FORUM, GROUPS.GROUP_NAME, GROUPS.GROUP_DESC, ";
    $sql .= "GROUPS.GID FROM GROUPS INNER JOIN GROUP_PERMS ";
    $sql .= "ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql .= "GROUP BY GROUPS.GID";

    $db->query($sql);

    $sql = "INSERT INTO GROUP_PERMS_NEW SELECT DISTINCT GROUPS_NEW.GID, ";
    $sql .= "GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUP_USERS ";
    $sql .= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql .= "INNER JOIN GROUPS ON (GROUPS.GID = GROUP_USERS.GID) INNER JOIN GROUPS_NEW ";
    $sql .= "ON (GROUPS_NEW.GID_OLD = GROUPS.GID) GROUP BY GID, FID ";
    $sql .= "ORDER BY GID, FID";

    $db->query($sql);

    $sql = "INSERT INTO GROUP_USERS_NEW SELECT GROUPS_NEW.GID, GROUP_USERS.UID ";
    $sql .= "FROM GROUP_USERS INNER JOIN GROUPS_NEW ON (GROUPS_NEW.GID_OLD = GROUP_USERS.GID)";

    $db->query($sql);

    $sql = "INSERT INTO USER_PERM SELECT DISTINCT GROUP_USERS.UID, GROUP_PERMS.FORUM, ";
    $sql .= "GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM FROM GROUP_USERS ";
    $sql .= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID) ";
    $sql .= "LEFT JOIN GROUPS ON (GROUPS.GID = GROUP_USERS.GID) WHERE GROUPS.GID IS NULL ";
    $sql .= "GROUP BY UID, FORUM, FID ORDER BY UID, FORUM, FID";

    $db->query($sql);

    $sql = "DROP TABLE GROUPS";

    $db->query($sql);

    $sql = "DROP TABLE GROUP_PERMS";

    $db->query($sql);

    $sql = "DROP TABLE GROUP_USERS";

    $db->query($sql);

    $sql = "RENAME TABLE GROUPS_NEW TO GROUPS";

    $db->query($sql);

    $sql = "RENAME TABLE GROUP_PERMS_NEW TO GROUP_PERMS";

    $db->query($sql);

    $sql = "RENAME TABLE GROUP_USERS_NEW TO GROUP_USERS";

    $db->query($sql);

    $sql = "ALTER TABLE GROUPS DROP COLUMN GID_OLD";

    $db->query($sql);
}

if (!install_table_exists($config['db_database'], 'PM_RECIPIENT')) {

    $sql = "CREATE TABLE PM_RECIPIENT ( ";
    $sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  NOTIFIED CHAR(1) NOT NULL DEFAULT 'N',";
    $sql .= "  PRIMARY KEY (MID,TO_UID)";
    $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    $db->query($sql);

    $sql = "CREATE TABLE PM_TYPE (";
    $sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  TYPE TINYINT(3) UNSIGNED NOT NULL,";
    $sql .= "  PRIMARY KEY (MID,UID,TYPE)";
    $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

    $db->query($sql);

    $sql = "INSERT INTO PM_CONTENT SELECT MID, NULL FROM PM WHERE MID NOT IN (SELECT MID FROM PM_CONTENT)";

    $db->query($sql);

    $sql = "DELETE FROM PM_CONTENT WHERE MID NOT IN (SELECT MID FROM PM)";

    $db->query($sql);

    $sql = "INSERT INTO PM_RECIPIENT SELECT PM.MID, PM.TO_UID, IF(PM.NOTIFIED = 1, 'Y', 'N') ";
    $sql .= "FROM PM WHERE PM.TYPE & 1 = 1 OR PM.TYPE & 2 = 2 OR PM.TYPE & 4 = 4 ";
    $sql .= "OR PM.TYPE & 16 = 16 OR PM.TYPE & 32 = 32";

    $db->query($sql);

    $sql = "INSERT INTO PM_TYPE SELECT PM.MID, PM.TO_UID, PM.TYPE FROM PM ";
    $sql .= "WHERE PM.TYPE & 1 = 1 OR PM.TYPE & 2 = 2 OR PM.TYPE & 4 = 4 ";
    $sql .= "OR PM.TYPE & 16 = 16 OR PM.TYPE & 32 = 32";

    $db->query($sql);

    $sql = "INSERT INTO PM_RECIPIENT SELECT PM.MID, PM.TO_UID, IF(PM.NOTIFIED = 1, 'Y', 'N') ";
    $sql .= "FROM PM WHERE PM.TYPE & 8 = 8 AND PM.SMID = 0";

    $db->query($sql);

    $sql = "INSERT INTO PM_TYPE SELECT PM.MID, PM.FROM_UID, PM.TYPE FROM PM ";
    $sql .= "WHERE PM.TYPE & 8 = 8 AND PM.SMID = 0";

    $db->query($sql);

    $sql = "DELETE FROM PM_RECIPIENT WHERE TO_UID = 0 OR TO_UID IS NULL";

    $db->query($sql);

    $sql = "ALTER TABLE PM DROP COLUMN TYPE";

    $db->query($sql);

    $sql = "ALTER TABLE PM DROP COLUMN TO_UID";

    $db->query($sql);

    $sql = "ALTER TABLE PM DROP COLUMN RECIPIENTS";

    $db->query($sql);

    $sql = "ALTER TABLE PM DROP COLUMN NOTIFIED";

    $db->query($sql);

    $sql = "ALTER TABLE PM DROP COLUMN SMID";

    $db->query($sql);

    $sql = "ALTER TABLE PM ADD COLUMN REPLY_TO_MID MEDIUMINT(8) UNSIGNED NULL AFTER MID";

    $db->query($sql);

    $sql = "ALTER TABLE PM CHANGE FROM_UID FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE PM CHANGE SUBJECT SUBJECT VARCHAR(64) NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE PM CHANGE CREATED CREATED DATETIME NOT NULL";

    $db->query($sql);
}

$sql = "DROP TABLE IF EXISTS PM_SEARCH_RESULTS";

$db->query($sql);

$sql = "CREATE TABLE PM_SEARCH_RESULTS (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  RELEVANCE FLOAT UNSIGNED NOT NULL, ";
$sql .= "  PRIMARY KEY (UID, MID)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "DROP TABLE IF EXISTS SESSIONS";

$db->query($sql);

$sql = "CREATE TABLE SESSIONS (";
$sql .= "  ID VARCHAR(40) NOT NULL,";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  DATA LONGBLOB NOT NULL,";
$sql .= "  MD5 VARCHAR(32) NOT NULL,";
$sql .= "  TIME DATETIME NOT NULL,";
$sql .= "  IPADDRESS VARCHAR(255) NOT NULL,";
$sql .= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql .= "  SID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql .= "  PRIMARY KEY (ID),";
$sql .= "  UNIQUE KEY SID (SID),";
$sql .= "  KEY REFERER (REFERER),";
$sql .= "  KEY TIME (TIME,FID),";
$sql .= "  KEY UID (UID,SID,TIME,FID)";
$sql .= ") ENGINE=INNODB DEFAULT CHARSET=UTF8";

$db->query($sql);

if (!install_column_exists($config['db_database'], 'POST_ATTACHMENT_FILES', 'FILESIZE')) {

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE AID AID_OLD VARCHAR(32) NOT NULL, CHANGE ID ID MEDIUMINT(8) UNSIGNED NOT NULL, DROP PRIMARY KEY";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN AID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY(AID)";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN FILESIZE BIGINT(8) UNSIGNED NOT NULL AFTER MIMETYPE";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN WIDTH SMALLINT(5) UNSIGNED DEFAULT NULL AFTER FILESIZE";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN HEIGHT SMALLINT(5) UNSIGNED DEFAULT NULL AFTER WIDTH";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES ADD COLUMN THUMBNAIL CHAR(1) NOT NULL AFTER HEIGHT";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE FILENAME FILENAME VARCHAR(255) NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE MIMETYPE MIMETYPE VARCHAR(255) NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES CHANGE HASH HASH VARCHAR(32) NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE AID AID_OLD CHAR(32) NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS ADD COLUMN AID MEDIUMINT(8) UNSIGNED NOT NULL AFTER PID";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS CHANGE PID PID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS DROP PRIMARY KEY";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS ADD PRIMARY KEY(FID, TID, PID, AID)";

    $db->query($sql);

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS CHANGE AID AID_OLD CHAR(32) NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS ADD COLUMN AID MEDIUMINT(8) UNSIGNED NOT NULL AFTER MID";

    $db->query($sql);

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS CHANGE MID MID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS DROP PRIMARY KEY";

    $db->query($sql);

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS ADD PRIMARY KEY(MID, AID)";

    $db->query($sql);

    $sql = "REPLACE INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql .= "SELECT POST_ATTACHMENT_IDS.FID, POST_ATTACHMENT_IDS.TID, ";
    $sql .= "POST_ATTACHMENT_IDS.PID, POST_ATTACHMENT_FILES.AID ";
    $sql .= "FROM POST_ATTACHMENT_FILES INNER JOIN POST_ATTACHMENT_IDS ";
    $sql .= "ON (POST_ATTACHMENT_IDS.AID_OLD = POST_ATTACHMENT_FILES.AID_OLD)";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS DROP COLUMN AID_OLD";

    $db->query($sql);

    $sql = "DELETE FROM POST_ATTACHMENT_IDS WHERE AID = 0";

    $db->query($sql);

    $sql = "REPLACE INTO PM_ATTACHMENT_IDS (MID, AID) ";
    $sql .= "SELECT PM_ATTACHMENT_IDS.MID, POST_ATTACHMENT_FILES.AID ";
    $sql .= "FROM POST_ATTACHMENT_FILES INNER JOIN PM_ATTACHMENT_IDS ";
    $sql .= "ON (PM_ATTACHMENT_IDS.AID_OLD = POST_ATTACHMENT_FILES.AID_OLD)";

    $db->query($sql);

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS DROP COLUMN AID_OLD";

    $db->query($sql);

    $sql = "DELETE FROM PM_ATTACHMENT_IDS WHERE AID = 0";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES DROP COLUMN AID_OLD";

    $db->query($sql);

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES DROP COLUMN ID";

    $db->query($sql);
}

if (!install_column_exists($config['db_database'], 'USER_PREFS', 'ENABLE_WIKI_QUICK_LINKS')) {

    $sql = "ALTER TABLE USER_PREFS ADD COLUMN ENABLE_WIKI_QUICK_LINKS CHAR(1) NULL AFTER ENABLE_WIKI_WORDS";
    $db->query($sql);
}

if (!install_column_exists($config['db_database'], 'USER_PREFS', 'ENABLE_TAGS')) {

    $sql = "ALTER TABLE USER_PREFS ADD COLUMN ENABLE_TAGS CHAR(1) NULL";
    $db->query($sql);
}

if (!install_column_exists($config['db_database'], 'USER_PREFS', 'AUTO_SCROLL_MESSAGES')) {

    $sql = "ALTER TABLE USER_PREFS ADD COLUMN AUTO_SCROLL_MESSAGES CHAR(1) NULL";
    $db->query($sql);
}

$sql = "DROP TABLE IF EXISTS SEARCH_RESULTS";

$db->query($sql);

$sql = "CREATE TABLE SEARCH_RESULTS (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  RELEVANCE FLOAT UNSIGNED NOT NULL, ";
$sql .= "  PRIMARY KEY (UID, FORUM, TID, PID)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

foreach ($forum_prefix_array as $forum_fid => $table_data) {

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_THREAD", 'APPROVED')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD COLUMN APPROVED DATETIME NULL AFTER POLL_FLAG";

        $db->query($sql);

        $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD COLUMN APPROVED_BY MEDIUMINT(8) UNSIGNED NULL AFTER APPROVED";

        $db->query($sql);

        $sql = "UPDATE `{$table_data['PREFIX']}THREAD` INNER JOIN `{$table_data['PREFIX']}POST` ";
        $sql .= "ON (`{$table_data['PREFIX']}POST`.TID = `{$table_data['PREFIX']}THREAD`.TID ";
        $sql .= "AND `{$table_data['PREFIX']}POST`.PID = 1) ";
        $sql .= "SET `{$table_data['PREFIX']}THREAD`.APPROVED = `{$table_data['PREFIX']}POST`.APPROVED, ";
        $sql .= "`{$table_data['PREFIX']}THREAD`.APPROVED_BY = `{$table_data['PREFIX']}POST`.APPROVED_BY";

        $db->query($sql);
    }

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_POST", 'INDEXED')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` ADD COLUMN INDEXED DATETIME NULL";
        $db->query($sql);
    }

    $sql = "DROP TABLE IF EXISTS `{$table_data['PREFIX']}POST_SEARCH_ID`";

    $db->query($sql);

    $sql = "CREATE TABLE `{$table_data['PREFIX']}POST_SEARCH_ID` (";
    $sql .= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql .= "  PRIMARY KEY  (SID,TID,PID)";
    $sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

    $db->query($sql);

    $sql = "TRUNCATE `{$table_data['PREFIX']}POST_SEARCH_ID";

    $db->query($sql);

    $sql = "INSERT INTO `{$table_data['PREFIX']}POST_SEARCH_ID` (TID, PID) ";
    $sql .= "SELECT TID, PID FROM `{$table_data['PREFIX']}POST`";

    $db->query($sql);

    if (!install_table_exists($config['db_database'], "{$table_data['WEBTAG']}_POST_RATING")) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}POST_RATING` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  RATING TINYINT(4) NOT NULL,";
        $sql .= "  CREATED DATETIME NOT NULL,";
        $sql .= "  PRIMARY KEY (TID,PID,UID),";
        $sql .= "  KEY CREATED (CREATED),";
        $sql .= "  KEY RATING (RATING)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);
    }

    if (!install_table_exists($config['db_database'], "{$table_data['WEBTAG']}_POST_TAG")) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}POST_TAG` (";
        $sql .= "  TID MEDIUMINT(11) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(11) UNSIGNED NOT NULL,";
        $sql .= "  TAG MEDIUMINT(11) UNSIGNED NOT NULL,";
        $sql .= "  PRIMARY KEY (TID, PID, TAG)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);
    }

    if (!install_table_exists($config['db_database'], "{$table_data['WEBTAG']}_TAG")) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}TAG` (";
        $sql .= "  TID MEDIUMINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql .= "  TAG VARCHAR(255) DEFAULT NULL,";
        $sql .= "  PRIMARY KEY (TID),";
        $sql .= "  UNIQUE KEY TAG (TAG)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);
    }

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_USER_TRACK", 'USER_KEY')) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}USER_TRACK_NEW` (";
        $sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  USER_KEY VARCHAR(255) NOT NULL,";
        $sql .= "  USER_VALUE TEXT,";
        $sql .= "  PRIMARY KEY (UID,USER_KEY)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

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

            $user_key = $db->escape($user_key);

            $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK_NEW` (UID, USER_KEY, USER_VALUE) ";
            $sql .= "SELECT UID, '$user_key', `$user_key` FROM `{$table_data['PREFIX']}USER_TRACK`";

            $db->query($sql);
        }

        $sql = "DROP TABLE `{$table_data['PREFIX']}USER_TRACK`";

        $db->query($sql);

        $sql = "RENAME TABLE `{$table_data['PREFIX']}USER_TRACK_NEW` TO `{$table_data['PREFIX']}USER_TRACK`";

        $db->query($sql);
    }

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_USER_PREFS", 'ENABLE_WIKI_QUICK_LINKS')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD COLUMN ENABLE_WIKI_QUICK_LINKS CHAR(1) NULL AFTER ENABLE_WIKI_WORDS";
        $db->query($sql);
    }

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_USER_PREFS", 'ENABLE_TAGS')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD COLUMN ENABLE_TAGS CHAR(1) NULL";
        $db->query($sql);
    }

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_USER_PREFS", 'AUTO_SCROLL_MESSAGES')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD COLUMN AUTO_SCROLL_MESSAGES CHAR(1) NULL";
        $db->query($sql);
    }

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` INNER JOIN POST_ATTACHMENT_FILES ";
    $sql .= "ON (POST_ATTACHMENT_FILES.HASH = `{$table_data['PREFIX']}USER_PREFS`.AVATAR_AID) ";
    $sql .= "SET `{$table_data['PREFIX']}USER_PREFS`.AVATAR_AID = POST_ATTACHMENT_FILES.AID";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` INNER JOIN POST_ATTACHMENT_FILES ";
    $sql .= "ON (POST_ATTACHMENT_FILES.HASH = `{$table_data['PREFIX']}USER_PREFS`.PIC_AID) ";
    $sql .= "SET `{$table_data['PREFIX']}USER_PREFS`.PIC_AID = POST_ATTACHMENT_FILES.AID";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE PIC_AID PIC_AID MEDIUMINT(11) NULL";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE AVATAR_AID AVATAR_AID MEDIUMINT(11) NULL";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` SET AVATAR_AID = NULL WHERE AVATAR_AID = 0";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` SET PIC_AID = NULL WHERE PIC_AID = 0";

    $db->query($sql);

    if (!install_table_exists($config['db_database'], "{$table_data['WEBTAG']}_POST_RECIPIENT")) {

        $sql = "CREATE TABLE `{$table_data['PREFIX']}POST_RECIPIENT` (";
        $sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql .= "  VIEWED DATETIME DEFAULT NULL,";
        $sql .= "  PRIMARY KEY (TID,PID,TO_UID)";
        $sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        $db->query($sql);

        $sql = "INSERT INTO `{$table_data['PREFIX']}POST_RECIPIENT` (TID, PID, TO_UID, VIEWED) ";
        $sql .= "SELECT TID, PID, TO_UID, VIEWED FROM `{$table_data['PREFIX']}POST`";

        $db->query($sql);

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN TO_UID;";

        $db->query($sql);

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN VIEWED";

        $db->query($sql);

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN STATUS";

        $db->query($sql);
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE APPROVED APPROVED DATETIME NULL";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET APPROVED = NULL WHERE APPROVED = 0";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE APPROVED_BY APPROVED_BY MEDIUMINT(8) UNSIGNED NULL";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET APPROVED_BY = NULL WHERE APPROVED_BY = 0";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE EDITED_BY EDITED_BY MEDIUMINT(8) UNSIGNED NULL";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET EDITED_BY = NULL WHERE EDITED_BY = 0";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE IPADDRESS IPADDRESS VARCHAR(255) NULL";

    $db->query($sql);

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET IPADDRESS = NULL WHERE LENGTH(IPADDRESS) = 0";

    $db->query($sql);

    $sql = "DELETE FROM `{$table_data['PREFIX']}POST_RECIPIENT` WHERE TO_UID = 0";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE IPADDRESS IPADDRESS VARCHAR(255) NULL";

    $db->query($sql);

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_FORUM_LINKS", 'POSITION')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}FORUM_LINKS` ADD COLUMN POSITION MEDIUMINT(8) UNSIGNED NULL AFTER LID";

        $db->query($sql);

        $sql = "UPDATE `{$table_data['PREFIX']}FORUM_LINKS` SET POSITION = POS";

        $db->query($sql);

        $sql = "ALTER TABLE `{$table_data['PREFIX']}FORUM_LINKS` DROP COLUMN POS";
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}ADMIN_LOG` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER ID, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER UID, ";
    $sql .= "CHANGE ACTION ACTION MEDIUMINT(8) UNSIGNED NOT NULL AFTER CREATED";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}BANNED` ";
    $sql .= "CHANGE BANTYPE BANTYPE TINYINT(4) NOT NULL AFTER ID, ";
    $sql .= "CHANGE BANDATA BANDATA VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER BANTYPE, ";
    $sql .= "CHANGE COMMENT COMMENT VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER BANDATA";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}FOLDER` ";
    $sql .= "CHANGE TITLE TITLE VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER FID, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER DESCRIPTION, ";
    $sql .= "CHANGE ALLOWED_TYPES ALLOWED_TYPES TINYINT(3) NOT NULL AFTER PREFIX, ";
    $sql .= "CHANGE POSITION POSITION MEDIUMINT(8) UNSIGNED NOT NULL AFTER ALLOWED_TYPES";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}FORUM_LINKS` ";
    $sql .= "CHANGE URI URI VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER LID, ";
    $sql .= "CHANGE TITLE TITLE VARCHAR(64) COLLATE UTF8_GENERAL_CI NOT NULL AFTER URI, ";
    $sql .= "CHANGE POSITION POSITION MEDIUMINT(8) UNSIGNED NOT NULL AFTER TITLE ";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS` ";
    $sql .= "CHANGE FID FID SMALLINT(5) UNSIGNED NOT NULL AFTER LID, ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER FID, ";
    $sql .= "CHANGE URI URI VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER UID, ";
    $sql .= "CHANGE TITLE TITLE VARCHAR(64) COLLATE UTF8_GENERAL_CI NOT NULL AFTER URI, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER DESCRIPTION, ";
    $sql .= "CHANGE CLICKS CLICKS MEDIUMINT(8) UNSIGNED NOT NULL AFTER VISIBLE";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS_COMMENT` ";
    $sql .= "CHANGE LID LID SMALLINT(5) UNSIGNED NOT NULL AFTER CID, ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER LID, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER UID";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS_FOLDERS` ";
    $sql .= "CHANGE PARENT_FID PARENT_FID SMALLINT(5) UNSIGNED NULL AFTER FID, ";
    $sql .= "CHANGE NAME NAME VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER PARENT_FID, ";
    $sql .= "CHANGE VISIBLE VISIBLE CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL AFTER NAME";

    $db->query($sql);

    if (!install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_LINKS_VOTE", 'VOTED')) {

        if (install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_LINKS_VOTE", 'TSTAMP')) {

            $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS_VOTE` CHANGE TSTAMP VOTED DATETIME NOT NULL";
            $db->query($sql);

        } else {

            $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS_VOTE` ADD COLUMN VOTED DATETIME NOT NULL AFTER RATING";
            $db->query($sql);
        }
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS_VOTE` ";
    $sql .= "CHANGE LID LID SMALLINT(5) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER LID, ";
    $sql .= "CHANGE RATING RATING SMALLINT(5) UNSIGNED NOT NULL AFTER UID, ";
    $sql .= "CHANGE VOTED VOTED DATETIME NOT NULL AFTER RATING";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL` ";
    $sql .= "CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE CHANGEVOTE CHANGEVOTE TINYINT(1) NOT NULL AFTER CLOSES, ";
    $sql .= "CHANGE POLLTYPE POLLTYPE TINYINT(1) NOT NULL AFTER CHANGEVOTE, ";
    $sql .= "CHANGE SHOWRESULTS SHOWRESULTS TINYINT(1) NOT NULL AFTER POLLTYPE, ";
    $sql .= "CHANGE VOTETYPE VOTETYPE TINYINT(1) UNSIGNED NOT NULL AFTER SHOWRESULTS, ";
    $sql .= "CHANGE OPTIONTYPE OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL AFTER VOTETYPE, ";
    $sql .= "CHANGE ALLOWGUESTS ALLOWGUESTS TINYINT(1) NOT NULL AFTER OPTIONTYPE";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL_QUESTIONS` ";
    $sql .= "CHANGE ALLOW_MULTI ALLOW_MULTI CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL AFTER QUESTION";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` ";
    $sql .= "CHANGE FROM_UID FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER REPLY_TO_PID, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER FROM_UID, ";
    $sql .= "CHANGE IPADDRESS IPADDRESS VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER EDITED_BY ";

    $db->query($sql);

    if (!install_index_exists($config['db_database'], "{$table_data['WEBTAG']}_POST", 'EDITED')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` ADD KEY EDITED(EDITED)";
        $db->query($sql);
    }

    if (!install_index_exists($config['db_database'], "{$table_data['WEBTAG']}_POST", 'INDEXED')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` ADD KEY INDEXED(INDEXED)";
        $db->query($sql);
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST_CONTENT` ";
    $sql .= "CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE PID PID MEDIUMINT(8) UNSIGNED NOT NULL AFTER TID";

    $db->query($sql);

    if (!install_index_exists($config['db_database'], "{$table_data['WEBTAG']}_POST_RECIPIENT", 'VIEWED')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST_RECIPIENT` ADD KEY VIEWED(VIEWED)";
        $db->query($sql);
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}PROFILE_ITEM` ";
    $sql .= "CHANGE PSID PSID MEDIUMINT(8) UNSIGNED NOT NULL AFTER PIID, ";
    $sql .= "CHANGE NAME NAME VARCHAR(64) COLLATE UTF8_GENERAL_CI NOT NULL AFTER PSID, ";
    $sql .= "CHANGE TYPE TYPE TINYINT(3) UNSIGNED NOT NULL AFTER NAME, ";
    $sql .= "CHANGE POSITION POSITION MEDIUMINT(3) UNSIGNED NOT NULL AFTER OPTIONS";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}PROFILE_SECTION` ";
    $sql .= "CHANGE NAME NAME VARCHAR(64) COLLATE UTF8_GENERAL_CI NOT NULL AFTER PSID, ";
    $sql .= "CHANGE POSITION POSITION MEDIUMINT(3) UNSIGNED NOT NULL AFTER NAME";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}RSS_FEEDS` ";
    $sql .= "CHANGE NAME NAME VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER RSSID, ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER NAME, ";
    $sql .= "CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL AFTER UID, ";
    $sql .= "CHANGE URL URL VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER FID, ";
    $sql .= "CHANGE FREQUENCY FREQUENCY MEDIUMINT(8) UNSIGNED NOT NULL AFTER PREFIX, ";
    $sql .= "CHANGE MAX_ITEM_COUNT MAX_ITEM_COUNT MEDIUMINT(8) UNSIGNED NOT NULL AFTER LAST_RUN";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}RSS_HISTORY` ";
    $sql .= "CHANGE RSSID RSSID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE LINK LINK VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER RSSID";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}STATS` ";
    $sql .= "CHANGE MOST_USERS_DATE MOST_USERS_DATE DATETIME NOT NULL AFTER ID, ";
    $sql .= "CHANGE MOST_USERS_COUNT MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL AFTER MOST_USERS_DATE, ";
    $sql .= "CHANGE MOST_POSTS_DATE MOST_POSTS_DATE DATETIME NOT NULL AFTER MOST_USERS_COUNT, ";
    $sql .= "CHANGE MOST_POSTS_COUNT MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL AFTER MOST_POSTS_DATE";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ";
    $sql .= "CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL AFTER TID, ";
    $sql .= "CHANGE BY_UID BY_UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER FID, ";
    $sql .= "CHANGE TITLE TITLE VARCHAR(64) COLLATE UTF8_GENERAL_CI NOT NULL AFTER BY_UID, ";
    $sql .= "CHANGE LENGTH LENGTH MEDIUMINT(8) UNSIGNED NOT NULL AFTER TITLE, ";
    $sql .= "CHANGE POLL_FLAG POLL_FLAG CHAR(1) COLLATE UTF8_GENERAL_CI NULL DEFAULT 'N' AFTER UNREAD_PID, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER APPROVED_BY, ";
    $sql .= "CHANGE STICKY STICKY CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL DEFAULT 'N' AFTER CLOSED";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD_STATS` ";
    $sql .= "CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE VIEWCOUNT VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL AFTER TID";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD_TRACK` ";
    $sql .= "CHANGE TID TID MEDIUMINT(8) NOT NULL FIRST, ";
    $sql .= "CHANGE NEW_TID NEW_TID MEDIUMINT(8) NOT NULL AFTER TID, ";
    $sql .= "CHANGE CREATED CREATED DATETIME NOT NULL AFTER NEW_TID, ";
    $sql .= "CHANGE TRACK_TYPE TRACK_TYPE TINYINT(4) NOT NULL AFTER CREATED";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_FOLDER` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL AFTER UID, ";
    $sql .= "CHANGE INTEREST INTEREST TINYINT(4) NOT NULL AFTER FID";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PEER` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE PEER_UID PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER UID, ";
    $sql .= "CHANGE RELATIONSHIP RELATIONSHIP TINYINT(4) NOT NULL AFTER PEER_UID";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PROFILE` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE PIID PIID MEDIUMINT(8) UNSIGNED NOT NULL AFTER UID, ";
    $sql .= "CHANGE PRIVACY PRIVACY TINYINT(3) UNSIGNED NOT NULL AFTER ENTRY";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_SIG` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST ";

    $db->query($sql);

    if (install_column_exists($config['db_database'], "{$table_data['WEBTAG']}_USER_SIG", 'HTML')) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_SIG` DROP COLUMN HTML";
        $db->query($sql);
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_THREAD` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL AFTER UID, ";
    $sql .= "CHANGE LAST_READ LAST_READ MEDIUMINT(8) UNSIGNED NOT NULL AFTER TID, ";
    $sql .= "CHANGE LAST_READ_AT LAST_READ_AT DATETIME NOT NULL AFTER LAST_READ, ";
    $sql .= "CHANGE INTEREST INTEREST TINYINT(4) NOT NULL DEFAULT 0 AFTER LAST_READ_AT";

    $db->query($sql);

    $sql = "ALTER TABLE `{$table_data['PREFIX']}WORD_FILTER` ";
    $sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
    $sql .= "CHANGE FILTER_NAME FILTER_NAME VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER FID, ";
    $sql .= "CHANGE FILTER_TYPE FILTER_TYPE TINYINT(3) UNSIGNED NOT NULL AFTER REPLACE_TEXT, ";
    $sql .= "CHANGE FILTER_ENABLED FILTER_ENABLED TINYINT(3) UNSIGNED NOT NULL AFTER FILTER_TYPE";
}

$sql = "UPDATE USER_PREFS INNER JOIN POST_ATTACHMENT_FILES ";
$sql .= "ON (POST_ATTACHMENT_FILES.HASH = USER_PREFS.AVATAR_AID) ";
$sql .= "SET USER_PREFS.AVATAR_AID = POST_ATTACHMENT_FILES.AID";

$db->query($sql);

$sql = "UPDATE USER_PREFS INNER JOIN POST_ATTACHMENT_FILES ";
$sql .= "ON (POST_ATTACHMENT_FILES.HASH = USER_PREFS.PIC_AID) ";
$sql .= "SET USER_PREFS.PIC_AID = POST_ATTACHMENT_FILES.AID";

$db->query($sql);

$sql = "ALTER TABLE USER_PREFS CHANGE PIC_AID PIC_AID MEDIUMINT(11) NULL";

$db->query($sql);

$sql = "ALTER TABLE USER_PREFS CHANGE AVATAR_AID AVATAR_AID MEDIUMINT(11) NULL";

$db->query($sql);

$sql = "UPDATE USER_PREFS SET AVATAR_AID = NULL WHERE AVATAR_AID = 0";

$db->query($sql);

$sql = "UPDATE USER_PREFS SET PIC_AID = NULL WHERE PIC_AID = 0";

$db->query($sql);

$sql = "UPDATE USER_PREFS SET POST_PAGE = 63";

$db->query($sql);

$sql = "ALTER TABLE FORUM_SETTINGS ";
$sql .= "CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
$sql .= "CHANGE SNAME SNAME VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER FID";

$db->query($sql);

$sql = "ALTER TABLE FORUMS ";
$sql .= "CHANGE WEBTAG WEBTAG VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER FID, ";
$sql .= "CHANGE DATABASE_NAME DATABASE_NAME VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER OWNER_UID, ";
$sql .= "CHANGE DEFAULT_FORUM DEFAULT_FORUM TINYINT(4) NOT NULL AFTER DATABASE_NAME, ";
$sql .= "CHANGE ACCESS_LEVEL ACCESS_LEVEL TINYINT(4) NOT NULL AFTER DEFAULT_FORUM, ";
$sql .= "CHANGE FORUM_PASSWD FORUM_PASSWD VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER ACCESS_LEVEL";

$db->query($sql);

$sql = "ALTER TABLE PM_CONTENT ";
$sql .= "CHANGE MID MID MEDIUMINT(8) UNSIGNED NOT NULL FIRST";

$db->query($sql);

$sql = "ALTER TABLE POST_ATTACHMENT_FILES ";
$sql .= "CHANGE DOWNLOADS DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL AFTER HASH";

$db->query($sql);

if (install_index_exists($config['db_database'], 'POST_ATTACHMENT_IDS', 'TID')) {

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS DROP KEY TID";
    $db->query($sql);
}

$sql = "ALTER TABLE SEARCH_ENGINE_BOTS ";
$sql .= "CHANGE NAME NAME VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER SID, ";
$sql .= "CHANGE URL URL VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER NAME, ";
$sql .= "CHANGE AGENT_MATCH AGENT_MATCH VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER URL";

$db->query($sql);

$sql = "ALTER TABLE SEARCH_RESULTS ";
$sql .= "CHANGE TID TID MEDIUMINT(8) UNSIGNED NOT NULL AFTER FORUM, ";
$sql .= "CHANGE PID PID MEDIUMINT(8) UNSIGNED NOT NULL AFTER TID, ";
$sql .= "CHANGE RELEVANCE RELEVANCE FLOAT UNSIGNED NOT NULL AFTER PID ";

$db->query($sql);

if (install_column_exists($config['db_database'], 'SEARCH_RESULTS', 'FID')) {

    $sql = "ALTER TABLE SEARCH_RESULTS DROP COLUMN FID";
    $db->query($sql);
}

$sql = "ALTER TABLE TIMEZONES ";
$sql .= "CHANGE TZID TZID INT(11) NOT NULL FIRST, ";
$sql .= "CHANGE DST_OFFSET DST_OFFSET DOUBLE NULL DEFAULT 0 AFTER GMT_OFFSET";

$db->query($sql);

$sql = "ALTER TABLE USER ";
$sql .= "CHANGE LOGON LOGON VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER UID, ";
$sql .= "CHANGE PASSWD PASSWD VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER LOGON, ";
$sql .= "CHANGE SALT SALT VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER PASSWD, ";
$sql .= "CHANGE EMAIL EMAIL VARCHAR(80) COLLATE UTF8_GENERAL_CI NOT NULL AFTER NICKNAME, ";
$sql .= "CHANGE REGISTERED REGISTERED DATETIME NOT NULL AFTER EMAIL, ";
$sql .= "CHANGE IPADDRESS IPADDRESS VARCHAR(255) COLLATE UTF8_GENERAL_CI NOT NULL AFTER REGISTERED";

$db->query($sql);

$sql = "ALTER TABLE USER_FORUM ";
$sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL FIRST, ";
$sql .= "CHANGE FID FID MEDIUMINT(8) UNSIGNED NOT NULL AFTER UID, ";
$sql .= "CHANGE INTEREST INTEREST TINYINT(4) NOT NULL DEFAULT 0 AFTER FID, ";
$sql .= "CHANGE ALLOWED ALLOWED TINYINT(4) NOT NULL DEFAULT 0 AFTER INTEREST";

$db->query($sql);

$sql = "ALTER TABLE USER_HISTORY ";
$sql .= "CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL AFTER HID, ";
$sql .= "CHANGE LOGON LOGON VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER UID, ";
$sql .= "CHANGE NICKNAME NICKNAME VARCHAR(32) COLLATE UTF8_GENERAL_CI NOT NULL AFTER LOGON, ";
$sql .= "CHANGE EMAIL EMAIL VARCHAR(80) COLLATE UTF8_GENERAL_CI NOT NULL AFTER NICKNAME, ";
$sql .= "CHANGE MODIFIED MODIFIED DATETIME NOT NULL AFTER EMAIL";

$db->query($sql);

$sql = "ALTER TABLE USER_PREFS ";
$sql .= "CHANGE START_PAGE START_PAGE CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL AFTER VIEW_SIGS, ";
$sql .= "CHANGE PM_EXPORT_TYPE PM_EXPORT_TYPE CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL AFTER PM_AUTO_PRUNE, ";
$sql .= "CHANGE PM_EXPORT_FILE PM_EXPORT_FILE CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL AFTER PM_EXPORT_TYPE, ";
$sql .= "CHANGE ANON_LOGON ANON_LOGON CHAR(1) COLLATE UTF8_GENERAL_CI NOT NULL AFTER DOB_DISPLAY";

$db->query($sql);

$sql = "ALTER TABLE VISITOR_LOG ";
$sql .= "CHANGE LAST_LOGON LAST_LOGON DATETIME NOT NULL AFTER FORUM ";

$db->query($sql);

if (!install_index_exists($config['db_database'], 'VISITOR_LOG', 'FORUM_LAST_LOGON')) {

    $sql = "ALTER TABLE `VISITOR_LOG` ADD KEY FORUM_LAST_LOGON(FORUM,LAST_LOGON)";
    $db->query($sql);
}

if (!install_index_exists($config['db_database'], 'VISITOR_LOG', 'IPADDRESS')) {

    $sql = "ALTER TABLE `VISITOR_LOG` ADD KEY IPADDRESS(IPADDRESS)";
    $db->query($sql);
}

$sql = "DELETE FROM POST_ATTACHMENT_IDS WHERE AID NOT IN (SELECT AID FROM POST_ATTACHMENT_FILES)";

$db->query($sql);

$sql = "DELETE FROM PM_ATTACHMENT_IDS WHERE AID NOT IN (SELECT AID FROM POST_ATTACHMENT_FILES)";

$db->query($sql);

if (isset($attachment_real_path)) {

    $attachments = glob(sprintf('%s/*', $attachment_real_path));

    $pattern_match = sprintf('/^%s\/([A-Fa-f0-9]{32})$/Du', preg_quote($attachment_real_path, '/'));

    foreach ($attachments as $attachment) {

        if (is_dir($attachment) || !preg_match($pattern_match, $attachment, $matches_array)) {
            continue;
        }

        $image_width = 'NULL';

        $image_height = 'NULL';

        $thumbnail = 'N';

        $hash = $db->escape($matches_array[1]);

        $file_size = $db->escape(filesize($attachment));

        if (($image_info = @getimagesize($attachment)) !== false) {

            $image_width = $db->escape($image_info[0]);

            $image_height = $db->escape($image_info[1]);

            $thumbnail = file_exists($attachment . '.thumb') ? 'Y' : 'N';
        }

        $sql = "UPDATE POST_ATTACHMENT_FILES SET FILESIZE = '$file_size', ";
        $sql .= "WIDTH = $image_width, HEIGHT = $image_height, ";
        $sql .= "THUMBNAIL = '$thumbnail' WHERE HASH = '$hash'";

        $db->query($sql);
    }
}