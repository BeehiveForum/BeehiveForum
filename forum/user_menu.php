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

/* $Id: user_menu.php,v 1.15 2004-03-17 22:21:37 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

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
echo "    <td class=\"postbody\"><a href=\"edit_prefs.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['userdetails']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_profile.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['userprofile']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_password.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['changepassword']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><hr /></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_email.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['emailandprivacy']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"forum_options.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['forumoptions']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_attachments.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['editattachments']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_signature.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['editsignature']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_relations.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['editrelationships']}</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\"><a href=\"edit_wordfilter.php?webtag={$webtag['WEBTAG']}\" target=\"right\">{$lang['editwordfilter']}</a></td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>