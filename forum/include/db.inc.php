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

/* $Id: db.inc.php,v 1.48 2004-04-19 01:42:55 decoyduck Exp $ */

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");

// Connects to the database and returns the connection ID

function db_connect ()
{
    global $db_server, $db_username, $db_password, $db_database, $default_settings;
    static $connection_id = false;

    if (!$connection_id) {

        if ($connection_id = @mysql_connect($db_server, $db_username, $db_password)) {
            if (@mysql_select_db($db_database, $connection_id)) {
                return $connection_id;
            }
        }

        if (isset($default_settings['show_friendly_errors']) && $default_settings['show_friendly_errors'] == "Y") {
	    trigger_error(BH_DB_CONNECT_ERROR, FATAL);
	}else {
	    trigger_error("Could not connect to database. Please check the details in config.inc.php.", E_USER_ERROR);
        }
    }

    return $connection_id;
}

// Disconnects from the database (PHP does this anyway when a script termintates,
// but it's nice to be tidy). Pass the connection ID to the function

function db_disconnect ($connection_id)
{
    //if ($connection_id) mysql_close($connection_id);
    return true;
}

// Executes a query on the database and returns a resource ID

function db_query ($sql, $connection_id)
{
    if ($resource_id = mysql_query($sql, $connection_id)) {
        return $resource_id;
    }else {
        $mysql_error = mysql_error($connection_id);
        trigger_error("<p>SQL: $sql</p><p>MySQL Said: $mysql_error</p>", FATAL);
    }
}

// Executes a query on the database and returns a resource ID

function db_unbuffered_query ($sql, $connection_id)
{
    if (function_exists("mysql_unbuffered_query")) {
        if ($resource_id = mysql_unbuffered_query($sql, $connection_id)) {
            return $resource_id;
        }else {
            $mysql_error = mysql_error($connection_id);
            trigger_error("<p>SQL: $sql</p><p>MySQL Said: $mysql_error</p>", FATAL);
	}
    }else {
        db_query($sql, $connection_id);
    }

    return $resource_id;
}

// Returns the number of rows affected by a SELECT query when passed the resource ID
function db_num_rows ($resource_id)
{
    $num_rows = mysql_num_rows($resource_id);
    return $num_rows;
}

// Returns the number of rows affected by a query when passed the connection ID
function db_affected_rows($connection_id)
{
    $results = mysql_affected_rows($connection_id);
    return $results;
}

// Returns a result array when passed the resource ID - this is superior to mysql_fetch_row(), and can be used in exactly the same way
function db_fetch_array ($resource_id, $result_type = MYSQL_BOTH)
{
    $results = mysql_fetch_array($resource_id, $result_type);
    return $results;
}

// Seeks to the specified row in a SELECT query (0 based)
function db_data_seek ($resource_id, $row_number)
{
    $seek_result = @mysql_data_seek($resource_id, $row_number);
    return $seek_result;
}

// Returns the AUTO_INCREMENT ID from the last insert statement
function db_insert_id($resource_id)
{
    $insert_id = mysql_insert_id($resource_id);
    return $insert_id;
}

?>