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

/* $Id: upgrade-06x-to-064.php,v 1.6 2006-05-20 12:22:12 decoyduck Exp $ */

if (isset($_SERVER['argc']) && $_SERVER['argc'] > 0) {

    if (strstr(php_sapi_name(), 'cgi')) {

        $install_cgi_mode  = true;
        $install_cgi_valid = false;

        $current_directory = basename(getcwd());

    }else {

        $install_cgi_mode  = false;
        $install_cgi_valid = false;

        $current_directory = preg_replace('/\\\/', '/', getcwd());

        if (!strstr(basename($_SERVER['PHP_SELF']), $_SERVER['argv'][0])) {
            echo "Error: CLI Upgrade must be run from within install directory.\n";
            exit;
        }
    }

    define("BH_INCLUDE_PATH", "../include/");

    include_once(BH_INCLUDE_PATH. "constants.inc.php");
    include_once(BH_INCLUDE_PATH. "db.inc.php");
    include_once(BH_INCLUDE_PATH. "install.inc.php");

    $remove_conflicts = true;

    $beehive_version = BEEHIVE_VERSION;

    foreach($_SERVER['argv'] as $arg) {

        if (preg_match("/^-h(.+)/", $arg, $hostname_matches) > 0) {
            $db_server = $hostname_matches[1];
        }

        if (preg_match("/^-u(.+)/", $arg, $username_matches) > 0) {
            $db_username = $username_matches[1];
        }

        if (preg_match("/^-p(.+)/", $arg, $password_matches) > 0) {
            $db_password = $password_matches[1];
        }

        if (preg_match("/^-D(.+)/", $arg, $database_matches) > 0) {
            $db_database = $database_matches[1];
        }

        if (preg_match("/^-Cq/", $arg) > 0) {
            $install_cgi_valid = true;
        }

        if (preg_match("/^--help/", $arg) > 0) {

            install_cli_show_upgrade_help();
            exit;
        }
    }

    if ($install_cgi_mode === true && $install_cgi_valid === false) {
        echo "When using PHP CGI binary you must specify -Cq option.\n\n";
        install_cli_show_help();
        exit;
    }

    if (!isset($db_server)) {
        echo "Must provide a MySQL hostname with -h option.\n";
        install_cli_show_upgrade_help();
        exit;
    }

    if (!isset($db_username)) {
        echo "Must provide a MySQL username with -u option.\n";
        install_cli_show_upgrade_help();
        exit;
    }

    if (!isset($db_password)) {
        echo "Must provide a MySQL password with -p option.\n";
        install_cli_show_upgrade_help();
        exit;
    }

    if (!isset($db_database)) {
        echo "Must provide a MySQL database name with -D option.\n";
        install_cli_show_upgrade_help();
        exit;
    }

    if (!$db_install = @db_connect()) {
        echo "Database connection to '$db_server' could not be established or permission is denied.\n";
        exit;
    }

    echo "Upgrading BeehiveForum to $beehive_version. Please wait...\n\n";

}elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-061-to-062.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;

}else {

    if (strstr(php_sapi_name(), 'cgi')) {
        $install_cgi_mode = true;
    }else {
        $install_cgi_mode = false;
    }

    include_once(BH_INCLUDE_PATH. "constants.inc.php");
    include_once(BH_INCLUDE_PATH. "db.inc.php");
    include_once(BH_INCLUDE_PATH. "install.inc.php");
}

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

$remove_tables = array('SEARCH_KEYWORDS', 'SEARCH_MATCH', 'SEARCH_POSTS', 'SEARCH_RESULTS');

