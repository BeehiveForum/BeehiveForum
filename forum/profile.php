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

/* $Id: profile.php,v 1.24 2003-10-23 19:16:45 uid81631 Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Frameset for thread list and messages

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");

if(bh_session_get_value('UID') == 0) {
        html_guest_error();
        exit;
}

require_once("./include/forum.inc.php");
require_once("./include/form.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user_profile.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/format.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/profile.inc.php");

html_draw_top();

echo "<h1>{$lang['editprofile']}</h1>\n";

$uid = bh_session_get_value('UID');

// Do updates

if (isset($HTTP_POST_VARS['submit'])) {

    for ($i = 0; $i < sizeof($HTTP_POST_VARS['t_piid']); $i++) {

        $entry = trim($HTTP_POST_VARS['t_entry'][$i]);
        user_profile_update($uid, $HTTP_POST_VARS['t_piid'][$i], $entry);
    }

    echo "<p>{$lang['profileupdated']}</p>";

}else {

    echo "<br />\n";
}

if ($profile_values = profile_get_user_values($uid)) {

    // Draw the form
    echo "<form name=\"f_profile\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"post\" target=\"_self\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";

    $last_psid = false;

    for ($i = 0; $i < sizeof($profile_values); $i++) {

        $new = isset($profile_values[$i]['CHECK_PIID']) ? "N" : "Y";
        $profile_values[$i]['ENTRY'] = isset($profile_values[$i]['ENTRY']) ? _stripslashes($profile_values[$i]['ENTRY']) : "";

        if ($profile_values[$i]['PSID'] != $last_psid) {
            echo "                <tr>\n";
            echo "                  <td class=\"subhead\" colspan=\"2\">", $profile_values[$i]['SECTION_NAME'], "</td>\n";
            echo "                </tr>\n";
        }

        $last_psid = $profile_values[$i]['PSID'];

        if (($profile_values[$i]['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_values[$i]['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

            list($field_name, $field_values) = explode(':', $profile_values[$i]['ITEM_NAME']);
            $field_values = explode(';', $field_values);

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" width=\"200\">", $field_name, form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":</td>\n";
            echo "                  <td valign=\"top\">";

            if ($profile_values[$i]['TYPE'] == PROFILE_ITEM_RADIO) {
                echo form_radio_array("t_entry[$i]", array_keys($field_values), $field_values, $profile_values[$i]['ENTRY']);
            }else {
                echo form_dropdown_array("t_entry[$i]", array_keys($field_values), $field_values, $profile_values[$i]['ENTRY']);
            }

            //echo form_input_hidden("t_old_entry[$i]", $profile_values[$i]['ENTRY']), form_input_hidden("t_new[$i]", $new), "&nbsp;&nbsp;</td>\n";

        }elseif ($profile_values[$i]['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" width=\"200\">", $profile_values[$i]['ITEM_NAME'], form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":</td>\n";
            echo "                  <td valign=\"top\">", form_textarea("t_entry[$i]", $profile_values[$i]['ENTRY'], 4, 57), /* form_input_hidden("t_old_entry[$i]", $profile_values[$i]['ENTRY']), form_input_hidden("t_new[$i]", $new), */ "&nbsp;&nbsp;</td>\n";
            echo "                </tr>\n";

        }else {

            $text_width = array(60, 30, 10);

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" width=\"200\">", $profile_values[$i]['ITEM_NAME'], form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":</td>\n";
            echo "                  <td valign=\"top\">", form_field("t_entry[$i]", $profile_values[$i]['ENTRY'], $text_width[$profile_values[$i]['TYPE']], 255), /* form_input_hidden("t_old_entry[$i]", $profile_values[$i]['ENTRY']), form_input_hidden("t_new[$i]", $new), */ "&nbsp;&nbsp;</td>\n";
            echo "                </tr>\n";

        }
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\"><p>", form_submit("submit", $lang['save']), "</p></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

}else {

    echo "<p>{$lang['profilesnotsetup']}</p>";

}

html_draw_bottom();

?>