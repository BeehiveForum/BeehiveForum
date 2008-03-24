<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: upgrade-07x-to-083.php,v 1.4 2008-03-24 23:32:21 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-07x-to-083.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

@set_time_limit(0);

$forum_webtag_array = array();

// This script upgrades all forums it finds regardless of the
// WEBTAG entered in the install form. This is imperative that
// this happens because otherwise if you later try to upgrade
// a second forum you will run into problems

$sql = "SHOW TABLES LIKE 'FORUMS'";

if (!$result = @db_query($sql, $db_install)) {

    $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "SELECT FID, WEBTAG FROM FORUMS";

    if ($result = @db_query($sql, $db_install)) {

        while ($forum_data = @db_fetch_array($result)) {

            $forum_webtag_array[$forum_data['FID']] = $forum_data['WEBTAG'];
        }

    }else {

        $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
        $valid = false;
        return;
    }
}

// Remove deprecated tables.

$remove_tables = array();

foreach ($remove_tables as $remove_table) {

    $sql = "DROP TABLE IF EXISTS $remove_table";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Check that we have no global tables which conflict
// with those we're about to create or remove.

$global_tables = array('USER_HISTORY', 'PM_SEARCH_RESULTS', 'TIMEZONES');

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

$forum_tables  = array('WORD_FILTER');

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

        $error_str = "<h2>Selected database contains tables which conflict with Beehive Forum. ";
        $error_str.= "If this database contains an existing Beehive Forum installation please ";
        $error_str.= "check that you have selected the correct install / upgrade method.</h2>\n";

        $error_array[] = $error_str;

        $error_str = "<h2>If you continue to encounter errors you may want to consider enabling ";
        $error_str.= "the remove conflicts option at the bottom of the installer.</h2>\n";

        $error_array[] = $error_str;

        $error_str = "<h2>Conflicting tables</h2>\n";
        $error_str.= "<div id=\"conflicting_tables\" class=\"install_table_list\">\n";
        $error_str.= sprintf("<ul><li>%s</li></ul>\n", implode("</li><li>", $conflicting_tables));
        $error_str.= "</div>\n";

        $error_array[] = $error_str;

        $valid = false;
        return;
    }
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // New column for "In Reply to" link in PMs.

    $sql = "ALTER TABLE PM ADD REPLY_TO_MID MEDIUMINT(8) NOT NULL DEFAULT '0' AFTER MID";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Remove the index on SVALUE before we convert it to TEXT

    $sql = "ALTER TABLE FORUM_SETTINGS DROP INDEX SVALUE";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Convert the SVALUE column to TEXT. This allows it to become big enough
    // to hold things like the forum rules message.

    $sql = "ALTER TABLE FORUM_SETTINGS CHANGE SVALUE SVALUE TEXT NOT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Profile Items have changed to make them easier to understand

    $sql = "ALTER TABLE {$forum_webtag}_PROFILE_ITEM ADD OPTIONS TEXT NOT NULL AFTER TYPE";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Fix the invalid primary key on THREAD_TRACK table which
    // causes an error when splitting a thread that has been split once already.

    $sql = "ALTER TABLE {$forum_webtag}_THREAD_TRACK DROP PRIMARY KEY, ";
    $sql.= "ADD PRIMARY KEY (TID, NEW_TID)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Performance boost for admin_user.php when looking up
    // a user's last few IP addresses to match against other users.

    $sql = "ALTER TABLE {$forum_webtag}_POST DROP INDEX IPADDRESS, ";
    $sql.= "ADD INDEX IPADDRESS (IPADDRESS, FROM_UID)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New User preference for mouseover spoiler reveal

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "USE_MOVER_SPOILER CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New User preference for light mode spoiler support

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "USE_LIGHT_MODE_SPOILER CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New User preference for image resize and page reflow.

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "USE_OVERFLOW_RESIZE CHAR(1) NOT NULL DEFAULT 'Y'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Fixed a bug where the anon logon wasn't working.

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS CHANGE ";
    $sql.= "ANON_LOGON ANON_LOGON CHAR(1) NOT NULL DEFAULT '0'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE {$forum_webtag}_USER_PREFS SET ANON_LOGON = 0 ";
    $sql.= "WHERE ANON_LOGON = 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE {$forum_webtag}_USER_PREFS SET ANON_LOGON = 1 ";
    $sql.= "WHERE ANON_LOGON = 'Y'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "PIC_AID CHAR(32) NOT NULL DEFAULT ''";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "AVATAR_URL VARCHAR(255) NOT NULL DEFAULT ''";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "AVATAR_AID CHAR(32) NOT NULL DEFAULT ''";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Index on APPROVED column to help speed up display of
    // Post Approval Queue in Admin.

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD INDEX APPROVED (APPROVED)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New USER_POLL_VOTES table format to allow guests to vote in polls

    $upv_new = preg_replace("/[^a-z]/", "", md5(uniqid(mt_rand())));

    while (install_get_table_conflicts(false, false, array($upv_new))) {
        $upv_new = preg_replace("/[^a-z]/", "", md5(uniqid(mt_rand())));
    }

    $sql = "CREATE TABLE {$forum_webtag}_{$upv_new} (";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  VOTE_ID MEDIUMINT(8) NOT NULL AUTO_INCREMENT,";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
    $sql.= "  PRIMARY KEY (TID, VOTE_ID),";
    $sql.= "  KEY UID (UID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Copy the existing data into the new table.

    $sql = "INSERT IGNORE INTO {$forum_webtag}_{$upv_new} (TID, UID, OPTION_ID, TSTAMP) ";
    $sql.= "SELECT TID, UID, OPTION_ID, TSTAMP FROM {$forum_webtag}_USER_POLL_VOTES ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Removed the old USER_POLL_VOTES table

    $sql = "DROP TABLE {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new USER_POLL_VOTES table

    $sql = "ALTER TABLE {$forum_webtag}_{$upv_new} RENAME {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Flag to allow guest votes configurable at poll level

    $sql = "ALTER TABLE {$forum_webtag}_POLL ADD ALLOWGUESTS TINYINT(1) NOT NULL DEFAULT '0'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // The Forum Links dropdown caption (top link) has moved
    // to the FORUM_SETTINGS table to allow for improved
    // functionality to the Admin section.

    $sql = "SELECT LID, TITLE FROM {$forum_webtag}_FORUM_LINKS ";
    $sql.= "ORDER BY POS ASC, LID ASC";

    if ($result = @db_query($sql, $db_install)) {

        if (db_num_rows($result) > 0) {

            list($lid, $forum_links_top_link) = db_fetch_array($result, DB_RESULT_NUM);

            // Save the existing forum link caption to the FORUM_SETTINGS table

            $forum_links_top_link = db_escape_string($forum_links_top_link);

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql.= "VALUES ('$forum_fid', 'forum_links_top_link', ";
            $sql.= "'$forum_links_top_link')";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            // Delete the old record from the FORUM_LINKS table.

            $lid = db_escape_string($lid);

            $sql = "DELETE FROM {$forum_webtag}_FORUM_LINKS ";
            $sql.= "WHERE LID = '$lid'";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }
    }

    // Index on THREAD.TITLE for searches

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD INDEX TITLE (TITLE)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New thread title prefix for folders

    $sql = "ALTER TABLE {$forum_webtag}_FOLDER ADD PREFIX VARCHAR(16) ";
    $sql.= "DEFAULT NULL AFTER DESCRIPTION";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Previous versions of Beehive ran folder titles and descriptions through
    // htmlentities() which causes problems when international characters are
    // used and the encoded string becomes too long for the column in MySQL.

    $sql = "SELECT FID, TITLE, DESCRIPTION FROM {$forum_webtag}_FOLDER";

    if ($result = @db_query($sql, $db_install)) {

        while ($folder_data = db_fetch_array($result)) {

            $fid = $folder_data['FID'];

            if (!isset($folder_data['TITLE'])) $folder_data['TITLE'] = "";
            if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = "";

            $new_title = db_escape_string(_htmlentities_decode($folder_data['TITLE']));
            $new_description = db_escape_string(_htmlentities_decode($folder_data['DESCRIPTION']));

            $sql = "UPDATE {$forum_webtag}_FOLDER SET TITLE = '$new_title', ";
            $sql.= "DESCRIPTION = '$new_description' WHERE FID = '$fid'";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }

    }else {

        $valid = false;
        return;
    }

    // Same problem with Thread Titles.

    $sql = "SELECT TID, TITLE FROM {$forum_webtag}_THREAD";

    if ($result = @db_query($sql, $db_install)) {

        while ($thread_data = db_fetch_array($result)) {

            $tid = $thread_data['TID'];

            if (!isset($thread_data['TITLE'])) $thread_data['TITLE'] = "";

            $new_title = db_escape_string(_htmlentities_decode($thread_data['TITLE']));

            $sql = "UPDATE {$forum_webtag}_THREAD SET TITLE = '$new_title' WHERE TID = '$tid'";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }

    }else {

        $valid = false;
        return;
    }

    // New Word Filter table format to allow switching on
    // and off individual filters.

    $sql = "CREATE TABLE {$forum_webtag}_WORD_FILTER (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  FILTER_NAME VARCHAR(255) NOT NULL,";
    $sql.= "  MATCH_TEXT TEXT NOT NULL,";
    $sql.= "  REPLACE_TEXT TEXT NOT NULL,";
    $sql.= "  FILTER_TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  FILTER_ENABLED TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  PRIMARY KEY  (UID, FID)";
    $sql.= ") TYPE = MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Copy the existing entries into the new table.

    $sql = "INSERT INTO {$forum_webtag}_WORD_FILTER (UID, FILTER_NAME, MATCH_TEXT, ";
    $sql.= "REPLACE_TEXT, FILTER_TYPE, FILTER_ENABLED) SELECT UID, '', MATCH_TEXT, ";
    $sql.= "REPLACE_TEXT, FILTER_OPTION, 1 FROM {$forum_webtag}_FILTER_LIST";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Update the new table to name all the entries with
    // the name 'Filter #num'

    $sql = "UPDATE {$forum_webtag}_WORD_FILTER SET FILTER_NAME = CONCAT('Filter #', FID);";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Remove the old FILTER_LIST table

    $sql = "DROP TABLE {$forum_webtag}_FILTER_LIST";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Sort the new table to order by UID.

    $sql = "ALTER TABLE {$forum_webtag}_WORD_FILTER ORDER BY UID";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Having the SESSIONS table as type HEAP is known to cause problems
