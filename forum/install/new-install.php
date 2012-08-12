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

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'install.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

@set_time_limit(0);

if (!isset($forum_webtag) || strlen(trim($forum_webtag)) < 1) {

    $error_array[] = "<h2>You must specify a forum webtag for your choosen type of installation.</h2>\n";
    $valid = false;
    return;
}

$remove_conflicts = (isset($remove_conflicts) && $remove_conflicts === true);

if (($conflicting_tables = install_check_table_conflicts($db_database, $forum_webtag, true, true, $remove_conflicts))) {

    $error_str = "<h2>Selected database contains tables which conflict with Beehive Forum. ";
    $error_str.= "If this database contains an existing Beehive Forum installation please ";
    $error_str.= "check that you have selected the correct install / upgrade method.</h2>\n";

    $error_array[] = $error_str;

    $error_str = "<h2>If you continue to encounter errors you may want to consider enabling ";
    $error_str.= "the remove conflicts option at the bottom of the installer.</h2>\n";

    $error_array[] = $error_str;

    $error_str = "<h2>Conflicting tables</h2>\n";
    $error_str.= "<div id=\"conflicting_tables\" class=\"install_table_list\">\n";
    $error_str.= sprintf("<ul><li>%s</li></ul>\n", implode("</li><li>", $conflicting_tables));
    $error_str.= "</div>\n";

    $error_array[] = $error_str;

    $valid = false;
    return;
}

