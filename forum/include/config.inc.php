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

/* $Id: config.inc.php,v 1.74 2004-04-10 21:45:32 decoyduck Exp $ */

// MAIN CONFIGURATION FILE

// Database stuff ------------------------------------------------------

$db_server   = "localhost";     // the address of your MySQL server
$db_username = "beehiveforum";  // your MySQL username
$db_password = "password";      // your MySQL password
$db_database = "beehiveforum";  // the name of your MySQL database

// Default settings ----------------------------------------------------

// IMPORTANT: As of BeehiveForum 0.4.1 the additional settings in config.inc.php have
//            been moved to a database table. The default settings below are only used
//            if the customised ones cannot be retrieved from the database. Under 
//            normal operation these settings will be ignored.

$forum_settings = array('forum_name'                => "A Beehive Forum",
                        'forum_email'               => "admin@abeehiveforum.net",
                        'default_style'             => "default",
                        'default_emoticons'         => "default",
                        'default_language'          => "en",
                        'show_friendly_errors'      => 'Y',
                        'cookie_domain'             => "",
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
                        'attachments_show_deleted'  => "N",
                        'attachment_allow_embed'    => "N",
                        'attachment_use_old_method' => "N",
                        'guest_account_enabled'     => "Y",
                        'session_cutoff'            => "86400",
                        'active_sess_cutoff'        => "900",
                        'gzip_compress_output'      => "Y",
                        'gzip_compress_level'       => "1");

?>