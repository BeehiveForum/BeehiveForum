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

/* $Id: upgrade_script.php,v 1.15 2004-08-08 21:56:45 tribalonline Exp $ */

if (basename($_SERVER['PHP_SELF']) == "upgrade_script.php") {

    header("Request-URI: ./install.php");
    header("Content-Location: ./install.php");
    header("Location: ./install.php");
    exit;
}

$sql = "SHOW TABLES LIKE 'FORUMS' ";

if (!$result = mysql_query($sql, $db_install)) {
    $valid = false;
}

if (mysql_num_rows($result) > 0) {

    $sql = "SELECT WEBTAG FROM FORUMS ";
    $result = mysql_query($sql, $db_install);

    while ($row = mysql_fetch_array($result)) {
        $forum_webtag_array[] = $row['WEBTAG'];
    }

}else {

    $forum_webtag_array[] = "DEFAULT";
}

foreach($forum_webtag_array as $forum_webtag) {

    $sql = "ALTER TABLE ADMIN_LOG RENAME {$forum_webtag}_ADMIN_LOG";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE BANNED_IP RENAME {$forum_webtag}_BANNED_IP";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE DEDUPE RENAME {$forum_webtag}_DEDUPE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE FILTER_LIST RENAME {$forum_webtag}_FILTER_LIST";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE FOLDER RENAME {$forum_webtag}_FOLDER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE LINKS RENAME {$forum_webtag}_LINKS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE LINKS_COMMENT RENAME {$forum_webtag}_LINKS_COMMENT";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE LINKS_FOLDERS RENAME {$forum_webtag}_LINKS_FOLDERS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE LINKS_VOTE RENAME {$forum_webtag}_LINKS_VOTE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE PM RENAME {$forum_webtag}_PM";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE PM_ATTACHMENT_IDS RENAME {$forum_webtag}_PM_ATTACHMENT_IDS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE PM_CONTENT RENAME {$forum_webtag}_PM_CONTENT";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE POLL RENAME {$forum_webtag}_POLL";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE POLL_VOTES RENAME {$forum_webtag}_POLL_VOTES";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE POST RENAME {$forum_webtag}_POST";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE POST_ATTACHMENT_FILES RENAME {$forum_webtag}_POST_ATTACHMENT_FILES";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE POST_ATTACHMENT_IDS RENAME {$forum_webtag}_POST_ATTACHMENT_IDS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE POST_CONTENT RENAME {$forum_webtag}_POST_CONTENT";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE PROFILE_ITEM RENAME {$forum_webtag}_PROFILE_ITEM";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE PROFILE_SECTION RENAME {$forum_webtag}_PROFILE_SECTION";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE STATS RENAME {$forum_webtag}_STATS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE THREAD RENAME {$forum_webtag}_THREAD";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_FOLDER RENAME {$forum_webtag}_USER_FOLDER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_PEER RENAME {$forum_webtag}_USER_PEER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_POLL_VOTES RENAME {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_PROFILE RENAME {$forum_webtag}_USER_PROFILE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_PREFS RENAME {$forum_webtag}_USER_PREFS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_SIG RENAME {$forum_webtag}_USER_SIG";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER_THREAD RENAME {$forum_webtag}_USER_THREAD";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_BANNED_IP_NEW (";
    $sql.= "  IP CHAR(15) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (IP)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_BANNED_IP_NEW (IP) ";
    $sql.= "SELECT DISTINCT IP FROM {$forum_webtag}_BANNED_IP";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_BANNED_IP";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_BANNED_IP_NEW RENAME {$forum_webtag}_BANNED_IP";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD FULLTEXT (TITLE)";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "REPAIR TABLE {$forum_webtag}_THREAD";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_LINKS_VOTE_NEW (";
    $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  PRIMARY KEY (LID, UID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_LINKS_VOTE_NEW (LID, UID, RATING, TSTAMP) ";
    $sql.= "SELECT DISTINCT LID, UID, RATING, TSTAMP FROM {$forum_webtag}_LINKS_VOTE GROUP BY LID, UID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_LINKS_VOTE ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_LINKS_VOTE_NEW RENAME {$forum_webtag}_LINKS_VOTE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_POST_ATTACHMENT_IDS_NEW (";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (TID,PID),";
    $sql.= "  KEY AID (AID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_POST_ATTACHMENT_IDS_NEW (TID, PID, AID) ";
    $sql.= "SELECT DISTINCT TID, PID, AID FROM {$forum_webtag}_POST_ATTACHMENT_IDS GROUP BY TID, PID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_POST_ATTACHMENT_IDS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POST_ATTACHMENT_IDS_NEW RENAME {$forum_webtag}_POST_ATTACHMENT_IDS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_STATS_NEW (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (ID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_STATS_NEW (MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
    $sql.= "SELECT MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT ";
    $sql.= "FROM {$forum_webtag}_STATS ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_STATS ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_STATS_NEW RENAME {$forum_webtag}_STATS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_FOLDER_NEW (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
    $sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (UID,FID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_FOLDER_NEW (UID, FID, INTEREST, ALLOWED) ";
    $sql.= "SELECT DISTINCT UID, FID, INTEREST, ALLOWED FROM {$forum_webtag}_USER_FOLDER ";
    $sql.= "GROUP BY UID, FID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_USER_FOLDER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_FOLDER_NEW RENAME {$forum_webtag}_USER_FOLDER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_PEER_NEW (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (UID,PEER_UID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_PEER_NEW (UID, PEER_UID, RELATIONSHIP) ";
    $sql.= "SELECT DISTINCT UID, PEER_UID, RELATIONSHIP FROM {$forum_webtag}_USER_PEER ";
    $sql.= "GROUP BY UID, PEER_UID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_USER_PEER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }


    $sql = "ALTER TABLE {$forum_webtag}_USER_PEER_NEW RENAME {$forum_webtag}_USER_PEER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_PREFS_NEW (";
    $sql.= "  UID MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL,";
    $sql.= "  FIRSTNAME VARCHAR(32) NOT NULL,";
    $sql.= "  LASTNAME VARCHAR(32) NOT NULL,";
    $sql.= "  DOB DATE DEFAULT '0000-00-00' NOT NULL,";
    $sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL,";
    $sql.= "  PIC_URL VARCHAR(255) NOT NULL,";
    $sql.= "  EMAIL_NOTIFY CHAR(1) DEFAULT 'Y' NOT NULL,";
    $sql.= "  TIMEZONE DECIMAL(2, 1) DEFAULT '0.0' NOT NULL,";
    $sql.= "  DL_SAVING CHAR(1) DEFAULT 'N' NOT NULL,";
    $sql.= "  MARK_AS_OF_INT CHAR(1) DEFAULT 'Y' NOT NULL,";
    $sql.= "  POSTS_PER_PAGE TINYINT(3) UNSIGNED DEFAULT '20' NOT NULL,";
    $sql.= "  FONT_SIZE TINYINT(3) UNSIGNED DEFAULT '10' NOT NULL,";
    $sql.= "  STYLE VARCHAR(255) NOT NULL,";
    $sql.= "  EMOTICONS VARCHAR(255) NOT NULL,";
    $sql.= "  VIEW_SIGS CHAR(1) DEFAULT '' NOT NULL,";
    $sql.= "  START_PAGE TINYINT(3) UNSIGNED DEFAULT '0' NOT NULL,";
    $sql.= "  LANGUAGE VARCHAR(32) NOT NULL,";
    $sql.= "  PM_NOTIFY CHAR(1) DEFAULT 'Y' NOT NULL,";
    $sql.= "  PM_NOTIFY_EMAIL CHAR(1) DEFAULT 'Y' NOT NULL,";
    $sql.= "  DOB_DISPLAY TINYINT(3) UNSIGNED DEFAULT '2' NOT NULL,";
    $sql.= "  ANON_LOGON TINYINT(3) UNSIGNED DEFAULT '0' NOT NULL,";
    $sql.= "  SHOW_STATS TINYINT(3) UNSIGNED DEFAULT '1' NOT NULL,";
    $sql.= "  IMAGES_TO_LINKS CHAR(1) DEFAULT 'N' NOT NULL,";
    $sql.= "  USE_WORD_FILTER CHAR(1) DEFAULT 'N' NOT NULL,";
    $sql.= "  USE_ADMIN_FILTER CHAR(1) DEFAULT 'N' NOT NULL,";
    $sql.= "  ALLOW_EMAIL CHAR(1) DEFAULT 'Y' NOT NULL,";
    $sql.= "  ALLOW_PM CHAR(1) DEFAULT 'Y' NOT NULL,";
    $sql.= "  POST_PAGE INT(32) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY (UID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_PREFS_NEW (UID, FIRSTNAME, LASTNAME, DOB, HOMEPAGE_URL, PIC_URL,";
    $sql.= "EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE, STYLE,";
    $sql.= "VIEW_SIGS, START_PAGE, LANGUAGE, PM_NOTIFY, PM_NOTIFY_EMAIL, DOB_DISPLAY, ANON_LOGON,";
    $sql.= "SHOW_STATS) SELECT DISTINCT UID, FIRSTNAME, LASTNAME, DOB, HOMEPAGE_URL, PIC_URL,";
    $sql.= "EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE,";
    $sql.= "STYLE, VIEW_SIGS, START_PAGE, LANGUAGE, PM_NOTIFY, PM_NOTIFY_EMAIL, DOB_DISPLAY,";
    $sql.= "ANON_LOGON, SHOW_STATS FROM {$forum_webtag}_USER_PREFS GROUP BY UID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_USER_PREFS ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS_NEW RENAME {$forum_webtag}_USER_PREFS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_PROFILE_NEW (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (UID,PIID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_PROFILE_NEW (UID, PIID, ENTRY) ";
    $sql.= "SELECT DISTINCT UID, PIID, ENTRY FROM {$forum_webtag}_USER_PROFILE ";
    $sql.= "GROUP BY UID, PIID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_USER_PROFILE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PROFILE_NEW RENAME {$forum_webtag}_USER_PROFILE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_SIG_NEW (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  CONTENT TEXT,";
    $sql.= "  HTML CHAR(1) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY (UID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_SIG_NEW (UID, CONTENT, HTML) ";
    $sql.= "SELECT DISTINCT UID, CONTENT, HTML FROM {$forum_webtag}_USER_SIG ";
    $sql.= "GROUP BY UID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_USER_SIG";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_SIG_NEW RENAME {$forum_webtag}_USER_SIG";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_THREAD_NEW (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,";
    $sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
    $sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY (UID, TID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_THREAD_NEW (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
    $sql.= "SELECT DISTINCT UID, TID, LAST_READ, LAST_READ_AT, INTEREST ";
    $sql.= "FROM {$forum_webtag}_USER_THREAD GROUP BY UID, TID ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_USER_THREAD ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD_NEW RENAME {$forum_webtag}_USER_THREAD";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD ADMIN_LOCK DATETIME DEFAULT NULL";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_PM ADD NOTIFIED TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_PM ADD REPLY_TO_MID MEDIUMINT(8) UNSIGNED NOT NULL AFTER MID";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "UPDATE {$forum_webtag}_PM SET NOTIFIED = 1 WHERE TYPE > 1";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POLL_VOTES DROP VOTES";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_FILTER_LIST_NEW (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',  ";
    $sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
    $sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
    $sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY (ID, UID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_FILTER_LIST_NEW (ID, UID, MATCH_TEXT, REPLACE_TEXT, FILTER_OPTION) ";
    $sql.= "SELECT DISTINCT ID, 0, FILTER, REPEAT('*', LENGTH(FILTER)), 1 FROM {$forum_webtag}_FILTER_LIST ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DROP TABLE {$forum_webtag}_FILTER_LIST ";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_FILTER_LIST_NEW RENAME {$forum_webtag}_FILTER_LIST";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE SESSIONS ADD FID MEDIUMINT(8) UNSIGNED DEFAULT '0' NOT NULL";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE SESSIONS ADD INDEX (FID)";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE SESSIONS ADD INDEX (UID)";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE FORUMS (";
    $sql.= "  FID mediumint(8) unsigned NOT NULL auto_increment,";
    $sql.= "  WEBTAG varchar(255) NOT NULL default '',";
    $sql.= "  DEFAULT_FORUM tinyint(4) NOT NULL default '0',";
    $sql.= "  ACCESS_LEVEL tinyint(4) NOT NULL default '0',";
    $sql.= "  FORUM_PASSWD VARCHAR(32) NOT NULL default '',";
    $sql.= "  PRIMARY KEY (FID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUMS (WEBTAG, {$forum_webtag}_FORUM) VALUES('DEFAULT', 1)";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE FORUM_SETTINGS (";
    $sql.= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  SNAME VARCHAR(255) NOT NULL,";
    $sql.= "  SVALUE VARCHAR(255) NOT NULL,";
    $sql.= "  INDEX (SID, FID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_name', 'A Beehive Forum')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_email', 'admin@abeehiveforum.net')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, '{$forum_webtag}_style', 'default')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, '{$forum_webtag}_emoticon', 'default')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, '{$forum_webtag}_language', 'en')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_stats', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_links', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'auto_logon', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_pms', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'pm_allow_attachments', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'maximum_post_length', '6226')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_post_editing', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'post_edit_time', '0')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_polls', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'search_min_word_length', '3')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_enabled', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_dir', 'attachments')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_allow_embed', 'N')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_use_old_method', 'N')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'guest_account_active', 'Y')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'session_cutoff', '86400')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'active_session_cutoff', '900')";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE VISITOR_LOG (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  LAST_LOGON DATETIME NOT NULL,";
    $sql.= "  PRIMARY KEY (UID, FID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO VISITOR_LOG (UID, FID, LAST_LOGON) SELECT UID, 1, LAST_LOGON FROM USER";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER DROP LAST_LOGON";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE USER DROP LOGON_FROM";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POST_ATTACHMENT_FILES ADD DELETED TINYINT UNSIGNED DEFAULT '0' NOT NULL";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE USER_FORUM (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
    $sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
    $sql.= "  PRIMARY KEY (UID, FID)";
    $sql.= ") TYPE = MYISAM";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "DELETE FROM USER WHERE LOGON = 'GUEST' AND (PASSWD = MD5('GUEST') OR PASSWD = MD5('guest'))";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_GROUPS (";
    $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
    $sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
    $sql.= "  AUTO_GROUP TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY (GID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_GROUP_PERMS (";
    $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY (GID,FID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "CREATE TABLE {$forum_webtag}_GROUP_USERS (";
    $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (GID,UID)";
    $sql.= ")";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    // User Permissions

    $sql = "SELECT UID, STATUS FROM USER WHERE STATUS IS NOT NULL AND STATUS > 0";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        $new_status = 0;

        $sql = "INSERT INTO {$forum_webtag}_GROUPS (AUTO_GROUP) VALUES (1)";

        if (!$result_gid = mysql_query($sql, $db_install)) {
            $valid = false;
        }

        $gid = mysql_insert_id($db_install);

        $sql = "INSERT INTO {$forum_webtag}_GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$gid', '{$row['UID']}')";

        if (!$result_uid = mysql_query($sql, $db_install)) {
            $valid = false;
        }

        if (($row['STATUS'] & 32) > 0) $new_status = (double)$new_status | 1024;
        if (($row['STATUS'] & 16) > 0) $new_status = (double)$new_status | 512;
        if (($row['STATUS'] & 4)  > 0) $new_status = (double)$new_status | 2;
        if (($row['STATUS'] & 1)  > 0) $new_status = (double)$new_status | 1;

        $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "VALUES ('$gid', '0', '$new_status')";

        if (!$result_perm = mysql_query($sql, $db_install)) {
            $valid = false;
        }

        if (($row['STATUS'] & 32) > 0 || ($row['STATUS'] & 16) > 0 || ($row['STATUS'] & 8) > 0) {

            $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
            $sql.= "SELECT $gid, FID, 6652 FROM {$forum_webtag}_FOLDER ";
            $sql.= "WHERE ACCESS_LEVEL = 0 ";

            if (!$result_fid = mysql_query($sql, $db_install)) {
                $valid = false;
            }
        }
    }

    // Default Folder Permissions

    $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
    $sql.= "SELECT 0, FID, 0 FROM {$forum_webtag}_FOLDER WHERE ";
    $sql.= "ACCESS_LEVEL = -1 OR ACCESS_LEVEL = 1";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
    $sql.= "SELECT 0, FID, 6396 FROM {$forum_webtag}_FOLDER WHERE ";
    $sql.= "ACCESS_LEVEL = 0";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    // User Folder Permissions

    $sql = "SELECT UID, FID FROM {$forum_webtag}_USER_FOLDER WHERE ALLOWED = 1";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        $sql = "SELECT GID FROM {$forum_webtag}_GROUP_USERS WHERE UID = '{$row['UID']}'";

        if (!$result_gid = mysql_query($sql, $db_install)) {
            $valid = false;
        }

        if (mysql_num_rows($result_gid) > 0) {

            list($gid) = mysql_fetch_array($result_gid, MYSQL_NUM);

            $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
            $sql.= "VALUES ('$gid', '{$row['FID']}', '6396')";

            if (!$result_perm = mysql_query($sql, $db_install)) {
                $valid = false;
            }

        }else {

            $sql = "INSERT INTO {$forum_webtag}_GROUPS (AUTO_GROUP) VALUES (1)";

            if (!$result_gid = mysql_query($sql, $db_install)) {
                $valid = false;
            }

            $gid = mysql_insert_id($db_install);

            $sql = "INSERT INTO {$forum_webtag}_GROUP_USERS (GID, UID) ";
            $sql.= "VALUES ('$gid', '{$row['UID']}')";

            if (!$result_uid = mysql_query($sql, $db_install)) {
                $valid = false;
            }

            $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
            $sql.= "VALUES ('$gid', '{$row['FID']}', '6396')";

            if (!$result_perm = mysql_query($sql, $db_install)) {
                $valid = false;
            }
        }
    }

    $sql = "ALTER TABLE USER DROP STATUS";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_FOLDER DROP ALLOWED";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_FOLDER DROP ACCESS_LEVEL";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POLL ADD OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER VOTETYPE";

    if (!$result = mysql_query($sql, $db_install)) {
        $valid = false;
    }
}

?>