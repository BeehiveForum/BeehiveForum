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

/* $Id: pm.php,v 1.122 2007-05-21 00:14:22 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Don't cache this page - fixes problems with Opera.

header_no_cache();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Available PM Folders

$available_folders = array(PM_FOLDER_INBOX, PM_FOLDER_SENT, PM_FOLDER_OUTBOX,
                           PM_FOLDER_SAVED, PM_FOLDER_DRAFTS, PM_SEARCH_RESULTS);

// If we're viewing a message we need to know the folder it is in.

if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = $_GET['mid'];
    
    if (!$folder = pm_message_get_folder($mid)) {
        $folder = PM_FOLDER_INBOX;
    }

    html_draw_top('body_tag=false', 'frames=true');

    echo "<frameset cols=\"280,*\" framespacing=\"0\" border=\"4\">\n";
    echo "  <frame src=\"./pm_folders.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder\" name=\"pm_folders\" frameborder=\"0\" />\n";
    echo "  <frame src=\"./pm_messages.php?webtag=$webtag&amp;mid=$mid&amp;folder=$folder\" name=\"pm_messages\" frameborder=\"0\" />\n";
    echo "</frameset>\n";

    html_draw_bottom();
    exit;

}elseif (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $folder = (in_array($_GET['folder'], $available_folders)) ? $_GET['folder'] : PM_FOLDER_INBOX;

    html_draw_top('body_tag=false', 'frames=true');

    echo "<frameset cols=\"280,*\" framespacing=\"0\" border=\"4\">\n";
    echo "  <frame src=\"./pm_folders.php?webtag=$webtag&amp;folder=$folder\" name=\"pm_folders\" frameborder=\"0\" />\n";
    echo "  <frame src=\"./pm_messages.php?webtag=$webtag&amp;folder=$folder\" name=\"pm_messages\" frameborder=\"0\" />\n";
    echo "</frameset>\n";

    html_draw_bottom();
    exit;
}

html_draw_top('body_tag=false', 'frames=true');

echo "<frameset cols=\"280,*\" framespacing=\"0\" border=\"4\">\n";
echo "  <frame src=\"./pm_folders.php?webtag=$webtag\" name=\"pm_folders\" frameborder=\"0\" />\n";
echo "  <frame src=\"./pm_messages.php?webtag=$webtag\" name=\"pm_messages\" frameborder=\"0\" />\n";
echo "</frameset>\n";

html_draw_bottom();

?>