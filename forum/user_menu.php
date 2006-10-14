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

/* $Id: user_menu.php,v 1.40 2006-10-14 19:11:35 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
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

html_draw_top();

echo "<table border=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td class=\"subhead\">{$lang['menu']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_prefs.php?webtag=$webtag\" target=\"right\">{$lang['userdetails']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_profile.php?webtag=$webtag\" target=\"right\">{$lang['userprofile']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_password.php?webtag=$webtag\" target=\"right\">{$lang['changepassword']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><hr /></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_email.php?webtag=$webtag\" target=\"right\">{$lang['emailandprivacy']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"forum_options.php?webtag=$webtag\" target=\"right\">{$lang['forumoptions']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_attachments.php?webtag=$webtag\" target=\"right\">{$lang['editattachments']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_signature.php?webtag=$webtag\" target=\"right\">{$lang['editsignature']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_relations.php?webtag=$webtag\" target=\"right\">{$lang['editrelationships']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" />&nbsp;<a href=\"edit_wordfilter.php?webtag=$webtag\" target=\"right\">{$lang['editwordfilter']}</a></td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>