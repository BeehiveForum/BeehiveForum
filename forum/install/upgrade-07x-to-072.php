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

/* $Id: upgrade-07x-to-072.php,v 1.23 2007-02-12 01:05:30 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-07x-to-072.php") {

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

$global_tables = array();

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

$forum_tables  = array();

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

        $error_str = "<h2>Conflicting tables</h2>\n";
        $error_str.= "<ul><li>". implode("</li><li>", $conflicting_tables). "</li></ul>\n";

        $error_array[] = $error_str;

        $valid = false;
        return;
    }
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

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

    // New User preference for image resize and page reflow.

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS ADD ";
    $sql.= "USE_OVERFLOW_RESIZE CHAR(1) NOT NULL DEFAULT 'Y'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Index on APPROVED column to help speed up display of
    // Post Approval Queue in Admin.

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD INDEX (APPROVED)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // New USER_POLL_VOTES table format to allow guests to vote in polls

    $upv_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));

    while (install_get_table_conflicts(false, false, array($upv_new))) {
        $upv_new = preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
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

    $sql = "INSERT INTO {$forum_webtag}_{$upv_new} (TID, UID, OPTION_ID, TSTAMP) ";
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

            $forum_links_top_link = addslashes($forum_links_top_link);

            $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
            $sql.= "VALUES ('$forum_fid', 'forum_links_top_link', ";
            $sql.= "'$forum_links_top_link')";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            // Delete the old record from the FORUM_LINKS table.

            $lid = addslashes($lid);

            $sql = "DELETE FROM {$forum_webtag}_FORUM_LINKS ";
            $sql.= "WHERE LID = '$lid'";

            if (!$result = @db_query($sql, $db_install)) {

                $valid = false;
                return;
            }
        }
    }

    // Index on THREAD.TITLE for searches

    $sql = "ALTER TABLE {$forum_webtag}_THREAD ADD INDEX (TITLE)";

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

    // Resolved bug with folder titles & descriptions not being htmlentities'd

    $sql = "SELECT FID, TITLE, DESCRIPTION FROM {$forum_webtag}_FOLDER";

    if ($result = @db_query($sql, $db_install)) {

        while ($folder_data = db_fetch_array($result)) {

            $fid = $folder_data['FID'];
            
            if (!isset($folder_data['TITLE'])) $folder_data['TITLE'] = "";
            if (!isset($folder_data['DESCRIPTION'])) $folder_data['DESCRIPTION'] = "";

            $new_title = addslashes(_htmlentities($folder_data['TITLE']));
            $new_description = addslashes(_htmlentities($folder_data['DESCRIPTION']));

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
}

// If we got this far we managed to complete the per-forum table
// upgrades without incident so we can now do the global tables.

// New USER_HISTORY table for tracking user logon, nickname
// and email address changes

$sql = "CREATE TABLE USER_HISTORY (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  LOGON VARCHAR(32) NULL,";
$sql.= "  NICKNAME VARCHAR(32) NULL,";
$sql.= "  EMAIL VARCHAR(80) NULL,";
$sql.= "  PRIMARY KEY (UID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// As of Beehive Forum 0.7.2 you can keep your per-forum tables
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

// New User preference for mouseover spoiler reveal

$sql = "ALTER TABLE USER_PREFS ADD USE_MOVER_SPOILER ";
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

$sql = "ALTER TABLE POST_ATTACHMENT_IDS ADD INDEX (AID)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Reindex PM_ATTACHMENT_IDS table to make queries quicker

install_remove_table_keys("PM_ATTACHMENT_IDS");

$sql = "ALTER TABLE PM_ATTACHMENT_IDS ADD INDEX (AID)";

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

$sql = "ALTER TABLE USER ADD INDEX LOGON";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER ADD INDEX NICKNAME";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Indexes on SEB.NAME and SEB.AGENT_MATCH for searches.

install_remove_table_keys("SEARCH_ENGINE_BOTS");

$sql = "ALTER TABLE SEARCH_ENGINE_BOTS ADD INDEX (NAME)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE SEARCH_ENGINE_BOTS ADD INDEX (AGENT_MATCH)";

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

?>