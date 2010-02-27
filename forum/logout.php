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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Load the user session

$user_sess = bh_session_check(false);

// Fetch the forum webtag

$webtag = get_webtag();

// After we've logged out redirect somewhere

$final_uri = '';

if (isset($_REQUEST['final_uri']) && strlen(trim(stripslashes_array($_REQUEST['final_uri']))) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename(trim(stripslashes_array($_REQUEST['final_uri'])))) > 0) {
        $final_uri = basename(trim(stripslashes_array($_REQUEST['final_uri'])));
    } 
}

bh_session_end();

if (isset($_REQUEST['register'])) {
    
    $final_uri = rawurlencode("register.php?webtag=$webtag$final_uri");
    header_redirect("index.php?webtag=$webtag&final_uri=$final_uri");
    exit;
}

bh_setcookie("bh_logon", "1");
bh_setcookie("bh_auto_logon", "", time() - YEAR_IN_SECONDS);

if (user_is_guest()) {

    header_redirect("index.php?webtag=$webtag$final_uri");
    exit;

}else {

    header_redirect("index.php?webtag=$webtag&logout_success=true$final_uri");
    exit;
}

?>