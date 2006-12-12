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

/* $Id: edit_profile.php,v 1.63 2006-12-12 21:42:26 decoyduck Exp $ */

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

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
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

$admin_edit = false;

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['profileuid'])) {

        if (is_numeric($_GET['profileuid'])) {

            $uid = $_GET['profileuid'];
            $admin_edit = true;

        }else {

            html_draw_top();
            echo "<h1>{$lang['error']}</h1>\n";
            echo "<h2>{$lang['nouserspecified']}</h2>\n";
            html_draw_bottom();
            exit;
        }

    }elseif (isset($_POST['profileuid'])) {

        if (is_numeric($_POST['profileuid'])) {

            $uid = $_POST['profileuid'];
            $admin_edit = true;

        } else {

            html_draw_top();
            echo "<h1>{$lang['error']}</h1>\n";
            echo "<h2>{$lang['nouserspecified']}</h2>\n";
            html_draw_bottom();
            exit;
        }
    
    }else {

        $uid = bh_session_get_value('UID');
    }

    if (isset($_POST['cancel'])) {

        header_redirect("./admin_user.php?webtag=$webtag&uid=$uid");
        exit;
    }

}else {

    if (bh_session_get_value('UID') == 0) {

        html_guest_error();
        exit;
    }

    $uid = bh_session_get_value('UID');
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != bh_session_get_value('UID'))) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

html_draw_top();

if ($admin_edit === true) {

    $user = user_get($uid);

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageuser']} &raquo; ", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), "</h1>\n";

}else {

    echo "<h1>{$lang['editprofile']}</h1>\n";
}

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

    if ($admin_edit === true) echo "<div align=\"center\">\n";

    echo "<form name=\"f_profile\" action=\"edit_profile.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";

    if ($admin_edit === true) echo "  ", form_input_hidden('profileuid', $uid), "\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">\n";
    echo "              <table class=\"box\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"posthead\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";

    $last_psid = false;

    foreach($profile_items_array as $profile_item) {

        $new = isset($profile_value['CHECK_PIID']) ? "N" : "Y";
        $profile_item['ENTRY'] = isset($profile_item['ENTRY']) ? _stripslashes($profile_item['ENTRY']) : "";

        if ($profile_item['PSID'] != $last_psid) {

            if ($last_psid !== false) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
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
                echo "            <td align=\"left\">\n";
                echo "              <table class=\"box\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"posthead\">\n";
                echo "                    <table class=\"posthead\" width=\"100%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" class=\"subhead\" colspan=\"4\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                      </tr>\n";

            }else {
                
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" class=\"subhead\" colspan=\"4\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                      </tr>\n";
            }
        }

        $last_psid = $profile_item['PSID'];

        if (($profile_item['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_item['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

            @list($field_name, $field_values) = explode(':', $profile_item['ITEM_NAME']);

            if (isset($field_name) && isset($field_values)) {

                $field_values = explode(';', $field_values);

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" valign=\"top\" width=\"175\">$field_name</td>\n";

                if ($profile_item['TYPE'] == PROFILE_ITEM_RADIO) {
                    echo "                        <td align=\"left\" valign=\"top\">", form_radio_array("t_entry[{$profile_item['PIID']}]", array_keys($field_values), $field_values, $profile_item['ENTRY']), "</td>\n";
                }else {
                    echo "                        <td align=\"left\" valign=\"top\">", form_dropdown_array("t_entry[{$profile_item['PIID']}]", array_keys($field_values), $field_values, $profile_item['ENTRY']), "</td>\n";
                }

                if ($admin_edit === false) {
                    echo "                        <td align=\"right\" valign=\"top\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", $lang['friendsonly'], (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == 1)), "&nbsp;&nbsp;</td>\n";
                }else {               
                    echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
                }

                echo "                      </tr>\n";
            }

        }elseif ($profile_item['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" valign=\"top\" width=\"175\">{$profile_item['ITEM_NAME']}</td>\n";
            echo "                        <td align=\"left\" valign=\"top\">", form_textarea("t_entry[{$profile_item['PIID']}]", $profile_item['ENTRY'], 4, 42), "</td>\n";

            if ($admin_edit === false) {
                echo "                        <td align=\"right\" valign=\"top\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", $lang['friendsonly'], (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == 1)), "&nbsp;&nbsp;</td>\n";
            }else {
                echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
            }

            echo "                      </tr>\n";

        }else {

            $text_width = array(40, 30, 10);

            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" valign=\"top\" width=\"175\">{$profile_item['ITEM_NAME']}</td>\n";
            echo "                        <td align=\"left\" valign=\"top\">", form_field("t_entry[{$profile_item['PIID']}]", $profile_item['ENTRY'], $text_width[$profile_item['TYPE']], 255), "</td>\n";

            if ($admin_edit === false) {
                echo "                        <td align=\"right\" valign=\"top\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", $lang['friendsonly'], (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == 1)), "&nbsp;&nbsp;</td>\n";
            }else {   
                echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
            }

            echo "                      </tr>\n";
        }
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">&nbsp;</td>\n";
    echo "          </tr>\n";

    if ($admin_edit === true) {

        echo "          <tr>\n";
        echo "            <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "          </tr>\n";

    }else {

        echo "          <tr>\n";
        echo "            <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
        echo "          </tr>\n";
    }

    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    if ($admin_edit === true) echo "</div>\n";

}else {

    echo "<p>{$lang['profilesnotsetup']}</p>";

}

html_draw_bottom();

?>