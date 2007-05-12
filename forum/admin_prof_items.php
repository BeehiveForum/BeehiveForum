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

/* $Id: admin_prof_items.php,v 1.107 2007-05-12 13:39:05 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
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
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['sect_page']) && is_numeric($_GET['sect_page'])) {
    $sect_page = ($_GET['sect_page'] > 0) ? $_GET['sect_page'] : 1;
}elseif (isset($_POST['sect_page']) && is_numeric($_POST['sect_page'])) {
    $sect_page = ($_POST['sect_page'] > 0) ? $_POST['sect_page'] : 1;
}else {
    $sect_page = 1;
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

if (isset($_GET['psid']) && is_numeric($_GET['psid'])) {

    $psid = $_GET['psid'];

}elseif (isset($_POST['psid']) && is_numeric($_POST['psid'])) {

    $psid = $_POST['psid'];

}else {

    html_draw_top();
    html_error_msg($lang['noprofilesectionspecified'], 'admin_prof_sect.php', 'get', array('back' => $lang['back']));
    html_draw_bottom();
    exit;
}

if (isset($_GET['viewitems'])) {
    $viewitems = "yes";
}elseif (isset($_POST['viewitems'])) {
    $viewitems = "yes";
}

if (isset($_POST['delete'])) {

    if (isset($_POST['delete_item']) && is_array($_POST['delete_item'])) {

        foreach($_POST['delete_item'] as $piid => $delete_item) {

            if (($delete_item == "Y") && ($profile_item_name = profile_item_get_name($piid))) {

                if ($section_name = profile_section_get_name($_POST['psid'])) {

                    if (profile_item_delete($piid)) {

                        admin_add_log_entry(DELETE_PROFILE_ITEM, array($section_name, $profile_item_name));
                        $del_success = "<h2>{$lang['successfullyremovedselectedprofileitems']}</h2>\n";
                        unset($_POST['piid'], $_GET['piid'], $piid);

                    }else {

                        $error_html.= "<h2>{$lang['failedtoremoveprofileitems']}</h2>\n";
                    }               
                }
            }
        }
    }
}

if (isset($_POST['cancel'])) {

    unset($_POST['additem'], $_GET['additem'], $_POST['piid'], $_GET['piid']);
}

if (isset($_POST['back'])) {
    
    if (isset($viewitems)) {

        $redirect = "./admin_prof_sect.php?webtag=$webtag&page=$sect_page";
        header_redirect($redirect);

    }else {
    
        $redirect = "./admin_prof_sect.php?webtag=$webtag&psid=$psid&page=$sect_page";
        header_redirect($redirect);
    }
}

if (isset($_POST['additemsubmit'])) {

    $valid = true;

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {
        $t_new_name = trim(_stripslashes($_POST['t_name_new']));
    }else {
        $valid = false;
    }

    if (isset($_POST['t_type_new']) && is_numeric($_POST['t_type_new'])) {
        $t_type_new = $_POST['t_type_new'];
    }else {
        $valid = false;
    }

    if ($valid) {

        $new_piid = profile_item_create($psid, $t_new_name, $t_type_new);
        $t_section_name = profile_section_get_name($psid);
        admin_add_log_entry(ADDED_PROFILE_ITEM, array($t_section_name, $t_new_name));
    }

}elseif (isset($_POST['edititemsubmit'])) {

    $valid = true;

    if (isset($_POST['piid']) && is_numeric($_POST['piid'])) {
        $piid = $_POST['piid'];
    }else {
        $valid = false;
    }

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {
        $t_name_new = trim(_stripslashes($_POST['t_name_new']));
    }else {
        $valid = false;
    }

    if (isset($_POST['t_type_new']) && is_numeric($_POST['t_type_new'])) {
        $t_type_new = $_POST['t_type_new'];
    }else {
        $valid = false;
    }

    if (isset($_POST['t_section_new']) && is_numeric($_POST['t_section_new'])) {
        $t_section_new = $_POST['t_section_new'];
    }else {
        $valid = false;
    }

    if ($valid) {

        if (profile_item_update($piid, $t_section_new, $t_type_new, $t_name_new)) {

            $profile_item = profile_get_item($piid);

            if (($t_name_new != $profile_item['NAME']) || ($t_type_new != $profile_item['TYPE']) || ($t_section_new != $psid)) {
                
                $log_data = array($t_name_new, $profile_item['NAME'], $t_type_new, $profile_item['TYPE'], $t_section_new, $psid);
                admin_add_log_entry(CHANGE_PROFILE_ITEM, $log_data);
            }

            $edit_success = "<h2>{$lang['successfullyeditedprofilesection']}</h2>\n";
            unset($_POST['edititemsubmit'], $_POST['psid'], $_POST['piid'], $_POST['t_name_new'], $profile_item, $piid, $t_name_new, $t_type_new, $t_section_new);
        }
    }

}elseif (isset($_POST['additem'])) {

    $redirect = "./admin_prof_items.php?webtag=$webtag&psid=$psid&additem=true&sect_page=$sect_page";
    header_redirect($redirect);
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($piid) = array_keys($_POST['move_up']);
    profile_item_move_up($psid, $piid);
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($piid) = array_keys($_POST['move_down']);
    profile_item_move_down($psid, $piid);
}

if (isset($_GET['additem']) || isset($_POST['additem'])) {

    html_draw_top();

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; ", profile_section_get_name($psid), " &raquo; {$lang['addnewitem']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("psid", _htmlentities($psid)), "\n";
    echo "  ", form_input_hidden("sect_page", _htmlentities($sect_page)), "\n";
    
    if (isset($viewitems)) echo "  ", form_input_hidden("viewitems", "yes"), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" colspan=\"2\">{$lang['addnewitem']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['itemname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? _htmlentities(_stripslashes($_POST['t_name_new'])) : ""), 32, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['type']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_type_new", array($lang['largetextfield'], $lang['mediumtextfield'], $lang['smalltextfield'], $lang['multilinetextfield'], $lang['radiobuttons'], $lang['dropdown'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("additemsubmit", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\"><p>{$lang['fieldtypeexample1']}</p></td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\"><p>{$lang['fieldtypeexample2']}</p></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_GET['piid']) || isset($_POST['piid'])) {

    if (isset($_POST['piid']) && is_numeric($_POST['piid'])) {

        $piid = $_POST['piid'];

    }elseif (isset($_GET['piid']) && is_numeric($_GET['piid'])) {

        $piid = $_GET['piid'];

    }else {

        html_draw_top();
        html_error_msg($lang['invaliditemidoritemnotfound'], 'admin_prof_sect.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$profile_item = profile_get_item($piid)) {

        html_draw_top();
        html_error_msg($lang['invaliditemidoritemnotfound'], 'admin_prof_sect.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top();
    
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; ", profile_section_get_name($psid), " &raquo; {$lang['edititem']} &raquo; {$profile_item['NAME']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("psid", _htmlentities($psid)), "\n";
    echo "  ", form_input_hidden("piid", _htmlentities($piid)), "\n";
    echo "  ", form_input_hidden("sect_page", _htmlentities($sect_page)), "\n";
    echo "  ", form_input_hidden("delete_item[$piid]", "Y"), "\n";

    if (isset($viewitems)) echo "  ", form_input_hidden("viewitems", "yes"), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" colspan=\"2\">{$lang['edititem']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['itemname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name_new", (isset($_POST['t_name_new']) ? _htmlentities(_stripslashes($_POST['t_name_new'])) : _htmlentities($profile_item['NAME'])), 32, 64), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['type']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_type_new", array($lang['largetextfield'], $lang['mediumtextfield'], $lang['smalltextfield'], $lang['multilinetextfield'], $lang['radiobuttons'], $lang['dropdown']), (isset($_POST['t_type_new']) && is_numeric($_POST['t_type_new']) ? $_POST['t_type_new'] : $profile_item['TYPE'])), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\">{$lang['moveto']}</td>\n";
    echo "                        <td align=\"left\">", profile_section_dropdown($psid, "t_section_new"), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("edititemsubmit", $lang['save']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\"><p>{$lang['fieldtypeexample1']}</p></td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\"><p>{$lang['fieldtypeexample2']}</p></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    $item_types_array = array($lang['largetextfield'], $lang['mediumtextfield'], 
                              $lang['smalltextfield'], $lang['multilinetextfield'], 
                              $lang['radiobuttons'], $lang['dropdown']);

    html_draw_top();
    
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']} &raquo; ", profile_section_get_name($psid), " &raquo; {$lang['viewitems']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success) && strlen(trim($add_success)) > 0) echo $add_success;
    if (isset($del_success) && strlen(trim($del_success)) > 0) echo $del_success;
    if (isset($edit_success) && strlen(trim($edit_success)) > 0) echo $edit_success;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_sections\" action=\"admin_prof_items.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("psid", _htmlentities($psid)), "\n";
    echo "  ", form_input_hidden("sect_page", _htmlentities($sect_page)), "\n";

    if (isset($viewitems)) echo "  ", form_input_hidden("viewitems", "yes"), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" colspan=\"2\">{$lang['itemname']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['type']}</td>\n";
    echo "                </tr>\n";

    $profile_items = profile_items_get_by_page($psid, $start);

    if (sizeof($profile_items['profile_items_array']) > 0) {

        $profile_index = 0;

        foreach ($profile_items['profile_items_array'] as $profile_item) {

            $profile_index++;

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("delete_item[{$profile_item['PIID']}]", "Y", false), "</td>\n";

            if ($profile_items['profile_items_count'] == 1) {

                echo "                  <td valign=\"top\" align=\"left\" colspan=\"2\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid=$psid&amp;piid={$profile_item['PIID']}&amp;sect_page=$sect_page\">{$profile_item['NAME']}</a></td>\n";

            }elseif ($profile_index == $profile_items['profile_items_count']) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$profile_item['PIID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";
                echo "                  <td valign=\"top\" align=\"left\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid=$psid&amp;piid={$profile_item['PIID']}&amp;sect_page=$sect_page\">{$profile_item['NAME']}</a></td>\n";

            }elseif ($profile_index > 1) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$profile_item['PIID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down[{$profile_item['PIID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
                echo "                  <td valign=\"top\" align=\"left\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid=$psid&amp;piid={$profile_item['PIID']}&amp;sect_page=$sect_page\">{$profile_item['NAME']}</a></td>\n";

            }else {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down[{$profile_item['PIID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
                echo "                  <td valign=\"top\" align=\"left\"><a href=\"admin_prof_items.php?webtag=$webtag&amp;psid=$psid&amp;piid={$profile_item['PIID']}&amp;sect_page=$sect_page\">{$profile_item['NAME']}</a></td>\n";
            }
            
            echo "                  <td valign=\"top\" align=\"left\">{$item_types_array[$profile_item['TYPE']]}</td>\n";
            echo "                </tr>\n";
        }
    
    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"4\">{$lang['noexistingprofileitemsfound']}</td>\n";
        echo "                </tr>\n";

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
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $profile_items['profile_items_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("additem", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>