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

/* $Id: upgrade-06x-to-064.php,v 1.15 2006-06-21 22:41:33 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-06x-to-064.php") {

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

        while ($row = @db_fetch_array($result)) {

            $forum_webtag_array[$row['FID']] = $row['WEBTAG'];
        }

    }else {

        $error_html.= "<h2>Could not locate any previous BeehiveForum installations!</h2>\n";
        $valid = false;
        return;
    }
}

// Check that we have no global tables which conflict
// with those we're about to create or remove.

$global_tables = array('DICTIONARY_NEW', 'SEARCH_ENGINE_BOTS', 'SEARCH_KEYWORDS',
                       'SEARCH_MATCH', 'SEARCH_POSTS', 'SEARCH_RESULTS');

if (isset($remove_conflicts) && $remove_conflicts === true) {

    foreach ($global_tables as $global_table) {

        $sql = "DROP TABLE IF EXISTS $global_table";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
}

// Check that we have no per-forum tables which conflict
// with those we're about to create.

$forum_tables  = array('USER_TRACK', 'THREAD_TRACK');

if (isset($remove_conflicts) && $remove_conflicts === true) {

    foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

        foreach ($forum_tables as $forum_table) {

            $sql = "DROP TABLE IF EXISTS {$forum_webtag}_{$forum_table}";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }

    }
}

// Now we call install_check_tables for each forum we've found
// with our list of tables to create to make sure they're well
// and truely not going to conflict.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    if (!install_check_tables($forum_webtag, $forum_tables, $global_tables)) {

        $error_str = "<h2>Selected database contains tables which conflict with BeehiveForum.";
        $error_str.= "If this database contains an existing BeehiveForum installation please ";
        $error_str.= "check that you have selected the correct install / upgrade method.<h2>\n";

        $error_array[] = $error_str;

        $error_str = "<h2>If you continue to encounter errors you may want to consider enabling ";
        $error_str.= "the remove conflicts option at the bottom of the installer.</h2>\n";

        $error_array[] = $error_str;

        $valid = false;
        return;
    }
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // Counter-change to older 0.6 builds. USER_TRACK is now
    // a per-forum table so we can use it to store user's
    // post counts for each forum they visit.
  
    $sql = "CREATE TABLE {$forum_webtag}_USER_TRACK (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  DDKEY DATETIME DEFAULT NULL,";
    $sql.= "  LAST_POST DATETIME DEFAULT NULL,";
    $sql.= "  LAST_SEARCH DATETIME DEFAULT NULL,";
    $sql.= "  POST_COUNT MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  USER_TIME_BEST DATETIME DEFAULT NULL, ";
    $sql.= "  USER_TIME_TOTAL DATETIME DEFAULT NULL, ";
    $sql.= "  PRIMARY KEY (UID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Table to store tracking information for thread splits
    // and merges and post moves etc.

    $sql = "CREATE TABLE {$forum_webtag}_THREAD_TRACK (";
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

    // Adding a new column to the THREAD table to track
    // thread view count.

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'";
    $result = @db_query($sql, $db_install);

    // Add columns for tracking where a post has been moved to.
    // We leave the old data as it is for future thread
    // and post copy feature.

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD MOVED_TID MEDIUMINT(8) UNSIGNED, ";
    $sql.= "ADD MOVED_PID MEDIUMINT(8) UNSIGNED";

    $result = @db_query($sql, $db_install);

    // Index the new columns so we don't drag our table to a halt when seeking
    // for the data.

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD INDEX (MOVED_TID, MOVED_PID)";
    $result = @db_query($sql, $db_install);

    // User's can now give each other nicknames without them knowing about it.

    $sql = "ALTER TABLE {$forum_webtag}_USER_PEER ADD PEER_NICKNAME VARCHAR(32)";
    $result = @db_query($sql, $db_install);

    // Relationships have changed somewhat. Older Beehive versions kept the old
    // relationship data but this now display incorrectly in the Edit Relationships
    // page so we need to remove it.

    $sql = "DELETE FROM {$forum_webtag}_USER_PEER WHERE RELATIONSHIP = 0";
    $result = @db_query($sql, $db_install);

    // Some indexes for our tables which we were slowing things down
    // rather a lot.

    $sql = "ALTER TABLE {$forum_webtag}_BANNED ADD INDEX (IPADDRESS), ";
    $sql.= "ADD INDEX (LOGON), ADD INDEX (NICKNAME), ADD INDEX (EMAIL)";

    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_POST DROP INDEX TID";
    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_USER_POLL_VOTES ADD INDEX UID (UID)";
    $result = @db_query($sql, $db_install);

    // Data type was too small on LINKS_FOLDERS.

    $sql = "ALTER TABLE {$forum_webtag}_LINKS_FOLDERS CHANGE ";
    $sql.= "PARENT_FID PARENT_FID SMALLINT(5) UNSIGNED NULL";

    $result = @db_query($sql, $db_install);
}

// New table for our search engine bot data. This is designed
// to be added to later.

$sql = "CREATE TABLE SEARCH_ENGINE_BOTS (";
$sql.= "  SID MEDIUMINT(8) NOT NULL AUTO_INCREMENT,";
$sql.= "  NAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  URL VARCHAR(255) DEFAULT NULL,";
$sql.= "  AGENT_MATCH VARCHAR(32) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (SID),";
$sql.= "  FULLTEXT KEY AGENT_MATCH (AGENT_MATCH)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// A not too comprehensive list of search engine bots and patterns
// to match their USER_AGENT strings as taken from the appropriate
// wikipedia page.

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

// Add the SID column to our VISITOR_LOG table so we can show
// the search engine bots in the visitor log.

$sql = "ALTER TABLE VISITOR_LOG ADD SID MEDIUMINT(8)";
$result = @db_query($sql, $db_install);

// And an index for it for our join against the SEARCH_ENGINE_BOTS table.

$sql = "ALTER TABLE VISITOR_LOG ADD INDEX (SID) ";
$result = @db_query($sql, $db_install);

// Beehive is back to use MySQL FULLTEXT searching (hooray) but we
// speed up the search by piling the results found into a table
// and letting the user browse from there.

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
$sql.= "  PRIMARY KEY  (UID,FORUM,TID,PID),";
$sql.= "  KEY CREATED (CREATED)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_TYPE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_AUTO_PRUNE, ";
$sql.= "ADD PM_EXPORT_FILE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_EXPORT_TYPE, ";
$sql.= "ADD PM_EXPORT_ATTACHMENTS CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_FILE, ";
$sql.= "ADD PM_EXPORT_STYLE CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_ATTACHMENTS, ";
$sql.= "ADD PM_EXPORT_WORDFILTER CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_STYLE";

$result = @db_query($sql, $db_install);

// The dictionary has been optimised a bit by making sure the
// data held in the table is lower-case.

$sql = "SHOW TABLES LIKE 'DICTIONARY'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "CREATE TABLE DICTIONARY_NEW (";
    $sql.= "  WORD VARCHAR(64) NOT NULL DEFAULT '',";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  SOUND VARCHAR(64) NOT NULL DEFAULT '',";
    $sql.= "  PRIMARY KEY  (WORD, UID),";
    $sql.= "  KEY SOUND (SOUND)";
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