<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: install_script.php,v 1.19 2004-08-17 21:08:09 tribalonline Exp $ */

if (basename($_SERVER['PHP_SELF']) == "install_script.php") {

    header("Request-URI: ./install.php");
    header("Content-Location: ./install.php");
    header("Location: ./install.php");
    exit;
}

$sql = "CREATE TABLE {$forum_webtag}_ADMIN_LOG (";
$sql.= "  LOG_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  LOG_TIME DATETIME DEFAULT NULL,";
$sql.= "  ADMIN_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  ACTION MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (LOG_ID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_BANNED_IP (";
$sql.= "  IP CHAR(15) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (IP)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_DEDUPE (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  DDKEY CHAR(32) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_FILTER_LIST (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID,UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_FOLDER (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  TITLE VARCHAR(32) DEFAULT NULL,";
$sql.= "  DESCRIPTION VARCHAR(255) DEFAULT NULL,";
$sql.= "  ALLOWED_TYPES TINYINT(3) DEFAULT NULL,";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  PRIMARY KEY  (FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_FOLDER (TITLE, DESCRIPTION, ALLOWED_TYPES, POSITION) ";
$sql.= "VALUES ('General', NULL, NULL, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_FORUM_LINKS (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  POS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  URI VARCHAR(255) DEFAULT NULL,";
$sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (LID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_FORUM_LINKS (POS, TITLE, URI) ";
$sql.= "VALUES (1, 'Forum Links:', NULL)";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_FORUM_LINKS (POS, TITLE, URI) ";
$sql.= "VALUES (2, 'Project Beehive Home', 'http://www.beehiveforum.net/')";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_FORUM_LINKS (POS, TITLE, URI) ";
$sql.= "VALUES (2, 'Teh Forum', 'http://www.tehforum.net/forum/')";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_GROUP_PERMS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS VALUES (1, 0, 1792);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS VALUES (1, 1, 6652);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS VALUES (0, 1, 6396);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_GROUP_USERS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_GROUP_USERS VALUES (1, 1);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_GROUPS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
$sql.= "  AUTO_GROUP TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_GROUPS (GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
$sql.= "VALUES ('Queen', NULL, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_LINKS (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  URI VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  TITLE VARCHAR(64) NOT NULL DEFAULT '',";
$sql.= "  DESCRIPTION TEXT NOT NULL,";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  CLICKS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (LID),";
$sql.= "  KEY FID (FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_LINKS_COMMENT (";
$sql.= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  COMMENT TEXT NOT NULL,";
$sql.= "  PRIMARY KEY  (CID),";
$sql.= "  KEY LID (LID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_LINKS_FOLDERS (";
$sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT '1',";
$sql.= "  NAME VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_LINKS_FOLDERS (PARENT_FID, NAME, VISIBLE) ";
$sql.= "VALUES (NULL, 'Top Level', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_LINKS_VOTE (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  PRIMARY KEY  (LID,UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_PM (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  REPLY_TO_MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '',";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY (MID),";
$sql.= "  KEY TO_UID (TO_UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_PM_ATTACHMENT_IDS (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  KEY AID (AID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_PM_CONTENT (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_POLL (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CLOSES DATETIME DEFAULT NULL,";
$sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',";
$sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',";
$sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',";
$sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (TID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_POLL_VOTES (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  OPTION_NAME CHAR(255) NOT NULL DEFAULT '',";
$sql.= "  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (TID,OPTION_ID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_POST (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  VIEWED DATETIME DEFAULT NULL,";
$sql.= "  CREATED DATETIME DEFAULT NULL,";
$sql.= "  STATUS TINYINT(4) DEFAULT '0',";
$sql.= "  EDITED DATETIME DEFAULT NULL,";
$sql.= "  EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (TID,PID),";
$sql.= "  KEY TO_UID (TO_UID),";
$sql.= "  KEY IPADDRESS (IPADDRESS)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_POST ";
$sql.= "(TID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, EDITED, EDITED_BY, IPADDRESS) ";
$sql.= "VALUES (1, 0, 1, 0, NULL, NOW(), 0, NULL, 0, '');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_POST_ATTACHMENT_FILES (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  DELETED TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID),";
$sql.= "  KEY AID (AID),";
$sql.= "  KEY HASH (HASH)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_POST_ATTACHMENT_IDS (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (TID,PID),";
$sql.= "  KEY AID (AID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_POST_CONTENT (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  PRIMARY KEY  (TID,PID),";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_POST_CONTENT VALUES (1, 1, 'Welcome to your new Beehive Forum');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_PROFILE_ITEM (";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
$sql.= "  TYPE TINYINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  PRIMARY KEY  (PIID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) ";
$sql.= "VALUES (1, 'Location', 0, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_PROFILE_ITEM VALUES (2, 1, 'Age', 0, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_PROFILE_ITEM VALUES (3, 1, 'Gender', 0, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_PROFILE_ITEM VALUES (4, 1, 'Quote', 0, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_PROFILE_ITEM VALUES (5, 1, 'Occupation', 0, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_PROFILE_SECTION (";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  PRIMARY KEY  (PSID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_PROFILE_SECTION (NAME, POSITION) ";
$sql.= "VALUES ('Personal', 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_STATS (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_THREAD (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
$sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL,";
$sql.= "  MODIFIED DATETIME DEFAULT NULL,";
$sql.= "  CLOSED DATETIME DEFAULT NULL,";
$sql.= "  STICKY CHAR(1) DEFAULT NULL,";
$sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL,";
$sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (TID),";
$sql.= "  KEY FID (FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO {$forum_webtag}_THREAD ";
$sql.= "(FID, TITLE, LENGTH, POLL_FLAG, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
$sql.= "VALUES (1, 'Welcome', 1, 'N', NOW(), NULL, 'N', NULL, NULL);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_FOLDER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_PEER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,PEER_UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_POLL_VOTES (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PTUID VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  PRIMARY KEY  (ID,TID,PTUID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_PREFS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  PIC_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  POSTS_PER_PAGE CHAR(3) NOT NULL DEFAULT '20',";
$sql.= "  FONT_SIZE CHAR(2) NOT NULL DEFAULT '10',";
$sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  START_PAGE CHAR(3) NOT NULL DEFAULT '0',";
$sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PM_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PM_NOTIFY_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
$sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT '1',";
$sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_PROFILE (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,PIID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_SIG (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  HTML CHAR(1) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE {$forum_webtag}_USER_THREAD (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
$sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,TID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE FORUM_SETTINGS (";
$sql.= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  SNAME VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  SVALUE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  KEY SID (SID,FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'forum_name', 'A Beehive Forum');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'forum_email', 'admin@abeehiveforum.net');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, '{$forum_webtag}_style', 'default');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, '{$forum_webtag}_emoticon', 'default');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, '{$forum_webtag}_language', 'en');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'show_stats', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'show_links', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'auto_logon', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'show_pms', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'pm_max_user_messages', '100');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'pm_allow_attachments', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'maximum_post_length', '6226');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'allow_post_editing', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'post_edit_time', '0');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'allow_polls', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'search_min_word_length', '3');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'attachments_enabled', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'attachments_dir', 'attachments');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'attachments_allow_embed', 'N');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'attachments_use_old_method', 'N');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'guest_account_active', 'Y');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'session_cutoff', '86400');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
$sql.= "VALUES (1, 'active_session_cutoff', '900');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE FORUMS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  WEBTAG VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  DEFAULT_FORUM TINYINT(4) NOT NULL DEFAULT '0',";
$sql.= "  ACCESS_LEVEL TINYINT(4) NOT NULL DEFAULT '0',";
$sql.= "  FORUM_PASSWD VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO FORUMS (WEBTAG, DEFAULT_FORUM, ACCESS_LEVEL) ";
$sql.= "VALUES ('{$forum_webtag}', 1, 0);";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE SESSIONS (";
$sql.= "  SESSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
$sql.= "  TIME DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (SESSID),";
$sql.= "  KEY HASH (HASH),";
$sql.= "  KEY FID (FID),";
$sql.= "  KEY UID (UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE USER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  LOGON VARCHAR(32) DEFAULT NULL,";
$sql.= "  PASSWD VARCHAR(32) DEFAULT NULL,";
$sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  EMAIL VARCHAR(80) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "INSERT INTO USER (LOGON, PASSWD, NICKNAME, EMAIL) ";
$sql.= "VALUES ('$admin_username', MD5('$admin_password'), '$admin_username', '$admin_email');";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE USER_FORUM (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
$sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

$sql = "CREATE TABLE USER_PREFS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FIRSTNAME VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  LASTNAME VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  DOB DATE NOT NULL DEFAULT '0000-00-00',";
$sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  PIC_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  TIMEZONE DECIMAL(2,1) NOT NULL DEFAULT 0,";
$sql.= "  DL_SAVING CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  POSTS_PER_PAGE CHAR(3) NOT NULL DEFAULT '20',";
$sql.= "  FONT_SIZE CHAR(2) NOT NULL DEFAULT '10',";
$sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  START_PAGE CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PM_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PM_NOTIFY_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
$sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT '1',";
$sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  POST_PAGE CHAR(3) DEFAULT '0',";
$sql.= "  PRIMARY KEY (UID)";
$sql.= "  ) TYPE=MYISAM;";

if(!$result = mysql_query($sql, $db_install)) {
    die($sql. "<br />\n". mysql_error());
}

$sql = "CREATE TABLE VISITOR_LOG (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  LAST_LOGON DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ")";

if(!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

?>
