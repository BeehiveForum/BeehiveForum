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
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

html_draw_top();

echo "<table width=\"100%\" class=\"menu_box\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\" class=\"subhead\">", gettext("Menu"), "</td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_prefs.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("User Details"), "</a><br /><span class=\"smallertext\">Mange account information, including profile picture and avatar.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_email.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", htmlentities_array(gettext("Email & Privacy")), "</a><br /><span class=\"smallertext\">Choose who, if anyone, may email, private message, or even see you visiting.</apsn><br /><br /> </td>\n";
echo "  </tr>\n";;

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"pm_options.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Private Message Options"), "</a><br /><span class=\"smallertext\">Tools to manage how your private messages are handled.</span><br /><br /></td>\n";
echo "  </tr>\n";

if (forum_check_webtag_available($webtag, false)) {
echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_attachments.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Attachments"), "</a><br /><span class=\"smallertext\">Tools to manage your attachments space and what you store in it.</span><br /><br /></td>\n";
echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_password.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Change Password"), "</a><br /><span class=\"smallertext\">Tools to manage your forums system password.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\"><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\" class=\"subhead\">May be unique to each forum.</td>\n";
echo "  </tr>\n";

if (forum_check_webtag_available($webtag, false)) {
echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_profile.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Edit Profile"), "</a><br /><span class=\"smallertext\">Manage your forum profile information, including who sees your profile. Each forum on this system may have different profile options available.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo" <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"forum_options.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Forum Options"), "</a><br /><span class=\"smallertext\">Tools to manage many forum settings, such time zone, language, style, font size, and many more.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_signature.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Signature"), "</a><br /><span class=\"smallertext\">Create and manage your signature. Use a different one for each forum or just one for them all.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_relations.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Relationships"), "</a><br /><span class=\"smallertext\">Relationships can help you see friends' posts and ignore others you don't want to see, plus more.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_wordfilter.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Word Filter"), "</a><br /><span class=\"smallertext\">Block words you don't want to see, or replace them with others of your choosing.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"edit_subscriptions.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Thread Subscriptions"), "</a><br /><span class=\"smallertext\">Manage what discussions you want to follow and keep track of when visiting.</span><br /><br /></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td align=\"left\">", html_style_image('bullet'), "&nbsp;<a href=\"folder_subscriptions.php?webtag=$webtag\" target=\"", html_get_frame_name('right'), "\">", gettext("Folder Subscriptions"), "</a><br /><span class=\"smallertext\">Manage what folders you want to follow and keep track of when visiting.</span><br /><br /></td>\n";
echo "  </tr>\n";
}


echo "</table>\n";

html_draw_bottom();