// where the MySQL server is set up to automatically restart after
// a number of queries or it has problems staying up so we'll
// convert it back to MYISAM.

$sql = "ALTER TABLE SESSIONS TYPE = MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// User approval is possible in Beehive as of 0.8.

$sql = "ALTER TABLE USER ADD APPROVED DATETIME NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// If we got this far we managed to complete the per-forum table
// upgrades without incident so we can now do the global tables.

// New USER_HISTORY table for tracking user logon, nickname
// and email address changes

$sql = "CREATE TABLE USER_HISTORY (";
$sql.= "  HID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  LOGON VARCHAR(32) NULL,";
$sql.= "  NICKNAME VARCHAR(32) NULL,";
$sql.= "  EMAIL VARCHAR(80) NULL,";
$sql.= "  MODIFIED DATETIME DEFAULT NULL,";
$sql.= "  PRIMARY KEY (HID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// As of Beehive Forum 0.8 you can keep your per-forum tables
// and global tables in seperate databases. In order to track
// the database names for each forum we need to store that in
// FORUMS table.

$sql = "ALTER TABLE FORUMS ADD DATABASE_NAME VARCHAR(255) NOT NULL ";
$sql.= "AFTER WEBTAG";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Set all the current forums to use the database name defined
// in the config.inc.php / install form for this installation.

