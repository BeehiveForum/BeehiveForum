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

/* $Id: install.inc.php,v 1.1 2004-05-08 17:56:44 decoyduck Exp $ */

//
// Table structure for table `ADMIN_LOG`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}ADMIN_LOG (";
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
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `BANNED_IP`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}BANNED_IP (";
$sql.= "  IP CHAR(15) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (IP)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `DEDUPE`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}DEDUPE (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  DDKEY CHAR(32) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `FILTER_LIST`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}FILTER_LIST (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `FOLDER`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}FOLDER (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  TITLE VARCHAR(32) DEFAULT NULL,";
$sql.= "  ACCESS_LEVEL TINYINT(4) DEFAULT '0',";
$sql.= "  DESCRIPTION VARCHAR(255) DEFAULT NULL,";
$sql.= "  ALLOWED_TYPES TINYINT(3) DEFAULT NULL,";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  PRIMARY KEY  (FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `FORUM_SETTINGS`
//

$sql = "CREATE TABLE {$db_prefix}FORUM_SETTINGS (";
$sql.= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  SNAME VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  SVALUE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  KEY SID (SID,FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `FORUMS`
//

$sql = "CREATE TABLE {$db_prefix}FORUMS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  WEBTAG VARCHAR(255) DEFAULT NULL,";
$sql.= "  FORUM TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  ACCESS_LEVEL TINYINT(4) DEFAULT '0',";
$sql.= "  PRIMARY KEY  (FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `links`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}LINKS (";
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
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `LINKS_COMMENT`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}LINKS_COMMENT (";
$sql.= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  COMMENT TEXT NOT NULL,";
$sql.= "  PRIMARY KEY  (CID),";
$sql.= "  KEY LID (LID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `LINKS_FOLDERS`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}LINKS_FOLDERS (";
$sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT '1',";
$sql.= "  NAME VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `LINKS_VOTE`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}LINKS_VOTE (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  PRIMARY KEY  (LID,UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `PM`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}PM (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '',";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  KEY TO_UID (TO_UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `PM_ATTACHMENT_IDS`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}PM_ATTACHMENT_IDS (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  KEY AID (AID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `PM_CONTENT`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}PM_CONTENT (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `POLL`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}POLL (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CLOSES DATETIME DEFAULT NULL,";
$sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',";
$sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',";
$sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',";
$sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (TID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `POLL_VOTES`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}POLL_VOTES (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  OPTION_NAME CHAR(255) NOT NULL DEFAULT '',";
$sql.= "  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (TID,OPTION_ID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `POST`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}POST (";
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
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `POST_ATTACHMENT_FILES`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}POST_ATTACHMENT_FILES (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID),";
$sql.= "  KEY AID (AID),";
$sql.= "  KEY HASH (HASH)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `POST_ATTACHMENT_IDS`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}POST_ATTACHMENT_IDS (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (TID,PID),";
$sql.= "  KEY AID (AID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `POST_CONTENT`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}POST_CONTENT (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  PRIMARY KEY  (TID,PID),";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `PROFILE_ITEM`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}PROFILE_ITEM (";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
$sql.= "  TYPE TINYINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  PRIMARY KEY  (PIID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `PROFILE_SECTION`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}PROFILE_SECTION (";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  NAME VARCHAR(64) DEFAULT NULL,";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',";
$sql.= "  PRIMARY KEY  (PSID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `SESSIONS`
//

$sql = "CREATE TABLE {$db_prefix}SESSIONS (";
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
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `STATS`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}STATS (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `THREAD`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}THREAD (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
$sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL,";
$sql.= "  MODIFIED DATETIME DEFAULT NULL,";
$sql.= "  CLOSED DATETIME DEFAULT NULL,";
$sql.= "  STICKY CHAR(1) DEFAULT NULL,";
$sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL,";
$sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (TID),";
$sql.= "  KEY IX_THREAD_FID (FID),";
$sql.= "  KEY BY_UID (BY_UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER`
//

$sql = "CREATE TABLE {$db_prefix}USER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  LOGON VARCHAR(32) DEFAULT NULL,";
$sql.= "  PASSWD VARCHAR(32) DEFAULT NULL,";
$sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  EMAIL VARCHAR(80) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_FOLDER`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_FOLDER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
$sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_FORUM`
//

$sql = "CREATE TABLE {$db_prefix}USER_FORUM (";
$sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
$sql.= "  FID mediumint(8) unsigned NOT NULL default '0',";
$sql.= "  INTEREST tinyint(4) default '0',";
$sql.= "  ALLOWED tinyint(4) default '0',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ") TYPE=MyISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_PEER`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_PEER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,PEER_UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_POLL_VOTES`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_POLL_VOTES (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PTUID VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  PRIMARY KEY  (ID,TID,PTUID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_PREFS`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_PREFS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FIRSTNAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  LASTNAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  DOB DATE DEFAULT '0000-00-00',";
$sql.= "  HOMEPAGE_URL VARCHAR(255) DEFAULT NULL,";
$sql.= "  PIC_URL VARCHAR(255) DEFAULT NULL,";
$sql.= "  EMAIL_NOTIFY CHAR(1) DEFAULT NULL,";
$sql.= "  TIMEZONE DECIMAL(2,1) DEFAULT NULL,";
$sql.= "  DL_SAVING CHAR(1) DEFAULT NULL,";
$sql.= "  MARK_AS_OF_INT CHAR(1) DEFAULT NULL,";
$sql.= "  POSTS_PER_PAGE TINYINT(3) UNSIGNED DEFAULT NULL,";
$sql.= "  FONT_SIZE TINYINT(3) UNSIGNED DEFAULT NULL,";
$sql.= "  STYLE VARCHAR(255) DEFAULT NULL,";
$sql.= "  EMOTICONS VARCHAR(255) DEFAULT NULL,";
$sql.= "  VIEW_SIGS CHAR(1) DEFAULT NULL,";
$sql.= "  START_PAGE TINYINT(3) UNSIGNED DEFAULT NULL,";
$sql.= "  LANGUAGE VARCHAR(32) DEFAULT NULL,";
$sql.= "  PM_NOTIFY CHAR(1) DEFAULT NULL,";
$sql.= "  PM_NOTIFY_EMAIL CHAR(1) DEFAULT NULL,";
$sql.= "  DOB_DISPLAY TINYINT(3) UNSIGNED DEFAULT NULL,";
$sql.= "  ANON_LOGON TINYINT(3) UNSIGNED DEFAULT NULL,";
$sql.= "  SHOW_STATS TINYINT(3) UNSIGNED DEFAULT NULL,";
$sql.= "  IMAGES_TO_LINKS CHAR(1) DEFAULT NULL,";
$sql.= "  USE_WORD_FILTER CHAR(1) DEFAULT NULL,";
$sql.= "  USE_ADMIN_FILTER CHAR(1) DEFAULT NULL,";
$sql.= "  ALLOW_EMAIL CHAR(1) DEFAULT NULL,";
$sql.= "  ALLOW_PM CHAR(1) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_PROFILE`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_PROFILE (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,PIID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_SIG`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_SIG (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  HTML CHAR(1) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_STATUS`
//

$sql = "CREATE TABLE {$db_prefix}USER_STATUS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  STATUS INT(16) NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `USER_THREAD`
//

$sql = "CREATE TABLE {$db_prefix}{$forum_webtag}USER_THREAD (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
$sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,TID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Table structure for table `VISITOR_LOG`
//

$sql = "CREATE TABLE {$db_prefix}VISITOR_LOG (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  LAST_LOGON DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  PRIMARY KEY  (UID,FID)";
$sql.= ") TYPE=MYISAM";

$result = mysql_query($sql, $db_install);

// --------------------------------------------------------

//
// Populate some of the tables
//

$sql = "INSERT INTO {$db_prefix}FORUMS (WEBTAG, DEFAULT_FORUM) VALUES ('$forum_webtag', 1)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}LINKS_FOLDERS (PARENT_FID, NAME, VISIBLE) VALUES (NULL, 'Top Level', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_name', 'A Beehive Forum')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_email', 'admin@abeehiveforum.net')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'style', 'default')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'emoticons', 'default')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'language', 'en')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_stats', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_links', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'auto_logon', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_pms', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'pm_allow_attachments', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'maximum_post_length', '6226')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_post_editing', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'post_edit_time', '0')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_polls', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'search_min_word_length', '3')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_enabled', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_dir', 'attachments')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_allow_embed', 'N')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_use_old_method', 'N')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'guest_account_active', 'Y')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'session_cutoff', '86400')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'active_session_cutoff', '900')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_SECTION (NAME, POSITION) VALUES ('Personal', 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Location', 0, 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Age', 0, 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Gender', 0, 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Quote', 0, 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Occupation', 0, 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Birthday (DD/MM)', 0, 0)";
$result = mysql_query($sql, $db_install);

$sql.= "INSERT INTO {$db_prefix}USER (LOGON, PASSWD, NICKNAME, EMAIL) VALUES ('$admin_username', md5('$admin_password'), 'Administrator', '$admin_email')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}USER_STATUS (UID, FID, STATUS) VALUES (1, 0, 56)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}USER_STATUS (UID, FID, STATUS) VALUES (1, 1, 56)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}FOLDER (TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES, POSITION) VALUES ('General', 0, NULL, NULL, 0)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}THREAD (FID, BY_UID, TITLE, LENGTH, POLL_FLAG, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) VALUES (1, 1, 'Welcome', 1, 'N', NOW(), NULL, 'N', NULL, NULL)";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}POST (TID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, EDITED, EDITED_BY, IPADDRESS) VALUES (1, 0, 1, 0, NULL, NOW(), 0, NULL, 0, '')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}POST_CONTENT (TID, PID, CONTENT) VALUES (1, 1, 'Welcome to your new Beehive Forum')";
$result = mysql_query($sql, $db_install);

$sql = "INSERT INTO {$db_prefix}{$forum_webtag}STATS (MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) VALUES (NOW(), 0, NOW(), 0)";
$result = mysql_query($sql, $db_install);

?>