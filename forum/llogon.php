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

/* $Id: llogon.php,v 1.45 2005-04-20 18:36:38 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

if ($user_sess = bh_session_check(false) && bh_session_get_value('UID') != 0) {

    light_html_draw_top();
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";
    echo form_quick_button("./lthread_list.php", $lang['continue'], false, false, "_top");
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

            if (isset($final_uri)) {
                header_redirect($final_uri, $lang['loggedinsuccessfully']);
            }else {
                header_redirect("./lthread_list.php?webtag=$webtag", $lang['loggedinsuccessfully']);
            }

        }else if ($luid == -2) {

            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
            }

            echo "<h2>HTTP/1.0 500 Internal Server Error</h2>\n";
            exit;

        }else {

            light_html_draw_top();
            echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
            echo form_quick_button("./llogon.php", $lang['back'], false, false, "_top");
            light_html_draw_bottom();
            exit;
        }

    }else {

        $error_html = "<h2>{$lang['usernameandpasswdrequired']}</h2>";
    }
}

light_html_draw_top();

if (isset($error_html)) echo $error_html;

light_draw_logon_form();

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>