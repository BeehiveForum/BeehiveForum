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

/* $Id: config.inc.php,v 1.124 2005-04-11 18:56:26 decoyduck Exp $ */

// MAIN CONFIGURATION FILE

define("BEEHIVE_INSTALL_NOWARN", 1);

// Database stuff ------------------------------------------------------

$db_server   = "localhost";    // the address of your MySQL server
$db_username = "beehiveforum";  // your MySQL username
$db_password = "password";  // your MySQL password
$db_database = "beehiveforum";  // the name of your MySQL database

// ---------------------------------------------------------------------

// MySQL Big Selects ---------------------------------------------------

$mysql_big_selects = false;

// Depending on the configuration of the MySQL server you may run into
// errors along the lines of: "The SELECT would examine too many records
// and probably take a very long time" when using Beehive. To attempt to
// prevent this from happening you can try turning this option on.

// ---------------------------------------------------------------------

// Error Handler -------------------------------------------------------

$show_friendly_errors = true;

// Should Beehive replace PHP's default error handler? If you have
// problems with blank pages, etc, you should try turning this option
// off to see if it goes away.

// ---------------------------------------------------------------------

// Cookie Domain -------------------------------------------------------

$cookie_domain = "";

// Specifies the domain name that the cookies set by Beehive should use.
// This is useful for situations where there is more than one access
// point for your forum.
//
// For example, both of the following URLs are valid access points for
// the *same* forum:
//
// http://forum.mybeehiveforum.net/
// http://www.mybeehiveforum.net/forum/
//
// To prevent users from having to login in twice at each access point,
// you could set the $cookie_domain value to "mybeehiveforum.net"
// and the cookies for both the logon page and the main session cookies
// will work for both URLs.
//
// Alternatively to force Beehive's cookies to only be valid at the
// second domain in the above list you could set the $cookie_domain
// value as "www.mybeehiveforum.net/forum/" and your users will then
// be unable to logon from anywhere but that address.
//
// WARNING: Do not change this if you do not understand what it does.
//          Setting it to an invalid or incorrect value may make it
//          impossible for you to use your forum.
//

// ---------------------------------------------------------------------

// GZIP Output Compression ---------------------------------------------

$gzip_compress_output = false;

$gzip_compress_level  = 1;

// This compresses the output of the PHP scripts using GZIP encoding.
// Compressing the output of the scripts can save you considerable
// amounts of bandwidth, but can also increase the CPU load on the
// server.
//
// As of Beehive 0.4 you can change the level of the gzip compression,
// as long as PHP 4.2.0 is installed. The maximum level of compression
// available is 9, while the lowest is 1. A higher level will result
// in increased server load.
//
// WARNING: If you are using mod_gzip or any other gzipping module
//          to handle the compression of PHP scripts on your web
//          server, do _NOT_ enable the built in GZIP compression
//          in Beehive, otherwise your forum may become inaccessible.

// ---------------------------------------------------------------------

?>