$sql = "CREATE TABLE DICTIONARY (";
$sql.= "  WORD VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SOUND VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (WORD, UID), ";
$sql.= "  KEY SOUND (SOUND)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE FORUMS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  WEBTAG VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  OWNER_UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql.= "  DATABASE_NAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  DEFAULT_FORUM TINYINT(4) NOT NULL DEFAULT '0', ";
$sql.= "  ACCESS_LEVEL TINYINT(4) NOT NULL DEFAULT '0', ";
$sql.= "  FORUM_PASSWD VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (FID), ";
$sql.= "  KEY WEBTAG (WEBTAG), ";
$sql.= "  KEY DEFAULT_FORUM (DEFAULT_FORUM)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE FORUM_SETTINGS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SNAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  SVALUE TEXT NOT NULL, ";
$sql.= "  PRIMARY KEY (FID, SNAME) ";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUPS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (GID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_PERMS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,FORUM,FID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_USERS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,UID),";
$sql.= "  KEY UID (UID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  RECIPIENTS VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SMID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (MID), ";
$sql.= "  KEY TYPE (TYPE), ";
$sql.= "  KEY FROM_UID (FROM_UID), ";
$sql.= "  KEY SMID (SMID), ";
$sql.= "  KEY TO_UID (TO_UID), ";
$sql.= "  FULLTEXT KEY SUBJECT (SUBJECT)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_ATTACHMENT_IDS (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (MID), ";
$sql.= "  KEY AID (AID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_CONTENT (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CONTENT TEXT, ";
$sql.= "  PRIMARY KEY (MID), ";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_FOLDERS (";
$sql.= "  UID MEDIUMINT(8) NOT NULL,";
$sql.= "  FID MEDIUMINT(8) NOT NULL,";
$sql.= "  TITLE VARCHAR(32) NOT NULL,";
$sql.= "  PRIMARY KEY (UID, FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_SEARCH_RESULTS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  RECIPIENTS VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (UID, MID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_FILES (";
$sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (AID, ID), ";
$sql.= "  KEY UID (UID), ";
$sql.= "  KEY HASH (HASH)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (FID, TID, PID), ";
$sql.= "  KEY AID (AID), ";
$sql.= "  KEY TID (TID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_ENGINE_BOTS (";
$sql.= "  SID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql.= "  NAME VARCHAR(32) DEFAULT NULL, ";
$sql.= "  URL VARCHAR(255) DEFAULT NULL, ";
$sql.= "  AGENT_MATCH VARCHAR(32) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (SID), ";
$sql.= "  KEY NAME (NAME), ";
$sql.= "  KEY AGENT_MATCH (AGENT_MATCH)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_RESULTS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  BY_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  LENGTH MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  RELEVANCE FLOAT UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (UID, FORUM, TID, PID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SESSIONS (";
$sql.= "  ID VARCHAR(32) NOT NULL,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  DATA LONGBLOB NOT NULL,";
$sql.= "  TIME DATETIME NOT NULL,";
$sql.= "  IPADDRESS VARCHAR(255) DEFAULT NULL,";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql.= "  USER_AGENT VARCHAR(255) DEFAULT NULL,";
$sql.= "  SID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  PRIMARY KEY (ID),";
$sql.= "  KEY REFERER (REFERER),";
$sql.= "  KEY TIME (TIME,FID),";
$sql.= "  KEY UID (UID,SID,TIME,FID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SFS_CACHE (";
$sql.= "  REQUEST_MD5 varchar(32) NOT NULL, ";
$sql.= "  RESPONSE longblob NOT NULL, ";
$sql.= "  CREATED datetime NOT NULL, ";
$sql.= "  EXPIRES datetime NOT NULL, ";
$sql.= "  PRIMARY KEY (REQUEST_MD5), ";
$sql.= "  KEY EXPIRES (EXPIRES) ";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE TIMEZONES (";
$sql.= "  TZID INT(11) NOT NULL DEFAULT '0', ";
$sql.= "  GMT_OFFSET DOUBLE DEFAULT '0', ";
$sql.= "  DST_OFFSET DOUBLE DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (TZID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  LOGON VARCHAR(32) DEFAULT NULL, ";
$sql.= "  PASSWD VARCHAR(255) DEFAULT NULL, ";
$sql.= "  SALT VARCHAR(255) DEFAULT NULL, ";
$sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL, ";
$sql.= "  EMAIL VARCHAR(80) DEFAULT NULL, ";
$sql.= "  REGISTERED DATETIME DEFAULT NULL, ";
$sql.= "  IPADDRESS VARCHAR(255) DEFAULT NULL, ";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL, ";
$sql.= "  APPROVED DATETIME DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID), ";
$sql.= "  KEY LOGON (LOGON), ";
$sql.= "  KEY NICKNAME (NICKNAME)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_TOKEN (";
$sql.= "  UID mediumint(8) unsigned NOT NULL,";
$sql.= "  TOKEN varchar(255) NOT NULL,";
$sql.= "  EXPIRES datetime NOT NULL,";
$sql.= "  PRIMARY KEY (UID, TOKEN)";
$sql.= ") ENGINE=MyISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_FORUM (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  INTEREST TINYINT(4) DEFAULT '0', ";
$sql.= "  ALLOWED TINYINT(4) DEFAULT '0', ";
$sql.= "  LAST_VISIT DATETIME DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID, FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_HISTORY (";
$sql.= "  HID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  LOGON VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  NICKNAME VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  EMAIL VARCHAR(80) NOT NULL DEFAULT '', ";
$sql.= "  MODIFIED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (HID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_PREFS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  FIRSTNAME VARCHAR(32) NOT NULL,";
$sql.= "  LASTNAME VARCHAR(32) NOT NULL,";
$sql.= "  DOB DATE NOT NULL,";
$sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL,";
$sql.= "  PIC_URL VARCHAR(255) NOT NULL,";
$sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  TIMEZONE INT(11) NOT NULL DEFAULT '27',";
$sql.= "  DL_SAVING CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  POSTS_PER_PAGE VARCHAR(3) NOT NULL DEFAULT '20',";
$sql.= "  FONT_SIZE VARCHAR(2) NOT NULL DEFAULT '10',";
$sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT 'default',";
$sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT 'default',";
$sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  START_PAGE CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT 'en_GB',";
$sql.= "  PM_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PM_NOTIFY_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PM_SAVE_SENT_ITEM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PM_INCLUDE_REPLY CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  PM_AUTO_PRUNE VARCHAR(3) NOT NULL DEFAULT '-60',";
$sql.= "  PM_EXPORT_TYPE CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  PM_EXPORT_FILE CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  PM_EXPORT_ATTACHMENTS CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  PM_EXPORT_STYLE CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  PM_EXPORT_WORDFILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
$sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  USE_EMAIL_ADDR CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  POST_PAGE SMALLINT(4) NOT NULL DEFAULT '3271',";
$sql.= "  SHOW_THUMBS VARCHAR(2) NOT NULL DEFAULT '2',";
$sql.= "  ENABLE_WIKI_WORDS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  USE_MOVER_SPOILER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_LIGHT_MODE_SPOILER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_OVERFLOW_RESIZE CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PIC_AID VARCHAR(32) NOT NULL,";
$sql.= "  AVATAR_URL VARCHAR(255) NOT NULL,";
$sql.= "  AVATAR_AID VARCHAR(32) NOT NULL,";
$sql.= "  REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  THREADS_BY_FOLDER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  THREAD_LAST_PAGE CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  LEFT_FRAME_WIDTH SMALLINT(4) NOT NULL DEFAULT '280',";
$sql.= "  SHOW_AVATARS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  SHOW_SHARE_LINKS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PRIMARY KEY (UID),";
$sql.= "  KEY DOB (DOB),";
$sql.= "  KEY DOB_DISPLAY (DOB_DISPLAY)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=utf8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE VISITOR_LOG (";
$sql.= "  VID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  SID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  LAST_LOGON DATETIME DEFAULT NULL,";
$sql.= "  IPADDRESS VARCHAR(255) NOT NULL,";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql.= "  USER_AGENT VARCHAR(255) DEFAULT NULL,";
$sql.= "  PRIMARY KEY (VID),";
$sql.= "  UNIQUE KEY UID (UID),";
$sql.= "  UNIQUE KEY SID (SID),";
$sql.= "  KEY FORUM (FORUM),";
$sql.= "  KEY LAST_LOGON (LAST_LOGON)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (!install_set_default_forum_settings()) {

    $valid = false;
    return;
}

if (!install_set_search_bots()) {

    $valid = false;
    return;
}

if (!install_set_timezones()) {

    $valid = false;
    return;
}

if (!($admin_uid = user_create($admin_username, $admin_password, $admin_username, $admin_email))) {

    $valid = false;
    return;
}

if (!perm_update_global_perms($admin_uid, USER_PERM_ADMIN_TOOLS | USER_PERM_FORUM_TOOLS)) {

    $valid = false;
    return;
}

if (!($forum_fid = forum_create($forum_webtag, 'A Beehive Forum', $admin_uid, $db_database, FORUM_UNRESTRICTED))) {

    $valid = false;
    return;
}

if (!forum_update_default($forum_fid)) {

    $valid = false;
    return;
}

if (!perm_update_user_forum_permissions($forum_fid, $admin_uid, USER_PERM_ADMIN_TOOLS)) {

    $valid = false;
    return;
}

if (!isset($skip_dictionary) || $skip_dictionary === false) {

    $dictionary_path = str_replace('\\', '/', rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR));

    if (!install_import_dictionary($dictionary_path)) {

        $valid = false;
        return;
    }
}

?>