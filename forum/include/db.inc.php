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

/* $Id: db.inc.php,v 1.60 2004-12-01 09:25:47 decoyduck Exp $ */

if (@file_exists("./include/config.inc.php")) {
    include_once("./include/config.inc.php");
}

include_once("./include/constants.inc.php");

// Connects to the database and returns the connection ID

function db_connect ()
{
    global $db_server, $db_username, $db_password, $db_database, $show_friendly_errors;

    static $connection_id = false;

    if (@extension_loaded('mysql')) {

        if (!$connection_id) {

            if ($connection_id = mysql_connect($db_server, $db_username, $db_password)) {

                if (mysql_select_db($db_database, $connection_id)) {

                    if (isset($mysql_big_selects) && $mysql_big_selects == true) {

                        $sql = "SET OPTION SQL_BIG_SELECTS = 1";
                        db_query($sql, $connection_id);
                    }

                    return $connection_id;
                }
            }

            if (isset($show_friendly_errors) && is_bool($show_friendly_errors) && $show_friendly_errors == true) {

                 trigger_error(BH_DB_CONNECT_ERROR, E_USER_ERROR);

            }else {

                trigger_error("Could not connect to database. Please check the details in config.inc.php.", E_USER_ERROR);
            }
        }

        return $connection_id;
    }

    if (@extension_loaded('mysqli')) {

        if (!$connection_id) {

            if ($connection_id = mysqli_connect($db_server, $db_username, $db_password, $db_database)) {

                if (isset($mysql_big_selects) && $mysql_big_selects == true) {

                    $sql = "SET OPTION SQL_BIG_SELECTS = 1";
                    db_query($sql, $connection_id);
                }

                return $connection_id;
            }

            if (isset($show_friendly_errors) && is_bool($show_friendly_errors) && $show_friendly_errors == true) {

                 trigger_error(BH_DB_CONNECT_ERROR, E_USER_ERROR);

            }else {

                trigger_error("Could not connect to database. Please check the details in config.inc.php.", E_USER_ERROR);
            }
        }

        return $connection_id;
    }

    trigger_error("Could not connect to the database. Please check that the PHP MySQL or MySQLi extension is correctly installed!", E_USER_ERROR);
}

// Executes a query on the database and returns a resource ID

function db_query ($sql, $connection_id)
{
    if (@extension_loaded('mysql')) {

        if ($resource_id = mysql_query($sql, $connection_id)) {

            return $resource_id;

        }else {

            $mysql_error = mysql_error($connection_id);
            trigger_error("<p>SQL: $sql</p><p>MySQL Said: $mysql_error</p>", E_USER_ERROR);
        }
    }

    if (@extension_loaded('mysqli')) {

        if ($resource_id = mysqli_query($connection_id, $sql)) {

            return $resource_id;

        }else {

            $mysql_error = mysqli_error($connection_id);
            trigger_error("<p>SQL: $sql</p><p>MySQL Said: $mysql_error</p>", E_USER_ERROR);
        }
    }

    trigger_error("Could not perform query. Please check that the PHP MySQL or MySQLi extension is correctly installed!", E_USER_ERROR);
}

// Executes a query on the database and returns a resource ID

function db_unbuffered_query ($sql, $connection_id)
{
    if (@extension_loaded('mysql')) {

        if (function_exists("mysql_unbuffered_query")) {

            if ($resource_id = mysql_unbuffered_query($sql, $connection_id)) {

                return $resource_id;

            }else {

                $mysql_error = mysql_error($connection_id);
                trigger_error("<p>SQL: $sql</p><p>MySQL Said: $mysql_error</p>", E_USER_ERROR);
            }

        }else {

            $resource_id = db_query($sql, $connection_id);
            return $resource_id;
        }
    }

    if (@extension_loaded('mysqli')) {

        $resource_id = db_query($sql, $connection_id);
        return $resource_id;
    }

    trigger_error("Could not perform query. Please check that the PHP MySQL or MySQLi extension is correctly installed", E_USER_ERROR);
}

