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

/* $Id: llogon.php,v 1.53 2006-09-01 14:18:41 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Get the final_uri from the URL

if (isset($_GET['final_uri']) && strlen(trim(_stripslashes($_GET['final_uri']))) > 0) {

    $final_uri = rawurldecode($_GET['final_uri']);

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "./lmessages.php.php?webtag=$webtag&msg={$_GET['msg']}";

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "./lthread_list.php?webtag=$webtag&folder={$_GET['folder']}";
}

// If the final_uri contains logout.php then unset it.

if (isset($final_uri) && strstr($final_uri, 'logout.php')) {
    unset($final_uri);
}

if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

    if (perform_logon(true)) {

        if (isset($final_uri)) {
            header_redirect($final_uri, $lang['loggedinsuccessfully']);
        }else {
            header_redirect("./lthread_list.php?webtag=$webtag", $lang['loggedinsuccessfully']);
        }

    }else {

        light_html_draw_top();
        echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
        echo form_quick_button("./llogon.php", $lang['back'], false, false, "_top");
        light_html_draw_bottom();
        exit;
    }
}

light_html_draw_top();

if (isset($error_html)) echo $error_html;

light_draw_logon_form();

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>