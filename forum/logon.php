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

/* $Id: logon.php,v 1.133 2004-04-23 22:11:09 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/beehive.inc.php");
include_once("./include/config.inc.php");
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

if ($user_sess = bh_session_check() && bh_session_get_value('UID') != 0) {

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

$webtag = get_webtag();

// Retrieve the final_uri request

if (isset($_GET['final_uri'])) {

    $final_uri = rawurldecode($_GET['final_uri']);

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "./discussion.php?webtag=$webtag&msg=". $_GET['msg'];

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "./discussion.php?webtag=$webtag&folder=". $_GET['folder'];

}elseif (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

    $final_uri = "./pm.php?webtag=$webtag&mid=". $_GET['pmid'];
}

// If the final_uri contains logout.php then unset it.

if (isset($final_uri) && strstr($final_uri, 'logout.php')) {
    unset($final_uri);
}

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
            echo "document.location.href = './index.php?webtag=$webtag&final_uri=$final_uri';\n";
        }else {
            echo "document.location.href = './index.php?webtag=$webtag';\n";
        }

        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['loggedinsuccessfully']}</p>";

        if (isset($final_uri)) {
            form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
        }else {
            form_quick_button("./index.php", $lang['continue'], false, false, "_top");
        }

        html_draw_bottom();
        exit;
    }

}elseif (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

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
                echo "document.location.href = './index.php?webtag=$webtag&final_uri=$final_uri';\n";
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
    }
}

html_draw_top('logon.js');

draw_logon_form(true);

html_draw_bottom();

?>