<?php

/*======================================================================
Copyright Chris Hodcroft <chris@hodcroft.net> 2002

This file is part of Beehive.

Beehive is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  
USA
======================================================================*/

// PROVIDES BASIC DATABASE FUNCTIONALITY
// This is desgined to be be referenced in an include() or require() statement
// in any script where access to the database is needed. Use these functions
// instead of the usual database functions.

// Connects to the database and returns the connection ID
function db_connect ()
{
	require ("./include/config.inc.php"); // requires database information
	$connection_id = mysql_connect($db_server, $db_username, $db_password) or die(mysql_error());
	mysql_select_db($db_database, $connection_id) or die(mysql_error());
	return $connection_id;
}

// Disconnects from the database (PHP does this anyway when a script termintates, 
// but it's nice to be tidy). Pass the connection ID to the function
function db_disconnect ($connection_id)
{
	if ($connection_id) mysql_close($connection_id);
}

// Executes a query on the database and returns a resource ID
function db_query ($sql, $connection_id)
{
	$resource_id = mysql_query($sql, $connection_id) or die("Invalid query:" . $sql);
	return $resource_id;
}

// Returns the number of rows affected by a SELECT query when passed the resource ID
function db_num_rows ($resource_id)
{
	$num_rows = mysql_num_rows($resource_id);
	return $num_rows;
}

// Returns a result array when passed the resource ID - this is superior to mysql_fetch_row(), and can be used in exactly the same way
function db_fetch_array ($resource_id)
{
	$results = mysql_fetch_array($resource_id);
	return $results;
}

?>
