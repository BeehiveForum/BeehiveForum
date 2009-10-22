<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: admin_prof_sect.php,v 1.129 2009-10-22 20:36:06 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

// Array for holding error messages

$error_msg_array = array();

// Cancel button clicked.

if (isset($_POST['cancel'])) {

    header_redirect("admin_prof_sect.php?webtag=$webtag");
    exit;
}

if (isset($_POST['delete_sections'])) {

    $valid = true;

    if (isset($_POST['delete_section']) && is_array($_POST['delete_section'])) {

        foreach ($_POST['delete_section'] as $psid => $delete_section) {

            if ($valid && $delete_section == "Y" && $profile_name = profile_section_get_name($psid)) {

                if (profile_section_delete($psid)) {

                    admin_add_log_entry(DELETE_PROFILE_SECT, $profile_name);

                }else {

                    $error_msg_array[] = $lang['failedtoremoveprofilesections'];
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_prof_sect.php?webtag=$webtag&deleted=true");
            exit;
        }
    }

}elseif (isset($_POST['addsectionsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim(stripslashes_array($_POST['t_name_new']))) > 0) {
        $t_name_new = trim(stripslashes_array($_POST['t_name_new']));
    }else {
        $error_msg_array[] = $lang['mustsepecifyaprofilesectionname'];
        $valid = false;
    }

    if ($valid) {

        if (($new_psid = profile_section_create($t_name_new))) {

            header_redirect("admin_prof_sect.php?webtag=$webtag&added=true");
            exit;
        }
    }

}elseif (isset($_POST['editfeedsubmit'])) {

    $valid = true;

    if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {
        $psid = $_POST['psid'];
    }else {
        $error_msg_array[] = $lang['mustspecifyaprofilesectionid'];
        $valid = false;
    }

    if (isset($_POST['t_name_new']) && strlen(trim(stripslashes_array($_POST['t_name_new']))) > 0) {
        $t_new_name = trim(stripslashes_array($_POST['t_name_new']));
    }else {
        $error_msg_array[] = $lang['mustsepecifyaprofilesectionname'];
        $valid = false;
    }

    if ($valid) {

        if (profile_section_update($psid, $t_new_name)) {

            $t_section_name = profile_section_get_name($psid);

            if ($t_new_name != $t_section_name) {
                admin_add_log_entry(CHANGE_PROFILE_SECT, array($t_section_name, $t_new_name));
            }

            header_redirect("admin_prof_sect.php?webtag=$webtag&edited=true");
            exit;
        }
    }

}elseif (isset($_POST['addsection'])) {

    $redirect = "admin_prof_sect.php?webtag=$webtag&page=$page&addsection=true";
    header_redirect($redirect);
    exit;

}elseif (isset($_POST['viewitems']) && is_array($_POST['viewitems'])) {

    list($psid) = array_keys($_POST['viewitems']);
    $redirect = "admin_prof_items.php?webtag=$webtag&psid=$psid&sect_page=$page";
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

    html_draw_top("title={$lang['admin']} » {$lang['manageprofilesections']} » {$lang['addnewprofilesection']}");

    echo "<h1>{$lang['admin']} &raquo; {$lang['manageprofilesections']} &raquo; {$lang['addnewprofilesection']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_prof_sect.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('addsection', 'true'), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array(stripslashes_array($_POST['t_name_new'])) : ""), 32, 64), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addsectionsubmit", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_POST['psid']) || isset($_GET['psid'])) {

    if (isset($_POST['psid']) && is_numeric($_POST['psid'])) {

        $psid = $_POST['psid'];

    }elseif (isset($_GET['psid']) && is_numeric($_GET['psid'])) {

        $psid = $_GET['psid'];

    }else {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidprofilesectionid'], 'admin_prof_sect.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$profile_section = profile_get_section($psid)) {

        html_draw_top("title={$lang['error']}");
        html_error_msg($lang['invalidprofilesectionid'], 'admin_prof_sect.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top("title={$lang['admin']} » {$lang['manageprofilesections']} » ". word_filter_add_ob_tags(htmlentities_array($profile_section['NAME'])));

    echo "<h1>{$lang['admin']} &raquo; {$lang['manageprofilesections']} &raquo; ", word_filter_add_ob_tags(htmlentities_array($profile_section['NAME'])), "</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
        html_display_error_array($error_msg_array, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"thread_options\" action=\"admin_prof_sect.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('psid', htmlentities_array($psid)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
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
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? htmlentities_array(stripslashes_array($_POST['t_name_new'])) : htmlentities_array($profile_section['NAME'])), 32, 64), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("editfeedsubmit", $lang['save']), "&nbsp;", form_submit("viewitems[$psid]", $lang['viewitems']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top("title={$lang['admin']} » {$lang['manageprofilesections']}");

    $profile_sections = profile_sections_get_by_page($start);

    echo "<h1>{$lang['admin']} &raquo; {$lang['manageprofilesections']}</h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '500', 'center');

    }else if (isset($_GET['added'])) {

        html_display_success_msg($lang['successfullyaddedprofilesection'], '500', 'center');

    }else if (isset($_GET['edited'])) {

        html_display_success_msg($lang['successfullyeditedprofilesection'], '500', 'center');

    }else if (isset($_GET['deleted'])) {

        html_display_success_msg($lang['successfullyremovedselectedprofilesections'], '500', 'center');

    }else if (sizeof($profile_sections['profile_sections_array']) < 1) {

        html_display_warning_msg($lang['noprofilesectionsfound'], '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_sections\" action=\"admin_prof_sect.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('page', htmlentities_array($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
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

    if (sizeof($profile_sections['profile_sections_array']) > 0) {

        $profile_index = 0;

        foreach ($profile_sections['profile_sections_array'] as $profile_section) {

            $profile_index++;

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("delete_section[{$profile_section['PSID']}]", "Y", false), "</td>\n";

            if ($profile_sections['profile_sections_count'] == 1) {

                echo "                  <td valign=\"top\" align=\"left\" width=\"450\" colspan=\"2\"><a href=\"admin_prof_sect.php?webtag=$webtag&amp;page=$page&amp;psid={$profile_section['PSID']}\">", word_filter_add_ob_tags(htmlentities_array($profile_section['NAME'])), "</a></td>\n";

            }elseif ($profile_index == $profile_sections['profile_sections_count']) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";
                echo "                  <td valign=\"top\" align=\"left\" width=\"450\"><a href=\"admin_prof_sect.php?webtag=$webtag&amp;page=$page&amp;psid={$profile_section['PSID']}\">", word_filter_add_ob_tags(htmlentities_array($profile_section['NAME'])), "</a></td>\n";

            }elseif ($profile_index > 1) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
                echo "                  <td valign=\"top\" align=\"left\" width=\"450\"><a href=\"admin_prof_sect.php?webtag=$webtag&amp;page=$page&amp;psid={$profile_section['PSID']}\">", word_filter_add_ob_tags(htmlentities_array($profile_section['NAME'])), "</a></td>\n";

            }else {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
                echo "                  <td valign=\"top\" align=\"left\" width=\"450\"><a href=\"admin_prof_sect.php?webtag=$webtag&amp;page=$page&amp;psid={$profile_section['PSID']}\">", word_filter_add_ob_tags(htmlentities_array($profile_section['NAME'])), "</a></td>\n";
            }

            echo "                  <td valign=\"top\" align=\"center\" width=\"100\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid={$profile_section['PSID']}&amp;sect_page=$page&amp;viewitems=yes\">", htmlentities_array($profile_section['ITEM_COUNT']), "</a></td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_prof_sect.php?webtag=$webtag", $start, $profile_sections['profile_sections_count'], 10), "</td>\n";
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

    html_draw_bottom();
}

?>