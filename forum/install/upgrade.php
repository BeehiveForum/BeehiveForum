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

if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) == 'upgrade.php') {

    header("Request-URI: index.php");
    header("Content-Location: index.php");
    header("Location: index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Stop script timing out
@set_time_limit(0);

// Get list of forums.
if (!($forum_webtag_array = install_get_webtags())) {

    $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
    $valid = false;
    return;
}

if (!install_table_exists($db_database, "SPHINX_SEARCH_ID")) {

    // Create new SPHINX_SEARCH_ID table shared by all forums.
    $sql = "CREATE TABLE SPHINX_SEARCH_ID (";
    $sql.= "  SEARCH_ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  PRIMARY KEY (SEARCH_ID)";
    $sql.= ") ENGINE=MyISAM  DEFAULT CHARSET=UTF8";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// We got this far then everything is okay for all forums.
// Start by creating and updating the per-forum tables.
foreach ($forum_webtag_array as $forum_fid => $table_data) {
    
    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_FOLDER", "PERM")) {
        
        $sql = "ALTER TABLE `{$table_data['PREFIX']}FOLDER` ADD COLUMN `PERM` INT(32) UNSIGNED DEFAULT NULL";
        
        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }        
    
        $sql = "INSERT INTO {$table_data['PREFIX']}FOLDER (FID, PERM) SELECT FOLDER.FID, ";
        $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
        $sql.= "AND GROUP_PERMS.FORUM = '$forum_fid' AND GROUP_PERMS.GID = 0) GROUP BY FOLDER.FID ";
        $sql.= "ON DUPLICATE KEY UPDATE PERM = VALUES(PERM)";
        
        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
          
        $sql = "DELETE FROM GROUP_PERMS WHERE GROUP_PERMS.FORUM = '$forum_fid' ";
        $sql.= "AND GROUP_PERMS.GID = 0 ";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_table_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_POLL_QUESTIONS")) {

        // Delete temp POLL_VOTES_NEW table if it exists
        $sql = "DROP TABLE IF EXISTS `{$table_data['PREFIX']}POLL_VOTES_NEW`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Delete temp USER_POLL_VOTES_NEW table if it exists
        $sql = "DROP TABLE IF EXISTS `{$table_data['PREFIX']}USER_POLL_VOTES_NEW`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Create new POLL_QUESTIONS table.
        $sql = "CREATE TABLE `{$table_data['PREFIX']}POLL_QUESTIONS`(";
        $sql.= "    TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    QUESTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "    QUESTION VARCHAR(255) NOT NULL,";
        $sql.= "    ALLOW_MULTI CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "    GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    PRIMARY KEY (TID, QUESTION_ID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // CREATE new POLL_VOTES table.
        $sql = "CREATE TABLE `{$table_data['PREFIX']}POLL_VOTES_NEW`(";
        $sql.= "    TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    QUESTION_ID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "    OPTION_NAME VARCHAR(255) NOT NULL,";
        $sql.= "    OPTION_ID_OLD MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    PRIMARY KEY (TID,QUESTION_ID,OPTION_ID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Create new USER_POLL_VOTES table
        $sql = "CREATE TABLE `{$table_data['PREFIX']}USER_POLL_VOTES_NEW`(";
        $sql.= "    VOTE_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "    TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    QUESTION_ID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    UID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    VOTED DATETIME NOT NULL,";
        $sql.= "    PRIMARY KEY (VOTE_ID),";
        $sql.= "    KEY TID (TID),";
        $sql.= "    KEY QUESTION_ID (QUESTION_ID),";
        $sql.= "    KEY OPTION_ID (OPTION_ID),";
        $sql.= "    KEY UID (UID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Make sure no polls have empty questions.
        $sql = "UPDATE `{$table_data['PREFIX']}POLL` POLL ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "ON (THREAD.TID = POLL.TID) SET POLL.QUESTION = THREAD.TITLE ";
        $sql.= "WHERE LENGTH(TRIM(BOTH FROM POLL.QUESTION)) = 0";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Create new question data for existing polls
        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_QUESTIONS` ";
        $sql.= "SELECT POLL.TID, IF (MIN_GROUP_ID = 0, POLL_VOTES.GROUP_ID + 1, ";
        $sql.= "POLL_VOTES.GROUP_ID) AS QUESTION_ID, IF (POLL_GROUP_COUNTS.GROUP_COUNT > 1, ";
        $sql.= "CONCAT(POLL.QUESTION, ' - ', POLL_VOTES.GROUP_ID), COALESCE(POLL.QUESTION, THREAD.TITLE)) AS QUESTION, ";
        $sql.= "'N' AS ALLOW_MULTI, POLL_VOTES.GROUP_ID FROM `{$table_data['PREFIX']}POLL` POLL ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ON (POLL_VOTES.TID = POLL.TID) ";
        $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = POLL.TID) ";
        $sql.= "INNER JOIN (SELECT POLL.TID, COUNT(DISTINCT POLL_VOTES.GROUP_ID) AS GROUP_COUNT, ";
        $sql.= "MIN(POLL_VOTES.GROUP_ID) AS MIN_GROUP_ID FROM `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL` POLL ON (POLL.TID = POLL_VOTES.TID) ";
        $sql.= "GROUP BY POLL_VOTES.TID ORDER BY POLL.TID) AS POLL_GROUP_COUNTS ON ";
        $sql.= "(POLL_GROUP_COUNTS.TID = POLL.TID) GROUP BY POLL.TID, POLL_VOTES.GROUP_ID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Convert old POLL_VOTES into their new format
        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_VOTES_NEW` ";
        $sql.= "SELECT POLL.TID, POLL_QUESTIONS.QUESTION_ID, NULL AS OPTION_ID, ";
        $sql.= "POLL_VOTES.OPTION_NAME, POLL_VOTES.OPTION_ID FROM `{$table_data['PREFIX']}POLL` POLL ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ON (POLL_QUESTIONS.TID = POLL.TID) ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ON (POLL_VOTES.TID = POLL.TID ";
        $sql.= "AND POLL_VOTES.GROUP_ID = POLL_QUESTIONS.GROUP_ID)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Convert old USER_POLL_VOTES into the new format
        $sql = "INSERT INTO `{$table_data['PREFIX']}USER_POLL_VOTES_NEW` ";
        $sql.= "SELECT NULL AS VOTE_ID, POLL.TID, POLL_QUESTIONS.QUESTION_ID, ";
        $sql.= "POLL_VOTES_NEW.OPTION_ID, USER_POLL_VOTES.UID, USER_POLL_VOTES.TSTAMP ";
        $sql.= "FROM `{$table_data['PREFIX']}POLL` POLL INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ";
        $sql.= "ON (POLL_QUESTIONS.TID = POLL.TID) INNER JOIN `{$table_data['PREFIX']}POLL_VOTES_NEW` POLL_VOTES_NEW ";
        $sql.= "ON (POLL_VOTES_NEW.TID = POLL.TID AND POLL_VOTES_NEW.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID) ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}USER_POLL_VOTES` USER_POLL_VOTES ";
        $sql.= "ON (USER_POLL_VOTES.TID = POLL.TID AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES_NEW.OPTION_ID_OLD)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Delete QUESTION column from POLL table.
        $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL` DROP COLUMN QUESTION";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Delete GROUP_ID column from new POLL_QUESTIONS table.
        $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL_QUESTIONS` DROP COLUMN GROUP_ID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Delete the OPTION_ID_OLD column from new POLL_VOTES table.
        $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL_VOTES_NEW` DROP COLUMN OPTION_ID_OLD";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Delete old POLL_VOTES table
        $sql = "DROP TABLE `{$table_data['PREFIX']}POLL_VOTES`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Rename POLL_VOTES_NEW table to POLL_VOTES
        $sql = "RENAME TABLE `{$table_data['PREFIX']}POLL_VOTES_NEW` TO `{$table_data['PREFIX']}POLL_VOTES`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Delete the old USER_POLL_VOTES table.
        $sql = "DROP TABLE `{$table_data['PREFIX']}USER_POLL_VOTES`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Rename USER_POLL_VOTES_NEW table to USER_POLL_VOTES
        $sql = "RENAME TABLE `{$table_data['PREFIX']}USER_POLL_VOTES_NEW` TO `{$table_data['PREFIX']}USER_POLL_VOTES`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", "SHOW_SHARE_LINKS")) {

        // Add field for thread_last_page
        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD SHOW_SHARE_LINKS CHAR(1) NOT NULL DEFAULT 'Y'";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_POST", "SEARCH_ID")) {

        // Add SEARCH_ID column for Sphinx integration.
        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` ADD SEARCH_ID BIGINT(20) UNSIGNED NULL";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Add a unique index to SEARCH_ID.
        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` ADD UNIQUE SEARCH_ID (SEARCH_ID)";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // Declare a MySQL variable to increment the SEARCH_ID column.
        $sql = "SELECT @search_id:= COALESCE(MAX(SEARCH_ID), 0) FROM SPHINX_SEARCH_ID";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // UPDATE SEARCH_ID in POST table to assign unique id to every post.
        $sql = "UPDATE `{$table_data['PREFIX']}POST` SET SEARCH_ID = @search_id:= @search_id + 1";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        // UPDATE SPHINX_SEARCH_ID with all the new post search ids.
        $sql = "INSERT INTO `SPHINX_SEARCH_ID` SELECT SEARCH_ID FROM `{$table_data['PREFIX']}POST`";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    // Purge the USER_TRACK.USER_TIME_TOTAL, USER_TIME_BEST and USER_TIME_UPDATED columns
    // as they were totally calculated incorrectly prior to Beehive Forum 1.1
    $sql = "UPDATE `{$table_data['PREFIX']}USER_TRACK` SET USER_TIME_TOTAL = NULL, USER_TIME_BEST = NULL, USER_TIME_UPDATED = NULL";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_table_exists($db_database, "USER_TOKEN")) {

    // Increase the allowed length of the PASSWD column.
    $sql = "ALTER TABLE USER CHANGE PASSWD PASSWD VARCHAR(255)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Add new SALT column to USER table for per-user password salting
    $sql = "ALTER TABLE USER ADD SALT VARCHAR(255) DEFAULT NULL AFTER PASSWD";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Create USER_TOKEN table used for remembering users who tick
    // the Remember me box on the login page.
    $sql = "CREATE TABLE USER_TOKEN (";
    $sql.= "  UID mediumint(8) unsigned NOT NULL,";
    $sql.= "  TOKEN varchar(255) NOT NULL,";
    $sql.= "  EXPIRES datetime NOT NULL,";
    $sql.= "  PRIMARY KEY (UID, TOKEN)";
    $sql.= ") ENGINE=MyISAM DEFAULT CHARSET=UTF8";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "USER_PREFS", "SHOW_SHARE_LINKS")) {

    // New User preference for thread list folder order
    $sql = "ALTER TABLE USER_PREFS ADD SHOW_SHARE_LINKS CHAR(1) NOT NULL DEFAULT 'Y'";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>