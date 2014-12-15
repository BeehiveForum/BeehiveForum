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

if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) == 'new-install.php') {

    header("Request-URI: index.php");
    header("Content-Location: index.php");
    header("Location: index.php");
    exit;
}

require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'install.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';

$error_str = null;

@set_time_limit(0);

if (!isset($forum_webtag) || strlen(trim($forum_webtag)) < 1) {
    throw new Exception("You must specify a forum webtag for your choosen type of installation.");
}

$remove_conflicts = (isset($remove_conflicts) && $remove_conflicts === true);

/** @noinspection PhpUndefinedVariableInspection */
if (($conflicting_tables = install_check_table_conflicts($config['db_database'], $forum_webtag, true, true, $remove_conflicts))) {

    $error_str = "Selected database contains tables which conflict with Beehive Forum. ";
    $error_str .= "If this database contains an existing Beehive Forum, please check that ";
    $error_str .= "you have selected the correct install / upgrade method.\n\n";

    $error_str .= "If you continue to encounter errors you may want to consider enabling ";
    $error_str .= "the remove conflicts option at the bottom of the installer.\n\n";

    $error_str .= "Conflicting tables:\n\n";
    $error_str .= implode(",\n", $conflicting_tables);

    throw new Exception($error_str);
}

$sql = "CREATE TABLE FORUMS (";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql .= "  WEBTAG VARCHAR(255) NOT NULL, ";
$sql .= "  OWNER_UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  DATABASE_NAME VARCHAR(255) NOT NULL, ";
$sql .= "  DEFAULT_FORUM TINYINT(4) NOT NULL, ";
$sql .= "  ACCESS_LEVEL TINYINT(4) NOT NULL, ";
$sql .= "  FORUM_PASSWD VARCHAR(32) NOT NULL, ";
$sql .= "  PRIMARY KEY (FID), ";
$sql .= "  KEY WEBTAG (WEBTAG), ";
$sql .= "  KEY DEFAULT_FORUM (DEFAULT_FORUM)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE FORUM_SETTINGS (";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  SNAME VARCHAR(255) NOT NULL, ";
$sql .= "  SVALUE TEXT NOT NULL, ";
$sql .= "  PRIMARY KEY (FID, SNAME) ";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE GROUPS (";
$sql .= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql .= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  GROUP_NAME VARCHAR(32) NOT NULL,";
$sql .= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
$sql .= "  PRIMARY KEY (GID),";
$sql .= "  KEY FORUM (FORUM)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE GROUP_PERMS (";
$sql .= "  GID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PERM INT(32) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (GID,FID)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE GROUP_USERS (";
$sql .= "  GID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (GID,UID)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM (";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql .= "  REPLY_TO_MID MEDIUMINT(8) UNSIGNED NULL, ";
$sql .= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  SUBJECT VARCHAR(64) NOT NULL, ";
$sql .= "  CREATED DATETIME NOT NULL, ";
$sql .= "  PRIMARY KEY (MID), ";
$sql .= "  KEY FROM_UID (FROM_UID), ";
$sql .= "  FULLTEXT KEY SUBJECT (SUBJECT)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM_ATTACHMENT_IDS (";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  AID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (MID,AID)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM_CONTENT (";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  CONTENT TEXT, ";
$sql .= "  PRIMARY KEY (MID), ";
$sql .= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM_FOLDERS (";
$sql .= "  UID MEDIUMINT(8) NOT NULL,";
$sql .= "  FID MEDIUMINT(8) NOT NULL,";
$sql .= "  TITLE VARCHAR(32) NOT NULL,";
$sql .= "  PRIMARY KEY (UID, FID)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM_RECIPIENT ( ";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  NOTIFIED CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  PRIMARY KEY (MID,TO_UID)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM_SEARCH_RESULTS (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  RELEVANCE FLOAT UNSIGNED NOT NULL, ";
$sql .= "  PRIMARY KEY (UID, MID)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE PM_TYPE (";
$sql .= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  TYPE TINYINT(3) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (MID,UID,TYPE)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE POST_ATTACHMENT_FILES (";
$sql .= "  AID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  FILENAME VARCHAR(255) NOT NULL,";
$sql .= "  MIMETYPE VARCHAR(255) NOT NULL,";
$sql .= "  FILESIZE BIGINT(8) UNSIGNED NOT NULL,";
$sql .= "  WIDTH SMALLINT(5) UNSIGNED DEFAULT NULL,";
$sql .= "  HEIGHT SMALLINT(5) UNSIGNED DEFAULT NULL,";
$sql .= "  THUMBNAIL CHAR(1) NOT NULL,";
$sql .= "  HASH VARCHAR(32) NOT NULL,";
$sql .= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (AID),";
$sql .= "  KEY UID (UID),";
$sql .= "  KEY HASH (HASH)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  AID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (FID,TID,PID,AID)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE SEARCH_ENGINE_BOTS (";
$sql .= "  SID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql .= "  NAME VARCHAR(32) NOT NULL, ";
$sql .= "  URL VARCHAR(255) NOT NULL, ";
$sql .= "  AGENT_MATCH VARCHAR(32) NOT NULL, ";
$sql .= "  PRIMARY KEY (SID), ";
$sql .= "  KEY NAME (NAME), ";
$sql .= "  KEY AGENT_MATCH (AGENT_MATCH)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

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

$sql = "CREATE TABLE SFS_CACHE (";
$sql .= "  REQUEST_MD5 varchar(32) NOT NULL, ";
$sql .= "  RESPONSE longblob NOT NULL, ";
$sql .= "  CREATED datetime NOT NULL, ";
$sql .= "  EXPIRES datetime NOT NULL, ";
$sql .= "  PRIMARY KEY (REQUEST_MD5), ";
$sql .= "  KEY EXPIRES (EXPIRES) ";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE TIMEZONES (";
$sql .= "  TZID INT(11) NOT NULL, ";
$sql .= "  GMT_OFFSET DOUBLE DEFAULT '0', ";
$sql .= "  DST_OFFSET DOUBLE DEFAULT '0', ";
$sql .= "  PRIMARY KEY (TZID)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE USER (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql .= "  LOGON VARCHAR(32) NOT NULL, ";
$sql .= "  PASSWD VARCHAR(255) NOT NULL, ";
$sql .= "  SALT VARCHAR(255) NOT NULL, ";
$sql .= "  NICKNAME VARCHAR(32) DEFAULT NULL, ";
$sql .= "  EMAIL VARCHAR(80) NOT NULL, ";
$sql .= "  REGISTERED DATETIME NOT NULL, ";
$sql .= "  IPADDRESS VARCHAR(255) NOT NULL, ";
$sql .= "  REFERER VARCHAR(255) DEFAULT NULL, ";
$sql .= "  APPROVED DATETIME DEFAULT NULL, ";
$sql .= "  PRIMARY KEY (UID), ";
$sql .= "  KEY LOGON (LOGON), ";
$sql .= "  KEY NICKNAME (NICKNAME)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE USER_TOKEN (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  TOKEN varchar(255) NOT NULL,";
$sql .= "  EXPIRES datetime NOT NULL,";
$sql .= "  PRIMARY KEY (UID, TOKEN)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE USER_FORUM (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  INTEREST TINYINT(4) NOT NULL DEFAULT '0', ";
$sql .= "  ALLOWED TINYINT(4) NOT NULL DEFAULT '0', ";
$sql .= "  LAST_VISIT DATETIME DEFAULT NULL, ";
$sql .= "  PRIMARY KEY (UID, FID)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE USER_HISTORY (";
$sql .= "  HID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql .= "  LOGON VARCHAR(32) NOT NULL, ";
$sql .= "  NICKNAME VARCHAR(32) NOT NULL, ";
$sql .= "  EMAIL VARCHAR(80) NOT NULL, ";
$sql .= "  MODIFIED DATETIME NOT NULL, ";
$sql .= "  PRIMARY KEY (HID)";
$sql .= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE USER_PERM (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  PERM INT(32) UNSIGNED NOT NULL,";
$sql .= "  PRIMARY KEY (UID,FORUM,FID)";
$sql .= ") ENGINE=MYISAM CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE USER_PREFS (";
$sql .= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  FIRSTNAME VARCHAR(32) NOT NULL,";
$sql .= "  LASTNAME VARCHAR(32) NOT NULL,";
$sql .= "  DOB DATE NOT NULL,";
$sql .= "  HOMEPAGE_URL VARCHAR(255) NOT NULL,";
$sql .= "  PIC_URL VARCHAR(255) NOT NULL,";
$sql .= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  TIMEZONE INT(11) NOT NULL DEFAULT '27',";
$sql .= "  DL_SAVING CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  POSTS_PER_PAGE VARCHAR(3) NOT NULL DEFAULT '20',";
$sql .= "  FONT_SIZE VARCHAR(2) NOT NULL DEFAULT '10',";
$sql .= "  STYLE VARCHAR(255) NOT NULL DEFAULT 'default',";
$sql .= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT 'default',";
$sql .= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  START_PAGE CHAR(1) NOT NULL,";
$sql .= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT 'en_GB',";
$sql .= "  PM_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  PM_NOTIFY_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  PM_SAVE_SENT_ITEM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  PM_INCLUDE_REPLY CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  PM_AUTO_PRUNE VARCHAR(3) NOT NULL DEFAULT '-60',";
$sql .= "  PM_EXPORT_TYPE CHAR(1) NOT NULL,";
$sql .= "  PM_EXPORT_FILE CHAR(1) NOT NULL,";
$sql .= "  PM_EXPORT_ATTACHMENTS CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  PM_EXPORT_STYLE CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  PM_EXPORT_WORDFILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
$sql .= "  ANON_LOGON CHAR(1) NOT NULL,";
$sql .= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  USE_EMAIL_ADDR CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  POST_PAGE SMALLINT(4) NOT NULL DEFAULT '3271',";
$sql .= "  SHOW_THUMBS VARCHAR(2) NOT NULL DEFAULT '2',";
$sql .= "  ENABLE_WIKI_WORDS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  ENABLE_WIKI_QUICK_LINKS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  USE_MOVER_SPOILER CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  USE_LIGHT_MODE_SPOILER CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  USE_OVERFLOW_RESIZE CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  PIC_AID MEDIUMINT(11) DEFAULT NULL,";
$sql .= "  AVATAR_URL VARCHAR(255) NOT NULL,";
$sql .= "  AVATAR_AID MEDIUMINT(11) DEFAULT NULL,";
$sql .= "  REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  THREADS_BY_FOLDER CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  THREAD_LAST_PAGE CHAR(1) NOT NULL DEFAULT 'N',";
$sql .= "  LEFT_FRAME_WIDTH SMALLINT(4) NOT NULL DEFAULT '280',";
$sql .= "  SHOW_AVATARS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  SHOW_SHARE_LINKS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  ENABLE_TAGS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  AUTO_SCROLL_MESSAGES CHAR(1) NOT NULL DEFAULT 'Y',";
$sql .= "  PRIMARY KEY (UID),";
$sql .= "  KEY DOB (DOB),";
$sql .= "  KEY DOB_DISPLAY (DOB_DISPLAY)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

$sql = "CREATE TABLE VISITOR_LOG (";
$sql .= "  VID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql .= "  UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql .= "  SID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql .= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql .= "  LAST_LOGON DATETIME NOT NULL,";
$sql .= "  IPADDRESS VARCHAR(255) NOT NULL,";
$sql .= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql .= "  USER_AGENT VARCHAR(255) DEFAULT NULL,";
$sql .= "  PRIMARY KEY (VID),";
$sql .= "  UNIQUE KEY UID (UID),";
$sql .= "  UNIQUE KEY SID (SID),";
$sql .= "  KEY FORUM (FORUM),";
$sql .= "  KEY LAST_LOGON (LAST_LOGON),";
$sql .= "  KEY FORUM_LAST_LOGON (FORUM, LAST_LOGON), ";
$sql .= "  KEY IPADDRESS (IPADDRESS)";
$sql .= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

$db->query($sql);

if (!install_set_default_forum_settings()) {
    throw new Exception('Failed to save forum settings');
}

if (!install_set_search_bots()) {
    throw new Exception('Failed to create search bot entries');
}

if (!install_set_timezones()) {
    throw new Exception('Failed to create timezone entries');
}

if (!($admin_uid = user_create($admin_username, $admin_password, $admin_username, $admin_email))) {
    throw new Exception('Failed to create admin user');
}

if (!perm_update_user_global_perms($admin_uid, USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS)) {
    throw new Exception('Failed to set admin global permissions');
}

if (!($forum_fid = forum_create($forum_webtag, 'A Beehive Forum', $admin_uid, $config['db_database'], FORUM_UNRESTRICTED, false, $error_str))) {
    throw new Exception($error_str);
}

if (!forum_update_default($forum_fid)) {
    throw new Exception('Failed to set default forum');
}

if (!perm_update_user_forum_permissions($admin_uid, $forum_fid, USER_PERM_ADMIN_TOOLS)) {
    throw new Exception('Failed to set admin forum permissions');
}