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

/* $Id: logon.php,v 1.178 2007-12-26 13:19:34 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Retrieve the final_uri request

if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

    $final_uri = basename(trim(_stripslashes($_GET['final_uri'])));;

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "discussion.php?webtag=$webtag&amp;msg=". $_GET['msg'];

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "discussion.php?webtag=$webtag&amp;folder=". $_GET['folder'];

}elseif (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

    $final_uri = "pm.php?webtag=$webtag&amp;mid=". $_GET['pmid'];
}

// If the final_uri contains logout.php then unset it.

if (isset($final_uri) && strstr($final_uri, 'logout.php')) {
    unset($final_uri);
}

// Logon script doesn't redirect if the session isn't created

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Load language file

$lang = load_language_file();

// Fetch the forum webtag

$webtag = get_webtag($webtag_search);

// Retrieve existing cookie data if any

logon_get_cookies($username_array, $password_array, $passhash_array);

// Delete the user's cookie as requested and send them back to the login form.

if (isset($_GET['deletecookie']) && $_GET['deletecookie'] == 'yes') {

    bh_remove_all_cookies();

    bh_setcookie("bh_logon", "1");

    if (isset($final_uri)) {

        $final_uri = rawurlencode($final_uri);
        header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", $lang['cookiessuccessfullydeleted']);

    }else {

        header_redirect("index.php?webtag=$webtag", $lang['cookiessuccessfullydeleted']);
    }

}elseif (isset($_POST['logon']) || isset($_POST['guest_logon'])) {

    if (logon_perform(true)) {

        if (isset($final_uri)) {

            $final_uri = rawurlencode($final_uri);
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", $lang['loggedinsuccessfully']);

        }else {

            header_redirect("index.php?webtag=$webtag", $lang['loggedinsuccessfully']);
        }

    }else {

        if (!defined('BEEHIVEMODE_LIGHT')) bh_setcookie("bh_logon_failed", "1");

        if (isset($final_uri)) {

            $final_uri = rawurlencode($final_uri);
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", $lang['usernameorpasswdnotvalid']);

        }else {

            header_redirect("index.php?webtag=$webtag", $lang['usernameorpasswdnotvalid']);
        }
    }

}elseif (isset($_POST['other_logon'])) {

    if (isset($final_uri)) {

        $final_uri = rawurlencode($final_uri);
        header_redirect("index.php?webtag=$webtag&other_logon=true&final_uri=$final_uri");

    }else {

        header_redirect("index.php?webtag=$webtag&other_logon=true");
    }
}

html_draw_top('logon.js');

echo "<div align=\"center\">\n";

logon_draw_form();

echo "</div>\n";

html_draw_bottom();

?>