$sql = "UPDATE FORUMS SET DATABASE_NAME = '$db_database'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// You can also specify a user when creating a forum that is
// automatically given admin access on that forum

$sql = "ALTER TABLE FORUMS ADD OWNER_UID MEDIUMINT(8) UNSIGNED NOT NULL ";
$sql.= "AFTER WEBTAG";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// New User preference for mouseover spoiler reveal

$sql = "ALTER TABLE USER_PREFS ADD USE_MOVER_SPOILER ";
$sql.= "CHAR(1) NOT NULL DEFAULT 'N'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// New User preference for light mode spoiler support

$sql = "ALTER TABLE USER_PREFS ADD USE_LIGHT_MODE_SPOILER ";
$sql.= "CHAR(1) NOT NULL DEFAULT 'N'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// New User preference for image resize and page reflow.

$sql = "ALTER TABLE USER_PREFS ADD USE_OVERFLOW_RESIZE ";
$sql.= "CHAR(1) NOT NULL DEFAULT 'Y'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Fixed a bug where the anon logon wasn't working.

$sql = "ALTER TABLE USER_PREFS CHANGE  ANON_LOGON ";
$sql.= "ANON_LOGON CHAR(1) NOT NULL DEFAULT '0'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "UPDATE USER_PREFS SET ANON_LOGON = 0 ";
$sql.= "WHERE ANON_LOGON = 'N'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "UPDATE USER_PREFS SET ANON_LOGON = 1 ";
$sql.= "WHERE ANON_LOGON = 'Y'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PIC_AID CHAR(32) NOT NULL DEFAULT ''";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD AVATAR_URL VARCHAR(255) NOT NULL DEFAULT ''";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD AVATAR_AID CHAR(32) NOT NULL DEFAULT ''";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Referer tracking for visitors.

