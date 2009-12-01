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

/* $Id: config.inc.php,v 1.154 2009-12-01 22:54:35 decoyduck Exp $ */

// MAIN CONFIGURATION FILE

define('BEEHIVE_INSTALL_NOWARN', 1);

// Database stuff ------------------------------------------------------

$db_server   = "localhost";     // The address of your MySQL server
$db_username = "beehiveforum";  // Your MySQL username
$db_password = "password";      // Your MySQL password
$db_database = "beehiveforum";  // The name of your MySQL database

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

// If you want Beehive to display user friendly error messages you can
// enable this option.
//
// Note: Under some circumstances this setting can cause problems
//       with PHP's error handler that result in blank pages
//       appearing instead of the appropriate error message.
//       If you encounter such issues you should consider
//       disabling this option.
//
// ---------------------------------------------------------------------

// Error Reporting Verbose Mode ----------------------------------------

$error_report_verbose = true;

// The Beehive Forum Error Handler can be configured to gather verbose
// details about any errors that occur, include HTTP Request and Cookie
// vars.
//
// WARNING: Verbose error reporting data may include user and system
//          credentials which may be used to compromise your server.
//          It is recommended that only enable verbose error reporting
//          on closed systems.

// ---------------------------------------------------------------------

// Error Reporting Email -----------------------------------------------

$error_report_email_addr_to = '';
$error_report_email_addr_from = 'no-reply@abeehiveforum.net';

// In addition to the error message displayed to end users Beehive can
// also send error reports to an email address. To enable this
// functionality simply change the value above to a valid email address.
//
// For example:
//
// $error_report_email_addr_to = 'support@mybeehiveforum.net'
//
// By default emails will be sent from 'no-reply@beehiveforum.net'.
// To change this you can also edit the $error_report_email_addr_from
// variable.

// Note: The no-reply email saved in the database is not used by the
//       Beehive Forum error handler in order to avoid logging another
//       error message trying to connect to a database server that is
//       not available.
//
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
// $cookie_domain = "mybeehiveforum.net/";
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
// Note: If you are using mod_gzip or any other gzipping module
//       to handle the compression of files on your web server,
//       do not enable the built in gzip compression in Beehive.
//       To do so can make your forum inaccessible.

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

// HTML client-side cache ----------------------------------------------

$http_cache_enabled = true;

// This option enables HTTP client-side caching of the thread list,
// messages and start pages. If you encounter issues with stale pages
// showing you can disable the cache by changing this value. Please
// note that the HTTP client-side caching is designed to help reduce
// bandwidth usage caused by repeated visits to the same page, and that
// disabling it may increase your forum's bandwidth usage.

// ---------------------------------------------------------------------

?>