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

/* $Id: admin.php,v 1.76 2005-12-07 09:26:36 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php");
}

// Load language file

$lang = load_language_file();

if (!perm_has_admin_access() && !perm_has_forumtools_access()) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$stylesheet = html_get_style_sheet();

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

$dtdpath = html_get_forum_uri();

echo "<!DOCTYPE html SYSTEM \"$dtdpath/dtd/beehiveforum.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>$forum_name</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\" />\n";
echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$forum_name} - {$lang['rssfeed']}\" href=\"threads_rss.php?webtag=$webtag\" />\n";
echo "</head>\n";
echo "<frameset cols=\"180,*\" border=\"1\">\n";
echo "  <frame src=\"./admin_menu.php?webtag=$webtag\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";

if (isset($_GET['page']) && strlen(trim(_stripslashes($_GET['page']))) > 0) {

    $page = basename(trim(_stripslashes($_GET['page'])));
    echo "  <frame src=\"$page\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}else {

    echo "  <frame src=\"./admin_main.php?webtag=$webtag\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
}

echo "</frameset>\n";
echo "</html>\n";

?>