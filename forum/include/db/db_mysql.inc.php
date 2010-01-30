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

function db_get_connection_vars(&$db_server, &$db_username, &$db_password, &$db_database)
{
    $db_server   = (isset($GLOBALS['db_server']))   ? $GLOBALS['db_server']   : '';
    $db_username = (isset($GLOBALS['db_username'])) ? $GLOBALS['db_username'] : '';
    $db_password = (isset($GLOBALS['db_password'])) ? $GLOBALS['db_password'] : '';
    $db_database = (isset($GLOBALS['db_database'])) ? $GLOBALS['db_database'] : '';
}

function db_connect($trigger_error = true)
{
    static $connection_id = false;

    db_get_connection_vars($db_server, $db_username, $db_password, $db_database);

    if (!$connection_id) {

        if (($connection_id = @mysql_connect($db_server, $db_username, $db_password))) {

            if (@mysql_select_db($db_database, $connection_id)) {

                db_set_utf8_charset($connection_id);
                
                db_set_time_zone_utc($connection_id);

                db_enable_compat_mode($connection_id);

                return $connection_id;
            }
        }

        if ($trigger_error === true) trigger_error(db_error(), E_USER_ERROR);

        return false;
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

    if (($mysql_version = db_fetch_mysql_version())) {

        if ($mysql_version >= 40100) {

            $sql = "SET SESSION SQL_MODE = ''";
            if (!db_query($sql, $connection_id)) return false;
        }
    }

    if (isset($mysql_big_selects) && $mysql_big_selects === true) {

        $sql = "SET SESSION SQL_BIG_SELECTS = 1";
        if (!db_query($sql, $connection_id)) return false;

        $sql = "SET SESSION SQL_MAX_JOIN_SIZE = DEFAULT";
        if (!db_query($sql, $connection_id)) return false;
    }

    return true;
}

function db_query($sql, $connection_id, $trigger_error = true)
{
    if (($result = @mysql_query($sql, $connection_id))) {
        return $result;
    }

    if ($trigger_error === true) db_trigger_error($sql, $connection_id);

    return false;
}

function db_unbuffered_query($sql, $connection_id, $trigger_error = true)
{
    if (function_exists("mysql_unbuffered_query")) {

        $GLOBALS['query_array'][] = $sql;
        
        if (($result = @mysql_unbuffered_query($sql, $connection_id))) {
            return $result;
        }

        if ($trigger_error === true) db_trigger_error($sql, $connection_id);
    }

    return db_query($sql, $connection_id, $trigger_error);
}

function db_data_seek($result, $offset)
{
    if (@mysql_data_seek($result, $offset)) {
        return true;
    }

    return false;
}

function db_num_rows($result)
{
    if (($num_rows = @mysql_num_rows($result))) {
        return $num_rows;
    }

    return 0;
}

function db_affected_rows($connection_id)
{
    if (($affected_rows = @mysql_affected_rows($connection_id))) {
        return $affected_rows;
    }

    return 0;
}

function db_fetch_array($result, $result_type = DB_RESULT_BOTH)
{
    if (($result_array = @mysql_fetch_array($result, $result_type))) {
        return $result_array;
    }

    return false;
}

function db_insert_id($connection_id)
{
    if (($insert_id = @mysql_insert_id($connection_id))) {
        return $insert_id;
    }

    return false;
}

function db_trigger_error($sql, $connection_id)
{
    if (error_reporting()) {

        if (!db_query($sql, $connection_id, false)) {

            $errno  = db_errno($connection_id);
            $errstr = db_error($connection_id);

            bh_error_handler($errno, "<p>$errstr</p>\n<p>$sql</p>");
        }
    }
}

function db_error($connection_id = false)
{
    if ($connection_id !== false) {

        if (($errstr = @mysql_error($connection_id))) {
            return $errstr;
        }

    }else {

        if (($errstr = @mysql_error())) {
            return $errstr;
        }
    }

    return "Unknown Error";
}

function db_errno($connection_id = false)
{
    if ($connection_id !== false) {

        if (($errno = @mysql_errno($connection_id))) {
            return $errno;
        }

    }else {

        if (($errno = @mysql_errno())) {
            return $errno;
        }
    }

    return 0;
}

function db_fetch_mysql_version()
{
    static $mysql_version = false;

    if (!$mysql_version) {
    
        if (!($db_fetch_mysql_version = db_connect(false))) return false;

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
    if (function_exists('mysql_real_escape_string')) {
        if (($db_escape_string = db_connect())) {
            return @mysql_real_escape_string($str, $db_escape_string);
        }
    }

    if (function_exists('mysql_escape_string')) {
        return @mysql_escape_string($str);
    }

    return addslashes($str);
}

?>