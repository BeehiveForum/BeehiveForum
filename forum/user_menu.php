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

/* $Id: user_menu.php,v 1.55 2008-07-27 10:53:34 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Intitalise a few variables

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag();
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {
    html_guest_error();
    exit;
}

html_draw_top();

echo "<table border=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"subhead\">{$lang['menu']}</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_prefs.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['userdetails']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_profile.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['userprofile']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_password.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['changepassword']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><hr /></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_email.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['emailandprivacy']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"forum_options.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['forumoptions']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"pm_options.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['privatemessageoptions']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_attachments.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['attachments']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_signature.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['signature']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_relations.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['relationships']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_wordfilter.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['wordfilter']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_subscriptions.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['threadsubscriptions']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", style_image('star.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"folder_subscriptions.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">{$lang['foldersubscriptions']}</a></td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>