// Returns the number of rows affected by a SELECT query when passed the resource ID
function db_num_rows ($resource_id)
{
    if (@extension_loaded('mysql')) {

        $num_rows = mysql_num_rows($resource_id);
        return $num_rows;
    }

    if (@extension_loaded('mysqli')) {

        $num_rows = mysqli_num_rows($resource_id);
        return $num_rows;
    }

    trigger_error("Could not obtain row count. Please check that the PHP MySQL or MySQLi extension is correctly installed", E_USER_ERROR);
}

// Returns the number of rows affected by a query when passed the connection ID
function db_affected_rows($connection_id)
{
    if (@extension_loaded('mysql')) {

        $results = mysql_affected_rows($connection_id);
        return $results;
    }

    if (@extension_loaded('mysqli')) {

        $results = mysqli_affected_rows($connection_id);
        return $results;
    }

    trigger_error("Could not obtain affected row count. Please check that the PHP MySQL or MySQLi extension is correctly installed", E_USER_ERROR);
}

function db_fetch_array ($resource_id, $result_type = DB_RESULT_BOTH)
{
    if (@extension_loaded('mysql')) {

        $results = mysql_fetch_array($resource_id, $result_type);
        return $results;
    }

    if (@extension_loaded('mysqli')) {

       $results = mysqli_fetch_array($resource_id, $result_type);
       return $results;
    }

    trigger_error("Could not retrieve row. Please check that the PHP MySQL or MySQLi extension is correctly installed", E_USER_ERROR);
}

// Seeks to the specified row in a SELECT query (0 based)
function db_data_seek ($resource_id, $row_number)
{
    if (@extension_loaded('mysql')) {

        $seek_result = @mysql_data_seek($resource_id, $row_number);
        return $seek_result;
    }

    if (@extension_loaded('mysqli')) {

        $seek_result = @mysqli_data_seek($resource_id, $row_number);
        return $seek_result;
    }

    trigger_error("Could not perform row seek. Please check that the PHP MySQL or MySQLi extension is correctly installed", E_USER_ERROR);
}

// Returns the AUTO_INCREMENT ID from the last insert statement
function db_insert_id($resource_id)
{
    if (@extension_loaded('mysql')) {

        $insert_id = mysql_insert_id($resource_id);
        return $insert_id;
    }

    if (@extension_loaded('mysqli')) {

        $insert_id = mysqli_insert_id($resource_id);
        return $insert_id;
    }

    trigger_error("Could not fetch AUTO_INCREMENT ID. Please check that the PHP MySQL or MySQLi extension is correctly installed", E_USER_ERROR);
}

function db_error($resource_id)
{
    if (@extension_loaded('mysql')) {

        return mysql_error($resource_id);
    }

    if (@extension_loaded('mysqli')) {

        return mysqli_error($resource_id);
    }

    return "Error unknown";
}

// Return the MySQL Server Version.
// Adapted from phpMyAdmin (ahem!)

function db_fetch_mysql_version()
{
    static $mysql_version = false;

    if (!$mysql_version) {

        $db_fetch_mysql_version = db_connect();

        $sql = "SELECT VERSION() AS version";
        $result = @db_query($sql, $db_fetch_mysql_version);

        if (!$row = db_fetch_array($result)) {

            $sql = "SHOW VARIABLES LIKE 'version'";
            $result = @db_query($sql, $db_fetch_mysql_version);

            $row = db_fetch_array($result);
        }

        $version_array = explode(".", $row['version']);

        if (!isset($version_array) || !isset($version_array[0])) {
            $version_array[0] = 3;
        }

        if (!isset($version_array[1])) {
            $version_array[1] = 21;
        }

        if (!isset($version_array[2])) {
            $version_array[2] = 0;
        }

        $mysql_version = (int)sprintf('%d%02d%02d', $version_array[0], $version_array[1], intval($version_array[2]));
    }

    return $mysql_version;
}

?>
