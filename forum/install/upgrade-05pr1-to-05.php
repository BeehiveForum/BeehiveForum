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

/* $Id: upgrade-05pr1-to-05.php,v 1.5 2004-12-05 17:58:07 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-05pr1-to-05.php") {

    header("Request-URI: ./install.php");
    header("Content-Location: ./install.php");
    header("Location: ./install.php");
    exit;

}else if (!isset($_SERVER['PHP_SELF'])) {

    echo "To install BeehiveForums 0.5 please visit install.php in your browser";
    exit;
}

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");

set_time_limit(0);

// This script upgrades all forums it finds regardless of the
// WEBTAG entered in the install form. This is imperative that
// this happens because otherwise if you later try to upgrade
// a second forum you will run into problems

$sql = "SHOW TABLES LIKE 'FORUMS' ";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "SELECT WEBTAG FROM FORUMS ";
    $result = db_query($sql, $db_install);

    while ($row = db_fetch_array($result)) {
        $forum_webtag_array[] = $row['WEBTAG'];
    }
}

// Recreate the old 0.4 tables for the PM.
// This is to allow globalisation of the PMs
// so user's don't end up with multiple
// inboxes that are hard to keep track of.

$sql = "CREATE TABLE PM (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '',";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY (MID),";
$sql.= "  KEY TO_UID (TO_UID)";
$sql.= ")";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_ATTACHMENT_IDS (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  KEY AID (AID)";
$sql.= ")";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_CONTENT (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  CONTENT TEXT,";
$sql.= "  PRIMARY KEY  (MID),";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ")";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE DEDUPE (";
$sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
$sql.= "  DDKEY char(32) default NULL,";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ")";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

foreach($forum_webtag_array as $forum_webtag) {

    // DEDUPE has been globalised so we can drop the per-forum
    // table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_DEDUPE";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Change in the way ANON_LOGON works which makes more
    // sense. Now instead of checking the user pref value
    // before deciding to show the LAST_LOGON value we have
    // bh_update_visitor_log() set the LAST_LOGON column
    // as NULL if applicable and then check that when we
    // go to display it.

    $sql = "ALTER TABLE {$forum_webtag}_VISITOR_LOG CHANGE ";
    $sql.= "LAST_LOGON LAST_LOGON DATETIME DEFAULT NULL ";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Need to allow Guest access to the folders which is the
    // default behaviour.

    $sql = "UPDATE {$forum_webtag}_GROUP_PERMS ";
    $sql.= "SET PERM = PERM & 8192 WHERE GID = 0 AND FID > 0";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Need to recreate the THREAD table so we reuse the BY_UID column
    // that was removed in 0.4. This is designed as a measure to combat
    // server load introduced by the ignore completely option making
    // use of the POST table.

    $sql = "CREATE TABLE {$forum_webtag}_THREAD_NEW (";
    $sql.= "  TID mediumint(8) unsigned NOT NULL auto_increment,";
    $sql.= "  FID mediumint(8) unsigned default NULL,";
    $sql.= "  BY_UID mediumint(8) unsigned default NULL,";
    $sql.= "  TITLE varchar(64) default NULL,";
    $sql.= "  LENGTH mediumint(8) unsigned default NULL,";
    $sql.= "  POLL_FLAG char(1) default NULL,";
    $sql.= "  MODIFIED datetime default NULL,";
    $sql.= "  CLOSED datetime default NULL,";
    $sql.= "  STICKY char(1) default NULL,";
    $sql.= "  STICKY_UNTIL datetime default NULL,";
    $sql.= "  ADMIN_LOCK datetime default NULL,";
    $sql.= "  PRIMARY KEY  (TID),";
    $sql.= "  KEY BY_UID (BY_UID),";
    $sql.= "  KEY FID (FID),";
    $sql.= "  FULLTEXT KEY TITLE (TITLE)";
    $sql.= ")";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Insert the old threads into the new table along with the FROM_UID
    // of the POST table as the BY_UID column.

    $sql = "INSERT INTO {$forum_webtag}_THREAD_NEW (TID, FID, ";
    $sql.= "BY_UID, TITLE, LENGTH, POLL_FLAG, MODIFIED, CLOSED, ";
    $sql.= "STICKY, STICKY_UNTIL, ADMIN_LOCK) SELECT THREAD.TID, ";
    $sql.= "THREAD.FID, POST.FROM_UID, THREAD.TITLE, THREAD.LENGTH, ";
    $sql.= "THREAD.POLL_FLAG, THREAD.MODIFIED, THREAD.CLOSED, ";
    $sql.= "THREAD.STICKY, THREAD.STICKY_UNTIL, THREAD.ADMIN_LOCK ";
    $sql.= "FROM {$forum_webtag}_THREAD THREAD ";
    $sql.= "LEFT JOIN {$forum_webtag}_POST POST ON ";
    $sql.= "(POST.TID = THREAD.TID AND POST.PID = 1)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // DROP the old THREAD table

    $sql = "DROP TABLE {$forum_webtag}_THREAD";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Rename our new THREAD table

    $sql = "ALTER TABLE {$forum_webtag}_THREAD_NEW RENAME {$forum_webtag}_THREAD";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Visitor log has been changed to per-forum table.

    $sql = "CREATE TABLE {$forum_webtag}_VISITOR_LOG (";
    $sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
    $sql.= "  LAST_LOGON datetime DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (UID)";
    $sql.= ")";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the global visitor log. No point trying to fetch
    // the old values from it really, as there will be a lot
    // of duplicates that don't make any sense.

    $sql = "DROP TABLE VISITOR_LOG";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Bug in the SESSIONS table that prevents guests having
    // the same IP address from using the forum. Easier
    // to drop and recreate the table here with the new
    // indexes / keys.

    $sql = "DROP TABLE SESSIONS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE SESSIONS (";
    $sql.= "  HASH varchar(32) NOT NULL default '',";
    $sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
    $sql.= "  IPADDRESS varchar(15) NOT NULL default '',";
    $sql.= "  TIME datetime NOT NULL default '0000-00-00 00:00:00',";
    $sql.= "  FID mediumint(8) unsigned NOT NULL default '0',";
    $sql.= "  PRIMARY KEY  (HASH, UID, IPADDRESS)";
    $sql.= ")";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Bug in the timezone preference meant it was impossible
    // to set your timezone beyond -9.9 GMT

    $sql = "ALTER TABLE USER_PREFS CHANGE TIMEZONE ";
    $sql.= "TIMEZONE DECIMAL(3,1) DEFAULT '0.0' NOT NULL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Move the data from the previous WEBTAG-ed PM tables into
    // the globalised tables. Downside to this is that the MIDs
    // for some messages will change which will affect people's
    // email notification links, but this is better than
    // loosing people's PMs entirely!

    $sql = "SELECT * FROM {$forum_webtag}_PM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    while($pm_data = db_fetch_array($result)) {

        $sql = "INSERT INTO PM (TYPE, TO_UID, FROM_UID, SUBJECT, CREATED, NOTIFIED) ";
        $sql.= "VALUES ('{$pm_data['TYPE']}', '{$pm_data['TO_UID']}', '{$pm_data['FROM_UID']}', ";
        $sql.= "'{$pm_data['SUBJECT']}', '{$pm_data['CREATED']}', '{$pm_data['NOTIFIED']}')";

        if ($pm_result = db_query($sql, $db_install)) {

            $pm_mid = db_insert_id($db_install);

            $sql = "INSERT INTO PM_ATTACHMENT_IDS (MID, AID) ";
            $sql.= "SELECT $pm_mid, AID FROM {$forum_webtag}_PM_ATTACHMENT_IDS";

            if (!$result = db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

            $sql = "INSERT INTO PM_CONTENT (MID, CONTENT) ";
            $sql.= "SELECT $pm_mid, CONTENT FROM {$forum_webtag}_PM_CONTENT";

            if (!$result = db_query($sql, $db_install)) {

                $valid = false;
                return;
            }

        }else {

            $valid = false;
            return;
        }
    }

    // Drop the old PM table

    $sql = "DROP TABLE {$forum_webtag}_PM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the old PM_ATTACHMENT_IDS table

    $sql = "DROP TABLE {$forum_webtag}_PM_ATTACHMENT_IDS";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the old PM_CONTENT table

    $sql = "DROP TABLE {$forum_webtag}_PM_CONTENT";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the per-forum PM_NOTIFY column from USER_PREFS

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS DROP PM_NOTIFY";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the per-forum PM_NOTIFY_EMAIL column from USER_PREFS

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS DROP PM_NOTIFY_EMAIL";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the per-forum PM_SAVE_SENT_ITEM column from USER_PREFS

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS DROP PM_SAVE_SENT_ITEM";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the per-forum PM_INCLUDE_REPLY column from USER_PREFS

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS DROP PM_INCLUDE_REPLY";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the per-forum PM_AUTO_PRUNE column from USER_PREFS

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS DROP PM_AUTO_PRUNE";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    // Drop the per-forum PM_AUTO_PRUNE_LENGTH column from USER_PREFS

    $sql = "ALTER TABLE {$forum_webtag}_USER_PREFS DROP PM_AUTO_PRUNE_LENGTH";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

// Create the table for the dictionary

$sql = "CREATE TABLE DICTIONARY (";
$sql.= "  WORD varchar(64) NOT NULL default '',";
$sql.= "  SOUND varchar(64) NOT NULL default '',";
$sql.= "  UID mediumint(8) unsigned NOT NULL default '0',";
$sql.= "  KEY SOUND (SOUND),";
$sql.= "  KEY UID (UID),";
$sql.= "  KEY WORD (WORD)";
$sql.= ")";

if (!$result = db_query($sql, $db_install)) {

    $valid = false;
    return;
}

// Import English dictionary

$dictionary_words = file('./install/english.dic');

foreach($dictionary_words as $word) {

    $metaphone = addslashes(metaphone(trim($word)));
    $word = addslashes(trim($word));

    $sql = "INSERT INTO DICTIONARY (WORD, SOUND, UID) ";
    $sql.= "VALUES ('$word', '$metaphone', 0)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>