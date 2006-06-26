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

/* $Id: upgrade-04-to-05.php,v 1.44 2006-06-26 11:04:49 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-04-to-05.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;

}

if (!isset($_SERVER['SCRIPT_FILENAME'])) {
    $_SERVER['SCRIPT_FILENAME'] = $_SERVER['SCRIPT_NAME'];
}

$dictionary_file = preg_replace('/\\\/', '/', dirname($_SERVER['SCRIPT_FILENAME']));
$dictionary_file.= "/install/english.dic";

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

@set_time_limit(0);

if (isset($forum_webtag) && strlen(trim($forum_webtag)) > 0) {

    $forum_webtag_array[] = $forum_webtag;

}else {

    $error_html.= "<h2>You must specify a forum webtag for your choosen type of installation.</h2>\n";
    $valid = false;
}

if (isset($forum_webtag_array) && sizeof($forum_webtag_array) > 0) {

    foreach($forum_webtag_array as $forum_webtag) {

        $sql = "ALTER TABLE ADMIN_LOG RENAME {$forum_webtag}_ADMIN_LOG";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE BANNED_IP RENAME {$forum_webtag}_BANNED_IP";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE FILTER_LIST RENAME {$forum_webtag}_FILTER_LIST";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE FOLDER RENAME {$forum_webtag}_FOLDER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE LINKS RENAME {$forum_webtag}_LINKS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE LINKS_COMMENT RENAME {$forum_webtag}_LINKS_COMMENT";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE LINKS_FOLDERS RENAME {$forum_webtag}_LINKS_FOLDERS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE LINKS_VOTE RENAME {$forum_webtag}_LINKS_VOTE";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE POLL RENAME {$forum_webtag}_POLL";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE POLL_VOTES RENAME {$forum_webtag}_POLL_VOTES";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE POST RENAME {$forum_webtag}_POST";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE POST_ATTACHMENT_FILES RENAME {$forum_webtag}_POST_ATTACHMENT_FILES";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE POST_ATTACHMENT_IDS RENAME {$forum_webtag}_POST_ATTACHMENT_IDS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE POST_CONTENT RENAME {$forum_webtag}_POST_CONTENT";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE PROFILE_ITEM RENAME {$forum_webtag}_PROFILE_ITEM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE PROFILE_SECTION RENAME {$forum_webtag}_PROFILE_SECTION";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE STATS RENAME {$forum_webtag}_STATS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE THREAD RENAME {$forum_webtag}_THREAD";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_FOLDER RENAME {$forum_webtag}_USER_FOLDER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_PEER RENAME {$forum_webtag}_USER_PEER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_POLL_VOTES RENAME {$forum_webtag}_USER_POLL_VOTES";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_PROFILE RENAME {$forum_webtag}_USER_PROFILE";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_SIG RENAME {$forum_webtag}_USER_SIG";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_THREAD RENAME {$forum_webtag}_USER_THREAD";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_BANNED_IP_NEW (";
        $sql.= "  IP CHAR(15) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (IP)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_BANNED_IP_NEW (IP) ";
        $sql.= "SELECT DISTINCT IP FROM {$forum_webtag}_BANNED_IP";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_BANNED_IP";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_BANNED_IP_NEW RENAME {$forum_webtag}_BANNED_IP";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_THREAD_NEW (";
        $sql.= "  TID mediumint(8) unsigned NOT NULL AUTO_INCREMENT,";
        $sql.= "  FID mediumint(8) unsigned DEFAULT NULL,";
        $sql.= "  BY_UID mediumint(8) DEFAULT NULL,";
        $sql.= "  TITLE varchar(64) DEFAULT NULL,";
        $sql.= "  LENGTH mediumint(8) unsigned DEFAULT NULL,";
        $sql.= "  POLL_FLAG char(1) DEFAULT NULL,";
        $sql.= "  MODIFIED datetime DEFAULT NULL,";
        $sql.= "  CLOSED datetime DEFAULT NULL,";
        $sql.= "  STICKY char(1) DEFAULT NULL,";
        $sql.= "  STICKY_UNTIL datetime DEFAULT NULL,";
        $sql.= "  ADMIN_LOCK datetime DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (TID),";
        $sql.= "  KEY FID (FID),";
        $sql.= "  KEY BY_UID (BY_UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_THREAD_NEW (TID, FID, BY_UID, TITLE, LENGTH, ";
        $sql.= "POLL_FLAG, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
        $sql.= "SELECT THREAD.TID, THREAD.FID, POST.FROM_UID, THREAD.TITLE, ";
        $sql.= "THREAD.LENGTH, THREAD.POLL_FLAG, THREAD.MODIFIED, THREAD.CLOSED, ";
        $sql.= "THREAD.STICKY, THREAD.STICKY_UNTIL, NULL ";
        $sql.= "FROM {$forum_webtag}_THREAD THREAD LEFT JOIN {$forum_webtag}_POST POST ";
        $sql.= "ON (POST.TID = THREAD.TID AND POST.PID = 1)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_THREAD ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_THREAD_NEW RENAME {$forum_webtag}_THREAD";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_LINKS_VOTE_NEW (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  PRIMARY KEY (LID, UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_LINKS_VOTE_NEW (LID, UID, RATING, TSTAMP) ";
        $sql.= "SELECT DISTINCT LID, UID, RATING, TSTAMP FROM {$forum_webtag}_LINKS_VOTE GROUP BY LID, UID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_LINKS_VOTE ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_LINKS_VOTE_NEW RENAME {$forum_webtag}_LINKS_VOTE";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_POST_ATTACHMENT_IDS_NEW (";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY  (TID,PID),";
        $sql.= "  KEY AID (AID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_POST_ATTACHMENT_IDS_NEW (TID, PID, AID) ";
        $sql.= "SELECT DISTINCT TID, PID, AID FROM {$forum_webtag}_POST_ATTACHMENT_IDS GROUP BY TID, PID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_POST_ATTACHMENT_IDS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_POST_ATTACHMENT_IDS_NEW RENAME {$forum_webtag}_POST_ATTACHMENT_IDS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_STATS_NEW (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
        $sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (ID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_STATS_NEW (MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
        $sql.= "SELECT MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT ";
        $sql.= "FROM {$forum_webtag}_STATS ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_STATS ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_STATS_NEW RENAME {$forum_webtag}_STATS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_USER_FOLDER_NEW (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
        $sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (UID,FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_USER_FOLDER_NEW (UID, FID, INTEREST, ALLOWED) ";
        $sql.= "SELECT DISTINCT UID, FID, INTEREST, ALLOWED FROM {$forum_webtag}_USER_FOLDER ";
        $sql.= "GROUP BY UID, FID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_USER_FOLDER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_USER_FOLDER_NEW RENAME {$forum_webtag}_USER_FOLDER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_USER_PEER_NEW (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PEER_UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_USER_PEER_NEW (UID, PEER_UID, RELATIONSHIP) ";
        $sql.= "SELECT DISTINCT UID, PEER_UID, RELATIONSHIP FROM {$forum_webtag}_USER_PEER ";
        $sql.= "GROUP BY UID, PEER_UID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_USER_PEER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }


        $sql = "ALTER TABLE {$forum_webtag}_USER_PEER_NEW RENAME {$forum_webtag}_USER_PEER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE USER_PREFS_NEW (";
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
        $sql.= "  PM_SAVE_SENT_ITEM CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  PM_INCLUDE_REPLY CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  PM_AUTO_PRUNE CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  PM_AUTO_PRUNE_LENGTH CHAR(3) NOT NULL DEFAULT '60',";
        $sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
        $sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  POST_PAGE CHAR(4) NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO USER_PREFS_NEW (UID, FIRSTNAME, LASTNAME, DOB, HOMEPAGE_URL, PIC_URL, ";
        $sql.= "EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE, STYLE, ";
        $sql.= "VIEW_SIGS, START_PAGE, LANGUAGE, PM_NOTIFY, PM_NOTIFY_EMAIL, DOB_DISPLAY, ANON_LOGON, ";
        $sql.= "SHOW_STATS) SELECT DISTINCT UID, FIRSTNAME, LASTNAME, DOB, HOMEPAGE_URL, PIC_URL, ";
        $sql.= "EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE, ";
        $sql.= "STYLE, VIEW_SIGS, START_PAGE, LANGUAGE, PM_NOTIFY, PM_NOTIFY_EMAIL, DOB_DISPLAY, ";
        $sql.= "ANON_LOGON, SHOW_STATS FROM USER_PREFS GROUP BY UID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET EMAIL_NOTIFY = 'N' WHERE EMAIL_NOTIFY != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET MARK_AS_OF_INT = 'N' WHERE MARK_AS_OF_INT != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET VIEW_SIGS = 'N' WHERE VIEW_SIGS != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET PM_NOTIFY = 'N' WHERE PM_NOTIFY != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET PM_NOTIFY_EMAIL = 'N' WHERE PM_NOTIFY_EMAIL <> 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET PM_SAVE_SENT_ITEM = 'Y' WHERE 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET PM_INCLUDE_REPLY = 'N' WHERE 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET PM_AUTO_PRUNE = 'N' WHERE 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET PM_AUTO_PRUNE_LENGTH = '60' WHERE 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET IMAGES_TO_LINKS = 'N' WHERE IMAGES_TO_LINKS != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET USE_WORD_FILTER = 'N' WHERE USE_WORD_FILTER != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET USE_ADMIN_FILTER = 'N' WHERE USE_ADMIN_FILTER != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET ALLOW_EMAIL = 'N' WHERE ALLOW_EMAIL != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE USER_PREFS_NEW SET ALLOW_PM = 'N' WHERE ALLOW_PM != 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE USER_PREFS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER_PREFS_NEW RENAME USER_PREFS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
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
        $sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
        $sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
        $sql.= "  PRIMARY KEY  (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_USER_PROFILE_NEW (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  ENTRY VARCHAR(255) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (UID,PIID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_USER_PROFILE_NEW (UID, PIID, ENTRY) ";
        $sql.= "SELECT DISTINCT UID, PIID, ENTRY FROM {$forum_webtag}_USER_PROFILE ";
        $sql.= "GROUP BY UID, PIID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_USER_PROFILE";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_USER_PROFILE_NEW RENAME {$forum_webtag}_USER_PROFILE";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_USER_SIG_NEW (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  CONTENT TEXT,";
        $sql.= "  HTML CHAR(1) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_USER_SIG_NEW (UID, CONTENT, HTML) ";
        $sql.= "SELECT DISTINCT UID, CONTENT, HTML FROM {$forum_webtag}_USER_SIG ";
        $sql.= "GROUP BY UID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_USER_SIG";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_USER_SIG_NEW RENAME {$forum_webtag}_USER_SIG";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_USER_THREAD_NEW (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,";
        $sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
        $sql.= "  LAST_READ_AT DATETIME DEFAULT NULL,";
        $sql.= "  INTEREST TINYINT(4) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY (UID, TID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_USER_THREAD_NEW (UID, TID, LAST_READ, LAST_READ_AT, INTEREST) ";
        $sql.= "SELECT DISTINCT UID, TID, LAST_READ, LAST_READ_AT, INTEREST ";
        $sql.= "FROM {$forum_webtag}_USER_THREAD GROUP BY UID, TID ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_USER_THREAD ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD_NEW RENAME {$forum_webtag}_USER_THREAD";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE PM ADD NOTIFIED TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE PM SET NOTIFIED = 1 WHERE TYPE > 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_POLL_VOTES DROP VOTES";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_FILTER_LIST_NEW (";
        $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',  ";
        $sql.= "  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',";
        $sql.= "  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY (ID, UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_FILTER_LIST_NEW (ID, UID, MATCH_TEXT, REPLACE_TEXT, FILTER_OPTION) ";
        $sql.= "SELECT DISTINCT ID, 0, FILTER, REPEAT('*', CHAR_LENGTH(FILTER)), 1 FROM {$forum_webtag}_FILTER_LIST ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE {$forum_webtag}_FILTER_LIST ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_FILTER_LIST_NEW RENAME {$forum_webtag}_FILTER_LIST";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE SESSIONS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE SESSIONS (";
        $sql.= "  HASH varchar(32) NOT NULL default '',";
        $sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
        $sql.= "  IPADDRESS varchar(15) NOT NULL default '',";
        $sql.= "  TIME datetime NOT NULL default '0000-00-00 00:00:00',";
        $sql.= "  FID mediumint(8) unsigned NOT NULL default '0',";
        $sql.= "  PRIMARY KEY  (HASH, UID, IPADDRESS)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE FORUMS (";
        $sql.= "  FID mediumint(8) unsigned NOT NULL auto_increment,";
        $sql.= "  WEBTAG varchar(255) NOT NULL DEFAULT '',";
        $sql.= "  DEFAULT_FORUM tinyint(4) NOT NULL DEFAULT '0',";
        $sql.= "  ACCESS_LEVEL tinyint(4) NOT NULL DEFAULT '0',";
        $sql.= "  FORUM_PASSWD VARCHAR(32) NOT NULL DEFAULT '',";
        $sql.= "  PRIMARY KEY (FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO FORUMS (WEBTAG, DEFAULT_FORUM) VALUES('{$forum_webtag}', 1)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE FORUM_SETTINGS (";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  SNAME VARCHAR(255) NOT NULL,";
        $sql.= "  SVALUE VARCHAR(255) NOT NULL,";
        $sql.= "  PRIMARY KEY (FID, SNAME)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $forum_settings = array('1' => array('forum_name'             => 'A Beehive Forum',
                                             'forum_email'            => 'admin@abeehiveforum.net',
                                             'forum_desc'             => 'A Beehive Forum',
                                             'forum_keywords'         => 'BeehiveForums, Beehive, Forum, Community',
                                             'default_style'          => 'default',
                                             'default_emoticons'      => 'default',
                                             'default_language'       => 'en',
                                             'allow_post_editing'     => 'Y',
                                             'post_edit_time'         => '0',
                                             'maximum_post_length'    => '6226',
                                             'allow_polls'            => 'Y',
                                             'show_stats'             => 'Y',
                                             'guest_account_enabled'  => 'Y',
                                             'allow_search_spidering' => 'Y'),

                                '0' => array('show_pms'                   => 'Y',
                                             'pm_max_user_messages'       => '100',
                                             'pm_auto_prune'              => 'N',
                                             'pm_auto_prune_length'       => '-60',
                                             'pm_allow_attachments'       => 'Y',
                                             'session_cutoff'             => '86400',
                                             'active_sess_cutoff'         => '900',
                                             'attachment_dir'             => 'attachments',
                                             'attachments_enabled'        => 'Y',
                                             'attachments_max_user_space' => '1048576',
                                             'attachments_allow_embed'    => 'N',
                                             'attachment_use_old_method'  => 'N',
                                             'guest_account_enabled'      => 'Y',
                                             'guest_auto_logon'           => 'Y'));

        foreach ($forum_settings as $forum => $settings_array) {

            foreach ($settings_array as $sname => $svalue) {

                $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
                $sql.= "VALUES ('$forum', '$sname', '$svalue')";

                if (!$result = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }
            }
        }

        $sql = "CREATE TABLE {$forum_webtag}_VISITOR_LOG (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  LAST_LOGON DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY (UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_VISITOR_LOG (UID, LAST_LOGON) ";
        $sql.= "SELECT UID, LAST_LOGON FROM USER";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER DROP LAST_LOGON";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE USER DROP LOGON_FROM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_FORUM_LINKS (";
        $sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  POS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  URI VARCHAR(255) DEFAULT NULL,";
        $sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (LID)";
        $sql.= ") TYPE=MYISAM";

        if(!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (1, 'Forum Links:', NULL)";

        if(!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (2, 'Project Beehive Home', 'http://www.beehiveforum.net/')";

        if(!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_FORUM_LINKS (POS, TITLE, URI) ";
        $sql.= "VALUES (2, 'Teh Forum', 'http://www.tehforum.net/forum/')";

        if(!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE USER_FORUM (";
        $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  INTEREST TINYINT(4) DEFAULT '0',";
        $sql.= "  ALLOWED TINYINT(4) DEFAULT '0',";
        $sql.= "  PRIMARY KEY (UID, FID)";
        $sql.= ") TYPE = MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DELETE FROM USER WHERE LOGON = 'GUEST' AND (PASSWD = MD5('GUEST') OR PASSWD = MD5('guest'))";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_GROUPS (";
        $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
        $sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
        $sql.= "  AUTO_GROUP TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY (GID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_GROUP_PERMS (";
        $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY (GID,FID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE {$forum_webtag}_GROUP_USERS (";
        $sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
        $sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
        $sql.= "  PRIMARY KEY  (GID,UID)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // User Permissions

        $sql = "SELECT UID, STATUS FROM USER WHERE STATUS IS NOT NULL AND STATUS > 0";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        while ($row = db_fetch_array($result)) {

            $new_status = 0;

            $sql = "INSERT INTO {$forum_webtag}_GROUPS (AUTO_GROUP) VALUES (1)";

            if (!$result_gid = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            $gid = db_insert_id($db_install);

            $sql = "INSERT INTO {$forum_webtag}_GROUP_USERS (GID, UID) ";
            $sql.= "VALUES ('$gid', '{$row['UID']}')";

            if (!$result_uid = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            if (($row['STATUS'] & USER_PERM_QUEEN)   > 0) $new_status = (double)$new_status | USER_PERM_FORUM_TOOLS;
            if (($row['STATUS'] & USER_PERM_SOLDIER) > 0) $new_status = (double)$new_status | USER_PERM_ADMIN_TOOLS;
            if (($row['STATUS'] & USER_PERM_WORM)    > 0) $new_status = (double)$new_status | USER_PERM_WORMED;
            if (($row['STATUS'] & USER_PERM_SPLAT)   > 0) $new_status = (double)$new_status | USER_PERM_BANNED;

            $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
            $sql.= "VALUES ('$gid', '0', '$new_status')";

            if (!$result_perm = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            if (($row['STATUS'] & USER_PERM_QUEEN) > 0 || ($row['STATUS'] & USER_PERM_SOLDIER) > 0 || ($row['STATUS'] & USER_PERM_WORKER) > 0) {

                $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
                $sql.= "SELECT $gid, FID, 6652 FROM {$forum_webtag}_FOLDER ";
                $sql.= "WHERE ACCESS_LEVEL = 0 ";

                if (!$result_fid = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }
            }
        }

        // Default Folder Permissions

        $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "SELECT 0, FID, 0 FROM {$forum_webtag}_FOLDER WHERE ";
        $sql.= "ACCESS_LEVEL = -1 OR ACCESS_LEVEL = 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "SELECT 0, FID, 14588 FROM {$forum_webtag}_FOLDER WHERE ";
        $sql.= "ACCESS_LEVEL = 0";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // User Folder Permissions

        $sql = "SELECT UID, FID FROM {$forum_webtag}_USER_FOLDER WHERE ALLOWED = 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        while ($row = db_fetch_array($result)) {

            $sql = "SELECT GID FROM {$forum_webtag}_GROUP_USERS WHERE UID = '{$row['UID']}'";

            if ($result_gid = @db_query($sql, $db_install)) {

                if (db_num_rows($result_gid) > 0) {

                    list($gid) = db_fetch_array($result_gid);

                    $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
                    $sql.= "VALUES ('$gid', '{$row['FID']}', '6396')";

                    if (!$result_perm = @db_query($sql, $db_install)) {

                        $valid = false;
                        return;
                    }

                }else {

                    $sql = "INSERT INTO {$forum_webtag}_GROUPS (AUTO_GROUP) VALUES (1)";

                    if (!$result_gid = @db_query($sql, $db_install)) {

                        $valid = false;
                        return;
                    }

                    $gid = db_insert_id($db_install);

                    $sql = "INSERT INTO {$forum_webtag}_GROUP_USERS (GID, UID) ";
                    $sql.= "VALUES ('$gid', '{$row['UID']}')";

                    if (!$result_uid = @db_query($sql, $db_install)) {

                        $valid = false;
                        return;
                    }

                    $sql = "INSERT INTO {$forum_webtag}_GROUP_PERMS (GID, FID, PERM) ";
                    $sql.= "VALUES ('$gid', '{$row['FID']}', '6396')";

                    if (!$result_perm = @db_query($sql, $db_install)) {

                        $valid = false;
                        return;
                    }
                }

            }else {

                $valid = false;
                return;
            }
        }

        $sql = "ALTER TABLE USER DROP STATUS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_USER_FOLDER DROP ALLOWED";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_FOLDER DROP ACCESS_LEVEL";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE {$forum_webtag}_POLL ADD OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER VOTETYPE";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE DICTIONARY (";
        $sql.= "  WORD varchar(64) NOT NULL default '',";
        $sql.= "  SOUND varchar(64) NOT NULL default '',";
        $sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
        $sql.= "  KEY SOUND (SOUND),";
        $sql.= "  KEY UID (UID),";
        $sql.= "  KEY WORD (WORD)";
        $sql.= ") TYPE=MYISAM";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        if (!isset($skip_dictionary) || $skip_dictionary === false) {

            $word_count = 0;

            $sql = "LOAD DATA INFILE '$dictionary_file' INTO TABLE DICTIONARY ";
            $sql.= "FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n' ";
            $sql.= "(WORD, SOUND)";

            if (!$result = @db_query($sql, $db_install)) {

                if ($fp = @fopen($dictionary_file, 'r')) {

                    while (!feof($fp)) {

                        $word = fgets($fp, 100);

                        list($word, $metaphone) = explode("\t", $word);

                        $metaphone = addslashes(trim($metaphone));
                        $word = addslashes(trim($word));

                        $sql = "INSERT INTO DICTIONARY (WORD, SOUND, UID) ";
                        $sql.= "VALUES ('$word', '$metaphone', 0)";

                        if (!$result = @db_query($sql, $db_install)) {

                            $valid = false;
                            return;
                        }

                        $word_count++;

                        if (($word_count % 5) == 0) {
                            install_flush_buffer();
                        }
                    }

                    fclose($fp);
                }
            }
        }
    }
}

?>
