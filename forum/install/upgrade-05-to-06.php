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

/* $Id: upgrade-05-to-06.php,v 1.39 2005-03-25 20:45:44 decoyduck Exp $ */

if (isset($_SERVER['argc']) && $_SERVER['argc'] > 0) {

    echo "\nTo upgrade your Project BeehiveForum installation\n";
    echo "please visit install.php in your browser\n";
    exit;

}elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-05-to-06.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;
}

set_time_limit(0);

$forum_webtag_array = array();

// This script upgrades all forums it finds regardless of the
// WEBTAG entered in the install form. This is imperative that
// this happens because otherwise if you later try to upgrade
// a second forum you will run into problems

$sql = "SHOW TABLES LIKE 'FORUMS'";

if (!$result = @db_query($sql, $db_install)) {

    $error_html.= "<h2>Could not locate any previous BeehiveForum installations!</h2>\n";
    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "SELECT FID, WEBTAG FROM FORUMS";

    if ($result = @db_query($sql, $db_install)) {

        while ($row = db_fetch_array($result)) {

            $forum_webtag_array[$row['FID']] = $row['WEBTAG'];
        }

    }else {

        $error_html.= "<h2>Could not locate any previous BeehiveForum installations!</h2>\n";
        $valid = false;
        return;
    }
}

