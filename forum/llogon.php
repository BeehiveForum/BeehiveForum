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

/* $Id: llogon.php,v 1.38 2004-12-01 09:25:47 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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
include_once("./include/light.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if ($user_sess = bh_session_check() && bh_session_get_value('UID') != 0) {

    light_html_draw_top();
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";
    form_quick_button("./lthread_list.php", $lang['continue'], false, false, "_top");
    light_html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Get the final_uri from the URL

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "./lthread_list.php?webtag=$webtag&msg={$_GET['msg']}";

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "./lthread_list.php?webtag=$webtag&folder={$_GET['folder']}";
}

if (isset($_POST['submit'])) {

    if (isset($_POST['logon']) && isset($_POST['password'])) {

        $luid = user_logon(strtoupper($_POST['logon']), $_POST['password']);

        if ($luid > -1) {

            bh_setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS);

            if ((strtoupper($_POST['logon']) == 'GUEST') && (strtoupper($_POST['password']) == 'GUEST')) {

                bh_session_init(0);

            }else {

                bh_session_init($luid);
            }

            if (isset($_POST['remember_user']) && $_POST['remember_user'] == 'Y') {

                bh_setcookie("bh_light_remember_username", $_POST['logon'], time() + YEAR_IN_SECONDS);
                bh_setcookie("bh_light_remember_password", $_POST['password'], time() + YEAR_IN_SECONDS);
            }

            if (!strstr(@$_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS

                if (isset($final_uri)) {
                    header_redirect($final_uri);
                }else {
                    header_redirect("./lthread_list.php?webtag=$webtag");
                }

            }else { // IIS bug prevents redirect at same time as setting cookies.

                light_html_draw_top();

                echo "<p>{$lang['loggedinsuccessfully']}</p>";

                if (isset($final_uri)) {
                    form_quick_button($final_uri, $lang['continue'], false, false, "_top");
                }else {
                    form_quick_button("./lthread_list.php", $lang['continue'], false, false, "_top");
                }

                light_html_draw_bottom();
                exit;

            }

        }else if ($luid == -2) { // User is banned - everybody hide

            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
            }

            echo "<h2>HTTP/1.0 500 Internal Server Error</h2>\n";
            exit;

        }else {

            light_html_draw_top();
            echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
            form_quick_button("./llogon.php", $lang['back'], false, false, "_top");
            light_html_draw_bottom();
            exit;
        }

    }else {

        $error_html = "<h2>{$lang['usernameandpasswdrequired']}</h2>";
    }
}

light_html_draw_top();

if (isset($error_html)) echo $error_html;

echo "<p>{$lang['welcometolight']}</p>\n";
echo "<form name=\"logonform\" action=\"". get_request_uri() ."\" method=\"post\">\n";

echo "<p>{$lang['username']}: ";
echo light_form_input_text("logon", (isset($_COOKIE['bh_light_remember_username']) ? $_COOKIE['bh_light_remember_username'] : "")). "</p>\n";

echo "<p>{$lang['passwd']}: ";
echo light_form_input_password("password", (isset($_COOKIE['bh_light_remember_password']) ? $_COOKIE['bh_light_remember_password'] : "")). "</p>\n";

echo "<p>", form_checkbox("remember_user", "Y", $lang['rememberpassword'], (isset($_COOKIE['bh_light_remember_username']) && isset($_COOKIE['bh_light_remember_password']) ? true : false)), "</p>\n";

echo "<p>", form_submit('submit', $lang['logon']), "</p>\n";

echo "</form>\n";

light_html_draw_bottom();

?>