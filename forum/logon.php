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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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
include_once(BH_INCLUDE_PATH. "cache.inc.php");
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

// Load language file
$lang = load_language_file();

// Fetch the forum webtag
$webtag = get_webtag();

// Retrieve the final_uri request
if (isset($_GET['final_uri']) && strlen(trim(stripslashes_array($_GET['final_uri']))) > 0) {

    $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

    if (preg_match("/^$available_files_preg/u", trim(stripslashes_array($_GET['final_uri']))) > 0) {
        $final_uri = href_cleanup_query_keys($_GET['final_uri']);
    }

}else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "discussion.php?webtag=$webtag&amp;msg=". $_GET['msg'];

}else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "discussion.php?webtag=$webtag&amp;folder=". $_GET['folder'];

}else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

    $final_uri = "pm.php?webtag=$webtag&amp;mid=". $_GET['pmid'];
}

// Don't cache this page - fixes problems with Opera.
cache_disable();

// Logon script doesn't redirect if the session isn't created
$user_sess = session_check(false);

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Delete the user's cookie as requested and send them back to the login form.
if (isset($_GET['deletecookie']) && ($_GET['deletecookie'] == 'yes')) {

    html_remove_all_cookies();

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

        if (isset($final_uri)) {

            $final_uri = rawurlencode(sprintf("logon.php?webtag=$webtag&logon_failed=true&final_uri=%s", rawurlencode($final_uri)));
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", $lang['usernameorpasswdnotvalid']);

        }else {

            $final_uri = rawurlencode("logon.php?webtag=$webtag&logon_failed=true");
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", $lang['usernameorpasswdnotvalid']);
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

logon_draw_form(LOGON_FORM_DEFAULT);

echo "</div>\n";

html_draw_bottom();

?>
