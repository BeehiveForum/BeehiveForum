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

/* $Id: config.inc.php,v 1.2 2004-05-09 14:50:58 decoyduck Exp $ */

// MAIN CONFIGURATION FILE

// define('BEEHIVE_INSTALLED', 1);

// Database stuff ------------------------------------------------------

$db_server   = "{db_server}";	// the address of your MySQL server
$db_username = "{db_username}";	// your MySQL username
$db_password = "{db_password}";	// your MySQL password
$db_database = "{db_database}";	// the name of your MySQL database

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

// Default settings ----------------------------------------------------

// IMPORTANT: As of BeehiveForum 0.5 the additional settings stored in
//            config.inc.php have been moved to a database table. The
//            settings below are only used if the customised ones cannot
//            be retrieved from the database. Under normal operation
//            these settings will be replaced by those in the database.

$default_settings = array('forum_name'                => "A Beehive Forum",
                          'forum_email'               => "admin@abeehiveforum.net",
                          'default_style'             => "default",
                          'default_emoticons'         => "default",
                          'default_language'          => "en",
                          'show_stats'                => "Y",
                          'show_links'                => "Y",
                          'auto_logon'                => "Y",
                          'show_pms'                  => "Y",
                          'pm_allow_attachments'      => "Y",
                          'maximum_post_length'       => "6226",
                          'allow_post_editing'        => "Y",
                          'post_edit_time'            => "0",
                          'allow_polls'               => "Y",
                          'search_min_word_length'    => "3",
                          'attachments_enabled'       => "Y",
                          'attachment_dir'            => "attachments",
                          'attachment_allow_embed'    => "N",
                          'attachment_use_old_method' => "N",
                          'guest_account_enabled'     => "Y",
                          'session_cutoff'            => "86400",
                          'active_sess_cutoff'        => "900");
?>