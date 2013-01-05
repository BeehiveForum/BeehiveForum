<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if ((!session::check_perm(USER_PERM_ADMIN_TOOLS, 0) && !session::check_perm(USER_PERM_FORUM_TOOLS, 0, 0) && !session::get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

html_draw_top();

if (forum_check_webtag_available($webtag)) {

    if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

        echo "<table border=\"0\" width=\"100%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"subhead\">", gettext("Admin Tools"), "</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Users"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_user_groups.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("User Groups"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_banned.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Ban Controls"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_folders.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Folders"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_rss_feeds.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("RSS Feeds"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_prof_sect.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Profiles"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forum_settings.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Forum Settings"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_startpage.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Start page"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_wordfilter.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Word Filter"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forum_stats.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Forum Stats"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_post_stats.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Posting Stats"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forum_links.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Forum Links"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_viewlog.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("View Log"), "</a></td>\n";
        echo "  </tr>\n";

        if (session::get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

            echo "  <tr>\n";
            echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_post_approve.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Post Approval Queue"), "</a></td>\n";
            echo "  </tr>\n";
        }

        if (session::get_folders_by_perm(USER_PERM_LINKS_MODERATE)) {

            echo "  <tr>\n";
            echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_link_approve.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Link Approval Queue"), "</a></td>\n";
            echo "  </tr>\n";
        }

        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_visitor_log.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Visitor Log"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";

    } else if (session::get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

        echo "<table border=\"0\" width=\"100%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"subhead\">", gettext("Admin Tools"), "</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_post_approve.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Post Approval Queue"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
    }

    if (session::check_perm(USER_PERM_FORUM_TOOLS, 0)) {

        echo "<table border=\"0\" width=\"100%\">\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"subhead\">", gettext("Forum Management"), "</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forums.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Manage Forums"), "</a></td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_default_forum_settings.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Global Forum Settings"), "</a></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
    }

} else {

    echo "<table border=\"0\" width=\"100%\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"subhead\">", gettext("Forum Management"), "</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Users"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_forums.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Manage Forums"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"admin_default_forum_settings.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Global Forum Settings"), "</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

html_draw_bottom();

?>