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

/* $Id: forum_password.php,v 1.32 2009-02-27 13:35:12 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Get the webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

$lang = lang::get_instance()->load(__FILE__);

// User clicked Cancel so we send them to the My Forums page.

if (isset($_POST['cancel'])) {

    $redirect_uri = "index.php?webtag=$webtag&final_uri=forums.php%3Fwebtag%3D$webtag";
    header_redirect($redirect_uri);
}

// By default we have no password

$forum_passhash = "";
$forum_password = "";

// Check we have the password in the POST data

if (isset($_POST['forum_password'])) {

    $forum_password = stripslashes_array($_POST['forum_password']);

    if (strlen(trim($forum_password)) > 0) {

        $forum_passhash = md5($forum_password);
        $forum_password = str_repeat(chr(32), mb_strlen($forum_password));

    }else {

        if (isset($_POST['forum_passhash']) && is_md5($_POST['forum_passhash'])) {

            $forum_passhash = $_POST['forum_passhash'];

        }else {

            $forum_passhash = "";
        }
    }
}

// Check for a returning page.

if (isset($_POST['final_uri']) && strlen(trim(stripslashes_array($_POST['final_uri']))) > 0) {

    $final_uri = basename(trim(stripslashes_array($_POST['final_uri'])));
    $redirect_uri = "index.php?webtag=$webtag&final_uri=". rawurlencode($final_uri);

}else {

    $redirect_uri = "index.php?webtag=$webtag";
}

// Validate the return to page

if (isset($redirect_uri) && strlen(trim($redirect_uri)) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename($redirect_uri)) < 1) {
        $redirect_uri = "index.php?webtag=$webtag";
    }
}

// Now we just set a cookie and bounce the user back.
// The check will be automatically be done again
// and if the password matches they'll be able to
// access the forum.

if (isset($_POST['remember_password']) && $_POST['remember_password'] == "Y") {

    bh_setcookie("bh_{$webtag}_password", $forum_password, time() + YEAR_IN_SECONDS);
    bh_setcookie("bh_{$webtag}_passhash", $forum_passhash, time() + YEAR_IN_SECONDS);

}else {

    bh_setcookie("bh_{$webtag}_password", '', time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_{$webtag}_passhash", '', time() - YEAR_IN_SECONDS);
}

// Log the user into the forum by setting a session cookie
// containing the forum's password as an MD5 hash.

bh_setcookie("bh_{$webtag}_sesshash", $forum_passhash);

// Redirect the user back to where they came from.

header_redirect($redirect_uri);

?>