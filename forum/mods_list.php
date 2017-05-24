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
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'mods_list.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = intval($_GET['fid']);

} else if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

    $fid = intval($_POST['fid']);

} else {

    html_draw_error(gettext("Cannot display folder moderators"));
}

$folder_title = folder_get_title($fid);

html_draw_top(
    array(
        'title' => sprintf(
            gettext('Moderator list - %s'),
            $folder_title
        ),
        'pm_popup_disabled' => true,
        'class' => 'window_title'
    )
);

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"1\">", gettext("Moderator list"), " - ", $folder_title, "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table width=\"90%\" class=\"posthead\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">\n";
echo "                          <h2>", gettext("Forum leaders:"), "</h2>\n";
echo "                          <ul>\n";

if (($forum_mods_array = mods_list_forum_leaders()) !== false) {

    foreach ($forum_mods_array as $forum_mod) {

        echo "                            <li><a href=\"user_profile.php?webtag=$webtag&amp;uid={$forum_mod['UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        echo word_filter_add_ob_tags(format_user_name($forum_mod['LOGON'], $forum_mod['NICKNAME']), true), "</a></li>\n";
    }

} else {

    echo "                            <li>", gettext("No moderators found"), "</li>\n";
}

echo "                          </ul>\n";
echo "                          <h2>", gettext("Folder moderators:"), "</h2>";
echo "                          <ul>\n";

if (($folder_mods_array = mods_list_folder_mods($fid)) !== false) {

    foreach ($folder_mods_array as $folder_mod) {

        echo "                            <li><a href=\"user_profile.php?webtag=$webtag&amp;uid={$folder_mod['UID']}\" target=\"_blank\" class=\"popup 650x500\">";
        echo word_filter_add_ob_tags(format_user_name($folder_mod['LOGON'], $folder_mod['NICKNAME']), true), "</a></li>\n";
    }

} else {

    echo "                            <li>", gettext("No moderators found"), "</li>\n";
}

echo "                          </ul>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <form accept-charset=\"utf-8\" method=\"post\" action=\"mods_list.php\" target=\"_self\">\n";
echo "    ", form_csrf_token_field(), "\n";
echo "    ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "    ", form_input_hidden('fid', htmlentities_array($fid)), "\n";
echo "    " . form_button('close_popup', gettext("Close")) . "\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();