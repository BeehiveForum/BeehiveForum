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

/* $Id: forum_password.php,v 1.1 2004-06-19 11:30:33 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");

// Load language file

$lang = load_language_file();

// Check we have a webtag. We do this differently
// to all the other pages otherwise we'd just trigger
// the display of the password dialog again.

if (isset($_GET['webtag'])) {
    $webtag = trim($_GET['webtag']);
}else if (isset($_POST['webtag'])) {
    $webtag = trim($_POST['webtag']);
}else {
    $webtag = false;
}

// Check we have the password in the POST data

if (isset($_POST['forum_password']) && strlen(trim($_POST['forum_password'])) > 0) {
    $forum_password = $_POST['forum_password'];
}else {
    $forum_password = "";
}

if (isset($_POST['ret']) && strlen(trim($_POST['ret'])) > 0) {
    $ret = "./index.php?webtag=$webtag&final_uri=". rawurlencode($_POST['ret']);
}else {
    $ret = "./index.php?webtag=$webtag";
}

// Now we just set a cookie and bounce the user back.
// The check will be automatically be done again
// and if the password matches they'll be able to
// access the forum.

bh_setcookie("{$webtag}_PASSWORD", $forum_password);

header_redirect($ret);

?>