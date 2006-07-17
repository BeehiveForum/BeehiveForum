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

/* $Id: upgrade-06x-to-064.php,v 1.29 2006-07-17 13:25:39 decoyduck Exp $ */

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

$global_tables = array('SEARCH_ENGINE_BOTS', 'SEARCH_KEYWORDS',
                       'SEARCH_MATCH', 'SEARCH_POSTS',
                       'SEARCH_RESULTS');

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

$forum_tables  = array('USER_TRACK', 'THREAD_STATS', 'THREAD_TRACK');

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

// Now we call install_get_table_conflicts for each forum we've found
// with our list of tables to create to make sure they're well
// and truely not going to conflict.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    if ($conflicting_tables = install_get_table_conflicts($forum_webtag, $forum_tables, $global_tables)) {

        $error_str = "<h2>Selected database contains tables which conflict with BeehiveForum.";
        $error_str.= "If this database contains an existing BeehiveForum installation please ";
        $error_str.= "check that you have selected the correct install / upgrade method.<h2>\n";

        $error_array[] = $error_str;

        $error_str = "<h2>If you continue to encounter errors you may want to consider enabling ";
        $error_str.= "the remove conflicts option at the bottom of the installer.</h2>\n";

        $error_array[] = $error_str;

        $error_str = "<h2>Conflicting tables:</h2>\n";
        $error_str.= "<ul><li>". implode("</li><li>", $conflicting_tables). "</li></ul>\n";

        $error_array[] = $error_str;

        $valid = false;
        return;
    }
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // New BANNED table format for new 0.6.4 admin_banned.php

    $banned_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));

    while (install_get_table_conflicts(false, false, array($banned_new))) {
        $banned_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
    }

    $sql = "CREATE TABLE {forum_webtag}_{$banned_new} (";
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

    // Populate the new banned table with any older ban data

    $ban_types = array('1' => 'IPADDRESS', '2' => 'LOGON',
                       '3' => 'NICKNAME',  '4' => 'EMAIL');

    foreach($ban_types as $ban_type => $old_column_name) {

        $sql = "INSERT INTO {forum_webtag}_{$banned_new} (BANTYPE, BANDATA) ";
        $sql.= "SELECT $ban_type, $old_column_name FROM {forum_webtag}_BANNED ";
        $sql.= "WHERE $old_column_name IS NOT NULL";

        $result = @db_query($sql, $db_install);
    }

    // Removed the old BANNED table

    $sql = "DROP TABLE {$forum_webtag}_BANNED";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new BANNED table
    
    $sql = "ALTER TABLE {$forum_webtag}_{$banned_new} RENAME {$forum_webtag}_BANNED";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New table to track thread view counts. This is in a
    // seperate table so that messages.php can update it quicker
    // than it can by hitting THREAD which causes locks on the
    // tables.

    $sql = "CREATE TABLE {$forum_webtag}_THREAD_STATS (";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (TID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

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

    // Table structure for USER_POLL_VOTES has changed to make
    // lookups use the TID primary key.

    $upv_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));

    while (install_get_table_conflicts(false, false, array($upv_new))) {
        $upv_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
    }

    $sql = "CREATE TABLE {$forum_webtag}_{$upv_new} (";
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
    
    $sql = "INSERT IGNORE INTO {$forum_webtag}_{$upv_new} (`TID`, `UID`, `OPTION_ID`, `TSTAMP`) ";
    $sql.= "SELECT `TID`, `UID`, `OPTION_ID`, `TSTAMP` FROM {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
    
    $sql = "DROP TABLE {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
    
    $sql = "ALTER TABLE {$forum_webtag}_{$upv_new} RENAME {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

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

    // User's can now give each other nicknames without them knowing about it.

    $sql = "ALTER TABLE {$forum_webtag}_USER_PEER ADD PEER_NICKNAME VARCHAR(32)";
    $result = @db_query($sql, $db_install);

    // Add columns for tracking where a post has been moved to.
    // We leave the old data as it is for future thread
    // and post copy feature.

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD MOVED_TID MEDIUMINT(8) UNSIGNED, ";
    $sql.= "ADD MOVED_PID MEDIUMINT(8) UNSIGNED";

    $result = @db_query($sql, $db_install);

    // Relationships have changed somewhat. Older Beehive versions kept the old
    // relationship data but this now display incorrectly in the Edit Relationships
    // page so we need to remove it.

    $sql = "DELETE FROM {$forum_webtag}_USER_PEER WHERE RELATIONSHIP = 0";
    $result = @db_query($sql, $db_install);

    // Data type was too small on LINKS_FOLDERS.

    $sql = "ALTER TABLE {$forum_webtag}_LINKS_FOLDERS CHANGE ";
    $sql.= "PARENT_FID PARENT_FID SMALLINT(5) UNSIGNED NULL";

    $result = @db_query($sql, $db_install);           

    // Indexes on USER_THREAD to make email notification queries run quicker

    install_remove_table_keys("{$forum_webtag}_USER_THREAD");

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD ADD INDEX TID (TID)";
    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD ADD INDEX LAST_READ (LAST_READ)";
    $result = @db_query($sql, $db_install);

    // Indexes on THREAD table to prevent thread list requiring creating of
    // temporary tables.

    install_remove_table_keys("{$forum_webtag}_THREAD");

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD INDEX BY_UID (BY_UID)";
    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD INDEX STICKY (STICKY, MODIFIED)";
    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD INDEX LENGTH (LENGTH)";
    $result = @db_query($sql, $db_install);
}

