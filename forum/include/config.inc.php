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

// MAIN CONFIGURATION FILE

// Database stuff ------------------------------------------------------

$db_server   = "localhost";     // the address of your MySQL server
$db_username = "beehiveforum";  // your MySQL username
$db_password = "password";      // your MySQL password
$db_database = "beehiveforum";  // the name of your MySQL database

// ---------------------------------------------------------------------

// Forum-specific ------------------------------------------------------

$forum_name    = "A Beehive Forum"; // the name of your forum
$forum_email   = "admin@abeehiveforum.net"; // admin email
$default_style = "default"; // the default forum style directory name
$default_language = "en"; // default language for the forum

// ---------------------------------------------------------------------

// Debugging -----------------------------------------------------------

$show_friendly_errors = true; // Should Beehive replace PHP's default
                              // error handler? If you have problems
                              // with blank pages, etc, you should try
                              // turning this option off to see if it
                              // goes away.

$debug_level = 1;             // Specifies the level of debugging info
                              // that is shown at the bottom of each page.
                              // A value of 0 (default) turns off the debug
                              // output. 1 shows a basic report including
                              // time taken to process the script, number
                              // of queries used and the status of the gzip
                              // compression. A level of 2 includes the basic
                              // report as well as a list of all the queries
                              // used to generate the current page.

// ---------------------------------------------------------------------

// Cookie options ------------------------------------------------------

$cookie_domain = ""; // Specifies the domain name that the cookies set
                     // by Beehive should use. This is useful for
                     // situations where there is more than one
                     // access point for your forum.
                     //
                     // For example, both of the following URLs are
                     // valid access points for the *same* forum:
                     //
                     // http://forum.mybeehiveforum.net/
                     // http://www.mybeehiveforum.net/forum/
                     //
                     // To prevent users from having to login in twice
                     // at each access point, you could set the
                     // $cookie_domain value to "mybeehiveforum.net"
                     // and the cookies for both the logon page and
                     // the main session cookies will work for both
                     // URLs.
                     //
                     // WARNING: Do not change this if you do not
                     //          understand what it does. Setting it to
                     //          an invalid or incorrect value will
                     //          make it impossible for you to use
                     //          your forum.

// Forum options -------------------------------------------------------

$show_links = true;             // Show the links section
$auto_logon = true;             // Automatically logs on the user as a
                                // guest unless they have previously
                                // visited the logon page.

// ---------------------------------------------------------------------

// PM Options ----------------------------------------------------------

$show_pms = true;               // Show the Private Messages section
$pm_allow_attachments = true;   // Allow Private Messages to contain
                                // attachments.

// ---------------------------------------------------------------------

// Post stuff ----------------------------------------------------------

$maximum_post_length = 6226;    // maximum character-length of posts
$allow_post_editing = true;     // allow users to edit their posts
$post_edit_time = 0;            // time that users can edit posts for in
                                // hours after posting, 0 = infinite

// ---------------------------------------------------------------------

// Search stuff --------------------------------------------------------

$search_min_word_length = 3;    // Minimum word length that is allowed to
                                // to be searched for in AND and OR based
                                // searches. Words smaller than the value
                                // specified will be removed from the
                                // query automatically. Exact phrase
                                // searches are not effected by this
                                // setting.


// Attachment stuff ----------------------------------------------------

// Enable attachments. If you have limited webspace you
// may wish to disable attachments.

$attachments_enabled = true;

// Where to store the attachments on
// your server. This should be a sub-folder
// to your beehiveforum installation folder
// i.e. if your beehiveforum is installed in /forum/
// the attachments path would be /forum/attachments/

$attachment_dir = 'attachments';

// ---------------------------------------------------------------------


// Guest Account -------------------------------------------------------

$guest_account_enabled = true;  // Enable the use of forum guest account
                                // Requires the creation of a GUEST user
                                // with the password also set as GUEST.

// ---------------------------------------------------------------------


// GZIP Output Compression ---------------------------------------------

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

// To disable GZIP compression change the variable below to false

$gzip_compress_output = false;
$gzip_compress_level  = 1;

?>