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

/* $Id: logon.php,v 1.159 2006-06-30 18:07:33 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

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

    $final_uri = rawurldecode($_GET['final_uri']);

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "./discussion.php?webtag=$webtag&amp;msg=". $_GET['msg'];

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "./discussion.php?webtag=$webtag&amp;folder=". $_GET['folder'];

}elseif (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

    $final_uri = "./pm.php?webtag=$webtag&amp;mid=". $_GET['pmid'];
}

// If the final_uri contains logout.php then unset it.

if (isset($final_uri) && strstr($final_uri, 'logout.php')) {
    unset($final_uri);
}

// Logon script doesn't redirect if the session isn't created

$user_sess = bh_session_check(false);

// Load language file

$lang = load_language_file();

// Fetch the forum webtag

$webtag = get_webtag($webtag_search);

// Retrieve existing cookie data if any

// Username array

if (isset($_COOKIE['bh_remember_username']) && is_array($_COOKIE['bh_remember_username'])) {
    $username_array = $_COOKIE['bh_remember_username'];
}else {
    $username_array = array();
}

// Password array

if (isset($_COOKIE['bh_remember_password']) && is_array($_COOKIE['bh_remember_password'])) {
    $password_array = $_COOKIE['bh_remember_password'];
}else {
    $password_array = array();
}

// Passhash array

if (isset($_COOKIE['bh_remember_passhash']) && is_array($_COOKIE['bh_remember_passhash'])) {
    $passhash_array = $_COOKIE['bh_remember_passhash'];
}else {
    $passhash_array = array();
}

// Delete the user's cookie as requested and send them back to the login form.

if (isset($_GET['deletecookie']) && $_GET['deletecookie'] == 'yes') {

    for ($i = 0; $i < sizeof($username_array); $i++) {

        bh_setcookie("bh_remember_username[$i]", '', time() - YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_password[$i]", '', time() - YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_passhash[$i]", '', time() - YEAR_IN_SECONDS);
    }

    bh_session_end();

    bh_setcookie("bh_logon", "1");

    if (isset($final_uri)) {

        $final_uri = rawurlencode($final_uri);
        header_redirect("./index.php?webtag=$webtag&final_uri=$final_uri", $lang['cookiessuccessfullydeleted']);

    }else {

        header_redirect("./index.php?webtag=$webtag", $lang['cookiessuccessfullydeleted']);
    }

}elseif ((isset($_POST['user_logon']) && isset($_POST['user_password']) && (isset($_POST['user_passhash']) || isset($_GET['other']))) || isset($_POST['guest_logon'])) {

    if (perform_logon(true)) {

        if (isset($final_uri)) {

            $final_uri = rawurlencode($final_uri);
            header_redirect("./index.php?webtag=$webtag&final_uri=$final_uri", $lang['loggedinsuccessfully']);

        }else {

            header_redirect("./index.php?webtag=$webtag", $lang['loggedinsuccessfully']);
        }

    }else {

        html_draw_top();

        echo "<div align=\"center\">\n";
        echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
        echo "<h2>{$lang['pleasereenterpasswd']}</h2>\n";

        if (isset($final_uri)) {
            echo form_quick_button("./index.php", $lang['back'], "final_uri", rawurlencode($final_uri), "_top");
        }else {
            echo form_quick_button("./index.php", $lang['back'], false, false, "_top");
        }

        echo "<hr width=\"350\" />\n";
        echo "<h2>{$lang['problemsloggingon']}</h2>\n";

        if (isset($final_uri)) {

            $final_uri = rawurlencode($final_uri);

            if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
                echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"$frame_top_target\">{$lang['deletecookies']}</a></p>\n";
            }else {
                echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
            }

            echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";

        }else {

            if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
                echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"$frame_top_target\">{$lang['deletecookies']}</a></p>\n";
            }else {
                echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
            }

            echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
        }

        html_draw_bottom();
        exit;
    }
}

html_draw_top('logon.js');

draw_logon_form(true);

if (user_guest_enabled()) {

    if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
    
        echo "  <form name=\"guest\" action=\"", get_request_uri(), "\" method=\"post\" target=\"$frame_top_target\">\n";
        echo "    <p class=\"smalltext\">", sprintf($lang['enterasa'], form_submit('guest_logon', $lang['guest'])), "</p>\n";
        echo "  </form>\n";

    }else {

        echo "  <form name=\"guest\" action=\"", get_request_uri(), "\" method=\"post\" target=\"_top\">\n";
        echo "    <p class=\"smalltext\">", sprintf($lang['enterasa'], form_submit('guest_logon', $lang['guest'])), "</p>\n";
        echo "  </form>\n";
    }
}

if (isset($final_uri)) {

    $final_uri = rawurlencode($final_uri);

    echo "  <p class=\"smalltext\">", sprintf($lang['donthaveanaccount'], "<a href=\"register.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">{$lang['registernow']}</a>"), "</p>\n";
    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['problemsloggingon']}</h2>\n";

    if (isset($frame_top_target) && strlen($frame_top_target) > 0) {

        echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"$frame_top_target\">{$lang['deletecookies']}</a></p>\n";
        echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";

    }else {

        echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
        echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
    }

}else {

    echo "  <p class=\"smalltext\">", sprintf($lang['donthaveanaccount'], "<a href=\"register.php?webtag=$webtag\" target=\"_self\">{$lang['registernow']}</a>"), "</p>\n";
    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['problemsloggingon']}</h2>\n";

    if (isset($frame_top_target) && strlen($frame_top_target) > 0) {

        echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"$frame_top_target\">{$lang['deletecookies']}</a></p>\n";
        echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";

    }else {

        echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
        echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
    }
}

echo "  <hr width=\"350\" />\n";
echo "  <h2>{$lang['usingaPDA']}</h2>\n";

if (isset($frame_top_target) && strlen($frame_top_target) > 0) {
    echo "  <p class=\"smalltext\"><a href=\"llogon.php?webtag=$webtag\" target=\"$frame_top_target\">{$lang['lightHTMLversion']}</a></p>\n";
}else {
    echo "  <p class=\"smalltext\"><a href=\"llogon.php?webtag=$webtag\" target=\"_top\">{$lang['lightHTMLversion']}</a></p>\n";
}

echo "</div>\n";

html_draw_bottom();

?>