$sql = "ALTER TABLE VISITOR_LOG ADD REFERER VARCHAR(255) DEFAULT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// IP Address tracking for Visitor Log

$sql = " ALTER TABLE VISITOR_LOG ADD IPADDRESS VARCHAR(15) DEFAULT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Reindex POST_ATTACHMENT_IDS table to make queries quicker

install_remove_table_keys("POST_ATTACHMENT_IDS");

$sql = "ALTER TABLE POST_ATTACHMENT_IDS ADD INDEX AID (AID)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// New more reliable functionality for PM sent items.

$sql = "ALTER TABLE PM ADD SMID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Table to cache the PM search results in.

$sql = "CREATE TABLE PM_SEARCH_RESULTS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL,";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL,";
$sql.= "  RECIPIENTS VARCHAR(255) NOT NULL,";
$sql.= "  CREATED DATETIME NOT NULL,";
$sql.= "  PRIMARY KEY (UID, MID)";
$sql.= ") TYPE = MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Reindex PM_ATTACHMENT_IDS table to make queries quicker

install_remove_table_keys("PM_ATTACHMENT_IDS");

$sql = "ALTER TABLE PM_ATTACHMENT_IDS ADD INDEX AID (AID)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Added ability to save draft messages requires that we add
// another column where we store the recipient field.

install_remove_table_keys("PM");

$sql = "ALTER TABLE PM ADD RECIPIENTS VARCHAR(255) NOT NULL DEFAULT '' AFTER SUBJECT";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// You can now search PMs for messages using fulltext searching.

$sql = "ALTER TABLE PM ADD FULLTEXT (SUBJECT)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Fulltext index for PM message body

install_remove_table_keys("PM_CONTENT");

$sql = "ALTER TABLE PM_CONTENT ADD FULLTEXT (CONTENT)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Moved the LAST_LOGON from VISITOR_LOG to LAST_VISIT in USER_FORUM
// so that clearing the visitor log doesn't clear out the user's last
// visited forums.

$sql = "ALTER TABLE USER_FORUM ADD LAST_VISIT DATETIME NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Move the existing data across to the new column.

$sql = "SELECT UID, LAST_LOGON FROM VISITOR_LOG WHERE UID > 0";

