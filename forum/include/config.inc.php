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

$db_server   = "mysql.sourceforge.net";	// the address of your MySQL server
$db_username = "beehiveforum";	// your MySQL username
$db_password = "miffle";	// your MySQL password
$db_database = "beehiveforum";	// the name of your MySQL database

// ---------------------------------------------------------------------


// Forum-specific ------------------------------------------------------

$forum_name  = "A Beehive Forum"; // the name of your forum
$forum_email = "webmaster@yourdomain.com"; // admin email

// ---------------------------------------------------------------------


// Post stuff ----------------------------------------------------------

$maximum_post_length = 6226;	// maximum character-length of posts

// ---------------------------------------------------------------------


// Attachment stuff ----------------------------------------------------

// Hopefully won't need this from now on, as the attachments now use a
// relative path rather than the DOCUMENT_ROOT / SCRIPT_FILENAME;

/*if(isset($HTTP_SERVER_VARS['PATH_TRANSLATED'])){
    $path = dirname($HTTP_SERVER_VARS['PATH_TRANSLATED']);
} else if(isset($HTTP_SERVER_VARS['SCRIPT_FILENAME'])){
    $path = dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']);
} else if(isset($HTTP_ENV_VARS['PATH_TRANSLATED'])){
    $path = dirname($HTTP_ENV_VARS['PATH_TRANSLATED']);
} else {
    $path = ".";
} */

$attachment_dir = 'attachments';

// ---------------------------------------------------------------------

?>