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

/* $Id: admin.php,v 1.66 2005-03-06 23:36:40 decoyduck Exp $ */

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

include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
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

$stylesheet = "./styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : forum_get_setting('default_style')). "/style.css";

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

echo "<!DOCTYPE html SYSTEM \"dtd/beehive-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>$forum_name</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\" />\n";
echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$forum_name} RSS Feed\" href=\"threads_rss.php\" />\n";
echo "</head>\n";
echo "<frameset cols=\"180,*\" border=\"1\">\n";
echo "  <frame src=\"./admin_menu.php?webtag=$webtag\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";

if (isset($_GET['page']) && strlen(trim(_stripslashes($_GET['page']))) > 0) {

    $page = trim(_stripslashes($_GET['page']));
    echo "  <frame src=\"$page\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}else {

    echo "  <frame src=\"./admin_main.php?webtag=$webtag\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
}

echo "</frameset>\n";
echo "</html>\n";

?>