if ($result = @db_query($sql, $db_install)) {

    while (list($uid, $last_logon) = db_fetch_array($result, DB_RESULT_NUM)) {

        $sql = "UPDATE USER_FORUM SET LAST_VISIT = '$last_logon' ";
        $sql.= "WHERE UID = '$uid'";

        if ($result_update = @db_query($sql, $db_install)) {

            if (db_affected_rows($db_install) < 1) {

                $sql = "INSERT IGNORE INTO USER_FORUM (UID, LAST_VISIT) ";
                $sql.= "VALUES ('$uid', '$last_logon')";

                if (!$result_insert = @db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }
            }
        }
    }

}else {

    $valid = false;
    return;
}

// Indexes on USER.LOGON and USER.NICKNAME for searches.

install_remove_table_keys("USER");

$sql = "ALTER TABLE USER ADD INDEX LOGON (LOGON)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER ADD INDEX NICKNAME (NICKNAME)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Indexes on SEB.NAME and SEB.AGENT_MATCH for searches.

install_remove_table_keys("SEARCH_ENGINE_BOTS");

$sql = "ALTER TABLE SEARCH_ENGINE_BOTS ADD INDEX NAME (NAME)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_ENGINE_BOTS ADD INDEX AGENT_MATCH (AGENT_MATCH)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// New column to allow sorting results by thread length.

$sql = "ALTER TABLE SEARCH_RESULTS ADD LENGTH MEDIUMINT(8) ";
$sql.= "UNSIGNED NOT NULL AFTER CREATED";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// New TIMEZONES table which provides Beehive with full
// international DST support.

$sql = "CREATE TABLE TIMEZONES (";
$sql.= "  TZID INT(11) NOT NULL DEFAULT '0',";
$sql.= "  GMT_OFFSET DOUBLE DEFAULT '0',";
$sql.= "  DST_OFFSET DOUBLE DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (TZID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Change the USER_PREF.TIMEZONE data type to an integer
// as we no longer actually store the offset there rather
// the TZID of the entry in the TIMEZONES table.

$sql = "ALTER TABLE USER_PREFS CHANGE TIMEZONE ";
$sql.= "TIMEZONE INT(11) NOT NULL DEFAULT '27'";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Timezones and their DST settings (TZID => array (GMT_OFFSET, DST_OFFSET));

$timezones_array = array(1  => array(-12, 0),  2  => array(-11, 0),  3  => array(-10, 0),
                         4  => array(-9, 1),   5  => array(-8, 1),   6  => array(-7, 0),
                         7  => array(-7, 1),   8  => array(-7, 1),   9  => array(-6, 0),
                         10 => array(-6, 1),   11 => array(-6, 1),   12 => array(-6, 0),
                         13 => array(-5, 0),   14 => array(-5, 1),   15 => array(-5, 0),
                         16 => array(-4, 1),   17 => array(-4, 0),   18 => array(-4, 1),
                         19 => array(-3.5, 1), 20 => array(-3, 1),   21 => array(-3, 0),
                         22 => array(-3, 1),   23 => array(-2, 1),   24 => array(-1, 1),
                         25 => array(-1, 0),   26 => array(0, 0),    27 => array(0, 1),
                         28 => array(1, 1),    29 => array(1, 1),    30 => array(1, 1),
                         31 => array(1, 1),    32 => array(1, 0),    33 => array(2, 1),
                         34 => array(2, 1),    35 => array(2, 1),    36 => array(2, 0),
                         37 => array(2, 1),    38 => array(2, 0),    39 => array(3, 1),
                         40 => array(3, 0),    41 => array(3, 1),    42 => array(3, 0),
                         43 => array(3.5, 1),  44 => array(4, 0),    45 => array(4, 1),
                         46 => array(4.5, 0),  47 => array(5, 1),    48 => array(5, 0),
                         49 => array(5.5, 0),  50 => array(5.75, 0), 51 => array(6, 1),
                         52 => array(6, 0),    53 => array(6, 0),    54 => array(6.5, 0),
                         55 => array(7, 0),    56 => array(7, 1),    57 => array(8, 0),
                         58 => array(8, 1),    59 => array(8, 0),    60 => array(8, 0),
                         61 => array(8, 0),    62 => array(9, 0),    63 => array(9, 0),
                         64 => array(9, 1),    65 => array(9.5, 1),  66 => array(9.5, 0),
                         67 => array(10, 0),   68 => array(10, 1),   69 => array(10, 0),
                         70 => array(10, 1),   71 => array(10, 1),   72 => array(11, 0),
                         73 => array(12, 1),   74 => array(12, 0),   75 => array(13, 0));

