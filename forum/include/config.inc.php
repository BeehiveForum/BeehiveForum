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

$db_server   = "localhost";	// the address of your MySQL server
$db_username = "beehiveforum";	// your MySQL username
$db_password = "miffle";	// your MySQL password
$db_database = "beehiveforum";	// the name of your MySQL database

// ---------------------------------------------------------------------


// Forum-specific ------------------------------------------------------

$forum_name  = "A Beehive Forum"; // the name of your forum
$forum_email = "webmaster@yourdomain.com"; // admin email
$default_style = "default"; // the default forum style directory name

// ---------------------------------------------------------------------


// Post stuff ----------------------------------------------------------

$maximum_post_length = 6226;	// maximum character-length of posts

// ---------------------------------------------------------------------


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
// server

// To disable GZIP compression change the variable below to false

$gzip_compress_output = true;

?>