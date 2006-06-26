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

/* $Id: upgrade-06x-to-064.php,v 1.17 2006-06-26 11:04:49 decoyduck Exp $ */

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

    // Loads of indexes to add. This is the whole list of indexes that Beehive
    // uses. Some of them will exist from previous Beehive versions so
    // we skip on failing on an error and continue on.

    $forum_table_keys = array('ADMIN_LOG'       => array('UID (UID)', 'CREATED (CREATED)', 'ACTION (ACTION)'),
                              'BANNED'          => array('LOGON (LOGON)', 'NICKNAME (NICKNAME)', 'EMAIL (EMAIL)', 'IPADDRESS (IPADDRESS)'),
                              'FOLDER'          => array('ALLOWED_TYPES (ALLOWED_TYPES)', 'POSITION (POSITION)', 'TITLE (TITLE)'),
                              'FORUM_LINKS'     => array('POS (POS)'),
                              'LINKS'           => array('FID (FID)', 'VISIBLE (VISIBLE)', 'TITLE (TITLE)', 'CREATED (CREATED)'),
                              'LINKS_COMMENT'   => array('LID (LID)'),
                              'LINKS_FOLDERS'   => array('PARENT_FID (PARENT_FID)', 'NAME (NAME)'),
                              'LINKS_VOTE'      => array('RATING (RATING)'),
                              'POLL'            => array('VOTETYPE (VOTETYPE)'),
                              'POST'            => array('TO_UID (TO_UID)', 'FROM_UID (FROM_UID)', 'IPADDRESS (IPADDRESS)', 'CREATED (CREATED)', 'MOVED_TID (MOVED_TID,MOVED_PID)', 'REPLY_TO_PID (REPLY_TO_PID)', 'EDITED_BY (EDITED_BY)', 'VIEWED (VIEWED)'),
                              'POST_CONTENT'    => array('FULLTEXT KEY CONTENT (CONTENT)'),
                              'PROFILE_ITEM'    => array('PSID (PSID)', 'POSITION (POSITION)'),
                              'PROFILE_SECTION' => array('POSITION (POSITION)'),
                              'RSS_FEEDS'       => array('FREQUENCY (FREQUENCY)', 'LAST_RUN (LAST_RUN)'),
                              'RSS_HISTORY'     => array('RSSID (RSSID)', 'LINK (LINK)'),
                              'THREAD'          => array('FID (FID)', 'BY_UID (BY_UID)', 'LENGTH (LENGTH)', 'STICKY (STICKY)', 'MODIFIED (MODIFIED)'),
                              'THREAD_TRACK'    => array('NEW_TID (NEW_TID)'),
                              'USER_FOLDER'     => array('INTEREST (INTEREST)'),
                              'USER_PEER'       => array('RELATIONSHIP (RELATIONSHIP)'),
                              'USER_POLL_VOTES' => array('UID (UID)', 'TID (TID)', 'OPTION_ID (OPTION_ID)'),
                              'USER_PREFS'      => array('DOB_DISPLAY (DOB_DISPLAY)', 'ANON_LOGON (ANON_LOGON)'),
                              'USER_THREAD'     => array('LAST_READ (LAST_READ)', 'INTEREST (INTEREST)'));

    foreach ($forum_table_keys as $forum_table) {

        foreach($forum_table as $column_name) {

            $sql = "ALTER TABLE {$forum_webtag}_{$forum_table} ADD INDEX {$column_name} ({$column_name})";
            $result = @db_query($sql, $db_install);
        }
    }            
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

// Loads more indexes to add, this time to global tables.
// Again, this is the whole list of indexes that Beehive
// uses. Some of them will exist from previous Beehive
// versions so we skip on failing.

$global_table_keys = array('DICTIONARY'            => array('SOUND (SOUND)'),
                           'FORUM_SETTINGS'        => array('SVALUE (SVALUE)'),
                           'FORUMS'                => array('WEBTAG (WEBTAG)', 'ACCESS_LEVEL (ACCESS_LEVEL)'),
                           'GROUP_PERMS'           => array('PERM (PERM)'),
                           'GROUP_USERS'           => array('UID (UID,GID)'),
                           'GROUPS'                => array('FORUM (FORUM)', 'AUTO_GROUP (AUTO_GROUP)'),
                           'PM'                    => array('TO_UID (TO_UID)', 'TYPE (TYPE)', 'FROM_UID (FROM_UID)', 'CREATED (CREATED)', 'NOTIFIED (NOTIFIED)'),
                           'PM_ATTACHMENT_IDS'     => array('AID (AID)'),
                           'POST_ATTACHMENT_FILES' => array('AID (AID)', 'HASH (HASH)', 'FILENAME (FILENAME)', 'UID (UID)'),
                           'POST_ATTACHMENT_IDS'   => array('AID (AID)'),
                           'SEARCH_ENGINE_BOTS'    => array('AGENT_MATCH (AGENT_MATCH)'),
                           'SEARCH_RESULTS'        => array('CREATED (CREATED)'),
                           'SESSIONS'              => array('UID (UID)', 'IPADDRESS (IPADDRESS)', 'TIME (TIME)', 'FID (FID)'),
                           'USER'                  => array('LOGON (LOGON)', 'PASSWD (PASSWD)', 'NICKNAME (NICKNAME)', 'EMAIL (EMAIL)'),
                           'USER_FORUM'            => array('ALLOWED (ALLOWED)'),
                           'USER_PREFS'            => array('DOB (DOB)', 'DOB_DISPLAY (DOB_DISPLAY)', 'ANON_LOGON (ANON_LOGON)'),
                           'VISITOR_LOG'           => array('UID (UID)', 'SID (SID)', 'LAST_LOGON (LAST_LOGON)', 'FORUM (FORUM)'));

foreach ($global_table_keys as $forum_table) {

    foreach($forum_table as $column_name) {

        $sql = "ALTER TABLE {$forum_webtag}_{$forum_table} ADD INDEX {$column_name} ({$column_name})";
        $result = @db_query($sql, $db_install);
    }
}

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