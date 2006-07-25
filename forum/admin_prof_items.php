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

/* $Id: admin_prof_items.php,v 1.85 2006-07-25 21:43:50 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {
    header_redirect("./admin_prof_sect.php?webtag=$webtag");
}

if (isset($_GET['psid']) && is_numeric($_GET['psid'])) {

  $psid = $_GET['psid'];

}elseif (isset($_POST['t_psid']) && is_numeric($_POST['t_psid'])) {

  $psid = $_POST['t_psid'];

}else {

  html_draw_top();
  echo "<h1>{$lang['invalidop']}</h1>\n";
  echo "<p>{$lang['noprofilesectionspecified']}</p>\n";
  html_draw_bottom();
  exit;

}

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['t_piid']) && is_array($_POST['t_piid'])) {

        foreach($_POST['t_piid'] as $piid => $value) {

            if (isset($_POST['t_name'][$piid]) && strlen(trim(_stripslashes($_POST['t_name'][$piid]))) > 0) {
                $t_new_name = trim(_stripslashes($_POST['t_name'][$piid]));
            }else {
                $valid = false;
            }

            if (isset($_POST['t_old_name'][$piid]) && strlen(trim(_stripslashes($_POST['t_old_name'][$piid]))) > 0) {
                $t_old_name = trim(_stripslashes($_POST['t_old_name'][$piid]));
            }else {
                $valid = false;
            }

            if (isset($_POST['t_type'][$piid]) && is_numeric($_POST['t_type'][$piid])) {
                $t_new_type = $_POST['t_type'][$piid];
            }else {
                $valid = false;
            }

            if (isset($_POST['t_old_type'][$piid]) && is_numeric($_POST['t_old_type'][$piid])) {
                $t_old_type = $_POST['t_old_type'][$piid];
            }else {
                $valid = false;
            }

            if (isset($_POST['t_section'][$piid]) && is_numeric($_POST['t_section'][$piid])) {
                $t_new_section = $_POST['t_section'][$piid];
            }else {
                $valid = false;
            }

            if (isset($_POST['t_old_section'][$piid]) && is_numeric($_POST['t_old_section'][$piid])) {
                $t_old_section = $_POST['t_old_section'][$piid];
            }else {
                $valid = false;
            }

            if (isset($_POST['t_position'][$piid]) && is_numeric($_POST['t_position'][$piid])) {
                $t_new_position = $_POST['t_position'][$piid];
            }else {
                $valid = false;
            }

            if (isset($_POST['t_old_position'][$piid]) && is_numeric($_POST['t_old_position'][$piid])) {
                $t_old_position = $_POST['t_old_position'][$piid];
            }else {
                $valid = false;
            }

            if ($valid && (($t_new_name != $t_old_name) || ($t_new_type != $t_old_type) || ($t_new_section != $t_old_section) || ($t_new_position != $t_old_position))) {

                profile_item_update($piid, $t_new_section, $t_new_position, $t_new_type, $t_new_name);

                $t_section_name = profile_section_get_name($psid);

                admin_add_log_entry(CHANGE_PROFILE_ITEM, array($t_new_name, $t_old_name, $t_new_type, $t_old_type, $t_new_section, $t_old_section, $t_new_position, $t_old_position));
            }
        }
    }

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {

        if (trim(_stripslashes($_POST['t_name_new'])) != $lang['newitem']) {

            $t_name_new = trim(_stripslashes($_POST['t_name_new']));

        }else {

            $valid = false;
        }

    }else {

        $valid = false;
    }

    if (isset($_POST['t_piid']) && is_array($_POST['t_piid'])) {
        $t_position_new = sizeof($_POST['t_piid']);
    }else {
        $t_position_new = 1;
    }

    if (isset($_POST['t_type_new']) && is_numeric($_POST['t_type_new'])) {
        $t_type_new = $_POST['t_type_new'];
    }else {
        $valid = false;
    }

    if ($valid) {

        $new_piid = profile_item_create($psid, $t_name_new, $t_position_new, $t_type_new);

        $t_section_name = profile_section_get_name($psid);

        admin_add_log_entry(ADDED_PROFILE_ITEM, array($t_section_name, $t_name_new));
    }

}elseif (isset($_POST['t_delete'])) {

    list($piid) = array_keys($_POST['t_delete']);

    $t_section_name = profile_section_get_name($psid);

    $t_item_name = isset($_POST['t_old_name'][$piid]) ? $_POST['t_old_name'][$piid] : "";

    profile_item_delete($piid);

    admin_add_log_entry(DELETE_PROFILE_ITEM, array($t_section_name, $t_item_name));
}

html_draw_top();

// Draw the form
echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['manageprofileitems']} : ", profile_section_get_name($psid), "</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("t_psid", $psid), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['position']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['itemname']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['type']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['moveto']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['deleteitem']}</td>\n";
echo "                </tr>\n";

if ($profile_items = profile_items_get($psid)) {

    foreach ($profile_items as $profile_item) {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_position[{$profile_item['PIID']}]", range(1, sizeof($profile_items) + 1), range(1, sizeof($profile_items) + 1), $profile_item['POSITION']), form_input_hidden("t_old_position[{$profile_item['PIID']}]", $profile_item['POSITION']), form_input_hidden("t_piid[{$profile_item['PIID']}]", $profile_item['PIID']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_name[{$profile_item['PIID']}]", $profile_item['NAME'], 40, 64), form_input_hidden("t_old_name[{$profile_item['PIID']}]", $profile_item['NAME']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_type[{$profile_item['PIID']}]", range(0, 5), array($lang['largetextfield'], $lang['mediumtextfield'], $lang['smalltextfield'], $lang['multilinetextfield'], $lang['radiobuttons'], $lang['dropdown']), $profile_item['TYPE']), form_input_hidden("t_old_type[{$profile_item['PIID']}]", $profile_item['TYPE']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", profile_section_dropdown($psid, "t_section[{$profile_item['PIID']}]"), form_input_hidden("t_old_section[{$profile_item['PIID']}]", $psid), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\" width=\"100\">", form_submit("t_delete[{$profile_item['PIID']}]", $lang['delete']), "</td>\n";
        echo "                </tr>\n";
    }
}

// Draw a row for a new section to be created

echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['new_caps']}</td>\n";
echo "                  <td align=\"left\">", form_field("t_name_new", $lang['newitem'], 40, 64), "</td>";
echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_type_new", range(0, 5), array($lang['largetextfield'], $lang['mediumtextfield'], $lang['smalltextfield'], $lang['multilinetextfield'], $lang['radiobuttons'], $lang['dropdown'])), "</td>\n";
echo "                  <td align=\"center\">&nbsp;</td>\n";
echo "                  <td align=\"center\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td><p>{$lang['fieldtypeexample1']}</p></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td><p>{$lang['fieldtypeexample2']}</p></td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>