// Insert the above data into the TIMEZONES table while also
// updating the old data in the USER_PREFS table to use the
// new TZID numbers.

foreach ($timezones_array as $tzid => $tz_data) {

    if (!is_numeric($tzid)) return false;

    if (!isset($tz_data[0]) || !is_numeric($tz_data[0])) return false;
    if (!isset($tz_data[1]) || !is_numeric($tz_data[1])) return false;

    $sql = "INSERT INTO TIMEZONES (TZID, GMT_OFFSET, DST_OFFSET) ";
    $sql.= "VALUES ('$tzid', '{$tz_data[0]}', '{$tz_data[1]}')";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $dl_saving = ($tz_data[1] > 0) ? 'Y' : 'N';

    $sql = "UPDATE USER_PREFS SET TIMEZONE = '$tzid' ";
    $sql.= "WHERE TIMEZONE = '{$tz_data[0]}' ";
    $sql.= "AND DL_SAVING = '$dl_saving'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "SELECT TIMEZONE.FID FROM FORUM_SETTINGS TIMEZONE ";
    $sql.= "LEFT JOIN FORUM_SETTINGS DL_SAVING ";
    $sql.= "ON (DL_SAVING.FID = TIMEZONE.FID ";
    $sql.= "AND DL_SAVING.SNAME = 'forum_dl_saving') ";
    $sql.= "WHERE TIMEZONE.SNAME = 'forum_timezone' ";
    $sql.= "AND TIMEZONE.SVALUE = '{$tz_data[0]}' ";
    $sql.= "AND DL_SAVING.SVALUE = '$dl_saving'";

    if ($result = @db_query($sql, $db_install)) {

        while (list($forum_fid) = db_fetch_array($result, DB_RESULT_NUM)) {

            $sql = "UPDATE FORUM_SETTINGS SET SVALUE = '$tzid' ";
            $sql.= "WHERE FID = '$forum_fid' AND SNAME = 'forum_timezone'";

            if (!$result_update = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }
    }
}

// Change to Visitor log.

$visitor_log_new = preg_replace("/[^a-z]/", "", md5(uniqid(mt_rand())));

while (install_get_table_conflicts(false, false, array($visitor_log_new))) {
    $visitor_log_new = preg_replace("/[^a-z]/", "", md5(uniqid(mt_rand())));
}

// Create the new table. Auto-increment has been changed to a compound
// value to allow better grouping by UID.

$sql = "CREATE TABLE $visitor_log_new (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  VID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  LAST_LOGON DATETIME DEFAULT NULL,";
$sql.= "  IPADDRESS VARCHAR(15) DEFAULT NULL,";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql.= "  SID MEDIUMINT(8) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (UID,VID),";
$sql.= "  KEY LAST_LOGON (LAST_LOGON),";
$sql.= "  KEY FORUM (FORUM),";
$sql.= "  KEY SID (SID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Copy the data from the old VISITOR_LOG into our new table.

$sql = "INSERT INTO $visitor_log_new (UID, FORUM, LAST_LOGON, IPADDRESS, REFERER, SID) ";
$sql.= "SELECT UID, FORUM, LAST_LOGON, IPADDRESS, REFERER, SID FROM VISITOR_LOG ";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Remove the old VISITOR_LOG table.

$sql = "DROP TABLE VISITOR_LOG";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Rename our new USER_POLL_VOTES table

$sql = "ALTER TABLE $visitor_log_new RENAME VISITOR_LOG";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

?>