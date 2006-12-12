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

/* $Id: admin_prof_sect.php,v 1.88 2006-12-12 21:42:26 decoyduck Exp $ */

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

if (bh_session_user_banned()) {

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

html_draw_top();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$error_html = "";
$add_success = "";
$del_success = "";
$edit_success = "";

if (isset($_POST['cancel']) || isset($_POST['delete'])) {

    unset($_POST['addfeed'], $_POST['psid'], $_GET['psid']);
}

if (isset($_POST['delete_sections'])) {

    if (isset($_POST['delete_section']) && is_array($_POST['delete_section'])) {

        foreach($_POST['delete_section'] as $psid => $delete_section) {
    
            if (($delete_section == "Y") && ($profile_name = profile_section_get_name($psid))) {

                if (profile_section_delete($psid)) {

                    admin_add_log_entry(DELETE_PROFILE_SECT, $profile_name);
                    $del_success = "<h2>{$lang['successfullyremovedselectedprofilesections']}</h2>\n";

                }else {
                    
                    $error_html.= "<h2>{$lang['failedtoremoveprofilesections']}</h2>\n";
                }               
            }
        }
    }

}elseif (isset($_POST['addsectionsubmit'])) {

    $valid = true;
    
    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {
        $t_name_new = trim(_stripslashes($_POST['t_name_new']));
    }else {
        $error_html.= "<h2>{$lang['mustsepecifyaprofilesectionname']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        if ($new_psid = profile_section_create($t_name_new)) {

            $add_success = "<h2>{$lang['successfullyaddedsection']}</h2>\n";
            admin_add_log_entry(ADDED_PROFILE_SECT, $t_name_new);
            unset($t_name_new, $_POST['addsection'], $_POST['addsectionsubmit']);
        }
    }

}elseif (isset($_POST['editfeedsubmit'])) {

    $valid = true;
    
    if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {
        $psid = $_POST['psid'];
    }else {
        $error_html.= "<h2>{$lang['mustspecifyaprofilesectionid']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {
        $t_new_name = trim(_stripslashes($_POST['t_name_new']));
    }else {
        $error_html.= "<h2>{$lang['mustsepecifyaprofilesectionname']}</h2>\n";
        $valid = false;
    }

    if ($valid) {
    
        if (profile_section_update($psid, $t_new_name)) {

            $t_section_name = profile_section_get_name($psid);

            if ($t_new_name != $t_section_name) {
                admin_add_log_entry(CHANGE_PROFILE_SECT, array($t_section_name, $t_new_name));
            }

            $edit_success = "<h2>{$lang['successfullyeditedprofilesection']}</h2>\n";
            unset($_POST['updatesectionsubmit'], $_POST['psid'], $_POST['t_name'], $psid, $t_new_name, $t_section_name);
        }
    }

}elseif (isset($_POST['addsection'])) {

    $redirect = "./admin_prof_sect.php?webtag=$webtag&addsection=true";
    header_redirect($redirect);
    exit;

}elseif (isset($_POST['viewitems']) && is_array($_POST['viewitems'])) {

    list($psid) = array_keys($_POST['viewitems']);
    $redirect = "./admin_prof_items.php?webtag=$webtag&psid=$psid";
    header_redirect($redirect);
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($psid) = array_keys($_POST['move_up']);
    profile_section_move_up($psid);
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($psid) = array_keys($_POST['move_down']);
    profile_section_move_down($psid);
}

if (isset($_GET['addsection']) || isset($_POST['addsection'])) {

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; {$lang['addnewprofilesection']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_prof_sect.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('addsection', 'true'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['sectionname']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['sectionname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? _htmlentities(_stripslashes($_POST['t_name_new'])) : ""), 32, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addsectionsubmit", $lang['add']), " &nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

}elseif (isset($_POST['psid']) || isset($_GET['psid'])) {

    if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {

        $psid = $_POST['psid'];

    }elseif (isset($_GET['psid']) && is_numeric($_GET['psid'])) {

        $psid = $_GET['psid'];

    }else {

        echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; {$lang['editsection']}</h1>\n";
        echo "<h2>{$lang['invalidfeedidorfeednotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (!$profile_section = profile_get_section($psid)) {

        echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; {$lang['editsection']}</h1>\n";
        echo "<h2>{$lang['invalidfeedidorfeednotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; {$profile_section['NAME']}</h1>\n";
    
    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success) && strlen(trim($add_success)) > 0) echo $add_success;
    if (isset($del_success) && strlen(trim($del_success)) > 0) echo $del_success;
    if (isset($edit_success) && strlen(trim($edit_success)) > 0) echo $edit_success;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_prof_sect.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('psid', $psid), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['sectionname']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['sectionname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? _htmlentities(_stripslashes($_POST['t_name_new'])) : _htmlentities($profile_section['NAME'])), 32, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";    
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("editfeedsubmit", $lang['save']), "&nbsp;", form_submit("viewitems[$psid]", $lang['viewitems']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

}else {

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success) && strlen(trim($add_success)) > 0) echo $add_success;
    if (isset($del_success) && strlen(trim($del_success)) > 0) echo $del_success;
    if (isset($edit_success) && strlen(trim($edit_success)) > 0) echo $edit_success;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_sections\" action=\"admin_prof_sect.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" width=\"25\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" colspan=\"2\">{$lang['sectionname']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"center\">{$lang['items']}</td>\n";
    echo "                </tr>\n";

    if ($profile_sections = profile_sections_get()) {

        $profile_index = 0;

        foreach ($profile_sections as $profile_section) {

            $profile_index++;

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"25\">", form_checkbox("delete_section[{$profile_section['PSID']}]", "Y", false), "</td>\n";

            if (sizeof($profile_sections) == 1) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" target=\"_blank\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" target=\"_blank\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";

            }elseif ($profile_index == sizeof($profile_sections)) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" target=\"_blank\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";

            }elseif ($profile_index > 1) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";

            }else {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" target=\"_blank\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
            }

            echo "                  <td valign=\"top\" align=\"left\" width=\"450\"><a href=\"admin_prof_sect.php?webtag=$webtag&amp;psid={$profile_section['PSID']}\">{$profile_section['NAME']}</td>\n";
            echo "                  <td valign=\"top\" align=\"center\">{$profile_section['ITEM_COUNT']}</td>\n";
            echo "                </tr>\n";
        }
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addsection", $lang['addnew']), "&nbsp;", form_submit("delete_sections", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
}

html_draw_bottom();

?>