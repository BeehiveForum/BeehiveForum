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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
}

// Include files we need.
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

function db_get_connection_vars(&$db_server, &$db_port, &$db_username, &$db_password, &$db_database)
{
    $db_server   = (isset($GLOBALS['db_server']))   ? $GLOBALS['db_server']   : '';
    $db_port     = (isset($GLOBALS['db_port']))     ? $GLOBALS['db_port']     : '3306';
    $db_username = (isset($GLOBALS['db_username'])) ? $GLOBALS['db_username'] : '';
    $db_password = (isset($GLOBALS['db_password'])) ? $GLOBALS['db_password'] : '';
    $db_database = (isset($GLOBALS['db_database'])) ? $GLOBALS['db_database'] : '';
}

function db_connect()
{
    static $connection_id = false;

    db_get_connection_vars($db_server, $db_port, $db_username, $db_password, $db_database);

    if (!$connection_id) {

        if (!($connection_id = @mysqli_connect($db_server, $db_username, $db_password, $db_database, $db_port))) {
            throw new Exception('Could not connect to database server. Check your MySQL user credentials', MYSQL_CONNECT_ERROR);
        }

        if (!db_set_utf8_charset($connection_id)) {
            throw new Exception('Could not enable UTF-8 mode. Check your MySQL user permissions.', db_errno());
        }

        if (!db_set_time_zone_utc($connection_id)) {
            throw new Exception('Could not set MySQL timezone to UTC. Check your MySQL user permissions.', db_errno());
        }

        if (!db_enable_compat_mode($connection_id)) {
            throw new Exception('Could not change MYSQL compatbility options. Check your MySQL user permissions.', db_errno());
        }

        if (!db_enable_no_auto_value($connection_id)) {
            throw new Exception('Could not set MySQL Session Variable SQL_MODE. Check your MySQL user permissions.', db_errno());
        }
    }

    return $connection_id;
}

function db_set_utf8_charset($connection_id)
{
    $sql = "SET NAMES 'utf8'";
    return db_query($sql, $connection_id);
}

function db_set_time_zone_utc($connection_id)
{
    $sql = "SET SESSION time_zone = '+0:00'";
    return db_query($sql, $connection_id);
}

function db_enable_compat_mode($connection_id)
{
    $mysql_big_selects = isset($GLOBALS['mysql_big_selects']) ? $GLOBALS['mysql_big_selects'] : false;

    if (isset($mysql_big_selects) && $mysql_big_selects === true) {

        $sql = "SET SESSION SQL_BIG_SELECTS = 1";
        if (!db_query($sql, $connection_id)) return false;

        $sql = "SET SESSION SQL_MAX_JOIN_SIZE = DEFAULT";
        if (!db_query($sql, $connection_id)) return false;
    }

    return true;
}

function db_enable_no_auto_value($connection_id)
{
    $sql = "SET SESSION SQL_MODE = NO_AUTO_VALUE_ON_ZERO";

    if (!db_query($sql, $connection_id)) return false;

    $sql = "SHOW SESSION VARIABLES LIKE 'SQL_MODE'";

    if (!($result = db_query($sql, $connection_id))) return false;

    if (db_num_rows($result) < 1) return false;

    list(, $value) = db_fetch_array($result, DB_RESULT_NUM);

    return ($value === 'NO_AUTO_VALUE_ON_ZERO');
}

function db_query($sql, $connection_id)
{
    if (!($result = mysqli_query($connection_id, $sql))) {
        throw new Exception(db_error($connection_id), db_errno($connection_id));
    }

    return $result;
}

function db_unbuffered_query($sql, $connection_id)
{
    return db_query($sql, $connection_id);
}

function db_num_rows($result)
{
    if (($num_rows = mysqli_num_rows($result))) {
        return $num_rows;
    }

    return 0;
}

function db_affected_rows($connection_id)
{
    if (($affected_rows = mysqli_affected_rows($connection_id))) {
        return $affected_rows;
    }

    return false;
}

function db_fetch_array($result, $result_type = DB_RESULT_BOTH)
{
    if (($result_array = mysqli_fetch_array($result, $result_type))) {
        return $result_array;
    }

    return false;
}

function db_insert_id($connection_id)
{
    if (($insert_id = mysqli_insert_id($connection_id))) {
        return $insert_id;
    }

    return false;
}

function db_error($connection_id = false)
{
    if ($connection_id !== false) {

        if (($errstr = mysqli_error($connection_id))) {
            return $errstr;
        }

    }else {

        if (($errstr = mysqli_error())) {
            return $errstr;
        }
    }

    return "Unknown Error";
}

function db_errno($connection_id = false)
{
    if ($connection_id !== false) {

        if (($errno = mysqli_errno($connection_id))) {
            return $errno;
        }

    }else {

        if (($errno = mysqli_errno())) {
            return $errno;
        }
    }

    return 0;
}

function db_fetch_mysql_version()
{
    static $mysql_version = false;

    if (!$mysql_version) {

        if (!($db_fetch_mysql_version = @db_connect())) return false;

        $sql = "SELECT VERSION() AS version";

        $result = db_query($sql, $db_fetch_mysql_version);

        if (!$version_data = db_fetch_array($result)) {

            $sql = "SHOW VARIABLES LIKE 'version'";
            $result = db_query($sql, $db_fetch_mysql_version);

            $version_data = db_fetch_array($result);
        }

        $version_array = explode(".", $version_data['version']);

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

function db_escape_string($str)
{
    $db_escape_string = db_connect();

    return mysqli_real_escape_string($db_escape_string, $str);
}

function db_ping($connection_id)
{
    return mysqli_ping($connection_id);
}

?>