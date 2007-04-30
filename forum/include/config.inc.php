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

/* $Id: config.inc.php,v 1.136 2007-04-30 22:42:24 decoyduck Exp $ */

// MAIN CONFIGURATION FILE

define('BEEHIVE_INSTALL_NOWARN', 1);

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

// Specifies the domain name and path that the cookies set by
// Beehive should use.
//
// WARNING: DO NOT CHANGE THIS OPTION IF YOU DO NOT UNDERSTAND WHAT
//          IT DOES. SETTING THIS OPTION TO AN INVALID OR INCORRECT
//          VALUE CAN MAKE YOUR FORUM UNUSABLE. IF YOU ARE IN DOUBT
//          LEAVE THIS SETTING AS IS.
//
// This option is useful for situations where there is more than one
// URI for your forum, for example where your forum is accessible
// from all of the following addresses:
//
// http://www.mybeehiveforum.net/forum/
// http://forum.mybeehiveforum.net/
// http://mybeehiveforum.net/forum/
//
// Usually cookies set at one address will be unavailable at the
// others which forces your users to login multiple times and keep
// multiple cookies if they visit the different sub-domains.
//
// To prevent this and force Beehive to use only one set of cookies
// and have them accessible from all addresses you would set the
// $cookie_domain value as follows:
//
// $cookie_domain = "mybeehiveforum.net/forum/";
//
// As you may have noticed the string used is common to all of
// addresses listed above and so any cookies set at any of the domains
// will be useable at the others.

// ---------------------------------------------------------------------

// GZIP Output Compression ---------------------------------------------

$gzip_compress_output = false;

$gzip_compress_level  = 1;

// This compresses the output of the PHP scripts using GZIP encoding.
// Compressing the output of the scripts can save you considerable
// amounts of bandwidth, but can also increase the CPU load on the
// server.
//
// WARNING: IF YOU ARE USING MOD_GZIP OR ANY OTHER GZIPPING MODULE
//          TO HANDLE THE COMPRESSION OF FILES ON YOUR WEB SERVER,
//          DO NOT ENABLE THE BUILT IN GZIP COMPRESSION IN BEEHIVE.
//          TO DO SO CAN MAKE YOUR FORUM UNUSABLE.
//
// You can also change the level of the gzip compression as long as PHP
// 4.2.0 is installed. The maximum level of compression available is 9,
// while the lowest is 1. A higher level will result in increased server
// load.

// ---------------------------------------------------------------------

// Frame top target ----------------------------------------------------

$frame_top_target = "_top";

// This option allows you to specify the "top" frame for Beehive to use
// when navigating between frames. If you intend to use your Beehive
// Forum embedded into another site (for example within an iframe)
// then you could change the value of this variable to match the name
// attribute of your iframe and prevent Beehive from breaking out of
// the frameset.
//
// Note: That when using Beehive within a iframe you should ensure that
//       it is running from the same domain as it's parent page
//       otherwise browsers may refuse the session cookies required
//       by Beehive and your users will not be able to login.

// ---------------------------------------------------------------------

?>