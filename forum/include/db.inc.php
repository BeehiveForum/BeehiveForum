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

/* $Id: db.inc.php,v 1.36 2003-09-09 15:16:27 decoyduck Exp $ */

// PROVIDES BASIC DATABASE FUNCTIONALITY
// This is desgined to be be referenced in an include() or require() statement
// in any script where access to the database is needed. Use these functions
// instead of the usual database functions.

// Connects to the database and returns the connection ID

$query_count = 0;

function db_connect ()
{
    static $connection_id = false;

    if (!$connection_id) {
        require ("./include/config.inc.php"); // requires database information
        $connection_id = @mysql_connect($db_server, $db_username, $db_password) or trigger_error("An error has occured while connecting to the database.", FATAL);

        mysql_select_db($db_database, $connection_id) or die(mysql_error());
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
    global $HTTP_SERVER_VARS, $query_count;

    $resource_id = mysql_query($sql, $connection_id) or trigger_error("Invalid query:$sql<br />\nMySQL Said: ". mysql_error(), FATAL);
    $query_count++;
    return $resource_id;
}

// Executes a query on the database and returns a resource ID
function db_unbuffered_query ($sql, $connection_id)
{
    global $HTTP_SERVER_VARS, $query_count;

    if (function_exists("mysql_unbuffered_query")) {
        $resource_id = mysql_unbuffered_query($sql, $connection_id) or trigger_error("Invalid query:$sql<br />\nMySQL Said: ". mysql_error(), FATAL);
    }else {
        $resource_id = mysql_query($sql, $connection_id) or trigger_error("Invalid query:$sql<br />\nMySQL Said: ". mysql_error(), FATAL);
    }

    $query_count++;
    return $resource_id;
}

// Returns the number of rows affected by a SELECT query when passed the resource ID
function db_num_rows ($resource_id)
{
    $num_rows = mysql_num_rows($resource_id);
    return $num_rows;
}

// Returns the number of rows affected by a query when passed the connection ID
function db_affected_rows($onnection_id)
{
    $results = mysql_affected_rows($onnection_id);
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