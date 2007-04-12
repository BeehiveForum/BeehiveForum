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

/* $Id: forum_password.php,v 1.13 2007-04-12 13:23:10 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {

    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag. We do this differently
// to all the other pages otherwise we'd just trigger
// the display of the password dialog again.

if (isset($_GET['webtag'])) {
    $webtag = trim(_stripslashes($_GET['webtag']));
}else if (isset($_POST['webtag'])) {
    $webtag = trim(_stripslashes($_POST['webtag']));
}else {
    $webtag = false;
}

// User clicked Cancel so we send them to the My Forums page.

if (isset($_POST['cancel'])) {
    $ret = "./index.php?final_uri=forums.php";
    header_redirect($ret);
}

// Check we have the password in the POST data

if (isset($_POST['forum_password']) && strlen(trim(_stripslashes($_POST['forum_password']))) > 0) {
    $forum_password = $_POST['forum_password'];
}else {
    $forum_password = "";
}

if (isset($_POST['ret']) && strlen(trim(_stripslashes($_POST['ret']))) > 0) {
    $ret = "index.php?webtag=$webtag&final_uri=". rawurlencode($_POST['ret']);
}else {
    $ret = "index.php?webtag=$webtag";
}

// validate the return to page

if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/", basename($ret)) < 1) {
        $ret = "index.php?webtag=$webtag";
    }
}

// Now we just set a cookie and bounce the user back.
// The check will be automatically be done again
// and if the password matches they'll be able to
// access the forum.

if (isset($_POST['remember_password']) && $_POST['remember_password'] == "Y") {
    bh_setcookie("bh_{$webtag}_password", $forum_password, time() + YEAR_IN_SECONDS);
}else {
    bh_setcookie("bh_{$webtag}_password", $forum_password);
}

header_redirect($ret);

?>