$sql = "DROP TABLE IF EXISTS DEDUPE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_TRACK (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  DDKEY DATETIME DEFAULT NULL,";
$sql.= "  LAST_POST DATETIME DEFAULT NULL,";
$sql.= "  LAST_SEARCH DATETIME DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS POST_ATTACHMENT_FILES";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

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
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS POST_ATTACHMENT_IDS";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (FID, TID, PID),";
$sql.= "  KEY AID (AID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_PERMS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,FORUM,FID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_USERS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,UID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUPS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
$sql.= "  AUTO_GROUP TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_KEYWORDS (";
$sql.= "  WID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  WORD VARCHAR(50) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY (WORD),";
$sql.= "  KEY WORD_ID (WID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_MATCH (";
$sql.= "  WID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (WID,FORUM,TID,PID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_POSTS (";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  TID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  CREATED DATETIME DEFAULT NULL,";
$sql.= "  PRIMARY KEY (FORUM,TID,PID),";
$sql.= "  KEY BY_UID (BY_UID),";
$sql.= "  KEY FROM_UID (FROM_UID),";
$sql.= "  KEY TO_UID (TO_UID),";
$sql.= "  KEY CREATED (CREATED)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // Admin log has changed to be more simplified

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_ADMIN_LOG";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_ADMIN_LOG (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  CREATED DATETIME DEFAULT NULL,";
    $sql.= "  ACTION MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  ENTRY TEXT,";
    $sql.= "  PRIMARY KEY  (ID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Permissions system has changed to be global tables

    $sql = "SELECT * FROM {$forum_webtag}_GROUPS";

    if ($result = @db_query($sql, $db_install)) {

        while ($group_data = db_fetch_array($result)) {

            $sql = "INSERT INTO GROUPS (FORUM, GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
            $sql.= "VALUES ('$forum_fid', '{$group_data['GROUP_NAME']}', ";
            $sql.= "'{$group_data['GROUP_DESC']}', '{$group_data['AUTO_GROUP']}')";

            if ($result_group = @db_query($sql, $db_instal)) {

                $new_group_gid = db_insert_id($db_install);

                $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERMS) ";
                $sql.= "SELECT $new_group_gid, $forum_fid, FID, PERMS FROM ";
                $sql.= "{$forum_webtag}_GROUP_PERMS WHERE GID = '{$group_data['GID']}'";

                if (!$result = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }

                $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
                $sql.= "SELECT $new_group_gid, UID FROM {$forum_webtag}_GROUP_USERS ";
                $sql.= "WHERE GID = '{$group_data['GID']}'";

                if (!$result = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }

            }else {

                $valid = false;
                return;
            }
        }

    }else {

        $valid = false;
        return;
    }

    // Extend any USER_PERM_FORUM_TOOLS AND USER_PERM_ADMIN_TOOLS permissions
    // to cover all forums so it mimics the behavior in 0.5.

    $sql = "SELECT GID, PERM FROM {$forum_webtag}_GROUP_PERMS ";
    $sql.= "WHERE (PERM & 1024 > 0 OR PERM & 512 > 0) ";
    $sql.= "AND FID = 0";

    if ($result = @db_query($sql, $db_install)) {

        while ($user_data = db_fetch_array($result)) {

            $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERMS) ";
            $sql.= "VALUES ('{$user_data['GID']}', 0, 0, '{$user_data['PERM']}')";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }

    }else {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_GROUPS";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_GROUPS_PERMS";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_GROUPS_USERS";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Improved ban controls allow banning of IP, LOGON
    // NICKNAME and EMAIL seperatly or in combinations.

    $sql = "CREATE TABLE {$forum_webtag}_BANNED (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  IPADDRESS CHAR(15) NOT NULL DEFAULT '',";
    $sql.= "  LOGON VARCHAR(32) DEFAULT NULL,";
    $sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL,";
    $sql.= "  EMAIL VARCHAR(80) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (ID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Insert the old IP addresses from the BANNED_IP table if any

    $sql = "INSERT INTO {$forum_webtag}_BANNED (IPADDRESS) ";
    $sql.= "SELECT IP FROM {$forum_webtag}_BANNED_IP";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_BANNED_IP";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Move the attachment file records into a global PAF table

    $sql = "INSERT INTO POST_ATTACHMENT_FILES (AID, UID, FILENAME, ";
    $sql.= "MIMETYPE, HASH, DOWNLOADS, DELETED) SELECT AID, UID, ";
    $sql.= "FILENAME, MIMETYPE, HASH, DOWNLOADS, DELETED ";
    $sql.= "FROM {$forum_webtag}_POST_ATTACHMENT_FILES ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Move the attachment records into a global PAI table
    // along with the forum FID.

    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql.= "SELECT $forum_fid, TID, PID, AID ";
    $sql.= "FROM {$forum_webtag}_POST_ATTACHMENT_IDS ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Need to recreate the THREAD table so we can add the
    // CREATED column from the POST table.

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_THREAD_NEW";

    if (!$result = @db_query($sql, $db_install)) {

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
    $sql.= "  CREATED datetime default NULL,";
    $sql.= "  MODIFIED datetime default NULL,";
    $sql.= "  CLOSED datetime default NULL,";
    $sql.= "  STICKY char(1) default NULL,";
    $sql.= "  STICKY_UNTIL datetime default NULL,";
    $sql.= "  ADMIN_LOCK datetime default NULL,";
    $sql.= "  PRIMARY KEY  (TID),";
    $sql.= "  KEY BY_UID (BY_UID),";
    $sql.= "  KEY FID (FID),";
    $sql.= "  FULLTEXT KEY TITLE (TITLE)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

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

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // DROP the old THREAD table

    $sql = "DROP TABLE {$forum_webtag}_THREAD";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new THREAD table

    $sql = "ALTER TABLE {$forum_webtag}_THREAD_NEW RENAME {$forum_webtag}_THREAD";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Add an index to the CREATED column in POST table.
    // POST table can be rather large so we do this
    // by rebuilding the table because otherwise
    // MySQL seems to fall over with the following error:
    // (Unable to write to /tmp/[file] error)

    $sql = "CREATE TABLE {$forum_webtag}_POST_NEW(";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  VIEWED DATETIME DEFAULT NULL,";
    $sql.= "  CREATED DATETIME DEFAULT NULL,";
    $sql.= "  STATUS TINYINT(4) DEFAULT '0',";
    $sql.= "  APPROVED DATETIME DEFAULT NULL,";
    $sql.= "  APPROVED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  EDITED DATETIME DEFAULT NULL,";
    $sql.= "  EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY (TID, PID),";
    $sql.= "  KEY TID (TID),";
    $sql.= "  KEY TO_UID (TO_UID),";
    $sql.= "  KEY FROM_UID (FROM_UID),";
    $sql.= "  KEY IPADDRESS (IPADDRESS),";
    $sql.= "  KEY CREATED (CREATED)";
    $sql.= ") TYPE = MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Transport the data from the old table into the new one.
    // This takes a long time. Upwards of 1 minute on a forum
    // with 300,000 messages. While we're here we're also going
    // to add the columns for the post approval and populate them
    // so the existing posts are pre-approved by the original author

    $sql = "INSERT INTO {$forum_webtag}_POST_NEW (TID, PID, REPLY_TO_PID, ";
    $sql.= "FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, ";
    $sql.= "APPROVED_BY, EDITED, EDITED_BY, IPADDRESS) SELECT TID, PID, ";
    $sql.= "REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, ";
    $sql.= "NOW(), FROM_UID, EDITED, EDITED_BY, IPADDRESS FROM {$forum_webtag}_POST";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Get rid of the old POST table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POST";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new POST table

    $sql = "ALTER TABLE {$forum_webtag}_POST_NEW RENAME {$forum_webtag}_POST";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Reformat the USER_POLL_VOTES table to be less resource intensive
    // While we're here we'll clean up the data in the table because
    // 0.4 and 0.5 had problems where you could vote for the same poll
    // option multiple times.

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_USER_POLL_VOTES_NEW";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_POLL_VOTES_NEW (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  PRIMARY KEY (ID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO {$forum_webtag}_USER_POLL_VOTES_NEW (TID, UID, OPTION_ID, TSTAMP) ";
    $sql.= "SELECT TID, UID, OPTION_ID, TSTAMP FROM {$forum_webtag}_USER_POLL_VOTES ";
    $sql.= "WHERE UID > 0";

    if ($result = @db_query($sql, $db_install)) {

        $sql = "SELECT MAX(UID) AS NUM_USERS FROM USER";

        if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
            return;
        }

        list($num_users) = db_fetch_array($result, DB_RESULT_NUM);

        for ($uid = 1; $uid <= $num_users; $uid++) {

            $sql = "INSERT INTO {$forum_webtag}_USER_POLL_VOTES_NEW (TID, UID, OPTION_ID, TSTAMP) ";
            $sql.= "SELECT TID, $uid, OPTION_ID, TSTAMP FROM {$forum_webtag}_USER_POLL_VOTES ";
            $sql.= "WHERE PTUID = MD5(CONCAT(TID, '.', $uid)) AND UID = 0";

            if (!$result = @db_query($sql, $db_install)) {

                        $valid = false;
                return;
            }
        }

    }else {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_POLL_VOTES_NEW RENAME {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Lots of other indexes to make things go /fast/ (maybe)

    $sql = "ALTER TABLE FORUMS ADD INDEX (WEBTAG) ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE FORUM_SETTINGS ADD INDEX (SVALUE) ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD ADD INDEX (LAST_READ) ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD ADD INDEX (INTEREST) ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_FOLDER ADD INDEX (INTEREST)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PEER ADD INDEX (RELATIONSHIP)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM ADD INDEX (TYPE)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE USER_PREFS ADD SHOW_THUMBS CHAR(2) DEFAULT '2' NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD SHOW_THUMBS CHAR(2) DEFAULT '2' NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE USER_PREFS ADD ENABLE_WIKI_WORDS CHAR(1) DEFAULT 'Y' NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ENABLE_WIKI_WORDS CHAR(1) DEFAULT 'Y' NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE USER_PREFS CHANGE PM_AUTO_PRUNE ";
    $sql.= "PM_AUTO_PRUNE CHAR(3) DEFAULT '-60' NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE USER_PREFS SET PM_AUTO_PRUNE = PM_AUTO_PRUNE_LENGTH ";
    $sql.= "WHERE PM_AUTO_PRUNE = 'Y'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE USER_PREFS SET PM_AUTO_PRUNE = PM_AUTO_PRUNE_LENGTH * -1 ";
    $sql.= "WHERE PM_AUTO_PRUNE = 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "SELECT SVALUE FROM FORUM_SETTINGS WHERE ";
    $sql.= "SNAME = 'pm_auto_prune_length' AND FID = $forum_fid";

    if ($result = @db_query($sql, $db_install)) {

        if (db_num_rows($result) > 0) {

            list($pm_auto_prune_length) = db_fetch_array($result, DB_RESULT_NUM);

            $sql = "UPDATE FORUM_SETTINGS SET SVALUE = $pm_auto_prune_length ";
            $sql.= "WHERE SVALUE = 'Y' AND SNAME = 'pm_auto_prune' ";
            $sql.= "AND FID = $forum_fid";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            $sql = "UPDATE FORUM_SETTINGS SET SVALUE = $pm_auto_prune_length * -1 ";
            $sql.= "WHERE SVALUE = 'N' AND SNAME = 'pm_auto_prune' ";
            $sql.= "AND FID = $forum_fid";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            $sql = "DELETE FROM FORUM_SETTINGS WHERE SNAME = 'pm_auto_prune_length' ";
            $sql.= "AND FID = $forum_fid";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

        }else {

            $sql = "DELETE FROM FORUM_SETTINGS WHERE FID = $forum_fid ";
            $sql.= "AND SVALUE LIKE 'pm_auto_prune%'";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql.= "VALUES ($forum_fid, 'pm_auto_prune', -60)";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }

    }else {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE USER_PREFS DROP PM_AUTO_PRUNE_LENGTH";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE {$forum_webtag}_USER_PREFS SET SHOW_STATS = 'Y' WHERE SHOW_STATS = 1;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE {$forum_webtag}_USER_PREFS SET SHOW_STATS = 'N' WHERE SHOW_STATS = 0;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE USER_PREFS SET SHOW_STATS = 'Y' WHERE SHOW_STATS = 1;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE USER_PREFS SET SHOW_STATS = 'N' WHERE SHOW_STATS = 0;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE {$forum_webtag}_USER_PREFS SET SHOW_STATS = 'Y' WHERE ANON_LOGON = 1;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE {$forum_webtag}_USER_PREFS SET SHOW_STATS = 'N' WHERE ANON_LOGON = 0;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE USER_PREFS SET SHOW_STATS = 'Y' WHERE ANON_LOGON = 1;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE USER_PREFS SET SHOW_STATS = 'N' WHERE ANON_LOGON = 0;";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>