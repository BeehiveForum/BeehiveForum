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

/* $Id$ */

if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) == 'upgrade-08x-to-083.php') {

    header("Request-URI: install.php");
    header("Content-Location: install.php");
    header("Location: install.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Stop script timing out

@set_time_limit(0);

// Current datetime

$current_datetime = date(MYSQL_DATETIME, time());

// Get list of forums.

if (!($forum_webtag_array = install_get_webtags())) {

    $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
    $valid = false;
    return;
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.

foreach ($forum_webtag_array as $forum_fid => $table_data) {

    // Removed unused entries from Admin Log.

    $sql = "DELETE FROM `{$table_data['PREFIX']}ADMIN_LOG` WHERE ACTION IN (6, 61, 68, 69)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_FOLDER", "CREATED")) {

        // Created and Modified dates for folders to aid thread list caching.

        $sql = "ALTER TABLE `{$table_data['PREFIX']}FOLDER` ADD `CREATED` DATETIME NULL DEFAULT NULL AFTER `DESCRIPTION`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}FOLDER` ADD `MODIFIED` DATETIME NULL DEFAULT NULL AFTER `CREATED`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Set the created date to current datetime.

        $sql = "UPDATE `{$table_data['PREFIX']}FOLDER` SET CREATED = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_THREAD", "DELETED")) {

        // Better support for deleted threads.

        $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD DELETED CHAR(1) NOT NULL DEFAULT 'N'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_THREAD", "UNREAD_PID")) {

        // Better support for unread cut-off.

        $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD UNREAD_PID MEDIUMINT(8) NULL AFTER LENGTH";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) !== false) {

        // Moved the UNREAD_PID column into the THREAD table.
        // Make sure the data is up to date - Also fixes the threads that are
        // inaccessible to due to bug in user delete code.

        $sql = "INSERT INTO `{$table_data['PREFIX']}THREAD` (TID, UNREAD_PID) ";
        $sql.= "SELECT THREAD.TID, MAX(POST.PID) FROM `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST` POST ON (POST.TID = THREAD.TID) ";
        $sql.= "WHERE POST.CREATED < CAST('$unread_cutoff_datetime' AS DATETIME) GROUP BY THREAD.TID ";
        $sql.= "ON DUPLICATE KEY UPDATE UNREAD_PID = VALUES(UNREAD_PID)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

    }else {

        // Fix the threads which are inaccessible due to a bug in the delete user code.

        $sql = "INSERT INTO `{$table_data['PREFIX']}THREAD` (TID, LENGTH) ";
        $sql.= "SELECT THREAD.TID, MAX(POST.PID) FROM `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST` POST ON (POST.TID = THREAD.TID) ";
        $sql.= "GROUP BY THREAD.TID ON DUPLICATE KEY UPDATE LENGTH = VALUES(LENGTH)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    // Reset the unread data so that none of the data has LAST_READ > LENGTH

    $sql = "UPDATE `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = USER_THREAD.TID) ";
    $sql.= "SET USER_THREAD.LAST_READ = THREAD.LENGTH WHERE USER_THREAD.LAST_READ > THREAD.LENGTH";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Delete any remaining 0 length threads from the THREADS table so they
    // don't appear in the thread list.

    $sql = "DELETE FROM `{$table_data['PREFIX']}THREAD` WHERE LENGTH = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", "REPLY_QUICK")) {

        // Add field for reply_quick

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", "THREADS_BY_FOLDER")) {

        // New User preference for thread list folder order

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD THREADS_BY_FOLDER CHAR(1) NOT NULL DEFAULT 'N'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", "THREAD_LAST_PAGE")) {

        // Add field for thread_last_page

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD THREAD_LAST_PAGE CHAR(1) NOT NULL DEFAULT 'N'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", "USE_EMAIL_ADDR")) {

        // Add field for thread_last_page

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD USE_EMAIL_ADDR CHAR(1) NOT NULL DEFAULT 'N'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    // ANON_LOGON column had wrong default value in < 0.9.2

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE `ANON_LOGON` `ANON_LOGON` CHAR(1) NOT NULL DEFAULT '0'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Sort out the THREAD MODIFIED columns being wrong due to a bug in 0.8 and 0.8.1.

    $sql = "INSERT INTO `{$table_data['PREFIX']}THREAD` (TID, FID, BY_UID, TITLE, LENGTH, ";
    $sql.= "POLL_FLAG, CREATED, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
    $sql.= "SELECT THREAD.TID, THREAD.FID, THREAD.BY_UID, THREAD.TITLE, THREAD.LENGTH, ";
    $sql.= "THREAD.POLL_FLAG, THREAD.CREATED, MAX(POST.CREATED), THREAD.CLOSED, THREAD.STICKY, ";
    $sql.= "THREAD.STICKY_UNTIL, THREAD.ADMIN_LOCK FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST` POST ON (POST.TID = THREAD.TID) GROUP BY THREAD.TID ";
    $sql.= "ON DUPLICATE KEY UPDATE MODIFIED = VALUES(MODIFIED)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}POST` POST, `{$table_data['PREFIX']}POST_CONTENT` POST_CONTENT ";
    $sql.= "SET POST.APPROVED = CAST('$current_datetime' AS DATETIME), POST.APPROVED_BY = POST.FROM_UID ";
    $sql.= "WHERE POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID ";
    $sql.= "AND POST_CONTENT.CONTENT IS NULL ";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Update existing deleted threads

    $sql = "UPDATE `{$table_data['PREFIX']}THREAD` SET DELETED = 'Y', ";
    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE LENGTH = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_BANNED", "EXPIRES")) {

        // New User preference for thread list folder order

        $sql = "ALTER TABLE `{$table_data['PREFIX']}BANNED` ADD EXPIRES DATETIME NOT NULL";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    // Change IPADDRESS column in POST so it can be NULL so the IP Address matching of the
    // user comparison tools can work more efficiently.

    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE IPADDRESS IPADDRESS VARCHAR(15) NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Set all empty IPADDRESS records to NULL

    $sql = "UPDATE `{$table_data['PREFIX']}POST` SET IPADDRESS = NULL WHERE LENGTH(IPADDRESS) = 0";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Remove any existing indexes on THREAD

    if (!install_remove_indexes($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_THREAD")) {

        $valid = false;
        return;
    }

    // Add the FULLTEXT key to TITLE.

    $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD FULLTEXT(TITLE)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Add index for thread sorting

    $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD INDEX `MODIFIED` (`MODIFIED`, `FID`, `LENGTH`, `DELETED`)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Add index for sticky thread sorting

    $sql = "ALTER TABLE `{$table_data['PREFIX']}THREAD` ADD INDEX `STICKY` (`STICKY`, `MODIFIED`, `FID`, `LENGTH`, `DELETED`)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
    
    // Last Search Sort By
    
    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_TRACK", "LAST_SEARCH_SORT_BY")) {

        // Add LAST_SEARCH_SORT_BY to USER_TRACK

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_TRACK` ADD LAST_SEARCH_SORT_BY TINYINT UNSIGNED NULL AFTER LAST_SEARCH_KEYWORDS";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
    
    // Last Search Sort Dir
    
    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_TRACK", "LAST_SEARCH_SORT_DIR")) {

        // Add LAST_SEARCH_SORT_DIR to USER_TRACK

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_TRACK` ADD LAST_SEARCH_SORT_DIR TINYINT UNSIGNED NULL AFTER LAST_SEARCH_SORT_BY";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
    
    // RSS Feed Max Items
    
    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_RSS_FEEDS", "MAX_ITEM_COUNT")) {

        // Better support for deleted threads.

        $sql = "ALTER TABLE `{$table_data['PREFIX']}_RSS_FEEDS` ADD MAX_ITEM_COUNT MEDIUMINT(8) NULL AFTER LAST_RUN";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }    
    
}

