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

/* $Id: upgrade-06RC-to-06.php,v 1.1 2005-07-27 23:18:48 decoyduck Exp $ */

if (isset($_SERVER['argc']) && $_SERVER['argc'] > 0) {

    if (!strstr(basename($_SERVER['PHP_SELF']), $_SERVER['argv'][0])) {
        echo "Error: CLI Upgrade must be run from within install directory.";
        exit;
    }

    define("BH_INCLUDE_PATH", "../include/");

    include_once(BH_INCLUDE_PATH. "constants.inc.php");
    include_once(BH_INCLUDE_PATH. "db.inc.php");
    include_once(BH_INCLUDE_PATH. "install.inc.php");

    $remove_conflicts = true;

    $install_path = "";

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

        if (preg_match("/^--help/", $arg) > 0) {

            install_cli_show_upgrade_help();
            exit;
        }
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

    $db_install = db_connect();

    echo "Upgrading BeehiveForum to $beehive_version. Please wait...\n\n";

}elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "upgrade-06RC-to-06.php") {

    header("Request-URI: ../install.php");
    header("Content-Location: ../install.php");
    header("Location: ../install.php");
    exit;

}else {

    include_once(BH_INCLUDE_PATH. "constants.inc.php");
    include_once(BH_INCLUDE_PATH. "db.inc.php");
    include_once(BH_INCLUDE_PATH. "install.inc.php");
}

set_time_limit(0);

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

        while ($row = db_fetch_array($result)) {

            $forum_webtag_array[$row['FID']] = $row['WEBTAG'];
        }

    }else {

        $error_html.= "<h2>Could not locate any previous BeehiveForum installations!</h2>\n";
        $valid = false;
        return;
    }
}

$remove_tables = array('SEARCH_RESULTS');

foreach ($remove_tables as $forum_table) {

    $sql = "DROP TABLE IF EXISTS {$forum_table}";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "CREATE TABLE SEARCH_RESULTS (";
$sql.= "    UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    BY_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "    CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
$sql.= "    KEY UID (UID)";
$sql.= ") TYPE=MYISAM";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

?>