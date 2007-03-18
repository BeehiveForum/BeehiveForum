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

/* $Id: admin.php,v 1.91 2007-03-18 23:10:07 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
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

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

html_draw_top('body_tag=false', 'frames=true');

echo "<frameset cols=\"200,*\" border=\"4\">\n";
echo "  <frame src=\"./admin_menu.php?webtag=$webtag\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";

$available_pages = array('admin_banned.php', 'admin_default_forum_settings.php', 
                         'admin_folders.php', 'admin_folder_add.php', 'admin_folder_edit.php', 
                         'admin_forums.php', 'admin_forum_access.php', 'admin_forum_links.php', 
                         'admin_forum_settings.php', 'admin_forum_set_passwd.php',
                         'admin_make_style.php', 'admin_post_approve.php', 'admin_post_stats.php', 
                         'admin_prof_items.php', 'admin_prof_sect.php', 'admin_rss_feeds.php', 
                         'admin_startpage.php', 'admin_user.php', 'admin_users.php', 
                         'admin_user_groups.php', 'admin_user_groups_add.php', 
                         'admin_user_groups_edit.php', 'admin_user_groups_edit_users.php', 
                         'admin_viewlog.php', 'admin_visitor_log.php', 'admin_wordfilter.php');

if (isset($_GET['page']) && strlen(trim(_stripslashes($_GET['page']))) > 0) {

    $page_name = trim(_stripslashes($_GET['page']));    
    $available_pages_preg = implode("|^", array_map('preg_quote_callback', $available_pages));
        
    if (preg_match("/^$available_pages_preg/", $page_name) > 0) {

        echo "  <frame src=\"$page_name\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
        echo "</frameset>\n";
        html_draw_bottom();
        exit;
    }
}
    
echo "  <frame src=\"./admin_main.php?webtag=$webtag\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
echo "</frameset>\n";

html_draw_bottom(false);

?>