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

/* $Id: upgrade-05pr1-to-05.php,v 1.11 2004-12-18 19:36:53 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-05pr1-to-05.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;

}else if (!isset($_SERVER['PHP_SELF'])) {

    echo "To install BeehiveForums 0.5 please visit install.php in your browser";
    exit;
}

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/install.inc.php");

set_time_limit(0);

// This script upgrades all forums it finds regardless of the
// WEBTAG entered in the install form. This is imperative that
// this happens because otherwise if you later try to upgrade
// a second forum you will run into problems

if (install_table_exists('FORUMS')) {

    if (!$forum_webtag_array = install_get_webtags()) {

        $valid = false;
        return;
    }
}

// Recreate the old 0.4 tables for the PM.
// This is to allow globalisation of the PMs
// so user's don't end up with multiple
// inboxes that are hard to keep track of.

if (!install_table_exists('PM')) {

    $sql = "CREATE TABLE PM (";
    $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '',";
    $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY (MID),";
    $sql.= "  KEY TO_UID (TO_UID)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_table_exists('PM_ATTACHMENT_IDS')) {

    $sql = "CREATE TABLE PM_ATTACHMENT_IDS (";
    $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (MID),";
    $sql.= "  KEY AID (AID)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_table_exists('PM_CONTENT')) {

    $sql = "CREATE TABLE PM_CONTENT (";
    $sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  CONTENT TEXT,";
    $sql.= "  PRIMARY KEY  (MID),";
    $sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Recreate the old 0.4 Attachment tables.

if (!install_table_exists('POST_ATTACHMENT_IDS')) {

    $sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (FID, TID, PID),";
    $sql.= "  KEY AID (AID)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_table_exists('POST_ATTACHMENT_FILES')) {

    $sql = "CREATE TABLE POST_ATTACHMENT_FILES (";
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
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// DEDUPE has been globalised so we can drop the per-forum
// table

if (!install_table_exists('DEDUPE')) {

    $sql = "CREATE TABLE DEDUPE (";
    $sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
    $sql.= "  DDKEY char(32) default NULL,";
    $sql.= "  PRIMARY KEY  (UID)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Bug in the SESSIONS table that prevents guests having
// the same IP address from using the forum. Easier
// to drop and recreate the table here with the new
// indexes / keys.

$sql = "DROP TABLE IF EXISTS SESSIONS";

if (!$result = db_query($sql, $db_install)) {

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
$sql.= ") TYPE=MyISAM";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // DEDUPE has been globalised so we can drop the per-forum
    // table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_DEDUPE";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Need to allow Guest access to the folders which is the
    // default behaviour.

    $sql = "UPDATE {$forum_webtag}_GROUP_PERMS ";
    $sql.= "SET PERM = PERM & 8192 WHERE GID = 0 AND FID > 0";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Need to recreate the THREAD table so we reuse the BY_UID column
    // that was removed in 0.4. This is designed as a measure to combat
    // server load introduced by the ignore completely option making
    // use of the POST table.

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_THREAD_NEW";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_THREAD_NEW (";
    $sql.= "  TID mediumint(8) unsigned NOT NULL auto_increment,";
    $sql.= "  FID mediumint(8) unsigned default NULL,";
    $sql.= "  BY_UID mediumint(8) unsigned default NULL,";
    $sql.= "  TITLE varchar(64) default NULL,";
    $sql.= "  LENGTH mediumint(8) unsigned default NULL,";
    $sql.= "  POLL_FLAG char(1) default NULL,";
    $sql.= "  CREATED datetime DEFAULT NULL,";
    $sql.= "  MODIFIED datetime default NULL,";
    $sql.= "  CLOSED datetime default NULL,";
    $sql.= "  STICKY char(1) default NULL,";
    $sql.= "  STICKY_UNTIL datetime default NULL,";
    $sql.= "  ADMIN_LOCK datetime default NULL,";
    $sql.= "  PRIMARY KEY  (TID),";
    $sql.= "  KEY BY_UID (BY_UID),";
    $sql.= "  KEY FID (FID),";
    $sql.= "  FULLTEXT KEY TITLE (TITLE)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Insert the old threads into the new table along with the FROM_UID
    // of the POST table as the BY_UID column.

    $sql = "INSERT INTO {$forum_webtag}_THREAD_NEW (TID, FID, ";
    $sql.= "BY_UID, TITLE, LENGTH, POLL_FLAG, CREATED, MODIFIED, ";
    $sql.= "CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) SELECT THREAD.TID, ";
    $sql.= "THREAD.FID, POST.FROM_UID, THREAD.TITLE, THREAD.LENGTH, ";
    $sql.= "THREAD.POLL_FLAG, POST.CREATED, THREAD.MODIFIED, ";
    $sql.= "THREAD.CLOSED, THREAD.STICKY, THREAD.STICKY_UNTIL, ";
    $sql.= "THREAD.ADMIN_LOCK FROM {$forum_webtag}_THREAD THREAD ";
    $sql.= "LEFT JOIN {$forum_webtag}_POST POST ON ";
    $sql.= "(POST.TID = THREAD.TID AND POST.PID = 1)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // DROP the old THREAD table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_THREAD";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new THREAD table

    $sql = "ALTER TABLE {$forum_webtag}_THREAD_NEW RENAME {$forum_webtag}_THREAD";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Visitor log has been changed to per-forum table.

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_VISITOR_LOG";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_VISITOR_LOG (";
    $sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
    $sql.= "  LAST_LOGON datetime DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (UID)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the global visitor log. No point trying to fetch
    // the old values from it really, as there will be a lot
    // of duplicates that don't make any sense.

    $sql = "DROP TABLE IF EXISTS VISITOR_LOG";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Bug in the timezone preference meant it was impossible
    // to set your timezone beyond -9.9 GMT

    $sql = "ALTER TABLE USER_PREFS CHANGE TIMEZONE ";
    $sql.= "TIMEZONE DECIMAL(3,1) DEFAULT '0.0' NOT NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Move the data from the previous WEBTAG-ed PM tables into
    // the globalised tables. Downside to this is that the MIDs
    // for some messages will change which will affect people's
    // email notification links, but this is better than
    // loosing people's PMs entirely!

    if (install_table_exists("{$forum_webtag}_PM")) {

        $sql = "SELECT * FROM {$forum_webtag}_PM";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        while($pm_data = db_fetch_array($result)) {

            $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, CREATED, NOTIFIED) ";
            $sql.= "VALUES ('{$pm_data['TYPE']}', '{$pm_data['TO_UID']}', '{$pm_data['FROM_UID']}', ";
            $sql.= "'{$pm_data['SUBJECT']}', '{$pm_data['CREATED']}', '{$pm_data['NOTIFIED']}')";

            if ($pm_result = db_query($sql, $db_install)) {

                $pm_mid = db_insert_id($db_install);

                if (install_table_exists("{$forum_webtag}_PM_ATTACHMENT_IDS")) {

                    $sql = "INSERT INTO PM_ATTACHMENT_IDS (MID, AID) ";
                    $sql.= "SELECT MID, AID FROM {$forum_webtag}_PM_ATTACHMENT_IDS ";
                    $sql.= "WHERE MID = $pm_mid";

                    if (!$result = db_query($sql, $db_install)) {

                        $valid = false;
                        return;
                    }
                }

                if (install_table_exists("{$forum_webtag}_PM_CONTENT")) {

                    $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
                    $sql.= "SELECT MID, CONTENT FROM {$forum_webtag}_PM_CONTENT ";
                    $sql.= "WHERE MID = $pm_mid";

                    if (!$result = db_query($sql, $db_install)) {

                        $valid = false;
                        return;
                    }
                }

            }else {

                $valid = false;
                return;
            }
        }
    }


    // Drop the old PM table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_PM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the old PM_ATTACHMENT_IDS table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_PM_ATTACHMENT_IDS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the old PM_CONTENT table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_PM_CONTENT";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Fix the USER_PREFS table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_USER_PREFS_NEW";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_PREFS_NEW (";
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
    $sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
    $sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT '1',";
    $sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
    $sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
    $sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
    $sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
    $sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
    $sql.= "  PRIMARY KEY  (UID)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Move the data from the old USER_PREFS table into
    // our new one.

    $sql = "INSERT INTO {$forum_webtag}_USER_PREFS_NEW (UID, HOMEPAGE_URL, PIC_URL, ";
    $sql.= "EMAIL_NOTIFY, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE, STYLE, EMOTICONS, ";
    $sql.= "VIEW_SIGS, START_PAGE, LANGUAGE, DOB_DISPLAY, ANON_LOGON, SHOW_STATS, ";
    $sql.= "IMAGES_TO_LINKS, USE_WORD_FILTER, USE_ADMIN_FILTER, ALLOW_EMAIL, ALLOW_PM) ";
    $sql.= "SELECT UID, HOMEPAGE_URL, PIC_URL, EMAIL_NOTIFY, MARK_AS_OF_INT, POSTS_PER_PAGE, ";
    $sql.= "FONT_SIZE, STYLE, EMOTICONS, VIEW_SIGS, START_PAGE, LANGUAGE, DOB_DISPLAY, ";
    $sql.= "ANON_LOGON, SHOW_STATS, IMAGES_TO_LINKS, USE_WORD_FILTER, USE_ADMIN_FILTER, ";
    $sql.= "ALLOW_EMAIL, ALLOW_PM FROM {$forum_webtag}_USER_PREFS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // DROP the old USER_PREFS table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_USER_PREFS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new USER_PREFS table

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS_NEW RENAME {$forum_webtag}_USER_PREFS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Attachments have changed to support handling across multiple forums
    // from one set of tables rather than per forum. Allows better user
    // tracking of attachments and PM attachments to work correctly.

    if (install_table_exists("{$forum_webtag}_POST_ATTACHMENT_IDS")) {

        $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
        $sql.= "SELECT $forum_fid, TID, PID, AID FROM {$forum_webtag}_POST_ATTACHMENT_IDS";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POST_ATTACHMENT_IDS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    if (install_table_exists("{$forum_webtag}_POST_ATTACHMENT_FILES")) {

        $sql = "INSERT INTO POST_ATTACHMENT_FILES (AID, UID, FILENAME, ";
        $sql.= "MIMETYPE, HASH, DOWNLOADS, DELETED) SELECT AID, UID, ";
        $sql.= "FILENAME, MIMETYPE, HASH, DOWNLOADS, DELETED FROM ";
        $sql.= "{$forum_webtag}_POST_ATTACHMENT_FILES";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POST_ATTACHMENT_FILES";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Create the table for the dictionary

$sql = "DROP TABLE IF EXISTS DICTIONARY";

if (!$result = db_query($sql, $db_install)) {

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
$sql.= ") TYPE=MyISAM";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Import English dictionary

$dictionary_words = file('./install/english.dic');

foreach($dictionary_words as $word) {

    $metaphone = addslashes(metaphone(trim($word)));
    $word = addslashes(trim($word));

    $sql = "INSERT INTO DICTIONARY (WORD, SOUND, UID) ";
    $sql.= "VALUES ('$word', '$metaphone', 0)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>