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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'emoticons.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold the emoticons
$emoticon = array();

// Get array of available emoticon sets
$emoticon_sets_array = emoticons_get_available(false);

// Check for preview argument in URL.
if (isset($_GET['pack']) && emoticons_set_exists($_GET['pack'])) {

    // Get the emoticon pack from the URL.
    $emoticon_set = basename($_GET['pack']);

} else if (isset($_SESSION['EMOTICONS']) && strlen(trim($_SESSION['EMOTICONS'])) > 0) {

    $emoticon_set = $_SESSION['EMOTICONS'];

} else {

    // Get the user's emoticon pack.
    $emoticon_set = basename(forum_get_setting('default_emoticons', null, 'default'));
}

// Check the emoticon set exists.
if (!emoticons_set_exists($emoticon_set)) {

    // Use the forum default emoticon pack.
    $emoticon_set = basename(forum_get_setting('default_emoticons', null, 'default'));
}

// Make sure the emoticon set has no path info.
$emoticon_set = basename($emoticon_set);

// Output starts here
html_draw_top(sprintf("title=%s", gettext("Emoticons")), "js/emoticons.js", 'pm_popup_disabled', 'class=window_title', "emoticons=$emoticon_set");

echo "<h1>", gettext("Emoticons"), "</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" valign=\"top\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td align=\"left\" class=\"subhead\">", gettext("Emoticons"), "</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table class=\"posthead\" width=\"95%\">\n";
echo "                    <tr>\n";

// Array to hold text to emoticon lookups.
$emoticon = array();

// Array to hold emoticon to text lookups
$emoticon_text = array();

// Include the emoticon pack.
if (@file_exists("emoticons/$emoticon_set/definitions.php")) {
    include("emoticons/$emoticon_set/definitions.php");
}

// Group emoticons by text
if (sizeof($emoticon) > 0) {

    foreach ($emoticon as $emot_text => $emot_class) {
        $emoticon_text[$emot_class][] = $emot_text;
    }
}

echo "                      <td align=\"left\">\n";
echo "                        <table class=\"posthead\" width=\"300\">\n";

// Display the preview
foreach ($emoticon_text as $emot_class => $emot_text_array) {

    echo "                          <tr>\n";
    echo "                            <td align=\"left\" width=\"100\">\n";

    printf('                              <span class="emoticon e_%1$s" title="%2$s"><span class="e__">%2$s</span></span>', $emot_class, $emot_text_array[0]);

    echo "                            </td>\n";
    echo "                            <td align=\"left\">", implode('&nbsp;', htmlentities_array($emot_text_array)), "</td>\n";
    echo "                          </tr>\n";
}

echo "                          <tr>\n";
echo "                            <td align=\"left\">&nbsp;</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"center\">", form_button('close_popup', gettext("Close")), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>