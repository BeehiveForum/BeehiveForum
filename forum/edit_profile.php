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

/* $Id: edit_profile.php,v 1.36 2004-04-28 14:28:52 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/profile.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user_profile.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
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
        user_profile_update($uid, $_POST['t_piid'][$i], $entry);
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
            echo "                  <td valign=\"top\" width=\"200\">", $field_name, form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":</td>\n";
            echo "                  <td valign=\"top\">";

            if ($profile_values[$i]['TYPE'] == PROFILE_ITEM_RADIO) {
                echo form_radio_array("t_entry[$i]", array_keys($field_values), $field_values, $profile_values[$i]['ENTRY']);
            }else {
                echo form_dropdown_array("t_entry[$i]", array_keys($field_values), $field_values, $profile_values[$i]['ENTRY']);
            }

            echo "&nbsp;&nbsp;</td>\n";

        }elseif ($profile_values[$i]['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" width=\"200\">", $profile_values[$i]['ITEM_NAME'], form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":</td>\n";
            echo "                  <td valign=\"top\">", form_textarea("t_entry[$i]", $profile_values[$i]['ENTRY'], 4, 42), "&nbsp;&nbsp;</td>\n";
            echo "                </tr>\n";

        }else {

            $text_width = array(45, 30, 10);

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" width=\"200\">", $profile_values[$i]['ITEM_NAME'], form_input_hidden("t_piid[$i]", $profile_values[$i]['PIID']), ":</td>\n";
            echo "                  <td valign=\"top\">", form_field("t_entry[$i]", $profile_values[$i]['ENTRY'], $text_width[$profile_values[$i]['TYPE']], 255), "&nbsp;&nbsp;</td>\n";
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