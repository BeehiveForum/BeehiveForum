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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

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

    } else {

        if (isset($_POST['forum_passhash']) && is_md5($_POST['forum_passhash'])) {

            $forum_passhash = $_POST['forum_passhash'];

        } else {

            $forum_passhash = "";
        }
    }
}

// Check for a returning page.
if (isset($_POST['final_uri']) && strlen(trim(stripslashes_array($_POST['final_uri']))) > 0) {
    
    $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

    if (preg_match("/^$available_files_preg/u", trim(stripslashes_array($_POST['final_uri']))) > 0) {
        $final_uri = href_cleanup_query_keys($_POST['final_uri']);
    }
}

if (isset($final_uri)) {
    $redirect_uri = "index.php?webtag=$webtag&final_uri=". rawurlencode($final_uri);
} else {
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

// Log the user into the forum by setting a session cookie
// containing the forum's password as an MD5 hash.
html_set_cookie("sess_hash_{$webtag}", $forum_passhash);

// Redirect the user back to where they came from.
header_redirect($redirect_uri);

?>