// We got this far, that means we can now update the global forum tables.

// GROUPS and GROUP_PERMS have changed to a schema which makes
// a lot more sense and is more normalised.

$sql = "CREATE TABLE GROUP_PERMS_NEW (";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY (FORUM, FID, GID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Copy the existing permissions to the new table.

$sql = "INSERT INTO GROUP_PERMS_NEW (FORUM, FID, GID, PERM) SELECT FORUM, FID, GID, PERM FROM GROUP_PERMS";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Remove the unneccesary records from GROUPS.

$sql = "DELETE FROM GROUPS WHERE AUTO_GROUP = 1";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// AUTO_GROUP and FORUM have been depreceated in GROUPS.
// GID is no longer the auto increment.

$sql = "ALTER TABLE GROUPS DROP COLUMN FORUM, DROP COLUMN AUTO_GROUP, CHANGE GID GID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Remove the old GROUP_PERMS table.

$sql = "DROP TABLE GROUP_PERMS";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Rename the new GROUP_PERMS_NEW to GROUP_PERMS.

$sql = "RENAME TABLE GROUP_PERMS_NEW TO GROUP_PERMS";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Dictionary has changed from metaphone to soundex matches

$sql = "UPDATE DICTIONARY SET SOUND = SOUNDEX(WORD)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Check for and fix a bug involving forum owner where Guests
// can be granted access to admin section of a forum.

$sql = "DELETE FROM GROUP_USERS WHERE UID = 0";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (!install_column_exists($db_database, "USER_PREFS", "REPLY_QUICK")) {

    // Add field for reply_quick

    $sql = "ALTER TABLE USER_PREFS ADD REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "USER_PREFS", "THREAD_LAST_PAGE")) {

    // Add field for thread_last_page

    $sql = "ALTER TABLE USER_PREFS ADD THREAD_LAST_PAGE CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "USER_PREFS", "THREADS_BY_FOLDER")) {

    // New User preference for thread list folder order

    $sql = "ALTER TABLE USER_PREFS ADD THREADS_BY_FOLDER CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "USER_PREFS", "USE_EMAIL_ADDR")) {

    // New User preference for thread list folder order

    $sql = "ALTER TABLE USER_PREFS ADD USE_EMAIL_ADDR CHAR(1) NOT NULL DEFAULT 'N'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (install_index_exists($db_database, 'FORUM_SETTINGS', 'SVALUE')) {

    // Remove the index on SVALUE before we convert it to TEXT

    $sql = "ALTER IGNORE TABLE FORUM_SETTINGS DROP INDEX SVALUE";
    $result = @db_query($sql, $db_install);
}

// Convert the SVALUE column to TEXT. This allows it to become big enough
// to hold things like the forum rules message.

$sql = "ALTER TABLE FORUM_SETTINGS CHANGE SVALUE SVALUE TEXT NOT NULL";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (install_index_exists($db_database, 'VISITOR_LOG', 'SID')) {

    // Remove the index on SID before we add the UNIQUE index

    $sql = "ALTER IGNORE TABLE VISITOR_LOG DROP INDEX SID";
    $result = @db_query($sql, $db_install);
}

// Add the UNIQUE index to SID.

$sql = "ALTER IGNORE TABLE VISITOR_LOG ADD UNIQUE (SID)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (!install_column_exists($db_database, "SESSIONS", "SID")) {

    // Add the SID to the SESSIONS table so we can show Bots on active user list.

    $sql = "ALTER TABLE SESSIONS ADD SID MEDIUMINT(8) DEFAULT NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_table_exists($db_database, 'PM_FOLDERS')) {

    // New table to store PM Folder names

    $sql = "CREATE TABLE PM_FOLDERS (";
    $sql.= "  UID MEDIUMINT(8) NOT NULL,";
    $sql.= "  FID MEDIUMINT(8) NOT NULL,";
    $sql.= "  TITLE VARCHAR(32) NOT NULL,";
    $sql.= "  PRIMARY KEY (UID, FID)";
    $sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>