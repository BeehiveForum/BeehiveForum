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

/* $Id: upgrade-05-to-06.php,v 1.8 2005-01-23 23:50:55 decoyduck Exp $ */

if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-05pr1-to-05.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;

}else if (!isset($_SERVER['PHP_SELF'])) {

    echo "To install BeehiveForums 0.5 please visit install.php in your browser";
    exit;
}

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");

set_time_limit(0);

$forum_webtag_array = array();

// This script upgrades all forums it finds regardless of the
// WEBTAG entered in the install form. This is imperative that
// this happens because otherwise if you later try to upgrade
// a second forum you will run into problems

$sql = "SHOW TABLES LIKE 'FORUMS'";

if (!$result = db_query($sql, $db_install)) {

    $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
    $valid = false;
    return;
}

if (db_num_rows($result) > 0) {

    $sql = "SELECT FID, WEBTAG FROM FORUMS";

    if ($result = db_query($sql, $db_install)) {

        while ($row = db_fetch_array($result)) {

            $forum_webtag_array[$row['FID']] = $row['WEBTAG'];
        }
    }
}

$sql = "DROP TABLE IF EXISTS POST_ATTACHMENT_FILES";

if (!$result = db_query($sql, $db_install)) {

    $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_FILES (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  DELETED TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (ID),";
$sql.= "  KEY AID (AID),";
$sql.= "  KEY HASH (HASH)";
$sql.= ") TYPE=MyISAM";

if (!$result = db_query($sql, $db_install)) {

    $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
    $valid = false;
    return;
}

$sql = "DROP TABLE IF EXISTS POST_ATTACHMENT_IDS";

if (!$result = db_query($sql, $db_install)) {

    $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  PRIMARY KEY  (FID, TID, PID),";
$sql.= "  KEY AID (AID)";
$sql.= ") TYPE=MyISAM";

if (!$result = db_query($sql, $db_install)) {

    $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
    $valid = false;
    return;
}

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    // Improved ban controls allow banning of IP, LOGON
    // NICKNAME and EMAIL seperatly or in combinations.

    $sql = "CREATE TABLE {$forum_webtag}_BANNED (";
    $sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "  IPADDRESS CHAR(15) NOT NULL DEFAULT '',";
    $sql.= "  LOGON VARCHAR(32) DEFAULT NULL,";
    $sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL,";
    $sql.= "  EMAIL VARCHAR(80) DEFAULT NULL,";
    $sql.= "  PRIMARY KEY  (IP)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Insert the old IP addresses from the BANNED_IP table if any

    $sql = "INSERT INTO {$forum_webtag}_BANNED (IPADDRESS) ";
    $sql.= "SELECT IP FROM {$forum_webtag}_BANNED_IP";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Move the attachment file records into a global PAF table

    $sql = "INSERT INTO POST_ATTACHMENT_FILES (AID, UID, FILENAME, ";
    $sql.= "MIMETYPE, HASH, DOWNLOADS, DELETED) SELECT AID, UID, ";
    $sql.= "FILENAME, MIMETYPE, HASH, DOWNLOADS, DELETED ";
    $sql.= "FROM {$forum_webtag}_POST_ATTACHMENT_FILES ";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Move the attachment records into a global PAI table
    // along with the forum FID.

    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql.= "SELECT $forum_fid, TID, PID, AID ";
    $sql.= "FROM {$forum_webtag}_POST_ATTACHMENT_IDS ";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Need to recreate the THREAD table so we can add the
    // CREATED column from the POST table.

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_THREAD_NEW";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_THREAD_NEW (";
    $sql.= "  TID mediumint(8) unsigned NOT NULL auto_increment,";
    $sql.= "  FID mediumint(8) unsigned default NULL,";
    $sql.= "  BY_UID mediumint(8) unsigned default NULL,";
    $sql.= "  TITLE varchar(64) default NULL,";
    $sql.= "  LENGTH mediumint(8) unsigned default NULL,";
    $sql.= "  POLL_FLAG char(1) default NULL,";
    $sql.= "  CREATED datetime default NULL,";
    $sql.= "  MODIFIED datetime default NULL,";
    $sql.= "  CLOSED datetime default NULL,";
    $sql.= "  STICKY char(1) default NULL,";
    $sql.= "  STICKY_UNTIL datetime default NULL,";
    $sql.= "  ADMIN_LOCK datetime default NULL,";
    $sql.= "  PRIMARY KEY  (TID),";
    $sql.= "  KEY BY_UID (BY_UID),";
    $sql.= "  KEY FID (FID),";
    $sql.= "  FULLTEXT KEY TITLE (TITLE)";
    $sql.= ") TYPE=MyISAM";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Insert the old threads into the new table along with the FROM_UID
    // of the POST table as the BY_UID column.

    $sql = "INSERT INTO {$forum_webtag}_THREAD_NEW (TID, FID, ";
    $sql.= "BY_UID, TITLE, LENGTH, POLL_FLAG, CREATED, MODIFIED, ";
    $sql.= "CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) SELECT THREAD.TID, ";
    $sql.= "THREAD.FID, THREAD.BY_UID, THREAD.TITLE, THREAD.LENGTH, ";
    $sql.= "THREAD.POLL_FLAG, POST.CREATED, THREAD.MODIFIED, ";
    $sql.= "THREAD.CLOSED, THREAD.STICKY, THREAD.STICKY_UNTIL, ";
    $sql.= "THREAD.ADMIN_LOCK FROM {$forum_webtag}_THREAD THREAD ";
    $sql.= "LEFT JOIN {$forum_webtag}_POST POST ON ";
    $sql.= "(POST.TID = THREAD.TID AND POST.PID = 1)";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // DROP the old THREAD table

    $sql = "DROP TABLE {$forum_webtag}_THREAD";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Rename our new THREAD table

    $sql = "ALTER TABLE {$forum_webtag}_THREAD_NEW RENAME {$forum_webtag}_THREAD";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Add an index to the CREATED column in POST table.
    // POST table can be rather large so we do this
    // by rebuilding the table because otherwise
    // MySQL seems to fall over with the following error:
    // (Unable to write to /tmp/[file] error)

    $sql = "CREATE TABLE {$forum_webtag}_POST_NEW(";
    $sql.= "TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $sql.= "REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "VIEWED DATETIME DEFAULT NULL,";
    $sql.= "CREATED DATETIME DEFAULT NULL,";
    $sql.= "STATUS TINYINT(4) DEFAULT '0',";
    $sql.= "EDITED DATETIME DEFAULT NULL,";
    $sql.= "EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',";
    $sql.= "PRIMARY KEY (TID, PID),";
    $sql.= "KEY TO_UID (TO_UID),";
    $sql.= "KEY IPADDRESS (IPADDRESS),";
    $sql.= "KEY CREATED (CREATED)";
    $sql.= ") TYPE = MYISAM";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Transport the data from the old table into the new one.
    // This takes a long time. Upwards of 1 minute on a forum
    // with 300,000 messages.

    $sql = "INSERT INTO {$forum_webtag}_POST_NEW (TID, PID, REPLY_TO_PID, FROM_UID, ";
    $sql.= "TO_UID, VIEWED, CREATED, STATUS, EDITED, EDITED_BY, IPADDRESS) ";
    $sql.= "SELECT TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, ";
    $sql.= "CREATED, STATUS, EDITED, EDITED_BY, IPADDRESS FROM {$forum_webtag}_POST";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Get rid of the old POST table

    $sql = "DROP TABLE IF EXISTS {$forum_webtag}_POST";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Rename our new POST table

    $sql = "ALTER TABLE {$forum_webtag}_POST_NEW RENAME {$forum_webtag}_POST";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Reformat the USER_POLL_VOTES table to be less resource intensive
    // Unfortunatly this means purging the results because I don't think
    // it would make sense to try and reverse the MD5 hashing in the
    // PTUID, at least not with modern servers ;)

    $sql = "DELETE FROM {$forum_webtag}_USER_POLL_VOTES";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_POLL_VOTES DROP PTUID";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_POLL_VOTES DROP PRIMARY KEY, ADD PRIMARY KEY (ID)";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    // Lots of other indexes to make things go /fast/ (maybe)

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD ADD INDEX (LAST_READ) ";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_THREAD ADD INDEX (INTEREST) ";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_FOLDER ADD INDEX (INTEREST)";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_USER_PEER ADD INDEX (RELATIONSHIP)";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }

    $sql = "ALTER TABLE PM ADD INDEX (TYPE)";

    if (!$result = db_query($sql, $db_install)) {

        $error_html.= "<h2>MySQL said:". db_error($db_install). "</h2>\n";
        $valid = false;
        return;
    }
}

?>