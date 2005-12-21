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

/* $Id: edit_profile.php,v 1.52 2005-12-21 17:32:50 decoyduck Exp $ */

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

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
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

    if (isset($_POST['t_entry']) && is_array($_POST['t_entry'])) {

        foreach($_POST['t_entry'] as $piid => $profile_entry) {

            $profile_entry = _stripslashes(trim($profile_entry));

            if (isset($_POST['t_entry_private'][$piid]) && $_POST['t_entry_private'][$piid] == 'Y') {
                $privacy = 1;
            }else {
                $privacy = 0;
            }

            user_profile_update($uid, $piid, $profile_entry, $privacy);
        }
    }

    echo "<h2>{$lang['profileupdated']}</h2>";
}

if ($profile_items_array = profile_get_user_values($uid)) {

    // Draw the form
    echo "<br />\n";
    echo "<form name=\"f_profile\" action=\"edit_profile.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td>\n";
    echo "              <table class=\"box\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"posthead\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";

    $last_psid = false;

    foreach($profile_items_array as $profile_item) {

        $new = isset($profile_value['CHECK_PIID']) ? "N" : "Y";
        $profile_item['ENTRY'] = isset($profile_item['ENTRY']) ? _stripslashes($profile_item['ENTRY']) : "";

        if ($profile_item['PSID'] != $last_psid) {

            if ($last_psid !== false) {

                echo "                      <tr>\n";
                echo "                        <td colspan=\"2\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
                echo "        <br />\n";
                echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td>\n";
                echo "              <table class=\"box\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td class=\"posthead\">\n";
                echo "                    <table class=\"posthead\" width=\"100%\">\n";
                echo "                      <tr>\n";
                echo "                        <td class=\"subhead\" colspan=\"3\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                      </tr>\n";

            }else {

                echo "                      <tr>\n";
                echo "                        <td class=\"subhead\" colspan=\"3\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                      </tr>\n";
            }
        }

        $last_psid = $profile_item['PSID'];

        if (($profile_item['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_item['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

            @list($field_name, $field_values) = explode(':', $profile_item['ITEM_NAME']);

            if (isset($field_name) && isset($field_values)) {

                $field_values = explode(';', $field_values);

                echo "                            <tr>\n";
                echo "                              <td valign=\"top\" width=\"50%\" nowrap=\"nowrap\">$field_name:</td>\n";

                if ($profile_item['TYPE'] == PROFILE_ITEM_RADIO) {
                    echo "                              <td align=\"right\" valign=\"top\">", form_radio_array("t_entry[{$profile_item['PIID']}]", array_keys($field_values), $field_values, $profile_item['ENTRY']), "</td>\n";
                }else {
                    echo "                              <td align=\"right\" valign=\"top\">", form_dropdown_array("t_entry[{$profile_item['PIID']}]", array_keys($field_values), $field_values, $profile_item['ENTRY']), "</td>\n";
                }

                echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", $lang['friendsonly'], (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == 1)), "&nbsp;</td>\n";
            }

        }elseif ($profile_item['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo "                      <tr>\n";
            echo "                        <td valign=\"top\" width=\"50%\" nowrap=\"nowrap\">{$profile_item['ITEM_NAME']}:</td>\n";
            echo "                        <td align=\"right\" valign=\"top\">", form_textarea("t_entry[{$profile_item['PIID']}]", $profile_item['ENTRY'], 4, 42), "</td>\n";
            echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", $lang['friendsonly'], (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == 1)), "&nbsp;</td>\n";
            echo "                      </tr>\n";

        }else {

            $text_width = array(45, 30, 10);

            echo "                      <tr>\n";
            echo "                        <td valign=\"top\" width=\"50%\" nowrap=\"nowrap\">{$profile_item['ITEM_NAME']}:</td>\n";
            echo "                        <td align=\"right\" valign=\"top\">", form_field("t_entry[{$profile_item['PIID']}]", $profile_item['ENTRY'], $text_width[$profile_item['TYPE']], 255), "</td>\n";
            echo "                        <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", $lang['friendsonly'], (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == 1)), "&nbsp;</td>\n";
            echo "                      </tr>\n";

        }
    }

    echo "                      <tr>\n";
    echo "                        <td colspan=\"2\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "            <tr>\n";
    echo "              <td>&nbsp;</td>\n";
    echo "            </tr>\n";
    echo "            <tr>\n";
    echo "              <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "            </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

}else {

    echo "<p>{$lang['profilesnotsetup']}</p>";

}

html_draw_bottom();

?>