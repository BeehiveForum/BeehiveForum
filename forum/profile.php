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

html_draw_top();

echo "<h1>{$lang['editprofile']}</h1>\n";

$uid = bh_session_get_value('UID');

// Do updates
if (isset($HTTP_POST_VARS['submit'])) {
    for ($i = 0; $i < sizeof($HTTP_POST_VARS['t_piid']); $i++) {
        if ($HTTP_POST_VARS['t_entry'][$i] != $HTTP_POST_VARS['t_old_entry'][$i]) {
            $entry = trim($HTTP_POST_VARS['t_entry'][$i]);
            if ($HTTP_POST_VARS['t_new'][$i] == "Y") {
                user_profile_create($uid, $HTTP_POST_VARS['t_piid'][$i], $entry);
            } else {
                user_profile_update($uid, $HTTP_POST_VARS['t_piid'][$i], $entry);
            }
        }
    }
    echo "<p>{$lang['profileupdated']}</p>";
}else {
    echo "<br />\n";
}

$db = db_connect();

$sql = "SELECT PROFILE_SECTION.PSID, PROFILE_SECTION.NAME AS SECTION_NAME, ";
$sql.= "PROFILE_ITEM.PIID, PROFILE_ITEM.NAME AS ITEM_NAME, ";
$sql.= "USER_PROFILE.PIID AS CHECK_PIID, USER_PROFILE.ENTRY ";
$sql.= "FROM " . forum_table("PROFILE_SECTION") . " PROFILE_SECTION, ";
$sql.= forum_table("PROFILE_ITEM") . " PROFILE_ITEM ";
$sql.= "LEFT JOIN " . forum_table("USER_PROFILE") . " USER_PROFILE ";
$sql.= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = $uid) ";
$sql.= "WHERE PROFILE_ITEM.PSID = PROFILE_SECTION.PSID ";
$sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_SECTION.PSID, ";
$sql.= "PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

$result = db_query($sql, $db);

if (db_num_rows($result)) {

    // Draw the form
    echo "<form name=\"f_profile\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"post\" target=\"_self\">\n";
    echo "  <table width=\"600\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"600\" class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";

    $last_psid = false;

    for ($i = 0; $i < db_num_rows($result); $i++) {

        $row = db_fetch_array($result);

        $new = isset($row['CHECK_PIID']) ? "N" : "Y";
        $row['ENTRY'] = isset($row['ENTRY']) ? _stripslashes($row['ENTRY']) : "";

        if ($row['PSID'] != $last_psid) {
            echo "                <tr>\n";
            echo "                  <td class=\"subhead\" colspan=\"2\">", $row['SECTION_NAME'], "</td>\n";
            echo "                </tr>\n";
        }

        $last_psid = $row['PSID'];

        echo "                <tr>\n";
        echo "                  <td>", $row['ITEM_NAME'], form_input_hidden("t_piid[$i]", $row['PIID']), "</td>\n";
        echo "                  <td nowrap=\"nowrap\" align=\"right\">:<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_field("t_entry[$i]", $row['ENTRY'], 60, 255), form_input_hidden("t_old_entry[$i]", $row['ENTRY']), form_input_hidden("t_new[$i]", $new), "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
        echo "                </tr>\n";
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