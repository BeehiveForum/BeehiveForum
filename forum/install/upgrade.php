<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) == 'upgrade.php') {

    header("Request-URI: index.php");
    header("Content-Location: index.php");
    header("Location: index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'install.inc.php';

@set_time_limit(0);

$current_datetime = date(MYSQL_DATETIME, time());

if (!($forum_prefix_array = install_get_table_data())) {

    $error_html.= "<h2>Could not locate any previous Beehive Forum installations!</h2>\n";
    $valid = false;
    return;
}

foreach ($forum_prefix_array as $forum_fid => $table_data) {
    
    if (!install_check_column_type($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_ADMIN_LOG", "ENTRY", "longblob")) {
        
        $sql = "ALTER TABLE `{$table_data['PREFIX']}ADMIN_LOG` CHANGE `ENTRY` `ENTRY` LONGBLOB NULL";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }        
    
        $sql = "SELECT ID, ENTRY FROM `{$table_data['PREFIX']}ADMIN_LOG`";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        while ($admin_log_data = db_fetch_array($result)) {
            
            $admin_log_data['ENTRY'] = explode("\x00", $admin_log_data['ENTRY']);
            $admin_log_data['ENTRY'] = base64_encode(serialize($admin_log_data['ENTRY']));
            
            $sql = "UPDATE `{$table_data['PREFIX']}ADMIN_LOG` ";
            $sql.= "SET ENTRY = '{$admin_log_data['ENTRY']}' ";
            $sql.= "WHERE ID = '{$admin_log_data['ID']}'";
            
            if (!db_query($sql, $db_install)) {

                $valid = false;
                return;
            }        
        }
    }
    
    $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` CHANGE `IPADDRESS` `IPADDRESS` VARCHAR(255) NOT NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
    
    if (!install_table_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_POST_SEARCH_ID")) {
        
        $sql = "CREATE TABLE `{$table_data['PREFIX']}POST_SEARCH_ID` (";
        $sql.= "  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "  INDEXED DATETIME DEFAULT NULL,";
        $sql.= "  PRIMARY KEY  (SID,TID,PID)";
        $sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";        
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }        
    }
        
    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_FOLDER", "PERM")) {
        
        $sql = "ALTER TABLE `{$table_data['PREFIX']}FOLDER` ADD COLUMN `PERM` INT(32) UNSIGNED DEFAULT NULL";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }        
    
        $sql = "INSERT INTO `{$table_data['PREFIX']}FOLDER` (FID, PERM) SELECT FOLDER.FID, ";
        $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM FROM `{$table_data['PREFIX']}FOLDER` FOLDER ";
        $sql.= "INNER JOIN GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
        $sql.= "AND GROUP_PERMS.FORUM = '$forum_fid' AND GROUP_PERMS.GID = 0) GROUP BY FOLDER.FID ";
        $sql.= "ON DUPLICATE KEY UPDATE PERM = VALUES(PERM)";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
          
        $sql = "DELETE FROM GROUP_PERMS WHERE GROUP_PERMS.FORUM = '$forum_fid' ";
        $sql.= "AND GROUP_PERMS.GID = 0 ";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_table_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_POLL_QUESTIONS")) {

        $sql = "DROP TABLE IF EXISTS `{$table_data['PREFIX']}POLL_VOTES_NEW`";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE IF EXISTS `{$table_data['PREFIX']}USER_POLL_VOTES_NEW`";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE `{$table_data['PREFIX']}POLL_QUESTIONS`(";
        $sql.= "    TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    QUESTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "    QUESTION VARCHAR(255) NOT NULL,";
        $sql.= "    ALLOW_MULTI CHAR(1) NOT NULL DEFAULT 'N',";
        $sql.= "    GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    PRIMARY KEY (TID, QUESTION_ID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "CREATE TABLE `{$table_data['PREFIX']}POLL_VOTES_NEW`(";
        $sql.= "    TID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    QUESTION_ID MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $sql.= "    OPTION_NAME VARCHAR(255) NOT NULL,";
        $sql.= "    OPTION_ID_OLD MEDIUMINT(8) UNSIGNED NOT NULL,";
        $sql.= "    PRIMARY KEY (TID,QUESTION_ID,OPTION_ID)";
        $sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

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

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "UPDATE `{$table_data['PREFIX']}POLL` POLL ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}THREAD` THREAD ";
        $sql.= "ON (THREAD.TID = POLL.TID) SET POLL.QUESTION = THREAD.TITLE ";
        $sql.= "WHERE LENGTH(TRIM(BOTH FROM POLL.QUESTION)) = 0";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

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

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO `{$table_data['PREFIX']}POLL_VOTES_NEW` ";
        $sql.= "SELECT POLL.TID, POLL_QUESTIONS.QUESTION_ID, NULL AS OPTION_ID, ";
        $sql.= "POLL_VOTES.OPTION_NAME, POLL_VOTES.OPTION_ID FROM `{$table_data['PREFIX']}POLL` POLL ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ON (POLL_QUESTIONS.TID = POLL.TID) ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}POLL_VOTES` POLL_VOTES ON (POLL_VOTES.TID = POLL.TID ";
        $sql.= "AND POLL_VOTES.GROUP_ID = POLL_QUESTIONS.GROUP_ID)";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "INSERT INTO `{$table_data['PREFIX']}USER_POLL_VOTES_NEW` ";
        $sql.= "SELECT NULL AS VOTE_ID, POLL.TID, POLL_QUESTIONS.QUESTION_ID, ";
        $sql.= "POLL_VOTES_NEW.OPTION_ID, USER_POLL_VOTES.UID, USER_POLL_VOTES.TSTAMP ";
        $sql.= "FROM `{$table_data['PREFIX']}POLL` POLL INNER JOIN `{$table_data['PREFIX']}POLL_QUESTIONS` POLL_QUESTIONS ";
        $sql.= "ON (POLL_QUESTIONS.TID = POLL.TID) INNER JOIN `{$table_data['PREFIX']}POLL_VOTES_NEW` POLL_VOTES_NEW ";
        $sql.= "ON (POLL_VOTES_NEW.TID = POLL.TID AND POLL_VOTES_NEW.QUESTION_ID = POLL_QUESTIONS.QUESTION_ID) ";
        $sql.= "INNER JOIN `{$table_data['PREFIX']}USER_POLL_VOTES` USER_POLL_VOTES ";
        $sql.= "ON (USER_POLL_VOTES.TID = POLL.TID AND USER_POLL_VOTES.OPTION_ID = POLL_VOTES_NEW.OPTION_ID_OLD)";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL` DROP COLUMN QUESTION";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL_QUESTIONS` DROP COLUMN GROUP_ID";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POLL_VOTES_NEW` DROP COLUMN OPTION_ID_OLD";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE `{$table_data['PREFIX']}POLL_VOTES`";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "RENAME TABLE `{$table_data['PREFIX']}POLL_VOTES_NEW` TO `{$table_data['PREFIX']}POLL_VOTES`";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "DROP TABLE `{$table_data['PREFIX']}USER_POLL_VOTES`";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }

        $sql = "RENAME TABLE `{$table_data['PREFIX']}USER_POLL_VOTES_NEW` TO `{$table_data['PREFIX']}USER_POLL_VOTES`";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", "SHOW_SHARE_LINKS")) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` ADD SHOW_SHARE_LINKS CHAR(1) NOT NULL DEFAULT 'Y'";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_POST", "SEARCH_ID")) {

        $sql = "ALTER TABLE `{$table_data['PREFIX']}POST` DROP COLUMN SEARCH_ID";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    $sql = "UPDATE `{$table_data['PREFIX']}USER_TRACK` SET USER_TIME_TOTAL = NULL, USER_TIME_BEST = NULL, USER_TIME_UPDATED = NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
    
    if (!install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_LINKS", 'APPROVED')) {
    
        $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS` ADD COLUMN `APPROVED` DATETIME NULL AFTER CREATED";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    
        $sql = "ALTER TABLE `{$table_data['PREFIX']}LINKS` ADD COLUMN `APPROVED_BY` MEDIUMINT(8) NULL AFTER `APPROVED`";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
        
        $approved_datetime = date(MYSQL_DATETIME, time());
        
        $sql = "UPDATE `{$table_data['PREFIX']}LINKS` SET APPROVED = '$approved_datetime', APPROVED_BY = UID";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }        
    }

    if (install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", 'DOB_DISPLAY')) {
        
        $sql = "UPDATE USER_PREFS INNER JOIN `{$table_data['PREFIX']}USER_PREFS` ";
        $sql.= "ON (`{$table_data['PREFIX']}USER_PREFS`.UID = USER_PREFS.UID) ";
        $sql.= "SET USER_PREFS.DOB_DISPLAY = `{$table_data['PREFIX']}USER_PREFS`.DOB_DISPLAY ";
        $sql.= "WHERE `{$table_data['PREFIX']}USER_PREFS`.DOB_DISPLAY < 3 ";
        $sql.= "AND USER_PREFS.DOB_DISPLAY > `{$table_data['PREFIX']}USER_PREFS`.DOB_DISPLAY";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }           

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` DROP COLUMN DOB_DISPLAY";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    if (install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", 'ANON_LOGON')) {
        
        $sql = "UPDATE USER_PREFS INNER JOIN `{$table_data['PREFIX']}USER_PREFS` ";
        $sql.= "ON (`{$table_data['PREFIX']}USER_PREFS`.UID = USER_PREFS.UID) ";
        $sql.= "SET USER_PREFS.ANON_LOGON = `{$table_data['PREFIX']}USER_PREFS`.ANON_LOGON ";
        $sql.= "WHERE `{$table_data['PREFIX']}USER_PREFS`.ANON_LOGON = 'Y'";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }          

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` DROP COLUMN ANON_LOGON";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
        
    if (install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", 'ALLOW_EMAIL')) {
        
        $sql = "UPDATE USER_PREFS INNER JOIN `{$table_data['PREFIX']}USER_PREFS` ";
        $sql.= "ON (`{$table_data['PREFIX']}USER_PREFS`.UID = USER_PREFS.UID) ";
        $sql.= "SET USER_PREFS.ALLOW_EMAIL = `{$table_data['PREFIX']}USER_PREFS`.ALLOW_EMAIL ";
        $sql.= "WHERE `{$table_data['PREFIX']}USER_PREFS`.ALLOW_EMAIL = 'N'";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }          

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` DROP COLUMN ALLOW_EMAIL";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
        
    if (install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", 'USE_EMAIL_ADDR')) {
        
        $sql = "UPDATE USER_PREFS INNER JOIN `{$table_data['PREFIX']}USER_PREFS` ";
        $sql.= "ON (`{$table_data['PREFIX']}USER_PREFS`.UID = USER_PREFS.UID) ";
        $sql.= "SET USER_PREFS.USE_EMAIL_ADDR = `{$table_data['PREFIX']}USER_PREFS`.USE_EMAIL_ADDR ";
        $sql.= "WHERE `{$table_data['PREFIX']}USER_PREFS`.USE_EMAIL_ADDR = 'N' ";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }        

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` DROP COLUMN USE_EMAIL_ADDR";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
        
    if (install_column_exists($table_data['DATABASE_NAME'], "{$table_data['WEBTAG']}_USER_PREFS", 'ALLOW_PM')) {

        $sql = "UPDATE USER_PREFS INNER JOIN `{$table_data['PREFIX']}USER_PREFS` ";
        $sql.= "ON (`{$table_data['PREFIX']}USER_PREFS`.UID = USER_PREFS.UID) ";
        $sql.= "SET USER_PREFS.ALLOW_PM = `{$table_data['PREFIX']}USER_PREFS`.ALLOW_PM ";
        $sql.= "WHERE `{$table_data['PREFIX']}USER_PREFS`.ALLOW_PM = 'N'";
        
        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }         

        $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` DROP COLUMN ALLOW_PM";

        if (!$result = db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE HOMEPAGE_URL HOMEPAGE_URL VARCHAR(255) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE PIC_URL PIC_URL VARCHAR(255) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE EMAIL_NOTIFY EMAIL_NOTIFY CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE MARK_AS_OF_INT MARK_AS_OF_INT CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE POSTS_PER_PAGE POSTS_PER_PAGE CHAR(3) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE FONT_SIZE FONT_SIZE CHAR(2) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE STYLE STYLE VARCHAR(255) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE EMOTICONS EMOTICONS VARCHAR(255) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE VIEW_SIGS VIEW_SIGS CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE START_PAGE START_PAGE CHAR(3) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE LANGUAGE LANGUAGE VARCHAR(32) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE SHOW_STATS SHOW_STATS CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE IMAGES_TO_LINKS IMAGES_TO_LINKS CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE USE_WORD_FILTER USE_WORD_FILTER CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE USE_ADMIN_FILTER USE_ADMIN_FILTER CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE SHOW_THUMBS SHOW_THUMBS CHAR(2) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE ENABLE_WIKI_WORDS ENABLE_WIKI_WORDS CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE USE_MOVER_SPOILER USE_MOVER_SPOILER CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE USE_LIGHT_MODE_SPOILER USE_LIGHT_MODE_SPOILER CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE USE_OVERFLOW_RESIZE USE_OVERFLOW_RESIZE CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE PIC_AID PIC_AID VARCHAR(32) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE AVATAR_URL AVATAR_URL VARCHAR(255) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE AVATAR_AID AVATAR_AID VARCHAR(32) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE REPLY_QUICK REPLY_QUICK CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE THREADS_BY_FOLDER THREADS_BY_FOLDER CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE THREAD_LAST_PAGE THREAD_LAST_PAGE CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE LEFT_FRAME_WIDTH LEFT_FRAME_WIDTH SMALLINT(4) UNSIGNED NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE SHOW_AVATARS SHOW_AVATARS CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE `{$table_data['PREFIX']}USER_PREFS` CHANGE SHOW_SHARE_LINKS SHOW_SHARE_LINKS CHAR(1) NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "UPDATE `{$table_data['PREFIX']}USER_PREFS` ";
    $sql.= "SET UID = IF (LENGTH(TRIM(BOTH FROM UID)) > 0, UID, NULL), ";
    $sql.= "HOMEPAGE_URL = IF (LENGTH(TRIM(BOTH FROM HOMEPAGE_URL)) > 0, HOMEPAGE_URL, NULL), ";
    $sql.= "PIC_URL = IF (LENGTH(TRIM(BOTH FROM PIC_URL)) > 0, PIC_URL, NULL), ";
    $sql.= "EMAIL_NOTIFY = IF (LENGTH(TRIM(BOTH FROM EMAIL_NOTIFY)) > 0, EMAIL_NOTIFY, NULL), ";
    $sql.= "MARK_AS_OF_INT = IF (LENGTH(TRIM(BOTH FROM MARK_AS_OF_INT)) > 0, MARK_AS_OF_INT, NULL), ";
    $sql.= "POSTS_PER_PAGE = IF (LENGTH(TRIM(BOTH FROM POSTS_PER_PAGE)) > 0, POSTS_PER_PAGE, NULL), ";
    $sql.= "FONT_SIZE = IF (LENGTH(TRIM(BOTH FROM FONT_SIZE)) > 0, FONT_SIZE, NULL), ";
    $sql.= "STYLE = IF (LENGTH(TRIM(BOTH FROM STYLE)) > 0, STYLE, NULL), ";
    $sql.= "EMOTICONS = IF (LENGTH(TRIM(BOTH FROM EMOTICONS)) > 0, EMOTICONS, NULL), ";
    $sql.= "VIEW_SIGS = IF (LENGTH(TRIM(BOTH FROM VIEW_SIGS)) > 0, VIEW_SIGS, NULL), ";
    $sql.= "START_PAGE = IF (LENGTH(TRIM(BOTH FROM START_PAGE)) > 0, START_PAGE, NULL), ";
    $sql.= "LANGUAGE = IF (LENGTH(TRIM(BOTH FROM LANGUAGE)) > 0, LANGUAGE, NULL), ";
    $sql.= "SHOW_STATS = IF (LENGTH(TRIM(BOTH FROM SHOW_STATS)) > 0, SHOW_STATS, NULL), ";
    $sql.= "IMAGES_TO_LINKS = IF (LENGTH(TRIM(BOTH FROM IMAGES_TO_LINKS)) > 0, IMAGES_TO_LINKS, NULL), ";
    $sql.= "USE_WORD_FILTER = IF (LENGTH(TRIM(BOTH FROM USE_WORD_FILTER)) > 0, USE_WORD_FILTER, NULL), ";
    $sql.= "USE_ADMIN_FILTER = IF (LENGTH(TRIM(BOTH FROM USE_ADMIN_FILTER)) > 0, USE_ADMIN_FILTER, NULL), ";
    $sql.= "SHOW_THUMBS = IF (LENGTH(TRIM(BOTH FROM SHOW_THUMBS)) > 0, SHOW_THUMBS, NULL), ";
    $sql.= "ENABLE_WIKI_WORDS = IF (LENGTH(TRIM(BOTH FROM ENABLE_WIKI_WORDS)) > 0, ENABLE_WIKI_WORDS, NULL), ";
    $sql.= "USE_MOVER_SPOILER = IF (LENGTH(TRIM(BOTH FROM USE_MOVER_SPOILER)) > 0, USE_MOVER_SPOILER, NULL), ";
    $sql.= "USE_LIGHT_MODE_SPOILER = IF (LENGTH(TRIM(BOTH FROM USE_LIGHT_MODE_SPOILER)) > 0, USE_LIGHT_MODE_SPOILER, NULL), ";
    $sql.= "USE_OVERFLOW_RESIZE = IF (LENGTH(TRIM(BOTH FROM USE_OVERFLOW_RESIZE)) > 0, USE_OVERFLOW_RESIZE, NULL), ";
    $sql.= "PIC_AID = IF (LENGTH(TRIM(BOTH FROM PIC_AID)) > 0, PIC_AID, NULL), ";
    $sql.= "AVATAR_URL = IF (LENGTH(TRIM(BOTH FROM AVATAR_URL)) > 0, AVATAR_URL, NULL), ";
    $sql.= "AVATAR_AID = IF (LENGTH(TRIM(BOTH FROM AVATAR_AID)) > 0, AVATAR_AID, NULL), ";
    $sql.= "REPLY_QUICK = IF (LENGTH(TRIM(BOTH FROM REPLY_QUICK)) > 0, REPLY_QUICK, NULL), ";
    $sql.= "THREADS_BY_FOLDER = IF (LENGTH(TRIM(BOTH FROM THREADS_BY_FOLDER)) > 0, THREADS_BY_FOLDER, NULL), "; 
    $sql.= "THREAD_LAST_PAGE = IF (LENGTH(TRIM(BOTH FROM THREAD_LAST_PAGE)) > 0, THREAD_LAST_PAGE, NULL), ";
    $sql.= "LEFT_FRAME_WIDTH = IF (LENGTH(TRIM(BOTH FROM LEFT_FRAME_WIDTH)) > 0, LEFT_FRAME_WIDTH, NULL),  ";
    $sql.= "SHOW_AVATARS = IF (LENGTH(TRIM(BOTH FROM SHOW_AVATARS)) > 0, SHOW_AVATARS, NULL), ";
    $sql.= "SHOW_SHARE_LINKS = IF (LENGTH(TRIM(BOTH FROM SHOW_SHARE_LINKS)) > 0, SHOW_SHARE_LINKS, NULL)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "DROP TABLE IF EXISTS SFS_CACHE";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}    

$sql = "CREATE TABLE SFS_CACHE (";
$sql.= "  REQUEST_MD5 varchar(32) NOT NULL, ";
$sql.= "  RESPONSE longblob NOT NULL, ";
$sql.= "  CREATED datetime NOT NULL, ";
$sql.= "  EXPIRES datetime NOT NULL, ";
$sql.= "  PRIMARY KEY (REQUEST_MD5), ";
$sql.= "  KEY EXPIRES (EXPIRES) ";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}    

if (!install_table_exists($db_database, "USER_TOKEN")) {

    $sql = "ALTER TABLE USER CHANGE PASSWD PASSWD VARCHAR(255)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE USER ADD SALT VARCHAR(255) DEFAULT NULL AFTER PASSWD";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE USER_TOKEN (";
    $sql.= "  UID mediumint(8) unsigned NOT NULL,";
    $sql.= "  TOKEN varchar(255) NOT NULL,";
    $sql.= "  EXPIRES datetime NOT NULL,";
    $sql.= "  PRIMARY KEY (UID, TOKEN)";
    $sql.= ") ENGINE=MyISAM DEFAULT CHARSET=UTF8";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "VISITOR_LOG", "USER_AGENT")) {
    
    $sql = "ALTER TABLE VISITOR_LOG ADD COLUMN USER_AGENT VARCHAR(255) DEFAULT NULL";
    
    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "USER_PREFS", "SHOW_SHARE_LINKS")) {

    $sql = "ALTER TABLE USER_PREFS ADD SHOW_SHARE_LINKS CHAR(1) NOT NULL DEFAULT 'Y'";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

if (!install_column_exists($db_database, "USER_PREFS", 'LEFT_FRAME_WIDTH')) {

    $sql = "ALTER TABLE USER_PREFS ADD COLUMN LEFT_FRAME_WIDTH SMALLINT(4) DEFAULT '280' NOT NULL AFTER THREAD_LAST_PAGE";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "ALTER TABLE USER_PREFS CHANGE UID UID MEDIUMINT(8) UNSIGNED NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE FIRSTNAME FIRSTNAME VARCHAR(32) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE LASTNAME LASTNAME VARCHAR(32) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE DOB DOB DATE NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE HOMEPAGE_URL HOMEPAGE_URL VARCHAR(255) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE PIC_URL PIC_URL VARCHAR(255) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE EMAIL_NOTIFY EMAIL_NOTIFY CHAR(1) DEFAULT 'Y' NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE STYLE STYLE VARCHAR(255) DEFAULT 'default' NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE EMOTICONS EMOTICONS VARCHAR(255) DEFAULT 'default' NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE LANGUAGE LANGUAGE VARCHAR(32) DEFAULT 'en_GB' NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE PIC_AID PIC_AID VARCHAR(32) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE AVATAR_URL AVATAR_URL VARCHAR(255) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS CHANGE AVATAR_AID AVATAR_AID VARCHAR(32) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS SPHINX_SEARCH_ID";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE `USER` CHANGE `IPADDRESS` `IPADDRESS` VARCHAR(255) NOT NULL";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS SESSIONS";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SESSIONS (";
$sql.= "  ID VARCHAR(40) NOT NULL,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  DATA LONGBLOB NOT NULL,";
$sql.= "  TIME DATETIME NOT NULL,";
$sql.= "  IPADDRESS VARCHAR(255) DEFAULT NULL,";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql.= "  USER_AGENT VARCHAR(255) DEFAULT NULL,";
$sql.= "  SID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  PRIMARY KEY (ID),";
$sql.= "  KEY REFERER (REFERER),";
$sql.= "  KEY TIME (TIME,FID),";
$sql.= "  KEY UID (UID,SID,TIME,FID)";
$sql.= ") ENGINE=INNODB DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS VISITOR_LOG_NEW";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE VISITOR_LOG_NEW (";
$sql.= "  VID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  SID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL,";
$sql.= "  LAST_LOGON DATETIME DEFAULT NULL,";
$sql.= "  IPADDRESS VARCHAR(255) NOT NULL,";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL,";
$sql.= "  USER_AGENT VARCHAR(255) DEFAULT NULL,";
$sql.= "  PRIMARY KEY (VID),";
$sql.= "  UNIQUE KEY UID (UID),";
$sql.= "  UNIQUE KEY SID (SID),";
$sql.= "  KEY FORUM (FORUM),";
$sql.= "  KEY LAST_LOGON (LAST_LOGON)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT IGNORE INTO VISITOR_LOG_NEW SELECT NULL AS VID, ";
$sql.= "IF (UID > 0, UID, NULL) AS UID, IF (SID > 0, SID, NULL) AS SID, ";
$sql.= "FORUM, LAST_LOGON, IPADDRESS, REFERER, USER_AGENT FROM VISITOR_LOG ";
$sql.= "ORDER BY LAST_LOGON DESC";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS VISITOR_LOG";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "RENAME TABLE VISITOR_LOG_NEW TO VISITOR_LOG";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

?>