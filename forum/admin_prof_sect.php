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

/* $Id: admin_prof_sect.php,v 1.66 2005-02-16 23:39:32 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/profile.inc.php");
include_once("./include/session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top();

if (!(perm_has_admin_access())) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Do updates

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['t_psid']) && is_array($_POST['t_psid'])) {

        foreach($_POST['t_psid'] as $psid => $value) {

            if (isset($_POST['t_name'][$psid]) && strlen(trim(_stripslashes($_POST['t_name'][$psid]))) > 0) {
                $t_new_name = trim(_stripslashes($_POST['t_name'][$psid]));
            }else {
                $valid = false;
            }

            if (isset($_POST['t_position'][$psid]) && is_numeric($_POST['t_position'][$psid])) {
                $t_new_position = $_POST['t_position'][$psid];
            }else {
                $valid = false;
            }

            if ($valid) {

                profile_section_update($psid, $t_new_position, $t_new_name);
                admin_addlog(0, 0, 0, 0, $psid, 0, 10);
            }
        }

    }

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {

        if (trim(_stripslashes($_POST['t_name_new'])) != $lang['newsection']) {

            $t_name_new = trim(_stripslashes($_POST['t_name_new']));

        }else {

            $valid = false;
        }

    }else {

        $valid = false;
    }

    if (isset($_POST['t_psid']) && is_array($_POST['t_psid'])) {
        $t_position_new = sizeof($_POST['t_psid']);
    }else {
        $t_position_new = 1;
    }

    if ($valid) {

        $new_psid = profile_section_create($t_name_new, $t_position_new);
        admin_addlog(0, 0, 0, 0, $new_psid, 0, 11);

    }

}elseif (isset($_POST['t_delete'])) {

    list($psid) = array_keys($_POST['t_delete']);
    profile_section_delete($psid);
    admin_addlog(0, 0, 0, 0, 0, $psid, 15);

}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageprofilesections']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_sections\" action=\"admin_prof_sect.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['position']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['sectionname']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['items']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['deletesection']}</td>\n";
echo "                </tr>\n";

if ($profile_sections = profile_sections_get()) {

    for ($i = 0; $i < sizeof($profile_sections); $i++) {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_position[{$profile_sections[$i]['PSID']}]", range(1, sizeof($profile_sections) + 1), range(1, sizeof($profile_sections) + 1), $i + 1), form_input_hidden("t_old_position[{$profile_sections[$i]['PSID']}]", $i), form_input_hidden("t_psid[{$profile_sections[$i]['PSID']}]", $profile_sections[$i]['PSID']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_name[{$profile_sections[$i]['PSID']}]", $profile_sections[$i]['NAME'], 40, 64), form_input_hidden("t_old_name[{$profile_sections[$i]['PSID']}]", $profile_sections[$i]['NAME']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_button("items", $lang['items'], "onclick=\"document.location.href='admin_prof_items.php?webtag=$webtag&amp;psid={$profile_sections[$i]['PSID']}'\""), "</td>\n";

        if (!profile_items_get($profile_sections[$i]['PSID'])) {
            echo "                  <td>", form_submit("t_delete[{$profile_sections[$i]['PSID']}]", $lang['delete']), "</td>\n";
        }else{
            echo "                  <td>&nbsp;</td>\n";
        }

        echo "                </tr>\n";
    }
}

// Draw a row for a new section to be created
echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['newcaps']}</td>\n";
echo "                  <td align=\"left\">", form_field("t_name_new", $lang['newsection'], 40, 64), "</td>\n";
echo "                  <td align=\"center\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"4\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>