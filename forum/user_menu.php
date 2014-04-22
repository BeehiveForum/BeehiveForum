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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

html_draw_top();

echo "<table border=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"subhead\">", gettext("Menu"), "</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_prefs.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("User Details"), "</a></td>\n";
echo "  </tr>\n";

if (forum_check_webtag_available($webtag, false)) {

    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_profile.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Edit Profile"), "</a></td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_password.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Change Password"), "</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><hr /></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_email.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", htmlentities_array(gettext("Email & Privacy")), "</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"forum_options.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Forum Options"), "</a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"pm_options.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Private Message Options"), "</a></td>\n";
echo "  </tr>\n";

if (forum_check_webtag_available($webtag, false)) {

    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_attachments.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Attachments"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_signature.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Signature"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_relations.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Relationships"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_wordfilter.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Word Filter"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"edit_subscriptions.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Thread Subscriptions"), "</a></td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\" class=\"postbody\"><img src=\"", html_style_image('bullet.png'), "\" border=\"0\" alt=\"\" />&nbsp;<a href=\"folder_subscriptions.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Folder Subscriptions"), "</a></td>\n";
    echo "  </tr>\n";
}

echo "</table>\n";

html_draw_bottom();