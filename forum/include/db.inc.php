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

// PROVIDES BASIC DATABASE FUNCTIONALITY
// This is desgined to be be referenced in an include() or require() statement
// in any script where access to the database is needed. Use these functions
// instead of the usual database functions.

// Connects to the database and returns the connection ID

require_once('./include/html.inc.php');
require_once('./include/form.inc.php');
require_once('./include/format.inc.php');

function db_connection_error()
{

    global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_POST_VARS;

    foreach ($HTTP_GET_VARS as $key => $value) {
      $getvars.= $key. '='. $value. '&';
    }

    $getvars = substr($getvars, 0, -1);

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>An error occured while trying to connect to the database. Please wait a few minutes and then click the Retry button below.</p>\n";
    echo "<p>As long as this browser window remains open, any form data you've submitted remains safe.</p>\n";
    echo "<form name=\"f_error\" method=\"post\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?$getvars\" target=\"_self\">\n";

    foreach ($HTTP_POST_VARS as $key => $value) {
      echo form_input_hidden($key, htmlspecialchars(_stripslashes($value))), "\n";
    }

    srand((double)microtime()*1000000);

    echo form_submit(md5(uniqid(rand())), 'Retry', 'onclick="document.location.reload();"'), "\n";
    echo "</form>\n";
    echo "</div>\n";
    html_draw_bottom();

}

function db_connect ()
{
    static $connection_id = false;
    
    if(!$connection_id){
    	require ("./include/config.inc.php"); // requires database information
    	$connection_id = @mysql_connect($db_server, $db_username, $db_password) or die(db_connection_error()); //or die(mysql_error());
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
	
	global $HTTP_SERVER_VARS;
	$resource_id = mysql_query($sql, $connection_id) or die("Invalid query:" . $sql . "<br />\n<br />\nMySQL Said: ". mysql_error(). "<br />\n<br />Page: \n". $HTTP_SERVER_VARS['PHP_SELF']);
	return $resource_id;
}

// Executes a query on the database and returns a resource ID
function db_unbuffered_query ($sql, $connection_id)
{

	global $HTTP_SERVER_VARS;
	if(function_exists("mysql_unbuffered_query")){
    	$resource_id = mysql_unbuffered_query($sql, $connection_id) or die("Invalid query:" . $sql . "<br />\n<br />\nMySQL Said: ". mysql_error(). "<br />\n<br />Page: \n". $HTTP_SERVER_VARS['PHP_SELF']);
    } else {
    	$resource_id = mysql_query($sql, $connection_id) or die("Invalid query:" . $sql . "<br />\n<br />\nMySQL Said: ". mysql_error(). "<br />\n<br />Page: \n". $HTTP_SERVER_VARS['PHP_SELF']);
    }
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