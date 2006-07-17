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

/* $Id: upgrade-05-to-064.php,v 1.16 2006-07-17 13:25:39 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-05-to-064.php") {

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

$remove_tables = array('DEDUPE', 'GROUPS', 'GROUP_PERMS', 'GROUP_USERS',
                       'POST_ATTACHMENT_FILES', 'POST_ATTACHMENT_IDS',
                       'RSS_FEEDS', 'RSS_HISTORY', 'SEARCH_KEYWORDS',
                       'SEARCH_MATCH', 'SEARCH_POSTS', 'SEARCH_RESULTS',
                       'SESSIONS', 'VISITOR_LOG');

foreach ($remove_tables as $forum_table) {

    $sql = "DROP TABLE IF EXISTS {$forum_table}";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "CREATE TABLE POST_ATTACHMENT_FILES (";
$sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY (AID, ID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (FID, TID, PID)";
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
$sql.= "  PRIMARY KEY  (GID, FORUM, FID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_USERS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID, UID)";
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

$sql = "CREATE TABLE SEARCH_ENGINE_BOTS (";
$sql.= "  SID MEDIUMINT(8) NOT NULL AUTO_INCREMENT,";
$sql.= "  NAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  URL VARCHAR(255) DEFAULT NULL,";
$sql.= "  AGENT_MATCH VARCHAR(32) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (SID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$bots_array = array('ia_archiver'      => array('NAME' => 'Alexa', 'URL' => 'http://www.alexa.com/'),
                    'Ask Jeeves/Teoma' => array('NAME' => 'Ask.com', 'URL' => 'http://www.ask.com/'),
                    'Baiduspider'      => array('NAME' => 'Baidu', 'URL' => 'http://www.baidu.com/'),
                    'GameSpyHTTP'      => array('NAME' => 'GameSpy', 'URL' => 'http://www.gamespy.com/'),
                    'Gigabot'          => array('NAME' => 'Gigablast', 'URL' => 'http://www.gigablast.com/'),
                    'Googlebot'        => array('NAME' => 'Google', 'URL' => 'http://www.google.com/'),
                    'Googlebot-Image'  => array('NAME' => 'Google Images', 'URL' => 'http://images.google.com/'),
                    'Slurp/si'         => array('NAME' => 'Inktomi', 'URL' => 'http://searchmarketing.yahoo.com/'),
                    'msnbot'           => array('NAME' => 'MSN Search', 'URL' => 'http://search.msn.com/'),
                    'Scooter'          => array('NAME' => 'Altavista', 'URL' => 'http://www.altavista.com/'),
                    'Yahoo! Slurp;'    => array('NAME' => 'Yahoo!', 'URL' => 'http://www.yahoo.com/'),
                    'Yahoo-MMCrawler'  => array('NAME' => 'Yahoo!', 'URL' => 'http://www.yahoo.com/'));

foreach ($bots_array as $agent => $details) {

    $agent = addslashes($agent);
    $name  = addslashes($details['NAME']);
    $url   = addslashes($details['URL']);

    $sql = "INSERT INTO SEARCH_ENGINE_BOTS (NAME, URL, AGENT_MATCH) ";
    $sql.= "VALUES ('$name', '$url', '%$agent%')";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "CREATE TABLE SEARCH_RESULTS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  BY_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  RELEVANCE FLOAT UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  KEYWORDS TEXT NOT NULL,";
$sql.= "  PRIMARY KEY  (UID, FORUM, TID, PID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE VISITOR_LOG (";
$sql.= "  VID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  LAST_LOGON DATETIME DEFAULT NULL,";
$sql.= "  SID MEDIUMINT(8) DEFAULT NULL,";
$sql.= "  PRIMARY KEY (VID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SESSIONS (";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
$sql.= "  TIME DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (HASH)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD SHOW_THUMBS CHAR(2) DEFAULT '2' NOT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE POST_PAGE POST_PAGE VARCHAR(4) DEFAULT '0' NOT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD ENABLE_WIKI_WORDS CHAR(1) DEFAULT 'Y' NOT NULL";

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

$sql = "ALTER TABLE USER_PREFS DROP PM_AUTO_PRUNE_LENGTH";

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

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_TYPE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_AUTO_PRUNE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_FILE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_EXPORT_TYPE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_ATTACHMENTS CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_FILE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_STYLE CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_ATTACHMENTS";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_WORDFILTER CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_STYLE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    $sql = "ALTER TABLE USER ADD IPADDRESS VARCHAR(15)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE USER ADD REFERER VARCHAR(255)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE SESSIONS ADD REFERER VARCHAR(255)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Globalise the VISITOR_LOG table

    $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON) ";
    $sql.= "SELECT $forum_fid, UID, LAST_LOGON ";
    $sql.= "FROM {$forum_webtag}_VISITOR_LOG";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_VISITOR_LOG";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

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

    // Folder permissions:

    $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
    $sql.= "SELECT 0, $forum_fid, FID, PERM FROM ";
    $sql.= "{$forum_webtag}_GROUP_PERMS WHERE GID = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DELETE FROM {$forum_webtag}_GROUP_PERMS WHERE GID = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // User permissions:

    $sql = "SELECT GID, GROUP_NAME, GROUP_DESC, AUTO_GROUP FROM {$forum_webtag}_GROUPS";

    if ($result = @db_query($sql, $db_install)) {

        while (list($gid, $name, $desc, $auto_group) = db_fetch_array($result, DB_RESULT_NUM)) {

            $name = addslashes($name);
            $desc = addslashes($desc);

            $sql = "INSERT INTO GROUPS (FORUM, GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
            $sql.= "VALUES ($forum_fid, '$name', '$desc', $auto_group)";

            if ($result_group = @db_query($sql, $db_install)) {

                $new_group_gid = db_insert_id($db_install);

                $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
                $sql.= "SELECT $new_group_gid, $forum_fid, FID, PERM FROM ";
                $sql.= "{$forum_webtag}_GROUP_PERMS WHERE GID = $gid";

                if (!$result = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }

                $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
                $sql.= "SELECT $new_group_gid, UID FROM {$forum_webtag}_GROUP_USERS ";
                $sql.= "WHERE GID = $gid";

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

    $up_forum = USER_PERM_FORUM_TOOLS;
    $up_admin = USER_PERM_ADMIN_TOOLS;

    $up_all = (double) (USER_PERM_FORUM_TOOLS | USER_PERM_ADMIN_TOOLS | USER_PERM_LINKS_MODERATE);
    $up_all = (double) ($up_all | USER_PERM_FOLDER_MODERATE);

    $sql = "SELECT GROUP_PERMS.GID, GROUP_PERMS.PERM, GROUP_USERS.UID FROM {$forum_webtag}_GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN {$forum_webtag}_GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE ((GROUP_PERMS.PERM & $up_forum > 0) OR (GROUP_PERMS.PERM & $up_admin > 0)) AND FID = 0";

    if ($result = @db_query($sql, $db_install)) {

        while ($user_data = db_fetch_array($result)) {

            $sql = "INSERT INTO GROUPS (FORUM, AUTO_GROUP) ";
            $sql.= "VALUES (0, 1)";

            if ($result_group = @db_query($sql, $db_install)) {

                $new_group_gid = db_insert_id($db_install);

                $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
                $sql.= "VALUES ($new_group_gid, 0, 0, $up_all)";

                if (!$result = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }

                $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
                $sql.= "VALUES ($new_group_gid, {$user_data['UID']})";

                if (!$result = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }
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

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_GROUP_PERMS";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_GROUP_USERS";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Improved ban controls allow banning of IP, LOGON
    // NICKNAME, EMAIL and HTTP REFERER

    $sql = "CREATE TABLE {forum_webtag}_BANNED (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  BANTYPE TINYINT(4) NOT NULL DEFAULT '0',";
    $sql.= "  BANDATA VARCHAR(255) NOT NULL DEFAULT '',";
    $sql.= "  COMMENT VARCHAR(255) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (ID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Insert the old IP addresses from the BANNED_IP table if any

    $sql = "INSERT INTO {$forum_webtag}_BANNED (BANTYPE, BANDATA) ";
    $sql.= "SELECT 1, IP FROM {$forum_webtag}_BANNED_IP";

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
    $sql.= "MIMETYPE, HASH, DOWNLOADS) SELECT AID, UID, ";
    $sql.= "FILENAME, MIMETYPE, HASH, DOWNLOADS ";
    $sql.= "FROM {$forum_webtag}_POST_ATTACHMENT_FILES ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POST_ATTACHMENT_FILES";

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

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POST_ATTACHMENT_IDS";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE DEFAULT_THREAD_TRACK (";
    $sql.= "  TID MEDIUMINT(8) NOT NULL DEFAULT '0',";
    $sql.= "  NEW_TID MEDIUMINT(8) NOT NULL DEFAULT '0',";
    $sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  TRACK_TYPE TINYINT(4) NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (TID)";
    $sql.= ") TYPE=MYISAM";

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
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  TITLE VARCHAR(64) DEFAULT NULL,";
    $sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL,";
    $sql.= "  CREATED DATETIME DEFAULT NULL,";
    $sql.= "  MODIFIED DATETIME DEFAULT NULL,";
    $sql.= "  CLOSED DATETIME DEFAULT NULL,";
    $sql.= "  STICKY CHAR(1) DEFAULT NULL,";
    $sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL,";
    $sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL,";
    $sql.= "  VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (TID),";
    $sql.= "  KEY BY_UID (BY_UID)";
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
    $sql.= "  MOVED_TID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  MOVED_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  PRIMARY KEY (TID, PID),";
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
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  VOTE_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  PRIMARY KEY  (TID,UID,VOTE_ID,OPTION_ID)";
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

    $sql = "ALTER TABLE {$forum_webtag}_USER_PEER ADD PEER_NICKNAME VARCHAR(32)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD SHOW_THUMBS CHAR(2) DEFAULT '2' NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ENABLE_WIKI_WORDS CHAR(1) DEFAULT 'Y' NOT NULL";

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

    $sql = "ALTER TABLE {$forum_webtag}_USER_PROFILE ADD PRIVACY TINYINT(3) UNSIGNED NOT NULL DEFAULT '0';";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POLL_NEW";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_POLL_NEW (";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  QUESTION VARCHAR(64) DEFAULT NULL,";
    $sql.= "  CLOSES DATETIME DEFAULT NULL,";
    $sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',";
    $sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',";
    $sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',";
    $sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY (TID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO {$forum_webtag}_POLL_NEW SELECT POLL.TID, THREAD.TITLE, ";
    $sql.= "POLL.CLOSES, POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, ";
    $sql.= "POLL.VOTETYPE, POLL.OPTIONTYPE FROM {$forum_webtag}_POLL POLL ";
    $sql.= "LEFT JOIN {$forum_webtag}_THREAD THREAD ON (THREAD.TID = POLL.TID)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE {$forum_webtag}_POLL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new THREAD table

    $sql = "ALTER TABLE {$forum_webtag}_POLL_NEW RENAME {$forum_webtag}_POLL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // RSS Feed and Feed History tables

    $sql = "CREATE TABLE {$forum_webtag}_RSS_FEEDS (";
    $sql.= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  NAME VARCHAR(255) NOT NULL DEFAULT '',";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  URL VARCHAR(255) DEFAULT NULL,";
    $sql.= "  PREFIX VARCHAR(16) DEFAULT NULL,";
    $sql.= "  FREQUENCY MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  LAST_RUN DATETIME DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (RSSID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_RSS_HISTORY (";
    $sql.= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  LINK VARCHAR(255) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY RSSID (RSSID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_USER_TRACK (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  DDKEY DATETIME DEFAULT NULL,";
    $sql.= "  LAST_POST DATETIME DEFAULT NULL,";
    $sql.= "  LAST_SEARCH DATETIME DEFAULT NULL,";
    $sql.= "  POST_COUNT MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
    $sql.= "  USER_TIME_BEST DATETIME DEFAULT NULL, ";
    $sql.= "  USER_TIME_TOTAL DATETIME DEFAULT NULL, ";
    $sql.= "  PRIMARY KEY  (UID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "SHOW TABLES LIKE 'DICTIONARY'";

if (!$result = @db_query($sql, $db_install)) {

    $error_html.= "<h2>Could not locate any previous BeehiveForum installations!</h2>\n";
    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "CREATE TABLE DICTIONARY_NEW (";
    $sql.= "  WORD VARCHAR(64) NOT NULL DEFAULT '',";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  SOUND VARCHAR(64) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (WORD, UID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "INSERT IGNORE INTO DICTIONARY_NEW (WORD, SOUND, UID) ";
    $sql.= "SELECT LOWER(TRIM(WORD)), TRIM(SOUND), UID FROM DICTIONARY";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS DICTIONARY";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE DICTIONARY_NEW RENAME DICTIONARY";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>