// Table structure for POST_ATTACHMENT_FILES has changed.

$paf_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));

while (install_get_table_conflicts(false, false, array($paf_new))) {
    $paf_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
}

$sql = "CREATE TABLE $paf_new (";
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

$sql = "INSERT INTO $paf_new (AID, UID, FILENAME, MIMETYPE, HASH, DOWNLOADS) ";
$sql.= "SELECT AID, UID, FILENAME, MIMETYPE, HASH, DOWNLOADS FROM ";
$sql.= "POST_ATTACHMENT_FILES";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE POST_ATTACHMENT_FILES";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE $paf_new RENAME POST_ATTACHMENT_FILES";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// SID column to track search engine bots against the visitor log.

$sql = "ALTER TABLE VISITOR_LOG ADD SID MEDIUMINT(8) UNSIGNED";
$result = @db_query($sql, $db_install);

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

// PM Export options - PM_EXPORT_TYPE stores export file type (HTML, XML, Plaintext)

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_TYPE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_AUTO_PRUNE";
$result = @db_query($sql, $db_install);

// PM Export options - PM_EXPORT_FILE stores file method (single file, multiple files)

$sql.= "ALTER TABLE USER_PREFS ADD PM_EXPORT_FILE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_EXPORT_TYPE";
$result = @db_query($sql, $db_install);

// PM Export options - PM_EXPORT_ATTACHMENTS sets exporting of attachments

$sql.= "ALTER TABLE USER_PREFS ADD PM_EXPORT_ATTACHMENTS CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_FILE";
$result = @db_query($sql, $db_install);

// PM Export options - PM_EXPORT_STYLE sets exporting of style sheet.

$sql.= "ALTER TABLE USER_PREFS ADD PM_EXPORT_STYLE CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_ATTACHMENTS";
$result = @db_query($sql, $db_install);

// PM Export options - PM_EXPORT_WORDFILTER sets application of word filter.

$sql.= "ALTER TABLE USER_PREFS ADD PM_EXPORT_WORDFILTER CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_STYLE";
$result = @db_query($sql, $db_install);

// The dictionary has been optimised a bit by making sure the
// data held in the table is lower-case.

$sql = "SHOW TABLES LIKE 'DICTIONARY'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Dictionary has been updated to be less resource intensive
// and more precise by moving a lot of the processing to PHP
// and away from MySQL.

if (db_num_rows($result) > 0) {

    // Generate a unique random table name and keep
    // doing so until we have one that doesn't exist.

    $dictionary_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));

    while (install_get_table_conflicts(false, false, array($dictionary_new))) {
        $dictionary_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
    }

    // Create our new table.
    
    $sql = "CREATE TABLE $dictionary_new (";
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

    // Move the data from the old DICTIONARY table
    // into our new one and remove duplicates and
    // lower-case and trim the words and sounds.

    $sql = "INSERT IGNORE INTO $dictionary_new (WORD, SOUND, UID) ";
    $sql.= "SELECT LOWER(TRIM(WORD)), TRIM(SOUND), UID FROM DICTIONARY";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Remove the old table.

    $sql = "DROP TABLE IF EXISTS DICTIONARY";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new table to DICTIONARY.

    $sql = "ALTER TABLE $dictionary_new RENAME DICTIONARY";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>