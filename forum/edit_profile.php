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

/* $Id: edit_profile.php,v 1.47 2005-04-01 13:17:12 rowan_hill Exp $ */

/**
* Displays the edit profile page, and processes sumbissions
*/

/**
*/

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

html_draw_top();

echo "<h1>{$lang['editprofile']}</h1>\n";

$uid = bh_session_get_value('UID');

// Do updates

if (isset($_POST['submit'])) {

    for ($i = 0; $i < sizeof($_POST['t_piid']); $i++) {
        $entry = trim($_POST['t_entry'][$i]);
        if (isset($_POST['t_entry_private'][$i])) {
            $privacy = 1;
        } else {
            $privacy = 0;
        }
        user_profile_update($uid, $_POST['t_piid'][$i], $entry, $privacy);
    }

    echo "<h2>{$lang['profileupdated']}</h2>";
}

if ($profile_values = profile_get_user_values($uid)) {

    // Draw the form
    echo "<br />\n";
    echo "<form name=\"f_profile\" action=\"edit_profile.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
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
            echo "                  <td valign=\"top\">", $field_name, form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":&nbsp;</td>\n";
            echo "                  <td valign=\"top\">";

            if ($profile_values[$i]['TYPE'] == PROFILE_ITEM_RADIO) {
                echo form_radio_array("t_entry[$i]", array_keys($field_values), $field_values, $profile_values[$i]['ENTRY']);
            }else {
                echo form_dropdown_array("t_entry[$i]", array_keys($field_values), $field_values, $profile_values[$i]['ENTRY']);
            }

            echo "&nbsp;&nbsp;</td>\n";
	    echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("t_entry_private[$i]","N",$lang['friendsonly'],$profile_values[$i]['PRIVACY']), "&nbsp;</td>\n";

        }elseif ($profile_values[$i]['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\">", $profile_values[$i]['ITEM_NAME'], form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":&nbsp;</td>\n";
            echo "                  <td valign=\"top\">", form_textarea("t_entry[$i]", $profile_values[$i]['ENTRY'], 4, 42), "&nbsp;&nbsp;</td>\n";
	    echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("t_entry_private[$i]","N",$lang['friendsonly'],$profile_values[$i]['PRIVACY']), "&nbsp;</td>\n";
            echo "                </tr>\n";

        }else {

            $text_width = array(45, 30, 10);

            echo "                <tr>\n";
            echo "                  <td valign=\"top\">", $profile_values[$i]['ITEM_NAME'], form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":&nbsp;</td>\n";
            echo "                  <td valign=\"top\">", form_field("t_entry[$i]", $profile_values[$i]['ENTRY'], $text_width[$profile_values[$i]['TYPE']], 255), "&nbsp;&nbsp;</td>\n";
	    echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("t_entry_private[$i]","N",$lang['friendsonly'],$profile_values[$i]['PRIVACY']), "&nbsp;</td>\n";
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
    echo "      <tr>\n";
    echo "        <td>&nbsp;</td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "      </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

}else {

    echo "<p>{$lang['profilesnotsetup']}</p>";

}

html_draw_bottom();

?>