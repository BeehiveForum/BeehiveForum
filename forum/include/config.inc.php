<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// MAIN CONFIGURATION FILE

// Database stuff ------------------------------------------------------
$db_server = "mysql"; // The address of your MySQL server
$db_port = "3306"; // The port of your MySQL server
$db_username = "beehiveforum"; // Your MySQL username
$db_password = "password"; // Your MySQL password
$db_database = "beehiveforum"; // The name of your MySQL database

// ---------------------------------------------------------------------

// MySQL Big Selects ---------------------------------------------------

$mysql_big_selects = false;

// Depending on the configuration of the MySQL server you may run into
// errors along the lines of: "The SELECT would examine too many records
// and probably take a very long time" when using Beehive. To attempt to
// prevent this from happening you can try turning this option on.

// ---------------------------------------------------------------------

// Error Handler -------------------------------------------------------

$error_report_verbose = false;

// The Beehive Forum Error Handler can be configured to display verbose
// details about any errors that occur to the end user.
//
// WARNING: This setting is NOT recommended in production environments.
//          Verbose error reporting data may include user and system
//          credentials which may be used to compromise your server.
//          It is recommended that only enable verbose error reporting
//          on closed testing environments.

// ---------------------------------------------------------------------

// Error Reporting Email -----------------------------------------------

$error_report_email_addr_to = '';
$error_report_email_addr_from = 'no-reply@beehiveforum.co.uk';

// In addition to the error message displayed to end users Beehive can
// also send error reports to an email address. To enable this
// functionality simply change the value above to a valid email address.
//
// For example:
//
// $error_report_email_addr_to = 'support@beehiveforum.co.uk'
//
// By default emails will be sent from 'no-reply@beehiveforum.co.uk'.
// To change this you can also edit the $error_report_email_addr_from
// variable.

// Note: The no-reply email saved in the database is not used by the
//       Beehive Forum error handler in order to avoid logging another
//       error message trying to connect to a database server that is
//       not available.
//
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