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

/* $Id: logon.php,v 1.141 2004-05-09 00:57:48 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/beehive.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Retrieve the final_uri request

if (isset($_GET['final_uri'])) {

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

if ($user_sess = bh_session_check() && bh_session_get_value('UID') != 0) {

    // Load language file

    $lang = load_language_file();

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";

    if (isset($final_uri)) {
        form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
    }else {
        form_quick_button("./index.php", $lang['continue'], false, false, "_top");
    }

    echo "</div>\n";
    html_draw_bottom();
    exit;
}

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

    if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        if (isset($final_uri)) {
            $final_uri = rawurlencode($final_uri);
            header_redirect("./index.php?webtag=$webtag&final_uri=$final_uri");
        }else {
            header_redirect("./index.php?webtag=$webtag");
        }

    }else {

        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";

        if (isset($final_uri)) {
            $final_uri = rawurlencode($final_uri);
            echo "document.location.href = './index.php?webtag=$webtag&amp;final_uri=$final_uri';\n";
        }else {
            echo "document.location.href = './index.php?webtag=$webtag';\n";
        }

        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['cookiessuccessfullydeleted']}</p>";

        if (isset($final_uri)) {
            form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
        }else {
            form_quick_button("./index.php", $lang['continue'], false, false, "_top");
        }

        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

    if (perform_logon(true)) {

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], "Microsoft-IIS")) {

            if (isset($final_uri)) {
                $final_uri = rawurlencode($final_uri);
                header_redirect("./index.php?webtag=$webtag&final_uri=$final_uri");
            }else {
                header_redirect("./index.php?webtag=$webtag");
            }

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";

            if (isset($final_uri)) {
                $final_uri = rawurlencode($final_uri);
                echo "document.location.href = './index.php?webtag=$webtag&amp;final_uri=$final_uri';\n";
            }else {
                echo "document.location.href = './index.php?webtag=$webtag';\n";
            }

            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\">\n";
            echo "<p>{$lang['loggedinsuccessfully']}</p>\n";

            if (isset($final_uri)) {
                form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
            }else {
               form_quick_button("./index.php", $lang['continue'], false, false, "_top");
            }

            echo "</div>\n";
            html_draw_bottom();
            exit;
        }

    }else {

        html_draw_top();

        echo "<div align=\"center\">\n";
        echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
        echo "<h2>{$lang['pleasereenterpasswd']}</h2>\n";

        if (isset($final_uri)) {
            form_quick_button("./index.php", $lang['back'], "final_uri", rawurlencode($final_uri), "_top");
        }else {
            form_quick_button("./index.php", $lang['back'], false, false, "_top");
        }

        echo "<hr width=\"350\" />\n";
        echo "<h2>{$lang['problemsloggingon']}</h2>\n";

        if (isset($final_uri)) {
            $final_uri = rawurlencode($final_uri);
            echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
            echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
        }else {
            echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
            echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
        }

        html_draw_bottom();
        exit;
    }
}

html_draw_top('logon.js');

draw_logon_form(true);

if (user_guest_enabled()) {

    echo "  <form name=\"guest\" action=\"", get_request_uri(), "\" method=\"POST\" target=\"_top\">\n";
    echo "    <p class=\"smalltext\">{$lang['enterasa']} ". form_input_hidden("user_logon", "guest"). form_input_hidden("user_password", "guest"). form_submit(md5(uniqid(rand())), $lang['guest']). "</p>\n";
    echo "  </form>\n";
}

if (isset($final_uri)) {

    $final_uri = rawurlencode($final_uri);

    echo "  <p class=\"smalltext\">{$lang['donthaveanaccount']} <a href=\"register.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">Register now.</a></p>\n";
    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['problemsloggingon']}</h2>\n";
    echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes&amp;final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
    echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag&amp;final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";

}else {

    echo "  <p class=\"smalltext\">{$lang['donthaveanaccount']} <a href=\"register.php?webtag=$webtag\" target=\"_self\">Register now.</a></p>\n";
    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['problemsloggingon']}</h2>\n";
    echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag=$webtag&amp;deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
    echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag=$webtag\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
}

echo "  <hr width=\"350\" />\n";
echo "  <h2>{$lang['usingaPDA']}</h2>\n";
echo "  <p class=\"smalltext\"><a href=\"llogon.php?webtag=$webtag\" target=\"_top\">{$lang['lightHTMLversion']}</a></p>\n";
echo "</div>\n";

html_draw_bottom();

?>