foreach ($remove_tables as $forum_table) {

    $sql = "DROP TABLE IF EXISTS {$forum_table}";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

foreach($forum_webtag_array as $forum_fid => $forum_webtag) {

    if (isset($remove_conflicts) && $remove_conflicts === true) {

        $sql = "DROP TABLE IF EXISTS {$forum_webtag}_USER_TRACK";

        if (!$result = @db_query($sql, $db_install)) {

            $valid = false;
            return;
        }
    }
  
    $sql = "CREATE TABLE {$forum_webtag}_USER_TRACK (";
    $sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
    $sql.= "  DDKEY DATETIME DEFAULT NULL,";
    $sql.= "  LAST_POST DATETIME DEFAULT NULL,";
    $sql.= "  LAST_SEARCH DATETIME DEFAULT NULL,";
    $sql.= "  POST_COUNT MEDIUMINT(8) UNSIGNED DEFAULT NULL,";
    $sql.= "  USER_TIME DATETIME DEFAULT NULL, ";
    $sql.= "  PRIMARY KEY (UID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE IF EXISTS USER_TRACK";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "CREATE TABLE {$forum_webtag}_THREAD_NEW (";
    $sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
    $sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
    $sql.= "  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
    $sql.= "  TITLE VARCHAR(64) DEFAULT NULL, ";
    $sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
    $sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL, ";
    $sql.= "  CREATED DATETIME DEFAULT NULL, ";
    $sql.= "  MODIFIED DATETIME DEFAULT NULL, ";
    $sql.= "  CLOSED DATETIME DEFAULT NULL, ";
    $sql.= "  STICKY CHAR(1) DEFAULT NULL, ";
    $sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL, ";
    $sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL, ";
    $sql.= "  VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
    $sql.= "  PRIMARY KEY (TID), ";
    $sql.= "  KEY FID (FID), ";
    $sql.= "  KEY BY_UID (BY_UID)";
    $sql.= ") TYPE=MYISAM";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "INSERT INTO {$forum_webtag}_THREAD_NEW ";
    $sql.= "(TID, FID, BY_UID, TITLE, LENGTH, POLL_FLAG, CREATED, ";
    $sql.= "MODIFIED, CLOSED, STICKY, STICKY_UNTIL,ADMIN_LOCK, VIEWCOUNT) ";
    $sql.= "SELECT USER_THREAD.TID, THREAD.FID, THREAD.BY_UID, ";
    $sql.= "THREAD.TITLE, THREAD.LENGTH, THREAD.POLL_FLAG, ";
    $sql.= "THREAD.CREATED, THREAD.MODIFIED, THREAD.CLOSED, ";
    $sql.= "THREAD.STICKY, THREAD.STICKY_UNTIL, THREAD.ADMIN_LOCK, ";
    $sql.= "COUNT(USER_THREAD.LAST_READ) AS VIEWCOUNT ";
    $sql.= "FROM {$forum_webtag}_USER_THREAD USER_THREAD, ";
    $sql.= "{$forum_webtag}_THREAD THREAD ";
    $sql.= "WHERE THREAD.TID = USER_THREAD.TID ";
    $sql.= "GROUP BY USER_THREAD.TID";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "DROP TABLE {$forum_webtag}_THREAD";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_THREAD_NEW RENAME {$forum_webtag}_THREAD";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

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

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD MOVED_TID MEDIUMINT(8) UNSIGNED";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD MOVED_PID MEDIUMINT(8) UNSIGNED";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POST ADD INDEX (MOVED_TID, MOVED_PID)";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }

    $sql = "ALTER TABLE {$forum_webtag}_POST DROP INDEX TID";
    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_USER_POLL_VOTES ADD INDEX UID (UID)";
    $result = @db_query($sql, $db_install);

    $sql = "ALTER TABLE {$forum_webtag}_LINKS_FOLDERS CHANGE ";
    $sql.= "PARENT_FID PARENT_FID SMALLINT(5) UNSIGNED NULL";

    $result = @db_query($sql, $db_install);
}

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

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_TYPE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_AUTO_PRUNE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_FILE CHAR(1) DEFAULT '0' NOT NULL AFTER PM_EXPORT_TYPE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_ATTACHMENTS CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_FILE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_STYLE CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_ATTACHMENTS";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "ALTER TABLE USER_PREFS ADD PM_EXPORT_WORDFILTER CHAR(1) DEFAULT 'N' NOT NULL AFTER PM_EXPORT_STYLE";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "SHOW TABLES LIKE 'DICTIONARY'";

if (!$result = @db_query($sql, $db_install)) {

    $error_html.= "<h2>Could not locate any previous BeehiveForum installations!</h2>\n";
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